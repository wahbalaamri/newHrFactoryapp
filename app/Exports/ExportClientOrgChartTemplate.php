<?php

namespace App\Exports;

use App\Models\OrgChartDesign;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportClientOrgChartTemplate implements FromCollection, WithHeadings
{
    private $client_id;
    private $multi_sectors = false;
    private $multi_companies = false;
    private $use_deps = false;
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
        for ($i = 0; $i < 10; $i++) {
            $row = [];
            if ($this->multi_sectors)
                $row[] = "Enter Your Sectors Names or Titles";
            if ($this->multi_companies)
                $row[] = "Enter Your Companies Names or Titles";
            if ($this->use_deps) {
                $org = OrgChartDesign::where('client_id', $this->client_id)->get();
                foreach ($org as $level) {
                    $row[] = "Enter Your " . $level->user_label . " Names or Titles";
                }
                if ($i != 5)
                    $row[] = "no";
                else
                    $row[] = "yes";
            }
            $dummy[] = $row;
        }

        return collect($dummy);
    }
    public function headings(): array
    {
        $headings = [];
        if ($this->multi_sectors)
            $headings[] = "Sectors: Names of Business Industries or Fields";
        if ($this->multi_companies)
            $headings[] = "Companies: Names of Organizations or Entities That work in your Business Industries or Fields";
        if ($this->use_deps) {
            $org = OrgChartDesign::where('client_id', $this->client_id)->get();
            foreach ($org as $level) {
                $headings[] = "Level-" . $level->level . ": " . $level->user_label;
            }
            $headings[] = "Is HR Department: indecate current level organization sturcture is HR Department or not";
        }
        return $headings;
    }
}
