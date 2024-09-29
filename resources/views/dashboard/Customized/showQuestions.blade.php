@extends('dashboard.layouts.main')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        {{ __('Customized Function') }}
                    </h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">
                            {{ __('Customized Function') }}
                        </li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-success">
                        {{-- card header --}}
                        <div class="card-header">
                            <h3 class="card-title">{{ __('Practice Questions') }}</h3>
                            <div class="card-tools">
                                @can('view', $practice)
                                <a href="{{ route('CustomizedSurvey.showPractices',$practice->function_id) }}"
                                    class="btn btn-warning btn-sm">
                                    <i class="fas fa-arrow-left"></i>
                                </a>
                                @endcan
                                {{-- button to add new practice --}}
                                @can('create', new App\Models\CustomizedSurveyQuestions)
                                <a href="
                                {{ route('CustomizedSurvey.createQuestion',$practice->id) }}"
                                    class="btn btn-secondary btn-sm">
                                    <i class="fas fa-plus"></i>
                                </a>
                                @endcan
                            </div>
                        </div>
                        {{-- card body --}}
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('Question') }}</th>
                                            <th>{{ __('Actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($practice->questions)>0)
                                        @foreach($practice->questions as $question)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $question->question }}</td>
                                            <td>
                                                {{-- button to edit question --}}
                                                @can('update',$question )
                                                <a href="
                                                {{ route('CustomizedSurvey.editQuestion',$question->id) }} "
                                                    class="btn btn-primary btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @endcan
                                                {{-- button to show sweetalert to confirm delete question --}}
                                                @can('delete',$question )
                                                <button class="btn btn-danger btn-sm"
                                                    onclick="deleteQuestion({{ $question->id }})">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                <form id="deleteQuestion-{{ $question->id }}"
                                                    action="
                                                    {{ route('CustomizedSurvey.deleteQuestion',$question->id)}}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                @endcan
                                            </td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="3">
                                                <p class="text-center">{{ __('No Questions Found') }}</p>
                                            </td>
                                        </tr>
                                        @endif
                                    </tbody>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function deleteQuestion(id) {
            Swal.fire({
                title: "{{ __('Are you sure?') }}",
                text: "{{ __('Once deleted, you will not be able to recover this question!') }}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
  if (result.isConfirmed) {
    document.getElementById(`deleteQuestion-${id}`).submit();
    Swal.fire({
      title: "Deleted!",
      text: "Your file has been deleted.",
      icon: "success"
    });
  }
});
        }
</script>
@endsection
