@extends('CP.master')
@section('title')
الإشعارات
@endsection
@section('content')

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">الإشعارات </a></li>
                        <li class="breadcrumb-item active">الرئيسية</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="row mt-4">
                <div class="col-lg-12">
                    <h2>الاشعارات</h2>
                </div>


            </div>
        </div>
        <div class="card-body">

            <div class="row">

                <div class="col-sm-12">

                <div data-simplebar style="max-height: 230px;">
                        @foreach (auth()->user()->notifications()->get() as $notification)

                            <a href="#!" class="text-reset notification-item">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <img src="{{ \App\Models\User::select('image')->where('id',$notification->notifiable_id)->first()->image }}"
                                             class="rounded-circle avatar-sm" alt="user-pic">
                                    </div>

                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">{{optional($notification->Notifer)->name}}</h6>
                                        <div class="font-size-13 text-muted">
                                            <p class="mb-1">{{$notification->data['data']}}</p>
                                            <p class="mb-0"><i class="mdi mdi-clock-outline"></i>
                                                <span>{{$notification->created_at->diffForHumans()}}</span></p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>

                </div>


            </div>
        </div>
    </div>



@endsection

@section('scripts')

@endsection
