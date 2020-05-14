<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/12
 * Time: 10:46
 */

namespace Admin\Dao;


class CaseeDao extends  BaseDao
{
    public function _initialize($db) {
        parent::_initialize($db);
    }
    public function setCaseeList($groupid,$attr_value_f,$attr_value_m,$start,$pageSize)
    {
        $where = $this->setWhereF($groupid,$attr_value_f,$attr_value_m);
        $querySql =  "SELECT 
                         uid,
                         company_id,
                         case_id,
	                     title,
	                     photo,
	                     (SELECT count(*) FROM cy_case_photo WHERE case_id=cy_case.case_id) count
                      FROM
	                     cy_case
                         $where
	                  AND 
	                      city_id ='7'
                      AND 
                         closed = 0
                      AND 
                         audit = 1
	                 LIMIT " . $start . "," . $pageSize;
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    /**
     * @return mixed
     * 根据找工人数据count 分页用
     */
    public function setCaseeConut($groupid,$attr_value_f,$attr_value_m)
    {

        $where = $this->setWhereF($groupid,$attr_value_f,$attr_value_m);
        $querySql =  "SELECT 
	                    count(*) as pageTotal
                      FROM
	                       cy_case
                           $where
	                  AND 
	                       city_id ='7'
                      AND 
                           closed = 0
                      AND 
                            audit = 1;";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    /**
     * 设置检索条件
     */
    private function setWhereF( $groupid,$attr_value_f,$attr_value_m)
    {
        $where = " WHERE 1=1 ";
        if (!empty($groupid) || !$groupid== null) {
            $where .= "AND 
                         case_id
                          IN (
	                SELECT
		                   case_id
	                FROM
		                    cy_case_attr
	                WHERE
		                    attr_id in (
		            SELECT
				              attr_id
			         FROM
				              cy_data_attr_value
			         WHERE
				              title = '" . $groupid . "')
				                                    AND   	attr_value_id IN (
			SELECT
				attr_value_id
			FROM
				cy_data_attr_value
			WHERE
				title = '" . $groupid . "'
		)
			                   )";}
        if (!empty($attr_value_f) || !$attr_value_f == null) {
            $where .= "  AND 
                            case_id
                         IN 
                         (
	                     SELECT
		                     case_id
	                     FROM
		                      cy_case_attr
	                     WHERE
		                       attr_id in (
			              SELECT
				                attr_id
			              FROM
				                cy_data_attr_value
			              WHERE
				                 title = '" . $attr_value_f . "'
		                        )
		                        AND   	attr_value_id IN (
			SELECT
				attr_value_id
			FROM
				cy_data_attr_value
			WHERE
				title = '" . $attr_value_f . "'
		)
			                     )";}
        if (!empty($attr_value_m) || !$attr_value_m == null) {
            $where .= " AND 
                           case_id IN (
	                 SELECT
		                    case_id
	                  FROM
	                      	cy_case_attr
	                  WHERE
		                     attr_id in (
			           SELECT
				              attr_id
			           FROM
				              cy_data_attr_value
			           WHERE
				              title = '" . $attr_value_m . "')
				                                    AND   	attr_value_id IN (
			SELECT
				attr_value_id
			FROM
				cy_data_attr_value
			WHERE
				title = '" . $attr_value_m . "'
		)
			                  )";}
        return $where;
    }
    public  function  setCy_case($case_id){
        $querySql =  "SELECT
	                     attr_id,
                         attr_value_id
                     FROM
	                     cy_case a,
	                    cy_case_attr b
                     WHERE
	                    a.case_id = b.case_id
	                 AND
                         b.attr_id!='6'
                     AND
                       a.case_id='$case_id'";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function  setCy_caseA($case_id){
        $querySql =  "SELECT
                	    uid,
	                 company_id
                     FROM
	                     cy_case 
	                     WHERE 
                       case_id='$case_id'";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function  setCy_caseB($case_id){
        $querySql =  "SELECT
                		attr_id,
	                   attr_value_id
                     FROM
	                     cy_case_attr
	                     WHERE 
                       case_id='$case_id'";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function  setDesigner($uid){
        $querySql =  "SELECT
	                      name
                       FROM
	                      cy_designer
                       WHERE
                          uid='$uid'";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function  setCy_data_att($attr_value_id,$attr_id){
        $querySql =  "SELECT
			    	      title
			           FROM
				           cy_data_attr_value
                       WHERE
                           attr_value_id='$attr_value_id'
                           AND 
                           attr_id='$attr_id'";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function  setCy_data_attr($attr_value_id,$attr_id){
        $querySql =  "SELECT
			    	      title
			           FROM
				           cy_data_attr_value
                       WHERE
                           attr_value_id='$attr_value_id'
                           AND 
                           attr_id='$attr_id'";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function  setPhone($case_id){
        $querySql =  "SELECT
	                     COUNT(*) count
                      FROM
	                     cy_case_photo
                      WHERE
	                    case_id = '$case_id'";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function  Casee_h(){
        $querySql =  "	SELECT
				             title
			             FROM
			                	cy_data_attr_value
		                 WHERE
				               attr_id = '5'";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function  Casee_f(){
        $querySql =  "	  SELECT
				             title
			              FROM
			                	cy_data_attr_value
		                  WHERE
				               attr_id = '4'";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function  Casee_j(){
        $querySql =  "	  SELECT
				             title
			               FROM
			                	cy_data_attr_value
		                  WHERE
				               attr_id = '6'";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function  Casee_photo_a($uid){
        $querySql =  "	  SELECT
				               a.name,
				               b.face,
				               a.uid  designer_id
			               FROM
			                	cy_designer a,
			                	 cy_member b
			               WHERE 
			                a.uid=b.uid
			                AND 
			                	a.uid='$uid'
			                AND 
                                a.closed = 0
                            AND 
                                a.audit = 1";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function  Casee_photo_b($company_id){
        $querySql =  "	  SELECT
	     a.name,
		 b.face
FROM
	cy_company a, 
 cy_member b
 WHERE
 a.uid=b.uid
 AND 
			                	a.company_id='$company_id'
			                AND 
                                 a.closed = 0
                            AND 
                                 a.audit = 1";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function  Casee_photo_c($case_id){
        $querySql =  "	SELECT
	                         a.photo
                        FROM
	                         cy_case_photo  a
                        WHERE
                              a.case_id='$case_id'
                     ";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function cy_compay_uid($uname){
        $querySql = "SELECT
	                      uid
                     FROM
	                      cy_member 
                     WHERE
                      uname = '$uname'";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function  Casee_pl($case_id,$start,$pageSize){
        $querySql =  "SELECT
                         	b.uname,
	                        a.content,
	                        from_unixtime(a.dateline, '%Y-%m-%d') time,
	                         b.face
                       FROM
	                         cy_case_comment a,
	                         cy_member b
                       WHERE
	                         a.uid = b.uid
                       AND 
                              a.case_id='$case_id'
                               LIMIT " . $start . "," . $pageSize;
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public function setCasee_pl($case_id)
    {
        $querySql =  "SELECT
                         count(*) as pageTotal
                       FROM
	                         cy_case_comment a,
	                         cy_member b
                       WHERE
	                         a.uid = b.uid
                       AND 
                              a.case_id='$case_id'";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function Casee_phh($uid,$start,$pageSize){
        $querySql = "SELECT
    b.case_id,
    b.views,
	b.title,
	b.likes,
	b.photo
FROM
	cy_case b
WHERE
	b.uid = '$uid'
AND b.audit = '1'
AND b.closed = '0'
    LIMIT " . $start . "," . $pageSize;
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function Casee_phha($company_id,$start,$pageSize){
        $querySql = "
	SELECT
	  b.case_id,
		b.title,
		b.views,
		b.likes,
		b.photo
	FROM
		cy_case b
	WHERE
		b.company_id = '$company_id'
	AND b.audit = '1'
	AND b.closed = '0'
    LIMIT " . $start . "," . $pageSize;
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    /**
     * @return mixed
     * 根据找工人数据count 分页用
     */
    public function setCaseeConutCasee_ph($uid)
    {
        $querySql =  "
SELECT
  count(*) as pageTotal
FROM
	cy_case b
WHERE
	b.uid = '$uid'
AND b.audit = '1'
AND b.closed = '0'";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public function setCaseeConutCasee_phh($company_id)
    {
        $querySql =  "
	SELECT
    count(*) as pageTotal
	FROM
		cy_case b
	WHERE
		b.company_id = '$company_id'
	AND b.audit = '1'
	AND b.closed = '0'";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function  Casee_plc($case_id,$uid,$content,$dateline,$clinetip){
        $sql = "INSERT INTO cy_case_comment 
                (
                    city_id,
                    case_id,
                    uid,
                    content,
                    audit,
                    clientip,
                    dateline
                ) 
                VALUES
                  (
                    '7',
                    '$case_id',
                    '$uid',
                    '$content',
                    '1',
                    '$dateline',
                    '$clinetip'
                  )";
        return execResult($this->db->execute($sql));
    }
}