<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/9
 * Time: 10:08
 */

namespace Admin\Service;
use Admin\Controller\BaseController;
use Admin\Dao\ShopDao;
use Think\Model;
use  Enum\SessionEnum;

class ShopService extends BaseController
{
    private  static  $ShopDao;
    private  $db;
    public  function  __construct()
    {
        $this->db=new  Model();
        self::$ShopDao=new  ShopDao($this->db);
    }
    public  function  cy_shop_cate(){
        $result =self::$ShopDao->cy_shop_cate();
        if ($result==null){
            $data['result']=[];
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
    public  function  cy_shop_cateb($id){
        $result =self::$ShopDao->cy_shop_cateb($id);
        foreach($result as $k =>$v){
            $id=$result[$k]['id'];
            $sub =self::$ShopDao->cy_shop_catebc($id);
            $result[$k]['sub']=$sub;
            if ($result==null){
                $data['result']=[];
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
    }
    public  function  cy_shop_photosy(){
        $result =self::$ShopDao->cy_shop_photosy();
        foreach($result as $k =>$v){
            $result[$k]['photo']=SessionEnum::PHOTOo.$result[$k]['photo'];
        }        $arr=array();
        foreach ($result as $value) {
            array_push($arr,  $value['photo']);
        }
        $this->loger("result", $result);
        return success_json_o("数据获取成功", $arr);
    }
    public  function  cy_shop_splb(){
        $result =self::$ShopDao->cy_shop_splb();
        if ($result==null){
            $data['result']=[];
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
    public  function  cy_shop_s(){
        $result =self::$ShopDao->cy_shop_s();
        if ($result==null){
            $data['result']=[];
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
    public  function  cy_shop_syxq($mr,$xl,$jg,$cat_id,$pageNumber,$pageSize){
        $pageSizee=$pageNumber*$pageSize;
        $start=$pageSizee-$pageSize;
        $result =self::$ShopDao->cy_shop_syxq($mr,$xl,$jg,$cat_id,$start,$pageSize);
        foreach($result as $k =>$v){
            if ($result[$k]['photo']==""){
                $result[$k]['photo']=SessionEnum::PHOTO.'face/face.jpg';
            }else{
                $result[$k]['photo']=SessionEnum::PHOTO.$result[$k]['photo'];
            }
        }
        $pageTotal = self::$ShopDao->setFitmentConut($mr,$xl,$jg,$cat_id);
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
            echo_res(0,"正确格式", $data);
            return ;
        }
    }
    public  function  cy_shop_lb($cat_id,$pageNumber,$pageSize){
        $pageSizee=$pageNumber*$pageSize;
        $start=$pageSizee-$pageSize;
        $result =self::$ShopDao->cy_shop_lb($cat_id,$start,$pageSize);
        $pageTotal = self::$ShopDao->setCy_shop_lb($cat_id);
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
            echo_res(0,"正确格式", $data);
            return ;
        }
    }
    public  function  cy_shop_xq($product_id){
        $data = [];
        $result =self::$ShopDao->cy_shop_xq($product_id);
        $result=$result[0];
        //商品图片
        if ($result['photo']==""){
            $data['photo']=SessionEnum::PHOTO.'face/face.jpg';
        }else{
            $data['photo']=SessionEnum::PHOTO.$result['photo'];
        }
        //商品名称
        $data['name']=$result['name'];
        //现金
        $data['market_price,']=$result['market_price'];
        //市场价
        $data['price'] = $result['price'];
        //总销量
        $data['sale_sku'] = $result['sale_sku'];
        //包邮等于，大于0等于多少运费
        $data['freight'] = $result['freight'];
        //公司内容
        $data['gsinfo'] = $result['gsinfo'];
        //公司名称
        $data['gsname'] = $result['gsname'];
        //公司logo
        if ($result['photo']==""){
            $data['logo']=SessionEnum::PHOTO.'face/face.jpg';
        }else{
            $data['logo']=SessionEnum::PHOTO.$result['logo'];
        }
        //基础建材
        $data['title'] =$result['title'];
        //评论数
        $data['count'] = $result['count'];
        //商品详情
        $data['info'] = $result['info'];
        //分类
        $data['fl'] = $result['fl'];
        $data['shop_id'] = $result['shop_id'];
        $data['product_id'] = $result['product_id'];
        echo_res(0,"登录成功", $data);
        return ;
    }
    public  function  cy_shop_spzx($name,$phone,$address,$shop_id,$product_id){
        $dateline=time();
        $clinetip=gethostbyname($_ENV['COMPUTERNAME']);
        $uid=self::$ShopDao->cy_compay_uid($phone);
        $uid=$uid[0]['uid'];
        $result =self::$ShopDao->cy_shop_spzx($name,$phone,$address,$shop_id,$product_id,$uid,$dateline,$clinetip);
        if (empty($result)) {
            return fail_json("商品咨询失败!");
        } else {
            return success_json_o("商品咨询成功");
        }
    }
    public  function  cy_shop_gwcj($product_id){
        $dateline=time();
        $clinetip=gethostbyname($_ENV['COMPUTERNAME']);
//        $uname=18363100061;
        $uname=$_SESSION;
        $uname=$uname['user']['uname'];
        if ($uname==""){
            return fail_json("请登录!");
        }
        $uid=self::$ShopDao->cy_compay_uid($uname);
        $uid=$uid[0]['uid'];
        $resultt =self::$ShopDao->cy_shop_gwa($uid);
        $cart=$resultt[0]['cart'];
        $array=explode(';', $cart);
        $str1='';
        foreach($array as $k =>$v){
//            $arrayy=explode('-', $array[$k]);
//            $arrayy=$arrayy[0];
            $arrayytt=substr($array[$k],0,2);
            if ($arrayytt==$product_id){
                $arrayyt = substr("$array[$k]", 5);
                $arrayyt=$arrayyt+1;
                $arrayytt=substr($array[$k],0,5);
                $arrayy=$arrayytt.$arrayyt;
                $array[$k]=$arrayy.';';
        }
            $str1= $str1.$array[$k];
        }
        $product_id=$str1;
        $result =self::$ShopDao->cy_shop_gwc($uid,$product_id,$dateline);
        if (empty($result)) {
            return fail_json("购物车失败!");
        } else {
            return success_json_o("购物车成功");
        }
    }
    public  function  cy_shop_ddxx($shop_id,$addr,$mobile,$note,$product_count,$product_number,$product_amount,$contact){
        $a = mt_rand(10000000,99999999);
        $b = mt_rand(10,99);
        $order_no= $a.$b;
        $clinetip=gethostbyname($_ENV['COMPUTERNAME']);

        $dateline=time();
//        $uname=18363100061;
        $uname=$_SESSION;
        $uname=$uname['user']['uname'];
        if ($uname==""){
            return fail_json("请登录!");
        }
        $uid=self::$ShopDao->cy_compay_uid($uname);
        $uid=$uid[0]['uid'];
        $resultt =self::$ShopDao->cy_shop_gwa($uid);
        $cart=$resultt[0]['cart'];
        $array=explode(';', $cart);
        $resultt =self::$ShopDao->cy_shop_ddxx($order_no,$uid,$shop_id,$addr,$mobile,$note,$product_count,$product_number,$product_amount,$contact,$clinetip,$dateline);
        if (empty($resultt)) {
            return fail_json("购物车失败!");
        }
        foreach($array as $k =>$v){
            $number = substr("$array[$k]", 5);
                $product_id=substr($array[$k],0,2);
            $product =self::$ShopDao->product($product_id);
            $product_name=$product[0]['name'];
            $product_price=$product[0]['price'];
            $order_id = mysql_insert_id();
            $amount=$product_price*$number;
            $result =self::$ShopDao->cy_shop_ddxxa($order_id,$product_id,$product_name,$product_price,$number,$amount);

        }
        if (empty($result)) {
            return fail_json("购物车失败!");
        } else {
            $product_id='';
            $resultt =self::$ShopDao->cy_shop_gwc($uid,$product_id,$dateline);
            if (empty($resultt)) {
                return fail_json("购物车失败!");
            } else {
                return success_json_o("购物车成功");
            }
        }
    }
    public  function  cy_shop_up($product_id){
        $dateline=time();
//        $uname=18363100061;
        $uname=$_SESSION;
        $uname=$uname['user']['uname'];
        if ($uname==""){
            return fail_json("请登录!");
        }
        $uid=self::$ShopDao->cy_compay_uid($uname);
        $uid=$uid[0]['uid'];
        $resultt =self::$ShopDao->cy_shop_gwa($uid);
        $cart=$resultt[0]['cart'];
        $array=explode(';', $cart);
        $str1='';
        foreach($array as $k =>$v){
//            $arrayy=explode('-', $array[$k]);
//            $arrayy=$arrayy[0];
            $arrayytt=substr($array[$k],0,2);
            if ($arrayytt==$product_id){
                $array[$k]='';
            }
            $str1= $str1.$array[$k];
        }
        $product_id=$str1;
        $result =self::$ShopDao->cy_shop_gwc($uid,$product_id,$dateline);
        if (empty($result)) {
            return fail_json("购物车失败!");
        } else {
            return success_json_o("购物车成功");
        }
    }
    public  function  cy_shop_gwc($product_id){
        $dateline=time();
//        $uname=18363100061;

        $uname=$_SESSION;


        $uname=$uname['user']['uname'];
        if ($uname==""){
            return fail_json("请登录!");
        }
        $uid=self::$ShopDao->cy_compay_uid($uname);
        $uid=$uid[0]['uid'];
        $resultt =self::$ShopDao->cy_shop_gwa($uid);
        $cart=$resultt[0]['cart'];
        $array=explode(';', $cart);
        if ($array==''){
            $product_id=$product_id.'-0:1;';

        }
        foreach($array as $k =>$v){
//            $arrayy=explode('-', $array[$k]);
//            $arrayy=$arrayy[0];
            $arrayytt=substr($array[$k],0,2);
            if ($arrayytt==$product_id){
                $a=1;
            }
        }
        if ($a==1){
            $product_id=$cart;
        }else{
            $product_id=$product_id.'-0:1;'.$cart;
        }
        $result =self::$ShopDao->cy_shop_gwc($uid,$product_id,$dateline);
        if (empty($result)) {
            return fail_json("购物车失败!");
        } else {
            return success_json_o("购物车成功");
        }
    }
    public  function  cy_shop_sjxq($shop_id){
        $data = [];
        $result =self::$ShopDao->cy_shop_sjxq($shop_id);
        $result=$result[0];
        //首页图片
        if ($result['photo']==""){
            $data['photo']=SessionEnum::PHOTO.'face/face.jpg';
        }else{
            $data['photo']=SessionEnum::PHOTO.$result['photo'];
        }
        //公司名称
        $data['name']=$result['name'];
        //公司logo
        $data['logo,']=$result['logo'];
        //公司内容
        $data['info'] = $result['info'];
        //公司地址
        $data['addr'] = $result['addr'];
        //公司入住时间
        $data['hours'] = $result['hours'];
        //商品口卑
        $data['score'] = $result['score'];
        echo_res(0,"登录成功", $data);
        return ;
    }


    public  function  cy_shop_sjqb($shop_id,$pageNumber,$pageSize){
        $pageSizee=$pageNumber*$pageSize;
        $start=$pageSizee-$pageSize;
        $result =self::$ShopDao->cy_shop_sjqb($shop_id,$start,$pageSize);
        $pageTotal = self::$ShopDao->setCy_shop_sjqb($shop_id);
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
            echo_res(0,"正确格式", $data);
            return ;
        }
    }
    public  function  cy_shop_spgz($shop_id){
        $dateline=time();
        $views =self::$ShopDao->views($shop_id);
        $views=$views[0]['views'];
        $views=$views+1;
        $result =self::$ShopDao->cy_shop_spgz($shop_id,$views,$dateline);
        if (empty($result)) {
            return fail_json("关注店铺失败!");
        } else {
            return success_json_o("关注店铺成功");
        }
    }
    public  function  cy_shop_spfl($shop_id){
        $result =self::$ShopDao->cy_shop_spfl($shop_id);
        if ($result==null){
            $data['result']=[];
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
    public  function  cy_shop_spjj($shop_id){
        $result =self::$ShopDao->cy_shop_spjj($shop_id);
        if ($result==null){
            $data['result']=[];
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
}