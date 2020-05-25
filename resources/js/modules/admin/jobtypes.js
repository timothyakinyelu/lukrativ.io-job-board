// VUEX modules/jobtypes.js
/*
    The Vuex data store for the jobtypes
*/

import jobtypeApi from '../../api/admin/jobtype'

export const jobtypes = {
    state: {
        jobtypes: [],
        jobtypesLoadStatus: 0,

        jobtype: {},
        jobtypeAddedText: '',
        jobtypeAddedStatus: 0,

        jobtypeUpdatedText: '',
        jobtypeUpdatedStatus: 0,

        jobtypeDeletedText: '',
        jobtypeDeletedStatus: 0
    },
    actions: {
        /*
        |   Description: Load all jobtypes
        |   Method: jobtypeApi.getjobtypes
        */
        LoadJobtypes({ commit }) {
            commit('setJobtypesLoadStatus', 1)

            jobtypeApi.getJobtypes()
            .then(function(response) {
                commit('setJobtypes', response.data)
                commit('setJobtypesLoadStatus', 2)
            })
            .catch( function() {
                commit('setJobtypes', [])
                commit('setJobtypesLoadStatus', 3)
            })
        },

        /*
        |   Description: Add an jobtype
        |   Method: jobtypeApi.addjobtype
        */
        AddJobtype({commit, dispatch}, data) {
            commit('setJobtypeAddedStatus', 1)

            jobtypeApi.addJobtype(
                data.name
            )
            .then(function(response) {
                commit('setJobtype', response.data)
                commit('setJobtypeAddedStatus', 2)
                commit('setJobtypeAddedText', response.data.name + ' ' + 'has been successfully added!')
                dispatch('LoadJobtypes')
            })
            .catch(function(err) {
                commit('setJobtype', {})
                commit('setJobtypeAddedStatus', 3)
                commit('setJobtypeAddedText', err.response.data.error)
            })
        },

        /*
        |   Description: Update a jobtype
        |   Method: jobtypeApi.updatejobtype
        */
        UpdateJobtype({commit, dispatch}, data) {
            commit('setJobtypeUpdatedStatus', 1)

            jobtypeApi.updateJobtype(
                data.id,
                data.name
            )
            .then(function(response) {
                commit('setJobtype', response.data)
                commit('setJobtypeUpdatedStatus', 2)
                commit('setJobtypeUpdatedText', response.data.name + ' ' + 'has been successfully updated!')
                dispatch('LoadJobtypes')
            })
            .catch(function(err) {
                commit('setJobtype', {})
                commit('setJobtypeUpdatedStatus', 3)
                commit('setJobtypeUpdatedText', err.response.data.error)
            })
        },

        /*
        |   Description: Delete jobtype
        |   Method: jobtypeApi.deletejobtype
        */
       DeleteJobtype({commit, dispatch}, data) {
           commit('setJobtypeDeletedStatus', 1)

           jobtypeApi.deletejobtype(data.jobtypeID)
           .then(function(response) {
                commit('setJobtypeDeletedStatus', 2)
                commit('setJobtypeDeletedText', response.data.name + ' ' + 'has been successfully deleted!')
                dispatch('LoadJobtypes')
           })
           .catch(function(err) {
                commit('setJobtypeDeletedStatus', 3)
                commit('setJobtypeDeletedText', err.response.data.error)
           })
       }
    },
    mutations: {
        setJobtypes (state, jobtypes) {
            state.jobtypes = jobtypes
        },
        setJobtypesLoadStatus (state, status) {
            state.jobtypesLoadStatus = status
        },
        setJobtype (state, jobtype) {
            state.jobtype = jobtype
        },
        setJobtypeAddedStatus (state, status) {
            state.jobtypeAddedStatus = status
        },
        setJobtypeAddedText (state, text) {
            state.jobtypeAddedText = text
        },
        setJobtypeUpdatedStatus (state, status) {
            state.jobtypeUpdatedStatus = status
        },
        setJobtypeUpdatedText (state, text) {
            state.jobtypeUpdatedText = text
        },
        setJobtypeDeletedStatus (state, status) {
            state.jobtypeDeletedStatus = status
        },
        setJobtypeDeletedText (state, text) {
            state.jobtypeDeletedText = text
        }
    },
    getters: {
        fetchJobtypes(state) {
            return state.jobtypes
        },
        showJobtypesLoadStatus(state) {
            return state.jobtypesLoadStatus
        },
        fetchJobtype(state) {
            return state.jobtype
        },
        showJobtypeAddedStatus(state) {
            return state.jobtypeAddedStatus
        },
        showJobtypeAddedText(state) {
            return state.jobtypeAddedText
        },
        showJobtypeUpdatedStatus(state) {
            return state.jobtypeUpdatedStatus
        },
        showJobtypeUpdatedText(state) {
            return state.jobtypeUpdatedText
        },
        showJobtypeDeletedStatus(state) {
            return state.jobtypeDeletedStatus
        },
        showJobtypeDeletedText(state) {
            return state.jobtypeDeletedText
        }
    }
}