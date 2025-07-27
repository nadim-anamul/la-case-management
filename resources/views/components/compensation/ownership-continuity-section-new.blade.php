<div class="form-section" x-data="ownershipContinuity()">
    <h2 class="form-section-title">
        <span class="section-icon">৪</span>
        মালিকানার ধারাবাহিকতার বর্ণনাঃ
    </h2>

    <!-- Step Progress Indicator -->
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="flex items-center cursor-pointer" @click="goToStep('info')">
                    <div class="w-8 h-8 rounded-full bg-blue-500 text-white flex items-center justify-center text-sm font-bold">১</div>
                    <span class="ml-2 text-sm hover:text-blue-600">SA/RS তথ্য</span>
                </div>
                <div class="flex-1 h-1 bg-gray-300"></div>
                <div class="flex items-center cursor-pointer" @click="goToStep('transfers')" x-show="completedSteps.includes('info')">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold" :class="completedSteps.includes('transfers') ? 'bg-green-500 text-white' : 'bg-gray-300 text-gray-600'">২</div>
                    <span class="ml-2 text-sm hover:text-blue-600">হস্তান্তর/রেকর্ড</span>
                </div>
                <div class="flex-1 h-1 bg-gray-300" x-show="completedSteps.includes('info')"></div>
                <div class="flex items-center cursor-pointer" @click="goToStep('applicant')" x-show="completedSteps.includes('transfers') || currentStep === 'applicant'">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold" :class="completedSteps.includes('applicant') ? 'bg-green-500 text-white' : 'bg-gray-300 text-gray-600'">৩</div>
                    <span class="ml-2 text-sm hover:text-blue-600">আবেদনকারী তথ্য</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Step 1: SA/RS Information -->
    <div x-show="currentStep === 'info'" class="space-y-6">
        <h3 class="text-lg font-bold mb-4">ধাপ ১: SA/RS তথ্য</h3>
        
        <!-- SA Flow -->
        <template x-if="acquisition_record_basis === 'SA'">
            <div>
                <h4 class="font-bold mb-4">SA রেকর্ড তথ্য:</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <template x-for="(owner, index) in sa_owners" :key="index">
                            <div class="flex items-center mb-2">
                                <input type="text" :id="'sa_owner_name_' + index" :name="'ownership_details[sa_info][sa_owners][' + index + '][name]'" x-model="owner.name" class="form-input flex-1" placeholder="SA মালিকের নাম">
                                <label :for="'sa_owner_name_' + index" class="ml-2">SA মালিকের নাম</label>
                                <button type="button" @click="removeSaOwner(index)" x-show="sa_owners.length > 1" class="btn-danger ml-2" title="মালিক মুছুন">×</button>
                            </div>
                        </template>
                        <button type="button" @click="addSaOwner()" class="btn-success mt-2">+ SA মালিক যোগ করুন</button>
                    </div>
                    <div class="floating-label">
                        <input type="text" id="sa_plot_no" name="ownership_details[sa_info][sa_plot_no]" x-model="sa_info.sa_plot_no" placeholder=" ">
                        <label for="sa_plot_no">SA দাগ নম্বর</label>
                    </div>
                    <div class="floating-label">
                        <input type="text" id="sa_khatian_no" name="ownership_details[sa_info][sa_khatian_no]" x-model="sa_info.sa_khatian_no" placeholder=" ">
                        <label for="sa_khatian_no">SA খতিয়ান নম্বর</label>
                    </div>
                    <div class="floating-label">
                        <input type="text" id="sa_total_land_in_plot" name="ownership_details[sa_info][sa_total_land_in_plot]" x-model="sa_info.sa_total_land_in_plot" placeholder=" ">
                        <label for="sa_total_land_in_plot">SA দাগে মোট জমি</label>
                    </div>
                    <div class="floating-label">
                        <input type="text" id="sa_land_in_khatian" name="ownership_details[sa_info][sa_land_in_khatian]" x-model="sa_info.sa_land_in_khatian" placeholder=" ">
                        <label for="sa_land_in_khatian">SA উক্ত খতিয়ানে জমির পরিমাণ</label>
                    </div>
                </div>
            </div>
        </template>

        <!-- RS Flow -->
        <template x-if="acquisition_record_basis === 'RS'">
            <div>
                <h4 class="font-bold mb-4">RS রেকর্ড তথ্য:</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <template x-for="(owner, index) in rs_owners" :key="index">
                            <div class="flex items-center mb-2">
                                <input type="text" :id="'rs_owner_name_' + index" :name="'ownership_details[rs_info][rs_owners][' + index + '][name]'" x-model="owner.name" class="form-input flex-1" placeholder="RS মালিকের নাম">
                                <label :for="'rs_owner_name_' + index" class="ml-2">RS মালিকের নাম</label>
                                <button type="button" @click="removeRsOwner(index)" x-show="rs_owners.length > 1" class="btn-danger ml-2" title="মালিক মুছুন">×</button>
                            </div>
                        </template>
                        <button type="button" @click="addRsOwner()" class="btn-success mt-2">+ RS মালিক যোগ করুন</button>
                    </div>
                    <div class="floating-label">
                        <input type="text" id="rs_plot_no" name="ownership_details[rs_info][rs_plot_no]" x-model="rs_info.rs_plot_no" placeholder=" ">
                        <label for="rs_plot_no">RS দাগ নম্বর</label>
                    </div>
                    <div class="floating-label">
                        <input type="text" id="rs_khatian_no" name="ownership_details[rs_info][rs_khatian_no]" x-model="rs_info.rs_khatian_no" placeholder=" ">
                        <label for="rs_khatian_no">RS খতিয়ান নম্বর</label>
                    </div>
                    <div class="floating-label">
                        <input type="text" id="rs_total_land_in_plot" name="ownership_details[rs_info][rs_total_land_in_plot]" x-model="rs_info.rs_total_land_in_plot" placeholder=" ">
                        <label for="rs_total_land_in_plot">RS দাগে মোট জমি</label>
                    </div>
                    <div class="floating-label">
                        <input type="text" id="rs_land_in_khatian" name="ownership_details[rs_info][rs_land_in_khatian]" x-model="rs_info.rs_land_in_khatian" placeholder=" ">
                        <label for="rs_land_in_khatian">RS খতিয়ানে মোট জমির পরিমাণ</label>
                    </div>
                </div>
            </div>
        </template>

        <div class="mt-6">
            <button type="button" @click="nextStep()" class="btn-primary" :disabled="!isStep1Valid()" :class="!isStep1Valid() ? 'opacity-50 cursor-not-allowed' : ''">পরবর্তী ধাপ</button>
            <div x-show="!isStep1Valid()" class="mt-2 text-sm text-red-600">
                <span>দয়া করে প্রথমে SA/RS তথ্য প্রবেশ করুন</span>
            </div>
        </div>
    </div>

    <!-- Step 2: Transfers and Records -->
    <div x-show="currentStep === 'transfers'" class="space-y-6">
        <h3 class="text-lg font-bold mb-4">ধাপ ২: হস্তান্তর ও রেকর্ড</h3>
        
        <!-- Action Buttons -->
        <div class="flex flex-wrap gap-4 mb-6">
            <button type="button" @click="addDeedTransfer()" class="btn-primary">মালিকানা হস্তান্তর যোগ করুন</button>
            <button type="button" @click="addInheritanceRecord()" class="btn-secondary">ওয়ারিশ রেকর্ড যোগ করুন</button>
            <button type="button" @click="addRsRecord()" :disabled="rs_record_disabled" class="btn-secondary" :class="{ 'opacity-50 cursor-not-allowed': rs_record_disabled }" x-show="acquisition_record_basis === 'SA'">আরএস রেকর্ড যোগ করুন</button>
            <button type="button" @click="nextStep()" class="btn-success">উপরোক্ত মালিকই আবেদনকারী</button>
        </div>

        <!-- Summary of Added Items -->
        <div class="bg-gray-50 p-4 rounded-lg mb-6">
            <h4 class="font-bold mb-2">যোগ করা আইটেম:</h4>
            <div class="space-y-2">
                <template x-for="(item, index) in transferItems" :key="index">
                    <div class="flex items-center justify-between bg-white p-2 rounded hover:bg-gray-50 cursor-pointer" @click="scrollToForm(item)">
                        <span x-text="item.type + ' #' + (index + 1)" class="flex-1"></span>
                        <button type="button" @click.stop="removeTransferItem(index)" class="text-red-500 hover:text-red-700 p-1" title="মুছুন">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                </template>
                <div x-show="transferItems.length === 0" class="text-gray-500">কোন আইটেম যোগ করা হয়নি</div>
            </div>
        </div>

        <!-- Deed Transfer Forms -->
        <template x-for="(deed, index) in deed_transfers" :key="'deed_' + index">
            <div class="record-card mb-4" x-show="deed.isVisible">
                <h5 x-text="'দলিল #' + (deed_transfers.filter(d => d.isVisible).length - deed_transfers.filter(d => d.isVisible).indexOf(deed))" class="text-lg font-semibold mb-3"></h5>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="floating-label">
                        <input type="text" :id="'deed_donor_name_' + index" :name="'ownership_details[transfer_info][deed_transfers][' + index + '][donor_name]'" x-model="deed.donor_name" placeholder=" ">
                        <label :for="'deed_donor_name_' + index">দলিল দাতার নাম<span class="text-red-500">*</span></label>
                    </div>
                    <div class="floating-label">
                        <input type="text" :id="'deed_recipient_name_' + index" :name="'ownership_details[transfer_info][deed_transfers][' + index + '][recipient_name]'" x-model="deed.recipient_name" placeholder=" ">
                        <label :for="'deed_recipient_name_' + index">দলিল গ্রহীতার নাম<span class="text-red-500">*</span></label>
                    </div>
                    <div class="floating-label">
                        <input type="text" :id="'deed_number_' + index" :name="'ownership_details[transfer_info][deed_transfers][' + index + '][deed_number]'" x-model="deed.deed_number" placeholder=" ">
                        <label :for="'deed_number_' + index">দলিল নম্বর<span class="text-red-500">*</span></label>
                    </div>
                    <div class="floating-label">
                        <input type="date" :id="'deed_date_' + index" :name="'ownership_details[transfer_info][deed_transfers][' + index + '][deed_date]'" x-model="deed.deed_date" placeholder=" ">
                        <label :for="'deed_date_' + index">দলিলের তারিখ<span class="text-red-500">*</span></label>
                    </div>
                    <div class="floating-label">
                        <input type="text" :name="'ownership_details[transfer_info][deed_transfers][' + index + '][sale_type]'" placeholder="সুনির্দিষ্ট দাগে অথবা সম্মিলিত দাগের হতে" x-model="deed.sale_type">
                        <label>বিক্রয়ের ধরন</label>
                    </div>
                    <div class="floating-label">
                        <input type="text" :name="'ownership_details[transfer_info][deed_transfers][' + index + '][plot_no]'" x-model="deed.plot_no" placeholder=" ">
                        <label>দাগ নম্বর</label>
                    </div>
                    <div class="floating-label">
                        <input type="text" :name="'ownership_details[transfer_info][deed_transfers][' + index + '][sold_land_amount]'" x-model="deed.sold_land_amount" placeholder=" ">
                        <label>বিক্রিত জমির পরিমাণ</label>
                    </div>
                    <div class="floating-label">
                        <input type="text" :name="'ownership_details[transfer_info][deed_transfers][' + index + '][total_sotangsho]'" x-model="deed.total_sotangsho" placeholder=" ">
                        <label>মোট কত শতাংশ</label>
                    </div>
                    <div class="floating-label">
                        <input type="text" :name="'ownership_details[transfer_info][deed_transfers][' + index + '][total_shotok]'" x-model="deed.total_shotok" placeholder=" ">
                        <label>মোট কত শতক</label>
                    </div>
                    <div class="floating-label">
                        <select :name="'ownership_details[transfer_info][deed_transfers][' + index + '][possession_mentioned]'" x-model="deed.possession_mentioned">
                            <option value="yes">হ্যাঁ</option>
                            <option value="no">না</option>
                        </select>
                        <label>দখল উল্লেখ করা আছে কিনা?</label>
                    </div>
                    <div class="floating-label">
                        <input type="text" :name="'ownership_details[transfer_info][deed_transfers][' + index + '][possession_plot_no]'" x-model="deed.possession_plot_no" placeholder=" ">
                        <label>দখলের দাগ নম্বর</label>
                    </div>
                    <div class="floating-label md:col-span-2">
                        <textarea :name="'ownership_details[transfer_info][deed_transfers][' + index + '][possession_description]'" rows="3" x-model="deed.possession_description" placeholder=" "></textarea>
                        <label>দখল এর বর্ণনা</label>
                    </div>
                </div>
            </div>
        </template>

        <!-- Inheritance Transfer Forms -->
        <template x-for="(inheritance, index) in inheritance_records" :key="'inheritance_' + index">
            <div class="record-card mb-4" x-show="inheritance.isVisible">
                <h5 x-text="'ওয়ারিশ #' + (inheritance_records.filter(i => i.isVisible).length - inheritance_records.filter(i => i.isVisible).indexOf(inheritance))" class="text-lg font-semibold mb-3"></h5>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="floating-label">
                        <input type="text" :id="'inheritance_previous_owner_name_' + index" :name="'ownership_details[transfer_info][inheritance_records][' + index + '][previous_owner_name]'" x-model="inheritance.previous_owner_name" placeholder=" ">
                        <label :for="'inheritance_previous_owner_name_' + index">যে মালিকের থেকে আগত তার নাম<span class="text-red-500">*</span></label>
                    </div>
                    <div class="floating-label">
                        <input type="date" :id="'inheritance_death_date_' + index" :name="'ownership_details[transfer_info][inheritance_records][' + index + '][death_date]'" x-model="inheritance.death_date" placeholder=" ">
                        <label :for="'inheritance_death_date_' + index">পূর্বতন মালিকের মৃত্যুর তারিখ<span class="text-red-500">*</span></label>
                    </div>
                    <div class="floating-label">
                        <input type="text" :id="'inheritance_type_' + index" :name="'ownership_details[transfer_info][inheritance_records][' + index + '][inheritance_type]'" x-model="inheritance.inheritance_type" placeholder=" ">
                        <label :for="'inheritance_type_' + index">হস্তান্তরের ধরন<span class="text-red-500">*</span></label>
                    </div>
                    <div class="floating-label">
                        <select :name="'ownership_details[transfer_info][inheritance_records][' + index + '][has_death_cert]'" x-model="inheritance.has_death_cert">
                            <option value="yes">হ্যাঁ</option>
                            <option value="no">না</option>
                        </select>
                        <label>পূর্বতন মালিকের মৃত্যুসনদ দাখিল করা হয়েছে কিনা?</label>
                    </div>
                    <div class="floating-label md:col-span-2">
                        <textarea :name="'ownership_details[transfer_info][inheritance_records][' + index + '][heirship_certificate_info]'" rows="3" x-model="inheritance.heirship_certificate_info" placeholder=" "></textarea>
                        <label>ওয়ারিশান সনদের তথ্য</label>
                    </div>
                </div>
            </div>
        </template>

        <!-- RS Record Form -->
        <template x-for="(rs, index) in rs_records" :key="'rs_' + index">
            <div class="record-card mb-4" x-show="rs.isVisible">
                <h5 x-text="'আরএস রেকর্ড #' + (rs_records.filter(r => r.isVisible).length - rs_records.filter(r => r.isVisible).indexOf(rs))" class="text-lg font-semibold mb-3"></h5>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="floating-label">
                        <input type="text" :id="'rs_record_plot_no_' + index" :name="'ownership_details[rs_records][' + index + '][plot_no]'" x-model="rs.plot_no" placeholder=" ">
                        <label :for="'rs_record_plot_no_' + index">আরএস দাগ নম্বর</label>
                    </div>
                    <div class="floating-label">
                        <input type="text" :id="'rs_record_khatian_no_' + index" :name="'ownership_details[rs_records][' + index + '][khatian_no]'" x-model="rs.khatian_no" placeholder=" ">
                        <label :for="'rs_record_khatian_no_' + index">আরএস খতিয়ান নম্বর</label>
                    </div>
                    <div class="floating-label">
                        <input type="text" :id="'rs_record_land_amount_' + index" :name="'ownership_details[rs_records][' + index + '][land_amount]'" x-model="rs.land_amount" placeholder=" ">
                        <label :for="'rs_record_land_amount_' + index">আরএস জমির পরিমাণ</label>
                    </div>
                    <div class="floating-label">
                        <input type="text" :id="'rs_record_owner_name_' + index" :name="'ownership_details[rs_records][' + index + '][owner_name]'" x-model="rs.owner_name" placeholder=" ">
                        <label :for="'rs_record_owner_name_' + index">আরএস মালিকের নাম</label>
                    </div>
                </div>
            </div>
        </template>
    </div>

    <!-- Step 3: Applicant Owner Information -->
    <div x-show="currentStep === 'applicant'" class="space-y-6">
        <h3 class="text-lg font-bold mb-4">ধাপ ৩: আবেদনকারী তথ্য</h3>
        
        <!-- Summary Section -->
        <div class="bg-blue-50 p-6 rounded-lg mb-6">
            <h4 class="font-bold text-lg mb-4 text-blue-800">মালিকানার ধারাবাহিকতার সারসংক্ষেপ</h4>
            
            <!-- SA/RS Info Summary -->
            <div class="mb-4">
                <h5 class="font-semibold text-blue-700 mb-2">১। SA/RS তথ্য:</h5>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div x-show="sa_info.sa_plot_no">
                        <span class="font-medium">SA দাগ নম্বর:</span> <span x-text="sa_info.sa_plot_no"></span>
                    </div>
                    <div x-show="sa_info.sa_khatian_no">
                        <span class="font-medium">SA খতিয়ান নম্বর:</span> <span x-text="sa_info.sa_khatian_no"></span>
                    </div>
                    <div x-show="sa_info.sa_total_land_in_plot">
                        <span class="font-medium">SA দাগে মোট জমি:</span> <span x-text="sa_info.sa_total_land_in_plot"></span>
                    </div>
                    <div x-show="sa_info.sa_land_in_khatian">
                        <span class="font-medium">SA খতিয়ানে জমির পরিমাণ:</span> <span x-text="sa_info.sa_land_in_khatian"></span>
                    </div>
                    <div x-show="rs_info.rs_plot_no">
                        <span class="font-medium">RS দাগ নম্বর:</span> <span x-text="rs_info.rs_plot_no"></span>
                    </div>
                    <div x-show="rs_info.rs_khatian_no">
                        <span class="font-medium">RS খতিয়ান নম্বর:</span> <span x-text="rs_info.rs_khatian_no"></span>
                    </div>
                    <div x-show="rs_info.rs_total_land_in_plot">
                        <span class="font-medium">RS দাগে মোট জমি:</span> <span x-text="rs_info.rs_total_land_in_plot"></span>
                    </div>
                    <div x-show="rs_info.rs_land_in_khatian">
                        <span class="font-medium">RS খতিয়ানে জমির পরিমাণ:</span> <span x-text="rs_info.rs_land_in_khatian"></span>
                    </div>
                </div>
            </div>
            
            <!-- Transfer Items Summary -->
            <div class="mb-4" x-show="transferItems.length > 0">
                <h5 class="font-semibold text-blue-700 mb-2">২। হস্তান্তর/রেকর্ড:</h5>
                <div class="space-y-2">
                    <template x-for="(item, index) in transferItems" :key="index">
                        <div class="bg-white p-2 rounded border-l-4 border-blue-500">
                            <span class="font-medium" x-text="item.type + ' #' + (index + 1)"></span>
                        </div>
                    </template>
                </div>
            </div>
            
            <!-- Applicant Info Summary -->
            <div>
                <h5 class="font-semibold text-blue-700 mb-2">৩। আবেদনকারী তথ্য:</h5>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div x-show="applicant_info.applicant_name">
                        <span class="font-medium">আবেদনকারীর নাম:</span> <span x-text="applicant_info.applicant_name"></span>
                    </div>
                    <div x-show="applicant_info.kharij_case_no">
                        <span class="font-medium">খারিজ কেস নম্বর:</span> <span x-text="applicant_info.kharij_case_no"></span>
                    </div>
                    <div x-show="applicant_info.kharij_plot_no">
                        <span class="font-medium">খারিজ দাগ নম্বর:</span> <span x-text="applicant_info.kharij_plot_no"></span>
                    </div>
                    <div x-show="applicant_info.kharij_land_amount">
                        <span class="font-medium">খারিজকৃত জমির পরিমাণ:</span> <span x-text="applicant_info.kharij_land_amount"></span>
                    </div>
                    <div x-show="applicant_info.kharij_date">
                        <span class="font-medium">খারিজের তারিখ:</span> <span x-text="applicant_info.kharij_date"></span>
                    </div>
                    <div x-show="applicant_info.kharij_details" class="md:col-span-2">
                        <span class="font-medium">খারিজের বিস্তারিত বিবরণ:</span> <span x-text="applicant_info.kharij_details"></span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- উপরোক্ত মালিকই আবেদনকারী Form -->
        <div class="bg-white p-6 rounded-lg border border-gray-200">
            <h4 class="font-bold text-lg mb-4 text-blue-800">উপরোক্ত মালিকই আবেদনকারী</h4>
            <p class="text-gray-600 mb-4">আবেদনকারী যদি উপরোক্ত মালিক হন, তাহলে তার খারিজের তথ্য দিন:</p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="floating-label">
                    <input type="text" name="ownership_details[applicant_info][applicant_name]" x-model="applicant_info.applicant_name" placeholder=" ">
                    <label>আবেদনকারীর নাম</label>
                </div>
                <div class="floating-label">
                    <input type="text" name="ownership_details[applicant_info][kharij_case_no]" x-model="applicant_info.kharij_case_no" placeholder=" ">
                    <label>খারিজ কেস নম্বর</label>
                </div>
                <div class="floating-label">
                    <input type="text" name="ownership_details[applicant_info][kharij_plot_no]" x-model="applicant_info.kharij_plot_no" placeholder=" ">
                    <label>খারিজ দাগ নম্বর</label>
                </div>
                <div class="floating-label">
                    <input type="text" name="ownership_details[applicant_info][kharij_land_amount]" x-model="applicant_info.kharij_land_amount" placeholder=" ">
                    <label>খারিজকৃত জমির পরিমাণ</label>
                </div>
                <div class="floating-label">
                    <input type="date" name="ownership_details[applicant_info][kharij_date]" x-model="applicant_info.kharij_date" placeholder=" ">
                    <label>খারিজের তারিখ</label>
                </div>
                <div class="floating-label md:col-span-2">
                    <textarea name="ownership_details[applicant_info][kharij_details]" rows="3" x-model="applicant_info.kharij_details" placeholder=" "></textarea>
                    <label>খারিজের বিস্তারিত বিবরণ</label>
                </div>
            </div>
        </div>

        <div class="mt-6">
            <button type="button" @click="prevStep()" class="btn-secondary mr-4">পূর্ববর্তী ধাপ</button>
            <button type="button" @click="saveAllData()" class="btn-success">সব তথ্য সংরক্ষণ করুন</button>
        </div>
    </div>

    <!-- Alert System -->
    <div x-show="alert.show" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform translate-y-2"
         class="fixed top-4 right-4 z-50 max-w-sm w-full"
         :class="alert.type === 'success' ? 'bg-green-500' : 'bg-red-500'">
        <div class="flex items-center p-4 text-white">
            <div class="flex-shrink-0">
                <svg x-show="alert.type === 'success'" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <svg x-show="alert.type === 'error'" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium" x-text="alert.message"></p>
            </div>
            <div class="ml-auto pl-3">
                <button @click="hideAlert()" class="text-white hover:text-gray-200">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <div x-show="currentStep !== 'applicant'" class="mt-6">
        <button type="button" @click="prevStep()" x-show="currentStep !== 'info'" class="btn-secondary mr-4">পূর্ববর্তী ধাপ</button>
        <button type="button" @click="saveStepData()" class="btn-primary">বর্তমান ধাপ সংরক্ষণ করুন</button>
    </div>
