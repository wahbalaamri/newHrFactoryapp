<?php

namespace App\Http\traits;

use App\Enums\NumberOfEmployees;
use App\Http\Facades\Landing;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\{Industry, Countries, TermsConditions};
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Support\Facades\Log;

trait CustomRegistersUsers
{
    use RedirectsUsers;

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        //get current country
        $current_country = Landing::getCurrentCountry();
        //get Default country
        $default_country = Landing::getDefaultCountry();
        //get terms & conditions
        $terms = TermsConditions::where('for', "Singup")->where('country_id', $current_country)->first();
        $terms = $terms ? $terms : TermsConditions::where('for', "Singup")->where('country_id', $default_country)->first();
        $Employee = new NumberOfEmployees();
        $data = [
            'industries' => Industry::all(),
            'countries' => Countries::all(),
            'numberOfEmployees' => $Employee->getList(),
            'terms' => $terms
        ];
        return view('auth.register')->with($data);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 201)
            : redirect($this->redirectPath());
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        //
    }
}
