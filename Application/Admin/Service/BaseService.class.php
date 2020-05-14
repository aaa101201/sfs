<?php
// +----------------------------------------------------------------------
// | 基础业务CRUD方法范例
// +----------------------------------------------------------------------
// | Author: James.Yu <zhenzhouyu@jiechengkeji.cn>
// +----------------------------------------------------------------------

namespace Admin\Service;

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
// 获取主键ID
    public function getLastInsertId($db){
        $sql = "SELECT last_insert_id() AS id";
        $result = $db->query($sql);
        $this->loger('result', $result);
        return $result[0]['id'];
    }
 }