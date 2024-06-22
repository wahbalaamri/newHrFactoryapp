{{-- editPartnership --}}
<div class="modal fade" id="editPartnership" tabindex="-1" role="dialog" aria-labelledby="editPartnershipLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            {{-- Modal Header --}}
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Create New Partnership') }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {{-- modal-body --}}
            <div class="modal-body">
                <form action="" method="post" id="partnership-form">
                    @csrf
                    <div class="row">
                        {{-- hidden id --}}
                        <input type="hidden" name="id" id="partnership-id">
                        {{-- select country --}}
                        <div class="form-group col-md-6 col-sm-12">
                            <label for="">{{ __('Country') }}</label>
                            <select class="form-control" name="country" id="country">
                                <option value="">{{ __('Select') }}</option>
                                <optgroup label="{{ __('Arab Country') }}">
                                    @foreach ($countries[1] as $country)
                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </optgroup>
                                <optgroup label="{{ __('Other') }}">
                                    @foreach ($countries[0] as $country)
                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </optgroup>
                            </select>
                        </div>
                        {{-- start date --}}
                        <div class="form-group col-md-6 col-sm-12">
                            <label for="">{{ __('Start Date') }}</label>
                            <input type="date" class="form-control" name="start_date" id="start_date">
                        </div>
                        {{-- end date --}}
                        <div class="form-group col-md-6 col-sm-12">
                            <label for="">{{ __('End Date') }}</label>
                            <input type="date" class="form-control" name="end_date" id="end_date">
                        </div>
                        {{-- exclusivity switch --}}
                        <div class="form-group col-md-6 col-sm-12">
                            <label for="" class="row">{{ __('Exclusivity') }}</label>
                            <input type="checkbox" name="exclusivity" id="exclusivity" data-bootstrap-switch
                                data-off-color="danger" data-on-color="success">
                        </div>
                        {{-- status switch --}}
                        <div class="form-group col-md-6 col-sm-12">
                            <label for="" class="row">{{ __('Status') }}</label>
                            <input type="checkbox" name="status" id="Partnershipstatus" checked data-bootstrap-switch
                                data-off-color="danger" data-on-color="success">
                        </div>
                        {{-- submit --}}
                        <div class="form-group col-sm-12">
                            <a href="javascript:void(0)" id="SavePartnerShip"
                                class="btn btn-primary btn-sm {{ app()->isLocale('ar')? 'float-left':'float-right' }}">{{
                                __('Save') }}</a>
                        </div>
                    </div>
                </form>
            </div>
            {{-- modal-footer --}}
            <div class="modal-footer">
                {{-- back to PartnershipsModal --}}
                <button type="button" class="btn btn-secondary" onclick="$('#editPartnership').modal('hide')"
                    data-toggle="modal" data-target="#PartnershipsModal">{{ __('Back') }}</button>
                {{-- save button --}}
            </div>
        </div>
    </div>
</div>
