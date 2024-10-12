<?php

namespace App\Jobs;

use App\Models\Clients;
use App\Models\Companies;
use App\Models\Departments;
use App\Models\Employees;
use App\Models\OrgChartDesign;
use App\Models\Sectors;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Facades\Excel;
use PhpParser\Node\Stmt\TryCatch;

class UploadEmployeeData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    private $client_id;
    private $file;
    private $user_id;
    protected $jobId;
    public function __construct($client_id, $file, $user_id)
    {
        //
        $this->client_id = $client_id;
        $this->file = $file;
        $this->user_id = $user_id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->jobId = $this->job->getJobId();
        //

        Excel::import(new LargeExcelImport($this->client_id, $this->user_id), $this->file);
    }
}
class LargeExcelImport implements ToCollection, WithChunkReading, WithHeadingRow
{
    /**
     * @param Collection $rows
     */
    private $client_id;
    private $file;
    private $user_id;
    public $notAdded_Employees = [];
    public function __construct($client_id, $user_id)
    {
        //
        $this->client_id = $client_id;
        $this->user_id = $user_id;
    }
    public function collection(Collection $Employees)
    {
        $client = Clients::find($this->client_id);
        $counter = 0;
        $data = [];
        foreach ($Employees as $row) {
            // Rename headers dynamically based on the prefix
            $renamedRow = $this->renameHeaders($row);
            $data[] = $renamedRow;
            // Process the renamed row here
            // Example: $renamedRow['Level 1'], $renamedRow['Level 2'], etc.
        }
        foreach ($data as $Employee) {
            $counter++;
            $department = null;
            $sectors_ob = null;
            $companies_ob = null;
            $region = null;
            $branch = null;
            $parent_id = null;
            $super_directory = null;
            $directory = null;
            $sectors = [];
            $companies = [];
            $date_of_birth = ($Employee['date_of_birth'] != '' || $Employee['date_of_birth'] != null) ? date('Y-m-d', strtotime($Employee['date_of_birth'])) : null;
            $date_of_service = ($Employee['date_of_service'] != '' || $Employee['date_of_service'] != null) ? date('Y-m-d', strtotime($Employee['date_of_service'])) : null;
            //pluck client sector ids into array
            if ($client->multiple_sectors) {
                //check $Employee['sectors'] is not null and the sectors is set
                if (isset($Employee['sectors']) && $Employee['sectors'] != '') {
                    $sectors_ob = Sectors::where('client_id', $this->client_id)->where('name_en', trim($Employee['sectors']))->get();
                    $sectors = $sectors_ob->pluck('id')->toArray();
                }
            } else {
                $sectors_ob = Sectors::where('client_id', $this->client_id)->get();
                $sectors = $sectors_ob->pluck('id')->toArray();
            }
            if ($client->multiple_company) {
                if (isset($Employee['companies']) && $Employee['companies'] != '') {
                    $companies_ob = Companies::where('client_id', $this->client_id)->where('name_en', trim($Employee['companies']))->whereIn('sector_id', $sectors)->get();
                    $companies = $companies_ob->pluck('id')->toArray();
                }
            } else {
                $companies_ob = Companies::where('client_id', $this->client_id)->whereIn('sector_id', $sectors)->get();
                $companies = $companies_ob->pluck('id')->toArray();
            }
            //pluck client company ids into array
            if ($client->use_departments) {
                //find org chart design
                $org_chart_design = OrgChartDesign::where('client_id', $this->client_id)->orderBy('level', 'asc')->get();
                $leve_id = null;
                $indexer = 1;
                foreach ($org_chart_design as $org_chart) {
                    //check if $Employee['level'] is not null and the level is set
                    if (isset($Employee['level_' . $indexer]) && $Employee['level_' . $indexer] != '') {
                        $leve = Departments::whereIn('company_id', $companies)->where('name_en', trim($Employee['level_' . $indexer]))->first();
                        if ($leve) {
                            $leve_id = $leve->id;
                        }
                    }
                    $indexer++;
                }
                if ($leve_id) {
                    $entity = Departments::where('id', $leve_id)->first();
                    $parent_id = $leve_id;
                }
            }
            $comp_id = null;
            if ($companies_ob) {
                if (count($companies_ob) > 0) {
                    $comp_id = $companies_ob->first()->id;
                } else
                    $comp_id = null;
            } else
                $comp_id = null;
            $sec_id = null;
            if ($sectors_ob) {
                if (count($sectors_ob) > 0) {
                    $sec_id = $sectors_ob->first()->id;
                } else {
                    $sec_id = null;
                }
            } else
                $sec_id = null;
            $employee = Employees::where('emp_id', trim($Employee['emp_number']))->where('email', trim($Employee['email']))->where('client_id', $this->client_id)->first();
            if (!$employee)
                $employee = new Employees();
            $employee->client_id = $this->client_id;
            $employee->comp_id = $comp_id;
            $employee->sector_id = $sec_id;
            $employee->dep_id = $parent_id;
            $employee->name = trim($Employee['name']) ?? '';
            $employee->emp_id = trim($Employee['emp_number']) ?? '';
            $employee->email = trim($Employee['email']);
            $employee->mobile = trim($Employee['phone']);
            $employee->gender = trim($Employee['gender']) ?? '';
            $employee->dob = $date_of_birth;
            $employee->dos = $date_of_service;
            $employee->position = trim($Employee['position']) ?? '';
            //check if $Employee['employee_type'] conatins Manager
            if (strpos(trim($Employee['employee_type']), 'Manager') !== false) {

                $employee->employee_type = 1;
            } else {
                $employee->employee_type = 2;
            }
            //added_by
            $employee->added_by = $this->user_id;
            $employee->save();
        }
        //export not added employees
        if (count($this->notAdded_Employees) > 0) {
            $fileName = 'NotAddedEmployees' . time() . '.csv';
            $filePath = storage_path('app/public/' . $fileName);
            $file = fopen($filePath, 'w');
            fputcsv($file, array('name', 'emp_number', 'email', 'phone', 'gender', 'date_of_birth', 'date_of_service', 'position', 'employee_type', 'sector', 'super_directorate', 'directorate', 'division', 'department', 'region', 'branch'));
            foreach ($this->notAdded_Employees as $Employee) {
                fputcsv($file, $Employee->toArray());
            }
        }
    }

