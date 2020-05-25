// VUEX modules/posts.js
/*
    The Vuex data store for the posts
*/

import jobAPI from '../../api/frontend/post'

export const posts = {
    state: {
        jobs: [],
        jobsLoadStatus: 0,
        jobsLoadError: '',

        job: {},
        related: {},
        jobLoadStatus: 0,
        jobLoadError: '',

        jobSubmittedStatus: 0,
        jobSubmittedText: ''
    },
    actions: {
        searchJobs({commit}, data) {
            commit('setJobsLoadStatus', 1)
           
            jobAPI.searchJobs(
                data.page,
                data.keyword,
                data.locale
            )
            .then(function(response) {
                commit('setJobs', response.data)
                commit('setJobsLoadStatus', 2)
            })
            .catch(function(err) {
                commit('setJobs', [])
                commit('setJobsLoadError', err.response.data.error)
                commit('setJobsLoadStatus', 3)
            })
        },
        fetchJob({commit}, data) {
            commit('setJobLoadStatus', 1)

            jobAPI.getJob(data.id)
            .then(function(response) {
                commit('setJob', response.data.data)
                commit('setRelated', response.data.related)
                commit('setJobLoadStatus', 2)
            })
            .catch(function(err) {
                commit('setJob', {})
                commit('setRelated', {})
                commit('setJobLoadError', err.response.data.error)
                commit('setJobLoadStatus', 3)
            })
        },
        submitJob({commit, dispatch}, data) {
            commit( 'setJobSubmittedStatus', 1 );

            jobAPI.submitJob( 
                data.company_id,
                data.name,
                data.about,
                data.address,
                data.website,
                data.contact_number,
                data.job_title,
                data.job_description,
                data.qualifications,
                data.competencies,
                data.job_location,
                data.salary,
                data.application_email,
                data.application_link,
                data.closing_date
            ).then( function(response) {
                commit( 'setJobSubmittedText',  response.data.success);
                commit('setJobSubmittedStatus', 2);

                // dispatch('loadUnVerifiedJobs');
            }).catch(function(err) {
                commit( 'setJobSubmittedText',  err.response.data.error);
                commit('setJobSubmittedStatus', 3)
            });
        }
    },
    mutations: {
        setJobs(state, jobs) {
            state.jobs = jobs
        },
        setJobsLoadStatus(state, status) {
            state.jobsLoadStatus = status
        },
        setJobsLoadError(state, text) {
            state.jobsLoadError = text
        },
        setJob(state, job) {
            state.job = job
        },
        setRelated(state, related) {
            state.related = related
        },
        setJobLoadStatus(state, status) {
            state.jobLoadStatus = status
        },
        setJobLoadError(state, text) {
            state.jobLoadError = text
        },
        setJobSubmittedStatus(state, status) {
            state.jobSubmittedStatus = status
        },
        setJobSubmittedText(state, text) {
            state.jobSubmittedText = text
        }
    },
    getters: {
        getJobs(state) {
            return state.jobs
        },
        showJobsLoadStatus(state) {
            return state.jobsLoadStatus
        },
        showJobsLoadError(state) {
            return state.jobsLoadError
        },
        getJob(state) {
            return state.job
        },
        getRelated(state) {
            return state.related
        },
        showJobLoadError(state) {
            return state.jobLoadError
        },
        showJobLoadStatus(state) {
            return state.jobLoadStatus
        },
        showJobSubmittedStatus(state) {
            return state.jobSubmittedStatus
        },
        showJobSubmittedText(state) {
            return state.jobSubmittedText
        }
    }
}