@php
    $name ??= $label ?? ("input_" . time());
    $id ??= $name;
    $value ??= old($name,null);
    $type ??= 'text';
    $options ??= [];
    $model = optional($model ??[]);
    $selected ??= $value ?? $model->$name;
@endphp

@if ($col ?? false)
    <div class="col-md-{{$col ?: 6}}">
        <div class="mb-3">
            @endif

            @if($label ?? false)
                <label class="form-label" for="{!! $id !!}">
                    {!! $label ?? $name !!}
                    @if ($required ?? false)
                        <span class="text-danger required-mark">*</span>
                    @endif
                </label>
            @endif

            @if ($type === 'select')
                <select
                    id="{!! $id !!}"
                    name="{!! $name !!}"
                    class="form-control {{$id}}_input {!! $class ?? '' !!}"
                    {!! $attributes ?? '' !!}
                >
                    @foreach($options as $value => $label)
                        <option value="{{ $value }}"
                                @if($selected == $value)
                                    selected="selected"
                            @endif
                        >{{$label}}</option>
                    @endforeach
                </select>
            @elseif($type === 'textarea')
                <textarea
                    id="{!! $id !!}"
                    name="{!! $name !!}"
                    rows="6"
                    class="form-control {{$id}}_textarea {!! $class ?? '' !!}"
                    {!! $attributes ?? '' !!}>{!! $value ?? old($name) !!}</textarea>
            @elseif ($type === 'file')
                <input
                    id="{!! $id !!}"
                    name="{!! $name !!}"
                    value="{!! $value ?? old($name) !!}"
                    type="{!! $type ?? 'file' !!}"
                    class="form-control {{$id}}_input {!! $class ?? '' !!}"
                    placeholder="{!! $placeholder ?? $label ?? '' !!}"
                    {!! ($multiple ?? false) ? 'multiple' : '' !!}
                    {!! $attributes ?? '' !!}
                >

                @push('js')
                    <script>
                    @php
                        $url = $model->getAttribute("{$id}_url",$model->$id);
                    @endphp
                        file_input("#{{$id}}"
                            @if($url)
                            ,{
                                initialPreview: @json([$url]),
                                initialPreviewConfig:[
                                    {
                                        caption: '',
                                        width: "120px",
                                        url: '{{route('licenses.delete_map_path',['license'=>$model->id])}}',
                                        key: '{{$model->id}}',
                                    },
                                ]
                            },true
                        @endif
                        );
                    </script>
                @endpush
            @else
                <input
                    id="{!! $id !!}"
                    name="{!! $name !!}"
                    value="{!! $value ?? old($name) !!}"
                    type="{!! $type ?? 'text' !!}"
                    class="form-control {{$id}}_input {!! $class ?? '' !!}"
                    placeholder="{!! $placeholder ?? $label ?? '' !!}"
                    {!! $attributes ?? '' !!}
                >
            @endif

            @if($name ?? false)
                <div class="col-12 text-danger" id="{!! $name !!}_error"></div>
            @endif

            @if ($col ?? false)
        </div>
    </div>
@endif
