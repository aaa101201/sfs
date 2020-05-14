 var userId = 0;
 $(function () {   
    $(document).on("pageInit", "#userSchoolInfo", function(e, id, page) {
        console.log("inited", "userSchoolInfo Page!");
        var detail;
        var provinces ={};
        $.ajax({
            type: 'POST',
            url:APP_PATH+ '/Home/User/detail',
            dataType: 'json',
            async : false,
            timeout: 3000,
            success: getDetailSuccess,
            error:function(){
                server_error();
            }
        });
         
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
        
        $("#save-school-btn").click(saveSchoolInfo);
        
        function saveSchoolInfo(){
            var params = {
                provinceId:$("#province-list").val(),
                cityId:$("#city-list").val(),
                schoolId:$("#school-list").val(),
                regionId:$("#region-list").val(),
                grade:$('#grade-list').val(),
                major:$("#userMajor").val()
            };
                
            $.ajax({
                type: 'POST',
                url:APP_PATH+ '/Home/User/update',
                dataType: 'json',
                data:params,
                timeout: 3000,
                success:function(res){
          
                    if(res.code==1){
                        $.toast('(^_^) 更新信息成功！', 1000);
                    }else{
                        $.toast("(+﹏+)更新信息失败！", 1000);   
                    }   
                },
                error:function(){
                    server_error();
                }
            });
        }
    });
    $.init();
});