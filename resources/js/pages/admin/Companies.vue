<template>
    <div>
        <div class="loader"  v-if="companiesLoadStatus !== 2">
            <div class="box one"></div>
            <div class="box two"></div>
            <div class="box three"></div>
        </div>
        <div id="companies" v-if="companiesLoadStatus === 2">
            <template>
                <div class="floating-div">
                    <v-btn 
                        style="background: #2c93e8;"
                        class="mobile-add" 
                    >
                        <i class="fa fa-plus my-float"></i>
                    </v-btn>
                </div>
            </template>
            <v-data-table
                :headers="headers"
                :items="companies"
                sort-by="name"
                class="elevation-1"
                :search="search"
            >
                <template v-slot:top>
                    <v-toolbar flat color="rgb(182, 213, 239)">
                        <v-toolbar-title>All Companies</v-toolbar-title>
                        <v-divider
                            class="mx-4"
                            inset
                            vertical
                        >
                        </v-divider>
                        <v-spacer></v-spacer>
                        <v-dialog v-model="dialog" max-width="800px">
                            <template v-slot:activator="{ on }">
                                <div class="text-center">
                                    <v-btn 
                                        style= "background: rgb(16, 129, 221);" 
                                        class="mx-2" 
                                        v-on="on"
                                        dark
                                    >
                                        + New Company
                                    </v-btn>
                                </div>
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
                                            <v-flex xs12 sm6 md4>
                                                <v-text-field v-model="editedItem.about" label="About"></v-text-field>
                                            </v-flex>
                                            <v-flex xs12 sm6 md4>
                                                <!--<input type="hidden" v-model="editedItem.industry.id">-->
                                                <v-select
                                                    v-model="editedItem.industry"
                                                    :items="industries"
                                                    item-text="name"
                                                    label="Industry"
                                                    return-object
                                                    single-line
                                                >
                                                </v-select>
                                            </v-flex>
                                            <v-flex xs12 sm6 md4>
                                                <v-text-field v-model="editedItem.company_email" label="Company Email"></v-text-field>
                                            </v-flex>
                                            <v-flex xs12 sm6 md4>
                                                <v-text-field v-model="editedItem.address" label="Address"></v-text-field>
                                            </v-flex>
                                            <v-flex xs12 sm6 md4>
                                                <v-text-field v-model="editedItem.website" label="Website"></v-text-field>
                                            </v-flex>
                                            <v-flex xs12 sm6 md4>
                                                <v-text-field v-model="editedItem.twitter_url" label="Twitter"></v-text-field>
                                            </v-flex>
                                            <v-flex xs12 sm6 md4>
                                                <v-text-field v-model="editedItem.facebook_url" label="Facebook"></v-text-field>
                                            </v-flex>
                                            <v-flex xs12 sm6 md4>
                                                <v-text-field v-model="editedItem.linkedin_url" label="LinkedIn"></v-text-field>
                                            </v-flex>
                                            <v-flex xs12 sm6 md4>
                                                <FeaturedImage v-model="editedItem.logo"/>
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
    import { authHeader } from '../../authHelper';
    import FeaturedImage from '../../components/FeaturedImage'

    export default {
        components: {
            FeaturedImage,
        },
        data: () => ({
            search: '',
            industries: [],
            industry: '',
            dialog: false,
            headers: [
                {
                text: 'Name',
                align: 'left',
                sortable: false,
                value: 'name',
                },
                { text: 'Company Email', value: 'company_email' },
                { text: 'Website', value: 'website', sortable: false  },
                { text: 'Industry', value: 'industry.name'  },
                { text: 'No. of Posts', value: 'jobs_count'},
                { text: 'Actions', value: 'action', sortable: false },
            ],
            editedIndex: -1,
            editedItem: {
                industry: '',
                name: '',
                about: '',
                company_email: '',
                contact_number: '',
                address: '',
                website: '',
                twitter_url: '',
                facebook_url: '',
                linkedin_url: '',
                logo: ''
            },
            defaultItem: {
                industry: '',
                name: '',
                about: '',
                company_email: '',
                contact_number: '',
                address: '',
                website: '',
                twitter_url: '',
                facebook_url: '',
                linkedin_url: '',
                logo: ''
            },
        }),
        created () {
            this.initialize();
        },
        computed: {
            formTitle () {
                return this.editedIndex === -1 ? 'New Company' : 'Edit Company'
            },
            /*
                Gets the companies load status
            */
            companiesLoadStatus(){
                return this.$store.getters.showCompaniesLoadStatus;
            },

            /*
                Gets the companies
            */
            companies(){
                return this.$store.getters.fetchCompanies;
            }
        },
        watch: {
            dialog (val) {
                val || this.close()
            },
        },
        methods: {
            initialize () {
                this.$store.dispatch('LoadCompanies')

                const requestOptions = {
                    headers: { ...authHeader()},
                    params: {
                        search: this.companyName
                    },
                };

                axios.get( FS_CONFIG.API_URL + '/industries', requestOptions)
                .then( function( response ){
                    this.industries = response.data;
                }.bind(this));
            },
            editItem (item) {
                console.log('Hey')
                this.editedIndex = this.companies.indexOf(item)
                this.editedItem = Object.assign({}, item)
                this.dialog = true
            },
            deleteItem (item) {
                if( confirm( 'Are you sure you want to delete this company?' ) ){
                    this.$store.dispatch( 'DeleteCompany', {
                        companyID: item.id
                    });
                }
            },
            close () {
                this.dialog = false
                setTimeout(() => {
                this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
                }, 300)
                
                this.editedItem.logo = ''
            },
            save () {
                if (this.editedIndex > -1) {
                    this.$store.dispatch( 'UpdateCompany', {
                        id: this.editedItem.id,
                        industry_id: this.editedItem.industry.id,
                        name: this.editedItem.name,
                        about: this.editedItem.about,
                        company_email: this.editedItem.company_email,
                        contact_number: this.editedItem.contact_number,
                        address: this.editedItem.address,
                        website: this.editedItem.website,
                        twitter_url: this.editedItem.twitter_url,
                        facebook_url: this.editedItem.facebook_url,
                        linkedin_url: this.editedItem.linkedin_url,
                        logo: this.editedItem.logo,
                    });
                } else {
                    this.$store.dispatch('AddCompany', {
                        industry_id: this.editedItem.industry.id,
                        name: this.editedItem.name,
                        about: this.editedItem.about,
                        company_email: this.editedItem.company_email,
                        contact_number: this.editedItem.contact_number,
                        address: this.editedItem.address,
                        website: this.editedItem.website,
                        twitter_url: this.editedItem.twitter_url,
                        facebook_url: this.editedItem.facebook_url,
                        linkedin_url: this.editedItem.linkedin_url,
                        logo: this.editedItem.logo,
                    });
                }
                this.close()
            },
        },
    }
</script>


<style scoped >
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


