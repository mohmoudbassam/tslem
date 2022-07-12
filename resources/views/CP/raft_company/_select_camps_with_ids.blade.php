@if(($appenChoose ?? !1) && $appenChoose)
    <option {!! (($selectedChoose ?? !1) && $selectedChoose ) ? 'selected' : '' !!} value="">اختر</option>
@endif

@foreach($camps as $id => $camp)
    <option value="{!! $id !!}">{!! $camp !!}</option>
@endforeach
