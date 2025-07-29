@extends('layouts.app')

@section('title', 'ক্ষতিপূরণ তথ্য প্রিভিউ')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-800">ক্ষতিপূরণ তথ্য প্রিভিউ</h1>
        <div class="space-x-4">
            <a href="{{ route('compensation.edit', $compensation->id) }}" class="btn-primary">
                সম্পাদনা করুন
            </a>
            <a href="{{ route('compensation.index') }}" class="btn-secondary">
                তালিকায় ফিরে যান
            </a>
        </div>
    </div>

    <!-- Case Information -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4 text-blue-600 border-b pb-2">
            <span class="section-icon">১</span>
            মামলার তথ্য
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div>
                <label class="font-semibold text-gray-700">মামলা নম্বর:</label>
                <p class="text-gray-900">{{ $compensation->case_number }}</p>
            </div>
            <div>
                <label class="font-semibold text-gray-700">মামলার তারিখ:</label>
                <p class="text-gray-900">{{ $compensation->case_date }}</p>
            </div>
            <div>
                <label class="font-semibold text-gray-700">এলএ কেস নং:</label>
                <p class="text-gray-900">{{ $compensation->la_case_no }}</p>
            </div>
            <div>
                <label class="font-semibold text-gray-700">রোয়েদাদের ক্রমিক নং:</label>
                <p class="text-gray-900">{{ $compensation->award_serial_no }}</p>
            </div>
            <div>
                <label class="font-semibold text-gray-700">যে রেকর্ড মূলে অধিগ্রহণ:</label>
                <p class="text-gray-900">{{ $compensation->acquisition_record_basis }}</p>
            </div>
            <div>
                <label class="font-semibold text-gray-700">দাগ নং:</label>
                <p class="text-gray-900">{{ $compensation->plot_no }}</p>
            </div>
        </div>
    </div>

    <!-- Applicant Information -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4 text-blue-600 border-b pb-2">
            <span class="section-icon">২</span>
            আবেদনকারীর তথ্য
        </h2>
        @foreach($compensation->applicants as $index => $applicant)
        <div class="mb-4 p-4 border rounded-lg">
            <h3 class="font-semibold text-lg mb-2">আবেদনকারী #{{ $index + 1 }}</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="font-semibold text-gray-700">নাম:</label>
                    <p class="text-gray-900">{{ $applicant['name'] }}</p>
                </div>
                <div>
                    <label class="font-semibold text-gray-700">পিতার নাম:</label>
                    <p class="text-gray-900">{{ $applicant['father_name'] }}</p>
                </div>
                <div class="md:col-span-2">
                    <label class="font-semibold text-gray-700">ঠিকানা:</label>
                    <p class="text-gray-900">{{ $applicant['address'] }}</p>
                </div>
                <div>
                    <label class="font-semibold text-gray-700">এন আই ডি:</label>
                    <p class="text-gray-900">{{ $applicant['nid'] }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Award Information -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4 text-blue-600 border-b pb-2">
            <span class="section-icon">৩</span>
            রোয়েদাদের তথ্য
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div>
                <label class="font-semibold text-gray-700">রোয়েদাদভুক্ত মালিকের নাম:</label>
                <p class="text-gray-900">{{ $compensation->award_holder_name }}</p>
            </div>
            <div>
                <label class="font-semibold text-gray-700">আবেদনকারীর নাম রোয়েদাদে আছে কিনা:</label>
                <p class="text-gray-900">{{ $compensation->is_applicant_in_award ? 'হ্যাঁ' : 'না' }}</p>
            </div>
            <div>
                <label class="font-semibold text-gray-700">অধিগ্রহণকৃত মোট জমির পরিমাণ:</label>
                <p class="text-gray-900">{{ $compensation->total_acquired_land }}</p>
            </div>
            <div>
                <label class="font-semibold text-gray-700">অধিগ্রহণকৃত জমির মোট ক্ষতিপূরণ:</label>
                <p class="text-gray-900">{{ $compensation->total_compensation }}</p>
            </div>
            <div>
                <label class="font-semibold text-gray-700">আবেদনকারীর অধিগ্রহণকৃত জমির পরিমাণ:</label>
                <p class="text-gray-900">{{ $compensation->applicant_acquired_land }}</p>
            </div>
            @if($compensation->acquisition_record_basis === 'SA')
            <div>
                <label class="font-semibold text-gray-700">SA দাগ নং:</label>
                <p class="text-gray-900">{{ $compensation->sa_plot_no }}</p>
            </div>
            <div>
                <label class="font-semibold text-gray-700">SA খতিয়ান নং:</label>
                <p class="text-gray-900">{{ $compensation->sa_khatian_no }}</p>
            </div>
            @endif
            @if($compensation->acquisition_record_basis === 'RS')
            <div>
                <label class="font-semibold text-gray-700">RS দাগ নং:</label>
                <p class="text-gray-900">{{ $compensation->rs_plot_no }}</p>
            </div>
            <div>
                <label class="font-semibold text-gray-700">RS খতিয়ান নং:</label>
                <p class="text-gray-900">{{ $compensation->rs_khatian_no }}</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Land Schedule -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4 text-blue-600 border-b pb-2">
            <span class="section-icon">৪</span>
            জমির তফসিল
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div>
                <label class="font-semibold text-gray-700">মৌজার নাম:</label>
                <p class="text-gray-900">{{ $compensation->mouza_name }}</p>
            </div>
            <div>
                <label class="font-semibold text-gray-700">জেএল নং:</label>
                <p class="text-gray-900">{{ $compensation->jl_no }}</p>
            </div>
            <div>
                <label class="font-semibold text-gray-700">সাবেক দাগ নং:</label>
                <p class="text-gray-900">{{ $compensation->former_plot_no }}</p>
            </div>
            <div>
                <label class="font-semibold text-gray-700">হাল দাগ নং:</label>
                <p class="text-gray-900">{{ $compensation->current_plot_no }}</p>
            </div>
        </div>
    </div>

    <!-- Ownership Continuity -->
    @if($compensation->ownership_details)
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4 text-blue-600 border-b pb-2">
            <span class="section-icon">৫</span>
            মালিকানার ধারাবাহিকতার বর্ণনা
        </h2>
        
        @if($compensation->acquisition_record_basis === 'SA' && isset($compensation->ownership_details['sa_info']))
        <div class="mb-6">
            <h3 class="font-semibold text-lg mb-3 text-green-600">SA রেকর্ড তথ্য</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="font-semibold text-gray-700">SA দাগ নম্বর:</label>
                    <p class="text-gray-900">{{ $compensation->ownership_details['sa_info']['sa_plot_no'] ?? '' }}</p>
                </div>
                <div>
                    <label class="font-semibold text-gray-700">SA খতিয়ান নম্বর:</label>
                    <p class="text-gray-900">{{ $compensation->ownership_details['sa_info']['sa_khatian_no'] ?? '' }}</p>
                </div>
                <div>
                    <label class="font-semibold text-gray-700">SA দাগে মোট জমি:</label>
                    <p class="text-gray-900">{{ $compensation->ownership_details['sa_info']['sa_total_land_in_plot'] ?? '' }}</p>
                </div>
                <div>
                    <label class="font-semibold text-gray-700">SA উক্ত খতিয়ানে জমির পরিমাণ:</label>
                    <p class="text-gray-900">{{ $compensation->ownership_details['sa_info']['sa_land_in_khatian'] ?? '' }}</p>
                </div>
            </div>
            
            @if(isset($compensation->ownership_details['sa_owners']))
            <div class="mt-4">
                <h4 class="font-semibold mb-2">SA মালিকগণ:</h4>
                @foreach($compensation->ownership_details['sa_owners'] as $owner)
                <p class="text-gray-900">• {{ $owner['name'] }}</p>
                @endforeach
            </div>
            @endif
        </div>
        @endif

        @if($compensation->acquisition_record_basis === 'RS' && isset($compensation->ownership_details['rs_info']))
        <div class="mb-6">
            <h3 class="font-semibold text-lg mb-3 text-green-600">RS রেকর্ড তথ্য</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="font-semibold text-gray-700">RS দাগ নম্বর:</label>
                    <p class="text-gray-900">{{ $compensation->ownership_details['rs_info']['rs_plot_no'] ?? '' }}</p>
                </div>
                <div>
                    <label class="font-semibold text-gray-700">RS খতিয়ান নম্বর:</label>
                    <p class="text-gray-900">{{ $compensation->ownership_details['rs_info']['rs_khatian_no'] ?? '' }}</p>
                </div>
                <div>
                    <label class="font-semibold text-gray-700">RS দাগে মোট জমি:</label>
                    <p class="text-gray-900">{{ $compensation->ownership_details['rs_info']['rs_total_land_in_plot'] ?? '' }}</p>
                </div>
                <div>
                    <label class="font-semibold text-gray-700">RS খতিয়ানে মোট জমির পরিমাণ:</label>
                    <p class="text-gray-900">{{ $compensation->ownership_details['rs_info']['rs_land_in_khatian'] ?? '' }}</p>
                </div>
            </div>
            
            @if(isset($compensation->ownership_details['rs_owners']))
            <div class="mt-4">
                <h4 class="font-semibold mb-2">RS মালিকগণ:</h4>
                @foreach($compensation->ownership_details['rs_owners'] as $owner)
                <p class="text-gray-900">• {{ $owner['name'] }}</p>
                @endforeach
            </div>
            @endif
        </div>
        @endif

        @if(isset($compensation->ownership_details['deed_transfers']) && count($compensation->ownership_details['deed_transfers']) > 0)
        <div class="mb-6">
            <h3 class="font-semibold text-lg mb-3 text-green-600">দলিল মূলে হস্তান্তর তথ্য</h3>
            @foreach($compensation->ownership_details['deed_transfers'] as $index => $deed)
            <div class="mb-4 p-4 border rounded-lg">
                <h4 class="font-semibold mb-2">দলিল #{{ $index + 1 }}</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="font-semibold text-gray-700">দাতার নাম:</label>
                        <p class="text-gray-900">{{ $deed['donor_name'] ?? '' }}</p>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-700">গ্রহীতার নাম:</label>
                        <p class="text-gray-900">{{ $deed['recipient_name'] ?? '' }}</p>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-700">দলিল নম্বর:</label>
                        <p class="text-gray-900">{{ $deed['deed_number'] ?? '' }}</p>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-700">দলিলের তারিখ:</label>
                        <p class="text-gray-900">{{ $deed['deed_date'] ?? '' }}</p>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-700">বিক্রয়ের ধরন:</label>
                        <p class="text-gray-900">{{ $deed['sale_type'] ?? '' }}</p>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-700">দাগ নম্বর:</label>
                        <p class="text-gray-900">{{ $deed['plot_no'] ?? '' }}</p>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-700">বিক্রিত জমির পরিমাণ:</label>
                        <p class="text-gray-900">{{ $deed['sold_land_amount'] ?? '' }}</p>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-700">মোট সোতাংশ:</label>
                        <p class="text-gray-900">{{ $deed['total_sotangsho'] ?? '' }}</p>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-700">মোট শতক:</label>
                        <p class="text-gray-900">{{ $deed['total_shotok'] ?? '' }}</p>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-700">দখলের উল্লেখ আছে কিনা:</label>
                        <p class="text-gray-900">{{ $deed['possession_mentioned'] === 'yes' ? 'হ্যাঁ' : 'না' }}</p>
                    </div>
                    @if($deed['possession_mentioned'] === 'yes')
                    <div>
                        <label class="font-semibold text-gray-700">দখলের দাগ নম্বর:</label>
                        <p class="text-gray-900">{{ $deed['possession_plot_no'] ?? '' }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <label class="font-semibold text-gray-700">দখলের বিবরণ:</label>
                        <p class="text-gray-900">{{ $deed['possession_description'] ?? '' }}</p>
                    </div>
                    @endif
                    <div>
                        <label class="font-semibold text-gray-700">খারিজ কেস নম্বর:</label>
                        <p class="text-gray-900">{{ $deed['mutation_case_no'] ?? '' }}</p>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-700">খারিজ দাগ নম্বর:</label>
                        <p class="text-gray-900">{{ $deed['mutation_plot_no'] ?? '' }}</p>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-700">খারিজ জমির পরিমাণ:</label>
                        <p class="text-gray-900">{{ $deed['mutation_land_amount'] ?? '' }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        @if(isset($compensation->ownership_details['inheritance_records']) && count($compensation->ownership_details['inheritance_records']) > 0)
        <div class="mb-6">
            <h3 class="font-semibold text-lg mb-3 text-green-600">ওয়ারিশ মূলে হস্তান্তর তথ্য</h3>
            @foreach($compensation->ownership_details['inheritance_records'] as $index => $inheritance)
            <div class="mb-4 p-4 border rounded-lg">
                <h4 class="font-semibold mb-2">ওয়ারিশ #{{ $index + 1 }}</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="font-semibold text-gray-700">পূর্ববর্তী মালিকের নাম:</label>
                        <p class="text-gray-900">{{ $inheritance['previous_owner_name'] ?? '' }}</p>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-700">মৃত্যুর তারিখ:</label>
                        <p class="text-gray-900">{{ $inheritance['death_date'] ?? '' }}</p>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-700">ওয়ারিশের ধরন:</label>
                        <p class="text-gray-900">{{ $inheritance['inheritance_type'] ?? '' }}</p>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-700">মৃত্যু সনদ আছে কিনা:</label>
                        <p class="text-gray-900">{{ $inheritance['has_death_cert'] === 'yes' ? 'হ্যাঁ' : 'না' }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <label class="font-semibold text-gray-700">ওয়ারিশ সনদের তথ্য:</label>
                        <p class="text-gray-900">{{ $inheritance['heirship_certificate_info'] ?? '' }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        @if(isset($compensation->ownership_details['rs_records']) && count($compensation->ownership_details['rs_records']) > 0)
        <div class="mb-6">
            <h3 class="font-semibold text-lg mb-3 text-green-600">আরএস রেকর্ড তথ্য</h3>
            @foreach($compensation->ownership_details['rs_records'] as $index => $rs)
            <div class="mb-4 p-4 border rounded-lg">
                <h4 class="font-semibold mb-2">আরএস রেকর্ড #{{ $index + 1 }}</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="font-semibold text-gray-700">আরএস দাগ নম্বর:</label>
                        <p class="text-gray-900">{{ $rs['rs_plot_no'] ?? '' }}</p>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-700">আরএস খতিয়ান নম্বর:</label>
                        <p class="text-gray-900">{{ $rs['rs_khatian_no'] ?? '' }}</p>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-700">আরএস দাগে মোট জমি:</label>
                        <p class="text-gray-900">{{ $rs['rs_total_land_in_plot'] ?? '' }}</p>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-700">আরএস খতিয়ানে জমির পরিমাণ:</label>
                        <p class="text-gray-900">{{ $rs['rs_land_in_khatian'] ?? '' }}</p>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-700">আরএস মালিকের নাম:</label>
                        <p class="text-gray-900">{{ $rs['rs_owner_name'] ?? '' }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        @if(isset($compensation->ownership_details['applicant_info']))
        <div class="mb-6">
            <h3 class="font-semibold text-lg mb-3 text-green-600">উপরোক্ত মালিকই আবেদনকারী</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="font-semibold text-gray-700">আবেদনকারীর নাম:</label>
                    <p class="text-gray-900">{{ $compensation->ownership_details['applicant_info']['applicant_name'] ?? '' }}</p>
                </div>
                <div>
                    <label class="font-semibold text-gray-700">খারিজ কেস নম্বর:</label>
                    <p class="text-gray-900">{{ $compensation->ownership_details['applicant_info']['kharij_case_no'] ?? '' }}</p>
                </div>
                <div>
                    <label class="font-semibold text-gray-700">খারিজ দাগ নম্বর:</label>
                    <p class="text-gray-900">{{ $compensation->ownership_details['applicant_info']['kharij_plot_no'] ?? '' }}</p>
                </div>
                <div>
                    <label class="font-semibold text-gray-700">খারিজ জমির পরিমাণ:</label>
                    <p class="text-gray-900">{{ $compensation->ownership_details['applicant_info']['kharij_land_amount'] ?? '' }}</p>
                </div>
                <div>
                    <label class="font-semibold text-gray-700">খারিজের তারিখ:</label>
                    <p class="text-gray-900">{{ $compensation->ownership_details['applicant_info']['kharij_date'] ?? '' }}</p>
                </div>
                <div class="md:col-span-2">
                    <label class="font-semibold text-gray-700">খারিজের বিবরণ:</label>
                    <p class="text-gray-900">{{ $compensation->ownership_details['applicant_info']['kharij_details'] ?? '' }}</p>
                </div>
            </div>
        </div>
        @endif
    </div>
    @endif

    <!-- Tax Information -->
    @if($compensation->tax_info)
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4 text-blue-600 border-b pb-2">
            <span class="section-icon">৬</span>
            করের তথ্য
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="font-semibold text-gray-700">ইংরেজি বছর:</label>
                <p class="text-gray-900">{{ $compensation->tax_info['english_year'] ?? '' }}</p>
            </div>
            <div>
                <label class="font-semibold text-gray-700">বাংলা বছর:</label>
                <p class="text-gray-900">{{ $compensation->tax_info['bangla_year'] ?? '' }}</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Additional Documents -->
    @if($compensation->additional_documents_info)
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4 text-blue-600 border-b pb-2">
            <span class="section-icon">৭</span>
            বণ্টন / না-দাবি / আপসনামা / এফিডেভিটের তথ্য
        </h2>
        @if(isset($compensation->additional_documents_info['selected_types']))
        <div class="mb-4">
            <label class="font-semibold text-gray-700">দাখিলকৃত ডকুমেন্টের ধরন:</label>
            <div class="mt-2">
                @foreach($compensation->additional_documents_info['selected_types'] as $type)
                <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm mr-2 mb-2">{{ $type }}</span>
                @endforeach
            </div>
        </div>
        @endif
        
        @if(isset($compensation->additional_documents_info['details']))
        <div>
            <label class="font-semibold text-gray-700">ডকুমেন্টের বিবরণ:</label>
            @foreach($compensation->additional_documents_info['details'] as $type => $details)
            <div class="mt-3 p-3 border rounded-lg">
                <h4 class="font-semibold text-gray-700 mb-2">{{ $type }}:</h4>
                <p class="text-gray-900">{{ $details }}</p>
            </div>
            @endforeach
        </div>
        @endif
    </div>
    @endif

    <!-- Kanungo Opinion -->
    @if($compensation->kanungo_opinion)
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4 text-blue-600 border-b pb-2">
            <span class="section-icon">৮</span>
            কানুনগো মতামত
        </h2>
        <div class="grid grid-cols-1 gap-4">
            <div>
                <label class="font-semibold text-gray-700">মালিকানার ধারাবাহিকতা আছে কিনা:</label>
                <p class="text-gray-900">{{ $compensation->kanungo_opinion['has_ownership_continuity'] === 'yes' ? 'হ্যাঁ' : 'না' }}</p>
            </div>
            <div>
                <label class="font-semibold text-gray-700">মতামতের বিবরণ:</label>
                <p class="text-gray-900">{{ $compensation->kanungo_opinion['opinion_details'] ?? '' }}</p>
            </div>
        </div>
    </div>
    @endif
</div>

<style>
.section-icon {
    display: inline-block;
    width: 24px;
    height: 24px;
    background-color: #3b82f6;
    color: white;
    border-radius: 50%;
    text-align: center;
    line-height: 24px;
    font-size: 12px;
    font-weight: bold;
    margin-right: 8px;
}

.btn-primary {
    @apply bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded;
}

.btn-secondary {
    @apply bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded;
}
</style>
@endsection 