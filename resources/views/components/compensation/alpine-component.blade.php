<script defer>
    document.addEventListener('alpine:init', () => {
        window.compensationForm = () => ({
            applicants: [],
            is_sa_owner: 'yes',
            ownership_type: 'deed',
            is_heir_applicant: 'yes',
            deed_transfers: [],
            inheritance_details: {},
            mutation_records: [],
            distribution_records: [],
            no_claim_type: 'donor',
            field_investigation_info: '',
            submitted_docs: [],
            inheritance_records: [],
            
            init() {
                // Get compensation data from data attribute if editing
                const compensationData = this.$el.dataset.compensation;
                if (compensationData && compensationData !== 'null') {
                    const data = JSON.parse(compensationData);
                    this.applicants = data.applicants || [{ name: '', father_name: '', address: '', nid: '' }];
                    this.is_sa_owner = data.is_applicant_sa_owner ? 'yes' : 'no';
                    this.ownership_type = data.ownership_details?.ownership_type || 'deed';
                    this.is_heir_applicant = data.ownership_details?.inheritance?.is_heir_applicant || 'yes';
                    this.deed_transfers = data.ownership_details?.deed_transfers || [];
                    this.inheritance_details = data.ownership_details?.inheritance || {};
                    this.inheritance_records = data.ownership_details?.inheritance_records || [];
                    this.mutation_records = data.mutation_info?.records || [];
                    this.distribution_records = data.additional_documents_info?.distribution_records || [];
                    this.no_claim_type = data.additional_documents_info?.no_claim_type || 'donor';
                    this.field_investigation_info = data.additional_documents_info?.field_investigation_info || '';
                    this.submitted_docs = data.additional_documents_info?.submitted_docs || [];
                } else {
                    // Initialize with default values for new form
                    this.applicants = [{ name: '', father_name: '', address: '', nid: '' }];
                    this.deed_transfers = [{ 
                        donor_name: '', recipient_name: '', deed_number: '', deed_date: '', 
                        sale_type: '', plot_no: '', sold_land_amount: '', total_sotangsho: '', 
                        total_shotok: '', possession_mentioned: 'yes', possession_plot_no: '', 
                        possession_description: '', mutation_case_no: '', mutation_plot_no: '', 
                        mutation_land_amount: '' 
                    }];
                    this.inheritance_records = [{
                        is_heir_applicant: 'yes',
                        has_death_cert: 'yes',
                        heirship_certificate_info: '',
                        previous_owner_name: '',
                        death_date: '',
                        inheritance_type: 'direct'
                    }];
                    this.mutation_records = [{ khatian_no: '', case_no: '', plot_no: '', land_amount: '' }];
                    this.distribution_records = [{ details: '' }];
                    this.inheritance_details = {
                        is_heir_applicant: 'yes',
                        has_death_cert: 'yes',
                        heirship_certificate_info: ''
                    };
                }
            },
            
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
            addInheritanceRecord() {
                this.inheritance_records.push({
                    is_heir_applicant: 'yes',
                    has_death_cert: 'yes',
                    heirship_certificate_info: '',
                    previous_owner_name: '',
                    death_date: '',
                    inheritance_type: 'direct'
                });
            },
            removeInheritanceRecord(index) {
                this.inheritance_records.splice(index, 1);
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