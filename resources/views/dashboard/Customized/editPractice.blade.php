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
                    <h1 class="m-0">{{ __('Customized Function') }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">
                            {{ __('Customized Function') }}</li>
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
                                <a href="{{ route('CustomizedSurvey.showPractices',$function->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-arrow-left"></i>
                                </a>
                            </div>
                        </div>
                        {{-- card body --}}
                        <div class="card-body">
                            {{-- form --}}
                            <form action="
                            {{$practice==null? route('CustomizedSurvey.storePractice',$function->id):route('CustomizedSurvey.updatePractice',$practice->id) }}" method="POST">
                                @csrf
                                @if ($practice)
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
                                        <label for="title">{{ __('Practice Title') }}</label>
                                        <input type="text" name="title" id="title" class="form-control"
                                            placeholder="Enter Practice Title" value="{{$practice!=NULL?old('title',$practice->title): old('title') }}">
                                        {{-- validation --}}
                                        @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    {{-- title_ar --}}
                                    <div class="form-group col-md-6 col-sm-12">
                                        <label for="title_ar">{{ __('Practice Title (Arabic)') }}</label>
                                        <input type="text" name="title_ar" id="title_ar" class="form-control"
                                            placeholder="Enter Practice Title in Arabic" value="{{$practice!=NULL?old('title_ar',$practice->title_ar): old('title_ar') }}">
                                        {{-- validation --}}
                                        @error('title_ar')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    {{-- description --}}
                                    <div class="form-group col-md-6 col-sm-12">
                                        <label for="description">{{ __('Practice Description') }}</label>
                                        <textarea name="description" id="description" class="form-control summernote"
                                            placeholder="Enter Practice Description">{{$practice!=NULL?old('description',$practice->description): old('description') }}</textarea>
                                        {{-- validation --}}
                                        @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    {{-- description_ar --}}
                                    <div class="form-group col-md-6 col-sm-12">
                                        <label for="description_ar">{{ __('Practice Description (Arabic)') }}</label>
                                        <textarea name="description_ar" id="description_ar"
                                            class="form-control summernote"
                                            placeholder="Enter Practice Description in Arabic">{{$practice!=NULL?old('description_ar',$practice->description_ar): old('description_ar') }}</textarea>
                                        {{-- validation --}}
                                        @error('description_ar')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6 col-sm-12">
                                        <label for="status">{{ __('Status') }}</label>
                                        <br>
                                        <input type="checkbox" name="status" checked data-bootstrap-switch
                                            data-off-color="danger" data-on-color="success">
                                    </div>
                                    <div @class([ 'form-group col-md-12 col-sm-12' , 'text-right'=>
                                        App()->isLocale('en'),
                                        'text-left'=>App()->isLocale('ar')
                                        ])>
                                        <button type="submit" class="btn btn-primary float-end">{{ __('Save')
                                            }}</button>
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
         $('.summernote').summernote();
</script>
@endsection
