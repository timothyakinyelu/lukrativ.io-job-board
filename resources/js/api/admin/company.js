/*
    Imports the FloraShaw API URL from the config.
*/
import { FS_CONFIG } from '../../config'
import { authHeader } from '../../authHelper'

export default {
    /*
    | Description: Fetch all companies from DB
    | url: api/v1/companies
    | method: GET
    */
    getCompanies: function() {
        const requestOptions = {
            headers: { ...authHeader(), 'Content-Type': 'application/json' }
        }

        return axios.get(FS_CONFIG.API_URL + '/companies', requestOptions)
    },

    /*
    | Description: Add a new company to the DB
    | url: api/v1/companies
    | method: POST
    */
    addCompany: function( industryID, name, about, address, companyEmail, website, twitterURL, facebookURL, linkedinURL, contactNumber, logo ) {
        const requestOptions = {
            headers: { ...authHeader(), 'Content-Type': 'application/json, multipart/form-data' },
        };

        let fd = new FormData()

        fd.append('industry_id', industryID);
        fd.append('name', name);
        fd.append('about', about);
        fd.append('address', address);
        fd.append('company_email', companyEmail);
        fd.append('website', website);
        fd.append('twitter_url', twitterURL);
        fd.append('facebook_url', facebookURL);
        fd.append('linkedin_url', linkedinURL);
        fd.append('contact_number', contactNumber);
        fd.append('logo', logo);

        return axios.post(FS_CONFIG.API_URL + '/companies', fd, requestOptions)
    },

    /*
    | Description: Update a company in the DB
    | url: api/v1/companies/id/update
    | method: PUT
    */
    updateCompany: function( companyID, industryID, name, about, address, companyEmail, website, twitterURL, facebookURL, linkedinURL, contactNumber, logo ) {
        const requestOptions = {
            headers: { ...authHeader(), 'Content-Type': 'application/json, multipart/form-data' },
        };

        let fd = new FormData()

        fd.append('industry_id', industryID);
        fd.append('name', name);
        fd.append('about', about);
        fd.append('address', address);
        fd.append('company_email', companyEmail);
        fd.append('website', website);
        fd.append('twitter_url', twitterURL);
        fd.append('facebook_url', facebookURL);
        fd.append('linkedin_url', linkedinURL);
        fd.append('contact_number', contactNumber);
        fd.append('logo', logo);

        fd.append('_method', 'PUT')

        return axios.post(FS_CONFIG.API_URL + '/companies/' + companyID + '/update', fd, requestOptions)
    },

    /*
    | Description: Delete a company in the DB
    | url: api/v1/companies/id/delete
    | method: DELETE
    */
    deleteCompany: function( companyID ) {
        const requestOptions = {
            headers: { ...authHeader(), 'Content-Type': 'application/json' },
        };

        return axios.delete(FS_CONFIG.API_URL + '/companies/' + companyID + '/delete', requestOptions)
    }
}