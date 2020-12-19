<template>
<div>
	<div class="container">
		<h5 class="alert alert-info text-center">After Five minutes Page will be expired</h5>
		<div class="card o-hidden border-0 shadow-lg my-5">
			<div class="card-body p-0">
				<!-- Nested Row within Card Body -->
				<div class="row">
					<div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
					<div class="col-lg-7">
						<div class="p-5">
							<div class="text-center">
								<h1 class="h4 text-gray-900 mb-4">Update Your Password</h1>
							</div>
							<form class="user" v-if="error">
								<div class="form-group">
									<input type="email" class="form-control form-control-user" id="exampleInputEmail" placeholder="Email Address" v-model="form.email">
									<small style="color: red">{{ error.email }}</small>
								</div>
								<div class="form-group row">
									<div class="col-sm-6 mb-3 mb-sm-0">
										<input type="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password" v-model="form.password">
										<small style="color: red">{{ error.password }}</small>
									</div>
									<div class="col-sm-6">
										<input type="password" class="form-control form-control-user" id="exampleRepeatPassword" placeholder="Repeat Password" v-model="form.confirmPassword">
										<small style="color: red">{{ error.confirmPassword }}</small>
									</div>
								</div>
								<button type="submit" class=" btn btn-primary" @click.prevent="updatePassword()">Update Password</button>
							</form>
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

data(){
    return{
        form:{
            email:'',
            password:'',
            confirmPassword:''
        },
        error:{}
    }
},
methods:{
	updatePassword: function() {
    let formData = this.form
    this.$store.dispatch('updatePassword', formData).then(response => {
        if (response.data.status) {
            toastr.success(response.data.message)
            this.form.email = null,
            this.form.password = null,
            this.form.confirmPassword = null,
            this.error.email = null,
            this.error.password = null,
            this.error.confirmPassword = null

        }
        if (!response.data.status) {
            if (typeof response.data.message === "string") {
                toastr.error(response.data.message)
                this.error.email = null,
                this.error.password = null,
                this.error.confirmPassword = null

            }
            if (typeof response.data.message === "object") {
                let { email, password, confirmPassword } = response.data.message
                let message = {
                    email: email ? email[0] : '',
                    password: password ? password[0] : '',
                    confirmPassword: confirmPassword ? confirmPassword[0] : ''
                }
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

