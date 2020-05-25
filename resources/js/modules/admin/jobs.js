// VUEX modules/posts.js
/*
    The Vuex data store for the posts
*/

import JobAPI from '../../api/admin/job'

export const jobs = {
    state: {
        verified: [],
        jobsLoadStatus: 0,

        drafts: [],

        jobAddedStatus: 0,
        jobAdded: {},
        jobAddedText: '',

        editJob: {},
		editJobLoadStatus: 0,
		updatedJobStatus: 0,
        updatedJobText: '',

        verifiedJob: {},
        verifiedJobStatus: 0,
        
        deletedJobStatus: 0,
		deletedJobText: '',
    },
    actions: {
        // Load all verified jobs
        loadVerifiedJobs( { commit } ){
            commit( 'setJobsLoadStatus', 1 );

            JobAPI.getVerifiedJobs()
            .then( function(response) {
                commit( 'setVerified', response.data );
                commit( 'setJobsLoadStatus', 2 );
            })
            .catch( function() {
                commit( 'setVerified', []);
                commit( 'setJobsLoadStatus', 3 );
            });
        },
        // Load all unverified jobs
        loadUnVerifiedJobs( { commit } ){
            commit( 'setJobsLoadStatus', 1 );

            JobAPI.getUnVerifiedJobs()
            .then( function(response) {
                commit( 'setDrafts', response.data );
                commit( 'setJobsLoadStatus', 2 );
            })
            .catch( function() {
                commit( 'setDrafts', []);
                commit( 'setJobsLoadStatus', 3 );
            });
        },
        // Add a new job
        addJob( { commit, dispatch }, data) {
            commit( 'setJobAddedStatus', 1 );

            JobAPI.addNewJob( 
                data.company_id,
                data.job_type_id,
                data.job_field_id,
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
                commit( 'setJobAddedText',  'New Job has been successfully added!');
                commit('setJobAddedStatus', 2);
                commit( 'setJobAdded', response.data );

                dispatch('loadUnVerifiedJobs');
            }).catch(function() {
                commit('setJobAddedStatus', 3)
            });
        },
        // Load post to edit
        loadJob( { commit }, data) {
            commit( 'setEditJobLoadStatus', 1);

            JobAPI.getJob(data.id)
            .then(function(response) {
                commit( 'setEditJob', response.data);
                commit( 'setEditJobLoadStatus', 2);
            })
            .catch(function() {
                commit( 'setEditJob', {} );
                commit( 'setEditJobLoadStatus', 3)
            });
        },
	    // Updates a job
		updateJob( { commit, state, dispatch }, data ){
            commit( 'setUpdatedJobStatus', 1 );

			JobAPI.updateJob( 
                data.id, 
                data.company_id,
                data.job_type_id,
                data.job_field_id,
                data.job_title, 
                data.job_description, 
                data.qualifications,
                data.competencies,
                data.job_location, 
                data.salary, 
                data.application_email, 
                data.application_link,
                data.closing_date
                )
            .then( function( response ){
                commit( 'setUpdatedJobText', response.data.title + ' ' + 'has been successfully updated!');
                commit( 'setUpdatedJobStatus', 2 );

                dispatch( 'loadUnVerifiedJobs' );
                dispatch( 'loadVerifiedJobs' );
            })
            .catch( function( error ){
                commit( 'setUpdatedJobStatus', 3 );
            });
        },
        /* Verify job */
        verifyJob( { commit, dispatch }, data ){
            commit( 'setVerifiedJobStatus', 1 );
            JobAPI.verifyJob( 
                data.jobID,
            )
            .then( function( response ){
                commit( 'setVerifiedJobStatus', 2 );
                commit( 'setVerifiedJob', response.data );
                dispatch( 'loadUnVerifiedJobs' );
                dispatch( 'loadVerifiedJobs' );
            })
            .catch( function(){
                commit( 'setVerifiedJobStatus', 3 );
            });
        },
        /*
			Deletes a job.
		*/
		deleteJob( { commit, state, dispatch }, data ){
			commit( 'setDeletedJobStatus', 1 );

			JobAPI.deleteJob( data.jobID )
            .then( function( response ){
                commit( 'setDeletedJobText', 'Job has been successfully deleted!');
                commit( 'setDeletedJobStatus', 2 );

                /*
                    Load the posts
                */
                dispatch( 'loadUnVerifiedJobs' );
                dispatch( 'loadVerifiedJobs' );
            })
            .catch( function(){
                commit( 'setDeletedJobStatus', 3 );
            });
		},
    },
    mutations: {
        setJobsLoadStatus( state, status ){
            state.jobsLoadStatus = status;
        },
        setVerified( state, verified ){
            state.verified = verified;
        },
        setDrafts( state, drafts ){
            state.drafts = drafts;
        },
        setJobAdded( state, job ){
			state.jobAdded = job;
		},
        setJobAddedStatus( state, status ){
            state.jobAddedStatus = status;
        },
        setJobAddedText( state, text ){
			state.jobAddedText = text;
		},
        setEditJob( state, job ){
			state.editJob = job;
		},
		setUpdatedJobStatus( state, status ){
			state.updatedJobStatus = status;
		},
		setUpdatedJobText( state, text ){
			state.updatedJobText = text;
		},
		setEditJobLoadStatus( state, status ){
			state.editJobLoadStatus = status;
        },
        setVerifiedJob( state, job ){
			state.verifiedJob = job;
        },
        setVerifiedJobStatus( state, status ){
			state.verifiedJobStatus = status;
        },
        setDeletedJobStatus( state, status ){
			state.deletedJobStatus = status;
		},
		setDeletedJobText( state, text ){
			state.deletedJobText = text;
		},
    },
    getters: {
        getJobsLoadStatus( state ) {
            return state.jobsLoadStatus;
        },
        getVerified( state ) {
            return state.verified;
        },
        getDrafts( state ) {
            return state.drafts;
        },
        getAddedJob( state ){
			return state.jobAdded;
		},
        getJobAddedStatus( state ){
            return state.jobAddedStatus;
        },
        getJobAddedText( state ){
			return state.jobAddedText;
		},
        getEditJob( state ){
			return state.editJob;
		},
		getUpdatedJobStatus( state ){
			return state.updatedJobStatus;
		},
		getUpdatedJobText( state ){
			return state.updatedJobText;
		},
		getEditJobLoadStatus( state ){
			return state.editJobLoadStatus;
        },
        getDeletedJobStatus( state ){
			return state.deletedJobStatus;
		},
		getDeletedJobText( state ){
			return state.deletedJobText;
		},
    }
}