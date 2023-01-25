@extends('admins.template.template')
@section('title')
    Image
@endsection
@section('meta')

@endsection
@section('stylesheet')
<style>
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
        New Image
    </div>
    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <form id="imageform" action="#">
                <div class="mb-3">
                    <div class="col-12 mt-2 text-end">
                        <button name="submitbtn" id="submitbtn" class="btn btn-outline-primary btn-sm" type="button" onclick="javascript:upload();">Save</button>
                        <a href="{{ route('imagesindex') }}" class="btn btn-outline-danger btn-sm">Cancel</a>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="row">
                        <div class="dropzone col-6">
                            <header>Drag & Drop to Upload File</header>
                        </div>
                        <div class="col-6" id="upload-block">

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

        const dropArea = document.querySelector(".dropzone"),dragText = dropArea.querySelector("header");
        let file;

        // preventing page from redirecting
        $("html").on("dragover", function(e) {
            e.preventDefault();
            e.stopPropagation();
        });
        $("html").on("drop", function(e) { e.preventDefault(); e.stopPropagation(); });

        //If user Drag File Over DropArea
        dropArea.addEventListener("dragover", (event)=>{
            event.preventDefault(); //preventing from default behaviour
            dropArea.classList.add("active");
            dragText.textContent = "Release to Upload File";
        });
        //If user leave dragged File from DropArea
        dropArea.addEventListener("dragleave", ()=>{
            dropArea.classList.remove("active");
            dragText.textContent = "Drag & Drop to Upload File";
        });
        //If user drop File on DropArea
        dropArea.addEventListener("drop", (event)=>{
            event.preventDefault(); //preventing from default behaviour
            file = event.dataTransfer.files;
            // console.log(file);
            $.each(event.dataTransfer.files,function(index,value){
                let list = new DataTransfer();
                list.items.add(value);
                let fileListObj = list.files;
                let pass = true;
                // check file type
                if(!checkUploadFileImage(fileListObj)){
                    pass = false;
                }
                // check file size 5MB
                if(!checkUploadFileSize(fileListObj,5242880)){
                    pass = false;
                }
                if(pass){
                    addBlock(fileListObj);
                }
            })
            dropArea.classList.remove("active");
            dragText.textContent = "Drag & Drop to Upload File";
        });

        function uuidv4() {
            return ([1e7]+-1e3+-4e3+-8e3+-1e11).replace(/[018]/g, c =>
                (c ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> c / 4).toString(16)
            );
        }

        const upload = () => {
            let pass = true;
            $.each($('.card-body'),function(index,value){
                let title = $(value).find('.image-title').val();
                let files = $(value).find('.file-upload')[0].files;
                if(checkUploadSelectFile(files)){
                    let blockUpload = $(this).parent().parent();
                    //check file image
                    if(!checkUploadFileImage(files)){
                        $(this).addClass('is-invalid');
                        $(blockUpload).find('#fileuploadFeedback').html('Please select image file.');
                        pass = false;
                        return false
                    }

                    //check file size 5MB
                    if(!checkUploadFileSize(files,5242880)){
                        $(this).addClass('is-invalid');
                        $(blockUpload).find('#fileuploadFeedback').html('File size more than 5MB.');
                        pass = false;
                        return false
                    }
                    if($(blockUpload).find('#imagetitle').val().trim().length === 0){
                        $(blockUpload).find('#imagetitle').val(files[0].name);
                    }
                    $(this).removeClass('is-invalid');
                }
            })
            if(pass){
                processModal.show();
                setTimeout(() => {
                    let indexUpload = 1;
                    $.each($('.card-body'),function(index,value){
                        let title = $(value).find('.image-title').val();
                        let files = $(value).find('.file-upload')[0].files;
                        if(checkUploadSelectFile(files)){
                            var fd = new FormData();
                            fd.append('fileupload',files[0]);
                            fd.append('title',title);
                            fd.append('description',title);
                            $.ajax({
                                url: '{{route('imageupload')}}',
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
                                        data:{id:response.id},
                                        success:function(response){
                                            if($('.card-body').length === indexUpload){
                                                showAlert(true,'Upload successful',true,'{{route('imagesindex')}}',1000)
                                            }else{
                                                indexUpload++;
                                            }
                                        }
                                    })
                                }
                            })
                        }
                    })
                },1000);
            }
        }

        const checkUploadSelectFile = (objectel) => {
            if(objectel.length > 0 ){
                return true;
            }else{
                return false;
            }
        }

        function checkUploadFileImage(objectel){
            let validImageTypes = ["image/jpeg", "image/jpg", "image/png"];
            if ($.inArray(objectel[0]['type'], validImageTypes) < 0) {
                return false;
            }
            return true;
        }

        function checkUploadFileSize(objectel,size){
            if(objectel[0]['size'] > parseInt(size))
            {
                return false;
            }
            return true;
        }

        const bindSelectFile = () => {
            $(".file-upload").unbind('change');
            $(".delete-component").unbind('click');
            $(".file-upload").on('change',function(){
                let files = $(this)[0].files;
                if(checkUploadSelectFile(files)){
                    let blockUpload = $(this).parent().parent();
                    //check file image
                    if(!checkUploadFileImage(files)){
                        $(this).addClass('is-invalid');
                        $(blockUpload).find('#fileuploadFeedback').html('Please select image file.');
                        return false
                    }

                    //check file size 5MB
                    if(!checkUploadFileSize(files,5242880)){
                        $(this).addClass('is-invalid');
                        $(blockUpload).find('#fileuploadFeedback').html('File size more than 5MB.');
                        return false
                    }
                    if($(blockUpload).find('#imagetitle').val().trim().length === 0){
                        $(blockUpload).find('#imagetitle').val(files[0].name);
                    }
                    $(this).removeClass('is-invalid');
                }else{
                    $(this).addClass('is-invalid');
                    $(blockUpload).find('#fileuploadFeedback').html('Please select a file.');
                }
            });
            $(".delete-component").on('click',function(){
                $(this).parent().parent().parent().parent().remove();
            });
        }

        const addBlock = (fileupload) => {
            let blockid = uuidv4();
            let uploadBlock = `
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <label for="imagetitle" class="form-label">Title</label>
                                <input type="text" class="form-control image-title" id="imagetitle" name="imagetitle" value="${fileupload[0].name}">
                            </div>
                            <div class="col-5">
                                <label for="fileupload" class="form-label">Image</label>
                                <input type="file" class="form-control file-upload" id="fileupload-${blockid}" name="fileupload">
                                <div id="fileuploadFeedback" class="invalid-feedback">
                                    Please use image file.
                                </div>
                            </div>
                            <div class="col-1">
                                <button type="button" class="btn-close delete-component"></button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            $('#upload-block').append(uploadBlock);
            $('#fileupload-'+blockid).prop("files",fileupload);
            bindSelectFile();
        }

    </script>
@endsection
