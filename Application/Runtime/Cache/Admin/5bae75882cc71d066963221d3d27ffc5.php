<?php if (!defined('THINK_PATH')) exit();?><!-- 列表 start -->
<div class="admin-content-body">
    <div class="am-cf am-padding am-padding-bottom-0">
        <div class="am-fl am-cf">
            <strong class="am-text-primary am-text-lg">会员列表</strong> /
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
            <div class="am-u-sm-12 am-u-md-2 max_w_200 am-fr">
                <div class="am-form-group am-form-icon">
                    <i class="am-icon-search"></i>
                    <input id="phone" type="text" class="am-form-field am-input-sm" placeholder="输入手机号">
                </div>
            </div>
            <div class="am-form-group am-u-sm-12 am-u-md-3 am-w-auto am-fr">
                等级：
                <select id="nav-level" data-am-selected="{btnSize: 'sm'}">

                </select>
            </div>
            <div class="am-form-group am-u-sm-12 am-u-md-3 am-w-auto am-fr">
                商户：
                <select id="nav-shop" data-am-selected="{btnSize: 'sm'}">

                </select>
            </div>
        </div>

        <div class="am-form-group am-u-sm-12 am-u-md-1 am-fr am-w-auto">
            <button id="doSearch" type="button"
                class="am-btn am-btn-primary am-btn-sm am-fr">确认</button>
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
                        <th class="am-text-center">卡号</th>
                        <th class="am-text-center">姓名</th>
                        <th class="am-text-center">手机号</th>
                        <th class="am-text-center">等级</th>
                        <th class="am-text-center">累计消费金额</th>
                        <th class="am-text-center">余额</th>
                        <th class="am-text-center">可用积分</th>
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
<script id="tpl-user-detail" type="text/html">
    <div class="am-cf am-padding am-padding-bottom-0">
        <div class="am-fl am-cf">
            <strong class="am-text-primary am-text-lg">会员信息</strong> /
            <small>详情</small>
        </div>
    </div>
    <hr>
    <div class="am-tabs am-margin" data-am-tabs>
        <ul class="am-tabs-nav am-nav am-nav-tabs">
            <li class="am-active"><a href="#xAdmin-tab">基本信息</a></li>
        </ul>
        <div class="am-tabs-bd">
            <div class="am-tab-panel am-fade am-in am-active" id="xAdmin-tab">
                <form class="am-form" data-am-validator>
                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-2 am-u-md-2 am-text-right">姓名</div>
                        <div class="am-u-sm-4 am-u-md-4 am-u-end">
                            <input type="text" value="{{realname}}" readonly>
                        </div>
                    </div>
                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-2 am-u-md-2 am-text-right">手机号</div>
                        <div class="am-u-sm-4 am-u-md-4 am-u-end">
                            <input type="text" value="{{phone}}" readonly>
                        </div>
                    </div>
                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-2 am-u-md-2 am-text-right">所属商户</div>
                        <div class="am-u-sm-4 am-u-md-4 am-u-end">
                            <input type="text" value="{{name}}" readonly>
                        </div>
                    </div>
                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-2 am-u-md-2 am-text-right">卡号</div>
                        <div class="am-u-sm-4 am-u-md-4 am-u-end">
                            <input type="text" value="{{cardno}}" readonly>
                        </div>
                    </div>
                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-2 am-u-md-2 am-text-right">会员等级</div>
                        <div class="am-u-sm-4 am-u-md-4 am-u-end">
                            <input type="text" value="{{levelname}}" readonly>
                        </div>
                    </div>
                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-2 am-u-md-2 am-text-right">累计消费金额</div>
                        <div class="am-u-sm-4 am-u-md-4 am-u-end">
                            <input type="text" value="{{amount}}" readonly>
                        </div>
                    </div>
                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-2 am-u-md-2 am-text-right">余额</div>
                        <div class="am-u-sm-4 am-u-md-4 am-u-end">
                            <input type="text" value="{{balance}}" readonly>
                        </div>
                    </div>
                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-2 am-u-md-2 am-text-right">可用积分</div>
                        <div class="am-u-sm-4 am-u-md-4 am-u-end">
                            <input type="text" value="{{point}}" readonly>
                        </div>
                    </div>
                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-2 am-u-md-2 am-text-right">注册时间</div>
                        <div class="am-u-sm-4 am-u-md-4 am-u-end">
                            <input type="text" value="{{createtime}}" readonly>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</script>
