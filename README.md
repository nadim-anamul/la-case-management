# Laravel PDF Generator

A Laravel application for generating compensation forms and PDF documents.

## Features

### Compensation Form
- Complete compensation form with multiple sections
- Dynamic form validation
- PDF generation capabilities
- Multi-step form process

### Ownership Continuity Section
The ownership continuity section includes a new feature for application area selection:

#### Application Area Types
Users can now select between two types of application areas:

1. **সুনির্দিষ্ট দাগ (Specific Plot)**
   - For single plot applications
   - Format: "আবেদনকৃত [PLOT-NUMBER] দাগের সুনির্দিষ্টভাবে [AREA] একর বিক্রয়"
   - Example: "আবেদনকৃত PLOT-005 দাগের সুনির্দিষ্টভাবে 2 একর বিক্রয়"

2. **বিভিন্ন দাগ (Multiple Plots)**
   - For multiple plots applications
   - Format: "আবেদনকৃত [PLOT-NUMBERS] দাগসহ বিভিন্ন দাগ উল্লেখ করে মোট [TOTAL-AREA] একরের কাতে [SELL-AREA] একর বিক্রয়"
   - Example: "আবেদনকৃত PLOT-005, PLOT-006 দাগসহ বিভিন্ন দাগ উল্লেখ করে মোট 5 একরের কাতে 2 একর বিক্রয়"

#### Data Storage
- Individual field values are stored in the database for better data integrity
- String formatting is handled in the preview using a helper method
- Backward compatibility is maintained for existing data

#### Benefits
- **Efficient Storage**: Only stores individual values, not complete strings
- **Flexible**: Easy to modify individual parts or change formatting
- **Searchable**: Can search/filter by individual plot numbers or areas
- **Maintainable**: Centralized formatting logic in the model

## Installation

1. Clone the repository
2. Run `composer install`
3. Copy `.env.example` to `.env` and configure your database
4. Run `php artisan migrate`
5. Run `php artisan serve`

## Usage

1. Navigate to the compensation form
2. Fill in the required information
3. In the ownership continuity section, select the appropriate application area type
4. Fill in the relevant fields based on your selection
5. Preview the form to see the formatted output

## Database Structure

The application area data is stored in the `ownership_details` JSON field with the following structure:

```json
{
  "deed_transfers": [
    {
      "application_type": "specific|multiple",
      "application_specific_area": "PLOT-005",
      "application_sell_area": "2",
      "application_other_areas": "PLOT-005, PLOT-006",
      "application_total_area": "5",
      "application_sell_area_other": "2"
    }
  ]
}
```

## Recent Changes

### Field Cleanup (August 2025)
- Removed unnecessary fields from deed transfer section:
  - `plot_no` (দাগ নম্বর)
  - `sold_land_amount` (বিক্রিত জমির পরিমাণ)
  - `total_sotangsho` (মোট কত শতাংশ)
  - `total_shotok` (মোট কত শতক)
- Created migration `2025_08_05_163145_remove_old_deed_transfer_fields_from_compensations.php` to clean up existing data
- Updated all form components, controllers, tests, and seeders
- Streamlined the deed transfer form for better user experience

## Contributing

Please read the contributing guidelines before submitting pull requests.
