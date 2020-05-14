$(function () {
	//sendJob
	$(document).on("pageInit", "#sendJob", function(e, id, page) {

	    console.log("inited", "sendJob Page!");

	    var company, provinces, category, types;
	   
	    $.ajax({
	        type: 'POST',
	        url:APP_PATH+ '/Home/Gp/citylist',
	        dataType: 'json',
	        timeout: 3000,
	        async:false,
	        success:function(res){
	            if(res.code==1){
	                provinces = {};
	                for (var i in res.data){
	                    provinces['p'+(res.data[i].id)] = res.data[i];
	                }
	            }else
	                server_error();
	        },
	        error:function(){
	            server_error();
	        }
	    });
	  
	    $.ajax({
	        type: 'POST',
	        url:APP_PATH+ '/Company/User/detail',
	        dataType: 'json',
	        timeout: 3000,
	        async:false,
	        success:function(res){
	            if(res.code==1) company = res.data;
	            else server_error();
	        },
	        error:function(){
	            server_error();
	        }
	    });
	    
	    $.ajax({
	        type: 'POST',
	        url:APP_PATH+ '/Home/Job/getCategory',
	        dataType: 'json',
	        timeout: 3000,
	        async:false,
	        success:function(res){
	            if(res.code==1) category = res.data;
	            else server_error();
	        },
	        error:function(){
	            server_error();
	        }
	    });

	    $.ajax({
	        type: 'POST',
	        url:APP_PATH+ '/Company/Job/getTypes',
	        dataType: 'json',
	        timeout: 3000,
	        async:false,
	        success:function(res){
	            if(res.code==1) types = res.data;
	            else server_error();
	        },
	        error:function(){
	            server_error();
	        }
	    });
	    
	    function reRenderRegionList(){
	        
	        $("#sendJob-region-select").html("");
	        var cityId = $("#sendJob-city-select").val();
	        if(!cityId){
	            cityId = $("#sendJob-city-select:first-child").val();
	        }
	
	        $.ajax({
	            type: 'POST',
	            url: APP_PATH + '/Home/Gp/regionList',
	            dataType: 'json',
	            data:{cId:cityId},
	            timeout: 3000,
	            async:false,
	            success:function(res){
	                if(res.code==1){
	                    $("#sendJob-region-select").html(template("sendJob-region-tpl",{company:company,regions:res.data}));
	                }
	                else $.toast(res.msg);
	            },
	            error:server_error
	            });
	        
	    }
	
	
	   function reRenderCitylist(){
	        var proid =  $("#sendJob-province-select").val();
	        if(proid) {
	            proid = "p"+proid;
	        } else {
	            proid = "p1";
	        }
	        $("#sendJob-city-select").html(template("sendJob-city-tpl",{company:company,cities:provinces[proid]['data']}));
	        reRenderRegionList();
	    }
		function arrayToObject(arr){
            obj = {};
            for( var i in arr){
                obj[arr[i]['name']]=arr[i]['value'];
            }
            return obj;
        }
        
        $("#rand").val('hell');
        console.log(Math.random());
        var test=$("#rand").val();
        console.log(test);
	    function doSendJob(){
	        //前台检查表单数据
            if(!checkFormFED()){
                return;
            }
            var formData = $("#sendJob .form_perfectInfo").serializeArray();
            formData =  arrayToObject(formData);
            //兼职类型数组
            formData.attributes = new Array();
            formData.attributes.push($('#jobType_select').val());
            console.log(formData.attributes);
	        $.ajax({
	            type: 'POST',
	            url: APP_PATH + '/Company/Job/add',
	            dataType: 'json',
	            data:formData,
	            timeout: 3000,
	            async:false,
	            success:function(res){
	                if(res.code==1){
	                    if(res.data.status==2){ //0.企业未完善信息 1.企业已完善信息未审核 2.审核通过
	                        $.toast("发布成功");
	                        setTimeout(function(){
	                            location.href= MOD_PATH+"/User/sendList"; //去发布记录页
	                        },2000);
	                    }else{
	                        location.href= CON_PATH+ '/sendOk';
	                    }
	                }
	                else $.toast(res.msg);
	            },
	            error:server_error
	            });
	    }
	
	    $("#sendJob .form_perfectInfo").html(template("sendJob-tpl",{company:company,provinces:provinces,category:category,types:types}));
	    $("#sendJob-province-select").change(reRenderCitylist);
	    $("#sendJob-city-select").change(reRenderRegionList); 
	    //$("#pCateId").change(dateChoose); 
	    var minDate = new Date(new Date().getTime() - 24*60*60*1000);
	    //var maxDate = new Date(new Date().getTime() + 24*60*60*1000*30);
	    var calendar_start,calendar_end;
	    function dateChoose(){
	    	// var type = $("#pCateId").val();
	    	// console.log(type);
	    	// if(type == 16){
	    	// 	maxDate = new Date(new Date().getTime() + 24*60*60*1000*60);
	    	// }else{
	    	// 	maxDate = new Date(new Date().getTime() + 24*60*60*1000*30);
	    	// }
	    	//$("#sendJob-startDate").val('');
	    	$("#sendJob-endDate").val('');
	    	$("#sendJob-startDate").off('click');
	    	$("#sendJob-endDate").off('click');
	    	calendar_start = $("#sendJob-startDate").calendar({
		    	minDate: minDate
		    	,maxDate: '2020-01-01'
		    });
		    calendar_end = $("#sendJob-endDate").calendar({
				minDate: $("#sendJob-startDate").val(),
		    	maxDate: new Date(new Date($("#sendJob-startDate").val()).getTime() + 24*60*60*1000*31*2)
		    });
	    }
	    dateChoose();
	    $("#sendJob-startDate").change(dateChoose); 
	    //工作时段,选用sui-picker
	    var param = {
            toolbarTemplate: '<header class="bar bar-nav">\
            <button class="button button-link pull-right close-picker">确定</button>\
            <h1 class="title">请选择</h1>\
            </header>',
            cols: [
                {
                    textAlign: 'center',
                    values: ['00:', '01:', '02:', '03:', '04:', '05:', '06:', '07:', '08:', '09:', '10:', '11:', 
                             '12:', '13:', '14:', '15:', '16:', '17:', '18:', '19:', '20:', '21:', '22:', '23:']
                },
                {
	                textAlign: 'center',
	                values: ['00','15','30','45']
	            }
            ]};
	    $("#beginHour").picker(param);
	    $("#endHour").picker(param);
	    var currDate = new Date();
	    var currDate_y = ''+currDate.getFullYear(),
	    	currDate_m = ((parseInt(currDate.getMonth())+1)<10?'0':'')+(currDate.getMonth()+1),
	    	currDate_d = (parseInt(currDate.getDate())<10?'0':'')+currDate.getDate(),
	    	currDate_h = ''+currDate.getHours(),
	    	currDate_mm = (parseInt(parseInt(currDate.getMinutes())/15)*15<10?'0':'')
	    	+parseInt(parseInt(currDate.getMinutes())/15)*15;
	    $("#datetime-picker").datetimePicker({
	    	value: [currDate_y, currDate_m, currDate_d, currDate_h, currDate_mm]
	    });
	    $("#doSendJob").click(doSendJob);
	    reRenderCitylist();

	    //前台检查表单数据填写
	    function checkFormFED(){
	        if ($('input[name = "company"]').val() == ''){
	            $.toast('(+_+)公司名称不能为空哦');
	            return false;
	        }
	        if ($('input[name = "title"]').val() == ''){
	            $.toast('(+_+)兼职名称不能为空哦');
	            return false;
	        }
	        if (!/^\+?[1-9]\d*$/.test($('input[name = "number"]').val())){
	            $.toast('(+_+)招聘人数输入不正确');
	            return false;
	        }
	        if ($('input[name = "income"]').val() == ''){
	            $.toast('(+_+)工资待遇不能为空哦');
	            return false;
	        }
	        if ($('input[name = "address"]').val() == ''){
	            $.toast('(+_+)详细地址不能为空哦');
	            return false;
	        }
	        //前台判断职位开始日期与结束日期前后关系
	        var startTime = $('#sendJob-startDate').val();
	        var endTime = $('#sendJob-endDate').val();
	        if ((startTime > endTime ) || (startTime == '') || (endTime == '')) {
	            $.toast('(+_+)工作日期输入不正确哦');
	            return false;
	        }
	        if(startTime == endTime){
	        	if($('input[name = "beginHour"]').val()>$('input[name = "endHour"]').val()){
	        		$.toast('(+_+)工作时间输入有误');
	            	return false;
	        	}
	        }
	        if ($('input[name = "deadline"]').val() == ''){
	            $.toast('(+_+)截止时间不能为空哦');
	            return false;
	        }
	        if ($('input[name = "linkman"]').val() == ''){
	            $.toast('(+_+)联系人不能为空哦');
	            return false;
	        }
	        var tel = $('input[name = "phone"]').val(); //获取手机号
	        var mobile_is_valid = !!tel.match(/^(0|86|17951)?(13[0-9]|15[012356789]|17[0-9]|18[0-9]|14[57])[0-9]{8}$/);
            var tel_is_valid = !!tel.match(/^(\d{3}-|\d{4}-)?\d{7,8}$/);
	        if (!tel.trim()){
	            $.toast('(+_+)联系电话不能为空哦');
	            return false;
	        } else if (!tel_is_valid && !mobile_is_valid) {
	        	$.toast('(+_+)联系电话格式不正确');
	        	return false;
	        }
	        if ($('textarea[name = "intro"]').val() == ''){
	            $.toast('(+_+)职位描述不能为空哦');
	            return false;
	        }
	        //正常情况不会出现此提示
	        if (($('select[name = "pCateId"]').val() == '') ||
	            ($('select[name = "jobType"]').val() == '') ||
	            ($('select[name = "payType"]').val() == '') ||
	            ($('select[name = "incomeUnit"]').val() == '') ||
	            ($('select[name = "provinceId"]').val() == '') ||
	            ($('select[name = "cityId"]').val() == '') ||
	            ($('select[name = "regionId"]').val() == '') ||
	            ($('input[name = "beginHour"]').val() == '') ||
	            ($('input[name = "endHour"]').val() == '')){

	            $.toast('(+_+)输入信息不能为空哦');
	            return false;
	        }
	        return true;
	    }
	});
	$.init();
});