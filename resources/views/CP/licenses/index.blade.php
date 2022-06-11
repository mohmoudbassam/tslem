@extends('CP.master')
@section('title')
    {{\App\Models\License::trans('plural')}}
@endsection
@section('content')
    <style>
        .modal-backdrop.show {
            display: initial !important;
        }

        .modal-backdrop.fade {
            display: initial !important;
        }

        .file-view-wrapper:hover {
            box-shadow: var(--bs-box-shadow) !important;
        }

        .file-view-icon {
            height: 180px;
            background-size: 50%;
            background-position: center;
            background-repeat: no-repeat;
        }

        .file-view-wrapper {
            position: relative;
        }

        .file-view-download {
            position: absolute;
            top: 9px;
            left: 11px;
            font-size: 18px;
            color: #0b2473;
        }
    </style>

    <!-- region: breadcrumb -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">
                    <a class="btn btn-primary" href="{{route('licenses.add')}}">
                        <i class="dripicons-license p-2"></i>
                        {{\App\Models\License::crudTrans('create')}}
                    </a>
                </h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="javascript: void(0);">{{\App\Models\License::crudTrans('index')}}</a></li>
                        <li class="breadcrumb-item active">الرئيسية</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- endregion: breadcrumb -->

    <!-- region: data -->
    <div class="card">

        <!-- region: search -->
        <div class="card-header">
            <div class="row mt-4">
                <div class="col-lg-12">

                    <form class="row gx-3 gy-2 align-items-center mb-4 mb-lg-0">
                        <div class="col-lg-4">
                            <label class="visually-hidden" for="specificSizeInputName">البحث</label>
                            <input type="text" class="form-control" id="name" placeholder="البحث">
                        </div>
                    </form>
                </div>


            </div>
        </div>
        <!-- endregion: search -->

        <div class="card-body">

            <div class="row">

                <div class="col-sm-12">
                    <!-- region: datatable -->
                    <table class="table align-middle datatable dt-responsive table-check nowrap dataTable no-footer"
                           id="items_table" style="border-collapse: collapse; border-spacing: 0px 8px; width: 100%;"
                           role="grid"
                           aria-describedby="DataTables_Table_0_info">
                        <thead>
                        @foreach(\App\Models\License::getIndexColumns() as $field)
                            <th>{{$field}}</th>
                        @endforeach

                        @foreach(__('general.datatable.fields') as $field)
                            <th>{{$field}}</th>
                        @endforeach
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    <!-- endregion: datatable -->
                </div>


            </div>
        </div>
    </div>
    <!-- endregion: data -->

    <!-- region: modal -->
    <div class="modal  bd-example-modal-lg" id="page_modal" data-backdrop="static" data-keyboard="false"
         role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    </div>

    <div class="modal bd-example-modal-lg" id="view-license-files" data-backdrop="static" data-keyboard="false"
         role="dialog" aria-labelledby="View User Files" aria-hidden="true">
    </div>

    <div class="modal fade" id="view-license-files-modal" tabindex="-1" role="dialog"
         aria-labelledby="view-license-files-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <!-- region: modal title -->
                <div class="modal-header">
                    <h5 class="modal-title" id="view-license-files-modal-title">مرفقات المستخدم</h5>
                </div>
                <!-- endregion: modal title -->
                <!-- region: modal body -->
                <div class="modal-body">
                    <div class="row my-4" id="file-view-row"></div>
                </div>
                <!-- endregion: modal body -->
                <!-- region: modal footer -->
                <div class="modal-footer">
                    <button type="button" id="close-view-files-modal" class="btn btn-secondary" data-dismiss="modal">
                        إخفاء
                    </button>
                </div>
                <!-- endregion: modal footer -->
            </div>
        </div>
    </div>

    <div class="modal fade" id="view-designer-types-modal" tabindex="-1" role="dialog"
         aria-labelledby="view-license-files-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="view-designer-types-modal-title">تخصصات المستخدم</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6" id="designer">
                            <div class="row" id="view-designer-types-row">
                                <div class="col-12 d-flex flex-row justify-content-between">
                                    <div
                                        class="border rounded-circle d-flex flex-row justify-content-center align-items-center align-content-center mt-1"
                                        data-type="designer" style="height: 15px; width: 15px;"></div>
                                    <p class="d-flex flex-row justify-content-start align-items-center align-content-center"
                                       style="width: 95%;">اشراف</p>
                                </div>
                                <div class="col-12 d-flex flex-row justify-content-between">
                                    <div
                                        class="border rounded-circle d-flex flex-row justify-content-center align-items-center align-content-center mt-1"
                                        data-type="consulting" style="height: 15px; width: 15px;"></div>
                                    <p class="d-flex flex-row justify-content-start align-items-center align-content-center"
                                       style="width: 95%;">مكتب تصميم</p>
                                </div>
                                <div class="col-12 d-flex flex-row justify-content-between">
                                    <div
                                        class="border rounded-circle d-flex flex-row justify-content-center align-items-center align-content-center mt-1"
                                        data-type="fire" style="height: 15px; width: 15px;"></div>
                                    <p class="d-flex flex-row justify-content-start align-items-center align-content-center"
                                       style="width: 95%;">الحماية والوقاية من الحريق</p>
                                </div>
                            </div>
                        </div>


                        <div class="col-6" id="contractor">
                            <div class="row" id="view-designer-types-row">
                                <div class="col-12 d-flex flex-row justify-content-between">
                                    <div
                                        class="border rounded-circle d-flex flex-row justify-content-center align-items-center align-content-center mt-1"
                                        data-type="general" style="height: 15px; width: 15px;"></div>
                                    <p class="d-flex flex-row justify-content-start align-items-center align-content-center"
                                       style="width: 95%;">عام</p>
                                </div>
                                <div class="col-12 d-flex flex-row justify-content-between">
                                    <div
                                        class="border rounded-circle d-flex flex-row justify-content-center align-items-center align-content-center mt-1"
                                        data-type="protections" style="height: 15px; width: 15px;"></div>
                                    <p class="d-flex flex-row justify-content-start align-items-center align-content-center"
                                       style="width: 95%;">الوقاية والحماية من الحرائق</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" id="close-view-designer-types-modal" class="btn btn-secondary"
                            data-dismiss="modal">إخفاء
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- endregion: modal -->

