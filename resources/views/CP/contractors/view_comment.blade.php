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

        #comments .media > .pull-left {
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
    </style>
@endsection
@section('content')

    <!-- start page title -->
    <div class="row">
        <section class="content-item" id="comments">
            <div class="container">
                <div class="row">
                    <form method="post" action="{{route('contractor.save_comment')}}">
                        @csrf
                        <h3 class="pull-left"></h3>
                        <fieldset>
                            <div class="row">

                                <div class="form-group col-xs-12 col-sm-9 col-lg-10">
                                    <textarea class="form-control" name="body" id="body"
                                              placeholder="َإضافة تعليق"></textarea>
                                </div>
                            </div>
                        </fieldset>
                        <input type="hidden" name="report_id" value="{{$report->id}}" id="report_id">
                        <button type="submit" class="btn btn-primary pull-right">إضافة تعليق</button>
                    </form>


                </div>

                <div class="row">

                    <div class="col-sm-8">

                        <h3>{{$report->comments->count()}} التعليقات</h3>

                        @foreach($comments as $comment)
                            <div class="media">
                                <a class="pull-left" href="#"><img class="media-object"
                                                                   src="{{$comment->user->image}}"
                                                                   alt=""></a>
                                <div class="media-body">
                                    <h4 class="media-heading">{{$comment->user->company_name}}</h4>
                                    <p>{{$comment->body}}</p>
                                    <ul class="list-unstyled list-inline media-detail pull-left">
                                        <li><i ></i>{{$comment->created_at->format('Y-m-d')}}</li>

                                    </ul>
                                </div>
                            </div>
                        @endforeach


                    </div>
                </div>
            </div>
        </section>
    </div>




@endsection

@section('scripts')
    <script>


    </script>

@endsection
