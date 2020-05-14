<?php
/**
 * Created by PhpStorm.
 * User: rainbow
 * Date: 16/11/18
 * Time: 上午9:55
 */

namespace Admin\Controller;
use Tools\XAuth;

class AuthController extends BaseController {

    public function _initialize() {
        parent::_initialize();
        $this->loger("_initialized", "AuthController");
        $this->authentication();

    }

    private $admin;
    // 无需验证的白名单
    private $whitelist = array(
        "",
        "Admin/User/doLogin");
    // 系统首页
    protected $errPage = "Admin/Index/index";

    private function authentication() {
        if(C('X_AUTH')) {
            $this->auth14BySession();
        }
    }

    private function auth14BySession() {
        if(!in_array(__INFO__, $this->whitelist)) {
            $this->admin = session("userInfo");
            if(!isset($this->admin)) {
                $this->loger("auth14 failed!", __INFO__);
                $this->error('非常抱歉,您没有登录系统!', __APP__, 3);
            }
        }
    }
    
    protected function getAdmin() {
        return $this->admin;
    }
}