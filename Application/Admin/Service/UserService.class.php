<?php
/**
 * Created by PhpStorm.
 * User: Freeman
 * Date: 2016/10/24
 * Time: 13:37
 */

namespace Admin\Service;


use Think\Model;
use Admin\Dao\UserDao;
use Enum\SessionEnum;

class UserService extends BaseService
{
    private static $userDAO;
    private $db;

    public function __construct() {
        $this->db = new Model();
        self::$userDAO = new UserDao($this->db);
    }
    public  function  cy_member_group(){
        $result =self::$userDAO->cy_member_group();
        $this->loger("result", $result);
        return success_json("数据获取成功",$result);
    }
    public  function  designerly_j(){
        $result =self::$userDAO->designerly_j();
        $this->loger("result", $result);
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
    public  function  designerly_zyx(){
        $result =self::$userDAO->designerly_zyx();
        $this->loger("result", $result);
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
    public  function  cy_companylygsfw(){
        $result =self::$userDAO->cy_companylygsfw();
        $this->loger("result", $result);
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
    public  function  cy_companylygsgm(){
    $result =self::$userDAO->cy_companylygsgm();
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
    public  function  designer_sly(){

        $uname=$_SESSION;
        $uname=$uname['user']['uname'];
        $uid = self::$userDAO->createea($uname);
        $uid=$uid[0]['uid'];
        $result =self::$userDAO->designer_sly($uid);
        $attr_id=$result[0]['attr_id'];
        $attr_value_id=$result[0]['attr_value_id'];
        $attr_idd=$result[1]['attr_id'];
        $attr_value_idd=$result[1]['attr_value_id'];
        $data = [];
        if (empty($result)){
            $data['jy'] = '';
            $data['zw'] ='';
        }
        {
            if ($attr_id == '9') {
                $result = self::$userDAO->designer_slyy($attr_id, $attr_value_id);
                $data['jy'] = $result['title'];
            } else {
                $resultt = self::$userDAO->designer_slyy($attr_idd, $attr_value_idd);
                $data['jy'] = $resultt['title'];
            }
            if ($attr_idd == '10') {
                $result = self::$userDAO->designer_slyy($attr_idd, $attr_value_idd);
                $data['zw'] = $result['title'];
            } else {
                $resultt = self::$userDAO->designer_slyy($attr_id, $attr_value_id);
                $data['zw'] = $resultt['title'];
            }
        }
        echo_res(0,"正确格式", $data);
        return ;
    }
    public  function  designer_q(){
        $uname=$_SESSION;
        $uname=$uname['user']['uname'];
        $uid=self::$userDAO->uidddc($uname);
        $uid=$uid['uid'];
        $cy_company=$uid['cy_company'];
        $result =self::$userDAO->designer_q($uid,$cy_company);
        if ($result==null){
            echo_res(1,"没有数据");
            return ;
        }else{
            echo_res(0,"有数据");
            return ;
        }
    }
    /**
     * 业主注册
     */
    public  function  create($uname, $passwd,$from,$group_id, $mail, $gender, $city_id, $lastlogin, $loginip, $regip, $dateline){
        //会员注册调用山海通注册接口
//        if ($from == 'member') {
//            $file_contents = file_get_contents("http://api.jft365.cn/ismember/getDiscount.php?phone=" . 'uname' . "");
//            $rs=json_decode($file_contents,true);
//            if($rs['code'] == 0){
//                //山海通同步注册用户
//                //$file_contents = file_get_contents("http://api.jft365.cn/ismember/getDiscount.php?phone=" . $account['uname'] . "&passwd=".md5($account['uname'])."");
//                $file_contents = file_get_contents("http://api.jft365.cn/ismember/addMember.php?register=zhuce&phone=" . 'uname' . "&password=".'uname'."");
//            }else{
//                return fail_json("山海通用户已存在请直接登录!");
//            }
//        }
        $a=self::$userDAO->cy_member($uname);
        $a=$a['uname'];
        if ($a!=null){
            return fail_json("用户已存在");
        }
        $uid =  self::$userDAO->createId();
        $uid=$uid['uid']+1;
        $result =  self::$userDAO->create($uid,$uname, $passwd,$from,$group_id, $mail, $gender, $city_id, $lastlogin, $loginip, $regip, $dateline);
        self::$userDAO->cy_member_a($uid);
        if (empty($result) ) {
            return fail_json("用户添加失败!");
        } else {
            session(SessionEnum::USER_INFO, $uname);
            return success_json("用户添加成功!");
        }
    }
    //装修工人;资料设置
    public function setMechanic($uname,$name,$area_id,$mobile,$qq,$about,$city_id,$flushtime) {
        $uid =  self::$userDAO->createe($uname);
        $group_id=$uid['group_id'];
        $uid=$uid['uid'];
        $result1=self::$userDAO->Mechaniclist($uid);
        if (!empty($result1)){
            $result = self::$userDAO->Update_Mechaniclist($uid,$group_id,$city_id,$flushtime,$name,$area_id,$mobile,$qq,$about);
            $this->loger("result", $result);
            if (empty($result) ) {
                return fail_json("工人注册资料设置失败!");
            } else {
                return success_json("工人注册资料设置成功!");
            }
        }else{
            $result = self::$userDAO->setMechaniclist($uid,$group_id,$city_id,$flushtime,$name,$area_id,$mobile,$qq,$about);
            $this->loger("result", $result);
            if (empty($result) ) {
                return fail_json("工人注册资料设置失败!");
            } else {
                return success_json("工人注册资料设置成功!");
            }
        }
    }
    //装修工人;属性设置
    public  function  Mechanic_s($uname,$attr_id,$attr_value_id){
        $uid =  self::$userDAO->createe($uname);
        $uid=$uid['uid'];
        $result1=self::$userDAO->Mechanic_k($uid);
        if (!empty($result1)){
            self::$userDAO->Update_Mechani($uid,$attr_id,$attr_value_id);
            return success_json("工人注册属性设置成功!");
        }else{
            $result = self::$userDAO->Mechanic_s($uid,$attr_id,$attr_value_id);
            $this->loger("result", $result);
            if (empty($result) ) {
                return fail_json("工人注册属性设置失败!");
            } else {
                return success_json("工人注册属性设置成功!");
            }
        }
    }
    public function  designerl(){
        $uname=$_SESSION;
        $uname=$uname['user']['uname'];
        $uid=self::$userDAO->uidddcd($uname);
        $uid=$uid[0]['uid'];
        $result = self::$userDAO->designerl($uid);
        $this->loger("result", $result);
        $data = [];
        $data['city_name'] = $result['city_name'];
        $data['area_name'] = $result['area_name'];
        $data['name'] = $result['name'];
        $data['qq'] = $result['qq'];
        $data['mobile'] = $result['mobile'];
        $data['school'] = $result['school'];
        $data['slogan'] = $result['slogan'];
        $data['about'] = $result['about'];
        echo_res(0,"登录成功", $data);
        return ;
    }
    /**
     * 设计师:资料设置
     */
    public  function setDesigner($uname,$group_id,$name,$school,$city_id,$area_id,$mobile,$qq,$slogan,$about,$orderby,$flushtime,$dateline){
        $uname=$_SESSION;
        $uname=$uname['user']['uname'];
        $uid = self::$userDAO->creat($uname);
        $uid = $uid['uid'];
        $group_id = $uid['group_id'];
        $result1 = self::$userDAO->Designer($uid);
        if (!empty($result1)) {
            $result = self::$userDAO->Update_Designer($uid, $group_id, $name, $school, $city_id, $area_id, $mobile, $qq, $slogan, $about, $orderby, $flushtime, $dateline);
            if (!empty($result)) {
                return success_json("设计师注册资料设置成功！");
            } else {
                return fail_json("设计师注册资料设置有误！");
            }
        } else {
            $result = self::$userDAO->setDesigner($uid, $group_id, $name, $school, $city_id, $area_id, $mobile, $qq, $slogan, $about, $orderby, $flushtime, $dateline);
            $this->loger("result", $result);
            if (!empty($result)) {
                return success_json("设计师注册资料设置成功！");
            } else {
                return fail_json("设计师注册资料设置有误！");
            }
        }

    }

    //注册设计师;属性设置
    public  function  designer_s($namejy,$namezw){
        $attr_id_attr_value_id= self::$userDAO->attr_id_attr_value_id($namejy);
        $attr_id=$attr_id_attr_value_id['attr_id'];
        $attr_value_id=$attr_id_attr_value_id['attr_value_id'];

        $attr_id_attr_value_idd= self::$userDAO->attr_id_attr_value_idd($namezw);
        $attr_idd=$attr_id_attr_value_idd['attr_id'];
        $attr_value_idd=$attr_id_attr_value_idd['attr_value_id'];

        $uname=$_SESSION;
        $uname=$uname['user']['uname'];
        $uid = self::$userDAO->createea($uname);
        $uid=$uid[0]['uid'];
        $result1=self::$userDAO->cy_designer_attr($uid);
        if (!empty($result1)){
            self::$userDAO->Update_cy_designer($uid,$attr_id,$attr_value_id);
            self::$userDAO->cy_designer_s($uid,$attr_id,$attr_value_id);
        }else{
            $result = self::$userDAO->cy_designer_s($uid,$attr_id,$attr_value_id);
            $this->loger("result", $result);
            if (empty($result) ) {
                return fail_json("设计师注册属性设置失败!");
            }
        }
        $result2=self::$userDAO->cy_designer_attr($uid);
        if (!empty($result2)){
            self::$userDAO->Update_cy_designerr($uid,$attr_idd,$attr_value_idd);
        self::$userDAO->cy_designer_ss($uid,$attr_idd,$attr_value_idd);
            return success_json("设计师注册属性设置成功!");
        }else{
            $result = self::$userDAO->cy_designer_ss($uid,$attr_idd,$attr_value_idd);
            $this->loger("result", $result);
            if (empty($result) ) {
                return fail_json("设计师注册属性设置失败!");
            } else {
                return success_json("设计师注册属性设置成功!");
            }
        }

    }
    public function  cy_companyly(){
        $data = [];
        $uname=$_SESSION;
        $uname=$uname['user']['uname'];
        $uid =  self::$userDAO->creat($uname);
        $uid=$uid['uid'];
        $company_id =  self::$userDAO->company_id($uid);
        $company_id = $company_id['company_id'];
        $result = self::$userDAO->cy_companyly($company_id);
        $resultt = self::$userDAO->cy_companylyy($company_id);
        $resultt[0]['attr_value_id'] ;
        $resultt[0]['attr_id'] ;
        $resultt[0]['title'] ;
if ( $resultt[0]['attr_id']==1){
    $attr= $resultt[0]['title'] ;

}else{
    $attr= $resultt[1]['title'] ;
}
        if ( $resultt[1]['attr_id']==3){
            $attrb= $resultt[1]['title'] ;
        }else{
            $attrb= $resultt[0]['title'] ;
        }
        $banner = self::$userDAO->cy_companyly_banner($company_id);
        if (sizeof($banner)=='1'){
            $banner[0]['photo']=SessionEnum::PHOTO.$banner['photo'];
            $data['photo'] =array();
             array_push($data['photo'],$banner[0]['photo']);
        }else{
            foreach($banner as $k =>$v){
                $banner[$k]['photo']=SessionEnum::PHOTO.$banner[$k]['photo'];
            }
            $arr=array();
            foreach ($banner as $value) {
                array_push($arr,  $value['photo']);
            }
            $data['photo'] = $arr;

        }
        if ($banner==null){
            $data['photo'] = '';
        }
        $this->loger("result", $result);
        $data['city_name'] = $result['city_name'];
        $data['uname'] = $result['uname'];
        $data['title'] = $result['title'];
        $data['name'] = $result['name'];
        if ($result['thumb']==null){
            $data['thumb'] ='';
        }else{
            $data['thumb'] = SessionEnum::PHOTO.$result['thumb'];
        }
        if ($result['logo']==null){
            $data['logo'] ='';
        }else{
            $data['logo'] =SessionEnum::PHOTO. $result['logo'];
        }
        $data['slogan'] = $result['slogan'];
        $data['contact'] = $result['contact'];
        $data['phone'] = $result['phone'];
        $data['mobile'] = $result['mobile'];
        $data['qq'] = $result['qq'];
        $data['addr'] = $result['addr'];
        $data['info'] = $result['info'];
        $data['attr'] = $attr;
        $data['attrb'] = $attrb;
        echo_res(0,"登录成功", $data);
        return ;
    }
    //装修公司;资料设置
    public  function setcy_company($uname, $group_id, $city_id, $area_id, $title, $name, $thumb, $logo, $slogan, $contact, $phone, $mobile, $qq, $addr,$attr,$attrb,$photo,$info, $flushtime, $clientip, $dateline){
           $uname=$_SESSION;
        $uname=$uname['user']['uname'];
       $logo = substr("$logo", -34, 42);
        $thumb = substr("$thumb", -34, 42);
        $uid =  self::$userDAO->creat($uname);
        $uid=$uid['uid'];
        $group_id = $uid['group_id'];
        $result1=self::$userDAO->company($uid);
        if (!empty($result1)){
            $result=self::$userDAO->Update_company($uid,$uname, $group_id, $city_id, $area_id, $title, $name, $thumb, $logo, $slogan, $contact, $phone, $mobile, $qq, $addr, $flushtime, $clientip, $dateline);
            if (!empty($result)) {
                $company_id =  self::$userDAO->company_id($uid);
                $company_id = $company_id['company_id'];
                self::$userDAO->deletebanner($company_id);
                $photo = explode(',', $photo);
                foreach($photo as $a){
                    $photo = substr("$a", -34, 42);
                    $banner=self::$userDAO->banner($company_id,$photo,$title);
                    if (empty($banner)) {
                        return fail_json("装修公司注册资料设置失败！");
                    }
                }
                $company_id = self::$userDAO->company_id($uid);
                $company_id=$company_id['company_id'];

                $r= self::$userDAO->company_fieldsLOL($info);
                if (empty($r)) {
                    $result6= self::$userDAO->Update_company_fields($company_id,$info);
                    if (empty($result6)) {
                        return fail_json("装修公司注册资料设置失败！");
                    }
                }
                $company_id =  self::$userDAO->company_id($uid);
                $company_id = $company_id['company_id'];
                self::$userDAO->attrR2($company_id);
                $attr=self::$userDAO->attr($attr);
                $result2 = self::$userDAO->attrR($company_id,$attr['attr_id'],$attr['attr_value_id']);
                if (!empty($result2)) {
                } else {
                    return fail_json("装修公司注册资料设置失败！");
                }
                $attrb=self::$userDAO->attrb($attrb);
                $result3 = self::$userDAO->attrR($company_id,$attrb['attr_id'],$attrb['attr_value_id']);
                if (!empty($result3)) {
                } else {
                    return fail_json("装修公司注册资料设置失败！");
                }
                $this->loger("result", $result);
                return success_json("装修公司注册资料设置成功!");
            } else {
                return fail_json("装修公司注册资料设置失败！");
            }
        }else{
            $result = self::$userDAO->setcy_company($uid,$group_id,$city_id,$area_id,$title,$name,$thumb,$logo,$slogan,$contact,$phone,$mobile,$qq,$addr,$flushtime,$clientip,$dateline);
            if (!empty($result)) {
                $company_id =  self::$userDAO->company_id($uid);
                $company_id = $company_id['company_id'];
                self::$userDAO->deletebanner($company_id);
                $photo = explode(',', $photo);
                foreach($photo as $a){
                    $photo = substr("$a", -34, 42);
                    $banner=self::$userDAO->banner($company_id,$photo,$title);
                    if (empty($banner)) {
                        return fail_json("装修公司注册资料设置失败！");
                    }
                }
                $company_idD =  self::$userDAO->company_idD();
                $company_idD=$company_idD['company_id'];
                $result7 = self::$userDAO->setcy_company_fields($company_idD,$info);
                if (empty($result7)) {
                    return fail_json("装修公司注册资料设置失败！");
                }

                $company_id =  self::$userDAO->company_id($uid);
                $company_id = $company_id['company_id'];
                $attr=self::$userDAO->attr($attr);
                self::$userDAO->attrR2($company_id);
                $result2 = self::$userDAO->attrR($company_id,$attr['attr_id'],$attr['attr_value_id']);
                if (!empty($result2)) {
                } else {
                    return fail_json("装修公司注册资料设置失败！");
                }
                $attrb=self::$userDAO->attrb($attrb);
                $result3 = self::$userDAO->attrR($company_id,$attrb['attr_id'],$attrb['attr_value_id']);
                if (!empty($result3)) {
                } else {
                    return fail_json("装修公司注册资料设置失败！");
                }
                $this->loger("result", $result);
                return success_json("装修公司注册资料设置成功!");
            } else {
                return fail_json("装修公司注册资料设置失败！");
            }
        }
    }
    //装修公司;属性设置:服务
    public  function  cy_company_s($uname,$attr_id,$attr_value_id){
        $uid =  self::$userDAO->createe($uname);
        $uid=$uid['uid'];
        $result = self::$userDAO->Mechanic_s($uid,$attr_id,$attr_value_id);
        $this->loger("result", $result);
        if (empty($result) ) {
            return fail_json("装修公司注册属性设置失败!");
        } else {
            return success_json("装修公司注册属性设置成功!");
        }
    }
    //装修公司;属性设置:规模
    public  function  cy_company_z($uname,$attr_id,$attr_value_id){
        $uid =  self::$userDAO->createe($uname,$attr_id);
        $uid=$uid['uid'];
        $result1=self::$userDAO->cy_company_k($uid,$attr_id);
        if (!empty($result1)){
            self::$userDAO->Update_Mechani($uid,$attr_id,$attr_value_id);
            return success_json("装修公司注册属性设置成功!");
        }else{
            $result = self::$userDAO->Mechanic_s($uid,$attr_id,$attr_value_id);
            $this->loger("result", $result);
            if (empty($result) ) {
                return fail_json("装修公司注册属性设置失败!");
            } else {
                return success_json("装修公司注册属性设置成功!");
            }
        }
    }
    //建材商家:商铺管理
    public  function  cy_shop($uname,$group_id,$money,$cat_id,$area_id,$city_id,$title,$name,$logo,$thumb,$contact,$phone,$xiaobao,$views,$credit,$score,$comments,$products,$verif_name,$tenders_num,$tenders_sign,$is_vip,$ling,$lat,$orderby,$audit,$flushtime,$closed,$dataline,$pay){
        $uid =  self::$userDAO->createe($uname);
        $uid=$uid['uid'];
        $result =  self::$userDAO->setcy_shop($uid,$group_id,$money,$cat_id,$city_id,$area_id,$title,$name,$logo,$thumb,$contact,$phone,$xiaobao,$views,$credit,$score,$comments,$products,$verif_name,$tenders_num,$tenders_sign,$is_vip,$ling,$lat,$orderby,$audit,$flushtime,$closed,$dataline,$pay);
        if (empty($result) ) {
            return fail_json("建材商家注册失败!");
        } else {
            return success_json("建材商家注册成功!");
        }
        $result1 =  self::$userDAO->setcy_shop_fields($uid);
        if (empty($result1) ) {
            return fail_json("建材商家注册失败!");
        } else {
            return success_json("建材商家注册成功!");
        }
    }
    //建材商家:基本设置
    public  function  cy_shop_banner($uname,$banner){
        $uid =  self::$userDAO->createe($uname);
        $uid=$uid['uid'];
        $result=self::$userDAO->cy_shop_banner($uid,$banner);
        $this->loger("result", $result);
        if (empty($result) ) {
            return fail_json("建材商家注册基本设置失败!");
        } else {
            return success_json("建材商家注册基本设置成功!");
        }
    }
    //建材商家:资料设置
    public  function  cy_shop_fox($uname,$fox,$mail,$qq,$hours,$addr,$jiaotong,$bulletin){
        $uid =  self::$userDAO->createe($uname);
        $uid=$uid['uid'];
        $result=self::$userDAO->cy_shop_fox($uid,$fox,$mail,$qq,$hours,$addr,$jiaotong,$bulletin);
        $this->loger("result", $result);
        if (empty($result) ) {
            return fail_json("建材商家注册基本设置失败!");
        } else {
            return success_json("建材商家注册基本设置成功!");
        }
    }
    //建材商家:SEO 设置
    public  function  cy_shop_seo($uname,$seo_title,$seo_keywords,$seo_description){
        $uid =  self::$userDAO->createe($uname);
        $uid=$uid['uid'];
        $result=self::$userDAO->cy_shop_seo($uid,$seo_title,$seo_keywords,$seo_description);
        $this->loger("result", $result);
        if (empty($result) ) {
            return fail_json("建材商家注册SEO 设置失败!");
        } else {
            return success_json("建材商家注册SEO 设置成功!");
        }
    }
}