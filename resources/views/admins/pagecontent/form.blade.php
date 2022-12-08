@extends('admins.template.template')
@section('title')
    Page Content
@endsection
@section('meta')

@endsection
@section('stylesheet')
<link href="{{asset('css/sorttheme.css')}}" rel="stylesheet">
<link href="{{asset('css/tags.css')}}" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<link href="{{asset('/css/form.css')}}" rel="stylesheet" />
<style>
#editorarea {
    height: 600px;
}
</style>
@endsection
@section('content')
<div class="container-fluid mt-5">
    <div class="h3 border-bottom border-primary text-primary">
        Page Content : @if($data->id == '') New @else {{$data->title}} @endif
    </div>
    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <form id="productform" action="#">
                <div class="row mt-2">
                    <div class="col-12 text-end mb-3">
                        <button name="submitbtn" id="submitbtn" class="btn btn-outline-primary btn-sm" type="button" onclick="javascript:buildData();">Save</button>
                        <a href="{{ route('pagecontentindex') }}" class="btn btn-outline-danger btn-sm">Cancel</a>
                    </div>
                    <div class="col-12">
                        <div class="alert alert-danger d-none" role="alert" id="error-report">
                            <ol id="error-list">

                            </ol>
                        </div>
                    </div>
                </div>
                <ul class="nav nav-tabs">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="config-tab" data-bs-toggle="tab" data-bs-target="#configtab" type="button" role="tab" aria-controls="configtab" aria-selected="true">Config</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="content-tab" data-bs-toggle="tab" data-bs-target="#contenttab" type="button" role="tab" aria-controls="contenttab" aria-selected="false">Content</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="special-tab" data-bs-toggle="tab" data-bs-target="#specialtab" type="button" role="tab" aria-controls="specialtab" aria-selected="false">Special</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="gallery-tab" data-bs-toggle="tab" data-bs-target="#gallerytab" type="button" role="tab" aria-controls="gallerytab" aria-selected="false">Gallery</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="configtab" role="tabpanel" aria-labelledby="config-tab">
                        @include('admins.pagecontent.tab-config')
                    </div>
                    <div class="tab-pane fade" id="contenttab" role="tabpanel" aria-labelledby="content-tab">
                        @include('admins.pagecontent.tab-content')
                    </div>
                    <div class="tab-pane fade" id="specialtab" role="tabpanel" aria-labelledby="special-tab">
                        @include('admins.pagecontent.tab-special')
                    </div>
                    <div class="tab-pane fade" id="gallerytab" role="tabpanel" aria-labelledby="gallery-tab">
                        @include('admins.pagecontent.tab-gallery')
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="browseSingleImage" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="browseSingleImageLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-fullscreen">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="browseSingleImageLabel">Browse Image</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <iframe id="iframeBrowseImage" width="100%" height="800" frameborder="0" allowfullscreen=""></iframe>
        </div>
      </div>
    </div>
