$(function () {
	// feedback
	$(document).on("pageInit", "#feedBack", function(e, id, page) {
	    console.log("inited", "feedBack Page!");
	    $("#submitFB").click(function(){
	        var content =$("textarea").val();
	        if(content == '' || content == null){
	            $.toast("提交内容不能为空哦！", 1000);
	        }else{
	            $.ajax({
	                type:'POST',
	                url: MOD_PATH + '/Sys/feedBack',
	                data:{
	                    'content':content
	                },
	                success:function(result){
	                    if(result.code==1){
	                        $.toast("提交反馈成功！", 1000);
	                        setTimeout(function() {
	                            location.href = APP_PATH + '/Company/User/bizCenter'
	                        }, 3000);
	                    }else{
	                        server_error();
	                    }
	                },
	                error: function(xhr,type){
	                    server_error();
	                }
	            });
	        }
	    });
	});
});