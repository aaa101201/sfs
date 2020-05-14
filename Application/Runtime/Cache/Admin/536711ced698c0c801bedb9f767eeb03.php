<?php if (!defined('THINK_PATH')) exit();?><style>
	.am-modal-alert {
		z-index: 2000;
	}

	.admin-content {
		position: relative;
	}

	#aaaTblCon table * {
		text-align: center;
	}

	#aaaTblCon table th {
		padding: 0.7rem !important;
	}

	#aaaTblCon table tr th:first-child,
	#aaaTblCon table tr td:first-child {
		display: none;
	}

	/*#aaaAddCon,*/
	/*#aaaInfCon,*/
	#aaaRec1Con,
	#aaaRec2Con,
	#aaaRec3Con,
	#aaaCon1Con,
	#aaaCon2Con,
	#aaaCon3Con {
		position: fixed;
		top: 50%;
		left: 50%;
		width: 360px;
		margin-top: -150px;
		margin-left: -180px;
		background-color: rgba(221, 221, 221, .99);
		background-color: white;
		border: 1px solid rgba(189, 189, 189, .99);
		padding: 2rem 2rem 3rem;
		z-index: 1200;
	}

	#aaaRec1Amount,
	#aaaRec3Amount,
	#aaaRec3Gift,
	#aaaCon1Amount,
	#aaaCon3Amount {
		margin-left: -1rem;
	}

	/*#aaaAddCon,*/
	/*#aaaInfCon {*/
	/*width: 500px;*/
	/*margin-left: -250px;*/
	/*}*/

	.aaa-1 {
		margin-top: 0;
		text-align: center;
	}

	.aaa-2 {
		line-height: 3rem;
	}

	.aaa-3 {
		text-align: center;
	}

	.aaa-4 {
		margin-top: 1rem;
	}

	.aaa-5 {
		display: none;
		position: absolute;
		top: -1.5rem;
		right: -1.5rem;
		width: 3rem;
		height: 3rem;
		cursor: pointer;
	}

	.aaa-6 {
		width: 70px;
	}

	#aaaAddConInner,
	#aaaInfConInner {
		padding: 2rem;
		width: 60%;
	}

	.aaa-7 {
		/*max-width: 70%;*/
	}

	.aaa-8 {
		line-height: 2.7rem;
	}

	#aaaSeaPhone,
	#aaaSeaName {
		/*max-width: 60% !important;*/
	}

	.aaaMask1 {
		position: fixed;
		width: 100%;
		height: 100%;
		background-color: rgba(0, 0, 0, .3);
		display: none;
	}
</style>

<!--内容区 头-->
<div class="am-cf am-padding am-padding-bottom-0">
	<div class="am-fl am-cf">
		<strong class="am-text-primary am-text-lg" id="tier-one">会员管理</strong> /
		<small id="tier-two">会员列表</small>
	</div>
	<button id="aaaAddConOpen" class="am-btn am-btn-primary am-btn-sm am-fr">新增会员</button>
</div>
<hr>

<!--主容器-->
<div class="admin-content-body">
	<div id="aaaSeaCon" class="am-g">
		<div class="am-u-sm-12 am-u-md-1 am-fl">
			<button id="aaaSeaExcel" class="am-btn am-btn-primary am-btn-sm am-fl">Excel</button>
		</div>
		<div class="am-u-sm-12 am-u-md-1 am-fr">
			<button id="aaaSeaSubmit" class="am-btn am-btn-primary am-btn-sm am-fr">查询</button>
		</div>
		<div class="am-u-sm-12 am-u-md-10 am-fr">
			<div class="am-u-sm-12 am-u-md-3 am-fr">
				<div class="am-form-group am-form-icon">
					<i class="am-icon-calendar"></i>
					<input id="aaaSeaTimeEnd" type="text" class="am-form-field am-input-sm aaa-7" placeholder="结束时间"
						   readonly>
				</div>
			</div>
			<div class="am-u-sm-12 am-u-md-3 am-fr">
				<div class="am-form-group am-form-icon">
					<i class="am-icon-calendar"></i>
					<input id="aaaSeaTimeStart" type="text" class="am-form-field am-input-sm aaa-7" placeholder="开始时间"
						   readonly>
				</div>
			</div>
			<div class="am-u-sm-12 am-u-md-3 am-fr">
				<span class="am-fl aaa-8">手机号：</span>
				<input id="aaaSeaPhone" placeholder="手机号" type="text" class="am-form-field am-input-sm am-fl">
			</div>
			<div class="am-u-sm-12 am-u-md-3 am-fr">
				<span class="am-fl aaa-8">姓名：</span>
				<input id="aaaSeaName" placeholder="姓名" type="text" class="am-form-field am-input-sm">
			</div>
		</div>
	</div>
	<div id="aaaTblCon" class="am-margin-top">
		<table class="am-table am-table-striped am-table-hover table-main">
			<thead>
			<tr>
				<th>ID</th>
				<th>卡号</th>
				<th>姓名</th>
				<th>手机号</th>
				<th>等级</th>
				<th>余额</th>
				<th>可用积分</th>
				<th>注册时间</th>
				<th style="width: 15%;">操作</th>
			</tr>
			</thead>
		</table>
	</div>
