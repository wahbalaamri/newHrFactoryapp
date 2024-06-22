@extends('layouts.main')

@section('content')
<div id="page-title" class="text-grey background-overlay "
    style="background-image: url('{{ asset('assets/img/aboutus.jpg') }}');" dir="@dir">
    <div>
        <div class="container padding-tb-20px z-index-2 position-relative">
            <h1 class="font-weight-700 text-capitalize page-title-about cms" data-contentId="63">{!!
                app()->getLocale()=='ar'? $contents->where('d_id', 63)->first()->ArabicText: $contents->where('d_id',
                63)->first()->EnglishText !!}</h1>
            <div class="row ">
                <div class="col-lg-7">
                    <h1 class="font-weight-700 pageSubTitle-about padding-tb-15px cms w-75" data-contentId="64">{!!
                        app()->getLocale()=='ar'? $contents->where('d_id', 64)->first()->ArabicText:
                        $contents->where('d_id', 64)->first()->EnglishText !!}</h1>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="background-light-grey padding-tb-100px text-center" dir="@dir">
    <div class="container">
        <div class="row justify-content-md-center" id="LoginArea">

            <div class="col-lg-4">
                <div class="padding-30px background-white border-1 border-grey-1 rounded-top box-shadow">

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group @pullText" style="font-family: cairo">
                            <label for="email" class="col-12 col-form-label text-start">{{ __('Email
                                Address') }}</label>

                            <div class="col-12">
                                <input id="email" type="email"
                                    class="form-control rounded-1 @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group @pullText" style="font-family: cairo">
                            <label for="password" class="col-12 col-form-label text-start">{{ __('Password')
                                }}</label>

                            <div class="col-12">
                                <input id="password" type="password"
                                    class="form-control rounded-0 @error('password') is-invalid @enderror"
                                    name="password" required autocomplete="current-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group text-start mt-2">
                            <div class="form-check font-weight-700">
                                <label class="form-check-label">
                                    <input class="form-check-input @checkInput" type="checkbox" name="remember"
                                        id="remember" {{old('remember') ? 'checked' : '' }}>
                                    <span class="@Checklable">{{ __('Remember Me') }}</span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block rounded-0 background-main-color">
                                {{ __('Login') }}
                            </button>
                        </div>
                    </form>

                </div>

                <div class="padding-30px background-white border-1 border-grey-1 pb-0 rounded-bottom box-shadow">
                    <div class="form-group" dir="@dir">
                        <div class="margin-bottom-20px margin-top-20px">
                            <a href="{{ route('register') }}"
                                class="btn btn-primary btn-block rounded-0 background-main-color"> <span
                                    class="text-uppercase @pullText">{{ __('sing up') }}</span><i
                                    class="fa fa-user margin-right-10px @pullIcon" aria-hidden="true"></i></a>

                        </div>

                        <div class="border-grey-2 text-center">
                            <a href="{{ route('password.request') }}" id="lnkForgetPassword"><i
                                    class="fa fa-lock margin-right-10px" aria-hidden="true"></i> <strong
                                    class="text-uppercase">{{ __('Recover My Password') }}</strong></a>
                        </div>

                    </div>

                </div>
            </div>


        </div>
        <!-- // row -->
    </div>
    <!-- // container -->
</section>
{{-- ==== --}}
</div>
</div>
</div>
@endsection
