<div id="Function" class="card mt-4" style="letter-spacing: 0.065rem;">
    <div class="card-header">
        <h3 class="card-title">{{ __('Result overview - by Functions and Practices') }}</h3>
    </div>
    <div class="card-body text-capitalize font-weight-600">
        <div class="row">
            <div class="col-1" style="max-width: 45px;"></div>
            <div class="col-11">
                <div class="col-12 {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }} h3 text-white p-3 bg-info"
                    style="border-radius: 15px;width: 89%; -webkit-box-shadow: 0px 0px 5px 1px #ABABAB;box-shadow: 0px 0px 5px 1px #ABABAB;">
                    {{ __('Key functions') }}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-1" style="max-width: 45px;"></div>
            <div class="col-11">
                <div class="row  padding-left-10px">
                    @foreach ($functions as $function)
                    <div class="text-center text-white m-1 bg-info"
                        style="width:10.5%; border-radius: 10px; -webkit-box-shadow: 0px 0px 5px 1px #ABABAB;box-shadow: 0px 0px 5px 1px #ABABAB; font-size: 0.79rem">
                        {{ $function->translated_title }}
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-1"
                style="background-color: #DCE6F2;    background-color: #DCE6F2;writing-mode: vertical-lr;transform: rotate(180deg);min-width: 19px;max-width: 45px;display: flex;align-items: center;justify-content: center;color:#376092; font-size: 1.5rem; font-weight: bold">
                {{ __('Practices') }}
            </div>
            <div class="col-11">
                <div class="row" style="width: 100%">
                    @foreach ($functions as $function)
                    @php $firstofFirstLoop = $loop->first; @endphp
                    <div class="col-1 @if($firstofFirstLoop) mt-3 mb-3 mr-3 @else m-3 @endif  justify-content-center pb-1 pt-1"
                        style="width: 10.5%; font-size: 0.79rem">
                        @foreach ($overall_Practices as $overall_Practice)
                        @if ($overall_Practice['function_id'] == $function->id)
                        <div class="text-center @if (!$loop->first) mt-1 p-2 @endif @if ($firstofFirstLoop) p-2 @else p-2 m-1 @endif @if ($overall_Practice['weight'] <= 0.5) bg-danger text-white @elseif ($overall_Practice['weight'] > 0.5 && $overall_Practice['weight'] <= 0.8) bg-warning text-black @else bg-success text-white @endif"
                            style=" width:150%; border-radius: 10px; -webkit-box-shadow: 5px 5px 20px 5px #ABABAB;box-shadow: 5px 5px 20px 5px #ABABAB;">
                            {{ $overall_Practice['name'] }}
                            {{ floatval($overall_Practice['weight']) * 100 }}%{{-- --id:
                            {{
                            $overall_Practice['id'] }} --}}
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
<button id="FunctionDownload" onclick="downloadResult('Function','Function')" class="btn btn-success mt-1">{{
    __('Download') }}</button>
