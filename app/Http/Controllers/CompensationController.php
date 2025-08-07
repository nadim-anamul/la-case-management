<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Compensation;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Traits\BengaliDateTrait;

class CompensationController extends Controller
{
    use BengaliDateTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'pending');
        $search = $request->get('search');
        
        $compensations = Compensation::query()
            ->byStatus($status)
            ->when($search, function($query) use ($search) {
                return $query->search($search);
            })
            ->orderBy('id', 'desc')
            ->paginate(10);
        
        return view('compensation_list', compact('compensations', 'status', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('compensation_form');
    }

    /**
     * Display the specified resource.
     */
    public function preview($id)
    {
        $compensation = Compensation::findOrFail($id);
        return view('compensation_preview', compact('compensation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $compensation = Compensation::findOrFail($id);
        return view('compensation_form', compact('compensation'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $this->validateCompensationData($request);
        $validatedData = $this->processCompensationData($validatedData);
        
        $compensation = Compensation::create($validatedData);

        return redirect()->route('compensation.preview', $compensation->id)
            ->with('success', 'ক্ষতিপূরণ তথ্য সফলভাবে জমা দেওয়া হয়েছে।');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $compensation = Compensation::findOrFail($id);
        
        $validatedData = $this->validateCompensationData($request);
        $validatedData = $this->processCompensationData($validatedData);

        $compensation->update($validatedData);

        return redirect()->route('compensation.preview', $compensation->id)
            ->with('success', 'ক্ষতিপূরণ তথ্য সফলভাবে আপডেট করা হয়েছে।');
    }

    /**
     * Get kanungo opinion for a compensation record
     */
    public function getKanungoOpinion($id)
    {
        $compensation = Compensation::findOrFail($id);
        
        return response()->json([
            'kanungo_opinion' => $compensation->kanungo_opinion
        ]);
    }

    /**
     * Update kanungo opinion for a compensation record
     */
    public function updateKanungoOpinion(Request $request, $id)
    {
        try {
            $compensation = Compensation::findOrFail($id);
            
            $validatedData = $request->validate([
                'kanungo_opinion' => 'required|array',
                'kanungo_opinion.has_ownership_continuity' => 'required|in:yes,no',
                'kanungo_opinion.opinion_details' => 'nullable|string',
            ]);
            
            $compensation->update([
                'kanungo_opinion' => $validatedData['kanungo_opinion']
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'কানুনগো/সার্ভেয়ারের মতামত সফলভাবে আপডেট করা হয়েছে।'
            ]);
        } catch (\Exception $e) {
            \Log::error('Kanungo opinion update error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'কিছু সমস্যা হয়েছে: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get order data for a compensation record
     */
    public function getOrder($id)
    {
        $compensation = Compensation::findOrFail($id);
        return response()->json([
            'order_signature_date' => $compensation->order_signature_date_bengali,
            'signing_officer_name' => $compensation->signing_officer_name
        ]);
    }

    /**
     * Update order data for a compensation record
     */
    public function updateOrder(Request $request, $id)
    {
        try {
            $compensation = Compensation::findOrFail($id);
            
            $validatedData = $request->validate([
                'order_signature_date' => 'required|string',
                'signing_officer_name' => 'required|string|max:255',
            ]);
            
            // Process Bengali dates before saving
            $validatedData = $this->processBengaliDates($validatedData);
            
            // Validate the converted date
            if (!$validatedData['order_signature_date']) {
                return response()->json([
                    'success' => false,
                    'message' => 'কিছু সমস্যা হয়েছে: The order signature date field must be a valid date.'
                ], 422);
            }
            
            try {
                \Carbon\Carbon::parse($validatedData['order_signature_date']);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'কিছু সমস্যা হয়েছে: The order signature date field must be a valid date.'
                ], 422);
            }
            
            // Update only the order fields
            $compensation->update([
                'order_signature_date' => $validatedData['order_signature_date'],
                'signing_officer_name' => $validatedData['signing_officer_name'],
                'status' => 'done'
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'আদেশ সফলভাবে নিষ্পত্তিকৃত হয়েছে।'
            ]);
        } catch (\Exception $e) {
            \Log::error('Order update error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'কিছু সমস্যা হয়েছে: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Validate compensation data
     */
    private function validateCompensationData(Request $request)
    {
        return $request->validate([
            // Basic Information
            'case_number' => 'required|string|max:255',
            'case_date' => 'required|string|max:255',
            'sa_plot_no' => 'required_if:acquisition_record_basis,SA|nullable|string|max:255',
            'rs_plot_no' => 'required_if:acquisition_record_basis,RS|nullable|string|max:255',
            
            // Applicants
            'applicants' => 'required|array|min:1',
            'applicants.*.name' => 'required|string|max:255',
            'applicants.*.father_name' => 'required|string|max:255',
            'applicants.*.address' => 'required|string|max:255',
            'applicants.*.nid' => 'required|string|max:20',
            
            // Award Information
            'la_case_no' => 'required|string|max:255',
            'award_type' => 'required|string|in:জমি,জমি ও গাছপালা,অবকাঠামো',
            'land_award_serial_no' => 'nullable|string|max:255',
            'tree_award_serial_no' => 'nullable|string|max:255',
            'infrastructure_award_serial_no' => 'nullable|string|max:255',
            'acquisition_record_basis' => 'required|string|in:SA,RS',
            'plot_no' => 'required|string|max:255',
            'award_holder_names' => 'required|array|min:1',
            'award_holder_names.*.name' => 'required|string|max:255',
            
            // Land Category
            'land_category' => 'nullable|array',
            'land_category.*.category_name' => 'required|string|max:255',
            'land_category.*.total_land' => 'required|string|max:255',
            'land_category.*.total_compensation' => 'required|string|max:255',
            'land_category.*.applicant_land' => 'required|string|max:255',
            
            // Additional Information
            'objector_details' => 'nullable|string',
            'is_applicant_in_award' => 'required|boolean',
            'source_tax_percentage' => 'required|string|max:255',
            'tree_compensation' => 'nullable|string|max:255',
            'infrastructure_compensation' => 'nullable|string|max:255',
            'mouza_name' => 'required|string|max:255',
            'jl_no' => 'required|string|max:255',
            
            // Land Schedule
            'land_schedule_sa_plot_no' => 'required_if:acquisition_record_basis,SA|nullable|string|max:255',
            'land_schedule_rs_plot_no' => 'required_if:acquisition_record_basis,RS|nullable|string|max:255',
            'sa_khatian_no' => 'nullable|string|max:255',
            'rs_khatian_no' => 'required_if:acquisition_record_basis,RS|nullable|string|max:255',
            
            // Ownership Details (simplified validation)
            'ownership_details' => 'nullable|array',
            
            // Tax Information
            'tax_info' => 'nullable|array',
            'tax_info.english_year' => 'nullable|string|max:255',
            'tax_info.bangla_year' => 'nullable|string|max:255',
            'tax_info.holding_no' => 'nullable|string|max:255',
            'tax_info.paid_land_amount' => 'nullable|string|max:255',
            
            // Additional Documents
            'additional_documents_info' => 'nullable|array',
            'additional_documents_info.selected_types' => 'nullable|array',
            'additional_documents_info.details' => 'nullable|array',
            'additional_documents_info.details.*' => 'nullable|string',
        ]);
    }

    /**
     * Process compensation data before saving
     */
    private function processCompensationData(array $data)
    {
        // Process Bengali dates
        $data = $this->processBengaliDates($data);

        // Convert award_type string to array for database storage
        if (isset($data['award_type'])) {
            $data['award_type'] = [$data['award_type']];
        }

        // Process ownership details if present
        if (isset($data['ownership_details'])) {
            $data['ownership_details'] = $this->processOwnershipDetails($data['ownership_details']);
        }

        // Process additional documents validation
        if (isset($data['additional_documents_info']['selected_types']) && 
            !empty($data['additional_documents_info']['selected_types'])) {
            $this->validateAdditionalDocuments($data['additional_documents_info']);
        }

        return $data;
    }

    /**
     * Process ownership details
     */
    private function processOwnershipDetails(array $ownershipDetails)
    {
        // Convert checkbox values to boolean for rs_records
        if (isset($ownershipDetails['rs_records'])) {
            foreach ($ownershipDetails['rs_records'] as &$rsRecord) {
                if (isset($rsRecord['dp_khatian'])) {
                    $rsRecord['dp_khatian'] = in_array($rsRecord['dp_khatian'], ['on', '1', 'true'], true);
                }
            }
        }
        
        // Convert rs_info dp_khatian checkbox value to boolean
        if (isset($ownershipDetails['rs_info']['dp_khatian'])) {
            $ownershipDetails['rs_info']['dp_khatian'] = in_array($ownershipDetails['rs_info']['dp_khatian'], ['on', '1', 'true'], true);
        }
        
        // Process story sequence if it's a JSON string
        if (isset($ownershipDetails['storySequence']) && is_string($ownershipDetails['storySequence'])) {
            $storySequence = json_decode($ownershipDetails['storySequence'], true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $ownershipDetails['storySequence'] = $storySequence;
            } else {
                $ownershipDetails['storySequence'] = [];
            }
        }
        
        // Process completed steps if it's a JSON string
        if (isset($ownershipDetails['completedSteps']) && is_string($ownershipDetails['completedSteps'])) {
            $completedSteps = json_decode($ownershipDetails['completedSteps'], true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $ownershipDetails['completedSteps'] = $completedSteps;
            } else {
                $ownershipDetails['completedSteps'] = [];
            }
        }
        
        // Convert rs_record_disabled to boolean
        if (isset($ownershipDetails['rs_record_disabled'])) {
            $ownershipDetails['rs_record_disabled'] = in_array($ownershipDetails['rs_record_disabled'], ['on', '1', 'true'], true);
        }

        return $ownershipDetails;
    }

    /**
     * Validate additional documents
     */
    private function validateAdditionalDocuments(array $additionalDocumentsInfo)
    {
        foreach ($additionalDocumentsInfo['selected_types'] as $type) {
            if (empty($additionalDocumentsInfo['details'][$type] ?? null)) {
                Validator::make([], [])->after(function ($validator) use ($type) {
                    $validator->errors()->add('additional_documents_info.details.' . $type, __('The :type details field is required.', ['type' => $type]));
                })->validate();
            }
        }
    }
}