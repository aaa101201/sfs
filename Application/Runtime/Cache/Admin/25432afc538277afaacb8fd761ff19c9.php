<?php if (!defined('THINK_PATH')) exit();?><!-- 列表 start -->
<div class="admin-content-body">
    <div class="am-cf am-padding am-padding-bottom-0">
        <div class="am-fl am-cf">
            <strong class="am-text-primary am-text-lg">商户管理</strong> /
            <small>列表</small>
        </div>
    </div>
    <hr>
    <!-- 列表-nav start-->
    <div class="am-g">
        <div class="am-u-sm-1 am-u-md-1">
            <div class="am-form-group">
                <div class="am-btn-toolbar">
                    <div class="am-btn-group am-btn-group-sm">
                        <button type="button" class="am-btn am-btn-primary"
                                id='export'>
                            <span class="am-icon-save"></span> Excel
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="am-u-sm-1 am-u-md-10" style="width: calc(100% - 240px);">
            <div class="am-form-group am-u-sm-12 am-u-md-3 am-w-auto">
                省：
                <select id="nav-province" data-am-selected="{btnSize: 'sm'}">

                </select>
            </div>
            <div class="am-form-group am-u-sm-12 am-u-md-3 am-w-auto">
                市：
                <select id="nav-city" data-am-selected="{btnSize: 'sm'}">

                </select>
            </div>
            <div class="am-form-group am-u-sm-12 am-u-md-3 am-w-auto">
                区：
                <select id="nav-region" data-am-selected="{btnSize: 'sm'}">

                </select>
            </div>
            <div class="am-u-sm-12 am-u-md-2 max_w_200">
    			<div class="am-form-group am-form-icon">
    				<i class="am-icon-calendar"></i> <input id="startTime"
    					type="text" class="am-form-field am-input-sm" placeholder="开始日期"
    					data-am-datepicker readonly>
    			</div>
    		</div>
            <div class="am-u-sm-12 am-u-md-2 max_w_200">
    			<div class="am-form-group am-form-icon">
    				<i class="am-icon-calendar"></i> <input id="endTime" type="text"
    					class="am-form-field am-input-sm" placeholder="结束日期"
    					data-am-datepicker readonly>
    			</div>
    		</div>
            <div class="am-u-sm-12 am-u-md-2 max_w_200">
    			<div class="am-form-group am-form-icon">
    				<i class="am-icon-search"></i>
    				<input id="phone" type="text" class="am-form-field am-input-sm" placeholder="商户名或电话">
    			</div>
    		</div>
            <div class="am-u-sm-12 am-u-md-0"></div>
        </div>

        <div class="am-form-group am-u-sm-12 am-u-md-1 am-fr am-w-auto">
            <button id="search" type="button"
                class="am-btn am-btn-primary am-btn-sm am-fr">确认</button>
        </div>
    </div>
    <div class="am-g">
        <div class="am-form-group am-u-sm-12 am-u-md-1 am-fr am-w-auto">
            <button id="addShop" type="button"
                class="am-btn am-btn-primary am-btn-sm am-fr">新增</button>
        </div>
    </div>
    <!-- 列表-nav end-->
    <br/>
    <!-- 列表 start-->
    <div class="am-g">
        <div class="am-u-sm-12">
            <form class="am-form am-scrollable-horizontal">
                <table id="x-table"
                       class="am-table am-table-striped am-table-hover table-main am-text-center">
                    <thead>
                    <tr>
                        <th class="am-text-center">商户</th>
                        <th class="am-text-center">电话</th>
                        <th class="am-text-center">账号</th>
                        <th class="am-text-center">省</th>
                        <th class="am-text-center">市</th>
                        <th class="am-text-center">区</th>
                        <th class="am-text-center">注册时间</th>
                        <th class="am-text-center">操作</th>
                    </tr>
                    </thead>
                </table>
            </form>
        </div>
    </div>
    <!-- 列表 end-->
</div>
<!-- detail start -->
<div id='detailForm'
     class="admin-content-body am-animation-slide-right"></div>
<!-- detail end -->
<footer class="admin-content-footer">
    <hr>
    <p class="am-padding-left">© 2016-2026 山东盈帆信息科技股份有限公司版权所有。</p>
</footer>

<script src="/Public/scripts/libs/amazeui.js"></script>

