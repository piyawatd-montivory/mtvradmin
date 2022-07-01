@extends('admins.template.template')
@section('title')
Content
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
            <h1>Content</h1>
        </div>
        <div class="col-6 text-end">
            <a href="{{route('contentnew')}}" class="btn btn-outline-primary">Add</a>
        </div>
    </div>
    <div class="row pb-3 mt-3">
        <label for="contenttype" class="col-1 col-form-label">Type</label>
        <div class="col-md-3">
            <select class="form-select" id="contenttype" name="contenttype">
                <option value="testimonial">Testimonial</option>
                <option value="benefit">Benefit</option>
            </select>
        </div>
    </div>
    <table id="contenttable" class="table table table-striped table-hover" style="width:100%">
        <thead>
            <tr>
                <th class="col-8">Title</th>
                <th class="col-1">Order</th>
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
        oTable = $('#contenttable').DataTable({
            "ajax":{
                    "url": "{{ route('contentlist') }}?type="+$('#contenttype').val(),
                    "dataType": "json",
                    "type": "GET"
            },
            "processing": true,
            "serverSide": true,
            "pageLength": 25,
            columns: [
                { data: 'title' },
                { data: 'sortorder' },
                { data: null }
            ],
            columnDefs: [
                {
                    orderable: false,
                    targets:   2,
                    render: function(data){
                        var toolsstr = '<a href="/admins/contents/edit/'+data.id+'" class="btn btn-outline-primary">Edit</a> ';
                        toolsstr += '<a href="/admins/contents/gallery/'+data.id+'" class="btn btn-outline-primary">Gallery</a> ';
                        toolsstr += '<a href="javascript:deleteuser(\''+data.id+'\',\''+data.title+'\');" class="btn btn-outline-danger">Delete</a>';
                        return toolsstr;
                    }
                }
            ],
            order: [[ 1, 'asc' ]]
        });
        $('#contenttype').on('change',function(){
            oTable.ajax.url("{{ route('contentlist') }}?type="+$('#contenttype').val()).load();
        })
    });

    function deleteuser(id,title) {
        $.confirm({
            title: 'Confirm!',
            content: 'Confirm delete '+title+' ?',
            buttons: {
                confirm:{
                    action: function () {
                        $.ajax({
                            type: "DELETE",
                            url: "{{ url('/admins/contents/delete') }}/"+id,
                            dataType:"json",
                            success: function(response){
                                $.alert('Delete success.');
                                oTable.ajax.url("{{ route('contentlist') }}?type="+$('#contenttype').val()).load();
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
