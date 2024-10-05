<div class="card mt-4">
    <div class="card-header">
        <div class="card-title">
            <h3>{{ $entity }}</h3>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="card">
                    <div class="mt-3 text-center">
                        <h3>{{ __('Legend') }}</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <h4 class="h4 text-center">{{ __('Performance categories & color codes') }}
                                </h4>
                                <div class="p-3 m-3 rounded-2 text-white text-center bg-success">
                                    {{ 'High:
                                    > 80%' }}
                                </div>
                                <div class="p-3 m-3 rounded-2 text-white text-center bg-warning">
                                    {{ __('Medium: >50% to 80%') }}</div>
                                <div class="p-3 m-3 rounded-2 text-white text-center bg-danger">
                                    {{ __('Low:
                                    <=50%') }} </div>

                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <h4 class="h4 text-center">
                                        {{ __('Definition of respondent groups') }}
                                    </h4>
                                    <div class="table-responsive">
                                        <table class="table table-borderless">
                                            <tbody>
                                                <tr>
                                                    <th>{{ __('Leadership') }}:</th>
                                                    <td>{{ __('All managers and leaders who took part in the
                                                        diagnosis process') }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('HR Team') }}:</th>
                                                    <td>{{ __('Members of the HR team both managers and
                                                        employyees – who take part of the diagnosis
                                                        process') }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Employees') }}:</th>
                                                    <td>{{ __('Employees who take part of the diagnosis
                                                        process.') }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="card">
                        {{-- card header --}}
                        <div class="mt-3 text-center">
                            <h3>{{ __('Survey Response rate') }}</h3>
                        </div>
                        {{-- card body --}}
                        <div class="card-body text-center">
                            {{-- survey divs --}}
                            <div class="w-100">
                                @if ($Resp_overAll_res > 0)
                                <div class="circle-wrap m-2"
                                    style=" {{ app()->getLocale() == 'ar' ? 'left: -35%!important' : 'left: 40%!important' }}; position: relative !important;">
                                    <div class="circle">

                                        <div class="mask half">
                                            <div
                                                class="fill-{{ number_format(($overAll_res / $Resp_overAll_res) * 100) }}">
                                            </div>
                                        </div>

                                        <div
                                            class="mask full-{{ number_format(($overAll_res / $Resp_overAll_res) * 100) }}">
                                            <div
                                                class="fill-{{ number_format(($overAll_res / $Resp_overAll_res) * 100) }}">
                                            </div>
                                        </div>
                                        <div
                                            class="{{ app()->getLocale() == 'ar' ? 'inside-circle-rtl' : 'inside-circle' }}">
                                            {{ number_format(($overAll_res / $Resp_overAll_res) * 100) }}%
                                            <p>
                                                {{ __('Responded') }}</p>
                                        </div>


                                    </div>
                                </div>
                                @endif
                                @if ($prop_leadersResp > 0)
                                <div class="col-6 text-end function-lable mr-3">
                                    {{ __('Total Leaders
                                    Answers') }}
                                    {{ $leaders_res }} {{ __('out of') }}
                                    {{ $prop_leadersResp }}</div>
                                <div class="col-9 text-start function-progress">
                                    <div class="progress" style="height: 31px">
                                        <div class="progress-bar @if ($leaders_res / $prop_leadersResp < 0.5) bg-danger @elseif($leaders_res / $prop_leadersResp == 1) bg-success @else bg-warning @endif"
                                            role="progressbar"
                                            style="width: {{ ($leaders_res / $prop_leadersResp) * 100 }}%; font-size: 1rem"
                                            aria-valuenow="{{ ($leaders_res / $prop_leadersResp) * 100 }}"
                                            aria-valuemin="0" aria-valuemax="100">
                                            {{ number_format(($leaders_res / $prop_leadersResp) * 100) }}%
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if ($prop_hrResp > 0)
                                <div class="col-6 text-end function-lable mr-3">
                                    {{ __('Total HR Answers') }}
                                    {{ $hr_res }} {{ __('out of') }} {{ $prop_hrResp }}</div>
                                <div class="col-9 text-start function-progress">
                                    <div class="progress" style="height: 31px">
                                        <div class="progress-bar @if ($hr_res / $prop_hrResp < 0.5) bg-danger @elseif($hr_res / $prop_hrResp == 1) bg-success @else bg-warning @endif"
                                            role="progressbar"
                                            style="width: {{ ($hr_res / $prop_hrResp) * 100 }}%; font-size: 1rem"
                                            aria-valuenow="{{ ($hr_res / $prop_hrResp) * 100 }}" aria-valuemin="0"
                                            aria-valuemax="100">
                                            {{ number_format(($hr_res / $prop_hrResp) * 100) }}%
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if ($prop_empResp > 0)
                                <div class="col-6 text-end function-lable mr-3">
                                    {{ __('Total Employee
                                    Answers') }}
                                    {{ $emp_res }} {{ __('out of') }} {{ $prop_empResp }}</div>

                                <div class="col-9 text-start function-progress">
                                    <div class="progress" style="height: 31px">
                                        <div class="progress-bar @if ($emp_res / $prop_empResp < 0.5) bg-danger @elseif($emp_res / $prop_empResp == 1) bg-success @else bg-warning @endif"
                                            role="progressbar"
                                            style="width: {{ ($emp_res / $prop_empResp) * 100 }}%; font-size: 1rem"
                                            aria-valuenow="{{ ($emp_res / $prop_empResp) * 100 }}" aria-valuemin="0"
                                            aria-valuemax="100">
                                            {{ number_format(($emp_res / $prop_empResp) * 100) }}%</div>
                                    </div>
                                </div>
                                @endif
                                {{-- end survey divs --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
