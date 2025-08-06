

<div class="form-section" x-data="ownershipContinuity()">
    <h2 class="form-section-title">
        <span class="section-icon">৪</span>
        মালিকানার ধারাবাহিকতার বর্ণনাঃ
    </h2>

    <!-- Enhanced Step Progress Indicator -->
    <div class="mb-8">
        <div class="max-w-4xl mx-auto">
            <!-- Progress Bar Container -->
            <div class="relative">
                <!-- Background Progress Bar -->
                <div class="absolute top-4.5 left-0 right-0 h-1.5 bg-gray-200 rounded-full"></div>
                
                <!-- Active Progress Bar -->
                <div class="absolute top-4.5 left-0 h-1.5 bg-gradient-to-r from-blue-500 to-green-500 rounded-full transition-all duration-500 ease-in-out shadow-sm"
                     :style="`width: ${getProgressWidth()}%`"></div>
                
                <!-- Step Indicators -->
                <div class="relative flex justify-between items-center">
                    <!-- Step 1 -->
                    <div class="flex flex-col items-center">
                        <div class="relative">
                            <!-- Step Circle -->
                            <div class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold transition-all duration-300 hover:scale-110 relative"
                                 :class="getStepClasses('info')"
                                 @click="goToStep('info')"
                                 :style="getStepClasses('info').includes('cursor-not-allowed') ? 'cursor: not-allowed;' : 'cursor: pointer;'">
                                <span x-text="'১'"></span>
                                
                                <!-- Small Check Icon for Completed Steps -->
                                <svg x-show="completedSteps.includes('info')" class="absolute -top-1 -right-1 w-4 h-4 bg-green-500 text-white rounded-full p-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            
                            <!-- Connection Line -->
                            <div class="absolute top-4.5 left-9 w-full h-0.5 bg-gray-300 transform -translate-y-px"
                                 x-show="completedSteps.includes('info')"></div>
                        </div>
                        
                        <!-- Step Label -->
                        <div class="mt-3 text-center transition-all duration-200 hover:-translate-y-0.5">
                            <div class="text-sm font-semibold transition-colors duration-200"
                                 :class="currentStep === 'info' ? 'text-blue-500' : completedSteps.includes('info') ? 'text-green-500' : 'text-gray-500'">
                                রেকর্ডের বর্ণনা
                            </div>
                        </div>
                    </div>
                    
                    <!-- Step 2 -->
                    <div class="flex flex-col items-center">
                        <div class="relative">
                            <!-- Step Circle -->
                            <div class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold transition-all duration-300 hover:scale-110 relative"
                                 :class="getStepClasses('transfers')"
                                 @click="goToStep('transfers')"
                                 :style="getStepClasses('transfers').includes('cursor-not-allowed') ? 'cursor: not-allowed;' : 'cursor: pointer;'">
                                <span x-text="'২'"></span>
                                
                                <!-- Small Check Icon for Completed Steps -->
                                <svg x-show="completedSteps.includes('transfers')" class="absolute -top-1 -right-1 w-4 h-4 bg-green-500 text-white rounded-full p-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            
                            <!-- Connection Line -->
                            <div class="absolute top-4.5 left-9 w-full h-0.5 bg-gray-300 transform -translate-y-px"
                                 x-show="completedSteps.includes('transfers')"></div>
                        </div>
                        
                        <!-- Step Label -->
                        <div class="mt-3 text-center transition-all duration-200 hover:-translate-y-0.5">
                            <div class="text-sm font-semibold transition-colors duration-200"
                                 :class="currentStep === 'transfers' ? 'text-green-500' : completedSteps.includes('transfers') ? 'text-green-500' : 'text-gray-500'">
                                হস্তান্তর/রেকর্ড
                            </div>
                        </div>
                    </div>
                    
                    <!-- Step 3 -->
                    <div class="flex flex-col items-center">
                        <div class="relative">
                            <!-- Step Circle -->
                            <div class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold transition-all duration-300 hover:scale-110 relative"
                                 :class="getStepClasses('applicant')"
                                 @click="goToStep('applicant')"
                                 :style="getStepClasses('applicant').includes('cursor-not-allowed') ? 'cursor: not-allowed;' : 'cursor: pointer;'">
                                <span x-text="'৩'"></span>
                                
                                <!-- Small Check Icon for Completed Steps -->
                                <svg x-show="completedSteps.includes('applicant')" class="absolute -top-1 -right-1 w-4 h-4 bg-green-500 text-white rounded-full p-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        
                        <!-- Step Label -->
                        <div class="mt-3 text-center transition-all duration-200 hover:-translate-y-0.5">
                            <div class="text-sm font-semibold transition-colors duration-200"
                                 :class="currentStep === 'applicant' ? 'text-blue-500' : completedSteps.includes('applicant') ? 'text-green-500' : 'text-gray-500'">
                                আবেদনকারী তথ্য
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Progress Status -->
            <div class="mt-4 text-center">
                <div class="text-sm font-medium text-gray-700">
                    <span x-text="getCurrentStepText()"></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Step 1: SA/RS Information -->
    <div x-show="currentStep === 'info'" class="space-y-6">
        <h3 class="text-lg font-bold mb-4">ধাপ ১: SA/RS রেকর্ডের বর্ণনা</h3>
        
        <!-- SA Flow -->
        <template x-if="acquisition_record_basis === 'SA'">
            <div>
                <h4 class="font-bold mb-4">SA রেকর্ডের তথ্য:</h4>
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
                    </div>
                    <div class="floating-label">
                        <input type="text" id="ownership_sa_plot_no" name="ownership_details[sa_info][sa_plot_no]" x-model="sa_info.sa_plot_no" placeholder=" ">
                        <label for="ownership_sa_plot_no">SA দাগ নম্বর</label>
                        @error('ownership_details.sa_info.sa_plot_no')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="floating-label">
                        <input type="text" id="ownership_sa_khatian_no" name="ownership_details[sa_info][sa_khatian_no]" x-model="sa_info.sa_khatian_no" placeholder=" ">
                        <label for="ownership_sa_khatian_no">SA খতিয়ান নম্বর</label>
                        @error('ownership_details.sa_info.sa_khatian_no')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="floating-label">
                        <input type="text" id="ownership_sa_total_land_in_plot" name="ownership_details[sa_info][sa_total_land_in_plot]" x-model="sa_info.sa_total_land_in_plot" placeholder=" ">
                        <label for="ownership_sa_total_land_in_plot">SA দাগে মোট জমি (একর)</label>
                        @error('ownership_details.sa_info.sa_total_land_in_plot')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="floating-label">
                        <input type="text" id="ownership_sa_land_in_khatian" name="ownership_details[sa_info][sa_land_in_khatian]" x-model="sa_info.sa_land_in_khatian" placeholder=" ">
                        <label for="ownership_sa_land_in_khatian">উক্ত SA খতিয়ানে জমির পরিমাণ (একর)</label>
                        @error('ownership_details.sa_info.sa_land_in_khatian')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </template>

        <!-- RS Flow -->
        <template x-if="acquisition_record_basis === 'RS'">
            <div>
                <h4 class="font-bold mb-4">RS রেকর্ডের তথ্য:</h4>
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
                    </div>
                    <div class="floating-label">
                        <input type="text" id="ownership_rs_plot_no" name="ownership_details[rs_info][rs_plot_no]" x-model="rs_info.rs_plot_no" placeholder=" ">
                        <label for="ownership_rs_plot_no">RS দাগ নম্বর</label>
                        @error('ownership_details.rs_info.rs_plot_no')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="floating-label">
                        <input type="text" id="ownership_rs_khatian_no" name="ownership_details[rs_info][rs_khatian_no]" x-model="rs_info.rs_khatian_no" placeholder=" ">
                        <label for="ownership_rs_khatian_no">RS খতিয়ান নম্বর</label>
                        @error('ownership_details.rs_info.rs_khatian_no')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="floating-label">
                        <input type="text" id="ownership_rs_total_land_in_plot" name="ownership_details[rs_info][rs_total_land_in_plot]" x-model="rs_info.rs_total_land_in_plot" placeholder=" ">
                        <label for="ownership_rs_total_land_in_plot">RS দাগে মোট জমি (একর)</label>
                        @error('ownership_details.rs_info.rs_total_land_in_plot')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="floating-label">
                        <input type="text" id="ownership_rs_land_in_khatian" name="ownership_details[rs_info][rs_land_in_khatian]" x-model="rs_info.rs_land_in_khatian" placeholder=" ">
                        <label for="ownership_rs_land_in_khatian">উক্ত দাগে RS খতিয়ানের হিস্যানুযায়ী জমির পরিমাণ (একর)</label>
                        @error('ownership_details.rs_info.rs_land_in_khatian')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="flex items-center space-x-2">
                        <label for="ownership_rs_dp_khatian">
                            <input type="checkbox" id="ownership_rs_dp_khatian" name="ownership_details[rs_info][dp_khatian]" x-model="rs_info.dp_khatian" class="form-checkbox mr-2">
                            ডিপি খতিয়ান
                        </label>
                    </div>
                </div>
            </div>
        </template>

        <!-- Navigation Buttons -->
        <div class="flex justify-between mt-6">
            <button type="button" @click="nextStep()" class="btn-secondary" :disabled="!isStep1Valid()">
                পরবর্তী ধাপ
            </button>
        </div>
    </div>

    <!-- Step 2: Transfers and Records -->
    <div x-show="currentStep === 'transfers'" class="space-y-6">
        <h3 class="text-lg font-bold mb-4">ধাপ ২: হস্তান্তর ও রেকর্ড</h3>
        
        <!-- Action Buttons -->
        {{-- <div class="flex flex-wrap gap-4 mb-6">
            <button type="button" @click="addDeedTransfer()" class="btn-primary">দলিলমূলে মালিকানা হস্তান্তর যোগ করুন</button>
            <button type="button" @click="addInheritanceRecord()" class="btn-primary">ওয়ারিশমূলে হস্তান্তর যোগ করুন</button>
            <button type="button" @click="addRsRecord()" :disabled="rs_record_disabled" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200" :class="{ 'opacity-50 cursor-not-allowed': rs_record_disabled }" x-show="acquisition_record_basis === 'SA'">আরএস রেকর্ড যোগ করুন</button>
            <button type="button" @click="nextStep()" class="btn-success">উপরোক্ত মালিকই আবেদনকারী</button>
        </div> --}}

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
            <div class="record-card mb-4">
                <h5 x-text="'দলিল #' + (index + 1)" class="text-lg font-semibold mb-3"></h5>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Multiple Donors -->
                    <div>
                        <template x-for="(donor, donorIdx) in deed.donor_names" :key="donorIdx">
                            <div class="flex items-center mb-2">
                                <input type="text" :id="'deed_donor_name_' + index + '_' + donorIdx" :name="'ownership_details[deed_transfers][' + index + '][donor_names][' + donorIdx + '][name]'" x-model="donor.name" class="form-input flex-1" placeholder="দলিল দাতার নাম">
                                <label :for="'deed_donor_name_' + index + '_' + donorIdx" class="ml-2">দলিল দাতার নাম</label>
                                <button type="button" @click="removeDeedDonor(index, donorIdx)" x-show="deed.donor_names.length > 1" class="btn-danger ml-2" title="দাতার নাম মুছুন">×</button>
                            </div>
                        </template>
                        <button type="button" @click="addDeedDonor(index)" class="btn-success mt-2">+ দলিল দাতার নাম যোগ করুন</button>
                    </div>
                    <!-- Multiple Recipients -->
                    <div>
                        <template x-for="(recipient, recipientIdx) in deed.recipient_names" :key="recipientIdx">
                            <div class="flex items-center mb-2">
                                <input type="text" :id="'deed_recipient_name_' + index + '_' + recipientIdx" :name="'ownership_details[deed_transfers][' + index + '][recipient_names][' + recipientIdx + '][name]'" x-model="recipient.name" class="form-input flex-1" placeholder="দলিল গ্রহীতার নাম">
                                <label :for="'deed_recipient_name_' + index + '_' + recipientIdx" class="ml-2">দলিল গ্রহীতার নাম</label>
                                <button type="button" @click="removeDeedRecipient(index, recipientIdx)" x-show="deed.recipient_names.length > 1" class="btn-danger ml-2" title="গ্রহীতার নাম মুছুন">×</button>
                            </div>
                        </template>
                        <button type="button" @click="addDeedRecipient(index)" class="btn-success mt-2">+ দলিল গ্রহীতার নাম যোগ করুন</button>
                    </div>
                    <div class="floating-label">
                        <input type="text" :id="'deed_number_' + index" :name="'ownership_details[deed_transfers][' + index + '][deed_number]'" x-model="deed.deed_number" placeholder=" ">
                        <label :for="'deed_number_' + index">দলিল নম্বর<span class="text-red-500">*</span></label>
                    </div>
                    <div class="floating-label">
                        <input type="text" :id="'deed_date_' + index" :name="'ownership_details[deed_transfers][' + index + '][deed_date]'" x-model="deed.deed_date" placeholder="দিন/মাস/বছর">
                        <label :for="'deed_date_' + index">দলিলের তারিখ<span class="text-red-500">*</span></label>
                    </div>
                    <div class="floating-label">
                        <input type="text" :name="'ownership_details[deed_transfers][' + index + '][sale_type]'" x-model="deed.sale_type">
                        <label>দলিলের ধরন</label>
                    </div>

                    
                    <!-- Application Area Section -->
                    <div class="form-section md:col-span-2">
                        <label class="font-semibold text-gray-700 mb-2"> আবেদনকৃত দাগে বিক্রয়ের ধরন: <span class="text-red-500">*</span></label>
                        <div class="space-y-4">
                            <!-- Radio button selection -->
                            <div class="mb-4">
                                <div class="radio-group">
                                    <label class="flex items-center mb-2 p-2 rounded" :class="deed.application_type === 'specific' ? 'bg-blue-100 border border-blue-300' : 'bg-gray-50 border border-gray-200'">
                                        <input type="radio" :name="'ownership_details[deed_transfers][' + index + '][application_type]'" value="specific" x-model="deed.application_type" @change="handleApplicationTypeChange(deed)" class="mr-2">
                                        <span class="font-medium">সুনির্দিষ্ট দাগ</span>
                                    </label>
                                    <label class="flex items-center p-2 rounded" :class="deed.application_type === 'multiple' ? 'bg-green-100 border border-green-300' : 'bg-gray-50 border border-gray-200'">
                                        <input type="radio" :name="'ownership_details[deed_transfers][' + index + '][application_type]'" value="multiple" x-model="deed.application_type" @change="handleApplicationTypeChange(deed)" class="mr-2">
                                        <span class="font-medium">বিভিন্ন দাগ</span>
                                    </label>
                                </div>
                                <!-- Validation Error Message -->
                                <div x-show="getApplicationAreaValidation(deed).hasError" class="mt-2 text-red-500 text-sm">
                                    <span x-text="getApplicationAreaValidation(deed).message"></span>
                                </div>
                            </div>
                            
                            <!-- Specific Plot Option -->
                            <div x-show="deed.application_type === 'specific'" class="p-4 border border-blue-200 rounded-lg bg-blue-50">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    আবেদনকৃত 
                                    <input type="text" :name="'ownership_details[deed_transfers][' + index + '][application_specific_area]'" x-model="deed.application_specific_area" @input="validateApplicationAreaFields(deed)" class="form-input mx-2" style="width: 100px; display: inline;" placeholder=" " :class="{'border-red-500': deed.application_type === 'specific' && !deed.application_specific_area}">
                                    <span class="text-red-500">*</span> দাগের সুনির্দিষ্টভাবে 
                                    <input type="text" :name="'ownership_details[deed_transfers][' + index + '][application_sell_area]'" x-model="deed.application_sell_area" @input="validateApplicationAreaFields(deed)" class="form-input mx-2" style="width: 100px; display: inline;" placeholder=" " :class="{'border-red-500': deed.application_type === 'specific' && !deed.application_sell_area}">
                                    <span class="text-red-500">*</span> একর বিক্রয়
                                </label>
                                <div x-show="deed.application_type === 'specific' && (!deed.application_specific_area || !deed.application_sell_area)" class="mt-2 text-red-500 text-sm">
                                    সুনির্দিষ্ট দাগের জন্য সকল তথ্য পূরণ করুন
                                </div>
                            </div>
                            
                            <!-- Multiple Plots Option -->
                            <div x-show="deed.application_type === 'multiple'" class="p-4 border border-green-200 rounded-lg bg-green-50">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    আবেদনকৃত 
                                    <input type="text" :name="'ownership_details[deed_transfers][' + index + '][application_other_areas]'" x-model="deed.application_other_areas" @input="validateApplicationAreaFields(deed)" class="form-input mx-2" style="width: 100px; display: inline;" placeholder=" " :class="{'border-red-500': deed.application_type === 'multiple' && !deed.application_other_areas}">
                                    <span class="text-red-500">*</span> দাগসহ বিভিন্ন দাগ উল্লেখ করে মোট 
                                    <input type="text" :name="'ownership_details[deed_transfers][' + index + '][application_total_area]'" x-model="deed.application_total_area" @input="validateApplicationAreaFields(deed)" class="form-input mx-2" style="width: 100px; display: inline;" placeholder=" " :class="{'border-red-500': deed.application_type === 'multiple' && !deed.application_total_area}">
                                    <span class="text-red-500">*</span> একরের কাতে 
                                    <input type="text" :name="'ownership_details[deed_transfers][' + index + '][application_sell_area_other]'" x-model="deed.application_sell_area_other" @input="validateApplicationAreaFields(deed)" class="form-input mx-2" style="width: 100px; display: inline;" placeholder=" " :class="{'border-red-500': deed.application_type === 'multiple' && !deed.application_sell_area_other}">
                                    <span class="text-red-500">*</span> একর বিক্রয়
                                </label>
                                <div x-show="deed.application_type === 'multiple' && (!deed.application_other_areas || !deed.application_total_area || !deed.application_sell_area_other)" class="mt-2 text-red-500 text-sm">
                                    বিভিন্ন দাগের জন্য সকল তথ্য পূরণ করুন
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- New Possession Section -->
                    <div class="form-section md:col-span-2">
                        <label class="font-semibold text-gray-700 mb-2"> দখলের বর্ণনা:</label>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">i) দলিলের বিবরণ ও হাতনকশায় দখল উল্লেখ রয়েছে কিনা?</label>
                                <div class="radio-group">
                                    <label class="flex items-center">
                                        <input type="radio" :name="'ownership_details[deed_transfers][' + index + '][possession_deed]'" value="yes" x-model="deed.possession_deed" class="mr-2">
                                        <span>হ্যাঁ</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" :name="'ownership_details[deed_transfers][' + index + '][possession_deed]'" value="no" x-model="deed.possession_deed" class="mr-2">
                                        <span>না</span>
                                    </label>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">ii) আবেদনকৃত দাগে দখল উল্লেখ রয়েছে কিনা?</label>
                                <div class="radio-group">
                                    <label class="flex items-center">
                                        <input type="radio" :name="'ownership_details[deed_transfers][' + index + '][possession_application]'" value="yes" x-model="deed.possession_application" class="mr-2">
                                        <span>হ্যাঁ</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" :name="'ownership_details[deed_transfers][' + index + '][possession_application]'" value="no" x-model="deed.possession_application" class="mr-2">
                                        <span>না</span>
                                    </label>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    iii) যে সকল দাগে দখল উল্লেখ করা 
                                    <input type="text" :name="'ownership_details[deed_transfers][' + index + '][mentioned_areas]'" x-model="deed.mentioned_areas" class="form-input ml-2" style="width: 250px; display: inline;" placeholder=" ">
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Special Details Section -->
                    <div class="form-section md:col-span-2">
                        <label class="font-semibold text-gray-700 mb-2">প্রযোজ্যক্ষেত্রে দলিলের বিশেষ বিবরণ:</label>
                        <textarea :name="'ownership_details[deed_transfers][' + index + '][special_details]'" x-model="deed.special_details" rows="4" class="form-input w-full" placeholder=" "></textarea>
                    </div>

                </div>
            </div>
        </template>

        <!-- Inheritance Transfer Forms -->
        <template x-for="(inheritance, index) in inheritance_records" :key="'inheritance_' + index">
            <div class="record-card mb-4">
                <h5 x-text="'ওয়ারিশ #' + (index + 1)" class="text-lg font-semibold mb-3"></h5>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="floating-label">
                        <input type="text" :id="'inheritance_previous_owner_name_' + index" :name="'ownership_details[inheritance_records][' + index + '][previous_owner_name]'" x-model="inheritance.previous_owner_name" placeholder=" ">
                        <label :for="'inheritance_previous_owner_name_' + index">পূর্ববর্তী মালিকের নাম<span class="text-red-500">*</span></label>
                    </div>
                    <div class="floating-label">
                        <input type="text" :id="'inheritance_death_date_' + index" :name="'ownership_details[inheritance_records][' + index + '][death_date]'" x-model="inheritance.death_date" placeholder="দিন/মাস/বছর">
                        <label :for="'inheritance_death_date_' + index">মৃত্যুর তারিখ<span class="text-red-500">*</span></label>
                    </div>
                    <div class="floating-label">
                        <select :name="'ownership_details[inheritance_records][' + index + '][has_death_cert]'" x-model="inheritance.has_death_cert">
                            <option value="yes">হ্যাঁ</option>
                            <option value="no">না</option>
                        </select>
                        <label>মৃত্যু সনদ আছে কিনা</label>
                    </div>
                    <div class="floating-label md:col-span-2">
                        <textarea :name="'ownership_details[inheritance_records][' + index + '][heirship_certificate_info]'" rows="3" x-model="inheritance.heirship_certificate_info" placeholder=" "></textarea>
                        <label>ওয়ারিশান সনদের বিবরণ</label>
                    </div>
                </div>
            </div>
        </template>

        <!-- RS Record Form -->
        <template x-for="(rs, index) in rs_records" :key="'rs_' + index">
            <div class="record-card mb-4">
                <h5 x-text="'আরএস রেকর্ড #' + (index + 1)" class="text-lg font-semibold mb-3"></h5>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <template x-for="(owner, ownerIdx) in rs.owner_names" :key="ownerIdx">
                            <div class="flex items-center mb-2">
                                <input type="text" :id="'rs_record_owner_name_' + index + '_' + ownerIdx" :name="'ownership_details[rs_records][' + index + '][owner_names][' + ownerIdx + '][name]'" x-model="owner.name" class="form-input flex-1" placeholder="আরএস মালিকের নাম">
                                <label :for="'rs_record_owner_name_' + index + '_' + ownerIdx" class="ml-2">আরএস মালিকের নাম</label>
                                <button type="button" @click="removeRsRecordOwner(index, ownerIdx)" x-show="rs.owner_names.length > 1" class="btn-danger ml-2" title="মালিকের নাম মুছুন">×</button>
                            </div>
                        </template>
                        <button type="button" @click="addRsRecordOwner(index)" class="btn-success mt-2">+ আরএস মালিকের নাম যোগ করুন</button>
                    </div>
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
                        <label :for="'rs_record_land_amount_' + index">আরএস দাগে জমির পরিমাণ (একর)</label>
                    </div>
                    <div class="flex items-center space-x-2">
                        <label for="">
                            <input type="checkbox" :id="'rs_record_dp_khatian_' + index" :name="'ownership_details[rs_records][' + index + '][dp_khatian]'" x-model="rs.dp_khatian" class="form-checkbox mr-2">
                            ডিপি খতিয়ান
                        </label>
                    </div>
                    
                </div>
            </div>
        </template>
        
        <!-- Action Buttons at Bottom -->
        <div class="flex flex-wrap gap-4 mt-6">
            <button type="button" @click="addDeedTransfer()" class="btn-primary">দলিলমূলে হস্তান্তর যোগ করুন</button>
            <button type="button" @click="addInheritanceRecord()" class="btn-primary">ওয়ারিশমূলে হস্তান্তর যোগ করুন</button>
            <button type="button" @click="addRsRecord()" :disabled="rs_record_disabled" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200" :class="{ 'opacity-50 cursor-not-allowed': rs_record_disabled }" x-show="acquisition_record_basis === 'SA'">আরএস রেকর্ড যোগ করুন</button>
            <button type="button" @click="nextStep()" class="btn-success">উপরোক্ত মালিকই আবেদনকারী</button>
        </div>
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
                        <span class="font-medium">SA খতিয়ানে জমির পরিমাণ (একর):</span> <span x-text="sa_info.sa_land_in_khatian"></span>
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
                        <span class="font-medium">RS খতিয়ানে জমির পরিমাণ (একর):</span> <span x-text="rs_info.rs_land_in_khatian"></span>
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
                        <span class="font-medium">খারিজকৃত জমির পরিমাণ (একর):</span> <span x-text="applicant_info.kharij_land_amount"></span>
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
            <h5 class="font-semibold text-blue-700 mb-2">খারিজের তথ্য</h5>
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
                    <label>উক্ত দাগে খারিজকৃত জমির পরিমাণ (একর)</label>
                </div>
                                    <div class="floating-label">
                        <input type="text" name="ownership_details[applicant_info][kharij_date]" x-model="applicant_info.kharij_date" placeholder="দিন/মাস/বছর">
                        <label>খারিজের তারিখ</label>
                    </div>
                <div class="floating-label md:col-span-2">
                    <textarea name="ownership_details[applicant_info][kharij_details]" rows="3" x-model="applicant_info.kharij_details" placeholder=" "></textarea>
                    <label>খারিজের বিস্তারিত বিবরণ</label>
                </div>
            </div>
        </div>

        <div class="mt-6">
            <button type="button" @click="prevStep()" class="btn-secondary mr-4"> <- পূর্ববর্তী ধাপ</button>
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
        <button type="button" @click="prevStep()" x-show="currentStep !== 'info'" class="btn-secondary mr-4"> <- পূর্ববর্তী ধাপ</button>
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
            sa_plot_no: @json(old('ownership_details.sa_info.sa_plot_no', '')),
            sa_khatian_no: @json(old('ownership_details.sa_info.sa_khatian_no', '')),
            sa_total_land_in_plot: @json(old('ownership_details.sa_info.sa_total_land_in_plot', '')),
            sa_land_in_khatian: @json(old('ownership_details.sa_info.sa_land_in_khatian', ''))
        },
        rs_info: {
            rs_plot_no: @json(old('ownership_details.rs_info.rs_plot_no', '')),
            rs_khatian_no: @json(old('ownership_details.rs_info.rs_khatian_no', '')),
            rs_total_land_in_plot: @json(old('ownership_details.rs_info.rs_total_land_in_plot', '')),
            rs_land_in_khatian: @json(old('ownership_details.rs_info.rs_land_in_khatian', '')),
            dp_khatian: @json(old('ownership_details.rs_info.dp_khatian', false))
        },
        applicant_info: {
            applicant_name: @json(old('ownership_details.applicant_info.applicant_name', '')),
            kharij_case_no: @json(old('ownership_details.applicant_info.kharij_case_no', '')),
            kharij_plot_no: @json(old('ownership_details.applicant_info.kharij_plot_no', '')),
            kharij_land_amount: @json(old('ownership_details.applicant_info.kharij_land_amount', '')),
            kharij_date: @json(old('ownership_details.applicant_info.kharij_date', '')),
            kharij_details: @json(old('ownership_details.applicant_info.kharij_details', ''))
        },

        
        // Arrays
        sa_owners: @json(old('ownership_details.sa_owners', [['name' => '']])),
        rs_owners: @json(old('ownership_details.rs_owners', [['name' => '']])),
        deed_transfers: @json(old('ownership_details.deed_transfers', [])),
        inheritance_records: @json(old('ownership_details.inheritance_records', [])),
        rs_records: @json(old('ownership_details.rs_records', [])),
        
        init() {
            // Get compensation data from parent form
            const form = this.$el.closest('form');
            if (form) {
                const compensationData = form.dataset.compensation;
                if (compensationData && compensationData !== 'null') {
                    const data = JSON.parse(compensationData);
                    if (data.ownership_details) {
                        // Update SA info
                        if (data.ownership_details.sa_info) {
                            this.sa_info = {
                                sa_plot_no: data.ownership_details.sa_info.sa_plot_no || '',
                                sa_khatian_no: data.ownership_details.sa_info.sa_khatian_no || '',
                                sa_total_land_in_plot: data.ownership_details.sa_info.sa_total_land_in_plot || '',
                                sa_land_in_khatian: data.ownership_details.sa_info.sa_land_in_khatian || ''
                            };
                        }
                        
                        // Update RS info
                        if (data.ownership_details.rs_info) {
                            this.rs_info = {
                                rs_plot_no: data.ownership_details.rs_info.rs_plot_no || '',
                                rs_khatian_no: data.ownership_details.rs_info.rs_khatian_no || '',
                                rs_total_land_in_plot: data.ownership_details.rs_info.rs_total_land_in_plot || '',
                                rs_land_in_khatian: data.ownership_details.rs_info.rs_land_in_khatian || '',
                                dp_khatian: data.ownership_details.rs_info.dp_khatian || false
                            };
                        }
                        
                        // Update applicant info
                        if (data.ownership_details.applicant_info) {
                            this.applicant_info = {
                                applicant_name: data.ownership_details.applicant_info.applicant_name || '',
                                kharij_case_no: data.ownership_details.applicant_info.kharij_case_no || '',
                                kharij_plot_no: data.ownership_details.applicant_info.kharij_plot_no || '',
                                kharij_land_amount: data.ownership_details.applicant_info.kharij_land_amount || '',
                                kharij_date: data.ownership_details.applicant_info.kharij_date || '',
                                kharij_details: data.ownership_details.applicant_info.kharij_details || ''
                            };
                        }
                        
                        // Update arrays
                        this.sa_owners = data.ownership_details.sa_owners || [{'name': ''}];
                        this.rs_owners = data.ownership_details.rs_owners || [{'name': ''}];
                        this.deed_transfers = data.ownership_details.deed_transfers || [];
                        // Ensure application area fields are properly initialized for existing deeds
                        this.deed_transfers.forEach(deed => {
                            if (!deed.application_type) {
                                deed.application_type = '';
                            }
                            if (!deed.application_specific_area) {
                                deed.application_specific_area = '';
                            }
                            if (!deed.application_sell_area) {
                                deed.application_sell_area = '';
                            }
                            if (!deed.application_other_areas) {
                                deed.application_other_areas = '';
                            }
                            if (!deed.application_total_area) {
                                deed.application_total_area = '';
                            }
                            if (!deed.application_sell_area_other) {
                                deed.application_sell_area_other = '';
                            }
                        });
                        this.inheritance_records = data.ownership_details.inheritance_records || [];
                        // Handle RS records with new structure
                        this.rs_records = data.ownership_details.rs_records || [];
                        // Convert old structure to new structure if needed
                        this.rs_records.forEach(rs => {
                            if (rs.owner_name && !rs.owner_names) {
                                rs.owner_names = [{name: rs.owner_name}];
                                delete rs.owner_name;
                            }
                            if (rs.dp_khatian === undefined) {
                                rs.dp_khatian = true;
                            }
                        });
                        this.transferItems = data.ownership_details.transferItems || [];
                        this.currentStep = data.ownership_details.currentStep || 'info';
                        this.completedSteps = data.ownership_details.completedSteps || [];
                        this.rs_record_disabled = data.ownership_details.rs_record_disabled || false;
                        
                        // Auto-detect completed steps based on existing data
                        this.detectCompletedSteps();
                    }
                }
            }
        },
        
        detectCompletedSteps() {
            // Reset completed steps
            this.completedSteps = [];
            
            // Check if Step 1 (info) has data
            if (this.isStep1Valid()) {
                this.completedSteps.push('info');
            }
            
            // Check if Step 2 (transfers) has data
            const hasTransfers = this.deed_transfers.length > 0 || 
                                this.inheritance_records.length > 0 || 
                                this.rs_records.length > 0;
            if (hasTransfers) {
                this.completedSteps.push('transfers');
            }
            
            // Check if Step 3 (applicant) has data
            const hasApplicantInfo = this.applicant_info.applicant_name || 
                                    this.applicant_info.kharij_case_no || 
                                    this.applicant_info.kharij_plot_no || 
                                    this.applicant_info.kharij_land_amount || 
                                    this.applicant_info.kharij_date || 
                                    this.applicant_info.kharij_details;
            if (hasApplicantInfo) {
                this.completedSteps.push('applicant');
            }
        },
        
        isEditMode() {
            // Check if we have existing data (edit mode)
            return this.completedSteps.length > 0 || 
                   this.sa_info.sa_plot_no || this.sa_info.sa_khatian_no ||
                   this.rs_info.rs_plot_no || this.rs_info.rs_khatian_no ||
                   this.deed_transfers.length > 0 || this.inheritance_records.length > 0 ||
                   this.applicant_info.applicant_name || this.applicant_info.kharij_case_no;
        },
        
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
            if (this.isEditMode()) {
                // Edit mode: Allow navigation to any step
                if (this.completedSteps.includes(step) || 
                    step === this.currentStep || 
                    (step === 'applicant' && this.completedSteps.includes('transfers')) ||
                    this.completedSteps.length > 0) {
                    this.currentStep = step;
                }
            } else {
                // Create mode: Sequential navigation only
                const stepOrder = ['info', 'transfers', 'applicant'];
                const currentIndex = stepOrder.indexOf(this.currentStep);
                const targetIndex = stepOrder.indexOf(step);
                
                // Allow navigation to current step, next step if current is completed, or previous completed steps
                if (step === this.currentStep || 
                    (targetIndex === currentIndex + 1 && this.completedSteps.includes(this.currentStep)) ||
                    (targetIndex < currentIndex && this.completedSteps.includes(step))) {
                    this.currentStep = step;
                } else if (targetIndex > currentIndex) {
                    // Show alert for trying to skip steps
                    this.showAlert('অনুগ্রহ করে বর্তমান ধাপ সম্পূর্ণ করুন আগে পরবর্তী ধাপে যাওয়ার জন্য।', 'error');
                }
            }
        },
        
        nextStep() {
            if (this.currentStep === 'info') {
                this.currentStep = 'transfers';
                this.completedSteps.push('info');
            } else if (this.currentStep === 'transfers') {
                // Check if there are any deed transfers that need validation
                const incompleteDeeds = this.deed_transfers.filter(deed => 
                    deed.application_type && 
                    ((deed.application_type === 'specific' && (!deed.application_specific_area || !deed.application_sell_area)) ||
                     (deed.application_type === 'multiple' && (!deed.application_other_areas || !deed.application_total_area || !deed.application_sell_area_other)))
                );
                
                if (incompleteDeeds.length > 0) {
                    // Show warning but allow to proceed
                    if (confirm('কিছু দলিলে আবেদনকৃত দাগের তথ্য অসম্পূর্ণ। আপনি কি এখনও পরবর্তী ধাপে যেতে চান?')) {
                        this.currentStep = 'applicant';
                        this.completedSteps.push('transfers');
                        this.completedSteps.push('applicant');
                    }
                    return;
                }
                
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
                donor_names: [{name: ''}],
                recipient_names: [{name: ''}],
                deed_number: '',
                deed_date: '',
                sale_type: '',
                application_type: '',
                application_specific_area: '',
                application_sell_area: '',
                application_other_areas: '',
                application_total_area: '',
                application_sell_area_other: '',
                possession_mentioned: 'no',
                possession_plot_no: '',
                possession_description: '',
                possession_deed: 'no',
                possession_application: 'no',
                mentioned_areas: '',
                special_details: ''
            };
            // Add at the end of the array to show at bottom
            this.deed_transfers.push(newDeed);
            this.transferItems.push({ type: 'দলিল', index: this.deed_transfers.length - 1 });
        },
        
        addDeedDonor(index) {
            this.deed_transfers[index].donor_names.push({ name: '' });
        },
        
        removeDeedDonor(index, donorIdx) {
            if (this.deed_transfers[index].donor_names.length > 1) {
                this.deed_transfers[index].donor_names.splice(donorIdx, 1);
            }
        },
        
        addDeedRecipient(index) {
            this.deed_transfers[index].recipient_names.push({ name: '' });
        },
        
        removeDeedRecipient(index, recipientIdx) {
            if (this.deed_transfers[index].recipient_names.length > 1) {
                this.deed_transfers[index].recipient_names.splice(recipientIdx, 1);
            }
        },
        
        addInheritanceRecord() {
            const newInheritance = {
                previous_owner_name: '',
                death_date: '',
                has_death_cert: 'no',
                heirship_certificate_info: ''
            };
            // Add at the end of the array to show at bottom
            this.inheritance_records.push(newInheritance);
            this.transferItems.push({ type: 'ওয়ারিশ', index: this.inheritance_records.length - 1 });
        },
        
        addRsRecord() {
            const newRs = {
                owner_names: [{name: ''}],
                plot_no: '',
                khatian_no: '',
                land_amount: '',
                dp_khatian: true
            };
            // Add at the end of the array to show at bottom
            this.rs_records.push(newRs);
            this.transferItems.push({ type: 'আরএস রেকর্ড', index: this.rs_records.length - 1 });
            this.rs_record_disabled = true;
        },
        
        removeTransferItem(index) {
            const item = this.transferItems[index];
            if (item.type === 'দলিল') {
                this.deed_transfers.splice(item.index, 1);
                // Update indices for remaining transfer items of the same type
                this.transferItems.forEach((transferItem, idx) => {
                    if (transferItem.type === 'দলিল' && idx !== index && transferItem.index > item.index) {
                        transferItem.index--;
                    }
                });
            } else if (item.type === 'ওয়ারিশ') {
                this.inheritance_records.splice(item.index, 1);
                // Update indices for remaining transfer items of the same type
                this.transferItems.forEach((transferItem, idx) => {
                    if (transferItem.type === 'ওয়ারিশ' && idx !== index && transferItem.index > item.index) {
                        transferItem.index--;
                    }
                });
            } else if (item.type === 'আরএস রেকর্ড') {
                this.rs_records.splice(item.index, 1);
                // Update indices for remaining transfer items of the same type
                this.transferItems.forEach((transferItem, idx) => {
                    if (transferItem.type === 'আরএস রেকর্ড' && idx !== index && transferItem.index > item.index) {
                        transferItem.index--;
                    }
                });
                this.rs_record_disabled = false;
            }
            this.transferItems.splice(index, 1);
        },
        
        handleApplicationTypeChange(deed) {
            if (deed.application_type === 'specific') {
                // Clear multiple plots fields
                deed.application_other_areas = '';
                deed.application_total_area = '';
                deed.application_sell_area_other = '';
            } else if (deed.application_type === 'multiple') {
                // Clear specific plot fields
                deed.application_specific_area = '';
                deed.application_sell_area = '';
            }
            
            // Trigger validation after type change
            this.$nextTick(() => {
                this.validateApplicationAreaFields(deed);
            });
        },
        
        validateApplicationArea(deed) {
            if (!deed.application_type) {
                return { valid: false, message: 'অনুগ্রহ করে একটি বিকল্প নির্বাচন করুন' };
            }
            
            if (deed.application_type === 'specific') {
                if (!deed.application_specific_area || !deed.application_sell_area) {
                    return { valid: false, message: 'সুনির্দিষ্ট দাগের জন্য সকল তথ্য পূরণ করুন' };
                }
            } else if (deed.application_type === 'multiple') {
                if (!deed.application_other_areas || !deed.application_total_area || !deed.application_sell_area_other) {
                    return { valid: false, message: 'বিভিন্ন দাগের জন্য সকল তথ্য পূরণ করুন' };
                }
            }
            
            return { valid: true };
        },

        getApplicationAreaValidation(deed) {
            if (!deed.application_type) {
                return { hasError: true, message: 'অনুগ্রহ করে একটি বিকল্প নির্বাচন করুন' };
            }
            
            if (deed.application_type === 'specific') {
                if (!deed.application_specific_area || !deed.application_sell_area) {
                    return { hasError: true, message: 'সুনির্দিষ্ট দাগের জন্য সকল তথ্য পূরণ করুন' };
                }
            } else if (deed.application_type === 'multiple') {
                if (!deed.application_other_areas || !deed.application_total_area || !deed.application_sell_area_other) {
                    return { hasError: true, message: 'বিভিন্ন দাগের জন্য সকল তথ্য পূরণ করুন' };
                }
            }
            
            return { hasError: false, message: '' };
        },

        validateApplicationAreaFields(deed) {
            // Real-time validation feedback
            const validation = this.getApplicationAreaValidation(deed);
            if (validation.hasError) {
                // You can add additional real-time feedback here if needed
                console.log('Validation error:', validation.message);
            }
        },

        validateAllDeedTransfers() {
            const errors = [];
            this.deed_transfers.forEach((deed, index) => {
                const validation = this.getApplicationAreaValidation(deed);
                if (validation.hasError) {
                    errors.push(`দলিল #${index + 1}: ${validation.message}`);
                }
            });
            return errors;
        },
        
        scrollToForm(item) {
            // Scroll to the specific form based on item type and index
            setTimeout(() => {
                let selector = '';
                if (item.type === 'দলিল') {
                    selector = `[x-text="'দলিল #' + ${item.index + 1}"]`;
                } else if (item.type === 'ওয়ারিশ') {
                    selector = `[x-text="'ওয়ারিশ #' + ${item.index + 1}"]`;
                } else if (item.type === 'আরএস রেকর্ড') {
                    selector = `[x-text="'আরএস রেকর্ড #' + ${item.index + 1}"]`;
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
            // Validate all deed transfers before saving
            const validationErrors = this.validateAllDeedTransfers();
            if (validationErrors.length > 0) {
                this.showAlert('কিছু দলিলে আবেদনকৃত দাগের তথ্য অসম্পূর্ণ। অনুগ্রহ করে পূরণ করুন।', 'error');
                return;
            }
            
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
            // Validate all deed transfers before saving
            const validationErrors = this.validateAllDeedTransfers();
            if (validationErrors.length > 0) {
                this.showAlert('কিছু দলিলে আবেদনকৃত দাগের তথ্য অসম্পূর্ণ। অনুগ্রহ করে পূরণ করুন।', 'error');
                return;
            }
            
            // Save all data and complete the form
            const allData = {
                sa_info: this.sa_info,
                rs_info: this.rs_info,
                sa_owners: this.sa_owners,
                rs_owners: this.rs_owners,
                deed_transfers: this.deed_transfers,
                inheritance_records: this.inheritance_records,
                rs_records: this.rs_records,
                applicant_info: this.applicant_info,
                transferItems: this.transferItems
            };
            
            // You can implement AJAX call here to save to server
            
            // Show comprehensive summary alert
            this.showAlert('সব তথ্য সফলভাবে সংরক্ষিত হয়েছে! মালিকানার ধারাবাহিকতা সম্পূর্ণ হয়েছে।', 'success');
        },

        addRsRecordOwner(index) {
            this.rs_records[index].owner_names.push({ name: '' });
        },

        removeRsRecordOwner(index, ownerIdx) {
            if (this.rs_records[index].owner_names.length > 1) {
                this.rs_records[index].owner_names.splice(ownerIdx, 1);
            }
        },

        // Enhanced Progress Indicator Functions
        getStepClasses(step) {
            const stepOrder = ['info', 'transfers', 'applicant'];
            const currentIndex = stepOrder.indexOf(this.currentStep);
            const stepIndex = stepOrder.indexOf(step);
            
            if (this.currentStep === step) {
                return 'bg-blue-500 text-white shadow-lg ring-2 ring-blue-300';
            } else if (this.completedSteps.includes(step)) {
                return 'bg-green-500 text-white shadow-md';
            } else if (stepIndex <= currentIndex) {
                // Available steps (current and previous)
                return 'bg-gray-300 text-gray-600 hover:bg-gray-400 cursor-pointer';
            } else {
                // Future steps (locked)
                return 'bg-gray-200 text-gray-400 cursor-not-allowed';
            }
        },

        getProgressWidth() {
            const totalSteps = 3;
            const completedCount = this.completedSteps.length;
            
            if (completedCount === totalSteps) {
                return 100;
            } else if (completedCount === 0) {
                return 0; // No progress at the beginning
            } else if (completedCount === 1) {
                return 33; // First step completed
            } else if (completedCount === 2) {
                return 66; // Second step completed
            } else {
                return 100; // All steps
            }
        },

        getStepIndex(step) {
            const steps = ['info', 'transfers', 'applicant'];
            return steps.indexOf(step) + 1;
        },

        getCurrentStepText() {
            const stepTexts = {
                'info': 'রেকর্ডের বর্ণনা',
                'transfers': 'হস্তান্তর/রেকর্ড',
                'applicant': 'আবেদনকারী তথ্য'
            };
            return stepTexts[this.currentStep] || '';
        }
    }
}
</script> 