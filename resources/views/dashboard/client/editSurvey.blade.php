{{-- extends --}}
@extends('dashboard.layouts.main')
{{-- content --}}
{{-- show client details --}}
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard </li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    {{-- create funcy card to display surveys --}}
                    <div class="col-12 mt-3">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('Create New Survey') }}</h3>
                                {{-- tool --}}
                                <div class="card-tools">
                                    {{-- back --}}
                                    <a href="{{ route('clients.ShowSurveys', [$id, $type]) }}"
                                        class="btn btn-sm btn-primary {{ App()->getLocale() == 'ar' ? 'float-start' : 'float-end' }}">{{ __('Back') }}</a>
                                    {{-- create new survey --}}
                                </div>
                            </div>
                            <div class="card-body">
                                @if (count($errors) > 0)
                                    @foreach ($errors->all() as $error)
                                        <div class="alert alert-danger">{{ $error }}</div>
                                    @endforeach
                                @endif

                                {{-- create new survey form --}}
                                <form action="{{ route('clients.storeSurvey', [$id, $type, $survey]) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row justify-content-center">
                                        <div class="col-10">
                                            <div class="row">
                                                {{-- select plans --}}
                                                <div class="form-group col-md-5 col-sm-12">
                                                    <input type="hidden" name="h_plan_id"
                                                        value="{{ $client_subscription->plan_id }}">
                                                    <label for="plan_id">{{ __('Select Plan') }}</label>
                                                    <select name="plan_id" id="plan_id" class="form-control" disabled>
                                                        <option value="">{{ __('Select Plan') }}</option>
                                                        @foreach ($plans as $plan)
                                                            <option value="{{ $plan->id }}"
                                                                @if ($client_subscription->plan_id == $plan->id) selected @endif>
                                                                {{ $plan->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-5 col-sm-12">
                                                    <label for="survey_title">{{ __('Survey Title') }}</label>
                                                    <input type="text" name="survey_title" id="survey_title"
                                                        value="{{ old('survey_title', is_object($survey_object) ? $survey_object->survey_title : '') }}"
                                                        class="form-control" placeholder="{{ __('Survey Title') }}"
                                                        required>
                                                    @error('survey_title')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                {{-- switch survey_stat --}}
                                                <div class="form-group col-md-5 col-sm-12">
                                                    <label for="survey_stat">{{ __('Status') }}</label>
                                                    <br>
                                                    <input type="checkbox" name="survey_stat" checked data-bootstrap-switch
                                                        data-off-color="danger" data-on-color="success"
                                                        @checked($survey_object ? $survey_object->status : true)>
                                                </div>
                                                @if ($type != 4)
                                                {{-- switch use default statmants --}}
                                                <div class="form-group col-md-5 col-sm-12">
                                                    <div class="row">
                                                        <div class="col-md-6 col-sm-12">
                                                            <label
                                                                for="use_default_stat">{{ __('Use Default Statements') }}
                                                            </label>
                                                        </div>
                                                        @if ($type == 3)
                                                            <div class="col-md-6 col-sm-12 text-bold validated">
                                                                <span class="">{{ __('(Validated)') }}</span>
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="#e0a800"
                                                                    style="width: 2.0rem" class="size-6">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                                                                </svg>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <br>
                                                    <input type="checkbox" name="use_default_stat" checked
                                                        data-bootstrap-switch data-off-color="danger"
                                                        data-on-color="success" @checked($survey_object ? !$survey_object->customized : true)>
                                                    <small class="blockquote-footer">
                                                        {{-- @if ($client->use_departments) --}}
                                                        {{ __('By checking you will get validated and verified survey') }}
                                                        {{-- @else
                                                    {{ __('By unChecking you will not be able to view report by
                                                    department') }}
                                                    @endif --}}
                                                    </small>
                                                </div>
                                                @endif
                                                {{-- textarea survey description --}}
                                                <div class="form-group col-sm-6">
                                                    <label for="survey_des">{{ __('Survey Description') }}</label>
                                                    <textarea name="survey_des" id="survey_des" class="form-control summernote"
                                                        placeholder="{{ __('Survey Description') }}" required>
                                                        {{ old('survey_des', is_object($survey_object) ? $survey_object->survey_des : '') }}</textarea>
                                                    @error('survey_des')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                {{-- submit --}}
                                                <div @class([
                                                    'form-group col-12',
                                                    'text-right' => App()->isLocale('en'),
                                                    'text-left' => App()->isLocale('ar'),
                                                ])>
                                                    <button type="submit"
                                                        class="btn btn-sm btn-outline-primary">{{ __('Create Survey') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- /.content-wrapper -->
@endsection
@section('scripts')
    <script>
        //get survey_object->state
        stat = "{{ $survey_object ? $survey_object->survey_stat : true }}" == 1 ? true : false;
        $("[name='survey_stat']").bootstrapSwitch('state', stat);
        use_default_stat = "{{ $survey_object ? $survey_object->customized : true }}" == 1 ? true : false;
        $("[name='use_default_stat']").bootstrapSwitch('state', !use_default_stat);
        $("[name='survey_stat']").bootstrapSwitch();
        $("[name='use_default_stat']").bootstrapSwitch();
        $('.summernote').summernote();
        //on use_default_stat change
        $("[name='use_default_stat']").on('switchChange.bootstrapSwitch', function(event, state) {
            $(".blockquote-footer").addClass("fade-in");
            //if switch is on
            if (state) {
                //check if .validated has d-none
                if (!$(".validated").hasClass("fade-in")) {
                    //add fade-in
                    $(".validated").removeClass("fade-out");
                    $(".validated").addClass("fade-in");
                    $('.blockquote-footer').text(
                        "{{ __('By checking you will get validated and verified survey') }}");
                }
                //change text of .blockquote-footer
            } else {
                //check if .validated has d-none
                if (!$(".validated").hasClass("fade-out")) {
                    //add fade-out
                    $(".validated").addClass("fade-out");
                    //remove fade-in
                    $(".validated").removeClass("fade-in");
                }

                $('.blockquote-footer').text(
                    "{{ __('By unChecking you will use unvalidated and unverified survey') }}");
            }
        });
    </script>
@endsection
