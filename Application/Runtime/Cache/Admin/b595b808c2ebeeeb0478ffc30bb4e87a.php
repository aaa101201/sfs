<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<title>jQuery Ajax</title>
	<meta charset="utf-8"/>
	<script src="/Public/styles/jquery-1.7.1.js" type="text/javascript"></script>
	<script src="/Public/styles/messages_zh.js" type="text/javascript"></script>
	<script src="/Public/styles/jquery.validate.js" type="text/javascript"></script>
	<script src="/Public/styles/card.js" type="text/javascript"></script>
</head>
<body>
<div id="result" style="background:orange;border:1px solid red;width:300px;height:200px;"></div>
<form id="formtest" action="" method="post">
	<p><span>用户名:</span><input type="text" name="username" id="username" /></p>
	<p><span>密码:</span><input type="password" name="password" id="rpassword" /></p>
	<button id="send_ajax" />提交</button>
</form>
</body>
</html>
<script>
    $(document).ready(function (){
        //Ajax方式
        $('#send_ajax').click(function (){
            var params=$('input').serialize();
            $.ajax({
                cache: true,
                url:'/index.php/Admin/User/doLogin',
                type:'post',
                dataType:'json',
                data:params,
                required: true,
                minlength: 6,
				equalTo: "",
                async: false,
                success:function(json) {
                    var str="姓名:"+json.code+"<br />";
                    str+="密码:"+json.msg+"<br />";
                    str+="条数:"+json.total+"<br />";
                    $("#result").html(str);
                }

            });
        });
    });
    $(function ()
    {
        $("#formtest").validate({
            rules:
                {
                    username: { required: true, minlength: 3, maxlength: 18 },
                    password: { required: true , equalTo: "#password" },

                },
            messages:
                {
                    password: {
                        equalTo: ""
                    },
                },
			/*错误提示位置*/
            errorPlacement: function (error, element)
            {
                error.appendTo(element.parent());
            }
        })
    })
</script>