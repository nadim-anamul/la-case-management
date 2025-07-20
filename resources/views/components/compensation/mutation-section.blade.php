<div class="form-section">
    <h2 class="form-section-title">
        <span class="section-icon">৫</span>
        খারিজের তথ্য
    </h2>
    <template x-for="(mutation, index) in mutation_records" :key="index">
        <div class="record-card">
            <h3 x-text="'খারিজ #' + (index + 1)"></h3>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="floating-label">
                    <input type="text" :name="'mutation_info[records][' + index + '][khatian_no]'" x-model="mutation.khatian_no" placeholder=" ">
                    <label>খারিজ খতিয়ান নম্বর</label>
                </div>
                <div class="floating-label">
                    <input type="text" :name="'mutation_info[records][' + index + '][case_no]'" x-model="mutation.case_no" placeholder=" ">
                    <label>কেস নম্বর</label>
                </div>
                <div class="floating-label">
                    <input type="text" :name="'mutation_info[records][' + index + '][plot_no]'" x-model="mutation.plot_no" placeholder=" ">
                    <label>দাগ</label>
                </div>
                <div class="floating-label">
                    <input type="text" :name="'mutation_info[records][' + index + '][land_amount]'" x-model="mutation.land_amount" placeholder=" ">
                    <label>পরিমাণ</label>
                </div>
            </div>
            <button
                type="button"
                @click="removeMutationRecord(index)"
                x-show="mutation_records.length > 1"
                class="btn-danger absolute top-4 right-4"
                title="খারিজ মুছুন"
            >×</button>
        </div>
    </template>
    <button type="button" @click="addMutationRecord()" class="btn-success">
        + খারিজ যোগ করুন
    </button>
</div> 