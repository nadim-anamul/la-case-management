<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderSheet extends Model
{
    use HasFactory;
    protected $table = 'order_sheets';
    protected $fillable = [
        'district', 'case_type', 'case_number', 'order_date', 'applicant_name', 'applicant_details',
        'roedad_review', 'miss_case_details', 'sa_record_details', 'sa_owner_heir_details',
        'sa_heir_heir_details', 'sa_heir_transfer_details_1', 'sa_heir_transfer_details_2',
        'rs_khatian_details', 'rs_owner_heir_details', 'tax_review', 'no_claim_review',
        'investigation_review', 'applicant_claim', 'overall_review', 'final_order_summary',
        'final_payment_order', 'compensation_details', 'total_compensation_words', 'lao_name', 'adc_name',
    ];
}
