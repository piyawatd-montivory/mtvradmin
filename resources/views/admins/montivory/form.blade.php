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
                        @if(!empty($position->image))
                            <img class="col-6" src="{{ $position->image }}">
                        @endif
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="job_position" class="col-sm-2 col-form-label">Job Position</label>
                    <div class="col-md-10">
                        <select class="form-select" aria-label="Default select example" id="job_position" name="job_position" value="{{$montivory->job_position}}">
                            <option value="Accountant">Accountant</option>
                            <option value="Business Analysts">Business Analysts</option>
                            <option value="Business Consultant – Data Privacy Specialist">Business Consultant – Data Privacy Specialist</option>
                            <option value="Business Consultant Trainee">Business Consultant Trainee</option>
                            <option value="Business Consultant">Business Consultant</option>
                            <option value="Business Development Manager">Business Development Manager</option>
                            <option value="Business Development">Business Development</option>
                            <option value="Chief Executive Officer">Chief Executive Officer</option>
                            <option value="Chief Executive Officer">Chief Executive Officer</option>
                            <option value="Chief Experience Officer">Chief Experience Officer</option>
                            <option value="Content Curator">Content Curator</option>
                            <option value="Data Analyst Trainee">Data Analyst Trainee</option>
                            <option value="Data Analyst">Data Analyst</option>
                            <option value="Digital Marketing Strategist">Digital Marketing Strategist</option>
                            <option value="Head Of Digital Operation">Head Of Digital Operation</option>
                            <option value="Head of Marketing Technology">Head of Marketing Technology</option>
                            <option value="Head of Research and Human Behavior">Head of Research and Human Behavior</option>
                            <option value="Head of UX/UI and Authoring">Head of UX/UI and Authoring</option>
                            <option value="Human behavior Researcher">Human behavior Researcher</option>
                            <option value="Human Resources">Human Resources</option>
                            <option value="IT Manager">IT Manager</option>
                            <option value="Java Backend Developer">Java Backend Developer</option>
                            <option value="Junior Data Scientist">Junior Data Scientist</option>
                            <option value="Junior Technical Consultant">Junior Technical Consultant</option>
                            <option value="Lead-Technical Consultant">Lead-Technical Consultant</option>
                            <option value="Project Manager">Project Manager</option>
                            <option value="Senior Human behavior Researcher">Senior Human behavior Researcher</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="linkin_url" class="col-sm-2 col-form-label">LinkedIn URL</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" id="linkin_url" name="linkin_url" placeholder="Linkin URL" value="{{$montivory->linkin_url}}" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="linkin_active" class="col-sm-2 col-form-label">LinkedIn Active</label>
                    <div class="col-md-9">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="linkin_active">
                            <label class="form-check-label" for="flexSwitchCheckDefault">Inactive</label>
                        </div>
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
        $('#fisrtname').focusout(function(){
            validateFirstName();
        });
        $('#lastname').focusout(function(){
            validateLastName();
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
        if(validateName()){
            $('#formdata').submit();
        }
    }

    function validateFirtstName(){
        if(isBlank($('#firstname').val())){
            $('#firstname').removeClass('is-valid');
            $('#firstname').addClass('is-invalid');
            return false;
        }else{
            $('#firstname').removeClass('is-invalid');
            $('#firstname').addClass('is-valid');
            return true;
        }
    }
    function validateLastName(){
        if(isBlank($('#lastname').val())){
            $('#lastname').removeClass('is-valid');
            $('#lastname').addClass('is-invalid');
            return false;
        }else{
            $('#lastname').removeClass('is-invalid');
            $('#lastname').addClass('is-valid');
            return true;
        }
    }

</script>
@endsection
