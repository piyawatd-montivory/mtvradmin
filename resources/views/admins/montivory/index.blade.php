@extends('admins.template.template')
@section('title')
Team Montivory
@endsection
@section('stylesheet')
<link href="{{asset('/css/datatables.min.css')}}" rel="stylesheet" />
<link href="{{asset('/css/dataTables.bootstrap5.css')}}" rel="stylesheet" />
<link href="{{asset('/css/select.bootstrap5.min.css')}}" rel="stylesheet" />
<link href="{{asset('/css/jquery-confirm.css')}}" rel="stylesheet" />
<link href="{{asset('/css/sorttheme.css')}}" rel="stylesheet">
@endsection
@section('content')
<div class="container-fluid px-4">
    <div class="row pb-3 mt-3">
        <div class="col-6">
            <h1>Team Montivory</h1>
        </div>
        <div class="col-6 text-end">
            <a href="{{route('montivorynew')}}" class="btn btn-outline-primary normal-btn">Add</a>
            <a href="javascript:reorderform();" class="btn btn-outline-primary normal-btn">Re Order</a>
            <a href="javascript:reorder();" class="btn btn-outline-primary reorder-update-btn" style="display: none;">Save</a>
            <a href="javascript:cancelreorder();" class="btn btn-outline-danger reorder-update-btn" style="display: none;">Cancel</a>
        </div>
    </div>
    <div class="row" id="show-table">
        <div class="col-12">
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
    </div>
    <div class="row" id="sorttable" style="display: none;">
        @foreach ($teams as $team)
            <div class="thumbnail col-2 mt-3" team-id="{{ $team->id }}">
                <div class="card">
                    {{ $team->firstname}} {{ $team->lastname}}
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
@section('script')
<script src="{{asset('/js/datatables.min.js')}}"></script>
<script src="{{asset('/js/dataTables.bootstrap5.js')}}"></script>
<script src="{{asset('/js/select.bootstrap5.min.js')}}"></script>
<script src="{{asset('/js/jquery-confirm.js')}}"></script>
<script src="{{asset('/js/Sortable.min.js')}}"></script>
<script>
    var oTable;
    var swaparea = document.getElementById('sorttable');
    new Sortable(swaparea, {
        swap: true,
        swapClass: 'highlight',
        animation: 150
    });

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

    function reorder(){
        var id = [];
        $.each($('#sorttable div.thumbnail'),function(key,value){
            id.push($(value).attr('team-id'));
        });
        $.ajax({
            url:'{{ route('montivoryreorder') }}',
            method: "POST",
            data: {'id':id},
            success: function(response){
                $.alert('Reorder success.');
                oTable.ajax.url("{{ route('montivorylist') }}").load();
                cancelreorder();
            }
        })
    }

    function reorderform() {
        $('.normal-btn').hide();
        $('#show-table').fadeOut(500,function(){
            $('#sorttable').fadeIn(500);
            $('.reorder-update-btn').show();
        });
    }

    function cancelreorder(){
        $('.reorder-update-btn').hide();
        $('#sorttable').fadeOut(500,function(){
            $('#show-table').fadeIn(500);
            $('.normal-btn').show();
        });
    }

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
