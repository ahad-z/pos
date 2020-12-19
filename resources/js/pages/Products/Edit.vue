<template>
<div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Edit Your Product</h3>
                        <router-link to="/product" class="btn btn-primary btn-sm" style="float: right" type="submit">All Product</router-link>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form class="form-horizontal">
                            <div class="card-body">
                                <!-- <div class="form-group row">
                                        <label for="brands" class="col-sm-2 col-form-label">Update Your Product</label>
                                        <div class="col-sm-10">
                                                <input type="text" class="form-control"  id="brands" placeholder="Enter Your Brand name..." v-model="form.categoryName">
                                        </div>
                                </div> -->
                                <div class="form-group">
                                    <label for="product">Product Name</label>
                                    <input type="text" class="form-control" v-model="form.product_name" id="product">
                                </div>
                                <div class="form-group">
                                    <label for="brand_id">Brand Name</label>
                                    <select id="brand_id" class="form-control"   v-model="form.brand_id">
                                        <option value="">---Select Brand--</option>
                                        <option :value="brand.brand_id" v-for="brand in getBrands.data">{{ brand.brand_name }}</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="cat_id">Category Name</label>
                                    <select id="cat_id" class="form-control"   v-model="form.cat_id">
                                        <option value="">---Select Category--</option>
                                        <option :value="cat.cat_id" v-for="cat in getCategories.data">{{ cat.category_name }}</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="unit_id">Unit Name</label>
                                    <select id="unit_id" class="form-control"   v-model="form.unit_id">
                                        <option value="">---Select Unit--</option>
                                        <option :value="unit.unit_id" v-for="unit in getUnits.data">{{ unit.unit }}</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="buying_price">Buying Price</label>
                                    <input type="text" class="form-control" v-model="form.buying_price" id="buying_price">
                                </div>
                                <div class="form-group">
                                    <label for="selling_price">Selling Price</label>
                                    <input type="text" class="form-control" v-model="form.selling_price" id="selling_price">
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-info" @click.prevent="updateProduct()">Update</button>
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
                product_name:'',
                brand_id:'',
                cat_id:'',
                unit_id:'',
                buying_price:'',
                selling_price:''
            },
    	}
    },

    computed:{
         ...mapGetters({
            getBrands : 'allBrands',
            getCategories : 'allCategories',
            getUnits : 'allUnits',
        })
     },

    methods:{
    	showProduct:function(){
    		axios.get(`http://127.0.0.1:8000/api/products/`+ this.$route.params.id, {
    			headers: {
    				Authorization:  `Bearer ${localStorage.getItem('access_token')}`
    			}
    		}).then(response => {
    			this.form.product_name = response.data.Product.product_name
                this.form.brand_id = response.data.Product.brand_id
                this.form.cat_id = response.data.Product.cat_id
                this.form.unit_id = response.data.Product.unit_id
                this.form.buying_price = response.data.Product.buying_price
                this.form.selling_price = response.data.Product.selling_price
    		})
    	},

    	updateProduct: function(){
    		let id = this.$route.params.id
    		let formData = this.form
    		this.$store.dispatch('updateProduct', {id, formData} ).then(response => {
    			if (response.data.status) {
                    toastr.success(response.data.message)
                    this.$router.push('/product')
                }
    		})
    	}
    },
    mounted(){
    	this.showProduct()
        this.$store.dispatch('allCategories')
        this.$store.dispatch('allBrands')
        this.$store.dispatch('allUnits')
    }
}
</script>