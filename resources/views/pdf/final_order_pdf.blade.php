<!DOCTYPE html>
<html lang="bn">
<head>
  <meta charset="UTF-8">
  <title>চুড়ান্ত অর্ডারশিট ডাউনলোড</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Embedded Noto Serif Bengali font -->
  <style>
    @page {
      size: A4;
      margin: 10mm 10mm 15mm 10mm;
    }
    @font-face {
      font-family: 'Noto Serif Bengali';
      font-style: normal;
      font-weight: 400;
      src: url('https://fonts.gstatic.com/s/notoserifbengali/v1/yYLrQh9-fIXkJvOfkYQ2bL3XYPFvqA.woff2') format('woff2');
    }
    body {
      margin: 0;
      padding: 0;
      font-family: 'Noto Serif Bengali', serif;
    }
    .a4 {
      width: 210mm;
      min-height: 297mm;
      margin: 0 auto;
      padding: 10mm;
      background: white;
      box-sizing: border-box;
    }
    table {
      table-layout: fixed;
    }
    /* Calculation table print safety and compact spacing */
    .calc-table { 
      width: 100%;
      border-collapse: collapse; 
      table-layout: fixed; 
      margin-bottom: 6mm; 
    }
    .calc-table thead { display: table-header-group; }
    .calc-table tfoot { display: table-footer-group; }
    .calc-table tr,
    .calc-table th,
    .calc-table td { page-break-inside: avoid; }
    .calc-table th,
    .calc-table td { padding: 6px 8px; vertical-align: middle; word-break: break-word; }
    .avoid-break { page-break-inside: avoid; }
    /* Headings shouldn't be stranded at page end and should have breathing room */
    h1, h2, h3, h4, strong { page-break-after: avoid; }
    h1, h2, h3, h4 { margin-top: 6mm; }
    /* Tighten default spacing */
    .mb-6 { margin-bottom: 10px !important; }
    .my-8 { margin-top: 12px !important; margin-bottom: 12px !important; }
    @media print {
      body { margin: 0; }
      .a4 { 
        width: 210mm; 
        min-height: 297mm; 
        margin: 0; 
        padding: 10mm;
        box-shadow: none;
      }
    }
  </style>
