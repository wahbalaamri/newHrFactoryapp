<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\ClientSubscriptionsController;
use App\Http\Controllers\CouponsController;
use App\Http\Controllers\DefaultMBController;
use App\Http\Controllers\EmailContentsController;
use App\Http\Controllers\FunctionPracticesController;
use App\Http\Controllers\FunctionsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IndustryController;
use App\Http\Controllers\Leader360ReviewController;
use App\Http\Controllers\ManageEmployeeEngagmentController;
use App\Http\Controllers\ManageHrDiagnosisController;
use App\Http\Controllers\MigrationConrtoller;
use App\Http\Controllers\PartnersController;
use App\Http\Controllers\PlansController;
use App\Http\Controllers\PracticeQuestionsController;
use App\Http\Controllers\SectionsController;
use App\Http\Controllers\SectorsController;
use App\Http\Controllers\ServiceApproachesController;
use App\Http\Controllers\ServiceFeaturesController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\SurveysController;
use App\Http\Controllers\TermsConditionsController;
use App\Http\Controllers\TrainingController;
use App\Http\Facades\TempURLFacade;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name("Home");

Route::get('/SetupNameRev', [HomeController::class, 'SetupNameRev'])->name("SetupNameRev");
Route::get('/about-us', [HomeController::class, 'aboutus'])->name("Home.about-us");
Route::get('/profile', [HomeController::class, 'profile'])->name("Home.profile");
Route::get('/training', [TrainingController::class, 'index'])->name("Training");
Route::get('/Surveys/takeSurvey/{id}', [SurveysController::class, 'takeSurvey'])->name("Surveys.takeSurvey");
Route::get('Surveys/survey/{id}', [Leader360ReviewController::class, 'survey'])->name('Surveys.survey');
Route::post('/Surveys/SaveAnswers', [SurveysController::class, 'SaveAnswers'])->name("Surveys.SaveAnswers");
Route::post('/Surveys/save360Answer', [SurveysController::class, 'save360Answer'])->name("Surveys.save360Answer");
//start up plan
Route::get('/startup', [PlansController::class, 'startup'])->name("Plans.startup");
Route::get('/manualBuilder', [PlansController::class, 'manualBuilder'])->name("Plans.manualBuilder");
Route::get('/client/startup', [PlansController::class, 'Clientstartup'])->name("Client.startup")->middleware('auth');
Route::get('/client/manualBuilder', [PlansController::class, 'ClientmanualBuilder'])->name("Client.manualBuilder")->middleware('auth');
Route::get('/SectionPlans', [PlansController::class, 'SectionPlans'])->name("Plans.SectionPlans");
Route::get('/checkout/{plan}/{Period}/{Amount}', [PlansController::class, 'checkout'])->name("Plans.checkout");
Route::get('/thawani', [PlansController::class, 'thawani'])->name("Plans.thawani");
Route::get('/payTabs', [PlansController::class, 'payTabs'])->name("Plans.payTabs");
Route::get('/CheckUser', [HomeController::class, 'CheckUser'])->name("CheckUser");
Route::get('/setupUsrPlans', [HomeController::class, 'setupUsrPlans'])->name("setupUsrPlans");
Route::get('/MigrateUsersOldSections', [MigrationConrtoller::class, 'MigrateUsersOldSections'])->name("MigrateUsersOldSections");
Route::get('/sections/editSec/{id}', [SectionsController::class, 'EditSe'])->name('sections.editSec');
Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/admin/dashboard', [HomeController::class, 'dashboard'])->name('admin.dashboard')->middleware('auth:web');
Route::get('/client/dashboard', [HomeController::class, 'client'])->name('client.dashboard')->middleware('auth:web');
Route::get('/client/manage', [HomeController::class, 'manage'])->name('client.manage')->middleware('auth:web');
Route::post('Coupons/getCouponRate', [CouponsController::class, 'getCouponRate'])->name('coupon.getCouponRate');
Route::get('tools/view/{id}', [HomeController::class, 'viewTool'])->name('tools.view');
Route::post('register/newclient', [RegisterController::class, 'registerNewClient'])->name('register.newclient');
Route::get('lang/{locale}', function () {
    session()->put('locale', request()->locale);
    return redirect()->back();
})->name('lang.swap');
//get all industries route
Route::get('/industries/all/{id}', [IndustryController::class, 'allIndustries'])->name('industries.all');
Route::post('clients/saveSCD', [ClientsController::class, 'saveSCD'])->name('clients.saveSCD');
Route::get('client/sectors/{id}', [SectorsController::class, 'sectors'])->name('sector.sectors');
Route::get('client/getRaters/{id}/{survey}/{type?}', [ClientsController::class, 'getRaters'])->name('sector.getRaters');
Route::get('client/companies/{id}', [ClientsController::class, 'companies'])->name('client.companies');
Route::get('client/departments/{id}', [ClientsController::class, 'departments'])->name('client.departments');
Route::get('client/getdep/{id}', [ClientsController::class, 'getDepartment'])->name('client.getDep');
Route::get('function/setup', [FunctionsController::class, 'setup']);
Route::get('practice/setup', [FunctionPracticesController::class, 'setup']);
Route::get('question/setup', [PracticeQuestionsController::class, 'setup']);
Route::get('plans/getUserPlan', [ClientSubscriptionsController::class, 'getUserPlan']);
Route::get('plans/getPlan/{id}', [PlansController::class, 'getPlan'])->name('subscription.getPlans');
//group routes for admin
Route::group(['middleware' => ['auth:web'], 'prefix' => 'admin'], function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('admin.dashboard');
    /*==================================================================================================================
      =                                                                                                                =
      =                                                                                                                =
      =                                                                                                                =
      =                                                  SERVICE ROUTES START                                          =
      =                                                                                                                =
      =                                                                                                                =
      =                                                                                                                =
      ==================================================================================================================*/
    Route::resource('services', ServicesController::class);
    /*==================================================================================================================
      =                                                                                                                =
      =                                                                                                                =
      =                                                                                                                =
      =                                                  SERVICE ROUTES END                                            =
      =                                                                                                                =
      =                                                                                                                =
      =                                                                                                                =
      ==================================================================================================================*/
    /*==================================================================================================================
      =                                                                                                                =
      =                                                                                                                =
      =                                                                                                                =
      =                                         SERVICE FEATURES ROUTES START                                          =
      =                                                                                                                =
      =                                                                                                                =
      =                                                                                                                =
      ==================================================================================================================*/
    Route::resource('service-features', ServiceFeaturesController::class);
    /*==================================================================================================================
      =                                                                                                                =
      =                                                                                                                =
      =                                                                                                                =
      =                                         SERVICE FEATURES ROUTES END                                            =
      =                                                                                                                =
      =                                                                                                                =
      =                                                                                                                =
      ==================================================================================================================*/
    /*==================================================================================================================
      =                                                                                                                =
      =                                                                                                                =
      =                                                                                                                =
      =                                        SERVICE APPROACHES ROUTES START                                         =
      =                                                                                                                =
      =                                                                                                                =
      =                                                                                                                =
      ==================================================================================================================*/
    Route::resource('service-approaches', ServiceApproachesController::class);
    /*==================================================================================================================
      =                                                                                                                =
      =                                                                                                                =
      =                                                                                                                =
      =                                        SERVICE APPROACHES ROUTES END                                           =
      =                                                                                                                =
      =                                                                                                                =
      =                                                                                                                =
      ==================================================================================================================*/


    /*==================================================================================================================
      =                                                                                                                =
      =                                                                                                                =
      =                                                                                                                =
      =                                        SERVICE PLANS ROUTES START                                              =
      =                                                                                                                =
      =                                                                                                                =
      =                                                                                                                =
      ==================================================================================================================*/
    Route::get('service-plans/create/{id}', [PlansController::class, 'create'])->name('service-plans.create');
    Route::post('service-plans/store/{id}', [PlansController::class, 'store'])->name('service-plans.store');
    Route::get('service-plans/show/{id}', [PlansController::class, 'show'])->name('service-plans.show');
    Route::get('service-plans/edit/{id}', [PlansController::class, 'edit'])->name('service-plans.edit');
    Route::delete('service-plans/destroy/{id}', [PlansController::class, 'destroy'])->name('service-plans.destroy');
    Route::get('service-plans/getCountriesPerPlan/{id}/{type}', [PlansController::class, 'getCountriesPerPlan'])->name('Service-planes.countries');
    /*==================================================================================================================
      =                                                                                                                =
      =                                                                                                                =
      =                                                                                                                =
      =                                        SERVICE PLANS ROUTES END                                                =
      =                                                                                                                =
      =                                                                                                                =
      =                                                                                                                =
      ==================================================================================================================*/
    /*==================================================================================================================
      =                                                                                                                =
      =                                                                                                                =
      =                                                                                                                =
      =                                        SERVICE Terms Conditions ROUTES START                                              =
      =                                                                                                                =
      =                                                                                                                =
      =                                                                                                                =
      ==================================================================================================================*/
    Route::get('termsconditions/create/{id}', [TermsConditionsController::class, 'create'])->name('termsconditions.create');
    Route::post('termsconditions/store/{id?}', [TermsConditionsController::class, 'store'])->name('termsconditions.store');
    Route::get('termsconditions/show/{id}', [TermsConditionsController::class, 'show'])->name('termsconditions.show');
    /*==================================================================================================================
      =                                                                                                                =
      =                                                                                                                =
      =                                                                                                                =
      =                                        SERVICE PLANS ROUTES END                                                =
      =                                                                                                                =
      =                                                                                                                =
      =                                                                                                                =
      ==================================================================================================================*/
    /*==================================================================================================================
      =                                                                                                                =
      =                                                                                                                =
      =                                                                                                                =
      =                                        SERVICE ManageHrDiagnosis ROUTES START                                              =
      =                                                                                                                =
      =                                                                                                                =
      =                                                                                                                =
      ==================================================================================================================*/
    Route::get('ManageHrDiagnosis/index', [ManageHrDiagnosisController::class, 'index'])->name('ManageHrDiagnosis.index');
    Route::get('ManageHrDiagnosis/createFunction', [ManageHrDiagnosisController::class, 'createFunction'])->name('ManageHrDiagnosis.createFunction');
    Route::post('ManageHrDiagnosis/storeFunction', [ManageHrDiagnosisController::class, 'storeFunction'])->name('ManageHrDiagnosis.storeFunction');
    Route::get('ManageHrDiagnosis/showPractices/{id}', [ManageHrDiagnosisController::class, 'showPractices'])->name('ManageHrDiagnosis.showPractices');
    Route::get('ManageHrDiagnosis/createPractice/{id}', [ManageHrDiagnosisController::class, 'createPractice'])->name('ManageHrDiagnosis.createPractice');
    Route::post('ManageHrDiagnosis/storePractice/{id}', [ManageHrDiagnosisController::class, 'storePractice'])->name('ManageHrDiagnosis.storePractice');
    Route::get('ManageHrDiagnosis/showQuestions/{id}', [ManageHrDiagnosisController::class, 'showQuestions'])->name('ManageHrDiagnosis.showQuestions');
    Route::get('ManageHrDiagnosis/editPractice/{id}', [ManageHrDiagnosisController::class, 'editPractice'])->name('ManageHrDiagnosis.editPractice');
    Route::delete('ManageHrDiagnosis/destroyPractice/{id}', [ManageHrDiagnosisController::class, 'destroyPractice'])->name('ManageHrDiagnosis.destroyPractice');
    Route::get('ManageHrDiagnosis/editFunction/{id}', [ManageHrDiagnosisController::class, 'editFunction'])->name('ManageHrDiagnosis.editFunction');
    Route::put('ManageHrDiagnosis/updateFunction/{id}', [ManageHrDiagnosisController::class, 'updateFunction'])->name('ManageHrDiagnosis.updateFunction');
    Route::delete('ManageHrDiagnosis/destroyFunction/{id}', [ManageHrDiagnosisController::class, 'destroyFunction'])->name('ManageHrDiagnosis.destroyFunction');
    Route::get('ManageHrDiagnosis/createQuestion/{id}', [ManageHrDiagnosisController::class, 'createQuestion'])->name('ManageHrDiagnosis.createQuestion');
    Route::post('ManageHrDiagnosis/storeQuestion/{id}', [ManageHrDiagnosisController::class, 'storeQuestion'])->name('ManageHrDiagnosis.storeQuestion');
    Route::get('ManageHrDiagnosis/editQuestion/{id}', [ManageHrDiagnosisController::class, 'editQuestion'])->name('ManageHrDiagnosis.editQuestion');
    Route::put('ManageHrDiagnosis/updateQuestion/{id}', [ManageHrDiagnosisController::class, 'updateQuestion'])->name('ManageHrDiagnosis.updateQuestion');
    Route::delete('ManageHrDiagnosis/deleteQuestion/{id}', [ManageHrDiagnosisController::class, 'deleteQuestion'])->name('ManageHrDiagnosis.deleteQuestion');
    Route::put('ManageHrDiagnosis/updatePractice/{id}', [ManageHrDiagnosisController::class, 'updatePractice'])->name('ManageHrDiagnosis.updatePractice');
    /*==================================================================================================================
      =                                                                                                                =
      =                                                                                                                =
      =                                                                                                                =
      =                                        SERVICE ManageHrDiagnosis ROUTES END                                                =
      =                                                                                                                =
      =                                                                                                                =
      =                                                                                                                =
      ==================================================================================================================*/
    /*==================================================================================================================
      =                                                                                                                =
      =                                                                                                                =
      =                                                                                                                =
      =                                        SERVICE Leader360Review ROUTES START                                              =
      =                                                                                                                =
      =                                                                                                                =
      =                                                                                                                =
      ==================================================================================================================*/
    Route::get('Leader360Review/index', [Leader360ReviewController::class, 'index'])->name('Leader360Review.index');
    Route::get('Leader360Review/createFunction', [Leader360ReviewController::class, 'createFunction'])->name('Leader360Review.createFunction');
    Route::post('Leader360Review/storeFunction', [Leader360ReviewController::class, 'storeFunction'])->name('Leader360Review.storeFunction');
    Route::get('Leader360Review/showPractices/{id}', [Leader360ReviewController::class, 'showPractices'])->name('Leader360Review.showPractices');
    Route::get('Leader360Review/createPractice/{id}', [Leader360ReviewController::class, 'createPractice'])->name('Leader360Review.createPractice');
    Route::post('Leader360Review/storePractice/{id}', [Leader360ReviewController::class, 'storePractice'])->name('Leader360Review.storePractice');
    Route::get('Leader360Review/showQuestions/{id}', [Leader360ReviewController::class, 'showQuestions'])->name('Leader360Review.showQuestions');
    Route::get('Leader360Review/editPractice/{id}', [Leader360ReviewController::class, 'editPractice'])->name('Leader360Review.editPractice');
    Route::delete('Leader360Review/destroyPractice/{id}', [Leader360ReviewController::class, 'destroyPractice'])->name('Leader360Review.destroyPractice');
    Route::get('Leader360Review/editFunction/{id}', [Leader360ReviewController::class, 'editFunction'])->name('Leader360Review.editFunction');
    Route::put('Leader360Review/updateFunction/{id}', [Leader360ReviewController::class, 'updateFunction'])->name('Leader360Review.updateFunction');
    Route::delete('Leader360Review/destroyFunction/{id}', [Leader360ReviewController::class, 'destroyFunction'])->name('Leader360Review.destroyFunction');
    Route::get('Leader360Review/createQuestion/{id}', [Leader360ReviewController::class, 'createQuestion'])->name('Leader360Review.createQuestion');
    Route::post('Leader360Review/storeQuestion/{id}', [Leader360ReviewController::class, 'storeQuestion'])->name('Leader360Review.storeQuestion');
    Route::get('Leader360Review/editQuestion/{id}', [Leader360ReviewController::class, 'editQuestion'])->name('Leader360Review.editQuestion');
    Route::put('Leader360Review/updateQuestion/{id}', [Leader360ReviewController::class, 'updateQuestion'])->name('Leader360Review.updateQuestion');
    Route::delete('Leader360Review/deleteQuestion/{id}', [Leader360ReviewController::class, 'deleteQuestion'])->name('Leader360Review.deleteQuestion');
    Route::put('Leader360Review/updatePractice/{id}', [Leader360ReviewController::class, 'updatePractice'])->name('Leader360Review.updatePractice');

    /*==================================================================================================================
      =                                                                                                                =
      =                                                                                                                =
      =                                                                                                                =
      =                                        SERVICE Leader360Review ROUTES END                                                =
      =                                                                                                                =
      =                                                                                                                =
      =                                                                                                                =
      ==================================================================================================================*/
    /*==================================================================================================================
      =                                                                                                                =
      =                                                                                                                =
      =                                                                                                                =
      =                                        SERVICE EmployeeEngagment ROUTES START                                              =
      =                                                                                                                =
      =                                                                                                                =
      =                                                                                                                =
      ==================================================================================================================*/
    Route::get('EmployeeEngagment/index', [ManageEmployeeEngagmentController::class, 'index'])->name('EmployeeEngagment.index');
    Route::get('EmployeeEngagment/createFunction', [ManageEmployeeEngagmentController::class, 'createFunction'])->name('EmployeeEngagment.createFunction');
    Route::post('EmployeeEngagment/storeFunction', [ManageEmployeeEngagmentController::class, 'storeFunction'])->name('EmployeeEngagment.storeFunction');
    Route::get('EmployeeEngagment/showPractices/{id}', [ManageEmployeeEngagmentController::class, 'showPractices'])->name('EmployeeEngagment.showPractices');
    Route::get('EmployeeEngagment/createPractice/{id}', [ManageEmployeeEngagmentController::class, 'createPractice'])->name('EmployeeEngagment.createPractice');
    Route::post('EmployeeEngagment/storePractice/{id}', [ManageEmployeeEngagmentController::class, 'storePractice'])->name('EmployeeEngagment.storePractice');
    Route::get('EmployeeEngagment/showQuestions/{id}', [ManageEmployeeEngagmentController::class, 'showQuestions'])->name('EmployeeEngagment.showQuestions');
    Route::get('EmployeeEngagment/editPractice/{id}', [ManageEmployeeEngagmentController::class, 'editPractice'])->name('EmployeeEngagment.editPractice');
    Route::delete('EmployeeEngagment/destroyPractice/{id}', [ManageEmployeeEngagmentController::class, 'destroyPractice'])->name('EmployeeEngagment.destroyPractice');
    Route::get('EmployeeEngagment/editFunction/{id}', [ManageEmployeeEngagmentController::class, 'editFunction'])->name('EmployeeEngagment.editFunction');
    Route::put('EmployeeEngagment/updateFunction/{id}', [ManageEmployeeEngagmentController::class, 'updateFunction'])->name('EmployeeEngagment.updateFunction');
    Route::delete('EmployeeEngagment/destroyFunction/{id}', [ManageEmployeeEngagmentController::class, 'destroyFunction'])->name('EmployeeEngagment.destroyFunction');
    Route::get('EmployeeEngagment/createQuestion/{id}', [ManageEmployeeEngagmentController::class, 'createQuestion'])->name('EmployeeEngagment.createQuestion');
    Route::post('EmployeeEngagment/storeQuestion/{id}', [ManageEmployeeEngagmentController::class, 'storeQuestion'])->name('EmployeeEngagment.storeQuestion');
    Route::get('EmployeeEngagment/editQuestion/{id}', [ManageEmployeeEngagmentController::class, 'editQuestion'])->name('EmployeeEngagment.editQuestion');
    Route::put('EmployeeEngagment/updateQuestion/{id}', [ManageEmployeeEngagmentController::class, 'updateQuestion'])->name('EmployeeEngagment.updateQuestion');
    Route::delete('EmployeeEngagment/deleteQuestion/{id}', [ManageEmployeeEngagmentController::class, 'deleteQuestion'])->name('EmployeeEngagment.deleteQuestion');
    Route::put('EmployeeEngagment/updatePractice/{id}', [ManageEmployeeEngagmentController::class, 'updatePractice'])->name('EmployeeEngagment.updatePractice');
    /*==================================================================================================================
      =                                                                                                                =
      =                                                                                                                =
      =                                                                                                                =
      =                                        SERVICE EmployeeEngagment ROUTES END                                                =
      =                                                                                                                =
      =                                                                                                                =
      =                                                                                                                =
      ==================================================================================================================*/
    /*==================================================================================================================
      =                                                                                                                =
      =                                                                                                                =
      =                                                                                                                =
      =                                        SERVICE Clients ROUTES START                                              =
      =                                                                                                                =
      =                                                                                                                =
      =                                                                                                                =
      ==================================================================================================================*/
    Route::get('clients/index', [ClientsController::class, 'index'])->name('clients.index');
    Route::get('clients/manage/{id}', [ClientsController::class, 'manage'])->name('clients.manage');
    Route::get('clients/ShowSurveys/{id}/{type}', [ClientsController::class, 'ShowSurveys'])->name('clients.ShowSurveys');
    Route::get('clients/createSurvey/{id}/{type}', [ClientsController::class, 'createSurvey'])->name('clients.createSurvey');
    Route::get('clients/editSurvey/{id}/{type}/{survey}', [ClientsController::class, 'editSurvey'])->name('clients.editSurvey');
    Route::post('clients/storeSurvey/{id}/{type}/{survey?}', [ClientsController::class, 'storeSurvey'])->name('clients.storeSurvey');
    Route::get('clients/ShowCustomizedSurveys/{id}/{type}', [ClientsController::class, 'ShowCustomizedSurveys'])->name('clients.ShowCustomizedSurveys');
    Route::get('clients/createCustomizedSurvey/{id}/{type}', [ClientsController::class, 'createCustomizedSurvey'])->name('clients.createCustomizedSurvey');
    Route::get('clients/editCustomizedSurvey/{id}/{type}/{survey}', [ClientsController::class, 'editCustomizedSurvey'])->name('clients.editCustomizedSurvey');
    Route::post('clients/storeCustomizedSurvey/{id}/{type}/{survey?}', [ClientsController::class, 'storeCustomizedSurvey'])->name('clients.storeCustomizedSurvey');
    Route::delete('clients/destroySurvey/{id}/{type}/{survey}', [ClientsController::class, 'destroySurvey'])->name('clients.destroySurvey');
    Route::post('clients/changeSurveyStat/{id}/{type}/{survey}', [ClientsController::class, 'changeSurveyStat'])->name('clients.changeSurveyStat');
    Route::post('clients/SubmitCustomizedQuestions/{id}/{type}', [ClientsController::class, 'SubmitCustomizedQuestions'])->name('clients.SubmitCustomizedQuestions');
    Route::get('clients/surveyDetails/{id}/{type}/{survey}', [ClientsController::class, 'surveyDetails'])->name('clients.surveyDetails');
    Route::get('clients/surveyCustomizedDetails/{id}/{type}/{survey}', [ClientsController::class, 'surveyCustomizedDetails'])->name('clients.surveyCustomizedDetails');
    Route::get('clients/CustomizedsurveyQuestions/{id}/{type}/{survey}', [ClientsController::class, 'CustomizedsurveyQuestions'])->name('clients.CustomizedsurveyQuestions');
    Route::get('clients/CreateCustomizedsurveyQuestions/{id}/{type}/{survey}', [ClientsController::class, 'CreateCustomizedsurveyQuestions'])->name('clients.CreateCustomizedsurveyQuestions');
    Route::get('clients/GetOtherSurveysQuestions/{sid}/{fid?}/{pid?}', [ClientsController::class, 'GetOtherSurveysQuestions'])->name('clients.GetOtherSurveysQuestions');
    Route::get('clients/GetFunctions/{sid}', [ClientsController::class, 'GetFunctions'])->name('clients.GetFunctions');
    Route::get('clients/GetPractices/{fid}', [ClientsController::class, 'GetPractices'])->name('clients.GetPractices');
    Route::get('clients/respondents/{id}/{type}/{survey}', [ClientsController::class, 'Respondents'])->name('clients.Respondents');
    Route::get('clients/CustomizedsurveyRespondents/{id}/{type}/{survey}', [ClientsController::class, 'CustomizedsurveyRespondents'])->name('clients.CustomizedsurveyRespondents');
    Route::get('clients/orgChart/{id}', [ClientsController::class, 'orgChart'])->name('clients.orgChart');
    Route::get('clients/Employees/{id}', [ClientsController::class, 'Employees'])->name('clients.Employees');
    Route::get('clients/ShowCreateEmail/{id}/{type}/{survey}', [ClientsController::class, 'ShowCreateEmail'])->name('clients.ShowCreateEmail');
    Route::post('clients/storeSurveyEmail/{id}/{type}/{survey}/{emailid?}', [ClientsController::class, 'storeSurveyEmail'])->name('clients.storeSurveyEmail');
    Route::get('clients/getClientLogo/{id}', [ClientsController::class, 'getClientLogo'])->name('clients.getClientLogo');
    Route::post('clients/storeEmployee', [ClientsController::class, 'storeEmployee'])->name('clients.storeEmployee');
    Route::get('clients/getEmployee/{id}', [ClientsController::class, 'getEmployee'])->name('clients.getEmployee');
    Route::post('clients/saveSurveyRespondents', [ClientsController::class, 'saveSurveyRespondents'])->name('clients.saveSurveyRespondents');
    Route::post('clients/saveSurveyCandidates', [ClientsController::class, 'saveSurveyCandidates'])->name('clients.saveSurveyCandidates');
    Route::get('clients/view-Subscriptions/{id}', [ClientsController::class, 'viewSubscriptions'])->name('clients.viewSubscriptions');
    Route::post('clients/saveSubscription/{id}', [ClientsController::class, 'saveSubscription'])->name('clients.saveSubscription');
    Route::get('clients/showSendSurvey/{id}/{type}/{survey}', [ClientsController::class, 'showSendSurvey'])->name('clients.showSendSurvey');
    // Route::get('clients/showSendSurvey/{id}/{type}/{survey}', [ClientsController::class, 'showSendSurvey'])->name('clients.showSendSurvey');
    Route::post('clients/sendSurvey/{id}/{type}/{survey}', [ClientsController::class, 'sendSurvey'])->name('clients.sendSurvey');
    Route::post('clients/SurveyResults/{id}/{type}/{survey}/{vtype}/{vtype_id?}', [ClientsController::class, 'SurveyResults'])->name('clients.SurveyResults');
    Route::post('clients/SaveRaters', [ClientsController::class, 'SaveRaters'])->name('clients.SaveRaters');
    Route::post('clients/candidates', [ClientsController::class, 'candidates'])->name('client.candidates');
    Route::post('clients/schedule360', [ClientsController::class, 'schedule360'])->name('client.schedule360');
    /*==================================================================================================================
      =                                                                                                                =
      =                                                                                                                =
      =                                                                                                                =
      =                                        SERVICE Clients ROUTES END                                              =
      =                                                                                                                =
      =                                                                                                                =
      =                                                                                                                =
      ==================================================================================================================*/
    /*==================================================================================================================
      =                                                                                                                =
      =                                                                                                                =
      =                                                                                                                =
      =                                        Partners ROUTES Start                                                   =
      =                                                                                                                =
      =                                                                                                                =
      =                                                                                                                =
      ==================================================================================================================*/
    Route::resource('partners', PartnersController::class);
    Route::post('partners/edit', [PartnersController::class, 'SavePartner'])->name('partner.edit');
    Route::get('partners/FocalPoints/{id}', [PartnersController::class, 'FocalPoints'])->name('partner.FocalPoints');
    Route::post('partners/SaveFocalPoint/{id}', [PartnersController::class, 'SaveFocalPoint'])->name('partner.SaveFocalPoint');
    Route::get('partners/Partnerships/{id}', [PartnersController::class, 'Partnerships'])->name('partner.Partnerships');
    Route::post('partners/SavePartnership/{id}', [PartnersController::class, 'SavePartnership'])->name('partner.SavePartnership');
    /*==================================================================================================================
      =                                                                                                                =
      =                                                                                                                =
      =                                                                                                                =
      =                                        Partners ROUTES End                                                     =
      =                                                                                                                =
      =                                                                                                                =
      =                                                                                                                =
      ==================================================================================================================*/
    /*==================================================================================================================
      =                                                                                                                =
      =                                                                                                                =
      =                                                                                                                =
      =                                        Emails Setup ROUTES START                                               =
      =                                                                                                                =
      =                                                                                                                =
      =                                                                                                                =
      ==================================================================================================================*/
    Route::get('Emails/AutomatedEmails/{country?}/{type?}', [EmailContentsController::class, 'AutomatedEmails'])->name('Emails.AutomatedEmails');
    Route::get('Emails/CreateAutmoatedEmails', [EmailContentsController::class, 'CreateAutmoatedEmails'])->name('Emails.CreateAutmoatedEmails');
    Route::get('Emails/EditAutmoatedEmails/{id}', [EmailContentsController::class, 'EditAutmoatedEmails'])->name('Emails.EditAutmoatedEmails');
    Route::post('Emails/SaveAutomatedEmails', [EmailContentsController::class, 'SaveAutomatedEmails'])->name('Emails.SaveAutomatedEmails');
    Route::get('Emails/CreateInstantEmail', [EmailContentsController::class, 'CreateInstantEmail'])->name('Emails.CreateInstantEmail');
    Route::post('Emails/SendInstantEmail', [EmailContentsController::class, 'SendInstantEmail'])->name('Emails.SendInstantEmail');
    /*==================================================================================================================
      =                                                                                                                =
      =                                                                                                                =
      =                                                                                                                =
      =                                        Emails Setup ROUTES END                                                 =
      =                                                                                                                =
      =                                                                                                                =
      =                                                                                                                =
      ==================================================================================================================*/
    /*==================================================================================================================
      =                                                                                                                =
      =                                                                                                                =
      =                                                                                                                =
      =                                        Terms Conditions ROUTES START                                           =
      =                                                                                                                =
      =                                                                                                                =
      =                                                                                                                =
      ==================================================================================================================*/
      Route::get('termsCondition/listall/{country?}/{type?}/', [TermsConditionsController::class, 'index'])->name('termsCondition.index');
      Route::get('/termsCondition/create', [TermsConditionsController::class, 'create'])->name('termsCondition.create');
      Route::post('/termsCondition/store', [TermsConditionsController::class, 'store'])->name('termsCondition.store');
      Route::get('/termsCondition/edit', [TermsConditionsController::class, 'edit'])->name('termsCondition.edit');
      Route::post('/termsCondition/update', [TermsConditionsController::class, 'update'])->name('termsCondition.update');
    /*==================================================================================================================
      =                                                                                                                =
      =                                                                                                                =
      =                                                                                                                =
      =                                        Terms Conditions ROUTES END                                             =
      =                                                                                                                =
      =                                                                                                                =
      =                                                                                                                =
      ==================================================================================================================*/
          /*==================================================================================================================
      =                                                                                                                =
      =                                                                                                                =
      =                                                                                                                =
      =                                        Manual Builder ROUTES START                                           =
      =                                                                                                                =
      =                                                                                                                =
      =                                                                                                                =
      ==================================================================================================================*/
      Route::get('manualBuilder/Default/{country?}', [DefaultMBController::class, 'index'])->name('manualBuilder.index');
      Route::get('manualBuilder/ClientSections/{id}', [DefaultMBController::class, 'ClientSections'])->name('manualBuilder.ClientSections');
      Route::post('manualBuilder/reorder/', [DefaultMBController::class, 'reorder'])->name('manualBuilder.reorder');
      Route::post('manualBuilder/update/', [DefaultMBController::class, 'updateSection'])->name('manualBuilder.update');
      Route::post('manualBuilder/store/', [DefaultMBController::class, 'storeSection'])->name('manualBuilder.store');
      Route::post('manualBuilder/newCountry/', [DefaultMBController::class, 'newCountry'])->name('manualBuilder.newCountry');
      Route::post('manualBuilder/updateSectionAvailablity/', [DefaultMBController::class, 'updateSectionAvailablity'])->name('manualBuilder.updateSectionAvailablity');
      Route::post('manualBuilder/deleteSection/', [DefaultMBController::class, 'deleteSection'])->name('manualBuilder.deleteSection');

    /*==================================================================================================================
      =                                                                                                                =
      =                                                                                                                =
      =                                                                                                                =
      =                                        Manual Builder ROUTES END                                             =
      =                                                                                                                =
      =                                                                                                                =
      =                                                                                                                =
      ==================================================================================================================*/
});
// //group routes for client
// Route::group(['middleware' => ['auth:web'], 'prefix' => 'admin'], function () {
// });
