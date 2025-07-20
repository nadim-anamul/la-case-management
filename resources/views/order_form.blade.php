@extends('layouts.app')

@section('title', 'নতুন আদেশপত্র তথ্য ফরম')

@section('content')
    <div class="container mx-auto p-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">নতুন আদেশপত্র তথ্য ফরম</h1>
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

        <form action="{{ route('order.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow-md">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
                <fieldset class="border p-4 rounded">
                    <legend class="font-bold px-2">সাধারণ তথ্য</legend>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label for="district" class="block text-sm font-medium text-gray-700">জেলা</label>
                            <input type="text" name="district" id="district" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('district', 'বগুড়া') }}">
                        </div>
                        <div>
                            <label for="case_type" class="block text-sm font-medium text-gray-700">মামলার ধরণ</label>
                            <input type="text" name="case_type" id="case_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('case_type', 'এলএ কেস') }}">
                        </div>
                        <div>
                            <label for="case_number" class="block text-sm font-medium text-gray-700">মামলার নং</label>
                            <input type="text" name="case_number" id="case_number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('case_number', '০২/গ্যাস/২০২০') }}">
                        </div>
                        <div>
                            <label for="order_date" class="block text-sm font-medium text-gray-700">আদেশের তারিখ</label>
                            <input type="date" name="order_date" id="order_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('order_date', date('Y-m-d')) }}">
                        </div>
                    </div>
                </fieldset>
                <fieldset class="border p-4 rounded">
                    <legend class="font-bold px-2">বিস্তারিত বিবরণ</legend>
                    <label for="applicant_name">আবেদনকারীগণের নাম</label>
                    <textarea name="applicant_name" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('applicant_name', 'মোঃ মামুনুর রশিদ') }}</textarea>
                    <label for="applicant_details">আবেদনকারীগণের বিবরণ</label>
                    <textarea name="applicant_details" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('applicant_details', 'আবেদনকারী জনাব (১) মো: আনোয়ারুল ইসলাম, (২) মো: আমিরুল ইসলাম, (৩) মো: আতাউর রহমান, (৪) মো: মামুনুর রশিদ এবং (৫) মোছা: তাসজিনারা খাতুন, সর্ব পিং-মোঃ মজিবর রহমান, সাং-বাঘোপাড়া দঃ পাড়া, উপজেলা-বগুড়া সদর, জেলা-বগুড়া। আবেদনকারীগণবগুড়া সদর উপজেলাধীন ২৫ নং আশোকোলা মৌজার এসএ ৫৫৭ নং খতিয়ানের ৪১২৬ নং দাগের ০.০২৯০ একর ধানী জমির ও ফসলের ক্ষতিপূরণের টাকা প্রাপ্তির আবেদন করেছেন।') }}</textarea>
                    <label for="roedad_review">রোয়েদাদ বহি পর্যালোচনা</label>
                    <textarea name="roedad_review" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('roedad_review', 'রোয়েদাদের ২১ এবং ২১ নং ক্রমিকে আশোকোলা মৌজার ৪১২৬ নং দাগে ০.০২৯০ একর জমির ও ফসলের ক্ষতিপূরণ (১) মজ প্রামানিক, পিং-স্বরিপ প্রামানিক, সাং-বাঘোপাড়া, (২) মোছা: পাপিয়া বেগম দিং, জং-মৃত মুলু মন্ডল, আশোকোলা বগুড়া, (৩) আমিরুল ইসলাম, (৪) আতাউর রহমান, (৫) মামুনুর রশিদ, (৬) অনিরুল ইসলাম, সর্ব পিং-মৃত মজিবর রহমান, সাং বাঘোপাড়া, (৭) মজিবর রহমান, পিং-কাসেম আলী, (৮) আনোয়ারা বিবি, জং মজিবর রহমান নামে রোয়েদাদ প্রস্তুত আছে।') }}</textarea>
                    <label for="miss_case_details">মিসকেসের উদ্ভব</label>
                    <textarea name="miss_case_details" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('miss_case_details', 'এমতাবস্থায়, আবেদনকারীগণের নামে রোয়েদাদ প্রস্তুত থাকলেও আপোষ বন্টননামা না থাকায় এই মিসকেসের উদ্ভব হয়।') }}</textarea>
                    <label for="sa_record_details">এস এ রেকর্ডপত্র পর্যালোচনা</label>
                    <textarea name="sa_record_details" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('sa_record_details', 'বগুড়া সদর উপজেলাধীন ২৫ নং আশোকোলা মৌজার এস এ ৫৫৭ নং খতিয়ানের ৪১২৬ নং দাগে ০.১৪০০ একরসহ অন্যান্য দাগে সর্বমোট ০.৬৪০০ একর জমি মজ প্রামানিক, পিং-স্বরিপ প্রামানিক, সাং-রামশহরনামে রেকর্ডভুক্ত আছে।') }}</textarea>
                    <label for="sa_owner_heir_details">এস এ রেকর্ডীয় মালিকের ওয়ারিশান সনদ পর্যালোচনা</label>
                    <textarea name="sa_owner_heir_details" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('sa_owner_heir_details', 'এস এ রেকর্ডীয় মালিক মজ প্রামানিক, পিং-স্বরিপ প্রামানিকসাং-, বাঘোপাড়া, বগুড়া সদর, বগুড়া মৃত্যুবরণ করলে ০১ (এক) পুত্র কাসেম আলী ওয়ারিশ মর্মে দাখিলকৃত ওয়ারিশান সনদে দেখা যায়।') }}</textarea>
                    <label for="sa_heir_heir_details">এস এ রেকর্ডীয় মালিকের পুত্রের ওয়ারিশান সনদ পর্যালোচনা</label>
                    <textarea name="sa_heir_heir_details" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('sa_heir_heir_details', 'এস এ রেকর্ডীয় মালিক মজ প্রামানিক, পিং-স্বরিপ প্রামানিক, সাং-বাঘোপাড়া, বগুড়া সদর, বগুড়া এর পুত্র কাসেম আলী, পিং-মৃত মজ প্রামানিক, সাং-বাঘোপাড়া, বগুড়া সদর, বগুড়া মৃত্যুবরণ করলে ০৪ (চার) পুত্র (১) হাজী মোঃ কেরামত আলী, (২) মোঃ ইয়াছিন আলী, (৩) মোঃ মজিবর রহমান, (৪) মোঃ হবিবর রহমান ও ০১ (এক) কন্যা মোছাঃ রাহেলা খাতুন ওয়ারিশ মর্মে দাখিলকৃত ওয়ারিশান সনদে দেখা যায়।') }}</textarea>
                    <label for="sa_heir_transfer_details_1">এস এ রেকর্ডী মালিকের ওয়ারিশমূলে প্রাপ্ত মালিকের হস্তান্তর (১)</label>
                    <textarea name="sa_heir_transfer_details_1" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('sa_heir_transfer_details_1', 'এস এ রেকর্ডীয় মালিক মজ প্রামানিক, পিং-স্বরিপ প্রামানিক, সাং-বাঘোপাড়া, বগুড়া সদর, বগুড়া এর ওয়ারিশমূলে প্রাপ্ত মালিক নাতি হবিবর রহমান প্রামানিক, পিং-মৃত কাছেম আলী প্রামানিক, সাং-বাঘোপাড়া, বগুড়া সদর, বগুড়া গত ২৬/১২/১৯৭৮ তারিখের ২৩৪২৭ নং কোবলা দলিলমূলে এওয়ার্ডভুক্ত ৪১২৬ নং দাগে ০.১৪০০ একরের কাতে ০.০৩৫০ একর জমি মোছাম্মৎ আনোয়ারা খাতুন, জং-মজিবর রহমান প্রামানিক, সাং-বাগোপাড়া, বগুড়া সদর, বগুড়া বরাবর হস্তান্তর করেন।') }}</textarea>
                    <label for="sa_heir_transfer_details_2">এস এ রেকর্ডী মালিকের ওয়ারিশমূলে প্রাপ্ত মালিকের হস্তান্তর (২)</label>
                    <textarea name="sa_heir_transfer_details_2" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('sa_heir_transfer_details_2', 'এস এ রেকর্ডীয় মালিক মজ প্রামানিক, পিং-স্বরিপ প্রামানিক, সাং-বাঘোপাড়া, বগুড়া সদর, বগুড়া এর ওয়ারিশমূলে প্রাপ্ত মালিক নাতনী মোছাম্মৎ রাহেলা খাতুন, জং-হবিবর রহমান, সাং-ঠেঙ্গামারা, বগুড়া সদর, বগুড়া গত ২৬/১২/১৯৭৮ তারিখের ২৩৪২৭ নং কোবলা দলিলমূলে এওয়ার্ডভুক্ত ৪১২৬ নং দাগসহ অন্যান্য দাগে সর্বমোট ৩.২১০০ একরের কাতে ০.১২০০ একর জমি (১) মোঃ মজিবর রহমান প্রামানিক, (২) মোঃ হবিবর রহমান প্রামানিক, উভয়ের পিং-মৃত কাছেম আলী প্রামানিক, সাং-বাগোপাড়া, বগুড়া সদর, বগুড়া বরাবর হস্তান্তর করেন।') }}</textarea>
                    <label for="rs_khatian_details">চূড়ান্ত আর এস খতিয়ান প্রকাশ</label>
                    <textarea name="rs_khatian_details" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('rs_khatian_details', 'পরবর্তীতে সাবেক ৪১২৬ হাল ৫৪৫২ নং দাগে ০.০৭০০ একর জমি (১) মজিবর ররহমান প্রামানিক, পিং-কাছেম আলী প্রামানিক এর ০.৫০০ হিস্যা এবং (২) আনোয়ারা বিবি, জং-মজিবর রহমান, সাং-বাঘোপাড়া এর ০.৫০০ হিস্যায় ১৩০১ নং আর এস খতিয়ান চূড়ান্তভাবে প্রকাশিত হয়।') }}</textarea>
                    <label for="rs_owner_heir_details">আর এস রেকর্ডীয় মালিকদ্বয়ের ওয়ারিশান সনদ পর্যালোচনা</label>
                    <textarea name="rs_owner_heir_details" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('rs_owner_heir_details', 'আর এস রেকর্ডীয় মালিক (১) মজিবর ররহমান প্রামানিক, পিং-কাছেম আলী প্রামানিক এবং (২) আনোয়ারা বিবি, জং-মজিবর রহমান, সাং-বাঘোপাড়া, বগুড়া সদর, বগুড়াদ্বয় মৃত্যুবরণ করলে ০৪ (চার) পুত্র (১) মোঃ আনোয়ারুল ইসলাম, (২) মোঃ আমিরুল ইসলাম, (৩) মোঃ আতাউর রহমান, (৪) মোঃ মামুনুর রশিদ এবং ০১ (এক) কন্যা মোছাঃ তানজিনারা খাতুন ওয়ারিশ মর্মে দাখিলকৃত ওয়ারিশান সনদে দেখা যায়।') }}</textarea>
                    <label for="tax_review">ভূমি উন্নয়ন কর পর্যালোচনা</label>
                    <textarea name="tax_review" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('tax_review', 'আর এস রেকর্ডীয় মালিক (১) মজিবর ররহমান প্রামানিক, পিং-কাছেম আলী প্রামানিক এবং (২) আনোয়ারা বিবি, জং-মজিবর রহমান, সাং-বাঘোপাড়া, বগুড়া সদর, বগুড়াদ্বয়ের ওয়ারিশ হিসেবে নালিশী বগুড়া সদর উপজেলাধীন ২৫ নং আশোকোলা মৌজার আর এস ১৩০১ নং খতিয়ানের সাবেক ৪১২৬ হাল ৫৪৫২ নং দাগে ০.০৭০০একর জমির ১৩০৫ নং হিসাব সৃজন করে ২০২৫-২০২৬ অর্থ বছর পর্যন্ত ভূমি উন্নয়ন কর পরিশোধ করেন।') }}</textarea>
                    <label for="no_claim_review">না-দাবী পর্যালোচনা</label>
                    <textarea name="no_claim_review" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('no_claim_review', 'টাকা উত্তোলনের সুবিধার জন্য মজিবর রহমান প্রামানিক, পিং-কাছেম আলী প্রামানিক, সাং-বাঘোপাড়া, বগুড়া সদর, বগুড়া এর সকল ওয়ারিশগণ (১) মোঃ আনোয়ারুল ইসলাম, (২) মোঃ আমিরুল ইসলাম, (৩) মোঃ আতাউর রহমান এবং (৪) মোছাঃ তানজিনারা খাতুন, সর্ব পিং-মৃত মজিবর রহমান, সর্ব সাং-বাঘোপাড়া, বগুড়া সদর, বগুড়াগণ নোটারীকৃত ৩০০/- (তিনশত) টাকার নন-জুডিসিয়াল ষ্ট্যাম্পে আবেদনকারী মো: মামুনুর রশীদ, পিং-মোঃ মজিবর রহমান, সাং-বাঘোপাড়া দঃ পাড়া, উপজেলা-বগুড়া সদর, জেলা-বগুড়া বরাবর না-দাবী প্রদান করেন।') }}</textarea>
                    <label for="investigation_review">সরেজমিন তদন্ত প্রতিবেদন পর্যালোচনা</label>
                    <textarea name="investigation_review" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('investigation_review', 'গত ২৯/০২/২০২৪ তারিখের কানুনগো ও সার্ভেয়ার এর সরেজমিন তদন্ত প্রতিবেদন দৃষ্টে দেখা যায়, নালিশী সম্পত্তি আবেদনকারী একক ভাবে ভোগ দখল করেছেন এবং আবেদনকারীর দখলীয় সম্পত্তিতে গ্যাস লাইন বিদ্যমান মর্মে প্রতিবেদনে উল্লেখ করেছেন।') }}</textarea>
                    <label for="applicant_claim">আবেদনকারীর দাবী</label>
                    <textarea name="applicant_claim" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('applicant_claim', 'না-দাবী ও সরেজমিন তদন্ত প্রতিবেদন মোতাবেক আবেদনকারী মো: মামুনুর রশীদ, পিং-মোঃ মজিবর রহমান সাং-বাঘোপাড়া দঃ পাড়া, উপজেলা-বগুড়া সদর, জেলা-বগুড়া, বগুড়া সদর উপজেলাধীন ২৫ নং আশোকোলা মৌজার এস এ ৫৫৭ নং খতিয়ানের ৪১২৬ নং দাগের ০.০২৯০ একর ধানী জমির ও ফসলের ক্ষতিপূরণের টাকা প্রাপ্তির দাবীদার।') }}</textarea>
                    <label for="overall_review">সার্বিক পর্যালোচনা</label>
                    <textarea name="overall_review" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('overall_review', 'সরেজমিন তদন্ত প্রতিবেদন মোতাবেক নালিশী সম্পত্তি আবেদনকারীর দখলে থাকায়, রেকর্ডপত্রে ধারাবাহিকত সঠিক থাকায় এবং সর্বশেষ আর এস জরিপে আবেদনকারীর পিতা-মাতার নাম চূড়ান্তভাবে প্রকাশিত হওয়ায় ওনালিশী সম্পত্তি সিটি কর্পোরেশন, পৌরসভা ও ক্যান্টমেন্ট বোর্ডবহির্ভূত এলাকায় অবস্থিত হওয়ায় কর কমিশনারের কার্যালয়, কর অঞ্চল-বগুড়া এর ০৯/০৭/২০২৩ খ্রি. তারিখের পত্রের নির্দেশনা অনুযায়ী বর্তমান হার ৬% উৎসে কর বাদে অধিগ্রহণকৃত জমির ও ফসলের ক্ষতিপূরণ পাওয়ার হকদার।') }}</textarea>
                    <label for="final_order_summary">অতএব, আদেশ হয় যে,</label>
                    <textarea name="final_order_summary" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('final_order_summary', 'সরেজমিন তদন্ত প্রতিবেদন মোতাবেক নালিশী সম্পত্তি আবেদনকারীর দখলে থাকায়, রেকর্ডপত্রের ধারাবাহিকত সঠিক থাকায় এবং সর্বশেষ আর এস জরিপে আবেদনকারীর পিতা-মাতার নাম চূড়ান্তভাবে প্রকাশিত হওয়ায় ও আবেদনকারী হালসন পর্যন্ত ভূমি উন্নয়ন পরিশোধ করায়বগুড়া সদর উপজেলাধীন ২৫ নং আশোকোলা মৌজার এসএ ৫৫৭ নং খতিয়ানের ৪১২৬ নং দাগের ০.০২৯০ একর ধানী জমির ও ফসলের ক্ষতিপূরণের জন্য প্রস্তুতকৃত ২১ এবং ২১ নং রোয়েদাদ সরেজমিন তদন্ত প্রতিবেদন মোতাবেক সংশোধনপূর্বক আবেদনকারীগণ বরাবর পেমেন্ট আদেশ প্রদান করা হলো।') }}</textarea>
                    <label for="final_payment_order">পেমেন্ট আদেশ</label>
                    <textarea name="final_payment_order" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('final_payment_order', '০১ নং আবেদনকারী মো: মামুনুর রশীদ, পিং-মোঃ মজিবর রহমান সাং-বাঘোপাড়া দঃ পাড়া, উপজেলা-বগুড়া সদর, জেলা-বগুড়া এরবগুড়া সদর উপজেলাধীন ২৫ নং আশোকোলা মৌজার এসএ ৫৫৭ নং খতিয়ানের ৪১২৬ নং দাগের ০.০২৯০ একর ধানী জমির ও ফসলের ক্ষতিপূরণ।') }}</textarea>
                </fieldset>
                <fieldset class="border p-4 rounded">
                    <legend class="font-bold px-2">ক্ষতিপূরণ ও স্বাক্ষর</legend>
                    <label for="compensation_details">ক্ষতিপূরণ টেবিল (JSON ফরম্যাট)</label>
                    <textarea name="compensation_details" rows="6" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm font-mono text-sm">{{ old('compensation_details', '[{"roedad_no":"২১","dag_no":"৪১২৬","description":"ধানী ০.০২৯০ একর জমির মোট প্রদেয় টাকা","total_compensation":"208238.74","tax_deduction":"6247.16","net_compensation":"201991.58"},{"roedad_no":"২১","dag_no":"৪১২৬","description":"ধানী ০.০২৯০ একর জমির ফসলের মোট প্রদেয় টাকা","total_compensation":"4719.75","tax_deduction":"141.59","net_compensation":"4578.16"}]') }}</textarea>
                    <label for="total_compensation_words">মোট টাকা (কথায়)</label>
                    <input type="text" name="total_compensation_words" id="total_compensation_words" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('total_compensation_words', 'দুই লক্ষ তেরো হাজার নয়শত ছাপ্পান্ন টাকা ঊনপঞ্চাশ পয়সা মাত্র') }}">
                    <label for="lao_name">ভূমি অধিগ্রহণ কর্মকর্তার নাম</label>
                    <input type="text" name="lao_name" id="lao_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('lao_name', 'নাহিয়ান মুনসীফ') }}">
                    <label for="adc_name">অতিরিক্ত জেলা প্রশাসক (রাজস্ব) এর নাম</label>
                    <input type="text" name="adc_name" id="adc_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('adc_name', 'পি. এম. ইমরুল কায়েস') }}">
                </fieldset>
            </div>
            <div class="mt-8 flex justify-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Submit
                </button>
            </div>
        </form>
    </div>
@endsection
