<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome DH!</h1>
                                    </div>
                                    <form class="user"  @submit.prevent="submit">
                                        <div class="form-group" v-if="error">
                                            <input type="email" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address..." v-model="form.email">
                                            <small style ="color: red">{{ error.email }}</small>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password" v-model="form.password">
                                            <small style ="color: red">{{ error.password }}</small>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Remember Me</label>
                                            </div>
                                        </div>
                                        <button type="submit"  class="btn btn-primary btn-user btn-block">
                                            Login
                                        </button>
                                        <hr>
                                        <a href="#" class="btn btn-google btn-user btn-block">
                                            <i class="fab fa-google fa-fw"></i> Login with Google
                                        </a>
                                        <a href="#" class="btn btn-facebook btn-user btn-block">
                                            <i class="fab fa-facebook-f fa-fw"></i> Login with Facebook
                                        </a>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <router-link class="small" to="/forgot-password">Forgot Password?</router-link>
                                    </div>
                                    <div class="text-center">
                                        <router-link class="small" to="/register">Create an Account!</router-link>
                                    </div>
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
    data() {
        return {
            form: {
                email: "",
                password: ""
            },
            error: {},
        }
    },
    methods: {
        submit: function () {
            const formData = this.form
            this.$store.dispatch("submit", formData).then( response => {
                if (response.data.status) {
                    toastr.success(response.data.message)
                    this.$router.push('/dashboard')
                }
                if(!response.data.status) {
                        if( typeof response.data.message === "string"){
                            toastr.error(response.data.message)
                            this.error.email = null,
                            this.error.password = null
                        }
                        if( typeof response.data.message === "object"){
                            let { email, password } = response.data.message
                            let message = {
                                email: email ? email[0] : '',
                                password: password ? password[0] : ''
                            };
                            this.error = message
                       }                
                }
            })
        }
    },
}
</script>

<style scoped>

</style>
