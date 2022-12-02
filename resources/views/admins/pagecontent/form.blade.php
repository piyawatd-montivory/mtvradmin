@extends('admins.template.template')
@section('title')
    Page Content
@endsection
@section('meta')

@endsection
@section('stylesheet')
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
                        <button name="submitbtn" id="submitbtn" class="btn btn-outline-primary btn-sm" type="button" onclick="javascript:buildData('save');">Save</button>
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
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="configtab" role="tabpanel" aria-labelledby="config-tab">
                        @include('admins.pagecontent.tab-config')
                    </div>
                    <div class="tab-pane fade" id="contenttab" role="tabpanel" aria-labelledby="content-tab">
                        @include('admins.pagecontent.tab-content')
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script src="{{asset('js/validate.js')}}"></script>
    <script src="//cdn.ckeditor.com/4.19.1/full/ckeditor.js"></script>
    <script type="text/javascript">

        CKEDITOR.disableAutoInline = true;
        let contentid = '{{$data->id}}';
        let contentversion = {{$data->version}};
        CKEDITOR.inline( 'editorarea' ,{
            customConfig: "{{ asset('js/ckcontentconfig.js') }}",
            enterMode: CKEDITOR.ENTER_BR,
            shiftEnterMode: CKEDITOR.ENTER_P,
            filebrowserImageBrowseUrl: '{{ route('imageck') }}'
        });

        $( document ).ready(function() {
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
            if(!checkSlug()){
                reporterror('checkslug');
                pass = false;
            }
            if(pass){
                let data = {};
                data.id = contentid;
                data.version = contentversion;
                data.title = $('#title').val();
                data.slug = $('#slug').val();
                //content
                data.content = CKEDITOR.instances['editorarea'].getData();
                data.active = $('#active').is(":checked");
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
                            contentid = response.sys.id;
                            contentversion = response.sys.version;
                            showAlert(true,'Save successful')
                            window.location.href = '/pagecontents/edit/'+contentid;
                        }
                    })
                },1000);
            }
        }
    </script>
@endsection
