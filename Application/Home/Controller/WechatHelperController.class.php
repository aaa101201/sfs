<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/28 0028
 * Time: 15:11
 */

namespace Home\Controller;
use Org\Wechat\MyWechat;

class WechatHelperController extends BaseController {

    public function validate(){
        $wechat = new MyWechat(C('WT_APP_TOKEN'), true);
        $wechat->run();
    }

     //http://wechat.luobojianzhi.com/index.php/home/Tool/refreshAccessToken/wt/3
    public function refreshAccessToken() {

        $appInfo = $this->getAppInfo();

        $appId = $appInfo["appid"];
        $appSecret = $appInfo["appsecret"];
        $appAlias = $appInfo["alias"];
        $this->trackLog("appId", $appId);
        $this->trackLog("appSecret", $appSecret);

        $url = $this->apiAccesstoken. "&appid=" . $appId . "&secret=" . $appSecret;
        $this->trackLog("url", $url);

        $json = file_get_contents($url);
        $this->trackLog("json", $json);
        $baseInfo = json_decode($json);
        
        //更新jssdk和wechatPush使用的access_token.json文件，修复之前生成二维码失败的诡异错误
        $accessToken = $baseInfo->access_token;
        $this->trackLog("access_token", $accessToken);
        if ($accessToken && C('WT_APP_ID') == $appId) {
            
            $json_file = json_decode(file_get_contents("./Public/token/access_token.json"));
            $json_file->expire_time = time() + 7000;
            $json_file->access_token = $accessToken;
            $fp = fopen("./Public/token/access_token.json", "w");
            fwrite($fp, json_encode($json_file));
            fclose($fp);
        }
        
        $model = new Model();
        $result = $model->query("SELECT * FROM wt_account WHERE appId='$appId'");
        $this->trackLog("result", json_encode($result));

        if(!empty($result)) {
            $result = $model->execute("UPDATE wt_account SET accessToken = '$accessToken' WHERE appId = '$appId'");
        }

        $data['code']  = 1;
        $data['msg']  = $appAlias . " accessToken refresh successfully!";
        $data['accesstoken']  = $accessToken;
        $this->ajaxReturn($data);
    }


    private function getAppInfo() {
        $wechatAlias = I('wt');
        $this->trackLog("wechatAlias", $wechatAlias);

        if(!is_string($wechatAlias)) {
            $data['wechatAlias'] = $wechatAlias;
            $data['code']  = 1;
            $data['msg']  = "wechatId参数不正确";
            $this->ajaxReturn($data);
        } 

        $model = new Model();

        $data = $model->query("SELECT * FROM wt_account WHERE alias='$wechatAlias'");
        $this->trackLog("data", json_encode($data));

        if(empty($data)) {
            $data['code']  = 1;
            $data['msg']  = "微信账户不存在!";
            $this->ajaxReturn($data);
        }

        return $data[0];
    }
    // http://wechat.luobojianzhi.com/index.php/home/tool/createMenu/wt/3
    public function createMenu() {

        $appInfo = $this->getAppInfo();

        $appId = $appInfo["appid"];
        $appSecret = $appInfo["appsecret"];
        $appAlias = $appInfo["alias"];
        $this->trackLog("appId", $appId);
        $this->trackLog("appSecret", $appSecret);

        //获取配置的菜单
        $model = new Model();

        $result = $model->query("SELECT content FROM wt_menu WHERE appId='$appId'");
        $this->trackLog("$result", json_encode($result));

        $menuContent = "";
        if(!empty($result)) {
            $menuContent = $result[0]["content"];
            $this->trackLog("menuContent", $menuContent);
        }

        $accessToken = "";
        $result = $model->query("SELECT accessToken FROM wt_account WHERE appId='$appId'");
        if(!empty($result)) {
            $accessToken = $result[0]["accesstoken"];
            $this->trackLog("accessToken", $accessToken);
        }

        $post_url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=$accessToken";
        $ch = curl_init($post_url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $menuContent);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($menuContent))
        );
        $respose_data = curl_exec($ch);

        $data['code']  = 1;
        $data['msg']  = "$appAlias menu create successfully!";
        $data['resposeData']  = $respose_data;
        $this->ajaxReturn($data);
    }

}