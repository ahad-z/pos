<template>
<div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Edit Your Expense</h3>
                        <router-link to="/expense" class="btn btn-primary btn-sm" style="float: right" type="submit">All Expenses</router-link>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form class="form-horizontal">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="type">Expenses Type</label>
                                    <select id="type" class="form-control"   v-model="form.type">
                                        <option value="">---Select Expense Type--</option>
                                        <option value="shop">Shop</option>
                                        <option value="family">Family</option>
                                        <option value="persoanl">Personal</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="amount">Amount</label>
                                    <input type="text" class="form-control"  id="amount" placeholder="Enter Your Amount..." v-model="form.amount">
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-info" @click.prevent="updateExpense()">Update</button>
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
    			type:'',
                amount:''
    		}
    	}
    },

    methods:{
    	showExpense:function(){
    		axios.get(`http://127.0.0.1:8000/api/expenses/`+ this.$route.params.id, {
    			headers: {
    				Authorization:  `Bearer ${localStorage.getItem('access_token')}`
    			}
    		}).then(response => {
    			this.form.type = response.data.expense.type
                this.form.amount = response.data.expense.amount
    		})
    	},

    	updateExpense: function(){
    		let id = this.$route.params.id
    		let formData = this.form
    		this.$store.dispatch('updateExpense', {id, formData} ).then(response => {
    			if (response.data.status) {
                    toastr.success(response.data.message)
                    this.$router.push('/expense')
                }
    		})
    	}
    },
    mounted(){
    	this.showExpense()
    }
}
</script>