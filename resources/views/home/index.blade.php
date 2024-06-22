@extends('layouts.main')
@section('content')

<style type="text/css">
    video {
        /*   width: 100vw;
        height: 100vh;
        top: 0;
        left: 0;*/
    }

    #rev_slider_18_1 .uranus.tparrows {
        width: 50px;
        height: 50px;
        background: rgba(255, 255, 255, 0)
    }

    #rev_slider_18_1 .uranus.tparrows:before {
        width: 50px;
        height: 50px;
        line-height: 50px;
        font-size: 40px;
        transition: all 0.3s;
        -webkit-transition: all 0.3s
    }

    #rev_slider_18_1 .uranus.tparrows:hover:before {
        opacity: 0.75
    }

    .hermes.tp-bullets {}

    .hermes .tp-bullet {
        overflow: hidden;
        border-radius: 50%;
        width: 16px;
        height: 16px;
        background-color: rgba(0, 0, 0, 0);
        box-shadow: inset 0 0 0 2px rgb(255, 255, 255);
        -webkit-transition: background 0.3s ease;
        transition: background 0.3s ease;
        position: absolute
    }

    .hermes .tp-bullet:hover {
        background-color: rgba(0, 0, 0, 0.21)
    }

    .hermes .tp-bullet:after {
        content: ' ';
        position: absolute;
        bottom: 0;
        height: 0;
        left: 0;
        width: 100%;
        background-color: rgb(255, 255, 255);
        box-shadow: 0 0 1px rgb(255, 255, 255);
        -webkit-transition: height 0.3s ease;
        transition: height 0.3s ease
    }

    .hermes .tp-bullet.selected:after {
        height: 100%
    }

    .blog-item p {
        margin-bottom: 0 !important;
    }
</style>

<div class="overslider border-light-box " dir="ltr">
    <div class="dualcol-test padding-18px">
        <div class="margin-bottom-30px">
            <h3 class="padding-textWhite cms" data-contentId="1">
                {{-- get idex of element that has value 1 from contents --}}
                {!! app()->getLocale()=='ar'? $contents->where('d_id', 1)->first()->ArabicText: $contents->where('d_id',
                1)->first()->EnglishText !!}
            </h3>
        </div>
        <div class="margin-bottom-20px">
            <br>
            <br>
            <span class="cms" data-contentId="2">
                {!! app()->getLocale()=='ar'? $contents->where('d_id', 2)->first()->ArabicText: $contents->where('d_id',
                2)->first()->EnglishText !!}
            </span>
        </div>
        <div class="">
            <a href="#"
                class="btn btn-sm background-main-color text-white padding-lr-15px border-0 opacity-8 capitalLetters"
                style="text-transform: capitalize;">StartTheDiagnosis</a>
        </div>
    </div>
</div>

<video id="bgvid" playsinline autoplay muted loop>
    <!--
    - Video needs to be muted, since Chrome 66+ will not autoplay video with sound.
    WCAG general accessibility recommendation is that media such as background video play through only once. Loop turned on for the purposes of illustration; if removed, the end of the video will fade in the same way created by pressing the "Pause" button  -->
    <source src="{{ asset('assets/vedios/Final.mp4') }}" type="video/mp4">
</video>

<section class="background-white">
    <div class="container">
        <div class="row">
            <div class="col-lg-12"></div>
        </div>
    </div>
