$(function () {
    /*
    *此文件为前端用到的状态字段作统一的定义
    */
    var statusEnum = {
        //交易类型
        TYPE_DECREASE : 0, //减少
        TYPE_INCREASE : 1, //增加

        //用户订单类型
        ORDERTYPE_USER_DEPOSIT : 0, //用户充值 
        ORDERTYPE_USER_WAGE : 1, //用户获得薪水
        ORDERTYPE_USER_WITHDRAWCASH : 2, //用户提现

        //企业订单类型
        ORDERTYPE_COMPANY_DEPOSIT : 20,  //企业充值
        ORDERTYPE_COMPANY_PAYOFF : 21, //企业发工资

        //订单状态
        STATUS_ORDER_FAILED  : 0,    //失败
        STATUS_ORDER_PROCESSING : 1, //处理中
        STATUS_ORDER_SUCCEEDED : 2,  //成功

        //钱包状态
        STATUS_DISABLED : 0, //禁用
        STATUS_NORMAL : 1, //正常
        STATUS_FREEZED : 2, //冻结
    };

    var handler = function (enumer) {
        for (key in enumer) {
            if (enumer.hasOwnProperty(key)) {
                template.helper(key, (function (key) {
                    return function () {
                        return String(enumer[key]);
                    };
                })(key));
            }
        }
    };

    handler(statusEnum);

	$(document).on("pageInit", "#myWallet", function () {
		console.log("inited page::", "myWallet!");
		$.ajax({
			type: 'GET',
			url: APP_PATH + "/Company/Wallet/getWalletDetail",
			dataType: 'json',
			async: false,
			timeout: 3000,
			context: $("#totalMoney span"),
			success: function (res) {
				if (res.code === 1) {
					var money = res.data.money;
					console.log('money: ' + money);
					if (money) {
						this.html(money);
						this[0].classList.add("gradient");
					} else {
						this.html("0.00");
						this[0].classList.add("gradient");
					}
				} else {
					this.html("0.00");
					this[0].classList.add("gradient");
				}
			},
			error: function () {
				server_error();
			}
		});
		$.ajax({
			type: 'GET',
			url: APP_PATH + '/Company/Wallet/IsPasswordEmpty',
			dataType: 'json',
			async: false,
			timeout: 3000,
			success: function (res) {
				console.log(res);
				if (!res) {
					$('#setPwd').click(function () {
						$.router.load(APP_PATH + '/Company/Wallet/myWallet_setPwd');
					});
				} else {
					$('#setPwd').click(function () {
						$.toast('您已经设置过密码了~');
					});
				}
			},
			error: server_error
		});
	});

	$(document).on("pageInit", "#setPwd", function () {

	    console.log("inited page::", "setPwd!");

	    var s = location.search, leap = null;
	    var isfrompay = s.slice(s.indexOf('?') + 1).split('=')[1];
	    if (isfrompay) {
	    	leap = APP_PATH + '/Company/User/bizCenter';
	    } else {
	    	leap = APP_PATH + '/Company/Wallet/myWallet';
	    }

	    $("#ok").click(function(){
	        var password = $("#password").val().trim(),
	        confirm = $("#confirm").val().trim(),
	        pwdReg = /^[0-9]{6}$/;
	        
	        if (!password || !confirm) {
	            $.toast('密码不能为空', 800);
	        } else if (!pwdReg.test(password) || !pwdReg.test(confirm)) {
	            $.toast('密码必须为6位纯数字', 800);
	        } else if (password !== confirm) {
	            $.toast('两次输入的密码不一致', 800);
	        } else {
	            $.ajax({
	                type: 'POST',
	                async: false,
	                timeout: 3000,
	            	dataType: 'json',
	            	url : APP_PATH + '/Company/Wallet/setPassword',
	            	data : {'password': password, 'confirm': confirm},
	          		success : function (result) {
	              		if (result.code === 0) {
	                  		$.toast('密码设置失败T^T', 800);
	                  		return;
	              		} else {
	                  		setTimeout(function () {
	                      		location.href = leap;
	                  		}, 1000);
	                  		$.toast('密码设置成功', 800);
	              		}
	          		},
	         		error: function (xhr, type) {
	              		server_error();
	          		}
	        	});
	      	}
	    });
	});

	$(document).on("pageInit", "#bizIncomeDetail", function() {
        console.log("inited", "bizIncomeDetail Page!");
        
        var pageSize = 10;
        var currPage = 1;
        var loading = false;
        var maxItems = 100;

        function addItems() {
            $.ajax({
                type: 'GET',
                url: APP_PATH + '/Company/Wallet/getIncomeDetail',
                data: { 
                    "currPage": currPage, 
                    "pageSize": pageSize
                },
                async: false,
                dataType: 'json',
                timeout: 3000,
                context: $('#companyIncomeDetailList'),
                success: function(res){
                    console.log(res);
                    if(res.code) {
                        maxItems = res.data.total;
                        if(maxItems <= 0){
                            $.toast("您还没有收支明细啦！", 1000, "toast_orange");   
                            return false; 
                        }

                        var data = {"datas": res.data.data};
                        var html = template("tpl-bizIncomeDetail", data);
                        this.append(html);

                        if(maxItems < pageSize) {
                            $('.infinite-scroll-preloader').hide();
                        }
                        loading = false;
                        currPage++;
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
        $("#bizIncomeDetail").off('infinite').on('infinite', '.infinite-scroll-bottom', function() {
            $('.infinite-scroll-preloader').show();
            if (loading) return;
            loading = true;
            setTimeout(function() {
                if (maxItems <= (currPage - 1) * pageSize) {
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

    $(document).on("pageInit", "#payAmount", function(e, pageId, $page) {
        console.log('inited page:: payAmount!');

        function GetQueryString(name) {  
            var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");  
            var r = window.location.search.substr(1).match(reg);  //获取url中"?"符后的字符串并正则匹配
            var context = "";  
            if (r != null)  
                context = r[2];  
                reg = null;  
                r = null;  
                return context == null || context == "" || context == "undefined" ? "" : context;          
        }
        var aIds = GetQueryString("aIds");
        var aIdstr = aIds.substring(0, aIds.length - 1);
        
        var sIds = GetQueryString("uIds"); //获取参数uIds的值
       
        var str = sIds.substring(0, sIds.length - 1); //去掉最后一个逗号
        
        var sArr= str.split(",");       //字符串转化为数组
        
        var sArrLeg = sArr.length; //获取选择要发放的人员数量

        var search = location.search;
        var jobId = search.slice(search.indexOf("&jobId=") + "&jobId=".length);

        $('a.back').off('click').on('click', function () {
            history.back();
        });

        $('.btnPay').on('click', function () {
            var sVal = $('#amountVal').val();
            var reg = /^[0-9]*[0-9][0-9]*\.?[0-9]{0,1}$/;
            if(sVal == '' || sVal == 'undefined'){
                $.alert('输入金额不能为空');
            } else if (sVal == 0) {
                $.alert('输入金额不能为0');
            } else if (!reg.test(sVal)) {
                $.alert('发放工资的最小单位为角');
            } else {
                var totalAmount = sVal*sArrLeg;
                var shtml = '需支付所有员工工资总数:<h3 style="color:#fff;">'+totalAmount+'元</h3><input id="zfbPwd" type="password" placeholder="请输入支付密码" style="color: #000;" />';
                $.alert(shtml, function(){
                    var txtPwd = $("#zfbPwd").val();
                    console.log(txtPwd);
                    var regPwd = /^\d{6}$/; 
                    if(!reg.test(txtPwd)){
                        $.toast("支付密码必须为6位纯数字", 1000, "toast_orange");  
                        return false;
                    }else{
                        // console.log(str+'=='+txtPwd+"=="+sVal+"==");
                        $.ajax({
                            type: 'POST',
                            dataType: 'json',
                            url: APP_PATH+'/Company/Apply/payoffToUsers',
                            data: {
                                "aids": aIdstr,
                                "ids": str,
                                "jobId": jobId,
                                "password": txtPwd,
                                "wage": sVal,
                                "companyId": ''
                            },
                            success: function (data) {
                                if (data.code === 1) { 
                                    $.toast("人员发放工资成功!", 1000, "toast_orange");
                                    
                                    setTimeout(function() {
                                       window.location.href = APP_PATH+"/Company/Wallet/myWallet.html"
                                    }, 2000);
                                } else { 
                                     $.toast(data.msg, 1000, "toast_orange");
                                }
                            },
                            error: function () {
                                $.toast("萝卜们太热情，服务器表示鸭梨很大！", 1000, "toast_orange");
                            }

                        });
                    }
                    
                });
            }
            
        });
    });

    var hasClicked = false, sId = 1;
	$(document).on('pageInit', '#payList_toPay', function () {

		console.log('inited page::', 'payList_toPay');

		var currPage = 1, pageSize = 10, companyId = '', loading = false, maxItems = 100;

		if (!hasClicked) {
			getList(sId);
			regScroll();
		}
		bindTab();
		bindButton();
		function bindTab() {
			$('.tab-link').unbind("click").click(function () {
				sId = $(this).data("status");
				$(this).siblings().removeClass('active');
				$(this).addClass('active');
				// inited1:注销绑定滚动监听/无限加载事件/加载提示符
				$(document).off('infinite');
				$.detachInfiniteScroll($('.infinite-scroll'));
				$('.infinite-scroll-preloader').remove();
				// inited2: 重绘DOM元素
				$('#jobList').html('');
				$.refreshScroller();
				// inited3: 分页参数
				currPage = 1;
				hasClicked = true;
				getList(sId);
				regScroll();
                bindButton();
			});
		}

		function regScroll() {
			$('#payList_toPay').off('infinite').on('infinite', '.infinite-scroll-bottom', function() {
				$('.infinite-scroll-preloader').show();
			    if (loading) return;
			    loading = true;
			    setTimeout(function() {
			        if (maxItems <= (currPage-1) * pageSize) {
			            $.toast("没有其他项目啦~", 800);
			            $.detachInfiniteScroll($('.infinite-scroll'));
			            $('.infinite-scroll-preloader').hide();
			            return;
			        }
			        getList(sId);
			        $.refreshScroller();
			    }, 100);
			});     
		}

		function bindButton() {
			$('.bindBtnShowUserList').click(function () {
				hasClicked = true;
				// location.href = (sId === 1) ? APP_PATH + '/Company/Wallet/payUserList_toPay?jobId=' + $(this).data("id") :
				// APP_PATH + '/Company/Wallet/payUserList_paid?jobId=' + $(this).data("id");
				$.router.load((sId === 1) ? APP_PATH + '/Company/Wallet/payUserList_toPay?jobId=' + $(this).data("id") :
				APP_PATH + '/Company/Wallet/payUserList_paid?jobId=' + $(this).data("id"));
			});
			$('.jobLi').click(function () {
				hasClicked = true;
			});
		}

		function getList(sId) {
			var whichOne = (sId === 1) ? 'getUnpaidJobs' : 'getPaidJobs';
			$.ajax({
				url: APP_PATH + '/Company/JobPay/' + whichOne,
				type: 'POST',
				dataType: 'json',
				timeout: 3000,
				async: false,
				context: $('#jobList'),
				data: {
					currPage: currPage,
					pageSize: pageSize,
					companyId: companyId
				},
				success: function (res) {
					if (res.code === 1) {
						maxItems = res.data.total;
						if(maxItems <= 0) return false;
						var data = { "jobs": res.data.data };
						console.log(data);
						//电话咨询时“元/月”不显示
						for(var i = 0; i < data.jobs.length; i++){
						  	var num = /^[0-9,\.,\-,\+,\~]*$/;
						  	var income = data.jobs[i].income;
						  	var bool = num.test(income);
						  	if (!bool) {
						   	 	data.jobs[i].incomeUnit = '';
						  	}
						}

						$(this).append(template('tpl-payList', data));
						if(maxItems < pageSize) {
						    $('.infinite-scroll-preloader').hide();
						}
						loading = false;
						currPage++;
					} else {
						if (sId === 1) {
							$.toast("暂时没有要发放工资的项目哦~", 1000);
						} else {
							$.toast("您可能还没有发放过工资~", 1000);
						}
						$.detachInfiniteScroll($('.infinite-scroll'));
						$('.infinite-scroll-preloader').remove();
					}
				},
				error: function () {
					console.log("error!!!");
					server_error();
					$.detachInfiniteScroll($('.infinite-scroll'));
					$('.infinite-scroll-preloader').remove();
				}
			});
		}
	});

	$(document).on("pageInit", "#payUserList_paid", function(e, id, page) {
        console.log("inited", "payUserList_paid Page!");
        
        var pageSize = 10;
        var currPage = 1;
        var loading = false;
        var maxItems = 100;

        var search = location.search;
        var jobId = search.slice(search.indexOf("jobId=") + "jobId=".length);

        function addItems(isscroll) {
            $.ajax({
                type: 'POST',
                url: APP_PATH + '/Company/JobPay/getPaidUsers', 
                data: { 
                    "currPage": currPage, 
                    "pageSize": pageSize,
                    "jobId": jobId,
                    "companyId": ''
                },
                dataType: 'json',
                timeout: 3000,
                context: $('.payUserList_paid'),
                success: function(res){

                    if(res.code) {
                        maxItems = res.data.total;
                        if(maxItems <= 0){
                            $.toast("您还没有已发放工资的人啦！", 1000, "toast_orange");   
                            return false; 
                        }

                        var data = {"datas": res.data.data};
                        var html = template("tpl-payUserList_paid", data);
                        if (isscroll) {
                            this.append(html);
                        } else {
                            this.html(html);
                        }                 

                        if(maxItems < pageSize) {
                            $('.infinite-scroll-preloader').hide();
                        }
                        loading = false;
                        currPage ++;
                    } else {
                        $.toast("您还没有已发放工资的人啦！", 1000, "toast_orange");
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
        $("#payUserList_paid").off('infinite').on('infinite', '.infinite-scroll-bottom', function() {
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
                addItems(true);
                $.refreshScroller();
            }, 500);
        }); 

        addItems();

    });

    $(document).on("pageInit", "#payUserList_toPay", function(e, id, page) {
        console.log("inited", "payUserList_toPay Page!");
        
        // var pageSize = 10;
        // var currPage = 1;
        // var loading = false;
        // var maxItems = 100;
        var param = location.search;
        var jobId = param.slice("?jobId=".length);

        function addItems() {
            $.ajax({
                type: 'POST',
                url: APP_PATH+'/Company/JobPay/getUnpaidUsers',
                
                data: { 
                    // "currPage": currPage, 
                    // "pageSize": pageSize,
                    "jobId": jobId,
                    "companyId": ''

                },
                dataType: 'json',
                timeout: 3000,
                context: $('.payUserList_toPay'),
                success: function(res){
                    console.log(res);
                    if(res.code) {
                        // maxItems = res.data.total;
                        // if(maxItems <= 0){
                        //     $.toast("您还没有要发放工资的人啦！", 1000, "toast_orange");   
                        //     return false; 
                        // }

                        var data = {"datas": res.data.data};
                        var html = template("tpl-payUserList_toPay", data);
                        this.html(html);

                        // if(maxItems < pageSize) {
                        //     $('.infinite-scroll-preloader').hide();
                        // }
                        // loading = false;
                        // currPage ++;

                        //  新加全选按钮交互
                            $("#checkAll").click(function () {
                                if ($(this).is(":checked")) {
                                    $("input[name=items]").prop("checked", true);
                                } else {
                                    $("input[name=items]").prop("checked", false);
                                }
                            });
                        //  获取选中items的id
                            $("#btnPayUserList").click(function (){
                                if($("input[name='items']:checked").length == 0){
                                    $.toast('您还没有勾选要发放的人员信息', 1000);
                                }else{
                                    var sValue = '';
                                    $("input[name='items']:checked").each(function () {
                                        sValue += this.value +',';
                                    });
                                    var aValue = '';
                                    $("input[name='items']:checked").each(function () {
                                        
                                        aValue += this.dataset.applyid + ',';
                                    });
                                    // alert(sValue);
                                    setTimeout(function () {
                                        $.router.load(APP_PATH + "/Company/Wallet/payAmount?uIds="+ sValue + "&aIds=" + aValue + "&jobId=" + jobId);
                                    }, 100);
                                    
                                }
                            });

                    } else {
                        $.toast("该项目暂时没有要发放工资的人哦~", 1000);
                    }
                },
                error: function(xhr, type){
                    server_error();
                    // $.detachInfiniteScroll($('.infinite-scroll'));
                    // $('.infinite-scroll-preloader').remove();
                }
            });
        };

        // 注册'infinite'事件处理函数
        // $(document).on('infinite', '.infinite-scroll-bottom', function() {
        //     $('.infinite-scroll-preloader').show();
        //     if (loading) return;
        //     loading = true;
        //     setTimeout(function() {
        //         if (maxItems <= (currPage-1) * pageSize) {
        //             $.detachInfiniteScroll($('.infinite-scroll'));
        //             $.toast("(^_^) 木有更多信息啦！");
        //             $('.infinite-scroll-preloader').hide();
        //             return;
        //         }
        //         addItems(currPage, pageSize);
        //         $.refreshScroller();
        //     }, 500);
        // }); 

        addItems();

    });

	$(document).on("pageInit", "#recharge", function(e, id, page) {
        // console.log("inited", "recharge Page!");
        $('#btnRecharge').off('click').on('click', function () {
            var sVal = $('#rechargeVal').val();
            var reg = /^[0-9]*[1-9][0-9]*$/;
            if(sVal == '' || sVal == 'undefined' || !reg.test(sVal)){
                $.alert('输入金额不能为空或非正整数');
            }else{
                console.log(sVal);
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
                                   window.location.href = APP_PATH+"/Company/Wallet/myWallet.html"
                                }, 2000);
                            }else if(res.err_msg == "get_brand_wcpay_request:cancel"){
                                $.ajax({
                                    type: 'get',
                                    url: APP_PATH + '/Company/Wallet/cancelRecharge',
                                    data: {
                                        'orderId': orderId
                                    },
                                    dataType: 'json',
                                    async: false,
                                    success: function (res) {
                                        $.alert("取消成功!"); 
                                        setTimeout(function() {
                                           window.location.href = APP_PATH+"/Company/Wallet/myWallet.html"
                                        }, 2000);
                                    },
                                    error: function () {
                                        $.alert("取消失败!"); 
                                        setTimeout(function() {
                                           window.location.href = APP_PATH+"/Company/Wallet/myWallet.html"
                                        }, 2000);
                                    }  
                                });
                            }else{
                                $.alert("充值失败,请重新充值!");
                                // $.toast("充值失败!", 1000, "toast_orange");
                                setTimeout(function() {
                                   window.location.href = APP_PATH+"/Company/Wallet/myWallet.html"
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

                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: APP_PATH+'/Company/Wallet/confirmRecharge',
                    data: {
                        "payType": 0,
                        "amount": sVal
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
                
            }
            
        });

    });

    $(document).on("pageInit", "#reSetPwd", function() {
        console.log("inited page::", "reSetPwd!");
        // var wait = 60;
        var hasclicked = false;
        
        //预填充账户信息
        var getPhoneInfo = function () {
            $.ajax({
                type: 'GET',
                // url: '/Mockup/Wallet/getUserPhone.json',
                url: APP_PATH+'/Company/Wallet/getCompanyPhone',
                dataType: 'json',
                timeout: 3000,
                context: $('#phone'),
                success: function(res){
                    if(res.code) {
                        var phone = res.data.phone;
                        this.attr("value", phone).attr("disabled", "disabled");
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

        var bindGetCap = function () {
            $('#getCaptcha').click(function () {
                var wait = 60, self = $(this);
                var tel = $("#phone").val(); //获取手机号
                var verifyCode = $("#phonecaptcha").val();
                hasclicked = true;
                self.html(wait + '秒后重发');
                self.removeClass('repeat_send');
                self.addClass('bg-gray');
                self.off('click');
                $(".getCaptcha").attr("disabled","disabled");

                var time = function () {
                    if (wait === 0) {
                        wait = 60;
                        self.html('获取验证码');
                        self.addClass('repeat_send'); 
                        self.removeClass('bg-gray');
                        self.removeAttr("disabled");
                        bindGetCap();
                    } else {    
                        self.html(wait + '秒后重发');
                        setTimeout(time, 1000); wait--;
                    }
                };

                time();

                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: APP_PATH + '/Company/Tools/getCaptcha', 
                    data: {
                        "phone": tel,
                        "verifyCode": '',
                        "type": 3
                    },
                    success: function (res) {
                        if (res.code == 0) {
                            wait = 60;
                            self.addClass('repeat_send');
                            self.removeAttr("disabled");
                            return;
                        }else {
                            $.toast(res.msg, 1000);                           
                        }
                    },
                    error: function () {
                        $.toast("萝卜们太热情，服务器表示鸭梨很大！", 1000);
                    }
                });
            });
        };

        bindGetCap();

        //点击重置密码按钮的验证
        $("#nextStep").bind('click',function () {
            var smsCode = $("#phonecaptcha").val();
            var newPwd = $("#newPwd").val().trim();
            var reNewPwd = $("#reNewPwd").val().trim();
            var tel = $("#phone").val(); //获取手机号

            var telReg = !!tel.match(/^(0|86|17951)?(13[0-9]|15[0-9]|17[0-9]|18[0-9]|14[57])[0-9]{8}$/);//验证手机号
            
            var reg = /^\d{6}$/;   //6位纯数字

            if (!telReg) {
                $.toast("请输入正确格式的号码", 1000);   
                return false;    
            }else if (!reg.test(smsCode)) { 
                $.toast("请输入6位数字验证码", 1000);                 
                return false;
            }else if(!reg.test(newPwd)){ //验证为6位纯数字
                $.toast("密码必须为6位纯数字", 1000);  
                return false;
            }else if (newPwd != reNewPwd) {
                $.toast('(^_^) 新密码两次 输入不一致', 1000);
                return;
            }else if (!hasclicked) {
                $.toast("请获取验证码", 1000);
                return false;
            }else {
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: APP_PATH+'/Company/Wallet/resetPassword',
                    data: {
                        "phone": tel,
                        "captcha": smsCode,
                        "password": newPwd,
                        "confirm": reNewPwd
                    },
                    success: function (res) {
                        if (res.code === 1) {
                            $.toast("重置支付密码成功!", 800);
                            setTimeout(function() {
                               location.href = APP_PATH + '/Company/Wallet/myWallet';
                            }, 1000);
                        } else { //验证码的验证放在服务器端返回
                            $("#phonecaptcha").val('');
                            $.toast(res.msg, 1000);
                        }
                    },
                    error: function () {
                        server_error();
                    }
                });
            }
        });
    });
    

    // 绑定工作详情页
    $(document).on("pageInit", "#bizJobDetail", function(e, id, page) {

        var path = location.pathname;
        var jobId  = path.slice(path.lastIndexOf('/')+1);

        function loadDetail(jobId){

            $.ajax({
                type: 'POST',
                url:APP_PATH+ '/Company/Job/getJobDetails',
                data: {"id": jobId},
                dataType: 'json',
                timeout: 3000,
                context: $('#jobDetailScroll'),

                success: function(res){
                    if(res.code=='0'){
                        $.toast("(+﹏+) 找不到这个职位了", 1000, "toast_orange");
                        return;
                    } else {
                        var job= res.data;
                        console.log("job", job);

                        //电话咨询时“元/月”不显示
                        var num = /^[0-9,\.,\-,\+,\~]*$/;
                        var income = job.income;
                        var bool = num.test(income);
                        if(!bool){
                          job.incomeunit = '';
                        }
                        var html = template("job-detail-tpl", job);
                        this.html(html);   
                    }
            },
            error: function(xhr, type){
              console.log(xhr);
              console.log(type);
              $.toast("(+﹏+) 萝卜们太热情，服务器表示鸭梨很大！", 1000, "toast_orange");
            }
          });
        }

        loadDetail(jobId);
    });

	$.init();
});