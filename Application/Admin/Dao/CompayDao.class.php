<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/12
 * Time: 15:10
 */

namespace Admin\Dao;


class CompayDao  extends  BaseDao
{
    public function _initialize($db) {
        parent::_initialize($db);
    }
    public function setFitmentList( $groupid,$attr_value_f,$attr_value_m,$city,$closed,$audit,$tenders_num,$start,$pageSize)
    {
        $where = $this->setWhere($groupid,$attr_value_f,$attr_value_m,$city,$closed,$audit,$tenders_num);
        $querySql = "SELECT 
                     company_id,
                     comments,
                     score,
                     score1,
	                 case_num,
	                 tenders_num,
	                 yuyue_num,
	                 name,
                     addr,
                     logo,
                     phone,
                     	(SELECT count(*)  FROM cy_company_comment WHERE company_id=cy_company.company_id) commentTotal
                     FROM
	                cy_company 
                        $where
	                 LIMIT " . $start . "," . $pageSize;
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    /**
     * 设置检索条件
     */
    private function setWhere($groupid,$attr_value_f,$attr_value_m,$city,$closed,$audit,$tenders_num)
    {
        $where = " WHERE 1=1 ";
        if (!empty($groupid) || !$groupid== null) {
            $where .= " and group_id = '" . $groupid . "'";
        }
        if (!empty($attr_value_f) || !$attr_value_f == null) {
            $where .= "  AND
                          company_id 
                          IN 
                          (
	                  SELECT
		                    company_id
	                  FROM
		                    cy_company_attr
	                  WHERE
		                    attr_id in (
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
		                    	title = '" . $attr_value_f . "'))";}
        if (!empty($attr_value_m) || !$attr_value_m == null) {
            $where .= " AND 
                        company_id 
                         IN (
	                 SELECT
		                  company_id
	                 FROM
		                   cy_company_attr
	                 WHERE
		                   attr_id in (
			          SELECT
				             attr_id
			          FROM
				             cy_data_attr_value
			          WHERE
				              title = '" . $attr_value_m . "'
	                  	)
	                 AND 
	                       attr_value_id in (
		              SELECT
			                 attr_value_id
		              FROM
			                 cy_data_attr_value
		              WHERE
		                  	title = '" . $attr_value_m . "'))";}
        if (!empty($city) || !$city== null) {
            $where .= " and city_id = '" . $city . "'";
        }
            $where .= " and closed = '" . $closed . "'";
            $where .= " and audit = '" . $audit . "'";
        if ($tenders_num=='口碑') {
            $where .= "order by score desc";
        }
        if ($tenders_num=='签单') {
            $where .= "order by tenders_num desc";
        }
        return $where;
    }
    public function  setCity_id($area_name){
        $querySql = "SELECT
	                    *
                      FROM
	                cy_data_area
	                  WHERE  area_name='$area_name'
	                ";
        $result = $this->db->query($querySql);
        return resultList($result);
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
    /**
     * @return mixed
     * 根据找装修公司数据count 分页用
     */
    public function setFitmentConut($groupid,$attr_value_f,$attr_value_m,$city,$closed,$audit,$tenders_num)
    {
        $where = $this->setWhere($groupid,$attr_value_f,$attr_value_m,$tenders_num,$city,$closed,$audit);
        $querySql = "SELECT 
	                  count(*) AS pageTotal
                     FROM
	                cy_company
                        $where";
        $result = $this->db->query($querySql);
        return  resultList($result);
    }
    public function setFitment_h()
    {
        $querySql = "SELECT 
	                area_name
                     FROM
	                cy_data_area
	                  ";
        $result = $this->db->query($querySql);
        return resultList($result);
    }

    public function setFitment_d()
    {
        $querySql = "SELECT 
	                title
                     FROM
	                cy_data_attr_value
	                 WHERE
	                 attr_id='15'";
        $result = $this->db->query($querySql);
        return resultList($result);
    }

    public function setFitment_f()
    {
        $querySql = "SELECT 
	                 title
                     FROM
	                cy_data_attr_value
	                 WHERE
	                 attr_id='1'
	                ";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public function setFitment_g()
    {
        $querySql = "SELECT 
	                 title
                     FROM
	                cy_data_attr_value
	                 WHERE
	                 attr_id='3'
	                ";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public function setFitment_m()
    {
        $querySql = "SELECT 
	                 title
                     FROM
	                cy_data_attr_value
	                 WHERE
	                 attr_id='16'";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public function cy_compay_h($company_id)
    {
        $querySql = "SELECT
            title,
			photo,
			views
	              	FROM
			cy_case
	                 WHERE

			company_id = '$company_id'";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function cy_compay_b($company_id){
        $querySql = "SELECT
	a.`name`,
	a.tenders_num,
	a.case_num,
	a.yuyue_num,
	a.thumb,
	a.photo,
	(
		SELECT
			photo
		FROM
			cy_case
		WHERE
			company_id = a.company_id
		LIMIT 0,
		1
	) photoo,
	(
		SELECT
			info
		FROM
			cy_company_fields
		WHERE
			company_id = a.company_id
		LIMIT 0,
		1
	) info,
	a.addr,
	a.comments,
	a.score,
	a.score1,
	a.score2,
	a.score3,
	(SELECT count(*)  FROM cy_company_comment WHERE company_id=a.company_id) count
FROM
	cy_company a
WHERE
	a.audit = '1'
AND a.closed = '0'
AND a.company_id = '$company_id'";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function count($company_id){
        $querySql = "SELECT
			             COUNT(*) COUNT
	           	     FROM
			             cy_case a
		             WHERE
		                 a.company_id='$company_id'
		              AND 
		                 a.audit = '1'
		              AND 
		                 a.closed = '0'";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function  setcompany($compay_id){
        $querySql = "SELECT
	                    a.company_id,
	                    a.comments,
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
	                    (SELECT count(*)  FROM cy_company_comment WHERE company_id=a.company_id) commentTotal

                    FROM
	                    cy_company a
                   WHERE 
                     a.company_id='$compay_id'" ;
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public function  cy_compay_kk($compay_id,$comments){
        $querySql = "UPDATE 
                         cy_company 
                      SET 
                          comments = '$comments'
                      WHERE 
                          company_id=$compay_id";
        return $this->db->execute($querySql);
    }
    public function  cy_compay_k($city_id,$compay_id,$score1,$score2,$score3,$score4,$score5,$content,$dateline,$replyip,$clinetip,$uid){
        $sql = "INSERT INTO cy_company_comment (
                    city_id,
                    uid,
                    company_id,
                    score1,
                    score2,
                    score3,
                    score4,
                    score5,
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
                    '$compay_id',
                    '$score1',
                    '$score2',
                    '$score3',
                    '$score4',
                    '$score5',
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
    public  function cy_compay_yuyuecx($company_id){
        $querySql = "SELECT
	                      name
                     FROM
	                      cy_company 
                     WHERE
                      company_id = '$company_id'";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function cy_compay_c($company_id){
        $querySql = "SELECT
	                      a.name,
                          b.face
                     FROM
	                      cy_designer a,
	                      cy_member b
                     WHERE
	                      a.uid = b.uid
                     AND a.company_id = '$company_id'
                     AND a.audit = '1'
                     AND a.closed = '0'";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function cy_compay_f($company_id,$start,$pageSize){
        $querySql = "SELECT
	                    b.uid,
	                    b.company_id,
	                    a.`name`,
	                    b.score1,
	                    b.score2,
	                    b.score3,
	                    b.score4,
	                    b.score5,
	                    from_unixtime(b.dateline, '%Y-%m-%d') dateline,
                        b.content,
                      (SELECT COUNT(*) FROM cy_company_comment ) conut
                    FROM
	                    cy_company a,
	                    cy_company_comment b
                    WHERE  a.company_id=b.company_id
                     AND  a.company_id='$company_id'
                     LIMIT " . $start . "," . $pageSize;
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function setcy_compay_v($company_id){
        $querySql = "SELECT
	                  count(*) AS pageTotal
                    FROM
	                    cy_company a,
	                    cy_company_comment b
                    WHERE  a.company_id=b.company_id
                     AND  a.company_id='$company_id'";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function setCy_compay_f($uid){
        $querySql = "SELECT
                          uname,
                          face
                     FROM
	                      cy_member
	                 WHERE 
	                   uid='$uid'";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function cy_compay_i($uname){
        $querySql = "SELECT
                          uid
                     FROM
	                      cy_member
	                 WHERE 
	                   uname='$uname'";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public function  cy_compay_yuyue($city_id,$uid,$company_id,$contact,$mobile,$status,$dateline,$clientip){
        $sql = "INSERT INTO cy_compay_yuyue (
                    city_id,
                    uid,
                    company_id,
                    contact,
                    mobile,
                    content,
                    status,
                    clientip
                ) 
                VALUES
                  (
                    '$city_id',
                    '$uid',
                    '$company_id',
                    '$contact',
                    '$mobile',
                    '预约装修',
                    '$status',
                    '$clientip'
                  )";
        return execResult($this->db->execute($sql));
    }
}