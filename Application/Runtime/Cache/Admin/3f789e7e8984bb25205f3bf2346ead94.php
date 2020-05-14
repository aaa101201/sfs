<?php if (!defined('THINK_PATH')) exit();?><style>
	.am-modal-alert {
		z-index: 10000;
	}

	#x-table * {
		text-align: center;
	}

	#x-table th {
		padding: 0.7rem !important;
	}

	.am-popup {
		width: 1400px;
		height: 720px;
		margin-left: -700px;
		margin-top: -360px;
	}

	.am-popup-inner {
		padding-top: 0;
	}
</style>

<!-- 列表 start -->
<div class="admin-content-body">
	<div class="am-cf am-padding am-padding-bottom-0">
		<div class="am-fl am-cf">
			<strong class="am-text-primary am-text-lg">投票管理</strong> /
			<small>投票列表</small>
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
						<th>投票类型</th>
						<th>奖励内容</th>
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
					投票管理
				</h2>
			</div>
			<div data-am-widget="tabs" class="am-tabs am-tabs-default" style="margin-top: 0;">
				<ul class="am-tabs-nav am-cf"
					style="border-left: 1px solid rgb(221, 221, 221);border-right: 1px solid rgb(221, 221, 221);">
					<li class="am-active"><a href="[data-tab-panel-0]">基本信息</a></li>
					<li class=""><a href="[data-tab-panel-1]">投票选项</a></li>
					<li class=""><a href="[data-tab-panel-2]">报名审核</a></li>
				</ul>
				<div class="am-tabs-bd">
					<div data-tab-panel-0 class="am-tab-panel am-active" id="baseInfo">
						<!-- tpl-baseInfo -->
					</div>
					<div data-tab-panel-1 class="am-tab-panel" id="itemsInfo">
						<!-- tpl-voteItems -->
					</div>
					<div data-tab-panel-2 class="am-tab-panel" id="registersInfo">
						<div class="am-g">
							<div class="am-u-sm-12">
								<form class="am-form">
									<table id="y-table"
										   class="am-table am-table-striped am-table-hover table-main">
										<thead>
										<tr>
											<th>id</th>
											<th>投票名称</th>
											<th>选项名称</th>
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
				</div>
			</div>
		</div>
	</div>
