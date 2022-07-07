$(function(){
    $('#applybtn').on('click',function(){
        searchJob();
    });
    $('.interest-title').on('click',function(){
        changetoolbar();
    });
    $('.skill-title').on('click',function(){
        changetoolbar();
    });
    $('#sendContactBtn').on('click',function(){
        submitform();
    });
})

function changetoolbar(){
    var show = true;
    if($('#interesttoolbar').attr('class') == 'skill-edit choose'){
        show = false;
    }
    if($('#skilltoolbar').attr('class') == 'skill-edit choose'){
        show = false;
    }
    if(!show){
        $('#applybtn').removeClass('d-none');
        $('#interesttoolbar').attr('class','skill-toggle');
        $('#skilltoolbar').attr('class','skill-toggle');
        $('#skill-result-block').addClass('d-none');
    }
}

function submitform(){
    if($('#position').val() == 'none'){
        $('#position').addClass('is-invalidarea');
        return false;
    }
    $('#position').removeClass('is-invalidarea');
    if(checkBlank('fullname') && checkPhone() && checkEmail() && checkcv() && checkMessage()){
        applyJob();
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

        },
        success: function(response){
            // $('#progress').addClass('d-none');
            // $('#complete').removeClass('d-none');
            // $('.preview').removeClass('d-none');
            // $('#preview').attr('src','/'+response.file);
            // $('#imagepath').val(response.file);
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
