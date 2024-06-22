{{-- modal to show all focal points --}}
<div class="modal fade" id="focalPointsModal" tabindex="-1" aria-labelledby="focalPointsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="focalPointsModalLabel">{{ __("Focal Point List")}}</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="table-responsive">
                        <table id="PartnerFocalPoints-data"
                            class="table table-active table-hover table-head-fixed table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th colspan="8" >
                                        <a href="javascript:void(0)" onclick="hideModal('focalPointsModal')" @class(['btn btn-success btn-sm','float-right'=> app()->isLocale('en'),
                                            'float-left' => app()->isLocale('ar')]) data-toggle="modal" data-target="#EditfocalPointsModal">
                                        <i class="fa fa-user-plus"></i>
                                        </a>
                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                        #
                                    </th>
                                    <th>{{ __('Name') }}
                                    </th>
                                    <th>{{ __('Email') }}
                                    </th>
                                    <th>{{ __('Phone') }}
                                    </th>
                                    <th>{{ __('Position') }}
                                    </th>
                                    <th>{{ __('Status') }}
                                    </th>
                                    <th colspan="2">{{ __('Actions') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="FocalPointTableBody">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
