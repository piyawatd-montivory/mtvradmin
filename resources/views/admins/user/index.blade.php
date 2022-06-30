@extends('admins.template.template')
@section('title')
User
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
            <h1>User</h1>
        </div>
        <div class="col-6 text-end">
            <a href="{{route('usernew')}}" class="btn btn-outline-primary">Add</a>
        </div>
    </div>
    <table id="usertable" class="table table table-striped table-hover" style="width:100%">
        <thead>
            <tr>
                <th class="col-3">Firstname</th>
                <th class="col-3">Lastname</th>
                <th class="col-3">Email</th>
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
    tUser = '';
    $(document).ready(function () {
        tUser = $('#usertable').DataTable({
            "ajax":{
                    "url": "{{ route('userlist') }}",
                    "dataType": "json",
                    "type": "GET"
            },
            "processing": true,
            "serverSide": true,
            "pageLength": 25,
            columns: [
                { data: 'firstname' },
                { data: 'lastname' },
                { data: 'email' },
                { data: null }
            ],
            columnDefs: [
                {
                    orderable: false,
                    targets:   3,
                    render: function(data){
                        var toolsstr = '<a href="/admins/users/edit/'+data.id+'" class="btn btn-outline-primary">Edit</a> ';
                        toolsstr += '<a href="javascript:deleteuser(\''+data.id+'\',\''+data.firstname+' '+data.lastname+'\');" class="btn btn-outline-danger">Delete</a>';
                        return toolsstr;
                    }
                }
            ],
            order: [[ 1, 'asc' ]]
        });
    });

    function deleteuser(id,fullname) {
        $.confirm({
            title: 'Confirm!',
            content: 'Confirm delete '+fullname+' ?',
            buttons: {
                confirm:{
                    action: function () {
                        $.ajax({
                            type: "DELETE",
                            url: "{{ url('/admins/users/delete') }}/"+id,
                            dataType:"json",
                            success: function(response){
                                $.alert('Delete success.');
                                tUser.ajax.url("{{ route('userlist') }}").load();
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
