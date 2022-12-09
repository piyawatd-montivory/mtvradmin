@extends('admins.template.template')
@section('title')
User
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
            <h1 class="text-primary">User</h1>
        </div>
        <div class="col-6 text-end">
            <a class="btn btn-outline-primary btn-sm" href="{{route('usernew')}}"><i class="fa-solid fa-plus"></i> Add</a>
        </div>
    </div>
    <div class="row pb-3 mt-3">
        <table id="content" class="table table-striped table-hover col-12">
            <thead>
                <tr>
                    <th class="col-3">Firstname</th>
                    <th class="col-2">Lastname</th>
                    <th class="col-3">Email</th>
                    <th class="col-2">Role</th>
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
            ajax:{
                url: '{{ route('userlist') }}',
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
                { data: 'firstname' },
                { data: 'lastname' },
                { data: 'email' },
                { data: 'role' },
                { data: null }
            ],
            columnDefs: [
                {
                    orderable: false,
                    targets:   3,
                },
                {
                    orderable: false,
                    targets:   4,
                    render: function(data){
                        var toolsstr = `
                        <a href="/users/edit/${data.id}" class="btn btn-outline-primary btn-sm">Edit</a>`;
                        return toolsstr;
                    }
                }
            ],
            order: [[ 0, 'asc' ]]
        });
    });
</script>
@endsection
