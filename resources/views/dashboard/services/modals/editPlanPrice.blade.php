{{-- modal for plan price --}}
<div class="modal fade" id="editPlanPrice" tabindex="-1" aria-labelledby="editPlanPriceLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ _('Edit Plan Price') }}</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="planPriceForm">
                    @csrf
                    {{-- hidden input for plan id --}}
                    <input type="hidden" name="eplan_id" id="eplan_id">
                    {{-- hidden input for plan price id --}}
                    <input type="hidden" name="plan_price_id" id="plan_price_id">
                    {{-- plan name --}}
                    <div class="row">
                        {{-- service valid in country --}}
                        <div class="form-group col-md-3 col-sm-12">
                            <label for="ppvalid_in">{{ __('Plan Valid In') }}</label>
                            <select name="ppvalid_in" id="ppvalid_in" class="form-control">

                            </select>
                            {{-- validation --}}
                            @error('ppvalid_in')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        {{-- monthly_price --}}
                        <div class="form-group col-md-3 col-sm-12">
                            <label for="monthly_price">{{ __('Monthly Price') }}</label>
                            <input type="number" name="monthly_price" id="monthly_price" class="form-control"
                                placeholder="{{ __('monthly Price') }}" value="{{ old('monthly_price') }}">
                            {{-- validation --}}
                            @error('monthly_price')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        {{-- annual_price --}}
                        <div class="form-group col-md-3 col-sm-12">
                            <label for="annual_price">{{ __('Annual Price') }}</label>
                            <input type="number" name="annual_price" id="annual_price" class="form-control"
                                placeholder="{{ __('Annual Price') }}" value="{{ old('annual_price') }}">
                            {{-- validation --}}
                            @error('annual_price')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        {{-- currency --}}
                        <div class="form-group col-md-3 col-sm-12">
                            <label for="currency">{{ __('Currency') }}</label>
                            <select name="currency" id="currency" class="form-control">
                                <option value="">{{ __('Select Currency') }}</option>

                                <option value="1" @if(old('currency')=="1" ) selected @endif>
                                    {{ __('OMR') }}
                                </option>
                                <option value="2" @if(old('currency')=="2" ) selected @endif>
                                    {{ __('USD') }}
                                </option>
                                <option value="3" @if(old('currency')=="3" ) selected @endif>
                                    {{ __('AED') }}
                                </option>
                                <option value="4" @if(old('currency')=="4" ) selected @endif>
                                    {{ __('SAR') }}
                                </option>
                                <option value="5" @if(old('currency')=="5" ) selected @endif>
                                    {{ __('KWD') }}
                                </option>
                                <option value="6" @if(old('currency')=="6" ) selected @endif>
                                    {{ __('BHD') }}
                                </option>
                                <option value="7" @if(old('currency')=="7" ) selected @endif>
                                    {{ __('QAR') }}
                                </option>
                                <option value="8" @if(old('currency')=="8" ) selected @endif>
                                    {{ __('EGP') }}
                                </option>
                                <option value="9" @if(old('currency')=="9" ) selected @endif>
                                    {{ __('JOD') }}</option>
                                {{-- lebanon --}}
                                <option value="10" @if(old('currency')=="10" ) selected @endif>
                                    {{ __('LBP') }}</option>

                            </select>
                        </div>
                        {{-- payment_methods --}}
                        <div class="form-group col-md-6 col-sm-12">
                            <label for="payment_methods">{{ __('Payment Methods') }}</label>
                            {{-- checkbox input --}}
                            <div class="row">
                                <div class="form-check col-md-6 col-sm-12">
                                    <input class="form-check-input" type="checkbox" name="PM-online" value="0"
                                        id="PM-online">
                                    <label class="form-check-label" for="PM-online">
                                        {{ __('Online') }}
                                    </label>
                                </div>
                                <div class="form-check col-md-6 col-sm-12">
                                    <input class="form-check-input" type="checkbox" name="PM-offline" value="0"
                                        id="PM-offline">
                                    <label class="form-check-label" for="PM-offline">
                                        {{ __('offline') }}
                                    </label>
                                </div>
                                <div class="form-check col-md-6 col-sm-12">
                                    <input class="form-check-input" type="checkbox" name="PM-perscope" value="0"
                                        id="PM-perscope">
                                    <label class="form-check-label" for="PM-perscope">
                                        {{ __('Per-scope') }}
                                    </label>
                                </div>
                                <div class="form-check col-md-6 col-sm-12">
                                    <input class="form-check-input" type="checkbox" name="PM-other" value="0"
                                        id="PM-other">
                                    <label class="form-check-label" for="PM-other">
                                        {{ __('Other') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
