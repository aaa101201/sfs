<?php
namespace Org\Wechat;
/**
 * Created by PhpStorm.
 * User: StandOpen
 * Date: 15-1-7
 * Time: 9:41
 */
class OrderPush
{
    protected $appid;
    protected $secrect;
    protected $accessToken;

    public function __construct($appId = false, $appSecret = false)
    {
        if ($appId) {
            $this->appId = $appId;
            $this->appSecret = $appSecret;
        } else {
            $appid_info = $this->getConfig("appid");
            if ($appid_info) {
                $this->appid = $appid_info['value'];
            }
            $appsec_info = $this->getConfig("appsecret");
            if ($appsec_info) {
                $this->secrect = $appsec_info['value'];
            }
        }

        $this->accessToken = $this->getToken();

    }

    protected function getConfig($key)
    {
        $config_info = M('config')->where(array('key' => $key))->find();
        return $config_info;
    }

    /**
     * 发送post请求
     * @param string $url
     * @param string $param
     * @return bool|mixed
     */
    function request_post($url = '', $param = '')
    {
        if (empty($url) || empty($param)) {
            return false;
        }
        $postUrl = $url;
        $curlPost = $param;
        $ch = curl_init(); //初始化curl
        curl_setopt($ch, CURLOPT_URL, $postUrl); //抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0); //设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1); //post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
        $data = curl_exec($ch); //运行curl
        curl_close($ch);
        return $data;
    }


