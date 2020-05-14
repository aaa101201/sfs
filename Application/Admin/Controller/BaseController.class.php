<?php
namespace Admin\Controller;

use Think\Controller;
use Tools\XLog;

class BaseController extends Controller
{

    CONST SYSTEM_SECRET = "Stock";

    public function _initialize() {
        XLog::trackLog("_initialize", "BaseController");
        $action_module = array("Admin\\Behavior\\SystemLogBehavior");
        \Think\Hook::add("action_module", $action_module);
    }

    /**
     * @param $content
     * 数组形式记录日志
     * input 输入参数 数组形式
     */
    protected function loger_array($content) {
        // 写入文件log
        foreach ($content["input"] as $key => $value) {
            XLog::trackLog($key, $value);
        }
    }

    protected function loger($title, $content) {
        XLog::trackLog($title, $content);
    }

    /**
     * @param $content
     * 数组中一共有四个key
     * input 输入参数 数组形式
     * path 请求地址
     * operaName 方法文字说明
     * output 方法的输出参数 数组形式
     */
    protected function systemLog($content) {

        if (is_array($content["input"])){
            // 写入文件log
            foreach ($content["input"] as $key => $value) {
                XLog::trackLog($key, $value);
            }
        }

        // 写入数据库log
        \Think\Hook::listen("action_module", $content);
    }
}