<?php $__env->startSection('title'); ?>
    انشاء مستخدم
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">


                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">انشاء مستخدم</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo e(route('users')); ?>">المستخدمين</a></li>
                        <li class="breadcrumb-item active">الرئيسية</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="row mt-4">
                <div class="col-lg-12">

                    <h4>
                        إنشاء مستخدم جديد
                    </h4>
                </div>

            </div>
        </div>
        <div class="card-body">
            <form id="add_edit_form" method="post" action="<?php echo e(route('users.add_edit')); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="row">

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="type">نوع المستخدم</label>
                            <select class="form-select" id="type" name="type">
                                <option <?php if($record->type =="admin"): ?> selected <?php endif; ?> value="admin">مدير نظام</option>
                                <option <?php if($record->type =="service_provider"): ?> selected
                                        <?php endif; ?> value="service_provider">مقدم خدمة
                                </option>
                                <option <?php if($record->type =="design_office"): ?> selected <?php endif; ?> value="design_office">مكتب
                                    تصميم
                                </option>
                                <option <?php if($record->type =="Sharer"): ?> selected <?php endif; ?> value="Sharer">جهة مشاركة</option>
                                <option <?php if($record->type =="consulting_office"): ?> selected
                                        <?php endif; ?>  value="consulting_office">مكتب استشاري
                                </option>
                                <option <?php if($record->type =="contractor"): ?> selected <?php endif; ?>  value="contractor">مقاول
                                </option>
                                <option <?php if($record->type =="Delivery"): ?> selected <?php endif; ?> value="Delivery">تسليم</option>
                                <option <?php if($record->type =="Kdana"): ?> selected <?php endif; ?> value="Kdana">كدانة</option>
                            </select>

                        </div>

                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="name">الإسم</label>
                            <input type="text" class="form-control" name="name" value="<?php echo e(old('name')); ?>" id="name"
                                   placeholder="الإسم">
                            <div class="col-12 text-danger" id="name_error"></div>
                        </div>
                    </div>

                    <?php if($record->company_name): ?>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="company_name">اسم الشركة / المؤسسة</label>
                                <input type="text" class="form-control" id="company_name"
                                       value="<?php echo e(old('company_name')); ?>" name="company_name"
                                       placeholder="اسم الشركة / المؤسسة">
                                <div class="col-12 text-danger" id="company_name_error"></div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if($record->company_type): ?>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="company_type">نوع الشركة</label>
                                <select class="form-select" id="company_type" name="company_type">
                                    <option value="">اختر...</option>
                                    <option <?php if(old('company_type')=='organization'): ?> selected
                                            <?php endif; ?> value="organization">مؤسسة
                                    </option>
                                    <option <?php if(old('company_type')=='office'): ?> selected <?php endif; ?> value="office">مكتب
                                    </option>
                                </select>
                                <div class="col-12 text-danger" id="company_type_error"></div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if($record->company_owner_name): ?>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="company_owner_name">اسم صاحب الشركة</label>
                                <input type="text" class="form-control" value="<?php echo e(old('company_owner_name')); ?>"
                                       id="company_owner_name"
                                       name="company_owner_name" placeholder="اسم صاحب الشركة">
                                <div class="col-12 text-danger" id="company_owner_name_error"></div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if($record->commercial_record): ?>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="commercial_record"> رقم السجل التجاري</label>
                                <input type="text" class="form-control" value="<?php echo e(old('commercial_record')); ?>"
                                       id="commercial_record" name="commercial_record"
                                       placeholder="رقم السجل التجاري">
                                <div class="col-12 text-danger" id="commercial_record_error"></div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if($record->website): ?>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="website">الموقع</label>
                                <input type="text" class="form-control" value="<?php echo e(old('website')); ?>" id="website"
                                       name="website"
                                       placeholder="الموقع">
                                <div class="col-12 text-danger" id="website_error"></div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if($record->responsible_name): ?>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="responsible_name">اسم الشخص المسؤول</label>
                                <input type="text" class="form-control" value="<?php echo e(old('responsible_name')); ?>"
                                       id="responsible_name" name="responsible_name"
                                       placeholder="اسم الشخص المسؤول">
                                <div class="col-12 text-danger" id="responsible_name_error"></div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if($record->id_number): ?>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="id_number">رقم الهوية</label>
                                <input type="text" class="form-control" value="<?php echo e(old('id_number')); ?>" id="id_number"
                                       name="id_number"
                                       placeholder="رقم الهوية">
                                <div class="col-12 text-danger" id="id_number_error"></div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if($record->id_date): ?>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="id_date">التاريخ</label>
                                <input type="date" class="form-control" value="<?php echo e(old('id_date')); ?>" id="id_date"
                                       name="id_date"
                                       placeholder="التاريخ">
                                <div class="col-12 text-danger" id="id_date_error"></div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if($record->source): ?>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="source">المصدر</label>
                                <input type="text" class="form-control" value="<?php echo e(old('source')); ?>" id="source"
                                       name="source" placeholder="المصدر">
                                <div class="col-12 text-danger" id="id_date_error"></div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if($record->email): ?>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="email">البريد الإلكتروني</label>
                                <input type="text" value="<?php echo e(old('email')); ?>" class="form-control" id="email" name="email"
                                       placeholder="البريد الإلكتروني">
                                <div class="col-12 text-danger" id="email_error"></div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if($record->phone): ?>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="phone">رقم الجوال</label>
                                <input type="number" value="<?php echo e(old('phone')); ?>" class="form-control" id="phone"
                                       name="phone"
                                       placeholder="رقم الجوال">
                                <div class="col-12 text-danger" id="phone_error"></div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if($record->address): ?>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="address">العنوان الوطني</label>
                                <input type="text" class="form-control" value="<?php echo e(old('address')); ?>" id="address"
                                       name="address"
                                       placeholder="العنوان الوطني">
                                <div class="col-12 text-danger" id="address_error"></div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if($record->telephone): ?>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="telephone">الهاتف</label>
                                <input type="number" value="<?php echo e(old('telephone')); ?>" class="form-control" id="telephone"
                                       name="telephone"
                                       placeholder="الهاتف">
                                <div class="col-12 text-danger" id="telephone_error"></div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if($record->city): ?>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="city">المدينة</label>
                                <input type="text" value="<?php echo e(old('city')); ?>" class="form-control" id="city" name="city"
                                       placeholder="المدينة">
                                <div class="col-12 text-danger" id="city_error"></div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if($record->employee_number): ?>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="employee_number">عدد الموظفين</label>
                                <input type="number" class="form-control" value="<?php echo e(old('employee_number')); ?>"
                                       id="employee_number" name="employee_number"
                                       placeholder="عدد الموظفين">
                                <div class="col-12 text-danger" id="employee_number_error"></div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="password">كلمة المرور</label>
                            <input type="password" class="form-control" id="password"  value="<?php echo e(old('password')); ?>" name="password">
                            <div class="col-12 text-danger" id="password_error"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="password_confirmation">تأكيد كلمة المرور</label>
                            <input type="password" class="form-control" value="<?php echo e(old('password_confirmation')); ?>"  id="password_confirmation"
                                   name="password_confirmation">
                            <div class="col-12 text-danger" id="password_confirmation_error"></div>
                        </div>
                    </div>
                </div>

                <?php if($record->commercial_file): ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="commercial_file">السجل التحاري</label>
                                <input type="file" class="form-control" value="<?php echo e(old('commercial_file')); ?>" id="commercial_file" name="commercial_file">
                                <div class="col-12 text-danger" id="commercial_file_error"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="commercial_date_end">تاريخ أنتهاء السجل التجاري</label>
                                <input type="date" class="form-control" value="<?php echo e(old('commercial_date_end')); ?>" id="commercial_date_end" name="commercial_date_end">
                                <div class="col-12 text-danger" id="commercial_date_end_error"></div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if($record->rating_certificate): ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="rating_certificate">شهادة تصنيف بلدي</label>
                                <input type="file" class="form-control" id="rating_certificate" name="rating_certificate">
                                <div class="col-12 text-danger" id="rating_certificate_error"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="rating_certificate_date_end">تاريخ الانتهاء</label>
                                <input type="date" class="form-control" id="rating_certificate_date_end" name="rating_certificate_date_end">
                                <div class="col-12 text-danger" id="rating_certificate_date_end_error"></div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if($record->address_file): ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="address_file">العنوان الوطني</label>
                                <input type="file" class="form-control" id="address_file" name="address_file">
                                <div class="col-12 text-danger" id="address_file_error"></div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if($record->profession_license): ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="profession_license">شهادة مزاولة المهنة</label>
                                <input type="file" class="form-control" id="profession_license" name="profession_license">
                                <div class="col-12 text-danger" id="profession_license_error"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="profession_license_date_end">تاريخ الانتهاء</label>
                                <input type="date" class="form-control" id="profession_license_date_end" name="profession_license_date_end">
                                <div class="col-12 text-danger" id="profession_license_date_end_error"></div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if($record->business_license_end_date): ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="business_license">رخصة نشاط تجاري</label>
                                <input type="file" class="form-control" id="business_license" name="business_license">
                                <div class="col-12 text-danger" id="business_license_error"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="business_license_end_date">تاريخ الانتهاء</label>
                                <input type="date" class="form-control" id="business_license_end_date" name="business_license_end_date">
                                <div class="col-12 text-danger" id="business_license_end_date_error"></div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?> <?php if($record->social_insurance_certificate): ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="social_insurance_certificate">رخصة التأمينات الإجتماعية</label>
                                <input type="file" class="form-control" id="social_insurance_certificate" name="social_insurance_certificate">
                                <div class="col-12 text-danger" id="social_insurance_certificate_error"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="social_insurance_certificate_end_date">تاريخ الانتهاء</label>
                                <input type="date" class="form-control" id="social_insurance_certificate_end_date" name="social_insurance_certificate_end_date">
                                <div class="col-12 text-danger" id="social_insurance_certificate_end_date_error"></div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if($record->certificate_of_zakat): ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="certificate_of_zakat">رخصة الزكاة والدخل</label>
                                <input type="file" class="form-control" id="certificate_of_zakat" name="certificate_of_zakat">
                                <div class="col-12 text-danger" id="certificate_of_zakat_error"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="date_of_zakat_end_date">تاريخ الانتهاء</label>
                                <input type="date" class="form-control" id="date_of_zakat_end_date" name="date_of_zakat_end_date">
                                <div class="col-12 text-danger" id="date_of_zakat_end_date_error"></div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if($record->certificate_of_zakat): ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="saudization_certificate">شهادة السعودة</label>
                                <input type="file" class="form-control" id="saudization_certificate" name="saudization_certificate">
                                <div class="col-12 text-danger" id="saudization_certificate_error"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="saudization_certificate_end_date">تاريخ الانتهاء</label>
                                <input type="date" class="form-control" id="saudization_certificate_end_date" name="saudization_certificate_end_date">
                                <div class="col-12 text-danger" id="saudization_certificate_end_date_error"></div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if($record->certificate_of_zakat): ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="chamber_of_commerce_certificate">شهادة الغرفة التجارية</label>
                                <input type="file" class="form-control" id="chamber_of_commerce_certificate" name="chamber_of_commerce_certificate">
                                <div class="col-12 text-danger" id="chamber_of_commerce_certificate_error"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="chamber_of_commerce_certificate_end_date">تاريخ الانتهاء</label>
                                <input type="date" class="form-control" id="chamber_of_commerce_certificate_end_date" name="chamber_of_commerce_certificate_end_date">
                                <div class="col-12 text-danger" id="chamber_of_commerce_certificate_end_date_error"></div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if($record->tax_registration_certificate): ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="tax_registration_certificate">شهادة تسجيل الضريبة</label>
                                <input type="file" class="form-control" id="tax_registration_certificate" name="tax_registration_certificate">
                                <div class="col-12 text-danger" id="tax_registration_certificate_error"></div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if($record->wage_protection_certificate): ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="wage_protection_certificate">شهادة حماية الأجور</label>
                                <input type="file" class="form-control" id="wage_protection_certificate" name="wage_protection_certificate">
                                <div class="col-12 text-danger" id="wage_protection_certificate_error"></div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if($record->memorandum_of_association): ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="memorandum_of_association">شهادة حماية الأجور</label>
                                <input type="file" class="form-control" id="memorandum_of_association" name="memorandum_of_association">
                                <div class="col-12 text-danger" id="memorandum_of_association_error"></div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </form>

            <div class="d-flex flex-wrap gap-3">
                <button type="button" class="btn btn-lg btn-primary submit_btn">إنشاء</button>
            </div>

            <?php if($errors->any()): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>

    </div>

    <div class="modal  bd-example-modal-lg" id="page_modal" data-backdrop="static" data-keyboard="false"
         role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script>
        <?php if($record->commercial_file): ?>

        <?php endif; ?>
        $('#add_edit_form').validate({
            rules: {
                "name": {
                    required: true,
                }, "password": {
                    required: true,
                }, "password_confirmation": {
                    required: true,
                },
                <?php $__currentLoopData = array_filter($record->makeHidden(['id','type'])->toArray()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rule=> $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                "<?php echo e("$rule"); ?>": {
                    required: true,
                },
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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


        $('#type').change(function (e) {
            window.location = '<?php echo e(route('users.get_form')); ?>?type=' + $(this).val()
        });
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('CP.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ahmedsal/workspace/tslem/resources/views/CP/users/form.blade.php ENDPATH**/ ?>