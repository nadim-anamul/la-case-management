@extends('layouts.app')

@section('title', 'চুড়ান্ত অর্ডারশিট প্রিভিউ')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Back Button and Actions -->
    <div class="mb-6 flex justify-between items-center">
        <a href="{{ route('compensation.preview', $compensation->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-bold rounded">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            ফিরে যান
        </a>
        <div class="flex space-x-3">
            <a href="{{ route('compensation.final-order.pdf', $compensation->id) }}" target="_blank" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow-lg hover:shadow-xl transition-all duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                PDF ডাউনলোড করুন
            </a>
        </div>
    </div>

    @if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
        {{ session('error') }}
    </div>
    @endif

    <!-- Present Content -->
    <div class="bg-white w-[21cm] min-h-[29.7cm] mx-auto my-8 p-10 shadow-lg text-[16px] leading-8">
        <!-- Title -->
        <h1 class="text-center text-lg font-bold">আদেশ পত্র</h1>
        <p class="text-center text-sm mb-4">( ১৯১৭ সালের রেকর্ড ম্যানুয়েলের ১২৯ নং বিধি )</p>

        <!-- Date Row -->
        <div class="flex justify-between mb-1">
          <span>আদেশ পত্র তারিখ: ...........................................</span>
          <span>হইতে: ........................................................ পর্যন্ত</span>
        </div>

        <!-- Region Row -->
        <div class="flex justify-between mb-1">
          <span>জেলা: {{ $compensation->district ?? '…………………………….' }}</span>
          <span>সাল: …………………………. পর্যন্ত</span>
        </div>

        <!-- Case Info -->
        <div class="flex justify-between mb-1">
          <span>মামলার ধরন: ক্ষতিপূরণ কেস নং: {{ $compensation->case_number ?? 'N/A' }}</span> 
          <span>এল.এ কেস: {{ $compensation->la_case_no ?? 'N/A' }}</span>
        </div>

        <!-- Orders Table with wide second column -->
        <table class="w-full border border-black border-collapse mb-6">
          <thead>
            <tr>
              <th class="border border-black p-2 w-[25mm]">আদেশের ক্রমিক নং ও তারিখ</th>
              <th class="border border-black p-2">আদেশ ও অফিসারের স্বাক্ষর</th>
              <th class="border border-black p-2 w-[25mm]">আদেশের উপর গৃহীত ব্যবস্থা</th>
            </tr>
          </thead>
          <tbody>
            <tr class="align-top">
              <td class="border border-black p-4 h-[90mm]"></td>
              <td class="border border-black p-4">
                <div class="text-justify leading-relaxed">
                  নথি আদেশের জন্য নেওয়া হলো। প্রার্থীর বক্তব্য, দাখিলকৃত কাগজপত্র, সার্ভেয়ার ও কানুনগো এর যৌথ স্বাক্ষরিত প্রতিবেদনসহ সংশ্লিষ্ট রেকর্ডপত্র পর্যালোচনা করা হলো।
                </div>
                
                <div class="text-justify leading-relaxed mt-4">
                  নথি পর্যালোচনায় দেখা যায় যে, 
                  @if($compensation->applicants && is_array($compensation->applicants) && count($compensation->applicants) > 0)
                      @foreach($compensation->applicants as $index => $applicant)
                          @if($index > 0)
                              , 
                          @endif
                          প্রার্থী {{ $index + 1 }} {{ $applicant['name'] ?? '…………………………….' }}, পিং {{ $applicant['father_name'] ?? '…………………………….' }}, সাং: {{ $applicant['address'] ?? '…………………………….' }}
                      @endforeach
                  @else
                      প্রার্থী …………………………., পিং …………………………., সাং: ………………………….
                  @endif
                  , উপজেলা: {{ $compensation->upazila ?? '…………………………….' }}, জেলা: {{ $compensation->district ?? '…………………………….' }}, {{ $compensation->la_case_no ?? '…………………………….' }} নং এল.এ কেসে অধিগ্রহণকৃত {{ $compensation->mouza_name ?? '…………………………….' }}/{{ $compensation->jl_no ?? '…………………………….' }} মৌজার 
                  @if($compensation->acquisition_record_basis === 'SA')
                      এসএ রেকর্ডমূলে অধিগ্রহণ
                  @elseif($compensation->acquisition_record_basis === 'RS')
                      আরএস রেকর্ডমূলে অধিগ্রহণ
                  @else
                      ………………………….
                  @endif
                  {{ $compensation->acquisition_record_basis === 'SA' ? ($compensation->sa_khatian_no ?? '…………………………….' ) : ($compensation->rs_khatian_no ?? '…………………………….' ) }} নং খতিয়ানের 
                  {{ $compensation->acquisition_record_basis === 'SA' ? ($compensation->land_schedule_sa_plot_no ?? '…………………………….' ) : ($compensation->land_schedule_rs_plot_no ?? '…………………………….' ) }} নং দাগের 
                  @if($compensation->award_type && is_array($compensation->award_type) && count($compensation->award_type) > 0)
                      @foreach($compensation->award_type as $index => $type)
                          @if($index > 0)
                              @if($index == count($compensation->award_type) - 1)
                                  এবং {{ $type }}
                              @else
                                  , {{ $type }}
                              @endif
                          @else
                              {{ $type }}
                          @endif
                      @endforeach
                  @else
                      ………………………….
                  @endif
                  এর ক্ষতিপূরণ দাবী করে আবেদন করেছেন।
                </div>
                
                <div class="text-justify leading-relaxed mt-4">
                  রোয়েদাদের বর্ণনাঃ রোয়েদাদ বহি পর্যালোচনা করে দেখা যায়, 
                  
                  @if($compensation->award_type && is_array($compensation->award_type) && in_array('জমি', $compensation->award_type))
                      জমির রোয়েদাদের 
                      @if($compensation->land_award_serial_no)
                          {{ str_pad((string)$compensation->land_award_serial_no, 6, '0', STR_PAD_LEFT) }} নং ক্রমিকে
                      @else
                          …………………………. নং ক্রমিকে
                      @endif
                      {{ $compensation->mouza_name ?? '…………………………….' }}/{{ $compensation->jl_no ?? '…………………………….' }} মৌজার 
                      @if($compensation->acquisition_record_basis === 'SA')
                          {{ $compensation->land_schedule_sa_plot_no ?? '…………………………….' }}
                      @elseif($compensation->acquisition_record_basis === 'RS')
                          {{ $compensation->land_schedule_rs_plot_no ?? '…………………………….' }}
                      @else
                          {{ $compensation->plot_no ?? '…………………………….' }}
                      @endif
                      নং দাগের 
                      @if($compensation->land_category && is_array($compensation->land_category))
                          @php
                              $totalLand = collect($compensation->land_category)->sum(function($category) {
                                  return floatval($category['total_land'] ?? 0);
                              });
                          @endphp
                          {{ number_format($totalLand, 4) }}
                      @else
                          ………………………….
                      @endif
                      একর জমির রোয়েদাদ 
                      @if($compensation->award_holder_names && is_array($compensation->award_holder_names))
                          @foreach($compensation->award_holder_names as $index => $holder)
                              @if($index > 0), @endif
                              {{ $holder['name'] ?? '…………………………….' }} ({{ $holder['father_name'] ?? '…………………………….' }})
                          @endforeach
                      @else
                          ………………………….
                      @endif
                      , সাং নিজ নামে রোয়েদাদ প্রস্তুত আছে।
                      @if($compensation->award_type && is_array($compensation->award_type) && in_array('গাছপালা/ফসল', $compensation->award_type))
                          <br><br>
                      @endif
                  @endif
                  
                  @if($compensation->award_type && is_array($compensation->award_type) && in_array('গাছপালা/ফসল', $compensation->award_type))
                      গাছপালার/ফসলের রোয়েদাদের 
                      @if($compensation->tree_award_serial_no)
                          {{ str_pad((string)$compensation->tree_award_serial_no, 6, '0', STR_PAD_LEFT) }} নং ক্রমিকে
                      @else
                          …………………………. নং ক্রমিকে
                      @endif
                      @if($compensation->tree_compensation)
                          {{ str_pad((string)number_format($compensation->tree_compensation, 0), 6, '0', STR_PAD_LEFT) }}
                      @else
                          ………………………….
                      @endif
                      টাকার ক্ষতিপূরণ আবেদনকারীর নিজ নামে রোয়েদাদ প্রস্তুত আছে।
                      @if($compensation->award_type && is_array($compensation->award_type) && in_array('অবকাঠামো', $compensation->award_type))
                          <br><br>
                      @endif
                  @endif
                  
                  @if($compensation->award_type && is_array($compensation->award_type) && in_array('অবকাঠামো', $compensation->award_type))
                      অবকাঠামোর রোয়েদাদের 
                      @if($compensation->infrastructure_award_serial_no)
                          {{ str_pad((string)$compensation->infrastructure_award_serial_no, 6, '0', STR_PAD_LEFT) }} নং ক্রমিকে
                      @else
                          …………………………. নং ক্রমিকে
                      @endif
                      @if($compensation->infrastructure_compensation)
                          {{ str_pad((string)number_format($compensation->infrastructure_compensation, 0), 6, '0', STR_PAD_LEFT) }}
                      @else
                          ………………………….
                      @endif
                      টাকার ক্ষতিপূরণ আবেদনকারীর নিজ নামে রোয়েদাদ প্রস্তুত আছে।
                  @endif
                  
                  @if(!$compensation->award_type || !is_array($compensation->award_type) || count($compensation->award_type) == 0)
                      ………………………….
                  @endif
                </div>
                
                <!-- Comprehensive Review Section -->
                <div class="text-justify leading-relaxed mt-4">
                  আবেদনকারির দাখিলকৃত কাগজপত্র ও কানুনগো ও সার্ভেয়ারের প্রতিবেদন দৃষ্টে সার্বিক পর্যালোচনাঃ 
                  
                  <!-- First Section: SA/RS Record Description -->
                  @if($compensation->acquisition_record_basis === 'SA')
                      <div class="ml-4 mt-2">
                          <strong>১. এসএ রেকর্ডের বর্ণনাঃ</strong> 
                          @if($compensation->sa_khatian_no && $compensation->land_schedule_sa_plot_no)
                              নালিশী সাবেক {{ $compensation->land_schedule_sa_plot_no }} নং দাগের হাল {{ $compensation->plot_no ?? '…………………………….' }} নং দাগে {{ $compensation->land_category && is_array($compensation->land_category) ? number_format(collect($compensation->land_category)->sum(function($category) { return floatval($category['total_land'] ?? 0); }), 4) : '…………………………….' }} একর জমি 
                              @if($compensation->award_holder_names && is_array($compensation->award_holder_names) && count($compensation->award_holder_names) > 0)
                                  {{ $compensation->award_holder_names[0]['name'] ?? '…………………………….' }} পিং-{{ $compensation->award_holder_names[0]['father_name'] ?? '…………………………….' }}
                              @else
                                  …………………………. পিং-…………………………….
                              @endif
                              নামে এসএ রেকর্ড প্রস্তুত হয়েছে।
                          @else
                              ………………………….
                          @endif
                      </div>
                  @elseif($compensation->acquisition_record_basis === 'RS')
                      <div class="ml-4 mt-2">
                          <strong>১. আরএস রেকর্ডের বর্ণনাঃ</strong> 
                          @if($compensation->rs_khatian_no && $compensation->land_schedule_rs_plot_no)
                              নালিশী সাবেক {{ $compensation->land_schedule_rs_plot_no }} নং দাগের হাল {{ $compensation->plot_no ?? '…………………………….' }} নং দাগে {{ $compensation->land_category && is_array($compensation->land_category) ? number_format(collect($compensation->land_category)->sum(function($category) { return floatval($category['total_land'] ?? 0); }), 4) : '…………………………….' }} একর জমি 
                              @if($compensation->award_holder_names && is_array($compensation->award_holder_names) && count($compensation->award_holder_names) > 0)
                                  {{ $compensation->award_holder_names[0]['name'] ?? '…………………………….' }} পিং-{{ $compensation->award_holder_names[0]['father_name'] ?? '…………………………….' }}
                              @else
                                  …………………………. পিং-…………………………….
                              @endif
                              নামে আরএস রেকর্ড প্রস্তুত হয়েছে।
                          @else
                              ………………………….
                          @endif
                      </div>
                  @else
                      <div class="ml-4 mt-2">
                          <strong>১. রেকর্ডের বর্ণনাঃ</strong> ………………………….
                      </div>
                  @endif
                  
                  <!-- Dynamic Sections Based on Ownership Continuity Sequence -->
                  @if($compensation->ownership_details && is_array($compensation->ownership_details) && isset($compensation->ownership_details['storySequence']) && count($compensation->ownership_details['storySequence']) > 0)
                      @foreach($compensation->ownership_details['storySequence'] as $index => $item)
                          @php
                              $sectionType = strtolower($item['type'] ?? '');
                              $sectionDescription = $item['description'] ?? '……………………………';
                              $sectionNumber = (int)$index + 2; // Start from 2 since 1 is used for SA/RS record
                          @endphp
                          
                          @if(str_contains($sectionType, 'আরএস রেকর্ড') || str_contains($sectionType, 'rs record'))
                              <div class="ml-4 mt-2">
                                  <strong>{{ $sectionNumber }}. আর এস রেকর্ডের বর্ণনাঃ</strong><br>
                                  নালিশী সাবেক {{ $compensation->land_schedule_rs_plot_no ?? '…………………………….' }} নং দাগের হাল {{ $compensation->plot_no ?? '…………………………….' }} নং দাগে {{ $compensation->land_category && is_array($compensation->land_category) ? number_format(collect($compensation->land_category)->sum(function($category) { return floatval($category['total_land'] ?? 0); }), 4) : '…………………………….' }} একর জমি 
                                  @if($compensation->award_holder_names && is_array($compensation->award_holder_names) && count($compensation->award_holder_names) > 0)
                                      {{ $compensation->award_holder_names[0]['name'] ?? '…………………………….' }} পিং-{{ $compensation->award_holder_names[0]['father_name'] ?? '…………………………….' }}
                                  @else
                                      …………………………. পিং-…………………………….
                                  @endif
                                  নামে আর এস রেকর্ড প্রস্তুত হয়েছে।
                              </div>
                          @elseif(str_contains($sectionType, 'ওয়ারিশ') || str_contains($sectionType, 'inheritance'))
                              <div class="ml-4 mt-2">
                                  <strong>{{ $sectionNumber }}. ওয়ারিশসূত্রে মালিকানার বর্ণনাঃ</strong><br>
                                  @if($compensation->ownership_details && is_array($compensation->ownership_details) && isset($compensation->ownership_details['storySequence']) && count($compensation->ownership_details['storySequence']) > 0)
                                      @foreach($compensation->ownership_details['storySequence'] as $storyIndex => $storyItem)
                                          @if(str_contains(strtolower($storyItem['type'] ?? ''), 'ওয়ারিশ') || str_contains(strtolower($storyItem['type'] ?? ''), 'inheritance'))
                                              @if($compensation->acquisition_record_basis === 'SA')
                                                  এস এ রেকর্ডীয় মালিক {{ $storyItem['description'] ?? '…………………………….' }} মৃত্যুবরণ করায় তার ওয়ারিশ হিসেবে {{ $compensation->applicants && is_array($compensation->applicants) && count($compensation->applicants) > 0 ? $compensation->applicants[0]['name'] ?? '…………………………….' : '…………………………….' }} থাকে (দাখিলকৃত সংযুক্ত ওয়ারিশান সনদ মোতাবেক)।
                                              @elseif($compensation->acquisition_record_basis === 'RS')
                                                  আর এস রেকর্ডীয় মালিক {{ $storyItem['description'] ?? '…………………………….' }} মৃত্যুবরণ করায় তার ওয়ারিশ হিসেবে {{ $compensation->applicants && is_array($compensation->applicants) && count($compensation->applicants) > 0 ? $compensation->applicants[0]['name'] ?? '…………………………….' : '…………………………….' }} থাকে (দাখিলকৃত সংযুক্ত ওয়ারিশান সনদ মোতাবেক)।
                                              @else
                                                  {{ $storyItem['description'] ?? '…………………………….' }}
                                              @endif
                                          @endif
                                      @endforeach
                                  @else
                                      {{ $sectionDescription }}
                                  @endif
                              </div>
                          @elseif(str_contains($sectionType, 'দলিল') || str_contains($sectionType, 'document') || str_contains($sectionType, 'transfer'))
                              <div class="ml-4 mt-2">
                                  <strong>{{ $sectionNumber }}. দলিলমূলে হস্তান্তরের বর্ণনাঃ</strong><br>
                                  @if($compensation->ownership_details && is_array($compensation->ownership_details) && isset($compensation->ownership_details['deed_transfers']) && count($compensation->ownership_details['deed_transfers']) > 0)
                                      @foreach($compensation->ownership_details['deed_transfers'] as $deedIndex => $deed)
                                          @if($deedIndex > 0)
                                              <br>
                                          @endif
                                          @if(isset($deed['donor_names']) && is_array($deed['donor_names']) && count($deed['donor_names']) > 0 && isset($deed['recipient_names']) && is_array($deed['recipient_names']) && count($deed['recipient_names']) > 0)
                                              @php
                                                  $donorNames = collect($deed['donor_names'])->pluck('name')->filter()->implode(', ');
                                                  $recipientNames = collect($deed['recipient_names'])->pluck('name')->filter()->implode(', ');
                                                  $deedNumber = $deed['deed_number'] ?? '……………………………';
                                                  $deedDate = $deed['deed_date'] ?? '……………………………';
                                                  $deedType = $deed['sale_type'] ?? '……………………………';
                                              @endphp
                                              
                                              {{ $donorNames }}, পিং {{ $deed['donor_names'][0]['father_name'] ?? '…………………………….' }} গত {{ $deedDate }} তারিখের {{ $deedNumber }} নং {{ $deedType }} {{ $recipientNames }}, পিং {{ $deed['recipient_names'][0]['father_name'] ?? '…………………………….' }} বরাবর নালিশী {{ $compensation->acquisition_record_basis === 'SA' ? ($compensation->land_schedule_sa_plot_no ?? '…………………………….' ) : ($compensation->land_schedule_rs_plot_no ?? '…………………………….' ) }} দাগের {{ $compensation->land_category && is_array($compensation->land_category) ? number_format(collect($compensation->land_category)->sum(function($category) { return floatval($category['total_land'] ?? 0); }), 4) : '…………………………….' }} একর জমি হস্তান্তর করেন।
                                          @else
                                              {{ $sectionDescription }}
                                          @endif
                                      @endforeach
                                  @else
                                      {{ $sectionDescription }}
                                  @endif
                              </div>
                          @else
                              <div class="ml-4 mt-2">
                                  <strong>{{ $sectionNumber }}. {{ $item['type'] ?? '…………………………….' }}ঃ</strong><br>
                                  {{ $sectionDescription }}
                              </div>
                          @endif
                          
                          @if($index < count($compensation->ownership_details['storySequence']) - 1)
                              <br>
                          @endif
                      @endforeach
                  @endif
                  
                  <!-- Name Registration and Tax Section (Independent Section) -->
                  @if($compensation->ownership_details && is_array($compensation->ownership_details) && isset($compensation->ownership_details['applicant_info']))
                      @php
                          $applicantInfo = $compensation->ownership_details['applicant_info'];
                          $applicantName = $applicantInfo['applicant_name'] ?? '……………………………';
                          $kharijCaseNo = $applicantInfo['kharij_case_no'] ?? '……………………………';
                          $kharijKhatianNo = $applicantInfo['kharij_khatian_no'] ?? '……………………………';
                          $kharijPlotNo = $applicantInfo['kharij_plot_no'] ?? '……………………………';
                          $kharijLandAmount = $applicantInfo['kharij_land_amount'] ?? '……………………………';
                          $kharijDate = $applicantInfo['kharij_date'] ?? '……………………………';
                          $kharijDetails = $applicantInfo['kharij_details'] ?? '';
                          
                          // Tax information from tax_info field
                          $holdingNo = $compensation->tax_info && is_array($compensation->tax_info) ? ($compensation->tax_info['holding_no'] ?? '……………………………') : '……………………………';
                          $paidLandAmount = $compensation->tax_info && is_array($compensation->tax_info) ? ($compensation->tax_info['paid_land_amount'] ?? '……………………………') : '……………………………';
                          $englishYear = $compensation->tax_info && is_array($compensation->tax_info) ? ($compensation->tax_info['english_year'] ?? '……………………………') : '……………………………';
                          $banglaYear = $compensation->tax_info && is_array($compensation->tax_info) ? ($compensation->tax_info['bangla_year'] ?? '……………………………') : '……………………………';
                          
                          $nextSectionNumber = ($compensation->ownership_details && is_array($compensation->ownership_details) && isset($compensation->ownership_details['storySequence']) ? count($compensation->ownership_details['storySequence']) : 0) + 2;
                      @endphp
                      
                      <div class="ml-4 mt-2">
                          <strong>{{ $nextSectionNumber }}. নামজারী ও খাজনার বর্ণনাঃ</strong><br>
                          আবেদনকারী {{ $applicantName }} প্রাপ্ত জমি {{ $kharijCaseNo }} নং নামজারী কেসমূলে রেকর্ড সংশোধনপূর্বক {{ $kharijKhatianNo }} নং নামজারী খতিয়ানে {{ $kharijPlotNo }} নং দাগে {{ $kharijLandAmount }} একর জমি নামজারী করেন। খাজনার রশিদ যাচাই করে দেখা যায়, {{ $holdingNo }} নং হোল্ডিং এ {{ $kharijPlotNo }} নং দাগে {{ $paidLandAmount }} একর জমির বিপরীতে বাংলা {{ $banglaYear }} সন পর্যন্ত ভূমি উন্নয়ন কর পরিশোধ অন্তে খাজনার রশিদ দাখিল করেছেন।
                          
                          @if($kharijDetails)
                              <br><br>
                              {{ $kharijDetails }}
                          @endif
                      </div>
                  @endif
                  
                  <br><br>
                  @if($compensation->additional_documents_info && is_array($compensation->additional_documents_info) && isset($compensation->additional_documents_info['selected_types']) && count($compensation->additional_documents_info['selected_types']) > 0)
                      @foreach($compensation->additional_documents_info['selected_types'] as $docType)
                          @if($docType === 'আপস- বন্টননামা')
                              @if(isset($compensation->additional_documents_info['details'][$docType]) && $compensation->additional_documents_info['details'][$docType])
                                  আপস- বন্টননামা বর্ণনাঃ {{ $compensation->additional_documents_info['details'][$docType] }}
                              @endif
                          @elseif($docType === 'না-দাবি')
                              @if(isset($compensation->additional_documents_info['details'][$docType]) && $compensation->additional_documents_info['details'][$docType])
                                  না-দাবীনামা বর্ণনাঃ {{ $compensation->additional_documents_info['details'][$docType] }}
                              @endif
                          @elseif($docType === 'সরেজমিন তদন্ত')
                              @if(isset($compensation->additional_documents_info['details'][$docType]) && $compensation->additional_documents_info['details'][$docType])
                                  সরেজমিন তদন্ত প্রতিবেদন বর্ণনাঃ {{ $compensation->additional_documents_info['details'][$docType] }}
                              @endif
                          @elseif($docType === 'এফিডেভিট')
                              @if(isset($compensation->additional_documents_info['details'][$docType]) && $compensation->additional_documents_info['details'][$docType])
                                  এফিডেভিট বর্ণনাঃ {{ $compensation->additional_documents_info['details'][$docType] }}
                              @endif
                          @else
                              @if(isset($compensation->additional_documents_info['details'][$docType]) && $compensation->additional_documents_info['details'][$docType])
                                  {{ $docType }} দাখিল করা হয়েছে। {{ $compensation->additional_documents_info['details'][$docType] }}
                              @else
                                  {{ $docType }} দাখিল করা হয়েছে।
                              @endif
                          @endif
                          @if(!$loop->last)
                              <br>
                          @endif
                      @endforeach
                  @endif
                  
                  <br><br>
                  কানুনগো ও সার্ভেয়ারের মতামতঃ 
                  
                  @if($compensation->kanungo_opinion && is_array($compensation->kanungo_opinion) && isset($compensation->kanungo_opinion['opinion_details']) && $compensation->kanungo_opinion['opinion_details'])
                      {{ $compensation->kanungo_opinion['opinion_details'] }}
                  @else
                      কাগজপত্রাদি পর্যালোচনা ও শুনানি অন্তে প্রতীয়মান হয় যে আবেদনকারী 
                      @if($compensation->applicants && is_array($compensation->applicants) && count($compensation->applicants) > 0)
                          ({{ $compensation->applicants[0]['name'] ?? '…………………………….' }})
                      @else
                          (…………………………….)
                      @endif
                      উক্ত প্রাপ্য অর্থের হকদার। 
                      
                      দাখিলকৃত কাগজপত্র যাচাইপূর্বক কানুনগো ও সার্ভেয়ারগণের দাখিলকৃত প্রতিবেদনে উল্লেখ করা হয় যে আবেদনকারী মালিকানার দাবীর স্বপক্ষে কাগজপত্রের ধারাবাহিকতা আছে।
                  @endif
                  
                  <br><br>
                  দাখিলকৃত কাগজপত্র যাচাইপূর্বক কানুনগো ও সার্ভেয়ারগণের দাখিলকৃত প্রতিবেদনে উল্লেখ করা হয় যে আবেদনকারী মালিকানার দাবীর স্বপক্ষে কাগজপত্রের ধারাবাহিকতা আছে।
                  
                  <br><br>
                  অতএব আদেশ হয় যে, কানুনগো ও সার্ভেয়ারের দাখিলকৃত যৌথ প্রতিবেদন ও আবেদনকারীর কাগজপত্র পর্যালোচনা করে দেখা যায় আবেদিত সম্পত্তি প্রার্থীর ভোগ-দখলীয় সম্পত্তি, মালিকানাস্বত্বের কাগজপত্র সঠিক থাকায় 
                  @if($compensation->applicants && is_array($compensation->applicants) && count($compensation->applicants) > 0)
                      @foreach($compensation->applicants as $applicantIndex => $applicant)
                          @if($applicantIndex > 0)
                              @if($applicantIndex == count($compensation->applicants) - 1)
                                  এবং
                              @else
                                  ,
                              @endif
                          @endif
                          {{ $applicant['name'] ?? '…………………………….' }}, পিং {{ $applicant['father_name'] ?? '…………………………….' }}, সাং: {{ $applicant['address'] ?? '…………………………….' }}, উপজেলা: {{ $compensation->upazila ?? '…………………………….' }}, জেলা: {{ $compensation->district ?? '…………………………….' }}
                      @endforeach
                  @else
                      …………………………., পিং …………………………., সাং: …………………………., উপজেলা: …………………………., জেলা: ………………………….
                  @endif
                  কে {{ $compensation->mouza_name ?? '…………………………….' }}/{{ $compensation->jl_no ?? '…………………………….' }} মৌজার নিম্নে উল্লিখিত তফসিল বর্ণিত সম্পত্তির ক্ষতিপূরণ প্রদান করা হলো।
                  
                  @if($compensation->final_order && is_array($compensation->final_order) && count($compensation->final_order) > 0)
                  <br><br>
                  
                  <!-- Compensation Details Table -->
                  <table class="w-full border border-black border-collapse mb-4">
                      <thead>
                          <tr>
                              <th class="border border-black p-2 text-center">রোয়েদাদ নং</th>
                              <th class="border border-black p-2 text-center">খতিয়া নং</th>
                              <th class="border border-black p-2 text-center">দাগ নং</th>
                              <th class="border border-black p-2 text-center">অধিগ্রহণকৃত জমি</th>
                              <th class="border border-black p-2 text-center">দাবির বিবরণ</th>
                              <th class="border border-black p-2 text-center">ক্ষতিপূরণের পরিমাণ</th>
                          </tr>
                      </thead>
                      <tbody>
                          @php
                              // Get final order data for comparison
                              $finalOrder = $compensation->final_order ?? [];
                              $finalOrderLand = 0;
                              $finalOrderLandCompensation = 0;
                              $finalOrderTreeCompensation = 0;
                              $finalOrderInfrastructureCompensation = 0;
                              
                              // Extract data from final_order structure
                              if (isset($finalOrder['land']) && $finalOrder['land']['selected']) {
                                  if (isset($finalOrder['land']['categories']) && is_array($finalOrder['land']['categories'])) {
                                      foreach ($finalOrder['land']['categories'] as $category) {
                                          $finalOrderLand += floatval($compensation->enDigits($category['acquired_land'] ?? 0));
                                      }
                                  } elseif (isset($finalOrder['land']['records']) && is_array($finalOrder['land']['records'])) {
                                      foreach ($finalOrder['land']['records'] as $record) {
                                          $finalOrderLand += floatval($compensation->enDigits($record['area'] ?? 0));
                                      }
                                  }
                                  // Get land compensation from land_category total
                                  if ($compensation->land_category && is_array($compensation->land_category)) {
                                      $finalOrderLandCompensation = collect($compensation->land_category)->sum(function($category) {
                                          return floatval($category['total_compensation'] ?? 0);
                                      });
                                  }
                              }
                              
                              if (isset($finalOrder['trees_crops']) && $finalOrder['trees_crops']['selected']) {
                                  $finalOrderTreeCompensation = floatval($compensation->enDigits($finalOrder['trees_crops']['amount'] ?? 0));
                              }
                              
                              if (isset($finalOrder['infrastructure']) && $finalOrder['infrastructure']['selected']) {
                                  $finalOrderInfrastructureCompensation = floatval($compensation->enDigits($finalOrder['infrastructure']['amount'] ?? 0));
                              }
                              
                              // Get award data from রোয়েদাদের তথ্যঃ section
                              $landAwardSerialNo = $compensation->land_award_serial_no ?? null;
                              $treeAwardSerialNo = $compensation->tree_award_serial_no ?? null;
                              $infrastructureAwardSerialNo = $compensation->infrastructure_award_serial_no ?? null;
                              
                              // Try to get award numbers from final order if main fields are empty
                              if (empty($landAwardSerialNo) && isset($finalOrder['land']) && $finalOrder['land']['selected']) {
                                  if (isset($finalOrder['land']['award_number']) && !empty($finalOrder['land']['award_number'])) {
                                      $landAwardSerialNo = $finalOrder['land']['award_number'];
                                  }
                              }
                              
                              if (empty($treeAwardSerialNo) && isset($finalOrder['trees_crops']) && $finalOrder['trees_crops']['selected']) {
                                  if (isset($finalOrder['trees_crops']['award_number']) && !empty($finalOrder['trees_crops']['award_number'])) {
                                      $treeAwardSerialNo = $finalOrder['trees_crops']['award_number'];
                                  }
                              }
                              
                              if (empty($infrastructureAwardSerialNo) && isset($finalOrder['infrastructure']) && $finalOrder['infrastructure']['selected']) {
                                  if (isset($finalOrder['infrastructure']['award_number']) && !empty($finalOrder['infrastructure']['award_number'])) {
                                      $infrastructureAwardSerialNo = $finalOrder['infrastructure']['award_number'];
                                  }
                              }
                              
                              // Get land schedule data
                              $landScheduleTotal = 0;
                              $landTypes = [];
                              if ($compensation->land_category && is_array($compensation->land_category)) {
                                  $landScheduleTotal = collect($compensation->land_category)->sum(function($category) {
                                      return floatval($category['total_land'] ?? 0);
                                  });
                                  $landTypes = collect($compensation->land_category)->pluck('land_type')->filter()->toArray();
                              }
                              
                              // Resolve land type for display (prefer final order category name, then form land_category[0])
                              $acquiredLandType = '';
                              if (isset($finalOrder['land']) && $finalOrder['land']['selected']) {
                                  if (isset($finalOrder['land']['categories']) && is_array($finalOrder['land']['categories']) && count($finalOrder['land']['categories']) > 0) {
                                      $acquiredLandType = $finalOrder['land']['categories'][0]['category_name'] ?? '';
                                  }
                              }
                              if (!$acquiredLandType && $compensation->land_category && is_array($compensation->land_category) && count($compensation->land_category) > 0) {
                                  $acquiredLandType = $compensation->land_category[0]['land_type'] ?? '';
                              }
                              
                              // Get compensation amounts from award section
                              $landCompensation = 0;
                              $treeCompensation = 0;
                              $infrastructureCompensation = 0;
                              
                              // Calculate land compensation based on final order land amount
                              if ($finalOrderLand > 0 && $landScheduleTotal > 0) {
                                  // Calculate proportional compensation based on final order land amount
                                  $landCompensation = ($finalOrderLand / $landScheduleTotal) * $finalOrderLandCompensation;
                              }
                              
                              // Use final order compensation for trees and infrastructure
                              $treeCompensation = $finalOrderTreeCompensation;
                              $infrastructureCompensation = $finalOrderInfrastructureCompensation;
                              
                              // Calculate total compensation
                              $totalCompensation = $landCompensation + $treeCompensation + $infrastructureCompensation;
                              
                              // Source tax is mandatory; compute directly from percentage
                              $sourceTax = ($totalCompensation * floatval($compensation->source_tax_percentage)) / 100;
                              
                              // Final amount after tax deduction
                              $finalAmount = $totalCompensation - $sourceTax;
                              
                              // Get plot and khatian numbers
                              $plotNo = $compensation->plot_no ?? '……………………………';
                              $khatianNo = $compensation->acquisition_record_basis === 'SA' ? 
                                          ($compensation->sa_khatian_no ?? '……………………………') : 
                                          ($compensation->rs_khatian_no ?? '……………………………');
                              
                              // Get award serial numbers - ensure they are properly retrieved
                              $landAwardNo = !empty($landAwardSerialNo) ? $landAwardSerialNo : '……………………………';
                              $treeAwardNo = !empty($treeAwardSerialNo) ? $treeAwardSerialNo : '……………………………';
                              $infrastructureAwardNo = !empty($infrastructureAwardSerialNo) ? $infrastructureAwardSerialNo : '……………………………';
                          @endphp
                          
                          <!-- Land Compensation Row -->
                          @if($landCompensation > 0 && isset($finalOrder['land']) && $finalOrder['land']['selected'] && in_array('জমি', $compensation->award_type ?? []))
                          <tr>
                              <td class="border border-black p-2 text-center">{{ $landAwardNo }}</td>
                              <td class="border border-black p-2 text-center">{{ $khatianNo }}</td>
                              <td class="border border-black p-2 text-center">{{ $plotNo }}</td>
                              <td class="border border-black p-2 text-center">
                                  {{ number_format($finalOrderLand, 4) }} একর @if(!empty($acquiredLandType)) ({{ $acquiredLandType }}) @endif
                              </td>
                              <td class="border border-black p-2 text-center">
                                  @if($compensation->land_category && is_array($compensation->land_category))
                                      @foreach($compensation->land_category as $index => $category)
                                          @if($index == 0)
                                              {{ number_format(floatval($category['total_land'] ?? 0), 4) }} একর @if(!empty($acquiredLandType)) ({{ $acquiredLandType }}) @endif
                                          @endif
                                      @endforeach
                                  @else
                                      {{ number_format($finalOrderLand, 4) }} একর
                                  @endif
                                  জমির ক্ষতিপূরণ বাবদ
                              </td>
                              <td class="border border-black p-2 text-center">{{ number_format($landCompensation, 2) }}</td>
                          </tr>
                          @endif
                          
                          <!-- Tree/Crop Compensation Row -->
                          @if($treeCompensation > 0 && isset($finalOrder['trees_crops']) && $finalOrder['trees_crops']['selected'] && in_array('গাছপালা/ফসল', $compensation->award_type ?? []))
                          <tr>
                              <td class="border border-black p-2 text-center">{{ $treeAwardNo }}</td>
                              <td class="border border-black p-2 text-center">{{ $khatianNo }}</td>
                              <td class="border border-black p-2 text-center">{{ $plotNo }}</td>
                              <td class="border border-black p-2 text-center">-</td>
                              <td class="border border-black p-2 text-center">গাছপালা/ফসলের ক্ষতিপূরণ বাবদ</td>
                              <td class="border border-black p-2 text-center">{{ number_format($treeCompensation, 2) }}</td>
                          </tr>
                          @endif
                          
                          <!-- Infrastructure Compensation Row -->
                          @if($infrastructureCompensation > 0 && isset($finalOrder['infrastructure']) && $finalOrder['infrastructure']['selected'] && in_array('অবকাঠামো', $compensation->award_type ?? []))
                          <tr>
                              <td class="border border-black p-2 text-center">{{ $infrastructureAwardNo }}</td>
                              <td class="border border-black p-2 text-center">{{ $khatianNo }}</td>
                              <td class="border border-black p-2 text-center">{{ $plotNo }}</td>
                              <td class="border border-black p-2 text-center">-</td>
                              <td class="border border-black p-2 text-center">অবকাঠামোর ক্ষতিপূরণ বাবদ</td>
                              <td class="border border-black p-2 text-center">{{ number_format($infrastructureCompensation, 2) }}</td>
                          </tr>
                          @endif
                          
                          <!-- Total Row -->
                          <tr class="font-bold">
                              <td class="border border-black p-2 text-center" colspan="5">উৎস করসহ মোট প্রদেয় =</td>
                              <td class="border border-black p-2 text-center">{{ number_format($totalCompensation, 2) }}</td>
                          </tr>
                          
                          <!-- Source Tax Row -->
                          <tr>
                              <td class="border border-black p-2 text-center" colspan="5">{{ $compensation->source_tax_percentage }}% উৎস কর (-)</td>
                              <td class="border border-black p-2 text-center">{{ number_format($sourceTax, 2) }}</td>
                          </tr>
                          
                          <!-- Final Amount Row -->
                          <tr class="font-bold">
                              <td class="border border-black p-2 text-center" colspan="5">উৎস কর বাদে প্রদেয় টাকা =</td>
                              <td class="border border-black p-2 text-center">{{ number_format($finalAmount, 2) }}</td>
                          </tr>
                      </tbody>
                  </table>
                  
                  <br><br>
                  
                  <!-- Additional Instructions -->
                  <div class="text-justify leading-relaxed">
                      মোট ক্ষতিপূরণ বাবদ প্রদেয় = {{ $compensation->formatAmountBangla($totalCompensation) }} ({{ $compensation->amountToBengaliWords($totalCompensation) }} মাত্র) টাকার এল.এ চেক আবেদনকারীর নামে প্রয়োজনীয় অঙ্গীকারনামা গ্রহণপূর্বক ইস্যু করা হোক।
                      
                      <br><br>
                      
                      উক্ত টাকা হতে বিল ও চালানের মাধ্যমে {{ $compensation->bnDigits($compensation->source_tax_percentage) }}% উৎস কর কর্তন বাদে {{ $compensation->formatAmountBangla($finalAmount) }} ({{ $compensation->amountToBengaliWords($finalAmount) }} মাত্র) টাকার MICR চেক প্রদান করার লক্ষ্যে বিল ভাউচারসহ উৎস করের চালানের কপি প্রস্তুতপূর্বক জেলা হিসাবরক্ষণ অফিসে প্রেরণ করা হোক।
                      
                      <br><br>
                      
                      সেই সাথে সিসি প্রস্তুতের জন্য সংশ্লিষ্ট সহকারীকে বলা হলো।
                  </div>
                  @endif
                </div>
                
                <div class="text-right font-bold mt-6">
                  ভূমি অধিগ্রহণ কর্মকর্তা <br>
                  {{ $compensation->district ?? '…………………………….' }}
                </div>
              </td>
              <td class="border border-black p-4"></td>
            </tr>
          </tbody>
        </table>
    </div>
</div>
@endsection
