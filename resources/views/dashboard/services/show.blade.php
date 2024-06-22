@extends('dashboard.layouts.main')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Services</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item active"><a href="{{ route('services.index') }}">{{ __('Service')
                                }}</a> </li>
                        <li class="breadcrumb-item active">{{ __('Create') }}</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div id="accordion">
                <div class="card card-lightblue">
                    <div class="card-header">
                        <h5 class="card-title">
                            <a class="d-block w-100" data-toggle="collapse" href="#collapseOne">
                                {{ __('General information about: ') }}{{ $service->name }}
                            </a>
                        </h5>
                    </div>
                    <div id="collapseOne" class="collapse" data-parent="#accordion" style="">
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-sm-12 text-center">
                                    <img src="{{ asset('uploads/services/images/' . $service->service_media_path) }}"
                                        class="img-fluid img-size-64" alt="service image">
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <p class="card-text">
                                    <h4>{{ $service->name }}</h4>
                                    </p>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <p class="card-text">
                                    <h4>{{ $service->name_ar }}</h4>
                                    </p>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <p class="card-text">
                                    <h6>Slug</h6>{{ $service->slug }}</p>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <p class="card-text">
                                    <h6>سلج</h6>{{ $service->slug_ar }}</p>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <p class="card-text">
                                    <h6>Description</h6>{!! $service->description !!}</p>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <p class="card-text">
                                    <h6>الوصف</h6>{!! $service->description_ar!!}</p>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <h6>Objectives</h6>
                                    <p class="card-text"> @if(strlen($service->objective) > 0){!!
                                        $service->objective!!}@else
                                        Not Setted @endif</p>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <h6>الأهداف</h6>
                                    <p class="card-text">@if(strlen($service->objective_ar) > 0){!!
                                        $service->objective_ar!!}
                                        @else لم يتم إدخاله @endif</p>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <h6>Service Type</h6>
                                    <p class="card-text">{{ $service->service_type }}</p>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <h6>{{ __('Country') }}</h6>
                                    <p class="card-text">{{ $service->country? $service->country->name: __("Not Setted")
                                        }}
                                    </p>
                                </div>
                                {{-- framwork media --}}
                                <div class="col-md-6 col-sm-12">
                                    <h6>{{ __('Framework Media') }}</h6>
                                    @if($service->FW_uploaded_video)
                                    <video width="320" height="240" controls>
                                        <source
                                            src="{{ asset('uploads/services/videos/' . $service->framework_media_path) }}"
                                            type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                    @else
                                    {{-- iframe for youtube --}}
                                    <iframe width="320" height="240" src="{{ $service->framework_media_path }}"
                                        frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen></iframe>
                                    @endif
                                </div>
                                {{-- framwork media arabic--}}
                                <div class="col-md-6 col-sm-12">
                                    <h6>{{ __('Framework Media Arabic') }}</h6>
                                    @if($service->FW_uploaded_video_ar)
                                    <video width="320" height="240" controls>
                                        <source
                                            src="{{ asset('uploads/services/videos/' . $service->framework_media_path_ar) }}"
                                            type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                    @else
                                    {{-- iframe for youtube --}}
                                    <iframe width="320" height="240" src="{{ $service->framework_media_path }}"
                                        frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen></iframe>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                {{-- card for service feature --}}
                <div class="card card-lightblue">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-9 col-sm-12 text-start">
                                <h5 class="float-start card-title">
                                    <a class="d-block w-100" data-toggle="collapse" href="#collapseTwo">
                                        {{ __('Service Features') }}
                                    </a>
                                </h5>
                            </div>
                            @can('create',new App\Models\ServiceFeatures)
                            <div class="col-md-3 col-sm-12 text-right">
                                <a href="javascript:void(0)" data-toggle="modal" data-target="#addEditFeature"
                                    class="btn bg-olive btn-sm float-right"><i class="fa fa-plus"></i></a>
                            </div>
                            @endcan
                        </div>
                    </div>
                    <div id="collapseTwo" class="collapse" data-parent="#accordion" style="">
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="list-group list-group-horizontal-md row">
                                    @foreach ($service->features as $feature)
                                    <div class="list-group-item col-lg-3 mt-1 mb-1 custom-hover">
                                        <h6>
                                            {{ $feature->feature }}
                                        </h6>
                                        <div class="row custom-btn-hover">
                                            @can('update',$feature)
                                            <div class="col-md-6 col-sm-12 text-center"><a href="javascript:void(0)"
                                                    class="btn btn-warning btn-sm"
                                                    onclick="showEdit('{{ $feature->id }}')"><i
                                                        class="fa fa-edit"></i></a>
                                            </div>
                                            @endcan
                                            @can('delete',$feature)
                                            <div class="col-md-6 col-sm-12 text-center"><a href="javascript:void(0)"
                                                    class="btn btn-danger btn-sm"
                                                    onclick="showEdit('{{ $feature->id }}')"><i
                                                        class="fa fa-trash"></i></a>
                                            </div>
                                            @endcan
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- card for service approaches --}}
                <div class="card card-lightblue">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-9 col-sm-12 text-start">
                                <h5 class="float-start card-title">
                                    <a class="d-block w-100" data-toggle="collapse" href="#collapseThree">
                                        {{ __('Service Approaches') }}
                                    </a>
                                </h5>
                            </div>
                            @can('create', new App\Models\ServiceApproaches)
                            <div class="col-md-3 col-sm-12 text-right">
                                <a href="javascript:void(0)" data-toggle="modal" data-target="#addEditApproach"
                                    class="btn bg-olive btn-sm float-right">
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
                            @endcan
                        </div>
                    </div>
                    <div id="collapseThree" class="collapse" data-parent="#accordion" style="">
                        <div class="card-body">
                            <div class="row justify-content-center">
                                @foreach ( $service->approaches as $approache)
                                <div class="col-md-3 col-sm-12">
                                    <div class="card">
                                        <div class="card-body custom-hover">
                                            <div class="row">
                                                {{-- image --}}
                                                <div class="col-12 text-center">
                                                    <img src="{{ asset('uploads/services/icons/' . $approache->icon) }}"
                                                        class="img-fluid img-size-64" alt="service image">
                                                </div>
                                            </div>
                                            <div class="row">
                                                {{-- approach --}}
                                                <div class="col-12 text-center">
                                                    <h6>{!! $approache->approach !!}</h6>
                                                </div>
                                            </div>
                                            <div class="row">
                                                {{-- approach arabic --}}
                                                <div class="col-12 text-center">
                                                    <h6>{!! $approache->approach_ar !!}</h6>
                                                </div>
                                            </div>
                                            <div class="row custom-btn-hover">
                                                @can('update',$approache)
                                                <div class="col-md-6 col-sm-12 text-center"><a href="javascript:void(0)"
                                                        class="btn btn-warning btn-sm mt-5"><i
                                                            class="fa fa-edit"></i></a>
                                                </div>
                                                @endcan
                                                @can('delete',$approache)
                                                <div class="col-md-6 col-sm-12 text-center"><a href="javascript:void(0)"
                                                        class="btn btn-danger btn-sm mt-5"><i
                                                            class="fa fa-trash"></i></a>
                                                </div>
                                                @endcan
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                {{-- card for service plans --}}
                <div class="card card-lightblue">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-9 col-sm-12 text-start">
                                <h5 class="float-start card-title">
                                    <a class="d-block w-100" data-toggle="collapse" href="#collapseFour">
                                        {{ __('Service Plans') }}
                                    </a>
                                </h5>
                            </div>
                            @can('create', new App\Models\Plans)
                            <div class="col-md-3 col-sm-12 text-right">
                                <a href="{{ route('service-plans.create', $service->id) }}"
                                    class="btn bg-olive btn-sm float-right">
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
                            @endcan
                        </div>
                    </div>
                    <div id="collapseFour" class="collapse" data-parent="#accordion" style="">
                        <div class="card-body">
                            <div class="row justify-content-center">
                                @foreach ($service->plans as $plan)
                                <div class="col-md-4 col-sm-12">
                                    <div class="card">
                                        <div class="card-body">

                                            <div class="row">
                                                {{-- plan --}}
                                                <div class="col-sm-12 text-center">
                                                    <h6>{{ App()->getLocale()=='en'? $plan->name: $plan->name_ar }}</h6>
                                                </div>
                                                <div class="col-sm-12 text-center">
                                                    <h6>{{ __('delivery mode') }}</h6> {!!
                                                    App()->getLocale()=='en'?$plan->delivery_mode:$plan->delivery_mode_ar
                                                    !!}
                                                </div>

                                            </div>
                                        </div>
                                        {{-- footer --}}
                                        <div class="card-footer">
                                            <div class="row">
                                                @can('view',$plan)
                                                <div class="col-md-4 col-sm-12 text-center">
                                                    <a href="javascript:void(0)" class="btn btn-sm btn-info"
                                                        onclick="showPlan('{{ $plan->id }}')">
                                                        {{ __('Show') }}
                                                    </a>
                                                </div>
                                                @endcan
                                                @can('update',$plan)
                                                <div class="col-md-4 col-sm-12 text-center">
                                                    <a href="{{ route('service-plans.edit', $plan->id) }}"
                                                        class="btn btn-sm btn-warning">
                                                        {{ __('Edit') }}
                                                    </a>
                                                </div>
                                                @endcan
                                                @can('delete',$plan)
                                                <div class="col-md-4 col-sm-12 text-center">
                                                    <form action="{{ route('service-plans.destroy', $plan->id) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            {{ __('Delete') }}
                                                        </button>
                                                    </form>
                                                </div>
                                                @endcan
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="row justify-content-center d-none">
                                <section class="content pb-3 pr-4 pl-4 w-100">
                                    <div class="container-fluid h-100">
                                        <div class="row">
                                            <div class="col-md-4 col-sm-6">
                                                <div class="card card-default">
                                                    <div class="card-header bg-info">
                                                        <h3 class="card-title">
                                                            {{ __('Plan info') }}
                                                        </h3>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="card card-info card-outline">
                                                            <div class="card-header">
                                                                <h5 class="card-title">{{ ('Plan info') }}</h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <p id="planInfo_P">
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="card card-success card-outline">
                                                            <div class="card-header">
                                                                <h5 class="card-title">{{ ('Plan Delivery Mode') }}</h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <p id="deliveryMode_P">
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="card card-danger card-outline">
                                                            <div class="card-header">
                                                                <h5 class="card-title">{{ ('Plan Limitations') }}</h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <p id="limitations_P">
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="card card-warning card-outline">
                                                            <div class="card-header">
                                                                <h5 class="card-title">{{ ('Plan Terms') }}</h5>
                                                                <div class="card-tools">
                                                                    <button type="button" class="btn btn-tool"
                                                                        data-target="#editTerms" data-toggle="modal"><i
                                                                            class="fas fa-plus"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div class="card-body">

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <div class="card card-success">
                                                    <div class="card-header">
                                                        <h3 class="card-title">
                                                            {{ __('Plan Features') }}
                                                        </h3>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="card card-primary card-outline">
                                                            <div class="card-header">
                                                                <h5 class="card-title">{{ __('Features') }}</h5>

                                                            </div>
                                                            <div class="card-body">
                                                                <p id="features_P">
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <div class="card card-primary">
                                                    <div class="card-header">
                                                        <h3 class="card-title">
                                                            {{ __('Plan Prices') }}
                                                        </h3>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="card card-primary card-outline">
                                                            <div class="card-header">
                                                                <h5 class="card-title">{{ __('Prices') }}</h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="table-responsive">
                                                                    <table
                                                                        class="table table-bordered table-hover text-xs">
                                                                        <thead>
                                                                            <tr>
                                                                                <td colspan="5">add</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>#</th>
                                                                                <th>{{ __('Country') }}</th>
                                                                                <th>{{ __('Monthly Price') }}</th>
                                                                                <th>{{ __('Annual Price') }}</th>
                                                                                <th>{{ __('Edit') }}</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody id="PriceTable">
                                                                            <tr>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
{{-- modal to add_edit feature --}}
@include('dashboard.services.modals.editFeature')
{{-- modal to add_edit approach --}}
@include('dashboard.services.modals.editApproach')
{{-- show terms and Conditions Modal --}}
@include('dashboard.services.modals.showTermsAndCondtions')
{{-- Edit terms and condtions modal --}}
@include('dashboard.services.modals.editTermsAndCondtions')
@include('dashboard.services.modals.editPlanPrice')
@endsection
@section('scripts')
<script>
    $('.summernote').summernote();
    //on status change
    $('#status').change(function () {
        if ($(this).is(':checked')) {
            $(this).next().text('Active');
        } else {
            $(this).next().text('In-Active');
        }
    });
    // on FeatureSave click
    $('#FeatureSave').click(function () {
        var feature = $('#feature').val();
        var feature_ar = $('#feature_ar').val();
        var status = $('#status').is(':checked') ? 1 : 0;
        var Sid = $('#Sid').val();
        var Fid = $('#Fid').val();
        var url = '';
        if (Fid) {
            url = "{{ route('service-features.update', ':id') }}";
            url = url.replace(':id', Fid);
        } else {
            url = "{{ route('service-features.store') }}";
        }
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                feature: feature,
                feature_ar: feature_ar,
                status: status,
                service: Sid,
                _token: "{{ csrf_token() }}",
                _method: Fid ? 'PUT' : 'POST'
            },
            success: function (data) {
                if (data.status) {
                    alert(data.message);
                    location.reload();
                } else {
                    alert(data.message);
                }
            }
        });
    });
    //on ApproachSave click
    $('#ApproachSave').click(function () {
        var approach = $('textarea[name="approach"]').val();
        var approach_ar = $('textarea[name="approach_ar"]').val();
        var icon = $('input[name="icon"]').prop('files')[0];
        var Sid = $('input[name="Sid"]').val();
        var Aid = $('input[name="Aid"]').val();
        var url = '';
        if (Aid) {
            url = "{{ route('service-approaches.update', ':id') }}";
            url = url.replace(':id', Aid);
        } else {
            url = "{{ route('service-approaches.store') }}";
        }
        var form_data = new FormData();
        form_data.append('approach', approach);
        form_data.append('approach_ar', approach_ar);
        form_data.append('icon', icon);
        form_data.append('service', Sid);
        form_data.append('_token', "{{ csrf_token() }}");
        form_data.append('_method', Aid ? 'PUT' : 'POST');
        $.ajax({
            url: url,
            type: 'POST',
            data: form_data,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data.status) {
                    alert(data.message);
                    location.reload();
                } else {
                    alert(data.message);
                }
            }
        });
    });
