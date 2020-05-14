<?php if (!defined('THINK_PATH')) exit();?><style>
	.admin-content {
		position: relative;
	}

	#zzzTblCon table * {
		text-align: center;
	}

	#zzzTblCon table th {
		padding: .7rem !important;
	}

	#zzzTblCon table tr th:first-child,
	#zzzTblCon table tr td:first-child {
		display: none;
	}

	#zzzTblCon table td {
		word-break: break-all;
	}

	/*#zzzAddCon,*/
	/*#zzzInfCon,*/
	#zzzRec1Con,
	#zzzRec2Con,
	#zzzCon1Con,
	#zzzCon2Con {
		position: absolute;
		top: 3rem;
		left: 50%;
		width: 360px;
		margin-left: -180px;
		background-color: rgba(221, 221, 221, .99);
		border: 1px solid rgba(189, 189, 189, .99);
		padding: 2rem 2rem 3rem;
	}

	/*#zzzAddCon,*/
	/*#zzzInfCon {*/
	/*width: 500px;*/
	/*margin-left: -250px;*/
	/*}*/

	.zzz-1 {
		margin-top: 0;
		text-align: center;
	}

	.zzz-2 {
		line-height: 3rem;
	}

	.zzz-3 {
		text-align: center;
	}

	.zzz-4 {
		margin-top: 1rem;
	}

	.zzz-5 {
		position: absolute;
		top: -1.5rem;
		right: -1.5rem;
		width: 3rem;
		height: 3rem;
		cursor: pointer;
	}

	.zzz-6 {
		width: 70px;
	}

	#zzzAddConInner,
	#zzzInfConInner {
		padding: 2rem;
		width: 60%;
	}
</style>

<!--内容区 头-->
<div class="am-cf am-padding am-padding-bottom-0">
	<div class="am-fl am-cf">
		<strong class="am-text-primary am-text-lg" id="tier-one">商户管理</strong> /
		<small id="tier-two">账号管理</small>
	</div>
	<button id="zzzAddConOpen" class="am-btn am-btn-primary am-btn-sm am-fr">新增账号</button>
</div>
<hr>

<!--主容器-->
<div class="admin-content-body">
	<div id="zzzTblCon" class="am-margin-top">
		<table class="am-table am-table-striped am-table-hover table-main">
			<thead>
			<tr>
				<th>ID</th>
				<th style="width: 10%;">名称</th>
				<th style="width: 10%;">别名</th>
				<th style="width: 10%;">appid</th>
				<th style="width: 15%;">appsecret</th>
				<th style="width: 15%;">accesstoken</th>
				<th style="width: 10%;">商户名</th>
				<th style="width: 10%;">创建时间</th>
				<th style="width: 10%;">更新时间</th>
				<th style="width: 10%;">操作</th>
			</tr>
			</thead>
		</table>
	</div>
</div>

