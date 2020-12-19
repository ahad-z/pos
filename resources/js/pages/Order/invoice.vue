<template>
<div>
	<div style="margin-bottom:10px;">
		<!-- Filter -->
		<div class="btn-group" style="float:right;">
			<button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<i class="fa fa-filter"></i>
			</button>
			<div class="dropdown-menu">
				<div class="input-group">
					<input type="date" class="form-control dropdown-item" v-model="firstDate">
				</div>
				<input type="date" class="form-control dropdown-item" v-model="secondDate">
				<div class="dropdown-divider"></div>
				<button style="float:right;" class="btn btn-primary" type="button" @click="SearchOrder(firstDate, secondDate)">
				<i class="fas fa-search fa-sm"></i>
				</button>
			</div>
		</div>
		<!-- End -->
		<!-- Invoice search  -->
		<div style="width:500px;">
			<div class="input-group">
				<input type="text" class="form-control" placeholder="Enter Invoice Number for..." v-model="searchKey">
				<div class="input-group-append">
					<button class="btn btn-primary" type="button" @click="SearchOrder(searchKey)">
					<i class="fas fa-search fa-sm"></i>
					</button>
				</div>
			</div>
			<!--End -->
		</div>
	</div>
	<!-- An order table -->
	<table class="table table-hover">
		<thead>
			<tr>
				<th scope="col">#</th>
				<th scope="col">Date</th>
				<th scope="col">Customer Name</th>
				<th scope="col">Discount-Type</th>
				<th scope="col">Discount-amount</th>
				<th scope="col">Grand Total</th>
				<th scope="col">Due</th>
				<th scope="col">Status</th>
				<th scope="col">Action</th>
			</tr>
		</thead>
		<tbody>
			<tr v-for="(order, index) in orders">
				<th scope="row">{{ index+1 }}</th>
				<td>{{ order.created_at|time }}</td>
				<td>{{ order.customer && order.customer.cust_name ? order.customer.cust_name  : 'walk-in Customer'}}</td>
				<td>{{ order.discount_type == '%' ? 'Percent' :'Cash'}}</td>
				<td>{{ order.discount_amount}}</td>
				<td>{{ order.total }}</td>
				<td>{{ order.due}}</td>
				<td><span class="badge" :class="setBadge(order.status)">{{ (order.status == 'paid') ? 'paid' :(order.status == 'due') ? 'due' : (order.status == 'return') ? 'return':'' }}</span></td>
				<td>
					<div class="btn-group">
						<a class="btn btn-primary btn-sm"  :href="'#vieOrder' + order.order_id" data-toggle="modal"><i class="fas fa-eye"></i></a>
						<router-link :to="`/edit-order/${order.order_id}`" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></router-link>
						<button  class="btn btn-danger btn-sm" @click = "deleteOrder(order.order_id)"><i class="fas fa-trash-alt"></i></button>
						<a  class="btn btn-success btn-sm" :href="'#viewPayment' + order.order_id" data-toggle="modal"><i class="fab fa-amazon-pay"></i></a>
						<a  class="btn btn-info btn-sm" href="#viewRetutnProductInfo" @click="getReturnProductInfo(order.order_details[0]['id'])" data-toggle="modal"><i class="fa fa-exchange-alt"></i></a>
					</div>
				</td>
			</tr>
			<tr>
				<td v-if="orders == 0" colspan="9"><h4 style="color:red; text-align:center;">No Order Create Yet!</h4></td>
			</tr>
		</tbody>
	</table>
	<!-- End -->
	<!-- View Modal for an order -->
	<div v-for="(order, index) in orders" class="modal fade" :id="'vieOrder' + order.order_id">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Order</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
					</button>
				</div>
				<div class="modal-body">
					<!-- product -->
					<div class="container-fluid invoice-container">
						<header>
							<div class="row align-items-center">
								<div class="col-sm-7 text-center text-sm-left mb-3 mb-sm-0">
									<img id="logo" style="width: 150px; height: 150px;" :src="'/uploads/logo_img/hardwaresuperstore-logo.jpg'" title="Koice" alt="DH" />
								</div>
								<div class="col-sm-5 text-center text-sm-right">
									<h4 class="text-7 mb-0">Invoice</h4>
								</div>
							</div>
							<hr>
						</header>
						<main>
							<div class="row">
								<div class="col-sm-6"><strong>Date: </strong>{{ order.created_at | time }}</div>
								<div class="col-sm-6 text-sm-right"> <strong>Invoice No:</strong> {{ order.invoice_number }}</div>
							</div>
							<hr>
							<div class="row">
								<div class="col-sm-6 text-sm-right order-sm-1">
									<strong>Pay To:</strong>
									<address>
										{{ order.customer && order.customer.cust_name ? order.customer.cust_name  : 'walk-in Customer' }}<br />
										{{ order.customer && order.customer.cust_phone }}<br />
										{{ order.customer && order.customer.cust_address}}
									</address>
								</div>
								<div class="col-sm-6 order-sm-0">
									<strong>Invoiced To:</strong>
									<address>
										Md.Mohouddin Dewan<br />
										Chowrastta Bazar<br />
										Shop #102<br />
										Bagadi
									</address>
								</div>
							</div>
							<div class="card">
								<div class="card-header">
									<h5 class="text-center" style="color: red">Don't Lose your Invoice. It Will need in future</h5>
								</div>
								<div class="card-body  px-2">
									<table class="table">
										<thead>
											<tr style="width: 100px">
												<th scope="col">#</th>
												<th scope="col">Product Name</th>
												<th scope="col">Unit</th>
												<th scope="col">Selling price</th>
												<th scope="col">Qty</th>
												<th scope="col">Dis-Type</th>
												<th scope="col">Dis-Amount</th>
												<th scope="col">Amount</th>
											</tr>
										</thead>
										<tbody>
											<tr  v-for="(orderDetail,index) in order.order_details">
												<td>{{ index+1 }}</td>
												<td>{{orderDetail.product.product_name }}</td>
												<td>{{orderDetail.product.units.unit }}</td>
												<td>{{orderDetail.product.selling_price }}</td>
												<td>{{orderDetail.qty }}</td>
												<td>{{orderDetail.discount_type == '%' ? 'percent':'cash'}}</td>
												<td>{{orderDetail.discount_amount }}</td>
												<td>{{orderDetail.product_subtotal }}</td>
											</tr>
											<tr>
												<td colspan="7" class="bg-light-2 text-right"><strong>Sub Total : </strong></td>
												<td class="bg-light-2 text-right">{{ order.sub_total  }}</td>
											</tr>
											<tr>
												<td colspan="7" class="bg-light-2 text-right"><strong>Discoutn Type : </strong><strong> {{ order.discount_type == '%' ? 'Percent' :'Cash' }}</strong></td>
												<td class="bg-light-2 text-right">{{order.discount_amount}}</td>
											</tr>
											<tr>
												<td colspan="7" class="bg-light-2 text-right"><strong>Total : </strong></td>
												<td  class="bg-light-2 text-right">{{order.total}}</td>
											</tr>
											<tr v-for="payment in order.payments ">
												<td>Date:</td>
												<td colspan="3">{{ payment.created_at | time }}</td>
												<td colspan="3" class="bg-light-2 text-right"><strong>Paid : </strong></td>
												<td class="bg-light-2 text-right">{{ payment.amount }}</td>
											</tr>
											<tr>
												<td colspan="7" class="bg-light-2 text-right"><strong class="badge" :class="setBadge(order.status)">{{ (order.status == 'paid') ? 'paid' :(order.status == 'due') ? 'due' : (order.status == 'return') ? 'return':'' }} : </strong></td>
												<td class="bg-light-2 text-right">{{ order.due == 0 ? 'Yeas': order.due }}</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</main>
						<footer class="text-center mt-4">
							<p class="text-1"><strong>NOTE :</strong> This is computer generated receipt and does not require physical signature.</p>
							<button  @click = "invoicePrint(order.order_id)" class="btn btn-light border text-black-50 shadow-none" ><i class="fa fa-print"></i> Print</button>
						</footer>
					</div>
					<!-- end -->
				</div>
			</div>
		</div>
	</div>
	<!-- End -->

	<!-- Return Product show modal -->
	<div  class="modal fade" id="viewRetutnProductInfo">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Return Product</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
					</button>
				</div>
				<div class="modal-body">
					<table class="table">
						<thead>
							<tr>
								<th scope="col">Sl</th>
								<th scope="col">Product Name</th>
								<th scope="col">Previous Qty</th>
								<th scope="col">Present Qty</th>
								<th scope="col">Date</th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="(qty,index) in returnQty.data">
								<th scope="row">{{ index+1 }}</th>
								<td>{{ qty.product_name }}</td>
								<td>{{ qty.previous_qty }}</td>
								<td>{{ qty.present_qty   }}</td>
								<td>{{ qty.created_at |time }}</td>
							</tr>
							<tr>
								<td colspan="5" v-if="returnQty.data ==0" class="text-center"><h5 style="color:red;">No product return for this Order</h5></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<!-- End Here -->

	<!-- Payment modal start  -->
	<div v-for="(order, index) in orders" class="modal fade" :id="'viewPayment' + order.order_id">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Payment</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
					</button>
				</div>
				<div class="modal-body">
					<!-- payment -->
					<!-- table for payment Information -->
					<table class="table">
						<thead>
							<tr style="width: 100px">
								<th scope="col">Total payable amount</th>
								<th scope="col">Due</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>{{ paymentSum(order.payments) }}</td>
							    <td>{{ order.due}}</td>
							</tr>

						</tbody>
					</table>
					<!-- End -->
					<form class="form-group">
						<div class="form-group">
							<label for="paymentType">Payment Type</label>
							<select id="paymentType" class="form-control" v-model="payment.payment_type">
								<option value="" disabled>Payment Type</option>
								<option value="cash">Cash</option>
								<option value="bkash">Bkash</option>
							</select>
							<!-- <small style="color: red">{{ error.cust_phone}}</small> -->
						</div>
						<div class="form-group">
							<label for="amount">Amount</label>
							<input type="text" class="form-control" id="amount" v-model="payment.payment_total" />
							<!-- <small style="color: red">{{ error.cust_address}}</small> -->
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-primary" @click.prevent="addPayment(order.order_id, order.cust_id)">Add Payment</button>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						</div>
					</form>
					<!-- end -->
				</div>
			</div>
		</div>
	</div>
	<!-- End modal -->
