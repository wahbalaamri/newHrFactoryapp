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
                    @elseif ($service_type==10)
                    {{ __('Customized Employee Engagment Tool') }}</h1>
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
                            @elseif ($service_type==10)
                            Customized Employee Engagment
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
                            @can('create',new App\Models\Functions)
                            <div class="card-tools">
                                <a href="@if ($service_type==4)
                                    {{ route('ManageHrDiagnosis.createFunction') }}

                                @elseif ($service_type==5)
                                    {{ route('Leader360Review.createFunction') }}
                                @elseif($service_type==3)
                                    {{ route('EmployeeEngagment.createFunction') }}
                                @elseif($service_type==10)
                                    {{ route('CEmployeeEngagment.createFunction') }}
                                @endif" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-plus"></i>
                                </a>
                            </div>
                            @endcan
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
                                                @can('view', $function)
                                                <a href=" @if ($service_type==4)
                                                {{ route('ManageHrDiagnosis.showPractices',$function->id) }}
                                                @elseif($service_type==5)
                                                {{ route('Leader360Review.showPractices',$function->id) }}
                                                @elseif($service_type==3)
                                                {{ route('EmployeeEngagment.showPractices',$function->id) }}
                                                @elseif($service_type==10)
                                                {{ route('CEmployeeEngagment.showPractices',$function->id) }}
                                                @endif
                                                " class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i> {{ __('View Practices')
                                                    }}</a>
                                                @endcan
                                            </td>
                                            <td>
                                                @can('update',$function)
                                                <a href="@if ($service_type==4)
                                                    {{ route('ManageHrDiagnosis.editFunction',$function->id) }}
                                                    @elseif($service_type==5)
                                                    {{ route('Leader360Review.editFunction',$function->id) }}
                                                    @elseif($service_type==3)
                                                    {{ route('EmployeeEngagment.editFunction',$function->id) }}
                                                    @elseif($service_type==10)
                                                    {{ route('CEmployeeEngagment.editFunction',$function->id) }}
                                                    @endif" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @endcan
                                                @can('delete',$function)
                                                <button type="button" class="btn btn-danger btn-sm"
                                                    onclick="confirmDelete({{ $function->id }})">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                <form id="delete-form-{{ $function->id }}" action="@if ($service_type==4)
                                                        {{ route('ManageHrDiagnosis.destroyFunction',$function->id) }}
                                                        @elseif($service_type==5)
                                                        {{ route('Leader360Review.destroyFunction',$function->id) }}
                                                        @elseif($service_type==3)
                                                        {{ route('EmployeeEngagment.destroyFunction',$function->id) }}
                                                        @elseif($service_type==10)
                                                        {{ route('CEmployeeEngagment.destroyFunction',$function->id) }}
                                                        @endif" method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                @endcan
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
                            @if(count($functions)<1)
                            {{-- copy from other service --}}
                            {{-- card --}}
                            <div class="card card-outline card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">{{ __('Copy from another tool') }}</h3>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('CEmployeeEngagment.CopyFunctions',$service_type) }}" method="POST">
                                        @csrf
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="type">{{ __('Service Type') }}</label>
                                                        <select name="type" id="type" class="form-control">
                                                            <option value="">{{ __('Select Service Type') }}
                                                            </option>
                                                            @if($service_type!=1)
                                                            <option value="1" @if (old('type') == '1') selected @endif>
                                                                {{ __('Manual Builder') }}</option>
                                                            @endif
                                                            @if($service_type!=2)
                                                            <option value="2" @if (old('type') == '2') selected @endif>
                                                                {{ __('Files') }}</option>
                                                                @endif
                                                            @if($service_type!=3)
                                                            <option value="3" @if (old('type') == '3') selected @endif>
                                                                {{ __('Employee Engagment') }}
                                                            </option>
                                                            @endif
                                                            @if($service_type!=4)
                                                            <option value="4" b @if (old('type') == '4') selected
                                                                @endif>
                                                                {{ __('HR Diagnosis') }}</option>
                                                                @endif
                                                            @if($service_type!=5)
                                                            <option value="5" @if (old('type') == '5') selected @endif>
                                                                {{ __('360 Review') }}</option>
                                                                @endif
                                                            @if($service_type!=6)
                                                            <option value="6" @if (old('type') == '6') selected @endif>
                                                                {{ __('360 Review - Nama') }}</option>
                                                                @endif
                                                            @if($service_type!=7)
                                                            <option value="7" @if (old('type') == '7') selected @endif>
                                                                {{ __('Customized surveys') }}</option>
                                                                @endif
                                                            @if($service_type!=8)
                                                            <option value="8" @if (old('type') == '8') selected @endif>
                                                                {{ __('Chat-bot') }}</option>
                                                                @endif
                                                            @if($service_type!=9)
                                                            <option value="9" @if (old('type') == '9') selected @endif>
                                                                {{ __('Calculator') }}</option>
                                                                @endif
                                                            @if($service_type!=10)
                                                            <option value="10" @if (old('type') == '10') selected @endif>
                                                                {{ __('Customized Employee Engagment') }}</option>
                                                                @endif
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    {{-- submit button --}}
                                                    <div class="col-md-12">
                                                        <button type="submit" class="btn btn-primary">{{ __('Copy') }}</button>
                                                    </div>
                                                </div>
                                            </div>
                                    </form>
                                </div>
                            </div>
                            @endif
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
