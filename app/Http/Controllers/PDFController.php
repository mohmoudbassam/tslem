<?php
namespace App\Http\Controllers;

use \Mpdf\Mpdf;

class PDFController extends Controller
{

    public function generate()
    {
        /**

        [
        'margin_left' => 20,
        'margin_right' => 20,
        'margin_top' => 50,
        'margin_bottom' => 10
        ]
         */

        $mpdf = new Mpdf();
        $mpdf->SetDirectionality('rtl');
        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;
        $mpdf->SetWatermarkImage('https://tsleem.com.sa/assets/img/%D8%AA%D8%B3%D9%84%D9%8A%D9%85%202.png', 1, '', array(10, 260));
        $mpdf->showWatermarkImage = true;
        $mpdf->WriteHTML('
        <!DOCTYPE html>
            <html>
            <head>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <title>test</title>
            </head>
            <body  style="direction: rtl;">
           محتوى الملف يكون هنا
            </body>
            </html>
            ');
        $mpdf->WriteFixedPosHTML('توقيع مكتب تسليم', 0, 250, 40, 90, 'auto');
        $mpdf->Output();
    }

}
