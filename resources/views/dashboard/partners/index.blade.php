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
</script>
<script src="{{ asset('assets/js/Partnerships.js') }}"></script>
<script src="{{ asset('assets/js/PartnerFocalPoint.js') }}"></script>
<script src="{{ asset('assets/js/partner.js') }}"></script>

@endsection
