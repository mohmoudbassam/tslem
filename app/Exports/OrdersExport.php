<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;

class OrdersExport implements FromCollection, WithEvents, WithHeadings, WithColumnWidths, WithTitle, WithMapping
{
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {

        return $this->data;
    }

    public function map($order): array
    {
        return [
            $order->identifier ?? '',
            $order->date ?? '',
            $order->service_provider->company_name ?? '',
            is_null($order->service_provider->parent_id) ? 'المجلس التنسيقي لمؤسسات وشركات خدمة حجاج الداخل': "مؤسسات وشركات خدمة حجاج الخارج",
            optional($order->designer)->company_name ?? '',
            $order->order_status ?? '',
            optional($order->contractor)->company_name ?? '',
            optional($order->consulting)->company_name,
            $order->waste_contractor ?? '',
            $order->service_provider->camp_number ?? '',
            $order->service_provider->box_number ?? '',
            $order->service_provider->license_number ?? '',

        ];
    }

    public function headings(): array
    {
        return [
            'رقم الطلب',
            'التاريخ',
            'مقدم الخدمة',
            'شركة الطوافة',
            'المكتب الهندسي',
            'حالة الطلب',
            ' المقاول',
            'المكتب الإستشاري',
            ' مقاول النفايات',
            'رقم المخيم',
            'رقم المربع',
            'رقم الترخيص',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 30,
            'B' => 30,
            'C' => 30,
            'D' => 30,
            'E' => 30,
            'F' => 30,
            'G' => 30,
            'H' => 30,
            'J' => 30,
            'K' => 30,
            'L' => 30,

        ];
    }

    public function title(): string
    {
        return 'orders';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()->setRightToLeft(true);
                $cellRange = 'A1:L1';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
                // $event->sheet->setMergeColumn(  ['columns' => array('A','B','C','D')]);
                //$event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setUnderline(true);
                $event->sheet->getDelegate()->getRowDimension(1)->setRowHeight(20);
                $event->sheet->getDelegate()->getStyle($cellRange)->getAlignment()->setWrapText(true);
            },
        ];
    }
}
