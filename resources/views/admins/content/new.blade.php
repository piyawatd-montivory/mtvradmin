@extends('layout.template')
@section('title')
    Content
@endsection
@section('meta')

@endsection
@section('stylesheet')
<link href="{{asset('/assets/css/sorttheme.css')}}" rel="stylesheet">
<style>
    #droplist {
        min-height: 800px;
    }
    .content-editor {
        min-height: 250px;
    }
    .component-social {
        min-height: 50px;
        height: 50px;
    }
    .component-ad {
        min-height: 50px;
        height: 50px;
    }
    .image-content-mockup {
        height: 150px;
    }
</style>
@endsection
@section('content')
<div class="container-fluid mt-5">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Content : New</h1>
    </div>
    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <form id="productform" method="post" action="{{ route('contentcreate') }}">
                <ul class="nav nav-tabs">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="config-tab" data-bs-toggle="tab" data-bs-target="#config" type="button" role="tab" aria-controls="config" aria-selected="true">Config</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="herocontent-tab" data-bs-toggle="tab" data-bs-target="#herocontent" type="button" role="tab" aria-controls="herocontent" aria-selected="false">Hero Content</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="content-tab" data-bs-toggle="tab" data-bs-target="#content" type="button" role="tab" aria-controls="content" aria-selected="false">Content</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="social-tab" data-bs-toggle="tab" data-bs-target="#social" type="button" role="tab" aria-controls="social" aria-selected="false">Social</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="config" role="tabpanel" aria-labelledby="config-tab">
                        @include('content.tab-config')
                    </div>
                    <div class="tab-pane fade" id="herocontent" role="tabpanel" aria-labelledby="herocontent-tab">
                        @include('content.tab-herocontent')
                    </div>
                    <div class="tab-pane fade" id="content" role="tabpanel" aria-labelledby="content-tab">
                        @include('content.tab-content')
                    </div>
                    <div class="tab-pane fade" id="social" role="tabpanel" aria-labelledby="social-tab">
                        @include('content.tab-social')
                    </div>
                </div>
                <div class="mb-3">
                    <div class="offset-2 mt-2">
                        <button name="submitbtn" id="submitbtn" class="btn btn-outline-primary btn-sm" type="button" onclick="javascript:buildData('save');">บันทึก</button>
                        <button name="submitbtn" id="submitbtn" class="btn btn-outline-primary btn-sm" type="button" onclick="javascript:submitform('preview');">Preview</button>
                        <a href="{{ route('contentindex') }}" class="btn btn-outline-danger btn-sm">ยกเลิก</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
  <!-- Modal -->
<div class="modal fade" id="browseSingleImage" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="browseSingleImageLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="browseSingleImageLabel">Browse Image</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <iframe id="iframeBrowseImage" width="100%" height="650" frameborder="0" allowfullscreen=""></iframe>
        </div>
      </div>
    </div>
</div>

