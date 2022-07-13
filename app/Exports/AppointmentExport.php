<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;

class AppointmentExport implements FromCollection, WithEvents, WithHeadings, WithColumnWidths, WithTitle, WithMapping
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

    public function map($row): array
    {
        return [
            $row->service_provider_name,
            optional($row->RaftCompanyLocation)->name,
            optional($row->RaftCompanyBox)->box,
            optional($row->RaftCompanyBox)->camp,
            optional($row->RaftCompanyLocation)->user->phone ?? '',
            $row->start_at_to_string,
        ];
    }

    public function headings(): array
    {
        return [
            'مركز الخدمة',
            'اسم شركة الطوافة',
            'رقم المربع',
            'رقم المخيم',
            'رقم الجوال',
            ' وقت الموعد',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 40,
            'B' => 40,
            'C' => 40,
            'D' => 40,
            'E' => 40,
            'F' => 40,
        ];
    }

    public function title(): string
    {
        return 'Appointments';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()->setRightToLeft(true);
                $cellRange = 'A1:F1';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
                $event->sheet->getDelegate()->getRowDimension(1)->setRowHeight(20);
                $event->sheet->getDelegate()->getStyle($cellRange)->getAlignment()->setWrapText(true);
            },
        ];
    }
}
