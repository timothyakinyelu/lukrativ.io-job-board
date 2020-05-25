/*
|   Authenticates admin users and provides access to rest
|   of admin page.
*/

import { FS_CONFIG } from '../../config'
import { authHeader } from '../../authHelper'

export default {
    checkEmail: function(email) {
        let fd = new FormData()

        fd.append('email', email);
        return axios.post(FS_CONFIG.API_URL + '/verify-email', fd)
    },
    confirmPassword: function(email, emailBool, password) {
        let fd = new FormData()

        fd.append('email', email);
        fd.append('emailBool', emailBool);
        fd.append('password', password);
        return axios.post(FS_CONFIG.API_URL + '/confirm-password', fd)
    },
    getUser: function() {
        const requestOptions = {
            headers: { ...authHeader() }
        };

        return axios.get(FS_CONFIG.API_URL + '/getUser', requestOptions);
    },
}


