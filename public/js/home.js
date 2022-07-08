$(function(){
    $('#contact-title').on('change',function(){
        if($('#contact-title').val() == 'job'){
            $('#position-block').removeClass('d-none');
            $('#file-block').removeClass('d-none');
            $('#company-block').addClass('d-none');
            $('#fullname-block').removeClass('half-2');

        }else{
            $('#position-block').addClass('d-none');
            $('#file-block').addClass('d-none');
            $('#company-block').removeClass('d-none');
            $('#fullname-block').addClass('half-2');
        }
    })
    $('#sendContactBtn').on('click',function(){
        submitform();
    });
})

function submitform(){
    if($('#contact-title').val() == 'job'){
        if(checkBlank('fullname') && checkPhone() && checkEmail() && checkcv() && checkMessage()){
            applyJob();
        }
    }else{
        if(checkBlank('fullname') && checkBlank('company') && checkPhone() && checkEmail() && checkMessage()){
            applyContact();
        }
    }

}

function applyJob(){
    var fd = new FormData();
    var files = $('#cv')[0].files;
    fd.append('cv',files[0]);
    fd.append('type','job');
    fd.append('position',$('#position').val());
    fd.append('fullname',$('#fullname').val());
    fd.append('email',$('#email').val());
    fd.append('phone',$('#phone').val());
    fd.append('message',$('#message').val());
    $.ajax({
        url: '/api/cv',
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        beforeSend: function( xhr ) {
            showModal();
        },
        success: function(response){
            window.location.href = "/careerfinish";
        },
    });
}

function applyContact(){
    var fd = new FormData();
    fd.append('type',$('#contact-title').val());
    fd.append('fullname',$('#fullname').val());
    fd.append('company',$('#company').val());
    fd.append('email',$('#email').val());
    fd.append('phone',$('#phone').val());
    fd.append('message',$('#message').val());
    $.ajax({
        url: '/api/contact',
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        beforeSend: function( xhr ) {
            showModal();
        },
        success: function(response){
            window.location.href = "/careerfinish";
        },
    });
}

function checkBlank(id){
    if(isBlank($('#'+id).val())){
        $('#'+id).addClass('is-invalid');
        return false;
    }
    $('#'+id).removeClass('is-invalid');
    return true;
}

function checkMessage(){
    if(isBlank($('#message').val())){
        $('#message').addClass('is-invalidarea');
        return false;
    }
    $('#message').removeClass('is-invalidarea');
    return true;
}

function checkEmail(){
    if(isBlank($('#email').val())){
        $('#email').addClass('is-invalid');
        return false;
    }
    if(!isEmail($('#email').val())){
        $('#email').addClass('is-invalid');
        return false;
    }
    $('#email').removeClass('is-invalid');
    return true;
}

function checkPhone(){
    if(isBlank($('#phone').val())){
        $('#phone').addClass('is-invalid');
        return false;
    }
    if(!isPhone($('#phone').val())){
        $('#phone').addClass('is-invalid');
        return false;
    }
    $('#email').removeClass('is-invalid');
    return true;
}

function checkcv(){
    var files = $('#cv')[0].files;
    // Check file selected or not
    if(!checkSelectFile('cv')){
        $('#cv').addClass('is-invalid');
        return false;
    }
    //check file type
    if(!checkFileCv('cv')){
        $('#cv').addClass('is-invalid');
        return false;
    }
    //check file size 5MB
    if(!checkFileSize('cv',8242880)){
        $('#cv').addClass('is-invalid');
        return false;
    }
    $('#cv').removeClass('is-invalid');
    return true;
}

function showModal(){
    document.getElementById('modal').style.display='block';
}

function closeModal(){
    document.getElementById('modal').style.display='none';
}
