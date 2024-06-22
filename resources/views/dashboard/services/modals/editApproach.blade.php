<div class="modal fade" id="addEditApproach" tabindex="-1" aria-labelledby="addEditApproachLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEditApproachLabel">Add Approach
                </h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"><i
                        class="fa fa-times"></i></button>
            </div>
            <div class="modal-body">
                {{-- form to add new approach --}}
                <form action="" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row p-2">
                        <input type="hidden" name="Sid" value="{{ $service->id }}">
                        <input type="hidden" name="Aid" value="">
                        {{-- approach in English --}}
                        <div class="form-group col-12">
                            <label for="approach">{{ __('Approach') }}</label>
                            <textarea name="approach" class="form-control summernote" placeholder="Approach"></textarea>
                        </div>
                        {{-- approach in Arabic --}}
                        <div class="form-group col-12">
                            <label for="approach_ar">{{ __('Approach Arabic') }}</label>
                            <textarea name="approach_ar" class="form-control summernote"
                                placeholder="Approach Arabic"></textarea>
                        </div>
                        {{-- icon --}}
                        <div class="form-group col-12">
                            <label for="icon">{{ __('Icon') }}</label>
                            <input type="file" name="icon" class="form-control">
                        </div>
                        {{-- save button --}}
                        <div class="form-group col-12">
                            <a type="submit" class="btn btn-sm btn-success float-right" id="ApproachSave">{{ __('Save')
                                }}</a>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
