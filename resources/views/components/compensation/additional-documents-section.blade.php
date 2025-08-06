<div class="form-section">
    <h2 class="form-section-title">
        <span class="section-icon">৭</span>
        বণ্টন / না-দাবি / আপসনামা / এফিডেভিটের তথ্য
    </h2>
    <div class="sub-section">
        <h3 class="font-bold mb-4">দাখিলকৃত ডকুমেন্টের ধরন:<span class="text-blue-500">*</span></h3>
        <div class="checkbox-group">
            <label><input type="checkbox" name="additional_documents_info[selected_types][]" value="আপস- বন্টননামা" x-model="selected_doc_types" class="mr-2"><span>আপস- বন্টননামা</span></label>
            <label><input type="checkbox" name="additional_documents_info[selected_types][]" value="না-দাবি" x-model="selected_doc_types" class="mr-2"><span>না-দাবি</span></label>
            <label><input type="checkbox" name="additional_documents_info[selected_types][]" value="সরেজমিন তদন্ত" x-model="selected_doc_types" class="mr-2"><span>সরেজমিন তদন্ত</span></label>
            <label><input type="checkbox" name="additional_documents_info[selected_types][]" value="এফিডেভিট" x-model="selected_doc_types" class="mr-2"><span>এফিডেভিট</span></label>
        </div>
        <template x-for="type in selected_doc_types" :key="type">
            <div class="floating-label mt-4">
                <textarea :name="'additional_documents_info[details][' + type + ']'"
                    " :id="'additional_documents_details_' + type"
                    rows="3" x-model="additional_documents_details[type]" placeholder=" "
                    :required="selected_doc_types.includes(type)"></textarea>
                <label :for="'additional_documents_details_' + type"><span x-text="type"></span><span class="text-red-500">*</span></label>
                @error('additional_documents_info.details.*')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </template>
    </div>
</div> 