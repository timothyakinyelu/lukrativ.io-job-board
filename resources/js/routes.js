/*
|-------------------------------------------------------------------------------
| routes.js
|-------------------------------------------------------------------------------
| Contains all of the routes for the application
*/

/*
    Import Vue and VueRouter to extend with the routes.
*/

import Vue from 'vue'
import VueRouter from 'vue-router'
import store from './store'

import Dashboard from './pages/admin/Dashboard'
import Login from './components/Login'
import Home from './layouts/Home'
import Admin from './layouts/Admin'
import Jobs from './pages/admin/Jobs'
import NewJob from './pages/admin/NewJob'
import EditJob from './pages/admin/EditJob'
import Companies from './pages/admin/Companies'
import Industries from './pages/admin/Industries'
import JobTypes from './pages/admin/JobTypes'
import JobFields from './pages/admin/JobFields'
import Users from './pages/admin/Users'
import Drafts from './pages/admin/Drafts'
import ResetPassword from './pages/settings/ResetPassword'
import ResetPasswordForm from './pages/settings/ResetPasswordForm'
import Profile from './pages/admin/Profile'
import Search from './pages/frontend/Search'
import Job from './pages/frontend/Job'
import FreePost from './pages/frontend/FreePost'
import { permissions } from './constants'


Vue.use(VueRouter) 


/*
	This will cehck to see if the user is authenticated or not.
*/
function requireAuth (to, from, next) {
    let token = localStorage.getItem('token');
	/*
		Determines where we should send the user.
	*/
	function proceed () {
        if (store.getters.getUserLoadStatus() == 2) {
            
            let user = store.getters.getUser;
            // if(to.matched.some(record => record.meta.is_employer)) {
            //     if(user.permission == permissions.EMPLOYER){
            //         next()
            //     }
            //     else{
            //         next('/user/profile')
            //     }
            // }

            if(to.matched.some(record => record.meta.is_admin)) {
                if(user.permission >= permissions.ADMIN){
                    next()
                }
                else{
                    next('/login')
                }
            }

            else if(to.matched.some(record => record.meta.is_super)) {
                if(user.permission == permissions.SUPER_ADMIN){
                    next()
                }
                else {
                    next('/login')
                }
            } else {
                next()
            }
        } else {
            next('/login')
        }
		
    }

    if(to.matched.some(record => record.meta.guest)) {
        if(token == null || token == 'undefined'){
            next()
        }
        else{
            store.dispatch( 'loadUser' );

            /*
                Watch for the user to be loaded. When it's finished, then
                we proceed.
            */
            store.watch( store.getters.getUserLoadStatus, function(){
                if( store.getters.getUserLoadStatus() == 2 ){
                    proceed();
                }
            });
        }
    }else if(!to.matched.some(record => record.meta.guest)) {
        if (token == null || token == 'undefined') {
            proceed()
        } else {
            store.dispatch( 'loadUser' );

            /*
                Watch for the user to be loaded. When it's finished, then
                we proceed.
            */
            store.watch( store.getters.getUserLoadStatus, function(){
                if( store.getters.getUserLoadStatus() == 2 ){
                    proceed();
                }
            });
        }
    }
}

export const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            name: 'resetlink',
            path: '/settings/send-password-reset-link',
            component: ResetPassword
        },
        {
            name: 'reset-password-form', 
            path: '/settings/reset-password/:token', 
            component: ResetPasswordForm,
        },
        {
            name: 'login',
            path: '/login',
            component: Login,
            beforeEnter: requireAuth,
            meta: { 
                guest: true
            }
        },
        {
            name: 'admin',
            path: '/admin',
            component: Admin,
            redirect: { name: 'dashboard' },
            beforeEnter: requireAuth,
            meta: { 
                is_admin: true
            },
            children: [
                { 
                    name: 'dashboard',
                    path: '/',
                    component: Dashboard,
                    meta: {
                        is_super : true
                    }
                },
                {
                    name: 'jobs',
                    path: 'jobs/verified',
                    component: Jobs,
                },
                {
                    name: 'unverifiedjobs',
                    path: 'jobs/unverified',
                    component: Drafts,
                },
                {
                    name: 'newjob',
                    path: 'jobs/new',
                    component: NewJob
                },
                {
                    name: 'editjob',
                    path: 'jobs/:id/edit',
                    component: EditJob
                },
                {
                    name: 'companies',
                    path: 'companies',
                    component: Companies
                },
                {
                    name: 'industries',
                    path: 'industries',
                    component: Industries
                },
                {
                    name: 'jobtypes',
                    path: 'job-types',
                    component: JobTypes
                },
                {
                    name: 'jobfields',
                    path: 'job-fields',
                    component: JobFields
                },
                {
                    name: 'users',
                    path: 'users',
                    component: Users,
                    meta: {
                        requiresAuth: true,
                        is_super : true
                    }
                },
                {
                    name: 'profile',
                    path: 'settings/account/profile',
                    component: Profile
                }
            ]
        },
        {
            name: 'home',
            path: '/',
            component: Home,
            redirect: { name: 'search' },
            children: [
                {
                    name: 'search',
                    path: '/search/',
                    component: Search
                },
                {
                    name: 'job',
                    path: 'job/:id/:slug',
                    component: Job
                },
                {
                    name: 'freepost',
                    path: 'job/post-job-for-free',
                    component: FreePost,
                    meta: { hideSearchBox: true }
                },
            ]
        }
    ]
});



