<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/2
 * Time: 14:34
 */

namespace Admin\Dao;


class FileDao  extends  BaseDao
{
    public function _initialize($db) {
        parent::_initialize($db);
    }
    public function  setgs($localLicence,$createtime,$updatetime){
        $sql=" INSERT INTO `cy_index`
                    (
                     `photo`,
                     `createtime`,
                     `updatetime`
                     )
                      VALUES (
                      '$localLicence',
                      '$createtime',
                      '$updatetime'
                       )";
        $result=$this->db->execute($sql);
        return execResult($result);
    }
}