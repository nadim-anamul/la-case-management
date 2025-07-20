<div class="form-section">
    <h2 class="form-section-title">
        <span class="section-icon">৬</span>
        খাজনার তথ্য
    </h2>
    <div class="floating-label">
        <input type="text" name="tax_info[paid_until]" value="{{ old('tax_info.paid_until', isset($compensation) ? $compensation->tax_info['paid_until'] ?? '' : '') }}" placeholder=" ">
        <label>কত সাল পর্যন্ত পরিশোধিত</label>
    </div>
</div> 