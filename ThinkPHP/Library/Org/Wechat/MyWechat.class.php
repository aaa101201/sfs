<?php

namespace Org\Wechat;

use Think\Model;

/**
 * 微信公众平台演示类
 */
class MyWechat extends Wechat {

    protected $base_url = "";

    public function __construct($token,$debug = FALSE) {
        parent::__construct($token, $debug);
    }

    /**
     * 用户关注时触发，回复「欢迎关注」
     *
     * @return void
     */
    protected function onSubscribe() {

        $this->trackLog("excute", "onSubscribe()");
        $eventkey = $this->getRequest('eventkey');
        $this->trackLog("eventkey", $eventkey);

        if($eventkey){

            $this->checkEventKey($eventkey);
            $this->replyWelcomeActivity();

        } else {

            $this->checkEventKey(0);
            $this->replyWelcomeActivity();

        }

    }

    /**
     * 关注时回复的图文消息
     */
    protected function replyWelcomeActivity() {

        $this->trackLog("excute", "replyWelcomeActivity");

        $picurl = "http://wechat.luobojianzhi.com/Public/promot/images/muzhirenwu.jpg";
        $url = "http://mp.weixin.qq.com/s/apOFq1if73gy-a0IDa5qPg";
        $title = "谁说在校生月入2000元不可能？";
        $desc = "谁说在校生月入2000元不可能？";

        $items = array(
            new NewsResponseItem($title, $desc, $picurl, $url),
            new NewsResponseItem('【你见过会生钱的萝卜钱包吗？】', '', '', "http://mp.weixin.qq.com/s/GuKk9rl8NzJG_em7nrOUkQ"),
        );

        $this->responseNews($items);
    }

    /**
     * 关注时回复的图文消息
     */
    protected function replyWelcome(){
        $picurl = "";
        $url = "";
        $title = "";
        $desc = "";
        $items = array(
            new NewsResponseItem($title, $desc, $picurl, $url),
        );

        $this->responseNews($items);
    }

    /**
     * 用户取消关注时触发
     *
     * @return void
     */
    protected function onUnsubscribe(){
        // 「悄悄的我走了，正如我悄悄的来；我挥一挥衣袖，不带走一片云彩。」

        //将用户的状态改成未关注
        $openid = $this->getRequest("fromusername");

        $model = new Model();
        $extSql = "SELECT * FROM ac_chief_fans WHERE openid='$openid'";
        $this->trackLog("extSql", $extSql);
        $info = $model->query($extSql);
        $this->trackLog("info", $info);

        if($info){
            $extSql = "UPDATE wt_user SET status=0 WHERE wechat_openid='$openid'";
            $this->trackLog("extSql", $extSql);
            $result = $model->execute($extSql);
            $this->trackLog("result", $result);

            $extSql = "UPDATE ac_chief_fans SET status=0 WHERE openid ='$openid'";
            $this->trackLog("extSql", $extSql);
            $result = $model->execute($extSql);
            $this->trackLog("result", $result);

            //减少数量
            $extSql = "UPDATE ac_chief SET number=number-1 WHERE id='".$info[0]['chiefid']."'";
            $this->trackLog("extSql", $extSql);
            $result = $model->execute($extSql);
            $this->trackLog("result", $result);
        }

    }

