<div class="form-section">
    <h2 class="form-section-title">
        কানুনগো/সার্ভেয়ারের মতামতঃ
    </h2>
    <div class="space-y-6">
        <div>
            <label>মালিকানার ধারাবাহিকতা আছে কিনা<span class="text-red-500">*</span></label>
            <div class="radio-group">
                <label><input type="radio" name="kanungo_opinion[has_ownership_continuity]" value="yes" {{ (old('kanungo_opinion.has_ownership_continuity', isset($compensation) ? $compensation->kanungo_opinion['has_ownership_continuity'] ?? '' : '') == 'yes') ? 'checked' : '' }} class="mr-2"><span>হ্যাঁ</span></label>
                <label><input type="radio" name="kanungo_opinion[has_ownership_continuity]" value="no" {{ (old('kanungo_opinion.has_ownership_continuity', isset($compensation) ? $compensation->kanungo_opinion['has_ownership_continuity'] ?? '' : '') == 'no') ? 'checked' : '' }} class="mr-2"><span>না</span></label>
            </div>
        </div>
        
        <div class="floating-label">
            <textarea name="kanungo_opinion[opinion_details]" rows="6" placeholder=" ">{{ old('kanungo_opinion.opinion_details', isset($compensation) ? $compensation->kanungo_opinion['opinion_details'] ?? '' : '') }}</textarea>
            <label>মতামতঃ</label>
        </div>
    </div>
</div> 