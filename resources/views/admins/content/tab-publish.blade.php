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
<hr>
<h3>Scheduled</h3>
<div class="mb-3 row">
    <div class="col-12">
        <button id="scheduled-btn" class="btn btn-outline-primary btn-sm">Add</button>
    </div>
</div>
<div class="mb-3 row">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col-2">Action</th>
                    <th scope="col-4">Date Time</th>
                    <th scope="col-4">Create At</th>
                    <th scope="col-2"></th>
                </tr>
            </thead>
            <tbody id="scheduled-list">
                @foreach ($scheduleds as $item)
                    <tr>
                        <th scope="row">{{$item->action}}</th>
                        <td>{{$item->datetime}}</td>
                        <td>{{$item->createat}}</td>
                        <td>
                            <a class="btn btn-outline-danger del-schedule btn-sm" id="{{$item->id}}">Delete</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
