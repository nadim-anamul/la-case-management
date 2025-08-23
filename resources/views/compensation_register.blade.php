@extends('layouts.app')

@section('title', 'ক্ষতিপূরণ কেস রেজিস্টার')

@section('styles')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    <style>
        .dt-buttons .dt-button { 
            background-image: linear-gradient(to right, #2563eb, #60a5fa); /* from-blue-600 to-blue-400 */
            color: #ffffff;
            font-weight: 700; /* base weight, will increase on hover */
            padding: 0.5rem 1rem; /* py-2 px-4 */
            border-radius: 0.5rem; /* rounded-lg */
            margin-right: 0.5rem; /* mr-2 */
            border: 1px solid #2563eb; /* subtle border */
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(37, 99, 235, 0.15); /* shadow-lg */
            position: relative; /* relative */
            z-index: 10; /* z-10 */
            transition: all 0.3s ease; /* transition-all duration-300 */
        }
        .dt-buttons .dt-button:hover { 
            background-image: linear-gradient(to right, #1d4ed8, #3b82f6); /* hover:from-blue-700 to-blue-500 */
            transform: translateY(-1px) translateX(0.25rem); /* group-hover:translate-x-1 */
            box-shadow: 0 6px 14px rgba(37, 99, 235, 0.22);
            font-weight: 800; /* group-hover:font-bold */
        }
        .dt-buttons .dt-button:focus { 
            outline: none; 
            box-shadow: 0 0 0 3px rgba(59,130,246,0.35); /* focus:ring-blue-300 */
        }
        table.dataTable tbody tr:hover { background-color: #f9fafb; }

        /* Column separation and table styling */
        #registerTable { border-collapse: separate; border-spacing: 0; }
        #registerTable thead th {
            background-color: #f8fafc; /* slate-50 */
            color: #334155; /* slate-700 */
            border-bottom: 2px solid #e5e7eb; /* gray-200 */
            border-right: 1px solid #e5e7eb;
            padding: 12px;
        }
        #registerTable thead th:last-child { border-right: none; }
        #registerTable tbody td {
            border-bottom: 1px solid #e5e7eb;
            border-right: 1px solid #e5e7eb;
            padding: 10px 12px;
            vertical-align: top;
        }
        #registerTable tbody td:last-child { border-right: none; }
        #registerTable tbody tr:nth-child(even) { background-color: #fafafa; }

        /* Enhanced print button styling */
        .dt-buttons { display: flex; gap: 0.5rem; margin-bottom: 0.5rem; }
        .dt-buttons .dt-button.buttons-print {
            background-image: none;
            background-color: #2563eb; /* solid blue */
            color: #ffffff;
            font-weight: 800;
            padding: 0.75rem 1.5rem; /* py-3 px-6 */
            border-radius: 9999px; /* pill */
            border: none;
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.25);
        }
        .dt-buttons .dt-button.buttons-print:hover {
            background-color: #1d4ed8 !important; /* darker on hover */
            box-shadow: 0 10px 24px rgba(37, 99, 235, 0.3);
        }
        .dt-buttons .dt-button.buttons-print:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(59,130,246,0.35), 0 8px 20px rgba(37, 99, 235, 0.25);
        }
        .dt-print-icon { margin-right: 0.4rem; }
    </style>
@endsection

