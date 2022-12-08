<div class="mt-3 row">
    <div class="col-6">
        <h3>Gallery</h3>
    </div>
    <div class="col-6 text-end">
        <button type="button" class="btn btn-sm btn-outline-primary" id="gallery-btn">
            Browse Image
        </button>
    </div>
    <div class="col-12">
        <div class="row" id="gallerydisplay">
            @foreach ($data->gallery as $gallery)
                <div class="col-4">
                    <div class="card mb-2">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-1"><i class="fa-solid fa-arrows-up-down-left-right move-class"></i></div>
                                <div class="col-11 text-end">
                                    <button type="button" class="btn-close delete-slide"></button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body card-body-slide">
                            <img src="{{$gallery->url}}" class="card-img card-slide-imgurl">
                            <div class="mb-3 mt-3">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control img-title" value="{{$gallery->title}}"/>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Link</label>
                                <input type="text" class="form-control img-link" value="{{$gallery->link}}"/>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