</head>
<body>
  <div class="a4">
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
          <span>মামলার ধরন: ক্ষতিপূরণ কেস নং: {{ $compensation->bnDigits($compensation->case_number ?? 'N/A') }}</span> 
          <span>এল.এ কেস: {{ $compensation->bnDigits($compensation->la_case_no ?? 'N/A') }}</span>
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
                  , উপজেলা: {{ $compensation->upazila ?? '…………………………….' }}, জেলা: {{ $compensation->district ?? '…………………………….' }}, {{ $compensation->getBengaliValue('la_case_no') ?? '…………………………….' }} নং এল.এ কেসে অধিগ্রহণকৃত {{ $compensation->mouza_name ?? '…………………………….' }}/{{ $compensation->getBengaliValue('jl_no') ?? '…………………………….' }} মৌজার 
                  @if($compensation->acquisition_record_basis === 'SA')
                      এসএ রেকর্ডমূলে অধিগ্রহণ
                  @elseif($compensation->acquisition_record_basis === 'RS')
                      আরএস রেকর্ডমূলে অধিগ্রহণ
                  @else
                      ………………………….
                  @endif
                                  {{ $compensation->acquisition_record_basis === 'SA' ? ($compensation->bnDigits($compensation->sa_khatian_no ?? '…………………………….' )) : ($compensation->bnDigits($compensation->rs_khatian_no ?? '…………………………….' )) }} নং খতিয়ানের
                {{ $compensation->acquisition_record_basis === 'SA' ? ($compensation->bnDigits($compensation->land_schedule_sa_plot_no ?? '…………………………….' )) : ($compensation->bnDigits($compensation->land_schedule_rs_plot_no ?? '…………………………….' )) }} নং দাগের 
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
                          {{ str_pad((string)$compensation->bnDigits($compensation->land_award_serial_no ?? ''), 6, '0', STR_PAD_LEFT) }} নং ক্রমিকে
                      @else
                          …………………………. নং ক্রমিকে
                      @endif
                      {{ $compensation->mouza_name ?? '…………………………….' }}/{{ $compensation->bnDigits($compensation->jl_no ?? '……………………………') }} মৌজার 
                      @if($compensation->acquisition_record_basis === 'SA')
                          {{ $compensation->bnDigits($compensation->land_schedule_sa_plot_no ?? '……………………………') }}
                      @elseif($compensation->acquisition_record_basis === 'RS')
                          {{ $compensation->bnDigits($compensation->land_schedule_rs_plot_no ?? '……………………………') }}
                      @else
                          {{ $compensation->bnDigits($compensation->plot_no ?? '……………………………') }}
                      @endif
                      নং দাগের 
                      @if($compensation->land_category && is_array($compensation->land_category))
                          @php
                              $totalLand = collect($compensation->land_category)->sum(function($category) {
                                  return floatval($category['total_land'] ?? 0);
                              });
                          @endphp
                          {{ $compensation->bnDigits(number_format($totalLand, 4)) }}
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
                          {{ str_pad((string)$compensation->bnDigits($compensation->tree_award_serial_no ?? ''), 6, '0', STR_PAD_LEFT) }} নং ক্রমিকে
                      @else
                          …………………………. নং ক্রমিকে
                      @endif
                      @if($compensation->tree_compensation)
                          {{ $compensation->bnDigits(str_pad((string)number_format($compensation->tree_compensation, 0), 6, '0', STR_PAD_LEFT)) }}
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
                          {{ str_pad((string)$compensation->bnDigits($compensation->infrastructure_award_serial_no ?? ''), 6, '0', STR_PAD_LEFT) }} নং ক্রমিকে
                      @else
                          …………………………. নং ক্রমিকে
                      @endif
                      @if($compensation->infrastructure_compensation)
                          {{ $compensation->bnDigits(str_pad((string)number_format($compensation->infrastructure_compensation, 0), 6, '0', STR_PAD_LEFT)) }}
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
                          @if($compensation->ownership_details && is_array($compensation->ownership_details) && isset($compensation->ownership_details['sa_info']))
                              @php
                                  $saInfo = $compensation->ownership_details['sa_info'];
                                  $saKhatianNo = $saInfo['sa_khatian_no'] ?? $compensation->sa_khatian_no ?? '……………………………';
                                  $saPlotNo = $saInfo['sa_plot_no'] ?? $compensation->land_schedule_sa_plot_no ?? '……………………………';
                                  $saLandInKhatian = $saInfo['sa_land_in_khatian'] ?? '……………………………';
                                  $saOwners = $compensation->ownership_details['sa_owners'] ?? [];
                                  $ownerNames = [];
                                  if (is_array($saOwners) && count($saOwners) > 0) {
                                      foreach ($saOwners as $owner) {
                                          if (!empty($owner['name'])) {
                                              $ownerNames[] = $owner['name'];
                                          }
                                      }
                                  }
                                  $ownerDisplay = count($ownerNames) > 0 ? implode(' ', $ownerNames) : '……………………………';
                              @endphp
                              এস এ {{ $compensation->bnDigits($saKhatianNo) }} নং খতিয়ানে {{ $compensation->bnDigits($saPlotNo) }} নং দাগে {{ $compensation->bnDigits($saLandInKhatian) }} একর জমি {{ $ownerDisplay }} নামে এস এ রেকর্ড প্রস্তুত রয়েছে
                          @else
                              @if($compensation->sa_khatian_no && $compensation->land_schedule_sa_plot_no)
                                  নালিশী সাবেক {{ $compensation->bnDigits($compensation->land_schedule_sa_plot_no) }} নং দাগের হাল {{ $compensation->bnDigits($compensation->plot_no ?? '…………………………….' ) }} নং দাগে {{ $compensation->land_category && is_array($compensation->land_category) ? $compensation->bnDigits(number_format(collect($compensation->land_category)->sum(function($category) { return floatval($category['total_land'] ?? 0); }), 4)) : '…………………………….' }} একর জমি 
                                  @if($compensation->award_holder_names && is_array($compensation->award_holder_names) && count($compensation->award_holder_names) > 0)
                                      {{ $compensation->award_holder_names[0]['name'] ?? '…………………………….' }} পিং-{{ $compensation->award_holder_names[0]['father_name'] ?? '…………………………….' }}
                                  @else
                                      …………………………. পিং-…………………………….
                                  @endif
                                  নামে এসএ রেকর্ড প্রস্তুত হয়েছে।
                              @else
                                  ………………………….
                              @endif
                          @endif
                      </div>
                  @elseif($compensation->acquisition_record_basis === 'RS')
                      <div class="ml-4 mt-2">
                          <strong>১. আরএস রেকর্ডের বর্ণনাঃ</strong> 
                          @if($compensation->ownership_details && is_array($compensation->ownership_details) && isset($compensation->ownership_details['rs_info']))
                              @php
                                  $rsInfo = $compensation->ownership_details['rs_info'];
                                  $rsKhatianNo = $rsInfo['rs_khatian_no'] ?? $compensation->rs_khatian_no ?? '……………………………';
                                  $rsPlotNo = $rsInfo['rs_plot_no'] ?? $compensation->land_schedule_rs_plot_no ?? '……………………………';
                                  $rsLandInKhatian = $rsInfo['rs_land_in_khatian'] ?? '……………………………';
                                  $rsOwners = $compensation->ownership_details['rs_owners'] ?? [];
                                  $ownerNames = [];
                                  if (is_array($rsOwners) && count($rsOwners) > 0) {
                                      foreach ($rsOwners as $owner) {
                                          if (!empty($owner['name'])) {
                                              $ownerNames[] = $owner['name'];
                                          }
                                      }
                                  }
                                  $ownerDisplay = count($ownerNames) > 0 ? implode(' ', $ownerNames) : '……………………………';
                              @endphp
                              আর এস {{ $compensation->bnDigits($rsKhatianNo) }} নং খতিয়ানে {{ $compensation->bnDigits($rsPlotNo) }} নং দাগে {{ $compensation->bnDigits($rsLandInKhatian) }} একর জমি {{ $ownerDisplay }} নামে আর এস রেকর্ড প্রস্তুত রয়েছে
                          @else
                              @if($compensation->rs_khatian_no && $compensation->land_schedule_rs_plot_no)
                                  নালিশী সাবেক {{ $compensation->bnDigits($compensation->land_schedule_rs_plot_no) }} নং দাগের হাল {{ $compensation->bnDigits($compensation->plot_no ?? '…………………………….' ) }} নং দাগে {{ $compensation->land_category && is_array($compensation->land_category) ? $compensation->bnDigits(number_format(collect($compensation->land_category)->sum(function($category) { return floatval($category['total_land'] ?? 0); }), 4)) : '…………………………….' }} একর জমি 
                                  @if($compensation->award_holder_names && is_array($compensation->award_holder_names) && count($compensation->award_holder_names) > 0)
                                      {{ $compensation->award_holder_names[0]['name'] ?? '…………………………….' }} পিং-{{ $compensation->award_holder_names[0]['father_name'] ?? '…………………………….' }}
                                  @else
                                      …………………………. পিং-…………………………….
                                  @endif
                                  নামে আরএস রেকর্ড প্রস্তুত হয়েছে।
                              @else
                                  ………………………….
                              @endif
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
                                  নালিশী সাবেক {{ $compensation->bnDigits($compensation->land_schedule_rs_plot_no ?? '…………………………….' ) }} নং দাগের হাল {{ $compensation->bnDigits($compensation->plot_no ?? '…………………………….' ) }} নং দাগে {{ $compensation->land_category && is_array($compensation->land_category) ? $compensation->bnDigits(number_format(collect($compensation->land_category)->sum(function($category) { return floatval($category['total_land'] ?? 0); }), 4)) : '…………………………….' }} একর জমি 
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
                                  @php
                                      // Find the specific deed that corresponds to this story sequence item
                                      $currentDeed = null;
                                      if ($compensation->ownership_details && is_array($compensation->ownership_details) && isset($compensation->ownership_details['deed_transfers']) && count($compensation->ownership_details['deed_transfers']) > 0) {
                                          foreach ($compensation->ownership_details['deed_transfers'] as $deedIndex => $deed) {
                                              if (isset($deed['deed_number']) && isset($deed['deed_date'])) {
                                                  if (str_contains($sectionDescription, $deed['deed_number']) || str_contains($sectionDescription, $deed['deed_date'])) {
                                                      $currentDeed = $deed;
                                                      break;
                                                  }
                                              }
                                          }
                                          if (!$currentDeed && isset($compensation->ownership_details['deed_transfers'][0])) {
                                              $currentDeed = $compensation->ownership_details['deed_transfers'][0];
                                          }
                                      }
                                  @endphp
                                  @if($currentDeed && isset($currentDeed['donor_names']) && is_array($currentDeed['donor_names']) && count($currentDeed['donor_names']) > 0 && isset($currentDeed['recipient_names']) && is_array($currentDeed['recipient_names']) && count($currentDeed['recipient_names']) > 0)
                                      @php
                                          $donorNames = collect($currentDeed['donor_names'])->pluck('name')->filter()->implode(', ');
                                          $recipientNames = collect($currentDeed['recipient_names'])->pluck('name')->filter()->implode(', ');
                                          $deedNumber = $currentDeed['deed_number'] ?? '……………………………';
                                          $deedDate = $currentDeed['deed_date'] ?? '……………………………';
                                          $deedType = $currentDeed['sale_type'] ?? '……………………………';
                                          // Calculate land amount for this deed
                                          $deedLandAmount = '……………………………';
                                          if (isset($currentDeed['application_sell_area']) && !empty($currentDeed['application_sell_area'])) {
                                              $deedLandAmount = number_format(floatval($currentDeed['application_sell_area']), 4);
                                          } elseif ($compensation->land_category && is_array($compensation->land_category)) {
                                              $totalLand = collect($compensation->land_category)->sum(function($category) { 
                                                  return floatval($category['total_land'] ?? 0); 
                                              });
                                              $deedLandAmount = number_format($totalLand, 4);
                                          }
                                      @endphp
                                      {{ $donorNames }}, গত {{ $compensation->bnDigits($deedDate) }} তারিখের {{ $compensation->bnDigits($deedNumber) }} নং {{ $deedType }} {{ $recipientNames }}, বরাবর নালিশী {{ $compensation->acquisition_record_basis === 'SA' ? ($compensation->bnDigits($compensation->land_schedule_sa_plot_no ?? '…………………………….' )) : ($compensation->bnDigits($compensation->land_schedule_rs_plot_no ?? '…………………………….' )) }} দাগের {{ $compensation->bnDigits($deedLandAmount) }} একর জমি হস্তান্তর করেন।
                                  @elseif($currentDeed)
                                      দলিলের তথ্য অসম্পূর্ণ। দলিল নম্বর: {{ $compensation->bnDigits($currentDeed['deed_number'] ?? '……………………………') }}, তারিখ: {{ $compensation->bnDigits($currentDeed['deed_date'] ?? '……………………………') }}
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
                          আবেদনকারী {{ $applicantName }} প্রাপ্ত জমি {{ $compensation->bnDigits($kharijCaseNo) }} নং নামজারী কেসমূলে রেকর্ড সংশোধনপূর্বক {{ $compensation->bnDigits($kharijKhatianNo) }} নং নামজারী খতিয়ানে {{ $compensation->bnDigits($kharijPlotNo) }} নং দাগে {{ $compensation->bnDigits($kharijLandAmount) }} একর জমি নামজারী করেন। খাজনার রশিদ যাচাই করে দেখা যায়, {{ $compensation->bnDigits($holdingNo) }} নং হোল্ডিং এ {{ $compensation->bnDigits($kharijPlotNo) }} নং দাগে {{ $compensation->bnDigits($paidLandAmount) }} একর জমির বিপরীতে বাংলা {{ $compensation->bnDigits($banglaYear) }} সন পর্যন্ত ভূমি উন্নয়ন কর পরিশোধ অন্তে খাজনার রশিদ দাখিল করেছেন।
                          
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
                  কানুনগো ও সার্ভেয়ারের মতামতঃ দাখিলকৃত কাগজপত্র যাচাইপূর্বক কানুনুনগো ও সার্ভেয়ারগণের দাখিলকৃত প্রতিবেদনে উল্লেখ করা হয় যে আবেদনকারী মালিকানার দাবীর স্বপক্ষে কাগজপত্রের ধারাবাহিকতা আছে।
                  
                  <br><br>
                  
                  সার্বিক কাগজপত্রাদি পর্যালোচনা ও শুনানি অন্তে  প্রতীয়মান হয় যে আবেদনকারী 
                  @if($compensation->applicants && is_array($compensation->applicants) && count($compensation->applicants) > 0)
                      {{ collect($compensation->applicants)->pluck('name')->filter()->implode(', ') }}
                  @else
                      ………………………….
                  @endif
                  উক্ত ক্ষতিপূরণের প্রাপ্য অর্থের হকদার।
                  
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
                  কে {{ $compensation->mouza_name ?? '…………………………….' }}/{{ $compensation->bnDigits($compensation->jl_no ?? '……………………………') }} মৌজার নিম্নে উল্লিখিত তফসিল বর্ণিত সম্পত্তির ক্ষতিপূরণ প্রদান করা হলো।
                  
                  @if($compensation->final_order && is_array($compensation->final_order) && count($compensation->final_order) > 0)
                  <br><br>
                  
                  <!-- Compensation Details Table -->
                  <table class="calc-table w-full border border-black border-collapse mb-4">
                      <colgroup>
                          <col style="width:16%">
                          <col style="width:12%">
                          <col style="width:12%">
                          <col style="width:16%">
                          <col style="width:22%">
                          <col style="width:22%">
                      </colgroup>
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
                              // Prepare
                              $finalOrder = $compensation->final_order ?? [];
                              $totalCompensation = 0;
                              // Common numbers
                              $plotNo = $compensation->bnDigits($compensation->plot_no ?? '……………………………');
                              $khatianNo = $compensation->acquisition_record_basis === 'SA' ? $compensation->bnDigits($compensation->sa_khatian_no ?? '……………………………') : $compensation->bnDigits($compensation->rs_khatian_no ?? '……………………………');
                              $landAwardSerialNo = $compensation->land_award_serial_no ?? ($finalOrder['land']['award_number'] ?? null);
                              $treeAwardSerialNo = $compensation->tree_award_serial_no ?? ($finalOrder['trees_crops']['award_number'] ?? null);
                              $infrastructureAwardSerialNo = $compensation->infrastructure_award_serial_no ?? ($finalOrder['infrastructure']['award_number'] ?? null);
                              $landAwardNo = !empty($landAwardSerialNo) ? $compensation->bnDigits($landAwardSerialNo) : '……………………………';
                              $treeAwardNo = !empty($treeAwardSerialNo) ? $compensation->bnDigits($treeAwardSerialNo) : '……………………………';
                              $infrastructureAwardNo = !empty($infrastructureAwardSerialNo) ? $compensation->bnDigits($infrastructureAwardSerialNo) : '……………………………';
                          @endphp
                          
                          <!-- Land Compensation Row -->
                          @if(isset($finalOrder['land']) && $finalOrder['land']['selected'] && in_array('জমি', $compensation->award_type ?? []))
                              @if(isset($finalOrder['land']['categories']) && is_array($finalOrder['land']['categories']) && count($finalOrder['land']['categories']) > 0)
                                  @php $landTotalForTax = 0; @endphp
                                  @foreach($finalOrder['land']['categories'] as $categoryIndex => $category)
                                      @php
                                          // Match category with land_category by name or index
                                          $categoryName = $category['category_name'] ?? '';
                                          $lc = null;
                                          if ($compensation->land_category && is_array($compensation->land_category)) {
                                              foreach ($compensation->land_category as $idx => $item) {
                                                  if (isset($item['land_type']) && strtolower($item['land_type']) === strtolower($categoryName)) { $lc = $item; break; }
                                              }
                                              if (!$lc && isset($compensation->land_category[$categoryIndex])) { $lc = $compensation->land_category[$categoryIndex]; }
                                          }
                                          $totalLand = $lc ? floatval($lc['total_land'] ?? 0) : 0;
                                          $totalComp = $lc ? floatval($lc['total_compensation'] ?? 0) : 0;
                                          $acquired = floatval($compensation->enDigits($category['acquired_land'] ?? 0));
                                          $displayAcquiredLand = $totalLand > 0 ? $totalLand : $acquired;
                                          $displayClaimLand = $acquired;
                                          $displayComp = ($totalLand > 0 && $acquired > 0) ? ($totalComp / $totalLand) * $acquired : 0;
                                          $landTotalForTax += $displayComp;
                                          $catAwardNo = $category['award_number'] ?? $landAwardSerialNo;
                                          $catAwardNo = !empty($catAwardNo) ? $compensation->bnDigits($catAwardNo) : '……………………………';
                                      @endphp
                                      @if($displayClaimLand > 0)
                                      <tr>
                                          <td class="border border-black p-2 text-center">{{ $catAwardNo }}</td>
                                          <td class="border border-black p-2 text-center">{{ $khatianNo }}</td>
                                          <td class="border border-black p-2 text-center">{{ $plotNo }}</td>
                                          <td class="border border-black p-2 text-center">{{ $compensation->bnDigits(number_format($displayAcquiredLand, 4)) }} একর</td>
                                          <td class="border border-black p-2 text-center">{{ $compensation->bnDigits(number_format($displayClaimLand, 4)) }} একর @if(!empty($categoryName)) ({{ $categoryName }}) @endif জমির ক্ষতিপূরণ বাবদ</td>
                                          <td class="border border-black p-2 text-center">{{ $compensation->bnDigits(number_format($displayComp, 2)) }}</td>
                                      </tr>
                                      @endif
                                  @endforeach
                                  @php $totalCompensation += $landTotalForTax; @endphp
                              @endif
                          @endif
                          
                          <!-- Tree/Crop Compensation Row -->
                          @if(isset($finalOrder['trees_crops']) && $finalOrder['trees_crops']['selected'] && in_array('গাছপালা/ফসল', $compensation->award_type ?? []))
                              @php $treeCompensation = floatval($compensation->enDigits($finalOrder['trees_crops']['amount'] ?? 0)); if ($treeCompensation > 0) { $totalCompensation += $treeCompensation; } @endphp
                              @if($treeCompensation > 0)
                              <tr>
                                  <td class="border border-black p-2 text-center">{{ $treeAwardNo }}</td>
                                  <td class="border border-black p-2 text-center">{{ $khatianNo }}</td>
                                  <td class="border border-black p-2 text-center">{{ $plotNo }}</td>
                                  <td class="border border-black p-2 text-center">-</td>
                                  <td class="border border-black p-2 text-center">গাছপালা/ফসলের ক্ষতিপূরণ বাবদ</td>
                                  <td class="border border-black p-2 text-center">{{ $compensation->bnDigits(number_format($treeCompensation, 2)) }}</td>
                              </tr>
                              @endif
                          @endif
                          
                          <!-- Infrastructure Compensation Row -->
                          @if(isset($finalOrder['infrastructure']) && $finalOrder['infrastructure']['selected'] && in_array('অবকাঠামো', $compensation->award_type ?? []))
                              @php $infrastructureCompensation = floatval($compensation->enDigits($finalOrder['infrastructure']['amount'] ?? 0)); if ($infrastructureCompensation > 0) { $totalCompensation += $infrastructureCompensation; } @endphp
                              @if($infrastructureCompensation > 0)
                              <tr>
                                  <td class="border border-black p-2 text-center">{{ $infrastructureAwardNo }}</td>
                                  <td class="border border-black p-2 text-center">{{ $khatianNo }}</td>
                                  <td class="border border-black p-2 text-center">{{ $plotNo }}</td>
                                  <td class="border border-black p-2 text-center">-</td>
                                  <td class="border border-black p-2 text-center">অবকাঠামোর ক্ষতিপূরণ বাবদ</td>
                                  <td class="border border-black p-2 text-center">{{ $compensation->bnDigits(number_format($infrastructureCompensation, 2)) }}</td>
                              </tr>
                              @endif
                          @endif
                          
                          @php $sourceTax = ($totalCompensation * floatval($compensation->source_tax_percentage)) / 100; $finalAmount = $totalCompensation - $sourceTax; @endphp
                          <!-- Total Row -->
                          <tr class="font-bold">
                              <td class="border border-black p-2 text-center" colspan="5">উৎস করসহ মোট প্রদেয় =</td>
                              <td class="border border-black p-2 text-center">{{ $compensation->bnDigits(number_format($totalCompensation, 2)) }}</td>
                          </tr>
                          
                          <!-- Source Tax Row -->
                          <tr>
                              <td class="border border-black p-2 text-center" colspan="5">{{ $compensation->bnDigits($compensation->source_tax_percentage) }}% উৎস কর (-)</td>
                              <td class="border border-black p-2 text-center">{{ $compensation->bnDigits(number_format($sourceTax, 2)) }}</td>
                          </tr>
                          
                          <!-- Final Amount Row -->
                          <tr class="font-bold">
                              <td class="border border-black p-2 text-center" colspan="5">উৎস কর বাদে প্রদেয় টাকা =</td>
                              <td class="border border-black p-2 text-center">{{ $compensation->bnDigits(number_format($finalAmount, 2)) }}</td>
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
</body>
</html>
