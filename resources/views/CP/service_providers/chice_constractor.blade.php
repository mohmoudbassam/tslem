<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">

        <div class="modal-header">
            <h5 class="modal-title"
                id="exampleModalLongTitle">اعتماد الطلب</h5>

        </div>
        <form action="'{{route('services_providers.choice_constructor_action')}}'" method="post" id="add_edit_form" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-lg-12 col-md-6 col-sm-12">
                        <div class="row">
                            <label class="col-12" for="reject_reason">اختر المقاول</label>
                            <div class="col-12">
                                <select class="form-control" name="contractor_id" id="contractor_id">
                                    <option value="">اختر ...</option>
                                    @foreach($contractors as $user)
                                        <option value="{{ $user->id }}">{{ $user->company_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 text-danger" id="contractor_id_error"></div>
                        </div>
                    </div>
                    <div class="form-group col-lg-12 col-md-6 col-sm-12">
                        <div class="row">
                            <label class="col-12" for="reject_reason">اختر المشرف</label>
                            <div class="col-12">
                                <select class="form-control" name="consulting_office_id" id="consulting_office_id">
                                    <option value="">اختر ...</option>
                                    @foreach($consulting_offices as $user)
                                        <option value="{{ $user->id }}">{{ $user->company_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 text-danger" id="consulting_office_id_error"></div>
                        </div>
                    </div>
                    <div class="form-group col-lg-12 col-md-6 col-sm-12">
                        <div class="row">
                            <label class="col-12" for="waste_contractor">اختر مقاول النفايات</label>
                            <div class="col-12">
                                <select class="form-control" name="waste_contractor" id="waste_contractor">
                                    <option value="">اختر ...</option>
                                    @foreach($waste_contractors as $wasteContractor)
                                        <option value="{{ $wasteContractor['name'] }}">{{ $wasteContractor['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 text-danger" id="waste_contractor_error"></div>
                        </div>
                    </div>

                </div>
            </div>
            <input type="hidden" name="id" value="{{$order->id}}">
            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">الغاء</button>
                <button type="button" class="btn btn-primary submit_btn">اعتماد</button>
            </div>
        </form>
    </div>
</div>

<script>
    $('#add_edit_form').validate({
        rules: {
            "contractor_id": {
                required: true,
            },
            "consulting_office_id": {
                required: true,
            },
            "waste_contractor": {
                required: true,
            }
        },
        errorElement: 'span',
        errorClass: 'help-block help-block-error',
        focusInvalid: true,
        errorPlacement: function (error, element) {
            $(element).addClass("is-invalid");
            error.appendTo('#' + $(element).attr('id') + '_error');
        },
        success: function (label, element) {

            $(element).removeClass("is-invalid");
        }
    });

    $('.submit_btn').click(function (e) {
        e.preventDefault();

        if (!$("#add_edit_form").valid())
            return false;


        postData(new FormData($('#add_edit_form').get(0)), '{{route('services_providers.choice_constructor_action')}}');

    });
</script>
