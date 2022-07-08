@extends('admins.template.template')
@section('title')
    Partner
@endsection
@section('meta')

@endsection
@section('stylesheet')

@endsection
@section('content')
<div class="container mt-5">
    <?php
    $headertitle = ' : New';
    $linkurl = route('partnercreate');
    if (!empty($partner->id)){
        $headertitle = ' : Update '.$partner->name;
        $linkurl = route('partnerupdate',['id'=>$partner->id]);
    }
    ?>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Partner {{$headertitle}}</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <form id="formdata" novalidate method="post" action="{{$linkurl}}">
                @csrf
                <input type="hidden" id="id" name="id" value="{{$partner->id}}"/>
                <div class="row mb-3">
                    <label for="logo" class="col-md-2 col-form-label">Logo</label>
                    <div class="col-md-6">
                        <div class="input-group">
                            <a class="btn btn-primary" id="logobtn" data-input="logo" data-preview="logo_preview">
                                <i class="far fa-image"></i> Choose
                            </a>
                            <input id="logo" class="form-control" type="text" name="logo" readonly>
                        </div>
                    </div>
                    <div class="col-md-4" id="logo_preview">
                        @if(!empty($partner->logo))
                            <img class="col-6" src="{{ $partner->logo }}">
                        @endif
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="name" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{$partner->name}}" required>
                        <div class="invalid-feedback" id="validatename">
                            Valid Name is required.
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="url" class="col-sm-2 col-form-label">Url</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" id="url" name="url" placeholder="https://www.example.com" value="{{$partner->url}}" required>
                        <div class="invalid-feedback" id="validateurl">
                            Valid Url is required.
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="sortorder" class="col-sm-2 col-form-label">Order</label>
                    <div class="col-md-10">
                        <input type="number" step="1" class="form-control" id="sortorder" name="sortorder" value="{{$partner->sortorder}}" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="description" class="col-sm-2 col-form-label">Description</label>
                    <div class="col-md-10">
                        <textarea class="form-control" rows="4" id="description" name="description">{{$partner->description}}</textarea>
                    </div>
                </div>
                <hr class="mb-4">
                <div class="row mb-3">
                    <div class="col-12 pb-2">
                        <button class="btn btn-outline-primary btn-sm" type="button" onClick="submitform();">Save</button>
                        <a href="{{ route('partnerindex') }}" class="btn btn-outline-danger btn-sm">Cancel</a>
                    </div>
                </div>
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
        $('#logobtn').filemanager('image');
        $('#name').focusout(function(){
            validateName();
        });
        $('#url').focusout(function(){
            validateUrl();
        });
    });

    function submitform(){
        @if(empty($partner->id))
        if(isBlank($('#logo').val())){
            $('#logo').removeClass('is-valid');
            $('#logo').addClass('is-invalid');
            return false;
        }else{
            $('#logo').removeClass('is-invalid');
            $('#logo').addClass('is-valid');
        }
        @endif
        if(validateName() && validateUrl()){
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

    function validateUrl(){
        if(isBlank($('#url').val())){
            $('#url').removeClass('is-valid');
            $('#url').addClass('is-invalid');
            return false;
        }else{
            $('#url').removeClass('is-invalid');
            $('#url').addClass('is-valid');
            return true;
        }
    }

</script>
@endsection
