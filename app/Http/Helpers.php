<?php

use App\Helpers\APIResponse;
use App\Models\BeneficiresCoulumns;
use App\Models\Order;
use App\Models\OrderService;

function save_logs($order, $user_id, $data)
{
    $order->logs()->create([
        'data' => $data,
        'user_id' => $user_id,
    ]);
}

function randomIntIdentifier($length = 10)
{
    $length = $length > 0 ? $length : 10;
    $numbers = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];
    $identifier = "1";
    for ($index = 1; $index < ($length - 1); $index++) {
        $identifier .= $numbers[mt_rand(0, 9)];
    }

    return $identifier;
}

function get_specialty_obligation_files_types($specialty)
{
    $types = [];
    foreach (get_specialty_obligation_files($specialty)["files"] as $obligationFiles) {
        $types[] = $obligationFiles["type"];
    }

    return $types;
}

function get_obligation_name_by_type($type)
{
    return [
        "gypsum_obligation" => "التعهد الخاص بإضافة الألواح الجبسية",
        "kitchen_obligation" => "التعهد الخاص بإضافة المطابخ",
        "storage_obligation" => "التعهد الخاص بإضافة مواقع التخزين",
        "entrance_obligation" => "التعهد الخاص بإضافة وسائل تغطية المداخل",
        "aisle_obligation" => "التعهد الخاص بإضافة وسائل تغطية الممرات",
        "electricity_obligation" => "التعهد الخاص بإضافة التمديدات والأجهزة الكهربائية",
        "air_conditioner_obligation" => "التعهد الخاص بإضافة المكيفات )الاسبليت(",
        "toilet_obligation" => "التعهد الخاص بإضافة المواضئ ودورات المياه",
    ][$type];
}

function get_specialty_obligation_files($specialty)
{
    return [
        "architect" => [
            "name_ar" => "المعماري",
            "name_en" => "architect",
            "files" => [
                [
                    "name" => "التعهد الخاص بإضافة الألواح الجبسية",
                    "type" => "gypsum_obligation",
                    "path" => asset("storage/obligations/" . "التعهد الخاص بإضافة الألواح الجبسية.pdf"),
                ],
                [
                    "name" => "التعهد الخاص بإضافة المطابخ",
                    "type" => "kitchen_obligation",
                    "path" => asset("storage/obligations/" . "التعهد الخاص بإضافة المطابخ.pdf"),
                ],
                [
                    "name" => "التعهد الخاص بإضافة مواقع التخزين",
                    "type" => "storage_obligation",
                    "path" => asset("storage/obligations/" . "التعهد الخاص بإضافة مواقع التخزين.pdf"),
                ],
                [
                    "name" => "التعهد الخاص بإضافة وسائل تغطية المداخل",
                    "type" => "entrance_obligation",
                    "path" => asset("storage/obligations/" . "التعهد الخاص بإضافة وسائل تغطية المداخل.pdf"),
                ],
                [
                    "name" => "التعهد الخاص بإضافة وسائل تغطية الممرات",
                    "type" => "aisle_obligation",
                    "path" => asset("storage/obligations/" . "التعهد الخاص بإضافة وسائل تغطية الممرات.pdf"),
                ],
            ],
        ],
        "electrical" => [
            "name_ar" => "الكهربائية",
            "name_en" => "electrical",
            "files" => [
                [
                    "name" => "التعهد الخاص بإضافة التمديدات والأجهزة الكهربائية",
                    "type" => "electricity_obligation",
                    "path" => asset("storage/obligations/" . "التعهد الخاص بإضافة التمديدات والأجهزة الكهربائية.pdf"),
                ],
                [
                    "name" => "التعهد الخاص بإضافة المطابخ",
                    "type" => "kitchen_obligation",
                    "path" => asset("storage/obligations/" . "التعهد الخاص بإضافة المطابخ.pdf"),
                ],
            ],
        ],
        "construction" => [
            "name_ar" => "الإنشائية",
            "name_en" => "construction",
            "files" => [
                [
                    "name" => "التعهد الخاص بإضافة المطابخ",
                    "type" => "kitchen_obligation",
                    "path" => asset("storage/obligations/" . "التعهد الخاص بإضافة المطابخ.pdf"),
                ],
            ],
        ],
        "mchanical" => [
            "name_ar" => "الميكانيكة",
            "name_en" => "mchanical",
            "files" => [
                [
                    "name" => "التعهد الخاص بإضافة المطابخ",
                    "type" => "kitchen_obligation",
                    "path" => asset("storage/obligations/" . "التعهد الخاص بإضافة المطابخ.pdf"),
                ],
                [
                    "name" => "التعهد الخاص بإضافة المكيفات )الاسبليت(",
                    "type" => "air_conditioner_obligation",
                    "path" => asset("storage/obligations/" . "التعهد الخاص بإضافة المكيفات )الاسبليت(.pdf"),
                ],
                [
                    "name" => "التعهد الخاص بإضافة المواضئ ودورات المياه",
                    "type" => "toilet_obligation",
                    "path" => asset("storage/obligations/" . "التعهد الخاص بإضافة المواضئ ودورات المياه.pdf"),
                ],
            ],
        ],
    ][$specialty];
}

