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
                                <a href="{{ route('Emails.CreateInstantEmail') }}"
                                    class="btn btn-sm btn-tool {{ App()->getLocale() == 'ar' ? 'float-start' : 'float-end' }}">
                                    <i class="fa fa-envelope"></i> {{ __('Send Instant Email') }}
                                </a>
                                <a href="{{ route('Emails.CreateAutmoatedEmails') }}"
                                    class="btn btn-sm btn-tool {{ App()->getLocale() == 'ar' ? 'float-start' : 'float-end' }}">
                                    <i class="fas fa-plus"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="col-md-8 col-sm-12">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-12 form-group">
                                            {{-- select country --}}
                                            <label for="country">{{ __('Select Country') }}</label>
                                            <select class="form-control" id="country">
                                                <option value="">{{ __('Select Country') }}</option>
                                                <option value="all">{{ __('All') }}</option>
                                                <optgroup label="{{ __('Arab countries') }}">
                                                    @foreach ($countries[1] as $country)
                                                    <option value="{{ $country->id }}">{{ $country->country_name }}
                                                    </option>
                                                    @endforeach
                                                </optgroup>
                                                <optgroup label="{{ __('Foreign countries') }}">
                                                    @foreach ($countries[0] as $country)
                                                    <option value="{{ $country->id }}">{{ $country->country_name }}
                                                    </option>
                                                    @endforeach
                                                </optgroup>
                                            </select>

                                        </div>
                                        <div class="col-md-6 col-sm-12 form-group">
                                            {{-- select Email Type --}}
                                            <label for="type">{{ __('Email Type') }}</label>
                                            <select class="form-control" id="type">
                                                <option value="">{{ __('Select Email Type') }}</option>
                                                <option value="Secheduled">{{ __('Secheduled Emails') }}</option>
                                                <option value="Auto">{{ __('Auto Send Emails') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-10 col-sm-12">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-bordered table-striped"
                                            id="email-datatable">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>{{ __('Email Title') }}</th>
                                                    <th>{{ __('country') }}</th>
                                                    <th>{{ __('Actions') }}</th>
                                                </tr>
                                            </thead>
                                        </table>
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
    //on country selection change
        $('#country').change(function() {
            var country = $(this).val();
            var survey = $('#survey').val();
            //check if country is selected
            if (country != '') {
                //initialize datatable
                var table = $('#email-datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    destroy: true,
                    ajax: {
                        url: "{{ route('Emails.AutomatedEmails') }}",
                        data: {
                            country: country,
                            survey: survey
                        }
                    },
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {
                            data: 'subject',
                            name: 'subject'
                        },
                        {
                            data: 'country',
                            name: 'country'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ]
                });
            }
        });
</script>
@endsection
