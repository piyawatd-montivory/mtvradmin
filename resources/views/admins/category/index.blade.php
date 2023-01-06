@extends('admins.template.template')
@section('title')
Category
@endsection
@section('stylesheet')
<link href="{{asset('css/datatables.min.css')}}" rel="stylesheet" />
<link href="{{asset('css/dataTables.bootstrap5.css')}}" rel="stylesheet" />
<link href="{{asset('css/select.bootstrap5.min.css')}}" rel="stylesheet" />
<link href="{{asset('css/jquery-confirm.css')}}" rel="stylesheet" />
<style>
table.dataTable.table-striped > tbody > tr.odd.selected > * {
  box-shadow: inset 0 0 0 9999px rgba(171, 172, 177, 0.95);
}
table.dataTable.table-striped > tbody > tr.even.selected > * {
  box-shadow: inset 0 0 0 9999px rgba(171, 172, 177, 0.95);
}
</style>
@endsection
@section('content')
<div class="container-fluid px-4">
    <div class="row mt-3 border-bottom border-primary">
        <div class="col-6">
            <h1 class="text-primary">Category</h1>
        </div>
        <div class="col-6 text-end">
            {{-- @if(authuser()->role == 'admin') --}}
            <a class="btn btn-outline-primary btn-sm" href="{{route('categorynew')}}"><i class="fa-solid fa-plus"></i> Add</a>
            {{-- @endif --}}
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-6 col-12 pb-3">
            <h3 class="text-primary border-bottom border-primary">Main</h3>
            <div class="table-responsive">
                <table id="main-category" class="table table-striped table-hover">
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
        </div>
        <div class="col-md-6 col-12 pb-3">
            <h3 class="text-primary border-bottom border-primary">Sub Category</h3>
            <div class="table-responsive">
                <table id="sub-category" class="table table-striped table-hover">
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
        </div>
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
    oSubTable = '';
    $(document).ready(function () {
        oTable = $('#main-category').DataTable({
            ajax:{
                url: '{{ route('categorylist') }}?main=true',
                dataType: 'json',
                type: 'GET'
            },
            select: true,
            processing: true,
            serverSide: true,
            pageLength: 25,
            search: {
                return: true,
            },
            columns: [
                { data: 'title' },
                { data: 'categoryorder' },
                { data: null }
            ],
            columnDefs: [
                {
                    targets:   1,
                    className: 'text-center'
                },
                {
                    orderable: false,
                    targets:   2,
                    render: function(data){
                        let toolsstr = `<a href="/admins/categories/edit/${data.id}" class="btn btn-outline-primary btn-sm">Edit</a> `;
                        if(data.archivetool){
                            toolsstr = toolsstr+`<a href="javascript:archivedata('${data.id}',${data.version},'${data.title}');" class="btn btn-sm btn-outline-warning">Archive</a> `;
                        }
                        return toolsstr;
                    }
                }
            ],
            order: [[ 1, 'asc' ]]
        });
        oTable.on( 'select', function ( e, dt, type, indexes ) {
            if ( type === 'row' ) {
                let data = oTable.rows( indexes ).data();
                refreshsubtable(data[0].id);
            }
        });
        oSubTable = $('#sub-category').DataTable({
            ajax:{
                url: '{{ route('categorylist') }}?main=false&id=main',
                dataType: 'json',
                type: 'GET'
            },
            select: true,
            processing: true,
            serverSide: true,
            pageLength: 25,
            search: {
                return: true,
            },
            columns: [
                { data: 'title' },
                { data: 'categoryorder' },
                { data: null }
            ],
            columnDefs: [
                {
                    targets:   1,
                    className: 'text-center'
                },
                {
                    orderable: false,
                    targets:   2,
                    render: function(data){
                        let toolsstr = `<a href="/admins/categories/edit/${data.id}" class="btn btn-outline-primary btn-sm">Edit</a> `;
                        if(data.archivetool){
                            toolsstr = toolsstr+`<a href="javascript:archivedata('${data.id}',${data.version},'${data.title}');" class="btn btn-sm btn-outline-warning">Archive</a> `;
                        }
                        return toolsstr;
                    }
                }
            ],
            order: [[ 1, 'asc' ]]
        });
    });

    const refreshsubtable = (id) => {
        oSubTable.ajax.url('{{ route('categorylist') }}?main=false&id='+id).load();
    }

    const archivedata = (id,version,title) => {
        $.confirm({
            title: 'Confirm!',
            content: 'Confirm Archived '+title+' ?',
            buttons: {
                confirm:{
                    action: function () {
                        processModal.show();
                        setTimeout(() => {
                            $.ajax({
                                url:'{{route('categoryarchived')}}',
                                method:"post",
                                async: false,
                                cache: false,
                                data:{id:id,version:version},
                                success:function(response){
                                    if(response.result){
                                        showAlert(true,'Archived successful',false,1000)
                                        oTable.ajax.url('{{ route('categorylist') }}?main=true').load();
                                        oSubTable.ajax.url('{{ route('categorylist') }}?main=false&id=main').load();
                                    }else{
                                        showAlert(false,'Can not Archived.',false,1000)
                                    }
                                }
                            })
                        },1000);
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
