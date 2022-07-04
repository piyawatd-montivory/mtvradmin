@extends('admins.template.template')
@section('title')
Partner
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
            <h1>Partner</h1>
        </div>
        <div class="col-6 text-end">
            <a href="{{route('partnernew')}}" class="btn btn-outline-primary">Add</a>
            <a href="javascript:reorderform();" class="btn btn-outline-primary reorder-btn">Re Order</a>
            <a href="javascript:reorder();" class="btn btn-outline-primary reorder-update-btn d-none">Save</a>
            <a href="javascript:cancelreorder();" class="btn btn-outline-danger reorder-update-btn d-none">Cancel</a>
        </div>
    </div>
    <div class="row" id="show-table">
        <div class="col-12">
            <table id="partnertable" class="table table table-striped table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th class="col-3">Logo</th>
                        <th class="col-5">Name</th>
                        <th class="col-1">Order</th>
                        <th class="col-3"></th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
    <div class="row d-none" id="sorttable">
        @foreach ($partners as $partner)
            <div class="thumbnail col-3 mt-3" partner-id="{{ $partner->id }}">
                <div class="card">
                    <img src="{{ $partner->logo }}" class="pb-2 card-img">
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
    var swaparea = document.getElementById('sorttable');
    new Sortable(swaparea, {
        swap: true,
        swapClass: 'highlight',
        animation: 150
    });

    function reorderform() {
        $('.reorder-update-btn').removeClass('d-none');
        $('.reorder-btn').addClass('d-none');
        $('#sorttable').removeClass('d-none');
        $('#show-table').addClass('d-none');
    }

    function cancelreorder(){
        $('.reorder-update-btn').addClass('d-none');
        $('.reorder-btn').removeClass('d-none');
        $('#sorttable').addClass('d-none');
        $('#show-table').removeClass('d-none');
    }

    function reorder(){
        var id = [];
        $.each($('#sorttable div.thumbnail'),function(key,value){
            id.push($(value).attr('partner-id'));
        });
        $.ajax({
            url:'{{ route('partnerreorder') }}',
            method: "POST",
            data: {'id':id},
            success: function(response){
                $.alert('Reorder success.');
                oTable.ajax.url("{{ route('partnerlist') }}").load();
                cancelreorder();
            }
        })
    }

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
                { data: 'sortorder' },
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
                    targets:   3,
                    render: function(data){
                        var toolsstr = '<a href="/admins/partners/edit/'+data.id+'" class="btn btn-outline-primary">Edit</a> ';
                        toolsstr += '<a href="javascript:deleteuser(\''+data.id+'\',\''+data.name+'\');" class="btn btn-outline-danger">Delete</a>';
                        return toolsstr;
                    }
                }
            ],
            order: [[ 2, 'asc' ]]
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
