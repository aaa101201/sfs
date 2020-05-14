<?php
// +----------------------------------------------------------------------
// | 基础业务CRUD方法范例
// +----------------------------------------------------------------------
// | Author: James.Yu <zhenzhouyu@jiechengkeji.cn>
// +----------------------------------------------------------------------

namespace Admin\Controller;

use Admin\Service\UserService;
use Enum\SessionEnum;

class UserController extends AuthController
{

    private static $userService;

    public function _initialize() {
        parent::_initialize();
        self::$userService = new UserService();
    }

    /**
     * 注册
     */
    public  function  cy_member_group(){
        $result=self::$userService->cy_member_group();
        $this->loger('result', $result);
        $this->ajaxReturn($result);
    }
    /**
     * P
     * 注册 业主注册
     */
    public function create()
    {
         $uname = I("uname", "", "strip_tags");// 手机号
         $passwd = I("passwd", "", "md5");// 密码
         $confirmpasswd = I("confirmpasswd", "", "md5");// 密码
         $group_id = I("group_id");
         $mail = I("mail");
         $gender ="woman";
         $city_id = 7;
         $lastlogin = time();
         $loginip = gethostbyname($_ENV['COMPUTERNAME']);
         $regip= gethostbyname($_ENV['COMPUTERNAME']);
         $dateline = time();
         $createuname=$uname;
         $_SESSION['user'] = array('createuname' => $createuname);
        //下面是测试用的0
//        $uname = '18333333333';// 手机号
//        $passwd = 'fee48f94485d70b299a07a4db6969276';// 密码
//        $confirmpasswd = 'fee48f94485d70b299a07a4db6969276';// 密码
//        $from='shop';
//        $group_id = '7';
//        $mail = "1012013566@qq.com";
//        $gender = "woman";
//        $city_id = 7;
//        $lastlogin = time();
//        $loginip = gethostbyname($_ENV['COMPUTERNAME']);
//        $regip = gethostbyname($_ENV['COMPUTERNAME']);
//        $dateline = time();
        if ($group_id=='1'){
            $from='member';
        }
        if ($group_id=='2'){
            $from='designer';
        }
        if ($group_id=='4'){
            $from='company';
        }
        if ($group_id=='7'){
            $from='shop';
        }
        if ($group_id=='8'){
            $from='mechanic';
        }
        if ($passwd != $confirmpasswd) {
            $this->ajaxReturn(fail_json("请确认密码不正确"));
        }
        if (empty($uname)) {
            $this->ajaxReturn(fail_json("请输入手机号"));
        }
        if (empty($passwd)) {
            $this->ajaxReturn(fail_json("请输入 密码"));
        }
        $result = self::$userService->create($uname, $passwd,$from,$group_id, $mail, $gender, $city_id, $lastlogin, $loginip, $regip, $dateline);
        $this->loger('result', $result);
        $this->ajaxReturn($result);
    }
    //装修工人;资料设置
    public function Mechanic()
    {
        $uname = 18363100069;// 手机号
        $name='王海煊';
        $area_id=2;
        //电话
        $mobile='';
        $qq='1012013566';
        ///内容
        $about='内容';
        $city_id='7';
        $flushtime=time();
        $result = self::$userService->setMechanic($uname,$name,$area_id,$mobile,$qq,$about,$city_id,$flushtime);
        $this->loger('result', $result);
        $this->ajaxReturn($result);
    }
    //装修工人;属性设置
    public function  Mechanic_s(){
        $attr_id='11';
        $attr_value_id='59';
        $uname = 18363100069;// 手机号
        $result = self::$userService->Mechanic_s($uname,$attr_id,$attr_value_id);
        $this->loger('result', $result);
        $this->ajaxReturn($result);
    }
    /**
     * 注册设计师:资料设置预览
     */
    public  function  designerl(){
        $result = self::$userService->designerl();
        $this->loger('result', $result);
    }
    /**
     * 注册设计师:资料设置工作经验
     */
    public  function  designerly_j(){
        $result = self::$userService->designerly_j();
        $this->loger('result', $result);
      //  $this->ajaxReturn($result);
    }
    /**
     * 注册设计师:资料设置工作职业选择
     */
    public  function  designerly_zyx(){
        $result = self::$userService->designerly_zyx();
        $this->loger('result', $result);
       // $this->ajaxReturn($result);
    }
//    /**
//     * 注册设计师:资料设置所在地区
//     */
//    public  function  designerly_zyxz(){
//        $result = self::$userService->designerly_zyxz();
//        $this->loger('result', $result);
//        $this->ajaxReturn($result);
//    }

public  function  designer_q(){
    $result = self::$userService->designer_q();
    $this->loger('result', $result);
}
    /**
     * 注册设计师:资料设置
     */
    public function designer()
    {
        $uname =I("uname");
       // 类型
        $group_id = I("group_id");
       // 省
        $city_id = '7';
       // 市
        $area_id = '3';
       // 名称
        $name =I("name");
       // 毕业院校
        $school =I("school");
       // 联系QQ
        $qq = I("qq");
       // 联系电话
        $mobile = I("mobile");
       // 口号
        $slogan =I("slogan");
       // 个人简介
        $about = I("about");
        //下面是测试
//        $uname = '18363100069';// 手机号
//        //类型
//        $group_id = '2';
//        //省
//        $city_id = '7';
//        //市
//        $area_id = '3';
//        //名称
//        $name = "王海煊";
//        //毕业院校
//        $school = "哈瑞宝";
//        //联系QQ
//        $qq = "1013566@qq.com";
//        //联系电话
//        $mobile = "18363100075";
//        //口号
//        $slogan =I("slogan");
//        //个人简介
//        $about = "公司的风格";
        $orderby = 50;
        $flushtime = time();
        $dateline = time();
        $result = self::$userService->setDesigner( $uname,$group_id,$name,$school,$city_id,$area_id,$mobile,$qq,$slogan,$about,$orderby,$flushtime,$dateline);
        $this->loger('result', $result);
        $this->ajaxReturn($result);
    }
    //注册设计师;属性设置
    public function  designer_s(){
      $namejy = I("namejy");
      $namezw = I("namezw");
        //下面测试
//        $name='54';
        $result = self::$userService->designer_s($namejy,$namezw);
        $this->loger('result', $result);
        $this->ajaxReturn($result);
    }
    //注册设计师;属性设置预览
    public function  designer_sly(){
        $result = self::$userService->designer_sly();
        $this->loger('result', $result);
    }
    //装修公司;资料设置预览
    public  function  cy_companyly(){
        $result = self::$userService->cy_companyly();
        $this->loger('result', $result);
    }
    //装修公司;资料设置公司服务
    public  function  cy_companylygsfw(){
        $result = self::$userService->cy_companylygsfw();
        $this->loger('result', $result);
    }
    //装修公司;资料设置公司规模
    public  function  cy_companylygsgm(){
        $result = self::$userService->cy_companylygsgm();
        $this->loger('result', $result);

    }
    //装修公司;资料设置
    public function cy_company()
    {
       $uname = I("uname");
//        //类型
       $group_id = '4';
//        //省
      $city_id = '7';
//        //市
        $area_id = '3';
//        //公司名称
        $title = I("title");
//        //公司简称
        $name =I("name");
//        //长方形LOGO
        $thumb = I("thumb");
//        //正方形LOGO
       $logo = I("logo");
//        //服务口号
        $slogan = I("slogan");
//        //联系人
        $contact = I("contact");
//        //*电话
        $phone = I("phone");
//        //手机
        $mobile = I("mobile");
//        //QQ
        $qq = I("qq");
//        //地址
        $addr = I("addr");
//        //公司服务
        $attr=I("attr");
//        //公司规模
        $attrb=I("attrb");
//        //轮播图
        $photo = I("photo");
//        //公司介绍
        $info=I("info");
        //下面测试
   //     $uname = '18363122269';// 手机号
        //类型
   //     $group_id = '4';
        //省
   //     $city_id = '7';
        //市
   //     $area_id = '3';
   //     //公司名称
   //     $title = "whx1";
        //公司简称
    //    $name = "王海煊";
        //长方形LOGO
    //    $thumb = "哈瑞宝";
        //正方形LOGO
     //   $logo = "哈瑞宝";
        //服务口号
      //  $slogan = "whx3";
        //联系人
   //     $contact = "whx";
        //*电话
   //     $phone = "183631000636";
        //手机
    //    $mobile = "18363100063";
        //QQ
    //    $qq = "1013566";
        //地址
     //  $addr = "dfdsf";
        //公司服务
   //     $attr='13';
        //公司规模
  //     $attrb='13';
        //轮播图
   //     $photo = "photo";
        //公司介绍
     //   $info='info';
        $flushtime = time();
        $clientip = gethostbyname($_ENV['COMPUTERNAME']);
        $dateline = time();
        $result = self::$userService->setcy_company($uname, $group_id, $city_id, $area_id, $title, $name, $thumb, $logo, $slogan, $contact, $phone, $mobile, $qq, $addr,$attr,$attrb,$photo,$info, $flushtime, $clientip, $dateline);
        $this->loger('result', $result);
        $this->ajaxReturn($result);
    }

