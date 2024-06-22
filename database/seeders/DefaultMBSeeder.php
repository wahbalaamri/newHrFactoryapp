<?php

namespace Database\Seeders;

use App\Models\DefaultMB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DefaultMBSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // check if DefaultMB table is empty
        // if (DefaultMB::count() > 0) {
        //     return;
        // }
        $contents = json_decode(file_get_contents('https://www.hrfactoryapp.com/Home/shipDef?email=Admin@hrfactoryapp.com&country=158&companysize=1&lang=2'), true);
        // insert content to database
        foreach ($contents['defaultMBs'] as  $defaultMB) {
            $new_defaultMB = new DefaultMB();
            $new_defaultMB->id = $defaultMB['Id'];
            $new_defaultMB->title = $defaultMB['Title'];
            $new_defaultMB->ordering = $defaultMB['Ordering'];
            $new_defaultMB->paren_id = $defaultMB['ParenId'];
            $new_defaultMB->description = $defaultMB['Description'];
            $new_defaultMB->content = $defaultMB['Content'];
            $new_defaultMB->user_id = $defaultMB['UserId'];
            $new_defaultMB->IsActive = $defaultMB['IsActive'] == 1 ? true : false;
            $new_defaultMB->language = $defaultMB['LanguageId'] == 1 ? 'en' : 'ar';
            $new_defaultMB->IsHaveLineBefore = $defaultMB['IsHaveLineBefore'] == 1 ? true : false;
            $new_defaultMB->country_id = 155;
            $new_defaultMB->default_MB_id = $defaultMB['DefaultMBId'];
            $new_defaultMB->company_size = $defaultMB['CompanySize'];
            $new_defaultMB->company_industry = $defaultMB['CompanyIndustry'];
            $new_defaultMB->save();
        }
    }
}
