<template>
<div>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 offset-md-2">
				<div class="card card-success">
					<div class="card-header">
						<h3 class="card-title">All Unit</h3>
						<a class="btn btn-primary btn-sm" style="float: right" href="#modalUnits" data-toggle="modal">Add Unit</a>
					</div>
					<div class="card-body">
						<div class="header-counter">
							{{  selected.length }}
						</div>
						<table class="table table-sm">
							<thead>
								<tr>
									<th>
										<input :disabled="units.data == 0" type="checkbox" @click="selectAll" v-model="selectedAll">
									</th>
									<th style="width: 10px">#</th>
									<th>Unit Name</th>
									<th>Created At</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<tr v-for="(unit, index) in units.data">
									<td><input type="checkbox" :value="unit.unit_id" v-model="selected"></td>
									<td>{{ index+1 }}</td>
									<td>{{ unit.unit }}</td>
									<td>{{ unit.created_at | time  }}</td>
									<td>
										<div class="btn-group">
											<router-link :to="`/edit-unit/${unit.unit_id}`" class="btn btn-info btn-sm">Edit</router-link>
											<button type="submit" class="btn btn-danger btn-sm" @click="deleteUnits(unit.unit_id)">Delete</button>
										</div>
									</td>
								</tr>
								<tr>
									<td colspan="6">
										<div class="dropdown">
											<button :disabled="!isSelected" v-if="units.data && units.data.length > 0 " class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown">
											Action
											</button>
											<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
												<button  class="dropdown-item" @click="allUnitDelete(selected)">DELETE</button>
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<td v-if="units.data == 0" colspan="6" style="color: red;text-align: center"><h4>No record available</h4></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Add Brand Modal -->
	<div class="modal fade" id="modalUnits">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Create Units</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
					</button>
				</div>
				<div class="modal-body">
					<form class="form-group" v-if="error">
						<div class="form-group">
							<label for="name">Unit Name</label>
							<input type="text" class="form-control" v-model="form.UnitName">
							<small style="color: red">{{ error.UnitName}}</small>
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-primary" @click.prevent="addUnits()">Add</button>
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
    			UnitName:''
    		},
    		error:{},
    		selected:[],
    		selectedAll:false,
    		isSelected:false,
    	}
    },
    computed:{
    	 units(){
            return this.$store.getters.allUnits
        }
    },

    watch:{
    	selected:function(data){
    		this.isSelected = (data.length > 0)
			this.selectedAll = (data.length === this.units.data.length )
    	}

    },

    methods:{
    	allUnits: function(){
    		this.$store.dispatch('allUnits')
    	},
    	addUnits: function(){
    		let formData = this.form
    		this.$store.dispatch('addUnits', formData).then( response => {
    			if (response.data.status) {
                    toastr.success(response.data.message)
                    this.form.UnitName = null,
                    this.error.UnitName = null
                    this.allUnits()
                }
                if(!response.data.status) {
                        if( typeof response.data.message === "string"){
                            toastr.error(response.data.message)
                            this.error.UnitName = null
                        }
                        if( typeof response.data.message === "object"){
                            let { UnitName } = response.data.message
                            let message = {
                                UnitName: UnitName ? UnitName[0] : ''
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
    			this.units.data.forEach( (unit) => {
    				this.selected.push(unit.unit_id)
    			})
    		}
    	},
    	deleteUnits:function(id){
    		 Swal.fire({
                title: 'Are you sure?',
                icon: 'question',
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
                showCancelButton: true,
                showCloseButton: true
            }).then(result => {
                if (result.isConfirmed) {
                    this.$store.dispatch("deleteUnits", id).then( response => {
                    	if (response.data.status) {
		                    toastr.success(response.data.message)
		                    this.allUnits()
                            this.selected = []
                        }else{
                        	toastr.error(response.data.message)
                        }
                    });
                }
            })
    	},

        allUnitDelete:function(id){
             Swal.fire({
                title: 'Are you sure?',
                icon: 'question',
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
                showCancelButton: true,
                showCloseButton: true
            }).then(result => {
                if (result.isConfirmed) {
                    this.$store.dispatch('allUnitDelete', id).then( response => {
                        if (response.data.status) {
                            toastr.success(response.data.total + ' ' + response.data.message)
                            this.allUnits()
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
    	this.allUnits()
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
