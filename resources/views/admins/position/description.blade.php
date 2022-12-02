<div class="mb-3 row">
    <label for="excerpt" class="col-2 form-label">Excerpt</label>
    <div class="col-10">
        <textarea id="excerpt" name="excerpt" class="form-control validate" rows="4">{{$data->excerpt}}</textarea>
        <div class="invalid-feedback">
            Please provide a valid Excerpt.
        </div>
    </div>
</div>
<div class="row mb-3">
    <label for="description" class="col-sm-2 col-form-label">Description</label>
    <div class="col-md-10">
        <textarea class="form-control" rows="4" id="description" name="description">{{$data->description}}</textarea>
        <div class="invalid-feedback" id="validatedescription">
            Please provide a valid Description.
        </div>
    </div>
</div>
