<?php
/**
 * Created by PhpStorm.
 * User: StandOpen
 * Date: 15-1-16
 * Time: 9:18
 */
namespace Org\Wechat;
use Think\Log;

class Jssdk {
    private $appId;
    private $appSecret;


    public function __construct($appId = false, $appSecret = false)
    {
        if ($appId) {
            $this->appId = $appId;
            $this->appSecret = $appSecret;
        } else {
            $appid_info = $this->getConfig("appid");
            if ($appid_info) {
                $this->appId = $appid_info['value'];
            }
            $appsec_info = $this->getConfig("appsecret");
            if ($appsec_info) {
                $this->appSecret = $appsec_info['value'];
            }
        }

    }

    protected function trackLog($title, $content, $type="DEBUG") {

        if(!is_string($content)) {
            $content = json_encode($content);
        }

        $_prefix = "[ Jiechengkeji ]";
        $_date = "[ " . date("H:i:s", time()) . " ]";
        $title = "[ " . $title . " ]";

        Log::record($_prefix ." ". $_date ." ". $title . " " . $content, $type);
    }

    protected function getConfig($key)
    {
        $config_info = M('config')->where(array('key' => $key))->find();
        return $config_info;
    }

    public function getSignPackage()
    {
        $jsapiTicket = $this->getJsApiTicket();
        $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $timestamp = time();
        $nonceStr = $this->createNonceStr();

        // 这里参数的顺序要按照 key 值 ASCII 码升序排序
        $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";

        $signature = sha1($string);

        $signPackage = array(
            "appId" => $this->appId,
            "nonceStr" => $nonceStr,
            "timestamp" => $timestamp,
            "url" => $url,
            "signature" => $signature,
            "rawString" => $string
        );
        return $signPackage;
    }

    private function createNonceStr($length = 16)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    private function getJsApiTicket()
    {
        // jsapi_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
        $data = json_decode(file_get_contents("./Public/token/jsapi_ticket.json"));
        if ($data->expire_time < time()) {
            $accessToken = $this->getToken($this->appId, $this->appSecret);
            // 如果是企业号用以下 URL 获取 ticket
            //$url = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token=$accessToken";
            $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
            $res = json_decode($this->httpGet($url));
            $ticket = $res->ticket;
            if ($ticket) {
                $data->expire_time = time() + 7000;
                $data->jsapi_ticket = $ticket;
                $fp = fopen("./Public/token/jsapi_ticket.json", "w");
                fwrite($fp, json_encode($data));
                fclose($fp);
            }
        } else {
            $ticket = $data->jsapi_ticket;
        }

        return $ticket;
    }

    /**
     * @param $appid
     * @param $appsecret
     * @return mixed
     * 获取token
     */
    public function getToken($appid, $appsecret)
    {


        $data = json_decode(file_get_contents("./Public/token/access_token.json"));
        if ($data->expire_time < time()) {
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $appid . "&secret=" . $appsecret;
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

    private function httpGet($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_URL, $url);

        $res = curl_exec($curl);
        curl_close($curl);

        return $res;
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


    public function createQr($data)
    {
        $token = $this->getToken($this->appId, $this->appSecret);
        $url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=" . $token;
        $result = $this->request_post($url, $data);
        $arr = json_decode($result, true);
        $this->trackLog("createQr", $arr);
        if (isset($arr['errcode']) && $arr['errcode'] != 0) {
            return false;
        } else {
            return $arr;
        }
    }

}