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

const submitform = () => {
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

const applyJob = () => {
    let fd = new FormData();
    let files = $('#cv')[0].files;
    fd.append('cv',files[0]);
    fd.append('type','job');
    fd.append('position',$('#position').val());
    fd.append('fullname',$('#cv-fullname').val());
    fd.append('email',$('#cv-email').val());
    fd.append('phone',$('#cv-phone').val());
    fd.append('message',$('#cv-message').val());
    showModal();
    setTimeout(() => {
        $.ajax({
            url: '/api/cv',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function(response){
                window.location.href = "/careerfinish";
            },
        });
    },1000);
}

const applyContact = () => {
    let fd = new FormData();
    fd.append('type',$('#contact-title').val());
    fd.append('fullname',$('#contact-fullname').val());
    fd.append('company',$('#company').val());
    fd.append('email',$('#contact-email').val());
    fd.append('phone',$('#contact-phone').val());
    fd.append('message',$('#contact-message').val());
    showModal();
    setTimeout(() => {
        $.ajax({
            url: '/api/contact',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function(response){
                window.location.href = "/careerfinish";
            },
        });
    },1000);
}

const checkBlank = (id) => {
    if(isBlank($('#'+id).val())){
        $('#'+id).addClass('is-invalid');
        return false;
    }
    $('#'+id).removeClass('is-invalid');
    return true;
}

const checkMessage = (id) => {
    if(isBlank($('#'+id).val())){
        $('#'+id).addClass('is-invalidarea');
        return false;
    }
    $('#'+id).removeClass('is-invalidarea');
    return true;
}

const checkEmail = (id) => {
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

const checkPhone = (id) => {
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

const checkcv = () => {
    let files = $('#cv')[0].files;
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

const showModal = () => {
    document.getElementById('modal').style.display='block';
}

const closeModal = () => {
    document.getElementById('modal').style.display='none';
}
