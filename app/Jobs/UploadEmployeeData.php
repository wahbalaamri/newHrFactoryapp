<?php

namespace App\Jobs;

use App\Models\Clients;
use App\Models\Companies;
use App\Models\Departments;
use App\Models\Employees;
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

        foreach ($Employees as $Employee) {
            $counter++;
            //log {"name":"Al Busaidi,Barakat Amin Said","emp_number":"3040","email":"barakat.busaidi@owwsc.nama.om",
            //"phone":"99424415","gender":"Male","date_of_birth":"29-03-1974","date_of_service":"08-04-2006",
            //"position":"Supply Chain Management Senior Manager","employee_type":" Manager","sector":null,
            //"super_senior_directorate":"Financial Affairs_SDI","directorate":null,"division":"Supply Chain_DIV",
            //"department":null,"region":"Muscat","branch":"Bawshar","sections":"Bawshar"}
            //   0 => name,
            //   1 => emp_id,
            //   2 => email,
            //   3 => mobile,
            //   4 => gender,
            //   5 => dob,
            //   6 => dos,
            //   7 => position,
            //   8 => EmployeeType,
            //   9 => Sector,
            //   10 => super directorate,
            //   11 => directorate,
            //   12 => div,
            //   13 => department,
            //   14 => region,
            //   15 => branch,
            $department = null;
            $sector = null;
            $company = null;
            $region = null;
            $branch = null;
            $parent_id = null;
            $super_directory = null;
            $directory = null;
            $date_of_birth = date('Y-m-d', strtotime($Employee['date_of_birth']));
            $date_of_service = date('Y-m-d', strtotime($Employee['date_of_service']));
            //pluck client sector ids into array
            $sectors = Sectors::where('client_id', $this->client_id)->get()->pluck('id')->toArray();
            //pluck client company ids into array
            $companies = Companies::where('client_id', $this->client_id)->whereIn('sector_id', $sectors)->get()->pluck('id')->toArray();
            if ($client->use_departments) {

                //if seinor directorate has value
                if ($Employee['super_senior_directorate'] != null) {
                    $super_directory = Departments::where('name_en', trim($Employee['super_senior_directorate']))->whereIn('company_id', $companies)->first();
                    //check if super directorate exist
                    if ($super_directory) {
                        $parent_id = $super_directory->id;
                        $entity = $super_directory;
                    }
                }
                //if directorate has value
                if ($Employee['directorate'] != null) {
                    $directory = Departments::where('name_en', trim($Employee['directorate']))->where('parent_id', $parent_id)->first();
                    //check if directorate exist
                    if ($directory) {
                        $parent_id = $directory->id;
                        $entity = $directory;
                    }
                }
                //if division has value
                if ($Employee['division'] != null) {
                    $department = Departments::where('name_en', trim($Employee['division']))->where('parent_id', $parent_id)->first();
                    //check if division exist
                    if ($department) {
                        $parent_id = $department->id;
                        $entity = $department;
                    }
                }
                //if department has value
                if ($Employee['department'] != null) {
                    $department = Departments::where('name_en', trim($Employee['department']))->where('parent_id', $parent_id)->first();
                    //check if department exist
                    if ($department) {
                        $parent_id = $department->id;
                        $entity = $department;
                    }
                }
                //if client use sections and sections has value
                if ($Employee['sections'] != null && $client->use_sections) {
                    $section = Departments::where('name_en', trim($Employee['sections']))->where('parent_id', $parent_id)->first();
                    //check if section exist
                    if ($section) {
                        $parent_id = $section->id;
                        $entity = $section;
                    }
                }
                $employee = Employees::where('emp_id', $Employee['emp_number'])->where('email', $Employee['email'])->where('client_id', $this->client_id)->first();
                if (!$employee)
                    $employee = new Employees();
                $employee->client_id = $this->client_id;
                $employee->comp_id = $entity->company_id;
                $employee->sector_id = $entity->company->sector_id;
                $employee->dep_id = $parent_id;
                $employee->name = $Employee['name'];
                $employee->emp_id = $Employee['emp_number'];
                $employee->email = $Employee['email'];
                $employee->mobile = $Employee['phone'];
                $employee->gender = $Employee['gender'];
                $employee->dob = $date_of_birth;
                $employee->dos = $date_of_service;
                $employee->position = $Employee['position'];
                //check if $Employee['employee_type'] conatins Manager
                if (strpos($Employee['employee_type'], 'Manager') !== false) {

                    $employee->employee_type = 1;
                } else {
                    $employee->employee_type = 2;
                }
                //added_by
                $employee->added_by = $this->user_id;
                $employee->save();
                log::info($employee);
            } else {

                //check if $Employee['super_senior_directorate'] != null
                if ($Employee['super_senior_directorate'] != null) {
                    //find the company
                    $company = Companies::where('name_en', trim($Employee['super_senior_directorate']))->whereIn('sector_id', $sectors)->first();
                    if ($company) {
                        $employee = Employees::where('emp_id', $Employee['emp_number'])->where('email', $Employee['email'])->where('client_id', $this->client_id)->first();
                        if (!$employee)
                            $employee = new Employees();
                        $employee->client_id = $this->client_id;
                        $employee->comp_id = $company->id;
                        $employee->sector_id = $company->sector_id;
                        $employee->dep_id = null;
                        $employee->name = $Employee['name'];
                        $employee->emp_id = $Employee['emp_number'];
                        $employee->email = $Employee['email'];
                        $employee->mobile = $Employee['phone'];
                        $employee->gender = $Employee['gender'];
                        $employee->dob = $date_of_birth;
                        $employee->dos = $date_of_service;
                        $employee->position = $Employee['position'];
                        //check if $Employee['employee_type'] conatins Manager
                        if (strpos($Employee['employee_type'], 'Manager') !== false) {

                            $employee->employee_type = 1;
                        } else {
                            $employee->employee_type = 2;
                        }
                        //added_by
                        $employee->added_by = $this->user_id;
                        $employee->save();
                    }
                }
            }
        }
        //export not added employees
        if (count($this->notAdded_Employees) > 0) {
            $fileName = 'NotAddedEmployees' . time() . '.csv';
            $filePath = storage_path('app/public/' . $fileName);
            $file = fopen($filePath, 'w');
            fputcsv($file, array('name', 'emp_number', 'email', 'phone', 'gender', 'date_of_birth', 'date_of_service', 'position', 'employee_type', 'sector', 'super_senior_directorate', 'directorate', 'division', 'department', 'region', 'branch'));
            foreach ($this->notAdded_Employees as $Employee) {
                fputcsv($file, $Employee->toArray());
            }
        }
    }

    public function chunkSize(): int
    {
        return 500;
    }
}
