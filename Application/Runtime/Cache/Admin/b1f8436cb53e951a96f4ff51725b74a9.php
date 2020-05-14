<?php if (!defined('THINK_PATH')) exit();?><style>
	#x-table * {
		text-align: center;
	}
	#x-table th {
		padding: 0.7rem !important;
	}
	.am-popup {
		width: 1000px;
		margin-left: -500px;
	}
</style>

<!-- 列表 start -->
<div class="admin-content-body">
	<div class="am-cf am-padding am-padding-bottom-0">
		<div class="am-fl am-cf">
			<strong class="am-text-primary am-text-lg">投票管理</strong> /
			<small>投票统计</small>
		</div>
	</div>
	<hr>
	<!-- 列表-nav start-->
	<div class="am-g">
		<div class="am-u-sm-12 am-u-md-2">
			<div class="am-form-group am-form-icon">
				<i class="am-icon-calendar"></i> <input id="s-startDate"
														type="text" class="am-form-field am-input-sm" placeholder="开始日期"
														data-am-datepicker>
			</div>
		</div>
		<div class="am-u-sm-12 am-u-md-2">
			<div class="am-form-group am-form-icon">
				<i class="am-icon-calendar"></i> <input id="s-endDate" type="text"
														class="am-form-field am-input-sm" placeholder="结束日期"
														data-am-datepicker>
			</div>
		</div>
		<div class="am-u-sm-12 am-u-md-1" style="float: left;">
			<button id="doSearch" type="button"
					class="am-btn am-btn-primary am-btn-sm">根据创建时间筛选
			</button>
		</div>
	</div>
	<!-- 列表-nav end-->
	<br/>
	<!-- 列表 start-->
	<div class="am-g">
		<div class="am-u-sm-12">
			<form class="am-form">
				<table id="x-table"
					   class="am-table am-table-striped am-table-hover table-main">
					<thead>
					<tr>
						<th>ID</th>
						<th>投票名称</th>
						<th>奖励</th>
						<th>开始时间</th>
						<th>结束时间</th>
						<th>创建时间</th>
						<th>操作</th>
					</tr>
					</thead>
				</table>
			</form>
		</div>
	</div>
	<!-- 列表 end-->
</div>

<!-- detail start -->
<div id='detailForm' class="admin-content-body am-animation-slide-right"></div>
<!-- detail end -->

<footer class="admin-content-footer">
	<hr>
	<p class="am-padding-left">© 2016-2026 山东盈帆信息科技股份有限公司版权所有。</p>
</footer>

<div class="am-popup" id="votePopup">
	<div class="am-popup-inner">
		<div class="am-popup-bd">
			<!--投票创建所需信息表单-->
			<div data-am-widget="titlebar" class="am-titlebar am-titlebar-default">
				<h2 class="am-titlebar-title ">
					投票统计
				</h2>
			</div>
			<div data-am-widget="tabs" class="am-tabs am-tabs-default" style="margin-top: 0;">
				<ul class="am-tabs-nav am-cf"
					style="border-left: 1px solid rgb(221, 221, 221);border-right: 1px solid rgb(221, 221, 221);">
					<li class="am-active"><a href="[data-tab-panel-0]">活动详情</a></li>
					<li class=""><a href="[data-tab-panel-1]">数据统计</a></li>
				</ul>
				<div class="am-tabs-bd">
					<div data-tab-panel-0 class="am-tab-panel am-active">
						<div class="am-g">
							<div class="am-u-sm-12">
								<form class="am-form">
									<table id="y-table"
										   class="am-table am-table-striped am-table-hover table-main">
										<thead>
										<tr>
											<th>序号</th>
											<th>选项名称</th>
											<th>票数</th>
											<th>联系电话</th>
											<th>介绍</th>
											<th>操作</th>
										</tr>
										</thead>
									</table>
								</form>
							</div>
						</div>
						<div id='detailTab' class="admin-content-body am-animation-slide-right"></div>
					</div>
					<div data-tab-panel-1 class="am-tab-panel">
						<div class="am-panel am-panel-default padding-b-60">
							<div class="am-panel-hd am-cf"
								 data-am-collapse="{target: '#collapse-panel-vote_count'}">
								职位申请统计（参与投票人次：<span id="votetimes">1210</span>）<span
									class="am-icon-chevron-down am-fr"></span>
							</div>
							<div id="collapse-panel-vote_count" class="am-in"
								 style="margin: 20px 30px 0 30px;min-height: 500px;">
								<div class="am-u-sm-6">
									<div class="am-u-sm-12 am-u-md-6 padding_0_5">
										<div class="am-form-group am-form-icon">
											<i class="am-icon-calendar"></i> <input id="startDate_vote_count"
																					type="text"
																					class="am-form-field am-input-sm"
																					placeholder=" 开始日期"
																					data-am-datepicker>
										</div>
									</div>
									<div class="am-u-sm-12 am-u-md-6 padding_0_5">
										<div class="am-form-group am-form-icon">
											<i class="am-icon-calendar"></i> <input id="endDate_vote_count" type="text"
																					class="am-form-field am-input-sm"
																					placeholder=" 结束日期"
																					data-am-datepicker>
										</div>
									</div>
								</div>
								<div class="am-form-group am-u-sm-1">
									<button id="voteCountBtn" type="button"
											class="am-btn am-btn-primary am-btn-sm">确认
									</button>
								</div>
								<canvas id="chart_vote_count" width="1600px" height="440px"></canvas>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="/Public/scripts/libs/amazeui.js"></script>