<script id="tpl-shop-detail" type="text/html">
    <div class="am-cf am-padding am-padding-bottom-0">
        <div class="am-fl am-cf">
            <strong class="am-text-primary am-text-lg">商户</strong> /
            <small>详情</small>
        </div>
    </div>
    <hr>
    <div class="am-tabs am-margin">
        <ul class="am-tabs-nav am-nav am-nav-tabs">
            <li class="am-active"><a href="#xAdmin-tab">基本信息</a></li>
        </ul>
        <div class="am-tabs-bd">
            <div class="am-tab-panel am-fade am-in am-active" id="xAdmin-tab">
                <form class="am-form" id="z_form">
                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-2 am-u-md-2 am-text-right"><span style="color: red;">*</span> 登录帐号:</div>
                        <div class="am-u-sm-4 am-u-md-4 am-u-end">
                            <input type="text" value="{{username}}" placeholder="登录账号为5~20位字母数字组合，字母开头" {{readonly}} {{action == "update" ? "readonly" : ""}} name="username">
                        </div>
                    </div>
                    {{if action == "save"}}
                        <div class="am-g am-margin-top">
                            <div class="am-u-sm-2 am-u-md-2 am-text-right"><span style="color: red;">*</span> 登录密码:</div>
                            <div class="am-u-sm-4 am-u-md-4 am-u-end">
                                <input type="text" value="{{password}}" placeholder="输入6~16位数字字母密码" {{readonly}} name="password">
                            </div>
                        </div>
                    {{/if}}
                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-2 am-u-md-2 am-text-right"><span style="color: red;">*</span> 手机号码:</div>
                        <div class="am-u-sm-4 am-u-md-4 am-u-end">
                            <input type="text" value="{{phone}}" placeholder="输入手机号码" {{readonly}} name="phone">
                        </div>
                    </div>
                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-2 am-u-md-2 am-text-right"><span style="color: red;">*</span> 商户姓名:</div>
                        <div class="am-u-sm-4 am-u-md-4 am-u-end">
                            <input type="text" value="{{realname}}" placeholder="输入商户姓名" {{readonly}} name="realname">
                        </div>
                    </div>
                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-2 am-u-md-2 am-text-right"><span style="color: red;">*</span> 商户公司:</div>
                        <div class="am-u-sm-4 am-u-md-4 am-u-end">
                            <input type="text" value="{{name}}" placeholder="输入商户公司名称" {{readonly}} name="name">
                        </div>
                    </div>
                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-2 am-u-md-2 am-text-right">商户电话:</div>
                        <div class="am-u-sm-4 am-u-md-4 am-u-end">
                            <input type="text" value="{{telephone}}" placeholder="输入商户电话" {{readonly}} name="telephone">
                        </div>
                    </div>
                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-2 am-u-md-2 am-text-right">所属省份:</div>
                        <div class="am-u-sm-4 am-u-md-4 am-u-end pos-rel">
                            <select  name="provinceId" {{readonly}}>

                            </select>
                        </div>
                    </div>
                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-2 am-u-md-2 am-text-right">所属地市:</div>
                        <div class="am-u-sm-4 am-u-md-4 am-u-end pos-rel">
                            <select  name="cityId" {{readonly}}>

                            </select>
                        </div>
                    </div>
                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-2 am-u-md-2 am-text-right">所属市区:</div>
                        <div class="am-u-sm-4 am-u-md-4 am-u-end pos-rel">
                            <select  name="regionId" {{readonly}}>

                            </select>
                        </div>
                    </div>
                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-2 am-u-md-2 am-text-right">商户地址:</div>
                        <div class="am-u-sm-4 am-u-md-4 am-u-end">
                            <input type="text" value="{{address}}" placeholder="输入商户地址" {{readonly}} name="address">
                        </div>
                    </div>
                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-2 am-u-md-2 am-text-right">工商注册时间:</div>
                        <div class="am-u-sm-4 am-u-md-4 am-u-end">
                            <input type="text" value="{{registertime}}" placeholder="选择注册时间" readonly name="registerTime">
                        </div>
                    </div>
                    <div class="am-g am-margin-top">
						<div class="am-u-sm-2 am-u-md-2 am-text-right">公司简介:</div>
						<div class="am-u-sm-4 am-u-md-4 am-u-end">
							<textarea class="" rows="5" placeholder="输入商户简介" {{readonly}} name="description">{{description}}</textarea>
						</div>
					</div>
                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-2 am-u-md-2 am-text-right">营业执照:</div>
                        <div class="am-u-sm-5 am-u-md-5 am-u-end">
                            <div class="am-cf am-u-md-12" style="padding: 0;">
                                {{if licenceimgurl}}
                                    <div class="am-u-sm-5 am-u-sm-uncentered pos-rel pointer" style="width: 47.5%;padding: 0;">
                                        <img class="am-thumbnail banner addImg" src="{{licenceimgurl}}" alt="" id="licenceImgURL"/>
                                    </div>
                                {{else}}
                                    <div class="am-u-sm-5 am-u-sm-uncentered pos-rel pointer" style="width: 47.5%;padding: 0;">
                                        <img class="am-thumbnail banner addImg" src="" alt="" id="licenceImgURL"/>
                                        <div class="pos-abs am-text-center addCardImg addImg">
                                            <p class="am-text-xl">添加营业执照</p>
                                            <p>+</p>
                                        </div>
                                    </div>
                                {{/if}}
                            </div>
                        </div>
                        <button type="button" id="fileBtn" style="display: none;"></button>
                    </div>
                    {{if action == "save"}}
                        <div class="am-g am-margin-top am-padding-bottom">
                            <div class="am-u-sm-4 am-u-md-2 am-text-right">操作：</div>
                            <div class="am-u-sm-4 am-u-md-9 am-u-end">
                                <button type="button" class="am-btn am-btn-primary" id="add">
                                    保存</button>
                            </div>
                        </div>
                    {{else if action == "update"}}
                        <div class="am-g am-margin-top am-padding-bottom">
                            <div class="am-u-sm-4 am-u-md-2 am-text-right">操作：</div>
                            <div class="am-u-sm-4 am-u-md-9 am-u-end">
                                <button type="button" class="am-btn am-btn-primary" id="update">
                                    更新</button>
                            </div>
                        </div>
                    {{/if}}
                </form>
            </div>
        </div>
    </div>
