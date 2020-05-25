<template>
    <div id="editjob">
        <span v-show="updatedStatus == 2">{{ updateSuccessText }}</span>

        <form @submit.prevent="updateJob()">
            <div class="card">
                <div class="card-header">
                    <h3>Edit Job Post</h3>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-xs-12 col-md-6">
                            <label for="companyName">Company Name</label>
                            <input type="text" 
                                class="form-control" 
                                id="companyName" 
                                v-model="companyName" 
                                v-on:keyup="searchCompanies()"
                            />
                            <span class="validation" v-show="!validations.companyName.is_valid">
                                {{ validations.companyName.text }}
                            </span>
                            <input type="hidden" v-model="companyID"/>
                            <div class="company-autocomplete-container" 
                                v-show="companyName.length > 0 && showAutoComplete"
                            >
                                <div class="company-autocomplete" 
                                    v-for="companyResult in companyResults" 
                                    v-bind:key="companyResult.id" 
                                    v-on:click="selectCompany( companyResult )"
                                >
                                    <span class="company-name">{{ companyResult.name }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-xs-12 col-md-6">
                            <label for="jobType">Job Type</label>
                            <input type="text" 
                                class="form-control" 
                                id="jobType" 
                                v-model="jobTypeName" 
                                v-on:keyup="searchJobTypes()"
                            />
                            <span class="validation" v-show="!validations.jobTypeName.is_valid">
                                {{ validations.jobTypeName.text }}
                            </span>
                            <input type="hidden" v-model="jobTypeID"/>
                            <div class="company-autocomplete-container" 
                                v-show="jobTypeName.length > 0 && showAutoComplete"
                            >
                                <div class="company-autocomplete" 
                                    v-for="jobTypeResult in jobTypeResults" 
                                    v-bind:key="jobTypeResult.id" 
                                    v-on:click="selectJobType( jobTypeResult )"
                                >
                                    <span class="company-name">{{ jobTypeResult.name }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-xs-12 col-md-6">
                            <label for="jobField">Job Field</label>
                            <input type="text" 
                                class="form-control" 
                                id="jobField" 
                                v-model="jobFieldName" 
                                v-on:keyup="searchJobFields()"
                            />
                            <span class="validation" v-show="!validations.jobFieldName.is_valid">
                                {{ validations.jobFieldName.text }}
                            </span>
                            <input type="hidden" v-model="jobFieldID"/>
                            <div class="company-autocomplete-container" 
                                v-show="jobFieldName.length > 0 && showAutoComplete"
                            >
                                <div class="company-autocomplete" 
                                    v-for="jobFieldResult in jobFieldResults" 
                                    v-bind:key="jobFieldResult.id" 
                                    v-on:click="selectJobField( jobFieldResult )"
                                >
                                    <span class="company-name">{{ jobFieldResult.name }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-xs-12 col-md-6">
                            <label for="jobTitle">Job Title</label>
                            <input type="text" 
                                class="form-control" 
                                id="jobTitle" 
                                v-model="job_title" 
                                placeholder="Example input"
                            >
                            <span class="validation" v-show="!validations.job_title.is_valid">
                                {{ validations.job_title.text }}
                            </span>
                        </div>
                        <div class="form-group col-xs-12 col-md-12">
                            <label for="jobDescription">Job Description</label>
                            <textarea v-model="job_description" 
                                id="jobDescription" 
                                class="form-control" 
                                cols="30" rows="10">
                            </textarea>
                            <span class="validation" v-show="!validations.job_description.is_valid">
                                {{ validations.job_description.text }}
                            </span>
                        </div>
                        <div class="form-group col-xs-12 col-md-6">
                            <label for="jobLocation">Job Location</label>
                            <input type="text" 
                                class="form-control" 
                                id="jobLocation" 
                                v-model="job_location" 
                                placeholder="Enter Job Location"
                            >
                            <span class="validation" v-show="!validations.job_location.is_valid">
                                {{ validations.job_location.text }}
                            </span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="salary">Salary</label>
                            <input type="text" 
                                class="form-control" 
                                id="salary" 
                                v-model="salary" 
                                placeholder="Enter Gross salary"
                            />
                        </div>
                        <div class="form-group col-md-6">
                            <label for="applicationEmail">Application Email</label>
                            <input type="email" 
                                class="form-control" 
                                id="applicationEmail" 
                                v-model="application_email" 
                                placeholder="Enter application email"
                            />
                        </div>
                        <div class="form-group col-md-6">
                            <label for="applicationLink">Application Link</label>
                            <input type="text" 
                                class="form-control" 
                                id="applicationLink" 
                                v-model="application_link" 
                                placeholder="Enter career website"
                            />
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary">Update Post</button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
 /*
        Imports lodash for debouncing
    */
    import _ from 'lodash';
    /*
        Imports the config for the API URL for searching companies.
    */
    import { FS_CONFIG } from '../../config';
    import { authHeader } from '../../authHelper';
    import { EventBus } from '../../event-bus.js';

    export default {
        data:() => ({
            showAutoComplete: true,
            companyResults: [],
            jobTypeResults: [],
            jobFieldResults: [],
            companyName: '',
            companyID: '',
            jobTypeName: '',
            jobTypeID: '',
            jobFieldName: '',
            jobFieldID: '',
            job_title: '',
            job_description: '',
            job_location: '',
            salary: '',
            application_email: '',
            application_link: '',
            validations: {
                companyName: {
                    is_valid: true,
                    text: ''
                },
                jobTypeName: {
                    is_valid: true,
                    text: ''
                },
                jobFieldName: {
                    is_valid: true,
                    text: ''
                },
                job_title: {
                    is_valid: true,
                    text: ''
                },
                job_location: {
                    is_valid: true,
                    text: ''
                },
                job_description: {
                    is_valid: true,
                    text: ''
                }
            }
        }),
        /* When component is mounted load job data */
        mounted() {
            this.$store.dispatch('loadJob',{
                id: this.$route.params.id
            })
        },
        methods: {
            populateForm() {
                this.companyName = this.job.company.name;
                this.jobTypeName = this.job.job_type.name;
                this.jobFieldName = this.job.job_field.name;
                this.companyID = this.job.company.id;
                this.jobTypeID = this.job.job_type.id;
                this.jobFieldID = this.job.job_field.id;
                this.job_title = this.job.job_title;
                this.job_location = this.job.job_location;
                this.job_description = this.job.job_description;
                this.salary = this.job.salary;
                this.application_email = this.job.application_email;
                this.application_link = this.job.application_link;
            },
            /*
                Searches the API route for companies
            */
            searchCompanies: _.debounce( function(e) {
                /*
                Ensures something is entered before searching companies.
                */
                if( this.companyName.length > 1){
                    this.showAutocomplete = true;
                    const requestOptions = {
                        headers: { ...authHeader()},
                        params: {
                            search: this.companyName
                        },
                    };
                    axios.get( FS_CONFIG.API_URL + '/companies/search' , requestOptions
                    ).then( function( response ){
                        this.companyResults = response.data.companies;
                    }.bind(this));
                }
            }, 100),
            searchJobTypes: _.debounce( function(e) {
                /*
                Ensures something is entered before searching companies.
                */
                if( this.jobTypeName.length > 1){
                    this.showAutocomplete = true;
                    const requestOptions = {
                        headers: { ...authHeader()},
                        params: {
                            search: this.jobTypeName
                        },
                    };
                    axios.get( FS_CONFIG.API_URL + '/jobtypes/search' , requestOptions
                    ).then( function( response ){
                        this.jobTypeResults = response.data.jobtypes;
                    }.bind(this));
                }
            }, 100),
            searchJobFields: _.debounce( function(e) {
                /*
                Ensures something is entered before searching companies.
                */
                if( this.jobFieldName.length > 1){
                    this.showAutocomplete = true;
                    const requestOptions = {
                        headers: { ...authHeader()},
                        params: {
                            search: this.jobFieldName
                        },
                    };
                    axios.get( FS_CONFIG.API_URL + '/jobfields/search' , requestOptions
                    ).then( function( response ){
                        this.jobFieldResults = response.data.jobfields;
                    }.bind(this));
                }
            }, 100),
            /*
                Selects an existing company
            */
            selectCompany( company ){
                this.showAutocomplete = false;
                this.companyName = company.name;
                this.companyID = company.id;
                this.companyResults = [];
            },
            selectJobType( jobtype ){
                this.showAutocomplete = false;
                this.jobTypeName = jobtype.name;
                this.jobTypeID = jobtype.id;
                this.jobTypeResults = [];
            },
            selectJobField( jobfield ){
                this.showAutocomplete = false;
                this.jobFieldName = jobfield.name;
                this.jobFieldID = jobfield.id;
                this.jobFieldResults = [];
            },
            /*
                Submits edits for a cafe
            */
            updateJob(){
                if( this.validateEdit() ){
                    this.$store.dispatch( 'updateJob', {
                        id: this.job.id,
                        company_id: this.companyID,
                        job_type_id: this.jobTypeID,
                        job_field_id: this.jobFieldID,
                        job_title: this.job_title,
                        job_description: this.job_description,
                        job_location: this.job_location,
                        salary: this.salary,
                        application_email: this.application_email,
                        application_link: this.application_link,
                        status: this.status
                    });
                }
            },
             validateEdit() {
                let validEditForm = true;

                /*
                Ensure a title has been entered
                */
                if( this.job_title.trim() == '' ){
                    validEditForm = false;
                    this.validations.job_title.is_valid = false;
                    this.validations.job_title.text = 'Please enter a job title for the new job!';
                }else{
                    this.validations.job_title.is_valid = true;
                    this.validations.job_title.text = '';
                }

                /*
                Ensure a description has been entered
                */
                if( this.job_description.trim() == '' ){
                    validEditForm = false;
                    this.validations.job_description.is_valid = false;
                    this.validations.job_description.text = 'Please enter a job description for the new job!';
                }else{
                    this.validations.job_description.is_valid = true;
                    this.validations.job_description.text = '';
                }

                /*
                Ensure a location has been entered
                */
                if( this.job_location.trim() == '' ){
                    validEditForm = false;
                    this.validations.job_location.is_valid = false;
                    this.validations.job_location.text = 'Please enter a location for the new job!';
                }else{
                    this.validations.job_description.is_valid = true;
                    this.validations.job_description.text = '';
                }

                /*
                Ensure a company has been entered
                */
                if( this.companyName.trim() == '' ){
                    validEditForm = false;
                    this.validations.companyName.is_valid = false;
                    this.validations.companyName.text = 'Please enter a company for the new job!';
                }else{
                    this.validations.companyName.is_valid = true;
                    this.validations.companyName.text = '';
                }

                /*
                Ensure a job type has been entered
                */
                if( this.jobTypeName.trim() == '' ){
                    validEditForm = false;
                    this.validations.jobTypeName.is_valid = false;
                    this.validations.jobTypeName.text = 'Please enter a job type for the new job!';
                }else{
                    this.validations.jobTypeName.is_valid = true;
                    this.validations.jobTypeName.text = '';
                }

                /*
                Ensure a job field has been entered
                */
                if( this.jobFieldName.trim() == '' ){
                    validEditForm = false;
                    this.validations.jobFieldName.is_valid = false;
                    this.validations.jobFieldName.text = 'Please enter a job field for the new job!';
                }else{
                    this.validations.jobFieldName.is_valid = true;
                    this.validations.jobFieldName.text = '';
                }

                return validEditForm;
            },
        },
        computed: {
            jobLoadStatus() {
                return this.$store.getters.getEditJobLoadStatus;
            },
            job() {
                return this.$store.getters.getEditJob;
            },
            updatedStatus() {
                return this.$store.getters.getUpdatedJobStatus;
            },
            updateSuccessText() {
                return this.$store.getters.getUpdatedJobText;
            }
        },

        //Defines actions to watch as page loads
        watch: {
            'updatedStatus': function(){
                if( this.updatedStatus == 2 ){
                    EventBus.$emit('show-success', {
                        notification: this.updateSuccessText
                    });
                    setTimeout(() => {
                        this.$router.push({ name: 'unverifiedjobs' });
                    }, 700)
                }
            },
            'jobLoadStatus': function(){
                if( this.jobLoadStatus == 2 ){
                this.populateForm();
                }
            }
        },
    }
</script>

<style scoped>
    #editjob {
        margin: 20px;
    }
    span.validation {
        font-size: 11px;
        color: #e3342f;
    }
    .card-header {
        background-color: rgb(182, 213, 239);
    }
    .card-header h3 {
        margin-top: 0.5rem;
    }
    label {
        color: grey;
    }
    .company-autocomplete {
        color:brown;
        cursor: pointer;
        border: 1px solid #dee2e6;
        border-radius: 5%;
        font-weight: 600;
        height: auto;
        max-height: 100px;
        overflow: auto;
    }
</style>