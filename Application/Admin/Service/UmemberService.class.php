<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/19
 * Time: 9:48
 */

namespace Admin\Service;
use Think\Model;
use Admin\Dao\UmemberDao;
use Enum\SessionEnum;

class UmemberService extends BaseService
{
    private static $UmemberDao;
    private $db;
    public function __construct() {
        $this->db = new Model();
        self::$UmemberDao = new UmemberDao($this->db);
    }
    public  function  Umember_company(){
        $data = [];
        $createuname=$_SESSION;
        $createuname=$createuname['user']['createuname'];
        if ($createuname==null){
            $uname=$_SESSION;
            $uname=$uname['user']['uname'];
            $result =self::$UmemberDao->Umember_company($uname);
            if ($result['face']==""){
                $result['face']=SessionEnum::PHOTO.'face/face.jpg';
            }else{
                $result['face']=SessionEnum::PHOTO.$result['face'];
            }
        }else{
            $result =self::$UmemberDao->Umember_company_a($createuname);
            if ($result['face']==""){
                $result['face']=SessionEnum::PHOTO.'face/face.jpg';
            }else{
                $result['face']=SessionEnum::PHOTO.$result['face'];
            }
        }
        $data['face'] = $result['face'];
        $data['gold'] = $result['gold'];
        $data['name'] = $result['name'];
        $data['uname'] = $result['uname'];
        $data['uid'] = $result['uid'];
        if ($result['uid']==null){
            $data['pd'] = false;
        }else{
            $data['pd'] = true;
        }
        $data['company_id'] = $result['company_id'];
        echo_res(0,"登录成功", $data);
        return ;
    }
    public  function  Umember_designer(){
        $createuname=$_SESSION;
        $createuname=$createuname['user']['createuname'];
        if ($createuname==null){
            $uname=$_SESSION;
            $uname=$uname['user']['uname'];
            $result =self::$UmemberDao->Umember_designer($uname);
            if ($result['face']==""){
                $data['face']=SessionEnum::PHOTO.'face/face.jpg';
            }else{
                $data['face']=SessionEnum::PHOTO.$result['face'];
            }
        }else{
            $result =self::$UmemberDao->Umember_designer_a($createuname);
            if ($result['face']==""){
                $data['face']=SessionEnum::PHOTO.'face/face.jpg';
            }else{
                $data['face']=SessionEnum::PHOTO.$result['face'];
            }
        }

            $data['uid'] = $result['uid'];
        if ($result['uid']==null){
            $data['pd'] = false;
        }else{
            $data['pd'] = true;
        }
            $data['uname'] = $result['uname'];
            $data['name'] = $result['name'];
        $data['blog_num'] = $result['blog_num'];
          $data['yuyue_num'] = $result['yuyue_num'];
            if ($result['yuyue_num']==null){
                $data['yuyue_num'] =0;
            }
        if ($result['blog_num']==null){
            $data['blog_num'] =0;
        }
            echo_res(0,"个人中心设计师详情页", $data);
            return ;
    }
    //注册会员页面
    public  function  Umember(){
        $data = [];
        $createuname=$_SESSION;
        $createuname=$createuname['user']['createuname'];
        if ($createuname==null){
            $uname=$_SESSION;
            $uname=$uname['user']['uname'];
            $result =self::$UmemberDao->Umember_b($uname);
//            if ($result[3]['face']!=null){
//                foreach($result as $k =>$v){
//                    if ($result[$k]['face']==""){
//                        $result['face']='http://music.shulailo.cn/attachs/face/face.jpg';
//                    }else{
//                        $result['face']='http://music.shulailo.cn/attachs/'.$result[0]['face'];
//                    }
//                    $result[$k]['jingb']="0";
//                    $result[$k]['yhj']="2";
//                }
//            }
                if ($result['face']==""){
                    $data['face']=SessionEnum::PHOTO.'face/face.jpg';
                    $data['jingb']="0";
                    $data['yhj']="2";
                }else{
                    $data['face']=SessionEnum::PHOTO.$result['face'];
                    $data['jingb']="0";
                    $data['yhj']="2";
            }
        }else{
            $result =self::$UmemberDao->Umember($createuname);
//            if ($result[3]['face']!=null){
//                foreach($result as $k =>$v){
//                    if ($result[$k]['face']==""){
//                        $result['face']='http://music.shulailo.cn/attachs/face/face.jpg';
//                    }else{
//                        $result['face']='http://music.shulailo.cn/attachs/'.$result[0]['face'];
//                    }
//                    $result[$k]['jingb']="0";
//                    $result[$k]['yhj']="2";
//                }
//            }
            if ($result['face']==""){
                $data['face']=SessionEnum::PHOTO.'face/face.jpg';
                $data['jingb']="0";
                $data['yhj']="2";
            }else{
                $data['face']=SessionEnum::PHOTO.$result['face'];
                $data['jingb']="0";
                $data['yhj']="2";
            }
        }
        $data['uid'] = $result['uid'];
        $data['uname'] = $result['uname'];
        $data['name'] = $result['name'];
        echo_res(0,"登录成功", $data);
        return ;
    }
    public  function  Umember_rz($mobile,$name,$id_number,$id_photo){
        $id_photo = substr("$id_photo", -34, 42);
        $uid=self::$UmemberDao->uidd($mobile);
        $uid=$uid['uid'];
        if ($uid==''){
            return fail_json("请输入正确手机号");
        }
        $uname=$_SESSION;
        $uname=$uname['user']['uname'];
        if ($uname==''){
            return fail_json("请重新登录");
        }
        $uid=self::$UmemberDao->setUmember_rzd($uid);
        if ($uid==''){
            return fail_json("已经验证过了");
        }
        $request_time=time();
        $verify_time=time();
        $repquest_ip=gethostbyname($_ENV['COMPUTERNAME']);
        $result = self::$UmemberDao->setUmember_rz($uid,$mobile,$name,$id_number,$id_photo,$request_time,$verify_time);
        if (empty($result)) {
            return fail_json("注册实名认证失败!");
        } else {
            return success_json_o("注册实名认证成功");
        }
        //        $this->loger("result", $result);
//        return success_json("数据获取成功",$result);
    }
    public  function  Diary_s($title,$home_name,$company,$type,$way,$total_price,$start_date,$end_date,$localLicence){
        $localLicence = substr("$localLicence", -34, 42);
        $uname=$_SESSION;
        $uname=$uname['user']['createuname'];
        if ($uname==""){
            $uname=$_SESSION;
            $uname=$uname['user']['uname'];
        }
        $uid=self::$UmemberDao->uiddd($uname);
        $uid=$uid['uid'];
        $company=self::$UmemberDao->company($company);
        $company=$company['company_id'];
        $home_id=self::$UmemberDao->home_name($home_name);
        $home_id=$home_id['home_id'];
        $type=self::$UmemberDao->type($type);
        $type_id=$type['type'];
        $way=self::$UmemberDao->type($way);
        $way_id=$way['type'];
        $dateline=time();
        $clientip=gethostbyname($_ENV['COMPUTERNAME']);
        $result =self::$UmemberDao->Diary_s($uid,$title,$home_name,$company,$home_id,$type_id,$way_id,$total_price,$start_date,$end_date,$dateline,$clientip,$localLicence);
        $this->loger("result", $result);
        return success_json("数据获取成功",$result);
    }
    public  function  Umember_rjcx($diary_id){
        $result =self::$UmemberDao->Umember_rjcx($diary_id);
        $type_id=$result['type_id'];
        $type_id=self::$UmemberDao->type_id($type_id);
        $way_id=$result['way_id'];
        $way_id=self::$UmemberDao->way_id($way_id);
        $company_id=$result['company_id'];
        $company_id=self::$UmemberDao->company_id($company_id);
        $data = [];
        $data['diary_id'] = $result['diary_id'];
        $data['title'] = $result['title'];
        $data['home_name'] = $result['home_name'];
        $data['company'] =$company_id['name'];
        $data['total_price'] = $result['total_price'];
        $data['start_date'] = $result['start_date'];
        $data['end_date'] = $result['end_date'];
        $data['type_id'] = $type_id[0]['name'];
        $data['way_id'] =$way_id[0]['name'];
        $data['thumb'] = SessionEnum::PHOTO.$result['thumb'];
        if (empty($result)){
            $data['diary_id'] = '';
            $data['title'] = '';
            $data['home_name'] = '';
            $data['company'] = '';
            $data['total_price'] = '';
            $data['start_date'] = '';
            $data['end_date'] = '';
            $data['thumb'] ='';
            $data['type_id'] = '';
            $data['way_id'] = '';
        }
        echo_res(0,"正确格式", $data);
        return ;
    }
    public  function  Umember_up($diary_id,$title,$home_name,$company,$type,$way,$total_price,$start_date,$end_date,$localLicence){
        $localLicence = substr("$localLicence", -34, 42);
        $uname=$_SESSION;
        $uname=$uname['user']['createuname'];
        if ($uname==""){
            $uname=$_SESSION;
            $uname=$uname['user']['uname'];
        }
        $uid=self::$UmemberDao->uiddd($uname);
        $uid=$uid['uid'];
        $company=self::$UmemberDao->company($company);
        $company=$company['company_id'];
        $home_id=self::$UmemberDao->home_name($home_name);
        $home_id=$home_id['home_id'];
        $type=self::$UmemberDao->type($type);
        $type_id=$type['type'];
        $way=self::$UmemberDao->type($way);
        $way_id=$way['type'];
        $dateline=time();
        $clientip=gethostbyname($_ENV['COMPUTERNAME']);
        $result =self::$UmemberDao->Umember_up($diary_id,$uid,$title,$home_name,$company,$home_id,$type_id,$way_id,$total_price,$start_date,$end_date,$dateline,$clientip,$localLicence);
        if (empty($result)) {
            return fail_json("日记修改失败!");
        } else {
            return success_json("日记修改成功");
        }
    }
    public  function  Umember_y($pageNumber,$pageSize){
        $pageSizee=$pageNumber*$pageSize;
        $start=$pageSizee-$pageSize;
        $uname=$_SESSION;
        $uname=$uname['user']['createuname'];
        if ($uname==""){
            $uname=$_SESSION;
            $uname=$uname['user']['uname'];
        }
        $uid=self::$UmemberDao->uiddd($uname);
        $uid=$uid['uid'];
        $result =self::$UmemberDao->Umember_yy($uid,$start,$pageSize);
        foreach($result as $k =>$v){
            $result[$k]['title']=$result[$k]['title']."日记";
        }
        $pageTotal = self::$UmemberDao->setUmember_y($uid);
        $pageCurrent=intval($pageNumber);
        $recordTotal=intval($pageTotal['0']['pagetotal']);
        $pageTotal=ceil($recordTotal/$pageSize);
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
            echo_res(0,"个人中心设计师文章预览", $data);
            return ;
        }
    }
    public  function  Umember_wz($diary_id,$pageNumber,$pageSize){
        $pageSizee=$pageNumber*$pageSize;
        $start=$pageSizee-$pageSize;
        $result =self::$UmemberDao->Umember_wz($diary_id,$start,$pageSize);
        $pageTotal = self::$UmemberDao->setUmember_wz($diary_id);
        $pageCurrent=intval($pageNumber);
        $recordTotal=intval($pageTotal['0']['pagetotal']);
        $pageTotal=ceil($recordTotal/$pageSize);
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
            echo_res(0,"装修文章预览", $data);
            return ;
        }
    }
    public  function  Umember_delete($diary_id){
        $result =self::$UmemberDao->Umember_delete($diary_id);
        if (empty($result)) {
            return fail_json("装修日记预览删除失败!");
        } else {
            return success_json("装修日记预览删除成功");
        }
    }
    public  function  Umember_wzd($item_id){
        $result =self::$UmemberDao->Umember_wzd($item_id);
        if (empty($result)) {
            return fail_json("文章删除失败!");
        } else {
            return success_json("文章删除成功");
        }
    }
    public  function  Umember_wzjd(){
        $result =self::$UmemberDao->Umember_wzjd();
        if ($result==null){
            echo_res(1,"没有数据");
            return ;
        }else{
            $data = [];
            if ($result[0]==null){
                $data['result'][0]=$result;
            }else{
                $data['result'] = $result;
            }
            echo_res(0,"个人中心设计师文章预览", $data);
            return ;
        }
    }
    public  function  Umember_xgcx($item_id){
        $result =self::$UmemberDao->Umember_xgcx($item_id);
        $data = [];
        $data['status'] = $result['status'];
        $data['content'] = $result['content'];
        $data['title'] = $result['title'];
        $data['item_id'] = $result['item_id'];
        if (empty($result)){
            $data['status'] = '';
            $data['content'] ='';
            $data['title'] ='';
            $data['item_id'] ='';
        }
        echo_res(0,"正确格式", $data);
        return ;
    }
    public  function  Umember_xg($item_id,$status,$content){
        $dateline=time();
        if ($status=='开工大吉'){
            $status='1';
        }
        if ($status=='水电改造'){
            $status='2';
        }
        if ($status=='泥瓦工阶段'){
            $status='3';
        }
        if ($status=='木工阶段'){
            $status='4';
        }
        if ($status=='油漆阶段'){
            $status='5';
        }
        if ($status=='安装'){
            $status='6';
        }
        if ($status=='验收完成'){
            $status='7';
        }
        $result =self::$UmemberDao->Umember_xg($item_id,$status,$content,$dateline);
        if (empty($result)) {
            return fail_json("添加文章失败!");
        } else {
            return success_json("添加文章成功");
        }
    }
    public  function  Umember_cr($diary_id,$status,$content){
        $dateline=time();
        $clinetip=gethostbyname($_ENV['COMPUTERNAME']);
       if ($status=='开工大吉'){
           $status='1';
       }
        if ($status=='水电改造'){
            $status='2';
        }
        if ($status=='泥瓦工阶段'){
            $status='3';
        }
        if ($status=='木工阶段'){
            $status='4';
        }
        if ($status=='油漆阶段'){
            $status='5';
        }
        if ($status=='安装'){
            $status='6';
        }
        if ($status=='验收完成'){
            $status='7';
        }
        $result =self::$UmemberDao->Umember_cr($diary_id,$status,$content,$clinetip,$dateline);
        if (empty($result)) {
            return fail_json("添加文章失败!");
        } else {
            return success_json("添加文章成功");
        }
    }
    public  function  yuyue(){
        $uname=$_SESSION;
        $uname=$uname['user']['createuname'];
        if ($uname==""){
            $uname=$_SESSION;
            $uname=$uname['user']['uname'];
        }
        $uid=self::$UmemberDao->uiddd($uname);
        $uid=$uid['uid'];
        $result =self::$UmemberDao->yuyue($uid);
        if ($result==null){
            echo_res(1,"没有数据");
            return ;
        }else{
            $data = [];
            if ($result[0]==null){
                $data['result'][0]=$result;
            }else{
                $data['result'] = $result;
            }
            echo_res(0,"个人中心设计师文章预览", $data);
            return ;
        }
    }
    public  function  ask($pageNumber,$pageSize){
        $pageSizee=$pageNumber*$pageSize;
        $start=$pageSizee-$pageSize;
        $uname=$_SESSION;
        $uname=$uname['user']['createuname'];
        if ($uname==""){
            $uname=$_SESSION;
            $uname=$uname['user']['uname'];
        }
        $uid=self::$UmemberDao->uiddd($uname);
        $uid=$uid['uid'];
        $result =self::$UmemberDao->ask($uid,$start,$pageSize);
        $pageTotal = self::$UmemberDao->setask($uid);
        $pageCurrent=intval($pageNumber);
        $recordTotal=intval($pageTotal['0']['pagetotal']);
        $pageTotal=ceil($recordTotal/$pageSize);
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
            echo_res(0,"装修日记装修问题", $data);
            return ;
        }

    }
    public  function  ask_answer($pageNumber,$pageSize){
        $pageSizee=$pageNumber*$pageSize;
        $start=$pageSizee-$pageSize;
        $uname=$_SESSION;
        $uname=$uname['user']['createuname'];
        if ($uname==""){
            $uname=$_SESSION;
            $uname=$uname['user']['uname'];
        }
        $uid=self::$UmemberDao->uiddd($uname);
        $uid=$uid['uid'];
        $result =self::$UmemberDao->ask_answer($uid,$start,$pageSize);
        $pageTotal = self::$UmemberDao->setsk_answer($uid);
        $pageCurrent=intval($pageNumber);
        $recordTotal=intval($pageTotal['0']['pagetotal']);
        $pageTotal=ceil($recordTotal/$pageSize);
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
            echo_res(0,"装修日记装修问题", $data);
            return ;
        }
    }
    public  function  yuyue_company(){
        $uname=$_SESSION;
        $uname=$uname['user']['createuname'];
        if ($uname==""){
            $uname=$_SESSION;
            $uname=$uname['user']['uname'];
        }
        $uid=self::$UmemberDao->uiddd($uname);
        $uid=$uid['uid'];
        $result =self::$UmemberDao->yuyue_company($uid);
        if ($result==null){
            echo_res(1,"没有数据");
            return ;
        }else{
            $data = [];
            if ($result[0]==null){
                $data['result'][0]=$result;
            }else{
                $data['result'] = $result;
            }
            echo_res(0,"普通我的预约预约公司", $data);
            return ;
        }
    }
    public  function  yuyue_company_sjs($pageNumber,$pageSize){
        $pageSizee=$pageNumber*$pageSize;
        $start=$pageSizee-$pageSize;
        $uname=$_SESSION;
        $uname=$uname['user']['createuname'];
        if ($uname==""){
            $uname=$_SESSION;
            $uname=$uname['user']['uname'];
        }
        $uid=self::$UmemberDao->uiddd($uname);
        $uid=$uid['uid'];
        $result =self::$UmemberDao->yuyue_company_sjs($uid,$start,$pageSize);
        $pageTotal = self::$UmemberDao->setyuyue_company_sjs($uid);
        $pageCurrent=intval($pageNumber);
        $recordTotal=intval($pageTotal['0']['pagetotal']);
        $pageTotal=ceil($recordTotal/$pageSize);
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
            echo_res(0,"普通我的预约预约设计师", $data);
            return ;
        }
    }
    public  function  wdtb($pageNumber,$pageSize){
        $pageSizee=$pageNumber*$pageSize;
        $start=$pageSizee-$pageSize;
        $uname=$_SESSION;
        $uname=$uname['user']['createuname'];
        if ($uname==""){
            $uname=$_SESSION;
            $uname=$uname['user']['uname'];
        }
        $uid=self::$UmemberDao->uiddd($uname);
        $uid=$uid[0]['uid'];
        $result =self::$UmemberDao->wdtb($uid,$start,$pageSize);
        $pageTotal = self::$UmemberDao->setwdtb($uid);
        $pageCurrent=intval($pageNumber);
        $recordTotal=intval($pageTotal['0']['pagetotal']);
        $pageTotal=ceil($recordTotal/$pageSize);
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
            echo_res(0,"普通我的预约预约设计师", $data);
            return ;
        }
    }
    public  function  yuyue_company_sj(){
        $uname=$_SESSION;
        $uname=$uname['user']['createuname'];
        if ($uname==""){
            $uname=$_SESSION;
            $uname=$uname['user']['uname'];
        }
        $uid=self::$UmemberDao->uiddd($uname);
        $uid=$uid['uid'];
        $result =self::$UmemberDao->yuyue_company_sj($uid);
        if ($result==null){
            echo_res(1,"没有数据");
            return ;
        }else{
            $data = [];
            if ($result[0]==null){
                $data['result'][0]=$result;
            }else{
                $data['result'] = $result;
            }
            echo_res(0,"普通我的预约预约设计师", $data);
            return ;
        }
    }

    public  function  order_index($order_status){
        if ($order_status==""){
            $result =self::$UmemberDao->order_indexa($order_status);
            foreach($result as $k =>$v){
                $result[$k]['photo']=SessionEnum::PHOTO.$result[$k]['photo'];
            }
        }else{
            $result =self::$UmemberDao->order_index($order_status);
            foreach($result as $k =>$v){
                $result[$k]['photo']=SessionEnum::PHOTO.$result[$k]['photo'];
            }
        }
        $this->loger("result", $result);
        return success_json("数据获取成功",$result);
    }
    public  function  order_index_b($order_id){
        $result =self::$UmemberDao->order_index_b($order_id);
        $this->loger("result", $result);
        return success_json("数据获取成功",$result);
    }
    public  function  order_index_c($pay_status){
        $result =self::$UmemberDao->order_index_c($pay_status);
        $this->loger("result", $result);
        return success_json("数据获取成功",$result);
    }
    public  function  Umember_designer_yl($pageNumber,$pageSize){
        $pageSizee=$pageNumber*$pageSize;
        $start=$pageSizee-$pageSize;
        $uname=$_SESSION;
        $uname=$uname['user']['createuname'];
        if ($uname==""){
            $uname=$_SESSION;
            $uname=$uname['user']['uname'];
        }
        $uid=self::$UmemberDao->uiddd($uname);
        $uid=$uid['uid'];
        $result =self::$UmemberDao->Umember_designer_yl($uid,$start,$pageSize);
        $pageTotal = self::$UmemberDao->setUmember_designer_yl($uid);
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
            $data = [];
            if ($result[0]==null){
                $data['result'][0]=$result;
            }else{
                $data['result'] = $result;
            }
            $data['recordTotal'] = $recordTotal;
            $data['pageCurrent'] = $pageCurrent;
            $data['pageTotal'] = $pageTotal;
            echo_res(0,"个人中心设计师文章预览", $data);
            return ;
        }

    }
    public  function  Umember_designer_delete($article_id){
        $result =self::$UmemberDao->Umember_designer_delete($article_id);
        $this->loger("result", $result);
        return success_json("数据获取成功",$result);
    }

    public  function  Umember_designer_update($article_id,$title,$content){
        $dateline=time();
        $result =self::$UmemberDao->Umember_designer_update($article_id,$title,$content,$dateline);
        $this->loger("result", $result);
        return success_json("数据获取成功",$result);
    }
    public  function  Umember_designer_tj($title,$content){
        $uname=$_SESSION;
        $uname=$uname['user']['uname'];
        $uid=self::$UmemberDao->uiddd($uname);
        $uid=$uid['uid'];
        $dateline=time();
        $result =self::$UmemberDao->Umember_designer_tj($uid,$title,$content,$dateline);
        $this->loger("result", $result);
        return success_json("数据获取成功",$result);
    }
    public  function  Umember_designer_yuyue($pageNumber,$pageSize){
        $pageSizee=$pageNumber*$pageSize;
        $start=$pageSizee-$pageSize;
        $uname=$_SESSION;
        $uname=$uname['user']['createuname'];
        if ($uname==""){
            $uname=$_SESSION;
            $uname=$uname['user']['uname'];
        }
        $uid=self::$UmemberDao->uiddd($uname);
        $uid=$uid['uid'];
        $result =self::$UmemberDao->Umember_designer_yuyue($uid,$start,$pageSize);
        $pageTotal = self::$UmemberDao->setUmember_designer_yuyue($uid);
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
            $data = [];
            if ($result[0]==null){
                $data['result'][0]=$result;
            }else{
                $data['result'] = $result;
            }
            $data['recordTotal'] = $recordTotal;
            $data['pageCurrent'] = $pageCurrent;
            $data['pageTotal'] = $pageTotal;
            echo_res(0,"个人中心设计师预览管理", $data);
            return ;
        }
    }

    public  function  Umember_company_jg($uid){
//        $uname=$_SESSION;
//        $uname=$uname['user']['createuname'];
//        if ($uname==""){
//            $uname=$_SESSION;
//            $uname=$uname['user']['uname'];
//        }
//        $uid=self::$UmemberDao->uiddd($uname);
//        $uid=$uid['uid'];
        $dateline=time();
        $result =self::$UmemberDao->Umember_company_jg($uid,$dateline);
        $this->loger("result", $result);
        return success_json("数据获取成功",$result);
    }
    public  function  Umember_company_tj($uname){
        $unam=$_SESSION;
        $unam=$unam['user']['uname'];
        $uid=self::$UmemberDao->uidddc($unam);
        $company_id=$uid['company_id'];
        $uid=self::$UmemberDao->uiddd($uname);
        $uid=$uid['uid'];
        if ($uid==null){
            return fail_json("数据有问题");
        }
        $uidd=self::$UmemberDao->uidddd($uid);

        $uidd=$uidd['uid'];
        if ($uidd==null){
            return fail_json("填写正确手机号");
        }else{
            $dateline=time();
            $result =self::$UmemberDao->Umember_company_tj($company_id,$uid,$dateline);
            $this->loger("result", $result);
            return success_json("数据获取成功",$result);
        }

    }
    public  function  Umember_company_yuyue(){
        $uname=$_SESSION;
        $uname=$uname['user']['createuname'];
        if ($uname==""){
            $uname=$_SESSION;
            $uname=$uname['user']['uname'];
        }
        $uid=self::$UmemberDao->uidddc($uname);
        $company_id=$uid['company_id'];
        $result =self::$UmemberDao->Umember_company_yuyue($company_id);
        if ($result==null){
            echo_res(1,"没有数据");
            return ;
        }else{
            $data = [];
            if ($result[0]==null){
                $data['result'][0]=$result;
            }else{
                $data['result'] = $result;
            }
            echo_res(0,"个人中心设计师文章预览", $data);
            return ;
        }
    }
    public  function  Umember_company_team($pageNumber,$pageSize){
        $pageSizee=$pageNumber*$pageSize;
        $start=$pageSizee-$pageSize;
        $uname=$_SESSION;
        $uname=$uname['user']['createuname'];
        if ($uname==""){
            $uname=$_SESSION;
            $uname=$uname['user']['uname'];
        }
        $uid=self::$UmemberDao->uidddc($uname);
        $company_id=$uid['company_id'];
        $result =self::$UmemberDao->Umember_company_team($company_id,$start,$pageSize);
        $pageTotal = self::$UmemberDao->setUmember_company_team($company_id);
        $pageCurrent=intval($pageNumber);
        $recordTotal=intval($pageTotal['0']['pagetotal']);
        $pageTotal=ceil($recordTotal/$pageSize);
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
            echo_res(0,"个人中心装修公司", $data);
            return ;
        }
    }
    public  function  Umember_company_yuyuesjs($pageNumber,$pageSize){
        $pageSizee=$pageNumber*$pageSize;
        $start=$pageSizee-$pageSize;
        $uname=$_SESSION;
        $uname=$uname['user']['createuname'];
        if ($uname==""){
            $uname=$_SESSION;
            $uname=$uname['user']['uname'];
        }
        $uid=self::$UmemberDao->uidddc($uname);
        $company_id=$uid['company_id'];
        $result =self::$UmemberDao->Umember_company_yuyuesjs($company_id,$start,$pageSize);
        $pageTotal = self::$UmemberDao->setUmember_company_yuyuesjs($company_id);
        $pageCurrent=intval($pageNumber);
        $recordTotal=intval($pageTotal['0']['pagetotal']);
        $pageTotal=ceil($recordTotal/$pageSize);
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
            echo_res(0,"预约设计师", $data);
            return ;
        }
    }
    public  function  Umember_company_comment($pageNumber,$pageSize){
        $data = [];
        $uname=$_SESSION;
        $uname=$uname['user']['createuname'];
        if ($uname==""){
            $uname=$_SESSION;
            $uname=$uname['user']['uname'];
        }
        $pageSizee=$pageNumber*$pageSize;
        $start=$pageSizee-$pageSize;
        $uid=self::$UmemberDao->uidddc($uname);
        $company_id=$uid['company_id'];
        $result =self::$UmemberDao->Umember_company_comment($company_id,$start,$pageSize);
        $pageTotal = self::$UmemberDao->setUmember_company_comment($company_id);
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
            echo_res(0,"个人中心设计师文章预览", $data);
            return ;
        }
    }
    public  function  Umember_company_commenthf($comment_id,$reply){
        $dateline=time();
        $result =self::$UmemberDao->Umember_company_commenthf($comment_id,$reply,$dateline);
        $this->loger("result", $result);
        return success_json("数据获取成功",$result);
    }
    public  function  Umember_company_tenders(){
        $uname=$_SESSION;
        $uname=$uname['user']['createuname'];
        if ($uname==""){
            $uname=$_SESSION;
            $uname=$uname['user']['uname'];
        }
        $uid=self::$UmemberDao->uidddcd($uname);
        $area_id=$uid['area_id'];

        $result =self::$UmemberDao->Umember_company_tenders($area_id);
        $this->loger("result", $result);
        return success_json("数据获取成功",$result);
    }
    public  function  Umember_company_tenderslooked($pageNumber,$pageSize){
        $data = [];
        $uname=$_SESSION;
        $uname=$uname['user']['createuname'];
        $pageSizee=$pageNumber*$pageSize;
        $start=$pageSizee-$pageSize;
        if ($uname==""){
            $uname=$_SESSION;
            $uname=$uname['user']['uname'];
        }
        $uid=self::$UmemberDao->uidddc($uname);
        $company_id=$uid['company_id'];
        $result =self::$UmemberDao->Umember_company_tenderslooked($company_id,$start,$pageSize);
        $pageTotal = self::$UmemberDao->setUmember_company_tenderslooked($company_id);
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
            echo_res(0,"我的投标", $data);
            return ;
        }
    }
    public  function  Umember_company_site(){
        $result =self::$UmemberDao->Umember_company_site();
        if ($result==null){
            echo_res(1,"没有数据");
            return ;
        }else{
            $data = [];
            if ($result[0]==null){
                $data['result'][0]=$result;
            }else{
                $data['result'] = $result;
            }
            echo_res(0,"在建工地", $data);
            return ;
        }
    }
    public  function  Umember_company_sitetj($title,$city_id,$area_id,$house_mj,$price,$thumb,$home_name,$case_id,$addr,$intro){
        $dateline=time();
        $clientip=gethostbyname($_ENV['COMPUTERNAME']);
        $audit='1';
        $result =self::$UmemberDao->Umember_company_sitetj($title,$city_id,$area_id,$house_mj,$price,$thumb,$home_name,$case_id,$addr,$intro,$dateline,$clientip,$audit);
        $this->loger("result", $result);
        return success_json_o("数据获取成功",$result);
    }
    public  function  Umember_company_siteyl($site_id){
        $result =self::$UmemberDao->Umember_company_siteyl($site_id);
        if ($result==null){
            echo_res(1,"没有数据");
            return ;
        }else{
            $data = [];
            if ($result[0]==null){
                $data['result'][0]=$result;
            }else{
                $data['result'] = $result;
            }
            echo_res(0,"个人中心装修公司-在建工地预览", $data);
            return ;
        }
    }
    public  function  Umember_company_sitexg($title,$city_id,$area_id,$house_mj,$price,$thumb,$home_name,$case_id,$addr,$intro,$site_id){
        $dateline=time();
        $clientip=gethostbyname($_ENV['COMPUTERNAME']);
        $result =self::$UmemberDao->Umember_company_sitexg($title,$city_id,$area_id,$house_mj,$price,$thumb,$home_name,$case_id,$addr,$intro,$dateline,$clientip,$site_id);
        $this->loger("result", $result);
        return success_json_o("数据获取成功",$result);
    }
    public  function  Umember_company_sitesc($site_id){
        $result =self::$UmemberDao->Umember_company_sitesc($site_id);
        $this->loger("result", $result);
        return success_json_o("数据获取成功",$result);
    }
    public  function  Umember_company_diary($site_id){
        $result =self::$UmemberDao->Umember_company_diary($site_id);
        if ($result==null){
            echo_res(1,"没有数据");
            return ;
        }else{
            $data = [];
            if ($result[0]==null){
                $data['result'][0]=$result;
            }else{
                $data['result'] = $result;
            }
            echo_res(0,"在建工地工地日记", $data);
            return ;
        }
    }
    public  function  Umember_company_diarytj($site_id,$status,$title,$content){
        $dateline=time();
        $clientip=gethostbyname($_ENV['COMPUTERNAME']);
       if ($status=='开工大吉'){
           $status='1';
       }
        if ($status=='水电改造'){
            $status='2';
        }
        if ($status=='泥瓦工阶段'){
            $status='3';
        }
        if ($status=='木工阶段'){
            $status='4';
        }
        if ($status=='油漆阶段'){
            $status='5';
        }
        if ($status=='安装'){
            $status='6';
        }
        if ($status=='验收完成'){
            $status='7';
        }
        $result =self::$UmemberDao->Umember_company_diarytj($site_id,$status,$title,$content,$dateline,$clientip);
        $this->loger("result", $result);
        return success_json_o("数据获取成功",$result);
    }
    public  function  Umember_company_diaryxg($site_id,$status,$title,$content,$item_id){
        $dateline=time();
        $clientip=gethostbyname($_ENV['COMPUTERNAME']);
        if ($status=='开工大吉'){
            $status='1';
        }
        if ($status=='水电改造'){
            $status='2';
        }
        if ($status=='泥瓦工阶段'){
            $status='3';
        }
        if ($status=='木工阶段'){
            $status='4';
        }
        if ($status=='油漆阶段'){
            $status='5';
        }
        if ($status=='安装'){
            $status='6';
        }
        if ($status=='验收完成'){
            $status='7';
        }
        $result =self::$UmemberDao->Umember_company_diaryxg($site_id,$status,$title,$content,$dateline,$clientip,$item_id);
        $this->loger("result", $result);
        return success_json_o("数据获取成功",$result);
    }
    public  function  Umember_company_diaryly($item_id){
        $result =self::$UmemberDao->Umember_company_diaryly($item_id);
        $this->loger("result", $result);
        return success_json_o("数据获取成功",$result);
    }
    public  function  Umember_company_diarysc($item_id){
        $result =self::$UmemberDao->Umember_company_diarysc($item_id);
        $this->loger("result", $result);
        if (empty($result)) {
            return fail_json("日记删除失败!");
        } else {
            return success_json_o("日记删除成功");
        }
    }
    public  function  Umember_company_sgjd(){
        $result =self::$UmemberDao->Umember_company_sgjd();
        $this->loger("result", $result);
        return success_json_o("数据获取成功",$result);
    }
    public  function  Umember_company_home($name){
        $result =self::$UmemberDao->Umember_company_home($name);
        if ($result==null){
            echo_res(1,"没有数据");
            return ;
        }else{
            $data = [];
            if ($result[0]==null){
                $data['result'][0]=$result;
            }else{
                $data['result'] = $result;
            }
            echo_res(0,"个人中心设计师文章预览", $data);
            return ;
        }
    }
    public  function  Umember_company_cb($name){
        $result =self::$UmemberDao->Umember_company_cb($name);
        if ($result==null){
            echo_res(1,"没有数据");
            return ;
        }else{
            $data = [];
            if ($result[0]==null){
                $data['result'][0]=$result;
            }else{
                $data['result'] = $result;
            }
            echo_res(0,"个人中心设计师文章预览", $data);
            return ;
        }
    }
    public  function  type1(){
        $result =self::$UmemberDao->type1();
        $this->loger("result", $result);
        return success_json_o("数据获取成功",$result);
    }
    public  function  type2(){
        $result =self::$UmemberDao->type2();
        $this->loger("result", $result);
        return success_json_o("数据获取成功",$result);
    }
    public  function  Umember_designer_Casee(){
        $uname=$_SESSION;
        $uname=$uname['user']['createuname'];
        if ($uname==""){
            $uname=$_SESSION;
            $uname=$uname['user']['uname'];
        }
        $uid=self::$UmemberDao->uiddd($uname);
        $uid=$uid['uid'];
        $result =self::$UmemberDao->Umember_designer_Case($uid);
        $this->loger("result", $result);
        return success_json_o("数据获取成功",$result);
    }
    public  function  Umember_company_Casee(){
        $uname=$_SESSION;
        $uname=$uname['user']['createuname'];
        if ($uname==""){
            $uname=$_SESSION;
            $uname=$uname['user']['uname'];
        }
        $uid=self::$UmemberDao->uidddc($uname);
        $company_id=$uid['company_id'];
        $result =self::$UmemberDao->Umember_company_Casee($company_id);
        $this->loger("result", $result);
        return success_json_o("数据获取成功",$result);
    }
    public  function  Umember_designer_Caseesc($case_id){
        $result =self::$UmemberDao->Umember_designer_Caseesc($case_id);
        $this->loger("result", $result);
        if (empty($result)) {
            return fail_json("案例管理删除失败!");
        } else {
            return success_json_o("案例管理删除成功");
        }
    }
}