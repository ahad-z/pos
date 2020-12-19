<template>
<div>
		<div class="row">
			<div class="col-md-8 offset-md-2">
				<div class="card card-success">
					<div class="card-header">
                        <div style="margin-bottom:10px;">
                            <h3 class="card-title text-center" style="color:gray">All Brands</h3>
                                <!-- Filter -->
                                    <!-- Can be added If needed -->
                                <!-- End -->
                                <!-- Invoice search  -->
                                <div style="width:300px;">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Enter Brand Name for....." v-model="searchKey">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button" @click="searchBrand()">
                                            <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <!--End -->
                                </div>
                            </div>
						<a class="btn btn-primary btn-sm" style="float: right" href="#modalAddUser" data-toggle="modal">Add Brand</a>
					</div>
					<div class="card-body">
						<div class="header-counter">
							{{  selected.length }}
						</div>
						<table class="table table-hover">
							<thead>
								<tr>
									<th>
										<input :disabled="brands.data == 0" type="checkbox" @click="selectAll" v-model="selectedAll">
									</th>
									<th style="width: 10px">#</th>
									<th>Brand Name</th>
									<th>Created At</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<tr v-for="(brand, index) in brands.data">
									<td><input type="checkbox" :value="brand.brand_id" v-model="selected"></td>
									<td>{{ index+1 }}</td>
									<td>{{ brand.brand_name }}</td>
									<td>{{ brand.created_at | time  }}</td>
									<td>
										<div class="btn-group">
											<router-link :to="`/edit/${brand.brand_id}`" class="btn btn-info btn-sm">Edit</router-link>
											<button type="submit" class="btn btn-danger btn-sm" @click="deleteBrand(brand.brand_id)">Delete</button>
										</div>
									</td>
								</tr>
								<tr>
									<td colspan="6">
										<div class="dropdown">
											<button :disabled="!isSelected" v-if="brands.data && brands.data.length > 0 " class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown">
											Action
											</button>
											<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
												<button  class="dropdown-item" @click="batchDelete(selected)">DELETE</button>
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<td v-if="brands.data == 0" colspan="5" style="color: red;text-align: center"><h4>No record available</h4></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	<!-- Add Brand Modal -->
	<div class="modal fade" id="modalAddUser">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Create User</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
					</button>
				</div>
				<div class="modal-body">
					<form class="form-group" v-if="error">
						<div class="form-group">
							<label for="name">Brand Name</label>
							<input type="text" class="form-control" v-model="form.brandName">
							<small style="color: red">{{ error.brandName}}</small>
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-primary" @click.prevent="addBrand()">Add</button>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
</template>
<script>
export default {
    name: "Brand",
    data(){
    	return{
    		form:{
    			brandName:''
    		},
    		error:{},
    		selected:[],
    		selectedAll:false,
    		isSelected:false,
            searchKey:''
    	}
    },
    computed:{
    	 brands(){
            return this.$store.getters.allBrands
        }
    },

    watch:{
    	selected:function(data){
    		this.isSelected = (data.length > 0)
			this.selectedAll = (data.length === this.brands.data.length )
    	}

    },

    methods:{
    	allBrands: function(){
            this.$Progress.start()
            this.$store.dispatch('allBrands')
            this.$Progress.finish()
    	},

        searchBrand() {
            if(!this.searchKey == ''){
                this.$store.dispatch('allBrands', {searchKey: this.searchKey}).then(response => {
                    this.searchKey = ''
                })
            }else{
                this.allBrands()
            }
        },

    	addBrand: function(){
    		let formData = this.form
            this.$Progress.start()
    		this.$store.dispatch('addBrand', formData).then( response => {
    			if (response.data.status) {
                    toastr.success(response.data.message)
                    this.form.brandName = null
                    this.error.brandName = null
                    this.allBrands()
                }
                if(!response.data.status) {
                        if( typeof response.data.message === "string"){
                            toastr.error(response.data.message)
                            this.error.brandName = null
                        }
                        if( typeof response.data.message === "object"){
                            let { brandName } = response.data.message
                            let message = {
                                brandName: brandName ? brandName[0] : ''
                            };
                            this.error = message
                       }                
                }
                this.$Progress.finish()
    		}).catch(error => {

                this.$Progress.fail()
            })
    	},
    	/* For all check */
    	selectAll: function(event){
    		if(event.target.checked === false){
    			this.selected = [];
    		}else{
    			this.brands.data.forEach( (brand) => {
    				this.selected.push(brand.brand_id)
    			})
    		}
    	},
    	deleteBrand:function(id){
    		 Swal.fire({
                title: 'Are you sure?',
                icon: 'question',
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
                showCancelButton: true,
                showCloseButton: true
            }).then(result => {
                if (result.isConfirmed) {
                    this.$Progress.start()
                    this.$store.dispatch("deleteBrand", id).then( response => {
                    	if (response.data.status) {
		                    toastr.success(response.data.message)
		                    this.allBrands()
                        }else{
                        	toastr.error(response.data.message)
                        }
                        this.$Progress.finish()
                    });
                }
            })
    	},

        batchDelete:function(id){
             Swal.fire({
                title: 'Are you sure?',
                icon: 'question',
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
                showCancelButton: true,
                showCloseButton: true
            }).then(result => {
                if (result.isConfirmed) {
                    this.$Progress.start()
                    this.$store.dispatch('batchDelete', id).then( response => {
                        if (response.data.status) {
                            toastr.success(response.data.total + ' ' + response.data.message)
                            this.allBrands()
                             this.selected.splice(0,this.selected.length);
                        }else{
                            toastr.error(response.data.message)
                        }
                        this.$Progress.finish()
                    })
                }
            })
        }
    },
    mounted(){
    	this.allBrands()
    }

}
</script>

<style scoped>

.table thead th {
    font-weight: 800;
    color: rgb(89 117 22);
    font-size: 0.75rem;
    text-transform: uppercase;
}
 .header-counter {
     border: 1px solid #dcbaba;
     font-size: 18px;
     margin: 13px;
     width: 25px;
     text-align: center;
 }
</style>
