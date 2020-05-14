<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/12
 * Time: 10:46
 */

namespace Admin\Service;
use Admin\Controller\BaseController;
use Admin\Dao\CaseeDao;
use Think\Model;
use  Enum\SessionEnum;
class CaseeService extends BaseController
{
    private  static  $CaseeDao;
    private  $db;
    public  function  __construct()
    {
        $this->db=new  Model();
        self::$CaseeDao=new  CaseeDao($this->db);
    }
    public  function  Casee_photo_c($case_id){
        $result=self::$CaseeDao->Casee_photo_c($case_id);
        foreach($result as $S =>$F){
            $result[$S]['photo']=SessionEnum::PHOTO.$result[$S]['photo'];
        }
        $arr=array();
        foreach ($result as $value) {
            array_push($arr,  $value['photo']);
        }
//        $result['count']=$result[0]['count'];
        $this->loger("result", $arr);
        return success_json_l("数据获取成功",$arr);
    }
    public  function Casee_photo($case_id){
        $resul =self::$CaseeDao->setCy_caseA($case_id);
        $uid=$resul[0]['uid'];
        $company_id=$resul[0]['company_id'];
        $result=self::$CaseeDao->Casee_photo_a($uid);
        if ($result[0]['face']==""){
            $result[0]['face']=SessionEnum::PHOTO.'face/face.jpg';
        }else{
            $result[0]['face']=SessionEnum::PHOTO.$result[0]['face'];
        }
        if ($result[0]['name']==""){
            $result =self::$CaseeDao->Casee_photo_b($company_id);
            if ($result[0]['face']==""){
                $result[0]['face']=SessionEnum::PHOTO.'face/face.jpg';
            }else{
                $result[0]['face']=SessionEnum::PHOTO.$result[0]['face'];
            }
        }
        $resultt =self::$CaseeDao->setCy_caseB($case_id);
        foreach($resultt as $I =>$A){
            $attr_value_id=$resultt[$I]['attr_value_id'];
            $attr_id=$resultt[$I]['attr_id'];
            $cy_data_attr =self::$CaseeDao->setCy_data_attr($attr_value_id,$attr_id);
            if ($attr_id==4){
                if ( $result[0]['attr_value_title']==''){
                    $result[0]['attr_value_title']=array($cy_data_attr[0]['title']);
                }else{
                    $result[0]['attr_value_title']=array( $result[0]['attr_value_title'][0],$cy_data_attr[0]['title']);
                }
            }
            if ($attr_id==5){
              $result[0]['attr_value_name']=$cy_data_attr[0]['title'];
            }
            if ($attr_id==6){
                $result[0]['attr_value_qiang']=$cy_data_attr[0]['title'];
            }
        }
        $resultk=self::$CaseeDao->Casee_photo_c($case_id);
        foreach($resultk as $S =>$F){
            $resultk[$S]['photo']=SessionEnum::PHOTO.$resultk[$S]['photo'];
        }
        $arr=array();
        foreach ($resultk as $value) {
            array_push($arr,  $value['photo']);
        }
        $pageTotal = self::$CaseeDao->setCasee_pl($case_id);
        $pageTotal=intval($pageTotal['0']['pagetotal']);
        $result[0]['commentTotal']=$pageTotal;
        $result[0]['carousel']=$arr;
        $this->loger("result", $result);
        return success_json("数据获取成功",$result);
    }
    public  function  Casee_pl($case_id,$pageNumber,$pageSize){
        $pageSizee=$pageNumber*$pageSize;
        $start=$pageSizee-$pageSize;
        $result =self::$CaseeDao->Casee_pl($case_id,$start,$pageSize);
        foreach($result as $I =>$A) {
            if ($result[$I]['face'] == "") {
                $result[$I]['face'] = SessionEnum::PHOTO . 'face/face.jpg';
            } else {
                $result[$I]['face'] = SessionEnum::PHOTO . $result[$I]['face'];
            }
        }
        $pageTotal = self::$CaseeDao->setCasee_pl($case_id);
        $pageCurrent=intval($pageNumber);
        $pageTotal=intval($pageTotal['0']['pagetotal']);
        $recordTotal=ceil($pageTotal/$pageSize);
        $this->loger("result", $result);
        return success_json_d("数据获取成功",$result,$pageCurrent,$pageTotal,$recordTotal);
    }
    public  function  Casee_plc($case_id,$content){
        $uname=$_SESSION;
        $uname=$uname['user']['uname'];
        if ($uname==""){
            return fail_json("请登录!");
        }
        $uid=self::$CaseeDao->cy_compay_uid($uname);
        $uid=$uid[0]['uid'];
        $dateline=time();
        $clinetip=gethostbyname($_ENV['COMPUTERNAME']);
        $result =self::$CaseeDao->Casee_plc($case_id,$uid,$content,$dateline,$clinetip);
        $this->loger("result", $result);
        return success_json_l("数据获取成功",$result);
    }
    public  function Casee_h(){
        $result =self::$CaseeDao->Casee_h();
        $arr=array();
        foreach ($result as $value) {
            array_push($arr,  $value['title']);
        }
        $this->loger("result", $arr);
        return success_json_l("数据获取成功",$arr);
    }
    public  function Casee_f(){
        $result =self::$CaseeDao->Casee_f();
        $arr=array();
        foreach ($result as $value) {
            array_push($arr,  $value['title']);
        }
        $this->loger("result", $arr);
        return success_json_l("数据获取成功",$arr);
    }
    public  function Casee_j(){
        $result =self::$CaseeDao->Casee_j();
        $arr=array();
        foreach ($result as $value) {
            array_push($arr,  $value['title']);
        }
        $this->loger("result", $arr);
        return success_json_l("数据获取成功",$arr);
    }
    /**
     * 装修案例
     */
    public  function  Casee($groupid,$attr_value_f,$attr_value_m,$pageNumber,$pageSize){
        $pageSizee=$pageNumber*$pageSize;
        $start=$pageSizee-$pageSize;
        $result =self::$CaseeDao->setCaseeList($groupid,$attr_value_f,$attr_value_m,$start,$pageSize);
        foreach($result as $k =>$v){
            $result[$k]['photo']=SessionEnum::PHOTO.$result[$k]['photo'];
        }
        $pageTotal = self::$CaseeDao->setCaseeConut($groupid,$attr_value_f,$attr_value_m);
        $pageCurrent=intval($pageNumber);
        $recordTotal=intval($pageTotal['0']['pagetotal']);
        $pageTotal=ceil($recordTotal/$pageSize);
        foreach($result as $k =>$v){
            $case_id=$result[$k]['case_id'];
            $resul =self::$CaseeDao->setCy_case($case_id);
            foreach($resul as $I =>$A){
                $attr_value_id=$resul[$I]['attr_value_id'];
                $attr_id=$resul[$I]['attr_id'];
                $cy_data_attr =self::$CaseeDao->setCy_data_att($attr_value_id,$attr_id);
                if ($I==0){
                    $result[$k]['attr_value_title']=$cy_data_attr[0]['title'];
                }
                if ($I==1){
                    $result[$k]['attr_value_name']=$cy_data_attr[0]['title'];
                }
            }
            $uid=$result[$k]['uid'];
            $dresul =self::$CaseeDao->setDesigner($uid);
            $phonecount =self::$CaseeDao->setPhone($case_id);
            $result[$k]['name']=$dresul[0]['name'];
            $result[$k]['phonecount']=$phonecount[0]['count'];
        }
        $this->loger("result", $result);
        return success_json_d("数据获取成功",$result,$pageCurrent,$pageTotal,$recordTotal);
    }
    public  function  Casee_phh($uid,$company_id,$pageNumber,$pageSize){
        $pageSizee=$pageNumber*$pageSize;
        $start=$pageSizee-$pageSize;
        if ($company_id==''){
            $result =self::$CaseeDao->Casee_phh($uid,$start,$pageSize);
        }else{
            $result =self::$CaseeDao->Casee_phha($company_id,$start,$pageSize);
        }
        foreach($result as $S =>$F){
            $result[$S]['photo']=SessionEnum::PHOTO.$result[$S]['photo'];
        }
        if ($company_id==''){
            $pageTotal = self::$CaseeDao->setCaseeConutCasee_ph($uid);
        }else{
            $pageTotal = self::$CaseeDao->setCaseeConutCasee_phh($company_id);
        }
        $pageCurrent=intval($pageNumber);
        $pageTotal=intval($pageTotal['0']['pagetotal']);
        $recordTotal=ceil($pageTotal/$pageSize);
        $this->loger("result", $result);
        return success_json_d("数据获取成功",$result,$pageCurrent,$pageTotal,$recordTotal);
    }
}