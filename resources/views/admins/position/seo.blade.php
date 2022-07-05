<div class="row mb-3">
    <label for="og_title" class="col-sm-2 col-form-label">Og Title</label>
    <div class="col-md-10">
        <input type="text" class="form-control" id="og_title" name="og_title" placeholder="Og title" value="{{$position->og_title}}" required>
    </div>
</div>
<div class="row mb-3">
    <label for="og_description" class="col-sm-2 col-form-label">Og Description</label>
    <div class="col-md-10">
        <textarea class="form-control" rows="4" id="og_description" name="og_description">{{$position->og_description}}</textarea>
    </div>
</div>
<div class="row mb-3">
    <label for="og_image" class="col-md-2 col-form-label">Og Image</label>
    <div class="col-md-6">
        <div class="input-group">
            <a class="btn btn-primary" id="ogimagebtn" data-input="og_image" data-preview="og_image_preview">
                <i class="far fa-image"></i> Choose
            </a>
            <input id="og_image" class="form-control" type="text" name="og_image" readonly>
        </div>
    </div>
    <div class="col-md-4" id="og_image_preview">
        @if(!empty($position->od_image))
            <img class="col-6" src="{{ $positon->od_image }}">
        @endif
    </div>
</div>
<div class="row mb-3">
    <label for="og_locale" class="col-sm-2 col-form-label">Og Locale</label>
    <div class="col-md-10">
        <input type="text" class="form-control" id="og_locale" name="og_locale" placeholder="Og Locale" value="{{$position->og_locale}}" required>
    </div>
</div>
<div class="row mb-3">
    <label for="og_locale" class="col-sm-2 col-form-label">Og Locale</label>
    <div class="col-md-10">
        <input type="text" class="form-control" id="og_locale" name="og_locale" placeholder="Og Locale" value="{{$position->og_locale}}" required>
    </div>
</div>
<div class="row mb-3">
    <label for="fb_pages" class="col-sm-2 col-form-label">FB Pages</label>
    <div class="col-md-10">
        <input type="text" class="form-control" id="fb_pages" name="fb_pages" placeholder="FB Pages" value="{{$position->fb_pages}}" required>
    </div>
</div>
<div class="row mb-3">
    <label for="fb_app_id" class="col-sm-2 col-form-label">FB App id</label>
    <div class="col-md-10">
        <input type="text" class="form-control" id="fb_app_id" name="fb_app_id" placeholder="FB App id" value="{{$position->fb_app_id}}" required>
    </div>
</div>
<div class="row mb-3">
    <label for="fb_image" class="col-md-2 col-form-label">fb_image</label>
    <div class="col-md-6">
        <div class="input-group">
            <a class="btn btn-primary" id="fb_imagebtn" data-input="fb_image" data-preview="fb_image_preview">
                <i class="far fa-image"></i> Choose
            </a>
            <input id="fb_image" class="form-control" type="text" name="fb_image" readonly>
        </div>
    </div>
    <div class="col-md-4" id="fb_image_preview">
        @if(!empty($position->fb_image))
            <img class="col-6" src="{{ $positon->fb_image }}">
        @endif
    </div>
</div>
<div class="row mb-3">
    <label for="twitter_image" class="col-md-2 col-form-label">twitter_image</label>
    <div class="col-md-6">
        <div class="input-group">
            <a class="btn btn-primary" id="twitter_imagebtn" data-input="twitter_image" data-preview="twitter_image_preview">
                <i class="far fa-image"></i> Choose
            </a>
            <input id="twitter_image" class="form-control" type="text" name="twitter_image" readonly>
        </div>
    </div>
    <div class="col-md-4" id="twitter_image_preview">
        @if(!empty($position->twitter_image))
            <img class="col-6" src="{{ $positon->twitter_image }}">
        @endif
    </div>
</div>
