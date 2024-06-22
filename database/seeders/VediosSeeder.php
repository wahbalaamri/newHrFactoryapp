<?php

namespace Database\Seeders;

use App\Models\Vedios;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VediosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // check if vedios table is empty
        if (Vedios::count() > 0) {
            return;
        }
        $contents = json_decode(file_get_contents('https://www.hrfactoryapp.com/Home/shipCoupons'), true);
        // insert content to database
        foreach ($contents['introVedios'] as  $vedio) {
            $new_vedio = new Vedios();
            $new_vedio->Uploaded = $vedio['Uploaded'];
            $new_vedio->EmbadedEnglish = $vedio['EmbadedEnglish'];
            $new_vedio->UploadedEnglish = $vedio['UploadedEnglish'];
            $new_vedio->EmbadedArabic = $vedio['EmbadedArabic'];
            $new_vedio->UploadedArabic = $vedio['UploadedArabic'];
            $new_vedio->save();
        }
    }
}
