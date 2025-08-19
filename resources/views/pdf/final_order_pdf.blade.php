<!DOCTYPE html>
<html lang="bn">
<head>
  <meta charset="UTF-8">
  <title>চুড়ান্ত অর্ডারশিট ডাউনলোড</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Tiro+Bangla&display=swap" rel="stylesheet">

  <!-- Embedded Noto Serif Bengali font -->
  <style>
    @page {
      size: A4;
      margin: 10mm 10mm 15mm 10mm;
    }
    /* @font-face {
      font-family: 'Noto Serif Bengali';
      font-style: normal;
      font-weight: 400;
      src: url('https://fonts.googleapis.com/css2?family=Tiro+Bangla&display=swap') format('woff2');
    } */
    body {
      margin: 0;
      padding: 0;
      font-family: 'Tiro Bangla', serif;
    }
    p {
      font-size: 12px;
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
              <th class="border border-black p-2 w-[25mm] text-sm">আদেশের ক্রমিক নং ও তারিখ</th>
              <th class="border border-black p-2 text-sm">আদেশ ও অফিসারের স্বাক্ষর</th>
              <th class="border border-black p-2 w-[25mm] text-sm">আদেশের উপর গৃহীত ব্যবস্থা</th>
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
                  , {{ $compensation->getBengaliValue('la_case_no') ?? '…………………………….' }} নং এল.এ কেসে অধিগ্রহণকৃত {{ $compensation->mouza_name ?? '…………………………….' }}/{{ $compensation->getBengaliValue('jl_no') ?? '…………………………….' }} মৌজার 
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
                  <strong>রোয়েদাদের বর্ণনাঃ</strong></br> রোয়েদাদ বহি পর্যালোচনা করে দেখা যায়, 
                  
                  @if($compensation->award_type && is_array($compensation->award_type) && in_array('জমি', $compensation->award_type))
                      জমির রোয়েদাদের 
                      @if($compensation->land_award_serial_no)
                          {{ $compensation->bnDigits($compensation->land_award_serial_no) }} নং ক্রমিকে
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
                          @if(count($compensation->award_holder_names) == 1)
                              {{ $compensation->award_holder_names[0]['name'] ?? '…………………………….' }}, পিতা: {{ $compensation->award_holder_names[0]['father_name'] ?? '…………………………….' }}
                          @else
                              @foreach($compensation->award_holder_names as $index => $holder)
                                  @if($index > 0)
                                      @if($index == count($compensation->award_holder_names) - 1)
                                          এবং
                                      @else
                                          ,
                                      @endif
                                  @endif
                                  {{ $compensation->bnDigits($index + 1) }}. {{ $holder['name'] ?? '…………………………….' }}, পিতা: {{ $holder['father_name'] ?? '…………………………….' }}
                              @endforeach
                          @endif
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
                          {{ $compensation->bnDigits($compensation->tree_award_serial_no) }} নং ক্রমিকে
                      @else
                          …………………………. নং ক্রমিকে
                      @endif
                      @if($compensation->tree_compensation)
                          {{ $compensation->bnDigits(number_format($compensation->tree_compensation, 0)) }}
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
                          {{ $compensation->bnDigits($compensation->infrastructure_award_serial_no) }} নং ক্রমিকে
                      @else
                          …………………………. নং ক্রমিকে
                      @endif
                      @if($compensation->infrastructure_compensation)
                          {{ $compensation->bnDigits(number_format($compensation->infrastructure_compensation, 0)) }}
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
                          <strong>{{ $compensation->bnDigits(1) }}. এসএ রেকর্ডের বর্ণনাঃ</strong></br> 
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
                                  $ownerDisplay = '';
                                  if (count($ownerNames) == 1) {
                                      $ownerDisplay = $ownerNames[0];
                                  } elseif (count($ownerNames) > 1) {
                                      $numberedNames = [];
                                      foreach ($ownerNames as $index => $name) {
                                          $numberedNames[] = $compensation->bnDigits($index + 1) . '. ' . $name;
                                      }
                                      $ownerDisplay = implode(', ', $numberedNames);
                                  } else {
                                      $ownerDisplay = '……………………………';
                                  }
                              @endphp
                              এস এ {{ $compensation->bnDigits($saKhatianNo) }} নং খতিয়ানে {{ $compensation->bnDigits($saPlotNo) }} নং দাগে {{ $compensation->bnDigits($saLandInKhatian) }} একর জমি {{ $ownerDisplay }} নামে এস এ রেকর্ড প্রস্তুত রয়েছে।
                          @else
                              @if($compensation->sa_khatian_no && $compensation->land_schedule_sa_plot_no)
                                  নালিশী সাবেক {{ $compensation->bnDigits($compensation->land_schedule_sa_plot_no) }} নং দাগের হাল {{ $compensation->bnDigits($compensation->plot_no ?? '…………………………….' ) }} নং দাগে {{ $compensation->land_category && is_array($compensation->land_category) ? $compensation->bnDigits(number_format(collect($compensation->land_category)->sum(function($category) { return floatval($category['total_land'] ?? 0); }), 4)) : '…………………………….' }} একর জমি 
                                  @if($compensation->award_holder_names && is_array($compensation->award_holder_names) && count($compensation->award_holder_names) > 0)
                                      @if(count($compensation->award_holder_names) == 1)
                                          {{ $compensation->award_holder_names[0]['name'] ?? '…………………………….' }}, পিতা: {{ $compensation->award_holder_names[0]['father_name'] ?? '…………………………….' }}
                                      @else
                                          @foreach($compensation->award_holder_names as $index => $holder)
                                              @if($index > 0)
                                                  @if($index == count($compensation->award_holder_names) - 1)
                                                      এবং
                                                  @else
                                                      ,
                                                  @endif
                                              @endif
                                              {{ $compensation->bnDigits($index + 1) }}. {{ $holder['name'] ?? '…………………………….' }}, পিতা: {{ $holder['father_name'] ?? '…………………………….' }}
                                          @endforeach
                                      @endif
                                  @else
                                      …………………………. পিতা: ………………………….
                                  @endif
                                  নামে এসএ রেকর্ড প্রস্তুত হয়েছে।
                              @else
                                  ………………………….
                              @endif
                          @endif
                      </div>
                  @elseif($compensation->acquisition_record_basis === 'RS')
                      <div class="ml-4 mt-2">
                          <strong>{{ $compensation->bnDigits(1) }}. আরএস রেকর্ডের বর্ণনাঃ</strong><br>
                          নালিশী সাবেক {{ $compensation->bnDigits($compensation->land_schedule_rs_plot_no ?? '…………………………….' ) }} নং দাগের হাল {{ $compensation->bnDigits($compensation->plot_no ?? '…………………………….' ) }} নং দাগে {{ $compensation->land_category && is_array($compensation->land_category) ? $compensation->bnDigits(number_format(collect($compensation->land_category)->sum(function($category) { return floatval($category['total_land'] ?? 0); }), 4)) : '…………………………….' }} একর জমি 
                          @if($compensation->award_holder_names && is_array($compensation->award_holder_names) && count($compensation->award_holder_names) > 0)
                              @if(count($compensation->award_holder_names) == 1)
                                  {{ $compensation->award_holder_names[0]['name'] ?? '…………………………….' }}, পিতা: {{ $compensation->award_holder_names[0]['father_name'] ?? '…………………………….' }}
                              @else
                                  @foreach($compensation->award_holder_names as $index => $holder)
                                      @if($index > 0)
                                          @if($index == count($compensation->award_holder_names) - 1)
                                              এবং
                                          @else
                                              ,
                                          @endif
                                      @endif
                                      {{ $compensation->bnDigits($index + 1) }}. {{ $holder['name'] ?? '…………………………….' }}, পিতা: {{ $holder['father_name'] ?? '…………………………….' }}
                                  @endforeach
                              @endif
                          @else
                              …………………………. পিতা: ………………………….
                          @endif
                          নামে আরএস রেকর্ড প্রস্তুত হয়েছে।
                      </div>
                  @else
                      <div class="ml-4 mt-2">
                          <strong>{{ $compensation->bnDigits(1) }}. রেকর্ডের বর্ণনাঃ</strong> ………………………….
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
                                  <strong>{{ $compensation->bnDigits($sectionNumber) }}. আরএস রেকর্ডের বর্ণনাঃ</strong><br>
                                  নালিশী সাবেক {{ $compensation->bnDigits($compensation->land_schedule_rs_plot_no ?? '…………………………….' ) }} নং দাগের হাল {{ $compensation->bnDigits($compensation->plot_no ?? '…………………………….' ) }} নং দাগে {{ $compensation->land_category && is_array($compensation->land_category) ? $compensation->bnDigits(number_format(collect($compensation->land_category)->sum(function($category) { return floatval($category['total_land'] ?? 0); }), 4)) : '…………………………….' }} একর জমি 
                                  @if($compensation->award_holder_names && is_array($compensation->award_holder_names) && count($compensation->award_holder_names) > 0)
                                      @if(count($compensation->award_holder_names) == 1)
                                          {{ $compensation->award_holder_names[0]['name'] ?? '…………………………….' }}, পিতা: {{ $compensation->award_holder_names[0]['father_name'] ?? '…………………………….' }}
                                      @else
                                          @foreach($compensation->award_holder_names as $index => $holder)
                                              @if($index > 0)
                                                  @if($index == count($compensation->award_holder_names) - 1)
                                                      এবং
                                                  @else
                                                      ,
                                                  @endif
                                              @endif
                                              {{ $compensation->bnDigits($index + 1) }}. {{ $holder['name'] ?? '…………………………….' }}, পিতা: {{ $holder['father_name'] ?? '…………………………….' }}
                                          @endforeach
                                      @endif
                                  @else
                                      …………………………. পিতা: ………………………….
                                  @endif
                                  নামে আরএস রেকর্ড প্রস্তুত হয়েছে।
                              </div>
                          @elseif(str_contains($sectionType, 'ওয়ারিশ') || str_contains($sectionType, 'inheritance'))
                              <div class="ml-4 mt-2">
                                  <strong>{{ $compensation->bnDigits($sectionNumber) }}. ওয়ারিশসূত্রে মালিকানার বর্ণনাঃ</strong><br>
                                  @php
                                      // Get inheritance certificate details from inheritance_records based on story sequence
                                      $inheritanceDetails = '';
                                      $deceasedPerson = '';
                                      
                                      if (isset($compensation->ownership_details['inheritance_records']) && is_array($compensation->ownership_details['inheritance_records']) && count($compensation->ownership_details['inheritance_records']) > 0) {
                                          // Find the inheritance record that corresponds to this story sequence item
                                          $storyItemIndex = $item['itemIndex'] ?? 0;
                                          if (isset($compensation->ownership_details['inheritance_records'][$storyItemIndex])) {
                                              $inheritance = $compensation->ownership_details['inheritance_records'][$storyItemIndex];
                                              $inheritanceDetails = $inheritance['heirship_certificate_info'] ?? '……………………………';
                                              $deceasedPerson = $inheritance['previous_owner_name'] ?? '……………………………';
                                          } else {
                                              // Fallback to first inheritance record if index doesn't match
                                              $inheritance = $compensation->ownership_details['inheritance_records'][0];
                                              $inheritanceDetails = $inheritance['heirship_certificate_info'] ?? '……………………………';
                                              $deceasedPerson = $inheritance['previous_owner_name'] ?? '……………………………';
                                          }
                                      }
                                  @endphp
                                  পূর্বোক্ত মালিক {{ $deceasedPerson }} মৃত্যুবরণ করলে তার ওয়ারিশগণ নালিশী সম্পত্তি প্রাপ্ত হন। দাখিলকৃত ওয়ারিশান সনদ অনুযায়ী- {{ $inheritanceDetails }}।
                              </div>
                          @elseif(str_contains($sectionType, 'দলিল') || str_contains($sectionType, 'document') || str_contains($sectionType, 'transfer'))
                              <div class="ml-4 mt-2">
                                  <strong>{{ $compensation->bnDigits($sectionNumber) }}. দলিলমূলে হস্তান্তরের বর্ণনাঃ</strong><br>
                                  @php
                                      // Find the specific deed that corresponds to this story sequence item
                                      $currentDeed = null;
                                      if ($compensation->ownership_details && is_array($compensation->ownership_details) && isset($compensation->ownership_details['deed_transfers']) && count($compensation->ownership_details['deed_transfers']) > 0) {
                                          // Use the itemIndex from the story sequence item to map to the correct deed
                                          if (isset($item['itemIndex']) && isset($compensation->ownership_details['deed_transfers'][$item['itemIndex']])) {
                                              $currentDeed = $compensation->ownership_details['deed_transfers'][$item['itemIndex']];
                                          } else {
                                              // Fallback: try to find by description matching
                                              foreach ($compensation->ownership_details['deed_transfers'] as $deedIndex => $deed) {
                                                  if (isset($deed['deed_number']) && isset($deed['deed_date'])) {
                                                      if (str_contains($sectionDescription, $deed['deed_number']) || str_contains($sectionDescription, $deed['deed_date'])) {
                                                          $currentDeed = $deed;
                                                          break;
                                                      }
                                                  }
                                              }
                                              
                                              // If still no match, use the first available deed as last resort
                                              if (!$currentDeed && isset($compensation->ownership_details['deed_transfers'][0])) {
                                                  $currentDeed = $compensation->ownership_details['deed_transfers'][0];
                                              }
                                          }
                                      }
                                  @endphp
                                  @if($currentDeed && isset($currentDeed['donor_names']) && is_array($currentDeed['donor_names']) && count($currentDeed['donor_names']) > 0 && isset($currentDeed['recipient_names']) && is_array($currentDeed['recipient_names']) && count($currentDeed['recipient_names']) > 0)
                                      @php
                                          // Format donor names with Bengali numbering
                                          $donorNamesArray = collect($currentDeed['donor_names'])->pluck('name')->filter()->toArray();
                                          $donorNames = '';
                                          if (count($donorNamesArray) == 1) {
                                              $donorNames = $donorNamesArray[0];
                                          } elseif (count($donorNamesArray) > 1) {
                                              $numberedDonorNames = [];
                                              foreach ($donorNamesArray as $donorIndex => $name) {
                                                  $numberedDonorNames[] = $compensation->bnDigits($donorIndex + 1) . '. ' . $name;
                                              }
                                              $donorNames = implode(', ', $numberedDonorNames);
                                          }
                                          // Format recipient names with Bengali numbering
                                          $recipientNamesArray = collect($currentDeed['recipient_names'])->pluck('name')->filter()->toArray();
                                          $recipientNames = '';
                                          if (count($recipientNamesArray) == 1) {
                                              $recipientNames = $recipientNamesArray[0];
                                          } elseif (count($recipientNamesArray) > 1) {
                                              $numberedRecipientNames = [];
                                              foreach ($recipientNamesArray as $recipientIndex => $name) {
                                                  $numberedRecipientNames[] = $compensation->bnDigits($recipientIndex + 1) . '. ' . $name;
                                              }
                                              $recipientNames = implode(', ', $numberedRecipientNames);
                                          }
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
                                      {{ $donorNames }} গত {{ $compensation->bnDigits($deedDate) }} তারিখের {{ $compensation->bnDigits($deedNumber) }} নং {{ $deedType }} দলিলমূলে {{ $recipientNames }} বরাবর {{ $compensation->formatApplicationAreaString($currentDeed) }} জমি হস্তান্তর করেন। উক্ত দলিলে সুনির্দিষ্টভাবে {{ $compensation->acquisition_record_basis === 'SA' ? ($compensation->bnDigits($compensation->land_schedule_sa_plot_no ?? '…………………………….' )) : ($compensation->bnDigits($compensation->land_schedule_rs_plot_no ?? '…………………………….' )) }} দাগে দখল উল্লেখ করে হস্তান্তর করা হয়।
                                  @elseif($currentDeed)
                                      দলিলের তথ্য অসম্পূর্ণ। দলিল নম্বর: {{ $compensation->bnDigits($currentDeed['deed_number'] ?? '……………………………') }}, তারিখ: {{ $compensation->bnDigits($currentDeed['deed_date'] ?? '……………………………') }}
                                  @else
                                      {{ $sectionDescription }}
                                  @endif
                              </div>
                          @else
                              <div class="ml-4 mt-2">
                                  <strong>{{ $compensation->bnDigits($sectionNumber) }}. {{ $item['type'] ?? '…………………………….' }}ঃ</strong><br>
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
                          
                          // Check if there's meaningful namejari information
                          $hasNamejariInfo = false;
                          $applicantName = '';
                          $namejariKhatianNo = '';
                          $kharijCaseNo = '';
                          $kharijKhatianNo = '';
                          $kharijPlotNo = '';
                          $kharijLandAmount = '';
                          $kharijDate = '';
                          $kharijDetails = '';
                          
                          // Check if any meaningful namejari data exists
                          if (!empty($applicantInfo['applicant_name']) && $applicantInfo['applicant_name'] !== '……………………………') {
                              $hasNamejariInfo = true;
                              $applicantName = $applicantInfo['applicant_name'];
                          } else {
                              $applicantName = '……………………………';
                          }
                          
                          if (!empty($applicantInfo['namejari_khatian_no']) && $applicantInfo['namejari_khatian_no'] !== '……………………………') {
                              $hasNamejariInfo = true;
                              $namejariKhatianNo = $applicantInfo['namejari_khatian_no'];
                          } else {
                              $namejariKhatianNo = '……………………………';
                          }
                          
                          if (!empty($applicantInfo['kharij_case_no']) && $applicantInfo['kharij_case_no'] !== '……………………………') {
                              $hasNamejariInfo = true;
                              $kharijCaseNo = $applicantInfo['kharij_case_no'];
                          } else {
                              $kharijCaseNo = '……………………………';
                          }
                          
                          if (!empty($applicantInfo['kharij_plot_no']) && $applicantInfo['kharij_plot_no'] !== '……………………………') {
                              $hasNamejariInfo = true;
                              $kharijPlotNo = $applicantInfo['kharij_plot_no'];
                          } else {
                              $kharijPlotNo = '……………………………';
                          }
                          
                          if (!empty($applicantInfo['kharij_land_amount']) && $applicantInfo['kharij_land_amount'] !== '……………………………') {
                              $hasNamejariInfo = true;
                              $kharijLandAmount = $applicantInfo['kharij_land_amount'];
                          } else {
                              $kharijLandAmount = '……………………………';
                          }
                          
                          $kharijDetails = $applicantInfo['kharij_details'] ?? '';
                          
                          // Tax information from tax_info field
                          $paidInName = $compensation->tax_info && is_array($compensation->tax_info) ? ($compensation->tax_info['paid_in_name'] ?? '……………………………') : '……………………………';
                          $holdingNo = $compensation->tax_info && is_array($compensation->tax_info) ? ($compensation->tax_info['holding_no'] ?? '……………………………') : '……………………………';
                          $paidLandAmount = $compensation->tax_info && is_array($compensation->tax_info) ? ($compensation->tax_info['paid_land_amount'] ?? '……………………………') : '……………………………';
                          $englishYear = $compensation->tax_info && is_array($compensation->tax_info) ? ($compensation->bnDigits($compensation->tax_info['english_year'] ?? '……………………………')) : '……………………………';
                          $banglaYear = $compensation->tax_info && is_array($compensation->tax_info) ? ($compensation->bnDigits($compensation->tax_info['bangla_year'] ?? '……………………………')) : '……………………………';
                          
                          $nextSectionNumber = ($compensation->ownership_details && is_array($compensation->ownership_details) && isset($compensation->ownership_details['storySequence']) ? count($compensation->ownership_details['storySequence']) : 0) + 2;
                      @endphp
                      
                      @if($hasNamejariInfo)
                          <div class="ml-4 mt-2">
                              <strong>{{ $compensation->bnDigits($nextSectionNumber) }}.নামজারীর বর্ণনা:</strong></br> আবেদনকারী {{ $applicantName }}
                              তার প্রাপ্ত জমি {{ $compensation->bnDigits($kharijCaseNo) }} নং নামজারী কেসমূলে রেকর্ড সংশোধনপূর্বক {{ $compensation->bnDigits($namejariKhatianNo) }} নং নামজারী খতিয়ানে {{ $compensation->bnDigits($kharijPlotNo) }} নং দাগে {{ $compensation->bnDigits($kharijLandAmount) }} একর জমি নিজ নামে নামজারী করেন।<br><br>
                          </div>
                      @endif
                      
                      <!-- Tax Description Section (Independent) -->
                      @php
                          // Check if there's meaningful tax information
                          $hasTaxInfo = false;
                          if (!empty($paidInName) && $paidInName !== '……………………………') {
                              $hasTaxInfo = true;
                          }
                          if (!empty($holdingNo) && $holdingNo !== '……………………………') {
                              $hasTaxInfo = true;
                          }
                          if (!empty($paidLandAmount) && $paidLandAmount !== '……………………………') {
                              $hasTaxInfo = true;
                          }
                          if (!empty($englishYear) && $englishYear !== '……………………………') {
                              $hasTaxInfo = true;
                          }
                          if (!empty($banglaYear) && $banglaYear !== '……………………………') {
                              $hasTaxInfo = true;
                          }
                          
                          // Calculate section numbers dynamically
                          $namejariSectionNumber = $nextSectionNumber;
                          $taxSectionNumber = $namejariSectionNumber + ($hasNamejariInfo ? 1 : 0);
                          $noClaimSectionNumber = $taxSectionNumber + ($hasTaxInfo ? 1 : 0);
                      @endphp
                      
                      @if($hasTaxInfo)
                          <div class="ml-4 mt-2">                 
                              <strong>{{ $compensation->bnDigits($taxSectionNumber) }}. খাজনার বর্ণনা:</strong></br> দাখিলকৃত খাজনার রশিদ যাচাই করে দেখা যায়, {{ $paidInName }}
                              নামে {{ $compensation->bnDigits($holdingNo) }} নং হোল্ডিং এ {{ $compensation->bnDigits($paidLandAmount) }} একর জমির বিপরীতে বাংলা {{ $compensation->bnDigits($banglaYear) }} সন/ ইংরেজি {{ $compensation->bnDigits($englishYear) }} সাল পর্যন্ত ভূমি উন্নয়ন কর পরিশোধ অন্তে খাজনার রশিদ দাখিল করা হয়েছে।<br><br>
                          </div>
                      @endif
                      
                      <!-- No-Claim Description Section (Independent) -->
                      @if($kharijDetails)
                          <div class="ml-4 mt-2">
                              <strong>{{ $compensation->bnDigits($noClaimSectionNumber) }}. না-দাবীর বর্ণনা</strong></br>{{ $kharijDetails }}
                          </div>
                          <br><br>
                      @endif
                  @endif
                  
                  
                  @if($compensation->additional_documents_info && is_array($compensation->additional_documents_info) && isset($compensation->additional_documents_info['selected_types']) && count($compensation->additional_documents_info['selected_types']) > 0)
                      @foreach($compensation->additional_documents_info['selected_types'] as $docType)
                          @if($docType === 'আপস- বন্টননামা')
                              @if(isset($compensation->additional_documents_info['details'][$docType]) && $compensation->additional_documents_info['details'][$docType])
                                  <strong>আপস- বন্টননামা বর্ণনাঃ</strong></br> {{ $compensation->additional_documents_info['details'][$docType] }}
                              @endif
                          @elseif($docType === 'না-দাবি')
                              @if(isset($compensation->additional_documents_info['details'][$docType]) && $compensation->additional_documents_info['details'][$docType])
                                  <strong>না-দাবীনামা বর্ণনাঃ</strong></br> {{ $compensation->additional_documents_info['details'][$docType] }}
                              @endif
                          @elseif($docType === 'সরেজমিন তদন্ত')
                              @if(isset($compensation->additional_documents_info['details'][$docType]) && $compensation->additional_documents_info['details'][$docType])
                                  <strong>সরেজমিন তদন্ত প্রতিবেদন বর্ণনাঃ</strong></br> {{ $compensation->additional_documents_info['details'][$docType] }}
                              @endif
                          @elseif($docType === 'এফিডেভিট')
                              @if(isset($compensation->additional_documents_info['details'][$docType]) && $compensation->additional_documents_info['details'][$docType])
                                  <strong>এফিডেভিট বর্ণনাঃ</strong></br> {{ $compensation->additional_documents_info['details'][$docType] }}
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
                  <strong>কানুনগো ও সার্ভেয়ারের মতামতঃ</strong></br> দাখিলকৃত কাগজপত্র যাচাইপূর্বক কানুনগো ও সার্ভেয়ারগণের দাখিলকৃত প্রতিবেদনে উল্লেখ করা হয় যে আবেদনকারী মালিকানার দাবীর স্বপক্ষে কাগজপত্রের ধারাবাহিকতা আছে।
                  
                  <br>
                  
                  সার্বিক কাগজপত্রাদি পর্যালোচনা ও শুনানি অন্তে  প্রতীয়মান হয় যে আবেদনকারী 
                  @if($compensation->applicants && is_array($compensation->applicants) && count($compensation->applicants) > 0)
                      @if(count($compensation->applicants) == 1)
                          {{ $compensation->applicants[0]['name'] ?? '…………………………….' }}, পিতা: {{ $compensation->applicants[0]['father_name'] ?? '…………………………….' }}
                      @else
                          @foreach($compensation->applicants as $applicantIndex => $applicant)
                              @if($applicantIndex > 0)
                                  @if($applicantIndex == count($compensation->applicants) - 1)
                                      এবং
                                  @else
                                      ,
                                  @endif
                              @endif
                              {{ $compensation->bnDigits($applicantIndex + 1) }}. {{ $applicant['name'] ?? '…………………………….' }}, পিতা: {{ $applicant['father_name'] ?? '…………………………….' }}
                          @endforeach
                      @endif
                  @else
                      ………………………….
                  @endif
                  উক্ত ক্ষতিপূরণের প্রাপ্য অর্থের হকদার।
                  
                  <br></br>
                  <strong>অতএব আদেশ হয় যে,</strong> কানুনগো ও সার্ভেয়ারের দাখিলকৃত যৌথ প্রতিবেদন ও আবেদনকারীর কাগজপত্র পর্যালোচনা করে দেখা যায় আবেদিত সম্পত্তি প্রার্থীর ভোগ-দখলীয় সম্পত্তি, মালিকানাস্বত্বের কাগজপত্র সঠিক থাকায় 
                  @if($compensation->applicants && is_array($compensation->applicants) && count($compensation->applicants) > 0)
                      @if(count($compensation->applicants) == 1)
                          {{ $compensation->applicants[0]['name'] ?? '…………………………….' }}, পিতা: {{ $compensation->applicants[0]['father_name'] ?? '…………………………….' }}, সাং: {{ $compensation->applicants[0]['address'] ?? '…………………………….' }}
                      @else
                          @foreach($compensation->applicants as $applicantIndex => $applicant)
                              @if($applicantIndex > 0)
                                  @if($applicantIndex == count($compensation->applicants) - 1)
                                      এবং
                                  @else
                                      ,
                                  @endif
                              @endif
                              {{ $compensation->bnDigits($applicantIndex + 1) }}. {{ $applicant['name'] ?? '…………………………….' }}, পিতা: {{ $applicant['father_name'] ?? '…………………………….' }}, সাং: {{ $applicant['address'] ?? '…………………………….' }}
                          @endforeach
                      @endif
                  @else
                      …………………………., পিতা: …………………………., সাং: ………………………….
                  @endif
                  কে {{ $compensation->mouza_name ?? '…………………………….' }}/{{ $compensation->bnDigits($compensation->jl_no ?? '……………………………') }} মৌজার নিম্নে উল্লিখিত তফসিল বর্ণিত সম্পত্তির ক্ষতিপূরণ প্রদান করা হলো।
                  
                  @if($compensation->final_order && is_array($compensation->final_order) && count($compensation->final_order) > 0)
                  <br>
                  
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
                  
                  <br>
                  
                  <!-- Additional Instructions -->
                  <div class="text-justify leading-relaxed">
                    মোট ক্ষতিপূরণ বাবদ উৎস কর বাদে প্রদেয় = {{ $compensation->formatAmountBangla($finalAmount) }} ({{ $compensation->amountToBengaliWords($finalAmount) }} মাত্র) টাকার এল.এ চেক আবেদনকারীর নামে প্রয়োজনীয় বন্ড ও অঙ্গীকারনামা গ্রহণপূর্বক ইস্যু অন্তে জেলা হিসাবরক্ষণ অফিসে প্রেরণ করা হোক। সেই সাথে সিসি প্রস্তুতের জন্য সংশ্লিষ্ট সহকারীকে বলা হলো।
                  </div>
                  @endif
                </div>
                <br>
                <br>
                
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
