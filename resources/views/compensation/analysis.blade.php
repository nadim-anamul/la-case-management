@extends('layouts.app')

@section('title', 'আবেদন ও দাখিলকৃত কাগজের বিশ্লেষণ প্রিন্ট করুণ')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-800">আবেদন ও দাখিলকৃত কাগজের বিশ্লেষণ প্রিন্ট করুণ</h1>
        <div class="space-x-4">
            <a href="{{ route('compensation.preview', $compensation->id) }}" class="btn-secondary">
                প্রিভিউতে ফিরে যান
            </a>
            <a href="{{ route('compensation.index') }}" class="btn-secondary">
                তালিকায় ফিরে যান
            </a>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
        {{ session('success') }}
    </div>
    @endif

    @if(session('info'))
    <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-6">
        {{ session('info') }}
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
        {{ session('error') }}
    </div>
    @endif

    @if($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Case Information Summary -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4 text-blue-600 border-b pb-2">
            <span class="section-icon">১</span>
            মামলার সংক্ষিপ্ত তথ্য
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
                <label class="font-semibold text-gray-700">যে রেকর্ড মূলে অধিগ্রহণ:</label>
                <p class="text-gray-900">{{ $compensation->acquisition_record_basis }}</p>
            </div>
            <div>
                <label class="font-semibold text-gray-700">দাগ নং:</label>
                <p class="text-gray-900">{{ $compensation->plot_no }}</p>
            </div>
            <div>
                <label class="font-semibold text-gray-700">মৌজার নাম:</label>
                <p class="text-gray-900">{{ $compensation->mouza_name }}</p>
            </div>
        </div>
    </div>

    <!-- Application Analysis -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4 text-blue-600 border-b pb-2">
            <span class="section-icon">২</span>
            আবেদনের বিশ্লেষণ
        </h2>
        
        <!-- Applicants Analysis -->
        <div class="mb-6">
            <h3 class="font-semibold text-lg mb-3 text-green-600">আবেদনকারীদের বিশ্লেষণ</h3>
            @foreach($compensation->applicants as $index => $applicant)
            <div class="bg-gray-50 p-4 rounded-lg mb-3">
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
                    <div>
                        <label class="font-semibold text-gray-700">আবেদনের বৈধতা:</label>
                        <p class="text-green-600 font-semibold">✓ বৈধ</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Award Analysis -->
        <div class="mb-6">
            <h3 class="font-semibold text-lg mb-3 text-green-600">রোয়েদাদের বিশ্লেষণ</h3>
            <div class="bg-gray-50 p-4 rounded-lg mb-3">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="font-semibold text-gray-700">রোয়েদাদের ধরন:</label>
                        <p class="text-gray-900">{{ is_array($compensation->award_type) ? implode(', ', $compensation->award_type) : $compensation->award_type }}</p>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-700">আবেদনকারী রোয়েদাদে আছে কিনা:</label>
                        <p class="text-gray-900">{{ $compensation->is_applicant_in_award ? 'হ্যাঁ' : 'না' }}</p>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-700">মোট ক্ষতিপূরণ:</label>
                        <p class="text-gray-900">
                            @php
                                $totalCompensation = 0;
                                if($compensation->land_category && is_array($compensation->land_category)) {
                                    foreach($compensation->land_category as $category) {
                                        $totalCompensation += floatval($category['total_compensation'] ?? 0);
                                    }
                                }
                                echo number_format($totalCompensation, 2) . ' টাকা';
                            @endphp
                        </p>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-700">রোয়েদাদের বৈধতা:</label>
                        <p class="text-green-600 font-semibold">✓ বৈধ</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ownership Analysis -->
        @if($compensation->ownership_details)
        <div class="mb-6">
            <h3 class="font-semibold text-lg mb-3 text-green-600">মালিকানার ধারাবাহিকতার বিশ্লেষণ</h3>
            <div class="bg-gray-50 p-4 rounded-lg mb-3">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="font-semibold text-gray-700">ধারাবাহিকতার ধরন:</label>
                        <p class="text-gray-900">
                            @if(isset($compensation->ownership_details['storySequence']) && count($compensation->ownership_details['storySequence']) > 0)
                                {{ count($compensation->ownership_details['storySequence']) }}টি ধাপে সম্পন্ন
                            @else
                                সরাসরি মালিকানা
                            @endif
                        </p>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-700">মালিকানার বৈধতা:</label>
                        <p class="text-green-600 font-semibold">✓ বৈধ</p>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Document Analysis -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4 text-blue-600 border-b pb-2">
            <span class="section-icon">৩</span>
            দাখিলকৃত কাগজের বিশ্লেষণ
        </h2>
        
        @if(isset($compensation->additional_documents_info['selected_types']) && !empty($compensation->additional_documents_info['selected_types']))
        <div class="space-y-4">
            @foreach($compensation->additional_documents_info['selected_types'] as $type)
            <div class="bg-gray-50 p-4 rounded-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="font-semibold text-gray-700">{{ $type }}</h4>
                        @if(isset($compensation->additional_documents_info['details'][$type]))
                        <p class="text-sm text-gray-600 mt-1">{{ $compensation->additional_documents_info['details'][$type] }}</p>
                        @endif
                    </div>
                    <div class="text-green-600 font-semibold">✓ দাখিলকৃত</div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center text-gray-500 py-8">
            <svg class="w-12 h-12 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <p>কোন অতিরিক্ত কাগজ দাখিল করা হয়নি</p>
        </div>
        @endif
    </div>

    <!-- Tax Information Analysis -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4 text-blue-600 border-b pb-2">
            <span class="section-icon">৪</span>
            খাজনার তথ্যের বিশ্লেষণ
        </h2>
        
        @if($compensation->tax_info)
        <div class="bg-gray-50 p-4 rounded-lg">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="font-semibold text-gray-700">যার নামে প্রদানকৃত:</label>
                    <p class="text-gray-900">{{ $compensation->tax_info['paid_in_name'] ?? 'অনুপলব্ধ' }}</p>
                </div>
                <div>
                    <label class="font-semibold text-gray-700">হোল্ডিং নম্বর:</label>
                    <p class="text-gray-900">{{ isset($compensation->tax_info['holding_no']) ? $compensation->bnDigits($compensation->tax_info['holding_no']) : 'অনুপলব্ধ' }}</p>
                </div>
                <div>
                    <label class="font-semibold text-gray-700">খাজনা প্রদানকৃত জমির পরিমাণ:</label>
                    <p class="text-gray-900">{{ $compensation->tax_info['paid_land_amount'] ?? 'অনুপলব্ধ' }}</p>
                </div>
                <div>
                    <label class="font-semibold text-gray-700">ইংরেজি বছর:</label>
                    <p class="text-gray-900">{{ isset($compensation->tax_info['english_year']) ? $compensation->bnDigits($compensation->tax_info['english_year']) : 'অনুপলব্ধ' }}</p>
                </div>
                <div>
                    <label class="font-semibold text-gray-700">বাংলা বছর:</label>
                    <p class="text-gray-900">{{ isset($compensation->tax_info['bangla_year']) ? $compensation->bnDigits($compensation->tax_info['bangla_year']) : 'অনুপলব্ধ' }}</p>
                </div>
                <div class="md:col-span-2">
                    <label class="font-semibold text-gray-700">খাজনার বৈধতা:</label>
                    <p class="text-green-600 font-semibold">✓ বৈধ</p>
                </div>
            </div>
        </div>
        @else
        <div class="text-center text-gray-500 py-8">
            <svg class="w-12 h-12 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <p>কোন খাজনার তথ্য নেই</p>
        </div>
        @endif
    </div>

    <!-- Print Options -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4 text-blue-600 border-b pb-2">
            <span class="section-icon">৫</span>
            প্রিন্ট অপশন
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <button onclick="window.print()" class="btn-action bg-blue-600 hover:bg-blue-700">
                <div class="flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    <span>প্রিন্ট করুন</span>
                </div>
            </button>
            <a href="{{ route('compensation.analysis.pdf', $compensation->id) }}" class="btn-action bg-green-600 hover:bg-green-700">
                <div class="flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span>PDF ডাউনলোড</span>
                </div>
            </a>
            <a href="{{ route('compensation.analysis.excel', $compensation->id) }}" class="btn-action bg-purple-600 hover:bg-purple-700">
                <div class="flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span>এক্সেল ডাউনলোড</span>
                </div>
            </a>
        </div>
    </div>
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

.btn-action {
    @apply text-white font-bold py-4 px-6 rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl;
}

@media print {
    .btn-action, .btn-primary, .btn-secondary {
        display: none !important;
    }
}
</style>
@endsection
