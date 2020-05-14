$(function () {   
    $(document).on("pageInit", "#modifyPwd", function(e, id, page) {

        console.log("inited", "modifyPwd Page!");

        $("#m_oldPwd").focus();             

        $("#m_btnResetPwd").click(function(){

            var newPwd = $("#m_newPwd").val();
            var reNewPwd = $("#m_aginNewPwd").val();
            var oldPwd= $("#m_oldPwd").val();
              
            if (oldPwd == '' || oldPwd==null) {
                $.toast('(^_^) 旧密码不能为空', 1000);
                return;
            } else if( newPwd =="" ||newPwd ==null || reNewPwd=="" || reNewPwd==null) {
                $.toast('(^_^) 新密码不能为空', 1000);
                return ;
            } else if(!isPasswprd(newPwd)) {
                $.toast('(^_^) 密码必须为6位及以上数字字母组合', 1000);  
                return;
            } else if (newPwd != reNewPwd) {
                $.toast('(^_^) 新密码两次 输入不一致', 1000);
                return;
            } else {
                $.ajax({
                    url : APP_PATH + '/Home/User/checkOldPwd',
                    data : {'oldInput' : oldPwd},
                    success : function(result) {
                        if(result.code==0) {
                            $.toast('(^_^) 旧密码不正确', 1000);
                            return ;
                        }else {
                            $.ajax({
                                url : APP_PATH + '/Home/User/changePwd',
                                data : {'newPwd' : newPwd,
                                'reNewPwd' : reNewPwd},
                                success : function(result){
                                    if(result.code==1){
                                        $.toast("(^_^) 修改成功！请重新登录", 1000);
                                        setTimeout(function() {
                                        location.href = APP_PATH + '/Home/Wechat/signIn';}, 2000);
                                    } else {
                                        $.toast("(^_^) 新密码不能和原密码相同！", 1000);
                                    }
                               },
                                error : function(xhr, type) {
                                    server_error();
                                 }
                            });
                        }
                    }
                });
            }
        });
    });
});