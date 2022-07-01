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
    <div class="row pb-3 mt-3">
        <div class="col-6">
            <h1>Position</h1>
        </div>
        <div class="col-6 text-end">
            <a href="{{route('positionnew')}}" class="btn btn-outline-primary">Add</a>
        </div>
    </div>
    <table id="positiontable" class="table table table-striped table-hover" style="width:100%">
        <thead>
            <tr>
                <th class="col-1">Position</th>
                <th class="col-1">Short Description</th>
                <th class="col-1">Description</th>
                <th class="col-1">Status Active</th>
                <th class="col-1">Image</th>
                <th class="col-1">Og Title</th>
                <th class="col-1">Og Description</th>
                <th class="col-1">0g Image</th>
                <th class="col-1">0g Locale</th>
                <th class="col-1">Fb Pages</th>
                <th class="col-1">Fb App Id</th>
                <th class="col-1">Fb Image</th>
                <th class="col-1">Twitter Image</th>
                <th class="col-3"></th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
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
                { data: 'position' },
                { data: 'short_description' },
                { data: 'description' },
                { data: 'status_active' },
                { data: 'image' },
                { data: 'og_title' },
                { data: 'og_description' },
                { data: 'og_image' },
                { data: 'og_locale' },
                { data: 'fb_pages' },
                { data: 'fb_app_id' },
                { data: 'fb_image' },
                { data: 'twitter_image' },
                { data: null }
            ],
            columnDefs: [
                {
                    orderable: false,
                    targets:   4,
                    render: function(data){
                        var toolsstr = '<img src="'+data.image+'" class="round table-thumbnail"/>';
                        return toolsstr;
                    }
                },
                {
                    orderable: false,
                    targets:   13,
                    render: function(data){
                        var toolsstr = '<a href="/admins/positions/edit/'+data.id+'" class="btn btn-outline-primary">Edit</a> ';
                        toolsstr += '<a href="javascript:deleteposition(\''+data.id+'\',\''+data.position+'\');" class="btn btn-outline-danger">Delete</a>';
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
