@extends('CP.layout.snappy_pdf')

@section('title', trans_choice("choice.Appointments",1) )

@section('content')
    <div class="container">
        <div class="row text-center align-items-center">
            <div class="col-4">
                <img src="{{ asset('appointment/ksa.png') }}" alt="" width="250">
                <p>{!! nl2br(__("print.appointment.header_right")) !!}</p>
            </div>
            <div class="col-4">
                <img src="{{ asset('appointment/kidana.png') }}" alt="" width="250">
            </div>
            <div class="col-4">
                <table class="table border mx-auto" style="width: 200px">
                    <tbody>
                    <tr>
                        <td>رقم المحضر</td>
                    </tr>
                    <tr>
                        <td>&nbsp; {{ $model ? $model->getIdString(4,!1) : '' }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-12">
                <p class="text-center h4">{!! nl2br(__("print.appointment.header_center")) !!}</p>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-12">
                <span>التاريخ: </span>
                <span>{{ now()->format('Y/m/d') }}</span>
                &emsp;&emsp;
                <span>الوقت: </span>
                <span>{{ now()->format('H:i') }}</span>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-12">
                <table class="table-bordered table">
                    <tbody>
                    <tr>
                        <td>
                            <span>نوع الجهة: </span>
                        </td>
                        <td>
                            <span>اسم الجهة: </span>
                        </td>
                        <td>
                            <span>المقاول: </span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <span>رقم التصريح: </span>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-12">
                <p class="text-justify">{!! nl2br(__("print.appointment.content")) !!}</p>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-12">
                <table class="table-bordered table">
                    <tbody>
                    <tr>
                        <td>
                            <span>رقم القطعة</span>
                        </td>
                        <td>
                            <span>رقم المخيم</span>
                        </td>
                        <td>
                            <span>مجموعة الخدمة</span>
                        </td>
                        <td>
                            <span>عدد الحجاج</span>
                        </td>
                        <td>
                            <span>رقم الكشف</span>
                        </td>
                        <td>
                            <span>ممثل شركة كدانة للتنمية والتطوير</span>
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-12">
                <p class="text-center">وعلى ذلك جرى التوقيع والله الموفق،،،</p>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-12">
                <table class="table-bordered table">
                    <tbody>
                    <tr class="text-center">
                        <td width="50%" colspan="2">
                            <span>ممثل الجهة المستفيدة</span>
                        </td>
                        <td width="50%" colspan="2">
                            <span>ممثل المقاول</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="50%" colspan="2">
                            <span>الاسم:</span>
                        </td>
                        <td width="50%" colspan="2">
                            <span>الاسم:</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="25%">
                            <span>التوقيع:</span>
                        </td>
                        <td width="25%">
                            <span>الجوال:</span>
                        </td>
                        <td width="25%">
                            <span>التوقيع:</span>
                        </td>
                        <td width="25%">
                            <span>الجوال:</span>
                        </td>
                    </tr>
                    <tr class="text-center">
                        <td width="50%" colspan="2">
                            <span>مندوب الاستشاري</span>
                        </td>
                        <td width="50%" colspan="2">
                            <span>مندوب وزارة الحج</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="50%" colspan="2">
                            <span>الاسم:</span>
                        </td>
                        <td width="50%" colspan="2">
                            <span>الاسم:</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="25%">
                            <span>التوقيع:</span>
                        </td>
                        <td width="25%">
                            <span>الجوال:</span>
                        </td>
                        <td width="25%">
                            <span>التوقيع:</span>
                        </td>
                        <td width="25%">
                            <span>الجوال:</span>
                        </td>
                    </tr>
                    <tr class="text-center">
                        <td width="100%" colspan="4">
                            <span>مندوب شركة كدانة للتنمية والتطوير</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="50%" colspan="2">
                            <span>الاسم:</span>
                        </td>
                        <td width="25%">
                            <span>التوقيع:</span>
                        </td>
                        <td width="25%">
                            <span>الجوال:</span>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <br>
        <br>
        <div class="row text-center align-items-center justify-content-end">
            <div class="col-auto">
                <img src="{{ asset('appointment/tsleem.png') }}" alt="" width="100">
            </div>
        </div>
    </div>
@stop
