// VUEX modules/Industries.js
/*
    The Vuex data store for the Industries
*/

import industryApi from '../../api/admin/industry'

export const industries = {
    state: {
        industries: [],
        industriesLoadStatus: 0,

        industry: {},
        industryAddedText: '',
        industryAddedStatus: 0,

        industryUpdatedText: '',
        industryUpdatedStatus: 0,

        industryDeletedText: '',
        industryDeletedStatus: 0
    },
    actions: {
        /*
        |   Description: Load all industries
        |   Method: industryApi.getIndustries
        */
        LoadIndustries({ commit }) {
            commit('setIndustriesLoadStatus', 1)

            industryApi.getIndustries()
            .then(function(response) {
                commit('setIndustries', response.data)
                commit('setIndustriesLoadStatus', 2)
            })
            .catch( function() {
                commit('setIndustries', [])
                commit('setIndustriesLoadStatus', 3)
            })
        },

        /*
        |   Description: Add an industry
        |   Method: industryApi.addIndustry
        */
        AddIndustry({commit, dispatch}, data) {
            commit('setIndustryAddedStatus', 1)

            industryApi.addIndustry(
                data.name
            )
            .then(function(response) {
                commit('setIndustry', response.data)
                commit('setIndustryAddedStatus', 2)
                commit('setIndustryAddedText', response.data.name + ' ' + 'has been successfully added!')
                dispatch('LoadIndustries')
            })
            .catch(function(err) {
                commit('setIndustry', {})
                commit('setIndustryAddedStatus', 3)
                commit('setIndustryAddedText', err.response.data.error)
            })
        },

        /*
        |   Description: Update a industry
        |   Method: industryApi.updateIndustry
        */
        UpdateIndustry({commit, dispatch}, data) {
            commit('setIndustryUpdatedStatus', 1)

            industryApi.updateIndustry(
                data.id,
                data.name
            )
            .then(function(response) {
                commit('setIndustry', response.data)
                commit('setIndustryUpdatedStatus', 2)
                commit('setIndustryUpdatedText', response.data.name + ' ' + 'has been successfully updated!')
                dispatch('LoadIndustries')
            })
            .catch(function(err) {
                commit('setIndustry', {})
                commit('setIndustryUpdatedStatus', 3)
                commit('setIndustryUpdatedText', err.response.data.error)
            })
        },

        /*
        |   Description: Delete industry
        |   Method: industryApi.deleteIndustry
        */
       DeleteIndustry({commit, dispatch}, data) {
           commit('setIndustryDeletedStatus', 1)

           industryApi.deleteIndustry(data.industryID)
           .then(function(response) {
                commit('setIndustryDeletedStatus', 2)
                commit('setIndustryDeletedText', response.data.name + ' ' + 'has been successfully deleted!')
                dispatch('LoadIndustries')
           })
           .catch(function(err) {
                commit('setIndustryDeletedStatus', 3)
                commit('setIndustryDeletedText', err.response.data.error)
           })
       }
    },
    mutations: {
        setIndustries (state, industries) {
            state.industries = industries
        },
        setIndustriesLoadStatus (state, status) {
            state.industriesLoadStatus = status
        },
        setIndustry (state, industry) {
            state.industry = industry
        },
        setIndustryAddedStatus (state, status) {
            state.industryAddedStatus = status
        },
        setIndustryAddedText (state, text) {
            state.industryAddedText = text
        },
        setIndustryUpdatedStatus (state, status) {
            state.industryUpdatedStatus = status
        },
        setIndustryUpdatedText (state, text) {
            state.industryUpdatedText = text
        },
        setIndustryDeletedStatus (state, status) {
            state.industryDeletedStatus = status
        },
        setIndustryDeletedText (state, text) {
            state.industryDeletedText = text
        }
    },
    getters: {
        fetchIndustries(state) {
            return state.industries
        },
        showIndustriesLoadStatus(state) {
            return state.industriesLoadStatus
        },
        fetchIndustry(state) {
            return state.industry
        },
        showIndustryAddedStatus(state) {
            return state.industryAddedStatus
        },
        showIndustryAddedText(state) {
            return state.industryAddedText
        },
        showIndustryUpdatedStatus(state) {
            return state.industryUpdatedStatus
        },
        showIndustryUpdatedText(state) {
            return state.industryUpdatedText
        },
        showIndustryDeletedStatus(state) {
            return state.industryDeletedStatus
        },
        showIndustryDeletedText(state) {
            return state.industryDeletedText
        }
    }
}