<template>
    <div>
        <div class="box electron-loader" v-if="jobsLoadStatus === 1"></div>
        <div v-if="jobsLoadStatus === 2">
            <div class="search-text">
                <span></span>
                <header class="title">
                    <div v-if="!$route.query.q && $route.query.l">
                        <h1 class="head">
                            Jobs in <span id="myText">{{ $route.query.l }}</span>
                        </h1>
                        <h2 class="search-count">
                            ({{ jobs.meta.total }} Job(s) Found)
                        </h2>
                    </div>
                    <div v-if="$route.query.q && $route.query.l">
                        <h1 class="head">
                            {{ $route.query.q }} Jobs in <span id="myText">{{ $route.query.l }}</span>
                        </h1>
                        <h2 class="search-count">
                            ({{ jobs.meta.total }} Job(s) Found)
                        </h2>
                    </div>
                    <div v-if="$route.query.q && !$route.query.l">
                        <h1 class="head">
                            {{ $route.query.q }} Jobs
                        </h1>
                        <h2 class="search-count">
                            ({{ jobs.meta.total }} Job(s) Found)
                        </h2>
                    </div>
                    <div v-if="!$route.query.q && !$route.query.l">
                        <h1 class="head">
                            All Job Openings
                        </h1>
                        <h2 class="search-count">
                            ({{ jobs.meta.total }} Job(s) Found)
                        </h2>
                    </div>
                </header>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <article class="single-list col-xs-12 col-lg-4"
                        v-for="job in jobs.data" 
                        :key="job.id"
                    >
                        <router-link :to="{name: 'job', params: {id: job.id, slug: job.slug}}"
                            class="jobLink"
                        >
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="logo-wrapper">
                                            <span>
                                                <img
                                                    :src="job.logo" 
                                                    class="comp-logo" 
                                                    data-retina-ok="true" 
                                                    :alt="job.company" 
                                                    style="opacity: 1;"
                                                >
                                            </span>
                                        </div>
                                        <div class="col-md-8">
                                            <h5 class="card-title card-text">
                                                {{ job.title }}
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <ul>
                                        <li>
                                            <p>
                                                <span class="fa fa-building"></span>
                                                {{ job.company }}
                                            </p>
                                        </li>
                                        <li>
                                            <p>
                                                <span class="fa fa-map-marker"></span>
                                                {{ job.location }}
                                            </p>
                                        </li>
                                        <li>
                                            <p>
                                                <span class="fa fa-clock-o"></span>
                                                Posted {{ job.date_posted }}
                                            </p>
                                        </li>
                                    </ul>
                                    <div class="badge badge-primary active">{{ job.type }}</div>
                                    <div class="badge badge-primary active" 
                                        v-if="job.salary"
                                    >
                                        ₦{{ job.salary }}
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="card-footer-wrapper">
                                        <div class="jobField">
                                            <span class="fa fa-briefcase"></span>
                                            {{ job.field }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </router-link>
                    </article>
                    <pagination 
                        v-if="jobs.meta.last_page > 1" 
                        :pagination="jobs" 
                        :offset="5" 
                        @paginate="fetchJobs(jobs.meta.current_page)"
                    >
                    </pagination>
                </div>
            </div>
        </div>
        <div v-if="jobsLoadStatus === 3">
            <div class="search-text">
                <span></span>
                <header class="title">
                    <h1 class="head">{{ jobsLoadError }}</h1>
                </header>
            </div>
        </div>
    </div>
</template>

<script>
    import Pagination from '../../navigations/frontend/Pagination'
    export default {
        components: {
            Pagination
        },
        created() {
            this.$store.dispatch('searchJobs', {
                page: this.$route.query.page,
                keyword: this.$route.query.q,
                locale: this.$route.query.l
            })
        },
        methods: {
            fetchJobs(page) {
                if (page > this.jobs.meta.last_page) {
                    page = this.jobs.meta.last_page;
                }
                this.$router.push({ query: 
                    { 
                        page: page, 
                        q: this.$route.query.q, 
                        l: this.$route.query.l 
                    }
                })
                .catch(() => {})
            }
        },
        computed: {
            jobs() {
                return this.$store.getters.getJobs
            },
            jobsLoadStatus() {
                return this.$store.getters.showJobsLoadStatus
            },
            jobsLoadError() {
                return this.$store.getters.showJobsLoadError
            }
        },
    }
</script>

<style scoped>
    @media (max-width: 768px){
        .col-md-8 {
            -webkit-box-flex: 0;
            flex: 0 0 66.6666666667%;
            max-width: 66.6666666667%;
        }
    }
    /* @media (min-width: 1014px) {
        .col-sm-12 {
            -webkit-box-flex: 0;
            flex: 0 0 100%;
            max-width: 100%;
        }
    } */
    .box {
        display: inline-block;
        width: 200px;
        height: 200px;
        border-radius: 3px;
        font-size: 30px;
        margin: 100px;
        top: 5vh;
        left: 35vw;
        padding: 1em;
        position: relative;
        margin-bottom: 0.25em;
        vertical-align: top;
        transition: 0.3s color, 0.3s border, 0.3s transform, 0.3s opacity;
    }
    .electron-loader {
        transform: rotateZ(45deg);
        perspective: 1000px;
        border-radius: 50%;
    }
    .electron-loader:before, .electron-loader:after {
        content: '';
        display: block;
        position: absolute;
        top: 0;
        left: 0;
        width: inherit;
        height: inherit;
        border-radius: 50%;
        animation: 1s spin linear infinite;
    }
    .electron-loader:before {
        transform: rotateX(70deg);
    }
    .electron-loader:after {
        transform: rotateY(70deg);
        animation-delay: 0.4s;
    }
    @keyframes rotate {
        0% {
            transform: translate(-50%, -50%) rotateZ(0deg);
        }
        100% {
            transform: translate(-50%, -50%) rotateZ(360deg);
        }
    }
    @keyframes rotateccw {
        0% {
            transform: translate(-50%, -50%) rotate(0deg);
        }
        100% {
            transform: translate(-50%, -50%) rotate(-360deg);
        }
    }
    @keyframes spin {
        0%, 100% {
            box-shadow: 0.2em 0px 0 0px currentcolor;
        }
        12% {
            box-shadow: 0.2em 0.2em 0 0 currentcolor;
        }
        25% {
            box-shadow: 0 0.2em 0 0px currentcolor;
        }
        37% {
            box-shadow: -0.2em 0.2em 0 0 currentcolor;
        }
        50% {
            box-shadow: -0.2em 0 0 0 currentcolor;
        }
        62% {
            box-shadow: -0.2em -0.2em 0 0 currentcolor;
        }
        75% {
            box-shadow: 0px -0.2em 0 0 currentcolor;
        }
        87% {
            box-shadow: 0.2em -0.2em 0 0 currentcolor;
        }
    }
 
    .search-text {
        align-items: center;
        display: flex;
        justify-content: space-between;
        justify-content: flex-start;
        padding: 12px 0;
        position: relative;
        box-shadow: rgba(0, 0, 0, 0.02) 1px 1px 1px 1px;
    }
    .search-text {
        margin-left: auto;
        margin-right: auto;
        background: white;
        margin-top: 20px;
    }
    .search-text>.title {
        display: flex;
        white-space: nowrap;
        width: 800px;
    }
    .title {
        margin: 8px 0 8px 40px;
    }
    .search-text>.title .head {
        font-weight: 600;
        padding-right: 4px;
    }
    .search-text>.title .search-count,
    .search-text>.title .head {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        font-size: 16px;
        line-height: 1.5;
        display: inline-block;
        margin-bottom: 0;
        margin-top: 0;
        max-width: 75%;
        vertical-align: bottom;
    }
    .single-list .card:hover {
        box-shadow: 0px 1px 3px 2px rgba(0,0,0,0.1);
        transition: box-shadow 0.25s ease-in-out;
        border-radius: 3px;
    }
    .card-header {
        background-color: inherit;
        border-bottom: 0;
    }
    h5.card-text {
        font-weight: 600;
        color: #495057;
    }
    a {
        text-decoration: none;
    }
    a.jobLink {
        color: #0b7ddc;
    }
    .logo-wrapper {
        padding: 0 !important;
    }
    .logo-wrapper img {
        max-width: 65px;
        max-height: 65px;
    }
    .card-body {
        padding-top: 0;
    }
    .card-body ul {
        margin: 5px 0 0 0;
        padding: 0;
        list-style: none;
    }
    .card-body ul li {
        list-style: none;
        margin-bottom: 0.33333rem;
    }
    .card-body ul li p {
        font-size: 15px;
        margin-bottom: 2px;
        margin: 0;
        display: flex;
        color: #4b81af;
    }
    .card-body ul li p span {
        margin-top: 3px;
        margin-right: 8px;
        color: #0b7ddc;
    }
    .badge-primary.active {
        padding: 6px 16px;
        border: none;
    }
    .badge-primary.active, 
    .badge-primary:focus, 
    .badge-primary:hover {
        color: #fff;
        box-shadow: 1px 1px 22px rgba(226, 99, 93, .19);
        background: #ff5757;
    }
    .badge-primary {
        background: 0 0;
        border: 1px solid #f6f5f9;
        color: #434244;
        font-weight: 600;
        padding: 6px 14px;
        border-radius: 100px;
        margin-right: 5px;
        transition: all 0s;
    }
    .badge {
        font-size: 90%;
    }
    .card-footer {
        border-top: 1px solid #e3e6ef;
        padding: 12px 20px;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
    }
    .card-footer .card-footer-wrapper {
        margin-right: 12px;
    }
    .card-footer 
    .card-footer-wrapper 
    .jobField {
        display: flex;
        align-items: center;
        color: #4b81af;
        font-size: 0.93333rem;
        word-break: break-word;
    }
    .card-footer 
    .card-footer-wrapper
    .jobField span {
        display: inline-flex;
        width: 2.26667rem;
        height: 2.26667rem;
        background: rgba(144, 58, 249, 0.1);
        color: #0b7ddc !important;
        font-size: 1rem;
        align-items: center;
        justify-content: center;
        border-radius: 20rem;
        margin-right: 0.4rem;
    }
    .jobField span {
        font-size: 14px;
        display: inline-block;
        margin-right: 7px;
        line-height: 28px;
        text-align: center;
        color: #444752;
    }
</style>