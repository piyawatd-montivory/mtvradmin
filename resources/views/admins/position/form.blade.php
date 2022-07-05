@extends('admins.template.template')
@section('title')
    Position
@endsection
@section('meta')

@endsection
@section('stylesheet')
<link href="{{asset('/css/tags.css')}}" rel="stylesheet" />
<link href="{{asset('/css/datatables.min.css')}}" rel="stylesheet" />
<link href="{{asset('/css/dataTables.bootstrap5.css')}}" rel="stylesheet" />
<link href="{{asset('/css/select.bootstrap5.min.css')}}" rel="stylesheet" />
@endsection
@section('content')
<div class="container mt-5">
    <?php
    $headertitle = ' : New';
    $linkurl = route('positioncreate');
    if (!empty($position->id)){
        $headertitle = ' : Update '.$position->name;
        $linkurl = route('positionupdate',['id'=>$position->id]);
    }
    ?>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Position {{$headertitle}}</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <form id="formdata" novalidate method="post" action="{{$linkurl}}">
                @csrf
                <input type="hidden" id="id" name="id" value="{{$position->id}}"/>
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                      <button class="nav-link active" id="detail-tab" data-bs-toggle="tab" data-bs-target="#detailtab" type="button" role="tab" aria-controls="detail" aria-selected="true">Detail</button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="description-tab" data-bs-toggle="tab" data-bs-target="#descriptiontab" type="button" role="tab" aria-controls="description" aria-selected="false">Description</button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="seo-tab" data-bs-toggle="tab" data-bs-target="#seotab" type="button" role="tab" aria-controls="seo" aria-selected="false">SEO</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active pt-3" id="detailtab" role="tabpanel" aria-labelledby="detailtab">
                        @include('admins.position.detail')
                    </div>
                    <div class="tab-pane fade pt-3" id="descriptiontab" role="tabpanel" aria-labelledby="descriptiontab">
                        @include('admins.position.description')
                    </div>
                    <div class="tab-pane fade pt-3" id="seotab" role="tabpanel" aria-labelledby="seotab">
                        @include('admins.position.seo')
                    </div>
                </div>
                <hr class="mb-4">
                <div class="row mb-3">
                    <div class="col-12 pb-3">
                        <button class="btn btn-outline-primary btn-sm" type="button" onClick="submitform();">Save</button>
                        <a href="{{ route('positionindex') }}" class="btn btn-outline-danger btn-sm">Cancel</a>
                    </div>
            </form>
        </div>
    </div>
</div>
<!-- skill Modal -->
<div class="modal fade" id="skillModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="skillModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="skillModalLabel">Skill</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <table id="list-skill" class="table table-striped table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" onClick="javascript:browseskill();">Select</button>
        </div>
      </div>
    </div>
</div>
<!-- interest Modal -->
<div class="modal fade" id="interestModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="interestModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="interestModalLabel">Interest</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <table id="list-interest" class="table table-striped table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" onClick="javascript:browseinterest();">Select</button>
        </div>
      </div>
    </div>
