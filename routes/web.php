<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['usermiddleware'])->group(function () {
    Route::get('/home', [UserController::class, 'viewHome']);

    Route::middleware(['adminmiddleware'])->group(function () {
        Route::get('/registerStaff', [UserController::class, 'viewRegisterStaff']);
        Route::post('/createStaff', [UserController::class, 'createStaff']);
    });

    Route::middleware(['managemiddleware'])->group(function () {
        Route::get('/manageProduct', [ProductController::class, 'viewManageProduct']);
        Route::post('/manageProduct', [ProductController::class, 'viewManageProductbyName']);
        Route::post('/manageProduct/create', [ProductController::class, 'createProduct']);
        Route::post('/manageProduct/edit', [ProductController::class, 'editProduct']);
        Route::post('/manageProduct/delete', [ProductController::class, 'deleteProduct']);
        Route::get('/viewCheckout', [TransactionController::class, 'viewCheckout']);
        Route::get('/viewCheckoutDetail/{id}', [TransactionController::class, 'viewCheckoutDetail']);
        Route::post('/viewCheckout/transaction', [TransactionController::class, 'checkoutTransaction']);
        Route::get('/historyCheckout', [TransactionController::class, 'viewHistoryCheckout']);
        Route::get('/historyCheckoutDetail/{id}', [TransactionController::class, 'viewHistoryCheckoutDetail']);
    });

    Route::middleware(['customermiddleware'])->group(function () {
        Route::get('/viewProducts', [TransactionController::class, 'viewProducts']);
        Route::post('/viewProducts', [TransactionController::class, 'viewProductsbyName']);
        Route::post('/viewProducts/addToCart', [TransactionController::class, 'addToCart']);
        Route::get('/viewCart', [TransactionController::class, 'viewCart']);
        Route::post('/viewCart/edit', [TransactionController::class, 'editItemInCart']);
        Route::post('/viewCart/delete', [TransactionController::class, 'removeFromCart']);
        Route::post('/viewCart/finalize', [TransactionController::class, 'finalizeCart']);
        Route::get('/historyTransaction', [TransactionController::class, 'viewHistoryTransaction']);
        Route::get('/historyTransactionDetail/{id}', [TransactionController::class, 'viewHistoryTransactionDetail']);
    });
});

Route::middleware(['postloginmiddleware'])->group(function () {
    Route::get('/', [UserController::class, 'viewLogin']);
    Route::get('/login', [UserController::class, 'viewLogin']);
    Route::post('/login/validate', [UserController::class, 'validateLogin']);
    Route::get('/changePassword', [UserController::class, 'viewChangePassword']);
    Route::post('/changePassword/change', [UserController::class, 'changePassword']);
    Route::get('/register', [UserController::class, 'viewRegister']);
    Route::post('/createAccount', [UserController::class, 'registerCustomer']);
});

Route::get('/logout', [UserController::class, 'logout']);