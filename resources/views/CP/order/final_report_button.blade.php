@php
    $_title = __('models/final_report.' . (($has_file ?? false) ? 'reattach_final_report' : 'attach_final_report'));
@endphp

@if($order->userCanAttachFinalReport())
<div class="btn-group btn-group-justified">
    @if(in_array($order->status,[$order::PENDING_OPERATION, $order::FINAL_REPORT_ATTACHED]) && ($pass ?? true))
        <a id="final-report-button" class="btn btn-primary final-report-button" href="#">
            <i class="fa fa-plus pe-2"></i>
            {{$_title}}
        </a>
    @endif
</div>
@endif

<div class="modal fade" id="final-report-modal" tabindex="-1" role="dialog" aria-labelledby="final-report-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="final-report-modal-title">
                    {{$_title}}
                </h5>
            </div>
            <div class="modal-body">
                <div class="row my-4" id="file-view-row"></div>
            </div>
            <div class="modal-footer">
                <button type="button" id="close-final-report-modal" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        $(function () {
            $("#close-final-report-modal").on("click", function () {
                $("#final-report-modal").modal("hide");
            })

            $('.final-report-button').click(function (e) {
                e.preventDefault()
                showModal('{{route('licenses.final_report_form', ['order'=>$order->id])}}', null, '#final-report-modal')

                return false;
            })
        })
    </script>
@endpush
