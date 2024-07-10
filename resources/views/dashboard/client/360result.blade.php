{{-- extends --}}
@extends('layouts.main')
@push('styles')
    <link href="{{ asset('assets/css/CircularProgress.css') }}" rel="stylesheet">
    <style>
        .col-title {
            background-color: #DCE6F2;
            background-color: #DCE6F2;
            min-width: 19px;
            max-width: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #376092;
            font-size: 1.5rem;
            font-weight: bold
        }

        /* col-title text */
        .col-title p {
            -webkit-transform: rotate(90deg);
        }
    </style>
@endpush
{{-- content --}}
@section('content')
    {{-- container --}}
    <div class="container-fluid mt-5 pt-5">
        <div class="row">
            <div class="col-10" id="finalResult">
                {{-- card --}}
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h4>{{ $email->name }}'s {{ __('360 Degree Review Report') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row candidate-r" style="page-break-before:always">
                            <div class="col-sm-12">
                                <div class="car">
                                    <div class="card-body">
                                        {{-- table candidate info --}}
                                        <table class="table-bordered table">
                                            <tr>
                                                <td>{{ __('Name') }}</td>
                                                <th colspan="{{ $Others > 0 ? 6 : 5 }}">{{ $email->name }}</th>
                                            </tr>
                                            <tr>
                                                <td>{{ __('Position') }}</td>
                                                <th colspan="{{ $Others > 0 ? 6 : 5 }}">{{ $email->position }}</th>
                                            </tr>
                                            <tr>
                                                <td>{{ __('Survey Data') }}</td>
                                                <th colspan="{{ $Others > 0 ? 6 : 5 }}">
                                                    {{ $survey->created_at->format('d M Y') }}</th>
                                            </tr>
                                            <tr class="bg-secondary text-white">
                                                <td class="text-center" colspan="{{ $Others > 0 ? 7 : 6 }}">{{ __('Raters') }}
                                                </td>
                                            </tr>
                                            <tr class="bg-secondary text-white">
                                                <td></td>
                                                <td>{{ __('Self') }}</td>
                                                <td>{{ __('Direct Manager') }}</td>
                                                <td>{{ __('Peers') }}</td>
                                                <td>{{ __('Direct Reports') }}</td>
                                                @if ($Others > 0)
                                                    <td>{{ __('Others') }}</td>
                                                @endif
                                                <td>{{ __('Overall') }}</td>
                                            </tr>
                                            <tr class="bg-secondary text-white">
                                                <td>{{ __('Response rate') }}</td>
                                                <td>
                                                    <div class="card-body">
                                                        <div class="progress">
                                                            <div class="progress-bar @if (number_format(($Self>0?($Self_answers / $Self):0) * 100) > 80) bg-success

                                                        @elseif (number_format(($Self>0?($Self_answers / $Self):0) * 100) > 50)
                                                            bg-warning
                                                        @else
                                                            bg-danger @endif"
                                                                role="progressbar"
                                                                aria-valuenow="{{ number_format(($Self>0?($Self_answers / $Self):0) * 100) }}"
                                                                aria-valuemin="0" aria-valuemax="100"
                                                                style="width: {{ number_format(($Self>0?($Self_answers / $Self):0) * 100) }}%; min-width: 20px;">
                                                                {{ number_format(($Self>0?($Self_answers / $Self):0) * 100) }}%</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="card-body">
                                                        <div class="progress">
                                                            <div class="progress-bar @if (number_format($DM>0?($DM_answers / $DM):0 * 100) > 80) bg-success

                                                        @elseif (number_format($DM>0?($DM_answers / $DM):0 * 100) > 50)
                                                            bg-warning
                                                        @else
                                                            bg-danger @endif"
                                                                role="progressbar"
                                                                aria-valuenow="{{ number_format($DM>0?($DM_answers / $DM):0 * 100) }}"
                                                                aria-valuemin="0" aria-valuemax="100"
                                                                style="width: {{ number_format($DM>0?($DM_answers / $DM):0 * 100) }}%; min-width: 20px;">
                                                                {{ number_format($DM>0?($DM_answers / $DM):0 * 100) }}%</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="card-body">
                                                        <div class="progress">
                                                            <div class="progress-bar @if (number_format($Peer>0?($Peer_answers / $Peer):0 * 100) > 80) bg-success

                                                        @elseif (number_format($Peer>0?($Peer_answers / $Peer):0 * 100) > 50)
                                                            bg-warning
                                                        @else
                                                            bg-danger @endif"
                                                                role="progressbar"
                                                                aria-valuenow="{{ number_format($Peer>0?($Peer_answers / $Peer):0 * 100) }}"
                                                                aria-valuemin="0" aria-valuemax="100"
                                                                style="width: {{ number_format($Peer>0?($Peer_answers / $Peer):0 * 100) }}%; min-width: 20px;">
                                                                {{ number_format($Peer>0?($Peer_answers / $Peer):0 * 100) }}%</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if ($DR > 0)
                                                        <div class="card-body">
                                                            <div class="progress">
                                                                <div class="progress-bar @if (number_format(($DR>0?($DR_answers / $DR):0) * 100) > 80) bg-success

                                                        @elseif (number_format(($DR>0?($DR_answers / $DR):0) * 100) > 50)
                                                            bg-warning
                                                        @else
                                                            bg-danger @endif"
                                                                    role="progressbar"
                                                                    aria-valuenow="{{ number_format(($DR>0?($DR_answers / $DR):0) * 100) }}"
                                                                    aria-valuemin="0" aria-valuemax="100"
                                                                    style="width: {{ number_format(($DR>0?($DR_answers / $DR):0) * 100) }}%; min-width: 20px;">
                                                                    {{ number_format(($DR>0?($DR_answers / $DR):0) * 100) }}%</div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        {{-- widget --}}
                                                        <h5 class="h5">{{ __('No Direct Reportings') }}</h5>
                                                    @endif
                                                </td>
                                                @if ($Others > 0)
                                                    <td>
                                                        <div class="card-body">
                                                            <div class="progress">
                                                                <div class="progress-bar @if (number_format($Others>0?($Others_answers / $Others):0 * 100) > 80) bg-success

                                                        @elseif (number_format($Others>0?($Others_answers / $Others):0 * 100) > 50)
                                                            bg-warning
                                                        @else
                                                            bg-danger @endif"
                                                                    role="progressbar"
                                                                    aria-valuenow="{{ number_format($Others>0?($Others_answers / $Others):0 * 100) }}"
                                                                    aria-valuemin="0" aria-valuemax="100"
                                                                    style="width: {{ number_format($Others>0?($Others_answers / $Others):0 * 100) }}%; min-width: 20px;">
                                                                    {{ number_format($Others>0?($Others_answers / $Others):0 * 100) }}%
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                @endif
                                                <td>
                                                    <div class="card-body">
                                                        <div class="progress">
                                                            <div class="progress-bar @if (number_format(
                                                                    (($Self_answers + $DM_answers + $DR_answers + $Peer_answers + $Others_answers) /
                                                                        ($Self + $DM + $DR + $Peer + $Others)) *
                                                                        100) > 80) bg-success

                                                        @elseif (number_format(
                                                                (($Self_answers + $DM_answers + $DR_answers + $Peer_answers + $Others_answers) /
                                                                    ($Self + $DM + $DR + $Peer + $Others)) *
                                                                    100) > 50)
                                                            bg-warning
                                                        @else
                                                            bg-danger @endif"
                                                                role="progressbar"
                                                                aria-valuenow="{{ number_format((($Self_answers + $DM_answers + $DR_answers + $Peer_answers + $Others_answers) / ($Self + $DM + $DR + $Peer + $Others)) * 100) }}"
                                                                aria-valuemin="0" aria-valuemax="100"
                                                                style="width: {{ number_format((($Self_answers + $DM_answers + $DR_answers + $Peer_answers + $Others_answers) / ($Self + $DM + $DR + $Peer + $Others)) * 100) }}%; min-width: 20px;">
                                                                {{ number_format((($Self_answers + $DM_answers + $DR_answers + $Peer_answers + $Others_answers) / ($Self + $DM + $DR + $Peer + $Others)) * 100) }}%
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="bg-secondary text-white">
                                                <td>{{ __('Target') }}</td>
                                                <td>{{ $Self }}
                                                </td>
                                                <td>{{ $DM }}
                                                </td>
                                                <td>{{ $Peer }}
                                                </td>
                                                <td>
                                                    @if ($DR > 0)
                                                        {{ $DR }}
                                                    @else
                                                        {{-- widget --}}
                                                        <h5 class="h5">{{ __('No Direct Reportings') }}</h5>
                                                    @endif
                                                </td>

                                                @if ($Others > 0)
                                                    <td>{{ $Others }}
                                                    </td>
                                                @endif
                                                <td>{{ $Self + $DM + $DR + $Peer + $Others }}
                                                </td>
                                            </tr>
                                            <tr class="bg-secondary text-white">
                                                <td>{{ __('Answered') }}</td>
                                                <td>{{ $Self_answers }}
                                                </td>
                                                <td>{{ $DM_answers }}
                                                </td>
                                                <td>{{ $Peer_answers }}
                                                </td>
                                                <td>
                                                    @if ($DR > 0)
                                                        {{ $DR_answers }}
                                                    @else
                                                        {{-- widget --}}
                                                        <h5 class="h5">{{ __('No Direct Reportings') }}</h5>
                                                    @endif
                                                </td>

                                                @if ($Others > 0)
                                                    <td>{{ $Others_answers }}
                                                    </td>
                                                @endif
                                                <td>{{ $Self_answers + $DM_answers + $DR_answers + $Peer_answers + $Others_answers }}
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="car">
                                    <div class="card-body"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row candidate-r" style="page-break-before:always">
                            <div class="col-md-6 col-sm-12 text-start">
                                <div class="card">
                                    <div class="card-header bg-info text-white">
                                        <h4 class="h4">{{ __('Top 5 Behaviors to Focus on') }}</h4>
                                    </div>
                                    <div class="card-body">
                                        @php
                                            $hasLowest = 0;
                                        @endphp
                                        @foreach ($lowest_practices as $l_practice)
                                            @if ($l_practice['All'] <= 80)
                                                @php
                                                    $hasLowest++;
                                                @endphp
                                                <div class="row justify-content-center">
                                                    <div class="col-md-10 col-sm-12">
                                                        <div class="card mb-1 mt-1">
                                                            <div class="card-body">
                                                                <h5 class="h5">{{ $l_practice['name'] }}</h5>
                                                                <div class="progress">
                                                                    <div class="progress-bar @if ($l_practice['All'] > 80) bg-success

                                                        @elseif ($l_practice['All'] > 50)
                                                            bg-warning
                                                        @else
                                                            bg-danger @endif"
                                                                        role="progressbar"
                                                                        aria-valuenow="{{ $l_practice['All'] }}"
                                                                        aria-valuemin="0" aria-valuemax="100"
                                                                        style="width: {{ $l_practice['All'] }}%; min-width: 20px;">
                                                                        {{ number_format($l_practice['All'],2) }}%</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                        @if ($hasLowest == 0)
                                            <div class="row justify-content-center">
                                                <div class="col-md-10 col-sm-12">
                                                    <div class="card mb-1 mt-1">
                                                        <div class="card-body">
                                                            <h5 class="h5">{{ __('No Behaviors to Focus on') }}</h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5 col-sm-12">
                                <div class="card col-6 float-end">
                                    <div class="card-header bg-dark text-white">
                                        <h4 class="h4">{{ __('Legend') }}</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-2 mt-2">
                                            <div class="col-lg-4 col-md-12">
                                                0-50%
                                            </div>
                                            <div class="col-lg-8 col-md-12">
                                                <div class="card bg-danger rounded-4">
                                                    <div class="card-body text-white">Major Development Area</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-2 mt-2">
                                            <div class="col-lg-4 col-md-12">
                                                50-80%
                                            </div>
                                            <div class="col-lg-8 col-md-12">
                                                <div class="card bg-warning rounded-4">
                                                    <div class="card-body">Secondary Development Area</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-2 mt-2">
                                            <div class="col-lg-4 col-md-12">
                                                80-100%
                                            </div>
                                            <div class="col-lg-8 col-md-12">
                                                <div class="card bg-success rounded-4">
                                                    <div class="card-body text-white">Strength Area</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row candidate-r mb-2 mt-2" style="page-break-before:always">
                            {{-- table --}}
                            <div class="col-lg-9 col-md-12">
                                <div class="card">
                                    <div class="card-header bg-info text-white">
                                        <h4 class="h4">{{ __('Behaviours Scores') }}</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-1" style="max-width: 45px;"></div>
                                            <div class="col-11">
                                                <div class="row padding-left-10px">
                                                    @foreach ($functions as $function)
                                                        <div class="bg-info m-2 p-2 text-center text-white"
                                                            style="width:{{ 100 / count($functions) - 2.5 }}%; border-radius: 10px; -webkit-box-shadow: 0px 0px 5px 1px #ABABAB;box-shadow: 0px 0px 5px 1px #ABABAB; font-size: 1.1rem">
                                                            {{  $function->translated_title }}
                                                            <br>{{ number_format($all_fun->where('id', $function->id)->first()['score'],2) }}%
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-1 col-title" style="">
                                                <p>{{ __('Behaviours') }}</p>
                                            </div>
                                            <div class="col-11">
                                                <div class="row" style="width: 100%">
                                                    @foreach ($functions as $function)
                                                        <?php $firstofFirstLoop = $loop->first; ?>
                                                        <div class="col-1 justify-content-center m-2 p-2 pb-1 pt-1"
                                                            style="width: {{ 100 / count($functions) - 2.5 }}%; font-size: 0.96rem">
                                                            @foreach ($practices as $practice)
                                                                @if ($practice['function'] == $function->id)
                                                                    <div class="@if (!$loop->first) mt-1 p-2 m-2 @endif @if ($firstofFirstLoop) p-2 m-2 @else p-2 m-2 @endif @if ($practice['All'] <= 50) bg-danger text-white @elseif ($practice['All'] > 50 && $practice['All'] < 80) bg-warning text-black @else bg-success text-white @endif text-center"
                                                                        style=" width:100%; border-radius: 10px;">
                                                                        {{ $practice['name'] }} [{{ number_format($practice['All'],2 )}}%]
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
                            <div class="col-lg-3 col-md-12">
                                <div class="card col-12 float-end">
                                    <div class="card-header bg-dark text-white">
                                        <h4 class="h4">{{ __('Legend') }}</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-2 mt-2">
                                            <div class="col-lg-4 col-md-12">
                                                0-50%
                                            </div>
                                            <div class="col-lg-8 col-md-12">
                                                <div class="card bg-danger rounded-4">
                                                    <div class="card-body text-white">Major Development Area</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-2 mt-2">
                                            <div class="col-lg-4 col-md-12">
                                                50-80%
                                            </div>
                                            <div class="col-lg-8 col-md-12">
                                                <div class="card bg-warning rounded-4">
                                                    <div class="card-body">Secondary Development Area</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-2 mt-2">
                                            <div class="col-lg-4 col-md-12">
                                                80-100%
                                            </div>
                                            <div class="col-lg-8 col-md-12">
                                                <div class="card bg-success rounded-4">
                                                    <div class="card-body text-white">Strength Area</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- end of row --}}
                        <div class="row candidate-r mb-2 mt-2" style="page-break-before:always">
                            <div class="col-lg-4 col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="h4">{{ __('Overall Score') }}</h4>
                                        <span>{{ __('based on responses of all participants') }}</span>
                                    </div>
                                    <div class="card-body">
                                        <div class="m-5 p-4">
                                            <div class="circle-wrap">
                                                <div class="circle">
                                                    <div class="mask half">
                                                        <div class="fill-{{ number_format($overall) }}"></div>
                                                    </div>
                                                    <div class="mask full-{{ number_format($overall) }}">
                                                        <div class="fill-{{ number_format($overall) }}"></div>
                                                    </div>
                                                    <div
                                                        class="{{ app()->getLocale() == 'ar' ? 'inside-circle-rtl' : 'inside-circle' }}">
                                                        <p class="mt-5">
                                                            {{ number_format($overall) }}%
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-12">
                                <div class="card">
                                    <div class="card-header bg-info text-white">
                                        <h4 class="h4">{{ __('Top 5 Strengths') }}</h4>
                                    </div>
                                    <div class="card-body">
                                        <?php $hasStrengths = 0; ?>
                                        @foreach ($highest_practices as $h_practice)
                                            @if ($h_practice['All'] >= 80)
                                                <?php $hasStrengths++; ?>
                                                <div class="row">
                                                    <div class="col-md-10 col-sm-12">
                                                        <div class="card mb-1 mt-1">
                                                            <div class="card-body">
                                                                <h5 class="h5">{{ $h_practice['name'] }}</h5>
                                                                <div class="progress">
                                                                    <div class="progress-bar @if ($h_practice['All'] >= 80) bg-success

                                                        @elseif ($h_practice['All'] > 33)
                                                            bg-warning
                                                        @else
                                                            bg-danger @endif"
                                                                        role="progressbar"
                                                                        aria-valuenow="{{ $h_practice['All'] }}"
                                                                        aria-valuemin="0" aria-valuemax="100"
                                                                        style="width: {{ $h_practice['All'] }}%; min-width: 20px;">
                                                                        {{ $h_practice['All'] }}%</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                        @if ($hasStrengths == 0)
                                            <div class="row">
                                                <div class="col-md-10 col-sm-12">
                                                    <div class="card mb-1 mt-1">
                                                        <div class="card-body">
                                                            <h5 class="h5">{{ __('No Strengths') }}</h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-12">
                                <div class="card col-12 float-end">
                                    <div class="card-header bg-dark text-white">
                                        <h4 class="h4">{{ __('Legend') }}</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-2 mt-2">
                                            <div class="col-lg-4 col-md-12">
                                                0-50%
                                            </div>
                                            <div class="col-lg-8 col-md-12">
                                                <div class="card bg-danger rounded-4 text-white">
                                                    <div class="card-body text-white">Major Development Area</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-2 mt-2">
                                        <div class="col-lg-4 col-md-12">
                                            50-80%
                                        </div>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="card bg-warning rounded-4">
                                                <div class="card-body">Secondary Development Area</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-2 mt-2">
                                        <div class="col-lg-4 col-md-12">
                                            80-100%
                                        </div>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="card bg-success rounded-4 text-white">
                                                <div class="card-body text-white">Strength Area</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row candidate-r justify-content-center mb-2 mt-2" style="page-break-before:always">
                            <div class="col-lg-10 col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="h4">{{ __('Self VS Others') }}</h4>
                                        {{-- <span>{{ __('based on responses of all participants') }}</span> --}}
                                    </div>
                                    <div class="card-body">
                                        <div class="m-5 p-4">
                                            <div class="row">
                                                <div class="d-flex justify-content-center">
                                                    <div class="chart-container col-9">
                                                        <canvas id="myChart" width="400" height="400"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- ================end============ --}}
                            </div>
                        </div>
                    </div>

                </div>
                {{-- end of card body --}}
                {{-- card footer --}}
                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-12"><a class="btn btn-sm btn-success"
                                href="#{{-- {{ route('candidate.candidateResult_P', [$email->id, $survey->id]) }} --}}">{{ __('Download') }}</a>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12"><a class="btn btn-sm btn-success" id="printPdf"
                                href="javascript:void(0);">{{ __('Download') }}</a></div>
                        <div class="col-lg-3 col-md-6 col-sm-12"><a class="btn btn-sm btn-success"
                                href="#">{{ __('Download') }}</a></div>
                        <div class="col-lg-3 col-md-6 col-sm-12"><a class="btn btn-sm btn-success"
                                href="#">{{ __('Download') }}</a></div>
                    </div>
                    {{-- hidden row --}}
                    <div class="row" style="display: none;">
                        <div class="col-lg-3 col-md-6 col-sm-12"><a class="btn btn-sm btn-success" id="Exportpdf"
                                href="#" onclick="Exportpdf()">{{ __('Download') }}</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@section('scripts')
    {{-- html2pdf --}}
    {{-- html2pdf cdn --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
    {{-- html2canvas cdn --}}
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    {{-- html2pdf --}}
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        Labels = @json($functions_lbl);
        self = @json($Self_Functions);
        others = @json($Others_Functions);

        const ctx = document.getElementById('myChart');
        //get max of hr
        var max = 0;
        var max_others = others.reduce(function(prev, current) {
            return (prev > current) ? prev : current
        })
        //get max of leaders
        var max_self = self.reduce(function(prev, current) {
            return (prev > current) ? prev : current
        })
        max = max_others > max_self ? max_others : max_self;
        max = (100 - max) > 10 ? parseInt(max) + 5 : 100;
        Chart.defaults.font.size = 20;
        const myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: Labels,
                datasets: [{
                        label: "{{ __('Self Rating') }}",
                        data: self,
                        backgroundColor: [
                            'rgba(0, 74, 159, 1)' //,
                            // 'rgba(54, 162, 235, 0.2)',
                            // 'rgba(255, 206, 86, 0.2)',
                            // 'rgba(75, 192, 192, 0.2)',
                            // 'rgba(153, 102, 255, 0.2)',
                            // 'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(0, 74, 159, 1)' //,
                            // 'rgba(54, 162, 235, 1)',
                            // 'rgba(255, 206, 86, 1)',
                            // 'rgba(75, 192, 192, 1)',
                            // 'rgba(153, 102, 255, 1)',
                            // 'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    },
                    {
                        label: "{{ __('Others Rating') }}",
                        data: others,
                        backgroundColor: [
                            // 'rgba(255, 99, 132, 0.2)',
                            // 'rgba(54, 162, 235, 0.2)',
                            // 'rgba(255, 206, 86, 0.2)',
                            // 'rgba(75, 192, 192, 0.2)',
                            // 'rgba(153, 102, 255, 0.2)',
                            'rgba(0, 153, 204,1)'
                        ],
                        borderColor: [
                            // 'rgba(255, 99, 132, 1)',
                            // 'rgba(54, 162, 235, 1)',
                            // 'rgba(255, 206, 86, 1)',
                            // 'rgba(75, 192, 192, 1)',
                            // 'rgba(153, 102, 255, 1)',
                            'rgba(0, 159, 204, 1)'
                        ],
                        borderWidth: 1
                    },
                ]
            },
            options: {
                scales: {
                    y: {
                        suggestedMin: 0,
                        suggestedMax: max,
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Score',
                            font: {
                                size: 25
                            }
                        },

                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Behaviours',
                            font: {
                                size: 25
                            }
                        }
                    }
                }
            }
        });



        // {{-- html2pdf --}}
        function Exportpdf() {
            //get all elements with class candidate-r
            var elements = document.getElementsByClassName('candidate-r');
            //loop through each of them
            for (var i = 0; i < elements.length; i++) {
                //get the current element
                var element = elements[i];
                //get children of the current element
                var children = element.children;
                //loop through each of them
                for (var j = 0; j < children.length; j++) {
                    //get the current child
                    var child = children[j];
                    //check if the current child has the class col-md-6
                    child.classList.remove('col-md-6');
                }
            }
            var elements = document.getElementsByClassName('candidate-r');
            //convert each of them to pdf
            for (var i = 0; i < elements.length; i++) {

                html2pdf(elements[i], {
                    margin: 10,
                    filename: 'candidateResult.pdf',
                    image: {
                        type: 'jpeg',
                        quality: 0.98
                    },
                    html2canvas: {
                        scale: 1
                    },
                    jsPDF: {
                        unit: 'mm',
                        format: 'a4',
                        orientation: 'landscape'
                    }
                });

            }
        }
    </script>
    {{-- print --}}
    <script>
        // {{-- print --}}
        document.getElementById('printPdf').addEventListener('click', function() {
            //get all elements with class candidate-r
            var elements = document.getElementsByClassName('candidate-r');
            console.log("dddhjkh");
            //loop through each of them
            for (var i = 0; i < elements.length; i++) {
                //get the current element
                var element = elements[i];
                //get children of the current element
                var children = element.children;
                //loop through each of them
                for (var j = 0; j < children.length; j++) {
                    //get the current child
                    var child = children[j];
                    //check if the current child has the class col-md-6
                    child.classList.remove('col-md-6');
                }
            }
            var elements = document.getElementsByClassName('candidate-r');
            //convert each of them to pdf
            for (var i = 0; i < elements.length; i++) {
                // avoid blank page
                if (elements[i].offsetHeight > 0) {
                    html2pdf(elements[i], {
                        margin: 10,
                        filename: 'candidateResult.pdf',
                        image: {
                            type: 'jpeg',
                            quality: 0.98
                        },
                        html2canvas: {
                            scale: 1
                        },
                        jsPDF: {
                            unit: 'mm',
                            format: 'a4',
                            orientation: 'landscape'
                        }
                    });
                }


            }
            for (var i = 0; i < elements.length; i++) {
                //get the current element
                var element = elements[i];
                //get children of the current element
                var children = element.children;
                //loop through each of them
                for (var j = 0; j < children.length; j++) {
                    //get the current child
                    var child = children[j];
                    //check if the current child has the class col-md-6
                    child.classList.add('col-md-6');
                }
            }
        });
    </script>
@endsection