function get_designer_type_name($tpe)
{
    return [
        "designer" => "مكتب تصميم",
        "consulting" => "اشراف",
        "fire" => "الحماية والوقاية من الحريق",
    ][$tpe];
}
function ends_with($string, $substring) {
    $length = strlen($substring);
    if ( substr_compare($string, $substring, -$length) === 0 ) {
        return true;
    } else {
        return false;
    }
}
function get_user_column_file($type)
{
    $benef = BeneficiresCoulumns::query()->select(
        'commercial_file',
        'rating_certificate',
        'address_file',
        'profession_license',
        'business_license',
        'social_insurance_certificate',
        'certificate_of_zakat',
        'saudization_certificate',
        'chamber_of_commerce_certificate',
        'tax_registration_certificate',
        'wage_protection_certificate',
        'memorandum_of_association',
        'company_owner_id_photo',
        'commissioner_id_photo',
        'commissioner_photo',
        'cv_file',
        'hajj_service_license',
        'personalization_record',
        'nomination_letter',
        'center_sketch',
        'gis_sketch',
        'dwg_sketch',
        'previous_works',
        'service_provider_obligation',
        'confidentiality_obligation'
    )->where('type', $type)->first();

    if (is_null($benef)) {
        return [];
    }

    $column = $benef->getAttributes();

    return array_filter($column);

}

function file_name_by_column($col)
{
    return [
        'commercial_file' => 'ملف السجل التجاري',
        'rating_certificate' => 'شهادة تصنيف وطني',
        'address_file' => 'العنوان الوطني',
        'profession_license' => 'مزاولة مهنة',
        'business_license' => 'شهادةالنشاط التجاري',
        'social_insurance_certificate' => 'شهادة التأمينات الاجتماعي',
        'certificate_of_zakat' => 'شهادةالزكاة والدخل',
        'saudization_certificate' => 'شهادةالسعودة',
        'chamber_of_commerce_certificate' => 'شهادة الغرفة التجارية',
        'tax_registration_certificate' => 'شهادة تسجيل الضريبة',
        'wage_protection_certificate' => 'شهادة حماية الأجور',
        'memorandum_of_association' => ' عقد التأسيس ',
        'company_owner_id_photo' => 'صورة هوية المالك',
        'commissioner_id_photo' => 'صورة هوية المفوض',
        'cv_file' => 'الاعمال السابقة',
        'commissioner_photo' => 'خطاب التفويض',
        'hajj_service_license' => 'الرخصة الموسيمية',
        'personalization_record' => 'الكروكي',
        'dwg_sketch' => 'كروكي المركز (DWG)',
        'previous_works' => 'الأعمال السابقة',
        'service_provider_obligation' => "اقرار مزودي الخدمة",
        'confidentiality_obligation' => "اتفاقية حفظ سويةالمعلومات",
    ][$col];
}

