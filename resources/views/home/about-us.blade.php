@extends('layouts.main')
@section('content')
<!-- Page title --->
<div id="page-title" class="text-grey background-overlay " style="background-image: url('{{ asset("assets/img/aboutus.jpg") }}');">
    <div>
        <div class="container padding-tb-185px z-index-2 position-relative">
            <h1 class="font-weight-700 text-capitalize page-title-about cms" data-contentId="104">{!! app()->getLocale()=='ar'? $contents->where('d_id', 104)->first()->ArabicText: $contents->where('d_id', 104)->first()->EnglishText !!})</h1>
            <div class="row ">
                <div class="col-lg-7">
                    <h1 class="font-weight-700 pageSubTitle-about padding-tb-15px cms" data-contentId="96">{!! app()->getLocale()=='ar'? $contents->where('d_id', 96)->first()->ArabicText: $contents->where('d_id', 96)->first()->EnglishText !!}</h1>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page title --->


<section class="padding-tb-80px background-white">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="clearfix margin-bottom-30px">
                            <h4 class="cms" data-contentId="97">{!! app()->getLocale()=='ar'? $contents->where('d_id', 97)->first()->ArabicText: $contents->where('d_id', 97)->first()->EnglishText !!}</h4>
                            <p class="cms" data-contentId="98">{!! app()->getLocale()=='ar'? $contents->where('d_id', 98)->first()->ArabicText: $contents->where('d_id', 98)->first()->EnglishText !!}</p>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="clearfix margin-bottom-30px">
                            <h1></h1>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="clearfix margin-bottom-30px">
                            <h4 class="cms" data-contentId="99">{!! app()->getLocale()=='ar'? $contents->where('d_id', 99)->first()->ArabicText: $contents->where('d_id', 99)->first()->EnglishText !!}</h4>
                            <p class="cms" data-contentId="100">{!! app()->getLocale()=='ar'? $contents->where('d_id', 100)->first()->ArabicText: $contents->where('d_id', 100)->first()->EnglishText !!}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 background-overlay wow fadeInUp" style="background-image: url('{{ asset("assets/img/letstalk.png") }}');background-size: contain; background-repeat: no-repeat;background-position: center;">
            </div>
        </div>
    </div>
</section>


<section>
    <div id="page-title" class="text-grey background-overlay " style="background-image: url('{{ asset("assets/img/founder-bg-img.jpg") }}');">
        <div>
            <div class="container padding-tb-185px z-index-2 position-relative">
                <h4 class="font-weight-700 pageSub-founder cms" data-contentId="101">{!! app()->getLocale()=='ar'? $contents->where('d_id', 101)->first()->ArabicText: $contents->where('d_id', 101)->first()->EnglishText !!}</h4>
                <div class="row">
                    <div class="col-lg-7">
                        <h3 class="font-weight-700 pageSubTitle-founder cms" data-contentId="102">{!! app()->getLocale()=='ar'? $contents->where('d_id', 102)->first()->ArabicText: $contents->where('d_id', 102)->first()->EnglishText !!}</h3>
                        <a href="https://www.linkedin.com/in/nabahan-al-kharusi-92045918" target="_blank" class="btn btn-sm background-main-color text-white border-0 opacity-8">{{ __('Nabahan On') }} <i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div id="" class="text-grey background-overlay " >
        <div>
            <div class="container padding-tb-185px z-index-2 position-relative">
                <h4 class="font-weight-700 pageSub-founder cms"></h4>
                <div class="row">
                    <div class="col-lg-12 text-center">

                        <a href="/profile/Profile.html" target="_blank" class="btn btn-sm background-main-color text-white border-0 opacity-8">Resources.General.CompanyProfile</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="padding-tb-80px background-white">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center cms" data-contentId="103">{!! app()->getLocale()=='ar'? $contents->where('d_id', 103)->first()->ArabicText: $contents->where('d_id', 103)->first()->EnglishText !!}</div>
        </div>
    </div>
</section>
@endsection
