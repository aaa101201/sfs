<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/12
 * Time: 15:49
 */

namespace Admin\Dao;


class DesignerDao extends  BaseDao
{
    public function _initialize($db)
    {
        parent::_initialize($db);
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
    private function setWheretoo( $groupid,$attr_value_f,$attr_value_m,$city,$closed,$audit,$tenders_num)
    {
        $where = " WHERE 1=1 ";
        if (!empty($groupid) || !$groupid== null) {
            $where .= " and group_id = '" . $groupid . "'";
        }
//        if (!empty($attr_value_f) || !$attr_value_f == null) {
//            $where .= " AND
//                                  uid IN (
//	                          SELECT
//		                            uid
//	                          FROM
//		                            cy_designer_attr
//	                          WHERE
//		                             attr_id in (
//		               	     SELECT
//			                          attr_id
//			                   FROM
//				                       cy_data_attr_value
//			                   WHERE
//			              	         title = '" . $attr_value_f . "'
//		                         )
//	                          AND
//	                                  attr_value_id in (
//	                	         SELECT
//		                  	           attr_value_id
//		                       FROM
//			                             cy_data_attr_value
//		                       WHERE
//			                           title = '" . $attr_value_f . "'
//	                             ) )";}
//        if (!empty($attr_value_m) || !$attr_value_m == null) {
//            $where .= "  AND
//                          uid
//                      IN
//                          (
//	                  SELECT
//		                   uid
//                      FROM
//	                      cy_designer_attr
//	                  WHERE
//		                   attr_id in (
//			           SELECT
//			                attr_id
//			           FROM
//				             cy_data_attr_value
//			           WHERE
//				             title = '" . $attr_value_m . "')
//	                  AND
//	                       attr_value_id in (
//		              SELECT
//			                attr_value_id
//		              FROM
//			                cy_data_attr_value
//		              WHERE
//			               title = '" . $attr_value_m . "') )";}
        if (!empty($city) || !$city== null) {
            $where .= " and city_id = '" . $city . "'";
        }
            $where .= " and closed = '" . $closed . "'";
            $where .= " and audit = '" . $audit . "'";
        if ($tenders_num=='预约') {
            $where .= "order by yuyue_num desc";
        }
        return $where;
    }
    /**
     * @return mixed
     * 根据找设计师数据count 分页用
     */
    public function setDesignerConut($groupid,$attr_value_f,$attr_value_m,$city,$closed,$audit,$tenders_num)
    {
        $where = $this->setWheretoo($groupid,$attr_value_f,$attr_value_m,$city,$closed,$audit,$tenders_num);
        $querySql = "SELECT 
	                 count(*) AS pageTotal
                     FROM
	                cy_designer
                        $where";
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
    public  function  cy_designer_id($uid){
        $querySql =  "SELECT 
	                    *
                       FROM
	                     cy_designer
	                   WHERE 
	                     uid = '$uid'";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public function  cy_designer_yuyue1($city_id,$designer,$company_id,$mobile,$contact,$content,$status,$dateline,$clientip){
        $sql = "INSERT INTO cy_designer_yuyue (
                    city_id,
                    uid,
                    designer_id,
                    company_id,
                    mobile,
                    contact,
                    content,
                    status,
                    dateline,
                    clientip
                ) 
                VALUES
                  (
                    '$city_id',
                    '0',
                    '$designer',
                    '$company_id',
                    '$mobile',
                    '$contact',
                    '$content',
                    '$status',
                    '$dateline',
                    '$clientip'
                  )";
        return execResult($this->db->execute($sql));
    }
    public function  cy_designer_yuyue($city_id,$designer,$company_id,$mobile,$contact,$content,$status,$dateline,$clientip){
        $sql = "INSERT INTO cy_designer_yuyue (
                    city_id,
                    uid,
                    designer_id,
                    company_id,
                    mobile,
                    contact,
                    content,
                    status,
                    dateline,
                    clientip
                ) 
                VALUES
                  (
                    '$city_id',
                    '0',
                    '$designer',
                    '$company_id',
                    '$mobile',
                    '$contact',
                    '$content',
                    '$status',
                    '$dateline',
                    '$clientip'
                  )";
        return execResult($this->db->execute($sql));
    }
    public  function  cy_yuyue($designer,$yuyue_num){
        $querySql = "UPDATE 
                         cy_designer 
                      SET 
                          yuyue_num='$yuyue_num'  
                      WHERE 
                          uid=$designer";
        return  $this->db->execute($querySql);
    }
    public  function  cy_designer_yuyuecx($uid){
        $querySql = "SELECT 
	                 name
                     FROM
	                cy_designer
	                WHERE 
	                 uid='$uid'
	                  ";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public function Designer_h()
    {
        $querySql = "SELECT 
	                 *
                     FROM
	                cy_data_area
	                  ";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public function Designer_d()
    {
        $querySql = "SELECT 
	                 *
                     FROM
	                cy_data_attr_value
	                 WHERE
	                 attr_id='18'
	                ";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public function Designer_j()
    {
        $querySql = "SELECT 
	                 *
                     FROM
	                cy_data_attr_value
	                 WHERE
	                 attr_id='9'
	                ";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public function Designer_z()
    {
        $querySql = "SELECT 
	                 *
                     FROM
	                cy_data_attr_value
	                 WHERE
	                 attr_id='10'
	                ";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public function Designer_m()
    {
        $querySql = "SELECT 
	                 *
                     FROM
	                cy_data_attr_value
	                 WHERE
	                 attr_id='16'
	                ";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function  setCity_id($area_name){
        $querySql = "SELECT
	city_id
FROM
	cy_data_area
WHERE 
area_name='$area_name'
	                ";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function cy_Designer_a($uid){
        $querySql = "SELECT
                        a.NAME,
	                    a.attention_num,
	                    a.yuyue_num,
	                    a.case_num,
	                    a.blog_num,
	                    (
		              SELECT
			                 NAME
		              FROM
			                cy_company
		              WHERE
			              company_id = a.company_id
	                 ) gsname,
	                     a.mobile,
	                     a.slogan,
	                     a.about,
	                     b.photo alphoto ,
                      	a.photo,
                      	a.score,
	                     a.score1,
                       	a.score2,
	                   a.score3
                  FROM
	                 cy_designer a,
	                   cy_case b
                      WHERE 
	                   a.uid='$uid'
	               AND 
		               a.audit = '1'
		           AND 
		              a.closed = '0'
		              AND b.uid=a.uid
		               limit 0,1";
        $result = $this->db->query($querySql);
        return resultList($result);
    }

    public  function count($uid){
        $querySql = "SELECT
			             COUNT(*) COUNT
	           	     FROM
			             cy_designer a,
			             cy_case b
		             WHERE
		                 a.uid='$uid'
		              AND 
		                 a.uid = b.uid
		              AND 
		                 a.audit = '1'
		              AND 
		                 a.closed = '0'";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function cy_Designer_f($uid,$start,$pageSize){
        $querySql = " SELECT
uid,
	(
		SELECT
			NAME
		FROM
			cy_designer
		WHERE
			uid = b.uid
	) NAME,
	b.score1,
	b.score2,
	b.score3,
	from_unixtime(b.dateline, '%Y-%m-%d') dateline,
	b.content
FROM
	cy_designer_comment b
WHERE
	b.designer_id = '$uid'
		           LIMIT " . $start . "," . $pageSize;
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function setcy_Designer_f2($uid){
        $querySql = "SELECT
	                  count(*) AS pageTotal
                    FROM
	                	cy_designer_comment b
WHERE
	b.designer_id = '$uid'";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function setcy_Designer_f($uid){
        $querySql = "SELECT
                          face
                     FROM
	                      cy_member
	                 WHERE 
	                   uid='$uid'";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function cy_Designer_i($uname){
        $querySql = "SELECT
                          uid
                     FROM
	                      cy_member
	                 WHERE 
	                   uname='$uname'";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function cy_Designer_ii($createuname){
        $querySql = "SELECT
                          uid
                     FROM
	                      cy_member
	                 WHERE 
	                   uname='$createuname'";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public function  cy_Designer_k($city_id,$designer_id,$score1,$score2,$score3,$content,$dateline,$replyip,$clinetip,$uid){
        $sql = "INSERT INTO cy_designer_comment (
                    city_id,
                    uid,
                    designer_id,
                    score1,
                    score2,
                    score3,
                    content,
                    dateline,
                    replyip,
                    clientip,
                    replytime,
                    audit,
                    closed
                ) 
                VALUES
                  (
                    '$city_id',
                    '$uid',
                    '$designer_id',
                    '$score1',
                    '$score2',
                    '$score3',
                    '$content',
                    '$dateline',
                    '$replyip',
                    '$clinetip',
                    '0',
                    '1',
                    '0'
                  )";
        return execResult($this->db->execute($sql));
    }
    public  function cy_Designer_article($uid,$start,$pageSize){
        $querySql = "SELECT
                      article_id,
                          uid,
                          title,
                          from_unixtime(dateline, '%Y-%m-%d') dateline
                     FROM
	                      cy_designer_article
	                 WHERE 
	                   uid='$uid'
	                      LIMIT " . $start . "," . $pageSize;
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function setcy_Designer_article($uid){
        $querySql = "SELECT
	                  count(*) AS pageTotal
                    FROM
	                     cy_designer_article
	                 WHERE 
	                   uid='$uid'";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function cy_Designer_showinfo($uid){
        $querySql = "SELECT
                          uid,
                          title,
                          views,
                          from_unixtime(dateline, '%Y-%m-%d') dateline,
                         content
                     FROM
	                      cy_designer_article
	                 WHERE 
	                   article_id='$uid'";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function cy_Designer_showinfoa($uid){
        $querySql = "SELECT
                          uid,
                         title,
                         from_unixtime(dateline, '%Y-%m-%d') dateline
                     FROM
	                      cy_designer_article
	                 WHERE 
	                   uid='$uid'";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public function cy_Designer_attention_num($uid,$attention_num)
    {
        $querySql = "UPDATE 
                         cy_designer 
                      SET 
                         attention_num='$attention_num'
                      WHERE 
                          uid=$uid";
        return $this->db->execute($querySql);
    }
}