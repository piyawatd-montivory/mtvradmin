<div class="row mb-3">
    <label for="ogimage" class="col-md-2 col-form-label">Og Image</label>
    <div class="col-md-6">
        <div class="input-group">
            <a class="btn btn-primary" id="ogimagebtn" data-input="ogimage" data-preview="ogimage_preview">
                <i class="far fa-image"></i> Choose
            </a>
            <input id="ogimage" class="form-control" type="text" name="ogimage" readonly>
        </div>
    </div>
    <div class="col-md-4" id="ogimage_preview">
        @if(!empty($content->ogimage))
            <img class="col-6" src="{{ $content->ogimage }}">
        @endif
    </div>
</div>
<div class="row mb-3">
    <label for="twitterimage" class="col-md-2 col-form-label">Twitter Image</label>
    <div class="col-md-6">
        <div class="input-group">
            <a class="btn btn-primary" id="twitterimagebtn" data-input="twitterimage" data-preview="twitterimage_preview">
                <i class="far fa-image"></i> Choose
            </a>
            <input id="twitterimage" class="form-control" type="text" name="twitterimage" readonly>
        </div>
    </div>
    <div class="col-md-4" id="twitterimage_preview">
        @if(!empty($content->twitterimage))
            <img class="col-6" src="{{ $content->twitterimage }}">
        @endif
    </div>
</div>
<div class="row mb-3">
    <label for="keywords" class="col-sm-2 col-form-label">Keywords</label>
    <div class="col-md-10">
        <textarea class="form-control" rows="4" id="keywords" name="keywords">{{$content->keywords}}</textarea>
    </div>
</div>
