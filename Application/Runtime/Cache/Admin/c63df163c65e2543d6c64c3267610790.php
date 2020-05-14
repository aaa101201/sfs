<?php if (!defined('THINK_PATH')) exit();?><!-- 列表 start -->
<div class="admin-content-body">
    <div class="am-cf am-padding am-padding-bottom-0">
        <div class="am-fl am-cf">
            <strong class="am-text-primary am-text-lg">会员设置</strong> /
            <small>列表</small>
        </div>
        <div class="am-fr am-cf">
            <button id="add" type="button"
                class="am-btn am-btn-primary am-btn-sm am-fr">新增</button>
        </div>
    </div>
    <hr>
    <br/>
    <!-- 列表 start-->
    <div class="am-g">
        <div class="am-u-sm-12">
            <form class="am-form am-scrollable-horizontal">
                <table id="x-table"
                       class="am-table am-table-striped am-table-hover table-main am-text-center">
                    <thead>
                    <tr>
                        <th class="am-text-center">序号</th>
                        <th class="am-text-center">名称</th>
                        <th class="am-text-center">累计消费金额</th>
                        <th class="am-text-center">积分比率</th>
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

<script id="tpl-setting-detail" type="text/html">
    <div class="am-cf am-padding am-padding-bottom-0">
        <div class="am-fl am-cf">
            <strong class="am-text-primary am-text-lg">会员等级</strong> /
            <small>详情</small>
        </div>
    </div>
    <hr>
    <div class="am-tabs am-margin">
        <ul class="am-tabs-nav am-nav am-nav-tabs">
            <li class="am-active"><a href="#xAdmin-tab">{{action == "save" ? "新增会员等级" : "编辑会员等级"}}</a></li>
        </ul>
        <div class="am-tabs-bd">
            <div class="am-tab-panel am-fade am-in am-active" id="xAdmin-tab">
                <form class="am-form" id="z_form">
                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-2 am-u-md-2 am-text-right">等级名称:</div>
                        <div class="am-u-sm-4 am-u-md-4 am-u-end">
                            <input type="text" value="{{levelname}}" placeholder="输入等级名称" {{readonly}} name="levelName">
                        </div>
                    </div>
                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-2 am-u-md-2 am-text-right">累计消费金额:</div>
                        <div class="am-u-sm-4 am-u-md-4 am-u-end">
                            <input type="text" value="{{amount}}" placeholder="输入此等级需要的消费金额(整数)" {{readonly}} name="amount">
                        </div>
                    </div>
                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-2 am-u-md-2 am-text-right">积分比率:</div>
                        <div class="am-u-sm-4 am-u-md-4 am-u-end">
                            <input type="text" value="{{point}}" placeholder="输入消费一元兑换积分数" {{readonly}} name="point">
                        </div>
                    </div>
                    {{if action == "save"}}
                        <div class="am-g am-margin-top am-padding-bottom">
                            <div class="am-u-sm-4 am-u-md-2 am-text-right">操作：</div>
                            <div class="am-u-sm-4 am-u-md-9 am-u-end">
                                <button type="button" class="am-btn am-btn-primary" id="submit">
                                    提交</button>
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
        var userSetting = function(){
            this.api = {
                getDataApi:     '/index.php/Admin/Settings/getSearchList', //获取会员等级数据列表
                addLevelApi:    '/index.php/Admin/Settings/doSyetem', //新增会员等级
                viewLevelApi:   '/index.php/Admin/Settings/FileTypesMan', //查看会员等级信息
                updateLevelApi: '/index.php/Admin/Settings/setSystem', //更新会员等级信息
                activeApi:      '/index.php/Admin/Settings/setEnable', //启用
                forbidApi:      '/index.php/Admin/Settings/setDisable', //禁用
            };
            this.table = null;
            this.init();
        };
        userSetting.prototype = {
            init: function(){
                this.drawTable();
                this.clickBtnFun();
                this.newLevel();
            },
            drawTable: function(){
                var self = this;
                self.table = $('#x-table').DataTable({
        			serverSide : true,
                    dom : '<"top">it<"bottom"p><"clear">',
        			ajax : {
                        url : self.api.getDataApi
                    },
        			columns : [
                        {"data" : "id"},
                        {"data" : "levelname"},
                        {"data" : "amount"},
                        {"data" : "point"}
        			],
        			columnDefs :[
                        {
        				    "targets" : 4,
        				    "render" : function(data, type, row) {
                                var arr = ["edit"];
                                arr.push(row.status=="0"?"active":"forbid");
        					    return template("btn-tpl", {"btnArr": returnBtn(arr)});
        				    }
        			    },{
                            "targets" : [0,1,2,3,4],
                            "className" : "table-info"
                        }
                    ]
        		});
            },
            newLevel: function(){
                var self = this;
                $('#add').on('click', function(){
                    var data = {
                        "readonly": "",
                        "action": "save"
                    };
                    $('#detailForm').html(template('tpl-setting-detail', data));
                    scrollToForm();
                    $('#submit').on('click', function(){
                        var bool = self.checkForm();
                        if(!bool) return;
                        var data = $('#z_form').serialize();
                        $.ajax({
                            url: self.api.addLevelApi,
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
        		});
            },
            forbid: function(id){
                var self = this;
                $.ajax({
                    url: self.api.forbidApi,
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
                    url: self.api.activeApi,
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
                    url: self.api.viewLevelApi,
    				data:{'id':id},
    				success: function(res){
                        if(res.code == "0"){
                            var data = res.data[0];
                            data.readonly = "";
                            data.action = "update";
                            $("#detailForm").html(template('tpl-setting-detail', data));
                            scrollToForm();
                            self.updateLevel(id);
                        }else{
                            modal_alert(res.msg);
                        }
    				},
                    error: errorTip
    			});
            },
            updateLevel: function(id){
                var self = this;
                $('#update').on('click', function(){
                    var bool = self.checkForm();
                    if(!bool) return;
                    var data = $('#z_form').serialize();
                    data += '&id=' + id;
                    $.ajax({
                        url: self.api.updateLevelApi,
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
            checkForm: function(){
                var f_levelName = $('input[name="levelName"]');
                if(f_levelName && f_levelName.val().trim() === ''){
                    modal_alert('等级名称不能为空！');
                    return false;
                }
                var f_amount = $('input[name="amount"]');
                if(f_amount && !isInt(f_amount.val())){
                    modal_alert('累计充值金额请输入正整数！');
                    return false;
                }
                var f_point = $('input[name="point"]');
                if(f_point && !isNum(f_point.val())){
                    modal_alert('积分比率输入不正确');
                    return false;
                }
                return true;
            }
        };
        new userSetting();
    })();
</script>