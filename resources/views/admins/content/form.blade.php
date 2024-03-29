@extends('admins.template.template')
@section('title')
    Content
@endsection
@section('meta')

@endsection
@section('stylesheet')
{{-- <link href="{{asset('css/sorttheme.css')}}" rel="stylesheet"> --}}
<link href="{{asset('css/tags.css')}}" rel="stylesheet" />
<link href="{{asset('css/jquery-confirm.css')}}" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<link href="{{asset('css/form.css')}}" rel="stylesheet" />
<link href="{{asset('css/gijgo.css')}}" rel="stylesheet" />
@endsection
@section('content')
<div class="container-fluid mt-3">
    <div class="h3 border-bottom border-primary text-primary">
        Content : @if($data->id == '') New @else {{$data->title}} @endif
    </div>
    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <form id="productform" action="#">
                <div class="row mt-2">
                    <div class="col-12 text-end mb-3">
                        <button name="submitbtn" id="submitbtn" class="btn btn-outline-primary btn-sm" type="button" onclick="javascript:buildData('save');">Save</button>
                        <button name="submitbtn" id="submitbtn" class="btn btn-outline-primary btn-sm" type="button" onclick="javascript:buildData('preview');">Preview</button>
                        <a href="{{ route('contentindex') }}" class="btn btn-outline-danger btn-sm">Cancel</a>
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
                        <button class="nav-link" id="herocontent-tab" data-bs-toggle="tab" data-bs-target="#herocontenttab" type="button" role="tab" aria-controls="herocontenttab" aria-selected="false">Image</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="content-tab" data-bs-toggle="tab" data-bs-target="#contenttab" type="button" role="tab" aria-controls="contenttab" aria-selected="false">Content</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="social-tab" data-bs-toggle="tab" data-bs-target="#socialtab" type="button" role="tab" aria-controls="socialtab" aria-selected="false">Social</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="reference-tab" data-bs-toggle="tab" data-bs-target="#referencetab" type="button" role="tab" aria-controls="referencetab" aria-selected="false">Reference</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pseudonym-tab" data-bs-toggle="tab" data-bs-target="#pseudonymtab" type="button" role="tab" aria-controls="pseudonymtab" aria-selected="false">Credits</button>
                    </li>
                    <li class="nav-item @if(authuser()->role == 'author') d-none @endif @if($data->id == '') d-none @endif" role="presentation">
                        <button class="nav-link" id="publish-tab" data-bs-toggle="tab" data-bs-target="#publishtab" type="button" role="tab" aria-controls="publishtab" aria-selected="false">Publish</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="configtab" role="tabpanel" aria-labelledby="config-tab">
                        @include('admins.content.tab-config')
                    </div>
                    <div class="tab-pane fade" id="herocontenttab" role="tabpanel" aria-labelledby="herocontent-tab">
                        @include('admins.content.tab-herocontent')
                    </div>
                    <div class="tab-pane fade" id="contenttab" role="tabpanel" aria-labelledby="content-tab">
                        @include('admins.content.tab-content')
                    </div>
                    <div class="tab-pane fade" id="socialtab" role="tabpanel" aria-labelledby="social-tab">
                        @include('admins.content.tab-social')
                    </div>
                    <div class="tab-pane fade" id="referencetab" role="tabpanel" aria-labelledby="reference-tab">
                        @include('admins.content.tab-reference')
                    </div>
                    <div class="tab-pane fade" id="pseudonymtab" role="tabpanel" aria-labelledby="pseudonym-tab">
                        @include('admins.content.tab-pseudonym')
                    </div>
                    <div class="tab-pane fade" id="publishtab" role="tabpanel" aria-labelledby="publish-tab">
                        @include('admins.content.tab-publish')
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