    public function chunkSize(): int
    {
        return 500;
    }
    private function renameHeaders($row)
    {
        $renamedRow = [];

        $renamedRow = [];
        foreach ($row as $key => $value) {

            if (str_starts_with($key, 'companies_')) {
                $renamedRow['companies'] = $value;
            }

            if (str_starts_with($key, 'sectors_')) {
                $renamedRow['sectors'] = $value;
            }
            for ($i = 1; $i <= 7; $i++) {
                if (str_starts_with($key, 'level_' . $i)) {
                    $renamedRow['level_' . $i] = $value;
                }
            }
            if (str_starts_with($key, 'name_')) {
                $renamedRow['name'] = $value;
            }
            if (str_starts_with($key, 'employee_id')) {
                $renamedRow['emp_number'] = $value;
            }
            if (str_starts_with($key, 'email_')) {
                $renamedRow['email'] = $value;
            }
            if (str_starts_with($key, 'phone_')) {
                $renamedRow['phone'] = $value;
            }
            if (str_starts_with($key, 'gender_')) {
                $renamedRow['gender'] = $value;
            }
            if (str_starts_with($key, 'date_of_birth_')) {
                $renamedRow['date_of_birth'] = $value;
            }
            if (str_starts_with($key, 'date_of_service_')) {
                $renamedRow['date_of_service'] = $value;
            }
            if (str_starts_with($key, 'position_')) {
                $renamedRow['position'] = $value;
            }
            if (str_starts_with($key, 'employee_type_')) {
                $renamedRow['employee_type'] = $value;
            }
        }
        return $renamedRow;
    }
}
