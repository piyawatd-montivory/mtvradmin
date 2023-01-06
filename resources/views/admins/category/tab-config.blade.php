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
    <label for="order" class="col-2 form-label">Order</label>
    <div class="col-10">
        <input type="number" class="form-control validate" id="categoryorder" name="categoryorder" value="{{isset($data->categoryorder)?$data->categoryorder:'0'}}">
    </div>
</div>
<div class="mb-3 row">
    <label for="category" class="col-2 col-form-label">Parent</label>
    <div class="col-10">
        <select class="form-select" name="category" id="category">
            <option value="main" @selected($data->parent == 'main')>Main</option>
            @foreach ($categories as $category)
                <option value="{{$category->id}}" @selected($data->parent == $category->id)>{{$category->name}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="mb-3 row">
    <label for="banner" class="col-2 form-label">Banner</label>
    <div class="col-2">
        <button type="button" class="btn btn-sm btn-outline-primary" id="banner-btn">
            Browse
        </button>
        <div id="bannerHelp" class="form-text text-hint">
            Image Size 950 x 640 pixels
        </div>
        <input type="hidden" id="banner" name="banner" class="form-control validate" value="{{$data->bannerid}}">
        <div class="invalid-feedback">
            Please provide a valid Banner.
        </div>
    </div>
    <div class="col-5">
        <img id="displaybanner" class="img-banner @if($data->bannerid == '') d-none @endif" src="@if($data->bannerid != '') {{$data->banner}} @endif"/>
    </div>
</div>