//on double click
function showEdit(id) {
    var url = "{{ route('service-features.edit', ':id') }}";
    url = url.replace(':id', id);
    $.ajax({
        url: url,
        type: 'GET',
        success: function (data) {
            $('#Fid').val(data.id);
            $('#feature').val(data.feature);
            $('#feature_ar').val(data.feature_ar);

            if(data.is_active == 1){
                $('#status').prop('checked', true);
                $('#status').next().text('Active');
            }else{
                //remove checked
                $('#status').removeAttr('checked');
                $('#status').next().text('In-Active');
            }
            $('#addEditFeature').modal('show');
        }
    });
}
//showPlan
function showPlan(id) {
    features="{{ $service->features }}";
    isEnglish = "{{ App()->getLocale() == 'en' }}";
    // convert features to array of objects
    features = JSON.parse(features.replace(/&quot;/g, '"'));
    var url = "{{ route('service-plans.show', ':id') }}";
    url = url.replace(':id', id);
    $.ajax({
        url: url,
        type: 'GET',
        success: function (data) {
            // clear table
            $('#PriceTable').html('');
            let loopIndex=1;
            data.prices.forEach(price=> {
                $('#PriceTable').append(`
                    <tr>
                        <td>${loopIndex++}</td>
                        <td>${price.Country_name}</td>
                        <td>${price.monthly_price} ${price.currency_sy}</td>
                        <td>${price.annual_price} ${price.currency_sy}</td>
                        <td><a href="javascript:void(0)" id="EditPlanPricebtn-${price.id}" class="btn btn-warning btn-xs" data-target="#editPlanPrice" data-toggle="modal"><i class="fa fa-edit"></i></a></td>
                    </tr>
                `);
                //find "EditPlanPricebtn-${price.id}"
                button=document.getElementById(`EditPlanPricebtn-${price.id}`)
                button.addEventListener('click',function(){
                    ShowEditPP(price)
                });
            });
            //clear features_P
            $('#features_P').html('');
            //show plan features
            features.forEach((feature, index) => {
                //if feature is in plan features
                if (data.features_id.includes(feature.id)) {
                $('#features_P').append(isEnglish ? `<p><i class="fa fa-check text-success pr-2"></i>${feature.feature}</p>` : `<p><i class="fa fa-check text-success pl-2"></i>${feature.feature_ar}</p>`);
                }
                else{
                    $('#features_P').append(isEnglish ? `<p><i class="fa fa-times text-danger pr-2"></i>${feature.feature}</p>` : `<p><i class="fa fa-times text-danger pl-2"></i>${feature.feature_ar}</p>`);
                }
            });
            $('#planInfo_P').html(data.plan.name);
            $('#deliveryMode_P').html(data.plan.delivery_mode);
            $('#limitations_P').html(data.plan.limitations);
            // $('#features_P').html(data.plan.features);
            if(data.plan.termsConditions){
                $("#showTermsLabel").text(isEnglish?data.plan.termsConditions.english_title:data.plan.termsConditions.arabic_title);
                $("TermsP").html(isEnglish?data.plan.termsConditions.english_terms:data.plan.termsConditions.arabic_terms);
                //setup the terms and conditions form
                $('#Pid').val(data.plan.id);
                $('#terms_title').val(data.plan.termsConditions.english_title);
                $('#terms_title_ar').val(data.plan.termsConditions.arabic_title);
                $('#terms').html(data.plan.termsConditions.english_terms);
                $('#terms_ar').html(data.plan.termsConditions.arabic_terms);
            }
            $('.d-none').removeClass('d-none');
            isPartner="{{ Auth()->user()->user_type == 'partner' }}"
            if(data.countries.length>0)
            {
                //ppvalid_in
           //set up Terms_Countries
           $('#ppvalid_in').html('');
                $('#ppvalid_in').append(`<option value="">Select</option>`);
                if(isPartner)
                {
                    data.countries.forEach((country, index) => {
                    $('#ppvalid_in').append(`<option value="${country.id}">${country.country_name}</option>`);
                });
            }
            else{
                $('#ppvalid_in').html('');
                $('#ppvalid_in').append(`<option value="">Select</option>`);
                //add option group
                $('#ppvalid_in').append(`<optgroup label="{{ __('Arab Countries') }}">`);
                data.countries[1].forEach((country, index) => {
                    $('#ppvalid_in').append(`<option value="${country.id}">${country.country_name}</option>`);
                });
                $('#ppvalid_in').append(`</optgroup>`);
                // //add option group
                $('#ppvalid_in').append(`<optgroup label="{{ __('Other') }}">`);
                data.countries[0].forEach((country, index) => {
                    $('#ppvalid_in').append(`<option value="${country.id}">${country.country_name}</option>`);
                });
                $('#ppvalid_in').append(`</optgroup>`);
            }
            $("#eplan_id").val(id);
            }
            else{
                console.log('there is no data');
            }
            if(data.countries.length>0)
            {
                //set up Terms_Countries
                $('#Terms_Countries').html('');
                $('#Terms_Countries').append(`<option value="">Select</option>`);
                if(isPartner)
                {
                    data.countries.forEach((country, index) => {
                    $('#Terms_Countries').append(`<option value="${country.id}">${country.country_name}</option>`);
                });
            }
            else{
                $('#Terms_Countries').html('');
                $('#Terms_Countries').append(`<option value="">Select</option>`);
                //add option group
                $('#Terms_Countries').append(`<optgroup label="{{ __('Arab Countries') }}">`);
                data.countries[1].forEach((country, index) => {
                    $('#Terms_Countries').append(`<option value="${country.id}">${country.country_name}</option>`);
                });
                $('#Terms_Countries').append(`</optgroup>`);
                // //add option group
                $('#Terms_Countries').append(`<optgroup label="{{ __('Other') }}">`);
                data.countries[0].forEach((country, index) => {
                    $('#Terms_Countries').append(`<option value="${country.id}">${country.country_name}</option>`);
                });
                $('#Terms_Countries').append(`</optgroup>`);
            }
            $("#eplan_id").val(id);
            }
            else{
                console.log('there is no data');
            }

        }
    });
}
//ShowEdit function
function ShowEditPP(price){
    console.log(price);
// to edit plan price
$('#eplan_id').val(price.plan_id);
$('#plan_price_id').val(price.id);
$('#ppvalid_in').val(price.country.id).trigger("change");
//set selection of ppvalid in

$('#monthly_price').val(price.monthly_price);
$('#annual_price').val(price.annual_price);
$('#currency').val(price.currency).trigger("change");
PMs=price.payment_methods
//set payment methods
PMs.forEach(item=>{
    $(`#PM-${item}`).prop('checked',true);
});
}
</script>
@endsection
