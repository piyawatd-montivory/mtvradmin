<div class="mb-3 row mt-3">
    <label for="ogtitle" class="col-2 form-label">Title</label>
    <div class="col-10">
        <input type="text" id="ogtitle" name="ogtitle" class="form-control" value="{{$data->ogtitle}}">
    </div>
</div>
<div class="mb-3 row">
    <label for="ogimage" class="col-2 form-label">Image</label>
    <div class="col-2">
        <button type="button" class="btn btn-sm btn-outline-primary" id="ogimage-btn">
            Browse
        </button>
        <div id="ogimageHelp" class="form-text text-hint">
            Image Size 1200 x 630 pixels
        </div>
        <input type="hidden" id="ogimage" name="ogimage" value="{{$data->ogimageid}}">
        <div class="invalid-feedback">
            Please provide a valid image.
        </div>
    </div>
    <div class="col-5">
        <img id="displayogimage" class="img-thumbnail @if($data->ogimageid == '') d-none @endif" src="@if($data->ogimageid != '') {{$data->ogimage}} @endif"/>
    </div>
</div>
<div class="mb-3 row">
    <label for="description" class="col-2 form-label">Description</label>
    <div class="col-10">
        <textarea id="ogdescription" name="ogdescription" class="form-control" rows="4">{{$data->ogdescription}}</textarea>
        <div class="invalid-feedback">
            Please provide a valid social description.
        </div>
    </div>
</div>
<div class="mb-3 row">
    <label for="keyword" class="col-2 form-label">Keyword</label>
    <div class="col-10">
        <textarea id="keyword" name="keyword" class="form-control" rows="4">{{$data->keyword}}</textarea>
    </div>
</div>
