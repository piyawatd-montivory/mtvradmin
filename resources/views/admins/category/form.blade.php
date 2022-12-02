@extends('admins.template.template')
@section('title')
    Category
@endsection
@section('meta')

@endsection
@section('stylesheet')
<link href="{{asset('css/sorttheme.css')}}" rel="stylesheet">
<link href="{{asset('css/tags.css')}}" rel="stylesheet" />
<link href="{{asset('css/jquery-confirm.css')}}" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
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
    .move-class {
        cursor: grabbing;
    }
    .add-component-class {
        cursor: pointer;
    }
</style>
@endsection
@section('content')
<div class="container-fluid mt-5">
    <div class="h3 border-bottom border-primary text-primary">
        Category : @if($data->id == '') New @else {{$data->title}} @endif
    </div>
    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <form id="productform" action="#">
                <div class="mb-3">
                    <div class="col-12 mt-2 text-end">
                        <button name="submitbtn" id="submitbtn" class="btn btn-outline-primary btn-sm" type="button" onclick="javascript:buildData('save');">Save</button>
                        <a href="{{ route('categoryindex') }}" class="btn btn-outline-danger btn-sm">Cancel</a>
                    </div>
                </div>
                <ul class="nav nav-tabs">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="config-tab" data-bs-toggle="tab" data-bs-target="#configtab" type="button" role="tab" aria-controls="configtab" aria-selected="true">Detail</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="social-tab" data-bs-toggle="tab" data-bs-target="#socialtab" type="button" role="tab" aria-controls="socialtab" aria-selected="false">Social</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="configtab" role="tabpanel" aria-labelledby="config-tab">
                        @include('admins.category.tab-config')
                    </div>
                    <div class="tab-pane fade" id="socialtab" role="tabpanel" aria-labelledby="social-tab">
                        @include('admins.category.tab-social')
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
    <script src="{{asset('js/validate.js')}}"></script>
    <script src="{{asset('js/Sortable.min.js')}}"></script>
    <script src="{{asset('js/jquery-confirm.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script type="text/javascript">

        const pvModalEl = document.getElementById('browseSingleImage');
        let imageModal ='';
        let browsetype = '';
        let contentid = '{{$data->id}}';
        let contentversion = {{$data->version}};

        $(function(){
            imageModal =  new bootstrap.Modal(document.getElementById('browseSingleImage'), {backdrop:true});
            $( '#category' ).select2( {
                theme: "bootstrap-5",
                width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                placeholder: $( this ).data( 'placeholder' ),
            } );
            $('#ogimage-btn').on('click',function(){
                browsetype = 'ogimage';
                $('#iframeBrowseImage').attr('src',"{{ route('imagebrowse')}}?type=single");
                imageModal.show();
            })
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
            $('#archive').on('click',function(){
                if(contentid !== ''){
                    archivedata(contentid,contentversion,$('#title').val());
                }
            })
        })

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
                    url:"{{route('checkslugcategory')}}",
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
            if(!checkSlug()){
                pass = false;
            }
            if(pass){
                let data = {};
                data.id = contentid;
                data.version = contentversion;
                data.title = $('#title').val();
                data.slug = $('#slug').val();
                data.parent = $('#category').val();
                data.categoryorder = $('#categoryorder').val();
                //bullet
                $.each($('.entry-bullet-data'),function(){
                    data.entrybullet.push({detail:$(this).val()})
                })
                //social
                data.ogtitle = $('#title').val();
                data.ogimage = $('#ogimage').val();
                data.ogdescription = $('#ogdescription').val();
                data.keyword = $('#keyword').val();
                processModal.show();
                setTimeout(() => {
                    $.ajax({
                        url:"{{route('categorycreate')}}",
                        method:"POST",
                        data:{data:JSON.stringify(data)},
                        success:function(response){
                            contentid = response.sys.id;
                            contentversion = response.sys.version;
                            showAlert(true,'Save successful')
                            window.location.href = '/admins/categories/edit/'+contentid;
                        }
                    })
                },1000);
            }
        }

        function selImageSuccess(imageData) {
            if(browsetype === 'ogimage'){
                $('#ogimage').val(imageData.id);
                $('#displayogimage').attr("src",imageData.url);
                $('#displayogimage').removeClass('d-none');
            }
            imageModal.hide();
            $('#iframeBrowseImage').attr('src','');
        }

    const archivedata = (id,version,title) => {
        $.confirm({
            title: 'Confirm!',
            content: 'Confirm Archived '+title+' ?',
            buttons: {
                confirm:{
                    action: function () {
                        $.ajax({
                            url:'{{route('categoryarchived')}}',
                            method:"post",
                            async: false,
                            cache: false,
                            data:{id:id,version:version},
                            beforeSend: function( xhr ) {
                                processModal.show();
                            },
                            success:function(response){
                                if(response.result){
                                    showAlert(true,'Archived successful',false,1000)
                                    contentid = response.data.sys.id;
                                    contentversion = response.data.sys.version;
                                    $('#publish').addClass('d-none');
                                    $('#unpublish').addClass('d-none');
                                    $('#archive').addClass('d-none');
                                    $('#unarchive').removeClass('d-none');
                                }else{
                                    showAlert(false,'Can not Archived.',false,1000)
                                }
                            }
                        })
                    }
                },
                cancel:{
                    btnClass: 'btn-red',
                    action: function () {

                    }
                }
            }
        });
    }
    </script>
@endsection
