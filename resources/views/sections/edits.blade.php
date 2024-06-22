<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

<div class="row @alignText" dir="@dir">
    <div class="form-group col-md-12">

        <input type="text" id="txtTitle" class="form-control" value="{{ $section->Title }}">
    </div>

    <div class="form-group col-md-12">
        Show In New Page
        {{-- @if (Model.IsHaveLineBefore == true)
        { --}}
        <input type="checkbox" id="ckhIsNewPage" @if($section->IsHaveLineBefore)checked @endif/>
        {{-- }
        else
        { --}}
        {{-- <input type="checkbox" id="ckhIsNewPage" /> --}}
        {{-- } --}}

    </div>
    <div class="form-group col-md-12">
        <label>@Resources.General.Details</label>
        <textarea name="editor1">{{ $section->Content }}</textarea>
        <script>
            CKEDITOR.replace('editor1', {
                extraPlugins: 'editorplaceholder',
                editorplaceholder: 'Start typing here Hello...',
            });
        </script>
    </div>
</div>


<div class="row">
    <div class="form-group col-md-12">
        {{-- @*<button id="btnSaveSection" class="btn btn-primary disabled">
            @Resources.General.Save
        </button>*@ --}}
    </div>
</div>

<div class="modal fade" id="explainModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true" style="z-index:10000;">
    <div class="modal-dialog" role="document" style="max-width: max-content">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changeImageModalLabel">@Resources.General.Explain</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{ $section->Descrip }}tion
            </div>
        </div>
    </div>
</div>

<script>
    $("#btnSaveSection").on("click", function () {

    });
</script>
