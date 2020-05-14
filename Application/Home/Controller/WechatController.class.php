<?php
/**
 * Created by PhpStorm.
 * User: StandOpen
 * Date: 14-12-1
 * Time: 11:10
 */
namespace Home\Controller;

use Home\Service\UserService;
use Enum\SessionEnum;

abstract class WechatController extends BaseController
{


    public function _initialize() {

        parent::_initialize();
        $accountId = I("accountId", "1", "intval");//wt_account表  公众号对应的系统表ID 默认为通达汽车
        $wtUser = session("wechatUser");
        if(!empty($wtUser['errcode'])){
            session("wechatUser",null);
        }
        $this->loger("wechatUser", $wtUser);
        $user = new UserService();
        $user->getWtAccount($accountId);
        if (!$wtUser) {
            if (isset($_REQUEST['code'])) {// 用户同意授权
                $this->loger("code", $_REQUEST['code']);
                $this->wechatCallBack();
            } else { //初始化OR用户拒绝授权后，REDO授权请求。
                $this->oAuth();
                exit();
            }
        }
    }

    /**
     * 微信oAuth认证
     */
    protected function oAuth() {
        $info = session(SessionEnum::WECHAT_ACCOUNT_INFO);
        $this->loger("excute", "oAuth()");
        $protocal = $_SERVER['SERVER_PROTOCOL'];
        if ($protocal['5'] == 's') {
            $protocal = 'https://';
        } else {
            $protocal = 'http://';
        }
        $http_host = $_SERVER['HTTP_HOST'];
        $origin_url = $protocal . $http_host;
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=" . $info['appid'] . "&redirect_uri=" . urlencode($origin_url) . $_SERVER['REQUEST_URI'] . "&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
        $this->loger("url", $url);
        header("Location:" . $url);
    }

    /**
     * 获取微信个人信息
     */
    protected function wechatCallBack() {
        $this->loger("excute", "wechatCallBack()");
        $info = session(SessionEnum::WECHAT_ACCOUNT_INFO);

        $code = $_REQUEST['code'];
        $state = $_REQUEST['state'];
        $this->loger("code", $code);
        $this->loger("state", $state);

        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=" . $info['appid'] . "&secret=" . $info['appsecret'] . "&code=" . $code . "&grant_type=authorization_code";
        $this->loger("url", $url);
        $data = file_get_contents($url);
        $this->loger("data", $data);

        $baseInfo = json_decode($data);
        $access_token = $baseInfo->access_token;
        $openid = $baseInfo->openid;
        $url = "https://api.weixin.qq.com/sns/userinfo?access_token=" . $access_token . "&openid=" . $openid . "&lang=zh_CN";
        $this->loger("url", $url);
        $data = file_get_contents($url);
        $this->loger("data", $data);

        $wechatUser = json_decode($data, true);
        $this->doSession($wechatUser);
        header('Content-type: text/html;charset=utf-8');
    }

    private function doSession($user) {
        session("wechatUser", $user, 3600 * 24);
        session("wechatUserOpenId", $user["openid"], 3600 * 24);
    }
}
