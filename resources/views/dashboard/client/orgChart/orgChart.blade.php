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
                                        class="btn btn-sm btn-primary {{ App()->getLocale() == 'ar' ? 'float-start' : 'float-end' }}">{{ __('Back') }}</a>
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
                                                        <label
                                                            for="phone">{{ __('Do you have multiple sectors?') }}</label>
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
                                                        <label
                                                            for="phone">{{ __('Do you have multiple companies?') }}</label>
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox" role="switch"
                                                                id="multiple_companies" name="multiple_companies"
                                                                @checked($client->multiple_company)>
                                                            <label class="form-check-label"
                                                                for="multiple_companies">{{ __('No,
                                                                                                                                                                                                                                                            Only one company') }}</label>
                                                        </div>

                                                    </div>
                                                    {{-- use departments --}}
                                                    <div class="form-group col-md-6 col-sm-12">
                                                        <label
                                                            for="phone">{{ __('Would like to make your departments appearing in the system?') }}</label>
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox" role="switch"
                                                                id="use_departments" name="use_departments"
                                                                @checked($client->use_departments)>
                                                            <label class="form-check-label" for="use_departments">
                                                                @if ($client->use_departments)
                                                                    {{ __('Yes, We like to use department') }}
                                                                @else
                                                                    {{ __('No, just stop on Company level') }}
                                                                @endif
                                                            </label>
                                                            <small class="blockquote-footer">
                                                                @if ($client->use_departments)
                                                                    {{ __('This will allow you to view report per department (Depends on your subscription plan).') }}
                                                                @else
                                                                    {{ __('By unChecking you will not be able to view report by department') }}
                                                                @endif
                                                            </small>
                                                        </div>
                                                    </div>
                                                    {{-- use sections --}}
                                                    <div class="form-group col-md-6 col-sm-12">
                                                        <label
                                                            for="phone">{{ __('Would like to make your sections appearing in the system?') }}</label>
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox" role="switch"
                                                                id="use_sections" name="use_sections"
                                                                @checked($client->use_sections)>
                                                            <label class="form-check-label" for="use_sections">
                                                                @if ($client->use_sections)
                                                                    {{ __('Yes, We like to use sections') }}
                                                                @else
                                                                    {{ __('No, just stop on Department level') }}
                                                                @endif
                                                            </label>
                                                            <small class="blockquote-footer">
                                                                @if ($client->use_sections)
                                                                    {{ __('This will allow you to view reports per section (Depends on your subscription plan).') }}
                                                                @else
                                                                    {{ __('By unChecking you will not be able to view reports by section') }}
                                                                @endif
                                                            </small>
                                                        </div>
                                                    </div>
                                                    {{-- submit --}}
                                                    <div class="form-group col-sm-12">
                                                        <a href="javascript:void(0)" onclick="saveOrgInfo()"
                                                            @class([
                                                                'btn btn-outline-success btn-sm',
                                                                'float-right' => app()->isLocale('en'),
                                                                'float-left' => app()->isLocale('ar'),
                                                            ])>{{ __('Save') }}</a>
                                                    </div>
                                                </div>
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
                                                <form action="{{ route('clients.uploadOrgChartExcel', $id) }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="form-group col-md-6 col-sm-12">
                                                        <label for="excel">{{ __('Upload Excel Sheet') }}</label>
                                                        <input type="file" name="excel" class="form-control"
                                                            required>
                                                    </div>
                                                    <div class="form-group col-sm-12">
                                                        <button type="submit"
                                                            class="btn btn-outline-success btn-sm {{ App()->getLocale() == 'ar' ? 'float-start' : 'float-end' }}">{{ __('Upload') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="headingThree">
                                            <h2 class="mb-0">
                                                <button class="btn btn-link btn-block text-left" type="button"
                                                    data-toggle="collapse" data-target="#collapseThree"
                                                    aria-expanded="true" aria-controls="collapseThree">
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
                                                    data-toggle="collapse" data-target="#collapseFour"
                                                    aria-expanded="false" aria-controls="collapseFour">
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
        document.addEventListener('contextmenu', event => event.preventDefault());

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
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'super_department',
                        name: 'super_department'
                    },
                    {
                        data: 'level',
                        name: 'level'
                    },
                    {
                        data: 'company',
                        name: 'company'
                    },
                    {
                        data: 'sector',
                        name: 'sector'
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
                    text: "You won't be able to revert this!",
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
                $("[for='use_departments']").text("{{ __('Yes, We like to use department') }}");
                //change next nearest blockquote-footer
                $("[for='use_departments']").siblings('.blockquote-footer').text(
                    "{{ __('This will allow you to view report per department (Depends on your subscription plan).') }}"
                );
            } else {
                $("[for='use_departments']").text("{{ __('No, just stop on Company level') }}");
                $("[for='use_departments']").siblings('.blockquote-footer').text(
                    "{{ __('By unChecking you will not be able to view report by department') }}");
            }
        });
        //on use_sections bootstrapswitch event
        $('#use_sections').on('switchChange.bootstrapSwitch', function(event, state) {
            //check if state is true
            if (state) {
                //change use_sections label with for
                $("[for='use_sections']").text("{{ __('Yes, We like to use sections') }}");
                //change blockquote-footer
                $("[for='use_sections']").siblings('.blockquote-footer').text(
                    "{{ __('This will allow you to view reports per section (Depends on your subscription plan).') }}"
                );
            } else {
                $("[for='use_sections']").text("{{ __('No, just stop on Department level') }}");
                $("[for='use_sections']").siblings('.blockquote-footer').text(
                    "{{ __('By unChecking you will not be able to view reports by section') }}");
            }
        });
        //saveOrgInfo function
        saveOrgInfo = () => {
            //get data
            multiple_sectors = $("#multiple_sectors").bootstrapSwitch('state') ? 1 : 0;
            multiple_companies = $("#multiple_companies").bootstrapSwitch('state') ? 1 : 0;
            //use_departments
            use_departments = $("#use_departments").bootstrapSwitch('state') ? 1 : 0;
            //use_sections
            use_sections = $("#use_sections").bootstrapSwitch('state') ? 1 : 0;
            //setup url
            url = "{{ route('clients.saveOrgInfo', ':id') }}";
            url = url.replace(':id', "{{ $id }}");
            //setup data
            data = {
                '_token': "{{ csrf_token() }}",
                'multiple_sectors': multiple_sectors,
                'multiple_companies': multiple_companies,
                'use_departments': use_departments,
                'use_sections': use_sections
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
    </script>
@endsection
