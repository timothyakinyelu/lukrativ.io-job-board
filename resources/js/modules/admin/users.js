// VUEX modules/users.js
/*
    The Vuex data store for users
*/

import userAPI from '../../api/admin/user'

export const users = {
    state: {
        users: [],
        usersLoadStatus: 0,

        user: {},
        userLoadStatus: 0,
        userAddedStatus: 0,
        userAddedText: '',

        userUpdatedStatus: 0,
		userUpdatedText: '',

        userDeletedStatus: 0,
		userDeleteText: '',
    },
    actions: {
        LoadUsers( { commit } ){
            commit( 'setUsersLoadStatus', 1 );

            userAPI.getUsers()
            .then( function(response) {
                commit( 'setUsers', response.data );
                commit( 'setUsersLoadStatus', 2 );
            })
            .catch( function() {
                commit( 'setUsers', []);
                commit( 'setUsersLoadStatus', 3 );
            });
        },
        LoadUser({ commit }) {
            commit('setUserLoadStatus', 1)

            userAPI.getUser()
            .then(function(response) {
                commit('setUser', response.data)
                commit('setUserLoadStatus', 2)
            })
            .catch(function(err) {
                commit('setUser', {})
                commit('setUserLoadStatus', 3)
            })
        },
        AddUser( { commit, dispatch }, data) {
            commit( 'setUserAddedStatus', 1 );

            console.log(data)
            userAPI.addNewUser( 
                data.first_name,
                data.last_name,
                data.email,
                data.permission,
                data.avatar,
            ).then( function(response) {
                commit('setUser', response.data)
                commit('setUserAddedStatus', 2);
                dispatch('LoadUsers');
            }).catch(function(err) {
                commit('setUserAddedStatus', 3)
                commit('setUserAddedText', err.response.data.error)
            });
        },
        //Update user
		UpdateUser( { commit, dispatch }, data ){
			commit( 'setUserUpdatedStatus', 1 );

			userAPI.updateUser( 
                data.id, 
                data.first_name, 
                data.last_name,
                data.email, 
                data.permission,
                data.avatar 
            )
            .then( function( response ){
                commit('setUser', response.data)
                commit( 'setUserUpdatedText', response.data.name+' has been successfully updated!');
                commit( 'setUserUpdatedStatus', 2 );
                    dispatch( 'LoadUsers' );
                })
            .catch( function( err ){
                commit( 'setUserUpdatedStatus', 3 );
                commit('setUserUpdatedText', err.response.data.error)
            });
		},
        /*
			Deletes a user.
		*/
		DeleteUser( { commit, dispatch }, data ){
			commit( 'setUserDeletedStatus', 1 );
            
			userAPI.deleteUser( data.userID )
            .then( function( response ){
                commit( 'setUserDeletedText', 'User has been successfully deleted!');
                commit( 'setUserDeletedStatus', 2 );

                /*
                    Load the users
                */
                dispatch( 'LoadUsers' );
            })
            .catch( function(err){
                commit( 'setUserDeletedStatus', 3 );
                commit('setUserDeletedText', err.response.data.error)
            });
		},
    },
    mutations: {
        setUsersLoadStatus( state, status ){
            state.usersLoadStatus = status;
        },
        setUsers( state, users ){
            state.users = users;
        },
        setUser( state, user) {
            state.user = user
        },
        setUserLoadStatus(state, status) {
            state.userLoadStatus = status
        },
        setUserUpdatedStatus( state, status ){
			state.userUpdatedStatus = status;
		},
		setUserUpdatedText( state, text ){
			state.userUpdatedText = text;
		},
        setUserAddedStatus( state, status ){
            state.userAddedStatus = status;
        },
        setUserAddedText( state, text ){
            state.userAddedText = text;
        },
        setUserDeletedStatus( state, status ){
			state.userDeletedStatus = status;
		},
		setUserDeletedText( state, text ){
			state.userDeletedText = text;
		},
    },
    getters: {
        showUsersLoadStatus( state ) {
            return state.usersLoadStatus;
        },
        fetchUsers( state ) {
            return state.users;
        },
        fetchUser(state) {
            return state.user
        },
        showUserLoadStatus( state ) {
            return state.userLoadStatus
        },
		showUserUpdatedStatus( state ){
			return state.userUpdatedStatus;
		},
		showUserUpdatedText( state ){
			return state.userUpdatedText;
		},
        showUserAddedStatus( state ){
            return state.userAddedStatus;
        },
        showUserDeletedStatus( state ){
			return state.userDeletedStatus;
		},
		showUserDeletedText( state ){
			return state.userDeletedText;
		},
    }
}