    /**
     * 收到文本消息时触发，回复收到的文本消息内容F
     *
     * @return void
     */
    protected function onText()
    {
        $content = $this->getRequest('content');
        if($content == 'id')
        {
            $this->responseText($this->getRequest("fromusername"));
        }else if($this->IsKeyNo($content)){

            //$this->responseText("① 请关注“高校脱单”微信公众号（直接搜索微信ID：gaoxiaotuodan，即可关注）；\n② 在“高校脱单”公众号内回复Ta的编号即可获取联系方式哦~");

            $this->responseImage('LOjgWuHoE-Bqm1upmXcaqJJEFvSpEZzrqjYe3uvXD-I');
        }else if ($content == '178'){
            $this->responseText("☞ <a href=\"http://e.gfd178.com/5m7GNgH4\">点我打照片</a> ☜ \n如果上方链接未能正常进入，请点击备用链接：☞<a href=\"http://blog.sina.com.cn/s/blog_1324268600102wxmo.html \">开始打印备用链接</a>☜");
        }else if($content == '情侣'){

            $this->responseText("<a href=\"http://cn.mikecrm.com/idFbLep\">http://cn.mikecrm.com/idFbLep</a>");

        }else if($content == '高考文科'){
            $this->responseText("<a href=\"http://mp.weixin.qq.com/s/jmdzfRDlv7fALw55VVFAtA\">（文科卷）再高考，我的分数可以上复旦！</a>");
        }else if($content == '高考理科'){
            $this->responseText("<a href=\"http://mp.weixin.qq.com/s/48Akkqt-wIZrMjk74UQflw\">（理科卷）再高考，您已被中科大录取！</a>");
        } else if ($content == '提现'){
            $this->responseText("感谢您使用萝卜钱包，提现时间为工作日内24小时，请耐心等待。");
        }else if ($content == '萝卜钱包'){
            $this->responseText("http://wechat.luobojianzhi.com/index.php/Home/Ad/luoboWallet_2?toWallet=0");
        }else if ($content == '注册'){
            $this->responseText("http://wechat.luobojianzhi.com/index.php/Home/Wechat/signUp");
        }else if ($content == '客服电话'){
            $this->responseText("0631-5666168");
        }else if ($content == '拇指任务') {
            $picurl = "http://wechat.luobojianzhi.com/Public/promot/images/muzhirenwu.jpg";
            $url = "http://mp.weixin.qq.com/s/apOFq1if73gy-a0IDa5qPg";
            $title = "谁说在校生月入2000元不可能？";
            $desc = "谁说在校生月入2000元不可能？";

            $items = array(
                new NewsResponseItem($title, $desc, $picurl, $url)
            );

            $this->responseNews($items);
        }else if ($content == '萝卜头领') {
            $picurl = "http://wechat.luobojianzhi.com/Public/promot/images/luobotouling.jpg";
            $url = "http://mp.weixin.qq.com/s/QROYD3JXEqGX8SVNShI96w";
            $title = "招募头领 | 头领任务升级啦，佣金赚更多！";
            $desc = "萝卜头领，一呼百应！";

            $items = array(
                new NewsResponseItem($title, $desc, $picurl, $url)
            );

            $this->responseNews($items);
        }else {
            $this->responseText("您的消息已收到，稍候回复您");
        }

    }

    /**
     * 高校脱单回复序号判断
     *
     * @return boolean
     */
    private function IsKeyNo($content){

        $keys = array(
            '6321','6666','1390','51838','50970','51062','44477','50692','53227','2857','52245',
            '1908','52637','51979','50263','14998','52815','4955','52895','51803','1868','48066',
            '27146','50879','54171','54369','54677','54936','52508', '043', '5629', '055', '27559',
            '061', '55997', '55219', '1141', '53947', '53706', '57005', '56297', '52563', '55569',
            '49669', '56990', '56859', '56998', '56983', '56917', '56756', '35432', '4043', '5427',
            '56869', '58235', '50084', '58302', '55028', '51350', '57576', '58334', '58330', '58289',
            '58282', '58373', '57734', '57985', '52163',
        );

        if(in_array($content, $keys)){

            return TRUE;
        }else{

            return FALSE;
        }
    }


    /**
     * 收到图片消息时触发，回复由收到的图片组成的图文消息
     *
     * @return void
     */
    protected
    function onImage()
    {
        $items = array(
            new NewsResponseItem('标题一', '描述一', $this->getRequest('picurl'), $this->getRequest('picurl')),
            new NewsResponseItem('标题二', '描述二', $this->getRequest('picurl'), $this->getRequest('picurl')),
        );

        // $this->responseNews($items);
    }

    /**
     * 收到地理位置消息时触发，回复收到的地理位置
     *
     * @return void
     */
    protected
    function onLocation()
    {


        //$this->responseText('收到了位置消息：' . $this->getRequest('location_x') . ',' . $this->getRequest('location_y'));

    }

    /**
     * 收到链接消息时触发，回复收到的链接地址
     *
     * @return void
     */
    protected
    function onLink()
    {
        //$this->responseText('收到了链接：' . $this->getRequest('url'));
    }

    /**
     * 收到自定义菜单消息时触发，用于子类重写
     *
     * @return void
     */
    protected function onClick() {
        $key = $this->getRequest('eventkey');

        switch($key)
        {

        }
    }

    /**
     * 收到未知类型消息时触发，回复收到的消息类型
     *
     * @return void
     */
    protected
    function onUnknown()
    {
        $this->responseText('收到了未知类型消息：' . $this->getRequest('msgtype'));
    }

    /**
     * 扫描二维码时触发，用于子类重写
     *
     * @return void
     */
    protected function onScan() {

        if($this->getRequest('eventkey')){
        }
    }



