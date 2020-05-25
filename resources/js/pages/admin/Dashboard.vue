<style scoped>
    
</style>

<template>
    <div>
        <h1>Dashboard</h1>
    </div>
</template>

<script>
    export default {
        created() {
            this.$store.dispatch('loadUser')
        }
    }
</script>