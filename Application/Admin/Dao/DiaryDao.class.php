<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/17
 * Time: 10:43
 */

namespace Admin\Dao;


class DiaryDao extends  BaseDao
{
    public function _initialize($db) {
        parent::_initialize($db);
    }
    public  function  setDiary_bb($start,$pageSize){
        $querySql = "SELECT
                           uid,
                          diary_id,
	                      home_name,
	                      content_num,
	                      views,
	                      comments,
	                      from_unixtime(dateline, '%Y-%m-%d') time,
	                      thumb,
	                      (
		              SELECT
			                 name
		               FROM
			               cy_company
		              WHERE
			                  company_id = cy_diary.company_id
	                   ) name
                   FROM
	                   cy_diary
                   WHERE 
                       audit = '1'
                   AND 
                       closed = '0'
                   LIMIT  $start,$pageSize" ;
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function  PageTotal_setDiary_bb(){
        $querySql = "SELECT
                     count(*) AS pageTotal
                   FROM
	                   cy_diary
                   WHERE 
                       audit = '1'
                   AND 
                       closed = '0'" ;
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function  setDiary_aa($start,$pageSize){
        $querySql = "SELECT
                           uid,
                          diary_id,
	                      home_name,
	                      content_num,
	                      views,
	                      comments,
	                      from_unixtime(dateline, '%Y-%m-%d') time,
	                      thumb,
	                      (
		              SELECT
			                 name
		               FROM
			               cy_company
		              WHERE
			                  company_id = cy_diary.company_id
	                   ) name
                   FROM
	                   cy_diary
                   WHERE 
                       audit = '1'
                   AND 
                       closed = '0'
                   LIMIT  $start,$pageSize" ;
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function  PageTotal_Diary_aa(){
        $querySql = "SELECT
                     count(*) AS pageTotal
                   FROM
	                   cy_diary
                   WHERE 
                       audit = '1'
                   AND 
                       closed = '0'" ;
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function  setDiary($start,$pageSize){
        $querySql = "SELECT
                           uid,
                          diary_id,
	                      home_name,
	                      content_num,
	                      views,
	                      comments,
	                      from_unixtime(dateline, '%Y-%m-%d') time,
	                      thumb,
	                      (
		              SELECT
			                 name
		               FROM
			               cy_company
		              WHERE
			                  company_id = cy_diary.company_id
	                   ) name
                   FROM
	                   cy_diary
                   WHERE 
                       audit = '1'
                   AND 
                       closed = '0'
                   LIMIT  $start,$pageSize" ;
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function  PageTotal_Company_cx(){
        $querySql = "SELECT
                     count(*) AS pageTotal
                   FROM
	                   cy_diary
                   WHERE 
                       audit = '1'
                   AND 
                       closed = '0'" ;
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
    public  function  Diary_b($diary_id){
        $querySql = "SELECT
	(
		CASE STATUS
		WHEN '1' THEN
			'开工大吉'
		WHEN '2' THEN
			'水电改造'
		WHEN '3' THEN
			'泥瓦工阶段'
		WHEN '4' THEN
			'木工阶段'
		WHEN '5' THEN
			'油漆阶段'
		WHEN '6' THEN
			'安装'
		WHEN '7' THEN
			'验收完成'
		ELSE
			''
		END
	) status,
  content,
  from_unixtime(dateline, '%Y-%m-%d') time
FROM
	 cy_diary_item
WHERE
    diary_id='$diary_id'";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function  Diary_a($diary_id){
        $querySql = "SELECT
                            uid,
	                        home_name,
	                        content_num,
	                        views,
	                        comments,
	                        from_unixtime(dateline, '%Y-%m-%d') time,
	                        thumb,
	                       (
	                	SELECT
			                 NAME
		                FROM
			         cy_company
		             WHERE
			             company_id = cy_diary.company_id
	                  ) NAME,
	                   (
		                SELECT
			               NAME
		             FROM
			cy_tenders_setting
		WHERE
			setting_id = cy_diary.way_id
	) way,
	(
		SELECT
			NAME
		FROM
			cy_tenders_setting
		WHERE
			setting_id = cy_diary.type_id
	) type,
	start_date,
	end_date,
	(
		CASE STATUS
		WHEN '1' THEN
			'开工大吉'
		WHEN '2' THEN
			'水电改造'
		WHEN '3' THEN
			'泥瓦工阶段'
		WHEN '4' THEN
			'木工阶段'
		WHEN '5' THEN
			'油漆阶段'
		WHEN '6' THEN
			'安装'
		WHEN '7' THEN
			'验收完成'
		ELSE
			''
		END
	) status
   FROM
	cy_diary
  WHERE
	audit = '1'
AND closed = '0'
AND  diary_id='$diary_id'" ;
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function  Diary_c($diary_id,$start,$pageSize){
        $querySql = "SELECT
   b.face,
	b.uname,
	a.content,
	from_unixtime(a.dateline, '%Y-%m-%d') time,
	(
		SELECT
			COUNT(*)
		FROM
			cy_member
		WHERE
			uid = a.uid
	) count
FROM
	cy_diary_comment a,
	cy_member b
WHERE
	a.uid = b.uid
	AND  a.diary_id='$diary_id'
	LIMIT  $start,$pageSize" ;
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function  PageTotal_Diary_c($diary_id){
        $querySql = "SELECT
                     count(*) AS pageTotal
                   FROM
	              	cy_diary_comment a,
         	cy_member b
    WHERE
	a.uid = b.uid
	AND  a.diary_id='$diary_id'" ;
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function  Diary_d($diary_id,$uid,$content,$dateline,$clinetip){
        $sql = "INSERT INTO cy_diary_comment
                (
                    city_id,
                    diary_id,
                    uid,
                    content,
                    audit,
                    clientip,
                    dateline
                )
                VALUES
                  (
                    '7',
                    '$diary_id',
                    '$uid',
                    '$content',
                    '1',
                    '$dateline',
                    '$clinetip'
                  )";
        return execResult($this->db->execute($sql));
    }
    public  function  Diary_h(){
        $querySql =  "		SELECT
				             title
			               FROM
			                	cy_data_attr_value
		                  WHERE
				               attr_id = '33'";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function  Diary_z(){
        $querySql =  "		SELECT
				             title
			               FROM
			                	cy_data_attr_value
		                  WHERE
				               attr_id = '33'";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function  Diary_j(){
        $querySql =  "	SELECT
				             title
			               FROM
			                	cy_data_attr_value
		                  WHERE
				               attr_id = '33'";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
}