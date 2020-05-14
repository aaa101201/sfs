<?php if (!defined('THINK_PATH')) exit();?><style>
	#fffCon {
		max-width: 600px;
	}

	.fff-1 {
		margin-top: 1rem;
	}

	.fff-1 div:nth-child(1) {
		text-align: right;
	}

	#fffLicense {
		width: 100%;
		cursor: pointer;
	}
</style>

<!--内容区 头-->
<div class="am-cf am-padding am-padding-bottom-0">
	<div class="am-fl am-cf">
		<strong class="am-text-primary am-text-lg" id="tier-one">商户信息</strong>
	</div>
</div>
<hr>

<!--主容器-->
<div class="admin-content-body">
	<div id="fffCon" class="am-form">
		<div class="am-g fff-1">
			<div class="am-u-sm-3 am-u-md-3 am-u-lg-3">真实姓名</div>
			<div class="am-u-sm-9 am-u-md-9 am-u-lg-9">
				<input type="text" id="fffName" readonly>
			</div>
		</div>
		<div class="am-g fff-1">
			<div class="am-u-sm-3 am-u-md-3 am-u-lg-3">公司名</div>
			<div class="am-u-sm-9 am-u-md-9 am-u-lg-9">
				<input type="text" id="fffCompany" readonly>
			</div>
		</div>
		<div class="am-g fff-1">
			<div class="am-u-sm-3 am-u-md-3 am-u-lg-3">法人手机号</div>
			<div class="am-u-sm-9 am-u-md-9 am-u-lg-9">
				<input type="text" id="fffPhone" readonly>
			</div>
		</div>
		<div class="am-g fff-1">
			<div class="am-u-sm-3 am-u-md-3 am-u-lg-3">公司座机</div>
			<div class="am-u-sm-9 am-u-md-9 am-u-lg-9">
				<input type="text" id="fffTelephone" readonly>
			</div>
		</div>
		<div class="am-g fff-1">
			<div class="am-u-sm-3 am-u-md-3 am-u-lg-3">省</div>
			<div class="am-u-sm-9 am-u-md-9 am-u-lg-9">
				<div id="fffProvince">
					<select>
						<option>全部</option>
					</select>
				</div>
			</div>
		</div>
		<div class="am-g fff-1">
			<div class="am-u-sm-3 am-u-md-3 am-u-lg-3">市</div>
			<div class="am-u-sm-9 am-u-md-9 am-u-lg-9">
				<div id="fffCity">
					<select>
						<option>全部</option>
					</select>
				</div>
			</div>
		</div>
		<div class="am-g fff-1">
			<div class="am-u-sm-3 am-u-md-3 am-u-lg-3">区</div>
			<div class="am-u-sm-9 am-u-md-9 am-u-lg-9">
				<div id="fffDistrict">
					<select>
						<option>全部</option>
					</select>
				</div>
			</div>
		</div>
		<div class="am-g fff-1">
			<div class="am-u-sm-3 am-u-md-3 am-u-lg-3">详细地址</div>
			<div class="am-u-sm-9 am-u-md-9 am-u-lg-9">
				<input type="text" id="fffAddress">
			</div>
		</div>
		<div class="am-g fff-1">
			<div class="am-u-sm-3 am-u-md-3 am-u-lg-3">公司简介</div>
			<div class="am-u-sm-9 am-u-md-9 am-u-lg-9">
				<input type="text" id="fffIntro">
			</div>
		</div>
		<div class="am-g fff-1">
			<div class="am-u-sm-3 am-u-md-3 am-u-lg-3">营业执照</div>
			<div class="am-u-sm-9 am-u-md-9 am-u-lg-9">
				<img src="/Public/images/llg-1.png" id="fffLicense">
			</div>
		</div>
		<div class="am-g fff-1">
			<div class="am-u-sm-3 am-u-md-3 am-u-lg-3">&nbsp;</div>
			<div class="am-u-sm-9 am-u-md-9 am-u-lg-9">
				<button id="fffSubmit" class="am-btn am-btn-primary">保存</button>
			</div>
		</div>
	</div>
</div>

<!--内容区 尾-->
<hr>
<footer class="admin-content-footer am-padding-top-0">
	<p class="am-padding-left">© 2016-2026 威海盈帆科技有限公司版权所有。</p>
</footer>

<script type="text/html" id="fffTpl1">
	<select>
		{{ each data }}
		<option value="{{ $value.id }}">{{ $value.name }}</option>
		{{ /each }}
	</select>
</script>

