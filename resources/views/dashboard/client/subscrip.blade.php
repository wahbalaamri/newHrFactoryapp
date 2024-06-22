@extends('dashboard.layouts.main')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Client Subscriptions') }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">{{ __('Client Subscriptions') }} </li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <!-- Main row -->
            <div class="row">
                <!-- Left col -->
                <section class="connectedSortable w-100">
                    <div class="card card-outline card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-business-time mr-1"></i>
                                {{ __("Client's Subscriptions") }}
                            </h3>
                            <div class="card-tools">
                                {{-- back --}}
                                <a href="{{ route('clients.manage',$id) }}"
                                    class="btn btn-sm btn-tool {{ App()->getLocale()=='ar'? 'float-start':'float-end' }}">
                                    <i class="fas fa-arrow-left"></i>
                                </a>
                                {{-- create new Employee --}}
                                <a href="javascript:void(0);" data-toggle="modal" data-target="#SubscriptionModal"
                                    class="btn btn-sm btn-tool {{ App()->getLocale()=='ar'? 'float-end':'float-start' }}">
                                    <i class="fas fa-plus"></i>
                                </a>
                            </div>
                        </div><!-- /.card-header -->
                        {{-- card body --}}
                        <div class="card-body">
                            {{-- responsive table --}}
                            <div class="table-responsive">
                                <table
                                    class="table table-hover table-striped table-bordered table-sm text-center text-sm"
                                    id="subscripTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('Service') }}</th>
                                            <th>{{ __('Plan') }}</th>
                                            <th>{{ __('Period') }}</th>
                                            <th>{{ __('Start Date') }}</th>
                                            <th>{{ __('End Date') }}</th>
                                            <th>{{ __('Paid Amount') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            {{-- <th>{{ __('Admin Actions') }}</th> --}}
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
</div>
<!-- /.content -->
{{-- include --}}
@include('dashboard.client.modals.SubscriptionModal')
@endsection
@section('scripts')
<script>
    var plans=[];
    var plansprice=[];
    $(document).ready(function() {
        $("#status").bootstrapSwitch();
        url="{{ route('clients.viewSubscriptions',':d') }}"
        url=url.replace(':d',"{{ $id }}")
        $('#subscripTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: url,
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'service',
                    name: 'service'
                },
                {
                    data: 'plan',
                    name: 'plan'
                },
                {
                    data: 'period',
                    name: 'period'
                },
                {
                    data: 'start_date',
                    name: 'start_date'
                },
                {
                    data: 'end_date',
                    name: 'end_date'
                },
                {
                    data: 'paid_amount',
                    name: 'paid_amount'
                },
                {
                    data: 'is_active',
                    name: 'is_active'
                },
                // {
                //     data: 'action',
                //     name: 'action',
                //     orderable: false,
                //     searchable: false
                // }
            ],
            "drawCallback": function(settings) {
                var data = "{{ Auth::user()->isAdmin }}";
                if (!data) {
                    // Remove the 3rd column (index 2) if the status is 'inactive'
                    $('#subscripTable').DataTable().column(7).visible(false);
                }
        }
        });
        ///on service select
        $('#service').on('change', function() {
            var service = $(this).val();
            url="{{ route('subscription.getPlans',':d') }}"
            url=url.replace(':d',service)
            if (service) {
                $.ajax({
                    url: url,
                    type: "get",
                    data: {
                        service: service,
                        country: "{{ $client->country }}"
                    },
                    success: function(data) {
                        if(data.status){
                            plans=data.plans;
                            plansprice=data.plans_prices;
                        $('#plan').empty();
                        $('#plan').append('<option value="">Select Plan</option>');
                        $.each(data.plans, function(key, value) {
                            $('#plan').append('<option value="' + value.id + '">' + value.planName +
                                '</option>');
                        });
                    }
                    else{
                        toastr.error(data.error);
                        $('#plan').empty();
                        $('#plan').append('<option value="">Select Plan</option>');
                    }
                    },
                    error: function(data) {
                        // console.log('Error:', data);
                    }
                });
            } else {
                $('#plan').empty();
            }
        });
        //on period select
        $('#period').on('change', function() {
            var period = $(this).val();
            var start_date = $('#start_date').val();
            if(period && start_date)
            //get plan price of selected plan and period
        console.log(plansprice.filter(plan=>plan.plan_id==$('#plan').val() && plan.period_id==period)[0].price);
            {setEndDate(period,start_date);}
        });
        //start_date change
        $('#start_date').on('change', function() {
            var period = $('#period').val();
            var start_date = $(this).val();
            if(period && start_date)
            {setEndDate(period,start_date);}
        });
        setEndDate=(period,start_date)=>{
            if (period && start_date) {
                var date = new Date(start_date);
                if (period == 1) {
                    date.setMonth(date.getMonth() + 1);
                } else {
                    date.setFullYear(date.getFullYear() + 1);
                }
                var dd = date.getDate();
                var mm = date.getMonth() + 1;
                var yyyy = date.getFullYear();
                if (dd < 10) {
                    dd = '0' + dd;
                }
                //set end date
                if (mm < 10) {
                    mm = '0' + mm;
                }
                var end_date = yyyy + '-' + mm + '-' + dd;
                $('#end_date').val(end_date);
            }
        }
        //save subscription
        $('#SubscriptionSave').on('click', function() {
            var service = $('#service').val();
            var plan = $('#plan').val();
            var period = $('#period').val();
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            var confirm = $('#confirm').is(':checked');
            //status
            var status = $('#status').is(':checked');
            var url="{{ route('clients.saveSubscription',':d') }}"

            url=url.replace(':d',"{{ $id }}")
            if(!confirm)
            {
                toastr.error('Please confirm the subscription');
                //add class to  $('#confirm') parent
                //check if it has the class
                if(!$('#confirm').parent().hasClass('text-danger'))
                {
                    $('#confirm').parent().addClass('text-danger');
                    $('#confirm').parent().removeClass('text-success');
                }

            }
            else{
                if($('#confirm').parent().hasClass('text-danger'))
                {
                    $('#confirm').parent().removeClass('text-danger');
                    $('#confirm').parent().addClass('text-success');
                }
            }
            if(service)
            {
                if($('#service').hasClass('is-invalid'))
                {
                    $('#service').removeClass('is-invalid');
                    //add is-valid class
                    $('#service').addClass('is-valid');

                }
            }
            else{
                $('#service').addClass('is-invalid');
                //remove is-valid class
                $('#service').removeClass('is-valid');
            }
            if(plan)
            {
                if($('#plan').hasClass('is-invalid'))
                {
                    $('#plan').removeClass('is-invalid');
                    //add is-valid class
                    $('#plan').addClass('is-valid');
                }
            }
            else{
                $('#plan').addClass('is-invalid');
                //remove is-valid class
                $('#plan').removeClass('is-valid');
            }
            if(period)
            {
                if($('#period').hasClass('is-invalid'))
                {
                    $('#period').removeClass('is-invalid');
                    //add is-valid class
                    $('#period').addClass('is-valid');
                }

            }
            else{
                $('#period').addClass('is-invalid');
                //remove is-valid class
                $('#period').removeClass('is-valid');
            }
            if(start_date)
            {
                if($('#start_date').hasClass('is-invalid'))
                {
                    $('#start_date').removeClass('is-invalid');
                    //add is-valid class
                    $('#start_date').addClass('is-valid');
                }
            }
            else{
                $('#start_date').addClass('is-invalid');
                //remove is-valid class
                $('#start_date').removeClass('is-valid');
            }
            if (service && plan && period && start_date && end_date && confirm) {
                $.ajax({
                    url: url,
                    type: "POST",
                    data: {
                        _token: "{{csrf_token()}}",
                        service: service,
                        plan: plan,
                        period: period,
                        start_date: start_date,
                        end_date: end_date,
                        status: status,
                        subscription: null,
                    },
                    success: function(data) {
                        if (data.status) {
                            $('#SubscriptionModal').modal('hide');
                            $('#subscripTable').DataTable().ajax.reload();
                            toastr.success(data.message);
                        } else {
                            toastr.error(data.error);
                        }
                    },
                    error: function(data) {
                        toastr.error(data.error);
                        // console.log('Error:', data);
                    }
                });
            } else {

                toastr.error('Please fill all fields and confirm the subscription');
            }
        });
    });
</script>
@endsection
