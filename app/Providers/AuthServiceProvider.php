<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\FunctionPractices;
use App\Models\Functions;
use App\Models\Plans;
use App\Models\PracticeQuestions;
use App\Models\ServiceApproaches;
use App\Models\ServiceFeatures;
use App\Models\Services;
use App\Models\TermsConditions;
use App\Policies\FunctionPracticesPolicy;
use App\Policies\FunctionsPolicy;
use App\Policies\PlansPolicy;
use App\Policies\PracticeQuestionsPolicy;
use App\Policies\ServiceApproachesPolicy;
use App\Policies\ServiceFeaturesPolicy;
use App\Policies\ServicesPolicy;
use App\Policies\TermsConditionsPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
        Services::class => ServicesPolicy::class,
        ServiceFeatures::class => ServiceFeaturesPolicy::class,
        ServiceApproaches::class => ServiceApproachesPolicy::class,
        Plans::class => PlansPolicy::class,
        TermsConditions::class => TermsConditionsPolicy::class,
        Functions::class => FunctionsPolicy::class,
        FunctionPractices::class => FunctionPracticesPolicy::class,
        PracticeQuestions::class => PracticeQuestionsPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
