/**
 * 导出excel
 */
var exportExcel = function(url){
    window.location = url;
}
/**
 * 错误提示
 */
var errorTip = function(){
	modal_alert('服务器繁忙~');
};
/**
 * 生成操作按钮
 */
var returnBtn = function(arr){
	var data = [];
	arr.forEach(function(item){
		switch (item) {
			case "view":
				data.push({"action": "view", "class": "", "btnIcon": "am-icon-copy", "btnName": "查看"});break;
			case "active":
				data.push({"action": "active", "class": "am-text-success", "btnIcon": "am-icon-copy", "btnName": "启用"});break;
			case "forbid":
				data.push({"action": "forbid", "class": "am-text-danger", "btnIcon": "am-icon-copy", "btnName": "禁用"});break;
			case "edit":
				data.push({"action": "edit", "class": "am-text-primary", "btnIcon": "am-icon-copy", "btnName": "编辑"});break;
			case "resetPwd":
				data.push({"action": "resetPwd", "class": "am-text-primary", "btnIcon": "am-icon-copy", "btnName": "重置密码"});break;
		}
	});
	return data;
};
//验证手机号
var isPhone = function(text) {
    return /^((17[0-9])|(14[0-9])|(13[0-9])|(15[^4,\D])|(18[0-9]))\d{8}$/.test(text);
}
//验证数字字母密码
var isPasswprd = function(text) {
    return /^[0-9A-Za-z]{6,16}$/.test(text);
}
//验证正整数
var isInt = function(text) {
    return /^[1-9]\d*$/.test(text);
}
//验证正实数，两位小数
var isNum = function(text) {
    return /^[0-9]+(.[0-9]{1,2})?$/.test(text) && (text != 0);
}
//验证帐号,数字字母组合,字母开头
var isAccountName = function(text) {
    return /^[a-zA-Z][a-zA-Z0-9_]{5,20}$/.test(text);
}
