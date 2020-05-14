'use strict';

var CON_PATH = "__CONTROLLER__";
var CON_PATH = "/index.php/Home/Vote";

$(function () {
	$(document).on('pageInit', '#statistics', function (e, id, page) {
		console.log('inited page::', 'statistics');
		var vote_id = getParam('id', 0);

		//for creating the chart
		var hasloaded = loadChart();
		var ctx = document.getElementById('bar').getContext('2d');
		if (hasloaded) {
			getRank();
		}
		else {
			window.chart_script.onload = getRank;
		}

		var pageSize = 10,
			currPage = 1,
			loading = false,
			maxItems = 10;

		var lastIndex = 10;

		//clear the list-block
		$('#votedUsers').empty();
		//init add
		addItems();

		//binding infinite scroll event
		$(document).on('infinite', '.infinite-scroll', function () {
			if (loading) return;
			loading = true;
			setTimeout(function () {
				loading = false;
				if (lastIndex >= maxItems) {
					$.detachInfiniteScroll($('.infinite-scroll'));
					$('.infinite-scroll-preloader').remove();
					return;
				}
				addItems();
				lastIndex = $('#votedUsers li').length;
				$.refreshScroller();
			}, 500);
		});

		function getRank() {
			$.ajax({
				method: 'POST',
				url: CON_PATH + '/votedBI',
				datatype: 'json',
				data: {id: vote_id},
				success: function (res) {
					console.log('votedBI:res', res);
					if (res.code !== 0) {
						var data = res.data;
						createBar(ctx, data, ['voteitemid', 'total', 'title'], 3); //3指定想要显示的横坐标数
					}
				}
			});
		}

		function addItems() {
			$.ajax({
				method: 'POST',
				url: CON_PATH + '/VotedUser',
				dataType: 'json',
				data: {id: vote_id, page: currPage, pageSize: pageSize},
				success: function (res) {
					//console.log('VotedUser:res', res);
					if (res.code !== 0) {
						var users = res.data.data;
						maxItems = res.data.total;

						//$('#votedUsers').append(template('tpl-voted', {datas: users}));
						$('#votedUsers').html(template('tpl-voted', {datas: users}));
						currPage++;

						//judge is enough or not
						if (lastIndex >= maxItems) {
							$.detachInfiniteScroll($('.infinite-scroll'));
							$('.infinite-scroll-preloader').remove();
							return;
						}
					}
				}
			});
		}
	});

	$(document).on('pageInit', '#vote', function (e, id, page) {
		//console.log('inited page::', 'vote');
		var vote_id = getParam('id', 0), vote_subType = getParam('num', 1);
		var vote_type = 0;  //0:有限 1:无限
		var url_part = CON_PATH + '/statistics?id=' + vote_id;

		$.ajax({
			type: 'GET',
			url: CON_PATH + '/user',
			dataType: 'json',
			success: function (res) {
				console.log('user:res', res);
				if (res.code !== 0) {
					var user_info = res.data;
					$('#user_info').html(template('tpl-userinfo', {data: user_info}));
					console.log(user_info.sex);
				}
			},
			error: function (xhr) {
				console.warn(xhr);
			}
		});

		$.ajax({
			type: 'POST',
			url: CON_PATH + '/detail',
			dataType: 'json',
			data: {
				id: vote_id,
				type: vote_type
			},
			success: function (res) {
				console.log('detail:res', res);
				if (res.code !== 0) {
					var votes = res.data.items;
					$('#vote_title').html(res.data.title);
					var addInfo = '<span class="f12">(最多选' + vote_subType + '项)</span>';
					$('#vote_info').html(res.data.info.replace(/\n/g, '<br>').replace(/\s/g, '&nbsp;') + addInfo);
					if (parseInt(vote_subType) === 1) {
						//alert( vote_type);
						$('#votes').html(template('tpl-single-votes', {datas: votes}));
					} else {
						$('#votes').html(template('tpl-multi-votes', {datas: votes}));
						limit(vote_subType);
					}
					// addTipForLong();
				}
			}
		});

		$.ajax({
			type: 'POST',
			url: CON_PATH + '/isVoted',
			data: {"id": vote_id},
			dataType: 'json',
			success: function (res) {
				console.log('isVoted:res', res);
				if (res.code === 1 && res.data) {
					var know = $('#know_others');
					know.css({'visibility': 'visible'}).attr('href', url_part);
				}
			}
		});

		$.ajax({
			type: 'POST',
			url: CON_PATH + '/voteStatistics',
			data: {"id": vote_id},
			dataType: 'json',
			success: function (res) {
				console.log('voteStatistics:res', res);
				if (res.code !== 0) {
					var data = res.data;
					var item_num = data.joinCount,
						vote_num = data.votedCount,
						visit_num = data.accessCount;
					$('#item_num').html(item_num || 0);
					$('#vote_num').html(vote_num || 0);
					$('#visit_num').html(visit_num || 0);
				}
			}
		});

		$('#submit').on('click', function (e) {

			var items = $('input[name="radio"]:checked'), itemId = [];

			//console.log(items)

			if (items.length === 0) return false;
			if (items.length > vote_subType) {
				$.toast('您最多选择' + vote_subType + '项~');
				return false;
			}

			if (items.length > 1) {
				items.map(function (index, item) {
					itemId.push(item.value);
				});
				itemId = itemId.join(',');
			} else {
				itemId = items.val();
			}

			$.ajax({
				type: 'POST',
				url: CON_PATH + '/submit',
				data: {"id": vote_id, "itemId": itemId, "type": vote_type},
				dataType: 'json',
				success: function (res) {
					if (res.code === 0) {
						$.toast("您已经投过票啦!");
					} else {
						$.toast("投票成功, 感谢您的参与!");
					}
					//window.location.href=window.location.href+"?id="+10000*Math.random();
					var know = $('#know_others');
					know.css({'visibility': 'visible'}).attr('href', url_part);

				},
				error: function (xhr) {
					console.warn(xhr);
				}
			});
		});

		function addTipForLong() {
			$('#votes').on('click', 'label', function () {
				var items = $('#votes').find('label');

				setTimeout(function () {
					items.each(function (key, item) {
						var input = $(item).find('input');
						var subtitle = $(item).find('.item-subtitle');
						console.log(input[0].checked);
						if (input[0].checked === true) {
							subtitle[0].style.cssText = 'white-space:normal; height: 5rem;';
						} else {
							subtitle[0].style.cssText = 'white-space:nowrap;';
						}
					});
				}, 0);
			});
		}

		function limit(num) {
			var labels = $('label'), checks = $('input[name="checkbox"]');
			labels.click(function (e) {
				var checked = $('input[name="checkbox"]:checked');
				if (checked.length >= num) {
					checks.attr('disabled', true);
					checked.removeAttr('disabled');
				} else {
					checks.removeAttr('disabled');
				}
			});
		}
	});

	//初始化
	$.init();

	/*-------------------------------------通用函数库-------------------------------------------------------------------------
	 ---------------------------------------供各页面调用------------------------------------------------------------------------*/
	function createBar(ctx, originData, attrs, num) {

		var colors = [
			'rgba(255, 99, 132, 0.8)',
			'rgba(54, 162, 235, 0.8)',
			'rgba(255, 206, 86, 0.8)',
			'rgba(75, 192, 192, 0.8)',
			'rgba(153, 102, 255, 0.8)',
			'rgba(255, 159, 64, 0.8)'
		];

		var temp = plunk(originData, attrs);

		if (num) {
			for (var key in temp) {
				temp[key] = temp[key].slice(0, num);
			}
		}

		temp.colors = temp[attrs[0]].map(function (value, index) {
			return colors[index % (num || 6)];
		});

		var labels = null;
		if (labels = temp[attrs[2]]) {
			labels = labels.map(function (label) {
				label = label.replace(/(&nbsp;)+/g, ' ');
				if (label.length < 5) {
					return label;
				} else {
					return label.slice(0, 4) + '..';
				}
			});
		}
		temp[attrs[2]] = labels;

		var data = {
			labels: temp[attrs[2] || attrs[0]],
			datasets: [{
				label: '投票统计',
				backgroundColor: temp.colors,
				data: temp[attrs[1]]
			}]
		};
		var options = {
			legend: {
				display: false
			},
			scales: {
				yAxes: [{
					type: 'linear',
					ticks: {
						min: 0
					}
				}]
			}
		};

		var myBar = new Chart(ctx, {
			type: 'bar',
			data: data,
			options: options
		});
	}

	function plunk(arr, wants) {
		var attrs = (typeof wants === 'string') ? [wants] : wants;
		if (!arr || !attrs || attrs.length === 0) {
			console.log('func plunk: 参数格式不正确\n' + 'arr: ' + arr + '\nattrs: ' + attrs);
			return false;
		}

		if (typeof arr === 'object') {
			var l = attrs.length, i = 0, results = {};
			for (; i < l; i++) {
				results[attrs[i]] = [];
				arr.forEach(function (data) {
					results[attrs[i]].push(data[attrs[i]]);
				});
			}
			return results;
		}
	}

	function loadChart() {
		var script = document.getElementById('chart_script');
		if (!script) {
			var chart_script = document.createElement('script');
			chart_script.setAttribute('id', 'chart_script');
			document.body.appendChild(chart_script);
			chart_script.setAttribute('src', '/Public/vote/js/Chart.bundle.min.js');

			window.chart_script = chart_script;
			return false;
		}
		else {
			return true;
		}
	}

	function getParam(str, deflt) {
		var search = decodeURIComponent(location.search);
		var result = new RegExp(str + '=([0-9]*)').exec(search);
		result = result ? result[1] : deflt;
		return result;
	}
});
