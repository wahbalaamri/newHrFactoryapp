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
                                {{-- back --}}
                                <a href="{{ route('Emails.AutomatedEmails') }}"
                                    class="btn btn-sm btn-tool {{ App()->getLocale() == 'ar' ? 'float-start' : 'float-end' }}">
                                    <i class="fas fa-arrow-left"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="col-11">
                                    <form action="{{ route('Emails.SaveAutomatedEmails') }}" method="post">
                                        @csrf
                                        {{-- show all errors --}}

                                        <div class="row justify-content-center">
                                            <div class="col-lg-4 col-md-6 col-sm-12 form-group">
                                                {{-- type of emails -schedule or automated --}}
                                                <label for="email_type" class="text-sm">{{ __('Type of Email')
                                                    }}</label>
                                                <select class="form-control" id="email_type" name="email_type">
                                                    <option value="">{{ __('Select Type') }}</option>
                                                    <option value="1" @if(old('email_type')=='1' ) selected @endif>{{
                                                        __('Automated') }}</option>
                                                    <option value="2" @if(old('email_type')=='2' ) selected @endif>{{
                                                        __('Secheduled') }}</option>
                                                </select>
                                                @error('email_type')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-lg-4 col-md-6 col-sm-12 form-group">
                                                {{-- select country of client --}}
                                                <label for="country" class="text-sm">
                                                    {{ __('Country of Clients Who Should Receive This E-mail ') }}
                                                </label>
                                                <select class="form-control" id="country" name="country">
                                                    <option value="">{{ __('Select Country') }}</option>
                                                    @if (Auth()->user()->isAdmin)
                                                    <optgroup label="{{ __('Arab countries') }}">
                                                        @foreach ($countries[1] as $country)
                                                        <option value="{{ $country->id }}"
                                                            @if(old('country')==$country->id) selected @endif>
                                                            {{ $country->country_name }}
                                                        </option>
                                                        @endforeach
                                                    </optgroup>
                                                    <optgroup label="{{ __('Foreign countries') }}">
                                                        @foreach ($countries[0] as $country)
                                                        <option value="{{ $country->id }}"
                                                            @if(old('country')==$country->id) selected @endif>
                                                            {{ $country->country_name }}
                                                        </option>
                                                        @endforeach
                                                    </optgroup>
                                                    @else
                                                    @foreach ($countries as $country)
                                                    <option value="{{ $country->id }}" @if(old('country')==$country->id)
                                                        selected @endif>
                                                        {{ $country->country_name }}
                                                    </option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                                @error('country')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row justify-content-center">
                                            <div class="col-lg-4 col-md-6 col-sm-12 form-group">
                                                {{-- type of clients who should receive this email --}}
                                                <label for="client_type" class="text-sm">{{ __('Type of Clients')
                                                    }}</label>
                                                <select class="form-control" id="client_type" name="client_type">
                                                    <option value="">{{ __('Select Type') }}</option>
                                                    <option value="all" @if(old('client_type')=="all" ) selected @endif>
                                                        {{ __('All Users') }}</option>
                                                    <option value="all-p" @if(old('client_type')=="all-ps" ) selected
                                                        @endif>{{ __('All Partners') }}</option>
                                                    <option value="all-c" @if(old('client_type')=="all-c" ) selected
                                                        @endif>{{ __('All Clients') }}</option>
                                                    <option value="AP" @if(old('client_type')=="AP" ) selected @endif>{{
                                                        __('Active Partners') }}</option>
                                                    <option value="NC" @if(old('client_type')=="NC" ) selected @endif>{{
                                                        __('New Clients') }}</option>
                                                    <option value="SC" @if(old('client_type')=="SC" ) selected @endif>{{
                                                        __('Subscribed Clients') }}</option>
                                                    <option value="USC" @if(old('client_type')=="USC" ) selected @endif>
                                                        {{ __('Unsubscribed Clients') }}</option>
                                                    <option value="NSC" @if(old('client_type')=="NSC" ) selected @endif>
                                                        {{ __('New subscribed Clients') }}</option>
                                                    <option value="ATES" @if(old('client_type')=="ATES" ) selected
                                                        @endif>{{ __('About To Expire subscription') }}
                                                    </option>
                                                </select>
                                                @error('client_type')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-lg-4 col-md-6 col-sm-12 form-group">
                                                <div class="d-none">
                                                    <label for="send_date">{{ __('Send Date & Time') }}</label>
                                                    <div class="row">
                                                        <input type="date" name="send_date" id="send_date"
                                                            class="form-control col-md-5 col-sm-12 m-1"
                                                            placeholder="{{ __('Send Date') }}" value="{{ old('send_date') }}">
                                                        <input type="time" name="send_time" id="send_time"
                                                            class="form-control col-md-5 col-sm-12 m-1"
                                                            placeholder="{{ __('Send Time') }}" value="{{ old('send_time') }}">
                                                    </div>
                                                    @error('send_date')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                    @error('send_time')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row justify-content-center">
                                            <div class="col-lg-4 col-md-6 col-sm-12 form-group">
                                                {{-- Email Subject in English --}}
                                                <label for="email_subject" class="text-sm">{{ __('Email Subject in
                                                    English') }}</label>
                                                <input type="text" class="form-control" id="email_subject"
                                                    name="email_subject" value="{{ old('email_subject') }}">
                                                @error('email_subject')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-lg-4 col-md-6 col-sm-12 form-group">
                                                {{-- Email Subject in Arabic --}}
                                                <label for="email_subject_ar" class="text-sm">{{ __('Email Subject in
                                                    Arabic') }}</label>
                                                <input type="text" class="form-control" id="email_subject_ar"
                                                    name="email_subject_ar" value="{{ old('email_subject_ar') }}">
                                                @error('email_subject_ar')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row justify-content-center">
                                            <div class="col-lg-4 col-md-6 col-sm-12 form-group">
                                                {{-- Email Header Body in English --}}
                                                <label for="email_header" class="text-sm">{{ __('Email Header in
                                                    English') }}</label>
                                                <textarea class="form-control summernote" id="email_header"
                                                    name="email_header">{{ old('email_header') }}</textarea>
                                                @error('email_header')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-lg-4 col-md-6 col-sm-12 form-group">
                                                {{-- Email Header Body in Arabic --}}
                                                <label for="email_header_ar" class="text-sm">{{ __('Email Header in
                                                    Arabic') }}</label>
                                                <textarea class="form-control summernote" id="email_header_ar"
                                                    name="email_header_ar">{{ old('email_header_ar') }}</textarea>
                                                @error('email_header_ar')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row justify-content-center">
                                            <div class="col-lg-4 col-md-6 col-sm-12 form-group">
                                                {{-- Email Body in English --}}
                                                <label for="email_footer" class="text-sm">{{ __('Email Footer in
                                                    English') }}</label>
                                                <textarea class="form-control summernote" id="email_footer"
                                                    name="email_footer">{{ old('email_footer') }}</textarea>
                                                @error('email_footer')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-lg-4 col-md-6 col-sm-12 form-group">
                                                {{-- Email Body in Arabic --}}
                                                <label for="email_footer_ar" class="text-sm">{{ __('Email Footer in
                                                    Arabic') }}</label>
                                                <textarea class="form-control summernote" id="email_footer_ar"
                                                    name="email_footer_ar">{{ old('email_footer_ar') }}</textarea>
                                                @error('email_footer_ar')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row justify-content-center">
                                            <div class="col-md-8 col-sm-12">
                                                <button type="submit" @class([ 'btn btn-outline-primary btn-sm'
                                                    , 'float-right'=> app()->isLocale('en'),
                                                    'float-left' => app()->isLocale('en'),
                                                    ])>{{ __('Save') }}</button>
                                            </div>
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
        // on email_type change
        $('#email_type').change(function() {
            console.log($(this).val());
            if ($(this).val() == "2") {
                $('#send_date').parent().parent().removeClass('d-none');
            } else {
                $('#send_date').parent().parent().addClass('d-none');
            }
        });
</script>
@endsection
