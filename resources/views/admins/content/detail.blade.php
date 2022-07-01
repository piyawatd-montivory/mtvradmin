<div class="row mb-3">
    <label for="shortdescription" class="col-sm-2 col-form-label">Short Description</label>
    <div class="col-md-10">
        <textarea class="form-control" rows="4" id="shortdescription" name="shortdescription">{{$content->shortdescription}}</textarea>
        <div class="invalid-feedback" id="validateshortdescription">
            Valid short description is required.
        </div>
    </div>
</div>
<div class="row mb-3">
    <label for="description" class="col-sm-2 col-form-label">Description</label>
    <div class="col-md-10">
        <textarea class="form-control" rows="4" id="description" name="description">{{$content->description}}</textarea>
    </div>
</div>
