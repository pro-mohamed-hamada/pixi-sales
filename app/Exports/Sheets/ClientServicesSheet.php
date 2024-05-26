<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class ClientServicesSheet implements WithHeadings, WithTitle
{
    public function headings(): array
    {
        return [
            'phone',
            'service',
            'price',
            'currency',
            'next_action',
            'next_action_date',
            'comment',
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Client_Services';
    }
}
