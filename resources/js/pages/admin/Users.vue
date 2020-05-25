<template>
    <div>
        <div class="loader"  v-if="usersLoadStatus !== 2">
            <div class="box one"></div>
            <div class="box two"></div>
            <div class="box three"></div>
        </div>
        <div id="users" v-if="usersLoadStatus === 2">
            <v-data-table
                :headers="headers"
                :items="users.data"
                sort-by="role"
                class="elevation-1"
                :search="search"
            >
                <template v-slot:top>
                    <v-toolbar flat color="rgb(182, 213, 239)">
                        <v-toolbar-title>All Users</v-toolbar-title>
                        <v-divider
                            class="mx-4"
                            inset
                            vertical
                        ></v-divider>
                        <v-spacer></v-spacer>
                        <v-dialog v-model="dialog" max-width="600px">
                            <template v-slot:activator="{ on }">
                                <v-btn 
                                    style= "background: rgb(16, 129, 221);" 
                                    class="mx-2" 
                                    v-on="on"
                                    dark
                                >
                                    + New User
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
                                                <v-text-field v-model="editedItem.first_name" label="First Name"></v-text-field>
                                            </v-flex>
                                            <v-flex xs12 sm6 md4>
                                                <v-text-field v-model="editedItem.last_name" label="Last Name"></v-text-field>
                                            </v-flex>
                                            <v-flex xs12 sm6 md4>
                                                <v-text-field v-model="editedItem.email" label="Email"></v-text-field>
                                            </v-flex>
                                            <v-flex xs12 sm6 md4>
                                                <v-select
                                                    v-model="editedItem.permission"
                                                    :items="items"
                                                    item-text="name"
                                                    item-value="id"
                                                    label="Role"
                                                    return-object
                                                    single-line
                                                >
                                                </v-select>
                                            </v-flex>
                                            <v-flex xs12 sm6 md4>
                                                <FeaturedImage v-model="editedItem.avatar"/>
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
    import { FS_CONFIG } from '../../config';
    import FeaturedImage from '../../components/FeaturedImage'

    export default {
        components: {
            FeaturedImage,
        },
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
                { text: 'Email', value: 'email', sortable: false },
                { text: 'Permission', value: 'permission'},
                { text: 'Role', value: 'role', sortable: true  },
                { text: 'Actions', value: 'action', sortable: false },
            ],
            items: [
                { id: 0, name: 'User' },
                { id: 1, name: 'Employer' },
                { id: 2, name: 'Admin' },
                { id: 3, name: 'Super Admin' }
            ],
            editedIndex: -1,
            editedItem: {
                first_name: '',
                last_name: '',
                email: '',
                permission: '',
                avatar: ''
            },
            defaultItem: {
                first_name: '',
                last_name: '',
                email: '',
                permission: '',
                avatar: ''
            },
        }),
        computed: {
            formTitle () {
                return this.editedIndex === -1 ? 'New User' : 'Edit User'
            },

            /*
                Gets the users load status
            */
            usersLoadStatus(){
                return this.$store.getters.showUsersLoadStatus;
            },

            /*
                Gets the users
            */
            users(){
                return this.$store.getters.fetchUsers;
            },
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
                this.$store.dispatch('LoadUsers');
            },

            editItem (item) {
                this.editedIndex = this.users.indexOf(item)
                this.editedItem = Object.assign({}, item)
                this.dialog = true
            },

            deleteItem (item) {
                if( confirm( 'Are you sure you want to delete this user?' ) ){
                    this.$store.dispatch( 'DeleteUser', {
                        userID: item.id
                    });
                }
            },

            close () {
                this.editedItem.avatar = ''
                this.dialog = false
                setTimeout(() => {
                    this.editedItem = Object.assign({}, this.defaultItem)
                    this.editedIndex = -1
                }, 300)
            },

            save () {
                if (this.editedIndex > -1) {
                    this.$store.dispatch( 'UpdateUser', {
                        id: this.editedItem.id,
                        first_name: this.editedItem.first_name,
                        last_name: this.editedItem.last_name,
                        email: this.editedItem.email,
                        permission: this.editedItem.permission.id,
                        avatar: this.editedItem.avatar
                    });
                } else {
                    this.$store.dispatch('AddUser', {
                        first_name: this.editedItem.first_name,
                        last_name: this.editedItem.last_name,
                        email: this.editedItem.email,
                        permission: this.editedItem.permission.id,
                        avatar: this.editedItem.avatar
                    });
                }
                this.close()
            },
        }
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
    .v-text-field.search {
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
    /* .v-text-field--single-line {
        position: absolute;
        left: 13vw;
    }
    .v-select {
        left: 25vw;
        width: 10vw;
    } */


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