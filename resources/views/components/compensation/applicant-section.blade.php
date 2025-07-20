<div class="form-section">
    <h2 class="form-section-title">
        <span class="section-icon">১</span>
        আবেদনকারীর তথ্যঃ
    </h2>
    <template x-for="(applicant, index) in applicants" :key="index">
        <div class="record-card">
            <h3 x-text="'আবেদনকারী #' + (index + 1)"></h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="floating-label">
                    <input type="text" :name="'applicants[' + index + '][name]'" x-model="applicant.name" placeholder=" " required>
                    <label>নাম</label>
                </div>
                <div class="floating-label">
                    <input type="text" :name="'applicants[' + index + '][father_name]'" x-model="applicant.father_name" placeholder=" " required>
                    <label>পিতার নাম</label>
                </div>
                <div class="floating-label md:col-span-2">
                    <input type="text" :name="'applicants[' + index + '][address]'" x-model="applicant.address" placeholder=" " required>
                    <label>ঠিকানা</label>
                </div>
                <div class="floating-label">
                    <input type="text" :name="'applicants[' + index + '][nid]'" x-model="applicant.nid" placeholder=" " required>
                    <label>এন আই ডি</label>
                </div>
            </div>
            <button
                type="button"
                @click="removeApplicant(index)"
                x-show="applicants.length > 1 && index !== 0"
                class="btn-danger absolute top-4 right-4"
                title="আবেদনকারী মুছুন"
            >×</button>
        </div>
    </template>
    <div class="flex items-center space-x-4">
        <button type="button" @click="addApplicant()" class="btn-success">
            + আবেদনকারী যোগ করুন
        </button>
        <span class="text-gray-600 text-sm">কমপক্ষে একজন আবেদনকারীর তথ্য প্রয়োজন</span>
    </div>
</div> 