<template>
    <div>
        <DashboardHeader></DashboardHeader>
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Earnings (Today)</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ this.today_sell  }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Earnings (Monthly)</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ this.monthly_sell }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Customer -->
          <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Customer</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ this.total_customer }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-friends fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Due Ammount (Today)</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ this.today_due  }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Chart from 'chart.js';
import DashboardHeader from "../layouts/partials/DashboardHeader";
export default {
    name: "Dashboard",
    components: {
        DashboardHeader
    },
    data(){
        return{
            total_customer : '',
            monthly_sell:'',
            today_due:'',
            today_sell:'',
        }
    },
    mounted(){
        this.customerCount();
        this.monthlySell();
        this.todaySell();
        this.todayDue();
    },
    methods:{
        customerCount:function(){
            axios.get('http://127.0.0.1:8000/api/total-customer',{
                headers: {
                    Authorization:  `Bearer ${localStorage.getItem('access_token')}`
                }
            }).then(response => {
                this.total_customer = response.data
            }).catch( error => {
                console.log("error")
            })
        },
        monthlySell:function(){
            axios.get('http://127.0.0.1:8000/api/monthly-sell',{
                headers: {
                    Authorization:  `Bearer ${localStorage.getItem('access_token')}`
                }
            }).then(response => {
                this.monthly_sell = response.data
            }).catch( error => {
                console.log("error")
            })
        },
        todaySell:function(){
            axios.get('http://127.0.0.1:8000/api/today-sell',{
                headers: {
                    Authorization:  `Bearer ${localStorage.getItem('access_token')}`
                }
            }).then(response => {
                this.today_sell = response.data
            }).catch( error => {
                console.log("error")
            })
        },
        todayDue:function(){
            axios.get('http://127.0.0.1:8000/api/today-due',{
                headers: {
                    Authorization:  `Bearer ${localStorage.getItem('access_token')}`
                }
            }).then(response => {
                this.today_due = response.data
            }).catch( error => {
                console.log("error")
            })
        },
    }
}
</script>

<style scoped>

</style>
