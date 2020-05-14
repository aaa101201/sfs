<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html class="no-js fixed-layout">
<head>
	<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<meta name="description" content="微会员">
<meta name="keywords" content="index">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="renderer" content="webkit">
<meta http-equiv="Cache-Control" content="no-siteapp" />
<meta name="apple-mobile-web-app-title" content="盈帆科技" />

	<title>惠盈联盟</title>
	<link rel="icon" type="image/png" href="/Public/images/icon/favicon.png">
<link rel="apple-touch-icon-precomposed" href="/Public/images/icon/app-icon72x72@2x.png">

<link rel="stylesheet" href="/Public/styles/amazeui.css">
<link rel="stylesheet" href="/Public/styles/amazeui.datetimepicker.css">
<link rel="stylesheet" href="/Public/styles/amazeui.datatables.css">
<link rel="stylesheet" href="/Public/styles/admin.css">
<style>
	/*input number step disable*/
	input[type=number]::-webkit-inner-spin-button,
	input[type=number]::-webkit-outer-spin-button {
		-webkit-appearance: none;
		margin: 0;
	}
</style>

<script>
	var ROOT = "";
	var APP_PATH = "/index.php";
	var MOD_PATH = "/index.php/Admin";
	var CON_PATH = "/index.php/Admin/Index";
</script>


<script>
	var log = console.log.bind(console); // !!!
	function getCookie(key) {
		var cookie = document.cookie, cookies, result;
		if (cookie.length > 0) {
			cookies = cookie.split(/\s*;\s*/);
			cookies.forEach(function (cookie) {
				var arr = cookie.split('=');
				if (arr.length > 1) {
					if (arr[0] === key) {
						result = arr[1];
					}
				}
			});
			return result;
		}
	}
	function setCookie(c_name, value, expiredays) {
		var exdate = new Date();
		exdate.setDate(exdate.getDate() + expiredays);
		document.cookie = c_name + "=" + escape(value) + ((expiredays == null) ? "" : ";expires=" + exdate.toGMTString() + ';path=/');
	}
</script>
	<!-- alert提示框 -->

<div id="modal-append-after"></div>

<div class="am-modal am-modal-alert" tabindex="-1" id="modal-alert">
	<div class="am-modal-dialog">
		<div class="am-modal-hd">微会员系统</div>
		<div class="am-modal-bd"></div>
		<div class="am-modal-footer">
			<span class="am-modal-btn" data-am-modal-confirm>确定</span>
		</div>
	</div>
</div>


<!-- confirm提示框 -->
<div class="am-modal am-modal-confirm" tabindex="-1" id="modal-confirm">
	<div class="am-modal-dialog">
		<div class="am-modal-hd">微会员系统</div>
		<div class="am-modal-bd">
		</div>
		<div class="am-modal-footer">
			<span class="am-modal-btn" data-am-modal-cancel>取消</span>
			<span class="am-modal-btn" data-am-modal-confirm>确定</span>
		</div>
	</div>
</div>

<div class="am-modal am-modal-prompt" tabindex="-1" id="modal-prompt">
	<div class="am-modal-dialog">
		<div class="am-modal-hd">微会员系统</div>
		<div class="am-modal-bd">
			<input type="text" class="am-modal-prompt-input">
		</div>
		<div class="am-modal-footer">
			<span class="am-modal-btn" data-am-modal-cancel>取消</span>
			<span class="am-modal-btn" data-am-modal-confirm>提交</span>
		</div>
	</div>
</div>
<script type="text/javascript">
	function modal_alert(text, callback) {
		var clone = $('#modal-alert').clone();
		$('#modal-alert').remove();
		$('#modal-append-after').after(clone);
		$('#modal-alert .am-modal-bd').html(text);
		$('#modal-alert').modal({
			onConfirm: callback
		});
	}

	function modal_confirm(text, callback) {
		var clone = $('#modal-confirm').clone();
		$('#modal-confirm').remove();
		$('#modal-append-after').after(clone);
		$('#modal-confirm .am-modal-bd').html(text);
		$('#modal-confirm').modal({
			onConfirm: callback
		});
	}

	function modal_prompt(text, callback) {
		$('#modal-prompt .am-modal-hd').html(text);
		$('#modal-prompt').modal({
			relatedTarget: this,
			onConfirm: callback
		});
	}
