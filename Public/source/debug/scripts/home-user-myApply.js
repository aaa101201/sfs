$(function() {
    // 取消申请
    function bindCancelApply() {
        $('.btnCancelFav').on('click', function (e) {
            var id = $(this).data("id");
            console.log("bindCancelApply:", id);
            $.ajax({
                type: 'GET',
                url: APP_PATH+'/Home/Apply/setStatus',
                data: { 
                    "id": id, 
                    "status": 2
                },
                dataType: 'json',
                timeout: 3000,
                success: function(data){
                    if(data.code) {
                        $.toast("(^_^) 操作成功！", 1000);
                        $("#apply_"+id).remove();
                        $("#unapply_"+id).remove();
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
    // Step1: 初始化"待录用"列表
    var status = "1_5";
    var pageSize = 10;
    var currPage = 1;
    var loading = false;
    var maxItems = 100;

    function addItems() {
        $.ajax({
            type: 'GET',
            url: APP_PATH+'/Home/Apply/filter',
            data: { 
                "currPage": currPage, 
                "pageSize": pageSize, 
                "status": status
            },
            dataType: 'json',
            timeout: 3000,
            context: $('.jobList'),
            success: function(data){
                if(data.code) {
                    maxItems = data.data.total;
                    if(maxItems <= 0) return false;
                    var data = { "jobs": data.data.data };
                    console.log(data);
                    //电话咨询时“元/月”不显示
                    for(var i = 0;i<data.jobs.length;i++){
                      var num = /^[0-9,\.,\-,\+,\~]*$/;
                      var income = data.jobs[i].income;
                      var bool = num.test(income);
                      if(!bool){
                        data.jobs[i].incomeUnit = '';
                      }
                    }
                    
                    this.append(template('job-apply-list-tpl', data));
                    if(maxItems < pageSize) {
                        $('.infinite-scroll-preloader').hide();
                    }
                    loading = false;
                    currPage++;
                    bindCancelApply();
                } else {
                    data_warn();
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

    // 注册'infinite'事件处理函数
    $(document).on('infinite', '.infinite-scroll-bottom', function() {
        if (loading) return;
        loading = true;
        setTimeout(function() {
            if (maxItems <= (currPage-1) * pageSize) {
                data_warn();
                $.detachInfiniteScroll($('.infinite-scroll'));
                $('.infinite-scroll-preloader').hide();
                return;
            }
            addItems();
            $.refreshScroller();
        }, 100);
    });      

    

    addItems();  
    var item = '待录用';//记录item
    
    // 绑定工作列表页
    $(document).on("pageInit", "#myApply", function(e, id, page) {
        
        console.log("inited page::", "myApply");
        
        // 绑定选择菜单事件
        $('.tab-link').off('click').on('click', function (e) {
            var sId = $(this).data("status");

            // Tab样式切换
            $(this).siblings().removeClass('active');
            $(this).addClass('active');

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
            status = sId;

            addItems();

            $(document).on('infinite', '.infinite-scroll-bottom', function() {
                if (loading) return;
                loading = true;
                setTimeout(function() {
                    var totalPage = Math.ceil(maxItems/pageSize); 
                    if (currPage > totalPage){
                        data_warn();
                        $.detachInfiniteScroll($('.infinite-scroll'));
                        $('.infinite-scroll-preloader').hide();
                        return;
                    }
                    addItems();
                    $.refreshScroller();

                }, 100);
            }); 
            $.init(); 
        }); 
        
    });   

    $.init();     
});