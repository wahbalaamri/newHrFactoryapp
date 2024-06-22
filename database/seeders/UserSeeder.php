<?php

namespace Database\Seeders;

use App\Jobs\UserSeederJob;
use App\Models\Clients;
use App\Models\Companies;
use App\Models\Countries;
use App\Models\Employees;
use App\Models\FocalPoints;
use App\Models\Industry;
use App\Models\PolicyMBFile;
use App\Models\Sectors;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //call userSeederJob
        $job = (new UserSeederJob())->delay(now()->addSeconds(2));
        dispatch($job);
    }
}
