<?php

namespace Database\Seeders;

use App\Models\TermsConditions;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TermsConditionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // check if termsCondtions is empty
        if (TermsConditions::count() > 0) {
            return;
        }
        $contents = json_decode(file_get_contents('https://www.hrfactoryapp.com/Home/shipData'), true);
        // insert content to database
        foreach ($contents['termsConditions'] as  $termsCondition) {
            $new_termsCondition = new TermsConditions();
            $new_termsCondition->country_id=$termsCondition['CountryId'];
            $new_termsCondition->arabic_text = $termsCondition['ArabicText'];
            $new_termsCondition->english_text = $termsCondition['EnglishText'];
            $new_termsCondition->arabic_title = $termsCondition['ArabicTitle'];
            $new_termsCondition->english_title = $termsCondition['EnglishTitle'];
            $new_termsCondition->save();
        }
    }
}
