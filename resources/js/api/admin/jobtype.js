/*
    Imports the FloraShaw API URL from the config.
*/
import { FS_CONFIG } from '../../config'
import { authHeader } from '../../authHelper'

export default {
    /*
    | Description: Fetch all jobtypes from DB
    | url: api/v1/jobtypes
    | method: GET
    */
    getJobtypes: function() {
        const requestOptions = {
            headers: { ...authHeader(), 'Content-Type': 'application/json' }
        }

        return axios.get(FS_CONFIG.API_URL + '/jobtypes', requestOptions)
    },

    /*
    | Description: Add a new jobtype to the DB
    | url: api/v1/jobtypes
    | method: POST
    */
    addJobtype: function(name) {
        const requestOptions = {
            headers: { ...authHeader(), 'Content-Type': 'application/json' },
        };

        let fd = new FormData()

        fd.append('name', name);

        return axios.post(FS_CONFIG.API_URL + '/jobtypes', fd, requestOptions)
    },

    /*
    | Description: Update an jobtype in the DB
    | url: api/v1/jobtypes/id/update
    | method: PUT
    */
    updateJobtype: function( jobtypeID, name) {
        const requestOptions = {
            headers: { ...authHeader(), 'Content-Type': 'application/json' },
        };

        let fd = new FormData()

        fd.append('name', name);

        fd.append('_method', 'PUT')

        return axios.post(FS_CONFIG.API_URL + '/jobtypes/' + jobtypeID + '/update', fd, requestOptions)
    },

    /*
    | Description: Delete an jobtype in the DB
    | url: api/v1/jobtypes/id/delete
    | method: DELETE
    */
    deleteJobtype: function( jobtypeID ) {
        const requestOptions = {
            headers: { ...authHeader(), 'Content-Type': 'application/json' },
        };

        return axios.delete(FS_CONFIG.API_URL + '/jobtypes/' + jobtypeID + '/delete', requestOptions)
    }
}