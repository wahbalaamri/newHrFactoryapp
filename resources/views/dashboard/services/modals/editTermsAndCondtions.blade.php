<div class="modal fade" id="editTerms" tabindex="-1" aria-labelledby="editTermsLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTermsLabel">
                </h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="editTermsForm" action="">
                    @csrf
                    {{-- select countries --}}
                    <div class="row p-2">
                        <div class="form-group col-md-6 col-sm-12">
                            <label for="Terms_Countries">{{ __('Select') }}</label>
                            <select name="Terms_Countries" id="Terms_Countries" class="form-control">
                                <option value="">{{ __('Select') }}</option>

                            </select>
                        </div>
                    </div>
                    <div class="row p-2">
                        <input type="hidden" name="Pid" id="Pid">
                        <div class="form-group col-md-6 col-sm-12">
                            <label for="terms_title">{{ __('Terms & Condtions Title') }} (EN)</label>
                            <input type="text" name="terms_title" id="terms_title" class="form-control"
                                placeholder="Terms & Condtions Title">
                        </div>
                        <div class="form-group col-md-6 col-sm-12">
                            <label for="terms_title_ar">{{ __('Terms & Condtions Title') }} (AR)</label>
                            <input type="text" name="terms_title_ar" id="terms_title_ar" class="form-control"
                                placeholder="Terms & Condtions Title">
                        </div>
                        <div class="form-group col-12">
                            <label for="terms">{{ __('Terms & Condtions') }} (EN)</label>
                            <textarea name="terms" id="terms" class="form-control summernote"
                                placeholder="Terms & Condtions"></textarea>
                        </div>
                        <div class="form-group col-12">
                            <label for="terms_ar">{{ __('Terms & Condtions') }} (AR)</label>
                            <textarea name="terms_ar" id="terms_ar" class="form-control summernote"
                                placeholder="Terms & Condtions"></textarea>
                        </div>
                        {{-- save button --}}
                        <div class="form-group col-12">
                            <a href="javascript:void(0)" class="btn btn-sm btn-success float-right" id="TermsSave">{{
                                __('Save')
                                }}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
