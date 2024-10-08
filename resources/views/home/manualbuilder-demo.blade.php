{{-- extends --}}
@extends('layouts.main')
@section('styles')
    {{-- css file --}}
    <link rel="stylesheet" href="{{ asset('assets/css/treeView.css') }}">
@endsection
{{-- content --}}
{{-- show client details --}}
@section('content')
            <div class="container">
                <div class="row">
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
                                                                            @class(['btn btn-xs'])
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
                                                                                >
                                                                            <label class="custom-control-label"
                                                                                for="section_available_p{{ $section->id }}"></label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @php
                                                            $max_allowed = 0;
                                                        @endphp
                                                        @if (count($children) > 0)

                                                            <ul class="list-group d-none">
                                                                @foreach ($children as $child)
                                                                @php
                                                            $max_allowed++;
                                                        @endphp
                                                                    <li class="list-group-item"
                                                                        data-ordering="{{ $child->ordering }}"
                                                                        data-id="{{ $child->id }}"
                                                                        @disabled($max_allowed>2)
                                                                        >
                                                                        <div class="row">
                                                                            <div class="col-sm-8">
                                                                                {{ $child->title }}
                                                                            </div>
                                                                            <div class="col-sm-3">
                                                                                <div class="row">
                                                                                    <div class="col-sm-4">
                                                                                        <a href="javascript:void(0)"
                                                                                            @class(['btn btn-xs btn-warning', 'disabled' => $max_allowed>2])
                                                                                            @if($max_allowed<3)
                                                                                            onclick="ShowEdit({{ $child }})"
                                                                                            @endif
                                                                                            @disabled($max_allowed>2)
                                                                                            >
                                                                                            <i class="fa fa-edit"></i>
                                                                                        </a>
                                                                                    </div>
                                                                                    <div class="col-sm-4">
                                                                                        <a href="javascript:void(0)"
                                                                                            class="btn btn-xs btn-danger"
                                                                                            @if($max_allowed<3)
                                                                                            onclick="delectSection({{ $child->id }},'c')"
                                                                                            @endif
                                                                                            @disabled($max_allowed>2)>
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
                                                                                                @disabled($max_allowed>2)>
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
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox"
                                                                    class="custom-control-input"
                                                                    id="section_id_ed"
                                                                    >
                                                                <label class="custom-control-label"
                                                                    for="section_id_ed"></label>
                                                            </div>
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
                                                        id="saveSection">{{ __('Save') }}</a>
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
<!-- include summernote css/js -->
<link rel="stylesheet" href="{{ asset('dashboard/plugins/summernote/summernote-bs4.min.css') }}">
<script src="{{ asset('dashboard/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
    <script>
        var current_section_id;

        $('.summernote').summernote({
            tabsize: 2,
            height: 120,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
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

            if (current_section_id == section.id && (!$("#EditSection").hasClass('d-none'))) {
                console.log(`test ${current_section_id}`);

                $("#EditSection").addClass('d-none');
                //reset inputs
                $('[name="section_id"]').val('');
                $('#section_title').val('');
                $('.summernote').summernote('code', '');

                return;

            }
            current_section_id = section.id;
            $("#EditSection").removeClass('d-none');
            //set section_id
            $('[name="section_id"]').val(section.id);
            //set section_title
            $('#section_title').val(section.title);
            //set section_content
            //set show_in_new_page
            if (section.IsHaveLineBefore == 1) {
                // check section_id_ed
                $('#section_id_ed').attr('checked', true);

            } else {
                // uncheck section_id_ed
                $('#section_id_ed').attr('checked', false);
            }
            $('.summernote').summernote('code', section.content);
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
