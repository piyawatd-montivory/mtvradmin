<div class="mb-3 row mt-3">
    <label for="thumbnail" class="col-2 form-label">Thumbnail</label>
    <div class="col-2">
        <button type="button" class="btn btn-sm btn-outline-primary" id="thumbnail-btn">
            Browse
        </button>
        <div id="thumbnailHelp" class="form-text text-hint">
            Image Size 950 x 640 pixels
        </div>
        <input type="hidden" id="thumbnail" name="thumbnail" class="form-control validate" value="{{$data->thumbnailid}}">
        <div class="invalid-feedback">
            Please provide a valid Thumbnail.
        </div>
    </div>
    <div class="col-5">
        <img id="displaythumbnail" class="img-thumbnail @if($data->thumbnailid == '') d-none @endif" src="@if($data->thumbnailid != '') {{$data->thumbnail}} @endif"/>
    </div>
</div>
<div class="row">
    <label for="heroimage" class="col-2 form-label">Hero Image</label>
    <div class="col-2">
        <button type="button" class="btn btn-sm btn-outline-primary" id="heroimage-btn">
            Browse
        </button>
        <div id="heroimageHelp" class="form-text text-hint">
            Image Size 1188 x 660 pixels
        </div>
        <input type="hidden" id="heroimage" name="heroimage" class="validate" value="{{$data->heroimageid}}">
        <div class="invalid-feedback">
            Please provide a valid Hero Image.
        </div>
    </div>
    <div class="col-5">
        <img id="displayheroimage" class="img-thumbnail @if($data->heroimageid == '') d-none @endif" src="@if($data->heroimageid != '') {{$data->heroimage}} @endif"/>
    </div>
</div>
