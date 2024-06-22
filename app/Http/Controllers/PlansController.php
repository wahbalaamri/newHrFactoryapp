<?php

namespace App\Http\Controllers;

use App\Enums\NumberOfEmployees;
use App\Enums\PlansEnum;
use App\Enums\SubscriptionPeriod;
use App\Models\Category;
use App\Models\Content;
use App\Models\Countries;
use App\Models\DefaultMB;
use App\Models\DocFile;
use App\Models\Industry;
use App\Models\PartnerFocalPoint;
use App\Models\Partnerships;
use App\Models\PlanFeatures;
use App\Models\Plans;
use App\Models\PlansPrices;
use App\Models\PolicyMBFile;
use App\Models\Services;
use App\Models\Vedios;
use App\Models\TermsConditions;
use App\Models\User;
use App\Models\UserPlans;
use App\Models\UserSections;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Paytabscom\Laravel_paytabs\Facades\paypage;

class PlansController extends Controller
{
    //
    public function startup()
    {
        $contents = Content::where('page', '=', 'startup')->get();
        $categories = Category::where([['CategoryPlan', 2], ['isActive', true]])->get()->pluck('id');
        $plan = Plans::find(2);
        //terms&conditions
        $m_terms = TermsConditions::where([['CountryId', 158], ['TermsConditionType', 2]])->first();
        $a_terms = TermsConditions::where([['CountryId', 158], ['TermsConditionType', 3]])->first();

        $data = [
            'contents' => $contents,
            'DocFiles' => DocFile::latest()->take(3)->get(),
            'DocFilesCount' => DocFile::where([['CountryId', 0], ['isFileActive', true]])->whereIn('CategoryId', $categories)->count(),
            'MonthlyPriceDisp' => ceil(doubleval($plan->ManthlyPrice) * 2.6008),
            'AnnualPriceDisp' => ceil(doubleval($plan->AnnualPrice) * 2.6008),
            'm_terms' => $m_terms,
            'a_terms' => $a_terms,
            'year' => SubscriptionPeriod::Year->name,
            'month' => SubscriptionPeriod::Month->name,
            'plan' => PlansEnum::Startup->name

        ];
        return view('plans.startup')->with($data);
    }
    //manualBuilder
    function manualBuilder()
    {
        $contents = Content::where('page', '=', 'manualbuilder')->get();
        $data = [
            'contents' => $contents,
        ];
        return view('plans.manualBuilder')->with($data);
    }
    function SectionPlans()
    {
        $contents = Content::where('page', '=', 'manualbuilder')->get();
        $plan = Plans::find(3);
        $List = [

            1 => __('From 1 to 10'),
            2 => __('From 11 to 49'),
            3 => __('From 50 to 99'),
            4 => __('From 100 to 499'),
            5 => __('From 499 to 1000'),
            6 => __('More than 1000'),
        ];
        //terms&conditions
        $vedio = Vedios::all()->first();
        if ($vedio->Uploaded) {
            $vedi_src = app()->getLocale() == 'ar' ? $vedio->UploadedArabic : $vedio->UploadedEnglish;
        } else {
            $vedi_src = app()->getLocale() == 'ar' ? $vedio->EmbadedArabic : $vedio->EmbadedEnglish;
        }
        $m_terms = TermsConditions::where([['country_id', 158], ['period', 2]])->first();
        $a_terms = TermsConditions::where([['country_id', 158], ['period', 3]])->first();

        $data = [
            'contents' => $contents,
            // 'DocFiles' => DocFile::latest()->take(3)->get(),
            // 'DocFilesCount' => DocFile::where([['CountryId', 0], ['isFileActive', true]])->whereIn('CategoryId', $categories)->count(),
            'MonthlyPriceDisp' => 23,
            'AnnualPriceDisp' => 98,
            'm_terms' => $m_terms,
            'a_terms' => $a_terms,
            'year' => SubscriptionPeriod::Year->name,
            'month' => SubscriptionPeriod::Month->name,
            'plan' => PlansEnum::ManualBuilder->name,
            'industries' => Industry::all(),
            'countries' => Countries::all()->groupBy('IsArabCountry'),
            'List' => $List,
            'vedi_src' => $vedi_src,
            'defaultMB_parents' => DefaultMB::where([['country_id', 158], ['company_size', 1], ['paren_id', null], ['language', app()->getLocale() == 'ar' ? 'ar' : 'en']])->orderBy('ordering')->get(),

        ];
        return view('plans.SectionPlans')->with($data);
    }
    //checkout
    function checkout($plan, $period, $amount)
    {
        //date now
        $now = date('Y-m-d');
        //add period to date
        $dateEnd =  SubscriptionPeriod::fromCase($period) == 1 ? date('Y-m-d', strtotime($now . ' + 30 days')) : date('Y-m-d', strtotime($now . ' + 1 year'));
        $vat = (doubleval($amount) * 0.05);
        //total
        $total = $amount + $vat;
        $data = [
            'plan' => PlansEnum::getName($plan),
            'period' => $period,
            'amount' => $amount,
            'countries' => Countries::all()->groupBy('IsArabCountry'),
            'date_start' => $now,
            'date_end' => $dateEnd,
            //vat taxe
            'vat' => $vat,
            'vat_rate' => 5,
            'total' => $total
        ];
        $planVlaue = PlansEnum::fromCase($plan);
        //get enum case from value
        // Log::info('value: ' . $planVlaue);
        //get enum name from value
        // Log::info( PlansEnum::getNameByVal($planVlaue)->name);
        // Log::info('value: ' . PlansEnum::fromCase($plan));
        // Log::info('value: ' . PlansEnum::getName($plan));
        // Log::info('value By V: ' . PlansEnum::getName(PlansEnum::getNameByVal($planVlaue)));
        return view('plans.checkout')->with($data);
    }
    //thawani online payment
    function thawani(Request $request)
    {
        $client = new Client();
        // url request
        $url = "https://checkout.thawani.om/api/v1/checkout/session";
        //thawani data
        $data = [
            "payment_method_id" => "card_zK5a7sd98wdwe78TbiSUyLUjann6xFx",
            "amount" => 100,
            "client_reference_id" => "12345",
            "return_url" => "https://www.hrfactoryapp.com",
            "metadata" => [
                "customer" => "thawani developers"
            ]
        ];
        $headers = [
            'thawani-api-key' => '8AoY3m4ahzYGuWtSfDW8YUa736DZvJ',  // Example custom header
            'Content-Type' => 'application/json',
        ];
        $response = $client->request('POST', $url, [
            'body' => '{
            "client_reference_id": "123412",
            "mode": "payment",
            "products": [
              {
                "name": "product 1",
                "quantity": 1,
                "unit_amount": 95200
              }
            ],
            "success_url": "https://www.hrfactoryapp.com",
            "cancel_url": "https://www.hrfactoryapp.com/login",
            "metadata": {
              "Customer name": "somename",
              "order id": 0
            }
          }',
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'thawani-api-key' => '8AoY3m4ahzYGuWtSfDW8YUa736DZvJ',
            ],
        ]);
        //   dd(  $response->getBody());
        $response = json_decode($response->getBody()->getContents());
        // dd($response->data->session_id);
        //return redirect
        return redirect("http://checkout.thawani.om/pay/" . $response->data->session_id . "?key=AE3Ac7wGc8tB13XuoXGw98KlwtkV5j");
    }
    function payTabs(Request $request)
    {
        //payment through paytabs
        $pay = paypage::sendPaymentCode('ecom')
            ->sendTransaction('sale', 'recurring')
            ->sendCart(10, 1000, 'test')
            ->sendCustomerDetails('Walaa Elsaeed', 'w.elsaeed@paytabs.com', '0101111111', 'test', 'Nasr City', 'Muscat', 'OM', '1234', '100.279.20.10')
            ->sendShippingDetails('Walaa Elsaeed', 'w.elsaeed@paytabs.com', '0101111111', 'test', 'Nasr City', 'Muscat', 'OM', '1234', '100.279.20.10')
            ->sendURLs('https://www.hrfactoryapp.com/Thawani/Webhook', 'https://www.hrfactoryapp.com/Thawani/Ipn')
            ->sendLanguage('en')
            ->create_pay_page();
        return $pay;
    }
    function Clientstartup()
    {
        //get active userplan from userplans where plan is startup
        $active_sub = UserPlans::where([['IsActive', true], ['UserId', Auth()->user()->id], ['PlanId', 2]])->first();
        if ($active_sub) {
            //get start-up files
            $files = DocFile::where([['CountryId', 0], ['isFileActive', true], ['CategoryId', 1]])->get();
        } else {
            $files = null;
        }
        $data = [
            'files' => $files,
            'active_sub' => $active_sub
        ];
        return view('dashboard.client.startup')->with($data);
    }
    function ClientmanualBuilder()
    {

        //get active userplan from userplans where plan is manualBuilder
        $active_sub = UserPlans::where([['IsActive', true], ['UserId', Auth()->user()->id], ['PlanId', 3]])->first();
        if ($active_sub) {
            //get user section by user auth id and order by ordering asc
            $sections = UserSections::where('UserId', Auth()->user()->id)->orderBy('Ordering')->get();
            //get policeMBFile details
            $policeMBFile = PolicyMBFile::where('user_id', Auth()->user()->id)->first();
            $data = [
                'sections' => $sections,
                'active_sub' => $active_sub,
                'policeMBFile' => $policeMBFile,
            ];
        } else {
            $data = [
                'sections' => null,
                'active_sub' => $active_sub,
                'policeMBFile' => null
            ];
        }
        return view('dashboard.client.manualBuilder')->with($data);
    }
    function setupPoliceMBFile()
    {
        //get all users
        $users = User::all();
        foreach ($users as $user) {
            //insert policeMBFile details from user
            $policeMBFile = new PolicyMBFile();
            $policeMBFile->user_id = $user->id;
            $policeMBFile->name = $user->DocumentName;
            $policeMBFile->name_ar = $user->DocumentNameAr;
            $policeMBFile->save();
        }
    }

    function create($id)
    {
        //get service
        $service = Services::find($id);
        $data = [
            'service' => $service,
            'countries' => Countries::all()->groupBy('IsArabCountry'),
            'plan' => null,
            'features' => null,
        ];
        return view('dashboard.services.plans.create')->with($data);
    }
    function edit($id)
    {
        //get service
        //get plan
        $plan = Plans::find($id);
        //get service
        $service = Services::find($plan->service);
        $data = [
            'service' => $service,
            'countries' => Countries::all()->groupBy('IsArabCountry'),
            'plan' => $plan,
            'features' => $plan->features_obj->pluck('feature_id')->toArray(),
        ];
        return view('dashboard.services.plans.create')->with($data);
    }
    function store(Request $request, $id)
    {


        if (Auth::user()->can('create', new Plans)) {
            $pfInputs = request()->only(
                collect(request()->all())->filter(function ($value, $key) {
                    return strpos($key, 'pf') === 0;
                })->keys()->toArray()
            );
            //get the array of keys from the pfInputs
            $keys = array_keys($pfInputs);
            // remove pf- from the keys
            $keys = array_map(function ($key) {
                return substr($key, 3);
            }, $keys);
            $PM_inputs = request()->only(
                collect(request()->all())->filter(function ($value, $key) {
                    return strpos($key, 'PM') === 0;
                })->keys()->toArray()
            );
            //get the array of keys from the PM_inputs
            $PM_keys = array_keys($PM_inputs);
            // remove PM- from the keys
            $PM_keys = array_map(function ($key) {
                return substr($key, 3);
            }, $PM_keys);
            //check for files
            if ($request->hasFile('sample_report')) {
                // Get icon file
                $sample_report = $request->file('sample_report');
                // Folder path
                $folder = 'uploads/services/sample_reports/';
                // Make icon name with original name
                $sample_report_name = date('YmdHis') . '-' . $sample_report->getClientOriginalName();
                // Upload icon
                $sample_report->move(public_path($folder), $sample_report_name);
            } else {
                $sample_report_name = "";
            }
            //create a new plan
            if ($request->plan_id)
                $plan = Plans::find($request->plan_id);
            else
                $plan = new Plans();
            $plan->service = $id;
            $plan->name = $request->name;
            $plan->name_ar = $request->name_ar;
            $plan->delivery_mode = $request->delivery_mode;
            $plan->delivery_mode_ar = $request->delivery_mode_ar;
            $plan->limitations = $request->limitations;
            $plan->limitations_ar = $request->limitations_ar;
            if ($request->plan_id && $sample_report_name == "");
            else
                $plan->sample_report = $request->sample_report;
            $plan->is_active = $request->is_active != null ? true : false;
            $plan->save();
            if ($request->plan_id)
                PlanFeatures::where('plan', $plan->id)->delete();
            //create a new plan features
            for ($i = 0; $i < count($keys); $i++) {

                $plan_feature = new PlanFeatures();
                $plan_feature->plan = $plan->id;
                $plan_feature->feature_id = $keys[$i];
                $plan_feature->save();
            }
            //create new plan pricing
            $plan_price = new PlansPrices();
            if (!$request->plan_id) {
                $plan_price->plan = $plan->id;
                $plan_price->country = $request->valid_in;
                $plan_price->monthly_price = $request->monthly_price;
                $plan_price->annual_price = $request->annual_price;
                $plan_price->currency = $request->currency;
                $plan_price->payment_methods = json_encode($PM_keys);
                $plan_price->is_active = true;
                $plan_price->save();
            }
            //return back to the service show page
            return redirect()->route('services.show', $id);
        } else {
            //return forbidden
            return abort(403);
        }
    }
    //show plan
    function show($id)
    {
        //get plan
        $plan = Plans::find($id);
        //get plan features
        $features = $plan->features_obj;
        //put $features id in array
        $features_id = $features->pluck('feature_id')->toArray();
        //get plan prices
        $prices = $plan->plansPrices;
        //process $prices data
        foreach ($prices as $price) {
            $price->Country_name = app()->getLocale() == 'en' ? $price->Country->name : $price->Country->name_ar;
            $price->currency_sy = $price->currency_symbol;
            $price->payment_methods = json_decode($price->payment_methods);
        }
        //get plan terms and conditions
        $terms = $plan->termsConditions;

        //if auth usertype partner
        if (Auth()->user()->user_type == 'partner') {
            //find the partner focal point
            $partner_id = PartnerFocalPoint::where('Email', Auth()->user()->email)->first()->partner_id;
            //get countries id in partnerships
            $Countries_id = Partnerships::where('partner_id', $partner_id)->pluck('country_id')->toArray();
            //get countries
            $countries = Countries::whereIn('id', $Countries_id)->get()->append('country_name');
        }
        //if auth usertype admin
        else {
            //get all countries
            $countries = Countries::all()->groupBy('IsArabCountry')->append('country_name');
        }
        $data = [
            'plan' => $plan,
            'features' => $features,
            'prices' => $prices,
            'features_id' => $features_id,
            'terms' => $terms,
            'countries' => $countries,
        ];
        //return json response
        return response()->json($data);
    }
    //getPlan function
    function getPlan(Request $request, $id)
    {
        try {
            //find service with type $id
            $service = Services::where('service_type', $id)->first();
            //service not found return not found
            if (!$service) {
                return response()->json(['status' => false, 'error' => 'Service not found']);
            }
            //get plans of service id
            $plans = Plans::where('service', $service->id)->get()->append('planName');
            $plans_ids = $plans->pluck('id')->toArray();
            //get all plans prices where country is $request->country
            $plans_prices = PlansPrices::whereIn('plan', $plans_ids)->where('country', $request->country)->get();
            //return json response
            return response()->json(['status' => true, 'plans' => $plans, 'plans_prices' => $plans_prices]);
        } catch (\Exception $e) {
            //return error
            Log::error($e->getMessage());
            return response()->json(['status' => false, 'error' => $e->getMessage()]);
        }
    }
    //destroy plan
    function destroy($id)
    {
        //get plan
        $plan = Plans::find($id);
        //delete plan features
        PlanFeatures::where('plan', $plan->id)->delete();
        //delete plan prices
        PlansPrices::where('plan', $plan->id)->delete();

        //delete plan
        $plan->delete();
        //return back
        return back();
    }
}
