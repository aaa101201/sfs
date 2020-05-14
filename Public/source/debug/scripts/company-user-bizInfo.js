$(function () {
	//bizInfo 企业中心-基本信息
	$(document).on("pageInit", "#bizInfo", function(e, id, page) {

	    console.log("inited Page::", "bizInfo!");

	    function initUploader(){
	        var uploader = WebUploader.create({
	            auto : true,
	            duplicate:true,
	            server : CON_PATH+'/uploadCompanyLogo',
	            formData : {
	            },
	            accept : {
	                title : 'Images',
	                extensions : 'jpg,jpeg,gif,png',
	                mimeTypes : 'image/*'
	            },
	            compress:{
	                width: 500,
	                height: 500,
	                quality: 90,
	                allowMagnify: true,
	                crop: true,
	                preserveHeaders: true,
	                noCompressIfLarger: false,
	                compressSize: 0
	                }
	            });
	            uploader.on('uploadSuccess',function(file,response){
	                $.toast(response.msg, 1000, "toast_orange");
	                if(response.code == 1){
	                    $('#bizInfo-top-container .img-responsive').attr('src',response.data.url);
	                }
	            });
	            uploader.addButton({
	                id:'#bizInfo-upload',
	                innerHTML:'修改头像&nbsp;&nbsp;<span class="icon icon-right"></span>'
	            });
	    }
	    
	    $.ajax({
	        type: 'POST',
	        url: APP_PATH + '/Company/User/detail',
	        dataType: 'json',
	        timeout: 3000,
	        success: function(data){
	            console.log(data);
	            if(data.code){
	                if(data.data.status == "2") {
	                    $("#perfectInfo").hide();
	                }
	                $("#bizInfo-top-container").html(template("bizInfo-top-tpl", data.data));
	                $("#bizInfo-mid-container").html(template("bizInfo-mid-tpl", data.data));
	                $("#bizInfo-btm-container").html(template("bizInfo-btm-tpl", data.data));
	                initUploader();
	            }else{
	                 server_error();
	            }
	        },
	        error: function(xhr,type){
	            console.log("xhr", xhr);
	            server_error();
	        }
	    });
	});
	
	//bizInfo_detail init 函数 冗余 
	$(document).on("pageInit", "#bizInfo-detail", function(e, id, page) {

	    console.log("inited Page::", "bizInfo-detail!");

	    $.ajax({
	        type: 'POST',
	        url: APP_PATH + '/Company/User/detail',
	        dataType: 'json',
	        timeout: 3000,
	        success: function(data){
	            console.log(data);
	            if(data.code){
	                $("#bizInfo_detail-container").html(template("bizInfo_detail-tpl",data.data));
	            }else{
	                server_error();
	            }
	        },
	        error: function(xhr,type){
	            server_error();
	        }
	    });

	    function bindSubmit(){
	    	var intro = $('textarea[name="intro"]').val();
	    	if (intro.length > 150) {
	    		$.toast('企业简介不能超过150字');
	    		return;
	    	}
	        $('#bizInfo_detail-submit').click(function(){
	            $.ajax({
	                type: 'POST',
	                url: APP_PATH + '/Company/User/updateBizInfo',
	                dataType: 'json',
	                data:$("#bizInfo_detail-container").serialize(),
	                timeout: 3000,
	                success: function(data){
	                    if(data.code == 1) {
	                        opt_success();
	                        setTimeout(
	                            function(){
	                                $.router.back();
	                                //window.location.href='__MODULE__/User/bizCenter';
	                        }, 1000);
	                    } else {
	                        $.toast(data.msg, 1000);
	                    }
	                },
	                error: function(xhr,type){
	                    server_error();
	                }
	            });
	        })
	    }

	    bindSubmit();
	});
	// 企业中心-基本信息
	$(document).on("pageInit", "#perfectInfo", function(e, id, page) {
	    
	    console.log("inited page::", "perfectInfo!");

	    var path = location.search;
	    var src  = path.slice(path.lastIndexOf('=')+1);

	    $.ajax({
	        type: 'POST',
	        url: APP_PATH + '/Company/User/detail',
	        dataType: 'json',
	        timeout: 3000,
	        success: function(data){
	            company = data.data;
	            console.log(company);
	            if(data.code){
	                $("#wrapPerfectInfo").html(template('user-perfect-tpl', {'company' : company}));
	                $.ajax({
	                    type: 'POST',
	                    url:APP_PATH + '/Home/Gp/citylist',
	                    dataType: 'json',
	                    timeout: 3000,
	                    success:getGPDataSuccess,
	                    error:function(){ server_error(); }
	                });

	                function getGPDataSuccess(res){ 
	                    var provinces = {};
	                    for(var i in res.data){
	                        provinces['p'+(res.data[i].id)] = res.data[i];
	                    }
	                    $("#province-list").val(1).html(template('select-option-tpl', {option : provinces, current:company.provinceid})).trigger('change');
	                    $("#province-list").change(reRenderCityList).trigger('change');  
	                    function reRenderCityList(){
	                        $('#city-list').html(template('select-option-tpl', { 'option':provinces['p'+$(this).val()].data, 'current':company.cityid}));
	                    } 
	                }

	                function submitPerfectInfo(){
	                    $.ajax({
	                        type: 'POST',
	                        url: MOD_PATH + '/User/doPerfectInfo',
	                        dataType: 'json',
	                        data:$(".form_perfectInfo").serialize(),
	                        timeout: 3000,
	                        success: function(data){
	                            if(data.code == 1) {
	                                opt_success();
	                                setTimeout(
	                                    function(){
	                                        if(src) {
	                                            window.location.href='__MODULE__/User/sendList';
	                                        } else {
	                                            $.router.back();   
	                                        }
	                                }, 1000);
	                            } else {
	                                opt_fail();
	                            }
	                        },
	                        error: function(xhr,type){
	                            server_error();
	                        }
	                     });
	                }
	                $("#perfectInfo-submit").click(submitPerfectInfo);
	            
	                var uploader = WebUploader.create({
	                        auto : true,
	                        duplicate:true,
	                        server : MOD_PATH + '/User/uploadLicenceImage',
	                        formData : {},
	                        accept : {
	                            title : 'Images',
	                            extensions : 'jpg,jpeg,gif,png',
	                            mimeTypes : 'image/*'
	                        },
	                        compress:{
	                            width: 500,
	                            height: 500,
	                            quality: 90,
	                            allowMagnify: true,
	                            crop: true,
	                            preserveHeaders: true,
	                            noCompressIfLarger: false,
	                            compressSize: 0
	                        }
	                });
	                uploader.addButton({
	                     id:'#perfectInfo-upload',
	                     innerHTML:'上传'
	                });
	                uploader.on('uploadSuccess',function(file,response){
	                    $.toast(response.msg, 1000, "toast_orange");
	                    if(response.code == 1){
	                        $('.form_perfectInfo .showZImg').attr('src', response.data.localURL);
	                        $('#licenceimage-field').val(response.data.url);
	                        $('#locallicenceimage-field').val(response.data.localURL);
	                    }
	                });

	            }else{
	                server_error();
	            }
	        },
	        error: function(xhr,type){
	            server_error();
	        }
	    });                     
	});
});