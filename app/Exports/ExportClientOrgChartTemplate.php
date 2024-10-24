<?php

namespace App\Exports;

use App\Models\Clients;
use App\Models\OrgChartDesign;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportClientOrgChartTemplate implements FromCollection, WithHeadings, WithStyles
{
    private $client_id;
    private $multi_sectors = false;
    private $multi_companies = false;
    private $use_deps = false;
    private $columns_count = 1;
    /**
     * @return \Illuminate\Support\Collection
     */
    public function __construct($client_id, $multi_sectors = false, $multi_companies = false, $use_deps = false)
    {
        //
        $this->client_id = $client_id;
        $this->multi_sectors = $multi_sectors;
        $this->multi_companies = $multi_companies;
        $this->use_deps = $use_deps;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        //
        $dummy = [];
        //get org chart design
        $org = OrgChartDesign::where('client_id', $this->client_id)->get();
        //find client
        $client = Clients::find($this->client_id);
        foreach ($client->sectors as $sector) {
            //foreach sector companies
            foreach ($sector->companies as $company) {
                for ($i = 0; $i < 10; $i++) {
                    $row = [];
                    if ($this->multi_sectors)
                        $row[] = $sector->name_en;
                    if ($this->multi_companies)
                        $row[] = $company->name_en;
                    foreach ($org as $level) {
                        $row[] = "Enter Your " . $level->user_label . " Names or Titles";
                    }
                    if ($i % 5 == 0)
                        $row[] = "yes";
                    else
                        $row[] = "no";
                    $dummy[] = $row;
                }
            }
        }
        for ($i = 0; $i < 10; $i++) {
            $row = [];
            if ($this->multi_sectors)
                $row[] = "Your New Sector/Business Industries";
            if ($this->multi_companies)
                $row[] = "Your New Company/Organization";
            foreach ($org as $level) {
                $row[] = "Enter Your " . $level->user_label . " Names or Titles";
            }
            if ($i % 5 == 0)
                $row[] = "yes";
            else
                $row[] = "no";
            $dummy[] = $row;
        }
        return collect($dummy);
    }
    public function headings(): array
    {
        $headings = [];
        if ($this->multi_sectors) {
            $headings[] = "Sectors: Names of Business Industries or Fields";
            $this->columns_count++;
        }
        if ($this->multi_companies) {
            $headings[] = "Companies: Names of Organizations or Entities That work in your Business Industries or Fields";
            $this->columns_count++;
        }
        if ($this->use_deps) {
            $org = OrgChartDesign::where('client_id', $this->client_id)->get();
            foreach ($org as $level) {
                $headings[] = "Level-" . $level->level . ": " . $level->user_label;
                $this->columns_count++;
            }
            $headings[] = "Is HR Department: indicate current level organization sturcture is HR Department or not (Yes/No)";
        }
        return $headings;
    }
    public static function afterSheet(\Maatwebsite\Excel\Events\AfterSheet $event)
    {
        $sheet = $event->sheet->getDelegate();

        // Get the total number of columns dynamically
        $highestColumn = $sheet->getHighestColumn(); // Example: "E"
        $highestRow = $sheet->getHighestRow();       // Example: "100"

        // Let's say you want to restrict the "Status" column which is dynamically determined (e.g., column 2)
        $statusColumnIndex = 5; // In this example, column 2 will have the "Yes/No" validation

        // Convert the index (2) to the corresponding column letter (e.g., "B")
        $statusColumnLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($statusColumnIndex);

        // Define the range for the status column (e.g., "B2:B100" dynamically)
        $validationRange = $statusColumnLetter . '2:' . $statusColumnLetter . $highestRow;

        // Create the data validation for "Yes/No"
        $validation = $sheet->getCell($statusColumnLetter . '2')->getDataValidation();
        $validation->setType(DataValidation::TYPE_LIST);
        $validation->setErrorStyle(DataValidation::STYLE_STOP);
        $validation->setAllowBlank(false);
        $validation->setShowDropDown(true);
        $validation->setFormula1('"Yes,No"');
        $validation->setShowErrorMessage(true);
        $validation->setErrorTitle('Invalid input');
        $validation->setError('Value must be Yes or No.');

        // Apply the validation to the entire range (B2:B100 dynamically)
        for ($row = 2; $row <= $highestRow; $row++) {
            $sheet->getCell($statusColumnLetter . $row)->setDataValidation(clone $validation);
        }
    }

    public function styles(Worksheet $sheet)
    {
        // Get the header row
        $headerRow = 1; // Header is on the first row
        $headings = $this->headings();
        $headerColumns = range('A', 'Z'); // You can extend this if needed
        $last_coordinate = '';
        // Loop through headings
        foreach ($headings as $index => $heading) {
            if ($index >= count($headerColumns)) {
                break; // Prevent overflow beyond the defined range
            }
            $last_coordinate = $headerColumns[$index];

            $cell = $headerColumns[$index] . $headerRow;
            $headerValue = $heading;

            // Check if the header contains "Mandatory"
            if (stripos($headerValue, 'Mandatory') !== false) {
                $sheet->getStyle($cell)->applyFromArray([
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FFFF00'], // Yellow fill for mandatory headers
                    ],
                    'font' => [
                        'bold' => true,
                        'color' => ['argb' => 'FF000000'],
                    ],
                ]);
            } else {
                $sheet->getStyle($cell)->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['argb' => 'FF000000'],
                    ],
                ]);
            }
        }
        $totalRows = $sheet->getHighestRow();
        $totalRows = $totalRows + 5;
        $coordinate = 'A' . $totalRows . ':' . $last_coordinate . $totalRows;
        $sheet->mergeCells('A' . $totalRows . ':' . $last_coordinate . $totalRows);
        $sheet->setCellValue('A' . $totalRows, 'Please Do Not Edit or Delete the header row, but you can delete this row once you have filled in the data.')->getStyle('A' . $totalRows)->getFont()->setBold(true);
        $sheet->getStyle('A' . $totalRows)->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFFF00'], // Yellow fill for header
            ],
            'font' => [
                'bold' => true,
                'size' => 16,
                'color' => ['argb' => 'FF000000'],
                //center the text
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
            ]
        ]);
    }
}
