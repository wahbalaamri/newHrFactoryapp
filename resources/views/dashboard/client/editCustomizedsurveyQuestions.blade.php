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
                            <h3 class="card-title">{{ __('Add/Edit Survey Questions') }}</h3>
                            {{-- tool --}}
                            <div class="card-tools">
                                {{-- back --}}
                                <a href="{{ route('clients.CustomizedsurveyQuestions', [$id, $type,$survey->id]) }}"
                                    class="btn btn-tool">
                                    <i class="fas fa-arrow-left"></i>
                                </a>
                                {{-- create new survey --}}
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="" method="post">
                                <div class="row justify-content-center">
                                    {{-- datatable for other services questions --}}
                                    <div class="col-md-10 col-sm-12">
                                        <div class="card card-primary collapsed-card card-outline">
                                            <div class="card-header">
                                                <h3 class="card-title">{{ __('Select Question From other Service') }}
                                                </h3>
                                                <div class="card-tools">
                                                    <button type="button" class="btn btn-tool"
                                                        data-card-widget="collapse"><i class="fas fa-plus"></i>
                                                    </button>
                                                </div>

                                            </div>

                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="form-group col-md-6 col-sm-12">
                                                        {{-- select service type --}}
                                                        <label for="service">{{ __('Service') }}</label>
                                                        <select name="service" id="service" class="form-control">
                                                            <option value="">{{ __('Select Service') }}</option>
                                                            <option value="3">
                                                                {{ __('Employee Engagment') }}
                                                            </option>
                                                            <option value="4">
                                                                {{ __('HR Diagnosis') }}</option>
                                                            <option value="5">
                                                                {{ __('360 Review') }}</option>
                                                            <option value="6">
                                                                {{ __('360 Review - Nama') }}</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6 col-sm-12">
                                                        {{-- select function --}}
                                                        <label for="function">{{ __('Function') }}</label>
                                                        <select name="function" id="function" class="form-control">
                                                            <option value="">{{ __('Select Function') }}</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6 col-sm-12">
                                                        {{-- select practice --}}
                                                        <label for="practice">{{ __('Practice') }}</label>
                                                        <select name="practice" id="practice" class="form-control">
                                                            <option value="">{{ __('Select Practice') }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="table-responsive">
                                                    <table
                                                        class="table table-bordered table-active table-hover table-striped"
                                                        id="Questions-datatable">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>{{ __('Question') }}</th>
                                                                <th>{{ __('Practice') }}</th>
                                                                <th>{{ __('Function') }}</th>
                                                                <th>{{ __('Action') }}</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    {{-- inputs for user questions --}}
                                    <div class="col-md-10 col-sm-12">
                                        <div class="card card-success card-outline">
                                            <div class="card-header">
                                                <h3 class="card-title">{{ __('Create Your Own Questions') }}</h3>
                                                <div class="card-tools">
                                                    <button type="button" class="btn btn-tool"
                                                        data-card-widget="collapse"><i class="fas fa-minus"></i>
                                                    </button>
                                                </div>

                                            </div>

                                            <div class="card-body">
                                                {{-- create inputs for functions, practices and questions --}}
                                                {{-- user can create on or multiple functions inside each function user
                                                can create one or multiple practices --}}
                                                {{-- each practice may have one or multiple questions --}}
                                                <div class="row">
                                                    <fieldset
                                                        class="w-100 shadow-lg p-3 mb-5 bg-white rounded border p-2">
                                                        <legend class="text-secondary w-auto">{{ __('Function') }}
                                                        </legend>
                                                        <div class="form-group col-11 function-div" id="FunctionDive">
                                                            <label for="function">{{ __('Function Title') }}</label>
                                                            <input type="text" name="function" id="function[]"
                                                                class="form-control col-md-5 col-sm-12"
                                                                placeholder="{{ __('Function Title') }}">
                                                            <label for="f_respondent">{{ __('Function Respondent')
                                                                }}</label>
                                                            <select name="f_respondent" id="f_respondent[]"
                                                                class="form-control col-md-5 col-sm-12">
                                                                <option value="">{{ __('Select Respondent') }}
                                                                </option>
                                                                <option value="1">{{ __('Only HR Employees') }}
                                                                </option>
                                                                <option value="2">{{ __('Only Employees') }}
                                                                </option>
                                                                <option value="3">{{ __('Only Managers') }}
                                                                </option>
                                                                <option value="4">
                                                                    {{ __('Employees & Employees') }}
                                                                </option>
                                                                <option value="5">{{ __('Managers & Employees') }}
                                                                </option>
                                                                <option value="6">
                                                                    {{ __('Managers & HR Employees') }}
                                                                </option>
                                                                <option value="7">{{ __('All Employees') }}
                                                                </option>
                                                                <option value="8">{{ __('Public') }}</option>
                                                            </select>

                                                            <fieldset
                                                                class="w-100 shadow p-3 mb-5 bg-white rounded border p-2">
                                                                <legend class="text-secondary w-auto">
                                                                    {{ __('Practice') }}
                                                                </legend>
                                                                <div class="form-group">
                                                                    <label for="practice">{{ __('Practice Title')
                                                                        }}</label>
                                                                    <input type="text" name="practice" id="practice[]"
                                                                        class="form-control col-md-5 col-sm-12"
                                                                        placeholder="{{ __('Practice Title') }}">
                                                                    {{-- add more practice --}}

                                                                    <fieldset
                                                                        class="w-100 shadow-sm p-3 mb-5 bg-white rounded border p-2">
                                                                        <legend class="text-secondary w-auto">
                                                                            {{ __('Question') }}</legend>
                                                                        <div class="form-group">
                                                                            <label for="question">{{ __('The Question')
                                                                                }}</label>
                                                                            <textarea name="question" id="question[]"
                                                                                class="form-control col-md-5 col-sm-12"
                                                                                placeholder="{{ __('The Question') }}"></textarea>
                                                                            <label for="q_respondent">{{ __('Question
                                                                                Respondent') }}</label>
                                                                            <select name="q_respondent"
                                                                                id="q_respondent[]"
                                                                                class="form-control col-md-5 col-sm-12">
                                                                                <option value="">
                                                                                    {{ __('Select Respondent') }}
                                                                                </option>
                                                                                <option value="1">
                                                                                    {{ __('Only HR Employees') }}
                                                                                </option>
                                                                                <option value="2">
                                                                                    {{ __('Only Employees') }}</option>
                                                                                <option value="3">
                                                                                    {{ __('Only Managers') }}</option>
                                                                                <option value="4">
                                                                                    {{ __('HR Employees & Employees') }}
                                                                                </option>
                                                                                <option value="5">
                                                                                    {{ __('Managers & Employees') }}
                                                                                </option>
                                                                                <option value="6">
                                                                                    {{ __('Managers & HR Employees') }}
                                                                                </option>
                                                                                <option value="7">
                                                                                    {{ __('All Employees') }}</option>
                                                                                <option value="8">
                                                                                    {{ __('Public') }}</option>
                                                                            </select>
                                                                        </div>

                                                                    </fieldset>
                                                                    <div class="form-group col-md-3 col-sm-12">
                                                                        <button type="button"
                                                                            class="btn btn-sm btn-outline-success" id=""
                                                                            onclick="AddQuestion(this)">{{ __('Add More
                                                                            Question') }}</button>
                                                                    </div>
                                                                </div>
                                                            </fieldset>
                                                            <div class="form-group col-md-2 col-sm-12"
                                                                id="addPractice-div">
                                                                <button type="button"
                                                                    class="btn btn-sm btn-outline-warning"
                                                                    id="addPractice" onclick="AddPractice(this)">{{
                                                                    __('Add Practice') }}</button>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                    <div class="form-group col-md-2 col-sm-12" id="addFunction-div">
                                                        <button type="button" class="btn btn-sm btn-outline-primary"
                                                            id="addFunction">{{ __('Add More Function') }}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- submit --}}
                                    <div class="col-md-10 col-sm-12">
                                        <div class="form-group">
                                            <a href="javascript:void(0)" id="SubmitQuestionsbtn"
                                                @class([ 'btn btn-sm btn-outline-info' , 'float-right'=>
                                                App()->isLocale('en'),
                                                'float-left' => App()->isLocale('ar'),
                                                ])>{{ __('Submit') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let selectedQuestions = [];
        //on document ready javascript function
        $("#service").change(function() {
            //get selected service value
            var service = $(this).val();
            if (service != '' || service != null) {
                //get function select value
                var fid = $('#function').val() == "" ? null : $('#function').val();
                //get practice select value
                var pid = $('#practice').val() == "" ? null : $('#practice').val();
                url = "{{ route('clients.GetOtherSurveysQuestions', [':sid', ':fid', ':pid']) }}";
                url = url.replace(':sid', service);
                url = url.replace(':fid', fid);
                url = url.replace(':pid', pid);
                //update table
                UpdateTable(url);
                //update function select
                $.ajax({
                    type: "GET",
                    url: "{{ route('clients.GetFunctions', ':sid') }}".replace(':sid', service),
                    success: function(response) {
                        if (response.stat) {
                            options =
                                `<option value="
                            ">{{ __('Select Function') }}</option>`
                            response.functions.forEach(element => {
                                options +=
                                    `<option value="${element.id}">${element.translated_title}</option>`;
                            });
                            $('#function').html(options);
                        }
                    }
                });
            }
        });
        $("#function").change(function() {
            var fid = $(this).val();
            if (fid != '' || fid != null) {
                //get function select value
                var service = $('#service').val() == "" ? null : $('#service').val();
                //get practice select value
                var pid = $('#practice').val() == "" ? null : $('#practice').val();
                url = "{{ route('clients.GetOtherSurveysQuestions', [':sid', ':fid', ':pid']) }}";
                url = url.replace(':sid', service);
                url = url.replace(':fid', fid);
                url = url.replace(':pid', pid);
                UpdateTable(url);
                //update practices select
                $.ajax({
                    type: "GET",
                    url: "{{ route('clients.GetPractices', ':fid') }}".replace(':fid', fid),
                    success: function(response) {
                        if (response.stat) {
                            options =
                                `<option value="
                            ">{{ __('Select Practice') }}</option>`
                            response.practices.forEach(element => {
                                options +=
                                    `<option value="${element.id}">${element.translated_title}</option>`
                            });
                            $('#practice').html(options);
                        }
                    }
                });
            }
        });
        $("#practice").change(function() {
            var pid = $(this).val();
            if (pid != '' || pid != null) {
                //get function select value
                var service = $('#service').val() == "" ? null : $('#service').val();
                //get practice select value
                var fid = $('#function').val() == "" ? null : $('#function').val();
                url = "{{ route('clients.GetOtherSurveysQuestions', [':sid', ':fid', ':pid']) }}";
                url = url.replace(':sid', service);
                url = url.replace(':fid', fid);
                url = url.replace(':pid', pid);
                UpdateTable(url);
            }
        });
        UpdateTable = (url) => {
            //initialize datatable
            $('#Questions-datatable').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                ajax: url,
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
                    }
                ],
                "columnDefs": [{
                    "targets": 4,
                    "render": function(data, type, row) {

                        return `<input type="checkbox" class="row-select" value="${row.id}" data-pid="${row.practice_id}" data-fid="${row.fid}" onchancge="setSelected(${row.id})"><label class="form-check-label" for="exampleCheck1">Select the Question</label>`;
                    }
                }],
            });
            $('#Questions-datatable tbody').on('change', 'input.row-select', function() {
                var id = $(this).val();
                if ($(this).is(':checked')) {
                    //get this data-pid attribute
                    var pid = $(this).attr('data-pid');
                    var fid = $(this).attr('data-fid');
                    row = {
                        'fid': fid,
                        'pid': pid,
                        'qid': id
                    }
                    selectedQuestions.push(row);
                } else {
                    selectedQuestions = selectedQuestions.filter(function(obj) {
                        return obj.qid !== id;
                    });
                }

            });
        }

        function AddQuestion(ctr) {
            var html = `<fieldset class="w-100 p-3 mb-5 border p-2""><legend class="text-secondary w-auto">{{ __('Question') }}</legend><div class="form-group">
                <label for="practice">{{ __('The Question') }}</label>
                <textarea name="question" id="question[]" class="form-control col-md-5 col-sm-12" placeholder="{{ __('The Question') }}"></textarea>
                <label
                                                                                    for="q_respondent">{{ __('Question Respondent') }}</label>
                                                                                <select name="q_respondent" id="q_respondent[]"
                                                                                    class="form-control col-md-5 col-sm-12">
                                                                                    <option value="">
                                                                                        {{ __('Select Respondent') }}
                                                                                    </option>
                                                                                    <option value="1">
                                                                                        {{ __('Only HR Employees') }}
                                                                                    </option>
                                                                                    <option value="2">
                                                                                        {{ __('Only Employees') }}</option>
                                                                                    <option value="3">
                                                                                        {{ __('Only Managers') }}</option>
                                                                                    <option value="4">
                                                                                        {{ __('HR Employees & Employees') }}
                                                                                    </option>
                                                                                    <option value="5">
                                                                                        {{ __('Managers & Employees') }}
                                                                                    </option>
                                                                                    <option value="6">
                                                                                        {{ __('Managers & HR Employees') }}
                                                                                    </option>
                                                                                    <option value="7">
                                                                                        {{ __('All Employees') }}</option>
                                                                                    <option value="8">
                                                                                        {{ __('Public') }}</option>
                                                                                </select>
            </div></fieldset>`;
            $(ctr).parent().parent().find('fieldset').last().after(html);
        }

        function AddPractice(ctr) {
            var html = `<fieldset class="w-100 p-3 mb-5 border p-2""><legend class="text-secondary w-auto">{{ __('Practice') }}</legend><div class="form-group">
                <label for="practice">{{ __('Practice Title') }}</label>
                <input type="text" name="practice" id="practice[]" class="form-control col-md-5 col-sm-12" placeholder="{{ __('Practice Title') }}">
                <fieldset class="w-100 p-3 mb-5 border p-2"><legend class="text-secondary w-auto">{{ __('Question') }}</legend><div class="form-group">
                <div class="form-group">
                    <label for="question">{{ __('The Question') }}</label>
                    <textarea name="question" id="question[]" class="form-control col-md-5 col-sm-12" placeholder="{{ __('The Question') }}"></textarea>
                    <label
                                                                                    for="q_respondent">{{ __('Question Respondent') }}</label>
                                                                                <select name="q_respondent" id="q_respondent[]"
                                                                                    class="form-control col-md-5 col-sm-12">
                                                                                    <option value="">
                                                                                        {{ __('Select Respondent') }}
                                                                                    </option>
                                                                                    <option value="1">
                                                                                        {{ __('Only HR Employees') }}
                                                                                    </option>
                                                                                    <option value="2">
                                                                                        {{ __('Only Employees') }}</option>
                                                                                    <option value="3">
                                                                                        {{ __('Only Managers') }}</option>
                                                                                    <option value="4">
                                                                                        {{ __('HR Employees & Employees') }}
                                                                                    </option>
                                                                                    <option value="5">
                                                                                        {{ __('Managers & Employees') }}
                                                                                    </option>
                                                                                    <option value="6">
                                                                                        {{ __('Managers & HR Employees') }}
                                                                                    </option>
                                                                                    <option value="7">
                                                                                        {{ __('All Employees') }}</option>
                                                                                    <option value="8">
                                                                                        {{ __('Public') }}</option>
                                                                                </select>
                </div></fieldset>
                <div class="form-group col-md-3 col-sm-12">
                    <button type="button" class="btn btn-sm btn-outline-success" id="" onclick="AddQuestion(this)">
                        {{ __('Add More Question') }}</button>
                        </div>
            </div></fieldset>`;
            //append #addPractice-div
            $(ctr).parent().parent().find('#addPractice-div').before(html);

        }
        //addFunction on click event
        $("#addFunction").click(function() {
            var html = `<fieldset
            class="w-100 shadow-lg p-3 mb-5 bg-white rounded border p-2">
            <legend class="text-secondary w-auto">{{ __('Function') }}</legend>
                <div class="form-group col-11 function-div" id="FunctionDive">
                    <label for="function">{{ __('Function Title') }}</label>
                    <input type="text" name="function" id="function[]" class="form-control col-md-5 col-sm-12"
                    placeholder="{{ __('Function Title') }}">
                    <label for="f_respondent">{{ __('Function Respondent') }}</label>
                                                            <select name="f_respondent" id="f_respondent[]"
                                                                class="form-control col-md-5 col-sm-12">
                                                                <option value="">{{ __('Select Respondent') }}</option>
                                                                <option value="1">{{ __('Only HR Employees') }}</option>
                                                                <option value="2">{{ __('Only Employees') }}</option>
                                                                <option value="3">{{ __('Only Managers') }}</option>
                                                                <option value="4">{{ __('Employees & Employees') }}
                                                                </option>
                                                                <option value="5">{{ __('Managers & Employees') }}
                                                                </option>
                                                                <option value="6">{{ __('Managers & HR Employees') }}
                                                                </option>
                                                                <option value="7">{{ __('All Employees') }}</option>
                                                                <option value="8">{{ __('Public') }}</option>
                                                            </select>
                    <fieldset class="w-100 shadow p-3 mb-5 bg-white rounded border p-2">
                        <legend class="text-secondary w-auto">{{ __('Practice') }}</legend>
                        <div class="form-group">
                            <label for="practice">{{ __('Practice Title') }}</label>
                            <input type="text" name="practice" id="practice[]"
                            class="form-control col-md-5 col-sm-12" placeholder="{{ __('Practice Title') }}">
                            <fieldset class="w-100 shadow-sm p-3 mb-5 bg-white rounded border p-2">
                                <legend class="text-secondary w-auto">{{ __('Question') }}</legend>
                                <div class="form-group">
                                    <label for="question">{{ __('The Question') }}</label>
                                    <textarea name="question" id="question[]" class="form-control col-md-5 col-sm-12" placeholder="{{ __('The Question') }}"></textarea>
                                    <label
                                                                                    for="q_respondent">{{ __('Question Respondent') }}</label>
                                                                                <select name="q_respondent" id="q_respondent[]"
                                                                                    class="form-control col-md-5 col-sm-12">
                                                                                    <option value="">
                                                                                        {{ __('Select Respondent') }}
                                                                                    </option>
                                                                                    <option value="1">
                                                                                        {{ __('Only HR Employees') }}
                                                                                    </option>
                                                                                    <option value="2">
                                                                                        {{ __('Only Employees') }}</option>
                                                                                    <option value="3">
                                                                                        {{ __('Only Managers') }}</option>
                                                                                    <option value="4">
                                                                                        {{ __('HR Employees & Employees') }}
                                                                                    </option>
                                                                                    <option value="5">
                                                                                        {{ __('Managers & Employees') }}
                                                                                    </option>
                                                                                    <option value="6">
                                                                                        {{ __('Managers & HR Employees') }}
                                                                                    </option>
                                                                                    <option value="7">
                                                                                        {{ __('All Employees') }}</option>
                                                                                    <option value="8">
                                                                                        {{ __('Public') }}</option>
                                                                                </select>
                                </div>
                            </fieldset>
                        </div>
                        <div class="form-group col-md-3 col-sm-12">
                                <button type="button" class="btn btn-sm btn-outline-success"
                                        id=""
                                        onclick="AddQuestion(this)">{{ __('Add More Question') }}</button>
                        </div>

                    </fieldset>
                        <div class="form-group col-md-2 col-sm-12" id="addPractice-div">
                                <button type="button" class="btn btn-sm btn-outline-warning" id="addPractice"
                                onclick="AddPractice(this)">{{ __('Add More Practice') }}</button>
                        </div>
                </div>
            </fieldset>`
            $('#addFunction-div').before(html);
        });
        $("#SubmitQuestionsbtn").click(function() {
            var FromReadyQuestion = [];
            var service = $('#service').val();
            var function_ = $('#function').val();
            var practice = $('#practice').val();
            var questions = $('#Questions-datatable').find('.row-select');
            //collect data each function each practice and each question
            var data = [];
            $('.function-div').each(function() {
                var function_ = $(this).find('input[name="function"]').val();
                var function_r=$(this).find('select[name="f_respondent"]').val();
                var practices = [];
                $(this).find('fieldset').each(function() {
                    var practice = $(this).find('input[name="practice"]').val();
                    var questions = [];
                    $(this).find('textarea[name="question"]').each(function() {
                        questions.push({
                            question: $(this).val(),
                            respondent: $(this).parent().find('select[name="q_respondent"]').val()
                        });
                    });
                    practices.push({
                        practice: practice,
                        questions: questions
                    });
                });
                data.push({
                    function_: function_,
                    function_r:function_r,
                    practices: practices
                });
            });
            //send data to server
            $.ajax({
                type: "POST",
                url: "{{ route('clients.SubmitCustomizedQuestions', [$id, $type]) }}",
                data: {
                    data: data,
                    selectedQuestions: selectedQuestions,
                    survey: "{{ $survey->id }}",
                    _token: "{{ csrf_token() }}"
                    // service: service,
                    // function_: function_,
                    // practice: practice
                },
                success: function(response) {
                    if (response.stat) {
                        //sweetalert
                        Swal.fire({
                        icon: 'success',
                        title: 'Done',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                    //reload page
                    setTimeout(() => {
                        //redirect to url
                        window.location.href = "{{ route('clients.ShowCustomizedSurveys', [$id, $type]) }}";
                    }, 1500);
                    } else {
                        alert('Error');
                    }
                }
            });
        });
</script>
@endsection
