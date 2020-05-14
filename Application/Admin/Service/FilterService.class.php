<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/4
 * Time: 14:43
 */

namespace Admin\Service;

use Admin\Controller\BaseController;
use Admin\Dao\FilterDao;
use Think\Model;

class FilterService extends BaseController
{
    private  static  $FilterDao;
    private  $db;
    public  function  __construct()
    {
        $this->db=new  Model();
        self::$FilterDao=new  FilterDao($this->db);
    }
    public function  Mechanic_h(){
        $result =self::$FilterDao->Mechanic_h();
        $this->loger("result", $result);
        return success_json("数据获取成功", $result);
    }
    public function  Mechanic_d(){
        $result =self::$FilterDao->Mechanic_d();
        $this->loger("result", $result);
        return success_json("数据获取成功", $result);
    }
    public function  Mechanic_g(){
        $result =self::$FilterDao->Mechanic_g();
        $this->loger("result", $result);
        return success_json("数据获取成功", $result);
    }
    public function  Mechanic_m(){
        $result =self::$FilterDao->Mechanic_m();
        $this->loger("result", $result);
        return success_json("数据获取成功", $result);
    }
}