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
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Org-Chart') }}</h1>
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
            <div class="row">
                {{-- create funcy card to display surveys --}}
                <div class="col-12 mt-3">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('Manage Your Org-Chart') }}</h3>
                            {{-- tool --}}
                            <div class="card-tools">
                                {{-- back --}}
                                <a href="{{ route('clients.manage', $id) }}"
                                    class="btn btn-sm btn-primary {{ App()->getLocale() == 'ar' ? 'float-start' : 'float-end' }}">{{
                                    __('Back') }}</a>
                                {{-- create new survey --}}
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="accordion" id="accordionExample">
                                <div class="card">
                                    <div class="card-header" id="headingOne">
                                        <h2 class="mb-0">
                                            <button class="btn btn-link btn-block text-left" type="button"
                                                data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
                                                aria-controls="collapseOne">
                                                {{ __('Set you organaization info') }}
                                            </button>
                                        </h2>
                                    </div>

                                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                        data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="form-group col-md-6 col-sm-12">
                                                    <label for="phone">{{ __('Do you have multiple sectors?') }}</label>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch"
                                                            id="multiple_sectors" name="multiple_sectors"
                                                            @checked($client->multiple_sectors)>
                                                        <label class="form-check-label" for="multiple_sectors">
                                                            @if ($client->multiple_sectors)
                                                            {{ __('Yes, We have multiple sectors') }}
                                                            @else
                                                            {{ __('No, Only one sector') }}
                                                            @endif
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6 col-sm-12">
                                                    <label for="phone">{{ __('Do you have multiple companies?')
                                                        }}</label>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch"
                                                            id="multiple_companies" name="multiple_companies"
                                                            @checked($client->multiple_company)>
                                                        <label class="form-check-label" for="multiple_companies">{{
                                                            __('No,
                                                            Only one company') }}</label>
                                                    </div>

                                                </div>
                                                {{-- use departments --}}
                                                <div class="form-group col-md-6 col-sm-12">
                                                    <label for="phone">{{ __('Would like to use your local levels
                                                        organization structure in the system?') }}</label>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch"
                                                            id="use_departments" name="use_departments"
                                                            @checked($client->use_departments)>
                                                        <label class="form-check-label" for="use_departments">
                                                            @if ($client->use_departments)
                                                            {{ __('Yes, We like to use local levels structure') }}
                                                            @else
                                                            {{ __('No, just stop on Company level') }}
                                                            @endif
                                                        </label>
                                                        <small class="blockquote-footer">
                                                            @if ($client->use_departments)
                                                            {{ __('This will allow you to view breckdown reports per
                                                            your local levels structure (Depends on your subscription
                                                            plan).') }}
                                                            @else
                                                            {{ __('By switching-off you will be unable to view breckdown
                                                            reports per your local levels structure') }}
                                                            @endif
                                                        </small>
                                                    </div>
                                                </div>

                                                {{-- submit --}}
                                                <div class="form-group col-sm-12">
                                                    <a href="javascript:void(0)" onclick="saveOrgInfo()"
                                                        @class([ 'btn btn-outline-success btn-sm' , 'float-right'=>
                                                        app()->isLocale('en'),
                                                        'float-left' => app()->isLocale('ar'),
                                                        ])>{{ __('Save') }}</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="headingOrg">
                                        <h2 class="mb-0">
                                            <button class="btn btn-link btn-block text-left" type="button"
                                                data-toggle="collapse" data-target="#collapseOrg" aria-expanded="true"
                                                aria-controls="collapseOne">
                                                {{ __('Download your organization chart template') }}
                                            </button>
                                        </h2>
                                    </div>

                                    <div id="collapseOrg" class="collapse" aria-labelledby="headingOrg"
                                        data-parent="#accordionExample">
                                        <div class="card-body">
                                            @if (!$client->multiple_sectors && !$client->multiple_company &&
                                            !$client->use_departments)
                                            {{-- alert --}}
                                            <div class="alert alert-info" role="alert">
                                                <strong>{{ __('Info!') }}</strong>
                                                {{ __('You don\'t need to upload any excel sheet') }}
                                            </div>
                                            @elseif(!$client->multiple_sectors && $client->multiple_company &&
                                            !$client->use_departments)
                                            {{-- add new company --}}
                                            <div class="row justify-content-center">
                                                <div class="col-md-6 col-sm-12">

                                                    <div class="" id="addNewCompanDiv">
                                                        {{-- form-group --}}
                                                        <div class="form-group">
                                                            <label for="phone">{{ __('Company Offical Name') }}</label>
                                                            <input type="text" class="form-control" id="add_new_company"
                                                                name="add_new_company[]"
                                                                placeholder="{{ __('Enter Company Offical Name') }}">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        {{-- add more --}}
                                                        <div class="col-md-6 col-sm-12">
                                                            <a href="javascript:void(0)" onclick="addCompany()"
                                                                class="btn btn-primary btn-sm"><i
                                                                    class="fa fa-plus"></i>
                                                                {{ __('Add') }}</a>
                                                        </div>
                                                        {{-- submit --}}
                                                        <div class="col-md-6 col-sm-12">
                                                            <a href="javascript:void(0)"
                                                                onclick="saveCompany({{ $client->sectors[0]->id }})"
                                                                class="btn btn-outline-success btn-sm"><i
                                                                    class="fa fa-save"></i>
                                                                {{ __('Save') }}</a>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            @elseif($client->multiple_sectors && $client->multiple_company &&
                                            !$client->use_departments)
                                            <form
                                                action="{{ route('clients.DownloadOrgChartTemp', [$client->id, $client->multiple_sectors, $client->multiple_company, $client->use_departments]) }}"
                                                method="post">
                                                @csrf
                                                <div class="row justify-content-center text-center">
                                                    <div class="col-md-6 col-sm-12">
                                                        {{-- download btn --}}
                                                        <button type="submit" class="btn btn-outline-success btn-sm"><i
                                                                class="fa fa-download"></i>
                                                            {{ __('Download Your Org-chart Template') }}</button>
                                                    </div>
                                                </div>
                                            </form>
                                            @elseif (
                                            (!$client->multiple_sectors || $client->multiple_sectors) &&
                                            (!$client->multiple_company || $client->multiple_company) &&
                                            $client->use_departments)
                                            <div class="row">
                                                <form
                                                    action="{{ route('clients.DownloadOrgChartTemp', [$client->id, $client->multiple_sectors, $client->multiple_company, $client->use_departments]) }}"
                                                    method="post" @class(['col-6'=> count($orgchart) > 0])>
                                                    @csrf
                                                    <div class="col-10" id="addLevelDiv">
                                                        <div class="row row-levels">
                                                            <div class="col-md-6 col-sm-12 form-group">
                                                                <label for="levels_label[]">{{ __('Your org chart label
                                                                    of
                                                                    Level-1') }}</label>
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Level-1:</span>
                                                                    </div>
                                                                    <input type="text" class="form-control"
                                                                        name="levels_label[]"
                                                                        placeholder="{{ __('Enter label of Level-1 of your org chart') }}">
                                                                </div>
                                                                {{-- hint --}}
                                                                <small class="text-muted">{{ __('Enter label of your org
                                                                    chart e.g. Directorate, Division, Department,
                                                                    Section or
                                                                    Unit') }}</small>
                                                            </div>
                                                            {{-- add more btn --}}
                                                            <div class="col-md-6 col-sm-12">
                                                                <a href="javascript:void(0)"
                                                                    class="btn btn-outline-warning btn-sm"
                                                                    id="addLevelbtn">
                                                                    <i class="fa fa-plus"></i>
                                                                    {{ __('Add') }}</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row justify-content-center text-center">
                                                        <div class="col-md-6 col-sm-12">
                                                            {{-- download btn --}}
                                                            <button type="submit"
                                                                class="btn btn-outline-success btn-sm"><i
                                                                    class="fa fa-download"></i>
                                                                {{ __('Download Your Org-chart Template') }}</button>
                                                        </div>
                                                    </div>
                                                </form>
                                                @if(count($orgchart) >= 0)
                                                <div class="col-md-6 col-sm-12">
                                                    <table class="table table-hover table-strip">
                                                        <thead>
                                                            <tr>
                                                                <th>{{ __('#') }}</th>
                                                                <th>{{ __('Level') }}</th>
                                                                <th>{{ __('User Label') }}</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($orgchart as $item)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $item->level }}</td>
                                                                <td>{{ $item->user_label }}</td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                @endif
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="headingTwo">
                                        <h2 class="mb-0">
                                            <button class="btn btn-link btn-block text-left" type="button"
                                                data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
                                                aria-controls="collapseTwo">
                                                {{ __('Upload Excel Sheet') }}
                                            </button>
                                        </h2>
                                    </div>

                                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                        data-parent="#accordionExample">
                                        <div class="card-body">
                                            {{-- form to upload excel sheet --}}
                                            <form action="{{ route('clients.uploadOrgChartExcel', $id) }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-group col-md-6 col-sm-12">
                                                    <label for="excel">{{ __('Upload Excel Sheet') }}</label>
                                                    <input type="file" name="excel" class="form-control" required>
                                                </div>
                                                <div class="form-group col-sm-12">
                                                    <button type="submit"
                                                        class="btn btn-outline-success btn-sm {{ App()->getLocale() == 'ar' ? 'float-start' : 'float-end' }}">{{
                                                        __('Upload') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="headingThree">
                                        <h2 class="mb-0">
                                            <button class="btn btn-link btn-block text-left" type="button"
                                                data-toggle="collapse" data-target="#collapseThree" aria-expanded="true"
                                                aria-controls="collapseThree">
                                                {{ __('Tree View') }}
                                            </button>
                                        </h2>
                                    </div>

                                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                                        data-parent="#accordionExample">
                                        <div class="card-body">
                                            @include('dashboard.client.orgChart.OrgChartTree', [
                                            'client' => $client,
                                            ])
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="headingFour">
                                        <h2 class="mb-0">
                                            <button class="btn btn-link btn-block text-left collapsed" type="button"
                                                data-toggle="collapse" data-target="#collapseFour" aria-expanded="false"
                                                aria-controls="collapseFour">
                                                {{ __('Table View') }}
                                            </button>
                                        </h2>
                                    </div>
                                    <div id="collapseFour" class="collapse" aria-labelledby="headingFour"
                                        data-parent="#accordionExample">
                                        <div class="card-body">
                                            @include('dashboard.client.orgChart.orgChartTable')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
{{-- -modal to create new sector --}}
@include('dashboard.client.modals.addSector')
@include('dashboard.client.modals.AddOrAssignAccting')
{{-- -modal to create new company --}}
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
{{-- js file --}}
<script>
    $("[name='is_hr']").bootstrapSwitch();
        $("#multiple_sectors").bootstrapSwitch();
        $("#multiple_companies").bootstrapSwitch();
        $(".form-check-input").bootstrapSwitch();
        // document.addEventListener('contextmenu', event => event.preventDefault());

        function ShowRespondents(id) {
            //show AddOrAssignAccting modal
            $('#AddOrAssignAccting').modal('show');
        }

        function ShowAdd(client_id, sector_id, type) {
            if (type == 'sector') {
                isArabic = '{{ App()->getLocale() == 'ar' }}';
                options = null;


                $("#AddNewSecCompDepLabel").text("{{ __('Add New Sector') }}");
                $("#AddNewSecCompDep .modal-body").html(`
                    <form action="" method="POST">
                        <input type="hidden" name="client_id" value="${client_id}">
                        <input type="hidden" name="type" value="${type}">
                        <input type="hidden" name="dep_id" value="">
                        <div class="form-group col-12">
                            <label for="sector_id">{{ __('Select Sector') }}</label>
                            <select name="sector_id" id="Selector_Sector" class="form-control" required onchange="selectedSector()"></select>
                        </div>
                        <div id="addNewSector" class="d-none">
                            <div class="form-group col-12">
                            <label for="name_en">{{ __('Sector Name') }} (EN)</label>
                            <input type="text" name="name_en" class="form-control">
                        </div>
                        <div class="form-group col-12">
                            <label for="name_ar">{{ __('Sector Name') }} (AR)</label>
                            <input type="text" name="name_ar" class="form-control">
                        </div>
                        </div>
                        <div class="form-group col-12">
                            <a href="javascript:void(0)" onclick="saveSCD(this)" class="btn btn-primary">{{ __('Save') }}</a>
                        </div>
                    </form>
                `);
                //get all indusrties
                //setup url
                url = "{{ route('industries.all', ':id') }}";
                url = url.replace(':id', client_id);
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(data) {
                        option = '<option value="">{{ __('Select Sector') }}</option>';
                        options += option;
                        data.forEach(function(industry) {
                            option = '<option value="' + industry.id + '">' + (isArabic ? industry
                                .name_ar : industry.name) + '</option>';
                            options += option;
                        });
                        //.push other as last option to options
                        options += '<option value="other">{{ __('Other') }}</option>';
                        //append options to selector
                        $("#Selector_Sector").html(options);
                    }
                });
                $('#Selector_Sector').select2();
                $('.select2-container ').css('width', '100%');
            } else if (type == 'comp') {
                $("#AddNewSecCompDepLabel").text("{{ __('Add New Company') }}");
                $("#AddNewSecCompDep .modal-body").html(`
                    <form action="" method="POST">
                        <input type="hidden" name="client_id" value="${client_id}">
                        <input type="hidden" name="type" value="${type}">
                        <input type="hidden" name="sector_id" value="${sector_id}">
                        <input type="hidden" name="dep_id" value="">
                        <div class="form-group col-12">
                            <label for="name_en">{{ __('Company Name') }} (EN)</label>
                            <input type="text" name="name_en" class="form-control" required>
                        </div>
                        <div class="form-group col-12">
                            <label for="name_ar">{{ __('Company Name') }} (AR)</label>
                            <input type="text" name="name_ar" class="form-control" required>
                        </div>
                        <div class="form-group
                        col-12">
                            <a href="javascript:void(0)" onclick="saveSCD(this)" class="btn btn-primary">{{ __('Save') }}</a>
                        </div>
                    </form>
                `);
            } else if (type == 'dep') {
                $("#AddNewSecCompDepLabel").text("{{ __('Add New Department') }}");
                $("#AddNewSecCompDep .modal-body").html(`
                    <form action="" method="POST">
                        <input type="hidden" name="client_id" value="${client_id}">
                        <input type="hidden" name="type" value="${type}">
                        <input type="hidden" name="company_id" value="${sector_id}">
                        <input type="hidden" name="dep_id" value="">
                        <div class="form-group col-12">
                            <label for="name_en">{{ __('Department Name') }} (EN)</label>
                            <input type="text" name="name_en" class="form-control" required>
                        </div>
                        <div class="form-group
                        col-12">
                            <label for="name_ar">{{ __('Department Name') }} (AR)</label>
                            <input type="text" name="name_ar" class="form-control" required>
                        </div>
                        <div class="form-group col-md-6 col-sm-12">
                                    <label for="is_hr">{{ __('Is this Department Equavlent to HR Department') }}</label>
                                    <br>
                                    <input type="checkbox" name="is_hr"  data-bootstrap-switch
                                        data-off-color="danger" data-on-color="success">
                                </div>
                        <div class="form-group col-12">
                            <a href="javascript:void(0)" onclick="saveSCD(this)" class="btn btn-primary">{{ __('Save') }}</a>
                        </div>
                    </form>
                `);
            } else if (type == 'sub-dep') {
                $("#AddNewSecCompDepLabel").text("{{ __('Add New Sub-Department') }}");
                $("#AddNewSecCompDep .modal-body").html(`
                    <form action="" method="POST">
                        <input type="hidden" name="client_id" value="${client_id}">
                        <input type="hidden" name="type" value="${type}">
                        <input type="hidden" name="department_id" value="${sector_id}">
                        <input type="hidden" name="dep_id" value="">
                        <div class="form-group col-12">
                            <label for="name_en">{{ __('Sub-Department Name') }} (EN)</label>
                            <input type="text" name="name_en" class="form-control" required>
                        </div>
                        <div class="form-group col-12">
                            <label for="name_ar">{{ __('Sub-Department Name') }} (AR)</label>
                            <input type="text" name="name_ar" class="form-control" required>
                        </div>
                        <div class="form-group col-md-6 col-sm-12">
                                    <label for="is_hr">{{ __('Is this Department Equavlent to HR Department') }}</label>
                                    <br>
                                    <input type="checkbox" name="is_hr"  data-bootstrap-switch
                                        data-off-color="danger" data-on-color="success">
                                </div>
                        <div class="form-group col-12">
                            <a href="javascript:void(0)" onclick="saveSCD(this)" class="btn btn-primary">{{ __('Save') }}</a>
                        </div>
                    </form>
                `);
            }
            $('#AddNewSecCompDep').modal('show');
            $("[name='is_hr']").bootstrapSwitch();
        }
        selectedSector = () => {
            if ($('#Selector_Sector').val() == 'other') {
                $('#addNewSector').removeClass('d-none');
            } else {
                $('#addNewSector').addClass('d-none');
            }
        }

        function saveSCD(button) {
            //get type
            form = button.parentElement.parentElement;
            type = form.type.value;
            PostedData = [null];

            if (type == 'sector') {
                //get sector_id
                sector_id = form.sector_id.value;
                if (sector_id == 'other') {
                    if (!form.name_en.value) {
                        toastr.error('Please enter The Name in English');
                        return;
                    }
                    if (!form.name_ar.value) {
                        toastr.error('Please enter The Name in Arabic');
                        return;
                    }
                }
                if (sector_id == '') {
                    toastr.error('Please Select Sector');
                    return;
                }
                //build data
                client_id = form.client_id.value;
                type = form.type.value;
                _id = sector_id;
                name_en = form.name_en.value;
                name_ar = form.name_ar.value;
                is_hr = null;
                dep_id = form.dep_id.value;
            } else if (type == 'comp') {
                if (!form.name_en.value) {
                    toastr.error('Please enter The Name in English');
                    return;
                }
                if (!form.name_ar.value) {
                    toastr.error('Please enter The Name in Arabic');
                    return;
                }
                //get sector_id
                sector_id = form.sector_id.value;
                client_id = form.client_id.value;
                type = form.type.value;
                _id = sector_id;
                name_en = form.name_en.value;
                name_ar = form.name_ar.value;
                is_hr = null;
                dep_id = form.dep_id.value;

            } else if (type == 'dep') {
                if (!form.name_en.value) {
                    toastr.error('Please enter The Name in English');
                    return;
                }
                if (!form.name_ar.value) {
                    toastr.error('Please enter The Name in Arabic');
                    return;
                }
                //get company_id
                company_id = form.company_id.value;
                //build data
                client_id = form.client_id.value;
                type = form.type.value;
                _id = company_id;
                name_en = form.name_en.value;
                name_ar = form.name_ar.value;
                is_hr = form.is_hr.checked;
                dep_id = form.dep_id.value;
            } else if (type == 'sub-dep') {
                if (!form.name_en.value) {
                    toastr.error('Please enter The Name in English');
                    return;
                }
                if (!form.name_ar.value) {
                    toastr.error('Please enter The Name in Arabic');
                    return;
                }
                //get department_id
                department_id = form.department_id.value;
                //build data
                client_id = form.client_id.value;
                type = form.type.value;
                _id = department_id;
                name_en = form.name_en.value;
                name_ar = form.name_ar.value;
                is_hr = form.is_hr.checked;
                dep_id = form.dep_id.value;

            }

            //setup url
            data = {
                '_token': "{{ csrf_token() }}",
                'client_id': client_id,
                'type': type,
                '_id': _id,
                'name_en': name_en,
                'name_ar': name_ar,
                'is_hr': is_hr,
                'dep_id': dep_id
            };
            url = "{{ route('clients.saveSCD') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: data,
                success: function(data) {
                    //sweet  alert
                    Swal.fire({
                        icon: 'success',
                        title: 'Done',
                        text: data.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                    //reload page
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }
        //yajra table for Departments-data
        $(document).ready(function() {
            url = "{{ route('clients.orgChart', ':id') }}";
            url = url.replace(':id', "{{ $id }}");
            $('#Departments-data').DataTable({
                processing: true,
                serverSide: true,
                ajax: url,
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    @foreach ($orgchart as $item)
                        {
                            data: 'c{{ $item->level }}',
                            name: 'c{{ $item->level }}',
                            // visible: {{ $orgchartAva[$loop->index] == 1 ? 'true' : 'false' }},
                        },
                    @endforeach


                    {
                        data: 'company',
                        name: 'company'
                    },
                    {
                        data: 'sector',
                        name: 'sector'
                    },
                    {
                        data: 'level',
                        name: 'level'
                    },

                    {
                        data: 'is_hr',
                        name: 'is_hr'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
            //make table width 100%
            $('#Departments-data').css('width', '100%');
            //on EditDep show modal
            EditDep = (id, comp, client, type) => {
                //setup url
                url = "{{ route('client.getDep', ':id') }}";
                url = url.replace(':id', id);
                //get data
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(data) {
                        $("#AddNewSecCompDepLabel").text("{{ __('Edit Department') }}");
                        $("#AddNewSecCompDep .modal-body").html(`
                    <form action="" method="POST">
                        <input type="hidden" name="client_id" value="${client}">
                        <input type="hidden" name="type" value="${type}">
                        <input type="hidden" name="department_id" value="${comp}">
                        <input type="hidden" name="dep_id" value="${id}">
                        <div class="form-group col-12">
                            <label for="name_en">{{ __('Sub-Department Name') }} (EN)</label>
                            <input type="text" name="name_en" class="form-control" required>
                        </div>
                        <div class="form-group col-12">
                            <label for="name_ar">{{ __('Sub-Department Name') }} (AR)</label>
                            <input type="text" name="name_ar" class="form-control" required>
                        </div>
                        <div class="form-group col-md-6 col-sm-12">
                                    <label for="is_hr">{{ __('Is this Department Equavlent to HR Department') }}</label>
                                    <br>
                                    <input type="checkbox" name="is_hr"  data-bootstrap-switch
                                        data-off-color="danger" data-on-color="success">
                                </div>
                        <div class="form-group col-12">
                            <a href="javascript:void(0)" onclick="saveSCD(this)" class="btn btn-primary">{{ __('Save') }}</a>
                        </div>
                    </form>
                `);
                        $("[name='is_hr']").bootstrapSwitch();
                        //fill data
                        $("input[name='department_id']").val(data.department.parent_id);
                        $("input[name='name_en']").val(data.department.name_en);
                        $("input[name='name_ar']").val(data.department.name_ar);
                        $("input[name='is_hr']").bootstrapSwitch('state', data.department.is_hr);
                        //show modal
                        $('#AddNewSecCompDep').modal('show');
                    }
                });
            }
            //on DeleteDep
            DeleteDep = (id) => {
                //confirm deleting
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Deleteing This Department will delete all its sub departments!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        //setup url
                        url = "{{ route('clients.deleteDep', ':id') }}";
                        url = url.replace(':id', id);
                        //delete
                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: {
                                //token
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(data) {
                                //sweet  alert
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Done',
                                    text: data.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                //reload page
                                setTimeout(() => {
                                    //reload yajra table
                                    $('#Departments-data').DataTable().ajax
                                        .reload();
                                }, 1500);
                            },
                            error: function(data) {
                                console.log(data);
                            }
                        });
                    }
                })
            }
        });
        //on multiple_companies bootstrapswitch event
        $('#multiple_companies').on('switchChange.bootstrapSwitch', function(event, state) {
            //check if state is true

            if (state) {
                //change multiple_companies label with for
                $("[for='multiple_companies']").text("{{ __('Yes, We have multiple companies') }}");
            } else {
                $("[for='multiple_companies']").text("{{ __('No, Only one company') }}");
            }
        });
        //on multiple_sectors bootstrapswitch event
        $('#multiple_sectors').on('switchChange.bootstrapSwitch', function(event, state) {
            //check if state is true
            if (state) {
                //change multiple_sectors label with for
                $("[for='multiple_sectors']").text("{{ __('Yes, We have multiple sectors') }}");
                //change multiple_companies state
                $("#multiple_companies").bootstrapSwitch('state', true);
                //change multiple_companies label with for
                $("[for='multiple_companies']").text("{{ __('Yes, We have multiple companies') }}");
            } else {
                $("[for='multiple_sectors']").text("{{ __('No, Only one sector') }}");
            }
        });
        //on use_departments bootstrapswitch event
        $('#use_departments').on('switchChange.bootstrapSwitch', function(event, state) {
            //check if state is true
            if (state) {
                //change use_departments label with for
                $("[for='use_departments']").text("{{ __('Yes, We like to use local levels structure') }}");
                //change next nearest blockquote-footer
                $("[for='use_departments']").siblings('.blockquote-footer').text(
                    "{{ __('This will allow you to view breckdown reports per your local levels structure (Depends on your subscription plan).') }}"
                );
            } else {
                $("[for='use_departments']").text("{{ __('No, just stop on Company level') }}");
                $("[for='use_departments']").siblings('.blockquote-footer').text(
                    "{{ __('By switching-off you will be unable to view breckdown reports per your local levels structure') }}"
                );
            }
        });
        //saveOrgInfo function
        saveOrgInfo = () => {
            //get data
            multiple_sectors = $("#multiple_sectors").bootstrapSwitch('state') ? 1 : 0;
            multiple_companies = $("#multiple_companies").bootstrapSwitch('state') ? 1 : 0;
            //use_departments
            use_departments = $("#use_departments").bootstrapSwitch('state') ? 1 : 0;
            //setup url
            url = "{{ route('clients.saveOrgInfo', ':id') }}";
            url = url.replace(':id', "{{ $id }}");
            //setup data
            data = {
                '_token': "{{ csrf_token() }}",
                'multiple_sectors': multiple_sectors,
                'multiple_companies': multiple_companies,
                'use_departments': use_departments,
                'use_sections': false
            };
            //send data
            $.ajax({
                url: url,
                type: 'POST',
                data: data,
                success: function(data) {
                    if (data.stat) { //sweet  alert
                        Swal.fire({
                            icon: 'success',
                            title: 'Done',
                            text: data.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        //reload page
                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }
        //addCompany function
        addCompany = () => {
            //add more company
            $("#addNewCompanDiv").append(`
            <div class="row">
            <div class="form-group col-md-10 col-sm-12"><label for="phone">{{ __('Company Offical Name') }}</label><input type="text" class="form-control" id="add_new_company" name="add_new_company[]" placeholder="{{ __('Enter Company Offical Name') }}">
            </div><div class="col-md-2 col-sm-12"><button type="button" class="btn btn-danger btn-xs" onclick="removeCompany(this)"><i class="fa fa-minus"></i></button>
            </div>`);

        }
        removeCompany = (e) => {
            //remove company
            $(e).parent().parent().remove();
        }
        //saveCompany function
        saveCompany = (sector = null) => {
            //get company name from input field name add_new_company[]
            add_new_company = $("input[name='add_new_company[]']").map(function() {
                return $(this).val();
            }).get();
        }
        //on document ready
        $(document).ready(function() {
            //on addLevel click
            $("#addLevelbtn").on("click", function() {
                //get count of children of addLevelDiv
                count = $("#addLevelDiv").children().length;
                console.log(count);
                if (count < 7) {
                    Leveln = "Level-" + (count + 1);
                    label = `{{ __('Your org chart label of ${Leveln}') }}`
                    prompt = `{{ __('Enter label of ${Leveln} of your org chart') }}`;
                    //add more level
                    $("#addLevelDiv").append(`
                   <div class="row row-levels">
                    <div class="col-md-6 col-sm-12 form-group">
                         <div class="row">
                        <label for="levels_label[]">${label}</label>
                        <div class="col-md-6 col-sm-12">
                            <a href="javascript:void(0)" class="btn btn-outline-danger btn-xs" onclick="removeLevel(this)" >
                                <i class="fa fa-minus"></i></a>
                        </div>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">${Leveln}:</span>
                            </div>
                            <input type="text" class="form-control" name="levels_label[]" placeholder="${prompt}">
                        </div>
                        <small class="text-muted">{{ __('Enter label of your org chart e.g. Directorate, Division, Department, Section or Unit') }}</small>

                    </div>
                   `);
                }
            });
            //removeLevel(this) function
            removeLevel = (e) => {
                //remove level
                $(e).parent().parent().parent().parent().remove();
                //reorder levels
                reorderLevels();
            }
            //reorderLevels function
            reorderLevels = () => {
                //get   count = $("#addLevelDiv").children().length;
                count = $("#addLevelDiv").children().length;
                index_start = 1;
                //make labels with new order
                labels = $("label[for='levels_label[]']").map(function() {
                    return $(this).val();
                }).get();
                //reorder
                $("label[for='levels_label[]']").each(function(index) {
                    Leveln = "Level-" + (index_start);
                    label = `{{ __('Your org chart label of ${Leveln}') }}`
                    prompt = `{{ __('Enter label of ${Leveln} of your org chart') }}`;
                    index_start++;
                    $(this).text(label);
                    //change placeholder
                    $(this).parent().parent().find("input").prop("placeholder", prompt);
                    //change span
                    $(this).parent().parent().find("span").text(Leveln);
                });
            }
        });
</script>
@endsection
