<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>নোটিশ প্রিভিউ</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Noto Sans Bengali', 'Lohit Bengali', 'DejaVu Sans', 'Liberation Sans', Arial, sans-serif;
        }
    </style>
</head>
<body class="bg-gray-300">
    <!-- Back Button -->
    <div class="container mx-auto px-4 py-4">
        <div class="flex justify-between items-center">
            <a href="{{ route('compensation.preview', $compensation->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-bold rounded">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                ফিরে যান
            </a>
            <div class="flex space-x-3">
                <a href="{{ route('compensation.notice.pdf', $compensation->id) }}" target="_blank" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow-lg hover:shadow-xl transition-all duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    PDF ডাউনলোড করুন
                </a>
            </div>
        </div>
    </div>

    <div class="bg-white w-[21cm] min-h-[29.7cm] mx-auto my-8 p-10 shadow-lg text-[16px] leading-8">
        @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            {{ session('error') }}
        </div>
        @endif
        
        <div class="text-center">
            <h1 class="text-xl font-bold">গণপ্রজাতন্ত্রী বাংলাদেশ সরকার</h1>
            <h2 class="text-lg font-bold">জেলা প্রশাসকের কার্যালয়</h2>
            <h2 class="text-lg font-bold">বগুড়া</h2>
            <h3>(ভূমি অধিগ্রহণ শাখা)</h3>
        </div>

        <h2 class="text-center font-bold underline my-8 text-lg">নোটিশ</h2>

        <div class="grid grid-cols-2 gap-5 mb-5">
            <div>
                <p class="mb-1">প্রসেস নং:</p>
                <p class="mb-1">ক্ষতিপূরণ কেস নং: {{ $compensation->la_case_no ?? 'N/A' }}</p>
            </div>
            <div class="flex flex-col items-center text-center">
                <p class="mb-1">তারিখ: ............................</p>
                <p class="mb-1">এল.এ কেস নং: {{ $compensation->la_case_no ?? 'N/A' }}</p>
            </div>
        </div>

        <div class="mt-6">
            <table class="w-full border border-black">
                <thead>
                    <tr>
                        <th class="border border-black p-2">আবেদনকারীর নাম ও ঠিকানা</th>
                        <th class="border border-black p-2">রোয়েদাদভুক্ত মালিকের নাম</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border border-black p-2 align-top">
                            @if($compensation->applicants && is_array($compensation->applicants))
                                @foreach($compensation->applicants as $index => $applicant)
                                    @if($index > 0)<br>@endif
                                    {{ $applicant['name'] ?? 'N/A' }}<br>
                                    পিতার নাম- {{ $applicant['father_name'] ?? 'N/A' }}<br>
                                    সাং- {{ $applicant['address'] ?? 'N/A' }}
                                @endforeach
                            @else
                                <span class="text-gray-500">কোন আবেদনকারী নেই</span>
                            @endif
                        </td>
                        <td class="border border-black p-2 align-top">
                            @if($compensation->award_holder_names && is_array($compensation->award_holder_names))
                                @foreach($compensation->award_holder_names as $index => $holder)
                                    @if($index > 0)<br>@endif
                                    {{ $holder['name'] ?? 'N/A' }}
                                @endforeach
                            @else
                                <span class="text-gray-500">কোন রোয়েদাদভুক্ত মালিক নেই</span>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        

        <p class="mt-6 text-justify">
            এতদ্বারা জানানো যাচ্ছে যে, নিম্ন তফসিল বর্ণিত সম্পত্তির ক্ষতিপূরণের বিষয়টি নিষ্পত্তির লক্ষ্যে শুনানীর জন্য আগামী <strong>............................</strong> ইং তারিখ দিন ধার্য করা হয়েছে। ধার্য তারিখে বেলা ৯.৩০ ঘটিকায় ক্ষতিপূরণ প্রাপ্তির স্বপক্ষে যাবতীয় প্রমাণাদির মূল কপিসহ শুনানীতে উপস্থিত হওয়ার জন্য বলা হলো।
        </p>
        <p class="text-justify">অন্যথায় বিধি মোতাবেক পরবর্তী আইনগত ব্যবস্থা গ্রহণ করা হবে।</p>

        <p class="mt-6 font-bold">তফসিলঃ</p>
        <p>উপজেলা: বগুড়া সদর</p>
        <p>মৌজা: {{ $compensation->mouza_name ?? 'N/A' }}</p>

        <table class="w-full border border-black mt-4">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border border-black p-2">খতিয়ান নং</th>
                    <th class="border border-black p-2">দাগ নং</th>
                    <th class="border border-black p-2">পরিমাণ (একরে)</th>
                    <th class="border border-black p-2">আবেদনকৃত ক্ষতিপূরণের ধরণ</th>
                </tr>
            </thead>
            <tbody>
                @if($compensation->land_category && is_array($compensation->land_category) && count($compensation->land_category) > 0)
                    @foreach($compensation->land_category as $category)
                    <tr>
                        <td class="border border-black p-2">{{ $compensation->sa_khatian_no ?? $compensation->rs_khatian_no ?? 'N/A' }}</td>
                        <td class="border border-black p-2">{{ $compensation->plot_no ?? 'N/A' }}</td>
                        <td class="border border-black p-2">{{ $category['total_land'] ?? 'N/A' }}</td>
                        <td class="border border-black p-2">
                            @if($compensation->award_type && is_array($compensation->award_type))
                                {{ implode(', ', $compensation->award_type) }}
                            @else
                                {{ $compensation->award_type ?? 'N/A' }}
                            @endif
                        </td>
                    </tr>
                    @endforeach
                @else
                <tr>
                    <td class="border border-black p-2">{{ $compensation->sa_khatian_no ?? $compensation->rs_khatian_no ?? 'N/A' }}</td>
                    <td class="border border-black p-2">{{ $compensation->plot_no ?? 'N/A' }}</td>
                    <td class="border border-black p-2">N/A</td>
                    <td class="border border-black p-2">
                        @if($compensation->award_type && is_array($compensation->award_type))
                            {{ implode(', ', $compensation->award_type) }}
                        @else
                            {{ $compensation->award_type ?? 'N/A' }}
                        @endif
                    </td>
                </tr>
                @endif
            </tbody>
        </table>

        <div class="mt-20 text-right font-bold">
            <p>ভূমি অধিগ্রহণ কর্মকর্তা</p>
            <p>বগুড়া</p>
        </div>
    </div>
</body>
</html>
