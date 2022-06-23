@if(currentUser()->isAdmin())
    <li>
    <a href="javascript: void(0);" class="has-arrow">
        <i data-feather="pocket"></i>
        <span data-key="t-apps">{{\App\Models\License::trans('group')}}</span>
    </a>
    <ul class="sub-menu" aria-expanded="false">
        <li>
            <a href="{{route('licenses')}}">
                <span data-key="t-calendar">{{\App\Models\License::crudTrans('index')}}</span>
            </a>
        </li>
        <li>
            <a href="{{route('licenses.add')}}">
                <span data-key="t-chat">{{\App\Models\License::crudTrans('add')}}</span>
            </a>
        </li>
        @if(request()->routeIs('licenses.edit'))
            <li>
                <a onclick="event.preventDefault(); return false" href="{{route('licenses.edit',['license'=>request()->license])}}">
                    <span data-key="t-chat">{{ \App\Models\License::crudTrans('update') }}</span>
                </a>
            </li>
        @endif
    </ul>
</li>
@else
    <li>
        <a href="{{route('licenses')}}">

            <i data-feather="pocket"></i>
            <span data-key="t-calendar">{{\App\Models\License::trans('group')}}</span>
        </a>
    </li>
@endif
