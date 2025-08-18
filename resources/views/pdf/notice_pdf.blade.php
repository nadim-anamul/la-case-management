<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>নোটিশ</title>
    
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
        .notice-page {
            width: 21cm;
            height: 29.7cm;
            margin: 0 auto;
            padding: 10mm; /* Reduced from 15mm for more compact layout */
            background: white;
            box-sizing: border-box;
        }
        .notice-header {
            text-align: center;
            margin-bottom: 15px; /* Reduced from 20px */
        }
        .notice-title {
            text-align: center;
            font-weight: bold;
            text-decoration: underline;
            margin: 10px 0; /* Reduced from 20px 0 */
            font-size: 14px; /* Reduced from 18px */
        }
        .notice-content {
            font-size: 14px;
            line-height: 1.5; /* Reduced from 1.6 */
        }
        .notice-table {
            width: 100%;
            border-collapse: collapse;
            margin: 12px 0; /* Reduced from 15px 0 */
        }
        .notice-table th,
        .notice-table td {
            border: 1px solid black;
            padding: 6px; /* Reduced from 8px */
            text-align: left;
        }
        .notice-table th {
            background-color: #f3f4f6;
            font-weight: bold;
        }
        .notice-signature {
            margin-top: 30px; /* Reduced from 40px */
            text-align: right;
            font-weight: bold;
        }
        br { line-height: 0.5; margin: 0; padding: 0; }
        br + br { margin-top: 4px; }
        @media print {
            body { margin: 0; }
            .notice-page { 
                width: 21cm; 
                height: 29.7cm; 
                margin: 0; 
                padding: 10mm; /* Maintain compact padding for print */
                box-shadow: none;
            }
        }
    </style>
