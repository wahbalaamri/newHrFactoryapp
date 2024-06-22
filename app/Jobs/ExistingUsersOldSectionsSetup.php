<?php

namespace App\Jobs;

use App\Models\UserSections;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ExistingUsersOldSectionsSetup implements ShouldQueue
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
        $old_sections = json_decode(file_get_contents('https://www.hrfactoryapp.com/Home/GetUserSections'), true);
        //insert old sections to new table
        // Log::info($old_sections);
        foreach ($old_sections['userSections'] as $old_section) {
            //insert old_section into UserSections
            $new_parent_sections = new UserSections();
            $new_parent_sections->Title = $old_section['Title'];
            $new_parent_sections->Ordering = $old_section['Ordering'];
            $new_parent_sections->ParenId = $old_section['ParenId'];
            $new_parent_sections->Description = $old_section['Description'];
            $new_parent_sections->Content = $old_section['Content'];
            $new_parent_sections->UserId = $old_section['UserId'];
            $new_parent_sections->IsActive = $old_section['IsActive'] == 1 ? true : false;
            $new_parent_sections->LanguageId = $old_section['LanguageId'];
            $new_parent_sections->IsHaveLineBefore = $old_section['IsHaveLineBefore'] == 1 ? true : false;
            $new_parent_sections->CountryID = $old_section['CountryID'];
            $new_parent_sections->DefaultMBId = $old_section['SectionId'];
            $new_parent_sections->CompanySize = $old_section['CompanySize'];
            $new_parent_sections->CompanyIndustry = $old_section['CompanyIndustry'];
            $new_parent_sections->save();
            $new_id=$new_parent_sections->id;
            //wait to fetch remote data
            $old_sub_sections = json_decode(file_get_contents('https://www.hrfactoryapp.com/Home/GetSubSections/?parent=' . $old_section['Id']), true);

            if (count($old_sub_sections['userSections']) > 0) {
                //insert old_subsections into userSections
                foreach ($old_sub_sections['userSections'] as $old_sub_section) {
                    $new_sub_sections = new UserSections();
                    $new_sub_sections->Title = $old_sub_section['Title'];
                    $new_sub_sections->Ordering = $old_sub_section['Ordering'];
                    $new_sub_sections->ParenId = $new_id;
                    $new_sub_sections->Description = $old_sub_section['Description'];
                    $new_sub_sections->Content = $old_sub_section['Content'];
                    $new_sub_sections->UserId = $old_sub_section['UserId'];
                    $new_sub_sections->IsActive = $old_sub_section['IsActive'] == 1 ? true : false;
                    $new_sub_sections->LanguageId = $old_sub_section['LanguageId'];
                    $new_sub_sections->IsHaveLineBefore = $old_sub_section['IsHaveLineBefore'] == 1 ? true : false;
                    $new_sub_sections->CountryID = $old_sub_section['CountryID'];
                    $new_sub_sections->DefaultMBId = $old_sub_section['SectionId'];
                    $new_sub_sections->CompanySize = $old_sub_section['CompanySize'];
                    $new_sub_sections->CompanyIndustry = $old_sub_section['CompanyIndustry'];
                    $new_sub_sections->save();
                    //update parent id
                }
            }
            // else {
            //     //log no subsctions
            //     // Log::alert('No Subsction');
            // }
        }
    }
}
