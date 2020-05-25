<template>
    <div>
        <div class="container-login100">
            <div class="wrap-login100 p-l-85 p-r-85 p-t-55 p-b-55">
                <form class="login100-form validate-form flex-sb flex-w" 
                    @submit.prevent="emitToLogin" method="post">
                    <router-link :to="{name: 'home'}" 
                        aria-label="logo" 
                        class="login-logo" >
                        <img src="/images/logo.png" alt="logo" />
                    </router-link>
                    <span class="login100-form-title p-b-32">
                        Hi,
                    </span>
                    <br/>
                    <div class="user-email">
                        <h6 class="email">{{ email }}</h6>
                    </div>
                    <br/>
                    <br/>
                    <div>
                        <span class="txt1 p-b-11">
                            Password
                        </span>
                    </div>
                    <div v-if="authStatus === 3" 
                        style="color:red;
                        font-weight:bold;"
                    >
                        <span>{{ statusText }}</span>
                    </div>
                    <div class="wrap-input100 validate-input m-b-12" 
                        data-validate="Password is required"
                    >
                        <span class="btn-show-pass">
                            <i @click="showPassword" class="fa fa-eye"></i>
                        </span>
                        <input class="input100" 
                            id="myInput"
                            aria-hidden="true"
                            type="password" 
                            v-model="password" 
                            name="password" 
                            autocomplete="off" 
                            required
                        />
                        <span class="focus-input100"></span>
                    </div>
                    <!-- <div class="flex-sb-m w-full p-b-48">
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
                    </div> -->
                    <div class="container-login100-form-btn">
                        <button type="submit" class="login100-form-btn">
                            Login
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: [
        'authStatus',
        'statusText',
        'email'
    ],
    data() {
        return {
            password: ""
        }
    },
    methods: {
        emitToLogin (event) {
            this.$emit('confirmPassword', this.password)
        },
        showPassword() {
            var x = document.getElementById("myInput");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    },
}
</script>

<style scoped>
    h6.email {
        border: 1px solid #80808059;
        border-radius: 15px;
        line-height: 1.5;
        padding: 5px;
        font-weight: 600;
        color: #0a7ddc;
    }

    .login100-form-title {
        font-size: 17px;
        text-transform: none;
    }

    .user-email {
        position: relative;
        width: 100%;
        display: flex;
        justify-content: center;
    }
</style>