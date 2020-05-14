<?php
namespace Admin\Controller;

use Admin\Service\IndexService;
use Enum\JsonEnum;
use Enum\SessionEnum;

class IndexController extends AuthController
{
    private static $indexService;

    public function _initialize() {
        parent::_initialize();
        self::$indexService = new IndexService();
    }

    /**
     * 获取首页系统菜单
     */
    public function menu() {
        $userInfo = session(SessionEnum::USER_INFO);
        $userId=$userInfo["id"];
        if (isset($userId)) {
            $menus = self::$indexService->getMenu($userId);
            $result[JsonEnum::AJAX_DATA] = $this->menus($menus, 0);
            $this->systemLog(array("input" => $menus, "path" => __ACTION__, "operaName" => "根据角色权限检索菜单", "output" => $result));
        }
        $result[JsonEnum::AJAX_CODE] = JsonEnum::AJAX_CODE_SUCCESS;
        $this->ajaxReturn($result);

    }
    //登录
    public function login() {
        $uname=I("uname");
        $passwd=I("passwd", "", "md5");// 密码
//        $uname='15666219025';
//        $passwd='4297f44b13955235245b2497399d7a93';
        $result=self::$indexService->login($uname,$passwd);

        $this->loger("result",$result);
      //  $this->ajaxReturn($result);
    }
    //修改资料查询
    public  function  Umember_zl(){
        $result=self::$indexService->Umember_zl();
        $this->loger('result', $result);
    }
    //修改资料修改
    public  function  Umember_zlx(){
        $realname=I("realname");
        $city_id=I("city_id");
        $time=I("time");
        $result=self::$indexService->Umember_zlx($realname,$city_id,$time);
        $this->loger('result', $result);
        $this->ajaxReturn($result);
    }
    //修改密码
    public  function  Umember_mm(){
//        $uname='15666319077';
//        $passwd='15666319076';
//        $xpasswd='15666319077';
//        $qpasswd='15666319077';
      $passwd=I("passwd", "", "md5");
      $xpasswd=I("xpasswd", "", "md5");
      $qpasswd=I("qpasswd", "", "md5");
        $result=self::$indexService->Umember_mm($passwd,$xpasswd,$qpasswd);
        $this->loger('result', $result);
        $this->ajaxReturn($result);
    }
    /**
     * @param $data
     * @param $pid
     * @return 设置menu子菜单
     */
    private function menus($data, $pid) {
        $menus = array();
        foreach ($data as $menu) {
            if ($menu['pid'] == $pid) {
                $menu['menus'] = $this->menus($data, $menu['id']);
                array_push($menus, $menu);
            }
        }
        return $menus;
    }
}