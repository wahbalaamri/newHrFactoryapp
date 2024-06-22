@extends('dashboard.layouts.main')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
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
                            <h3 class="card-title">{{ __('Show Survey Details') }}</h3>
                            {{-- tool --}}
                            <div class="card-tools">
                                {{-- back --}}
                                <a href="{{ route('clients.surveyDetails',[$id,$type,$survey->id])}}"
                                    class="btn btn-sm btn-tool {{ App()->getLocale()=='ar'? 'float-start':'float-end' }}">{{
                                    __('Back') }}</a>
                                {{-- create new survey --}}
                            </div>
                        </div>
                        <div class="card-body">
                            <form
                                action="{{ route('clients.storeSurveyEmail',[$id,$type,$survey,$emailContet!=null?$emailContet->id:null]) }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-6 col-sm-12">
                                        <label for="subject">{{ __('E-mail Title') }}(EN)</label>
                                        <input type="text" name="subject" id="subject" class="form-control"
                                            placeholder="{{ __('E-mail Title') }}" required
                                            value="{{ old('subject',$emailContet!=null?$emailContet->subject:'') }}">
                                        @error('subject')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6 col-sm-12">
                                        <label for="subject_ar">{{ __('E-mail Title') }}(AR)</label>
                                        <input type="text" name="subject_ar" id="subject_ar" class="form-control"
                                            placeholder="{{ __('E-mail Title') }}" required
                                            value="{{ old('subject_ar',$emailContet!=null?$emailContet->subject_ar:'') }}">
                                        @error('subject_ar')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    @if($emailContet!=null)
                                    <div class="form-group col-md-6 col-sm-12">
                                        {{-- show logo image--}}
                                        <img src="{{ asset('uploads/emails/'.$emailContet->logo) }}" alt="logo"
                                            class="img-thumbnail" style="width: 100px;height:100px">
                                    </div>
                                    @endif
                                    <div class="form-group col-md-6 col-sm-12">
                                        <label for="survey_logo">{{ __('Survey Logo') }}</label>
                                        <input type="file" name="survey_logo" id="survey_logo"
                                            class="form-control form-control-file" placeholder="{{ __('Survey Logo') }}"
                                            {{ $emailContet==null ? 'required': '' }}>
                                        @error('survey_logo')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    {{-- switch --}}
                                    <div class="form-group col-md-6 col-sm-12">
                                        <label for="status">{{ __('Email Status') }}</label>
                                        <br>
                                        <input type="checkbox" name="status" id="status" @if($emailContet!=null) @if($emailContet->status) checked @endif @else checked @endif data-bootstrap-switch
                                            data-off-color="danger" data-on-color="success">
                                    </div>
                                    @if($emailContet!=null)
                                    @if($emailContet->use_client_logo && $client->logo_path!=null)
                                    <div class="form-group col-md-6 col-sm-12" id="CLImage">
                                        {{-- show logo image--}}
                                        <img src="{{ asset('uploads/companies/logos/'.$client->logo_path) }}" alt="logo"
                                            class="img-thumbnail" style="width: 100px;height:100px">
                                    </div>
                                    @endif
                                    @endif
                                    <div class="form-group col-md-6 col-sm-12">
                                        <label for="Client_logo_status">{{ __('Use Client Logo') }}</label>
                                        <br>
                                        <input type="checkbox" name="Client_logo_status" id="Client_logo_status"
                                            data-bootstrap-switch data-off-color="danger" data-on-color="success" @if($emailContet!=null) @if($emailContet->use_client_logo) checked @endif  @endif>
                                    </div>
                                    {{-- upload client logo --}}
                                    <div id="Upload_client_logo" class="form-group col-md-6 col-sm-12  @if($emailContet!=null)
                                    @if(!$emailContet->use_client_logo || $client->logo_path!=null )d-none @endif @else d-none @endif">
                                        <label for="client_logo">{{ __('Client Logo') }}</label>
                                        <input type="file" name="client_logo" id="client_logo"
                                            class="form-control form-control-file" placeholder="{{ __('Client Logo') }}"
                                            @if($emailContet!=null) @if($emailContet->use_client_logo) required @endif @endif>
                                        @error('client_logo')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-7 col-sm-12">
                                        <label for="email_body">{{ __('E-mail Body') }}(EN)</label>
                                        <textarea name="email_body" id="email_body" class="form-control summernote"
                                            placeholder="{{ __('E-mail Body') }}" required>{{ old('email_body',$emailContet!=null?$emailContet->body_header:'') }}</textarea>
                                        @error('email_body')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-7 col-sm-12">
                                        <label for="email_body_ar">{{ __('E-mail Body') }}(AR)</label>
                                        <textarea name="email_body_ar" id="email_body_ar"
                                            class="form-control summernote" placeholder="{{ __('E-mail Body') }}"
                                            required>{{ old('email_body_ar',$emailContet!=null?$emailContet->body_header_ar:'') }}</textarea>
                                        @error('email_body_ar')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-7 col-sm-12">
                                        <label for="email_footer">{{ __('E-mail Footer') }}(EN)</label>
                                        <textarea name="email_footer" id="email_footer" class="form-control summernote"
                                            placeholder="{{ __('E-mail Footer') }}" required>{{ old('email_footer',$emailContet!=null?$emailContet->body_footer:'') }}</textarea>
                                        @error('email_footer')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-7 col-sm-12">
                                        <label for="email_footer_ar">{{ __('E-mail Footer') }}(AR)</label>
                                        <textarea name="email_footer_ar" id="email_footer_ar"
                                            class="form-control summernote" placeholder="{{ __('E-mail Footer') }}"
                                            required>{{ old('email_footer_ar',$emailContet!=null?$emailContet->body_footer_ar:'') }}</textarea>
                                        @error('email_footer_ar')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
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
    $("#Client_logo_status").bootstrapSwitch();
    $("#status").bootstrapSwitch();
    $('.summernote').summernote({toolbar: [
        ['style', ['style']],
        ['font', ['bold', 'underline', 'clear']],
        ['fontname', ['fontname']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['table', ['table']],
        ['insert', ['link', 'picture', 'video']],
        ['view', ['fullscreen', 'help']],
        ],});

        // on Client_logo_status change
        $('#Client_logo_status').on('switchChange.bootstrapSwitch', function (event, state) {
            if(state){
             //get current url
                var url = window.location.href;
                //split url
                var urlArr = url.split('/');
                //get second element
                var id = urlArr[6];
                //logo_path
                //ajax request
                requestUrl="{{ route('clients.getClientLogo',':id') }}"
                requestUrl = requestUrl.replace(':id', id);
                $.ajax({
                    url: requestUrl,
                    type: 'GET',
                    success: function (data) {
                        if(data.logo==null){
                            $('#Upload_client_logo').removeClass('d-none');
                            // add required into client_logo
                            $('#client_logo').attr('required','required');

                        }                     //set logo path
                        else{
                            $('#CLImage').removeClass('d-none');
                            $('#client_logo').removeAttr('required');
                            $('#Upload_client_logo').addClass('d-none');
                        }
                    }
                });
            }
            else{
                $('#Upload_client_logo').addClass('d-none');
                $('#CLImage').addClass('d-none');
                // remove required from client_logo
                $('#client_logo').removeAttr('required');
            }
        });
</script>
@endsection