@section('content')
    <div class="container mx-auto p-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">ক্ষতিপূরণ কেস রেজিস্টার</h1>
            <a href="{{ route('compensation.index') }}"
               class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                ← ক্ষতিপূরণ কেসের তালিকা
            </a>
        </div>

        <div class="bg-white shadow-md rounded-lg p-4 overflow-x-auto">
            <table id="registerTable" class="display stripe hover" style="width:100%">
                <thead>
                    <tr>
                        <th>ক্ষতিপূরণ কেস নং</th>
                        <th>সংশ্লিষ্ট এল.এ কেস নং</th>
                        <th>আবেদনকারীর নাম ও ঠিকানা</th>
                        <th>রোয়েদাদ নং</th>
                        <th>সম্পত্তির তফসিলের বর্ণনা</th>
                        <th>কেস এন্ট্রির তারিখ</th>
                        <th>কেস নিষ্পত্তির তারিখ</th>
                        <th>আদেশের সার-সংক্ষেপ ও অফিসারের স্বাক্ষর</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($compensations as $item)
                        @php
                            // Applicants info (all applicants)
                            $applicantText = '';
                            if (is_array($item->applicants) && count($item->applicants) > 0) {
                                $applicantLines = [];
                                foreach ($item->applicants as $app) {
                                    $name = is_array($app) ? ($app['name'] ?? '') : (string)$app;
                                    $father = is_array($app) ? ($app['father_name'] ?? '') : '';
                                    $address = is_array($app) ? ($app['address'] ?? '') : '';
                                    $line = trim($name)
                                        . (trim($father) ? "\nপিং- " . trim($father) : '')
                                        . (trim($address) ? "\n" . trim($address) : '');
                                    if (trim($line) !== '') { $applicantLines[] = $line; }
                                }
                                $applicantText = implode("\n\n", $applicantLines);
                            } else {
                                $applicantText = '';
                            }

                            // Roedad numbers based on রোয়েদাদের ধরন (award_type)
                            $roedadLines = [];
                            $awardTypes = is_array($item->award_type) ? $item->award_type : [];
                            // Land
                            if (in_array('জমি', $awardTypes) && !empty($item->land_award_serial_no)) {
                                $roedadLines[] = 'জমি: ' . $item->getBengaliValue('land_award_serial_no');
                            }
                            // Trees/Crops
                            if (in_array('গাছপালা/ফসল', $awardTypes) && !empty($item->tree_award_serial_no)) {
                                $roedadLines[] = 'গাছপালা/ফসল: ' . $item->getBengaliValue('tree_award_serial_no');
                            }
                            // Infrastructure
                            if (in_array('অবকাঠামো', $awardTypes) && !empty($item->infrastructure_award_serial_no)) {
                                $roedadLines[] = 'অবকাঠামো: ' . $item->getBengaliValue('infrastructure_award_serial_no');
                            }
                            $roedadDisplay = implode("\n", $roedadLines);

                            // Property schedule description
                            $lines = [];
                            if (!empty($item->upazila)) { $lines[] = 'উপজেলা: ' . $item->upazila; }
                            $mouzaJl = trim(($item->mouza_name ?? ''));
                            $jlNo = $item->getBengaliValue('jl_no');
                            if ($mouzaJl || $jlNo) { $lines[] = 'মৌজা: ' . trim($mouzaJl . ($jlNo ? '/' . $jlNo : '')); }
                            $isSA = $item->acquisition_record_basis === 'SA';
                            $khatian = $isSA ? $item->getBengaliValue('sa_khatian_no') : $item->getBengaliValue('rs_khatian_no');
                            $plot = $isSA ? $item->getBengaliValue('land_schedule_sa_plot_no') : $item->getBengaliValue('land_schedule_rs_plot_no');
                            if ($khatian) { $lines[] = 'খতিয়ান নং: ' . $khatian; }
                            if ($plot) { $lines[] = 'দাগ নং: ' . $plot; }

                            // পরিমাণ (একরে): total acquired land with award type suffixes
                            $acquiredLand = 0.0;
                            $hasAcquired = false;
                            if (is_array($item->final_order ?? null) && isset($item->final_order['land']['categories']) && is_array($item->final_order['land']['categories'])) {
                                foreach ($item->final_order['land']['categories'] as $cat) {
                                    if (isset($cat['acquired_land']) && $cat['acquired_land'] !== '') {
                                        $acquiredLand += (float) $item->enDigits($cat['acquired_land']);
                                        $hasAcquired = true;
                                    }
                                }
                            }
                            if (!$hasAcquired) {
                                // Fallback to total land from categories
                                $acquiredLand = (float) ($item->total_land_amount ?? 0);
                            }
                            $areaLine = '';
                            if ($acquiredLand > 0) {
                                $areaStr = $item->bnDigits(number_format($acquiredLand, 4, '.', ''));
                                $tags = [];
                                if (in_array('গাছপালা/ফসল', $awardTypes)) { $tags[] = 'ফসল'; }
                                if (in_array('অবকাঠামো', $awardTypes)) { $tags[] = 'অবকাঠামো'; }
                                $suffix = count($tags) ? ('+' . implode('+', $tags)) : '';
                                $areaLine = 'পরিমাণ (একরে): ' . $areaStr . $suffix;
                                $lines[] = $areaLine;
                            }
                            $scheduleText = implode("\n", $lines);

                            // Order summary and officer signature
                            $officer = $item->signing_officer_name ?: '';
                            $orderSummary = '';
                            if (is_array($item->final_order ?? null) && !empty($item->final_order['summary'] ?? '')) {
                                $orderSummary = (string) $item->final_order['summary'];
                            }
                            $orderCell = trim(($orderSummary ? $orderSummary . "\n" : '') . ($officer ? ('স্বাক্ষরকারী: ' . $officer) : ''));
                        @endphp
                        <tr>
                            <td>{{ $item->getBengaliValue('case_number') }}</td>
                            <td>{{ $item->getBengaliValue('la_case_no') }}</td>
                            <td><div class="whitespace-pre-line">{{ $applicantText }}</div></td>
                            <td><div class="whitespace-pre-line">{{ $roedadDisplay }}</div></td>
                            <td><div class="whitespace-pre-line">{{ $scheduleText }}</div></td>
                            <td>{{ $item->case_date_bengali }}</td>
                            <td>{{ $item->order_signature_date_bengali }}</td>
                            <td><div class="whitespace-pre-line">{{ $orderCell }}</div></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- jQuery and DataTables + Buttons -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const table = $('#registerTable').DataTable({
                pageLength: 10,
                order: [],
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'print',
                        text: '<span class="dt-print-icon" aria-hidden="true">🖨️</span><span>প্রিন্ট</span>',
                        title: 'ক্ষতিপূরণ কেস রেজিস্টার',
                        exportOptions: { columns: ':visible', modifier: { page: 'all' } },
                        customize: function (win) {
                            const css = 'body{ font-family:"Tiro Bangla", serif; }\n'
                                + '#registerTable{ border-collapse: collapse; width:100%; }\n'
                                + '#registerTable th, #registerTable td{ border:1px solid #e5e7eb; padding:6px; vertical-align: top; }\n'
                                + '#registerTable thead th{ background:#f8fafc; }\n'
                                + '#registerTable tbody tr{ page-break-inside: avoid; break-inside: avoid; }\n'
                                + '#registerTable tbody td{ page-break-inside: avoid; break-inside: avoid; }';
                            const head = win.document.head || win.document.getElementsByTagName('head')[0];
                            const style = win.document.createElement('style');
                            style.type = 'text/css';
                            style.appendChild(win.document.createTextNode(css));
                            head.appendChild(style);
                            const link = win.document.createElement('link');
                            link.rel = 'stylesheet';
                            link.href = 'https://fonts.googleapis.com/css2?family=Tiro+Bangla&display=swap';
                            head.appendChild(link);
                        }
                    }
                ],
                language: {
                    search: 'অনুসন্ধান:',
                    lengthMenu: 'প্রতি পাতায় _MENU_ টি',
                    info: 'মোট _TOTAL_ টি থেকে _START_ থেকে _END_ পর্যন্ত',
                    paginate: { previous: 'পূর্ববর্তী', next: 'পরবর্তী' },
                    zeroRecords: 'কোনো তথ্য পাওয়া যায়নি',
                }
            });
        });
    </script>
@endsection


