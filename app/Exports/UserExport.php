<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;

class UserExport implements FromCollection, WithEvents, WithHeadings, WithColumnWidths, WithTitle, WithMapping
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

    public function map($user): array
    {
        return [
            $user->company_name,
            $user->company_owner_name,
            $user->email,
            $user->phone,
            $user->commercial_record,
            $user->id_number,
        ];
    }

    public function headings(): array
    {
        return [
            'اسم المكتب',
            'اسم المالك',
            'البريد الالتكروني',
            'الجوال',
            ' السجل التجاي',
            ' الهوية',
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

        ];
    }

    public function title(): string
    {
        return 'users';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()->setRightToLeft(true);
                $cellRange = 'A1:F1';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
                // $event->sheet->setMergeColumn(  ['columns' => array('A','B','C','D')]);
                //$event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setUnderline(true);
                $event->sheet->getDelegate()->getRowDimension(1)->setRowHeight(20);
                $event->sheet->getDelegate()->getStyle($cellRange)->getAlignment()->setWrapText(true);
            },
        ];
    }
}