</script>

	<script src="/Public/scripts/libs/jquery.js"></script>
<script src="/Public/scripts/libs/amazeui.js"></script>
<script src="/Public/scripts/libs/amazeui.datetimepicker.min.js"></script>
<script src="/Public/scripts/libs/webuploader.js"></script>
<script src="/Public/scripts/libs/amazeui.datatables.js"></script>
<script src="/Public/scripts/libs/template.js"></script>
<script src="/Public/scripts/libs/jquery.scrollTo.min.js"></script>
<script src="/Public/scripts/libs/echarts.js"></script>

<script src="/Public/scripts/app.js"></script>
<script src="/Public/scripts/tools.js"></script>
<script src="/Public/scripts/enum.js"></script>

<script>
	(function () {
		var easeInOut = function (t, b, c, d) {
			if ((t /= d / 2) < 1) return c / 2 * t * t * t + b;
			return c / 2 * ((t -= 2) * t * t + 2) + b;
		};
		var getElementTop = function (element) {
			var actualTop = element.offsetTop, current = element.offsetParent;

			while (current !== null) {
				actualTop += current.offsetTop;
				current = current.offsetParent;
			}

			return Number.parseInt(actualTop);
		};
		var getScrollTop = function (elem) {
			var elementScrollTop = null;
			if (elem) {
				elementScrollTop = elem.scrollTop;
			} else {
				if (document.compatMode == "BackCompat") {
					elementScrollTop = document.body.scrollTop;
				} else {
					elementScrollTop = document.documentElement.scrollTop;
				}
			}

			return Number.parseInt(elementScrollTop);
		};
		var setScrollTop = function (elem, val) {
			if (val == null) {
				val = elem;
				elem = null;
			}
			if (elem) {
				elem.scrollTop = val;
			} else {
				if (document.compatMode == "BackCompat") {
					document.body.scrollTop = val;
				} else {
					document.documentElement.scrollTop = val;
				}
			}
		};

		window.scrollToForm = function () {
			var start = 0, duration = 50, toSet = null, top = null, elem = document.getElementById('xAdmin-tab'),
				wrap = document.querySelector('.admin-content'), top = getScrollTop(wrap);
			var _run = function () {
				start += 1;
				toSet = easeInOut(start, top, Math.min(getElementTop(elem) - top - 100, wrap.scrollHeight - wrap.clientHeight), duration);
				setScrollTop(wrap, toSet);
				if (start < duration) requestAnimationFrame(_run);
			};
			_run();
		};
	})();
</script>

<!--set name after login-->
<script>
	$(function () {
		$('#user_login_name').html(' ' + getCookie('username'));
	});
</script>

<style>
	.mask1 {
		position: fixed;
		z-index: 1100;
		width: 100%;
		height: 100%;
		background-color: rgba(0, 0, 0, .3);
		display: none;
	}
</style>

