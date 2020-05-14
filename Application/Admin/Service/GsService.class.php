<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/29
 * Time: 9:45
 */

namespace Admin\Service;


use Admin\Controller\BaseController;
use Admin\Dao\GsDao;
use Think\Model;
use  Enum\SessionEnum;

class GsService extends BaseController
{
          private  static  $GsDao;
          private  $db;
          public  function  __construct()
          {
              $this->db=new  Model();
              self::$GsDao=new  GsDao($this->db);
          }
    public  function  setgs(){
        $result =self::$GsDao->setgs();
        foreach($result as $k =>$v){
            $result[$k]['photo']=SessionEnum::PHOTOo.$result[$k]['photo'];
        }        $arr=array();
        foreach ($result as $value) {
            array_push($arr,  $value['photo']);
        }
        $this->loger("result", $result);
        return success_json_o("数据获取成功", $arr);
    }
    public function  sethot(){
        $result =self::$GsDao->sethot();
        foreach($result as $k =>$v){
            $result[$k]['photo']=SessionEnum::PHOTO.$result[$k]['photo'];
        }
        $this->loger("result", $result);
        return success_json_o("数据获取成功", $result);
    }
    public function   setcompany($pageNumber,$pageSize){
        $pageSizee=$pageNumber*$pageSize;
        $start=$pageSizee-$pageSize;
        $result =self::$GsDao->setcompany($start,$pageSize);
        foreach($result as $k =>$v){
            $company_id=$result[$k]['company_id'];
            $discuss=$result[$k]['discuss'];
            $score1=$result[$k]['score1'];
            if ($score1==0&&$discuss==0){
                $score=0;
            }else{
                $score=$discuss/$score1;
            }
            $result[$k]['score']=$score;
            $result[$k]['commentTotal']= $result[$k]['commenttotal'];
            $result[$k]['logo']=SessionEnum::PHOTO.$result[$k]['logo'];
            $result1 =self::$GsDao->setcom($company_id);
            if (sizeof($result1)=='4'){
                if ($result1[3]['photo']==''){
                    $result1[3]['photo']='face/face.jpg';
                }
                if ($result1[2]['photo']==''){
                    $result1[2]['photo']='face/face.jpg';
                }
                if ($result1[0]['photo']==''){
                    $result1[0]['photo']='face/face.jpg';
                }
                if ($result1[1]['photo']==''){
                    $result1[1]['photo']='face/face.jpg';
                }
                $result[$k]['photo']=array(SessionEnum::PHOTO.$result1[0]['photo'],SessionEnum::PHOTO.$result1[1]['photo'],SessionEnum::PHOTO.$result1[2]['photo'],SessionEnum::PHOTO.$result1[3]['photo']);
            }
            if (sizeof($result1)=='3'){
                if ($result1[2]['photo']==''){
                    $result1[2]['photo']='face/face.jpg';
                }
                if ($result1[0]['photo']==''){
                    $result1[0]['photo']='face/face.jpg';
                }
                if ($result1[1]['photo']==''){
                    $result1[1]['photo']='face/face.jpg';
                }
                $result[$k]['photo']=array(SessionEnum::PHOTO.$result1[0]['photo'],SessionEnum::PHOTO.$result1[1]['photo'],SessionEnum::PHOTO.$result1[2]['photo']);
            }
            if (sizeof($result1)=='2'){
                if ($result1[0]['photo']==''){
                    $result1[0]['photo']='face/face.jpg';
                }
                $a=$result1[1]['photo'];
                if ($a==''){
                    $result1[1]['photo']='face/face.jpg';
                }
                $result[$k]['photo']=array(SessionEnum::PHOTO.$result1[0]['photo'],SessionEnum::PHOTO.$result1[1]['photo']);
            }
            if (sizeof($result1)=='1'){
                if ($result1[0]['photo']==''){
                    $result1[0]['photo']='face/face.jpg';
                }
                $result[$k]['photo']=array(SessionEnum::PHOTO.$result1[0]['photo']);
            }
            if ($result1==null){
                $result[$k]['photo']=array();
            }
        }
        $pageTotal=self::$GsDao->PageTotal_Company_cx();
        $pageCurrent=intval($pageNumber);
        $recordTotal=intval($pageTotal['0']['pagetotal']);
        $pageTotal=ceil($recordTotal/$pageSize);
        $this->loger("result", $result);
        return success_json_d("数据获取成功", $result,$pageCurrent,$pageTotal,$recordTotal);
    }
    public  function  cy_tophot(){
        $result =self::$GsDao->cy_tophot( );
        $this->loger("result", $result);
        return success_json_o("数据获取成功", $result);
    }
    public  function cy_history(){
        $uname=$_SESSION;
        $uname=$uname['user']['uname'];
        if ($uname==""){
            $result =self::$GsDao->cy_history();
        }else{
            $result =self::$GsDao->cy_historyb($uname);
        }
        $this->loger("result", $result);
        return success_json_o("数据获取成功", $result);
    }
    public  function  sethot_a($name){
        $createtime=date("Y-m-d H:i:s");
        $updatetime=date("Y-m-d H:i:s");
        $result =self::$GsDao->sethot_a($name,$createtime,$updatetime);
        $this->loger("result", $result);
        return success_json_o("数据获取成功", $result);
    }
    public  function  cy_historyss($name,$cate,$pageNumber,$pageSize){
        $createtime=date("Y-m-d H:i:s");
        $updatetime=date("Y-m-d H:i:s");
        $uname=$_SESSION;
        $uname=$uname['user']['uname'];
        $result2=self::$GsDao->cy_historyssb($name,$uname,$createtime,$updatetime);
        if (empty($result2) ) {
            return fail_json("用户搜索失败!");
        } else {
            if ($cate=='1'){
                $pageSizee=$pageNumber*$pageSize;
                $start=$pageSizee-$pageSize;
                $result =self::$GsDao->cy_historyss($name,$start,$pageSize);
                foreach($result as $k =>$v){
                    $company_id=$result[$k]['company_id'];
                    $result[$k]['logo']=SessionEnum::PHOTO.$result[$k]['logo'];
                    $result1 =self::$GsDao->setcom($company_id);
                    if (sizeof($result1)=='4'){
                        if ($result1[3]['photo']==''){
                            $result1[3]['photo']='face/face.jpg';
                        }
                        if ($result1[2]['photo']==''){
                            $result1[2]['photo']='face/face.jpg';
                        }
                        if ($result1[0]['photo']==''){
                            $result1[0]['photo']='face/face.jpg';
                        }
                        if ($result1[1]['photo']==''){
                            $result1[1]['photo']='face/face.jpg';
                        }
                        $result[$k]['photo']=array(SessionEnum::PHOTO.$result1[0]['photo'],SessionEnum::PHOTO.$result1[1]['photo'],SessionEnum::PHOTO.$result1[2]['photo'],SessionEnum::PHOTO.$result1[3]['photo']);
                    }
                    if (sizeof($result1)=='3'){
                        if ($result1[2]['photo']==''){
                            $result1[2]['photo']='face/face.jpg';
                        }
                        if ($result1[0]['photo']==''){
                            $result1[0]['photo']='face/face.jpg';
                        }
                        if ($result1[1]['photo']==''){
                            $result1[1]['photo']='face/face.jpg';
                        }
                        $result[$k]['photo']=array(SessionEnum::PHOTO.$result1[0]['photo'],SessionEnum::PHOTO.$result1[1]['photo'],SessionEnum::PHOTO.$result1[2]['photo']);
                    }
                    if (sizeof($result1)=='2'){
                        if ($result1[0]['photo']==''){
                            $result1[0]['photo']='face/face.jpg';
                        }
                        $a=$result1[1]['photo'];
                        if ($a==''){
                            $result1[1]['photo']='face/face.jpg';
                        }
                        $result[$k]['photo']=array(SessionEnum::PHOTO.$result1[0]['photo'],SessionEnum::PHOTO.$result1[1]['photo']);
                    }
                    if (sizeof($result1)=='1'){
                        if ($result1[0]['photo']==''){
                            $result1[0]['photo']='face/face.jpg';
                        }
                        $result[$k]['photo']=array(SessionEnum::PHOTO.$result1[0]['photo']);
                    }
                    if ($result1==null){
                        $result[$k]['photo']=array();
                    }
                }
//                if ($result!=null){
//                    foreach($result as $k =>$v){
//                        $result[$k]['logo']=SessionEnum::PHOTO.$result[$k]['logo'];
//                    }
//                }
                $pageTotal=self::$GsDao->PageTotal_cy_historyss();
                $pageCurrent=intval($pageNumber);
                $recordTotal=intval($pageTotal['0']['pagetotal']);
                $pageTotal=ceil($recordTotal/$pageSize);
            }
            if ($cate=='2'){
                $pageSizee=$pageNumber*$pageSize;
                $start=$pageSizee-$pageSize;
                $result =self::$GsDao->cy_historyssa($name,$start,$pageSize);
                foreach($result as $k =>$v){
                    $a=array();
                    $result[$k]['photo']=$a;
                    $gift_phone=$result[$k]['mobile'];
                    $face =self::$GsDao->setmeeber($gift_phone);
                    if ($face[0]['face']==""){
                        $result[$k]['logo']=SessionEnum::PHOTO.'face/face.jpg';

                    }else{
                        $result[$k]['logo']=SessionEnum::PHOTO.$face[0]['face'];
                    }
                    $uid=$result[$k]['uid'];
                    $result1 =self::$GsDao->setcom2($uid);
                    if (sizeof($result1)=='3'){
                        if ($result1[2]['photo']==''){
                            $result1[2]['photo']='face/face.jpg';
                        }
                        if ($result1[0]['photo']==''){
                            $result1[0]['photo']='face/face.jpg';
                        }
                        if ($result1[1]['photo']==''){
                            $result1[1]['photo']='face/face.jpg';
                        }
                        $result[$k]['photo']=array(SessionEnum::PHOTO.$result1[0]['photo'],SessionEnum::PHOTO.$result1[1]['photo'],SessionEnum::PHOTO.$result1[2]['photo']);
                    }
                    if (sizeof($result1)=='2'){
                        if ($result1[2]['photo']==''){
                            $result1[2]['photo']='face/face.jpg';
                        }
                        if ($result1[1]['photo']==''){
                            $result1[1]['photo']='face/face.jpg';
                        }
                        $result[$k]['photo']=array(SessionEnum::PHOTO.$result1[0]['photo'],SessionEnum::PHOTO.$result1[1]['photo']);
                    }
                    if (sizeof($result1)=='1'){
                        if ($result1[0]['photo']==''){
                            $result1[0]['photo']='face/face.jpg';
                        }
                        $result[$k]['photo']=array(SessionEnum::PHOTO.$result1[0]['photo']);
                    }
                    if ($result1==null){
                        $result[$k]['photo']=array();
                    }
                }
//                if ($result!=null){
//                    foreach($result as $k =>$v){
//                        $result[$k]['logo']=SessionEnum::PHOTO.$result[$k]['logo'];
//                    }
//                }
                $pageTotal=self::$GsDao->PageTotal_cy_historyssa($name);
                $pageCurrent=intval($pageNumber);
                $recordTotal=intval($pageTotal['0']['pagetotal']);
                $pageTotal=ceil($recordTotal/$pageSize);
            }
            $this->loger("result", $result);
            return success_json_d("数据获取成功", $result,$pageCurrent,$pageTotal,$recordTotal);
        }
    }

