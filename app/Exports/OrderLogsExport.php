<?php

namespace App\Exports;

use App\Models\OrderLogs;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class OrderLogsExport implements FromCollection, WithHeadings, WithTitle, WithMapping, WithColumnWidths
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

    public function map($order_logs): array
    {
        return [
            $order_logs->id ?? '-',
            $order_logs->order()->value('identifier') ?? '-',
            $order_logs->user()->value('name') ?? '-',
            $order_logs->data ?? '-',
            $order_logs->created_at->format($order_logs->getDateFormat()) ?? '-',
        ];
    }
    public function columnWidths(): array
    {
        return [
            'A' => 10,
            'B' => 20,
            'C' => 30,
            'D' => 30,
            'E' => 30,
        ];
    }

    public function headings(): array
    {
        return array_values(OrderLogs::trans('fields'));
    }

    public function title(): string
    {
        return OrderLogs::trans('plural');
    }
}
