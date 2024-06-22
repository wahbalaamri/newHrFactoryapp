<?php

namespace App\Http\Controllers;

use App\Models\EmailContents;
use App\Http\Requests\StoreEmailContentsRequest;
use App\Http\Requests\UpdateEmailContentsRequest;
use App\Models\Clients;
use App\Models\ClientSubscriptions;
use App\Models\Countries;
use App\Models\Partners;
use App\Models\Partnerships;
use App\Models\scheduleAutoEmails;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EmailContentsController extends Controller
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
    public function store(StoreEmailContentsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(EmailContents $emailContents)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmailContents $emailContents)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmailContentsRequest $request, EmailContents $emailContents)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmailContents $emailContents)
    {
        //
    }
    //AutomatedEmails function
    public function AutomatedEmails(Request $request, $country = null, $type = null)
    {
        try {
            $emailContents = null;
            $countries = null;
            //get current user isadmin?
            if (!auth()->user()->isAdmin) {
                //check if user partner otherwise throw 403
                if (!auth()->user()->user_type == 'partner') {
                    //abort not autherized
                    abort(403, 'Unauthorized action.');
                }
                //get partner id
                $partner_id = auth()->user()->partner_id;
                //get partner
                $partner = Partners::find($partner_id);
                //get partner partnerships
                $partnerships = $partner->partnerships->where('is_active', true);
                //get partnerships country id
                $countries = Countries::whereIn('id', $partnerships->pluck('country_id')->toArray())->get();
            } else {
                //is admin

                $countries = Countries::all()->groupBy('IsArabCountry');
            }
            //if request is ajax
            if (request()->ajax()) {

                //build where
                $where = [];
                //if country is not null
                if ($country != "all")
                    if ($country) {
                        $where[] = ['country_id', $country];
                    }
                //if type is not null
                if ($type) {
                    $where[] = ['email_type', $type];
                }
                //get email contents
                $emailContents = EmailContents::where($where)->get();
                //return datatable
                return datatables()->of($emailContents)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $btn = '<a href="' . route('Emails.EditAutmoatedEmails', $row->id) . '" class="edit btn btn-primary btn-sm">Edit</a>';
                        return $btn;
                    })
                    ->editColumn('country', function ($row) {
                        $country_name = $row->country ? Countries::select(['name', 'name_ar'])->where($row->country)->first()->append('country_name')->country_name : __('For All Countries');
                        return $country_name;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
            //return view
            $data = [
                'countries' => $countries
            ];
            return view('dashboard.admin.emails.automatedEmails', compact('countries'));
        } catch (Exception $e) {
            Log::info($e->getMessage());
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
    //CreateInstantEmail  function
    public function CreateInstantEmail(Request $request)
    {
        try {
            //get countries
            $countries = Countries::all()->groupBy('IsArabCountry');
            //return view
            return view('dashboard.admin.emails.createInstantEmail', compact('countries'));
        } catch (Exception $e) {
            Log::info($e->getMessage());
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
    //SendInstantEmail function
    public function SendInstantEmail(Request $request)
    {
        $request->validate([
            'email_subject' => 'required',
            'email_subject_ar' => 'required',
            'email_header' => 'required',
            'email_header_ar' => 'required',
            'email_footer' => 'required',
            'email_footer_ar' => 'required',
        ]);
        try {
            $country = $request->country;
            $receivers = null;
            $where = [];
            if ($country) {
                $where[] = ['country', $country];
            }
            if ($request->client_type == "all") {
                //get all clients IDs
                $client_ids = Clients::select('id')->where('is_active', true)->where($where)->get()->pluck('id')->toArray();
                //select emails of client users
                $receivers = User::select('email')->whereIn('client_id', $client_ids)->where('is_main', true)->get()->pluck('email')->toArray();
                //get all partners IDs
                $partner_ids = Partners::select('id')->where('is_active', true)->where($where)->get()->pluck('id')->toArray();
                //select emails of partner users
                $receivers = array_merge($receivers, User::select('email')->whereIn('partner_id', $partner_ids)->where('is_main', true)->get()->pluck('email')->toArray());
            } elseif ($request->client_type == "all-p") {
                //get all partners IDs
                $partner_ids = Partners::select('id')->where('is_active', true)->where($where)->get()->pluck('id')->toArray();
                //select emails of partner users
                $receivers = User::select('email')->whereIn('partner_id', $partner_ids)->where('is_main', true)->get()->pluck('email')->toArray();
            } elseif ($request->client_type == "all-c") {
                //get all clients IDs
                $client_ids = Clients::select('id')->where('is_active', true)->where($where)->get()->pluck('id')->toArray();
                //select emails of client users
                $receivers = User::select('email')->whereIn('client_id', $client_ids)->where('is_main', true)->get()->pluck('email')->toArray();
            } elseif ($request->client_type == "AP") {
                //get all partners where there partnership is active
                $partners = Partnerships::select('partner_id')->where('is_active', true)->get()->pluck('partner_id')->toArray();
                $partner_ids = Partners::select('id')->whereIn('id', $partners)->where($where)->get()->pluck('id')->toArray();
                //select emails of partner users
                $receivers = User::select('email')->whereIn('partner_id', $partner_ids)->where('is_main', true)->get()->pluck('email')->toArray();
            } elseif ($request->client_type == "NC") {
                $receivers = [];
            } elseif ($request->client_type == "SC") {
                //get all subscribed clients IDs
                $clients = ClientSubscriptions::select('client_id')->where('is_active', true)->get()->pluck('client_id')->toArray();
                $client_ids = Clients::select('id')->whereIn('id', $clients)->where($where)->get()->pluck('id')->toArray();
                //select emails of client users
                $receivers = User::select('email')->whereIn('client_id', $client_ids)->where('is_main', true)->get()->pluck('email')->toArray();
            } elseif ($request->client_type == "USC") {
                //get all client who is not subscribed or his subscription is not active
                $client_ids = Clients::select('id')->where('is_active', true)->where($where)->get()->pluck('id')->toArray();
                //get all subscribed clients IDs
                $subscribed_client_ids = ClientSubscriptions::select('client_id')->where('is_active', true)->get()->pluck('client_id')->toArray();
                //get all not subscribed clients
                $not_subscribed_clients = array_diff($client_ids, $subscribed_client_ids);
                //select emails of client users
                $receivers = User::select('email')->whereIn('client_id', $not_subscribed_clients)->where('is_main', true)->get()->pluck('email')->toArray();
            } elseif ($request->client_type == "NSC") {
                $receivers = [];
            } elseif ($request->client_type == "ATES") {
                //get all subscribed clients whos there subscription will expire within on week
                $clients = ClientSubscriptions::select('client_id')->where('is_active', true)->where('end_date', '>=', now()->format('Y-m-d'))->where('end_date', '<=', now()->addWeek()->format('Y-m-d'))->get()->pluck('client_id')->toArray();
                $client_ids = Clients::select('id')->whereIn('id', $clients)->where($where)->get()->pluck('id')->toArray();
                //select emails of client users
                $receivers = User::select('email')->whereIn('client_id', $client_ids)->where('is_main', true)->get()->pluck('email')->toArray();
            }
        } catch (Exception $e) {
            Log::info($e->getMessage());
            //return back with error
            return back()->with('error', $e->getMessage());
        }
    }
    //CreateAutmoatedEmails function
    public function CreateAutmoatedEmails(Request $request)
    {
        try {
            //get countries
            $countries = Countries::all()->groupBy('IsArabCountry');
            //return view
            return view('dashboard.admin.emails.createAutomatedEmails', compact('countries'));
        } catch (Exception $e) {
            Log::info($e->getMessage());
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
    //SaveAutomatedEmails function
    public function SaveAutomatedEmails(Request $request)
    {
        $request->validate([
            'email_type' => 'required',
            'country' => 'required_if:email_type,1',
            'send_date' => 'required_if:email_type,2',
            'send_time' => 'required_if:email_type,2',
            'email_subject' => 'required',
            'email_subject_ar' => 'required',
            'email_header' => 'required',
            'email_header_ar' => 'required',
            'email_footer' => 'required',
            'email_footer_ar' => 'required',
        ]);
        try {
            $country = $request->country;
            //create email content
            $emailContent = EmailContents::create([
                'email_type' => $request->email_type == 1 ? "auto" : "schedule",
                'country' => $request->country,
                'subject' => $request->email_subject,
                'subject_ar' => $request->email_subject_ar,
                'body_header' => $request->email_header,
                'body_footer' => $request->email_footer,
                'body_header_ar' => $request->email_header_ar,
                'body_footer_ar' => $request->email_footer_ar,
                'created_by' => Auth()->user()->id,
                'created_by_type' => Auth()->user()->isAdmin ? 'admin' : 'partner',
                'status' => 1,
                'use_client_logo' => 0,
                'email_for' => $request->client_type
            ]);
            //if email_type =2
            if ($request->email_type == 2) {
                $receivers = null;
                $where = [];
                if ($country) {
                    $where[] = ['country', $country];
                }
                if ($request->client_type == "all") {
                    //get all clients IDs
                    $client_ids = Clients::select('id')->where('is_active', true)->where($where)->get()->pluck('id')->toArray();
                    //select emails of client users
                    $receivers = User::select('email')->whereIn('client_id', $client_ids)->where('is_main', true)->get()->pluck('email')->toArray();
                    //get all partners IDs
                    $partner_ids = Partners::select('id')->where('is_active', true)->where($where)->get()->pluck('id')->toArray();
                    //select emails of partner users
                    $receivers = array_merge($receivers, User::select('email')->whereIn('partner_id', $partner_ids)->where('is_main', true)->get()->pluck('email')->toArray());
                } elseif ($request->client_type == "all-p") {
                    //get all partners IDs
                    $partner_ids = Partners::select('id')->where('is_active', true)->where($where)->get()->pluck('id')->toArray();
                    //select emails of partner users
                    $receivers = User::select('email')->whereIn('partner_id', $partner_ids)->where('is_main', true)->get()->pluck('email')->toArray();
                } elseif ($request->client_type == "all-c") {
                    //get all clients IDs
                    $client_ids = Clients::select('id')->where('is_active', true)->where($where)->get()->pluck('id')->toArray();
                    //select emails of client users
                    $receivers = User::select('email')->whereIn('client_id', $client_ids)->where('is_main', true)->get()->pluck('email')->toArray();
                } elseif ($request->client_type == "AP") {
                    //get all partners where there partnership is active
                    $partners = Partnerships::select('partner_id')->where('is_active', true)->get()->pluck('partner_id')->toArray();
                    $partner_ids = Partners::select('id')->whereIn('id', $partners)->where($where)->get()->pluck('id')->toArray();
                    //select emails of partner users
                    $receivers = User::select('email')->whereIn('partner_id', $partner_ids)->where('is_main', true)->get()->pluck('email')->toArray();
                } elseif ($request->client_type == "NC") {
                    $receivers = [];
                } elseif ($request->client_type == "SC") {
                    //get all subscribed clients IDs
                    $clients = ClientSubscriptions::select('client_id')->where('is_active', true)->get()->pluck('client_id')->toArray();
                    $client_ids = Clients::select('id')->whereIn('id', $clients)->where($where)->get()->pluck('id')->toArray();
                    //select emails of client users
                    $receivers = User::select('email')->whereIn('client_id', $client_ids)->where('is_main', true)->get()->pluck('email')->toArray();
                } elseif ($request->client_type == "USC") {
                    //get all client who is not subscribed or his subscription is not active
                    $client_ids = Clients::select('id')->where('is_active', true)->where($where)->get()->pluck('id')->toArray();
                    //get all subscribed clients IDs
                    $subscribed_client_ids = ClientSubscriptions::select('client_id')->where('is_active', true)->get()->pluck('client_id')->toArray();
                    //get all not subscribed clients
                    $not_subscribed_clients = array_diff($client_ids, $subscribed_client_ids);
                    //select emails of client users
                    $receivers = User::select('email')->whereIn('client_id', $not_subscribed_clients)->where('is_main', true)->get()->pluck('email')->toArray();
                } elseif ($request->client_type == "NSC") {
                    $receivers = [];
                } elseif ($request->client_type == "ATES") {
                    //get all subscribed clients whos there subscription will expire within on week
                    $clients = ClientSubscriptions::select('client_id')->where('is_active', true)->where('end_date', '>=', now()->format('Y-m-d'))->where('end_date', '<=', now()->addWeek()->format('Y-m-d'))->get()->pluck('client_id')->toArray();
                    $client_ids = Clients::select('id')->whereIn('id', $clients)->where($where)->get()->pluck('id')->toArray();
                    //select emails of client users
                    $receivers = User::select('email')->whereIn('client_id', $client_ids)->where('is_main', true)->get()->pluck('email')->toArray();
                }
                //create schedule email
                $scheduleEmail = scheduleAutoEmails::create([
                    'email_id' => $emailContent->id,
                    'recivers' => json_encode($receivers),
                    'send_date' => $request->send_date,
                    'send_time' => $request->send_time,
                    'status' => 1,
                    'send_status' => 0,
                ]);
            }
            //return redirect
            return redirect()->route('Emails.AutomatedEmails');
        } catch (Exception $e) {
            Log::info($e->getMessage());
            //return back with error
            return back()->with('error', $e->getMessage());
        }
    }
}
