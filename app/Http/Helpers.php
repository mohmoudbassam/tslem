<?php

use App\Models\BeneficiresCoulumns;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

function save_logs($order, $user_id, $data)
{
    $order->logs()->create([
        'data' => $data,
        'user_id' => $user_id
    ]);
}

function get_user_column_file($type)
{
    $benef = BeneficiresCoulumns::query()->select('commercial_file',
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
        'memorandum_of_association')
        ->where('type', $type)->first();
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
        'memorandum_of_association' => 'شهادة عقد التأسيس '
    ][$col];
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
