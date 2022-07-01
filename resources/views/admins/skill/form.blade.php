@extends('admins.template.template')
@section('title')
Skill, Interest
@endsection
@section('meta')

@endsection
@section('stylesheet')

@endsection
@section('content')
<div class="container mt-5">
    <?php
    $headertitle = ' : New';
    $linkurl = route('skillcreate');
    if (!empty($skill->id)){
        $headertitle = ' : Update '.$skill->name;
        $linkurl = route('skillupdate',['id'=>$skill->id]);
    }
    ?>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Name {{$headertitle}}</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <form id="formdata" novalidate method="post" action="{{$linkurl}}">
                @csrf
                <input type="hidden" id="id" name="id" value="{{$skill->id}}"/>
                <div class="row mb-3">
                    <label for="name" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{$skill->name}}" required>
                        <div class="invalid-feedback" id="validateposition">
                            Valid Name is required.
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="type" class="col-sm-2 col-form-label">Type</label>
                    <div class="col-md-10">
                        <select class="form-select" aria-label="Default select example" id="type" name="type" value="{{$skill->type}}">
                            <option value="Skill">Skill</option>
                            <option value="Interest">Interest</option>
                        </select>
                    </div>
                </div>
                <hr class="mb-4">
                <button class="btn btn-outline-primary btn-sm" type="button" onClick="submitform();">Save</button>
                <a href="{{ route('skillindex') }}" class="btn btn-outline-danger btn-sm">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="{{asset('js/validate.js')}}"></script>
<script>


    $(document).ready(function(){
        $('#name').focusout(function(){
            validateName();
        });
    });

    function submitform(){
        if(validateName()){
            $('#formdata').submit();
        }
    }

    function validateName(){
        if(isBlank($('#name').val())){
            $('#name').removeClass('is-valid');
            $('#name').addClass('is-invalid');
            return false;
        }else{
            $('#name').removeClass('is-invalid');
            $('#name').addClass('is-valid');
            return true;
        }
    }

</script>
@endsection
