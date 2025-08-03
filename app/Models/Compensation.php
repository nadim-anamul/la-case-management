<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BengaliDateTrait;

class Compensation extends Model
{
    use HasFactory, BengaliDateTrait;

    protected $table = 'compensations';

    protected $fillable = [
        'case_number', 'case_date', 'sa_plot_no', 'rs_plot_no',
        'applicants', 'la_case_no', 'award_type', 'award_serial_no',
        'acquisition_record_basis', 'plot_no', 'award_holder_names',
        'objector_details', 'is_applicant_in_award', 'total_acquired_land',
        'total_compensation', 'source_tax_percentage', 'tree_compensation',
        'infrastructure_compensation', 'infrastructure_source_tax_percentage',
        'applicant_acquired_land', 'mouza_name', 'jl_no', 'sa_khatian_no', 
        'land_schedule_sa_plot_no', 'rs_khatian_no', 'land_schedule_rs_plot_no', 
        'is_applicant_sa_owner', 'ownership_details', 'mutation_info', 'tax_info', 
        'additional_documents_info', 'kanungo_opinion', 'sa_owners', 'rs_owners', 
        'order_signature_date', 'signing_officer_name', 'status'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'applicants' => 'array',
        'award_type' => 'array',
        'award_holder_names' => 'array',
        'is_applicant_in_award' => 'boolean',
        'ownership_details' => 'array',
        'mutation_info' => 'array',
        'tax_info' => 'array',
        'additional_documents_info' => 'array',
        'kanungo_opinion' => 'array',
        'sa_owners' => 'array',
        'rs_owners' => 'array',
    ];

    /**
     * Get case_date in Bengali format
     */
    public function getCaseDateBengaliAttribute()
    {
        return $this->convertToBengaliDate($this->case_date);
    }

    /**
     * Get order_signature_date in Bengali format
     */
    public function getOrderSignatureDateBengaliAttribute()
    {
        return $this->convertToBengaliDate($this->order_signature_date);
    }
}