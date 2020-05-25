/*
|-------------------------------------------------------------------------------
| VUEX modules/display.js
|-------------------------------------------------------------------------------
| The Vuex data store for the display state
*/
export const display = {
    /*
      Defines the state being monitored for the module
    */
    state: {
        showPopOut: false,
    },
  
    /*
      Defines the actions that can be performed on the state.
    */
    actions: {
        /*
            Toggles the showing and hiding of the popout.
        */
        toggleShowPopOut( { commit }, data ){
            commit( 'setShowPopOut', data.showPopOut );
        },
    },
  
    /*
      Defines the mutations used by the state.
    */
    mutations: {
        /*
            Sets the state to show or hide the pop out.
        */
        setShowPopOut( state, show ){
            state.showPopOut = show;
        },
    },
  
    /*
      Defines the getters on the Vuex module.
    */
    getters: {
        /*
            Returns whether or not the pop out is shown or hidden.
        */
        getShowPopOut( state ){
            return state.showPopOut;
        },
    }
}