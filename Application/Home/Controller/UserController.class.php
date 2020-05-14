<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/28 0028
 * Time: 15:11
 */

namespace Home\Controller;

use Enum\SessionEnum;
use Home\Service\UserService;

class UserController extends WechatController
{

    private $userService;

    public function _initialize() {
        parent::_initialize();
        $this->userService = new UserService();
    }

    /**
     * 发送短信验证码
     */
    public function sendSMSCode() {
        $phone = I("phone");//手机号
        // 空号不做处理
        if (empty($phone)) {
            $this->ajaxReturn(fail_json("手机号不能为空"));
        }

        $code = build_number();
        $this->loger('code', $code);
        session(SessionEnum::SMS_LOGIN_CODE, $code);
        session(SessionEnum::SMS_PHONE_TIME_STAMP, time());
        sendSmsCode($phone, $code);
        $this->ajaxReturn(success_json());
    }

    /**
     * 判断该会员是否已经登录并绑定了此账号，
     * 如果已绑定并且上次登录时间在7天之内则直接登录
     */
    public function accountExpire() {
        $accountId = I("accountId", "1", "intval");//wt_account表  公众号对应的系统表ID 默认为通达汽车
        $openId = session(SessionEnum::WECHAT_USER_OPENID);
        $result = $this->userService->accountExpire($openId);
        $this->ajaxReturn($result);
    }

    /**
     * 登录  存在手机号则登录，不存在则注册
     */
    public function signIn() {
        $phone = I("phone", "", "strip_tags");//手机号
        $code = I("code", "", "strip_tags");//验证码

        if (checkSessTime()) {
            unset($_SESSION[SessionEnum::SMS_LOGIN_CODE]);
            unset($_SESSION[SessionEnum::SMS_PHONE_TIME_STAMP]);
            $this->ajaxReturn(fail_json("手机验证码已过期，请重新获取！"));
        }
        if ($code != session(SessionEnum::SMS_LOGIN_CODE)) {
            unset($_SESSION[SessionEnum::SMS_LOGIN_CODE]);
            unset($_SESSION[SessionEnum::SMS_PHONE_TIME_STAMP]);
            $this->ajaxReturn(fail_json("手机验证码不正确，请重新输入！"));
        }
        $shopId = session(SessionEnum::SHOP_ID);
        $result = $this->userService->doLogin($shopId, $phone);
        $this->ajaxReturn($result);
    }

    /**
     * 获取用户卡基本信息
     * 1，卡号
     * 2，姓名
     * 3，卡等级
     * 4，余额
     * 5，积分
     */
    public function getUserCardInfo() {
        $openId = session(SessionEnum::WECHAT_USER_OPENID);
        $result = $this->userService->getUserCardInfo($openId);
        $this->ajaxReturn($result);
    }

    /**
     * 获取用户个人信息
     * 1，头像
     * 2，姓名
     * 3，手机号
     * 4，性别
     * 5，生日类别 生日类别 0:阴历 1:阳历
     * 6，生日
     */
    public function getUserInfo() {
        $openId = session(SessionEnum::WECHAT_USER_OPENID);
        $result = $this->userService->getUserInfo($openId);
        $this->ajaxReturn($result);
    }

    /**
     * 编辑用户个人信息
     * 1，头像
     * 2，姓名
     * 3，手机号   不允许改
     * 4，性别
     * 5，生日类别  生日类别 0:阴历 1:阳历
     * 6，生日
     */
    public function editUserInfo() {
        $headimgurl = I("headimgurl", "", "strip_tags");//头像
        $realname = I("realname", "", "strip_tags");//姓名
        $gender = I("gender", 0);//性别 0:女 1:男(wt)
        $birthtype = I("birthtype", 0);//生日类别  生日类别 0:阴历 1:阳历
        $birthday = I("birthday", "");//生日
        $openId = session(SessionEnum::WECHAT_USER_OPENID);
        $param = array(
            "headimgurl" => $headimgurl,
            "realname" => $realname,
            "gender" => $gender,
            "birthType" => $birthtype,
            "birthday" => $birthday
        );
        $result = $this->userService->editUserInfoByOpenId($openId, $param);
        $this->ajaxReturn($result);
    }
}