</script>
<script type="text/javascript">
    (function(){
        var ShopTable = function(){
            this.api = {
                getDataApi:     '/index.php/Admin/Shop/getSearchList', //获取商户数据列表
                getProvinceApi: '/index.php/Admin/Gp/getProvince', //获取省>市>区列表
                getCityApi:     '/index.php/Admin/Gp/getCities', //获取省>市>区列表
                getRegionsApi:  '/index.php/Admin/Gp/getRegions', //获取省>市>区列表
                exportExcelApi: '/index.php/Admin/Shop/export', //导出excel
                viewShopApi:    '/index.php/Admin/Shop/selectShop', //查看商户信息
                updateShopApi:  '/index.php/Admin/Shop/updateShop', //编辑商户信息
                activeShopApi:  '/index.php/Admin/Shop/setEnable', //启用商户
                forbidShopApi:  '/index.php/Admin/Shop/setDisable', //禁用商户
                newShopApi:     '/index.php/Admin/Shop/doShop', //新增商户
                uploadApi:      '/index.php/Admin/File/upload', //上传营业执照
                resetPwdApi:    '/index.php/Admin/Shop/doResetPassword', //重置商户密码
            };
            this.province = "";//检索省>市>区
            this.city = "";//检索省>市>区
            this.region = "";//检索省>市>区
            this.startTime = "";//检索开始日期
            this.endTime = "";//检索结束日期
            this.phone = "";//检索商户名或手机号
            this.table = null;
            this.uploader = null;
            this.init();
        };
        ShopTable.prototype = {
            init: function(){
                this.fillSelect($('#nav-province'), $('#nav-city'), $('#nav-region'), {});
                this.drawTable();
                this.clickBtnFun();
                this.doSearch();
                this.newShop();
                this.export();
            },
            drawTable: function(){
                var self = this;
                self.table = $('#x-table').DataTable({
        			serverSide : true,
                    dom : '<"top">it<"bottom"p><"clear">',
        			ajax : {
                        url : self.api.getDataApi+'?provinceId='+self.province+'&cityId='+self.city+'&regionId='+self.region+'&createTimeStart='
                                +self.startTime+'&createTimeEnd='+self.endTime+'&telephonename='+self.phone
                    },
        			columns : [
                        {"data" : "name"},
                        {"data" : "telephone"},
                        {"data" : "username"},
                        {"data" : "province"},
                        {"data" : "city"},
                        {"data" : "region"},
                        {"data" : "registertime"}
        			],
        			columnDefs :[
                        {
        				    "targets" : 7,
        				    "render" : function(data, type, row) {
                                var arr = ["view", "edit"];
                                arr.push(row.status=="0"?"active":"forbid");
                                arr.push("resetPwd");
        					    return template("btn-tpl", {"btnArr": returnBtn(arr)});
        				    }
        			    },{
                            "targets" : [0,1,2,3,4,5,6],
                            "className" : "table-info"
                        }
                    ]
        		});
            },
            newShop: function(){
                var self = this;
                $('#addShop').on('click', function(){
                    var data = {
                        "readonly": "",
                        "action": "save"
                    };
                    $('#detailForm').html(template('tpl-shop-detail', data));
                    scrollToForm();
                    self.fillSelect($('select[name="provinceId"]'), $('select[name="cityId"]'), $('select[name="regionId"]'), {});
                    self.initDate($('input[name="registerTime"]'));
                    self.createUploader();
                    self.uploadImg();
                    $('#add').on('click', function(){
                        var bool = self.checkForm();
                        if(!bool) return;
                        var data = $('#z_form').serialize();
                        data += '&licenceImgURL=' + $('#licenceImgURL').attr('src');
                        $.ajax({
                            url: self.api.newShopApi,
                            data: data,
                            success: function(res){
                                if(res.code == "0"){
                                    modal_alert(res.msg || "创建成功");
                                    $('#detailForm').empty();
                                    self.table.ajax.reload();
                                }else{
                                    modal_alert(res.msg || "创建失败");
                                }
                            },
                            error: errorTip
                        });
                    });
                });
            },
            clickBtnFun: function(){
                var self = this;
                $('#x-table tbody').on('click', 'button', function() {
                    var data = self.table.row($(this).parents('tr')).data();
        			var action = $(this).attr("action");
        			var id = data["id"] || -1;
        			if (action == "view") {
        				self.view(id);
        				return;
        			}
        			if (action == "forbid") {
        				self.forbid(id);
        				return;
        			}
        			if (action == "active") {
        				self.active(id);
        				return;
        			}
        			if (action == "edit") {
        				self.edit(id);
        				return;
        			}
        			if (action == "resetPwd") {
        				self.resetPwd(id);
        				return;
        			}
        		});
            },
            view: function(id){
                var self = this;
                $.ajax({
                    url: self.api.viewShopApi,
    				data:{'id':id},
    				success: function(res){
                        if(res.code == "0"){
                            var data = res.data[0];
                            data.readonly = "readonly";
                            data.action = "view";
                            $("#detailForm").html(template('tpl-shop-detail', data));
                            self.fillSelect($('select[name="provinceId"]'), $('select[name="cityId"]'), $('select[name="regionId"]'), {
                                "provinceId": data.provinceid,
                                "cityId": data.cityid,
                                "regionId": data.regionid
                            });
                            scrollToForm();
                        }else{
                            modal_alert(res.msg);
                        }
    				},
                    error: errorTip
    			});
            },
            forbid: function(id){
                var self = this;
                $.ajax({
                    url: self.api.forbidShopApi,
    				data:{'id':id},
    				success: function(res){
                        modal_alert(res.msg);
                        self.table.ajax.reload().draw();
    				},
                    error: errorTip
    			});
            },
            active: function(id){
                var self = this;
                $.ajax({
                    url: self.api.activeShopApi,
    				data:{'id':id},
    				success: function(res){
                        modal_alert(res.msg);
                        self.table.ajax.reload().draw();
    				},
                    error: errorTip
    			});
            },
            edit: function(id){
                var self = this;
                $.ajax({
                    url: self.api.viewShopApi,
    				data:{'id':id},
    				success: function(res){
                        if(res.code == "0"){
                            var data = res.data[0];
                            data.readonly = "";
                            data.action = "update";
                            $("#detailForm").html(template('tpl-shop-detail', data));
                            self.fillSelect($('select[name="provinceId"]'), $('select[name="cityId"]'), $('select[name="regionId"]'), {
                                "provinceId": data.provinceid,
                                "cityId": data.cityid,
                                "regionId": data.regionid
                            });
                            self.initDate($('input[name="registerTime"]'));
                            scrollToForm();
                            self.createUploader();
                            self.uploadImg();
                            self.updateShop(id);
                        }else{
                            modal_alert(res.msg);
                        }
    				},
                    error: errorTip
    			});
            },
            updateShop: function(id){
                var self = this;
                $('#update').on('click', function(){
                    var bool = self.checkForm();
                    if(!bool) return;
                    var data = $('#z_form').serialize();
                    data += '&licenceImgURL=' + $('#licenceImgURL').attr('src');
                    data += '&id=' + id;
                    $.ajax({
                        url: self.api.updateShopApi,
                        data: data,
                        success: function(res){
                            if(res.code == "0"){
                                modal_alert(res.msg || "更新成功");
                                $('#detailForm').empty();
                                self.table.ajax.reload().draw();
                            }else{
                                modal_alert(res.msg || "更新失败");
                            }
                        },
                        error: errorTip
                    });
                });
            },
            resetPwd: function(id){
                var self = this;
                $.ajax({
                    url: self.api.resetPwdApi,
                    data:{'id':id},
                    success: function(res){
                        modal_alert('密码重置为"123456"');
                    },
                    error: errorTip
                });
            },
            doSearch: function(){
                var self = this;
                $('#search').click(function(){
                    self.province = $("#nav-province").val();
                    self.city = $("#nav-city").val();
                    self.region = $("#nav-region").val();
                    self.startTime = $("#startTime").val();
                    self.endTime = $("#endTime").val();
                    self.phone = $("#phone").val();
                    var url = self.api.getDataApi+'?provinceId='+self.province+'&cityId='+self.city+'&regionId='+self.region+'&createTimeStart='
                        +self.startTime+'&createTimeEnd='+self.endTime+'&telephonename='+self.phone;
                    self.table.ajax.url(url).load();
                });
            },
            /*省市区筛选三级联动*/
            fillSelect: function(provinceDom, cityDom, regionDom, optionIds){
                console.log(optionIds)
                var self = this;
                $.ajax({
                    url: self.api.getProvinceApi,
    				success: function(res){
                        if(res.length){
                            var data = res.map(function(item){
                                return {
                                    "value": item.id,
                                    "name": item.name,
                                    "optionId": optionIds.provinceId || ''
                                };
                            });
                            provinceDom.html(template('select-tpl', {"data": data}));
                            if(optionIds.provinceId){
                                provinceDom.trigger('change');
                            }
                        }else{
                            errorTip();
                        }
    				},
                    error: errorTip
    			});
                provinceDom.on('change', function(){
                    $.ajax({
                        url: self.api.getCityApi,
                        data: {
                            "pid": provinceDom.val()
                        },
        				success: function(res){
                            if(res.length){
                                var data = res.map(function(item){
                                    return {
                                        "value": item.id,
                                        "name": item.name,
                                        "optionId": optionIds.cityId || ''
                                    };
                                });
                                cityDom.html(template('select-tpl', {"data": data}));
                                if(optionIds.cityId){
                                    cityDom.trigger('change');
                                }
                            }else{
                                errorTip();
                            }
        				},
                        error: errorTip
        			});
                });
                cityDom.on('change', function(){
                    $.ajax({
                        url: self.api.getRegionsApi,
                        data: {
                            "cid": cityDom.val()
                        },
        				success: function(res){
                            if(res.length){
                                var data = res.map(function(item){
                                    return {
                                        "value": item.id,
                                        "name": item.name,
                                        "optionId": optionIds.regionId || ''
                                    };
                                });
                                regionDom.html(template('select-tpl', {"data": data}));
                            }else{
                                errorTip();
                            }
        				},
                        error: errorTip
        			});
                });
            },
            export: function(){
                var self = this;
                $("#export").click(function(){
                    self.province = $("#nav-province").val();
                    self.city = $("#nav-city").val();
                    self.region = $("#nav-region").val();
                    self.startTime = $("#startTime").val();
                    self.endTime = $("#endTime").val();
                    self.phone = $("#phone").val();
                    var url = self.api.exportExcelApi+'?provinceId='+self.province+'&cityId='+self.city+'&regionId='+self.region+'&createTimeStart='
                        +self.startTime+'&createTimeEnd='+self.endTime+'&telephonename='+self.phone;
                    exportExcel(url);
                });
            },
            createUploader: function() {
                var self = this;
                self.uploader = WebUploader.create({
                    auto: true,
                    duplicate: true,
                    multiple: false,
                    server: self.api.uploadApi,
                    fileSingleSizeLimit: 8 * 1024 * 1024,
                    compress: {
                        noCompressIfLarger: false,
                        compressSize: 0,
                    },
                    formData: {},
                    accept: {
                        title: 'Images',
                        extensions: 'gif,jpg,jpeg,bmp,png',
                        mimeTypes: 'image/jpg,image/jpeg,image/png,image/gif,image/bmp'
                    }
                });
                self.uploader.addButton({
                    id: '#fileBtn',
                });
            },
            uploadImg: function(){
                var self = this;
                var uploader = self.uploader;
                $('.addImg').off('click').on('click',function() {
                    var that = $(this);
                    $('#fileBtn input').click();
                    uploader.off('uploadSuccess').on('uploadSuccess', function(file, response) {
                        if (response.code == '0') {
                            that.parent().find('img').attr('src',response.CDNPath);
                            that.parent().find('.addCardImg').addClass('am-hide');
                            that.parent().find('.form-delete-banner').removeClass('am-hide');
                        } else {
                            modal_alert('上传失败~');
                        }
                    });
                    uploader.on('error', function(type) {
                        if (type == "Q_TYPE_DENIED") {
                            modal_alert('图片格式gif,jpg,jpeg,bmp,png~');
                        }else if (type == "F_EXCEED_SIZE") {
                            modal_alert('文件大小不能超过8M~');
                        }
                    });
                });
            },
            initDate: function(jq){
                jq.datepicker({
                    format: 'yyyy-mm-dd'
                });
            },
            checkForm: function(){
                var f_username = $('input[name="username"]');
                if(f_username && !isAccountName(f_username.val())){
                    modal_alert('登录账号为5~20位字母数字组合，字母开头！');
                    return false;
                }
                var f_password = $('input[name="password"]');
                if(f_password && !isPasswprd(f_password.val())){
                    modal_alert('密码应为6~16位数字字母组合！');
                    return false;
                }
                var f_phone = $('input[name="phone"]');
                if(f_phone && !isPhone(f_phone.val())){
                    modal_alert('手机号码输入不正确');
                    return false;
                }
                var f_realname = $('input[name="realname"]');
                if(f_realname && f_realname.val().trim() === ''){
                    modal_alert('商户姓名不能为空');
                    return false;
                }
                var f_telephone = $('input[name="telephone"]');
                if(f_telephone && f_telephone.val().trim() === ''){
                    //modal_alert('商户电话不能为空');
                    //return false;
                }
                var f_name = $('input[name="name"]');
                if(f_name && f_name.val().trim() === ''){
                    modal_alert('商户公司名称不能为空');
                    return false;
                }
                var f_provinceId = $('select[name="provinceId"]');
                if(f_provinceId && f_provinceId.val() === '0'){
                    //modal_alert('请选择商户所属省份');
                    //return false;
                }
                var f_cityId = $('select[name="cityId"]');
                if(f_cityId && f_cityId.val() === '0'){
                    //modal_alert('请选择商户所属地市');
                   // return false;
                }
                var f_regionId = $('select[name="regionId"]');
                if(f_regionId && f_regionId.val() === '0'){
                    //modal_alert('请选择商户所属市区');
                    //return false;
                }
                var f_address = $('input[name="address"]');
                if(f_address && f_address.val().trim() === ''){
                   // modal_alert('商户地址不能为空');
                   // return false;
                }
                var f_registerTime = $('input[name="registerTime"]');
                if(f_registerTime && f_registerTime.val().trim() === ''){
                   // modal_alert('工商注册时间不能为空');
                   // return false;
                }
                var f_description = $('textarea[name="description"]');
                if(f_description && f_description.val() === ''){
                   // modal_alert('公司简介不能为空');
                   // return false;
                }
                var f_licenceImgURL = $('#licenceImgURL');
                if(f_licenceImgURL && f_licenceImgURL.attr('src') === ''){
                   // modal_alert('请上传营业执照');
                   // return false;
                }
                return true;
            }
        };
        new ShopTable();
    })();
</script>