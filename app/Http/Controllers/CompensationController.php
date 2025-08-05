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
        $query = Compensation::query();
        
        // Filter by status
        $status = $request->get('status', 'pending');
        $query->where('status', $status);
        
        // Search functionality
        $search = $request->get('search');
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('la_case_no', 'like', "%{$search}%")
                  ->orWhere('case_number', 'like', "%{$search}%")
                  ->orWhere('mouza_name', 'like', "%{$search}%")
                  ->orWhere('jl_no', 'like', "%{$search}%")
                  ->orWhere('sa_khatian_no', 'like', "%{$search}%")
                  ->orWhere('rs_khatian_no', 'like', "%{$search}%")
                  ->orWhere('plot_no', 'like', "%{$search}%")
                  ->orWhere('land_schedule_sa_plot_no', 'like', "%{$search}%")
                  ->orWhere('land_schedule_rs_plot_no', 'like', "%{$search}%");
                
                // Use MySQL JSON_SEARCH for applicant name search
                $q->orWhereRaw("JSON_SEARCH(applicants, 'one', ?, null, '$[*].name')", ["%{$search}%"]);
            });
        }
        
        $compensations = $query->orderBy('id', 'desc')->paginate(10);
        
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
        $validatedData = $request->validate([
            'case_number' => 'required|string|max:255',
            'case_date' => 'required|string|max:255',
            'sa_plot_no' => 'required_if:acquisition_record_basis,SA|nullable|string|max:255',
            'rs_plot_no' => 'required_if:acquisition_record_basis,RS|nullable|string|max:255',
            'applicants' => 'required|array|min:1',
            'applicants.*.name' => 'required|string|max:255',
            'applicants.*.father_name' => 'required|string|max:255',
            'applicants.*.address' => 'required|string|max:255',
            'applicants.*.nid' => 'required|string|max:20',
            'la_case_no' => 'required|string|max:255',
            'award_type' => 'required|string|in:জমি,জমি ও গাছপালা,অবকাঠামো',
            'land_award_serial_no' => 'nullable|string|max:255',
            'tree_award_serial_no' => 'nullable|string|max:255',
            'infrastructure_award_serial_no' => 'nullable|string|max:255',
            'acquisition_record_basis' => 'required|string|in:SA,RS',
            'plot_no' => 'required|string|max:255',
            'award_holder_names' => 'required|array|min:1',
            'award_holder_names.*.name' => 'required|string|max:255',
            'land_category' => 'nullable|array',
            'land_category.*.category_name' => 'required|string|max:255',
            'land_category.*.total_land' => 'required|string|max:255',
            'land_category.*.total_compensation' => 'required|string|max:255',
            'land_category.*.applicant_land' => 'required|string|max:255',
            'objector_details' => 'nullable|string',
            'is_applicant_in_award' => 'required|boolean',
            'source_tax_percentage' => 'required|string|max:255',
            'tree_compensation' => 'nullable|string|max:255',
            'infrastructure_compensation' => 'nullable|string|max:255',
            'mouza_name' => 'required|string|max:255',
            'jl_no' => 'required|string|max:255',
            'land_schedule_sa_plot_no' => 'required_if:acquisition_record_basis,SA|nullable|string|max:255',
            'land_schedule_rs_plot_no' => 'required_if:acquisition_record_basis,RS|nullable|string|max:255',
            'sa_khatian_no' => 'nullable|string|max:255',
            'rs_khatian_no' => 'required_if:acquisition_record_basis,RS|nullable|string|max:255',
            'ownership_details' => 'nullable|array',
            'ownership_details.sa_info' => 'nullable|array',
            'ownership_details.sa_info.sa_plot_no' => 'nullable|string|max:255',
            'ownership_details.sa_info.sa_khatian_no' => 'nullable|string|max:255',
            'ownership_details.sa_info.sa_total_land_in_plot' => 'nullable|string|max:255',
            'ownership_details.sa_info.sa_land_in_khatian' => 'nullable|string|max:255',
            'ownership_details.rs_info' => 'nullable|array',
            'ownership_details.rs_info.rs_plot_no' => 'nullable|string|max:255',
            'ownership_details.rs_info.rs_khatian_no' => 'nullable|string|max:255',
            'ownership_details.rs_info.rs_total_land_in_plot' => 'nullable|string|max:255',
            'ownership_details.rs_info.rs_land_in_khatian' => 'nullable|string|max:255',
            'ownership_details.sa_owners' => 'nullable|array',
            'ownership_details.sa_owners.*.name' => 'nullable|string|max:255',
            'ownership_details.rs_owners' => 'nullable|array',
            'ownership_details.rs_owners.*.name' => 'nullable|string|max:255',
            'ownership_details.deed_transfers' => 'nullable|array',
            'ownership_details.deed_transfers.*.donor_names' => 'required|array|min:1',
            'ownership_details.deed_transfers.*.donor_names.*.name' => 'required|string|max:255',
            'ownership_details.deed_transfers.*.recipient_names' => 'required|array|min:1',
            'ownership_details.deed_transfers.*.recipient_names.*.name' => 'required|string|max:255',
            'ownership_details.deed_transfers.*.deed_number' => 'nullable|string|max:255',
            'ownership_details.deed_transfers.*.deed_date' => 'nullable|string|max:255',
            'ownership_details.deed_transfers.*.sale_type' => 'nullable|string|max:255',
            'ownership_details.deed_transfers.*.plot_no' => 'nullable|string|max:255',
            'ownership_details.deed_transfers.*.sold_land_amount' => 'nullable|string|max:255',
            'ownership_details.deed_transfers.*.total_sotangsho' => 'nullable|string|max:255',
            'ownership_details.deed_transfers.*.total_shotok' => 'nullable|string|max:255',
            'ownership_details.deed_transfers.*.possession_mentioned' => 'nullable|in:yes,no',
            'ownership_details.deed_transfers.*.possession_plot_no' => 'nullable|string|max:255',
            'ownership_details.deed_transfers.*.possession_description' => 'nullable|string',
            'ownership_details.inheritance_records' => 'nullable|array',
            'ownership_details.inheritance_records.*.previous_owner_name' => 'nullable|string|max:255',
            'ownership_details.inheritance_records.*.death_date' => 'nullable|string|max:255',
            'ownership_details.inheritance_records.*.has_death_cert' => 'nullable|in:yes,no',
            'ownership_details.inheritance_records.*.heirship_certificate_info' => 'nullable|string',
            'ownership_details.rs_records' => 'nullable|array',
            'ownership_details.rs_records.*.plot_no' => 'nullable|string|max:255',
            'ownership_details.rs_records.*.khatian_no' => 'nullable|string|max:255',
            'ownership_details.rs_records.*.land_amount' => 'nullable|string|max:255',
            'ownership_details.rs_records.*.owner_names' => 'nullable|array',
            'ownership_details.rs_records.*.owner_names.*.name' => 'nullable|string|max:255',
            'ownership_details.rs_records.*.dp_khatian' => 'nullable|boolean',
            'ownership_details.transferItems' => 'nullable|array',
            'ownership_details.transferItems.*.type' => 'nullable|string|max:255',
            'ownership_details.transferItems.*.index' => 'nullable|integer',
            'ownership_details.currentStep' => 'nullable|string|max:255',
            'ownership_details.completedSteps' => 'nullable|array',
            'ownership_details.rs_record_disabled' => 'nullable|boolean',
            'ownership_details.applicant_info' => 'nullable|array',
            'ownership_details.applicant_info.applicant_name' => 'nullable|string|max:255',
            'ownership_details.applicant_info.kharij_case_no' => 'nullable|string|max:255',
            'ownership_details.applicant_info.kharij_plot_no' => 'nullable|string|max:255',
            'ownership_details.applicant_info.kharij_land_amount' => 'nullable|string|max:255',
            'ownership_details.applicant_info.kharij_date' => 'nullable|string|max:255',
            'ownership_details.applicant_info.kharij_details' => 'nullable|string',
            'tax_info' => 'nullable|array',
            'tax_info.english_year' => 'nullable|string|max:255',
            'tax_info.bangla_year' => 'nullable|string|max:255',
            'tax_info.holding_no' => 'nullable|string|max:255',
            'tax_info.paid_land_amount' => 'nullable|string|max:255',
            'additional_documents_info' => 'nullable|array',
            'additional_documents_info.selected_types' => 'nullable|array',
            'additional_documents_info.details' => 'nullable|array',
            'additional_documents_info.details.*' => 'nullable|string',
        ]);

        // Custom validation for additional_documents_info.details
        if (isset($validatedData['additional_documents_info']['selected_types']) && !empty($validatedData['additional_documents_info']['selected_types'])) {
            foreach ($validatedData['additional_documents_info']['selected_types'] as $type) {
                if (empty($validatedData['additional_documents_info']['details'][$type] ?? null)) {
                    Validator::make([], [])->after(function ($validator) use ($type) {
                        $validator->errors()->add('additional_documents_info.details.' . $type, __('The :type details field is required.', ['type' => $type]));
                    })->validate();
                }
            }
        }

        // Process Bengali dates before saving
        $validatedData = $this->processBengaliDates($validatedData);

        // Convert award_type string to array for database storage
        if (isset($validatedData['award_type'])) {
            $validatedData['award_type'] = [$validatedData['award_type']];
        }

        $compensation = Compensation::create($validatedData);

        return redirect()->route('compensation.preview', $compensation->id)->with('success', 'ক্ষতিপূরণ তথ্য সফলভাবে জমা দেওয়া হয়েছে।');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $compensation = Compensation::findOrFail($id);
        
        $validatedData = $request->validate([
            'case_number' => 'required|string|max:255',
            'case_date' => 'required|string|max:255',
            'sa_plot_no' => 'required_if:acquisition_record_basis,SA|nullable|string|max:255',
            'rs_plot_no' => 'required_if:acquisition_record_basis,RS|nullable|string|max:255',
            'applicants' => 'required|array|min:1',
            'applicants.*.name' => 'required|string|max:255',
            'applicants.*.father_name' => 'required|string|max:255',
            'applicants.*.address' => 'required|string|max:255',
            'applicants.*.nid' => 'required|string|max:20',
            'la_case_no' => 'required|string|max:255',
            'award_type' => 'required|string|in:জমি,জমি ও গাছপালা,অবকাঠামো',
            'land_award_serial_no' => 'nullable|string|max:255',
            'tree_award_serial_no' => 'nullable|string|max:255',
            'infrastructure_award_serial_no' => 'nullable|string|max:255',
            'acquisition_record_basis' => 'required|string|in:SA,RS',
            'plot_no' => 'required|string|max:255',
            'award_holder_names' => 'required|array|min:1',
            'award_holder_names.*.name' => 'required|string|max:255',
            'land_category' => 'nullable|array',
            'land_category.*.category_name' => 'required|string|max:255',
            'land_category.*.total_land' => 'required|string|max:255',
            'land_category.*.total_compensation' => 'required|string|max:255',
            'land_category.*.applicant_land' => 'required|string|max:255',
            'objector_details' => 'nullable|string',
            'is_applicant_in_award' => 'required|boolean',
            'source_tax_percentage' => 'required|string|max:255',
            'tree_compensation' => 'nullable|string|max:255',
            'infrastructure_compensation' => 'nullable|string|max:255',
            'mouza_name' => 'required|string|max:255',
            'jl_no' => 'required|string|max:255',
            'land_schedule_sa_plot_no' => 'required_if:acquisition_record_basis,SA|nullable|string|max:255',
            'land_schedule_rs_plot_no' => 'required_if:acquisition_record_basis,RS|nullable|string|max:255',
            'sa_khatian_no' => 'nullable|string|max:255',
            'rs_khatian_no' => 'required_if:acquisition_record_basis,RS|nullable|string|max:255',
            'ownership_details' => 'nullable|array',
            'ownership_details.sa_info' => 'nullable|array',
            'ownership_details.sa_info.sa_plot_no' => 'nullable|string|max:255',
            'ownership_details.sa_info.sa_khatian_no' => 'nullable|string|max:255',
            'ownership_details.sa_info.sa_total_land_in_plot' => 'nullable|string|max:255',
            'ownership_details.sa_info.sa_land_in_khatian' => 'nullable|string|max:255',
            'ownership_details.rs_info' => 'nullable|array',
            'ownership_details.rs_info.rs_plot_no' => 'nullable|string|max:255',
            'ownership_details.rs_info.rs_khatian_no' => 'nullable|string|max:255',
            'ownership_details.rs_info.rs_total_land_in_plot' => 'nullable|string|max:255',
            'ownership_details.rs_info.rs_land_in_khatian' => 'nullable|string|max:255',
            'ownership_details.sa_owners' => 'nullable|array',
            'ownership_details.sa_owners.*.name' => 'nullable|string|max:255',
            'ownership_details.rs_owners' => 'nullable|array',
            'ownership_details.rs_owners.*.name' => 'nullable|string|max:255',
            'ownership_details.deed_transfers' => 'nullable|array',
            'ownership_details.deed_transfers.*.donor_names' => 'required|array|min:1',
            'ownership_details.deed_transfers.*.donor_names.*.name' => 'required|string|max:255',
            'ownership_details.deed_transfers.*.recipient_names' => 'required|array|min:1',
            'ownership_details.deed_transfers.*.recipient_names.*.name' => 'required|string|max:255',
            'ownership_details.deed_transfers.*.deed_number' => 'nullable|string|max:255',
            'ownership_details.deed_transfers.*.deed_date' => 'nullable|string|max:255',
            'ownership_details.deed_transfers.*.sale_type' => 'nullable|string|max:255',
            'ownership_details.deed_transfers.*.plot_no' => 'nullable|string|max:255',
            'ownership_details.deed_transfers.*.sold_land_amount' => 'nullable|string|max:255',
            'ownership_details.deed_transfers.*.total_sotangsho' => 'nullable|string|max:255',
            'ownership_details.deed_transfers.*.total_shotok' => 'nullable|string|max:255',
            'ownership_details.deed_transfers.*.possession_mentioned' => 'nullable|in:yes,no',
            'ownership_details.deed_transfers.*.possession_plot_no' => 'nullable|string|max:255',
            'ownership_details.deed_transfers.*.possession_description' => 'nullable|string',
            'ownership_details.inheritance_records' => 'nullable|array',
            'ownership_details.inheritance_records.*.previous_owner_name' => 'nullable|string|max:255',
            'ownership_details.inheritance_records.*.death_date' => 'nullable|string|max:255',
            'ownership_details.inheritance_records.*.has_death_cert' => 'nullable|in:yes,no',
            'ownership_details.inheritance_records.*.heirship_certificate_info' => 'nullable|string',
            'ownership_details.rs_records' => 'nullable|array',
            'ownership_details.rs_records.*.plot_no' => 'nullable|string|max:255',
            'ownership_details.rs_records.*.khatian_no' => 'nullable|string|max:255',
            'ownership_details.rs_records.*.land_amount' => 'nullable|string|max:255',
            'ownership_details.rs_records.*.owner_names' => 'nullable|array',
            'ownership_details.rs_records.*.owner_names.*.name' => 'nullable|string|max:255',
            'ownership_details.rs_records.*.dp_khatian' => 'nullable|boolean',
            'ownership_details.transferItems' => 'nullable|array',
            'ownership_details.transferItems.*.type' => 'nullable|string|max:255',
            'ownership_details.transferItems.*.index' => 'nullable|integer',
            'ownership_details.currentStep' => 'nullable|string|max:255',
            'ownership_details.completedSteps' => 'nullable|array',
            'ownership_details.rs_record_disabled' => 'nullable|boolean',
            'ownership_details.applicant_info' => 'nullable|array',
            'ownership_details.applicant_info.applicant_name' => 'nullable|string|max:255',
            'ownership_details.applicant_info.kharij_case_no' => 'nullable|string|max:255',
            'ownership_details.applicant_info.kharij_plot_no' => 'nullable|string|max:255',
            'ownership_details.applicant_info.kharij_land_amount' => 'nullable|string|max:255',
            'ownership_details.applicant_info.kharij_date' => 'nullable|string|max:255',
            'ownership_details.applicant_info.kharij_details' => 'nullable|string',
            'tax_info' => 'nullable|array',
            'tax_info.english_year' => 'nullable|string|max:255',
            'tax_info.bangla_year' => 'nullable|string|max:255',
            'tax_info.holding_no' => 'nullable|string|max:255',
            'tax_info.paid_land_amount' => 'nullable|string|max:255',
            'additional_documents_info' => 'nullable|array',
            'additional_documents_info.selected_types' => 'nullable|array',
            'additional_documents_info.details' => 'nullable|array',
            'additional_documents_info.details.*' => 'nullable|string',
        ]);

        // Custom validation for additional_documents_info.details
        if (isset($validatedData['additional_documents_info']['selected_types']) && !empty($validatedData['additional_documents_info']['selected_types'])) {
            foreach ($validatedData['additional_documents_info']['selected_types'] as $type) {
                if (empty($validatedData['additional_documents_info']['details'][$type] ?? null)) {
                    Validator::make([], [])->after(function ($validator) use ($type) {
                        $validator->errors()->add('additional_documents_info.details.' . $type, __('The :type details field is required.', ['type' => $type]));
                    })->validate();
                }
            }
        }

        // Process Bengali dates before saving
        $validatedData = $this->processBengaliDates($validatedData);

        // Convert award_type string to array for database storage
        if (isset($validatedData['award_type'])) {
            $validatedData['award_type'] = [$validatedData['award_type']];
        }

        $compensation->update($validatedData);

        return redirect()->route('compensation.preview', $compensation->id)->with('success', 'ক্ষতিপূরণ তথ্য সফলভাবে আপডেট করা হয়েছে।');
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
            
            // Update only the kanungo_opinion field
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
            'order_signature_date' => $compensation->order_signature_date,
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
                'order_signature_date' => 'required|date',
                'signing_officer_name' => 'required|string|max:255',
            ]);
            
            // Process Bengali dates before saving
            $validatedData = $this->processBengaliDates($validatedData);
            
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
}