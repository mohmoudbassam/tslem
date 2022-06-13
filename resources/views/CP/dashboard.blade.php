@extends('CP.master')
@section('title')
    المستخدمين
@endsection
@section('style')
    <style>
        .apexcharts-canvas{
            width: 100% !important;
        }
        .apexcharts-tooltip-marker {
            margin-left: 10px;
            margin-right: 0px;
        }
        .legend-info {
            font-family: JannaLT !important;
            display: flex;
          align-items: center;
        }
        .apexcharts-legend-series {
          display: flex;
          align-items: center;
        }
        .apexcharts-legend-marker {
            margin-left: 7px;
            margin-right: 0;
        }
        .apexcharts-datalabels-group *{
          font-family: JannaLT !important;
        }
        .card.card-chart {
            border-radius: 10px;
            box-shadow: 0px 0px 20px #c0946f38;
        }
    </style>

@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-xl-4 col-md-6">
            <!-- card -->
            <div class="card card-h-100 card-chart">
                <!-- card body -->
                <div class="card-body px-2">
                    <div id="chart-1"></div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->
        <div class="col-xl-4 col-md-6">
            <!-- card -->
            <div class="card card-h-100 card-chart">
                <!-- card body -->
                <div class="card-body px-2">
                    <div id="chart-2"></div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->
        <div class="col-xl-4 col-md-6">
            <!-- card -->
            <div class="card card-h-100 card-chart">
                <!-- card body -->
                <div class="card-body px-2">
                    <div id="chart-3"></div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div>
        <div class="col-xl-4 col-md-6">
            <!-- card -->
            <div class="card card-h-100 card-chart">
                <!-- card body -->
                <div class="card-body px-2">
                    <div id="chart-7"></div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div>

      <!-- end col -->
        <div class="col-xl-4 col-md-6">
            <!-- card -->
            <div class="card card-h-100 card-chart">
                <!-- card body -->
                <div class="card-body px-2">
                    <div id="chart-4"></div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->
        <div class="col-xl-4 col-md-6">
            <!-- card -->
            <div class="card card-h-100 card-chart">
                <!-- card body -->
                <div class="card-body px-2">
                    <div id="chart-5"></div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->
    </div>
    <div class="row">
        <div class="col-xl-12 col-xxl-12 col-md-12">
            <!-- card -->
            <div class="card card-h-100 card-chart">
                <!-- card body -->
                <div class="card-body px-2">
                    <div id="chart-6"></div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->
    </div>
    <div class="row">
        <div class="col-xl-4 col-md-6">
            <!-- card -->
            <div class="casrd card-sh-100">
                <!-- card body -->
                <div class="card-body">
                    <!-- <div class="d-flex align-items-center py-3">
                        <div class="col-auto me-3">
                            <div class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																	<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																		<polygon points="0 0 24 0 24 24 0 24"></polygon>
																		<path d="M18,8 L16,8 C15.4477153,8 15,7.55228475 15,7 C15,6.44771525 15.4477153,6 16,6 L18,6 L18,4 C18,3.44771525 18.4477153,3 19,3 C19.5522847,3 20,3.44771525 20,4 L20,6 L22,6 C22.5522847,6 23,6.44771525 23,7 C23,7.55228475 22.5522847,8 22,8 L20,8 L20,10 C20,10.5522847 19.5522847,11 19,11 C18.4477153,11 18,10.5522847 18,10 L18,8 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
																		<path d="M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z" fill="#000000" fill-rule="nonzero"></path>
																	</g>
																</svg>
                            </div>
                        </div>
                        <div class="col">
                            <h2><span class="counter-value" data-target="{{$number_of_user}}"></span></h2>
                            <h6 class="text-muted mb-0">عدد المسجلين</h6>
                        </div>
                    </div> -->

                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->

        <div class="col-xl-4 col-md-6">
            <!-- card -->
            <div class="casrd card-sh-100">
                <!-- card body -->
                <div class="card-body">
                    <!-- <div class="d-flex align-items-center py-3">
                        <div class="col-auto me-3">
                            <div class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <polygon points="0 0 24 0 24 24 0 24"/>
        <path d="M18,14 C16.3431458,14 15,12.6568542 15,11 C15,9.34314575 16.3431458,8 18,8 C19.6568542,8 21,9.34314575 21,11 C21,12.6568542 19.6568542,14 18,14 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
        <path d="M17.6011961,15.0006174 C21.0077043,15.0378534 23.7891749,16.7601418 23.9984937,20.4 C24.0069246,20.5466056 23.9984937,21 23.4559499,21 L19.6,21 C19.6,18.7490654 18.8562935,16.6718327 17.6011961,15.0006174 Z M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z" fill="#000000" fill-rule="nonzero"/>
    </g>
