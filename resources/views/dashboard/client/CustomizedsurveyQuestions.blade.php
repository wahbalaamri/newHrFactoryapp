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
                    {{-- card --}}
                    <div class="col-md-12">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('Customized Questions') }}</h3>
                                {{-- tools --}}
                                <div class="card-tools">
                                    {{-- back button --}}
                                    <a href="{{ route('clients.surveyCustomizedDetails', [$id, $type, $survey->id]) }}"
                                        class="btn btn-tool">
                                        <i class="fas fa-arrow-left"></i>
                                    </a>
                                    <a href="{{ route('clients.CreateCustomizedsurveyQuestions', [$id, $type, $survey->id]) }}"
                                        class="btn btn-tool">
                                        <i class="fas fa-plus"></i>
                                    </a>

                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered table-striped text-center" id="question-datatable">
                                        <thead>
                                            <tr>
                                                <th rowspan="2">#</th>
                                                <th rowspan="2">{{ __('Question') }}</th>
                                                <th rowspan="2">{{ __('Practice') }}</th>
                                                <th rowspan="2">{{ __('Function') }}</th>
                                                <th colspan="2">{{ __('Actions') }}</th>
                                            </tr>
                                            <tr>
                                                <th>{{ __('Edit') }}</th>
                                                <th>{{ __('Delete') }}</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('#question-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('clients.CustomizedsurveyQuestions', [$id, $type, $survey->id]) }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'question',
                        name: 'question'
                    },
                    {
                        data: 'practice',
                        name: 'practice'
                    },
                    {
                        data: 'function',
                        name: 'function'
                    },
                    {
                        data: 'editCol',
                        name: 'editCol',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'deleteCol',
                        name: 'deleteCol',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
            //vertical-align: middle; to #question-datatable thead tr's
            $('#question-datatable thead tr').css('vertical-align', 'middle');
        });
    </script>
@endsection
