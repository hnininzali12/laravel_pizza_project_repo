<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ContactController;
use App\Http\Middleware\UserCheckMiddleware;
use App\Http\Middleware\AdminCheckMiddleware;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PizzaController;
use App\Http\Controllers\Admin\UserAccController;
use App\Http\Controllers\Admin\CategoryController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        if(Auth::check()){
            if(Auth::user()->role=='admin'){
                return redirect()->route('admin#profile');
            }
            elseif(Auth::user()->role=='user'){
                return redirect()->route('user#index');
            }
        }
    })->name('dashboard');
});

Route::group(['prefix'=>'admin','namespace'=>'Admin','middleware'=>[AdminCheckMiddleware::class]],function(){
   // Route::get('/',[AdminController::class,'index'])->name('admin#index');
    Route::get('profile',[AdminController::class,'profile'])->name('admin#profile');
    Route::post('updateProfile/{id}',[AdminController::class,'updateProfile'])->name('admin#updateProfile');
    Route::get('changePasswordPage',[AdminController::class,'changePasswordPage'])->name('admin#changePasswordPage');
    Route::post('changePassword/{id}',[AdminController::class,'changePassword'])->name('admin#changePassword');

    Route::get('category',[CategoryController::class,'category'])->name('admin#category');
    Route::get('addCategory',[CategoryController::class,'addCategory'])->name('admin#addCategory');
    Route::post('createCategory',[CategoryController::class,'createCategory'])->name('admin#createCategory');
    Route::get('deleteCategory/{id}',[CategoryController::class,'deleteCategory'])->name('admin#deleteCategory');
    Route::get('updateCategory/{id}',[CategoryController::class,'updateCategory'])->name('admin#updateCategory');
    Route::post('editCategory',[CategoryController::class,'editCategory'])->name('admin#editCategory');
    Route::get('category/search',[CategoryController::class,'searchCategory'])->name('admin#searchCategory');
    Route::get('categoryItem/{id}',[PizzaController::class,'categoryItem'])->name('admin#categoryItem');
    //download csv
    Route::get('categories/download',[CategoryController::class,'categoryListDownload'])->name('admin#categoryListDownload');

    Route::get('pizza',[PizzaController::class,'pizza'])->name('admin#pizza');
    Route::get('createPizza',[PizzaController::class,'createPizza'])->name('admin#createPizza');
    Route::post('insertPizza',[PizzaController::class,'insertPizza'])->name('admin#insertPizza');
    Route::get('deletePizza/{id}',[PizzaController::class,'deletePizza'])->name('admin#deletePizza');
    Route::get('pizzaInfo/{id}',[PizzaController::class,'pizzaInfo'])->name('admin#pizzaInfo');
    Route::get('editPizza/{id}',[PizzaController::class,'editPizza'])->name('admin#editPizza');
    Route::post('updatePizza/{id}',[PizzaController::class,'updatePizza'])->name('admin#updatePizza');
    Route::get('pizza/search',[PizzaController::class,'searchPizza'])->name('admin#searchPizza');
    //download csv
    Route::get('pizza/download',[PizzaController::class,'pizzaListDownload'])->name('admin#pizzaListDownload');

   // Route::get('user',[UserAccController::class,'user'])->name('admin#user');
    Route::get('userList',[UserAccController::class,'userList'])->name('admin#userList');
    //user change role
    Route::get('user/changeRolePage/{id}',[UserAccController::class,'userChangeRolePage'])->name('admin#userChangeRolePage');
    Route::post('user/changeRole/{id}',[UserAccController::class,'userChangeRole'])->name('admin#userChangeRole');
    Route::get('adminList',[UserAccController::class,'adminList'])->name('admin#adminList');
    //admin List edit
    Route::get('adminList/edit/{id}',[UserAccController::class,'adminListEdit'])->name('admin#adminListEdit');
    Route::post('adminList/update/{id}',[UserAccController::class,'adminListUpdate'])->name('admin#adminListUpdate');
    Route::get('user/search',[UserAccController::class,'searchUser'])->name('admin#searchUser');
    Route::get('admin/search',[UserAccController::class,'searchAdmin'])->name('admin#searchAdmin');
    Route::get('delelteUser/{id}',[UserAccController::class,'deleteUser'])->name('admin#deleteUser');
    //csv download
    Route::get('userList/download',[UserAccController::class,'userListDownload'])->name('admin#userListDownload');

    Route::get('contactList',[ContactController::class,'contactList'])->name('admin#contactList');
    //download csv
    Route::get('contactList/download',[ContactController::class,'contactListDownload'])->name('admin#contactListDownload');
    Route::get('contact/search',[ContactController::class,'searchContactList'])->name('admin#searchContactList');

    //order
    Route::get('orderList',[OrderController::class,'orderList'])->name('admin#orderList');
    //download csv
    Route::get('orderList/download',[OrderController::class,'orderListDownload'])->name('admin#orderListDownLoad');
    Route::get('searchOrderList',[OrderController::class,'searchOrderList'])->name('admin#searchOrderList');
});

Route::group(['prefix'=>'user','middleware'=>UserCheckMiddleware::class],function(){
    //user home page
    Route::get('/',[UserController::class,'index'])->name('user#index');
    //user profile page
    Route::get('profile',[UserController::class,'userProfile'])->name('user#userProfile');
    //update profile
    Route::post('profile/update/{id}',[UserController::class,'userProfileUpdate'])->name('user#userProfileUpdate');
    //change password page
    Route::get('changePassword',[UserController::class,'userChangePassword'])->name('user#userChangePassword');
    //update password
    Route::post('changesPassword/{id}',[UserController::class,'updatePassword'])->name('user#updatePassword');


    //pizza detail
    Route::get('pizzaDetails/{id}',[UserController::class,'pizzaDetails'])->name('user#pizzaDetails');
    //pizza order page
    Route::get('pizzaOrder',[UserController::class,'pizzaOrder'])->name('user#pizzaOrder');
    //place order
    Route::post('order',[UserController::class,'placeOrder'])->name('user#placeOrder');

    //search pizza category by clicking
    Route::get('pizza/search/{id}',[UserController::class,'pizzaSearch'])->name('user#pizzaSearch');

    //pizza search item with search bar
    Route::get('pizza/searchItem',[UserController::class,'searchPizzaItem'])->name('user#searchPizzaItem');

    //pizza search with price and time
    Route::get('pizza/search',[UserController::class,'searchItem'])->name('user#searchItem');

    //contact
    Route::post('contact', [ContactController::class,'createContact'])->name('user#createContact');
});