function citiesList()
{
    return [
        'تبوك',
        'الرياض',
        'الطائف',
        'مكة المكرمة',
        'حائل',
        'بريدة',
        'الهفوف',
        'الدمام',
        'المدينة المنورة',
        'ابها',
        'جازان',
        'جدة',
        'المجمعة',
        'الخبر',
        'حفر الباطن',
        'خميس مشيط',
        'احد رفيده',
        'القطيف',
        'عنيزة',
        'قرية العليا',
        'الجبيل',
        'النعيرية',
        'الظهران',
        'الوجه',
        'بقيق',
        'الزلفي',
        'خيبر',
        'الغاط',
        'املج',
        'رابغ',
        'عفيف',
        'ثادق',
        'سيهات',
        'تاروت',
        'ينبع',
        'شقراء',
        'الدوادمي',
        'الدرعية',
        'القويعية',
        'المزاحمية',
        'بدر',
        'الخرج',
        'الدلم',
        'الشنان',
        'الخرمة',
        'الجموم',
        'المجاردة',
        'السليل',
        'تثليث',
        'بيشة',
        'الباحة',
        'القنفذة',
        'محايل',
        'ثول',
        'ضبا',
        'تربه',
        'صفوى',
        'عنك',
        'طريف',
        'عرعر',
        'القريات',
        'سكاكا',
        'رفحاء',
        'دومة الجندل',
        'الرس',
        'المذنب',
        'الخفجي',
        'رياض الخبراء',
        'البدائع',
        'رأس تنورة',
        'البكيرية',
        'الشماسية',
        'الحريق',
        'حوطة بني تميم',
        'ليلى',
        'بللسمر',
        'شرورة',
        'نجران',
        'صبيا',
        'ابو عريش',
        'صامطة',
        'احد المسارحة',
        'مدينة الملك عبدالله الاقتصادية',
        'بلقرن',
    ];
}

function wasteContractorsList()
{
    return collect([
        [
            'name' => 'مسارات النقل',
        ],
        [
            'name' => 'سدر للخدمات',
        ],
        [
            'name' => 'الفارس المختص',
        ],
        [
            'name' => 'غربيات الدولية',
        ],
        [
            'name' => 'ابراج الغيوم',
        ],
        [
            'name' => 'مؤسسة ضيف الله القرشي',
        ],
        [
            'name' => 'دائرة النظافة',
        ],
        [
            'name' => 'مستقبل البيئة',
        ],
        [
            'name' => 'مؤسسة نباتات',
        ],
        [
            'name' => 'المدن النظيفة',
        ],
        [
            'name' => 'عز البيارق',
        ],
        [
            'name' => 'مؤسسة الوادي',
        ],
        [
            'name' => 'لجين التجارية',
        ],
        [
            'name' => 'البلد الامين',
        ],
        [
            'name' => 'مؤسسة افاق',
        ],
        [
            'name' => 'افراس للمقاولات',
        ],
        [
            'name' => 'سعود المتقدمة',
        ],
        [
            'name' => 'اناقة المدن',
        ],
        [
            'name' => 'مهندسو البيئة',
        ],
        [
            'name' => 'اسطورة الانفال',
        ],
        [
            'name' => 'التراث والبيئة',
        ],
    ]);
}

function is_image($extension)
{
    $image_type = [
        'png',
        'jpg',
        'jpeg',
        'gif',
    ];

    return in_array($extension, $image_type);
}

function is_pdf($extension)
{
    return $extension == 'pdf';
}

function get_file_icon($ext)
{
    switch ($ext) {
        case 'pdf':
            return $type = 'fa fa-file-pdf';
            break;
        case 'docx':
        case 'doc':

            return $type = 'fa-file-word';
            break;
        case 'xls':
            return $type = 'fa-file-excel';
        case 'xlsx':
            return $type = 'fa-file-excel';
            break;
        case 'mp3':
        case 'ogg':
        case 'wav':
            $type = 'audio';
            break;
        case 'mp4':
        case 'mov':
            $type = 'video';
            break;
        case 'zip':
        case '7z':
        case 'rar':
            $type = 'archive';
            break;
        case 'jpg':
        case 'jpeg':
        case 'png':
            $type = 'image';
            break;
        default:
            $type = 'alt';
    }

}

function api($success, $code, $message, $items = null, $errors = null)
{
    return new APIResponse($success, $code, $message);
}

function api_exception(Exception $e)
{
    return api(false, $e->getCode(), $e->getMessage())
        ->add('error', [
            'line' => $e->getLine(),
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'trace' => $e->getTrace(),
        ])->get();
}

function sms($number, $body)
{

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://www.msegat.com/gw/sendsms.php");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, TRUE);

    curl_setopt($ch, CURLOPT_POST, TRUE);
    $number = normalize_phone_number($number);
    $fields = [
        "userName" => env('MSEGAT_SENDER'),
        "numbers" => "$number",
        "userSender" => env('MSEGAT_SENDER'),
        "apiKey" => env('MSEGAT_APIKEY'),
        "msg" => $body,
        'message' => $body,
    ];

    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
    ]);

    $response = curl_exec($ch);

    $info = curl_getinfo($ch);
    curl_close($ch);

}

