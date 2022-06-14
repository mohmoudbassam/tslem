@extends('CP.master')
@section('title')
    {{\App\Models\License::trans('plural')}}
@endsection
@section('content')
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
                        @foreach(\App\Models\License::getIndexColumns(true) as $field)
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
