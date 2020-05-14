 var userId = 0;
 $(function () {   
    $(document).on("pageInit", "#userFullInfo", function(e, id, page) {
        console.log("inited", "userFullInfo Page!");

        var jobId = location.search.match(/jobId=(\d+)/)[1];
        var box = $('#wrapUserFullInfo form'), btn = $('#save-full-btn');

        getInfo(showInfo);
        btn.click(saveFullInfo);

        function getInfo(callback) {
            callback || (callback = function () {});
            $.ajax({
                type: 'GET',
                url: APP_PATH + '/Home/User/detail',
                dataType: 'json',
                success: callback,
                error: server_error
            });
        }

        function showInfo(res) {
            var html = template('tpl-fullInfo', res.data);
            box.html(html);
            fillPCRS(res);
        }
        
        function saveFullInfo(){
            if (!checkInfo()) return false;
            $.ajax({
                type: 'POST',
                url: APP_PATH + '/Home/User/update',
                dataType: 'json',
                data: box.serialize(),
                timeout: 3000,
                success: function(res) {
                    if (res.code == 1) {
                        localStorage.setItem('jobspan' + jobId, new Date(new Date().getTime() + 1000 * 3600).getTime());
                        $.toast('简历提交成功(^_^)', 1000);
                        setTimeout(function () {
                            $.router.back();
                        }, 1000);
                    } else {
                        $.toast("简历提交失败(+_+)", 1000);  
                    }   
                },
                error: server_error
            });
        }
        
        function checkInfo() {
            var toCheck = {
                realname: $('input[name="realname"]').val(),
                major: $('input[name="major"]').val(),
                degree: $('select[name="degree"]').val(),
                expectPay: $('select[name="expectPay"]').val(),
                practice: $('textarea[name="practice"]').val(),
                intro: $('textarea[name="intro"]').val(),
            };
            //check if the info is ok
            var attrs = Object.keys(toCheck);
            var i = 0;
            for (; i < attrs.length; i++) {
                temp = toCheck[attrs[i]];
                temp && (temp = temp.trim());
                if (!temp) {
                    $.toast('请将信息补充完整', 1000);
                    return false;
                }
            }

            //check special parts
            if (toCheck.intro.replace(/\s/g, '').length < 50) {
                $.toast('请再多介绍下自己吧', 1000);
                return false;
            }
           
            return true;
        }
        function fillPCRS(res) {
            var detail;
            var provinces ={};
            
            getDetailSuccess(res);
             
            function getDetailSuccess(res){
                userId = res.data.id;
                detail = res.data;
                console.log(detail);
                $("#userMajor").val(res.data.major); // 专业
                $.ajax({
                    type: 'POST',
                    url:APP_PATH+ '/Home/Gp/citylist',
                    dataType: 'json',
                    timeout: 3000,
                    success:getGPDataSuccess,
                    error:function(){
                        server_error();
                    }
                });
            }
            
            function getGPDataSuccess(res){
                console.log(res.data);
                var datas = res.data;
                for (var i in datas){
                    provinces['p'+(datas[i].id)] = datas[i];
                }
                $("#province-list").html(template('school-province-list-tpl',{option:provinces, current:detail.provinceid}));
                $('#region-list').change(reRenderSchoolList);
                $('#city-list').change(reRenderRegionList);
                $("#province-list").change(reRenderCityList).trigger('change');
            
                $('#grade-list').html(template('grade-list-tpl',{option:[2012,2013,2014,2015,2016/*,2017,2018,2019,2020*/],current:detail.grade}));
            }
            
            function reRenderCityList(){
                $('#city-list').html(template('city-list-tpl', { option : provinces['p'+ $(this).val()].data, current : detail.cityid } ))
                              .trigger('change');
                console.log('This is this: ' + $(this).val());
            }

            function reRenderRegionList(res){
                  $.ajax({
                    type: 'POST',
                    url:APP_PATH+ '/Home/Gp/regionlist',
                    data:{cId:$('#city-list').val()},
                    dataType: 'json',
                    timeout: 3000,
                    context:$('#region-list'),
                    success:function(res){
                        console.log('region-list'+res.data);
                        this.html(template('region-list-tpl',{option:res.data,current:detail.regionid}))
                                .trigger('change');
                    },
                    error:function(){
                        server_error();
                    }
               });
            }

            function reRenderSchoolList(res){
                  $.ajax({
                    type: 'POST',
                    url:APP_PATH+ '/Home/Gp/schoolList',
                    data:{rId:$('#region-list').val()},
                    dataType: 'json',
                    timeout: 3000,
                    context:$('#school-list'),
                    success:function(res){
                        this.html(template('school-list-tpl',{option:res.data,current:detail.schoolid}));
                    },
                    error:function(){
                        server_error();
                    }
               });
            }
        }
    });
    $.init();
});