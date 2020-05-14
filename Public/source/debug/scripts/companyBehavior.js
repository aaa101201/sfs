//此文件为企业端埋点事件方法
function biLog(data){
    $init = {
        "source": "wechat.luobojianzhi.com"
    }
    $.ajax({
        type: 'POST',
        url:  APP_PATH+'/Home/Tools/biLog',
        data: { biData : $.extend($init, data)}
    });
}
//点击企业简介按钮,企业端事件埋点
function logBizCenter(){
    $data = { 
        "behavior": "wechat_b_company_bizInfo"
    };
    console.log("data", $data);
    biLog($data);
    enterBizInfo(); 
}
//点击修改头像按钮,企业端事件埋点
function logUserPhoto(){
    $data = { 
        "behavior": "wechat_b_company_bizInfo_userphoto"
    };
    console.log("data", $data);
    biLog($data); 
}
//点击修改基本信息,企业端事件埋点
function logPerfectInfo(){
    $data = { 
        "behavior": "wechat_b_company_bizInfo_perfectInfo"
    };
    console.log("data", $data);
    biLog($data); 
    enterPerfectInfo();
}
//点击上传证件按钮,企业端事件埋点
function logUpload(){
    $data = { 
        "behavior": "wechat_b_company_bizInfo_perfectInfo_uploadZJ"
    };
    console.log("data", $data);
    biLog($data); 
}
//点击修改详细信息,企业端事件埋点
function logInfoDetails(){
    $data = { 
        "behavior": "wechat_b_company_bizInfo_bizInfoDetail"
    };
    console.log("data", $data);
    biLog($data); 
    enterBizInfoDetail();
}
//点击发布兼职,企业端事件埋点
function logSendJob(){
    $data = { 
        "behavior": "wechat_b_company_sendJob"
    };
    console.log("data", $data);
    biLog($data); 
}
//点击发布记录,企业端事件埋点
function logSendList(){
    $data = { 
        "behavior": "wechat_b_company_sendList"
    };
    console.log("data", $data);
    biLog($data); 
}
//点击取消发布,企业端事件埋点
function logCancelSendJob(){
    $data = { 
        "behavior": "wechat_b_company_sendList_cancelSendJob"
    };
    console.log("data", $data);
    biLog($data); 
}
//点击结束招聘,企业端事件埋点
function logFinishJob(){
    $data = { 
        "behavior": "wechat_b_company_sendList_finishJob"
    };
    console.log("data", $data);
    biLog($data); 
}
//点击投递记录,企业端事件埋点
function logApplyList(){
    $data = { 
        "behavior": "wechat_b_company_applyList"
    };
    console.log("data", $data);
    biLog($data); 
}
//点击申请人员,企业端事件埋点
function logApplyUserList(){
    $data = { 
        "behavior": "wechat_b_company_applyList_applyUserList"
    };
    console.log("data", $data);
    biLog($data); 
}
//点击通过/拒绝/完成/未完成按钮,企业端事件埋点
function logSomeButton(buttonId){
    var type = 'someButton';
    if(buttonId == 2){
        type = '通过';
    }else if(buttonId == 3){
        type = '拒绝';
    }else if(buttonId == 4){
        type = '完成';
    }else if(buttonId == 5){
        type = '未完成';
    }
    $data = { 
        "behavior": "wechat_b_company_applyList_someButton",
        "extend": type//具体而定
    };
    console.log("data", $data);
    biLog($data); 
}
//点击电话按钮,企业端事件埋点
function logPhone(){
    $data = { 
        "behavior": "wechat_b_company_applyList_phone"
    };
    console.log("data", $data);
    biLog($data); 
}
//点击意见反馈,企业端事件埋点
function logFeedback(){
    $data = { 
        "behavior": "wechat_b_company_feedback"
    };
    console.log("data", $data);
    biLog($data); 
    enterFeedback();
}
//点击设置,企业端事件埋点
function logSetting(){
    $data = { 
        "behavior": "wechat_b_company_setting"
    };
    console.log("data", $data);
    biLog($data); 
    enterSetting();
}
//点击修改密码按钮,企业端事件埋点
function logResetPWD(){
    $data = { 
        "behavior": "wechat_b_company_resetpwd"
    };
    console.log("data", $data);
    biLog($data); 
    enterResetPWD();
}
//点击退出登陆,企业端事件埋点
function logLogOut(){
    $data = { 
        "behavior": "wechat_b_company_logout"
    };
    console.log("data", $data);
    biLog($data); 
}
//发布记录下点击待审核/招聘中/已结束,企业端事件埋点
function logSendList_tab(str){
    var type = 'Tab';
    if(str == 's1'){
        type = '待审核';
    }else if(str == 's2'){
        type = '招聘中';
    }else if(str == 's3'){
        type = '已结束';
    }
    $data = { 
        "behavior": "wechat_b_sendList_tab_catg_li",
        "extend": type
    };
    console.log("data", $data);
    biLog($data); 
}
//投递人员记录下点击待通过/待完成/已完成,企业端事件埋点
function logApplyList_tab(str){
    var type = 'Tab';
    if(str == 's1'){
        type = '待通过';
    }else if(str == 's2'){
        type = '待完成';
    }else if(str == 's3'){
        type = '已完成';
    }
    $data = { 
        "behavior": "wechat_b_applyList_tab_catg_li",
        "extend": type
    };
    console.log("data", $data);
    biLog($data); 
}
//点击完善信息页提交按钮,企业端事件埋点
function logSubmit(){
    $data = { 
        "behavior": "wechat_b_perfectinfo_submit"
    };
    console.log("data", $data);
    biLog($data); 
}
//点击某条兼职信息,企业端事件埋点
function logSomeJob(jobId){
    $data = { 
        "behavior": "wechat_b_company_job",
        "jobId":jobId
    };
    console.log("data", $data);
    biLog($data); 
}



