<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-2">Forgot Your Password?</h1>
                                        <p class="mb-4">We get it, stuff happens. Just enter your email address below and we'll send you a link to reset your password!</p>
                                    </div>
                                    <form class="user">
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address..." v-model="form.email">
                                        </div>
                                        <a  class="btn btn-primary btn-user btn-block" @click="forgotPass()">
                                            Reset Password
                                        </a>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <router-link class="small" to="/register">Create an Account!</router-link>
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
        </div>
    </div>
</template>

<script>
export default {
name: "ForegtPassword",
data(){
    return{
        form:{
            email:''
        }
    }
},
methods:{
    forgotPass: function(){
        let formData = this.form
       this.$store.dispatch('forgotPass', formData).then(response => {
        if(response.data.status){
            toastr.success(response.data.message)
            this.form.email = null
        }else{
            toastr.error(response.data.message)
        }
    })
    }
},

}
</script>

<style scoped>

</style>
