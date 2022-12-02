@extends('admins.template.template')
@section('title')
    Sign In
@endsection
@section('meta')

@endsection
@section('stylesheet')

@endsection
@section('content')
<div class="container mt-5">
    <!-- Content Row -->
    <div class="row justify-content-center">
        <div class="col-md-5 mt-5">
            <form id="formsignin">
                <div class="row mb-5 mt-5 text-center">
                    <div class="col-12">
                        <img src="{{asset('images/logo.png')}}" class="signin-logo"/>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="email" class="col-12 col-md-2 col-form-label">Email</label>
                    <div class="col-12 col-md-10">
                        <input type="text" class="form-control validate" id="email" name="email" placeholder="Email">
                        <div class="invalid-feedback">
                            Valid Email is required.
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="password" class="col-12 col-md-2 col-form-label">Password</label>
                    <div class="col-12 col-md-10">
                        <input type="password" class="form-control validate" id="password" name="password">
                        <div class="invalid-feedback" id="passerror">
                            Valid Password is required.
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-md-10 offset-md-2 pb-2">
                        <button class="btn btn-outline-primary btn-sm" id="signin-btn" type="submit">Sign In</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="{{asset('js/validate.js')}}"></script>
<script>

    $(function(){
        $('#formsignin').on('submit',function(){
            return false;
        })
        $('#signin-btn').on('click',function(){
            let email = $('#email').val();
            let password = $('#password').val();
            let pass = true;
            $.each($('.validate'),function(i,obj){
                if(isBlank($(obj).val())){
                    $(obj).addClass('is-invalid');
                    pass = false;
                }else{
                    $(obj).removeClass('is-invalid');
                }
            })
            if(pass){
                processModal.show();
                $.ajax({
                    url:'{{route('auth')}}',
                    method:"POST",
                    dataType:"JSON",
                    data:{email:email,password:password},
                    success:function(response){
                        if(response.result){
                            showAlert(true,'Signin success',true,'{{route('contentindex')}}',1000);
                        }else{
                            showAlert(false,response.message);
                        }
                    }
                })
            }
        })
    })
</script>
@endsection
