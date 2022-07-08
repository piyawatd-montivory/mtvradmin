@extends('admins.template.template')
@section('title')
Content
@endsection
@section('stylesheet')
<link href="{{asset('/css/datatables.min.css')}}" rel="stylesheet" />
<link href="{{asset('/css/dataTables.bootstrap5.css')}}" rel="stylesheet" />
<link href="{{asset('/css/select.bootstrap5.min.css')}}" rel="stylesheet" />
@endsection
@section('content')
<div class="container-fluid px-4">
    <div class="row pb-3 mt-3">
        <div class="col-6">
            <h1>Contact</h1>
        </div>
    </div>
    <div class="row pb-3 mt-3">
        <label for="contacttype" class="col-1 col-form-label">Type</label>
        <div class="col-md-3">
            <select class="form-select" id="contacttype" name="contacttype">
                <option value="job" selected>Job</option>
                <option value="sales">Sales</option>
                <option value="partner">Partner</option>
            </select>
        </div>
    </div>
    <table id="contacttable" class="table table table-striped table-hover" style="width:100%">
        <thead>
            <tr>
                <th class="col-5">Fullname</th>
                <th class="col-2">Email</th>
                <th class="col-2">Phone</th>
                <th class="col-2">Date</th>
                <th class="col-1"></th>
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
<script>
    oTable = '';
    $(document).ready(function () {
        oTable = $('#contacttable').DataTable({
            "ajax":{
                    "url": "{{ route('contactlist') }}?type="+$('#contacttype').val(),
                    "dataType": "json",
                    "type": "GET"
            },
            "processing": true,
            "serverSide": true,
            "pageLength": 25,
            columns: [
                { data: null },
                { data: 'email' },
                { data: 'phone' },
                { data: 'date' },
                { data: null }
            ],
            columnDefs: [
                {
                    orderable: false,
                    targets:   0,
                    render: function(data){
                        if(data.flagread){
                            return data.fullname
                        }else{
                            return data.fullname+' <span class="badge rounded-pill bg-primary">new</span>'
                        }
                    }
                },
                {
                    orderable: false,
                    targets:   4,
                    render: function(data){
                        return '<a href="/admins/contacts/view/'+data.id+'" class="btn btn-outline-primary">View</a>';
                    }
                }
            ],
            order: [[ 3, 'desc' ]]
        });
        $('#contacttype').on('change',function(){
            oTable.ajax.url("{{ route('contactlist') }}?type="+$('#contacttype').val()).load();
        })
    });
</script>
@endsection
