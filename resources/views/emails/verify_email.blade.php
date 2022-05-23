@component('mail::message')
# تفعيل البريد الالكتروني

اضغط على الرابط التالي لتفعيل بريدك الالكتروني
@component('mail::button', ['url' => url('/account/verify/'.$token) ])
تفعيل البريد الالكتروني 
@endcomponent

شكرا,<br>
{{ config('app.name') }}
@endcomponent
