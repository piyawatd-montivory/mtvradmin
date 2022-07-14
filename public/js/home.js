$(function(){
    $('#contact-title').on('change',function(){
        if($('#contact-title').val() == 'job'){
            $('#contact-fieldset').fadeOut(200,function(){
                $('#cv-fieldset').fadeIn(200);
            });
        }else{
            $('#cv-fieldset').fadeOut(200,function(){
                $('#contact-fieldset').fadeIn(200);
            });
        }
    })
    $('#sendContactBtn').on('click',function(){
        submitform();
    });
})

function submitform(){
    if($('#contact-title').val() == 'job'){
        if(checkBlank('cv-fullname') && checkPhone('cv-phone') && checkEmail('cv-email') && checkcv() && checkMessage('cv-message')){
            applyJob();
        }
    }else{
        if(checkBlank('contact-fullname') && checkBlank('company') && checkPhone('contact-phone') && checkEmail('contact-email') && checkMessage('contact-message')){
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

function checkMessage(id){
    if(isBlank($('#'+id).val())){
        $('#'+id).addClass('is-invalidarea');
        return false;
    }
    $('#'+id).removeClass('is-invalidarea');
    return true;
}

function checkEmail(id){
    if(isBlank($('#'+id).val())){
        $('#'+id).addClass('is-invalid');
        return false;
    }
    if(!isEmail($('#'+id).val())){
        $('#'+id).addClass('is-invalid');
        return false;
    }
    $('#'+id).removeClass('is-invalid');
    return true;
}

function checkPhone(id){
    if(isBlank($('#'+id).val())){
        $('#'+id).addClass('is-invalid');
        return false;
    }
    if(!isPhone($('#'+id).val())){
        $('#'+id).addClass('is-invalid');
        return false;
    }
    $('#'+id).removeClass('is-invalid');
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