<!--添加-->
<div class="am-tabs am-margin am-hide" id="zzzAddCon">
	<ul class="am-tabs-nav am-nav am-nav-tabs">
		<li class="am-active"><a href="#xAdmin-tab">新增账号</a></li>
	</ul>
	<div class="am-tabs-bd">
		<div class="am-tab-panel am-fade am-in am-active">
			<div id="zzzAddConInner" class="am-form">
				<div class="am-g am-margin-bottom">
					<div class="am-u-sm-3 zzz-2">商户</div>
					<div class="am-u-sm-9">
						<select id="zzzAddShopId"></select>
					</div>
				</div>
				<div class="am-g am-margin-bottom">
					<div class="am-u-sm-3 zzz-2">惠盈联盟</div>
					<div class="am-u-sm-9" style="line-height: 3rem;">
						<input type="radio" name="zzzAddStatus" value="1" checked> 是
						&nbsp;&nbsp;&nbsp;
						<input type="radio" name="zzzAddStatus" value="0"> 否
					</div>
				</div>
				<div class="am-g am-margin-bottom">
					<div class="am-u-sm-3 zzz-2">名称</div>
					<div class="am-u-sm-9">
						<input type="text" placeholder="名称" id="zzzAddName">
					</div>
				</div>
				<div class="am-g am-margin-bottom">
					<div class="am-u-sm-3 zzz-2">别名</div>
					<div class="am-u-sm-9">
						<input type="text" placeholder="别名" id="zzzAddAlias">
					</div>
				</div>
				<div class="am-g am-margin-bottom">
					<div class="am-u-sm-3 zzz-2">appId</div>
					<div class="am-u-sm-9">
						<input type="text" placeholder="appId" id="zzzAddAppId">
					</div>
				</div>
				<div class="am-g am-margin-bottom">
					<div class="am-u-sm-3 zzz-2">appSecret</div>
					<div class="am-u-sm-9">
						<input type="text" placeholder="appSecret" id="zzzAddAppSecret">
					</div>
				</div>
				<div class="am-g am-margin-bottom">
					<div class="am-u-sm-3 zzz-2">accessToken</div>
					<div class="am-u-sm-9">
						<input type="text" placeholder="accessToken" id="zzzAddAccessToken">
					</div>
				</div>
				<div class="am-g am-margin-top">
					<div class="am-u-sm-3 zzz-2"></div>
					<div class="am-u-sm-9">
						<button class="am-btn am-btn-primary" id="zzzAddSubmit">提交</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!--查看和修改-->
<div class="am-tabs am-margin am-hide" id="zzzInfCon">
	<ul class="am-tabs-nav am-nav am-nav-tabs">
		<li class="am-active"><a href="#xAdmin-tab">查看账号</a></li>
	</ul>
	<div class="am-tabs-bd">
		<div class="am-tab-panel am-fade am-in am-active">
			<div id="zzzInfConInner" class="am-form">
				<input type="hidden" id="zzzInfoId">
				<div class="am-g zzz-4">
					<div class="am-u-sm-3 am-u-md-3 am-u-lg-3">名称</div>
					<div class="am-u-sm-9 am-u-md-9 am-u-lg-9">
						<input type="text" id="zzzInfoName" placeholder="名称">
					</div>
				</div>
				<div class="am-g zzz-4">
					<div class="am-u-sm-3 am-u-md-3 am-u-lg-3">别名</div>
					<div class="am-u-sm-9 am-u-md-9 am-u-lg-9">
						<input type="text" id="zzzInfoAlias" placeholder="别名">
					</div>
				</div>
				<div class="am-g zzz-4">
					<div class="am-u-sm-3 am-u-md-3 am-u-lg-3">appId</div>
					<div class="am-u-sm-9 am-u-md-9 am-u-lg-9">
						<input type="text" id="zzzInfoAppId" placeholder="appId">
					</div>
				</div>
				<div class="am-g zzz-4">
					<div class="am-u-sm-3 am-u-md-3 am-u-lg-3">appSecret</div>
					<div class="am-u-sm-9 am-u-md-9 am-u-lg-9">
						<input type="text" id="zzzInfoAppSecret" placeholder="appSecret">
					</div>
				</div>
				<div class="am-g zzz-4">
					<div class="am-u-sm-3 am-u-md-3 am-u-lg-3">accessToken</div>
					<div class="am-u-sm-9 am-u-md-9 am-u-lg-9">
						<input type="text" id="zzzInfoAccessToken" placeholder="accessToken">
					</div>
				</div>
				<div class="am-g zzz-4">
					<div class="am-u-sm-3 am-u-md-3 am-u-lg-3"></div>
					<div class="am-u-sm-9 am-u-md-9 am-u-lg-9">
						<button id="zzzInfoSubmit" class="am-btn am-btn-primary">保存</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!--内容区 尾-->
