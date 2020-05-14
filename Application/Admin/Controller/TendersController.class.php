<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/28
 * Time: 11:41
 */

namespace Admin\Controller;
use Admin\Service\TendersService;
use Enum\SessionEnum;

class TendersController extends  AuthController
{
    private static $TendersService;

    public function _initialize()
    {
        parent::_initialize();
        self::$TendersService = new TendersService();
    }

    /**
     * 免费招标   $from = "TZX";//招标类型  3万以下  $city_id=5， 3万到5万  $city_id=6，5万到8万  $city_id=7，8万以上  $city_id=8，
     * 建材招标   $from = TJC  $city_id=0
     * 免费设计   $from = TSJ
     * 免费报价   $from = TBJ
     * 免费量房   $from = TLF
     */
    public function ZaoBiao()
    {
         $username=I("username");//姓名
         $password = I("password");//电话
         $budget=I("bugget");//金额
         $homemj=I("homemj");//装修面积
         $homemname=I("homename");//小区名称
//       $city=I("city");//城市
         $area=I("area");//区
//       $province=I("province");//省
         $addr=I("addr");//详细地址
         $comment=I("comment");//备注要求
//       免费招标  $from = "TZX";
//       建材招标   $from = TJC
//       免费设计   $from = TSJ
//       免费报价   $from = TBJ
//       免费量房   $from = TLF
         $from = I("from");
         $dimian=I("dimian");//地板,油漆,门窗'等等
         $type = I("type");//公装
         $way = I("way");
//        $type = '家装';//公装
        if ($type=='家装'){
            $type='1';
        }
        if ($type=='公装'){
            $type='2';
        }
        if ($way=='清包'){
            $way='18';
        }
        if ($way=='半包'){
            $way='19';
        }
        if ($way=='全包'){
            $way='20';
        }
        $city='7';
       //下面是测试用的
//       $username = "王海2";//姓名
//       $password = "18363100063";//电话
//       $budget = '5-8万';//金额
//       $homemj = 88;//装修面积
//       $homemname = "上海大公馆";//小区名称
////       $province='山东省';//省
//       $city = '威海市';//城市
//       $area = '环翠区';//区
//       $addr = "龙岗区";//详细地址
//       $comment = "测试sss";//备注要求
//       $from = "TJC";//招标类型
//       $dimian='地板,油漆,门窗';
        if (empty($username)) {
            $this->ajaxReturn(fail_json("请输入姓名"));
        }
        if (empty($password)) {
            $this->ajaxReturn(fail_json("请输入电话"));
        }
        $result=self::$TendersService->ZaoBiao($from, $username, $password, $budget, $homemj, $homemname, $city, $area, $addr, $comment,$dimian,$type,$way);
        $this->loger('result', $result);
        $this->ajaxReturn($result);
    }
    //最新装修招标订单
  public  function cy_trenders_a(){
      $result=self::$TendersService->cy_trenders_a();
      $this->loger('result', $result);
     // $this->ajaxReturn($result);
  }
  //装修预算
public  function  cy_trenders_b(){
    $result=self::$TendersService->cy_trenders_b();
    $a=$result['data'];
    $result['data']=array();
    $result['data']['result']=$a;
    $this->loger('result', $result);
    $this->ajaxReturn($result);
}
//建材招标类型
    public  function  cy_trenders_c(){
        $result=self::$TendersService->cy_trenders_c();
        $a=$result['data'];
        $result['data']=array();
        $result['data']['result']=$a;
        $this->loger('result', $result);
        $this->ajaxReturn($result);
    }
    //其他招标类型
    public  function  cy_trenders_e(){
        $result=self::$TendersService->cy_trenders_e();
        $a=$result['data'];
        $result['data']=array();
        $result['data']['result']=$a;
        $this->loger('result', $result);
        $this->ajaxReturn($result);
    }
    //地墙面
    public  function  cy_trenders_d(){
        $result=self::$TendersService->cy_trenders_d();
        $a=$result['data'];
        $result['data']=array();
        $result['data']['result']=$a;
        $this->loger('result', $result);
        $this->ajaxReturn($result);
    }
    //首页图片
    public  function cy_tenders_photo(){
        $result=self::$TendersService->cy_tenders_photo();
        $this->loger('result', $result);
        $this->ajaxReturn($result);
    }
}