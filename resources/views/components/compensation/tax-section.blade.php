<div class="form-section">
    <h2 class="form-section-title">
        <span class="section-icon">৬</span>
        খাজনার তথ্য
    </h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="floating-label">
            <input type="text" name="tax_info[english_year]" value="{{ old('tax_info.english_year', isset($compensation) ? $compensation->tax_info['english_year'] ?? '' : '') }}" placeholder=" ">
            <label>ইংরেজি সাল পর্যন্ত পরিশোধিত</label>
        </div>
        <div class="floating-label">
            <input type="text" name="tax_info[bangla_year]" value="{{ old('tax_info.bangla_year', isset($compensation) ? $compensation->tax_info['bangla_year'] ?? '' : '') }}" placeholder=" ">
            <label>বাংলা সাল পর্যন্ত পরিশোধিত</label>
        </div>
    </div>
</div> 