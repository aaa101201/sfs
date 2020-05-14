'use strict';
var shopId = sessionStorage.getItem('shopId');
var OWNER_CONF = OWNER_CONF_ALL[shopId];
var userInfo = null;
var COUPON_STATUS = {
	"status": {
		"0": "已使用",
		"1": "未使用",
		"2": "已过期"
	},
	"img": {
		"0": "coupons_0.png", //已使用
		"1": "coupons_1.png", //未使用
		"2": "coupons_0.png" //已过期
	},
	"css": {
		"0": "z_unable",
		"1": "z_able",
		"2": "z_unable"
	}
};
//toolFun
var ToolFun = {
	isPhone: function isPhone(text) {
		//验证手机号格式
		return (/^((17[0-9])|(14[0-9])|(13[0-9])|(15[^4,\D])|(18[0-9]))\d{8}$/.test(text)
		);
	},
	isSMSCode: function isSMSCode(text) {
		//验证短信验证码格式
		return (/^[0-9]{6}$/.test(text)
		);
	},
	trimAll: function trimAll(str) {
		return str.replace(/\s*/g, "");
	},
	formatCardNo: function formatCardNo(str) {
		if (!str) return;
		//if(!/^[0-9]{15}$/.test(str)) return; //卡号15位
		var i = parseInt(str.length / 4),
			j = 0,
			res = '';
		for (; j < i; j++) {
			res += str.substring(j * 4, (j + 1) * 4);
			res += ' ';
		}
		if (str.length % 4 == 0) {
			res = res.substring(0, res.length - 1); //去除结尾空格
		} else {
			res += str.substring(i * 4, str.length);
		}
		return res;
	},
	formatMony: function formatMony(m) {
		if (!m) return;
		var money = Number(m);
		money = money.toFixed(2);
		money += '';
		var int = money.substring(0, money.indexOf(".")).replace(/\B(?=(?:\d{3})+$)/g, ','); //取到整数部分
		var dot = money.substring(money.length, money.indexOf(".")); //取到小数部分
		money = int + dot;
		return money;
	},
	getParamName: function getParamName(attr) {
		var match = RegExp('[?&]' + attr + '=([^&]*)').exec(window.location.search);
		return match && decodeURIComponent(match[1].replace(/\+/g, ' ')); //url中+号表示空格，要替换掉
	},
	getYearAndMonth: function getYearAndMonth(date) {
		if (!/^\d{4}\-\d{2}\-\d{2}\s\d{2}\:\d{2}\:\d{2}$/.test(date)) return; //数据格式2017-06-06 12:12:12
		var ymd = date.split(' ');
		var ymdArr = ymd[0].split('-');
		return {
			'year': ymdArr[0],
			'month': ymdArr[1],
			'dateMD': date.substring(5, date.length)
		};
	}
};
var fillTitle = function fillTitle(title) {
	$('h1.title').text(title);
};
var getUserInfo = function getUserInfo() {
	$.showIndicator();
	$.ajax({
		url: MOD_PATH + '/User/getUserInfo',
		async: false,
		success: function (res) {
			if (res.code == '0') {
				$.hideIndicator();
				userInfo = {
					"headimgurl": res.data.headimgurl,
					"realname": res.data.realname,
					"gender": res.data.gender || '1',
					"birthtype": res.data.birthtype || '1',
					"birthday": res.data.birthday,
					"phone": res.data.phone,
					"picUrl": OWNER_CONF.imgPath
				};
				userInfo.sex = userInfo.gender == "0" ? "女" : "男";
				sessionStorage.setItem('userInfoStrCopy', JSON.stringify(userInfo));
			} else {
				$.hideIndicator();
				$.toast(res.msg || "服务器繁忙~");
			}
		},
		error: function () {
			$.hideIndicator();
			server_error();
		}
	});
};
var editUserInfo = function editUserInfo() {
	$.showIndicator();
	$.ajax({
		url: MOD_PATH + '/User/editUserInfo',
		data: userInfo,
		success: function (res) {
			if (res.code == '0') {
				$.hideIndicator();
				$.toast("保存成功~");
				sessionStorage.setItem('userInfoStrCopy', JSON.stringify(userInfo));
				if ($('#save')) $('#save').addClass('btn_disable');
			} else {
				$.hideIndicator();
				$.toast(res.msg || "保存失败~");
			}
		},
		error: function () {
			$.hideIndicator();
			server_error();
		}
	});
};
/*index.html*/
(function () {
	$(document).on('pageInit', '#index', function (e, id, page) {
		fillTitle(OWNER_CONF.title.proName);
		var data = {
			logoIcon: OWNER_CONF.imgPath + 'pic_logo.png',
			phoneIcon: OWNER_CONF.imgPath + 'phone.png',
			passwordIcon: OWNER_CONF.imgPath + 'password.png'
		};
		var html = template('tpl-index', data);
		$('#indexDiv').html(html);

		//获取手机验证码
		var time = 30,
			intervalId = null;
		$('#btn_getCode').on('click', function () {

			var self = $(this);
			if (self.hasClass('btn_disable')) {
				return;
			}
			var phone = $('#phone').val().trim();
			if (!ToolFun.isPhone(phone)) {
				$.toast("手机号输入有误~");
				return;
			}
			self.addClass('btn_disable');

			//请求手机验证码接口
			$.ajax({
				url: MOD_PATH + '/User/sendSMSCode',
				data: {
					'phone': phone
				},
				success: function success(res) {
					if (res.code == '0') {
						$.toast("获取手机验证码成功~");
						intervalId = setInterval(refreshGetCaptcha, 1000);
					} else {
						self.removeClass('btn_disable');
						$.toast(res.msg || "获取手机验证码失败~");
					}
				},
				error: function error() {
					self.removeClass('btn_disable');
					server_error();
				}
			});
		});

		//计时器
		function refreshGetCaptcha() {
			var text = $("#btn_getCode .item-input");
			text.html(time + '秒后重发');
			time--;
			if (time < 0) {
				clearInterval(intervalId);
				$('#btn_getCode').removeClass('btn_disable');
				text.html("获取验证码");
				time = 30;
			}
		}

		//登录
		$('#doLogin').on('click', function () {

			var self = $(this);
			if (self.hasClass('btn_disable')) {
				return;
			}
			var phone = $('#phone').val().trim();
			if (!ToolFun.isPhone(phone)) {
				$.toast("手机号输入有误~");
				return;
			}
			var code = $('#code').val().trim();
			if (!ToolFun.isSMSCode(code)) {
				$.toast("验证码输入有误~");
				return;
			}

			self.addClass('btn_disable');
			$.showIndicator();
			//请求登录接口
			$.ajax({
				url: MOD_PATH + '/User/signIn',
				data: {
					'phone': phone,
					'code': code
				},
				success: function success(res) {
					if (res.code == '0') {
						$.hideIndicator();
						$.toast("登录成功~");
						self.removeClass('btn_disable');
						setTimeout(function () {
							$.router.load(APP_PATH + '/Home/User/userCenter', true);
						}, 2000);
					} else {
						$.hideIndicator();
						$.toast(res.msg || "登录失败~");
						self.removeClass('btn_disable');
					}
				},
				error: function error() {
					$.hideIndicator();
					server_error();
					self.removeClass('btn_disable');
				}
			});
		});
	});
})();
/*userCenter.html*/
(function () {
	$(document).on('pageInit', '#userCenter', function (e, id, page) {
		fillTitle(OWNER_CONF.title.proName);
		//请求接口，获取用户信息卡号、余额、积分等数据
		$.showIndicator();
		var data = {
			imgArr: {
				cardIcon: OWNER_CONF.imgPath + 'pic_card.png',
				listIcon_01: OWNER_CONF.imgPath + 'pic_001.png',
				listIcon_02: OWNER_CONF.imgPath + 'pic_002.png',
				listIcon_03: OWNER_CONF.imgPath + 'pic_003.png',
				listIcon_04: OWNER_CONF.imgPath + 'pic_004.png',
				listIcon_05: OWNER_CONF.imgPath + 'pic_005.png'
			},
			cardType: OWNER_CONF.cardType
		};
		$.ajax({
			url: MOD_PATH + '/User/getUserCardInfo',
			success: function (res) {
				if (res.code == '0') {
					$.hideIndicator();
					data.cardNum = ToolFun.formatCardNo(ToolFun.trimAll(res.data.cardno));
					data.cardNumNaN = "**** **** **** ***";
					data.realname = res.data.realname || '会员';
					data.levelName = res.data.levelname;
					data.balance = ToolFun.formatMony(res.data.balance);
					data.score = res.data.point;
					var html = template('tpl-userCenter', data);
					$('#userCenterDiv').html(html);
				} else {
					$.hideIndicator();
					$.toast(res.msg || "服务器繁忙~");
				}
			},
			error: function () {
				$.hideIndicator();
				server_error();
			}
		});
	});
})();
/*expendList.html*/
(function () {
	$(document).on('pageInit', '#expendList', function (e, id, page) {
		$('.infinite-scroll-preloader').hide();

		var loading = false, pageSize = 10, currPage = 1, maxItems;
		$('#expendListDiv').html(' ');

		$(document).on("infinite", ".infinite-scroll-bottom", function () {
			if (loading) return;
			loading = true;
			setTimeout(function () {
				if (maxItems <= (currPage - 1) * pageSize) {
					// 加载完毕，则注销无限加载事件，以防不必要的加载
					$.detachInfiniteScroll($('.infinite-scroll'));
					// 删除加载提示符
					$('.infinite-scroll-preloader').remove();
					return;
				}
				getData();
				$.refreshScroller();
			}, 500);
		});
		/**
		 * 请求数据
		 */
		function getData() {
			//$.showIndicator();
			$.ajax({
				url: MOD_PATH + '/Index/consumeRecord',
				data: {
					start: currPage,
					pagesize: pageSize
				},
				success: function success(res) {
					$.hideIndicator();
					if (res.code == '0') {
						var data = res.data;
						maxItems = res.total;
						drawList(data);
						loading = false;
						currPage++;
						if (maxItems <= pageSize) {
							// 加载完毕，则注销无限加载事件，以防不必要的加载
							$.detachInfiniteScroll($('.infinite-scroll'));
							// 删除加载提示符
							$('.infinite-scroll-preloader').remove();
						}
					} else {
						$.toast("您还没有消费信息~");
					}
				},
				error: function error() {
					$.hideIndicator();
					server_error();
				},
				complete: function () {
					$.hideIndicator();
					$('.infinite-scroll-preloader').hide();
				}
			});
		}

		/**
		 * 渲染列表数据
		 */
		function drawList(data) {
			data.forEach(function (item) {
				item.listIcon = item.type == "1" ? OWNER_CONF.imgPath + 'pic_expend.png' : OWNER_CONF.imgPath + 'pic_recharge.png';
				item.amount = item.type == "1" ? '-' + item.amount : '+' + item.amount;
				// item.typeName = item.type == "1" ? "消费" : "充值";
				// 0 充值
				// 1 消费
				// 2 充值赠送
				if (item.type === '0')
					item.typeName = '充值';
				else if (item.type === '1')
					item.typeName = '消费';
				else if (item.type === '2')
					item.typeName = '充值赠送';

				var res = ToolFun.getYearAndMonth(item.createtime);
				var year = res.year,
					month = res.month;
				item.date = res.dateMD;
				//列表分月显示处理
				if ($('#' + year + month).length) {
					$('#' + year + month).append(template('tpl-expendList', item));
				} else {
					var _id = year + month,
						text = void 0;
					if (new Date().getFullYear() == year) {
						if (new Date().getMonth() + 1 == parseInt(month)) {
							text = "本月";
						} else {
							text = month + "月";
						}
					} else {
						text = year + '年' + month + "月";
					}
					var html = '<ul id="' + _id + '"><p class="z_month">' + text + '</p></ul>';
					$('#expendListDiv').append(html);
					$('#' + year + month).append(template('tpl-expendList', item));
				}
			});
		};
		getData();
	});
})();
/*scoreList.html*/
(function () {
	$(document).on('pageInit', '#scoreList', function (e, id, page) {
		$('.infinite-scroll-preloader').hide();

		$('#exchangeGift').on('click', function () {
			$.alert("\"积分商城\" 敬请期待");
		});
		var loading = false, pageSize = 10, currPage = 1, maxItems;
		$('#scoreListDiv').html(' ');
		$(document).on("infinite", ".infinite-scroll-bottom", function () {
			if (loading) return;
			loading = true;
			setTimeout(function () {
				if (maxItems <= (currPage - 1) * pageSize) {
					// 加载完毕，则注销无限加载事件，以防不必要的加载
					$.detachInfiniteScroll($('.infinite-scroll'));
					// 删除加载提示符
					$('.infinite-scroll-preloader').remove();
					return;
				}
				getData();
				$.refreshScroller();
			}, 500);
		});
		/**
		 * 请求数据
		 */
		function getData() {
			$.showIndicator();
			$.ajax({
				url: MOD_PATH + '/Index/pointRecord',
				data: {
					start: currPage,
					pagesize: pageSize
				},
				success: function success(res) {
					$.hideIndicator();
					if (res.code == '0') {
						var score = res.pointtotal || '0';
						var d_score = ToolFun.formatMony(score);
						d_score = d_score.substring(0, d_score.length - 3);
						$('#score').html(d_score + '分');
						var data = res.data;
						maxItems = res.total;
						drawList(data);
						loading = false;
						currPage++;
						if (maxItems <= pageSize) {
							// 加载完毕，则注销无限加载事件，以防不必要的加载
							$.detachInfiniteScroll($('.infinite-scroll'));
							// 删除加载提示符
							$('.infinite-scroll-preloader').remove();
						}
					} else {
						$('#score').html('0 分');
						$.toast("你还没有积分信息~");
					}
				},
				error: function error() {
					$.hideIndicator();
					server_error();
				},
				complete: function () {
					$.hideIndicator();
					$('.infinite-scroll-preloader').hide();
				}
			});
		}

		/**
		 * 渲染列表数据
		 */
		function drawList(data) {
			data.forEach(function (item) {
				item.listIcon = item.type == "1" ? OWNER_CONF.imgPath + 'scoreAdd.png' : OWNER_CONF.imgPath + 'scoreReduce.png';
				item.amount = item.type == "1" ? '+' + item.amount : '-' + item.amount;
				item.typeName = item.type == "1" ? "消费赠送" : "商城兑换礼品";

				var res = ToolFun.getYearAndMonth(item.createtime);
				var year = res.year,
					month = res.month;
				item.date = res.dateMD;
				//列表分月显示处理
				if ($('#' + year + month).length) {
					$('#' + year + month).append(template('tpl-scoreList', item));
				} else {
					var _id2 = year + month,
						text = void 0;
					if (new Date().getFullYear() == year) {
						if (new Date().getMonth() + 1 == parseInt(month)) {
							text = "本月";
						} else {
							text = month + "月";
						}
					} else {
						text = year + '年' + month + "月";
					}
					var html = '<ul id="' + _id2 + '"><p class="z_month">' + text + '</p></ul>';
					$('#scoreListDiv').append(html);
					$('#' + year + month).append(template('tpl-scoreList', item));
				}
			});
		};
		getData();
	});
})();
/*userInfo.html*/
(function () {
	$(document).on('pageInit', '#userInfo', function (e, id, page) {
		getUserInfo();
		var html = template('tpl-userInfo', userInfo);
		$('#userInfoDiv').html(html);
		//生日选择器
		if (!!userInfo.birthday) {
			var y = userInfo.birthday.substring(0, 4),
				m = userInfo.birthday.substring(5, 7),
				d = userInfo.birthday.substring(8);
			$("#birthday").datetimePicker({
				value: [y, m, d, '0', '00']
			});
		} else {
			$("#birthday").datetimePicker({
				value: ['1980', '01', '01', '0', '00']
			});
		}

		//性别选择器
		$("#sex").picker({
			toolbarTemplate: '<header class="bar bar-nav"><button class="button button-link pull-right close-picker">\u786E\u5B9A</button></header>',
			cols: [{
				textAlign: 'center',
				values: ['男', '女']
			}]
		});
		//阴历阳历切换
		$(document).on('click', '.z_radio', function () {
			$('.z_radio').children('img').attr('src', OWNER_CONF.imgPath + 'i_radioUn.png');
			$(this).children('img').attr('src', OWNER_CONF.imgPath + 'i_radio.png');

			userInfo.birthtype = $(this).data('btype');
			sessionStorage.setItem('userInfo', JSON.stringify(userInfo));
			compareInfo();
		});
		//保存信息修改
		$('#save').on('click', function () {
			if ($(this).hasClass('btn_disable')) return;
			editUserInfo();
		});
		$('#sex').on('change', function () {
			userInfo.gender = $(this).val() == "男" ? "1" : "0";
			sessionStorage.setItem('userInfo', JSON.stringify(userInfo));
			compareInfo();
		});
		$('#birthday').on('change', function () {
			userInfo.birthday = $(this).val().substring(0, 10);
			sessionStorage.setItem('userInfo', JSON.stringify(userInfo));
			compareInfo();
		});
		function compareInfo() {
			var bool = sessionStorage.getItem('userInfoStr') == sessionStorage.getItem('userInfoStrCopy');
			if (!bool) $('#save').removeClass('btn_disable');
		}
	});
})();
/*dealPage.html*/
(function () {
	$(document).on('pageInit', '#dealName', function (e, id, page) {
		getUserInfo();
		$('#name').val(userInfo.realname);
		$('#saveName').on('click', function () {
			if (!$('#name').val() || $('#name').val().length > 4) {
				$.toast('姓名不能为空,且4个字符以内~');
				return;
			}
			if ($('#name').val() === userInfo.realname) {
				$.toast('您没有修改呢~');
				return;
			} else {
				userInfo.realname = $('#name').val();
				editUserInfo();
				setTimeout(function () {
					location.href = 'userInfo';
				}, 1500);
			}
		});
	});
})();
/*dealPhoto.html*/
(function () {
	$(document).on('pageInit', '#dealPhoto', function (e, id, page) {
		getUserInfo();
		$("#photo").attr("src", userInfo.headimgurl);
		$(document).off('click').on('click', '#choosePhoto', function () {
			var ua = navigator.userAgent.toLowerCase();
			if (/iphone|ipad|ipod/.test(ua)) {
				$('#uploadImg').click().click();
			} else {
				$('#uploadImg').trigger('click');
			}
		});
		$(document).on('change', '#uploadImg', function (e) {
			$.showIndicator();
			var Orientation;
			EXIF.getData($('#uploadImg')[0].files[0], function () {
				Orientation = EXIF.getTag(this, 'Orientation'); //获取图像拍摄方向
			});
			var reader = new FileReader(); //通过 FileReader 读取blob类型
			reader.readAsDataURL($('#uploadImg')[0].files[0]);
			reader.onload = function (e) {
				new CLIPIMG(reader.result, Orientation);
				setTimeout(function () {
					$('html').addClass('clipHtml').find('.page-group').hide();
					$('#clipImg').click();
				}, 500);
			};
		});
	});
})();
/*rules.html*/
(function () {
	$(document).on('pageInit', '#rules', function (e, id, page) {
		$('img.z_ruleIcon').attr('src', OWNER_CONF.imgPath + 'rules.png');
		$.ajax({
			url: MOD_PATH + '/Index/levelRule',
			dataType: 'json',
			success: function success(res) {
				if (res.code == '0' && res.data.length) {
					var data = {
						data: res.data,
						picUrl: OWNER_CONF.imgPath
					};
					$('#levelRule').html(template('tpl-levelRule', {"data": data})).removeClass('z_hide');
				}
			},
			error: function error() {
				server_error();
			}
		});
		$.ajax({
			url: MOD_PATH + '/Index/rechargeRule',
			dataType: 'json',
			success: function success(res) {
				if (res.code == '0' && res.data.length) {
					var data = {
						data: res.data,
						picUrl: OWNER_CONF.imgPath
					};
					$('#rechargeRule').html(template('tpl-rechargeRule', {"data": data})).removeClass('z_hide');
				}
			},
			error: function error() {
				server_error();
			}
		});
		$.ajax({
			//url: MOD_PATH + '/Index/levelPoint',
			url: 'http://bewin.yingfankeji.net/index.php/Home/Index/levelPoint',
			dataType: 'json',
			success: function (res) {
				//$.alert(res.tostring())
				if (res.code == '0' && res.data.length) {
					var data = {
						data: res.data,
						picUrl: OWNER_CONF.imgPath
					};
					$('#pointRule').html(template('tpl-pointRule', {"data": data})).removeClass('z_hide');
				}
			},
			error: function () {
				//$.alert(MOD_PATH + '/Index/levelPoint');
				server_error();
			}
		});
	});
})();
/*coupons.html*/
(function () {
	$(document).on('pageInit', '#coupons', function (e, id, page) {
		//$.showIndicator();
		$('.couponsList').empty();
		$.ajax({
			url: '/Public/wechat/data/coupons.json',
			dataType: 'text',
			success: function success(res) {
				res = JSON.parse(res);
				if (res.code == '0') {
					$.hideIndicator();
					var data = res.data;
					drawList(data);
				} else {
					$.hideIndicator();
					$.toast(res.msg || "服务器繁忙~");
				}
			},
			error: function error() {
				$.hideIndicator();
				server_error();
			}
		});
		/**
		 * 渲染列表数据
		 */
		function drawList(data) {
			data.forEach(function (item) {
				item.statusName = COUPON_STATUS.status[item.status];
				item.img = OWNER_CONF.imgPath + COUPON_STATUS.img[item.status];
				item.css = COUPON_STATUS.css[item.status];
				var res = ToolFun.formatMony(item.amount);
				item.amount = res.substring(0, res.length - 3);
			});
			$('.couponsList').html(template('tpl-coupons', {"data": data}));
		}
	});
})();
$.init();

