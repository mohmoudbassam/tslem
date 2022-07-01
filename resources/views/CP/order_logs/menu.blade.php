@if(currentUser()->isAdmin())

    <li>
        <a href="{{route('order_logs')}}">
            <i data-feather="layers"></i>
            <span data-key="t-dashboard">{{\App\Models\OrderLogs::crudTrans('index')}}</span>
        </a>
    </li>
@endif
