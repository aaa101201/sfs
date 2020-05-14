<?php if (!defined('THINK_PATH')) exit();?><style>
	.admin-content {
		overflow: auto;
	}

	#VoteAddCon {
		max-width: 700px;
	}

	.VoteAdd-1 {
		margin-top: 1rem;
	}

	.VoteAdd-2 {
		border: 1px solid rgba(204, 204, 204, 1);
		padding: 1.5rem;
		margin-left: 0 !important;
		width: 100% !important;
		width: 1200px !important;
	}

	.VoteAdd-3 {
		/*for jquery*/
	}
</style>

<input type="file" id="file1" class="am-hide">
<input type="file" multiple id="file2" class="am-hide">

<!--内容区 头-->
<div class="am-cf am-padding am-padding-bottom-0">
	<div class="am-fl am-cf">
		<strong class="am-text-primary am-text-lg" id="tier-one">投票管理</strong> /
		<small id="tier-two">新建投票</small>
	</div>
</div>
<hr>

<!--主容器-->
<div class="admin-content-body">
	<div id="VoteAddCon" class="am-form">
		<div class="am-g VoteAdd-1 am-hide">
			<div class="am-u-sm-3 am-u-md-3 am-u-lg-3">公司名称</div>
			<div class="am-u-sm-9 am-u-md-9 am-u-lg-9">
				<input type="text" id="VoteAddCompanyName" placeholder="公司名称">
			</div>
		</div>
		<div class="am-g VoteAdd-1">
			<div class="am-u-sm-3 am-u-md-3 am-u-lg-3">标题</div>
			<div class="am-u-sm-9 am-u-md-9 am-u-lg-9">
				<input type="text" id="VoteAddTitle" placeholder="标题">
			</div>
		</div>
		<div class="am-g VoteAdd-1">
			<div class="am-u-sm-3 am-u-md-3 am-u-lg-3">时间</div>
			<div class="am-u-sm-9 am-u-md-9 am-u-lg-9">
				<input type="text" id="VoteAddTimeStart" placeholder="开始时间" readonly style="width: 49%; float: left;">
				<input type="text" id="VoteAddTimeEnd" placeholder="结束时间" readonly style="width: 49%; float: right;">
			</div>
		</div>
		<div class="am-g VoteAdd-1">
			<div class="am-u-sm-3 am-u-md-3 am-u-lg-3">规则</div>
			<div class="am-u-sm-9 am-u-md-9 am-u-lg-9">
				<textarea id="VoteAddRule" placeholder="规则" style="min-height: 100px;"></textarea>
			</div>
		</div>
		<div class="am-g VoteAdd-1">
			<div class="am-u-sm-3 am-u-md-3 am-u-lg-3">奖励</div>
			<div class="am-u-sm-9 am-u-md-9 am-u-lg-9">
				<input type="text" id="VoteAddPrize" placeholder="奖励">
			</div>
		</div>
		<!--another con-->
		<div class="am-g VoteAdd-1">
			<div class="am-u-sm-3 am-u-md-3 am-u-lg-3">选项</div>
			<div class="am-u-sm-9 am-u-md-9 am-u-lg-9">
				<div class="am-g VoteAdd-2">
					<div class="am-g">
						<div class="am-u-sm-4 am-u-md-2 am-text-center">标题</div>
						<div class="am-u-sm-4 am-u-md-2 am-text-center">手机</div>
						<div class="am-u-sm-4 am-u-md-2 am-text-center">权重</div>
						<div class="am-u-sm-4 am-u-md-3 am-text-center">描述</div>
						<div class="am-u-sm-4 am-u-md-1 am-text-center">图片</div>
						<div class="am-u-sm-4 am-u-md-1 am-text-center">预览</div>
						<div class="am-u-sm-4 am-u-md-1 am-text-center">操作</div>
					</div>
					<div class="am-g VoteAdd-1 am-hide" id="VoteAddCloneMe">
						<div class="am-u-sm-4 am-u-md-2 am-text-center">
							<input type="text" value="" placeholder="标题" class="VoteAddNewItemTitle">
						</div>
						<div class="am-u-sm-4 am-u-md-2 am-text-center">
							<input type="text" value="" placeholder="手机" class="VoteAddNewItemPhone">
						</div>
						<div class="am-u-sm-4 am-u-md-2 am-text-center">
							<input type="number" value="" placeholder="权重" min="0" step="1"
								   class="VoteAddNewItemWeight">
						</div>
						<div class="am-u-sm-4 am-u-md-3 am-text-center">
							<textarea placeholder="描述" style="height: 3rem; overflow: hidden;"
									  class="VoteAddNewItemDesc"></textarea>
						</div>
						<div class="am-u-sm-4 am-u-md-1 am-text-center">
							<button type="button" class="am-btn am-btn-default VoteAddNewItemUpload">上传</button>
						</div>
						<div class="am-u-sm-4 am-u-md-1 am-text-center">
							<img src="/Public/images/llg-1.png" class="VoteAddNewItemPreview"
								 style="width: 3rem; height: 3rem;">
						</div>
						<div class="am-u-sm-4 am-u-md-1 am-text-center">
							<button type="button" class="am-btn am-btn-default VoteAddNewItemDel" disabled>删除</button>
						</div>
					</div>
					<button class="am-btn am-btn-primary am-margin-top" id="VoteAddNewItemAdd">添加</button>
				</div>
			</div>
		</div>
		<div class="am-g VoteAdd-1">
			<div class="am-u-sm-3 am-u-md-3 am-u-lg-3">类型1</div>
			<div class="am-u-sm-9 am-u-md-9 am-u-lg-9">
				<input type="radio" name="VoteAddType1" value="0" checked> 有限
				&nbsp;&nbsp;&nbsp;
				<input type="radio" name="VoteAddType1" value="1"> 无限
			</div>
		</div>
		<div class="am-g VoteAdd-1">
			<div class="am-u-sm-3 am-u-md-3 am-u-lg-3">类型2</div>
			<div class="am-u-sm-9 am-u-md-9 am-u-lg-9">
				<input type="radio" name="VoteAddType2" value="0" checked> 单选
				&nbsp;&nbsp;&nbsp;
				<input type="radio" name="VoteAddType2" value="1"> 多选
			</div>
		</div>
		<div class="am-g VoteAdd-1 am-hide" id="VoteAddType2NumCon">
			<div class="am-u-sm-3 am-u-md-3 am-u-lg-3">多选数目</div>
			<div class="am-u-sm-9 am-u-md-9 am-u-lg-9">
				<select id="VoteAddType2Num"></select>
			</div>
		</div>
		<div class="am-g VoteAdd-1 am-hide">
			<div class="am-u-sm-3 am-u-md-3 am-u-lg-3">轮播图</div>
			<div class="am-u-sm-9 am-u-md-9 am-u-lg-9">
				<button type="button" class="am-btn am-btn-default am-btn-sm" id="VoteAddSlidesUpload">
					<i class="am-icon-cloud-upload"></i>
					请选择图片
				</button>
			</div>
		</div>
		<div class="am-g VoteAdd-1">
			<div class="am-u-sm-3 am-u-md-3 am-u-lg-3">&nbsp;</div>
			<div class="am-u-sm-9 am-u-md-9 am-u-lg-9">
				<button id="VoteAddSubmit" class="am-btn am-btn-primary">保存</button>
			</div>
		</div>
	</div>
