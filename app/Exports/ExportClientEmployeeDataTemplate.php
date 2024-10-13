<?php

namespace App\Exports;

use App\Models\Clients;
use App\Models\OrgChartDesign;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportClientEmployeeDataTemplate implements FromCollection, WithHeadings, WithStyles
{
    private $client_id;
    private $client;
    public function __construct($client_id)
    {
        $this->client_id = $client_id;
        $this->client = Clients::find($this->client_id);
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $employee_template_data = [];
        foreach ($this->client->sectors as $sector) {
            foreach ($sector->companies as $company) {
                if ($this->client->use_departments) {
                    foreach ($company->departments as $department) {
                        $row = [];
                        if ($this->client->multiple_sectors) {
                            $row[] = $sector->name_en;
                        }
                        $row[] = $company->name_en;
                        $row[] = $department->name_en;
                        $row[] = "Name_";
                        $row[] = "Employee ID_";
                        $row[] = "employee_email@companydomain.com ";
                        $row[] = "9xxxxxxx or 7xxxxxxx ";
                        $row[] = "Employee";
                        $row[] = "Female";
                        $row[] = "Date Of Birth e.g. 1990-01-01 ";
                        $row[] = "Date Of Service e.g. 1990-01-01 ";
                        $row[] = "Position ";
                        $employee_template_data[] = $row;
                        $row = [];
                        if ($this->client->multiple_sectors) {
                            $row[] = $sector->name_en;
                        }
                        $row[] = $company->name_en;
                        $row[] = $department->name_en;
                        $row[] = "Name_";
                        $row[] = "Employee ID_";
                        $row[] = "employee_email@companydomain.com ";
                        $row[] = "9xxxxxxx or 7xxxxxxx ";
                        $row[] = "Manager";
                        $row[] = "Male";
                        $row[] = "Date Of Birth e.g. 1990-01-01 ";
                        $row[] = "Date Of Service e.g. 1990-01-01 ";
                        $row[] = "Position ";
                        $employee_template_data[] = $row;
                    }
                } else {
                    $row = [];
                    if ($this->client->multiple_sectors) {
                        $row[] = $sector->name_en;
                    }
                    $row[] = $company->name_en;
                    $row[] = "Name_";
                    $row[] = "Employee ID_";
                    $row[] = "employee_email@companydomain.com ";
                    $row[] = "9xxxxxxx or 7xxxxxxx ";
                    $row[] = "Employee";
                    $row[] = "Female";
                    $row[] = "Date Of Birth e.g. 1990-01-01 ";
                    $row[] = "Date Of Service e.g. 1990-01-01 ";
                    $row[] = "Position ";
                    $employee_template_data[] = $row;
                    $row = [];
                    if ($this->client->multiple_sectors) {
                        $row[] = $sector->name_en;
                    }
                    $row[] = $company->name_en;
                    $row[] = "Name_";
                    $row[] = "Employee ID_";
                    $row[] = "employee_email@companydomain.com ";
                    $row[] = "9xxxxxxx or 7xxxxxxx ";
                    $row[] = "Manager";
                    $row[] = "Male";
                    $row[] = "Date Of Birth e.g. 1990-01-01 ";
                    $row[] = "Date Of Service e.g. 1990-01-01 ";
                    $row[] = "Position ";
                    $employee_template_data[] = $row;
                }
            }
        }
        $row = [];
        //merging
        if ($this->client->use_departments) {
        }
        return collect($employee_template_data);
    }

    public function headings(): array
    {
        $heading = [];
        // find client

        if ($this->client->multiple_sectors) {
            $heading[] = "Sector *Mandatory*";
        }
        // if ($this->client->multiple_company) {
        $heading[] = "Company *Mandatory*";
        // }
        if ($this->client->use_departments) {
            $org = OrgChartDesign::where('client_id', $this->client->id)->get();
            $header = "Hirarchal Level : e.g. (";
            if ($org->count() > 0) {
                $index = 1;
                foreach ($org as $o) {
                    $header .= $o->user_label;
                    if ($index == ($org->count() - 1)) {
                        $header .= " or ";
                    } elseif ($index  == ($org->count())) {
                        $header .= ").*Mandatory*";
                    } else {
                        $header .= ", ";
                    }
                    $index++;
                }
            }
            $heading[] = $header;
        }
        $heading[] = "Name";
        $heading[] = "Employee ID ";
        $heading[] = "Email  *Mandatory*";
        $heading[] = "Phone";
        $heading[] = "Employee Type *Mandatory*";
        $heading[] = "Gender";
        $heading[] = "Date of Birth";
        $heading[] = "Date of Service";
        $heading[] = "Position";
        return $heading;
    }
    //implemnt style

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
        $coordinate='A' . $totalRows . ':' . $last_coordinate . $totalRows;
        $sheet->mergeCells('A' . $totalRows . ':' . $last_coordinate . $totalRows);
        $sheet->setCellValue('A'. $totalRows, 'Please Do Not Edit or Delete the header row, but you can delete this row once you have filled in the data.')->getStyle('A'.$totalRows)->getFont()->setBold(true);
        $sheet->getStyle('A'.$totalRows)->applyFromArray([
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
