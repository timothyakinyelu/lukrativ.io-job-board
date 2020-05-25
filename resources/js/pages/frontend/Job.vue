<template>
    <div class="container JD">
        <div class="row">
            <div class="col-sm-12 col-lg-9 container">
                <ul class="nav nav-tabs">
                    <li class="nav-item"
                        :class="{active: tab1 === true}"
                        @click="setTab1"
                    >
                        <a id="description-tab" 
                            role="tab" 
                            class="nav-link"
                        >  
                            Description
                        </a>
                    </li>
                    <li class="nav-item"
                        @click="setTab2"
                        :class="{active: tab2 === true}"
                    >
                        <a id="company-tab" 
                            role="tab" 
                            class="nav-link"
                        >
                            company
                        </a>
                    </li>
                </ul>
                <Description 
                    aria-labelledby="description-tab"
                    role="tabpanel"
                    v-if="tab1"
                    :job= "job"
                />
                <CompanyInfo 
                    aria-labelledby="company-tab"
                    role="tabpanel"
                    v-if="tab2"
                    :job= "job"
                />
            </div>
            <div class="col-sm-12 col-lg-3">
                <Related 
                    v-if="related"
                    :related= "related"
                />
            </div>
        </div>
    </div>
</template>

<script>
    import Description from '../../components/Description'
    import CompanyInfo from '../../components/CompanyInfo'
    import Related from '../../components/Related'

    export default {
        components: {
            Description,
            CompanyInfo,
            Related
        },
        created() {
            let jobID = this.$route.params.id
            this.$store.dispatch('fetchJob', {id: jobID})

            this.setTab1();
        },
        methods: {
            setTab1() {
                this.$store.dispatch("toggleShowTab1", { showTab1: true});
                this.$store.dispatch("toggleShowTab2", { showTab2: false });
            },
            setTab2() {
                this.$store.dispatch("toggleShowTab2", { showTab2: true});
                this.$store.dispatch("toggleShowTab1", { showTab1: false });
            }
        },
        computed: {
            job() {
                return this.$store.getters.getJob;
            },
            related() {
                return this.$store.getters.getRelated;
            },
            jobLoadStatus() {
                return this.$store.getters.showJobLoadStatus
            },
            tab1() {
                return this.$store.getters.getShowTab1;
            },
            tab2() {
                return this.$store.getters.getShowTab2;
            }
        },
    }
</script>

<style scoped>
    .nav-item.active {
        border: 1px solid #e0e0e0;
        border-top-left-radius: 0.25rem;
        border-top-right-radius: 0.25rem;
    }
    a.nav-link {
        color: #0d7ddc;
    }
    .nav-item.active a.nav-link {
        font-weight: 600;
    }
</style>