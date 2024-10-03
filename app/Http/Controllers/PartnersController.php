<?php

namespace App\Http\Controllers;

use App\Http\Facades\Landing;
use App\Http\Facades\TempURL;
use App\Models\Partners;
use App\Http\Requests\StorePartnersRequest;
use App\Http\Requests\UpdatePartnersRequest;
use App\Jobs\SendAccountInfoJob;
use App\Models\Countries;
use App\Models\PartnerFocalPoint;
use App\Models\Partnerships;
use App\Models\Services;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class PartnersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $L_TempURL;
    public function index(Request $request)
    {
        //check if $request has signature
        if ($request->ajax()) {
            //datatable
            $data = Partners::all()->append(['focal_points_count', 'partnerships_count']);
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('country', function ($row) {
                    return $row->countryObj->country_name;
                })
                //add action
                ->addColumn('action', function ($row) {
                    //edit partners
                    $btn = '<a href="javascript:void(0)" class="edit btn btn-info btn-xs">Edit</a>';
                    //delete partners
                    $btn = $btn . ' <a href="javascript:void(0)" class="delete btn btn-danger btn-xs">Delete</a>';
                    return $btn;
                })
                ->addColumn('FocalPoints', function ($row) {
                    $url = TempURL::getTempURL('partner.FocalPoints', 5, $this->encrypt_data($row->id));
                    return $url;
                })
                ->addColumn('SaveFocalPoints', function ($row) {
                    $url = TempURL::getTempURL('partner.SaveFocalPoint', 5, $this->encrypt_data($row->id));
                    return $url;
                })
                ->addColumn('Partnerships', function ($row) {
                    $url = TempURL::getTempURL('partner.Partnerships', 5, $this->encrypt_data($row->id));
                    return $url;
                })
                ->addColumn('SavePartnerships', function ($row) {
                    $url = TempURL::getTempURL('partner.SavePartnership', 5, $this->encrypt_data($row->id));
                    return $url;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        if ($request->signature) {
            if (TempURL::getIsValidUrl($request)) {
                $data = [
                    'url' => TempURL::getTempURL('partners.index', 5),
                    'countries' => Countries::all()->groupBy('IsArabCountry')->append('country_name'),
                    'services' => Services::where('public_availability', true)->get(),
                ];
                return view('dashboard.partners.index')->with($data);
            } else {
                $temp = TempURL::getTempURL('partners.index', 5);
                $this->L_TempURL = $temp;
                return redirect($temp);
            }
        } else {

            $temp = TempURL::getTempURL('partners.index', 5);
            return redirect($temp);
        }
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
    public function store(StorePartnersRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Partners $partners)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Partners $partners)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePartnersRequest $request, Partners $partners)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Partners $partners)
    {
        //
    }
    function SavePartner(Request $request)
    {
        try {
            if (TempURL::getIsValidUrl($request)) {
                //check value of id if its null or not
                if ($request->id)
                    $partner = Partners::find($request->id);
                else
                    $partner = new Partners();
                //check if logo has file
                if ($request->hasFile('logo')) {
                    $file = $request->file('logo');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() . '.' . $extension;
                    $file->move('uploads/companies/logos/', $filename);
                    $partner->logo_path = $filename;
                } elseif ($partner->logo_path == null) {
                    $partner->logo_path = "noimage.jpg";
                }
                $partner->name = $request->name;
                $partner->name_ar = null;
                $partner->country = $request->country;
                $partner->webiste = $request->webiste;
                $partner->is_active = $request->Pstatus == 1;
                $partner->save();
                return response()->json(['msg' => 'Data is successfully saved', 'stat' => true]);
            }
            return response()->json(['msg' => 'URL you used is expired. Re-fresh the page', 'stat' => false]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['msg' => 'Error occured while saving data', 'stat' => false]);
        }
    }
    function encrypt_data($data)
    {
        return base64_encode($data);
    }
    function decrypt_data($data)
    {
        return base64_decode($data);
    }
    function FocalPoints(Request $request, $id)
    {
        try {
            if ($request->signature) {
                if (TempURL::getIsValidUrl($request)) {
                    $decrypted_id = $this->decrypt_data($id);
                    $focal_points = PartnerFocalPoint::where('partner_id', $decrypted_id)->get();
                    $data = [
                        'stat' => true,
                        'msg' => "Data retrived successfully.",
                        'focal_points' => $focal_points,
                    ];
                } else {
                    $data = [
                        'stat' => false,
                        'msg' => "URL you used is expired. Re-fresh the page",
                    ];
                }
            } else {
                $data = [
                    'stat' => false,
                    'msg' => "URL you used is expired. Re-fresh the page",
                ];
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $data = [
                'stat' => false,
                'msg' => "Error occured while saving data",
            ];
        }
        return response()->json($data);
    }
    //SaveFocalPoint
    function SaveFocalPoint(Request $request, $id)
    {
        $decrypted_id = $this->decrypt_data($id);
        try {
            $email = "";
            $name = $request->focal_name;
            $auto_pass = Landing::generateRandomPassword();
            if (TempURL::getIsValidUrl($request)) {
                if ($request->focal_id) {
                    $focal_point = PartnerFocalPoint::find($request->focal_id);
                    $email = $focal_point->email;
                } else { //check email already exists
                    $user = User::where('email', $request->focal_email)->first();
                    if ($user)
                        return response()->json(['msg' => 'Email already exists', 'stat' => false]);

                    $focal_point = new PartnerFocalPoint();
                }
                $focal_point->partner_id = $decrypted_id;
                $focal_point->name = $name;
                $focal_point->name_ar = $request->focal_name_ar;
                $focal_point->country = $request->focal_country;
                $focal_point->phone = $request->focal_phone;
                $focal_point->Email = $request->focal_email;
                $focal_point->position = $request->focal_position;
                $focal_point->is_active = $request->focal_status ? true : false;
                $focal_point->save();
                //add user
                if ($request->focal_id) {
                    //find user
                    $user = User::where('email', $email)->first();
                    $focal_points_count = PartnerFocalPoint::where('partner_id', $decrypted_id)->count();
                }
                if ($user == null) {
                    $user = new User();
                    //get count of focalpoint for current partner
                    $focal_points_count = PartnerFocalPoint::where('partner_id', $decrypted_id)->count();
                }
                $user->name = $name;
                $user->email = $request->focal_email;
                $user->client_id = null;
                $user->partner_id = $decrypted_id;
                $user->sector_id = null;
                $user->comp_id = null;
                $user->dep_id = null;
                $user->user_type = 'partner';
                $user->emp_id = null;
                if ($request->focal_id == null) {
                    $user->is_main = $focal_points_count > 0 ? false : true;
                    $user->password = bcrypt($auto_pass);
                }
                $user->isAdmin = false;
                $user->lang = 1;
                $user->hide_my_result = false;
                $user->is_active = $request->focal_status ? true : false;
                $user->save();
                if ($request->focal_id == null) {
                    $email = $user->email;
                    $password = $auto_pass;
                    $job = (new SendAccountInfoJob($email, $password))->delay(now()->addSeconds(2));
                    dispatch($job);
                }
                $data = [
                    'stat' => true,
                    'msg' => "Data is successfully saved",
                    'focals' => PartnerFocalPoint::where('partner_id', $decrypted_id)->get()
                ];
            } else {
                $data = [
                    'stat' => false,
                    'msg' => "URL you used is expired. Re-fresh the page",
                ];
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $data = [
                'stat' => false,
                'msg' => "Error occured while saving data",
            ];
        }
        return response()->json($data);
    }
    //Partnerships function
    function Partnerships(Request $request, $id)
    {
        try {
            if ($request->signature) {
                if (TempURL::getIsValidUrl($request)) {
                    $decrypted_id = $this->decrypt_data($id);
                    $partnerships = Partners::find($decrypted_id)->partnerships->append(['exclusive', 'active']);

                    foreach ($partnerships as $pratnerShip) {
                        $pratnerShip->country_name = $pratnerShip->country->country_name;
                    }
                    $data = [
                        'stat' => true,
                        'msg' => "Data retrived successfully.",
                        'partnerships' => $partnerships,
                    ];
                } else {
                    $data = [
                        'stat' => false,
                        'msg' => "URL you used is expired. Re-fresh the page",
                    ];
                }
            } else {
                $data = [
                    'stat' => false,
                    'msg' => "URL you used is expired. Re-fresh the page",
                ];
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $data = [
                'stat' => false,
                'msg' => "Error occured while saving data",
            ];
        }
        return response()->json($data);
    }
    //SavePartnership function
    function SavePartnership(Request $request, $id)
    {
        $decrypted_id = $this->decrypt_data($id);
        try {
            Log::info($request->all());
            if (TempURL::getIsValidUrl($request)) {
                //get all inputs start with s-
                $services = array_filter($request->all(), function ($key) {
                    return strpos($key, 's-') === 0;
                }, ARRAY_FILTER_USE_KEY);
                //get the kes of services
                // $keys = array_keys($services);
                //remove the s- from the keys
                // $keys = array_map(function ($key) {
                //     return substr($key, 2);
                // }, $keys);
                if ($request->partnership_id)
                    $partnership = Partnerships::find($request->partnership_id);
                else
                    $partnership = new Partnerships();
                $partnership->partner_id = $decrypted_id;
                $partnership->country_id = $request->country;
                $partnership->start_date = $request->start_date;
                $partnership->end_date = $request->end_date;
                $partnership->is_exclusive = $request->exclusivity ? true : false;
                $partnership->is_active = $request->status ? true : false;
                //save services as json array
                $partnership->services = json_encode($services);
                $partnership->save();
                Log::info($partnership);
                $pratnerShips = Partnerships::where('partner_id', $decrypted_id)->get();

                $data = [
                    'stat' => true,
                    'msg' => "Data is successfully saved",
                    'partnerships' => $pratnerShips/* collect($new_pratnerShips) */
                ];
            } else {
                $data = [
                    'stat' => false,
                    'msg' => "URL you used is expired. Re-fresh the page",
                ];
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $data = [
                'stat' => false,
                'msg' => "Error occured while saving data",
            ];
        }
        return response()->json($data);
    }
}
