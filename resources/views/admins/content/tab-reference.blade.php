<div class="mb-3 row  mt-3">
    <div class="col-12">
        <button type="button" id="ref-btn" name="ref-btn" class="btn btn-sm btn-outline-primary">Add</button>
    </div>
</div>
<div class="mb-3 row mt-3">
    <div class="col-12" id="card-ref-block">
        @foreach ($reference as $refitem)
            <div class="card mb-2">
                <div class="card-header">
                    <div class="row">
                    <div class="col-6">
                        Reference
                    </div>
                    <div class="col-6 text-end">
                        <button type="button" class="btn-close delete-reference"></button>
                    </div>
                    </div>
                </div>
                <div class="card-body card-body-reference" refid="{{$loop->index}}">
                    <div class="mb-3 row mt-3">
                        <label for="ref-title" class="col-md-1 col-4 form-label">Title</label>
                        <div class="col-md-3 col-8 mb-2">
                            <input type="text" class="form-control validate" id="ref-title{{$loop->index}}" name="ref-title{{$loop->index}}" placeholder="Title" value="{{$refitem->title}}">
                            <div class="invalid-feedback">
                                Please provide a valid title.
                            </div>
                        </div>
                        <label for="ref-link" class="col-md-1 col-4 form-label">Link</label>
                        <div class="col-md-7 col-8">
                            <input type="text" class="form-control validate" id="ref-link{{$loop->index}}" name="ref-link{{$loop->index}}" placeholder="Link" value="{{$refitem->link}}">
                            <div class="invalid-feedback">
                                Please provide a valid link.
                            </div>
                        </div>
                    </div>
                </div>
            </div>     
        @endforeach
    </div>
</div>