 var userId = 0;
 $(function () {   
    $(document).on("pageInit", "#userLeastInfo", function(e, id, page) {
        console.log("inited", "userLeastInfo Page!");

        var box = $('#wrapUserLeastInfo form'), btn = $('#save-least-btn');

        getInfo(showInfo);
        btn.click(saveLeastInfo);

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
            var html = template('tpl-leastInfo', res.data);
            box.html(html);
            fillPCRS(res);
        }
        
        function saveLeastInfo(){
            if (!checkInfo()) return false;
            $.ajax({
                type: 'POST',
                url: APP_PATH + '/Home/User/setUserInfo',
                dataType: 'json',
                data: box.serialize(),
                timeout: 3000,
                success: function(res) {
                    if (res.code == 1) {
                        $.toast('提交成功(^_^)', 1000);
                        setTimeout(function () {
                            $.router.back();
                        }, 1000);
                    } else {
                        $.toast("提交失败(+_+)", 1000);  
                    }   
                },
                error: server_error
            });
        }
        
        function checkInfo() {
            var toCheck = {
                realname: $('input[name="realname"]').val(),
            };
            //check if the info is ok
            var attrs = Object.keys(toCheck);
            var i = 0;
            for (; i < attrs.length; i++) {
                temp = toCheck[attrs[i]];
                temp && (temp = temp.trim());
                if (!temp) {
                    $.toast('请将信息补充完整', 1000);
                    console.warn(attrs[i]);
                    return false;
                }
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
                $("#province-list").change(reRenderCityList).trigger('change');
            }
            
            function reRenderCityList(){
                $('#city-list').html(template('city-list-tpl', { option : provinces['p'+ $(this).val()].data, current : detail.cityid } ))
                              .trigger('change');
            }

        }
    });
    $.init();
});