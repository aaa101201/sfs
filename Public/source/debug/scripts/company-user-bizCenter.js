$(function () {
    $(document).on("pageInit", "#bizCenter", function(e, id, page) {
        console.log("inited page::", "bizCenter");
        $.ajax({
            type: 'POST',
            url: CON_PATH + '/detail',
            dataType: 'json',
            timeout: 3000,
            success: function(data){
                console.log(data);
                if(data.code){
                    $("#biz-center-top-info").html(template("biz-center-top-info-tpl",data.data));
                }else{
                     server_error();
                }
            },
            error: function(xhr,type){
                console.log("xhr", xhr);
                server_error();
            }
        });
        // $('#sendMoney').click(function () {
        //     $.ajax({
        //         type: 'GET',
        //         url: APP_PATH + '/Company/User/IsPasswordEmpty',
        //         dataType: 'json',
        //         timeout: 3000,
        //         success: function (res) {
        //             if (res) {
        //                 location.href = APP_PATH + '/Company/Wallet/payList';
        //             } else {
        //                 $.toast('您还没有设置支付密码~', 1000);
        //                 setTimeout(function () {
        //                     location.href = APP_PATH + '/Company/Wallet/myWallet_setPwd?frompay=yes';
        //                 }, 1000);
        //             }
        //         },
        //         error: server_error
        //     });
        // });  
    });

    $.init();
});