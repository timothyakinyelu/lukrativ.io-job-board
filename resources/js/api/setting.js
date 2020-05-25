/*
    Imports the FloraShaw API URL from the config.
*/
import { FS_CONFIG } from '../config.js';

export default {
    
    /*
    POST  /api/v1/sendPasswordResetLink
    */
    sendEmailLink: function( email){
        return axios.post( FS_CONFIG.API_URL + '/sendPasswordResetLink', {
            email: email
        });
    },

    /*
    POST /api/v1/settings/resetPassword
    */
    passwordChange: function(token, email, password, password_confirmation) {
        let fd = new FormData()

        fd.append('token', token)
        fd.append('email', email)
        fd.append('password', password)
        fd.append('password_confirmation', password_confirmation)

        return axios.post( FS_CONFIG.API_URL + '/settings/resetPassword', fd)
    }
}