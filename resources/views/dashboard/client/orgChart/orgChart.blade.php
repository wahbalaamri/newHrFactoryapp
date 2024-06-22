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
                                <a href="{{ route('clients.manage',$id) }}"
                                    class="btn btn-sm btn-primary {{ App()->getLocale()=='ar'? 'float-start':'float-end' }}">{{
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
                                                {{ __('Tree View') }}
                                            </button>
                                        </h2>
                                    </div>

                                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                        data-parent="#accordionExample">
                                        <div class="card-body">
                                            @include('dashboard.client.orgChart.OrgChartTree',['client'=>$client])
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="headingTwo">
                                        <h2 class="mb-0">
                                            <button class="btn btn-link btn-block text-left collapsed" type="button"
                                                data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false"
                                                aria-controls="collapseTwo">
                                                {{__('Table View')}}
                                            </button>
                                        </h2>
                                    </div>
                                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
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
        document.addEventListener('contextmenu', event => event.preventDefault());
        function ShowRespondents(id) {
            //show AddOrAssignAccting modal
            $('#AddOrAssignAccting').modal('show');
        }
        function ShowAdd(client_id,sector_id,type) {
            if(type=='sector'){
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
                url = "{{ route('industries.all',':id') }}";
                url = url.replace(':id',client_id);
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(data) {
                        option = '<option value="">{{ __('Select Sector') }}</option>';
                        options+=option;
                        data.forEach(function(industry) {
                            option = '<option value="'+industry.id+'">'+(isArabic?industry.name_ar:industry.name)+'</option>';
                            options+=option;
                        });
                        //.push other as last option to options
                        options+='<option value="other">{{ __('Other') }}</option>';
                        //append options to selector
                        $("#Selector_Sector").html(options);
                    }
                });
                $('#Selector_Sector').select2(
                );
                $('.select2-container ').css('width','100%');
            }else if(type=='comp'){
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
            }else if(type=='dep'){
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
            }else if(type=='sub-dep'){
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
        selectedSector=()=>{
            if($('#Selector_Sector').val()=='other'){
                $('#addNewSector').removeClass('d-none');
            }else{
                $('#addNewSector').addClass('d-none');
            }
        }
        function saveSCD(button){
            //get type
            form=button.parentElement.parentElement;
            type = form.type.value;
            PostedData=[null];
           if(type=='sector'){
                //get sector_id
                sector_id = form.sector_id.value;
                if(sector_id=='other' && (form.name_en.value=='' || form.name_ar.value=='')){
                    alert('Please enter sector name');
                    return;

                }
                if(sector_id==''){
                    alert('Please select sector');
                    return;
                }
                //build data
                client_id=form.client_id.value;
                    type=form.type.value;
                    _id=sector_id;
                    name_en=form.name_en.value;
                    name_ar=form.name_ar.value;
                    is_hr = null;
                    dep_id = form.dep_id.value;
            }
            else if(type=='comp'){
                //get sector_id
                sector_id = form.sector_id.value;
                client_id=form.client_id.value;
                    type=form.type.value;
                    _id=sector_id;
                    name_en=form.name_en.value;
                    name_ar=form.name_ar.value;
                    is_hr = null;
                    dep_id = form.dep_id.value;

            }
            else if(type=='dep'){
                //get company_id
                company_id = form.company_id.value;
                //build data
                client_id=form.client_id.value;
                    type=form.type.value;
                    _id=company_id;
                    name_en=form.name_en.value;
                    name_ar=form.name_ar.value;
                    is_hr = form.is_hr.checked;
                    dep_id = form.dep_id.value;
            }
            else if(type=='sub-dep'){
                //get department_id
                department_id = form.department_id.value;
                //build data
                client_id=form.client_id.value;
                    type=form.type.value;
                    _id=department_id;
                    name_en=form.name_en.value;
                    name_ar=form.name_ar.value;
                    is_hr = form.is_hr.checked;
                    dep_id = form.dep_id.value;

            }

            //setup url
            data = {
                    '_token':"{{ csrf_token() }}",
                    'client_id':client_id,
                    'type':type,
                    '_id':_id,
                    'name_en':name_en,
                    'name_ar':name_ar,
                    'is_hr':is_hr,
                    'dep_id':dep_id
                };
            url = "{{ route('clients.saveSCD') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data:data,
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
            url = "{{ route('clients.orgChart',':id') }}";
                url = url.replace(':id',"{{ $id }}");
            $('#Departments-data').DataTable({
                processing: true,
                serverSide: true,
                ajax: url,
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name'},
                    {data: 'super_department', name: 'super_department'},
                    {data: 'level', name: 'level'},
                    {data: 'company', name: 'company'},
                    {data: 'sector', name: 'sector'},
                    {data: 'is_hr', name: 'is_hr'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
            //make table width 100%
            $('#Departments-data').css('width', '100%');
            //on EditDep show modal
            EditDep=(id,comp,client,type)=>{
                //setup url
                url = "{{ route('client.getDep',':id') }}";
                url = url.replace(':id',id);
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
                        $("input[name='is_hr']").bootstrapSwitch('state',data.department.is_hr);
                        //show modal
                        $('#AddNewSecCompDep').modal('show');
                    }
                });
            }
        });
</script>
@endsection
