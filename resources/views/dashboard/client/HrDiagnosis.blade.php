{{-- extends --}}
@extends('dashboard.layouts.main')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/CircularProgress.css') }}">
@endpush
{{-- content --}}
@section('content')
{{-- container --}}
<div class="content-wrapper">
<div class="container pt-5 mt-5">
    <div class="">
        <div class="col-12" id="finalResult">
            @include('dashboard.client.hrdiagnosisResults.legand')
            @include('dashboard.client.hrdiagnosisResults.Function')
            @include('dashboard.client.hrdiagnosisResults.key')
            @include('dashboard.client.hrdiagnosisResults.Laverages')
            @include('dashboard.client.hrdiagnosisResults.HRaverages')
            @include('dashboard.client.hrdiagnosisResults.Empaverages')
            @include('dashboard.client.hrdiagnosisResults.heatmap')
            @include('dashboard.client.hrdiagnosisResults.Linear')
            @include('dashboard.client.hrdiagnosisResults.Consolidated')
            @if ( count($heatmap) > 0)
            @include('dashboard.client.hrdiagnosisResults.heatmapEntities')
            @endif
            <div class="card mt-4" style="letter-spacing: 0.065rem;">
                <div class="card-header">
                    <h3 class="card-title">{{ __('Downloads') }}</h3>
                </div>
                <div class="card-body text-capitalize">
                    <div class="row text-start">
                        <div class="col-4 p-3 ">

                            <button id="DownloadAll" class="btn btn-success mt-3" style="border-radius: 10px;
    -webkit-box-shadow: 5px 5px 20px 5px #ababab;
    box-shadow: 5px 5px 20px 5px #ababab;">
                                {{ __('Download All Graph') }}
                            </button>
                        </div>
                        <div class="col-4 p-3 ">

                            <a href="{{ route('clients.DownloadSurveyResults',[$id,4,$type]) }}"
                                class="btn btn-success mt-3" style="border-radius: 10px;
    -webkit-box-shadow: 5px 5px 20px 5px #ababab;
    box-shadow: 5px 5px 20px 5px #ababab;">{{ __('Download Survey Responses') }}</a>
                        </div>
                        <div class="col-4 p-3 ">

                            <a href="{{ route('clients.DownloadPriorities',[$id,$type]) }}"
                                class="btn btn-success mt-3" style="border-radius: 10px;
    -webkit-box-shadow: 5px 5px 20px 5px #ababab;
    box-shadow: 5px 5px 20px 5px #ababab;">{{ __('Download Priorities Answers') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
@section('scripts')
{{-- <script src="{{ asset('assets/js/libs/jszip.min.js') }}"></script>
<script src="{{ asset('assets/js/dist/pptxgen.min.js') }}"></script> --}}
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js">
</script>

<script>
  Labels = @json($function_Lables);
    Leaders = @json($leaders_perform_onlyz);
    hr = @json($hr_perform_onlyz);
    //===============================
    //create new array with labels, Leaders, and hr
    //===============================

    google.charts.load('current', {'packages':['line']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var my_data=[];
        var functions_labels=[];
    for (var i = 0; i < Labels.length; i++) {
        //get id from labels
        var fid = Labels[i]['id'];
        //find id in Leaders
        var leader = Leaders.find(item => item.id === fid);;
        //find id in hr
        var hr_ = hr.find(item => item.id === fid);
        //create an array with labels, Leaders, and hr
        var item=[];
        item.push(Labels[i]['title']);
        item.push((Number( leader.performance)/100));
        item.push((Number( hr_.performance)/100));
        my_data.push(item);
        functions_labels.push(Labels[i]['title']);
    }
      var data = new google.visualization.DataTable();
      data.addColumn('string',  "Functions");
      data.addColumn('number', 'Leaders');
      data.addColumn('number', 'HR Team');

      data.addRows([
        my_data[0],
        my_data[1],
        my_data[2],
        my_data[3],
        my_data[4],
        my_data[5],
        my_data[6],
        my_data[7],
      ]);

      var options = {
        chart: {
          title: 'Leadership view VS HR team view',
        },
        width: 900,
        height: 500,
        vAxis: {
            format:'percent'
         },
         hAxis: {
            title: 'Function',  // Title for the x-axis
            slantedText: true,  // Enable slanted text
            slantedTextAngle: 90, // Set angle for slanted text
            textStyle: {
                fontSize: 12,  // Customize font size
            },
            ticks: functions_labels
        },
      };

      var chart = new google.charts.Line(document.getElementById('linechart_material'));

      chart.draw(data, google.charts.Line.convertOptions(options));
    }
    //===============================
    $("#DownloadAll").click(function() {
        window.setTimeout(function() {
            // do whatever you want to do
            downloadResult('Function', 'Function')
        }, 3000);
        window.setTimeout(function() {
            // do whatever you want to do
            downloadResult('key', 'Dashboard')
        }, 3000);
        window.setTimeout(function() {
            // do whatever you want to do
            downloadResult('Laverages', 'Leadership_View_Average')
        }, 3000);
        window.setTimeout(function() {
            // do whatever you want to do
            downloadResult('HRaverages', 'HR_View_Average')
        }, 3000);
        window.setTimeout(function() {
            // do whatever you want to do
            downloadResult('Empaverages', 'Employee_View_Average')
        }, 3000);
        window.setTimeout(function() {
            // do whatever you want to do
            downloadResult('heatmap', 'heatmap')
        }, 3000);
        window.setTimeout(function() {
            // do whatever you want to do
            downloadResult('Linear', 'Linear')
        }, 3000);
        window.setTimeout(function() {
            // do whatever you want to do
            downloadResult('Consolidated', 'Consolidated')
        }, 3000);
    });

    // $("#heatmapDownload").click(function() {

    //     html2canvas(document.getElementById("heatmap")).then(function(canvas) {
    //         downloadImage(canvas.toDataURL(), "heatmap.png");
    //     });


    // });
    // $("#FunctionDownload").click(function() {

    //     html2canvas(document.getElementById("Function")).then(function(canvas) {
    //         downloadImage(canvas.toDataURL(), "Function.png");
    //     });


    // });
    // $("#keyDownload").click(function() {

    //     html2canvas(document.getElementById("key")).then(function(canvas) {
    //         downloadImage(canvas.toDataURL(), "key.png");
    //     });
    // });
    function downloadResult(Resultcard, filename = 'untitled') {
        console.log(Resultcard);
        html2canvas(document.getElementById(Resultcard)).then(function(canvas) {
            downloadImage(canvas.toDataURL(), filename + ".png");
        });
    }

    function downloadImage(uri, filename) {
        var link = document.createElement('a');
        if (typeof link.download !== 'string') {
            window.open(uri);
        } else {
            link.href = uri;
            link.download = filename;
            accountForFirefox(clickLink, link);
        }
    }

    function clickLink(link) {
        link.click();
    }

    function accountForFirefox(click) {
        var link = arguments[1];
        document.body.appendChild(link);
        click(link);
        document.body.removeChild(link);
    }

</script>
@endsection
