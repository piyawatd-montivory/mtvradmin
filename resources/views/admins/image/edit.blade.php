@extends('admins.template.template')
@section('title')
    Image
@endsection
@section('meta')

@endsection
@section('stylesheet')
<style>
.img-thumbnail {
    max-width: 500px;
}
.dropzone{
  border: 2px dashed #000;
  height: 500px;
  width: 700px;
  border-radius: 5px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
}
.dropzone.active{
  border: 2px solid #eee;
}
.dropzone header{
  font-size: 30px;
  font-weight: 500;
  color: #000;
}
</style>
@endsection
@section('content')
<div class="container-fluid mt-5">
    <div class="h3 border-bottom border-primary text-primary">
        Edit Image
    </div>
    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <form id="imageform" action="#">
                <div class="mb-3">
                    <div class="col-12 mt-2 text-end">
                        <button name="submitbtn" id="submitbtn" class="btn btn-outline-primary btn-sm" type="button" onclick="javascript:save();">Save</button>
                        <a href="{{ route('imagesindex') }}" class="btn btn-outline-danger btn-sm">Cancel</a>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="mb-3 row">
                        <div class="col-12 text-center">
                            <img src="http:{{ $data->fields->file->{'en-US'}->url }}" class="img-thumbnail"/>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="title" class="col-2 col-form-label">Title</label>
                        <div class="col-10">
                            <input type="text" class="form-control validate" id="title" name="title" placeholder="Title" value="{{ $data->fields->title->{'en-US'} }}">
                            <div class="invalid-feedback">
                                Please provide a valid title.
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="description" class="col-2 col-form-label">Description</label>
                        <div class="col-10">
                            <textarea class="form-control" id="description" name="description">{{ isset($data->fields->description->{'en-US'})?$data->fields->description->{'en-US'}:'' }}</textarea>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="fileupload" class="col-2 col-form-label">Image</label>
                        <div class="col-10">
                            <input type="file" class="form-control file-upload" id="fileupload" name="fileupload">
                            <div id="fileuploadFeedback" class="invalid-feedback">
                                Please use image file.
                            </div>
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
    <script type="text/javascript">

        $(function(){
            $("#fileupload").change(function(){
                let files = $('#fileupload')[0].files;
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
                    if($('#title').val().trim().length === 0){
                        $('#title').val(files[0].name);
                    }
                }else{
                    $('#fileupload').addClass('is-invalid');
                    $('#fileuploadFeedback').html('Please select a file.');
                }
            });
        })

        const save = () => {
            let pass = true;
            $.each($('.validate'),function(i,obj){
                if($(obj).val().trim().length === 0){
                    $(obj).addClass('is-invalid');
                    pass = false;
                }else{
                    $(obj).removeClass('is-invalid');
                }
            })
            if(checkSelectFile('fileupload')){
                //check file image
                if(!checkFileImage('fileupload')){
                    $('#fileupload').addClass('is-invalid');
                    $('#fileuploadFeedback').html('Please select image file.');
                    pass = false;
                }

                //check file size 5MB
                if(!checkFileSize('fileupload',5242880)){
                    $('#fileupload').addClass('is-invalid');
                    $('#fileuploadFeedback').html('File size more than 5MB.');
                    pass = false;
                }
            }
            if(pass){
                let data = {};
                data.id = '{{$data->sys->id}}';
                data.version = {{$data->sys->version}};
                data.title = $('#title').val();
                data.description = $('#description').val();
                data.contentType = '{{$data->fields->file->{'en-US'}->contentType}}';
                data.filename = '{{$data->fields->file->{'en-US'}->fileName}}';
                data.url = '{{$data->fields->file->{'en-US'}->url}}';
                processModal.show();
                setTimeout(() => {
                    let files = $('#fileupload')[0].files;
                    // Check file selected or not
                    if(checkSelectFile('fileupload')){
                        let fd = new FormData();
                        fd.append('fileupload',files[0]);
                        fd.append('title',data.title);
                        fd.append('description',data.description);
                        fd.append('version',data.version);
                        fd.append('id',data.id);
                        $.ajax({
                            url: '{{route('imageupdatenewimage')}}',
                            type: 'post',
                            data: fd,
                            contentType: false,
                            processData: false,
                            headers: {"X-CSRF-TOKEN": "{{ csrf_token() }}"},
                            success: function(response){
                                $.ajax({
                                    url:'{{route('imagepublished')}}',
                                    method:"post",
                                    async: false,
                                    cache: false,
                                    data:{id:'{{$data->sys->id}}'},
                                    success:function(response){
                                        showAlert(true,'Update successful',true,'/admins/images/edit/{{$data->sys->id}}',1000);
                                    }
                                })
                            },
                        })
                    }else{
                        $.ajax({
                            url: '{{route('imageupdate')}}',
                            method:"POST",
                            headers: {"X-CSRF-TOKEN": "{{ csrf_token() }}"},
                            data:{data:JSON.stringify(data)},
                            success: function(response){
                                $.ajax({
                                    url:'{{route('imagepublished')}}',
                                    method:"post",
                                    async: false,
                                    cache: false,
                                    data:{id:'{{$data->sys->id}}'},
                                    success:function(response){
                                        showAlert(true,'Update successful',true,'/admins/images/edit/{{$data->sys->id}}',1000);
                                    }
                                })
                            },
                        })
                    }
                },1000);
            }
        }
    </script>
@endsection
