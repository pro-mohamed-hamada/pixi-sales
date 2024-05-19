<?php

namespace App\Exports\Sheets;

use App\Enum\ClientStatusEnum;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
class CurrenciesSheet implements FromArray, WithTitle, WithEvents
{
    use RegistersEventListeners;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function array(): array
    {
        return [
            ["EGP"],
            ["USD"],
        ];
    }

    public static function afterSheet(AfterSheet $event)
    {
        $sheet = $event->sheet;
        for ($row = 2; $row <=1000; $row++) {
            $objValidation = $sheet->getParent()->getSheet(1)->getCell("D" . $row)->getDataValidation();
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
            $objValidation->setFormula1('Currencies!$A$1:$A$2');
        }
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Currencies';
    }

}
