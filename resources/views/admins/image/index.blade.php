@extends('admins.template.template')
@section('title')
Images
@endsection
@section('stylesheet')
<link href="{{asset('/css/datatables.min.css')}}" rel="stylesheet" />
<link href="{{asset('/css/dataTables.bootstrap5.css')}}" rel="stylesheet" />
<link href="{{asset('/css/select.bootstrap5.min.css')}}" rel="stylesheet" />
<link href="{{asset('/css/jquery-confirm.css')}}" rel="stylesheet" />
@endsection
@section('content')
<div class="container-fluid px-4">
    <div class="row mt-3 border-bottom border-primary">
        <div class="col-6">
            <h1 class="text-primary">Images</h1>
        </div>
        <div class="col-6 text-end">
            <a class="btn btn-outline-primary btn-sm" href="{{route('imagesnew')}}"><i class="fa-solid fa-plus"></i> Add</a>
        </div>
    </div>
    <div class="row control-block mt-3">
        <div class="col-12">
            <a class="btn btn-outline-danger control-delete disabled btn-sm" href="#">Delete</a>
            <a class="btn btn-outline-warning control-archive disabled btn-sm" href="#">Archive</a>
            <a class="btn btn-outline-info control-unarchive disabled btn-sm" href="#">Unarchive</a>
            <a class="btn btn-outline-danger control-unpublish disabled btn-sm" href="#">Unpublish</a>
            <a class="btn btn-outline-success control-publish disabled btn-sm" href="#">Publish</a>
        </div>
    </div>
    <div class="row mt-3 table-responsive">
        <table id="content" class="table table-striped table-hover col-12">
            <thead>
                <tr>
                    <th class="col-1 text-center"></th>
                    <th class="col-2">Thumbnail</th>
                    <th class="col-3">Title</th>
                    <th class="col-2">Create</th>
                    <th class="col-1">Status</th>
                    <th class="col-3"></th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>
