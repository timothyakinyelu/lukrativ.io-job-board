
<template>
    <div class="container-scroller">
        <Navbar />
        <div class="container-fluid page-body-wrapper"> 
            <div class="content-panel">
                <router-view :key="$route.fullPath"></router-view>
            </div>
        </div>
        <Footer />
    </div>
</template>

<script>
    import Navbar from '../navigations/frontend/Navbar'
    import Footer from '../navigations/frontend/Footer' 

    export default {
        components: { 
            Navbar, 
            Footer
        },
    }
</script>

<style >
    .content-panel {
        width: 100%;
        background-color: hsla(0,0%,100%,.7);
    }

    /* Scrollbar styles */
    ::-webkit-scrollbar {
        width: 5px;
    }

    /* Track */
    ::-webkit-scrollbar-track {
        /* box-shadow: inset 0 0 5px grey; */
        border-radius: 2px;
    }
    
    /* Handle */
    ::-webkit-scrollbar-thumb {
        background: #3490dc;
        border-radius: 5px;
    }

    /* Handle on hover */
    ::-webkit-scrollbar-thumb:hover {
        background: #ff5757; 
    }
</style>