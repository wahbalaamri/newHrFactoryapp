@extends('layouts.main')
@section('styles')
<link rel="stylesheet" href="{{ asset('dashboard/plugins/bs-stepper/css/bs-stepper.min.css') }}">
@endsection
@section('content')
<div class="container-fluid p-0">
    <div id="page-title" class="text-grey background-overlay "
        style="background-image: url('../assets/img/hrplugin.jpg');background-size: cover;background-repeat: no-repeat;">
        <div>
            <div class="container padding-tb-35px z-index-2 position-relative">
                <div class="row">
                    <div class="col-xl-2">
                        <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 99 98">
                            <defs>
                                <style>
                                    .cls-1 {
                                        fill: #fefefe;
                                        stroke: #fefefe;
                                        stroke-miterlimit: 10;
                                        stroke-width: 0.27px;
                                    }

                                    .cls-2 {
                                        fill: #e4a229;
                                    }

                                    .cls-3 {
                                        fill: #1f1c1d;
                                    }
                                </style>
                            </defs>
                            <title>icon-plugin</title>
                            <path class="cls-1"
                                d="M90,89.5H84.45V79.72h-2.8V89.5H64.91V79.72H62.12V89.5h-5.6V79.69a4.13,4.13,0,0,1,3-4l9-2.7a5.8,5.8,0,0,0,9.58,0l9,2.7a4.11,4.11,0,0,1,3,4Z" />
                            <path class="cls-1"
                                d="M73,70h.2a9.74,9.74,0,0,0,2.83-.44V71a3.55,3.55,0,0,1-2.8,1.8A3.65,3.65,0,0,1,70.47,71V69.59A9.06,9.06,0,0,0,73,70Z" />
                            <path class="cls-1"
                                d="M66.27,57.32a13.21,13.21,0,0,0,4.3-1.23l2.22.75a11.53,11.53,0,0,0,3.41.55h.41a10.2,10.2,0,0,0,3.64-.65v3.44a7,7,0,0,1-7,7H73a6.74,6.74,0,0,1-4.78-2,6.82,6.82,0,0,1-2-4.78Z" />
                            <path class="cls-1"
                                d="M36.34,68.43A8,8,0,0,1,31.6,70h-.24V68.2a10,10,0,0,0,2.87-3.11,16.1,16.1,0,0,0,2.11,3.34Z" />
                            <path class="cls-1"
                                d="M42.54,79.69V89.5H37V79.72H34.16V89.5H17.42V79.72h-2.8V89.5H9V79.69a4.12,4.12,0,0,1,3-4L21,73a6,6,0,0,0,4.77,2.53A6.08,6.08,0,0,0,30.58,73l9,2.7a4.11,4.11,0,0,1,3,4Z" />
                            <path class="cls-1"
                                d="M17.38,65.13a9.43,9.43,0,0,0,2.83,3.07V70H20a8,8,0,0,1-4.74-1.54,16.68,16.68,0,0,0,2.15-3.3Z" />
                            <path class="cls-1"
                                d="M25.77,67.17a7,7,0,0,1-7-7V58.72a13.65,13.65,0,0,0,4.3-1.23,28.56,28.56,0,0,0,8.49,1.3h1.16v1.39a7,7,0,0,1-7,7Z" />
                            <path class="cls-1"
                                d="M28.57,71a3.56,3.56,0,0,1-2.8,1.8A3.67,3.67,0,0,1,23,71v-1.4a10.89,10.89,0,0,0,2.8.41,10.64,10.64,0,0,0,2.8-.41Z" />
                            <path class="cls-1"
                                d="M25.29,49a6.48,6.48,0,0,1,4.61,1.91l.64.65.21.1a3.58,3.58,0,0,1,2,3.27V56H31.6a25.58,25.58,0,0,1-8.18-1.33l-.55-.17-.78.41a11.38,11.38,0,0,1-3.28,1v-.38A6.5,6.5,0,0,1,25.29,49Z" />
                            <path class="cls-1"
                                d="M35.76,35.19l9-2.73A6,6,0,0,0,49.53,35a6.08,6.08,0,0,0,4.78-2.56l9,2.73a4.13,4.13,0,0,1,3,4V49H60.72V39.21h-2.8V49H41.15V39.21h-2.8V49H32.76V39.18a4.12,4.12,0,0,1,3-4Z" />
                            <path class="cls-1"
                                d="M49.53,29.46a9.7,9.7,0,0,0,2.8-.44v1.43a3.56,3.56,0,0,1-2.8,1.78,3.49,3.49,0,0,1-2.79-1.78v-1.4a10.56,10.56,0,0,0,2.79.41Z" />
                            <path class="cls-1"
                                d="M42.54,19.68v-2.8h3.62a5.85,5.85,0,0,0,3.37-1,5.9,5.9,0,0,0,3.38,1h3.61v2.8a7,7,0,0,1-14,0Z" />
                            <path class="cls-1"
                                d="M49.06,8.5a6.49,6.49,0,0,1,4.6,1.9l.61.65.21.1a3.54,3.54,0,0,1,2,2.94H52.91a3.3,3.3,0,0,1-2.39-1l-1-1-1,1a3.35,3.35,0,0,1-2.39,1H42.65A6.49,6.49,0,0,1,49.06,8.5Z" />
                            <path class="cls-1"
                                d="M77.46,50.19a19.19,19.19,0,0,0,4.6,2.29,8.14,8.14,0,0,1-5.45,2.11H76.2a7.8,7.8,0,0,1-2.53-.41l-3.3-1.09-.82.41a10.77,10.77,0,0,1-3,1,7.14,7.14,0,0,1,7-5.46,7.26,7.26,0,0,1,4,1.19Z" />
                            <path class="cls-2"
                                d="M35.32,33.83l10-3V26.91a8.28,8.28,0,0,1-4.2-7.23V16.54A33.55,33.55,0,0,0,16,49a33.93,33.93,0,0,0,1.4,9.58V55.51a7.91,7.91,0,0,1,13.5-5.59l.48.48V39.18a5.58,5.58,0,0,1,4-5.35Z" />
                            <path class="cls-2"
                                d="M64.84,60.42V56h0a8.84,8.84,0,0,1,2.25-5.59H31.33a5.09,5.09,0,0,1,2.79,4.53v3.51a14.3,14.3,0,0,0,4.2,10.13,9.69,9.69,0,0,1-6.75,2.8H29.93l10,3a5.64,5.64,0,0,1,4,5.36v2.38a33.12,33.12,0,0,0,5.59.45A34.1,34.1,0,0,0,55.06,82V79.69a5.63,5.63,0,0,1,4-5.36l10-3V67.55a8.19,8.19,0,0,1-4.2-7.13Z" />
                            <path class="cls-2"
                                d="M57.85,16.54v3.14a8.29,8.29,0,0,1-4.19,7.23v3.95l10,3a5.58,5.58,0,0,1,4,5.35V49.85a8.51,8.51,0,0,1,5.79-2.25A8.65,8.65,0,0,1,78.17,49a17.93,17.93,0,0,0,4.37,2.15l.37.14C83,50.53,83,49.78,83,49A33.55,33.55,0,0,0,57.85,16.54Z" />
                            <path class="cls-3" d="M77.42,67.51l.11-.17s-.07,0-.11.07Z" />
                            <path class="cls-2"
                                d="M77.42,71.37S76,74.16,73.23,74.16,69,71.37,69,71.37l2.79,6.95L69,90.9h8.38L74.63,78.32Z" />
                            <path class="cls-2"
                                d="M29.93,71.37s-1.4,2.79-4.19,2.79-4.2-2.79-4.2-2.79l2.8,6.95L21.54,90.9h8.39l-2.8-12.58Z" />
                            <path class="cls-2"
                                d="M53.66,30.86s-1.36,2.76-4.16,2.76-4.19-2.76-4.19-2.76l2.79,7L45.31,50.4h8.35L50.9,37.82Z" />
                            <path class="cls-3"
                                d="M87.82,73l-9-2.69V68.16a9.71,9.71,0,0,0,4.2-8V55.27a11.27,11.27,0,0,0,2.55-2.69l1-1.53L83,49.85a15.83,15.83,0,0,1-4-2A9.94,9.94,0,0,0,69,47.23v-8a7,7,0,0,0-5-6.68l-9-2.7V27.69a9.72,9.72,0,0,0,4.19-8V14.43a6.37,6.37,0,0,0-3.34-5.66l-.34-.34A9.1,9.1,0,0,0,49,5.7,9.3,9.3,0,0,0,39.71,15v4.67a9.8,9.8,0,0,0,4.2,8V29.8l-9,2.7a6.94,6.94,0,0,0-5,6.68v8.29a9.22,9.22,0,0,0-4.67-1.27A9.32,9.32,0,0,0,16,55.51v3.28a12.12,12.12,0,0,1-3.78,8.79l-1,1,1,1a11,11,0,0,0,3.2,2.18L11.18,73a6.91,6.91,0,0,0-5,6.69V92.3H45.31V79.69a7,7,0,0,0-5-6.69l-4.2-1.26a11.06,11.06,0,0,0,3.18-2.18l1-1-1-1a12.79,12.79,0,0,1-3.79-9.14V54.93a6.52,6.52,0,0,0-.82-3.13H64.47a9.89,9.89,0,0,0-1,4.39v4.23a9.44,9.44,0,0,0,2.8,6.75,13.89,13.89,0,0,0,1.4,1.16v2l-9,2.69a7,7,0,0,0-5,6.69V92.3H92.8V79.69a7,7,0,0,0-5-6.69ZM77.42,50.19A19.18,19.18,0,0,0,82,52.48a8,8,0,0,1-5.42,2.11h-.41a7.78,7.78,0,0,1-2.52-.41l-3.31-1.09-.82.41a10.9,10.9,0,0,1-3.06,1,7.2,7.2,0,0,1,7-5.46,7.31,7.31,0,0,1,4,1.19ZM49,8.5a6.42,6.42,0,0,1,4.57,1.9l.65.65.2.1a3.52,3.52,0,0,1,2,2.94H52.84a3.2,3.2,0,0,1-2.35-1l-1-1-1,1a3.35,3.35,0,0,1-2.39,1H42.58A6.56,6.56,0,0,1,49,8.5ZM42.51,19.68v-2.8h3.61a6,6,0,0,0,3.38-1,5.87,5.87,0,0,0,3.34,1h3.62v2.8a7,7,0,1,1-14,0Zm7,9.78A9.75,9.75,0,0,0,52.3,29v1.43a3.63,3.63,0,0,1-2.8,1.78,3.53,3.53,0,0,1-2.8-1.78v-1.4a10.64,10.64,0,0,0,2.8.41ZM35.73,35.19l9-2.73a5.76,5.76,0,0,0,9.58,0l9,2.73a4.13,4.13,0,0,1,3,4V49H60.65V39.21h-2.8V49H41.11V39.21H38.32V49H32.73V39.18a4.12,4.12,0,0,1,3-4ZM25.26,49a6.46,6.46,0,0,1,4.6,1.91l.65.65.2.1a3.64,3.64,0,0,1,2,3.27V56H31.57a25.64,25.64,0,0,1-8.19-1.33l-.54-.17L22,54.9a10.7,10.7,0,0,1-3.27,1v-.38A6.53,6.53,0,0,1,25.26,49Zm3.27,22a3.53,3.53,0,0,1-2.79,1.8,3.6,3.6,0,0,1-2.8-1.8v-1.4a10.83,10.83,0,0,0,2.8.41,10.56,10.56,0,0,0,2.79-.41Zm-2.79-3.79a7,7,0,0,1-7-7V58.72A13.16,13.16,0,0,0,23,57.49a29,29,0,0,0,8.53,1.3h1.16v1.39a7,7,0,0,1-7,7Zm-8.43-2a9.88,9.88,0,0,0,2.83,3.07V70h-.23a8.15,8.15,0,0,1-4.74-1.54,14.33,14.33,0,0,0,2.14-3.3Zm25.2,14.56V89.5H36.92V79.72h-2.8V89.5H17.35V79.72h-2.8V89.5H9V79.69a4.12,4.12,0,0,1,3-4L21,73a6.07,6.07,0,0,0,4.78,2.53A6,6,0,0,0,30.51,73l9,2.7a4.11,4.11,0,0,1,3,4Zm-6.2-11.26A8.06,8.06,0,0,1,31.57,70h-.24V68.2a9.89,9.89,0,0,0,2.86-3.11,14.63,14.63,0,0,0,2.12,3.34ZM66.24,57.32a13.21,13.21,0,0,0,4.3-1.23l2.21.75a11.53,11.53,0,0,0,3.41.55h.41a10.25,10.25,0,0,0,3.65-.65v3.44a7,7,0,0,1-7,7H73a6.74,6.74,0,0,1-6.75-6.75ZM73,70h.21A9.79,9.79,0,0,0,76,69.53V71a3.08,3.08,0,0,1-5.6,0V69.59A9.11,9.11,0,0,0,73,70ZM90,89.5H84.41V79.72H81.62V89.5H64.84V79.72H62.05V89.5H56.46V79.69a4.15,4.15,0,0,1,3-4l9-2.7A5.76,5.76,0,0,0,78,73l9,2.7a4.15,4.15,0,0,1,3,4Z" />
                            <rect class="cls-3" x="34.81" y="24.62" width="2.8" height="2.8"
                                transform="translate(-8.16 21.59) rotate(-30)" />
                            <rect class="cls-3" x="29.32" y="28.85" width="2.8" height="2.8"
                                transform="translate(-12.39 30.58) rotate(-45)" />
                            <rect class="cls-3" x="25.09" y="34.34" width="2.8" height="2.8"
                                transform="translate(-17.71 40.8) rotate(-60)" />
                            <polygon class="cls-3"
                                points="22.16 43.14 22.87 40.41 25.57 41.16 24.85 43.85 22.16 43.14" />
                            <rect class="cls-3" x="48.1" y="74.16" width="2.8" height="2.76" />
                            <polygon class="cls-3" points="73.4 41.16 76.09 40.41 76.84 43.14 74.12 43.85 73.4 41.16" />
                            <rect class="cls-3" x="71.08" y="34.34" width="2.8" height="2.8"
                                transform="matrix(0.87, -0.5, 0.5, 0.87, -8.16, 41.03)" />
                            <rect class="cls-3" x="66.85" y="28.85" width="2.8" height="2.8"
                                transform="translate(-1.4 57.12) rotate(-45)" />
                            <rect class="cls-3" x="61.37" y="24.62" width="2.8" height="2.8"
                                transform="translate(8.84 67.36) rotate(-60)" />
                            <rect class="cls-3" x="48.1" y="54.59" width="2.8" height="16.77" />
                            <rect class="cls-3" x="53.66" y="54.59" width="2.8" height="2.8" />
                            <rect class="cls-3" x="53.66" y="60.18" width="2.8" height="11.18" />
                            <rect class="cls-3" x="42.51" y="54.59" width="2.8" height="2.8" />
                            <rect class="cls-3" x="42.51" y="60.18" width="2.8" height="11.18" />
                        </svg>
                    </div>
                </div>
                <div class="col-4"></div>
                <div class="col-4">
                    <h3 class="font-weight-700 text-capitalize page-title-tech">Regsiter</h3>
                </div>
                <div class="col-4"></div>
            </div>
        </div>
    </div>

