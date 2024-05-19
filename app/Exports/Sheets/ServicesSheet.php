<?php

namespace App\Exports\Sheets;

use App\Models\City;
use App\Models\Service;
use App\Models\User;
use App\Services\UserService;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithMapping;

class ServicesSheet implements FromCollection, WithTitle, WithEvents, WithMapping
{
    use RegistersEventListeners;

    public Collection $services;

    public function __construct()
    {
        $this->services = Service::all();//app()->make(UserService::class)->getAll();
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->services;
    }

    public static function afterSheet(AfterSheet $event)
    {
        $sheet = $event->sheet;
        for ($row = 2; $row <=1000; $row++) {
            $objValidation = $sheet->getParent()->getSheet(1)->getCell("B" . $row)->getDataValidation();
            $objValidation->setType(DataValidation::TYPE_LIST);
            $objValidation->setErrorStyle(DataValidation::STYLE_INFORMATION);
            $objValidation->setAllowBlank(false);
            $objValidation->setShowInputMessage(true);
            $objValidation->setShowErrorMessage(true);
            $objValidation->setShowDropDown(true);
            $objValidation->setErrorTitle('Input error');
            $objValidation->setError('Value is not in list.');
            $objValidation->setPromptTitle('Pick from list');
            $objValidation->setPrompt('Please pick a value from list.');
            $objValidation->setFormula1('Services!$A$1:$A$100');
        }
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Services';
    }

    public function map($row): array
    {
        return [
            $row->name . "#".$row->id
        ];
    }
}
