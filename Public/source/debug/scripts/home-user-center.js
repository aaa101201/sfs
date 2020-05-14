var userId = 0;
$(function () {
    $(document).on("pageInit", "#userCenter", function(e, id, page) {

        function getParam(str, deflt) {
          var search = decodeURIComponent(location.href);
          var result = new RegExp('[\\W]' + str + '(?:[=|\\/])([0-9|a-z]*)').exec(search);
          result = result ? result[1] : deflt;
          return result; 
        }

        var cId = getParam('cId', 1);

        var toMall = getParam('toMall', 0);
        if (toMall) {
            $('header a').click(function (e) {
                e.preventDefault();
                location.href = APP_PATH + '/Mall/Index/index?cId=' + cId;
                return false;
            });
        } else {
            $('header a').click(function (e) {
                e.preventDefault();
                location.href = APP_PATH + '/Home/Index/index/cId/' + cId;
                return false;
            });
        }
        
        $.ajax({
            type: 'POST',
            url: APP_PATH + '/Home/User/detail',
            dataType: 'json',
            async: false,
            timeout: 3000,
            context: $('#userData'),
            success:function (res) {
                if (res.code==0) {
                    $.toast("！", 1000);
                    return;
                }
                var html = template("user-center-tpl", res.data);
                this.html(html);

                var url;
                if (res.data.ischief) {
                    url = APP_PATH + '/Home/User/adminInviteCode';
                    if (res.data.admininvitecode) url += '?code=' + res.data.admininvitecode;
                    $('#toInviteCode span').html('我的加盟商');
                    $('#toInviteCode').show().off('click').on('click', function () {
                        $.router.load(url, false);
                    });
                } else {
                    url = APP_PATH + '/Home/User/chiefInviteCode';
                    if (res.data.chiefinvitecode) url += '?code=' + res.data.chiefinvitecode;
                    $('#toInviteCode span').html('我的头领');
                    $('#toInviteCode').show().off('click').on('click', function () {
                        $.router.load(url, false);
                    });
                }

                userId = res.data.id;
            },
            error:function(){
                server_error();
            }
        });
        
    });

    $(document).on("pageInit", "#chiefInviteCode", function () {
        var origincodematch = location.search.match(/\?code=(\d+)/);
        var code = $('input[name="chiefInviteCode"]');
        var btn = $('#btn_send_code');
        var wrapbtn = $('#btn_if_show');

        if (!origincodematch) {
            wrapbtn.show();
            code[0].removeAttribute('disabled');
        } else {
            code.val(origincodematch[1]);
        }

        clampInputNum(code, 4);

        btn.off('click').on('click', function () {
            var chiefInviteCode = code.val();
            if (chiefInviteCode.length != 4) {
                $.toast('请填写4位数字邀请码!', 1000);
                return false;
            }
            $.ajax({
                type: 'POST',
                url: APP_PATH + '/Home/User/setChiefInviteCode',
                dataType: 'json',
                data: { chiefInviteCode: chiefInviteCode},
                success: function (res) {
                    if (res.code) {
                        $.toast('与头领绑定成功~', 1000);
                        wrapbtn.hide();
                        code[0].setAttribute('disabled', 'true');
                    } else {
                        $.toast(res.msg, 1000);
                    }
                },
                error: server_error
            });
        });
    });

    $(document).on("pageInit", "#adminInviteCode", function () {

        var origincodematch = location.search.match(/\?code=(\d+)/);
        var code = $('input[name="adminInviteCode"]');
        var btn = $('#btn_send_code');
        var wrapbtn = $('#btn_if_show');

        if (!origincodematch) {
            wrapbtn.show();
            code[0].removeAttribute('disabled');
        } else {
            code.val(origincodematch[1]);
        }

        clampInputNum(code, 4);

        btn.off('click').on('click', function () {
            var adminInviteCode = code.val();
            if (adminInviteCode.length != 4) {
                $.toast('请填写4位数字邀请码!', 1000);
                return false;
            }
            $.ajax({
                type: 'POST',
                url: APP_PATH + '/Home/User/setAdminInviteCode',
                dataType: 'json',
                data: { adminInviteCode: adminInviteCode},
                success: function (res) {
                    if (res.code) {
                        $.toast('与加盟商绑定成功~', 1000);
                        wrapbtn.hide();
                        code[0].setAttribute('disabled', 'true');
                    } else {
                        $.toast(res.msg, 1000);
                    }
                },
                error: server_error
            });
        });
    });

    function clampInputNum(container, num) {
        $(container).off('textInput').off('paste').on('textInput', function (e) {
            if ($(this).val().length >= num) {
                e.preventDefault();
            }
        }).on('paste', function (e) {
            e.preventDefault();
        });
    }

    $.init(); 
});