</div>
@endsection
@section('script')
    <script src="{{asset('js/Sortable.min.js')}}"></script>
    <script src="{{asset('js/validate.js')}}"></script>
    <script src="//cdn.ckeditor.com/4.19.1/full/ckeditor.js"></script>
    <script type="text/javascript">

        CKEDITOR.disableAutoInline = true;
        let imageModal ='';
        let cversion = {{$data->version}};
        CKEDITOR.inline( 'editorarea' ,{
            customConfig: "{{ asset('js/ckcontentconfig.js') }}",
            contentsCss: [ '{{asset('css/theme.css')}}' ],
            enterMode: CKEDITOR.ENTER_BR,
            shiftEnterMode: CKEDITOR.ENTER_P,
            filebrowserImageBrowseUrl: '{{ route('imageck') }}'
        });

        $( document ).ready(function() {
            imageModal =  new bootstrap.Modal(document.getElementById('browseSingleImage'), {backdrop:true});
            $('#title').on('change',function(){
                if($('#slug').val().trim().length == 0){
                    $('#slug').val(buildSlug($('#title').val()));
                    checkSlug();
                }
            });
            $('#slug').on('change',function(){
                let slug = $('#slug').val();
                $('#slug').val(buildSlug(slug));
                checkSlug();
            });
            $('.add-tag').on('click',function(){
                addTag($(this).attr('id'));
            })
            $('#gallery-btn').on('click',function(){
                $('#iframeBrowseImage').attr('src',"{{ route('imagebrowse')}}?type=multiple");
                imageModal.show();
            })
            removeTag();
            bindDeleteSlide();
        })

         //slide
         Sortable.create(gallerydisplay, {
            handle: '.move-class',
            animation: 150,
            ghostClass: "bg-opacity-10",  // Class name for the drop placeholder
            chosenClass: "bg-info",  // Class name for the chosen item
            dragClass: "sortable-drag"  // Class name for the dragging item
        });

        const addTag = (tagtype) => {
            let newitem = true;
            let itemid = $('#session').val();
            let controlid = '#session-listitem';
            let tagclass
            if(tagtype === 'page'){
                itemid = $('#page').val();
                controlid = '#page-listitem';
            }
            $.each($(controlid).children(), function( index, value ) {
                if($(value).attr('id') === itemid)
                {
                    newitem = false;
                    return false;
                }
            });
            if(newitem){
                let itemstr = `
                    <span class="tag tag-label" id="${itemid}">
                    ${itemid}<span class="remove">x</span></span> `;
                $(controlid).append(itemstr);
                removeTag();
            }
        }

        const removeTag = () => {
            $( ".remove").unbind( "click" );
            $('.remove').click(function () {
                $(this).parent().remove();
            });
        }

        const checkSlug = () => {
            let result = false;
            if($('#currentslug').val() !== ''){
                if($('#currentslug').val() === $('#slug').val()){
                    result = true;
                }
            }
            if(result){
                return result;
            }
            $.ajax({
                    url:"{{route('pagecontentcheckslug')}}",
                    method:"post",
                    data:{slug:$('#slug').val()},
                    async: false,
                    cache: false,
                    success:function(response){
                    if(!response.result){
                        $('#slug').val('');
                        $('#slug').addClass('is-invalid');
                    }else{
                        $('#slug').removeClass('is-invalid');
                        result = true;
                    }
                }
            })
            return result;
        }

        function selImageSuccess(imageData) {
            $.each(imageData,function(index,value){
                let slidehtml = `
                <div class="col-4">
                    <div class="card mb-2">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-1"><i class="fa-solid fa-arrows-up-down-left-right move-class"></i></div>
                                <div class="col-11 text-end">
                                    <button type="button" class="btn-close delete-slide"></button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body card-body-slide">
                            <img src="${value.url}" class="card-img card-slide-imgurl">
                            <div class="mb-3 mt-3">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control img-title" value="${value.title}"/>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Link</label>
                                <input type="text" class="form-control img-link"/>
                            </div>
                        </div>
                    </div>
                </div>
                `;
                $('#gallerydisplay').append(slidehtml);
            })
            bindDeleteSlide();
            imageModal.hide();
            $('#iframeBrowseImage').attr('src','');
        }

        const bindDeleteSlide = () => {
            $('.delete-slide').unbind('click');
            $('.delete-slide').on('click',function(){
                if (confirm("Remove Block!") == true) {
                    $(this).parent().parent().parent().parent().parent().remove();
                }
            })
        }

        const reporterror = (name) => {
            let label = '';
            switch (name) {
                case 'title':
                    label = 'Please provide a valid Title.';
                    break
                case 'slug':
                    label = 'Please provide a valid Slug.';
                    break
                case 'checkslug':
                    label = 'Slug is ready to use.';
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
            if(!checkSlug()){
                reporterror('checkslug');
                pass = false;
            }
            if(pass){
                let data = {};
                data.id = '{{$data->id}}';
                data.version = cversion;
                data.title = $('#title').val();
                data.slug = $('#slug').val();
                data.special = $('#special').val();
                //content
                data.content = CKEDITOR.instances['editorarea'].getData();
                data.active = $('#active').is(":checked");
                //page
                data.page = [];
                $.each($('#page-listitem').children(), function( index, value ) {
                    data.page.push($(value).attr('id'));
                });
                //session
                data.session = [];
                $.each($('#session-listitem').children(), function( index, value ) {
                    data.session.push($(value).attr('id'));
                });
                data.gallery = createGallery();
                processModal.show();
                setTimeout(() => {
                    $.ajax({
                        url:"{{route('pagecontentcreate')}}",
                        method:"POST",
                        headers: {"X-CSRF-TOKEN": "{{ csrf_token() }}"},
                        data:{data:JSON.stringify(data)},
                        success:function(response){
                            // clear error report
                            $('#error-report').addClass('d-none');
                            $('#error-list').html('');
                            cversion = response.sys.version;
                            showAlert(true,'Save successful')
                            window.location.href = '/admins/pagecontents/edit/'+response.sys.id;
                        }
                    })
                },1000);
            }
        }

        const createGallery = () => {
            let galleryArray = [];
            $.each($('.card-body-slide'),function(index,value){
                let galleryObj = {};
                galleryObj.url = $(value).find('.card-slide-imgurl').attr('src');
                galleryObj.title = $(value).find('.img-title').val();
                galleryObj.link = $(value).find('.img-link').val();
                galleryArray.push(galleryObj);
            })
            return galleryArray;
        }
    </script>
@endsection
