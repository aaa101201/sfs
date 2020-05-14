//此文件存放通用的js


// 校验密码
function isPasswprd(text) {
    if(text.indexOf('_')==0)
        return false;
    
    // 非纯数字或字母组合的用这个
    return /^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{6,16}$/.test(text); 
    //可以纯数字或纯字母
    //return /^[a-zA-Z0-9_]{6,16}$/.test(text); 
    
}

// 校验手机号
function isMobile(text) {
    return /^((17[0-9])|(14[0-9])|(13[0-9])|(15[^4,\D])|(18[0-9]))\d{8}$/.test(text);
}

function escapeChars(str) {
    str = str.replace(/&amp;/g,'&');
    str = str.replace(/&amp;/g,'&');
    str = str.replace(/&nbsp;/g,' ');
    str = str.replace(/&lt;/g,'<');
    str = str.replace(/&gt;/g,'>');
    str = str.replace(/&acute;/g,"\'");
    str = str.replace(/&quot;/g,"\"");
    str = str.replace(/&brvbar;/g,"|");
    return str;
}