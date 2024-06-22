@extends('dashboard.layouts.main')
@section('content')
<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                {{-- create card for Manual policy builder --}}
                <div class="card mt-4">
                    <h5 class="card-header">Manual Policy Builder</h5>
                    <div class="card-body">
                        @if($active_sub==null )
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
                        @else
                        @if ( !$policeMBFile ==null || $policeMBFile->name==null || $$policeMBFile->name_ar==null || $policeMBFile->logo==null)
                        {{-- allow user to create his own file --}}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-info" role="alert">
                                    <h4 class="alert-heading">Warning!</h4>
                                    <p>You have not created your HR policy file yet.
                                    </p>
                                    <hr>
                                    <p class="mb-0 text-capitalize">in bellow form you can set your file names and your logo</p>
                                </div>
                                {{-- form to setup file names and logo --}}
                                {!! Form::open(['action' => 'PolicyController@store', 'method'=>'POST','enctype' => 'multip
                                art/form-data']) !!}

                            </div>
                        </div>
                        @else
                        <div class="row">
                            <div class="col-md-12">
                            </div>
                        </div>
                        @endif

                        @endif
                    </div>
                </div>
                {{-- end card --}}
            </div>
        </div>
    </div>
</div>
@endsection
