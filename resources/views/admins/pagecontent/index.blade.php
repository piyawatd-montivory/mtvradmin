@extends('layout.template')
@section('title')
Content
@endsection
@section('stylesheet')
<link href="{{asset('/assets/css/datatables.min.css')}}" rel="stylesheet" />
<link href="{{asset('/assets/css/dataTables.bootstrap5.css')}}" rel="stylesheet" />
<link href="{{asset('/assets/css/select.bootstrap5.min.css')}}" rel="stylesheet" />
<link href="{{asset('/assets/css/jquery-confirm.css')}}" rel="stylesheet" />
@endsection
@section('content')
<div class="container-fluid px-4">
    <div class="row mt-3 border-bottom border-primary">
        <div class="col-6">
            <h1 class="text-primary">Content</h1>
        </div>
        <div class="col-6 text-end">
            <a class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createModal"><i class="fa-solid fa-plus"></i> Add</a>
        </div>
    </div>
    <div class="row mt-3">
        <label for="status" class="col-1 form-label">Status</label>
        <div class="col-3">
            <select class="form-select" name="status" id="status">
                <option value="all" selected>All</option>
                <option value="draft">Draft</option>
                <option value="publish">Publish</option>
                <option value="archive">Archive</option>
            </select>
        </div>
    </div>
    <div class="row pb-3 mt-3 table-responsive">
        <table id="content" class="table table-striped table-hover col-12">
            <thead>
                <tr>
                    <th class="col-5">Title</th>
                    <th class="col-2">Create</th>
                    <th class="col-1">Owner</th>
                    <th class="col-1">Status</th>
                    <th class="col-3"></th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="createModalLabel">Select Templates</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center">
            <a href="{{ route('contentnew',['type'=>'hero']) }}" class="btn btn-outline-primary mb-2">Hero Banner</a>
            <a href="{{ route('contentnew',['type'=>'slide']) }}" class="btn btn-outline-primary mb-2">Slide Banner</a>
            <a href="{{ route('contentnew',['type'=>'video']) }}" class="btn btn-outline-primary mb-2">Video Banner</a>
            <a href="{{ route('contentnew',['type'=>'podcast']) }}" class="btn btn-outline-primary mb-2">Podcast</a>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
</div>
@endsection
@section('script')
<script src="{{asset('/assets/js/datatables.min.js')}}"></script>
<script src="{{asset('/assets/js/dataTables.bootstrap5.js')}}"></script>
<script src="{{asset('/assets/js/select.bootstrap5.min.js')}}"></script>
<script src="{{asset('/assets/js/jquery-confirm.js')}}"></script>
<script>
    oTable = '';
    $(document).ready(function () {
        $('#status').on('change',function(){
            reloaddata();
        })
        oTable = $('#content').DataTable({
            ajax:{
                url: '{{ route('contentlist') }}?status='+$('#status').val(),
                dataType: 'json',
                type: 'GET'
            },
            processing: true,
            serverSide: true,
            pageLength: 25,
            search: {
                return: true,
            },
            columns: [
                { data: 'title' },
                { data: 'createat' },
                { data: 'owner' },
                { data: null },
                { data: null }
            ],
            columnDefs: [
                {
                    orderable: false,
                    targets:   2,
                },
                {
                    orderable: false,
                    targets:   3,
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
                    targets:   4,
                    render: function(data){
                        let toolsstr = `<a href="/contents/preview?id=${data.id}" class="btn btn-outline-success btn-sm" target="_blank">Preview</a> `;
                        if(data.updatetool){
                            toolsstr = toolsstr+`<a href="/contents/edit/${data.id}" class="btn btn-outline-primary btn-sm">Edit</a> `;
                        }
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
            order: [[ 1, 'desc' ]]
        });
    });

    const reloaddata = () => {
        oTable.ajax.url("{{ route('contentlist') }}?status="+$('#status').val()).load();
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
