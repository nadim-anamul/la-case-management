@extends('layouts.app')

@section('title', 'ক্ষতিপূরণ তথ্য ফরম')

@section('styles')
<style>
    body { 
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
    }
    
    .form-container {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .form-section { 
        background: linear-gradient(145deg, #ffffff, #f8fafc);
        border: 2px solid #e2e8f0; 
        border-radius: 15px; 
        padding: 2rem; 
        margin-bottom: 2rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .form-section:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        border-color: #3b82f6;
    }
    
    .form-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #3b82f6, #8b5cf6, #06b6d4);
    }
    
    .form-section-title { 
        font-size: 1.5rem; 
        font-weight: 700; 
        margin-bottom: 1.5rem; 
        padding-bottom: 0.75rem; 
        border-bottom: 3px solid #e2e8f0;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .form-section-title::before {
        content: '';
        width: 8px;
        height: 8px;
        background: linear-gradient(45deg, #3b82f6, #8b5cf6);
        border-radius: 50%;
        display: inline-block;
    }
    
    .sub-section { 
        background: linear-gradient(145deg, #f8fafc, #f1f5f9);
        border: 2px solid #e2e8f0; 
        border-radius: 12px; 
        padding: 1.5rem; 
        margin-top: 1.5rem; 
        position: relative;
        transition: all 0.3s ease;
    }
    
    .sub-section:hover {
        border-color: #06b6d4;
        box-shadow: 0 4px 12px rgba(6, 182, 212, 0.1);
    }
    
    label { 
        font-weight: 600; 
        color: #374151;
        margin-bottom: 0.5rem;
        display: block;
        font-size: 0.95rem;
    }
    
    input[type="text"], 
    input[type="date"], 
    input[type="email"], 
    select, 
    textarea {
        background: linear-gradient(145deg, #ffffff, #f8fafc);
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);
    }
    
    input[type="text"]:focus, 
    input[type="date"]:focus, 
    input[type="email"]:focus, 
    select:focus, 
    textarea:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1), inset 0 2px 4px rgba(0, 0, 0, 0.05);
        transform: translateY(-1px);
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        border: none;
        border-radius: 10px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        color: white;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px rgba(59, 130, 246, 0.25);
    }
    
    .btn-primary:hover {
        background: linear-gradient(135deg, #1d4ed8, #1e40af);
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(59, 130, 246, 0.4);
    }
    
    .btn-secondary {
        background: linear-gradient(135deg, #6b7280, #4b5563);
        border: none;
        border-radius: 10px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        color: white;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px rgba(107, 114, 128, 0.25);
    }
    
    .btn-secondary:hover {
        background: linear-gradient(135deg, #4b5563, #374151);
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(107, 114, 128, 0.4);
    }
    
    .btn-success {
        background: linear-gradient(135deg, #10b981, #059669);
        border: none;
        border-radius: 10px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        color: white;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px rgba(16, 185, 129, 0.25);
    }
    
    .btn-success:hover {
        background: linear-gradient(135deg, #059669, #047857);
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(16, 185, 129, 0.4);
    }
    
    .btn-danger {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        border: none;
        border-radius: 50%;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        font-weight: bold;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px rgba(239, 68, 68, 0.25);
    }
    
    .btn-danger:hover {
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        transform: scale(1.1);
        box-shadow: 0 6px 12px rgba(239, 68, 68, 0.4);
    }
    
    .record-card {
        background: linear-gradient(145deg, #ffffff, #f8fafc);
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        position: relative;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }
    
    .record-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        border-color: #06b6d4;
    }
    
    .record-card h3, .record-card h4 {
        color: #1e293b;
        font-weight: 700;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .record-card h3::before, .record-card h4::before {
        content: '';
        width: 6px;
        height: 6px;
        background: linear-gradient(45deg, #06b6d4, #3b82f6);
        border-radius: 50%;
        display: inline-block;
    }
    
    .radio-group, .checkbox-group {
        display: flex;
        gap: 1.5rem;
        flex-wrap: wrap;
        margin-top: 0.5rem;
    }
    
    .radio-group label, .checkbox-group label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background: linear-gradient(145deg, #f8fafc, #f1f5f9);
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 500;
    }
    
    .radio-group label:hover, .checkbox-group label:hover {
        border-color: #3b82f6;
        background: linear-gradient(145deg, #eff6ff, #dbeafe);
    }
    
    .radio-group input:checked + span,
    .checkbox-group input:checked + span {
        color: #3b82f6;
        font-weight: 600;
    }
    
    .alert {
        background: linear-gradient(145deg, #fef2f2, #fee2e2);
        border: 2px solid #fecaca;
        border-radius: 12px;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
        color: #991b1b;
        font-weight: 500;
    }
    
    .alert ul {
        margin-top: 0.5rem;
        padding-left: 1.5rem;
    }
    
    .alert li {
        margin-bottom: 0.25rem;
    }
    
    .page-header {
        background: linear-gradient(135deg, #1e293b, #334155);
        color: white;
        padding: 2rem;
        border-radius: 15px;
        margin-bottom: 2rem;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }
    
    .page-header h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .page-header p {
        opacity: 0.9;
        font-size: 1.1rem;
    }
    
    .form-footer {
        background: linear-gradient(145deg, #f8fafc, #f1f5f9);
        border: 2px solid #e2e8f0;
        border-radius: 15px;
        padding: 2rem;
        margin-top: 2rem;
        text-align: center;
    }
    
    .form-footer .btn {
        margin: 0 0.5rem;
    }
    
    .section-icon {
        width: 24px;
        height: 24px;
        background: linear-gradient(45deg, #3b82f6, #8b5cf6);
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.75rem;
        font-weight: bold;
        margin-right: 0.75rem;
    }
    
    .floating-label {
        position: relative;
        margin-bottom: 1.5rem;
    }
    
    .floating-label input,
    .floating-label select,
    .floating-label textarea {
        width: 100%;
        padding-top: 1.5rem;
        padding-bottom: 0.5rem;
    }
    
    .floating-label label {
        position: absolute;
        top: 0.75rem;
        left: 1rem;
        font-size: 0.875rem;
        color: #6b7280;
        transition: all 0.3s ease;
        pointer-events: none;
    }
    
    .floating-label input:focus + label,
    .floating-label input:not(:placeholder-shown) + label,
    .floating-label select:focus + label,
    .floating-label select:not([value=""]) + label,
    .floating-label textarea:focus + label,
    .floating-label textarea:not(:placeholder-shown) + label {
        top: 0.25rem;
        font-size: 0.75rem;
        color: #3b82f6;
        font-weight: 600;
    }
    
    @media (max-width: 768px) {
        .form-section {
            padding: 1.5rem;
        }
        
        .page-header {
            padding: 1.5rem;
        }
        
        .page-header h1 {
            font-size: 2rem;
        }
        
        .radio-group, .checkbox-group {
            flex-direction: column;
            gap: 0.75rem;
        }
    }
</style>
@endsection

@section('scripts')
<script defer>
    document.addEventListener('alpine:init', () => {
        window.compensationForm = () => ({
            applicants: [{ name: '', father_name: '', address: '', nid: '' }],
            is_sa_owner: 'yes',
            ownership_type: 'deed',
            is_heir_applicant: 'yes',
            deed_transfers: [{ 
                donor_name: '', recipient_name: '', deed_number: '', deed_date: '', 
                sale_type: '', plot_no: '', sold_land_amount: '', total_sotangsho: '', 
                total_shotok: '', possession_mentioned: 'yes', possession_plot_no: '', 
                possession_description: '', mutation_case_no: '', mutation_plot_no: '', 
                mutation_land_amount: '' 
            }],
            inheritance_details: {
                is_heir_applicant: 'yes',
                has_death_cert: 'yes',
                heirship_certificate_info: ''
            },
            mutation_records: [{ khatian_no: '', case_no: '', plot_no: '', land_amount: '' }],
            distribution_records: [{ details: '' }],
            no_claim_type: 'donor',
            field_investigation_info: '',
            submitted_docs: [],
            
            addApplicant() {
                this.applicants.push({ name: '', father_name: '', address: '', nid: '' });
            },
            removeApplicant(index) {
                this.applicants.splice(index, 1);
            },
            addDeedTransfer() {
                this.deed_transfers.push({ 
                    donor_name: '', recipient_name: '', deed_number: '', deed_date: '', 
                    sale_type: '', plot_no: '', sold_land_amount: '', total_sotangsho: '', 
                    total_shotok: '', possession_mentioned: 'yes', possession_plot_no: '', 
                    possession_description: '', mutation_case_no: '', mutation_plot_no: '', 
                    mutation_land_amount: '' 
                });
            },
            removeDeedTransfer(index) {
                this.deed_transfers.splice(index, 1);
            },
            addMutationRecord() {
                this.mutation_records.push({ khatian_no: '', case_no: '', plot_no: '', land_amount: '' });
            },
            removeMutationRecord(index) {
                this.mutation_records.splice(index, 1);
            },
            addDistributionRecord() {
                this.distribution_records.push({ details: '' });
            },
            removeDistributionRecord(index) {
                this.distribution_records.splice(index, 1);
            }
        });
    });
</script>
@endsection

@section('content')
<div class="container mx-auto p-8">
    <div class="page-header">
        <div class="flex justify-between items-center">
            <div>
                <h1>ক্ষতিপূরণ তথ্য ফরম</h1>
                <p>ভূমি অধিগ্রহণ সম্পর্কিত ক্ষতিপূরণের জন্য আবেদন ফরম</p>
            </div>
            <a href="{{ route('compensation.index') }}" class="btn-secondary">
                ← তালিকা দেখুন
            </a>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert" role="alert">
            <p><strong>অনুগ্রহ করে নিচের ত্রুটিগুলো সংশোধন করুন:</strong></p>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('compensation.store') }}" method="POST" class="form-container p-8" x-data="compensationForm">
        @csrf
        
        <!-- Section 1: Applicant Information -->
        <div class="form-section">
            <h2 class="form-section-title">
                <span class="section-icon">১</span>
                আবেদনকারীর তথ্যঃ
            </h2>
            <template x-for="(applicant, index) in applicants" :key="index">
                <div class="record-card">
                    <h3 x-text="'আবেদনকারী #' + (index + 1)"></h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="floating-label">
                            <input type="text" :name="'applicants[' + index + '][name]'" x-model="applicant.name" placeholder=" " required>
                            <label>নাম</label>
                        </div>
                        <div class="floating-label">
                            <input type="text" :name="'applicants[' + index + '][father_name]'" x-model="applicant.father_name" placeholder=" " required>
                            <label>পিতার নাম</label>
                        </div>
                        <div class="floating-label md:col-span-2">
                            <input type="text" :name="'applicants[' + index + '][address]'" x-model="applicant.address" placeholder=" " required>
                            <label>ঠিকানা</label>
                        </div>
                        <div class="floating-label">
                            <input type="text" :name="'applicants[' + index + '][nid]'" x-model="applicant.nid" placeholder=" " required>
                            <label>এন আই ডি</label>
                        </div>
                    </div>
                    <button
                        type="button"
                        @click="removeApplicant(index)"
                        x-show="applicants.length > 1 && index !== 0"
                        class="btn-danger absolute top-4 right-4"
                        title="আবেদনকারী মুছুন"
                    >×</button>
                </div>
            </template>
            <div class="flex items-center space-x-4">
                <button type="button" @click="addApplicant()" class="btn-success">
                    + আবেদনকারী যোগ করুন
                </button>
                <span class="text-gray-600 text-sm">কমপক্ষে একজন আবেদনকারীর তথ্য প্রয়োজন</span>
            </div>
        </div>

        <!-- Section 2: Award Information -->
        <div class="form-section">
            <h2 class="form-section-title">
                <span class="section-icon">২</span>
                রোয়েদাদের তথ্যঃ
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="floating-label">
                    <input type="text" name="la_case_no" placeholder=" ">
                    <label>এলএ কেস নং</label>
                </div>
                <div>
                    <label>রোয়েদাদের ধরন</label>
                    <div class="checkbox-group">
                        <label><input type="checkbox" name="award_type[]" value="জমি/অবকাঠামো" class="mr-2"><span>জমি/অবকাঠামো</span></label>
                        <label><input type="checkbox" name="award_type[]" value="জমি/গাছপালা" class="mr-2"><span>জমি/গাছপালা</span></label>
                    </div>
                </div>
                <div class="floating-label">
                    <input type="text" name="award_serial_no" placeholder=" ">
                    <label>রোয়েদাদের ক্রমিক নং</label>
                </div>
                <div class="floating-label">
                    <input type="text" name="acquisition_record_basis" placeholder=" ">
                    <label>যে রেকর্ড মূলে অধিগ্রহণ</label>
                </div>
                <div class="floating-label">
                    <input type="text" name="plot_no" placeholder=" ">
                    <label>দাগ নং</label>
                </div>
                <div class="floating-label">
                    <input type="text" name="award_holder_name" placeholder=" ">
                    <label>রোয়েদাদভুক্ত মালিকের নাম</label>
                </div>
                <div class="floating-label md:col-span-2">
                    <textarea name="objector_details" rows="3" placeholder=" "></textarea>
                    <label>রোয়েদাদে কোন আপত্তি অন্তর্ভুক্ত থাকলে আপত্তিকারীর নাম ও ঠিকানা</label>
                </div>
                <div>
                    <label>আবেদনকারীর নাম রোয়েদাদে আছে কিনা?</label>
                    <div class="radio-group">
                        <label><input type="radio" name="is_applicant_in_award" value="1" class="mr-2"><span>হ্যাঁ</span></label>
                        <label><input type="radio" name="is_applicant_in_award" value="0" class="mr-2"><span>না</span></label>
                    </div>
                </div>
                <div class="floating-label">
                    <input type="text" name="total_acquired_land" placeholder=" ">
                    <label>অধিগ্রহণকৃত মোট জমির পরিমাণ</label>
                </div>
                <div class="floating-label">
                    <input type="text" name="total_compensation" placeholder=" ">
                    <label>অধিগ্রহণকৃত জমির মোট ক্ষতিপূরণ (উৎস কর সহ)</label>
                </div>
                <div class="floating-label">
                    <input type="text" name="applicant_acquired_land" placeholder=" ">
                    <label>আবেদনকারীর অধিগ্রহণকৃত জমির পরিমাণ</label>
                </div>
            </div>
        </div>

        <!-- Section 3: Land Schedule -->
        <div class="form-section">
            <h2 class="form-section-title">
                <span class="section-icon">৩</span>
                আবেদনকৃত জমির তফসিলঃ
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="floating-label">
                    <input type="text" name="mouza_name" placeholder=" ">
                    <label>মৌজার নাম</label>
                </div>
                <div class="floating-label">
                    <input type="text" name="jl_no" placeholder=" ">
                    <label>জেএল নং</label>
                </div>
                <div class="floating-label">
                    <input type="text" name="sa_khatian_no" placeholder=" ">
                    <label>এসএ খতিয়ান নং</label>
                </div>
                <div class="floating-label">
                    <input type="text" name="former_plot_no" placeholder=" ">
                    <label>সাবেক দাগ নং</label>
                </div>
                <div class="floating-label">
                    <input type="text" name="rs_khatian_no" placeholder=" ">
                    <label>আর এস খতিয়ান নং</label>
                </div>
                <div class="floating-label">
                    <input type="text" name="current_plot_no" placeholder=" ">
                    <label>হাল দাগ নং</label>
                </div>
            </div>
        </div>

        <!-- Section 4: Ownership Continuity -->
        <div class="form-section">
            <h2 class="form-section-title">
                <span class="section-icon">৪</span>
                মালিকানার ধারাবাহিকতার বর্ণনাঃ
            </h2>
            <div>
                <label>১। আবেদনকারি নিজে SA মালিক?</label>
                <div class="radio-group">
                    <label><input type="radio" name="ownership_details[is_applicant_sa_owner]" value="yes" x-model="is_sa_owner" class="mr-2"><span>হ্যাঁ</span></label>
                    <label><input type="radio" name="ownership_details[is_applicant_sa_owner]" value="no" x-model="is_sa_owner" class="mr-2"><span>না</span></label>
                </div>
            </div>

            <div x-show="is_sa_owner === 'no'" class="mt-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="floating-label">
                        <input type="text" name="ownership_details[sa_owner_name]" placeholder=" ">
                        <label>SA মালিকের নাম</label>
                    </div>
                    <div class="floating-label">
                        <input type="text" name="ownership_details[sa_plot_no]" placeholder=" ">
                        <label>দাগ নম্বর</label>
                    </div>
                    <div class="floating-label">
                        <input type="text" name="ownership_details[previous_owner_name]" placeholder=" ">
                        <label>যে মালিকের থেকে আগত তার নাম</label>
                    </div>
                    <div class="floating-label">
                        <input type="text" name="ownership_details[sa_khatian_no]" placeholder=" ">
                        <label>খতিয়ান নম্বর</label>
                    </div>
                    <div class="floating-label">
                        <input type="text" name="ownership_details[sa_total_land_in_plot]" placeholder=" ">
                        <label>দাগে মোট জমি</label>
                    </div>
                    <div class="floating-label">
                        <input type="text" name="ownership_details[sa_land_in_khatian]" placeholder=" ">
                        <label>উক্ত খতিয়ানে জমির পরিমাণ</label>
                    </div>
                </div>

                <div>
                    <label>আবেদনকারি কি দলিল মূলে মালিক অথবা ওয়ারিশ মূলে মালিক?</label>
                    <div class="radio-group">
                        <label><input type="radio" name="ownership_details[ownership_type]" value="deed" x-model="ownership_type" class="mr-2"><span>দলিল মূলে</span></label>
                        <label><input type="radio" name="ownership_details[ownership_type]" value="inheritance" x-model="ownership_type" class="mr-2"><span>ওয়ারিশ মূলে</span></label>
                    </div>
                </div>

                <!-- Deed Details -->
                <div x-show="ownership_type === 'deed'" class="sub-section">
                    <h3 class="font-bold mb-4">দলিল মূলে হস্তান্তর তথ্য:</h3>
                    <template x-for="(deed, index) in deed_transfers" :key="index">
                        <div class="record-card">
                            <h4 x-text="'দলিল #' + (index + 1)"></h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="floating-label">
                                    <input type="text" :name="'ownership_details[deed_transfers][' + index + '][donor_name]'" x-model="deed.donor_name" placeholder=" ">
                                    <label>দলিল দাতার নাম</label>
                                </div>
                                <div class="floating-label">
                                    <input type="text" :name="'ownership_details[deed_transfers][' + index + '][recipient_name]'" x-model="deed.recipient_name" placeholder=" ">
                                    <label>দলিল গ্রহীতার নাম</label>
                                </div>
                                <div class="floating-label">
                                    <input type="text" :name="'ownership_details[deed_transfers][' + index + '][deed_number]'" x-model="deed.deed_number" placeholder=" ">
                                    <label>দলিল নম্বর</label>
                                </div>
                                <div class="floating-label">
                                    <input type="date" :name="'ownership_details[deed_transfers][' + index + '][deed_date]'" x-model="deed.deed_date" placeholder=" ">
                                    <label>দলিলের তারিখ</label>
                                </div>
                                <div class="floating-label">
                                    <input type="text" :name="'ownership_details[deed_transfers][' + index + '][sale_type]'" placeholder="সুনির্দিষ্ট দাগে অথবা সম্মিলিত দাগের হতে" x-model="deed.sale_type">
                                    <label>বিক্রয়ের ধরন</label>
                                </div>
                                <div class="floating-label">
                                    <input type="text" :name="'ownership_details[deed_transfers][' + index + '][plot_no]'" x-model="deed.plot_no" placeholder=" ">
                                    <label>দাগ নম্বর</label>
                                </div>
                                <div class="floating-label">
                                    <input type="text" :name="'ownership_details[deed_transfers][' + index + '][sold_land_amount]'" x-model="deed.sold_land_amount" placeholder=" ">
                                    <label>বিক্রিত জমির পরিমাণ</label>
                                </div>
                                <div class="floating-label">
                                    <input type="text" :name="'ownership_details[deed_transfers][' + index + '][total_sotangsho]'" x-model="deed.total_sotangsho" placeholder=" ">
                                    <label>মোট কত শতাংশ</label>
                                </div>
                                <div class="floating-label">
                                    <input type="text" :name="'ownership_details[deed_transfers][' + index + '][total_shotok]'" x-model="deed.total_shotok" placeholder=" ">
                                    <label>মোট কত শতক</label>
                                </div>
                                <div class="floating-label">
                                    <select :name="'ownership_details[deed_transfers][' + index + '][possession_mentioned]'" x-model="deed.possession_mentioned">
                                        <option value="yes">হ্যাঁ</option>
                                        <option value="no">না</option>
                                    </select>
                                    <label>দখল উল্লেখ করা আছে কিনা?</label>
                                </div>
                                <div class="floating-label">
                                    <input type="text" :name="'ownership_details[deed_transfers][' + index + '][possession_plot_no]'" x-model="deed.possession_plot_no" placeholder=" ">
                                    <label>দখলের দাগ নম্বর</label>
                                </div>
                                <div class="floating-label md:col-span-2">
                                    <textarea :name="'ownership_details[deed_transfers][' + index + '][possession_description]'" rows="3" x-model="deed.possession_description" placeholder=" "></textarea>
                                    <label>দখল এর বর্ণনা</label>
                                </div>
                            </div>
                            <div class="sub-section mt-6">
                                <h4 class="font-bold mb-4">ক্রেতার খারিজের তথ্য:</h4>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <div class="floating-label">
                                        <input type="text" :name="'ownership_details[deed_transfers][' + index + '][mutation_case_no]'" x-model="deed.mutation_case_no" placeholder=" ">
                                        <label>খারিজ কেস নম্বর</label>
                                    </div>
                                    <div class="floating-label">
                                        <input type="text" :name="'ownership_details[deed_transfers][' + index + '][mutation_plot_no]'" x-model="deed.mutation_plot_no" placeholder=" ">
                                        <label>দাগ নম্বর</label>
                                    </div>
                                    <div class="floating-label">
                                        <input type="text" :name="'ownership_details[deed_transfers][' + index + '][mutation_land_amount]'" x-model="deed.mutation_land_amount" placeholder=" ">
                                        <label>খারিজকৃত জমির পরিমাণ</label>
                                    </div>
                                </div>
                            </div>
                            <button
                                type="button"
                                @click="removeDeedTransfer(index)"
                                x-show="deed_transfers.length > 1"
                                class="btn-danger absolute top-4 right-4"
                                title="দলিল মুছুন"
                            >×</button>
                        </div>
                    </template>
                    <button type="button" @click="addDeedTransfer()" class="btn-success">
                        + দলিল যোগ করুন
                    </button>
                </div>

                <!-- Inheritance Details -->
                <div x-show="ownership_type === 'inheritance'" class="sub-section">
                    <h3 class="font-bold mb-4">ওয়ারিশ মূলে হস্তান্তর তথ্য:</h3>
                    <div class="space-y-6">
                        <div>
                            <label>ওয়ারিশমুলে প্রাপ্ত বেক্তি কি আবেদনকারী নিজে?</label>
                            <div class="radio-group">
                                <label><input type="radio" name="ownership_details[inheritance][is_heir_applicant]" value="yes" x-model="inheritance_details.is_heir_applicant" class="mr-2"><span>হ্যাঁ</span></label>
                                <label><input type="radio" name="ownership_details[inheritance][is_heir_applicant]" value="no" x-model="inheritance_details.is_heir_applicant" class="mr-2"><span>না</span></label>
                            </div>
                        </div>
                        <div class="floating-label">
                            <select name="ownership_details[inheritance][has_death_cert]" x-model="inheritance_details.has_death_cert">
                                <option value="yes">হ্যাঁ</option>
                                <option value="no">না</option>
                            </select>
                            <label>পূর্বতন মালিকের মৃত্যুসনদ দাখিল করা হয়েছে কিনা?</label>
                        </div>
                        <div class="floating-label">
                            <textarea name="ownership_details[inheritance][heirship_certificate_info]" rows="3" x-model="inheritance_details.heirship_certificate_info" placeholder=" "></textarea>
                            <label>ওয়ারিশান সনদের তথ্য</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 5: Mutation Information -->
        <div class="form-section">
            <h2 class="form-section-title">
                <span class="section-icon">৫</span>
                খারিজের তথ্য
            </h2>
            <template x-for="(mutation, index) in mutation_records" :key="index">
                <div class="record-card">
                    <h3 x-text="'খারিজ #' + (index + 1)"></h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div class="floating-label">
                            <input type="text" :name="'mutation_info[records][' + index + '][khatian_no]'" x-model="mutation.khatian_no" placeholder=" ">
                            <label>খারিজ খতিয়ান নম্বর</label>
                        </div>
                        <div class="floating-label">
                            <input type="text" :name="'mutation_info[records][' + index + '][case_no]'" x-model="mutation.case_no" placeholder=" ">
                            <label>কেস নম্বর</label>
                        </div>
                        <div class="floating-label">
                            <input type="text" :name="'mutation_info[records][' + index + '][plot_no]'" x-model="mutation.plot_no" placeholder=" ">
                            <label>দাগ</label>
                        </div>
                        <div class="floating-label">
                            <input type="text" :name="'mutation_info[records][' + index + '][land_amount]'" x-model="mutation.land_amount" placeholder=" ">
                            <label>পরিমাণ</label>
                        </div>
                    </div>
                    <button
                        type="button"
                        @click="removeMutationRecord(index)"
                        x-show="mutation_records.length > 1"
                        class="btn-danger absolute top-4 right-4"
                        title="খারিজ মুছুন"
                    >×</button>
                </div>
            </template>
            <button type="button" @click="addMutationRecord()" class="btn-success">
                + খারিজ যোগ করুন
            </button>
        </div>

        <!-- Section 6: Tax Information -->
        <div class="form-section">
            <h2 class="form-section-title">
                <span class="section-icon">৬</span>
                খাজনার তথ্য
            </h2>
            <div class="floating-label">
                <input type="text" name="tax_info[paid_until]" placeholder=" ">
                <label>কত সাল পর্যন্ত পরিশোধিত</label>
            </div>
        </div>

        <!-- Section 7: Additional Documents -->
        <div class="form-section">
            <h2 class="form-section-title">
                <span class="section-icon">৭</span>
                বণ্টন / না-দাবি / আপসনামা / সরেজমিন তদন্তের তথ্য
            </h2>
            
            <!-- Distribution Records -->
            <div class="sub-section">
                <h3 class="font-bold mb-4">বণ্টন:</h3>
                <template x-for="(distribution, index) in distribution_records" :key="index">
                    <div class="record-card">
                        <div class="floating-label">
                            <textarea :name="'additional_documents_info[distribution_records][' + index + '][details]'" rows="3" x-model="distribution.details" placeholder=" "></textarea>
                            <label>বণ্টনের বিবরণ</label>
                        </div>
                        <button
                            type="button"
                            @click="removeDistributionRecord(index)"
                            x-show="distribution_records.length > 1"
                            class="btn-danger absolute top-4 right-4"
                            title="বণ্টন মুছুন"
                        >×</button>
                    </div>
                </template>
                <button type="button" @click="addDistributionRecord()" class="btn-success">
                    + বণ্টন যোগ করুন
                </button>
            </div>

            <!-- No Claim Type -->
            <div class="sub-section">
                <h3 class="font-bold mb-4">না দাবি:</h3>
                <div>
                    <label>না দাবির ধরন</label>
                    <div class="radio-group">
                        <label><input type="radio" name="additional_documents_info[no_claim_type]" value="donor" x-model="no_claim_type" class="mr-2"><span>দাতা</span></label>
                        <label><input type="radio" name="additional_documents_info[no_claim_type]" value="recipient" x-model="no_claim_type" class="mr-2"><span>গ্রহীতা</span></label>
                    </div>
                </div>
            </div>

            <!-- Field Investigation -->
            <div class="sub-section">
                <h3 class="font-bold mb-4">সরেজমিন তদন্ত:</h3>
                <div class="floating-label">
                    <textarea name="additional_documents_info[field_investigation_info]" rows="4" x-model="field_investigation_info" placeholder=" "></textarea>
                    <label>সরেজমিন তদন্তের তথ্য</label>
                </div>
            </div>

            <!-- Submitted Documents -->
            <div class="sub-section">
                <h3 class="font-bold mb-4">দাখিলকৃত ডকুমেন্টের ধরন:</h3>
                <div class="checkbox-group">
                    <label><input type="checkbox" name="additional_documents_info[submitted_docs][]" value="বণ্টন" class="mr-2"><span>বণ্টন</span></label>
                    <label><input type="checkbox" name="additional_documents_info[submitted_docs][]" value="না দাবি" class="mr-2"><span>না দাবি</span></label>
                    <label><input type="checkbox" name="additional_documents_info[submitted_docs][]" value="দাতা" class="mr-2"><span>দাতা</span></label>
                    <label><input type="checkbox" name="additional_documents_info[submitted_docs][]" value="গ্রহীতা" class="mr-2"><span>গ্রহীতা</span></label>
                    <label><input type="checkbox" name="additional_documents_info[submitted_docs][]" value="সরেজমিন তদন্ত" class="mr-2"><span>সরেজমিন তদন্ত</span></label>
                </div>
            </div>
        </div>

        <div class="form-footer">
            <button type="submit" class="btn-primary">
                জমা দিন
            </button>
            <a href="{{ route('compensation.index') }}" class="btn-secondary">
                বাতিল করুন
            </a>
        </div>
    </form>
</div>
@endsection