<hr>
<footer class="admin-content-footer am-padding-top-0">
	<p class="am-padding-left">© 2016-2026 威海盈帆科技有限公司版权所有。</p>
</footer>

<script type="text/html" id="zzzTpl1">
	<button class="am-btn am-btn-default am-btn-xs view zzz-6" style="margin: 0 3px 3px 0;">
		<span class="am-icon-eye"></span>
		<span>查看</span>
	</button>
	{{ if status === '1' }}
	<button class="am-btn am-btn-default am-btn-xs disable zzz-6" style="margin: 0 3px 3px 0; color: red;">
		<span class="am-icon-minus-circle"></span>
		<span>禁用</span>
	</button>
	{{ else }}
	<button class="am-btn am-btn-default am-btn-xs enable zzz-6" style="margin: 0 3px 3px 0; color: green;">
		<span class="am-icon-plus-circle"></span>
		<span>启用</span>
	</button>
	{{ /if }}
</script>
<script type="text/html" id="zzzTpl2">
	<option value="">请选择</option>
	{{ each data }}
	<option value="{{ $value.id }}">{{ $value.name }}</option>
	{{ /each }}
</script>

<script>
	!function (a) {
		"use strict";
		function b(b) {
			var c = a("");
			try {
				c = a(b).clone();
			} catch (d) {
				c = a("<span />").html(b);
			}
			return c;
		}

		function c(b, c, d) {
			var e = a.Deferred();
			try {
				b = b.contentWindow || b.contentDocument || b;
				var f = b.document || b.contentDocument || b;
				d.doctype && f.write(d.doctype), f.write(c), f.close();
				var g = !1, h = function () {
					if (!g) {
						b.focus();
						try {
							b.document.execCommand("print", !1, null) || b.print(), a("body").focus();
						} catch (a) {
							b.print();
						}
						b.close(), g = !0, e.resolve();
					}
				};
				a(b).on("load", h), setTimeout(h, d.timeout);
			} catch (a) {
				e.reject(a);
			}
			return e;
		}

		function d(b, d) {
			var f = a(d.iframe + ""), g = f.length;
			return 0 === g && (f = a('<iframe height="0" width="0" border="0" wmode="Opaque"/>').prependTo("body").css({
				position: "absolute",
				top: -999,
				left: -999
			})), c(f.get(0), b, d).done(function () {
				setTimeout(function () {
					0 === g && f.remove();
				}, 1e3);
			}).fail(function (a) {
				console.error("Failed to print from iframe", a), e(b, d);
			}).always(function () {
				try {
					d.deferred.resolve();
				} catch (a) {
					console.warn("Error notifying deferred", a);
				}
			});
		}

		function e(a, b) {
			return c(window.open(), a, b).always(function () {
				try {
					b.deferred.resolve();
				} catch (a) {
					console.warn("Error notifying deferred", a);
				}
			});
		}

		function f(a) {
			return !!("object" == typeof Node ? a instanceof Node : a && "object" == typeof a && "number" == typeof a.nodeType && "string" == typeof a.nodeName);
		}

		a.print = a.fn.print = function () {
			var c, g, h = this;
			h instanceof a && (h = h.get(0)), f(h) ? (g = a(h), arguments.length > 0 && (c = arguments[0])) : arguments.length > 0 ? (g = a(arguments[0]), f(g[0]) ? arguments.length > 1 && (c = arguments[1]) : (c = arguments[0], g = a("html"))) : g = a("html");
			var i = {
				globalStyles: !0,
				mediaPrint: !1,
				stylesheet: null,
				noPrintSelector: ".no-print",
				iframe: !0,
				append: null,
				prepend: null,
				manuallyCopyFormValues: !0,
				deferred: a.Deferred(),
				timeout: 750,
				title: null,
				doctype: "<!doctype html>"
			};
			c = a.extend({}, i, c || {});
			var j = a("");
			c.globalStyles ? j = a("style, link, meta, base, title") : c.mediaPrint && (j = a("link[media=print]")), c.stylesheet && (j = a.merge(j, a('<link rel="stylesheet" href="' + c.stylesheet + '">')));
			var k = g.clone();
			if (k = a("<span/>").append(k), k.find(c.noPrintSelector).remove(), k.append(j.clone()), c.title) {
				var l = a("title", k);
				0 === l.length && (l = a("<title />"), k.append(l)), l.text(c.title);
			}
			k.append(b(c.append)), k.prepend(b(c.prepend)), c.manuallyCopyFormValues && (k.find("input").each(function () {
				var b = a(this);
				b.is("[type='radio']") || b.is("[type='checkbox']") ? b.prop("checked") && b.attr("checked", "checked") : b.attr("value", b.val());
			}), k.find("select").each(function () {
				a(this).find(":selected").attr("selected", "selected");
			}), k.find("textarea").each(function () {
				var b = a(this);
				b.text(b.val());
			}));
			var m = k.html();
			try {
				c.deferred.notify("generated_markup", m, k);
			} catch (a) {
				console.warn("Error notifying deferred", a);
			}
			if (k.remove(), c.iframe)try {
				d(m, c);
			} catch (a) {
				console.error("Failed to print from iframe", a.stack, a.message), e(m, c);
			} else e(m, c);
			return this;
		};
	}(jQuery);