</svg>
                            </div>
                        </div>
                        <div class="col">
                            <h2><span class="counter-value" data-target=""></span></h2>
                            <h6 class="text-muted mb-0">عدد المستخدمين تحت الإعتماد</h6>
                        </div>
                    </div> -->
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col-->
        <div class="col-xl-4 col-md-6">
            <!-- card -->
            <div class="casrd card-sh-100">
                <!-- card body -->
                <div class="card-body">
                    <!-- <div class="d-flex align-items-center py-3">
                        <div class="col-auto me-3">
                            <div class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <polygon points="0 0 24 0 24 24 0 24"/>
        <path d="M18,14 C16.3431458,14 15,12.6568542 15,11 C15,9.34314575 16.3431458,8 18,8 C19.6568542,8 21,9.34314575 21,11 C21,12.6568542 19.6568542,14 18,14 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
        <path d="M17.6011961,15.0006174 C21.0077043,15.0378534 23.7891749,16.7601418 23.9984937,20.4 C24.0069246,20.5466056 23.9984937,21 23.4559499,21 L19.6,21 C19.6,18.7490654 18.8562935,16.6718327 17.6011961,15.0006174 Z M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z" fill="#000000" fill-rule="nonzero"/>
    </g>
</svg>
                            </div>
                        </div>
                        <div class="col">
                            <h2><span class="counter-value" data-target=""></span></h2>
                            <h6 class="text-muted mb-0">عدد المستخدمين المعتمدين</h6>
                        </div>
                    </div> -->
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col-->
        <div class="col-xl-4 col-md-6">
            <!-- card -->
            <div class="casrd card-sh-100">
                <!-- card body -->
                <div class="card-body">
                    <!-- <div class="d-flex align-items-center py-3">
                        <div class="col-auto me-3">
                            <div class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																	<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																		<polygon points="0 0 24 0 24 24 0 24"></polygon>
																		<path d="M12.9336061,16.072447 L19.36,10.9564761 L19.5181585,10.8312381 C20.1676248,10.3169571 20.2772143,9.3735535 19.7629333,8.72408713 C19.6917232,8.63415859 19.6104327,8.55269514 19.5206557,8.48129411 L12.9336854,3.24257445 C12.3871201,2.80788259 11.6128799,2.80788259 11.0663146,3.24257445 L4.47482784,8.48488609 C3.82645598,9.00054628 3.71887192,9.94418071 4.23453211,10.5925526 C4.30500305,10.6811601 4.38527899,10.7615046 4.47382636,10.8320511 L4.63,10.9564761 L11.0659024,16.0730648 C11.6126744,16.5077525 12.3871218,16.5074963 12.9336061,16.072447 Z" fill="#000000" fill-rule="nonzero"></path>
																		<path d="M11.0563554,18.6706981 L5.33593024,14.122919 C4.94553994,13.8125559 4.37746707,13.8774308 4.06710397,14.2678211 C4.06471678,14.2708238 4.06234874,14.2738418 4.06,14.2768747 L4.06,14.2768747 C3.75257288,14.6738539 3.82516916,15.244888 4.22214834,15.5523151 C4.22358765,15.5534297 4.2250303,15.55454 4.22647627,15.555646 L11.0872776,20.8031356 C11.6250734,21.2144692 12.371757,21.2145375 12.909628,20.8033023 L19.7677785,15.559828 C20.1693192,15.2528257 20.2459576,14.6784381 19.9389553,14.2768974 C19.9376429,14.2751809 19.9363245,14.2734691 19.935,14.2717619 L19.935,14.2717619 C19.6266937,13.8743807 19.0546209,13.8021712 18.6572397,14.1104775 C18.654352,14.112718 18.6514778,14.1149757 18.6486172,14.1172508 L12.9235044,18.6705218 C12.377022,19.1051477 11.6029199,19.1052208 11.0563554,18.6706981 Z" fill="#000000" opacity="0.3"></path>
																	</g>
																</svg>
                            </div>
                        </div>
                        <div class="col">
                            <h2><span class="counter-value" data-target=""></span></h2>
                            <h6 class="text-muted mb-0">عدد مراكز الخدمة</h6>
                        </div>
                    </div> -->

                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col-->
        <div class="col-xl-4 col-md-6">
            <!-- card -->
            <div class="casrd card-sh-100">
                <!-- card body -->
                <div class="card-body">
                    <!-- <div class="d-flex align-items-center py-3">
                        <div class="col-auto me-3">
                            <div class="icon">
                                <svg width="30" height="30" viewBox="0 0 512 512" enable-background="new 0 0 512 512" id="Layer_1" version="1.1" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g><path d="M484.582,319.536c-26.98-11.333-51.265-27.472-72.175-47.954c-12.721-12.472-34.628-12.472-47.391,0   c-6.171,6.046-12.721,11.588-19.462,16.863c-10.022-4.112-66.687-17.029-73.118-19.023c-12.745-3.964-23.117-13.665-28.077-25.858   c39.327-17.106,60.172-61.317,63.494-105.77v-6.657h16.715c5.038,0,9.114-4.082,9.114-9.114c0-5.032-4.076-9.114-9.114-9.114   h-11.392l-1.264-12.816c-2.985-30.166-23.692-55.217-52.755-63.833l-16.614-4.925v-6.218c0-5.032-4.076-9.114-9.114-9.114h-51.871   c-5.026,0-9.102,4.07-9.114,9.09l-0.012,6.183l-16.994,5.043c-28.944,8.58-49.634,33.524-52.719,63.524l-1.347,13.066H90.212   c-5.032,0-9.114,4.082-9.114,9.114c0,5.032,4.082,9.114,9.114,9.114h17.148l0.012,7.346c3.287,43.647,23.894,87.483,62.77,104.78   c-4.907,12.454-14.798,22.162-27.828,26.185c-11.072,3.418-54.054,12.828-54.054,12.828c-0.006,0-0.012,0-0.012,0   c-5.939,1.317-58.196,14.051-64.224,56.273c-3.637,25.395-7.88,49.497-7.886,49.545c-0.469,2.646,0.267,5.376,1.994,7.441   c1.733,2.065,4.29,3.252,6.984,3.252h279.23c10.336,20.672,22.791,40.265,37.411,58.54l20.951,26.179   c6.349,7.939,15.831,12.496,26.001,12.496c10.176,0,19.652-4.557,26.007-12.496l20.963-26.202   c27.466-34.343,47.521-73.196,59.602-115.478C497.873,332.756,493.269,323.179,484.582,319.536z M327.321,301.32   c-10.947,6.96-22.399,13.143-34.491,18.216c-3.459,1.46-6.028,4.017-7.992,6.948l8.111-33.032   C293.802,293.654,324.431,300.46,327.321,301.32z M253.977,53.727c21.924,6.503,37.541,25.407,39.796,48.168l1.092,11.013h-52.322   V50.339L253.977,53.727z M224.315,34.23v78.678h-33.833l0.172-78.678H224.315z M120.853,101.717   c2.326-22.642,17.937-41.451,39.772-47.931l11.766-3.489l-0.136,62.61h-52.553L120.853,101.717z M125.576,137.793v-6.657h164.061   l0.012,5.969c-3.584,47.658-30.344,95.731-82.048,95.731S129.136,184.762,125.576,137.793z M207.6,251.063   c6.847,0,13.267-0.777,19.397-2.029c3.323,8.817,8.503,16.602,15.107,22.969l-34.26,27.822l-34.812-28.119   c6.456-6.331,11.505-14.033,14.745-22.743C194.031,250.268,200.593,251.063,207.6,251.063z M121.891,293.458l22.168,87.098H86.308   v-78.868C89.56,300.685,113.744,295.339,121.891,293.458z M42.062,341.134c2.189-15.308,14.264-25.473,26.018-31.863v71.285H35.915   C37.505,371.003,39.902,356.24,42.062,341.134z M162.868,380.556l-23.271-91.429c2.99-0.783,14.863-4.794,18.044-6.408   l44.495,35.927c1.667,1.341,3.697,2.017,5.726,2.017c2.035,0,4.07-0.676,5.744-2.041l43.961-35.696   c3.032,1.507,14.65,5.394,17.676,6.183l-22.446,91.447H162.868z M271.564,380.556c0,0,10.277-39.772,10.579-38.722   c3.792,13.273,8.461,26.161,13.801,38.722H271.564z M421.444,445.907l-20.963,26.202c-5.75,7.191-17.789,7.191-23.544,0   l-20.945-26.179c-25.953-32.432-44.905-69.149-56.095-109.592c39.603-16.09,70.383-44.394,77.883-51.74   c2.943-2.884,6.824-4.474,10.941-4.474c4.106,0,7.986,1.59,10.924,4.474c22.571,22.096,48.767,39.505,78.103,52.227   C466.336,376.77,447.391,413.463,421.444,445.907z"></path><path d="M359.658,370.338c-3.56-3.56-9.327-3.56-12.888,0c-3.56,3.56-3.56,9.327,0,12.888l24.535,24.529   c2.035,2.053,4.753,3.18,7.642,3.18c2.89,0,5.601-1.127,7.619-3.157l50.286-50.292c3.56-3.56,3.56-9.327,0-12.888   c-3.554-3.56-9.327-3.56-12.888,0l-45.017,45.023L359.658,370.338z"></path></g></svg>
                            </div>
                        </div>
                        <div class="col">
                            <h2><span class="counter-value" data-target=""></span></h2>
                            <h6 class="text-muted mb-0">عدد المقاولون</h6>
                        </div>
                    </div> -->
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col-->
        <div class="col-xl-4 col-md-6">
            <!-- card -->
            <div class="casrd card-sh-100">
                <!-- card body -->
                <div class="card-body">
                    <!-- <div class="d-flex align-items-center py-3">
                        <div class="col-auto me-3">
                            <div class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <path d="M20,8 L18.173913,8 C17.0693435,8 16.173913,8.8954305 16.173913,10 L16.173913,12 C16.173913,12.5522847 15.7261978,13 15.173913,13 L8.86956522,13 C8.31728047,13 7.86956522,12.5522847 7.86956522,12 L7.86956522,10 C7.86956522,8.8954305 6.97413472,8 5.86956522,8 L4,8 L4,6 C4,4.34314575 5.34314575,3 7,3 L17,3 C18.6568542,3 20,4.34314575 20,6 L20,8 Z" fill="#000000" opacity="0.3"/>
        <path d="M6.15999985,21.0604779 L8.15999985,17.5963763 C8.43614222,17.1180837 9.04773263,16.9542085 9.52602525,17.2303509 C10.0043179,17.5064933 10.168193,18.1180837 9.89205065,18.5963763 L7.89205065,22.0604779 C7.61590828,22.5387706 7.00431787,22.7026457 6.52602525,22.4265033 C6.04773263,22.150361 5.88385747,21.5387706 6.15999985,21.0604779 Z M17.8320512,21.0301278 C18.1081936,21.5084204 17.9443184,22.1200108 17.4660258,22.3961532 C16.9877332,22.6722956 16.3761428,22.5084204 16.1000004,22.0301278 L14.1000004,18.5660262 C13.823858,18.0877335 13.9877332,17.4761431 14.4660258,17.2000008 C14.9443184,16.9238584 15.5559088,17.0877335 15.8320512,17.5660262 L17.8320512,21.0301278 Z" fill="#000000" opacity="0.3"/>
        <path d="M20,10 L20,15 C20,16.6568542 18.6568542,18 17,18 L7,18 C5.34314575,18 4,16.6568542 4,15 L4,10 L5.86956522,10 L5.86956522,12 C5.86956522,13.6568542 7.21271097,15 8.86956522,15 L15.173913,15 C16.8307673,15 18.173913,13.6568542 18.173913,12 L18.173913,10 L20,10 Z" fill="#000000"/>
    </g>
