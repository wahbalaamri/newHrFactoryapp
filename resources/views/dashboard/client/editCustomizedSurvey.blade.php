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
                                    <a href="{{ route('clients.ShowCustomizedSurveys', [$id, $type]) }}"
                                        class="btn btn-sm btn-primary {{ App()->getLocale() == 'ar' ? 'float-start' : 'float-end' }}">{{ __('Back') }}</a>
                                    {{-- create new survey --}}
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('clients.storeCustomizedSurvey', [$id, $type]) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        {{-- select plans --}}
                                        <div class="form-group col-md-6 col-sm-12">
                                            <input type="hidden" name="h_plan_id"
                                                value="{{ $client_subscription->plan_id }}">
                                            <input type="hidden" name="h_splan_id" value="{{ $client_subscription->id }}">
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
                                        <div class="form-group col-md-6 col-sm-12">
                                            <label for="survey_title">{{ __('Survey Title') }}</label>
                                            <input type="text" name="survey_title" id="survey_title" class="form-control"
                                                placeholder="{{ __('Survey Title') }}">
                                            @error('survey_title')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        {{-- switch survey_stat --}}
                                        <div class="form-group col-md-6 col-sm-12">
                                            <label for="survey_stat">{{ __('Status') }}</label>
                                            <br>
                                            <input type="checkbox" name="survey_stat" checked data-bootstrap-switch
                                                data-off-color="danger" data-on-color="success">
                                        </div>
                                        <div class="form-group col-md-6 col-sm-12">
                                            <label for="candidate_raters_model">
                                                {{ __('Candidate Raters Model') }}
                                                <div class="col-12">
                                                    <input type="checkbox" name="candidate_raters_model"
                                                        data-bootstrap-switch="" data-off-color="danger"
                                                        data-on-color="success" value="1">
                                                </div>
                                        </div>
                                        {{-- switch cycle_stat --}}
                                        <div class="form-group col-md-6 col-sm-12">
                                            <label
                                                for="cycle_stat">{{ __('Will this survey will be pulsed frequently?') }}</label>
                                            <br>
                                            <input type="checkbox" name="cycle_stat" data-bootstrap-switch
                                                data-off-color="danger" data-on-color="success">
                                        </div>
                                        <div class="form-group col-md-6 col-sm-12">
                                            <label
                                                for="reminder_stat">{{ __('Is there reminder should be send to
                                                                                            respondents?') }}</label>
                                            <br>
                                            <input type="checkbox" name="reminder_stat" data-bootstrap-switch
                                                data-off-color="danger" data-on-color="success">
                                        </div>
                                        <div class="form-group col-md-6 col-sm-12">
                                            <label
                                                for="mandatory_stat">{{ __('Is it must to collect all respondent answers before start next cycle?') }}</label>
                                            <br>
                                            <input type="checkbox" name="mandatory_stat" data-bootstrap-switch
                                                data-off-color="danger" data-on-color="success">
                                        </div>
                                    </div>
                                    <div class="row" id="cycle-row">
                                        {{-- select cycle --}}
                                        <div class="form-group col-md-6 col-sm-12">
                                            <label for="cycle_id">{{ __('Select Cycle') }}</label>
                                            <select name="cycle_id" id="cycle_id" class="form-control">
                                                <option value="">{{ __('Select Cycle') }}</option>
                                                <option value="1d"> {{ __('Every Day') }}</option>
                                                <option value="2d"> {{ __('Every Two Days') }}</option>
                                                <option value="3d"> {{ __('Every Three Days') }}</option>
                                                <option value="4d"> {{ __('Every Four Days') }}</option>
                                                <option value="5d"> {{ __('Every Five Days') }}</option>
                                                <option value="1w"> {{ __('Every Week') }}</option>
                                                <option value="2w"> {{ __('Every Two Weeks') }}</option>
                                                <option value="3w"> {{ __('Every Three Weeks') }}</option>
                                                <option value="1m"> {{ __('Every Month') }}</option>
                                                <option value="2m"> {{ __('Every Two Months') }}</option>
                                                <option value="1q"> {{ __('Quarterly') }}</option>
                                                <option value="sa"> {{ __('Semi Annual') }}</option>
                                                <option value="1a"> {{ __('Annual') }}</option>
                                            </select>
                                        </div>
                                        {{-- cycle start_date --}}
                                        <div class="form-group col-md-6 col-sm-12">
                                            <label for="start_date">{{ __('Cycle Start Date & Time') }}</label>
                                            <div class="row">
                                                <input type="date" name="start_date" id="start_date"
                                                    class="form-control col-4 m-1"
                                                    placeholder="{{ __('Cycle Start Date') }}">
                                                <input type="time" name="start_time" id="start_time"
                                                    class="form-control col-4 m-1"
                                                    placeholder="{{ __('Cycle Start Time') }}">
                                            </div>
                                            @error('start_date')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                            @error('start_time')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        {{-- cycle end_date --}}
                                        <div class="form-group col-md-6 col-sm-12">
                                            <label for="end_date">{{ __('Cycle End Date') }}</label>
                                            <input type="date" name="end_date" id="end_date"
                                                class="form-control col-4" placeholder="{{ __('Cycle End Date') }}">
                                            @error('end_date')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6 col-sm-12">
                                            <label for="reminder_duration_type">{{ __('Select Reminder Cycle') }}</label>
                                            <select name="reminder_duration_type" id="reminder_duration_type"
                                                class="form-control">
                                                <option value="">{{ __('Select Cycle') }}</option>
                                                <option value="1d"> {{ __('Every Day') }}</option>
                                                <option value="2d"> {{ __('Every Two Days') }}</option>
                                                <option value="3d"> {{ __('Every Three Days') }}</option>
                                                <option value="4d"> {{ __('Every Four Days') }}</option>
                                                <option value="5d"> {{ __('Every Five Days') }}</option>
                                                <option value="1w"> {{ __('Every Week') }}</option>
                                                <option value="2w"> {{ __('Every Two Weeks') }}</option>
                                                <option value="3w"> {{ __('Every Three Weeks') }}</option>
                                                <option value="1m"> {{ __('Every Month') }}</option>
                                                <option value="2m"> {{ __('Every Two Months') }}</option>
                                                <option value="1q"> {{ __('Quarterly') }}</option>
                                                <option value="sa"> {{ __('Semi Annual') }}</option>
                                                <option value="1a"> {{ __('Annual') }}</option>
                                            </select>
                                        </div>
                                        {{-- cycle start_date --}}
                                        <div class="form-group col-md-6 col-sm-12">
                                            <label
                                                for="reminder_start_date">{{ __('Reminder Start Date & Time') }}</label>
                                            <div class="row">
                                                <input type="date" name="reminder_start_date" id="reminder_start_date"
                                                    class="form-control col-4 m-1"
                                                    placeholder="{{ __('Cycle Start Date') }}">
                                                <input type="time" name="reminder_start_time" id="reminder_start_time"
                                                    class="form-control col-4 m-1"
                                                    placeholder="{{ __('Cycle Start Time') }}">
                                            </div>
                                            @error('reminder_start_date')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                            @error('reminder_start_time')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        {{-- textarea survey description --}}
                                        <div class="form-group col-md-6 col-sm-12">
                                            <label for="survey_des">{{ __('Survey Description') }}</label>
                                            <textarea name="survey_des" id="survey_des" class="form-control summernote"
                                                placeholder="{{ __('Survey Description') }}"></textarea>
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
                                                class="btn btn-primary">{{ __('Create Survey') }}</button>
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
        $("[type='checkbox']").bootstrapSwitch();
        $('.summernote').summernote();
    </script>
@endsection
