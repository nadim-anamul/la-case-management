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
            'is_applicant_sa_owner' => 'required|boolean',
            'sa_owner_name' => 'nullable|string|max:255',
        ]);

        Compensation::create($validatedData);

        return redirect()->route('compensation.index')->with('success', 'ক্ষতিপূরণ তথ্য সফলভাবে জমা দেওয়া হয়েছে।');
    }
}