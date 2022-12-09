@extends('admins.template.template')
@section('title')
Page Content
@endsection
@section('stylesheet')
<link href="{{asset('css/datatables.min.css')}}" rel="stylesheet" />
<link href="{{asset('css/dataTables.bootstrap5.css')}}" rel="stylesheet" />
<link href="{{asset('css/select.bootstrap5.min.css')}}" rel="stylesheet" />
<link href="{{asset('css/jquery-confirm.css')}}" rel="stylesheet" />
@endsection
@section('content')
<div class="container-fluid px-4">
    <div class="row mt-3 border-bottom border-primary">
        <div class="col-6">
            <h1 class="text-primary">Page Content</h1>
        </div>
        <div class="col-6 text-end">
            <a class="btn btn-outline-primary btn-sm" href="{{route('pagecontentnew')}}"><i class="fa-solid fa-plus"></i> Add</a>
        </div>
    </div>
    <div class="row pb-3 mt-3 table-responsive">
        <table id="content" class="table table-striped table-hover col-12">
            <thead>
                <tr>
                    <th class="col-5">Title</th>
                    <th class="col-2">Page</th>
                    <th class="col-2">Session</th>
                    <th class="col-1">Active</th>
                    <th class="col-2"></th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>
@endsection
@section('script')
<script src="{{asset('js/datatables.min.js')}}"></script>
<script src="{{asset('js/dataTables.bootstrap5.js')}}"></script>
<script src="{{asset('js/select.bootstrap5.min.js')}}"></script>
<script src="{{asset('js/jquery-confirm.js')}}"></script>
<script>
    oTable = '';
    $(document).ready(function () {
        oTable = $('#content').DataTable({
            "ajax":{
                url: '{{ route('pagecontentlist') }}',
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
                { data: 'title' },
                { data: 'page' },
                { data: 'session' },
                { data: null },
                { data: null }
            ],
            columnDefs: [
                {
                    orderable: false,
                    targets:   1
                },
                {
                    orderable: false,
                    targets:   2
                },
                {
                    orderable: false,
                    targets:   3,
                    className: 'text-center',
                    render: function(data){
                        let result = '<span class="text-secondary"><i class="fa-solid fa-circle-xmark"></i> In Active</span>';
                        if(data.active){
                            result = '<span class="text-success"><i class="fa-solid fa-circle-check"></i> Active</span>';
                        }
                        return result;
                    }
                },
                {
                    orderable: false,
                    targets:   4,
                    render: function(data){
                        let toolsstr = `<a href="/admins/pagecontents/edit/${data.id}" class="btn btn-outline-primary btn-sm">Edit</a> `;
                        if(data.archivetool){
                            toolsstr = toolsstr+`<a href="javascript:archivedata('${data.id}',${data.version},'${data.title}');" class="btn btn-sm btn-outline-warning">Archive</a> `;
                        }
                        if(data.unarchivetool){
                            toolsstr = toolsstr+`<a href="javascript:unarchivedata('${data.id}',${data.version},'${data.title}');" class="btn btn-sm btn-outline-info">Unarchive</a> `;
                        }
                        if(data.publishtool){
                            toolsstr = toolsstr+`<a href="javascript:publishdata('${data.id}',${data.version},'${data.title}');" class="btn btn-sm btn-outline-success">Publish</a>`;
                        }
                        if(data.unpublishtool){
                            toolsstr = toolsstr+`<a href="javascript:unpublishdata('${data.id}',${data.version},'${data.title}');" class="btn btn-sm btn-outline-danger">Unpublish</a>`;
                        }
                        return toolsstr;
                    }
                }
            ],
            order: [[ 0, 'desc' ]]
        });
    });

    const reloaddata = () => {
        oTable.ajax.url("{{ route('pagecontentlist') }}").load();
    }

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