<script>
	var fff = {
		file: $('#fff-file'),
		data: {
			edit: {
				provinceId: '',
				cityId: '',
				regionId: '',
				address: '',
				description: '',
				licenceImgURL: ''
			}
		},
		url: {
			file: '/index.php/Admin/File/upload',
			get: '/index.php/Admin/Shop/getShopInfoByLogin',
			edit: '/index.php/Admin/Shop/updateShopInfoByLogin',
			getProvince: '/index.php/Admin/Gp/getProvince',
			getCity: '/index.php/Admin/Gp/getCities',
			getDistrict: '/index.php/Admin/Gp/getRegions'
		},
		setCity: function (pid) {
			$.post(fff.url.getCity, {pid: pid}, function (res) {
				var render = template.compile($('#fffTpl1').html());
				var html = render({data: res});
				$('#fffCity').html(html);
			});
		},
		setDistrict: function (cid) {
			$.post(fff.url.getDistrict, {cid: cid}, function (res) {
				var render = template.compile($('#fffTpl1').html());
				var html = render({data: res});
				$('#fffDistrict').html(html);
			});
		},
		onLoad: function () {
			$.post(fff.url.get, function (res) {
				if (res.code !== 0)
					return modal_alert(res.msg);

				if (!res.data)
					return;

				var t = res.data[0];

				$('#fffName').val(t.realname);
				$('#fffCompany').val(t.name);
				$('#fffPhone').val(t.phone);
				$('#fffTelephone').val(t.telephone);
				$('#fffAddress').val(t.address);
				$('#fffIntro').val(t.description);
				t.licenceimgurl && $('#fffLicense').attr('src', t.licenceimgurl);

				$.post(fff.url.getProvince, function (resInner) {
					var render = template.compile($('#fffTpl1').html());
					var html = render({data: resInner});
					$('#fffProvince').html(html).promise().done(function () {
						$('#fffProvince').find('select').val(t.provinceid);
					});
				});

				if (t.provinceid === '0') {
					$('#fffCity').find('select option').selected();
					$('#fffDistrict').find('select option').selected();
					return;
				}

				if (t.cityid === '0')
					return;

				$.post(fff.url.getCity, {pid: t.provinceid}, function (resInner) {
					var render = template.compile($('#fffTpl1').html());
					var html = render({data: resInner});
					$('#fffCity').html(html).promise().done(function () {
						$('#fffCity').find('select').val(t.cityid);
					});
				});

				if (t.regionid === '0')
					return;

				$.post(fff.url.getDistrict, {cid: t.cityid}, function (resInner) {
					var render = template.compile($('#fffTpl1').html());
					var html = render({data: resInner});
					$('#fffDistrict').html(html).promise().done(function () {
						$('#fffDistrict').find('select').val(t.regionid);
					});
				});
			});
		},
		clicks: function () {
			$(document).off('change', '#fffProvince select').on('change', '#fffProvince select', function () {
				var pid = $(this).val();
				if (pid === '0')
					return;

				fff.setCity(pid);
			});
			$(document).off('change', '#fffCity select').on('change', '#fffCity select', function () {
				var cid = $(this).val();
				if (cid === '0')
					return;

				fff.setDistrict(cid);
			});
			$(document).off('click', '#fffLicense').on('click', '#fffLicense', function () {
				$('#fff-file').click();
			});
			$(document).off('click', '#fffSubmit').on('click', '#fffSubmit', function () {
				var province = $('#fffProvince');
				var city = $('#fffCity');
				var district = $('#fffDistrict');
				var address = $('#fffAddress');
				var intro = $('#fffIntro');

				fff.data.edit.provinceId = province.find('select').val();
				fff.data.edit.cityId = city.find('select').val();
				fff.data.edit.regionId = district.find('select').val();
				fff.data.edit.address = address.val();
				fff.data.edit.description = intro.val();

				$.post(fff.url.edit, fff.data.edit, function (res) {
					if (res.code !== 0)
						return modal_alert(res.msg);

					modal_alert('修改成功');
				});
			});
			fff.file.unbind().change(function () {
				if (fff.file.get(0).files.length === 0)
					return;
				var formData = new FormData();
				formData.append('file', fff.file.get(0).files[0]);
				$.ajax({
					url: fff.url.file,
					type: 'post',
					data: formData,
					contentType: false,
					processData: false,
					cache: false,
					success: function (res) {
						// CDNPath, localPath
						fff.data.edit.licenceImgURL = res.localPath;
						$('#fffLicense').attr('src', res.localPath);
					},
					fail: function (res) {
						//
					},
					complete: function () {
						fff.file.val('');
					}
				});
			});
		},
		init: function () {
			this.onLoad();
			this.clicks();
		}
	};
	$(function () {
		fff.init();
	});
</script>

<input type="file" id="fff-file" style="display: none;">