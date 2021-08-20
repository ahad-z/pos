<template>
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
        <router-link class="sidebar-brand d-flex align-items-center justify-content-center" to="/dashboard">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-laugh-wink"></i>
            </div>
            <div class="sidebar-brand-text mx-3">DH</div>
        </router-link>
        <hr class="sidebar-divider my-0">
        <li class="nav-item active">
            <router-link class="nav-link" to="/dashboard">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>{{ __t("navigation.dashboard") }}</span></router-link>
        </li>
        <hr class="sidebar-divider">
        <div class="sidebar-heading">
            Interface
        </div>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-tasks"></i>
                <span>{{ __t("navigation.brand") }}</span>
            </a>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Mange Your Brand:</h6>
                    <router-link class="collapse-item" to="/brands" active-class="active">{{ __t("navigation.manage_brand") }}</router-link>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwoCat" aria-expanded="true" aria-controls="collapseTwoCat">
                <i class="fas fa-tasks"></i>
                <span>{{ __t("navigation.category") }}</span>
            </a>
            <div id="collapseTwoCat" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Manage Your Category:</h6>
                    <router-link class="collapse-item" to="/category">{{ __t("navigation.manage_category") }}</router-link>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwoProduct" aria-expanded="true" aria-controls="collapseTwoCat">
                <i class="fas fa-tasks"></i>
                <span>{{ __t("navigation.products") }}</span>
            </a>
            <div id="collapseTwoProduct" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Mange Your Product:</h6>
                    <router-link class="collapse-item" to="/product">{{ __t("navigation.manage_products") }}</router-link>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwoOrder" aria-expanded="true" aria-controls="collapseTwoCat">
                <i class="fas fa-tasks"></i>
                <span>{{ __t("navigation.order") }}</span>
            </a>
            <div id="collapseTwoOrder" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Mange Your Order:</h6>
                    <router-link class="collapse-item" to="/order">{{ __t("navigation.add_order") }}</router-link>
                    <router-link class="collapse-item" to="/invoice">{{ __t("navigation.invoice") }}</router-link>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwoProfits" aria-expanded="true" aria-controls="collapseTwoCat">
                <i class="fas fa-tasks"></i>
                <span>{{ __t("navigation.profits") }}</span>
            </a>
            <div id="collapseTwoProfits" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header"> Your Profits:</h6>
                    <a class="collapse-item" href="#">{{ __t("navigation.profits") }}</a>
                </div>
            </div>
        </li>
         <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUnit" aria-expanded="true" aria-controls="collapseTwoCat">
                <i class="fas fa-tasks"></i>
                <span>{{ __t("navigation.unit") }}</span>
            </a>
            <div id="collapseUnit" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header"> Your Unit:</h6>
                    <router-link class="collapse-item" to="/unit" active-class="active">{{ __t("navigation.unit") }}</router-link>
                </div>
            </div>
        </li> 
         <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseStock" aria-expanded="true" aria-controls="collapseTwoCat">
                <i class="fas fa-tasks"></i>
                <span>{{ __t("navigation.stock") }}</span>
            </a>
            <div id="collapseStock" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header"> Your Stock:</h6>
                    <router-link class="collapse-item" to="/stock" active-class="active">{{ __t("navigation.stock") }}</router-link>
                </div>
            </div>
        </li>  
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseExpense" aria-expanded="true" aria-controls="collapseTwoCat">
                <i class="fas fa-tasks"></i>
                <span>{{ __t("navigation.expense") }}</span>
            </a>
            <div id="collapseExpense" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header"> Your Expense:</h6>
                    <router-link class="collapse-item" to="/expense" active-class="active">{{ __t("navigation.expense") }}</router-link>
                </div>
            </div>
        </li>
         <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCustomer" aria-expanded="true" aria-controls="collapseTwoCat">
                <i class="fas fa-tasks"></i>
                <span>{{ __t("navigation.customer") }}</span>
            </a>
            <div id="collapseCustomer" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header"> Your Customer:</h6>
                    <router-link class="collapse-item" to="/customer" active-class="active">{{ __t("navigation.customer") }}</router-link>
                </div>
            </div>
        </li>
        <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>
    </ul>
</template>

<script>
export default {
name: "Sidebar"
}
</script>

<style scoped>

</style>
