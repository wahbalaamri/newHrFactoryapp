<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\UserSections;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SetupUsersIdInUsersOldSections implements ShouldQueue
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
        //get all users
        $users = User::all();
        foreach ($users as $user) {
            $id = $user->id;
            //email
            $email = $user->email;
            //remotely getuserbyemail
            $contents = json_decode(file_get_contents('https://www.hrfactoryapp.com/Home/getUserByEmail?email=' . $email), true);
            //check if user has a plan
            $oldId = $contents['Id'];
            //update userid in uuserplans table
            // $userplans = UserPlans::where('UserId', $oldId)->get();
            // foreach($userplans as $userplan)
            // {
            //     $userplan->UserId=$id;
            //     $userplan->save();
            // }
            //update userid in usersections table
            $usersections = UserSections::where('UserId', $oldId)->update(['UserId' => $user->id]);
        }
    }
}
