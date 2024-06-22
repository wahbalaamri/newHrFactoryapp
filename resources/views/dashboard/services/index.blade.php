@extends('dashboard.layouts.main')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Services</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Service</li>
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
                {{-- show all services --}}
                @foreach ($services as $service)
                <div class="col-md-3">
                    <div @class(['card card-outline', 'card-info'=> $loop->odd,
                        'card-success' => $loop->even,
                        ])>
                        <div class="card-header">
                            <h3 class="card-title">{{ $service->name }}</h3>
                        </div>
                        <div class="card-body text-center" style="max-height: 18.4rem !important;min-height: 14.4rem;">

                            <img class="img-thumbnail" height="100" width="100"
                                src="{{ asset('uploads/services/images/'.$service->service_media_path) }}"
                                alt="{{ $service->name }}">
                            <div class="d-flex flex-column justify-content-end">
                                <p class="card-text text-white pb-2 pt-1">{!! $service->description !!}</p>
                            </div>

                        </div>
                        <div class="card-footer">
                            <div class="row justify-content-center">
                                @can('view',$service)
                                <div class="col-md-3 col-sm-12 m-2 text-center">
                                    <a href="{{ route('services.show', $service->id) }}"
                                        class="btn btn-primary btn-xs"><i class="fa fa-eye"></i></a>
                                </div>
                                @endcan
                                @can('update',$service)
                                <div class="col-md-3 col-sm-12 m-2 text-center"><a
                                        href="{{ route('services.edit', $service->id) }}"
                                        class="btn btn-warning btn-xs"><i class="fa fa-edit"></i></a>
                                </div>
                                @endcan
                                @can('delete',$service)
                                <div class="col-md-3 col-sm-12 m-2 text-center"><a
                                        href="{{ route('services.show', $service->id) }}"
                                        class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>
                                </div>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                {{-- add new service button --}}
                @can('create',new App\Models\Services)
                <div class="col-md-3">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Add New Service</h3>
                        </div>
                        <div class="card-body" style="min-height: 18.4rem;">
                            <div class="row justify-content-center">
                                <img src="{{ asset('assets/img/HR-1024x631.jpg') }}" class="card-img-top">
                                <a href="{{ route('services.create') }}"
                                    class="btn btn-secondary text-sm w-100 btn-xs mt-5">
                                    {{-- plus icon large --}}
                                    <i class="fas fa-plus"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endcan
            </div>
        </div>
    </section>
</div>
@endsection
