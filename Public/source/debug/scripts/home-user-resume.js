var userId = 0;
$(function () {   
    $(document).on("pageInit", "#userResume", function(e, id, page) {
        console.log("inited", "userResume Page!");
        $.ajax({
            type: 'get',
            url: APP_PATH + '/Home/User/detail',
            dataType: 'json',
            async : false,
            timeout: 3000,
            context: $('#wrapUserResume'),
            success: function (res) {
                if (res.code == 0) {
                    server_error();
                    return;
                }
                userId = res.data.id;
                
                var html = template("user-resume-tpl", res.data);
                this.html(html);

                ['intro', 'practice', 'planning'].forEach(function (item) {
                    var elemS = '.wrap' + item[0].toUpperCase() + item.slice(1);
                    if (res.data[item]) {
                        var html = res.data[item].replace(/\n/g, '<br>');
                        $(elemS).html(html);
                    }
                });

                var uploader = WebUploader.create({
                    auto : true,
                    duplicate:true,
                    server : APP_PATH + '/Home/User/uploadUserPhoto',
                    formData : {
                                        
                    },
                    accept : {
                        title : 'Images',
                        extensions : 'jpg,jpeg,gif,png',
                        mimeTypes : 'image/*'
                    },
                    compress:{
                        width: 500,
                        height: 500,
                        quality: 90,
                        allowMagnify: true,
                        crop: true,
                        preserveHeaders: true,
                        noCompressIfLarger: false,
                        compressSize: 0
                    }
                });

                uploader.addButton({
                    id:'#mod-user-photo',
                    innerHTML:'修改头像&nbsp;&nbsp;<span class="icon icon-right"></span>'
                });
                
                uploader.on('uploadSuccess',function(file,response){
                   $.toast(response.msg, 1000, "toast_orange");
                   if(response.code=='1'){
                       $('#user-photo').attr('src',response.data.url);
                   }
                });
            },
            error: function () {
                server_error();
            }
        }); 
    });
    $.init(); 
}); 
