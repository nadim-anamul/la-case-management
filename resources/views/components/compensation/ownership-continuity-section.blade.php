<div class="form-section">
    <h2 class="form-section-title">
        <span class="section-icon">৪</span>
        মালিকানার ধারাবাহিকতার বর্ণনাঃ
    </h2>
    <template x-if="acquisition_record_basis === 'SA'">
        <div>
            <label>১। আবেদনকারি নিজে SA মালিক?</label>
            <div class="radio-group">
                <label><input type="radio" name="ownership_details[is_applicant_sa_owner]" value="yes" x-model="is_sa_owner" class="mr-2"><span>হ্যাঁ</span></label>
                <label><input type="radio" name="ownership_details[is_applicant_sa_owner]" value="no" x-model="is_sa_owner" class="mr-2"><span>না</span></label>
            </div>
            <div x-show="is_sa_owner === 'no'" class="mt-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <template x-for="(owner, index) in sa_owners" :key="index">
                            <div class="flex items-center mb-2">
                                <input type="text" :id="'sa_owner_name_' + index" :name="'ownership_details[sa_owners][' + index + '][name]'" x-model="owner.name" class="form-input flex-1" placeholder="SA মালিকের নাম">
                                <label :for="'sa_owner_name_' + index" class="ml-2">SA মালিকের নাম</label>
                                <button type="button" @click="removeSaOwner(index)" x-show="sa_owners.length > 1" class="btn-danger ml-2" title="মালিক মুছুন">×</button>
                            </div>
                        </template>
                        <button type="button" @click="addSaOwner()" class="btn-success mt-2">+ SA মালিক যোগ করুন</button>
                        <small class="text-gray-500">একাধিক মালিক থাকলে যোগ করুন।</small>
                    </div>
                    <div class="floating-label">
                        <input type="text" id="old_sa_plot_no" name="ownership_details[sa_plot_no]" value="{{ old('ownership_details.sa_plot_no', isset($compensation) ? $compensation->ownership_details['sa_plot_no'] ?? '' : '') }}" placeholder=" ">
                        <label for="old_sa_plot_no">SA দাগ নম্বর</label>
                        <small class="text-gray-500">যে দাগ নম্বরের মালিকানা যাচাই হচ্ছে</small>
                    </div>
                    <div class="floating-label">
                        <input type="text" id="previous_owner_name" name="ownership_details[previous_owner_name]" value="{{ old('ownership_details.previous_owner_name', isset($compensation) ? $compensation->ownership_details['previous_owner_name'] ?? '' : '') }}" placeholder=" ">
                        <label for="previous_owner_name">যে মালিকের থেকে আগত তার নাম</label>
                    </div>
                    <div class="floating-label">
                        <input type="text" id="old_sa_khatian_no" name="ownership_details[sa_khatian_no]" value="{{ old('ownership_details.sa_khatian_no', isset($compensation) ? $compensation->ownership_details['sa_khatian_no'] ?? '' : '') }}" placeholder=" ">
                        <label for="old_sa_khatian_no">SA খতিয়ান নম্বর</label>
                    </div>
                    <div class="floating-label">
                        <input type="text" id="old_sa_total_land_in_plot" name="ownership_details[sa_total_land_in_plot]" value="{{ old('ownership_details.sa_total_land_in_plot', isset($compensation) ? $compensation->ownership_details['sa_total_land_in_plot'] ?? '' : '') }}" placeholder=" ">
                        <label for="old_sa_total_land_in_plot">SA দাগে মোট জমি</label>
                    </div>
                    <div class="floating-label">
                        <input type="text" id="old_sa_land_in_khatian" name="ownership_details[sa_land_in_khatian]" value="{{ old('ownership_details.sa_land_in_khatian', isset($compensation) ? $compensation->ownership_details['sa_land_in_khatian'] ?? '' : '') }}" placeholder=" ">
                        <label for="old_sa_land_in_khatian">SA উক্ত খতিয়ানে জমির পরিমাণ</label>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <div>
                        <template x-for="(owner, index) in rs_owners" :key="index">
                            <div class="flex items-center mb-2">
                                <input type="text" :id="'rs_owner_name_' + index" :name="'ownership_details[rs_owners][' + index + '][name]'" x-model="owner.name" class="form-input flex-1" placeholder="RS মালিকের নাম">
                                <label :for="'rs_owner_name_' + index" class="ml-2">RS মালিকের নাম</label>
                                <button type="button" @click="removeRsOwner(index)" x-show="rs_owners.length > 1" class="btn-danger ml-2" title="মালিক মুছুন">×</button>
                            </div>
                        </template>
                        <button type="button" @click="addRsOwner()" class="btn-success mt-2">+ RS মালিক যোগ করুন</button>
                        <small class="text-gray-500">একাধিক মালিক থাকলে যোগ করুন।</small>
                    </div>
                    <div>
                        <div class="floating-label">
                            <input type="text" id="old_rs_plot_no" name="ownership_details[rs_plot_no]" value="{{ old('ownership_details.rs_plot_no', isset($compensation) ? $compensation->ownership_details['rs_plot_no'] ?? '' : '') }}" placeholder=" ">
                            <label for="old_rs_plot_no">RS দাগ নম্বর</label>
                        </div>
                        <div class="floating-label">
                            <input type="text" id="rs_previous_owner_name" name="ownership_details[rs_previous_owner_name]" value="{{ old('ownership_details.rs_previous_owner_name', isset($compensation) ? $compensation->ownership_details['rs_previous_owner_name'] ?? '' : '') }}" placeholder=" ">
                            <label for="rs_previous_owner_name">RS যে মালিকের থেকে আগত তার নাম</label>
                        </div>
                        <div class="floating-label">
                            <input type="text" id="old_rs_khatian_no" name="ownership_details[rs_khatian_no]" value="{{ old('ownership_details.rs_khatian_no', isset($compensation) ? $compensation->ownership_details['rs_khatian_no'] ?? '' : '') }}" placeholder=" ">
                            <label for="old_rs_khatian_no">RS খতিয়ান নম্বর</label>
                        </div>
                        <div class="floating-label">
                            <input type="text" id="old_rs_total_land_in_plot" name="ownership_details[rs_total_land_in_plot]" value="{{ old('ownership_details.rs_total_land_in_plot', isset($compensation) ? $compensation->ownership_details['rs_total_land_in_plot'] ?? '' : '') }}" placeholder=" ">
                            <label for="old_rs_total_land_in_plot">RS দাগে মোট জমি</label>
                        </div>
                        <div class="floating-label">
                            <input type="text" id="old_rs_land_in_khatian" name="ownership_details[rs_land_in_khatian]" value="{{ old('ownership_details.rs_land_in_khatian', isset($compensation) ? $compensation->ownership_details['rs_land_in_khatian'] ?? '' : '') }}" placeholder=" ">
                            <label for="old_rs_land_in_khatian">RS খতিয়ানে মোট জমির পরিমাণ</label>
                        </div>
                    </div>
                </div>
                <!-- Show deed/inheritance only if not owner -->
                <div class="mt-6">
                    <label>আবেদনকারি কি দলিল মূলে মালিক অথবা ওয়ারিশ মূলে মালিক?</label>
                    <div class="radio-group">
                        <label><input type="radio" name="ownership_details[ownership_type]" value="deed" x-model="ownership_type" class="mr-2"><span>দলিল মূলে</span></label>
                        <label><input type="radio" name="ownership_details[ownership_type]" value="inheritance" x-model="ownership_type" class="mr-2"><span>ওয়ারিশ মূলে</span></label>
                    </div>
                </div>
                <div x-show="ownership_type === 'deed'" class="sub-section">
                    <h3 class="font-bold mb-4">দলিল মূলে হস্তান্তর তথ্য:</h3>
                    <template x-for="(deed, index) in deed_transfers" :key="index">
                        <div class="record-card">
                            <h4 x-text="'দলিল #' + (index + 1)"></h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="floating-label">
                                    <input type="text" :id="'deed_donor_name_' + index" :name="'ownership_details[deed_transfers][' + index + '][donor_name]'" x-model="deed.donor_name" placeholder=" ">
                                    <label :for="'deed_donor_name_' + index">দলিল দাতার নাম<span x-show="ownership_type === 'deed'" class="text-red-500">*</span></label>
                                    @error('ownership_details.deed_transfers.*.donor_name')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="floating-label">
                                    <input type="text" :id="'deed_recipient_name_' + index" :name="'ownership_details[deed_transfers][' + index + '][recipient_name]'" x-model="deed.recipient_name" placeholder=" ">
                                    <label :for="'deed_recipient_name_' + index">দলিল গ্রহীতার নাম<span x-show="ownership_type === 'deed'" class="text-red-500">*</span></label>
                                    @error('ownership_details.deed_transfers.*.recipient_name')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="floating-label">
                                    <input type="text" :id="'deed_number_' + index" :name="'ownership_details[deed_transfers][' + index + '][deed_number]'" x-model="deed.deed_number" placeholder=" ">
                                    <label :for="'deed_number_' + index">দলিল নম্বর<span x-show="ownership_type === 'deed'" class="text-red-500">*</span></label>
                                    @error('ownership_details.deed_transfers.*.deed_number')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="floating-label">
                                    <input type="date" :id="'deed_date_' + index" :name="'ownership_details[deed_transfers][' + index + '][deed_date]'" x-model="deed.deed_date" placeholder=" ">
                                    <label :for="'deed_date_' + index">দলিলের তারিখ<span x-show="ownership_type === 'deed'" class="text-red-500">*</span></label>
                                    @error('ownership_details.deed_transfers.*.deed_date')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
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
                                        <input type="text" :id="'inheritance_previous_owner_name_' + index" :name="'ownership_details[inheritance_records][' + index + '][previous_owner_name]'" x-model="inheritance.previous_owner_name" placeholder=" ">
                                        <label :for="'inheritance_previous_owner_name_' + index">যে মালিকের থেকে আগত তার নাম<span x-show="ownership_type === 'inheritance'" class="text-red-500">*</span></label>
                                        @error('ownership_details.inheritance_records.*.previous_owner_name')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="floating-label">
                                        <input type="date" :id="'inheritance_death_date_' + index" :name="'ownership_details[inheritance_records][' + index + '][death_date]'" x-model="inheritance.death_date" placeholder=" ">
                                        <label :for="'inheritance_death_date_' + index">পূর্বতন মালিকের মৃত্যুর তারিখ<span x-show="ownership_type === 'inheritance'" class="text-red-500">*</span></label>
                                        @error('ownership_details.inheritance_records.*.death_date')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
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
    </template>
    <template x-if="acquisition_record_basis === 'RS'">
        <div>
            <label>১। আবেদনকারি নিজে RS মালিক?</label>
            <div class="radio-group">
                <label><input type="radio" name="ownership_details[is_applicant_rs_owner]" value="yes" x-model="is_rs_owner" class="mr-2"><span>হ্যাঁ</span></label>
                <label><input type="radio" name="ownership_details[is_applicant_rs_owner]" value="no" x-model="is_rs_owner" class="mr-2"><span>না</span></label>
            </div>
            <div x-show="is_rs_owner === 'no'" class="mt-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <template x-for="(owner, index) in rs_owners" :key="index">
                            <div class="flex items-center mb-2">
                                <input type="text" :id="'rs_owner_name_' + index" :name="'ownership_details[rs_owners][' + index + '][name]'" x-model="owner.name" class="form-input flex-1" placeholder="RS মালিকের নাম">
                                <label :for="'rs_owner_name_' + index" class="ml-2">RS মালিকের নাম</label>
                                <button type="button" @click="removeRsOwner(index)" x-show="rs_owners.length > 1" class="btn-danger ml-2" title="মালিক মুছুন">×</button>
                            </div>
                        </template>
                        <button type="button" @click="addRsOwner()" class="btn-success mt-2">+ RS মালিক যোগ করুন</button>
                        <small class="text-gray-500">একাধিক মালিক থাকলে যোগ করুন।</small>
                    </div>
                    <div class="floating-label">
                        <input type="text" id="old_rs_plot_no_2" name="ownership_details[rs_plot_no]" value="{{ old('ownership_details.rs_plot_no', isset($compensation) ? $compensation->ownership_details['rs_plot_no'] ?? '' : '') }}" placeholder=" ">
                        <label for="old_rs_plot_no_2">RS দাগ নম্বর</label>
                    </div>
                    <div class="floating-label">
                        <input type="text" id="rs_previous_owner_name" name="ownership_details[rs_previous_owner_name]" value="{{ old('ownership_details.rs_previous_owner_name', isset($compensation) ? $compensation->ownership_details['rs_previous_owner_name'] ?? '' : '') }}" placeholder=" ">
                        <label for="rs_previous_owner_name">RS যে মালিকের থেকে আগত তার নাম</label>
                    </div>
                    <div class="floating-label">
                        <input type="text" id="old_rs_khatian_no_2" name="ownership_details[rs_khatian_no]" value="{{ old('ownership_details.rs_khatian_no', isset($compensation) ? $compensation->ownership_details['rs_khatian_no'] ?? '' : '') }}" placeholder=" ">
                        <label for="old_rs_khatian_no_2">RS খতিয়ান নম্বর</label>
                    </div>
                    <div class="floating-label">
                        <input type="text" id="rs_total_land_in_plot" name="ownership_details[rs_total_land_in_plot]" value="{{ old('ownership_details.rs_total_land_in_plot', isset($compensation) ? $compensation->ownership_details['rs_total_land_in_plot'] ?? '' : '') }}" placeholder=" ">
                        <label for="rs_total_land_in_plot">RS দাগে মোট জমি</label>
                    </div>
                    <div class="floating-label">
                        <input type="text" id="rs_land_in_khatian" name="ownership_details[rs_land_in_khatian]" value="{{ old('ownership_details.rs_land_in_khatian', isset($compensation) ? $compensation->ownership_details['rs_land_in_khatian'] ?? '' : '') }}" placeholder=" ">
                        <label for="rs_land_in_khatian">RS উক্ত খতিয়ানে জমির পরিমাণ</label>
                    </div>
                </div>
                <!-- Show deed/inheritance only if not owner -->
                <div class="mt-6">
                    <label>আবেদনকারি কি দলিল মূলে মালিক অথবা ওয়ারিশ মূলে মালিক?</label>
                    <div class="radio-group">
                        <label><input type="radio" name="ownership_details[ownership_type]" value="deed" x-model="ownership_type" class="mr-2"><span>দলিল মূলে</span></label>
                        <label><input type="radio" name="ownership_details[ownership_type]" value="inheritance" x-model="ownership_type" class="mr-2"><span>ওয়ারিশ মূলে</span></label>
                    </div>
                </div>
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
    </template>
</div> 