</div>

<!--弹窗容器-->

<!--会员添加-->
<div class="am-tabs am-margin am-hide" id="aaaAddCon">
	<ul class="am-tabs-nav am-nav am-nav-tabs">
		<li class="am-active"><a href="#xAdmin-tab">新增会员</a></li>
	</ul>
	<div class="am-tabs-bd">
		<div class="am-tab-panel am-fade am-in am-active">
			<div id="aaaAddConInner" class="am-form">
				<!--<img src="/Public/images/llg-2.png" id="aaaAddConClose" class="aaa-5">-->
				<!--<h2 class="aaa-1">新增会员</h2>-->
				<div class="am-g am-margin-bottom">
					<div class="am-u-sm-3 aaa-2">会员姓名</div>
					<div class="am-u-sm-9">
						<input type="text" placeholder="会员姓名" id="aaaAddName">
					</div>
				</div>
				<div class="am-g">
					<div class="am-u-sm-3 aaa-2">生日</div>
					<div class="am-u-sm-9" style="line-height: 3rem;">
						<input type="radio" name="aaaAddBirthType" value="1" checked> 阳历
						&nbsp;&nbsp;&nbsp;
						<input type="radio" name="aaaAddBirthType" value="0"> 阴历
					</div>
				</div>
				<div class="am-g am-margin-bottom">
					<div class="am-u-sm-3 aaa-2"></div>
					<div class="am-u-sm-9">
						<input type="text" id="aaaAddBirth" placeholder="0000-00-00">
					</div>
				</div>
				<div class="am-g am-margin-bottom">
					<div class="am-u-sm-3 aaa-2">性别</div>
					<div class="am-u-sm-9" style="line-height: 3rem;">
						<input type="radio" name="aaaAddSex" value="1" checked> 男
						&nbsp;&nbsp;&nbsp;
						<input type="radio" name="aaaAddSex" value="0"> 女
					</div>
				</div>
				<div class="am-g">
					<div class="am-u-sm-3 aaa-2">手机号</div>
					<div class="am-u-sm-9">
						<input type="number" placeholder="手机号" id="aaaAddPhone">
					</div>
				</div>
				<div class="am-g am-margin-top">
					<div class="am-u-sm-3 aaa-2"></div>
					<div class="am-u-sm-9">
						<button class="am-btn am-btn-primary" id="aaaAddSubmit">提交</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!--会员信息的查看和修改-->
