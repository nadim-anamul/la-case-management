<div class="form-section">
    <h2 class="form-section-title">
        <span class="section-icon">৩</span>
        আবেদনকৃত জমির তফসিলঃ
    </h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-4 xs:gap-2">
        <div class="floating-label">
            <input type="text" name="mouza_name" value="{{ old('mouza_name', isset($compensation) ? $compensation->mouza_name : '') }}" placeholder=" " required>
            <label>মৌজার নাম<span class="text-red-500">*</span></label>
        </div>
        <div class="floating-label">
            <input type="text" name="jl_no" value="{{ old('jl_no', isset($compensation) ? $compensation->jl_no : '') }}" placeholder=" " required>
            <label>জেএল নং<span class="text-red-500">*</span></label>
        </div>
        <div class="floating-label">
            <input type="text" name="sa_khatian_no" value="{{ old('sa_khatian_no', isset($compensation) ? $compensation->sa_khatian_no : '') }}" placeholder=" ">
            <label>এসএ খতিয়ান নং</label>
        </div>
        <div class="floating-label">
            <input type="text" name="land_schedule_sa_plot_no" value="{{ old('land_schedule_sa_plot_no', isset($compensation) ? $compensation->land_schedule_sa_plot_no : '') }}" placeholder=" " :required="acquisition_record_basis === 'SA'">
            <label>SA দাগ নং<span class="text-red-500" x-show="acquisition_record_basis === 'SA'">*</span></label>
        </div>
        <div class="floating-label">
            <input type="text" name="rs_khatian_no" value="{{ old('rs_khatian_no', isset($compensation) ? $compensation->rs_khatian_no : '') }}" placeholder=" ">
            <label>আর এস খতিয়ান নং</label>
        </div>
        <div class="floating-label">
            <input type="text" name="land_schedule_rs_plot_no" value="{{ old('land_schedule_rs_plot_no', isset($compensation) ? $compensation->land_schedule_rs_plot_no : '') }}" placeholder=" " :required="acquisition_record_basis === 'RS'">
            <label>RS দাগ নং<span class="text-red-500" x-show="acquisition_record_basis === 'RS'">*</span></label>
        </div>
    </div>
    <style>
    @media (max-width: 1024px) {
        .form-section { padding: 1rem !important; }
    }
    @media (max-width: 768px) {
        .form-section { padding: 0.75rem !important; }
        .form-section-title { font-size: 1.1rem; }
        .grid { grid-template-columns: 1fr !important; }
    }
    @media (max-width: 480px) {
        .form-section { padding: 0.5rem !important; }
        .form-section-title { font-size: 1rem; }
    }
    </style>
</div> 