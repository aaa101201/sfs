$(function () {
    // 绑定工作详情页
    $(document).on("pageInit", "#jobDetail", function(e, id, page) {

        var path = location.pathname;
        // var jobId  = path.slice(path.lastIndexOf('/')+1);
        var jobId  = path.split('/')[6];
        console.log('=========='+jobId);
        var companyId='';
        var title='';
        var applyStatus = false; //是否申请过职位状态
        var map_address = '';//兼职地址
        var map_city = '';
        var deadline = '';
        var appliedCount = 0;
        function loadDetail(jobId){
            $.ajax({
                type: 'POST',
                url: APP_PATH+ '/Home/Job/getJobDetails',
                data: {"id": jobId},
                dataType: 'json',
                async:false,
                timeout: 3000,
                context: $('#jobDetailScroll'),

                success: function(res){
                    if(res.code=='0'){
                        $.toast("(+﹏+) 找不到这个职位了", 1000, "toast_orange");
                        return;
                    } else {
                        var job= res.data;
                        
                        title =job.title;
                        map_address = job.address;
                        map_city = job.city;
                        job.companyinfo = job.companyinfo.slice(0, 150);
                        if(job.deadline){
                            job.deadline = job.deadline.substring(0,16);
                        }
                        deadline = job.deadline;
                        //电话咨询时“元/月”不显示
                        var num = /^[0-9,\.,\-,\+,\~]*$/;
                        var income = job.income;
                        var bool = num.test(income);
                        if(!bool){
                          job.incomeunit = '';
                        }
                        console.log(job.attributes[0]);
                        console.log("session", res.session);
                        companyId=job.companyid;
                        console.log("superType:", job.supertype);
                        var superType = job.supertype;
                        
                        //如果superType=1,为名企招聘,全职招聘，则更改模板
                        if(superType == 1){
                            $('.title').html('职位详情');
                            var html = template("job-detail-tpl-02", job);
                        }else{
                            var html = template("job-detail-tpl", job);
                        }
                        if(!(parseInt(job.postedCount)<parseInt(job.number))){
                            $('#btnApply').addClass('fc_999');   
                        }
                        
                        appliedCount = parseInt(job.appliedCount);

                        this.html(html);
                        $('.jobIntro').html(escapeChars(job.intro));

                        $(".job-connect").hide();
                        $(".job-connect-info").hide();

                        if(job.applied) {
                            $(".job-connect").show();
                            applyStatus = true;
                        } else {
                            $(".job-connect-info").show();
                        }

                        if(job.collected) {
                            $(".job-icon-star").addClass('iconf-fav02');
                        }

                        $('#btnApply').click(function () {
                            var jobspan = localStorage.getItem('jobspan' + jobId);
                            if (jobspan) {
                                if (new Date().getTime() < jobspan) {
                                    applyJob(0);
                                } else {
                                    localStorage.removeItem(jobspan);
                                    applyJob(superType);
                                }
                            } else {
                                applyJob(superType);
                            }
                        });
                        $('#btnFav').click(toggleCollect);

                        $('#btnTel').click(function(){
                            if(applyStatus){
                                location.href='tel:'+job.phone;
                            }else {
                                $.toast("(+﹏+) 亲，申请后才可以查看", 1000, "toast_orange");
                            }
                        });    
                        loadMap(); 
                    }
            },
            error: function(xhr, type){
              $.toast("(+﹏+) 萝卜们太热情，服务器表示鸭梨很大！", 1000, "toast_orange");
            }
          });
        }

        function applyJob(superType){
            if($('#btnApply').hasClass('fc_999')){
                $.toast("(+﹏+) 该职位已经招满了", 1000, "toast_orange");
                return;
            }
            if(deadline){
                var currentTime = new Date().getTime();
                var deadlineTime = new Date(deadline.replace(new RegExp("-","gm"),"/")).getTime();
                console.log(currentTime,deadlineTime);
                if(deadlineTime < currentTime){
                    $.toast("(+﹏+) 该职位报名截止了", 1000, "toast_orange");
                    return;
                }
            }
            
            //全职的逻辑判断
            if (superType == 1) {
                $.ajax({
                    type: 'GET',
                    url: APP_PATH + '/Home/User/detail',
                    dataType: 'json',
                    success: function (res) {
                        if (!res.code) {
                            $.toast("(+﹏+) 您还没有登录", 1000, "toast_orange");
                            setTimeout(function(){
                                location.href=APP_PATH+"/Home/Wechat/signIn?jobId=" + jobId;
                            }, 1000);
                            return;
                        }
                        judgeShouldFillResume(res);
                    },
                    error: server_error
                });

                return;
            }

            $.ajax({
                type: 'get',
                url:APP_PATH+ '/Home/Apply/job',
                data: {"id": jobId,'companyId':companyId,'title':title},
                dataType: 'json',
                timeout: 3000,
                success: function(res){
                    if (res.code=='1'){
                        $.toast("(^_^) 申请职位成功！", 1000, "toast_orange");
                        setTimeout(function(){
                            $('.appliedCount').text(++appliedCount + '人');
                            $(".job-connect").show();
                            $(".job-connect-info").hide();
                            applyStatus = true;
                        },500)
                    } else if (res.redirect == 1) {
                        $.toast('请先完善您的信息', 1000);
                        loadLeastInfoScript(function () {
                            $.router.load(APP_PATH + '/Home/User/userLeastInfo', true);
                        });
                    } else if (res.msg=='unauthorized'){
                        $.toast("(+﹏+) 您还没有登录", 1000, "toast_orange");
                        setTimeout(function(){
                            location.href = APP_PATH+"/Home/Wechat/signIn?jobId=" + jobId;
                        },500);
                    } else {
                        $.toast(res.msg,1000,"toast_orange")
                    }
                },
                error: function(xhr, type){
                    $.toast("(+﹏+) 萝卜们太热情，服务器表示鸭梨很大！", 1000, "toast_orange");
                }
            });
        }

        function collectJob(icon){
            $.ajax({
                type: 'get',
                url:APP_PATH + '/Home/collect/collectJob',
                data: {"id": jobId},
                dataType: 'json',
                timeout: 3000,
                success:function(res){
                  if (res.code == 1){
                    icon.removeClass('iconf-fav ');
                    icon.addClass('iconf-fav02');
                  }else if(res.msg=='unauthorized'){
                    $.toast("(+﹏+) 您还没有登录", 1000, "toast_orange");
                    setTimeout(function(){
                      location.href = APP_PATH+"/Home/Wechat/signIn?jobId=" + jobId;
                    },1000);
                  } else{
                    $.toast("(+﹏+)" + res.msg, 1000, "toast_orange");
                  }
                },
                error:function(res){
                  $.toast("(+﹏+) 萝卜们太热情，服务器表示鸭梨很大！", 1000, "toast_orange");
                }
            });
        }

        function decollectJob(icon){
            $.ajax({
                type: 'get',
                url:APP_PATH + '/Home/collect/cancelCollect',
                data: {"id": jobId},
                dataType: 'json',
                timeout: 3000,
                success:function(res){
                  if (res.code == 1){
                    icon.removeClass('iconf-fav02 ');
                    icon.addClass('iconf-fav');
                  } else if(res.msg=='unauthorized'){
                    $.toast("(+﹏+) 您还没有登录", 1000, "toast_orange");
                    setTimeout(function(){
                      location.href=APP_PATH+"/Home/Wechat/signIn";
                    },1000);      
                  } else{
                    $.toast("(+﹏+)" + res.msg, 1000, "toast_orange");
                  }
                },
                error:function(res){
                  $.toast("(+﹏+) 萝卜们太热情，服务器表示鸭梨很大！", 1000, "toast_orange");
                }
            });
        }    

        function toggleCollect(){
            var icon = $(this).children().eq(0);
            if (icon.hasClass('iconf-fav02')){
                decollectJob(icon);
            } else{
                collectJob(icon);
            }
        }    

        loadDetail(jobId);
        //外部链接进入详情页，详情页返回键处理
        function disposeHistoryPage(){
            var qLink = getQueryStringArgs()['qLink'];
            console.log('qLink:'+qLink);
            if(qLink == 1){
                $('header a').removeClass('back');
                $('header a').attr('external','external');
            }
        }
        disposeHistoryPage();
        function getQueryStringArgs () {
            var qs = (location.search.length > 0 ? location.search.substring(1) : ""),
            args = {},
            items = qs.length ? qs.split("&") : [],
            item = null,
            name = null,
            value = null,
            i = 0,
            len = items.length;

            for (i = 0; i < len; i++) {
                item = items[i].split("=");
                name = decodeURIComponent(item[0]);
                value = decodeURIComponent(item[1]);
                if (name.length) {
                    args[name] = value;
                }
            }
            return args;
        }
        function loadMap(){
            var point = new BMap.Point(122.09395837, 37.52878708); //默认威海
            // 创建Map实例
            var map = new BMap.Map("allmap"); 
            map.centerAndZoom(point, 14);
            $('#allmap').css('height','6rem');
            map.enableScrollWheelZoom(true);
            map.enableContinuousZoom(true); 
            var myGeo = new BMap.Geocoder();
            var city = map_city || "威海";
            console.log(map_address,map_city);
            myGeo.getPoint(map_address, function (point) {
                if (point) {
                    map.centerAndZoom(point, 16);
                    map.addOverlay(new BMap.Marker(point));
                } else {
                    // $.toast(">///< 地图君无法定位到该位置~<br />");
                }
            }, city);
        }

        //判断用户是否应该填写简历
        function judgeShouldFillResume(res) {
            if (!res.data.planning || !res.data.practice || !res.data.intro) {
                $.toast('请先完善您的简历~', 1000);
                loadFullInfoScript(function () {
                    $.router.load(APP_PATH + '/Home/User/userFullInfo?jobId=' + jobId, false);
                });
            } else {
                var option = $.modal.prototype.defaults;
                //cache
                var oldOk = option.modalButtonOk, oldCancel = option.modalButtonCancel;

                option.modalButtonOk = '去修改';
                option.modalButtonCancel = '直接申请';
                
                $.confirm('您已经填写过简历,要修改吗?',
                    function () {
                        loadFullInfoScript(function () {
                            $.router.load(APP_PATH + '/Home/User/userFullInfo?jobId=' + jobId, false);
                        });
                    },
                    function () {
                        applyJob(0);
                    }
                );

                //恢复原来的设置
                option.modalButtonOk = oldOk;
                option.modalButtonCancel = oldCancel;
            }
        }

        function loadFullInfoScript(callback) {
            var script = document.getElementById('fullInfoJS');
            if (script) {
                callback();
            } else {
                script = document.createElement('script');
                script.id = 'fullInfoJS';
                script.onload = callback;
                script.src = '/Public/source/debug/scripts/home-user-fullInfo.js';
                document.body.appendChild(script);
            }
        }

        function loadLeastInfoScript(callback) {
            var script = document.getElementById('leastInfoJS');
            if (script) {
                callback();
            } else {
                script = document.createElement('script');
                script.id = 'leastInfoJS';
                script.onload = callback;
                script.src = '/Public/source/debug/scripts/home-user-leastInfo.js';
                document.body.appendChild(script);
            }
        }

    });
    $.init();
  });