<?php

namespace App\Jobs;

use App\Models\Clients;
use App\Models\Companies;
use App\Models\Departments;
use App\Models\Sectors;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithEvents;

class UploadOrgChart implements ShouldQueue
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
        //read file from public

        //$request->file('excel')
        Excel::import(new LargeExcelImportOrg($this->client_id, $this->user_id), $this->file);
    }
}
class LargeExcelImportOrg implements ToCollection, WithChunkReading, WithHeadingRow, WithEvents
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
    public function collection(Collection $org_chart)
    {
        //find client
        $client = Clients::find($this->client_id);
        $super_directorates = false;
        $directorates = false;
        $divisions = false;
        $departments = false;
        $super_directorates_hasValue = false;
        $directorates_hasValue = false;
        $divisions_hasValue = false;
        $departments_hasValue = false;
        $sd_level=0;
        $di_level=0;
        $div_level=0;
        $dep_level=0;
        foreach ($org_chart as $entity) {
            $level=1;
            if (isset($entity['super_directorates'])) {
                $super_directorates = true;
                //check if super_directorates is not empty
                if (trim($entity['super_directorates']) != '' && $entity['super_directorates'] != null && $entity['super_directorates'] != '') {
                    $super_directorates_hasValue = true;
                    $sd_level = $level++;
                }
            }
            if (isset($entity['directorates'])) {
                $directorates = true;
                //check if directorates is not empty
                if (trim($entity['directorates']) != '' && $entity['directorates'] != null && $entity['directorates'] != '') {
                    $directorates_hasValue = true;
                    $di_level = $level++;
                }
            }
            if (isset($entity['division'])) {
                $divisions = true;
                //check if divisions is not empty
                if (trim($entity['division']) != '' && $entity['division'] != null && $entity['division'] != '') {
                    $divisions_hasValue = true;
                    $div_level = $level++;
                }
            }
            if (isset($entity['department'])) {
                $departments = true;
                //check if departments is not empty
                if (trim($entity['department']) != '' && $entity['department'] != null && $entity['department'] != '') {
                    $departments_hasValue = true;
                    $dep_level = $level++;
                }
            }
            //check if all values are true
            if ($super_directorates && $directorates && $divisions && $departments && $super_directorates_hasValue && $directorates_hasValue && $divisions_hasValue && $departments_hasValue) {
                break;
            }
        }
        // loop through $org_chart
        foreach ($org_chart as $entity) {

            $level = 1;
            $sector_id = null;
            $company_id = null;
            $region_id = null;
            $branch_id = null;
            $new_parent_id = null;
            $super_directorate_id = null;
            $directorate_id = null;
            $div_id = null;
            $department_id = null;
            $section_id = null;
            if ($client->multiple_sectors) {
                //check if sector has value
                if (trim($entity['sectors']) != '' && $entity['sectors'] != null && $entity['sectors'] != '') {
                    $sector = Sectors::where('name_en', trim($entity['sectors']))->where('client_id', $this->client_id)->first();
                    if (!$sector) {
                        $sector = new Sectors();
                    }
                    $sector->name_en = trim($entity['sectors']);
                    $sector->name_ar = trim($entity['sectors']);
                    $sector->client_id = $this->client_id;
                    $sector->save();
                    $sector_id = $sector->id;
                }
            } else {
                $sector_id = $client->sectors->first()->id;
            }
            if ($client->multiple_company) {
                //check if company has value and $sector_id not null
                if (trim($entity['Establishments']) != '' && $sector_id && $entity['Establishments'] != null && $entity['Establishments'] != '') {
                    $company = Companies::where('name_en', trim($entity['Establishments']))->where('sector_id', $sector_id)->first();
                    if (!$company) {
                        $company = new Companies();
                    }
                    $company->name_en = trim($entity['Establishments']);
                    $company->name_ar = trim($entity['Establishments']);
                    $company->sector_id = $sector_id;
                    $company->save();
                    $company_id = $company->id;
                }
            } else {
                $company_id = $client->sectors->first()->companies->first()->id;
            }

            //check if super_directorate has value and $branch_id not null
            if ($client->use_departments && $super_directorates) {
                if (trim($entity['super_directorates']) != '' && $company_id && $client->use_departments && $entity['super_directorates'] != null && $entity['super_directorates'] != '') {
                    $super_directorate = Departments::where('name_en', ($entity['super_directorates']))->where('parent_id', $new_parent_id)->first();
                    if (!$super_directorate) {
                        $super_directorate = new Departments();
                    }
                    $super_directorate->name_en = ($entity['super_directorates']);
                    $super_directorate->name_ar = ($entity['super_directorates']);
                    $super_directorate->company_id = $company_id;
                    $super_directorate->parent_id = $new_parent_id;
                    $super_directorate->type = $sd_level;
                    $super_directorate->dep_level = $sd_level;
                    $super_directorate->is_hr = strtolower(trim($entity['hr_department'])) == 'yes';
                    $super_directorate->save();
                    $super_directorate_id = $super_directorate->id;
                    $new_parent_id = $super_directorate->id;
                }
            }
            //check if directorate has value and $super_directorate_id not null
            if ($client->use_departments && $directorates) {
                if (trim($entity['directorates']) != '' &&  $client->use_departments &&  $entity['directorates'] != null && $entity['directorates'] != '') {
                    $directorate = Departments::where('name_en', trim($entity['directorates']))->where('parent_id', $new_parent_id)->first();
                    if (!$directorate) {
                        $directorate = new Departments();
                    }
                    $directorate->name_en = trim($entity['directorates']);
                    $directorate->name_ar = trim($entity['directorates']);
                    $directorate->company_id = $company_id;
                    $directorate->parent_id = $new_parent_id;
                    $directorate->type = $di_level;
                    $directorate->dep_level = $di_level;
                    $directorate->is_hr = strtolower(trim($entity['hr_department'])) == 'yes';
                    $directorate->save();
                    $directorate_id = $directorate->id;
                    $new_parent_id = $directorate->id;
                }
            }
            //check if div has value and $directorate_id not null
            if ($client->use_departments && $divisions) {
                if (trim($entity['division']) != '' &&  $client->use_departments  && $entity['division'] != null && $entity['division'] != '') {
                    $div = Departments::where('name_en', trim($entity['division']))->where('parent_id', $new_parent_id)->first();
                    if (!$div) {
                        $div = new Departments();
                    }
                    $div->name_en = trim($entity['division']);
                    $div->name_ar = trim($entity['division']);
                    $div->company_id = $company_id;
                    $div->parent_id = $new_parent_id;
                    $div->type = $div_level;
                    $div->dep_level = $div_level;
                    $div->is_hr = strtolower(trim($entity['hr_department'])) == 'yes';
                    $div->save();
                    $div_id = $div->id;
                    $new_parent_id = $div->id;
                }
            }
            //check if department has value and $div_id not null
            if($client->use_departments && $departments) {
                if (trim($entity['department']) != '' &&  $client->use_departments && $entity['department'] != null && $entity['department'] != '') {
                    $department = Departments::where('name_en', trim($entity['department']))->where('parent_id', $new_parent_id)->first();
                    if (!$department) {
                        $department = new Departments();
                    }
                    $department->name_en = trim($entity['department']);
                    $department->name_ar = trim($entity['department']);
                    $department->company_id = $company_id;
                    $department->parent_id = $new_parent_id;
                    $department->type = $dep_level;
                    $department->dep_level = $dep_level;
                    $department->is_hr = strtolower(trim($entity['hr_department'])) == 'yes';
                    $department->save();
                    $department_id = $department->id;
                    $new_parent_id = $department->id;
                }
            }
            //check if section has value and $department_id not null
            if (trim($entity['section']) != '' && $department_id && $client->use_sections && $entity['section'] != null && $entity['section'] != '') {
                $section = Departments::where('name_en', trim($entity['section']))->where('parent_id', $new_parent_id)->first();
                if (!$section) {
                    $section = new Departments();
                }
                $section->name_en = trim($entity['section']);
                $section->name_ar = trim($entity['section']);
                $section->company_id = $company_id;
                $section->parent_id = $department_id;
                $section->type = 5;
                $section->dep_level = 5;
                $section->is_hr = strtolower(trim($entity['hr_department'])) == 'yes';
                $section->save();
                $section_id = $section->id;
            }
        }
    }
    public function chunkSize(): int
    {
        return 500;
    }

    /**
     * Register the events to listen for.
     *
     * @return array
     */
    public function registerEvents(): array
    {
        return [

            $this->onComplete(),
        ];
    }
    public function onComplete()
    {
        // Log::info("I just Finish Job");
    }
}
