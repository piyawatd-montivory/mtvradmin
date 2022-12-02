<div class="row mb-3">
    <label for="title" class="col-sm-2 col-form-label">Title</label>
    <div class="col-md-10">
        <input type="text" class="form-control" id="title" name="title" placeholder="Title" value="{{$data->title}}" required>
        <div class="invalid-feedback">
            Please provide a valid title.
        </div>
    </div>
</div>
<div class="row mb-3">
    <label for="slug" class="col-sm-2 col-form-label">Slug</label>
    <div class="col-md-10">
        <input type="text" class="form-control" id="slug" name="slug" placeholder="Slug" value="{{$data->slug}}" required>
        <input type="hidden" id="currentslug" name="currentslug" value="{{isset($data->slug)?$data->slug:''}}">
        <div class="invalid-feedback" id="validatealias">
            Please provide a valid slug.
        </div>
    </div>
</div>
<div class="mb-3 row">
    <label for="skill" class="col-2 col-form-label">Skill</label>
    <div class="col-10 col-md-3">
        <select class="form-select" name="skill" id="skill">
            @foreach ($skills as $skill)
                <option value="{{$skill}}">{{$skill}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-12 col-md-1 text-center mt-md-0 mt-2">
        <button type="button" class="btn btn-outline-primary btn-sm" id="add-skill">Add</button>
    </div>
    <div class="col-12 col-md-6" id="skill-listitem">
        @foreach ($data->skills as $skill)
            <span class="tag tag-label tag-skill" key="{{$skill}}">
                {{$skill}}<span class="remove">x</span>
            </span>
        @endforeach
    </div>
</div>
<div class="mb-3 row">
    <label for="interest" class="col-md-2 col-form-label">Interest</label>
    <div class="col-10 col-md-3">
        <select class="form-select" name="interest" id="interest">
            @foreach ($interests as $interest)
                <option value="{{$interest}}">{{$interest}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-12 col-md-1 text-center mt-md-0 mt-2">
        <button type="button" class="btn btn-outline-primary btn-sm" id="add-interest">Add</button>
    </div>
    <div class="col-12 col-md-6" id="interest-listitem">
        @foreach ($data->interests as $interest)
            <span class="tag tag-label tag-interest" key="{{$interest}}">
                {{$interest}}<span class="remove">x</span>
            </span>
        @endforeach
    </div>
</div>
<div class="mb-3 row">
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
<div class="row mb-3">
    <label for="active" class="col-sm-2 col-form-label">Active</label>
    <div class="col-md-9">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="active" name="active" @if( $data->active) checked @endif>
        </div>
    </div>
</div>
