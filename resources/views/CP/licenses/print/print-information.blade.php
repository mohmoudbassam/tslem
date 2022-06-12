<div align="right">
    <h4>معلومات المستفيد:</h4>
</div>

<table style='width: 100%;' border="1" cellspacing="0" cellpadding="0">
    <tbody align="center">
    <tr >
        <td colspan="2" width="85%">{{$model->raft_company_name}}</td>
        <td width="15%">اسم الجهة</td>
    </tr>

    <tr>
        <td width="55%">خريطة Gis</td>
        <td width="30%">{{$model->raft_company_id}}</td>
        <td width="15%">رقم المركز</td>
    </tr>

    <tr>
        <td rowspan="5">
            <img src="{{asset('images/licenses/map.jpg')}}" class="my-2 map-image img" width="300">
        </td>
        <td>{{$model->box_name}}</td>
        <td>رقم المربع</td>
    </tr>

    <tr>
        <td>{{$model->camp_name}}</td>
        <td>رقم المخيم</td>
    </tr>

    <tr>
        <td>{{$model->tents_count}}</td>
        <td>عدد الخيام</td>
    </tr>

    <tr>
        <td>{{$model->person_count}}</td>
        <td>عدد الحجاج</td>
    </tr>

    <tr>
        <td>{{$model->camp_space}}</td>
        <td>مساحة المخيم</td>
    </tr>
    </tbody>
</table>
