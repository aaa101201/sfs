<?php

namespace Enum;

header("Content-Type: text/html; charset=utf-8");

class SessionEnum {

    //session中存储的信息key
    CONST USER_INFO = "userInfo";    //当前登录的用户信息数据

    CONST LOGIN_ID = "loginId";    //session中储存的当前登录用户角色名称

    CONST WECHAT_USER = "wechatUser"; // 微信session信息

    CONST WECHAT_USER_OPENID = "wechatUserOpenId"; // 微信session信息 openid

    CONST SHOP_ID = "shopId";    //session中储存的当前公众号对应的商户ID
    CONST UID = "uid";    //session中储存的当前用户id
    CONST PHOTO = 'http://www.whjz365.cn/attachs/';
    CONST PHOTOk = 'http://www.whjz365.cn/attachs';
    CONST PHOTOo = 'http://m.shulailo.cn';
    CONST WECHAT_ACCOUNT_INFO = "wechatAccountInfo";    //session中储存的当前公众号信息

    CONST SMS_LOGIN_CODE = "phonecaptcha";    //手机验证码

    CONST SMS_PHONE_TIME_STAMP = "phone_time_stamp";    //
}

?>