</svg>
                            </div>
                        </div>
                        <div class="col">
                            <h2><span class="counter-value" data-target=""></span></h2>
                            <h6 class="text-muted mb-0">عدد المكاتب الإستشارية</h6>
                        </div>
                    </div> -->

                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col-->


    </div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>

var chart1 = {
    chart: {
        type: 'area',
        height: 160,
        sparkline: {
            enabled: true
        },
    },

    stroke: {
        curve: 'straight'
    },
    fill: {
        opacity: 1,
    },
  series: [{
    name: 'المجوع',
    data: @json(array_values($box_with_files_in))
  }],
  labels: @json(array_keys($box_with_files_in)),
  yaxis: {
    min: 0
  },
  xaxis: {
    type: 'datetime',
  },
  colors: ['#0A2373'],
  title: {
    text:'{{$count_box_with_files_in}}',
    offsetX: 0+'%',
    style: {
      fontSize: '24px',
      cssClass: 'apexcharts-yaxis-title px-4',
      fontFamily: 'JannaLT',
    }
  },
  subtitle: {
    text: ' المحاضر المسلمة لشركات حجاج الداخل',
    offsetX: 0+'%',
    style: {
      fontSize: '14px',
      cssClass: 'apexcharts-yaxis-title px-4',
      fontFamily: 'JannaLT',
      padding:"0px 20px"
    }
  }
}
new ApexCharts(document.querySelector("#chart-1"), chart1).render();

