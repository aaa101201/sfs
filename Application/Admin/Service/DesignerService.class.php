<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/12
 * Time: 15:49
 */

namespace Admin\Service;
use Admin\Controller\BaseController;
use Admin\Dao\DesignerDao;
use Think\Model;
use  Enum\SessionEnum;

class DesignerService extends BaseController
{
    private  static  $DesignerDao;
    private  $db;
    public  function  __construct()
    {
        $this->db=new  Model();
        self::$DesignerDao=new  DesignerDao($this->db);
    }
    public function  Designer_h(){
        $result =self::$DesignerDao->Designer_h();
        $arr=array();
        foreach ($result as $value) {
            array_push($arr,  $value['area_name']);
        }
        $arr['result']=$arr;
        $this->loger("result", $arr);
        return success_json_o("数据获取成功", $arr);
    }
    public function  Designer_d(){
        $result =self::$DesignerDao->Designer_d();
        $arr=array();
        foreach ($result as $value) {
            array_push($arr,  $value['title']);
        }
        $arr['result']=$arr;
        $this->loger("result", $arr);
        return success_json_o("数据获取成功", $arr);
    }
    public function  Designer_j(){
        $result =self::$DesignerDao->Designer_j();
        $arr=array();
        foreach ($result as $value) {
            array_push($arr,  $value['title']);
        }
        $arr['result']=$arr;
        $this->loger("result", $arr);
        return success_json_o("数据获取成功", $arr);
    }
    public function  Designer_z(){
        $result =self::$DesignerDao->Designer_z();
        $arr=array();
        foreach ($result as $value) {
            array_push($arr,  $value['title']);
        }
        $arr['result']=$arr;
        $this->loger("result", $arr);
        return success_json_o("数据获取成功", $arr);
    }
    public function  Designer_m(){
        $result =self::$DesignerDao->Designer_m();
        $arr=array();
        foreach ($result as $value) {
            array_push($arr,  $value['title']);
        }
        $arr['result']=$arr;
        $this->loger("result", $arr);
        return success_json_o("数据获取成功", $arr);
    }
    /**
     * 找设计师
     */
    public  function  Designer($groupid,$attr_value_f,$attr_value_m,$area_name,$closed,$audit,$tenders_num,$pageNumber,$pageSize){
        $pageSizee=$pageNumber*$pageSize;
        $start=$pageSizee-$pageSize;
        if ($groupid=='普通设计师'){
            $groupid=2;
        }
        $city =self::$DesignerDao->setCity_id($area_name);
        $city=$city[0]['city_id'];
        $result =self::$DesignerDao->setDesignerList($groupid,$attr_value_f,$attr_value_m,$city,$closed,$audit,$tenders_num,$start,$pageSize);
        $pageTotal = self::$DesignerDao->setDesignerConut($groupid,$attr_value_f,$attr_value_m,$city,$closed,$audit,$tenders_num);
        foreach($result as $k =>$v){
            $a=array();
            $result[$k]['photo']=$a;
            $gift_phone=$result[$k]['mobile'];
            $face =self::$DesignerDao->setmeeber($gift_phone);
            if ($face[0]['face']==""){
                $result[$k]['logo']=SessionEnum::PHOTO.'face/face.jpg';

            }else{
                $result[$k]['logo']=SessionEnum::PHOTO.$face[0]['face'];
            }
            $uid=$result[$k]['uid'];
            $result1 =self::$DesignerDao->setcom2($uid);
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
        $pageCurrent=intval($pageNumber);
        $recordTotal=intval($pageTotal['0']['pagetotal']);
        $pageTotal=ceil($recordTotal/$pageSize);
        $this->loger("result", $result);
        return success_json_d("数据获取成功", $result,$pageCurrent,$pageTotal,$recordTotal);
    }
    public function  cy_designer_yuyue($uid,$city_id,$mobile,$contact,$status,$dateline,$clientip){
        $uid =self::$DesignerDao->cy_designer_id($uid);
        $yuyue_num=$uid[0]['yuyue_num'];
        $yuyue_num=intval($yuyue_num)+1;
        $content=$uid[0]['mobile'];
        $company_id=$uid[0]['company_id'];
        $designer=$uid[0]['uid'];
        $content='预约设计师'.$content;
        $result =self::$DesignerDao->cy_designer_yuyue($city_id,$designer,$company_id,$mobile,$contact,$content,$status,$dateline,$clientip);
        if (empty($result)) {
            return fail_json("免费预约失败!");
        } else {
            $result =self::$DesignerDao->cy_yuyue($designer,$yuyue_num);
            if (empty($result)){
                return fail_json("免费预约失败!");
            }
            $this->loger("result", $result);
            return success_json_o("免费预约成功");
        }
    }
    public function  cy_designer_yuyuecx($uid){
        $result =self::$DesignerDao->cy_designer_yuyuecx($uid);
        $this->loger("result", $result);
        return success_json_o("数据获取成功", $result);
    }

    public  function  cy_Designer_a($uid){
        $data = [];
        $result =self::$DesignerDao->cy_Designer_a($uid);
        $pageTotal = self::$DesignerDao->setcy_Designer_f2($uid);
        $pageTotal =intval($pageTotal['0']['pagetotal']);
        $count=self::$DesignerDao->count($uid);
        $count=$count[0]['count'];
        $data['count']=$count;
        $resulta =self::$DesignerDao->setcy_Designer_f($uid);
        if ($resulta[0]['face']==""){
            $data['photoo']=SessionEnum::PHOTO.'face/face.jpg';
        }else{
            $data['photoo']=SessionEnum::PHOTO.$resulta[0]['face'];
        }

        $data['name'] = $result[0]['name'];
        $data['attention_num'] = $result[0]['attention_num'];
        $data['yuyue_num'] = $result[0]['yuyue_num'];
        $data['case_num'] = $result[0]['case_num'];
        $data['blog_num'] = $result[0]['blog_num'];
        $data['gsname'] = $result[0]['gsname'];
        $data['mobile'] = $result[0]['mobile'];
        $data['slogan'] = $result[0]['slogan'];
        $data['about'] = $result[0]['about'];
        $data['alphoto'] =SessionEnum::PHOTO. $result[0]['alphoto'];
        $data['photo'] =SessionEnum::PHOTOo. $result[0]['photo'];
        $data['score'] = $result[0]['score'];
        $data['score1'] = $result[0]['score1'];
        $data['score2'] = $result[0]['score2'];
        $data['score3'] = $result[0]['score3'];
        $data['commentTotal'] = $pageTotal;
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
        echo_res(0,"登录成功", $data);
        return ;
    }

    public  function   cy_Designer_f($uid,$pageNumber,$pageSize){
        $pageSizee=$pageNumber*$pageSize;
        $start=$pageSizee-$pageSize;
        $result =self::$DesignerDao->cy_Designer_f($uid,$start,$pageSize);
        foreach($result as $k =>$v){
            $uid=$result[$k]['uid'];
            $logo =self::$DesignerDao->setcy_Designer_f($uid);
            if ($logo[$k]['face']==null){
                $result[$k]['face']=SessionEnum::PHOTO.'face/face.jpg';
            }else{
                $result[$k]['face']=SessionEnum::PHOTO.$logo[$k]['face'];
            }

           // $result[$k]['uname']=$logo[0]['uname'];
        }
        $pageTotal = self::$DesignerDao->setcy_Designer_f2($uid);
        $pageCurrent=intval($pageNumber);
        $pageTotal =intval($pageTotal['0']['pagetotal']);
        $recordTotal=ceil($pageTotal/$pageSize);
        $this->loger("result", $result);
        if ($result==null){
            $data['result'] = 0;
            $data['recordTotal'] = $recordTotal;
            $data['pageCurrent'] = $pageCurrent;
            $data['pageTotal'] = $pageTotal;
            echo_res(1,"没有数据",$data);
            return ;
        }else{

            if ($result[0]==null){
                $data['result'][0]=$result;
            }else{
                $data['result'] = $result;
            }
            $data['recordTotal'] = $recordTotal;
            $data['pageCurrent'] = $pageCurrent;
            $data['pageTotal'] = $pageTotal;
            echo_res(0,"正确格式", $data);
            return ;
        }
    }
    public  function  cy_Designer_k($city_id,$designer_id,$score1,$score2,$score3,$content){
        $dateline=time();
        $replyip=gethostbyname($_ENV['COMPUTERNAME']);
        $clinetip=gethostbyname($_ENV['COMPUTERNAME']);
        $uname=$_SESSION;
        $uname=$uname['user']['uname'];
        if ($uname==""){
            return fail_json("请登录!");
        }
        $uid=self::$DesignerDao->cy_Designer_i($uname);
        $uid=$uid[0]['uid'];
        $result =self::$DesignerDao->cy_Designer_k($city_id,$designer_id,$score1,$score2,$score3,$content,$dateline,$replyip,$clinetip,$uid);
        if (empty($result)) {
            return fail_json("插入评论失败!");
        } else {
            return success_json_o("插入评论成功");
        }
    }
    public  function  cy_Designer_article($uid,$pageNumber,$pageSize){
        $pageSizee=$pageNumber*$pageSize;
        $start=$pageSizee-$pageSize;
        if($uid==''){
            $createuname=$_SESSION;
            $createuname=$createuname['user']['createuname'];
            if ($createuname==null){
                $uname=$_SESSION;
                $uname=$uname['user']['uname'];
                $uid=self::$DesignerDao->cy_Designer_i($uname);
                $uid=$uid[0]['uid'];
                $result =self::$DesignerDao->cy_Designer_article($uid,$start,$pageSize);
                $pageTotal = self::$DesignerDao->setcy_Designer_article($uid);
                $pageCurrent=intval($pageNumber);
                $recordTotal=intval($pageTotal['0']['pagetotal']);
                $pageTotal=ceil($recordTotal/$pageSize);
            }else{
                $uid=self::$DesignerDao->cy_Designer_ii($createuname);
                $uid=$uid[0]['uid'];
                $result =self::$DesignerDao->cy_Designer_article($uid,$start,$pageSize);
                $pageTotal = self::$DesignerDao->setcy_Designer_article($uid);
                $pageCurrent=intval($pageNumber);
                $recordTotal=intval($pageTotal['0']['pagetotal']);
                $pageTotal=ceil($recordTotal/$pageSize);
            }
        }else{
            $result =self::$DesignerDao->cy_Designer_article($uid,$start,$pageSize);
            $pageTotal = self::$DesignerDao->setcy_Designer_article($uid);
            $pageCurrent=intval($pageNumber);
            $recordTotal=intval($pageTotal['0']['pagetotal']);
            $pageTotal=ceil($recordTotal/$pageSize);
        }
        $this->loger("result", $result);
        return success_json_d("数据获取成功", $result,$pageCurrent,$pageTotal,$recordTotal);
    }
    public  function  cy_Designer_showinfo($uid){
        $result =self::$DesignerDao->cy_Designer_showinfo($uid);
//        $createuname=$_SESSION;
//        $createuname=$createuname['user']['createuname'];
//        if ($createuname==null){
//            $uname=$_SESSION;
//            $uname=$uname['user']['uname'];
//            $uid=self::$DesignerDao->cy_Designer_i($uname);
//            $uid=$uid[0]['uid'];
//            $result =self::$DesignerDao->cy_Designer_showinfo($uid);
//        }else{
//            $uid=self::$DesignerDao->cy_Designer_ii($createuname);
//            $uid=$uid[0]['uid'];
//            $result =self::$DesignerDao->cy_Designer_showinfo($uid);
//        }
        $this->loger("result", $result);
        return success_json_o("数据获取成功",$result);
    }
    public  function  cy_Designer_showinfoa($uid){
        $result =self::$DesignerDao->cy_Designer_showinfoa($uid);

//        $createuname=$_SESSION;
//        $createuname=$createuname['user']['createuname'];
//        if ($createuname==null){
//            $uname=$_SESSION;
//            $uname=$uname['user']['uname'];
//            $uid=self::$DesignerDao->cy_Designer_i($uname);
//            $uid=$uid[0]['uid'];
//            $result =self::$DesignerDao->cy_Designer_showinfoa($uid);
//        }else{
//            $uid=self::$DesignerDao->cy_Designer_ii($createuname);
//            $uid=$uid[0]['uid'];
//            $result =self::$DesignerDao->cy_Designer_showinfoa($uid);
//        }
        $this->loger("result", $result);
        return success_json_o("数据获取成功",$result);
    }
    public  function  cy_Designer_attention_num($uid){
        $resultt =self::$DesignerDao->cy_Designer_a($uid);
        $attention_num=$resultt[0]['attention_num']+1;
        $result =self::$DesignerDao->cy_Designer_attention_num($uid,$attention_num);
        $this->loger("result", $result);
        return success_json_o("数据获取成功",$result);
    }
}