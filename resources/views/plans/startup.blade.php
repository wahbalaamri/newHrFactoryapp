@extends('layouts.main')
@section('content')


{{-- @functions{
IHtmlString GetContent(int contentId)
{
string content = "";
List<Content> contents = (List<Content>)Session["Content"];
        Content content1 = contents.Where(x => x.Id == contentId).SingleOrDefault();
        if (!System.Threading.Thread.CurrentThread.CurrentCulture.TextInfo.IsRightToLeft)
        {
        content = content1 != null ? content1.EnglishText : "";
        if (content.Trim() == "") content = "Please Insert Text";
        }
        else
        {
        content = content1 != null ? content1.ArabicText : "";
        if (content.Trim() == "") content = "برجاء ادخال نص";
        }

        return Html.Raw(content);
        }
        }

        @{
        var hideClass = "";
        var hideloginbtnClass = "d-none";

        }
        @if (Session["UserId"] == null)
        {
        hideClass = "d-none";
        hideloginbtnClass = "";
        } --}}
        <!-- Page title --->
        <div id="page-title" class="text-grey background-overlay " style="background-image: url('{{ asset("
            assets/img/startup.jpg") }}');background-size: cover;background-repeat: no-repeat;">
            <div>
                <div class="container padding-tb-35px z-index-2 position-relative">
                    <div class="row">
                        <div class="col-xl-2">
                            <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 99 98">
                                <defs>
                                    <style>
                                        .cls-1 {
                                            fill: #e4a229;
                                        }

                                        .cls-2 {
                                            fill: #dec7b6;
                                        }

                                        .cls-3 {
                                            fill: #feece1;
                                        }

                                        .cls-4 {
                                            fill: #eed8c9;
                                        }

                                        .cls-5 {
                                            fill: #1f1c1d;
                                        }
                                    </style>
                                </defs>
                                <title>icon-startup</title>
                                <path class="cls-1"
                                    d="M51,9.86a32.21,32.21,0,0,1,8.32,9.53H42.61A32.2,32.2,0,0,1,51,9.86Z" />
                                <path class="cls-1"
                                    d="M68.09,58.56a14.94,14.94,0,0,1-2.47,9.63L65,63.92a4.23,4.23,0,0,0-4.2-3.63H59.59l3.73-11.62a15.13,15.13,0,0,1,4.77,9.89Z" />
                                <path class="cls-1"
                                    d="M33.08,58.56a15.16,15.16,0,0,1,4.8-9.89l3.73,11.62H40.34a4.19,4.19,0,0,0-4.16,3.63l-.64,4.27a15.37,15.37,0,0,1-2.46-9.63Z" />
                                <path class="cls-2"
                                    d="M43.87,77.44a9.86,9.86,0,0,0-9.72,2.37,11.44,11.44,0,0,0-8.63-4,12.18,12.18,0,0,0-3,.43A14,14,0,0,0,8.6,64.52H7.2v2.8H8.6A11.24,11.24,0,0,1,19.79,77.41a11.15,11.15,0,0,0-3.46,3.17A14.16,14.16,0,0,0,7.2,77.21V80A11.34,11.34,0,0,1,18.49,91.3h2.8a13.93,13.93,0,0,0-3-8.63,9.08,9.08,0,0,1,3.53-3.23h0a8.68,8.68,0,0,1,3.63-.83,8.49,8.49,0,0,1,6.89,3.56,10.47,10.47,0,0,0-1.23,4.9H34A7.59,7.59,0,0,1,35.18,83h0l.07-.07a7,7,0,0,1,8.66-2.5v3.7h2.8V72.85h-2.8Z" />
                                <path class="cls-2"
                                    d="M90.4,67.32h1.4v-2.8H90.4A14,14,0,0,0,76.51,76.21a12,12,0,0,0-3-.43,11.44,11.44,0,0,0-8.63,4,9.86,9.86,0,0,0-9.72-2.37V72.85h-2.8V84.14h2.8v-3.7a7,7,0,0,1,8.66,2.5l.07.07h0A7.59,7.59,0,0,1,65,87.07h2.8a10.47,10.47,0,0,0-1.23-4.9,8.42,8.42,0,0,1,10.52-2.73,0,0,0,0,1,0,0,8.5,8.5,0,0,1,3.53,3.19,13.93,13.93,0,0,0-3,8.63h2.8A11.34,11.34,0,0,1,91.8,80v-2.8a14.16,14.16,0,0,0-9.13,3.37,11.15,11.15,0,0,0-3.46-3.17A11.24,11.24,0,0,1,90.4,67.32Z" />
                                <rect class="cls-3" x="22.72" y="81.44" width="2.8" height="2.8" />
                                <rect class="cls-4" x="7.2" y="58.86" width="2.83" height="2.83" />
                                <rect class="cls-3" x="86.17" y="71.55" width="2.8" height="2.83" />
                                <rect class="cls-4" x="74.88" y="65.92" width="2.83" height="2.83" />
                                <rect class="cls-3" x="59.36" y="88.47" width="2.83" height="2.83" />
                                <rect class="cls-4" x="88.97" y="56.06" width="2.83" height="2.8" />
                                <path class="cls-5"
                                    d="M49.5,29.25a5.65,5.65,0,1,1-5.63,5.66,5.63,5.63,0,0,1,5.63-5.66Zm0,14.12A8.46,8.46,0,1,0,41,34.91a8.48,8.48,0,0,0,8.46,8.46Z" />
                                <path class="cls-5"
                                    d="M18.49,91.3h2.8a13.93,13.93,0,0,0-3-8.63,9.08,9.08,0,0,1,3.53-3.23h0a8.68,8.68,0,0,1,3.63-.83,8.49,8.49,0,0,1,6.89,3.56,10.47,10.47,0,0,0-1.23,4.9H34A7.59,7.59,0,0,1,35.18,83h0l.07-.07a7,7,0,0,1,8.66-2.5v3.7h2.8V72.85h-2.8v4.59a9.8,9.8,0,0,0-9.72,2.4,11.37,11.37,0,0,0-8.63-4.06,12.18,12.18,0,0,0-3,.43A14,14,0,0,0,8.6,64.52H7.2v2.8H8.6A11.24,11.24,0,0,1,19.79,77.41a11.15,11.15,0,0,0-3.46,3.17A14.16,14.16,0,0,0,7.2,77.21V80A11.34,11.34,0,0,1,18.49,91.3Z" />
                                <path class="cls-5"
                                    d="M76.51,76.21a12,12,0,0,0-3-.43,11.44,11.44,0,0,0-8.63,4,9.86,9.86,0,0,0-9.72-2.37V72.85h-2.8V84.14h2.8v-3.7a7,7,0,0,1,8.66,2.5l.07.07h0A7.59,7.59,0,0,1,65,87.07h2.8a10.47,10.47,0,0,0-1.23-4.9,8.42,8.42,0,0,1,10.52-2.73,0,0,0,0,1,0,0,8.5,8.5,0,0,1,3.53,3.19,13.93,13.93,0,0,0-3,8.63h2.8A11.34,11.34,0,0,1,91.8,80v-2.8a14.16,14.16,0,0,0-9.13,3.37,11.15,11.15,0,0,0-3.46-3.17A11.24,11.24,0,0,1,90.4,67.32h1.4v-2.8H90.4A14,14,0,0,0,76.51,76.21Z" />
                                <rect class="cls-5" x="22.72" y="81.44" width="2.8" height="2.8" />
                                <rect class="cls-5" x="7.2" y="58.86" width="2.83" height="2.83" />
                                <rect class="cls-5" x="86.17" y="71.55" width="2.8" height="2.83" />
                                <rect class="cls-5" x="74.88" y="65.92" width="2.83" height="2.83" />
                                <rect class="cls-5" x="59.36" y="88.47" width="2.83" height="2.83" />
                                <rect class="cls-5" x="88.97" y="56.06" width="2.83" height="2.8" />
                                <path class="cls-5"
                                    d="M32,58.56a15.3,15.3,0,0,1,4.8-9.89l3.73,11.62H39.24a4.19,4.19,0,0,0-4.16,3.63l-.64,4.27A15.37,15.37,0,0,1,32,58.56Zm7.76-36.34H59.26a31.63,31.63,0,0,1,1.23,22.65l-.33,1h0L55.53,60.29H43.47L38.84,45.84h0l-.3-1a31.47,31.47,0,0,1,1.2-22.65ZM49.5,9.86a31.68,31.68,0,0,1,8.33,9.53H41.17A31.68,31.68,0,0,1,49.5,9.86ZM67,58.56a15.37,15.37,0,0,1-2.46,9.63l-.64-4.27a4.19,4.19,0,0,0-4.16-3.63H58.49l3.73-11.62A15.3,15.3,0,0,1,67,58.56ZM53.43,67.32H45.57l.87-4.23h6.12ZM35.41,73a1.61,1.61,0,0,0,.43-.07,1.5,1.5,0,0,0,1-1.16l1.07-7.43a1.39,1.39,0,0,1,1.36-1.23h4.3l-1.07,5.36a1.43,1.43,0,0,0,1.1,1.67,1,1,0,0,0,.3,0H55.13a1.41,1.41,0,0,0,1.43-1.4c0-.1,0-.2,0-.3l-1.07-5.36h4.3a1.36,1.36,0,0,1,1.36,1.23l1.07,7.43a1.5,1.5,0,0,0,1,1.16,1.61,1.61,0,0,0,.43.07,1.42,1.42,0,0,0,1-.43,18,18,0,0,0,0-25.45c-.46-.46-1-.9-1.46-1.33v0A34.48,34.48,0,0,0,50.33,7a1.41,1.41,0,0,0-1.66,0A34.48,34.48,0,0,0,35.84,45.74v0a18,18,0,0,0-2.76,25.31,18.94,18.94,0,0,0,1.33,1.47,1.42,1.42,0,0,0,1,.43Z" />
                                <rect class="cls-5" x="42.44" y="47.6" width="2.83" height="2.8" />
                                <rect class="cls-5" x="48.1" y="47.6" width="2.8" height="2.8" />
                                <rect class="cls-5" x="53.73" y="47.6" width="2.83" height="2.8" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="font-weight-700 text-capitalize page-title-tech cms pb-5" data-contentId="68">
                        {!! app()->getLocale()=='ar'? $contents->where('d_id', 68)->first()->ArabicText:
                        $contents->where('d_id', 68)->first()->EnglishText !!}</h3>
                </div>

            </div>

        </div>
        <!-- Page title --->

        <section class="padding-tb-20px background-white">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 text-center" dir="@dir">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="clearfix margin-bottom-30px">
                                    <a href="{{ app()->getLocale()=='ar'?asset('Areas/plansData/StartupArabic.pdf'):asset('Areas/plansData/Startup.pdf') }}"
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
                                    <h4><a href="{{ app()->getLocale()=='ar'?asset('Areas/plansData/StartupArabic.pdf'):asset('Areas/plansData/Startup.pdf') }}"
                                            download>Resources.General.GuidePDF</a></h4>
                                    <p class="cms" data-contentId="69">{!! app()->getLocale()=='ar'?
                                        $contents->where('d_id', 69)->first()->ArabicText: $contents->where('d_id',
                                        69)->first()->EnglishText !!})</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8 wow fadeInUp">
                        <video height="360" controls style="border:1px solid black">
                            <source
                                src="{{ app()->getLocale()=='ar'?asset('Areas/plansData/StartupArabic.mp4'): asset('Areas/plansData/Startup.mp4') }}"
                                type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                </div>
            </div>
        </section>


        <section>
            <div id="sectioninner" class="section">
                <div class="sectionInner">
                    <div class="container">
                        <div class="text-center margin-bottom-35px fadeInUp">
                            <h1 class="text-center cms" data-contentId="70">{!! app()->getLocale()=='ar'?
                                $contents->where('d_id', 70)->first()->ArabicText: $contents->where('d_id',
                                70)->first()->EnglishText !!}</h1>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-10 sm-mb-30px wow fadeInUp">
                                <div class="blog-item thum-hover background-white hvr-float hvr-sh2 ">
                                    <div class="position-relative background-beig">
                                        <div class="date z-index-101 padding-10px"></div>
                                        <div class="item-thumbnail">
                                            <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 850 515">
                                                <defs>
                                                    <style>
                                                        .cls-1 {
                                                            fill: #e4a32b;
                                                        }

                                                        .cls-2 {
                                                            fill: #fff;
                                                        }
                                                    </style>
                                                </defs>
                                                <title>icon-warmup</title>
                                                <rect class="cls-1" width="850" height="515" />
                                                <path class="cls-2"
                                                    d="M552.47,110.51H310.17a25.93,25.93,0,0,0-25.84,25.84V321.23a25.94,25.94,0,0,0,25.84,25.84h82l-4,19.46a26,26,0,0,1-25.36,20.73H339.52a8.62,8.62,0,0,0,0,17.23h183.6a8.62,8.62,0,0,0,0-17.23H499.67a25.78,25.78,0,0,1-25.2-20.73l-4-19.46h82a25.94,25.94,0,0,0,25.84-25.84V136.35a25.93,25.93,0,0,0-25.84-25.84ZM457.56,369.88a43,43,0,0,0,7.82,17.38H397.26a43,43,0,0,0,7.82-17.38l4.63-22.81h43.22Zm103.52-48.65a8.57,8.57,0,0,1-8.61,8.61H310.17a8.57,8.57,0,0,1-8.61-8.61V136.35a8.57,8.57,0,0,1,8.61-8.61h242.3a8.57,8.57,0,0,1,8.61,8.61Z" />
                                                <path class="cls-2"
                                                    d="M391.2,254.07h80.24a8.58,8.58,0,0,0,8.61-8.61v-5.75a48.91,48.91,0,0,0-24.88-42.59,31.5,31.5,0,1,0-47.7,0,48.91,48.91,0,0,0-24.88,42.59v5.75a8.58,8.58,0,0,0,8.61,8.61Zm25.68-77.52a14.36,14.36,0,1,1,14.36,14.35,14.4,14.4,0,0,1-14.36-14.35Zm14.36,31.58a31.71,31.71,0,0,1,31.58,28.71h-63a31.56,31.56,0,0,1,31.42-28.71Z" />
                                                <path class="cls-2"
                                                    d="M534.6,283.9H376.85V281a8.69,8.69,0,0,0-8.62-8.62,8.58,8.58,0,0,0-8.61,8.62v2.87H328a8.62,8.62,0,1,0,0,17.23h31.58V304a8.58,8.58,0,0,0,8.61,8.61,8.68,8.68,0,0,0,8.62-8.61v-2.87H534.6a8.62,8.62,0,1,0,0-17.23Z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="blog-item padding-lr-30px padding-top-60px text-center">
                                        {{-- @if (Session["CMS"] != null && (bool)Session["CMS"] == true)
                                        {
                                        <a href="javascript:void(0);" class="text-extra-large d-block  cms"
                                            data-contentId="116">@GetContent(116)</a>
                                        }
                                        else
                                        { --}}
                                        <a href="#" class="text-extra-large d-block"> {!! app()->getLocale()=='ar'?
                                            $contents->where('d_id', 116)->first()->ArabicText: $contents->where('d_id',
                                            116)->first()->EnglishText !!}</a>
                                        {{-- } --}}

                                        <div class="text-center padding-lr-30px padding-bottom-63px cms"
                                            data-contentId="117">{!! app()->getLocale()=='ar'? $contents->where('d_id',
                                            117)->first()->ArabicText: $contents->where('d_id',
                                            117)->first()->EnglishText !!}</div>
                                        <div class="padding-bottom-22px">
                                            <a href="../TrainingHome#learnOnline"
                                                class="btn btn-sm background-main-color text-white padding-lr-15px border-0 opacity-8 ">{{
                                                __('Subscribe') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-10 sm-mb-30px wow fadeInUp">
                                <div class="blog-item thum-hover background-white hvr-float hvr-sh2 ">
                                    <div class="position-relative background-beig">
                                        <div class="date z-index-101 padding-10px"></div>
                                        <div class="item-thumbnail">
                                            <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 850 515">
                                                <defs>
                                                    <style>
                                                        .cls-1 {
                                                            fill: #e4a32b;
                                                        }

                                                        .cls-2 {
                                                            fill: #fff;
                                                        }
                                                    </style>
                                                </defs>
                                                <title>icon-resources</title>
                                                <rect class="cls-1" width="850" height="515" />
                                                <path class="cls-2"
                                                    d="M353.93,331.12c7.66,7.65,15.16,15.15,22.65,22.49V331.12ZM546.62,386c0-8.78.16-17.23,0-25.68a6.75,6.75,0,0,0-7-6.38H480.27c-4.15,0-6.86,2.87-7,7-.16,2.72,0,5.43,0,8.14V386ZM473.25,280.23A36.69,36.69,0,1,0,510.1,243.7a36.76,36.76,0,0,0-36.85,36.53ZM303.53,129V349.14h41.63c-6.54-6.54-12.6-12.92-19-19a13.91,13.91,0,0,1-4.63-10.85c.16-52.16,0-104.32,0-156.48,0-10.21,5.42-15.63,15.63-15.63H473.09V129Zm36.68,36.69V312.61h40c9.09,0,14.84,5.74,14.84,14.84v40h59.34c.47-4.46.31-8.93,1.27-13.08a25.09,25.09,0,0,1,24.09-18.82c6.7-.16,13.24,0,19.94,0-29.83-6.7-45.46-31.26-45.3-55.19a53.39,53.39,0,0,1,11.64-33.82c11.17-14,26-20.73,43.71-21.37V165.7Zm217.9,238.79H461.76c-8.93-3.51-6.7-11.32-7-18.34h-3.35c-21.21,0-42.43-.16-63.64,0A12.46,12.46,0,0,1,378,382c-4-4.15-8.3-8.45-12.6-12.44a6.52,6.52,0,0,0-4.15-1.76c-20.26-.16-40.52-.16-60.77-.16a38.72,38.72,0,0,1-4.31-.16c-7-1.43-11.33-6.86-11.33-14.83V125.18a26,26,0,0,1,.32-3.66c1.28-5.91,5.27-9.1,10.53-11H480.59c.31.16.47.32.79.48,7,2.55,10.21,7,10.21,14.51V147a3.43,3.43,0,0,0,1,.16h20.58c9.57,0,15.15,5.58,15.15,15.31v63c0,2.23.64,3.19,2.71,4.15,38.28,16,45.94,66.83,14,93.47a57.69,57.69,0,0,1-25.52,12.28c6.54.16,13.08.16,19.46.16,15.15,0,26,10.85,26,26,.16,10.37-.16,20.74.16,30.95.16,5.74-1.76,9.73-7,12Z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="blog-item padding-lr-30px padding-top-60px text-center">
                                        {{-- @if (Session["CMS"] != null && (bool)Session["CMS"] == true)
                                        {
                                        <a href="javascript:void(0);" class="text-extra-large d-block cms"
                                            data-contentId="118">@GetContent(118)</a>
                                        }
                                        else
                                        { --}}
                                        <a href="{{-- @Url.Action(" Materials","Plans", new { plan="Startup" }) --}}"
                                            class="text-extra-large d-block ">{!! app()->getLocale()=='ar'?
                                            $contents->where('d_id', 118)->first()->ArabicText: $contents->where('d_id',
                                            118)->first()->EnglishText !!}</a>
                                        {{-- } --}}
                                        <div class="text-center padding-lr-30px padding-bottom-10px cms"
                                            data-contentId="119">{!! app()->getLocale()=='ar'? $contents->where('d_id',
                                            119)->first()->ArabicText: $contents->where('d_id',
                                            119)->first()->EnglishText !!}</div>

                                        <div>

                                            {{-- @{
                                            int counter = 0;
                                            } --}}
                                            <table class="table border-0 align_table" dir="@dir">
                                                <tbody class="">
                                                    @foreach ($DocFiles as $Files)

                                                    <tr class="noborder">


                                                        <td class="text-center"><i class="fa-solid fa-book-open"></i>
                                                        </td>
                                                        <td class="text-center">

                                                            <h5 class="h5">{{app()->getLocale()=='ar'? $Files->NameAr
                                                                : $Files->Name }}</h5>

                                                        </td>

                                                    </tr>
                                                    @endforeach
                                                    <tr>
                                                        <td colspan="2" class="text-center">
                                                            {{-- @if (ViewBag.isHaveStartupPlan)
                                                            {
                                                            <a href="@Url.Action(" Materials", "Plans" , new {
                                                                plan="Startup" })"
                                                                class="btn btn-sm background-main-color text-white padding-lr-15px border-0 opacity-8">
                                                                @Resources.General.Around (@Files.Count)
                                                                @Resources.General.MoreToolsAvailable
                                                            </a>
                                                            }
                                                            else
                                                            { --}}
                                                            <span class="h6 text-danger col-12">{{ __('Around') }}
                                                                ({{ $DocFilesCount }})
                                                                {{ __('More Tools Available') }}</span>
                                                            <a href="#builder_s"
                                                                class="btn btn-sm background-main-color text-white padding-lr-15px border-0 opacity-8 col-12 @hideClass">
                                                                {{ __('Subscribe') }}
                                                            </a>
                                                            {{-- } --}}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </div>



                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-10 sm-mb-30px wow fadeInUp">
                                <div class="blog-item thum-hover background-white hvr-float hvr-sh2 ">
                                    <div class="position-relative background-beig">
                                        <div class="date z-index-101 padding-10px"></div>
                                        <div class="item-thumbnail">
                                            <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 850 515">
                                                <defs>
                                                    <style>
                                                        .cls-1 {
                                                            fill: #e4a32b;
                                                        }

                                                        .cls-2 {
                                                            fill: #fff;
                                                        }
                                                    </style>
                                                </defs>
                                                <title>icon-health-check</title>
                                                <rect class="cls-1" width="850" height="515" />
                                                <path class="cls-2"
                                                    d="M485.54,156.53v-6.38A16.21,16.21,0,0,0,469.26,134H446.93a25.89,25.89,0,0,0,3.19-12.6,27.28,27.28,0,0,0-54.55-.16A26.62,26.62,0,0,0,398.76,134h-18a16.07,16.07,0,0,0-16.12,16.11v6.38h-37.8a17.43,17.43,0,0,0-17.39,17.39V403.45a17.43,17.43,0,0,0,17.39,17.39H523.18a17.43,17.43,0,0,0,17.39-17.39V173.92a17.43,17.43,0,0,0-17.39-17.39Zm-141,250.27a18.38,18.38,0,0,1-18.35-18.5V312.21h47.54a12.26,12.26,0,0,0,9.89-5.74l3.51-5.9,10.2,49.77c2.88,13.55,17.87,8.29,19.31-.32l12.28-79.6,10.84,76.41c1.44,8.61,13.72,15.95,18.83,2.23l14-36.85h51.21V388.3a18.38,18.38,0,0,1-18.35,18.5Zm62.05-285.36a16.27,16.27,0,0,1,32.54-.16c0,5.26-2.4,10.21-6.22,12.76H412.64c-3.67-2.55-6.06-7.5-6.06-12.6Zm-80.4,70a17.43,17.43,0,0,1,17.39-17.39h21.05A11.24,11.24,0,0,0,376,185.24h98.1a11.24,11.24,0,0,0,11.33-11.17h21.05a17.43,17.43,0,0,1,17.39,17.39V295.94H468a11.75,11.75,0,0,0-10.85,7.5l-1.75,4.63-14.84-85c-.95-5.59-5.74-9.1-11.48-9.1h0c-5.59,0-10.53,3.51-11.49,9.1l-12.92,71.46-4-19.3a11.77,11.77,0,0,0-9.25-9.1,11.91,11.91,0,0,0-12,5.27L364,295.94H326.18Z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="blog-item padding-lr-30px padding-top-60px text-center">
                                        {{-- @if (Session["CMS"] != null && (bool)Session["CMS"] == true)
                                        {
                                        <a href="javascript:void(0);" class="text-extra-large d-block cms"
                                            data-contentId="120">GetContent(120)</a>
                                        }
                                        else
                                        { --}}
                                        <a href="#" class="text-extra-large d-block ">{!! app()->getLocale()=='ar'?
                                            $contents->where('d_id', 120)->first()->ArabicText: $contents->where('d_id',
                                            120)->first()->EnglishText !!}</a>
                                        {{-- } --}}
                                        <div class="text-center padding-lr-30px padding-bottom-63px cms"
                                            data-contentId="121">{!! app()->getLocale()=='ar'? $contents->where('d_id',
                                            121)->first()->ArabicText: $contents->where('d_id',
                                            121)->first()->EnglishText !!}</div>
                                        <div class="padding-bottom-22px">
                                            {{-- @if (ViewBag.isHaveStartupPlan)
                                            { --}}
                                            {{-- <a href="@Url.Action(" Intro", "Survey" )"
                                                class="btn btn-sm background-main-color text-white padding-lr-15px border-0 opacity-8">{{
                                                __('Start') }}</a>
                                            <a href="@Url.Action(" History", "Survey" )"
                                                class="btn btn-sm background-main-color text-white padding-lr-15px border-0 opacity-8">{{
                                                __('PreviousChecks') }}</a> --}}
                                            {{-- }
                                            else
                                            { --}}
                                            <a href="#builder_s"
                                                class="btn btn-sm background-main-color text-white padding-lr-15px border-0 opacity-8 @hideClass">{{
                                                __('Subscribe') }}</a>
                                            {{-- } --}}

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row text-center">
                            <div class="padding-bottom-22px col-lg-12">
                                {{--
                                <a href="../Login/Index?r=@Request.Url.ToString()"
                                    class="btn btn-sm background-main-color text-white padding-lr-15px border-0 opacity-8 @hideloginbtnClass">@Resources.General.Login</a>
                                --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        {{-- @if (Session["UserId"] != null)
        {
        if (!ViewBag.isHaveStartupPlan || ((User)Session["User"]).IsAdmin || ViewBag.isFreePlan)
        { --}}
        {{-- var showbtn = "d-none";
        var showCost = "";
        if (ViewBag.isFreePlan)
        {
        showbtn = "";
        showCost = "d-none";
        } --}}
        <section>
            <div id="builder_s" class="section">
                <div class="sectionInner">
                    <div class="container">
                        <div class="row @showbtn" id="btnShowUpGrade">
                            <div class="col-lg-12 col-md-12 sm-mb-30px wow fadeInUp">
                                <div class="blog-item thum-hover hvr-float hvr-sh2">
                                    {{-- <button id="btnUpgrade"
                                        class="btn background-main-color text-white">@Resources.General.Upgrade</button>
                                    --}}
                                </div>
                            </div>
                        </div>
                        <div id="divCost" class="row @showCost">
                            <div class="col-lg-6 col-md-6 sm-mb-30px wow fadeInUp"
                                style="visibility: visible; animation-name: fadeInUp;">
                                <div class="blog-item thum-hover bg-gray hvr-float hvr-sh2 ">
                                    <div class="position-relative background-beig">
                                        <div class="item-thumbnail" style="font-size: 5rem;">{{ $MonthlyPriceDisp }}
                                            <span style="font-size: 2.5rem; margin-top: -38px; text-align: center;">USD
                                                $</span>
                                        </div>
                                    </div>
                                    <div class="blog-item padding-lr-30px padding-top-60px text-center">
                                        <h1 class="padding-bottom-20px">{{ __('Per Month') }}</h1>
                                        <div class="form-group ">
                                            <div class="form-check padding-bottom-20px">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="StrUPMonthlyCheckbox"
                                                        onchange="agree('StrUPMonthlyCheckbox','MonthlyStartUpdiv')">
                                                    {{ __('I Agree With ') }} <a href="#" data-bs-toggle="modal"
                                                        data-bs-target="#agreeMonthModal">{{ __('Terms & Conditions')}}</a>
                                                </label>
                                            </div>

                                        </div>
                                        <div id="MonthlyStartUpdiv" style="display:none;">

                                            <div class="row justify-content-center pb-4 text-start"
                                                dir="{{ app()->getLocale()=='ar'? 'rtl':'ltr' }}">
                                                <div class="col-5">
                                                    <label for="MonthlySearchCouponCodeStartUp" class="form-label">{{
                                                        __('Coupon Code') }}</label>
                                                    <input type="text" class="form-control"
                                                        id="MonthlySearchCouponCodeStartUp"
                                                        aria-describedby="MonthlySearchCouponCodeStartUpMSG"
                                                        onchange="getCouponDiscount('MonthlySearchCouponCodeStartUp','MonthlyStartUpSubLink','2',{{ $MonthlyPriceDisp }})"
                                                        required>
                                                    <div id="MonthlySearchCouponCodeStartUpMSG"
                                                        class="invalid-feedback d-none">

                                                    </div>
                                                </div>
                                            </div>
                                            <div id="MonthlyStartUpDiscountDiv"
                                                class="row padding-bottom-22px col-md-12 d-none" dir="@dir">
                                                <div class="row">
                                                    <label class="col-4">{{ __('Plan Price Before Dicount') }}</label>
                                                    <label id="MonthlystartupPlanPriceCD"
                                                        class="font-weight-700 col-3">55
                                                        ff <span class="pr-2 pl-2">{{ __('OMR') }}</span>
                                                    </label>

                                                </div>
                                                <div class="row">
                                                    <label class="col-4">{{ __('Coupon Discount Rate') }}</label>
                                                    <label id="MonthlystartupCouponDiscRateCD"
                                                        class="font-weight-700 col-3">55 </label>
                                                </div>
                                                <div class="row">
                                                    <label class="col-4">{{ __('Plan Price After Discount') }}</label>
                                                    <label id="MonthlystartupPlanPriceAftDisCD"
                                                        class="font-weight-700 col-3">55
                                                    </label>
                                                </div>
                                                <div class="row">
                                                    <label class="col-4">{{ __('Plan Price Save') }}</label>
                                                    <label id="MonthlystartupPlanPriceSaveCD"
                                                        class="font-weight-700 col-3"><del> 55
                                                        </del></label>

                                                </div>
                                            </div>
                                            <div class="padding-bottom-22px">
                                                {{-- @if (!ViewBag.isHaveStartupPlan)
                                                { --}}
                                                <a id="MonthlyStartUpSubLink"
                                                    href="{{ route('Plans.checkout',[$plan,$month,$MonthlyPriceDisp]) }}"
                                                    class="btn btn-sm background-main-color text-white padding-lr-15px border-0 opacity-8">
                                                    {{ __('Subscribe') }}
                                                </a>



                                                {{-- } --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 sm-mb-30px wow fadeInUp"
                                style="visibility: visible; animation-name: fadeInUp;">
                                <div class="blog-item thum-hover bg-gray hvr-float hvr-sh2 ">
                                    <div class="position-relative background-beig">
                                        <div class="item-thumbnail" style="font-size: 5rem;">{{ $AnnualPriceDisp }}
                                            <span style="font-size: 2.5rem; margin-top: -38px; text-align: center;">USD
                                                $</span>
                                        </div>
                                    </div>
                                    <div class="blog-item padding-lr-30px padding-top-60px text-center">
                                        <h1 class="padding-bottom-20px">{{ __('Per Year') }}</h1>
                                        <div class="form-group ">
                                            <div class="form-check padding-bottom-20px">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" id="StrUPannualCheckbox"
                                                        onchange="agree('StrUPannualCheckbox','AnnualStartUpdiv')"
                                                        type="checkbox"> {{ __('I Agree With') }} <a href="#"
                                                        data-bs-toggle="modal" data-bs-target="#agreeYearModal">{{
                                                        __('Terms & Conditions') }}</a>
                                                </label>
                                            </div>
                                        </div>
                                        <div id="AnnualStartUpdiv" style="display:none;">
                                            <div class="row justify-content-center pb-4 text-start" dir="@dir">
                                                <div class="col-5">
                                                    <label for="SearchCouponCodeStartUp" class="form-label">{{
                                                        __('Coupon Code') }}</label>
                                                    <input type="text" class="form-control" id="SearchCouponCodeStartUp"
                                                        aria-describedby="SearchCouponCodeStartUpMSG"
                                                        onchange="getCouponDiscount('SearchCouponCodeStartUp','StartUpSubLink','2',{{ $AnnualPriceDisp }})"
                                                        required>
                                                    <div id="SearchCouponCodeStartUpMSG"
                                                        class="invalid-feedback d-none">

                                                    </div>
                                                </div>
                                            </div>
                                            <div id="annualStartUpDiscountDiv"
                                                class="row @pullAlign padding-bottom-22px col-md-12 d-none" dir="@dir">
                                                <div class="row">
                                                    <label class="col-4">{{ __('Plan Price Before Dicount') }}</label>
                                                    <label id="startupPlanPriceCD" class="font-weight-700 col-3">55
                                                    </label>
                                                </div>
                                                <div class="row">
                                                    <label class="col-4">{{ __('Coupon Dicount Rate') }}</label>
                                                    <label id="startupCouponDiscRateCD" class="font-weight-700 col-3">55
                                                    </label>
                                                </div>
                                                <div class="row">
                                                    <label class="col-4">{{ __('Plan Price After Dicount') }}</label>
                                                    <label id="startupPlanPriceAftDisCD"
                                                        class="font-weight-700 col-3">55
                                                    </label>
                                                </div>
                                                <div class="row">
                                                    <label class="col-4">{{ __('Plan Price Save') }}</label>
                                                    <label id="startupPlanPriceSaveCD"
                                                        class="font-weight-700 col-3"><del> 55
                                                        </del></label>

                                                </div>
                                            </div>

                                            <div class="padding-bottom-22px">


                                                {{-- @if (!ViewBag.isHaveStartupPlan)
                                                { --}}
                                                <a id="StartUpSubLink"
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

        {{-- }
        } --}}
        <div class="modal fade" id="agreeMonthModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 id="exampleModalLabel2" class="modal-title" data-contentId="">{!!
                            App()->getLocale()=='ar'?$m_terms['ArabicTitle']:$m_terms['EnglishTitle'] !!}</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" data-contentId="">{!!
                        App()->getLocale()=='ar'?$m_terms['ArabicText']:$m_terms['EnglishText'] !!}</div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="agreeYearModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 id="exampleModalLabel1" class="modal-title" data-contentId="">{!!
                            App()->getLocale()=='ar'?$a_terms['ArabicTitle']:$a_terms['EnglishTitle'] !!}</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" data-contentId="">{!!
                        App()->getLocale()=='ar'?$a_terms['ArabicText']:$a_terms['EnglishText'] !!}</div>
                </div>
            </div>
        </div>
        <script>
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
