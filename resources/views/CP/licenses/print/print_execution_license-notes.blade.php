
<table style='width: 100%;padding-top: 30px;' cellspacing="0" cellpadding="0">
    <tbody align="right">
    <tr>
        <td>
            <p>
تمت الأعمال بموجب رخصة الاضافات رقم ({{str_pad($model->id, 4, '0', STR_PAD_LEFT)}})، وتاريخ
&nbsp;&nbsp;&nbsp;{{ Hijrian::hijri($model->date)->format('Y/m/d') }} هـ، والتقرير النهائي للمكتب الاستشاري المشرف على التنفيذ {{optional($model->order)->consulting->company_name ?? ''}}
            </p>
        </td>
    </tr>
    <tr class="no-border">
        <td>
            <table style='width: 100%;' cellspacing="0" cellpadding="0">
                <tbody align="center">
                <tr>
                    <td rowspan="2" width="30%" style="margin: 0" class="qr-image">
                        {!! $model->getQRElement(\App\Models\License::EXECUTION_TYPE) !!}
                    </td>
                    <td width="30%">تاريخ الطباعة</td>
                    <td rowspan="2" width="30%" ><img class="my-2 stamp-image img" src="{{public_path('images/licenses/Stamp.png')}}" width="150" alt=""></td>
                </tr>

                <tr>
                    <td>{{hijriDateTime()}}</td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