    /**
     * 发送get请求
     * @param string $url
     * @return bool|mixed
     */
    function request_get($url = '')
    {
        if (empty($url)) {
            return false;
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    /**
     * @param $appid
     * @param $appsecret
     * @return mixed
     * 获取token
     */
    public function getToken()
    {


        $data = json_decode(file_get_contents("./Public/token/access_token.json"));
        if ($data->expire_time < time()) {
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $this->appid . "&secret=" . $this->secrect;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $token = curl_exec($ch);
            curl_close($ch);
            $token = json_decode(stripslashes($token));
            $arr = json_decode(json_encode($token), true);
            $access_token = $arr['access_token'];

            if ($access_token) {
                $data->expire_time = time() + 7000;
                $data->access_token = $access_token;
                $fp = fopen("./Public/token/access_token.json", "w");
                fwrite($fp, json_encode($data));
                fclose($fp);
            }


        } else {
            $access_token = $data->access_token;
        }
        return $access_token;
    }

    /**
     * 发送自定义的模板消息
     * @param $touser
     * @param $template_id
     * @param $url
     * @param $data
     * @param string $topcolor
     * @return bool
     */
    public function doSend($touser, $template_id, $url, $data, $topcolor = '#7B68EE')
    {
        /*
         * data=>array(
                'first'=>array('value'=>urlencode("您好,您已购买成功"),'color'=>"#743A3A"),
                'name'=>array('value'=>urlencode("商品信息:微时代电影票"),'color'=>'#EEEEEE'),
                'remark'=>array('value'=>urlencode('永久有效!密码为:1231313'),'color'=>'#FFFFFF'),
            )
         */
        $template = array(
            'touser' => $touser,
            'template_id' => $template_id,
            'url' => $url,
            'topcolor' => $topcolor,
            'data' => $data
        );
        $json_template = json_encode($template);
        $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=" . $this->accessToken;
        $dataRes = $this->request_post($url, urldecode($json_template));


       // print_r($dataRes);

        if ($dataRes['errcode'] == 0) {
            return true;
        } else {
            return false;
        }
    }


    public function newOrder($order_sn)
    {


        $order_info = M('order')->where(array('order_sn' => $order_sn))->find();
        if(!$order_info || $order_info['is_push'] == 1)
        {
            return ;
        }

        $shop_info = M('shop')->where(array('shop_id' => $order_info['shop_id']))->find();

        $first = "您的店铺有新的订单生成。";
        $remark = "登陆后台进行查看";
        $data = array(
            'first' => array('value' => urlencode($first), 'color' => "#743A3A"),
            'keyword1' => array('value' => urlencode($shop_info['shop_name']), 'color' => '#1C94C4'),
            'keyword2' => array('value' => urlencode($order_info['goods_name']), 'color' => '#1C94C4'),
            'keyword3' => array('value' => urlencode($order_info['add_time_f']), 'color' => '#1C94C4'),
            'keyword4' => array('value' => urlencode("￥".$order_info['amount']), 'color' => '#1C94C4'),
            'keyword5' => array('value' => urlencode("已支付"), 'color' => '#1C94C4'),
            'remark' => array('value' => urlencode($remark), 'color' => '#1C94C4')
        );
        $template_id = 'Ym75Ml84bC50FkqFIB681zIj9VWC9V3z-sYqbaEdZGg';
        $openid = $shop_info['admin_openid'];
        if ($openid) {
            $url = "";
            $this->doSend($openid, $template_id, $url, $data);
        }
    }


    public function confirmOrder($order_id)
    {
        /*
        6wY83pm7GeIrhNx9BylL4YE0wP4lrbcSgj0rs_xSVf0
        您好，您已成功消费。
        {{productType.DATA}}：{{name.DATA}}
        消费时间：{{time.DATA}}
        {{remark.DATA}}
        */

        $order_info = M('order')->where(array('order_id' => $order_id))->find();
        $user_info = M('user_wechat')->where(array('user_id' => $order_info['user_id']))->find();
        $finish_time = date("Y-m-d H:i:s",time());
        $remark = "点击查看详情";
        $data = array(
            'productType' => array('value' => urlencode("服务项目"), 'color' => '#1C94C4'),
            'name' => array('value' => urlencode($order_info['goods_name']), 'color' => '#1C94C4'),
            'time' => array('value' => urlencode($finish_time), 'color' => '#1C94C4'),

            'remark' => array('value' => urlencode($remark), 'color' => '#1C94C4')
        );
        $template_id = '6wY83pm7GeIrhNx9BylL4YE0wP4lrbcSgj0rs_xSVf0';
        $openid = $user_info['openid'];
        if ($openid) {
            $url = "http://wechat.wnway.com/Order/orderInfo?order_id=".$order_id;
            $this->doSend($openid, $template_id, $url, $data);
        }
    }


    public function newNeed($shop_id,$need_id)
    {
        /*
        HOcnfa3GIS3C73W3WWcqgISsN-K0sZzy-X7St9ZtsMw

        {{first.DATA}}
客户需求：{{keyword1.DATA}}
客户名称：{{keyword2.DATA}}
提出时间：{{keyword3.DATA}}
{{remark.DATA}}
        */

        $need_info = M('need')->where(array('id' => $need_id))->find();
        $user_info = M('user')->where(array('user_id' => $need_info['user_id']))->find();
        $shop_info = M('shop')->where(array('shop_id' => $shop_id))->find();

        $first = "有新的客户需求";
        $remark = "点击查看";
        $data = array(
            'first' => array('value' => urlencode($first), 'color' => "#743A3A"),
            'keyword1' => array('value' => urlencode($need_info['goods_name']."需求"), 'color' => '#1C94C4'),
            'keyword2' => array('value' => urlencode($user_info['user_name']), 'color' => '#1C94C4'),
            'keyword3' => array('value' => urlencode(date('Y-m-d H:i:s',$need_info['add_time'])), 'color' => '#1C94C4'),
            'remark' => array('value' => urlencode($remark), 'color' => '#1C94C4')
        );
        $template_id = 'HOcnfa3GIS3C73W3WWcqgISsN-K0sZzy-X7St9ZtsMw';
        $openid = $shop_info['admin_openid'];
        if ($openid) {
            $url = "http://wechat.wnway.com/Need/checkNeed?need_id=".$need_id;
            $this->doSend($openid, $template_id, $url, $data);
        }


    }

    public function newPrice($shop_id,$need_id,$price)
    {
        /*
        c_tQRmqygnip_RRed4PAwE5ewoyjCswl2hs6JIlVgVU

        {{first.DATA}}
报价卖家：{{keyword1.DATA}}
报价档口：{{keyword2.DATA}}
报价金额：{{keyword3.DATA}}
报价时间：{{keyword4.DATA}}
{{remark.DATA}}
        */



        $need_info = M('need')->where(array('id' => $need_id))->find();
        $user_info = M('user_wechat')->where(array('user_id' => $need_info['user_id']))->find();
        $shop_info = M('shop')->where(array('shop_id' => $shop_id))->find();

        $first = "你的需求有新的报价";
        $remark = "点击查看";
        $data = array(
            'first' => array('value' => urlencode($first), 'color' => "#743A3A"),
            'keyword1' => array('value' => urlencode($shop_info['shop_name']."需求"), 'color' => '#1C94C4'),
            'keyword2' => array('value' => urlencode($shop_info['address']), 'color' => '#1C94C4'),
            'keyword3' => array('value' => urlencode('￥'.$price), 'color' => '#1C94C4'),
            'keyword4' => array('value' => urlencode(date('Y-m-d H:i:s',time())), 'color' => '#1C94C4'),
            'remark' => array('value' => urlencode($remark), 'color' => '#1C94C4')
        );
        $template_id = 'c_tQRmqygnip_RRed4PAwE5ewoyjCswl2hs6JIlVgVU';
        $openid = $user_info['openid'];
        if ($openid) {
            $url = "http://wechat.wnway.com/Need/checkNeed?need_id=".$need_id;
            $this->doSend($openid, $template_id, $url, $data);
        }




    }

    public function doRefund($order_id)
    {
        /*
         0bAhsvFFAOeWOdKTiOyIOhiHJxWTbHdrMe1iRca-OYc
         {{first.DATA}}
        退款原因：{{reason.DATA}}
        退款金额：{{refund.DATA}}
        {{remark.DATA}}

         */

        $order_info = M('order')->where(array('order_id' => $order_id))->find();
        $user_info = M('user_wechat')->where(array('user_id' => $order_info['user_id']))->find();

        $first = "你的订单已退款";
        $remark = "点击查看详情";
        $data = array(
            'first' => array('value' => urlencode($first), 'color' => "#743A3A"),
            'reason' => array('value' => urlencode($order_info['remark']), 'color' => '#1C94C4'),
            'refund' => array('value' => urlencode($order_info['amount']), 'color' => '#1C94C4'),
            'remark' => array('value' => urlencode($remark), 'color' => '#1C94C4')
        );
        $template_id = '0bAhsvFFAOeWOdKTiOyIOhiHJxWTbHdrMe1iRca-OYc';
        $openid = $user_info['openid'];
        if ($openid) {
            $url = "http://wechat.wnway.com/Order/orderInfo?order_id=".$order_id;
            $this->doSend($openid, $template_id, $url, $data);
        }
    }

    public function confirmNeed($shop_id,$need_id,$remark_baojia)
    {
        /*
        y3b4c1pRwWHBJpJrBIBmbSKpSSWuFYm76jZEuRGIsW0

        {{first.DATA}}
报价项目：{{keyword1.DATA}}
报价内容：{{keyword2.DATA}}
价格：{{keyword3.DATA}}
时间：{{keyword4.DATA}}
{{remark.DATA}}
        */

        $need_info = M('need')->where(array('id' => $need_id))->find();
        $shop_info = M('shop')->where(array('shop_id' => $shop_id))->find();

        $first = "你的报价已被用户采纳";
        $remark = "点击查看";
        $data = array(
            'first' => array('value' => urlencode($first), 'color' => "#743A3A"),
            'keyword1' => array('value' => urlencode($need_info['goods_name']), 'color' => '#1C94C4'),
            'keyword2' => array('value' => urlencode($remark_baojia), 'color' => '#1C94C4'),
            'keyword3' => array('value' => urlencode($need_info['amount']), 'color' => '#1C94C4'),
            'keyword4' => array('value' => urlencode(date('Y-m-d H:i:s',time())), 'color' => '#1C94C4'),
            'remark' => array('value' => urlencode($remark), 'color' => '#1C94C4')
        );
        $template_id = 'y3b4c1pRwWHBJpJrBIBmbSKpSSWuFYm76jZEuRGIsW0';
        $openid = $shop_info['admin_openid'];
        if ($openid) {
            $url = "http://wechat.wnway.com/Need/checkNeed?need_id=".$need_id;
            $this->doSend($openid, $template_id, $url, $data);
        }



    }



    /****************************新的二手车*******************************/
    public function newSecCar($user_id,$sec_id)
    {
        /*
        HOcnfa3GIS3C73W3WWcqgISsN-K0sZzy-X7St9ZtsMw

        {{first.DATA}}
客户需求：{{keyword1.DATA}}
客户名称：{{keyword2.DATA}}
提出时间：{{keyword3.DATA}}
{{remark.DATA}}
        */

        $sec_car_info = M('second_car')->where(array('id' => $sec_id))->find();
        $pingu_info = M('user_wechat')->where(array('user_id' => $user_id))->find();

        $car_info = M('user_car')->where(array('id' => $sec_car_info['car_id']))->find();
        $brand_name = M('car_brand')->where(array('id' => $car_info['brand_id']))->getField("name");
        $fct_name = M('car_fct')->where(array('id' => $car_info['fct_id']))->getField("name");
        $ser_info = M('car_series')->where(array('id' => $car_info['ser_id']))->find();

        $first = "有新的二手车需要报价";
        $remark = "点击查看";
        $data = array(
            'first' => array('value' => urlencode($first), 'color' => "#743A3A"),
            'keyword1' => array('value' => urlencode($brand_name.$fct_name.$ser_info['name']), 'color' => '#1C94C4'),
            'keyword2' => array('value' => urlencode($ser_info['realname']), 'color' => '#1C94C4'),
            'keyword3' => array('value' => urlencode(date('Y-m-d H:i:s',$sec_car_info['add_time'])), 'color' => '#1C94C4'),
            'remark' => array('value' => urlencode($remark), 'color' => '#1C94C4')
        );
        $template_id = 'HOcnfa3GIS3C73W3WWcqgISsN-K0sZzy-X7St9ZtsMw';
        $openid = $pingu_info['openid'];
        if ($openid) {
            $url = "http://wechat.wnway.com/SecondCar/checkCar?sec_id=".$sec_id;
            $this->doSend($openid, $template_id, $url, $data);
        }


    }


    public function newSecPrice($user_id,$sec_id,$price)
    {
        /*
        c_tQRmqygnip_RRed4PAwE5ewoyjCswl2hs6JIlVgVU

        {{first.DATA}}
报价卖家：{{keyword1.DATA}}
报价档口：{{keyword2.DATA}}
报价金额：{{keyword3.DATA}}
报价时间：{{keyword4.DATA}}
{{remark.DATA}}
        */

        $sec_car_info = M('second_car')->where(array('id' => $sec_id))->find();
        $user_info = M('user_wechat')->where(array('user_id' => $sec_car_info['user_id']))->find();
        $ser_car_price_info = M('second_car_price')->where(array('user_id' => $user_id,'sec_id' => $sec_id))->find();

        $brand_name = $sec_car_info['car_brand_name'];
        $fct_name = $sec_car_info['car_fct_name'];
        $ser_name = $sec_car_info['car_ser_name'];


        $first = "你的二手车有新的报价";
        $remark = "点击查看";
        $data = array(
            'first' => array('value' => urlencode($first), 'color' => "#743A3A"),
            'keyword1' => array('value' => urlencode(date('Y-m-d H:i:s',time())), 'color' => '#1C94C4'),
            'keyword2' => array('value' => urlencode($ser_car_price_info['realname']), 'color' => '#1C94C4'),
            'keyword3' => array('value' => urlencode($brand_name.$fct_name.$ser_name), 'color' => '#1C94C4'),
            'keyword4' => array('value' => urlencode('￥'.$price), 'color' => '#1C94C4'),
            'remark' => array('value' => urlencode($remark), 'color' => '#1C94C4')
        );
        $template_id = 'WHryNtJxxvoLIKUpw5ECCoaUvSEnMwwRzRr8UAgYP-I';
        $openid = $user_info['openid'];
        if ($openid) {
            $url = "http://wechat.wnway.com/SecondCar/carInfo?id=".$sec_id;
            $this->doSend($openid, $template_id, $url, $data);
        }




    }



    public function confirmSec($user_id,$sec_id,$remark_baojia)
    {
        /*
        y3b4c1pRwWHBJpJrBIBmbSKpSSWuFYm76jZEuRGIsW0

        {{first.DATA}}
报价项目：{{keyword1.DATA}}
报价内容：{{keyword2.DATA}}
价格：{{keyword3.DATA}}
时间：{{keyword4.DATA}}
{{remark.DATA}}
        */

        $sec_car_info = M('second_car')->where(array('id' => $sec_id))->find();
        $user_info = M('user_wechat')->where(array('user_id' => $user_id))->find();

        $brand_name = $sec_car_info['car_brand_name'];
        $fct_name = $sec_car_info['car_fct_name'];
        $ser_name = $sec_car_info['car_ser_name'];

        $first = "你的报价已被用户采纳";
        $remark = "点击查看";
        $data = array(
            'first' => array('value' => urlencode($first), 'color' => "#743A3A"),
            'keyword1' => array('value' => urlencode($brand_name.$fct_name.$ser_name), 'color' => '#1C94C4'),
            'keyword2' => array('value' => urlencode($remark_baojia), 'color' => '#1C94C4'),
            'keyword3' => array('value' => urlencode($sec_car_info['amount']), 'color' => '#1C94C4'),
            'keyword4' => array('value' => urlencode(date('Y-m-d H:i:s',time())), 'color' => '#1C94C4'),
            'remark' => array('value' => urlencode($remark), 'color' => '#1C94C4')
        );
        $template_id = 'y3b4c1pRwWHBJpJrBIBmbSKpSSWuFYm76jZEuRGIsW0';
        $openid = $user_info['openid'];
        if ($openid) {
            $url = "http://wechat.wnway.com/SecondCar/checkCar?sec_id=".$sec_id;
            $this->doSend($openid, $template_id, $url, $data);
        }



    }









    public function newDaiban($user_id,$daiban_id)
    {
        /*
        HOcnfa3GIS3C73W3WWcqgISsN-K0sZzy-X7St9ZtsMw

        {{first.DATA}}
客户需求：{{keyword1.DATA}}
客户名称：{{keyword2.DATA}}
提出时间：{{keyword3.DATA}}
{{remark.DATA}}
        */

        $daiban_order_info = M('daiban_order')->where(array('id' => $daiban_id))->find();
        $pingu_info = M('user_wechat')->where(array('user_id' => $user_id))->find();


        $first = "有新的代办年审订单";
        $remark = "点击查看";
        $data = array(
            'first' => array('value' => urlencode($first), 'color' => "#743A3A"),
            'keyword1' => array('value' => urlencode("代办年审"), 'color' => '#1C94C4'),
            'keyword2' => array('value' => urlencode($daiban_order_info['realname']), 'color' => '#1C94C4'),
            'keyword3' => array('value' => urlencode(date('Y-m-d H:i:s',$daiban_order_info['add_time'])), 'color' => '#1C94C4'),
            'remark' => array('value' => urlencode($remark), 'color' => '#1C94C4')
        );
        $template_id = 'HOcnfa3GIS3C73W3WWcqgISsN-K0sZzy-X7St9ZtsMw';
        $openid = $pingu_info['openid'];
        if ($openid) {
            $url = "http://wechat.wnway.com/Daiban/check?daiban_id=".$daiban_id;
            $this->doSend($openid, $template_id, $url, $data);
        }


    }


}