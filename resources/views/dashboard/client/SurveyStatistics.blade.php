@extends('dashboard.layouts.main')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Welcome to HR Factory</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Welcomepage</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ __('Statistics of ') . $survey->survey_title }} </h3>
            </div>
            <div class="card-body">
                <div class="card-body">

                    <div id="accordion">
                        {{-- Sector-wise result --}}
                        <div class="card card-primary">
                            <div class="card-header">
                                <h4 class="card-title w-100">
                                    <a class="d-block w-100" data-toggle="collapse" href="#collapseOne"
                                        aria-expanded="false">
                                        {{ __('Sector wise results') }}
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseOne" class="collapse" data-parent="#accordion" style="">
                                <div class="card-body">
                                    <div class="row justify-content-center">
                                        @if (count($sector_stat) > 0)
                                        {{ __('here is the statistics of the survey') }}
                                        @else
                                        <div class="col-md-4">
                                            <div class="card card-outline card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">{{ __('Singl Sector') }}</h3>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row justify-content-center">
                                                        <div class="">
                                                            <div @class([ 'card card-outline' , 'card-success'=>
                                                                $total_percentage >= 70,
                                                                'card-warning' =>
                                                                $total_percentage > 40 &&
                                                                $total_percentage < 70, 'card-danger'=>
                                                                    $total_percentage <= 40, ])>
                                                                        <div class="card-header">
                                                                            <h3 class="card-title">{{__('Overall')}}
                                                                            </h3>
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <div @class([ 'small-box' , ' bg-success'=>
                                                                                $total_percentage >= 70,
                                                                                'bg-warning' =>
                                                                                $total_percentage > 40 &&
                                                                                $total_percentage < 70, 'bg-danger'=>
                                                                                    $total_percentage <= 40, ])>
                                                                                        <div class="inner text-center">
                                                                                            <h3>{{
                                                                                                number_format($total_percentage,
                                                                                                2) }}<sup
                                                                                                    style="font-size: 20px">%</sup>
                                                                                            </h3>
                                                                                            <p>{{ __('Total answered') .
                                                                                                ':
                                                                                                ' .
                                                                                                $sum_of_answered
                                                                                                }}
                                                                                            </p>
                                                                                        </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="card-footer">
                                                                            <p>{{ __('Targeted Number') .
                                                                                ':
                                                                                ' .
                                                                                $sum_of_respondents }}
                                                                            </p>
                                                                        </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Company-wise result --}}
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h4 class="card-title w-100">
                                    <a class="d-block w-100" data-toggle="collapse" href="#collapseTwo">
                                        {{ 'Company-wise Results' }}
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseTwo" class="collapse" data-parent="#accordion">
                                <div class="card-body">
                                    <div class="row justify-content-center">
                                        @if (count($company_stat) > 0)
                                        {{ __('here is the statistics of the survey') }}
                                        @else
                                        <div class="col-md-4">
                                            <div class="card card-outline card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">{{ __('Singl Company') }}</h3>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row justify-content-center">
                                                        <div class="">
                                                            <div @class([ 'card card-outline' , 'card-success'=>
                                                                $total_percentage >= 70,
                                                                'card-warning' =>
                                                                $total_percentage > 40 &&
                                                                $total_percentage < 70, 'card-danger'=>
                                                                    $total_percentage <= 40, ])>
                                                                        <div class="card-header">
                                                                            <h3 class="card-title">{{ __('Overall') }}
                                                                            </h3>
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <div @class([ 'small-box' , ' bg-success'=>
                                                                                $total_percentage >= 70,
                                                                                'bg-warning' =>
                                                                                $total_percentage > 40 &&
                                                                                $total_percentage < 70, 'bg-danger'=>
                                                                                    $total_percentage <= 40, ])>
                                                                                        <div class="inner text-center">
                                                                                            <h3>{{
                                                                                                number_format($total_percentage,
                                                                                                2) }}<sup
                                                                                                    style="font-size: 20px">%</sup>
                                                                                            </h3>
                                                                                            <p>{{ __('Total answered') .
                                                                                                ':
                                                                                                ' .
                                                                                                $sum_of_answered
                                                                                                }}
                                                                                            </p>
                                                                                        </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="card-footer">
                                                                            <p>{{ __('Targeted Number') .
                                                                                ':
                                                                                ' .
                                                                                $sum_of_respondents }}
                                                                            </p>
                                                                        </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Region-wise result --}}
                        <div class="card card-primary">
                            <div class="card-header">
                                <h4 class="card-title w-100">
                                    <a class="d-block w-100" data-toggle="collapse" href="#collapseThree">
                                        {{ 'Region-wise Results' }}
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseThree" class="collapse" data-parent="#accordion">
                                <div class="card-body">
                                    <div class="row justify-content-center">
                                        @if (count($region_stat) > 0)
                                        @foreach ($region_stat as $single_region)
                                        <div class="col-md-3">
                                            <div @class([ 'card card-outline' , 'card-success'=>
                                                $total_percentage >= 70,
                                                'card-warning' =>
                                                $total_percentage > 40 && $single_region['percentage'] <
                                                    70, 'card-danger'=> $single_region['percentage'] <= 40, ])>
                                                        <div class="card-header">
                                                            <h3 class="card-title">{{ $single_region['entity_name'] }}
                                                            </h3>
                                                        </div>
                                                        <div class="card-body">
                                                            <div @class([ 'small-box' , ' bg-success'=>
                                                                $single_region['percentage'] >= 70,
                                                                'bg-warning' =>
                                                                $single_region['percentage'] > 40 &&
                                                                $single_region['percentage'] < 70, 'bg-danger'=>
                                                                    $single_region['percentage'] <= 40, ])>
                                                                        <div class="inner text-center">
                                                                            <h3>{{
                                                                                number_format($single_region['percentage'],
                                                                                2) }}<sup
                                                                                    style="font-size: 20px">%</sup>
                                                                            </h3>
                                                                            <p>{{ __('Total answered') .
                                                                                ':
                                                                                ' .
                                                                                $single_region['answered'] }}
                                                                            </p>
                                                                        </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-footer">
                                                            <p>{{ __('Targeted Number') .
                                                                ':
                                                                ' .
                                                                $single_region['respondents'] }}
                                                            </p>
                                                        </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        @else
                                        <div class="col-md-3">
                                            <div class="card card-outline card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">{{ __('Singl Region') }}</h3>
                                                </div>
                                                <div class="card-body">
                                                    {{ 'There is Only one Region' }}
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Branch-wise result --}}
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h4 class="card-title">
                                    <a class="d-block w-100" data-toggle="collapse" href="#collapseFour">
                                        {{ 'Branch-wise Results' }}
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseFour" class="collapse" data-parent="#accordion">
                                <div class="card-body">
                                    @if (count($branch_stat) > 0)
                                    <div class="row">
                                        @foreach ($branch_stat as $single_region)
                                        <div class="col-md-3">
                                            <div @class([ 'card card-outline' , 'card-success'=>
                                                $single_region['percentage'] >= 70,
                                                'card-warning' =>
                                                $single_region['percentage'] > 40 && $single_region['percentage'] <
                                                    70, 'card-danger'=> $single_region['percentage'] <= 40, ])>
                                                        <div class="card-header">
                                                            <h3 class="card-title">{{ $single_region['entity_name'] }}
                                                            </h3>
                                                        </div>
                                                        <div class="card-body">
                                                            <div @class([ 'small-box' , ' bg-success'=>
                                                                $single_region['percentage'] >= 70,
                                                                'bg-warning' =>
                                                                $single_region['percentage'] > 40 &&
                                                                $single_region['percentage'] < 70, 'bg-danger'=>
                                                                    $single_region['percentage'] <= 40, ])>
                                                                        <div class="inner text-center">
                                                                            <h3>{{
                                                                                number_format($single_region['percentage'],
                                                                                2) }}<sup
                                                                                    style="font-size: 20px">%</sup>
                                                                            </h3>
                                                                            <p>{{ __('Total answered') .
                                                                                ':
                                                                                ' .
                                                                                $single_region['answered'] }}
                                                                            </p>
                                                                        </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-footer">
                                                            <p>{{ __('Targeted Number') .
                                                                ':
                                                                ' .
                                                                $single_region['respondents'] }}
                                                            </p>
                                                        </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    @else
                                    @endif
                                </div>
                            </div>
                        </div>
                        {{-- Super Director-wise result --}}
                        <div class="card card-primary">
                            <div class="card-header">
                                <h4 class="card-title">
                                    <a class="d-block w-100" data-toggle="collapse" href="#collapseFive">
                                        {{ 'Super Director-wise Results' }}
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseFive" class="collapse" data-parent="#accordion">
                                <div class="card-body">
                                    @if (count($super_dir_stat) > 0)
                                    <div class="row">
                                        @foreach ($super_dir_stat as $single_region)
                                        <div class="col-md-3">
                                            <div @class([ 'card card-outline' , 'card-success'=>
                                                $single_region['percentage'] >= 70,
                                                'card-warning' =>
                                                $single_region['percentage'] > 40 && $single_region['percentage'] <
                                                    70, 'card-danger'=> $single_region['percentage'] <= 40, ])>
                                                        <div class="card-header">
                                                            <h3 class="card-title">{{ $single_region['entity_name'] }}
                                                            </h3>
                                                        </div>
                                                        <div class="card-body">
                                                            <div @class([ 'small-box' , ' bg-success'=>
                                                                $single_region['percentage'] >= 70,
                                                                'bg-warning' =>
                                                                $single_region['percentage'] > 40 &&
                                                                $single_region['percentage'] < 70, 'bg-danger'=>
                                                                    $single_region['percentage'] <= 40, ])>
                                                                        <div class="inner text-center">
                                                                            <h3>{{
                                                                                number_format($single_region['percentage'],
                                                                                2) }}<sup
                                                                                    style="font-size: 20px">%</sup>
                                                                            </h3>
                                                                            <p>{{ __('Total answered') .
                                                                                ':
                                                                                ' .
                                                                                $single_region['answered'] }}
                                                                            </p>
                                                                        </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-footer">
                                                            <p>{{ __('Targeted Number') .
                                                                ':
                                                                ' .
                                                                $single_region['respondents'] }}
                                                            </p>
                                                        </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    @else
                                    {{ __('There is Only One Super Director') }}
                                    @endif
                                </div>
                            </div>
                        </div>
                        {{-- Director-wise result --}}
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h4 class="card-title">
                                    <a class="d-block w-100" data-toggle="collapse" href="#collapseSix">
                                        {{ 'Director-wise Results' }}
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseSix" class="collapse" data-parent="#accordion">
                                <div class="card-body">
                                    @if (count($dir_stat) > 0)
                                    <div class="row">
                                        @foreach ($dir_stat as $single_region)
                                        <div class="col-md-3">
                                            <div @class([ 'card card-outline' , 'card-success'=>
                                                $single_region['percentage'] >= 70,
                                                'card-warning' =>
                                                $single_region['percentage'] > 40 && $single_region['percentage'] <
                                                    70, 'card-danger'=> $single_region['percentage'] <= 40, ])>
                                                        <div class="card-header">
                                                            <h3 class="card-title">{{ $single_region['entity_name'] }}
                                                            </h3>
                                                        </div>
                                                        <div class="card-body">
                                                            <div @class([ 'small-box' , ' bg-success'=>
                                                                $single_region['percentage'] >= 70,
                                                                'bg-warning' =>
                                                                $single_region['percentage'] > 40 &&
                                                                $single_region['percentage'] < 70, 'bg-danger'=>
                                                                    $single_region['percentage'] <= 40, ])>
                                                                        <div class="inner text-center">
                                                                            <h3>{{
                                                                                number_format($single_region['percentage'],
                                                                                2) }}<sup
                                                                                    style="font-size: 20px">%</sup>
                                                                            </h3>
                                                                            <p>{{ __('Total answered') .
                                                                                ':
                                                                                ' .
                                                                                $single_region['answered'] }}
                                                                            </p>
                                                                        </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-footer">
                                                            <p>{{ __('Targeted Number') .
                                                                ':
                                                                ' .
                                                                $single_region['respondents'] }}
                                                            </p>
                                                        </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    @else
                                    {{ __('There is Only One Director') }}
                                    @endif
                                </div>
                            </div>
                        </div>
                        {{-- Division-wise result --}}
                        <div class="card card-primary">
                            <div class="card-header">
                                <h4 class="card-title">
                                    <a class="d-block w-100" data-toggle="collapse" href="#collapseSeven">
                                        {{ 'Division-wise Results' }}
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseSeven" class="collapse" data-parent="#accordion">
                                <div class="card-body">
                                    @if (count($div_stat) > 0)
                                    <div class="row">
                                        @foreach ($div_stat as $single_region)
                                        <div class="col-md-3">
                                            <div @class([ 'card card-outline' , 'card-success'=>
                                                $single_region['percentage'] >= 70,
                                                'card-warning' =>
                                                $single_region['percentage'] > 40 && $single_region['percentage'] <
                                                    70, 'card-danger'=> $single_region['percentage'] <= 40, ])>
                                                        <div class="card-header">
                                                            <h3 class="card-title">{{ $single_region['entity_name'] }}
                                                            </h3>
                                                        </div>
                                                        <div class="card-body">
                                                            <div @class([ 'small-box' , ' bg-success'=>
                                                                $single_region['percentage'] >= 70,
                                                                'bg-warning' =>
                                                                $single_region['percentage'] > 40 &&
                                                                $single_region['percentage'] < 70, 'bg-danger'=>
                                                                    $single_region['percentage'] <= 40, ])>
                                                                        <div class="inner text-center">
                                                                            <h3>{{
                                                                                number_format($single_region['percentage'],
                                                                                2) }}<sup
                                                                                    style="font-size: 20px">%</sup>
                                                                            </h3>
                                                                            <p>{{ __('Total answered') .
                                                                                ':
                                                                                ' .
                                                                                $single_region['answered'] }}
                                                                            </p>
                                                                        </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-footer">
                                                            <p>{{ __('Targeted Number') .
                                                                ':
                                                                ' .
                                                                $single_region['respondents'] }}
                                                            </p>
                                                        </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    @else
                                    {{ __('There is Only One Division') }}
                                    @endif
                                </div>
                            </div>
                        </div>
                        {{-- Department-wise result --}}
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h4 class="card-title">
                                    <a class="d-block w-100" data-toggle="collapse" href="#collapseEight">
                                        {{ 'Department-wise Results' }}
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseEight" class="collapse" data-parent="#accordion">
                                <div class="card-body">
                                    @if (count($deps_stat) > 0)
                                    <div class="row">
                                        @foreach ($deps_stat as $single_region)
                                        <div class="col-md-3">
                                            <div @class([ 'card card-outline' , 'card-success'=>
                                                $single_region['percentage'] >= 70,
                                                'card-warning' =>
                                                $single_region['percentage'] > 40 && $single_region['percentage'] <
                                                    70, 'card-danger'=> $single_region['percentage'] <= 40, ])>
                                                        <div class="card-header">
                                                            <h3 class="card-title">{{ $single_region['entity_name'] }}
                                                            </h3>
                                                        </div>
                                                        <div class="card-body">
                                                            <div @class([ 'small-box' , ' bg-success'=>
                                                                $single_region['percentage'] >= 70,
                                                                'bg-warning' =>
                                                                $single_region['percentage'] > 40 &&
                                                                $single_region['percentage'] < 70, 'bg-danger'=>
                                                                    $single_region['percentage'] <= 40, ])>
                                                                        <div class="inner text-center">
                                                                            <h3>{{
                                                                                number_format($single_region['percentage'],
                                                                                2) }}<sup
                                                                                    style="font-size: 20px">%</sup>
                                                                            </h3>
                                                                            <p>{{ __('Total answered') .
                                                                                ':
                                                                                ' .
                                                                                $single_region['answered'] }}
                                                                            </p>
                                                                        </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-footer">
                                                            <p>{{ __('Targeted Number') .
                                                                ':
                                                                ' .
                                                                $single_region['respondents'] }}
                                                            </p>
                                                        </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    @else
                                    {{ __('There is Only One Department') }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection
