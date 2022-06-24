@extends('CP.layout.print_layout')
@php
    $mode ??= 'print';
    $mode_form ??= ($mode === 'print' ? 'print' : 'create');
    $model = optional($model ?? null);

@endphp

    @section('title')
        {{\App\Models\License::crudTrans($mode)}}
    @endsection

@section('content')
    @if( !($print ?? true) )
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
        h4 {
            margin: 0 !important;
            margin-top: 15px !important;
        }

        .border {
            border: 1px solid black !important;
        }
    </style>
@endsection
