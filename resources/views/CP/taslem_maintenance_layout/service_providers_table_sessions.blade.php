<table class="table mb-0">

    <thead class="table-light">
    <tr>
        <th>#</th>
        <th>مقدم الخدمة</th>
        <th>البريد الإلكتروني</th>
        <th>رقم الجوال</th>
        <th>الموعد</th>
    </tr>
    </thead>
    <tbody>
    @php($i=1)
    @foreach($users as $user )
        <tr>
            <th scope="row">{{$i}}</th>
            <td>{{$user->company_name}}</td>
            <td>{{$user->email}}</td>
            <td>{{$user->phone}}</td>
            <td><input type="text" class="form-control datepic" id="date{{$user->id}}" name="{{$user->id}}"></td>
            <input type="hidden" id="user[{{$user->id}}]">
            <input type="hidden" name="user[{{$user->id}}]"  id="{{$user->id}}">
        </tr>
        @php($i++)
    @endforeach

    </tbody>
    <script>
        flatpickr(".datepic", {enableTime: true, minDate: '{{now('Asia/Riyadh')}}'});

        $('.datepic').on('change', function () {
            let date_pickr_name = $(this).attr('name');
            let hidden_input = $("#"+date_pickr_name);
            hidden_input.val($(this).val());

        })
    </script>
</table>
