<?php

namespace App\Exports\Sheets;

use App\Models\City;
use App\Models\Source;
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
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SourcesSheet implements FromCollection, WithTitle, WithEvents, WithMapping
{
    use RegistersEventListeners;

    public Collection $sources;

    public function __construct()
    {
        $this->sources = Source::all();//app()->make(UserService::class)->getAll();
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->sources;
    }

    public static function afterSheet(AfterSheet $event)
    {
        $sheet = $event->sheet;
        for ($row = 2; $row <=1000; $row++) {
            $objValidation = $sheet->getParent()->getSheet(0)->getCell("J" . $row)->getDataValidation();
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
            $objValidation->setFormula1('Sources!$A$1:$A$100');
        }
        $sheet = $event->sheet->getDelegate(); // Get the PhpSpreadsheet object

        // Hide the sheet
        $sheet->getParent()->getSheetByName($sheet->getTitle())->setSheetState(Worksheet::SHEETSTATE_HIDDEN);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Sources';
    }

    public function map($row): array
    {
        return [
            $row->title . "#".$row->id
        ];
    }
}