</div>
<div class="container p-3">

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">{{ __('Registration') }}</h3>
                </div>
                <div class="card-body p-0">
                    <form action="{{ route('register.newclient') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="bs-stepper linear">
                            <div class="bs-stepper-header" role="tablist">

                                <div class="step active" data-target="#company">
                                    <button type="button" class="step-trigger" role="tab" aria-controls="company"
                                        id="company-trigger" aria-selected="true">
                                        <span class="bs-stepper-circle">1</span>
                                        <span class="bs-stepper-label">{{ __('Organization info') }}</span>
                                    </button>
                                </div>
                                <div class="line"></div>
                                <div class="step" data-target="#focalpoint">
                                    <button type="button" class="step-trigger" role="tab" aria-controls="focalpoint"
                                        id="focalpoint-trigger" aria-selected="false" disabled="disabled">
                                        <span class="bs-stepper-circle">2</span>
                                        <span class="bs-stepper-label">{{ __('Focal Point Details') }}</span>
                                    </button>
                                </div>
                            </div>
                            <div class="bs-stepper-content">

                                <div id="company" class="content active dstepper-block" role="tabpanel"
                                    aria-labelledby="company-trigger">
                                    {{-- show all errors --}}
                                    @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="list-group">
                                            @foreach ($errors->all() as $error)
                                            <li class="list-group-item"> {{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif
                                    <div class="row">
                                        {{-- company name in English --}}
                                        <div class="form-group col-md-6 col-sm-12">
                                            <label for="company_name_en">{{ __('Organization Name') }}</label>
                                            <input type="text" class="form-control" id="company_name_en"
                                                name="company_name_en" placeholder="Organization Name">
                                            @error('company_name_en')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        {{-- company name in Arabic --}}
                                        {{-- <div class="form-group col-md-6 col-sm-12">
                                            <label for="company_name_ar">{{ __('Company Name (Arabic)') }}</label>
                                            <input type="text" class="form-control" id="company_name_ar"
                                                name="company_name_ar" placeholder="Company Name (Arabic)">
                                            @error('company_name_ar')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div> --}}
                                        {{--select company sector --}}
                                        <div class="form-group col-md-6 col-sm-12">
                                            <label for="company_sector">{{ __('Sector') }}</label>
                                            <select class="form-control" id="company_sector" name="company_sector">
                                                <option value="">{{ __('Select Sector') }}</option>
                                                @foreach ($industries as $industry)
                                                <option value="{{ $industry->id }}">@if(App()->isLocale('en')){{
                                                    $industry->name }} @else {{ $industry->name_ar }} @endif</option>
                                                @endforeach
                                            </select>
                                            @error('company_sector')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        {{-- select company country --}}
                                        <div class="form-group col-md-6 col-sm-12">
                                            <label for="company_country">{{ __('Country') }}</label>
                                            <select class="form-control" id="company_country" name="company_country">
                                                <option value="">{{ __('Select Country') }}</option>
                                                @foreach ($countries as $country)
                                                <option value="{{ $country->id }}">@if(App()->isLocale('en')){{
                                                    $country->name }} @else {{ $country->name_ar }} @endif</option>
                                                @endforeach
                                            </select>
                                            @error('company_country')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        {{-- select company size group --}}
                                        <div class="form-group col-md-6 col-sm-12">
                                            <label for="company_size">{{ __('Size') }}</label>
                                            <select class="form-control" id="company_size" name="company_size">
                                                <option value="">{{ __('Select Size') }}</option>
                                                {{-- KEY VALUE LOOP --}}

                                                @foreach ($numberOfEmployees as $vlue=>$size)
                                                <option value="{{ $vlue }}">{{$size }}</option>
                                                @endforeach
                                            </select>
                                            @error('company_size')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        {{-- company phone number --}}
                                        <div class="form-group col-md-6 col-sm-12">
                                            <label for="phone">{{ __('Phone') }}</label>
                                            <input type="text" class="form-control" id="phone" name="phone"
                                                placeholder="Phone">
                                            @error('phone')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        {{-- logo_path --}}
                                        {{-- <div class="form-group col-md-6 col-sm-12">
                                            <label for="logo_path">{{ __('Company Logo') }}</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="logo_path"
                                                        name="logo_path">
                                                    <label class="custom-file-label" for="logo_path">{{ __('Choose
                                                        file') }}</label>
                                                </div>

                                            </div>
                                            @error('logo_path')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div> --}}
                                        {{-- company webiste --}}
                                        {{-- <div class="form-group col-md-6 col-sm-12">
                                            <label for="website">{{ __('Company Website') }}</label>
                                            <input type="text" class="form-control" id="website" name="website"
                                                placeholder="Company Website">
                                            @error('website')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div> --}}
                                    </div>
                                    <div class="pt-2 pb-4">
                                        <a href="javascript:void(0)" class="btn btn-primary float-end pb-2"
                                            onclick="stepper.next()">{{ __('Next') }}</a>
                                    </div>
                                </div>
                                <div id="focalpoint" class="content" role="tabpanel"
                                    aria-labelledby="focalpoint-trigger">
                                    <div class="row">
                                        {{-- focal point name --}}
                                        <div class="form-group col-md-6 col-sm-12">
                                            <label for="focal_name">{{ __('Focal Point Name') }}</label>
                                            <input type="text" class="form-control" id="focal_name" name="focal_name"
                                                placeholder="Focal Point Name">
                                            @error('focal_name')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        {{-- focal point email --}}
                                        <div class="form-group col-md-6 col-sm-12">
                                            <label for="focal_email">{{ __('Focal Point Email') }}</label>
                                            <input type="email" class="form-control" id="focal_email" name="focal_email"
                                                placeholder="Focal Point Email">
                                            @error('focal_email')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        {{-- focal point phone --}}
                                        <div class="form-group col-md-6 col-sm-12">
                                            <label for="focal_phone">{{ __('Focal Point Phone') }}</label>
                                            <input type="text" class="form-control" id="focal_phone" name="focal_phone"
                                                placeholder="Focal Point Phone">
                                            @error('focal_phone')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        {{--focal point password --}}
                                        <div class="form-group col-md-6 col-sm-12">
                                            <label for="password">{{ __('Create Password') }}</label>
                                            <div class="input-group" dir="ltr">
                                                <input type="password" class="form-control" id="password"
                                                    name="password" placeholder="Focal Point Password">
                                                <button class="btn btn-outline-secondary" type="button"
                                                    id="togglePassword">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                            @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="pt-2 pb-4">
                                        <a href="javascript:void(0)" class="btn btn-primary  float-start"
                                            onclick="stepper.previous()">Previous</a>
                                        <button type="submit" class="btn btn-primary  float-end">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('dashboard/plugins/bs-stepper/js/bs-stepper.min.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
    window.stepper = new Stepper(document.querySelector('.bs-stepper'))
  })
  const passwordInput = document.getElementById('password');
    const togglePasswordButton = document.getElementById('togglePassword');

    togglePasswordButton.addEventListener('click', function() {
      const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordInput.setAttribute('type', type);
      this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
    });
</script>
@endsection