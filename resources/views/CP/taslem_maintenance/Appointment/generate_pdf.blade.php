@extends('CP.layout.snappy_pdf')

@section('content')
    <div class="container">
        <table style="width: 100%">
            <tbody>
            <tr>
                <td>
                    {{--<img src="{{ url('appointment/ksa.png') }}" style="width: 200px " alt="">--}}
                     {!! nl2br(__("print.appointment.header_right")) !!}
                </td>
                <td>
                    {{--<img src="{{ url('appointment/ksa.png') }}" alt="">--}}
                </td>
                <td>

                </td>
            </tr>
            </tbody>
        </table>
        <h3 style="text-align:center;"> مواعيد يوم: {{now()->format('Y-m-d')}}</h3>
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