//




var chart2 = {
    chart: {
    type: 'area',
    height: 160,
    sparkline: {
      enabled: true
    },
  },

  stroke: {
    curve: 'straight'
  },
  fill: {
    opacity: 1,
  },
  series: [{
    name: 'المجوع',
    data: @json(array_values($box_with_files_out))
  }],
  labels: @json(array_keys($box_with_files_out)),
  yaxis: {
    min: 0
  },
  xaxis: {
    type: 'datetime',
  },
  colors: ['#0A2373'],
  title: {
    text: @json($count_box_with_files_out),
    offsetX: 0+'%',
    style: {
      fontSize: '24px',
      cssClass: 'apexcharts-yaxis-title px-4',
      fontFamily: 'JannaLT',
    }
  },
  subtitle: {
    text: 'المحاضر المسلمة لشركات حجاج الخارج',
    offsetX: 0+'%',
    style: {
      fontSize: '14px',
      cssClass: 'apexcharts-yaxis-title px-4',
      fontFamily: 'JannaLT',
      padding:"0px 20px"
    }
  }
}
new ApexCharts(document.querySelector("#chart-2"), chart2).render();


//







var chart3 = {
    chart: {
    type: 'area',
    height: 160,
    sparkline: {
      enabled: true
    },
  },

  stroke: {
    curve: 'straight'
  },
  fill: {
    opacity: 1,
  },
  series: [{
    name: 'المجوع',
    data: @json(array_values($count_actions_performed_per_day))
  }],
  labels:  @json(array_keys($count_actions_performed_per_day)),
  yaxis: {
    min: 0
  },
  xaxis: {
    type: 'datetime',
  },
  colors: ['#0A2373'],
  title: {
    text: @json($count_actions_performed),
    offsetX: 0+'%',
    style: {
      fontSize: '24px',
      cssClass: 'apexcharts-yaxis-title px-4',
      fontFamily: 'JannaLT',
    }
  },
  subtitle: {
    text: 'عدد الإجراءات المنفذة',
    offsetX: 0+'%',
    style: {
      fontSize: '14px',
      cssClass: 'apexcharts-yaxis-title px-4',
      fontFamily: 'JannaLT',
      padding:"0px 20px"
    }
  }
}
new ApexCharts(document.querySelector("#chart-3"), chart3).render();


