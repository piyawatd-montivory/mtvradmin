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
    <label for="page" class="col-2 col-form-label">Page</label>
    <div class="col-10 col-md-3">
        <select class="form-select" name="page" id="page">
            <option value="index">index</option>
            <option value="career">career</option>
        </select>
    </div>
    <div class="col-12 col-md-1 text-center mt-md-0 mt-2">
        <button type="button" class="btn btn-outline-primary btn-sm add-tag" id="page">Add</button>
    </div>
    <div class="col-12 col-md-6" id="page-listitem">
        @foreach ($data->page as $page)
            <span class="tag tag-label" id="{{$page}}">
            {{$page}}<span class="remove">x</span></span>
        @endforeach
    </div>
</div>
<div class="mb-3 row">
    <label for="session" class="col-2 col-form-label">Session</label>
    <div class="col-10 col-md-3">
        <select class="form-select" name="session" id="session">
            <option value="first">first</option>
            <option value="team-montivory">team-montivory</option>
            <option value="third">third</option>
            <option value="partner">partner</option>
            <option value="provide">provide</option>
            <option value="why-montivory">why-montivory</option>
            <option value="benefit">benefit</option>
            <option value="footer">footer</option>
        </select>
    </div>
    <div class="col-12 col-md-1 text-center mt-md-0 mt-2">
        <button type="button" class="btn btn-outline-primary btn-sm add-tag" id="session">Add</button>
    </div>
    <div class="col-12 col-md-6" id="session-listitem">
        @foreach ($data->session as $session)
            <span class="tag tag-label" id="{{$session}}">
            {{$session}}<span class="remove">x</span></span>
        @endforeach
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
