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
                            <h3 class="card-title">{{ __('Manage Partners') }}</h3>
                            {{-- tool --}}
                            <div class="card-tools">

                                {{-- create new Employee --}}
                                <a href="javascript:void(0);"
                                    data-url="{{ App\Http\Facades\TempURL::getTempURL('partners.create', 5) }}"
                                    id="addEmployee" data-toggle="modal" data-target="#editPartner"
                                    class="btn btn-sm btn-tool {{ App()->getLocale()=='ar'? 'float-end':'float-start' }}">
                                    <i class="fas fa-plus"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="card card-outline card-info w-75">
                                    <div class="card-header">
                                        <div class="card-title">{{ __('filter area') }}</div>
                                    </div>
                                    <div class="card-body">

                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="card card-outline card-blue w-100">
                                    <div class="card-header">
                                        <div class="card-title">{{ __('Data area') }}</div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row w-100">
                                            {{-- responsive table --}}
                                            <div class="table-responsive">
                                                <table id="Partner-table"
                                                    class="table table-bordered table-hover table-head-fixed table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>{{ __('Partner Name') }}</th>
                                                            <th>{{ __('Country') }}</th>
                                                            <th>{{ __('Partnership') }}</th>
                                                            <th>{{ __('Focal Points') }}</th>
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
                </div>
            </div>
        </div>
    </section>
</div>
@include('dashboard.partners.Modals.EditPartner')
@include('dashboard.partners.Modals.FocalPointsModal')
@include('dashboard.partners.Modals.editPartnerFocalPoint')
@include('dashboard.partners.Modals.PartnershipsModal')
@include('dashboard.partners.Modals.editPartnership')
<div id="PartnerEdit" data-url="{{ $url}}" data-url2="{{ \App\Http\Facades\TempURL::getTempURL('partner.edit',5) }}">
</div>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $("#Pstatus").bootstrapSwitch();
    $("#focal_status").bootstrapSwitch();
    $("#exclusivity").bootstrapSwitch();
    $("#Partnershipstatus").bootstrapSwitch();
    //on Pstatus change
    $('#Pstatus').on('switchChange.bootstrapSwitch', function (event, state) {
        if (state) {
            //set Pstatus prop checked true
            $("#Pstatus").attr('checked', true);
        } else {
            $("#Pstatus").attr('checked', false);
        }
    });
    //on focal_status change
    $('#focal_status').on('switchChange.bootstrapSwitch', function (event, state) {
        if (state) {
           //set focal_status prop checked true
           $("#focal_status").attr('checked', true);
        } else {
            $("#focal_status").attr('checked', false);
        }
    });
    //on exclusivity change
    $('#exclusivity').on('switchChange.bootstrapSwitch', function (event, state) {
        if (state) {
            //set exclusivity prop checked true
            $("#exclusivity").attr('checked', true);
        } else {
            $("#exclusivity").attr('checked', false);
        }
    });
    //on Partnershipstatus change
    $('#Partnershipstatus').on('switchChange.bootstrapSwitch', function (event, state) {
        if (state) {
            //set Partnershipstatus prop checked true
            $("#Partnershipstatus").attr('checked', true);
        } else {
            $("#Partnershipstatus").attr('checked', false);
        }
    });
    // ===
    var element = document.getElementById("PartnerEdit");