</div>
@endsection
@section('script')
<script src="{{asset('js/validate.js')}}"></script>
<script src="{{asset('ckeditor/ckeditor.js')}}"></script>
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{asset('/js/datatables.min.js')}}"></script>
<script src="{{asset('/js/dataTables.bootstrap5.js')}}"></script>
<script src="{{asset('/js/select.bootstrap5.min.js')}}"></script>
<script>

    var option = {
        height: "400",
        customConfig: "{{ asset('js/ckconfig.js') }}",
        contentsCss: '{{asset('/css/theme.css')}}',
        filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
        filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
        filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
        filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
    }
    // //ckeditor init
    CKEDITOR.replace( 'description' , option);

    var skillModal = '';
    var interestModal = '';
    var oSkillTable = '';
    var oInterestTable = '';


    $(document).ready(function(){
        $('#imagebtn').filemanager('image');
        $('#alias').focusout(function(){
            validateAlias();
        });
        $('#position').focusout(function(){
            validatePosition();
        });
        $('#short_description').focusout(function(){
            validateShortDescription();
        });
        $('#description').focusout(function(){
            validateDescription();
        });
        oSkillTable = $('#list-skill').DataTable({
            data: {!! htmlspecialchars_decode(json_encode($skills)) !!},
            columns: [
                { data: null },
                { data: 'name' }
            ],
            columnDefs: [ {
                orderable: false,
                className: 'select-checkbox',
                targets:   0,
                data: null,
                defaultContent: '',
            } ],
            select: {
                style:    'multi',
                selector: 'td:first-child'
            },
            order: [[ 1, 'asc' ]]
        });
        oInterestsTable = $('#list-interest').DataTable({
            data: {!! htmlspecialchars_decode(json_encode($interests)) !!},
            columns: [
                { data: null },
                { data: 'name' }
            ],
            columnDefs: [ {
                orderable: false,
                className: 'select-checkbox',
                targets:   0,
                data: null,
                defaultContent: '',
            } ],
            select: {
                style:    'multi',
                selector: 'td:first-child'
            },
            order: [[ 1, 'asc' ]]
        });
        skillModal = new bootstrap.Modal(document.getElementById('skillModal'), {backdrop:true});
        interestModal =  new bootstrap.Modal(document.getElementById('interestModal'), {backdrop:true});
        removeSkillInterest();
    });

    function browseskill(){
        var skillSel = oSkillTable.rows({ selected: true }).data();
        if (skillSel.length > 0)
        {
            skillModal.toggle();
            $.each(skillSel, function(cindex,cvalue){;
                var newitem = true;
                $.each($('#skill-listitem').children(), function( index, value ) {
                    var skillid = $(value).attr('id');
                    if(cvalue.id == skillid)
                    {
                        newitem = false;
                        return false;
                    }
                });
                if(newitem){
                    var itemstr = '<span class="tag tag-label" id="'+cvalue.id+'">';
                        itemstr += '<input type="hidden" name="skillid[]" value="'+cvalue.id+'"/>'+cvalue.name+'<span class="remove">x</span></span> ';
                    $('#skill-listitem').append(itemstr);
                }
            });
            removeSkillInterest();
        }
    }

    function browseinterest(){
        var interestSel = oInterestsTable.rows({ selected: true }).data();
        if (interestSel.length > 0)
        {
            interestModal.toggle();
            $.each(interestSel, function(cindex,cvalue){;
                var newitem = true;
                $.each($('#interest-listitem').children(), function( index, value ) {
                    var interestid = $(value).attr('id');
                    if(cvalue.id == interestid)
                    {
                        newitem = false;
                        return false;
                    }
                });
                if(newitem){
                    var itemstr = '<span class="tag tag-label" id="'+cvalue.id+'">';
                        itemstr += '<input type="hidden" name="interestid[]" value="'+cvalue.id+'"/>'+cvalue.name+'<span class="remove">x</span></span> ';
                    $('#interest-listitem').append(itemstr);
                }
            });
            removeSkillInterest();
        }
    }

    function removeSkillInterest(){
        $( ".remove").unbind( "click" );
        $('.remove').click(function () {
            $(this).parent().remove();
        });
    }

    function submitform(){
        @if(empty($position->id))
        if(isBlank($('#image').val())){
            $('#image').removeClass('is-valid');
            $('#image').addClass('is-invalid');
            return false;
        }else{
            $('#image').removeClass('is-invalid');
            $('#image').addClass('is-valid');
        }
        @endif
        if(validatePosition() && validateShortDescription() && validateDescription() && validateAlias()){
            $('#formdata').submit();
        }
    }

    function validateAlias(){
        if(isBlank($('#alias').val())){
            $('#alias').removeClass('is-valid');
            $('#alias').addClass('is-invalid');
            return false;
        }else{
            $('#alias').removeClass('is-invalid');
            $('#alias').addClass('is-valid');
            return true;
        }
    }

    function validatePosition(){
        if(isBlank($('#position').val())){
            $('#position').removeClass('is-valid');
            $('#position').addClass('is-invalid');
            return false;
        }else{
            $('#position').removeClass('is-invalid');
            $('#position').addClass('is-valid');
            return true;
        }
    }

    function validateShortDescription(){
        if(isBlank($('#short_description').val())){
            $('#short_description').removeClass('is-valid');
            $('#short_description').addClass('is-invalid');
            return false;
        }else{
            $('#short_description').removeClass('is-invalid');
            $('#short_description').addClass('is-valid');
            return true;
        }
    }

    function validateDescription(){

        if(CKEDITOR.instances['description'].getData() == ''){
            $('#description').removeClass('is-valid');
            $('#description').addClass('is-invalid');
            return false;
        }
        $('#description').removeClass('is-invalid');
        $('#description').addClass('is-valid');
        return true;
    }

</script>
@endsection
