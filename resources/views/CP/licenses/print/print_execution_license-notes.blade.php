
<table style='width: 100%;padding-top: 30px;' cellspacing="0" cellpadding="0">
    <tbody align="right">
    <tr>
        <td>
            <p>
تمت الأعمال بموجب رخصة الاضافات رقم (.......................)، وتاريخ
&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;14 هـ، والتقرير النهائي للمكتب الاستشاري المشرف على التنفيذ .....................
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