//



var chart4 = {
    chart: {
    type: 'area',
    height: 160,
    sparkline: {
      enabled: true
    },
  },

  stroke: {
    curve: 'straight'
  },
  fill: {
    opacity: 1,
  },
  series: [{
    name: 'المجوع',
    data: @json(array_values($session_for_boxes))
  }],
  labels: @json(array_keys($session_for_boxes)),
  yaxis: {
    min: 0
  },
  xaxis: {
    type: 'datetime',
  },
  colors: ['#0A2373'],
  title: {
    text: '{{$session_count}}',
    offsetX: 0+'%',
    style: {
      fontSize: '24px',
      cssClass: 'apexcharts-yaxis-title px-4',
      fontFamily: 'JannaLT',
    }
  },
  subtitle: {
    text: 'المواعيد التي تم اطلاقها لإستلام المخيمات',
    offsetX: 0+'%',
    style: {
      fontSize: '14px',
      cssClass: 'apexcharts-yaxis-title px-4',
      fontFamily: 'JannaLT',
      padding:"0px 20px"
    }
  }
}
new ApexCharts(document.querySelector("#chart-4"), chart4).render();



//








var chart5 = {
    chart: {
    type: 'area',
    height: 160,
    sparkline: {
      enabled: true
    },
  },

  stroke: {
    curve: 'straight'
  },
  fill: {
    opacity: 1,
  },
  series: [{
    name: 'المجوع',
    data: @json(array_values($number_of_login_per_day))
  }],
  labels: @json(array_keys($number_of_login_per_day)),
  yaxis: {
    min: 0
  },
  xaxis: {
    type: 'datetime',
  },
  colors: ['#0A2373'],
  title: {
    text: '{{$number_of_login}}',
    offsetX: 0+'%',
    style: {
      fontSize: '24px',
      cssClass: 'apexcharts-yaxis-title px-4',
      fontFamily: 'JannaLT',
    }
  },
  subtitle: {
    text: 'مرات الدخول الى المنصة',
    offsetX: 0+'%',
    style: {
      fontSize: '14px',
      cssClass: 'apexcharts-yaxis-title px-4',
      fontFamily: 'JannaLT',
      padding:"0px 20px"
    }
  }
}
new ApexCharts(document.querySelector("#chart-5"), chart5).render();

