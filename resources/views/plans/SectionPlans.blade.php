@extends('layouts.main')
@section('content')
<div class="container">
    <div class="col-12">
        <fieldset class="form-group border p-3 col-lg-4 col-md-6 col-sm-12">
            <legend class="w-auto px-2">{{ __('Our Legal Partner') }}</legend>
            <div class="form-group">
                <a href="https://drsaifalrawahi.com/">
                    <img src="{{ asset('assets/img/DSA.png') }}" class="img-responsive" />
                </a>
            </div>
        </fieldset>
    </div>
    <div class="col-11">
        <fieldset>
            <legend>{{ __('How To use this builder') }}</legend>
            <div class="row p-2 justify-content-center">
                <iframe width="980" height="350" src="{{ $vedi_src }}">
                </iframe>
            </div>
        </fieldset>
    </div>
    <div class="row pt-5 mt-4" dir="@dir">
        <div class="col-lg-3 btn-acc">
            <div class="releasesWrp" id="releases">
                <ul class="releases">
                    <li>
                        {{-- @if (Model.DefaultMB.Count != 0)
                        {

                        for (int i = 0; i < Model.DefaultMB.Count(); i++) { if (Model.DefaultMB[i].ParenId==null) {<!--
                            Release Item --> --}}

                            @foreach ($defaultMB_parents as $defaultMB_parent)


                            <ul class="releaseRow row " data-SectionId="{{ $defaultMB_parent->id }}">

                                <div class="list_icon">
                                    <li class="col-lg-1 col-1 rcol tc sort" @hidden><i class="fas fa-arrows-alt"
                                            aria-hidden="true"></i></li>
                                    <li class="col-lg-8 col-8 rcol tc showTracks" id="li-{{ $defaultMB_parent->id }}">
                                        <span>
                                            {{ $defaultMB_parent->title }}
                                        </span>
                                        {{-- @if (Model.DefaultMB[i].Childs.Count() != 0)
                                        { --}}
                                        <span id="plus-icon-{{ $defaultMB_parent->id }}"
                                            class="@sectionItemClass fa fa-plus"></span>
                                        {{-- } --}}

                                    </li>
                                    <li class="col-lg-3 col-3 rcol actions_icon">
                                        <a href="javascript:void(0);" class="editSection"
                                            data-SectionId="{{ $defaultMB_parent->id }}"><i class="far fa-edit"></i></a>
                                        <a href="javascript:void(0)"
                                            onclick="return deleteSection({{ $defaultMB_parent->id }});"><i
                                                class="far fa-trash-alt"></i></a>
                                        <a href="#">
                                            <label class="switch">
                                                {{-- @if (Model.DefaultMB[i].IsActive)
                                                { --}}
                                                <input class="chkActivate" value="1" checked
                                                    data-SectionId="{{ $defaultMB_parent->Id }}" type="checkbox">
                                                {{-- }
                                                else
                                                { --}}
                                                {{-- <input class="chkActivate"
                                                    data-SectionId="{{ $defaultMB_parent->Id }}" type="checkbox"> --}}
                                                {{-- } --}}
                                                <span class="slider round"></span>
                                            </label>
                                        </a>
                                    </li>
                                </div>
                                <li class="releaseTracks">
                                    {{-- @{ int x = 0;}foreach Item in Model.DefaultMB.Where(a => a.ParenId ==
                                    Model.DefaultMB[i].Id).OrderBy(a => a.Ordering))
                                    { --}}
                                    @foreach ($defaultMB_parent->children as $defaultMB_childe)
                                    <ul class="trackRow" data-SectionId="{{ $defaultMB_childe->id }}">

                                        <li class="col-lg-1 col-1 rcol tc sort" @hidden><i class="fas fa-arrows-alt"
                                                aria-hidden="true"></i></li>
                                        <li class="col-lg-6 col-6 rcol">{{ $defaultMB_childe->title }}</li>
                                        <li class="col-lg-4 col-4 fa-pull-right rcol tc">
                                            {{-- @{ string showActions = "";
                                            string disabled = "";}
                                            @if (x > 2)
                                            {
                                            showActions = "d-none";
                                            }
                                            @if (x > 2)
                                            { --}}
                                            @if($loop->iteration >3)
                                            <a href="" onclick="" data-bs-toggle="modal"
                                                data-bs-target="#toUnlockPlan"><i
                                                    class="fa fa-lock red text-danger"></i></a>
                                            @endif
                                            {{-- } --}}
                                            {{-- else
                                            { --}}
                                            <a href="javascript:void(0);"
                                                class="editSection @if($loop->iteration >3) disabled @endif"
                                                data-SectionId="{{ $defaultMB_childe->id }}" @if($loop->iteration >3)
                                                disabled @endif><i class="far fa-edit @showActions"></i></a>
                                            <a href="javascript:void(0)"
                                                class="@if($loop->iteration >3) disabled @endif" @if($loop->iteration
                                                >3) disabled @else onclick="return deleteSection({{
                                                $defaultMB_childe->id }});" @endif><i
                                                    class="far fa-trash-alt red @showActions"></i></a>
                                            {{-- } --}}
                                            <a href="#">
                                                <label class="switch">
                                                    {{-- @if (x <= 2) { --}} <input @if($loop->iteration >3) disabled
                                                        @else checked @endif class="chkActivate"
                                                        data-SectionId="{{ $defaultMB_childe->id }}"
                                                        type="checkbox">
                                                        {{-- }

                                                        {
                                                        if (x > 2)
                                                        { disabled = "disabled"; } --}}
                                                        {{-- @else
                                                        <input class="chkActivate"
                                                            data-SectionId="{{ $defaultMB_childe->id }}" type="checkbox"
                                                            @if($loop->iteration >3) 'disabled' @endif>{{-- } --}}
                                                        {{--@endif --}}
                                                        <span class="slider round"></span>
                                                </label>
                                            </a>
                                        </li>
                                    </ul>
                                    @endforeach
                                    {{-- x++;
                                    } --}}

                                </li>
                            </ul>{{-- } --}}
                            {{-- }
                            } --}}
                            @endforeach


                    </li>
                </ul>
            </div>
            <hr>
            <a class="btn btn-primary" id="AddNewSection" href="#)" role="button">@Resources.General.NewSection</a>
            <a class="btn btn-primary" id="DownloadPolicy" href="#" role="button">@Resources.General.Download</a>
            <a class="btn btn-warning" id="SharePolicy" href="#" role="button">@Resources.General.SharePolicy</a>
            <hr>
            <a class="btn btn-primary" href="@Url.Action(" Index", "Builder" )"
                role="button">@Resources.General.Back</a>
            <hr>
        </div>

        <div class="col-lg-9" id="divEditSection" dir="@dir" style="@EditDisplayClass">

        </div>
        <div class="clearfix"></div>
        <div class="col-md-8 ml-auto wow fadeInUp">
            <img src="{{ __('assets/img/BuilderFooter.png') }}" alt="">
        </div>
    </div>