    //装修公司;属性设置:服务
    public  function  cy_company_s(){
        $uname = I("uname");
        $attr_id=I("attr_id");
        $attr_value_id=I("attr_value_id");
        //下面是测试
//        $attr_id='1';
//        $attr_value_id='2';
//        $uname = '18363122269';// 手机号
        $result = self::$userService->cy_company_s($uname,$attr_id,$attr_value_id);
        $this->loger('result', $result);
        $this->ajaxReturn($result);
    }
    //装修公司;属性设置:规模
    public  function  cy_company_z(){
         $uname = I("uname");
         $attr_id=I("attr_id");
         $attr_value_id=I("attr_value_id");
        //下面是测试
//        $attr_id='3';
//        $attr_value_id='4';
//        $uname = '18363122269';// 手机号
        $result = self::$userService->cy_company_z($uname,$attr_id,$attr_value_id);
        $this->loger('result', $result);
        $this->ajaxReturn($result);
    }
    //建材商家:商铺管理
    public function cy_shop()
    {
        $uname = '18363133369';// 手机号
        $group_id = '7';
        $money = 0;
        //商铺分类
        $cat_id = '1';
        $city_id = '7';
        $area_id = '3';
        //商铺标题
        $title = "whx1";
        //商铺名称
        $name = "王海煊";
        //长方形LOGO
        $thumb = "哈瑞宝";
        //正方形LOGO
        $logo = "哈瑞宝";
        //联系人
        $contact = "whx";
        //电话
        $phone = "18363133369";
        //经度:
        $lng = '11';
        // 纬度:
        $lat = '22';
        $flushtime = time();
        $dataline = time();
        $result = self::$userService->cy_shop($uname,$group_id, $money, $cat_id, $city_id, $area_id, $title, $name, $logo, $thumb, $contact, $phone, $lng, $lat,$flushtime, $dataline);
        $this->loger('result', $result);
        $this->ajaxReturn($result);
    }

