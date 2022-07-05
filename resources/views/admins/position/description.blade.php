<div class="row mb-3">
    <label for="short_description" class="col-sm-2 col-form-label">Short Description</label>
    <div class="col-md-10">
        <textarea class="form-control" rows="3" id="short_description" name="short_description">{{$position->short_description}}</textarea>
        <div class="invalid-feedback" id="validateshortdescription">
            Valid Short Description is required.
        </div>
    </div>
</div>
<div class="row mb-3">
    <label for="description" class="col-sm-2 col-form-label">Description</label>
    <div class="col-md-10">
        <textarea class="form-control" rows="4" id="description" name="description">{{$position->description}}</textarea>
        <div class="invalid-feedback" id="validatedescription">
            Valid Description is required.
        </div>
    </div>
</div>
