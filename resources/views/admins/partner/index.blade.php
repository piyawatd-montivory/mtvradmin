@extends('admins.template.template')
@section('title')
Partner
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
            <h1>Partner</h1>
        </div>
        <div class="col-6 text-end">
            <a href="{{route('partnernew')}}" class="btn btn-outline-primary">Add</a>
        </div>
    </div>
    <table id="partnertable" class="table table table-striped table-hover" style="width:100%">
        <thead>
            <tr>
                <th class="col-3">Logo</th>
                <th class="col-6">Name</th>
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
    oTable = '';
    $(document).ready(function () {
        oTable = $('#partnertable').DataTable({
            "ajax":{
                    "url": "{{ route('partnerlist') }}",
                    "dataType": "json",
                    "type": "GET"
            },
            "processing": true,
            "serverSide": true,
            "pageLength": 25,
            columns: [
                { data: null },
                { data: 'name' },
                { data: null }
            ],
            columnDefs: [
                {
                    orderable: false,
                    targets:   0,
                    render: function(data){
                        var toolsstr = '<img src="'+data.logo+'" class="round table-thumbnail"/>';
                        return toolsstr;
                    }
                },
                {
                    orderable: false,
                    targets:   2,
                    render: function(data){
                        var toolsstr = '<a href="/admins/partners/edit/'+data.id+'" class="btn btn-outline-primary">Edit</a> ';
                        toolsstr += '<a href="javascript:deleteuser(\''+data.id+'\',\''+data.name+'\');" class="btn btn-outline-danger">Delete</a>';
                        return toolsstr;
                    }
                }
            ],
            order: [[ 1, 'asc' ]]
        });
    });

    function deleteuser(id,name) {
        $.confirm({
            title: 'Confirm!',
            content: 'Confirm delete '+name+' ?',
            buttons: {
                confirm:{
                    action: function () {
                        $.ajax({
                            type: "DELETE",
                            url: "{{ url('/admins/partners/delete') }}/"+id,
                            dataType:"json",
                            success: function(response){
                                $.alert('Delete success.');
                                oTable.ajax.url("{{ route('partnerlist') }}").load();
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