<div class="modal fade" id="tagsModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="TagsModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="browseSingleImageLabel">Tags</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row mb-3 mt-3">
                <label for="nametag" class="col-sm-2 col-form-label">Name</label>
                <div class="col-md-10">
                    <input type="text" class="form-control" id="nametag" name="nametag" placeholder="Name">
                    <div class="invalid-feedback" id="nametag-feedback">
                        Please provide a valid name.
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <label for="idtag" class="col-sm-2 col-form-label">Id</label>
                <div class="col-md-10">
                    <input type="text" class="form-control" id="idtag" name="idtag" placeholder="Id">
                    <div class="invalid-feedback" id="idtag-feedback">
                        Please provide a valid id.
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" id="modal-tag-close">Close</button>
            <button type="button" class="btn btn-primary btn-sm" onclick="addTags()" id="modal-tag-add">Add</button>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="scheduledModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="scheduledModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="browseSingleImageLabel">Scheduled</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row mb-3 mt-3">
                <div class="col-md-10 offset-md-2">
                    <div class="form-check form-check-inline @if($data->status <> 'draft') d-none @endif">
                        <input class="form-check-input" type="radio" name="typescheduled" id="typescheduledpublish" value="publish" @if($data->status == 'draft') checked @endif>
                        <label class="form-check-label" for="typescheduledpublish">Publish</label>
                    </div>
                    <div class="form-check form-check-inline @if($data->status <> 'publish') d-none @endif">
                        <input class="form-check-input" type="radio" name="typescheduled" id="typescheduledunpublish" value="unpublish" @if($data->status == 'publish') checked @endif>
                        <label class="form-check-label" for="typescheduledunpublish">Unpublish</label>
                    </div>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="datepicker" class="col-2 form-label">Date</label>
                <div class="col-4">
                    <input id="datepicker" class="form-control" value="{{ $data->scdate }}"/>
                </div>
                <div class="col-4">
                    <input id="timepicker" class="form-control" value="{{ $data->sctime }}"/>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" id="modal-tag-close">Close</button>
            <button type="button" class="btn btn-primary btn-sm" onclick="addScheduled()" id="modal-tag-add">Add</button>
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
    <script src="{{asset('js/gijgo.js')}}"></script>
    <script src="//cdn.ckeditor.com/4.19.1/full/ckeditor.js"></script>
    <script type="text/javascript">

        CKEDITOR.disableAutoInline = true;
        const imageModalEl = document.getElementById('browseSingleImage');
        const tagModalEl = document.getElementById('tagsModal');
        const scheduledModalEl = document.getElementById('scheduledModal')
        let imageModal ='';
        let tagModal ='';
        let scheduledModal = '';
        let browsetype = '';
        let componentid = '';
        let editid = {{count($components)}};
        let cversion = {{$data->version}};
        let refid = {{count($reference)}};
        let datepicker = $('#datepicker').datepicker({
            uiLibrary: 'bootstrap5',
            format: 'dd/mm/yyyy'
        });
        let timepicker = $('#timepicker').timepicker({
            uiLibrary: 'bootstrap5',
            modal:false
        });

        $( document ).ready(function() {
            imageModal =  new bootstrap.Modal(document.getElementById('browseSingleImage'), {backdrop:true});
            tagModal =  new bootstrap.Modal(document.getElementById('tagsModal'), {backdrop:true,keyboard:false});
            scheduledModal =  new bootstrap.Modal(document.getElementById('scheduledModal'), {backdrop:true,keyboard:false});
            $( '#category' ).select2( {
                theme: "bootstrap-5",
                width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                placeholder: $( this ).data( 'placeholder' ),
            } );
            $( '#tag' ).select2( {
                theme: "bootstrap-5",
                width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                placeholder: $( this ).data( 'placeholder' ),
            } );
            $( '#pcredit' ).select2( {
                theme: "bootstrap-5",
                width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                placeholder: $( this ).data( 'placeholder' ),
            } );
            $('#thumbnail-btn').on('click',function(){
                browsetype = 'thumbnail';
                $('#iframeBrowseImage').attr('src',"{{ route('imagebrowse')}}?type=single");
                imageModal.show();
            })
            $('#heroimage-btn').on('click',function(){
                browsetype = 'heroimage';
                $('#iframeBrowseImage').attr('src',"{{ route('imagebrowse')}}?type=single");
                imageModal.show();
            })
            $('#mobileimage-btn').on('click',function(){
                browsetype = 'mobileimage';
                $('#iframeBrowseImage').attr('src',"{{ route('imagebrowse')}}?type=single");
                imageModal.show();
            })
            $('#ogimage-btn').on('click',function(){
                browsetype = 'ogimage';
                $('#iframeBrowseImage').attr('src',"{{ route('imagebrowse')}}?type=single");
                imageModal.show();
            })
            $('#scheduled-btn').on('click',function(){
                scheduledModal.show();
            })
            $('#ref-btn').on('click',function(){
                addreference();
            })
            $('#add-category').on('click',function(){
                addCategory();
            })
            $('#add-tag').on('click',function(){
                addTag();
            })
            $('#add-pseudonym').on('click',function(){
                addPseudonym();
            })
            $('#add-pcredit').on('click',function(){
                addCredit();
            })
            $('#title').on('change',function(){
                if($('#slug').val().trim().length == 0){
                    $('#slug').val(buildSlug($('#title').val()));
                    checkSlug();
                }
                if($('#ogtitle').val().trim().length == 0){
                    $('#ogtitle').val($('#title').val());
                }
            });
            $('#slug').on('change',function(){
                let slug = $('#slug').val();
                $('#slug').val(buildSlug(slug));
                checkSlug();
            });
            setck();
            bindDel();
            bindSelectImageComponent();
            removeCategory();
            removePseudonym();
            $('#publish').on('click',function(){
                publishdata('{{$data->id}}',cversion,$('#title').val());
            })
            $('#unpublish').on('click',function(){
                unpublishdata('{{$data->id}}',cversion,$('#title').val());
            })
            $('#archive').on('click',function(){
                archivedata('{{$data->id}}',cversion,$('#title').val());
            })
            $('#unarchive').on('click',function(){
                unarchivedata('{{$data->id}}',cversion,$('#title').val());
            })
            $('.add-component-class').click(function(){
                addComponent($(this).parent().parent().parent().attr('dataid'));
            })
            //tag
            $('#new-tag').click(function(){
                tagModal.show();
            })
            $('#idtag').on('change',function(){
                let slug = $('#idtag').val();
                $('#idtag').val(buildSlug(slug));
            });
            bindDelScheduled();
        })

        const addScheduled = () => {
            scheduledModal.hide();
            processModal.show();
            setTimeout(() => {
                $.ajax({
                    url:"{{route('scheduled')}}",
                    async: false,
                    cache: false,
                    method:"POST",
                    headers: {"X-CSRF-TOKEN": "{{ csrf_token() }}"},
                    data:{id:"{{$data->id}}",scdate:datepicker.val(),sctime:timepicker.val(),action:$('input[name="typescheduled"]:checked').val()},
                    success:function(response){
                        if(response.result){
                            showAlert(true,'Create scheduled successful',false,1000);
                            let tdstr = `
                            <tr>
                                <th scope="row">${response.action}</th>
                                <td>${response.datetime}</td>
                                <td>${response.createat}</td>
                                <td>
                                    <a class="btn btn-outline-danger del-schedule btn-sm" id="${response.id}">Delete</a>
                                </td>
                            </tr>
                            `;
                            $('#scheduled-list').append(tdstr);
                            bindDelScheduled();
                        }else{
                            showAlert(false,'Can not add scheduled.',false,1000);
                        }
                    }
                })
            },1000);
        }

        const deleteScheduled = (scEl) => {
            processModal.show();
            setTimeout(() => {
                $.ajax({
                    url:"{{route('delscheduled')}}",
                    async: false,
                    cache: false,
                    method:"POST",
                    headers: {"X-CSRF-TOKEN": "{{ csrf_token() }}"},
                    data:{id:scEl.id},
                    success:function(response){
                        showAlert(true,'Cancel scheduled successful',false,1000)
                        $(scEl).parent().parent().remove();
                    }
                })
            },1000);
        }

        const bindDelScheduled = () => {
            $('.del-schedule').unbind('click');
            $('.del-schedule').on('click',function(){
                if (confirm("Cancel scheduled!") == true) {
                    deleteScheduled(this);
                }
            })
        }


        const reporterrortag = (type) => {
            if(type === 'nametag') {
                $('#nametag-feedback').text('Please provide a valid name.')
            }
            if(type === 'idtag') {
                $('#idtag-feedback').text('Please provide a valid id.')
            }
            if(type === 'checkname') {
                $('#nametag-feedback').text('This name is already use.')
            }
            if(type === 'checkid') {
                $('#idtag-feedback').text('This id is already use.')
            }
        }

        const addTags = () => {
            let pass = true;
            let slug = $('#idtag').val();
            $('#idtag').val(buildSlug(slug));
            $.each($('.validate'),function(i,obj){
                if($(obj).val().trim().length === 0){
                    $(obj).addClass('is-invalid');
                    reporterrortag($(obj).attr('name'));
                    pass = false;
                }else{
                    $(obj).removeClass('is-invalid');
                }
            })
            if(!checkNameTag()){
                reporterrortag('checkname');
                pass = false;
            }
            if(!checkIdTag()){
                reporterrortag('checkid');
                pass = false;
            }
            if(pass){
                let data = {};
                data.id = $('#idtag').val();
                data.version = 0;
                data.name = $('#nametag').val();
                $('#modal-tag-add').prop('disabled',true);
                $('#modal-tag-close').prop('disabled',true);
                setTimeout(() => {
                    $.ajax({
                        url:"{{route('tagscreate')}}",
                        method:"POST",
                        headers: {"X-CSRF-TOKEN": "{{ csrf_token() }}"},
                        data:{data:JSON.stringify(data)},
                        success:function(response){
                            // clear error report
                            $('#modal-tag-add').prop('disabled',false);
                            $('#modal-tag-close').prop('disabled',false);
                            $('#nametag').removeClass('is-invalid');
                            $('#idtag').removeClass('is-invalid');
                            let itemstr = `
                                <span class="tag tag-label tag-tag" id="${data.id}" key="${data.name}">
                                ${data.name}<span class="remove">x</span></span> `;
                            $('#tag-listitem').append(itemstr);
                            $('#tag').append(`<option value="${data.id}">${data.name}</option>`);
                            removeCategory();
                            tagModal.hide();
                        }
                    })
                },1000);
            }
        }

        const checkNameTag = () => {
            let result = false;
            $.ajax({
                url:"{{route('checktagname')}}",
                method:"post",
                data:{name:$('#nametag').val()},
                async: false,
                cache: false,
                success:function(response){
                    if(!response.result){
                        $('#nametag').val('');
                        $('#nametag').addClass('is-invalid');
                    }else{
                        $('#nametag').removeClass('is-invalid');
                        result = true;
                    }
                }
            })
            return result;
        }

        const checkIdTag = () => {
            let result = false;
            $.ajax({
                    url:"{{route('checktag')}}",
                    method:"post",
                    data:{id:$('#idtag').val()},
                    async: false,
                    cache: false,
                    success:function(response){
                    if(!response.result){
                        $('#idtag').val('');
                        $('#idtag').addClass('is-invalid');
                    }else{
                        $('#idtag').removeClass('is-invalid');
                        result = true;
                    }
                }
            })
            return result;
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
                url:"{{route('contentcheckslug')}}",
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

        const addCategory = () => {
            let newitem = true;
            let itemid = $('#category').val();
            let itemtext = $('#category option:selected').text();
            $.each($('#category-listitem').children(), function( index, value ) {
                if($(value).attr('id') === itemid)
                {
                    newitem = false;
                    return false;
                }
            });
            if(newitem){
                let itemstr = `
                    <span class="tag tag-label tag-category" id="${itemid}" key="${itemid}">
                    <input type="hidden" name="categorykey[]" value="${itemid}"/>${itemtext}<span class="remove">x</span></span> `;
                $('#category-listitem').append(itemstr);
                removeCategory();
            }
        }

        const removeCategory = () => {
            $( ".remove").unbind( "click" );
            $('.remove').click(function () {
                $(this).parent().remove();
            });
        }

        const addTag = () => {
            let newitem = true;
            let itemid = $('#tag').val();
            let itemtext = $('#tag option:selected').text();
            $.each($('#tag-listitem').children(), function( index, value ) {
                if($(value).attr('id') === itemid)
                {
                    newitem = false;
                    return false;
                }
            });
            if(newitem){
                let itemstr = `
                    <span class="tag tag-label tag-tag" id="${itemid}" key="${itemtext}">
                    ${itemtext}<span class="remove">x</span></span> `;
                $('#tag-listitem').append(itemstr);
                removeCategory();
            }
        }

        const addPseudonym = () => {
            let newitem = true;
            let itemid = $('#pseudonym').val();
            let itemtext = $('#pseudonym option:selected').text();
            $.each($('#pseudonym-listitem').children(), function( index, value ) {
                if($(value).attr('id') === itemid)
                {
                    newitem = false;
                    return false;
                }
            });
            if(newitem){
                let itemstr = `
                    <span class="tag tag-label tag-pseudonym" id="${itemid}" key="${itemid}">
                    <input type="hidden" name="pseudonymkey[]" value="${itemid}"/>${itemtext}<span class="remove">x</span></span> `;
                $('#pseudonym-listitem').append(itemstr);
                removePseudonym();
            }
        }

        const addCredit = () => {
            let newitem = true;
            let itemid = $('#pcredit').val();
            let itemtext = $('#pcredit option:selected').text();
            $.each($('#pseudonym-listitem').children(), function( index, value ) {
                if($(value).attr('id') === itemid)
                {
                    newitem = false;
                    return false;
                }
            });
            if(newitem){
                let itemstr = `
                    <span class="tag tag-label tag-pseudonym" id="${itemid}" key="${itemid}">
                    <input type="hidden" name="pseudonymkey[]" value="${itemid}"/>${itemtext}<span class="remove">x</span></span> `;
                $('#pseudonym-listitem').append(itemstr);
                removePseudonym();
            }
        }

        const removePseudonym = () => {
            $( ".remove").unbind( "click" );
            $('.remove').click(function () {
                $(this).parent().remove();
            });
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
                case 'heroimage':
                    label = 'Please provide a valid Hero Image.';
                    break
                case 'herovideo':
                    label = 'Please provide a valid Hero Video.';
                    break
                case 'heropodcast':
                    label = 'Please provide a valid Podcast.';
                    break
                case 'category':
                    label = 'Please provide a valid Category.';
                    break
            }
            $('#error-report').removeClass('d-none');
            $('#error-list').append(`<li>${label}</li>`);
        }

        const buildData = (savetype) => {
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
            if($('#category-listitem').children().length === 0){
                reporterror('category');
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
                data.spotlightimage = $('#spotlightimage').val();
                data.owner = '{{$data->owner}}';
                //hero content
                data.heroimage = $('#heroimage').val().trim();
                //mobile image
                data.mobileimage = $('#mobileimage').val().trim();
                //content
                data.content = createData();
                //reference
                data.reference = createRef();
                //social
                data.ogtitle = $('#ogtitle').val();
                data.ogimage = $('#ogimage').val();
                data.ogdescription = $('#ogdescription').val();
                data.keyword = $('#keyword').val();
                //category
                data.category = [];
                $.each($('#category-listitem').children(), function( index, value ) {
                    data.category.push($(value).attr('id'));
                });
                //category
                data.tags = [];
                $.each($('#tag-listitem').children(), function( index, value ) {
                    data.tags.push($(value).attr('id'));
                });
                //pseudonym
                let pseudonymArray = [];
                $.each($('#pseudonym-listitem').children(), function( index, value ) {
                    let pseudonymItem = {};
                    pseudonymItem.id = $(value).attr('id');
                    pseudonymArray.push(pseudonymItem);
                });
                data.pseudonym = pseudonymArray;
                processModal.show();
                setTimeout(() => {
                    $.ajax({
                        url:"{{route('contentcreate')}}",
                        method:"POST",
                        headers: {"X-CSRF-TOKEN": "{{ csrf_token() }}"},
                        data:{data:JSON.stringify(data)},
                        success:function(response){
                            // clear error report
                            $('#error-report').addClass('d-none');
                            $('#error-list').html('');
                            cversion = response.sys.version;
                            showAlert(true,'Save successful')
                            if(savetype === 'preview'){
                                let win = window.open('/admins/contents/preview/'+response.sys.id, '_blank');
                            }
                            window.location.href = '/admins/contents/edit/'+response.sys.id;
                        }
                    })
                },1000);
            }
        }

        const createData = () => {
            let components = [];
            $.each($('.content-component'),function(index,value){
                let componentContent = {};
                let blockid = $(value).attr('blockid')
                componentContent.display = false;
                if($( "#display"+blockid ).prop( "checked")){
                    componentContent.display = true;
                }

                switch($(value).attr('componenttype')){
                    case 'content':
                        componentContent.component = 'content';
                        componentContent.content = CKEDITOR.instances[$(value).attr('editid')].getData();
                        break
                    case 'blockquote':
                        componentContent.component = 'blockquote';
                        componentContent.content = CKEDITOR.instances[$(value).attr('editid')].getData();
                        componentContent.title = $('#quotetitle'+blockid).val();
                        componentContent.credit = $('#quotecredit'+blockid).val();
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

        const createRef = () => {
            let refs = [];
            $.each($('.card-body-reference'),function(index,value){
                let refContent = {};
                let blockid = $(value).attr('refid')
                refContent.title = $('#ref-title'+blockid).val();
                refContent.link = $('#ref-link'+blockid).val();
                refs.push(refContent);
            });
            return refs;
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
            if(browsetype === 'mobileimage'){
                $('#mobileimage').val(imageData.id);
                $('#displaymobileimage').attr("src",imageData.url);
                $('#displaymobileimage').removeClass('d-none');
            }
            if(browsetype === 'ogimage'){
                $('#ogimage').val(imageData.id);
                $('#displayogimage').attr("src",imageData.url);
                $('#displayogimage').removeClass('d-none');
            }
            if(browsetype === 'editorimage'){
                $('#'+componentid).attr("src",imageData.url);
                $('#'+componentid+'title').val(imageData.title);
            }
            imageModal.hide();
            $('#iframeBrowseImage').attr('src','');
        }

        const removeck = () => {
            $.each($('.content-editor'),function(index,value){
                    CKEDITOR.instances[$(value).attr('id')].destroy()
            })
            $('.content-editor').attr('contenteditable',false)
        }

        const fullConfig = () => {
            let config = {
                customConfig: "{{ asset('js/ckcontentconfig.js') }}",
                // contentsCss: [ '{{asset('assets/preview/css/theme.css')}}' ],
                enterMode: CKEDITOR.ENTER_BR,
                shiftEnterMode: CKEDITOR.ENTER_P,
                filebrowserImageBrowseUrl: '{{ route('imageck') }}'
            }
            return config;
        }

        const setck = () => {
            $('.content-editor').attr('contenteditable',true)
            $.each($('.content-component'),function(index,value){
                switch($(value).attr('componenttype')){
                    case 'content':
                        CKEDITOR.inline( $(value).attr('editid') ,fullConfig());
                        break
                    case 'blockquote':
                        CKEDITOR.inline( $(value).attr('editid') ,fullConfig());
                        break
                    case 'image-left':
                        CKEDITOR.inline( $(value).attr('editid') ,fullConfig());
                        break
                    case 'image-right':
                        CKEDITOR.inline( $(value).attr('editid') ,fullConfig());
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
                console.log(componentid)
                $('#iframeBrowseImage').attr('src',"{{ route('imagebrowse')}}?type=single");
                imageModal.show();
            })
        }

        const addreference = () => {
            let refhtml = `<div class="card mb-2">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            Reference
                        </div>
                        <div class="col-6 text-end">
                            <button type="button" class="btn-close delete-reference"></button>
                        </div>
                    </div>
                </div>
                <div class="card-body card-body-reference" refid="${refid}">
                    <div class="mb-3 row mt-3">
                        <label for="ref-title" class="col-md-1 col-4 form-label">Title</label>
                        <div class="col-md-3 col-8 mb-2">
                            <input type="text" class="form-control validate" id="ref-title${refid}" name="ref-title${refid}" placeholder="Title" value="">
                            <div class="invalid-feedback">
                                Please provide a valid title.
                            </div>
                        </div>
                        <label for="ref-link" class="col-md-1 col-4 form-label">Link</label>
                        <div class="col-md-7 col-8">
                            <input type="text" class="form-control validate" id="ref-link${refid}" name="ref-link${refid}" placeholder="Link" value="">
                            <div class="invalid-feedback">
                                Please provide a valid link.
                            </div>
                        </div>
                    </div>
                </div>
            </div>`;
            $('#card-ref-block').append(refhtml);
            refid++
            bindcardref();
        }

        const bindcardref = () => {
            $('.delete-reference').unbind('click');
            $('.delete-reference').on('click',function(){
                if (confirm("Remove Block!") == true) {
                    $(this).parent().parent().parent().parent().remove();
                }
            })
        }

        // Component list
        Sortable.create(componentlist, {
            handle: '.move-class',
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

        //Content Component
        Sortable.create(editorarea, {
            group: {
                name: 'shared',
                pull: 'clone' // To clone: set pull to 'clone'
            },
            handle: '.move-class',
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
                switch(itemid){
                    case 'content':
                        title = 'Content';
                        bodycomponent = `
                            <div class="card-body content-component content-editor" blockid="${editid}" componenttype="content" editid="mycedit${editid}" contenteditable="true" id="mycedit${editid}">

                            </div>
                        `;
                        break
                    case 'image-left':
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
                        break
                    case 'image-right':
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
                        break
                    case 'double-image':
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
                        break
                    case 'single-image':
                        title = 'Single Image';
                        bodycomponent = `
                            <div class="card-body content-component" blockid="${editid}" componenttype="single-image" editid="mycedit${editid}">
                                <div class="row">
                                    <div class="col-12 border">
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
                                                <label for="image${editid}title" class="form-label">Caption</label>
                                                <input type="text" class="form-control" id="image${editid}title" name="image${editid}title">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                        break
                    case 'blockquote':
                        title = 'Blockquote';
                        bodycomponent = `
                            <div class="card-body content-component" blockid="${editid}" componenttype="blockquote" editid="mycedit${editid}">
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label for="quotetitle${editid}" class="form-label">Title</label>
                                        <input type="text" class="form-control" id="quotetitle${editid}" name="quotetitle${editid}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label for="mycedit${editid}" class="form-label">Content</label>
                                        <div class="col-12 border content-editor" contenteditable="true" id="mycedit${editid}">

                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label for="quotecredit${editid}" class="form-label">Credit</label>
                                        <input type="text" class="form-control" id="quotecredit${editid}" name="quotecredit${editid}">
                                    </div>
                                </div>
                            </div>
                        `;
                        break
                }
                let htmlel = `
                    <div class="card mb-3">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-1 col-md-1"><i class="fa-solid fa-up-down move-class"></i></div>
                                <div class="col-5 col-md-8">${title}</div>
                                <div class="col-4 col-md-2">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" id="display${editid}" checked>
                                        <label class="form-check-label" for="flexSwitchCheckChecked">Display</label>
                                    </div>
                                </div>
                                <div class="col-2 col-md-1 text-end">
                                    <button type="button" class="btn-close delete-component"></button>
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

        const addComponent = (itemid) => {
            removeck();
            let title = '';
            let componenttype = '';
            let bodycomponent = '';
            switch(itemid){
                    case 'content':
                        title = 'Content';
                        bodycomponent = `
                            <div class="card-body content-component content-editor" blockid="${editid}" componenttype="content" editid="mycedit${editid}" contenteditable="true" id="mycedit${editid}">

                            </div>
                        `;
                        break
                    case 'single-image':
                        title = 'Single Image';
                        bodycomponent = `
                            <div class="card-body content-component" blockid="${editid}" componenttype="single-image" editid="mycedit${editid}">
                                <div class="row">
                                    <div class="col-12 border">
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
                                                <label for="image${editid}title" class="form-label">Caption</label>
                                                <input type="text" class="form-control" id="image${editid}title" name="image${editid}title">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                        break
                    case 'image-left':
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
                                                <label for="image${editid}title" class="form-label">Caption</label>
                                                <input type="text" class="form-control" id="image${editid}title" name="image${editid}title">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 border content-editor" contenteditable="true" id="mycedit${editid}">

                                    </div>
                                </div>
                            </div>
                        `;
                        break
                    case 'image-right':
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
                                                <label for="image${editid}title" class="form-label">Caption</label>
                                                <input type="text" class="form-control" id="image${editid}title" name="image${editid}title">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                        break
                    case 'double-image':
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
                                                <label for="imageleft${editid}title" class="form-label">Caption</label>
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
                                                <label for="imageright${editid}title" class="form-label">Caption</label>
                                                <input type="text" class="form-control" id="imageright${editid}title" name="imageright${editid}title">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                        break
                    case 'blockquote':
                        title = 'Blockquote';
                        bodycomponent = `
                            <div class="card-body content-component" blockid="${editid}" componenttype="blockquote" editid="mycedit${editid}">
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label for="quotetitle${editid}" class="form-label">Title</label>
                                        <input type="text" class="form-control" id="quotetitle${editid}" name="quotetitle${editid}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label for="mycedit${editid}" class="form-label">Content</label>
                                        <div class="col-12 border content-editor" contenteditable="true" id="mycedit${editid}">

                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label for="quotecredit${editid}" class="form-label">Credit</label>
                                        <input type="text" class="form-control" id="quotecredit${editid}" name="quotecredit${editid}">
                                    </div>
                                </div>
                            </div>
                        `;
                        break
            }
            let htmlel = `
                <div class="card mb-3">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-1 col-md-1"><i class="fa-solid fa-up-down move-class"></i></div>
                            <div class="col-5 col-md-8">${title}</div>
                            <div class="col-4 col-md-2">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="display${editid}" checked>
                                    <label class="form-check-label" for="flexSwitchCheckChecked">Display</label>
                                </div>
                            </div>
                            <div class="col-2 col-md-1 text-end">
                                <button type="button" class="btn-close delete-component"></button>
                            </div>
                        </div>
                    </div>
                    ${bodycomponent}
                </div>
                `;
            $('#editorarea').append( $(htmlel) );
            bindDel();
            bindSelectImageComponent();
            setck();
            editid++;
        }

        //publish function
        const publishdata = (id,version,title) => {
            $.confirm({
                title: 'Confirm!',
                content: 'Confirm Published '+title+' ?',
                buttons: {
                    confirm:{
                        action: function () {
                            processModal.show();
                            setTimeout(() => {
                                $.ajax({
                                    url:'{{route('published')}}',
                                    method:"post",
                                    async: false,
                                    cache: false,
                                    data:{id:id,version:version},
                                    success:function(response){
                                        if(response.result){
                                            showAlert(true,'Published successful',false,1000)
                                            cversion = response.data.sys.version;
                                            $('#publish').addClass('d-none');
                                            $('#archive').addClass('d-none');
                                            $('#unarchive').addClass('d-none');
                                            $('#unpublish').removeClass('d-none');
                                        }else{
                                        showAlert(false,'Can not Published.',false,1000)
                                    }
                                    }
                                })
                            },1000)
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

        const unpublishdata = (id,version,title) => {
            $.confirm({
                title: 'Confirm!',
                content: 'Confirm Unpublished '+title+' ?',
                buttons: {
                    confirm:{
                        action: function () {
                            processModal.show();
                            setTimeout(() => {
                                $.ajax({
                                    url:'{{route('unpublished')}}',
                                    method:"post",
                                    async: false,
                                    cache: false,
                                    data:{id:id,version:version},
                                    success:function(response){
                                        if(response.result){
                                            showAlert(true,'Unpublished successful',false,2000)
                                            cversion = response.data.sys.version;
                                            $('#publish').removeClass('d-none');
                                            $('#unpublish').addClass('d-none');
                                            $('#archive').removeClass('d-none');
                                            $('#unarchive').addClass('d-none');
                                        }else{
                                            showAlert(false,'Can not Unpublished.',false,2000)
                                        }
                                    }
                                })
                            }, 1000);
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

        const archivedata = (id,version,title) => {
            $.confirm({
                title: 'Confirm!',
                content: 'Confirm Archived '+title+' ?',
                buttons: {
                    confirm:{
                        action: function () {
                            processModal.show();
                            setTimeout(() => {
                                $.ajax({
                                    url:'{{route('archived')}}',
                                    method:"post",
                                    async: false,
                                    cache: false,
                                    data:{id:id,version:version},
                                    success:function(response){
                                        if(response.result){
                                            showAlert(true,'Archived successful',false,1000)
                                            cversion = response.data.sys.version;
                                            $('#publish').addClass('d-none');
                                            $('#unpublish').addClass('d-none');
                                            $('#archive').addClass('d-none');
                                            $('#unarchive').removeClass('d-none');
                                        }else{
                                            showAlert(false,'Can not Archived.',false,1000)
                                        }
                                    }
                                })
                            },1000)
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

        const unarchivedata = (id,version,title) => {
            $.confirm({
                title: 'Confirm!',
                content: 'Confirm Unrchived '+title+' ?',
                buttons: {
                    confirm:{
                        action: function () {
                            processModal.show();
                            setTimeout(() => {
                                $.ajax({
                                    url:'{{route('unarchived')}}',
                                    method:"post",
                                    async: false,
                                    cache: false,
                                    data:{id:id,version:version},
                                    success:function(response){
                                        if(response.result){
                                            showAlert(true,'Unrchived successful',false,1000)
                                            cversion = response.data.sys.version;
                                            $('#publish').removeClass('d-none');
                                            $('#unpublish').addClass('d-none');
                                            $('#archive').removeClass('d-none');
                                            $('#unarchive').addClass('d-none');
                                        }else{
                                            showAlert(false,'Can not Unrchived.',false,1000)
                                        }
                                    }
                                })
                            },1000);
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
