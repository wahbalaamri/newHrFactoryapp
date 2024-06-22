<?php

namespace Database\Seeders;

use App\Models\UserPlans;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserPlansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // //truncate table
        // UserPlans::truncate();
        // //check if UserPlans is empty
        // if (UserPlans::count() > 0) {
        //     return;
        // }
        // $contents = json_decode(file_get_contents('https://www.hrfactoryapp.com/Home/shipCoupons'), true);
        // // insert content to database
        // foreach ($contents['userPlans'] as  $userPlan) {
        //     $new_userPlan = new UserPlans();
        //     $new_userPlan->PlanId = $userPlan['PlanId'];
        //     $new_userPlan->UserId = $userPlan['UserId'];
        //     $new_userPlan->StartDate = date('Y-m-d H:i:s', preg_replace('/[^\d]/','', $userPlan['StartDate'])/1000);
        //     $new_userPlan->EndDate = date('Y-m-d H:i:s', preg_replace('/[^\d]/','', $userPlan['EndDate'])/1000);
        //     $new_userPlan->IsActive = $userPlan['IsActive'] == 1 ? true : false;
        //     $new_userPlan->Price = doubleval($userPlan['Price']);
        //     $new_userPlan->IsFreeUsed = $userPlan['IsFreeUsed'] == 1 ? true : false;
        //     $new_userPlan->IsFreeActive = $userPlan['IsFreeActive'] == 1 ? true : false;
        //     $new_userPlan->save();
        // }
    }
}
