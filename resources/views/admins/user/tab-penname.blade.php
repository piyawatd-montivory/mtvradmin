<div class="mt-3 row">
    <div class="col-12 text-end mb-2">
        <button type="button" class="btn btn-sm btn-outline-primary" id="btn-new-penname" @if($data->id == '') disabled @endif>
            New
        </button>
    </div>
    <div class="col-12">
        <div class="row" id="penname-list">
            @foreach ($data->pseudonyms as $pseudonym)
                <div class="col-12">
                    <div class="card mb-2">
                        <div class="card-body">
                            <div class="mb-3 row">
                                <div class="col-1 text-center">
                                    <img src="{{$pseudonym->image}}" class="penname-image">
                                </div>
                                <div class="col-4">
                                    <div class="row">
                                        <label for="penname" class="col-2 col-form-label">Name</label>
                                        <div class="col-10">
                                            <input type="text" readonly class="form-control-plaintext" id="penname" name="penname" value="{{$pseudonym->name}}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="title" class="col-2 col-form-label">Title</label>
                                        <div class="col-10">
                                            <input type="text" readonly class="form-control-plaintext" id="title" name="title" value="{{$pseudonym->title}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-5">
                                    <div class="row">
                                        <label for="description" class="col-3 col-form-label">Description</label>
                                        <div class="col-9">
                                            <textarea rows="3" readonly class="form-control-plaintext" id="description" name="description">{{$pseudonym->description}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2" pid="{{$pseudonym->id}}" pversion="{{$pseudonym->version}}" mid="{{$pseudonym->imageid}}" mversion="{{$pseudonym->imageversion}}" default="{{$pseudonym->default}}">
                                    <button type="button" class="btn btn-sm btn-outline-primary btn-edit-penname">Edit</button>
                                    @if(!$pseudonym->default)
                                    <button type="button" class="btn btn-sm btn-outline-danger btn-delete-penname">Delete</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>     
                </div>
            @endforeach
        </div>
    </div>
</div>