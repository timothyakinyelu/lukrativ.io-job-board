// VUEX modules/jobfields.js
/*
    The Vuex data store for the jobfields
*/

import jobfieldApi from '../../api/admin/jobfield'

export const jobfields = {
    state: {
        jobfields: [],
        jobfieldsLoadStatus: 0,

        jobfield: {},
        jobfieldAddedText: '',
        jobfieldAddedStatus: 0,

        jobfieldUpdatedText: '',
        jobfieldUpdatedStatus: 0,

        jobfieldDeletedText: '',
        jobfieldDeletedStatus: 0
    },
    actions: {
        /*
        |   Description: Load all jobfields
        |   Method: jobfieldApi.getjobfields
        */
        LoadJobfields({ commit }) {
            commit('setJobfieldsLoadStatus', 1)

            jobfieldApi.getJobfields()
            .then(function(response) {
                commit('setJobfields', response.data)
                commit('setJobfieldsLoadStatus', 2)
            })
            .catch( function() {
                commit('setJobfields', [])
                commit('setJobfieldsLoadStatus', 3)
            })
        },

        /*
        |   Description: Add an jobfield
        |   Method: jobfieldApi.addjobfield
        */
        AddJobfield({commit, dispatch}, data) {
            commit('setJobfieldAddedStatus', 1)

            jobfieldApi.addJobfield(
                data.name
            )
            .then(function(response) {
                commit('setJobfield', response.data)
                commit('setJobfieldAddedStatus', 2)
                commit('setJobfieldAddedText', response.data.name + ' ' + 'has been successfully added!')
                dispatch('LoadJobfields')
            })
            .catch(function(err) {
                commit('setJobfield', {})
                commit('setJobfieldAddedStatus', 3)
                commit('setJobfieldAddedText', err.response.data.error)
            })
        },

        /*
        |   Description: Update a jobfield
        |   Method: jobfieldApi.updatejobfield
        */
        UpdateJobfield({commit, dispatch}, data) {
            commit('setJobfieldUpdatedStatus', 1)

            jobfieldApi.updateJobfield(
                data.id,
                data.name
            )
            .then(function(response) {
                commit('setJobfield', response.data)
                commit('setJobfieldUpdatedStatus', 2)
                commit('setJobfieldUpdatedText', response.data.name + ' ' + 'has been successfully updated!')
                dispatch('LoadJobfields')
            })
            .catch(function(err) {
                commit('setJobfield', {})
                commit('setJobfieldUpdatedStatus', 3)
                commit('setJobfieldUpdatedText', err.response.data.error)
            })
        },

        /*
        |   Description: Delete jobfield
        |   Method: jobfieldApi.deletejobfield
        */
       DeleteJobfield({commit, dispatch}, data) {
           commit('setJobfieldDeletedStatus', 1)

           jobfieldApi.deletejobfield(data.jobfieldID)
           .then(function(response) {
                commit('setJobfieldDeletedStatus', 2)
                commit('setJobfieldDeletedText', response.data.name + ' ' + 'has been successfully deleted!')
                dispatch('LoadJobfields')
           })
           .catch(function(err) {
                commit('setJobfieldDeletedStatus', 3)
                commit('setJobfieldDeletedText', err.response.data.error)
           })
       }
    },
    mutations: {
        setJobfields (state, jobfields) {
            state.jobfields = jobfields
        },
        setJobfieldsLoadStatus (state, status) {
            state.jobfieldsLoadStatus = status
        },
        setJobfield (state, jobfield) {
            state.jobfield = jobfield
        },
        setJobfieldAddedStatus (state, status) {
            state.jobfieldAddedStatus = status
        },
        setJobfieldAddedText (state, text) {
            state.jobfieldAddedText = text
        },
        setJobfieldUpdatedStatus (state, status) {
            state.jobfieldUpdatedStatus = status
        },
        setJobfieldUpdatedText (state, text) {
            state.jobfieldUpdatedText = text
        },
        setJobfieldDeletedStatus (state, status) {
            state.jobfieldDeletedStatus = status
        },
        setJobfieldDeletedText (state, text) {
            state.jobfieldDeletedText = text
        }
    },
    getters: {
        fetchJobfields(state) {
            return state.jobfields
        },
        showJobfieldsLoadStatus(state) {
            return state.jobfieldsLoadStatus
        },
        fetchJobfield(state) {
            return state.jobfield
        },
        showJobfieldAddedStatus(state) {
            return state.jobfieldAddedStatus
        },
        showJobfieldAddedText(state) {
            return state.jobfieldAddedText
        },
        showJobfieldUpdatedStatus(state) {
            return state.jobfieldUpdatedStatus
        },
        showJobfieldUpdatedText(state) {
            return state.jobfieldUpdatedText
        },
        showJobfieldDeletedStatus(state) {
            return state.jobfieldDeletedStatus
        },
        showJobfieldDeletedText(state) {
            return state.jobfieldDeletedText
        }
    }
}