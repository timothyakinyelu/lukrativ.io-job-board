<style scoped>
    .card-header {
        color: grey;
    }

    label {
        color: grey;
    }
</style>

<template>
    <div class="mt-4 col-8 offset-2 hifhwot">
        <span v-show="sendEmailStatus == 1">Loading</span>
        <span v-show="sendEmailStatus == 2">Email sent successfully!</span>
        <span v-show="sendEmailStatus == 3">Email not on record!</span>
        
        <div class="card">
            <div class="card-header">Reset Password</div>
            <div class="card-body">
                <form @submit.prevent="sendEmail()">
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="inputEmail3" placeholder="Email" v-model="email">
                            <span class="validation" v-show="!validations.email.is_valid">{{ validations.email.text }}</span>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <div class="col-sm-10 offset-2">
                            <button class="btn btn-primary">Send Email</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
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
        sendEmail() {
            if(this.validateSendEmail) {
                this.$store.dispatch('sendEmail', {
                    email: this.email,
                });
            };
        },
        validateSendEmail () {
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
        },
        clearForm(){
            this.email = '';
            this.validations = {
                email: {
                    is_valid: true,
                    text: ''
                },
            }
        }
    },
    computed: {
        /*
            Gets the cafes load status
        */
        sendEmailStatus(){
            return this.$store.getters.getSendEmailStatus;
        },
    },
    watch: {
        'sendEmailStatus': function(){
            if( this.sendEmailStatus == 2 ){
                this.clearForm();
                $("#email-sent-successfully").show().delay(5000).fadeOut();
            }

            if( this.sendEmailStatus == 3 ){
                $("#there-was-a-problem-sending-the-email").show().delay(5000).fadeOut();
            }
        }
    },
}
</script>

