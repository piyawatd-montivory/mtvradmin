@extends('admins.template.template')
@section('title')
    Content
@endsection
@section('meta')

@endsection
@section('stylesheet')
    <link href="{{asset('/css/sorttheme.css')}}" rel="stylesheet">
@endsection
@section('content')
<div class="container mt-5">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Gallery : {{ $content->title }}</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <form id="formdata" novalidate method="post" action="{{route('contentgalleryupdate',['id'=>$content->id])}}">
                @csrf
                <input type="hidden" id="id" name="id" value="{{$content->id}}"/>
                @csrf
                <div class="row top-gallery justify-content-between">
                    <div class="col-2">
                        <a href="javascript:galleryModal.toggle();" class="btn btn-outline-primary btn-icon-split btn-sm">
                            New Images
                        </a>
                    </div>
                    <div class="col-2">
                        <button type="submit" class="btn btn-outline-primary btn-icon-split btn-sm">
                            Save
                        </button>
                        <a href="{{route('contentindex')}}" class="btn btn-outline-danger btn-sm">
                            Cancel
                        </a>
                    </div>
                </div>
                <div class="row" id="showgallery">
                    <?php
                        $galleryArray = json_decode($content->gallery);
                    ?>
                    @foreach ($galleryArray as $gallery)
                        <div class="thumbnail col-3 mt-3">
                            <div class="card">
                                <div class="caption text-end mt-1 pe-1">
                                    <a href="javascript:void(0);" class="btn btn-outline-danger delgallery" role="button">Delete</a>
                                    <input type="hidden" name="image[]" value="{{ $gallery->image }}">
                                </div>
                                <img src="{{ $gallery->image }}" class="pb-2 card-img">
                            </div>
                        </div>
                    @endforeach
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Product Variant Modal -->
<div class="modal fade" id="galleryModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="galleryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="galleryModalLabel">Gallery Image</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row mb-3">
                <label for="selimage" class="col-md-2 col-form-label">Image</label>
                <div class="col-md-6">
                    <div class="input-group">
                        <a class="btn btn-primary" id="selimagebtn" data-input="selimage" data-preview="selimage_preview">
                            <i class="far fa-image"></i> Choose
                        </a>
                        <input id="selimage" class="form-control" type="text" name="selimage" readonly>
                    </div>
                </div>
                <div class="col-md-4" id="selimage_preview">
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" onClick="javascript:addGalleryImage();">Ok</button>
        </div>
      </div>
    </div>
</div>
@endsection
@section('script')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{asset('/js/Sortable.min.js')}}"></script>
<script>
    var swaparea = document.getElementById('showgallery');
    var galleryModal = '';
    var gModalEl = document.getElementById('galleryModal');

new Sortable(swaparea, {
    swap: true,
    swapClass: 'highlight',
    animation: 150
});

$(document).ready(function () {
    $('#selimagebtn').filemanager('image');
    bliddelete();
    galleryModal =  new bootstrap.Modal(document.getElementById('galleryModal'), {backdrop:true});
});

gModalEl.addEventListener('hidden.bs.modal', function (event) {
    $('#selimage').val('');
    $('#selimage_preview').html('');
});

function addGalleryImage(){
    var text = '<div class="thumbnail col-3 mt-3"><div class="card"><div class="caption text-end mt-1 pe-1">';
        text += '<a href="javascript:void(0);" class="btn btn-outline-danger delgallery" role="button">Delete</a>';
        text += '<input type="hidden" name="image[]" value="'+$('#selimage').val()+'"></div>';
        text += '<img src="'+$('#selimage').val()+'" class="pb-2 card-img"></div></div>';
    $('#showgallery').append(text);
    $( ".delgallery").unbind( "click" );
    bliddelete();
    galleryModal.toggle();
}

function bliddelete(){
    $('.delgallery').click(function () {
        $(this).parent().parent().parent().remove();
    });
}
</script>
@endsection
