{{-- extends --}}
@extends('dashboard.layouts.main')
@section('styles')
    {{-- css file --}}
    <link rel="stylesheet" href="{{ asset('assets/css/treeView.css') }}">
@endsection
{{-- content --}}
{{-- show client details --}}
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <!-- /.col -->
                    <div class="col-sm-12">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item">Dashboard </li>
                            <li class="breadcrumb-item active">Emails</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    {{-- create funcy card to display surveys --}}
                    <div class="col-12 mt-3">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('Manage Autmated Emails') }}</h3>
                                {{-- tool --}}
                                <div class="card-tools">
                                    <a href="{{ route('termsCondition.index') }}"
                                        class="btn btn-sm btn-tool {{ App()->getLocale() == 'ar' ? 'float-start' : 'float-end' }}">
                                        <i class="fas fa-arrow-left"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row justify-content-center">
                                    <div class="col-md-8 col-sm-12">
                                        <form action="{{ route('termsCondition.store') }}" method="post">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6 col-sm-12 form-group">
                                                    {{-- select country --}}
                                                    <label for="country">{{ __('Select Country') }}</label>
                                                    <select class="form-control" id="country" name="country">
                                                        <option value="">{{ __('Select Country') }}</option>
                                                        <option value="all">{{ __('All') }}</option>
                                                        <optgroup label="{{ __('Arab countries') }}">
                                                            @foreach ($countries[1] as $country)
                                                                <option value="{{ $country->id }}">
                                                                    {{ $country->country_name }}
                                                                </option>
                                                            @endforeach
                                                        </optgroup>
                                                        <optgroup label="{{ __('Foreign countries') }}">
                                                            @foreach ($countries[0] as $country)
                                                                <option value="{{ $country->id }}">
                                                                    {{ $country->country_name }}
                                                                </option>
                                                            @endforeach
                                                        </optgroup>
                                                    </select>
                                                    @error('country')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 col-sm-12 form-group">
                                                    {{-- select Email Type --}}
                                                    <label for="type">{{ __('Terms Type') }}</label>
                                                    <select class="form-control" id="type" name="type">
                                                        <option value="">{{ __('Select Terms Type') }}</option>
                                                        <option value="Singup">{{ __('Singup') }}</option>
                                                        <option value="Login">{{ __('Login') }}</option>
                                                    </select>
                                                    @error('type')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                {{-- terms title in english --}}
                                                <div class="col-md-6 col-sm-12 form-group">
                                                    <label for="title_en">{{ __('Title in English') }}</label>
                                                    <input type="text" class="form-control" id="title_en"
                                                        name="title_en" placeholder="{{ __('Enter title in English') }}">
                                                    @error('title_en')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                {{-- terms title in arabic --}}
                                                <div class="col-md-6 col-sm-12 form-group">
                                                    <label for="title_ar">{{ __('Title in Arabic') }}</label>
                                                    <input type="text" class="form-control" id="title_ar"
                                                        name="title_ar" placeholder="{{ __('Enter title in Arabic') }}">
                                                    @error('title_ar')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                {{-- terms content in english --}}
                                                <div class="col-md-6 col-sm-12 form-group">
                                                    <label for="content_en">{{ __('Content in English') }}</label>
                                                    <textarea class="form-control summernote" id="content_en" name="content_en"
                                                        placeholder="{{ __('Enter content in English') }}"></textarea>
                                                    @error('content_en')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                {{-- terms content in arabic --}}
                                                <div class="col-md-6 col-sm-12 form-group">
                                                    <label for="content_ar">{{ __('Content in Arabic') }}</label>
                                                    <textarea class="form-control summernote" id="content_ar" name="content_ar"
                                                        placeholder="{{ __('Enter content in Arabic') }}"></textarea>
                                                    @error('content_ar')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                {{-- is_active switch --}}
                                                <div class="col-md-6 col-sm-12 form-group">
                                                    <label for="is_active">{{ __('Status') }}</label>
                                                    <input type="checkbox" checked name="is_active" id="is_active"
                                                        data-bootstrap-switch="" data-off-color="danger"
                                                        data-on-color="success" value="1">
                                                </div>
                                                {{-- submit button --}}
                                                <div class="col-md-12 col-sm-12 form-group">
                                                    <button type="submit"
                                                        class="btn btn-outline-info btn-sm">{{ __('Save') }}</button>
                                                </div>
                                        </form>
                                    </div>

                                </div>
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
        $("[name='is_active']").bootstrapSwitch();
        $('.summernote').summernote({
            tabsize: 2,
            height: 120,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'help']]
            ]
        });
    </script>
@endsection
