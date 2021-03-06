<?php

use App\Http\Controllers\CP\ConsultingOffice\ConsultingOfficeController;
use App\Http\Controllers\CP\Contractor\ContractorController;
use App\Http\Controllers\CP\Delivery\DeliveryController;
use App\Http\Controllers\CP\Designer\DesignerOrderController;
use App\Http\Controllers\CP\GeneralController;
use App\Http\Controllers\CP\Kdana\KdanaController;
use App\Http\Controllers\CP\Licenses\LicenseController;
use App\Http\Controllers\CP\LoginController;
use App\Http\Controllers\CP\Media\MediaController;
use App\Http\Controllers\CP\NewsArticles\NewsArticleController;
use App\Http\Controllers\CP\NewsController;
use App\Http\Controllers\CP\NotificationController;
use App\Http\Controllers\CP\OrderLogs\OrderLogsController;
use App\Http\Controllers\CP\RaftCenter\RaftCenterController;
use App\Http\Controllers\CP\RaftCompany\RaftCompanyController;
use App\Http\Controllers\CP\RegisterController;
use App\Http\Controllers\CP\ServiceProviders\OrdersController;
use App\Http\Controllers\CP\Session\SessionController;
use App\Http\Controllers\CP\Sharer\SharerController;
use App\Http\Controllers\CP\SystemConfig\ServicesController;
use App\Http\Controllers\CP\SystemConfig\SpecialtiesController;
use App\Http\Controllers\CP\SystemConfig\SystemConstController;
use App\Http\Controllers\CP\TaslemMaintenance\AppointmentController;
use App\Http\Controllers\CP\TaslemMaintenance\TaslemMaintenance;
use App\Http\Controllers\CP\Users\UserController;
use App\Http\Controllers\CP\Users\UserRequestController;
use App\Http\Controllers\CP\VerificationController;
use App\Http\Controllers\DevelopmentController;
use App\Http\Controllers\ImportExcelController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\SiteController;
use App\Models\Order;
use App\Models\OrderLogs;
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
Route::prefix('fix')->group(function () {
    Route::get('orders/logs', function () {
        $trans = [
            "???? ?????????? ??????????"                                              => "logs.created",
            "???? ???????????? ?????????? ???? ???????? ??????????????"                             => "logs.approved-designer",
            "???? ?????? ?????????? ???? ???????? ??????????????"                                => "logs.rejected-designer",
            "???? ?????? ???????????????? ???? ???????? ??????????????"                             => "logs.rejected-tsleem",
            "???? ?????? ?????????? ???? ???????? ?????????????? ????????"                           => "logs.rejected-designer",
            "??????????????, ???? ???????? ???????? ???? ???????? ??????????????"                       => "logs.approved-designer",
            "???????????????? ???? ???????? ???????? ???? ???????? ??????????????"                       => "logs.approved-designer",
            "???? ???????????? ?????????? ???? ???????? ??????????????"                             => "logs.approved-tsleem",
            "???? ???????????? ?????????? ???? ???????? ?????????? ???????????????? ???????? ???????????? ????????????????" => "logs.approved-tsleem",
            "???? ?????????? ???????????? ?????????? ??????????????????"                             => "logs.filled",
            "???? ?????????? ???????????? ?????????? ???????????????? ?????????????? ???????????? ????????????????"      => "logs.license-ready",
            "???? ???????????? ?????????? ???? ?????????????? ?????????????? ???????????????? ?????????? ????????????"    => "logs.approved-all",
            "???????????? ?????????? ?????????????? ?????????? ???????????????? ?????????????? ???????????? ????????????????" => "logs.license-ready",
            "???????????? ?????????? ??????????????"                                        => "???? ?????????? ???????? ????????????????",
        ];
        $orderTrans = Order::trans("logs");
        $orderFRTrans = Order::trans("final_report_attached_status");
        $orderStatusTrans = Order::getOrderStatuses();
        $logs = OrderLogs::all();
        $newLogs = collect($logs->all())
            ->mapWithKeys(function (OrderLogs $log, $mainKey) use ($trans, $orderTrans, $orderFRTrans, $orderStatusTrans) {
                $data = implode(" ", preg_split("/\s*\#\d+\s*/", $log->data));
                $newKey = $data = trim(str_ireplace("  ", " ", $data));
                $dataValue = null;
                if (!isset($trans[$newKey])) {
                    foreach ($trans as $key => $value) {
                        if (starts_with($newKey, $key)) {
                            $newKey = "{$key}";
                            $dataValue = $value;
                            break;
                        }
                    }

                    if (!$dataValue && !isset($trans[$newKey])) {
                        foreach ($orderFRTrans as $key => $value) {
                            if (starts_with($newKey, $value)) {
                                $newKey = "{$key}";
                                $dataValue = $value;
                                break;
                            }
                        }

                        if (!$dataValue && !isset($orderFRTrans[$newKey])) {
                            foreach ($orderStatusTrans as $key => $value) {
                                if (starts_with($newKey, $value)) {
                                    $newKey = $key;
                                    $dataValue = $value;
                                    break;
                                }
                            }
                        }
                    }

                    if (!$dataValue && !isset($orderFRTrans[$newKey]) && !isset($orderStatusTrans[$newKey])) {
                        if (($dataValue = array_search($newKey, $orderTrans)) === false) {
                            if (($dataValue = array_search($newKey, $orderFRTrans)) === false) {
                                if (($dataValue = array_search($newKey, $orderStatusTrans)) === false) {
                                    dd($log->id, $newKey, $log->data);
                                }
                                $newKey = $dataValue;
                                $dataValue = $orderStatusTrans[$dataValue] ?? $dataValue;
                            }
                            else {
                                $newKey = $dataValue;
                                $dataValue = $orderFRTrans[$dataValue] ?? $dataValue;
                            }
                        }
                        else {
                            $newKey = $dataValue;
                            $dataValue = $orderTrans[$dataValue] ?? $dataValue;
                        }
                    }
                    else {
                        $newKey = "final_report_attached_status.{$newKey}";
                    }
                }

                if (!$dataValue) {
                    if (isset($trans[$newKey])) {
                        $dataValue = Order::trans($trans[$newKey]) ?: $dataValue;
                    }
                    elseif (isset($orderStatusTrans[$newKey])) {
                        $dataValue = Order::trans($orderStatusTrans[$newKey]) ?: $dataValue;
                    }
                    elseif ($newKey) {
                        $dataValue = Order::trans($newKey);
                    }
                }

                if ($dataValue) {
                    $log->data = Order::trans($dataValue);
                }

                return [
                    $mainKey => !($log->originalIsEquivalent('data') ? true : $log->save()),
                ];
            });

        dump(
            "Data Count:",
            $logs
                ->map
                ->refresh()
                ->groupBy('data')
                ->map
                ->count()
                ->all()
        );

        return (($fails = $newLogs->filter()->count()) ? "Fail! {$fails}" : ("Done! ".$newLogs->count()))."/".$logs->count();
    });
});

