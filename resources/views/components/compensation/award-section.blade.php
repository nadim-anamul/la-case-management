<div class="form-section">
    <h2 class="form-section-title">
        <span class="section-icon">২</span>
        রোয়েদাদের তথ্যঃ
    </h2>
    
    <!-- Conditional Fields Note -->
    <div class="mb-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
        <p class="text-sm text-yellow-800">
            <span class="font-semibold">দ্রষ্টব্য:</span> SA নির্বাচন করলে SA দাগ নং এবং SA খতিয়ান নং প্রয়োজন। 
            RS নির্বাচন করলে RS দাগ নং এবং RS খতিয়ান নং প্রয়োজন।
        </p>
    </div>
    
    <div x-data="{ 
        award_type: '{{ old('award_type', isset($compensation) ? (is_array($compensation->award_type) ? $compensation->award_type[0] ?? '' : $compensation->award_type) : '') }}',
        acquisition_record_basis: '{{ old('acquisition_record_basis', isset($compensation) ? $compensation->acquisition_record_basis : '') }}'
    }" class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="floating-label">
            <input type="text" name="la_case_no" value="{{ old('la_case_no', isset($compensation) ? $compensation->la_case_no : '') }}" placeholder=" " required>
            <label>এলএ কেস নং<span class="text-red-500">*</span></label>
        </div>
        <div>
            <label>রোয়েদাদের ধরন<span class="text-red-500">*</span></label>
            <div class="radio-group">
                <label><input type="radio" name="award_type" value="জমি" x-model="award_type" class="mr-2" required 
                    {{ (old('award_type', isset($compensation) ? (is_array($compensation->award_type) ? $compensation->award_type[0] ?? '' : $compensation->award_type) : '')) == 'জমি' ? 'checked' : '' }}><span>জমি</span></label>
                <label><input type="radio" name="award_type" value="জমি ও গাছপালা" x-model="award_type" class="mr-2" required 
                    {{ (old('award_type', isset($compensation) ? (is_array($compensation->award_type) ? $compensation->award_type[0] ?? '' : $compensation->award_type) : '')) == 'জমি ও গাছপালা' ? 'checked' : '' }}><span>জমি ও গাছপালা</span></label>
                <label><input type="radio" name="award_type" value="অবকাঠামো" x-model="award_type" class="mr-2" required 
                    {{ (old('award_type', isset($compensation) ? (is_array($compensation->award_type) ? $compensation->award_type[0] ?? '' : $compensation->award_type) : '')) == 'অবকাঠামো' ? 'checked' : '' }}><span>অবকাঠামো</span></label>
            </div>
        </div>
        <div class="floating-label">
            <input type="text" name="award_serial_no" value="{{ old('award_serial_no', isset($compensation) ? $compensation->award_serial_no : '') }}" placeholder=" " required>
            <label>রোয়েদাদের ক্রমিক নং<span class="text-red-500">*</span></label>
        </div>
        <div class="floating-label">
            <select name="acquisition_record_basis" id="acquisition_record_basis" x-model="acquisition_record_basis" class="form-input" required aria-required="true">
                <option value="">-- নির্বাচন করুন --</option>
                <option value="SA">SA</option>
                <option value="RS">RS</option>
            </select>
            <label for="acquisition_record_basis">যে রেকর্ড মূলে অধিগ্রহণ<span class="text-red-500">*</span></label>
            @error('acquisition_record_basis')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div class="floating-label">
            <input type="text" name="plot_no" value="{{ old('plot_no', isset($compensation) ? $compensation->plot_no : '') }}" placeholder=" " required>
                                    <label>খতিয়ান নং<span class="text-red-500">*</span></label>
        </div>
        <template x-if="acquisition_record_basis === 'SA'">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:col-span-2">
                <div class="floating-label">
                    <input type="text" name="sa_plot_no" id="sa_plot_no" value="{{ old('sa_plot_no', isset($compensation) ? $compensation->sa_plot_no : '') }}" placeholder=" " required>
                    <label for="sa_plot_no">SA দাগ নং<span class="text-red-500">*</span></label>
                    @if(old('acquisition_record_basis', isset($compensation) ? $compensation->acquisition_record_basis : '') == 'SA')
                        @error('sa_plot_no')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    @endif
                </div>
                <div class="floating-label">
                    <input type="text" name="rs_plot_no" id="rs_plot_no_sa" value="{{ old('rs_plot_no', isset($compensation) ? $compensation->rs_plot_no : '') }}" placeholder=" ">
                    <label for="rs_plot_no_sa">RS দাগ নং</label>
                    @if(old('acquisition_record_basis', isset($compensation) ? $compensation->acquisition_record_basis : '') == 'SA')
                        @error('rs_plot_no')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    @endif
                </div>
            </div>
        </template>
        <template x-if="acquisition_record_basis === 'RS'">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:col-span-2">
                <div class="floating-label">
                    <input type="text" name="rs_plot_no" id="rs_plot_no_rs" value="{{ old('rs_plot_no', isset($compensation) ? $compensation->rs_plot_no : '') }}" placeholder=" " required>
                    <label for="rs_plot_no_rs">RS দাগ নং<span class="text-red-500">*</span></label>
                    @if(old('acquisition_record_basis', isset($compensation) ? $compensation->acquisition_record_basis : '') == 'RS')
                        @error('rs_plot_no')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    @endif
                </div>
            </div>
        </template>
        <!-- Award Holder Names Section -->
        <div class="md:col-span-2">
            <div class="sub-section">
                <h4 class="text-lg font-semibold mb-4">রোয়েদাদভুক্ত মালিকের নাম<span class="text-red-500">*</span></h4>
                <div x-data="{ award_holder_names: {{ old('award_holder_names', isset($compensation) ? json_encode($compensation->award_holder_names ?? [['name' => '']]) : '[{\"name\": \"\"}]') }} }">
                    <template x-for="(holder, index) in award_holder_names" :key="index">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="flex-1">
                                <input type="text" 
                                       :name="'award_holder_names[' + index + '][name]'" 
                                       x-model="holder.name" 
                                       placeholder="মালিকের নাম" 
                                       class="form-input w-full" 
                                       required>
                            </div>
                            <button type="button" 
                                    @click="award_holder_names.splice(index, 1)" 
                                    class="btn-danger"
                                    x-show="award_holder_names.length > 1">
                                ×
                            </button>
                        </div>
                    </template>
                    <button type="button" 
                            @click="award_holder_names.push({name: ''})" 
                            class="btn-success">
                        + মালিকের নাম যোগ করুন
                    </button>
                </div>
            </div>
        </div>
        <div class="floating-label md:col-span-2">
            <textarea name="objector_details" rows="3" placeholder=" ">{{ old('objector_details', isset($compensation) ? $compensation->objector_details : '') }}</textarea>
            <label>রোয়েদাদে কোন আপত্তি অন্তর্ভুক্ত থাকলে আপত্তিকারীর নাম ও ঠিকানা</label>
        </div>
        <div>
            <label>আবেদনকারীর নাম রোয়েদাদে আছে কিনা?<span class="text-red-500">*</span></label>
            <div class="radio-group">
                <label><input type="radio" name="is_applicant_in_award" value="1" {{ (old('is_applicant_in_award', isset($compensation) ? $compensation->is_applicant_in_award : '')) == '1' ? 'checked' : '' }} class="mr-2"><span>হ্যাঁ</span></label>
                <label><input type="radio" name="is_applicant_in_award" value="0" {{ (old('is_applicant_in_award', isset($compensation) ? $compensation->is_applicant_in_award : '')) == '0' ? 'checked' : '' }} class="mr-2"><span>না</span></label>
            </div>
        </div>
        <div class="floating-label">
            <input type="text" name="total_acquired_land" value="{{ old('total_acquired_land', isset($compensation) ? $compensation->total_acquired_land : '') }}" placeholder=" " required>
            <label>অধিগ্রহণকৃত মোট জমির পরিমাণ<span class="text-red-500">*</span></label>
        </div>
        <div class="floating-label">
            <input type="text" name="total_compensation" value="{{ old('total_compensation', isset($compensation) ? $compensation->total_compensation : '') }}" placeholder=" " required>
            <label>অধিগ্রহণকৃত জমির মোট ক্ষতিপূরণ<span class="text-red-500">*</span></label>
        </div>
        <div class="floating-label">
            <input type="text" name="source_tax_percentage" value="{{ old('source_tax_percentage', isset($compensation) ? $compensation->source_tax_percentage : '') }}" placeholder=" " required>
            <label>উৎস কর %<span class="text-red-500">*</span></label>
        </div>
        <!-- Conditional Fields based on Award Type -->
        <template x-if="award_type === 'জমি ও গাছপালা'">
            <div class="floating-label">
                <input type="text" name="tree_compensation" value="{{ old('tree_compensation', isset($compensation) ? $compensation->tree_compensation : '') }}" placeholder=" " required>
                <label>গাছপালার মোট ক্ষতিপূরণ<span class="text-red-500">*</span></label>
            </div>
        </template>
        <template x-if="award_type === 'অবকাঠামো'">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:col-span-2">
                <div class="floating-label">
                    <input type="text" name="infrastructure_compensation" value="{{ old('infrastructure_compensation', isset($compensation) ? $compensation->infrastructure_compensation : '') }}" placeholder=" " required>
                    <label>অবকাঠামোর মোট ক্ষতিপূরণ<span class="text-red-500">*</span></label>
                </div>
                <div class="floating-label">
                    <input type="text" name="infrastructure_source_tax_percentage" value="{{ old('infrastructure_source_tax_percentage', isset($compensation) ? $compensation->infrastructure_source_tax_percentage : '') }}" placeholder=" " required>
                    <label>উৎস কর %<span class="text-red-500">*</span></label>
                </div>
            </div>
        </template>
        <!-- Land-related fields - only show if NOT infrastructure -->
        <template x-if="award_type !== 'অবকাঠামো'">
            <div class="floating-label">
                <input type="text" name="applicant_acquired_land" value="{{ old('applicant_acquired_land', isset($compensation) ? $compensation->applicant_acquired_land : '') }}" placeholder=" " required>
                <label>আবেদনকারীর অধিগ্রহণকৃত জমির পরিমাণ<span class="text-red-500">*</span></label>
            </div>
        </template>
    </div>
</div> 