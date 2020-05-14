<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/4
 * Time: 14:42
 */

namespace Admin\Dao;


class FilterDao  extends  BaseDao
{
    public function _initialize($db)
    {
        parent::_initialize($db);
    }
    public function Mechanic_h()
    {
        $querySql = "SELECT 
	                 *
                     FROM
	                cy_data_area
	                  ";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public function Mechanic_d()
    {
        $querySql = "SELECT 
	                 *
                     FROM
	                cy_data_attr_value
	                 WHERE
	                 attr_id='19'
	                ";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public function Mechanic_g()
    {
        $querySql = "SELECT 
	                 *
                     FROM
	                cy_data_attr_value
	                 WHERE
	                 attr_id='11'
	                ";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public function Mechanic_m()
    {
        $querySql = "SELECT 
	                 *
                     FROM
	                cy_data_attr_value
	                 WHERE
	                 attr_id='17'
	                ";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
}