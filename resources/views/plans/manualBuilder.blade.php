@extends('layouts.main')
@section('content')

<!-- Page title --->
<div id="page-title" class="text-grey background-overlay " style="background-image: url('{{ asset("
    assets/img/manualbuilder.jpg") }}');background-size: cover;background-repeat: no-repeat;">
    <div>
        <div class="container padding-tb-35px z-index-2 position-relative">
            <div class="row">
                <div class="col-xl-2">
                    <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 99 98">
                        <defs>
                            <style>
                                .cls-1 {
                                    fill: #1f1c1d;
                                }

                                .cls-2 {
                                    fill: #e4a229;
                                }

                                .cls-3 {
                                    fill: #fefefe;
                                }
                            </style>
                        </defs>
                        <title>icon-mb</title>
                        <path class="cls-1"
                            d="M20.86,57.94H40.21a3.58,3.58,0,0,0,3.34,2.25h1.32a1.18,1.18,0,0,1,.93.45H20.86ZM52.94,21.87H65.41v9H62.75V24.53H52.94v6.11H23.88V24.53H14.07V87.16H62.75V77.42h2.66V89.83h-54v-68H23.88v-7.2h6V8.17h17v6.5h6ZM20.86,37.49H46.64l-1.35,1.35a3.41,3.41,0,0,0-.84,1.32H20.86Zm0,30.67H44.45a3.31,3.31,0,0,0,.84,1.35l1.35,1.35H20.86Zm0-20.45H45.8a1.12,1.12,0,0,1-.93.45H43.55a3.57,3.57,0,0,0-3.34,2.25H20.86ZM50.27,22.86V17.37H44.2v-6.5H32.62v6.5h-6V27.94H50.27Z" />
                        <path class="cls-2"
                            d="M87,56.59a1.17,1.17,0,0,1-1.19,1.19H84.45a3.62,3.62,0,0,0-3.38,2.34c-.13.36-.29.68-.42,1a3.58,3.58,0,0,0,.71,4.05l1,.93a1.25,1.25,0,0,1,0,1.71h0l-3.4,3.4a1.18,1.18,0,0,1-1.71,0l-1-.93a3.64,3.64,0,0,0-4-.74,10,10,0,0,1-1,.42,3.67,3.67,0,0,0-2.31,3.38v1.31a1.23,1.23,0,0,1-1.23,1.23H62.84a1.22,1.22,0,0,1-1.19-1.23V73.34A3.65,3.65,0,0,0,59.31,70c-.33-.13-.65-.26-1-.42a3.6,3.6,0,0,0-4,.74l-1,.93a1.18,1.18,0,0,1-1.71,0h0l-3.41-3.4a1.25,1.25,0,0,1,0-1.71l1-.93a3.69,3.69,0,0,0,.71-4.05,9.09,9.09,0,0,1-.42-1,3.68,3.68,0,0,0-3.38-2.34H44.77a1.17,1.17,0,0,1-1.19-1.19V51.76a1.17,1.17,0,0,1,1.19-1.18h1.32a3.66,3.66,0,0,0,3.38-2.35c.13-.32.29-.68.42-1a3.63,3.63,0,0,0-.71-4l-1-.93a1.25,1.25,0,0,1,0-1.71h0l3.41-3.4a1.18,1.18,0,0,1,1.71,0l1,.93a3.6,3.6,0,0,0,4,.74c.35-.16.67-.29,1-.42A3.65,3.65,0,0,0,61.65,35V33.7a1.21,1.21,0,0,1,1.19-1.22h4.82a1.22,1.22,0,0,1,1.23,1.22V35a3.67,3.67,0,0,0,2.31,3.37,10,10,0,0,1,1,.42,3.64,3.64,0,0,0,4-.74l1-.93a1.18,1.18,0,0,1,1.71,0l3.4,3.4a1.25,1.25,0,0,1,0,1.71l-1,.93a3.65,3.65,0,0,0-.71,4c.13.32.29.68.42,1a3.64,3.64,0,0,0,3.38,2.35h1.31A1.16,1.16,0,0,1,87,51.76ZM63.16,46a7.78,7.78,0,0,1,2.09-.26,5.35,5.35,0,0,1,1.06.07c.07,0,.16,0,.26,0a6.57,6.57,0,0,1,.77.16l.26.06a9.24,9.24,0,0,1,1.83.78,1.28,1.28,0,0,1,.26.16l.58.38a2.64,2.64,0,0,1,.29.23l.67.58c.1.09.16.19.26.29s.26.28.39.45.19.25.25.35a4.72,4.72,0,0,1,.36.55l.19.29a6.81,6.81,0,0,1,.42.9,1.37,1.37,0,0,0,.13.35l.19.67c0,.13.06.23.09.36.07.32.13.64.17,1v.29a3.93,3.93,0,0,1,0,.84v.29l-.1.86a8.51,8.51,0,0,1-4.24,5.92c-.17.06-.29.16-.45.23l-.1,0a9.21,9.21,0,0,1-2.19.67c-.06,0-.13,0-.16,0s-.32,0-.45,0a3.89,3.89,0,0,1-.61,0h-.22a8.43,8.43,0,0,1-.87,0l-.16,0a4.75,4.75,0,0,1-1-.19,8.43,8.43,0,0,1,0-16.33Z" />
                        <path class="cls-3"
                            d="M61.36,46a8.15,8.15,0,0,1,2.12-.26,4.91,4.91,0,0,1,1,.07c.1,0,.2,0,.29,0a6.57,6.57,0,0,1,.77.16c.07,0,.17,0,.23.06a9.25,9.25,0,0,1,1.86.78l.26.16.58.38a1.94,1.94,0,0,1,.29.23l.67.58c.07.09.16.19.23.29a4.4,4.4,0,0,1,.42.45c.09.12.16.25.25.35l.36.55a1.18,1.18,0,0,1,.16.29,4.37,4.37,0,0,1,.42.9c.06.12.09.22.16.35l.19.67c0,.13.06.23.1.36.06.32.09.64.13,1a1,1,0,0,1,0,.29v1.13a8.1,8.1,0,0,1-.13.86,8.44,8.44,0,0,1-4.21,5.92,3.77,3.77,0,0,0-.45.23l-.1,0a9,9,0,0,1-2.22.67.39.39,0,0,0-.16,0c-.13,0-.29,0-.45,0a3.69,3.69,0,0,1-.58,0h-.25a7.86,7.86,0,0,1-.84,0l-.16,0a4.89,4.89,0,0,1-1-.19,8.43,8.43,0,0,1,0-16.33Z" />
                        <path class="cls-1"
                            d="M85.18,56.59A1.18,1.18,0,0,1,84,57.78H82.65a3.7,3.7,0,0,0-3.38,2.34,9.09,9.09,0,0,1-.42,1,3.64,3.64,0,0,0,.74,4.05l.93.93a1.18,1.18,0,0,1,0,1.71h0l-3.4,3.4a1.18,1.18,0,0,1-1.71,0l-.93-.93a3.64,3.64,0,0,0-4-.74,9.09,9.09,0,0,1-1,.42,3.67,3.67,0,0,0-2.31,3.38v1.31a1.23,1.23,0,0,1-1.22,1.23H61.07a1.22,1.22,0,0,1-1.19-1.23V73.34A3.65,3.65,0,0,0,57.54,70c-.32-.13-.68-.26-1-.42a3.66,3.66,0,0,0-4,.74l-.93.93a1.18,1.18,0,0,1-1.71,0h0l-3.4-3.4a1.18,1.18,0,0,1,0-1.71l.93-.93a3.64,3.64,0,0,0,.74-4.05,9.09,9.09,0,0,1-.42-1,3.7,3.7,0,0,0-3.38-2.34H43a1.2,1.2,0,0,1-1.23-1.19V51.76A1.19,1.19,0,0,1,43,50.58h1.31a3.68,3.68,0,0,0,3.38-2.35c.13-.32.26-.68.42-1a3.64,3.64,0,0,0-.74-4l-.93-.93a1.18,1.18,0,0,1,0-1.71h0l3.4-3.4a1.18,1.18,0,0,1,1.71,0l.93.93a3.66,3.66,0,0,0,4,.74c.32-.16.68-.29,1-.42A3.69,3.69,0,0,0,59.88,35V33.7a1.21,1.21,0,0,1,1.19-1.22H65.9a1.22,1.22,0,0,1,1.22,1.22V35a3.67,3.67,0,0,0,2.31,3.37,9.09,9.09,0,0,1,1,.42,3.64,3.64,0,0,0,4-.74l.93-.93a1.18,1.18,0,0,1,1.71,0l3.4,3.4a1.18,1.18,0,0,1,0,1.71l-.93.93a3.6,3.6,0,0,0-.71,4c.13.32.26.68.39,1a3.72,3.72,0,0,0,3.38,2.35H84a1.18,1.18,0,0,1,1.18,1.18ZM84,48.16H82.65a1.17,1.17,0,0,1-1.1-.8c-.16-.39-.32-.74-.48-1.12a1.19,1.19,0,0,1,.22-1.36l1-.93a3.67,3.67,0,0,0,0-5.11l-3.41-3.41a3.62,3.62,0,0,0-5.11,0l-1,.94a1.22,1.22,0,0,1-1.35.25,7.52,7.52,0,0,0-1.13-.48A1.2,1.2,0,0,1,69.53,35V33.7a3.63,3.63,0,0,0-3.63-3.64H61.07a3.61,3.61,0,0,0-3.6,3.64V35a1.23,1.23,0,0,1-.8,1.12l-1.13.45a1.17,1.17,0,0,1-1.35-.22l-.93-1a3.67,3.67,0,0,0-5.11,0l-3.41,3.44a3.62,3.62,0,0,0,0,5.11l.93.93a1.25,1.25,0,0,1,.26,1.36c-.16.38-.32.73-.48,1.12a1.18,1.18,0,0,1-1.13.8H43a3.63,3.63,0,0,0-3.64,3.6v4.83A3.63,3.63,0,0,0,43,60.19h1.31a1.21,1.21,0,0,1,1.13.8,9.11,9.11,0,0,0,.48,1.13,1.24,1.24,0,0,1-.26,1.35l-.93.93a3.62,3.62,0,0,0,0,5.11l3.41,3.41a3.62,3.62,0,0,0,5.11,0l.93-.93a1.24,1.24,0,0,1,1.35-.26,7.52,7.52,0,0,0,1.13.48,1.24,1.24,0,0,1,.8,1.13v1.31a3.61,3.61,0,0,0,3.6,3.64H65.9a3.63,3.63,0,0,0,3.63-3.64V73.34a1.21,1.21,0,0,1,.77-1.13c.39-.13.77-.29,1.13-.45a1.18,1.18,0,0,1,1.35.23l1,1a3.61,3.61,0,0,0,5.08,0l3.41-3.41a3.62,3.62,0,0,0,0-5.11l-.94-.93a1.17,1.17,0,0,1-.22-1.35c.16-.36.32-.74.48-1.13a1.17,1.17,0,0,1,1.1-.8H84a3.6,3.6,0,0,0,3.6-3.6V51.76a3.6,3.6,0,0,0-3.6-3.6Z" />
                        <path class="cls-1"
                            d="M61.36,46a8.15,8.15,0,0,1,2.12-.26,4.91,4.91,0,0,1,1,.07c.1,0,.2,0,.29,0a6.57,6.57,0,0,1,.77.16c.07,0,.17,0,.23.06a9.25,9.25,0,0,1,1.86.78l.26.16.58.38a1.94,1.94,0,0,1,.29.23l.67.58c.07.09.16.19.23.29a4.4,4.4,0,0,1,.42.45c.09.12.16.25.25.35l.36.55a1.18,1.18,0,0,1,.16.29,4.37,4.37,0,0,1,.42.9c.06.12.09.22.16.35l.19.67c0,.13.06.23.1.36.06.32.09.64.13,1a1,1,0,0,1,0,.29v1.13a8.1,8.1,0,0,1-.13.86,8.44,8.44,0,0,1-4.21,5.92,3.77,3.77,0,0,0-.45.23l-.1,0a9,9,0,0,1-2.22.67.39.39,0,0,0-.16,0c-.13,0-.29,0-.45,0a3.69,3.69,0,0,1-.58,0h-.25a7.86,7.86,0,0,1-.84,0l-.16,0a4.89,4.89,0,0,1-1-.19,8.43,8.43,0,0,1,0-16.33Zm13,7.68a6.23,6.23,0,0,0-.07-.86,6.78,6.78,0,0,0-.16-.9,4.37,4.37,0,0,0-.16-.62,6.28,6.28,0,0,0-.22-.7,2.44,2.44,0,0,0-.16-.52c-.16-.38-.36-.77-.55-1.12,0,0,0-.07,0-.1a12.6,12.6,0,0,0-1.09-1.57.45.45,0,0,1-.1-.13,5.5,5.5,0,0,0-.52-.55L71,46.33a3.66,3.66,0,0,0-.39-.32c-.13-.13-.29-.26-.45-.39L70,45.46a10.85,10.85,0,0,0-6.47-2.12h-.35c-.26,0-.51,0-.77.07l-.42,0c-.38.06-.77.13-1.16.22a10.86,10.86,0,0,0,0,21h.07A9.26,9.26,0,0,0,62.1,65c.29,0,.58,0,.84.06s.38,0,.58,0,.7,0,1.06-.06a.28.28,0,0,0,.13,0c.29,0,.57-.07.86-.13a1.34,1.34,0,0,1,.36-.07,5,5,0,0,1,.64-.16l.52-.19c.16-.07.32-.1.48-.16s.32-.16.48-.23l.61-.29h0a14.13,14.13,0,0,0,3.09-2.25,3,3,0,0,0,.64-.77,12.59,12.59,0,0,0,1.83-5,6.3,6.3,0,0,0,.07-.71,4.79,4.79,0,0,0,0-.64c0-.1,0-.16,0-.22s0-.33,0-.49Z" />
                    </svg>
                </div>
            </div>
            <h3 class="font-weight-700 text-capitalize page-title-tech cms pb-3" style="line-height: 1.2;"
                data-contentId="79">{!! app()->getLocale()=='ar'? $contents->where('d_id', 79)->first()->ArabicText:$contents->where('d_id', 79)->first()->EnglishText !!}</h3>
        </div>
    </div>
