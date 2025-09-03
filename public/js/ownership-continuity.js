// Wait for Alpine.js to be available and register the component
(function() {
    function initOwnershipContinuity() {
        if (typeof Alpine !== 'undefined' && Alpine.data) {
            Alpine.data('ownershipContinuity', () => ({
                // Basic data properties
                acquisition_record_basis: 'SA', // Default to SA, can be changed by parent form
                sa_info: {
                    sa_plot_no: '',
                    sa_khatian_no: '',
                    sa_total_land_in_plot: '',
                    sa_land_in_khatian: ''
                },
                rs_info: {
                    rs_plot_no: '',
                    rs_khatian_no: '',
                    rs_total_land_in_plot: '',
                    rs_land_in_khatian: '',
                    dp_khatian: false
                },
                applicant_info: {
                    applicant_name: '',
                    namejari_khatian_no: '',
                    kharij_case_no: '',
                    kharij_plot_no: '',
                    kharij_land_amount: '',
                    kharij_date: '',
                    kharij_details: ''
                },
                
                // Arrays
                sa_owners: [{'name': ''}],
                rs_owners: [{'name': ''}],
                deed_transfers: [],
                inheritance_records: [],
                rs_records: [],
                storySequence: [],
                completedSteps: [],
                currentStep: 'info',
                rs_record_disabled: false,
                nextCreationOrder: 1,
                
                // Alert system
                alert: {
                    show: false,
                    type: 'success',
                    message: ''
                },
                
                init() {
                    // Load existing data if available
                    this.loadExistingData();
                    
                    // Ensure we have at least one item in each array
                    if (this.sa_owners.length === 0) this.sa_owners = [{'name': ''}];
                    if (this.rs_owners.length === 0) this.rs_owners = [{'name': ''}];
                    if (this.deed_transfers.length === 0) this.deed_transfers = [];
                    if (this.inheritance_records.length === 0) this.inheritance_records = [];
                    if (this.rs_records.length === 0) this.rs_records = [];
                    
                    // Ensure all existing items have creation orders
                    this.ensureCreationOrders();
                    
                    // Generate story sequence if empty
                    if (this.storySequence.length === 0) {
                        this.generateStorySequence();
                    }
                    
                    // Update completed steps
                    this.updateCompletedSteps();
                    
                    // Watch for changes in acquisition_record_basis
                    this.watchAcquisitionRecordBasis();
                },
                
                // Simple method to load existing data
                loadExistingData() {
                    // Load acquisition_record_basis from parent form
                    this.loadAcquisitionRecordBasis();
                    
                    // Check for old form data (validation errors)
                    const oldFormData = window.oldFormData || {};
                    if (oldFormData.ownership_details && Object.keys(oldFormData.ownership_details).length > 0) {
                        this.loadDataFromOldForm(oldFormData.ownership_details);
                        return;
                    }
                    
                    // Check for compensation data from parent form (edit mode)
                    const form = this.$el.closest('form');
                    if (form) {
                        const compensationData = form.dataset.compensation;
                        if (compensationData && compensationData !== 'null') {
                            try {
                                const data = JSON.parse(compensationData);
                                if (data.ownership_details) {
                                    this.loadDataFromCompensation(data.ownership_details);
                                }
                                // Also load acquisition_record_basis from compensation data
                                if (data.acquisition_record_basis) {
                                    this.acquisition_record_basis = data.acquisition_record_basis;
                                }
                            } catch (error) {
                                console.error('Error parsing compensation data:', error);
                            }
                        }
                    }
                },
                
                // Load acquisition_record_basis from parent form
                loadAcquisitionRecordBasis() {
                    // Try to get acquisition_record_basis from the parent form
                    const form = this.$el.closest('form');
                    if (form) {
                        const acquisitionRecordBasisField = form.querySelector('[name="acquisition_record_basis"]');
                        if (acquisitionRecordBasisField) {
                            this.acquisition_record_basis = acquisitionRecordBasisField.value || 'SA';
                        }
                    }
                },
                
                // Watch for changes in acquisition_record_basis field
                watchAcquisitionRecordBasis() {
                    const form = this.$el.closest('form');
                    if (form) {
                        const acquisitionRecordBasisField = form.querySelector('[name="acquisition_record_basis"]');
                        if (acquisitionRecordBasisField) {
                            // Listen for change events
                            acquisitionRecordBasisField.addEventListener('change', (e) => {
                                this.acquisition_record_basis = e.target.value;
                                console.log('Acquisition record basis changed to:', this.acquisition_record_basis);
                            });
                            
                            // Also listen for input events for real-time updates
                            acquisitionRecordBasisField.addEventListener('input', (e) => {
                                this.acquisition_record_basis = e.target.value;
                            });
                        }
                    }
                },
                
                // Load data from old form (validation errors)
                loadDataFromOldForm(data) {
                    if (data.sa_info) this.sa_info = { ...this.sa_info, ...data.sa_info };
                    if (data.rs_info) {
                        this.rs_info = { ...this.rs_info, ...data.rs_info };
                        // Ensure dp_khatian is properly converted to boolean
                        if (this.rs_info.dp_khatian !== undefined) {
                            this.rs_info.dp_khatian = Boolean(this.rs_info.dp_khatian);
                        }
                    }
                    if (data.applicant_info) this.applicant_info = { ...this.applicant_info, ...data.applicant_info };
                    if (data.sa_owners) this.sa_owners = [...data.sa_owners];
                    if (data.rs_owners) this.rs_owners = [...data.rs_owners];
                    if (data.deed_transfers) this.deed_transfers = [...data.deed_transfers];
                    if (data.inheritance_records) this.inheritance_records = [...data.inheritance_records];
                    if (data.rs_records) {
                        this.rs_records = [...data.rs_records];
                        // Ensure dp_khatian is properly converted to boolean for each RS record
                        this.rs_records.forEach(rs => {
                            if (rs.dp_khatian !== undefined) {
                                rs.dp_khatian = Boolean(rs.dp_khatian);
                            }
                        });
                    }
                    if (data.currentStep) this.currentStep = data.currentStep;
                    if (data.completedSteps) this.completedSteps = [...data.completedSteps];
                    if (data.rs_record_disabled !== undefined) this.rs_record_disabled = data.rs_record_disabled;
                    if (data.acquisition_record_basis) this.acquisition_record_basis = data.acquisition_record_basis;
                    if (data.nextCreationOrder) this.nextCreationOrder = data.nextCreationOrder;
                    
                    // Ensure all existing items have creation orders
                    this.ensureCreationOrders();
                    
                    // Always regenerate story sequence from actual data instead of using stored story sequence
                    // This ensures the correct information is displayed
                    this.generateStorySequence();
                    
                    // Update completed steps after loading data
                    this.updateCompletedSteps();
                },
                
                // Load data from compensation record (edit mode)
                loadDataFromCompensation(data) {
                    if (data.sa_info) this.sa_info = { ...this.sa_info, ...data.sa_info };
                    if (data.rs_info) {
                        this.rs_info = { ...this.rs_info, ...data.rs_info };
                        // Ensure dp_khatian is properly converted to boolean
                        if (this.rs_info.dp_khatian !== undefined) {
                            this.rs_info.dp_khatian = Boolean(this.rs_info.dp_khatian);
                        }
                    }
                    if (data.applicant_info) this.applicant_info = { ...this.applicant_info, ...data.applicant_info };
                    if (data.sa_owners) this.sa_owners = [...data.sa_owners];
                    if (data.rs_owners) this.rs_owners = [...data.rs_owners];
                    if (data.deed_transfers) {
                        this.deed_transfers = [...data.deed_transfers];
                        
                        // Ensure radio button values are properly set
                        this.deed_transfers.forEach((deed, index) => {
                            // Ensure radio button values are strings
                            if (deed.application_type === null || deed.application_type === undefined) {
                                deed.application_type = 'specific';
                            }
                            
                            if (deed.possession_deed === null || deed.possession_deed === undefined) {
                                deed.possession_deed = 'yes';
                            }
                            
                            // Ensure boolean values are converted to strings for radio buttons
                            if (typeof deed.possession_deed === 'boolean') {
                                deed.possession_deed = deed.possession_deed ? 'yes' : 'no';
                            }
                        });
                    }
                    if (data.inheritance_records) {
                        this.inheritance_records = [...data.inheritance_records];
                        
                        // Ensure select dropdown values are properly set
                        this.inheritance_records.forEach((inheritance, index) => {
                            // Ensure has_death_cert has a default value
                            if (inheritance.has_death_cert === null || inheritance.has_death_cert === undefined) {
                                inheritance.has_death_cert = 'yes';
                            }
                            
                            // Convert boolean to string if needed
                            if (typeof inheritance.has_death_cert === 'boolean') {
                                inheritance.has_death_cert = inheritance.has_death_cert ? 'yes' : 'no';
                            }
                        });
                    }
                    if (data.rs_records) {
                        this.rs_records = [...data.rs_records];
                        // Ensure dp_khatian is properly converted to boolean for each RS record
                        this.rs_records.forEach(rs => {
                            if (rs.dp_khatian !== undefined) {
                                rs.dp_khatian = Boolean(rs.dp_khatian);
                            }
                        });
                    }
                    if (data.currentStep) this.currentStep = data.currentStep;
                    if (data.completedSteps) this.completedSteps = [...data.completedSteps];
                    if (data.rs_record_disabled !== undefined) this.rs_record_disabled = data.rs_record_disabled;
                    if (data.acquisition_record_basis) this.acquisition_record_basis = data.acquisition_record_basis;
                    if (data.nextCreationOrder) this.nextCreationOrder = data.nextCreationOrder;
                    
                    // Ensure all existing items have creation orders
                    this.ensureCreationOrders();
                    
                    // Always regenerate story sequence from actual data instead of using stored story sequence
                    // This ensures the correct information is displayed
                    this.generateStorySequence();
                    
                    // Update completed steps after loading data
                    this.updateCompletedSteps();
                },
                
                // Generate story sequence from existing data
                generateStorySequence() {
                    this.storySequence = [];
                    
                    // Create a combined array with all items and their creation order
                    const allItems = [];
                    
                    // Add deed transfers with their creation order
                    this.deed_transfers.forEach((deed, index) => {
                        const hasValue = (value) => value && value.toString().trim() !== '';
                        const deedNumber = hasValue(deed.deed_number) ? deed.deed_number : 'অনির্ধারিত';
                        const deedDate = hasValue(deed.deed_date) ? deed.deed_date : 'অনির্ধারিত';
                        
                        allItems.push({
                            type: 'দলিলমূলে মালিকানা হস্তান্তর',
                            description: `দলিল নম্বর: ${deedNumber}, তারিখ: ${deedDate}`,
                            itemType: 'deed',
                            itemIndex: index,
                            creationOrder: deed.creationOrder || 0
                        });
                    });
                    
                    // Add inheritance records with their creation order
                    this.inheritance_records.forEach((inheritance, index) => {
                        const hasValue = (value) => value && value.toString().trim() !== '';
                        const previousOwner = hasValue(inheritance.previous_owner_name) ? inheritance.previous_owner_name : 'অনির্ধারিত';
                        
                        allItems.push({
                            type: 'ওয়ারিশমূলে হস্তান্তর',
                            description: `পূর্ববর্তী মালিক: ${previousOwner}`,
                            itemType: 'inheritance',
                            itemIndex: index,
                            creationOrder: inheritance.creationOrder || 0
                        });
                    });
                    
                    // Add RS records with their creation order
                    this.rs_records.forEach((rs, index) => {
                        const hasValue = (value) => value && value.toString().trim() !== '';
                        const plotNo = hasValue(rs.plot_no) ? rs.plot_no : 'অনির্ধারিত';
                        
                        allItems.push({
                            type: 'আরএস রেকর্ড যোগ',
                            description: `দাগ নম্বর: ${plotNo}`,
                            itemType: 'rs',
                            itemIndex: index,
                            creationOrder: rs.creationOrder || 0
                        });
                    });
                    
                    // Sort by creation order to maintain the sequence in which items were added
                    allItems.sort((a, b) => a.creationOrder - b.creationOrder);
                    
                    // Add sequence index for display
                    allItems.forEach((item, index) => {
                        item.sequenceIndex = index;
                    });
                    
                    this.storySequence = allItems;
                },
                
                // Get next creation order number
                getNextCreationOrder() {
                    return this.nextCreationOrder++;
                },
                
                // Ensure all existing items have creation orders
                ensureCreationOrders() {
                    // Assign creation orders to deed transfers if they don't have them
                    this.deed_transfers.forEach((deed, index) => {
                        if (deed.creationOrder === undefined) {
                            deed.creationOrder = this.getNextCreationOrder();
                        }
                    });
                    
                    // Assign creation orders to inheritance records if they don't have them
                    this.inheritance_records.forEach((inheritance, index) => {
                        if (inheritance.creationOrder === undefined) {
                            inheritance.creationOrder = this.getNextCreationOrder();
                        }
                    });
                    
                    // Assign creation orders to RS records if they don't have them
                    this.rs_records.forEach((rs, index) => {
                        if (rs.creationOrder === undefined) {
                            rs.creationOrder = this.getNextCreationOrder();
                        }
                    });
                },
                
                // Simple method to update story sequence
                updateStorySequence() {
                    this.generateStorySequence();
                    this.updateCompletedSteps();
                },
                
                // Add new deed transfer
                addDeedTransfer() {
                    const creationOrder = this.getNextCreationOrder();
                    console.log('Adding deed transfer with creation order:', creationOrder);
                    this.deed_transfers.push({
                        donor_names: [{'name': ''}],
                        recipient_names: [{'name': ''}],
                        deed_number: '',
                        deed_date: '',
                        sale_type: '',
                        application_type: 'specific',
                        application_specific_area: '',
                        application_sell_area: '',
                        application_other_areas: '',
                        application_total_area: '',
                        application_sell_area_other: '',
                        possession_deed: 'yes',
                        mentioned_areas: '',
                        special_details: '',
                        tax_info: '',
                        creationOrder: creationOrder
                    });
                    this.updateStorySequence();
                },
                
                // Remove deed transfer
                removeDeedTransfer(index) {
                    this.deed_transfers.splice(index, 1);
                    this.updateStorySequence();
                },
                
                // Add new inheritance record
                addInheritanceRecord() {
                    const creationOrder = this.getNextCreationOrder();
                    console.log('Adding inheritance record with creation order:', creationOrder);
                    this.inheritance_records.push({
                        previous_owner_name: '',
                        has_death_cert: 'yes',
                        heirship_certificate_info: '',
                        creationOrder: creationOrder
                    });
                    this.updateStorySequence();
                },
                
                // Remove inheritance record
                removeInheritanceRecord(index) {
                    this.inheritance_records.splice(index, 1);
                    this.updateStorySequence();
                },
                
                // Add new RS record
                addRsRecord() {
                    const creationOrder = this.getNextCreationOrder();
                    console.log('Adding RS record with creation order:', creationOrder);
                    this.rs_records.push({
                        owner_names: [{'name': ''}],
                        plot_no: '',
                        khatian_no: '',
                        land_amount: '',
                        dp_khatian: false,
                        creationOrder: creationOrder
                    });
                    this.updateStorySequence();
                },
                
                // Remove RS record
                removeRsRecord(index) {
                    this.rs_records.splice(index, 1);
                    this.updateStorySequence();
                },
                
                // Add owner to arrays
                addOwner(array, index) {
                    if (!array[index]) array[index] = [];
                    array[index].push({'name': ''});
                },
                
                // Remove owner from arrays
                removeOwner(array, arrayIndex, ownerIndex) {
                    if (array[arrayIndex] && array[arrayIndex].length > 1) {
                        array[arrayIndex].splice(ownerIndex, 1);
                    }
                },
                
                // Handle application type change
                handleApplicationTypeChange(deed) {
                    if (deed.application_type === 'specific') {
                        deed.application_other_areas = '';
                        deed.application_total_area = '';
                        deed.application_sell_area_other = '';
                    }
                },
                
                // Validate application area fields
                validateApplicationAreaFields(deed) {
                    if (deed.application_type === 'specific') {
                        const specific = parseFloat(deed.application_specific_area) || 0;
                        const sell = parseFloat(deed.application_sell_area) || 0;
                        
                        if (specific > 0 && sell > 0) {
                            deed.application_total_area = (specific + sell).toFixed(2);
                        }
                    }
                },
                
                // Get application area validation status
                getApplicationAreaValidation(deed) {
                    if (!deed.application_type) {
                        return { hasError: false, message: '' };
                    }
                    
                    if (deed.application_type === 'specific') {
                        if (!deed.application_specific_area || !deed.application_sell_area) {
                            return { 
                                hasError: true, 
                                message: 'সুনির্দিষ্ট দাগ এবং বিক্রয়কৃত জমির পরিমাণ প্রয়োজন' 
                            };
                        }
                    } else if (deed.application_type === 'multiple') {
                        if (!deed.application_other_areas || !deed.application_total_area || !deed.application_sell_area_other) {
                            return { 
                                hasError: true, 
                                message: 'বিভিন্ন দাগ, মোট জমির পরিমাণ এবং বিক্রয়কৃত জমির পরিমাণ প্রয়োজন' 
                            };
                        }
                    }
                    
                    return { hasError: false, message: '' };
                },
                
                // Check if step is valid
                isStepValid(step) {
                    switch (step) {
                        case 'info':
                            return this.sa_info.sa_plot_no || this.rs_info.rs_plot_no;
                        case 'transfers':
                            return this.deed_transfers.length > 0 || this.inheritance_records.length > 0 || this.rs_records.length > 0;
                        case 'applicant':
                            return this.applicant_info.applicant_name || this.applicant_info.kharij_case_no;
                        default:
                            return false;
                    }
                },
                
                // Get step status
                getStepStatus(step) {
                    if (this.currentStep === step) return 'current';
                    if (this.isStepValid(step)) return 'completed';
                    return 'pending';
                },
                
                // Navigate to step
                goToStep(step) {
                    if (this.isStepValid(step) || step === 'info') {
                        this.currentStep = step;
                    }
                },
                
                // Get progress width for progress bar
                getProgressWidth() {
                    const totalSteps = 3;
                    const completedCount = this.completedSteps.length;
                    return (completedCount / totalSteps) * 100;
                },
                
                // Get step classes for styling
                getStepClasses(step) {
                    if (this.currentStep === step) {
                        return 'bg-blue-500 text-white shadow-lg scale-110';
                    } else if (this.isStepValid(step)) {
                        return 'bg-green-500 text-white shadow-md cursor-pointer';
                    } else {
                        return 'bg-gray-300 text-gray-600 cursor-not-allowed';
                    }
                },
                
                // Update completed steps based on current data
                updateCompletedSteps() {
                    this.completedSteps = [];
                    if (this.isStepValid('info')) this.completedSteps.push('info');
                    if (this.isStepValid('transfers')) this.completedSteps.push('transfers');
                    if (this.isStepValid('applicant')) this.completedSteps.push('applicant');
                },
                
                // Add SA owner
                addSaOwner() {
                    this.sa_owners.push({'name': ''});
                },
                
                // Remove SA owner
                removeSaOwner(index) {
                    if (this.sa_owners.length > 1) {
                        this.sa_owners.splice(index, 1);
                    }
                },
                
                // Add RS owner
                addRsOwner() {
                    this.rs_owners.push({'name': ''});
                },
                
                // Remove RS owner
                removeRsOwner(index) {
                    if (this.rs_owners.length > 1) {
                        this.rs_owners.splice(index, 1);
                    }
                },
                
                // Add deed donor
                addDeedDonor(deedIndex) {
                    this.deed_transfers[deedIndex].donor_names.push({'name': ''});
                },
                
                // Remove deed donor
                removeDeedDonor(deedIndex, donorIndex) {
                    if (this.deed_transfers[deedIndex].donor_names.length > 1) {
                        this.deed_transfers[deedIndex].donor_names.splice(donorIndex, 1);
                    }
                },
                
                // Add deed recipient
                addDeedRecipient(deedIndex) {
                    this.deed_transfers[deedIndex].recipient_names.push({'name': ''});
                },
                
                // Remove deed recipient
                removeDeedRecipient(deedIndex, recipientIndex) {
                    if (this.deed_transfers[deedIndex].recipient_names.length > 1) {
                        this.deed_transfers[deedIndex].recipient_names.splice(recipientIndex, 1);
                    }
                },
                
                // Add RS record owner
                addRsRecordOwner(rsIndex) {
                    this.rs_records[rsIndex].owner_names.push({'name': ''});
                },
                
                // Remove RS record owner
                removeRsRecordOwner(rsIndex, ownerIndex) {
                    if (this.rs_records[rsIndex].owner_names.length > 1) {
                        this.rs_records[rsIndex].owner_names.splice(ownerIndex, 1);
                    }
                },
                
                // Remove story item
                removeStoryItem(index) {
                    const item = this.storySequence[index];
                    
                    if (item) {
                        // Remove from the corresponding data array based on item type
                        if (item.itemType === 'deed' && typeof item.itemIndex === 'number') {
                            // Remove deed transfer
                            if (this.deed_transfers[item.itemIndex]) {
                                this.deed_transfers.splice(item.itemIndex, 1);
                                console.log(`Removed deed transfer at index ${item.itemIndex}`);
                            }
                        } else if (item.itemType === 'inheritance' && typeof item.itemIndex === 'number') {
                            // Remove inheritance record
                            if (this.inheritance_records[item.itemIndex]) {
                                this.inheritance_records.splice(item.itemIndex, 1);
                                console.log(`Removed inheritance record at index ${item.itemIndex}`);
                            }
                        } else if (item.itemType === 'rs' && typeof item.itemIndex === 'number') {
                            // Remove RS record
                            if (this.rs_records[item.itemIndex]) {
                                this.rs_records.splice(item.itemIndex, 1);
                                console.log(`Removed RS record at index ${item.itemIndex}`);
                            }
                        }
                        
                        // Remove from story sequence
                        this.storySequence.splice(index, 1);
                        
                        // Regenerate story sequence to update indices and maintain order
                        this.generateStorySequence();
                        
                        // Update completed steps
                        this.updateCompletedSteps();
                        
                        console.log('Story item removed and data arrays updated');
                    }
                },
                
                // Scroll to story item
                scrollToStoryItem(item) {
                    // Implementation for scrolling to specific form sections
                    console.log('Scrolling to:', item);
                },
                
                // Navigation methods
                nextStep() {
                    if (this.currentStep === 'info' && this.isStep1Valid()) {
                        this.currentStep = 'transfers';
                    } else if (this.currentStep === 'transfers') {
                        this.currentStep = 'applicant';
                    }
                    this.updateCompletedSteps();
                },
                
                prevStep() {
                    if (this.currentStep === 'applicant') {
                        this.currentStep = 'transfers';
                    } else if (this.currentStep === 'transfers') {
                        this.currentStep = 'info';
                    }
                },
                
                // Step validation
                isStep1Valid() {
                    return this.isStepValid('info');
                },
                
                // Get current step text
                getCurrentStepText() {
                    const stepTexts = {
                        'info': 'ধাপ ১: SA/RS রেকর্ডের বর্ণনা',
                        'transfers': 'ধাপ ২: হস্তান্তর ও রেকর্ড',
                        'applicant': 'ধাপ ৩: আবেদনকারীর খারিজ ও খাজনা'
                    };
                    return stepTexts[this.currentStep] || '';
                },
                
                // Save step data
                saveStepData() {
                    // Save current step data to localStorage or send to server
                    localStorage.setItem('ownershipContinuityData', JSON.stringify({
                        sa_info: this.sa_info,
                        rs_info: this.rs_info,
                        applicant_info: this.applicant_info,
                        sa_owners: this.sa_owners,
                        rs_owners: this.rs_owners,
                        deed_transfers: this.deed_transfers,
                        inheritance_records: this.inheritance_records,
                        rs_records: this.rs_records,
                        storySequence: this.storySequence,
                        currentStep: this.currentStep,
                        completedSteps: this.completedSteps,
                        rs_record_disabled: this.rs_record_disabled,
                        nextCreationOrder: this.nextCreationOrder
                    }));
                    
                    this.showAlert('success', 'বর্তমান ধাপের তথ্য সংরক্ষণ করা হয়েছে');
                },
                
                // Save all data
                saveAllData() {
                    // Save all data to localStorage or send to server
                    localStorage.setItem('ownershipContinuityData', JSON.stringify({
                        sa_info: this.sa_info,
                        rs_info: this.rs_info,
                        applicant_info: this.applicant_info,
                        sa_owners: this.sa_owners,
                        rs_owners: this.rs_owners,
                        deed_transfers: this.deed_transfers,
                        inheritance_records: this.inheritance_records,
                        rs_records: this.rs_records,
                        storySequence: this.storySequence,
                        currentStep: this.currentStep,
                        completedSteps: this.completedSteps,
                        rs_record_disabled: this.rs_record_disabled,
                        nextCreationOrder: this.nextCreationOrder
                    }));
                    
                    this.showAlert('success', 'সব তথ্য সফলভাবে সংরক্ষণ করা হয়েছে');
                },
                
                // Alert system
                showAlert(type, message) {
                    this.alert = { type, message, show: true };
                    setTimeout(() => this.hideAlert(), 5000);
                },
                
                hideAlert() {
                    this.alert.show = false;
                },
                
                // Format number input (Bengali and English numbers)
                formatNumberInput(value, target = null) {
                    if (!value) return '';
                    
                    // Convert Bengali numbers to English
                    const bengaliToEnglish = {
                        '০': '0', '১': '1', '২': '2', '৩': '3', '৪': '4',
                        '৫': '5', '৬': '6', '৭': '7', '৮': '8', '৯': '9'
                    };
                    
                    let formatted = value.toString();
                    Object.keys(bengaliToEnglish).forEach(bengali => {
                        formatted = formatted.replace(new RegExp(bengali, 'g'), bengaliToEnglish[bengali]);
                    });
                    
                    // Remove any non-numeric characters except decimal point
                    formatted = formatted.replace(/[^0-9.]/g, '');
                    
                    // Ensure only one decimal point
                    const parts = formatted.split('.');
                    if (parts.length > 2) {
                        formatted = parts[0] + '.' + parts.slice(1).join('');
                    }
                    
                    if (target) {
                        target.value = formatted;
                    }
                    
                    return formatted;
                }
            }));
            console.log('ownershipContinuity component registered successfully');
        } else {
            // Alpine.js not ready yet, retry after a short delay
            setTimeout(initOwnershipContinuity, 100);
        }
    }

    // Try multiple initialization approaches
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initOwnershipContinuity);
    } else {
        initOwnershipContinuity();
    }
    
    // Also try when Alpine is ready
    document.addEventListener('alpine:init', initOwnershipContinuity);
})();