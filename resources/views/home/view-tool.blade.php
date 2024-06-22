@extends('layouts.main')
@section('content')
{{-- add imager banner --}}
<div class="container-fluid">
    <div class="row main-bg">
        <div class="col-lg-6 col-md-12 col-sm-12 p-0 m-0 text-center justify-content-center align-self-center">
            <h1 class="text-white" style="font-size: 3.4rem; line-height: 4.0rem">
                {{ $service->slug}}
            </h1>
            {{-- <span style="font-size: 2.4rem">{{ __('Maximize your return on people investment') }}
            </span> --}}
        </div>
        <div class="col-lg-6 col-md-12 col-sm-12 p-0 m-0">
            <img src="{{ asset('uploads/services/images/') }}/{{ $service->service_media_path }}"
                class="float-end image-2" alt="" srcset="">
        </div>
    </div>
</div>
{{-- end add imager banner --}}
{{-- add welcome paragraph --}}
<div class="container-fluid p-5">
    {{-- <div class="row"> --}}
        <div class="col-12 text-center justify-content-center align-self-center">
            <h1 class="text-center">
                {{ __('Our approach') }}
            </h1>
        </div>
        <div class="col-12 text-center justify-content-center align-self-center pt-5">
            <div class="row">
                @foreach($service->approaches as $approach)

                <div class="col-lg-4 col-md-12 col-sm-12">
                    <div class="col-12">
                        <img src="{{ asset('uploads/services/icons/') }}/{{ $approach->icon }}" alt="" srcset=""
                            height="80" style="">
                    </div>
                    <div class="col-12">
                        <div class="w-75 m-auto p-3">

                            <p class="">{!! $approach->approach!!}
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
        {{--
    </div> --}}
</div>

