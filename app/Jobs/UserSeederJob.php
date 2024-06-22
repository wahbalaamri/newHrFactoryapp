<?php

namespace App\Jobs;

use App\Models\Clients;
use App\Models\Companies;
use App\Models\Countries;
use App\Models\Employees;
use App\Models\FocalPoints;
use App\Models\Industry;
use App\Models\PolicyMBFile;
use App\Models\Sectors;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class UserSeederJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        // check if Users table is empty
        if (User::count() > 0) {
            return;
        }
        $contents = json_decode(file_get_contents('https://www.hrfactoryapp.com/Home/shipData'), true);
        //insert content to database
        foreach ($contents['users'] as  $user) {
            if ($user['ContactInformation'] == '97001455'){
                // Log::info('Wahb is here');
            } else{
                if (($user['IsDeleted'] != true && $user['IsDeleted'] == false)) {
                    if ($user['IsAdmin'] == 1) {
                        //create new admin
                        $admin = User::where('email', $user['Email'])->get()->first();
                        $admin = $admin == null ? new User() : $admin;
                        $admin->name = $user['Name'];
                        $admin->email = $user['Email'];
                        $admin->client_id = null;
                        $admin->sector_id = null;
                        $admin->comp_id = null;
                        $admin->dep_id = null;
                        $admin->user_type = 'admin';
                        $admin->isAdmin = true;
                        $admin->password = bcrypt($user['Password']);
                        $admin->is_active = $user['IsDeleted'] == 1 ? false : true;
                        //delete_at
                        $admin->deleted_at = $user['IsDeleted'] == 1 ? now()->format('Y-m-d H:i:s') : null;
                        $admin->save();

                        //seed policy file
                        $PloicyFile = new PolicyMBFile();
                        $PloicyFile->user_id = $admin->id;
                        $PloicyFile->name = $user['DocumentName'];
                        $PloicyFile->name_ar = $user['DocumentNameAr'];
                        $PloicyFile->save();
                    } else {
                        //create new client
                        $olduser = User::where('email', $user['Email'])->get()->first();
                        if ($olduser == null) {
                            //get sector id
                            $sector = json_decode(file_get_contents('https://www.hrfactoryapp.com/Home/GetIndustry/' . $user['IndustryId']), true);
                            $country = json_decode(file_get_contents('https://www.hrfactoryapp.com/Home/GetCountry/' . $user['CountryId']), true);
                            $LocalSector = Industry::where('name', $sector['Name'])->first();
                            $LocalCountry = Countries::where('name', $country['Name'])->first();
                            $client = new Clients();
                            $client->name = $user['Name'];
                            $client->name_ar = $user['NameAr'];
                            $client->country = $LocalCountry->id;
                            $client->industry = $LocalSector->id;
                            $client->client_size = $user['NumberOFEmployees'];
                            $client->partner_id = null;
                            $client->logo_path = null;
                            $client->webiste = null;
                            $client->use_sections = true;
                            $client->is_active = $user['IsDeleted'] == 1 ? false : true;
                            //delete_at
                            // $client->deleted_at = $user['IsDeleted'] == 1 ? now()->format('Y-m-d H:i:s') : null;
                            $client->save();
                            //create new sector
                            $sector = new Sectors();
                            $sector->client_id = $client->id;
                            $sector->name_en = $LocalSector->name;
                            $sector->name_ar = $LocalSector->name_ar;
                            $sector->save();
                            //create new company
                            $company = new Companies();
                            $company->client_id = $client->id;
                            $company->sector_id = $sector->id;
                            $company->name_en = $user['Name'];
                            $company->name_ar = $user['NameAr'] != null ? $user['NameAr'] : $user['Name'];
                            $company->save();
                            //create new focal point
                            $focal_point = new FocalPoints();
                            $focal_point->client_id = $client->id;
                            $focal_point->name = $user['ContactPerson'];
                            $focal_point->name_ar = $user['ContactPerson'];
                            $focal_point->email = $user['Email'];
                            $focal_point->phone = $user['ContactInformation'];
                            $focal_point->position = null;
                            $focal_point->is_active = $user['IsDeleted'] == 1 ? false : true;
                            //delete_at
                            // $focal_point->deleted_at = $user['IsDeleted'] == 1 ? now()->format('Y-m-d H:i:s') : null;
                            $focal_point->save();
                            //new Employee
                            $employee = new Employees();
                            $employee->client_id = $client->id;
                            $employee->sector_id = $sector->id;
                            $employee->comp_id = $company->id;
                            $employee->dep_id = null;
                            $employee->email = $user['Email'];
                            $employee->mobile = $user['ContactInformation'];
                            $employee->emp_id = null;
                            $employee->employee_type = 2;
                            $employee->isCandidate = false;
                            $employee->isBoard = false;
                            $employee->acting_for = null;
                            $employee->is_hr_manager = false;
                            $employee->added_by = 0;
                            $employee->save();
                            //seed users
                            $user_ = new User();
                            $user_->name = $user['Name'];
                            $user_->email = $user['Email'];
                            $user_->client_id = $client->id;
                            $user_->sector_id = $sector->id;
                            $user_->comp_id = $company->id;
                            $user_->dep_id = null;
                            $user_->user_type = 'client';
                            $user_->isAdmin = false;
                            $user_->emp_id = $employee->id;
                            $user_->is_main = true;
                            $user_->password = bcrypt($user['Password']);
                            $user_->is_active = $user['IsDeleted'] == 1 ? false : true;
                            //delete_at
                            // $user_->deleted_at = $user['IsDeleted'] == 1 ? now()->format('Y-m-d H:i:s') : null;
                            $user_->save();
                            //seed policy file
                            $policy = new PolicyMBFile();
                            $policy->user_id = $client->id;
                            $policy->name = $user['DocumentName'];
                            $policy->name_ar = $user['DocumentNameAr'];
                            $policy->save();
                        }
                    }
                } else {

                }
            }
        }
    }
}