</div>

<script>
function ownershipContinuity() {
    return {
        currentStep: 'info',
        completedSteps: [],
        transferItems: [],
        rs_record_disabled: false,
        alert: {
            show: false,
            message: '',
            type: 'success'
        },
        
        // Data objects
        sa_info: {
            sa_plot_no: '',
            sa_khatian_no: '',
            sa_total_land_in_plot: '',
            sa_land_in_khatian: ''
        },
        rs_info: {
            rs_plot_no: '',
            rs_khatian_no: '',
            rs_total_land_in_plot: '',
            rs_land_in_khatian: ''
        },
        applicant_info: {
            applicant_name: '',
            kharij_case_no: '',
            kharij_plot_no: '',
            kharij_land_amount: '',
            kharij_date: '',
            kharij_details: ''
        },

        
        // Arrays
        sa_owners: [{'name': ''}],
        rs_owners: [{'name': ''}],
        deed_transfers: [],
        inheritance_records: [],
        rs_records: [],
        
        showAlert(message, type = 'success') {
            this.alert.message = message;
            this.alert.type = type;
            this.alert.show = true;
            
            // Auto-hide after 3 seconds
            setTimeout(() => {
                this.hideAlert();
            }, 3000);
        },
        
        hideAlert() {
            this.alert.show = false;
        },
        
        isStep1Valid() {
            // Check if at least some basic SA or RS information is entered
            const hasSaInfo = this.sa_info.sa_plot_no || this.sa_info.sa_khatian_no || this.sa_info.sa_total_land_in_plot || this.sa_info.sa_land_in_khatian;
            const hasRsInfo = this.rs_info.rs_plot_no || this.rs_info.rs_khatian_no || this.rs_info.rs_total_land_in_plot || this.rs_info.rs_land_in_khatian;
            const hasSaOwners = this.sa_owners.some(owner => owner.name && owner.name.trim() !== '');
            const hasRsOwners = this.rs_owners.some(owner => owner.name && owner.name.trim() !== '');
            
            // At least one of SA or RS information should be filled
            return hasSaInfo || hasRsInfo || hasSaOwners || hasRsOwners;
        },
        
        goToStep(step) {
            // Allow navigation to completed steps, current step, or applicant step if transfers are completed
            if (this.completedSteps.includes(step) || step === this.currentStep || (step === 'applicant' && this.completedSteps.includes('transfers'))) {
                this.currentStep = step;
            }
        },
        
        nextStep() {
            if (this.currentStep === 'info') {
                this.currentStep = 'transfers';
                this.completedSteps.push('info');
            } else if (this.currentStep === 'transfers') {
                this.currentStep = 'applicant';
                this.completedSteps.push('transfers');
                this.completedSteps.push('applicant');
            }
        },
        
        prevStep() {
            if (this.currentStep === 'transfers') {
                this.currentStep = 'info';
            } else if (this.currentStep === 'applicant') {
                this.currentStep = 'transfers';
            }
        },
        
        addSaOwner() {
            this.sa_owners.push({ name: '' });
        },
        
        removeSaOwner(index) {
            if (this.sa_owners.length > 1) {
                this.sa_owners.splice(index, 1);
            }
        },
        
        addRsOwner() {
            this.rs_owners.push({ name: '' });
        },
        
        removeRsOwner(index) {
            if (this.rs_owners.length > 1) {
                this.rs_owners.splice(index, 1);
            }
        },
        
        addDeedTransfer() {
            const newDeed = {
                donor_name: '',
                recipient_name: '',
                deed_number: '',
                deed_date: '',
                sale_type: '',
                plot_no: '',
                sold_land_amount: '',
                total_sotangsho: '',
                total_shotok: '',
                possession_mentioned: 'no',
                possession_plot_no: '',
                possession_description: '',
                isVisible: true
            };
            // Insert at the beginning of the array to show at top
            this.deed_transfers.unshift(newDeed);
            this.transferItems.push({ type: 'দলিল', index: 0 });
        },
        
        addInheritanceRecord() {
            const newInheritance = {
                previous_owner_name: '',
                death_date: '',
                inheritance_type: '',
                has_death_cert: 'no',
                heirship_certificate_info: '',
                isVisible: true
            };
            // Insert at the beginning of the array to show at top
            this.inheritance_records.unshift(newInheritance);
            this.transferItems.push({ type: 'ওয়ারিশ', index: 0 });
        },
        
        addRsRecord() {
            const newRs = {
                plot_no: '',
                khatian_no: '',
                land_amount: '',
                owner_name: '',
                isVisible: true
            };
            // Insert at the beginning of the array to show at top
            this.rs_records.unshift(newRs);
            this.transferItems.push({ type: 'আরএস রেকর্ড', index: 0 });
            this.rs_record_disabled = true;
        },
        
        removeTransferItem(index) {
            const item = this.transferItems[index];
            if (item.type === 'দলিল') {
                this.deed_transfers[item.index].isVisible = false;
            } else if (item.type === 'ওয়ারিশ') {
                this.inheritance_records[item.index].isVisible = false;
            } else if (item.type === 'আরএস রেকর্ড') {
                this.rs_records[item.index].isVisible = false;
                this.rs_record_disabled = false;
            }
            this.transferItems.splice(index, 1);
        },
        
        scrollToForm(item) {
            // Scroll to the specific form based on item type and index
            setTimeout(() => {
                let selector = '';
                if (item.type === 'দলিল') {
                    const visibleDeeds = this.deed_transfers.filter(d => d.isVisible);
                    const deedNumber = visibleDeeds.length - visibleDeeds.indexOf(this.deed_transfers[item.index]);
                    selector = `[x-text="'দলিল #' + ${deedNumber}"]`;
                } else if (item.type === 'ওয়ারিশ') {
                    const visibleInheritances = this.inheritance_records.filter(i => i.isVisible);
                    const inheritanceNumber = visibleInheritances.length - visibleInheritances.indexOf(this.inheritance_records[item.index]);
                    selector = `[x-text="'ওয়ারিশ #' + ${inheritanceNumber}"]`;
                } else if (item.type === 'আরএস রেকর্ড') {
                    const visibleRs = this.rs_records.filter(r => r.isVisible);
                    const rsNumber = visibleRs.length - visibleRs.indexOf(this.rs_records[item.index]);
                    selector = `[x-text="'আরএস রেকর্ড #' + ${rsNumber}"]`;
                }
                
                const element = document.querySelector(selector);
                if (element) {
                    element.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    element.closest('.record-card').classList.add('ring-2', 'ring-blue-500');
                    setTimeout(() => {
                        element.closest('.record-card').classList.remove('ring-2', 'ring-blue-500');
                    }, 2000);
                }
            }, 100);
        },
        
        saveStepData() {
            // Save current step data to localStorage or send to server
            const stepData = {
                step: this.currentStep,
                data: {
                    sa_info: this.sa_info,
                    rs_info: this.rs_info,
                    sa_owners: this.sa_owners,
                    rs_owners: this.rs_owners,
                    deed_transfers: this.deed_transfers,
                    inheritance_records: this.inheritance_records,
                    rs_records: this.rs_records,
                    applicant_info: this.applicant_info
                }
            };
            
            // You can implement AJAX call here to save to server
            console.log('Saving step data:', stepData);
            
            // Show success alert
            this.showAlert('বর্তমান ধাপের তথ্য সফলভাবে সংরক্ষিত হয়েছে!', 'success');
            
            // Auto-navigate to Step 2 after saving
            if (this.currentStep === 'info') {
                setTimeout(() => {
                    this.nextStep();
                }, 1000);
            }
        },
        
        saveAllData() {
            // Save all data and complete the form
            const allData = {
                sa_info: this.sa_info,
                rs_info: this.rs_info,
                sa_owners: this.sa_owners,
                rs_owners: this.rs_owners,
                deed_transfers: this.deed_transfers.filter(d => d.isVisible),
                inheritance_records: this.inheritance_records.filter(i => i.isVisible),
                rs_records: this.rs_records.filter(r => r.isVisible),
                applicant_info: this.applicant_info,
                transferItems: this.transferItems
            };
            
            // You can implement AJAX call here to save to server
            console.log('Saving all data:', allData);
            
            // Show comprehensive summary alert
            this.showAlert('সব তথ্য সফলভাবে সংরক্ষিত হয়েছে! মালিকানার ধারাবাহিকতা সম্পূর্ণ হয়েছে।', 'success');
        }
    }
}
</script> 