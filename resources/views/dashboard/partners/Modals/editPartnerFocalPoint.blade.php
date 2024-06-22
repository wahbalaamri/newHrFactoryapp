{{-- modal for EditfocalPointsModal --}}
<div class="modal fade" id="EditfocalPointsModal" tabindex="-1" aria-labelledby="EditfocalPointsModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="EditfocalPointsModalLabel">{{ __("Edit Focal Point")}}</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="FocalPointForm" action="" method="post">
                    <div class="row">
                        @csrf
                        {{-- hidden id --}}
                        <input type="hidden" name="focal_id" id="focal_id">
                        {{-- focal point name in English --}}
                        <div class="form-group col-md-6 col-sm-12">
                            <label for="focal_name">{{ __('Name') }}</label>
                            <input type="text" class="form-control" id="focal_name" name="focal_name"
                                placeholder="{{ __('Name') }}">
                        </div>
                        {{-- focal point name in Arabic --}}

                        <div class="form-group col-md-6 col-sm-12">
                            <label for="focal_name_ar">{{ __('Name in Arabic') }}</label>
                            <input type="text" class="form-control" id="focal_name_ar" name="focal_name_ar"
                                placeholder="{{ __('Name in Arabic') }}">
                        </div>
                        {{-- focal point email --}}
                        <div class="form-group col-md-6 col-sm-12">
                            <label for="focal_email">{{ __('Email') }}</label>
                            <input type="email" class="form-control" id="focal_email" name="focal_email"
                                placeholder="{{ __('Email') }}">
                        </div>
                        {{-- focal point phone --}}
                        <div class="form-group col-md-6 col-sm-12">
                            <label for="focal_phone">{{ __('Phone') }}</label>
                            <input type="text" class="form-control" id="focal_phone" name="focal_phone"
                                placeholder="{{ __('Phone') }}">
                        </div>
                        {{-- focal point position --}}
                        <div class="form-group col-md-6 col-sm-12">
                            <label for="focal_position">{{ __('Position') }}</label>
                            <input type="text" class="form-control" id="focal_position" name="focal_position"
                                placeholder="{{ __('Position') }}">
                        </div>
                        {{-- focal point status switch --}}
                        <div class="form-group col-md-6 col-sm-12">
                            <label for="focal_status">{{ __('Status') }}</label>
                            <input type="checkbox" name="focal_status" id="focal_status" checked data-bootstrap-switch>
                        </div>
                        {{-- submit --}}
                        <div class="form-group col-sm-12">
                            <a href="javascript:void(0)" id="SaveFocalPointbtn" onclick="SaveFocalPoint(this)" @class(['btn btn-success btn-sm', 'float-right' => app()->isLocale('en'), 'float-left' => app()->isLocale('ar')])>
                            {{ __('Save') }}
                            </a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <a href="javascript:void(0)" onclick="hideModal('EditfocalPointsModal')" data-toggle="modal"
                    data-target="#focalPointsModal" @class(['btn btn-secondary btn-sm', 'float-right'=>
                    app()->isLocale('en'),
                    'float-left' => app()->isLocale('ar')])>{{ __('Back') }}</a>
            </div>
        </div>
    </div>
</div>
