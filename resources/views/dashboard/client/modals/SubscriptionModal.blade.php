{{-- add new subscription modal --}}
<div class="modal fade" id="SubscriptionModal" tabindex="-1" aria-labelledby="SubscriptionModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="SubscriptionModalLabel">
                    <i class="fas fa-business-time mr-1"></i>
                    {{ __("Add New Subscription") }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="SubscriptionForm" method="POST" action="">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-10">
                            <label for="service">{{ __('Service') }}</label>
                            <select class="form-control" name="service" id="service">
                                <option value="">{{ __('Select Service Type') }}</option>
                                <option value="1">{{ __('Manual Builder') }}</option>
                                <option value="2">{{ __('Files') }}</option>
                                <option value="3">{{ __('Employee Engagment') }}</option>
                                <option value="4">{{ __('HR Diagnosis') }}</option>
                                <option value="5">{{ __('360 Review') }}</option>
                                <option value="6">{{ __('360 Review - Nama') }}</option>
                                <option value="7">{{ __('Customized surveys') }}</option>
                                <option value="8">{{ __('Chat-bot') }}</option>
                                <option value="9">{{ __('Calculator') }}</option>
                            </select>
                        </div>
                        <div class="form-group col-md-10">
                            <label for="plan">{{ __('Plan') }}</label>
                            <select class="form-control" name="plan" id="plan">
                                <option value="">{{ __('Select Plan') }}</option>
                            </select>
                        </div>
                        <div class="form-group col-md-10">
                            <label for="period">{{ __('Period') }}</label>
                            <select class="form-control" name="period" id="period">
                                <option value="">{{ __('Select Period') }}</option>
                                <option value="1">{{ __('Monthly') }}</option>
                                <option value="4">{{ __('Annually') }}</option>
                            </select>
                        </div>
                        <div class="form-group col-md-10">
                            <label for="start_date">{{ __('Start Date') }}</label>
                            <input type="date" class="form-control" name="start_date" id="start_date">
                        </div>
                        <div class="form-group col-md-10">
                            <label for="end_date">{{ __('End Date') }}</label>
                            <input type="date" class="form-control" name="end_date" id="end_date" disabled>
                        </div>
                        <div class="form-group col-md-6 col-sm-12">
                            <label for="status">{{ __('Status') }}</label>
                            <br>
                            <input type="checkbox" name="status" id="status" checked data-bootstrap-switch
                                data-off-color="danger" data-on-color="success">
                        </div>
                        {{-- checkbox confirmation --}}
                        <div class="form-group col-md-10">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="confirm" id="confirm">
                                <label class="form-check-label" for="confirm">
                                    {{ __('I confirm the subscription') }}
                                </label>
                            </div>
                        </div>
                        {{-- submit --}}
                        <div class="form-group col-md-10 text-right text-xs">
                            <a href="javascript:void(0)" class="btn btn-primary btn-xs" id="SubscriptionSave">
                                <i class="fas fa-save mr-1"></i>
                                {{ __('Save') }}
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
