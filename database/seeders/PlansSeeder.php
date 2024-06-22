<?php

namespace Database\Seeders;

use App\Models\Plans;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // //
        // //check if plans table is empty
        // if (Plans::count() > 0) {
        //     return;
        // }

        // $contents = json_decode(file_get_contents('https://www.hrfactoryapp.com/Home/shipData'), true);
        // //insert content to database
        // foreach ($contents['plans'] as  $plan) {
        //     //seed plans
        //     Plans::create([
        //         'Name' => $plan['Name'],
        //         'NameAR' => $plan['NameAR'],
        //         'currency' => 'OMR',
        //         'AnnualPrice' => $plan['AnnualPrice'],
        //         'ManthlyPrice' => $plan['ManthlyPrice'],
        //         //created_at now
        //         'created_at' => now()->format('Y-m-d H:i:s'),
        //         //                'updated_at'=>now(),
        //         'updated_at' => now()->format('Y-m-d H:i:s'),
        //     ]);
        // }
    }
}
