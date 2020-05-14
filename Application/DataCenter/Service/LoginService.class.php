<?php
/**
 * Created by PhpStorm.
 * User: jiechengkeji
 * Date: 2017/7/20
 * Time: 8:38
 */

namespace DataCenter\Service;


use DataCenter\Dao\LoginDao;
use Enum\SessionEnum;
use Think\Model;

class LoginService extends BaseService
{
    private static $loginDao;
    private $db;

    public function __construct()
    {
        $this->db = new Model();
        self::$loginDao = new LoginDao($this->db);
    }

    /*
     * 管理员手机登录账号
     */
    public function loginPhone($userName, $passWord)
    {
        $result = self::$loginDao->loginPhone($userName, $passWord);
        $this->loger("result", $result);
        if (!empty($result)) {
            session(SessionEnum::SHOP_ID, $result["shopid"]);
            return success_json("登陆成功！");
        } else {
            return fail_json("账号或密码不正确！");
        }
    }
}