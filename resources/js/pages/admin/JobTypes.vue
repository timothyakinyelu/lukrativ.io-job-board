<template>
    <div>
        <div class="loader"  v-if="jobtypesLoadStatus !== 2">
            <div class="box one"></div>
            <div class="box two"></div>
            <div class="box three"></div>
        </div>
        <div id="jobtypes" v-if="jobtypesLoadStatus === 2">
            <v-data-table
                :headers="headers"
                :items="jobtypes"
                sort-by="name"
                class="elevation-1"
                :search="search"
            >
                <template v-slot:top>
                    <v-toolbar flat color="rgb(182, 213, 239)">
                        <v-toolbar-title>All Job type</v-toolbar-title>
                        <v-divider
                            class="mx-4"
                            inset
                            vertical
                        ></v-divider>
                        <v-spacer></v-spacer>
                        <v-dialog v-model="dialog" max-width="500px">
                            <template v-slot:activator="{ on }">
                                <v-btn style= "background: rgb(16, 129, 221);" 
                                    class="mx-2" 
                                    dark
                                    v-on="on"
                                >
                                    + New Job type
                                </v-btn>
                            </template>
                            <v-card>
                                <v-card-title>
                                    <span class="headline">{{ formTitle }}</span>
                                </v-card-title>

                                <v-card-text>
                                    <v-container grid-list-md>
                                        <v-layout wrap>
                                            <v-flex xs12 sm6 md4>
                                                <v-text-field v-model="editedItem.name" label="Name"></v-text-field>
                                            </v-flex>
                                        </v-layout>
                                    </v-container>
                                </v-card-text>

                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn color="blue darken-1" text @click="close">Cancel</v-btn>
                                    <v-btn color="blue darken-1" text @click="save">Save</v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>
                    </v-toolbar>
                </template>
                <template v-slot:item.action="{ item }">
                    <v-icon
                        small
                        style="color:#2c93e8"
                        class="mr-2"
                        @click="editItem(item)"
                    >
                        edit
                    </v-icon>
                    <v-icon
                        small
                        style="color:#e3342f"
                        @click="deleteItem(item)"
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
            dialog: false,
            headers: [
                {
                    text: 'Name',
                    align: 'left',
                    sortable: false,
                    value: 'name',
                },
                { text: 'No. of Posts', value: 'jobs_count'},
                { text: 'Actions', value: 'action', sortable: false },
            ],
            editedIndex: -1,
            editedItem: {
                name: ''
            },
            defaultItem: {
                name: ''
            },
        }),

        computed: {
            formTitle () {
                return this.editedIndex === -1 ? 'New Job type' : 'Edit Job type'
            },
            /*
                Gets the jobtypes load status
            */
            jobtypesLoadStatus(){
                return this.$store.getters.showJobtypesLoadStatus;
            },

            /*
                Gets the industries
            */
            jobtypes(){
                return this.$store.getters.fetchJobtypes;
            }
        },
        watch: {
            dialog (val) {
                val || this.close()
            },
        },
        created () {
            this.initialize();
        },
        methods: {
            initialize () {
                this.$store.dispatch('LoadJobtypes')
            },
            editItem (item) {
                this.editedIndex = this.jobtypes.indexOf(item)
                this.editedItem = Object.assign({}, item)
                this.dialog = true
            },
            deleteItem (item) {
                if( confirm( 'Are you sure you want to delete this job type?' ) ){
                    this.$store.dispatch( 'DeleteJobtype', {
                        jobtypeID: item.id
                    });
                }
            },
            close () {
                this.dialog = false
                setTimeout(() => {
                    this.editedItem = Object.assign({}, this.defaultItem)
                    this.editedIndex = -1
                }, 300)
            },
            save () {
                if (this.editedIndex > -1) {
                    this.$store.dispatch( 'UpdateJobtype', {
                        id: this.editedItem.id,
                        name: this.editedItem.name,
                        slug: this.editedItem.slug,
                    });
                } else {
                    this.$store.dispatch('AddJobtype', {
                        name: this.editedItem.name,
                        slug: this.editedItem.slug,
                    });
                }
                this.close()
            },
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
    .v-text-type.search {
        position: absolute;
        left: 15vw;
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
    .v-btn span a {
        color: #ffffff;
        text-decoration: none;
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