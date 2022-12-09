function buildSlug(value) {
    let n = value.replace(/[\s]/g,'-');
    n = n.replace(/[^\wก-๙\-]/g,'');
    return n;
}

function isBlank(value) {
    if(value.trim().length > 0)
    {
        return false;
    }
    return true;
}

function isName(value) {
    let regex = /^[^0-9_!¡?÷?¿/\\+=@#$%ˆ&*(){}|~<>;:[\]]{2,}$/;
    return regex.test(value);
}

function isPhone(value) {
    let regex = /[0]{1}[0-9]{9}/;
    return regex.test(value);
}

function isEmail(value) {
    let regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(value);
}

function isImageFile(value) {
    let regex = /([a-zA-Z0-9\s_\\.\-:])+(.png|.jpg|.gif)$/;
    return regex.test(value);
}

function isCost(value) {
    let regex = /(?:\d*\.\d{1,2}|\d+)$/;
    return regex.test(value);
}

function isNumber(value) {
    let regex = /^\d+$/;
    return regex.test(value);
}

function checkSelectFile(id){
    let files = $('#'+id)[0].files;
    if(files.length > 0 ){
        return true;
    }else{
        return false;
    }
}

function checkFileImage(id){
    let files = $('#'+id)[0].files;
    let validImageTypes = ["image/jpeg", "image/png"];
    if ($.inArray(files[0]['type'], validImageTypes) < 0) {
        return false;
    }
    return true;
}

function checkFileCv(id){
    let files = $('#'+id)[0].files;
    let validImageTypes = ["image/jpeg", "image/png", "application/pdf"];
    if ($.inArray(files[0]['type'], validImageTypes) < 0) {
        return false;
    }
    return true;
}

function checkFileSize(id,size){
    let files = $('#'+id)[0].files;
    if(files[0]['size'] > parseInt(size))
    {
        return false;
    }
    return true;
}

function checkID(id){
    id = id.replace(/-/g, "");
    if(! isNumber(id)) return false;
    if(id.substring(0,1)== 0) return false;
    if(id.length != 13) return false;
    for(i=0, sum=0; i < 12; i++)
        sum += parseFloat(id.charAt(i))*(13-i);
    if((11-sum%11)%10!=parseFloat(id.charAt(12))) return false;
    return true;
}

function checkpassword(id){
    let password = $('#'+id).val().trim();
    let obj = $('#'+id).parent()
    let result = true;
    //check password length
    if(password.length < 5){
        $('#'+id).removeClass('is-valid');
        $('#'+id).addClass('is-invalid');
        $(obj).find('.invalid-feedback').html('รหัสผ่านห้ามน้อยกว่า 5 ตัวอักษร');
        return false;
    }else{
        let number = /([0-9])/;
        let alphabets = /([a-zA-Z])/;
        if (password.match(number) && password.match(alphabets)) {
            $('#'+id).removeClass('is-invalid');
            return true;
        } else {
            $('#'+id).addClass('is-invalid');
            $(obj).find('.invalid-feedback').html('รหัสผ่านต้องมีตัวอักษรตัวใหญ่ 1 ตัว ตัวเล็ก 1 ตัว ตัวเลข 1 ตัว เฉพาะภาษาอังกฤษ');
            return false;
        }
    }
}
