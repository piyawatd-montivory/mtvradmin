$(function(){
    $('#sendContactBtn').on('click',function(){
        submitform();
    });
})

const submitform = () => {
    let pass = true;
    $.each($('.validate'),function(i,obj){
        if($(obj).val().trim().length === 0){
            $(obj).addClass('is-invalid');
            pass = false;
        }else{
            $(obj).removeClass('is-invalid');
        }
    })
    if(pass && checkPhone() && checkEmail() && checkcv()){
        applyJob();
    }
}

const applyJob = () => {
    let fd = new FormData();
    let files = $('#cv')[0].files;
    fd.append('cv',files[0]);
    fd.append('type','job');
    fd.append('position',$('#position').val());
    fd.append('fullname',$('#fullname').val());
    fd.append('email',$('#email').val());
    fd.append('phone',$('#phone').val());
    fd.append('message',$('#message').val());
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

const showModal = () => {
    document.getElementById('modal').style.display='block';
}

const checkEmail = () => {
    if(!isEmail($('#email').val())){
        $('#email').addClass('is-invalid');
        return false;
    }
    $('#email').removeClass('is-invalid');
    return true;
}

const checkPhone = () => {
    if(!isPhone($('#phone').val())){
        $('#phone').addClass('is-invalid');
        return false;
    }
    $('#email').removeClass('is-invalid');
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
