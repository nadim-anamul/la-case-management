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
            'applicants' => 'required|array|min:1',
            'applicants.*.name' => 'required|string|max:255',
            'applicants.*.father_name' => 'required|string|max:255',
            'applicants.*.address' => 'required|string|max:255',
            'applicants.*.nid' => 'required|string|max:20',
            'la_case_no' => 'required|string|max:255',
            'award_type' => 'nullable|array',
            'award_serial_no' => 'required|string|max:255',
            'acquisition_record_basis' => 'required|string|max:255',
            'plot_no' => 'required|string|max:255',
            'award_holder_name' => 'required|string|max:255',
            'objector_details' => 'nullable|string',
            'is_applicant_in_award' => 'required|boolean',
            'total_acquired_land' => 'required|string|max:255',
            'total_compensation' => 'required|string|max:255',
            'applicant_acquired_land' => 'required|string|max:255',
            'mouza_name' => 'required|string|max:255',
            'jl_no' => 'required|string|max:255',
            'sa_khatian_no' => 'required|string|max:255',
            'former_plot_no' => 'required|string|max:255',
            'rs_khatian_no' => 'required|string|max:255',
            'current_plot_no' => 'required|string|max:255',
            'ownership_details' => 'required|array',
            'ownership_details.is_applicant_sa_owner' => 'required|in:yes,no',
            'ownership_details.sa_owner_name' => 'nullable|string|max:255',
            'ownership_details.sa_plot_no' => 'nullable|string|max:255',
            'ownership_details.previous_owner_name' => 'nullable|string|max:255',
            'ownership_details.sa_khatian_no' => 'nullable|string|max:255',
            'ownership_details.sa_total_land_in_plot' => 'nullable|string|max:255',
            'ownership_details.sa_land_in_khatian' => 'nullable|string|max:255',
            'ownership_details.ownership_type' => 'nullable|in:deed,inheritance',
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
            'ownership_details.deed_transfers.*.mutation_case_no' => 'nullable|string|max:255',
            'ownership_details.deed_transfers.*.mutation_plot_no' => 'nullable|string|max:255',
            'ownership_details.deed_transfers.*.mutation_land_amount' => 'nullable|string|max:255',
            'ownership_details.inheritance.is_heir_applicant' => 'nullable|in:yes,no',
            'ownership_details.inheritance.has_death_cert' => 'nullable|in:yes,no',
            'ownership_details.inheritance.heirship_certificate_info' => 'nullable|string',
            'mutation_info' => 'required|array',
            'mutation_info.records' => 'nullable|array',
            'mutation_info.records.*.khatian_no' => 'nullable|string|max:255',
            'mutation_info.records.*.case_no' => 'nullable|string|max:255',
            'mutation_info.records.*.plot_no' => 'nullable|string|max:255',
            'mutation_info.records.*.land_amount' => 'nullable|string|max:255',
            'tax_info' => 'required|array',
            'tax_info.paid_until' => 'nullable|string|max:255',
            'additional_documents_info' => 'required|array',
            'additional_documents_info.distribution_records' => 'nullable|array',
            'additional_documents_info.distribution_records.*.details' => 'nullable|string',
            'additional_documents_info.no_claim_type' => 'nullable|in:donor,recipient',
            'additional_documents_info.field_investigation_info' => 'nullable|string',
            'additional_documents_info.submitted_docs' => 'nullable|array',
        ]);

        Compensation::create($validatedData);

        return redirect()->route('compensation.index')->with('success', 'ক্ষতিপূরণ তথ্য সফলভাবে জমা দেওয়া হয়েছে।');
    }
}