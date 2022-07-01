@extends('admins.template.template')
@section('title')
    Content
@endsection
@section('meta')

@endsection
@section('stylesheet')

@endsection
@section('content')
<div class="container mt-5">
    <?php
    $headertitle = ' : New';
    $linkurl = route('contentcreate');
    if (!empty($content->id)){
        $headertitle = ' : Update '.$content->name;
        $linkurl = route('contentupdate',['id'=>$content->id]);
    }
    ?>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Content {{$headertitle}}</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <form id="formdata" novalidate method="post" action="{{$linkurl}}">
                @csrf
                <input type="hidden" id="id" name="id" value="{{$content->id}}"/>
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                      <button class="nav-link active" id="config-tab" data-bs-toggle="tab" data-bs-target="#config" type="button" role="tab" aria-controls="config" aria-selected="true">Config</button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="detail-tab" data-bs-toggle="tab" data-bs-target="#detail" type="button" role="tab" aria-controls="detail" aria-selected="false">Detail</button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="seo-tab" data-bs-toggle="tab" data-bs-target="#seo" type="button" role="tab" aria-controls="seo" aria-selected="false">SEO</button>
                    </li>
                  </ul>
                  <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active pt-3" id="config" role="tabpanel" aria-labelledby="config-tab">
                        @include('admins.content.config')
                    </div>
                    <div class="tab-pane fade pt-3" id="detail" role="tabpanel" aria-labelledby="detail-tab">
                        @include('admins.content.detail')
                    </div>
                    <div class="tab-pane fade pt-3" id="seo" role="tabpanel" aria-labelledby="seo-tab">
                        @include('admins.content.seo')
                    </div>
                  </div>

                <hr class="mb-4">
                <button class="btn btn-outline-primary btn-sm" type="button" onClick="submitform();">Save</button>
                <a href="{{ route('contentindex') }}" class="btn btn-outline-danger btn-sm">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="{{asset('js/validate.js')}}"></script>
<script src="{{asset('ckeditor/ckeditor.js')}}"></script>
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script>

    var option = {
        height: "400",
        customConfig: "{{ asset('js/ckconfig.js') }}",
        contentsCss: '{{asset('/css/theme.css')}}',
        filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
        filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
        filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
        filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
    }
    // //ckeditor init
    CKEDITOR.replace( 'description' , option);

    $(document).ready(function(){
        $('#imagebtn').filemanager('image');
        $('#title').focusout(function(){
            validateTitle();
        });
        // $('#url').focusout(function(){
        //     validateUrl();
        // });
    });

    function submitform(){
        if(validateTitle()){
            $('#formdata').submit();
        }
    }

    function validateTitle(){
        if(isBlank($('#title').val())){
            $('#title').removeClass('is-valid');
            $('#title').addClass('is-invalid');
            return false;
        }else{
            $('#title').removeClass('is-invalid');
            $('#title').addClass('is-valid');
            return true;
        }
    }

</script>
@endsection
