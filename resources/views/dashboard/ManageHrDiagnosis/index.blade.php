@extends('dashboard.layouts.main')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        @if ($service_type==4)
                        {{ __('HR Diagnosis Tool') }}</h1>
                    @elseif ($service_type==5)
                    {{ __('360 Review Tool') }}</h1>
                    @elseif ($service_type==3)
                    {{ __('Employee Engagment Tool') }}</h1>
                    @endif
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">
                            @if ($service_type==4)
                            HR Diagnosis
                            @elseif ($service_type==5)
                            360 Review
                            @elseif ($service_type==3)
                            Employee Engagment
                            @endif
                        </li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('Functions') }}
                            </h3>
                            <div class="card-tools">
                                <a href="@if ($service_type==4)
                                    {{ route('ManageHrDiagnosis.createFunction') }}

                                @elseif ($service_type==5)
                                    {{ route('Leader360Review.createFunction') }}
                                @elseif($service_type==3)
                                    {{ route('EmployeeEngagment.createFunction') }}
                                @endif" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-plus"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('Function Title') }}</th>
                                            <th>{{ __('Function Practices') }}</th>
                                            <th>{{ __('Actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($functions)>0)
                                        @foreach($functions as $function)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $function->title }}</td>
                                            <td>
                                                {{-- button to view practices --}}

                                                <a href=" @if ($service_type==4)
                                                {{ route('ManageHrDiagnosis.showPractices',$function->id) }}
                                                @elseif($service_type==5)
                                                {{ route('Leader360Review.showPractices',$function->id) }}
                                                @elseif($service_type==3)
                                                {{ route('EmployeeEngagment.showPractices',$function->id) }}
                                                @endif
                                                " class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i> {{ __('View Practices')
                                                    }}</a>
                                            </td>
                                            <td>
                                                <a href="@if ($service_type==4)
                                                    {{ route('ManageHrDiagnosis.editFunction',$function->id) }}
                                                    @elseif($service_type==5)
                                                    {{ route('Leader360Review.editFunction',$function->id) }}
                                                    @elseif($service_type==3)
                                                    {{ route('EmployeeEngagment.editFunction',$function->id) }}
                                                    @endif" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-danger btn-sm"
                                                    onclick="confirmDelete({{ $function->id }})">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                <form id="delete-form-{{ $function->id }}"
                                                    action="@if ($service_type==4)
                                                        {{ route('ManageHrDiagnosis.destroyFunction',$function->id) }}
                                                        @elseif($service_type==5)
                                                        {{ route('Leader360Review.destroyFunction',$function->id) }}
                                                        @elseif($service_type==3)
                                                        {{ route('EmployeeEngagment.destroyFunction',$function->id) }}
                                                        @endif"
                                                    method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </td>
                                            @endforeach
                                            @else
                                        <tr>
                                            <td colspan="4" class="text-center">{{ __('No Data Found') }}</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
    </section>
</div>
@endsection
@section('scripts')
<script src=""></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmDelete(id) {
        Swal.fire({
            title: "{{ __('Are you sure?') }}",
            text: "{{ __('You will not be able to recover this data') }}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: "{{ __('Yes, delete it!') }}",
            cancelButtonText: "{{ __('Cancel') }}",
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }});
            }
</script>
@endsection