</div>

<section class="padding-tb-20px background-white">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 text-center">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="clearfix margin-bottom-30px">
                            <a href="{{ App()->getLocale()=='ar'?asset('Areas/plansData/ManualBuilderArabic.pdf'):asset('Areas/plansData/ManualBuilder.pdf') }}"
                                download>
                                <svg id="Layer_11" data-name="Layer 11" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 70 91">
                                    <defs>
                                        <style>
                                            .cls-1 {
                                                fill: #e4a229;
                                            }
                                        </style>
                                    </defs>
                                    <title>pdf</title>
                                    <path class="cls-1"
                                        d="M17.82,56.45c0-1.35-1-2.13-2.57-2.13a4.42,4.42,0,0,0-1.35.13v4.27a6.74,6.74,0,0,0,1.09.09c1.74,0,2.83-.87,2.83-2.36Z" />
                                    <path class="cls-1"
                                        d="M27.89,54.36a5.75,5.75,0,0,0-1.48.13V64a4.68,4.68,0,0,0,1.18.09c3,0,4.88-1.61,4.88-5.1,0-3-1.74-4.58-4.58-4.58Z" />
                                    <path class="cls-1"
                                        d="M46.68,4.75H14.42a8.55,8.55,0,0,0-8.54,8.54V44.9H5.05A3.45,3.45,0,0,0,1.6,48.34V69.27a3.46,3.46,0,0,0,3.45,3.45h.83v3.83a8.56,8.56,0,0,0,8.54,8.55h44A8.57,8.57,0,0,0,67,76.55V25Zm-36,47.39a25.82,25.82,0,0,1,4.44-.31A6.8,6.8,0,0,1,19.48,53a4.09,4.09,0,0,1,1.57,3.36,4.51,4.51,0,0,1-1.35,3.4A6.47,6.47,0,0,1,15,61.29a9.05,9.05,0,0,1-1.09,0v5.19H10.63ZM58.45,79.87h-44a3.32,3.32,0,0,1-3.31-3.32V72.72H52.18a3.48,3.48,0,0,0,3.44-3.45V48.34a3.48,3.48,0,0,0-3.44-3.44H11.11V13.29A3.31,3.31,0,0,1,14.42,10l30.3-.05V21.14a5.91,5.91,0,0,0,5.93,5.93h11l.13,49.48a3.32,3.32,0,0,1-3.32,3.32ZM23.14,66.35V52.14a26.44,26.44,0,0,1,4.45-.31c2.74,0,4.53.48,5.93,1.53A6.53,6.53,0,0,1,36,58.85a7.29,7.29,0,0,1-2.4,5.84C32,66,29.68,66.57,26.85,66.57a24.67,24.67,0,0,1-3.71-.22ZM46.6,57.94v2.65H41.41v5.85H38.09V51.92H47v2.7H41.41v3.32Z" />
                                </svg>
                            </a>

                            <h4><a href="{{ App()->getLocale()=='ar'?asset('Areas/plansData/ManualBuilderArabic.pdf'):asset('Areas/plansData/ManualBuilder.pdf') }}"
                                    download>@Resources.General.GuidePDF</a></h4>
                            <p class="cms" data-contentId="80">{!! app()->getLocale()=='ar'? $contents->where('d_id',
                                80)->first()->ArabicText:
                                $contents->where('d_id', 80)->first()->EnglishText !!}</p>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-lg-8 wow fadeInUp">
                <video height="360" controls style="border:1px solid black">
                    <source
                        src="{{ App()->getLocale()=='ar'?asset('Areas/plansData/ManualBuilderArabic.pdf'):asset('Areas/plansData/ManualBuilder.mp4') }}"
                        type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>
    </div>
