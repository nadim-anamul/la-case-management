<div class="form-section">
    <h2 class="form-section-title">
        <span class="section-icon">৮</span>
        কানুনগো/সার্ভেয়ারের মতামতঃ
    </h2>
    <div class="space-y-6">
        <div>
            <label>মালিকানার ধারাবাহিকতা আছে কিনা</label>
            <div class="radio-group">
                <label><input type="radio" name="kanungo_opinion[ownership_continuity]" value="yes" {{ (old('kanungo_opinion.ownership_continuity', isset($compensation) ? $compensation->kanungo_opinion['ownership_continuity'] ?? '' : '') == 'yes') ? 'checked' : '' }} class="mr-2"><span>হ্যাঁ</span></label>
                <label><input type="radio" name="kanungo_opinion[ownership_continuity]" value="no" {{ (old('kanungo_opinion.ownership_continuity', isset($compensation) ? $compensation->kanungo_opinion['ownership_continuity'] ?? '' : '') == 'no') ? 'checked' : '' }} class="mr-2"><span>না</span></label>
            </div>
        </div>
        
        <div>
            <label>কোন কাগজের ঘাটতি আছে কিনা</label>
            <div class="radio-group">
                <label><input type="radio" name="kanungo_opinion[document_deficiency]" value="yes" {{ (old('kanungo_opinion.document_deficiency', isset($compensation) ? $compensation->kanungo_opinion['document_deficiency'] ?? '' : '') == 'yes') ? 'checked' : '' }} class="mr-2"><span>হ্যাঁ</span></label>
                <label><input type="radio" name="kanungo_opinion[document_deficiency]" value="no" {{ (old('kanungo_opinion.document_deficiency', isset($compensation) ? $compensation->kanungo_opinion['document_deficiency'] ?? '' : '') == 'no') ? 'checked' : '' }} class="mr-2"><span>না</span></label>
            </div>
        </div>
        
        <div class="floating-label">
            <textarea name="kanungo_opinion[opinion_details]" rows="6" placeholder=" ">{{ old('kanungo_opinion.opinion_details', isset($compensation) ? $compensation->kanungo_opinion['opinion_details'] ?? '' : '') }}</textarea>
            <label>মতামতঃ ক্ষতিপূরণ প্রদান করা যেতে পারে/ কাগজ দাখিল সাপেক্ষে ক্ষতিপূরণ প্রদান করা যেতে পারে- কি কি কাগজ/ মিস কেস সৃজন করা যেতে পারে- কারণ</label>
        </div>
        
        <div class="floating-label">
            <textarea name="kanungo_opinion[special_comments]" rows="4" placeholder=" ">{{ old('kanungo_opinion.special_comments', isset($compensation) ? $compensation->kanungo_opinion['special_comments'] ?? '' : '') }}</textarea>
            <label>বিশেষ মন্তব্য</label>
        </div>
    </div>
</div> 