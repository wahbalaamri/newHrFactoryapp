<?php

namespace App\Http\Controllers;

use App\Models\DefaultMB;
use App\Http\Requests\StoreDefaultMBRequest;
use App\Http\Requests\UpdateDefaultMBRequest;
use App\Models\Clients;
use App\Models\ClientSubscriptions;
use App\Models\Countries;
use App\Models\FocalPoints;
use App\Models\Partnerships;
use App\Models\Plans;
use App\Models\Services;
use App\Models\UserSections;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DefaultMBController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $country = 155, $plan = null)
    {
        $user_id = auth()->user()->id;
        //get current user type
        $user_type = auth()->user()->user_type;
        $available_countries = [];
        $partnerships_countries = [];
        $exist_plans_id = [];
        //
        if (auth()->user()->isAdmin) {
            //get all terms
            //get all countries
            $countries = Countries::all()->groupBy('IsArabCountry');
        } elseif ($user_type == "partner") {
            //get all partnerships
            $partnerships_countries = Partnerships::where('partner_id', auth()->user()->partner_id)->get()->pluck('country_id')->toArray();
            //get all terms where plan is null
            //get countries
            $countries = Countries::whereIn('id', $partnerships_countries)->get();
        } else {
            //abort not autherized
            abort(403);
        }
        $sections = [];
        if ($plan != null) {
            $sections = DefaultMB::where('country_id', $country)->where('plan_id', $plan)->whereNull('paren_id')->where('language', app()->isLocale('en') ? 'en' : 'ar')->orderBy('ordering')->get();
            if (count($sections) > 0) {
                //get countries which has DefaultMB
                $available_countries = Countries::whereHas('defaultMB', function ($query) {
                    $query->where('language', app()->isLocale('en') ? 'en' : 'ar');
                })->get();
            }
        }
        //get plans of manual builders service
        $plans = Plans::where('service', function ($quere) {
            $quere->select('id')->from('services')->where('service_type', 1);
        })->get();
        //get defualt country
        $default_country = Countries::where('name', 'Oman')->first();
        if (count($plans) > 0) {
            if (count($sections) == 0 && $plan == null)
                return redirect()->route('manualBuilder.index', [$default_country->id, $plans[0]->id]);
        }
        if (count($plans) > 0 && count($sections) == 0) {
            //get unique plans id of current country sections
            $exist_plans_id = DefaultMB::where('country_id', $country)->where('language', app()->isLocale('en') ? 'en' : 'ar')->whereNotNull('plan_id')->groupBy('plan_id')->pluck('plan_id')->toArray();
        }
        $data = [
            'sections' => $sections,
            'countries' => $countries,
            'country_id' => $country,
            'available_countries' => $available_countries,
            'plans' => $plans,
            'plan_id' => $plan,
            'default_country' => $default_country,
            'partnerships_countries' => $partnerships_countries,
            'exist_plans_id' => $exist_plans_id,
        ];
        return view('dashboard.admin.ManualBuilder.index', $data);
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
    public function store(StoreDefaultMBRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(DefaultMB $defaultMB)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DefaultMB $defaultMB)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDefaultMBRequest $request, DefaultMB $defaultMB)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DefaultMB $defaultMB)
    {
        //
    }
    public function reorder(Request $request)
    {
        $orderData = $request->orderData;
        foreach ($orderData as $key => $value) {
            $section = DefaultMB::find($value['id']);
            $section->ordering = $value['ordering'];
            $section->save();
        }
        return response()->json(['message' => 'Sections reordered successfully']);
    }
    public function updateSection(Request $request)
    {
        try {
            $IsHaveLineBefore = $request->IsHaveLineBefore == "true" ? true : false;
            $lang = app()->getLocale();
            //find section by id
            $section = DefaultMB::find($request->id);
            //update title, content and IsHaveLineBefore
            $section->title = $request->title;
            $section->content = $request->content;
            $section->IsHaveLineBefore = $IsHaveLineBefore;
            $section->save();
            return response()->json(['message' => 'Section updated successfully', 'stat' => true]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'Something went wrong, please try again later', 'stat' => false], 500);
        }
    }
    //storeSection function
    public function storeSection(Request $request)
    {
        try {
            $IsHaveLineBefore = $request->IsHaveLineBefore == "true" ? true : false;
            $lang = app()->getLocale();
            //find max ordering
            $maxOrdering = DefaultMB::where('country_id', $request->country)->where('paren_id', $request->parent)->where('language', $lang == 'en' ? 'en' : 'ar')->max('ordering');
            //create new section
            $section = new DefaultMB();
            $section->paren_id = $request->parent;
            $section->title = $request->title;
            $section->content = $request->content;
            $section->IsHaveLineBefore = $IsHaveLineBefore;
            $section->country_id = $request->country;
            $section->plan_id = $request->plan;
            $section->language = $lang == 'en' ? 'en' : 'ar';
            $section->default_MB_id = 0;
            $section->IsActive = true;
            $section->company_size = 1;
            $section->company_industry = 1;
            $section->ordering = $maxOrdering + 1;
            $section->save();
            return response()->json(['message' => 'Section created successfully', 'stat' => true]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'Something went wrong, please try again later', 'stat' => false], 500);
        }
    }
    //newCountry function
    public function newCountry(Request $request)
    {
        try {
            $default_country = Countries::where('name', 'Oman')->first();
            $default_counrty = $default_country->id;
            //get all section for default country
            $sections = DefaultMB::where('country_id', $default_counrty)->where('plan_id', $request->new_plan)->whereNull('paren_id')->get();
            $new_country = $request->new_country;
            //add all section to new country
            foreach ($sections as $section) {
                $new_section = new DefaultMB();
                $new_section->paren_id = $section->paren_id;
                $new_section->title = $section->title;
                $new_section->content = $section->content;
                $new_section->plan_id = $section->plan_id;
                $new_section->IsHaveLineBefore = $section->IsHaveLineBefore;
                $new_section->country_id = $new_country;
                $new_section->language = $section->language;
                $new_section->default_MB_id = $section->default_MB_id;
                $new_section->IsActive = $section->IsActive;
                $new_section->company_size = $section->company_size;
                $new_section->company_industry = $section->company_industry;
                $new_section->ordering = $section->ordering;
                $new_section->save();
                //get children
                if (count($section->children) > 0) {
                    foreach ($section->children as $child) {
                        $new_child = new DefaultMB();
                        $new_child->paren_id = $new_section->id;
                        $new_child->title = $child->title;
                        $new_child->content = $child->content;
                        $new_child->plan_id = $child->plan_id;
                        $new_child->IsHaveLineBefore = $child->IsHaveLineBefore;
                        $new_child->country_id = $new_country;
                        $new_child->language = $child->language;
                        $new_child->default_MB_id = $child->default_MB_id;
                        $new_child->IsActive = $child->IsActive;
                        $new_child->company_size = $child->company_size;
                        $new_child->company_industry = $child->company_industry;
                        $new_child->ordering = $child->ordering;
                        $new_child->save();
                    }
                }
            }
            return response()->json(['message' => 'Section created successfully', 'stat' => true]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'Something went wrong, please try again later', 'stat' => false], 500);
        }
    }
    //updateSectionAvailablity function
    public function updateSectionAvailablity(Request $request)
    {
        try {
            $section = DefaultMB::find($request->id);
            $section->IsActive = $request->IsActive == "true" ? true : false;
            $section->save();
            return response()->json(['message' => 'Section updated successfully', 'stat' => true]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'Something went wrong, please try again later', 'stat' => false], 500);
        }
    }
    //deleteSection function
    public function deleteSection(Request $request)
    {
        try {
            $section = DefaultMB::find($request->id);
            if ($request->type == "p" && (count($section->children) > 0) && $section) {
                foreach ($section->children as $child) {
                    $child->delete();
                }
            }
            $section->delete();
            return response()->json(['message' => 'Section deleted successfully', 'stat' => true]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'Something went wrong, please try again later', 'stat' => false], 500);
        }
    }
    //ClientSections function
    public function ClientSections(Request $request, $id)
    {
        try {
            //get service of manaul builder
            $service = Services::where('service_type', 1)->first();
            //get ids plans of manual builder
            $plans = Plans::where('service', $service->id)->pluck('id')->toArray();
            //get active user subscriptions
            $subscriptions = ClientSubscriptions::where('client_id', $id)
                ->whereIn('plan_id', $plans)
                ->where('is_active', true)->first();
            //get type of plan
            $plan_type = Plans::where('id', $subscriptions->plan_id)->first()->plan_type;
            $sections = UserSections::where('user_id', $id)->whereNull('paren_id')->where('language', app()->getLocale())->get();
            $contents = [];
            $data = [
                'sections' => $sections->sortBy('ordering'),
                'contents' => $contents,
                'id' => $id,
                'client' => Clients::find($id),
                'plan_type' => $plan_type
            ];
            return view('dashboard.admin.ManualBuilder.ClientSections')->with($data);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'Something went wrong, please try again later', 'stat' => false], 500);
        }
    }
    //copysections function
    public function copysections(Request $request, $id)
    {
        try {
            //find client
            $client = Clients::find($id);
            //get client country
            $country = $client->country;
            //get service plans
            $plans = Plans::where('service', function ($quere) {
                $quere->select('id')->from('services')->where('service_type', 1);
            })->get();
            //get plans id
            $plans_id = $plans->pluck('id')->toArray();
            $subscribed_plan_ = $client->subscriptions->where('is_active', true)->whereIn('plan_id', $plans_id)->first();
            $subscribed_plan = $subscribed_plan_->plan_id;
            if ($plans->where('id', $subscribed_plan)->first()->plan_type == 5) {
                //get
                $subscribed_plan = $plans->where('plan_type', 1)->first()->id;
            }
            //get client active subscriptions
            $sections = DefaultMB::where('country_id', $country)->where('plan_id', $subscribed_plan)->whereNull('paren_id')->get();
            //check if $sections has value
            $sections = count($sections) > 0 ? $sections : DefaultMB::where('country_id', 155)->where('plan_id', $subscribed_plan)->whereNull('paren_id')->get();
            foreach ($sections as $section) {
                //check if the section already there
                $new_section = UserSections::where('default_MB_id', $section->id)->where('user_id', $id)->first();
                if (!$new_section)
                    $new_section = new UserSections();
                $new_section->paren_id = $section->paren_id;
                $new_section->title = $section->title;
                $new_section->content = $section->content;
                $new_section->plan_id = $section->plan_id;
                $new_section->IsHaveLineBefore = $section->IsHaveLineBefore;
                $new_section->country_id = $country;
                $new_section->language = $section->language;
                $new_section->default_MB_id = $section->id;
                $new_section->IsActive = $section->IsActive;
                $new_section->company_size = $section->company_size;
                $new_section->company_industry = $section->company_industry;
                $new_section->ordering = $section->ordering;
                $new_section->user_id = $id;
                $new_section->save();
                //get children
                if (count($section->children) > 0) {
                    foreach ($section->children as $child) {
                        $new_child = new UserSections();
                        $new_child->paren_id = $new_section->id;
                        $new_child->title = $child->title;
                        $new_child->content = $child->content;
                        $new_child->plan_id = $child->plan_id;
                        $new_child->IsHaveLineBefore = $child->IsHaveLineBefore;
                        $new_child->country_id = $country;
                        $new_child->language = $child->language;
                        $new_child->default_MB_id = $child->id;
                        $new_child->IsActive = $child->IsActive;
                        $new_child->company_size = $child->company_size;
                        $new_child->company_industry = $child->company_industry;
                        $new_child->ordering = $child->ordering;
                        $new_child->user_id = $id;
                        $new_child->save();
                    }
                }
            }
            return redirect()->route('manualBuilder.ClientSections', $id);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'Something went wrong, please try again later', 'stat' => false], 500);
        }
    }
    public function clientSectionsreorder(Request $request)
    {
        $orderData = $request->orderData;
        foreach ($orderData as $key => $value) {
            $section = UserSections::find($value['id']);
            $section->ordering = $value['ordering'];
            $section->save();
        }
        return response()->json(['message' => 'Sections reordered successfully']);
    }
    public function clientSectionsupdate(Request $request)
    {
        try {
            $IsHaveLineBefore = $request->IsHaveLineBefore == "true" ? true : false;
            $lang = app()->getLocale();
            //find section by id
            $section = UserSections::find($request->id);
            //update title, content and IsHaveLineBefore
            $section->title = $request->title;
            $section->content = $request->content;
            $section->IsHaveLineBefore = $IsHaveLineBefore;
            $section->save();
            return response()->json(['message' => 'Section updated successfully', 'stat' => true]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'Something went wrong, please try again later', 'stat' => false], 500);
        }
    }
    //storeSection function
    public function clientSectionsstore(Request $request)
    {
        try {
            $IsHaveLineBefore = $request->IsHaveLineBefore == "true" ? true : false;
            $lang = app()->getLocale();
            //find max ordering
            $maxOrdering = UserSections::where('country_id', $request->country)->where('paren_id', $request->parent)->where('language', $lang == 'en' ? 'en' : 'ar')->max('ordering');
            //create new section
            $section = new UserSections();
            $section->paren_id = $request->parent;
            $section->user_id = $request->user_id;
            $section->title = $request->title;
            $section->content = $request->content;
            $section->IsHaveLineBefore = $IsHaveLineBefore;
            $section->country_id = $request->country;
            $section->language = $lang == 'en' ? 'en' : 'ar';
            $section->default_MB_id = 0;
            $section->IsActive = true;
            $section->company_size = 1;
            $section->company_industry = 1;
            $section->ordering = $maxOrdering + 1;
            $section->save();
            return response()->json(['message' => 'Section created successfully', 'stat' => true]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'Something went wrong, please try again later', 'stat' => false], 500);
        }
    }
    //updateSectionAvailablity function
    public function updateclientSectionAvailablity(Request $request)
    {
        try {
            $section = UserSections::find($request->id);
            $section->IsActive = $request->IsActive == "true" ? true : false;
            $section->save();
            return response()->json(['message' => 'Section updated successfully', 'stat' => true]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'Something went wrong, please try again later', 'stat' => false], 500);
        }
    }
    //deleteSection function
    public function deleteclientSection(Request $request)
    {
        try {
            $section = UserSections::find($request->id);
            if ($request->type == "p" && (count($section->children) > 0) && $section) {
                foreach ($section->children as $child) {
                    $child->delete();
                }
            }
            $section->delete();
            return response()->json(['message' => 'Section deleted successfully', 'stat' => true]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'Something went wrong, please try again later', 'stat' => false], 500);
        }
    }
    //downloadClientPolicy function
    public function downloadClientPolicy(Request $request, $id)
    {
        try {
            //find client
            $client = Clients::find($id);
            //get client sections
            $sections = UserSections::where('user_id', $id)->whereNull('paren_id')->where('language', app()->getLocale())->where('IsActive', true)->get()->sortBy('ordering');
            $contents = [];
            $date = date('Y-m-d');
            $image = null;
            if ($client->logo_path != null) {


                $url = public_path('uploads/companies/logos/' . $client->logo_path);
                $imageContents = file_get_contents($url);

                // Get the mime type of the image
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mimeType = finfo_buffer($finfo, $imageContents);
                finfo_close($finfo);

                // Encode the image contents to base64
                $base64 = base64_encode($imageContents);
                $image = "data:$mimeType;base64,$base64";
            }
            //export sections to download pdf
            $data = [
                'sections' => $sections,
                'client' => $client,
                //date now
                'date' => $date,
                'image' => $image
            ];
            //load view
            // return view('dashboard.admin.ManualBuilder.manualBuilderTemplate')->with($data);
            $pdf = PDF::loadView('dashboard.admin.ManualBuilder.manualBuilderTemplate', compact('sections', 'client', 'date', 'image'));
            $pdf->setPaper('a4', 'portrait');
            $pdf->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);
            return $pdf->download($client->client_name . '-HR Policy-' . $date . '.pdf');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'Something went wrong, please try again later', 'stat' => false], 500);
        }
    }
    //CopyPlanSections function
    public function CopyPlanSections(Request $request, $country, $plan_id, $des_plan)
    {
        try {
            //get all sections of plan
            $sections = DefaultMB::where('country_id', $country)->where('plan_id', $plan_id)->whereNull('paren_id')->get();
            foreach ($sections as $section) {
                $new_section = new DefaultMB();
                $new_section->paren_id = $section->paren_id;
                $new_section->title = $section->title;
                $new_section->content = $section->content;
                $new_section->plan_id = $des_plan;
                $new_section->IsHaveLineBefore = $section->IsHaveLineBefore;
                $new_section->country_id = $country;
                $new_section->language = $section->language;
                $new_section->default_MB_id = $section->id;
                $new_section->IsActive = $section->IsActive;
                $new_section->company_size = $section->company_size;
                $new_section->company_industry = $section->company_industry;
                $new_section->ordering = $section->ordering;
                $new_section->save();
                //get children
                if (count($section->children) > 0) {
                    foreach ($section->children as $child) {
                        $new_child = new DefaultMB();
                        $new_child->paren_id = $new_section->id;
                        $new_child->title = $child->title;
                        $new_child->content = $child->content;
                        $new_child->plan_id = $des_plan;
                        $new_child->IsHaveLineBefore = $child->IsHaveLineBefore;
                        $new_child->country_id = $country;
                        $new_child->language = $child->language;
                        $new_child->default_MB_id = $child->id;
                        $new_child->IsActive = $child->IsActive;
                        $new_child->company_size = $child->company_size;
                        $new_child->company_industry = $child->company_industry;
                        $new_child->ordering = $child->ordering;
                        $new_child->save();
                    }
                }
            }
            return redirect()->route('manualBuilder.index', [$country, $des_plan]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'Something went wrong, please try again later', 'stat' => false], 500);
        }
    }
}
