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
    public function __construct($client_id, $user_id)
    {
        //
        $this->client_id = $client_id;
        $this->user_id = $user_id;
    }
    public function collection(Collection $Employees)
    {
        $client = Clients::find($this->client_id);
        foreach ($Employees as $Employee) {
            Log::info($Employee);
            Log::info($Employee['name']);
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
            $super_directory = null;
            $directory = null;
            $date_of_birth = date('Y-m-d', strtotime($Employee['date_of_birth']));
            $date_of_service = date('Y-m-d', strtotime($Employee['date_of_service']));
            //pluck client sector ids into array
            $sectors = Sectors::where('client_id', $this->client_id)->get()->pluck('id')->toArray();
            //pluck client company ids into array
            $companies = Companies::where('client_id', $this->client_id)->whereIn('sector_id', $sectors)->get()->pluck('id')->toArray();
            if ($client->use_departments) {
                if ($Employee['sections'] != null && $client->use_sections) {
                    $section = Departments::where('name_en', trim($Employee['sections']))->whereIn('company_id', $companies)->first();
                    if ($section) {
                        //check if employee exist
                        $employee = Employees::where('emp_id', $Employee['emp_number'])->where('email', $Employee['email'])->where('client_id', $this->client_id)->first();
                        if (!$employee)
                            $employee = new Employees();
                        $employee->client_id = $this->client_id;
                        $employee->comp_id = $section->company_id;
                        $employee->sector_id = $section->company->sector_id;
                        $employee->dep_id = $section->id;
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
                //check if departmnt has value
                elseif ($Employee['department'] != null) {
                    $department = Departments::where('name_en', trim($Employee['department']))->whereIn('company_id', $companies)->first();
                    if ($department) {
                        // add employee
                        $employee = Employees::where('emp_id', $Employee['emp_number'])->where('email', $Employee['email'])->where('client_id', $this->client_id)->first();
                        if (!$employee)
                            $employee = new Employees();
                        $employee->client_id = $this->client_id;
                        $employee->comp_id = $department->company_id;
                        $employee->sector_id = $department->company->sector_id;
                        $employee->dep_id = $department->id;
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
                //else check if div has value
                elseif ($Employee['division'] != null) {
                    $div = Departments::where('name_en', trim($Employee['division']))->whereIn('company_id', $companies)->first();
                    if ($div) {
                        $employee = Employees::where('emp_id', $Employee['emp_number'])->where('email', $Employee['email'])->where('client_id', $this->client_id)->first();
                        if (!$employee)
                            $employee = new Employees();
                        $employee->client_id = $this->client_id;
                        $employee->comp_id = $div->company_id;
                        $employee->sector_id = $div->company->sector_id;
                        $employee->dep_id = $div->id;
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
                //else check if directorate has value
                elseif ($Employee['directorate'] != null) {
                    $directorate = Departments::where('name_en', trim($Employee['directorate']))->whereIn('company_id', $companies)->first();
                    if ($directorate) {
                        $employee = Employees::where('emp_id', $Employee['emp_number'])->where('email', $Employee['email'])->where('client_id', $this->client_id)->first();
                        if (!$employee)
                            $employee = new Employees();
                        $employee->client_id = $this->client_id;
                        $employee->comp_id = $directorate->company_id;
                        $employee->sector_id = $directorate->company->sector_id;
                        $employee->dep_id = $directorate->id;
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
                //check if super dirctorate has value
                elseif ($Employee['super_senior_directorate'] != null) {
                    $super_dirctorate = Departments::where('name_en', trim($Employee['super_senior_directorate']))->whereIn('company_id', $companies)->first();
                    if ($super_dirctorate) {
                        $employee = Employees::where('emp_id', $Employee['emp_number'])->where('email', $Employee['email'])->where('client_id', $this->client_id)->first();
                        if (!$employee)
                            $employee = new Employees();
                        $employee->client_id = $this->client_id;
                        $employee->comp_id = $super_dirctorate->company_id;
                        $employee->sector_id = $super_dirctorate->company->sector_id;
                        $employee->dep_id = $super_dirctorate->id;
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
                //check if branch has value
                elseif ($Employee['branch'] != null) {
                    $branch = Departments::where('name_en', trim($Employee['branch']))->whereIn('company_id', $companies)->first();
                    if ($branch) {
                        $employee = Employees::where('emp_id', $Employee['emp_number'])->where('email', $Employee['email'])->where('client_id', $this->client_id)->first();
                        if (!$employee)
                            $employee = new Employees();
                        $employee->client_id = $this->client_id;
                        $employee->comp_id = $branch->company_id;
                        $employee->sector_id = $branch->company->sector_id;
                        $employee->dep_id = $branch->id;
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
                //check if region has value
                elseif ($Employee['region'] != null) {
                    $region = Departments::where('name_en', trim($Employee['region']))->whereIn('company_id', $companies)->first();
                    if ($region) {
                        $employee = Employees::where('emp_id', $Employee['emp_number'])->where('email', $Employee['email'])->where('client_id', $this->client_id)->first();
                        if (!$employee)
                            $employee = new Employees();
                        $employee->client_id = $this->client_id;
                        $employee->comp_id = $region->company_id;
                        $employee->sector_id = $region->company->sector_id;
                        $employee->dep_id = $region->id;
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
    }
    public function chunkSize(): int
    {
        return 500;
    }
}
