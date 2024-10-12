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
                        <h1 class="m-0">{{ $client->name }} {{ __('Employees') }}</h1>
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
                                <h3 class="card-title">{{ __('Manage Your Employees') }}</h3>
                                {{-- tool --}}
                                <div class="card-tools">
                                    {{-- back --}}
                                    <a href="{{ route('clients.manage', $id) }}"
                                        class="btn btn-sm btn-tool {{ App()->getLocale() == 'ar' ? 'float-start' : 'float-end' }}">
                                        <i class="fas fa-arrow-left"></i>
                                    </a>
                                    {{-- create new Employee --}}
                                    <a href="javascript:void(0);" id="addEmployee" data-toggle="modal"
                                        onclick="addEmployee()" data-target="#EmployeeModal"
                                        class="btn btn-sm btn-tool {{ App()->getLocale() == 'ar' ? 'float-end' : 'float-start' }}">
                                        <i class="fas fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                {{-- card --}}
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">{{ __('Upload Your Employees Data') }}</h3>
                                    </div>
                                    <div class="card-body">
                                        {{-- form to upload excel sheet --}}
                                        <form action="{{ route('clients.uploadEmployeeExcel', $id) }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group col-md-6 col-sm-12">
                                                {{-- download excel --}}
                                                <a href="{{ route('clients.DownloadEmployeeTemp', $id) }}" class="btn btn-outline-info btn-sm">
                                                    <i class="fa fa-download"></i>
                                                    {{ __('Download Employee Data Template') }}
                                                </a>
                                            </div>
                                            <div class="form-group col-md-6 col-sm-12">
                                                <label for="excel">{{ __('Upload Excel Sheet') }}</label>
                                                <input type="file" name="excel" class="form-control" required>
                                            </div>
                                            <div class="form-group col-sm-12">
                                                <button type="submit"
                                                    class="btn btn-outline-success btn-sm {{ App()->getLocale() == 'ar' ? 'float-start' : 'float-end' }}">{{ __('Upload') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table id="Employee-data"
                                        class="table table-hover table-striped table-bordered text-center text-sm">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>{{ __('Employee Name') }}</th>
                                                <th>{{ __('Email') }}</th>
                                                <th>{{ __('Phone') }}</th>
                                                <th>{{ __('Employee Type') }}</th>
                                                {{-- <th>{{__('Department')}}</th>
                                            <th>{{__('Company')}}</th>
                                            <th>{{__('Sector')}}</th>
                                            <th>{{__('HR Manager?')}}</th>
                                            <th>{{__('Is Active')}}</th>
                                            <th>{{__('Actions')}}</th> --}}
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    {{-- include editEmployee Modal --}}
    @include('dashboard.client.modals.editEmployee')
    <!-- /.content-wrapper -->
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        isUsingDepartment = "{{ $client->use_departments }}" == 1
        isUsingSections = "{{ $client->use_sections }}" == 1
        $(document).ready(function() {
            url = "{{ route('clients.Employees', ':d') }}";
            url = url.replace(':d', "{{ $id }}");
            $('#Employee-data').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                responsive: true,
                ajax: url,
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        "render": function(data, type, row) {
                            return '<button class="btn btn-xs btn-success mr-3 ml-3 text-xs show-more" data-id="' +
                                data.id + '"><i class="fa fa-eye"></i></button>' + data;
                        }
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'mobile',
                        name: 'mobile'
                    },
                    {
                        data: 'type',
                        name: 'type'
                    },
                    // {data: 'department', name: 'department'},
                    // {data: 'company', name: 'company'},
                    // {data: 'sector', name: 'sector'},
                    // {data: 'hr', name: 'hr', orderable: false, searchable: false},
                    // {data: 'active', name: 'active', orderable: false, searchable: false},
                    // {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
            //Employee-data width
            $('#Employee-data').css('width', '75%');
            var table = $('#Employee-data').DataTable();

            // Add a button to each row that, when clicked, shows the additional info div
            $('#Employee-data tbody').on('click', 'button.show-more', function() {
                var tr = $(this).closest('tr');
                var row = table.row(tr);
                var data = row.data();
                if (row.child.isShown()) {
                    // This row is already open - close it
                    this.innerHTML = '<i class="fa fa-eye"></i>';
                    //change button color
                    this.classList.remove('btn-danger');
                    this.classList.add('btn-success');
                    row.child.hide('slow');
                    tr.removeClass('shown');
                } else {
                    isAdmin = "{{ Auth::user()->isAdmin }}" == 1;
                    this.innerHTML = '<i class="fa fa-eye-slash"></i>';
                    //change button color
                    this.classList.remove('btn-success');
                    this.classList.add('btn-danger');
                    //html contente div
                    div =
                        '<div class="details-div"><table class="table table-striped-columns"><tr><th>Department</th><th>Company</th><th>Sector</th><th>HR Manager?</th><th>Status</th><th>Action</th>'
                    if (isAdmin)
                        div += '<th>Assign as user</th>'
                    div += '</tr><tr><td>'
                    div += data['department'] + '</td><td>' + data['company'] + '</td><td>'
                    div += data['sector'] + '</td><td>' + data['hr'] + '</td><td>'
                    div += data['active'] + '</td><td>' + data['action'] + '</td>'
                    if (isAdmin)
                        div += '<td>' + data['assign'] + '</td>'
                    div += '</tr></table></div>'
                    // Open this row
                    row.child(div).show('slow');
                    tr.addClass('shown');
                }
            });
            //on sector selected
            $('#sector').on('change', function() {
                var sector_id = $(this).val();
                getCompanies(sector_id);
            });
            //on company selected
            $('#company').on('change', function() {
                var company_id = $(this).val();
                if (isUsingDepartment)
                    getdepartments(company_id, 'r');
            });
            //on superdirectorate selected
            $('#superdirectorate').on('change', function() {
                var dep_id = $(this).val();
                if (isUsingDepartment)
                    getdepartments(dep_id, 's');
            })
            //on directorate selected
            $('#directorate').on('change', function() {
                var dep_id = $(this).val();
                if (isUsingDepartment)
                    getdepartments(dep_id, 'd');
            })
            //on division selected
            $('#division').on('change', function() {
                var division = $(this).val();
                if (isUsingDepartment)
                    getdepartments(division, 'di');
            })
            //on department selected
            $('#department').on('change', function() {
                var department = $(this).val();
                if (isUsingSections)
                    getSections(department);
            });
            //on SaveEmployee click
            $('#SaveEmployee').on('click', function() {
                var id = $(this).data('Empid');
                var name = $('#name').val();
                //check if name has value
                if (!name) {
                    //toaster
                    toastr.error('Please Enter Employee Name');
                    return;
                }
                var email = $('#email').val();
                //check if email has value
                if (!email) {
                    //toaster
                    toastr.error('Please Enter Employee Email');
                    return;
                }
                var mobile = $('#mobile').val();
                //check if mobile has value
                if (!mobile) {
                    //toaster
                    toastr.error('Please Enter Employee Phone');
                    return;
                }
                //type
                var type = $('#type').val();
                //check if type has vlue
                if (!type) {
                    //toaster
                    toastr.error('Please Select Employee Type');
                    return;
                }
                //position
                var position = $('#position').val();
                //check if position has value
                if (!position) {
                    //toaster
                    toastr.error('Please Enter Position');
                    return;
                }
                //department
                if (isUsingDepartment) {
                    department = null;
                    var department = $('#superdirectorate').val() ? $('#superdirectorate').val() :
                        department;
                    var department = $('#directorate').val() ? $('#directorate').val() : department;
                    var department = $('#division').val() ? $('#division').val() : department;
                    var department = $('#department').val() ? $('#department').val() : department;
                    if (isUsingSections) {
                        var department = $('#section').val() ? $('#section').val() : department;
                    }
                    //check if department has value
                    if (!department) {
                        //toaster
                        toastr.error('Please Select Department');
                        return;
                    }
                } else {
                    var department = null;
                }
                //company
                var company = $('#company').val();
                //check if company has value
                if (!company) {
                    //toaster
                    toastr.error('Please Select Company');
                    return;
                }
                //sector
                var sector = $('#sector').val();
                //check if sector has value
                if (!sector) {
                    //toaster
                    toastr.error('Please Select Sector');
                    return;
                }
                //client_id
                var client_id = "{{ $id }}";
                //url
                url = "{{ route('clients.storeEmployee') }}";
                //ajax
                $.ajax({
                    url: url,
                    type: "POST",
                    dataType: 'json',
                    data: {
                        id: id,
                        name: name,
                        email: email,
                        mobile: mobile,
                        type: type,
                        position: position,
                        department: department,
                        company: company,
                        sector: sector,
                        client_id: client_id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(data) {
                        $('#EmployeeModal').modal('hide');
                        $('#Employee-data').DataTable().ajax.reload();
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });
            //on addEmployee click
            $("#addEmployee").click(function() {
                $('#name').val('');
                $('#email').val('');
                $('#mobile').val('');
                $('#type').val('');
                $('#position').val('');
                $('#department').val('');
                $('#company').val('');
                $('#sector').val('');
                $('#SaveEmployee').data('Empid', '');
                $('#EmployeeModal').modal('show');
            });
            editEmp = (id) => {
                $("#EmployeeModalLabel").text('Edit Employee');
                url = "{{ route('clients.getEmployee', ';d') }}";
                url = url.replace(';d', id);
                $.ajax({
                    url: url,
                    type: "GET",
                    success: function(data) {
                        getCompanies(data.employee.sector_id);
                        //after 1 sec
                        // getdepartments(data.employee.comp_id, 'r');
                        getEmployeeDep(data.employee.dep_id);
                        setTimeout(function() {
                            $('#name').val(data.employee.name);
                            $('#email').val(data.employee.email);
                            $('#mobile').val(data.employee.mobile);
                            $('#type').val(data.employee.employee_type);
                            $('#position').val(data.employee.position);
                            //select department dropdown
                            $('#department').val(data.employee.dep_id);
                            $('#company').val(data.employee.comp_id);
                            $('#sector').val(data.employee.sector_id);
                            $('#SaveEmployee').data('Empid', data.employee.id);
                            $('#EmployeeModal').modal('show');
                        }, 500);
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }
            addEmployee = () => {
                $("#EmployeeModalLabel").text('Add Employee');
                $('#name').val('');
                $('#email').val('');
                $('#mobile').val('');
                $('#type').val('');
                $('#position').val('');
                $('#department').val('');
                $('#company').val('');
                $('#sector').val('');
                $('#SaveEmployee').data('Empid', '');
            }
            getdepartments = (id, type) => {
                url = "{{ route('client.departments', [':d', ':t']) }}";
                url = url.replace(':d', id);
                url = url.replace(':t', type);
                if (id) {
                    $.ajax({
                        url: url,
                        type: "GET",
                        success: function(data) {
                            if (type == 'r') {
                                $('#superdirectorate').empty();
                                $('#superdirectorate').append(
                                    '<option value="">Select Super directorate</option>');
                                $('#directorate').empty();
                                $('#directorate').append(
                                    '<option value="">Select Directorate</option>');
                                $('#division').empty();
                                $('#division').append('<option value="">Select Division</option>');
                                $('#department').empty();
                                $('#department').append(
                                    '<option value="">Select Department</option>');
                                $('#section').empty();
                                $('#section').append('<option value="">Select Section</option>');
                                $.each(data, function(index, department) {
                                    if (department.dep_level == 1) {
                                        $('#superdirectorate').append('<option value="' +
                                            department.id +
                                            '">' + department.name + '</option>');
                                    }
                                    if (department.dep_level == 2) {
                                        $('#directorate').append('<option value="' +
                                            department.id +
                                            '">' + department.name + '</option>');
                                    }
                                    if (department.dep_level == 3) {
                                        $('#division').append('<option value="' +
                                            department.id +
                                            '">' + department.name + '</option>');
                                    }
                                    if (department.dep_level == 4) {
                                        $('#department').append('<option value="' +
                                            department.id +
                                            '">' + department.name + '</option>');
                                    }
                                    if (department.dep_level == 5) {
                                        $('#section').append('<option value="' + department
                                            .id + '">' + department.name + '</option>');
                                    }
                                });
                            }
                            if (type == 's') {
                                $('#directorate').empty();
                                $('#directorate').append(
                                    '<option value="">Select Directorate</option>');
                                $('#division').empty();
                                $('#division').append('<option value="">Select Division</option>');
                                $('#department').empty();
                                $('#department').append(
                                    '<option value="">Select Department</option>');
                                $('#section').empty();
                                $('#section').append('<option value="">Select Section</option>');
                                $.each(data, function(index, department) {
                                    if (department.dep_level == 2) {
                                        $('#directorate').append('<option value="' +
                                            department.id +
                                            '">' + department.name + '</option>');
                                    }
                                    if (department.dep_level == 3) {
                                        $('#division').append('<option value="' +
                                            department.id +
                                            '">' + department.name + '</option>');
                                    }
                                    if (department.dep_level == 4) {
                                        $('#department').append('<option value="' +
                                            department.id +
                                            '">' + department.name + '</option>');
                                    }
                                    if (department.dep_level == 5) {
                                        $('#section').append('<option value="' +
                                            department.id +
                                            '">' + department.name + '</option>');
                                    }
                                });
                            }
                            if (type == 'd') {
                                $('#division').empty();
                                $('#division').append('<option value="">Select Division</option>');
                                $('#department').empty();
                                $('#department').append(
                                    '<option value="">Select Department</option>');
                                $('#section').empty();
                                $('#section').append('<option value="">Select Section</option>');
                                $.each(data, function(index, department) {

                                    if (department.dep_level == 3) {
                                        $('#division').append('<option value="' +
                                            department.id +
                                            '">' + department.name + '</option>');
                                    }
                                    if (department.dep_level == 4) {
                                        $('#department').append('<option value="' +
                                            department.id +
                                            '">' + department.name + '</option>');
                                    }
                                    if (department.dep_level == 5) {
                                        $('#section').append('<option value="' +
                                            department.id +
                                            '">' + department.name + '</option>');
                                    }
                                });
                            }
                            if (type == 'di') {
                                $('#department').empty();
                                $('#department').append(
                                    '<option value="">Select Department</option>');
                                $('#section').empty();
                                $('#section').append('<option value="">Select Section</option>');
                                $.each(data, function(index, department) {
                                    if (department.dep_level == 4) {
                                        $('#department').append('<option value="' +
                                            department.id +
                                            '">' + department.name + '</option>');
                                    }
                                    if (department.dep_level == 5) {
                                        $('#section').append('<option value="' +
                                            department.id +
                                            '">' + department.name + '</option>');
                                    }
                                });
                            }
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                }
            }
            getCompanies = (id) => {
                url = "{{ route('client.companies', ':d') }}";
                url = url.replace(':d', id);
                if (id) {
                    $.ajax({
                        url: url,
                        type: "GET",
                        success: function(data) {
                            $('#company').empty();
                            $('#company').append('<option value="">Select Company</option>');
                            $.each(data, function(index, company) {
                                $('#company').append('<option value="' + company.id + '">' +
                                    company.name + '</option>');
                            });
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                }
            }
            getSections = (id) => {
                url = "{{ route('client.departments', [':d', ':t']) }}";
                url = url.replace(':d', id);
                url = url.replace(':t', 'd');
                if (id) {
                    $.ajax({
                        url: url,
                        type: "GET",
                        success: function(data) {
                            $('#section').empty();
                            $('#section').append('<option value="">Select Section</option>');
                            $.each(data, function(index, section) {
                                $('#section').append('<option value="' + section.id + '">' +
                                    section.name + '</option>');
                            });
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                }
            }
            //assignUser click
            assignUser = (id) => {
                url = "{{ route('clients.AssignAsUser', [':d', ':c']) }}";
                url = url.replace(':d', id);
                url = url.replace(':c', "{{ $client->id }}");
                $.ajax({
                    url: url,
                    type: "GET",
                    success: function(data) {
                        $('#Employee-data').DataTable().ajax.reload();
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }
        });

        function getEmployeeDep(id) {
            if (id == null) {
                console.log('no id');
                return;
            }
            url = "{{ route('client.departments', [':d', ':t']) }}";
            url = url.replace(':d', id);
            url = url.replace(':t', 'ed');
            var next_id = null
            if (id) {
                $.ajax({
                    url: url,
                    type: "GET",
                    success: function(data) {
                        if (data.status) {
                            var dep_level = null;
                            $.each(data.departments, function(index, department) {
                                // department.id ==id
                                if (department.id == id) {
                                    next_id = department.parent_id
                                }
                                if (dep_level == null || dep_level != department.dep_level) {
                                    dep_level = department.dep_level;
                                    if (dep_level == 1) {
                                        //setup superdirectorate
                                        $('#superdirectorate').empty();
                                        $('#superdirectorate').append(
                                            '<option value="">Select Super directorate</option>');
                                    }
                                    if (dep_level == 2) {
                                        //setup directorate
                                        $('#directorate').empty();
                                        $('#directorate').append(
                                            '<option value="">Select Directorate</option>');
                                    }
                                    if (dep_level == 3) {
                                        //setup division
                                        $('#division').empty();
                                        $('#division').append(
                                            '<option value="">Select Division</option>');
                                    }
                                    if (dep_level == 4) {
                                        //setup department
                                        $('#department').empty();
                                        $('#department').append(
                                            '<option value="">Select Department</option>');
                                    }
                                    if (dep_level == 5) {
                                        //setup Section
                                        $('#section').empty();
                                        $('#section').append(
                                            '<option value="">Select section</option>');
                                    }
                                }
                                if (dep_level == 1) {
                                    selected = department.id == id ? "selected" : "";
                                    //setup superdirectorate
                                    $('#superdirectorate').append('<option value="' + department.id +
                                        '" ' + selected + '>' +
                                        department.name + '</option>');
                                }
                                if (dep_level == 2) {
                                    //setup directorate
                                    selected = department.id == id ? "selected" : "";
                                    $('#directorate').append('<option value="' +
                                        department.id +
                                        '"' + selected + '>' + department.name + '</option>');
                                }
                                if (dep_level == 3) {
                                    //setup division
                                    selected = department.id == id ? "selected" : "";
                                    $('#division').append('<option value="' +
                                        department.id +
                                        '"' + selected + '>' + department.name + '</option>');
                                }
                                if (dep_level == 4) {
                                    //setup department
                                    selected = department.id == id ? "selected" : "";
                                    $('#department').append('<option value="' + department.id + '" ' +
                                        selected + '>' + department
                                        .name + '</option>');
                                }
                                if (dep_level == 5) {
                                    //setup Section
                                    selected = department.id == id ? "selected" : "";
                                    $('#section').append('<option value="' +
                                        department.id +
                                        '"' + selected + '>' + department.name + '</option>');
                                }
                            });
                            if (next_id != null) {
                                getEmployeeDep(next_id);
                            }
                        }
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }
        }

        deleteEmp = (id) => {
            //Show delete confirmation swal
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
                        url = "{{ route('clients.deleteEmployee', [':d', ':c']) }}";
                        url = url.replace(':d', id);
                        url = url.replace(':c', "{{ $client->id }}");
                        $.ajax({
                            url: url,
                            type: "post",
                            data: { _token: '{{ csrf_token() }}' },
                            success: function(data) {
                                //if success
                                if (data.status) {
                                    //toaster
                                    toastr.success(data.message);
                                    //reload table
                                    $('#Employee-data').DataTable().ajax.reload();
                                }
                                else{
                                    //toaster
                                    toastr.error(data.message);
                                }
                            },
                            error: function(error) {
                                console.log(error);
                            }
                        });
                    }
                });
        }
    </script>
@endsection
