<div class="mb-3 row  mt-3">
    <label for="title" class="col-2 form-label">Title</label>
    <div class="col-10">
        <input type="text" class="form-control validate" id="title" name="title" placeholder="Title" value="{{$data->title}}">
        <div class="invalid-feedback">
            Please provide a valid title.
        </div>
    </div>
</div>
<div class="mb-3 row">
    <label for="slug" class="col-2 form-label">Slug</label>
    <div class="col-10">
        <input type="text" class="form-control validate" id="slug" name="slug" placeholder="Slug" value="{{isset($data->slug)?$data->slug:''}}">
        <input type="hidden" id="currentslug" name="currentslug" value="{{isset($data->slug)?$data->slug:''}}">
        <div class="invalid-feedback">
            Please provide a valid slug.
        </div>
    </div>
</div>
<div class="mb-3 row">
    <label for="active" class="col-2 form-label">Active</label>
    <div class="col-10">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="active" name="active" @if($data->active) checked @endif>
        </div>
    </div>
</div>
