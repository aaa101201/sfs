<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/12
 * Time: 10:45
 */

namespace Admin\Controller;
use Admin\Service\CaseeService;


class CaseeController extends  AuthController
{
    private  static $CaseeService;

    public  function  _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        self::$CaseeService=new CaseeService();
    }
    //户型
    public  function  Casee_h(){
        $result=self::$CaseeService->Casee_h();
        $this->loger('result', $result);
        $this->ajaxReturn($result);
    }
    //风格
    public  function  Casee_f(){
        $result=self::$CaseeService->Casee_f();
        $this->loger('result', $result);
        $this->ajaxReturn($result);
    }
    //价格
    public  function  Casee_j(){
        $result=self::$CaseeService->Casee_j();
        $this->loger('result', $result);
        $this->ajaxReturn($result);
    }
    /**
     * 装修案例
     */
    public  function  Casee(){
        //户型
        $groupid=I('groupid');
        //风格
        $attr_value_f=I('attr_value_f');
//        $attr_value_f='田园';
        //价格
        $attr_value_m=I('attr_value_m');
        $pageNumber=I('pageNumber',1, 'intval');// 当前页，首页为1
        $pageSize = I('pageSize', 10, 'intval');// 分页用 每页数量
        $result=self::$CaseeService->Casee($groupid,$attr_value_f,$attr_value_m,$pageNumber,$pageSize);
        $this->loger('result', $result);
        $this->ajaxReturn($result);
    }

    /**
     * s装修案例图片选择
     */
    public  function  Casee_phh(){
        $id=I('id');
        $who=I('who');
        if ($who=='designer'){
            $uid=$id;
        }
        if ($who=='company'){
            $company_id=$id;
        }
//        $uid='117';
//        $company_id='';
        $pageNumber=I('pageNumber',1, 'intval');// 当前页，首页为1
        $pageSize = I('pageSize', 10, 'intval');// 分页用 每页数量
        $result=self::$CaseeService->Casee_phh($uid,$company_id,$pageNumber,$pageSize);
        $this->loger('result', $result);
        $this->ajaxReturn($result);
    }
    /**
     * s装修案例详情页
     */
    public  function  Casee_photo(){
        $case_id=I('case_id');
//        $case_id='29';
        $result=self::$CaseeService->Casee_photo($case_id);
//        $a= $result['data'][0];
//        $result['data']=array();
//        $result['data']=$a;
        $this->loger('result', $result);
        $this->ajaxReturn($result);
    }
    /**
     * 装修案例首页图片
     * 这个现在没有用到
     */
    public  function  Casee_photo_c(){
        $case_id=I('case_id');
//        $case_id='29';
        $result=self::$CaseeService->Casee_photo_c($case_id);
        $this->loger('result', $result);
        $this->ajaxReturn($result);
    }
    /**
     * 设计师装修案例评论
     */
    public  function  Casee_pl(){
        $case_id=I('case_id');
       // $case_id='49';
        $pageNumber=I('pageNumber',1, 'intval');// 当前页，首页为1
        $pageSize = I('pageSize', 10, 'intval');// 分页用 每页数量
        $result=self::$CaseeService->Casee_pl($case_id,$pageNumber,$pageSize);
        $this->loger('result', $result);
        $this->ajaxReturn($result);
    }
    /**
     * 设计师装修案例评论插入
     */
    public  function  Casee_plc(){
        $case_id=I('case_id');
        $content=I('content');
        $result=self::$CaseeService->Casee_plc($case_id,$content);
        $this->loger('result', $result);
        $this->ajaxReturn($result);
    }
}