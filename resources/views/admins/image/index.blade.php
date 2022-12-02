@extends('layout.template')
@section('title')
Image
@endsection
@section('stylesheet')
<link href="{{asset('/assets/css/datatables.min.css')}}" rel="stylesheet" />
<link href="{{asset('/assets/css/dataTables.bootstrap5.css')}}" rel="stylesheet" />
<link href="{{asset('/assets/css/select.bootstrap5.min.css')}}" rel="stylesheet" />
<link href="{{asset('/assets/css/jquery-confirm.css')}}" rel="stylesheet" />
@endsection
@section('content')
<div class="container-fluid px-4">
    <div class="row mt-3">
        <div class="col-6">
            <h1>Image</h1>
        </div>
        <div class="col-6 text-end">
            <a class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createModal"><i class="fa-solid fa-plus"></i> เพิ่ม</a>
        </div>
    </div>

    <div class="row mb-3">
        <label for="productname" class="col-md-2 col-form-label">Product Image</label>
        <div class="col-md-4">
            <input type="file" class="form-control" id="fileupload" name="fileupload">
            <div id="fileuploadFeedback" class="invalid-feedback">
                Please use image file.
            </div>
            <div class="progress mt-2 d-none" id="progress">
                <div class="progress-bar progress-bar-striped bg-info progress-bar-animated" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <p id="complete" class="d-none">complete</p>
        </div>
        <div class="col-md-1">
            <button type="button" class="btn btn-outline-info" id="btn_upload">Upload</button>
        </div>
        <div class="col-md-3 text-center preview d-none">
            <img src="" class="rounded col-10" id="preview"/>
            <input type="hidden" id="imagepath" class="imagepath"/>
        </div>
        <div class="col-md-1 preview d-none">
            <button type="button" class="btn btn-outline-danger" id="btn_delete">Delete</button>
        </div>
    </div>




</div>
@endsection
@section('script')
<script src="{{asset('/assets/js/datatables.min.js')}}"></script>
<script src="{{asset('/assets/js/dataTables.bootstrap5.js')}}"></script>
<script src="{{asset('/assets/js/select.bootstrap5.min.js')}}"></script>
<script src="{{asset('/assets/js/jquery-confirm.js')}}"></script>
<script src="{{asset('/assets/js/validate.js')}}"></script>
<script>
    $(function(){
        $("#fileupload").change(function(){
            console.log('in');
        });
        $('#btn_upload').on('click',function(){
            var fd = new FormData();
            var files = $('#fileupload')[0].files;
            // Check file selected or not
            if(checkSelectFile('fileupload')){
                //check file image
                if(!checkFileImage('fileupload')){
                    $('#fileupload').addClass('is-invalid');
                    $('#fileuploadFeedback').html('Please select image file.');
                    return false
                }

                //check file size 5MB
                if(!checkFileSize('fileupload',5242880)){
                    $('#fileupload').addClass('is-invalid');
                    $('#fileuploadFeedback').html('File size more than 5MB.');
                    return false
                }

                fd.append('fileupload',files[0]);
                fd.append('title','image title');
                fd.append('description','image des');

                // $.ajax({
                //     url: '{{route('imageupload')}}',
                //     type: 'post',
                //     data: fd,
                //     contentType: false,
                //     processData: false,
                //     beforeSend: function( xhr ) {
                //         $('#progress').removeClass('d-none');
                //         $('#complete').addClass('d-none');
                //         $('.preview').addClass('d-none');
                //         $('#imagepath').val('');
                //     },
                //     success: function(response){
                //         $('#progress').addClass('d-none');
                //         $('#complete').removeClass('d-none');
                //         $('.preview').removeClass('d-none');
                //         $('#preview').attr('src','/'+response.file);
                //         $('#imagepath').val(response.file);
                //     },
                // });
            }else{
                $('#fileupload').addClass('is-invalid');
                $('#fileuploadFeedback').html('Please select a file.');
            }
        })
    })
</script>
@endsection