    /**
     * 找工人
     */
    public  function  Mechanic($groupid,$attr_value_f,$area_name,$closed,$audit,$tenders_num,$pageNumber,$pageSize){
        if ($groupid=='普通技工'){
            $groupid=7;
        }
        $pageSizee=$pageNumber*$pageSize;
        $start=$pageSizee-$pageSize;
        $city =self::$GsDao->setCity_id($area_name);
        $city=$city[0]['city_id'];
        $result =self::$GsDao->setMechanicList($groupid,$attr_value_f,$city,$closed,$audit,$tenders_num,$start,$pageSize);
        foreach($result as $k =>$v){
            $a=array();
            $result[$k]['photo']=$a;
            $gift_phone=$result[$k]['moible'];
            $title =self::$GsDao->setTitle($gift_phone);
            $face =self::$GsDao->setmeeber($gift_phone);
            $result[$k]['logo']=SessionEnum::PHOTO.$face['face'];
            //工种
            $result[$k]['title']=$title['title'];
            foreach($result as $I =>$A){
                $result1 =self::$GsDao->setcom3();
                $gift_phone1=$result1[$I]['phone'];
                if ($gift_phone==$gift_phone1){
                    $result[$k]['photo'][$I]=$result1[$I]['photo'];
                }
            }
        }
        $pageTotal = self::$GsDao->setMechanicConut($groupid,$attr_value_f,$city,$closed,$audit,$tenders_num);
        $pageCurrent=intval($pageNumber);
        $recordTotal=intval($pageTotal['0']['pagetotal']);
        $pageTotal=ceil($recordTotal/$pageSize);
        $this->loger("result", $result);
        return success_json_d("数据获取成功", $result,$pageCurrent,$pageTotal,$recordTotal);
    }
    /**
     * 头部图片
     */
    public  function  AdvItem($advid){
        $result =self::$GsDao->setAdvItem($advid);
        $this->loger("result", $result);
        return success_json_o("数据获取成功", $result);
    }
    /**
     * 热门案例图片链接
     */
    public  function  BlockItem($blockid){
        $result =self::$GsDao->setBlockItem($blockid);
        $this->loger("result", $result);
        return success_json_o("数据获取成功", $result);
    }
}