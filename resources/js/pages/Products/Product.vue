<template>
<div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">All Products</h3>
                        <a class="btn btn-primary btn-sm" style="float: right" href="#modalProduct" data-toggle="modal">Add Products</a>
                    </div>
                    <div class="card-body">
                        <div class="header-counter">
                            {{  selected.length }}
                        </div>
                        <table class="table table-lg table table-hover">
                            <thead>
                                <tr>
                                    <th>
                                        <input :disabled="products.data ==0" type="checkbox" @click="selectAll" v-model="selectedAll">
                                    </th>
                                    <th style="width:50px">sl</th>
                                    <th>Product Name</th>
                                    <th>Brand Name</th>
                                    <th>Category Name</th>
                                    <th>Unit</th>
                                    <th>Quantity</th>
                                    <th>Buying Price</th>
                                    <th>Selling Price</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(product, index) in products.data">
                                    <td><input type="checkbox" :value="product.product_id" v-model="selected"></td>
                                    <td>{{ index+1 }}</td>
                                    <td>{{ product.product_name }}</td>
                                    <td>{{ product.brands.brand_name }}</td>
                                    <td>{{ product.categories.category_name }}</td>
                                    <td>{{ product.units.unit }}</td>
                                    <td>{{ product.stock && product.stock.quantity }}</td>
                                    <td>{{ product.buying_price }}</td>
                                    <td>{{ product.selling_price }}</td>
                                    <td>{{ product.created_at | time  }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <router-link :to="`/edit-product/${product.product_id}`" class="btn btn-info btn-sm">Edit</router-link>
                                            <button type="submit" class="btn btn-danger btn-sm" @click="deleteProduct(product.product_id)">Delete</button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="10">
                                        <div class="dropdown">
                                            <button :disabled="!isSelected" v-if="products.data && products.data.length > 0 " class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown">
                                            Action
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <button  class="dropdown-item" @click="allProductDelete(selected)">DELETE</button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td v-if="products.data == 0" colspan="11" style="text-align: center"><h4 style="color: red;">No Product available</h4></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Add Product  Modal -->
    <div class="modal fade" id="modalProduct">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Create Product</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-group" v-if="error">
                        <div class="form-group">
                            <label for="product">Product Name</label>
                            <input type="text" class="form-control" v-model="form.product_name" id="product">
                            <small style="color: red">{{ error.product_name}}</small>
                        </div>
                        <div class="form-group">
                            <label for="brand_id">Brand Name</label>
                           <select id="brand_id" class="form-control"   v-model="form.brand_id">
                                <option value="" disabled>Select Brand</option>
                                <option :value="brand.brand_id" v-for="brand in getBrands.data">{{ brand.brand_name }}</option>
                            </select>
                            <small style="color: red">{{ error.brand_id}}</small>
                        </div> 
                        <div class="form-group">
                            <label for="cat_id">Category Name</label>
                             <select id="cat_id" class="form-control"   v-model="form.cat_id">
                                <option value="" disabled>Select Category</option>
                                <option :value="cat.cat_id" v-for="cat in getCategories.data">{{ cat.category_name }}</option>
                            </select>
                            <small style="color: red">{{ error.cat_id}}</small>
                        </div> 
                         <div class="form-group">
                            <label for="unit_id">Unit Name</label>
                             <select id="unit_id" class="form-control"   v-model="form.unit_id">
                                <option value="" disabled>Select Unit</option>
                                <option :value="unit.unit_id" v-for="unit in getUnits.data">{{ unit.unit }}</option>
                            </select>
                            <small style="color: red">{{ error.unit_id}}</small>
                        </div>
                        <div class="form-group">
                            <label for="buying_price">Buying Price</label>
                            <input type="text" class="form-control" v-model="form.buying_price" id="buying_price">
                            <small style="color: red">{{ error.buying_price}}</small>
                        </div>
                        <div class="form-group">
                            <label for="selling_price">Selling Price</label>
                            <input type="text" class="form-control" v-model="form.selling_price" id="selling_price">
                            <small style="color: red">{{ error.selling_price}}</small>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" @click.prevent="addProducts()">Add</button>
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
    name: "Product",
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
            error:{},
            selected:[],
            selectedAll:false,
            isSelected:false,
        }
    },
    computed:{
        products(){
            return this.$store.getters.allproducts
        },
          ...mapGetters({
            getBrands: 'allBrands',
            getCategories: 'allCategories',
            getUnits: 'allUnits',
        })
    },
    watch:{
        selected:function(data){
            this.isSelected = (data.length > 0)
            this.selectedAll = (data.length === this.products.data.length )
        }
    },
    methods:{
        allProducts(){
            this.$store.dispatch('allProducts')
        },

        addProducts: function(){
            let formData = this.form
            this.$store.dispatch('addProducts', formData).then( response => {
                if (response.data.status) {
                    toastr.success(response.data.message)
                    this.form  = {}
                    this.error = {}

                    this.allProducts()
                }
                if(!response.data.status) {
                        if( typeof response.data.message === "string"){
                            toastr.error(response.data.message)
                            this.error = {}
                        }
                        if( typeof response.data.message === "object"){
                            let { product_name, brand_id, cat_id, unit_id, buying_price, selling_price} = response.data.message
                            let message = {
                                product_name: product_name ? product_name[0] : '',
                                brand_id: brand_id ? brand_id[0] : '',
                                cat_id: cat_id ? cat_id[0] : '',
                                unit_id: unit_id ? unit_id[0] : '',
                                buying_price: buying_price ? buying_price[0] : '',
                                selling_price: selling_price ? selling_price[0] : '',
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
                this.products.data.forEach( (product) => {
                    this.selected.push(product.product_id)
                })
            }
        },
        deleteProduct:function(id){
             Swal.fire({
                title: 'Are you sure?',
                icon: 'question',
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
                showCancelButton: true,
                showCloseButton: true
            }).then(result => {
                if (result.isConfirmed) {
                    this.$store.dispatch("deleteProduct", id).then( response => {
                        if (response.data.status) {
                            toastr.success(response.data.message)
                            this.allProducts()
                            this.selected = []
                        }else{
                            toastr.error(response.data.message)
                        }
                    });
                }
            })
        },
        allProductDelete:function(id){
             Swal.fire({
                title: 'Are you sure?',
                icon: 'question',
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
                showCancelButton: true,
                showCloseButton: true
            }).then(result => {
                if (result.isConfirmed) {
                    this.$store.dispatch('allProductDelete', id).then( response => {
                        if (response.data.status) {
                            toastr.success(response.data.total + ' ' + response.data.message)
                            this.allProducts()
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
        this.allProducts()
        this.$store.dispatch('allCategories')
        this.$store.dispatch('allBrands')
        this.$store.dispatch('allUnits')
    }
}
    
</script>

<style scoped>
.table thead th {
    font-weight: 800;
    /*color: rgb(89 117 22);*/
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