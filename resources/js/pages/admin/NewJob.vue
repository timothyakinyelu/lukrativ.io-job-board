<template>
    <div id="newjob">
        <span v-show="jobAddStatus == 2">{{ jobAddedText }}</span>

        <form @submit.prevent="submitNewPost()">
            <div class="card">
                <div class="card-header">
                    <h3>New Job Post</h3>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-xs-12 col-md-6">
                            <div class="centered company-selection-container">
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
                                    v-show="companyName.length > 0 && showAutocomplete"
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
                                v-show="jobTypeName.length > 0 && showAutocomplete"
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
                                v-show="jobFieldName.length > 0 && showAutocomplete"
                            >
                                <div class="company-autocomplete" v-for="jobFieldResult in jobFieldResults"
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
                            />
                            <span class="validation" v-show="!validations.job_title.is_valid">
                                {{ validations.job_title.text }}
                            </span>
                        </div>
                        <div class="form-group col-xs-12 col-md-12">
                            <label for="jobDescription">Job Description</label>
                            <textarea v-model="job_description" 
                                id="jobDescription" 
                                class="form-control" 
                                cols="30" 
                                rows="10"
                            >
                            </textarea>
                            <span class="validation" v-show="!validations.job_description.is_valid">
                                {{ validations.job_description.text }}
                            </span>
                        </div>
                        <div class="form-group col-xs-12 col-md-12">
                            <label for="qualifications">Qualifications</label>
                            <textarea v-model="qualifications" 
                                id="qualifications" 
                                class="form-control" 
                                cols="30" 
                                rows="10"
                            >
                            </textarea>
                        </div>
                        <div class="form-group col-xs-12 col-md-12">
                            <label for="competencies">Competencies</label>
                            <textarea v-model="competencies" 
                                id="competencies" 
                                class="form-control" 
                                cols="30" 
                                rows="10"
                            >
                            </textarea>
                        </div>
                        <div class="form-group col-xs-12 col-md-6">
                            <label for="jobLocation">Job Location</label>
                            <input type="text" 
                                class="form-control" 
                                id="jobLocation" 
                                v-model="job_location" 
                                placeholder="Enter Job Location"
                            />
                            <span class="validation" v-show="!validations.job_location.is_valid">
                                {{ validations.job_location.text }}
                            </span>
                        </div>
                        <div class="form-group col-xs-12 col-md-6">
                            <label for="salary">Salary</label>
                            <input type="text" 
                                class="form-control" 
                                id="salary" 
                                v-model="salary" 
                                placeholder="Enter Gross salary"
                            />
                        </div>
                        <div class="form-group col-xs-12 col-md-6">
                            <label for="applicationEmail">Application Email</label>
                            <input type="email" 
                                class="form-control" 
                                id="applicationEmail" 
                                v-model="application_email" 
                                placeholder="Enter application email"
                            />
                        </div>
                        <div class="form-group col-xs-12 col-md-6">
                            <label for="applicationLink">Application Link</label>
                            <input type="url" id="applicationLink"
                                class="form-control"
                                v-model="application_link"
                                placeholder="http://example.com"
                                pattern="http://.*" size="30"
                            />
                        </div>
                        <div class="form-group col-xs-12 col-md-6">
                            <label for="applicationDeadline">Application Deadline</label>
                            <input type="date" id="applicationDeadline"
                                class="form-control"
                                v-model="closing_date"
                                placeholder="Enter date"
                            />
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary">Add Post</button>
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
            showAutocomplete: true,
            companyName: '',
            companyID: '',
            companyResults: [],
            jobTypeName: '',
            jobTypeID: '',
            jobTypeResults: [],
            jobFieldName: '',
            jobFieldID: '',
            jobFieldResults: [],
            job_title: '',
            job_description: '',
            qualifications: '',
            competencies: '',
            job_location: '',
            salary: '',
            application_link: '',
            application_email: '',
            closing_date: '',
            validations: {
                job_title: {
                    is_valid: true,
                    text: ''
                },
                job_description: {
                    is_valid: true,
                    text: ''
                },
                job_location: {
                    is_valid: true,
                    text: ''
                },
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
                }
            }
        }),
        methods: {
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
            }),
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
            }),
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
            }),
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
            submitNewPost() {
                if(this.validateNewPost()) {
                    this.$store.dispatch('addJob', {
                        company_id: this.companyID,
                        job_type_id: this.jobTypeID,
                        job_field_id: this.jobFieldID,
                        job_title: this.job_title,
                        job_description: this.job_description,
                        qualifications: this.qualifications,
                        competencies: this.competencies,
                        job_location: this.job_location,
                        salary: this.salary,
                        application_email: this.application_email,
                        application_link: this.application_link,
                        closing_date: this.closing_date
                    });
                };
            },
            validateNewPost() {
                let validNewPostForm = true;

                /*
                Ensure a title has been entered
                */
                if( this.job_title.trim() == '' ){
                    validNewPostForm = false;
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
                    validNewPostForm = false;
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
                    validNewPostForm = false;
                    this.validations.job_location.is_valid = false;
                    this.validations.job_location.text = 'Please enter a location for the new job!';
                }else{
                    this.validations.job_location.is_valid = true;
                    this.validations.job_location.text = '';
                }

                /*
                Ensure a company has been entered
                */
                if( this.companyName.trim() == '' ){
                    validNewPostForm = false;
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
                    validNewPostForm = false;
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
                    validNewPostForm = false;
                    this.validations.jobFieldName.is_valid = false;
                    this.validations.jobFieldName.text = 'Please enter a job field for the new job!';
                }else{
                    this.validations.jobFieldName.is_valid = true;
                    this.validations.jobFieldName.text = '';
                }

                return validNewPostForm;
            },
            clearForm(){
                this.companyName = '';
                this.companyID = '';
                this.jobTypeName = '';
                this.jobTypeID = '';
                this.jobFieldName = '';
                this.jobFieldID = '';
                this.job_title = '';
                this.job_description = '';
                this.job_location = '';
                this.salary = '';
                this.application_email = '';
                this.application_link = '';
                this.closing_date = '';
                this.validations = {
                    job_title: {
                        is_valid: true,
                        text: ''
                    },
                    job_description: {
                        is_valid: true,
                        text: ''
                    },
                    job_location: {
                        is_valid: true,
                        text: ''
                    },
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
                    }
                };
            }
        },
        computed: {
            /*
                Gets the job load status
            */
            jobAddStatus() {
                return this.$store.getters.getJobAddedStatus;
            },
            jobAddedText() {
                return this.$store.getters.getJobAddedText;
            }
        },
        watch: {
            'jobAddStatus': function(){
                if( this.jobAddStatus == 2 ){
                    this.clearForm();
                    EventBus.$emit('show-success', {
                        notification: this.jobAddedText
                    });
                }

                if( this.jobAddStatus == 3 ){
                    $("#there-was-a-problem-adding-job").show().delay(5000).fadeOut();
                }
            }
        },
    
    }
</script>

<style scoped>
    #newjob {
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
    .company-autocomplete-container {
        max-height: 100px;
        border: 1px solid #dee2e6;
        border-radius: 5%;
        overflow: auto;
    }
</style>