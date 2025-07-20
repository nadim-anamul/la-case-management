@extends('layouts.app')

@section('title', 'আদেশপত্র সম্পাদনা করুন')

@section('content')
    <div class="container mx-auto p-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">আদেশপত্র সম্পাদনা করুন</h1>
            <a href="{{ route('order.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                &larr; Back to List
            </a>
        </div>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <p><strong>Please correct the errors below:</strong></p>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('order.update', $order->id) }}" method="POST" class="bg-white p-6 rounded-lg shadow-md">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
                 <fieldset class="border p-4 rounded">
                    <legend class="font-bold px-2">সাধারণ তথ্য</legend>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label for="district" class="block text-sm font-medium text-gray-700">জেলা</label>
                            <input type="text" name="district" id="district" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('district', $order->district) }}">
                        </div>
                        <div>
                            <label for="case_type" class="block text-sm font-medium text-gray-700">মামলার ধরণ</label>
                            <input type="text" name="case_type" id="case_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('case_type', $order->case_type) }}">
                        </div>
                        <div>
                            <label for="case_number" class="block text-sm font-medium text-gray-700">মামলার নং</label>
                            <input type="text" name="case_number" id="case_number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('case_number', $order->case_number) }}">
                        </div>
                        <div>
                            <label for="order_date" class="block text-sm font-medium text-gray-700">আদেশের তারিখ</label>
                            <input type="date" name="order_date" id="order_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('order_date', $order->order_date) }}">
                        </div>
                    </div>
                </fieldset>
                <fieldset class="border p-4 rounded">
                    <legend class="font-bold px-2">বিস্তারিত বিবরণ</legend>
                    <label for="applicant_name">আবেদনকারীগণের নাম</label>
                    <textarea name="applicant_name" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('applicant_name', $order->applicant_name) }}</textarea>
                    <label for="applicant_details">আবেদনকারীগণের বিবরণ</label>
                    <textarea name="applicant_details" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('applicant_details', $order->applicant_details) }}</textarea>
                    <label for="roedad_review">রোয়েদাদ বহি পর্যালোচনা</label>
                    <textarea name="roedad_review" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('roedad_review', $order->roedad_review) }}</textarea>
                    <label for="miss_case_details">মিসকেসের উদ্ভব</label>
                    <textarea name="miss_case_details" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('miss_case_details', $order->miss_case_details) }}</textarea>
                    <label for="sa_record_details">এস এ রেকর্ডপত্র পর্যালোচনা</label>
                    <textarea name="sa_record_details" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('sa_record_details', $order->sa_record_details) }}</textarea>
                    <label for="sa_owner_heir_details">এস এ রেকর্ডীয় মালিকের ওয়ারিশান সনদ পর্যালোচনা</label>
                    <textarea name="sa_owner_heir_details" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('sa_owner_heir_details', $order->sa_owner_heir_details) }}</textarea>
                    <label for="sa_heir_heir_details">এস এ রেকর্ডীয় মালিকের পুত্রের ওয়ারিশান সনদ পর্যালোচনা</label>
                    <textarea name="sa_heir_heir_details" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('sa_heir_heir_details', $order->sa_heir_heir_details) }}</textarea>
                    <label for="sa_heir_transfer_details_1">এস এ রেকর্ডী মালিকের ওয়ারিশমূলে প্রাপ্ত মালিকের হস্তান্তর (১)</label>
                    <textarea name="sa_heir_transfer_details_1" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('sa_heir_transfer_details_1', $order->sa_heir_transfer_details_1) }}</textarea>
                    <label for="sa_heir_transfer_details_2">এস এ রেকর্ডী মালিকের ওয়ারিশমূলে প্রাপ্ত মালিকের হস্তান্তর (২)</label>
                    <textarea name="sa_heir_transfer_details_2" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('sa_heir_transfer_details_2', $order->sa_heir_transfer_details_2) }}</textarea>
                    <label for="rs_khatian_details"> চূড়ান্ত আর এস খতিয়ান প্রকাশ</label>
                    <textarea name="rs_khatian_details" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('rs_khatian_details', $order->rs_khatian_details) }}</textarea>
                    <label for="rs_owner_heir_details">আর এস রেকর্ডীয় মালিকদ্বয়ের ওয়ারিশান সনদ পর্যালোচনা</label>
                    <textarea name="rs_owner_heir_details" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('rs_owner_heir_details', $order->rs_owner_heir_details) }}</textarea>
                    <label for="tax_review">ভূমি উন্নয়ন কর পর্যালোচনা</label>
                    <textarea name="tax_review" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('tax_review', $order->tax_review) }}</textarea>
                    <label for="no_claim_review">না-দাবী পর্যালোচনা</label>
                    <textarea name="no_claim_review" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('no_claim_review', $order->no_claim_review) }}</textarea>
                    <label for="investigation_review">সরেজমিন তদন্ত প্রতিবেদন পর্যালোচনা</label>
                    <textarea name="investigation_review" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('investigation_review', $order->investigation_review) }}</textarea>
                    <label for="applicant_claim">আবেদনকারীর দাবী</label>
                    <textarea name="applicant_claim" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('applicant_claim', $order->applicant_claim) }}</textarea>
                    <label for="overall_review">সার্বিক পর্যালোচনা</label>
                    <textarea name="overall_review" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('overall_review', $order->overall_review) }}</textarea>
                    <label for="final_order_summary">অতএব, আদেশ হয় যে,</label>
                    <textarea name="final_order_summary" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('final_order_summary', $order->final_order_summary) }}</textarea>
                    <label for="final_payment_order">পেমেন্ট আদেশ</label>
                    <textarea name="final_payment_order" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('final_payment_order', $order->final_payment_order) }}</textarea>
                </fieldset>
                <fieldset class="border p-4 rounded">
                    <legend class="font-bold px-2">ক্ষতিপূরণ ও স্বাক্ষর</legend>
                    <label for="compensation_details">ক্ষতিপূরণ টেবিল (JSON ফরম্যাট)</label>
                    <textarea name="compensation_details" rows="6" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm font-mono text-sm">{{ old('compensation_details', $order->compensation_details) }}</textarea>
                    <label for="total_compensation_words">মোট টাকা (কথায়)</label>
                    <input type="text" name="total_compensation_words" id="total_compensation_words" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('total_compensation_words', $order->total_compensation_words) }}">
                    <label for="lao_name">ভূমি অধিগ্রহণ কর্মকর্তার নাম</label>
                    <input type="text" name="lao_name" id="lao_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('lao_name', $order->lao_name) }}">
                    <label for="adc_name">অতিরিক্ত জেলা প্রশাসক (রাজস্ব) এর নাম</label>
                    <input type="text" name="adc_name" id="adc_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('adc_name', $order->adc_name) }}">
                </fieldset>
            </div>
            <div class="mt-8 flex justify-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Update Order
                </button>
            </div>
        </form>
    </div>
@endsection