@extends('dashboard.layouts.main')
@section('content')
<!-- Content Wrapper. Contains page content -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        @if($service_type==4)
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
                                @elseif($service_type==5)
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
                            <form
                                action="
                                @if($service_type==4)
                                {{ $question==null? route('ManageHrDiagnosis.storeQuestion',$practice->id): route('ManageHrDiagnosis.updateQuestion',$question->id) }}
                                @elseif($service_type==5)
                                {{ $question==null? route('Leader360Review.storeQuestion',$practice->id): route('Leader360Review.updateQuestion',$question->id) }}
                                @elseif($service_type==3)
                                {{ $question==null? route('EmployeeEngagment.storeQuestion',$practice->id): route('EmployeeEngagment.updateQuestion',$question->id) }}
                                @endif"
                                method="POST">
                                @csrf
                                @if($question!=null)
                                @method('PUT')
                                @endif
                                {{-- SHOW ERRORS --}}
                                @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                                <div class="row">
                                    <div class="form-group col-md-6 col-sm-12">
                                        <label for="question">{{ __('Question') }}</label>
                                        <input type="text" name="question" id="question" class="form-control"
                                            placeholder="Enter Question"
                                            value="{{ $question!=null?old('question',$question->question):old('question') }}">
                                        {{-- validation --}}
                                        @error('question')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    {{-- question arabic --}}
                                    <div class="form-group col-md-6 col-sm-12">
                                        <label for="question_ar">{{ __('Question Arabic') }}</label>
                                        <input type="text" name="question_ar" id="question_ar" class="form-control"
                                            placeholder="Enter Question Arabic"
                                            value="{{ $question!=null?old('question_ar',$question->question_ar):old('question_ar') }}">
                                        {{-- validation --}}
                                        @error('question_ar')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    {{-- description --}}
                                    <div class="form-group col-md-6 col-sm-12">
                                        <label for="description">{{ __('Description') }}</label>
                                        <textarea name="description" id="description" class="form-control summernote"
                                            placeholder="Enter Description">{{ $question!=null?old('description',$question->description):old('description') }}</textarea>
                                        {{-- validation --}}
                                        @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    {{-- description_ar --}}
                                    <div class="form-group col-md-6 col-sm-12">
                                        <label for="description_ar">{{ __('Description Arabic') }}</label>
                                        <textarea name="description_ar" id="description_ar"
                                            class="form-control summernote"
                                            placeholder="Enter Description Arabic">{{ $question!=null?old('description_ar',$question->description_ar):old('description_ar') }}</textarea>
                                        {{-- validation --}}
                                        @error('description_ar')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    {{-- respondent --}}
                                    <div class="form-group col-md-6 col-sm-12">
                                        <label for="respondent">{{ __('Respondent') }}</label>
                                        <select name="respondent" id="respondent" class="form-control">
                                            <option value="">{{ __('Select Respondent') }}</option>
                                            <option value="1" @if ($question!=null) @if (old('respondent',$question->
                                                respondent)==1)
                                                selected
                                                @endif
                                                @else
                                                @if (old('respondent')==1)
                                                selected
                                                @endif
                                                @endif>{{ __('Only HR Employees') }}</option>
                                            <option value="2" @if ($question!=null) @if (old('respondent',$question->
                                                respondent)==2)
                                                selected
                                                @endif
                                                @else
                                                @if (old('respondent')==2)
                                                selected
                                                @endif
                                                @endif>{{ __('Only Employees') }}</option>
                                            <option value="3" @if ($question!=null) @if (old('respondent',$question->
                                                respondent)==3)
                                                selected
                                                @endif
                                                @else
                                                @if (old('respondent')==3)
                                                selected
                                                @endif
                                                @endif>{{ __('Only Managers') }}</option>
                                            <option value="4" @if ($question!=null) @if (old('respondent',$question->
                                                respondent)==4)
                                                selected
                                                @endif
                                                @else
                                                @if (old('respondent')==4)
                                                selected
                                                @endif
                                                @endif>{{ __('HR Employees & Employees') }}</option>
                                            <option value="5" @if ($question!=null) @if (old('respondent',$question->
                                                respondent)==5)
                                                selected
                                                @endif
                                                @else
                                                @if (old('respondent')==5)
                                                selected
                                                @endif
                                                @endif>{{ __('Managers & Employees') }}</option>
                                            <option value="6" @if ($question!=null) @if (old('respondent',$question->
                                                respondent)==6)
                                                selected
                                                @endif
                                                @else
                                                @if (old('respondent')==6)
                                                selected
                                                @endif
                                                @endif>{{ __('Managers & HR Employees') }}</option>
                                            <option value="7" @if ($question!=null) @if (old('respondent',$question->
                                                respondent)==7)
                                                selected
                                                @endif
                                                @else
                                                @if (old('respondent')==7)
                                                selected
                                                @endif
                                                @endif>{{ __('All Employees') }}</option>
                                            <option value="8" @if ($question!=null) @if (old('respondent',$question->
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
                                    @if($service_type==3)
                                    {{-- IsENPS --}}
                                    <div class="form-group col-md-6 col-sm-12">
                                        <label for="IsENPS">{{ __('Is ENPS') }}</label>
                                        <br>
                                        <input type="checkbox" name="IsENPS" @if ($question!=null) @if($question->IsENPS) checked @endif @else checked @endif data-bootstrap-switch
                                            data-off-color="danger" data-on-color="success">
                                    </div>
                                    @endif
                                    {{-- status --}}
                                    <div class="form-group col-md-6 col-sm-12">
                                        <label for="status">{{ __('Status') }}</label>
                                        <br>
                                        <input type="checkbox" name="status" @if ($question!=null) @if($question->status) checked @endif @else checked @endif data-bootstrap-switch
                                            data-off-color="danger" data-on-color="success">
                                    </div>
                                    <div class="form-group col-md-12 col-sm-12">
                                        <button type="submit" class="btn btn-success">{{ __('Save') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section('scripts')
<script>
    $("[name='status']").bootstrapSwitch();
    $("[name='IsENPS']").bootstrapSwitch();
         $('.summernote').summernote();
</script>
@endsection
