@extends('admins.template.template')
@section('title')
Skill, Interest
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
            <h1>Skill, Interest</h1>
        </div>
        <div class="col-6 text-end">
            <a href="{{route('skillnew')}}" class="btn btn-outline-primary">Add</a>
        </div>
    </div>
    <div class="row pb-3 mt-3">
        <label for="contenttype" class="col-1 col-form-label">Type</label>
        <div class="col-md-3">
            <select class="form-select" id="contenttype" name="contenttype">
                <option value="skill">Skill</option>
                <option value="interest">Interest</option>
            </select>
        </div>
    </div>
    <table id="skill_intereststable" class="table table table-striped table-hover" style="width:100%">
        <thead>
            <tr>
                <th class="col-2">Name</th>
                <th class="col-2">Type</th>
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
        oTable = $('#skill_intereststable').DataTable({
            "ajax":{
                    "url": "{{ route('skilllist') }}?type="+$('#contenttype').val(),
                    "dataType": "json",
                    "type": "GET"
            },
            "processing": true,
            "serverSide": true,
            "pageLength": 25,
            columns: [
                { data: 'name' },
                { data: 'type' },
                { data: null }
            ],
            columnDefs: [
                {
                    orderable: false,
                    targets:   2,
                    render: function(data){
                        var toolsstr = '<a href="/admins/skills/edit/'+data.id+'" class="btn btn-outline-primary">Edit</a> ';
                        toolsstr += '<a href="javascript:deleteskill(\''+data.id+'\',\''+data.name+'\');" class="btn btn-outline-danger">Delete</a>';
                        return toolsstr;
                    }
                }
            ],
            order: [[ 0, 'asc' ]]
        });
        $('#contenttype').on('change',function(){
            oTable.ajax.url("{{ route('skilllist') }}?type="+$('#contenttype').val()).load();
        })
    });

    function deleteskill(id,name) {
        $.confirm({
            title: 'Confirm!',
            content: 'Confirm delete '+ name +' ?',
            buttons: {
                confirm:{
                    action: function () {
                        $.ajax({
                            type: "DELETE",
                            url: "{{ url('/admins/skills/delete') }}/"+id,
                            dataType:"json",
                            success: function(response){
                                $.alert('Delete success.');
                                oTable.ajax.url("{{ route('skilllist') }}").load();
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

    function makeAjaxRequest() {
    var data;
    if ($('#type').val()== 0) {
        data = { Skill };
    } else if ($('#type').val()== 1) {
        data = { Interest };
    }

    $.ajax({
        url: 'scr.php',
        type: 'get',
        data: data,
        success: function(response) {
            $('table#resultTable tbody').html(response);
        }
    });
}

</script>
@endsection
