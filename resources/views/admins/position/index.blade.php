@extends('admins.template.template')
@section('title')
Position
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
            <h1 class="text-primary">Position</h1>
        </div>
        <div class="col-6 text-end">
            <a class="btn btn-outline-primary btn-sm" href="{{route('positionnew')}}"><i class="fa-solid fa-plus"></i> Add</a>
        </div>
    </div>
    <div class="row pb-3 mt-3 table-responsive">
        <table id="positiontable" class="table table table-striped table-hover" style="width:100%">
            <thead>
                <tr>
                    <th class="col-7">Position</th>
                    <th class="col-2">Active</th>
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
        oTable = $('#positiontable').DataTable({
            "ajax":{
                    "url": "{{ route('positionlist') }}",
                    "dataType": "json",
                    "type": "GET"
            },
            "processing": true,
            "serverSide": true,
            "pageLength": 25,
            columns: [
                { data: 'title' },
                { data: 'active' },
                { data: null }
            ],
            columnDefs: [
                {
                    orderable: false,
                    targets:   1,
                    render: function(data){
                        let result = '<span class="text-secondary"><i class="fa-solid fa-circle-xmark"></i> In Active</span>';
                        if(data){
                            result = '<span class="text-success"><i class="fa-solid fa-circle-check"></i> Active</span>';
                        }
                        return result;
                    }
                },
                {
                    orderable: false,
                    targets:   2,
                    render: function(data){
                        let toolsstr = '<a href="/admins/positions/edit/'+data.id+'" class="btn btn-sm btn-outline-primary">Edit</a> ';
                        if(data.archivetool){
                            toolsstr += '<a href="javascript:deleteposition(\''+data.id+'\',\''+data.position+'\');" class="btn btn-outline-danger btn-sm">Delete</a>';
                        }
                        return toolsstr;
                    }
                }
            ],
            order: [[ 0, 'asc' ]]
        });
    });

    function deleteposition(id,position) {
        $.confirm({
            title: 'Confirm!',
            content: 'Confirm delete '+ position +' ?',
            buttons: {
                confirm:{
                    action: function () {
                        $.ajax({
                            type: "DELETE",
                            url: "{{ url('/admins/positions/delete') }}/"+id,
                            dataType:"json",
                            success: function(response){
                                $.alert('Delete success.');
                                oTable.ajax.url("{{ route('positionlist') }}").load();
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
