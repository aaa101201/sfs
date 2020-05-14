<?php
/**
 * Created by PhpStorm.
 * User: jiechengkeji
 * Date: 2017/7/20
 * Time: 10:59
 */

namespace DataCenter\Dao;


class ShowDao extends BaseDao
{
    public function _initialize()
    {
        parent::_initialize();
    }

    /*
     * 根据交易时间和交易类型检索用户信息和交易数据
     */
    public function showPhone($showTimeStart, $showTimeEnd, $searchType, $page = 1, $pageSize = 10, $sessionId)
    {
        $where = $this->setWhere($showTimeStart, $showTimeEnd, $searchType, $sessionId);
        $sql = "SELECT 
                 cu.shopId,
                 cu.realname,
                 ce.type,
                 ce.createTime,
                 FORMAT(ce.amount/100,2) AS amount
               FROM
                 c_exchage ce 
               LEFT JOIN c_user cu ON ce.userId = cu.id 
               LEFT JOIN admin_user au ON cu.shopId = au.shopId
           $where 
           ORDER BY ce.createTime DESC
           limit " . ($page - 1) * $pageSize . "," . $pageSize;
        $result = $this->db->query($sql);
        return resultList($result);
    }

    /*
     * 根据交易类型来查询交易的数量
     *
     */
    public function showPhoneCount($showTimeStart, $showTimeEnd, $searchType, $sessionId)
    {
        $where = $this->setWhere($showTimeStart, $showTimeEnd, $searchType, $sessionId);
        $sql = "SELECT 
                COUNT(*) AS total
              FROM
                c_exchage ce 
              LEFT JOIN c_user cu ON ce.userId = cu.id 
              LEFT JOIN admin_user au ON cu.shopId = au.shopId
           $where";
        $result = $this->db->query($sql);
        return $result[0]["total"];
    }

    /*
     * 设置检索条件
     */
    private function setWhere($showTimeStart, $showTimeEnd, $searchType, $sessionId)
    {
        $this->loger('session', $sessionId);
        $where = "where 1=1";
        //消费类型
        if (strlen($searchType) > 0) {
            $where .= " AND ce.type = '" . $searchType . "'";
        } else {
            $where .= " AND ce.type in (0,1) ";
        }
        //根据id分不同的商家
        if (!empty($sessionId)) {
            $where .= " AND au.shopId= '" . $sessionId . "'";
        }
        // 时间区间
        if (!empty($showTimeStart) && empty($showTimeEnd)) {
            $where .= " AND  ce.createTime >= '" . $showTimeStart . " 00:00:00" . "' ";
        }
        if (!empty($showTimeEnd) && empty($showTimeStart)) {
            $where .= " AND ce.createTime <= '" . $showTimeEnd . " 23:59:59" . "'";
        }
        if (!empty($showTimeStart) && !empty($showTimeEnd)) {
            $where .= " AND  ce.createTime BETWEEN '" . $showTimeStart . " 00:00:00" . "' AND '" . $showTimeEnd . " 23:59:59" . "' ";
        }
        return $where;
    }

}