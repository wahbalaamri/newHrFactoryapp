<?php

namespace App\Http\Controllers;

use App\Models\UserSections;
use App\Http\Requests\StoreUserSectionsRequest;
use App\Http\Requests\UpdateUserSectionsRequest;
use App\Models\Clients;
use App\Models\Companies;
use App\Models\Employees;
use App\Models\FocalPoints;
use App\Models\Sectors;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserSectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserSectionsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(UserSections $userSections)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserSections $userSections)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserSectionsRequest $request, UserSections $userSections)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserSections $userSections)
    {
        //
    }
    public function setUpMissingUsers()
    {
        //read clients from client.json
        $clients = file_get_contents(public_path('uploads/clients.json'));
        $clients = json_decode($clients, true);
        //read sectors from sectors.json
        $sectors = file_get_contents(public_path('uploads/sectors.json'));
        $sectors = json_decode($sectors, true);
        //read companies from companies.json
        $companies = file_get_contents(public_path('uploads/companies.json'));
        $companies = json_decode($companies, true);
        //read employees from employees.json
        $employees = file_get_contents(public_path('uploads/employees.json'));
        $employees = json_decode($employees, true);
        //read FocalPoints from FocalPoints.json
        $FocalPoints = file_get_contents(public_path('uploads/FocalPoints.json'));
        $FocalPoints = json_decode($FocalPoints, true);
        //read users from users.json
        $users = file_get_contents(public_path('uploads/User.json'));
        $users = json_decode($users, true);
        //loop through clients
        // foreach ($clients['rows'] as $client) {
        //     Log::info($client);
        // }
        //dd clients, sectors, companies, employees, FocalPoints, users
        Log::info($clients['rows']);
        foreach ($clients['rows'] as $client) {
            Log::info($client);
            $client_id = $client['id'];
            //find sector from $sectors with $client_id
            $sector = collect($sectors['rows'])->where('client_id', $client_id)->first();
            //find company from $companies with $client_id
            $company = collect($companies['rows'])->where('client_id', $client_id)->first();
            //find employee from $employees with $client_id
            $employee = collect($employees['rows'])->where('client_id', $client_id)->first();
            //find FocalPoint from $FocalPoints with $client_id
            $FocalPoint = collect($FocalPoints['rows'])->where('client_id', $client_id)->first();
            //find user from $users with $client_id
            $user = collect($users['rows'])->where('client_id', $client_id)->first();
            //check if client exist
            $client1 = Clients::where('name', $client['name'])->first();
            if ($client1) {
                $new_client = $client1;
            }
            //add client
            else
                $new_client = new Clients();
            $new_client->name = $client['name'];
            $new_client->name_ar = $client['name_ar'];
            $new_client->country = $client['country'];
            $new_client->industry = $client['industry'];
            $new_client->client_size = $client['client_size'];
            $new_client->use_sections = $client['use_sections'] == 1 ? true : false;
            $new_client->is_active = $client['is_active'] == 1 ? true : false;
            $new_client->save();
            //check if sector exist
            $sector1 = Sectors::where('name_en', $sector['name_en'])->where('client_id', $new_client->id)->first();
            if ($sector1) {
                $new_sector = $sector1;
            }
            //add sector
            else
                $new_sector = new Sectors();
            $new_sector->client_id = $new_client->id;
            $new_sector->name_en = $sector['name_en'];
            $new_sector->name_ar = $sector['name_ar'];
            $new_sector->save();
            //check if company exist
            $company1 = Companies::where('name_en', $company['name_en'])->where('client_id', $new_client->id)->first();
            if ($company1) {
                $new_company = $company1;
            }
            //add company
            else
                $new_company = new Companies();
            $new_company->client_id = $new_client->id;
            $new_company->sector_id = $new_sector->id;
            $new_company->name_en = $company['name_en'];
            $new_company->name_ar = $company['name_ar'];
            $new_company->save();
            //check if employee exist
            $employee1 = Employees::where('name', $employee['name'])->where('client_id', $new_client->id)->first();
            if ($employee1) {
                $new_employee = $employee1;
            }
            //add employee
            else
                $new_employee = new Employees();
            $new_employee->client_id = $new_client->id;
            $new_employee->comp_id = $new_company->id;
            $new_employee->sector_id = $new_sector->id;
            $new_employee->name = $employee['name'];
            $new_employee->email = $employee['email'];
            $new_employee->mobile = $employee['mobile'];
            $new_employee->employee_type = $employee['employee_type'];
            $new_employee->isCandidate = $employee['isCandidate'] == 1;
            $new_employee->isBoard = $employee['isBoard'] == 1;
            $new_employee->is_hr_manager = $employee['is_hr_manager'] == 1;
            $new_employee->added_by = $employee['added_by'];
            $new_employee->active = $employee['active'] == 1;
            $new_employee->save();
            //check if FocalPoint exist
            $FocalPoint1 = FocalPoints::where('name', $FocalPoint['name'])->where('client_id', $new_client->id)->first();
            if ($FocalPoint1) {
                $new_FocalPoint = $FocalPoint1;
            }
            //add FocalPoint
            else
                $new_FocalPoint = new FocalPoints();
            $new_FocalPoint->client_id = $new_client->id;
            $new_FocalPoint->name = $FocalPoint['name'];
            $new_FocalPoint->name_ar = $FocalPoint['name_ar'];
            $new_FocalPoint->email = $FocalPoint['email'];
            $new_FocalPoint->phone = $FocalPoint['phone'];
            $new_FocalPoint->save();
            //check if user exist
            $user1 = User::where('name', $user['name'])->where('email',$user['email'])->first();
            if ($user1) {
                $new_user = $user1;
            }
            //add user
            else
                $new_user = new User();
            $new_user->client_id = $new_client->id;
            $new_user->sector_id = $new_sector->id;
            $new_user->comp_id = $new_company->id;
            $new_user->emp_id = $new_employee->id;
            $new_user->name = $user['name'];
            $new_user->email = $user['email'];
            $new_user->user_type = $user['user_type'];
            $new_user->password = $user['password'];
            $new_user->is_main = $user['is_main'] == 1;
            $new_user->isAdmin = $user['isAdmin'] == 1;
            $new_user->lang = $user['lang'];
            $new_user->hide_my_result = $user['hide_my_result'] == 1;
            $new_user->is_active = $user['is_active'] == 1;
            $new_user->save();
        }
        dd("done");
    }
}
