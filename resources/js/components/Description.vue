<template>
    <div class="job-desc">
        <div id="fs-JD">
            <section>
                <div class="job">
                    <div class="top">
                        <h4>{{ job.company }}</h4>
                        <a v-if="job.link !== null" 
                            href="" 
                            target="_blank" 
                            class="btn btn-warning" 
                            style="color:white"
                        >
                            Apply
                        </a>
                    </div>
                    <div class="job-details">
                        <div class="job-title">
                            <h1>Job Title: {{ job.title }}</h1>
                        </div>
                        <h4>Job Type: {{ job.type }}</h4>
                        <h4>Experience Level: Mid-Level </h4>
                        <div style="line-height:1.5;margin-top: 20px;">
                            <section>
                                <div class="jobContent">
                                    <h5><strong>Role Responsibilities</strong><br></h5>
                                    <dd id="text">{{ job.description }}</dd> 
                
                                    <h5><strong>Competencies/Skills</strong><br></h5>
                                    <dd id="text">{{ job.competencies }}</dd>
                                
                                
                                    <h5><strong>Required Qualifications</strong><br></h5>
                                    <dd id="text">{{ job.qualifications }}</dd>
                                    
                                    <h5><strong>Application Closing Date</strong><br></h5>
                                    <dd v-if="job.deadline !== null" id="text">{{ job.deadline }}</dd>
                                    <dd v-if="job.deadline === null" id="text">Not Specified.</dd>

                                    <div v-if="job.email !== null">
                                        <h5><strong>Method of Application</strong><br></h5>
                                        <dd id="text">Please send updated resume as an attachment to {{ job.email }}, with the job title as SUBJECT of the mail.</dd>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </section>
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
    #fs-JD {
        position: relative;
        /* width: 45vw; */
        max-width: 100%;
        /* left: 20px; */
        padding: 20px;
        z-index: 4;
        border-right: 1px solid #dae0e5;
        word-wrap: break-word;
    }
    #fs-JD .job {
        padding: 0;
        /* margin-top: 26px; */
        background: #fff;
        box-shadow: 1px 1px 22px rgba(157, 184, 209, .19);
        border-radius: 3px;
    }
    #fs-JD .job .top {
        display: flex;
        align-items: center;
        padding: 17px 25px;
        border-bottom: 1px solid #6c757d94;
        border-top-left-radius: 3px;
        border-top-right-radius: 3px;
    }
    #fs-JD .job .top h4 {
        color: #ff5757;
        font-size: 14px;
        font-weight: 600;
        width: 100%;
        margin-bottom: 0;
        margin-right: auto!important;
    }
    #fs-JD .job .job-details {
        padding: 20px;
    }
    #fs-JD .job .job-details h4 {
        font-size: 13px;
        font-weight: 700;
    }
    #fs-JD .job .job-details .job-title{
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }
    #fs-JD h1 {
        font-size: 22px;
        font-weight: 600;
        display: inline-block;
    }
</style>