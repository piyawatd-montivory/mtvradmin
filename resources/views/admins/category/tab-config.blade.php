<div class="mb-3 row  mt-3">
    <label for="title" class="col-2 form-label">Title</label>
    <div class="col-10">
        <input type="text" class="form-control validate" id="title" name="title" placeholder="Title" value="{{$data->title}}" @if(authuser()->role <> 'admin') readonly @endif>
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
        <input type="number" class="form-control validate" id="categoryorder" name="categoryorder" value="{{isset($data->categoryorder)?$data->categoryorder:'0'}}"  @if(authuser()->role <> 'admin') readonly @endif>
    </div>
</div>
<div class="mb-3 row">
    <label for="category" class="col-2 col-form-label">Parent</label>
    <div class="col-10">
        @if(authuser()->role == 'admin') 
            <select class="form-select" name="category" id="category">
                <option value="main" @selected($data->parent == 'main')>Main</option>
                @foreach ($categories as $category)
                    <option value="{{$category->id}}" @selected($data->parent == $category->id)>{{$category->name}}</option>
                @endforeach
            </select>
        @else
            @if($data->parent == 'main') 
                <input type="hidden" value="main" id="category" name="category"/>
                <input type="text" class="form-control" id="categoryname" name="categoryname" value="Main" readonly>
            @else
                @foreach ($categories as $category)
                    @if($category->id == $data->parent) 
                        <input type="hidden" value="{{$data->parent}}" id="category" name="category"/>
                        <input type="text" class="form-control" id="categoryname" name="categoryname" value="{{$category->name}}" readonly>
                    @endif
                @endforeach
            @endif
        @endif
        
    </div>
</div>