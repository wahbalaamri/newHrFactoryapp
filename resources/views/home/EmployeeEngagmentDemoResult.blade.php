<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HR Factory | Dashboard</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('dashboard/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset('dashboard/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('dashboard/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('dashboard/plugins/jqvmap/jqvmap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dashboard/dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('dashboard/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('dashboard/plugins/daterangepicker/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('dashboard/plugins/summernote/summernote-bs4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/plugins/bs-stepper/css/bs-stepper.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/plugins/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/CircularProgress.css') }}">
    @stack('styles')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ asset('assets/img/logo-1.png') }}" alt="AdminLTELogo" height=""
                width="">

        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="index3.html" class="nav-link">Home</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Contact</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">

                <!-- Messages Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-comments"></i>
                        <span class="badge badge-danger navbar-badge">3</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                <img src="{{ asset('dashboard/dist/img/user1-128x128.jpg') }}" alt="User Avatar"
                                    class="img-size-50 mr-3 img-circle">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        Brad Diesel
                                        <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">Call me whenever you can...</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                <img src="{{ asset('dashboard/dist/img/user8-128x128.jpg') }}" alt="User Avatar"
                                    class="img-size-50 img-circle mr-3">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        John Pierce
                                        <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">I got your message bro</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                <img src="{{ asset('dashboard/dist/img/user3-128x128.jpg') }}" alt="User Avatar"
                                    class="img-size-50 img-circle mr-3">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        Nora Silvester
                                        <span class="float-right text-sm text-warning"><i
                                                class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">The subject goes here</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
                    </div>
                </li>
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-warning navbar-badge">15</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">15 Notifications</span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-envelope mr-2"></i> 4 new messages
                            <span class="float-right text-muted text-sm">3 mins</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-users mr-2"></i> 8 friend requests
                            <span class="float-right text-muted text-sm">12 hours</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-file mr-2"></i> 3 new reports
                            <span class="float-right text-muted text-sm">2 days</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true"
                        href="#" role="button">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <div class="custom-hover brand-link">
                <a href="#" class="brand-link col-12">
                    <img src="{{ asset('assets/img/logo-1.png') }}" alt="HR Factory App logo"
                        class="brand-image img-circle elevation-3" style="opacity: .8">
                    <span class="brand-text font-weight-light">HR Factory App</span>
                </a>
            </div>
            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset('dashboard/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
                            alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">Demo</a>
                    </div>
                </div>
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fa fa-business-time"></i>
                                <p>
                                    {{ __('Manage') }}
                                    {{-- <span class="right badge badge-danger">New</span> --}}
                                </p>
                            </a>
                        </li>

                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>
        <div class="content-wrapper">
            <div class="container-fluid pt-5 mt-5">
                <div class="row">
                    <div class="col-12" id="finalResult">
                        <div class="card">
                            {{-- header --}}
                            <div class="card-header">
                                <div class="d-flex text-start">
                                    <h3 class="card-title text-black">
                                        {{ __('Organizational-wise') }} | {{ $entity }}</h3>
                                </div>
                            </div>
                            <div class="card-body">
                                {{-- row with three columns idintical --}}
                                <div class="row">
                                    <div
                                        class="col-lg-5 col-md-12 col-sm-12 pl-5 pr-5 d-flex align-items-stretch margin-right-52px justify-content-center">
                                        <div class="card bg-light p-3 mb-3 rounded w-75">
                                            {{-- header with blue background --}}
                                            <div class="card-header bg-info">
                                                {{-- centerlize items --}}
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <h3 class="card-title text-white text-center pt-4 pb-4">
                                                        {{ __('Employee Engagement Index') }}</h3>
                                                </div>
                                            </div>
                                            {{-- body --}}
                                            <div class="card-body">
                                                @if (count($outcomes) > 0)
                                                    <div
                                                        class="row d-flex justify-content-center align-items-center text-center">
                                                        <div class="col-12">
                                                            <div
                                                                class="speedometer @if ($outcomes[0]['outcome_index'] >= 75) speed-5
                                                                @elseif($outcomes[0]['outcome_index'] >= 60)
                                                                speed-4
                                                                @elseif($outcomes[0]['outcome_index'] >= 50)
                                                                speed-3
                                                                @elseif($outcomes[0]['outcome_index'] >= 40)
                                                                speed-2
                                                                @else
                                                                speed-1 @endif
                                                        ">
                                                                <div class="pointer"></div>
                                                            </div>
                                                            <h3 class="caption">{{ $outcomes[0]['outcome_index'] }}%
                                                            </h3>
                                                        </div>
                                                        <div class="col-12 mt-5">
                                                            <div class="row">
                                                                <div class="col-sm-4 col-xs-12 progress-container">
                                                                    <div class="custom-progress mb-3">
                                                                        <div class="custom-progress-bar bg-success @if ($outcomes[0]['Favorable_score'] <= 0) text-danger @endif"
                                                                            style="height:{{ $outcomes[0]['Favorable_score'] }}%; min-height: 15% !important;">
                                                                            <span>{{ $outcomes[0]['Favorable_score'] }}%</span>
                                                                        </div>
                                                                    </div>
                                                                    <span
                                                                        class="caption h6">{{ __('Engaged') }}</span>
                                                                </div>
                                                                <div class="col-sm-4 col-xs-12 progress-container">
                                                                    <div class="custom-progress mb-3">
                                                                        <div class="custom-progress-bar bg-warning @if ($outcomes[0]['Nuetral_score'] <= 0) text-danger @endif"
                                                                            style="height:{{ $outcomes[0]['Nuetral_score'] }}%; min-height: 15% !important;">
                                                                            <span>{{ $outcomes[0]['Nuetral_score'] }}%</span>
                                                                        </div>
                                                                    </div>
                                                                    <span
                                                                        class="caption h6">{{ __('Nuetral') }}</span>
                                                                </div>
                                                                <div class="col-sm-4 col-xs-12 progress-container">
                                                                    <div class="custom-progress mb-3">
                                                                        <div class="custom-progress-bar bg-danger @if ($outcomes[0]['UnFavorable_score'] <= 0) text-danger @endif"
                                                                            style="height:{{ $outcomes[0]['UnFavorable_score'] }}%; min-height: 15% !important;">
                                                                            <span>{{ $outcomes[0]['UnFavorable_score'] }}%</span>
                                                                        </div>
                                                                    </div>
                                                                    <span
                                                                        class="caption h6">{{ __('Actively Disengaged') }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @if ($ENPS_data_array)
                                        <div
                                            class="col-lg-5 col-md-12 col-sm-12 pl-5 pr-5 d-flex align-items-stretch margin-right-52px justify-content-center">
                                            <div class="card bg-light p-3 mb-3 rounded w-75">
                                                {{-- header with blue background --}}
                                                <div class="card-header bg-info">
                                                    {{-- centerlize items --}}
                                                    <div class="d-flex justify-content-center align-items-center">
                                                        <h3 class="card-title text-white text-center pt-2 pb-2">
                                                            {{ __('Employee Net Promotor Score (eNPS)') }}</h3>
                                                    </div>
                                                </div>
                                                {{-- body --}}
                                                <div class="card-body">
                                                    <div
                                                        class="row d-flex justify-content-center align-items-center text-center">
                                                        <div class="col-12">
                                                            <div @class([
                                                                'speedometer',
                                                                'speed-5' => $ENPS_data_array['ENPS_index'] > 0,
                                                                'speed-3' => $ENPS_data_array['ENPS_index'] == 0,
                                                                'speed-1' => $ENPS_data_array['ENPS_index'] < 0,
                                                            ])>
                                                                <div class="pointer"></div>
                                                            </div>
                                                            <h3 class="caption">{{ $ENPS_data_array['ENPS_index'] }}%
                                                            </h3>
                                                        </div>
                                                        <div class="col-12 mt-5">
                                                            <div class="row">
                                                                <div class="col-sm-4 col-xs-12 progress-container">
                                                                    <div class="custom-progress mb-3">
                                                                        <div class="custom-progress-bar bg-success @if ($ENPS_data_array['Favorable_score'] <= 0) text-danger @endif"
                                                                            style="height:{{ $ENPS_data_array['Favorable_score'] }}%; min-height: 15% !important;">
                                                                            <span>{{ $ENPS_data_array['Favorable_score'] }}%</span>
                                                                        </div>
                                                                    </div>
                                                                    <span
                                                                        class="caption h6">{{ __('Promotors') }}</span>
                                                                </div>
                                                                <div class="col-sm-4 col-xs-12 progress-container">
                                                                    <div class="custom-progress mb-3">
                                                                        <div class="custom-progress-bar bg-warning @if ($ENPS_data_array['Nuetral_score'] <= 0) text-danger @endif"
                                                                            style="height:{{ $ENPS_data_array['Nuetral_score'] }}%; min-height: 15% !important;">
                                                                            <span>{{ $ENPS_data_array['Nuetral_score'] }}%</span>
                                                                        </div>
                                                                    </div>
                                                                    <span
                                                                        class="caption h6 pt-3">{{ __('Passives') }}</span>
                                                                </div>
                                                                <div class="col-sm-4 col-xs-12 progress-container">
                                                                    <div class="custom-progress mb-3">
                                                                        <div class="custom-progress-bar bg-danger @if ($ENPS_data_array['UnFavorable_score'] <= 0) text-danger @endif"
                                                                            style="height:{{ $ENPS_data_array['UnFavorable_score'] }}%; min-height: 15% !important;">
                                                                            <span>{{ $ENPS_data_array['UnFavorable_score'] }}%</span>
                                                                        </div>
                                                                    </div>
                                                                    <span
                                                                        class="caption h6 pt-3">{{ __('Detractors') }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="row">
                                    <div class="card bg-light p-3 mb-3 rounded w-100">
                                        {{-- header with blue background --}}
                                        <div class="card-header bg-info">
                                            {{-- centerlize items --}}
                                            <div class="d-flex justify-content-center align-items-center">
                                                <h3 class="card-title text-white text-center pt-4 pb-4">
                                                    {{ __('Employee Engagement Drivers') }}</h3>
                                            </div>
                                        </div>
                                        {{-- body --}}
                                        <div class="card-body">
                                            <div
                                                class="row d-flex justify-content-center align-items-center text-center">
                                                @foreach ($drivers_functions as $function)
                                                    <div class="col-md-4 col-sm-12">
                                                        <div class="caption">
                                                            <h3 class="h3">{{ $function['function_title'] }}</h3>
                                                            {{-- <h5 class="h6">({{ $fun['fun_des'] }})</h5> --}}
                                                        </div>
                                                        <div
                                                            class="speedometer

                                                @if ($function['Favorable_score'] >= 75) speed-5
                                                @elseif($function['Favorable_score'] >= 60)
                                                speed-4
                                                @elseif($function['Favorable_score'] >= 50)
                                                speed-3
                                                @elseif($function['Favorable_score'] >= 40)
                                                speed-2
                                                @else
                                                speed-1 @endif
                                                ">
                                                            <div class="pointer"></div>
                                                        </div>
                                                        <h3 class="caption">{{ $function['Favorable_score'] }}%</h3>
                                                        @foreach ($drivers as $practice)
                                                            @if ($practice['function'] == $function['function'])
                                                                <div
                                                                    class="col-12 pt-2 pb-2 text-center mb-2 rounded
                                                    @if ($practice['Favorable_score'] >= 75) bg-success text-white
                                                    @elseif($practice['Favorable_score'] >= 40)
                                                        bg-warning
                                                        @else
                                                        bg-danger text-white @endif
                                                    ">
                                                                    {{ $practice['practice_title'] }}{{-- -- {{
                                                        $practice['Favorable_score']}}
                                                        --}}
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- end of card --}}
                        {{-- card for Top and Bottom Scores-Organizational Wide --}}
                        <div class="card shadow p-3 mb-5 bg-white rounded">
                            {{-- header --}}
                            <div class="card-header d-flex align-items-center">
                                <h2 class="h4 text-orange">{{ __('Top and Bottom Scores - ') }}
                                    {{ __('Company-Wise') }}

                                </h2>


                            </div>
                            {{-- body --}}

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        {{-- card --}}
                                        <div class="card p-3 mb-5 rounded">
                                            {{-- header --}}
                                            <div class="card-header d-flex align-items-center bg-info">
                                                <h3 class="h3 text-white">{{ __('Key Strengths') }}</h3>
                                            </div>
                                            {{-- body --}}
                                            <div class="card-body">

                                                <div class="">
                                                    @foreach ($driver_practice_desc as $parctice)
                                                        @if ($parctice['Favorable_score'] >= 75)
                                                            <span class="caption">
                                                                {{ $parctice['practice_title'] }}</span>
                                                            <div class="progress rounded" role="progressbar"
                                                                aria-label="Warning example"
                                                                aria-valuenow="{{ $parctice['Favorable_score'] }}"
                                                                aria-valuemin="0" aria-valuemax="100"
                                                                style="height: 20px; padding: 0;">
                                                                <div class="progress-bar bg-success"
                                                                    style="width: {{ $parctice['Favorable_score'] }}% ; font-size: 0.9rem;">
                                                                    {{ $parctice['Favorable_score'] }}%</div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        {{-- card --}}
                                        <div class="card p-3 mb-5 rounded">
                                            {{-- header --}}
                                            <div class="card-header d-flex align-items-center bg-info">
                                                <h3 class="h3 text-white">{{ __('Key Improvement Areas') }}</h3>
                                            </div>
                                            {{-- body --}}
                                            <div class="card-body">
                                                <div class="row-">
                                                    <div class="progress-bar bg-success" style="width: 25%"></div>
                                                    @foreach ($driver_practice_asc as $parctice)
                                                        @if ($parctice['Favorable_score'] < 75)
                                                            <span class="caption">
                                                                {{ $parctice['practice_title'] }}
                                                            </span>
                                                            <div class="progress rounded" role="progressbar"
                                                                aria-label="Warning example"
                                                                aria-valuenow="{{ $parctice['Favorable_score'] }}"
                                                                aria-valuemin="0" aria-valuemax="100"
                                                                style="height: 20px; padding: 0;">
                                                                <div class="progress-bar
                                            @if ($parctice['Favorable_score'] >= 75) bg-success
                                            @elseif ($parctice['Favorable_score'] >= 40)
                                            bg-warning
                                            @else
                                            bg-danger @endif
                                            "
                                                                    style="min-width: 10%; width: {{ $parctice['Favorable_score'] }}% ; font-size: 0.9rem;">
                                                                    {{ $parctice['Favorable_score'] }}%</div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        {{--
                                        ===========================================================================
                                        --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if ($type != 'comp')
                            <div class="card shadow p-3 mb-5 bg-white rounded">
                                {{-- header --}}
                                <div class="card-header d-flex align-items-center">
                                    <h2 class="h4 text-orange">
                                        {{ __('Heat Map - Engagement Drivers Result across ') }}</h2>
                                </div>
                                {{-- body --}}
                                <div class="card-body">

                                    <div class="table-responsive">
                                        <table class="table table-active table-bordered" aria-colspan="2"
                                            style="font-size: 1.15rem;">
                                            <thead>
                                                <tr class="text-center">
                                                    <th class="bg-info text-white">
                                                        @if ($type == 'all')
                                                            {{ __('Sector') }}
                                                        @elseif ($type == 'sec')
                                                            {{ __('Department') }}
                                                        @endif
                                                    </th>
                                                    <th class="bg-info text-white">{{ __('Engagement Index') }}</th>
                                                    <th class="bg-info text-white">{{ __('Head') }}</th>
                                                    <th class="bg-info text-white">
                                                        {{ __('Hand') }}
                                                    </th>
                                                    <th class="bg-info text-white">{{ __('Heart') }}</th>
                                                    <th class="bg-info text-white">{{ __('eNPS') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($heat_map as $heat)
                                                    <tr class="text-center" onclick="#">
                                                        <a href="#">
                                                            <td class="bg-light">{{ $heat['entity_name'] }}</td>

                                                            <td
                                                                class="@if ($heat['indecators'][3]['score'] >= 75) bg-success
                                            @elseif($heat['indecators'][3]['score'] >= 40)
                                                bg-warning
                                                @else
                                                bg-danger @endif text-white">
                                                                {{ $heat['indecators'][3]['score'] }}
                                                            </td>
                                                            <td
                                                                class="@if ($heat['indecators'][0]['score'] >= 75) bg-success
                                            @elseif($heat['indecators'][0]['score'] >= 40)
                                                bg-warning
                                                @else
                                                bg-danger @endif text-white">
                                                                {{ $heat['indecators'][0]['score'] }}
                                                            </td>
                                                            <td
                                                                class="@if ($heat['indecators'][1]['score'] >= 75) bg-success
                                            @elseif($heat['indecators'][1]['score'] >= 40)
                                                bg-warning
                                                @else
                                                bg-danger @endif text-white">
                                                                {{ $heat['indecators'][1]['score'] }}
                                                            </td>
                                                            <td
                                                                class="@if ($heat['indecators'][2]['score'] >= 75) bg-success
                                            @elseif($heat['indecators'][2]['score'] >= 40)
                                                bg-warning
                                                @else
                                                bg-danger @endif text-white">
                                                                {{ $heat['indecators'][2]['score'] }}
                                                            </td>
                                                            <td
                                                                class="@if ($heat['indecators'][4]['score'] > 0) bg-success
                                            @elseif($heat['indecators'][4]['score'] == 0)
                                                bg-warning
                                                @else
                                                bg-danger @endif text-white">
                                                                {{ $heat['indecators'][4]['score'] }}
                                                            </td>

                                                    </tr>
                                                @endforeach
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    </div>
                </div>
            </div>
            <footer class="main-footer">
                <strong>Copyright &copy; 2024-2025 <a href="https://hrfactoryapp.com">HR Factory</a>.</strong>
                All rights reserved.
                <div class="float-right d-none d-sm-inline-block">
                    <b>Version</b> 1.0.0
                </div>
            </footer>

            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Control sidebar content goes here -->
            </aside>
            <!-- /.control-sidebar -->
        </div>

    </div>
    <!-- ./wrapper -->
    <!-- jQuery -->
    <script src="{{ asset('dashboard/plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('dashboard/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('dashboard/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('dashboard/plugins/chart.js/Chart.min.js') }}"></script>
    <!-- Sparkline -->
    <script src="{{ asset('dashboard/plugins/sparklines/sparkline.js') }}"></script>
    <!-- JQVMap -->
    <script src="{{ asset('dashboard/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="https://jvectormap.com/js/jquery-jvectormap-world-mill.js"></script>
    {{-- <script src="{{ asset('dashboard/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script> --}}
    <!-- jQuery Knob Chart -->
    <script src="{{ asset('dashboard/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <!-- daterangepicker -->
    <script src="{{ asset('dashboard/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('dashboard/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/bs-stepper/js/bs-stepper.min.js') }}"></script>
    <!-- Summernote -->
    <script src="{{ asset('dashboard/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('dashboard/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dashboard/dist/js/adminlte.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('dashboard/dist/js/demo.js') }}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{ asset('dashboard/dist/js/pages/dashboard.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/datatables-responsive/js/dataTables.responsive.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/datatables-buttons/js/dataTables.buttons.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/toastr/toastr.min.js') }}"></script>
    @yield('scripts')

</body>

</html>
