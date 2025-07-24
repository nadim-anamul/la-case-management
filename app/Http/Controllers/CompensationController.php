<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Compensation;

class CompensationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $compensations = Compensation::orderBy('id', 'desc')->paginate(10);
        return view('compensation_list', compact('compensations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('compensation_form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'case_number' => 'required|string|max:255',
            'case_date' => 'required|date',
            'sa_plot_no' => 'nullable|string|max:255',
            'rs_plot_no' => 'nullable|string|max:255',
            'applicants' => 'required|array|min:1',
            'applicants.*.name' => 'required|string|max:255',
            'applicants.*.father_name' => 'required|string|max:255',
            'applicants.*.address' => 'required|string|max:255',
            'applicants.*.nid' => 'required|string|max:20',
            'la_case_no' => 'required|string|max:255',
            'award_type' => 'nullable|array',
            'award_serial_no' => 'required|string|max:255',
            'acquisition_record_basis' => 'required|string|in:SA,RS',
            'plot_no' => 'required|string|max:255',
            'award_holder_name' => 'required|string|max:255',
            'objector_details' => 'nullable|string',
            'is_applicant_in_award' => 'required|boolean',
            'total_acquired_land' => 'required|string|max:255',
            'total_compensation' => 'required|string|max:255',
            'applicant_acquired_land' => 'required|string|max:255',
            'mouza_name' => 'required|string|max:255',
            'jl_no' => 'required|string|max:255',
            'sa_khatian_no' => 'required_if:acquisition_record_basis,SA|string|max:255',
            'rs_khatian_no' => 'required_if:acquisition_record_basis,RS|string|max:255',
            'former_plot_no' => 'required|string|max:255',
            'current_plot_no' => 'required|string|max:255',
            'ownership_details' => 'required|array',
            'ownership_details.is_applicant_sa_owner' => 'required_if:acquisition_record_basis,SA|in:yes,no',
            'ownership_details.sa_owner_name' => 'nullable|string|max:255',
            'ownership_details.sa_plot_no' => 'nullable|string|max:255',
            'ownership_details.previous_owner_name' => 'nullable|string|max:255',
            'ownership_details.sa_khatian_no' => 'nullable|string|max:255',
            'ownership_details.sa_total_land_in_plot' => 'nullable|string|max:255',
            'ownership_details.sa_land_in_khatian' => 'nullable|string|max:255',
            'ownership_details.ownership_type' => 'required|in:deed,inheritance',
            'ownership_details.deed_transfers' => 'required_if:ownership_details.ownership_type,deed|array',
            'ownership_details.deed_transfers.*.donor_name' => 'required_if:ownership_details.ownership_type,deed|string|max:255',
            'ownership_details.deed_transfers.*.recipient_name' => 'required_if:ownership_details.ownership_type,deed|string|max:255',
            'ownership_details.deed_transfers.*.deed_number' => 'required_if:ownership_details.ownership_type,deed|string|max:255',
            'ownership_details.deed_transfers.*.deed_date' => 'required_if:ownership_details.ownership_type,deed|date',
            'ownership_details.inheritance_records' => 'required_if:ownership_details.ownership_type,inheritance|array',
            'ownership_details.inheritance_records.*.previous_owner_name' => 'required_if:ownership_details.ownership_type,inheritance|string|max:255',
            'ownership_details.inheritance_records.*.death_date' => 'required_if:ownership_details.ownership_type,inheritance|date',
            'ownership_details.inheritance_records.*.inheritance_type' => 'required_if:ownership_details.ownership_type,inheritance|string|max:255',
            'ownership_details.sa_owners' => 'nullable|array',
            'ownership_details.sa_owners.*.name' => 'nullable|string|max:255',
            'ownership_details.rs_owners' => 'nullable|array',
            'ownership_details.rs_owners.*.name' => 'nullable|string|max:255',
            'mutation_info' => 'required|array',
            'mutation_info.records' => 'nullable|array',
            'mutation_info.records.*.khatian_no' => 'nullable|string|max:255',
            'mutation_info.records.*.case_no' => 'nullable|string|max:255',
            'mutation_info.records.*.plot_no' => 'nullable|string|max:255',
            'mutation_info.records.*.land_amount' => 'nullable|string|max:255',
            'tax_info' => 'required|array',
            'tax_info.paid_until' => 'nullable|string|max:255',
            'additional_documents_info' => 'required|array',
            'additional_documents_info.selected_types' => 'required|array|min:1',
            'additional_documents_info.details' => 'required|array',
            'additional_documents_info.details.*' => 'nullable|string',
            'kanungo_opinion' => 'required|array',
            'kanungo_opinion.ownership_continuity' => 'required|in:yes,no',
            'kanungo_opinion.opinion_details' => 'nullable|string',
        ]);

        // Custom validation for additional_documents_info.details
        if (isset($validatedData['additional_documents_info']['selected_types'])) {
            foreach ($validatedData['additional_documents_info']['selected_types'] as $type) {
                if (empty($validatedData['additional_documents_info']['details'][$type] ?? null)) {
                    \Validator::make([], [])->after(function ($validator) use ($type) {
                        $validator->errors()->add('additional_documents_info.details.' . $type, __('The :type details field is required.', ['type' => $type]));
                    })->validate();
                }
            }
        }

        // Extract is_applicant_sa_owner from ownership_details and set it as a separate field
        $isApplicantSaOwner = $validatedData['ownership_details']['is_applicant_sa_owner'] ?? null;
        $validatedData['is_applicant_sa_owner'] = $isApplicantSaOwner === 'yes' ? true : false;

        Compensation::create($validatedData);

        return redirect()->route('compensation.index')->with('success', 'ক্ষতিপূরণ তথ্য সফলভাবে জমা দেওয়া হয়েছে।');
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $compensation = Compensation::findOrFail($id);
        
        $validatedData = $request->validate([
            'case_number' => 'required|string|max:255',
            'case_date' => 'required|date',
            'sa_plot_no' => 'nullable|string|max:255',
            'rs_plot_no' => 'nullable|string|max:255',
            'applicants' => 'required|array|min:1',
            'applicants.*.name' => 'required|string|max:255',
            'applicants.*.father_name' => 'required|string|max:255',
            'applicants.*.address' => 'required|string|max:255',
            'applicants.*.nid' => 'required|string|max:20',
            'la_case_no' => 'required|string|max:255',
            'award_type' => 'nullable|array',
            'award_serial_no' => 'required|string|max:255',
            'acquisition_record_basis' => 'required|string|in:SA,RS',
            'plot_no' => 'required|string|max:255',
            'award_holder_name' => 'required|string|max:255',
            'objector_details' => 'nullable|string',
            'is_applicant_in_award' => 'required|boolean',
            'total_acquired_land' => 'required|string|max:255',
            'total_compensation' => 'required|string|max:255',
            'applicant_acquired_land' => 'required|string|max:255',
            'mouza_name' => 'required|string|max:255',
            'jl_no' => 'required|string|max:255',
            'sa_khatian_no' => 'required_if:acquisition_record_basis,SA|string|max:255',
            'rs_khatian_no' => 'required_if:acquisition_record_basis,RS|string|max:255',
            'former_plot_no' => 'required|string|max:255',
            'current_plot_no' => 'required|string|max:255',
            'ownership_details' => 'required|array',
            'ownership_details.is_applicant_sa_owner' => 'required_if:acquisition_record_basis,SA|in:yes,no',
            'ownership_details.sa_owner_name' => 'nullable|string|max:255',
            'ownership_details.sa_plot_no' => 'nullable|string|max:255',
            'ownership_details.previous_owner_name' => 'nullable|string|max:255',
            'ownership_details.sa_khatian_no' => 'nullable|string|max:255',
            'ownership_details.sa_total_land_in_plot' => 'nullable|string|max:255',
            'ownership_details.sa_land_in_khatian' => 'nullable|string|max:255',
            'ownership_details.ownership_type' => 'required|in:deed,inheritance',
            'ownership_details.deed_transfers' => 'required_if:ownership_details.ownership_type,deed|array',
            'ownership_details.deed_transfers.*.donor_name' => 'required_if:ownership_details.ownership_type,deed|string|max:255',
            'ownership_details.deed_transfers.*.recipient_name' => 'required_if:ownership_details.ownership_type,deed|string|max:255',
            'ownership_details.deed_transfers.*.deed_number' => 'required_if:ownership_details.ownership_type,deed|string|max:255',
            'ownership_details.deed_transfers.*.deed_date' => 'required_if:ownership_details.ownership_type,deed|date',
            'ownership_details.inheritance_records' => 'required_if:ownership_details.ownership_type,inheritance|array',
            'ownership_details.inheritance_records.*.previous_owner_name' => 'required_if:ownership_details.ownership_type,inheritance|string|max:255',
            'ownership_details.inheritance_records.*.death_date' => 'required_if:ownership_details.ownership_type,inheritance|date',
            'ownership_details.inheritance_records.*.inheritance_type' => 'required_if:ownership_details.ownership_type,inheritance|string|max:255',
            'ownership_details.sa_owners' => 'nullable|array',
            'ownership_details.sa_owners.*.name' => 'nullable|string|max:255',
            'ownership_details.rs_owners' => 'nullable|array',
            'ownership_details.rs_owners.*.name' => 'nullable|string|max:255',
            'mutation_info' => 'required|array',
            'mutation_info.records' => 'nullable|array',
            'mutation_info.records.*.khatian_no' => 'nullable|string|max:255',
            'mutation_info.records.*.case_no' => 'nullable|string|max:255',
            'mutation_info.records.*.plot_no' => 'nullable|string|max:255',
            'mutation_info.records.*.land_amount' => 'nullable|string|max:255',
            'tax_info' => 'required|array',
            'tax_info.paid_until' => 'nullable|string|max:255',
            'additional_documents_info' => 'required|array',
            'additional_documents_info.selected_types' => 'required|array|min:1',
            'additional_documents_info.details' => 'required|array',
            'additional_documents_info.details.*' => 'nullable|string',
            'kanungo_opinion' => 'required|array',
            'kanungo_opinion.ownership_continuity' => 'required|in:yes,no',
            'kanungo_opinion.opinion_details' => 'nullable|string',
        ]);

        // Custom validation for additional_documents_info.details
        if (isset($validatedData['additional_documents_info']['selected_types'])) {
            foreach ($validatedData['additional_documents_info']['selected_types'] as $type) {
                if (empty($validatedData['additional_documents_info']['details'][$type] ?? null)) {
                    \Validator::make([], [])->after(function ($validator) use ($type) {
                        $validator->errors()->add('additional_documents_info.details.' . $type, __('The :type details field is required.', ['type' => $type]));
                    })->validate();
                }
            }
        }

        // Extract is_applicant_sa_owner from ownership_details and set it as a separate field
        $isApplicantSaOwner = $validatedData['ownership_details']['is_applicant_sa_owner'] ?? null;
        $validatedData['is_applicant_sa_owner'] = $isApplicantSaOwner === 'yes' ? true : false;

        $compensation->update($validatedData);

        return redirect()->route('compensation.index')->with('success', 'ক্ষতিপূরণ তথ্য সফলভাবে আপডেট করা হয়েছে।');
    }
}