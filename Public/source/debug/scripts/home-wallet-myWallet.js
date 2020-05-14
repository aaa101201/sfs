/*
*该文件为钱包个人端整个模块的JS文件
*考虑到SUI MOBILE的路由机制，每个模块合成一个文件是较为稳妥和简洁的方案
*这样可以充分利用浏览器对静态文件的缓存机制，减少请求数
*/

$(function () {
	$(document).on("pageInit", "#bindZFB", function () {


		console.log("inited page::", "bindZFB!");

		var immeBind = $("#immeBind"),
        msg = document.getElementById("toShow");

		var hasBind = function (txt) {
            immeBind.html("修改绑定支付宝");
            msg.innerHTML = '<div class="zfbInfo pos_rela line_b">' +
                                '已绑定的支付宝:&nbsp;&nbsp;' +
                                '<strong>' + txt + '<\/strong>' +
                            '<\/div>';
            immeBind.click(function () {
                $.router.load(APP_PATH + "/Home/Wallet/bindZFBconfirm");
            });
        };

        var noBind = function () {
            immeBind.html("立即绑定支付宝");
            msg.innerHTML = '<div class="zfbInfo pos_rela line_b text-center">' +
                                '您还没有绑定支付宝账号哦~' +
                            '<\/div>';
            immeBind.click(function () {
                $.router.load(APP_PATH + "/Home/Wallet/bindZFBsetPwd");
            });
        };

		$.ajax({
			type: 'POST',
			url: APP_PATH + "/Home/Wallet/getBindAlipay",
			dataType: 'json',
			async: false,
			timeout: 3000,
			success: function (res) {
				if (res.code === 1) {
					var alipay = res.data.alipay;
					if (alipay) {
						hasBind(alipay);
					} else {
						noBind();
					}
				} else {
					noBind();
				}
			},
			error: function () {
				server_error();
			}
		});
	});

	$(document).on("pageInit", "#bindZFBsetPwd", function () {

        console.log("inited page::", "bindZFBsetPwd!");

        $("#payPwd").focus();

        $("#nextBtn").click(function(){

            var payPwd = $("#payPwd").val().trim(),
            repeatPwd = $("#repeatPwd").val().trim(),
            pwdReg = /^[0-9]{6}$/;

            if (!payPwd || !repeatPwd) {
                $.toast('密码不能为空', 800);
            } else if (!pwdReg.test(payPwd) || !pwdReg.test(repeatPwd)) {
                $.toast('密码必须为6位纯数字', 800);
            } else if (payPwd !== repeatPwd) {
                $.toast('两次输入的密码不一致', 800);
            } else {
                $.ajax({
                    type: 'POST',
                    async: false,
                    timeout: 3000,
                    dataType: 'json',
                    url : APP_PATH + '/Home/Wallet/setPassword',
                    data : {'password': payPwd, 'confirm': repeatPwd},
                    success : function (result) {
                        if (result.code === 0) {
                            $.toast('密码设置失败T^T', 800);
                            return;
                        } else {
                            setTimeout(function () {
                                $.router.load(APP_PATH + '/Home/Wallet/bindZFBdetailInfo', true);
                            }, 1000);
                            $.toast('密码设置成功', 500);
                        }
                    },
                    error: function (xhr, type) {
                        server_error();
                    }
                });
            }
        });
    });

    $(document).on("pageInit", "#bindZFBdetailInfo", function () {
    	console.log("inited page::", "bindZFBdetailInfo!");
        var vfrom = location.search.slice(3), vto = '';
        if (vfrom === '2') {
            $("#descripChange").html("验证");
            vto = '?v=2'
        }
    	$("#nextBtn").click(function () {

    		var account = $("#account").val().trim(),
    		username = $("#username").val().trim();

    		$.ajax({
    			type: 'POST',
    			url: APP_PATH + "/Home/Wallet/bindAlipay",
    			async: false,
    			data: {
    				"alipay": account,
    				"alipayName": username
    			},
    			timeout: 3000,
    			dataType: 'json',
    			success: function (res) {
    				if (res.code === 1) {
						$.router.load(APP_PATH + '/Home/Wallet/bindZFBstatus' + vto, true);
    				} else {
    					$.toast(res.msg, 800);
    				}
    			},
    			error: function () {
    				server_error();
    			}
    		});
    	});
    });

    $(document).on("pageInit", "#bindZFBconfirm", function () {
        var timer = null; //bind the timeout
        console.log("inited page::", "bindZFBconfirm!");
        var getconPhoneInfo = function () {
            $.ajax({
                type: 'POST',
                url: APP_PATH + '/Home/Wallet/getUserPhone',
                dataType: 'json',
                timeout: 3000,
                context: $('#conphone'),
                success: function(res){
                    if(res.code) {
                        var phone = res.data.phone;
                        this.attr("value",phone);
                    } else {
                        server_error();
                    }
                },
                error: function(xhr, type){
                    server_error();
                }
            });
        }
        getconPhoneInfo();

        $('.conbtn_send').unbind('click').click(function () {
        	var conwait = 60;
            var contel = $("#conphone").val(); //获取手机号
            var contime = function () {
                $('.conbtn_send').addClass('count');
                $('.conbtn_send').html(conwait + '秒后重发');
                if (conwait === 0) {
                    $('.conbtn_send').html('获取验证码');
                    conwait = 60;
                    $('.conbtn_send').addClass('conrepeat_send');
                    $('.conbtn_send').removeClass('bg-gray');
                    $(".conbtn_send").removeAttr("disabled");
                    return;
                } else {
                    $('.conbtn_send').removeClass('conrepeat_send');
                    conwait--;
                    $('.conbtn_send').addClass('bg-gray');
                    $(".conbtn_send").attr("disabled","disabled");
                    timer = setTimeout(function () {
                        contime();
                    }, 1000);
                }
            };

            contime();

            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: APP_PATH + '/Home/Tools/getCaptcha',
                data: {
                    "phone": contel,
                    "type": 2  // 2 means confirm not reset the password
                },
                success: function (data) {
                    if (data.code == 0) {
                        conwait = 60;
                        $('.conbtn_send').addClass('conrepeat_send');
                        $(".conbtn_send").removeAttr("disabled");
                        return;
                    }else {
                        $.toast(data.msg, 1000, "toast_orange");
                    }
                },
                error: function () {
                    $.toast("萝卜们太热情，服务器表示鸭梨很大！", 1000, "toast_orange");
                }
            });
        });
        $("#nextBtn").unbind('click').click(function () {
            var oldPwd = $("#oldPwd").val().trim(),
            pwdReg = /^[0-9]{6}$/;
            var smsCode = $("#phonecaptcha").val();
            var tel = $("#conphone").val();

            if (!oldPwd) {
                $.toast('您还没有输入密码', 800); return false;
            } else if (!pwdReg.test(oldPwd)) {
                $.toast('密码为6位纯数字哦~', 800); return false;
            } else if (!$(".conbtn_send").hasClass('count')) {
                $.toast("请获取验证码", 1000, "toast_orange"); return false;
            } else {
                $.ajax({
                    type: 'POST',
                    url: APP_PATH + "/Home/Wallet/tellOldPassword",
                    async: false,
                    data: {
                        "oldPwd": oldPwd,
                        "phone": tel,
                        "captcha": smsCode
                    },
                    dataType: 'json',
                    timeout: 3000,
                    success: function (res) {
                        if (res.code === 0) {
                            $.toast('密码验证失败', 800);
                        } else {
                            setTimeout(function () {
                                $.router.load(APP_PATH + "/Home/Wallet/bindZFBdetailInfo?v=2");
                            }, 1000);
                            clearTimeout(timer);
                            $('.conbtn_send').html('获取验证码');
                            $('.conbtn_send').addClass('conrepeat_send');
                            $('.conbtn_send').removeClass('bg-gray');
                            $(".conbtn_send").removeAttr("disabled");
                            $.toast("密码验证成功", 500)
                        }
                    },
                    error: function () {
                        server_error();
                    }
                });
            }
        });
    });

    $(document).on("pageInit", "#bindZFBstatus", function () {
        var vfrom = location.search.slice(3);
        if (vfrom === '2') {
            $("#descripChange").html("验证");
        }
    });

    $(document).on("pageInit", "#userIncomeDetail", function(e, id, page) {
        console.log("inited", "userIncomeDetail Page!");


        var pageSize = 10;
        var currPage = 1;
        var loading = false;
        var maxItems = 100;

        function addItems() {
            $.ajax({
                type: 'POST',
                url: APP_PATH+'/Home/Wallet/getIncomeDetail',

                data: {
                    "currPage": currPage,
                    "pageSize": pageSize
                },
                dataType: 'json',
                timeout: 3000,
                context: $('.userIncomeList'),
                success: function(res){
                    console.log(res);
                    if(res.code) {
                        maxItems = res.data.total;
                        if(maxItems <= 0){
                            $.toast("您还没有收支明细啦！", 1000, "toast_orange");
                            return false;
                        }

                        var data = {"datas": res.data.data};
                        var html = template("tpl-userIncomeDetail", data);
                        this.append(html);

                        if(maxItems < pageSize) {
                            $('.infinite-scroll-preloader').hide();
                        }
                        loading = false;
                        currPage ++;

                    } else {
                        server_error();
                        $.detachInfiniteScroll($('.infinite-scroll'));
                        $('.infinite-scroll-preloader').remove();
                    }
                },
                error: function(xhr, type){
                    server_error();
                    $.detachInfiniteScroll($('.infinite-scroll'));
                    $('.infinite-scroll-preloader').remove();
                }
            });
        };

        // 注册'infinite'事件处理函数
        $(document).on('infinite', '.infinite-scroll-bottom', function() {
            $('.infinite-scroll-preloader').show();
            if (loading) return;
            loading = true;
            setTimeout(function() {
                if (maxItems <= (currPage-1) * pageSize) {
                    $.detachInfiniteScroll($('.infinite-scroll'));
                    $.toast("(^_^) 木有更多信息啦！");
                    $('.infinite-scroll-preloader').hide();
                    return;
                }
                addItems(currPage, pageSize);
                $.refreshScroller();
            }, 500);
        });

        addItems();
    });

    $(document).on("pageInit", "#withDrawCash", function(e, id, page) {
        //预填充支付宝账户信息
        function getZFBInfo() {
            $.ajax({
                type: 'POST',
                // url: '/Mockup/Wallet/getBindAlipay.json',
                url: APP_PATH+'/Home/Wallet/getBindAlipay',
                data: {
                },
                dataType: 'json',
                timeout: 3000,
                context: $('.userIncomeList'),
                success: function(res){
                    if(res.code) {
                        var alipayName = res.data.alipayname;
                        var alipay = res.data.alipay;
                        $('#zfb').attr("value",alipay);
                        $('#zfbName').attr("value",alipayName);
                    } else {
                        server_error();
                    }
                },
                error: function(xhr, type){
                    server_error();
                }
            });
        }
        getZFBInfo();

        //点击确认提现按钮
        $("#btnWithDraw").unbind('click').bind('click',function () {
            var zfbNum = $('#zfbNum').val();
            var zfbPwd = $('#zfbPwd').val();
            var reg = /^\d{6}$/;   //6位纯数字
            var zfb = $('#zfb').val();
            var zfbName = $('#zfbName').val();
            var regNum = /^(\+|-)?\d+$/; //正整数

            var myDate = new Date();
            var dateNum = myDate.getDay(); //dateNum != 2,周二限制
            if(!regNum.test(zfbNum) || zfbNum<60){
                $.toast("提现金额必须为不低于60元的正整数", 1000, "toast_orange");
            }else if(!reg.test(zfbPwd)){
                $.toast("请输入6位纯数字支付密码", 1000, "toast_orange");
                $("#zfbPwd").focus();
            }else{
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: APP_PATH+'/Home/Wallet/withDrawCash',
                    data: {
                        "amount": zfbNum,
                        "password": zfbPwd,
                        "alipay": zfb,
                        "alipayname": zfbName
                    },
                    success: function (data) {
                        if (data.code) { //确认取现成功,跳转页面

                            window.location.href = APP_PATH+"/Home/Wallet/withDrawCashStatus.html";
                        } else { //验证放在服务器端返回
                            $.toast(data.msg, 1000, "toast_orange");
                            $("#zfbNum").val('');
                            $('#zfbPwd').val('');
                        }
                    },
                    error: function () {
                        $.toast("萝卜们太热情，服务器表示鸭梨很大！", 1000, "toast_orange");
                    }

                });
            }
        });


    });

    $(document).on("pageInit", "#rechargeCash", function(e, id, page) {

        //点击确认充值按钮
        $("#btnRecharge").unbind('click').bind('click',function () {
            var amount = $('#rechargeNum').val();
            var regNum = /^(\+|-)?\d+$/; //正整数
            if(!regNum.test(amount) || amount<1){
                $.toast("提现金额必须为大于1元的正整数", 1000, "toast_orange");
                $("#amount").focus();
            }else{
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: APP_PATH+'/Home/Wallet/confirmRecharge',
                    data: {
                        "amount": amount,
                        "payType": 0//微信支付
                    },
                    success: function (data) {
                        if (data.code == 1) {

                            // console.log(data.jsApiParameters);

                            callpay(data.jsApiParameters, data.orderId);
                        } else {
                             $.toast(data.msg, 1000, "toast_orange");
                        }
                    },
                    error: function () {
                        $.toast("萝卜们太热情，服务器表示鸭梨很大！", 1000, "toast_orange");
                    }

                });
                //调用微信JS api 支付
                function jsApiCall(jsData, orderId){
                    WeixinJSBridge.invoke(
                        'getBrandWCPayRequest',
                        // JSON.stringify(jsData),
                        jsData,
                        function(res){
                            WeixinJSBridge.log(res.err_msg);
                            console.log(res.err_msg);
                            if(res.err_msg == "get_brand_wcpay_request:ok"){
                                $.alert("充值成功!");
                                // $.toast("充值成功!", 1000, "toast_orange");
                                // window.location.href = APP_PATH+"/Company/Wallet/rechargeStatus.html"
                                setTimeout(function() {
                                   window.location.href = APP_PATH+"/Home/Wallet/myWallet.html"
                                }, 2000);
                            }else if(res.err_msg == "get_brand_wcpay_request:cancel"){
                                $.ajax({
                                    type: 'get',
                                    url: APP_PATH + '/Home/Wallet/cancelRecharge',
                                    data: {
                                        'orderId': orderId
                                    },
                                    dataType: 'json',
                                    async: false,
                                    success: function (res) {
                                        $.alert("取消成功!");
                                        setTimeout(function() {
                                           window.location.href = APP_PATH+"/Home/Wallet/myWallet.html"
                                        }, 2000);
                                    },
                                    error: function () {
                                        $.alert("取消失败!");
                                        setTimeout(function() {
                                           window.location.href = APP_PATH+"/Home/Wallet/myWallet.html"
                                        }, 2000);
                                    }
                                });
                            }else{
                                $.alert("充值失败,请重新充值!");
                                // $.toast("充值失败!", 1000, "toast_orange");
                                setTimeout(function() {
                                   window.location.href = APP_PATH+"/Home/Wallet/myWallet.html"
                                }, 2000);
                            };
                        }
                    );
                };
                function callpay(jsData, orderId){
                    if (typeof WeixinJSBridge == "undefined"){
                        if( document.addEventListener ){
                            document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
                        }else if (document.attachEvent){
                            document.attachEvent('WeixinJSBridgeReady', jsApiCall);
                            document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
                        }
                    }else{

                        jsApiCall(jsData, orderId);
                    }
                };
            }
        });
    });

    $(document).on("pageInit", "#bindZFBreSetPwd", function() {
        var intervalId;

        //预填充账户信息
        function getPhoneInfo() {
            $.ajax({
                type: 'POST',
                // url: '/Mockup/Wallet/getUserPhone.json',
                url: APP_PATH+'/Home/Wallet/getUserPhone',
                data: {
                },
                dataType: 'json',
                timeout: 3000,
                context: $('#phone'),
                success: function(res){
                    if(res.code) {
                        var phone = res.data.phone;
                        $('#phone').attr("value",phone);
                    } else {
                        server_error();
                    }
                },
                error: function(xhr, type){
                    server_error();
                }
            });
        }
        getPhoneInfo();

        var wait = 60;
        $('.repeat_send').unbind('click').click(function () {
            var tel = $("#phone").val(); //获取手机号
            function time() {

                $('.btn_send').addClass('count');
                $('.btn_send').html(wait+ '秒后重发');

                if (wait == 0) {

                    $('.btn_send').html('获取验证码');
                    wait = 60;
                    $('.btn_send').addClass('repeat_send');

                    $('.btn_send').removeClass('bg-gray');
                    $(".btn_send").removeAttr("disabled");
                    return;

                } else {

                    $('.btn_send').removeClass('repeat_send');
                    wait--;
                    $('.btn_send').addClass('bg-gray');
                    $(".btn_send").attr("disabled","disabled");

                    setTimeout(function () {
                        time();
                    }, 1000);
                }
            }

            time();

            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: APP_PATH + '/Home/Tools/getCaptcha',
                data: {
                    "phone": tel,
                    "type": 3

                },
                success: function (data) {
                    if (data.code == 0) {
                        wait = 60;
                        $('.btn_send').addClass('repeat_send');
                        $(".btn_send").removeAttr("disabled");
                        return;
                    }else {
                        $.toast(data.msg, 1000, "toast_orange");
                    }
                },
                error: function () {
                    $.toast("萝卜们太热情，服务器表示鸭梨很大！", 1000, "toast_orange");
                }
            });
        });


        //点击重置密码按钮的验证
        $("#btnResetPwd").unbind('click').bind('click',function () {

            var smsCode = $("#phonecaptcha").val();
            var newPwd = $("#newPwd").val().trim();
            var reNewPwd = $("#reNewPwd").val().trim();
            var tel = $("#phone").val(); //获取手机号

            var telReg = !!tel.match(/^(0|86|17951)?(13[0-9]|15[0-9]|17[0-9]|18[0-9]|14[57])[0-9]{8}$/);//验证手机号

            var reg = /^\d{6}$/;   //6位纯数字

            if (!telReg) {
                $.toast("请输入正确格式的号码", 1000, "toast_orange");
                return false;
            }else if (!reg.test(smsCode)) {
                $.toast("请输入6位数字验证码", 1000, "toast_orange");
                return false;
            }else if(!reg.test(newPwd)){ //验证为6位纯数字
                $.toast("密码必须为6位纯数字", 1000, "toast_orange");
                return false;
            }else if (newPwd != reNewPwd) {
                $.toast('(^_^) 新密码两次 输入不一致', 1000);
                return;
            }else if (!$(".btn_send").hasClass('count')) {
                $.toast("请获取验证码", 1000, "toast_orange");
                return false;
            }else {
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: APP_PATH+'/Home/Wallet/resetPassword',
                    data: {
                        "phone": tel,
                        "captcha": smsCode,
                        "password": newPwd,
                        "confirm": reNewPwd
                    },
                    success: function (data) {
                        if (data.code == 1) { //重置密码成功,跳转页面
                            $.toast("重置支付密码成功!", 1000, "toast_orange");

                            setTimeout(function() {
                               window.location.href = "/index.php";
                            }, 2000);
                        } else { //验证码的验证放在服务器端返回
                            $("#phonecaptcha").val('');
                             $.toast(data.msg, 1000, "toast_orange");
                        }
                    },
                    error: function () {
                        $.toast("萝卜们太热情，服务器表示鸭梨很大！", 1000, "toast_orange");
                    }
                });
            }
        });
    });

    $(document).on("pageInit", "#chiefIncome", function () {
        console.log("inited page::", "chiefIncome!");


        $.ajax({
            type: 'POST',
            url: APP_PATH + "/Home/Wallet/getPromotDetail",
            dataType: 'json',
            success: function (res) {
                if (res.code) {
                    var spread = String(res.data.promotgains || 0), free =  String(res.data.financialgains || 0), online = String(res.data.salarygains || 0);
                    $('#spreadIncome').html(formatNum(spread));
                    $('#freeIncome').html(formatNum(free));
                    $('#salarygains').html(formatNum(online));
                } else {
                    $('#spreadIncome').html('0.00');
                    $('#freeIncome').html('0.00');
                    $('#salarygains').html('0.00');
                }
            },
            error: server_error
        });
    });

    $(document).on("pageInit", "#freeIncome", function () {
        console.log("inited page::", "freeIncome!");

        var loading = false, pageSize = 10, currPage = 1, maxItems = 100, lastIndex = 10;

        var list = $('#freeIncomeList');

        list.empty();
        addItems();

        $(document).on("infinite", ".infinite-scroll", function () {
            if (loading) {
                return false;
            }
            loading = true;
            setTimeout(function () {
                loading = false;
                if (lastIndex >= maxItems) {
                    $.detachInfiniteScroll($('.infinite-scroll'));
                    $('.infinite-scroll-preloader').remove();
                    return;
                }
                addItems();
                lastIndex = list.children('li').length;
                $.refreshScroller();
            }, 500);
        });

        function addItems() {
            $.ajax({
                type: 'POST',
                url: APP_PATH + "/Home/Wallet/getFinancialLog",
                dataType: 'json',
                data: {
                    pageSize: pageSize,
                    currPage: currPage
                },
                success: function (res) {
                    if (res.code) {

                        maxItems = res.data.total;
                        var html = template('tpl-chiefIncomeDetail', {items: res.data.data});
                        list.append(html);
                        currPage++;

                        if (lastIndex >= maxItems) {
                            $.detachInfiniteScroll($('.infinite-scroll'));
                            $('.infinite-scroll-preloader').remove();
                            return;
                        }
                    }
                },
                error: server_error
            });
        }
    });
    $(document).on("pageInit", "#salaryIncome", function () {
        console.log("inited page::", "salaryIncome!");

        var loading = false, pageSize = 10, currPage = 1, maxItems = 100, lastIndex = 10;

        var list = $('#salaryIncomeList');

        list.empty();
        addItems();

        $(document).on("infinite", ".infinite-scroll", function () {
            if (loading) {
                return false;
            }
            loading = true;
            setTimeout(function () {
                loading = false;
                if (lastIndex >= maxItems) {
                    $.detachInfiniteScroll($('.infinite-scroll'));
                    $('.infinite-scroll-preloader').remove();
                    return;
                }
                addItems();
                lastIndex = list.children('li').length;
                $.refreshScroller();
            }, 500);
        });

        function addItems() {
            $.ajax({
                type: 'POST',
                url: APP_PATH + "/Home/Wallet/getSalaryLog",
                dataType: 'json',
                data: {
                    pageSize: pageSize,
                    currPage: currPage
                },
                success: function (res) {
                    if (res.code) {

                        maxItems = res.data.total;
                        var html = template('tpl-chiefIncomeDetail', {items: res.data.data});
                        list.append(html);
                        currPage++;

                        if (lastIndex >= maxItems) {
                            $.detachInfiniteScroll($('.infinite-scroll'));
                            $('.infinite-scroll-preloader').remove();
                            return;
                        }
                    }
                },
                error: server_error
            });
        }
    });

    $(document).on("pageInit", "#spreadIncome", function () {
        console.log("inited page::", "spreadIncome!");

        var loading = false, pageSize = 10, currPage = 1, maxItems = 100, lastIndex = 10;

        var list = $('#spreadIncomeList');

        list.empty();
        addItems();

        $(document).on("infinite", ".infinite-scroll", function () {
            if (loading) {
                return false;
            }
            loading = true;
            setTimeout(function () {
                loading = false;
                if (lastIndex >= maxItems) {
                    $.detachInfiniteScroll($('.infinite-scroll'));
                    $('.infinite-scroll-preloader').remove();
                    return;
                }
                addItems();
                lastIndex = list.children('li').length;
                $.refreshScroller();
            }, 500);
        });

        function addItems() {
            $.ajax({
                type: 'POST',
                url: APP_PATH + "/Home/Wallet/getPromotLog",
                dataType: 'json',
                data: {
                    pageSize: pageSize,
                    currPage: currPage
                },
                success: function (res) {
                    if (res.code) {

                        maxItems = res.data.total;
                        var html = template('tpl-chiefIncomeDetail', {items: res.data.data});
                        list.append(html);
                        currPage++;

                        if (lastIndex >= maxItems) {
                            $.detachInfiniteScroll($('.infinite-scroll'));
                            $('.infinite-scroll-preloader').remove();
                            return;
                        }
                    }
                },
                error: server_error
            });
        }
    });

	$(document).on("pageInit", "#myWallet", function () {
		console.log("inited page::", "myWallet!");
		$.ajax({
			type: 'POST',
			url: APP_PATH + "/Home/Wallet/getWalletDetail",
			dataType: 'json',
			async: false,
			timeout: 3000,
			context: $("#totalMoney span"),
			success: function (res) {
				if (res.code === 1) {
					if (res.data.totalMoney) {
						this.html(formatNum(res.data.totalMoney));
					} else {
						this.html("0.00");
					}
                    if (res.data.walletbalance){
                        $('#yuebaoMonry h5').html(formatNum(res.data.walletbalance));
                    } else {
						$('#yuebaoMonry h5').html("0.00");
					}
                    if (res.data.money){
                        $('#walletMoney h5').html(formatNum(res.data.money));
                    } else {
						$('#walletMoney h5').html("0.00");
					}
                    if (res.data.ischief) {
                        $('#chiefblock').show();
                    }
				} else {
					this.html("0.00");
				}
                this.addClass("gradient");
			},
			error: function () {
				server_error();
			}
		});

		var hasAli = function () {
			$("#withDraw").click(function () {
				$.router.load(APP_PATH + '/Home/Wallet/withDraw', true);
			});
			$("#findPwd").click(function () {
				$.router.load(APP_PATH + '/Home/Wallet/bindZFBreSetPwd', true);
			});
		};

		var noAli = function () {
			$("#withDraw").click(function () {
				setTimeout(function () {
					$.router.load(APP_PATH + '/Home/Wallet/bindZFBsetPwd', true);
				}, 1000);
				$.toast('您还没有绑定支付宝哦~', 800);
			});
			$("#findPwd").click(function () {
				setTimeout(function () {
					$.router.load(APP_PATH + '/Home/Wallet/bindZFBsetPwd', true);
				}, 1000);
				$.toast('您还没有绑定支付宝哦~', 800);
			});
		};

		$.ajax({
			type: 'POST',
			url: APP_PATH + "/Home/Wallet/getBindAlipay",
			dataType: 'json',
			async: false,
			timeout: 3000,
			success: function (res) {
				if (res.code === 1) {
					var alipay = res.data.alipay;
					if (alipay) {
						hasAli();
					} else {
						noAli();
					}
				} else {
					noAli();
				}
			},
			error: function () {
				server_error();
			}
		});

        $("#recharge").click(function () {
            $.router.load(APP_PATH + '/Home/Wallet/recharge', true);
        });
	});
	/*余额宝*/
	$(document).on("pageInit", "#yuebao", function () {
		console.log("inited page::", "yuebao!");
		$.ajax({
			type: 'POST',
			url: APP_PATH + "/Home/Wallet/getWalletDetail",
			dataType: 'json',
			async: false,
			timeout: 3000,
			context: $("#yuebaoMoney span"),
			success: function (res) {
				if (res.code === 1) {
					if (res.data.walletbalance) {
						this.html(formatNum(res.data.walletbalance));
					} else {
						this.html("0.00");
					}
                    if (res.data.income){
                        $('#income h5').html(formatNum(res.data.income));
                    } else {
						$('#income h5').html("0.00");
					}
                    if (res.data.rate){
                        $('#rate h5').html(res.data.rate * 100 + '%');
                    } else {
						$('#rate h5').html("*");
					}
				} else {
					this.html("0.00");
				}
                this.addClass("gradient");
			},
			error: function () {
				server_error();
			}
		});
	});
	/*钱包转入余额宝*/
	$(document).on("pageInit", "#walletToYuebao", function () {
		console.log("inited page::", "walletToYuebao!");
		function drawPage(){
			$.ajax({
				type: 'POST',
				url: APP_PATH + "/Home/Wallet/getWalletDetail",
				dataType: 'json',
				async: false,
				timeout: 3000,
				context: $("#walletMoney"),
				success: function (res) {
					if (res.code === 1) {
						if (res.data.money) {
							this.html(formatNum(res.data.money)+'元');
						}else {
							this.html("0.00元");
						}
					} else {
						this.html("*.**元");
					}
				},
				error: function () {
					server_error();
				}
			});
			$('#w2yNum').val('');
		}

        $("#btnWTY").unbind('click').bind('click',function () {
            var w2yNum = $('#w2yNum').val();
            var regNum = /^\d+$/;
            if(!regNum.test(w2yNum) || w2yNum<1){
                $.toast("转入金额必须为大于1元的正整数", 1000, "toast_orange");
                $("#w2yNum").focus();
            }else{
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: APP_PATH+'/Home/Wallet/shiftToBalance',
                    data: {
                        "money": w2yNum,
						"type": 0 //0：用户 1：企业
                    },
                    success: function (data) {
                        $.toast(data.msg, 1000, "toast_orange");
						drawPage();
						setTimeout(function() {
						   window.location.href = APP_PATH+"/Home/Wallet/yuebao.html"
						}, 2000);
                    },
                    error: function () {
                        $.toast("萝卜们太热情，服务器表示鸭梨很大！", 1000, "toast_orange");
                    }

                });
            }
        });

		drawPage();
	});
	/*余额宝收支明细*/
	$(document).on("pageInit", "#yuebaoIncomeDetail", function () {
		console.log("inited page::", "yuebaoIncomeDetail!");

        var loading = false, pageSize = 15, currPage = 1, maxItems = 100, lastIndex = 10;

        var list = $('#yuebaoIncomeList');

        //list.empty();
        addItems();

        $(document).on("infinite", ".infinite-scroll", function () {
            if (loading) {
                return false;
            }
            loading = true;
            setTimeout(function () {
                loading = false;
                if (lastIndex >= maxItems) {
                    $.detachInfiniteScroll($('.infinite-scroll'));
                    $('.infinite-scroll-preloader').remove();
                    return;
                }
                addItems();
                lastIndex = list.children('li').length + 1;
                $.refreshScroller();
            }, 500);
        });

        function addItems() {
            $.ajax({
                type: 'POST',
                url: APP_PATH + "/Home/Wallet/showBalanceDetail",
                dataType: 'json',
                data: {
                    start: currPage,
                    pagesize: pageSize
                },
                success: function (res) {
                    if (res.code == 0 && Number(res.total)>0) {
                        maxItems = res.total;

                        var html = template('tpl-yuebaoIncomeDetail', {items: res.data});
						console.log(html)
                        list.append(html);
						$('#yuebaoIncomeList').removeClass('display_none');
                        currPage++;
                        if (lastIndex >= maxItems) {
                            $.detachInfiniteScroll($('.infinite-scroll'));
                            $('.infinite-scroll-preloader').remove();
                            return;
                        }

                    }else{
						$('.wallet_tip_img').removeClass('display_none');
					}
                },
                error: server_error
            });
        }
	});
	$.init();

    function formatNum(str){
        var intNum = '', decimal = '', group = [];

        var plusD = function (str) {
            var temp = [], len = str.length;
            for (var i = 0; i < len; i++) {
                var char = str[i];
                if ((len - i - 1) % 3 === 0 && (len - i - 1) !== 0) {
                    temp.push(char, ',');
                } else {
                    temp.push(char);
                }
            }
            return temp.join('');
        };

        if (str = String(str)) {
            group = str.split('.');
            intNum = plusD(group[0]);
            decimal = group[1];
            if (decimal) {
                switch (decimal.length) {
                    case 1: decimal = decimal + '0'; break;
                    default: decimal = decimal.slice(0, 2);
                }
            } else {
                decimal = '00';
            }
            return intNum + '.' + decimal;
        }
    }
});
