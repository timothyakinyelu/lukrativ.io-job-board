<template>
    <div>
        <div class="container-login100">
            <div class="wrap-login100 p-l-85 p-r-85 p-t-55 p-b-55">
                <form class="login100-form validate-form flex-sb flex-w" 
                    @submit.prevent="emitToParent" method="post"
                >
                    <router-link :to="{name: 'home'}" 
                        aria-label="logo" 
                        class="login-logo" >
                        <img src="/images/logo.png" alt="logo" />
                    </router-link>
                    <span class="login100-form-title p-b-32">
                        Login
                    </span>
                    <br/>
                    <br/>
                    <span class="txt1 p-b-11">
                        Email
                    </span>
                    <div v-if="emailStatus === 3" 
                        style="color:red;
                        font-weight:bold;"
                    >
                        <span>{{ statusText }}</span>
                    </div>
                    <span class="validation" 
                        v-if="!validations.email.is_valid"
                    >
                        {{ validations.email.text }}
                    </span>
                    <div class="wrap-input100 validate-input m-b-36" 
                        data-validate="Email is required"
                    >
                        <input class="input100" 
                            type="email" 
                            v-model="email" 
                            name="email" 
                        />
                        <span class="focus-input100"></span>
                    </div>
                    
                    <div class="container-login100-form-btn">
                        <button type="submit" class="login100-form-btn">
                            Next
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
        'emailStatus',
        'statusText'
    ],
    data() {
        return {
            email: '',
            validations: {
                email: {
                    is_valid: true,
                    text: ''
                },
            }
        }
    },
    methods: {
        emitToParent (event) {
            if(this.validateEmail()) {
                this.$emit('checkEmail', this.email)
            }
        },

        validateEmail() {
            let validEmail = true;

            /*
            Ensure a title has been entered
            */
            if( this.email.trim() == '' ){
                validEmail = false;
                this.validations.email.is_valid = false;
                this.validations.email.text = 'You must enter a valid email';
            }else{
                this.validations.email.is_valid = true;
                this.validations.email.text = '';
            }

            return validEmail;
        }

    },
}
</script>

<style scoped>
    
</style>