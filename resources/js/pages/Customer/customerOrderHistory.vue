<template>
	<div>
		<!-- An Order-summary table -->
	<table class="table table-hover">
		<thead>
			<tr>
				<th scope="col">Invoice Number</th>
				<th scope="col">Date</th>
				<th scope="col">Customer Name</th>
				<th scope="col">Discount-Type</th>
				<th scope="col">Discount-amount</th>
				<th scope="col">Grand Total</th>
				<th scope="col">Amount</th>
				<th scope="col">Status</th>
				<th scope="col">Action</th>
			</tr>
		</thead>
		<tbody>
			<tr v-for="(order, index) in orders.data">
				<th scope="row">{{ order.invoice_number }}</th>
				<td>{{ order.created_at|time }}</td>
				<td>{{ order.customer && order.customer.cust_name ? order.customer.cust_name  : 'walk-in Customer'}}</td>
				<td>{{ order.discount_type == '%' ? 'Percent' :'Cash'}}</td>
				<td>{{ order.discount_amount}}</td>
				<td>{{ order.total }}</td>
				<td>{{ order.due}}</td>
				<td><span class="badge" :class="setBadge(order.status)">{{ (order.status == 'paid') ? 'paid' :(order.status == 'due') ? 'due' : (order.status == 'return') ? 'return':'' }}</span></td>
				<td>
					<div class="btn-group">
						<a  class="btn btn-success btn-sm" href="#addPayment" data-toggle="modal" @click="getPaymentData(order.order_id, order.due)"><i class="fab fa-amazon-pay"></i></a>
					</div>
				</td>
			</tr>
			<tr>
				<td v-if="orders.data == 0" colspan="9"><h4 style="color:red; text-align:center;">No Order Create Yet!</h4></td>
			</tr>
		</tbody>
	</table>
	<!-- End -->
	<!-- Add Payment Modal -->
		<div class="modal fade" id="addPayment">
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
								<td>{{ paymentSum( payments.data) }}</td>
							    <td>{{ order_due }}</td>
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
							<button type="submit" class="btn btn-primary" @click.prevent="addPayment(payments.data[0]['order_id'], payments.data[0]['cust_id'])">Add Payment</button>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						</div>
					</form>
					<!-- end -->
				</div>
			</div>
		</div>
	</div>
	<!-- End Here -->
	</div>
</template>
<script>
export default {
    name: "customerOrderHistory",
    data(){
        return{
            orders:[],

            payment:{
            	payment_type:'',
            	payment_total:''
            },
            payments:[],
            order_due: ''
        }
    },
    computed:{
         
    },

    methods:{

    	getInvoice() {
    		let id = this.$route.params.id
            axios.get('http://127.0.0.1:8000/api/oders-summary/'+id, {
            	headers: {
                    Authorization:  `Bearer ${localStorage.getItem('access_token')}`
                }
             }).then(response => {
             	this.orders = response.data
            }).catch(error => {
                console.log(error)
            })
    	},

    	setBadge(status){
				let data = {due : 'badge-danger', paid	:'badge-success', return:'badge-info' }
                return data[status]

			},
		getPaymentData(id, due){
			this.order_due = due
			axios.get('http://127.0.0.1:8000/api/payments/'+id, {
            	headers: {
                    Authorization:  `Bearer ${localStorage.getItem('access_token')}`
                }
             }).then(response => {
             	this.payments = response.data
            }).catch(error => {
                console.log(error)
            })
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
                			this.getInvoice()

                		}else{
                			toastr.warning('something is wrong!')
                		}
                	})
				}
				
			},
    },
    mounted() {
    	this.getInvoice()
    }

}
</script>

<style scoped>


</style>