<div class="am-tabs am-margin am-hide" id="aaaInfCon">
	<ul class="am-tabs-nav am-nav am-nav-tabs">
		<li class="am-active"><a href="#xAdmin-tab">查看会员</a></li>
	</ul>
	<div class="am-tabs-bd">
		<div class="am-tab-panel am-fade am-in am-active">
			<div id="aaaInfConInner" class="am-form">
				<!--<img src="/Public/images/llg-2.png" id="aaaInfConClose" class="aaa-5">-->
				<input type="hidden" id="aaaInfoId">
				<div class="am-g aaa-4">
					<div class="am-u-sm-3 am-u-md-3 am-u-lg-3">会员姓名</div>
					<div class="am-u-sm-9 am-u-md-9 am-u-lg-9">
						<input type="text" id="aaaInfoName" placeholder="会员姓名">
					</div>
				</div>
				<div class="am-g aaa-4">
					<div class="am-u-sm-3 am-u-md-3 am-u-lg-3">生日</div>
					<div class="am-u-sm-9 am-u-md-9 am-u-lg-9">
						<input type="radio" name="aaaInfoBirthType" value="1" checked> 阳历
						<input type="radio" name="aaaInfoBirthType" value="0"> 阴历
					</div>
				</div>
				<div class="am-g aaa-4">
					<div class="am-u-sm-3 am-u-md-3 am-u-lg-3"></div>
					<div class="am-u-sm-9 am-u-md-9 am-u-lg-9">
						<input type="text" id="aaaInfoBirth" placeholder="0000-00-00">
					</div>
				</div>
				<div class="am-g aaa-4">
					<div class="am-u-sm-3 am-u-md-3 am-u-lg-3">性别</div>
					<div class="am-u-sm-9 am-u-md-9 am-u-lg-9">
						<input type="radio" name="aaaInfoSex" value="1" checked> 男
						<input type="radio" name="aaaInfoSex" value="0"> 女
					</div>
				</div>
				<div class="am-g aaa-4">
					<div class="am-u-sm-3 am-u-md-3 am-u-lg-3">手机号</div>
					<div class="am-u-sm-9 am-u-md-9 am-u-lg-9">
						<input type="text" id="aaaInfoPhone" placeholder="手机号">
					</div>
				</div>
				<div class="am-g aaa-4">
					<div class="am-u-sm-3 am-u-md-3 am-u-lg-3">卡号</div>
					<div class="am-u-sm-9 am-u-md-9 am-u-lg-9">
						<input type="text" id="aaaInfoCard">
					</div>
				</div>
				<div class="am-g aaa-4">
					<div class="am-u-sm-3 am-u-md-3 am-u-lg-3">会员等级</div>
					<div class="am-u-sm-9 am-u-md-9 am-u-lg-9">
						<input type="text" id="aaaInfoRank" disabled>
					</div>
				</div>
				<div class="am-g aaa-4">
					<div class="am-u-sm-3 am-u-md-3 am-u-lg-3">余额</div>
					<div class="am-u-sm-9 am-u-md-9 am-u-lg-9">
						<input type="text" id="aaaInfoBalance" disabled>
					</div>
				</div>
				<div class="am-g aaa-4">
					<div class="am-u-sm-3 am-u-md-3 am-u-lg-3">可用积分</div>
					<div class="am-u-sm-9 am-u-md-9 am-u-lg-9">
						<input type="text" id="aaaInfoPoint" disabled>
					</div>
				</div>
				<div class="am-g aaa-4">
					<div class="am-u-sm-3 am-u-md-3 am-u-lg-3">累计消费金额</div>
					<div class="am-u-sm-9 am-u-md-9 am-u-lg-9">
						<input type="text" id="aaaInfoSpent" disabled>
					</div>
				</div>
				<div class="am-g aaa-4">
					<div class="am-u-sm-3 am-u-md-3 am-u-lg-3">关注日期</div>
					<div class="am-u-sm-9 am-u-md-9 am-u-lg-9">
						<input type="text" id="aaaInfoDate" disabled>
					</div>
				</div>
				<div class="am-g aaa-4">
					<div class="am-u-sm-3 am-u-md-3 am-u-lg-3"></div>
					<div class="am-u-sm-9 am-u-md-9 am-u-lg-9">
						<button id="aaaInfoSubmit" class="am-btn am-btn-primary">保存</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!--会员充值-->
<div id="aaaRec1Con" class="am-form am-hide">
	<input type="hidden" id="aaaRec1Id">
	<input type="hidden" id="aaaRec1Name">
	<img src="/Public/images/llg-2.png" id="aaaRec1ConClose" class="aaa-5">
	<h2 class="aaa-1">会员充值</h2>
	<div class="am-g">
		<div class="am-u-sm-3 aaa-2">金额</div>
		<div class="am-u-sm-9">
			<input type="number" placeholder="金额" id="aaaRec1Amount">
		</div>
	</div>
	<div class="am-g aaa-3 am-margin-top">
		<button class="am-btn am-btn-primary am-margin-right" id="aaaRec1Cancel">取消</button>
		<button class="am-btn am-btn-primary" id="aaaRec1Submit">确认</button>
	</div>
</div>

<!--会员充值确认-->
<div id="aaaRec3Con" class="am-form am-hide">
	<input type="hidden" id="aaaRec3Id">
	<input type="hidden" id="aaaRec3Name">
	<img src="/Public/images/llg-2.png" id="aaaRec3ConClose" class="aaa-5">
	<h2 class="aaa-1">充值确认</h2>
	<div class="am-g" style="margin-bottom: 1rem;">
		<div class="am-u-sm-3 aaa-2">金额</div>
		<div class="am-u-sm-9">
			<input type="number" placeholder="金额" id="aaaRec3Amount" readonly>
		</div>
	</div>
	<div class="am-g">
		<div class="am-u-sm-3 aaa-2">赠送</div>
		<div class="am-u-sm-9">
			<input type="number" placeholder="赠送" id="aaaRec3Gift" readonly>
		</div>
	</div>
	<div class="am-g aaa-3 am-margin-top">
		<button class="am-btn am-btn-primary am-margin-right" id="aaaRec3Cancel">取消</button>
		<button class="am-btn am-btn-primary" id="aaaRec3Submit">确认</button>
	</div>
