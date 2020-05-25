/*
|-------------------------------------------------------------------------------
| VUEX modules/display.js
|-------------------------------------------------------------------------------
| The Vuex data store for the display state
*/
export const tab = {
    /*
      Defines the state being monitored for the module
    */
    state: {
        showTab1: false,
        showTab2: false
    },
  
    /*
      Defines the actions that can be performed on the state.
    */
    actions: {
        /*
            Toggles the showing and hiding of the popout.
        */
        toggleShowTab1( { commit }, data ){
            commit( 'setShowTab1', data.showTab1 );
        },
        toggleShowTab2( { commit }, data ){
            commit( 'setShowTab2', data.showTab2 );
        },
    },
  
    /*
      Defines the mutations used by the state.
    */
    mutations: {
        /*
            Sets the state to show or hide the pop out.
        */
        setShowTab1( state, show ){
            state.showTab1= show;
        },
        setShowTab2( state, show ){
            state.showTab2= show;
        },
    },
  
    /*
      Defines the getters on the Vuex module.
    */
    getters: {
        /*
            Returns whether or not the pop out is shown or hidden.
        */
        getShowTab1( state ){
            return state.showTab1;
        },
        getShowTab2( state ){
            return state.showTab2;
        },
    }
}