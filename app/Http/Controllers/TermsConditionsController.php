<?php

namespace App\Http\Controllers;

use App\Models\TermsConditions;
use App\Http\Requests\StoreTermsConditionsRequest;
use App\Http\Requests\UpdateTermsConditionsRequest;
use App\Models\Countries;
use App\Models\Partnerships;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PHPUnit\Framework\MockObject\Builder\Identity;

class TermsConditionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $country = null, $type = null)
    {
        $countries = null;
        $terms = null;
        $where = [];
        if ($country) {
            $where[] = ['country_id', $country];
        }
        if ($type) {
            $where[] = ['for', $type];
        }
        //get current user id
        $user_id = auth()->user()->id;
        //get current user type
        $user_type = auth()->user()->user_type;
        //check if current user is admin
        if (auth()->user()->isAdmin) {
            //get all terms
            $terms = TermsConditions::where('plan_id', 0)->whereNotNull('for')->where($where)->get();
            //get all countries
            $countries = Countries::all()->groupBy('IsArabCountry');
        } elseif ($user_type == "partner") {
            //get all partnerships
            $partnerships_countries = Partnerships::where('partner_id', auth()->user()->partner_id)->get()->pluck('country_id')->toArray();
            //get all terms where plan is null
            $terms = TermsConditions::where('plan_id', 0)->whereIn('country_id', $partnerships_countries)->whereNotNull('for')->where($where)->get();
            //get countries
            $countries = Countries::whereIn('id', $partnerships_countries)->get();
        } else {
            //abort not autherized
            abort(403);
        }
        if (request()->ajax()) {

            //return datatable $terms
            return datatables()->of($terms)
                ->addIndexColumn()
                ->addColumn('title', function ($row) {
                    return app()->isLocale('en') ? $row->english_title : $row->arabic_title;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('termsCondition.edit',[$row->id]) . '" class="edit btn btn-primary btn-xs m-2"><i class="fa fa-edit"></i></a>';
                    $btn .= '<a href="javascript:void(0)" class="delete btn btn-danger btn-xs m-2"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->editColumn('country_id', function ($row) {
                    return $row->country ? (app()->isLocale('en') ? $row->country->name : $row->country->name_ar) : __('ALL Cuntries');
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        //return view with $terms and $countries
        return view('dashboard.admin.terms.index', compact('terms', 'countries'));
        //get all terms where plan is null

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $countries = null;
        $terms = null;
        //get current user id
        $user_id = auth()->user()->id;
        //get current user type
        $user_type = auth()->user()->user_type;
        //check if current user is admin
        if (auth()->user()->isAdmin) {
            //get all countries
            $countries = Countries::all()->groupBy('IsArabCountry');
        } elseif ($user_type == "partner") {
            //get all partnerships
            $partnerships_countries = Partnerships::where('partner_id', auth()->user()->partner_id)->get()->pluck('country_id')->toArray();
            //get countries
            $countries = Countries::whereIn('id', $partnerships_countries)->get();
        } else {
            //abort not autherized
            abort(403);
        }
        $terms_is_active=true;
        //return view with $terms and $countries
        return view('dashboard.admin.terms.edit', compact('countries', 'terms','terms_is_active'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTermsConditionsRequest $request)
    {
        //
        $terms = new TermsConditions();
        $terms->country_id = $request->country;
        $terms->for = $request->type;
        $terms->english_text = $request->content_en;
        $terms->arabic_text = $request->content_ar;
        $terms->english_title = $request->title_en;
        $terms->arabic_title = $request->title_ar;
        $terms->is_active = $request->is_active ? true : false;
        $terms->created_by = auth()->user()->id;
        $terms->save();
        return redirect()->route('termsCondition.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(TermsConditions $termsConditions)
    {
        //

    }
    public function CustomCreate($id)
    {
        //
        $countries = null;
        $terms = null;
        //get current user id
        $user_id = auth()->user()->id;
        //get current user type
        $user_type = auth()->user()->user_type;
        //check if current user is admin
        if (auth()->user()->isAdmin) {
            //get all countries
            $countries = Countries::all()->groupBy('IsArabCountry');
        } elseif ($user_type == "partner") {
            //get all partnerships
            $partnerships_countries = Partnerships::where('partner_id', auth()->user()->partner_id)->get()->pluck('country_id')->toArray();
            //get countries
            $countries = Countries::whereIn('id', $partnerships_countries)->get();
        } else {
            //abort not autherized
            abort(403);
        }
        //return view with $terms and $countries
        return view('dashboard.admin.terms.edit', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function Customstore(StoreTermsConditionsRequest $request, $id)
    {
        //
        $terms = new TermsConditions();
        $terms->country_id = $request->country;
        $terms->for = $request->type;
        $terms->english_text = $request->content_en;
        $terms->arabic_text = $request->content_ar;
        $terms->english_title = $request->title_en;
        $terms->arabic_title = $request->title_ar;
        $terms->is_active = $request->is_active ? true : false;
        $terms->created_by = auth()->user()->id;
        $terms->save();
        return redirect()->route('termsCondition.index');
    }

    /**
     * Display the specified resource.
     */
    public function Customshow(TermsConditions $termsConditions, $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $id)
    {
        //find terms
        $terms = TermsConditions::find($id);
        $countries = null;
        //get current user id
        $user_id = auth()->user()->id;
        //get current user type
        $user_type = auth()->user()->user_type;
        //check if current user is admin
        if (auth()->user()->isAdmin) {
            //get all countries
            $countries = Countries::all()->groupBy('IsArabCountry');
        } elseif ($user_type == "partner") {
            //get all partnerships
            $partnerships_countries = Partnerships::where('partner_id', auth()->user()->partner_id)->get()->pluck('country_id')->toArray();
            //get countries
            $countries = Countries::whereIn('id', $partnerships_countries)->get();
        } else {
            //abort not autherized
            abort(403);
        }
        $terms_is_active=$terms->is_active;
        //return view with $terms and $countries
        return view('dashboard.admin.terms.edit', compact('countries', 'terms','terms_is_active'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $terms = TermsConditions::find($id);
        $terms->country_id = $request->country;
        $terms->for = $request->type;
        $terms->english_text = $request->content_en;
        $terms->arabic_text = $request->content_ar;
        $terms->english_title = $request->title_en;
        $terms->arabic_title = $request->title_ar;
        $terms->is_active = $request->is_active ? true : false;
        $terms->save();
        return redirect()->route('termsCondition.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TermsConditions $termsConditions)
    {
        //
    }
    public function createTEST()
    {
    }
}
