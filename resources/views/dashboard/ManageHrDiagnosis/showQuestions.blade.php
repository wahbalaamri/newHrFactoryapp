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
                        @if($service_type==4)
                        {{ __('HR Diagnosis Tool') }}
                        @elseif($service_type==5)
                        {{ __('360 Review Tool') }}
                        @elseif($service_type==3)
                        {{ __('Employee Engagment Tool') }}
                        @endif
                    </h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">
                            @if($service_type == 4)
                            HR Diagnosis
                            @elseif($service_type == 5)
                            360 Review
                            @elseif($service_type == 3)
                            Employee Engagment
                            @endif
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
                                <a href="@if($service_type == 4)
                                {{ route('ManageHrDiagnosis.showPractices',$practice->function_id) }}
                                @elseif($service_type == 5)
                                {{ route('Leader360Review.showPractices',$practice->function_id) }}
                                @elseif($service_type == 3)
                                {{ route('EmployeeEngagment.showPractices',$practice->function_id) }}
                                @endif
                                "
                                    class="btn btn-warning btn-sm">
                                    <i class="fas fa-arrow-left"></i>
                                </a>
                                {{-- button to add new practice --}}
                                <a href="
                                @if($service_type == 4)
                                {{ route('ManageHrDiagnosis.createQuestion',$practice->id) }}
                                @elseif($service_type == 5)
                                {{ route('Leader360Review.createQuestion',$practice->id) }}
                                @elseif($service_type == 3)
                                {{ route('EmployeeEngagment.createQuestion',$practice->id) }}
                                @endif
                                "
                                    class="btn btn-secondary btn-sm">
                                    <i class="fas fa-plus"></i>
                                </a>
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
                                                <a href="
                                                @if($service_type == 4)
                                                {{ route('ManageHrDiagnosis.editQuestion',$question->id) }}
                                                @elseif($service_type == 5)
                                                {{ route('Leader360Review.editQuestion',$question->id) }}
                                                @elseif($service_type == 3)
                                                {{ route('EmployeeEngagment.editQuestion',$question->id) }}
                                                @endif

                                                "
                                                    class="btn btn-primary btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                {{-- button to show sweetalert to confirm delete question --}}
                                                <button class="btn btn-danger btn-sm"
                                                    onclick="deleteQuestion({{ $question->id }})">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                <form id="deleteQuestion-{{ $question->id }}"
                                                    action="
                                                    @if($service_type == 4)
                                                    {{ route('ManageHrDiagnosis.deleteQuestion',$question->id)}}
                                                    @elseif($service_type == 5)
                                                    {{ route('Leader360Review.deleteQuestion',$question->id)}}
                                                    @elseif($service_type == 3)
                                                    {{ route('EmployeeEngagment.deleteQuestion',$question->id)}}
                                                    @endif
                                                    "
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
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