<script type="text/javascript">
    (function(){
        var UserTable = function(){
            this.api = {
                getDataApi:      '/index.php/Admin/Contact/getSearchList',
                getUserLevelApi: '/index.php/Admin/Contact/getlevelName',
                getShopListApi:  '/index.php/Admin/Contact/getName',
                exportExcelApi:  '/index.php/Admin/Contact/export',
                activeUserApi:   '/index.php/Admin/Contact/setEnable',
                forbidUserApi:   '/index.php/Admin/Contact/setDisable',
                viewUserApi:     '/index.php/Admin/Contact/showMember',
            };
            this.shop = "";//检索商户
            this.level = "";//检索等级
            this.phone = "";//检索手机号
            this.table = null;
            this.init();
        };
        UserTable.prototype = {
            init: function(){
                this.fillSelect();
                this.drawTable({});
                this.clickBtnFun();
                this.doSearch();
                this.export();
            },
            drawTable: function(){
                var self = this;
                self.table = $('#x-table').DataTable({
        			serverSide : true,
                    dom : '<"top">it<"bottom"p><"clear">',
        			ajax : {
                        url : self.api.getDataApi+'?shopId='+self.shop+'&phone='+self.phone+'&level='+self.levelId
                    },
        			columns : [
                        {"data" : "name"},
                        {"data" : "cardno"},
                        {"data" : "realname"},
                        {"data" : "phone"},
                        {"data" : "levelname"},
                        {"data" : "amount"},
                        {"data" : "balance"},
                        {"data" : "point"},
                        {"data" : "createtime"}
        			],
        			columnDefs :[
                        {
        				    "targets" : 9,
        				    "render" : function(data, type, row) {
                                var arr = ["view"];
                                arr.push(row.status=="0"?"active":"forbid");
        					    return template("btn-tpl", {"btnArr": returnBtn(arr)});
        				    }
        			    },{
                            "targets" : [0,1,2,3,4,5,6,7,8],
                            "className" : "table-info"
                        }
                    ]
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
        		});
            },
            view: function(id){
                var self = this;
                $.ajax({
                    url: self.api.viewUserApi,
    				data:{'id':id},
    				success: function(res){
                        if(res.code == "0"){
                            var data = res.data[0];
                            $("#detailForm").html(template('tpl-user-detail', data));
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
                    url: self.api.forbidUserApi,
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
                    url: self.api.activeUserApi,
    				data:{'id':id},
    				success: function(res){
                        modal_alert(res.msg);
                        self.table.ajax.reload().draw();
    				},
                    error: errorTip
    			});
            },
            doSearch: function(){
                var self = this;
                $('#doSearch').click(function(){
                    self.shop = $("#nav-shop").val();
                    self.level = $("#nav-level").val();
                    self.phone = $("#phone").val();
                    var url = self.api.getDataApi + '?shopId=' + self.shop + '&levelId=' + self.level + '&phone=' + self.phone;
                    self.table.ajax.url(url).load();
                });
            },
            fillSelect: function(){
                var self = this;
                $.ajax({
                    url: self.api.getShopListApi,
                    type: 'POST',
                    success: function(res){
                        if(res.code == "0"){
                            var data = res.data;
                            data.filter(function(item){
                                item.value = item.id;
                            });
                            data.unshift({
                                value: "0",
                                name: "全部"
                            });
                            $('#nav-shop').html(template('select-tpl', {"data": data}));
                        }else{
                            modal_alert(res.msg);
                        }
                    },
                    error: errorTip
                });
                $.ajax({
                    url: self.api.getUserLevelApi,
                    type: 'POST',
                    success: function(res){
                        if(res.code == "0"){
                            var data = res.data;
                            data.filter(function(item){
                                item.value = item.id;
                                item.name = item.levelname;
                            });
                            data.unshift({
                                value: "0",
                                name: "全部"
                            });
                            $('#nav-level').html(template('select-tpl', {"data": data}));
                        }else{
                            modal_alert(res.msg);
                        }
                    },
                    error: errorTip
                });
            },
            export: function(){
                var self = this;
                $("#export").click(function(){
                    self.shop = $("#nav-shop").val();
                    self.level = $("#nav-level").val();
                    self.phone = $("#phone").val();
                    var url = self.api.exportExcelApi+'?shopId='+self.shop+'&levelId='+self.level+'&phone='+self.phone;
                    exportExcel(url);
                });
            }
        };
        new UserTable();
    })();
</script>