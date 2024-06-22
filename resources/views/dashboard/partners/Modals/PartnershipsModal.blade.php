{{-- PartnershipsModal --}}
<div class="modal fade" id="PartnershipsModal" tabindex="-1" role="dialog" aria-labelledby="partnershipsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            {{-- Modal Header --}}
            <div class="modal-header">
                <h5 class="modal-title"> {{ __('Partnerships List') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {{-- modal body --}}
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-active table-head-fixed table-hover table-striped" id="partnerships-data">
                        <thead>
                            <tr>
                                <th colspan="8">
                                    {{-- create button --}}
                                    <a href="javascript:void(0);" data-url="" id="addPartnership" data-toggle="modal" data-target="#editPartnership" class="btn btn-sm btn-outline-success {{ App()->getLocale()=='ar'? 'float-left':'float-right' }}">
                                        <i class="fas fa-plus"></i>
                                    </a>
                                </th>
                            </tr>
                            <tr>
                                <th>#</th>
                                <th>{{ __("Country") }}</th>
                                <th>{{ __('Satrt Date') }}</th>
                                <th>{{ __('End Date') }}</th>
                                <th>{{ __('Exclusivity') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th colspan="2">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody id="partnerships-table-body">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
