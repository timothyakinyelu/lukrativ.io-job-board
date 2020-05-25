// VUEX modules/companies.js
/*
    The Vuex data store for the companies
*/

import companyApi from '../../api/admin/company'

export const companies = {
    state: {
        companies: [],
        companiesLoadStatus: 0,

        company: {},
        companyAddedText: '',
        companyAddedStatus: 0,

        companyUpdatedText: '',
        companyUpdatedStatus: 0,

        companyDeletedText: '',
        companyDeletedStatus: 0
    },
    actions: {
        /*
        |   Description: Load all companies
        |   Method: companyApi.getCompanies
        */
        LoadCompanies({ commit }) {
            commit('setCompaniesLoadStatus', 1)

            companyApi.getCompanies()
            .then(function(response) {
                commit('setCompanies', response.data)
                commit('setCompaniesLoadStatus', 2)
            })
            .catch( function() {
                commit('setCompanies', [])
                commit('setCompaniesLoadStatus', 3)
            })
        },

        /*
        |   Description: Add a company
        |   Method: companyApi.addCompany
        */
        AddCompany({commit, dispatch}, data) {
            commit('setCompanyAddedStatus', 1)
            console.log(data)
            companyApi.addCompany(
                data.industry_id,
                data.name,
                data.about, 
                data.address,
                data.company_email, 
                data.contact_number,
                data.website,
                data.twitter_url,
                data.facebook_url,
                data.linkedin_url,
                data.logo
            )
            .then(function(response) {
                commit('setCompany', response.data)
                commit('setCompanyAddedStatus', 2)
                commit('setCompanyAddedText', response.data.name + ' ' + 'has been successfully added!')
                dispatch('LoadCompanies')
            })
            .catch(function(err) {
                commit('setCompany', {})
                commit('setCompanyAddedStatus', 3)
                commit('setCompanyAddedText', err.response.data.error)
            })
        },

        /*
        |   Description: Update a company
        |   Method: companyApi.updateCompany
        */
        UpdateCompany({commit, dispatch}, data) {
            commit('setCompanyUpdatedStatus', 1)

            companyApi.updateCompany(
                data.id,
                data.industry_id,
                data.name, 
                data.about, 
                data.address,
                data.company_email,
                data.contact_number, 
                data.website,
                data.twitter_url,
                data.facebook_url,
                data.linkedin_url,
                data.logo
            )
            .then(function(response) {
                commit('setCompany', response.data)
                commit('setCompanyUpdatedStatus', 2)
                commit('setCompanyUpdatedText', response.data.name + ' ' + 'has been successfully updated!')
                dispatch('LoadCompanies')
            })
            .catch(function(err) {
                commit('setCompany', {})
                commit('setCompanyUpdatedStatus', 3)
                commit('setCompanyUpdatedText', err.response.data.error)
            })
        },

        /*
        |   Description: Delete company
        |   Method: companyApi.deleteCompany
        */
       DeleteCompany({commit, dispatch}, data) {
           commit('setCompanyDeletedStatus', 1)

           companyApi.deleteCompany(data.companyID)
           .then(function(response) {
                commit('setCompanyDeletedStatus', 2)
                commit('setCompanyDeletedText', response.data.name + ' ' + 'has been successfully deleted!')
                dispatch('LoadCompanies')
           })
           .catch(function(err) {
                commit('setCompanyDeletedStatus', 3)
                commit('setCompanyDeletedText', err.response.data.error)
           })
       }
    },
    mutations: {
        setCompanies (state, companies) {
            state.companies = companies
        },
        setCompaniesLoadStatus (state, status) {
            state.companiesLoadStatus = status
        },
        setCompany (state, company) {
            state.company = company
        },
        setCompanyAddedStatus (state, status) {
            state.companyAddedStatus = status
        },
        setCompanyAddedText (state, text) {
            state.companyAddedText = text
        },
        setCompanyUpdatedStatus (state, status) {
            state.companyUpdatedStatus = status
        },
        setCompanyUpdatedText (state, text) {
            state.companyUpdatedText = text
        },
        setCompanyDeletedStatus (state, status) {
            state.companyDeletedStatus = status
        },
        setCompanyDeletedText (state, text) {
            state.companyDeletedText = text
        }
    },
    getters: {
        fetchCompanies(state) {
            return state.companies
        },
        showCompaniesLoadStatus(state) {
            return state.companiesLoadStatus
        },
        fetchCompany(state) {
            return state.company
        },
        showCompanyAddedStatus(state) {
            return state.companyAddedStatus
        },
        showCompanyAddedText(state) {
            return state.companyAddedText
        },
        showCompanyUpdatedStatus(state) {
            return state.companyUpdatedStatus
        },
        showCompanyUpdatedText(state) {
            return state.companyUpdatedText
        },
        showCompanyDeletedStatus(state) {
            return state.companyDeletedStatus
        },
        showCompanyDeletedText(state) {
            return state.companyDeletedText
        }
    }
}