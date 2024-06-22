<?php

namespace Database\Seeders;

use App\Models\Countries;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //check if Countries table is empty
        if (Countries::count() > 0) {
            return;
        }
        $contents = json_decode(file_get_contents('https://www.hrfactoryapp.com/Home/shipCountries'), true);
        //insert content to database
        foreach ($contents['countries'] as  $country) {
            $new_country = new Countries();
            $new_country->name = $country['Name'];
            $new_country->name_ar = $country['NameAr'];
            $new_country->country_code = $country['CountryCode'];
            $new_country->IsArabCountry = $country['IsArabCountry'];
            //is_active
            $new_country->is_active = true ;
            $new_country->save();
        }
    }
}
