/*
    Imports the FloraShaw API URL from the config.
*/
import { FS_CONFIG } from '../../config';
import { authHeader } from '../../authHelper';

export default {
    /*
        GET     /api/v1/jobs
    */
    getVerifiedJobs: function(){
        const requestOptions = {
            headers: { ...authHeader(), 'Content-Type': 'application/json' },
        };

        return axios.get( FS_CONFIG.API_URL + '/jobs/verified',  requestOptions );
    },

    /*
        GET     /api/v1/jobs
    */
    getUnVerifiedJobs: function(){
        const requestOptions = {
            headers: { ...authHeader(), 'Content-Type': 'application/json' },
        };

        return axios.get( FS_CONFIG.API_URL + '/jobs/unverified',  requestOptions );
    },

    /*
    POST  /api/v1/jobs
    */
    addNewJob: function( companyID, jobTypeID, jobFieldID, job_title, 
        job_description, qualifications, competencies, job_location, 
        salary, application_email, application_link, closing_date ){
        const requestOptions = {
            headers: { ...authHeader(), 'Content-Type': 'application/json' },
        };

        return axios.post( FS_CONFIG.API_URL + '/jobs', {
            company_id: companyID,
            job_type_id: jobTypeID,
            job_field_id: jobFieldID,
            job_title: job_title,
            job_description: job_description,
            qualifications: qualifications,
            competencies: competencies,
            job_location: job_location,
            salary: salary,
            application_email: application_email,
            application_link: application_link,
            closing_date: closing_date
        }, requestOptions);
    },
    /*
        GET   /api/v1/jobs/{jobID}/edit
    */
    getJob: function( jobID ){
        const requestOptions = {
            headers: { ...authHeader(), 'Content-Type': 'application/json' },
        };

        return axios.get( FS_CONFIG.API_URL + '/jobs/' + jobID + '/edit', requestOptions);
    },
    /*
    PUT  /api/v1/jobs/{jobID}/edit
    */
    updateJob: function( jobID, companyID, jobTypeID, jobFieldID, 
        job_title, job_description, qualifications, competencies, 
        job_location, salary, application_email, application_link, closing_date ){
        /*
            Initialize the form data
        */
        let formData = new FormData();
        /*
            Add the form data we need to submit
        */
        
        formData.append('jobID', jobID);
        formData.append('company_id', companyID);
        formData.append('job_type_id', jobTypeID);
        formData.append('job_field_id', jobFieldID);
        formData.append('job_title', job_title);
        formData.append('job_description', JSON.stringify( job_description ) );
        formData.append('qualifications', JSON.stringify( qualifications ) );
        formData.append('competencies', JSON.stringify( competencies ) );
        formData.append('job_location', job_location);
        formData.append('salary', salary);
        formData.append('application_email', application_email);
        formData.append('application_link', application_link);
        formData.append('closing_date', closing_date);
        
        formData.append('_method', 'PUT');

        const requestOptions = {
            headers: { ...authHeader(), 'Content-Type': 'application/json' }
        };

        return axios.post( FS_CONFIG.API_URL + '/jobs/' + jobID + '/update', formData, requestOptions);
    },
    /*
    VERIFY  /api/v1/jobs/{jobID}/verify
    */
    verifyJob: function( jobID ){
        const requestOptions = {
            headers: { ...authHeader(), 'Content-Type': 'application/json' },
        };

        /*
            Initialize the form data
        */
        let formData = new FormData();
        
        formData.append('_method', 'PUT');

        return axios.post( FS_CONFIG.API_URL + '/jobs/' + jobID + '/verify', formData, requestOptions);
    },
    /*
    DELETE  /api/v1/jobs/{jobID}/
    */
    deleteJob: function( jobID ){
        const requestOptions = {
            headers: { ...authHeader(), 'Content-Type': 'application/json' },
        };

        return axios.delete( FS_CONFIG.API_URL + '/jobs/' + jobID + '/delete', requestOptions );
    }
}