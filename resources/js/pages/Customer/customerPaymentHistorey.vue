<template>
	<div>
		<!-- Payment-summary table -->
	<table class="table table-hover">
		<thead>
			<tr>
				<th scope="col">#</th>
				<th scope="col">Date</th>
				<th scope="col">Payment Amount</th>
				<th scope="col">Payment-Type</th>
			</tr>
		</thead>
		<tbody>
			<tr v-for="(payment, index) in payments.data">
				<th scope="row">{{ index+1 }}</th>
				<td>{{ payment.created_at|time }}</td>
				<td>{{ payment.amount }}</td>
				<td>{{ payment.payment_type}}</td>
			</tr>
			<tr>
				<td v-if="payments.data== 0" colspan="9"><h4 style="color:red; text-align:center;">No Payment Yet!</h4></td>
			</tr>
		</tbody>
	</table>
	<!-- End -->
	</div>
</template>
<script>
export default {
    name: "customerPaymentHistorey",
    data(){
        return{

            payments:[],
        }
    },
    computed:{
         
    },

    methods:{

		getPayments(){
			let id = this.$route.params.id
			axios.get('http://127.0.0.1:8000/api/payments-history/'+id, {
            	headers: {
                    Authorization:  `Bearer ${localStorage.getItem('access_token')}`
                }
             }).then(response => {
             	console.log(response.data)
             	this.payments = response.data
            }).catch(error => {
                console.log(error)
            })
		}
    },
    mounted() {
    	this.getPayments()
    }

}
</script>

<style scoped>


</style>