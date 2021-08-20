<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderDetailsController;
use App\Http\Controllers\ReturnProductController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\DashboardController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/login',  [LoginController::class, 'authLogin'])->name('login');
Route::post('/register', [RegisterController::class, 'store']);
Route::get('/forget-pass', [ForgotPasswordController::class, 'authLogin']);
Route::post('/forgot-password',  [ForgotPasswordController::class, 'forgotPassword']);
Route::post('/update-password',  [ForgotPasswordController::class, 'updatePassword']);

Route::get('total-customer', [DashboardController::class, 'customerCount']);

Route::middleware('auth:api')->group(function () {
    Route::post('/log-out',  [LoginController::class, 'authLogOut']);
    Route::resource('brands', BrandController::class);
    Route::post('brands-batch-delete', [BrandController::class, 'batchDelete']);

    Route::resource('categories', CategoryController::class);
    Route::post('categories-all-delete', [CategoryController::class, 'batchDelete']);

    Route::resource('customers', CustomerController::class);
    Route::post('customers-all-delete', [CustomerController::class, 'CustomerallDelete']);

    Route::resource('products', ProductController::class);
    Route::post('products-all-delete', [ProductController::class, 'productsAllDelete']);

    Route::resource('stocks', StockController::class);
    Route::post('stocks-all-delete', [StockController::class, 'allStockDelete']);
    Route::get('get-product/{id}', [StockController::class, 'getProduct']);

    Route::resource('units', UnitController::class);
    Route::post('units-all-delete', [UnitController::class, 'allDelete']);

    Route::resource('expenses', ExpensesController::class);
    Route::post('expenses-all-delete', [ExpensesController::class, 'allExpensesDelete']);

    Route::resource('orders', OrderController::class);
    Route::post('orders-product-delete', [OrderController::class, 'productDelete']);
    Route::post('orders-payment-add', [OrderController::class, 'addPayment']);

    Route::resource('orders-details', OrderDetailsController::class);
    Route::get('return-product-qty/{id}', [OrderDetailsController::class, 'returnProductQty']);

    Route::get('oders-summary/{id}', [CustomerController::class, 'customerOrders']);

    Route::get('payments/{id}', [CustomerController::class, 'getPayments']);
    Route::get('payments-history/{id}', [CustomerController::class, 'getPaymentsHistory']);

    Route::get('total-customer', [DashboardController::class, 'customerCount']);
    Route::get('today-sell', [DashboardController::class, 'todaySell']);
    Route::get('today-due', [DashboardController::class, 'todayDue']);
    Route::get('monthly-sell', [DashboardController::class, 'MonthlySell']);
});
