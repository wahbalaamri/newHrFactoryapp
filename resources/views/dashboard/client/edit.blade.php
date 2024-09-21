@extends('dashboard.layouts.main')
@section('styles')
<link rel="stylesheet" href="{{ asset('dashboard/plugins/bs-stepper/css/bs-stepper.min.css') }}">
@endsection
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard </li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('Add New Client') }}</h3>
                            {{-- card tool --}}
                            <div class="card-tools">
                                <a href="{{ route('clients.index') }}" class="btn btn-tool">
                                    <i class="fa fa-arrow-left"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <form action="{{ route('clients.store') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="bs-stepper linear">
                                    <div class="bs-stepper-header" role="tablist">

                                        <div class="step active" data-target="#company">
                                            <button type="button" class="step-trigger" role="tab"
                                                aria-controls="company" id="company-trigger" aria-selected="true">
                                                <span class="bs-stepper-circle">1</span>
                                                <span class="bs-stepper-label">{{ __('Organization info') }}</span>
                                            </button>
                                        </div>
                                        <div class="line"></div>
                                        <div class="step" data-target="#focalpoint">
                                            <button type="button" class="step-trigger" role="tab"
                                                aria-controls="focalpoint" id="focalpoint-trigger" aria-selected="false"
                                                disabled="disabled">
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
                                                    <label for="company_name_ar">{{ __('Company Name (Arabic)')
                                                        }}</label>
                                                    <input type="text" class="form-control" id="company_name_ar"
                                                        name="company_name_ar" placeholder="Company Name (Arabic)">
                                                    @error('company_name_ar')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div> --}}
                                                {{-- select company sector --}}
                                                <div class="form-group col-md-6 col-sm-12">
                                                    <label for="company_sector">{{ __('Sector') }}</label>
                                                    <select class="form-control" id="company_sector"
                                                        name="company_sector">
                                                        <option value="">{{ __('Select Sector') }}</option>
                                                        @foreach ($industries as $industry)
                                                        <option value="{{ $industry->id }}">
                                                            @if (App()->isLocale('en'))
                                                            {{ $industry->name }}
                                                            @else
                                                            {{ $industry->name_ar }}
                                                            @endif
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                    @error('company_sector')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                {{-- select company country --}}
                                                <div class="form-group col-md-6 col-sm-12">
                                                    <label for="company_country">{{ __('Country') }}</label>
                                                    <select class="form-control" id="company_country"
                                                        name="company_country">
                                                        <option value="">{{ __('Select Country') }}</option>
                                                        @foreach ($countries as $country)
                                                        <option value="{{ $country->id }}">
                                                            @if (App()->isLocale('en'))
                                                            {{ $country->name }}
                                                            @else
                                                            {{ $country->name_ar }}
                                                            @endif
                                                        </option>
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

                                                        @foreach ($numberOfEmployees as $vlue => $size)
                                                        <option value="{{ $vlue }}">{{ $size }}</option>
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

                                            </div>
                                            <div class="pt-2 pb-4">
                                                <a href="javascript:void(0)" @class(['btn btn-primary btn-sm
                                                    pb-2', 'float-right'=> app()->isLocale('en'), 'float-left' =>
                                                    app()->isLocale('ar')])
                                                    onclick="stepper.next()">{{ __('Next') }}</a>
                                            </div>
                                        </div>
                                        <div id="focalpoint" class="content" role="tabpanel"
                                            aria-labelledby="focalpoint-trigger">
                                            <div class="row">
                                                {{-- focal point name --}}
                                                <div class="form-group col-md-6 col-sm-12">
                                                    <label for="focal_name">{{ __('Focal Point Name') }}</label>
                                                    <input type="text" class="form-control" id="focal_name"
                                                        name="focal_name" placeholder="Focal Point Name">
                                                    @error('focal_name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                {{-- focal point email --}}
                                                <div class="form-group col-md-6 col-sm-12">
                                                    <label for="focal_email">{{ __('Focal Point Email') }}</label>
                                                    <input type="email" class="form-control" id="focal_email"
                                                        name="focal_email" placeholder="Focal Point Email">
                                                    @error('focal_email')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                {{-- focal point phone --}}
                                                <div class="form-group col-md-6 col-sm-12">
                                                    <label for="focal_phone">{{ __('Focal Point Phone') }}</label>
                                                    <input type="text" class="form-control" id="focal_phone"
                                                        name="focal_phone" placeholder="Focal Point Phone">
                                                    @error('focal_phone')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                @if ($terms)
                                                <div class="form-group col-md-6 col-sm-12">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="terms_condtions_box">
                                                        <label class="form-check-label" for="terms_condtions_box">
                                                            {{ __('I viewed and I agree to') }} <a
                                                                href="javascript:void(0)"
                                                                data-target="#terms_conditions_modal"
                                                                data-toggle="modal">{{ 'terms & conditions' }}</a>
                                                        </label>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                            <div class="pt-2 pb-4">
                                                <a href="javascript:void(0)" @class(['btn btn-primary
                                                    btn-sm', 'float-left'=> app()->isLocale('en'), 'float-right' =>
                                                    app()->isLocale('ar')])
                                                    onclick="stepper.previous()">{{ __('Previous') }}</a>
                                                <button type="submit" @class(['btn btn-primary btn-sm', 'float-right'=>
                                                    app()->isLocale('en'), 'float-left' => app()->isLocale('ar')])
                                                    @disabled($terms !=null)>{{ __('Submit') }}</button>
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

    </section>
</div>
<div class="modal fade" id="terms_conditions_modal" tabindex="-1" aria-labelledby="terms_conditions_modalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="terms_conditions_modalLabel">{{ __('Terms & Conditions') }}</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <h5>{{ $terms->title }}</h5>
                {!! $terms->text !!}
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('dashboard/plugins/bs-stepper/js/bs-stepper.min.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
            window.stepper = new Stepper(document.querySelector('.bs-stepper'))
        })

        //on terms_condtions_box change
        const terms_condtions_box = document.getElementById('terms_condtions_box');
        terms_condtions_box.addEventListener('change', function() {
            if (this.checked) {
                //enable submit button
                document.querySelector('button[type="submit"]').removeAttribute('disabled');
            } else {
                //disable submit button
                document.querySelector('button[type="submit"]').setAttribute('disabled', 'disabled');
            }
        });
</script>
@endsection
