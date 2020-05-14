<?php if (!defined('THINK_PATH')) exit();?><style>
	#bbbTblCon table * {
		text-align: center;
	}

	#bbbTblCon table th {
		padding: 0.7rem !important;
	}

	#bbbTblCon table tr th:first-child,
	#bbbTblCon table tr td:first-child {
		display: none;
	}

	.bbb-1 {
		line-height: 2.7rem;
	}
</style>

<!--内容区 头-->
<div class="am-cf am-padding am-padding-bottom-0">
	<div class="am-fl am-cf">
		<strong class="am-text-primary am-text-lg" id="tier-one">会员管理</strong> /
		<small id="tier-two">消费记录</small>
	</div>
</div>
<hr>

<!--主容器-->
<div class="admin-content-body">
	<div id="bbbSeaCon" class="am-g">
		<div class="am-u-sm-12 am-u-md-1 am-fl">
			<button id="bbbSeaExcel" class="am-btn am-btn-primary am-btn-sm">Excel</button>
		</div>
		<div class="am-u-sm-12 am-u-md-1 am-fr">
			<button id="bbbSeaSubmit" class="am-btn am-btn-primary am-btn-sm am-fr">查询</button>
		</div>
		<div class="am-u-sm-12 am-u-md-10 am-fr">
			<div class="am-u-sm-12 am-u-md-3 am-fr">
				<div class="am-form-group am-form-icon">
					<i class="am-icon-calendar"></i>
					<input id="bbbSeaTimeEnd" type="text" class="am-form-field am-input-sm" placeholder="结束时间" readonly>
				</div>
			</div>
			<div class="am-u-sm-12 am-u-md-3 am-fr">
				<div class="am-form-group am-form-icon">
					<i class="am-icon-calendar"></i>
					<input id="bbbSeaTimeStart" type="text" class="am-form-field am-input-sm" placeholder="开始时间"
						   readonly>
				</div>
			</div>
			<div class="am-u-sm-12 am-u-md-3 am-fr">
				<span class="bbb-1 am-fl">手机号：</span>
				<input id="bbbSeaPhone" placeholder="手机号" type="text"
					   class="am-form-field am-input-sm am-fl">
			</div>
			<div class="am-u-sm-12 am-u-md-3 am-fr">
				<span class="bbb-1 am-fl">姓名：</span>
				<input id="bbbSeaName" placeholder="姓名" type="text"
					   class="am-form-field am-input-sm am-fl">
			</div>
		</div>
	</div>
	<div id="bbbTblCon" class="am-margin-top">
		<table class="am-table am-table-striped am-table-hover table-main">
			<thead>
			<tr>
				<th>ID</th>
				<th style="width: 20%;">卡号</th>
				<th style="width: 15%;">姓名</th>
				<th style="width: 15%;">手机号</th>
				<th style="width: 15%;">金额</th>
				<!--<th style="width: 15%;">消费类型</th>-->
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
	var bbb = {
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
			list: '/index.php/Admin/Member/consumeRecord'
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
//				{data: "typename"},
				{data: "createtime"}
			];
			dt.ajax.url = bbb.url.list;
			bbb.table = $('#bbbTblCon').find('table').DataTable(dt);
		},
		onLoad: function () {
			$('#bbbSeaTimeStart').datepicker();
			$('#bbbSeaTimeEnd').datepicker();
			bbb.drawTable(bbb.data.search);
			$('.bbb-1').each(function () {
				var that = $(this);
				var next = that.next();
				next.width((that.parent().width() - that.width() - 20) + 'px');
			});
		},
		clicks: function () {
			// 搜索
			$(document).off('click', '#bbbSeaSubmit').on('click', '#bbbSeaSubmit', function () {
				var name = $('#bbbSeaName');
				var phone = $('#bbbSeaPhone');
				var start = $('#bbbSeaTimeStart');
				var end = $('#bbbSeaTimeEnd');

				var nameV = name.val();
				var phoneV = phone.val();
				var startV = start.val();
				var endV = end.val();

				// if (!nameV || !phoneV)
				// return modal_alert('搜索条件不能全部为空');

				bbb.data.search.realname = nameV;
				bbb.data.search.phone = phoneV;
				bbb.data.search.createTimeStart = startV;
				bbb.data.search.createTimeEnd = endV;

				bbb.drawTable(bbb.data.search, true);
			});
		},
		init: function () {
			this.onLoad();
			this.clicks();
		}
	};

	$(function () {
		bbb.init();
	});
</script>