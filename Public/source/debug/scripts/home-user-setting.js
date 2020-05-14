$(function () {   
    $(document).on("pageInit", "#userSetting", function(e, id, page) {

        console.log("inited page::", "userSetting!");

        $(document).bind('click', '#signOut', function () {
            $.ajax({
                type: 'POST',
                url: MOD_PATH + '/User/signOut',
                dataType: 'json',
                timeout: 3000,
                success: function(data){
                    if(data.code){
                        $.toast("(^_^) 欢迎君再来！", 1000);
                        setTimeout(function() {
                            location.href = MOD_PATH + '/Wechat/signIn';
                        }, 2000);
                    }else{
                        server_error();
                    }
                },
                error: function(xhr,type){
                    server_error();
                }
            });
        });
    });
});