@endsection
@section('script')
<script src="{{asset('/js/datatables.min.js')}}"></script>
<script src="{{asset('/js/dataTables.bootstrap5.js')}}"></script>
<script src="{{asset('/js/select.bootstrap5.min.js')}}"></script>
<script src="{{asset('/js/jquery-confirm.js')}}"></script>
<script>
    oTable = '';
    $(document).ready(function () {
        loadTable();
        $('.control-delete').on('click',function(){
            deletedata(getCheck(),'');
        })
        $('.control-archive').on('click',function(){
            archivedata(getCheck(),'');
        })
        $('.control-unarchive').on('click',function(){
            unarchivedata(getCheck(),'');
        })
        $('.control-unpublish').on('click',function(){
            unpublishdata(getCheck(),'');
        })
        $('.control-publish').on('click',function(){
            publishdata(getCheck(),'');
        })
    });

    const liveCheck = () => {
        let selArray = [];
        let draft = 0;
        let archive = 0;
        let publish = 0;
        $.each($('.sel-id'),function(index,value){
            if($(value).is(":checked")){
                selArray.push($(value).val());
                switch($(value).attr('status')){
                    case 'draft':
                        draft++;
                        break
                    case 'publish':
                        publish++;
                        break
                    case 'archive':
                        archive++;
                        break
                }
            }
        })
        if(selArray.length > 0){
            if((draft > 0) && (publish === 0) && (archive === 0)){
                $('.control-publish').removeClass('disabled');
                $('.control-unpublish').addClass('disabled');
                $('.control-delete').removeClass('disabled');
                $('.control-archive').removeClass('disabled');
                $('.control-unarchive').addClass('disabled');
            }
            if((draft === 0) && (publish > 0) && (archive === 0)){
                $('.control-publish').addClass('disabled');
                $('.control-unpublish').removeClass('disabled');
                $('.control-delete').addClass('disabled');
                $('.control-archive').addClass('disabled');
                $('.control-unarchive').addClass('disabled');
            }
            if((draft === 0) && (publish === 0) && (archive > 0)){
                $('.control-publish').addClass('disabled');
                $('.control-unpublish').addClass('disabled');
                $('.control-delete').removeClass('disabled');
                $('.control-archive').addClass('disabled');
                $('.control-unarchive').removeClass('disabled');
            }
            if((draft > 0) && (publish > 0) && (archive > 0)){
                $('.control-publish').addClass('disabled');
                $('.control-unpublish').addClass('disabled');
                $('.control-delete').addClass('disabled');
                $('.control-archive').addClass('disabled');
                $('.control-unarchive').addClass('disabled');
            }
        }
    }

    const getCheck = () => {
        let selData = '';
        $.each($('.sel-id'),function(index,value){
            if($(value).is(":checked")){
                if(selData === ''){
                    selData = $(value).val();
                }else{
                    selData += ','+$(value).val();
                }
            }
        })
        return selData;
    }

    const loadTable = () => {
        oTable = $('#content').DataTable({
            "ajax":{
                url: '{{ route('imagelist') }}',
                "dataType": "json",
                "type": "GET"
            },
            "processing": true,
            "serverSide": true,
            "pageLength": 25,
            search: {
                return: true,
            },
            columns: [
                { data: null },
                { data: null },
                { data: 'title' },
                { data: 'createat' },
                { data: null },
                { data: null }
            ],
            columnDefs: [
                {
                    orderable: false,
                    targets:   0,
                    className: 'text-center',
                    render: function(data){
                        return `<input class="form-check-input sel-id" type="checkbox" status="${data.status}" value="${data.id}">`;
                    }
                },
                {
                    orderable: false,
                    targets:   1,
                    className: 'text-center',
                    render: function(data){
                        return `<img src="${data.file}" class="img-thumbnail mx-auto d-block"/>`;
                    }
                },
                {
                    orderable: false,
                    targets:   4,
                    className: 'text-center',
                    render: function(data){
                        let statuslabel = '';
                        if(data.status === 'draft'){
                            statuslabel = '<span class="text-danger">Draft</span>';
                        }
                        if(data.status === 'archive'){
                            statuslabel = '<span class="text-danger">Archive</span>';
                        }
                        if(data.status === 'change'){
                            statuslabel = '<span class="text-primary">Change</span>';
                        }
                        if(data.status === 'publish'){
                            statuslabel = '<span class="text-success">Publish</span>';
                        }
                        return statuslabel;
                    }
                },
                {
                    orderable: false,
                    targets:   5,
                    render: function(data){
                        let toolsstr = `<a href="/admins/contents/edit/${data.id}" class="btn btn-outline-primary btn-sm">Edit</a> `;
                        if(data.archivetool){
                            toolsstr = toolsstr+`<a href="javascript:archivedata('${data.id}','${data.title}');" class="btn btn-sm btn-outline-warning">Archive</a> `;
                        }
                        if(data.unarchivetool){
                            toolsstr = toolsstr+`<a href="javascript:unarchivedata('${data.id}','${data.title}');" class="btn btn-sm btn-outline-info">Unarchive</a> `;
                        }
                        if(data.publishtool){
                            toolsstr = toolsstr+`<a href="javascript:publishdata('${data.id}','${data.title}');" class="btn btn-sm btn-outline-success">Publish</a> `;
                        }
                        if(data.unpublishtool){
                            toolsstr = toolsstr+`<a href="javascript:unpublishdata('${data.id}','${data.title}');" class="btn btn-sm btn-outline-danger">Unpublish</a> `;
                        }
                        if(data.deletetool){
                            toolsstr = toolsstr+`<a href="javascript:deletedata('${data.id}','${data.title}');" class="btn btn-sm btn-outline-danger">Delete</a>`;
                        }
                        return toolsstr;
                    }
                }
            ],
            order: [[ 3, 'desc' ]]
        });

        oTable.on( 'draw', function () {
            $('.sel-id').on('change',function(){
                liveCheck();
            })
        });
    };

    const reloaddata = () => {
        oTable.ajax.url("{{ route('imagelist') }}").load();
    }

    const deletedata = (id,title) => {
        let msgtitle = 'Confirm Delete item ?';
        if(title !== ''){
            msgtitle = 'Confirm Delete '+title+' ?'
        }
        $.confirm({
            title: 'Confirm!',
            content: msgtitle,
            buttons: {
                confirm:{
                    action: function () {
                        processModal.show();
                        setTimeout(() => {
                            $.ajax({
                                url:'{{route('imagedelete')}}',
                                method:"post",
                                async: false,
                                cache: false,
                                data:{id:id},
                                success:function(response){
                                    if(response.result){
                                        showAlert(true,'Delete successful',false,1000)
                                        reloaddata();
                                    }else{
                                        showAlert(false,'Can not Delete.',false,1000)
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

    const publishdata = (id,title) => {
        let msgtitle = 'Confirm Published item ?';
        if(title !== ''){
            msgtitle = 'Confirm Published '+title+' ?'
        }
        $.confirm({
            title: 'Confirm!',
            content: msgtitle,
            buttons: {
                confirm:{
                    action: function () {
                        processModal.show();
                        setTimeout(() => {
                            $.ajax({
                                url:'{{route('imagepublished')}}',
                                method:"post",
                                async: false,
                                cache: false,
                                data:{id:id},
                                success:function(response){
                                    if(response.result){
                                        showAlert(true,'Published successful',false,1000)
                                        reloaddata();
                                    }else{
                                        showAlert(false,'Can not Published.',false,1000)
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

    const unpublishdata = (id,title) => {
        let msgtitle = 'Confirm Unpublished item ?';
        if(title !== ''){
            msgtitle = 'Confirm Unpublished '+title+' ?'
        }
        $.confirm({
            title: 'Confirm!',
            content: msgtitle,
            buttons: {
                confirm:{
                    action: function () {
                        processModal.show();
                        setTimeout(() => {
                            $.ajax({
                                url:'{{route('imageunpublished')}}',
                                method:"post",
                                async: false,
                                cache: false,
                                data:{id:id},
                                success:function(response){
                                    if(response.result){
                                        showAlert(true,'Unpublished successful',false,1000)
                                        reloaddata();
                                    }else{
                                        showAlert(false,'Can not Unpublished.',false,1000)
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

    const archivedata = (id,title) => {
        let msgtitle = 'Confirm Archived item ?';
        if(title !== ''){
            msgtitle = 'Confirm Archived '+title+' ?'
        }
        $.confirm({
            title: 'Confirm!',
            content: msgtitle,
            buttons: {
                confirm:{
                    action: function () {
                        processModal.show();
                        setTimeout(() => {
                            $.ajax({
                                url:'{{route('imagearchived')}}',
                                method:"post",
                                async: false,
                                cache: false,
                                data:{id:id},
                                success:function(response){
                                    if(response.result){
                                        showAlert(true,'Archived successful',false,1000)
                                        reloaddata();
                                    }else{
                                        showAlert(false,'Can not Archived.',false,1000)
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

    const unarchivedata = (id,title) => {
        let msgtitle = 'Confirm Unrchived item ?';
        if(title !== ''){
            msgtitle = 'Confirm Unrchived '+title+' ?'
        }
        $.confirm({
            title: 'Confirm!',
            content: msgtitle,
            buttons: {
                confirm:{
                    action: function () {
                        processModal.show();
                        setTimeout(() => {
                            $.ajax({
                                url:'{{route('imageunarchived')}}',
                                method:"post",
                                async: false,
                                cache: false,
                                data:{id:id},
                                success:function(response){
                                    if(response.result){
                                        showAlert(true,'Unarchived successful',false,1000)
                                        reloaddata();
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
