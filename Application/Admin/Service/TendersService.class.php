<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/28
 * Time: 11:43
 */

namespace Admin\Service;
use Think\Model;
use Admin\Dao\TendersDao;
use Enum\SessionEnum;

use Home\Controller\BaseController;

class TendersService extends  BaseController
{
       private  static  $TendersDao;
       private  $db;
    public function __construct() {
        $this->db = new Model();
        self::$TendersDao = new TendersDao($this->db);
    }
    /**
     * 免费招标
     */
    public  function   ZaoBiao($from, $username, $password, $budget, $homemj, $homemname, $city, $area, $addr, $comment,$dimian,$type,$way){
             $ateline=time();
             $clientip = gethostbyname($_ENV['COMPUTERNAME']);
        $budget=self::$TendersDao->getbudget($budget);
        $budget=$budget[0]['setting_id'];
        $city =self::$TendersDao->setCity_id($city);
        $city=$city[0]['city_id'];
        $area =self::$TendersDao->setArea($area);
        $area=$area[0]['area_id'];
        $uid=self::$TendersDao->setUid($password);
        $uid=$uid[0]['uid'];
        $result=self::$TendersDao->getZaoBiao($from,$username,$uid,$password,$budget,$homemj,$homemname,$city,$area,$addr,$comment,$ateline,$clientip,$type,$way);
        if ($from=='TJC'){
            $result = explode(',', $dimian);
            $attr_id  =self::$TendersDao->getLastInsertId($this->db);
            foreach($result as $k =>$v){
                $attr_value_name= $result[$k];
                $attr_value_id=self::$TendersDao->attr_value_id($attr_value_name);
                $attr_value_id=$attr_value_id[0]['attr_value_id'];
                $result1=self::$TendersDao->cy_trenders($attr_id,$attr_value_id);
                if (empty($result1)){
                    return fail_json("免费招标添加失败!");
                }
            }
        }
        if (empty($result)){
            return fail_json("免费招标添加失败!");
        }else{
            return success_json_o("免费招标添加成功!");

        }
    }
    public  function cy_trenders_a(){
        $data = [];
        $result=self::$TendersDao->cy_trenders_a();
        foreach($result as $k =>$v){
            $budget_id=$result[$k]['budget_id'];
            $budget_name=self::$TendersDao->budget_id($budget_id);
            $result[$k]['budget_name']=$budget_name[0]['name'];
            $from=$result[$k]['from'];
            if ($from=='TZX'){
                $result[$k]['from']='招标';
            }
            if ($from=='TSJ'){
                $result[$k]['from']='设计';
            }
            if ($from=='TJC'){
                $result[$k]['from']='招标';
            }
            if ($from=='TBJ'){
                $result[$k]['from']='报价';
            }
            if ($from=='TLF'){
                $result[$k]['from']='量房';
            }
        }
        if ($result==null){
            echo_res(1,"没有数据");
            return ;
        }else {
            $data = [];
            if ($result[0] == null) {
                $data['result'][0] = $result;
            } else {
                $data['result'] = $result;
            }
            echo_res(0, "最新装修招标订单", $data);
            return;
        }
    }
public  function  cy_trenders_b(){
    $result=self::$TendersDao->cy_trenders_b();
    $arr=array();
    foreach ($result as $value) {

        array_push($arr,  $value['name']);
    }
    return success_json_o("数据获取成功", $arr);
}
    public  function  cy_trenders_c(){
        $result=self::$TendersDao->cy_trenders_c();
        $arr=array();
        foreach ($result as $value) {

            array_push($arr,  $value['name']);
        }
        return success_json_o("数据获取成功", $arr);
    }
    public  function  cy_trenders_d(){
        $result=self::$TendersDao->cy_trenders_d();
        $arr=array();
        foreach ($result as $value) {

            array_push($arr,  $value['title']);
        }
        return success_json_o("数据获取成功", $arr);
    }
    public  function  cy_trenders_e(){
        $result=self::$TendersDao->cy_trenders_e();
        $arr=array();
        foreach ($result as $value) {

            array_push($arr,  $value['name']);
        }
        return success_json_o("数据获取成功", $arr);
    }
    public  function  cy_tenders_photo(){
        $result=self::$TendersDao->cy_tenders_photo();
        foreach($result as $k =>$v){
            $fromb=$result[$k]['fromb'];
            $photo=SessionEnum::PHOTOo.$result[$k]['photo'];
            $result[$fromb]=$photo;
            unset($result[$k]);
        }
        return success_json_o("数据获取成功", $result);
    }
}