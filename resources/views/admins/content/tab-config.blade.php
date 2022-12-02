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
    <label for="excerpt" class="col-2 form-label">Excerpt</label>
    <div class="col-10">
        <textarea id="excerpt" name="excerpt" class="form-control validate" rows="4">{{$data->excerpt}}</textarea>
        <div class="invalid-feedback">
            Please provide a valid excerpt.
        </div>
    </div>
</div>
<div class="mb-3 row">
    <label for="category" class="col-2 col-form-label">Category</label>
    <div class="col-10 col-md-3">
        <select class="form-select" name="category" id="category">
            @foreach ($categories as $category)
                <option value="{{$category->id}}">{{$category->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-12 col-md-1 text-center mt-md-0 mt-2">
        <button type="button" class="btn btn-outline-primary btn-sm" id="add-category">Add</button>
    </div>
    <div class="col-12 col-md-6" id="category-listitem">
        @foreach ($data->categories as $contentcategory)
            <span class="tag tag-label tag-category" id="{{$contentcategory->id}}" key="{{$contentcategory->id}}">
            {{$contentcategory->name}}<span class="remove">x</span></span>
        @endforeach
    </div>
</div>
<div class="mb-3 row">
    <label for="tag" class="col-2 col-form-label">Tag</label>
    <div class="col-10 col-md-3">
        <select class="form-select" name="tag" id="tag">
            @foreach ($tags as $tag)
                <option value="{{$tag->id}}">{{$tag->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-12 col-md-1 text-center mt-md-0 mt-2">
        <button type="button" class="btn btn-outline-primary btn-sm" id="add-tag">Add</button>
        <button type="button" class="btn btn-outline-primary btn-sm" id="new-tag">New</button>
    </div>
    <div class="col-12 col-md-6" id="tag-listitem">
        @foreach ($data->tags as $contenttag)
            <span class="tag tag-label tag-tag" id="{{$contenttag->id}}" key="{{$contenttag->name}}">
            {{$contenttag->name}}<span class="remove">x</span></span>
        @endforeach
    </div>
</div>