</section>
<!-- // Section subscription -->
<section>
    <div class="sectionWrapper" id="subscriptionPlans">
        <div id="section1" class="section">
            <div class="sectionInner">
                <div class="container">
                    <div class="text-center margin-bottom-35px fadeInUp">
                        <h1 class="text-center cms" data-contentId="10"><span style="color:#f39c12">{{ __('HR Tools')
                                }}</span></h1>
                    </div>
                    <div class="row ">
                        @foreach ($services as $service)
                        @if ($service->service_type != 6)
                            
                        @endif
                        <div class="col-lg-4 col-md-6 sm-mb-30px wow fadeInUp padding-bottom-42px">
                            <div class="blog-item thum-hover background-white hvr-float hvr-sh2 ">
                                <div class="position-relative">
                                    <div class="date z-index-101 padding-10px image-builder"></div>
                                    <div class="item-thumbnail"><a href="{{ route('tools.view',$service->id) }}"><img
                                                src="{{ asset('uploads/services/icons') }}/{{ $service->service_icon }}" alt=""></a></div>
                                </div>
                                <div class="blog-item padding-lr-30px text-center">
                                    <a href="{{ route('tools.view',$service->id) }}" class="text-extra-large d-block "><span style="color:#f39c12"><span style="font-size:18px">{{ $service->name }}</span></span></a>
                                    <div class="text-center padding-lr-30px padding-bottom-42px height-200 cms"
                                        data-contentId="11"><span style="font-size:14px"><span style="color:black">{!! $service->description !!}</span></span>
                                    </div>
                                    <div class="text-center blog-item padding-bottom-22px">
                                        <a class="youtube" href="{{ route('tools.view',$service->id) }}">
                                            <img src="{{ asset('assets/img/player-01.png') }}" alt="">
                                        </a>
                                    </div>
                                    <div class="padding-bottom-22px"> <a href="{{ route('tools.view',$service->id) }}"
                                            class="btn btn-sm background-main-color text-white padding-lr-15px border-0 opacity-8">{{
                                            __('Go') }}</a></div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        {{-- <div class="col-lg-4 col-md-6 sm-mb-30px wow fadeInUp padding-bottom-42px">
                            <div class="blog-item thum-hover background-white hvr-float hvr-sh2 ">
                                <div class="position-relative">
                                    <div class="date z-index-101 padding-10px image-builder"></div>
                                    <div class="item-thumbnail"> <a href="{{ route('Plans.startup') }}"><img
                                                src="{{ asset('assets/img/HRStar-up.png') }}" alt=""></a></div>
                                </div>
                                <div class="blog-item padding-lr-30px text-center">
                                    <a href="{{ route('Plans.startup') }}" class="text-extra-large d-block ">{!!
                                        app()->getLocale()=='ar'? $contents->where('d_id', 49)->first()->ArabicText:
                                        $contents->where('d_id', 49)->first()->EnglishText !!}</a>
                                    <div class="text-center padding-lr-30px padding-bottom-42px height-200 cms"
                                        data-contentId="12">{!! app()->getLocale()=='ar'? $contents->where('d_id',
                                        12)->first()->ArabicText: $contents->where('d_id', 12)->first()->EnglishText !!}
                                    </div>
                                    <div class="text-center blog-item padding-bottom-22px">
                                        <a class="youtube" href="#">
                                            <img src="{{ asset('assets/img/player-01.png') }}" alt="">
                                        </a>
                                    </div>
                                    <div class="padding-bottom-22px">
                                        <a href="{{ route('Plans.startup') }}"
                                            class="btn btn-sm background-main-color text-white padding-lr-15px border-0 opacity-8">
                                            {{ __('Go') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="col-lg-4 col-md-6 sm-mb-30px wow fadeInUp padding-bottom-42px">
                            <div class="blog-item thum-hover background-white hvr-float hvr-sh2 ">
                                <div class="position-relative">
                                    <div class="date z-index-101 padding-10px image-builder"></div>
                                    <div class="item-thumbnail">

                                        <a href="https://diagnosis.hrfactoryapp.com/">
                                            <img src="{{ asset('assets/img/HRWarm-up.png') }}" alt=""></a>
                                    </div>
                                </div>
                                <div class="blog-item padding-lr-30px text-center">

                                    <a href="https://diagnosis.hrfactoryapp.com/" class="text-extra-large d-block cms"
                                        data-contentId="122">{!! app()->getLocale()=='ar'? $contents->where('d_id',
                                        122)->first()->ArabicText: $contents->where('d_id', 122)->first()->EnglishText
                                        !!}</a>

                                    <div class="text-center padding-lr-30px padding-bottom-20px height-200 cms"
                                        data-contentId="123">{!! app()->getLocale()=='ar'? $contents->where('d_id',
                                        123)->first()->ArabicText: $contents->where('d_id', 123)->first()->EnglishText
                                        !!}</div>
                                    <div class="text-center blog-item padding-bottom-22px">

                                        <a class="youtube" href="https://diagnosis.hrfactoryapp.com/">
                                            <img src="{{ asset('assets/img/player-01.png') }}" alt="">
                                        </a>
                                    </div>
                                    <div class="padding-bottom-22px">
                                        <a href="https://diagnosis.hrfactoryapp.com/"
                                            class="btn btn-sm background-main-color text-white padding-lr-15px border-0 opacity-8">{{
                                            __('Go') }}</a>

                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="col-lg-4 col-md-6 sm-mb-30px wow fadeInUp">
                            <div class="blog-item thum-hover background-white hvr-float hvr-sh2 ">
                                <div class="position-relative">
                                    <div class="date z-index-101 padding-10px image-builder"></div>
                                    <div class="item-thumbnail">
                                        <a href="https://3h.hrfactoryapp.com/"><img
                                                src="{{ asset('assets/img/HRDoctor.png') }}" alt=""></a>

                                    </div>
                                </div>
                                <div class="blog-item padding-lr-30px text-center">
                                    <a href="https://3h.hrfactoryapp.com/" class="text-extra-large d-block cms"
                                        data-contentId="124">{!! app()->getLocale()=='ar'? $contents->where('d_id',
                                        124)->first()->ArabicText: $contents->where('d_id', 124)->first()->EnglishText
                                        !!}</a>
                                    <div class="text-center padding-lr-30px padding-bottom-42px height-200 cms"
                                        data-contentId="125">{!! app()->getLocale()=='ar'? $contents->where('d_id',
                                        125)->first()->ArabicText: $contents->where('d_id', 125)->first()->EnglishText
                                        !!}</div>

                                    <div class="text-center blog-item padding-bottom-22px">
                                        <a class="youtube" href="https://3h.hrfactoryapp.com/">
                                            <img src="{{ asset('assets/img/player-01.png') }}" alt="">
                                        </a>

                                    </div>
                                    <div class="padding-bottom-22px">
                                        <a href="https://3h.hrfactoryapp.com/"
                                            class="btn btn-sm background-main-color text-white padding-lr-15px border-0 opacity-8">{{
                                            __('Go') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-lg-4 col-md-6 sm-mb-30px wow fadeInUp">
                            <div class="blog-item thum-hover background-white hvr-float hvr-sh2 ">
                                <div class="position-relative">
                                    <div class="date z-index-101 padding-10px image-builder"></div>
                                    <div class="item-thumbnail">
                                        <a href="#">

                                            <img src="{{ asset('assets/img/HRTech.png') }}" alt=""></a>
                                    </div>
                                </div>
                                <div class="blog-item padding-lr-30px text-center">
                                    <a href="#" class="text-extra-large d-block cms" data-contentId="47">{!!
                                        app()->getLocale()=='ar'? $contents->where('d_id', 47)->first()->ArabicText:
                                        $contents->where('d_id', 47)->first()->EnglishText !!}</a>
                                    <div class="text-center padding-lr-30px padding-bottom-42px height-200 cms"
                                        data-contentId="15">{!! app()->getLocale()=='ar'? $contents->where('d_id',
                                        15)->first()->ArabicText: $contents->where('d_id', 15)->first()->EnglishText !!}
                                    </div>
                                    <div class="text-center blog-item padding-bottom-22px">
                                        <a class="youtube" href="#">
                                            <img src="{{ asset('assets/img/player-01.png') }}" alt="">
                                        </a>
                                    </div>
                                    <div class="padding-bottom-22px">
                                        <a href="#"
                                            class="btn btn-sm background-main-color text-white padding-lr-15px border-0 opacity-8">{{
                                            __('Go') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-lg-4 col-md-6 sm-mb-30px wow fadeInUp">
                            <div class="blog-item thum-hover background-white hvr-float hvr-sh2 ">
                                <div class="position-relative">
                                    <div class="date z-index-101 padding-10px image-builder"></div>
                                    <div class="item-thumbnail"><a href="#" ,"Plans"><img
                                                src="{{ asset('assets/img/HRPlug-in.png') }}" alt=""></a></div>
                                </div>
                                <div class="blog-item padding-lr-30px text-center">
                                    <a href="#" ,"Plans" class="text-extra-large d-block cms" data-contentId="48">{!!
                                        app()->getLocale()=='ar'? $contents->where('d_id', 48)->first()->ArabicText:
                                        $contents->where('d_id', 48)->first()->EnglishText !!}</a>
                                    <div class="text-center padding-lr-30px padding-bottom-42px height-200 margin-bottom-0px cms"
                                        data-contentId="16">{!! app()->getLocale()=='ar'? $contents->where('d_id',
                                        16)->first()->ArabicText: $contents->where('d_id', 16)->first()->EnglishText !!}
                                    </div>
                                    <div class="text-center blog-item padding-bottom-22px">
                                        <a class="youtube" href="#" ,"Plans">
                                            <img src="{{ asset('assets/img/player-01.png') }}" alt="">
                                        </a>
                                    </div>
                                    <div class="padding-bottom-22px"> <a href="#" ,"Plans"
                                            class="btn btn-sm background-main-color text-white padding-lr-15px border-0 opacity-8">{{
                                            __('Go') }}</a></div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="mb-2">

    <div class="sectionWrapper">
        <div id="section4" class="section">
            <div class="sectionInner">
                <div class="container">
                    <div class="text-center  wow fadeInUp">
                        <h1 class="cms margin-bottom-35px" data-contentId="44">{!! app()->getLocale()=='ar'?
                            $contents->where('d_id', 44)->first()->ArabicText: $contents->where('d_id',
                            44)->first()->EnglishText !!}</h1>
                        <ul class="row  no-gutters padding-0px margin-0px list-unstyled text-center">


                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="video wow">
    <div class="stripeElephant">
        <div class="">
            <div class="text-center">

            </div>
        </div>
    </div>
</section>

<div class="container">
    <div class="row">
        <div class="col-lg-2"> </div>
        <div class="col-lg-3 background-white">
            <div class="margin-bottom-40px font-weight-300 wow fadeInUp">
                <h1 class="text-center cms" data-contentId="17">
                    {!! app()->getLocale()=='ar'? $contents->where('d_id', 17)->first()->ArabicText:
                    $contents->where('d_id', 17)->first()->EnglishText !!}
                </h1>
            </div>
        </div>
        <div class="col-lg-2 background-white">
            <div class="margin-bottom-40px font-weight-300 wow fadeInUp">
                <h1 class="text-center compare">{{ __('VS') }}</h1>
            </div>
        </div>
        <div class="col-lg-3 background-white">
            <div class="margin-bottom-40px font-weight-300 wow fadeInUp">
                <h1 class="text-center cms" data-contentId="18">
                    {!! app()->getLocale()=='ar'? $contents->where('d_id', 18)->first()->ArabicText:
                    $contents->where('d_id', 18)->first()->EnglishText !!}
                </h1>
            </div>
        </div>
        <div class="col-lg-2"> </div>
        <div class="col-lg-1"> </div>
        <div class="col-lg-5 margin-bottom-30px wow fadeInUp d-flex justify-content-center">
            <div class="item">
                <div class="background-white opacity-hover-7 padding-30px">
                    <div class="float-right width-66px margin-left-20px"> <img src="{{ asset('assets/img/icon5.png') }}"
                            alt=""> </div>
                    <h4 class="margin-bottom-0px text-right cms" data-contentId="19">{!! app()->getLocale()=='ar'?
                        $contents->where('d_id', 19)->first()->ArabicText: $contents->where('d_id',
                        19)->first()->EnglishText !!}</h4>
                    <p class="text-grey-2 text-right cms" data-contentId="20">{!! app()->getLocale()=='ar'?
                        $contents->where('d_id', 20)->first()->ArabicText: $contents->where('d_id',
                        20)->first()->EnglishText !!}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-5 margin-bottom-30px wow fadeInUp d-flex justify-content-center">
            <div class="item">
                <div class="background-white opacity-hover-7 padding-30px">
                    <div class="float-left width-66px margin-right-20px"> <img src="{{ asset('assets/img/icon4.png') }}"
                            alt=""> </div>
                    <h4 class="margin-bottom-0px text-left cms" data-contentId="21">{!! app()->getLocale()=='ar'?
                        $contents->where('d_id', 21)->first()->ArabicText: $contents->where('d_id',
                        21)->first()->EnglishText !!}</h4>
                    <p class="text-grey-2 text-left cms" data-contentId="22">{!! app()->getLocale()=='ar'?
                        $contents->where('d_id', 22)->first()->ArabicText: $contents->where('d_id',
                        22)->first()->EnglishText !!}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-1"> </div>
        <div class="col-lg-1"> </div>
        <div class="col-lg-5 margin-bottom-30px wow fadeInUp d-flex justify-content-center">
            <div class="item">
                <div class="background-white opacity-hover-7 padding-30px">
                    <div class="float-right width-66px margin-left-20px"> <img src="{{ asset('assets/img/icon6.png') }}"
                            alt=""> </div>
                    <h4 class="margin-bottom-0px text-right cms" data-contentId="23">{!! app()->getLocale()=='ar'?
                        $contents->where('d_id', 23)->first()->ArabicText: $contents->where('d_id',
                        23)->first()->EnglishText !!}</h4>
                    <p class="text-grey-2 text-right cms" data-contentId="24">{!! app()->getLocale()=='ar'?
                        $contents->where('d_id', 24)->first()->ArabicText: $contents->where('d_id',
                        24)->first()->EnglishText !!}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-5 margin-bottom-30px wow fadeInUp d-flex justify-content-center">
            <div class="item">
                <div class="background-white opacity-hover-7 padding-30px">
                    <div class="float-left width-66px margin-right-20px"> <img src="{{ asset('assets/img/icon7.png') }}"
                            alt=""> </div>
                    <h4 class="margin-bottom-0px text-left cms" data-contentId="25">{!! app()->getLocale()=='ar'?
                        $contents->where('d_id', 25)->first()->ArabicText: $contents->where('d_id',
                        25)->first()->EnglishText !!}</h4>
                    <p class="text-grey-2 text-left cms" data-contentId="26">{!! app()->getLocale()=='ar'?
                        $contents->where('d_id', 26)->first()->ArabicText: $contents->where('d_id',
                        26)->first()->EnglishText !!}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-1"> </div>
        <div class="col-lg-1"> </div>
        <div class="col-lg-5 margin-bottom-30px wow fadeInUp d-flex justify-content-center">
            <div class="item">
                <div class="background-white opacity-hover-7 padding-30px">
                    <div class="float-right width-66px margin-left-20px"> <img src="{{ asset('assets/img/icon8.png') }}"
                            alt=""> </div>
                    <h4 class="margin-bottom-0px text-right cms" data-contentId="27">{!! app()->getLocale()=='ar'?
                        $contents->where('d_id', 27)->first()->ArabicText: $contents->where('d_id',
                        27)->first()->EnglishText !!}</h4>
                    <p class="text-grey-2 text-right cms" data-contentId="28">{!! app()->getLocale()=='ar'?
                        $contents->where('d_id', 28)->first()->ArabicText: $contents->where('d_id',
                        28)->first()->EnglishText !!}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-5 margin-bottom-30px wow fadeInUp d-flex justify-content-center">
            <div class="item">
                <div class="background-white opacity-hover-7 padding-30px">
                    <div class="float-left width-66px margin-right-20px"> <img src="{{ asset('assets/img/icon9.png') }}"
                            alt=""> </div>
                    <h4 class="margin-bottom-0px text-left cms" data-contentId="29">{!! app()->getLocale()=='ar'?
                        $contents->where('d_id', 29)->first()->ArabicText: $contents->where('d_id',
                        29)->first()->EnglishText !!}</h4>
                    <p class="text-grey-2 text-left cms" data-contentId="30">{!! app()->getLocale()=='ar'?
                        $contents->where('d_id', 30)->first()->ArabicText: $contents->where('d_id',
                        30)->first()->EnglishText !!}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-1"> </div>
        <div class="col-lg-1"> </div>
        <div class="col-lg-5 margin-bottom-30px wow fadeInUp d-flex justify-content-center">
            <div class="item">
                <div class="background-white opacity-hover-7 padding-30px">
                    <div class="float-right width-66px margin-left-20px"> <img
                            src="{{ asset('assets/img/icon10.png') }}" alt=""> </div>
                    <h4 class="margin-bottom-0px text-right cms" data-contentId="31">{!! app()->getLocale()=='ar'?
                        $contents->where('d_id', 31)->first()->ArabicText: $contents->where('d_id',
                        31)->first()->EnglishText !!}</h4>
                    <p class="text-grey-2 text-right cms" data-contentId="32">{!! app()->getLocale()=='ar'?
                        $contents->where('d_id', 32)->first()->ArabicText: $contents->where('d_id',
                        32)->first()->EnglishText !!}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-5 margin-bottom-30px wow fadeInUp d-flex justify-content-center">
            <div class="item">
                <div class="background-white opacity-hover-7 padding-30px">
                    <div class="float-left width-66px margin-right-20px"> <img
                            src="{{ asset('assets/img/icon11.png') }}" alt=""> </div>
                    <h4 class="margin-bottom-0px text-left cms" data-contentId="33">{!! app()->getLocale()=='ar'?
                        $contents->where('d_id', 33)->first()->ArabicText: $contents->where('d_id',
                        33)->first()->EnglishText !!}</h4>
                    <p class="text-grey-2 text-left cms" data-contentId="34">{!! app()->getLocale()=='ar'?
                        $contents->where('d_id', 34)->first()->ArabicText: $contents->where('d_id',
                        34)->first()->EnglishText !!}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-1"> </div>
        <div class="col-lg-1"> </div>
        <div class="col-lg-5 margin-bottom-30px wow fadeInUp d-flex justify-content-center">
            <div class="item">
                <div class="background-white opacity-hover-7 padding-30px">
                    <div class="float-right width-66px margin-left-20px"> <img
                            src="{{ asset('assets/img/icon12.png') }}" alt=""> </div>
                    <h4 class="margin-bottom-0px text-right cms" data-contentId="35">{!! app()->getLocale()=='ar'?
                        $contents->where('d_id', 35)->first()->ArabicText: $contents->where('d_id',
                        35)->first()->EnglishText !!}</h4>
                    <p class="text-grey-2 text-right cms" data-contentId="36">{!! app()->getLocale()=='ar'?
                        $contents->where('d_id', 36)->first()->ArabicText: $contents->where('d_id',
                        36)->first()->EnglishText !!}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-5 margin-bottom-30px wow fadeInUp d-flex justify-content-center">
            <div class="item">
                <div class="background-white opacity-hover-7 padding-30px">
                    <div class="float-left width-66px margin-right-20px"> <img
                            src="{{ asset('assets/img/icon13.png') }}" alt=""> </div>
                    <h4 class="margin-bottom-0px text-left cms" data-contentId="37">{!! app()->getLocale()=='ar'?
                        $contents->where('d_id', 37)->first()->ArabicText: $contents->where('d_id',
                        37)->first()->EnglishText !!}</h4>
                    <p class="text-grey-2 text-left cms" data-contentId="38">{!! app()->getLocale()=='ar'?
                        $contents->where('d_id', 38)->first()->ArabicText: $contents->where('d_id',
                        38)->first()->EnglishText !!}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-1"> </div>
    </div>
</div>


<section class="text-grey  background-overlay" style="background-image: url('{{ asset(" assets/img/hrconsultant.jpg")
    }}');">
    <div id="consultHR" class="container padding-tb-100px z-index-2 position-relative">
        <div class="row justify-content-center text-center">
            <div class="container">
                <div class="row ">
                    <div class="col-lg-5 col-md-6 col-xs-12 wow fadeInUp">
                        <div class="text-left padding-tb-60px">
                            <h1 class="font-weight-700 text-capitalize Hr-title pt-0 cms" data-contentId="39">{!!
                                app()->getLocale()=='ar'? $contents->where('d_id', 39)->first()->ArabicText:
                                $contents->where('d_id', 39)->first()->EnglishText !!}</h1>
                            <div class="text-left">
                                <p class="Hr-copy cms" data-contentId="40">{!! app()->getLocale()=='ar'?
                                    $contents->where('d_id', 40)->first()->ArabicText: $contents->where('d_id',
                                    40)->first()->EnglishText !!}</p>
                            </div>
                            <div class="padding-bottom-22px">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<section class="text-grey  background-overlay" style="background-image: url('{{ asset(" assets/img/elearning.png") }}')
    ;background-position:center">
    <div id="learnOnline" class="container padding-tb-100px z-index-2 position-relative">
        <div class="row justify-content-center text-center">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 col-md-6 wow fadeInUp">
                    </div>


                    <div class="col-lg-5 col-md-6 wow fadeInUp">
                        <div class="text-left">
                            <h1 class="font-weight-700 text-capitalize Hr-title cms" data-contentId="41">{!!
                                app()->getLocale()=='ar'? $contents->where('d_id', 41)->first()->ArabicText:
                                $contents->where('d_id', 41)->first()->EnglishText !!}</h1>
                            <div class="text-left">
                                <p class="Learning-copy font-weight-700 cms" data-contentId="42">{!!
                                    app()->getLocale()=='ar'? $contents->where('d_id', 42)->first()->ArabicText:
                                    $contents->where('d_id', 42)->first()->EnglishText !!}</p>
                            </div>
                            <div class="text-left">
                                <p class="Learning-copy cms" data-contentId="43">{!! app()->getLocale()=='ar'?
                                    $contents->where('d_id', 43)->first()->ArabicText: $contents->where('d_id',
                                    43)->first()->EnglishText !!}</p>
                            </div>
                        </div>
                        <div class="text-left">
                            <a href="" class="btn btn-sm background-main-color text-white padding-lr-15px border-0 ">{{
                                __('Learn More') }}</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>






<div class="container">
    <div class="row">
        <div class="col-lg-12 background-white">
            <div class="margin-bottom-40px font-weight-300 wow fadeInUp padding-top-60px">
                <h1 class="text-center cms" data-contentId="3">{!! app()->getLocale()=='ar'? $contents->where('d_id',
                    3)->first()->ArabicText: $contents->where('d_id', 3)->first()->EnglishText !!}</h1>
            </div>
        </div>
        <div class="col-lg-2"> </div>
        <div class="col-lg-8 background-white">
            <div class="">
                <div class="row">
                    <div class="col-lg-12 margin-bottom-30px wow fadeInUp">
                        <div class="item margin-lr-15px">
                            <div class="background-white opacity-hover-7 padding-30px">
                                <div class="float-left width-101px margin-right-20px"> <img
                                        src="{{ asset('assets/img/icon1.png') }}" alt=""> </div>
                                <h4 class="margin-bottom-0px cms" data-contentId="4">{!! app()->getLocale()=='ar'?
                                    $contents->where('d_id', 4)->first()->ArabicText: $contents->where('d_id',
                                    4)->first()->EnglishText !!}</h4>
                                <p class="text-grey-2 cms" data-contentId="5">{!! app()->getLocale()=='ar'?
                                    $contents->where('d_id', 5)->first()->ArabicText: $contents->where('d_id',
                                    5)->first()->EnglishText !!}</p>
                            </div>
                        </div>
                        <div class="item margin-lr-15px">
                            <div class="background-white opacity-hover-7 padding-30px">
                                <div class="float-left width-101px margin-right-20px"> <img
                                        src="{{ asset('assets/img/icon2.png') }}" alt=""> </div>
                                <h4 class="margin-bottom-0px cms" data-contentId="6">{!! app()->getLocale()=='ar'?
                                    $contents->where('d_id', 6)->first()->ArabicText: $contents->where('d_id',
                                    6)->first()->EnglishText !!}</h4>
                                <p class="text-grey-2 cms" data-contentId="7">{!! app()->getLocale()=='ar'?
                                    $contents->where('d_id', 7)->first()->ArabicText: $contents->where('d_id',
                                    7)->first()->EnglishText !!}</p>
                            </div>
                        </div>
                        <div class="item margin-lr-15px">
                            <div class="background-white opacity-hover-7 padding-30px">
                                <div class="float-left width-101px margin-right-20px"> <img
                                        src="{{ asset('assets/img/icon3.png') }}" alt=""> </div>
                                <h4 class="margin-bottom-0px cms" data-contentId="8">{!! app()->getLocale()=='ar'?
                                    $contents->where('d_id', 8)->first()->ArabicText: $contents->where('d_id',
                                    8)->first()->EnglishText !!}</h4>
                                <p class="text-grey-2 cms" data-contentId="9">{!! app()->getLocale()=='ar'?
                                    $contents->where('d_id', 9)->first()->ArabicText: $contents->where('d_id',
                                    9)->first()->EnglishText !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2"> </div>
    </div>
</div>
@endsection