</div>

<!--会员充值成功-->
<div id="aaaRec2Con" class="am-form am-hide">
	<img src="/Public/images/llg-2.png" id="aaaRec2ConClose" class="aaa-5">
	<h2 class="aaa-1">交易成功</h2>
	<div class="am-g">
		<div class="am-u-sm-4">卡号</div>
		<div class="am-u-sm-8" id="aaaRec2Card"></div>
	</div>
	<div class="am-g">
		<div class="am-u-sm-4">交易类型</div>
		<div class="am-u-sm-8">充值</div>
	</div>
	<div class="am-g">
		<div class="am-u-sm-4">交易金额</div>
		<div class="am-u-sm-8" id="aaaRec2Amount"></div>
	</div>
	<div class="am-g">
		<div class="am-u-sm-4">充值返现</div>
		<div class="am-u-sm-8" id="aaaRec2AmountBack"></div>
	</div>
	<div class="am-g">
		<div class="am-u-sm-4">余额</div>
		<div class="am-u-sm-8" id="aaaRec2Balance"></div>
	</div>
	<div class="am-g">
		<div class="am-u-sm-4">剩余积分</div>
		<div class="am-u-sm-8" id="aaaRec2Point"></div>
	</div>
	<div class="am-g">
		<div class="am-u-sm-4">日期</div>
		<div class="am-u-sm-8" id="aaaRec2Date"></div>
	</div>
	<div class="am-g aaa-3 am-margin-top">
		<button class="am-btn am-btn-primary am-margin-right" id="aaaRec2Cancel">关闭</button>
		<button class="am-btn am-btn-primary" id="aaaRec2Print">打印小票</button>
	</div>
</div>

<!--会员消费-->
<div id="aaaCon1Con" class="am-form am-hide">
	<input type="hidden" id="aaaCon1Id">
	<img src="/Public/images/llg-2.png" id="aaaCon1ConClose" class="aaa-5">
	<h2 class="aaa-1">会员消费</h2>
	<div class="am-g">
		<div class="am-u-sm-3 aaa-2">金额</div>
		<div class="am-u-sm-9">
			<input type="number" placeholder="金额" id="aaaCon1Amount">
		</div>
	</div>
	<div class="am-g aaa-3 am-margin-top">
		<button class="am-btn am-btn-primary am-margin-right" id="aaaCon1Cancel">取消</button>
		<button class="am-btn am-btn-primary" id="aaaCon1Submit">确认</button>
	</div>
</div>

<!--会员消费确认-->
<div id="aaaCon3Con" class="am-form am-hide">
	<input type="hidden" id="aaaCon3Id">
	<img src="/Public/images/llg-2.png" id="aaaCon3ConClose" class="aaa-5">
	<h2 class="aaa-1">消费确认</h2>
	<div class="am-g">
		<div class="am-u-sm-3 aaa-2">金额</div>
		<div class="am-u-sm-9">
			<input type="number" placeholder="金额" id="aaaCon3Amount" readonly>
		</div>
	</div>
	<div class="am-g aaa-3 am-margin-top">
		<button class="am-btn am-btn-primary am-margin-right" id="aaaCon3Cancel">取消</button>
		<button class="am-btn am-btn-primary" id="aaaCon3Submit">确认</button>
	</div>
</div>

<!--会员消费成功-->
<div id="aaaCon2Con" class="am-form am-hide">
	<img src="/Public/images/llg-2.png" id="aaaCon2ConClose" class="aaa-5">
	<h2 class="aaa-1">交易成功</h2>
	<div class="am-g">
		<div class="am-u-sm-4">卡号</div>
		<div class="am-u-sm-8" id="aaaCon2Card"></div>
	</div>
	<div class="am-g">
		<div class="am-u-sm-4">交易类型</div>
		<div class="am-u-sm-8" id="aaaCon2Type"></div>
	</div>
	<div class="am-g">
		<div class="am-u-sm-4">交易金额</div>
		<div class="am-u-sm-8" id="aaaCon2Amount"></div>
	</div>
	<div class="am-g">
		<div class="am-u-sm-4">余额</div>
		<div class="am-u-sm-8" id="aaaCon2Balance"></div>
	</div>
	<div class="am-g">
		<div class="am-u-sm-4">积分变动</div>
		<div class="am-u-sm-8" id="aaaCon2PointChange"></div>
	</div>
	<div class="am-g">
		<div class="am-u-sm-4">剩余积分</div>
		<div class="am-u-sm-8" id="aaaCon2Point"></div>
	</div>
	<div class="am-g">
		<div class="am-u-sm-4">日期</div>
		<div class="am-u-sm-8" id="aaaCon2Date"></div>
	</div>
	<div class="am-g aaa-3 am-margin-top">
		<button class="am-btn am-btn-primary am-margin-right" id="aaaCon2Cancel">关闭</button>
		<button class="am-btn am-btn-primary" id="aaaCon2Print">打印小票</button>
	</div>
