
<template>
    <v-app>
        <div class="container-scroller">
            <Navbar 
                v-if="userLoadStatus == 2" 
                :user = "user"
                :isLoggedIn= "isLoggedIn"
            />
            <div class="container-fluid page-body-wrapper"> 
                <Sidebar />
                <div class="main-panel">
                    <router-view :key="$route.fullPath"></router-view>
                </div>
            </div>
        </div>
    </v-app>
</template>

<script>
    import Navbar from '../navigations/admin/Navbar' 
    import Sidebar from '../navigations/admin/Sidebar'

    export default {
        components: { 
            Navbar,
            Sidebar 
        },
        created() {
            this.$store.dispatch('loadUser') 
        },
        computed: {
            user() {
                return this.$store.getters.getUser
            },
            userLoadStatus() {
                return this.$store.getters.getUserLoadStatus();
            },
            authStatus() {
                return this.$store.getters.getAuthStatus
            },
            isLoggedIn() {
                return this.$store.getters.isLoggedIn
            },
            unverified() {
                return this.$store.getters.getDrafts;
            }
        },
    }
</script>

<style >
    .container-scroller {
        overflow: hidden;
    }
    .page-body-wrapper {
        min-height: calc(100vh - 60px);
        display: -webkit-flex;
        display: flex;
        -webkit-flex-direction: row;
        flex-direction: row;
        padding-left: 0;
        padding-right: 0;
        padding-top: 60px;
    }
    .theme--light.v-application {
        background: initial;
    }
    @media (max-width: 991px)
    {   .main-panel {
            margin-left: 0;
            width: 100% !important;
        }
    }
    .main-panel {
        width: calc(100% - 257px);
        min-height: calc(100vh - 60px);
        display: flex;
        flex-direction: column;
        background-color: #dee2e6;
    }
    .sidebar .nav.sub-menu .nav-item .nav-link.router-link-active,
    .dropdown-item.router-link-active {
        opacity: 1;
        visibility: visible;
        border-left-color: #4DB6AC;
        color: red;
        transition: all 0.25s;
    }
</style>