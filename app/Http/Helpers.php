<?php

use App\Models\BeneficiresCoulumns;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Helpers\APIResponse;
function save_logs($order, $user_id, $data)
{
    $order->logs()->create([
        'data' => $data,
        'user_id' => $user_id
    ]);
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
        'company_owner_id_photo',
        'nomination_letter',
        'center_sketch',
        'gis_sketch',

        )->where('type', $type)->first();




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
        'company_owner_id_photo'=>'صورة هوية المالك',
        'commissioner_id_photo'=>'صورة هوية المفوض',
        'cv_file'=>'الاعمال السابقة',
        'commissioner_photo'=>'خطاب التفويض',
        'hajj_service_license'=>'ترخيص خدمة الحج',
        'personalization_record'=>'محضر التخصيص',
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
        'بلقرن'
    ];
}

function is_image($extension)
{
    $image_type = [
        'png', 'jpg', 'jpeg', 'gif',
    ];
    return in_array($extension, $image_type);
}

function is_pdf($extension)
{
    return $extension == 'pdf';
}


 function get_file_icon($ext)
{
    switch($ext){
        case 'pdf':
           return  $type='fa fa-file-pdf';
            break;
        case 'docx':
        case 'doc':

        return  $type='fa-file-word';
            break;
        case 'xls':
            return  $type='fa-file-excel';
        case 'xlsx':
          return  $type='fa-file-excel';
            break;
        case 'mp3':
        case 'ogg':
        case 'wav':
            $type='audio';
            break;
        case 'mp4':
        case 'mov':
            $type='video';
            break;
        case 'zip':
        case '7z':
        case 'rar':
            $type='archive';
            break;
        case 'jpg':
        case 'jpeg':
        case 'png':
            $type='image';
            break;
        default:
            $type='alt';
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