@endsection
@section('script')
    <script src="{{asset('/assets/js/validate.js')}}"></script>
    <script src="{{asset('/assets/js/Sortable.min.js')}}"></script>
    <script src="//cdn.ckeditor.com/4.19.1/full/ckeditor.js"></script>
    <script type="text/javascript">

        CKEDITOR.disableAutoInline = true;
        const pvModalEl = document.getElementById('browseSingleImage');
        let productVariantModal ='';
        let browsetype = '';
        let componentid = '';
        let editid = {{count($components)}};
        let contentid = '';
        let contentversion = 0;

        $(function(){
            productVariantModal =  new bootstrap.Modal(document.getElementById('browseSingleImage'), {backdrop:true});
            $('#thumbnail-btn').on('click',function(){
                browsetype = 'thumbnail';
                $('#iframeBrowseImage').attr('src',"{{ route('imagebrowse')}}?type=single");
                productVariantModal.show();
            })
            $('#heroimage-btn').on('click',function(){
                browsetype = 'heroimage';
                $('#iframeBrowseImage').attr('src',"{{ route('imagebrowse')}}?type=single");
                productVariantModal.show();
            })
            $('#ogimage-btn').on('click',function(){
                browsetype = 'ogimage';
                $('#iframeBrowseImage').attr('src',"{{ route('imagebrowse')}}?type=single");
                productVariantModal.show();
            })
            $('#heroslide-btn').on('click',function(){
                browsetype = 'heroslide';
                $('#iframeBrowseImage').attr('src',"{{ route('imagebrowse')}}?type=multiple");
                productVariantModal.show();
            })
            setck();
            bindDel();
            bindSelectImageComponent();
        })

        const buildData = (savetype) => {
            let pass = true;
            $.each($('.validate'),function(i,obj){
                if($(obj).val().trim().length === 0){
                    $(obj).addClass('is-invalid');
                    pass = false;
                }else{
                    $(obj).removeClass('is-invalid');
                }
            })
            if(pass){
                let data = {};
                data.title = $('#title').val();
                data.excerpt = $('#excerpt').val();
                data.thumbnail = $('#thumbnail').val();
                data.category = $('#category').val();
                //hero content
                @if($type == 'hero')
                    data.type = 'hero';
                    data.heroimage = $('#heroimage').val();
                @endif
                @if($type == 'video')
                    data.type = 'video';
                    data.herovideo = $('#herovideo').val();
                @endif
                @if($type == 'slide')
                    data.type = 'slide';
                @endif
                //content
                data.content = createData();
                //social
                data.ogimage = $('#ogimage').val();
                data.ogdescription = $('#ogdescription').val();
                if(contentid === ''){
                    $.ajax({
                        url:"{{route('contentcreate')}}",
                        method:"POST",
                        data:{data:JSON.stringify(data)},
                        beforeSend: function( xhr ) {
                            // processModal.show();
                        },
                        success:function(response){
                            let contentid = response.sys.id;
                            let contentversion = response.sys.version;
                            if(savetype === 'preview'){
                                let win = window.open('{{ route('contentpreview') }}?id='+contentid, '_blank');
                            }
                        }
                    })
                }
            }
        }

        const createData = () => {
            let components = [];
            $.each($('.content-component'),function(index,value){
                let componentContent = {};
                let blockid = $(value).attr('blockid')
                switch($(value).attr('componenttype')){
                    case 'content':
                        componentContent.component = 'content';
                        componentContent.content = CKEDITOR.instances[$(value).attr('editid')].getData();
                        break
                    case 'bullet':
                        componentContent.component = 'bullet';
                        componentContent.content = CKEDITOR.instances[$(value).attr('editid')].getData();
                        break
                    case 'blockquote':
                        componentContent.component = 'blockquote';
                        componentContent.content = CKEDITOR.instances[$(value).attr('editid')].getData();
                        break
                    case 'social':
                        componentContent.component = 'social';
                        componentContent.content = '';
                        break
                    case 'ad':
                        componentContent.component = 'ad';
                        componentContent.content = '';
                        break
                    case 'image-left':
                        componentContent.component = 'image-left';
                        componentContent.image = $('#image'+blockid).attr('src');
                        componentContent.imagetitle = $('#image'+blockid+'title').val();
                        componentContent.content = CKEDITOR.instances[$(value).attr('editid')].getData();
                        break
                    case 'image-right':
                        componentContent.component = 'image-right';
                        componentContent.image = $('#image'+blockid).attr('src');
                        componentContent.imagetitle = $('#image'+blockid+'title').val();
                        componentContent.content = CKEDITOR.instances[$(value).attr('editid')].getData();
                        break
                    case 'double-image':
                        componentContent.component = 'double-image';
                        componentContent.imageleft = $('#imageleft'+blockid).attr('src');
                        componentContent.imagelefttitle = $('#imageleft'+blockid+'title').val();
                        componentContent.imageright = $('#imageright'+blockid).attr('src');
                        componentContent.imagerighttitle = $('#imageright'+blockid+'title').val();
                        break
                    case 'single-image':
                        componentContent.component = 'single-image';
                        componentContent.image = $('#image'+blockid).attr('src');
                        componentContent.imagetitle = $('#image'+blockid+'title').val();
                        break
                }
                components.push(componentContent);
            })
            return components;
        }

        function selImageSuccess(imageData) {
            if(browsetype === 'thumbnail'){
                $('#thumbnail').val(imageData.id);
                $('#displaythumbnail').attr("src",imageData.url);
                $('#displaythumbnail').removeClass('d-none');
            }
            if(browsetype === 'heroimage'){
                $('#heroimage').val(imageData.id);
                $('#displayheroimage').attr("src",imageData.url);
                $('#displayheroimage').removeClass('d-none');
            }
            if(browsetype === 'ogimage'){
                $('#ogimage').val(imageData.id);
                $('#displayogimage').attr("src",imageData.url);
                $('#displayogimage').removeClass('d-none');
            }
            if(browsetype === 'heroslide'){
                console.log(imageData);
            }
            if(browsetype === 'editorimage'){
                $('#'+componentid).attr("src",imageData.url);
                $('#'+componentid+'title').val(imageData.title);
            }
            productVariantModal.hide();
        }

        const removeck = () => {
            $.each($('.content-editor'),function(index,value){
                    CKEDITOR.instances[$(value).attr('id')].destroy()
            })
            $('.content-editor').attr('contenteditable',false)
        }

        const setck = () => {
            $('.content-editor').attr('contenteditable',true)
            $.each($('.content-component'),function(index,value){
                switch($(value).attr('componenttype')){
                    case 'content':
                        CKEDITOR.inline( $(value).attr('editid') ,{
                            customConfig: "{{ asset('assets/js/ckcontentconfig.js') }}",
                            enterMode: CKEDITOR.ENTER_BR,
                            shiftEnterMode: CKEDITOR.ENTER_P,
                            filebrowserImageBrowseUrl: '{{ route('imageck') }}'
                        });
                        break
                    case 'blockquote':
                        CKEDITOR.inline( $(value).attr('editid') ,{
                            customConfig: "{{ asset('assets/js/ckcontentconfig.js') }}",
                            enterMode: CKEDITOR.ENTER_BR,
                            shiftEnterMode: CKEDITOR.ENTER_P
                        });
                        break
                    case 'bullet':
                        CKEDITOR.inline( $(value).attr('editid') ,{
                            customConfig: "{{ asset('assets/js/ckcontentconfig.js') }}",
                            enterMode: CKEDITOR.ENTER_BR,
                            shiftEnterMode: CKEDITOR.ENTER_P
                        });
                        break
                    case 'image-left':
                        CKEDITOR.inline( $(value).attr('editid') ,{
                            customConfig: "{{ asset('assets/js/ckcontentconfig.js') }}",
                            enterMode: CKEDITOR.ENTER_BR,
                            shiftEnterMode: CKEDITOR.ENTER_P
                        });
                        break
                    case 'image-right':
                        CKEDITOR.inline( $(value).attr('editid') ,{
                            customConfig: "{{ asset('assets/js/ckcontentconfig.js') }}",
                            enterMode: CKEDITOR.ENTER_BR,
                            shiftEnterMode: CKEDITOR.ENTER_P
                        });
                        break
                }
            })
        }

        const bindDel = () => {
            $('.delete-component').unbind('click');
            $('.delete-component').on('click',function(){
                if (confirm("Remove Block!") == true) {
                    $(this).parent().parent().parent().parent().remove();
                }
            })
        }

        const bindSelectImageComponent = () => {
            $('.editor-browse').on('click',function(){
                browsetype = 'editorimage';
                componentid = $(this).attr('imgid');
                $('#iframeBrowseImage').attr('src',"{{ route('imagebrowse')}}?type=single");
                productVariantModal.show();
            })
        }

        // Simple list
        Sortable.create(componentlist, {
            group: {
                name: 'shared',
                pull: 'clone', // To clone: set pull to 'clone'
                put: false,
                revertClone:true
            },
            sort: false,
            dataIdAttr: 'dataid',
            ghostClass: "sortable-ghost",  // Class name for the drop placeholder
            chosenClass: "sortable-chosen",  // Class name for the chosen item
            dragClass: "sortable-drag",  // Class name for the dragging item
            animation: 150,
            onStart: function (/**Event*/evt) {
                removeck();
            },
            onEnd: function (/**Event*/evt) {
                setck();
            },
        });

        Sortable.create(editorarea, {
            group: {
                name: 'shared',
                pull: 'clone' // To clone: set pull to 'clone'
            },
            handle: '.card-header',
            animation: 150,
            ghostClass: "bg-opacity-10",  // Class name for the drop placeholder
            chosenClass: "bg-info",  // Class name for the chosen item
            dragClass: "sortable-drag",  // Class name for the dragging item
            onStart: function (/**Event*/evt) {
                removeck();
            },
            onEnd: function (/**Event*/evt) {
                setck();
            },
            // Element dragging ended
            onAdd: function (/**Event*/evt) {
                let itemid = $(evt.item).attr('dataid');
                let title = '';
                let componenttype = '';
                let bodycomponent = '';
                if(itemid === 'content'){
                    title = 'Content';
                    bodycomponent = `
                        <div class="card-body content-component content-editor" blockid="${editid}" componenttype="content" editid="mycedit${editid}" contenteditable="true" id="mycedit${editid}">

                        </div>
                    `;
                }
                if(itemid === 'bullet'){
                    title = 'Bullet';
                    bodycomponent = `
                        <div class="card-body content-component content-editor" blockid="${editid}" componenttype="bullet" editid="mycedit${editid}" contenteditable="true" id="mycedit${editid}">

                        </div>
                    `;
                }
                if(itemid === 'image-left'){
                    title = 'Image Left';
                    bodycomponent = `
                        <div class="card-body content-component" blockid="${editid}" componenttype="image-left" editid="mycedit${editid}">
                            <div class="row">
                                <div class="col-6 border">
                                    <div class="row mb-3 mt-3">
                                        <div class="col-12">
                                            <button type="button" class="btn btn-sm btn-outline-primary editor-browse" imgid="image${editid}">
                                                Browse
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12 text-center">
                                            <img src="" class="img-fluid image-content-mockup" id="image${editid}"/>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label for="image${editid}title" class="form-label">Title</label>
                                            <input type="text" class="form-control" id="image${editid}title" name="image${editid}title">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 border content-editor" contenteditable="true" id="mycedit${editid}">

                                </div>
                            </div>
                        </div>
                    `;
                }
                if(itemid === 'image-right'){
                    title = 'Image Right';
                    bodycomponent = `
                        <div class="card-body content-component" blockid="${editid}" componenttype="image-right" editid="mycedit${editid}">
                            <div class="row">
                                <div class="col-6 border content-editor" contenteditable="true" id="mycedit${editid}">

                                </div>
                                <div class="col-6 border">
                                    <div class="row mb-3 mt-3">
                                        <div class="col-12">
                                            <button type="button" class="btn btn-sm btn-outline-primary editor-browse" imgid="image${editid}">
                                                Browse
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12 text-center">
                                            <img src="" class="img-fluid image-content-mockup" id="image${editid}"/>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label for="image${editid}title" class="form-label">Title</label>
                                            <input type="text" class="form-control" id="image${editid}title" name="image${editid}title">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                }
                if(itemid === 'double-image'){
                    title = 'Double Image';
                    bodycomponent = `
                        <div class="card-body content-component" blockid="${editid}" componenttype="double-image" editid="mycedit${editid}">
                            <div class="row">
                                <div class="col-6 border">
                                    <div class="row mb-3 mt-3">
                                        <div class="col-12">
                                            <button type="button" class="btn btn-sm btn-outline-primary editor-browse" imgid="imageleft${editid}">
                                                Browse
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12 text-center">
                                            <img src="" class="img-fluid image-content-mockup" id="imageleft${editid}"/>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label for="imageleft${editid}title" class="form-label">Title</label>
                                            <input type="text" class="form-control" id="imageleft${editid}title" name="imageleft${editid}title">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 border">
                                    <div class="row mb-3 mt-3">
                                        <div class="col-12">
                                            <button type="button" class="btn btn-sm btn-outline-primary editor-browse" imgid="imageright${editid}">
                                                Browse
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12 text-center">
                                            <img src="" class="img-fluid image-content-mockup" id="imageright${editid}"/>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label for="imageright${editid}title" class="form-label">Title</label>
                                            <input type="text" class="form-control" id="imageright${editid}title" name="imageright${editid}title">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                }
                if(itemid === 'single-image'){
                    title = 'Single Image';
                    bodycomponent = `
                        <div class="card-body content-component" blockid="${editid}" componenttype="single-image" editid="mycedit${editid}">
                            <div class="row">
                                <div class="col-12 border">
                                    <div class="row mb-3 mt-3">
                                        <div class="col-12">
                                            <button type="button" class="btn btn-sm btn-outline-primary editor-browse" imgid="singleimage${editid}">
                                                Browse
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12 text-center">
                                            <img src="" class="img-fluid image-content-mockup" id="singleimage${editid}"/>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label for="singleimage${editid}title" class="form-label">Title</label>
                                            <input type="text" class="form-control" id="singleimage${editid}title" name="singleimage${editid}title">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                }
                if(itemid === 'ad'){
                    title = 'Ad';
                    bodycomponent = `
                    <div class="card-body content-component" blockid="${editid}" componenttype="ad" editid="mycedit${editid}">
                        Ad
                    </div>
                    `;
                }
                if(itemid === 'social'){
                    title = 'Social';
                    bodycomponent = `
                        <div class="card-body content-component" blockid="${editid}" componenttype="social" editid="mycedit${editid}">
                            Social
                        </div>
                    `;
                }
                if(itemid === 'blockquote'){
                    title = 'Blockquote';
                    bodycomponent = `
                        <div class="card-body content-component content-editor" blockid="${editid}" componenttype="blockquote" editid="mycedit${editid}" contenteditable="true" id="mycedit${editid}">

                        </div>
                    `;
                }
                let htmlel = `
                    <div class="card mb-3">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-6">${title}</div>
                                <div class="col-6 text-end">
                                    <button type="button" class="btn-close"></button>
                                </div>
                            </div>
                        </div>
                        ${bodycomponent}
                    </div>
                    `;
                $(evt.item).replaceWith( $(htmlel) );
                bindDel();
                bindSelectImageComponent();
                editid++;
            }
        });
    </script>
@endsection
