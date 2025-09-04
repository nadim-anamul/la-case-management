<!DOCTYPE html>
<html lang="bn">
<head>
  <meta charset="UTF-8">
  <title>ক্ষতিপূরণ কেসে উপস্থাপন</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Tiro+Bangla&display=swap" rel="stylesheet">

  <!-- Embedded Noto Serif Bengali font -->
  <style>
    body {
        margin: 0;
        padding: 0;
        font-family: 'Tiro Bangla', serif;
    }
    .a4 {
      width: 210mm;
      height: 297mm;
      margin: 0 auto;
      padding: 12mm; /* Reduced from 20mm for more compact layout */
      background: white;
      box-sizing: border-box;
    }
    p {
      font-size: 14px;
    }
    div >span {
      font-size: 14px;
    }
    table {
      table-layout: fixed;
    }
    br { line-height: 0.5; margin: 0; padding: 0; }
    br + br { margin-top: 4px; }
    @media print {
      body { margin: 0; }
      .a4 { 
        width: 210mm; 
        height: 297mm; 
        margin: 0; 
        padding: 12mm; /* Maintain compact padding for print */
        box-shadow: none;
      }
    }
  </style>
</head>
<body>
  <div class="a4">
    <!-- Title -->
    <h1 class="text-center text-lg font-bold">আদেশ পত্র</h1>
    <p class="text-center text-sm mb-1">( ১৯১৭ সালের রেকর্ড ম্যানুয়েলের ১২৯ নং বিধি )</p>

    <!-- Date Row -->
    <div class="flex justify-between mb-1">
      <span>আদেশ পত্র তারিখ: ………………………….</span>
      <span>হইতে: ………………………….পর্যন্ত</span>
    </div>

    <!-- Region Row -->
    <div class="flex justify-between mb-1">
      <span>জেলা: {{ $compensation->district ?? '…………………………….' }}</span>
      <span>সাল: …………………………. পর্যন্ত</span>
    </div>

    <!-- Case Info -->
    <div class="flex justify-between mb-1">
      <span>মামলার ধরন: ক্ষতিপূরণ কেস নং: {{ $compensation->getBengaliValue('case_number') ?? 'N/A' }}</span> 
      <span>এল.এ কেস: {{ $compensation->getBengaliValue('la_case_no') ?? 'N/A' }}</span>
    </div>

    <!-- Orders Table with wide second column -->
    <table class="w-full border border-black border-collapse mb-6 h-[220mm]">
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
            @if($compensation->applicants && is_array($compensation->applicants) && count($compensation->applicants) > 0)
                @foreach($compensation->applicants as $applicant)
                    <p>@if(count($compensation->applicants) > 1){{ $compensation->bnDigits($loop->iteration) }}। @endif{{ $applicant['name'] ?? 'N/A' }}</p>
                    <p>পিতা- {{ $applicant['father_name'] ?? 'N/A' }}, সাং- {{ $applicant['address'] ?? 'N/A' }}</p>
                    @if(!$loop->last)@endif
                @endforeach
            @endif
            <br>
            <p>নিম্ন তফসিল বর্ণিত সম্পত্তির ক্ষতিপূরণ দাবী করে আবেদন দাখিল করেছেন</p>
            <p>উপজেলা: {{ $compensation->upazila ?? 'N/A' }}, মৌজা: {{ $compensation->mouza_name ?? 'N/A' }}</p>
            <p>জেএল নং: {{ $compensation->getBengaliValue('jl_no') ?? 'N/A' }}, খতিয়ান নং: {{ $compensation->bnDigits($compensation->plot_no ?? 'N/A') }}</p>
            <p>দাগ নং: @if($compensation->acquisition_record_basis == 'SA'){{ $compensation->getBengaliValue('sa_plot_no') ?? 'N/A' }}@else{{ $compensation->getBengaliValue('rs_plot_no') ?? 'N/A' }}@endif</p>
            <p>আবেদনকৃত ক্ষতিপূরণের ধরণ: 
                @if($compensation->award_type && is_array($compensation->award_type))
                    {{ implode(', ', $compensation->award_type) }}
                @else
                    {{ $compensation->award_type ?? 'N/A' }}
                @endif
            </p>
            @if($compensation->award_type && is_array($compensation->award_type))
              @if(in_array('জমি', $compensation->award_type) && $compensation->land_category && is_array($compensation->land_category))
                  @foreach($compensation->land_category as $index => $category)
                      <p class="ml-4">• জমির রোয়েদাদ নং {{ $compensation->bnDigits($compensation->land_award_serial_no ?? 'N/A') }}: {{ $category['category_name'] ?? 'N/A' }} - {{ $compensation->bnDigits(number_format($category['total_land'] ?? 0, 4)) }} একর জমি, ক্ষতিপূরণ: {{ $compensation->bnDigits(number_format($category['total_compensation'] ?? 0, 2)) }} টাকা, আবেদনকারীর দাবী :{{ (isset($category['applicant_land']) && is_numeric($category['applicant_land'])) ? $compensation->bnDigits(number_format($category['applicant_land'], 4)) : '..............' }} একর।</p>
                  @endforeach
              @endif
              
              @if(in_array('গাছপালা/ফসল', $compensation->award_type) && $compensation->tree_compensation)
                  <p class="ml-4">• গাছপালা/ফসলের রোয়েদাদ নং {{ $compensation->bnDigits($compensation->tree_award_serial_no ?? 'N/A') }}: ক্ষতিপূরণ {{ $compensation->bnDigits(number_format($compensation->tree_compensation, 2)) }} টাকা</p>
              @endif
              
              @if(in_array('অবকাঠামো', $compensation->award_type) && $compensation->infrastructure_compensation)
                  <p class="ml-4">• অবকাঠামোর রোয়েদাদ নং {{ $compensation->bnDigits($compensation->infrastructure_award_serial_no ?? 'N/A') }}: ক্ষতিপূরণ {{ $compensation->bnDigits(number_format($compensation->infrastructure_compensation, 2)) }} টাকা</p>
              @endif
          @else
              <p class="ml-4">কোন রোয়েদাদ পাওয়া যায়নি</p>
          @endif
            
            <br>
            <p>আবেদিত জমি {{ $compensation->bnDigits($compensation->la_case_no) ?? 'N/A' }} নং এল.এ কেসে অধিগ্রহণ করা হয়েছে। উক্ত জমির ক্ষতিপূরণ বাবদ 
                @php
                    $awardNumbers = [];
                    if ($compensation->land_award_serial_no) {
                        $awardNumbers[] = $compensation->land_award_serial_no;
                    }
                    if ($compensation->tree_award_serial_no) {
                        $awardNumbers[] = $compensation->tree_award_serial_no;
                    }
                    if ($compensation->infrastructure_award_serial_no) {
                        $awardNumbers[] = $compensation->infrastructure_award_serial_no;
                    }
                    
                    if (count($awardNumbers) > 0) {
                        echo 'রোয়েদাদ নং- ' . $compensation->bnDigits(implode(', ', $awardNumbers));
                    } else {
                        echo 'N/A';
                    }
                @endphp
                @if($compensation->is_applicant_in_award == 'yes')
                    প্রার্থীর নামে আছে।
                @else
                    প্রার্থীর নামে নাই।
                @endif
                বর্ণিত জমির বিষয়ে প্রার্থী কর্তৃক দাখিলকৃত কাগজপত্রের সাথে এ কার্যালয়ের রেকর্ডপত্র পর্যালোচনা করে প্রতিবেদন দাখিল করার জন্য সার্ভেয়ার জনাব ................................... ও কানুনগো জনাব ................................... কে বলা হলো।
                <br>
                আবেদনকারীকে নোটিশ প্রদান করা হোক। শুনানির জন্য পরবর্তী তারিখঃ  ............... </p>
            <br><br>
            <div class="text-right font-bold">
              <p>ভূমি অধিগ্রহণ কর্মকর্তা</p>
              <p>{{ $compensation->district ?? '…………………………….' }}</p>
            </div>
          </td>
          <td class="border border-black p-4"></td>
        </tr>
      </tbody>
    </table>
  </div>
</body>
</html>
