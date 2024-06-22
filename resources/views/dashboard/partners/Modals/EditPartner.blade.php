{{-- modale to edit partner information --}}
<div class="modal fade" id="editPartner" role="dialog" aria-labelledby="editPartner" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPartner">{{ __('Add New Partner') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        {{-- hidden id --}}
                        <input type="hidden" name="id" id="id">
                        {{-- partner name --}}
                        <div class="form-group col-md-6 col-sm-12">
                            <label for="name">{{ __('Partner Name') }}</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="{{ __('Partner Name') }}">
                        </div>
                        {{-- country --}}
                        <div class="form-group col-md-6 col-sm-12">
                            <label for="country">{{ __('Country') }}</label>
                            <select class="form-control" id="country" name="country">
                                <option value="">{{ __('Select Country') }}</option>
                                <optgroup label="{{ __(" Arab Countries") }}">

                                    @foreach ($countries[1] as $country)
                                    <option value="{{ $country->id }}">{{ $country->country_name }}</option>
                                    @endforeach
                                </optgroup>
                                <optgroup label="{{ __(" Other") }}">
                                    @foreach ($countries[0] as $country)
                                    <option value="{{ $country->id }}">{{ $country->country_name }}</option>
                                    @endforeach
                                </optgroup>
                            </select>
                        </div>
                        {{-- upload logo --}}
                        <div class="form-group col-md-6 col-sm-12">
                            <label for="logo">{{ __('Upload Logo') }}</label>
                            <input type="file" class="form-control" id="logo" name="logo">
                        </div>
                        {{-- website --}}
                        <div class="form-group col-md-6 col-sm-12">
                            <label for="website">{{ __('Website') }}</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text p-0">https://</span>
                                </div>
                                <input type="text" class="form-control" id="website" name="website"
                                    placeholder="{{ __('Website') }}">
                            </div>
                        </div>
                        {{-- siwtch for status --}}
                        <div class="form-group col-md-6 col-sm-12 form-switch">
                            <label for="Pstatus">{{ __('Status') }}</label>
                            <input type="checkbox" name="Pstatus" id="Pstatus" checked data-bootstrap-switch
                                data-off-color="danger" data-on-color="success">
                        </div>
                        {{-- submit --}}
                        <div class="form-group col-sm-12">
                            <a href="javascript:void(0)" id="SavePartner" @class(['btn btn-primary btn-sm', 'float-right'=>
                                app()->isLocale('en'),
                                'float-left' => app()->isLocale('ar')])>{{ __('Save') }}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- end modale to edit partner information --}}
{{-- # Path: resources/views/dashboard/partners/Modals/EditPartner.blade.php --}}