</div>
</template>
<script>
	import {mapGetters} from 'vuex';
	export default{
		data(){
			return{
				payment:{
	                payment_type:'',
	                payment_total:'',
              	},

              	returnQty:{},
              	searchKey:'',
              	firstDate:'',
              	secondDate:''
			}
		},

		computed: {
			...mapGetters({
	            orders : 'allOrder'
	        }),

		},

		methods:{

			getReturnProductInfo(OrderDetailId){
				axios.get(`http://127.0.0.1:8000/api/return-product-qty/`+OrderDetailId, {
	                    headers: {
	                        Authorization:  `Bearer ${localStorage.getItem('access_token')}`
	                    }
                	}).then(response => {
                		console.log(response.data)
                		this.returnQty = response.data
                	}).catch(error => {
                		console.log(error)
                	})
			},

			addPayment(order_id, cust_id) {
				if(this.payment.payment_type == '' ){
					toastr.warning('Please Select Payment type')
				}else if(this.payment.payment_total == ''){
					toastr.warning('Please Enter Payment amount')
				}else if( isNaN(parseFloat(this.payment.payment_total))){
					toastr.warning('Please Enter Digit')
				}else{

					let orderID  = order_id 
					let custID   = cust_id
					let formData = this.payment
					axios.post(`http://127.0.0.1:8000/api/orders-payment-add`, {orderID, custID, formData}, {
	                    headers: {
	                        Authorization:  `Bearer ${localStorage.getItem('access_token')}`
	                    }
                	}).then(response => {
                		if(response.data.status){
                			toastr.success('payment add successfully!')
                			this.payment = {}
                			this.allOrder()

                		}else{
                			toastr.warning('something is wrong!')
                		}
                	})
				}
				
			},

			paymentSum(data){
				let i
				let sum = 0
				if(data){
					for (i = 0; i < data.length; i++) {
				 	 	sum += parseFloat (data[i]['amount'])
				 	}
				  return sum
				}
			},


			allOrder() {
				this.$store.dispatch('allOrder')
			},

			SearchOrder(data, date){

					if(!data == ''){
					this.$store.dispatch('allOrder', {searchKey:data, date:date}).then(response => {
						if(response.data.data.length == 0){
							toastr.warning('No order for this Invoice Number Or Match Your invoice Number Again')
						}
						this.searchKey  = ''
						this.firstDate  = ''
						this.secondDate = ''
					    })
				    }else{
					    this.allOrder()
				    }
			},

			setBadge(status){
				let data = {due : 'badge-danger', paid	:'badge-success', return:'badge-info' }
                return data[status]

			},

			invoicePrint(id) {
				let orderId = id
                window.open("http://127.0.0.1:8000/generate-pdf/"+orderId, "_blank")
			},

			deleteOrder:function(id){
    		 Swal.fire({
                title: 'Are you sure?',
                icon: 'question',
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
                showCancelButton: true,
                showCloseButton: true
            }).then(result => {
                	if (result.isConfirmed) {
                    	this.$store.dispatch("deleteOrder", id).then( response => {
                    		if (response.data.status) {
		                    	toastr.success(response.data.message)
		                    	this.allOrder()
                        	}else{
                        		toastr.error(response.data.message)
                        	}
                    	});
                	}
            	})
    		},
		},

		mounted(){
			this.allOrder()
			this.paymentSum()
		}


	}
</script>

<style scoped>
 @media screen and (min-width: 676px){
        .modal-dialog {
          max-width: 1000px; /* New width for default modal */
        }
    }

</style>