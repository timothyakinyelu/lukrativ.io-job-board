<template>
    <div v-if="userLoadStatus  === 2">
        <div class="container box_1620">
            <div class="banner_inner d-flex align-items-center">
                <div class="banner_content">
                    <div class="media">
                        <div class="d-flex">
                            <img 
                                src="/images/larissagideon.jpg" 
                                alt="profile" 
                                style="width: 40vh;"
                            />
                        </div>
                        <div class="media-body">
                            <div class="personal_text">
                                <h3>{{ user.name }}</h3>

                                <h5>General Information</h5>
                                <ul class="list basic_info">
                                    <li><a href><i class="fa fa-calendar"></i> 31st December, 1992</a></li>
                                    <li><span>Role:</span> {{ user.role }}</li>
                                </ul>
                                
                                <h5>Contact Information</h5>
                                <ul class="list basic_info">
                                    <li><a href><i class="fa fa-phone"></i> 44 (012) 6954 783</a></li>
                                    <li><a href><i class="fa fa-envelope"></i> {{ user.email }}</a></li>
                                    <li><a href><i class="fa fa-home"></i> Santa monica bullevard</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="edit-action">
                            <div class="edit-inner">
                                <h6>Actions</h6>
                                <button class="btn btn-default" @click="loadUser()"><i class="fa fa-pencil">Edit Profile</i></button>
                                <br/>
                                <div id="settings">
                                    <router-link :to="{ name: 'resetlink' }">Change Password</router-link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        computed: {
            user() {
                return this.$store.getters.getUser
            },
            userLoadStatus() {
                return this.$store.getters.getUserLoadStatus();
            },
        },
    }
</script>

<style scoped>
    .home_banner_area .box_1620 {
        min-height: 700px;
        border-radius: 12px;
        position: relative;
        bottom: -200px;
        background: #fff;
        padding: 30px;
        box-shadow: 0px 20px 80px 0px rgba(153, 153, 153, 0.3);
    }
    .home_banner_area .banner_inner {
        position: relative;
        width: 100%;
        min-height: 700px;
        display: flex;
    }
    .home_banner_area .banner_inner .banner_content {
        color: #222222;
        vertical-align: middle;
        align-self: center;
        text-align: left;
    }
    .home_banner_area .banner_inner .banner_content .media .d-flex {
        padding-right: 125px;
    }
    .home_banner_area .banner_inner .banner_content .media .media-body {
        vertical-align: middle;
        align-self: center;
    }
    .banner_inner {
        background: white;
        margin: 10px;
    }
    .banner_content {
        margin: 20px;
    }
    .d-flex {
        padding: 20px;
    }
    .personal_text h6 {
        font-size: 14px;
        font-family: "Roboto", sans-serif;
        text-transform: uppercase;
        letter-spacing: 2.1px;
        font-weight: normal;
        margin-bottom: 12px;
        color: #222222;
    }
    .personal_text h3 {
        font-size: 35px;
        text-transform: uppercase;
        margin-bottom: 15px;
        color: #222222;
    }
    .personal_text h4 {
        font-size: 14px;
        font-weight: 500;
        font-family: "Roboto", sans-serif;
        text-transform: uppercase;
        margin-bottom: 20px;
        color: #222222;
    }
    .personal_text p {
        font-family: "Roboto", sans-serif;
        max-width: 540px;
        color: #777777;
        margin-bottom: 40px;
    }
    .list {
        list-style: none;
        margin: 0px;
        padding: 0px;
    }
    .personal_text .basic_info li {
        margin-bottom: 15px;
    }
    .personal_text .basic_info li a {
        position: relative;
        padding-left: 40px;
        font-size: 14px;
        color: #777777;
        text-decoration: none;
    }
    .personal_text .basic_info li a i {
        position: absolute;
        left: 0px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 14px;
        color: #766dff;
    }
    .personal_text .personal_social {
        margin-top: 45px;
    }
    .personal_text .personal_social li {
        display: inline-block;
        margin-right: 7px;
    }
    .personal_text .personal_social li a {
        line-height: 40px;
        width: 40px;
        background: #e8e8e8;
        border-radius: 5px;
        display: inline-block;
        text-align: center;
        color: #fff;
        font-size: 16px;
    }
    .edit-action {
        position: relative;
        right: -100px;
        border: 1px solid #9e9e9ea1;
        width: 150px;
        box-shadow: 0px 1px 1px 0px rgba(0, 0, 0, 0.49);
    }
    .edit-inner h6 {
        padding-left: 10px;
        padding-top: 10px;
        padding-right: 10px;
    }
    .btn {
        background-color: #e9ecef;
        width: 10vw;
        margin-left: 5px;
        margin-bottom: 5px;
    }
    .fa-pencil:before {
        content: "\f040";
        padding-right: 13px;
    }
    #settings {
        margin: 10px;
    }
    #settings a {
        color: #e3342f;
        font-weight: 600;
    }
</style>