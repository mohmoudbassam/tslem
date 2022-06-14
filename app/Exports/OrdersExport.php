<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Events\AfterSheet;

class OrdersExport implements FromCollection
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
            optional($order->designer)->company_name ?? '',
            $order->order_status ?? '',
            optional($order->contractor)->company_name ?? '',
            optional($order->consulting)->company_name,
            $order->waste_contractor ?? '',
        ];
    }

    public function headings(): array
    {
        return [
            'رقم الطلب',
            'التاريخ',
            'المكتب الهندسي',
            'حالة الطلب',
            ' المقاول',
            ' المكتب الإستشاري',
            ' مقاول النفايات',
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
            'J' => 30,

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
                $cellRange = 'A1:G1';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
                // $event->sheet->setMergeColumn(  ['columns' => array('A','B','C','D')]);
                //$event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setUnderline(true);
                $event->sheet->getDelegate()->getRowDimension(1)->setRowHeight(20);
                $event->sheet->getDelegate()->getStyle($cellRange)->getAlignment()->setWrapText(true);
            },
        ];
    }
}
