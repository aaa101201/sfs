$(function() {
    var pageSize = 10;
    var currPage = 1;
    var loading = false;
    var maxItems = 100;
    function addItems() {
        $.ajax({
            type: 'POST',
            url: APP_PATH+'/home/Collect/listCollected',
            data: { 
                "currPage": currPage, 
                "pageSize": pageSize
            },
            dataType: 'json',
            timeout: 3000,
            context: $('.jobList'),
            success: function(data){
                console.log("data", data);
                if(data.code) {
                    maxItems = data.data.total;
                    var data = { "jobs": data.data.data };

                    // //电话咨询时“元/月”不显示
                    for(var i = 0;i<data.jobs.length;i++){
                      var num = /^[0-9,\.,\-,\+,\~]*$/;
                      var income = data.jobs[i].income;
                      var bool = num.test(income);
                      if(!bool){
                        data.jobs[i].incomeUnit = '';
                      }
                    }

                    var html = template('job-fav-list-tpl', data);
                    this.append(html);
                    $('.infinite-scroll-preloader').hide();
                    loading = false;
                    currPage ++;
                } else {
                    $.toast("您还未收藏过兼职信息！", 1000);
                    $.detachInfiniteScroll($('.infinite-scroll'));
                    $('.infinite-scroll-preloader').hide();
                }
            },
            error: function(xhr, type){
                console.log("xhr", xhr);
                server_error();
                $.detachInfiniteScroll($('.infinite-scroll'));
                $('.infinite-scroll-preloader').hide();
            }
        });
    }
    $(document).on('infinite', '.infinite-scroll-bottom', function() {
        $('.infinite-scroll-preloader').show();
        if (loading) return;
        loading = true;
        setTimeout(function() {
            if (currPage * pageSize > maxItems) {
                $.detachInfiniteScroll($('.infinite-scroll'));
                $.toast("(^_^) 木有兼职信息啦！");
                $('.infinite-scroll-preloader').hide();
                return;
            }
            addItems(currPage, pageSize);
            $.refreshScroller();
        }, 500);
    });
    addItems();      


$(document).on("pageInit", "#myFav", function(e, id, page) {
    // 点击取消收藏按钮
    $(document).bind('click', '.btnCancelFav', function () {
        var self = this;
        console.log(self.id);
        jobId = self.id;
        $.ajax({
            type: 'POST',
            url: APP_PATH+'/home/Collect/cancelCollect',
            data: { 
                "id": jobId
            },
            dataType: 'json',
            timeout: 3000,
            success: function(data){
                if(data.code){
                    // 移除此条兼职信息，需移除2个相邻的li,需等待提示后移除
                    setTimeout(function(){
                        $.toast("O(∩_∩)O 操作成功！", 1000);
                        $(self).parent().prev('.jobLi').remove();
                        $(self).parent().remove();
                    },500);
                }else{
                     server_error();
                }
            },
            error: function(xhr,type){
                server_error();
                console.log("xhr", xhr);
            }
        });
    });
}); 

$.init();  
});