    //建材商家:基本设置
    public  function  cy_shop_banner(){
        $uname = '18363133369';// 手机号
        $banner='商铺Banner';
        $result = self::$userService->cy_shop_banner($uname,$banner);
        $this->loger('result', $result);
        $this->ajaxReturn($result);
    }
    //建材商家:资料设置
    public  function  cy_shop_fox(){
        $uname = '18363133369';// 手机号
        //传真
        $fox='商铺Banner';
        //公司邮箱
        $mail='商铺Banner';
        //客服QQ
        $qq='商铺Banner';
        //营业时间
        $hours='商铺Banner';
        //地址
        $addr='商铺Banner';
        //交通
        $jiaotong='商铺Banner';
        //公司介绍
        $bulletin='商铺Banner';
        $result = self::$userService->cy_shop_fox($uname,$fox,$mail,$qq,$hours,$addr,$jiaotong,$bulletin);
        $this->loger('result', $result);
        $this->ajaxReturn($result);
    }
    //建材商家:SEO 设置
    public  function  cy_shop_seo(){
        $uname = '18363133369';// 手机号
        //SEO 标题
        $seo_title='商铺Banner';
        //SEO 关键字
        $seo_keywords='商铺Banner';
        //SEO 描述
        $seo_description='商铺Banner';
        $result = self::$userService->cy_shop_seo($uname,$seo_title,$seo_keywords,$seo_description);
        $this->loger('result', $result);
        $this->ajaxReturn($result);
    }
    // 管理员退出
    public function logout() {
        $_SESSION = array(); //清除SESSION值.
//        if (isset($_COOKIE[session_name()])) {  //判断客户端的cookie文件是否存在,存在的话将其设置为过期.
//            setcookie(session_name(), '', time() - 1, '/');
//        }
//        session_destroy();  //清除服务器的sesion文件
//        $this->redirect('/');
        if (!empty($_SESSION)) {
            echo_res(1,"退出失败");
            return ;
        } else {
            echo_res(0,"退出成功" );
            return ;
        }
    }

}