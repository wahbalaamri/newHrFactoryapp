{{-- raters modal --}}
<div class="modal fade" id="ratersModal" tabindex="-1" role="dialog" aria-labelledby="ratersModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            {{-- modal header --}}
            <div class="modal-header">
                <h5 class="modal-title" id="ratersModalLabel">{{ __('Raters') }}</h5>
            </div>
            {{-- modal body --}}
            <div class="modal-body">
                <div class="row">
                    <input type="hidden" name="candidate_id" id="candidate_id">
                    {{-- select sector --}}
                    <div class="form-group col-md-6 col-sm-12">
                        <label for="sector">{{ __('Sector') }}</label>
                        <select class="form-control" name="sector" id="sector">
                            <option value="">{{ __('Select Sector') }}</option>
                        </select>
                    </div>
                    {{-- select company --}}
                    <div class="form-group col-md-6 col-sm-12">
                        <label for="company">{{ __('Company') }}</label>
                        <select class="form-control" name="company" id="company">
                            <option value="">{{ __('Select Company') }}</option>
                        </select>
                    </div>
                    {{-- select department --}}
                    <div class="form-group col-md-6 col-sm-12">
                        <label for="department">{{ __('Department') }}</label>
                        <select class="form-control" name="department" id="department">
                            <option value="">{{ __('Select Department') }}</option>
                        </select>
                    </div>
                    {{-- select type of raters --}}
                    <div class="form-group col-md-6 col-sm-12">
                        <label for="type">{{ __('Type') }}</label>
                        <select class="form-control" name="type" id="type">
                            <option value="">{{ __('Select Type') }}</option>
                            <option value="SL">{{ __('Self') }}</option>
                            <option value="LM">{{ __('Line Manager') }}</option>
                            <option value="PE">{{ __('Peer') }}</option>
                            <option value="DR">{{ __('Direct Report') }}</option>
                            <option value="OT">{{ __('other') }}</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    {{-- datatable --}}
                    <div class="table-responsive">
                        <table class="table table-bordered table-active table-hover table-striped" id="Raters">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Email') }}</th>
                                    <th>{{ __('Position') }}</th>
                                    <th>{{ __('Department') }}</th>
                                    <th>{{ __('Type') }}</th>
                                    <th >{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- raters table --}}