{{-- end welcome paragraph --}}
{{-- add subscriptionPlans --}}
<div class="container-fluid pt-5">
    <div class="row pt-2 pb-5" style="background-color: #f8f7f5;">
        <div class="col-12 pb-1 pt-1 text-center justify-content-center align-self-center">
            <h1 class="text-center text-capitalize">
                {{ __('Plans') }}
            </h1>
        </div>
        <div class="col-12">
            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-sm-8">
                        {{-- add card --}}
                        <div class="responsive-table">
                            <table class="table table-hover table-bordered table-striped table-striped-columns">
                                <thead>
                                    <tr>
                                        <th scope="col">{{ __('Feature') }}</th>
                                        @foreach ($service->plans as $plan)
                                        <th scope="col">{{ $plan->name }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($service->features as $feature)
                                    <tr>
                                        <td>{{ $feature->feature }}</td>
                                        @foreach ($service->plans as $plan)
                                        <td>
                                            @if (in_array($feature->id, $plan->Features))
                                            <i class="fas fa-check text-success"></i>
                                            @else
                                            <i class="fas fa-times text-danger"></i>
                                            @endif
                                        </td>
                                        @endforeach
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <th>{{ __('One time Subscription Fee') }}</th>
                                        @foreach ($service->plans as $plan)
                                        <td>{{ $plan->plansPrices[0]->monthly_price }} {{
                                            $plan->plansPrices[0]->currency_symbol }}
                                            <a href="javascript:void(0)" class="btn btn-sm btn-warning">{{ __('Subscripe
                                                now') }}</a>
                                        </td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <th>{{ __('Annual Subscription Fee') }}</th>
                                        @foreach ($service->plans as $plan)
                                        @php

                                        $TotalMonthlyprice = $plan->plansPrices[0]->monthly_price*12;
                                        $diff= $TotalMonthlyprice - $plan->plansPrices[0]->annual_price ;
                                        $percentage= number_format(($diff / $TotalMonthlyprice)*100,2)
                                        @endphp
                                        <td><del>{{ $TotalMonthlyprice}}
                                            </del> {{ $plan->plansPrices[0]->annual_price }} {{
                                            $plan->plansPrices[0]->currency_symbol }} <span class="text-success">({{
                                                __('Save') }} {{
                                                $percentage }}%)</span> <a href="javascript:void(0)"
                                                class="btn btn-sm btn-success">{{ __('Subscripe
                                                now') }}</a></td>
                                        @endforeach
                                    </tr>
                                    {{-- if user loged in --}}
                                    @if (Auth::check())
                                    <tr>
                                        <th>{{ __('Action') }}</th>
                                        @foreach ($service->plans as $plan)
                                        <td>
                                            <a href="" class="btn btn-primary">{{ __('Get Started') }}</a>
                                        </td>
                                        @endforeach
                                        @endif
                                </tbody>
                            </table>
                        </div>
                        {{-- end card --}}
                    </div>


                </div>
            </div>

        </div>
    </div>
</div>
<div class="container-fluid p-5">
    <div class="row justify-content-center">
        <div class="col-6">
            <h1 class="pt-3 pb-3 text-center text-capitalize">{{ __('Tool framework') }}<sup class="h5">TM</sup></h1>

            @if(App()->getLocale() == 'ar')
            @if($service->FW_uploaded_video_ar)
            <video id="myVid" src="{{ asset('uploads/services/videos')}}/{{ $service->framework_media_path_ar }}"
                autoplay="true" muted="muted">
            </video>
            @else
            {{-- embad youtube video --}}
            <iframe width="100%" height="315" src="{{ $service->framework_media_path_ar }}" title="YouTube video player"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen></iframe>
            @endif
            @else
            @if($service->FW_uploaded_video)

            <video id="myVid" src="{{ asset('uploads/services/videos')}}/{{ $service->framework_media_path }}"
                autoplay="true" muted="muted">
            </video>
            @else
            {{-- embad youtube video--}}
            <iframe width="100%" height="315" src="{{ $service->framework_media_path }}" title="YouTube video player"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen></iframe>
            @endif
            @endif
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="requestservice" tabindex="-1" aria-labelledby="requestserviceLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="requestserviceLabel">Request service</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    @csrf
                    <div class="row">
                        <input type="hidden" name="plan_id" id="plan_id" value="">
                        {{-- Company Name --}}
                        <div class="form-group  col-md-6">
                            <label for="name">{{ __('Company Name') }}</label>
                            <input type="text" name="company_name"
                                class="form-control @error('company_name') is-invalid @enderror" id="company_name"
                                placeholder="Enter Company Name">
                            @error('company_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        {{-- company_phone --}}
                        <div class="form-group col-md-6">
                            <label for="name">{{ __('Company Phone') }}</label>
                            <input type="text" name="company_phone"
                                class="form-control @error('company_phone') is-invalid @enderror" id="company_phone"
                                placeholder="Enter Company Phone">
                            @error('company_phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>


                        {{-- fp_name --}}
                        <div class="form-group col-md-6">
                            <label for="name">{{ __('Focal Point Name') }}</label>
                            <input type="text" name="fp_name"
                                class="form-control @error('fp_name') is-invalid @enderror" id="fp_name"
                                placeholder="Enter Focal Point Name">
                            @error('fp_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        {{-- fp_email --}}
                        <div class="form-group  col-md-8">
                            <label for="name">{{ __('Focal Point Email') }}</label>
                            <input type="email" name="fp_email"
                                class="form-control @error('fp_email') is-invalid @enderror" id="fp_email"
                                placeholder="Enter Focal Point Email">
                            @error('fp_email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        {{-- remarks --}}
                        <div class="form-group  col-md-12">
                            <label for="name">{{ __('Remarks') }}</label>
                            <textarea name="remarks" id="remarks" cols="30" rows="10"
                                class="form-control @error('remarks') is-invalid @enderror"></textarea>
                            @error('remarks')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer mt-3">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection
{{-- scripts --}}
@section('scripts')
<script>
    $(function () {
  $('[data-toggle="popover"]').popover({
    html : true,

        content: function() {
            var content = $(this).attr("data-popover-content");
            return $(content).children(".popover-body").html();
        }
  });

});
function SetUpthis(controle){
    console.log(controle);
    // console.log(controle.attr('data-bs-content'));
}
    $(document).ready(function() {
            // if error is found
            if ($('.is-invalid').length > 0) {
                $('#requestservice').modal('show');
            }
            abcsd(2);
        });



        function RenderModal(id, title) {
            $('#requestserviceLabel').text(title);
            $('#plan_id').val(id);
            //
        }
        //js function
        function abcsd(id) {
            window.addEventListener('load', videoScroll);
            window.addEventListener('scroll', videoScroll);

            videoScroll();

        }
        function videoScroll() {
            var windowHeight = window.innerHeight;
                                var thisVideoEl = document.getElementById('myVid');
                                    videoHeight = thisVideoEl.clientHeight,
                                    videoClientRect = thisVideoEl.getBoundingClientRect().top;

                                if ( videoClientRect <= ( (windowHeight) - (videoHeight*.5) ) && videoClientRect >= ( 0 - ( videoHeight*.5 ) ) ) {
                                    thisVideoEl.play();
                                } else {
                                    thisVideoEl.pause();
                                }
                    }
</script>
@endsection
