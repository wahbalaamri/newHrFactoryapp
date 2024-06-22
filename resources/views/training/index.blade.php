@extends('layouts.main')
@section('content')

<link href="{{ asset('assets/TrCss/SomePart.css') }}" rel="stylesheet" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="{{ asset('assets/TrCss/slider.css') }}" rel="stylesheet" />
<style>
    .btn-hr {
        color: #FFFFFF;
        background-color: #e3a32a;
        border-color: #ffc107;
        font-weight: bold;
    }

        .btn-hr:hover {
            color: #3f3737;
            background-color: ##ff6a00;
            border-color: #31a6e0;
            font-weight: bold;
        }
</style>

<section class="jumbotron text-center" >
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-12 text-center">
                <img src="{{ asset('assets/TrCss/img/logo.png') }}"  height="100" />
                <h1>
                    HR Learning
                </h1>
            </div>
            <div class="col-md-6  col-sm-12 text-center">

                <div style="
        background-size: contain, cover;
        background-image: url('{{ asset('assets/TrCss/img/screen.png') }}');
        background-repeat: no-repeat;
        background-position: center center;
        margin-bottom: -150px;
        padding: 60px !important;">
                    <div class="embed-responsive embed-responsive-16by9 mr-lg-5 mb-lg-5 mr-sm-0 mb-sm-1 ">
                        <iframe class="embed-responsive-item" src="{{ app()->getLocale()=='ar'? asset('assets/vedios/Arabic.mp4'):asset('assets/vedios/English.mp4') }}" allowfullscreen></iframe>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="container sm-mt-25px margin-top-59px mt-sm-5 mt-md-5 sm-mt-45px">
    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto mt-sm-auto text-center">

        <p class="lead">
            ViewBag.LearnOnlineText

        </p>
    </div>
</div>

<!-- END REVOLUTION SLIDER -->

<div class="container">
    <center>
        <h1>
            SelectCourse

        </h1>
        <br />
    </center>

    <div class="row">
        <div class="col-md-12">
                <div class="slides float-right">
                    {{-- @foreach ( $item  as $Model)
                    {
                        <div class="slide card" style="padding: 0px;">
                            <a href="@Url.Action("CourseDetails","TrainingHome",new { CID=@item.Courses.CourseID})">

                                <div style="width: 100%; height: 100%;">
                                    <img class="imgSlide" height="150"
                                         src='~/Images/coursesAvatar/@item.Courses.Avatar' />
                                    <img src="~/Images/TrainerAvatar/@item.Trainers.TrainerAvatar" class="rounded-circle avatar" />

                                    <div class="Course-info">
                                        <p class="text-grey-2">@item.Trainers.TrainerName</p>

                                        <h5 class="CourseName">
                                            @Html.DisplayFor(modelItem => item.Courses.CourseName)
                                        </h5>
                                    </div>
                                    <div class="slide-footer mt-4">
                                        <span class="pull-right text-orange pr-2">
                                            @Html.DisplayFor(modelItem => item.Courses.CoursePrice)
                                        </span>
                                        <span class="pull-left pl-2">
                                            <i class="fa fa-user text-grey-2"></i>
                                            <i class="fa fa-comment text-grey-2"></i>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </div>

                    } --}}

                </div>
            </div>
    </div>


    <center class="m-lg-5">
        <a class="btn btn-hr btn-lg" href="{{-- @Url.Action("AllCourses") --}}">
            HumanResourceHelth.Model.Resources.AppResource.ShowAll
        </a>
    </center>
</div>

<div style="margin-top:20px">
        *Html.Partial("GetTrainers");*
    </div>

{{--
<script type="text/javascript">
    var tpj = jQuery;

    var revapi18;
    tpj(document).ready(function () {
        if (tpj("#rev_slider_18_1").revolution == undefined) {
            revslider_showDoubleJqueryError("#rev_slider_18_1");
        } else {
            revapi18 = tpj("#rev_slider_18_1").show().revolution({
                sliderType: "standard",
                jsFileLocation: "//localhost/revslider-standalone/revslider/public/assets/revslider/assets/js/",
                sliderLayout: "fullwidth",
                dottedOverlay: "none",
                delay: 9000,
                navigation: {
                    keyboardNavigation: "off",
                    keyboard_direction: "horizontal",
                    mouseScrollNavigation: "off",
                    mouseScrollReverse: "default",
                    onHoverStop: "off",
                    arrows: {
                        style: "uranus",
                        enable: true,
                        hide_onmobile: false,
                        hide_onleave: true,
                        hide_delay: 200,
                        hide_delay_mobile: 1200,
                        tmp: '',
                        left: {
                            h_align: "left",
                            v_align: "center",
                            h_offset: 20,
                            v_offset: 0
                        },
                        right: {
                            h_align: "right",
                            v_align: "center",
                            h_offset: 20,
                            v_offset: 0
                        }
                    },
                    bullets: {
                        enable: true,
                        hide_onmobile: false,
                        style: "hermes",
                        hide_onleave: false,
                        direction: "horizontal",
                        h_align: "center",
                        v_align: "bottom",
                        h_offset: 0,
                        v_offset: 60,
                        space: 5,
                        tmp: ''
                    }
                },
                responsiveLevels: [1240, 1024, 778, 480],
                visibilityLevels: [1240, 1024, 778, 480],
                gridwidth: [1110, 1024, 778, 480],
                gridheight: [500, 500, 500, 500],
                lazyType: "none",
                shadow: 0,
                spinner: "spinner0",
                stopLoop: "off",
                stopAfterLoops: -1,
                stopAtSlide: -1,
                shuffle: "off",
                autoHeight: "off",
                disableProgressBar: "on",
                hideThumbsOnMobile: "off",
                hideSliderAtLimit: 0,
                hideCaptionAtLimit: 0,
                hideAllCaptionAtLilmit: 0,
                debugMode: false,
                fallbacks: {
                    simplifyAll: "off",
                    nextSlideOnWindowFocus: "off",
                    disableFocusListener: false,
                }
            });
        }
    }); /*ready*/</script> --}}

@endsection