<div class="mask1"></div>

	<script id="menu-tpl" type="text/html">
    {{each menus as menu i}}
        {{if menu.weight == 1 || menu.weight == 2}}
            <li>
                <a href="/index.php/{{#menu.url}}">
                    {{ if menu.weight == 1 }}
                    <span class="am-icon-{{menu.icon}} am-icon-sm"></span> {{#menu.name}}
                    {{ else }}
                    <span class="am-icon-{{menu.icon}}"></span> {{#menu.name}}
                    {{ /if }}
                </a>
            </li>
        {{/if}}
        {{if menu.weight != 1 && menu.weight != 2}}
            <li>
                <a class="am-cf" data-am-collapse="{target: '#collapse-{{#menu.name}}-nav'}">
                    <span class="am-icon-{{menu.icon}}"></span> {{#menu.name}}
                    <span class="am-icon-angle-right am-fr am-margin-right"></span>
                </a>
                {{if menu.menus}}
                    <ul class="am-list am-collapse admin-sidebar-sub" id="collapse-{{#menu.name}}-nav">
                        {{each menu.menus as cMenu i}}
                        <li>
                            <a href="/index.php/{{#cMenu.url}}" class="am-cf">
                                <span class="am-icon-{{cMenu.icon}} {{cMenu.pending?'icon-pending':''}}"></span> <span class="{{cMenu.pending?'icon-pending':''}}">{{#cMenu.name}}</span>
                                <span class="am-badge am-badge-secondary am-margin-right am-fr"></span>
                            </a>
                        </li>
                        {{/each}}
                    </ul>
                {{/if}}
            </li>
        {{/if}}
    {{/each}}
</script>

<script id="select-tpl" type="text/html">
	{{each data as value index}}
	    <option value={{value.value}} {{value.value == value.optionId ? "selected" : ""}}>{{value.name}}</option>
	{{/each}}
</script>

<script id="voteItem-tpl" type="text/html">
    <li class="am-g">
        <div class="am-u-sm-4 am-u-md-2 am-text-center">
            <input type="text" class="itemTitle" value="" placeholder="">
        </div>
        <div class="am-u-sm-4 am-u-md-1 am-text-center">
            <input type="text" class="itemPhone" value="" placeholder="">
        </div>
        <div class="am-u-sm-4 am-u-md-1 am-text-center">
            <input type="number" class="itemWeight" value="" placeholder="" min="0" step="1">
        </div>
        <div class="am-u-sm-4 am-u-md-4 am-text-center">
            <input type="text" class="itemIntro" value="" placeholder="">
        </div>
        <div class="am-u-sm-4 am-u-md-2 am-text-center" style="position: relative;">
            <input type="text" class="itemImg" value="" placeholder="" readonly="readonly">
            <button type="button" class="am-btn am-btn-default upBtn">上传</button>
        </div>
        <div class="am-u-sm-4 am-u-md-2 am-text-center">
            <button type="button" class="am-btn am-btn-danger removeItem">删除</button>
        </div>
    </li>
</script>

<script id="vote-p_admin-x-table-opt-tpl" type="text/html">
    <div class="am-btn-toolbar">
        <div class="am-btn-group am-btn-group-xs">

            <button type="button" action="seeDetail" class="am-btn am-btn-default am-btn-xs tc_look">
                <span class="am-icon-copy"></span>查看
            </button>

            {{if status==1}}
            <button type="button" action="pause" class="am-btn am-btn-default am-btn-xs am-text-danger tc_ban">
                <span class="am-icon-copy"></span>暂停
            </button>
            {{else if status==2}}
            <button type="button" action="active" class="am-btn am-btn-default am-btn-xs am-text-primary tc_start">
                <span class="am-icon-copy"></span>继续
            </button>
            {{/if}}
            {{if status==0}}
            <button type="button" action="" class="am-btn am-btn-default am-btn-xs tc_ban">
                <span class="am-icon-copy"></span>已结束
            </button>
            {{else}}
            <button type="button" action="over" class="am-btn am-btn-default am-btn-xs tc_look">
                <span class="am-icon-copy"></span>结束
            </button>
            <button type="button" action="getVoteURL" class="am-btn am-btn-default am-btn-xs tc_look">
                <span class="am-icon-copy"></span>获取投票地址
            </button>
            {{/if}}
        </div>
    </div>
</script>
<script id="vote-p_admin-y-table-opt-tpl" type="text/html">
    <div class="am-btn-toolbar">
        <div class="am-btn-group am-btn-group-xs">

            <button type="button" action="showItem" class="am-btn am-btn-default am-btn-xs am-hide-sm-only tc_look">
                <span class="am-icon-copy"></span> 查看
            </button>
            {{if status==0}}
            <button type="button" action="passItem" class="am-btn am-btn-default am-btn-xs am-hide-sm-only tc_ban">
                <span class="am-icon-copy"></span> 通过
            </button>
            {{else}}
            <button type="button" action="pauseItem" class="am-btn am-btn-default am-btn-xs am-hide-sm-only tc_look">
                <span class="am-icon-copy"></span> 禁用
            </button>
            {{/if}}
        </div>
    </div>
</script>

<script type="text/html" id="tpl-baseInfo">
    <form class="am-form">
        <!-- <div class="am-g am-margin-top">
            <div class="am-u-sm-4 am-u-md-2 am-text-right">企业</div>
            <div class="am-u-sm-4 am-u-md-9 am-u-end">
                <input type="text" class=""  value="" id="company">
            </div>
        </div> -->
        <div class="am-g am-margin-top">
            <div class="am-u-sm-4 am-u-md-2 am-text-right">投票标题</div>
            <div class="am-u-sm-4 am-u-md-9 am-u-end">
                <input type="text" class="" value="{{title}}" placeholder="输入投票标题" id="title">
            </div>
        </div>
        <div class="am-g am-margin-top">
            <div class="am-u-sm-4 am-u-md-2 am-text-right">活动时间</div>
            <div class="am-u-sm-4 am-u-md-9 am-u-end">
                <div class="am-u-sm-12 am-u-md-3" style="padding-left: 0px;">
                    <div class="am-form-group am-form-icon" style="margin-bottom: 0px;">
                        <i class="am-icon-calendar"></i> <input id="startDate"
                                                                class="am-form-field am-input-sm" placeholder="&nbsp;&nbsp;&nbsp;开始日期" value="{{begintime}}">
                    </div>
                </div>
                <div class="am-u-sm-12 am-u-md-3" style="padding-right: 0px;">
                    <div class="am-form-group am-form-icon" style="margin-bottom: 0px;">
                        <i class="am-icon-calendar"></i> <input id="endDate" type="text"
                                                                class="am-form-field am-input-sm" placeholder="&nbsp;&nbsp;&nbsp;结束日期" value="{{endtime}}">
                    </div>
                </div>
                <div class="am-u-sm-12 am-u-md-3"></div>
            </div>
        </div>
        <div class="am-g am-margin-top">
            <div class="am-u-sm-4 am-u-md-2 am-text-right">投票规则说明</div>
            <div class="am-u-sm-4 am-u-md-9 am-u-end">
                <textarea class="" rows="5" id="info" placeholder="请填写投票规则">{{info}}</textarea>
            </div>
        </div>
        <div class="am-g am-margin-top">
            <div class="am-u-sm-4 am-u-md-2 am-text-right">投票奖励</div>
            <div class="am-u-sm-4 am-u-md-9 am-u-end">
                <input type="text" class="" value="{{reward}}" placeholder="输入投票奖励" id="reward">
            </div>
        </div>
        <div class="am-g am-margin-top">
            <div class="am-u-sm-4 am-u-md-2 am-text-right">投票类型</div>
            <div class="am-u-sm-4 am-u-md-9 am-u-end chooseVoteType">
                {{if type == 0}}
                <label for="voteType01">有限投票</label>
                {{else if type == 1}}
                <label for="voteType02">无限投票</label>
                {{/if}}
            </div>
        </div>
        <div class="am-g am-margin-top">
            <div class="am-u-sm-4 am-u-md-2 am-text-right">投票项数</div>
            <div class="am-u-sm-4 am-u-md-9 am-u-end chooseVoteType">
                <label class="am-fl">最多同时选择{{num}}项</label>
            </div>
        </div>
        <div class="am-g am-margin-top" style="padding-top: 5rem;">
            <div class="am-u-sm-2 am-u-sm-centered">
                <button type="button" style="width: 100%" class="am-btn am-btn-primary updateVote">保存</button>
            </div>
        </div>
    </form>
</script>

<script type="text/html" id="tpl-voteItems">
    <form class="am-form">
        <div class="am-g am-margin-top">
            <div class="am-u-sm-12 am-u-sm-centered" style="padding: 0 1.5rem;">
                <div class="voteCard" style="">
                    <div class="am-g">
                        <div class="am-u-sm-4 am-u-md-2 am-text-center">选项标题</div>
                        <div class="am-u-sm-4 am-u-md-1 am-text-center">手机</div>
                        <div class="am-u-sm-4 am-u-md-1 am-text-center">权重</div>
                        <div class="am-u-sm-4 am-u-md-4 am-text-center">描述</div>
                        <div class="am-u-sm-4 am-u-md-2 am-text-center">图片</div>
                        <div class="am-u-sm-4 am-u-md-2 am-text-center"></div>
                    </div>
                    <ul class="am-list voteli" style="max-height: 36rem;overflow-y: scroll;overflow-x: hidden;">
                        {{each data as item index}}
                        <li class="am-g">
                            <div class="am-u-sm-4 am-u-md-2 am-text-center" style="display: none;">
                                <input type="text" class="itemId" value="{{item.id}}" placeholder="">
                            </div>
                            <div class="am-u-sm-4 am-u-md-2 am-text-center">
                                <input type="text" class="itemTitle" value="{{item.name}}" placeholder="">
                            </div>
                            <div class="am-u-sm-4 am-u-md-1 am-text-center">
                                <input type="text" class="itemPhone" value="{{item.phone}}" placeholder="">
                            </div>
                            <div class="am-u-sm-4 am-u-md-1 am-text-center">
                                <input type="number" class="itemWeight" value="{{item.weight}}" placeholder="" min="0" step="1">
                            </div>
                            <div class="am-u-sm-4 am-u-md-4 am-text-center">
                                <input type="text" class="itemIntro" value="{{item.intro}}" placeholder="">
                            </div>
                            <div class="am-u-sm-4 am-u-md-2 am-text-center" style="position: relative;">
                                <input type="text" class="itemImg" value="{{item.image}}" placeholder="" readonly="readonly">
                                <button type="button" class="am-btn am-btn-default upBtn">上传</button>
                            </div>
                            <div class="am-u-sm-4 am-u-md-2 am-text-center">
                                <button type="button" class="am-btn am-btn-danger removeItem">删除</button>
                            </div>
                        </li>
                        {{/each}}
                    </ul>
                    <button type="button" class="am-btn am-btn-primary" id="addItem">增加</button>
                    <button type="button" id="fileBtn" style="display: none;"></button>
                </div>
            </div>
        </div>
        <div class="am-g am-margin-top" style="padding-top: 5rem;">
            <div class="am-u-sm-2"></div>
            <div class="am-u-sm-2 am-u-sm-centered">
                <button type="button" style="width: 100%" class="am-btn am-btn-primary updateVote">保存</button>
            </div>
        </div>
    </form>
</script>

<script type="text/html" id="vote-formTemplate">
    <div class="am-cf am-padding am-padding-bottom-0" >
        <div class="am-fl am-cf">
            <strong class="am-text-primary am-text-lg">用户</strong> /
            <small>详情</small>
        </div>
    </div>
    <hr>
    <div class="am-tabs am-margin" data-am-tabs>
        <div class="am-tabs-bd">
            <div class="am-tab-panel am-fade am-in am-active" id="xAdmin-tab">
                <form class="am-form" data-am-validator >
                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-4 am-u-md-2 am-text-right">活动标题</div>
                        <div class="am-u-sm-2 am-u-md-6 am-u-end">
                            <input type="text" class="" value="{{title}}" placeholder="" readonly="readonly" >
                        </div>
                    </div>
                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-4 am-u-md-2 am-text-right">姓名</div>
                        <div class="am-u-sm-2 am-u-md-6 am-u-end">
                            <input type="text" class="" value="{{name}}" placeholder="" readonly="readonly" >
                        </div>
                    </div>
                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-4 am-u-md-2 am-text-right">联系电话</div>
                        <div class="am-u-sm-2 am-u-md-6 am-u-end">
                            <input type="text" class="" value="{{phone}}" placeholder="" readonly="readonly" >
                        </div>
                    </div>
                    <!-- <div class="am-g am-margin-top">
                        <div class="am-u-sm-4 am-u-md-2 am-text-right">个人头像</div>
                        <div class="am-u-sm-8 am-u-md-4 am-u-end">
                            <img id="userPortrait" src="{{headimgurl || '/Public/images/icon/default_head.png'}}" width="140" height="140"/>
                            <div class="am-form-group am-form-file am-form-inline">
                                <i class="am-icon-cloud-upload"> </i> 更换头像
                                <input id="doc-form-file" type="file">
                            </div>
                        </div>
                    </div> -->
                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-4 am-u-md-2 am-text-right">介绍</div>
                        <div class="am-u-sm-4 am-u-md-6 am-u-end">
                            <textarea class="" rows="5" id="doc-ta-1" readonly="readonly">{{intro}}</textarea>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</script>

<script id="vote-p_count-x-table-opt-tpl" type="text/html">
    <div class="am-btn-toolbar">
        <div class="am-btn-group am-btn-group-xs">
            <button type="button" action="seeDetail" class="am-btn am-btn-default am-btn-xs am-hide-sm-only tc_look">
                <span class="am-icon-copy"></span> 查看
            </button>
        </div>
    </div>
</script>
<script id="vote-p_count-y-table-opt-tpl" type="text/html">
    <div class="am-btn-toolbar">
        <div class="am-btn-group am-btn-group-xs">
            <button type="button" action="showItem" class="am-btn am-btn-default am-btn-xs am-hide-sm-only tc_look">
                <span class="am-icon-copy"></span> 查看
            </button>
        </div>
    </div>
</script>

</head>
<body>
<!--[if lte IE 9]>
<p class="browsehappy">你正在使用<strong>过时</strong>的浏览器， 请 <a href="http://browsehappy.com/" target="_blank">升级浏览器</a>
	以获得更好的体验！</p>
<![endif]-->
<header class="am-topbar am-topbar-inverse admin-header">
	<button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-success am-show-sm-only" data-am-collapse="{target: '#topbar-collapse'}">
		<span class="am-sr-only">导航切换</span> <span class="am-icon-bars"></span>
	</button>

	<div class="am-collapse am-topbar-collapse" id="topbar-collapse">
		<div class="am-topbar-brand">
	<strong>惠盈联盟后台管理</strong> <small class="am-hide">微会员后台管理系统</small>
</div>

<button
	class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-success am-show-sm-only"
	data-am-collapse="{target: '#topbar-collapse'}">
	<span class="am-sr-only">导航切换</span> <span class="am-icon-bars"></span>
</button>

<div class="am-collapse am-topbar-collapse" id="topbar-collapse">
	<ul class="am-nav am-nav-pills am-topbar-nav am-topbar-right admin-header-list">
		<li class="am-dropdown" data-am-dropdown>
			<a class="am-dropdown-toggle" data-am-dropdown-toggle href="javascript:;">
				<span class="am-icon-user"></span> <span id="user_login_name"></span>
				<span class="am-icon-caret-down"></span>
			</a>
			<ul class="am-dropdown-content">
				<li><a href="#" style="display:none"><span class="am-icon-user"></span> 资料</a></li>
				<li><a href="#" style="display:none"><span class="am-icon-cog"></span> 设置</a></li>
				<li><a href="javascript:;" id="logOutBtn" onclick="logOut()"><span class="am-icon-power-off"></span>退出</a></li>
			</ul>
		</li>
		<li class="am-hide-sm-only">
			<a href="javascript:;" id="admin-fullscreen">
				<span class="am-icon-arrows-alt"></span>
				<span class="admin-fullText">开启全屏</span>
			</a>
		</li>
	</ul>
</div>

<div class="am-modal am-modal-confirm" tabindex="-1" id="my-confirm">
   	<div class="am-modal-dialog">
    	<div class="am-modal-bd" style="color:#000;font-size:16px;line-height:4;">
      		你确定要退出登录吗？
    	</div>
    	<div class="am-modal-footer">
    		<span class="am-modal-btn" data-am-modal-cancel>取消</span>
      		<span class="am-modal-btn" data-am-modal-confirm>确定</span>
    	</div>
  	</div>
</div>
<script>
	function logOut(e) {
		$('#my-confirm').modal({
	        relatedTarget: $('#logOutBtn'),
	        onConfirm: function(options) {
	        	location.href = '/index.php/Admin/User/logout';
	        }
	    });
	}
	document.getElementById('user_login_name').innerHTML = '&nbsp;' + getCookie('username');
</script>

	</div>
</header>

<div class="am-cf admin-main">
	<!-- sidebar start -->
	<div class="admin-sidebar am-offcanvas" id="admin-offcanvas">
		<div class="am-offcanvas-bar admin-offcanvas-bar">
			<ul class='am-list admin-sidebar-list' id="x-sidebar">
				<script>
	$(document).ready(function() {
		var prev, curr;
		var promise = new Promise(function (resolve, reject) {
			// $.get("/Public/data/menu.json", function(res) {
			$.get("/index.php/Admin/Index/menu", function(res) {
				//console.log(res)
				res.data = res.data.map(function (data) {
					data.isclose = location.pathname.indexOf(data.url) > -1 ? false : true;
					if (!data.isclose) {
						data.menus.map(function (menu) {
							menu.pending = location.pathname.indexOf(menu.url) > -1 ? true : false;
						});
					}

					return data;
				});
				var menu = template('menu-tpl',{ menus:res.data });
				var sidebar = $('#x-sidebar');
				sidebar.html(menu);
				resolve();
				sidebar.off('click').on('click', 'a:not([data-am-collapse])', function (e) {
					e.preventDefault();

					var url = null;
					if (e.target.nodeName.toLowerCase() === 'span') {
						curr = e.target.parentNode;
					} else {
						curr = e.target;
					}

					url = curr.getAttribute('href');
					$('.am-datepicker,.am-dimmer').remove();

					if (url === 'javascript:;') return;

					storeURL2Session({
						toUrl: url,
						scroll: $('#admin-offcanvas')[0].scrollTop,
						pending: 'a[href="' + $(curr).attr('href') + '"]',
					});

					// handle pending class
					if (prev) {
						Array.prototype.slice.call(prev.children).forEach(function (a) {
							a.classList.remove('icon-pending');
						});
					}
					Array.prototype.slice.call(curr.children).forEach(function (a) {
						a.classList.add('icon-pending');
					});

					prev = curr;

					console.warn('page change to: ' + url);
					var box = $('.admin-content');
					function animateBox(elem, className) {
						return new Promise(function (resolve, reject) {
							elem.addClass(className);
							animatePromise(elem).then(function () {
								elem.removeClass(className);
								resolve();
							});
						});
					}
					function animatePromise(elem) {
						return new Promise(function (resolve, reject) {
							setTimeout(resolve, 300);
						});
					}
					animateBox(box, 'from-center-to-left').then(function () {
						$.when(box.empty().load(url)).then(function () {
							animateBox(box, 'from-right-to-center');
						});
					});
				});

				//handle logout
				var sidebarLogout = $('a[href="/index.php/Home/User/logout"]');
				sidebarLogout.attr('href', 'javascript:;').click(function (e) {
					$('#my-confirm').modal({
				        relatedTarget: sidebarLogout,
				        onConfirm: function (options) {
				        	location.href = '/index.php/Admin/User/logout';
				        }
				    });
				});

				$('.am-icon-home').parent().click();
			});
		});

		sessionStorage.clear();
		restoreSession();

		function restoreSession() {
			var obj = null, toUrL = null, scroll = 0, pending = null;
			if (obj = sessionStorage.getItem('admin')) {
				obj = JSON.parse(obj);
				//console.warn(obj);
				toUrl = obj.toUrl; scroll = obj.scroll, pending = obj.pending;
				$('.admin-content').empty().load(toUrl);
				promise.then(function () {
					pending = $(pending);
					pending.children().addClass('icon-pending');
					pending.parents('ul.am-list').prev('a').click();
					prev = pending[0];
					$('#admin-offcanvas')[0].scrollTop = scroll;
				});
			}
		}

		function storeURL2Session(detail) {
			return sessionStorage.setItem('admin', JSON.stringify(detail));
		}
	});
</script>

			</ul>
			<div class="am-panel am-panel-default admin-sidebar-panel">
				<div class="am-panel-bd">
					<p><span class="am-icon-bookmark"></span> 公告</p>
					<p>微会员管理系统v1.0！ </p>
				</div>
			</div>
		</div>
	</div>
	<!-- sidebar end -->
	<!-- content start -->
	<div class="admin-content">

	</div>
	<!-- content end -->
</div>
<a href="#" class="am-icon-btn am-icon-th-list am-show-sm-only admin-menu" data-am-offcanvas="{target: '#admin-offcanvas'}"></a>
<script>
	init
	 (function () {
	 	var obj;
	 	if (obj = sessionStorage.getItem('admin')) {
	 		console.log(obj)
	 		var url = JSON.parse(obj).toUrl;
	 		console.log(url)
	 		if (url === '/index.php/Admin/Index/dashboard') {
	 			$('.admin-content').load('/index.php/Admin/Index/dashboard');
	 		}
	 	} else {
	 		$('.admin-content').load('/index.php/Admin/Index/dashboard');
	 	}
	 })();
</script>
</body>
</html>