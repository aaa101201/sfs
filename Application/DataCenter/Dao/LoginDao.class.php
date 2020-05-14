<?php
/**
 * Created by PhpStorm.
 * User: jiechengkeji
 * Date: 2017/7/20
 * Time: 8:28
 */

namespace DataCenter\Dao;

use Enum\UserEnum;

class LoginDao extends BaseDao
{
    public function _initialize($db)
    {
        parent::_initialize($db);
    }

    /*
     * 获取手机登录账号密码
     */
    public function loginPhone($userName, $passWord)
    {
        $sql = "SELECT 
                   * 
                FROM admin_user 
                WHERE username = '%s' 
                AND password = '%s'
                AND STATUS =" . UserEnum::AD_STATUS_ACTIVE;
        $regs = array($userName, $passWord);
        $result = $this->db->query($sql,$regs);
        return result($result);
    }

}