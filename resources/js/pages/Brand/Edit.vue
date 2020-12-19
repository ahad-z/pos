<template>
<div>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 offset-md-2">
				<div class="card card-info">
					<div class="card-header">
						{{ this.$route.params.id }}
						<h3 class="card-title">Edit Your Brand</h3>
						<router-link to="/brands" class="btn btn-primary btn-sm" style="float: right" type="submit">All Brands</router-link>
					</div>
					<!-- /.card-header -->
					<div class="card-body">
						<form class="form-horizontal">
							<div class="card-body">
								<div class="form-group row">
									<label for="brands" class="col-sm-2 col-form-label">Update Your Brand</label>
									<div class="col-sm-10">
										<input type="text" class="form-control"  id="brands" placeholder="Enter Your Brand name..." v-model="form.brandName">
									</div>
								</div>
							</div>
							<!-- /.card-body -->
							<div class="card-footer">
								<button type="submit" class="btn btn-info" @click.prevent="update()">Update</button>
								<button type="reset" class="btn btn-default float-right">Reset</button>
							</div>
							<!-- /.card-footer -->
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</template>

<script>
export default {
    name: "Edit",
    data(){
    	return{
    		form:{
    			brandName:''
    		}

    	}
    },

    methods:{
    	showBrand:function(){
    		axios.get(`http://127.0.0.1:8000/api/brands/`+ this.$route.params.id, {
    			headers: {
    				Authorization:  `Bearer ${localStorage.getItem('access_token')}`
    			}
    		}).then(response => {
    			this.form.brandName = response.data.brand.brand_name
    		})
    	},

    	update: function(){
    		let id = this.$route.params.id
    		let formData = this.form
    		this.$store.dispatch('update', {id, formData} ).then(response => {
    			if (response.data.status) {
                    toastr.success(response.data.message)
                    this.$router.push('/brands')
                }
    		})
    	}
    },
    mounted(){
    	this.showBrand()
    }
}
</script>