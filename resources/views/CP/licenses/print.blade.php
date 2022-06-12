@extends('CP.print_master')
@php
    $mode ??= 'print';
    $mode_form ??= ($mode === 'print' ? 'print' : 'create');
    $model = optional($model ?? null);

@endphp

@if( !request()->has('print') )
    @section('title')
        {{\App\Models\License::crudTrans($mode)}}
    @endsection
@endif

@section('content')
    @if( !request()->has('print') )
        <div class="row">
            <div class="my-2 col-12">
                <div class="d-flex flex-wrap gap-3">
                    <a href="?print=1" class="btn btn-lg btn-primary print_btn">{{\App\Models\License::crudTrans($mode)}}</a>
                </div>
            </div>
        </div>
    @endif

    @include('CP.licenses.print.print-head')
    @include('CP.licenses.print.print-information')
    @include('CP.licenses.print.print-extra-information')
    @include('CP.licenses.print.print-executors')
    @include('CP.licenses.print.print-notes')

    <div class="page-break"></div>

    @include('CP.licenses.print.print-extra-works')


@endsection

@section('style')
    <style>
        body {
            /*font-family: "Amiri", DejaVu Sans, sans-serif !important;*/
        }

        h4 {
            margin: 0 !important;
            margin-top: 15px !important;
        }

        .print-page-container {
            /*font-size: 16px*/
        }

        .text-bold {
            font-weight: bold;
        }

        .img {
            /*max-width: 200px;*/
        }

        .ksa-image2, .qr-image {
            /*max-width: 156px;*/
        }

        .border {
            border: 1px solid black !important;
        }

        .fit-content {
            height: fit-content !important;
        }
    </style>
@endsection

@section('script')
    <script type="text/javascript">

    </script>
@endsection
