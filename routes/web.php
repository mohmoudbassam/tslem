<?php

use App\Http\Controllers\CP\Contractor\ContractorController;

use App\Http\Controllers\CP\ConsultingOffice\ConsultingOfficeController;
use App\Http\Controllers\CP\TaslemMaintenance\TaslemMaintenance;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\CP\Delivery\DeliveryController;
use App\Http\Controllers\CP\LoginController;
use App\Http\Controllers\CP\NewsController;
use App\Http\Controllers\CP\NotificationController;
use App\Http\Controllers\CP\RegisterController;
use App\Http\Controllers\CP\SystemConfig\SpecialtiesController;
use App\Http\Controllers\CP\VerificationController;
use App\Http\Controllers\CP\ServiceProviders\OrdersController;
use App\Http\Controllers\CP\Sharer\SharerController;
use App\Http\Controllers\CP\SystemConfig\ServicesController;
use App\Http\Controllers\CP\SystemConfig\SystemConstController;
use App\Http\Controllers\CP\Users\UserController;
use App\Http\Controllers\CP\Designer\DesignerOrderController;
use App\Http\Controllers\CP\Users\UserRequestController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use UniSharp\LaravelFilemanager\Controllers\LfmController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\CP\RaftCompany\RaftCompanyController;
use App\Http\Controllers\CP\RaftCenter\RaftCenterController;

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


Route::get('/', [SiteController::class, 'getHome'])->name('public');
Route::get('guide/{guideType}', [SiteController::class, 'getGuide'])->name('guide');

Route::get('login', [LoginController::class, 'index'])->name('login_page');
Route::Post('login', [LoginController::class, 'login'])->name('login');

Route::get('register/{type?}/{designer_type?}', [RegisterController::class, 'index'])->name('register');
Route::post('regester_action', [RegisterController::class, 'add_edit'])->name('register_action');

Route::any('logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('verify', [VerificationController::class, 'verify'])
        ->middleware(["is-unverified"])
        ->name('verify');
    Route::get('account/verify/{token}', [VerificationController::class, 'verify_account'])
        ->middleware(["is-unverified"])
        ->name('user.verify');
    Route::get('upload_files', [VerificationController::class, 'upload_files'])->name('upload_files');
    Route::post('upload_files', [VerificationController::class, 'save_upload_files'])->name('upload_files_action');
    Route::get('dashboard', [LoginController::class, 'dashboard'])->name('dashboard');
});