//进入注册页,企业端事件埋点
function enterSignUp(){
    $data = { 
        "behavior": "wechat_p_company_signup"
    };
    console.log("data", $data);
    biLog($data); 
}
//进入登录页,企业端事件埋点
function enterSignIn(){
    $data = { 
        "behavior": "wechat_p_company_signin"
    };
    console.log("data", $data);
    biLog($data); 
}
//进入忘记密码页,企业端事件埋点
function enterResetPWD(){
    $data = { 
        "behavior": "wechat_p_company_resetpwd"
    };
    console.log("data", $data);
    biLog($data); 
}
//进入萝卜协议页,企业端事件埋点
function enterAgreement(){
    $data = { 
        "behavior": "wechat_p_company_agreement"
    };
    console.log("data", $data);
    biLog($data); 
}
//进入企业中心页,企业端事件埋点
function enterUserCenter(){
    $data = { 
        "behavior": "wechat_p_company_usercenter"
    };
    console.log("data", $data);
    biLog($data); 
}
//进入企业简介页,企业端事件埋点
function enterBizInfo(){
    $data = { 
        "behavior": "wechat_p_company_bizInfo"
    };
    console.log("data", $data);
    biLog($data); 
}
//进入完善信息页,企业端事件埋点
function enterPerfectInfo(){
    $data = { 
        "behavior": "wechat_p_company_bizInfo_perfectInfo"
    };
    console.log("data", $data);
    biLog($data); 
}
//进入详细信息页,企业端事件埋点
function enterBizInfoDetail(){
    $data = { 
        "behavior": "wechat_p_company_bizInfo_bizInfoDetail"
    };
    console.log("data", $data);
    biLog($data); 
}
//进入发布兼职页,企业端事件埋点
function enterSendJob(){
    $data = { 
        "behavior": "wechat_p_company_sendJob"
    };
    console.log("data", $data);
    biLog($data); 
}
//进入发布成功页,企业端事件埋点
function enterSendOk(){
    $data = { 
        "behavior": "wechat_p_company_sendOk"
    };
    console.log("data", $data);
    biLog($data); 
}
//进入发布记录页,企业端事件埋点
function enterSendList(){
    $data = { 
        "behavior": "wechat_p_company_sendList"
    };
    console.log("data", $data);
    biLog($data); 
}
//进入投递记录页,企业端事件埋点
function enterApplyList(){
    $data = { 
        "behavior": "wechat_p_company_applyList"
    };
    console.log("data", $data);
    biLog($data); 
}
//进入申请人员页,企业端事件埋点
function enterApplyUserList(){
    $data = { 
        "behavior": "wechat_p_company_applyList_applyUserList"
    };
    console.log("data", $data);
    biLog($data); 
}
//进入意见反馈页,企业端事件埋点
function enterFeedback(){
    $data = { 
        "behavior": "wechat_p_company_feedback"
    };
    console.log("data", $data);
    biLog($data); 
}
//进入设置页,企业端事件埋点
function enterSetting(){
    $data = { 
        "behavior": "wechat_p_company_setting"
    };
    console.log("data", $data);
    biLog($data); 
}
//进入修改密码页,企业端事件埋点
function enterModifyPWD(){
    $data = { 
        "behavior": "wechat_p_company_modifypwd"
    };
    console.log("data", $data);
    biLog($data); 
}
//进入发布记录/投递记录下某条兼职信息详情页,企业端事件埋点
function enterJobDetails(jobId){
    $data = { 
        "behavior": "wechat_p_company_job",
        "jobId": jobId
    };
    console.log("data", $data);
    biLog($data); 
}
/*
* 微信营销页面埋点
*/
//招兼职
function enterBizFindPT() {
    $data = { 
        "behavior": "wechat_p_company_league_bizFindPT",
    };
    console.log("data", $data);
    biLog($data); 
}
//发广告
function enterBizAd() {
    $data = { 
        "behavior": "wechat_p_company_league_bizAd",
    };
    console.log("data", $data);
    biLog($data); 
}
//加盟
function enterBizJoin() {
    $data = { 
        "behavior": "wechat_p_company_league_bizJoin",
    };
    console.log("data", $data);
    biLog($data); 
}