</div>
<script src="/Public/scripts/libs/amazeui.js"></script>
<script src="/Public/scripts/vote.js"></script>
<script>
	'use strict';
	var param = {};
	var uploader;
	var voteId = 0;
	var y_table;
	var bool = true;
	$(function () {
		function seeDetail(id) {
			$("#detailTab").html('');
			$("#votePopup").modal();
			var status = 0;
			voteId = id;
			$.ajax({
				url: MOD_PATH + '/Vote/votes',
				data: {'voteId': id},
				async: false,
				success: function (data) {
					if (data) {
						$('#baseInfo').html(template('tpl-baseInfo', data.data[0]));
						status = data.data[0].status;
					}
				}, error: function () {
					modal_alert("操作失败!");
				}
			});
			$.ajax({
				url: MOD_PATH + '/Vote/items',
				data: {'voteId': id},
				async: false,
				success: function (data) {
					//console.log("data is:" + JSON.stringify(data));
					if (data) {
						$('#itemsInfo').html(template('tpl-voteItems', {data: data.data}));
					}
				}, error: function () {
					modal_alert("操作失败!");
				}
			});
			//console.log(bool);
			if (bool) {
				y_table = $('#y-table').DataTable({
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
						url: MOD_PATH + "/Vote/registers?voteId=" + id
					},
					//每页显示三条数据
					pageLength: 10,
					"dom": '<"top">it<"bottom"p><"clear">',
					columns: [
						{"data": "id"},
						{"data": "title"},
						{"data": "name"},
						{"data": "phone"},
						{"data": "intro"}],
					"columnDefs": [{
						"targets": 5,
						"render": function (data, type, row) {
							return template("vote-p_admin-y-table-opt-tpl", row);
						}
					}]
				});
				bool = false;
			} else {
				y_table.ajax.url(MOD_PATH + "/Vote/registers?voteId=" + id).load();
			}
			if (status == 0) {
				$('button.am-btn-primary').removeClass('am-btn-primary').addClass('am-btn-default');
				$('button.removeItem').removeClass('am-btn-danger').addClass('am-btn-default');
			}
			init(id, status);
			$('#y-table tbody').on('click', 'button', function () {
				//console.log('button');
				var data = y_table.row($(this).parents('tr')).data();
				var action = $(this).attr("action");
				var id = data["id"] || -1;
				//console.log('itemid', id);
				if (action == "showItem") {
					showItem(id);
					return;
				}
				if (action == "passItem") {
					passItem(id);
					return;
				}
				if (action == "pauseItem") {
					pauseItem(id);
					return;
				}
			});
		}

		function active(id) {
			$.ajax({
				url: MOD_PATH + '/Vote/updateVote',
				data: {'voteId': id, 'status': 1},
				success: function (data) {
					//console.log("data is:" + data);
					if (data) {
						modal_alert("操作成功");
						$("#x-table").DataTable().ajax.reload();
					}
				}, error: function () {
					modal_alert("操作失败!");
				}
			});
		}

		function over(id) {
			$.ajax({
				url: MOD_PATH + '/Vote/updateVote',
				data: {'voteId': id, 'status': 0},
				success: function (data) {
					if (data) {
						modal_alert("操作成功");
						$("#x-table").DataTable().ajax.reload();
					}
				}, error: function () {
					modal_alert("操作失败!");
				}
			});
		}

		function pause(id) {
			$.ajax({
				url: MOD_PATH + '/Vote/updateVote',
				data: {'voteId': id, 'status': 2},
				success: function (data) {
					if (data) {
						modal_alert("操作成功");
						$("#x-table").DataTable().ajax.reload();
					}
				}, error: function () {
					modal_alert("操作失败!");
				}
			});
		}

		function getVoteURL(id) {
			$.ajax({
				url: MOD_PATH + '/Vote/getVoteUrl',
				data: {'voteId': id},
				success: function (data) {
					//modal_alert(window.location.href.split('index.php')[0] + 'index.php/Home/Vote/vote' + data.data);
					modal_alert(data.data);
				},
				error: function () {
					modal_alert("操作失败!");
				}
			});
		}

		function showItem(voteItemId) {
			$.ajax({
				url: MOD_PATH + '/Vote/registers',
				data: {'voteId': voteId, 'voteItemId': voteItemId},
				success: function (data) {
					if (data) {
						$("#detailTab").html(template('vote-formTemplate', data.data[0]));
					}
				}, error: function () {
					modal_alert("操作失败!");
				}
			});
		}

		function passItem(voteItemId) {
			$.ajax({
				url: MOD_PATH + '/Vote/updateItem',
				data: {'voteItemId': voteItemId, 'status': 1},
				success: function (data) {
					y_table.ajax.url(MOD_PATH + "/Vote/registers?voteId=" + voteId).load();
				}, error: function () {
					modal_alert("操作失败!");
				}
			});
		}

		function pauseItem(voteItemId) {
			$.ajax({
				url: MOD_PATH + '/Vote/updateItem',
				data: {'voteItemId': voteItemId, 'status': 0},
				success: function (data) {
					y_table.ajax.url(MOD_PATH + "/Vote/registers?voteId=" + voteId).load();
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
			columns: [{"data": "id"}, {"data": "title"}, {"data": "type"}, {"data": "reward"}, {"data": "begintime"}, {"data": "endtime"}, {"data": "createtime"}],
			"columnDefs": [{
				"targets": 2,
				"render": function (data, type, row) {
					if (row.type == 0) {
						return '有限投票';
					}
					if (row.type == 1) {
						return '无限投票';
					}
				},
				"className": "table-vote-type"
			}, {
				"targets": 7,
				"render": function (data, type, row) {
					return template("vote-p_admin-x-table-opt-tpl", row);
				}
			}]
		});

		$('#x-table tbody').on('click', 'button', function (e) {
			//e.preventDefault();
			//log('aaa');
			//return;
			var data = table.row($(this).parents('tr')).data();
			var action = $(this).attr("action");
			var id = data["id"] || -1;
			if (action == "seeDetail") {
				seeDetail(id);
				return;
			}
			if (action == "pause") {
				pause(id);
				return;
			}
			if (action == "active") {
				active(id);
				return;
			}
			if (action == "over") {
				over(id);
				return;
			}
			if (action == "getVoteURL") {
				getVoteURL(id);
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
			//console.log(url);
			table.ajax.url(url).load();
		});
		var init = function (id, status) {
			if (status != 0) {
				//dateTime();
				$('#startDate').datetimepicker();
				$('#endDate').datetimepicker();
				createUploader();
				$('#addItem').click(function () {
					addItem();
				});
				removeItem();
				uploadImage();
				$('.updateVote').click(function () {
					updateVote(id);
				});
			}
			itemNum(5);
			// addBanner();
			// removeBanner();
		};
	});
</script>