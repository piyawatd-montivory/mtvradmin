@extends('admins.template.template')
@section('title')
    Position
@endsection
@section('meta')

@endsection
@section('stylesheet')
<link href="{{asset('/css/tags.css')}}" rel="stylesheet" />
<link href="{{asset('/css/datatables.min.css')}}" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@endsection
@section('content')
<div class="container mt-3">
    <div class="h3 border-bottom border-primary text-primary">
        Position : @if($data->id == '') New @else {{$data->title}} @endif
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <form id="formdata" action="#">
                <div class="row mt-2">
                    <div class="col-12 text-end mb-3">
                        <button name="submitbtn" id="submitbtn" class="btn btn-outline-primary btn-sm" type="button" onclick="javascript:buildData();">Save</button>
                        <a href="{{ route('positionindex') }}" class="btn btn-outline-danger btn-sm">Cancel</a>
                    </div>
                    <div class="col-12">
                        <div class="alert alert-danger d-none" role="alert" id="error-report">
                            <ol id="error-list">

                            </ol>
                        </div>
                    </div>
                </div>
                @csrf
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                      <button class="nav-link active" id="detail-tab" data-bs-toggle="tab" data-bs-target="#detailtab" type="button" role="tab" aria-controls="detail" aria-selected="true">Detail</button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="description-tab" data-bs-toggle="tab" data-bs-target="#descriptiontab" type="button" role="tab" aria-controls="description" aria-selected="false">Description</button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="seo-tab" data-bs-toggle="tab" data-bs-target="#seotab" type="button" role="tab" aria-controls="seo" aria-selected="false">SEO</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active pt-3" id="detailtab" role="tabpanel" aria-labelledby="detailtab">
                        @include('admins.position.detail')
                    </div>
                    <div class="tab-pane fade pt-3" id="descriptiontab" role="tabpanel" aria-labelledby="descriptiontab">
                        @include('admins.position.description')
                    </div>
                    <div class="tab-pane fade pt-3" id="seotab" role="tabpanel" aria-labelledby="seotab">
                        @include('admins.position.seo')
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
<script src="//cdn.ckeditor.com/4.19.1/full/ckeditor.js"></script>
<script src="{{asset('/js/datatables.min.js')}}"></script>
<script src="{{asset('/js/dataTables.bootstrap5.js')}}"></script>
<script src="{{asset('/js/select.bootstrap5.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>

    CKEDITOR.disableAutoInline = true;
    const imageModalEl = document.getElementById('browseSingleImage');
    let browsetype = '';
    let imageModal ='';
    let cversion = {{$data->version}};

    CKEDITOR.replace( 'description' , {
            height: "400",
            customConfig: "{{ asset('js/ckcontentconfig.js') }}",
            enterMode: CKEDITOR.ENTER_BR,
            shiftEnterMode: CKEDITOR.ENTER_P,
            filebrowserImageBrowseUrl: '{{ route('imageck') }}'
        });

    $(document).ready(function(){
        imageModal =  new bootstrap.Modal(document.getElementById('browseSingleImage'), {backdrop:true});
        $( '#skill' ).select2( {
            theme: "bootstrap-5",
            width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
            placeholder: $( this ).data( 'placeholder' ),
        } );
        $( '#interest' ).select2( {
            theme: "bootstrap-5",
            width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
            placeholder: $( this ).data( 'placeholder' ),
        } );
        $('#thumbnail-btn').on('click',function(){
            browsetype = 'thumbnail';
            $('#iframeBrowseImage').attr('src',"{{ route('imagebrowse')}}?type=single");
            imageModal.show();
        })
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
        $('#add-skill').on('click',function(){
            addSkill();
        })
        $('#add-interest').on('click',function(){
            addInterest();
        })
        removeSkillInterest();
    });

    const addSkill = () => {
        let newitem = true;
        let itemtext = $('#skill').val();
        $.each($('#skill-listitem').children(), function( index, value ) {
            if($(value).attr('key') === itemtext)
            {
                newitem = false;
                return false;
            }
        });
        if(newitem){
            let itemstr = `
                <span class="tag tag-label tag-skill" key="${itemtext}">
                    ${itemtext}<span class="remove">x</span>
                </span> `;
            $('#skill-listitem').append(itemstr);
            removeSkillInterest();
        }
        $('#newskill').val('');
    }

    const addInterest = () => {
        let newitem = true;
        let itemtext = $('#interest').val();
        $.each($('#interest-listitem').children(), function( index, value ) {
            if($(value).attr('key') === itemtext)
            {
                newitem = false;
                return false;
            }
        });
        if(newitem){
            let itemstr = `
                <span class="tag tag-label tag-interest" key="${itemtext}">
                    ${itemtext}<span class="remove">x</span>
                </span> `;
            $('#interest-listitem').append(itemstr);
            removeSkillInterest();
        }
        $('#newinterest').val('');
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
                url:"{{route('positioncheckslug')}}",
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

    function removeSkillInterest(){
        $( ".remove").unbind( "click" );
        $('.remove').click(function () {
            $(this).parent().remove();
        });
    }

    function selImageSuccess(imageData) {
        if(browsetype === 'thumbnail'){
            $('#thumbnail').val(imageData.id);
            $('#displaythumbnail').attr("src",imageData.url);
            $('#displaythumbnail').removeClass('d-none');
        }
        if(browsetype === 'ogimage'){
            $('#ogimage').val(imageData.id);
            $('#displayogimage').attr("src",imageData.url);
            $('#displayogimage').removeClass('d-none');
        }
        imageModal.hide();
        $('#iframeBrowseImage').attr('src','');
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
            case 'excerpt':
                label = 'Please provide a valid Excerpt.';
                break
            case 'thumbnail':
                label = 'Please provide a valid Thumbnail.';
                break
            case 'skill':
                label = 'Please provide a valid Skill.';
                break
            case 'interest':
                label = 'Please provide a valid Interest.';
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
        if($('#skill-listitem').children().length === 0){
            reporterror('skill');
            pass = false;
        }
        if($('#interest-listitem').children().length === 0){
            reporterror('interest');
            pass = false;
        }
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
            data.excerpt = $('#excerpt').val();
            data.thumbnail = $('#thumbnail').val();
            //content
            data.description = CKEDITOR.instances['description'].getData();
            data.ogimage = $('#ogimage').val();
            data.ogdescription = $('#ogdescription').val();
            data.keyword = $('#keyword').val();
            //skill
            data.skills = [];
            data.interests = [];
            $.each($('#skill-listitem').children(), function( index, value ) {
                data.skills.push($(value).attr('key'));
            });
            $.each($('#interest-listitem').children(), function( index, value ) {
                data.interests.push($(value).attr('key'));
            });
            data.active = $('#active').is(":checked");
            processModal.show();
            setTimeout(() => {
                $.ajax({
                    url:"{{route('positioncreate')}}",
                    method:"POST",
                    headers: {"X-CSRF-TOKEN": "{{ csrf_token() }}"},
                    data:{data:JSON.stringify(data)},
                    success:function(response){
                        // clear error report
                        $('#error-report').addClass('d-none');
                        $('#error-list').html('');
                        cversion = response.sys.version;
                        showAlert(true,'Save successful');
                        window.location.href = '/admins/positions/edit/'+response.sys.id;
                    }
                })
            },1000);
        }
    }

</script>
@endsection
