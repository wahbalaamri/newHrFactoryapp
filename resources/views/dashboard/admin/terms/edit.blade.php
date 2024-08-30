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
                <!-- /.col -->
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item">Dashboard </li>
                        <li class="breadcrumb-item active">Emails</li>
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
                            <h3 class="card-title">{{ __('Manage Autmated Emails') }}</h3>
                            {{-- tool --}}
                            <div class="card-tools">
                                <a href="{{ route('termsCondition.index') }}"
                                    class="btn btn-sm btn-tool {{ App()->getLocale() == 'ar' ? 'float-start' : 'float-end' }}">
                                    <i class="fas fa-arrow-left"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="col-md-8 col-sm-12">
                                    <form
                                        action="{{ $terms?route('termsCondition.update',$terms->id): route('termsCondition.store') }}"
                                        method="post">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6 col-sm-12 form-group">
                                                {{-- select country --}}
                                                <label for="country">{{ __('Select Country') }}</label>
                                                <select class="form-control" id="country" name="country">
                                                    <option value="">{{ __('Select Country') }}</option>
                                                    @if (auth()->user()->isAdmin)
                                                    <optgroup label="{{ __('Arab countries') }}">
                                                        @foreach ($countries[1] as $country)
                                                        <option value="{{ $country->id }}" @if($terms)
                                                            @selected(old('country',$terms->country_id)==$country->id)
                                                            @else @selected(old('country')==$country->id) @endif>
                                                            {{ $country->country_name }}
                                                        </option>
                                                        @endforeach
                                                    </optgroup>
                                                    <optgroup label="{{ __('Foreign countries') }}">
                                                        @foreach ($countries[0] as $country)
                                                        <option value="{{ $country->id }}" @if($terms)
                                                            @selected(old('country',$terms->country_id)==$country->id)
                                                            @else @selected(old('country')==$country->id) @endif>
                                                            {{ $country->country_name }}
                                                        </option>
                                                        @endforeach
                                                    </optgroup>
                                                    @else
                                                    @foreach ($countries as $country)
                                                    <option value="{{ $country->id }}" @if($terms)
                                                        @selected(old('country',$terms->country_id)==$country->id) @else
                                                        @selected(old('country')==$country->id) @endif>
                                                        {{ $country->country_name }}
                                                    </option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                                @error('country')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 col-sm-12 form-group">
                                                {{-- select Email Type --}}
                                                <label for="type">{{ __('Terms Type') }}</label>
                                                <select class="form-control" id="type" name="type">
                                                    <option value="">{{ __('Select Terms Type') }}</option>
                                                    <option value="Singup" @if($terms) @selected(old('country',$terms->
                                                        for)=="Singup") @else @selected(old('country')=="Singup")
                                                        @endif>{{ __('Singup') }} </option>
                                                    <option value="Login" @if($terms) @selected(old('country',$terms->
                                                        for)=="Login") @else @selected(old('country')=="Login")
                                                        @endif>{{ __('Login') }}</option>
                                                </select>
                                                @error('type')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            {{-- terms title in english --}}
                                            <div class="col-md-6 col-sm-12 form-group">
                                                <label for="title_en">{{ __('Title in English') }}</label>
                                                <input type="text" class="form-control" id="title_en"
                                                    value="@if($terms) {{ old('title_en',$terms->english_title) }} @else {{ old('title_en') }} @endif"
                                                    name="title_en" placeholder="{{ __('Enter title in English') }}">
                                                @error('title_en')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            {{-- terms title in arabic --}}
                                            <div class="col-md-6 col-sm-12 form-group">
                                                <label for="title_ar">{{ __('Title in Arabic') }}</label>
                                                <input type="text" class="form-control" id="title_ar"
                                                    value="@if($terms) {{ old('title_ar',$terms->arabic_title) }} @else {{ old('title_ar') }} @endif"
                                                    name="title_ar" placeholder="{{ __('Enter title in Arabic') }}">
                                                @error('title_ar')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            {{-- terms content in english --}}
                                            <div class="col-md-6 col-sm-12 form-group">
                                                <label for="content_en">{{ __('Content in English') }}</label>
                                                <textarea class="form-control summernote" id="content_en"
                                                    name="content_en"
                                                    placeholder="{{ __('Enter content in English') }}">
                                                        @if($terms) {{ old('content_en',$terms->english_text) }} @else {{ old('content_en') }} @endif
                                                    </textarea>
                                                @error('content_en')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            {{-- terms content in arabic --}}
                                            <div class="col-md-6 col-sm-12 form-group">
                                                <label for="content_ar">{{ __('Content in Arabic') }}</label>
                                                <textarea class="form-control summernote" id="content_ar"
                                                    name="content_ar" placeholder="{{ __('Enter content in Arabic') }}">
                                                        @if($terms) {{ old('content_ar',$terms->arabic_text) }} @else {{ old('content_ar') }} @endif
                                                    </textarea>
                                                @error('content_ar')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            {{-- is_active switch --}}
                                            <div class="col-md-6 col-sm-12 form-group">
                                                <label for="is_active">{{ __('Status') }}</label>
                                                <input type="checkbox" checked name="is_active" id="is_active"
                                                    data-bootstrap-switch="" data-off-color="danger"
                                                    data-on-color="success" value="1">
                                            </div>
                                            {{-- submit button --}}
                                            <div class="col-md-12 col-sm-12 form-group">
                                                <button type="submit" class="btn btn-outline-info btn-sm">{{ __('Save')
                                                    }}</button>
                                            </div>
                                    </form>
                                </div>

                            </div>
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
    $("[name='is_active']").bootstrapSwitch();
        $('.summernote').summernote({
            tabsize: 2,
            height: 120,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'help']]
            ]
        });
        //on document ready
        $(document).ready(function(){
            //check if $terms is not null
            terms="{{ $terms }}";
            active=true;
            active= "{{ $terms_is_active }}";
            //old value
            old="{{ old('is_active') }}"
            if(terms){
                //change based on old or $trems->is_active
                if(old){
                    //change stat of is_active bootstrap switch
                    $("[name='is_active']").bootstrapSwitch('state',(old | active));
                }else{
                    //change stat of is_active bootstrap switch
                    $("[name='is_active']").bootstrapSwitch('state',active);
                }

            }
            else{
                //change stat of is_active bootstrap switch
                $("[name='is_active']").bootstrapSwitch('state',(old==1 | active));
            }
        });
        //on is_active bootstrap switch change
        $("[name='is_active']").on('switchChange.bootstrapSwitch', function(event, state) {
            //check if the switch is on
            if(state){
                //set the value of is_active input to 1
                $("[name='is_active']").val(1)
            }else{
                //set the value of is_active input to 0
                $("[name='is_active']").val(0)
            }
        });
</script>
@endsection
