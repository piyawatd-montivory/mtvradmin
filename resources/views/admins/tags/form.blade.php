@extends('admins.template.template')
@section('title')
    Tags
@endsection
@section('meta')

@endsection
@section('stylesheet')

@endsection
@section('content')
<div class="container mt-3">
    <div class="h3 border-bottom border-primary text-primary">
        Tags : @if($data->id == '') New @else {{$data->name}} @endif
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <form id="formdata" action="#">
                <div class="row mt-2">
                    <div class="col-12 text-end mb-3">
                        <button name="submitbtn" id="submitbtn" class="btn btn-outline-primary btn-sm" type="button" onclick="javascript:buildData();">Save</button>
                        <a href="{{ route('tagsindex') }}" class="btn btn-outline-danger btn-sm">Cancel</a>
                    </div>
                    <div class="col-12">
                        <div class="alert alert-danger d-none" role="alert" id="error-report">
                            <ol id="error-list">

                            </ol>
                        </div>
                    </div>
                </div>
                @csrf
                <div class="row mb-3">
                    <label for="name" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-md-10">
                        <input type="hidden" id="currentname" name="currentname" value="{{$data->name}}">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{$data->name}}" required>
                        <div class="invalid-feedback">
                            Please provide a valid name.
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="id" class="col-sm-2 col-form-label">Id</label>
                    <div class="col-md-10">
                        <input type="hidden" id="currentid" name="currentid" value="{{$data->id}}">
                        <input type="text" class="form-control" id="id" name="id" placeholder="Id" value="{{$data->id}}" @if($data->id == '') required @else readonly @endif>
                        <div class="invalid-feedback">
                            Please provide a valid id.
                        </div>
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

    let cversion = {{$data->version}};

    $(document).ready(function(){
        $('#name').on('change',function(){
            checkName();
        });
        $('#id').on('change',function(){
            let slug = $('#id').val();
            $('#id').val(buildSlug(slug));
            checkId();
        });
    });

    const checkName = () => {
        let result = false;
        if($('#currentname').val() !== ''){
            if($('#currentname').val() === $('#name').val()){
                result = true;
            }
        }
        if(result){
            return result;
        }
        $.ajax({
                url:"{{route('checktagname')}}",
                method:"post",
                data:{name:$('#name').val()},
                async: false,
                cache: false,
                success:function(response){
                if(!response.result){
                    $('#name').val('');
                    $('#name').addClass('is-invalid');
                }else{
                    $('#name').removeClass('is-invalid');
                    result = true;
                }
            }
        })
        return result;
    }

    const checkId = () => {
        let result = false;
        if($('#currentid').val() !== ''){
            if($('#currentid').val() === $('#id').val()){
                result = true;
            }
        }
        if(result){
            return result;
        }
        $.ajax({
                url:"{{route('checktag')}}",
                method:"post",
                data:{id:$('#id').val()},
                async: false,
                cache: false,
                success:function(response){
                if(!response.result){
                    $('#id').val('');
                    $('#id').addClass('is-invalid');
                }else{
                    $('#id').removeClass('is-invalid');
                    result = true;
                }
            }
        })
        return result;
    }

    const reporterror = (name) => {
        let label = '';
        switch (name) {
            case 'name':
                label = 'Please provide a valid Name.';
                break
            case 'checkname':
                label = 'Name is ready to use.';
                break
            case 'id':
                label = 'Please provide a valid Id.';
                break
            case 'checkid':
                label = 'Id is ready to use.';
                break
        }
        $('#error-report').removeClass('d-none');
        $('#error-list').append(`<li>${label}</li>`);
    }


    const buildData = () => {
        let pass = true;
        $('#error-list').html('');
        $.each($('.validate'),function(i,obj){
            if($(obj).val().trim().length === 0){
                $(obj).addClass('is-invalid');
                reporterror($(obj).attr('name'));
                pass = false;
            }else{
                $(obj).removeClass('is-invalid');
            }
        })
        if(!checkName()){
            reporterror('checkname');
            pass = false;
        }
        if(!checkId()){
            reporterror('checkid');
            pass = false;
        }
        if(pass){
            let data = {};
            data.id = $('#id').val();
            data.version = cversion;
            data.name = $('#name').val();
            processModal.show();
            setTimeout(() => {
                $.ajax({
                    url:"{{route('tagscreate')}}",
                    method:"POST",
                    headers: {"X-CSRF-TOKEN": "{{ csrf_token() }}"},
                    data:{data:JSON.stringify(data)},
                    success:function(response){
                        // clear error report
                        $('#error-report').addClass('d-none');
                        $('#error-list').html('');
                        cversion = response.sys.version;
                        showAlert(true,'Save successful');
                        window.location.href = '/admins/tags/edit/'+response.sys.id;
                    }
                })
            },1000);
        }
    }

</script>
@endsection
