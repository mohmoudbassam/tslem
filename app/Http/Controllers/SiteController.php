<?php
namespace App\Http\Controllers;



class SiteController extends Controller
{

    public function getMainData(){
        $data = [];
        $data['news']=  \App\Models\News::query()->latest()->get();
        return $data;
    }
    
    public function getPhotos()
    {
        $data['photos'] =  \App\Models\Media::query()->where('type', 'image')->latest()->take(12)->get();
        $data['pageTitle'] =  'المركز الاعلامي - الصور';
        return view("photos", $data);
    }

    public function getVideos()
    {
        $data['photos'] =  \App\Models\Media::query()->where('type', 'video')->latest()->take(12)->get();
        $data['pageTitle'] =  'المركز الاعلامي - الفيديوهات';
        return view("photos", $data);
    }

    public function getHome(){
        return view("public",$this->getMainData());
    }

    public function getGuide($guideType){
        $data = $this->getMainData();


        if($guideType == 'mina'){
            $data['pageTitle'] = 'ادلة مشعر منى';
            $data['links'] = [
                [
                    'name' => 'اجراءآت تأهيل المكاتب و الشركات الهندسية  للوقاية والحماية من الحريق لمشعر منى',
                    'link' => asset('assets/guide/mina/اجراءآت تأهيل المكاتب و الشركات الهندسية  للوقاية والحماية من الحريق لمشعر منى.pdf')
                ],
                [
                    'name' => 'اجراءآت تأهيل مقاولي تنفيذ اعمال الوقاية والحماية من الحريق بمشعر منى',
                    'link' => asset('assets/guide/mina/اجراءآت تأهيل مقاولي تنفيذ اعمال الوقاية والحماية من الحريق بمشعر منى.pdf')
                ],
                [
                    'name' => 'خطوات استخدام بوابة مركز الخدمات الشامل تسليم لمشعر منى',
                    'link' => asset('assets/guide/mina/خطوات استخدام بوابة مركز الخدمات الشامل تسليم لمشعر منى.pdf')
                ],
                [
                    'name' => 'دليل اجراءآت تأهيل المكاتب و الشركات الهندسية لأعمال الإضافات للمخيمات بمنى',
                    'link' => asset('assets/guide/mina/دليل اجراءآت تأهيل المكاتب و الشركات الهندسية لأعمال الإضافات للمخيمات بمنى.pdf')
                ],
                [
                    'name' => 'دليل الشروط الوقائية في المشاعر المقدسة',
                    'link' => asset('assets/guide/mina/_دليل_الشروط_الوقائية_في_المشاعر_المقدسة.pdf')
                ],
                [
                    'name' => 'دليل اجراءآت و تأهيل المقاولين للعمل في أعمال الإضافات للمخيمات بمنى',
                    'link' => asset('assets/guide/mina/دليل اجراءآت و تأهيل المقاولين للعمل في أعمال الإضافات للمخيمات بمنى.pdf')
                ],
                [
                    'name' => 'دليل اعمال تغذية المياة و الصرف الصحي لأعمال الإضافات للمخيمات مشعر منى',
                    'link' => asset('assets/guide/mina/دليل اعمال تغذية المياة و الصرف الصحي لأعمال الإضافات للمخيمات مشعر منى.pdf')
                ],
                [
                    'name' => 'دليل الأعمال الانشائية لأعمال الإضافات للمخيمات مشعر منى',
                    'link' => asset('assets/guide/mina/دليل الأعمال الانشائية لأعمال الإضافات للمخيمات مشعر منى.pdf')
                ],
                [
                    'name' => 'دليل الأعمال الكهربائية لاعمال الإضافات للمخيمات بمشعر منى',
                    'link' => asset('assets/guide/mina/دليل الأعمال الكهربائية لاعمال الإضافات للمخيمات بمشعر منى.pdf')
                ],
                [
                    'name' => 'دليل الأعمال المعمارية لاعمال الإضافات للمخيمات بمشعر منى',
                    'link' => asset('assets/guide/mina/دليل الأعمال المعمارية لاعمال الإضافات للمخيمات بمشعر منى.pdf')
                ],
                [
                    'name' => 'دليل الأعمال لإضافات أنظمة التكييف والتبريد للمخيمات بمشعر منى',
                    'link' => asset('assets/guide/mina/دليل الأعمال لإضافات أنظمة التكييف والتبريد للمخيمات بمشعر منى.pdf')
                ],
                [
                    'name' => 'مركز الخدمات الشامل ( تسليم )',
                    'link' => asset('assets/guide/mina/مركز الخدمات الشامل ( تسليم ).pdf')
                ]
            ];
        }else {
            $data['pageTitle'] = 'ادلة مشعر عرفات';
            $data['links'] = [
                [
                    'name' => 'الدليل الاسترشادي للاعمال الموسمية بمشعر عرفات',
                    'link' => asset('assets/guide/arafat/الدليل الاسترشادي للاعمال الموسمية بمشعر عرفات.pdf')
                ],
                [
                    'name' => 'الدليل الاسترشادي للمنطقة المطورة بمشعر عرفات',
                    'link' => asset('assets/guide/arafat/الدليل الاسترشادي للمنطقة المطورة بمشعر عرفات.pdf')
                ],
                [
                    'name' => 'خطوات عمل مؤسسات وشركات الحج في مشعر عرفات 1443 هـ',
                    'link' => asset('assets/guide/arafat/خطوات عمل مؤسسات وشركات الحج في مشعر عرفات 1443 هـ.pdf')
                ],
                [
                    'name' => 'دليل الشروط الوقائية في المشاعر المقدسة',
                    'link' => asset('assets/guide/mina/_دليل_الشروط_الوقائية_في_المشاعر_المقدسة.pdf')
                ],
                [
                    'name' => 'مركز تسليم مشعر عرفات',
                    'link' => asset('assets/guide/arafat/مركز تسليم مشعر عرفات.pdf')
                ]
            ];
        }
        return view("guide",$data);
    }

    public function getPage($pageSlug){
        $data = $this->getMainData();
        switch($pageSlug){
            case 'faq':
                return view("page_faq",$data);
            break;
            default:
                abort(404);
            break;
        }
        
    }

}
