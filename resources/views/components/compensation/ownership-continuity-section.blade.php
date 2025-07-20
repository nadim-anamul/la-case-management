<div class="form-section">
    <h2 class="form-section-title">
        <span class="section-icon">৪</span>
        মালিকানার ধারাবাহিকতার বর্ণনাঃ
    </h2>
    <div>
        <label>১। আবেদনকারি নিজে SA মালিক?</label>
        <div class="radio-group">
            <label><input type="radio" name="ownership_details[is_applicant_sa_owner]" value="yes" x-model="is_sa_owner" {{ (old('ownership_details.is_applicant_sa_owner', isset($compensation) ? ($compensation->is_applicant_sa_owner ? 'yes' : 'no') : 'yes')) == 'yes' ? 'checked' : '' }} class="mr-2"><span>হ্যাঁ</span></label>
            <label><input type="radio" name="ownership_details[is_applicant_sa_owner]" value="no" x-model="is_sa_owner" {{ (old('ownership_details.is_applicant_sa_owner', isset($compensation) ? ($compensation->is_applicant_sa_owner ? 'yes' : 'no') : 'yes')) == 'no' ? 'checked' : '' }} class="mr-2"><span>না</span></label>
        </div>
    </div>

    <div x-show="is_sa_owner === 'no'" class="mt-6 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="floating-label">
                <input type="text" name="ownership_details[sa_owner_name]" value="{{ old('ownership_details.sa_owner_name', isset($compensation) ? $compensation->ownership_details['sa_owner_name'] ?? '' : '') }}" placeholder=" ">
                <label>SA মালিকের নাম</label>
            </div>
            <div class="floating-label">
                <input type="text" name="ownership_details[sa_plot_no]" value="{{ old('ownership_details.sa_plot_no', isset($compensation) ? $compensation->ownership_details['sa_plot_no'] ?? '' : '') }}" placeholder=" ">
                <label>দাগ নম্বর</label>
            </div>
            <div class="floating-label">
                <input type="text" name="ownership_details[previous_owner_name]" value="{{ old('ownership_details.previous_owner_name', isset($compensation) ? $compensation->ownership_details['previous_owner_name'] ?? '' : '') }}" placeholder=" ">
                <label>যে মালিকের থেকে আগত তার নাম</label>
            </div>
            <div class="floating-label">
                <input type="text" name="ownership_details[sa_khatian_no]" value="{{ old('ownership_details.sa_khatian_no', isset($compensation) ? $compensation->ownership_details['sa_khatian_no'] ?? '' : '') }}" placeholder=" ">
                <label>খতিয়ান নম্বর</label>
            </div>
            <div class="floating-label">
                <input type="text" name="ownership_details[sa_total_land_in_plot]" value="{{ old('ownership_details.sa_total_land_in_plot', isset($compensation) ? $compensation->ownership_details['sa_total_land_in_plot'] ?? '' : '') }}" placeholder=" ">
                <label>দাগে মোট জমি</label>
            </div>
            <div class="floating-label">
                <input type="text" name="ownership_details[sa_land_in_khatian]" value="{{ old('ownership_details.sa_land_in_khatian', isset($compensation) ? $compensation->ownership_details['sa_land_in_khatian'] ?? '' : '') }}" placeholder=" ">
                <label>উক্ত খতিয়ানে জমির পরিমাণ</label>
            </div>
        </div>

        <div>
            <label>আবেদনকারি কি দলিল মূলে মালিক অথবা ওয়ারিশ মূলে মালিক?</label>
            <div class="radio-group">
                <label><input type="radio" name="ownership_details[ownership_type]" value="deed" x-model="ownership_type" {{ (old('ownership_details.ownership_type', isset($compensation) ? $compensation->ownership_details['ownership_type'] ?? '' : '')) == 'deed' ? 'checked' : '' }} class="mr-2"><span>দলিল মূলে</span></label>
                <label><input type="radio" name="ownership_details[ownership_type]" value="inheritance" x-model="ownership_type" {{ (old('ownership_details.ownership_type', isset($compensation) ? $compensation->ownership_details['ownership_type'] ?? '' : '')) == 'inheritance' ? 'checked' : '' }} class="mr-2"><span>ওয়ারিশ মূলে</span></label>
            </div>
        </div>

        <!-- Deed Details -->
        <div x-show="ownership_type === 'deed'" class="sub-section">
            <h3 class="font-bold mb-4">দলিল মূলে হস্তান্তর তথ্য:</h3>
            <template x-for="(deed, index) in deed_transfers" :key="index">
                <div class="record-card">
                    <h4 x-text="'দলিল #' + (index + 1)"></h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="floating-label">
                            <input type="text" :name="'ownership_details[deed_transfers][' + index + '][donor_name]'" x-model="deed.donor_name" placeholder=" ">
                            <label>দলিল দাতার নাম</label>
                        </div>
                        <div class="floating-label">
                            <input type="text" :name="'ownership_details[deed_transfers][' + index + '][recipient_name]'" x-model="deed.recipient_name" placeholder=" ">
                            <label>দলিল গ্রহীতার নাম</label>
                        </div>
                        <div class="floating-label">
                            <input type="text" :name="'ownership_details[deed_transfers][' + index + '][deed_number]'" x-model="deed.deed_number" placeholder=" ">
                            <label>দলিল নম্বর</label>
                        </div>
                        <div class="floating-label">
                            <input type="date" :name="'ownership_details[deed_transfers][' + index + '][deed_date]'" x-model="deed.deed_date" placeholder=" ">
                            <label>দলিলের তারিখ</label>
                        </div>
                        <div class="floating-label">
                            <input type="text" :name="'ownership_details[deed_transfers][' + index + '][sale_type]'" placeholder="সুনির্দিষ্ট দাগে অথবা সম্মিলিত দাগের হতে" x-model="deed.sale_type">
                            <label>বিক্রয়ের ধরন</label>
                        </div>
                        <div class="floating-label">
                            <input type="text" :name="'ownership_details[deed_transfers][' + index + '][plot_no]'" x-model="deed.plot_no" placeholder=" ">
                            <label>দাগ নম্বর</label>
                        </div>
                        <div class="floating-label">
                            <input type="text" :name="'ownership_details[deed_transfers][' + index + '][sold_land_amount]'" x-model="deed.sold_land_amount" placeholder=" ">
                            <label>বিক্রিত জমির পরিমাণ</label>
                        </div>
                        <div class="floating-label">
                            <input type="text" :name="'ownership_details[deed_transfers][' + index + '][total_sotangsho]'" x-model="deed.total_sotangsho" placeholder=" ">
                            <label>মোট কত শতাংশ</label>
                        </div>
                        <div class="floating-label">
                            <input type="text" :name="'ownership_details[deed_transfers][' + index + '][total_shotok]'" x-model="deed.total_shotok" placeholder=" ">
                            <label>মোট কত শতক</label>
                        </div>
                        <div class="floating-label">
                            <select :name="'ownership_details[deed_transfers][' + index + '][possession_mentioned]'" x-model="deed.possession_mentioned">
                                <option value="yes">হ্যাঁ</option>
                                <option value="no">না</option>
                            </select>
                            <label>দখল উল্লেখ করা আছে কিনা?</label>
                        </div>
                        <div class="floating-label">
                            <input type="text" :name="'ownership_details[deed_transfers][' + index + '][possession_plot_no]'" x-model="deed.possession_plot_no" placeholder=" ">
                            <label>দখলের দাগ নম্বর</label>
                        </div>
                        <div class="floating-label md:col-span-2">
                            <textarea :name="'ownership_details[deed_transfers][' + index + '][possession_description]'" rows="3" x-model="deed.possession_description" placeholder=" "></textarea>
                            <label>দখল এর বর্ণনা</label>
                        </div>
                    </div>
                    <div class="sub-section mt-6">
                        <h4 class="font-bold mb-4">ক্রেতার খারিজের তথ্য:</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="floating-label">
                                <input type="text" :name="'ownership_details[deed_transfers][' + index + '][mutation_case_no]'" x-model="deed.mutation_case_no" placeholder=" ">
                                <label>খারিজ কেস নম্বর</label>
                            </div>
                            <div class="floating-label">
                                <input type="text" :name="'ownership_details[deed_transfers][' + index + '][mutation_plot_no]'" x-model="deed.mutation_plot_no" placeholder=" ">
                                <label>দাগ নম্বর</label>
                            </div>
                            <div class="floating-label">
                                <input type="text" :name="'ownership_details[deed_transfers][' + index + '][mutation_land_amount]'" x-model="deed.mutation_land_amount" placeholder=" ">
                                <label>খারিজকৃত জমির পরিমাণ</label>
                            </div>
                        </div>
                    </div>
                    <button
                        type="button"
                        @click="removeDeedTransfer(index)"
                        x-show="deed_transfers.length > 1"
                        class="btn-danger absolute top-4 right-4"
                        title="দলিল মুছুন"
                    >×</button>
                </div>
            </template>
            <button type="button" @click="addDeedTransfer()" class="btn-success">
                + দলিল যোগ করুন
            </button>
        </div>

        <!-- Inheritance Details -->
        <div x-show="ownership_type === 'inheritance'" class="sub-section">
            <h3 class="font-bold mb-4">ওয়ারিশ মূলে হস্তান্তর তথ্য:</h3>
            <template x-for="(inheritance, index) in inheritance_records" :key="index">
                <div class="record-card">
                    <h4 x-text="'ওয়ারিশ #' + (index + 1)"></h4>
                    <div class="space-y-6">
                        <div>
                            <label>ওয়ারিশমুলে প্রাপ্ত বেক্তি কি আবেদনকারী নিজে?</label>
                            <div class="radio-group">
                                <label><input type="radio" :name="'ownership_details[inheritance_records][' + index + '][is_heir_applicant]'" value="yes" x-model="inheritance.is_heir_applicant" class="mr-2"><span>হ্যাঁ</span></label>
                                <label><input type="radio" :name="'ownership_details[inheritance_records][' + index + '][is_heir_applicant]'" value="no" x-model="inheritance.is_heir_applicant" class="mr-2"><span>না</span></label>
                            </div>
                        </div>
                        
                        <div x-show="inheritance.is_heir_applicant === 'no'" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="floating-label">
                                <input type="text" :name="'ownership_details[inheritance_records][' + index + '][previous_owner_name]'" x-model="inheritance.previous_owner_name" placeholder=" ">
                                <label>যে মালিকের থেকে আগত তার নাম</label>
                            </div>
                            <div class="floating-label">
                                <input type="date" :name="'ownership_details[inheritance_records][' + index + '][death_date]'" x-model="inheritance.death_date" placeholder=" ">
                                <label>পূর্বতন মালিকের মৃত্যুর তারিখ</label>
                            </div>
                            <div class="floating-label">
                                <input type="text" :name="'ownership_details[inheritance_records][' + index + '][inheritance_type]'" x-model="inheritance.inheritance_type" placeholder="সরাসরি বা অন্যান্য">
                                <label>হস্তান্তরের ধরন</label>
                            </div>
                            <div class="floating-label">
                                <select :name="'ownership_details[inheritance_records][' + index + '][has_death_cert]'" x-model="inheritance.has_death_cert">
                                    <option value="yes">হ্যাঁ</option>
                                    <option value="no">না</option>
                                </select>
                                <label>পূর্বতন মালিকের মৃত্যুসনদ দাখিল করা হয়েছে কিনা?</label>
                            </div>
                            <div class="floating-label md:col-span-2">
                                <textarea :name="'ownership_details[inheritance_records][' + index + '][heirship_certificate_info]'" rows="3" x-model="inheritance.heirship_certificate_info" placeholder=" "></textarea>
                                <label>ওয়ারিশান সনদের তথ্য</label>
                            </div>
                        </div>
                        
                        <div x-show="inheritance.is_heir_applicant === 'no'" class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                            <p class="text-blue-800 font-medium mb-2">পরবর্তী ওয়ারিশ যোগ করুন:</p>
                            <p class="text-blue-600 text-sm">যেহেতু এই ওয়ারিশমুলে প্রাপ্ত ব্যক্তি আবেদনকারী নন, তাই পরবর্তী ওয়ারিশের তথ্য যোগ করুন।</p>
                        </div>
                    </div>
                    <button
                        type="button"
                        @click="removeInheritanceRecord(index)"
                        x-show="inheritance_records.length > 1"
                        class="btn-danger absolute top-4 right-4"
                        title="ওয়ারিশ মুছুন"
                    >×</button>
                </div>
            </template>
            <button type="button" @click="addInheritanceRecord()" class="btn-success">
                + ওয়ারিশ যোগ করুন
            </button>
            
            <div x-show="inheritance_records.length > 0 && inheritance_records[inheritance_records.length - 1].is_heir_applicant === 'yes'" class="mt-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                <p class="text-green-800 font-medium">✓ ওয়ারিশ প্রক্রিয়া সম্পন্ন</p>
                <p class="text-green-600 text-sm">সর্বশেষ ওয়ারিশমুলে প্রাপ্ত ব্যক্তি আবেদনকারী নিজে, তাই আরও ওয়ারিশ যোগ করার প্রয়োজন নেই।</p>
            </div>
        </div>
    </div>
</div> 