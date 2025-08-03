<?php

namespace App\Traits;

trait BengaliDateTrait
{
    /**
     * Convert English date to Bengali date format (day/month/year)
     */
    public function convertToBengaliDate($englishDate)
    {
        if (!$englishDate) {
            return null;
        }

        $date = \Carbon\Carbon::parse($englishDate);
        
        // Convert day, month, year to Bengali numerals
        $day = $this->convertToBengaliNumerals($date->day);
        $month = $this->convertToBengaliNumerals($date->month);
        $year = $this->convertToBengaliNumerals($date->year);
        
        return $day . '/' . $month . '/' . $year;
    }

    /**
     * Convert English numerals to Bengali numerals
     */
    private function convertToBengaliNumerals($number)
    {
        $englishNumerals = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $bengaliNumerals = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
        
        return str_replace($englishNumerals, $bengaliNumerals, $number);
    }

    /**
     * Convert Bengali date format back to English date for database storage
     */
    public function convertFromBengaliDate($date)
    {
        if (!$date) {
            return null;
        }

        // If the date is already in Y-m-d format (English), return it as is
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            return $date;
        }

        // Convert Bengali numerals to English numerals
        $bengaliNumerals = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
        $englishNumerals = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        
        $englishDate = str_replace($bengaliNumerals, $englishNumerals, $date);
        
        // Parse the date format (day/month/year)
        $parts = explode('/', $englishDate);
        if (count($parts) === 3) {
            $day = $parts[0];
            $month = $parts[1];
            $year = $parts[2];
            
            // Validate and create date
            if (checkdate($month, $day, $year)) {
                return \Carbon\Carbon::create($year, $month, $day)->format('Y-m-d');
            }
        }
        
        return null;
    }

    /**
     * Process date fields in the request data
     */
    public function processBengaliDates($data)
    {
        $dateFields = [
            'case_date',
            'ownership_details.deed_transfers.*.deed_date',
            'ownership_details.inheritance_records.*.death_date',
            'ownership_details.applicant_info.kharij_date',
            'order_signature_date'
        ];

        foreach ($dateFields as $field) {
            if (str_contains($field, '*')) {
                // Handle array fields
                $this->processArrayDateFields($data, $field);
            } else {
                // Handle single date fields
                if (isset($data[$field]) && $data[$field]) {
                    $data[$field] = $this->convertFromBengaliDate($data[$field]);
                }
            }
        }

        return $data;
    }

    /**
     * Process date fields in array structures
     */
    private function processArrayDateFields(&$data, $fieldPattern)
    {
        $parts = explode('.', $fieldPattern);
        $fieldName = array_pop($parts);
        
        $current = &$data;
        foreach ($parts as $part) {
            if ($part === '*') {
                // Handle wildcard for arrays
                if (is_array($current)) {
                    foreach ($current as &$item) {
                        if (isset($item[$fieldName]) && $item[$fieldName]) {
                            $item[$fieldName] = $this->convertFromBengaliDate($item[$fieldName]);
                        }
                    }
                }
                return;
            }
            
            if (!isset($current[$part])) {
                return;
            }
            
            $current = &$current[$part];
        }
        
        if (isset($current[$fieldName]) && $current[$fieldName]) {
            $current[$fieldName] = $this->convertFromBengaliDate($current[$fieldName]);
        }
    }
} 