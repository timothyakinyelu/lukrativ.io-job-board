<template>
    <div>
        <div class="search-container" style="width: 100%;">
            <div class="main-form-container">
                <form id="ldsf" class="" role="search" @submit.prevent="search">
                    <div class="form-row">
                        <div class="col-7" id="input-wrap">
                            <input type="text" 
                                class=" form-control main-input main-name" 
                                v-model="keyword"
                                placeholder="Company, Job Title or Keywords" 
                            />
                        </div>
                        <div class="col-4" id="input-wrap-location">
                            <i class="fa fa-map-marker"></i>
                            <input id="location" 
                                type="text" 
                                class="form-control main-location location" 
                                v-model="locale"  
                                style="padding-left: 20px;" 
                                placeholder="Location"
                            />
                        </div>
                        <div class="col-1">
                            <button id="main-submit"
                                aria-label="search" 
                                class="btn btn" 
                                type="submit" 
                                tabindex="0"
                                :disabled="keyword === '' && locale === ''"
                            >
                                <!-- <i class="fa fa-search"></i> -->
                                <span>Submit</span>
                            </button>
                        </div>
                        
                    </div> 
                </form>
            </div>

            <!-- mobile search -->
            <div class="mobile-form-container">
                <a class="" href="#" data-toggle="dropdown" id="searchBox">
                    <i class="fa fa-search"></i>
                </a>
                <div
                    class="dropdown-menu dropdown-menu-right"
                    aria-labelledby="searchBox"
                >
                    <form id="ldsf" role="search" class="" method="get" >
                        <div class="form-row">
                            <div class="col input-wrap">
                                <input type="text" 
                                    class="form-control main-input main-name" 
                                    name="keyword"  
                                    value="" 
                                    placeholder="Company, Job Title or Keywords" 
                                />
                            </div>

                            <div class="button-wrap">
                                <button id="main-submit" 
                                    aria-label="mobile-search"
                                    class="btn btn" 
                                    type="submit" 
                                    tabindex="0"
                                    :disabled="keyword === ''"
                                >
                                    <span>Submit</span>
                                </button>
                            </div>
                        </div> 
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { EventBus } from '../event-bus';
    export default {
        data:() => ({
            keyword: '',
            locale: ''
        }),
        methods: {
            search() {
                this.$router.push({ path: '/search/', query: {q: this.keyword, l: this.locale} })
            }
        },
    }
</script>

<style scoped>
    form#ldsf {
        margin-left: 100px;
        margin-right: 100px;
    }
    form#ldsf > .form-row >.col {
        padding-top: 0;
    }
    .form-row {
        justify-content: center;
    }
    .form-row .input-wrap {
        padding: 0;
    }
    .main-form-container {
        position: relative;
    }
    .mobile-form-container {
        display: none;
    }
    #input-wrap-location .fa {
        position: absolute;
        top: 20px;
        left: 10px;
        font-size: 20px;
    }
    #main-submit { 
        background: #0b7ddc;
        color: #fff; 
        display: inline-block; 
        font-size: 19px; 
        font-weight: 500;
        text-align: center; 
        cursor: pointer;
        margin-bottom: 0px; 
        background-image: url('/svg/search-icon.svg');
        background-size: 25px;
        background-position: center center;
        background-repeat: no-repeat;
        border-radius: 0 2px 2px 0;
        -webkit-appearance: none;
        border-radius: 0px 4px 4px 0px; 
        width:51px;
        height: calc(2.19rem + 2px);;
        border: 0px;
        padding-top:0px;
    }
    #main-submit span {
        display: none;
    }
    #main-submit:hover { 
        background: #ff5757; 
        color: #fff !important; 
        background-image: url('/svg/search-icon.svg');
        background-size: 25px;
        background-position: center center;
        background-repeat: no-repeat;
        -webkit-appearance: none; 
    }
    .mobile-form-container .dropdown-menu {
        padding: 0;
        margin: 0;
        background-clip: unset;
        border: 0;
        border-radius: 0;
    }
    a#searchBox {
        font-size: 1.5rem;
    }

    @media (max-width: 991px) {
        .search-container {
            width: 100% !important;
        }
        form#ldsf {
            margin-left: 0;
            margin-right: 0;
        }
        form#ldsf > .form-row >.col {
            max-width: 62.5vw;
            height: fit-content;
        }
        .mobile-form-container {
            display: block;
        }

        .main-form-container {
            display: none;
        }
        #ldsf input.main-input {
            width: 60vw;
            font-size: .9rem;
        }
        .input-wrap {
            padding-right: 0 !important;
            padding-left: 0 !important;
        }
    }
</style>