@extends('admins.template.template')
@section('title')
Team Montivory
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
            <h1>Team Montivory</h1>
        </div>
        <div class="col-6 text-end">
            <a href="{{route('montivorynew')}}" class="btn btn-outline-primary">Add</a>
        </div>
    </div>
    <table id="teammontivorytable" class="table table table-striped table-hover" style="width:100%">
        <thead>
            <tr>
                <th class="col-2">Firstname</th>
                <th class="col-2">Lastname</th>
                <th class="col-2">Job Position</th>
                <th class="col-2">Status Active</th>
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
        oTable = $('#teammontivorytable').DataTable({
            "ajax":{
                    "url": "{{ route('montivorylist') }}",
                    "dataType": "json",
                    "type": "GET"
            },
            "processing": true,
            "serverSide": true,
            "pageLength": 25,
            columns: [
                { data: 'firstname' },
                { data: 'lastname' },
                { data: 'job_position' },
                { data: 'status_active' },
                { data: null }
            ],
            columnDefs: [
                {
                    orderable: false,
                    targets:   3,
                    render: function(data){
                        var result = '<span class="text-secondary"><i class="fa-solid fa-circle-xmark"></i> In Active</span>';
                        if(data){
                            result = '<span class="text-success"><i class="fa-solid fa-circle-check"></i> Active</span>';
                        }
                        return result;
                    }
                },
                {
                    orderable: false,
                    targets:   4,
                    render: function(data){
                        var fullname = data.firstname+' '+data.lastname;
                        var toolsstr = '<a href="/admins/montivory/edit/'+data.id+'" class="btn btn-outline-primary">Edit</a> ';
                        toolsstr += '<a href="javascript:deletemontivory(\''+data.id+'\',\''+fullname+'\');" class="btn btn-outline-danger">Delete</a>';
                        return toolsstr;
                    }
                }
            ],
            order: [[ 0, 'asc' ]]
        });
    });

    function deletemontivory(id,fullname) {
        $.confirm({
            title: 'Confirm!',
            content: 'Confirm delete '+ fullname +' ?',
            buttons: {
                confirm:{
                    action: function () {
                        $.ajax({
                            type: "DELETE",
                            url: "{{ url('/admins/montivory/delete') }}/"+id,
                            dataType:"json",
                            success: function(response){
                                $.alert('Delete success.');
                                oTable.ajax.url("{{ route('montivorylist') }}").load();
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
