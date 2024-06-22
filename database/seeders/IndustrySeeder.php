<?php

namespace Database\Seeders;

use App\Models\Industry;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IndustrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // check if Industry table is empty
        if (Industry::count() > 0) {
            return;
        }
        $contents = json_decode(file_get_contents('https://www.hrfactoryapp.com/Home/shipCountries'), true);
        // insert content to database
        foreach ($contents['industries'] as  $industry) {
            $new_industry = new Industry();
            $new_industry->name = $industry['Name'];
            $new_industry->name_ar = $industry['NameAr'];
            //system_create
            $new_industry->system_create = true;
            //is_active
            $new_industry->is_active = true;
            $new_industry->client_id = null;
            $new_industry->save();
        }
    }
}
