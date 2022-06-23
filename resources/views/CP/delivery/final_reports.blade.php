<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <div class="h3">التقارير النهائية</div>
            <div>
                @include('CP.order.final_report_button', ['order' => $order, 'pass' => $order->shouldPostFinalReports() && $order->shouldUserPostFinalReports()])
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
                @foreach(($final_reports ?? []) as $final_report)
                <div class="col-md-6 col-sm-12">
                    @include('CP.order.final_report_card', $final_report ?? [])
                </div>
                @endforeach
        </div>
    </div>

</div>
<div
    class="modal  bd-example-modal-lg"
    id="page_modal"
    data-backdrop="static"
    data-keyboard="false"
    role="dialog"
    aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true"
></div>

@push('css')
    <style>

        .file-view-wrapper:hover {
            box-shadow: var(--bs-box-shadow) !important;
        }

        .file-view-icon {
            height: 200px;
            background-size: 50%;
            background-position: center;
            background-repeat: no-repeat;
        }

        .file-view-wrapper {
            position: relative;
        }

        .file-view-download {
            position: absolute;
            top: 9px;
            left: 11px;
            font-size: 18px;
            color: #0b2473;
        }
    </style>
@endpush
@push('js')
    <script>
        $(function () {
        })

    </script>
@endpush
