<div class="row mb-3">
    <label for="image" class="col-md-2 col-form-label">Image</label>
    <div class="col-md-6">
        <div class="input-group">
            <a class="btn btn-primary" id="imagebtn" data-input="image" data-preview="image_preview">
                <i class="far fa-image"></i> Choose
            </a>
            <input id="image" class="form-control" type="text" name="image" readonly>
        </div>
    </div>
    <div class="col-md-4" id="image_preview">
        @if(!empty($content->image))
            <img class="col-6" src="{{ $content->image }}">
        @endif
    </div>
</div>
<div class="row mb-3">
    <label for="title" class="col-sm-2 col-form-label">Title</label>
    <div class="col-md-10">
        <input type="text" class="form-control" id="title" name="title" placeholder="Title" value="{{$content->title}}" required>
        <div class="invalid-feedback" id="validatetitle">
            Valid Title is required.
        </div>
    </div>
</div>
<div class="row mb-3">
    <label for="alias" class="col-sm-2 col-form-label">Alias</label>
    <div class="col-md-10">
        <input type="text" class="form-control" id="alias" name="alias" placeholder="Alias" value="{{$content->alias}}" required>
        <div class="invalid-feedback" id="validatealias">
            Valid Alias is required.
        </div>
    </div>
</div>
<div class="row mb-3">
    <label for="author" class="col-sm-2 col-form-label">Author</label>
    <div class="col-md-10">
        <input type="text" class="form-control" id="author" name="author" placeholder="Author" value="{{$content->author}}" >
    </div>
</div>
<div class="row mb-3">
    <label for="position" class="col-sm-2 col-form-label">Position</label>
    <div class="col-md-10">
        <input type="text" class="form-control" id="position" name="position" placeholder="Position" value="{{$content->position}}" >
    </div>
</div>
<div class="row mb-3">
    <label for="sortorder" class="col-sm-2 col-form-label">Order</label>
    <div class="col-md-10">
        <input type="number" step="0.1" class="form-control" id="sortorder" name="sortorder" value="{{$content->sortorder}}" required>
    </div>
</div>
<div class="row mb-3">
    <label for="contenttype" class="col-sm-2 col-form-label">Type</label>
    <div class="col-md-10">
        <select class="form-control" id="contenttype" name="contenttype">
            <option value="testimonial" @selected('testimonial' == $content->contenttype)>Testimonial</option>
            <option value="benefit" @selected('benefit' == $content->contenttype)>Benefit</option>
        </select>
    </div>
</div>