</div>

<!--内容区 尾-->
<hr>
<footer class="admin-content-footer am-padding-top-0">
	<p class="am-padding-left">© 2016-2026 威海盈帆科技有限公司版权所有。</p>
</footer>

<script type="text/html" id="aaaTpl1">
	<button class="am-btn am-btn-default am-btn-xs consume aaa-6" style="margin: 0 3px 3px 0;">
		<span class="am-icon-diamond"></span>
		<span>消费</span>
	</button>
	<button class="am-btn am-btn-default am-btn-xs recharge aaa-6" style="margin: 0 -1px 3px 0;">
		<span class="am-icon-cc-visa"></span>
		<span>充值</span>
	</button>
	<br>
	<button class="am-btn am-btn-default am-btn-xs view aaa-6" style="margin: 0 3px 3px 0;">
		<span class="am-icon-eye"></span>
		<span>查看</span>
	</button>
	{{ if status === '1' }}
	<button class="am-btn am-btn-default am-btn-xs disable aaa-6" style="margin: 0 3px 3px 0; color: red;">
		<span class="am-icon-minus-circle"></span>
		<span>禁用</span>
	</button>
	{{ else }}
	<button class="am-btn am-btn-default am-btn-xs enable aaa-6" style="margin: 0 3px 3px 0; color: green;">
		<span class="am-icon-plus-circle"></span>
		<span>启用</span>
	</button>
	{{ /if }}
</script>

