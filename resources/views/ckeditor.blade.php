<!DOCTYPE html><!--
	Copyright (c) 2014-2022, CKSource Holding sp. z o.o. All rights reserved.
	This file is licensed under the terms of the MIT License (see LICENSE.md).
-->

<html lang="en" dir="ltr">
	<head>
		<title>Example CK</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="{{asset('/css/sb-admin.css')}}" rel="stylesheet" />

	</head>
	<body>
        <div class="container">
            <div class="row">
                <div class="col-md-12 pb-3">
                    <div id="editor">

                    </div>
                </div>
            </div>
            <div class="row">
                <label for="thumbnail_th" class="col-md-2 col-form-label">Thumbnail</label>
                <div class="col-md-5">
                    <div class="input-group">
                        <a class="btn btn-primary" id="thumbth" data-input="thumbnail_th" data-preview="thumbnail_preview_th">
                            <i class="far fa-image"></i> Choose
                        </a>
                        <input id="thumbnail_th" class="form-control" type="text" name="thumbnail_th" readonly>
                    </div>
                </div>
                <div class="col-md-4" id="thumbnail_preview_th">

                </div>
            </div>
        </div>
        <script src="{{asset('js/jquery-3.6.0.min.js')}}"></script>
        <script src="{{asset('ckeditor/ckeditor.js')}}"></script>
        <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
		<script>
        //ckeditor config
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
            CKEDITOR.replace( 'editor' , option);
            $('#thumbth').filemanager('image');
		</script>
	</body>
</html>
