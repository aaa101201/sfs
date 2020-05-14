<?php
// +----------------------------------------------------------------------
// | 基础业务CRUD方法范例
// +----------------------------------------------------------------------
// | Author: James.Yu <zhenzhouyu@jiechengkeji.cn>
// +----------------------------------------------------------------------

namespace Home\Service;

use Tools\XLog;
use Think\Think;

class BaseService {

    public static $xlog;

    public function __construct() {

    }

    protected function loger($title, $content) {
        self::$xlog = new XLog();
        self::$xlog->trackLog($title, $content);
    }

 }