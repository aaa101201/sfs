 var userId = 0;
 $(function () {   
    $(document).on("pageInit", "#userMoreInfo", function(e, id, page) {
        console.log("inited", "userMoreInfo Page!");

        var box = $('#wrapUserMoreInfo form'), btn = $('#save-more-btn');

        getInfo(showInfo);
        btn.click(saveMoreInfo);

        function checkInfo() {
            return true;
        }

        function getInfo(callback) {
            callback || (callback = function () {});
            $.ajax({
                type: 'GET',
                url: APP_PATH + '/Home/User/detail',
                dataType: 'json',
                success: callback,
                error: server_error
            });
        }

        function showInfo(res) {
            var html = template('tpl-moreInfo', res.data);
            box.html(html);
        }
        
        function saveMoreInfo(){
            if (!checkInfo()) return false;
            $.ajax({
                type: 'POST',
                url: APP_PATH + '/Home/User/update',
                dataType: 'json',
                data: box.serialize(),
                timeout: 3000,
                success: function(res) {
                    if (res.code == 1) {
                        $.toast('(^_^) 更新信息成功！', 1000);
                    } else {
                        $.toast("(+﹏+)更新信息失败！", 1000);   
                    }   
                },
                error: server_error
            });
        }
    });
    $.init();
});