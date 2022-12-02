@extends('admins.template.template')
@section('title')
Skill, Interest
@endsection
@section('meta')

@endsection
@section('stylesheet')
<link href="{{asset('css/tags.css')}}" rel="stylesheet" />
@endsection
@section('content')
<div class="container mt-5">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Skill & Interest</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <form id="formdata" action="#">
                <div class="mb-3">
                    <div class="col-12 mt-2 text-end">
                        <button name="submitbtn" id="submitbtn" class="btn btn-outline-primary btn-sm" type="button" onclick="javascript:buildData();">Save</button>
                        <a href="{{ route('skillindex') }}" class="btn btn-outline-danger btn-sm">Cancel</a>
                    </div>
                </div>
                <hr/>
                <div class="mb-3 row">
                    <div class="col-6">
                        <h3 class="text-primary border-bottom border-primary">Skills</h3>
                        <div class="mb-3 row">
                            <div class="col-12 col-md-10">
                                <input type="text" id="newskill" name="newskill" class="form-control"/>
                            </div>
                            <div class="col-12 col-md-2 mt-md-0 mt-2">
                                <button type="button" class="btn btn-outline-primary btn-sm" id="add-skill">Add</button>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-12" id="skill-listitem">
                                @foreach ($data->skills as $skill)
                                    <span class="tag tag-label tag-skill" key="{{$skill}}">
                                        {{$skill}}<span class="remove">x</span>
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <h3 class="text-primary border-bottom border-primary">Interests</h3>
                        <div class="mb-3 row">
                            <div class="col-12 col-md-10">
                                <input type="text" id="newinterest" name="newinterest" class="form-control"/>
                            </div>
                            <div class="col-12 col-md-2 mt-md-0 mt-2">
                                <button type="button" class="btn btn-outline-primary btn-sm" id="add-interest">Add</button>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-12" id="interest-listitem">
                                @foreach ($data->interests as $interest)
                                    <span class="tag tag-label tag-interest" key="{{$interest}}">
                                        {{$interest}}<span class="remove">x</span>
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="{{asset('js/validate.js')}}"></script>
<script>

    let cversion = {{$data->version}};
    $(function(){
        $('#add-skill').on('click',function(){
            addSkill();
        })
        $('#add-interest').on('click',function(){
            addInterest();
        })
        removetag();
    })

    const addSkill = () => {
        let newitem = true;
        let itemtext = $('#newskill').val().trim();
        $.each($('#skill-listitem').children(), function( index, value ) {
            if($(value).attr('key') === itemtext)
            {
                newitem = false;
                return false;
            }
        });
        if(newitem){
            let itemstr = `
                <span class="tag tag-label tag-skill" key="${itemtext}">
                    ${itemtext}<span class="remove">x</span>
                </span> `;
            $('#skill-listitem').append(itemstr);
            removetag();
        }
        $('#newskill').val('');
    }

    const addInterest = () => {
        let newitem = true;
        let itemtext = $('#newinterest').val().trim();
        $.each($('#interest-listitem').children(), function( index, value ) {
            if($(value).attr('key') === itemtext)
            {
                newitem = false;
                return false;
            }
        });
        if(newitem){
            let itemstr = `
                <span class="tag tag-label tag-interest" key="${itemtext}">
                    ${itemtext}<span class="remove">x</span>
                </span> `;
            $('#interest-listitem').append(itemstr);
            removetag();
        }
        $('#newinterest').val('');
    }

    const removetag = () => {
        $( ".remove").unbind( "click" );
        $('.remove').click(function () {
            $(this).parent().remove();
        });
    }

    const buildData = () => {
        let pass = true;
        $.each($('.validate'),function(i,obj){
            if($(obj).val().trim().length === 0){
                $(obj).addClass('is-invalid');
                pass = false;
            }else{
                $(obj).removeClass('is-invalid');
            }
        });
        if(pass){
            let data = {};
            data.id = '{{$data->id}}';
            data.version = cversion;
            data.skills = [];
            data.interests = [];
            $.each($('#skill-listitem').children(), function( index, value ) {
                data.skills.push($(value).attr('key'));
            });
            $.each($('#interest-listitem').children(), function( index, value ) {
                data.interests.push($(value).attr('key'));
            });
            processModal.show();
            setTimeout(() => {
                $.ajax({
                    url:"{{route('skillcreate')}}",
                    method:"POST",
                    headers: {"X-CSRF-TOKEN": "{{ csrf_token() }}"},
                    data:{data:JSON.stringify(data)},
                    success:function(response){
                        cversion = response.sys.version;
                        showAlert(true,'Save successful');
                    }
                });
            },1000);
        }
    }

</script>
@endsection
