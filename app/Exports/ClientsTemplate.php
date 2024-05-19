<?php

namespace App\Exports;

use App\Exports\Sheets\CitiesSheet;
use App\Exports\Sheets\ClientServicesSheet;
use App\Exports\Sheets\ClientsSheet;
use App\Exports\Sheets\CurrenciesSheet;
use App\Exports\Sheets\EmployeesSheet;
use App\Exports\Sheets\IndustriesSheet;
use App\Exports\Sheets\ReasonsSheet;
use App\Exports\Sheets\ServicesSheet;
use App\Exports\Sheets\SourcesSheet;
use App\Exports\Sheets\StatusSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
class ClientsTemplate implements WithMultipleSheets
{
    use Exportable, RegistersEventListeners;
    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];

        $sheets[] = new ClientsSheet();
        $sheets[] = new ClientServicesSheet();
        $sheets[] = new CitiesSheet();
        $sheets[] = new IndustriesSheet();
        $sheets[] = new EmployeesSheet();
        $sheets[] = new SourcesSheet();
        $sheets[] = new ReasonsSheet();
        $sheets[] = new ServicesSheet();
        $sheets[] = new StatusSheet();
        $sheets[] = new CurrenciesSheet();

        return $sheets;
    }

    

}