    /**
     * 检查自定义二维码
     * @param $eventkey
     * @param bool $is_first
     */
    protected function checkEventKey($eventkey, $is_first = true) {

        $this->trackLog("excute", "checkEventKey");

        $this->trackLog("eventkey", $eventkey);

        $chiefId = 0;

        if(strstr($eventkey, "qrscene")) {

            $arr = explode("_",$eventkey);
            $chiefId = intval($arr[1]);

        } else {

            $chiefId = intval($eventkey);

        }

        //获取全局access_token
        $model = new Model();
        $appId = C('WT_APP_ID');
        $querySql = "SELECT accessToken FROM wt_account WHERE appId = '$appId'";
        $this->trackLog("querySql", $querySql);
        $accessToken = $model->query($querySql);
        $this->trackLog("accessToken", $accessToken);

        if($accessToken){

            $accessToken = $accessToken[0]['accesstoken'];
        }else{

            $accessToken = '';
        }
        $openid = $this->getRequest("fromusername");
        $this->trackLog("openid", $openid);
        $this->trackLog("accessToken", $accessToken);

        //获取用户信息
        $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=" . $accessToken . "&openid=" . $openid . "&lang=zh_CN";
        $json = file_get_contents($url);
        $this->trackLog("json", $json);
        $json = json_decode($json, true);
        $nickname = '';
        $headimgurl = '';
        if(array_key_exists('nickname', $json) && array_key_exists('headimgurl', $json)){
            $nickname = $json['nickname'];
            $headimgurl = $json['headimgurl'];
        }

        //判断以前是否关注过
        $extSql = "SELECT * FROM ac_chief_fans WHERE openid='$openid'";
        $this->trackLog("extSql", $extSql);
        $res = $model->query($extSql);
        $this->trackLog("res", $res);

        if($res) {

            $this->trackLog("chiefId", $chiefId);
            if($res[0]['chiefid'] > 0) {
                //增加数量
                $extSql = "UPDATE ac_chief SET number=number+1 WHERE id='".$res[0]['chiefid']."'";
                $this->trackLog("extSql", $extSql);
                $res = $model->execute($extSql);
                $this->trackLog("res", $res);
            }

            //修改为关注状态
            $extSql = "UPDATE ac_chief_fans SET status=1 WHERE openid='$openid'";
            $this->trackLog("extSql", $extSql);
            $res = $model->execute($extSql);
            $this->trackLog("res", $res);

        } else {

            $userThirdId = 0;
            $extSql = "SELECT * FROM wt_user WHERE wechat_openid='$openid'";
            $this->trackLog("extSql", $extSql);
            $wxinfo = $model->query($extSql);
            $this->trackLog("wxinfo", $wxinfo);

            if($wxinfo) {

                $userThirdId = 0;
                $extSql = "UPDATE wt_user SET from_promot_id='$chiefId',status=1 WHERE wechat_openid='$openid'";
                $this->trackLog("extSql", $extSql);
                $result = $model->execute($extSql);
                $this->trackLog("result", $result);
                $userThirdId =  $wxinfo[0]['id'];
            } else {

                //如果是新用户，插入到微信用户表中
                $extSql = "INSERT INTO wt_user(wechat_openid,nickname,headimgurl,status,from_promot_id) VALUES("
                    ."'$openid','$nickname','$headimgurl',1,'$chiefId')";
                $this->trackLog("extSql", $extSql);
                $result = $model->execute($extSql);
                $this->trackLog("result", $result);

                //获取新插入记录的id
                $extSql = "SELECT id FROM wt_user WHERE wechat_openid='$openid'";
                $this->trackLog("extSql", $extSql);
                $result = $model->query($extSql);
                $this->trackLog("result", $result);

                $userThirdId = $result[0]['id'];
            }

            //如果是新用户，插入到微信用户表中
            $extSql = "INSERT INTO ac_chief_fans(wxid, chiefId, nickname, headimgurl, status, openid) VALUES("
                ."'$userThirdId','$chiefId', '$nickname', '$headimgurl', 1, '$openid')";
            $this->trackLog("extSql", $extSql);
            $result = $model->execute($extSql);
            $this->trackLog("result", $result);

            //增加萝卜头领粉丝数量
            $extSql = "UPDATE ac_chief SET number=number+1 WHERE id='$chiefId'";
            $this->trackLog("extSql", $extSql);
            $res = $model->execute($extSql);
            $this->trackLog("res", $res);
        }
    }


    /**
     * 回复图文消息
     * @param $title
     * @param $desc
     * @param string $url
     * @param string $pic_url
     */
    protected function _reply($title,$desc,$url = "http://www.baidu.com",$pic_url = "")
    {
        $url = $url."&openid=".$this->getRequest("fromusername");
        $item = new NewsResponseItem($title, $desc,$pic_url, $url);
        $response[] = $item;
        $this->responseNews($response);
    }





}