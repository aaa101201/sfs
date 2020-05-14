<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/12
 * Time: 15:11
 */

namespace Admin\Service;
use Admin\Controller\BaseController;
use Admin\Dao\CompayDao;
use Think\Model;
use Enum\SessionEnum;

class CompayService extends BaseController
{
    private  static  $CompayDao;
    private  $db;
    public  function  __construct()
    {
        $this->db=new  Model();
        self::$CompayDao=new  CompayDao($this->db);
    }
    public function  setFitment_h(){
        $result =self::$CompayDao->setFitment_h();
        $arr=array();
        foreach ($result as $value) {
            array_push($arr,  $value['area_name']);
        }
        $this->loger("arr", $arr);
        return success_json_l("数据获取成功", $arr);
    }
    public function  setFitment_d(){
        $result =self::$CompayDao->setFitment_d();
        $arr=array();
        foreach ($result as $value) {
            array_push($arr,  $value['title']);
        }
        $this->loger("arr", $arr);
        return success_json_l("数据获取成功", $arr);
    }
    public function  setFitment_f(){
        $result =self::$CompayDao->setFitment_f();
        $arr=array();
        foreach ($result as $value) {
            array_push($arr,  $value['title']);
        }
        $this->loger("arr", $arr);
        return success_json_l("数据获取成功", $arr);
    }
    public function  setFitment_g(){
        $result =self::$CompayDao->setFitment_g();
        $arr=array();
        foreach ($result as $value) {
            array_push($arr,  $value['title']);
        }
        $this->loger("arr", $arr);
        return success_json_l("数据获取成功", $arr);
    }
    public function  setFitment_m(){
        $result =self::$CompayDao->setFitment_m();
        $arr=array();
        foreach ($result as $value) {
            array_push($arr,  $value['title']);
        }
        $this->loger("arr", $arr);
        return success_json_l("数据获取成功", $arr);
    }

