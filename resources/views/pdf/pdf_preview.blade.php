<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Sheet Preview - {{ $order->case_number }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tiro+Bangla:ital@0;1&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Tiro Bangla', serif;
            background-color: #ccc; /* Gray background for the area outside the page */
        }
        .page {
            background: white;
            display: block;
            margin: 2rem auto;
            padding: 2.5cm; /* Standard A4 padding */
            box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
            width: 21cm;
            /* height: 29.7cm; */ /* Height should be auto to allow content to flow */
        }
        .header { text-align: center; }
        .header h2 { margin: 0; font-weight: bold; text-decoration: underline; }
        .case-info { text-align: center; margin-bottom: 20px; }
        .content-table { width: 100%; border-collapse: collapse; margin-top: 20px; table-layout: fixed; }
        .content-table th, .content-table td { border: 1px solid black; padding: 8px; text-align: left; vertical-align: top; }
        .content-table th { font-weight: bold; text-align: center; }
        .section-title { font-weight: bold; text-decoration: underline; margin-top: 15px; margin-bottom: 5px; font-size: 14px; }
        .compensation-table { width: 100%; border-collapse: collapse; margin-top: 15px; font-size: 12px; }
        .compensation-table th, .compensation-table td { border: 1px solid black; padding: 5px; text-align: center; }
        .signatures { margin-top: 100px; overflow: hidden; width: 100%; }
        .signature-left { float: left; width: 48%; text-align: center; }
        .signature-right { float: right; width: 48%; text-align: center; }
        p { text-align: justify; }

        @media print {
            body {
                background-color: white; /* No gray background when printing */
            }
            .page {
                margin: 0;
                box-shadow: none;
                width: auto;
                height: auto;
            }
            .page-break {
                page-break-before: always;
            }
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="header">
            <p>বাংলাদেশ ফরম নম্বর-২৭০</p>
            <h2>আদেশপত্র</h2>
            <p>(১৯১৭ সালের রেকর্ড ম্যানুয়েলের ১২৯ নং বিধি)</p>
        </div>
        <div class="case-info">
            <p>জেলা - {{ $order->district }}</p>
            <p>মামলার ধরণ: {{ $order->case_type }} নং-{{ $order->case_number }}</p>
        </div>
        <table class="content-table">
            <thead>
                <tr>
                    <th style="width:15%;">আদেশের ক্রমিক নং ও তারিখ</th>
                    <th style="width:65%;">আদেশ ও অফিসারের স্বাক্ষর</th>
                    <th style="width:20%;">আদেশের উপর গৃহীত ব্যবস্থা</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <p>১১</p>
                        <p>{{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y') }}</p>
                    </td>
                    <td>
                        <p>অদ্য আদেশের জন্য দিন ধার্য থাকায় নথি উপস্থাপন করা হলো। রোয়েদাদভুক্ত মালিক {{ $order->applicant_name }} হাজিরা দিলেন।</p>
                        <p>{{ $order->applicant_details }}</p>
                        <p class="section-title">রোয়েদাদ বহি পর্যালোচনা:</p>
                        <p>{{ $order->roedad_review }}</p>
                        <p>{{ $order->miss_case_details }}</p>
                        <p class="section-title">এস এ রেকর্ডপত্র পর্যালোচনাঃ</p>
                        <p>{{ $order->sa_record_details }}</p>
                        <p class="section-title">এস এ রেকর্ডীয় মালিকের ওয়ারিশান সনদ পর্যালোচনা:</p>
                        <p>{{ $order->sa_owner_heir_details }}</p>
                        <p class="section-title">এস এ রেকর্ডীয় মালিকের পুত্রের ওয়ারিশান সনদ পর্যালোচনা:</p>
                        <p>{{ $order->sa_heir_heir_details }}</p>
                        <div class="page-break"></div>
                        <p class="section-title">এস এ রেকর্ডী মালিকের ওয়ারিশমূলে প্রাপ্ত মালিকের হস্তান্তর:</p>
                        <p>{{ $order->sa_heir_transfer_details_1 }}</p>
                        <p>{{ $order->sa_heir_transfer_details_2 }}</p>
                        <p class="section-title">চূড়ান্ত আর এস খতিয়ান প্রকাশ:</p>
                        <p>{{ $order->rs_khatian_details }}</p>
                        <p class="section-title">আর এস রেকর্ডীয় মালিকদ্বয়ের ওয়ারিশান সনদ পর্যালোচনা:</p>
                        <p>{{ $order->rs_owner_heir_details }}</p>
                        <p class="section-title">ভূমি উন্নয়ন কর পর্যালোচনাঃ</p>
                        <p>{{ $order->tax_review }}</p>
                        <p class="section-title">না-দাবী পর্যালোচনা:</p>
                        <p>{{ $order->no_claim_review }}</p>
                        <div class="page-break"></div>
                        <p class="section-title">সরেজমিন তদন্ত প্রতিবেদন পর্যালোচনা:</p>
                        <p>{{ $order->investigation_review }}</p>
                        <p class="section-title">আবেদনকারীর দাবীঃ</p>
                        <p>{{ $order->applicant_claim }}</p>
                        <p class="section-title">সার্বিক পর্যালোচনাঃ</p>
                        <p>{{ $order->overall_review }}</p>
                        <p style="font-weight: bold; margin-top: 20px;">অতএব, আদেশ হয় যে,</p>
                        <p>{{ $order->final_order_summary }}</p>
                        <p>{{ $order->final_payment_order }}</p>
                        <table class="compensation-table">
                            <thead>
                                <tr>
                                    <th>রোয়েদাদ নং</th>
                                    <th>খতিয়ান নং</th>
                                    <th>জমির পরিমাণ বা অন্যান্য বাবদ</th>
                                    <th>মোট ক্ষতিপূরণ</th>
                                    <th>উৎস কর কর্তন</th>
                                    <th>বাদে ক্ষতিপূরণ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php 
                                    $compensationData = json_decode($order->compensation_details, true);
                                    $total_comp = 0; $total_tax = 0; $total_net = 0;
                                @endphp
                                @foreach($compensationData as $item)
                                @php
                                    $item_total = (float)str_replace(',', '', $item['total_compensation']);
                                    $item_tax = (float)str_replace(',', '', $item['tax_deduction']);
                                    $item_net = (float)str_replace(',', '', $item['net_compensation']);
                                    $total_comp += $item_total; $total_tax += $item_tax; $total_net += $item_net;
                                @endphp
                                <tr>
                                    <td>{{ $item['roedad_no'] }}</td>
                                    <td>{{ $item['dag_no'] }}</td>
                                    <td>{{ $item['description'] }}</td>
                                    <td>{{ number_format($item_total, 2, '.', '') }}</td>
                                    <td>{{ number_format($item_tax, 2, '.', '') }}</td>
                                    <td>{{ number_format($item_net, 2, '.', '') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" style="text-align: right; font-weight: bold;">মোট প্রদেয় টাকা =</td>
                                    <td style="font-weight: bold;">{{ number_format($total_comp, 2, '.', '') }}</td>
                                    <td style="font-weight: bold;">{{ number_format($total_tax, 2, '.', '') }}</td>
                                    <td style="font-weight: bold;">{{ number_format($total_net, 2, '.', '') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                        <p style="margin-top: 15px;">মোট (কথায়ঃ {{ $order->total_compensation_words }}) টাকার প্রয়োজনীয় বন্ড ও যথাযথ সনাক্তকরণের মাধ্যমে নথি প্রাপ্তির ০৩ (তিন) কার্য দিবসের মধ্যে সিসি প্রস্তুত অন্তে এল এ চেক প্রদান করা হোক। তৎসহ ৩% উৎস কর {{ number_format($total_tax, 2, '.', '') }} টাকা কর্তন এর ভাউচার বিলসহ এলএ চেক জেলা হিসাবরক্ষণ অফিসে প্রেরণ করা হোক।</p>
                        <div class="signatures">
                            <div class="signature-left">
                                <p><strong>{{ $order->lao_name }}</strong></p>
                                <p>ভূমি অধিগ্রহণ কর্মকর্তা</p>
                                <p>{{ $order->district }}</p>
                            </div>
                            <div class="signature-right">
                                <p><strong>{{ $order->adc_name }}</strong></p>
                                <p>অতিরিক্ত জেলা প্রশাসক (রাজস্ব)</p>
                                <p>{{ $order->district }}</p>
                            </div>
                        </div>
                    </td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>