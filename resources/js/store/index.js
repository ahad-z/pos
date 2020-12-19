import Vuex from "vuex"
import Auth from "./modules/Auth"
import Brand from "./modules/Brand"
import Category from "./modules/Category"
import Units from "./modules/Unit"
import Products from "./modules/Products"
import Stocks from "./modules/Stock"
import Expense from "./modules/Expense"
import Customer from "./modules/Customer"
import Order from "./modules/Order"
import Vue from 'vue'
Vue.use(Vuex)

const store = new Vuex.Store({
    modules: {
        Auth,
        Brand,
        Category,
        Units,
        Products,
        Stocks,
        Expense,
        Customer,
        Order,

    }
})
 export default store;
