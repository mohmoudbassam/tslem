<?php

use App\Http\Controllers\CP\LoginController;
use App\Http\Controllers\CP\NotificationController;
use App\Http\Controllers\CP\ServiceProviders\OrdersController;
use App\Http\Controllers\CP\SystemConfig\SystemConstController;
use App\Http\Controllers\CP\Users\UserController;
use App\Http\Controllers\Designer\DesignerOrderController;
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

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('login', [LoginController::class, 'index'])->name('login_page');
Route::Post('login', [LoginController::class, 'login'])->name('login');

Route::any('logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('dashboard', [LoginController::class, 'dashboard'])->name('dashboard');
    Route::get('edit_profile', [UserController::class, 'edit_profile'])->name('edit_profile');
    Route::get('update_profile', [UserController::class, 'update_profile'])->name('update_profile');
    Route::post('save_profile', [UserController::class, 'save_profile'])->name('save_profile');
    Route::prefix('users')->name('users')->middleware('admin')->group(function () {
        Route::get('users', [UserController::class, 'index']);
        Route::get('add', [UserController::class, 'add'])->name('.add');
        Route::get('form', [UserController::class, 'get_form'])->name('.get_form');
        Route::get('list', [UserController::class, 'list'])->name('.list');
        Route::post('status', [UserController::class, 'status'])->name('.status');
        Route::post('add_edit', [UserController::class, 'add_edit'])->name('.add_edit');
        Route::get('update_from/{user}', [UserController::class, 'update_from'])->name('.update_from');
        Route::post('update', [UserController::class, 'update'])->name('.update');
        Route::post('delete', [UserController::class, 'delete'])->name('.delete');

    });
    Route::prefix('service-providers')->name('services_providers')->middleware('service_provider')->group(function () {
        Route::get('orders', [OrdersController::class, 'orders']);
        Route::get('create_order', [OrdersController::class, 'create_order'])->name('.create_order');
        Route::post('save_order', [OrdersController::class, 'save_order'])->name('.save_order');
        Route::get('list', [OrdersController::class, 'list'])->name('.list');
    });
    Route::prefix('design-office')->name('design_office')->middleware('design_office')->group(function () {
        Route::get('orders', [DesignerOrderController::class, 'orders']);
        Route::get('', [DesignerOrderController::class, 'list'])->name('.list');
    });
    Route::prefix('system-config')->group(function () {
//        Route::get('const', [SystemConstController::class, 'index']);
        Route::prefix('const')->name('const')->group(function () {
            Route::get('', [SystemConstController::class, 'index'])->name('.index');
            Route::get('list', [SystemConstController::class, 'list'])->name('.list');
            Route::get('add', [SystemConstController::class, 'add'])->name('.add');
            Route::get('update_from/{constName}', [SystemConstController::class, 'update_from'])->name('.update_from');
            Route::post('store', [SystemConstController::class, 'store'])->name('.store');
            Route::post('delete', [SystemConstController::class, 'delete'])->name('.delete');
            Route::post('update', [SystemConstController::class, 'update'])->name('.update');
        });
    });

    Route::post('read_message',[NotificationController::class, 'read_message'])->name('read_message');
});
Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
