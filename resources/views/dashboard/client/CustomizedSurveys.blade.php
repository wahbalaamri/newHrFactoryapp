{{-- extends --}}
@extends('dashboard.layouts.main')

{{-- content --}}
{{-- show client details --}}
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard </li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                {{-- create funcy card to display surveys --}}
                <div class="col-12 mt-3">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('Surveys') }}</h3>
                            <div class="card-tools">
                                <a href="{{ route('clients.manage',$client->id) }}"
                                    class="btn btn-tool">
                                    <i class="fa fa-arrow-left"></i>
                                </a>
                            {{-- tool --}}
                                <a href="{{ route('clients.createCustomizedSurvey',[$client->id,$type]) }}"
                                    class="btn btn-tool">
                                <i class="fa fa-plus"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table id="surveysDataTable" class="table table table-bordered data-table">
                                            <thead>
                                                <tr>
                                                    <th scope="">#</th>
                                                    <th scope="">{{ __('Survey Name') }}</th>
                                                    <th scope="">{{ __('Service') }}</th>
                                                    <th scope="">{{ __('Plan') }}</th>
                                                    <th scope="">{{ __('Survey Status') }}</th>
                                                    <th scope="">{{ __('Survey Date') }}</th>
                                                    <th scope="">{{ __('Start') }}</th>
                                                    <th colspan="3" scope="">{{ __('Survey
                                                        Actions') }}
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($client_survyes as $survey)
                                                <tr {{--role="button"
                                                    onclick="window.location.replace('{{ route('clients.surveyDetails',[$id,$type,$survey->id])}}');"
                                                    --}}>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $survey->survey_title }}</td>
                                                    <td>
                                                        @if ($survey->plan)
                                                        {{ $survey->plan->service_->service_name }}
                                                        @else
                                                        {{ __('No service') }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($survey->plan)
                                                        {{ $survey->plan->name }}
                                                        @else
                                                        {{ __('No Plan') }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox"
                                                                role="switch"
                                                                id="flexSwitchCheckChecked{{ $survey->id }}" {{
                                                                $survey->survey_stat?
                                                            'checked':'' }}
                                                            onchange="ChangeCheck(this,'{{ $id }}','{{ $type
                                                            }}','{{$survey->id}}')" >
                                                        </div>
                                                    </td>
                                                    <td>{{ $survey->created_at->format('d-m-Y')
                                                        }}</td>
                                                    <td><a href="{{ route('clients.surveyCustomizedDetails',[$id,$type,$survey->id])}}"
                                                            class="btn btn-info btn-sm m-1"><i
                                                                class="fa fa-eye"></i></a></td>
                                                    <td><a href="{{ route('clients.editSurvey', [$id,$type,$survey->id])}}"
                                                            class="edit btn btn-primary btn-sm m-1"><i
                                                                class="fa fa-edit"></i></a></td>

                                                    <td>
                                                        <form
                                                            action="{{route('clients.destroySurvey', [$id,$type,$survey->id])}}"
                                                            method="POST" class="delete_form" style="display:inline">
                                                            <input type="hidden" name="_method"
                                                                value="DELETE">@csrf<button type="submit"
                                                                class="btn btn-danger btn-sm m-1"><i
                                                                    class="fa fa-trash"></i></button>
                                                        </form>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </section>
    <!-- /.content -->
</div>
@endsection
@section('scripts')

<script>
    $(".form-check-input").bootstrapSwitch();
    //onchange switch
    function ChangeCheck(e,id,type,survey_id){
        var status = e.checked?1:0;
        //setup url
        url = "{{ route('clients.changeSurveyStat',[':id',':type',':survey']) }}";
        url = url.replace(':id',id);
        url = url.replace(':type',type);
        url = url.replace(':survey',survey_id);
        $.ajax({
            type: "POST",
            url: url,
            data: {
                "_token": "{{ csrf_token() }}",
                "id": id,
                "status": status
            },
            success: function (response) {
                if (response.status) {
                    toastr.success(response.message);
                } else {
                    toastr.error(response.message);
                }
            }
        });
    }
</script>
@endsection
