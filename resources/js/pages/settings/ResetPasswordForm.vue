<style scoped>
    .container {
        position: relative;
        top: 40px;
    }
    .card-header {
        color: grey;
    }

    label {
        color: grey;
    }
</style>

<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-5">
                <div class="card card-default">
                    <div class="card-header">
                        <h4>Change  Password</h4>
                    </div>
                    <div v-if="passwordChangedStatus === 3" 
                        style="color:red;
                        font-weight:bold;
                        position:absolute;
                        top: 15vh;"
                    >
                        <span>{{ passwordChangedText }}</span>
                    </div>
                    <div v-if="passwordChangedStatus === 2" 
                        style="color:red;
                        font-weight:bold;
                        position:absolute;
                        top: 15vh;"
                    >
                        <span>{{ passwordChangedText }}</span>
                    </div>
                    <div class="card-body">
                        <!-- <ul v-if="errors">
                        <li v-for="error in errors" v-bind:key="error">{{ msg }}</li>
                        </ul> -->
                        <form @submit.prevent="resetPassword">

                            <div class="form-group col-xs-12 col-md-12">
                                <label for="email">E-mail</label>
                                <input type="email" 
                                    id="email" 
                                    class="form-control" 
                                    placeholder="user@example.com" 
                                    v-model="email" 
                                    required
                                />
                                <span class="validation" v-show="!validations.email.is_valid">
                                    {{ validations.email.text }}
                                </span>
                            </div>
                            <div class="form-group col-xs-12 col-md-12">
                                <label for="email">New Password</label>
                                <input type="password" 
                                    id="password" 
                                    class="form-control" 
                                    placeholder="Enter New Password" 
                                    v-model="password" 
                                    autocomplete="off"
                                    required
                                />
                                <span class="validation" v-show="!validations.password.is_valid">
                                    {{ validations.password.text }}
                                </span>
                            </div>
                            <div class="form-group col-xs-12 col-md-12">
                                <label for="email">Confirm New Password</label>
                                <input type="password" 
                                    id="password_confirmation" 
                                    class="form-control" 
                                    placeholder="Confirm New Password" 
                                    v-model="password_confirmation" 
                                    autocomplete="off"
                                    required
                                />
                                <span class="validation" v-show="!validations.password_confirmation.is_valid">
                                    {{ validations.password_confirmation.text }}
                                </span>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-10 offset-9">
                                    <button v-if="passwordChangedStatus !==2" type="submit" class="btn btn-primary">Update</button>
                                    <button v-if="passwordChangedStatus === 2" class="btn btn-success">
                                        <router-link :to="{ name: 'login' }">Go to Login</router-link>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { EventBus } from '../../event-bus';
    
    export default {
        data() {
            return {
                token: '',
                email: '',
                password: null,
                password_confirmation: null,
                validations: {
                    email: {
                        is_valid: true,
                        text: ''
                    },
                    password: {
                        is_valid: true,
                        text: ''
                    },
                    password_confirmation: {
                        is_valid: true,
                        text: ''
                    },
                }
            }
        },
        methods: {
            resetPassword() {
                if(this.validateChangePassword) {
                    this.$store.dispatch('changePassword', {
                        token: this.$route.params.token,
                        email: this.email,
                        password: this.password,
                        password_confirmation: this.password_confirmation
                    });
                };
            },
            validateChangePassword() {
                let validEmailForm = true;

                /*
                Ensure a title has been entered
                */
                if( this.email.trim() == '' ){
                    validEmailForm = false;
                    this.validations.email.is_valid = false;
                    this.validations.email.text = 'Please enter a valid email!';
                }else{
                    this.validations.email.is_valid = true;
                    this.validations.email.text = '';
                }

                if( this.password.trim() == '' ){
                    validEmailForm = false;
                    this.validations.password.is_valid = false;
                    this.validations.password.text = 'Please enter a valid password!';
                }else{
                    this.validations.password.is_valid = true;
                    this.validations.password.text = '';
                }

                if( this.password_confirmation.trim() == '' ){
                    validEmailForm = false;
                    this.validations.password_confirmation.is_valid = false;
                    this.validations.password_confirmation.text = 'Please confirm password!';
                }else{
                    this.validations.password_confirmation.is_valid = true;
                    this.validations.password_confirmation.text = '';
                }
            },
            clearForm(){
                this.email = '';
                this.password = '';
                this.password_confirmation = '';

                this.validations = {
                    email: {
                        is_valid: true,
                        text: ''
                    },
                    password: {
                        is_valid: true,
                        text: ''
                    },
                    password_confirmation: {
                        is_valid: true,
                        text: ''
                    },
                }
            }
        },
        computed: {
            passwordChangedStatus(){
                return this.$store.getters.getPasswordChangedStatus;
            },
            passwordChangedText() {
                return this.$store.getters.getPasswordChangedText;
            }
        },
        watch: {
            'passwordChangedStatus': function(){
                if( this.passwordChangedStatus == 2 ){
                    this.clearForm();
                    
                    EventBus.$emit('show-success', {
                        notification: this.passwordChangedText
                    })
                }

                if( this.passwordChangedStatus == 3 ){
                    EventBus.$emit('show-error', {
                        notification: this.passwordChangedText
                    })
                }
            }
        },
    }
</script>