//,'is-verified'
Route::middleware(['auth', 'is-file-uploaded'])->group(function () {

    Route::get('edit_profile', [UserController::class, 'edit_profile'])->name('edit_profile');
    Route::post('save_profile', [UserController::class, 'save_profile'])->name('save_profile');
    Route::post('after_reject', [UserController::class, 'after_reject'])->name('after_reject');
    Route::get('notifications', [NotificationController::class, 'notifications'])->name('notifications');

    Route::prefix('users')->name('users')->middleware('admin')->group(function () {
        Route::get('users', [UserController::class, 'index']);
        Route::get('add', [UserController::class, 'add'])->name('.add');
        Route::get('form', [UserController::class, 'get_form'])->name('.get_form');
        Route::get('list', [UserController::class, 'list'])->name('.list');

        Route::get('{user}/files', [UserController::class, 'get_user_files'])->name('.get_files');
        Route::get('{user}/design/types', [UserController::class, 'get_design_types'])->name('.get_user_design_types');

        Route::post('status', [UserController::class, 'status'])->name('.status');
        Route::post('add_edit', [UserController::class, 'add_edit'])->name('.add_edit');
        Route::get('update_from/{user}', [UserController::class, 'update_from'])->name('.update_from');
        Route::get('change_password/{user}', [UserController::class, 'change_password_form'])->name('.change_password_form');
        Route::post('change_password', [UserController::class, 'change_password'])->name('.change_password');

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
        Route::get('orders', [OrdersController::class, 'orders'])->name('.orders');
        Route::middleware(["is-verified"])
        ->group(function () {
            Route::get('create_order', [OrdersController::class, 'create_order'])->name('.create_order');
            Route::get('edit_order/{order}', [OrdersController::class, 'edit_order'])->name('.edit_order');
            Route::post('update_order', [OrdersController::class, 'update_order'])->name('.update_order');
            Route::post('save_order', [OrdersController::class, 'save_order'])->name('.save_order');
            Route::get('show_appointment', [OrdersController::class, 'show_appointment'])->name('.show_appointment');
            Route::get('show_main_files', [OrdersController::class, 'show_main_files'])->name('.show_main_files');
        });
        Route::get('list', [OrdersController::class, 'list'])->name('.list');
        Route::get('add_constructor_form/{order}', [OrdersController::class, 'add_constructor_form'])->name('.add_constructor_form');
        Route::post('choice_constructor_action', [OrdersController::class, 'choice_constructor_action'])->name('.choice_constructor_action');
    });
    Route::prefix('design-office')->name('design_office')->middleware(['design_office'])->group(function () {
        Route::get('orders', [DesignerOrderController::class, 'orders'])->name('.orders');
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
        Route::get('accept/{order}', [DesignerOrderController::class, 'accept'])->name('.accept');
        Route::post('reject/{order}', [DesignerOrderController::class, 'reject'])->name('.reject');
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
        Route::get('reject_form', [DeliveryController::class, 'reject_form'])->name('.reject_form');
        Route::post('accept', [DeliveryController::class, 'accept'])->name('.accept');
        Route::post('reject', [DeliveryController::class, 'reject'])->name('.reject');
        Route::get('view_file/{order}', [DeliveryController::class, 'view_file'])->name('.view_file');
        Route::get('/reports/add', [DeliveryController::class, 'add_report_page'])->name('.report_add_form');
        Route::post('copy_note', [DeliveryController::class, 'copy_note'])->name('.copy_note');
    });
    Route::prefix('contractor')->name('contractor')->middleware(['contractor'])->group(function () {
        Route::get('orders', [ContractorController::class, 'orders'])->name('.orders');
        Route::middleware(["verifiedUser"])
            ->group(function () {
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

                Route::get('order-details/{order}', [ContractorController::class, 'order_details'])->name('.order_details');
                Route::get('/{order}/list', [ContractorController::class, 'list_orders'])->name('.list_orders');
                Route::get('download/{id}', [ContractorController::class, 'download'])->name('.download');
                Route::get('accept_order/{order}', [ContractorController::class, 'accept_order'])->name('.accept_order');
                Route::get('reject_order/{order}', [ContractorController::class, 'reject_order'])->name('.reject_order');
            });
    });
    Route::prefix('consulting-office')->name('consulting_office')->middleware(['consulting_office', 'verifiedUser'])->group(function () {
        Route::get('orders', [ConsultingOfficeController::class, 'orders']);
        Route::get('', [ConsultingOfficeController::class, 'list'])->name('.list');
        Route::get('/{order}/reports', [ConsultingOfficeController::class, 'reports_view'])->name('.reports_view');
        Route::get('/{order}/reports/list', [ConsultingOfficeController::class, 'reports_list'])->name('.reports_list');
        Route::get('/reports/edit/{report}', [ConsultingOfficeController::class, 'edit_report_page'])->name('.report_edit_form');
        Route::get('add-report', [ConsultingOfficeController::class, 'add_report_page'])->name('.report_add_form');
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

        Route::get('/reports', [ConsultingOfficeController::class, 'reports'])->name('.reports');
        Route::get('/reports/list', [ConsultingOfficeController::class, 'reports_all_list'])->name('.reports_all_list');
        Route::get('/{order}/report-details', [ConsultingOfficeController::class, 'reports_view_details'])->name('.reports_view_details');
        Route::get('/{order}/contractor-reports/list', [ConsultingOfficeController::class, 'contractor_list'])->name('.contractor_list');
        Route::post('complete', [ConsultingOfficeController::class, 'complete'])->name('.complete');
        Route::get('accept_order/{order}', [ConsultingOfficeController::class, 'accept_order'])->name('.accept_order');
        Route::get('reject_order/{order}', [ConsultingOfficeController::class, 'reject_order'])->name('.reject_order');

    });
    Route::prefix('Sharer')->name('Sharer')->middleware(['sharer'])->group(function () {
        Route::get('orders', [SharerController::class, 'orders'])->name('.order');
        Route::get('', [SharerController::class, 'list'])->name('.list');
        Route::get('reject_form', [SharerController::class, 'reject_form'])->name('.reject_form');
        Route::post('accept', [SharerController::class, 'accept'])->name('.accept');
        Route::post('reject', [SharerController::class, 'reject'])->name('.reject');
        Route::get('view_file/{order}', [SharerController::class, 'view_file'])->name('.view_file');
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
        Route::prefix('specialties')->name('specialties')->group(function () {
            Route::get('', [SpecialtiesController::class, 'index'])->name('.index');
            Route::get('list', [SpecialtiesController::class, 'list'])->name('.list');
            Route::get('add', [SpecialtiesController::class, 'add'])->name('.add');
            Route::get('update_from/{specialties}', [SpecialtiesController::class, 'update_from'])->name('.update_from');
            Route::post('store', [SpecialtiesController::class, 'store'])->name('.store');
            Route::post('delete', [SpecialtiesController::class, 'delete'])->name('.delete');
            Route::post('update', [SpecialtiesController::class, 'update'])->name('.update');
        });
        Route::prefix('news')->name('news')->group(function () {
            Route::get('', [NewsController::class, 'index']);
            Route::get('list', [NewsController::class, 'list'])->name('.list');
            Route::get('form/{news?}', [NewsController::class, 'form'])->name('.form');
            Route::post('form/{news?}', [NewsController::class, 'add_edit'])->name('.add_edit');
            Route::post('delete', [NewsController::class, 'delete'])->name('.delete');
        });
    });
    Route::prefix('raft_company')->name('raft_company')->middleware(['raft_company'])->group(function () {
        Route::get('', [RaftCompanyController::class, 'index']);
        Route::get('list', [RaftCompanyController::class, 'list'])->name('.list');
        Route::get('center/add', [RaftCompanyController::class, 'add_center'])->name('.add_center');
        Route::post('center/save_center', [RaftCompanyController::class, 'save_center'])->name('.save_center');

    });

    Route::prefix('raft_center')->name('raft_center')->middleware(['raft_center'])->group(function () {
        Route::get('', [RaftCenterController::class, 'index']);
    });


    Route::post('read_message', [NotificationController::class, 'read_message'])->name('read_message');
});

 Route::prefix('taslem_maintenance')->name('taslem_maintenance')->middleware(['auth'])->group(function () {
    Route::get('', [TaslemMaintenance::class, 'index'])->name('.index');
    Route::prefix('sessions')->name(".sessions")->group(function () {
        Route::get('/list', [TaslemMaintenance::class, 'list'])->name('.list');
        Route::get('/users_list', [TaslemMaintenance::class, 'users_list'])->name('.users_list');
        Route::get('/add', [TaslemMaintenance::class, 'add_session_form'])->name('.add_form');
        Route::post('/save', [TaslemMaintenance::class, 'save_session'])->name('.save');

    });
     Route::get('/add_files/{service_provider_id}', [TaslemMaintenance::class, 'add_files'])->name('.add_files');
     Route::post('/upload_file/{service_provider_id}/{type}', [TaslemMaintenance::class, 'upload_file'])->name('.upload_file');
     Route::post('/save_note', [TaslemMaintenance::class, 'save_note'])->name('.save_note');
    Route::get('list', [RaftCompanyController::class, 'list'])->name('.list');
    Route::get('center/add', [RaftCompanyController::class, 'add_center'])->name('.add_center');
    Route::post('center/save_center', [RaftCompanyController::class, 'save_center'])->name('.save_center');

});
//Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth','order_id_middleware']], function () {
//    \UniSharp\LaravelFilemanager\Lfm::routes();
//});

Route::get('test', function () {
    return view('fm');
});

Route::get('generate', [PDFController::class, 'generate']);
Route::get('test-email', function () {
    Mail::send('mail', ['name', 'Ripon Uddin Arman'], function ($message) {
        $message->to('test@tsleem.com.sa', 'Tutorials Point')->subject('Laravel Testing Mail with Attachment');
    });
});



