<div class="modal fade" id="addEditFeature" tabindex="-1" aria-labelledby="addEditFeatureLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEditFeatureLabel">Add Feature</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    {{-- featur in English --}}
                    <input type="hidden" name="Fid" id="Fid">
                    <input type="hidden" name="Sid" id="Sid" value="{{ $service->id }}">
                    <div class="form-group col-12">
                        <label for="feature">{{ __('Feature') }}</label>
                        <input type="text" name="feature" id="feature" class="form-control" placeholder="Feature">
                    </div>
                    {{-- featur in Arabic --}}
                    <div class="form-group col-12">
                        <label for="feature_ar">{{ __('Feature Arabic') }}</label>
                        <input type="text" name="feature_ar" id="feature_ar" class="form-control"
                            placeholder="Feature Arabic">
                    </div>
                    {{-- feature status --}}
                    <div class="form-group col-12">
                        <label for="status">{{ __('Status') }}</label>
                        {{-- switch --}}
                        <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                            <input type="checkbox" class="custom-control-input" id="status" checked>
                            <label class="custom-control-label" for="status">{{ __('Active') }}</label>
                        </div>
                    </div>
                    <div class="form-group col-12">
                        <a type="submit" class="btn btn-sm btn-success float-right" id="FeatureSave">{{ __('Save')
                            }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
