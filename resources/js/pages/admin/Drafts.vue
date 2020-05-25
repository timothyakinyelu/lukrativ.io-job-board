
<template>
    <div>
        <div class="loader"  v-if="jobsLoadStatus !== 2">
            <div class="box one"></div>
            <div class="box two"></div>
            <div class="box three"></div>
        </div>
        <div id="drafts" v-if="jobsLoadStatus === 2">
            <template >
                <div class="floating-div">
                    <v-btn 
                    style="background: #2c93e8;"
                    class="mobile-add" 
                    >
                        <router-link :to="{ name: 'newjob' }">
                            <i class="fa fa-plus my-float"></i>
                        </router-link>
                    </v-btn>
                </div>
            </template>
            <v-data-table
                :headers="headers"
                :items="jobs.data"
                sort-by="id"
                class="elevation-1"
                :search="search"
            >
                <template v-slot:top>
                    <v-toolbar flat color="rgb(182, 213, 239)">
                        <v-toolbar-title>Unverified Jobs</v-toolbar-title>
                        <v-divider
                        class="mx-4"
                        inset
                        vertical
                        ></v-divider>
                        <v-spacer></v-spacer>
                        <v-dialog max-width="500px">
                            <template v-slot:activator="{ on }">
                                <div class="text-center">
                                    <v-btn 
                                        style="background: rgb(16, 129, 221);"
                                        class="mx-2" 
                                        v-on="on"
                                    >
                                        <router-link :to="{ name: 'newjob' }">+ New Job</router-link>
                                    </v-btn>
                                </div>
                            </template>
                        </v-dialog>
                        <v-text-field
                            v-model="search"
                            append-icon="search"
                            label="Search"
                            single-line
                            hide-details
                            class="search"
                        >
                        </v-text-field>
                        <v-text-field
                            v-model="search"
                            append-icon="search"
                            hide-details
                            class="mobile-search"
                        >
                        </v-text-field>
                    </v-toolbar>
                </template>
                <template v-slot:item.action="{ item }">
                    <v-icon
                        small
                        style="color:#2c93e8"
                        class="mr-2"
                        @click="editJob(item.id)"
                    >
                        edit
                    </v-icon>
                    <v-icon
                        small
                        style="color:#e3342f"
                        class="mr-2"
                        @click="deleteJob(item.id)"
                    >
                        delete
                    </v-icon>
                    <v-icon
                        small
                        style="color:#38c172"
                       @click="verify(item.id)"
                    >
                        verified_user
                    </v-icon>
                </template>
                <template v-slot:no-data>
                    <v-btn color="primary" @click="initialize">Reset</v-btn>
                </template>
            </v-data-table>
        </div>
    </div>
    
</template>

<script>
    export default {
        data: () => ({
            search: '',
            headers: [
                { text: '#', align: 'left', value: 'id'},
                { text: 'Company', value: 'company'},
                { text: 'Title', value: 'title' },
                { text: 'Location', value: 'location' },
                { text: 'Date Created', value: 'date_created',},
                { text: 'Actions', value: 'action', sortable: false },
            ],
        }),
        created() {
            this.initialize();
        },
        methods: {
            initialize() {
                this.$store.dispatch('loadUnVerifiedJobs')
            },
            editJob: function (id) {
                const jobID = id
                
                this.$router.push({ name: 'editjob', params: { id: jobID }})
            },
            
            deleteJob: function(id){
                if( confirm( 'Are you sure you want to delete this post?' ) ){
                    this.$store.dispatch( 'deleteJob', {
                        jobID: id
                    });
                }
            },
            verify: function(id) {
                if( confirm( 'Are you sure you want to verify this draft?' ) ){
                    this.$store.dispatch( 'verifyJob', {
                        jobID: id
                    })
                    .then(function(response) {
                        confirm('Job Verified');
                    })
                    .catch(function() {
                        alert('Unable to verify job')
                    });
                }
            },
        },
        computed: {
            /*
                Gets the load status
            */
            jobsLoadStatus(){
                return this.$store.getters.getJobsLoadStatus;
            },

            jobs() {
                return this.$store.getters.getDrafts
            }
        },
    }
</script>

<style scoped>
    .theme--light.v-data-table {
        background-color: #f8f9fa;
    }
    .theme--dark.v-btn:not(.v-btn--flat):not(.v-btn--text):not(.v-btn--outlined) {
        background-color: #6cb2eb;
    }
    .v-btn span a {
        color: #ffffff;
        text-decoration: none;
    }
    .v-text-field {
        position: absolute;
        left: 17vw;
    }
    .elevation-1 {
        margin: 20px;
    }
    .mobile-search {
        display: none;
    }
    .mobile-add {
        display: none;
    }
    .v-data-table table {
        background: #ffffff;
    }
    .loader {
        position: relative;
        right: 0;
        top: 40vh;
    }
    .box {
        position: relative;
        display: inline-block;
        top: 50%;
        left: 45%;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        margin-right: 30px;
        animation: bubble 3s ease-in-out infinite;
    }
    .one {
        background-color: tomato;
        animation-delay: 0.2s;
    }
    .two {
        background-color: yellow;
        animation-delay: 0.4s;
    }
    .three {
        background-color: green;
        animation-delay: 0.6s;
    }

    @keyframes bubble {
        0% {
            transform: scale(1);
            opacity: 1;
        }

        50% {
            transform: scale(1.7);
            opacity: 0;
        }

        100% {
            transform: scale(1);
            opacity: 0.8;
        }
    }

    .theme--light.v-sheet {
        font-weight: bolder;
    }


    @media (max-width: 991px)
    {   .mobile-search {
            display: block;
            width: 30vw;
            left: 55vw;
        }
        .search {
            display: none;
        }
        .mobile-add {
            position:fixed;
            width:50px;
            height:50px;
            /* bottom:40px; */
            right:40px;
            background-color:#0C9;
            color:#FFF;
            border-radius:50px;
            text-align:center;
            box-shadow: 2px 2px 3px #999;
            display: block;
        }
        .mx-2 {
            display: none;
        }
        .mobile-add.v-btn:not(.v-btn--round).v-size--default {
            height: 50px;
            min-width: 50px;
            cursor: pointer;
        }
        .mobile-add.v-btn.v-size--default, .v-btn.v-size--large {
            font-size: 1rem;
        }
        .floating-div {
            z-index: 999;
            position: absolute;
            bottom: 22vh;
        }
        .my-float{
            margin-top:5px;
        }
        .v-divider--vertical {
            display: none;
        }
    }

    @media (max-width: 768px) {
        .loader {
            right: 17vw;
        }
    }
</style>