# 🧪 Form Testing Guide - Number Input Validation

This guide provides comprehensive testing instructions for the updated compensation form with number inputs.

## 📊 Test Data Overview

The database has been seeded with **11 comprehensive test records** covering:

1. **Basic Land Case** (#1001) - Simple জমি award with standard values
2. **Land & Trees Case** (#1002) - জমি ও গাছপালা with multiple land categories  
3. **Infrastructure Case** (#1003) - অবকাঠামো award with RS basis
4. **Multiple Applicants** (#1004) - Multiple applicants and award holders
5. **Decimal Test Case** (#1005) - Complex decimal numbers (0.01 to 999.99)
6. **Additional Cases** (#1006-#1011) - Various edge cases and scenarios

## 🎯 Testing Checklist

### ✅ 1. Form Add Functionality

**Test Steps:**
1. Navigate to: `/compensation/create`
2. Fill out the form using number inputs
3. Verify number input behavior:

**Applicant Section:**
- [ ] **NID Field**: Should accept only numbers (13-17 digits)
- [ ] **Mobile Field**: Should accept 11 digits starting with 01
- [ ] Test with: `01712345678` (valid) vs `123456789` (invalid)

**Award Section:**
- [ ] **Source Tax %**: Should accept decimals (0-100)
- [ ] Test with: `5.50`, `12.34`, `0.01`, `15.00`
- [ ] **Land Category Fields**:
  - [ ] Total Land (acres): `2.50`, `0.01`, `123.45`
  - [ ] Total Compensation: `250000.00`, `1000.01`, `123456.78`
  - [ ] Applicant Land (acres): `2.50`, `0.01`, `67.89`
- [ ] **Tree Compensation**: `75000.50`, `12345.67`
- [ ] **Infrastructure Compensation**: `500000.00`

**Ownership Continuity Section:**
- [ ] **SA/RS Land Amounts**: `5.00`, `2.50`, `999.99`, `123.45`
- [ ] **Kharij Land Amount**: `2.50`, `67.89`

**Tax Section:**
- [ ] **Holding Number**: `1001`, `1005`
- [ ] **Paid Land Amount**: `2.50`, `67.89`
- [ ] **Years**: `2024`, `১৪৩১`

### ✅ 2. Form Edit Functionality

**Test Steps:**
1. Navigate to: `/compensation`
2. Click "Edit" on any existing record
3. Verify data loads correctly in number inputs:

**Test Cases:**
- [ ] **Case #1001**: Basic case with standard decimal values
- [ ] **Case #1005**: Decimal test case with complex numbers
- [ ] **Case #1002**: Land & trees with multiple categories

**Verification Points:**
- [ ] All number fields display existing values correctly
- [ ] Decimal values preserved (e.g., `5.50` not `5.5`)
- [ ] Mobile numbers show with proper format
- [ ] NID numbers display completely
- [ ] Form validation works on update

### ✅ 3. Preview Display Testing

**Test Steps:**
1. Navigate to: `/compensation`
2. Click "Preview" on various records
3. Verify number formatting in display:

**Check These Records:**
- [ ] **Case #1001**: Standard formatting
- [ ] **Case #1005**: Complex decimal display
- [ ] **Case #1002**: Multiple land categories
- [ ] **Case #1004**: Multiple applicants and award holders

**Verification Points:**
- [ ] All numeric values display correctly
- [ ] Decimal places preserved in display
- [ ] Currency amounts formatted properly
- [ ] Land measurements show with units
- [ ] Percentages display correctly
- [ ] **Multiple applicants clearly numbered** (আবেদনকারী #1, #2, etc.)
- [ ] **Multiple award holders clearly numbered** (মালিক #1, #2, etc.)

### ✅ 4. PDF Generation Testing

**Test Steps:**
1. Navigate to: `/compensation/{id}/pdf`
2. Test PDF generation for different cases:

**Test Cases:**
- [ ] **Case #1001**: Basic land case PDF
- [ ] **Case #1002**: Land & trees PDF with multiple categories
- [ ] **Case #1005**: Decimal numbers PDF
- [ ] **Case #1003**: Infrastructure PDF
- [ ] **Case #1004**: Multiple applicants/award holders PDF

**Verification Points:**
- [ ] All numbers render correctly in PDF
- [ ] Decimal formatting preserved
- [ ] Bengali numbers display properly
- [ ] No layout issues with number fields
- [ ] Currency symbols and units appear correctly
- [ ] **Multiple applicants clearly differentiated in PDF** (আবেদনকারী #1, #2)
- [ ] **Multiple award holders clearly differentiated in PDF** (মালিক #1, #2)
- [ ] **Proper spacing between multiple entries**

## 🔢 Multiple Applicants/Award Holders Differentiation

### What's New:
- **Notice PDF**: Clear numbering with "আবেদনকারী #1:", "মালিক #1:" etc.
- **Notice Preview**: Color-coded numbering (blue for applicants, green for award holders)
- **Regular Notice**: Proper heading for each person with numbers
- **List View**: Compact numbering in applicant names column

### Test Specifically:
- [ ] **Case #1004**: Has 2 applicants (সাইফুল ইসলাম, সালমা খাতুন)
- [ ] Check all views show clear differentiation
- [ ] Verify numbering starts from #1 and increments properly
- [ ] Ensure proper spacing between multiple entries

## 🔍 Specific Number Validation Tests

### Mobile Number Validation
```
✅ Valid: 01712345678, 01987654321, 01555666777
❌ Invalid: 1712345678, 017123456789, 02712345678
```

### NID Validation  
```
✅ Valid: 1234567890123, 9876543210987 (13+ digits)
❌ Invalid: 123456789 (too short), abc1234567890 (non-numeric)
```

### Decimal Land Amounts
```
✅ Valid: 0.01, 2.50, 123.45, 999.99
❌ Invalid: -1.00, abc, empty
```

### Percentage Values
```
✅ Valid: 0.50, 5.50, 12.34, 15.00
❌ Invalid: 101.00, -5.00, abc%
```

### Currency Amounts
```
✅ Valid: 1000.01, 250000.00, 123456.78
❌ Invalid: -1000, abc, 1,000 (with comma)
```

## 🚨 Error Scenarios to Test

1. **Empty Required Fields**: Try submitting with empty number fields
2. **Invalid Formats**: Enter text in number fields
3. **Out of Range**: Enter negative numbers where not allowed
4. **Decimal Precision**: Test very small (0.001) and large (999999.99) values

## 📱 Mobile/Responsive Testing

Test the form on different screen sizes:
- [ ] Desktop (number input spinners)
- [ ] Tablet (numeric keyboard)
- [ ] Mobile (tel keyboard for mobile field)

## 🎯 Success Criteria

- [ ] All number fields accept and store values correctly
- [ ] Decimal precision preserved throughout the system
- [ ] Form validation prevents invalid inputs
- [ ] Edit functionality loads and updates correctly
- [ ] Preview displays all numbers properly
- [ ] PDF generation includes all numeric data
- [ ] Mobile keyboards appear for appropriate fields
- [ ] No JavaScript errors in browser console

## 🔧 Troubleshooting

**If numbers don't save correctly:**
1. Check browser console for validation errors
2. Verify database column types support decimals
3. Check Laravel validation rules

**If decimal places are lost:**
1. Ensure `step="0.01"` attribute is present
2. Check database precision settings
3. Verify model casting configuration

**If mobile keyboard doesn't appear:**
1. Confirm `type="tel"` for mobile fields
2. Test on actual mobile device
3. Check CSS doesn't interfere

---

## 📋 Quick Test Commands

```bash
# Check seeded data
php artisan tinker --execute="echo App\Models\Compensation::count() . ' records created';"

# View specific test case
php artisan tinker --execute="\$case = App\Models\Compensation::find(5); echo json_encode(\$case->land_category, JSON_PRETTY_PRINT);"

# Reset test data if needed
php artisan db:seed --class=CompensationSeeder
```

---

**✨ Happy Testing!** 🚀
