<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Users\LoginController;
use App\Http\Controllers\Admin\MainController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\MenuController;
use  App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UploadController;
use App\Http\Controllers\Admin\TableController;
use  App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\BillController;
use App\Http\Controllers\Admin\PayController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\CusBillController;
use App\Http\Controllers\CusAccountController;
use App\Http\Controllers\Admin\VoucherController;
use App\Models\Notification;
use App\Http\Controllers\Admin\RevenueController;
use App\Http\Controllers\Admin\AttendanceController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('admin/users/login', [LoginController::class, 'index'])->name('login');
Route::post('admin/users/login/store', [LoginController::class, 'store']);


Route::get('customer/order/{id}',[CustomerController::class,'showMenu']);
Route::post('customer/search/list/',[CustomerController::class,'search']);
Route::post('customer/search/menu/',[CustomerController::class,'searchMenu']);
Route::get('customer/cart/show/{id}',[CustomerController::class,'showCart']);
Route::post('customer/add/cart',[CustomerController::class,'create']);
Route::delete('customer/delete/Cart', [CustomerController::class,'deleteProduct']);
Route::post('customer/update/cart',[CustomerController::class,'update']);
Route::post('customer/create/bill/',[CusBillController::class,'cusCreate']);


Route::get('/customer/login/{id}', [CustomerController::class, 'loginIndex'])->name('login/cus');
Route::post('/cus/store/{id}', [CusAccountController::class, 'store']);
Route::post('/customer/login/store/{id}',[CusAccountController::class,'login']);
Route::get('/customer/call/{id}',[CustomerController::class,'call']);


Route::middleware(['auth.cus'])->group(function () {
    Route::get('/customer/loveList/{id}',[CusAccountController::class,'loveList']);
    Route::get('/customer/discountIndex/{id}',[CustomerController::class,'discountIndex']);
    Route::get('/customer/indexListLove/{id}',[CustomerController::class,'indexListLove']);
    Route::get('/customer/profile/{id}',[CustomerController::class,'showProfile'])->name('profile/cus');
    Route::get('/cus/logout/{id}',[CusAccountController::class , 'logout']);
    Route::post('/customer/updateAcc/{id}',[CusAccountController::class,'update_profile']);
    Route::post('/customer/updatePass/{id}',[CusAccountController::class,'update_password']);
  
});

