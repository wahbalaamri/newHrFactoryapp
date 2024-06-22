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
                    <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('Send Survey Now') }}</h3>
                            {{-- tool --}}
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                        class="fas fa-plus"></i>
                                </button>
                                {{-- back --}}
                                <a href="{{ route('clients.surveyDetails',[$id,$type,$survey->id])}}"
                                    class="btn btn-sm btn-tool {{ App()->getLocale()=='ar'? 'float-start':'float-end' }}">{{
                                    __('Back') }}</a>
                                {{-- create new survey --}}
                            </div>
                        </div>
                        <div class="card-body" style="display: none">
                            <form action="{{ route('clients.sendSurvey',[$id,$type,$survey]) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    {{-- show all errors --}}
                                    @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif
                                </div>
                                <div class="row">
                                    {{-- select for client sectors --}}
                                    <div class="form-group col-md-6 col-sm-12">
                                        <label for="sector">{{ __('Select Sector') }}</label>
                                        <select name="sector" id="sector" class="form-control">
                                            <option value="">{{ __('Select Sector') }}</option>
                                            @foreach ($client->sectors as $sector)
                                            <option value="{{ $sector->id }}">
                                                {{ $sector->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('sector')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    {{-- select for client companies --}}
                                    <div class="form-group col-md-6 col-sm-12">
                                        <label for="company">{{ __('Select Company') }}</label>
                                        <select name="company" id="company" class="form-control">
                                            <option value="">{{ __('Select Company') }}</option>
                                        </select>
                                        @error('company')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    {{-- select for client department --}}
                                    <div class="form-group col-md-6 col-sm-12">
                                        <label for="department">{{ __('Select Department') }}</label>
                                        <select name="department" id="department" class="form-control">
                                            <option value="">{{ __('Select Department') }}</option>
                                        </select>
                                        @error('department')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    @if($type==5)
                                    <div class="form-group col-md-6 col-sm-12">
                                        <label for="raters">{{ __('Select Type of Raters') }}</label>
                                        <select name="raters" id="raters" class="form-control">
                                            <option value="">{{ __('Select Raters') }}</option>
                                            <option value="ALL">{{ __('ALL') }}</option>
                                            <option value="Self">{{ __('Selfs') }}</option>
                                            <option value="LM">{{ __('Line Managers') }}</option>
                                            <option value="Peer">{{ __('Peers') }}</option>
                                            <option value="DR">{{ __('Direct Reportings') }}</option>
                                        </select>
                                        @error('raters')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    @endif
                                </div>
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

                                    @if($emailContet!=null)
                                    @if($emailContet->use_client_logo && $client->logo_path!=null)
                                    <div class="form-group col-md-6 col-sm-12" id="CLImage">
                                        {{-- show logo image--}}
                                        <img src="{{ asset('uploads/companies/logos/'.$client->logo_path) }}" alt="logo"
                                            class="img-thumbnail" style="width: 100px;height:100px">
                                    </div>
                                    @endif
                                    @endif


                                    <div class="form-group col-md-7 col-sm-12">
                                        <label for="email_body">{{ __('E-mail Body') }}(EN)</label>
                                        <textarea name="email_body" id="email_body" class="form-control summernote"
                                            placeholder="{{ __('E-mail Body') }}"
                                            required>{{ old('email_body',$emailContet!=null?$emailContet->body_header:'') }}</textarea>
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
                                            placeholder="{{ __('E-mail Footer') }}"
                                            required>{{ old('email_footer',$emailContet!=null?$emailContet->body_footer:'') }}</textarea>
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
                <div class="col-12 mt-3">
                    <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('schedule Send Survey') }}</h3>
                            {{-- tool --}}
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                        class="fas fa-plus"></i>
                                </button>
                                {{-- back --}}
                                <a href="{{ route('clients.surveyDetails',[$id,$type,$survey->id])}}"
                                    class="btn btn-sm btn-tool {{ App()->getLocale()=='ar'? 'float-start':'float-end' }}">{{
                                    __('Back') }}</a>
                                {{-- create new survey --}}
                            </div>
                        </div>
                        <div class="card-body" style="display: none">
                            <form action="{{ route('client.schedule360') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    {{-- show all errors --}}
                                    @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif
                                </div>
                                <div class="row">
                                    {{-- select for client sectors --}}
                                    <div class="form-group col-md-6 col-sm-12">
                                        <label for="s_sector">{{ __('Select Sector') }}</label>
                                        <select name="s_sector" id="s_sector" class="form-control">
                                            <option value="">{{ __('Select Sector') }}</option>
                                            @foreach ($client->sectors as $sector)
                                            <option value="{{ $sector->id }}">
                                                {{ $sector->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('s_sector')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    {{-- select for client companies --}}
                                    <div class="form-group col-md-6 col-sm-12">
                                        <label for="s_company">{{ __('Select Company') }}</label>
                                        <select name="s_company" id="s_company" class="form-control">
                                            <option value="">{{ __('Select Company') }}</option>
                                        </select>
                                        @error('s_company')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    {{-- select for client department --}}
                                    <div class="form-group col-md-6 col-sm-12">
                                        <label for="s_department">{{ __('Select Department') }}</label>
                                        <select name="s_department" id="s_department" class="form-control">
                                            <option value="">{{ __('Select Department') }}</option>
                                        </select>
                                        @error('s_department')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6 col-sm-12">
                                        <label for="candidate">{{ __('Select Candidate') }}</label>
                                        <select name="candidate" id="candidate" class="form-control">
                                            <option value="">{{ __('Select Candidate') }}</option>
                                            @foreach ($candidates as $candidate)
                                            <option value="{{ $candidate->id }}">
                                                {{ $candidate->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('candidate')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    @if($type==5||$type==6)
                                    <div class="form-group col-md-6 col-sm-12">
                                        <label for="s_raters">{{ __('Select Type of Raters') }}</label>
                                        <select name="s_raters" id="s_raters" class="form-control">
                                            <option value="">{{ __('Select Raters') }}</option>
                                            <option value="ALL">{{ __('ALL') }}</option>
                                            <option value="Self">{{ __('Selfs') }}</option>
                                            <option value="LM">{{ __('Line Managers') }}</option>
                                            <option value="Peer">{{ __('Peers') }}</option>
                                            <option value="DR">{{ __('Direct Reportings') }}</option>
                                        </select>
                                        @error('s_raters')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    @endif
                                </div>
                                <div class="row">
                                    {{-- set date of schedule --}}
                                    <div class="form-group col-md-6 col-sm-12">
                                        <label for="schedule_date">{{ __('Schedule Date') }}</label>
                                        <input type="date" name="schedule_date" id="schedule_date" class="form-control"
                                            required value="{{ old('schedule_date') }}">
                                        @error('schedule_date')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    {{-- set time of schedule --}}
                                    <div class="form-group col-md-6 col-sm-12">
                                        <label for="schedule_time">{{ __('Schedule Time') }}</label>
                                        <input type="time" name="schedule_time" id="schedule_time" class="form-control"
                                            required value="{{ old('schedule_time') }}">
                                        @error('schedule_time')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6 col-sm-12">
                                        <label for="s_subject">{{ __('E-mail Title') }}(EN)</label>
                                        <input type="text" name="s_subject" id="s_subject" class="form-control"
                                            placeholder="{{ __('E-mail Title') }}" required
                                            value="{{ old('s_subject',$emailContet!=null?$emailContet->subject:'') }}">
                                        @error('s_subject')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6 col-sm-12">
                                        <label for="s_subject_ar">{{ __('E-mail Title') }}(AR)</label>
                                        <input type="text" name="s_subject_ar" id="s_subject_ar" class="form-control"
                                            placeholder="{{ __('E-mail Title') }}" required
                                            value="{{ old('s_subject_ar',$emailContet!=null?$emailContet->subject_ar:'') }}">
                                        @error('s_subject_ar')
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

                                    @if($emailContet!=null)
                                    @if($emailContet->use_client_logo && $client->logo_path!=null)
                                    <div class="form-group col-md-6 col-sm-12" id="CLImage">
                                        {{-- show logo image--}}
                                        <img src="{{ asset('uploads/companies/logos/'.$client->logo_path) }}" alt="logo"
                                            class="img-thumbnail" style="width: 100px;height:100px">
                                    </div>
                                    @endif
                                    @endif


                                    <div class="form-group col-md-7 col-sm-12">
                                        <label for="s_email_body">{{ __('E-mail Body') }}(EN)</label>
                                        <textarea name="s_email_body" id="s_email_body" class="form-control summernote"
                                            placeholder="{{ __('E-mail Body') }}"
                                            required>{{ old('s_email_body',$emailContet!=null?$emailContet->body_header:'') }}</textarea>
                                        @error('s_email_body')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-7 col-sm-12">
                                        <label for="s_email_body_ar">{{ __('E-mail Body') }}(AR)</label>
                                        <textarea name="s_email_body_ar" id="s_email_body_ar"
                                            class="form-control summernote" placeholder="{{ __('E-mail Body') }}"
                                            required>{{ old('s_email_body_ar',$emailContet!=null?$emailContet->body_header_ar:'') }}</textarea>
                                        @error('s_email_body_ar')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-7 col-sm-12">
                                        <label for="s_email_footer">{{ __('E-mail Footer') }}(EN)</label>
                                        <textarea name="s_email_footer" id="s_email_footer"
                                            class="form-control summernote" placeholder="{{ __('E-mail Footer') }}"
                                            required>{{ old('s_email_footer',$emailContet!=null?$emailContet->body_footer:'') }}</textarea>
                                        @error('s_email_footer')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-7 col-sm-12">
                                        <label for="s_email_footer_ar">{{ __('E-mail Footer') }}(AR)</label>
                                        <textarea name="s_email_footer_ar" id="s_email_footer_ar"
                                            class="form-control summernote" placeholder="{{ __('E-mail Footer') }}"
                                            required>{{ old('s_email_footer_ar',$emailContet!=null?$emailContet->body_footer_ar:'') }}</textarea>
                                        @error('s_email_footer_ar')
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
        $('#sector').on('change',function(){
                var sector_id=$(this).val();
                getCompanies(sector_id,'company');
            });
        $('#s_sector').on('change',function(){
                var sector_id=$(this).val();
                getCompanies(sector_id,'s_company');
                getCandidates(sector_id,'sectore');
            });
            //on company selected
            $('#company').on('change',function(){
                var company_id=$(this).val();
                getdepartments(company_id,'department');
            });
            $('#s_company').on('change',function(){
                var company_id=$(this).val();
                getdepartments(company_id,'s_department');
                getCandidates(company_id,'company');
            });
            $('#s_department').on('change',function(){
                var dep_id=$(this).val();
                getCandidates(dep_id,'dep');
            });
            getdepartments=(id,dep)=>{
                url="{{ route('client.departments',':d') }}";
                url=url.replace(':d',id);
                if(id){
                    $.ajax({
                        url:url,
                        type:"GET",
                        success:function(data){
                            $(`#${dep}`).empty();
                            $(`#${dep}`).append('<option value="">Select Department</option>');
                            $.each(data,function(index,department){
                                $(`#${dep}`).append('<option value="'+department.id+'">'+department.name+'</option>');
                            });
                        },
                        error:function(error){
                            console.log(error);
                        }
                    });
                }
            }
            getCompanies=(id,comp)=>{
                url="{{ route('client.companies',':d') }}";
                url=url.replace(':d',id);
                if(id){
                    $.ajax({
                        url:url,
                        type:"GET",
                        success:function(data){
                            $(`#${comp}`).empty();
                            $(`#${comp}`).append('<option value="">Select Company</option>');
                            $.each(data,function(index,company){
                                $(`#${comp}`).append('<option value="'+company.id+'">'+company.name+'</option>');
                            });
                        },
                        error:function(error){
                            console.log(error);
                        }
                    });
                }
            }
            getCandidates=(id,type)=>{
                url="{{ route('client.candidates',':d') }}";
                url=url.replace(':d',id);
                if(id){
                    $.ajax({
                        url:url,
                        type:"post",
                        data:{
                            _token:'{{ csrf_token() }}',
                            type:type,
                            id:id,
                            survey:"{{ $survey->id }}",
                            client:"{{ $client->id }}"
                        },
                        success:function(data){
                            $('#candidate').empty();
                            $('#candidate').append('<option value="">Select Candidate</option>');
                            $.each(data,function(index,candidate){
                                $('#candidate').append('<option value="'+candidate.id+'">'+candidate.name+'</option>');
                            });
                        },
                        error:function(error){
                            console.log(error);
                        }
                    });
                }
            }
</script>
@endsection
