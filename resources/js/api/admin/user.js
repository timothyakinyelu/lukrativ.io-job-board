/*
    Imports the FloraShaw API URL from the config.
*/
import { FS_CONFIG } from '../../config';
import { authHeader } from '../../authHelper'

export default {
    /*
        GET     /api/v1/users
    */
    getUsers: function(){
        const requestOptions = {
            headers: { ...authHeader(), 'Content-Type': 'application/json' },
        };

        return axios.get( FS_CONFIG.API_URL + '/users', requestOptions );
    },
    /*
        GET     /api/v1/users/{userID}/show
    */
    getUser: function(){
        const requestOptions = {
            headers: { ...authHeader(), 'Content-Type': 'application/json' },
        };

        return axios.get( FS_CONFIG.API_URL + '/getUser', requestOptions );
    },
    /*
    POST  /api/v1/users
    */
    addNewUser: function( firstName, lastName, email, permission, avatar ){
        const requestOptions = {
            headers: { ...authHeader(), 'Content-Type': 'application/json, multipart/form-data' },
        };

        let fd = new FormData()

        fd.append('first_name', firstName);
        fd.append('last_name', lastName);
        fd.append('email', email);
        fd.append('permission', permission);
        fd.append('avatar', avatar);

        return axios.post(FS_CONFIG.API_URL + '/users', fd, requestOptions)
    },
    /*
    PUT  /api/v1/users/{userID}/edit
    */
    updateUser: function( userID, firstName, lastName, email, permission, avatar){

        const requestOptions = {
            headers: { ...authHeader(), 'Content-Type': 'application/json, multipart/form-data' },
        };
        /*
            Initialize the form data
        */
        let formData = new FormData();
        /*
            Add the form data we need to submit
        */

        formData.append('first_name', firstName);
        formData.append('last_name', lastName)
        formData.append('email', email);
        formData.append('permission', permission);
        formData.append('avatar', avatar)
        
        formData.append('_method', 'PUT');

        return axios.post( FS_CONFIG.API_URL + '/users/' + userID + '/update', formData, requestOptions);
    },
    /*
    DELETE  /api/v1/users/{userID}/delete
    */
    deleteUser: function( userID ){
        const requestOptions = {
            headers: { ...authHeader(), 'Content-Type': 'application/json' },
        };

        return axios.delete( FS_CONFIG.API_URL + '/users/' + userID + '/delete', requestOptions);
    }
}