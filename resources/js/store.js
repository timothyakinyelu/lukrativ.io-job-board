//VUEX store.js

/*
    Adds the promise polyfill for IE 11
*/
require('es6-promise').polyfill();

import Vue from 'vue'
import Vuex from 'vuex'

import { auth } from './modules/admin/auth'
import { display } from './modules/admin/sideNav'
import { jobs } from './modules/admin/jobs'
import { companies } from './modules/admin/companies'
import { industries } from './modules/admin/industries'
import { jobfields } from './modules/admin/jobfields'
import { jobtypes } from './modules/admin/jobtypes'
import { users } from './modules/admin/users'
import { settings } from './modules/settings'
import { posts } from './modules/frontend/posts'
import { tab } from './modules/frontend/tabToggle'

Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        auth,
        display,
        jobs,
        companies,
        industries,
        jobfields,
        jobtypes,
        users,
        settings,
        posts,
        tab
    }
})