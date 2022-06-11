@extends('CP.print_master')
@php
    $mode ??= 'print';
    $mode_form ??= ($mode === 'print' ? 'print' : 'create');
    $model = optional($model ?? null);
@endphp
@section('title')
    {{\App\Models\License::crudTrans($mode)}}
@endsection
@section('content')
    <div class="row">
        <div class="my-2 col-12">
            <div class="d-flex flex-wrap gap-3">
                <button type="button" class="btn btn-lg btn-primary submit_btn" form="form">
                    {{\App\Models\License::crudTrans($mode)}}</button>
            </div>
        </div>
    </div>
    <div class=" print-page-container">
        <div class="row row-head d-flex align-items-center justify-content-center ">
            <div class="row col-3 ">
                <div class="col-12 text-center">
                    <img src="{{asset('images/licenses/ksa.jpg')}}" class="ksa-image img">
                </div>
                <div class="col-12 text-center">
                    شركة كدانة للتنمية و التطوير
                    مركز تسليم
                </div>
            </div>
            <div class="col-5 text-center ">
                <img src="{{asset('images/licenses/logo.png')}}" class="logo-image img">
            </div>
            <div class="col-4 text-center ">
                <div class="row">
                    <div class="col-6">رقم الرخصة:</div>
                    <div class="col-6">{{$model->id}}</div>
                    <div class="col-6">تاريخها:</div>
                    <div class="col-6">{{$model->hijri_date}} هـ</div>
                    <div class="col-6">تاريخ الإنتهاء:</div>
                    <div class="col-6">{{$model->hijri_expiry_date}} هـ</div>
                </div>
            </div>
        </div>

        <div class="row row-title py-2">
            <div class="col-12 text-center h5">
                رخصة إضافات ( مشعر منى )
            </div>
        </div>

        <div class="row row-information py-2 ">
            <div class="col-12 text-bold">معلومات المستفيد:</div>

            <div class="row col-6 ">
                <div class="col-4 text-center border">اسم الجهة</div>
                <div class="col-8 text-center border">{{$model->raft_company_name}}</div>

                <div class="col-4 text-center border">رقم المركز</div>
                <div class="col-8 text-center border">{{$model->raft_company_id}}</div>

                <div class="col-4 text-center border">رقم المربع</div>
                <div class="col-8 text-center border">{{$model->box_name}}</div>

                <div class="col-4 text-center border">رقم المخيم</div>
                <div class="col-8 text-center border">{{$model->camp_name}}</div>

                <div class="col-4 text-center border">عدد الخيام</div>
                <div class="col-8 text-center border">{{$model->tents_count}}</div>

                <div class="col-4 text-center border">عدد الحجاج</div>
                <div class="col-8 text-center border">{{$model->person_count}}</div>

                <div class="col-4 text-center border">مساحة المخيم</div>
                <div class="col-8 text-center border">{{$model->camp_space}}</div>
            </div>

            <div class="row col-6">
                <div class="col-12 d-flex align-items-center justify-content-center border ">خريطة Gis</div>
                <div class="col-12 d-flex align-items-center justify-content-center p-0 border">
                    <img src="{{asset('images/licenses/map.jpg')}}" class="my-2 map-image img">
                </div>
            </div>
        </div>

        <div class="row row-extra-information py-2 ">
            <div class="col-12 text-bold">مكونات الاضافة:</div>

            <div class="row col-6 ">
                <div class="col-6 text-nowrap text-center border">القواطع الجبسية (م .ط)</div>
                <div class="col-6 text-center border">-</div>

                <div class="col-6 text-nowrap text-center border">المكيفات (عدد)</div>
                <div class="col-6 text-center border">-</div>

                <div class="col-6 text-nowrap text-center border">دورة المياه (عدد)</div>
                <div class="col-6 text-center border">-</div>

                <div class="col-6 text-nowrap text-center border">رشاش حريق (عدد)</div>
                <div class="col-6 text-center border">-</div>
            </div>

            <div class="row col-6 ">
                <div class="col-6 text-nowrap text-center border">مخرج طوارئ (عدد)</div>
                <div class="col-6 text-center border">-</div>

                <div class="col-6 text-nowrap text-center border">مضلات مقاومة للحريق (م2)</div>
                <div class="col-6 text-center border">-</div>

                <div class="col-6 text-nowrap text-center border">مغاسل (عدد)</div>
                <div class="col-6 text-center border">-</div>

                <div class="col-6 text-nowrap text-center border">اخرى (عدد)</div>
                <div class="col-6 text-center border">-</div>
            </div>
        </div>

        <div class="row row-executors py-2 me-2">
            <div class="col-12 text-bold">منفذي الاعمال</div>

            <div class="row col-12 ">
                <div class="col-4 text-center text-nowrap border">المكتب المصمم</div>
                <div class="col-8 text-center border">-</div>

                <div class="col-4 text-center text-nowrap border">الإستشاري المشرف</div>
                <div class="col-8 text-center border">-</div>

                <div class="col-4 text-center text-nowrap border">المقاول المنفذ</div>
                <div class="col-8 text-center border">-</div>

                <div class="col-4 text-center text-nowrap border">مقاول نقل النفايات</div>
                <div class="col-8 text-center border">-</div>
            </div>
        </div>

        <div class="row row-notes py-2 me-2">
            <div class="col-12 text-bold">ملاحظات</div>

            <div class="row col-12">
                <div class="col-12 border">
                    يلزم تنفيذ الأعمال بموجب الادلة الخاصة بالأعمال الاضافية والمتابعة من قبل الاستشاري المشرف بموجب
                    ماتم
                    اعتماده من قبل مركز تسليم ، وان تكون مطابقة للمخططات المعتمدة والمرفقة على QR
                </div>

            <div class="row col-6">
                <div class="col-6 text-center p-0">
                    <div class="col-12 d-flex align-items-center justify-content-center border h-25">
                        اعتماد مدير المركز
                    </div>
                    <div class="col-12 d-flex align-items-center justify-content-center border h-75"></div>
                </div>
                <div class="col-6 d-flex align-items-center justify-content-center border">
                    <div class="col-12 text-center">
                        الختم
                    </div>
                </div>
            </div>

            <div class="row col-6 ">
                <div class="col-6 text-center p-0">
                    <div class="col-12 d-flex align-items-center justify-content-center h-50 border">
                        تاريخ الطباعة
                    </div>
                    <div class="col-12 d-flex align-items-center justify-content-center h-50 border">
                        {{now()}}
                    </div>
                </div>
                <div class="col-6 text-center p-0 border">
                    <img src="{{asset('images/licenses/qr.png')}}" class="my-2 qr-image img">
                </div>
            </div>
            </div>
        </div>

        <div class="row row-extra-works py-2 ">
            <div class="col-12 text-center text-bold">الأعمال الإضافية</div>

            <div class="row py-2">
                <div class="col-12 ">
                    اولاً : متطلبات الأعمال الإضافية المقدمة من قبل شركات و مؤسسات حجاج الداخل و الخارج
                </div>
                <div class="col-12 ">
                    1- إنشاء دورات مياه عامة بحيث تتكون المجموعة الواحدة من أربع دورات أكثر ويتم إنشائة خارج المنطقة
                    المغطاه بالخيام قدر الإمكان و في حالة تعذر ذلك تنفذ تحت الخيام مع إزالة الأروقة الحالية لتلك الخيام
                    وأن يختصر إنشاء الدورات العامة على المواقع التي لا يوجد بها حمامات أما دورات المياه الخاصة فيجب أن
                    لا تقل عن دورتين متجاورتين وأن لا تتعارض مع مخارج الطوارئ ويتم ربط هذه الدورات بشبكة المياه و الصرف
                    الصحي حسب الادلة وفي كل الحالات تكون دورات المياه من الفيبر قلاس المقاوم .
                    <br>2- إضافة مواضى لدورات المياه الخاصة بها .
                    <br>3- عمل فواصل داخليه بين الخيام أو بين المواقع على أن تكون الفواصل من الألواح الجبسية المقاومة
                    للحريق صناعة شركة الجبس الأهلية بسماكة 12.7 سم أو الألواح الجبسية الفرنسية المقاومة للحريق أو
                    الألمانية المقاومة للحريق لمدة 45 دقيقة .
                    <br>4-إنشاء مطابخ جديدة في المخيمات التي لا تتوفر فيها المطابخ على أن تكون مطابقة لمتطلبات الدفاع
                    المدني وحسب الادلة و الشروط .
                </div>
            </div>

            <div class="row py-2">
                <div class="col-12 ">
                    ثانياً : متطلبات تنفيذ العمل
                </div>
                <div class="col-12 ">
                    1- يتم تنفيذ جميع الاعمال المطلوبة الورادة في الفقرة الأولى على حساب الجهة المستفيدة (الشركات
                    ومؤسسات حجاج الداخل و الخارج ) تحت إشراف مركز تسليم و التنسيق مع مقاولي التشغيل و الصيانة في المشروع
                    على مسءوليتهم .
                    <br>2- عدم البدء بتنفيذ اي عمل من الأعمال المطلوبة إلا بعد الحصول على تصريح منمركز تسليم يبين نوع
                    العمل و موقعه و الاشتراطات الخاصة به ويلزم الإحتفاظ به بالموقع في مكان بارز مع مخطط معتمد يوضح
                    الأعمال الموافق على تنفيذها .
                    <br>3- أن يتم الإتفاق مع مقاول التشغيل و الصيانة على القيام بعملية فك وحفظ و إعادة تركيب القواطع و
                    السواتر المطلوب وضع فواصل جبسية مكانها وفقا للأسعار المحددة منمركز تسليم وتسليمها لهم بمحاضر رسمية
                    وتكون تكلفة ذلك على حساب صاحب المخيم .
                    <br>4- تقوم شركات ومؤسسات حجاج الداخل و الخاريج بالتنسيق مع اسكان الحجاج بمنى بإزالة كافة الأعمال
                    التي يجب إزالتها بعد موسم الحج مباشرة و إعادة الوضع إلى ما كان عليه سابقاً و تقديم ما يثبت ذلك من
                    الجهات المعنية .
                    <br>5- تكليف مكتب هندسي إستشاري من قبل شركات ومؤسسات حجاج الداخل و الخارج يقوم بتقديم عدد ثلاثة
                    تقارير لكل موقع على ثلاثة مراحل أثناء تنفيذ العمل تفيد بمطابقة جميع الاعمال الإضافية للمطلوب أعلاه
                    من عدمه يتنفيذ هذه الشروط و الادلة و المواصفات الفنية وذلك لجميع الأعمال التخصصية .
                </div>
            </div>
        </div>
    </div>

@endsection
@section('style')
    <style>
        .print-page-container {
            font-size: 16px
        }

        .text-bold {
            font-weight: bold;
        }

        .img {
            max-width: 256px;
        }

        .ksa-image2, .qr-image {
            max-width: 156px;
        }

        .border {
            border: 1px solid black !important;
        }

        .map-image2 {
            position: absolute;
            top: 25%;
            left: 25%;
        }

        .fit-content {
            height: fit-content !important;
        }
    </style>
@endsection
