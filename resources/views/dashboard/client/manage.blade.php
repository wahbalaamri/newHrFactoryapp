@extends('dashboard.layouts.main')
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
            <!-- Small boxes (Stat box) -->
            <div class="row">

                <!-- ./col -->
            </div>
            <!-- /.row -->
            <!-- Main row -->
            <div class="row">
                <!-- Left col -->
                <section class="connectedSortable w-100">
                    <!-- Custom tabs (Charts with tabs)-->
                    <div class="card card-outline card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-users mr-1"></i>
                                {{ __("Client's Tools") }}
                            </h3>
                            <div class="card-tools">
                            </div>
                        </div><!-- /.card-header -->
                        {{-- card body --}}
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-3 col-6">

                                    <div class="small-box bg-success">
                                        <div class="inner" style="min-height: 123px">
                                            <h3 style="font-size: 1.2rem">{{ ('Your Org-Chart') }}</h3>
                                            <p class="w-75">{{ ("Manage Your Org-chart") }}</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-desktop"></i>
                                        </div>
                                        <a href="{{route('clients.orgChart',$id)}}" class="small-box-footer">
                                            {{ __('Get Started') }} <i class="fas fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-6">

                                    <div class="small-box bg-danger">
                                        <div class="inner" style="min-height: 123px">
                                            <h3 style="font-size: 1.2rem">{{ ('Your Employees') }}</h3>
                                            <p class="w-75">{{ ("Manage Your Employee (Respondents)") }}</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-business-time"></i>
                                        </div>
                                        <a href="{{route('clients.Employees',$id)}}" class="small-box-footer">
                                            {{ __('Get Started') }} <i class="fas fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-6">

                                    <div class="small-box bg-info">
                                        <div class="inner" style="min-height: 123px">
                                            <h3 style="font-size: 1.2rem">{{ __('Manual Builder') }}</h3>
                                            <p class="w-75">{{ __('HR Policy Builder') }}</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-file-alt"></i>
                                        </div>
                                        <a href="{{ \App\Http\Facades\Landing::CheckUserSubscription($id,1)? route('manualBuilder.ClientSections',$id):'#' }}"
                                            class="small-box-footer">
                                            {{ __('Get Started') }} <i class="fas fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-6">

                                    <div class="small-box bg-warning">
                                        <div class="inner" style="min-height: 123px">
                                            <h3 style="font-size: 1.2rem">{{ __('Employee Engagment') }}</h3>
                                            <p class="w-75">{{ __("Measure Your Employee Happiness") }}</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-happy"></i>
                                        </div>
                                        <a href="{{ \App\Http\Facades\Landing::CheckUserSubscription($id,3)? route('clients.ShowSurveys',[$id,3]):'#' }}" class="small-box-footer">
                                            {{ __('Get Started') }} <i class="fas fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-6">

                                    <div class="small-box bg-secondary">
                                        <div class="inner" style="min-height: 123px">
                                            <h3 style="font-size: 1.2rem">{{ ('HR Diagnosis') }}</h3>
                                            <p class="w-75">{{ ("Insepct You HR Department") }}</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-business-time"></i>
                                        </div>
                                        <a href="{{\App\Http\Facades\Landing::CheckUserSubscription($id,4)? route('clients.ShowSurveys',[$id,4]):'#'}}" class="small-box-footer">
                                            {{ __('Get Started') }} <i class="fas fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-6">

                                    <div class="small-box bg-warning">
                                        <div class="inner" style="min-height: 123px">
                                            <h3 style="font-size: 1.2rem">{{ __('360 Leader Review') }}</h3>
                                            <p class="w-75">{{ __('Assess Your Leaders From 360 Degree') }}</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-user-tie"></i>
                                        </div>
                                        <a href="{{\App\Http\Facades\Landing::CheckUserSubscription($id,5)? route('clients.ShowSurveys',[$id,5]):'#'}}" class="small-box-footer">
                                            {{ __('Get Started') }} <i class="fas fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-6">

                                    <div class="small-box bg-success">
                                        <div class="inner" style="min-height: 123px">
                                            <h3 style="font-size: 1.2rem">{{ __('360 Leader Review Customized') }}</h3>
                                            <p class="w-75">{{ __('Assess Your Leaders From 360 Degree') }}</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-user-tie"></i>
                                        </div>
                                        <a href="{{\App\Http\Facades\Landing::CheckUserSubscription($id,6)? route('clients.ShowSurveys',[$id,6]):'#'}}" class="small-box-footer">
                                            {{ __('Get Started') }} <i class="fas fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-6">

                                    <div class="small-box bg-danger">
                                        <div class="inner" style="min-height: 123px">
                                            <h3 style="font-size: 1.2rem">{{ ('HR Templates') }}</h3>
                                            <p class="w-75">{{ ("Access Most Used HR Templates") }}</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-folder-open"></i>
                                        </div>
                                        <a href="#" class="small-box-footer">
                                            {{ __('Get Started') }} <i class="fas fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-6">

                                    <div class="small-box bg-info">
                                        <div class="inner" style="min-height: 123px">
                                            <h3 style="font-size: 1.2rem">Customized surveys</h3>
                                            <p class="w-75">Build your own customized survey</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-file-alt"></i>
                                        </div>
                                        <a href="{{ route('clients.ShowCustomizedSurveys',[$id,7]) }}"
                                            class="small-box-footer">
                                            Get Started <i class="fas fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(Auth::user()->isAdmin)
                    <div class="card card-outline card-primary mt-2">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-user-cog mr-1"></i>
                                {{ __("Admin Tools") }}
                            </h3>
                            <div class="card-tools">
                            </div>
                        </div><!-- /.card-header -->
                        {{-- card body --}}
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-3 col-6">

                                    <div class="small-box bg-success">
                                        <div class="inner" style="min-height: 123px">
                                            <h3 style="font-size: 1.2rem">{{ ('Client Subscriptions') }}</h3>
                                            <p class="w-75">{{ ("View all Client Subscriptions") }}</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-desktop"></i>
                                        </div>
                                        <a href="{{route('clients.viewSubscriptions',$id)}}" class="small-box-footer">
                                            {{ __('Get Started') }} <i class="fas fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    <!-- /.card -->
                </section>
                <!-- /.Left col -->
            </div>
        </div>
    </section>
</div>
@endsection
