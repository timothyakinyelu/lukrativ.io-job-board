<template>
    <transition name="slide-fade">
        <nav class="sidebar sidebar-offcanvas"
            id="sidebar"
        >
            <ul class="nav" 
                style="padding-left: 0;"
            >
                <li class="nav-item" @click="hideNav">
                    <router-link :to="{ name: 'dashboard' }" class="nav-link">
                        <i class="mdi mdi-home menu-icon"></i>
                        <span class="menu-title">Dashboard</span>
                    </router-link>
                </li>
                <li class="nav-item">
                    <a class="nav-link" 
                        data-toggle="collapse" 
                        href="#ui-basic" 
                        aria-expanded="false" 
                        aria-controls="ui-basic"
                    >
                        <i class="mdi mdi-account-supervisor-circle menu-icon"></i>
                        <span class="menu-title">User Management</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="ui-basic">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item" @click="hideNav"> 
                            <router-link :to="{ name: 'users' }"  class="nav-link">Users</router-link>
                        </li>
                    </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" 
                        data-toggle="collapse" 
                        href="#auth" 
                        aria-expanded="false" 
                        aria-controls="auth"
                    >
                        <i class="mdi mdi-library menu-icon"></i>
                        <span class="menu-title">Job Management</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="auth">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item" @click="hideNav"> 
                                <router-link :to="{ name: 'jobs' }" class="nav-link">Verified Jobs </router-link>
                            </li>
                            <li class="nav-item" @click="hideNav"> 
                                <router-link :to="{ name: 'unverifiedjobs' }" class="nav-link">Unverified Jobs </router-link>
                            </li>
                            <li class="nav-item" @click="hideNav"> 
                                <router-link :to="{ name: 'newjob' }" class="nav-link"> New Job </router-link>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" 
                        data-toggle="collapse" 
                        href="#post-info" 
                        aria-expanded="false" 
                        aria-controls="post-info"
                    >
                        <i class="mdi mdi-book-open menu-icon"></i>
                        <span class="menu-title">Job Information</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="post-info">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item" @click="hideNav"> 
                                <router-link :to="{ name: 'companies' }" class="nav-link"> Companies </router-link>
                            </li>
                            <li class="nav-item" @click="hideNav"> 
                                <router-link :to="{ name: 'industries' }" class="nav-link"> Industries </router-link>
                            </li>
                            <li class="nav-item" @click="hideNav"> 
                                <router-link :to="{ name: 'jobtypes' }" class="nav-link"> Job Types </router-link>
                            </li>
                            <li class="nav-item" @click="hideNav"> 
                                <router-link :to="{ name: 'jobfields' }" class="nav-link" > Job Fields </router-link>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item" @click="hideNav">
                    <a class="nav-link" href="documentation/documentation.html">
                    <i class="mdi mdi-file-document-box-outline menu-icon"></i>
                    <span class="menu-title">Documentation</span>
                    </a>
                </li>
            </ul>
        </nav>
    </transition>
</template>

<script>
    import { EventBus } from '../../event-bus';
    export default {
        methods: {
            hideNav(){
                this.$store.dispatch( 'toggleShowPopOut', { showPopOut: false } );
                
                let side = document.getElementById('sidebar');
                side.classList.remove("active");
            },
        },
        computed: {
            /*
                Gets whether or not the popout should be shown or not.
            */
            showPopOut(){
                return this.$store.getters.getShowPopOut;
            },
            /*
                Determines if we should show the popout.
            */
            showRightNav(){
                return this.showPopOut;
            },
        }
    }
</script>

<style scoped>
    .sidebar {
        min-height: calc(100vh - 60px);
        background: #ffffff;
        font-family: "Roboto", sans-serif;
        font-weight: 400;
        padding: 0;
        width: 257px;
        z-index: 11;
        transition: width 0.25s ease, background 0.25s ease;
        box-shadow: none;
        border-right: 1px solid #e3e3e3;
    }
    .sidebar .nav:not(.sub-menu) {
        margin-top: .3rem;
    }
    .sidebar .nav {
        overflow: hidden;
        flex-wrap: nowrap;
        flex-direction: column;
        margin-bottom: 60px;
    }
    .sidebar .nav:not(.sub-menu) > .nav-item {
        border-bottom: 1px solid #f3f3f3;
        margin-top: 0;
    }
    .sidebar .nav.sub-menu .nav-item {
        padding: 0;
    }
    .sidebar .nav .nav-item {
        transition-duration: 0.25s;
        transition-property: background;
    }
    .sidebar .nav .nav-item.active > .nav-link {
        background: initial;
        position: relative;
    }
    .sidebar .nav .nav-item .nav-link {
        display: flex;
        align-items: center;
        white-space: nowrap;
        padding: 0.75rem 2.5rem 0.75rem 1.25rem;
        color: #000;
        transition-duration: 0.45s;
        transition-property: color;
    }
    .sidebar .nav .nav-item.active > .nav-link i, 
    .sidebar .nav .nav-item.active > .nav-link .menu-title, 
    .sidebar .nav .nav-item.active > .nav-link .menu-arrow {
        color: #4d83ff;
    }
    .sidebar .nav .nav-item .nav-link i.menu-arrow {
        display: inline-block;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        margin-left: auto;
        margin-right: 0;
        color: #000;
    }
    .sidebar .nav .nav-item .nav-link i.menu-icon {
        font-size: 1.125rem;
        line-height: 1;
        margin-right: 1.125rem;
        color: inherit;
    }
    .sidebar .nav .nav-item .nav-link i {
        color: inherit;
    }
    .sidebar .nav .nav-item .nav-link[aria-expanded="true"] i.menu-arrow:before {
        transform: rotate(180deg);
    }
    .sidebar .nav .nav-item .nav-link i.menu-arrow:before {
        content: "\F140";
        font-family: "Material Design Icons";
        font-style: normal;
        display: block;
        font-size: 1rem;
        line-height: 10px;
        transition: all 0.2s ease-in;
    }
    .sidebar .nav .nav-item .nav-link .menu-title {
        color: inherit;
        display: inline-block;
        font-size: 0.875rem;
        line-height: 1;
        vertical-align: middle;
        font-family: 'Philosopher', 'Sans-serif';
        font-weight: 600;
    }
    .sidebar .nav.sub-menu .nav-item .nav-link {
        color: #656565;
        padding: 0.6rem 1rem;
        position: relative;
        font-size: 0.875rem;
        line-height: 1;
        height: auto;
        border-top: 0;
    }
    .sidebar .nav.sub-menu {
        margin-bottom: 0;
        margin-top: 0;
        list-style: none;
        padding: 0.25rem 0 0.6rem 3.55rem;
    }
    /* Enter and leave animations can use different */
    /* durations and timing functions.              */
    .slide-fade-enter-active {
        transition: all .3s ease;
    }
    .slide-fade-leave-active {
        transition: all .8s cubic-bezier(1.0, 0.5, 0.8, 1.0);
    }
    .slide-fade-enter, .slide-fade-leave-to
    /* .slide-fade-leave-active below version 2.1.8 */ {
        transform: translateX(10px);
        opacity: 0;
    }
    @media screen and (max-width: 991px)
    {    
        .sidebar-offcanvas {
            position: fixed;
            max-height: calc(100vh - 60px);
            top: 60px;
            bottom: 0;
            overflow: auto;
            right: -257px;
            transition: all 0.25s ease-out;
        }
        .sidebar-offcanvas.active {
            left: 0;
            display: block;
        }
    }
    @media screen and (max-width: 768px) {
        .sidebar {
            width: 100%;
            display: none
        }
    }
</style>

