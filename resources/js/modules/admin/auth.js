/*
|-------------------------------------------------------------------------------
| VUEX modules/admin/auth.js
|-------------------------------------------------------------------------------
| The Vuex data store for authentication
*/

import authenticate from '../../api/admin/authenticate'
import  { router }  from '../../routes';

const token = localStorage.getItem('token');

export const auth = {
    state: {
        checked: 0,
        error: '',
        token: token || '',
        user: {},
        userLoadStatus: 0,
        statusText: '',
        emailStatus: 0,
        email: '',
        confirmedEmail: false
    },
    actions: {
        checkEmail({commit}, data) {
            commit('setEmailStatus', 1);

            authenticate.checkEmail(data.email)
            .then( function(response) {
                commit('setEmailConfirmed', response.data.status);
                commit('setEmail', response.data.email);
                commit('setEmailStatus', 2);
            })
            .catch(function(err) {
                commit('setEmailConfirmed', false);
                commit( 'setStatusText',  err.response.data.error);
                commit('setEmail', '');
                commit('setEmailStatus', 3)
            })
        } ,
        confirmPassword({commit, dispatch}, data) {
            commit('setAuthStatus', 1);

            authenticate.confirmPassword(
                data.email,
                data.emailBool,
                data.password
            )
            .then( function(resp) {
                const token = resp.data.token
                
                localStorage.setItem('token', token)

                commit('setToken',token)
                commit('setAuthStatus', 2)

                dispatch( 'loadUser' );
                
                //router.replace({name: 'admin'}).then(x => router.go(0)).catch(e =>console.log(e));
                router.push({name: 'admin'})
            })
            .catch( function(err) {
                commit('setToken', '')
                commit( 'setStatusText',  err.response.data.error);
                commit('setAuthStatus', 3);

                localStorage.removeItem('token')
                localStorage.removeItem('user')
            })
        },
        loadUser({commit}) {
            commit('setUserLoadStatus', 1)

            authenticate.getUser()
            .then( function(response) {
                commit( 'setUser', response.data.data );
                commit( 'setUserLoadStatus', 2 );
            })
            .catch( function() {
                commit( 'setUser', {} );
                commit( 'setUserLoadStatus', 3 );
                localStorage.removeItem('token')
            })
        },
        logout({ commit }) {
            return new Promise((resolve, reject) => {
                commit('logout')
                localStorage.removeItem('token')
                localStorage.removeItem('user')
                resolve()
            })
        }
    },
    mutations: {
        setEmailConfirmed(state, bool) {
            state.confirmedEmail = bool
        },
        setEmail(state, email) {
            state.email = email
        },
        setEmailStatus(state, status) {
            state.emailStatus = status
        },
        setToken(state, token) {
            state.token = token
        },
        setAuthStatus(state, status){
            state.checked = status
        },
        setStatusText(state, text) {
            state.statusText = text
        },
        setUserLoadStatus( state, status ){
            state.userLoadStatus = status;
        },
        setUser(state, resp){
            state.user = resp
        },
        logout(state) {
            state.checked = 0
            state.token = ''
        },
    },
    getters: {
        getEmailConfirmed(state) {
            return state.confirmedEmail
        },
        getToken(state) {
            return state.token;
        },
        getEmail(state) {
            return state.email
        },
        getEmailStatus(state) {
            return state.emailStatus
        },
        isLoggedIn: state => !!state.token,
        getAuthStatus: state => state.checked,
        getStatusText( state) {
            return state.statusText
        },
        getUserLoadStatus( state ){
            return function(){
                return state.userLoadStatus;
            }
        },
        getUser( state ){
            return state.user;
        },
    }
}