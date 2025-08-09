@extends('layouts.app')

@section('title', 'সকল পক্ষকে নোটিশ করুণ')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-800">সকল পক্ষকে নোটিশ করুণ</h1>
        <div class="space-x-4">
            <a href="{{ route('compensation.notice.preview', $compensation->id) }}" class="btn-primary">
                নোটিশ প্রিভিউ দেখুন
            </a>
            <a href="{{ route('compensation.notice.pdf', $compensation->id) }}" target="_blank" class="btn-secondary">
                নোটিশ PDF ডাউনলোড
            </a>
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
                <label class="font-semibold text-gray-700">জেলা:</label>
                <p class="text-gray-900">{{ $compensation->district ?? 'তথ্য নেই' }}</p>
            </div>
            <div>
                <label class="font-semibold text-gray-700">উপজেলা:</label>
                <p class="text-gray-900">{{ $compensation->upazila ?? 'তথ্য নেই' }}</p>
            </div>
            <div>
                <label class="font-semibold text-gray-700">মৌজার নাম:</label>
                <p class="text-gray-900">{{ $compensation->mouza_name }}</p>
            </div>
        </div>
    </div>

    <!-- Parties Information -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4 text-blue-600 border-b pb-2">
            <span class="section-icon">২</span>
            নোটিশ প্রাপক পক্ষসমূহ
        </h2>
        
        <!-- Applicants -->
        <div class="mb-6">
            <h3 class="font-semibold text-lg mb-3 text-green-600">আবেদনকারীগণ</h3>
            @foreach($compensation->applicants as $index => $applicant)
            <div class="bg-gray-50 p-4 rounded-lg mb-3">
                <h4 class="font-semibold text-lg mb-3 text-blue-600">#{{ $index + 1 }}</h4>
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
                </div>
            </div>
            @endforeach
        </div>

        <!-- Award Holders -->
        <div class="mb-6">
            <h3 class="font-semibold text-lg mb-3 text-green-600">রোয়েদাদভুক্ত মালিকগণ</h3>
            @foreach($compensation->award_holder_names as $index => $holder)
            <div class="bg-gray-50 p-4 rounded-lg mb-3">
                <h4 class="font-semibold text-lg mb-3 text-green-600">#{{ $index + 1 }}</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="font-semibold text-gray-700">নাম:</label>
                        <p class="text-gray-900">{{ $holder['name'] }}</p>
                    </div>
                    @if(isset($holder['father_name']) && $holder['father_name'])
                    <div>
                        <label class="font-semibold text-gray-700">পিতার নাম:</label>
                        <p class="text-gray-900">{{ $holder['father_name'] }}</p>
                    </div>
                    @endif
                    @if(isset($holder['address']) && $holder['address'])
                    <div class="md:col-span-2">
                        <label class="font-semibold text-gray-700">ঠিকানা:</label>
                        <p class="text-gray-900">{{ $holder['address'] }}</p>
                    </div>
                    @endif
                    <div>
                        <label class="font-semibold text-gray-700">মালিকানা ধরন:</label>
                        <p class="text-gray-900">রোয়েদাদভুক্ত মালিক</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Objectors (if any) -->
        @if($compensation->objector_details)
        <div class="mb-6">
            <h3 class="font-semibold text-lg mb-3 text-green-600">আপত্তিকারীগণ</h3>
            <div class="bg-gray-50 p-4 rounded-lg mb-3">
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="font-semibold text-gray-700">আপত্তির বিবরণ:</label>
                        <p class="text-gray-900">{{ $compensation->objector_details }}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Notice Form -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4 text-blue-600 border-b pb-2">
            <span class="section-icon">৩</span>
            নোটিশের তথ্য
        </h2>
        <form action="{{ route('compensation.notice.store', $compensation->id) }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="floating-label">
                    <input type="text" name="notice_date" id="notice_date" class="form-input" placeholder=" " required>
                    <label for="notice_date">নোটিশের তারিখ <span class="text-red-500">*</span></label>
                </div>
                <div class="floating-label">
                    <input type="text" name="notice_type" id="notice_type" class="form-input" placeholder=" " required>
                    <label for="notice_type">নোটিশের ধরন <span class="text-red-500">*</span></label>
                </div>
                <div class="floating-label">
                    <input type="text" name="notice_delivery_method" id="notice_delivery_method" class="form-input" placeholder=" " required>
                    <label for="notice_delivery_method">নোটিশ প্রেরণের পদ্ধতি <span class="text-red-500">*</span></label>
                </div>
                <div class="floating-label">
                    <input type="text" name="notice_recipient" id="notice_recipient" class="form-input" placeholder=" " required>
                    <label for="notice_recipient">নোটিশ প্রাপক <span class="text-red-500">*</span></label>
                </div>
                <div class="md:col-span-2">
                    <label class="font-semibold text-gray-700 mb-2">নোটিশের বিষয়বস্তু:</label>
                    <textarea name="notice_content" rows="4" class="form-input w-full" placeholder="নোটিশের বিস্তারিত বিষয়বস্তু লিখুন" required></textarea>
                </div>
                <div class="md:col-span-2">
                    <label class="font-semibold text-gray-700 mb-2">বিশেষ নির্দেশনা:</label>
                    <textarea name="special_instructions" rows="3" class="form-input w-full" placeholder="কোন বিশেষ নির্দেশনা থাকলে লিখুন"></textarea>
                </div>
            </div>
            
            <div class="mt-6 flex justify-end space-x-4">
                <button type="submit" class="btn-primary">
                    নোটিশ প্রেরণ করুন
                </button>
            </div>
        </form>
    </div>

    <!-- Previous Notices -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4 text-blue-600 border-b pb-2">
            <span class="section-icon">৪</span>
            পূর্ববর্তী নোটিশসমূহ
        </h2>
        <div class="text-center text-gray-500 py-8">
            <svg class="w-12 h-12 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4 19h16a2 2 0 002-2V7a2 2 0 00-2-2H4a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
            </svg>
            <p>কোন পূর্ববর্তী নোটিশ নেই</p>
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
</style>
@endsection
