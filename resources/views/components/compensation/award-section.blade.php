<div class="form-section">
    <h2 class="form-section-title">
        <span class="section-icon">২</span>
        রোয়েদাদের তথ্যঃ
    </h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="floating-label">
            <input type="text" name="la_case_no" value="{{ old('la_case_no', isset($compensation) ? $compensation->la_case_no : '') }}" placeholder=" ">
            <label>এলএ কেস নং</label>
        </div>
        <div>
            <label>রোয়েদাদের ধরন</label>
            <div class="checkbox-group">
                <label><input type="checkbox" name="award_type[]" value="জমি/অবকাঠামো" {{ (old('award_type', isset($compensation) ? $compensation->award_type : [])) && in_array('জমি/অবকাঠামো', old('award_type', isset($compensation) ? $compensation->award_type : [])) ? 'checked' : '' }} class="mr-2"><span>জমি/অবকাঠামো</span></label>
                <label><input type="checkbox" name="award_type[]" value="জমি/গাছপালা" {{ (old('award_type', isset($compensation) ? $compensation->award_type : [])) && in_array('জমি/গাছপালা', old('award_type', isset($compensation) ? $compensation->award_type : [])) ? 'checked' : '' }} class="mr-2"><span>জমি/গাছপালা</span></label>
            </div>
        </div>
        <div class="floating-label">
            <input type="text" name="award_serial_no" value="{{ old('award_serial_no', isset($compensation) ? $compensation->award_serial_no : '') }}" placeholder=" ">
            <label>রোয়েদাদের ক্রমিক নং</label>
        </div>
        <div class="floating-label">
            <input type="text" name="acquisition_record_basis" value="{{ old('acquisition_record_basis', isset($compensation) ? $compensation->acquisition_record_basis : '') }}" placeholder=" ">
            <label>যে রেকর্ড মূলে অধিগ্রহণ</label>
        </div>
        <div class="floating-label">
            <input type="text" name="plot_no" value="{{ old('plot_no', isset($compensation) ? $compensation->plot_no : '') }}" placeholder=" ">
            <label>দাগ নং</label>
        </div>
        <div class="floating-label">
            <input type="text" name="award_holder_name" value="{{ old('award_holder_name', isset($compensation) ? $compensation->award_holder_name : '') }}" placeholder=" ">
            <label>রোয়েদাদভুক্ত মালিকের নাম</label>
        </div>
        <div class="floating-label md:col-span-2">
            <textarea name="objector_details" rows="3" placeholder=" ">{{ old('objector_details', isset($compensation) ? $compensation->objector_details : '') }}</textarea>
            <label>রোয়েদাদে কোন আপত্তি অন্তর্ভুক্ত থাকলে আপত্তিকারীর নাম ও ঠিকানা</label>
        </div>
        <div>
            <label>আবেদনকারীর নাম রোয়েদাদে আছে কিনা?</label>
            <div class="radio-group">
                <label><input type="radio" name="is_applicant_in_award" value="1" {{ (old('is_applicant_in_award', isset($compensation) ? $compensation->is_applicant_in_award : '')) == '1' ? 'checked' : '' }} class="mr-2"><span>হ্যাঁ</span></label>
                <label><input type="radio" name="is_applicant_in_award" value="0" {{ (old('is_applicant_in_award', isset($compensation) ? $compensation->is_applicant_in_award : '')) == '0' ? 'checked' : '' }} class="mr-2"><span>না</span></label>
            </div>
        </div>
        <div class="floating-label">
            <input type="text" name="total_acquired_land" value="{{ old('total_acquired_land', isset($compensation) ? $compensation->total_acquired_land : '') }}" placeholder=" ">
            <label>অধিগ্রহণকৃত মোট জমির পরিমাণ</label>
        </div>
        <div class="floating-label">
            <input type="text" name="total_compensation" value="{{ old('total_compensation', isset($compensation) ? $compensation->total_compensation : '') }}" placeholder=" ">
            <label>অধিগ্রহণকৃত জমির মোট ক্ষতিপূরণ (উৎস কর সহ)</label>
        </div>
        <div class="floating-label">
            <input type="text" name="applicant_acquired_land" value="{{ old('applicant_acquired_land', isset($compensation) ? $compensation->applicant_acquired_land : '') }}" placeholder=" ">
            <label>আবেদনকারীর অধিগ্রহণকৃত জমির পরিমাণ</label>
        </div>
    </div>
</div> 