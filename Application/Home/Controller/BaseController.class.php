<?php

/**
 * User: James.Yu<zhenzhouyu@jiechengkeji.cn>
 * CreateTime: 03/23/16
 * UpdateTime: 05/10/16
 */

namespace Home\Controller;

use Enum\SessionEnum;
use Think\Controller;
use Tools\XLog;


class BaseController extends Controller {

    CONST SYSTEM_SECRET = "LUOBOJIANZHI";

    public function _initialize() {
        $this->behaviorLog();
        $this->loger("initialized", "BaseController");
    }

    // 跟踪日志
    protected function loger($title, $content) {
        XLog::trackLog($title, $content);
    }

    // 行为日志(loger.yingfankeji.net) TODO
    private function behaviorLog() {

        if(__ACTION__==="/index.php/Home/Tools/biLog")
            return;

        $_DATA = array();
        if (IS_POST){

            parse_str(file_get_contents('php://input'), $_DATA);
        }else if(IS_GET){

            $queryString = urldecode($_SERVER['QUERY_STRING']);
            $_DATA = array_merge($_DATA, $this->convertGetParam($queryString));
        }

        $user = session(SessionEnum::USER_INFO);
        if(!is_null($user))
            $_DATA['userId'] = $user["id"];
        $wt_user = session(SessionEnum::WECHAT_USER);
        if(!is_null($wt_user))
            $_DATA['openid'] = $wt_user["openid"];

        $city = session("curr_city");
        if(!is_null($city)){
            $_DATA['cityId'] = $city["id"];
        }

        $data['data'] = json_encode($_DATA);

        $data['source'] = $_SERVER['SERVER_NAME'];
        $data['action'] = __ACTION__;

        $this->loger("data", $data);

        $fieldSql = "";
        $valueSql = "";
        foreach ($data as $key => $value) {
            $fieldSql = $fieldSql . ", $key";
            $valueSql = $valueSql . ", '$value'";
        }

        $fieldSql = substr($fieldSql, (strpos($fieldSql, ",")+1));
        $valueSql = substr($valueSql, (strpos($valueSql, ",")+1));

        $biSql = "INSERT INTO bi_log_v2($fieldSql) VALUES ($valueSql)";
        $this->loger("biSql", $biSql);
        M()->execute($biSql);
    }

    private function convertGetParam($queryString){

        $retArray = [];
        $strArray = explode('&', $queryString);
        foreach($strArray as $item){

            $valueArray = explode('=', $item);
            $retArray[$valueArray[0]] = $valueArray[1];
        }

        return $retArray;
    }
}
