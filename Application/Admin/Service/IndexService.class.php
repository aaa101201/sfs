<?php
/**
 * Created by PhpStorm.
 * User: Freeman
 * Date: 2016/10/27
 * Time: 14:53
 */

namespace Admin\Service;

use Think\Model;
use Admin\Dao\IndexDao;
use  Enum\SessionEnum;

class IndexService extends BaseService
{

    private static $indexDao;
    private  $db;
    public function __construct() {
        $this->db=new  Model();
        self::$indexDao = new IndexDao($this->db);
    }

    public function getMenu($args) {
        $db = new Model();
        $data = self::$indexDao->getMenu($db, $args);
        return $data;
    }
public  function  login($uname,$passwd){
//    $file_contents = file_get_contents("http://api.jft365.cn/ismember/getDiscount.php?phone=" . $uname . "");
//    $result=json_decode($file_contents,true);
//    if($result['code'] == 1){
//        $result=self::$indexDao->login($uname,$passwd);
//        if (empty($result)) {
//            $fromw = "1";//山海通用户标记
//            $mail = "" . time() . "@sht.com";
//            $passwd='123456';
//            $from='member';
//            $group_id = '1';
//            $gender = "woman";
//            $city_id = '7';
//            $lastlogin = time();
//            $loginip = gethostbyname($_ENV['COMPUTERNAME']);
//            $regip = gethostbyname($_ENV['COMPUTERNAME']);
//            $dateline = time();
//            $result =  self::$indexDao->create($uname,$passwd,$fromw,$mail,$from,$group_id,$gender,$city_id,$lastlogin,$loginip,$regip,$dateline);
//            return success_json("山海通用户登录成功",$result);
//        }
//     }
    $resul=array($uname,$passwd);
    $_SESSION = array(); //清除SESSION值.
    session('user', $resul);
    $_SESSION['user'] = array('uname' => $uname, 'passwd' => $passwd);
    $arr_str = serialize($resul);
    setcookie("user",$arr_str);
    $result=self::$indexDao->login($uname,$passwd);
    $this->loger("result",$result);
    if (empty($result)) {
        echo_res(1,"登录失败");
        return ;
    } else {
        $data = [];
        $data['from'] = $result['from'];
        echo_res(0,"登录成功", $data);
        return ;
    }
}
    public  function  Umember_zl(){
        $uname=$_SESSION;
        $uname=$uname['user']['uname'];
        $result = self::$indexDao->Umember_zl($uname);
        $data = [];
        if ( $result['face']==""){
            $data['face']=SessionEnum::PHOTO.'face/face.jpg';
        }else{
            $data['face']=SessionEnum::PHOTO. $result['face'];
        }
        $y= $result['y'];
        $m= $result['m'];
        $d= $result['d'];
        $data['time']=$y.'_'.$m.'_'.$d;
        $realname=$result['realname'];
        if ($realname==""){
            $data['realname']=$result['uname'];
        }else{
            $data['realname'] = $result['realname'];
        }
        $data['uname'] = $result['uname'];
        $data['city_id'] = $result['city_id'];
        echo_res(0,"登录成功", $data);
        return ;
    }
    public  function  Umember_zlx($realname,$city_id,$time){
        $uname=$_SESSION;
        $uname=$uname['user']['uname'];
        $dateline=time();
        $array = explode('_', $time);
        $y = $array[0];
        $m = $array[1];
        $d = $array[2];
        $city_id =self::$indexDao->Designer_h($city_id);
        $city_id=$city_id[0]['city_id'];
        if ($city_id==''){
            return fail_json("城市超出服务服务");
        }
        $result = self::$indexDao->Umember_zlx($uname,$realname,$city_id,$y,$m,$d,$dateline);
        $this->loger("result", $result);
        if (empty($result)) {
            return fail_json("修改资料失败!");
        } else {
            return success_json("修改资料成功");
        }
    }
    public  function   Umember_mm($passwd,$xpasswd,$qpasswd){
        $uname=$_SESSION;
        $uname=$uname['user']['uname'];
        $passwdD=$uname['user']['passwd'];
        if ($xpasswd!=$qpasswd){
            return fail_json("确认密码不正确!");
        }
        $dateline=time();
        $passwdd = self::$indexDao->Umember_passwd($uname);
        $passwdc=$passwdd[0]['passwd'];
        if ($passwd!=$passwdc){
            return fail_json("密码不正确!");
        }
        $result = self::$indexDao->Umember_mm($xpasswd,$uname,$dateline);
        $this->loger("result", $result);
        if (empty($result)) {
            return fail_json("修改密码失败!");
        } else {
            return success_json("修改密码成功");
        }
    }
}