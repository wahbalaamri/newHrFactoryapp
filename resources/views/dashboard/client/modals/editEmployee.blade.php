{{-- add or edit Employee Modal --}}
<div class="modal fade" id="EmployeeModal" tabindex="-1" role="dialog" aria-labelledby="EmployeeModal"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="EmployeeForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="EmployeeModalLabel">{{__('Add Employee')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-center">
                        {{-- Client name --}}
                        <div class="form-group col-sm-10">
                            <label for="name">{{__('Client Name')}}</label>
                            <input type="text" class="form-control" id="client_name" name="client_name"
                                placeholder="{{__('Client Name')}}" value="{{ $client->name }}" disabled>
                        </div>
                        {{-- Select Sector --}}
                        <div class="form-group col-md-5 col-sm-10">
                            <label for="sector">{{__('Sector')}}</label>
                            <select class="form-control" id="sector" name="sector" required>
                                <option value="">{{__('Select Sector')}}</option>
                                @foreach ($client->sectors as $sector)
                                <option value="{{ $sector->id }}">{{ $sector->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- Select Company --}}
                        <div class="form-group col-md-5 col-sm-10">
                            <label for="company">{{__('Company')}}</label>
                            <select class="form-control" id="company" name="company" required>
                                <option value="">{{__('Select Company')}}</option>
                            </select>
                        </div>
                        {{-- Select Department --}}
                        <div class="form-group col-md-5 col-sm-10">
                            <label for="department">{{__('Department')}}</label>
                            <select class="form-control" id="department" name="department" required>
                                <option value="">{{__('Select Department')}}</option>
                            </select>
                        </div>
                        {{-- Employee Name --}}
                        <div class="form-group col-md-5 col-sm-10">
                            <label for="name">{{__('Employee Name')}}</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="{{__('Employee Name')}}"
                                required>
                        </div>
                        {{-- Employee Email --}}
                        <div class="form-group col-md-5 col-sm-10">
                            <label for="email">{{__('Employee Email')}}</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="{{__('Employee Email')}}"
                                required>
                        </div>
                        {{-- Employee Phone --}}
                        <div class="form-group col-md-5 col-sm-10">
                            <label for="mobile">{{__('Employee Phone')}}</label>
                            <input type="text" class="form-control" id="mobile" name="mobile" placeholder="{{__('Employee Phone')}}"
                                required>
                        </div>
                        {{-- switch Employee Type --}}
                        <div class="form-group col-md-5 col-sm-10">
                            <label for="type">{{__('Employee Type')}}</label>
                            <select class="form-control" id="type" name="type" required>
                                <option value="">{{__('Select Employee Type')}}</option>
                                <option value="1">{{__('Manager')}}</option>
                                <option value="2">{{__('Employee')}}</option>
                            </select>
                        </div>
                        {{-- position --}}
                        <div class="form-group col-md-5 col-sm-10">
                            <label for="position">{{__('Position')}}</label>
                            <input type="text" class="form-control" id="position" name="position" placeholder="{{__('Position')}}"
                                required>
                        </div>
                        {{-- submit --}}
                        <div class="form-group col-sm-10 text-right">
                            <a href="javascript:void(0);" id="SaveEmployee" data-Empid="" class="btn btn-primary btn-block">{{__('Submit')}}</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
