@extends('layouts.app')

@section('title', 'ক্ষতিপূরণ তথ্য ফরম')

@section('styles')
<style>
    label { font-weight: bold; }
    .form-section { border: 1px solid #e2e8f0; border-radius: 0.5rem; padding: 1.5rem; margin-bottom: 1.5rem; }
    .form-section-title { font-size: 1.25rem; font-weight: bold; margin-bottom: 1rem; border-bottom: 1px solid #e2e8f0; padding-bottom: 0.5rem; }
</style>
@endsection

@section('scripts')
<script defer>
    document.addEventListener('alpine:init', () => {
        window.compensationForm = () => ({
            applicants: [{ name: '', father_name: '', address: '', nid: '' }],
            is_sa_owner: '1',
            addApplicant() {
                this.applicants.push({ name: '', father_name: '', address: '', nid: '' });
            },
            removeApplicant(index) {
                this.applicants.splice(index, 1);
            }
        });
    });
</script>
@endsection

@section('content')
<div class="container mx-auto p-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">ক্ষতিপূরণ তথ্য ফরম</h1>
        <a href="{{ route('compensation.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
            &larr; তালিকা দেখুন
        </a>
    </div>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <p><strong>অনুগ্রহ করে নিচের ত্রুটিগুলো সংশোধন করুন:</strong></p>
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('compensation.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow-md" x-data="compensationForm">
        @csrf
        <!-- Section 1: Applicant Information -->
        <div class="form-section">
            <h2 class="form-section-title">১। আবেদনকারীর তথ্যঃ</h2>
            <template x-for="(applicant, index) in applicants" :key="index">
                <div class="border p-4 rounded mb-4 relative">
                    <h3 class="font-bold mb-2" x-text="'আবেদনকারী #' + (index + 1)"></h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label :for="'name_' + index">নাম</label>
                            <input type="text" :name="'applicants[' + index + '][name]'" x-model="applicant.name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                        <div>
                            <label :for="'father_name_' + index">পিতার নাম</label>
                            <input type="text" :name="'applicants[' + index + '][father_name]'" x-model="applicant.father_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                        <div class="md:col-span-2">
                            <label :for="'address_' + index">ঠিকানা</label>
                            <input type="text" :name="'applicants[' + index + '][address]'" x-model="applicant.address" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                        <div>
                            <label :for="'nid_' + index">এন আই ডি</label>
                            <input type="text" :name="'applicants[' + index + '][nid]'" x-model="applicant.nid" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                    </div>
                    <button
                        type="button"
                        @click="removeApplicant(index)"
                        x-show="applicants.length > 1 && index !== 0"
                        class="absolute top-2 right-2 bg-red-500 text-white rounded-full h-6 w-6 flex items-center justify-center"
                        title="আবেদনকারী মুছুন"
                    >&times;</button>
                </div>
            </template>
            <div class="flex items-center space-x-2">
                <button type="button" @click="addApplicant()" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                    + আবেদনকারী যোগ করুন
                </button>
                <span class="text-gray-500 text-sm">কমপক্ষে একজন আবেদনকারীর তথ্য প্রয়োজন</span>
            </div>
        </div>

        <!-- Section 2: Award Information -->
        <div class="form-section">
            <h2 class="form-section-title">২। রোয়েদাদের তথ্যঃ</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="la_case_no">এলএ কেস নং</label>
                    <input type="text" name="la_case_no" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label>রোয়েদাদের ধরন</label>
                    <div class="mt-2 flex space-x-4">
                        <label><input type="checkbox" name="award_type[]" value="জমি/অবকাঠামো" class="mr-2">জমি/অবকাঠামো</label>
                        <label><input type="checkbox" name="award_type[]" value="জমি/গাছপালা" class="mr-2">জমি/গাছপালা</label>
                    </div>
                </div>
                <div>
                    <label for="award_serial_no">রোয়েদাদের ক্রমিক নং</label>
                    <input type="text" name="award_serial_no" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label for="acquisition_record_basis">যে রেকর্ড মূলে অধিগ্রহণ</label>
                    <input type="text" name="acquisition_record_basis" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label for="plot_no">দাগ নং</label>
                    <input type="text" name="plot_no" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label for="award_holder_name">রোয়েদাদভুক্ত মালিকের নাম</label>
                    <input type="text" name="award_holder_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div class="md:col-span-2">
                    <label for="objector_details">রোয়েদাদে কোন আপত্তি অন্তর্ভুক্ত থাকলে আপত্তিকারীর নাম ও ঠিকানা</label>
                    <textarea name="objector_details" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                </div>
                <div>
                    <label>আবেদনকারীর নাম রোয়েদাদে আছে কিনা?</label>
                    <div class="mt-2 flex space-x-4">
                        <label><input type="radio" name="is_applicant_in_award" value="1" class="mr-2">হ্যাঁ</label>
                        <label><input type="radio" name="is_applicant_in_award" value="0" class="mr-2">না</label>
                    </div>
                </div>
                <div>
                    <label for="total_acquired_land">অধিগ্রহণকৃত মোট জমির পরিমাণ</label>
                    <input type="text" name="total_acquired_land" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label for="total_compensation">অধিগ্রহণকৃত জমির মোট ক্ষতিপূরণ (উৎস কর সহ)</label>
                    <input type="text" name="total_compensation" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label for="applicant_acquired_land">আবেদনকারীর অধিগ্রহণকৃত জমির পরিমাণ</label>
                    <input type="text" name="applicant_acquired_land" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
            </div>
        </div>

        <!-- Section 3: Land Schedule -->
        <div class="form-section">
            <h2 class="form-section-title">৩। আবেদনকৃত জমির তফসিলঃ</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div><label for="mouza_name">মৌজার নাম</label><input type="text" name="mouza_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></div>
                <div><label for="jl_no">জেএল নং</label><input type="text" name="jl_no" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></div>
                <div><label for="sa_khatian_no">এসএ খতিয়ান নং</label><input type="text" name="sa_khatian_no" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></div>
                <div><label for="former_plot_no">সাবেক দাগ নং</label><input type="text" name="former_plot_no" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></div>
                <div><label for="rs_khatian_no">আর এস খতিয়ান নং</label><input type="text" name="rs_khatian_no" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></div>
                <div><label for="current_plot_no">হাল দাগ নং</label><input type="text" name="current_plot_no" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></div>
            </div>
        </div>

        <!-- Section 4: Ownership Continuity -->
        <div class="form-section">
            <h2 class="form-section-title">৪। মালিকানার ধারাবাহিকতার বর্ণনাঃ</h2>
            <div>
                <label>আবেদনকারি নিজে SA মালিক কিনা?</label>
                <div class="mt-2 flex space-x-4">
                    <label><input type="radio" name="is_applicant_sa_owner" value="1" x-model="is_sa_owner" class="mr-2">হ্যাঁ</label>
                    <label><input type="radio" name="is_applicant_sa_owner" value="0" x-model="is_sa_owner" class="mr-2">না</label>
                </div>
            </div>
            <div x-show="is_sa_owner === '0'" class="mt-4">
                <label for="sa_owner_name">SA মালিকের নাম</label>
                <input type="text" name="sa_owner_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>
        </div>

        <div class="mt-8 flex justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                জমা দিন
            </button>
        </div>
    </form>
</div>
@endsection