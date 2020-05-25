/*
    Imports the FloraShaw API URL from the config.
*/
import { FS_CONFIG } from '../../config'
import { authHeader } from '../../authHelper'

export default {
    /*
    | Description: Fetch all industries from DB
    | url: api/v1/industries
    | method: GET
    */
    getIndustries: function() {
        const requestOptions = {
            headers: { ...authHeader(), 'Content-Type': 'application/json' }
        }

        return axios.get(FS_CONFIG.API_URL + '/industries', requestOptions)
    },

    /*
    | Description: Add a new industry to the DB
    | url: api/v1/indutries
    | method: POST
    */
    addIndustry: function(name) {
        const requestOptions = {
            headers: { ...authHeader(), 'Content-Type': 'application/json' },
        };

        let fd = new FormData()

        fd.append('name', name);

        return axios.post(FS_CONFIG.API_URL + '/industries', fd, requestOptions)
    },

    /*
    | Description: Update an industry in the DB
    | url: api/v1/industries/id/update
    | method: PUT
    */
    updateIndustry: function( industryID, name) {
        const requestOptions = {
            headers: { ...authHeader(), 'Content-Type': 'application/json' },
        };

        let fd = new FormData()

        fd.append('name', name);

        fd.append('_method', 'PUT')

        return axios.post(FS_CONFIG.API_URL + '/industries/' + industryID + '/update', fd, requestOptions)
    },

    /*
    | Description: Delete an industry in the DB
    | url: api/v1/industries/id/delete
    | method: DELETE
    */
    deleteIndustry: function( industryID ) {
        const requestOptions = {
            headers: { ...authHeader(), 'Content-Type': 'application/json' },
        };

        return axios.delete(FS_CONFIG.API_URL + '/industries/' + industryID + '/delete', requestOptions)
    }
}