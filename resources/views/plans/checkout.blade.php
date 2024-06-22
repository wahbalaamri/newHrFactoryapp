@extends('layouts.main')
@section('content')

<div class="container mb-5 pt-1 pb-5" dir="@dir">
    <div class="panel panel-info">
        <div class="panel-heading">

            <div
                class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <div class="row">
                    <h1 class="h2 @Opalignclass"> {{ __('Payment') }}</h1>
                </div>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group ml-2 col-lg-12">

                    </div>
                </div>
            </div>

        </div>
        <div class="panel-body justify-content-center" id="CategoriesContinar" dir="@dir">
            <div class="table-responsive">
                <table class="table table-condensed table-hover w-100 @Text_Align">
                    <tbody>
                        <tr>
                            <th class="w-25">{{ __('Plan Name') }}</th>
                            <td class="text-start" colspan="3">{{ $plan }}
                            </td>
                        </tr>
                        <tr>
                            <th class="w-25">{{ __('Subscription Period') }}</th>
                            <td class="text-start" colspan="3">{{ $period }}</td>
                        </tr>
                        <tr>
                            <th class="w-25">{{ __('Subscription from') }}</th>
                            <td class="text-start">{{ $date_start}}</td>
                            <th class="w-25">{{ __('To') }}</th>
                            <td class="text-start">{{ $date_end }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('Select Currency') }}</th>
                            <td class="text-start">
                                <select id="Currencies" class="form-control">
                                    <option value="">{{ __('Select') }}</option>
                                    <optgroup label="{{ __('Arab Countries') }}">
                                        @foreach ($countries[1] as $country )
                                        <option value="{{ $country->id }}">{{ app()->getLocale()=='ar'?
                                            $country->NameAr:$country->Name }}
                                        </option>
                                        @endforeach
                                    </optgroup>
                                    <optgroup label="{{ __('Other Currencies') }}">
                                        @foreach ($countries[0] as $country )
                                        <option value="{{ $country->id }}">{{ app()->getLocale()=='ar'?
                                            $country->NameAr:$country->Name }}
                                        </option>
                                        @endforeach
                                    </optgroup>

                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th class="w-25">{{ __('Subscription Price') }}</th>
                            <td class="text-start">{{ $amount }}<span class='p-2'><i class='fa fa-dollar-sign'></i>{{ __('USD') }}</span></td>
                            <td class="text-start" id="AmountTxt"></td>
                            <td class="text-start" id="AmountVal"></td>
                        </tr>
                        <tr>
                            <td class="text-start" id="AmountTxt">{{ __('VAT') }}</td>
                            <td class="text-start" id="AmountVal">
                                {{ $vat }}<span class='p-2'><i class='fa fa-dollar-sign'></i>{{ __('USD') }}</span></td>
                            </td>
                            <td class="text-start" id="AmountTxt">{{ __('VAT Rate') }}</td>
                            <td class="text-start" id="AmountVal">{{ $vat_rate }}%</td>
                        </tr>
                        <tr>
                            <th class="w-25">{{ __('Total') }}</th>
                            <td class="text-start">{{ $total }}<span class='p-2'><i class='fa fa-dollar-sign'></i>{{ __('USD') }}</span></td>
                            <td class="text-start" id="TotalTxt"></td>
                            <td class="text-start" id="TotalVal"></td>
                        </tr>

                        <tr>
                            <td colspan="4" class="text-start">
                                <h5>{{ __('Pay with') }}</h5>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-center">

                                <a id="AnnualManualBuilderSubLink" href="{{ route('Plans.thawani') }}"
                                    class="btn btn-sm text-white padding-lr-15px border-0 opacity-8">
                                    <img src="{{ asset('assets/img/Logo-Thawani.png') }}" style="width:100%; height:100px;">
                                </a>
                            </td>
                            <td colspan="2" class="text-center">
                                {{-- <form action="~/Thawani/Create" method="post">
                                    @Html.AntiForgeryToken() --}}
                                    <a type="submit" href="" class="btn btn-sm text-white padding-lr-15px border-0 opacity-8">
                                        <img src="{{ asset('assets/img/payTabs.png') }}" style="width:200px; height:100px;">
                                        <h5 class="h6">{{ __('GeneratePayTabsPaymentLink') }}</h5>
                                    </button>
                                {{-- </form> --}}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="row" dir="ltr">
                <div class="col-6 p-3 m-2 text-center">

                </div>
                <div class="col-6 p-3 m-2">

                </div>
            </div>

            <div class="row">
                <div class="col-6 text-center">
                    <img src="https://images.all-free-download.com/images/graphicwebp/mastercard_logo_29764.webp"
                        style="width: 15%; height: 111%;">
                </div>
                <div class="col-6 text-center">
                    <img src="https://images.all-free-download.com/images/graphicwebp/visa_logo_31102.webp"
                        style="width: 15%; height: 76%;">
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {

        countryCode = "us";
        option = "<option value=''>{{ __('Select</opt') }}ion>"
        $.ajax({
            url: "https://restcountries.com/v2/alpha/" + countryCode,
            type: "get",
            success: (resp) => {
                option += "<option value='" + resp.currencies[0].code + "'>" + resp.currencies[0].name + " : " + resp.currencies[0].symbol + "</option>";
            },
            error: (errResp) => {

            }
        });
        countryCode = "@ViewBag.countryCode";

        $.ajax({
            url: "https://restcountries.com/v2/alpha/" + countryCode,
            type: "get",
            success: (resp) => {
                option += "<option value='" + resp.currencies[0].code + "'>" + resp.currencies[0].name + " : " + resp.currencies[0].symbol + "</option>";
                $("#Currencies").html(option);
            },
            error: (errResp) => {

            }
        });
        $("#Currencies").change(function () {
            let CountryCurrency = $("#Currencies").val().toLowerCase();
            var currencyDetails = $("#Currencies option:selected").text();
            currencyDetails = currencyDetails.split(":")
            //console.log(currencyDetails);
            url = "https://cdn.jsdelivr.net/gh/fawazahmed0/currency-api@1/latest/currencies/omr/" + CountryCurrency + ".json";
            $.ajax({
                url: url,
                type: "get",
                success: (resp) => {
                    var newPrice = resp[CountryCurrency] *@ViewBag.Amount;
                    var newPricetxt = newPrice + currencyDetails[1];
                    $("#AmountTxt").html("Plan Price in " + currencyDetails[0]);
                    $("#AmountVal").html(newPricetxt);
                    $("#TotalTxt").html("Total Price in " + currencyDetails[0]);
                    $("#TotalVal").html(newPricetxt);

                },
                error: (errResp) => {
                    console.log(errResp);
                }
            });
        });
    });
</script>
@endsection
