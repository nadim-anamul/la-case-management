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

Three test methods have been added to `OwnershipContinuityFlowTest`:

1. `test_application_area_validation_with_specific_plot()` - Tests specific plot validation
2. `test_application_area_validation_with_multiple_plots()` - Tests multiple plots validation
3. `test_edit_form_with_all_steps_completed()` - Tests edit functionality with all steps completed

These tests verify that:
- Application area data is properly saved
- Validation rules are enforced
- Form edit functionality works correctly
- All steps are marked as completed when editing forms with existing data

## Create vs Edit Mode

### Smart Mode Detection
The system automatically detects whether the user is creating a new form or editing an existing one:

#### `isEditMode()` Function
Checks for existing data to determine the mode:
- **Edit Mode**: When any ownership details exist (SA/RS info, transfers, applicant info)
- **Create Mode**: When no existing data is present

### Create Mode (Sequential Navigation)
When creating a new form:
- **All 3 Steps Visible**: All steps are shown initially but with different states
- **Sequential Progression**: Users must complete each step before proceeding to the next
- **Locked Future Steps**: Steps that haven't been reached yet are visually locked
- **Progress Enforcement**: Cannot skip steps - shows error message if attempted
- **Visual Feedback**: Clear indication of current, completed, and locked steps

### Edit Mode (Free Navigation)
When editing an existing form:
- **Auto-Detection**: Automatically detects which steps have data
- **Free Navigation**: Users can navigate to any step regardless of completion status
- **Data Preservation**: All existing data is properly loaded and maintained



### Step States

#### Create Mode:
- **Current Step**: Blue circle with ring border
- **Completed Steps**: Green circle with small checkmark
- **Available Steps**: Gray circle (previous steps)
- **Locked Steps**: Light gray circle with disabled cursor

#### Edit Mode:
- **Current Step**: Blue circle with ring border
- **Completed Steps**: Green circle with small checkmark
- **Available Steps**: Gray circle (all steps accessible)

### Navigation Logic

#### Create Mode Navigation:
```javascript
// Sequential navigation only
if (step === this.currentStep || 
    (targetIndex === currentIndex + 1 && this.completedSteps.includes(this.currentStep)) ||
    (targetIndex < currentIndex && this.completedSteps.includes(step))) {
    this.currentStep = step;
} else if (targetIndex > currentIndex) {
    // Show error for trying to skip steps
    this.showAlert('অনুগ্রহ করে বর্তমান ধাপ সম্পূর্ণ করুন আগে পরবর্তী ধাপে যাওয়ার জন্য।', 'error');
}
```

#### Edit Mode Navigation:
```javascript
// Free navigation to any step
if (this.completedSteps.includes(step) || 
    step === this.currentStep || 
    (step === 'applicant' && this.completedSteps.includes('transfers')) ||
    this.completedSteps.length > 0) {
    this.currentStep = step;
}
```

## Error Messages

All error messages are in Bengali:

- **No selection**: "অনুগ্রহ করে একটি বিকল্প নির্বাচন করুন"
- **Specific plot incomplete**: "সুনির্দিষ্ট দাগের জন্য সকল তথ্য পূরণ করুন"
- **Multiple plots incomplete**: "বিভিন্ন দাগের জন্য সকল তথ্য পূরণ করুন"
- **Form submission blocked**: "কিছু দলিলে আবেদনকৃত দাগের তথ্য অসম্পূর্ণ। অনুগ্রহ করে পূরণ করুন।" 