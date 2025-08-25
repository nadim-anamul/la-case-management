@extends('layouts.pdf')

@section('title', 'ক্ষতিপূরণ কেস প্রিভিউ')

@section('content')
<div class="container-pdf">
    <!-- Header with case summary -->
    <div class="header-section">
        <h1 class="main-title">ক্ষতিপূরণ কেস প্রিভিউ</h1>
        <div class="case-summary">
            <span class="summary-item">মামলা নং: {{ $compensation->getBengaliValue('case_number') }}</span>
            <span class="summary-item">তারিখ: {{ $compensation->case_date_bengali }}</span>
            <span class="summary-item">এলএ কেস: {{ $compensation->getBengaliValue('la_case_no') }}</span>
        </div>
    </div>

    <!-- Case Information -->
    <h2 class="section-header">মামলার তথ্য</h2>
    <div class="info-grid-compact">
        <span class="info-item-compact">মামলা নম্বর: {{ $compensation->getBengaliValue('case_number') }}</span>
        <span class="info-item-compact">মামলার তারিখ: {{ $compensation->case_date_bengali }}</span>
        <span class="info-item-compact">এলএ কেস নং: {{ $compensation->getBengaliValue('la_case_no') }}</span>
        @if($compensation->land_award_serial_no)
        <span class="info-item-compact">জমির রোয়েদাদ নং: {{ $compensation->getBengaliValue('land_award_serial_no') }}</span>
        @endif
        @if($compensation->tree_award_serial_no)
        <span class="info-item-compact">গাছপালার রোয়েদাদ নং: {{ $compensation->getBengaliValue('tree_award_serial_no') }}</span>
        @endif
        @if($compensation->infrastructure_award_serial_no)
        <span class="info-item-compact">অবকাঠামোর রোয়েদাদ নং: {{ $compensation->getBengaliValue('infrastructure_award_serial_no') }}</span>
        @endif
        <span class="info-item-compact">রেকর্ড মূলে অধিগ্রহণ: {{ $compensation->acquisition_record_basis }}</span>
        <span class="info-item-compact">দাগ নং: {{ $compensation->acquisition_record_basis === 'SA' ? ($compensation->bnDigits($compensation->sa_plot_no ?? '…………………………….' )) : ($compensation->bnDigits($compensation->rs_plot_no ?? '…………………………….' )) }}</span>
        <span class="info-item-compact">খতিয়ান নং: {{ $compensation->bnDigits($compensation->plot_no ?? '…………………………….' ) }}</span>
    </div>

    <!-- Applicant Information -->
    <h2 class="section-header">আবেদনকারীর তথ্য</h2>
    @foreach($compensation->applicants as $index => $applicant)
    <div class="applicant-card-compact">
        <h3 class="applicant-title-compact">আবেদনকারী #{{ $index + 1 }}</h3>
        <div class="applicant-info-compact">
            <span class="info-item-compact">নাম: {{ $applicant['name'] }}</span>
            <span class="info-item-compact">পিতার নাম: {{ $applicant['father_name'] }}</span>
            <span class="info-item-compact">ঠিকানা: {{ $applicant['address'] }}</span>
            <span class="info-item-compact">এন আই ডি: {{ $compensation->bnDigits($applicant['nid']) }}</span>
            @if(isset($applicant['mobile']) && $applicant['mobile'])
            <span class="info-item-compact">মোবাইল নং: {{ $compensation->bnDigits($applicant['mobile']) }}</span>
            @endif
        </div>
    </div>
    @endforeach

    <!-- Award Information -->
    <h2 class="section-header">রোয়েদাদের তথ্য</h2>

    <!-- Award Holders -->
    @if($compensation->award_holder_names && count($compensation->award_holder_names) > 0)
    <div class="award-holders">
        <h3 class="subsection-title">রোয়েদাদভুক্ত মালিকের তথ্য</h3>
        @foreach($compensation->award_holder_names as $index => $holder)
        <div class="holder-card-compact">
            <h4 class="holder-title-compact">মালিক #{{ $index + 1 }}</h4>
            <div class="holder-info-compact">
                <span class="info-item-compact">নাম: {{ $holder['name'] }}</span>
                @if(isset($holder['father_name']) && $holder['father_name'])
                <span class="info-item-compact">পিতার নাম: {{ $holder['father_name'] }}</span>
                @endif
                @if(isset($holder['address']) && $holder['address'])
                <span class="info-item-compact">ঠিকানা: {{ $holder['address'] }}</span>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    @endif

        <!-- Additional Compensation Details -->
        @if($compensation->tree_compensation || $compensation->infrastructure_compensation || $compensation->applicant_acquired_land)
        <div class="additional-compensation">
            <h3 class="subsection-title">অতিরিক্ত ক্ষতিপূরণের তথ্য</h3>
            <div class="compensation-grid">
                @if($compensation->tree_award_serial_no)
                <div>
                    <label class="font-semibold text-gray-700">গাছপালা/ফসলের রোয়েদাদ নং: {{ $compensation->getBengaliValue('tree_award_serial_no') }}</label>
                </div>
                @endif
                @if($compensation->tree_compensation)
                <div class="compensation-item">
                    <label>গাছপালার ক্ষতিপূরণ: {{ $compensation->tree_compensation }}</label>
                </div>
                @endif
                @if($compensation->infrastructure_award_serial_no)
                <div class="compensation-item">
                    <label class="font-semibold text-gray-700">অবকাঠামোর রোয়েদাদ নং: {{ $compensation->getBengaliValue('infrastructure_award_serial_no') }}</label>
                </div>
                @endif
                @if($compensation->infrastructure_compensation)
                <div class="compensation-item">
                    <label>অবকাঠামোর ক্ষতিপূরণ: {{ $compensation->infrastructure_compensation }}</label>
                </div>
                @endif
                @if($compensation->land_award_serial_no)
                <div class="compensation-item">
                    <label class="font-semibold text-gray-700">জমির রোয়েদাদ নং: {{ $compensation->getBengaliValue('land_award_serial_no') }}</label>
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Land Categories -->
        @if($compensation->land_category && count($compensation->land_category) > 0)
        <div class="land-categories">
            <h3 class="subsection-title">জমির শ্রেণী অনুযায়ী তথ্য</h3>
            <div class="category-table">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>জমির শ্রেণী</th>
                            <th>মোট জমি</th>
                            <th>মোট ক্ষতিপূরণ</th>
                            <th>আবেদনকারীর জমি</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($compensation->land_category as $category)
                        <tr>
                            <td>{{ $category['category_name'] ?? '' }}</td>
                            <td>{{ $compensation->bnDigits($category['total_land'] ?? '') }} একর</td>
                            <td>{{ $compensation->bnDigits($category['total_compensation'] ?? '') }}</td>
                            <td>{{ $category['applicant_land'] ? $compensation->bnDigits($category['applicant_land']) . ' একর' : 'তথ্য নেই' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <!-- Award Type and Records -->
        <div class="award-details">
            @if($compensation->award_type)
            <div class="detail-item">
                <label>রোয়েদাদের ধরন:</label>
                <span>{{ is_array($compensation->award_type) ? implode(', ', $compensation->award_type) : $compensation->award_type }}</span>
            </div>
            @endif
            
            @if($compensation->acquisition_record_basis === 'SA')
            <div class="record-info">
                <h4>SA রেকর্ড তথ্য</h4>
                <div class="info-row">
                    <div class="info-col">
                        <label>SA দাগ নং: {{ $compensation->getBengaliValue('sa_plot_no') }}</label>
                    </div>
                    <div class="info-col">
                        <label>SA খতিয়ান নং: {{ $compensation->getBengaliValue('sa_khatian_no') }}</label>
                    </div>
                </div>
            </div>
            @endif
            
            @if($compensation->acquisition_record_basis === 'RS')
            <div class="record-info">
                <h4>RS রেকর্ড তথ্য</h4>
                <div class="info-row">
                    <div class="info-col">
                        <label>RS দাগ নং: {{ $compensation->getBengaliValue('rs_plot_no') }}</label>
                    </div>
                    <div class="info-col">
                        <label>RS খতিয়ান নং: {{ $compensation->getBengaliValue('rs_khatian_no') }}</label>
                    </div>
                </div>
            </div>
            @endif
            
            @if($compensation->objector_details)
            <div class="objector-info">
                <label>আপত্তিকারীর তথ্য: {{ $compensation->objector_details }}</label>
            </div>
            @endif
        </div>
    </div>

    <!-- Land Schedule -->
    <h2 class="section-header">
        আবেদনকৃত জমির তফসিল
    </h2>
    <div class="land-schedule-info">
        <div class="location-details">
            <div class="info-row">
                <div class="info-col">
                    <label>জেলা: {{ $compensation->district ?? 'তথ্য নেই' }}</label>
                </div>
                <div class="info-col">
                    <label>উপজেলা: {{ $compensation->upazila ?? 'তথ্য নেই' }}</label>
                </div>
            </div>
            <div class="info-row">
                <div class="info-col">
                    <label>মৌজার নাম: {{ $compensation->mouza_name }}</label>
                </div>
                <div class="info-col">
                    <label>জেএল নং: {{ $compensation->getBengaliValue('jl_no') }}</label>
                </div>
            </div>
        </div>
        
        <div class="record-details">
            <div class="info-row">
                <div class="info-col">
                    <label>এসএ খতিয়ান নং: {{ $compensation->getBengaliValue('sa_khatian_no') }}</label>
                </div>
                <div class="info-col">
                    <label>SA দাগ নং: {{ $compensation->getBengaliValue('land_schedule_sa_plot_no') }}</label>
                </div>
            </div>
            <div class="info-row">
                <div class="info-col">
                    <label>আর এস খতিয়ান নং: {{ $compensation->getBengaliValue('rs_khatian_no') }}</label>
                </div>
                <div class="info-col">
                    <label>RS দাগ নং: {{ $compensation->getBengaliValue('land_schedule_rs_plot_no') }}</label>
                </div>
            </div>
        </div>
    </div>

    <!-- Ownership Continuity -->
    @if($compensation->ownership_details)
    <h2 class="section-header">
        মালিকানার ধারাবাহিকতার বর্ণনা
    </h2>
        
        <!-- Story Sequence Display - Show First -->
        @if(isset($compensation->ownership_details['storySequence']) && count($compensation->ownership_details['storySequence']) > 0)
        <div class="mb-4">
            <h3 class="subsection-title">মালিকানার ধারাবাহিকতার ক্রম</h3>
            <div class="story-sequence">
                @foreach($compensation->ownership_details['storySequence'] as $index => $item)
                <div class="story-item">
                    <div class="story-number">{{ $index + 1 }}</div>
                    <div class="story-content">
                        <div class="story-type">{{ $item['type'] }}</div>
                        <div class="story-description">{{ $item['description'] }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        @if($compensation->acquisition_record_basis === 'SA' && isset($compensation->ownership_details['sa_info']))
        <div class="mb-4">
            <h3 class="subsection-title">SA রেকর্ড তথ্য</h3>
            <div class="info-grid">
                <div class="info-item">
                    <label>SA দাগ নম্বর: {{ $compensation->bnDigits($compensation->ownership_details['sa_info']['sa_plot_no'] ?? '') }}</label>
                </div>
                <div class="info-item">
                    <label>SA খতিয়ান নম্বর: {{ $compensation->bnDigits($compensation->ownership_details['sa_info']['sa_khatian_no'] ?? '') }}</label>
                </div>
                <div class="info-item">
                    <label>SA দাগে মোট জমি: {{ $compensation->bnDigits($compensation->ownership_details['sa_info']['sa_total_land_in_plot'] ?? '') }}</label>
                </div>
                <div class="info-item">
                    <label>SA উক্ত খতিয়ানে জমির পরিমাণ: {{ $compensation->getBengaliNestedValue('ownership_details.sa_info.sa_land_in_khatian') ?? '' }}</label>
                </div>
            </div>
            
            @if(isset($compensation->ownership_details['sa_owners']))
            <div class="mt-3">
                <h4 class="subsection-subtitle">SA মালিকগণ:</h4>
                @foreach($compensation->ownership_details['sa_owners'] as $owner)
                <p class="owner-item">• {{ $owner['name'] }}</p>
                @endforeach
            </div>
            @endif
        </div>
        @endif

        @if($compensation->acquisition_record_basis === 'RS' && isset($compensation->ownership_details['rs_info']))
        <div class="mb-4">
            <h3 class="subsection-title">RS রেকর্ড তথ্য</h3>
            <div class="info-grid">
                <label>RS দাগ নম্বর: {{ $compensation->bnDigits($compensation->ownership_details['rs_info']['rs_plot_no'] ?? '') }}</label>
                <label>RS খতিয়ান নম্বর: {{ $compensation->bnDigits($compensation->ownership_details['rs_info']['rs_khatian_no'] ?? '') }}</label>
                <label>RS দাগে মোট জমি: {{ $compensation->bnDigits($compensation->ownership_details['rs_info']['rs_total_land_in_plot'] ?? '') }}</label>
                <label>RS খতিয়ানে মোট জমির পরিমাণ: {{ $compensation->ownership_details['rs_info']['rs_land_in_khatian'] ?? '' }}</label>
                <label>ডিপি খতিয়ান: {{ isset($compensation->ownership_details['rs_info']['dp_khatian']) && $compensation->ownership_details['rs_info']['dp_khatian'] ? 'হ্যাঁ' : 'না' }}</label>
            </div>
            
            @if(isset($compensation->ownership_details['rs_owners']))
            <div class="mt-3">
                <h4 class="subsection-subtitle">RS মালিকগণ:</h4>
                @foreach($compensation->ownership_details['rs_owners'] as $owner)
                <p class="owner-item">• {{ $owner['name'] }}</p>
                @endforeach
            </div>
            @endif
        </div>
        @endif

        <!-- Detailed Transfer Information - Ordered by Story Sequence -->
        @if(isset($compensation->ownership_details['storySequence']) && count($compensation->ownership_details['storySequence']) > 0)
            @php
                // Create arrays to store the detailed information
                $deedTransfers = $compensation->ownership_details['deed_transfers'] ?? [];
                $inheritanceRecords = $compensation->ownership_details['inheritance_records'] ?? [];
                $rsRecords = $compensation->ownership_details['rs_records'] ?? [];
                
                // Track which items have been displayed
                $displayedDeeds = [];
                $displayedInheritances = [];
                $displayedRsRecords = [];
            @endphp
            
            @foreach($compensation->ownership_details['storySequence'] as $index => $item)
                @if($item['itemType'] === 'deed' && isset($deedTransfers[$item['itemIndex']]))
                    @php $deed = $deedTransfers[$item['itemIndex']]; $displayedDeeds[] = $item['itemIndex']; @endphp
                    <div class="mb-6">
                        <h3 class="section-header">দলিল মূলে হস্তান্তর তথ্য</h3>
                        <div class="mb-4 p-4 border rounded-lg">
                            <h4 class="subsection-subtitle">দলিল #{{ $item['itemIndex'] + 1 }}</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label>দাতার নাম:</label>
                                    @if(isset($deed['donor_names']))
                                        @foreach($deed['donor_names'] as $donor)
                                            <p>• {{ $donor['name'] ?? '' }}</p>
                                        @endforeach
                                    @endif
                                </div>
                                <div>
                                    <label>গ্রহীতার নাম:</label>
                                    @if(isset($deed['recipient_names']))
                                        @foreach($deed['recipient_names'] as $recipient)
                                            <p>• {{ $recipient['name'] ?? '' }}</p>
                                        @endforeach
                                    @endif
                                </div>
                                <div>
                                    <label>দলিল নম্বর: {{ $deed['deed_number'] ?? '' }}</label>
                                </div>
                                <div>
                                    <label>দলিলের তারিখ: {{ $compensation->bnDigits($deed['deed_date']) ?? '' }}</label>
                                </div>
                                <div>
                                    <label>দলিলের ধরন: {{ $deed['sale_type'] ?? '' }}</label>
                                </div>

                                <!-- Application Area Fields -->
                                @if(isset($deed['application_type']) && $deed['application_type'])
                                <div>
                                    <label>আবেদনকৃত দাগে সুনির্দিষ্টভাবে বিক্রয়:</label>
                                    <p>{{ $compensation->formatApplicationAreaString($deed) }}</p>
                                </div>
                                @endif
                                @if(isset($deed['possession_mentioned']) && $deed['possession_mentioned'] === 'yes')
                                <div>
                                    <label>দখলের দাগ নম্বর:</label>
                                    <p>{{ $deed['possession_plot_no'] ?? '' }}</p>
                                </div>
                                <div class="md:col-span-2">
                                    <label>দখল এর বর্ণনা:</label>
                                    <p>{{ $deed['possession_description'] ?? '' }}</p>
                                </div>
                                @endif
                                
                                <!-- New Possession Fields -->
                                <div>
                                    <label>দলিলের বিবরণ ও হাতনকশায় আবেদনকৃত দাগে দখল উল্লেখ রয়েছে কিনা?</label>
                                    <p>{{ isset($deed['possession_deed']) && $deed['possession_deed'] === 'yes' ? 'হ্যাঁ' : 'না' }}</p>
                                </div>
                                @if(isset($deed['mentioned_areas']) && $deed['mentioned_areas'])
                                <div>
                                    <label>যে সকল দাগে দখল উল্লেখ করা:</label>
                                    <p>{{ $deed['mentioned_areas'] }}</p>
                                </div>
                                @endif
                                @if(isset($deed['special_details']) && $deed['special_details'])
                                <div class="md:col-span-2">
                                    <label>প্রযোজ্যক্ষেত্রে দলিলের বিশেষ বিবরণ:</label>
                                    <p>{{ $deed['special_details'] }}</p>
                                </div>
                                @endif
                                @if(isset($deed['tax_info']) && $deed['tax_info'])
                                <div class="md:col-span-2">
                                    <label>খারিজের তথ্য:</label>
                                    <p>{{ $deed['tax_info'] }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @elseif($item['itemType'] === 'inheritance' && isset($inheritanceRecords[$item['itemIndex']]))
                    @php $inheritance = $inheritanceRecords[$item['itemIndex']]; $displayedInheritances[] = $item['itemIndex']; @endphp
                    <div class="mb-6">
                        <h3 class="section-header">ওয়ারিশ মূলে হস্তান্তর তথ্য</h3>
                        <div class="mb-4 p-4 border rounded-lg">
                            <h4 class="subsection-subtitle">ওয়ারিশ #{{ $item['itemIndex'] + 1 }}</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label>পূর্ববর্তী মালিকের নাম: {{ $inheritance['previous_owner_name'] ?? '' }}</label>
                                </div>                             
                                <div>
                                    <label>ওয়ারিশান সনদ দাখিল করা হয়েছে কিনা: {{ isset($inheritance['has_death_cert']) && $inheritance['has_death_cert'] === 'yes' ? 'হ্যাঁ' : 'না' }}</label>
                                </div>
                                <div class="md:col-span-2">
                                    <label>ওয়ারিশ সনদের তথ্য:</label>
                                    <p>{{ $inheritance['heirship_certificate_info'] ?? '' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif($item['itemType'] === 'rs' && isset($rsRecords[$item['itemIndex']]))
                    @php $rs = $rsRecords[$item['itemIndex']]; $displayedRsRecords[] = $item['itemIndex']; @endphp
                    <div class="mb-6">
                            <h3 class="section-header">আরএস রেকর্ড তথ্য</h3>
                        <div class="mb-4 p-4 border rounded-lg">
                            <h4 class="subsection-subtitle">আরএস রেকর্ড #{{ $item['itemIndex'] + 1 }}</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label>আরএস দাগ নম্বর:</label>
                                    <p>{{ $rs['plot_no'] ?? '' }}</p>
                                </div>
                                <div>
                                    <label>আরএস খতিয়ান নম্বর:</label>
                                    <p>{{ $rs['khatian_no'] ?? '' }}</p>
                                </div>
                                <div>
                                    <label>আরএস জমির পরিমাণ:</label>
                                    <p class="text-gray-900">{{ $compensation->bnDigits($rs['land_amount'] ?? '') }}</p>
                                </div>
                                <div class="md:col-span-2">
                                    <label>আরএস মালিকের নাম:</label>
                                    @if(isset($rs['owner_names']))
                                        @foreach($rs['owner_names'] as $owner)
                                            <p>• {{ $owner['name'] ?? '' }}</p>
                                        @endforeach
                                    @elseif(isset($rs['owner_name']))
                                        <p>• {{ $rs['owner_name'] }}</p>
                                    @endif
                                </div>
                                <div>
                                    <label>ডিপি খতিয়ান:</label>
                                    <p>{{ isset($rs['dp_khatian']) && $rs['dp_khatian'] ? 'হ্যাঁ' : 'না' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
            
            <!-- Show any remaining items that weren't in the story sequence -->
            @foreach($deedTransfers as $index => $deed)
                @if(!in_array($index, $displayedDeeds))
                    <div class="mb-6">
                        <h3 class="section-header">দলিল মূলে হস্তান্তর তথ্য</h3>
                        <div class="mb-4 p-4 border rounded-lg">
                            <h4 class="subsection-header">দলিল #{{ $index + 1 }}</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label>দাতার নাম:</label>
                                    @if(isset($deed['donor_names']))
                                        @foreach($deed['donor_names'] as $donor)
                                            <p>• {{ $donor['name'] ?? '' }}</p>
                                        @endforeach
                                    @endif
                                </div>
                                <div>
                                    <label>গ্রহীতার নাম:</label>
                                    @if(isset($deed['recipient_names']))
                                        @foreach($deed['recipient_names'] as $recipient)
                                            <p>• {{ $recipient['name'] ?? '' }}</p>
                                        @endforeach
                                    @endif
                                </div>
                                <div>
                                    <label>দলিল নম্বর:</label>
                                    <p>{{ $deed['deed_number'] ?? '' }}</p>
                                </div>
                                <div>
                                    <label>দলিলের তারিখ:</label>
                                    <p>{{ $deed['deed_date'] ?? '' }}</p>
                                </div>
                                <div>
                                    <label>দলিলের ধরন:</label>
                                    <p>{{ $deed['sale_type'] ?? '' }}</p>
                                </div>

                                <!-- Application Area Fields -->
                                @if(isset($deed['application_type']) && $deed['application_type'])
                                <div>
                                    <label>আবেদনকৃত দাগে সুনির্দিষ্টভাবে বিক্রয়:</label>
                                    <p>{{ $compensation->formatApplicationAreaString($deed) }}</p>
                                </div>
                                @endif
                                @if(isset($deed['possession_mentioned']) && $deed['possession_mentioned'] === 'yes')
                                <div>
                                    <label>দখলের দাগ নম্বর:</label>
                                    <p>{{ $deed['possession_plot_no'] ?? '' }}</p>
                                </div>
                                <div class="md:col-span-2">
                                    <label>দখল এর বর্ণনা:</label>
                                    <p>{{ $deed['possession_description'] ?? '' }}</p>
                                </div>
                                @endif
                                
                                <!-- New Possession Fields -->
                                <div>
                                    <label>দলিলের বিবরণ ও হাতনকশায় আবেদনকৃত দাগে দখল উল্লেখ রয়েছে কিনা?</label>
                                    <p>{{ isset($deed['possession_deed']) && $deed['possession_deed'] === 'yes' ? 'হ্যাঁ' : 'না' }}</p>
                                </div>
                                @if(isset($deed['mentioned_areas']) && $deed['mentioned_areas'])
                                <div>
                                    <label>যে সকল দাগে দখল উল্লেখ করা:</label>
                                    <p>{{ $deed['mentioned_areas'] }}</p>
                                </div>
                                @endif
                                @if(isset($deed['special_details']) && $deed['special_details'])
                                <div class="md:col-span-2">
                                    <label>প্রযোজ্যক্ষেত্রে দলিলের বিশেষ বিবরণ:</label>
                                    <p>{{ $deed['special_details'] }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach

            @foreach($inheritanceRecords as $index => $inheritance)
                @if(!in_array($index, $displayedInheritances))
                    <div class="mb-6">
                        <h3 class="section-header">ওয়ারিশ মূলে হস্তান্তর তথ্য</h3>
                        <div class="mb-4 p-4 border rounded-lg">
                            <h4 class="subsection-subtitle">ওয়ারিশ #{{ $index + 1 }}</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label>পূর্ববর্তী মালিকের নাম: {{ $inheritance['previous_owner_name'] ?? '' }}</label>
                                </div>
                                <div>
                                    <label>ওয়ারিশান সনদ দাখিল করা হয়েছে কিনা: {{ isset($inheritance['has_death_cert']) && $inheritance['has_death_cert'] === 'yes' ? 'হ্যাঁ' : 'না' }}</label>
                                </div>
                                <div class="md:col-span-2">
                                    <label>ওয়ারিশ সনদের তথ্য:</label>
                                    <p>{{ $inheritance['heirship_certificate_info'] ?? '' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach

            @foreach($rsRecords as $index => $rs)
                @if(!in_array($index, $displayedRsRecords))
                    <div class="mb-6">
                        <h3 class="section-header">আরএস রেকর্ড তথ্য</h3>
                        <div class="mb-4 p-4 border rounded-lg">
                            <h4 class="subsection-subtitle">আরএস রেকর্ড #{{ $index + 1 }}</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label>আরএস দাগ নম্বর:</label>
                                    <p>{{ $rs['plot_no'] ?? '' }}</p>
                                </div>
                                <div>
                                    <label>আরএস খতিয়ান নম্বর:</label>
                                    <p>{{ $rs['khatian_no'] ?? '' }}</p>
                                </div>
                                <div>
                                    <label>আরএস জমির পরিমাণ:</label>
                                    <p>{{ $compensation->bnDigits($rs['land_amount'] ?? '') }}</p>
                                </div>
                                <div class="md:col-span-2">
                                    <label>আরএস মালিকের নাম:</label>
                                    @if(isset($rs['owner_names']))
                                        @foreach($rs['owner_names'] as $owner)
                                            <p>• {{ $owner['name'] ?? '' }}</p>
                                        @endforeach
                                    @elseif(isset($rs['owner_name']))
                                        <p>• {{ $rs['owner_name'] }}</p>
                                    @endif
                                </div>
                                <div>
                                    <label>ডিপি খতিয়ান:</label>
                                    <p>{{ isset($rs['dp_khatian']) && $rs['dp_khatian'] ? 'হ্যাঁ' : 'না' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        @else
            <!-- Fallback: Show sections in original order if no story sequence -->
            @if(isset($compensation->ownership_details['deed_transfers']) && count($compensation->ownership_details['deed_transfers']) > 0)
            <div class="mb-6">
                <h3 class="section-header">দলিল মূলে হস্তান্তর তথ্য</h3>
                @foreach($compensation->ownership_details['deed_transfers'] as $index => $deed)
                <div class="mb-4 p-4 border rounded-lg">
                    <h4 class="subsection-subtitle">দলিল #{{ $index + 1 }}</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label>দাতার নাম:</label>
                            @if(isset($deed['donor_names']))
                                @foreach($deed['donor_names'] as $donor)
                                    <p>• {{ $donor['name'] ?? '' }}</p>
                                @endforeach
                            @endif
                        </div>
                        <div>
                            <label>গ্রহীতার নাম:</label>
                            @if(isset($deed['recipient_names']))
                                @foreach($deed['recipient_names'] as $recipient)
                                    <p>• {{ $recipient['name'] ?? '' }}</p>
                                @endforeach
                            @endif
                        </div>
                        <div>
                            <label>দলিল নম্বর:</label>
                            <p>{{ $deed['deed_number'] ?? '' }}</p>
                        </div>
                        <div>
                            <label>দলিলের তারিখ:</label>
                            <p>{{ $deed['deed_date'] ?? '' }}</p>
                        </div>
                        <div>
                            <label>দলিলের ধরন:</label>
                            <p>{{ $deed['sale_type'] ?? '' }}</p>
                        </div>

                        <!-- Application Area Fields -->
                        @if(isset($deed['application_type']) && $deed['application_type'])
                        <div>
                            <label>আবেদনকৃত দাগের সুনির্দিষ্টভাবে বিক্রয়:</label>
                            <p>{{ $compensation->formatApplicationAreaString($deed) }}</p>
                        </div>
                        @endif
                        @if(isset($deed['possession_plot_no']))
                        <div>
                            <label>দখলের দাগ নম্বর:</label>
                            <p>{{ $deed['possession_plot_no'] ?? '' }}</p>
                        </div>
                        @endif
                        @if(isset($deed['possession_description']))
                        <div class="md:col-span-2">
                            <label>দখল এর বর্ণনা:</label>
                            <p>{{ $deed['possession_description'] ?? '' }}</p>
                        </div>
                        @endif
                        
                        <!-- New Possession Fields -->
                        <div>
                            <label>দলিলের বিবরণ ও হাতনকশায় আবেদনকৃত দাগে দখল উল্লেখ রয়েছে কিনা?</label>
                            <p>{{ isset($deed['possession_deed']) && $deed['possession_deed'] === 'yes' ? 'হ্যাঁ' : 'না' }}</p>
                        </div>
                        @if(isset($deed['mentioned_areas']) && $deed['mentioned_areas'])
                        <div>
                            <label>যে সকল দাগে দখল উল্লেখ করা:</label>
                            <p>{{ $deed['mentioned_areas'] }}</p>
                        </div>
                        @endif
                        @if(isset($deed['special_details']) && $deed['special_details'])
                        <div class="md:col-span-2">
                            <label>প্রযোজ্যক্ষেত্রে দলিলের বিশেষ বিবরণ:</label>
                            <p>{{ $deed['special_details'] }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            @if(isset($compensation->ownership_details['inheritance_records']) && count($compensation->ownership_details['inheritance_records']) > 0)
            <div class="mb-6">
                <h3 class="section-header">ওয়ারিশ মূলে হস্তান্তর তথ্য</h3>
                @foreach($compensation->ownership_details['inheritance_records'] as $index => $inheritance)
                <div class="mb-4 p-4 border rounded-lg">
                    <h4 class="subsection-subtitle">ওয়ারিশ #{{ $index + 1 }}</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label>পূর্ববর্তী মালিকের নাম:</label>
                            <p>{{ $inheritance['previous_owner_name'] ?? '' }}</p>
                        </div> 
                        <div class="md:col-span-2">
                            <label>ওয়ারিশ সনদের তথ্য:</label>
                            <p>{{ $inheritance['heirship_certificate_info'] ?? '' }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            @if(isset($compensation->ownership_details['rs_records']) && count($compensation->ownership_details['rs_records']) > 0)
            <div class="mb-6">
                <h3 class="section-header">আরএস রেকর্ড তথ্য</h3>
                @foreach($compensation->ownership_details['rs_records'] as $index => $rs)
                <div class="mb-4 p-4 border rounded-lg">
                    <h4 class="subsection-subtitle">আরএস রেকর্ড #{{ $index + 1 }}</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label>আরএস দাগ নম্বর:</label>
                            <p>{{ $rs['plot_no'] ?? '' }}</p>
                        </div>
                        <div>
                            <label>আরএস খতিয়ান নম্বর:</label>
                            <p>{{ $rs['khatian_no'] ?? '' }}</p>
                        </div>
                        <div>
                            <label>আরএস জমির পরিমাণ:</label>
                            <p>{{ $rs['land_amount'] ?? '' }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <label>আরএস মালিকের নাম:</label>
                            @if(isset($rs['owner_names']))
                                @foreach($rs['owner_names'] as $owner)
                                    <p>• {{ $owner['name'] ?? '' }}</p>
                                @endforeach
                            @elseif(isset($rs['owner_name']))
                                <p>• {{ $rs['owner_name'] }}</p>
                            @endif
                        </div>
                        <div>
                            <label>ডিপি খতিয়ান:</label>
                            <p>{{ isset($rs['dp_khatian']) && $rs['dp_khatian'] ? 'হ্যাঁ' : 'না' }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        @endif

        @if(isset($compensation->ownership_details['applicant_info']))
            @php
                $applicantInfo = $compensation->ownership_details['applicant_info'];
                $hasApplicantData = false;
                
                // Check if any field has actual data
                $fieldsToCheck = [
                    'applicant_name', 'namejari_khatian_no', 'kharij_case_no', 
                    'kharij_plot_no', 'kharij_land_amount', 'kharij_date', 'kharij_details'
                ];
                
                foreach ($fieldsToCheck as $field) {
                    if (!empty($applicantInfo[$field] ?? '')) {
                        $hasApplicantData = true;
                        break;
                    }
                }
            @endphp
            
            @if($hasApplicantData)
            <div class="mb-6">
                <h3 class="section-header">আবেদনকারীর অনুকূলে নামজারির তথ্য</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @if(!empty($applicantInfo['applicant_name'] ?? ''))
                    <div>
                        <label>আবেদনকারীর নাম: {{ $applicantInfo['applicant_name'] }}</label>
                    </div>
                    @endif
                    
                    @if(!empty($applicantInfo['namejari_khatian_no'] ?? ''))
                    <div>
                        <label>নামজারি খতিয়ান নং: {{ $compensation->bnDigits($applicantInfo['namejari_khatian_no']) }}</label>
                    </div>
                    @endif
                    
                    @if(!empty($applicantInfo['kharij_case_no'] ?? ''))
                    <div>
                        <label>খারিজ কেস নম্বর: {{ $compensation->bnDigits($applicantInfo['kharij_case_no']) }}</label>
                    </div>
                    @endif
                    
                    @if(!empty($applicantInfo['kharij_plot_no'] ?? ''))
                    <div>
                        <label>খারিজ দাগ নম্বর: {{ $compensation->bnDigits($applicantInfo['kharij_plot_no']) }}</label>
                    </div>
                    @endif
                    
                    @if(!empty($applicantInfo['kharij_land_amount'] ?? ''))
                    <div>
                        <label>খারিজ জমির পরিমাণ: {{ $compensation->bnDigits($applicantInfo['kharij_land_amount']) }}</label>
                    </div>
                    @endif
                    
                    @if(!empty($applicantInfo['kharij_date'] ?? ''))
                    <div>
                        <label>খারিজের তারিখ: {{ $compensation->bnDigits($applicantInfo['kharij_date']) }}</label>
                    </div>
                    @endif
                    
                    @if(!empty($applicantInfo['kharij_details'] ?? ''))
                    <div class="md:col-span-2">
                        <label>খারিজের বিবরণ:</label>
                        <p>{{ $applicantInfo['kharij_details'] }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        @endif
    </div>
    @endif

    <!-- Tax Information -->
    <h2 class="section-header">খাজনার তথ্য</h2>
    <div class="info-grid-compact">
        <span class="info-item-compact">যার নামে প্রদানকৃত: {{ $compensation->tax_info['paid_in_name'] ?? 'তথ্য নেই' }}</span>
        <span class="info-item-compact">হোল্ডিং নম্বর: {{ $compensation->bnDigits($compensation->tax_info['holding_no'] ?? '') }}</span>
        <span class="info-item-compact">জমির পরিমান: {{ $compensation->bnDigits($compensation->tax_info['paid_land_amount'] ?? '') }} একর</span>
        <span class="info-item-compact">ইংরেজি বছর: {{ $compensation->bnDigits($compensation->tax_info['english_year'] ?? '') }}</span>
        <span class="info-item-compact">বাংলা বছর: {{ $compensation->bnDigits($compensation->tax_info['bangla_year'] ?? '') }}</span>
    </div>

    <!-- Additional Documents -->
    <h2 class="section-header">বণ্টন / না-দাবি / আপসনামা / এফিডেভিটের তথ্য</h2>
    <div class="info-grid-compact">
        @if(isset($compensation->additional_documents_info['selected_types']) && !empty($compensation->additional_documents_info['selected_types']))
        <span class="info-item-compact">ডকুমেন্টের ধরন: {{ implode(', ', $compensation->additional_documents_info['selected_types']) }}</span>
        @else
        <span class="info-item-compact">ডকুমেন্টের ধরন: তথ্য নেই</span>
        @endif
        
        @if(isset($compensation->additional_documents_info['details']) && !empty($compensation->additional_documents_info['details']))
        @foreach($compensation->additional_documents_info['details'] as $type => $details)
        <span class="info-item-compact">{{ $type }}: {{ $details }}</span>
        @endforeach
        @endif
    </div>

    <!-- Kanungo Opinion -->
    @if($compensation->kanungo_opinion)
    <h2 class="section-header">
        কানুনগো/সার্ভেয়ারের মতামত
    </h2>
    <div class="info-grid">
        <div class="info-item">
            <label>মালিকানার ধারাবাহিকতা আছে কিনা:</label>
            <span class="status-badge {{ isset($compensation->kanungo_opinion['has_ownership_continuity']) && $compensation->kanungo_opinion['has_ownership_continuity'] === 'yes' ? 'status-yes' : 'status-no' }}">
                {{ isset($compensation->kanungo_opinion['has_ownership_continuity']) && $compensation->kanungo_opinion['has_ownership_continuity'] === 'yes' ? 'হ্যাঁ' : 'না' }}
            </span>
        </div>
        <div class="info-item">
            <label>মতামতের বিবরণ:</label>
            <span>{{ $compensation->kanungo_opinion['opinion_details'] ?? '' }}</span>
        </div>
    </div>
    @endif

    <!-- Final Order Information -->
    @if($compensation->final_order)
    <h2 class="section-header">
        চূড়ান্ত আদেশ
    </h2>
        
        @if(isset($compensation->final_order['land']) && $compensation->final_order['land']['selected'])
        <div class="mb-4">
            <h3 class="subsection-title">জমি</h3>
            <div class="land-categories">
                @if(isset($compensation->final_order['land']['categories']) && is_array($compensation->final_order['land']['categories']))
                    @foreach($compensation->final_order['land']['categories'] as $index => $category)
                    <div class="category-item">
                        <div class="category-grid">
                            <div class="category-field">
                                <label>জমির শ্রেণী:</label>
                                <span>{{ $category['category_name'] ?? '' }}</span>
                            </div>
                            <div class="category-field">
                                <label>অধিগ্রহণকৃত জমি (একর):</label>
                                <span>{{ $category['acquired_land'] ?? '' }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
        @endif

        @if(isset($compensation->final_order['trees_crops']) && $compensation->final_order['trees_crops']['selected'])
        <div class="mb-4">
            <h3 class="subsection-title">গাছপালা/ফসল</h3>
            <div class="compensation-item">
                <div class="compensation-grid">
                    <div class="compensation-field">
                        <label>ক্ষতিপূরণের ধরন:</label>
                        <span>{{ $compensation->final_order['trees_crops']['compensation_type'] === 'full' ? 'সম্পূর্ণ' : 'আংশিক' }}</span>
                    </div>
                    <div class="compensation-field">
                        <label>ক্ষতিপূরণের পরিমাণ:</label>
                        <span>{{ $compensation->final_order['trees_crops']['amount'] ?? '' }}</span>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(isset($compensation->final_order['infrastructure']) && $compensation->final_order['infrastructure']['selected'])
        <div class="mb-4">
            <h3 class="subsection-title">অবকাঠামো</h3>
            <div class="compensation-item">
                <div class="compensation-grid">
                    <div class="compensation-field">
                        <label>ক্ষতিপূরণের ধরন:</label>
                        <span>{{ $compensation->final_order['infrastructure']['compensation_type'] === 'full' ? 'সম্পূর্ণ' : 'আংশিক' }}</span>
                    </div>
                    <div class="compensation-field">
                        <label>ক্ষতিপূরণের পরিমাণ:</label>
                        <span>{{ $compensation->final_order['infrastructure']['amount'] ?? '' }}</span>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
    @endif

    <!-- Order Information - Case Completion Status -->
    @if($compensation->order_signature_date)
    <h2 class="section-header">
        আদেশ তথ্য - কেস নিষ্পত্তিকৃত
    </h2>
        <div class="completion-status">
            <div class="status-indicator">
                <span class="status-icon">✓</span>
                <span class="status-text">এই ক্ষতিপূরণ কেসটি নিষ্পত্তিকৃত হয়েছে</span>
            </div>
        </div>
        <div class="info-grid">
            <div class="info-item">
                <label>আদেশ স্বাক্ষরের তারিখ:</label>
                <span>{{ $compensation->order_signature_date }}</span>
            </div>
            <div class="info-item">
                <label>স্বাক্ষরকারী কর্মকর্তার নাম:</label>
                <span>{{ $compensation->signing_officer_name ?? 'তথ্য নেই' }}</span>
            </div>
        </div>
        
        @if($compensation->order_comment && !empty($compensation->order_comment))
        <div class="info-item full-width">
            <label>মন্তব্য:</label>
            <span class="comment-text">{{ $compensation->order_comment }}</span>
        </div>
        @endif
    </div>
    @endif

    <!-- Mutation Information -->
    @if($compensation->mutation_info)
    <h2 class="section-header">
        নামজারির তথ্য
    </h2>
    <div class="info-grid">
        <div class="info-item">
            <label>নামজারি আছে কিনা:</label>
            <span class="status-badge {{ isset($compensation->mutation_info['has_mutation']) && $compensation->mutation_info['has_mutation'] ? 'status-yes' : 'status-no' }}">
                {{ isset($compensation->mutation_info['has_mutation']) && $compensation->mutation_info['has_mutation'] ? 'হ্যাঁ' : 'না' }}
            </span>
        </div>
        @if(isset($compensation->mutation_info['has_mutation']) && $compensation->mutation_info['has_mutation'])
        <div class="info-item">
            <label>নামজারির ধরন:</label>
            <span>{{ $compensation->mutation_info['mutation_type'] ?? '' }}</span>
        </div>
        <div class="info-item">
            <label>নামজারির তারিখ:</label>
            <span>{{ $compensation->mutation_info['mutation_date'] ?? '' }}</span>
        </div>
        <div class="info-item">
            <label>নামজারির বিবরণ:</label>
            <span>{{ $compensation->mutation_info['mutation_details'] ?? '' }}</span>
        </div>
        @endif
    </div>
    @endif

    <!-- Order Details -->
    @if($compensation->order_signature_date || $compensation->signing_officer_name)
    <h2 class="section-header">
        আদেশের তথ্য
    </h2>
    <div class="info-grid">
        @if($compensation->order_signature_date)
        <div class="info-item">
            <label>আদেশ স্বাক্ষরের তারিখ:</label>
            <span>{{ $compensation->order_signature_date }}</span>
        </div>
        @endif
        @if($compensation->signing_officer_name)
        <div class="info-item">
            <label>স্বাক্ষরকারী কর্মকর্তার নাম:</label>
            <span>{{ $compensation->signing_officer_name }}</span>
        </div>
        @endif
    </div>
    @endif

    <!-- Former and Current Plot Information -->
    @if($compensation->former_plot_no || $compensation->current_plot_no)
    <h2 class="section-header">
        দাগ নম্বরের তথ্য
    </h2>
    <div class="info-grid">
        @if($compensation->former_plot_no)
        <div class="info-item">
            <label>পূর্ববর্তী দাগ নম্বর:</label>
            <span>{{ $compensation->former_plot_no }}</span>
        </div>
        @endif
        @if($compensation->current_plot_no)
        <div class="info-item">
            <label>বর্তমান দাগ নম্বর:</label>
            <span>{{ $compensation->current_plot_no }}</span>
        </div>
        @endif
    </div>
    @endif

    <!-- Application Analysis -->
    <h2 class="section-header">
        আবেদনপত্র বিশ্লেষণ
    </h2>
        <div class="space-y-4">
            <!-- Application Type -->
            <div class="analysis-item">
                <p class="analysis-text">
                    আবেদনকারী 
                    @if($compensation->award_type )
                    {{ is_array($compensation->award_type) ? implode(', ', $compensation->award_type) : $compensation->award_type }}
                    @endif
                    ক্ষতিপূরণের জন্য আবেদন করেছেন।
                </p>
            </div>

            <!-- Combined Applicant and Award Info -->
            <div class="analysis-item">
                <p class="analysis-text">
                    আবেদনকারী 
                    @if($compensation->applicants && is_array($compensation->applicants))
                        {{ $compensation->bnDigits(count($compensation->applicants)) }} জন।
                    @else
                        ১ জন।
                    @endif
                    রোয়েদাদভুক্ত মালিক 
                    @if($compensation->award_holder_names && is_array($compensation->award_holder_names))
                        {{ $compensation->bnDigits(count($compensation->award_holder_names)) }} জন।
                    @else
                        ১ জন।
                    @endif
                    আবেদনকারীর নাম রোয়েদাদে 
                    @if($compensation->is_applicant_in_award)
                        আছে।
                    @else
                        নাই।
                    @endif
                </p>
            </div>

            <!-- Settlement Distribution Logic -->
            <div class="analysis-item">
                <p class="analysis-text">
                    @if($compensation->award_holder_names && is_array($compensation->award_holder_names) && count($compensation->award_holder_names) == 1 && $compensation->is_applicant_in_award)
                        রোয়েদাদভুক্ত মালিক ১ জন বিধায় আপসবন্টন/ না-দাবীনামা প্রয়োজন নেই।
                    @elseif($compensation->award_holder_names && is_array($compensation->award_holder_names) && count($compensation->award_holder_names) > 1)
                    রোয়েদাদভুক্ত মালিক একাধিক বিধায়- আপসবন্টন/ না-দাবী/ সরেজমিন দখল প্রতিবেদন প্রয়োজন।
                    @else
                        রোয়েদাদভুক্ত মালিকের সংখ্যা নির্ধারণ করা যায়নি।
                    @endif
                </p>
            </div>

            <!-- Settlement/No Claim Documents -->
            <div class="analysis-item">
                <p class="analysis-text">
                    @php
                        $hasSettlementOrNoClaim = $compensation->additional_documents_info && 
                                                isset($compensation->additional_documents_info['selected_types']) && 
                                                is_array($compensation->additional_documents_info['selected_types']) &&
                                                (in_array('আপস- বন্টননামা', $compensation->additional_documents_info['selected_types']) || 
                                                 in_array('না-দাবি', $compensation->additional_documents_info['selected_types']));
                    @endphp
                    
                    @if($hasSettlementOrNoClaim)
                        আপসবন্টন নামা/ না- দাবীনামা দাখিল করা হয়েছে
                    @else
                        আপসবন্টন নামা/ না- দাবীনামা দাখিল করা হয়নাই
                    @endif
                </p>
            </div>

            <!-- Mutation Status -->
            @if(isset($compensation->ownership_details['applicant_info']['kharij_case_no']) && !empty($compensation->ownership_details['applicant_info']['kharij_case_no']))
            <div class="analysis-item">
                <p class="analysis-text">
                    আবেদনকারীর নামে উল্লিখিত দাগে খারিজ করা আছে
                </p>
            </div>
            @else
            <div class="analysis-item">
                <p class="analysis-text">
                    আবেদনকারীর নামে উল্লিখিত দাগে খারিজ করা নেই
                </p>
            </div>
            @endif
            @if( isset($compensation->tax_info['paid_in_name']) && !empty($compensation->tax_info['paid_in_name']))
            <div class="analysis-item">
                <p class="analysis-text">
                    {{ $compensation->tax_info['paid_in_name'] }} নামে খাজনা প্রদান করা হয়েছে
                </p>
            </div>
            @endif

            <!-- Tax Receipt Status -->
            <div class="analysis-item">
                <p class="analysis-text">
                    @php
                        $hasTaxInfo = $compensation->tax_info && 
                                     isset($compensation->tax_info['english_year']) && 
                                     !empty($compensation->tax_info['english_year']) &&
                                     isset($compensation->tax_info['bangla_year']) && 
                                     !empty($compensation->tax_info['bangla_year']) &&
                                     isset($compensation->tax_info['paid_land_amount']) && 
                                     !empty($compensation->tax_info['paid_land_amount']);
                    @endphp
                    
                    @if($hasTaxInfo)
                        ইংরেজি {{ $compensation->tax_info['english_year'] }} এবং বাংলা {{ $compensation->tax_info['bangla_year'] }} সন পর্যন্ত {{ $compensation->bnDigits($compensation->tax_info['paid_land_amount']) }} একর জমির খাজনা পরিশোধ করা হয়েছে।
                    @else
                        উল্লিখিত দাগে খাজনার রশিদ দাখিল করা হয়নাই
                    @endif
                </p>
            </div>

            <!-- Deed Information -->
            @if($compensation->ownership_details && isset($compensation->ownership_details['deed_transfers']) && count($compensation->ownership_details['deed_transfers']) > 0)
            <div class="analysis-item">
                <p class="analysis-text">
                    @foreach($compensation->ownership_details['deed_transfers'] as $deed)
                        @if(isset($deed['deed_number']) && !empty($deed['deed_number']))
                            আবেদনকারীর দাখিলকৃত দলিল নং {{ $deed['deed_number'] }} তে উল্লিখিত দাগে দখল উল্লেখ করা 
                            @if(isset($deed['possession_deed']) && $deed['possession_deed'] === 'yes')
                                রয়েছে
                            @else
                                নাই
                            @endif
                            ।<br>
                        @endif
                    @endforeach
                </p>
            </div>
            @endif

            <!-- Land Compensation Claim Based on Land Categories -->
            @if($compensation->land_category && is_array($compensation->land_category) && count($compensation->land_category) > 0)
            <div class="analysis-item">
                @foreach($compensation->land_category as $index => $category)
                    @if($category['total_land'] && $category['total_compensation'])
                    <p class="analysis-text mb-2">
                        আবেদনকারী উল্লিখিত দাগে <strong>{{ $compensation->bnDigits($category['category_name'] ?? '') }}</strong> জমি শ্রেণীর অধিগ্রহণকৃত {{ $compensation->bnDigits($category['total_land']) }} একর জমির মোট ক্ষতিপূরণ {{ $compensation->bnDigits($category['total_compensation']) }}
                    </p>
                    @endif
                @endforeach
            </div>
            @endif

            <!-- Acquisition Record Basis -->
            <div class="analysis-item">
                <p class="analysis-text">
                    {{ $compensation->acquisition_record_basis ?? 'এসএ/ আরএস' }} রেকর্ডমূলে অধিগ্রহণ।
                </p>
            </div>
            @if($compensation->acquisition_record_basis === 'SA' && $compensation->ownership_details && isset($compensation->ownership_details['rs_records']) && count($compensation->ownership_details['rs_records']) > 0)
            <div class="analysis-item">
                <p class="analysis-text">
                        এস এ রেকর্ডমূলে অধিগ্রহন, আর এস এর তথ্যও দাখিল করা হএছে।
                </p>
            </div>
            @elseif($compensation->acquisition_record_basis === 'SA' && (!$compensation->ownership_details || !isset($compensation->ownership_details['rs_records']) || count($compensation->ownership_details['rs_records']) == 0))
            <div class="analysis-item">
                <p class="analysis-text">
                        এস এ রেকর্ডমূলে অধিগ্রহণ, কিন্তু আরএস রেকর্ডের তথ্য দাখিল করা হয়নি।
                </p>
            </div>
            @endif
            <!-- Objection Status -->
            <div class="analysis-item">
                <p class="analysis-text">
                    রোয়েদাদে আপত্তি দাখিল 
                    @if($compensation->objector_details)
                        আছে।
                    @else
                        নাই।
                    @endif
                </p>
            </div>
        </div>
    </div>

    <!-- Case Information Section -->
    @if($compensation->case_information && !empty($compensation->case_information))
    <h2 class="section-header">
        মামলার তথ্য
    </h2>
    <div class="analysis-item">
        <p class="analysis-text">
            {{ $compensation->case_information }}
        </p>
    </div>
    @endif

    <!-- General Comments Section -->
    @if($compensation->general_comments && !empty($compensation->general_comments))
    <h2 class="section-header">
        মন্তব্য
    </h2>
    <div class="analysis-item">
        <p class="analysis-text">
            {{ $compensation->general_comments }}
        </p>
    </div>
    @endif

    
</div>

<style>
/* PDF-optimized styles matching preview page */
body {
    font-family: 'Tiro Bangla', serif;
    line-height: 1.5;
    color: #111827;
    margin: 0;
    padding: 0;
    background-color: #f9fafb;
}

/* Container matching preview page */
.container-pdf {
    max-width: 100%;
    margin: 0 auto;
    padding: 20px;
    background-color: #f9fafb;
}

/* Header section matching preview */
.header-section {
    background: white;
    border-radius: 8px;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
    border: 1px solid #e5e7eb;
    padding: 20px;
    margin-bottom: 20px;
    text-align: center;
}

.main-title {
    font-size: 28px;
    font-weight: bold;
    color: #1f2937;
    margin: 0 0 20px 0;
    border-bottom: 2px solid #3b82f6;
    padding-bottom: 15px;
}

.case-summary {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
    margin-top: 20px;
}

.summary-item {
    text-align: center;
    padding: 15px;
    background: #f8fafc;
    border-radius: 6px;
    border: 1px solid #e2e8f0;
}

.summary-label {
    display: block;
    font-weight: 600;
    color: #4b5563;
    font-size: 14px;
    margin-bottom: 5px;
}

.summary-value {
    color: #1f2937;
    font-size: 16px;
    font-weight: 600;
}

/* Section headers matching preview page */
h2 {
    font-size: 20px;
    font-weight: 600;
    margin: 20px 0 15px 0;
    color: #2563eb;
    border-bottom: 2px solid #bfdbfe;
    padding-bottom: 8px;
}

h3 {
    font-size: 18px;
    font-weight: 600;
    margin: 15px 0 10px 0;
    color: #059669;
}

/* Continuous layout styling */
.section-header {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    padding: 15px 20px;
    margin: 25px 0 15px 0;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
    color: #2563eb;
    border-bottom: 2px solid #bfdbfe;
    page-break-after: avoid;
    break-after: avoid;
}

/* Content spacing for continuous layout */
.section-header + div,
.section-header + section {
    margin-top: 15px;
    margin-bottom: 20px;
}

/* Ensure proper content flow */
.info-grid-compact,
.info-grid,
.applicant-info-compact,
.holder-info-compact,
.land-schedule-info,
.story-sequence,
.info-grid {
    margin-bottom: 20px;
}

/* Compact grids */
.grid-pdf {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 8px;
}
label,p {
    font-size: 14px
}
.grid-pdf-2 {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 8px;
}

.grid-pdf-3 {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 8px;
}

/* Info grid matching preview page */
.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 15px;
    margin-top: 15px;
}

.info-item {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.info-item label {
    font-weight: 600;
    color: #374151;
    font-size: 14px;
    margin-bottom: 4px;
}

.info-item span {
    color: #111827;
    font-size: 14px;
    padding: 6px 0;
    line-height: 1.5;
}

/* Status badges matching preview page */
.status-badge {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 600;
    text-align: center;
    min-width: 70px;
    border: 1px solid transparent;
}

.status-yes {
    background: #dcfce7;
    color: #166534;
    border-color: #bbf7d0;
}

.status-no {
    background: #fef2f2;
    color: #991b1b;
    border-color: #fecaca;
}

/* Compact form fields */
.field-pdf {
    margin-bottom: 6px;
}

.field-pdf label {
    font-weight: 600;
    color: #4b5563;
    font-size: 13px;
    display: block;
    margin-bottom: 2px;
}

.field-pdf p {
    margin: 0;
    color: #111827;
    font-size: 13px;
    padding: 2px 0;
}

/* Applicant sections matching preview page */
.applicant-card {
    border: 1px solid #e5e7eb;
    border-radius: 6px;
    padding: 15px;
    margin-bottom: 15px;
    background: #f9fafb;
}

.applicant-title {
    font-size: 16px;
    font-weight: 600;
    color: #374151;
    margin: 0 0 10px 0;
    border-bottom: 1px solid #d1d5db;
    padding-bottom: 5px;
}

.applicant-info {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.info-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
}

.info-col {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.info-col.full-width {
    grid-column: 1 / -1;
}

.info-col label {
    font-weight: 600;
    color: #374151;
    font-size: 14px;
}

.info-col span {
    color: #111827;
    font-size: 14px;
    padding: 4px 0;
}

/* Award holders matching preview page */
.holder-card {
    border: 1px solid #e5e7eb;
    border-radius: 6px;
    padding: 15px;
    margin-bottom: 15px;
    background: #f9fafb;
}

.holder-title {
    font-size: 16px;
    font-weight: 600;
    color: #374151;
    margin: 0 0 10px 0;
    border-bottom: 1px solid #d1d5db;
    padding-bottom: 5px;
}

.holder-info {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

/* Tables matching preview page */
.data-table {
    width: 100%;
    border-collapse: collapse;
    margin: 15px 0;
    background: white;
    border-radius: 6px;
    overflow: hidden;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
}

.data-table th,
.data-table td {
    border: 1px solid #e5e7eb;
    padding: 12px;
    font-size: 14px;
    text-align: left;
}

.data-table th {
    background: #f8fafc;
    font-weight: 600;
    color: #374151;
    border-bottom: 2px solid #e5e7eb;
}

.data-table tr:nth-child(even) {
    background: #f9fafb;
}

.data-table tr:hover {
    background: #f3f4f6;
}

/* Compact status indicators */
.status-pdf {
    display: inline-block;
    padding: 2px 6px;
    border-radius: 3px;
    font-size: 11px;
    font-weight: 600;
}

.status-yes {
    background: #dcfce7;
    color: #166534;
    border: 1px solid #bbf7d0;
}

.status-no {
    background: #fef2f2;
    color: #991b1b;
    border: 1px solid #fecaca;
}

/* Compact spacing utilities */
.mb-2 { margin-bottom: 8px; }
.mb-3 { margin-bottom: 12px; }
.mb-4 { margin-bottom: 16px; }
.mb-5 { margin-bottom: 20px; }

.p-2 { padding: 8px; }
.p-3 { padding: 12px; }
.p-4 { padding: 16px; }

/* Page break controls */
.page-break {
    page-break-before: always;
}

.avoid-break {
    page-break-inside: avoid;
}

/* Print optimizations */
@media print {
    .section-header {
        break-after: avoid;
        page-break-after: avoid;
    }
    
    h2, h3, h4 {
        break-after: avoid;
        page-break-after: avoid;
    }
    
    /* Keep content with headers */
    .section-header + div {
        break-inside: avoid;
        page-break-inside: avoid;
    }
}

/* Final compact optimizations */
.container-pdf {
    padding: 15px;
}

/* Spacing between sections */
.section-header + .section-header {
    margin-top: 20px;
}

/* Compact story sequence */
.story-item {
    padding: 6px;
    margin-bottom: 6px;
}

.story-number {
    width: 20px;
    height: 20px;
    line-height: 20px;
    font-size: 11px;
}

/* Compact tables */
.data-table {
    margin: 10px 0;
}

.data-table th,
.data-table td {
    padding: 6px;
    font-size: 12px;
}



/* Analysis section matching preview page */
.analysis-item {
    padding: 16px;
    background: #f9fafb;
    border-radius: 8px;
    border: 1px solid #e5e7eb;
    margin-bottom: 12px;
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
}

.analysis-text {
    margin: 0;
    color: #111827;
    font-size: 14px;
    line-height: 1.5;
}

/* Ensure consistent styling for all analysis items */
.analysis-item p {
    margin: 0;
    color: #111827;
    font-size: 14px;
    line-height: 1.5;
}

.analysis-item strong {
    color: #1f2937;
    font-weight: 600;
}

/* Award summary matching preview page */
.award-summary {
    margin: 15px 0;
}

.summary-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
    margin-top: 15px;
}

.summary-box {
    background: #f8fafc;
    padding: 15px;
    border-radius: 6px;
    border: 1px solid #e2e8f0;
    text-align: center;
}

.summary-box label {
    display: block;
    font-weight: 600;
    color: #4b5563;
    font-size: 13px;
    margin-bottom: 8px;
}

.highlight-value {
    color: #1f2937;
    font-size: 16px;
    font-weight: 600;
}

/* Subsection titles matching preview page */
.subsection-title {
    font-size: 16px;
    font-weight: 600;
    color: #059669;
    margin: 15px 0 10px 0;
    border-bottom: 1px solid #d1fae5;
    padding-bottom: 5px;
}

.subsection-subtitle {
    font-size: 14px;
    font-weight: 600;
    color: #374151;
    margin: 10px 0 5px 0;
}

/* Section label matching preview page */
.section-label {
    font-weight: 600;
    color: #4b5563;
    font-size: 13px;
    display: block;
    margin-bottom: 8px;
}

/* Story sequence matching preview page */
.story-sequence {
    margin-top: 10px;
}

.story-item {
    display: flex;
    align-items: flex-start;
    margin-bottom: 10px;
    padding: 8px;
    background: #eff6ff;
    border-radius: 6px;
    border-left: 4px solid #3b82f6;
}

.story-number {
    width: 24px;
    height: 24px;
    background: #3b82f6;
    color: white;
    border-radius: 50%;
    text-align: center;
    line-height: 24px;
    font-size: 12px;
    font-weight: bold;
    margin-right: 10px;
    flex-shrink: 0;
}

.story-content {
    flex: 1;
}

.story-type {
    font-weight: 600;
    color: #1e40af;
    font-size: 13px;
    margin-bottom: 2px;
}

.story-description {
    color: #6b7280;
    font-size: 12px;
}

.owner-item {
    margin: 4px 0;
    color: #111827;
    font-size: 13px;
}

.no-data {
    color: #dc2626;
    font-style: italic;
    font-size: 13px;
}

/* Document types matching preview page */
.document-types {
    margin-top: 8px;
}

.document-type-badge {
    display: inline-block;
    background: #dbeafe;
    color: #1e40af;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 11px;
    margin-right: 6px;
    margin-bottom: 6px;
}

.document-detail {
    margin-top: 12px;
    padding: 8px;
    border: 1px solid #e5e7eb;
    border-radius: 6px;
    background: #f9fafb;
}

.document-type-title {
    font-size: 13px;
    font-weight: 600;
    color: #374151;
    margin: 0 0 5px 0;
}

.document-description {
    margin: 0;
    color: #111827;
    font-size: 12px;
    line-height: 1.4;
}

/* Land categories matching preview page */
.land-categories {
    margin-top: 10px;
}

.category-item {
    background: #f9fafb;
    padding: 8px;
    border-radius: 6px;
    border: 1px solid #e5e7eb;
    margin-bottom: 8px;
}

.category-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 8px;
}

.category-field {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.category-field label {
    font-weight: 600;
    color: #4b5563;
    font-size: 12px;
}

.category-field span {
    color: #111827;
    font-size: 12px;
}

.compensation-item {
    background: #f9fafb;
    padding: 8px;
    border-radius: 6px;
    border: 1px solid #e5e7eb;
}

.compensation-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 8px;
}

.compensation-field {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.compensation-field label {
    font-weight: 600;
    color: #4b5563;
    font-size: 12px;
}

.compensation-field span {
    color: #111827;
    font-size: 12px;
}

.completion-status {
    margin: 15px 0;
    padding: 12px;
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    border-radius: 8px;
}

.status-indicator {
    display: flex;
    align-items: center;
    gap: 8px;
}

.status-icon {
    width: 20px;
    height: 20px;
    background: #16a34a;
    color: white;
    border-radius: 50%;
    text-align: center;
    line-height: 20px;
    font-size: 12px;
    font-weight: bold;
}

.status-text {
    font-size: 14px;
    font-weight: 600;
    color: #166534;
}

/* Summary section styles */
.summary-content {
    margin-top: 15px;
}

.summary-item {
    margin-bottom: 20px;
    padding: 15px;
    background: #f8fafc;
    border-radius: 8px;
    border-left: 4px solid #3b82f6;
}

/* Compact styles for reduced page count */
.case-summary {
    display: flex;
    gap: 20px;
    justify-content: center;
    flex-wrap: wrap;
}

.case-summary .summary-item {
    margin: 0;
    padding: 8px 12px;
    background: #f8fafc;
    border-radius: 6px;
    border: 1px solid #e2e8f0;
    font-size: 14px;
    font-weight: 500;
}

.info-grid-compact {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 8px;
    margin-top: 10px;
}

.info-item-compact {
    padding: 6px 8px;
    background: #f9fafb;
    border-radius: 4px;
    border: 1px solid #e5e7eb;
    font-size: 13px;
    color: #374151;
}

.applicant-card-compact {
    border: 1px solid #e5e7eb;
    border-radius: 6px;
    padding: 10px;
    margin-bottom: 10px;
    background: #f9fafb;
}

.applicant-title-compact {
    font-size: 14px;
    font-weight: 600;
    color: #374151;
    margin: 0 0 8px 0;
    border-bottom: 1px solid #d1d5db;
    padding-bottom: 4px;
}

.applicant-info-compact {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 6px;
}

.holder-card-compact {
    border: 1px solid #e5e7eb;
    border-radius: 6px;
    padding: 10px;
    margin-bottom: 10px;
    background: #f9fafb;
}

.holder-title-compact {
    font-size: 14px;
    font-weight: 600;
    color: #374151;
    margin: 0 0 8px 0;
    border-bottom: 1px solid #d1d5db;
    padding-bottom: 4px;
}

.holder-info-compact {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 6px;
}

/* Continuous layout spacing */
.section-header {
    margin: 25px 0 15px 0;
    padding: 15px 20px;
}

.section-header {
    margin: 15px 0 10px 0;
    padding-bottom: 6px;
}

.subsection-title {
    margin: 12px 0 8px 0;
    padding-bottom: 4px;
}

/* Compact table styles */
.data-table th,
.data-table td {
    padding: 8px;
    font-size: 13px;
}

/* Compact analysis items */
.analysis-item {
    padding: 12px;
    margin-bottom: 8px;
}

.analysis-text {
    font-size: 14px;
    line-height: 1.5;
}

/* Additional compact spacing */
.space-y-4 > * + * {
    margin-top: 8px;
}

/* Reduce main title size */
.main-title {
    font-size: 24px;
    margin: 0 0 15px 0;
    padding-bottom: 10px;
}

/* Reduce header section padding */
.header-section {
    padding: 15px;
    margin-bottom: 15px;
}

/* Transfer summary compact styles */
.transfer-summary {
    border: 1px solid #e5e7eb;
    border-radius: 6px;
    padding: 10px;
    margin-bottom: 10px;
    background: #f9fafb;
}

.transfer-title {
    font-size: 14px;
    font-weight: 600;
    color: #374151;
    margin: 0 0 8px 0;
    border-bottom: 1px solid #d1d5db;
    padding-bottom: 4px;
}

.transfer-info-compact {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 6px;
}

.summary-title {
    font-size: 16px;
    font-weight: 600;
    color: #1e40af;
    margin: 0 0 10px 0;
    border-bottom: 1px solid #d1d5db;
    padding-bottom: 5px;
}

.summary-text {
    margin: 0;
    color: #374151;
    font-size: 14px;
    line-height: 1.5;
}

.recommendations {
    margin-top: 10px;
}

.recommendation-item {
    margin: 8px 0;
    padding: 8px 12px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 500;
}

.recommendation-item.positive {
    background: #dcfce7;
    color: #166534;
    border-left: 3px solid #16a34a;
}

.recommendation-item.negative {
    background: #fef2f2;
    color: #991b1b;
    border-left: 3px solid #dc2626;
}

.recommendation-item.warning {
    background: #fef3c7;
    color: #92400e;
    border-left: 3px solid #f59e0b;
}
</style>
@endsection 