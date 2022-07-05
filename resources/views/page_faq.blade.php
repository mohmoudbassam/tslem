@extends('page_layout')
@section('pageTitle', 'الاسئلة الشائعة')
@section('pageHead')
<style>
      .accordion-button::after{
        margin-right: auto;
        margin-left: 0;
      }
      .main-header:not(.fixed-header).internal{
        background-color: #0A2373 ;
      }
      .main-header:not(.fixed-header).bg-primary .menu-container .main-menu .menu_item .menu_link {
        color: #fff;
      }
      .accordion-button:not(.collapsed) {
        color: #0a2373;
        background-color: #0a23730f;
        box-shadow: inset 0 -1px 0 rgb(0 0 0 / 13%);
      }
      .accordion-button {
        text-align: right;
      }

    </style>
    <script type="text/javascript">
        $(function(){
            $('.accordion-button').click(function(){
                $(this).toggleClass('collapsed');
                $(this).closest('.accordion-header').next().toggleClass('show');
            });
        });
    </script>
@endsection
@section('pageContent')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <section class="section py-5 my-lg-5">
                      <div class="accordion" id="accordionExample">
                        <div class="accordion-item shadow border-0 mb-3 rounded-10 overflow-hidden">
                          <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button shadow-none py-4" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                              لماذا لا يعمل "زر" إنشاء رفع الطلب؟
                            </button>
                          </h2>
                          <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                              لأنه من المهم الانتظار حتى يتم اكتمال رفع جميع البيانات.
                            </div>
                          </div>
                        </div>
                        <div class="accordion-item shadow border-0 mb-3 rounded-10 overflow-hidden">
                          <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button shadow-none collapsed py-4" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                              هل يمكن تزويدنا بأسماء المقاولين والمكاتب الهندسية المؤهلين؟
                            </button>
                          </h2>
                          <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                              ▪️نعم .. تتوفر جميع أسماء المقاولين والمكاتب الهندسية المؤهلين في الصفحة الرئسية للمنصة.
                            </div>
                          </div>
                        </div>
                        <div class="accordion-item shadow border-0 mb-3 rounded-10 overflow-hidden">
                          <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button shadow-none collapsed py-4" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                              لماذا لم يتم اعتماد تأهيل المؤسسات والشركات رغم وجود سجل تجاري لها؟
                            </button>
                          </h2>
                          <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                              يعود السبب في ذلك؛ لأن النشاط المطلوب للتأهيل هو المكاتب الهندسية المرخصة، والمقاولين للأعمال الإنشائية المرخصين بسجل تجاري ساري المفعول.
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
            </section>
        </div>
    </div>
</div>
@endsection