function order_services($id)
{
   $order= Order::query()->find($id);
   $order_services= OrderService::query()->with('service.specialties.service')->where('order_id', $order->id)->get();
  $services=  $order_services->map(function($service){
      return [
         'name'=> $service->service->name,
          'quantity'=> $service->unit,
          'quantity_label'=> $service->service->unit,
      ];
    });
    return $services;
}

function normalize_phone_number($number)
{

    $number = preg_replace('/^0+/', '', $number);

    if (strlen($number) < 12) return '+966' . $number;

    return '+' . $number;

}

if (!function_exists('getTrans')) {
    /**
     * Translate the given message or return default.
     *
     * @param string|null $key
     * @param array $replace
     * @param string|null $locale
     *
     * @return string|array|null
     */
    function getTrans($key = null, $default = null, $replace = [], $locale = null)
    {
        $key = value($key);
        $return = __($key, $replace, $locale);

        return $return === $key ? value($default) : $return;
    }
}

if (!function_exists('currentLocale')) {
    /**
     * return appLocale
     *
     * @param bool $full
     *
     * @return string
     */
    function currentLocale($full = false): string
    {
        if ($full) {
            return (string)app()->getLocale();
        }

        $locale = str_replace('_', '-', app()->getLocale());
        $locale = current(explode("-", $locale));

        return $locale ?: "";
    }
}

if (!function_exists('currentUser')) {
    /**
     * Returns current logged in user
     *
     * @param mixed $default
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|mixed
     */
    function currentUser($default = null)
    {
        return
            auth()->user() ??
            auth('web')->user() ??
            auth('users')->user() ??
            value($default);
    }
}

if (!function_exists('crudTrans')) {
    /**
     * @param \Illuminate\Database\Eloquent\Model|string|\Closure $model
     * @param \Closure|string|null $key
     * @param \Closure|string|null $locale
     * @param \Closure|mixed|null $default
     *
     * @return array|string|null
     */
    function crudTrans($model = null, $key = null, $locale = null, $default = null, $instance = null)
    {
        $locale ??= currentLocale();
        $getModelTrans =
            fn($is_singular = true) => isModel($model) ? $model::trans(
                $is_singular ? 'singular' : 'plural',
                [],
                $locale
            )
                : ($is_singular ? 'str_singular' : 'str_plural')($model);

        $instance = $instance && isModel($instance) ? $instance : optional((object)['id_label' => $instance ?? '']);

        $results = __('general.model', [
            'prefix' => $instance->id_label ? $getModelTrans(true) . ' ' : '',
            'model' => $instance->id_label ?: $getModelTrans(true),
            'models' => $getModelTrans(false),
        ], $locale);

        $key = value($key);
        return is_null($key) ? $results : data_get($results, $key, $default);
    }
}

if (!function_exists('isModel')) {
    /**
     * Determine if a given object is inherit Model class.
     *
     * @param \Illuminate\Database\Eloquent\Model|object $object
     *
     * @return bool
     */
    function isModel($object): bool
    {
        try {
            return ($object instanceof \Illuminate\Database\Eloquent\Model)
                || is_a($object, \Illuminate\Database\Eloquent\Model::class)
                || is_subclass_of($object, \Illuminate\Database\Eloquent\Model::class);
        } catch (Exception $exception) {

        }

        return false;
    }
}

if (!function_exists('isDateAttribute')) {
    /**
     * @param $model
     * @param $key
     *
     * @return bool
     */
    function isDateAttribute($model, $key): bool
    {
        try {
            $model = is_object($model) ? $model : app($model);

            return in_array($key, $model->getDates(), true) ||
                $model->hasCast($key, ['date', 'datetime', 'immutable_date', 'immutable_datetime']);
        } catch (Exception $exception) {

        }

        return false;
    }
}

if (!function_exists('saveLicense')) {
    /**
     * @param Order|int $order
     * @param array $attributes
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    function saveLicense($order, array $attributes)
    {
        /** @var Order $order */
        $order = isModel($order) ? $order : Order::find($order);

        return $order->saveLicense($attributes);
    }
}
