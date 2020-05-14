<?php
// +----------------------------------------------------------------------
// | 基础业务CRUD方法范例
// +----------------------------------------------------------------------
// | Author: James.Yu <zhenzhouyu@jiechengkeji.cn>
// +----------------------------------------------------------------------

namespace Home\Dao;

use Tools\XLog;

class BaseDao {

    protected $db = null;

    protected static $xlog;

    public function __construct($db = null) {

        $this->db = $db;

        self::$xlog = new XLog();
        self::$xlog->trackLog("__construct", "BaseDAO");
    }

    protected function loger($title, $content) {
        self::$xlog->trackLog($title, $content);
    }

    // 获取主键ID
    public function getLastInsertId($db){
        $sql = "SELECT  last_insert_id()  AS  id";
        $result =$db->query($sql);
        $this->loger('result', $result);
        return $result[0]['id'];
    }
 }