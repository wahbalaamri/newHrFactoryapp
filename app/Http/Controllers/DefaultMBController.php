<?php

namespace App\Http\Controllers;

use App\Models\DefaultMB;
use App\Http\Requests\StoreDefaultMBRequest;
use App\Http\Requests\UpdateDefaultMBRequest;
use App\Models\Countries;
use App\Models\FocalPoints;
use App\Models\Partnerships;
use App\Models\UserSections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DefaultMBController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $country = 155)
    {
        $user_id = auth()->user()->id;
        //get current user type
        $user_type = auth()->user()->user_type;
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
        $sections = DefaultMB::where('country_id', $country)->whereNull('paren_id')->where('language', app()->isLocale('en') ? 'en' : 'ar')->orderBy('ordering')->get();
        //get countries which has DefaultMB
        $available_countries = Countries::whereHas('defaultMB', function ($query) {
            $query->where('language', app()->isLocale('en') ? 'en' : 'ar');
        })->get();
        $data = [
            'sections' => $sections,
            'countries' => $countries,
            'country_id' => $country,
            'available_countries' => $available_countries,
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
            Log::info($IsHaveLineBefore);
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

            Log::info($request->country);
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
            $default_counrty = 155;
            //get all section for default country
            $sections = DefaultMB::where('country_id', $default_counrty)->whereNull('paren_id')->get();
            $new_country = $request->new_country;
            //add all section to new country
            foreach ($sections as $section) {
                $new_section = new DefaultMB();
                $new_section->paren_id = $section->paren_id;
                $new_section->title = $section->title;
                $new_section->content = $section->content;
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
            $sections = UserSections::where('user_id', $id)->whereNull('paren_id')->get();
            if(count($sections)<=0)
            {
                //get focal point
                $focal_point = FocalPoints::where('client_id', $id)->first();
                //check if remote has for this user
                $contents = json_decode(file_get_contents('https://www.hrfactoryapp.com/Home/UserSctions?email='.$focal_point->email.'&lang=1'), true);
                dd($contents);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'Something went wrong, please try again later', 'stat' => false], 500);
        }
    }
}
