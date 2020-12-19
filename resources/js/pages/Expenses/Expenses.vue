<template>
<div>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 offset-md-2">
				<div class="card card-success">
					<div class="card-header">
						<h3 class="card-title">All Expenses </h3>
						<!-- <router-link to="#" class="btn btn-primary btn-sm" style="float: right" type="submit">Add Brand</router-link> -->
						<a class="btn btn-primary btn-sm" style="float: right" href="#modalAddUser" data-toggle="modal">Add Expenses</a>
					</div>
					<div class="card-body">
						<div class="header-counter">
							{{  selected.length }}
						</div>
						<table class="table table-sm">
							<thead>
								<tr>
									<th>
										<input :disabled="expenses.data == 0" type="checkbox" @click="selectAll" v-model="selectedAll">
									</th>
									<th style="width: 10px">#</th>
									<th>Expenses Type</th>
                                    <th>Amount</th>
									<th>Created At</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<tr v-for="(expense, index) in expenses.data">
									<td><input type="checkbox" :value="expense.id" v-model="selected"></td>
									<td>{{ index+1 }}</td>
									<td>{{ expense.type | capitalize }}</td>
                                    <td>{{ expense.amount }}</td>
									<td>{{ expense.created_at | time  }}</td>
									<td>
										<div class="btn-group">
											<router-link :to="`/edit-expense/${expense.id}`" class="btn btn-info btn-sm">Edit</router-link>
											<button type="submit" class="btn btn-danger btn-sm" @click="deleteExpense(expense.id)">Delete</button>
										</div>
									</td>
								</tr>
								<tr>
									<td colspan="6">
										<div class="dropdown">
											<button :disabled="!isSelected" v-if="expenses.data && expenses.data.length > 0 " class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown">
											Action
											</button>
											<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
												<button  class="dropdown-item" @click="allexpensesDelete(selected)">DELETE</button>
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<td v-if="expenses.data == 0" colspan="5" style="color: red;text-align: center"><h4>No record available</h4></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Add Brand Modal -->
	<div class="modal fade" id="modalAddUser">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Add Expenses </h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
					</button>
				</div>
				<div class="modal-body">
					<form class="form-group" v-if="error">
						<div class="form-group">
                            <label for="type">Expenses Type</label>
                           <select id="type" class="form-control"   v-model="form.type">
                                <option value="">---Select Expense Type--</option>
                                <option value="shop">Shop</option>
                                <option value="family">Family</option>
                                <option value="persoanl">Personal</option>
                            </select>
                            <small style="color: red">{{ error.type}}</small>
                        </div>
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="text" class="form-control" v-model="form.amount">
                            <small style="color: red">{{ error.amount}}</small>
                        </div>
						<div class="form-group">
							<button type="submit" class="btn btn-primary" @click.prevent="addExpenses()">Add</button>
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
    			type:'',
                amount:''
    		},
    		error:{},
    		selected:[],
    		selectedAll:false,
    		isSelected:false,
    	}
    },
    computed:{
    	 expenses(){
            return this.$store.getters.allExpenses
        }
    },

    watch:{
    	selected:function(data){
    		this.isSelected = (data.length > 0)
			this.selectedAll = (data.length === this.expenses.data.length )
    	}

    },

    methods:{
    	allExpenses: function(){
    		this.$store.dispatch('allExpenses')
    	},
    	addExpenses: function(){
    		let formData = this.form
    		this.$store.dispatch('addExpenses', formData).then( response => {
    			if (response.data.status) {
                    toastr.success(response.data.message)
                    this.form.type = null
                    this.form.amount = null
                    this.error.type = null
                    this.error.amount = null
                    this.allExpenses()
                }
                if(!response.data.status) {
                        if( typeof response.data.message === "string"){
                            toastr.error(response.data.message)
                            this.error.type = null
                            this.error.amount = null
                        }
                        if( typeof response.data.message === "object"){
                            let { type, amount } = response.data.message
                            let message = {
                                type: type ? type[0] : '',
                                amount: amount ? amount[0] : '',  
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
    			this.expenses.data.forEach( (expense) => {
    				this.selected.push(expense.id)
    			})
    		}
    	},
    	deleteExpense:function(id){
    		 Swal.fire({
                title: 'Are you sure?',
                icon: 'question',
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
                showCancelButton: true,
                showCloseButton: true
            }).then(result => {
                if (result.isConfirmed) {
                    this.$store.dispatch("deleteExpense", id).then( response => {
                    	if (response.data.status) {
		                    toastr.success(response.data.message)
		                    this.allExpenses()
                        }else{
                        	toastr.error(response.data.message)
                        }
                    });
                }
            })
    	},

        allexpensesDelete:function(id){
             Swal.fire({
                title: 'Are you sure?',
                icon: 'question',
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
                showCancelButton: true,
                showCloseButton: true
            }).then(result => {
                if (result.isConfirmed) {
                    this.$store.dispatch('allexpensesDelete', id).then( response => {
                        if (response.data.status) {
                            toastr.success(response.data.total + ' ' + response.data.message)
                            this.allExpenses()
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
    	this.allExpenses()
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
