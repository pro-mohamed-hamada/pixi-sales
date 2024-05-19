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
class StatusSheet implements FromArray, WithTitle, WithEvents
{
    use RegistersEventListeners;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function array(): array
    {
        return [
            ["new#".ClientStatusEnum::NEW],
            ["contacted#".ClientStatusEnum::CONTACTED],
            ["interested#".ClientStatusEnum::INTERESTED],
            ["not_interested#".ClientStatusEnum::NOT_INTERESTED],
            ["proposal#".ClientStatusEnum::PROPOSAL],
            ["meeting#".ClientStatusEnum::MEETING],
            ["closed#".ClientStatusEnum::CLOSED],
            ["lost#".ClientStatusEnum::LOST],
        ];
    }

    public static function afterSheet(AfterSheet $event)
    {
        $sheet = $event->sheet;
        for ($row = 2; $row <=1000; $row++) {
            $objValidation = $sheet->getParent()->getSheet(0)->getCell("L" . $row)->getDataValidation();
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
            $objValidation->setFormula1('Client_Status!$A$1:$A$100');
        }
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Client_Status';
    }

}