var CLIPIMG = function (imgUrl, Orientation) {
	this.img = imgUrl;
	this.uploadApi = MOD_PATH + '/File/upload';
	this.clipImgOpt = {
		pattern: 'clipping',
		selector: '#clipImg',
		clippingWidth: 400,
		clippingHeight: 400,
		clippingRadius: 0,
		clippingBackground: '',
		clippingImportSuffix: 'jpge',
		// Orientation: Orientation
		Orientation: 1
	};
	this.init();
};
CLIPIMG.prototype = {
	init: function () {
		this.beforeClip();
		this.showClipWin();
		this.afterClip();
	},
	beforeClip: function () {
		$("#clipImg").attr('src', this.img);
	},
	showClipWin: function () {
		var self = this;
		$('#dealPhoto').on('click', '#clipImg', function () {
			ImageView.show(self.clipImgOpt);
			self.dealClipWinBtn();
			$.hideIndicator();
		});
	},
	dealClipWinBtn: function () {
		var self = this;
		$('div.iv_closebtn').remove();
		$('.iv_head').prepend('<div class="iv_closebtn"><div class="iv_lArrow"><i></i></div></div>');
		$('div.iv_closebtn').off('click').on('click', function () {
			ImageView.restore();
			$('html').removeClass('clipHtml').find('.page-group').show();
		});
	},
	afterClip: function () {
		var self = this;
		ImageView.on('clipping', function (data) {
			$.showIndicator();
			$('html').removeClass('clipHtml').find('.page-group').show();
			self.sumitImageFile(self.uploadApi, data);
		});
	},
	sumitImageFile: function (url, base64Codes) {
		var self = this,
			fd = null,
			bool = this.needsFormDataShim();

		if (bool) {
			fd = this.FormDataShim();
		} else {
			fd = new FormData();
		}

		var file = this.dataURLtoBlob(base64Codes);
		fd.append('file', file, 'picture.png');
		$.ajax({
			url: url,
			type: "POST",
			data: fd,
			dataType: "text",
			processData: false, // 告诉jQuery不要去处理发送的数据
			contentType: false, //告诉jQuery不要去设置Content-Type请求头
			success: function (res) {
				res = JSON.parse(res);
				userInfo.headimgurl = res.CDNPath;
				$('html').removeClass('.clipHtml').find('.page-group').show();
				$.hideIndicator();
				editUserInfo();
				setTimeout(function () {
					location.reload();
				}, 500);
			},
			error: function () {
				$('html').removeClass('.clipHtml').find('.page-group').show();
				$.hideIndicator();
				location.reload();
			}
		});
	},
	dataURLtoBlob: function (data) {
		var tmp = data.split(',');
		tmp[1] = tmp[1].replace(/\s/g, '');
		var binary = atob(tmp[1]);
		var array = [];
		for (var i = 0; i < binary.length; i++) {
			array.push(binary.charCodeAt(i));
		}
		return this.newBlob(new Uint8Array(array), 'image/jpeg');
	},
	newBlob: function (data, datatype) {
		var out;
		try {
			out = new Blob([data], {
				type: datatype
			});
		} catch (e) {
			window.BlobBuilder = window.BlobBuilder ||
				window.WebKitBlobBuilder ||
				window.MozBlobBuilder ||
				window.MSBlobBuilder;

			if (e.name == 'TypeError' && window.BlobBuilder) {
				var bb = new BlobBuilder();
				bb.append(data.buffer);
				out = bb.getBlob(datatype);
			} else if (e.name == "InvalidStateError") {
				out = new Blob([data], {
					type: datatype
				});
			} else {
			}
		}
		return out;
	},
	FormDataShim: function () {
		// Store a reference to this
		var self = this,
			parts = [], // Data to be sent
			boundary = Array(5).join('-') + (+new Date() * (1e16 * Math.random())).toString(32),
			oldSend = XMLHttpRequest.prototype.send;

		this.append = function (name, value, filename) {
			parts.push('--' + boundary + '\r\nContent-Disposition: form-data; name="' + name + '"');

			if (value instanceof Blob) {
				parts.push('; filename="' + (filename || 'blob') + '"\r\nContent-Type: ' + value.type + '\r\n\r\n');
				parts.push(value);
			} else {
				parts.push('\r\n\r\n' + value);
			}
			parts.push('\r\n');
		};

		// Override XHR send()
		XMLHttpRequest.prototype.send = function (val) {
			var fr,
				data,
				oXHR = this;

			if (val === this) {
				//注意不能漏最后的\r\n ,否则有可能服务器解析不到参数.
				parts.push('--' + boundary + '--\r\n');
				data = self.XBlob(parts);
				fr = new FileReader();
				fr.onload = function () {
					oldSend.call(oXHR, fr.result);
				};
				fr.onerror = function (err) {
					throw err;
				};
				fr.readAsArrayBuffer(data);

				this.setRequestHeader('Content-Type', 'multipart/form-data; boundary=' + boundary);
				XMLHttpRequest.prototype.send = oldSend;
			} else {
				oldSend.call(this, val);
			}
		};
	},
	needsFormDataShim: function () {
		var bCheck = ~navigator.userAgent.indexOf('Android') &&
			~navigator.vendor.indexOf('Google') &&
			!~navigator.userAgent.indexOf('Chrome');
		return bCheck && navigator.userAgent.match(/AppleWebKit\/(\d+)/).pop() <= 534;
	},
	blobConstruct: function () {
		try {
			return new Blob();
		} catch (e) {
		}
	},
	XBlob: function () {
		var bool = this.blobConstruct();
		if (bool) {
			return window.Blob;
		} else {
			return function (parts, opts) {
				var bb = new (window.BlobBuilder || window.WebKitBlobBuilder || window.MSBlobBuilder);
				parts.forEach(function (p) {
					bb.append(p);
				});
				return bb.getBlob(opts ? opts.type : undefined);
			};
		}
	}
};
