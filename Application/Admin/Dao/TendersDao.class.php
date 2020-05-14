<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/28
 * Time: 11:42
 */

namespace Admin\Dao;


class TendersDao extends  BaseDao
{
    public function _initialize($db) {
        parent::_initialize($db);
    }
    public  function  getbudget($budget){
        $querySql = "SELECT 
	                 *
                     FROM
	                cy_tenders_setting
	                WHERE 
	                NAME ='$budget'" ;
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public function  setCity_id($city){
        $querySql = "SELECT
	                    *
                      FROM
	                cy_data_city
	                  WHERE  city_name='$city'
	                ";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public function  setUid($password){
        $querySql = "SELECT
	                    *
                      FROM
	                cy_member
	                  WHERE 
	                  uname='$password'
	                ";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function  setArea($area){
        $querySql = "SELECT
	                    *
                      FROM
	                cy_data_area
	                  WHERE  area_name='$area'
	                ";
        $result = $this->db->query($querySql);
        return resultList($result);
    }

    public  function  attr_value_id($attr_value_name){
        $querySql = "SELECT
	                    *
                      FROM
	                cy_data_attr_value
	                  WHERE  title='$attr_value_name'
	                ";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function  cy_trenders($attr_id,$attr_value_id){
        $sql = "INSERT INTO `cy_tenders_attr` (
	                      `attr_id`,
	                      `attr_value_id`
                                      )
                     VALUES
	                             (
		                    '$attr_id',
		                    '$attr_value_id'
	                          )";
        return execResult($this->db->execute($sql));
    }
    /**
     * 免费招标
     *
     */
    public  function  getZaoBiao($from,$username,$uid,$password,$budget,$homemj,$homemname,$city,$area,$addr,$comment,$ateline,$clientip,$type){
        $sql = "INSERT INTO `cy_tenders` (
	                               `from`,
	                               `zxb_id`,
	                               `city_id`,
	                               `area_id`,
	                               `uid`,
	                               `contact`,
	                               `mobile`,
	                               `home_id`,
	                               `home_name`,
	                               `way_id`,
	                               `type_id`,
	                               `style_id`,
	                               `budget_id`,
	                               `service_id`,
	                               `house_type_id`,
	                               `house_mj`,
	                               `huxing`,
	                               `addr`,
	                               `comment`,
	                               `zx_time`,
	                               `tx_time`,
	                               `gold`,
	                               `max_look`,
                               	   `looks`,
	                               `views`,
	                               `tracks`,
	                               `new_track`,
	                               `sign_uid`,
	                               `sign_from`,
	                               `sign_company_id`,
	                               `sign_info`,
	                               `sign_time`,
	                               `status`,
	                               `remark`,
	                               `audit`,
	                               `clientip`,
	                               `dateline`,
	                               `allow_looks`
                                     )
                              VALUES
	                                (
		                            '$from',
		                             0,
		                            '7',
		                            '3',
		                             '$uid',
		                           '$username',
	                        	   '$password',
		                             0,
		                           '$homemname',
		                             0,
		                             '$type',
		                             0,
		                            '$budget',
		                             0,
		                             0,
		                            '$homemj',
		                             '',
		                            '$addr',
		                            '$comment',
		                             0,
		                             0,
		                             0,
		                             3,
		                             0,
		                             0,
		                             0,
		                             0,
		                             0,
		                             'company',
		                              0,
		                              '',
		                              0,
		                              0,
	                                  '',
		                              0,
		                             '$clientip',
		                             '$ateline',
		                              NULL
	                                  )";
        return execResult($this->db->execute($sql));
    }
    public  function  cy_trenders_a(){
        $querySql = "SELECT
                   from_unixtime(a.dateline,'%Y-%m-%d')  dateline,
                     a.contact,
                     a.from,
                     a.house_mj,
                     a.budget_id
                    FROM
	                cy_tenders a
	                WHERE 
	                a.title!=''";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    // 获取主键ID
    public function getLastInsertId($db){
        $sql = "SELECT  last_insert_id()  AS  id";
        $result =$db->query($sql);
        $this->loger('result', $result);
        return $result[0]['id'];
    }
    public  function  budget_id($budget_id){
        $querySql = "SELECT
                     *
                      FROM
	                cy_tenders_setting
	                WHERE 
	                setting_id='$budget_id' 
	                ";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function  cy_trenders_b(){
        $querySql = "SELECT
                     name
                      FROM
	                cy_tenders_setting
	                WHERE 
	                  type='3' 
	                ";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function  cy_trenders_c(){
        $querySql = "SELECT
                     name
                      FROM
	                cy_tenders_setting
	                WHERE 
	                  type='1' 
	                ";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function  cy_trenders_d(){
        $querySql = "SELECT
                     title
                      FROM
	                cy_data_attr_value
	                WHERE 
	                  attr_id='13' 
	                ";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function  cy_trenders_e(){
        $querySql = "SELECT
                     name
                      FROM
	                cy_tenders_setting
	                WHERE 
	                  type='6' 
	                ";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function  cy_tenders_photo(){
        $querySql = "SELECT
                     *
                      FROM
	                cy_tenders_photo 
	                ";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function  Umember_designer_yuyue($uid){
        $querySql = "SELECT
                     contact,
                     mobile,
                     from_unixtime(dateline,'%Y-%m-%d')  dateline
                      FROM
	                cy_designer_yuyue 
	                WHERE 
	                 uid='$uid'
	                ";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
}