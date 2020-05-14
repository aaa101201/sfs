var dateTime = function () {
	var startDate = $('#startDate');
	var endDate = $('#endDate');
	startDate.datetimepicker();
	endDate.datetimepicker({
		useCurrent: false
	});
	startDate.on('dp.change', function (e) {
		endDate.data('DateTimePicker').minDate(e.date);
	});
	endDate.on('dp.change', function (e) {
		startDate.data('DateTimePicker').maxDate(e.date);
	});
};
var addItem = function () {
	$('.voteli').append(template('voteItem-tpl', {}));
};
var removeItem = function () {
	$('.voteli').on('click', '.removeItem', function () {
		$(this).parent().parent().remove();
	});
};
var itemNum = function (num) {
	var i = 1, html = '';
	for (; i <= num; i++) {
		html += '<option value="' + i + '">' + i + '</option>';
	}
	$('#itemNum').html(html);
};
var addVote = function () {
	var checkBool = checkForm();
	if (checkBool) {
		$.ajax({
			type: "POST",
			dataType: "json",
			url: MOD_PATH + '/Vote/addVote',
			data: param,
			success: function (res) {
				if (res.code == 1) {
					showModal('投票创建成功');
					//window.location.reload();
				} else {
					showModal('投票创建失败');
				}
			},
			error: function () {
				showModal('投票创建失败');
			}
		});
	}
};
var checkForm = function () {
	param.items = [];
	//param.banner = [];
	//var company = $('#company').val().trim();
	// if(!company || company==''){
	//     showModal('公司名称不能为空！');
	//     return false;
	// }
	//param.company = company;
	var title = $('#title').val().trim();
	if (!title || title == '') {
		showModal('投票标题不能为空！');
		return false;
	}
	param.title = title;
	var startDate = $('#startDate').val();
	if (!startDate || startDate == '') {
		showModal('请选择投票开始时间~');
		return false;
	}
	param.beginTime = startDate;
	var endDate = $('#endDate').val();
	if (!endDate || endDate == '') {
		showModal('请选择投票截止时间~');
		return false;
	}
	param.endTime = endDate;
	var info = $('#info').val().trim();
	if (!info || info == '') {
		showModal('投票规则说明不能为空');
		return false;
	}
	param.info = info;
	var reward = $('#reward').val().trim();
	param.reward = reward;
	var flag = true;
	$('.voteli li').each(function () {
		var itemTitle = $(this).find('.itemTitle').val().trim();
		var itemPhone = $(this).find('.itemPhone').val().trim();
		var itemWeight = $(this).find('.itemWeight').val().trim();
		var itemIntro = $(this).find('.itemIntro').val().trim();
		var itemImg = $(this).find('.itemImg').val().trim();
		if (!itemTitle || title == '' || !itemIntro || itemIntro == '') {
			showModal('选项名称和选项说明均不能为空');
			flag = false;
		}
		// if(!isMobile(itemPhone)){
		//     showModal('请检查手机号码格式');
		//     flag = false;
		// }
		//console.log($(this).find('.itemId').val());
		if ($(this).find('.itemId').val() != '') {
			var itemId = $(this).find('.itemId').val();
		} else {
			var itemId = 0;
		}
		//console.log('itemId',itemId);
		itemImg = itemImg.split('&');
		param.items.push({
			voteItemId: itemId,
			title: itemTitle,
			phone: itemPhone,
			weight: itemWeight,
			intro: itemIntro,
			image: itemImg[0],
			thumbImage: itemImg[1]
		});
	});
	//console.log('flag',flag);
	if (!flag)return false;
	if ($('input[name="voteType"]:checked')) {
		param.type = $('input[name="voteType"]:checked').attr("value");
	}
	singleormore = $('input[name="voteTimes"]:checked').attr("value");
	//console.log(singleormore);
	switch (singleormore) {
		case "0":
			param.num = 1;
			break;
		case "1":
			param.num = $('#itemNum').val();
			break;
	}
	// $('#banner .am-u-sm-4').each(function(){
	//     var itemTitle = $(this).find('img');
	//     console.log(itemTitle);
	//     if(!itemTitle){
	//         showModal('请上传轮播图~');
	//     }
	//     param.banner.push(itemTitle.attr('src'));
	// });
	//console.log(param);
	return true;
};
var showModal = function (text) {
	$('#modal-alert').on('open.modal.amui', function () {
		$(this).find(".am-modal-hd").html("萝卜兼职");
		$(this).find(".am-modal-bd").html(text);
	});
	$('#modal-alert').modal();
};
var uploadImage = function () {
	$('.voteli').on('click', '.upBtn', function () {
		var thisImg = $(this);
		$('#fileBtn input').click();
		uploader.off('uploadSuccess').on('uploadSuccess', function (file, response) {
			if (response.code == '0') {
				thisImg.parent().children('input').val(response.localPath + '&' + response.localPath);
			} else {
				modal_alert('上传失败');
			}
		});
		uploader.on('error', function (type) {
			if (type == "Q_TYPE_DENIED") {
				modal_alert("gif,jpg,jpeg,bmp,png");
			} else if (type == "F_EXCEED_SIZE") {
				modal_alert("文件大小不能超过8M");
			}
		});
	});
};
var createUploader = function () {
	uploader = WebUploader.create({
		auto: true,
		duplicate: true,
		multiple: false,
		//server : MOD_PATH+'/File/uploadWithtThumb',
		server: MOD_PATH + '/File/upload',
		fileSingleSizeLimit: 8 * 1024 * 1024,
		compress: {
			noCompressIfLarger: false,
			compressSize: 0,
		},
		formData: {},
		accept: {
			title: 'Images',
			extensions: 'gif,jpg,jpeg,bmp,png',
			mimeTypes: 'image/*'
		}

	});
	uploader.addButton({
		id: '#fileBtn',
	});
};
var addBanner = function () {
	$('#uploadBanner').on('click', function () {
		$('#fileBtn input').click();
		uploader.off('uploadSuccess').on('uploadSuccess', function (file, response) {
			if (response.code == '1') {
				var html = '<div class="am-u-sm-4 am-u-sm-uncentered">\
                                <img class="am-thumbnail" src="' + response.CDNPath + '" alt=""/>\
                            <div class="delete-icon">x</div></div>';
				$('#banner').append(html);
			} else {
				modal_alert('上传失败');
			}
		});
		uploader.on('error', function (type) {
			if (type == "Q_TYPE_DENIED") {
				modal_alert("gif,jpg,jpeg,bmp,png");
			} else if (type == "F_EXCEED_SIZE") {
				modal_alert("文件大小不能超过8M");
			}
		});
	});
};
var removeBanner = function () {
	$('#banner').on('click', '.delete-icon', function (event) {
		$(this).parent().remove();
	});
};
var isMobile = function (text) {
	return /^((17[0-9])|(14[0-9])|(13[0-9])|(15[^4,\D])|(18[0-9]))\d{8}$/.test(text);
};
var updateVote = function (id) {
	var checkBool = checkForm();
	//console.log(checkBool);
	param.voteId = id;
	//console.log(param);
	if (checkBool) {
		$.ajax({
			type: "POST",
			dataType: "json",
			url: MOD_PATH + '/Vote/updateVote',
			data: param,
			success: function (res) {
				// code: 1, msg: "修改投票成功!"
				if (res.code !== 1)
					modal_alert(res.msg);
				modal_alert('保存成功');
			}
		});
	}
};
