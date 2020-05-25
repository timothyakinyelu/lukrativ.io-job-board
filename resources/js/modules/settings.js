// VUEX modules/roles.js
/*
    The Vuex data store for the roles
*/

import settingsAPI from '../api/setting'

export const settings = {
    state: {
        sendEmailStatus: 0,
        resetLinkText: '',

        passwordChangedStatus: 0,
        passwordChangedText: ''
    },
    actions: {
        sendEmail( { commit }, data) {
            commit( 'setSendEmailStatus', 1 );
            console.log(data.email)
            settingsAPI.sendEmailLink( 
                data.email,
            ).then( function(response) {
                commit('setSendEmailStatus', 2);
                commit('setResetLinkText', response.data.data)
            }).catch(function(err) {
                commit('setSendEmailStatus', 3)
                commit('setResetLinkText', err.response.data.error)
            });
        },
        changePassword( {commit}, data) {
            commit( 'setPasswordChangedStatus', 1)
            
            settingsAPI.passwordChange(
                data.token,
                data.email,
                data.password,
                data.password_confirmation
            ).then( function(response) {
                commit( 'setPasswordChangedStatus',2 )
                commit( 'setPasswordChangedText', response.data.status)
            }).catch( function(err) {
                commit( 'setPasswordChangedStatus', 3)
                commit( 'setPasswordChangedText', err.response.data.error)
            })
        }
    },
    mutations: {
        setSendEmailStatus( state, status ){
            state.sendEmailStatus = status;
        },
        setResetLinkText(state, text) {
            state.resetLinkText = text
        },
        setPasswordChangedStatus(state, status) {
            state.passwordChangedStatus = status
        },
        setPasswordChangedText(state, text) {
            state.passwordChangedText = text
        }
    },
    getters: {
        getSendEmailStatus( state ){
            return state.sendEmailStatus;
        },
        getResetLinkText(state) {
            return state.resetLinkText
        },
        getPasswordChangedStatus(state) {
            return state.passwordChangedStatus
        },
        getPasswordChangedText(state) {
            return state.passwordChangedText
        }
    }
}