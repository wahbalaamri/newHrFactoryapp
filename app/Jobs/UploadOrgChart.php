<?php

namespace App\Jobs;

use App\Models\Clients;
use App\Models\Companies;
use App\Models\Departments;
use App\Models\OrgChartDesign;
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
        $sd_level = 0;
        $di_level = 0;
        $div_level = 0;
        $dep_level = 0;
        $data = [];
        foreach ($org_chart as $row) {
            // Rename headers dynamically based on the prefix
            $renamedRow = $this->renameHeaders($row);
            $data[] = $renamedRow;
            // Process the renamed row here
            // Example: $renamedRow['Level 1'], $renamedRow['Level 2'], etc.
        }
        // loop through $org_chart
        foreach ($data as $entity) {

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
                if (trim($entity['companies']) != '' && $sector_id && $entity['companies'] != null && $entity['companies'] != '') {
                    $company = Companies::where('name_en', trim($entity['companies']))->where('sector_id', $sector_id)->first();
                    if (!$company) {
                        $company = new Companies();
                    }
                    $company->name_en = trim($entity['companies']);
                    $company->name_ar = trim($entity['companies']);
                    $company->sector_id = $sector_id;
                    $company->client_id = $client->id;
                    $company->save();
                    $company_id = $company->id;
                }
            } else {
                $company_id = $client->sectors->first()->companies->first()->id;
            }
            $parent_id = null;
            $local_level = 1;
           if($client->use_departments) {
            $orgchartsize=OrgChartDesign::where('client_id', $client->id)->count();
            $is_hr_department = false;
            //get is_hr_department
            if (trim($entity['is_hr_department']) != '' && $entity['is_hr_department'] != null && $entity['is_hr_department'] != '') {
                $is_hr_department = $entity['is_hr_department'] == 'yes';
            }
            for ($i = 1; $i <= $orgchartsize; $i++) {
                if(trim($entity['level_' . $i]) != '' && $entity['level_' . $i] != null && $entity['level_' . $i] != '') {
                    $orgItem = Departments::where('name_en', trim($entity['level_' . $i]))
                        ->where('company_id', $company_id)
                        ->where('parent_id', $parent_id)
                        ->first();
                    if ($orgItem) {
                        $parent_id = $orgItem->id;
                        $orgItem->dep_level = $local_level;
                        $orgItem->type = $local_level;
                        $orgItem->is_hr = $is_hr_department;
                        $orgItem->company_id = $company_id;
                        $orgItem->name_en = trim($entity['level_' . $i]);
                        $orgItem->name_ar = trim($entity['level_' . $i]);
                        $orgItem->save();
                        $local_level++;
                    }
                    else{
                        $orgItem = new Departments();
                        $orgItem->name_en = trim($entity['level_' . $i]);
                        $orgItem->name_ar = trim($entity['level_' . $i]);
                        $orgItem->company_id = $company_id;
                        $orgItem->parent_id = $parent_id;
                        $orgItem->dep_level = $local_level;
                        $orgItem->type = $local_level;
                        $orgItem->is_hr = $is_hr_department;
                        $orgItem->save();
                        $local_level++;
                        $parent_id = $orgItem->id;
                    }
                }
            }}

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
            if (str_starts_with($key, 'is_hr_department')) {
                $renamedRow['is_hr_department'] = $value;
            }
            for ($i = 1; $i <= 7; $i++) {
                if (str_starts_with($key, 'level_' . $i)) {
                    $renamedRow['level_' . $i] = $value;
                }
            }
            // foreach ($this->prefixMap as $prefix => $newName) {
            //     if (str_starts_with($key, $prefix)) {
            //         $renamedRow[$newName] = $value;
            //         $this->exists[$newName] = true; // Mark that this column exists
            //     }
            // }
        }

        return $renamedRow;
    }
}