Route::middleware(['auth'])->group(function () {
    Route::middleware(['checkRole'])->group(function () {
    Route::group(['prefix' => 'admin'], function () { 
        Route::get('/',[MainController::class , 'index'])->name('admin');   
    });
    Route::get('profile', function () {
        $new = Notification::with(['user'])->orderBy('id', 'desc')->take(5)->get();
        $newAll = Notification::with(['user'])->orderBy('id', 'ASC')->get();
        return view('admin.Profile',[
            'title' => 'Thông tin tài khoản',
            'users' => Auth::user(),
            'new' => $new,
            'newAll' => $newAll
        ]);
    })->name('profile');
    Route::post('/updateAcc', [AccountController::class,'update_profile']);
    Route::get('/editAcc/{id}', [AccountController::class,'edit_profile']);
    Route::post('/editStore/{id}', [AccountController::class,'edit_store']);  
    Route::get('/resetPass/{id}', [AccountController::class,'resetPass']);
    Route::get('logout',[AccountController::class , 'logout']);
    Route::get('listAcc',[AccountController::class , 'index'])->name('listAcc');
    Route::post('storeAcc', [AccountController::class,'store']);
    Route::post('updatePass', [AccountController::class,'update_password']);
    Route::delete('deleteAcc/{id}', [AccountController::class,'deleteAcc']); 
    Route::get('searchAcc',[AccountController::class , 'searchAcc']);


    Route::prefix('menus')->group(function () {
        Route::get('add',[MenuController::class,'create']);
        Route::post('add',[MenuController::class,'store']);
        Route::get('list',[MenuController::class,'index'])->name('menus/list');
        Route::delete('destroy',[MenuController::class,'destroy']);
        Route::get('edit/{menu}',[MenuController::class,'show']);
        Route::post('edit/{menu}',[MenuController::class,'update']);
    });

    #Product
    Route::prefix('product')->group(function (){
        Route::get('add',[ProductController::class,'create']);
        Route::post('add',[ProductController::class,'store']);
        Route::get('list',[ProductController::class,'index'])->name('product/list');
        Route::get('destroy/{id}',[ProductController::class,'destroy']);
        Route::get('edit/{id}',[ProductController::class,'show']);
        Route::post('edit/{id}',[ProductController::class,'update']);
    });
    #upload
    Route::post('upload/services',[UploadController::class, 'store']);


    Route::prefix('tables')->group(function (){
        Route::get('list',[TableController::class,'index'])->name('tables/list');
        Route::get('add',[TableController::class,'create']);
        Route::post('add',[TableController::class,'store']);
        Route::get('edit/{id}',[TableController::class,'show']);
        Route::delete('destroy/{id}',[TableController::class,'destroy']);
        Route::post('edit/{id}',[TableController::class,'update']);
    });


    Route::prefix('order')->group(function (){
      
        Route::get('tables/list/',[OrderController::class,'index'])->name('order/tables/list');
        Route::get('bill/list/',[BillController::class,'index'])->name('order/bill/list');
        Route::get('bill/cancle/',[BillController::class,'listBillCancle']);
        Route::get('detailCancle/show/{id}',[BillController::class,'listDetailCancle']);
        Route::post('create/bill/',[BillController::class,'create']);
        Route::get('detail/show/{id}',[BillController::class,'showDetails']);
        Route::post('update/detail',[BillController::class,'updateDetails']);
        Route::post('delete/detail/',[BillController::class,'deleteDetails']);
        Route::post('deleteAll/detail/',[BillController::class,'deleteAllDetails']);
        Route::post('finish/detail',[BillController::class,'finishDetails']);
        Route::post('finish/allDetail',[BillController::class,'finishAllDetails']);
        Route::post('cancle',[BillController::class,'cancleOrder']);
        Route::post('search/list/',[OrderController::class,'search']);
    });

    Route::prefix('pay')->group(function (){
        Route::get('bill/list/',[PayController::class,'index'])->name('bill/list/');
        Route::get('detail/show/{id}',[PayController::class,'showDetails']);
        Route::post('payment',[PayController::class,'payment']);
        Route::get('checkout',[PayController::class,'checkout']);
        Route::get('revenue/list/',[PayController::class,'indexRev'])->name('revenue/list/');
        Route::post('revenue/search/',[PayController::class,'searchRe']);
        Route::get('reDetail/show/{id}',[PayController::class,'showReDetail']);
        Route::post('revenue/exportPdf/',[PayController::class,'exporttoPDF']);
    });
    
       
    Route::prefix('voucher')->group(function (){
        Route::get('add',[VoucherController::class,'index']);
        Route::post('add',[VoucherController::class,'store']);
        Route::get('list',[VoucherController::class,'indexList'])->name('voucher/list');
        Route::get('edit/{id}',[VoucherController::class,'show']);
        Route::delete('destroy/{id}',[VoucherController::class,'destroy']);
        Route::post('edit/{id}',[VoucherController::class,'update']);
        Route::post('check',[VoucherController::class,'check']);
    });
    

    Route::prefix('revenue')->group(function () {
        Route::get('index',[RevenueController::class,'index']);
        Route::post('searchRange',[RevenueController::class,'searchRange']);
        Route::get('indexDay',[RevenueController::class,'indexDay']); 
        Route::post('searchDay',[RevenueController::class,'searchDay']);
      
    });

    
    Route::prefix('customer')->group(function () {
        Route::get('listAcc',[AccountController::class,'cusList']);
        Route::get('upgrade/{id}',[AccountController::class,'upgrade']);
    });


    Route::prefix('attendance')->group(function (){
        Route::get('confirm',[AttendanceController::class,'listConfirm']);
        Route::get('confirmAll',[AttendanceController::class,'confirmAll']);
        Route::get('confirmCheckout',[AttendanceController::class,'listConfirmOut']);
        Route::get('edit/{id}',[AttendanceController::class,'edit']);
        Route::post('edit/{id}',[AttendanceController::class,'editStore']);
        Route::post('checkin',[AttendanceController::class,'checkin']);
        Route::post('checkout',[AttendanceController::class,'checkout']);
        Route::delete('destroy/{id}',[AttendanceController::class,'destroy']);
        Route::get('confirm/{id}',[AttendanceController::class,'confirmStore']);
        Route::get('report',[AttendanceController::class,'reportSalary']);
        Route::post('searchRange',[AttendanceController::class,'searchRange']);
        Route::get('show/{id}',[AttendanceController::class,'showAtt']);
        Route::post('searchRangeShow/{id}',[AttendanceController::class,'searchRangeShow']);
        Route::post('exportPdf/',[AttendanceController::class,'exporttoPDF']);
    });


        Route::get('menu/order/{id}',[OrderController::class,'showMenu']);
        Route::post('add/cart',[OrderController::class,'create']);
        Route::get('cart/show/{id}',[OrderController::class,'showCart']);
        Route::delete('delete/Cart', [OrderController::class,'deleteProduct']);
        Route::post('update/cart',[OrderController::class,'update']);


        Route::get('customer/bill/list/',[CusBillController::class,'index']);
        Route::get('customer/detail/show/{id}',[CusBillController::class,'showDetails']);
        Route::post('confirm/allDetail',[CusBillController::class,'confirmAllDetails']);
        Route::post('update/cusDetail',[CusBillController::class,'updateCusDetails']);
        Route::post('delete/cusDetail/',[CusBillController::class,'deleteCusDetails']);
        Route::post('deleteAll/cusDetail/',[CusBillController::class,'deleteAllCusDetails']);
    });
});

