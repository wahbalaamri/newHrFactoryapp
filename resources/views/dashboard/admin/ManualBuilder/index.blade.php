{{-- extends --}}
@extends('dashboard.layouts.main')
@section('styles')
    {{-- css file --}}
    <link rel="stylesheet" href="{{ asset('assets/css/treeView.css') }}">
@endsection
{{-- content --}}
{{-- show client details --}}
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <!-- /.col -->
                    <div class="col-sm-12">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item">Dashboard </li>
                            <li class="breadcrumb-item active">Manual Builder</li>
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
                    <div class="col-12 mt-3">
                        <div class="card card-outline card-success">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('HRFactory Manual builder is Available in') }}</h3>
                                {{-- tool --}}
                                <div class="card-tools">
                                    <button
                                        class="btn btn-sm btn-tool {{ App()->getLocale() == 'ar' ? 'float-start' : 'float-end' }}"
                                        data-toggle="modal" data-target="#AddNewCountry">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                {{-- list all available countries --}}
                                <div class="row">
                                    @if (count($available_countries) > 0)
                                        @foreach ($available_countries as $country)
                                            <div class="col-md-3 col-sm-6 col-12">
                                                <div class="info-box shadow-sm">
                                                    <span class="info-box-icon">
                                                        {{-- country flag --}}
                                                        <img src="https://www.worldatlas.com/r/w236/img/flag/{{ strtolower($country->country_code) }}-flag.jpg"
                                                            alt="{{ $country->country_name }}" width="50"
                                                            height="50">
                                                    </span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-text">{{ $country->country_name }}</span>
                                                        <span @class([
                                                            'info-box-number',
                                                            'text-right' => app()->isLocale('en'),
                                                            'text-left' => app()->isLocale('en'),
                                                        ])>
                                                            @if (count($plans) > 0)
                                                                @foreach ($plans as $plan)
                                                                    <a href="{{ route('manualBuilder.index', ['country' => $country->id, 'plan' => $plan->id]) }}"
                                                                        @class([
                                                                            'btn btn-xs',
                                                                            'btn-info' => $loop->odd,
                                                                            'btn-warning' => $loop->even,
                                                                        ])>
                                                                        <i class="fa fa-eye"></i>
                                                                        {{ __('View Sections of ') }}{{ $plan->plan_name }}
                                                                    </a>
                                                                @endforeach
                                                            @endif
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="col-md-3 col-sm-6 col-12">
                                            <div class="info-box shadow-sm">
                                                <span class="info-box-icon">
                                                    {{-- country flag --}}
                                                    <img src="https://www.worldatlas.com/r/w236/img/flag/{{ strtolower($default_country->country_code) }}-flag.jpg"
                                                        alt="{{ $default_country->country_name }}" width="50"
                                                        height="50">
                                                </span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">{{ $default_country->country_name }}</span>
                                                    <span @class([
                                                        'info-box-number',
                                                        'text-right' => app()->isLocale('en'),
                                                        'text-left' => app()->isLocale('en'),
                                                    ])>
                                                        @if (count($plans) > 0)
                                                            @foreach ($plans as $plan)
                                                                <a href="{{ route('manualBuilder.index', ['country' => $default_country->id, 'plan' => $plan->id]) }}"
                                                                    @class([
                                                                        'btn btn-xs',
                                                                        'btn-info' => $loop->odd,
                                                                        'btn-warning' => $loop->even,
                                                                    ])>
                                                                    <i class="fa fa-eye"></i>
                                                                    {{ __('View Sections of ') }}{{ $plan->plan_name }}
                                                                </a>
                                                            @endforeach
                                                        @else
                                                            <a href="{{ route('services.index') }}"
                                                                class="btn btn-xs btn-info">
                                                                {{ __('Manage Service Plans') }}
                                                            </a>
                                                        @endif

                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- create funcy card to display surveys --}}
                    <div class="col-12 mt-3">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    {{ __('Manage Manual Builder: ') }}({{ count($sections) > 0 ? $sections[0]->country->country_name : '' }})
                                </h3>
                                {{-- tool --}}
                            </div>
                            <div class="card-body">
                                <div class="row justify-content-center">
                                    @if (count($sections) > 0)
                                        <div class="col-md-4 col-sm-12">
                                            {{-- dragable items --}}
                                            <ul class="list-group">
                                                @foreach ($sections as $section)
                                                    @php
                                                        $children = $section->children()->get();
                                                    @endphp
                                                    <li class="list-group-item" data-ordering="{{ $section->ordering }}"
                                                        data-id="{{ $section->id }}">
                                                        <div class="row">
                                                            <div class="col-sm-8">
                                                                @if (count($children) > 0)
                                                                    <a href="javascript:void(0)"
                                                                        onclick="ParentClicked(this)"><i
                                                                            class="fa fa-plus text-success m-2"></i></a>
                                                                @endif
                                                                {{ $section->title }}
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <div class="row">
                                                                    <div class="col-sm-4">
                                                                        <a href="javascript:void(0)"
                                                                            class="btn btn-xs btn-warning"
                                                                            onclick="ShowEdit({{ $section }})">
                                                                            <i class="fa fa-edit"></i>
                                                                        </a>
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <a href="javascript:void(0)"
                                                                            @class([
                                                                                'btn btn-xs
                                                                                                                                                                                                                        btn-danger',
                                                                                'disabled' =>
                                                                                    count($partnerships_countries) > 0 &&
                                                                                    !in_array($section->country_id, $partnerships_countries),
                                                                            ])
                                                                            @disabled(count($partnerships_countries) > 0 && !in_array($section->country_id, $partnerships_countries))
                                                                            onclick="delectSection({{ $section->id }},'p')">
                                                                            <i class="fa fa-trash"></i>
                                                                        </a>
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <div class="custom-control custom-switch">
                                                                            <input type="checkbox"
                                                                                class="custom-control-input"
                                                                                @checked($section->IsActive)
                                                                                id="section_available_p{{ $section->id }}"
                                                                                @disabled(count($partnerships_countries) > 0 && !in_array($section->country_id, $partnerships_countries))
                                                                                onchange="updateSectionAvailablity(this,{{ $section->id }})">
                                                                            <label class="custom-control-label"
                                                                                for="section_available_p{{ $section->id }}"></label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @if (count($children) > 0)
                                                            <ul class="list-group d-none">
                                                                @foreach ($children as $child)
                                                                    <li class="list-group-item"
                                                                        data-ordering="{{ $child->ordering }}"
                                                                        data-id="{{ $child->id }}">
                                                                        <div class="row">
                                                                            <div class="col-sm-8">
                                                                                {{ $child->title }}
                                                                            </div>
                                                                            <div class="col-sm-3">
                                                                                <div class="row">
                                                                                    <div class="col-sm-4">
                                                                                        <a href="javascript:void(0)"
                                                                                            class="btn btn-xs btn-warning"
                                                                                            onclick="ShowEdit({{ $child }})">
                                                                                            <i class="fa fa-edit"></i>
                                                                                        </a>
                                                                                    </div>
                                                                                    <div class="col-sm-4">
                                                                                        <a href="javascript:void(0)"
                                                                                            class="btn btn-xs btn-danger"
                                                                                            @disabled(count($partnerships_countries) > 0 && !in_array($child->country_id, $partnerships_countries))
                                                                                            onclick="delectSection({{ $child->id }},'c')">
                                                                                            <i class="fa fa-trash"></i>
                                                                                        </a>
                                                                                    </div>
                                                                                    <div class="col-sm-4">
                                                                                        <div
                                                                                            class="custom-control custom-switch">
                                                                                            <input type="checkbox"
                                                                                                class="custom-control-input"
                                                                                                @checked($child->IsActive)
                                                                                                id="section_available_c{{ $child->id }}"
                                                                                                @disabled(count($partnerships_countries) > 0 && !in_array($child->country_id, $partnerships_countries))
                                                                                                onchange="updateSectionAvailablity(this,{{ $child->id }})">
                                                                                            <label
                                                                                                class="custom-control-label"
                                                                                                for="section_available_c{{ $child->id }}"></label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                            <div class="row mt-2">

                                                <div class="col-md-4 col-sm-12">
                                                    <a href="javascript:void(0)" class="btn btn-xs btn-success"
                                                        data-toggle="modal" data-target="#AddSectionModal">
                                                        <i class="fa fa-plus">
                                                        </i>
                                                        {{ __('Add Section') }}
                                                    </a>
                                                </div>
                                                <div class="col-md-4 col-sm-12">
                                                    <a href="javascript:void(0)" class="btn btn-xs btn-info">
                                                        <i class="fa fa-send">
                                                        </i>
                                                        {{ __('Share HR Policy') }}
                                                    </a>
                                                </div>
                                                <div class="col-md-4 col-sm-12">
                                                    <a href="javascript:void(0)" class="btn btn-xs btn-primary">
                                                        <i class="fa fa-download">
                                                        </i>
                                                        {{ __('Download HR Policy') }}
                                                    </a>

                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-md-8 col-sm-12">
                                            <div id="EditSection" class="d-none">
                                                <div class="form-group">
                                                    <input type="hidden" name="section_id">
                                                    <label for="section_title">{{ __('Section Title') }}</label>
                                                    <input type="text" class="form-control" id="section_title"
                                                        placeholder="Enter Section Title">
                                                </div>
                                                <div class="form-group">
                                                    {{-- switch --}}
                                                    <label for="show_in_new_page">
                                                        {{ __('Show in new Page') }}
                                                        <div class="col-12">
                                                            <input type="checkbox" name="show_in_new_page"
                                                                data-bootstrap-switch="" data-off-color="danger"
                                                                data-on-color="success" value="1">
                                                        </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="section_content">{{ __('Section Content') }}</label>
                                                    <textarea class="form-control summernote" id="section_content" rows="3" placeholder="Enter Section Content"></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <a href="javascript:void(0)" @class([
                                                        'btn btn-outline-success
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        btn-sm',
                                                        'float-right' => app()->isLocale('en'),
                                                        'float-left' => app()->isLocale('ar'),
                                                    ])
                                                        @if (Auth()->user()->user_type == 'partner' &&
                                                                count($partnerships_countries) > 0 &&
                                                                !in_array($country_id, $partnerships_countries)) disabled @endif
                                                        id="saveSection">{{ __('Save') }}</a>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        @if ($plan_id)
                                            @if (count($exist_plans_id) > 0)
                                                <div class="col-sm-12">
                                                    <div class="row justify-content-center">
                                                        @foreach ($exist_plans_id as $exist_id)
                                                            <div class="col-md-4 col-sm-12">
                                                                <a href="{{ route('manualBuilder.CopyPlanSections', ['country' => $country_id, 'id' => $exist_id, 'd_id' => $plan_id]) }}"
                                                                    class="btn btn-xs btn-info">
                                                                    <i class="fa fa-eye"></i>
                                                                    {{ __('Copy Section of ') }}{{ $plans->where('id', $exist_id)->first()->plan_name }}
                                                                </a>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="col-md-4 col-sm-12">
                                                <a href="javascript:void(0)" class="btn btn-xs btn-success"
                                                    data-toggle="modal" data-target="#AddSectionModal">
                                                    <i class="fa fa-plus">
                                                    </i>
                                                    {{ __('Add Section') }}
                                                </a>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    {{-- modal to AddNewCountry --}}
    <div class="modal fade" id="AddNewCountry" tabindex="-1" aria-labelledby="AddNewCountryLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="AddNewCountryLabel"> {{ __('Add Manual builder for new country') }}
                    </h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 col-sm-12 form-group">
                            <label for="" class="form-control-label">{{ __('Select Country to Add') }}</label>
                            <select name="" id="new_country" class="form-control">
                                <option value="">{{ __('Select Country') }}</option>
                                @if (auth()->user()->isAdmin)
                                    <optgroup label="{{ __('Arab Countries') }}">
                                        @foreach ($countries[1] as $country)
                                            <option value="{{ $country->id }}">{{ $country->country_name }}</option>
                                        @endforeach
                                    </optgroup>
                                    <optgroup label="{{ __('Foreign Countries') }}">
                                        @foreach ($countries[0] as $country)
                                            <option value="{{ $country->id }}">{{ $country->country_name }}</option>
                                        @endforeach
                                    </optgroup>
                                @else
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->country_name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        {{-- select plan --}}
                        <div class="col-md-6 col-sm-12 form-group">
                            <label for="" class="form-control-label">{{ __('Select Plan to Add') }}</label>
                            <select name="" id="new_plan" class="form-control">
                                <option value="">{{ __('Select Plan') }}</option>
                                @foreach ($plans as $plan)
                                    <option value="{{ $plan->id }}">{{ $plan->plan_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-12 form-group"><a href="" @class([
                            'btn btn-sm btn-outline-info',
                            'float-right' => app()->isLocale('en'),
                            'float-left' => app()->isLocale('ar'),
                        ])
                                id="add_new_country">{{ __('Save') }}</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- modal to add new section --}}
    <div class="modal fade" id="AddSectionModal" tabindex="-1" aria-labelledby="AddSectionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="AddSectionModalLabel">{{ __('Add Section') }}</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
                <form>
                    <div class="modal-body">
                        <div class="row">
                            {{-- select parent section --}}
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="section_title">{{ __('Section Title') }}</label>
                                <select name="parent" id="parent" class="form-control">
                                    <option value="">{{ __('Main Section') }}</option>
                                    @foreach ($sections as $section)
                                        <option value="{{ $section->id }}">{{ $section->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- section title --}}
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="new_section_title">{{ __('Section Title') }}</label>
                                <input type="text" class="form-control" id="new_section_title"
                                    placeholder="Enter Section Title">
                            </div>
                            {{-- switch --}}
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="show_in_new_page">
                                    {{ __('Show in new Page') }}
                                    <div class="col-12">
                                        <input type="checkbox" name="new_show_in_new_page" data-bootstrap-switch=""
                                            data-off-color="danger" data-on-color="success" value="1">
                                    </div>
                                </label>
                            </div>
                            {{-- section content --}}
                            <div class="form-group col-sm-12">
                                <label for="new_section_content">{{ __('Section Content') }}</label>
                                <textarea class="form-control summernote" id="new_section_content" rows="3"
                                    placeholder="Enter Section Content"></textarea>
                            </div>
                            {{-- submit --}}
                            <div class="form-group col-sm-12">
                                <a href="javascript:void(0)" @class([
                                    'btn btn-outline-info btn-sm',
                                    'float-right' => app()->isLocale('en'),
                                    'float-left' => app()->isLocale('ar'),
                                ])
                                    id="saveNewSection">{{ __('Save') }}</a>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
    <script>
        var current_section_id;
        $("[name='show_in_new_page']").bootstrapSwitch();
        $("[name='new_show_in_new_page']").bootstrapSwitch();
        $('.summernote').summernote({
            tabsize: 4,
            minHeight: 250,
            height: 250,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['fontSizeUnits', ['px', 'pt']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'help']]
            ]
        });
        var darggeditem_ordering;
        var targgeted_ordering;
        var currentDraggedItem_id;
        var targgeted_id;
        document.addEventListener('DOMContentLoaded', function() {
            var nestedSortables = [].slice.call(document.querySelectorAll('.list-group'));

            nestedSortables.forEach(function(nestedSortable) {
                new Sortable(nestedSortable, {
                    group: {
                        name: 'nested',
                        pull: function(to, from, dragEl) {
                            return dragEl.parentNode === to
                                .el; // Prevents dragging out of parent
                        },
                        put: false // Prevents items from being inserted into the parent
                    },
                    animation: 150,
                    fallbackOnBody: true,
                    swapThreshold: 0.65,
                    onStart: function(evt) {
                        currentDraggedItem = evt.item;
                        //get data-id of currentDraggedItem
                        currentDraggedItem_id = currentDraggedItem.getAttribute('data-id');
                        darggeditem_ordering = currentDraggedItem.getAttribute('data-ordering');
                    },
                    onEnd: function(evt) {
                        var replacedItem = evt.to.children[evt.oldIndex];
                        //get data-id of currentDraggedItem
                        targgeted_id = replacedItem.getAttribute('data-id');
                        targgeted_ordering = replacedItem.getAttribute('data-ordering');
                        //swap ordering
                        replacedItem.setAttribute('data-ordering', darggeditem_ordering)
                        currentDraggedItem.setAttribute('data-ordering', targgeted_ordering)
                        //update order
                        updateOrder(evt.to);
                    }
                });
            });

            function updateOrder(container) {
                var items = container.children;
                var orderData = [];
                //get current item
                for (var i = 0; i < items.length; i++) {
                    var item = items[i];
                    orderData.push({
                        id: item.getAttribute('data-id'),
                        ordering: item.getAttribute('data-ordering')
                    });
                }
                isPartner = "{{ Auth()->user()->user_type == 'partner' }}"
                P_Countries = @json($partnerships_countries);
                currentCountry = "{{ $country_id }}"
                if (isPartner && P_Countries.length > 0 && !P_Countries.includes(currentCountry)) {
                    toastr.error("{{ __('You are not allowed to edit this section') }}");
                    return;
                }
                //send ajax request
                $.ajax({
                    url: "{{ route('manualBuilder.reorder') }}",
                    type: 'POST',
                    data: {
                        orderData: orderData,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        console.log(response);
                    }
                });
            }
        });
        ParentClicked = (ctr1) => {
            //check if class fa-minus is exsit
            open_i = $(".fa-minus");
            if (open_i.length > 0) {
                //change fa-minus to plus
                open_i.removeClass('fa-minus');
                open_i.addClass('fa-plus');
                open_i.addClass('text-success');
                open_i.removeClass('text-warning');
                //hide ul
                open_i.closest('li').children('ul').addClass('d-none');
            }
            //get ctr child of ul
            ctr = $(ctr1).closest('li');
            ul = $(ctr).children('ul');
            //find childeren with class fa
            row = $(ctr).find('.row');
            col = $(row).find('div');
            //find i_childeren
            i_element = $(ctr1).children('i');
            if (ul.hasClass('d-none')) {
                ul.removeClass('d-none');
                //change fa-plus to minuse
                i_element.removeClass('fa-plus');
                i_element.addClass('fa-minus');
                i_element.removeClass('text-success');
                i_element.addClass('text-warning');
            } else {
                ul.addClass('d-none');
                //change fa-minus to plus
                i_element.removeClass('fa-minus');
                i_element.addClass('fa-plus');
                i_element.addClass('text-success');
                i_element.removeClass('text-warning');
            }
        }
        ShowEdit = (section) => {

            console.log(section.id);

            if (current_section_id == section.id && (!$("#EditSection").hasClass('d-none'))) {
                $("#EditSection").addClass('d-none');
                //reset inputs
                $('[name="section_id"]').val('');
                $('#section_title').val('');
                $('.summernote').summernote('code', '');
                $('[name="show_in_new_page"]').bootstrapSwitch('state', false);
                return;

            }
            current_section_id = section.id;
            $("#EditSection").removeClass('d-none');
            //set section_id
            $('[name="section_id"]').val(section.id);
            //set section_title
            $('#section_title').val(section.title);
            //set section_content
            $('.summernote').summernote('code', section.content);
            //set show_in_new_page
            if (section.IsHaveLineBefore == 1) {
                $('[name="show_in_new_page"]').bootstrapSwitch('state', true);
            } else {
                $('[name="show_in_new_page"]').bootstrapSwitch('state', false);
            }
        }
        //on saveSection clicked
        $('#saveSection').click(function() {
            var section_id = $('[name="section_id"]').val();
            var section_title = $('#section_title').val();
            var section_content = $('.summernote').summernote('code');
            var show_in_new_page = $('[name="show_in_new_page"]').bootstrapSwitch('state');
            isPartner = "{{ Auth()->user()->user_type == 'partner' }}"
            P_Countries = @json($partnerships_countries);
            currentCountry = "{{ $country_id }}"
            if (isPartner && P_Countries.length > 0 && !P_Countries.includes(currentCountry)) {
                toastr.error("{{ __('You are not allowed to edit this section') }}");
                return;
            }
            $.ajax({
                url: "{{ route('manualBuilder.update') }}",
                type: 'POST',
                data: {
                    id: section_id,
                    title: section_title,
                    section_content: section_content,
                    IsHaveLineBefore: show_in_new_page,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    console.log(response);
                    if (response.stat) {
                        //reset inputs
                        $('[name="section_id"]').val('');
                        $('#section_title').val('');
                        $('.summernote').summernote('code', '');
                        $('[name="show_in_new_page"]').bootstrapSwitch('state', false);
                        //hide edit section
                        $("#EditSection").addClass('d-none');
                        //success toastr
                        toastr.success("{{ __('Section Updated Successfully') }}");
                        //after 5 seconds reload page
                        setTimeout(() => {
                            location.reload();
                        }, 2000);
                    }
                }
            });
        });
        //on saveNewSection clicked
        $('#saveNewSection').click(function() {
            var parent = $('#parent').val();
            var plan = "{{ $plan_id }}";
            var country = "{{ $country_id }}";
            var section_title = $('#new_section_title').val();
            var section_content = $('#new_section_content').summernote('code');
            var show_in_new_page = $('[name="new_show_in_new_page"]').bootstrapSwitch('state');
            $.ajax({
                url: "{{ route('manualBuilder.store') }}",
                type: 'POST',
                data: {
                    parent: parent,
                    title: section_title,
                    section_content: section_content,
                    IsHaveLineBefore: show_in_new_page,
                    plan: plan,
                    country: "{{ $country_id }}",
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    console.log(response);
                    if (response.stat) {
                        //reset inputs
                        $('#parent').val('');
                        $('#section_title').val('');
                        $('.summernote').summernote('code', '');
                        $('[name="show_in_new_page"]').bootstrapSwitch('state', false);
                        //hide edit section
                        $("#AddSectionModal").modal('hide');
                        //reload
                        location.reload();
                    }
                }
            });
        });
        //on add_new_country clicked
        $('#add_new_country').click(function() {
            var country = $('#new_country').val();
            var plan = $('#new_plan').val();
            //check if all data setted
            if (country == '' || plan == '') {
                //toaster
                toastr.error("{{ __('Please select country and plan') }}");
                return;
            }
            $.ajax({
                url: "{{ route('manualBuilder.newCountry') }}",
                type: 'POST',
                data: {
                    new_country: country,
                    new_plan: plan,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    console.log(response);
                    if (response.stat) {
                        //reset inputs
                        $('#new_country').val('');
                        //hide edit section
                        $("#AddNewCountry").modal('hide');
                        //reload
                        location.reload();
                    }
                }
            });
        });
        //function updateSectionAvailablity
        function updateSectionAvailablity(control, section_id) {
            var section_id = section_id;
            //get the checkbox
            var isAvailabel = control.checked ? true : false;
            $.ajax({
                url: "{{ route('manualBuilder.updateSectionAvailablity') }}",
                type: 'POST',
                data: {
                    id: section_id,
                    IsActive: isAvailabel,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    console.log(response);
                }
            });
        }
        //delectSection
        function delectSection(section_id, type) {
            var section_id = section_id;
            var type = type;
            //sweetalert to confirm deleteing
            msg = type == "p" ? "{{ __('Are you sure you want to delete this section and its sub-sections?') }}" :
                "{{ __('Are you sure you want to delete this sub section?') }}";

            swal.fire({
                title: "{{ __('Are you sure?') }}",
                text: msg,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: "{{ route('manualBuilder.deleteSection') }}",
                        type: 'POST',
                        data: {
                            id: section_id,
                            type: type,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            console.log(response);
                            if (response.stat) {
                                Swal.fire({
                                    title: "Deleted!",
                                    text: "Your file has been deleted.",
                                    icon: "success"
                                });
                                //reload
                                location.reload();
                            }
                        }
                    });
                }
            });
        }
    </script>
@endsection
