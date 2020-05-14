<?php
/**
 * Created by PhpStorm.
 * User: Freeman
 * Date: 2016/10/24
 * Time: 13:37
 */

namespace Home\Service;


use Think\Model;
use Home\Dao\UserDao;
use Enum\SessionEnum;

class UserService extends BaseService
{
    private static $userDAO;
    private $db;

    public function __construct()
    {
        $this->db = new Model();
        self::$userDAO = new UserDao($this->db);
    }

    public function snycUser2DB()
    {
        self::$userDAO->snycUser2DB();
    }

    public function getWtAccount($id)
    {
        $data = self::$userDAO->getWtAccount($id);
        if ($data) {
            session(SessionEnum::SHOP_ID, $data["shopid"]);
            session(SessionEnum::WECHAT_ACCOUNT_INFO, $data);
            return success_json("数据获取成功", $data);
        } else {
            return fail_json("系统内未录入该公众号信息。");
        }
    }

    public function accountExpire($openId)
    {
        $res = self::$userDAO->checkHasNotice($openId);
        if ($res) {
            return success_json("已登陆并且上次登录在7天之内，可跳过登陆界面。");
        } else {
            return fail_json("未登录或者上次登录已超过7天需要重新登录。");
        }
    }

    public function doLogin($shopId, $phone)
    {
        $id = self::$userDAO->checkPhoneUnique($shopId, $phone);
        $this->loger("result", $id);
        // 手机号已注册 将手机号 绑定该会员的微信号信息
        if ($id) {
            self::$userDAO->snycUser2DB($id);
        } else {
            // 手机号未注册，系统添加注册账号
            self::$userDAO->snycUser2DB(null, $shopId, $phone);
            $id = self::$userDAO->getLastInsertId($this->db);
            // 添加会员卡信息
            $cardNo = build_number(15);
            $levelId = self::$userDAO->getLevelDefault();
            $param = array(
                $cardNo,
                $id,
                0,
                0,
                $levelId
            );
            self::$userDAO->createCard($param);
        }
        return success_json();
    }

    public function getUserCardInfo($openId)
    {
        $data = self::$userDAO->getUserCardInfo($openId);
        $this->loger("result", $data);
        if ($data) {
            return success_json("卡信息获取成功！", $data);
        } else {
            return fail_json("卡信息获取失败！");
        }
    }

    public function getUserInfo($openId)
    {
        $data = self::$userDAO->getUserInfo($openId);
        $this->loger("result", $data);
        if ($data) {
            return success_json("用户信息获取成功！", $data);
        } else {
            return fail_json("用户信息获取失败！");
        }
    }

    public function editUserInfoByOpenId($openId, $param)
    {
        $data = self::$userDAO->getUserInfo($openId);
        if (!$data) {
            return fail_json("要更新的用户信息不存在！");
        }

        $paramFilter = array_filter($param, function ($value) {
            return strlen($value) > 0;
        });

        $data = self::$userDAO->editUserInfoByOpenId($openId, $paramFilter);
        $this->loger("result", $data);
        if ($data) {
            return success_json("用户信息获取成功！", $data);
        } else {
            return fail_json("用户信息获取失败！");
        }
    }
}