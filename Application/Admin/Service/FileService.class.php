<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/2
 * Time: 14:30
 */
use Admin\Controller\BaseController;
use Admin\Dao\FileDao;
use Think\Model;

class FileService  extends  BaseController
{
    private  static  $FileDao;
    private  $db;
    public  function  __construct()
    {
        $this->db=new  Model();
        self::$FileDao=new  FileDao($this->db);
    }
    public  function  setgs($localLicence){
        $createtime=date("Y-m-d H:i:s");
        $updatetime=date("Y-m-d H:i:s");
        $result =self::$FileDao->setgs($localLicence,$createtime,$updatetime);
        $this->loger("result", $result);
        if (empty($result) ) {
            return fail_json("上传失败!");
        } else {
            return success_json("上传成功!");
        }
    }
}