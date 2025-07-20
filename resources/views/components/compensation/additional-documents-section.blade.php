<div class="form-section">
    <h2 class="form-section-title">
        <span class="section-icon">৭</span>
        বণ্টন / না-দাবি / আপসনামা / সরেজমিন তদন্তের তথ্য
    </h2>
    
    <!-- Distribution Records -->
    <div class="sub-section">
        <h3 class="font-bold mb-4">বণ্টন:</h3>
        <template x-for="(distribution, index) in distribution_records" :key="index">
            <div class="record-card">
                <div class="floating-label">
                    <textarea :name="'additional_documents_info[distribution_records][' + index + '][details]'" rows="3" x-model="distribution.details" placeholder=" "></textarea>
                    <label>বণ্টনের বিবরণ</label>
                </div>
                <button
                    type="button"
                    @click="removeDistributionRecord(index)"
                    x-show="distribution_records.length > 1"
                    class="btn-danger absolute top-4 right-4"
                    title="বণ্টন মুছুন"
                >×</button>
            </div>
        </template>
        <button type="button" @click="addDistributionRecord()" class="btn-success">
            + বণ্টন যোগ করুন
        </button>
    </div>

    <!-- No Claim Type -->
    <div class="sub-section">
        <h3 class="font-bold mb-4">না দাবি:</h3>
        <div>
            <label>না দাবির ধরন</label>
            <div class="radio-group">
                <label><input type="radio" name="additional_documents_info[no_claim_type]" value="donor" x-model="no_claim_type" {{ (old('additional_documents_info.no_claim_type', isset($compensation) ? $compensation->additional_documents_info['no_claim_type'] ?? '' : '')) == 'donor' ? 'checked' : '' }} class="mr-2"><span>দাতা</span></label>
                <label><input type="radio" name="additional_documents_info[no_claim_type]" value="recipient" x-model="no_claim_type" {{ (old('additional_documents_info.no_claim_type', isset($compensation) ? $compensation->additional_documents_info['no_claim_type'] ?? '' : '')) == 'recipient' ? 'checked' : '' }} class="mr-2"><span>গ্রহীতা</span></label>
            </div>
        </div>
    </div>

    <!-- Field Investigation -->
    <div class="sub-section">
        <h3 class="font-bold mb-4">সরেজমিন তদন্ত:</h3>
        <div class="floating-label">
            <textarea name="additional_documents_info[field_investigation_info]" rows="4" x-model="field_investigation_info" placeholder=" ">{{ old('additional_documents_info.field_investigation_info', isset($compensation) ? $compensation->additional_documents_info['field_investigation_info'] ?? '' : '') }}</textarea>
            <label>সরেজমিন তদন্তের তথ্য</label>
        </div>
    </div>

    <!-- Submitted Documents -->
    <div class="sub-section">
        <h3 class="font-bold mb-4">দাখিলকৃত ডকুমেন্টের ধরন:</h3>
        <div class="checkbox-group">
            <label><input type="checkbox" name="additional_documents_info[submitted_docs][]" value="বণ্টন" {{ (old('additional_documents_info.submitted_docs', isset($compensation) ? $compensation->additional_documents_info['submitted_docs'] ?? [] : [])) && in_array('বণ্টন', old('additional_documents_info.submitted_docs', isset($compensation) ? $compensation->additional_documents_info['submitted_docs'] ?? [] : [])) ? 'checked' : '' }} class="mr-2"><span>বণ্টন</span></label>
            <label><input type="checkbox" name="additional_documents_info[submitted_docs][]" value="না দাবি" {{ (old('additional_documents_info.submitted_docs', isset($compensation) ? $compensation->additional_documents_info['submitted_docs'] ?? [] : [])) && in_array('না দাবি', old('additional_documents_info.submitted_docs', isset($compensation) ? $compensation->additional_documents_info['submitted_docs'] ?? [] : [])) ? 'checked' : '' }} class="mr-2"><span>না দাবি</span></label>
            <label><input type="checkbox" name="additional_documents_info[submitted_docs][]" value="দাতা" {{ (old('additional_documents_info.submitted_docs', isset($compensation) ? $compensation->additional_documents_info['submitted_docs'] ?? [] : [])) && in_array('দাতা', old('additional_documents_info.submitted_docs', isset($compensation) ? $compensation->additional_documents_info['submitted_docs'] ?? [] : [])) ? 'checked' : '' }} class="mr-2"><span>দাতা</span></label>
            <label><input type="checkbox" name="additional_documents_info[submitted_docs][]" value="গ্রহীতা" {{ (old('additional_documents_info.submitted_docs', isset($compensation) ? $compensation->additional_documents_info['submitted_docs'] ?? [] : [])) && in_array('গ্রহীতা', old('additional_documents_info.submitted_docs', isset($compensation) ? $compensation->additional_documents_info['submitted_docs'] ?? [] : [])) ? 'checked' : '' }} class="mr-2"><span>গ্রহীতা</span></label>
            <label><input type="checkbox" name="additional_documents_info[submitted_docs][]" value="সরেজমিন তদন্ত" {{ (old('additional_documents_info.submitted_docs', isset($compensation) ? $compensation->additional_documents_info['submitted_docs'] ?? [] : [])) && in_array('সরেজমিন তদন্ত', old('additional_documents_info.submitted_docs', isset($compensation) ? $compensation->additional_documents_info['submitted_docs'] ?? [] : [])) ? 'checked' : '' }} class="mr-2"><span>সরেজমিন তদন্ত</span></label>
        </div>
    </div>
</div> 