<?php if (!defined('THINK_PATH')) exit();?><div class="admin-content-body">
	<div class="am-cf am-padding">
		<div class="am-fl am-cf">
			<strong class="am-text-primary am-text-lg">首页</strong> / <small>仪表盘</small>
		</div>
	</div>
	<ul class="am-avg-sm-1 am-avg-md-4 am-margin am-padding am-text-center admin-content-list ">
		<li><a href="#" class="am-text-success "><span
						class="am-icon-btn am-icon-user " ></span><br />+商户会员总数/人<br /><div id='newIncreaseUser'>0</div></a></li>
		<li><a href="#" class="am-text-warning "><span
						class="am-icon-btn am-icon-sitemap"></span><br />+商户累计消费金额<br /><div id='newIncreaseShop'>0</div></a></li>
		<li><a href="#" class="am-text-danger "><span
						class="am-icon-btn am-icon-signal "></span><br />+商户今日消费金额/元<br /><div id='newIncreasePoint'>0</div></a></li>
		<li><a href="#" class="am-text-secondary"><span
						class="am-icon-btn am-icon-sliders"></span><br />+商户今日消费会员数/人<br /><div id='residuePoint'>*</div></a></li>
	</ul>
	<div class="am-g">
		<div class="am-u-sm-6">
			<div class="am-panel am-panel-default">
				<div class="am-panel-hd am-cf"
					 data-am-collapse="{target: '#collapse-amount-nav,#collapse-amount-canvas'}">
					总消费金额<span class="am-icon-chevron-down am-fr"></span>
				</div>

				<div id="collapse-amount-nav" class="am-in am-cf"  style="margin:20px;" >
					<div class="am-u-sm-12 am-u-md-3">
		    			<div class="am-form-group am-form-icon">
		    				<i class="am-icon-calendar"></i> <input id="startTime_amount"
		    					type="text" class="am-form-field am-input-sm datepicker" placeholder="开始日期" readonly>
		    			</div>
		    		</div>
		            <div class="am-u-sm-12 am-u-md-3">
		    			<div class="am-form-group am-form-icon">
		    				<i class="am-icon-calendar"></i> <input id="endTime_amount" type="text"
		    					class="am-form-field am-input-sm datepicker" placeholder="结束日期" readonly>
		    			</div>
		    		</div>
					<div class="am-form-group am-u-sm-3">
						<button id="amountBtn" type="button"
								class="am-btn am-btn-primary am-btn-sm am-fr">确认</button>
					</div>
				</div>

				<div id="collapse-amount-canvas" class="am-in"  style="height: 300px;margin-bottom: 20px; width: calc(100% - 10px);">

				</div>
			</div>
		</div>
		<div class="am-u-sm-6">
			<div class="am-panel am-panel-default">
				<div class="am-panel-hd am-cf"
					 data-am-collapse="{target: '#collapse-user-nav,#collapse-user-canvas'}">
					总会员人数<span class="am-icon-chevron-down am-fr"></span>
				</div>

				<div id="collapse-user-nav" class="am-in am-cf"  style="margin:20px;" >
					<div class="am-u-sm-12 am-u-md-3">
		    			<div class="am-form-group am-form-icon">
		    				<i class="am-icon-calendar"></i> <input id="startTime_user"
		    					type="text" class="am-form-field am-input-sm datepicker" placeholder="开始日期" readonly>
		    			</div>
		    		</div>
		            <div class="am-u-sm-12 am-u-md-3">
		    			<div class="am-form-group am-form-icon">
		    				<i class="am-icon-calendar"></i> <input id="endTime_user" type="text"
		    					class="am-form-field am-input-sm datepicker" placeholder="结束日期" readonly>
		    			</div>
		    		</div>
					<div class="am-form-group am-u-sm-3">
						<button id="userBtn" type="button"
								class="am-btn am-btn-primary am-btn-sm am-fr">确认</button>
					</div>
				</div>

				<div id="collapse-user-canvas" class="am-in"  style="height: 300px;margin-bottom: 20px; width: 90%; width: calc(100% - 10px);" >

				</div>
			</div>
		</div>
	</div>
