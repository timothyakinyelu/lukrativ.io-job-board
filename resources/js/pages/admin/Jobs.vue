
<template>
    <div>
        <div class="loader" v-if="jobsLoadStatus !== 2">
            <div class="box one"></div>
            <div class="box two"></div>
            <div class="box three"></div>
        </div>
        <div id="drafts" v-if="jobsLoadStatus === 2">
            <v-data-table
                :headers="headers"
                :items="jobs.data"
                sort-by="id"
                class="elevation-1"
                :search="search"
            >
                <template v-slot:top>
                    <v-toolbar flat color="rgb(182, 213, 239)">
                        <v-toolbar-title>Verified Jobs</v-toolbar-title>
                        <v-divider
                        class="mx-4"
                        inset
                        vertical
                        ></v-divider>
                        <v-spacer></v-spacer>
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
                { text: 'Date Verified', value: 'date_verified'},
                { text: 'Verified By', value: 'verified_by'},
                { text: 'Actions', value: 'action', sortable: false },
            ],
        }),
        created() {
            this.initialize();
        },
        methods: {
            initialize() {
                this.$store.dispatch('loadVerifiedJobs')
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
            }
        },
        computed: {
            /*
                Gets the load status
            */
            jobsLoadStatus(){
                return this.$store.getters.getJobsLoadStatus;
            },

            jobs() {
                return this.$store.getters.getVerified;
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
        left: 15vw;
    }
    .elevation-1 {
        margin: 20px;
    }
    .mobile-search {
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