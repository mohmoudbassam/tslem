<div class="card">
    @isset($title)
        <div class="card-header">
            <div class="row text-center">
                <h4 class="card-title">{{$title ?? ''}}</h4>
            </div>
        </div>
    @endisset
    <div class="card-body">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-12 my-2 file-view m-auto" style="cursor:pointer;height: 100%;width: 256px;">
                <a href="{{ $url ?? '#' }}" download="">
                    <div class="rounded border overflow-hidden file-view-wrapper d-block">
                        <div class="file-view-icon" style="background-image: url('{{ asset("assets/images/pdf-file.png") }}'); height: 180px; background-size: 50%"></div>
                        <div class="file-view-download"><i class="fas fa-download"></i></div>
                        <div class="justify-content-center d-flex flex-column text-center border-top" style="height: 40px; background-color: #eeeeee;">
                            <small class="text-muted text-nowrap" title="{{$label ?? ''}}" style="font-size: 12px;">
                                <i class="fas fa-download"></i>
                                {{$label ?? ''}}
                            </small>
                        </div>
                    </div>
                </a>
            </div>

            @if($order->shouldPostFinalReports())
            @isset($info)
            @isset($info['note'])
                <div class="col-md-12 my-3 text-start">
                    <div class="bold border col-md-12 my-3 p-2 rounded-start {{($info['has_file'] ?? false) ? "bg-soft-light border-light " : "bg-soft-danger border-danger text-danger "}}">
                        {!! $info['note'] !!}
                    </div>
                </div>
            @endisset
            @endisset
            @endif

            @isset($buttons)
                <div class="col-md-8 col-sm-6 col-12 my-2 w-100 text-center">
                    @foreach(array_wrap($buttons ?? []) as $button)
                        @if($button['status'] ?? true)
                            <a class="btn btn-{{$button['type'] ?? 'success'}} {{($button['modal'] ?? '') ? 'show-modal' : ''}}" href="{{$button['url'] ?? '#'}}">{{$button['text'] ?? ''}}</a>
                        @endif
                    @endforeach
                </div>
            @endisset
        </div>

    </div>
</div>
