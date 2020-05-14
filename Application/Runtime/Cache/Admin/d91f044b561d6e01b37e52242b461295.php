<?php if (!defined('THINK_PATH')) exit();?><style>
	.admin-content {
		position: relative;
	}

	#hhhTblCon table * {
		text-align: center;
	}

	#hhhTblCon table th {
		padding: 0.7rem !important;
	}

	#hhhTblCon table tr th:first-child,
	#hhhTblCon table tr td:first-child {
		display: none;
	}

	#hhhAddCon,
	#hhhEditCon {
		position: fixed;
		top: 50%;
		left: 50%;
		width: 360px;
		margin-top: -170px;
		margin-left: -180px;
		background-color: rgba(221, 221, 221, .99);
		background-color: white;
		border: 1px solid rgba(189, 189, 189, .99);
		padding: 2rem 2rem 3rem;
		z-index: 1200;
	}

	.hhh-1 {
		margin-top: 0;
		text-align: center;
	}

	.hhh-2 {
		line-height: 3rem;
	}

	.hhh-3 {
		text-align: center;
	}

	.hhh-5 {
		position: absolute;
		top: -1.5rem;
		right: -1.5rem;
		width: 3rem;
		height: 3rem;
		cursor: pointer;
		display: none;
	}

</style>

<!--内容区 头-->
<div class="am-cf am-padding am-padding-bottom-0">
	<div class="am-fl am-cf">
		<strong class="am-text-primary am-text-lg" id="tier-one">充值优惠设置</strong>
	</div>
	<button id="hhhAddConOpen" class="am-btn am-btn-primary am-btn-sm am-fr">新建规则</button>
</div>
<hr>

<!--主容器-->
<div class="admin-content-body">
	<div id="hhhTblCon" class="am-margin-top">
		<table class="am-table am-table-striped am-table-hover table-main">
			<thead>
			<tr>
				<th>ID</th>
				<th>充值</th>
				<th>赠送</th>
				<th>建立时间</th>
				<th style="width: 15%;">操作</th>
			</tr>
			</thead>
		</table>
	</div>
</div>

<!--弹窗容器-->

<!--规则添加-->
<div id="hhhAddCon" class="am-form am-hide">
	<img src="/Public/images/llg-2.png" id="hhhAddConClose" class="hhh-5">
	<h2 class="hhh-1">新建充值优惠规则</h2>
	<div class="am-g">
		<div class="am-u-sm-3 hhh-2">充值</div>
		<div class="am-u-sm-9">
			<input type="number" placeholder="" id="hhhAddAmount">
		</div>
	</div>
	<div class="am-g" style="margin-top: 1rem;">
		<div class="am-u-sm-3 hhh-2">赠送</div>
		<div class="am-u-sm-9">
			<input type="number" placeholder="" id="hhhAddGift">
		</div>
	</div>
	<div class="am-g hhh-3 am-margin-top">
		<button class="am-btn am-btn-primary am-margin-right" id="hhhAddCancel">取消</button>
		<button class="am-btn am-btn-primary" id="hhhAddSubmit">确认</button>
	</div>
</div>

<!--规则修改-->
<div id="hhhEditCon" class="am-form am-hide">
	<input type="hidden" id="hhhEditId">
	<img src="/Public/images/llg-2.png" id="hhhEditConClose" class="hhh-5">
	<h2 class="hhh-1">修改充值优惠规则</h2>
	<div class="am-g">
		<div class="am-u-sm-3 hhh-2">充值</div>
		<div class="am-u-sm-9">
			<input type="number" placeholder="" id="hhhEditAmount" readonly>
		</div>
	</div>
	<div class="am-g" style="margin-top: 1rem;">
		<div class="am-u-sm-3 hhh-2">赠送</div>
		<div class="am-u-sm-9">
			<input type="number" placeholder="" id="hhhEditGift">
		</div>
	</div>
	<div class="am-g hhh-3 am-margin-top">
		<button class="am-btn am-btn-primary am-margin-right" id="hhhEditCancel">取消</button>
		<button class="am-btn am-btn-primary" id="hhhEditSubmit">确认</button>
	</div>
</div>

<!--内容区 尾-->
<hr>
<footer class="admin-content-footer am-padding-top-0">
	<p class="am-padding-left">© 2016-2026 威海盈帆科技有限公司版权所有。</p>
</footer>

<script type="text/html" id="hhhTpl1">
	<button class="am-btn am-btn-default am-btn-xs edit" style="margin: 0 3px 3px 0;">
		<span class="am-icon-edit"></span>
		<span>编辑</span>
	</button>
	{{ if status === '1' }}
	<button class="am-btn am-btn-default am-btn-xs disable" style="margin: 0 3px 3px 0; color: red;">
		<span class="am-icon-minus-circle"></span>
		<span>禁用</span>
	</button>
	{{ else }}
	<button class="am-btn am-btn-default am-btn-xs disable" style="margin: 0 3px 3px 0; color: green;">
		<span class="am-icon-plus-circle"></span>
		<span>启用</span>
	</button>
	{{ /if }}
</script>