Route::get('t', function () {
    return resize_old_images(request('name'));
});

Route::get('/', [SiteController::class, 'getHome'])->name('public');
Route::get('guide/{guideType}', [SiteController::class, 'getGuide'])->name('guide');
Route::get('page/{pageSlug}', [SiteController::class, 'getPage'])->name('page');

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
    Route::get('ExportRaftCompanyLocationBar', [LoginController::class, 'exportRaftCompanyLocationBar'])->name('exportRaftCompanyLocationBar');
});

Route::prefix('NewsArticles')
    ->name('NewsArticles')
    ->group(function () {
        Route::get('NewsArticles', [NewsArticleController::class, 'Mainlist'])
            ->name('.Mainlist');
        Route::get('article/{news_article}', [NewsArticleController::class, 'article'])
            ->name('.article');
    });

Route::prefix('Photoes')
    ->name('Photoes')
    ->group(function () {
        Route::get('Photoes', [SiteController::class, 'getPhotos'])
            ->name('.Photoes');
    });

Route::get('delete_img', [MediaController::class, 'delete_img'])->name('delete_img');

Route::prefix('Videos')
    ->name('Videos')
    ->group(function () {
        Route::get('Videos', [SiteController::class, 'getVideos'])
            ->name('.Videos');
    });

//,'is-verified'
Route::middleware(['auth', 'is-file-uploaded'])->group(function () {

    Route::get('edit_profile', [UserController::class, 'edit_profile'])->name('edit_profile');
    Route::post('save_profile', [UserController::class, 'save_profile'])->name('save_profile');
    Route::post('after_reject', [UserController::class, 'after_reject'])->name('after_reject');
    Route::get('notifications', [NotificationController::class, 'notifications'])->name('notifications');

    Route::prefix('media')
        ->name('media')
        ->middleware(['user_type:admin,multi_media'])
        ->group(function () {
            Route::get('', [MediaController::class, 'index']);
            Route::get('list', [MediaController::class, 'list'])->name('.list');
            Route::get('form/{media?}', [MediaController::class, 'form'])->name('.form');
            Route::post('form/{media?}', [MediaController::class, 'add_edit'])->name('.add_edit');
            Route::post('delete', [MediaController::class, 'delete'])->name('.delete');
        });

    Route::prefix('licenses')
        ->name('licenses')
        ->middleware(['user_type:admin'])
        ->group(function () {
            Route::get('add', [LicenseController::class, 'add'])->name('.add');
            Route::post('store', [LicenseController::class, 'store'])->name('.store');
            Route::get('edit/{license}', [LicenseController::class, 'edit'])->name('.edit');
            Route::post('update/{license}', [LicenseController::class, 'update'])->name('.update');
            Route::post('delete/{license}', [LicenseController::class, 'delete'])->name('.delete');
            Route::post('delete_map_path/{license}', [LicenseController::class, 'delete_map_path'])->name('.delete_map_path');
        });

    Route::prefix('order_logs')
        ->name('order_logs')
        ->middleware(['user_type:admin'])
        ->group(function () {
            Route::get('', [OrderLogsController::class, 'index']);
            Route::get('list', [OrderLogsController::class, 'list'])->name('.list');
            Route::get('export', [OrderLogsController::class, 'export'])->name('.export');
        });

    Route::prefix('licenses')
        ->name('licenses')
        ->middleware(['user_type:admin,Delivery'])
        ->group(function () {
            Route::get('', [LicenseController::class, 'index']);
            Route::get('form', [LicenseController::class, 'form'])->name('.form');
            Route::get('list', [LicenseController::class, 'list'])->name('.list');
            Route::get('print/{license}', [LicenseController::class, 'show_print'])->name('.show_print');
            Route::post('print/{license}', [LicenseController::class, 'print'])->name('.print');
            Route::get('order/{order}/form', [LicenseController::class, 'order_license_form'])->name('.order_license_form');
            Route::post('order/{order}/create', [LicenseController::class, 'order_license_create'])->name('.order_license_create');
        });

    Route::prefix('licenses')
        ->name('licenses')
        ->group(function () {
            Route::get('download/{order}/license', [LicenseController::class, 'download'])
                ->name('.download');
            Route::get('view_pdf/{order}/license', [LicenseController::class, 'view_pdf'])
                ->name('.view_pdf');
            Route::get('pdf/{order}/license1', [LicenseController::class, 'pdf1'])
                ->name('.pdf1');
            Route::get('pdf/{order}/license2', [LicenseController::class, 'pdf2'])
                ->name('.pdf2');
            Route::get('pdf/{order}/license', [LicenseController::class, 'pdf'])
                ->name('.pdf');
            Route::get('view_html/{order}/license', [LicenseController::class, 'view_html'])
                ->name('.view_html');

            Route::get('view_pdf/{order}/execution_license', [LicenseController::class, 'view_pdf_execution_license'])
                ->name('.view_pdf_execution_license');

            Route::get('view_final_attachment/{license}/file', [LicenseController::class, 'license_final_attachment_file'])
                ->name('.license_final_attachment_file');

            Route::get('view_map/{license}/file', [LicenseController::class, 'license_map_file'])
                ->name('.license_map_file');

            Route::get('order/{order}/attach-final-report-form', [LicenseController::class, 'order_license_attach_final_report_form'])
                ->name('.attach_final_report_form');
            Route::post('order/{order}/attach-final-report', [LicenseController::class, 'order_license_attach_final_report'])
                ->name('.attach_final_report');

            Route::get('order/{order}/final-report-contractor-approve', [LicenseController::class, 'order_final_report_contractor_approve'])
                ->name('.final_report_contractor_approve');
            Route::get('order/{order}/final-report-consulting-office-approve', [LicenseController::class, 'order_final_report_consulting_office_approve'])
                ->name('.final_report_consulting_office_approve');

            Route::get('order/{order}/final-report-form', [LicenseController::class, 'order_license_final_report_form'])
                ->name('.final_report_form');
            Route::post('order/{order}/final-report', [LicenseController::class, 'order_license_final_report'])
                ->name('.final_report');

            Route::get('order/{order}/reject_form/{type}', [LicenseController::class, 'reject_form'])->name('.reject_form');
            Route::post('order/{order}/reject_form/{type}', [LicenseController::class, 'reject'])->name('.reject');
        });

    Route::prefix('news_articles')
        ->name('news_articles')
        ->middleware(['user_type:admin,multi_media'])
        ->group(function () {
            Route::get('', [NewsArticleController::class, 'index']);
            Route::get('add', [NewsArticleController::class, 'add'])->name('.add');
            Route::get('edit/{news_article}', [NewsArticleController::class, 'edit'])->name('.edit');
            Route::get('form', [NewsArticleController::class, 'form'])->name('.form');
            Route::get('list', [NewsArticleController::class, 'list'])->name('.list');
            Route::post('update/{news_article}', [NewsArticleController::class, 'update'])->name('.update');
            Route::post('delete/{news_article}', [NewsArticleController::class, 'delete'])->name('.delete');
            Route::post('store', [NewsArticleController::class, 'store'])->name('.store');
            Route::post('upload', [NewsArticleController::class, 'upload'])->name('.upload');
            Route::get('toggle_publish/{news_article}', [NewsArticleController::class, 'togglePublish'])->name('.toggle_publish');
        });

    // Route::prefix('NewsArticles')
    //     ->name('NewsArticles')
    //     ->group(function() {
    //         Route::get('NewsArticles', [ NewsArticleController::class, 'Mainlist' ])
    //             ->name('.Mainlist');
    //         Route::get('article/{news_article}', [ NewsArticleController::class, 'article' ])
    //             ->name('.article');
    //     });
    Route::prefix('users')->name('users')->middleware('admin')->group(function () {
        Route::get('users', [UserController::class, 'index']);
        Route::get('add', [UserController::class, 'add'])->name('.add');
        Route::get('form', [UserController::class, 'get_form'])->name('.get_form');
        Route::get('list', [UserController::class, 'list'])->name('.list');
        Route::get('user_export', [UserController::class, 'user_export'])->name('.user_export');

        Route::get('{user}/files', [UserController::class, 'get_user_files'])->name('.get_files');
        Route::get('{user}/design/types', [UserController::class, 'get_design_types'])->name(
            '.get_user_design_types'
        );

        Route::post('status', [UserController::class, 'status'])->name('.status');
        Route::post('add_edit', [UserController::class, 'add_edit'])->name('.add_edit');
        Route::get('update_from/{user}', [UserController::class, 'update_from'])->name('.update_from');
        Route::get('change_password/{user}', [UserController::class, 'change_password_form'])->name(
            '.change_password_form'
        );
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

    Route::prefix('orders')->middleware('admin')->name('orders')->group(function () {
        Route::get('', [\App\Http\Controllers\CP\admin\OrdersController::class, 'index']);
        Route::get('list', [\App\Http\Controllers\CP\admin\OrdersController::class, 'list'])->name('.list');
        Route::get('export', [\App\Http\Controllers\CP\admin\OrdersController::class, 'export'])->name('.export');
    });

    Route::group(['as' => 'Admin.', 'prefix' => 'Admin'], function () {
        Route::group(['as' => 'Order.', 'prefix' => 'Order'], function () {
            // List view
            Route::get('Trashed', [\App\Http\Controllers\CP\admin\OrdersController::class, 'trashedIndex'])->name('trashed');
            // List of datatable
            Route::get('Trashed-List', [\App\Http\Controllers\CP\admin\OrdersController::class, 'trashedList'])->name('trashedList');
            // Soft Delete orders
            Route::get('Soft-Delete', [\App\Http\Controllers\CP\admin\OrdersController::class, 'softDelete'])->name('softDelete');
            // Restore soft deleted order
            Route::get('Restore', [\App\Http\Controllers\CP\admin\OrdersController::class, 'restore'])->name('restore');
        });
    });

    Route::prefix('service-providers')->name('services_providers')->middleware(['service_provider'])->group(
        function () {
            Route::get('orders', [OrdersController::class, 'orders'])->name('.orders');
            Route::middleware(["is-verified"])
                ->group(function () {
                    Route::get('obligations/agree', [UserController::class, 'agree_to_obligation'])->name(
                        '.obligations_agree'
                    );
                    Route::get('edit_order/{order}', [OrdersController::class, 'edit_order'])->name('.edit_order');
                    Route::post('update_order', [OrdersController::class, 'update_order'])->name('.update_order');
                    Route::post('save_order', [OrdersController::class, 'save_order'])->name('.save_order');
                    Route::get('show_appointment', [OrdersController::class, 'show_appointment'])->name(
                        '.show_appointment'
                    );
                    Route::get('show_main_files', [OrdersController::class, 'show_main_files'])->name(
                        '.show_main_files'
                    );
                    Route::get('seen_maintain_file', [OrdersController::class, 'seen_maintain_file'])->name(
                        '.seen_maintain_file'
                    );
                    Route::get('docx_file/{fileType}', [OrdersController::class, 'docx_file'])->name('.docx_file');
                    Route::get('create_order', [OrdersController::class, 'create_order'])->name('.create_order');
                });
            Route::post("update-licence-number", [UserController::class, "update_licence_number"])
                ->name(".update_licence_number");
            Route::get('{user}/design/types', [UserController::class, 'get_design_types'])->name(
                '.get_user_design_types'
            );
            Route::get('list', [OrdersController::class, 'list'])->name('.list');
            Route::get('add_constructor_form/{order}', [OrdersController::class, 'add_constructor_form'])->name(
                '.add_constructor_form'
            );
            Route::post('choice_constructor_action', [OrdersController::class, 'choice_constructor_action'])->name(
                '.choice_constructor_action'
            );
        }
    );

    Route::prefix('design-office')->name('design_office')->group(function () {
        Route::get('download/{id}', [DesignerOrderController::class, 'download'])->name('.download');
    });
    Route::prefix('design-office')->name('design_office')->middleware(['design_office'])->group(function () {
        Route::get('orders', [DesignerOrderController::class, 'orders'])->name('.orders');
        Route::get('order_agreement_form/{order}', [DesignerOrderController::class, 'order_agreement_form'])->name('.order_agreement_form');
        Route::post('order_agreement/{order}', [DesignerOrderController::class, 'order_agreement'])->name('.order_agreement');
        Route::get('', [DesignerOrderController::class, 'list'])->name('.list');
        Route::get('add-files/{order}', [DesignerOrderController::class, 'add_files'])->name('.add_files');
        Route::post('save_file', [DesignerOrderController::class, 'save_file'])->name('.save_file');
        Route::get('edit_files/{order}', [DesignerOrderController::class, 'edit_files'])->name('.edit_files');
        Route::get('get_service_by_id/{id}', [DesignerOrderController::class, 'get_service_by_id'])->name(
            '.get_service_by_id'
        );
        Route::get('view_file/{order}', [DesignerOrderController::class, 'view_file'])->name('.view_file');

        Route::get('service/obligation/files', [DesignerOrderController::class, 'get_service_obligation_files'])
            ->name('.service_obligation_files');

        Route::get('delete_service/{service}', [DesignerOrderController::class, 'delete_service'])->name(
            '.delete_service'
        );
        Route::get('delete_file/{file}', [DesignerOrderController::class, 'delete_file'])->name('.delete_file');
        Route::post('edit_file_action', [DesignerOrderController::class, 'edit_file_action'])->name(
            '.edit_file_action'
        );
        Route::prefix('consulting')->middleware('ConsultingDesigner')->name('.consulting')->group(function () {
            Route::get('orders', [ConsultingOfficeController::class, 'orders'])->name('.orders');
            Route::get('list', [ConsultingOfficeController::class, 'list'])->name('.list');
        });
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
        Route::get('view_contractor_report/{order_id}', [DeliveryController::class, 'view_contractor_report'])->name(
            '.view_contractor_report'
        );
        Route::get('contractor_report_list/{order}', [DeliveryController::class, 'contractor_report_list'])->name(
            '.contractor_report_list'
        );
        Route::get('accept_form', [DeliveryController::class, 'accept_form'])->name('.accept_form');
        Route::get('reject_form', [DeliveryController::class, 'reject_form'])->name('.reject_form');
        Route::post('accept', [DeliveryController::class, 'accept'])->name('.accept');
        Route::post('reject', [DeliveryController::class, 'reject'])->name('.reject');
        Route::get('view_file/{order}', [DeliveryController::class, 'view_file'])->name('.view_file');
        Route::get('/reports/add', [DeliveryController::class, 'add_report_page'])->name('.report_add_form');
        Route::post('copy_note', [DeliveryController::class, 'copy_note'])->name('.copy_note');
        Route::get('export', [DeliveryController::class, 'export'])->name('.export');
    });
    Route::prefix('contractor')->name('contractor')->middleware(['contractor'])->group(function () {
        Route::get('orders', [ContractorController::class, 'orders'])->name('.orders');
        Route::middleware(["verifiedUser"])->group(function () {
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

        Route::post("update_specialty", [ContractorController::class, "update_specialty"])
            ->name(".update_specialty");
    });
    Route::prefix('consulting-office')
        ->name('consulting_office')
        ->middleware(['ConsultingDesigner', 'verifiedUser'])
        ->group(function () {
            Route::get('orders', [ConsultingOfficeController::class, 'orders']);
            Route::get('', [ConsultingOfficeController::class, 'list'])->name('.list');
            Route::get('/{order}/reports', [ConsultingOfficeController::class, 'reports_view'])->name('.reports_view');
            Route::get('/{order}/reports/list', [ConsultingOfficeController::class, 'reports_list'])->name('.reports_list');
            Route::get('/reports/edit/{report}', [ConsultingOfficeController::class, 'edit_report_page'])->name('.report_edit_form');
            Route::get('{order}/add-report', [ConsultingOfficeController::class, 'add_report_page'])->name('.report_add_form');
            Route::get('accept_form', [ConsultingOfficeController::class, 'accept_form'])->name('.accept_form');
            Route::post('accept', [ConsultingOfficeController::class, 'accept'])->name('.accept');
            Route::post('reject', [ConsultingOfficeController::class, 'reject'])->name('.reject');
            Route::post('delete_report', [ConsultingOfficeController::class, 'delete_report'])->name(
                '.delete_report'
            );
            Route::post('/delete_file/{attchment}', [ConsultingOfficeController::class, 'delete_file'])->name(
                '.delete_file'
            );
            Route::post('edit_report', [ConsultingOfficeController::class, 'edit_report'])->name('.edit_report');
            Route::post('{Order}/add_report', [ConsultingOfficeController::class, 'add_report'])->name('.add_report');
            Route::get(
                'view_contractor_report/{order_id}',
                [ConsultingOfficeController::class, 'view_contractor_report']
            )->name('.view_contractor_report');
            Route::get(
                'contractor_report_list/{order}',
                [ConsultingOfficeController::class, 'contractor_report_list']
            )->name('.contractor_report_list');
            Route::get('show_comments/{report}', [ConsultingOfficeController::class, 'show_comments'])->name(
                '.show_comments'
            );
            Route::post('save_comment', [ConsultingOfficeController::class, 'save_comment'])->name('.save_comment');

            Route::get('/reports', [ConsultingOfficeController::class, 'reports'])->name('.reports');
            Route::get('/reports/list', [ConsultingOfficeController::class, 'reports_all_list'])->name(
                '.reports_all_list'
            );
            Route::get('/{order}/report-details', [ConsultingOfficeController::class, 'reports_view_details'])->name(
                '.reports_view_details'
            );
            Route::get('/{order}/contractor-reports/list', [ConsultingOfficeController::class, 'contractor_list'])
                ->name('.contractor_list');
            Route::post('complete', [ConsultingOfficeController::class, 'complete'])->name('.complete');
            Route::get('accept_order/{order}', [ConsultingOfficeController::class, 'accept_order'])->name(
                '.accept_order'
            );
            Route::get('reject_order/{order}', [ConsultingOfficeController::class, 'reject_order'])->name(
                '.reject_order'
            );
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
            Route::get('update_from/{constName}', [SystemConstController::class, 'update_from'])->name(
                '.update_from'
            );
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
            Route::get('update_from/{specialties}', [SpecialtiesController::class, 'update_from'])->name(
                '.update_from'
            );
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
    Route::prefix('raft_company')->name('raft_company')->group(function () {
        Route::middleware(['raft_company'])->group(function () {
            Route::get('', [RaftCompanyController::class, 'index']);
            Route::get('list', [RaftCompanyController::class, 'list'])->name('.list');
            Route::get('centers_list', [RaftCompanyController::class, 'centers_list'])->name('.centers_list');
            Route::get('center/add', [RaftCompanyController::class, 'add_center'])->name('.add_center');
            Route::post('center/save_center', [RaftCompanyController::class, 'save_center'])->name('.save_center');

            Route::get(
                'view_files_and_appointment/{session}',
                [RaftCompanyController::class, 'view_files_and_appointment']
            )->name('.view_files_and_appointment');
            Route::get('docx_file/{fileType}/{session}', [RaftCompanyController::class, 'docx_file'])->name(
                '.docx_file'
            );
            Route::get('view_maintainance_files/{session}', [RaftCompanyController::class, 'view_maintainance_files'])
                ->name('.view_maintainance_files');
            Route::get('seen_maintain_file/{session}', [RaftCompanyController::class, 'seen_maintain_file'])->name(
                '.seen_maintain_file'
            );
        });
        Route::get('get_camp_by_box/{box}', [RaftCompanyController::class, 'get_camp_by_box'])->name('.get_camp_by_box');
    });
    Route::prefix('session')->name('session')->group(function () {
        Route::middleware(['raft_company'])->group(function () {
            Route::get('', [SessionController::class, 'index']);
            Route::get('list', [SessionController::class, 'list'])->name('.list');
            Route::get('add', [SessionController::class, 'add'])->name('.add');
            Route::post('save', [SessionController::class, 'save'])->name('.save');
        });
        Route::get('get_camp_by_box/{box}',[SessionController::class, 'get_camp_by_box'])->name('.get_camp_by_box');
    });
    Route::post('read_message', [NotificationController::class, 'read_message'])->name('read_message');
});
Route::prefix('raft_center')->name('raft_center')->middleware(['raft_center'])->group(function () {
    Route::get('', [RaftCenterController::class, 'index']);
});
Route::prefix('obligation')->name('obligation')->group(function () {
    Route::get('download/{id}', [DeliveryController::class, 'download_obligation'])->name('.download');
});
Route::prefix('order_speciality_file')->name('order_speciality_file')->group(function () {
    Route::get('download/{id}', [DeliveryController::class, 'download_speciality_file'])->name('.download');
});
Route::group([
    'prefix' => 'Appointment',
    'as'     => '.Appointment.',
], function () {
    Route::get('GeneratePdf/{User}', [AppointmentController::class, 'generatePdf'])->name('generatePdf');
});
Route::prefix('taslem_maintenance')->name('taslem_maintenance')->middleware(['auth'])->group(function () {
    Route::get('', [TaslemMaintenance::class, 'index'])->name('.index');
    Route::prefix('sessions')->name(".sessions")->group(function () {
        Route::get('/list/{list_type}', [TaslemMaintenance::class, 'list'])->name('.list');
        Route::get('/sessions_list', [TaslemMaintenance::class, 'sessions_list'])->name('.sessions_list');
        Route::get('/add', [TaslemMaintenance::class, 'add_session_form'])->name('.add_form');
        Route::post('/save', [TaslemMaintenance::class, 'save_session'])->name('.save');
        Route::get('/toDaySessions', [TaslemMaintenance::class, 'toDaySessions'])->name('.toDaySessions');
        Route::get('/to_day_list', [TaslemMaintenance::class, 'to_day_list'])->name('.to_day_list');
        Route::get('/getTable/{user_ids}', [TaslemMaintenance::class, 'getTable'])->name('.getTable');

        Route::post('/delete_session', [TaslemMaintenance::class, 'delete_session'])->name('.delete');
        Route::post('/publish', [TaslemMaintenance::class, 'publish_session'])->name('.publish');
        Route::get('/toDaySessions', [TaslemMaintenance::class, 'index'])->name('.toDaySessions');
        Route::get('/export', [TaslemMaintenance::class, 'export'])->name('.export');
        Route::get('/excel', [TaslemMaintenance::class, 'excel'])->name('.excel');
        Route::post('send_sms', [TaslemMaintenance::class, 'send_sms'])->name('.send_sms');
    });
    Route::get('/add_files/{session_id}', [TaslemMaintenance::class, 'add_files'])->name('.add_files');
    Route::post('/upload_file/{session_id}/{type}', [TaslemMaintenance::class, 'upload_file'])->name('.upload_file');
    Route::post('/download_file/{session_id}/{type}', [TaslemMaintenance::class, 'download_file'])->name('.download_file');
    Route::post('/save_note', [TaslemMaintenance::class, 'save_note'])->name('.save_note');

    Route::group([
        'prefix' => 'Appointment',
        'as'     => '.Appointment.',
    ], function () {
        Route::get('', [AppointmentController::class, 'index'])->name('index');
        Route::get('data-tables', [AppointmentController::class, 'list'])->name('list');
        Route::get('export', [AppointmentController::class, 'export'])->name('export');
        Route::get('excel', [AppointmentController::class, 'excel'])->name('excel');
        Route::get('create', [AppointmentController::class, 'create'])->name('create');
        Route::post('store', [AppointmentController::class, 'store'])->name('store');
        Route::post('send_sms', [AppointmentController::class, 'send_sms'])->name('send_sms');
        Route::get('NotPublished', [AppointmentController::class, 'notPublished'])->name('notPublished');
        Route::post('publish', [AppointmentController::class, 'publish'])->name('publish');
        Route::post('delete', [AppointmentController::class, 'delete'])->name('delete');
        Route::get('{Appointment}/show', [AppointmentController::class, 'show'])->name('show');
        Route::post('{Appointment}/update', [AppointmentController::class, 'update'])->name('update');
        Route::post('{Appointment}/upload', [AppointmentController::class, 'upload'])->name('upload');
    });
});
Route::prefix('kdana')->name('kdana')->middleware(['kdana'])->group(function () {
    Route::get('', [KdanaController::class, 'index']);
    Route::get('orders', [KdanaController::class, 'orders'])->name('.orders');
    Route::get('orders_list', [KdanaController::class, 'orders_list'])->name('.orders_list');
    Route::get('users', [KdanaController::class, 'show_users'])->name('.show_users');
    Route::get('users_list', [KdanaController::class, 'users_list'])->name('.users_list');
    Route::get('show_license', [KdanaController::class, 'show_license'])->name('.show_license');
    Route::get('license_list', [KdanaController::class, 'license_list'])->name('.license_list');
});
//Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth','order_id_middleware']], function () {
//    \UniSharp\LaravelFilemanager\Lfm::routes();
//});

Route::get('generate', [PDFController::class, 'generate']);
Route::get('import-excel', function () {


    //    return view('CP.import-excel.index');
});
Route::post('import', [ImportExcelController::class, 'import'])->name('import');

Route::get('raft_company/get_camp_by_box/{box}', [RaftCompanyController::class, 'get_camp_by_box'])->name('raft_company.get_camp_by_box');
Route::get('RaftCompany/{box}/Camps', [RaftCompanyController::class, 'campsByBoxNumber'])->name('RaftCompany.campsByBoxNumber');

Route::get('qr_download_files/{order}', [LicenseController::class, 'qr_download_files'])->name('qr_download_files');
Route::get('download_raft_company_file/{rf_id}/{file_type}', [LicenseController::class, 'download_raft_company_file'])->name('download_raft_company_file');
Route::get('showWest', [LoginController::class, 'showWest'])->name('showWest');
Route::get('west_list', [LoginController::class, 'west_list'])->name('west_list');
Route::get('ex', [LoginController::class, 'ex'])->name('ex');
Route::get('ex_boxes_users', [LoginController::class, 'ex_boxes_users'])->name('ex_boxes_users');
Route::get('download_file/{model}/{id}/{attribute}', [GeneralController::class, 'download_file'])->name('download_file');

Route::group(['prefix' => 'Development'], fn() => Route::any('', [DevelopmentController::class, 'dev'])->name('development'));
