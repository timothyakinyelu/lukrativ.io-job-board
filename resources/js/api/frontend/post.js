/*
    Imports the FloraShaw API URL from the config.
*/
import { FS_CONFIG } from '../../config';

export default {
    /*
        GET     /api/v1/jobs
    */
    searchJobs: function(page, keyword, locale) {
        return axios.get(FS_CONFIG.API_URL + '/jobs/search?page=' + page, {
            params: {
                // page: current_page,
                keyword: keyword,
                locale: locale
            }
        })
    },

    /*
        GET     /api/v1/jobs/job/id
    */
    getJob: function(jobID) {
        return axios.get(FS_CONFIG.API_URL + '/jobs/job/' + jobID)
    },

    submitJob: function(company_id, name, about, address, 
        website, contact_number, job_title, job_description, 
        job_location, salary, 
        application_email, application_link, closing_date) 
    {
        return axios.post( FS_CONFIG.API_URL + '/jobs/job', {
            company_id: company_id,
            name: name,
            about: about,
            address: address,
            website: website,
            contact_number: contact_number,
            job_title: job_title,
            job_description: job_description,
            job_location: job_location,
            salary: salary,
            application_email: application_email,
            application_link: application_link,
            closing_date: closing_date
        });
    }
}