let url = element.getAttribute('data-url');
let url2 = element.getAttribute('data-url2');
console.log("dw");
$('#Partner-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: url,
    columns: [{
            data: 'DT_RowIndex',
            name: 'DT_RowIndex',
            orderable: false,
            searchable: false,
            // "render": function(data, type, row) {
            //     return '<button class="btn btn-xs btn-success mr-3 ml-3 text-xs show-more" data-id="' + row.id + '"><i class="fa fa-eye"></i></button>';
            // }
        },
        { data: 'name', name: 'name' },
        { data: 'country', name: 'country' },
        {
            data: 'Partnership',
            name: 'Partnership',
            "render": function(data, type, row) {
                return '<button class="btn btn-xs btn-info mr-3 ml-3 text-xs show-more" onclick="ShowPartnerships(\'' + row.Partnerships + '\',\'' + row.SavePartnerships + '\')"  data-id="' + row.id + '" data-toggle="modal" data-target="#PartnershipsModal"><span>Partnerships: <span title="This Partner is available in' + row.partnerships_count + 'Country/Countries" class="badge bg-warning">' + row.partnerships_count + '</span></span></button>';
            }
        },
        {
            data: 'FocalPoints	',
            name: 'FocalPoints	',
            "render": function(data, type, row) {
                return '<a href="javascript:void(0)" onclick="ShowPartnerFocalPoints(\'' + row.FocalPoints + '\',\'' + row.SaveFocalPoints + '\')" class="btn btn-xs btn-success mr-3 ml-3 text-xs show-more" data-id="' + row.id + '" data-toggle="modal" data-target="#focalPointsModal"><span>' + row.name + ' Focal Points: <span title="' + row.focal_points_count + ' direct Contact" class="badge bg-warning">' + row.focal_points_count + '</span></span></a>';
            },

        },
        {
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false,

        },
    ],
    //on ready
    "drawCallback": (s) => {
        // console.log("ss");
    },
    //on error
    "error": (s) => {
            console.log("error");
        }
        //on event inside table


});
//$('#Partner-table') width 100
$('#Partner-table').css('width', '100%');
//on website change
$('#website').on('change', function() {
    var website = $(this).val();
    //check if it's containing http:// or https://
    if (website.includes("http://") || website.includes("https://")) {
        //if http:// update the prepend
        if (website.includes("http://")) {
            website = website.replace("http://", "");
            //get previouse element
            var prev = $('#website').prev();
            // get first child of prev
            var first = prev.children().first();
            //update the first child
            first.text("http://");
        }
        //if https:// update the prepend
        if (website.includes("https://")) {
            website = website.replace("https://", "");
            //get previouse element
            var prev = $('#website').prev();
            // get first child of prev
            var first = prev.children().first();
            //update the first child
            first.text("https://");
        }
        $('#website').val(website);
    } else {
        $('#website').val(website);
    }
});
// on SavePartner clicked
$("#SavePartner").click(() => {
    //check if id is null
    if ($('#id').val() == '') {
        //if null add new partner
        addPartner();
    } else {
        //if not null update partner
        updatePartner();
    }
});
//add new partner
function addPartner() {
    //get all values
    var name = $('#name').val();
    var country = $('#country').val();
    var website = $('#website').val();
    var logo = $('#logo').prop('files')[0];
    //if Pstatus check
    if ($('#Pstatus').is(':checked')) {
        var Pstatus = 1;
    } else {
        var Pstatus = 0;
    }
    //check if name input are filled
    if (name == '') {
        //sweetalert
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: "You need to fill partner name",
        });
        return;
    }
    //check if country input are filled
    if (country == '') {
        //sweetalert
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: "You need to select partner country",
        });
        return;
    }
    var formData = new FormData();
    formData.append('name', name);
    formData.append('country', country);
    formData.append('website', website);
    formData.append('logo', logo);
    formData.append('Pstatus', Pstatus);
    formData.append('_token', $('input[name="_token"]').val());
    //send request to add new partner
    $.ajax({
        type: "POST",
        url: url2,
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(response) {
            //if success reload the table
            if (response.stat) {
                //sweetalert
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.msg,
                });
                $('#Partner-table').DataTable().ajax.reload();
                //clear all inputs
                clearInputs();
            } else {
                //sweetalert
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.msg,
                });
            }
        },
        error: function(error) {
            console.log(error);
        }
    });
}

    // =====
</script>
<script src="{{ asset('assets/js/Partnerships.js') }}"></script>
<script src="{{ asset('assets/js/PartnerFocalPoint.js') }}"></script>
{{-- <script src="{{ asset('assets/js/partner.js') }}"></script> --}}

@endsection