</div>

<!--内容区 尾-->
<hr>
<footer class="admin-content-footer am-padding-top-0">
	<p class="am-padding-left">© 2016-2026 威海盈帆科技有限公司版权所有。</p>
</footer>

<script type="text/html" id="VoteAddTpl1">
	<option value="1" selected>1</option>
	{{ each data }}
	{{ if $value > 1 }}
	<option value="{{ $value }}">{{ $value }}</option>
	{{ /if }}
	{{ /each }}
</script>

<script>
	var VoteAdd = {
		file1: $('#file1'),
		file2: $('#file2'),
		toWhere: null,
		url: {
			add: '/index.php/Admin/Vote/addVote',
			upload1: '/index.php/Admin/File/upload',
			upload2: '/index.php/Admin/File/uploadWithtThumb'
		},
		forSelect: function () {
			var length = $('.VoteAddNewItemDel').length - 1; // 1 is hidden for clean clone
			var data = [0];
			var i = 1;
			while (i <= length) {
				data[i] = i;
				i++;
			}
			var render = template.compile($('#VoteAddTpl1').html());
			var html = render({data: data});
			$('#VoteAddType2Num').html(html);
		},
		onLoad: function () {
			$('#VoteAddTimeStart').datetimepicker({format: 'yyyy-mm-dd hh:ii:ss'});
			$('#VoteAddTimeEnd').datetimepicker({format: 'yyyy-mm-dd hh:ii:ss'});
			VoteAdd.forSelect();
			$('#VoteAddNewItemAdd').before($('#VoteAddCloneMe').clone().removeClass('am-hide').addClass('VoteAdd-3'));
			this.forSelect();
		},
		clicks: function () {
			// 添加选项
			$(document).off('click', '#VoteAddNewItemAdd').on('click', '#VoteAddNewItemAdd', function () {
				var that = $(this);
				that.before($('#VoteAddCloneMe').clone().removeClass('am-hide').addClass('VoteAdd-3'));
				$('.VoteAddNewItemDel').each(function (index, item) {
					if (index !== 1)
						$(this).attr('disabled', false);
				});
				VoteAdd.forSelect();
			});

			// 删除选项
			$(document).off('click', '.VoteAddNewItemDel').on('click', '.VoteAddNewItemDel', function () {
				var that = $(this);
				that.parent().parent().remove();
				VoteAdd.forSelect();
			});

			// 多选显示多选数目 单选隐藏多选数目
			$(document).off('click', 'input[name=VoteAddType2]').on('click', 'input[name=VoteAddType2]', function () {
				if ($(this).val() === '1') {
					$('#VoteAddType2NumCon').removeClass('am-hide');
				}
				else {
					$('#VoteAddType2NumCon').addClass('am-hide');
					$('#VoteAddType2Num').val('1');
				}
			});

			// 选项图片上传
			VoteAdd.file1.unbind().change(function () {
				if (VoteAdd.file1.get(0).files.length === 0)
					return;
				var formData = new FormData();
				formData.append('file', VoteAdd.file1.get(0).files[0]); // $_POST['postKey']
				$.ajax({
					url: VoteAdd.url.upload1,
					type: 'post',
					data: formData,
					contentType: false,
					processData: false,
					cache: false,
					success: function (res) {
						VoteAdd.toWhere.attr('src', res.CDNPath);
					},
					fail: function (res) {
						//
					},
					complete: function () {
						VoteAdd.file1.val('');
					}
				});
			});
			$(document).off('click', '.VoteAddNewItemUpload').on('click', '.VoteAddNewItemUpload', function () {
				VoteAdd.toWhere = $(this).parent().next().find('img');
				VoteAdd.file1.click();
			});

			// 轮播图片文件上传
			VoteAdd.file2.unbind().change(function () {
				if (VoteAdd.file2.get(0).files.length === 0)
					return;
				var formData = new FormData();
				$.each(VoteAdd.file2.get(0).files, function (i, item) {
					formData.append('file', item);
				});
				$.ajax({
					url: VoteAdd.url.upload2,
					type: 'post',
					data: formData,
					contentType: false,
					processData: false,
					cache: false,
					success: function (res) {
						log(res);
					},
					fail: function (res) {
						//
					},
					complete: function () {
						VoteAdd.file2.val('');
					}
				});
			});
			$(document).off('click', '#VoteAddSlidesUpload').on('click', '#VoteAddSlidesUpload', function () {
				VoteAdd.file2.click();
			});

			// 提交
			$(document).off('click', '#VoteAddSubmit').on('click', '#VoteAddSubmit', function () {
				var companyName = $('#VoteAddCompanyName');
				var title = $('#VoteAddTitle');
				var timeStart = $('#VoteAddTimeStart');
				var timeEnd = $('#VoteAddTimeEnd');
				var rule = $('#VoteAddRule');
				var prize = $('#VoteAddPrize');
				// VoteAddType1
				// VoteAddType2
				var type2Num = $('#VoteAddType2Num');
				var options = [];

				var titleV = title.val().trim();
				var timeStartV = timeStart.val().trim();
				var timeEndV = timeEnd.val().trim();
				var ruleV = rule.val().trim();
				var prizeV = prize.val().trim();
				$('.VoteAdd-3').each(function (index, item) {
					var a = {}; // not [] !!!
					var titleInner = $(this).find('.VoteAddNewItemTitle');
					var phone = $(this).find('.VoteAddNewItemPhone');
					var weight = $(this).find('.VoteAddNewItemWeight');
					var desc = $(this).find('.VoteAddNewItemDesc');
					var preview = $(this).find('.VoteAddNewItemPreview');
					a["title"] = titleInner.val();
					a["phone"] = phone.val();
					a["weight"] = weight.val();
					a["intro"] = desc.val();
					a["image"] = preview.attr('src');
					options.push(a);
				});

				if (!titleV || !timeStartV || !timeEndV || !ruleV || !prizeV || options === [])
					return modal_alert('必须全部填写');

				var data = {
					title: title.val(),
					beginTime: timeStart.val(),
					endTime: timeEnd.val(),
					info: rule.val(),
					reward: prize.val(),
					type: $('input[name=VoteAddType1]:checked').val(),
					num: type2Num.val(),
					//items: JSON.stringify(options)
					items: options
				};
				$.post(VoteAdd.url.add, data, function (res) {
					return modal_alert(res.msg);
					if (res.code !== 0)
						return modal_alert(res.msg);
				});
			});
		},
		init: function () {
			this.onLoad();
			this.clicks();
		}
	};
	$(function () {
		VoteAdd.init();
	});
</script>