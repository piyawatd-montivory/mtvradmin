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
                {{-- <div class="row mb-3">
                    <label for="type" class="col-sm-2 col-form-label">Type</label>
                    <div class="col-md-10">
                        <select class="form-select" aria-label="Default select example" id="type" name="type" value="{{$skill->type}}">
                            <option value="Skill">Skill</option>
                            <option value="Interest">Interest</option>
                        </select>
                    </div>
                </div> --}}
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
<script>


    $(document).ready(function(){
        $('#fisrtname').focusout(function(){
            validateFirstName();
        });
        $('#lastname').focusout(function(){
            validateLastName();
        });
    });

    function submitform(){
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
