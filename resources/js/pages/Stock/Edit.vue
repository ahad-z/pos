<template>
<div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Edit Your Stock</h3>
                        <router-link to="/stock" class="btn btn-primary btn-sm" style="float: right" type="submit">All Stock</router-link>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form class="form-horizontal">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="product_id">Products</label>
                                    <select id="product_id" class="form-control"   v-model="form.product_id">
                                        <option value="">---Select Product--</option>
                                        <option :value="product.product_id" v-for="product in getProducts.data">{{ product.product_name }}</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="quantity">Quantity</label>
                                      <input type="text" class="form-control"  id="quantity" placeholder="Enter quantity..." v-model="form.quantity">
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-info" @click.prevent="updateStock()">Update</button>
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
import {mapGetters} from 'vuex';
export default {
    name: "Edit",
    data(){
    	return{
    		form:{
                product_id:'',
    			quantity:''
    		}
    	}
    },

    computed:{
        ...mapGetters({
            getProducts:'allproducts'
        })
    },

    methods:{
    	showStock:function(){
    		axios.get(`http://127.0.0.1:8000/api/stocks/`+ this.$route.params.id, {
    			headers: {
    				Authorization:  `Bearer ${localStorage.getItem('access_token')}`
    			}
    		}).then(response => {
    			this.form.product_id = response.data.Stock.product_id
                this.form.quantity = response.data.Stock.quantity
    		})
    	},

    	updateStock: function(){
    		let id = this.$route.params.id
    		let formData = this.form
    		this.$store.dispatch('updateStock', {id, formData} ).then(response => {
    			if (response.data.status) {
                    toastr.success(response.data.message)
                    this.$router.push('/stock')
                }
    		})
    	}
    },
    mounted(){
    	this.showStock()
        this.$store.dispatch('allProducts')
    }
}
</script>