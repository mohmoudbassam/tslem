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
    <div class="card">
        <div class="card-header">
            <div class="row mt-4">
                <div class="col-lg-12">

                    <h4>
                    تغيير كلمة المرور
                    </h4>
                </div>

            </div>
        </div>
        <div class="card-body">
            <form  method="post" action="{{route('users.change_password')}}">
                @csrf
                <div class="row">

                    

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="name">كلمة  المرور الجديدة</label>
                            <input type="password" class="form-control" name="password"  id="password" >
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="name">تأكيد كلمة المرور  </label>
                            <input type="password" class="form-control" name="password_confirmation"  id="password_confirmation" >
                        </div>
                    </div>

                        <input type="hidden" name="id" value="{{$user->id}}">

                </div>

                <div class="d-flex flex-wrap gap-3">
                    <button type="submit" class="btn btn-lg btn-primary submit_btn">تغيير</button>
                </div>
            </form>

            <br>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

    </div>

    

@endsection

@section('scripts')
    

@endsection
