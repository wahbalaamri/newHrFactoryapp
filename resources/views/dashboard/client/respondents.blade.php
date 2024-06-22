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
                    <h1 class="m-0">{{ __('Employees') }}</h1>
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
                                <a href="{{ route('clients.surveyDetails', [$id, $type, $survey->id]) }}"
                                    class="btn btn-sm btn-tool {{ App()->getLocale() == 'ar' ? 'float-start' : 'float-end' }}">
                                    <i class="fas fa-arrow-left"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="Employee-data"
                                    class="table table-hover table-striped table-bordered text-center text-sm">
                                    <thead>

                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('Respondents') }}</th>
                                            <th>{{ __('Employee Name') }}</th>
                                            <th>{{ __('Email') }}</th>
                                            <th>{{ __('Phone') }}</th>
                                            <th>{{ __('Position') }}</th>
                                            {{-- <th>{{__('HR Manager?')}}</th>
                                            <th>{{__('Actions')}}</th>
                                            <th>{{__('Send Survey')}}</th>
                                            <th>{{__('Send Reminder')}}</th>
                                            <th>{{__('Raters')}}</th> --}}
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <td colspan=""></td>
                                            <td>
                                                {{-- button to read ids --}}
                                                @if ($survey_type == 5 || $survey_type == 6)
                                                <a href="javascript:void(0)" onclick="SetAsCandidate()"
                                                    class="btn btn-sm btn-primary" id="read-all">
                                                    {{ __('Save') }}
                                                </a>
                                                @else
                                                <a href="javascript:void(0)" onclick="SetAsRespondent()"
                                                    class="btn btn-sm btn-primary" id="read-all">
                                                    {{ __('Save') }}
                                                </a>
                                                @endif
                                            </td>
                                            <td colspan=""></td>
                                            <td colspan=""></td>
                                            <td colspan=""></td>
                                            {{-- <td colspan=""></td>
                                            <td colspan=""></td>
                                            <td colspan=""></td>
                                            <td colspan=""></td>
                                            <td colspan=""></td> --}}
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- /.content-wrapper -->
{{-- include AddRater --}}
@include('dashboard.client.modals.RatersModal')
@endsection
@section('scripts')
<script>
    $(document).ready(function() {
            type = "{{ $type }}";
            url = "{{ route('clients.Respondents', [':d', ':type', ':survey']) }}";
            url = url.replace(':d', "{{ $id }}");
            url = url.replace(':type', "{{ $type }}");
            url = url.replace(':survey', "{{ $survey->id }}");
            $('#Employee-data').DataTable({
                processing: true,
                serverSide: true,
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
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
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
                        data: 'position',
                        name: 'position'
                    },
                    // {data: 'hr', name: 'hr'},
                    // {data: 'action', name: 'action', orderable: false, searchable: false},
                    // {data: 'SendSurvey', name: 'SendSurvey', orderable: false, searchable: false},
                    // {data: 'SendReminder', name: 'SendReminder', orderable: false, searchable: false},
                    // {data: 'raters', name: 'raters', orderable: false, searchable: false},
                ],
                "columnDefs": [{
                    "targets": 1,
                    "render": function(data, type, row) {

                        if (row.is_candidate_raters) {

                            if (row.isAddedAsCandidate == true) {
                                return '<input type="checkbox" class="row-select" value="' + row
                                    .id +
                                    '" checked><label class="form-check-label" for="exampleCheck1">Selected as Candidate</label>';
                            } else {
                                return '<input type="checkbox" class="row-select" value="' + row
                                    .id +
                                    '"><label class="form-check-label" for="exampleCheck1">Add as Candidate</label>';
                            }
                        } else {
                            if (row.isAddAsRespondent == true) {
                                return '<input type="checkbox" class="row-select" value="' + row
                                    .id +
                                    '" checked><label class="form-check-label" for="exampleCheck1">Selected as Respondent</label>';
                            } else {
                                return '<input type="checkbox" class="row-select" value="' + row
                                    .id +
                                    '"><label class="form-check-label" for="exampleCheck1">Add as Respondent</label>';
                            }
                        }
                    }
                }],
                //         "drawCallback": function(settings) {
                //     var api = this.api();
                //     api.rows().every(function() {
                //         var data = this.data();

                //         if (data.service_type != 5 || data.service_type != 6) {
                //             // Remove the 3rd column (index 2) if the status is 'inactive'
                //             $('#Employee-data').DataTable().column(10).visible(false);
                //         }
                //         else{
                //             $('#Employee-data').DataTable().column(8).visible(false);
                //             $('#Employee-data').DataTable().column(9).visible(false);
                //         }
                //     });
                // }
            });
            //====================================================
            var table = $('#Employee-data').DataTable();
            // Add a button to each row that, when clicked, shows the additional info div
            $('#Employee-data tbody').on('click', 'button.show-more', function() {
                var isCandidateRaters = "{{ $is_candidate_raters }}";
                isCandidateRaters=isCandidateRaters==1?true:false;
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
                    this.innerHTML = '<i class="fa fa-eye-slash"></i>';
                    //change button color
                    this.classList.remove('btn-success');
                    this.classList.add('btn-danger');
                    // Open this row
                    row_data =
                        '<div class="details-div"><table class="table table-striped-columns"><tr><th>' +
                        "{{ __('HR Manager?') }}" + '</th><th>' + "{{ __('Actions') }}" +
                        '</th>'
                    if (!isCandidateRaters) {
                        row_data += '<th>' + "{{ __('Send Survey') }}" + '</th><th>' +
                            "{{ __('Send Reminder') }}" + '</th>'
                    }
                    if (isCandidateRaters) {
                        row_data += '<th>' + "{{ __('Raters') }}" + '</th><th>' + "{{ __('Results') }}" +
                            '</th>'
                    }
                    row_data += '</tr><tr><td>' +
                        data['hr'] + '</td><td>' + data['action'] + '</td>'
                    if (!isCandidateRaters) {
                        row_data += '<td>' + data['SendSurvey'] + '</td><td>' +
                            data['SendReminder'] + '</td>';
                    }
                    if (isCandidateRaters) {
                        row_data += '<td>' + data['raters'] + '</td>' + '<td>' + data['result'] + '</td>';
                    }
                    row_data += '</tr></table></div>';
                    row.child(row_data).show('slow');
                    tr.addClass('shown');
                }
            });
            //  Employee-data width 100%
            $('#Employee-data').css('width', '100%');
            SetAsRespondent = () => {
                var ids = [];
                $('.row-select:checked').each(function() {
                    ids.push($(this).val());
                });
                if (ids.length > 0) {
                    $.ajax({
                        url: "{{ route('clients.saveSurveyRespondents') }}",
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "ids": ids,
                            "survey": "{{ $survey_id }}",
                            "type": "{{ $type }}",
                            "client": "{{ $id }}",
                            "tool_type":"normal"
                        },
                        success: function(data) {
                            if (data.status) {
                                $('#Employee-data').DataTable().ajax.reload();
                                toastr.success(data.message);
                            }
                            if (!data.status) {
                                console.log(data);
                            }
                        }
                    });
                } else {
                    toastr.error("Please select at least one Employee");
                }
            }
        });
        //SetAsCandidate
        SetAsCandidate = () => {
            var ids = [];
            $('.row-select:checked').each(function() {
                ids.push($(this).val());
            });
            if (ids.length > 0) {
                $.ajax({
                    url: "{{ route('clients.saveSurveyCandidates') }}",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "ids": ids,
                        "survey": "{{ $survey_id }}",
                        "type": "{{ $type }}",
                        "client": "{{ $id }}",
                        "tool_type":"normal"
                    },
                    success: function(data) {
                        if (data.status) {
                            toastr.success(data.message);
                            $('#Employee-data').DataTable().ajax.reload();
                        }
                        if (!data.status) {
                            console.log(data);
                        }
                    }
                });
            } else {
                toastr.error("Please select at least one Employee");
            }
        }
        //on AddRaters
        AddRaters = (id) => {
            $('#candidate_id').val(id)

            getSectors(id);
            $("#Raters").DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                ajax: "{{ route('sector.getRaters', [':id', ':survey']) }}".replace(':id', id).replace(
                    ':survey', "{{ $survey->id }}"),
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
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
                        data: 'position',
                        name: 'position'
                    },
                    {
                        data: 'dep_id',
                        name: 'dep_id'
                    },
                    {
                        data: 'rtype',
                        name: 'rtype'
                    },

                ],
                "columnDefs": [{
                    "targets": 6,
                    "render": function(data, type, row) {
                        if (row.isAdded) {
                            return `<input type="checkbox" class="row-select" value="${row.id} " checked onchange="SaveRater(this,' ${row.id}','${row.Cid}','${row.type}')"><label class="form-check-label" for="exampleCheck1">Selected as Rater</label>`;
                        } else {
                            return `<input type="checkbox" class="row-select" value="${row.id} " onchange="SaveRater(this,' ${row.id}','${row.Cid}','${row.type}')"><label class="form-check-label" for="exampleCheck1">Select as Rater</label>`;
                        }
                    }
                }],
            })
        }
        //on sector selected
        $('#sector').on('change', function() {
            var sector_id = $(this).val();
            getCompanies(sector_id);
        });
        //on company selected
        $('#company').on('change', function() {
            var company_id = $(this).val();
            getdepartments(company_id);
        });
        getdepartments = (id) => {
            url = "{{ route('client.departments', ':d') }}";
            url = url.replace(':d', id);
            if (id) {
                $.ajax({
                    url: url,
                    type: "GET",
                    success: function(data) {
                        $('#department').empty();
                        $('#department').append('<option value="">Select Department</option>');
                        $.each(data, function(index, department) {
                            $('#department').append('<option value="' + department.id + '">' +
                                department.name + '</option>');
                        });
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
                            $('#company').append('<option value="' + company.id + '">' + company
                                .name + '</option>');
                        });
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }
        }
        getSectors = (id) => {
            url = "{{ route('sector.sectors', ':d') }}"
            url = url.replace(':d', id);
            $.ajax({
                url: url,
                type: "GET",
                success: function(data) {
                    if (data.status) {
                        $('#sector').html();
                        options = '<option value="">{{ __('Select Sector') }}</option>';
                        data.sectors.forEach(element => {
                            options += '<option value="' + element.id + '">' + element.name +
                                '</option>';
                        });
                        $('#sector').html(options);
                        $('#sector').select2();
                        $('#AddRaters').modal('show');
                    }
                    if (!data.status) {
                        console.log("fff");
                        console.log(data);
                    }
                }
            });
        }
        SaveRater = (ctr, id, cid, type) => {
            //check if ctr is checked
            let url = "{{ App\Http\Facades\TempURL::getTempURL('clients.SaveRaters', 5) }}"
            action = "";
            ctr.checked ? action = "add" : action = "remove";
            survey = "{{ $survey->id }}";
            $.ajax({
                url: url,
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id,
                    "cid": cid,
                    "type": type,
                    "survey": survey,
                    "action": action,
                    "client_id":"{{ $id }}",
                    "stype":"{{ $survey_type }}"
                },
                success: function(data) {
                    if (data.stat) {
                        toastr.success(data.message);
                        //$("#Raters").DataTable reload
                        $("#Raters").DataTable().ajax.reload();
                    }
                    if (!data.stat) {
                        toastr.error(data.message);
                    }
                }
            });
        }
</script>
@endsection
