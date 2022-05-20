<?php

use App\Http\Controllers\CP\Contractor\ContractorController;

use App\Http\Controllers\CP\ConsultingOffice\ConsultingOfficeController;

use App\Http\Controllers\CP\Delivery\DeliveryController;
use App\Http\Controllers\CP\LoginController;
use App\Http\Controllers\CP\NotificationController;
use App\Http\Controllers\CP\RegisterController;
use App\Http\Controllers\CP\ServiceProviders\OrdersController;
use App\Http\Controllers\CP\SystemConfig\ServicesController;
use App\Http\Controllers\CP\SystemConfig\SystemConstController;
use App\Http\Controllers\CP\Users\UserController;
use App\Http\Controllers\CP\Designer\DesignerOrderController;
use App\Http\Controllers\CP\Users\UserRequestController;
use Illuminate\Support\Facades\Route;
use UniSharp\LaravelFilemanager\Controllers\LfmController;

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
    return view("public");
})->name('public');

Route::get('login', [LoginController::class, 'index'])->name('login_page');
Route::Post('login', [LoginController::class, 'login'])->name('login');

Route::get('register', [RegisterController::class, 'index'])->name('register');
Route::post('regester_action', [RegisterController::class, 'add_edit'])->name('register_action');

Route::any('logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('dashboard', [LoginController::class, 'dashboard'])->name('dashboard');
    Route::get('edit_profile', [UserController::class, 'edit_profile'])->name('edit_profile');
    Route::post('save_profile', [UserController::class, 'save_profile'])->name('save_profile');
    Route::post('after_reject', [UserController::class, 'after_reject'])->name('after_reject');
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
        Route::prefix('request')->name('.request')->group(function () {
            Route::get('', [UserRequestController::class, 'index']);
            Route::get('list', [UserRequestController::class, 'list'])->name('.list');
            Route::get('show', [UserRequestController::class, 'show'])->name('.show');
            Route::get('show/{user}', [UserRequestController::class, 'show'])->name('.show');
            Route::post('accept', [UserRequestController::class, 'accept'])->name('.accept');
            Route::get('reject_form', [UserRequestController::class, 'reject_form'])->name('.reject_form');
            Route::post('reject', [UserRequestController::class, 'reject'])->name('.reject');
        });
    });
    Route::prefix('service-providers')->name('services_providers')->middleware(['service_provider'])->group(function () {
        Route::get('orders', [OrdersController::class, 'orders']);
        Route::get('create_order', [OrdersController::class, 'create_order'])->name('.create_order');
        Route::post('save_order', [OrdersController::class, 'save_order'])->name('.save_order');
        Route::get('list', [OrdersController::class, 'list'])->name('.list');
    });
    Route::prefix('design-office')->name('design_office')->middleware(['design_office'])->group(function () {
        Route::get('orders', [DesignerOrderController::class, 'orders']);
        Route::get('', [DesignerOrderController::class, 'list'])->name('.list');
        Route::get('add-files/{order}', [DesignerOrderController::class, 'add_files'])->name('.add_files');
        Route::post('save_file', [DesignerOrderController::class, 'save_file'])->name('.save_file');
        Route::get('edit_files/{order}', [DesignerOrderController::class, 'edit_files'])->name('.edit_files');
        Route::get('get_service_by_id/{id}', [DesignerOrderController::class, 'get_service_by_id'])->name('.get_service_by_id');
        Route::get('view_file/{order}', [DesignerOrderController::class, 'view_file'])->name('.view_file');
        Route::get('download/{id}', [DesignerOrderController::class, 'download'])->name('.download');

        Route::get('delete_service/{service}', [DesignerOrderController::class, 'delete_service'])->name('.delete_service');
        Route::get('delete_file/{file}', [DesignerOrderController::class, 'delete_file'])->name('.delete_file');
        Route::post('edit_file_action', [DesignerOrderController::class, 'edit_file_action'])->name('.edit_file_action');
        Route::post('accept', [DesignerOrderController::class, 'accept'])->name('.accept');

//        Route::post('accept', [DesignerOrderController::class, 'accept'])->name('.accept');

        Route::post('reject', [DesignerOrderController::class, 'reject'])->name('.reject');
    });
    Route::prefix('delivery')->name('delivery')->middleware(['delivery'])->group(function () {
        Route::get('orders', [DeliveryController::class, 'orders']);
        Route::get('', [DeliveryController::class, 'list'])->name('.list');
        Route::get('/{order}/reports', [DeliveryController::class, 'reports_view'])->name('.reports_view');
        Route::get('/reports', [DeliveryController::class, 'reports'])->name('.reports');
        
        Route::get('/{order}/reports/list', [DeliveryController::class, 'reports_list'])->name('.reports_list');
        Route::get('/reports/list', [DeliveryController::class, 'reports_list_all'])->name('.reports_list_all');
        Route::get('/reports/edit/{report}', [DeliveryController::class, 'edit_report_page'])->name('.report_edit_form');
        //Route::get('/{order}/add', [DeliveryController::class, 'add_report_page'])->name('.report_add_form');
        Route::post('/delete_report', [DeliveryController::class, 'delete_report'])->name('.delete_report');
        Route::post('/delete_file/{attchment}', [DeliveryController::class, 'delete_file'])->name('.delete_file');
        Route::post('edit_report', [DeliveryController::class, 'edit_report'])->name('.edit_report');
        Route::post('add_report', [DeliveryController::class, 'add_report'])->name('.add_report');
        Route::get('view_contractor_report/{order_id}', [DeliveryController::class, 'view_contractor_report'])->name('.view_contractor_report');
        Route::get('contractor_report_list/{order}', [DeliveryController::class, 'contractor_report_list'])->name('.contractor_report_list');
        Route::get('accept_form', [DeliveryController::class, 'accept_form'])->name('.accept_form');
        Route::post('accept', [DeliveryController::class, 'accept'])->name('.accept');
        Route::post('reject', [DeliveryController::class, 'reject'])->name('.reject');
        Route::get('view_file/{order}', [DeliveryController::class, 'view_file'])->name('.view_file');

        Route::get('/reports/add', [DeliveryController::class, 'add_report_page'])->name('.report_add_form');
    });

    Route::prefix('contractor')->name('contractor')->middleware(['contractor', 'verifiedUser'])->group(function () {
        Route::get('orders', [ContractorController::class, 'orders']);
        Route::get('', [ContractorController::class, 'list'])->name('.list');
        Route::get('add_report/{order}', [ContractorController::class, 'add_report_from'])->name('.add_report_form');
        Route::post('add_report', [ContractorController::class, 'add_edit_report'])->name('.add_edit_report');
        Route::get('show_reports/{order}', [ContractorController::class, 'show_reports'])->name('.show_reports');
        Route::get('report_list/{order}', [ContractorController::class, 'report_list'])->name('.report_list');
        Route::get('edit_report_form/{report}', [ContractorController::class, 'edit_report_form'])->name('.edit_report_form');
        Route::post('update_report', [ContractorController::class, 'update_report'])->name('.update_report');
        Route::post('delete_report', [ContractorController::class, 'delete_report'])->name('.delete_report');
        Route::post('delete_file/{file}', [ContractorController::class, 'delete_file'])->name('.delete_file');
        Route::get('show_comments/{report}', [ContractorController::class, 'show_comments'])->name('.show_comments');
        Route::post('save_comment', [ContractorController::class, 'save_comment'])->name('.save_comment');

    });
    Route::prefix('consulting-office')->name('consulting_office')->middleware(['consulting_office', 'verifiedUser'])->group(function () {
        Route::get('orders', [ConsultingOfficeController::class, 'orders']);
        Route::get('', [ConsultingOfficeController::class, 'list'])->name('.list');
        Route::get('/{order}/reports', [ConsultingOfficeController::class, 'reports_view'])->name('.reports_view');
        Route::get('/{order}/reports/list', [ConsultingOfficeController::class, 'reports_list'])->name('.reports_list');
        Route::get('/reports/edit/{report}', [ConsultingOfficeController::class, 'edit_report_page'])->name('.report_edit_form');
        Route::get('/{order}/add', [ConsultingOfficeController::class, 'add_report_page'])->name('.report_add_form');
        Route::get('accept_form', [ConsultingOfficeController::class, 'accept_form'])->name('.accept_form');
        Route::post('accept', [ConsultingOfficeController::class, 'accept'])->name('.accept');
        Route::post('reject', [ConsultingOfficeController::class, 'reject'])->name('.reject');
        Route::post('delete_report', [ConsultingOfficeController::class, 'delete_report'])->name('.delete_report');
        Route::post('/delete_file/{attchment}', [ConsultingOfficeController::class, 'delete_file'])->name('.delete_file');
        Route::post('edit_report', [ConsultingOfficeController::class, 'edit_report'])->name('.edit_report');
        Route::post('add_report', [ConsultingOfficeController::class, 'add_report'])->name('.add_report');
        Route::get('view_contractor_report/{order_id}', [ConsultingOfficeController::class, 'view_contractor_report'])->name('.view_contractor_report');
        Route::get('contractor_report_list/{order}', [ConsultingOfficeController::class, 'contractor_report_list'])->name('.contractor_report_list');
        Route::get('show_comments/{report}', [ConsultingOfficeController::class, 'show_comments'])->name('.show_comments');
        Route::post('save_comment', [ConsultingOfficeController::class, 'save_comment'])->name('.save_comment');
    });
    Route::prefix('system-config')->group(function () {

        Route::prefix('const')->name('const')->group(function () {
            Route::get('', [SystemConstController::class, 'index'])->name('.index');
            Route::get('list', [SystemConstController::class, 'list'])->name('.list');
            Route::get('add', [SystemConstController::class, 'add'])->name('.add');
            Route::get('update_from/{constName}', [SystemConstController::class, 'update_from'])->name('.update_from');
            Route::post('store', [SystemConstController::class, 'store'])->name('.store');
            Route::post('delete', [SystemConstController::class, 'delete'])->name('.delete');
            Route::post('update', [SystemConstController::class, 'update'])->name('.update');
        });
        Route::prefix('service')->name('service')->group(function () {
            Route::get('', [ServicesController::class, 'index'])->name('.index');
            Route::get('list', [ServicesController::class, 'list'])->name('.list');
            Route::get('add', [ServicesController::class, 'add'])->name('.add');
            Route::get('update_from/{service}', [ServicesController::class, 'update_from'])->name('.update_from');
            Route::post('store', [ServicesController::class, 'store'])->name('.store');
            Route::post('delete', [ServicesController::class, 'delete'])->name('.delete');
            Route::post('update', [ServicesController::class, 'update'])->name('.update');
        });
    });

    Route::post('read_message', [NotificationController::class, 'read_message'])->name('read_message');
});
//Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth','order_id_middleware']], function () {
//    \UniSharp\LaravelFilemanager\Lfm::routes();
//});

Route::get('test', function () {
    return view('fm');
});
