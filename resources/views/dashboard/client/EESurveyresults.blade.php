{{-- extends --}}
@extends('dashboard.layouts.main')
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/CircularProgress.css') }}">
@endpush
{{-- content --}}
@section('content')
    {{-- container --}}
    <div class="content-wrapper">
        <div class="container-fluid pt-5 mt-5">
            <div class="row">
                <div class="col-12" id="finalResult">
                    <div class="card">
                        {{-- header --}}
                        <div class="card-header">
                            <div class="d-flex text-start">
                                <h3 class="card-title">Results</h3>
                            </div>
                        </div>
                        {{-- body --}}
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 col-sm-6">
                                    <a href="{{ route('clients.SurveyResults', [$client_id, $Service_type, $survey_id, 'all']) }}"
                                        class="btn btn-sm btn-success">By Org chart</a>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <a href="{{ route('clients.SurveyResults', [$client_id, $Service_type, $survey_id, 'gender']) }}"
                                        class="btn btn-sm btn-success">By gender</a>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <a href="{{ route('clients.SurveyResults', [$client_id, $Service_type, $survey_id, 'age']) }}"
                                        class="btn btn-sm btn-success">By age</a>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <a href="{{ route('clients.SurveyResults', [$client_id, $Service_type, $survey_id, 'service']) }}"
                                        class="btn btn-sm btn-success">By Years of Service</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12" id="finalResult">
                        <div class="card result-card" data-title="Dashboard">
                            {{-- header --}}
                            <div class="card-header">
                                <div class="d-flex text-start">
                                    <h3 class="card-title text-black">
                                        {{ $entity }}

                                    </h3>
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
                                                            <h3 class="caption">{{ $outcomes[0]['outcome_index'] }}%</h3>
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
                                                                    <span class="caption h6">{{ __('Engaged') }}</span>
                                                                </div>
                                                                <div class="col-sm-4 col-xs-12 progress-container">
                                                                    <div class="custom-progress mb-3">
                                                                        <div class="custom-progress-bar bg-warning @if ($outcomes[0]['Nuetral_score'] <= 0) text-danger @endif"
                                                                            style="height:{{ $outcomes[0]['Nuetral_score'] }}%; min-height: 15% !important;">
                                                                            <span>{{ $outcomes[0]['Nuetral_score'] }}%</span>
                                                                        </div>
                                                                    </div>
                                                                    <span class="caption h6">{{ __('Nuetral') }}</span>
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
                                                            <h3 class="caption">{{ $ENPS_data_array['ENPS_index'] }}%</h3>
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
                                                                    <span class="caption h6">{{ __('Promotors') }}</span>
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

                                </div>
                            </div>
                        </div>
                        <div class="card bg-light p-3 mb-3 rounded w-100 shadow result-card" data-title="Drivers">
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
                                <div class="row d-flex justify-content-center align-items-center text-center">
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
                        {{-- end of card --}}
                        {{-- card for Top and Bottom Scores-Organizational Wide --}}
                        <div id="top_and_bottom" class="card shadow p-3 mb-5 bg-white rounded result-card"
                            data-title="Top and Bottom Scores">
                            {{-- header --}}
                            <div class="card-header d-flex align-items-center">
                                <h2 class="h4 text-orange">{{ __('Top and Bottom Scores - ') }}
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
                        @if (count($heat_map) > 0)
                            <div id="heat_map" class="card shadow p-3 mb-5 bg-white rounded result-card"
                                data-title="Heat Map">
                                {{-- header --}}
                                <div class="card-header d-flex align-items-center">
                                    <h2 class="h4 text-orange">{{ __('Heat Map') }}
                                    </h2>
                                </div>
                                {{-- body --}}

                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>{{ __('Component Name') }}</th>
                                                    <th>{{ __('Hand Score') }}</th>
                                                    <th>{{ __('Head Score') }}</th>
                                                    <th>{{ __('Heart Score') }}</th>
                                                    <th>{{ __('Outcome Index') }}</th>
                                                    <th>{{ __('ENP Score') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($heat_map as $component)
                                                    @php
                                                        $vtype = $component['vtype'];
                                                        $entity_id = $component['entity_id'];
                                                    @endphp
                                                    <tr class="text-center" style="cursor: pointer;"
                                                        onclick="window.open('{{ route('clients.SurveyResults', [$client_id, $Service_type, $survey_id, $vtype, $entity_id]) }}')">
                                                        <td>{{ $component['entity_name'] }}</td>
                                                        <td @class([
                                                            'bg-success' => number_format($component['hand_favorable_score'], 2) >= 75,
                                                            'bg-warning' =>
                                                                number_format($component['hand_favorable_score'], 2) >= 40 &&
                                                                number_format($component['hand_favorable_score'], 2) < 75,
                                                            'bg-danger' => number_format($component['hand_favorable_score'], 2) < 40,
                                                        ])>
                                                            {{ number_format($component['hand_favorable_score'], 2) }}
                                                        </td>
                                                        <td @class([
                                                            'bg-success' => number_format($component['head_favorable_score'], 2) >= 75,
                                                            'bg-warning' =>
                                                                number_format($component['head_favorable_score'], 2) >= 40 &&
                                                                number_format($component['head_favorable_score'], 2) < 75,
                                                            'bg-danger' => number_format($component['head_favorable_score'], 2) < 40,
                                                        ])>
                                                            {{ number_format($component['head_favorable_score'], 2) }}
                                                        </td>
                                                        <td @class([
                                                            'bg-success' => number_format($component['heart_favorable_score'], 2) >= 75,
                                                            'bg-warning' =>
                                                                number_format($component['heart_favorable_score'], 2) >= 40 &&
                                                                number_format($component['heart_favorable_score'], 2) < 75,
                                                            'bg-danger' => number_format($component['heart_favorable_score'], 2) < 40,
                                                        ])>
                                                            {{ number_format($component['heart_favorable_score'], 2) }}
                                                        </td>
                                                        <td @class([
                                                            'bg-success' =>
                                                                number_format($component['outcome_favorable_score'], 2) >= 75,
                                                            'bg-warning' =>
                                                                number_format($component['outcome_favorable_score'], 2) >= 40 &&
                                                                number_format($component['outcome_favorable_score'], 2) < 75,
                                                            'bg-danger' => number_format($component['outcome_favorable_score'], 2) < 40,
                                                        ])>
                                                            {{ number_format($component['outcome_favorable_score'], 2) }}
                                                        </td>
                                                        <td @class([
                                                            'bg-success' => number_format($component['enps_favorable'], 2) > 0,
                                                            'bg-warning' => number_format($component['enps_favorable'], 2) == 0,
                                                            'bg-danger' => number_format($component['enps_favorable'], 2) < 0,
                                                        ])>
                                                            {{ number_format($component['enps_favorable'], 2) }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="card mt-3">
                            {{-- header --}}
                            <div class="card-header">
                                <div class="d-flex text-start">
                                    <h3 class="card-title text-black">{{ __('Downloads') }}</h3>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row text-start">
                                    <div class="col-4 p-3 ">

                                        <a href="{{ route('clients.DownloadSurveyResults', [$id, 'all']) }}"
                                            class="btn btn-success mt-3"
                                            style="border-radius: 10px;
            -webkit-box-shadow: 5px 5px 20px 5px #ababab;
            box-shadow: 5px 5px 20px 5px #ababab;">{{ __('Download Survey Answers') }}</a>
                                    </div>
                                    <div class="col-4 p-3 ">

                                        <a href="javascript:void(0)" id="downloadButton"
                                            class="btn btn-success mt-3">{{ __('Download Survey Result as Images') }}</a>
                                    </div>
                                    <div class="col-4 p-3 ">
                                        <a href="javascript:void(0)" id="printButton" class="btn btn-success mt-3">
                                            {{ __('Download Survey Result PDF') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    {{-- scripts --}}
    @section('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

        <script>
            //on printButton click
            $(document).on('click', '#printButton', function() {
                const {
                    jsPDF
                } = window.jspdf;
                const pdf = new jsPDF();

                // Use document.querySelectorAll to get all elements with the class "result-card" this divs not conatining canvas
                const divs = document.querySelectorAll(".result-card");
                //remove shadow class from divs
                divs.forEach(div => {
                    div.classList.remove('shadow');
                })
                let promises = Array.from(divs).map(div => {
                    return html2canvas(div, {
                        allowTaint: true,
                        useCORS: true
                    });
                });
                console.log(promises);

                Promise.all(promises).then(canvas => {
                    canvas.forEach((canvas, i) => {
                        //remove shadow from canvas
                        canvas.getContext("2d").shadowBlur = 0;
                        const imgData = canvas.toDataURL("image/png");
                        const imgProperties = pdf.getImageProperties(imgData);
                        const pdfWidth = pdf.internal.pageSize.getWidth();
                        const pdfHeight = (imgProperties.height * pdfWidth) / imgProperties.width;
                        pdf.addImage(imgData, "PNG", 0, 0, pdfWidth, pdfHeight);
                        if (i < promises.length - 1) {
                            pdf.addPage();
                        }
                    });
                    pdf.save("result.pdf");
                });
                //add shadow back to divs
                divs.forEach(div => {
                    div.classList.add('shadow');
                })
            });
            // on downloadButton click
            $(document).on('click', '#downloadButton', function() {
                //get all card with result-card class
                var resultCards = $('.result-card');
                //loop through each card
                resultCards.each(function() {
                    //get each card
                    var card = $(this);
                    //get card data-title
                    var title = card.data('title');
                    //create canvas
                    html2canvas(card, {
                        onrendered: function(canvas) {
                            var canvasImg = canvas.toDataURL("image/jpg");
                            var downloadLink = document.createElement("a");
                            downloadLink.download = title + ".jpg";
                            downloadLink.href = canvasImg;
                            downloadLink.click();
                        },
                        useCORS: true
                    })
                })
            });
        </script>
    @endsection
