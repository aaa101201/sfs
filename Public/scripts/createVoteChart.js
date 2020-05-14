var initCharts = function (Chart) {
	var extend = function (origin, extra) {
		for (var attr in extra) {
			if ((typeof extra[attr]).toLowerCase() !== 'object') {
				origin[attr] = extra[attr];
			} else {
				if (!origin[attr]) {
					origin[attr] = {};
				}
				extend(origin[attr], extra[attr]);
			}
		}
	};
	var g = {
		defaultFontColor: '#666',
		defaultFontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
		defaultFontSize: 12,
		defaultFontStyle: 'normal',
		//Common
		responsive: true,
		responsiveAnimationDuration: 600,
		maintainAspectRatio: true,
		//Title
		title: {
			display: true,
			position: 'top',
			fullWidth: true,
			fontSize: 18,
			fontColor: '#666',
			fontStyle: 'bold',
			padding: '10',
			text: ''
		},
		legend: {
			display: true,
			position: 'bottom',
			fullWidth: true,
			labels: {
				boxWidth: 40,
				fontSize: 18,
				fontStyle: 'bold',
				fontColor: '#555',
				padding: 10,
				usePointStyle: false,
				reverse: false
			}
		},
		tooltips: {
			enabled: true,
			mode: 'x-axis', //single label x-axis
			backgroundColor: 'rgba(0,0,0,0.8)',
			titleFontSize: 14,
			titleFontStyle: 'normal',
			titleFontColor: '#ccc',
			titleSpacing: 2,
			titleMarginBottom: 6,
			bodyFontSize: 16,
			bodyFontStyle: 'normal',
			bodyFontColor: '#fff',
			bodySpacing: 3,
			footerFontSize: 16,
			footerFontStyle: 'normal',
			footerFontColor: '#fff',
			footerSpacing: 3,
			footerMarginTop: 6,
			xPadding: 6,
			yPadding: 6,
			caretSize: 0,
			cornerRadius: 5
		},
		hover: {
			mode: 'x-axis'
		},
		elements: {
			arc: {
				backgroundColor: 'rgba(0, 0, 0, 0.7)',
				borderColor: '#fff',
				borderWidth: 2
			},
			line: {
				tension: 0.4,
				backgroundColor: 'rgba(0, 0, 0, 0.1)',
				borderWidth: 2,
				borderColor: 'rgba(0, 0, 0, 0.1)',
				borderCapStyle: 'butt', //butt, round, square
				borderDash: [],
				borderDashOffset: 0.0,
				borderJoinStyle: 'miter', //bevel, round, miter
				capBezierPoints: true,
				fill: true,
				stepped: false
			},
			point: {
				radius: 3,
				pointStyle: 'circle',
				backgroundColor: 'rgba(0, 0, 0, 0.1)',
				borderWidth: 1,
				borderColor: 'rgba(0, 0, 0, 0.1)',
				hitRadius: 1,
				hoverRadius: 3,
				hoverBorderWidth: 1
			},
			rectangle: {
				backgroundColor: 'rgba(0, 0, 0, 0.1)',
				borderWidth: 0,
				borderColor: 'rgba(0, 0, 0, 0.1)',
				borderSkipped: 'bottom'
			}
		}
	};
	extend(Chart.defaults.global, g);
};

var convert2arr = function (arr, wants) {
	var attrs = (typeof wants === 'string') ? [wants] : wants;
	if (!arr || !attrs || attrs.length === 0) {
		console.log('func convert2arr: 参数格式不正确\n' + 'arr: ' + arr + '\nattrs: ' + attrs);
		return false;
	}

	var l = attrs.length, i = 0, results = {};
	for (; i < l; i++) {
		results[attrs[i]] = [];
		arr.forEach(function (data) {
			results[attrs[i]].push(data[attrs[i]]);
		});
	}
	return results;
};
var voteChart = null;
var voteData = {
	_votenum: [],
	_dates: []
};
Object.defineProperties(voteData, {
	votenum: {
		get: function () {
			return this._votenum;
		},
		set: function (newVal) {
			console.log(newVal, typeof newVal);
			if (Object.prototype.toString.call(newVal).toLowerCase() === '[object array]') {
				this._votenum.splice(0, this._votenum.length);
				Array.prototype.push.apply(this._votenum, newVal);
			} else {
				throw new Error('您必须传入一个数组！');
			}
		}
	},
	dates: {
		get: function () {
			return this._dates;
		},
		set: function (newVal) {
			if (Object.prototype.toString.call(newVal).toLowerCase() === '[object array]') {
				this._dates.splice(0, this._dates.length);
				Array.prototype.push.apply(this._dates, newVal);
			} else {
				throw new Error('您必须传入一个数组！');
			}
		}
	}
});
var updateVoteChart = function (_from, _to) {
	// ...获取项目，作业类型，起止日期信息，注意设置默认值
	var f = $('#startDate_vote_count').val() || _from, t = $('#endDate_vote_count').val() || _to;
 	var startDate = f ? f + ' 00:00:00' : null;
	var endDate = t ? t + ' 23:59:59' : null;
	var results = null;
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: MOD_PATH + '/Vote/getVoteStats',
		data: {	
			voteId: voteId,
			beginTime: startDate, //日期起
			endTime: endDate // 日期止
		},
		success: function (res) {
			console.log(res);
			if (res.code == 0) {
				return false;
			} else {
				$('#votetimes').text(res.data.usernum);
				console.log(JSON.stringify(res));
				var dayCollection = ['周日', '周一', '周二', '周三', '周四', '周五', '周六'];
				results = convert2arr(res.data.list, ['votenum', 'createtime']);
				voteData.votenum = results.votenum;
				voteData.dates = results.createtime.map(function (date) {
					return date + '(' + dayCollection[new Date(date && date.trim()).getDay()] + ')';
				});
				console.log('voteData', voteData.votenum, voteData.dates);
				if (voteChart) {
					voteChart.update();
				} else {
					voteChart = createVoteChart(voteData);
				}
			}
		},
		error: function () {
			throw new Error('服务器异常！');
		}
	});

};
var createVoteChart = function (data) {
	var ctx = document.getElementById('chart_vote_count').getContext('2d');
	initCharts(Chart);
	//overwrite the FUNCTION initCharts
	initCharts = function () {
		console.log('Chart has inited!');
	};
	return new Chart(ctx, {
		type: 'line',
		data: {
			labels: data.dates,
			datasets: [
				{
					label: '日增',
					data: data.votenum,
					cubicInterpolationMode: 'default', //default, monotone
					backgroundColor: 'rgba(248, 248, 248, 0.1)',
					borderColor: 'rgba(100, 100, 100, 0.6)',
				}
			]
		},
		options: {
	        title: {
	            display: true,
	            text: ' '
	        },
	        legend: {
	        	display: false
	        },
	        scales: {
	        	xAxes: [{
	        		type: 'category', //category, linear, logarithmic, time, radialLinear
	        		ticks: {
	        			maxRotation: 45,
	        		},
	        		gridLines: {
	        			display: false
	        		}
	        	}],
	        	yAxes: [{
	        		type: 'linear',
	        		ticks: {
	        			maxTicksLimit: 15
	        		},
	        		gridLines: {
	        			display: true,
	        			color: 'rgba(0, 0, 0, 0.1)'
	        		}
	        	}]
	        }
		}
	});
};
$('#voteCountBtn').click(function () {
	updateVoteChart();
});