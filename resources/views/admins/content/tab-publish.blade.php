<div class="mb-3 row  mt-3">
    <div class="col-12">
        @if($data->status == 'draft')
            <button class="btn btn-sm btn-outline-success" type="button" id="publish">
                Publish
            </button>
            <button class="btn btn-sm btn-outline-warning d-none" type="button" id="unpublish">
                Unpublish
            </button>
            <button class="btn btn-sm btn-outline-warning" type="button" id="archive">
                Archive
            </button>
            <button class="btn btn-sm btn-outline-warning d-none" type="button" id="unarchive">
                Unarchive
            </button>
            <button class="btn btn-sm btn-outline-danger d-none" type="button" id="deletecontent">
                Delete
            </button>
        @endif
        @if($data->status == 'publish')
            <button class="btn btn-sm btn-outline-success d-none" type="button" id="publish">
                Publish
            </button>
            <button class="btn btn-sm btn-outline-warning" type="button" id="unpublish">
                Unpublish
            </button>
            <button class="btn btn-sm btn-outline-warning d-none" type="button" id="archive">
                Archive
            </button>
            <button class="btn btn-sm btn-outline-warning d-none" type="button" id="unarchive">
                Unarchive
            </button>
            <button class="btn btn-sm btn-outline-danger d-none" type="button" id="deletecontent">
                Delete
            </button>
        @endif
        @if($data->status == 'archive')
            <button class="btn btn-sm btn-outline-success d-none" type="button" id="publish">
                Publish
            </button>
            <button class="btn btn-sm btn-outline-warning d-none" type="button" id="unpublish">
                Unpublish
            </button>
            <button class="btn btn-sm btn-outline-warning d-none" type="button" id="archive">
                Archive
            </button>
            <button class="btn btn-sm btn-outline-warning" type="button" id="unarchive">
                Unarchive
            </button>
            <button class="btn btn-sm btn-outline-danger d-none" type="button" id="deletecontent">
                Delete
            </button>
        @endif
    </div>
</div>
<div class="mb-3 row">
    <label for="scheduled" class="col-2 form-label">Date</label>
    <div class="col-3">
        
    </div>
    <div class="col-3">

    </div>
</div>