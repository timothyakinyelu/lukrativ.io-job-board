/*
    Imports the FloraShaw API URL from the config.
*/
import { FS_CONFIG } from '../../config'
import { authHeader } from '../../authHelper'

export default {
    /*
    | Description: Fetch all jobfields from DB
    | url: api/v1/jobfields
    | method: GET
    */
    getJobfields: function() {
        const requestOptions = {
            headers: { ...authHeader(), 'Content-Type': 'application/json' }
        }

        return axios.get(FS_CONFIG.API_URL + '/jobfields', requestOptions)
    },

    /*
    | Description: Add a new jobfield to the DB
    | url: api/v1/jobfields
    | method: POST
    */
    addJobfield: function(name) {
        const requestOptions = {
            headers: { ...authHeader(), 'Content-Type': 'application/json' },
        };

        let fd = new FormData()

        fd.append('name', name);

        return axios.post(FS_CONFIG.API_URL + '/jobfields', fd, requestOptions)
    },

    /*
    | Description: Update an jobfield in the DB
    | url: api/v1/jobfields/id/update
    | method: PUT
    */
    updateJobfield: function( jobfieldID, name) {
        const requestOptions = {
            headers: { ...authHeader(), 'Content-Type': 'application/json' },
        };

        let fd = new FormData()

        fd.append('name', name);

        fd.append('_method', 'PUT')

        return axios.post(FS_CONFIG.API_URL + '/jobfields/' + jobfieldID + '/update', fd, requestOptions)
    },

    /*
    | Description: Delete an jobfield in the DB
    | url: api/v1/jobfields/id/delete
    | method: DELETE
    */
    deleteJobfield: function( jobfieldID ) {
        const requestOptions = {
            headers: { ...authHeader(), 'Content-Type': 'application/json' },
        };

        return axios.delete(FS_CONFIG.API_URL + '/jobfields/' + jobfieldID + '/delete', requestOptions)
    }
}