</section>
<section class="padding-tb-20px background-white">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
                <p class="cms" data-contentId="81">{!! app()->getLocale()=='ar'? $contents->where('d_id',
                    81)->first()->ArabicText:
                    $contents->where('d_id', 81)->first()->EnglishText !!}</p>
            </div>
        </div>
        @if(!Auth()->check() || true)
        <div class="container">
            {{-- If user not subscribe or not logedin --}}
            <div class="row text-center">
                <div class="padding-bottom-22px col-lg-12">
                    <a href="{{ route('Plans.SectionPlans') }}"
                        class="btn btn-sm background-main-color text-white padding-lr-15px border-0 opacity-8">{{ __('Subscription Plans') }}</a>
                </div>
            </div>

        </div>
        @endif
    </div>
</section>

@if(Auth()->check())
<div class="container">
    <div class="row">
        <div class="col-5"></div>
        <div class="col-3">
            {{-- if user logedin and has subsrciption --}}
            <a href="" class="btn btn-sm background-main-color text-white padding-lr-15px border-0 opacity-8">
                {{ __('Build Your Document') }}
            </a>
        </div>
    </div>
</div>
@endif
<br />

<div class="modal fade" id="agreeMonthModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="exampleModalLabel2" class="modal-title" data-contentId="">@ViewBag.MBMTitle</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" data-contentId="">Html.Raw(ViewBag.MBMText)</div>
        </div>
    </div>