<script src="/Public/scripts/vote.js"></script>
<script src="/Public/scripts/libs/Chart.js"></script>
<script src="/Public/scripts/createVoteChart.js"></script>
<script>
	'use strict';
	var voteId = 0;
	var y_table;
	var bool = true;
	$(function () {
		function seeDetail(id) {
			$("#detailTab").html('');
			$("#votePopup").modal();
			var status = 0;
			voteId = id;
			console.log(bool);
			if (bool) {
				y_table = $('#y-table').DataTable({
					serverSide: true,
					ajax: {
						//指定数据源
						url: MOD_PATH + "/Vote/getVoteData?voteId=" + id
					},
					//每页显示三条数据
					pageLength: 10,
					"dom": '<"top">it<"bottom"p><"clear">',
					columns: [{"data": "id"}, {"data": "title"}, {"data": "total"}, {"data": "phone"}, {"data": "intro"}],
					"columnDefs": [{
						"targets": 5,
						"render": function (data, type, row) {
							return template("vote-p_count-y-table-opt-tpl", row);
						}
					}]
				});
				bool = false;
			} else {
				y_table.ajax.url(MOD_PATH + "/Vote/getVoteData?voteId=" + id).load();
			}
			$('#y-table tbody').on('click', 'button', function () {
				var data = y_table.row($(this).parents('tr')).data();
				var action = $(this).attr("action");
				var id = data["id"] || -1;
				if (action == "showItem") {
					showItem(id);
					return;
				}
			});
			updateVoteChart();
		}

		function showItem(voteItemId) {
			$.ajax({
				url: MOD_PATH + '/Vote/items',
				data: {'voteItemId': voteItemId},
				success: function (data) {
					if (data) {
						$("#detailTab").html(template('vote-formTemplate', data.data[0]));
					}
				}, error: function () {
					modal_alert("操作失败!");
				}
			});
		}

		var table = $('#x-table').DataTable({
			bProcessing: false,
			bAutoWidth: false,
			bInfo: false,
			sPaginationType: "simple_numbers",
			iDisplayLength: 10,
			searching: false,
			bSort: false,
			bLengthChange: false,
			destroy: true,
			bPaginate: true,
			bStateSave: true,
			serverSide: true,
			ajax: {
				//指定数据源
				url: MOD_PATH + "/Vote/votes",
			},
			//每页显示三条数据
			pageLength: 10,
			"dom": '<"top">it<"bottom"p><"clear">',
			columns: [{"data": "id"}, {"data": "title"}, {"data": "reward"}, {"data": "begintime"}, {"data": "endtime"}, {"data": "createtime"}],
			"columnDefs": [{
				"targets": 6,
				"render": function (data, type, row) {
					return template("vote-p_count-x-table-opt-tpl", row);
				}
			}]
		});

		$('#x-table tbody').on('click', 'button', function () {
			var data = table.row($(this).parents('tr')).data();
			var action = $(this).attr("action");
			var id = data["id"] || -1;
			if (action == "seeDetail") {
				seeDetail(id);
				return;
			}
		});

		$('#doSearch').on('click', function () {
			var start = '00:00:00';
			var end = '23:59:59';
			var beginTime = $('#s-startDate').val();
			if (!beginTime == '' || !beginTime == null) {
				beginTime = "'" + beginTime + ' ' + start + "'";
			}
			var endTime = $('#s-endDate').val();
			if (!endTime == '' || !endTime == null) {
				endTime = "'" + endTime + ' ' + end + "'";
			}
			var url = MOD_PATH + "/Vote/votes?beginTime=" + beginTime
				+ "&endTime=" + endTime;
			console.log(url);
			table.ajax.url(url).load();
		});
	});
</script>