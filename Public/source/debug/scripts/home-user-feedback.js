$(function () {
    $(document).on("pageInit", "#feedBack", function(e, id, page) {
        $("#submitFB").click(function(){
            var content =$("textarea").val();
            if(content == '' || content == null){
                $.toast("(^_^) 提交内容不能为空哦！", 1000);
            }else{
                $.ajax({
                    type:'POST',
                    url: APP_PATH + '/Home/Sys/feedBack',
                    data:{
                        'content':content
                    },
                    success:function(result){
                        if(result.code==1){
                            $.toast("(^_^) 提交反馈成功！", 1000);
                            setTimeout(function() {
                                location.href = './userCenter.html';
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