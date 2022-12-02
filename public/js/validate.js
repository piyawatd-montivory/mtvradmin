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
