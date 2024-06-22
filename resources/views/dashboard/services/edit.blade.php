@extends('dashboard.layouts.main')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Services</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item active"><a href="{{ route('services.index') }}">{{ __('Service')
                                }}</a> </li>
                        <li class="breadcrumb-item active">{{ __('Create') }}</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            {{-- create new service form --}}
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">{{ 'New Service' }}</h3>
                        </div>
                        <div class="card-body p-0">
                            <form
                                action="{{ $service ? route('services.update', $service->id) : route('services.store') }}"
                                method="post" enctype="multipart/form-data">
                                @csrf
                                @if ($service)
                                @method('PUT')
                                @endif
                                <div class="bs-stepper linear">
                                    <div class="bs-stepper-header" role="tablist">

                                        <div class="step active" data-target="#service-info">
                                            <button type="button" class="step-trigger" role="tab"
                                                aria-controls="service-info" id="service-info-trigger"
                                                aria-selected="true">
                                                <span class="bs-stepper-circle">1</span>
                                                <span class="bs-stepper-label">{{ __('Service info') }}</span>
                                            </button>
                                        </div>
                                        @if (!$service)
                                        <div class="line"></div>
                                        <div class="step" data-target="#Service-Feature">
                                            <button type="button" class="step-trigger" role="tab"
                                                aria-controls="Service-Feature" id="Service-Feature-trigger"
                                                aria-selected="false" disabled="disabled">
                                                <span class="bs-stepper-circle">2</span>
                                                <span class="bs-stepper-label">{{ __('Service Feature') }}</span>
                                            </button>
                                        </div>
                                        <div class="line"></div>
                                        <div class="step" data-target="#Service-Approch">
                                            <button type="button" class="step-trigger" role="tab"
                                                aria-controls="Service-Approch" id="Service-Approch-trigger"
                                                aria-selected="false" disabled="disabled">
                                                <span class="bs-stepper-circle">2</span>
                                                <span class="bs-stepper-label">{{ __('Service Approch') }}</span>
                                            </button>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="bs-stepper-content">

                                        <div id="service-info" class="content active dstepper-block" role="tabpanel"
                                            aria-labelledby="service-info-trigger">
                                            {{-- show all errors --}}
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
                                                        {{-- service name in English --}}
                                                        <div class="form-group col-md-6 col-sm-12">
                                                            <label for="name">{{ __('Service Name (English)') }}</label>
                                                            <input type="text" name="name" id="name"
                                                                class="form-control"
                                                                placeholder="{{ __('Service Name in English') }}"
                                                                value="{{ old('name', $service ? $service->name : '') }}">
                                                            {{-- validation --}}
                                                            @error('name')
                                                            <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        {{-- service name in Arabic --}}
                                                        <div class="form-group col-md-6 col-sm-12">
                                                            <label for="name_ar">{{ __('Service Name (Arabic)')
                                                                }}</label>
                                                            <input type="text" name="name_ar" id="name_ar"
                                                                class="form-control"
                                                                placeholder="{{ __('Service Name in Arabic') }}"
                                                                value="{{ old('name_ar', $service ? $service->name_ar : '') }}">
                                                            {{-- validation --}}
                                                            @error('name_ar')
                                                            <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        {{-- service slug in English --}}
                                                        <div class="form-group col-md-6 col-sm-12">
                                                            <label for="slug">{{ __('Service Slug (English)') }}</label>
                                                            <input type="text" name="slug" id="slug"
                                                                class="form-control"
                                                                placeholder="{{ __('Service Slug in English') }}"
                                                                value="{{ old('slug', $service ? $service->slug : '') }}">
                                                            {{-- validation --}}
                                                            @error('slug')
                                                            <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        {{-- service slug in Arabic --}}
                                                        <div class="form-group col-md-6 col-sm-12">
                                                            <label for="slug_ar">{{ __('Service Slug (Arabic)')
                                                                }}</label>
                                                            <input type="text" name="slug_ar" id="slug_ar"
                                                                class="form-control"
                                                                placeholder="{{ __('Service Slug in Arabic') }}"
                                                                value="{{ old('slug_ar', $service ? $service->slug_ar : '') }}">
                                                            {{-- validation --}}
                                                            @error('slug_ar')
                                                            <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group col-md-6 col-sm-12">
                                                            <label for="public_availability">{{ __('Service
                                                                Availability') }}
                                                                {{ __('public') }} /{{ __('private') }}</label>
                                                            <div class="col-12">
                                                                <input type="checkbox" name="public_availability"
                                                                @if($service) @checked($service->public_availability)
                                                                @else checked @endif
                                                                data-bootstrap-switch="" data-off-color="danger"
                                                                data-on-color="success" value="1">
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-6 col-sm-12">
                                                            <label for="candidate_raters_model">
                                                                {{ __('Candidate Raters Model') }}
                                                            <div class="col-12">
                                                                <input type="checkbox" name="candidate_raters_model"
                                                                @if($service) @checked($service->candidate_raters_model)
                                                                 @endif
                                                                data-bootstrap-switch="" data-off-color="danger"
                                                                data-on-color="success" value="1">
                                                            </div>
                                                        </div>
                                                        {{-- service description in English --}}
                                                        <div class="form-group col-md-6 col-sm-12">
                                                            <label for="description">{{ __('Service Description
                                                                (English)') }}</label>
                                                            <textarea name="description" id="description"
                                                                class="form-control summernote"
                                                                placeholder="{{ __('Service Description in English') }}">{{ old('description', $service ? $service->description : '') }}</textarea>
                                                            {{-- validation --}}
                                                            @error('description')
                                                            <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        {{-- service description in Arabic --}}
                                                        <div class="form-group col-md-6 col-sm-12">
                                                            <label for="description_ar">{{ __('Service Description
                                                                (Arabic)') }}</label>
                                                            <textarea name="description_ar" id="description_ar"
                                                                class="form-control summernote"
                                                                placeholder="{{ __('Service Description in Arabic') }}">{{ old('description_ar', $service ? $service->description_ar : '') }}</textarea>
                                                            {{-- validation --}}
                                                            @error('description_ar')
                                                            <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        {{-- service Objectives in English --}}
                                                        <div class="form-group col-md-6 col-sm-12">
                                                            <label for="objectives">{{ __('Service Objectives
                                                                (English)') }}</label>
                                                            <textarea name="objectives" id="objectives"
                                                                class="form-control summernote"
                                                                placeholder="{{ __('Service Objectives in English') }}">{{ old('objectives', $service ? $service->objective : '') }}</textarea>
                                                            {{-- validation --}}
                                                            @error('objectives')
                                                            <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        {{-- service Objectives in Arabic --}}
                                                        <div class="form-group col-md-6 col-sm-12">
                                                            <label for="objectives_ar">{{ __('Service Objectives
                                                                (Arabic)') }}</label>
                                                            <textarea name="objectives_ar" id="objectives_ar"
                                                                class="form-control summernote"
                                                                placeholder="{{ __('Service Objectives in Arabic') }}">{{ old('objectives_ar', $service ? $service->objective_ar : '') }}</textarea>
                                                            {{-- validation --}}
                                                            @error('objectives_ar')
                                                            <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        {{-- service valid in country --}}
                                                        <div class="form-group col-md-6 col-sm-12">
                                                            <label for="valid_in">{{ __('Service Valid In') }}</label>
                                                            <select name="valid_in" id="valid_in" class="form-control">
                                                                <option value="">{{ __('Select Country') }}
                                                                </option>

                                                                <optgroup label="{{ __('Arab Countries') }}">
                                                                    @foreach ($countries[1] as $country)
                                                                    <option value="{{ $country->id }}"
                                                                        @if(old('valid_in', $service ? $service->country :
                                                                        null) == $country->id) selected @endif>
                                                                        {{ $country->name }}
                                                                    </option>
                                                                    @endforeach
                                                                </optgroup>
                                                                <optgroup label="{{ __('Other') }}">
                                                                    @foreach ($countries[0] as $country)
                                                                    <option value="{{ $country->id }}"
                                                                        @if(old('valid_in', $service ? $service->country :
                                                                        null) == $country->id) selected @endif>
                                                                        {{ $country->name }}
                                                                    </option>
                                                                    @endforeach
                                                                </optgroup>
                                                            </select>
                                                            {{-- validation --}}
                                                            @error('valid_in')
                                                            <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        {{-- service type --}}
                                                        <div class="form-group col-md-6 col-sm-12">
                                                            <label for="type">{{ __('Service Type') }}</label>
                                                            <select name="type" id="type" class="form-control">
                                                                <option value="">{{ __('Select Service Type') }}
                                                                </option>
                                                                <option value="1" @if (old('type', $service ? $service->
                                                                    service_type : null) == '1') selected @endif>
                                                                    {{ __('Manual Builder') }}</option>
                                                                <option value="2" @if (old('type', $service ? $service->
                                                                    service_type : null) == '2') selected @endif>
                                                                    {{ __('Files') }}</option>
                                                                <option value="3" @if (old('type', $service ? $service->
                                                                    service_type : null) == '3') selected @endif>
                                                                    {{ __('Employee Engagment') }}
                                                                </option>
                                                                <option value="4" b @if (old('type', $service ?
                                                                    $service->service_type : null) == '4') selected
                                                                    @endif>
                                                                    {{ __('HR Diagnosis') }}</option>
                                                                <option value="5" @if (old('type', $service ? $service->
                                                                    service_type : null) == '5') selected @endif>
                                                                    {{ __('360 Review') }}</option>
                                                                @if ($clients > 0)
                                                                <option value="6" @if (old('type', $service ? $service->
                                                                    service_type : null) == '6') selected @endif>
                                                                    {{ __('360 Review - Nama') }}</option>
                                                                <option value="7" @if (old('type', $service ? $service->
                                                                    service_type : null) == '7') selected @endif>
                                                                    {{ __('Customized surveys') }}</option>
                                                                @endif
                                                                <option value="8" @if (old('type', $service ? $service->
                                                                    service_type : null) == '8') selected @endif>
                                                                    {{ __('Chat-bot') }}</option>
                                                                <option value="9" @if (old('type', $service ? $service->
                                                                    service_type : null) == '9') selected @endif>
                                                                    {{ __('Calculator') }}</option>
                                                            </select>
                                                            {{-- validation --}}
                                                            @error('type')
                                                            <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        {{-- service image --}}
                                                        <div class="form-group col-md-6 col-sm-12">
                                                            @if ($service)
                                                            <div class="col-12">
                                                                <img src="{{ asset('uploads/services/images/' . $service->service_media_path) }}"
                                                                    class="img-thumbnail" height="100" width="100"
                                                                    alt="{{ $service->name }}">
                                                            </div>
                                                            @endif
                                                            <label for="image">{{ __('Service Image') }}</label>
                                                            <input type="file" name="image" id="image"
                                                                class="form-control">
                                                            {{-- validation --}}
                                                            @error('image')
                                                            <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        {{-- service icon --}}
                                                        <div class="form-group col-md-6 col-sm-12">
                                                            @if ($service)
                                                            <div class="col-12">
                                                                <img src="{{ asset('uploads/services/icons/' . $service->service_icon) }}"
                                                                    class="img-thumbnail" height="100" width="100"
                                                                    alt="{{ $service->name }}">
                                                            </div>
                                                            @endif
                                                            <label for="service_icon">{{ __('Service Icon') }}</label>
                                                            <input type="file" name="service_icon" id="service_icon"
                                                                class="form-control">
                                                            {{-- validation --}}
                                                            @error('service_icon')
                                                            <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        {{-- service framework video --}}
                                                        {{-- switch upload or youtube --}}
                                                        <div class="form-group col-md-8 col-sm-12">
                                                            <label for="framework_video">{{ __('Service Framework
                                                                Video') }}
                                                                {{ __('Upload') }} <i class="fa fa-upload"></i>/{{
                                                                __('YouTube') }} <i class="fa fa-youtube"></i></label>
                                                            <div class="col-12 text-center">
                                                                <input type="checkbox" name="Framework_video_type"
                                                                @if($service) @checked($service->FW_uploaded_video)
                                                                @else checked @endif
                                                                data-bootstrap-switch="" data-off-color="danger"
                                                                data-on-color="success" value="1">
                                                            </div>
                                                            <div class="row">
                                                                <div id="uploadVideo"
                                                                    class="w-100 @error('youtube_link') d-none @enderror">
                                                                    <div class="form-group col-md-12 col-sm-12">
                                                                        <label for="framework_video">{{ __('Upload
                                                                            Video') }}</label>
                                                                        <input type="file" name="framework_video"
                                                                            id="framework_video" class="form-control">
                                                                        {{-- validation --}}
                                                                        @error('framework_video')
                                                                        <span class="text-danger">{{ $message }}</span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div id="youtubeVideo"
                                                                    class="@error('youtube_link') @else d-none @enderror w-100 text-center mt-3">
                                                                    {{-- preview youtube in iframe --}}
                                                                    <iframe
                                                                        src="@if ($service) {{ $service->framework_media_path }} @endif"
                                                                        id="previewYouTube" @class(['d-none'=>
                                                                        !$service])
                                                                        frameborder="0"></iframe>
                                                                    <div class="form-group col-md-12 col-sm-12">
                                                                        <label for="youtube_link">{{ __('YouTube Video
                                                                            Link') }}</label>
                                                                        <textarea name="youtube_link" id="youtube_link"
                                                                            class="form-control"
                                                                            placeholder="{{ __('YouTube Video Link') }}"
                                                                            rows="5">{{ old('youtube_link') }}</textarea>
                                                                        {{-- hidden input for url --}}
                                                                        <input type="hidden" name="youtube_url"
                                                                            id="youtube_url"
                                                                            value="{{ old('youtube_url', $service ? $service->framework_media_path : '') }}">
                                                                        {{-- btnGetYouTube URL --}}
                                                                        <button type="button"
                                                                            class="btn btn-primary float-right mt-2"
                                                                            id="btnGetYouTubeURL">{{ __('Get YouTube
                                                                            Video') }}</button>
                                                                        {{-- validation --}}
                                                                        @error('youtube_link')
                                                                        <span class="text-danger">{{ $message }}</span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{-- service framework video Arabic --}}
                                                        {{-- switch upload or youtube --}}
                                                        <div class="form-group col-md-8 col-sm-12">
                                                            <label for="framework_video">{{ __('Arabic Service Framework
                                                                Video') }}
                                                                {{ __('Upload') }} <i class="fa fa-upload"></i>/{{
                                                                __('YouTube') }} <i class="fa fa-youtube"></i></label>
                                                            <div class="col-12 text-center">
                                                                <input type="checkbox" name="Framework_video_type_ar"
                                                                    @if ($service)
                                                                    @checked($service->FW_uploaded_video_ar)
                                                                @else checked @endif
                                                                data-bootstrap-switch="" data-off-color="danger"
                                                                data-on-color="success" value="1">
                                                            </div>
                                                            <div class="row">
                                                                <div id="uploadVideoAr"
                                                                    class="w-100 @error('youtube_link_ar') d-none @enderror">
                                                                    <div class="form-group col-md-12 col-sm-12">
                                                                        <label for="framework_video_ar">{{ __('Upload
                                                                            Video') }}</label>
                                                                        <input type="file" name="framework_video_ar"
                                                                            id="framework_video_ar"
                                                                            class="form-control">
                                                                        {{-- validation --}}
                                                                        @error('framework_video_ar')
                                                                        <span class="text-danger">{{ $message }}</span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div id="youtubeVideo_ar"
                                                                    class="@error('youtube_link_ar') @else d-none @enderror w-100 text-center mt-3">
                                                                    {{-- preview youtube in iframe --}}
                                                                    <iframe
                                                                        src="@if ($service) {{ $service->framework_media_path_ar }} @endif"
                                                                        id="previewYouTubeAr" @class(['d-none'=>
                                                                        !$service])
                                                                        frameborder="0"></iframe>
                                                                    <div class="form-group col-md-12 col-sm-12">
                                                                        <label for="youtube_link_ar">{{ __('YouTube
                                                                            Video Link') }}</label>
                                                                        <textarea name="youtube_link_ar"
                                                                            id="youtube_link_ar" class="form-control"
                                                                            placeholder="{{ __('YouTube Video Link') }}"
                                                                            rows="5">{{ old('youtube_link_ar') }}</textarea>
                                                                        {{-- hidden input for url --}}
                                                                        <input type="hidden" name="youtube_url_ar"
                                                                            id="youtube_url_ar"
                                                                            value="{{ old('youtube_url_ar', $service ? $service->framework_media_path_ar : '') }}">
                                                                        {{-- btnGetYouTube URL --}}
                                                                        <button type="button"
                                                                            class="btn btn-primary float-right mt-2"
                                                                            id="btnGetYouTubeURLAr">{{ __('Get YouTube
                                                                            Video') }}</button>
                                                                        {{-- validation --}}
                                                                        @error('youtube_link_ar')
                                                                        <span class="text-danger">{{ $message }}</span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @if ($service)
                                            <button type="submit" class="btn btn-primary float-right">Submit</button>
                                            @else
                                            <a href="javascript:void(0);" class="btn btn-primary float-right"
                                                onclick="stepper.next()">Next</a>
                                            @endif
                                        </div>
                                        @if (!$service)
                                        <div id="Service-Feature" class="content" role="tabpanel"
                                            aria-labelledby="Service-Feature-trigger">
                                            <div class="row justify-content-center">
                                                <div class="w-75">
                                                    <div class="row">
                                                        {{-- input text for service Featuer in English --}}
                                                        <div class="form-group col-md-4 col-sm-12">
                                                            <label for="feature">{{ __('Service Feature (English)')
                                                                }}</label>
                                                            <input type="text" name="feature[]" id="feature"
                                                                class="form-control"
                                                                placeholder="{{ __('Service Feature in English') }}"
                                                                value="{{ old('feature[]') }}">
                                                            {{-- validation --}}
                                                            @error('feature')
                                                            <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        {{-- input text for service Featuer in Arabic --}}
                                                        <div class="form-group col-md-4 col-sm-12">
                                                            <label for="feature_ar">{{ __('Service Feature (Arabic)')
                                                                }}</label>
                                                            <input type="text" name="feature_ar[]" id="feature_ar"
                                                                class="form-control"
                                                                placeholder="{{ __('Service Feature in Arabic') }}"
                                                                value="{{ old('feature_ar[]') }}">
                                                            {{-- validation --}}
                                                            @error('feature_ar')
                                                            <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        {{-- btn add more feature --}}
                                                        <div class="form-group col-md-2 col-sm-12">
                                                            <label for="addFeature">{{ __('Add More Feature') }}</label>
                                                            <a href="javascript:void(0);"
                                                                class="btn btn-primary form-control" id="addFeature">{{
                                                                __('Add') }}</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <a href="javascript:void(0);" class="btn btn-primary"
                                                onclick="stepper.previous()">Previous</a>
                                            <a href="javascript:void(0);" class="btn btn-primary float-right"
                                                onclick="stepper.next()">Next</a>
                                        </div>
                                        <div id="Service-Approch" class="content" role="tabpanel"
                                            aria-labelledby="Service-Approch-trigger">
                                            <div class="row justify-content-center">
                                                <div class="w-75">
                                                    <div class="row">
                                                        {{-- input text for service approach in English --}}
                                                        <div class="form-group col-md-4 col-sm-12">
                                                            <label for="approach">{{ __('Service Approach (English)')
                                                                }}</label>
                                                            <textarea name="approach[]" id="approach"
                                                                class="form-control summernote"
                                                                placeholder="{{ __('Service Approach in English') }}">{{ old('approach[]') }}</textarea>
                                                            {{-- validation --}}
                                                            @error('approach')
                                                            <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        {{-- input text for service approach in Arabic --}}
                                                        <div class="form-group col-md-4 col-sm-12">
                                                            <label for="approach_ar">{{ __('Service Approach (Arabic)')
                                                                }}</label>
                                                            <textarea name="approach_ar[]" id="approach_ar"
                                                                class="form-control summernote"
                                                                placeholder="{{ __('Service Approach in Arabic') }}">{{ old('approach_ar[]') }}</textarea>
                                                            {{-- validation --}}
                                                            @error('approach_ar')
                                                            <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        {{-- upload approach icon --}}
                                                        <div class="form-group col-md-2 col-sm-12">
                                                            <label for="icon">{{ __('Approach Icon') }}</label>
                                                            <input type="file" name="icon[]" id="icon"
                                                                class="form-control">
                                                            {{-- validation --}}
                                                            @error('icon')
                                                            <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        {{-- btn add more approach --}}
                                                        <div class="form-group col-md-2 col-sm-12">
                                                            <label for="addApproach">{{ __('Add More Approach')
                                                                }}</label>
                                                            <a href="javascript:void(0);"
                                                                class="btn btn-primary form-control" id="addApproach">{{
                                                                __('Add') }}</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <a href="javascript:void(0);" class="btn btn-primary"
                                                onclick="stepper.previous()">Previous</a>
                                            <button type="submit" class="btn btn-primary float-right">Submit</button>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>
</div>
@endsection
@section('scripts')
<script>
    // BS-Stepper Init
        document.addEventListener('DOMContentLoaded', function() {
            window.stepper = new Stepper(document.querySelector('.bs-stepper'))
        })

        $(document).ready(function() {


            $('.summernote').summernote();

            $("[name='Framework_video_type']").bootstrapSwitch();
            $("[name='Framework_video_type_ar']").bootstrapSwitch();
            $("[name='public_availability']").bootstrapSwitch();
            $("[name='candidate_raters_model']").bootstrapSwitch();

            //initialize the switch
            //bootstrap-switch-handle-on change text to 1
            $(".bootstrap-switch-handle-on").text("Upload Video");
            $(".bootstrap-switch-handle-on").css('width', "139px");
            //bootstrap-switch-handle-off change text to 0
            $(".bootstrap-switch-handle-off").text("From Youtube");
            $(".bootstrap-switch-handle-off").css('width', "139px");
            //bootstrap-switch-container parent class set width to 100%
            $(".bootstrap-switch-container").parent().css("width", "183px");
            $(".bootstrap-switch-container").css("width", "323px");

            //get parent of public_availability
            let parent = $("[name='public_availability']").parent();
            //get child of parent with class bootstrap-switch-handle-on
            let child = parent.find(".bootstrap-switch-handle-on");
            //change text of child to "Yes"
            child.text("Available for public");
            child.css('width', "204px");
            //get child of parent with class bootstrap-switch-handle-off
            child = parent.find(".bootstrap-switch-handle-off");
            child.css('width', "204px");
            //change text of child to "Not Available for public"
            child.text("Not Available for public");
            //get parent of parent
            parent.parent().css("width", "187px");
            parent.css("width", "338px")
            //get parent of public_availability
            let parent1 = $("[name='candidate_raters_model']").parent();
            //get child of parent with class bootstrap-switch-handle-on
            let child1 = parent1.find(".bootstrap-switch-handle-on");
            //change text of child to "Yes"
            child1.text("Candidate Raters Model");
            child1.css('width', "204px");
            //get child of parent with class bootstrap-switch-handle-off
            child1 = parent1.find(".bootstrap-switch-handle-off");
            child1.css('width', "204px");
            //change text of child to "Not Available for public"
            child1.text("Respondents Model");
            //get parent of parent
            parent1.parent().css("width", "187px");
            parent1.css("width", "346px")
            CandidateRatersModelChange();
            hasService = "{{ $service ? true : false }}";
            if (hasService) {
                FrameworkVideoTypeChange();
                FrameworkVideoTypeArChange();
            }
            //btnGetYouTubeURL click
            $("#btnGetYouTubeURL").click(function() {
                //get youtube link value
                let value = $("#youtube_link").val();
                //if value is empty
                if (value == "") {
                    //show alert
                    alert("Please enter youtube link");
                    return;
                }
                //get youtube video url
                let finalUrl = getUrl(value);
                //set youtube url to hidden input
                $("#youtube_url").val(finalUrl);
                //set iframe src to finalUrl
                $("#previewYouTube").attr("src", finalUrl);
                //show iframe
                $("#previewYouTube").removeClass("d-none");
            });
            //btnGetYouTubeURLAr click
            $("#btnGetYouTubeURLAr").click(function() {
                //get youtube link value
                let value = $("#youtube_link_ar").val();
                //if value is empty
                if (value == "") {
                    //show alert
                    alert("Please enter youtube link");
                    return;
                }
                let finalUrl = getUrl(value);
                //set youtube url to hidden input
                $("#youtube_url_ar").val(finalUrl);
                //set iframe src to finalUrl
                $("#previewYouTubeAr").attr("src", finalUrl);
                //show iframe
                $("#previewYouTubeAr").removeClass("d-none");
            });

            function getUrl(value) {
                let finalUrl = "";
                if (value.includes('iframe')) {
                    valueArry = value.split(' ');
                    console.log(valueArry);
                    //get youtube video url
                    finalUrl = valueArry[getindex(valueArry, 'src')];
                    finalUrl = finalUrl.replace('src="', '');
                    finalUrl = finalUrl.replace('"', '');
                    console.log(finalUrl);
                } else {
                    valueArry = value.split("\"");
                    finalUrl = valueArry[getindex(valueArry, 'http')]
                }
                return finalUrl;
            }

            function getindex(MainString, SubString) {
                for (i = 0; i < MainString.length; i++) {
                    if (MainString[i].includes(SubString)) {
                        return i;
                    }
                }
            }
        });
        //add more feature
        $("#addFeature").click(function() {
            div = $("#addFeature").parent().parent();
            //add new row
            div.append(
                '<div class="form-group col-md-4 col-sm-12"><label for="feature">{{ __('Service Feature (English)') }}</label><input type="text" name="feature[]" id="feature" class="form-control" placeholder="{{ __('Service Feature in English') }}"></div><div class="form-group col-md-4 col-sm-12"><label for="feature_ar">{{ __('Service Feature (Arabic)') }}</label><input type="text" name="feature_ar[]" id="feature_ar" class="form-control" placeholder="{{ __('Service Feature in Arabic') }}"></div>' +
                '<div class="form-group col-md-2 col-sm-12"><label for="removeFeature">{{ __('Remove Feature') }}</label><a href="javascript:void(0);" class="btn btn-danger form-control" id="removeFeature" onclick="removethis(this)">{{ __('Remove') }}</a></div>'
            );
        });
        //removethis(this)
        function removethis(e) {
            $(e).parent().prev().remove();
            $(e).parent().prev().remove();
            $(e).parent().remove();
        }

        function removeApproach(e) {
            $(e).parent().prev().remove();
            $(e).parent().prev().remove();
            $(e).parent().prev().remove();
            $(e).parent().remove();
        }
        //add more approach
        $("#addApproach").click(function() {
            //check if the length of the icon is greater than 2
            console.log($("[name='icon[]']").length);
            if ($("[name='icon[]']").length > 2) {
                //show alert
                alert("You can't add more than 3 approaches");
                return;
            }
            div = $("#addApproach").parent().parent();
            //add new row
            div.append(
                '<div class="form-group col-md-4 col-sm-12"><label for="approach">{{ __('Service Approach (English)') }}</label><textarea name="approach[]" id="approach" class="form-control summernote" placeholder="{{ __('Service Approach in English') }}"></textarea></div><div class="form-group col-md-4 col-sm-12"><label for="approach_ar">{{ __('Service Approach (Arabic)') }}</label><textarea name="approach_ar[]" id="approach_ar" class="form-control summernote" placeholder="{{ __('Service Approach in Arabic') }}"></textarea></div>' +
                '<div class="form-group col-md-2 col-sm-12"><label for="icon">{{ __('Approach Icon') }}</label><input type="file" name="icon[]" id="icon" class="form-control"></div><div class="form-group col-md-2 col-sm-12"><label for="removeApproach">{{ __('Remove Approach') }}</label><a href="javascript:void(0);" class="btn btn-danger form-control" id="removeApproach" onclick="removeApproach(this)">{{ __('Remove') }}</a></div>'
            );
        });
        $("[name='candidate_raters_model']").on('switchChange.bootstrapSwitch', function(event, state) {
            //if switch is on
            CandidateRatersModelChange();
        });
        $("[name='public_availability']").on('switchChange.bootstrapSwitch', function(event, state) {
            //if switch is on
            PublicAvailabilityChange();
        });
        //on Framework_video_type switch change
        $("[name='Framework_video_type']").on('switchChange.bootstrapSwitch', function(event, state) {
            //if switch is on
            FrameworkVideoTypeChange();
        });
        //on Framework_video_type_ar switch change
        $("[name='Framework_video_type_ar']").on('switchChange.bootstrapSwitch', function(event, state) {
            FrameworkVideoTypeArChange();
        });
        FrameworkVideoTypeChange = () => {
            //check if Framework_video_type is checked
            state = $("[name='Framework_video_type']").is(":checked");
            if (state == true) {
                //set left-margin to 0px
                $("[name='Framework_video_type']").parent().css("margin-left", "0px");
                //show upload video div
                $("#uploadVideo").removeClass("d-none");
                //hide youtube video div
                $("#youtubeVideo").addClass("d-none");
                //change value of Framework_video_type to 1
                $("[name='Framework_video_type']").val(1);
                //change value of youtube_url to null
                $("[name='youtube_url']").val("");
                //set iframe src to null
                $("#previewYouTube").attr("src", "");
                //hide iframe
                $("#previewYouTube").addClass("d-none");
            } else {
                //set left-margin to -68px
                $("[name='Framework_video_type']").parent().css("margin-left", "-139px");
                //hide upload video div
                $("#uploadVideo").addClass("d-none");
                //show youtube video div
                $("#youtubeVideo").removeClass("d-none");
                //change value of Framework_video_type to 0
                $("[name='Framework_video_type']").val(0);
                //remove selected file
                $("#framework_video").val("");
            }
        }
        FrameworkVideoTypeArChange = () => {
            //check if Framework_video_type is checked
            state = $("[name='Framework_video_type_ar']").is(":checked");
            //if switch is on
            if (state == true) {
                //set left-margin to 0px
                $("[name='Framework_video_type_ar']").parent().css("margin-left", "0px");
                //show upload video div
                $("#uploadVideoAr").removeClass("d-none");
                //hide youtube video div
                $("#youtubeVideo_ar").addClass("d-none");
                //change value of Framework_video_type to 1
                $("[name='Framework_video_type_ar']").val(1);
                //change value of youtube_url_ar to null
                $("[name='youtube_url_ar']").val("");
                //set iframe src to null
                $("#previewYouTubeAr").attr("src", "");
                //hide iframe
                $("#previewYouTubeAr").addClass("d-none");
            } else {
                //set left-margin to -68px
                $("[name='Framework_video_type_ar']").parent().css("margin-left", "-139px");
                //hide upload video div
                $("#uploadVideoAr").addClass("d-none");
                //show youtube video div
                $("#youtubeVideo_ar").removeClass("d-none");
                //change value of Framework_video_type to 0
                $("[name='Framework_video_type_ar']").val(0);
                //remove selected file
                $("#framework_video_ar").val("");
            }
        }
        PublicAvailabilityChange = () => {
            //check if public_availability is checked
            state = $("[name='public_availability']").is(":checked");
            //if switch is on
            if (state == true) {
                //set left-margin to 0px
                $("[name='public_availability']").parent().css("margin-left", "0px");
                //show public availability div
                $("#publicAvailability").removeClass("d-none");
                //change value of public_availability to 1
                $("[name='public_availability']").val(1);
            } else {
                //set left-margin to -68px
                $("[name='public_availability']").parent().css("margin-left", "-152px");
                //hide public availability div
                $("#publicAvailability").addClass("d-none");
                //change value of public_availability to 0
                $("[name='public_availability']").val(0);
            }
        }
        CandidateRatersModelChange = () => {
            //check if candidate_raters_model is checked
            state = $("[name='candidate_raters_model']").is(":checked");
            //if switch is on
            if (state == true) {
                //set left-margin to 0px
                $("[name='candidate_raters_model']").parent().css("margin-left", "0px");
                //show candidate raters model div
                $("#candidateRatersModel").removeClass("d-none");
                //change value of candidate_raters_model to 1
                $("[name='candidate_raters_model']").val(1);
            } else {
                //set left-margin to -68px
                $("[name='candidate_raters_model']").parent().css("margin-left", "-157px");
                //hide candidate raters model div
                $("#candidateRatersModel").addClass("d-none");
                //change value of candidate_raters_model to 0
                $("[name='candidate_raters_model']").val(0);
            }
        }
</script>
@endsection
