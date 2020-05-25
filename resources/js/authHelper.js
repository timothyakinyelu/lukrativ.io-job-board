import store from './store'
export function authHeader() {
    //returns the authorization token with requests
    // console.log()
    let token = store.getters.getToken;
    
    if(token) {
        return {'Authorization': 'Bearer ' + token}
    } else {
        return {}
    }
}