    public  function  setFitment($groupid,$attr_value_f,$attr_value_m,$area_name,$closed,$audit,$tenders_num,$pageNumber,$pageSize){
        if ($groupid=='普通装修公司'){
            $groupid=4;
        }
        if ($groupid=='砖石装修公司'){
            $groupid=5;
        }
        $city =self::$CompayDao->setCity_id($area_name);
        $city=$city[0]['city_id'];
        $pageSizee=$pageNumber*$pageSize;
        $start=$pageSizee-$pageSize;
        $result =self::$CompayDao->setFitmentList( $groupid,$attr_value_f,$attr_value_m,$city,$closed,$audit,$tenders_num,$start,$pageSize);
        foreach($result as $k =>$v){
            $a=array();
            $result[$k]['photo']=$a;
            $result[$k]['commentTotal']= $result[$k]['commenttotal'];
            $comments=$result[$k]['commenttotal'];
//            $score=$result[$k]['score'];
            $comments=intval($comments);
//            $score=intval($score);
//            $comments=ceil($score/$comments);
//            $comments=intval($comments);
            $result[$k]['comments']=$comments;
            $score=$result[$k]['score'];
            $score1=$result[$k]['score1'];
            if ($score1==0&&$score==0){
                $score=0;
            }else{
                $score=$score/$score1;
            }
            $result[$k]['score']=$score;

//            $gift_phone=$result[$k]['phone'];
            $company_id=$result[$k]['company_id'];
            $result[$k]['logo']=SessionEnum::PHOTO.$result[$k]['logo'];
            $result1 =self::$CompayDao->setcom($company_id);
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
        $pageTotal = self::$CompayDao->setFitmentConut($groupid,$attr_value_f,$attr_value_m,$city,$closed,$audit,$tenders_num);
        $pageCurrent=intval($pageNumber);
        $recordTotal=intval($pageTotal['0']['pagetotal']);
        $pageTotal=ceil($recordTotal/$pageSize);
        $this->loger("result", $result);
        return success_json_d("数据获取成功", $result,$pageCurrent,$pageTotal,$recordTotal);
    }
    /**
     * 找装修公司详情
     */
    public  function  cy_compay_a($company_id){
        $data = [];
        $count=self::$CompayDao->count($company_id);
        $count=$count[0]['count'];
        $result =self::$CompayDao->cy_compay_b($company_id);
        $result=$result[0];
        if ($result['photoo']==""){
            $data['photoo']=SessionEnum::PHOTO.'face/face.jpg';
        }else{
            $data['photoo']=SessionEnum::PHOTO.$result['photoo'];
        }
        $data['photo']=SessionEnum::PHOTOo.$result['photo'];
        $data['thumb']=SessionEnum::PHOTO.$result['thumb'];
        $data['commentTotal']=$result['count'];
        $data['count']=$count;
        $data['name'] = $result['name'];
        $data['tenders_num'] = $result['tenders_num'];
        $data['case_num'] = $result['case_num'];
        $data['yuyue_num'] = $result['yuyue_num'];
        $data['info'] = $result['info'];
        $data['addr'] = $result['addr'];
        $data['comments'] =$result['comments'];
        $data['score'] = $result['score'];
        $data['score1'] = $result['score1'];
        $data['score2'] = $result['score2'];
        $data['score3'] = $result['score3'];
        if ($result['score']==null){
            $data['pd'] = false;
        }else{
            $data['pd'] = true;
        }
        if ($data['score']>5){
            $data['score'] =5;
        }
        if ($data['score1']>5){
            $data['score1'] =5;
        }
        if ($data['score2']>5){
            $data['score2'] =5;
        }
        if ($data['score3']>5){
            $data['score3'] =5;
        }
//        $a= $data['score1'];
//        $b= $data['score2'];
//        $c= $data['score3'];
//        $data['score']=$a+$b+$c;
        echo_res(0,"登录成功", $data);
        return ;
    }
    public  function  cy_compay_h($company_id){
        $result =self::$CompayDao->cy_compay_h($company_id);
        $result['photoo']=SessionEnum::PHOTO.$result['photoo'];
        $result['photo']=SessionEnum::PHOTOo.$result['photo'];
        $result['thumb']=SessionEnum::PHOTO.$result['thumb'];
        $this->loger("result", $result);
        return success_json_o("数据获取成功", $result);
    }
    public  function  cy_compay_c($company_id){
        $result =self::$CompayDao->cy_compay_c($company_id);
        foreach($result as $k =>$v){
            if ($result[$k]['face']==""){
                $result[$k]['face']=SessionEnum::PHOTO.'face/face.jpg';
            }else{
                $result[$k]['face']=SessionEnum::PHOTO.$result[$k]['face'];
            }
        }
        if ($result==null){
            $data['result']='';
            echo_res(1,"没有数据",$data);
            return ;
        }else{
            $data = [];
            if ($result[0]==null){
                $data['result'][0]=$result;
            }else{
                $data['result'] = $result;
            }
            echo_res(0,"正确格式", $data);
            return ;
        }
    }
    public  function  cy_compay_f($company_id,$pageNumber,$pageSize){
        $pageSizee=$pageNumber*$pageSize;
        $start=$pageSizee-$pageSize;
        $result =self::$CompayDao->cy_compay_f($company_id,$start,$pageSize);
        foreach($result as $k =>$v){
            $uid=$result[$k]['uid'];
            $logo =self::$CompayDao->setCy_compay_f($uid);
            $face=$logo[0]['face'];
            $result[$k]['uname']=$logo[0]['uname'];
            if ($face==""){
                $result[$k]['face']=SessionEnum::PHOTO.'face/face.jpg';
            }else{
                $result[$k]['face']=SessionEnum::PHOTO.$face;
            }
        }
        $pageTotal = self::$CompayDao->setcy_compay_v($company_id);
        $pageCurrent=intval($pageNumber);
        $recordTotal=intval($pageTotal['0']['pagetotal']);
        $pageTotal=ceil($recordTotal/$pageSize);
        $this->loger("result", $result);
        return success_json_d("数据获取成功", $result,$pageCurrent,$pageTotal,$recordTotal);
    }
    public  function  cy_compay_k($city_id,$compay_id,$score1,$score2,$score3,$score4,$score5,$content){
        $dateline=time();
        $replyip=gethostbyname($_ENV['COMPUTERNAME']);
        $clinetip=gethostbyname($_ENV['COMPUTERNAME']);
        $uname=$_SESSION;
        $uname=$uname['user']['uname'];
        if ($uname==""){
            return fail_json("请登录!");
        }
        $uid=self::$CompayDao->cy_compay_uid($uname);
        $uid=$uid[0]['uid'];
        $result =self::$CompayDao->setcompany($compay_id);
        $comments=$result[0]['comments'];
        $comments=$comments+1;
        self::$CompayDao->cy_compay_kk($compay_id,$comments);

        $result =self::$CompayDao->cy_compay_k($city_id,$compay_id,$score1,$score2,$score3,$score4,$score5,$content,$dateline,$replyip,$clinetip,$uid);
        if (empty($result)) {
            return fail_json("插入评论失败!");
        } else {
            return success_json_o("插入评论成功");
        }
    }
    public function  cy_compay_yuyue($company_id,$city_id,$mobile,$contact,$status,$dateline,$clientip){
        $uname=$_SESSION;
        $uname=$uname['user']['uname'];
        if ($uname==""){
            return fail_json("请登录!");
        }
        $uid=self::$CompayDao->cy_compay_uid($uname);
        $uid=$uid[0]['uid'];
        $result =self::$CompayDao->cy_compay_yuyue($uid,$company_id,$city_id,$mobile,$contact,$status,$dateline,$clientip);
        if (empty($result)) {
            return fail_json("免费预约失败!");
        } else {
            $this->loger("result", $result);
            return success_json_o("免费预约成功");
        }
    }
    public function  cy_compay_yuyuecx($company_id){
        $result =self::$CompayDao->cy_compay_yuyuecx($company_id);
        $this->loger("result", $result);
        return success_json_o("数据获取成功", $result);
    }
}