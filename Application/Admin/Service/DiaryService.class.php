<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/17
 * Time: 10:44
 */

namespace Admin\Service;
use Admin\Controller\BaseController;
use Admin\Dao\DiaryDao;
use Think\Model;
use  Enum\SessionEnum;

class DiaryService extends BaseController
{
    private  static  $DiaryDao;
    private  $db;
    public  function  __construct()
    {
        $this->db=new  Model();
        self::$DiaryDao=new  DiaryDao($this->db);
    }
    public  function Diary_h(){
        $result =self::$DiaryDao->Diary_h();
        $this->loger("result", $result);
        return success_json("数据获取成功",$result);
    }
    public  function Diary_z(){
        $result =self::$DiaryDao->Diary_z();
        $this->loger("result", $result);
        return success_json("数据获取成功",$result);
    }
    public  function Diary_j(){
        $result =self::$DiaryDao->Diary_j();
        $this->loger("result", $result);
        return success_json("数据获取成功",$result);
    }
    public function   Diary($pageNumber,$pageSize){
        $pageSizee=$pageNumber*$pageSize;
        $start=$pageSizee-$pageSize;
        $result =self::$DiaryDao->setDiary($start,$pageSize);
        foreach($result as $k =>$v){
            $result[$k]['thumb']=SessionEnum::PHOTO.$result[$k]['thumb'];
        }
        $pageTotal=self::$DiaryDao->PageTotal_Company_cx();
        $pageCurrent=intval($pageNumber);
        $recordTotal=intval($pageTotal['0']['pagetotal']);
        $pageTotal=ceil($recordTotal/$pageSize);
        $this->loger("result", $result);
        return success_json_d("数据获取成功", $result,$pageCurrent,$pageTotal,$recordTotal);
    }
    public function   Diary_aa($pageNumber,$pageSize){
        $pageSizee=$pageNumber*$pageSize;
        $start=$pageSizee-$pageSize;
        $result =self::$DiaryDao->setDiary_aa($start,$pageSize);
        foreach($result as $k =>$v){
            $result[$k]['thumb']=SessionEnum::PHOTO.$result[$k]['thumb'];
        }
        $pageTotal=self::$DiaryDao->PageTotal_Diary_aa();
        $pageCurrent=intval($pageNumber);
        $recordTotal=intval($pageTotal['0']['pagetotal']);
        $pageTotal=ceil($recordTotal/$pageSize);
        $this->loger("result", $result);
        return success_json_d("数据获取成功", $result,$pageCurrent,$pageTotal,$recordTotal);
    }
    public function   Diary_bb($pageNumber,$pageSize){
        $pageSizee=$pageNumber*$pageSize;
        $start=$pageSizee-$pageSize;
        $result =self::$DiaryDao->setDiary_bb($start,$pageSize);
        foreach($result as $k =>$v){
            $result[$k]['thumb']=SessionEnum::PHOTO.$result[$k]['thumb'];
        }
        $pageTotal=self::$DiaryDao->PageTotal_setDiary_bb();
        $pageCurrent=intval($pageNumber);
        $recordTotal=intval($pageTotal['0']['pagetotal']);
        $pageTotal=ceil($recordTotal/$pageSize);
        $this->loger("result", $result);
        return success_json_d("数据获取成功", $result,$pageCurrent,$pageTotal,$recordTotal);
    }
    public function   Diary_a($diary_id){
        $result =self::$DiaryDao->Diary_a($diary_id);
        foreach($result as $k =>$v){
            if ($result[$k]['thumb']==""){
                $result[$k]['thumb']=SessionEnum::PHOTO.'face/face.jpg';

            }else{
                $result[$k]['thumb']=SessionEnum::PHOTO.$result[$k]['thumb'];
            }
        }
        $resultT =self::$DiaryDao->Diary_b($diary_id);
        $result[0]['step']=$resultT;
        $this->loger("result", $result);
        return success_json("数据获取成功", $result);
    }
    public function   Diary_b($diary_id){
        $result =self::$DiaryDao->Diary_b($diary_id);
        $this->loger("result", $result);
        return success_json_d("数据获取成功", $result);
    }
    public function   Diary_c($diary_id,$pageNumber,$pageSize){
        $pageSizee=$pageNumber*$pageSize;
        $start=$pageSizee-$pageSize;
        $result =self::$DiaryDao->Diary_c($diary_id,$start,$pageSize);
        foreach($result as $k =>$v){
            if ($result[$k]['face']==""){
                $result[$k]['face']=SessionEnum::PHOTO.'face/face.jpg';

            }else{
                $result[$k]['face']=SessionEnum::PHOTO.$result[$k]['face'];
            }
        }
        $pageTotal=self::$DiaryDao->PageTotal_Diary_c($diary_id);
        $pageCurrent=intval($pageNumber);
        $pageTotal=intval($pageTotal['0']['pagetotal']);
        $recordTotal=ceil($pageTotal/$pageSize);
        $this->loger("result", $result);
        return success_json_d("数据获取成功", $result,$pageCurrent,$pageTotal,$recordTotal);
    }
    public function   Diary_d($diary_id,$content){
        $uname=$_SESSION;
        $uname=$uname['user']['uname'];
        if ($uname==""){
            return fail_json("请登录!");
        }
        $uid=self::$DiaryDao->cy_compay_uid($uname);
        $uid=$uid[0]['uid'];
        $dateline=time();
        $clinetip=gethostbyname($_ENV['COMPUTERNAME']);
        $result =self::$DiaryDao->Diary_d($diary_id,$uid,$content,$dateline,$clinetip);
        $this->loger("result", $result);
        return success_json_d("数据获取成功", $result);
    }
}