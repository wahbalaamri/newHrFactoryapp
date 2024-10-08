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
                    <h1 class="m-0">{{ $survey->survey_title }} {{ __('Dashboard') }}</h1>
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
                            <h3 class="card-title">{{ $survey->survey_title }} {{ __('Tools') }}</h3>
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
                            <div class="row">
                                @if ($survey->customized)
                                <div class="col-lg-3 col-md-4 col-sm-12">
                                    <div class="small-box bg-warning">
                                        <div class="inner" style="min-height: 123px">
                                            <h3 style="font-size: 136%;">{{ __('Manage Statements') }}</h3>
                                            <p class="w-75">{{ __('Manage Customized Statements') }}</p>
                                        </div>
                                        <div class="icon">
                                            <i class="far fa-file-alt"></i>
                                        </div>
                                        <a href="{{ route('CustomizedSurvey.Functions',[$id,$survey->id]) }}"
                                            class="small-box-footer">
                                            {{ __('Start') }}<i class="fas fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>
                                @endif
                                <div class="col-lg-3 col-md-4 col-sm-12">
                                    <div class="small-box bg-info">
                                        <div class="inner" style="min-height: 123px">
                                            <h3 style="font-size: 136%;">{{ __('Respondents') }}</h3>
                                            <p class="w-75">{{ __('Manage Survey Respondents') }}</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-user-plus"></i>
                                        </div>
                                        <a href="{{ route('clients.Respondents',[$id,$type,$survey->id]) }}"
                                            class="small-box-footer">
                                            {{ __('Start') }}<i class="fas fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-12">
                                    <div class="small-box bg-warning">
                                        <div class="inner" style="min-height: 123px">
                                            <h3 style="font-size: 136%;">{{ __('Survey Email') }}</h3>
                                            <p class="w-75">{{ __('Setup Email For Survey') }}</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-mail-bulk"></i>
                                        </div>
                                        <a href="{{ route('clients.ShowCreateEmail',[$id,$type,$survey->id]) }}"
                                            class="small-box-footer">
                                            {{ __('Start') }}<i class="fas fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-12">

                                    <div class="small-box bg-success">
                                        <div class="inner" style="min-height: 123px">
                                            <h3 style="font-size: 136%;">{{ __('Send Survey') }}</h3>
                                            <p class="w-75">{{ __('You Can Setup Sending Survey') }}</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-email"></i>
                                        </div>
                                        <a href="{{ route('clients.showSendSurvey',[$id,$type,$survey->id]) }}"
                                            class="small-box-footer">
                                            {{ __('Start') }}<i class="fas fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-12">

                                    <div class="small-box bg-danger">
                                        <div class="inner" style="min-height: 123px">
                                            <h3 style="font-size: 136%;">{{ __('Send Reminders') }}</h3>
                                            <p class="w-75">{{ __('You Can Setup Sending Reminders') }}</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-email-unread"></i>
                                        </div>
                                        <a href="{{ route('clients.showSendSurvey',[$id,$type,$survey->id,'r']) }}" class="small-box-footer">
                                            {{ __('Start') }}<i class="fas fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-12">
                                    <div class="small-box bg-success">
                                        <div class="inner" style="min-height: 123px">
                                            <h3 style="font-size: 136%;">{{ __('Statistics') }}</h3>
                                            <p class="w-75">{{ __('Get Survey Ststistics') }}</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-chart-pie"></i>
                                        </div>
                                        <a href="{{ route('ManageHrDiagnosis.SurveyStat',['id'=>$survey->id,'cid'=>$id,'type'=>'all']) }}"
                                            class="small-box-footer">
                                            {{ __('Start') }}<i class="fas fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-12">
                                    <div class="small-box bg-info">
                                        <div class="inner" style="min-height: 123px">
                                            <h3 style="font-size: 136%;">{{ __('Results') }}</h3>
                                            <p class="w-75">{{ __('Get Survey Results') }}</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-stats-bars"></i>
                                        </div>
                                        <a href="{{ route('clients.SurveyResults',[$id,$type,$survey->id,'all']) }}"
                                            class="small-box-footer">
                                            {{ __('Start') }}<i class="fas fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
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
    $(document).ready(function() {
            $('#surveysDataTable').DataTable();
            $('ul').Treeview();
        });
</script>
@endsection
