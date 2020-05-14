<?php if (!defined('THINK_PATH')) exit();?>
<form action="/ajax/index.php/Admin/File/publicLoad" method="post" enctype="multipart/form-data">  
    <input type="file" name="file"/>  
    <input type="submit" value="提交">  
</form>