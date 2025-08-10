@extends('layouts.app')

@section('title', 'ক্ষতিপূরণ কেসে উপস্থাপন')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-800">ক্ষতিপূরণ কেসে উপস্থাপন</h1>
        <div class="space-x-4">
            <a href="{{ route('compensation.present.preview', $compensation->id) }}" target="_blank" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow-lg hover:shadow-xl transition-all duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                উপস্থাপনা প্রিভিউ
            </a>
            <a href="{{ route('compensation.present.pdf', $compensation->id) }}" target="_blank" class="inline-flex items-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg shadow-lg hover:shadow-xl transition-all duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                PDF ডাউনলোড
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
                <label class="font-semibold text-gray-700">মৌজার নাম:</label>
                <p class="text-gray-900">{{ $compensation->mouza_name }}</p>
            </div>
        </div>
    </div>

    <!-- Presentation Form -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4 text-blue-600 border-b pb-2">
            <span class="section-icon">২</span>
            উপস্থাপনার তথ্য
        </h2>
        <form action="{{ route('compensation.present.store', $compensation->id) }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="floating-label">
                    <input type="text" name="presentation_date" id="presentation_date" class="form-input" placeholder=" " required>
                    <label for="presentation_date">উপস্থাপনার তারিখ <span class="text-red-500">*</span></label>
                </div>
                <div class="floating-label">
                    <input type="text" name="presentation_time" id="presentation_time" class="form-input" placeholder=" " required>
                    <label for="presentation_time">উপস্থাপনার সময় <span class="text-red-500">*</span></label>
                </div>
                <div class="floating-label">
                    <input type="text" name="presentation_venue" id="presentation_venue" class="form-input" placeholder=" " required>
                    <label for="presentation_venue">উপস্থাপনার স্থান <span class="text-red-500">*</span></label>
                </div>
                <div class="floating-label">
                    <input type="text" name="presenting_officer" id="presenting_officer" class="form-input" placeholder=" " required>
                    <label for="presenting_officer">উপস্থাপনাকারী কর্মকর্তা <span class="text-red-500">*</span></label>
                </div>
                <div class="md:col-span-2">
                    <label class="font-semibold text-gray-700 mb-2">উপস্থাপনার বিবরণ:</label>
                    <textarea name="presentation_details" rows="4" class="form-input w-full" placeholder="উপস্থাপনার বিস্তারিত বিবরণ লিখুন"></textarea>
                </div>
                <div class="md:col-span-2">
                    <label class="font-semibold text-gray-700 mb-2">বিশেষ নোট:</label>
                    <textarea name="special_notes" rows="3" class="form-input w-full" placeholder="কোন বিশেষ নোট থাকলে লিখুন"></textarea>
                </div>
            </div>
            
            <div class="mt-6 flex justify-end space-x-4">
                <button type="submit" class="btn-primary">
                    উপস্থাপনা সংরক্ষণ করুন
                </button>
            </div>
        </form>
    </div>

    <!-- Previous Presentations -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4 text-blue-600 border-b pb-2">
            <span class="section-icon">৩</span>
            পূর্ববর্তী উপস্থাপনা
        </h2>
        <div class="text-center text-gray-500 py-8">
            <svg class="w-12 h-12 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <p>কোন পূর্ববর্তী উপস্থাপনা নেই</p>
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
