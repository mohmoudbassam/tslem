@extends('CP.master')
@section('title')
تغيير كلمة المرور
@endsection
@section('content')

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">


                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">تغيير كلمة المرور </a></li>
                        <li class="breadcrumb-item"><a href="{{route('users')}}">المستخدمين</a></li>
                        <li class="breadcrumb-item active">الرئيسية</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="row">
            <div class="col-12">
                <div class="alert alert-danger">
                    <div class="ul m-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="card-title">
                                تغيير كلمة المرور
                            </h1>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form  method="post" action="{{route('users.change_password')}}" id="update-password-form">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label required-field" for="password">كلمة  المرور الجديدة</label>
                                    <input type="password" class="form-control" name="password"  id="password" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label required-field" for="password_confirmation">تأكيد كلمة المرور  </label>
                                    <input type="password" class="form-control" name="password_confirmation"  id="password_confirmation" required>
                                </div>
                            </div>
                            <input type="hidden" name="id" value="{{$user->id}}">
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <div class="d-flex flex-wrap gap-3">
                        <button type="submit" class="btn btn-lg btn-primary submit_btn" form="update-password-form">تغيير</button>
                    </div>
                </div>

            </div>
        </div>
    </div>



@endsection

@section('scripts')


@endsection
