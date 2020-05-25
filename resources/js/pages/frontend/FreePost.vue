<template>
    <div>
        <span v-show="jobSubmittedStatus == 2">{{ jobSubmittedText }}</span>
        <section class="post-form-pg container-fluid" style="margin-top: 25px;">
            <div class="jumbotron">
                <img src="/images/apple-click-connection-392018.jpg" alt="apple-click">
                <div class="jumbotron-text">
                    <h1>Post Jobs for FREE</h1>
                    <p id="fs-text">Access a huge, diverse set of job seekers with every posting.</p>
                    <p id="fs-snd-text">We verify every job posted on this platform because 
                        we believe in listing only quality and verified jobs.
                    </p>
                </div>
            </div>
            <div class="forms">
                <form id="form1" @submit.prevent="postJob()" class="needs-validation">
                    <div class="form-row">
                        <div id="comp_dits" class="col-xs-12 col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Company Details</h5>
                                </div>
                                <div class="card-body">
                                    <div id="inner-form" class="form-group row">
                                        <label for="companyName" 
                                            class="col-sm-3 col-form-label"
                                        >
                                            Company Name
                                        </label>
                                        <div class="col-sm-8">
                                            <input type="text" 
                                                class="form-control" 
                                                id="companyName" 
                                                v-model="companyName" 
                                                v-on:keyup="searchCompanies()"
                                            />
                                            <span class="validation" 
                                                v-if="!validations.companyName.is_valid"
                                            >
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
                                                    <span class="company-name">
                                                        {{ companyResult.name }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="inner-form" class="form-group row">
                                        <label for="about_company" class="col-sm-3 col-form-label">Employer Brand</label>
                                        <div class="col-sm-8">
                                            <textarea v-model="about" class="form-control" cols="30" rows="3"></textarea>
                                            <span class="info">Good but not required.</span>
                                        </div>
                                    </div>
                                    <div id="inner-form" class="form-group row">
                                        <label for="company_address" 
                                            class="col-sm-3 col-form-label"
                                        >
                                            Company Address
                                        </label>
                                        <div class="col-sm-8">
                                            <input type="text" 
                                                class="form-control" 
                                                d="inputCompanyAddress" 
                                                v-model="address"
                                            />
                                            <span class="info">If a job has been posted here before, 
                                                please leave blank.
                                            </span>
                                        </div>
                                    </div>
                                    <div id="inner-form" class="form-group row">
                                        <label for="company_website" 
                                            class="col-sm-3 col-form-label"
                                        >
                                            Company Website
                                        </label>
                                        <div class="col-sm-8">
                                            <input type="url" 
                                                class="form-control" 
                                                id="inputCompanyWebsite" 
                                                v-model="website"
                                                placeholder="http://example.com"
                                            />
                                            <span class="info">If available.</span>
                                        </div>
                                    </div>
                                    <div id="inner-form" class="form-group row">
                                        <label for="contact_number" 
                                            class="col-sm-3 col-form-label"
                                        >
                                            Contact Number
                                        </label>
                                        <div class="col-sm-8">
                                            <input type="text" 
                                                class="form-control" 
                                                id="inputContactNumber" 
                                                v-model="contact_number"
                                            />
                                            <span v-if="validations.job_title.is_valid"
                                                class="info"
                                            >
                                                For verification purposes only, 
                                                will not be disclosed.
                                            </span>
                                            <span class="validation" 
                                                v-if="!validations.job_title.is_valid"
                                            >
                                                {{ validations.job_title.text }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="job_dit" class="col-xs-12 col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Job Details</h5>
                                </div>
                                <div class="card-body">
                                    <div id="inner-form" class="form-group row">
                                        <label for="job_title" 
                                            class="col-sm-3 col-form-label"
                                        >
                                            Job Title
                                        </label>
                                        <div class="col-sm-8">
                                            <input type="text" 
                                                class="form-control" 
                                                id="inputJobTitle" 
                                                v-model="job_title" 
                                            
                                            />
                                            <span class="validation" 
                                                v-if="!validations.job_title.is_valid">
                                                {{ validations.job_title.text }}
                                            </span>
                                        </div>
                                    </div>
                                    <div id="inner-form" class="form-group row">
                                        <label for="job_description" 
                                            class="col col-form-label"
                                        >
                                            Job Description(including competencies, qualifications 
                                            & method of application)
                                        </label>
                                        <div class="col-sm-11">
                                            <textarea v-model="job_description" 
                                                class="form-control" 
                                                cols="30" 
                                                rows="6" 
                                            >
                                            </textarea>
                                            <span class="validation" 
                                                v-if="!validations.job_description.is_valid"
                                            >
                                                {{ validations.job_description.text }}
                                            </span>
                                        </div>
                                    </div>
                                    <div id="inner-form" class="form-group row">
                                        <label for="job_location" 
                                            class="col-sm-3 col-form-label"
                                        >
                                            Job Location
                                        </label>
                                        <div class="col-sm-8">
                                            <input type="text" 
                                                class="form-control" 
                                                id="inputJobLocation" 
                                                v-model="job_location"
                                                
                                            />
                                            <span class="validation" 
                                                v-if="!validations.job_location.is_valid"
                                            >
                                                {{ validations.job_location.text }}
                                            </span>
                                        </div>
                                    </div>
                                    <div id="inner-form" class="form-group row">
                                        <label for="job_salary" 
                                            class="col-sm-3 col-form-label"
                                        >
                                            Salary/Salary Range
                                        </label>
                                        <div class="col-sm-8">
                                            <input type="text" 
                                                class="form-control" 
                                                id="inputJobSalary" 
                                                v-model="salary"
                                            />
                                            <span class="info">
                                                Time to fill usually lower if this is included.
                                            </span>
                                        </div>
                                    </div>
                                    <div id="inner-form" class="form-group row">
                                        <label for="application_email" 
                                            class="col-sm-3 col-form-label"
                                        >
                                            Application Email
                                        </label>
                                        <div class="col-sm-8">
                                            <input type="email" 
                                                class="form-control" 
                                                id="inputApplicationEmail" 
                                                v-model="application_email"
                                            />
                                        </div>
                                    </div>
                                    <div id="inner-form" class="form-group row">
                                        <label for="application_link" 
                                            class="col-sm-3 col-form-label"
                                        >
                                            Application Link
                                        </label>
                                        <div class="col-sm-8">
                                            <input type="url" 
                                                class="form-control" 
                                                id="inputApplicationLink" 
                                                v-model="application_link"
                                                placeholder="http://example.com"
                                            />
                                            <span class="info">
                                                If application is to be done on company site.
                                            </span>
                                        </div>
                                    </div>
                                    <div id="inner-form" class="form-group row">
                                        <label for="applicationDeadline"
                                            class="col-sm-3 col-form-label"
                                        >
                                            Application Deadline
                                        </label>
                                        <div class="col-sm-8">
                                            <input type="date" id="applicationDeadline"
                                                class="form-control"
                                                v-model="closing_date"
                                                placeholder="Enter date"
                                            />
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <div class="card-footer" style="width: 96vw;margin-left: 5px;">
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" 
                                        type="checkbox" 
                                        id="invalidCheck" 
                                        v-model="agreement"
                                        required
                                    />
                                    <label class="form-check-label" for="invalidCheck">
                                        Agree to terms and conditions
                                    </label>
                                </div>
                            </div>
                            <button class="btn btn-primary" 
                                aria-label="submit form"
                                type="submit"
                                tabindex="0"
                                :disabled="agreement === false"
                            >
                                Submit Job Post
                            </button>
                        </div>
                    </div>        
                </form> 
            </div>
        </section>
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
        data: () => ({
            showAutoComplete: true,
            companyName: '',
            companyID: '',
            companyResults: [],
            about: '',
            address: '',
            website: '',
            contact_number: '',
            job_title: '',
            job_description: '',
            job_location: '',
            salary: '',
            application_email: '',
            application_link: '',
            closing_date: '',
            agreement: false,
            validations: {
                companyName: {
                    is_valid: true,
                    text: ''
                },
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
                    this.showAutoComplete = true;
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
            /*
                Selects an existing company
            */
            selectCompany( company ){
                this.showAutoComplete = false;
                this.companyName = company.name;
                this.companyID = company.id;
                this.companyResults = [];
            },
            postJob() {
                if(this.validateNewPost()) {
                    this.$store.dispatch('submitJob', {
                        company_id: this.companyID,
                        name: this.companyName,
                        about: this.about,
                        address: this.address,
                        website: this.website,
                        contact_number: this.contact_number,
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
                    this.validations.job_description.is_valid = true;
                    this.validations.job_description.text = '';
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

                return validNewPostForm;
            },
            clearForm(){
                this.companyName = '';
                this.companyID = '';
                this.about = '';
                this.address = '';
                this.website = '';
                this.contact_number = '';
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
                };
            }
        },
        computed: {
            jobSubmittedStatus() {
                return this.$store.getters.showJobSubmittedStatus;
            },
            jobSubmittedText() {
                return this.$store.getters.showJobSubmittedText;
            }
        },
        watch: {
            'jobSubmittedStatus': function(){
                if( this.jobSubmittedStatus == 2 ){
                    this.clearForm();
                    EventBus.$emit('show-success', {
                        notification: this.jobSubmittedText
                    });
                }

                if( this.jobSubmittedStatus == 3 ){
                    $("#there-was-a-problem-submitting-job").show().delay(5000).fadeOut();
                }
            }
        },
    }
</script>

<style scoped>
    .post-form-pg {
        width: 96vw !important;
        padding: 0;
    }
    .post-form-pg .inner {
        background: #fff;
        padding-top: 30px;
    }
    .jumbotron img {
        max-width: 100%;
        max-height: 100%;
        width: 500vw;
    }
    .jumbotron-text {
        position: absolute;
        top: 95px;
        z-index: 999;
        color: white;
        left: 100px;
    }
    .jumbotron-text h1{
        color: chocolate;
    }
    .jumbotron-text p{
        margin-top: 0;
        margin-bottom: 1rem;
        width: 25vw;
        color: #f8fafc;
        font-size: 1.4rem;
    }
    #fs-snd-text {
        color: #f8f9fa;
    }
    .jumbotron-bottom {
        position: absolute;
        top: 150px;
        left: 100px;
    }
    .jumbotron-bottom p {
        margin-bottom: 0;
        font-size: 1.3rem;
        color: #ffe817;
    }
    span.info {
        color: #0a7ddc;
        font-size: .75rem;
    }
    span.validation {
        font-size: 11px;
        color: #e3342f;
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

    @media screen and (max-width: 768px){
        .jumbotron-text {
            left: 40px;
        }
        .jumbotron-text h1 {
            font-size: 1.2rem;
        }
        .jumbotron-text p {
            width: 50vw;
            font-size: 1rem;
        }
        #fs-snd-text {
            display: none;
        }
    }
</style>