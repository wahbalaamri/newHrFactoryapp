@extends('dashboard.layouts.main')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">@if($service_type==4)
                        {{ __('HR Diagnosis Tool') }}
                        @elseif($service_type==5)
                        {{ __('360 Review Tool') }}
                        @elseif($service_type==3)
                        {{ __('Employee Engagment Tool') }}
                        @endif
                    </h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">
                            @if($service_type == 4)
                            HR Diagnosis
                            @elseif($service_type == 5)
                            360 Review
                            @elseif($service_type == 3)
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
                    <div class="card card-outline card-success">
                        {{-- card header --}}
                        <div class="card-header">
                            <h3 class="card-title">{{ __('Add New Function') }}</h3>
                            <div class="card-tools">
                                <a href="@if($service_type==4)
                                {{ route('ManageHrDiagnosis.index') }}
                                @elseif ($service_type==5)
                                {{ route('Leader360Review.index') }}
                                @elseif($service_type==3)
                                {{ route('EmployeeEngagment.index') }}
                                @endif
                                " class="btn btn-warning btn-sm">
                                    <i class="fas fa-arrow-left"></i>
                                </a>
                            </div>
                        </div>
                        {{-- card body --}}
                        <div class="card-body">
                            {{-- form --}}
                            <form action="@if($service_type==4)
                            {{ $function==null? route('ManageHrDiagnosis.storeFunction') : route('ManageHrDiagnosis.updateFunction',$function->id) }}
                            @elseif($service_type==5)
                            {{ $function==null? route('Leader360Review.storeFunction') : route('Leader360Review.updateFunction',$function->id) }}
                            @elseif($service_type==3)
                            {{ $function==null? route('EmployeeEngagment.storeFunction') : route('EmployeeEngagment.updateFunction',$function->id) }}
                            @endif
                            " method="POST">
                                @csrf
                                @if ($function!=null)
                                @method('PUT')
                                @endif
                                <div class="row">
                                    <div class="form-group col-md-6 col-sm-12">
                                        <label for="title">{{ __('Function Title') }}</label>
                                        <input type="text" name="title" id="title" class="form-control"
                                            placeholder="Enter Function Title"
                                            value="{{ $function==null? old('title'):old('title',$function->title) }}">
                                        {{-- validation --}}
                                        @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    {{-- title_ar --}}
                                    <div class="form-group col-md-6 col-sm-12">
                                        <label for="title_ar">{{ __('Function Title (Arabic)') }}</label>
                                        <input type="text" name="title_ar" id="title_ar" class="form-control"
                                            placeholder="Enter Function Title in Arabic"
                                            value="{{ $function==null? old('title_ar'):old('title_ar',$function->title_ar) }}">
                                        {{-- validation --}}
                                        @error('title_ar')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    {{-- description --}}
                                    <div class="form-group col-md-6 col-sm-12">
                                        <label for="description">{{ __('Function Description') }}</label>
                                        <textarea name="description" id="description" class="form-control summernote"
                                            placeholder="Enter Function Description">{{ $function==null? old('description'):old('description',$function->description) }}</textarea>
                                        {{-- validation --}}
                                        @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    {{-- description_ar --}}
                                    <div class="form-group col-md-6 col-sm-12">
                                        <label for="description_ar">{{ __('Function Description (Arabic)') }}</label>
                                        <textarea name="description_ar" id="description_ar"
                                            class="form-control summernote"
                                            placeholder="Enter Function Description in Arabic">{{ $function==null? old('description_ar'):old('description_ar',$function->description_ar) }}</textarea>
                                        {{-- validation --}}
                                        @error('description_ar')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    {{-- select respondent --}}
                                    <div class="form-group col-md-6 col-sm-12">
                                        <label for="respondent">{{ __('Select Respondent') }}</label>
                                        <select name="respondent" id="respondent" class="form-control">
                                            <option value="">{{ __('Select Respondent') }}</option>
                                            <option value="1" @if ($function!=null) @if (old('respondent',$function->
                                                respondent)==1)
                                                selected
                                                @endif
                                                @else
                                                @if (old('respondent')==1)
                                                selected
                                                @endif
                                                @endif>{{ __('Only HR Employees') }}</option>
                                            <option value="2" @if ($function!=null) @if (old('respondent',$function->
                                                respondent)==2)
                                                selected
                                                @endif
                                                @else
                                                @if (old('respondent')==2)
                                                selected
                                                @endif
                                                @endif>{{ __('Only Employees') }}</option>
                                            <option value="3" @if ($function!=null) @if (old('respondent',$function->
                                                respondent)==3)
                                                selected
                                                @endif
                                                @else
                                                @if (old('respondent')==3)
                                                selected
                                                @endif
                                                @endif>{{ __('Only Managers') }}</option>
                                            <option value="4" @if ($function!=null) @if (old('respondent',$function->
                                                respondent)==4)
                                                selected
                                                @endif
                                                @else
                                                @if (old('respondent')==4)
                                                selected
                                                @endif
                                                @endif>{{ __('HR Employees & Employees') }}</option>
                                            <option value="5" @if ($function!=null) @if (old('respondent',$function->
                                                respondent)==5)
                                                selected
                                                @endif
                                                @else
                                                @if (old('respondent')==5)
                                                selected
                                                @endif
                                                @endif>{{ __('Managers & Employees') }}</option>
                                            <option value="6" @if ($function!=null) @if (old('respondent',$function->
                                                respondent)==6)
                                                selected
                                                @endif
                                                @else
                                                @if (old('respondent')==6)
                                                selected
                                                @endif
                                                @endif>{{ __('Managers & HR Employees') }}</option>
                                            <option value="7" @if ($function!=null) @if (old('respondent',$function->
                                                respondent)==7)
                                                selected
                                                @endif
                                                @else
                                                @if (old('respondent')==7)
                                                selected
                                                @endif
                                                @endif>{{ __('All Employees') }}</option>
                                            <option value="8" @if ($function!=null) @if (old('respondent',$function->
                                                respondent)==8)
                                                selected
                                                @endif
                                                @else
                                                @if (old('respondent')==8)
                                                selected
                                                @endif
                                                @endif>{{ __('Public') }}</option>
                                        </select>
                                        {{-- validation --}}
                                        @error('respondent')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    {{-- switch for isDriver --}}
                                    @if($service_type==3)
                                    <div class="form-group col-md-6 col-sm-12">
                                        <label for="IsDriver">{{ __('Is Driver') }}</label>
                                        <br>
                                        <input type="checkbox" name="IsDriver" checked data-bootstrap-switch
                                            data-off-color="danger" data-on-color="success">
                                    </div>
                                    @endif
                                    {{-- switch for status --}}
                                    <div class="form-group col-md-6 col-sm-12">
                                        <label for="status">{{ __('Status') }}</label>
                                        <br>
                                        <input type="checkbox" name="status" checked data-bootstrap-switch
                                            data-off-color="danger" data-on-color="success">
                                    </div>
                                    {{-- submit button --}}
                                    <div @class([ 'form-group col-md-12 col-sm-12' , 'text-right'=>
                                        App()->isLocale('en'),
                                        'text-left'=>App()->isLocale('ar')
                                        ])>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save"></i> {{ __('Save') }}
                                        </button>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection
@section('scripts')
<script>
    $("[name='status']").bootstrapSwitch();
    $("[name='IsDriver']").bootstrapSwitch();
         $('.summernote').summernote();
</script>
@endsection
