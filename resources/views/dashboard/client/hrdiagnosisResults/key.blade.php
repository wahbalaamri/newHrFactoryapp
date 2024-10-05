<div id="key" class="card mt-4" style="letter-spacing: 0.065rem;">
    <div class="card-header">
        <h3 class="card-title">{{ __('Dashboard') }}</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-3 m-1 rounded text-center h3 p-3"
                style="background-color: #DCE6F2 ; color:#376092 !important;">
                {{ __('Overall Performance') }}
                <div class="mt-5">
                    <div class="circle-wrap">
                        <div class="circle">
                            <div class="mask half">
                                <div class="fill-{{ $overallResult }}"></div>
                            </div>
                            <div class="mask full-{{ $overallResult }}">
                                <div class="fill-{{ $overallResult }}"></div>
                            </div>
                            <div class="{{ app()->getLocale() == 'ar' ? 'inside-circle-rtl' : 'inside-circle' }}">
                                {{ $overallResult }}%<p>{{ __('Performance score') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="pt-3">
                        {{ __('Overall performance of HR functionality') }}
                    </div>
                </div>
            </div>
            <div class="col-4 m-1 rounded text-center h3 p-3"
                style="background-color: #DCE6F2 ; color:#376092 !important;">
                {{ __('Key improvement areas') }}
                @php $hasWPoints = false;
                usort($asc_perform, function ($a, $b) {
                return $a['performance'] <=> $b['performance'];
                    }); @endphp
                    @foreach (collect($asc_perform)->where('performance', '<', 80)->take(4) as $asc_perform_)
                        <div class="mt-5 text-start">
                            <span class="h5"> {{ $asc_perform_['function'] }}</span>
                            <div class="progress" style="height: 31px">
                                <div class="progress-bar
                    @if ($asc_perform_['performance'] <= 50) bg-danger @elseif($asc_perform_['performance'] > 50 && $asc_perform_['performance'] < 80) bg-warning @else bg-success @endif"
                                    role="progressbar"
                                    style="width: {{ $asc_perform_['performance'] }}%; font-size: 1rem;min-width: 2em;"
                                    aria-valuenow="{{ $asc_perform_['performance'] }}" aria-valuemin="2"
                                    aria-valuemax="100">{{ number_format($asc_perform_['performance']) }}%
                                </div>
                            </div>
                            @php $hasWPoints = true; @endphp

                        </div>
                        @endforeach
                        @if (!$hasWPoints)
                        <span class="h5" style="font-size: 2rem"> {{ __('None') }}</span>
                        @endif
            </div>
            <div class="col-4 m-1 rounded text-center h3 p-3"
                style="background-color: #DCE6F2 ; color:#376092 !important;">{{ __('Strength Areas') }}
                @php $strengthcounter = 0;
                $hasWPoints = false;
                usort($asc_perform, function ($a, $b) {
                return $b['performance'] <=> $a['performance'];
                    }); @endphp
                    @foreach (collect($asc_perform)->where('performance', '>', 80)->take(4) as $asc_perform_)
                    <div class="mt-5 text-start">
                        @php $strengthcounter++; @endphp
                        <span class="h5"> {{ $asc_perform_['function'] }}</span>
                        <div class="progress" style="height: 31px">
                            <div class="progress-bar @if ($asc_perform_['performance'] <= 50) bg-danger @elseif($asc_perform_['performance'] > 50 && $asc_perform_['performance'] < 80) bg-warning @else bg-success @endif"
                                role="progressbar"
                                style="width: {{ $asc_perform_['performance'] }}%; font-size: 1rem;min-width: 2em;"
                                aria-valuenow="{{ $asc_perform_['performance'] }}" aria-valuemin="0"
                                aria-valuemax="100">{{ number_format($asc_perform_['performance']) }}%
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @if ($strengthcounter == 0)
                    <h5 class="h5 mt-5 pt-5" style="font-size: 2rem"> {{ __('None') }}</h5>
                    @endif
            </div>
        </div>
    </div>
    <div class="card-footer">
        <span class="legend-result"><b>{{ __('Legend') }}:</b></span> <span class="legend-levels"><b>
                {{ __('Low:') }}</b></span>
        <=50% – <span class="legend-levels"><b>{{ __('Medium:') }}</b></span> > {{ __('50% to 80%') }} –
            <span class="legend-levels"><b>{{ __('High:') }}</b></span> >80%

    </div>
</div>
<button id="keyDownload" onclick="downloadResult('key','Dashboard')" class="btn btn-success mt-1">{{
    __('Download
    key') }}</button>