var chart7 = {
    chart: {
    type: 'area',
    height: 160,
    sparkline: {
      enabled: true
    },
  },

  stroke: {
    curve: 'straight'
  },
  fill: {
    opacity: 1,
  },
  series: [{
    name: 'المجوع',
    data: @json(array_values($count_actions_outing_per_day))
  }],
  labels: @json(array_keys($count_actions_outing_per_day)),
  yaxis: {
    min: 0
  },
  xaxis: {
    type: 'datetime',
  },
  colors: ['#0A2373'],
  title: {
    text: '{{$count_actions_outing}}',
    offsetX: 0+'%',
    style: {
      fontSize: '24px',
      cssClass: 'apexcharts-yaxis-title px-4',
      fontFamily: 'JannaLT',
    }
  },
  subtitle: {
    text: 'عدد الطلبات الصادرة',
    offsetX: 0+'%',
    style: {
      fontSize: '14px',
      cssClass: 'apexcharts-yaxis-title px-4',
      fontFamily: 'JannaLT',
      padding:"0px 20px"
    }
  }
}
new ApexCharts(document.querySelector("#chart-7"), chart7).render();




//




var optionDonut = {
  chart: {
      type: 'donut',
      width: '100%',
      height: 250,
  },
    colors: ['#bf9370', '#8e6f50','#615036', '#745931','#663e00'],
    legend: {
      fontWeight: 400,
     formatter: function(seriesName, opts) {
        return '<div class="legend-info">' + '<span class="pe-2">' + seriesName + '</span>' + '<span class="text-dark font-size-18">' + opts.w.globals.series[opts.seriesIndex] + '</span>' + '</div>'
      }
    },
  series: @json(array_values($donat))
  ,
    dataLabels: {
      enabled: false,
    },
    labels: ['شركات الطوافة (حجاج الخارج) المسجلة', 'عدد شركات حجاج الداخل المسجلين', 'عدد المكاتب الهندسية المسجلة', 'عدد المقاولين المسجلين'],

     plotOptions: {
      pie: {
        donut: {
          labels: {
            show: true,
            name: {
              show: true,
              color: '#dfsda',
              offsetY: -10
            },
            value: {
              show: true,
              color: undefined,
              offsetY: 16,
              formatter: function (val) {
                return val
              }
            },
            total: {
              show: true,
              label: 'المجموع',
              color: '#373d3f',
              formatter: function (w) {
                return w.globals.seriesTotals.reduce((a, b) => {
                  return a + b
                }, 0)
              }
            }
          }
        }
      }
    },
}

var donut = new ApexCharts(
  document.querySelector("#chart-6"),
  optionDonut
)
donut.render();

</script>
@endsection
