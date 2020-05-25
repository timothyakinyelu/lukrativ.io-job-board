<template>
    <div class="relatable">
        <h3><span>Related Jobs</span></h3>

        <h3 v-if="related.length < 1">No related jobs</h3>
        <div v-if="related.length > 0" class="section-title">
            <router-link 
                v-for="item in related"
                :key="item.id"
                :to="{name: 'job', params: {id: item.id, slug: item.slug}}"
                class="jobLink"
            >
                <h5>{{ item.title }}</h5>
           </router-link>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'related'
        ]
    }
</script>

<style scoped>
    .section-title {
        background-color: #f9fbfc;
    }
</style>