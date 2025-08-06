# Ownership Continuity Section - Application Area Validation

## Overview

The Application Area Section in the Ownership Continuity component now includes comprehensive validation to ensure that when either "সুনির্দিষ্ট দাগ" (Specific Plot) or "বিভিন্ন দাগ" (Multiple Plots) is selected, the corresponding data entry fields become mandatory.

## Features

### 1. Visual Indicators
- **Required Field Markers**: Red asterisks (*) indicate mandatory fields
- **Real-time Validation**: Input fields show red borders when validation fails
- **Error Messages**: Clear Bengali error messages appear below the form section

### 2. Validation Rules

#### For "সুনির্দিষ্ট দাগ" (Specific Plot):
- `application_specific_area` - আবেদনকৃত দাগ (Required)
- `application_sell_area` - বিক্রয়কৃত একর (Required)

#### For "বিভিন্ন দাগ" (Multiple Plots):
- `application_other_areas` - বিভিন্ন দাগ (Required)
- `application_total_area` - মোট একর (Required)
- `application_sell_area_other` - বিক্রয়কৃত একর (Required)

### 3. Form Edit Support
- Existing data is properly loaded when editing forms
- Application type selection is preserved
- All corresponding fields are populated correctly
- Validation state is maintained

### 4. Validation Functions

#### `getApplicationAreaValidation(deed)`
Returns validation status with error messages in Bengali.

#### `validateApplicationAreaFields(deed)`
Provides real-time validation feedback during user input.

#### `validateAllDeedTransfers()`
Validates all deed transfers before form submission.

### 5. Integration Points

#### Before Step Navigation:
- Validates all deed transfers before proceeding to the applicant step
- Shows error alert if validation fails

#### Before Data Saving:
- Validates all deed transfers before saving step data
- Validates all deed transfers before saving all data
- Prevents form submission if validation fails

## Usage

### Frontend Validation
```javascript
// Real-time validation on input
@input="validateApplicationAreaFields(deed)"

// Visual feedback with CSS classes
:class="{'border-red-500': deed.application_type === 'specific' && !deed.application_specific_area}"
```

### Backend Integration
The validation data is properly structured for backend processing:

```php
'ownership_details' => [
    'deed_transfers' => [
        [
            'application_type' => 'specific', // or 'multiple'
            'application_specific_area' => 'PLOT-123',
            'application_sell_area' => '1.50',
            // ... other fields
        ]
    ]
]
```

## Testing

Two new test methods have been added to `OwnershipContinuityFlowTest`:

1. `test_application_area_validation_with_specific_plot()` - Tests specific plot validation
2. `test_application_area_validation_with_multiple_plots()` - Tests multiple plots validation

These tests verify that:
- Application area data is properly saved
- Validation rules are enforced
- Form edit functionality works correctly

## Error Messages

All error messages are in Bengali:

- **No selection**: "অনুগ্রহ করে একটি বিকল্প নির্বাচন করুন"
- **Specific plot incomplete**: "সুনির্দিষ্ট দাগের জন্য সকল তথ্য পূরণ করুন"
- **Multiple plots incomplete**: "বিভিন্ন দাগের জন্য সকল তথ্য পূরণ করুন"
- **Form submission blocked**: "কিছু দলিলে আবেদনকৃত দাগের তথ্য অসম্পূর্ণ। অনুগ্রহ করে পূরণ করুন।" 