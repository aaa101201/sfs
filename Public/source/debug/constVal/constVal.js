/*
*此文件为前端用到的状态字段作统一的定义
*/
var statusEnum = {
	//交易类型
	TYPE_DECREASE : 0, //减少
	TYPE_INCREASE : 1, //增加

	//用户订单类型
	ORDERTYPE_USER_DEPOSIT : 0, //用户充值
	ORDERTYPE_USER_WAGE : 1, //用户获得薪水
	ORDERTYPE_USER_WITHDRAWCASH : 2, //用户提现

	//企业订单类型
	ORDERTYPE_COMPANY_DEPOSIT : 20,  //企业充值
	ORDERTYPE_COMPANY_PAYOFF : 21, //企业发工资

	//通用类型
    ORDERTYPE_GAINS : 100,

	//订单状态
	STATUS_ORDER_FAILED  : 0,    //失败
	STATUS_ORDER_PROCESSING : 1, //处理中
	STATUS_ORDER_SUCCEEDED : 2,  //成功

	//钱包状态
	STATUS_DISABLED : 0, //禁用
	STATUS_NORMAL : 1, //正常
	STATUS_FREEZED : 2, //冻结

	//支付方式
	PAY_TYPE_WECHAT : 0,//微信支付
	PAY_TYPE_ALIPAY : 1 //支付宝支付

	//钱包与支付宝转入转出
	,ORDERTYPE_Wallet_Balance : 105 //余额宝与钱包
	,STATUS_ORDER_UNBLOCK : 2 //转出余额宝，解冻
	,STATUS_ORDER_BLOCK : 4 //转入余额宝，冻结
	,STATUS_ORDER_ACTIVE : 5 //转入余额宝，解冻
};

var handler = function (enumer) {
	for (key in enumer) {
		if (enumer.hasOwnProperty(key)) {
			template.helper(key, (function (key) {
				return function () {
					return String(enumer[key]);
				};
			})(key));
		}
	}
};

handler(statusEnum);
