<template>
<div>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 offset-md-2">
				<div class="card card-success">
					<div class="card-header">
						<h3 class="card-title">All Stock</h3>
						<a class="btn btn-primary btn-sm" style="float: right" href="#modalStock" data-toggle="modal">Add New Stock</a>
					</div>
					<div class="card-body">
						<div class="header-counter">
							{{  selected.length }}
						</div>
						<table class="table table-sm">
							<thead>
								<tr>
									<th>
										<input :disabled="stocks.data == 0" type="checkbox" @click="selectAll" v-model="selectedAll">
									</th>
									<th style="width: 10px">#</th>
									<th>Product Name</th>
                                    <th>Quantity</th>
									<th>Created At</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<tr v-for="(stock, index) in stocks.data">
									<td><input type="checkbox" :value="stock.stocks_id" v-model="selected"></td>
									<td>{{ index+1 }}</td>
									<td>{{ stock.products.product_name }}</td>
                                    <td>{{ stock.quantity }}</td>
									<td>{{ stock.created_at | time  }}</td>
									<td>
										<div class="btn-group">
											<router-link :to="`/edit-stock/${stock.stocks_id}`" class="btn btn-info btn-sm">Edit</router-link>
											<button type="submit" class="btn btn-danger btn-sm" @click="deleteStock(stock.stocks_id)">Delete</button>
										</div>
									</td>
								</tr>
								<tr>
									<td colspan="6">
										<div class="dropdown">
											<button :disabled="!isSelected" v-if="stocks.data && stocks.data.length > 0 " class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown">
											Action
											</button>
											<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
												<button  class="dropdown-item" @click="allStockDelete(selected)">DELETE</button>
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<td v-if="stocks.data == 0" colspan="6" style="color: red;text-align: center"><h4>No record available</h4></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Add Brand Modal -->
	<div class="modal fade" id="modalStock">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Create Stock</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
					</button>
				</div>
				<div class="modal-body">
					<form class="form-group" v-if="error">
                        <div class="form-group">
                            <label for="name">Products</label>
                                <select id="product_id" class="form-control" v-model="form.product_id" @change="getProduct()">
                                    <option value="">---Select Product--</option>
                                    <option :value="product.product_id" v-for="product in getProducts.data">{{ product.product_name }}</option>
                                </select>
                            <small style="color: red">{{ error.product_id}}</small>
                        </div>
                        <div class="form-group">
                            <label for="name">Quantity</label>
                            <input type="text" class="form-control" v-model="form.quantity" @focusout="avgPrice()">
                            <small style="color: red">{{ error.quantity}}</small>
                        </div>
                        <div class="form-group">
                            <label for="name">Present Selling Price</label>
                            <input disabled type="text" class="form-control" v-model="form.present_selling_price">
                        </div>
                        <div class="form-group">
                            <label for="name">Avg Selling Price</label>
                            <input disabled type="text" class="form-control" v-model="form.avg_selling_price">
                        </div>
						<div class="form-group">
							<button type="submit" class="btn btn-primary" @click.prevent="addStock()">Add</button>
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
    import {mapGetters} from 'vuex';
export default {
    name: "Category",
    data(){
    	return{
    		form:{
    			product_id:'',
                quantity:'',
                avg_selling_price:'',
                present_selling_price:'',
    		},
            existing_qty:'',
    		error:{},
    		selected:[],
    		selectedAll:false,
    		isSelected:false,
    	}
    },
    computed:{
    	 stocks(){
            return this.$store.getters.allStocks
        },
        ...mapGetters({
             getProducts:'allproducts'
        })
    },

    watch:{
    	selected:function(data){
    		this.isSelected = (data.length > 0)
			this.selectedAll = (data.length === this.stocks.data.length )
    	}

    },

    methods:{
    	allStocks: function(){
    		this.$store.dispatch('allStocks')
    	},
    	addStock: function(){
    		let formData = this.form
    		this.$store.dispatch('addStock', formData).then( response => {
    			if (response.data.status) {
                    toastr.success(response.data.message)
                    this.form.product_id  = null,
                    this.error.product_id = null,
                    this.form.quantity    = null,
                    this.error.quantity   = null
                    this.allStocks()
                }
                if(!response.data.status) {
                        if( typeof response.data.message === "string"){
                            toastr.error(response.data.message)
                            this.error.product_id = null,
                            this.error.quantity   = null
                        }
                        if( typeof response.data.message === "object"){
                            let { product_id, quantity } = response.data.message
                            let message = {
                                product_id: product_id ? product_id[0] : '',
                                quantity: quantity ? quantity[0] : ''
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
    			this.stocks.data.forEach( (stock) => {
    				this.selected.push(stock.stocks_id)
    			})
    		}
    	},
    	deleteStock:function(id){
    		 Swal.fire({
                title: 'Are you sure?',
                icon: 'question',
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
                showCancelButton: true,
                showCloseButton: true
            }).then(result => {
                if (result.isConfirmed) {
                    this.$store.dispatch("deleteStock", id).then( response => {
                    	if (response.data.status) {
		                    toastr.success(response.data.message)
		                    this.allStocks()
                        }else{
                        	toastr.error(response.data.message)
                        }
                    });
                }
            })
    	},

        allStockDelete:function(id){
             Swal.fire({
                title: 'Are you sure?',
                icon: 'question',
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
                showCancelButton: true,
                showCloseButton: true
            }).then(result => {
                if (result.isConfirmed) {
                    this.$store.dispatch('allStockDelete', id).then( response => {
                        if (response.data.status) {
                            toastr.success(response.data.total + ' ' + response.data.message)
                            this.allStocks()
                            this.selected.splice(0,this.selected.length);
                        }else{
                            toastr.error(response.data.message)
                        }
                    })
                }
            })
        },
        getProduct(){
            let id = this.form.product_id
            axios.get('http://127.0.0.1:8000/api/get-product/'+id,{
                headers: {
                    Authorization:  `Bearer ${localStorage.getItem('access_token')}`
                }
            }).then(response => {
                this.form.present_selling_price = response.data.selling_price
                this.existing_qty = response.data.qty
            }).catch( error => {
                console.log("error")
            })
        },
        avgPrice(){
            let sum_of_qty = parseInt(this.form.quantity) + parseInt(this.existing_qty)
            let avg_price = this.form.present_selling_price * sum_of_qty /sum_of_qty
            this.form.avg_selling_price = avg_price
        }
    },
    mounted(){
    	this.allStocks()
        this.$store.dispatch('allProducts')

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
