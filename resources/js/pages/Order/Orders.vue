<template>
    <div>
        <div class="row center">
            <!-- Create An Order -->
            <div class="col-xl-7 col-lg-7">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Create An Orders</h3>
                        <div class="input-group">
                            <input type="text" class="form-control"  v-on:keyup="getResult()" v-model="searchCustomer" placeholder="Enter Customer phone number for search......">
                            <input class="form-control" type="text" v-model="order.cust_name" placeholder="Enter Pedestrian Name...">
                            <a class="btn btn-primary btn-sm" style="float: right;" href="#modalAddUser" data-toggle="modal">Add Customer</a>
                        </div>
                        <div class="searchPhonNumber">
                         <ul class="list-group" v-for="customer in searResult">
                            <li class="list-group-item" @click="searchHit(customer.cust_phone)">{{ customer.cust_phone }}</li>
                        </ul>
                      </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Sl.</th>
                                    <th>Product Name</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Dsicount</th>
                                    <th>Total</th>
                                    <th><i style="color: red;" class="far fa-trash-alt"></i></th>
                                </tr>
                            </thead>
                            <tr v-for="(product, k) in order.products" :key="k">
                                <td class="form-control text-center">
                                    {{ k+1 }}
                                </td>
                                <td>
                                    <input class="form-control" disabled="" v-model="product.product_name" />
                                </td>
                                <td>
                                    <input readonly="" class="form-control text-right" type="number" min="0" step=".01" v-model="product.product_price" />
                                </td>
                                <td>
                                    <input class="form-control text-right" type="number" min="0" v-model="product.qty" />
                                </td>
                                <td>
                                    <div class="input-group">
                                        <input class="form-control text-right" type="number" min="0" step=".01" v-model="product.discount" />
                                        <select v-model="product.discount_type" class="form-control">
                                            <option value="%">Perchent</option>
                                            <option value="cash">Cash</option>
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <input readonly class="form-control text-right" type="number" min="0" step=".01" :value="productSubTotal(product)" />
                                </td>
                                <td scope="row" class="trashIconContainer" style="margin-left: 10px;">
                                    <i class="far fa-trash-alt" style="color: red;" @click="deleteRow(k)"></i>
                                </td>
                            </tr>
                            <tfoot>
                                <tr>
                                    <td colspan="5" class="text-right">Sub Total</td>
                                    <td class="text-right">{{ subTotal }}</td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right" style="margin-right: 20px;">Discount type</td>
                                    <td class="text-right">
                                        <select class="form-control" v-model="order.discount_type">
                                            <option value="%">Perchentage</option>
                                            <option value="cash">Cash</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right">Amount</td>
                                    <td class="text-right"><input type="number" class="form-control" v-model="order.discount" /></td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right">Total</td>
                                    <td class="text-right">{{ total }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="card-footer">
                       <!--  <button type="button" class="btn btn-info" @click="addOrder">
                           <i class="fas fa-file-invoice-dollar"></i>
                            Make Order
                        </button> -->
                        <button :disabled="order.products==0" class="btn btn-info" style="margin-left: 10px;" href="#modalPayment" data-toggle="modal" @click="checkCustomerInfo()"><i class="fas fa-money-bill"> Add Payment</i></button>
                    </div>
                </div>
            </div>
            <!-- Product List show -->
            <div class="col-xl-5 col-lg-7">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Product List</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="brand">Brand</label>
                            <select id="brand" class="form-control" @change="GetBrandProduct" v-model="filters.brand_id">
                                <option value="" disabled>Select Brand</option>
                                <option :value="brand.brand_id" v-for="brand in getBrands.data">{{ brand.brand_name }}</option>
                            </select> 
                        </div>
                        <div class="form-group">
                            <label for="category">Category</label>
                            <select id="category" class="form-control" @change="getProducts" v-model="filters.cat_id">
                                <option value="" disabled>Select Category</option>
                                <option :value="cat.cat_id" v-for="cat in getCategories.data">{{ cat.category_name }}</option>
                            </select>
                        </div>
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th style="width: 10px;">#</th>
                                    <th>Product Name</th>
                                    <th>Selling Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(product, index) in filterProducts.data">
                                    <td>{{ index+1 }}</td>
                                    <td @click="getProductInfo(product.product_name, product.selling_price, product.product_id)">{{ product.product_name }}</td>
                                    <td>{{ product.selling_price }}</td>
                                </tr>
                                <tr>
                                    <td v-if="!filterProducts.data" colspan="5" style="text-align: center;"><h4 style="color: red">Please select Brand and Category. Or select Category</h4></td>
                                    <td v-if="filterProducts.data == 0" colspan="5" style="text-align: center;"><h4 style="color: red">No products for this Brand</h4></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <h4 class="text-center">Some Action Goes here</h4>
                    </div>
                </div>
            </div>
        </div>
        <!-- Add Customer Modal -->
        <div class="modal fade" id="modalAddUser">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Customer Add</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="form-group">
                            <div class="form-group">
                                <label for="cust_name">Customer Name</label>
                                <input type="text" class="form-control" id="cust_name" v-model="form.cust_name" />
                                <small style="color: red">{{ error.cust_name}}</small>
                            </div>
                            <div class="form-group">
                                <label for="cust_phone">Customer Phone Number</label>
                                <input type="number" class="form-control" id="cust_phone" v-model="form.cust_phone" />
                                <small style="color: red">{{ error.cust_phone}}</small>
                            </div>
                            <div class="form-group">
                                <label for="cust_address">Customer Address</label>
                                <textarea class="form-control" id="cust_address" v-model="form.cust_address"></textarea>
                                <small style="color: red">{{ error.cust_address}}</small>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" @click.prevent="AddCustomer()">Add</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Add Payment Modal -->
        <div class="modal fade" id="modalPayment">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Payment Add</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button>
                    </div>
                    <div class="modal-body">
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
                                <button type="submit" class="btn btn-primary" @click.prevent="addPayment()">Add</button>
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
    name: "Orders",
    data(){
    	return{
        	order: {
                products: [],
                discount: 0,
                discount_type: '%',
                cust_name:'',
                cust_id:'',
                total: 0,
            },
            filters: { 
                cat_id: '',
                brand_id: '',
                query: ''
            },
            filterProducts:{},
            form:{
                cust_name: '',
                cust_phone: '',
                cust_address: '',
            },
            payment:{
                payment_total:'',
                payment_type:''
            },
            error:{},
            searchCustomer: '',
            searResult:[]
    	}
    },
    computed:{
        ...mapGetters({
            getBrands : 'allBrands',
            getCategories : 'allCategories',
            getUnits : 'allUnits',
        }),
        subTotal() {
            let st = 0;

            this.order.products.forEach(p => {
                st += this.productSubTotal(p)
            })

            return st
        },
        total() {
            let st = this.subTotal;

            if(this.order.discount_type === '%'){
                return st - ((st * this.order.discount) / 100);
            }else{
                return st - this.order.discount;
            }
        },
    },

    watch:{

    },

    methods:{
        getResult() {
            /*this.searResult = []*/
            let queryForAllNumber = this.searchCustomer
            let queryLengthChek = this.searchCustomer.length
             if(!queryForAllNumber == '' && queryLengthChek >= 3){
                this.$store.dispatch('allCustomer', {allPhone:queryForAllNumber}).then( response => {
                    if(response.data.data.length){
                       this.searResult = response.data.data
                    }else{
                        this.searResult = null
                        toastr.warning('No customer! Please Add')
                    }
               })
            }else{
                this.searResult = [] 
            }
        },

        searchHit(phone){
            let query = phone
            this.$store.dispatch('allCustomer', {cust_phone:query}).then( response => {
                if(response.data.data.length){
                    this.order.cust_name = response.data.data.[0].cust_name
                    this.order.cust_id = response.data.data.[0].cust_id
                    this.searchCustomer = null
                    this.searResult = []
                }else{
                    toastr.warning('No customer! Please Add')
                }
                
           })
        },

        productSubTotal(product){
            let st = product.product_price * product.qty;

            if(product.discount_type === '%'){
                return st - ((st * product.discount) / 100);
            }else{
                return st - product.discount;
            }
        },
       
        getProductInfo(name,price, id){
            let newItem = {
                product_id: id,
                product_name: name,
                product_price: price,
                qty: 0+1,
                discount: 0,
                sub_total: price,
                discount_type: '%',
            }
            this.order.products.push(newItem)
        },

         GetBrandProduct(){
            let filter = this.filters
            if(filter.cat_id){
                this.getProducts()
            }
        },

        getProducts(){
            let query = this.filters
            this.$store.dispatch('allProducts', query).then(response => {
                this.filterProducts = response.data
            })
        },
        /*Add order before making payment but may be face an error bcz payment Dependecy in backENd*/
       /* addOrder(){

            let orderInfo = {...this.order, total:this.total}

            this.$store.dispatch('addOrder', orderInfo)
        },*/
        
    	AddCustomer(){
            let formData = this.form
            this.$store.dispatch('addCustomer', formData).then( response => {
                if (response.data.status) {
                    toastr.success(response.data.message)
                    this.form= {}
                    this.error={}
                    this.order.cust_id = response.data.customer.cust_id
                    this.order.cust_name = response.data.customer.cust_name  
                }
                if(!response.data.status) {
                    if( typeof response.data.message === "string"){
                        toastr.error(response.data.message)
                        this.error={}
                    }
                    if( typeof response.data.message === "object"){
                        let {cust_name, cust_phone, cust_address } = response.data.message
                        let message = {
                            cust_name: cust_name ? cust_name[0] : '',
                            cust_phone: cust_phone ? cust_phone[0] : '',
                            cust_address: cust_address ? cust_address[0] : '',  
                        };
                        this.error = message
                   }                
                }
            })
        },

        deleteRow(index){
            this.order.products.splice(index, 1)
            this.order.cust_name = null
        },

        loadOnce:function(){
            location.reload();
        },

        addPayment(){
            if( this.payment.payment_type == ''){
                toastr.warning('Please Enter the amount type')
            }else if(this.payment.payment_total == ''){
                toastr.warning('Please Enter amount of Payment')
            }else if(isNaN (this.payment.payment_total)){
                toastr.warning('Please Enter Valid Formate')
            }else{
                let orderInfo = {...this.order, total:this.total, payment:this.payment, subTotal:this.subTotal}
                this.$store.dispatch('addOrder', orderInfo).then(response => {
                    let orderId = response.data.order.order_id
                    window.open("http://127.0.0.1:8000/generate-pdf/"+orderId, "_blank")
                    this.loadOnce()
                })
            }
            
        },

        checkCustomerInfo(){
            if(this.order.cust_name == ''){
                toastr.warning('Customer Name is Required Or Type just Enter Customer');
            }
        }

    },
    mounted(){
    	this.$store.dispatch('allCategories')
        this.$store.dispatch('allBrands')
        this.$store.dispatch('allUnits')
       
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
.searchPhonNumber{
    overflow-y:scroll;
    color: red;
    max-height:300px; 
    width:100%;
}
</style>
