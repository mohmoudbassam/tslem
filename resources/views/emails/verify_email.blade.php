<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300&family=Tajawal:wght@200;400&display=swap" rel="stylesheet">

@component('mail::message')
 <h2 style = "text-align:right; font-family:Tajawal;"> تفعيل البريد الالكتروني</h2>

 <p style = "text-align:right; font-family:Tajawal;">اضغط على الرابط التالي لتفعيل بريدك الالكتروني</p>


@component('mail::button', ['url' => url('/account/verify/'.$token) ])
<p style = "text-align:right; font-family:Tajawal; line-height:10px; padding-top:10px;">تفعيل البريد الالكتروني </p>

@endcomponent

<img src="{{url('/assets/img/تسليم 2.png')}}" alt="">

@endcomponent
