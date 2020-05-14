$(function(){
    // 取消发布
    function bindCancelAdd() {
        $('.btnCancelFav').on('click', function (e) {
            var id = $(this).data("id");
            var self = this;
            console.log("bindCancelAdd:", id);
            $.ajax({
                type: 'GET',
                url: APP_PATH+'/Company/Job/setStatus',
                data: { 
                    "id": id, 
                    "status": 5
                },
                dataType: 'json',
                timeout: 3000,
                success: function(data){
                    if(data.code) {
                        $.toast("O(^_^)O 取消发布成功！", 1000);
                        $(self).parent().prev('.jobLi').remove();
                        $(self).parent().remove();
                    } else {
                        server_error();
                    }
                },
                error: function(xhr, type){
                    server_error();
                }
            });             
        });                    
    }

    // 结束工作
    function bindCloseJob() {
        $('.btnCancelFav').on('click', function (e) {
            var id = $(this).data("id");
            var self = this;
            console.log("bindCloseJob:", id);
            $.ajax({
                type: 'GET',
                url: APP_PATH+'/Company/Job/setStatus',
                data: { 
                    "id": id, 
                    "status": 3
                },
                dataType: 'json',
                timeout: 3000,
                success: function(data){
                    if(data.code) {
                        $.toast("O(^_^)O 操作成功！", 1000);
                        $(self).parent().prev('.jobLi').remove();
                        $(self).parent().remove();
                    } else {
                        server_error();
                    }
                },
                error: function(xhr, type){
                    server_error();
                }
            }); 
        });                    
    }

    // Step1: 职位状态 0:未审核[待审核] 1:审核通过[招聘中] 2:审核未通过[已结束] 3:结束招聘[已结束] 4:招聘过期[已结束] 5:取消发布[已结束]
    var status = 0;
    var pageSize = 10;
    var currPage = 1;
    var loading = false;
    var maxItems = 100;
    var hasLoaded = false;

    var sId = 1; //默认展示第一个tab下对应的模板内容；

    function addItems() {
        $.ajax({
            type: 'GET',
            url: APP_PATH+'/Company/Job/filter',
            data: { 
                "currPage": currPage, 
                "pageSize": pageSize,
                "status": status
            },
            dataType: 'json',
            timeout: 3000,
            success: function(data){
                if(data.code) {
                    maxItems = data.data.total;
                    if(maxItems <= 0) return false;
                    var data = { "dataList": data.data.data };
                    console.log(data);
                    
                    //电话咨询时“元/月”不显示
                    for(var i = 0;i<data.dataList.length;i++){
                      var num = /^[0-9,\.,\-,\+,\~]*$/;
                      var income = data.dataList[i].income;
                      var bool = num.test(income);
                      if(!bool){
                        data.dataList[i].incomeunit = '';
                      }
                    }

                    var html = template('tab'+sId+'-tpl', data);
                    $(".jobList").append(html);

                    if(maxItems < pageSize) {
                        $('.infinite-scroll-preloader').hide();
                    }

                    loading = false;
                    currPage++;
                    
                    if(sId == 1) {
                        bindCancelAdd();
                    } else {
                        bindCloseJob();
                    }
                } else {
                    $.toast("(^_^) 您还没有发布记录！", 1000);
                    $.detachInfiniteScroll($('.infinite-scroll'));
                    $('.infinite-scroll-preloader').remove();
                }
            },
            error: function(xhr, type){
                server_error();
                $.detachInfiniteScroll($('.infinite-scroll'));
                $('.infinite-scroll-preloader').remove();
            }
        });
    }
         
    $(document).on("pageInit", "#sendList", function(e, id, page) {
        if (!hasLoaded) {
            addItems();
            // 注册'infinite'事件处理函数
            $(document).on('infinite', '.infinite-scroll-bottom', function() {
                if (loading) return;
                loading = true;
                setTimeout(function() {
                    if (maxItems <= (currPage-1) * pageSize) {
                        $.toast("(^_^) 木有更多记录啦！", 1000);
                        $.detachInfiniteScroll($('.infinite-scroll'));
                        $('.infinite-scroll-preloader').hide();
                        return;
                    }
                    addItems();
                    $.refreshScroller();
                }, 100);
            }); 
        }
        // 绑定选择菜单事件
        $('.tab-link').off('click').on('click', function (e) {
            var self = this;
            var str = self.id;
            var tmpId = str.substring(str.length -1); //对应元素Id,非statusId
            var statusId = $(this).data("status"); //对应tab的statusId

            // Tab样式切换
            $(this).siblings().removeClass('active');
            $(this).addClass('active');
            // Content样式切换
            $('#tab_'+sId).addClass('active');
            $('#tab_'+sId).siblings().removeClass('active');

            // inited1:注销绑定滚动监听/无限加载事件/加载提示符
            $(document).off('infinite');
            $.detachInfiniteScroll($('.infinite-scroll'));
            $('.infinite-scroll-preloader').remove();
            // inited2: 重绘DOM元素
            $('.content').remove();
            $('#tab_content').html(template('scroll-base-tpl', {}));
            $.refreshScroller();
            // inited3: 分页参数
            currPage = 1;
            sId = tmpId; //通过sId,查找对应模板文件填充到content里
            status = statusId;
            $(document).on('infinite', '.infinite-scroll-bottom', function() {
                if (loading) return;
                loading = true;
                setTimeout(function() {
                    var totalPage = Math.ceil(maxItems/pageSize); 
                     if (currPage > totalPage){
                        $.toast("(^_^) 木有更多记录啦！", 1000);
                        $.detachInfiniteScroll($('.infinite-scroll'));
                        $('.infinite-scroll-preloader').hide();
                        return;
                    }
                    addItems();
                    $.refreshScroller();
                }, 100);
            }); 
            addItems();
            hasLoaded = true;
            $.init();
        });                 
    });
    $.init(); 
});