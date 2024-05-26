<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
class ClientsSheet implements WithTitle, WithHeadings, WithStyles
{
    

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Clients';
    }

    public function headings(): array
    {
        return [
            'name',
            'phone',
            'industry',
            'company_name',
            'city',
            'other_person_name',
            'other_person_phone',
            'other_person_position',
            'facebook_url',
            'source',
            'assigned_to',
            'status',
            'reason',
            'comment',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['size' => 16]],

            // // Styling a specific cell by coordinate.
            // 'B2' => ['font' => ['italic' => true]],

            // // Styling an entire column.
            // 'C'  => ['font' => ['size' => 16]],
        ];
    }
}
