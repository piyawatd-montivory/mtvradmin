@extends('admins.template.template')
@section('title')
Team Montivory
@endsection
@section('meta')

@endsection
@section('stylesheet')

@endsection
@section('content')
<div class="container mt-5">
    <?php
    $headertitle = ' : New';
    $linkurl = route('montivorycreate');
    if (!empty($montivory->id)){
        $headertitle = ' : Update '.$montivory->firstname;
        $linkurl = route('montivoryupdate',['id'=>$montivory->id]);
    }
    ?>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Montivory {{$headertitle}}</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <form id="formdata" novalidate method="post" action="{{$linkurl}}">
                @csrf
                <input type="hidden" id="id" name="id" value="{{$montivory->id}}"/>
                <div class="row mb-3">
                    <label for="firstname" class="col-sm-2 col-form-label">First Name</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" id="firstname" name="firstname" placeholder="First Name" value="{{$montivory->firstname}}" required>
                        <div class="invalid-feedback" id="validatefirstname">
                            Valid First Name is required.
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="lastname" class="col-sm-2 col-form-label">Last Name</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Last Name" value="{{$montivory->lastname}}" required>
                        <div class="invalid-feedback" id="validatelastname">
                            Valid Last Name is required.
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
                        @if(!empty($montivory->image))
                            <img class="col-6" src="{{ $montivory->image }}">
                        @endif
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="job_position" class="col-sm-2 col-form-label">Job Position</label>
                    <div class="col-md-10">
                        <input type="text" name="job_position" id="job_position" value="{{$montivory->job_position}}" class="form-control"/>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="linkin_url" class="col-sm-2 col-form-label">LinkedIn URL</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" id="linkin_url" name="linkin_url" placeholder="Linkin URL" value="{{$montivory->linkedin_url}}" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="linkin_active" class="col-sm-2 col-form-label">LinkedIn Active</label>
                    <div class="col-md-9">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="linkin_active" name="linkin_active" @if( $montivory->linkedin_active == 0) checked @endif>
                            <label class="form-check-label" for="flexSwitchCheckDefault">Active</label>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="status_active" class="col-sm-2 col-form-label">Status Active</label>
                    <div class="col-md-9">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="status_active" name="status_active" @if( $montivory->status_active == 0) checked @endif>
                            <label class="form-check-label" for="flexSwitchCheckDefault">Active</label>
                        </div>
                    </div>
                </div>

                <hr class="mb-4">
                <button class="btn btn-outline-primary btn-sm" type="button" onClick="submitform();">Save</button>
                <a href="{{ route('montivoryindex') }}" class="btn btn-outline-danger btn-sm">Cancel</a>
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
        $('#firstname').focusout(function(){
            validateText('firstname');
        });
        $('#lastname').focusout(function(){
            validateText('lastname');
        });
        $('#job_position').focusout(function(){
            validateText('job_position');
        });
    });

    function submitform(){
        @if(empty($montivory->id))
        if(isBlank($('#image').val())){
            $('#image').removeClass('is-valid');
            $('#image').addClass('is-invalid');
            return false;
        }else{
            $('#image').removeClass('is-invalid');
            $('#image').addClass('is-valid');
        }
        @endif
        if(validateText('firstname') && validateText('lastname') && validateText('job_position')){
            $('#formdata').submit();
        }
    }

    function validateText(id){
        if(isBlank($('#'+id).val())){
            $('#'+id).removeClass('is-valid');
            $('#'+id).addClass('is-invalid');
            return false;
        }else{
            $('#'+id).removeClass('is-invalid');
            $('#'+id).addClass('is-valid');
            return true;
        }
    }

</script>
@endsection
