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
        // loop through $org_chart
        foreach ($org_chart as $entity) {
            //{"sectors":"Water & Wastewater ","companies":"Nama Water Services ","regions":"Ad Dakhliyah",
            //"branches":"Nizwa Office","super_directorates":"Operation & Maintenance_SDI","directorates":"Region Operation_DI",
            //"division":"South Batinah & Dakhliyah Operation_DIV","department":"Operations Al Dakhliah Region_DT",
            //"hr_department":null,"9":null,"10":null,"11":null,"12":null,"13":null,"14":null,"15":null,
            //"16":null,"17":null,"18":null}
            //     0 => 'sectors',
            //     1 => 'companies',
            //     2 => 'regions',
            //     3 => 'branches',
            //     4 => 'super_directorates',
            //     5 => 'directorates',
            //     6 => 'division',
            //     7 => 'department',
            //     8 => 'section',
            //     9 => 'hr_department',
            $sector_id = null;
            $company_id = null;
            $region_id = null;
            $branch_id = null;
            $new_parent_id=null;
            $super_directorate_id = null;
            $directorate_id = null;
            $div_id = null;
            $department_id = null;
            $section_id = null;
            if ($client->multiple_sectors) {
                //check if sector has value
                if (trim($entity['sectors'])!='' && $entity['sectors']!=null && $entity['sectors']!='') {
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
                if (trim($entity['Establishments'])!='' && $sector_id && $entity['Establishments']!=null && $entity['Establishments']!='') {
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
            // //check if region has value and $company_id not null
            // if (trim($entity['regions'])!='' && $company_id && $client->use_departments && $entity['regions']!=null && $entity['regions']!='') {
            //     $region = Departments::where('name_en', trim($entity['regions']))->where('company_id', $company_id)->first();
            //     if (!$region) {
            //         $region = new Departments();
            //     }
            //     $region->name_en = trim($entity['regions']);
            //     $region->name_ar = trim($entity['regions']);
            //     $region->company_id = $company_id;
            //     $region->type = 3;
            //     $region->dep_level = 3;
            //     $region->is_hr = strtolower(trim($entity['hr_department'])) == 'yes';
            //     $region->save();
            //     $region_id = $region->id;
            // }
            // //check if branch has value and $region_id not null
            // if (trim($entity['branches'])!='' && $region_id && $client->use_departments && $entity['branches']!=null && $entity['branches']!='') {
            //     $branch = Departments::where('name_en', trim($entity['branches']))->where('parent_id', $region_id)->first();
            //     if (!$branch) {
            //         $branch = new Departments();
            //     }
            //     $branch->name_en = trim($entity['branches']);
            //     $branch->name_ar = trim($entity['branches']);
            //     $branch->company_id = $company_id;
            //     $branch->parent_id = $region_id;
            //     $branch->type = 4;
            //     $branch->dep_level = 4;
            //     $branch->is_hr = strtolower(trim($entity['hr_department'])) == 'yes';
            //     $branch->save();
            //     $branch_id = $branch->id;
            //     $new_parent_id = $branch->id;
            // }
            //check if super_directorate has value and $branch_id not null
            if (trim($entity['super_directorates'])!='' && $company_id && $client->use_departments && $entity['super_directorates']!=null && $entity['super_directorates']!='') {
                $super_directorate = Departments::where('name_en', ($entity['super_directorates']))->where('parent_id', $new_parent_id)->first();
                if (!$super_directorate) {
                    $super_directorate = new Departments();
                }
                $super_directorate->name_en = ($entity['super_directorates']);
                $super_directorate->name_ar = ($entity['super_directorates']);
                $super_directorate->company_id = $company_id;
                $super_directorate->parent_id = $new_parent_id;
                $super_directorate->type = 1;
                $super_directorate->dep_level = 1;
                $super_directorate->is_hr = strtolower(trim($entity['hr_department'])) == 'yes';
                $super_directorate->save();
                $super_directorate_id = $super_directorate->id;
                $new_parent_id = $super_directorate->id;
            }
            //check if directorate has value and $super_directorate_id not null
            if (trim($entity['directorates'])!='' &&  $client->use_departments &&  $entity['directorates']!=null && $entity['directorates']!='') {
                $directorate = Departments::where('name_en', trim($entity['directorates']))->where('parent_id', $new_parent_id)->first();
                if (!$directorate) {
                    $directorate = new Departments();
                }
                $directorate->name_en = trim($entity['directorates']);
                $directorate->name_ar = trim($entity['directorates']);
                $directorate->company_id = $company_id;
                $directorate->parent_id = $new_parent_id;
                $directorate->type = 2;
                $directorate->dep_level = 2;
                $directorate->is_hr = strtolower(trim($entity['hr_department'])) == 'yes';
                $directorate->save();
                $directorate_id = $directorate->id;
                $new_parent_id = $directorate->id;
            }
            //check if div has value and $directorate_id not null
            if (trim($entity['division'])!='' &&  $client->use_departments  && $entity['division']!=null && $entity['division']!='') {
                $div = Departments::where('name_en', trim($entity['division']))->where('parent_id', $new_parent_id)->first();
                if (!$div) {
                    $div = new Departments();
                }
                $div->name_en = trim($entity['division']);
                $div->name_ar = trim($entity['division']);
                $div->company_id = $company_id;
                $div->parent_id = $new_parent_id;
                $div->type = 3;
                $div->dep_level = 3;
                $div->is_hr = strtolower(trim($entity['hr_department'])) == 'yes';
                $div->save();
                $div_id = $div->id;
                $new_parent_id = $div->id;
            }
            //check if department has value and $div_id not null
            if (trim($entity['department'])!='' &&  $client->use_departments && $entity['department']!=null && $entity['department']!='') {
                $department = Departments::where('name_en', trim($entity['department']))->where('parent_id', $new_parent_id)->first();
                if (!$department) {
                    $department = new Departments();
                }
                $department->name_en = trim($entity['department']);
                $department->name_ar = trim($entity['department']);
                $department->company_id = $company_id;
                $department->parent_id = $new_parent_id;
                $department->type = 4;
                $department->dep_level = 4;
                $department->is_hr = strtolower(trim($entity['hr_department'])) == 'yes';
                $department->save();
                $department_id = $department->id;
                $new_parent_id = $department->id;
            }
            //check if section has value and $department_id not null
            if (trim($entity['section'])!='' && $department_id && $client->use_sections && $entity['section']!=null && $entity['section']!='') {
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
        Log::info("I just Finish Job");
    }
}
