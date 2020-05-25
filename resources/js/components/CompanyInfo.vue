<template>
    <div class="company_info">
        <div class="company">
            <div class="info" style="line-height:1.5;">
                <h3>{{ job.company }}</h3>
                <p v-if="job.about !== null" 
                    class="about"
                >
                    {{ job.about }}
                </p>
                <br>
                <a v-if="job.website !== null" 
                    href="http://www.semanticbits.com?ref=iremotejobs.com" 
                    target="_blank"
                >
                    <img src="/svg/web-logo.svg" 
                        style="width:8%" 
                        alt="Company Website Link"
                    />
                    <b>Visit Company Website</b>
                </a>
                <br>

                <br>
                <h6><b>Address:</b></h6>
                <ul class="comp-dits"
                    style="padding-left: 0;"
                >
                    <li>{{ job.address }}</li> 
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'job'
        ]
    }
</script>

<style scoped>
    .company_info .company {
        padding: 14px 23px 16px;
        display: flex;
        align-items: center;
        /* border-bottom: 1px solid #6c757d85; */
    }
    .comp-dits {
        list-style: none;
    }
</style>