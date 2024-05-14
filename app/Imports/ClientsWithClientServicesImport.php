<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ClientsWithClientServicesImport implements WithMultipleSheets
{


    // Add a constructor to accept the request
    public function __construct()
    {
        //
    }
    public function sheets(): array
    {
        return [
            'Clients' => new ClientsImport(),
            // 'ClientServices' => new ClientServicesImport(),
        ];
    }

}
