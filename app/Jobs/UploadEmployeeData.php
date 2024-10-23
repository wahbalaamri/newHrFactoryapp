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
            $is_hr = false;
            $date_of_birth = ($Employee['date_of_birth'] != '' && $Employee['date_of_birth'] != null && $Employee['date_of_birth'] != 'Please Do Not Edit or Delete the header row, but you can delete this row once you have filled in the data.') ? date('Y-m-d', strtotime($Employee['date_of_birth'])) : null;
            $date_of_service = ($Employee['date_of_service'] != '' && $Employee['date_of_service'] != null && $Employee['date_of_service'] != 'Please Do Not Edit or Delete the header row, but you can delete this row once you have filled in the data.') ? date('Y-m-d', strtotime($Employee['date_of_service'])) : null;
            //pluck client sector ids into array
            if ($client->multiple_sectors) {
                //check $Employee['sectors'] is not null and the sectors is set
                if (
                    isset($Employee['sectors'])
                    && $Employee['sectors'] != ''
                ) {
                    $sectors_ob = Sectors::where('client_id', $this->client_id)->where('name_en', trim($Employee['sectors']))->first();
                    $sectors = $sectors_ob->id;
                }
            } else {
                $sectors_ob = Sectors::where('client_id', $this->client_id)->first();
                $sectors = $sectors_ob->id;
            }
            if ($client->multiple_company) {
                Log::info($Employee['companies']);
                if (
                    isset($Employee['companies'])
                    && $Employee['companies'] != ''
                ) {
                    Log::info($Employee['companies']);
                    $companies_ob = Companies::where('client_id', $this->client_id)->where('name_en', trim($Employee['companies']))->where('sector_id', $sectors)->first();
                    $companies = $companies_ob->id;
                }
            } else {
                $companies_ob = Companies::where('client_id', $this->client_id)->where('sector_id', $sectors)->first();
                $companies = $companies_ob->id;
            }
            //pluck client company ids into array
            if ($client->use_departments) {
                //find org chart design
                $leve_id = null;
                $is_hr = false;
                //check if $Employee['level'] is not null and the level is set
                if (
                    isset($Employee['hirarchal_level'])
                    && $Employee['hirarchal_level'] != ''
                ) {
                    $leve = Departments::where('company_id', $companies)
                        ->where('name_en', trim($Employee['hirarchal_level']))->first();
                    if ($leve) {
                        $leve_id = $leve->id;
                        $is_hr = $leve->is_hr;
                    }
                }
                if ($leve_id) {
                    $parent_id = $leve_id;
                }
            }
            $comp_id = null;
            if ($companies_ob) {
                $comp_id = $companies_ob->id;
            } else
                $comp_id = null;
            $sec_id = null;
            if ($sectors_ob) {
                $sec_id = $sectors_ob->id;
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
            $employee->mobile = trim($Employee['phone']) ?? '';
            $employee->gender = trim($Employee['gender']) ?? '';
            $employee->dob = $date_of_birth;
            $employee->dos = $date_of_service;
            $employee->position = trim($Employee['position']) ?? '';
            //check if $Employee['employee_type'] conatins Manager
            if (strpos(trim($Employee['employee_type']), 'Manager') !== false) {

                $employee->employee_type = 1;
                if ($is_hr) {
                    $employee->is_hr_manager = true;
                } else {
                    $employee->is_hr_manager = false;
                }
            } else {
                $employee->employee_type = 2;
                $employee->is_hr_manager = false;
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

            if (str_starts_with($key, 'company')) {
                $renamedRow['companies'] = $value;
            }

            if (str_starts_with($key, 'sector')) {
                $renamedRow['sectors'] = $value;
            }
            if (str_starts_with(strtolower($key), 'hirarchal_level')) {
                $renamedRow['hirarchal_level'] = $value;
            }
            if (str_starts_with($key, 'name')) {
                $renamedRow['name'] = $value;
            }
            if (str_starts_with($key, 'employee_id')) {
                $renamedRow['emp_number'] = $value;
            }
            if (str_starts_with($key, 'email')) {
                $renamedRow['email'] = $value;
            }
            if (str_starts_with($key, 'phone')) {
                $renamedRow['phone'] = $value;
            }
            if (str_starts_with($key, 'gender')) {
                $renamedRow['gender'] = $value;
            }
            if (str_starts_with($key, 'date_of_birth')) {
                $renamedRow['date_of_birth'] = $value;
            }
            if (str_starts_with($key, 'date_of_service')) {
                $renamedRow['date_of_service'] = $value;
            }
            if (str_starts_with($key, 'position')) {
                $renamedRow['position'] = $value;
            }
            if (str_starts_with($key, 'employee_type')) {
                $renamedRow['employee_type'] = $value;
            }
        }
        return $renamedRow;
    }
}
