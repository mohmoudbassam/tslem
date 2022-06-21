<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;

class RaftCompanyExport implements FromCollection, WithEvents, WithHeadings, WithColumnWidths, WithTitle
{
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {

        return new Collection($this->data);
    }



    public function headings(): array
    {
        return [
            'اسم الشركة',
            'شركة الطوافة',
            'المربع ',
            'المخيم',


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
            'H' => 30,
            'I' => 30,

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
                $cellRange = 'A1:I1';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
                // $event->sheet->setMergeColumn(  ['columns' => array('A','B','C','D')]);
                //$event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setUnderline(true);
                $event->sheet->getDelegate()->getRowDimension(1)->setRowHeight(20);
                $event->sheet->getDelegate()->getStyle($cellRange)->getAlignment()->setWrapText(true);
            },
        ];
    }
}
