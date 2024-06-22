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
                                <a href="{{ route('clients.manage',$id) }}"
                                    class="btn btn-sm btn-tool {{ App()->getLocale()=='ar'? 'float-start':'float-end' }}">
                                    <i class="fas fa-arrow-left"></i>
                                </a>
                                {{-- create new Employee --}}
                                <a href="javascript:void(0);" id="addEmployee" data-toggle="modal" data-target="#EmployeeModal"
                                    class="btn btn-sm btn-tool {{ App()->getLocale()=='ar'? 'float-end':'float-start' }}">
                                    <i class="fas fa-plus"></i>
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
                                            <th>{{__('Employee Name')}}</th>
                                            <th>{{__('Email')}}</th>
                                            <th>{{__('Phone')}}</th>
                                            <th>{{__('Employee Type')}}</th>
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
<script>
    $(document).ready(function() {
            url="{{ route('clients.Employees',':d') }}";
            url=url.replace(':d',"{{$id}}");
            $('#Employee-data').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                responsive: true,
                ajax: url,
                columns:[
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false,
                    "render": function (data, type, row) {
                return '<button class="btn btn-xs btn-success mr-3 ml-3 text-xs show-more" data-id="' + data.id + '"><i class="fa fa-eye"></i></button>'+data;
            }},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'mobile', name: 'mobile'},
                    {data: 'type', name: 'type'},
                    // {data: 'department', name: 'department'},
                    // {data: 'company', name: 'company'},
                    // {data: 'sector', name: 'sector'},
                    // {data: 'hr', name: 'hr', orderable: false, searchable: false},
                    // {data: 'active', name: 'active', orderable: false, searchable: false},
                    // {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
            //Employee-data width
            $('#Employee-data').css('width','75%');
            var table = $('#Employee-data').DataTable();

// Add a button to each row that, when clicked, shows the additional info div
$('#Employee-data tbody').on('click', 'button.show-more', function () {
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
        row.child('<div class="details-div"><table class="table table-striped-columns"><tr><th>Department</th><th>Company</th><th>Sector</th><th>HR Manager?</th><th>Status</th><th>Action</th></tr><tr><td>'
            +data['department']+'</td><td>'+data['company']+'</td><td>'
                +data['sector']+'</td><td>'+data['hr']+'</td><td>'
                    +data['active']+'</td><td>'+data['action']+'</td></tr></table></div>').show('slow');
        tr.addClass('shown');
    }
});
            //on sector selected
            $('#sector').on('change',function(){
                var sector_id=$(this).val();
                getCompanies(sector_id);
            });
            //on company selected
            $('#company').on('change',function(){
                var company_id=$(this).val();
                getdepartments(company_id);
            });
            //on SaveEmployee click
            $('#SaveEmployee').on('click',function(){
                var id=$(this).data('Empid');
                var name=$('#name').val();
                var email=$('#email').val();
                var mobile=$('#mobile').val();
                //type
                var type=$('#type').val();
                //position
                var position=$('#position').val();
                //department
                var department=$('#department').val();
                //company
                var company=$('#company').val();
                //sector
                var sector=$('#sector').val();
                //client_id
                var client_id="{{$id}}";
                //url
                url="{{ route('clients.storeEmployee') }}";
                //ajax
                $.ajax({
                    url:url,
                    type:"POST",
                    dataType:'json',
                    data:{
                        id:id,
                        name:name,
                        email:email,
                        mobile:mobile,
                        type:type,
                        position:position,
                        department:department,
                        company:company,
                        sector:sector,
                        client_id:client_id,
                        _token:"{{ csrf_token() }}"
                    },
                    success:function(data){
                        $('#EmployeeModal').modal('hide');
                        $('#Employee-data').DataTable().ajax.reload();
                    },
                    error:function(error){
                        console.log(error);
                    }
                });
            });
            //on addEmployee click
            $("#addEmployee").click(function(){
                $('#name').val('');
                $('#email').val('');
                $('#mobile').val('');
                $('#type').val('');
                $('#position').val('');
                $('#department').val('');
                $('#company').val('');
                $('#sector').val('');
                $('#SaveEmployee').data('Empid','');
                $('#EmployeeModal').modal('show');
            });
            editEmp=(id)=>{
                url="{{ route('clients.getEmployee',';d') }}";
                url=url.replace(';d',id);
                $.ajax({
                    url:url,
                    type:"GET",
                    success:function(data){
                        getCompanies(data.employee.sector_id);
                        //after 1 sec
                        getdepartments(data.employee.comp_id);
                        setTimeout(function(){
                        $('#name').val(data.employee.name);
                        $('#email').val(data.employee.email);
                        $('#mobile').val(data.employee.mobile);
                        $('#type').val(data.employee.type);
                        $('#position').val(data.employee.position);
                        //select department dropdown
                        $('#department').val(data.employee.dep_id);
                        $('#company').val(data.employee.comp_id);
                        $('#sector').val(data.employee.sector_id);
                        $('#SaveEmployee').data('Empid',data.employee.id);
                        $('#EmployeeModal').modal('show');
                    },500);
                    },
                    error:function(error){
                        console.log(error);
                    }
                });
            }
            getdepartments=(id)=>{
                url="{{ route('client.departments',':d') }}";
                url=url.replace(':d',id);
                if(id){
                    $.ajax({
                        url:url,
                        type:"GET",
                        success:function(data){
                            $('#department').empty();
                            $('#department').append('<option value="">Select Department</option>');
                            $.each(data,function(index,department){
                                $('#department').append('<option value="'+department.id+'">'+department.name+'</option>');
                            });
                        },
                        error:function(error){
                            console.log(error);
                        }
                    });
                }
            }
            getCompanies=(id)=>{
                url="{{ route('client.companies',':d') }}";
                url=url.replace(':d',id);
                if(id){
                    $.ajax({
                        url:url,
                        type:"GET",
                        success:function(data){
                            $('#company').empty();
                            $('#company').append('<option value="">Select Company</option>');
                            $.each(data,function(index,company){
                                $('#company').append('<option value="'+company.id+'">'+company.name+'</option>');
                            });
                        },
                        error:function(error){
                            console.log(error);
                        }
                    });
                }
            }
        });
</script>
@endsection
