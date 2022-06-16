<div align="right">
    <h4>مكونات الاضافة:</h4>
</div>

<table style='width: 100%;' cellspacing="0" cellpadding="0" class="no-border">
    <tbody align="center">
    <tr>
        <td>
            <table style='width: 100%;' cellspacing="0" cellpadding="0">
                <tbody align="center">
                @foreach($second_services as $service)

                    <tr>
                        <td nowrap="nowrap" width="60%">{{$service['quantity']}}</td>
                        <td nowrap="nowrap" width="40%">{{$service['name']}} ({{$service['quantity_label']}})</td>
                    </tr>
                @endforeach

                @if(count($second_services) != count($first_services) )
                    <td nowrap="nowrap" width="100%" style="color:white">test</td>
                    <td nowrap="nowrap" width="100%" style="color:white">test</td>
                @endif
                </tbody>
            </table>
        </td>

        <td width="5%" class="border"></td>

        <td>
            <table style='width: 100%;' cellspacing="0" cellpadding="0">
                <tbody align="center">
                @foreach($first_services as $service)

                    <tr>
                        <td nowrap="nowrap" width="60%">{{$service['quantity']}}</td>
                        <td nowrap="nowrap" width="40%">{{$service['name']}} ({{$service['quantity_label']}})</td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
