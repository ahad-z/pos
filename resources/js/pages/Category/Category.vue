<template>
<div>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 offset-md-2">
				<div class="card card-success">
					<div class="card-header">
						<h3 class="card-title">All Category</h3>
						<a class="btn btn-primary btn-sm" style="float: right" href="#modalCategoryr" data-toggle="modal">Add Category</a>
					</div>
					<div class="card-body">
						<div class="header-counter">
							{{  selected.length }}
						</div>
						<table class="table table-sm">
							<thead>
								<tr>
									<th>
										<input :disabled="categories.data == 0" type="checkbox" @click="selectAll" v-model="selectedAll">
									</th>
									<th style="width: 10px">#</th>
									<th>Category Name</th>
									<th>Created At</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<tr v-for="(category, index) in categories.data">
									<td><input type="checkbox" :value="category.cat_id" v-model="selected"></td>
									<td>{{ index+1 }}</td>
									<td>{{ category.category_name }}</td>
									<td>{{ category.created_at | time  }}</td>
									<td>
										<div class="btn-group">
											<router-link :to="`/edit-category/${category.cat_id}`" class="btn btn-info btn-sm">Edit</router-link>
											<button type="submit" class="btn btn-danger btn-sm" @click="deleteCategory(category.cat_id)">Delete</button>
										</div>
									</td>
								</tr>
								<tr>
									<td colspan="6">
										<div class="dropdown">
											<button :disabled="!isSelected" v-if="categories.data && categories.data.length > 0 " class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown">
											Action
											</button>
											<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
												<button  class="dropdown-item" @click="AllCatDelete(selected)">DELETE</button>
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<td v-if="categories.data == 0" colspan="6" style="color: red;text-align: center"><h4>No record available</h4></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Add Brand Modal -->
	<div class="modal fade" id="modalCategoryr">
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
							<label for="name">Category Name</label>
							<input type="text" class="form-control" v-model="form.categoryName">
							<small style="color: red">{{ error.categoryName}}</small>
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-primary" @click.prevent="addCategory()">Add</button>
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
    name: "Category",
    data(){
    	return{
    		form:{
    			categoryName:''
    		},
    		error:{},
    		selected:[],
    		selectedAll:false,
    		isSelected:false,
    	}
    },
    computed:{
    	 categories(){
            return this.$store.getters.allCategories
        }
    },

    watch:{
    	selected:function(data){
    		this.isSelected = (data.length > 0)
			this.selectedAll = (data.length === this.categories.data.length )
    	}

    },

    methods:{
    	allCategories: function(){
    		this.$store.dispatch('allCategories')
    	},
    	addCategory: function(){
    		let formData = this.form
    		this.$store.dispatch('addCategories', formData).then( response => {
    			if (response.data.status) {
                    toastr.success(response.data.message)
                    this.form.categoryName = null,
                    this.error.categoryName = null
                    this.allCategories()
                }
                if(!response.data.status) {
                        if( typeof response.data.message === "string"){
                            toastr.error(response.data.message)
                            this.error.categoryName = null
                        }
                        if( typeof response.data.message === "object"){
                            let { categoryName } = response.data.message
                            let message = {
                                categoryName: categoryName ? categoryName[0] : ''
                            };
                            this.error = message
                       }                
                }
    		})
    	},
    	/* For all check */
    	selectAll: function(event){
    		if(event.target.checked === false){
    			this.selected = [];
    		}else{
    			this.categories.data.forEach( (category) => {
    				this.selected.push(category.cat_id)
    			})
    		}
    	},
    	deleteCategory:function(id){
    		 Swal.fire({
                title: 'Are you sure?',
                icon: 'question',
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
                showCancelButton: true,
                showCloseButton: true
            }).then(result => {
                if (result.isConfirmed) {
                    this.$store.dispatch("deleteCategories", id).then( response => {
                    	if (response.data.status) {
		                    toastr.success(response.data.message)
		                    this.allCategories()
                        }else{
                        	toastr.error(response.data.message)
                        }
                    });
                }
            })
    	},

        AllCatDelete:function(id){
             Swal.fire({
                title: 'Are you sure?',
                icon: 'question',
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
                showCancelButton: true,
                showCloseButton: true
            }).then(result => {
                if (result.isConfirmed) {
                    this.$store.dispatch('AllCatDelete', id).then( response => {
                        if (response.data.status) {
                            toastr.success(response.data.total + ' ' + response.data.message)
                            this.allCategories()
                            this.selected.splice(0,this.selected.length);
                        }else{
                            toastr.error(response.data.message)
                        }
                    })
                }
            })
        }
    },
    mounted(){
    	this.allCategories()
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
