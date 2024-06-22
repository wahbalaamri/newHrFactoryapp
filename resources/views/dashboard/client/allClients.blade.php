@extends('dashboard.layouts.main')
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
            <!-- Small boxes (Stat box) -->
            <div class="row">

                <!-- ./col -->
            </div>
            <!-- /.row -->
            <!-- Main row -->
            <div class="row">
                <!-- Left col -->
                <section class="connectedSortable w-100">
                    <!-- Custom tabs (Charts with tabs)-->
                    <div class="card card-outline card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-users mr-1"></i>
                                {{ __('List of All Clients') }}
                            </h3>
                            <div class="card-tools">
                            </div>
                        </div><!-- /.card-header -->
                        {{-- card body --}}
                        <div class="card-body">
                            <div id="table-warraper">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6"></div>
                                    <div class="col-sm-12 col-md-6"></div>
                                </div>
                                <div class="table-responsive">
                                    <table
                                        class="table table-bordered table-striped table-bordered dataTable dtr-inline"
                                        id="ClientsTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>{{ __('Name') }}</th>
                                                <th>{{ __('Focal Point Name') }}</th>
                                                <th>{{__('Focal Point Email')}}</th>
                                                <th>{{__('Focal Point Phone')}}</th>
                                                <th>{{__('Company Phone')}}</th>
                                                <th>{{__('Status')}}</th>
                                                <th>{{__('Subscription')}}</th>
                                                <th>{{__('Created At')}}</th>
                                                <th colspan="3">{{__('Actions')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($clients)>0)
                                            @foreach ($clients as $client)
                                            <tr>
                                                <td>
                                                    {{ $loop->iteration }}
                                                </td>
                                                <td>
                                                    {{ $client->name }}
                                                </td>
                                                <td>
                                                    {{ $client->focalPoint->first()->name }}
                                                </td>
                                                <td>
                                                    {{ $client->focalPoint->first()->email }}
                                                </td>
                                                <td>
                                                    {{ $client->focalPoint->first()->phone }}
                                                </td>
                                                <td>
                                                    {{ $client->phone??'N/A' }}
                                                </td>
                                                <td>
                                                    @if($client->deleted_at==null) <span class='badge bg-success'>{{
                                                        __('Active')
                                                        }}</span>@else<span class='badge bg-danger'>{{ __('Inactive')
                                                        }}</span>@endif
                                                </td>
                                                <td>
                                                    {{-- view Client subscriptions page --}}
                                                    <a href="{{ route('clients.manage', $client->id) }}"
                                                        class="btn btn-info btn-sm">
                                                        <i class="fas fa-eye"></i>
                                                        {{ __('Client subscriptions') }}
                                                    </a>
                                                </td>
                                                <td>
                                                    {{ $client->created_at }}
                                                </td>
                                                <td>
                                                    <a href="{{-- {{ route('client.show', $client->id) }} --}}"
                                                        class="btn btn-info btn-sm">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="{{-- {{ route('client.edit', $client->id) }} --}}"
                                                        class="btn btn-primary btn-sm">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    {{-- delete --}}
                                                    <form action="{{-- {{ route('client.destroy', $client->id) }} --}}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>

                                                </td>
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr>
                                                <td colspan="9" class="text-center">{{__('No Clients Found')}}</td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </section>
                <!-- /.Left col -->
            </div>
        </div>
    </section>
</div>
@endsection
@section('scripts')
<script>
    $(function () {
      $("#example1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
      $('#ClientsTable').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });
</script>
@endsection
