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
                                <a href="{{ route('clients.ShowSurveys',[$id,$type]) }}"
                                    class="btn btn-sm btn-primary {{ App()->getLocale()=='ar'? 'float-start':'float-end' }}">{{
                                    __('Back') }}</a>
                                {{-- create new survey --}}
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('clients.storeSurvey',[$id,$type]) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                {{-- select plans --}}
                                <div class="form-group col-md-6 col-sm-12">
                                    <input type="hidden" name="h_plan_id" value="{{ $client_subscription->plan_id }}">
                                    <label for="plan_id">{{ __('Select Plan') }}</label>
                                    <select name="plan_id" id="plan_id" class="form-control" disabled>
                                        <option value="">{{ __('Select Plan') }}</option>
                                        @foreach ($plans as $plan)
                                        <option value="{{ $plan->id }}" @if($client_subscription->plan_id==$plan->id) selected @endif>{{ $plan->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-6 col-sm-12">
                                    <label for="survey_title">{{ __('Survey Title') }}</label>
                                    <input type="text" name="survey_title" id="survey_title" class="form-control"
                                        placeholder="{{ __('Survey Title') }}" required>
                                    @error('survey_title')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                {{-- textarea survey description --}}
                                <div class="form-group col-md-6 col-sm-12">
                                    <label for="survey_des">{{ __('Survey Description') }}</label>
                                    <textarea name="survey_des" id="survey_des" class="form-control summernote"
                                        placeholder="{{ __('Survey Description') }}" required></textarea>
                                    @error('survey_des')
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
                                {{-- submit --}}
                                <div @class([ 'form-group col-12' , 'text-right'=>
                                    App()->isLocale('en'),
                                    'text-left'=>App()->isLocale('ar')
                                    ])>
                                    <button type="submit" class="btn btn-primary">{{ __('Create Survey') }}</button>
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
    $("[name='survey_stat']").bootstrapSwitch();
         $('.summernote').summernote();
</script>
@endsection
