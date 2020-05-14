var userId = 0;
$(function () {
    $(document).on("pageInit","#userBaseInfo", function (e, pageId, $page) {
        console.log("inited", "userBaseInfo Page!");
        $.ajax({
            type: 'POST',
            url:APP_PATH+ '/Home/User/detail',
            dataType: 'json',
            async : 0,
            timeout: 3000,
            context: $('.form_perfectInfo'),
            success:function(res){
                userId = res.data.id;
                if(res.code==0){
                    server_error();
                    return;
                }
                  
                var html = template("user-baseinfo-tpl", res.data);
                this.html(html);

                $('#save-base-btn').click(saveBaseInfo);
                
                function saveBaseInfo(){
                    var params ={
                        realname:$("input[name='realname']").val(),
                        gender : $("input[name='sex']:checked").val()
                    };
                    $.ajax({
                         type: 'POST',
                         url:APP_PATH+ '/Home/User/update',
                         dataType: 'json',
                         data:params,
                         timeout: 3000,
                         success:function(res){
                              if(res.code==1){
                                  $.toast('(^_^) 更新信息成功！', 1000, "toast_orange");
                              }else{
                                  $.toast("(+﹏+) 没有信息修改！", 1000, "toast_orange");   
                              }
                         },
                         error:function(){
                            server_error();
                         }
                    });
                }
            },
            error:function(){
                server_error();
            }
        });
    });
    $.init();
});