</head>
<body>
    <div class="notice-page">
        <div class="notice-header">
            <h1 style="font-size: 16px; font-weight: bold; margin: 0;">গণপ্রজাতন্ত্রী বাংলাদেশ সরকার</h1>
            <h2 style="font-size: 14px; font-weight: bold; margin: 3px 0;">জেলা প্রশাসকের কার্যালয়</h2>
            <h2 style="font-size: 14px; font-weight: bold; margin: 3px 0;">বগুড়া</h2>
            <h3 style="font-size: 13px; margin: 3px 0;">(ভূমি অধিগ্রহণ শাখা)</h3>
        </div>

        <div class="notice-title">নোটিশ</div>

        <div class="notice-content">
            <div class="grid grid-cols-2 gap-5 mb-5">
                <div>
                    <p class="mb-1">প্রসেস নং:</p>
                    <p class="mb-1">ক্ষতিপূরণ কেস নং: {{ $compensation->getBengaliValue('case_number') ?? 'N/A' }}</p>
                </div>
                <div class="flex flex-col items-center">
                    <p class="mb-1">তারিখ: ............................</p>
                    <p class="mb-1">এল.এ কেস নং: {{ $compensation->getBengaliValue('la_case_no') ?? 'N/A' }}</p>
                </div>
            </div>

            <table class="notice-table">
                <thead>
                    <tr>
                        <th class="border border-black p-2 w-1/2">আবেদনকারীর নাম ও ঠিকানা</th>
                        <th class="border border-black p-2 w-1/2">রোয়েদাদভুক্ত মালিকের নাম ও ঠিকানা</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="vertical-align: top;">
                            @if($compensation->applicants && is_array($compensation->applicants))
                                @foreach($compensation->applicants as $index => $applicant)
                                    @if($index > 0)<br>@endif
                                    <strong>#{{ $index + 1 }}:</strong><br>
                                    {{ $applicant['name'] ?? 'N/A' }}<br>
                                    পিতার নাম- {{ $applicant['father_name'] ?? 'N/A' }}<br>
                                    সাং- {{ $applicant['address'] ?? 'N/A' }}@if(isset($applicant['mobile']) && $applicant['mobile'])<br>মোবাইল- {{$compensation->bnDigits($applicant['mobile']) }}@endif
                                @endforeach
                            @else
                                <span style="color: #6b7280;">কোন আবেদনকারী নেই</span>
                            @endif
                        </td>
                        <td style="vertical-align: top;">
                            @if($compensation->award_holder_names && is_array($compensation->award_holder_names))
                                @foreach($compensation->award_holder_names as $index => $holder)
                                    @if($index > 0)<br>@endif
                                    <strong>#{{ $index + 1 }}:</strong><br>
                                    {{ $holder['name'] ?? 'N/A' }}<br>
                                    @if(isset($holder['father_name']) && $holder['father_name'])পিতার নাম- {{ $holder['father_name'] }}<br>@endif
                                    @if(isset($holder['address']) && $holder['address'])সাং- {{ $holder['address'] }}@endif
                                @endforeach
                            @else
                                <span style="color: #6b7280;">কোন রোয়েদাদভুক্ত মালিক নেই</span>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>

            <p style="margin: 10px 0; text-align: justify;">
                এতদ্বারা জানানো যাচ্ছে যে, নিম্ন তফসিল বর্ণিত সম্পত্তির ক্ষতিপূরণের বিষয়টি নিষ্পত্তির লক্ষ্যে শুনানীর জন্য আগামী <strong>............................</strong> ইং তারিখ দিন ধার্য করা হয়েছে। ধার্য তারিখে বেলা ৯.৩০ ঘটিকায় ক্ষতিপূরণ প্রাপ্তির স্বপক্ষে যাবতীয় প্রমাণাদির মূল কপিসহ শুনানীতে উপস্থিত হওয়ার জন্য বলা হলো।
            </p>
            <p style="margin: 5px 0; text-align: justify;">
                অন্যথায় বিধি মোতাবেক পরবর্তী আইনগত ব্যবস্থা গ্রহণ করা হবে।
            </p>

            <p style="margin: 3px 0; font-weight: bold;">তফসিলঃ</p>
            <p style="margin: 3px 0;">জেলা: {{ $compensation->district ?? 'তথ্য নেই' }}</p>
            <p style="margin: 3px 0;">উপজেলা: {{ $compensation->upazila ?? 'তথ্য নেই' }}</p>
            <p style="margin: 3px 0;">মৌজা: {{ $compensation->mouza_name ?? 'তথ্য নেই' }}</p>

            <table class="w-full border border-black mt-4">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border border-black p-2">রোয়েদাদ নং</th>
                        <th class="border border-black p-2">খতিয়ান নং</th>
                        <th class="border border-black p-2">দাগ নং</th>
                        <th class="border border-black p-2">রোয়েদাদের ধরন</th>
                        <th class="border border-black p-2">পরিমাণ (একরে)</th>
                    </tr>
                </thead>
                <tbody>
                    @if($compensation->award_type && is_array($compensation->award_type))
                        @if(in_array('জমি', $compensation->award_type) && $compensation->land_category && is_array($compensation->land_category))
                            @foreach($compensation->land_category as $index => $category)
                            <tr>
                                <td class="border border-black p-2">{{ $compensation->bnDigits($compensation->land_award_serial_no ?? 'N/A') }}</td>
                                <td class="border border-black p-2">{{ $compensation->bnDigits($compensation->sa_khatian_no ?? $compensation->rs_khatian_no ?? 'N/A') }}</td>
                                <td class="border border-black p-2">{{ $compensation->bnDigits($compensation->plot_no ?? 'N/A') }}</td>
                                <td class="border border-black p-2">জমির রোয়েদাদ ({{ $category['category_name'] ?? 'N/A' }})</td>
                                <td class="border border-black p-2">{{ $compensation->bnDigits(number_format($category['total_land'] ?? 0, 4)) }}</td>
                            </tr>
                            @endforeach
                        @endif
                        
                        @if(in_array('গাছপালা/ফসল', $compensation->award_type) && $compensation->tree_compensation)
                        <tr>
                            <td class="border border-black p-2">{{ $compensation->bnDigits($compensation->tree_award_serial_no ?? 'N/A') }}</td>
                            <td class="border border-black p-2">{{ $compensation->bnDigits($compensation->sa_khatian_no ?? $compensation->rs_khatian_no ?? 'N/A') }}</td>
                            <td class="border border-black p-2">{{ $compensation->bnDigits($compensation->plot_no ?? 'N/A') }}</td>
                            <td class="border border-black p-2">গাছপালা/ফসলের রোয়েদাদ</td>
                            <td class="border border-black p-2">-</td>
                        </tr>
                        @endif
                        
                        @if(in_array('অবকাঠামো', $compensation->award_type) && $compensation->infrastructure_compensation)
                        <tr>
                            <td class="border border-black p-2">{{ $compensation->bnDigits($compensation->infrastructure_award_serial_no ?? 'N/A') }}</td>
                            <td class="border border-black p-2">{{ $compensation->bnDigits($compensation->sa_khatian_no ?? $compensation->rs_khatian_no ?? 'N/A') }}</td>
                            <td class="border border-black p-2">{{ $compensation->bnDigits($compensation->plot_no ?? 'N/A') }}</td>
                            <td class="border border-black p-2">অবকাঠামোর রোয়েদাদ</td>
                            <td class="border border-black p-2">-</td>
                        </tr>
                        @endif
                    @else
                    <tr>
                        <td class="border border-black p-2" colspan="6" class="text-center">কোন রোয়েদাদ পাওয়া যায়নি</td>
                    </tr>
                    @endif
                </tbody>
            </table>
            </br>
        </br>

            <div class="notice-signature">
                <p style="margin: 5px 0;">ভূমি অধিগ্রহণ কর্মকর্তা</p>
                <p style="margin: 5px 0;">বগুড়া</p>
            </div>
        </div>
    </div>
</body>
</html>
