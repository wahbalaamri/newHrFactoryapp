<div class="card mt-4" id="Consolidated" style="letter-spacing: 0.065rem;">
    <div class="card-header">
        <h4 class="card-title">{{ __('Consolidated results') }}</h4>
    </div>
    <div class="card-body" style="letter-spacing: 0.065rem;">
        <div class="row">
            <div class="col-12">
                {{ __('Consolidated findings by function') }}
            </div>
        </div>
        <div class="row">
            <div class="col-sm-1 m-1 text-white bg-info"
                style="font-size: 0.84rem;border-radius: 10px;display: flex;justify-content: center;align-content: center;flex-direction: column;text-align: center;">
                <span>{{ __('Functions') }}</span>
            </div>
            @php
                usort($asc_perform, function ($a, $b) {
                    return $a['performance'] <=> $b['performance'];
                });
            @endphp
            @foreach ($asc_perform as $perfomr)
                <div class="m-1 text-white bg-info"
                    style="width: 10.4% !important; font-size: 0.8rem;border-radius: 10px;display: flex;justify-content: center;align-content: center;flex-direction: column;text-align: center;">
                    {{ $perfomr['function'] }}
                </div>
            @endforeach
        </div>
        <div class="row">
            <div class="col-sm-1 m-1 text-white bg-primary"
                style="font-size: 0.84rem;border-radius: 10px;display: flex;justify-content: center;align-content: center;flex-direction: column;text-align: center;">
                <span style="hyphens: auto;">{{ __('Improvement need') }}
                </span>
            </div>
            @foreach ($asc_perform as $perfomr)
                <div class="m-1 @if ($perfomr['performance'] <= 50) bg-danger text-white @elseif($perfomr['performance'] > 80) bg-success text-white @else bg-warning @endif"
                    style="width: 10.4% !important; font-size: 0.8rem border-radius: 10px;">
                    @if ($perfomr['performance'] <= 50)
                        {{ __('Critical to improve') }}
                    @elseif($perfomr['performance'] > 80)
                        No
                        {{ __('Improvement Needed') }}
                    @else
                        {{ __('Need to improve') }}{{-- {{ $perfomr['performance'] }} --}}
                    @endif
                </div>
            @endforeach
        </div>
        <div class="row">
            <div class="col-sm-1 m-1 text-white bg-primary"
                style="font-size: 0.84rem;border-radius: 10px;display: flex;justify-content: center;align-content: center;flex-direction: column;text-align: center;">
                <span>
                    {{ __('Performance rating by Leaders, Employees and HR Team') }}
                </span>
            </div>
            @foreach ($asc_perform as $perfomr)
                <div class="m-1 " style="width: 10.4% !important; font-size: 0.8rem border-radius: 10px;">
                    @foreach ($sorted_leader_performences as $leader)
                        @if ($leader['function_id'] == $perfomr['function_id'])
                            <div class="row mt-2">
                                <div class="col-md-5">
                                    <img src="{{ asset('assets/img/icon/LeadersIcon.png') }}" height="30"
                                        width="35" alt="">
                                </div>
                                @if ($leader['applicable'])
                                    {{ $leader['performance'] }}% <br>
                                @else
                                    {{ __('N/A') }}<br>
                                @endif
                            </div>
                        @break;
                    @endif
                @endforeach
                {{-- hr --}}
                @foreach ($sorted_hr_performences as $hr)
                    @if ($hr['function_id'] == $perfomr['function_id'])
                        <div class="row mt-2">
                            <div class="col-md-5">
                                <img src="{{ asset('assets/img/icon/HRIcon.png') }}" height="30" width="35"
                                    alt="">
                            </div>
                            @if ($hr['applicable'])
                                {{ $hr['performance'] }}% <br>
                            @else
                                {{ __('N/A') }}<br>
                            @endif
                        </div>
                    @break;
                @endif
            @endforeach
            {{-- emp --}}
            @foreach ($sorted_emp_performences as $emp)
                @if ($emp['function_id'] == $perfomr['function_id'])
                    <div class="row mt-2">
                        <div class="col-md-5">
                            <img src="{{ asset('assets/img/icon/EmployeIcon.png') }}" height="30"
                                width="35" alt="">
                        </div>
                        @if ($emp['applicable'])
                            {{ $emp['performance'] }}% <br>
                        @else
                            {{ __('N/A') }}<br>
                        @endif
                    </div>
                @break;
            @endif
        @endforeach
    </div>
@endforeach
</div>
<div class="row">
<div class="col-sm-1 m-1 text-white bg-info"
    style="font-size: 0.84rem;border-radius: 10px;display: flex;justify-content: center;align-content: center;flex-direction: column;text-align: center;">
    <span>{{ __('Priority') }}
    </span>
</div>
@foreach ($asc_perform as $perfomr)
    <div class="m-1 " style="width: 10.4% !important; font-size: 0.8rem">
        @foreach ($priorities as $pro)
            @if ($pro['function_id'] == $perfomr['function_id'])
                <div class="@if ($pro['priority'] <= 50) bg-success text-white @elseif($pro['priority'] > 50 && $pro['priority'] <= 80) bg-warning text-black @else bg-danger text-white @endif"
                    style="border-radius: 10px;display: flex;justify-content: center;align-content: center;flex-direction: column;text-align: center;height: 2rem;font-size: 1rem;">
                    @if ($pro['priority'] <= 50)
                        {{ __('Low') }}
                    @elseif($pro['priority'] > 50 && $pro['priority'] <= 80)
                        {{ __('Medium') }}
                    @else
                        {{ __('High') }}
                    @endif
                </div>
            @break
        @endif
    @endforeach
</div>
@endforeach
</div>
<div class="row">
<div class="col-sm-1 m-1 bg-primary text-white"
style="font-size: 0.84rem;border-radius: 10px;display: flex;justify-content: center;align-content: center;flex-direction: column;text-align: center;">

<span>{{ __('Key improvement areas by practices') }}
</span>
</div>
@foreach ($asc_perform as $perfomr)
@php $count = 0; @endphp
<div class="m-1 " style="width: 10.4% !important; font-size: 0.8rem">
    <ul class="list-group" style="width: 100%; border-radius: 10px;">
        @foreach ($overall_Practices as $practice)
            @if ($practice['function_id'] == $perfomr['function_id'])
                <li class="list-group-item list-group-item p-2 text-center">
                    {{ $practice['name'] }}
                </li>
                @php $count++; @endphp
            @endif
            @if ($count == 3)
            @break;
        @endif
    @endforeach
</ul>
</div>
@endforeach
</div>
</div>
<div class="card-footer">
<span class="legend-result"><b>{{ __('Legend') }}:</b></span> <span class="legend-levels"><b>
{{ __('Leadership') }}:</b></span>
<img src="{{ asset('assets/img/icon/LeadersIcon.png') }}" height="20" width="25" alt=""> – <span
class="legend-levels"><b>{{ __('HR Team') }}:</b></span> <img
src="{{ asset('assets/img/icon/HRIcon.png') }}" height="20" width="25" alt=""> – <span
class="legend-levels"><b>{{ __('Employee') }}:</b></span> <img
src="{{ asset('assets/img/icon/EmployeIcon.png') }}" height="20" width="25" alt="">

</div>
</div>
</div>
<button id="heatmapDownload" class="btn btn-success mt-1"
style="border-radius: 10px;
-webkit-box-shadow: 5px 5px 20px 5px #ababab;
box-shadow: 5px 5px 20px 5px #ababab;"
onclick="downloadResult('Consolidated','Consolidated')">
{{ __('Download') }}
</button>
