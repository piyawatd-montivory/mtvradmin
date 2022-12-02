<div class="mb-3 row mt-3">
    <div class="col-md-6 col-12">
        <div class="row mb-3">
            <label for="pseudonym" class="col-4 col-form-label">Pseudonym</label>
            <div class="col-8">
                <select class="form-select" name="pseudonym" id="pseudonym">
                    @foreach ($pseudonyms as $pseudonym)
                        <option value="{{$pseudonym->id}}">{{$pseudonym->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-6 offset-4">
                <button type="button" class="btn btn-outline-primary btn-sm" id="add-pseudonym">Add</button>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-12">
        <div class="mb-3 row">
            <label for="pcredit" class="col-4 col-form-label">Credit</label>
            <div class="col-8">
                <select class="form-select" name="pcredit" id="pcredit">
                    @foreach ($publiccredits as $publiccredit)
                        <option value="{{$publiccredit->id}}">{{$publiccredit->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-6 offset-4">
                <button type="button" class="btn btn-outline-primary btn-sm" id="add-pcredit">Add</button>
            </div>
        </div>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-12" id="pseudonym-listitem">
        @if(isset($data->pseudonyms))
        @foreach ($data->pseudonyms as $contentpseudonym)
            <span class="tag tag-label tag-pseudonym" id="{{$contentpseudonym->id}}" key="{{$contentpseudonym->id}}">
            <input type="hidden" name="pseudonymkey[]" value="{{$contentpseudonym->id}}"/>{{$contentpseudonym->name}}<span class="remove">x</span></span> 
        @endforeach
        @endif
    </div>
</div>