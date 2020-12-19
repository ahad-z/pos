<template>
    <div class="container">
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                            </div>
                            <form class="user" v-if="error">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" id="exampleFirstName" placeholder="First Name" v-model="form.name">
                                    <small style="color: red"> {{ error.name }} </small>
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user" id="exampleInputEmail" placeholder="Email Address" v-model="form.email">
                                    <small style="color: red"> {{ error.email }} </small>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password" v-model="form.password">
                                        <small style="color: red"> {{ error.password }} </small>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control form-control-user" id="exampleRepeatPassword" placeholder="Repeat Password" v-model="form.confirmPassword">
                                        <small style="color: red"> {{ error.confirmPassword }} </small>
                                    </div>
                                </div>
                                <a href="" class="btn btn-primary btn-user btn-block" @click.prevent="register()">
                                    Register Account
                                </a>
                                <hr>
                                <a href="index.html" class="btn btn-google btn-user btn-block">
                                    <i class="fab fa-google fa-fw"></i> Register with Google
                                </a>
                                <a href="index.html" class="btn btn-facebook btn-user btn-block">
                                    <i class="fab fa-facebook-f fa-fw"></i> Register with Facebook
                                </a>
                            </form>
                            <hr>
                            <div class="text-center">
                                <router-link class="small" to="/forgot-password">Forgot Password?</router-link>
                            </div>
                            <div class="text-center">
                                <router-link class="small" to="/">Already have an account? Login!</router-link>
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
    name: "AuthRegistration",
    data(){
        return{
            form:{
                name:'',
                email:'',
                password:'',
                confirmPassword:''
            },
            error:{}
        }
    },
    methods:{
        register:function(){
            let formData = this.form
            this.$store.dispatch('register', formData).then( response => {
                if (response.data.status) {
                    toastr.success(response.data.message)
                    this.form.name            = null,
                    this.form.email           = null,
                    this.form.password        = null,
                    this.form.confirmPassword = null,

                    this.error.name            = null,
                    this.error.email           = null,
                    this.error.password        = null,
                    this.error.confirmPassword = null

                }
                if (!response.data.status) {
                    if (typeof response.data.message === "string") {
                        toastr.error(response.data.message)
                        this.error.name            = null,
                        this.error.email           = null,
                        this.error.password        = null,
                        this.error.confirmPassword = null

                    }
                    if (typeof response.data.message === "object") {
                        let { name, email, password, confirmPassword } = response.data.message
                        let message = {
                            name: name ? name[0] : '',
                            email: email ? email[0] : '',
                            password: password ? password[0] : '',
                            confirmPassword: confirmPassword ? confirmPassword[0] : ''
                        }
                        this.error = message
                    }
                }
            })
        }
    }

}
</script>

<style scoped>

</style>