</div>

<div class="modal fade" id="agreeYearModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="exampleModalLabel1" class="modal-title" data-contentId="">ViewBag.MBATitle</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" data-contentId="">Html.Raw(ViewBag.MBAText)</div>
        </div>
    </div>
</div>

<script>
    $("#freeSubscribeManualBuilderAnnual").on("click", function () {
        let startDate = new Date();
        let endDate = new Date();
        endDate.setDate(endDate.getDate() + 365);
        var startmonth = ((startDate.getMonth() + 1));
        var Endmonth = ((endDate.getMonth() + 1));
        startDay = startDate.getDate();
        startYear = startDate.getFullYear();
        endDay = endDate.getDate();
        endYear = endDate.getFullYear();
        var userId =;
        var planId = "3";
        var fromDay = startDay;
        var fromMonth = startmonth;
        var fromYear = startYear;
        var toDay = endDay;
        var toMonth = Endmonth;
        var toYear = endYear;
        var price = 0;
         $.ajax({
            url: "@Url.Action("SubscribeFree", "Plans")",
            data: {
                "userId": userId, "planId": planId,
                "fromDay": fromDay, "fromMonth": fromMonth, "fromYear": fromYear,
                "toDay": toDay, "toMonth": toMonth, "toYear": toYear,
                "price": price, "isTrail": false
            },
            type: "GET",
            success: function () {
                toastr.success("You have register for annual successfully");
                location.reload();
            },
            error: function (err) {
                toastr.error(err.statusText)
            }
        });
    });

    $("#freeSubscribeManualBuilderMonthly").on("click", function () {
        let startDate = new Date();
        let endDate = new Date();
        endDate.setDate(endDate.getDate() + 30);
        var startmonth = ((startDate.getMonth() + 1));
        var Endmonth = ((endDate.getMonth() + 1));
        startDay = startDate.getDate();
        startYear = startDate.getFullYear();
        endDay = endDate.getDate();
        endYear = endDate.getFullYear();
        var userId =
        var planId = "3";
        var fromDay = startDay;
        var fromMonth = startmonth;
        var fromYear = startYear;
        var toDay = endDay;
        var toMonth = Endmonth;
        var toYear = endYear;
        var price = 0;
         $.ajax({
            url: "",
            data: {
                "userId": userId, "planId": planId,
                "fromDay": fromDay, "fromMonth": fromMonth, "fromYear": fromYear,
                "toDay": toDay, "toMonth": toMonth, "toYear": toYear,
                "price": price,"isTrail": false
            },
            type: "GET",
            success: function () {
                toastr.success("You have register for monthly successfully");
                location.reload();
            },
            error: function (err) {
                toastr.error(err.statusText)
            }
        });
    });
    $("#btnUpgrade").on("click", function () {
        if ($("#divCost").hasClass("d-none")) {
            $("#divCost").removeClass("d-none");
            $("#btnUpgrade").html("@Resources.General.Cancel");
        }
        else {
            $("#divCost").addClass("d-none");
            $("#btnUpgrade").html("@Resources.General.Upgrade");
        }

    });
</script>
@endsection
