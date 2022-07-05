<div class="row mb-3">
    <label for="position" class="col-sm-2 col-form-label">Position</label>
    <div class="col-md-10">
        <input type="text" class="form-control" id="position" name="position" placeholder="Position" value="{{$position->position}}" required>
        <div class="invalid-feedback" id="validateposition">
            Valid Position is required.
        </div>
    </div>
</div>
<div class="row mb-3">
    <label for="alias" class="col-sm-2 col-form-label">Alias</label>
    <div class="col-md-10">
        <input type="text" class="form-control" id="alias" name="alias" placeholder="Alias" value="{{$position->alias}}" required>
        <div class="invalid-feedback" id="validatealias">
            Valid Alias is required.
        </div>
    </div>
</div>
<div class="row mb-3">
    <label for="skill" class="col-md-2 col-form-label">Skill</label>
    <div class="col-md-2">
        <button type="button" class="btn btn-outline-primary" onClick="javascript:skillModal.toggle()">
            Skill <i class="fa-solid fa-plus"></i>
        </button>
    </div>
    <div class="col-7" id="skill-listitem">
        @foreach ($positionskills as $pskill)
            @if($pskill->skill)
                @foreach ($skills as $skill)
                    @if($skill->id == $pskill->skill)
                        <span class="tag tag-label" id="{{ $skill->id }}">
                        <input type="hidden" name="skillid[]" value="{{ $skill->id }}"/>{{ $skill->name }}<span class="remove">x</span></span>
                        @break
                    @endif
                @endforeach
            @endif
        @endforeach
    </div>
</div>
<div class="row mb-3">
    <label for="interest" class="col-md-2 col-form-label">Interest</label>
    <div class="col-md-2">
        <button type="button" class="btn btn-outline-primary" onClick="javascript:interestModal.toggle()">
            Interest <i class="fa-solid fa-plus"></i>
        </button>
    </div>
    <div class="col-7" id="interest-listitem">
        @foreach ($positionskills as $pskill)
            @if($pskill->interest)
                @foreach ($interests as $interest)
                    @if($interest->id == $pskill->interest)
                        <span class="tag tag-label" id="{{ $interest->id }}">
                        <input type="hidden" name="interestid[]" value="{{ $interest->id }}"/>{{ $interest->name }}<span class="remove">x</span></span>
                        @break
                    @endif
                @endforeach
            @endif
        @endforeach
    </div>
</div>
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
        @if(!empty($position->image))
            <img class="col-6" src="{{ $position->image }}">
        @endif
    </div>
</div>
<div class="row mb-3">
    <label for="status_active" class="col-sm-2 col-form-label">Status Active</label>
    <div class="col-md-9">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="status_active" @if( $position->status_active == 0) checked @endif>
            <label class="form-check-label" for="flexSwitchCheckDefault">Active</label>
        </div>
    </div>
</div>
