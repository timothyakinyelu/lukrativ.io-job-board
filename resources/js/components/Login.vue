
<template>
    <div class="limiter">
        <!--
        <div class="container-login100">
            <div class="wrap-login100 p-l-85 p-r-85 p-t-55 p-b-55">
                <form class="login100-form validate-form flex-sb flex-w" 
                    @submit.prevent="login" method="post">
                    <span class="login100-form-title p-b-32">
                        Account Login
                    </span>
                    <div v-if="authStatus === 3" 
                        style="color:red;
                        font-weight:bold;
                        position:absolute;
                        top: 15vh;"
                    >
                        <span>{{ statusText }}</span>
                    </div>
                    <br/>
                    <br/>
                    <span class="txt1 p-b-11">
                        Email
                    </span>
                    <div class="wrap-input100 validate-input m-b-36" 
                        data-validate="Email is required"
                    >
                        <input class="input100" 
                            type="email" 
                            v-model="email" 
                            name="email" 
                            required
                        />
                        <span class="focus-input100"></span>
                    </div>
                    <span class="txt1 p-b-11">
                        Password
                    </span>
                    <div class="wrap-input100 validate-input m-b-12" 
                        data-validate="Password is required"
                    >
                        <span class="btn-show-pass">
                            <i class="fa fa-eye"></i>
                        </span>
                        <input class="input100" 
                            type="password" 
                            v-model="password" 
                            name="password" 
                            autocomplete="off" 
                            required
                        />
                        <span class="focus-input100"></span>
                    </div>
                    <div class="flex-sb-m w-full p-b-48">
                        <div class="contact100-form-checkbox">
                            <input class="input-checkbox100" 
                                id="ckb1" 
                                type="checkbox" 
                                name="remember-me" 
                            />
                            <label class="label-checkbox100" for="ckb1">
                                Remember me
                            </label>
                        </div>
                        <div>
                            <a href="#" class="txt3">
                                Forgot Password?
                            </a>
                        </div>
                    </div>
                    <div class="container-login100-form-btn">
                        <button type="submit" class="login100-form-btn">
                            Login
                        </button>
                    </div>
                </form>
            </div>
        </div>
        -->
        <VerifyEmail 
            :emailStatus = 'emailStatus'
            v-on:checkEmail="checkEmail"
            :statusText = 'statusText'
            v-if="emailStatus !== 2"
        />
        <Password 
            :emailBool = 'confirmedEmail'
            :email = 'email'
            :authStatus = 'authStatus'
            :statusText = 'statusText'
            v-on:confirmPassword="confirmPassword"
            v-if="emailStatus === 2"
        />
    </div>
</template>

<script>
    import { EventBus } from '../event-bus';
    import VerifyEmail from '../components/VerifyEmail'
    import Password from '../components/Password'

    export default {
        components: {
            VerifyEmail,
            Password
        },
        methods: {
            // login() {
            //     let email = this.email
            //     let password = this.password
            //     this.$store.dispatch('login', { email, password })
            // },
            checkEmail(val) {
                let email = val
                this.$store.dispatch('checkEmail', {email})
            },
            confirmPassword(val) {
                let password = val;
                let emailBool = this.confirmedEmail;
                let email = this.email;
                this.$store.dispatch('confirmPassword', {email, emailBool, password})
            }
        },
        computed: {
            email() {
                return this.$store.getters.getEmail;
            },
            confirmedEmail() {
                return this.$store.getters.getEmailConfirmed;
            },
            emailStatus() {
                return this.$store.getters.getEmailStatus;
            },
            authStatus(){
                return this.$store.getters.getAuthStatus
            },
            statusText() {
                return this.$store.getters.getStatusText
            }
        },
        watch: {
            'authStatus': function() {
                if( this.authStatus == 3 ) {
                    EventBus.$emit('show-error', {
                        notification: this.statusText
                    })
                }
            }
        },
    }
</script>