</div>
<hr />
{{-- closed --}}
</div>
<div class="container">
    <div class="row mb-3 @dir">
        <div class="col-md-12 col-lg-4 mt-2 animated @slideInRight">
            <div class="card pricing-box rounded">
                <div class="card-block text-center">
                    <h4 class="card-title">

                        {{ __('Standard') }}
                    </h4>
                    <h6 class="card-text">
                        <sup class="currency">
                            OMR
                        </sup>
                        <span class="amount">
                            55
                        </span>
                        <span class="month">
                            / mo
                        </span>
                    </h6>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item text-center d-inline-block">
                        <span class="@alignfloat @accordion_header_text"><b>
                                {{ __('For Whom') }}
                            </b></span>
                        <span class="@invalignfloat @accordion_header_text">

                            {{ __('A client who wants only to access a compliant HR manual builder/ prepopulated A
                            client who wants only to access a complaint HR manual builder/ pre-populated policies') }}
                        </span>
                    </li>
                    <li class="list-group-item text-center d-inline-block">
                        <span class="@alignfloat @accordion_header_text"><b>
                                {{ __('Process') }}
                            </b></span>

                        <ul class="list-unstyled @invalignfloat @accordion_header_text">
                            <li>

                                {{ __('Access to the HR manual builder.') }}
                            </li>
                            <li>
                                {{ __('Edit the manual according to your requirements.') }}
                            </li>
                        </ul>

                    </li>
                    <li class="list-group-item text-center d-inline-block">
                        <span class="@alignfloat @accordion_header_text"><b>
                                {{ __('Payment Mode') }}
                            </b></span>
                        <span class="@invalignfloat @accordion_header_text">

                            {{ __('online Pay') }}
                        </span>
                    </li>

                </ul>
                <div class="card-block text-center">

                    <button type="button" class="btn btn-warning btn-outline-start m-1" data-bs-toggle="modal"
                        data-bs-target="#basicPlanSub">

                        {{ __('Get Started') }}
                    </button>
                </div>
            </div>
        </div>

        <div class="col-md-12 col-lg-4 mt-2 ">
            <div class="card pricing-box pricing-premium">
                <div class="card-block text-center">
                    <h4 class="card-title">

                        {{ __('Customized HR Policy Manual') }}
                    </h4>
                    <h6 class="card-text">

                        <span class="month">

                            {{ __('Based on an agreed scope of work.') }}
                        </span>
                    </h6>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item text-center d-inline-block">
                        <span class="@alignfloat @accordion_header_text"><b>
                                {{ __('For Whom') }}
                            </b></span>
                        <span class="@invalignfloat @accordion_header_text">

                            {{ __('A client who wants customization of the HR policy manual/ a fit for purpose from an
                            HR standpoint.') }}
                        </span>
                    </li>
                    <li class="list-group-item text-center d-inline-block">
                        <span class="@alignfloat @accordion_header_text"><b>
                                {{ __('Process') }}
                            </b></span>

                        <ul class="list-unstyled @invalignfloat @accordion_header_text">
                            <li>

                                {{ __('HR consultant(s) works with you to facilitate the development of a customized HR
                                policy manual.') }}
                            </li>
                        </ul>

                    </li>
                    <li class="list-group-item text-center d-inline-block">
                        <span class="@alignfloat @accordion_header_text"><b>
                                {{ __('Payment Mode') }}
                            </b></span>
                        <span class="@invalignfloat @accordion_header_text">
                            Offline
                        </span>
                    </li>

                </ul>
                <div class="card-block text-center">
                    <a href="javascript:void(0);" class="btn btn-warning btn-outline-start m-1" title="Get Started"
                        data-bs-toggle="modal" data-bs-target="#RequestService" onclick="SetupServiceid('1')">

                        {{ __('Get Started') }}
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-4 mt-2 animated @slideInLeft">
            <div class="card pricing-box">
                <div class="card-block text-center">
                    <h4 class="card-title">

                        {{ __('Only Legal Review') }}
                    </h4>
                    <h6 class="card-text">

                        <span class="month">

                            {{ __('Based on an agreed scope of work.') }}
                        </span>
                    </h6>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item text-center d-inline-block">
                        <span class="@alignfloat @accordion_header_text"><b>
                                {{ __('For Whom') }}
                            </b></span>
                        <span class="@invalignfloat @accordion_header_text">

                            {{ __('A client who wants only to access a complaint HR manual builder/ pre-populated
                            policies and then get a legal review and the Ministry of Labour stamp.') }}
                        </span>
                    </li>
                    <li class="list-group-item text-center d-inline-block">
                        <span class="@alignfloat @accordion_header_text"><b>
                                {{ __('Process') }}
                            </b></span>

                        <ul class="list-unstyled @invalignfloat @accordion_header_text">
                            <li>

                                {{ __('Contact the legal firm directly.') }}
                            </li>

                        </ul>

                    </li>
                    <li class="list-group-item text-center d-inline-block">
                        <span class="@alignfloat @accordion_header_text"><b>
                                {{ __('Payment Mode') }}
                            </b></span>
                        <span class="@invalignfloat @accordion_header_text">
                            offline
                        </span>
                    </li>

                </ul>
                <div class="card-block text-center">
                    <a href="javascript:void(0);" class="btn btn-warning btn-outline-start m-1" title="Get Started"
                        data-bs-toggle="modal" data-bs-target="#RequestService" onclick="SetupServiceid('2')">

                        {{ __('Get Started') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="basicPlanSub" tabindex="-1" aria-labelledby="basicPlanSubLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="basicPlanSubLabel">Subscribe</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <section>
                    <div id="builder_s" class="section">
                        <div class="sectionInner">
                            <div class="container">
                                <div class="row @showbtn" id="btnShowUpGrade">
                                    <div class="col-lg-12 col-md-12 sm-mb-30px wow fadeInUp">
                                        <div class="blog-item thum-hover hvr-float hvr-sh2">
                                            <button id="btnUpgrade"
                                                class="btn background-main-color text-white">@Resources.General.Upgrade</button>
                                        </div>
                                    </div>
                                </div>
                                <div id="divCost" class="row">
                                    <div class="col-lg-6 col-md-6 sm-mb-30px">
                                        <div class="blog-item thum-hover bg-gray hvr-float hvr-sh2 ">
                                            <div class="position-relative background-beig">
                                                <div class="item-thumbnail" style="font-size: 5rem;">
                                                    {{ $MonthlyPriceDisp }}
                                                    <span
                                                        style="font-size: 2.5rem; margin-top: -38px; text-align: center;">
                                                        USD $
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="blog-item padding-lr-30px padding-top-60px text-center">
                                                <h1 class="padding-bottom-20px">{{ __('Per Month') }}</h1>
                                                <div class="form-group ">
                                                    <div class="form-check padding-bottom-20px">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input" required type="checkbox"
                                                                id="ManualMonthlyCheckbox"
                                                                onchange="agree('ManualMonthlyCheckbox','MonthlyManualBuilderdiv')">
                                                            {{ __('I Agree With ') }}
                                                            <a href="#" data-bs-toggle="modal"
                                                                data-bs-target="#agreeMonthModal">
                                                                {{ __('Terms & Conditions')}}
                                                            </a>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div id="MonthlyManualBuilderdiv" style="display:none;">
                                                    <div class="row justify-content-center pb-4 text-start" dir="@dir">
                                                        <div class="col-md-6 @pullAlign">
                                                            <label for="MonthlySearchCouponCodeManualBuilder"
                                                                class="form-label">
                                                                {{ __('Coupon Code') }}
                                                            </label>
                                                            <input type="text" class="form-control"
                                                                id="MonthlySearchCouponCodeManualBuilder"
                                                                aria-describedby="MonthlySearchCouponCodeManualBuilderMSG"
                                                                onchange="getCouponDiscount('MonthlySearchCouponCodeManualBuilder','MonthlyManualBuilderSubLink','3','{{ $MonthlyPriceDisp }}')"
                                                                required>
                                                            <div id="MonthlySearchCouponCodeManualBuilderMSG"
                                                                class="invalid-feedback d-none">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="MonthlyManualBuilderDiscountDiv"
                                                        class="row @pullAlign padding-bottom-22px col-md-12 d-none @textAlign"
                                                        dir="@dir">
                                                        <div class="row">
                                                            <label class="col-9">{{ __('Plan Price Before Dicount')
                                                                }}</label>
                                                            <label id="MonthlyManualBuilderPlanPriceCD"
                                                                class="font-weight-500 col-3">55 </label>
                                                        </div>
                                                        <div class="row">
                                                            <label class="col-9">{{ __('Coupon Discount Rate')
                                                                }}</label>
                                                            <label id="MonthlyManualBuilderCouponDiscRateCD"
                                                                class="font-weight-500 col-3">
                                                                55
                                                            </label>
                                                        </div>
                                                        <div class="row">
                                                            <label class="col-9">{{ __('Plan Price After Discount')
                                                                }}</label>
                                                            <label id="MonthlyManualBuilderPlanPriceAftDisCD"
                                                                class="font-weight-500 col-3">55 </label>

                                                        </div>
                                                        <div class="row">
                                                            <label class="col-9">{{ __('Plan Price Save') }}</label>
                                                            <label id="MonthlyManualBuilderPlanPriceSaveCD"
                                                                class="font-weight-500 col-3">
                                                                <del> 55</del>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="padding-bottom-22px">

                                                        <a id="MonthlyManualBuilderSubLink"
                                                            href="{{ route('Plans.checkout',[$plan,$month,$MonthlyPriceDisp]) }}"
                                                            class="btn btn-sm background-main-color text-white padding-lr-15px border-0 opacity-8">
                                                            Subscribe
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 sm-mb-30px">
                                        <div class="blog-item thum-hover bg-gray hvr-float hvr-sh2 ">
                                            <div class="position-relative background-beig">
                                                <div class="item-thumbnail" style="font-size: 5rem;">
                                                    {{ $AnnualPriceDisp }} <span
                                                        style="font-size: 2.5rem; margin-top: -38px; text-align: center;">USD
                                                        $</span>
                                                </div>
                                            </div>
                                            <div class="blog-item padding-lr-30px padding-top-60px text-center">
                                                <h1 class="padding-bottom-20px">{{ __('Per Year') }}</h1>
                                                <div class="form-group ">
                                                    <div class="form-check padding-bottom-20px">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input" type="checkbox"
                                                                id="ManualAnnualCheckbox"
                                                                onchange="agree('ManualAnnualCheckbox','AnnualManualBuilderdiv')">
                                                            {{ __('I Agree With ') }}
                                                            <a href="#" data-bs-toggle="modal"
                                                                data-bs-target="#agreeYearModal">
                                                                {{ __('Terms & Conditions')}}
                                                            </a>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div id="AnnualManualBuilderdiv" style="display:none;">
                                                    <div class="row justify-content-center pb-4 text-start" dir="@dir">
                                                        <div class="col-md-6">
                                                            <label for="AnnualSearchCouponCodeManualBuilder"
                                                                class="form-label">
                                                                {{ __('Coupon Code') }}
                                                            </label>
                                                            <input type="text" class="form-control"
                                                                id="AnnualSearchCouponCodeManualBuilder" aria-
                                                                describedby="AnnualSearchCouponCodeManualBuilderMSG"
                                                                onchange="getCouponDiscount                                             ('AnnualSearchCouponCodeManualBuilder','AnnualManualBuilderSubLink','3','{{ $AnnualPriceDisp }}')"
                                                                required>
                                                            <div id="AnnualSearchCouponCodeManualBuilderMSG"
                                                                class="invalid-feedback d-                                 none">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="AnnualManualBuilderDiscountDiv"
                                                        class="row @pullAlign padding-bottom-22px                          col-md-12 d-none @textAlign"
                                                        dir="@dir">
                                                        <div class="row">
                                                            <label class="col-9">{{ __('Plan Price Before Dicount')
                                                                }}</label>
                                                            <label id="AnnualManualBuilderPlanPriceCD"
                                                                class="font-weight-500 col-3">55</label>

                                                        </div>
                                                        <div class="row">
                                                            <label class="col-9">{{ __('Coupon Discount Rate')
                                                                }}</label>
                                                            <label id="AnnualManualBuilderCouponDiscRateCD"
                                                                class="font-weight-500 col-3">
                                                                55
                                                            </label>
                                                        </div>
                                                        <div class="row">
                                                            <label class="col-9">{{ __('Plan Price After Discount')
                                                                }}</label>
                                                            <label id="AnnualManualBuilderPlanPriceAftDisCD"
                                                                class="font-weight-500 col-3">
                                                                55
                                                            </label>

                                                        </div>
                                                        <div class="row">
                                                            <label class="col-9">{{ __('Plan Price Save') }}</label>
                                                            <label id="AnnualManualBuilderPlanPriceSaveCD"
                                                                class="font-weight-500 col-3">
                                                                <del> 55</del>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="padding-bottom-22px">

                                                        <a id="AnnualManualBuilderSubLink"
                                                            href="{{ route('Plans.checkout',[$plan,$year,$AnnualPriceDisp]) }}"
                                                            class="btn btn-sm background-main-color text-white padding-lr-15px border-0 opacity-8">
                                                            {{ __('Subscribe') }}
                                                        </a>
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
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="agreeMonthModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="exampleModalLabel2" class="modal-title" data-contentId="">{!!
                    App()->getLocale()=='ar'?$m_terms['arabic_title']:$m_terms['english_title'] !!}</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" data-contentId="">{!!
                App()->getLocale()=='ar'?$m_terms['arabic_text']:$m_terms['english_text'] !!}</div>
        </div>
    </div>
</div>

<div class="modal fade" id="agreeYearModal" tabindex="-1" role="dialog" aria-labelledby="agreeYearModalLabel1"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="agreeYearModalLabel1" class="modal-title" data-contentId="">{!!
                    App()->getLocale()=='ar'?$a_terms['arabic_title']:$a_terms['english_title'] !!}</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" data-contentId="">{!!
                App()->getLocale()=='ar'?$a_terms['arabic_text']:$a_terms['english_text'] !!}</div>
        </div>
    </div>
</div>

<div class="modal fade" id="RequestService" tabindex="-1" aria-labelledby="RequestServiceLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="RequestServiceLabel">Request Service</h1>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="requesrServiceForm" enctype="multipart/form-data">
                    <div class="row">
                        <input type="hidden" value="@userId" name="userID" id="userID" />
                        <input type="hidden" value="" name="serviceID" id="serviceID" />
                        <div class="col-lg-6 col-md-11 form-group">
                            <label class="form-label">
                                @Resources.General.Company @Resources.General.InEnglish
                            </label>
                            <input type="text" class="form-control" value="@name" name="company_name" id="company_name"
                                required />
                        </div>
                        <div class="col-lg-6 col-md-11 form-group">
                            <label class="form-label">
                                @Resources.General.ContactPerson
                            </label>
                            <input type="text" class="form-control" value="@contcatpserson" name="contact_name"
                                id="contact_name" required />
                        </div>
                        <div class="col-lg-6 col-md-11 form-group">
                            <label class="form-label">
                                @Resources.General.ContactInformation
                            </label>
                            <input type="text" class="form-control" value="@contactPersonPhone" name="contact_phone"
                                id="contact_phone" required />
                        </div>
                        <div class="col-lg-6 col-md-11 form-group">
                            <label class="form-label">
                                @Resources.General.Email
                            </label>
                            <input type="text" class="form-control" value="" name="contact_email" id="contact_email"
                                required />

                        </div>
                        <div class="col-lg-6 col-md-11 form-group">
                            <label class="form-label">
                                @Resources.General.Industry
                            </label>
                            <select class="form-control" name="industry" id="industry" required>
                                <option value=""> @Resources.General.Select</option>
                                @foreach ($industries as $indust)

                                <option value="{{ $indust->id }}" {{-- @if (userId !=0 && indust.Id==industry) { <text>
                                    selected</text> } --}}>
                                    {{ App()->getLocale()=='ar'? $indust->NameAr :$indust->Name }}

                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-6 col-md-11 form-group">
                            <label class="form-label">
                                @Resources.General.Country
                            </label>
                            <select class="form-control" name="Country" id="Country" required>
                                <option value=""> {{ __('Select') }}</option>
                                <optgroup label="{{ __('Arab countries') }}" @foreach ($countries[1] as $country1)
                                    <option value="{{ $country1->id }}" {{-- @if (userId !=0 && country1.Id==country) {
                                    <text>
                                    selected</text> } --}}>
                                    {{ App()->getLocale()=='ar'? $country1->NameAr:$country1->Name }}

                                    </option>
                                    @endforeach
                                </optgroup>
                                <optgroup label="{{ __('Other countries') }}">
                                    @foreach ($countries[0] as $country0)

                                    <option value="{{ $country0->id }}" {{-- @if (userId !=0 && country0.Id==country) {
                                        <text>
                                        selected</text> } --}}>
                                        {{ App()->getLocale()=='ar'? $country0->NameAr:$country0->Name }}

                                    </option>
                                    @endforeach
                                </optgroup>
                            </select>
                        </div>
                        <div class="col-lg-6 col-md-11 form-group">
                            <label class="form-label">
                                @Resources.General.Country
                            </label>
                            <select id="employees" name="employees" required class="form-control">
                                {{-- for each key and value --}}

                                @foreach ($List as $key => $value)

                                <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach

                            </select>
                        </div>
                        <div class="col-lg-6 col-md-11 form-group">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="isFileExist">
                                <input type="hidden" id="isFileExistVal" name="isFileExistVal" value="0" />
                                <label class="form-check-label"
                                    for="flexSwitchCheckDefault">@Resources.General.IsthereExistingHRPolicy</label>
                            </div>
                        </div>
                        <div class="col-sm-11 form-group" style="display:none" id="FileUpload">
                            <label class="form-label">
                                @Resources.General.Upload
                            </label>
                            <input type="file" class="form-control" value="" name="HRPolice" id="HRPolice" />
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">@Resources.General.Cancel</button>
                <button type="button" class="btn btn-primary" id="SubmitServiceReq">@Resources.General.Submit</button>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script>
    $(function () {

$("#accordion")
    .accordion({
                                            header: "> div > .test",
        heightStyle: true,
        collapsible: true,
        active: false,
        activate: function () {

        }
    })
    .sortable({
        axis: "y",
        handle: ".test",
        stop: function (event, ui) {
            // IE doesn't register the blur when sorting
            // so trigger focusout handlers to remove .ui-state-focus
            ui.item.children(".test").triggerHandler("focusout");
            newOrder = (ui.item.index()+1);
            console.log(ui.item);
            sectionId=ui.item[0].children[0].id;
            // Refresh accordion to handle new order
            $(this).accordion("refresh");
            $.ajax({

                url: '#',//"@Url.Action("SaveSectionOrder", "Section")",
                data: { 'newOrder': newOrder, 'sectionId': sectionId },
                type: "GET",
                success: function () {
                    toastr.success("Section New Location Saved")
                    //location.reload();
                },
                error: function () {
                    //toastr.error("Error");
                }
            });
        }
    });
});

$(function () {
$(".cities").sortable({
    revert: true,
    stop: function (event, ui) {
            // IE doesn't register the blur when sorting
            // so trigger focusout handlers to remove .ui-state-focus
            ui.item.children(".test").triggerHandler("focusout");
        newOrder = (ui.item.index() + 1);
        //console.log(ui.item[0].id);
        sectionId = ui.item[0].id
            // Refresh accordion to handle new order

            $.ajax({

                url: '#',//"@Url.Action("SaveSubSectionOrder", "Section")",
                data: { 'newOrder': newOrder, 'sectionId': sectionId },
                type: "GET",
                success: function () {
                    toastr.success("Section New Location Saved")
                    //location.reload();
                },
                error: function () {
                    //toastr.success(" Success")
                }
            });
        }
})
});
        $(document).ready(function () {
            $("#isFileExist").change(function () {
                $("#FileUpload").toggle("slow");
                var newVal = $("#isFileExistVal").val() == 0 ? 1 : 0;
                $("#isFileExistVal").val(newVal);
            });

            $("#SubmitServiceReq").click(function (event) {
                event.preventDefault();
                if ($("#company_name").val() === "") {
                    // toast alert
                    toastr.error('Check Comapny Name');
                    return;
                }
                if ($("#contact_name").val() === "") {
                    // toast alert
                    toastr.error('Check Contact Name');
                    return;
                }
                if ($("#contact_phone").val() === "") {
                    // toast alert
                    toastr.error('Check Contact Phone');
                    return;
                }
                if ($("#contact_email").val() === "") {
                    // toast alert
                    toastr.error('Check Contact Email');
                    return;
                }
                if ($("#industry").val() === "") {
                    // toast alert
                    toastr.error('Check Industry');
                    return;
                }
                if ($("#Country").val() === "") {
                    // toast alert
                    toastr.error('Check Country');
                    return;
                }
                if ($("#employees").val() === "") {
                    // toast alert
                    toastr.error('Check Employees');
                    return;
                }
                if (($("#isFileExistVal").val() === "1") && ($("#HRPolice")[0].files.length <= 0)) {
                    // toast alert
                    toastr.error('Check HR ploicy file');
                    return;
                }

                var form = $('#requesrServiceForm');
                form.attr('enctype', 'multipart/form-data');
                var formData = new FormData(form[0]);
                $.ajax({
                    url: "/RequestMBServices/anythingtosave",
                    type: "POST",
                    processData: false,
                    contentType: false,
                    data:  formData ,
                    success: (response) => {
                        if (response.success) {
                            $('#RequestService').modal('hide');
                            //toaster success
                            toastr.success("Your Request has benn submitted");
                            /*window.location.reload();*/
                        }
                        else {
                            toastr.error("Somthing went Wrong")
                            console.log(response.responseText);
                        }
                    },
                    error: (error) => {
                        toastr.error("Somthing went Wrong")
                        console.log(error);
                    }
                });
            });
            SetupServiceid = (service) => {
                $("#serviceID").val(service);
                service == '1' ? $("#RequestServiceLabel").html("@Resources.General.SectionCPlanTitle") : $("#RequestServiceLabel").html("@Resources.General.SectionOLPlanTitle")
            }
        });
        $(function ()
        {
    $('#releases ul li').sortable({ // #releases ul li
        containment: "document",
        items: '> ul',
        handle: '.sort',
        cursor: 'move',
        connectWith: '.releaseRow', // #releases ul
        placeholder: 'holder',
        tolerance: "pointer",
        revert: 300,
        forcePlaceholderSize: true,
        opacity: 0.5,
        helper: "clone",
        scroll: false,
        dropOnEmpty: true,
        stop: function (event, ui) {
            Swal.fire("The new sort-order will be saved only for subscribed users")
            var sectionId = ui.item.attr("data-SectionId");
            console.log("Section Id : " + sectionId);
            var newOrder = (ui.item.index() + 1);
            console.log("new Order : " + newOrder);
            // @*$.ajax({
            //     url: "@Url.Action("SaveSectionOrder", "Section")",
            //     data: { 'newOrder': newOrder, 'sectionId': sectionId },
            //     type: "GET",
            //     success: function () {
            //         toastr.success("Section New Location Saved")
            //         //location.reload();
            //     },
            //     error: function () {
            //         //toastr.error("Error");
            //     }
            // });*@
        },
        //change: function (event, ui) {
        //    // do your stuff here.
        //    alert("Ok");
        //}
    });


    $('.releaseTracks').sortable({ // #releases ul li
        containment: "document",
        items: '> ul',
        handle: '.sort',
        cursor: 'move',
        helper: "clone",
        revert: 300,
        connectWith: '.releaseTracks', // #releases ul
        placeholder: 'holder',
        tolerance: "pointer",
        forcePlaceholderSize: true,
        opacity: 0.5,
        scroll: true,
        dropOnEmpty: true,
        containment: "parent",
        stop: function (event, ui) {
            Swal.fire('The new sort-order will be saved only for subscribed users')
            // @*debugger;
            // var sectionId = ui.item.attr("data-SectionId");
            // console.log("Section Id : " + sectionId);
            // var newOrder = (ui.item.index() + 1);
            // console.log("new Order : " + newOrder);
            // $.ajax({
            //     url: "@Url.Action("SaveSubSectionOrder", "Section")",
            //     data: { 'newOrder': newOrder, 'sectionId': sectionId },
            //     type: "GET",
            //     success: function () {
            //         toastr.success("Section New Location Saved")
            //         //location.reload();
            //     },
            //     error: function () {
            //         //toastr.error("Error");
            //     }
            // });*@
        },
    });

    $('.showTracks').on('click', function () {
        id = $(this).attr("id");
        idvariables = id.split("-");
        spanID = "#plus-icon-" + idvariables[1];
        if ($(spanID).length > 0) {
            classes=$(spanID).attr("class");

            if (classes.includes("fa-plus")) {
                                    classes = classes.replace('fa-plus', 'fa-minus');
                                }
            else {
                classes = classes.replace('fa-minus', 'fa-plus');

            }
            $(spanID).attr("class", classes);
        }
        $(this).closest('.releaseRow').find('.releaseTracks').slideToggle(function () {
            //if ($(this).children().length)

        });
    });

    $(".tooltip_bottom_center").tooltip({
        tooltipClass: "tooltipBox",
        show: {
            effect: "slideDown",
            delay: 100
        },

        position: {
            my: "center",
            at: "bottom+10"
        }
    });
              var releaseItem = $('.releases li ul.releaseRow');
    releaseItem = releaseItem.slice(1);
    var container = $('.releases > li ul.releaseRow:gt(0)');
    var order = [3, 4];
    var release_id = null;

    $(document).one('ready', function () {
        setOrder(order);
    });
});

    // Set releases order
    function setOrder(order) {
        // console.log(order);
        if (order !== undefined && order !== null && order.length !== 0) {
            // console.log('A - ' + 'Order: ' + order);
            render(order);
        } else {
            // TODO update to be actual release id's of default value being used on page load.
            $.each(releaseItem, function (i, v) {

                // var release_id = i; // update to use actual release ID.
                // $(this).attr('data-soResourceseGeneralsourcesurcesurcest', release_id);
                order.push($(this).data('sort'));
                var items = $(this).children('li');

                $.each(items, function (i, v) {
                    $(this).attr('data-sort', $(this).parent().data('sort') + '.' + i++);
                });

            });
            // console.log('B');
            render(order);
        }
    }


    // Get releases order
    function getOrder() {
        if (order !== undefined && order !== null && order.length !== 0) {
            return order;
        } else {
            return 0;
        }
    }

    // Sort releases order based on sort selction
    function sortReleases(sortby) // string
    {
        // Get current order
        var currentOrder = getOrder();
        // console.log(currentOrder);

        var dataValue = [];
        var sortValue = Array();
        var toSort = [];
        var newOrder = [];

        $.each(releaseItem, function () {
            dataValue.push($(this).children('li').not('li.releaseTracks'));
        });

        $.each(dataValue, function (k, v) {
            $.each(v, function () {
                if ($(this).data('sortby') === sortby) {
                    var rId = 'release_' + $(this).parent().data('sort');
                    // console.log(rId + ' ' + $(this).text());
                    sortValue[rId] = $(this).text();
                }
            });
        });
        // console.log(sortValue);

        var alpha = /[^a-zA-Z]/g;
        var numeric = /[^0-9]/g;

        function sortAlphaNum(a, b) {
            console.log(a);
            console.log(b);
            var aA = a.replace(alpha, "");
            var bA = b.replace(alpha, "");
            if (aA === bA) {
                var aN = parseInt(a.replace(numeric, ""), 10);
                var bN = parseInt(b.replace(numeric, ""), 10);
                return aN === bN ? 0 : aN > bN ? 1 : -1;
            } else {
                return aA > bA ? 1 : -1;
            }
        }
        // console.log(sortValue);
        sortValue.sort(sortAlphaNum);
        // sortAlphaNum(sortValue);
        console.log(sortValue);
        render(sortValue);
    }

    // Event, listen for releases order selection
    $('.releaseHeadings .fa-sort').on('click', function () {
        var sortby = $(this).parent().data('sortby');
        sortReleases(sortby);
    });

    function render(order) {
        // console.log('Output HTML of releases in new order: ' + order);
    }
    function deleteSection(sectionId) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire(
                            'Deleted!',
                            'After subscription user can delete any section and it will be effected in database, for now deleting section will not affected into database',
                            'success'
                        )
                    }
                })

};
$(".editSection").on("click", function () {

                var sectionId = $(this).attr("data-SectionId")
                console.log(sectionId);
                $(".list_icon").removeClass("activee");
                $(".trackRow").removeClass("activee");
                $(this).parent().parent().addClass("activee");
                $.ajax({
                    url: "{{ url('sections/editSec') }}/"+sectionId,
                    // data: { "sectionId": sectionId },
                    type: "GET",
                    async: false,
                    success: function (data) {
                        $("#divEditSection").html(data);
                        var divEditSection = document.getElementById("divEditSection");
                                var ix = divEditSection.style.display == "none" ? 0 : 1;

                        if (secid == sectionId || secid == null || (secid != sectionId && ix==0)) {
                            $('#divEditSection').toggle(ix === 0);
                        }

                        },
                    error: function (data) {
                        console.log(data)
                        toastr.error("Error 12545")
                    }
                });
                            secid = sectionId;
            });
</script>
<script>
    const draggables = document.querySelectorAll('.accordion-item')
const containers = document.querySelectorAll('.accordion')

draggables.forEach(draggable => {
  draggable.addEventListener('dragstart', () => {
    draggable.classList.add('dragging')
  })

  draggable.addEventListener('dragend', () => {
    draggable.classList.remove('dragging')
  })
})

containers.forEach(container => {
  container.addEventListener('dragover', e => {
      const draggable = document.querySelector('.dragging')
      // get draggable parent element
        const parent = draggable.parentElement;
        //check if parent is not the same as the container
        if(container.contains(draggable)){
            e.preventDefault()
    const afterElement = getDragAfterElement(container, e.clientY)
    console.log(afterElement);
    if (afterElement == null) {
      container.appendChild(draggable)
    } else {
      container.insertBefore(draggable, afterElement)
    }
        }

  })
})

function getDragAfterElement(container, y) {
  const draggableElements = [...container.querySelectorAll('.accordion-item:not(.dragging)')]

  return draggableElements.reduce((closest, child) => {
    const box = child.getBoundingClientRect()
    const offset = y - box.top - box.height / 2

    if (offset < 0 && offset > closest.offset) {
      return { offset: offset, element: child }
    } else {
      return closest
    }
  }, { offset: Number.NEGATIVE_INFINITY }).element
}
</script>

@endsection
