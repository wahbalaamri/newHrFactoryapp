<div id="heatmap" class="card mt-4" style="letter-spacing: 0.065rem;">
    <div class="card-header">
        <h3 class="card-title ">{{ __('High level heat map') }}
        </h3>
    </div>
    <div class="card-body" style="background-color: #DCE6F2 ; color:#376092 !important;">
        <div class="row text-center">
            <div class="m-1 rounded text-center h5 p-3 text-danger" style="font-size: 1.7rem">
                {{ __('High level heat map – Leadership view Priorities vs Performance in key People
                                management functions') }}
            </div>
        </div>
        <div class="row">
            <div class="col-3 text-center heat-map heat-map-priority heat-map-priority-v">
                {{ __('Priority
                                by leaders') }}
            </div>
            <div class="col-9 heat-map"></div>

            @for ($i = 0; $i < 3; $i++)
                <div class="col-3 text-end heat-map heat-map-priority heat-map-priority-lable text-capitalize">
                    <span>
                        @switch($i)
                            @case(0)
                                {{ __('High') }}
                            @break

                            @case(1)
                                {{ __('Medium') }}
                            @break

                            @case(2)
                                {{ __('Low') }}
                            @break

                            @default
                        @endswitch
                    </span>
                </div>
                <div class="col-9 heat-map">
                    <div class="row">
                        @for ($j = 0; $j < 3; $j++) {{-- Start first --}}
                            @if (($i == 0 && $j == 0) || ($i == 0 && $j == 1) || ($i == 1 && $j == 0))
                                <div class="bg-danger heat-map-result">
                                    @if ($i == 0)
                                        @if ($j == 0)
                                            <ul>
                                                @foreach ($priorities as $pri)
                                                    @if ($pri['priority'] > 80 && $pri['priority'] <= 100)
                                                        @if ($pri['performance'] <= 50)
                                                            <li class="text-white">{{ $pri['function'] }}
                                                            </li>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </ul>
                                        @elseif ($j == 1)
                                            <ul>

                                                @foreach ($priorities as $pri)
                                                    @if ($pri['priority'] > 80 && $pri['priority'] <= 100)
                                                        @if ($pri['performance'] > 50 && $pri['performance'] <= 80)
                                                            <li class="text-white">{{ $pri['function'] }}
                                                            </li>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </ul>
                                        @else
                                            <ul>

                                                @foreach ($priorities as $pri)
                                                    ffff
                                                    @if ($pri['priority'] > 50 && $pri['priority'] < 80)
                                                        @if ($pri['performance'] <= 50)
                                                            <li class="text-white">{{ $pri['function'] }}
                                                            </li>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </ul>
                                        @endif
                                    @else
                                        @if ($j == 0)
                                            <ul>

                                                @foreach ($priorities as $pri)
                                                    @if ($pri['priority'] > 50 && $pri['priority'] < 80)
                                                        @if ($pri['performance'] <= 50)
                                                            <li class="text-white">{{ $pri['function'] }}
                                                            </li>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </ul>
                                        @endif
                                    @endif
                                </div>
                            @endif
                            {{-- End first --}}
                            {{-- Start second --}}
                            @if (($i == 1 && $j == 1) || ($i == 2 && $j == 1) || ($i == 2 && $j == 0))
                                <div class="bg-warning heat-map-result">
                                    @if ($i == 1)
                                        @if ($j == 1)
                                            <ul>

                                                @foreach ($priorities as $pri)
                                                    @if ($pri['priority'] > 50 && $pri['priority'] < 80)
                                                        @if ($pri['performance'] > 50 && $pri['performance'] <= 80)
                                                            <li class="text-black">{{ $pri['function'] }}
                                                            </li>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </ul>
                                        @endif
                                    @else
                                        @if ($j == 0)
                                            <ul>

                                                @foreach ($priorities as $pri)
                                                    @if ($pri['priority'] <= 50)
                                                        @if ($pri['performance'] <= 50)
                                                            <li class="text-black">
                                                                {{ $pri['function'] }}
                                                                {{ $pri['performance'] }}</li>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </ul>
                                        @endif
                                        @if ($j == 1)
                                            <ul>

                                                @foreach ($priorities as $pri)
                                                    @if ($pri['priority'] <= 50)
                                                        @if ($pri['performance'] > 50 && $pri['performance'] <= 80)
                                                            <li class="text-black">{{ $pri['function'] }}
                                                            </li>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </ul>
                                        @endif
                                    @endif
                                </div>
                            @endif
                            {{-- End second --}}
                            {{-- Start third --}}
                            @if (($i == 0 && $j == 2) || ($i == 1 && $j == 2) || ($i == 2 && $j == 2))
                                <div class="bg-success heat-map-result">
                                    @if ($i == 0)
                                        @if ($j == 2)
                                            <ul>

                                                @foreach ($priorities as $pri)
                                                    @if ($pri['priority'] > 80 && $pri['priority'] <= 100)
                                                        @if ($pri['performance'] > 80)
                                                            <li class="text-white">{{ $pri['function'] }}
                                                            </li>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </ul>
                                        @endif
                                    @endif
                                    @if ($i == 1)
                                        @if ($j == 2)
                                            <ul>

                                                @foreach ($priorities as $pri)
                                                    @if ($pri['priority'] > 50 && $pri['priority'] < 80)
                                                        @if ($pri['performance'] > 80)
                                                            <li class="text-white">{{ $pri['function'] }}
                                                            </li>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </ul>
                                        @endif
                                    @endif
                                    @if ($i == 2)
                                        @if ($j == 2)
                                            <ul>

                                                @foreach ($priorities as $pri)
                                                    @if ($pri['priority'] <= 50)
                                                        @if ($pri['performance'] > 80)
                                                            <li class="text-white">{{ $pri['function'] }}
                                                            </li>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </ul>
                                        @endif
                                    @endif
                                </div>
                            @endif
                        @endfor
                    </div>
                </div>
            @endfor

            <div class="col-3 text-end heat-map">
                <span></span>
            </div>
            <div class="col-9 heat-map">
                <div class="row">
                    <div class="heat-map-bottom-label">{{ __('Low') }}</div>
                    <div class="heat-map-bottom-label">{{ __('Medium') }}</div>
                    <div class="heat-map-bottom-label">{{ __('High') }}</div>
                </div>
            </div>
            <div class="col-3 text-end heat-map">
                <span></span>
            </div>
            <div class="col-9 heat-map text-center p-3">
                <div class="heat-map-bottom-title">
                    {{ __('People management performance score by leaders') }}
                </div>
            </div>
        </div>
    </div>
    {{-- card footer --}}
    <div class="card-footer">
        <span class="legend-result"><b>{{ __('Legend') }}:</b></span> <span class="legend-levels"><b>
                {{ __('Low:') }}</b></span>
        <=50% – <span class="legend-levels"><b>{{ __('Medium:') }}</b></span> > {{ __('50% to 80%') }}
            – <span class="legend-levels"><b>{{ __('High:') }}</b></span> >80%

    </div>
</div>
<button id="heatmapDownload" class="btn btn-success mt-1" onclick="downloadResult('heatmap','heatmap')">
    {{ __('Download') }}
</button>
