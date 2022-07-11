@extends('CP.layout.snappy_pdf')

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
                        <td></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <p class="text-justify">{!! nl2br(__("print.appointment.content")) !!}</p>
            </div>
        </div>
        <br>
        <br>
        <div class="row">
            <div class="col-md-12">
                <div>
                    <table class="center">
                        <tr class="th">
                            <th>
                                وقت الموعد
                            </th>
                            <th>
                                رقم الجوال
                            </th>
                            <th>
                                رقم المخيم
                            </th>
                            <th>
                                رقم المربع
                            </th>
                            <th>
                                مركز الخدمة
                            </th>
                            <th>
                                اسم شركة الطوافة
                            </th>
                        </tr>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <br>
    </div>
@stop
