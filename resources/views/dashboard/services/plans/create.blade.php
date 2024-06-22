@extends('dashboard.layouts.main')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Plans') }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item active"><a href="{{ route('services.index') }}">{{ __('Service')
                                }}</a> </li>
                        <li class="breadcrumb-item active">{{ __('New Plan') }}</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-lightblue">
                <div class="card-header">
                    <h3 class="card-title">{{$plan?__('Edit Plan'): __('New Plan') }}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{ route('service-plans.store',$service->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="bs-stepper linear">
                            <div class="bs-stepper-header" role="tablist">

                                <div class="step active" data-target="#plan-info">
                                    <button type="button" class="step-trigger" role="tab" aria-controls="plan-info"
                                        id="plan-info-trigger" aria-selected="true">
                                        <span class="bs-stepper-circle">1</span>
                                        <span class="bs-stepper-label">{{ __('Plan Info') }}</span>
                                    </button>
                                </div>
                                <div class="line"></div>
                                <div class="step" data-target="#plan-feature">
                                    <button type="button" class="step-trigger" role="tab" aria-controls="plan-feature"
                                        id="plan-feature-trigger" aria-selected="false" disabled="disabled">
                                        <span class="bs-stepper-circle">2</span>
                                        <span class="bs-stepper-label">{{ __('Plan Feature') }}</span>
                                    </button>
                                </div>
                                @if(!$plan)
                                <div class="line"></div>
                                <div class="step" data-target="#plan-price">
                                    <button type="button" class="step-trigger" role="tab" aria-controls="plan-price"
                                        id="plan-price-trigger" aria-selected="false" disabled="disabled">
                                        <span class="bs-stepper-circle">3</span>
                                        <span class="bs-stepper-label">{{ __('Plan Price') }}</span>
                                    </button>
                                </div>
                                @endif
                            </div>
                            <div class="bs-stepper-content">

                                <div id="plan-info" class="content active dstepper-block" role="tabpanel"
                                    aria-labelledby="plan-info-trigger">
                                    @if ($errors->any())
                                    <div class="alert alert-danger text-white">
                                        <ul>
                                            {!! implode('', $errors->all('<li class="">:message</li>')) !!}
                                        </ul>
                                    </div>
                                    @endif
                                    <div class="row justify-content-center">
                                        <div class="w-75">
                                            <div class="row">
                                                {{-- name --}}
                                                <input type="hidden" name="plan_id" value="{{ $plan?$plan->id:null }}">
                                                <div class="form-group col-md-5 col-sm-12">
                                                    <label for="name">{{ __('Plan Name (English)') }}</label>
                                                    <input type="text" name="name" id="name" class="form-control"
                                                        placeholder="{{ __('Plan Name in English') }}"
                                                        value="{{ old('name' ,$plan?$plan->name:null) }}">
                                                    {{-- validation --}}
                                                    @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                {{-- name arabic--}}
                                                <div class="form-group col-md-5 col-sm-12">
                                                    <label for="name_ar">{{ __('Plan Name (Arabic)') }}</label>
                                                    <input type="text" name="name_ar" id="name_ar" class="form-control"
                                                        placeholder="{{ __('Plan Name in Arabic') }}"
                                                        value="{{ old('name_ar',$plan?$plan->name_ar:null) }}">
                                                    {{-- validation --}}
                                                    @error('name_ar')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                {{-- sample_report file upload --}}
                                                <div class="form-group col-md-6 col-sm-12">
                                                    <label for="sample_report">{{ __('Sample Report') }}</label>
                                                    <input type="file" name="sample_report" id="sample_report"
                                                        class="form-control">
                                                    {{-- validation --}}
                                                    @error('sample_report')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                {{-- is_active switch --}}
                                                <div class="form-group col-md-6 col-sm-12">
                                                    <label for="is_active">{{ __('Plan Status') }}</label>
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input"
                                                            id="is_active" name="is_active" @if($plan) @if($plan->is_active) checked @endif @else
                                                             checked @endif>
                                                        <label class="custom-control-label" for="is_active">{{
                                                            __('Active') }}</label>
                                                    </div>
                                                </div>
                                                {{-- delivery_mode --}}
                                                <div class="form-group col-md-6 col-sm-12">
                                                    <label for="delivery_mode">{{ __('delivery_mode (English)')
                                                        }}</label>
                                                    <textarea name="delivery_mode" id="delivery_mode"
                                                        class="form-control summernote"
                                                        placeholder="{{ __('delivery_mode in English') }}"
                                                        rows="3">{{ old('delivery_mode',$plan?$plan->delivery_mode:null) }}</textarea>
                                                    {{-- validation --}}
                                                    @error('delivery_mode')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                {{-- delivery_mode arabic --}}
                                                <div class="form-group col-md-6 col-sm-12">
                                                    <label for="delivery_mode_ar">{{ __('delivery_mode (Arabic)')
                                                        }}</label>
                                                    <textarea name="delivery_mode_ar" id="delivery_mode_ar"
                                                        class="form-control summernote"
                                                        placeholder="{{ __('delivery_mode in Arabic') }}"
                                                        rows="3">{{ old('delivery_mode_ar',$plan?$plan->delivery_mode_ar:null) }}</textarea>
                                                    {{-- validation --}}
                                                    @error('delivery_mode_ar')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                {{-- limitations --}}
                                                <div class="form-group col-md-6 col-sm-12">
                                                    <label for="limitations">{{ __('Limitations (English)') }}</label>
                                                    <textarea name="limitations" id="limitations"
                                                        class="form-control summernote"
                                                        placeholder="{{ __('Limitations in English') }}"
                                                        rows="3">{{ old('limitations',$plan?$plan->limitations:null) }}</textarea>
                                                    {{-- validation --}}
                                                    @error('limitations')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                {{-- limitations arabic --}}
                                                <div class="form-group col-md-6 col-sm-12">
                                                    <label for="limitations_ar">{{ __('Limitations (Arabic)') }}</label>
                                                    <textarea name="limitations_ar" id="limitations_ar"
                                                        class="form-control summernote"
                                                        placeholder="{{ __('Limitations in Arabic') }}"
                                                        rows="3">{{ old('limitations_ar',$plan?$plan->limitations_ar:null) }}</textarea>
                                                    {{-- validation --}}
                                                    @error('limitations_ar')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            {{-- end row --}}
                                        </div>
                                    </div>
                                    <a href="javascript:void" class="btn btn-primary float-right"
                                        onclick="stepper.next()">Next</a>
                                </div>
                                <div id="plan-feature" class="content" role="tabpanel"
                                    aria-labelledby="plan-feature-trigger">
                                    <div class="row justify-content-center">
                                        <div class="w-75">
                                            <div class="row">
                                                {{-- features --}}
                                                <div class="form-group col-sm-12">
                                                    <label for="features">{{ __('Features') }}</label>
                                                    {{-- checkbox input --}}

                                                    <div class="row">
                                                        @foreach ( $service->features as $feature)
                                                        <div class="form-check col-md-4 col-sm-12">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="pf-{{ $feature->id }}" id="pf-{{ $feature->id }}" @if($plan) @if (in_array($feature->id,$features))
                                                                    checked
                                                                @endif @endif>
                                                            <label class="form-check-label" for="pf-{{ $feature->id }}">
                                                                {{ $feature->feature }}
                                                            </label>
                                                        </div>
                                                        @endforeach

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="javascript:void(0)" class="btn btn-primary float-left"
                                        onclick="stepper.previous()">Previous</a>
                                    @if($plan)
                                    <button type="submit" class="btn btn-primary float-right">Submit</button>
                                    @else
                                    <a href="javascript:void" class="btn btn-primary float-right"
                                        onclick="stepper.next()">Next</a>
                                    @endif
                                </div>
                                @if(!$plan)
                                <div id="plan-price" class="content" role="tabpanel"
                                    aria-labelledby="plan-price-trigger">
                                    <div class="row justify-content-center">
                                        <div class="w-75">
                                            <div class="row">
                                                {{-- service valid in country --}}
                                                <div class="form-group col-md-3 col-sm-12">
                                                    <label for="valid_in">{{ __('Plan Valid In') }}</label>
                                                    <select name="valid_in" id="valid_in" class="form-control">
                                                        <option value="">{{ __('Select Country') }}</option>

                                                        <optgroup label="{{ __('Arab Countries') }}">
                                                            @foreach ($countries[1] as $country)
                                                            <option value="{{ $country->id }}"
                                                                @if(old('valid_in')==$country->id) selected
                                                                @endif>{{ $country->name }}
                                                            </option>
                                                            @endforeach
                                                        </optgroup>
                                                        <optgroup label="{{ __('Other') }}">
                                                            @foreach ($countries[0] as $country)
                                                            <option value="{{ $country->id }}"
                                                                @if(old('valid_in')==$country->id) selected
                                                                @endif>{{ $country->name }}
                                                            </option>
                                                            @endforeach
                                                        </optgroup>
                                                    </select>
                                                    {{-- validation --}}
                                                    @error('valid_in')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                {{-- monthly_price --}}
                                                <div class="form-group col-md-3 col-sm-12">
                                                    <label for="monthly_price">{{ __('Monthly Price') }}</label>
                                                    <input type="number" name="monthly_price" id="monthly_price"
                                                        class="form-control" placeholder="{{ __('monthly Price') }}"
                                                        value="{{ old('monthly_price') }}">
                                                    {{-- validation --}}
                                                    @error('monthly_price')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                {{-- annual_price --}}
                                                <div class="form-group col-md-3 col-sm-12">
                                                    <label for="annual_price">{{ __('Annual Price') }}</label>
                                                    <input type="number" name="annual_price" id="annual_price"
                                                        class="form-control" placeholder="{{ __('Annual Price') }}"
                                                        value="{{ old('annual_price') }}">
                                                    {{-- validation --}}
                                                    @error('annual_price')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                {{-- currency --}}
                                                <div class="form-group col-md-3 col-sm-12">
                                                    <label for="currency">{{ __('Currency') }}</label>
                                                    <select name="currency" id="currency" class="form-control">
                                                        <option value="">{{ __('Select Currency') }}</option>

                                                        <option value="1" @if(old('currency')=="1" ) selected @endif>
                                                            {{ __('OMR') }}
                                                        </option>
                                                        <option value="2" @if(old('currency')=="2" ) selected @endif>
                                                            {{ __('USD') }}
                                                        </option>
                                                        <option value="3" @if(old('currency')=="3" ) selected @endif>
                                                            {{ __('AED') }}
                                                        </option>
                                                        <option value="4" @if(old('currency')=="4" ) selected @endif>
                                                            {{ __('SAR') }}
                                                        </option>
                                                        <option value="5" @if(old('currency')=="5" ) selected @endif>
                                                            {{ __('KWD') }}
                                                        </option>
                                                        <option value="6" @if(old('currency')=="6" ) selected @endif>
                                                            {{ __('BHD') }}
                                                        </option>
                                                        <option value="7" @if(old('currency')=="7" ) selected @endif>
                                                            {{ __('QAR') }}
                                                        </option>
                                                        <option value="8" @if(old('currency')=="8" ) selected @endif>
                                                            {{ __('EGP') }}
                                                        </option>
                                                        <option value="9" @if(old('currency')=="9" ) selected @endif>
                                                            {{ __('JOD') }}</option>
                                                        {{-- lebanon --}}
                                                        <option value="10" @if(old('currency')=="10" ) selected @endif>
                                                            {{ __('LBP') }}</option>

                                                    </select>
                                                </div>
                                                {{-- payment_methods --}}
                                                <div class="form-group col-md-6 col-sm-12">
                                                    <label for="payment_methods">{{ __('Payment Methods') }}</label>
                                                    {{-- checkbox input --}}
                                                    <div class="row">
                                                        <div class="form-check col-md-6 col-sm-12">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="PM-online" value="0" id="PM-online">
                                                            <label class="form-check-label" for="PM-online">
                                                                {{ __('Online') }}
                                                            </label>
                                                        </div>
                                                        <div class="form-check col-md-6 col-sm-12">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="PM-offline" value="0" id="PM-offline">
                                                            <label class="form-check-label" for="PM-offline">
                                                                {{ __('offline') }}
                                                            </label>
                                                        </div>
                                                        <div class="form-check col-md-6 col-sm-12">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="PM-perscope" value="0" id="PM-perscope">
                                                            <label class="form-check-label" for="PM-perscope">
                                                                {{ __('Per-scope') }}
                                                            </label>
                                                        </div>
                                                        <div class="form-check col-md-6 col-sm-12">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="PM-other" value="0" id="PM-other">
                                                            <label class="form-check-label" for="PM-other">
                                                                {{ __('Other') }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <a href="javascript:void(0)" class="btn btn-primary float-left"
                                                onclick="stepper.previous()">Previous</a>
                                            <button type="submit" class="btn btn-primary float-right">Submit</button>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section('scripts')

<script>
    // BS-Stepper Init
  document.addEventListener('DOMContentLoaded', function () {
    window.stepper = new Stepper(document.querySelector('.bs-stepper'))
  })

    $(document).ready(function () {
        $('.summernote').summernote();
    });
</script>
@endsection
