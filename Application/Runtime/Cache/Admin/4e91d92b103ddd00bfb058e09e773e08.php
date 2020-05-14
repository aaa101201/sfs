<?php if (!defined('THINK_PATH')) exit();?><style>
	#gggCon {
		max-width: 600px;
	}

	.ggg-1 {
		margin-top: 1rem;
	}
</style>

<!--内容区 头-->
<div class="am-cf am-padding am-padding-bottom-0">
	<div class="am-fl am-cf">
		<strong class="am-text-primary am-text-lg" id="tier-one">修改密码</strong>
	</div>
</div>
<hr>

<!--主容器-->
<div class="admin-content-body">
	<div id="gggCon" class="am-form">
		<div class="am-g ggg-1">
			<div class="am-u-sm-3 am-u-md-3 am-u-lg-3">账号</div>
			<div class="am-u-sm-9 am-u-md-9 am-u-lg-9">
				<input type="text" id="gggAccount" disabled>
			</div>
		</div>
		<div class="am-g ggg-1">
			<div class="am-u-sm-3 am-u-md-3 am-u-lg-3">原密码</div>
			<div class="am-u-sm-9 am-u-md-9 am-u-lg-9">
				<input type="password" id="gggPasswordOld" placeholder="原密码">
			</div>
		</div>
		<div class="am-g ggg-1">
			<div class="am-u-sm-3 am-u-md-3 am-u-lg-3">新密码</div>
			<div class="am-u-sm-9 am-u-md-9 am-u-lg-9">
				<input type="password" id="gggPasswordNew" placeholder="新密码">
			</div>
		</div>
		<div class="am-g ggg-1">
			<div class="am-u-sm-3 am-u-md-3 am-u-lg-3">新密码</div>
			<div class="am-u-sm-9 am-u-md-9 am-u-lg-9">
				<input type="password" id="gggPasswordNewAgain" placeholder="再次输入新密码">
			</div>
		</div>
		<div class="am-g ggg-1">
			<div class="am-u-sm-3 am-u-md-3 am-u-lg-3">&nbsp;</div>
			<div class="am-u-sm-9 am-u-md-9 am-u-lg-9">
				<button id="gggSubmit" class="am-btn am-btn-primary">保存</button>
			</div>
		</div>
	</div>
</div>

<!--内容区 尾-->
<hr>
<footer class="admin-content-footer am-padding-top-0">
	<p class="am-padding-left">© 2016-2026 威海盈帆科技有限公司版权所有。</p>
</footer>

<script>
	var ggg = {
		url: {
			update: '/index.php/Admin/User/updatePassword'
		},
		data: {
			update: {
				passwordold: '',
				password: ''
			}
		},
		onLoad: function () {
			$('#gggAccount').val(getCookie('username'));
		},
		clicks: function () {
			$(document).off('click', '#gggSubmit').on('click', '#gggSubmit', function () {
				var old = $('#gggPasswordOld');
				var neww = $('#gggPasswordNew');
				var neww2 = $('#gggPasswordNewAgain');

				var oldV = old.val();
				var newwV = neww.val();
				var neww2V = neww2.val();

				oldV.trim();
				newwV.trim();
				neww2V.trim();

				if (!oldV || !newwV || !neww2V)
					return modal_alert('必须全部填写');

				if (newwV !== neww2V)
					return modal_alert('新密码填写不相同，请重新输入');

				ggg.data.update.passwordold = oldV;
				ggg.data.update.password = newwV;

				$.post(ggg.url.update, ggg.data.update, function (res) {
					if (res.code !== 0)
						return modal_alert(res.msg);

					modal_alert('修改成功');

					old.val('');
					neww.val('');
					neww2.val('');
				});
			});
		},
		init: function () {
			this.onLoad();
			this.clicks();
		}
	};
	$(function () {
		ggg.init();
	});
</script>