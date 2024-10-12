<?php

namespace App\Exports;

use App\Models\Clients;
use App\Models\OrgChartDesign;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportClientEmployeeDataTemplate implements FromCollection, WithHeadings
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
        //
        $employee_template_data = [];
        for ($i = 0; $i < 50; $i++) {
            $row = [];
            if ($this->client->multiple_sectors) {
                $row[] = "Please specify your Sector Where Employee Works ";
            }
            if ($this->client->multiple_company) {
                $row[] = "Please specify your Company Where Employee Works ";
            }
            if ($this->client->use_departments) {
                //find org chart
                $org = OrgChartDesign::where('client_id', $this->client->id)->get();
                if ($org->count() > 0) {
                    foreach ($org as $o) {
                        $row[] = "Please specify your level_" . $o->level . " organization structure or " . $o->user_label . " Where Employee Works ";
                    }
                }
            }
            $row[] = "Name_" . $i;
            $row[] = "Employee ID_" . $i;
            $row[] = "employee_email@companydomain.com " . $i;
            $row[] = "9xxxxxxx or 7xxxxxxx " . $i;
            $row[] = $i % 5 == 0 ? "Manager" : "Employee";
            $row[] = $i % 2 == 0 ? "Male" : "Female" . $i;
            $row[] = "Date Of Birth e.g. 1990-01-01 " . $i;
            $row[] = "Date Of Service e.g. 1990-01-01 " . $i;
            $row[] = "Position " . $i;
            $employee_template_data[] = $row;
        }
        return collect($employee_template_data);
    }

    public function headings(): array
    {
        $heading = [];
        // find client

        if ($this->client->multiple_sectors) {
            $heading[] = "Sector : Your Sector Where Your Employee Works";
        }
        if ($this->client->multiple_company) {
            $heading[] = "Company : Your Company Where Your Employee Works";
        }
        if ($this->client->use_departments) {
            $org = OrgChartDesign::where('client_id', $this->client->id)->get();
            if ($org->count() > 0) {
                foreach ($org as $o) {
                    $heading[] = "LeveL_" . $o->level . " : Your level_" . $o->level . " organization structure or " . $o->user_label . " Where Your Employee Works";
                }
            }
        }
        $heading[] = "Name : Your Employee Name";
        $heading[] = "Employee ID : Your Employee ID";
        $heading[] = "Email : Your Employee Email Address *Mandatory";
        $heading[] = "Phone : Your Employee Phone Number *Mandatory";
        $heading[] = "Employee Type : Your Employee Type either Manager or Employee *Mandatory";
        $heading[] = "Gender : Your Employee Gender either Male or Female";
        $heading[] = "Date of Birth : Your Employee Date of Birth *Mandatory";
        $heading[] = "Date of Service : Your Employee Date of Service *Mandatory";
        $heading[] = "Position : Your Employee Position *Mandatory";
        return $heading;
    }
}
