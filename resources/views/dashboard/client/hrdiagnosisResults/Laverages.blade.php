<div id="Laverages" class="card mt-4" style="letter-spacing: 0.065rem;">
    <div class="card-header">
        <h3 class="card-title">{{ __('Performance by Functions - Leadership') }}
        </h3>
    </div>
    <div class="card-body" style="background-color: #DCE6F2 ; color:#376092 !important;">
        <div class="row text-center">
            <div class="m-1 rounded text-center h5 p-3" style="font-size: 1.7rem">
                {{ __('People management performance – Leadership view average scores by people
                functions') }}
            </div>
        </div>
        <div class="row row-function">
            @php
            //sort Descending sorted_leader_performences
            usort($sorted_leader_performences, function ($a, $b) {
            return $b['performance'] <=> $a['performance'];
                });
                @endphp
                @foreach ($sorted_leader_performences as $performence)
                <div class="col-md-3 col-sm-6 text-center function-lable">
                    {{ $performence['function'] }}
                </div>
                <div class="col-md-9 col-sm-6 text-start function-progress">
                    <div class="progress" style="height: 31px">
                        <div class="progress-bar @if ($performence['performance'] > 80 && $performence['performance'] <= 100) bg-success @elseif($performence['performance'] > 50 && $performence['performance'] <= 80) bg-warning @else bg-danger @endif"
                            role="progressbar"
                            style="width: {{ $performence['performance'] }}%; font-size: 1rem;min-width: 2em;"
                            aria-valuenow="{{ $performence['performance'] }}" aria-valuemin="0" aria-valuemax="100">
                            {{ number_format($performence['performance']) }}%
                        </div>
                    </div>
                </div>
                @endforeach
        </div>
    </div>
</div>
<button id="averagesDownload" onclick="downloadResult('Laverages','Leadership_View_Average')"
    class="btn btn-success mt-1">{{ __('Download') }}</button>
