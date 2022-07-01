@extends('admins.template.template')
@section('title')
    Position
@endsection
@section('meta')

@endsection
@section('stylesheet')

@endsection
@section('content')
<div class="container mt-5">
    <?php
    $headertitle = ' : New';
    $linkurl = route('positioncreate');
    if (!empty($position->id)){
        $headertitle = ' : Update '.$position->name;
        $linkurl = route('positionupdate',['id'=>$position->id]);
    }
    ?>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Position {{$headertitle}}</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <form id="formdata" novalidate method="post" action="{{$linkurl}}">
                @csrf
                <input type="hidden" id="id" name="id" value="{{$position->id}}"/>
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
                    <label for="og_title" class="col-sm-2 col-form-label">Og Title</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" id="og_title" name="og_title" placeholder="Og title" value="{{$position->og_title}}" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="og_description" class="col-sm-2 col-form-label">Og Description</label>
                    <div class="col-md-10">
                        <textarea class="form-control" rows="4" id="og_description" name="og_description">{{$position->og_description}}</textarea>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="og_image" class="col-md-2 col-form-label">Og Image</label>
                    <div class="col-md-6">
                        <div class="input-group">
                            <a class="btn btn-primary" id="ogimagebtn" data-input="og_image" data-preview="og_image_preview">
                                <i class="far fa-image"></i> Choose
                            </a>
                            <input id="og_image" class="form-control" type="text" name="og_image" readonly>
                        </div>
                    </div>
                    <div class="col-md-4" id="og_image_preview">
                        @if(!empty($position->od_image))
                            <img class="col-6" src="{{ $positon->od_image }}">
                        @endif
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="og_locale" class="col-sm-2 col-form-label">Og Locale</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" id="og_locale" name="og_locale" placeholder="Og Locale" value="{{$position->og_locale}}" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="og_locale" class="col-sm-2 col-form-label">Og Locale</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" id="og_locale" name="og_locale" placeholder="Og Locale" value="{{$position->og_locale}}" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="fb_pages" class="col-sm-2 col-form-label">FB Pages</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" id="fb_pages" name="fb_pages" placeholder="FB Pages" value="{{$position->fb_pages}}" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="fb_app_id" class="col-sm-2 col-form-label">FB App id</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" id="fb_app_id" name="fb_app_id" placeholder="FB App id" value="{{$position->fb_app_id}}" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="fb_image" class="col-md-2 col-form-label">fb_image</label>
                    <div class="col-md-6">
                        <div class="input-group">
                            <a class="btn btn-primary" id="fb_imagebtn" data-input="fb_image" data-preview="fb_image_preview">
                                <i class="far fa-image"></i> Choose
                            </a>
                            <input id="fb_image" class="form-control" type="text" name="fb_image" readonly>
                        </div>
                    </div>
                    <div class="col-md-4" id="fb_image_preview">
                        @if(!empty($position->fb_image))
                            <img class="col-6" src="{{ $positon->fb_image }}">
                        @endif
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="twitter_image" class="col-md-2 col-form-label">twitter_image</label>
                    <div class="col-md-6">
                        <div class="input-group">
                            <a class="btn btn-primary" id="twitter_imagebtn" data-input="twitter_image" data-preview="twitter_image_preview">
                                <i class="far fa-image"></i> Choose
                            </a>
                            <input id="twitter_image" class="form-control" type="text" name="twitter_image" readonly>
                        </div>
                    </div>
                    <div class="col-md-4" id="twitter_image_preview">
                        @if(!empty($position->twitter_image))
                            <img class="col-6" src="{{ $positon->twitter_image }}">
                        @endif
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="status_active" class="col-sm-2 col-form-label">Status Active</label>
                    <div class="col-md-9">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="status_active">
                            <label class="form-check-label" for="flexSwitchCheckDefault">Inactive</label>
                        </div>
                    </div>
                </div>
                <hr class="mb-4">
                <button class="btn btn-outline-primary btn-sm" type="button" onClick="submitform();">Save</button>
                <a href="{{ route('positionindex') }}" class="btn btn-outline-danger btn-sm">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="{{asset('js/validate.js')}}"></script>
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script>


    $(document).ready(function(){
        $('#imagebtn').filemanager('image');
        $('#position').focusout(function(){
            validatePosition();
        });
        $('#short_description').focusout(function(){
            validateShortDescription();
        });
        $('#description').focusout(function(){
            validateDescription();
        });
    });

    function submitform(){
        @if(empty($position->id))
        if(isBlank($('#image').val())){
            $('#image').removeClass('is-valid');
            $('#image').addClass('is-invalid');
            return false;
        }else{
            $('#image').removeClass('is-invalid');
            $('#image').addClass('is-valid');
        }
        @endif
        if(validatePosition() && validateShortDescription() && validateDescription()){
            $('#formdata').submit();
        }
    }

    function validatePosition(){
        if(isBlank($('#position').val())){
            $('#position').removeClass('is-valid');
            $('#position').addClass('is-invalid');
            return false;
        }else{
            $('#position').removeClass('is-invalid');
            $('#position').addClass('is-valid');
            return true;
        }
    }

    function validateShortDescription(){
        if(isBlank($('#short_description').val())){
            $('#short_description').removeClass('is-valid');
            $('#short_description').addClass('is-invalid');
            return false;
        }else{
            $('#short_description').removeClass('is-invalid');
            $('#short_description').addClass('is-valid');
            return true;
        }
    }

    function validateDescription(){
        if(isBlank($('#description').val())){
            $('#description').removeClass('is-valid');
            $('#description').addClass('is-invalid');
            return false;
        }else{
            $('#description').removeClass('is-invalid');
            $('#description').addClass('is-valid');
            return true;
        }
    }

</script>
@endsection
