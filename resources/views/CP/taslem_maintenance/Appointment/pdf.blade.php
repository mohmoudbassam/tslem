<html>
<head>
    <style>
        .table td {
            text-align: center;
            vertical-align: middle;
        }

        table .th {
            background-color: lightgray;
        }

        table .th td {
            font-weight: bold;
        }

        table, th, td, tr {
            border: 1px solid black;
        }

        tr {
            border-bottom: 1pt solid black;
        }

        .center {
            margin-left: auto;
            margin-right: auto;
        }
    </style>
    <meta
        http-equiv="Content-Type"
        content="text/html; charset=UTF-8"
    >
    <style>
        @page {
            header: page-header;
            footer: page-footer;
        }

        body {
            font-family: sans-serif;
        }
    </style>
</head>
<body>
<htmlpageheader
    name="page-header"
    style="float: right !important"
>

</htmlpageheader>
<div class="container">
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
                    @foreach($rows as $row)
                        <tr>
                            <td>{{$row->start_at_to_string}}</td>
                            <td>{{optional($row->RaftCompanyLocation)->user->phone ?? ''}}</td>
                            <td>{{optional($row->RaftCompanyBox)->camp}}</td>
                            <td>{{optional($row->RaftCompanyBox)->box}}</td>
                            <td>{{$row->service_provider_name}}</td>
                            <td>{{optional($row->RaftCompanyLocation)->name}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <br>
</div>
</body>
</html>
