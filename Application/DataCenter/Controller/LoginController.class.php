<?php
/**
 * Created by PhpStorm.
 * User: jiechengkeji
 * Date: 2017/7/20
 * Time: 8:37
 */

namespace DataCenter\Controller;


use DataCenter\Service\LoginService;


class LoginController extends AuthController
{
    private static $loginService;

    public function _initialize()
    {
        parent::_initialize();
        self::$loginService = new LoginService();
    }

    /*
     * 管理员手机登录账号
     */
    public function loginPhone()
    {
        $userName = I("username", "", "strip_tags");//手机登录账户名
        $passWord = I("password", "", "md5");//手机登录密码
        $this->loger("username", $userName);
        $result = self::$loginService->loginPhone($userName, $passWord);
        $this->loger("result", $result);
        $this->ajaxReturn($result);
    }


}