/* globals $, console, server_error, APP_PATH, reRenderCitylist */
'use strict';

/*
*	This file mainly contains 3 modules.
*	The first on is for validate the form.
*	The second one is for submitting the form.
*	The third one is for scrolling the page when people click the 'btn_contact'.
*/

/*重写*/
$.toast = function(msg, duration, extraclass) {
    var $toast = $('<div class="modal toast ' + (extraclass || '') + '">' + msg + '</div>').appendTo(document.body);
    $.openModal($toast, function(){
        setTimeout(function() {
            $.closeModal($toast);
        }, duration || 2000);
    });
    return $toast;
};
var T = function (posturl) {
	this.posturl = posturl;
	this.f = document.forms[0];
	this.phonenumber = '400-886-3334';
	this.modal = null;
};

T.prototype.isempty = function () {
	var i = 0, e = null;

	for (; i < this.f.elements.length; i += 1) {
		e = this.f.elements[i];
		if (e.type !== 'fieldset' && e.type !== 'submit' && e.type !== 'button' && (!e.name.trim() || !e.value.trim())) {
			return true;
		}
	}
	return false;
};
T.prototype.islegal = function () {
	var phone = this.f.phone.value,
	mobile_is_valid = !!phone.match(/^(0|86|17951)?(13[0-9]|15[012356789]|17[0-9]|18[0-9]|14[57])[0-9]{8}$/),
	tel_is_valid = !!phone.match(/^(\d{3}-|\d{4}-)?\d{7,8}$/);
	if (mobile_is_valid || tel_is_valid) {
		return true;
	}
	return false;
};
T.prototype.postForm = function () {
	var data = new FormData(this.f),
	that = this;

	$.ajax({
	    url: APP_PATH + this.posturl,
	    type: 'POST',
	    cache: false,
	    data: data,
	    processData: false,
	    contentType: false,
	    success: function (res) {
	    	if (res.code === 1) {
	    		$.toast('我们将及时与您联系~', 1000);
	    		that.f.reset();
	    		if (that.f.cityId) {
	    			reRenderCitylist();
	    		}
	    		$('.upsuccess').hide();
				$('.upsuccess').removeClass('rubberBand');
				$.closeModal(that.modal);
	    	} else if (res.code === 2) {
	    		$.toast('换张图片试试~', 1000);
	    		$.closeModal(that.modal);
	    	} else {
	    		$.toast('提交失败，请稍后再试~', 1000);
	    		$.closeModal(that.modal);
	    	}
	    },
	    error: function () {
	    	$.toast('服务器出了点问题~');
	    	$.closeModal(that.modal);
	    }
	});
};

var initT = function (t, btn_sub, btn_call, btn_pt, se) {
	btn_sub.click(function () {
		if (t.isempty()) {
			$.toast('您提交的信息不完整~', 1000);
		} else if (!t.islegal()) {
			$.toast('您的联系电话格式不正确~', 1000);
		} else {
			t.modal = $.toast('信息提交中...', 100000);
			t.postForm();
		}
	});
	btn_call.click(function () {
		location.href = 'tel:' + t.phonenumber;
	});
	btn_pt.click(function () {
		var d = se.scrollHeight || se.scrollHeight,
		t = se.clientHeight || se.clientHeight;
		var scrollTo = function (target) {
			console.log('count');
			var timer = setTimeout(function () {
				var current = se.scrollTop;
				var step = 20;
				var dist = 0, next = 0;
				if (target > current) {
					dist = Math.ceil((target - current) / step);
					next = current + dist;
					if (next < target) {
						se.scrollTop = next;
						scrollTo(target);
					} else {
						se.scrollTop = target;
						clearTimeout(timer);
					}
				} else {
					dist = Math.floor((target - current) / step);
					next = current + dist;
					if (next > target) {
						se.scrollTop = next;
						scrollTo(target);
					} else {
						se.scrollTop = target;
						clearTimeout(timer);
					}
				}
			}, 1);
		}; 
		scrollTo(d - t); 
	});
	if ($('#file')) {
		$('#file').change(function () {
			console.log(this.value);
			$('.upsuccess').show();
			$('.upsuccess').addClass('rubberBand');
		});
	}
};