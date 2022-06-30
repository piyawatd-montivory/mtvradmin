@extends('admins.template.template')
@section('title')
    User
@endsection
@section('meta')

@endsection
@section('stylesheet')

@endsection
@section('content')
<div class="container mt-5">
    <?php
    $headertitle = ' : New';
    $linkurl = route('usercreate');
    if (!empty($user->id)){
        $headertitle = ' : Update '.$user->firstname.' '.$user->lastname;
        $linkurl = route('userupdate',['id'=>$user->id]);
    }
    ?>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">User {{$headertitle}}</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <form id="formdata" novalidate method="post" action="{{$linkurl}}">
                @csrf
                <input type="hidden" id="userid" name="userid" value="{{$user->id}}"/>
                <div class="row mb-3">
                    <label for="firstname" class="col-sm-2 col-form-label">Firstname</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Firstname" value="{{$user->firstname}}" required>
                        <div class="invalid-feedback" id="validatefirstname">
                            Valid Firstname is required.
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="lastname" class="col-sm-2 col-form-label">Lastname</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Lastname" value="{{$user->lastname}}" required>
                        <div class="invalid-feedback" id="validatelastname">
                            Valid Lastname is required.
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-md-10">
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{$user->email}}" required @if (!empty($user->id)) readonly @endif>
                        <div class="invalid-feedback" id="validateemail">
                            Valid Email is required.
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="password" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-md-10">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                        <small id="passwordHelpBlock" class="form-text text-muted">
                            Password ความยาวขั้นต่ำ 5 ตัวอักษร และ ต้องมีตัวอักษรตัวใหญ่ 1 ตัว ตัวเล็ก 1 ตัว ตัวเลข 1 ตัว เฉพาะภาษาอังกฤษ
                        </small>
                        <div class="invalid-feedback" id="validatepassword">
                            Password ห้ามว่าง
                        </div>
                    </div>
                </div>
                <hr class="mb-4">
                <button class="btn btn-outline-primary btn-sm" type="button" onClick="submitform();">Save</button>
                <a href="{{ route('userindex') }}" class="btn btn-outline-danger btn-sm">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="{{asset('js/validate.js')}}"></script>
<script>

    @if (empty($user->id))
        var emailcheck = false;
    @else
        var emailcheck = true;
    @endif

    $(function(){
        @if (empty($user->id))
        $('#email').focusout(function(){
            validateEmail();
        });
        @endif
    })

    function submitform(){
        if(!isName($('#firstname').val())){
            $('#firstname').removeClass('is-valid');
            $('#firstname').addClass('is-invalid');
            return false;
        }else{
            $('#firstname').removeClass('is-invalid');
            $('#firstname').addClass('is-valid');
        }

        @if (empty($user->id))
        if(!checkpassword()){
            return false;
        }
        @endif

        if(emailcheck){
            $('#formdata').submit();
        }else{
            $('#email').removeClass('is-valid');
            $('#email').addClass('is-invalid');
            $('#validateemail').text('Email ผิดรูปแบบ');
        }
    }

    function validateEmail(){
        var email = $('#email').val();
        if(!isEmail(email)){
            $('#email').removeClass('is-valid');
            $('#email').addClass('is-invalid');
            $('#validateemail').text('Email ผิดรูปแบบ');
            emailcheck = false;
        }else{
            $.ajax({
                url:"{{ route('checkemail') }}",
                method:"POST",
                data:{"email":$('#email').val()},
                success:function(response){
                    if(response.result){
                        $('#email').removeClass('is-valid');
                        $('#email').addClass('is-invalid');
                        $('#validateemail').html('Email ถูกใช้แล้ว');
                        emailcheck = false;
                    }else{
                        $('#email').removeClass('is-invalid');
                        $('#email').addClass('is-valid');
                        emailcheck = true;
                    }
                }
            })
        }
    }

    function checkpassword(){
        var password = $('#password').val().trim();
        var result = true;
        //check password length
        if(password.length < 5){
            $('#password').removeClass('is-valid');
            $('#password').addClass('is-invalid');
            $('#validatepassword').html('รหัสผ่านห้ามน้อยกว่า 5 ตัวอักษร');
            result = false;
        }else{
            var number = /([0-9])/;
            var alphabets = /([a-zA-Z])/;
            if (password.match(number) && password.match(alphabets)) {
                $('#password').removeClass('is-invalid');
                $('#password').addClass('is-valid');
            } else {
                $('#password').removeClass('is-valid');
                $('#password').addClass('is-invalid');
                $('#validatepassword').html('รหัสผ่านต้องมีตัวอักษรตัวใหญ่ 1 ตัว ตัวเล็ก 1 ตัว ตัวเลข 1 ตัว เฉพาะภาษาอังกฤษ');
                result = false;
            }
        }
        return result;
    }
</script>
@endsection
