<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/29
 * Time: 9:44
 */

namespace Admin\Dao;


class GsDao  extends  BaseDao
{

    public function _initialize($db) {
        parent::_initialize($db);
    }
    public  function  setcom($company_id){
        $querySql = "SELECT
	                      case_id,
	                      photo
                     FROM
	                      cy_case a
                     WHERE
	                      company_id = '$company_id'
                     ORDER BY
	                      case_id DESC
                     LIMIT 0,4" ;
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public function  setgs(){
        $querySql = "SELECT 
	                  photo
                     FROM
	                  cy_index
	                 ORDER BY
                	  id 
                	 DESC" ;
        $result = $this->db->query($querySql);
        return resultList($result);
    }
public  function  sethot(){
       $querySql = "SELECT 
	                  *
                     FROM
	                cy_product
	                WHERE
	                  cat_id='375'" ;
    $result = $this->db->query($querySql);
    return resultList($result);
}
    public  function  setcompany($start,$pageSize){
        $querySql = "SELECT
	                    a.company_id,
	                    a.comments discuss,
                        a.score,
	                    a.case_num,
	                    a.tenders_num,
	                    a.yuyue_num,
	                    a. name,
	                    a.addr,
                     	a.logo,
	                    a.phone,
	                    a.photo,
	                     a.score,
	                    a.score1,
	                    (SELECT count(*)  FROM cy_company_comment WHERE company_id=a.company_id) commentTotal

                    FROM
	                    cy_company a
                   WHERE 
                       a.audit = '1'
                   AND 
                       a.closed = '0'
                   LIMIT  
	                  $start,$pageSize" ;
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function  setcom3(){
        $querySql = "SELECT
	                   phone,photo
                     FROM
	                   cy_tp  
	                 WHERE   
	                   type='3' 
	                 ORDER BY
	                   id 
	                 DESC " ;
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public function  cy_tophot(){
        $querySql = "SELECT
	                     *
                      FROM
	                    cy_tophot
	                  WHERE  
	                    tophot != ''
                      GROUP BY
	                    id DESC
                      LIMIT 0,
                        6" ;
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public function  cy_history(){
        $querySql = "SELECT
	                     *
                      FROM
	                    cy_history
	                    WHERE 
	                    tophistory != ''
                      GROUP BY
	                    id DESC
                      LIMIT 0,6" ;
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public function  cy_historyb($uname){
        $querySql = "SELECT
	                     *
                      FROM
	                    cy_history
	                    WHERE 
	                    tophistory != ''
	                    AND 
	                      photo='$uname'
                      GROUP BY
	                    id DESC
                      LIMIT 0,6" ;
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function  cy_historyss($name,$start,$pageSize){
        $querySql = "SELECT
                     a.company_id,
	                 a.comments discuss,
	                 a.case_num,
	                 a.tenders_num,
	                 a.yuyue_num,
	                 a. name,
                     a.addr,
                     a.logo,
                     a.phone,
                     a.score
                    FROM
	                    cy_company a
	                WHERE 
	                    name like '%$name%'
	                AND 
	                     a.audit = '1'
                    AND 
                       a.closed = '0'
                   LIMIT  $start,$pageSize" ;
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function  PageTotal_cy_historyss(){
        $querySql = "SELECT
                       count(*) AS pageTotal
                     FROM
	                   cy_company a
                     WHERE 
	                     a.audit = '1'
                     AND 
                       a.closed = '0'  " ;
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function  setcom2($uid){
        $querySql = "SELECT
	                    case_id,
                    	photo
                     FROM
	                    cy_case 
                     WHERE
                     	uid = '$uid'
                     ORDER BY
	                     case_id DESC
                     LIMIT 0,3" ;
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function  setmeeber($gift_phone){
        $querySql =  "SELECT 
	                 *
                     FROM
	                  cy_member
	                 WHERE 
	                   uname = '$gift_phone'";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function  cy_historyssa($name,$start,$pageSize){
        $querySql = "SELECT
	                  	uid,
	                    name,
	                    case_num,
	                    yuyue_num,
	                    mobile,
	                   (
		               CASE 1
		               WHEN '1' THEN
			           '设计师'
		               ELSE
			           '其他'
		               END
                      	) sjs
                      FROM
	                  cy_designer
	                  WHERE 
	                    name like  '%$name%'
	                  AND 
	                     audit = '1'
                      AND 
                         closed = '0'
                   LIMIT  $start,$pageSize";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function  PageTotal_cy_historyssa($name){
        $querySql = "SELECT
                     count(*) AS pageTotal
                    FROM
	                   cy_designer a
                    WHERE 
	                     a.audit = '1'
                    AND 
                       a.closed = '0'
                    AND 
                       a.name like  '%$name%'" ;
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function  cy_historyssb($name,$uname,$createtime,$updatetime){
        $sql = "INSERT INTO cy_history (
                  tophistory,
                  photo,
                  createtime,
                  updatetime
                ) 
                VALUES
                  (
                    '$name',
                    '$uname',
                    '$createtime',
                    '$updatetime'
                  )";
        return execResult($this->db->execute($sql));
    }
    public  function  sethot_a($name,$createtime,$updatetime){
        $sql = "INSERT INTO cy_tophot (
                  tophot,
                  createtime,
                  updatetime
                ) 
                VALUES
                  (
                    '$name',
                    '$createtime',
                    '$updatetime'
                  )";
        return execResult($this->db->execute($sql));
    }
    public  function  PageTotal_Company_cx(){
        $querySql = "SELECT
	                   	count(*) AS pageTotal
                     FROM
	                      cy_company  a" ;
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public function setFitmentList(  $groupid,$attr_value_f,$attr_value_m,$city,$closed,$audit,$tenders_num,$start,$pageSize)
    {
        $where = $this->setWhere($groupid,$attr_value_f,$attr_value_m,$tenders_num,$city,$closed,$audit);
        $querySql = "SELECT 
                     comments,
                     score,
	                 case_num,
	                 tenders_num,
	                 yuyue_num,
	                 name,
                     addr,
                     logo,
                     phone
                     FROM
	                cy_company 
                        $where
	                 LIMIT " . $start . "," . $pageSize;
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function  setTitle($gift_phone){
        $querySql =  "SELECT
	                    (
	              	 SELECT
			            title
		             FROM
			            cy_data_attr_value
		             WHERE
		              	attr_value_id = b.attr_value_id
	                    ) title
                     FROM
	                     cy_mechanic a,
	                     cy_mechanic_attr b
                     WHERE
	                       a.uid = b.uid 
	                 AND 
	                        a.mobile='$gift_phone'";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public function setDesignerList( $groupid,$attr_value_f,$attr_value_m,$city,$closed,$audit,$tenders_num,$start,$pageSize)
    {
        $where = $this->setWheretoo($groupid,$attr_value_f,$attr_value_m,$city,$closed,$audit,$tenders_num);
        $querySql = "SELECT 
	                  	uid,
	                    name,
	                    case_num,
	                    yuyue_num,
	                    mobile,
	                    (
		                CASE 1
		               WHEN '1' THEN
			           '设计师'
		                ELSE
			           '其他'
		               END
                         	) sjs
                       FROM
	                     cy_designer
                          $where
	                    LIMIT " . $start . "," . $pageSize;
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public function setMechanicList($groupid,$attr_value_f,$city,$closed,$audit,$tenders_num,$start,$pageSize)
    {
        $where = $this->setWheretree($groupid,$attr_value_f,$city,$closed,$audit,$tenders_num);
        $querySql =  "SELECT 
                       DISTINCT
	                    *,
	                   (
		               SELECT
			               area_name
	                   FROM
			               cy_data_area
		               WHERE
			              area_id = cy_mechanic.area_id
	                     )
	                   area_name,
	                    (
		               SELECT
			              city_name
		               FROM
			              cy_data_city
		               WHERE
			              city_id = cy_mechanic.city_id
	                      ) city
                       FROM
	                    cy_mechanic
                        $where
	                 LIMIT " . $start . "," . $pageSize;
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    /**
     * @return mixed
     * 根据找工人数据count 分页用
     */
    public function setMechanicConut($groupid,$attr_value_f,$city,$closed,$audit,$tenders_num)
    {
        $where = $this->setWheretree($groupid,$attr_value_f,$city,$closed,$audit,$tenders_num);
        $querySql =  "SELECT 
                        DISTINCT
	                    count(*) as pageTotal
                      FROM
	                   cy_mechanic
                        $where";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    /**
     * 头部图片
     */
    public  function   setAdvItem($advid){
         $querySql = "SELECT
	                        *
                      FROM
	                      cy_adv_item
                      WHERE
	                      adv_id = $advid";
        $result = $this->db->query($querySql);
        return resultList($result);

    }

    /**
     * 热门案例图片链接
     */
    public  function   setBlockItem($blockid){
        $querySql = "SELECT
	                    *
                     FROM
	                    cy_block_item
                    WHERE
	                    block_id = $blockid   LIMIT 0,4";
        $result = $this->db->query($querySql);
        return resultList($result);

    }
    private function setWheretree( $groupid,$attr_value_f,$city,$closed,$audit,$tenders_num)
    {
        $where = " WHERE 1=1 ";
        if ($tenders_num=='签单') {
            $where .= "order by tenders_num";
        }
        if ($tenders_num=='预约') {
            $where .= "order by yuyue_num";
        }
        if (!empty($groupid) || !$groupid==null) {
            $where .= " and group_id = '" . $groupid . "'";
        }
        if (!empty($attr_value_f) || !$attr_value_f == null) {
            $where .= "  and   
                         uid IN 
                         (
        	           SELECT
		                 uid
	                  FROM
		                  cy_mechanic_attr
	                  WHERE
		                  attr_id in
		                   (
			           SELECT
				              attr_id
			           FROM
				             cy_data_attr_value
			           WHERE
				             title = '" . $attr_value_f . "'
		                   )
	                 AND 
	                     attr_value_id in (
		              SELECT
			              attr_value_id
		              FROM
			              cy_data_attr_value
		              WHERE
		                 	title = '" . $attr_value_f . "')) ";}
        if (!empty($city) || !$city== null) {
            $where .= " and group_id = '" . $city . "'";
        }
        if (!empty($closed) || !$closed == null) {
            $where .= " and closed = '" . $closed . "'";
        }
        if (!empty($audit) || !$audit == null) {
            $where .= " and audit = '" . $audit . "'";
        }
        return $where;
    }
}