</div>
<script>
	(function(){
		$('.datepicker').datepicker({
			format: 'yyyy-mm-dd'
		});
		// 商户累计消费金额/元
		$.get('/index.php/Admin/Homepage/getVipExpend',function(res){
			//log(res)
			if(res.code == '0') $('#newIncreaseShop').text(res.data);
		});
		// 商户会员总数/人
		$.get('/index.php/Admin/Homepage/getVipNumber',function(res){
			//log(res)
			if(res.code == '0') $('#newIncreaseUser').text(res.data);
		});
		// 商户今日消费金额/元
		$.get('/index.php/Admin/Homepage/getVipTodayExpend',function(res){
			//log(res)
			if(res.code == '0') $('#newIncreasePoint').text(res.data);
		});
		// 商户今日消费会员数/人
		$.get('/index.php/Admin/Homepage/getVipTodayNumber',function(res){
			//log(res)
			if(res.code == '0') $('#residuePoint').text(res.data);
		});
		// 商户消费金额/元
		$.get('/index.php/Admin/Homepage/getVipExpendTime',function(res){
			//log(res)
			if(res.code == '0') $('#abbac1').text(res.data);
		});
		// 商户会员数
		$.get('/index.php/Admin/Homepage/getVipNumberTime',function(res){
			//log(res)
			if(res.code == '0') $('#abbac2').text(res.data);
		});

		var Date1 = new Date();
		var Date2 = new Date(Date1.getTime() - 1000*60*60*24*30);
		var createTimeStart = Date2.getFullYear()+'-'+((Date2.getMonth()+1)<10?('0'+(Date2.getMonth()+1)):(Date2.getMonth()+1))
								+'-'+(Date2.getDate()<10?('0'+Date2.getDate()):Date2.getDate());
		var createTimeEnd = Date1.getFullYear()+'-'+((Date1.getMonth()+1)<10?('0'+(Date1.getMonth()+1)):(Date1.getMonth()+1))
								+'-'+(Date1.getDate()<10?('0'+Date1.getDate()):Date1.getDate());

		/*总消费金额折线图*/
		function getExpend(){
			$.get('/index.php/Admin/Homepage/getVipExpendTime', {
				createTimeStart: $('#startTime_amount').val() || createTimeStart,
				createTimeEnd: $('#endTime_amount').val() || createTimeEnd
			}, function(res){
				if(res.code == '0' && res.data && res.data.length) {
					res.data.forEach(function(item){
						item.value = item.amount;
					});
					var data = handleData(res.data);
					data.title = ['消费金额'];
					drawCanvas(data, document.getElementById('collapse-amount-canvas'));
				}else{
					document.getElementById('collapse-amount-canvas').innerHTML = '<span style="padding-left: 40px;">没有数据~</span>';
				}
			});
		}

		/*总会员数折线图*/
		function getContactNumber(){
			$.get('/index.php/Admin/Homepage/getVipNumberTime', {
				createTimeStart: $('#startTime_user').val() || createTimeStart,
				createTimeEnd: $('#endTime_user').val() || createTimeEnd
			}, function(res){
				//console.log(res)
				if(res.code == '0' && res.data && res.data.length) {
					res.data.forEach(function(item){
						item.value = item.count;
					});
					var data = handleData(res.data);
					data.title = ['会员数量'];
					drawCanvas(data, document.getElementById('collapse-user-canvas'));
				}else{
					document.getElementById('collapse-user-canvas').innerHTML = '<span style="padding-left: 40px;">没有数据~</span>';
				}
			});
		}

		getExpend();
		getContactNumber();

		$("#amountBtn, #userBtn, #pointBtn, #shopBtn").on('click', function(){
			switch($(this).attr('id')){
				case 'amountBtn': getExpend();break;
				case 'userBtn': getContactNumber();break;
				case 'pointBtn': getPointNumber();break;
				case 'shopBtn': getShopNumber();break;
			}
		});
		/*some funs to deal data before drawing*/
		function handleData(data){
			if(!data.length)  return;
			var res = {
				value: [],
				date: []
			};
			data.forEach(function(item){
				res.value.push(item.value);
				res.date.push(item.createtime);
			});
			return res;
		}
		function drawCanvas(data, dom){
			// 基于准备好的dom，初始化echarts实例
			var myChart = echarts.init(dom);
			// 指定图表的配置项和数据
			var option = {
				legend: {
			        data: data.title
			    },
				tooltip: {
					trigger: 'axis'
				},
				grid: {
					left: '3%',
					right: '6%',
					bottom: '3%',
					containLabel: true
				},
				xAxis: {
					type: 'category',
					boundaryGap: false,
					data: data.date,
				},
				yAxis: {
					type: 'value'
				},
				series: [
					{
						name: data.title,
						type: 'line',
						data: data.value
					}
				]
			};
			// 使用刚指定的配置项和数据显示图表。
			myChart.setOption(option);
		}
	})();
</script>