<!--scrollTo lib-->
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
	var aaa = {
		table: undefined,
		rules: [],
		data: {
			search: {
				realname: '',
				phone: '',
				createTimeStart: '',
				createTimeEnd: ''
			},
			add: {
				realname: '',
				birthType: '',
				birthday: '',
				gender: '',
				phone: ''
			},
			edit: {
				id: '',
				realname: '',
				birthType: '',
				birthday: '',
				gender: '',
				phone: ''
			},
			consume: {
				id: '',
				amount: ''
			},
			recharge: {
				id: '',
				amount: ''
			}
		},
		url: {
			isOverBalance: '/index.php/Admin/Member/moneyNo',
			getRules: '/index.php/Admin/Settings/getRechargeRuleList',
			add: '/index.php/Admin/Member/addMember',
			list: '/index.php/Admin/Member/searchMemberList',
			get: '/index.php/Admin/Member/getInfoById',
			edit: '/index.php/Admin/Member/editMemberById',
			consume: '/index.php/Admin/Member/consume',
			recharge: '/index.php/Admin/Member/recharge',
			disable: '/index.php/Admin/Member/setDisable',
			enable: '/index.php/Admin/Member/setEnable'
		},
		drawTable: function (para, resetStart) {
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
				aoData.realname = para.realname;
				aoData.phone = para.phone;
				aoData.createTimeStart = para.createTimeStart;
				aoData.createTimeEnd = para.createTimeEnd;
				if (resetStart)
					aoData.start = 0;
			};
			dt.columns = [
				{data: "id"},
				{data: "cardno"},
				{data: "realname"},
				{data: "phone"},
				{data: "levelname"},
				{data: "balance"},
				{data: "point"},
				{data: "subscribetime"},
				{data: "status"}
			];
			dt.columnDefs = [
				{
					targets: [8],
					data: "cardno",
					render: function (data, type, row) {
						var render = template.compile($('#aaaTpl1').html());
						return render({status: data});
					}
				}];
			dt.ajax.url = aaa.url.list;
			aaa.table = $('#aaaTblCon').find('table').DataTable(dt);
		},
		getRules: function () {
			$.post(aaa.url.getRules, function (res) {
				if (res.code !== 0) {
					if (res.code === 1) {
						// return modal_alert('没有充值赠送规则');
					}
					else {
						return modal_alert(res.msg);
					}
				}

				for (var key in res.data) {
					aaa.rules[key] = [];
					aaa.rules[key]['amount'] = res.data[key]['amount'];
					aaa.rules[key]['gift'] = res.data[key]['giftamount'];
				}
			});
		},
		onLoad: function () {
			$('#aaaSeaTimeStart').datepicker();
			$('#aaaSeaTimeEnd').datepicker();
			aaa.drawTable(aaa.data.search);
			aaa.getRules();
			$('.aaa-8').each(function () {
				var that = $(this);
				var next = that.next();
				next.width((that.parent().width() - that.width() - 20) + 'px');
			});
		},
		clicks: function () {
			// 添加会员
			$(document).off('click', '#aaaAddConOpen').on('click', '#aaaAddConOpen', function () {
				$('#aaaInfCon').addClass('am-hide');
				$('#aaaAddCon').removeClass('am-hide');
				$('.admin-content').scrollTo('#aaaAddCon', 500);
				$('#aaaAddBirth').datepicker();
			});
			false && $(document).off('click', '#aaaAddConClose').on('click', '#aaaAddConClose', function () {
				$('#aaaAddCon').addClass('am-hide');
			});
			$(document).off('click', '#aaaAddSubmit').on('click', '#aaaAddSubmit', function () {
				var name = $('#aaaAddName');
				var birth = $('#aaaAddBirth');
				var phone = $('#aaaAddPhone');

				var nameV = name.val();
				var birthV = birth.val();
				var phoneV = phone.val();

				nameV.trim();
				birthV.trim();
				phoneV.trim();

				if (!nameV || !birthV || !phoneV) {
					return modal_alert('必须全部填写');
				}

				aaa.data.add.realname = nameV;
				aaa.data.add.birthtype = $('input[name="aaaAddBirthType"]:checked').val();
				aaa.data.add.birthday = birthV;
				aaa.data.add.gender = $('input[name="aaaAddSex"]:checked').val();
				aaa.data.add.phone = phoneV;

				$.post(aaa.url.add, aaa.data.add, function (res) {
					if (res.code !== 0)
						return modal_alert(res.msg);

					modal_alert('添加成功');

					name.val('');
					birth.attr('value', ''); // do not use val() !!!
					phone.val('');
					$('input[name=aaaAddBirthType]').filter('[value=1]').prop('checked', true);
					$('input[name=aaaAddSex]').filter('[value=1]').prop('checked', true);
					$('.admin-content').scrollTo(0, 500);
					$('#aaaAddCon').addClass('am-hide');
					aaa.drawTable(aaa.data.search);
				});
			});

			// 搜索
			$(document).off('click', '#aaaSeaSubmit').on('click', '#aaaSeaSubmit', function () {
				var name = $('#aaaSeaName');
				var phone = $('#aaaSeaPhone');
				var start = $('#aaaSeaTimeStart');
				var end = $('#aaaSeaTimeEnd');

				var nameV = name.val();
				var phoneV = phone.val();
				var startV = start.val();
				var endV = end.val();

				nameV.trim();
				phoneV.trim();
				startV.trim();
				endV.trim();

				if (!nameV && !phoneV && !startV && !endV) {
					// return modal_alert('搜索条件不能全部为空');
				}

				aaa.data.search.realname = nameV;
				aaa.data.search.phone = phoneV;
				aaa.data.search.createTimeStart = startV;
				aaa.data.search.createTimeEnd = endV;

				aaa.drawTable(aaa.data.search, true);
			});

			// 查看
			$(document).off('click', '#aaaTblCon table .view').on('click', '#aaaTblCon table .view', function () {
				$('#aaaAddCon').addClass('am-hide');
				$('#aaaInfCon').removeClass('am-hide');
				$('.admin-content').scrollTo('#aaaInfCon', 500);
				var tr = $(this).parent().parent();
				var id = tr.find('td:first-child').text();
				$.post(aaa.url.get, {id: id}, function (res) {
					if (res.code !== 0)
						return modal_alert(res.msg);

					$('#aaaInfoId').val(res.data.id);
					$('#aaaInfoName').val(res.data.realname);
					$('input[name=aaaInfoBirthType]').filter('[value=' + res.data.birthtype + ']').prop('checked', true);
					$('#aaaInfoBirth').datepicker('setValue', res.data.birthday);
					$('input[name=aaaInfoSex]').filter('[value=' + res.data.gender + ']').prop('checked', true);
					$('#aaaInfoPhone').val(res.data.phone);
					$('#aaaInfoCard').val(res.data.cardno);
					$('#aaaInfoRank').val(res.data.levelname);
					$('#aaaInfoBalance').val(res.data.balance);
					$('#aaaInfoPoint').val(res.data.point);
					$('#aaaInfoSpent').val(res.data.amount);
					$('#aaaInfoDate').val(res.data.subscribetime);
				});
			});
			false && $(document).off('click', '#aaaInfConClose').on('click', '#aaaInfConClose', function () {
				$('#aaaInfCon').addClass('am-hide');
			});
			$(document).off('click', '#aaaInfoSubmit').on('click', '#aaaInfoSubmit', function () {
				var id = $('#aaaInfoId').val();

				var name = $('#aaaInfoName');
				var birth = $('#aaaInfoBirth');
				var phone = $('#aaaInfoPhone');
				var cardNo = $('#aaaInfoCard');

				var nameV = name.val();
				var birthV = birth.val();
				var phoneV = phone.val();
				var cardNoV = cardNo.val();

				nameV.trim();
				birthV.trim();
				phoneV.trim();
				cardNoV.trim();

				if (!nameV || !birthV || !phoneV)
					return modal_alert('必须全部填写');

				aaa.data.edit.id = id;
				aaa.data.edit.realname = nameV;
				aaa.data.edit.birthType = $('input[name=aaaInfoBirthType]:checked').val();
				aaa.data.edit.birthday = birthV;
				aaa.data.edit.gender = $('input[name=aaaInfoSex]:checked').val();
				aaa.data.edit.phone = phoneV;
				aaa.data.edit.cardno = cardNoV;

				$.post(aaa.url.edit, aaa.data.edit, function (res) {
					if (res.code !== 0)
						return modal_alert(res.msg);

					modal_alert('修改成功');
					$('#aaaInfCon').addClass('am-hide');
					$('.admin-content').scrollTo(0, 500);
					aaa.drawTable(aaa.data.search);
				});
			});

			// +++ 消费
			$(document).off('click', '#aaaTblCon table .consume').on('click', '#aaaTblCon table .consume', function () {
				$('.mask1').show();
				$('#aaaCon1Con').removeClass('am-hide');
				var tr = $(this).parent().parent();
				var id = tr.find('td:first-child').text();
				$('#aaaCon1Id').val(id);
			});
			$(document).off('click', '#aaaCon1Cancel').on('click', '#aaaCon1Cancel', function () {
				$('.mask1').hide();
				$('#aaaCon1Con').addClass('am-hide');
			});
			$(document).off('click', '#aaaCon2Cancel').on('click', '#aaaCon2Cancel', function () {
				$('.mask1').hide();
				$('#aaaCon2Con').addClass('am-hide');
				aaa.drawTable(aaa.data.search);
			});
			$(document).off('click', '#aaaCon3Cancel').on('click', '#aaaCon3Cancel', function () {
				$('.mask1').hide();
				$('#aaaCon3Con').addClass('am-hide');
			});
			$(document).off('click', '#aaaCon1Submit').on('click', '#aaaCon1Submit', function () {
				var id = $('#aaaCon1Id');
				var amount = $('#aaaCon1Amount');

				var idV = id.val();
				var amountV = amount.val();

				idV.trim();
				amountV.trim();

				if (!amountV)
					return;
				//return modal_alert('请输入金额');

				$.post(aaa.url.isOverBalance, {id: idV, amount: amountV}, function (res) {
					if (res.code !== 0)
						return modal_alert(res.msg);

					$('#aaaCon3Id').val(idV);
					$('#aaaCon3Amount').val(amountV);

					$('#aaaCon1Con').addClass('am-hide');
					$('#aaaCon3Con').removeClass('am-hide');
				});

			});
			$(document).off('click', '#aaaCon3Submit').on('click', '#aaaCon3Submit', function () {
				var id = $('#aaaCon3Id');
				var amount = $('#aaaCon3Amount');

				var idV = id.val();
				var amountV = amount.val();

				idV.trim();
				amountV.trim();

				if (!amountV)
					return modal_alert('请输入金额');

				aaa.data.consume.id = idV;
				aaa.data.consume.amount = amountV;

				$.post(aaa.url.consume, aaa.data.consume, function (res) {
					if (res.code !== 0)
						return modal_alert(res.msg);

					$('#aaaCon3Con').addClass('am-hide');
					$('#aaaCon2Con').removeClass('am-hide');

					id.val('');
					amount.val('');

					$('#aaaCon2Card').text(res.data.cardno);
					$('#aaaCon2Type').text(res.data.typename);
					$('#aaaCon2Amount').text(res.data.amount);
					$('#aaaCon2Balance').text(res.data.balance);
					$('#aaaCon2PointChange').text(res.data.addpoint);
					$('#aaaCon2Point').text(res.data.point);
					$('#aaaCon2Date').text(res.data.createtime);
				});
			});
			$(document).off('click', '#aaaCon2Print').on('click', '#aaaCon2Print', function () {
				$('#aaaCon2Con').print();
			});

			// +++ 充值
			$(document).off('click', '#aaaTblCon table .recharge').on('click', '#aaaTblCon table .recharge', function () {
				$('.mask1').show();
				$('#aaaRec1Con').removeClass('am-hide');
				var tr = $(this).parent().parent();
				var id = tr.find('td:first-child').text();
				var name = tr.find('td').eq(2).text();
				$('#aaaRec1Id').val(id);
				$('#aaaRec1Name').val(name);
			});
			$(document).off('click', '#aaaRec1Cancel').on('click', '#aaaRec1Cancel', function () {
				$('.mask1').hide();
				$('#aaaRec1Con').addClass('am-hide');
			});
			$(document).off('click', '#aaaRec2Cancel').on('click', '#aaaRec2Cancel', function () {
				$('.mask1').hide();
				$('#aaaRec2Con').addClass('am-hide');
				aaa.drawTable(aaa.data.search);
			});
			$(document).off('click', '#aaaRec3Cancel').on('click', '#aaaRec3Cancel', function () {
				$('.mask1').hide();
				$('#aaaRec3Con').addClass('am-hide');
			}); // 3 is actually 1.5, it's an added step
			$(document).off('click', '#aaaRec1Submit').on('click', '#aaaRec1Submit', function () {
				var id = $('#aaaRec1Id');
				var name = $('#aaaRec1Name');
				var amount = $('#aaaRec1Amount');

				var idV = id.val();
				var nameV = name.val();
				var amountV = amount.val();

				idV.trim();
				nameV.trim();
				amountV.trim();

				if (!amountV)
					return;
				//return modal_alert('请输入金额');

				$('#aaaRec3Id').val(idV);
				$('#aaaRec3Name').val(nameV);
				$('#aaaRec3Amount').val(amountV);
				$('#aaaRec3Gift').val('0');
				aaa.rules.forEach(function (value, index, array) {
					if (parseInt(value['amount']) === parseInt(amountV))
						$('#aaaRec3Gift').val(parseInt(value['gift']));
				});

				$('#aaaRec1Con').addClass('am-hide');
				$('#aaaRec3Con').removeClass('am-hide');

				id.val('');
				name.val('');
				amount.val('');
			});
			$(document).off('click', '#aaaRec3Submit').on('click', '#aaaRec3Submit', function () {
				var id = $('#aaaRec3Id');
				var name = $('#aaaRec3Name');
				var amount = $('#aaaRec3Amount');
				var gift = $('#aaaRec3Gift');

				var idV = id.val();
				var nameV = name.val();
				var amountV = amount.val();

				idV.trim();
				nameV.trim();
				amountV.trim();

				if (!amountV)
					return modal_alert('请输入金额');

				//$('#aaaRec3Con').addClass('am-hide');
				//$('#aaaRec2Con').removeClass('am-hide');

				aaa.data.recharge.id = idV;
				aaa.data.recharge.UserName = nameV;
				aaa.data.recharge.amount = amountV;

				$.post(aaa.url.recharge, aaa.data.recharge, function (res) {
					if (res.code !== 0)
						return modal_alert(res.msg);

					$('#aaaRec3Con').addClass('am-hide');
					$('#aaaRec2Con').removeClass('am-hide');

					id.val('');
					amount.val('');
					gift.val('');

					$('#aaaRec2Card').text(res.data.cardno);
					$('#aaaRec2Amount').text(res.data.amount);
					$('#aaaRec2Balance').text(res.data.balance);
					$('#aaaRec2AmountBack').text(res.data.backamount || 0);
					$('#aaaRec2Point').text(res.data.point);
					$('#aaaRec2Date').text(res.data.createtime);
				});

			});
			$(document).off('click', '#aaaRec2Print').on('click', '#aaaRec2Print', function () {
				$('#aaaRec2Con').print();
			});

			// 禁用
			$(document).off('click', '#aaaTblCon table .disable').on('click', '#aaaTblCon table .disable', function () {
				var that = $(this);
				var tr = $(this).parent().parent();
				var id = tr.find('td:first-child').text();
				$.post(aaa.url.disable, {id: id}, function (res) {
					if (res.code !== 0)
						return modal_alert(res.msg);

					that.removeClass('disable').addClass('enable').css('color', 'green').find('span').eq(0).attr('class', 'am-icon-plus-circle');
					that.removeClass('disable').addClass('enable').css('color', 'green').find('span').eq(1).text('启用');
				});
			});

			// 启用
			$(document).off('click', '#aaaTblCon table .enable').on('click', '#aaaTblCon table .enable', function () {
				var that = $(this);
				var tr = $(this).parent().parent();
				var id = tr.find('td:first-child').text();
				$.post(aaa.url.enable, {id: id}, function (res) {
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
		aaa.init();
	});
</script>