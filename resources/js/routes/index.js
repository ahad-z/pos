import  AuthLogin from "../Component/Auth/AuthLogin"
import Registration from "../Component/Auth/AuthRegistration"
import ForgetPassword from "../Component/Auth/ForegtPassword"
import UpdatePassword  from"../Component/Auth/UpdatePass"



import NotFound from "../pages/NotFound"
import Dashboard from "../pages/Dashboard"

import  Brand from  "../pages/Brand/Brand"
import  Edit from  "../pages/Brand/Edit"

import  Category from  "../pages/Category/Category"
import  EditCategory from  "../pages/Category/Edit"

import  Unit from  "../pages/Unit/Unit"
import  EditUnit from  "../pages/Unit/Edit"

import  Product from  "../pages/Products/Product"
import  EditProduct from  "../pages/Products/Edit"

import  Stock from  "../pages/Stock/Stock"
import  EditStock from  "../pages/Stock/Edit"

import  Expense from  "../pages/Expenses/Expenses"
import  EditExpense from  "../pages/Expenses/Edit"

import  Order from  "../pages/Order/Orders"
import  Invoiec from  "../pages/Order/invoice"
import EditOrder from "../pages/Order/orderEdit"


import Customer from "../pages/Customer/Customer"
import EditCustomer from "../pages/Customer/Edit"
import CustomerOrderHistory from "../pages/Customer/customerOrderHistory"
import CustomerPaymentHistory from "../pages/Customer/customerPaymentHistorey"











export default [
    { path: '*', component: NotFound,  meta: {layout: 'ErrorLayout'} },
    { path: '/', component: AuthLogin, meta: {layout: 'AuthLayout', requiresVisitor:true } },
    { path: '/register', component: Registration, meta: {layout: 'AuthLayout'} },
    { path: '/forgot-password', component: ForgetPassword, meta: {layout: 'AuthLayout'} },
    { path: '/update-password', component: UpdatePassword, meta: {layout: 'AuthLayout'} },

    { path: '/dashboard', component: Dashboard, meta:{ requiresAuth: true } },

    { path: '/brands', component: Brand, meta:{ requiresAuth: true } },
    { path: '/edit/:id', component: Edit, meta:{ requiresAuth: true } },

    { path: '/category', component: Category, meta:{ requiresAuth: true } },
    { path: '/edit-category/:id', component: EditCategory, meta:{ requiresAuth: true } },

    { path: '/unit', component: Unit, meta:{ requiresAuth: true } },
    { path: '/edit-unit/:id', component: EditUnit, meta:{ requiresAuth: true } },

    { path: '/product', component: Product, meta:{ requiresAuth: true } },
    { path: '/edit-product/:id', component: EditProduct, meta:{ requiresAuth: true } },

    { path: '/stock', component: Stock, meta:{ requiresAuth: true } },
    { path: '/edit-stock/:id', component: EditStock, meta:{ requiresAuth: true } },

    { path: '/expense', component: Expense, meta:{ requiresAuth: true } },
    { path: '/edit-expense/:id', component: EditExpense, meta:{ requiresAuth: true } },

    { path: '/order', component: Order, meta:{ requiresAuth: true } },
    { path: '/invoice', component:Invoiec , meta:{ requiresAuth: true} },
    { path: '/edit-order/:id', component:EditOrder , meta:{ requiresAuth: true} },

    { path: '/customer', component:Customer , meta:{ requiresAuth: true } },
    { path: '/edit-customer/:id', component:EditCustomer , meta:{ requiresAuth: true } },

    { path: '/order-summary/:id', component:CustomerOrderHistory , meta:{ requiresAuth: true } },
    { path: '/payment-summary/:id', component:CustomerPaymentHistory , meta:{ requiresAuth: true } },





]

