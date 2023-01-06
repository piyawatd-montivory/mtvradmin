@extends('admins.template.template')
@section('title')
Tags
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
            <h1 class="text-primary">Tags</h1>
        </div>
        <div class="col-6 text-end">
            <a class="btn btn-outline-primary btn-sm" href="{{route('tagsnew')}}"><i class="fa-solid fa-plus"></i> Add</a>
        </div>
    </div>
    <div class="row pb-3 mt-3 table-responsive">
        <table id="tagstable" class="table table table-striped table-hover" style="width:100%">
            <thead>
                <tr>
                    <th class="col-9">Tags</th>
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
    oTable = null;
    $(document).ready(function () {
        oTable = $('#tagstable').DataTable({
            "ajax":{
                    "url": "{{ route('tagslist') }}",
                    "dataType": "json",
                    "type": "GET"
            },
            "processing": true,
            "serverSide": true,
            "pageLength": 25,
            columns: [
                { data: 'name' },
                { data: null }
            ],
            columnDefs: [
                {
                    orderable: false,
                    targets:   1,
                    render: function(data){
                        let toolsstr = '<a href="/admins/tags/edit/'+data.id+'" class="btn btn-sm btn-outline-primary">Edit</a> ';
                            toolsstr += '<a href="javascript:deletetags(\''+data.id+'\',\''+data.name+'\');" class="btn btn-outline-danger btn-sm">Delete</a>';
                        return toolsstr;
                    }
                }
            ],
            order: [[ 0, 'asc' ]]
        });
    });

    function deletetags(id,name) {
        $.confirm({
            title: 'Confirm!',
            content: 'Confirm delete '+ name +' ?',
            buttons: {
                confirm:{
                    action: function () {
                        $.ajax({
                            type: "DELETE",
                            url: "{{ url('/admins/tags/delete') }}/"+id,
                            dataType:"json",
                            success: function(response){
                                if(response.result){
                                    $.alert('Delete success.');
                                    oTable.ajax.url("{{ route('tagslist') }}").load();
                                }else{
                                    $.alert('Can not delete.Have content use this tags.');
                                }
                            }
                        });
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
