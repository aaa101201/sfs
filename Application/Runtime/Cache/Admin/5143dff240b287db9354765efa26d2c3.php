<?php if (!defined('THINK_PATH')) exit();?><style>
	#dddTblCon table * {
		text-align: center;
	}

	#dddTblCon table th {
		padding: 0.7rem !important;
	}

	#dddTblCon table tr th:first-child,
	#dddTblCon table tr td:first-child {
		display: none;
	}

	.ddd-1 {
		line-height: 2.7rem;
	}
</style>

<!--内容区 头-->
<div class="am-cf am-padding am-padding-bottom-0">
	<div class="am-fl am-cf">
		<strong class="am-text-primary am-text-lg" id="tier-one">会员管理</strong> /
		<small id="tier-two">积分变动记录</small>
	</div>
</div>
<hr>

<!--主容器-->
<div class="admin-content-body">
	<div id="dddSeaCon" class="am-g">
		<div class="am-u-sm-12 am-u-md-1 am-fl">
			<button id="dddSeaExcel" class="am-btn am-btn-primary am-btn-sm">Excel</button>
		</div>
		<div class="am-u-sm-12 am-u-md-1 am-fr">
			<button id="dddSeaSubmit" class="am-btn am-btn-primary am-btn-sm am-fr">查询</button>
		</div>
		<div class="am-u-sm-12 am-u-md-10 am-fr">
			<div class="am-u-sm-12 am-u-md-3 am-fr">
				<div class="am-form-group am-form-icon">
					<i class="am-icon-calendar"></i>
					<input id="dddSeaTimeEnd" type="text" class="am-form-field am-input-sm" placeholder="结束时间" readonly>
				</div>
			</div>
			<div class="am-u-sm-12 am-u-md-3 am-fr">
				<div class="am-form-group am-form-icon">
					<i class="am-icon-calendar"></i>
					<input id="dddSeaTimeStart" type="text" class="am-form-field am-input-sm" placeholder="开始时间"
						   readonly>
				</div>
			</div>
			<div class="am-u-sm-12 am-u-md-3 am-fr">
				<span class="ddd-1 am-fl">手机号：</span>
				<input id="dddSeaPhone" placeholder="手机号" type="text"
					   class="am-form-field am-input-sm am-fl">
			</div>
			<div class="am-u-sm-12 am-u-md-3 am-fr">
				<span class="ddd-1 am-fl">姓名：</span>
				<input id="dddSeaName" placeholder="姓名" type="text"
					   class="am-form-field am-input-sm am-fl">
			</div>
		</div>
	</div>
	<div id="dddTblCon" class="am-margin-top">
		<table class="am-table am-table-striped am-table-hover table-main">
			<thead>
			<tr>
				<th>ID</th>
				<th style="width: 20%;">卡号</th>
				<th style="width: 15%;">姓名</th>
				<th style="width: 15%;">手机号</th>
				<th style="width: 15%;">变动值</th>
				<!--<th style="width: 15%;">说明</th>-->
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
	var ddd = {
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
			list: '/index.php/Admin/Member/pointRecord'
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
				{data: "point"},
//				{data: "remark"},
				{data: "createtime"}
			];
			dt.ajax.url = ddd.url.list;
			ddd.table = $('#dddTblCon').find('table').DataTable(dt);
		},
		onLoad: function () {
			$('#dddSeaTimeStart').datepicker();
			$('#dddSeaTimeEnd').datepicker();
			ddd.drawTable(ddd.data.search);
			$('.ddd-1').each(function () {
				var that = $(this);
				var next = that.next();
				next.width((that.parent().width() - that.width() - 20) + 'px');
			});
		},
		clicks: function () {
			// 搜索
			$(document).off('click', '#dddSeaSubmit').on('click', '#dddSeaSubmit', function () {
				var name = $('#dddSeaName');
				var phone = $('#dddSeaPhone');
				var start = $('#dddSeaTimeStart');
				var end = $('#dddSeaTimeEnd');

				var nameV = name.val();
				var phoneV = phone.val();
				var startV = start.val();
				var endV = end.val();

				// if (!nameV || !phoneV)
				// return modal_alert('搜索条件不能全部为空');

				ddd.data.search.realname = nameV;
				ddd.data.search.phone = phoneV;
				ddd.data.search.createTimeStart = startV;
				ddd.data.search.createTimeEnd = endV;

				ddd.drawTable(ddd.data.search, true);
			});
		},
		init: function () {
			this.onLoad();
			this.clicks();
		}
	};

	$(function () {
		ddd.init();
	});
</script>