<style>
    .limiter {
        width: 100%;
        margin: 0 auto;
    }
    .container-login100 {
        width: 100%;
        min-height: 100vh;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        padding: 15px;
        background-color: #ebebeb;
    }
    .wrap-login100 {
        width: 560px;
        background: #fff;
        border-radius: 10px;
        position: relative;
    }
    .p-r-85 {
        padding-right: 85px;
    }
    .p-l-85 {
        padding-left: 85px;
    }
    .p-b-55 {
        padding-bottom: 55px;
    }

    .p-t-55 {
        padding-top: 55px;
    }
    .login100-form {
        width: 100%;
    }
    .flex-sb {
        display: flex;
        justify-content: space-between;
    }
    .flex-w {
        display: flex;
        flex-wrap: wrap;
    }
    .login100-form-title {
        font-family: 'Montserrat', sans-serif;
        font-size: 20px;
        color: #555555;
        line-height: 1.2;
        text-transform: uppercase;
        text-align: left;
        width: 100%;
        display: inline-grid;
        justify-content: center;
        font-weight: 600;
    }
    .login-logo {
        margin-right: auto;
        margin-left: auto;
    }
    .login-logo img {
        max-width: 120px;
    }
    .p-b-32 {
        padding-bottom: 10px;
    }
    .txt1 {
        font-family: 'Livvic', serif;
        font-size: 13px;
        color: #555555;
        line-height: 1.4;
        text-transform: uppercase;
    }
    .p-b-11 {
        padding-bottom: 11px;
    }
    .validate-input {
        position: relative;
    }
    .wrap-input100 {
        width: 100%;
        position: relative;
        background-color: #fff;
        border: 1px solid #e6e6e6;
        border-radius: 2px;
    }
    .m-b-36 {
        margin-bottom: 36px;
    }
    .input100 {
        font-family: 'Montserrat', sans-serif;
        color: #555555;
        line-height: 1.2;
        font-size: 18px;
        display: block;
        width: 100%;
        background: transparent;
        height: 55px;
        padding: 0 25px 0 25px;
    }
    input {
        outline: none;
        border: none;
    }
    .focus-input100 {
        position: absolute;
        display: block;
        width: calc(100% + 2px);
        height: calc(100% + 2px);
        top: -1px;
        left: -1px;
        pointer-events: none;
        border: 1px solid #57b846;
        border-radius: 3px;
        visibility: hidden;
        opacity: 0;
        transition: all 0.4s;
        transform: scaleX(1.1) scaleY(1.3);
    }
    .m-b-12 {
        margin-bottom: 12px;
    }
    .btn-show-pass {
        font-size: 15px;
        color: #999999;
        display: flex;
        align-items: center;
        position: absolute;
        height: 100%;
        top: 0;
        right: 12px;
        padding: 0 5px;
        cursor: pointer;
        transition: background 0.4s;
    }
    .flex-sb-m {
        display: flex;
        justify-content: space-between;
        -ms-align-items: center;
        align-items: center;
    }
    .w-full {
        width: 100%;
    }
    .p-b-48 {
        padding-bottom: 48px;
    }
    .input-checkbox100 {
        display: none;
    }
    .label-checkbox100 {
        font-family: 'Livvic', sans-serif;
        font-size: 13px;
        color: #999999;
        line-height: 1.4;
        display: block;
        position: relative;
        padding-left: 26px;
        cursor: pointer;
    }
    .label-checkbox100::before {
        content: "\f00c";
        font-family: FontAwesome;
        font-size: 13px;
        color: transparent;
        display: flex;
        justify-content: center;
        align-items: center;
        position: absolute;
        width: 18px;
        height: 18px;
        border-radius: 2px;
        background: #fff;
        border: 1px solid #e6e6e6;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
    }
    .txt3 {
        font-family: 'Livvic', sans-serif;
        font-size: 13px;
        color: #555555;
        line-height: 1.4;
    }
    .container-login100-form-btn {
        width: 100%;
        display: flex;
        flex-wrap: wrap;
    }
    .login100-form-btn {
        font-family: 'Montserrat', sans-serif;
        font-size: 16px;
        color: #fff;
        line-height: 1.2;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 0 20px;
        min-width: 150px;
        height: 55px;
        background-color: #333333;
        border-radius: 27px;
        transition: all 0.4s;
    }
    .login100-form-btn:hover {
        background-color: #17a2b8;
    }
    button {
        outline: none !important;
        border: none;
        background: transparent;
    }
    span.validation {
        font-size: 11px;
        color: #e3342f;
    }
</style>