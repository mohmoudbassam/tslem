
<?php $__env->startSection('title'); ?>
    الملف الشخصي
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<link rel="stylesheet" href="<?php echo e(url('/assets/libs/flatpickr/flatpickr.min.css')); ?>"/>
<style>
.file-preview {
    display: none;
}
</style>
    <?php if($errors->any()): ?>
        <div class="row">
            <div class="col-12">
                <div class="alert alert-danger" role="alert">
                    <ul class="m-0">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php if(session('success')): ?>
        <div class="row">
            <div class="col-12">
                <div class="alert alert-success" role="alert">
                    <li><?php echo e(session('success')); ?></li>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title m-0">تعديل الملف الشخصي</h1>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <form id="add_edit_form" method="post" action="<?php echo e(in_array(auth()->user()->verified, [0, 2]) ? route('after_reject'): route('save_profile')); ?>" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <div class="row">
                                <?php if($record->company_name): ?>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="company_name">اسم الشركة / المؤسسة<span
                                                    class="text-danger required-mark">*</span></label>
                                            <input type="text" class="form-control" id="company_name"
                                                   value="<?php echo e($user->company_name); ?>"  name="company_name"
                                                   placeholder="اسم الشركة / المؤسسة">
                                            <div class="col-12 text-danger" id="company_name_error"></div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if($record->company_owner_name): ?>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label required-field" for="company_owner_name">اسم المالك</label>
                                            <input type="text" class="form-control" value="<?php echo e($user->company_owner_name); ?>"
                                                   id="company_owner_name"
                                                   name="company_owner_name" placeholder="اسم المالك">
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if($record->id_number): ?>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="id_number">رقم هوية المالك<span
                                                    class="text-danger required-mark">*</span></label>
                                            <input type="text" class="form-control" value="<?php echo e($user->id_number); ?>" id="id_number"
                                                   name="id_number" onkeypress="return /[0-9]/i.test(event.key)" maxlength="10"
                                                   placeholder="رقم الهوية">
                                            <div class="col-12 text-danger" id="id_number_error"></div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if($record->commercial_record): ?>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label required-field" for="commercial_record"> رقم السجل التجاري</label>
                                            <input type="text" onkeypress="return /[0-9]/i.test(event.key)" class="form-control"
                                                   value="<?php echo e($user->commercial_record); ?>"
                                                   id="commercial_record" placeholder="xxxxxxxxx" name="commercial_record" minlength="10" maxlength="10">
                                            <div class="col-12 text-danger" id="commercial_record_error"></div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if($record->email): ?>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="email"> البريد الإلكتروني<span
                                                    class="text-danger required-mark">*</span></label>
                                            <input type="email" value="<?php echo e($user->email); ?>" class="form-control" id="email"
                                                   name="email"
                                                   placeholder="البريد الإلكتروني">
                                            <div class="col-12 text-danger" id="email_error"></div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if($record->phone): ?>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="phone">رقم الجوال<span class="text-danger required-mark">*</span></label>
                                            <input type="text" onkeypress="return /[0-9]/i.test(event.key)" value="<?php echo e($user->phone); ?>"
                                                   class="form-control" id="phone"
                                                   name="phone" minlength="10" maxlength="10"
                                                   placeholder="رقم الجوال">
                                            <div class="col-12 text-danger" id="phone_error"></div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if($record->telephone): ?>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="telephone">الهاتف<span class="text-danger required-mark">*</span></label>
                                            <input type="text" value="<?php echo e($user->telephone); ?>" class="form-control" id="telephone"
                                                   name="telephone"
                                                   placeholder="الهاتف">
                                            <div class="col-12 text-danger" id="telephone_error"></div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if($record->city): ?>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="city">المدينة<span
                                                    class="text-danger required-mark">*</span></label>
                                            <select class="form-control" id="city" name="city">
                                                <?php $__currentLoopData = citiesList(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cityItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($cityItem); ?>" <?php if($cityItem == $user->city): ?> selected <?php endif; ?>><?php echo e($cityItem); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                            <div class="col-12 text-danger" id="city_error"></div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if($record->commercial_file): ?>
                                    <div class="row m-0 p-0">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="commercial_file">السجل التحاري (PDF)</label>
                                                <input type="file" class="form-control"
                                                       id="commercial_file" name="commercial_file">
                                                <div class="col-12 text-danger" id="commercial_file_error"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="commercial_file_end_date">تاريخ انتهاء السجل التجاري</label>
                                                <input type="text" class="form-control flatpickr"
                                                       value="<?php echo e($user->commercial_file_end_date); ?>" id="commercial_file_end_date"
                                                       name="commercial_file_end_date">
                                                <div class="col-12 text-danger" id="commercial_file_end_date_error"></div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if($record->rating_certificate): ?>
                                    <div class="row m-0 p-0">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="rating_certificate">شهادة تصنيف بلدي (PDF)</label>
                                                <input type="file" class="form-control" id="rating_certificate" name="rating_certificate">
                                                <div class="col-12 text-danger" id="rating_certificate_error"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="rating_certificate_end_date">تاريخ الانتهاء</label>
                                                <input type="text" class="form-control flatpickr" id="rating_certificate_end_date"
                                                       name="rating_certificate_end_date"  value="<?php echo e($user->rating_certificate_end_date); ?>">
                                                <div class="col-12 text-danger" id="rating_certificate_end_date_error"></div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if($record->address_file): ?>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="address_file">العنوان الوطني (PDF)</label>
                                            <input type="file" class="form-control" name="address_file" id="address_file">
                                            <div class="col-12 text-danger" id="address_file_error"></div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if($record->profession_license): ?>
                                    <div class="row m-0 p-0">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="profession_license">شهادة مزاولة المهنة (PDF)</label>
                                                <input type="file" class="form-control" id="profession_license" name="profession_license">
                                                <div class="col-12 text-danger" id="profession_license_error"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="profession_license_end_date">تاريخ الانتهاء</label>
                                                <input type="text" class="form-control flatpickr" id="profession_license_end_date"
                                                       name="profession_license_end_date" value="<?php echo e($user->profession_license_end_date); ?>">
                                                <div class="col-12 text-danger" id="profession_license_date_end_error"></div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if($record->business_license): ?>
                                    <div class="row m-0 p-0">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="business_license">رخصة نشاط تجاري (PDF)</label>
                                                <input type="file" class="form-control" name="business_license" id="business_license">
                                                <div class="col-12 text-danger" id="business_license_error"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="business_license_end_date">تاريخ الانتهاء</label>
                                                <input type="text" class="form-control flatpickr" id="business_license_end_date"
                                                       name="business_license_end_date" value="<?php echo e($user->business_license_end_date); ?>">
                                                <div class="col-12 text-danger" id="business_license_end_date_error"></div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if($record->social_insurance_certificate): ?>
                                    <div class="row m-0 p-0">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="social_insurance_certificate">رخصة التأمينات
                                                    الإجتماعية (PDF)</label>
                                                <input type="file" class="form-control" id="social_insurance_certificate"
                                                       name="social_insurance_certificate">
                                                <div class="col-12 text-danger" id="social_insurance_certificate_error"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="social_insurance_certificate_end_date">تاريخ
                                                    الانتهاء</label>
                                                <input type="text" class="form-control flatpickr" value="<?php echo e($user->social_insurance_certificate_end_date); ?>"
                                                       id="social_insurance_certificate_end_date" name="social_insurance_certificate_end_date">
                                                <div class="col-12 text-danger" id="social_insurance_certificate_end_date_error"></div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if($record->certificate_of_zakat): ?>
                                    <div class="row m-0 p-0">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="certificate_of_zakat">رخصة الزكاة والدخل (PDF)</label>
                                                <input type="file" class="form-control" id="certificate_of_zakat"
                                                       name="certificate_of_zakat">
                                                <div class="col-12 text-danger" id="certificate_of_zakat_error"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="date_of_zakat_end_date">تاريخ الانتهاء</label>
                                                <input type="text" class="form-control flatpickr" id="date_of_zakat_end_date"
                                                       name="date_of_zakat_end_date" value="<?php echo e($user->date_of_zakat_end_date); ?>">
                                                <div class="col-12 text-danger" id="date_of_zakat_end_date_error"></div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if($record->saudization_certificate): ?>
                                    <div class="row m-0 p-0">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="saudization_certificate">شهادة السعودة (PDF)</label>
                                                <input type="file" class="form-control" id="saudization_certificate"
                                                       name="saudization_certificate">
                                                <div class="col-12 text-danger" id="saudization_certificate_error"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="saudization_certificate_end_date">تاريخ الانتهاء</label>
                                                <input type="text" class="form-control flatpickr" id="saudization_certificate_end_date"
                                                       name="saudization_certificate_end_date" value="<?php echo e($user->saudization_certificate_end_date); ?>">
                                                <div class="col-12 text-danger" id="saudization_certificate_end_date_error"></div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if($record->chamber_of_commerce_certificate): ?>
                                    <div class="row m-0 p-0">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="chamber_of_commerce_certificate">شهادة الغرفة
                                                    التجارية (PDF)</label>
                                                <input type="file" class="form-control" id="chamber_of_commerce_certificate"
                                                       name="chamber_of_commerce_certificate">
                                                <div class="col-12 text-danger" id="chamber_of_commerce_certificate_error"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="chamber_of_commerce_certificate_end_date">تاريخ
                                                    الانتهاء</label>
                                                <input type="text" class="form-control flatpickr" value="<?php echo e($user->chamber_of_commerce_certificate_end_date); ?>"
                                                       id="chamber_of_commerce_certificate_end_date"
                                                       name="chamber_of_commerce_certificate_end_date">
                                                <div class="col-12 text-danger" id="chamber_of_commerce_certificate_end_date_error"></div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if($record->tax_registration_certificate): ?>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="tax_registration_certificate">شهادة تسجيل الضريبة
                                                (PDF)</label>
                                            <input type="file" class="form-control" id="tax_registration_certificate"
                                                   name="tax_registration_certificate">
                                            <div class="col-12 text-danger" id="tax_registration_certificate_error"></div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if($record->wage_protection_certificate): ?>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="wage_protection_certificate">شهادة حماية الأجور (PDF)</label>
                                            <input type="file" class="form-control" id="wage_protection_certificate"
                                                   name="wage_protection_certificate">
                                            <div class="col-12 text-danger" id="wage_protection_certificate_error"></div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if($record->memorandum_of_association): ?>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="memorandum_of_association"> عقد التأسيس (PDF)</label>
                                            <input type="file" class="form-control" id="memorandum_of_association"
                                                   name="memorandum_of_association">
                                            <div class="col-12 text-danger" id="memorandum_of_association_error"></div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if($record->type == 'contractor'): ?>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="previous_works">الاعمال السابقة (PDF)</label>
                                            <input type="file" class="form-control" id="previous_works"
                                                   name="previous_works">
                                            <div class="col-12 text-danger" id="previous_works_error"></div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <?php if($record->company_owner_id_photo): ?>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="company_owner_id_photo"> صورة هوية  المالك (PDF)</label>
                                            <input type="file" class="form-control" id="company_owner_id_photo"
                                                   name="company_owner_id_photo">
                                            <div class="col-12 text-danger" id="company_owner_id_photo_error"></div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if($record->commissioner_id_photo): ?>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="commissioner_id_photo"> صورة هوية  المفوض (PDF)</label>
                                            <input type="file" class="form-control" id="commissioner_id_photo"
                                                   name="commissioner_id_photo">
                                            <div class="col-12 text-danger" id="commissioner_id_photo_error"></div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if($record->commissioner_photo): ?>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="commissioner_photo"> صورة التفويض (PDF)</label>
                                            <input type="file" class="form-control" id="commissioner_photo"
                                                   name="commissioner_photo">
                                            <div class="col-12 text-danger" id="commissioner_photo_error"></div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex flex-wrap gap-3">
                        <button type="submit" class="btn btn-lg btn-primary submit_btn" form="add_edit_form">تعديل</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>

    <script>
        <?php $__currentLoopData = array_keys($col_file); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $_col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($user->{$_col}): ?>
                file_input('#<?php echo e($_col); ?>', {
                    initialPreview: '<?php echo e(asset('storage/'.$user->{$_col})); ?>',
                });
            <?php else: ?>
                file_input('#<?php echo e($_col); ?>');
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


        $('#add_edit_form').validate({
            rules: {
                <?php $__currentLoopData = array_filter($record->makeHidden(['id','type'])->toArray()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rule=> $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(!$user->{$rule}): ?>
                "<?php echo e("$rule"); ?>": {
                    required: true,
                },
                <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            },
            "id_number": {
                minlength: 10,
                maxlength: 10,
                required: true
            },
            "commercial_record": {
                minlength: 10,
                maxlength: 10,
                required: true,
                number: true
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

            $('#add_edit_form').submit()

        });

        flatpickr(".flatpickr");
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('CP.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\taslem\resources\views/CP/users/edit_profile.blade.php ENDPATH**/ ?>