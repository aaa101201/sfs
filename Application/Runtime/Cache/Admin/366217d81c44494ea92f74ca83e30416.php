<?php if (!defined('THINK_PATH')) exit();?><style>
	#cccTblCon table * {
		text-align: center;
	}

	#cccTblCon table tr th:first-child,
	#cccTblCon table tr td:first-child {
		display: none;
	}

	.ccc-1 {
		line-height: 2.7rem;
	}

	#cccTblCon table th {
		padding: 0.7rem !important;
	}
</style>

<!--内容区 头-->
<div class="am-cf am-padding am-padding-bottom-0">
	<div class="am-fl am-cf">
		<strong class="am-text-primary am-text-lg" id="tier-one">会员管理</strong> /
		<small id="tier-two">充值记录</small>
	</div>
</div>
<hr>

<!--主容器-->
<div class="admin-content-body">
	<div id="cccSeaCon" class="am-g">
		<div class="am-u-sm-12 am-u-md-1 am-fl">
			<button id="cccSeaExcel" class="am-btn am-btn-primary am-btn-sm">Excel</button>
		</div>
		<div class="am-u-sm-12 am-u-md-1 am-fr">
			<button id="cccSeaSubmit" class="am-btn am-btn-primary am-btn-sm am-fr">查询</button>
		</div>
		<div class="am-u-sm-12 am-u-md-10 am-fr">
			<div class="am-u-sm-12 am-u-md-3 am-fr">
				<div class="am-form-group am-form-icon">
					<i class="am-icon-calendar"></i>
					<input id="cccSeaTimeEnd" type="text" class="am-form-field am-input-sm" placeholder="结束时间" readonly>
				</div>
			</div>
			<div class="am-u-sm-12 am-u-md-3 am-fr">
				<div class="am-form-group am-form-icon">
					<i class="am-icon-calendar"></i>
					<input id="cccSeaTimeStart" type="text" class="am-form-field am-input-sm" placeholder="开始时间"
						   readonly>
				</div>
			</div>
			<div class="am-u-sm-12 am-u-md-3 am-fr">
				<span class="ccc-1 am-fl">手机号：</span>
				<input id="cccSeaPhone" placeholder="手机号" type="text"
					   class="am-form-field am-input-sm am-fl">
			</div>
			<div class="am-u-sm-12 am-u-md-3 am-fr">
				<span class="ccc-1 am-fl">姓名：</span>
				<input id="cccSeaName" placeholder="姓名" type="text"
					   class="am-form-field am-input-sm am-fl">
			</div>
		</div>
	</div>
	<div id="cccTblCon" class="am-margin-top">
		<table class="am-table am-table-striped am-table-hover table-main">
			<thead>
			<tr>
				<th>ID</th>
				<th style="width: 20%;">卡号</th>
				<th style="width: 15%;">姓名</th>
				<th style="width: 15%;">手机号</th>
				<th style="width: 15%;">充值金额</th>
				<th style="width: 15%;">赠送金额</th>
				<th style="width: 20%;">时间</th>
			</tr>
			</thead>
		</table>
	</div>
</div>

<!--内容区 尾-->
<hr>
<footer class="admin-content-footer am-padding-top-0">
	<p class="am-padding-left">© 2016-2026 威海盈帆科技有限公司版权所有。</p>
</footer>

<script>
	var ccc = {
		table: undefined,
		data: {
			search: {
				realname: '',
				phone: '',
				createTimeStart: '',
				createTimeEnd: ''
			}
		},
		url: {
			list: '/index.php/Admin/Member/rechargeRecord'
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
				{data: "amount"},
				{data: "addamount"},
				{data: "createtime"}
			];
			dt.ajax.url = ccc.url.list;
			ccc.table = $('#cccTblCon').find('table').DataTable(dt);
		},
		onLoad: function () {
			$('#cccSeaTimeStart').datepicker();
			$('#cccSeaTimeEnd').datepicker();
			ccc.drawTable(ccc.data.search);
			$('.ccc-1').each(function () {
				var that = $(this);
				var next = that.next();
				next.width((that.parent().width() - that.width() - 20) + 'px');
			});
		},
		clicks: function () {
			// 搜索
			$(document).off('click', '#cccSeaSubmit').on('click', '#cccSeaSubmit', function () {
				var name = $('#cccSeaName');
				var phone = $('#cccSeaPhone');
				var start = $('#cccSeaTimeStart');
				var end = $('#cccSeaTimeEnd');

				var nameV = name.val();
				var phoneV = phone.val();
				var startV = start.val();
				var endV = end.val();

				// if (!nameV || !phoneV)
				// return modal_alert('搜索条件不能全部为空');

				ccc.data.search.realname = nameV;
				ccc.data.search.phone = phoneV;
				ccc.data.search.createTimeStart = startV;
				ccc.data.search.createTimeEnd = endV;

				ccc.drawTable(ccc.data.search, true);
			});
		},
		init: function () {
			this.onLoad();
			this.clicks();
		}
	};
	$(function () {
		ccc.init();
	});
</script>