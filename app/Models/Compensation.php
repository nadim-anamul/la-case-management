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
        'applicants', 'la_case_no', 'award_type',
        'land_award_serial_no', 'tree_award_serial_no', 'infrastructure_award_serial_no',
        'acquisition_record_basis', 'plot_no', 'award_holder_names',
        'objector_details', 'is_applicant_in_award', 
        'source_tax_percentage', 'tree_compensation',
        'infrastructure_compensation',
        'land_category', 'district', 'upazila', 'mouza_name', 'jl_no', 'sa_khatian_no', 
        'land_schedule_sa_plot_no', 'rs_khatian_no', 'land_schedule_rs_plot_no', 
        'ownership_details', 'mutation_info', 'tax_info', 
        'additional_documents_info', 'kanungo_opinion',
        'order_signature_date', 'signing_officer_name', 'status', 'final_order'
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
        'land_category' => 'array',
        'is_applicant_in_award' => 'boolean',
        'ownership_details' => 'array',
        'mutation_info' => 'array',
        'tax_info' => 'array',
        'additional_documents_info' => 'array',
        'kanungo_opinion' => 'array',
        'final_order' => 'array',
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

    /**
     * Format application area string based on type
     */
    public function formatApplicationAreaString($deed)
    {
        if (!isset($deed['application_type']) || !$deed['application_type']) {
            // Handle backward compatibility for old data
            if (isset($deed['application_specific_area']) && $deed['application_specific_area']) {
                $specificArea = $deed['application_specific_area'] ?? '';
                $sellArea = $deed['application_sell_area'] ?? '';
                return "আবেদনকৃত {$specificArea} দাগের সুনির্দিষ্টভাবে {$sellArea} একর বিক্রয়";
            } elseif (isset($deed['application_other_areas']) && $deed['application_other_areas']) {
                $otherAreas = $deed['application_other_areas'] ?? '';
                $totalArea = $deed['application_total_area'] ?? '';
                $sellAreaOther = $deed['application_sell_area_other'] ?? '';
                return "আবেদনকৃত {$otherAreas} দাগসহ বিভিন্ন দাগ উল্লেখ করে মোট {$totalArea} একরের কাতে {$sellAreaOther} একর বিক্রয়";
            }
            return '';
        }

        if ($deed['application_type'] === 'specific') {
            $specificArea = $deed['application_specific_area'] ?? '';
            $sellArea = $deed['application_sell_area'] ?? '';
            return "আবেদনকৃত {$specificArea} দাগের সুনির্দিষ্টভাবে {$sellArea} একর বিক্রয়";
        } elseif ($deed['application_type'] === 'multiple') {
            $otherAreas = $deed['application_other_areas'] ?? '';
            $totalArea = $deed['application_total_area'] ?? '';
            $sellAreaOther = $deed['application_sell_area_other'] ?? '';
            return "আবেদনকৃত {$otherAreas} দাগসহ বিভিন্ন দাগ উল্লেখ করে মোট {$totalArea} একরের কাতে {$sellAreaOther} একর বিক্রয়";
        }

        return '';
    }

    /**
     * Get the total land amount from land category
     */
    public function getTotalLandAmountAttribute()
    {
        if (!$this->land_category || !is_array($this->land_category)) {
            return 0;
        }

        return collect($this->land_category)->sum(function ($category) {
            return floatval($category['total_land'] ?? 0);
        });
    }

    /**
     * Get the total compensation amount from land category
     */
    public function getTotalCompensationAmountAttribute()
    {
        if (!$this->land_category || !is_array($this->land_category)) {
            return 0;
        }

        return collect($this->land_category)->sum(function ($category) {
            return floatval($category['total_compensation'] ?? 0);
        });
    }

    /**
     * Get the applicant's acquired land amount
     */
    public function getApplicantAcquiredLandAttribute()
    {
        if (!$this->land_category || !is_array($this->land_category)) {
            return 0;
        }

        return collect($this->land_category)->sum(function ($category) {
            return floatval($category['applicant_land'] ?? 0);
        });
    }

    /**
     * Get the plot number based on acquisition record basis
     */
    public function getPlotNoAttribute()
    {
        if ($this->acquisition_record_basis === 'SA') {
            return $this->land_schedule_sa_plot_no;
        } elseif ($this->acquisition_record_basis === 'RS') {
            return $this->land_schedule_rs_plot_no;
        }
        return $this->jl_no;
    }

    /**
     * Scope to filter by status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope to search in compensation records
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('la_case_no', 'like', "%{$search}%")
              ->orWhere('case_number', 'like', "%{$search}%")
              ->orWhere('mouza_name', 'like', "%{$search}%")
              ->orWhere('jl_no', 'like', "%{$search}%")
              ->orWhere('sa_khatian_no', 'like', "%{$search}%")
              ->orWhere('rs_khatian_no', 'like', "%{$search}%")
              ->orWhere('plot_no', 'like', "%{$search}%")
              ->orWhere('land_schedule_sa_plot_no', 'like', "%{$search}%")
              ->orWhere('land_schedule_rs_plot_no', 'like', "%{$search}%")
              ->orWhereRaw("JSON_SEARCH(applicants, 'one', ?, null, '$[*].name')", ["%{$search}%"]);
        });
    }
}