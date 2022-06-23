@extends('CP.master')
@section('title')
التعليقات
@endsection
@section('style')
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<style>
body {
    margin-top: 20px;
}

.content-item {
    padding: 30px 0;
    background-color: #FFFFFF;
}

.content-item.grey {
    background-color: #F0F0F0;
    padding: 50px 0;
    height: 100%;
}

.content-item h2 {
    font-weight: 700;
    font-size: 35px;
    line-height: 45px;
    text-transform: uppercase;
    margin: 20px 0;
}

.content-item h3 {
    font-weight: 400;
    font-size: 20px;
    color: #555555;
    margin: 10px 0 15px;
    padding: 0;
}

.content-headline {
    height: 1px;
    text-align: center;
    margin: 20px 0 70px;
}

.content-headline h2 {
    background-color: #FFFFFF;
    display: inline-block;
    margin: -20px auto 0;
    padding: 0 20px;
}

.grey .content-headline h2 {
    background-color: #F0F0F0;
}

.content-headline h3 {
    font-size: 14px;
    color: #AAAAAA;
    display: block;
}


#comments {
    box-shadow: 0 -1px 6px 1px rgba(0, 0, 0, 0.1);
    background-color: #FFFFFF;
}

#comments form {
    margin-bottom: 30px;
}

#comments .btn {
    margin-top: 7px;
}

#comments form fieldset {
    clear: both;
}

#comments form textarea {
    height: 100px;
}

#comments .media {
    border-top: 1px dashed #DDDDDD;
    padding: 20px 0;
    margin: 0;
}

#comments .media>.pull-left {
    margin-right: 20px;
}

#comments .media img {
    max-width: 100px;
}

#comments .media h4 {
    margin: 0 0 10px;
}

#comments .media h4 span {
    font-size: 14px;
    float: right;
    color: #999999;
}

#comments .media p {
    margin-bottom: 15px;
    text-align: justify;
}

#comments .media-detail {
    margin: 0;
}

#comments .media-detail li {
    color: #AAAAAA;
    font-size: 12px;
    padding-right: 10px;
    font-weight: 600;
}

#comments .media-detail a:hover {
    text-decoration: underline;
}

#comments .media-detail li:last-child {
    padding-right: 0;
}

#comments .media-detail li i {
    color: #666666;
    font-size: 15px;
    margin-right: 10px;
}

.details_p {
    font-size: 20px;
}

.bold {
    font-weight: bold;
}
</style>
@endsection
@section('content')


<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">


            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">التقارير</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">الطلبات</a></li>
                    <li class="breadcrumb-item active">الرئيسية</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">

        <h2 class = "mb-5">تفاصيل التقرير</h2>

        <div class="row">

            <div class="col-md-6 mb-3">
                <p class="details_p"> <span class="bold"> رقم التقرير : </span>{{$report->id}}</p>
            </div>

            <div class="col-md-6 mb-3">
                <p class="details_p"> <span class="bold"> عنوان التقرير : </span>{{$report->title}}</p>
            </div>


            <div class="col-md-6 mb-3">
                <p class="details_p"> <span class="bold"> وصف التقرير : </span>{{$report->description}}</p>
            </div>


            <div class="col-md-6 mb-3">
                <p class="details_p space-nowrap"> <span class="bold">  تاريخ الإنشاء : </span>{{$report->created_at}}</p>
            </div>


        </div>
        <hr>
        <div class="row">
            @if(!empty($report->files))
                <h2 class = "mt-5">المرفقات</h2>

            @foreach($report->files as $file)
            <div class="col-md-offset-3 col-md-2">
                                                    <div class="panel panel-default bootcards-file">

                                                        <div class="list-group">
                                                            <div class="list-group-item">
                                                                <a href="#">
                                                                    <i class="fa fa-file-pdf fa-4x"></i>
                                                                </a>
                                                                <h5 class="list-group-item-heading">
                                                                    <a
                                                                        href="{{route('contractor.download',['id'=>$file->id])}}">
                                                                        {{$file->real_name}}
                                                                    </a>
                                                                </h5>

                                                            </div>

                                                        </div>
                                                        <br>
                                                        <div class="panel-footer">
                                                            <div class="btn-group btn-group-justified">
                                                                <div class="btn-group">
                                                                    <a class="btn btn-success"
                                                                        href="{{route('contractor.download',['id'=>$file->id])}}">
                                                                        <i class="fa fa-arrow-down"></i>
                                                                        تنزيل
                                                                    </a>
                                                                </div>


                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
            @endforeach
            @endif
        </div>

        <hr>


        <div class="row">
            <section class="content-item" id="comments" style="padding-right:20px;">

                <form method="post" id="save_comment">
                    @csrf
                    <div class="row">
                        <div class="form-group col-xs-10 col-sm-9 col-lg-10">
                            <textarea class="form-control v" name="body" id="body"
                                placeholder="َإضافة تعليق"></textarea>
                        </div>
                        <div class="col-xs-2 col-sm-2 col-lg-2" style="padding-top:53px;">
                            <button type="submit" class="btn btn-primary submit_btn">إضافة تعليق</button>
                        </div>
                    </div>

                    <input type="hidden" name="report_id" value="{{$report->id}}" id="report_id">
                </form>


                <div class="row">

                    <div class="col-sm-8">

                        <h3>{{$report->comments->count()}} تعليق</h3>

                        @foreach($comments as $comment)
                        <div class="media">
                            <a class="pull-left" href="#"><img class="media-object" src="{{$comment->user->image}}"
                                    alt=""></a>
                            <div class="media-body">

                                <div class="row">
                                    <div class="col-sm-10">
                                        <p class="media-heading" style="font-size:18px;">
                                            {{$comment->user->company_name}}</p>
                                    </div>
                                    <div class="col-sm-2">
                                        @if(!is_null($comment->created_at))
                                        {{$comment->created_at->format('Y-m-d')}}
                                        @endif
                                    </div>

                                </div>
                                <h5>{{$comment->body}}</h5>
                            </div>
                        </div>
                        @endforeach


                    </div>
                </div>
            </section>
        </div>
    </div>

</div>



<!-- start page title -->





@endsection

@section('scripts')
<script>
$('#save_comment').validate({
    rules: {
        "body": {
            required: true,
        }
    },
    errorElement: 'span',
    errorClass: 'help-block help-block-error',
    focusInvalid: true,
    errorPlacement: function(error, element) {
        $(element).addClass("is-invalid");
        error.appendTo('#' + $(element).attr('id') + '_error');
    },
    success: function(label, element) {

        $(element).removeClass("is-invalid");
    }
});

$('.submit_btn').click(function(e) {
    e.preventDefault();

    if (!$("#save_comment").valid())
        return false;

    postData(new FormData($('#save_comment').get(0)), "{{route('contractor.save_comment')}}");
    location.reload();
});
</script>

@endsection
