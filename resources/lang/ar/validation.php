<?php
return [
    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */
    'accepted'        => 'يجب قبول :attribute.',
    'active_url'      => ':attribute لا يُمثّل رابطًا صحيحًا.',
    'after'           => 'يجب على :attribute أن يكون تاريخًا لاحقًا للتاريخ :date.',
    'after_or_equal'  => ':attribute يجب أن يكون تاريخاً لاحقاً أو مطابقاً لتاريخ اليوم.',
    'alpha'           => 'يجب أن لا يحتوي :attribute سوى على حروف.',
    'alpha_dash'      => 'يجب أن لا يحتوي :attribute سوى على حروف، أرقام ومطّات.',
    'alpha_num'       => 'يجب أن يحتوي :attribute على حروفٍ وأرقامٍ فقط.',
    'array'           => 'يجب أن يكون :attribute ًمصفوفة.',
    'before'          => 'يجب على :attribute أن يكون تاريخًا سابقًا للتاريخ :date.',
    'before_or_equal' => ':attribute يجب أن يكون تاريخا سابقا أو مطابقا للتاريخ :date.',
    'between'         => [
        'numeric' => 'يجب أن تكون قيمة :attribute بين :min و :max.',
        'file'    => 'يجب أن يكون حجم الملف :attribute بين :min و :max كيلوبايت.',
        'string'  => 'يجب أن يكون عدد حروف النّص :attribute بين :min و :max.',
        'array'   => 'يجب أن يحتوي :attribute على عدد من العناصر بين :min و :max.',
    ],
    'boolean'         => 'يجب أن تكون قيمة :attribute إما true أو false .',
    'confirmed'       => 'حقل التأكيد غير مُطابق للحقل :attribute.',
    'date'            => ':attribute ليس تاريخًا صحيحًا.',
    'date_equals'     => 'يجب أن يكون :attribute مطابقاً للتاريخ :date.',
    'date_format'     => 'لا يتوافق :attribute مع الشكل :format.',
    'different'       => 'يجب أن يكون الحقلان :attribute و :other مُختلفين.',
    'digits'          => 'يجب أن يحتوي :attribute على :digits رقمًا/أرقام.',
    'digits_between'  => 'يجب أن يحتوي :attribute بين :min و :max رقمًا/أرقام .',
    'dimensions'      => 'الـ :attribute يحتوي على أبعاد صورة غير صالحة.',
    'distinct'        => 'للحقل :attribute قيمة مُكرّرة.',
    'email'           => 'يجب أن يكون :attribute عنوان بريد إلكتروني صحيح البُنية.',
    'exists'          => 'قيمة :attribute المحددة غير موجودة.',
    'file'            => 'الـ :attribute يجب أن يكون ملفا.',
    'filled'          => ':attribute إجباري.',
    'gt'              => [
        'numeric' => 'يجب أن تكون قيمة :attribute أكبر من :value.',
        'file'    => 'يجب أن يكون حجم الملف :attribute أكبر من :value كيلوبايت.',
        'string'  => 'يجب أن يكون طول النّص :attribute أكثر من :value حروفٍ/حرفًا.',
        'array'   => 'يجب أن يحتوي :attribute على أكثر من :value عناصر/عنصر.',
    ],
    'gte'             => [
        'numeric' => 'يجب أن تكون قيمة :attribute مساوية أو أكبر من :value.',
        'file'    => 'يجب أن يكون حجم الملف :attribute على الأقل :value كيلوبايت.',
        'string'  => 'يجب أن يكون طول النص :attribute على الأقل :value حروفٍ/حرفًا.',
        'array'   => 'يجب أن يحتوي :attribute على الأقل على :value عُنصرًا/عناصر.',
    ],
    'image'           => 'يجب أن يكون :attribute صورةً.',
    'in'              => ':attribute غير موجود.',
    'in_array'        => ':attribute غير موجود في :other.',
    'integer'         => 'يجب أن يكون :attribute عددًا صحيحًا.',
    'ip'              => 'يجب أن يكون :attribute عنوان IP صحيحًا.',
    'ipv4'            => 'يجب أن يكون :attribute عنوان IPv4 صحيحًا.',
    'ipv6'            => 'يجب أن يكون :attribute عنوان IPv6 صحيحًا.',
    'json'            => 'يجب أن يكون :attribute نصآ من نوع JSON.',
    'lt'              => [
        'numeric' => 'يجب أن تكون قيمة :attribute أصغر من :value.',
        'file'    => 'يجب أن يكون حجم الملف :attribute أصغر من :value كيلوبايت.',
        'string'  => 'يجب أن يكون طول النّص :attribute أقل من :value حروفٍ/حرفًا.',
        'array'   => 'يجب أن يحتوي :attribute على أقل من :value عناصر/عنصر.',
    ],
    'lte'             => [
        'numeric' => 'يجب أن تكون قيمة :attribute مساوية أو أصغر من :value.',
        'file'    => 'يجب أن لا يتجاوز حجم الملف :attribute :value كيلوبايت.',
        'string'  => 'يجب أن لا يتجاوز طول النّص :attribute :value حروفٍ/حرفًا.',
        'array'   => 'يجب أن لا يحتوي :attribute على أكثر من :value عناصر/عنصر.',
    ],
    'max'             => [
        'numeric' => 'يجب أن تكون قيمة :attribute مساوية أو أصغر من :max.',
        'file'    => 'يجب أن لا يتجاوز حجم الملف :attribute :max كيلوبايت.',
        'string'  => 'يجب أن لا يتجاوز طول النّص :attribute :max حروفٍ/حرفًا.',
        'array'   => 'يجب أن لا يحتوي :attribute على أكثر من :max عناصر/عنصر.',
    ],
    'mimes'           => 'يجب أن يكون ملفًا من نوع : :values.',
    'mimetypes'       => 'يجب أن يكون ملفًا من نوع : :values.',
    'min'             => [
        'numeric' => 'يجب أن تكون قيمة :attribute مساوية أو أكبر من :min.',
        'file'    => 'يجب أن يكون حجم الملف :attribute على الأقل :min كيلوبايت.',
        'string'  => 'يجب أن يكون طول النص :attribute على الأقل :min حروفٍ/حرفًا.',
        'array'   => 'يجب أن يحتوي :attribute على الأقل على :min عُنصرًا/عناصر.',
    ],
    'not_in'          => ':attribute موجود.',
    'not_regex'       => 'صيغة :attribute غير صحيحة.',
    'numeric'         => 'يجب على :attribute أن يكون رقمًا.',
    'present'         => 'يجب تقديم :attribute.',
    'regex'           => 'صيغة :attribute .غير صحيحة.',
    'required'        => ':attribute مطلوب.',


    'required_CHARGE'                => 'حقل سعر النقل مطلوب',
    'required_EMAIL'                 => 'حقل البريد الالكتروني للنظام مطلوب',
    'required_MOBILE'                => 'حقل رقم الهاتف الخاص بالنظام مطلوب',
    'required_title_ar'              => 'حقل العنوان باللغة العربية مطلوب',
    'required_title_en'              => 'حقل العنوان باللغة العربية مطلوب',
    'required_name_ar'               => 'حقل الاسم باللغة العربية مطلوب',
    'required_name_en'               => 'حقل الاسم باللغة الانجليزية مطلوب',
    'required_description_ar'        => 'حقل الوصف باللغة العربية مطلوب',
    'required_description_en'        => 'حقل الوصف باللغة الانجليزية مطلوب',
    'required_new_password'          => 'حقل كلمة المرور الجديدة مطلوب',
    'required_name'                  => 'حقل الاسم مطلوب',
    'required_color'                 => 'حقل لون الخفية مطلوب',
    'required_font_color'            => 'حقل لون الخط مطلوب',
    'required_image'                 => 'حقل الصورة مطلوب',
    'image_image'                    => 'حقل الصورة يجب ان يحوي على صورة',
    'required_email'                 => 'حقل البريد الالكتروني مطلوب',
    'valid_email'                    => 'حقل البريد الالكتروني يجب ان يحوي على بريد الكتروني صحيح',
    'required_password'              => 'حقل كلمة المرور مطلوب',
    'password_min8'                  => 'حقل كلمة المرور يجب ان يحوي على 8 رموز على الاقل',
    'required_password_confirmation' => 'حقل تأكيد كلمة المرور مطلوب',
    'password_confirmation'          => 'حقل تأكيد كلمة المرور يجب ان يطابق حقل كلمة المرور',
    'required_product_id'            => 'حقل المنتج مطلوب',
    'required_price'                 => 'حقل سعر المنتج مطلوب',
    'required_range'                 => 'حقل فترة العرض مطلوب',
    'price_double'                   => 'حقل سعر المنتج يجب ان يكون رقم',
    'price_min'                      => 'حقل سعر المنتج يجب ان يكون اكبر من 0',
    'price_max'                      => 'حقل سعر المنتج بعد العرض يجب ان يكون اقل من سعره قبل العرض',
    'required_mobile'                => 'حقل رقم الهاتف مطلوب',
    'required_age'                   => 'حقل العمر مطلوب',
    'age_min'                        => 'حقل العمر يجب الا يكون اقل من 0',
    'required_location'              => 'حقل الموقع مطلوب',
    'required_product_price'         => 'حقل السعر مطلوب',
    'required_product_quantity'      => 'حقل الكمية مطلوب',
    'product_quantity_min'           => 'حقل الكمية يجب ان يكون اكبر من 0',
    'product_price_min'              => 'حقل السعر يجب ان يكون اكبر من 0',


    'required_if'          => ':attribute مطلوب في حال ما إذا كان :other يساوي :value.',
    'required_unless'      => ':attribute مطلوب في حال ما لم يكن :other يساوي :values.',
    'required_with'        => ':attribute مطلوب إذا توفّر :values.',
    'required_with_all'    => ':attribute مطلوب إذا توفّر :values.',
    'required_without'     => ':attribute مطلوب إذا لم يتوفّر :values.',
    'required_without_all' => ':attribute مطلوب إذا لم يتوفّر :values.',
    'same'                 => 'يجب أن يتطابق :attribute مع :other.',
    'size'                 => [
        'numeric' => 'يجب أن تكون قيمة :attribute مساوية لـ :size.',
        'file'    => 'يجب أن يكون حجم الملف :attribute :size كيلوبايت.',
        'string'  => 'يجب أن يحتوي النص :attribute على :size حروفٍ/حرفًا بالضبط.',
        'array'   => 'يجب أن يحتوي :attribute على :size عنصرٍ/عناصر بالضبط.',
    ],
    'starts_with'          => 'يجب أن يبدأ :attribute بأحد القيم التالية: :values',
    'string'               => 'يجب أن يكون :attribute نصًا.',
    'timezone'             => 'يجب أن يكون :attribute نطاقًا زمنيًا صحيحًا.',
    'unique'               => 'قيمة :attribute مُستخدمة من قبل.',
    'uploaded'             => 'فشل في تحميل الـ :attribute.',
    'url'                  => 'صيغة الرابط :attribute غير صحيحة.',
    'uuid'                 => ':attribute يجب أن يكون بصيغة UUID سليمة.',
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */
    'custom'               => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'name'              => 'الاسم',
        'user_name'         => 'إسم المستخدم',
        'email'             => 'البريد اللالكتروني',
        'mobile'            => 'رقم الجوال',
        'image'             => 'الصورة',
        'message'           => 'الرسالة',
        'categories'        => 'القسم',
        'personal_id'       => 'الرقم الوطني',
        'nationality'       => 'الجنسية',
        'license_number'    => 'رقم الرخصة',
        'license_image'     => 'صورة الرخصة',
        'type'              => 'النوع',
        'company_image'     => 'شعار الشركة',
        'categories.*'      => 'القسم',
        'country_id'        => 'الدولة',
        'area_id'           => 'المدينة',
        'dates'             => 'التواريخ',
        'dates.*'           => 'التاريخ',
        'images'            => 'الصور',
        'images.*'          => 'الصورة',
        'price'             => 'السعر',
        'duration'          => 'المدة',
        'address'           => 'العنوان',
        'seats'             => 'عدد الافراد',
        'lat'               => 'خط الطول',
        'long'              => 'خط العرض',
        'description'       => 'الوصف',
        'services'          => 'الخدمات',
        'schedule'          => 'جدول الخدمة',
        'refund_policy'     => 'سياسة الارجاع',
        'main_image'        => 'الصورة الرئيسية',
        'today'             => 'اليوم',
        'category_id'       => 'القسم الرئيسي',
        'sub_category_id'   => 'القسم الفرعي',
        'trip_id'           => 'الرحلة',
        'image_id'          => 'الصورة',
        'reason'            => 'السبب',
        'trip_image_id'     => 'الصورة',
        'invoice_image'     => 'صورة الفاتورة',
        'complaint_id'      => 'نوع الابلاغ',
        'password'          => 'كلمة المرور',
        'commercial_record' => 'السجل التجاري',
        'phone'             => 'الجوال',
        'raft_company_id'          => 'شركة الطوافة',
        'box_raft_company_box_id'  => 'رقم المربع',
        'camp_raft_company_box_id' => 'رقم المخيم',
        'date'                     => 'تاريخ الرخصة',
        'expiry_date'              => 'تاريخ الانتهاء',
        'tents_count'              => 'عدد الخيام',
        'person_count'             => 'عدد الحجاج',
        'camp_space'               => 'مساحة المخيم',
    ],
];