@endsection

@section('scripts')
    <script src="https://momentjs.com/downloads/moment.js"></script>
    <script>
        let submitSearch = () => $( '#items_table' ).DataTable().ajax.reload( null, true );

        $.fn.dataTable.ext.errMode = 'none';
        $( function () {
            $( '#items_table' ).DataTable( {
                                               "dom": 'tpi',
                                               "searching": false,
                                               "processing": true,
                                               'stateSave': true,
                                               "serverSide": true,
                                               ajax: {
                                                   url: '{{route('licenses.list')}}',
                                                   type: 'GET',
                                                   "data": function (d) {
                                                       d.name = $( '#name' ).val();
                                                   },
                                               },
                                               language: {
                                                   "url": "{{url('/')}}/assets/datatables/Arabic.json",
                                               },
                                               columns: {!! \App\Models\License::getDatatableColumns(true, true) !!}
                                           } );

        } );
        $( '#name' ).keypress( function (e) {
            if( e.keyCode === 13 ) {
                e.preventDefault()
                submitSearch()
                return false
            } else if( this.value.length >= 2 ) {
                submitSearch()
            }
        } );

        function delete_model(id, url, callback = null) {
            Swal.fire( {
                           title: '{{\App\Models\License::crudTrans('delete_confirm')}}',
                           text: "",
                           type: 'warning',
                           showCancelButton: true,
                           confirmButtonColor: '#84dc61',
                           cancelButtonColor: '#d33',
                           confirmButtonText: '@lang('general.yes')',
                           cancelButtonText: '@lang('general.no')',
                       } ).then( (result) => {
                if( result.value ) {
                    $.ajax( {
                                url: url,
                                type: "POST",
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    'id': id,
                                },
                                beforeSend() {
                                    KTApp.blockPage( {
                                                         overlayColor: '#000000',
                                                         type: 'v2',
                                                         state: 'success',
                                                         message: '@lang('general.please_wait')',
                                                     } );
                                },
                                success: function (data) {
                                    if( callback && typeof callback === "function" ) {
                                        callback( data );
                                    } else {
                                        if( data.success ) {
                                            $( '#items_table' ).DataTable().ajax.reload( null, false );
                                            showAlertMessage( 'success', data.message );
                                        } else {
                                            showAlertMessage( 'error', '@lang('general.something_went_wrong')' );
                                        }
                                        KTApp.unblockPage();
                                    }
                                },
                                error: function (data) {
                                },
                            } );
                }
            } );
        }
    </script>
@endsection
