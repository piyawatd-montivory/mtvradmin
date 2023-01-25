<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>CK</title>
        @include('admins.template.inc-stylesheet')
        <link rel="icon" href="{{ asset('images/logo.png')}}" type="image/icon type">
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
        <style>
            .card-img-top {
                height: 15vw;
                object-fit: cover;
            }
            .card-body {
                height: 69px;
                overflow: hidden;
            }
            .card-title {
                font-size: 12px;
            }
        </style>
    </head>
    <body>
        <div class="container-fluid px-4">
            <div class="row mt-3">
                <div class="col-12 col-md-3">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="title" name="title">
                        <div class="invalid-feedback">
                            Please provide a valid title.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="fileupload" class="form-label">Image</label>
                        <input type="file" class="form-control" id="fileupload" name="fileupload">
                        <div id="fileuploadFeedback" class="invalid-feedback">
                            Please use image file.
                        </div>
                        <div class="progress mt-2 d-none" id="progress">
                            <div class="progress-bar progress-bar-striped bg-info progress-bar-animated" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <p id="complete" class="d-none text-success">complete</p>
                    </div>
                    <div class="mb-3">
                        <button type="button" class="btn btn-outline-info btn-sm" id="btn_upload">Upload</button>
                    </div>
                </div>
                <div class="col-12 col-md-9">
                    <div class="row pb-3">
                        <div class="col-4 col-md-6">
                            <button type="button" class="btn btn-sm btn-outline-primary" id="selImage">Select</button>
                        </div>
                        <div class="col-8 col-md-6 text-end">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control border-primary" id="search" placeholder="Search" aria-label="Search" aria-describedby="search-btn">
                                <button class="btn btn-outline-primary" type="button" id="search-btn">Search</button>
                            </div>
                        </div>
                    </div>
                    <div class="row pt-3 border" id="image-display">
                    </div>
                    <div class="row">
                        <div class="col-12 mt-2 text-end">
                            <nav aria-label="Page navigation">
                                <ul class="pagination justify-content-end" id="pagination">
                                  <li class="page-item" id="previous-btn"><a class="page-link" href="#">Previous</a></li>
                                  <li class="page-item" id="next-btn"><a class="page-link" href="#">Next</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('admins.template.inc-javascript')
        <script src="{{asset('js/validate.js')}}"></script>
        <script type="text/javascript">
            let currentPage = 1;
            let totalPage = 0;
            let searchtext = '';

            $(function(){
                loadImage(currentPage);
                $('#selImage').on('click',function(){
                    selectedImage();
                })
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
                        fd.append('title',$('#title').val());
                        fd.append('description',$('#description').val());
                        $('#progress').removeClass('d-none');
                        $('#complete').addClass('d-none');
                        $('#btn_upload').addClass('d-none');
                        setTimeout(() => {
                            $.ajax({
                                url: '{{route('imageupload')}}',
                                type: 'post',
                                data: fd,
                                contentType: false,
                                processData: false,
                                headers: {"X-CSRF-TOKEN": "{{ csrf_token() }}"},
                                success: function(response){
                                    let resurl = response.url;
                                    $.ajax({
                                        url:'{{route('imagepublished')}}',
                                        method:"post",
                                        async: false,
                                        cache: false,
                                        data:{id:response.id},
                                        success:function(response){
                                            $('#progress').addClass('d-none');
                                            $('#complete').removeClass('d-none');
                                            $('#btn_upload').removeClass('d-none');
                                            $('#fileupload').val('');
                                            $('#title').val('');
                                            $('#description').val('');
                                            window.opener.CKEDITOR.tools.callFunction( {{ $CKEditorFuncNum }}, resurl );
                                            window.close();
                                        }
                                    })
                                },
                            })
                        },1000);
                    }else{
                        $('#fileupload').addClass('is-invalid');
                        $('#fileuploadFeedback').html('Please select a file.');
                    }
                })
                $('#previous-btn').on('click',function(){
                    if(totalPage !== 0){
                        if(currentPage !== 1) {
                            currentPage--;
                            loadImage(currentPage)
                        }
                    }
                })
                $('#next-btn').on('click',function(){
                    if(totalPage !== 0){
                        if(currentPage !== totalPage) {
                            currentPage++;
                            loadImage(currentPage)
                        }
                    }

                })
                $('#search-btn').on('click',function(){
                    currentPage = 1;
                    searchtext = $('#search').val();
                    loadImage(currentPage);
                })
            });

            const selectedImage = () => {
                if($('.selected').length > 0)
                {
                    window.opener.CKEDITOR.tools.callFunction( {{ $CKEditorFuncNum }}, $($('.selected')[0]).find('.card-img-top').attr('src') );
                    window.close();
                }
            }

            const loadImage = (page) => {
                let progress = `
                <div class="col-12">
                    <div class="progress mt-2" id="progress">
                        <div class="progress-bar progress-bar-striped bg-info progress-bar-animated" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                `;
                $('#image-display').html(progress);
                setTimeout(() => {
                    $.ajax({
                        url:"{{route('imageckloadimage')}}?page="+page+"&search="+searchtext,
                        method:"GET",
                        success:function(response){
                            $('#image-display').html('');
                            $.each(response.items,function(index,value){
                                let card = `
                                    <div class="col-6 col-md-3 pb-3">
                                        <div class="card" imageid="${value.id}">
                                            <img src="https:${value.file}" class="card-img-top" alt="${value.title}">
                                            <div class="card-body">
                                                <span class="card-title">${value.title}</span>
                                                <textarea class="imagedescription d-none">${value.description}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                `;
                                $('#image-display').append(card);
                            });
                            bindCard();
                            if(response.page !== 0){
                                totalPage = response.page;
                                if(page === 1) {
                                    $('#previous-btn').addClass('disabled');
                                }else{
                                    $('#previous-btn').removeClass('disabled');
                                }
                                if(page === response.page){
                                    $('#next-btn').addClass('disabled');
                                }else{
                                    $('#next-btn').removeClass('disabled');
                                }
                            }else{
                                totalPage = 0;
                                $('#previous-btn').addClass('disabled');
                                $('#next-btn').addClass('disabled');
                            }
                        }
                    })
                },1000);
            }

            const bindCard = () => {
                $('.card').unbind('click');
                $('.card').on('click',function(){
                    $('.card').removeClass('border-primary border-3 selected');
                    $(this).toggleClass("border-primary border-3 selected");
                })
            }
        </script>
    </body>
</html>
