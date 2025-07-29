<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Compensation;
use Illuminate\Support\Facades\Validator;

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
            'case_date' => 'required|date',
            'sa_plot_no' => 'required_if:acquisition_record_basis,SA|nullable|string|max:255',
            'rs_plot_no' => 'required_if:acquisition_record_basis,RS|nullable|string|max:255',
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
            'sa_khatian_no' => 'required_if:acquisition_record_basis,SA|nullable|string|max:255',
            'rs_khatian_no' => 'required_if:acquisition_record_basis,RS|nullable|string|max:255',
            'former_plot_no' => 'required|string|max:255',
            'current_plot_no' => 'required|string|max:255',
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
            'ownership_details.deed_transfers.*.donor_name' => 'nullable|string|max:255',
            'ownership_details.deed_transfers.*.recipient_name' => 'nullable|string|max:255',
            'ownership_details.deed_transfers.*.deed_number' => 'nullable|string|max:255',
            'ownership_details.deed_transfers.*.deed_date' => 'nullable|date',
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
            'ownership_details.inheritance_records.*.death_date' => 'nullable|date',
            'ownership_details.inheritance_records.*.inheritance_type' => 'nullable|string|max:255',
            'ownership_details.inheritance_records.*.has_death_cert' => 'nullable|in:yes,no',
            'ownership_details.inheritance_records.*.heirship_certificate_info' => 'nullable|string',
            'ownership_details.rs_records' => 'nullable|array',
            'ownership_details.rs_records.*.plot_no' => 'nullable|string|max:255',
            'ownership_details.rs_records.*.khatian_no' => 'nullable|string|max:255',
            'ownership_details.rs_records.*.land_amount' => 'nullable|string|max:255',
            'ownership_details.rs_records.*.owner_name' => 'nullable|string|max:255',
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
            'ownership_details.applicant_info.kharij_date' => 'nullable|date',
            'ownership_details.applicant_info.kharij_details' => 'nullable|string',
            'tax_info' => 'nullable|array',
            'tax_info.english_year' => 'nullable|string|max:255',
            'tax_info.bangla_year' => 'nullable|string|max:255',
            'additional_documents_info' => 'required|array',
            'additional_documents_info.selected_types' => 'required|array|min:1',
            'additional_documents_info.details' => 'required|array',
            'additional_documents_info.details.*' => 'nullable|string',
            'kanungo_opinion' => 'required|array',
            'kanungo_opinion.has_ownership_continuity' => 'required|in:yes,no',
            'kanungo_opinion.opinion_details' => 'nullable|string',
        ]);

        // Custom validation for additional_documents_info.details
        if (isset($validatedData['additional_documents_info']['selected_types'])) {
            foreach ($validatedData['additional_documents_info']['selected_types'] as $type) {
                if (empty($validatedData['additional_documents_info']['details'][$type] ?? null)) {
                    Validator::make([], [])->after(function ($validator) use ($type) {
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $compensation = Compensation::findOrFail($id);
        
        $validatedData = $request->validate([
            'case_number' => 'required|string|max:255',
            'case_date' => 'required|date',
            'sa_plot_no' => 'required_if:acquisition_record_basis,SA|nullable|string|max:255',
            'rs_plot_no' => 'required_if:acquisition_record_basis,RS|nullable|string|max:255',
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
            'sa_khatian_no' => 'required_if:acquisition_record_basis,SA|nullable|string|max:255',
            'rs_khatian_no' => 'required_if:acquisition_record_basis,RS|nullable|string|max:255',
            'former_plot_no' => 'required|string|max:255',
            'current_plot_no' => 'required|string|max:255',
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
            'ownership_details.deed_transfers.*.donor_name' => 'nullable|string|max:255',
            'ownership_details.deed_transfers.*.recipient_name' => 'nullable|string|max:255',
            'ownership_details.deed_transfers.*.deed_number' => 'nullable|string|max:255',
            'ownership_details.deed_transfers.*.deed_date' => 'nullable|date',
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
            'ownership_details.inheritance_records.*.death_date' => 'nullable|date',
            'ownership_details.inheritance_records.*.inheritance_type' => 'nullable|string|max:255',
            'ownership_details.inheritance_records.*.has_death_cert' => 'nullable|in:yes,no',
            'ownership_details.inheritance_records.*.heirship_certificate_info' => 'nullable|string',
            'ownership_details.rs_records' => 'nullable|array',
            'ownership_details.rs_records.*.plot_no' => 'nullable|string|max:255',
            'ownership_details.rs_records.*.khatian_no' => 'nullable|string|max:255',
            'ownership_details.rs_records.*.land_amount' => 'nullable|string|max:255',
            'ownership_details.rs_records.*.owner_name' => 'nullable|string|max:255',
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
            'ownership_details.applicant_info.kharij_date' => 'nullable|date',
            'ownership_details.applicant_info.kharij_details' => 'nullable|string',
            'tax_info' => 'nullable|array',
            'tax_info.english_year' => 'nullable|string|max:255',
            'tax_info.bangla_year' => 'nullable|string|max:255',
            'additional_documents_info' => 'required|array',
            'additional_documents_info.selected_types' => 'required|array|min:1',
            'additional_documents_info.details' => 'required|array',
            'additional_documents_info.details.*' => 'nullable|string',
            'kanungo_opinion' => 'required|array',
            'kanungo_opinion.has_ownership_continuity' => 'required|in:yes,no',
            'kanungo_opinion.opinion_details' => 'nullable|string',
        ]);

        // Custom validation for additional_documents_info.details
        if (isset($validatedData['additional_documents_info']['selected_types'])) {
            foreach ($validatedData['additional_documents_info']['selected_types'] as $type) {
                if (empty($validatedData['additional_documents_info']['details'][$type] ?? null)) {
                    Validator::make([], [])->after(function ($validator) use ($type) {
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