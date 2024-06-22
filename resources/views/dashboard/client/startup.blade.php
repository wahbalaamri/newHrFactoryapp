@extends('dashboard.layouts.main')
@section('content')
<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                {{-- create card for startup files --}}
                <div class="card mt-4">
                    <h5 class="card-header">Startup Files</h5>
                    <div class="card-body">
                        @if($active_sub)
                        <div class="row">
                            <div class="col-md-12">
                                {{-- create table for startup files --}}

                                {{-- end table --}}
                            </div>
                        </div>
                        @else
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-danger" role="alert">
                                    <h4 class="alert-heading">Warning!</h4>
                                    <p>You have not subscribed to any plan yet. Please subscribe to a plan to continue.
                                    </p>
                                    <hr>
                                    <p class="mb-0">Click <a href="#">here</a> to
                                        subscribe to a plan.</p>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