<script>
	var hhh = {
		table: undefined,
		data: {
			add: {
				amount: '',
				giftamount: ''
			},
			edit: {
				id: '',
				giftamount: ''
			}
		},
		url: {
			add: '/index.php/Admin/Settings/addRechargeRule',
			list: '/index.php/Admin/Settings/getRechargeRuleList',
			get: '/index.php/Admin/Settings/getRechargeRuleById',
			edit: '/index.php/Admin/Settings/editRechargeRuleById',
			enable: '/index.php/Admin/Settings/setRechargeRuleEnable',
			disable: '/index.php/Admin/Settings/setRechargeRuleDisable',
		},
		drawTable: function (para) {
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
				bPaginate: false,
				serverSide: true,
				bStateSave: true,
				ajax: {
					"dataSrc": function (json) {
						return json.data || []; // extremely important, when 0 records found in back end, i get code=1 and error msg, and no data
					}
				},
				sServerMethod: "POST",
				fnServerParams: function (aoData) {
					//aoData.start = 1;
				}
			};
			dt.columns = [
				{data: "id"},
				{data: "amount"},
				{data: "giftamount"},
				{data: "createtime"},
				{data: "status"}
			];
			dt.columnDefs = [
				{
					targets: [4],
					data: "status",
					render: function (data, type, row) {
						var render = template.compile($('#hhhTpl1').html());
						return render({status: data});
					}
				}];
			dt.ajax.url = hhh.url.list;
			hhh.table = $('#hhhTblCon').find('table').DataTable(dt);
		},
		onLoad: function () {
			hhh.drawTable(hhh.data.search);
		},
		clicks: function () {
			// 禁用
			$(document).off('click', '#hhhTblCon table .disable').on('click', '#hhhTblCon table .disable', function () {
				var that = $(this);
				var tr = $(this).parent().parent();
				var id = tr.find('td:first-child').text();
				$.post(hhh.url.disable, {id: id}, function (res) {
					if (res.code !== 0)
						return modal_alert(res.msg);

					that.removeClass('disable').addClass('enable').css('color', 'green').find('span').eq(0).attr('class', 'am-icon-plus-circle');
					that.removeClass('disable').addClass('enable').css('color', 'green').find('span').eq(1).text('启用');
				});
			});

			// 启用
			$(document).off('click', '#hhhTblCon table .enable').on('click', '#hhhTblCon table .enable', function () {
				var that = $(this);
				var tr = $(this).parent().parent();
				var id = tr.find('td:first-child').text();
				$.post(hhh.url.enable, {id: id}, function (res) {
					if (res.code !== 0)
						return modal_alert(res.msg);

					that.removeClass('enable').addClass('disable').css('color', 'red').find('span').eq(0).attr('class', 'am-icon-minus-circle');
					that.removeClass('enable').addClass('disable').css('color', 'red').find('span').eq(1).text('禁用');
				});
			});

			//

			// 新建 打开
			$(document).off('click', '#hhhAddConOpen').on('click', '#hhhAddConOpen', function () {
				$('.mask1').show();
				$('#hhhAddCon').removeClass('am-hide');
			});

			// 新建 取消
			$(document).off('click', '#hhhAddCancel').on('click', '#hhhAddCancel', function () {
				$('.mask1').hide();
				$('#hhhAddCon').addClass('am-hide');
			});

			// 新建 确认
			$(document).off('click', '#hhhAddSubmit').on('click', '#hhhAddSubmit', function () {
				var amount = $('#hhhAddAmount');
				var gift = $('#hhhAddGift');

				var amountV = amount.val();
				var giftV = gift.val();

				amountV.trim();
				giftV.trim();

				if (!amountV || !giftV)
					return modal_alert('必须全部填写');

				hhh.data.add.amount = amountV;
				hhh.data.add.giftamount = giftV;

				$.post(hhh.url.add, hhh.data.add, function (res) {
					if (res.code !== 0)
						return modal_alert(res.msg);

					$('#hhhAddCancel').click();
					amount.val('');
					gift.val('');

					hhh.drawTable(hhh.data.search);
				});
			});

			//

			// 编辑 打开
			$(document).off('click', '#hhhTblCon table .edit').on('click', '#hhhTblCon table .edit', function () {
				var tr = $(this).parent().parent();
				var id = tr.find('td:first-child').text();
				$.post(hhh.url.get, {id: id}, function (res) {
					if (res.code !== 0)
						return modal_alert(res.msg);

					$('#hhhEditId').val(res.data.id);
					$('#hhhEditAmount').val(res.data.amount);
					$('#hhhEditGift').val(res.data.giftamount);

					$('.mask1').show();
					$('#hhhEditCon').removeClass('am-hide');
				});
			});

			// 编辑 取消
			$(document).off('click', '#hhhEditCancel').on('click', '#hhhEditCancel', function () {
				$('.mask1').hide();
				$('#hhhEditCon').addClass('am-hide');
			});

			// 编辑 确认
			$(document).off('click', '#hhhEditSubmit').on('click', '#hhhEditSubmit', function () {
				var amount = $('#hhhEditAmount');
				var gift = $('#hhhEditGift');

				var amountV = amount.val();
				var giftV = gift.val();

				amountV.trim();
				giftV.trim();

				if (!amountV || !giftV)
					return modal_alert('必须全部填写');

				hhh.data.edit.id = $('#hhhEditId').val();
				hhh.data.edit.giftamount = giftV;

				$.post(hhh.url.edit, hhh.data.edit, function (res) {
					if (res.code !== 0)
						return modal_alert(res.msg);

					$('#hhhEditCancel').click();
					amount.val('');
					gift.val('');

					hhh.drawTable(hhh.data.search);
				});
			});
		},
		init: function () {
			this.onLoad();
			this.clicks();
		}
	};
	$(function () {
		hhh.init();
	});
</script>