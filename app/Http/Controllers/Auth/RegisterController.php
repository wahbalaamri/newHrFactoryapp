<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\traits\CustomRegistersUsers;
use App\Models\Clients;
use App\Models\Companies;
use App\Models\Countries;
use App\Models\Employees;
use App\Models\FocalPoints;
use App\Models\Industry;
use App\Models\Partnerships;
use App\Models\Sectors;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    // use RegistersUsers;
    use CustomRegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
    //registerNewClient
    function registerNewClient(Request $request)
    {
        //validate request
        //validate company name english
        // $request->validate([
        //     'company_name_en' => 'required|string|max:255',
        //     'company_name_ar' => 'required|string|max:255',
        //     'phone' => 'required|string|max:255',
        //     'company_country' => 'required|integer',
        //     'company_sector' => 'required|integer',
        //     'company_size' => 'required|integer',
        //     'focal_name' => 'required|string|max:255',
        //     'focal_email' => 'required|string|max:255',
        //     'focal_phone' => 'required|string|max:255',
        //     'password' => 'required|string|min:8',
        // ]);
        //check if the user is already registered
        $user = User::where('email', $request->focal_email)->first();
        if ($user) {
            //return back with error message
            return back()->with('fail', 'You are already registered');
        } else {
            //check if logo_path has file
            if ($request->hasFile('logo_path')) {
                $file = $request->file('logo_path');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move('uploads/companies/logos/', $filename);
            } else {
                $filename = null;
            }
            // get current client country using API https://extreme-ip-lookup.com/json/?key=sswCYj3OKfeIuxY1C3Bd
            $client_ip = request()->ip();
            $client_country = file_get_contents("https://extreme-ip-lookup.com/json/?key=sswCYj3OKfeIuxY1C3Bd");
            $client_country = json_decode($client_country);
            $countryCode = $client_country->countryCode;
            //find the country from countries table
            $country = Countries::where('country_code', $countryCode)->first();
            // get partner id from partnerships table
            $partnership = Partnerships::where('country_id', $country->id)->first();
            //create new Client
            $newClient = new Clients();
            $newClient->name = $request->company_name_en;
            $newClient->name_ar = $request->company_name_ar;
            $newClient->country = $request->company_country;
            $newClient->industry = $request->company_sector;
            $newClient->client_size = $request->company_size;
            $newClient->phone = $request->phone;
            $newClient->logo_path = $filename;
            $newClient->webiste = $request->website;
            $newClient->partner_id = $partnership == null ? null : $partnership->partner_id;
            $newClient->save();
            //retrieve industry
            $industry = Industry::find($request->company_sector);
            //create new sector
            $newSector = new Sectors();
            $newSector->client_id = $newClient->id;
            $newSector->name_en = $industry->name;
            $newSector->name_ar = $industry->name_ar;
            $newSector->save();
            //add new comapny
            //create new company
            $company = new Companies();
            $company->client_id = $newClient->id;
            $company->sector_id = $newSector->id;
            $company->name_en = $request->company_name_en;
            $company->name_ar = $request->company_name_ar != null ? $request->company_name_ar : $request->company_name_en;
            $company->save();
            //new Employee
            $newEmployee = new Employees();
            $newEmployee->name = $request->focal_name;
            $newEmployee->client_id = $newClient->id;
            $newEmployee->email = $request->focal_email;
            $newEmployee->mobile = $request->focal_phone;
            $newEmployee->sector_id = $newSector->id;
            $newEmployee->comp_id = $company->id;
            $newEmployee->emp_id = null;
            $newEmployee->employee_type = 2;
            $newEmployee->isCandidate = false;
            $newEmployee->isBoard = false;
            $newEmployee->acting_for = null;
            $newEmployee->is_hr_manager = false;
            $newEmployee->added_by = 0;
            $newEmployee->save();
            //create new user
            $newUser = new User();
            $newUser->name = $request->focal_name;
            $newUser->email = $request->focal_email;
            $newUser->password = Hash::make($request->password);
            $newUser->client_id = $newClient->id;
            $newUser->sector_id = $newSector->id;
            $newUser->emp_id = $newEmployee->id;
            $newUser->is_main = true;
            //user_type
            $newUser->user_type = "client";
            //is_active
            $newUser->is_active = true;
            $newUser->save();
            //create new focal point
            $newFocal = new FocalPoints();
            $newFocal->name = $request->focal_name;
            $newFocal->email = $request->focal_email;
            $newFocal->phone = $request->focal_phone;
            $newFocal->client_id = $newClient->id;
            $newFocal->is_active = true;
            $newFocal->save();
            //redirect to login page with success message
            return redirect('/login')->with('success', 'You are registered successfully');
        }
    }
}
