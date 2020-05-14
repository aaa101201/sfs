$(function () {
	//bizSetting 
	$(document).on("pageInit", "#CompanySetting", function(e, id, page) {
	    console.log("inited", "CompanySetting Page!");
	    $(document).bind('click', '#signOut', function () {
	        var self = this;
	        console.log(self.id);
	        var jobId = self.id;
	        $.ajax({
	            type: 'POST',
	            url: MOD_PATH + '/User/signOut',
	            dataType: 'json',
	            timeout: 3000,
	            success: function(data){
	                if(data.code){
	                  $.toast("(^_^) 欢迎君再来！", 1000);
	                  setTimeout(function() {
	                      location.href = MOD_PATH+ '/Index/signIn';
	                  }, 2000);
	                }else{
	                  server_error();
	                }
	            },
	            error: function(xhr,type){
	                console.log("xhr", xhr);
	                server_error();
	            }
	        });
	    });
	});
	//modify pwd
	$(document).on("pageInit", "#modifyPwd", function(e, id, page) {
	    console.log("inited", "modifyPwd Page!");
	    $("#m_oldPwd").focus();             

	    $("#m_btnResetPwd").click(function(){

	        var newPwd = $("#m_newPwd").val();
	        var reNewPwd = $("#m_aginNewPwd").val();
	        var oldPwd= $("#m_oldPwd").val();
	        var reg=/^[\w]{8}$/; 

	        if (oldPwd == '' || oldPwd==null) {
	            $.toast('旧密码不能为空', 1000);
	            return;
	        } else if( newPwd =="" ||newPwd ==null || reNewPwd=="" || reNewPwd==null) {
	            $.toast('新密码不能为空', 1000);
	            return ;
	        } else if(!isPasswprd(newPwd)) {
	            $.toast('(^_^) 密码必须为6位及以上数字字母组合', 1000);  
	            return;
	        } else if (newPwd != reNewPwd) {
	            $.toast('新密码两次 输入不一致', 1000);
	            return;
	        } else {
	            $.ajax({
	                url : APP_PATH + '/Company/Index/checkOldPwd',
	                data : {'oldInput' : oldPwd},
	                success : function(result) {
	                    if(result.code==0) {
	                        $.toast('旧密码不正确', 1000);
	                        return ;
	                    }else {
	                        $.ajax({
	                            url : APP_PATH + '/Company/Index/changePwd',
	                            data : {'newPwd' : newPwd,
	                                'reNewPwd' : reNewPwd
	                            },
	                            success : function(result){
	                                if(result==1){
	                                    $.toast("修改成功！请重新登录", 1000);
	                                    setTimeout(function() {
	                                        location.href = APP_PATH + '/Company/Index/signIn';}, 2000);
                                    } else {
                                        $.toast("新密码不能和原密码相同！", 1000);
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