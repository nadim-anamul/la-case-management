<!DOCTYPE html>
<html lang="bn">
<head>
  <meta charset="UTF-8">
  <title>ক্ষতিপূরণ কেসে উপস্থাপন</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Embedded Noto Serif Bengali font -->
  <style>
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
      height: 297mm;
      margin: 0 auto;
      padding: 20mm;
      background: white;
      box-sizing: border-box;
    }
    table {
      table-layout: fixed;
    }
    @media print {
      body { margin: 0; }
      .a4 { 
        width: 210mm; 
        height: 297mm; 
        margin: 0; 
        padding: 20mm;
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
    <div class="flex justify-between mb-4">
      <span>আদেশ পত্র তারিখ: ………………………….</span>
      <span>হইতে: ………………………….পর্যন্ত</span>
    </div>

    <!-- Region Row -->
    <div class="flex justify-between mb-4">
      <span>জেলা: {{ $compensation->district ?? '…………………………….' }}</span>
      <span>সাল: …………………………. পর্যন্ত</span>
    </div>

    <!-- Case Info -->
    <div class="flex justify-between mb-4">
      <span>মামলার ধরন: ক্ষতিপূরণ কেস নং: {{ $compensation->case_number ?? 'N/A' }}</span> 
      <span>এল.এ কেস: {{ $compensation->la_case_no ?? 'N/A' }}</span>
    </div>

    <!-- Orders Table with wide second column -->
    <table class="w-full border border-black border-collapse mb-6">
      <thead>
        <tr>
          <th class="border border-black p-2 w-[35mm]">আদেশের ক্রমিক নং ও তারিখ</th>
          <th class="border border-black p-2">আদেশ ও অফিসারের স্বাক্ষর</th>
          <th class="border border-black p-2 w-[35mm]">আদেশের উপর গৃহীত ব্যবস্থা</th>
        </tr>
      </thead>
      <tbody>
        <tr class="align-top">
          <td class="border border-black p-4 h-[90mm]"></td>
          <td class="border border-black p-4">
            @if($compensation->applicants && is_array($compensation->applicants) && count($compensation->applicants) > 0)
                @php $applicant = $compensation->applicants[0]; @endphp
                <p class="text-sm">{{ $applicant['name'] ?? 'N/A' }}</p>
                <p class="text-sm">পিতা- {{ $applicant['father_name'] ?? 'N/A' }}, সাং- {{ $applicant['address'] ?? 'N/A' }}</p>
                <p class="text-sm">উপজেলা- {{ $compensation->upazila ?? 'N/A' }}, জেলা: বগুড়া</p> 
            @else
                <p class="text-sm">(আবেদনকারীর নাম)</p>
                <p class="text-sm">পিতা- (পিতার নাম), সাং- (ঠিকানা)</p>
                <p class="text-sm">উপজেলা- (উপজেলার নাম), জেলা: বগুড়া</p> 
            @endif
            <br>
            <p>নিম্ন তফসিল বর্ণিত সম্পত্তির ক্ষতিপূরণ দাবী করে আবেদন দাখিল করেছেন</p>
            <br>
            <p>উপজেলা: {{ $compensation->upazila ?? 'N/A' }}</p>
            <p>মৌজা: {{ $compensation->mouza_name ?? 'N/A' }}</p>
            <p>জেএল নং: {{ $compensation->jl_no ?? 'N/A' }}</p>
            <p>খতিয়ান নং: {{ $compensation->sa_khatian_no ?? $compensation->rs_khatian_no ?? 'N/A' }}</p>
            <p>দাগ নং: {{ $compensation->plot_no ?? 'N/A' }}</p>
            <p>আবেদনকৃত ক্ষতিপূরণের ধরণ: 
                @if($compensation->award_type && is_array($compensation->award_type))
                    {{ implode(', ', $compensation->award_type) }}
                @else
                    {{ $compensation->award_type ?? 'N/A' }}
                @endif
            </p>
            <p>অধিগ্রহণকৃত জমির পরিমাণ (একরে): 
                @if($compensation->land_category && is_array($compensation->land_category) && count($compensation->land_category) > 0)
                    {{ $compensation->land_category[0]['total_land'] ?? 'N/A' }}
                @else
                    N/A
                @endif
            </p>
            <p>দাবীকৃত জমির পরিমাণ (একরে): 
                @if($compensation->land_category && is_array($compensation->land_category) && count($compensation->land_category) > 0)
                    {{ $compensation->land_category[0]['total_land'] ?? 'N/A' }}
                @else
                    N/A
                @endif
            </p>
            
            <br><br>
            <p>আবেদিত জমি {{ $compensation->la_case_no ?? 'N/A' }} নং এল.এ কেসে অধিগ্রহণ করা হয়েছে। উক্ত জমির ক্ষতিপূরণ বাবদ 
                @if($compensation->award_type && is_array($compensation->award_type) && in_array('জমি ও গাছপালা', $compensation->award_type))
                    @if($compensation->land_award_serial_no && $compensation->tree_award_serial_no)
                        জমির রোয়েদাদ নং {{ $compensation->land_award_serial_no }} এবং গাছপালার রোয়েদাদ নং {{ $compensation->tree_award_serial_no }}
                    @elseif($compensation->land_award_serial_no)
                        জমির রোয়েদাদ নং {{ $compensation->land_award_serial_no }}
                    @elseif($compensation->tree_award_serial_no)
                        গাছপালার রোয়েদাদ নং {{ $compensation->tree_award_serial_no }}
                    @else
                        N/A
                    @endif
                @elseif($compensation->land_award_serial_no)
                    {{ $compensation->land_award_serial_no }}
                @elseif($compensation->tree_award_serial_no)
                    {{ $compensation->tree_award_serial_no }}
                @elseif($compensation->infrastructure_award_serial_no)
                    {{ $compensation->infrastructure_award_serial_no }}
                @else
                    N/A
                @endif
                নং এওয়ার্ড প্রার্থীর নামে আছে/নাই। আবেদনকারীকে নোটিশ প্রদান করা হোক। শুনানির জন্য পরবর্তী তারিখঃ  ............... খ্রি: .............</p>
            <br><br>
            <div class="text-right font-bold">
              <p>ভূমি অধিগ্রহণ কর্মকর্তা</p>
              <p>বগুড়া</p>
            </div>
          </td>
          <td class="border border-black p-4"></td>
        </tr>
      </tbody>
    </table>
  </div>
</body>
</html>
