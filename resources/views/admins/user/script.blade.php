<script type="text/javascript">

    const pvModalEl = document.getElementById('browseSingleImage');
    const pnModalEl = document.getElementById('pennameModal');
    let imageModal ='';
    let pnModal ='';
    let browsetype = '';
    let userid = '{{$data->id}}';
    let userversion = {{$data->version}};
    let oldpassword = '{{$data->password}}';
    let oldemail = '{{$data->email?$data->email:""}}';

    $(function(){
        pnModal =  new bootstrap.Modal(document.getElementById('pennameModal'), {backdrop:true});
        $('#btn_upload').on('click',function(){
            uploadImage();
        })
        $('#btn-new-penname').on('click',function(){
            pnModal.show();
        });
        $('#btn-modal-save').on('click',function(){
            pnModalSave();
        })
        bindToolPenname();
    })

    const uploadImage = () => {
        let fd = new FormData();
        let files = $('#fileupload')[0].files;
        // Check file selected or not
        if(checkSelectFile('fileupload')){
            //check file image
            if(!checkFileImage('fileupload')){
                $('#fileupload').addClass('is-invalid');
                $('#fileuploadFeedback').html('Please select image file.');
                return false
            }

            //check file size 5MB
            if(!checkFileSize('fileupload',5242880)){
                $('#fileupload').addClass('is-invalid');
                $('#fileuploadFeedback').html('File size more than 5MB.');
                return false
            }

            fd.append('fileupload',files[0]);
            fd.append('title',$('#email').val()+'-pennameprofile');
            if('{{config('app.defaultimage')}}' !== $('#m-mid').val())
            {
                fd.append('mid',$('#m-mid').val());
                fd.append('mversion',$('#m-mversion').val());
            }else{
                fd.append('mid','');
                fd.append('mversion','');
            }

            $('#progress').removeClass('d-none');
            $('#btn_upload').addClass('d-none');
            setTimeout(() => {
                $.ajax({
                    url: '{{route('imageuploadprofile')}}',
                    type: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    headers: {"X-CSRF-TOKEN": "{{ csrf_token() }}"},
                    success: function(response){
                        $('#fileupload').removeClass('is-invalid');
                        $('#progress').addClass('d-none');
                        $('#btn_upload').removeClass('d-none');
                        $('#fileupload').val('');
                        $('#displaythumbnail').attr('src',response.url);
                        $('#displaythumbnail').removeClass('d-none');
                        $('#m-mid').val(response.id);
                        $('#m-mversion').val(response.version);
                    },
                });
            },1000)
        }else{
            $('#fileupload').addClass('is-invalid');
            $('#fileuploadFeedback').html('Please select a file.');
        }
    }

    const checkemail = () => {
        let result = false;
        $.ajax({
            url:'{{route('checkemail')}}',
            method:'POST',
            async:false,
            data : {email:$('#email').val()},
            success:function(response){
                if(!response.result){
                    result = true;
                }
            }
        })
        return result;
    }

    const buildData = (savetype) => {
        let pass = true;
        $.each($('.validate'),function(i,obj){
            if($(obj).val().trim().length === 0){
                $(obj).addClass('is-invalid');
                pass = false;
            }else{
                $(obj).removeClass('is-invalid');
            }
        })
        if(userid === ''){
            if(!isBlank($('#email').val())){
                if(!isEmail($('#email').val())){
                    pass = false;
                    $('#email').addClass('is-invalid');
                    $('#emailerror').text('Please provide a valid email.')
                }else{
                    if($('#email').val() !== oldemail){
                        if(!checkemail()){
                            pass = false;
                            $('#email').addClass('is-invalid');
                            $('#emailerror').text('This email is already taken.')
                        }else{
                            $('#email').removeClass('is-invalid');
                        }
                    }else{
                        $('#email').removeClass('is-invalid');
                    }
                }
            }else{
                $('#email').removeClass('is-invalid');
            }
        }
        if($('#password').val().trim().length > 0){
            if(!checkpassword('password')){
                pass = false;
                $('#password').addClass('is-invalid');
                $('#passerror').text('Password wrong pattern.');
            }else{
                $('#password').removeClass('is-invalid');
                if($('#confirmpassword').val().trim().length > 0){
                    if($('#confirmpassword').val() !== $('#password').val()){
                        pass = false;
                        $('#cfpasserror').text('Confirm password and password miss match.');
                        $('#confirmpassword').addClass('is-invalid');
                    }else{
                        $('#confirmpassword').removeClass('is-invalid');
                    }
                }else{
                    pass = false;
                    $('#cfpasserror').text('Please provide a valid confirm password.');
                    $('#confirmpassword').addClass('is-invalid');
                }
            }
        }
        if(pass){
            let data = {};
            data.id = userid;
            data.version = userversion;
            data.type = '{{$data->type}}';
            data.email = $('#email').val();
            data.password = '';
            data.oldpassword = oldpassword;
            if($('#password').val().trim().length > 0)
            {
                data.password = $('#password').val();
            }
            data.firstname = $('#firstname').val();
            data.lastname = $('#lastname').val();
            data.role = $('#role').val();
            data.active = false;
            data.default = false;
            if($( "#active").prop( "checked")){
                data.active = true;
            }
            if($( "#default").prop( "checked")){
                data.default = true;
            }
            processModal.show();
            setTimeout(() => {
                $.ajax({
                    url:"{{route('userupdate')}}",
                    method:"POST",
                    async: false,
                    cache: false,
                    headers: {"X-CSRF-TOKEN": "{{ csrf_token() }}"},
                    data:{data:JSON.stringify(data)},
                    success:function(response){
                        $('#btn-new-penname').attr('disabled',false);
                        $('#password').val('');
                        $('#password').removeClass('validate');
                        $('#email').attr('readonly',true);
                        if(userid === ''){
                            let datapenname = {}
                            datapenname.id = '';
                            datapenname.version = 0;
                            datapenname.name = $('#firstname').val()+' '+$('#lastname').val();
                            datapenname.title = '{{config('app.pseudonymtitle')}}';
                            datapenname.description = '{{config('app.pseudonymtitle')}}';
                            datapenname.mid = '{{config('app.defaultimage')}}';
                            datapenname.uid = response.sys.id;
                            datapenname.default = true;
                            datapenname.defaultuser = false;
                            if($( "#default").prop( "checked")){
                                datapenname.defaultuser = true;
                            }
                            $.ajax({
                                url:'{{route('userupdatepenname')}}',
                                method:"POST",
                                async: false,
                                cache: false,
                                headers: {"X-CSRF-TOKEN": "{{ csrf_token() }}"},
                                data:{data:JSON.stringify(datapenname)},
                                success:function(presponse){
                                    let penhtml = `
                                    <div class="col-12">
                                        <div class="card mb-2">
                                            <div class="card-body">
                                                <div class="mb-3 row">
                                                    <div class="col-1 text-center">
                                                        <img src="{{config('app.defaultimageurl')}}" class="penname-image">
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="row">
                                                            <label for="penname" class="col-2 col-form-label">Name</label>
                                                            <div class="col-10">
                                                                <input type="text" readonly class="form-control-plaintext" id="penname" name="penname" value="${datapenname.name}">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <label for="title" class="col-2 col-form-label">Title</label>
                                                            <div class="col-10">
                                                                <input type="text" readonly class="form-control-plaintext" id="title" name="title" value="${datapenname.title}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-5">
                                                        <div class="row">
                                                            <label for="description" class="col-3 col-form-label">Description</label>
                                                            <div class="col-9">
                                                                <textarea rows="3" readonly class="form-control-plaintext" id="description" name="description">${datapenname.description}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-2" pid="${presponse.sys.id}" pversion="${presponse.sys.version}" mid="${datapenname.mid}" mversion="1" default="true">
                                                        <button type="button" class="btn btn-sm btn-outline-primary btn-edit-penname">Edit</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    `;
                                    $('#penname-list').append(penhtml);
                                    bindToolPenname();
                                }
                            })
                        }
                        userid = response.sys.id;
                        userversion = response.sys.version;
                        oldpassword = response.password;
                        if(data.type == 'profile'){
                            showAlert(true,'Update profile successful')
                        }else{
                            showAlert(true,'Save successful')
                            window.location.href = '/admins/users/edit/'+response.sys.id;
                        }
                    }
                })
            },1000)
        }
    }

    let datablock = '';
    let displayblock = ''
    const bindToolPenname = () => {
        $('.btn-edit-penname').unbind('click');
        $('.btn-edit-penname').on('click',function(){
            datablock = $(this).parent();
            displayblock = $(this).parent().parent();
            $('#m-pid').val($(datablock).attr('pid'));
            $('#m-pversion').val($(datablock).attr('pversion'));
            $('#m-mid').val($(datablock).attr('mid'));
            $('#m-mversion').val($(datablock).attr('mversion'));
            $('#m-penname').val($(displayblock).find('#penname').val())
            $('#m-title').val($(displayblock).find('#title').val())
            if($(datablock).attr('default')){
                $('#m-default').val('yes');
            }else{
                $('#m-default').val('no');
            }
            $('#m-description').val($(displayblock).find('#description').val())
            $('#displaythumbnail').attr('src',$(displayblock).find('.penname-image').attr('src'));
            $('#displaythumbnail').removeClass('d-none');
            pnModal.show();
        })
        $('.btn-delete-penname').unbind('click');
        $('.btn-delete-penname').on('click',function(){
            datablock = $(this).parent();
            displayblock = $(this).parent().parent();
            if (confirm("Delete "+$(displayblock).find('#penname').val()+" ?") == true) {
                let data = {};
                data.id = $(datablock).attr('pid');
                data.uid = '{{authuser()->id}}';
                data.version = $(datablock).attr('pversion');
                data.mid = $(datablock).attr('mid');
                data.mversion = $(datablock).attr('mversion');
                data.defaultuser = false;
                if($( "#default").prop( "checked")){
                    data.defaultuser = true;
                }
                processModal.show();
                setTimeout(() => {
                    $.ajax({
                        url:'{{route('userdeletepenname')}}',
                        method:"POST",
                        data:{data:JSON.stringify(data)},
                        success:function(response){
                            if(response.result)
                            {
                                $(this).parent().parent().parent().parent().parent().remove();
                                showAlert(true,'Delete successful')
                            }else{
                                showAlert(false,'Can not delete.Have content used.')
                            }
                        }
                    })
                },1000);
            }
        })
    }

    const pnModalSave = () => {
        let pass = true;
        if($('#m-penname').val().trim().length === 0){
            $('#m-penname').addClass('is-invalid');
            pass = false;
        }else{
            $('#m-penname').removeClass('is-invalid');
        }
        if($('#m-title').val().trim().length === 0){
            $('#m-title').addClass('is-invalid');
            pass = false;
        }else{
            $('#m-penname').removeClass('is-invalid');
        }
        if($('#m-mid').val().trim().length === 0){
            $('#fileupload').addClass('is-invalid');
            pass = false;
        }else{
            $('#fileupload').removeClass('is-invalid');
        }
        if(pass)
        {
            let data = {}
            data.id = $('#m-pid').val();
            data.version = $('#m-pversion').val();
            data.name = $('#m-penname').val();
            data.title = $('#m-title').val();
            data.description = $('#m-description').val();
            data.mid = $('#m-mid').val();
            data.uid = userid;
            data.default = false;
            if($('#m-default') === 'yes'){
                data.default = true;
            }
            data.defaultuser = false;
            if($( "#default").prop( "checked")){
                data.defaultuser = true;
            }

            $('#btn-modal-pn-cancel').attr('disabled',true);
            $('#btn-modal-save').attr('disabled',true);
            setTimeout(() => {
                $.ajax({
                    url:'{{route('userupdatepenname')}}',
                    method:"POST",
                    data:{data:JSON.stringify(data)},
                    headers: {"X-CSRF-TOKEN": "{{ csrf_token() }}"},
                    success:function(response){
                        if(data.id === ''){
                            let imgsrc = $('#displaythumbnail').attr('src');
                            let imversion = $('#m-mversion').val();
                            let imid = $('#m-mid').val();
                            let penhtml = `
                            <div class="col-12">
                                <div class="card mb-2">
                                    <div class="card-body">
                                        <div class="mb-3 row">
                                            <div class="col-1 text-center">
                                                <img src="${imgsrc}" class="penname-image">
                                            </div>
                                            <div class="col-4">
                                                <div class="row">
                                                    <label for="penname" class="col-2 col-form-label">Name</label>
                                                    <div class="col-10">
                                                        <input type="text" readonly class="form-control-plaintext" id="penname" name="penname" value="${data.name}">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <label for="title" class="col-2 col-form-label">Title</label>
                                                    <div class="col-10">
                                                        <input type="text" readonly class="form-control-plaintext" id="title" name="title" value="${data.title}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-5">
                                                <div class="row">
                                                    <label for="description" class="col-3 col-form-label">Description</label>
                                                    <div class="col-9">
                                                        <textarea rows="3" readonly class="form-control-plaintext" id="description" name="description">${data.description}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-2" pid="${response.sys.id}" pversion="${response.sys.version}" mid="${imid}" mversion="${imversion}" default="false">
                                                <button type="button" class="btn btn-sm btn-outline-primary btn-edit-penname">Edit</button>
                                                <button type="button" class="btn btn-sm btn-outline-danger btn-delete-penname">Delete</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            `;
                            $('#penname-list').append(penhtml);
                            bindToolPenname();
                        }else{
                            $(datablock).attr('pversion',response.version)
                            $(displayblock).find('#penname').val(data.name);
                            $(displayblock).find('#title').val(data.title);
                            $(displayblock).find('#description').val(data.description);
                            $(displayblock).find('.penname-image').attr('src',$('#displaythumbnail').attr('src'));
                            $(datablock).attr('mversion',$('#m-mversion').val());
                        }
                        pnModal.hide();
                    }
                })
            },1000);
        }

    }

    pnModalEl.addEventListener('hide.bs.modal', event => {
        $('#btn-modal-pn-cancel').attr('disabled',false);
        $('#btn-modal-save').attr('disabled',false);
        $('#m-title').val('');
        $('#m-default').val('');
        $('#m-penname').val('');
        $('#m-description').val('');
        $('#m-pid').val('');
        $('#m-pversion').val('');
        $('#m-mid').val('');
        $('#m-mversion').val('');
        $('#fileupload').removeClass('is-invalid');
        $('#progress').addClass('d-none');
        $('#complete').addClass('d-none');
        $('#btn_upload').removeClass('d-none');
        $('#fileupload').val('');
        $('#displaythumbnail').attr('src','');
        $('#displaythumbnail').addClass('d-none');
    })

</script>