</script>

<script>
	var zzz = {
		table: undefined,
		data: {
			add: {
				name: '',
				alias: '',
				appId: '',
				appSecret: '',
				accessToken: '',
				status: '',
				shopId: ''
			},
			edit: {
				id: '',
				name: '',
				alias: '',
				appId: '',
				appSecret: '',
				accessToken: ''
			}
		},
		url: {
			list: '/index.php/Admin/Shop/getMangagers',
			enable: '/index.php/Admin/Shop/setEnableMangagers',
			disable: '/index.php/Admin/Shop/setDisableMangagers',
			get: '/index.php/Admin/Shop/seeMangagers',
			edit: '/index.php/Admin/Shop/updateMangagers',
			listForAdd: '/index.php/Admin/Shop/seeMangagersShop',
			add: '/index.php/Admin/Shop/setMangagersShop',
			add2: '/index.php/Admin/Shop/updateDisable'
		},
		drawTable: function () {
			var dt = {
				bProcessing: false,
				bAutoWidth: false,
				bInfo: false,
				sPaginationType: "simple_numbers",
				iDisplayLength: 10,
				searching: false,
				bSort: false,
				bLengthChange: false,
				destroy: true,
				pageLength: 10,
				bPaginate: true,
				serverSide: true,
				bStateSave: true,
				ajax: {
					"dataSrc": function (json) {
						return json.data;
					}
				},
				sServerMethod: "POST",
				fnServerParams: function (aoData) {
					//aoData.start = 1;
				}
			};
			dt.fnServerParams = function (aoData) {
				//aoData.realname = para.realname;
				//aoData.phone = para.phone;
			};
			dt.columns = [
				{data: "id"},
				{data: "name"},
				{data: "alias"},
				{data: "appid"},
				{data: "appsecret"},
				{data: "accesstoken"},
				{data: "shopname"},
				{data: "createtime"},
				{data: "updatetime"},
				{data: "status"}
			];
			dt.columnDefs = [
				{
					targets: [9],
					data: "status",
					render: function (data, type, row) {
						var render = template.compile($('#zzzTpl1').html());
						return render({status: data});
					}
				}];
			dt.ajax.url = zzz.url.list;
			zzz.table = $('#zzzTblCon').find('table').DataTable(dt);
		},
		onLoad: function () {
			false && $.post(zzz.url.list, function (res) {
				log(res);
			});
			zzz.drawTable();

			$('#zzzAddName').parent().parent().hide();
			$('#zzzAddAlias').parent().parent().hide();
			$('#zzzAddAppId').parent().parent().hide();
			$('#zzzAddAppSecret').parent().parent().hide();
			$('#zzzAddAccessToken').parent().parent().hide();
		},
		clicks: function () {
			// 添加
			$(document).off('click', '#zzzAddConOpen').on('click', '#zzzAddConOpen', function () {
				$('#zzzAddCon').removeClass('am-hide');
				$('.admin-content').scrollTo('#zzzAddCon', 500);
				$.post(zzz.url.listForAdd, function (res) {
					var render = template.compile($('#zzzTpl2').html());
					var html = render({data: res.data});
					$('#zzzAddShopId').html(html);
				});
			});
			$(document).off('click', 'input[name=zzzAddStatus]').on('click', 'input[name=zzzAddStatus]', function () {
				var that = $(this);
				var value = that.val();
				if (value === '1') {
					$('#zzzAddName').parent().parent().hide();
					$('#zzzAddAlias').parent().parent().hide();
					$('#zzzAddAppId').parent().parent().hide();
					$('#zzzAddAppSecret').parent().parent().hide();
					$('#zzzAddAccessToken').parent().parent().hide();
				}
				else {
					$('#zzzAddName').parent().parent().show();
					$('#zzzAddAlias').parent().parent().show();
					$('#zzzAddAppId').parent().parent().show();
					$('#zzzAddAppSecret').parent().parent().show();
					$('#zzzAddAccessToken').parent().parent().show();
				}
			});
			$(document).off('click', '#zzzAddSubmit').on('click', '#zzzAddSubmit', function () {
				var status = $('input[name="zzzAddStatus"]:checked').val().trim();
				var shopId = $('#zzzAddShopId');
				var name = $('#zzzAddName');
				var alias = $('#zzzAddAlias');
				var appId = $('#zzzAddAppId');
				var appSecret = $('#zzzAddAppSecret');
				var accessToken = $('#zzzAddAccessToken');

				if (status === '0') {
					var shopIdV = shopId.val();
					var nameV = name.val();
					var aliasV = alias.val();
					var appIdV = appId.val();
					var appSecretV = appSecret.val();
					var accessTokenV = accessToken.val();

					shopIdV.trim();
					nameV.trim();
					aliasV.trim();
					appIdV.trim();
					appSecretV.trim();
					accessTokenV.trim();

					if (!nameV || !aliasV || !appIdV || !appSecretV || !accessTokenV || !shopIdV) {
						return modal_alert('必须全部填写');
					}

					zzz.data.add.shopId = shopIdV;
					zzz.data.add.staus = status;
					zzz.data.add.name = nameV;
					zzz.data.add.alias = aliasV;
					zzz.data.add.appId = appIdV;
					zzz.data.add.appSecret = appSecretV;
					zzz.data.add.accessToken = accessTokenV;

					$.post(zzz.url.add, zzz.data.add, function (res) {
						if (res.code !== 0)
							return modal_alert(res.msg);

						modal_alert('添加成功');

						name.val('');
						alias.val('');
						appId.val('');
						appSecret.val('');
						accessToken.val('');
						$('input[name=zzzAddStatus]').filter('[value=1]').prop('checked', true);
						shopId.val('');

						$('.admin-content').scrollTo(0, 500);
						$('#zzzAddCon').addClass('am-hide');

						zzz.drawTable();
					});
				}
				else {
					var shopIdV = shopId.val();

					shopIdV.trim();

					if (!shopIdV) {
						return modal_alert('必须全部填写');
					}

					$.post(zzz.url.add2, {shopId: shopIdV}, function (res) {
						if (res.code !== 0)
							return modal_alert(res.msg);

						modal_alert('添加成功');

						name.val('');
						alias.val('');
						appId.val('');
						appSecret.val('');
						accessToken.val('');
						$('input[name=zzzAddStatus]').filter('[value=1]').prop('checked', true);
						shopId.val('');

						$('.admin-content').scrollTo(0, 500);
						$('#zzzAddCon').addClass('am-hide');

						zzz.drawTable();
					});
				}
			});

			// 查看
			$(document).off('click', '#zzzTblCon table .view').on('click', '#zzzTblCon table .view', function () {
				$('#zzzInfCon').removeClass('am-hide');
				$('.admin-content').scrollTo('#zzzInfCon', 500);
				var tr = $(this).parent().parent();
				var id = tr.find('td:first-child').text();
				$.post(zzz.url.get, {id: id}, function (res) {
					log(res);
					if (res.code !== 0)
						return modal_alert(res.msg);

					var t = res.data[0];
					$('#zzzInfoId').val(t.id);
					$('#zzzInfoName').val(t.name);
					$('#zzzInfoAlias').val(t.alias);
					$('#zzzInfoAppId').val(t.appid);
					$('#zzzInfoAppSecret').val(t.appsecret);
					$('#zzzInfoAccessToken').val(t.accesstoken);
				});
			});
			$(document).off('click', '#zzzInfoSubmit').on('click', '#zzzInfoSubmit', function () {
				var id = $('#zzzInfoId').val();

				var name = $('#zzzInfoName');
				var alias = $('#zzzInfoAlias');
				var appId = $('#zzzInfoAppId');
				var appSecret = $('#zzzInfoAppSecret');
				var accessToken = $('#zzzInfoAccessToken');

				var nameV = name.val();
				var aliasV = alias.val();
				var appIdV = appId.val();
				var appSecretV = appSecret.val();
				var accessTokenV = accessToken.val();

				nameV.trim();
				aliasV.trim();
				appIdV.trim();
				appSecretV.trim();
				accessTokenV.trim();

				if (!nameV || !aliasV || !appIdV || !appSecretV || !accessTokenV)
					return modal_alert('必须全部填写');

				zzz.data.edit.id = id;
				zzz.data.edit.name = nameV;
				zzz.data.edit.alias = aliasV;
				zzz.data.edit.appId = appIdV;
				zzz.data.edit.appSecret = appSecretV;
				zzz.data.edit.accessToken = accessTokenV;

				$.post(zzz.url.edit, zzz.data.edit, function (res) {
					if (res.code !== 0)
						return modal_alert(res.msg);

					modal_alert('修改成功');
					$('#zzzInfCon').addClass('am-hide');
					$('.admin-content').scrollTo(0, 500);

					zzz.drawTable();
				});
			});

			// 禁用
			$(document).off('click', '#zzzTblCon table .disable').on('click', '#zzzTblCon table .disable', function () {
				var that = $(this);
				var tr = $(this).parent().parent();
				var id = tr.find('td:first-child').text();
				$.post(zzz.url.disable, {id: id}, function (res) {
					if (res.code !== 0)
						return modal_alert(res.msg);

					that.removeClass('disable').addClass('enable').css('color', 'green').find('span').eq(0).attr('class', 'am-icon-plus-circle');
					that.removeClass('disable').addClass('enable').css('color', 'green').find('span').eq(1).text('启用');
				});
			});

			// 启用
			$(document).off('click', '#zzzTblCon table .enable').on('click', '#zzzTblCon table .enable', function () {
				var that = $(this);
				var tr = $(this).parent().parent();
				var id = tr.find('td:first-child').text();
				$.post(zzz.url.enable, {id: id}, function (res) {
					if (res.code !== 0)
						return modal_alert(res.msg);

					that.removeClass('enable').addClass('disable').css('color', 'red').find('span').eq(0).attr('class', 'am-icon-minus-circle');
					that.removeClass('enable').addClass('disable').css('color', 'red').find('span').eq(1).text('禁用');
				});
			});
		},
		init: function () {
			this.onLoad();
			this.clicks();
		}
	};
	$(function () {
		zzz.init();
	});
</script>