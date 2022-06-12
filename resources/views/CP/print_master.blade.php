@include('CP.layout.print_head')

@if(request()->has('html'))
<div style="{{request()->has('html') ? 'width: 695px;' : ''}}">
@endif
    @yield('content')
@if(request()->has('html'))
</div>
@endif

@yield('scripts')

</body>
</html>
