<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/19
 * Time: 9:48
 */

namespace Admin\Dao;


class UmemberDao extends BaseDao
{
    public function _initialize($db)
    {
        parent::_initialize($db);
    }

    public function Umember_company_a($createuname)
    {
        $querySql = "SELECT
                           a.uid,
	                       a.uname,
	                       a.gold,
                           a.face,
	                   (
		             CASE a.FROM
		            WHEN 'member' THEN
			             '家装助手会员'
		            WHEN 'designer' THEN
			             '家装助手设计师'
		            WHEN 'company' THEN
			             '家装助手装修公司'
		            WHEN 'shop' THEN
			            '家装助手建材商家'
		            WHEN 'mechanic' THEN
			            '家装助手装修工人'
		            END
	                    )  name
                    FROM
	                    cy_member a
	                WHERE 
	                     uname='$createuname'
	                ";
        $result = $this->db->query($querySql);
        return result($result);
    }

    public function Umember_company($uname)
    {
        $querySql = "SELECT
                         a.uid,
	                     a.uname,
	                     a.gold,
                         a.face,
	                    (
		             CASE a.FROM
		             WHEN 'member' THEN
			             '家装助手会员'
		             WHEN 'designer' THEN
			             '家装助手设计师'
	                 WHEN 'company' THEN
			             '家装助手装修公司'
		             WHEN 'shop' THEN
		             	 '家装助手建材商家'
		             WHEN 'mechanic' THEN
			              '家装助手装修工人'
		             END
	                     )  name,
	                    b.company_id
                    FROM
	                  cy_member a,
                      cy_company b
	                WHERE 
	                  a.uid=b.uid
	                AND 
	                  uname='$uname'
	   ";
        $result = $this->db->query($querySql);
        return result($result);
    }

    public function Umember($createuname)
    {
        $querySql = "SELECT
     a.uid,
	a.uname,
    a.face,
	(
		CASE a.FROM

		WHEN 'member' THEN
			'家装助手会员'
		WHEN 'designer' THEN
			'家装助手设计师'
		WHEN 'company' THEN
			'家装助手装修公司'
		WHEN 'shop' THEN
			'家装助手建材商家'
		WHEN 'mechanic' THEN
			'家装助手装修工人'
		END
	)  name
    FROM
	cy_member a
	WHERE 
	   uname='$createuname';";
        $result = $this->db->query($querySql);
        return result($result);
    }

    public function Umember_b($uname)
    {
        $querySql = "SELECT
    a.uid,
	a.uname,
    a.face,
	(
		CASE a.FROM

		WHEN 'member' THEN
			'家装助手会员'
		WHEN 'designer' THEN
			'家装助手设计师'
		WHEN 'company' THEN
			'家装助手装修公司'
		WHEN 'shop' THEN
			'家装助手建材商家'
		WHEN 'mechanic' THEN
			'家装助手装修工人'
		END
	)  name
    FROM
	cy_member a
	WHERE 
	   a.uname='$uname'
	   ";
        $result = $this->db->query($querySql);
        return result($result);
    }

    public function Umember_designer($uname)
    {
        $querySql = "SELECT
   a.uid,
	a.uname,
    a.face,
	(
		CASE a.FROM

		WHEN 'member' THEN
			'家装助手会员'
		WHEN 'designer' THEN
			'家装助手设计师'
		WHEN 'company' THEN
			'家装助手装修公司'
		WHEN 'shop' THEN
			'家装助手建材商家'
		WHEN 'mechanic' THEN
			'家装助手装修工人'
		END
	)  name,
    b.yuyue_num,
    b.blog_num
    FROM
	cy_member a,
    cy_designer b
 WHERE  a.uid=b.uid
      AND 
	   a.uname='$uname'
	   ";
        $result = $this->db->query($querySql);
        return result($result);
    }

    public function Umember_designer_a($createuname)
    {
        $querySql = "SELECT
    a.uid,
	a.uname,
    a.face,
	(
		CASE a.FROM

		WHEN 'member' THEN
			'家装助手会员'
		WHEN 'designer' THEN
			'家装助手设计师'
		WHEN 'company' THEN
			'家装助手装修公司'
		WHEN 'shop' THEN
			'家装助手建材商家'
		WHEN 'mechanic' THEN
			'家装助手装修工人'
		END
	)  name,
b.yuyue_num
    FROM
	cy_member a,
    cy_designer b
 WHERE  a.uid=b.uid
      AND 
	   a.uname='$createuname'
	   ";
        $result = $this->db->query($querySql);
        return result($result);
    }

    public function uname_c($uid)
    {
        $querySql = "SELECT
                     *
                      FROM
	                      cy_diary 
                     WHERE 
                         uid='$uid'";
        $result = $this->db->query($querySql);
        return result($result);
    }

    public function uidd($mobile)
    {
        $querySql = "SELECT
                     *
                      FROM
	                      cy_member 
                     WHERE 
                         uname='$mobile'";
        $result = $this->db->query($querySql);
        return result($result);
    }
    public function setUmember_rzd($uid)
    {
        $querySql = "SELECT
                     *
                      FROM
	                      cy_member_verify
                     WHERE
                         uid='$uid'";
        $result = $this->db->query($querySql);
        return result($result);
    }
    public function uiddd($uname)
    {
        $querySql = "SELECT
                     uid
                      FROM
	                      cy_member 
                     WHERE 
                         uname='$uname'
                         ";
        $result = $this->db->query($querySql);
        return result($result);
    }
    public function uidddd($uid)
    {
        $querySql = "SELECT
                     uid
                      FROM
	                      cy_designer 
                     WHERE 
                         uid='$uid'";
        $result = $this->db->query($querySql);
        return result($result);
    }
    public function uidddc($uname)
    {
        $querySql = "SELECT
                     b.company_id
                      FROM
	                      cy_member a,
	                      cy_company b
                     WHERE 
                     a.uid=b.uid
                     AND 
                         a.uname='$uname'";
        $result = $this->db->query($querySql);
        return result($result);
    }
    public function uidddcd($uname)
    {
        $querySql = "SELECT
                     b.area_id
                      FROM
	                      cy_company b
                     WHERE 
                         b.uname='$uname'";
        $result = $this->db->query($querySql);
        return result($result);
    }
    public function setUmember_rz($uid, $mobile, $name, $id_number, $id_photo, $request_time, $verify_time)
    {
        $sql = "INSERT INTO cy_member_verify (
                  uid,
                  id_photo,
                  mobile,
                  name,
                  id_number,
                  verify,
                  request_time,
                  verify_time                ) 
                VALUES
                  (
                    '$uid',
                    '$id_photo',
                    '$mobile',
                    '$name',
                    '$id_number',
                     '1',
                    '$request_time',
                    '$verify_time'                  )";
        return execResult($this->db->execute($sql));
    }

    public function company($company)
    {
        $querySql = "SELECT
                     *
                      FROM
	                      cy_company
                     WHERE 
                         name='$company'";
        $result = $this->db->query($querySql);
        return result($result);
    }

    public function home_name($home_name)
    {
        $querySql = "SELECT
                     *
                      FROM
	                      cy_home
                     WHERE 
                         name='$home_name'";
        $result = $this->db->query($querySql);
        return result($result);
    }

    public function type($type)
    {
        $querySql = "SELECT
	                  *
                    FROM
	                     cy_tenders_setting
                   WHERE
	                      name = '$type'";
        $result = $this->db->query($querySql);
        return result($result);
    }
    public function Umember_rjcx($diary_id)
    {
        $querySql = "SELECT
	                  a.diary_id,a.title,a.home_name,a.company_id,a.total_price,a.start_date,a.end_date,a.type_id,
               a.way_id,a.thumb
                    FROM
	                     cy_diary a
                   WHERE
	                      a.diary_id = '$diary_id'";
        $result = $this->db->query($querySql);
        return result($result);
    }
    public function Umember_up($diary_id,$uid,$title,$home_name,$company,$home_id,$type_id,$way_id,$total_price,$start_date,$end_date,$dateline,$clientip,$localLicence)
    {
        $querySql = "UPDATE 
                         cy_diary 
                      SET 
                            uid = '$uid',
                          title = '$title',
                          home_name = '$home_name',
                          company_id = '$company',
                          home_id = '$home_id',
                          type_id = '$type_id',
                          way_id = '$way_id',
                          total_price = '$total_price',
                          start_date = '$start_date',
                          end_date = '$end_date',
                          dateline = '$dateline',
                          clientip = '$clientip',
                          thumb = '$localLicence'
                      WHERE 
                          diary_id=$diary_id";
        return $this->db->execute($querySql);
    }

    public function Diary_s($uid, $title, $home_name, $company, $home_id, $type_id, $way_id, $total_price, $start_date, $end_date, $dateline, $clientip, $localLicence)
    {
        $sql = "INSERT INTO cy_diary (
                  uid,
                  title,
                  home_name,
                  company_id,
                  home_id,
                  type_id,
                  way_id,
                  total_price,
                  start_date,
                  end_date,
                  dateline,
                  clientip,
                  city_id,
                  content_num,
                   views,
                   comments,
                    status,
                   audit,
                   closed,
                   thumb
                ) 
                VALUES
                  (
                    '$uid',
                    '$title',
                    '$home_name',
                    '$company',
                    '$home_id',
                     '$type_id',
                    '$way_id',
                    '$total_price',
                    '$start_date',
                    '$end_date',
                    '$dateline',
                    '$clientip',
                    '7',
                    '0',
                    '0',
                    '0',
                    '1',
                    '1',
                    '0',
                    '$localLicence'
                  )";
        return execResult($this->db->execute($sql));
    }
    public function Umember_yy($uid,$start,$pageSize)
    {
        $querySql = "SELECT
    diary_id,
	title,
	home_name name,
	(
		CASE status
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
	(
		CASE audit
		WHEN '0' THEN
			'待审核'
		WHEN '1' THEN
			'通过'
		ELSE
			''
		END
	) audit,
	from_unixtime(dateline, '%Y-%m-%d') time 
FROM
	cy_diary 
	         WHERE 
            uid='$uid'
            AND 
		audit = '1'
AND
      closed = '0'
        LIMIT " . $start . "," . $pageSize;
        $result = $this->db->query($querySql);
        return result($result);
    }


    public  function setUmember_y($uid){
        $querySql = "SELECT
	                  count(*) AS pageTotal
                    FROM
	 	cy_diary a
                             WHERE
	    
            a.uid='$uid'
            AND 
		a.audit = '1'
AND
      a.closed = '0'";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function setcy_compay_v(){
        $querySql = "SELECT
	                  count(*) AS pageTotal
                    FROM
	                 	cy_diary a,
	cy_diary_item b
WHERE
	a.diary_id = b.diary_id
	AND 
		a.audit = '1'
AND
      a.closed = '0'";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public function Umember_delete($diary_id)
    {
        $querySql = "UPDATE 
                         cy_diary 
                      SET 
                          audit = '0'
                      WHERE 
                          diary_id=$diary_id";
        return $this->db->execute($querySql);
    }

    public function Umember_deletee($diary_id)
    {
        $querySql = "UPDATE 
                         cy_diary 
                      SET 
                          audit = '0'
                      WHERE 
                          diary_id=$diary_id";
        return $this->db->execute($querySql);
    }

    public function Umember_wzd($item_id)
    {
        $sql = "DELETE 
                    FROM 
                    cy_diary_item
                  WHERE  
                  item_id = '$item_id'";
        return execResult($this->db->execute($sql));
    }

    public function Umember_wz($diary_id,$start,$pageSize)
    {
        $querySql = "SELECT
                           a.diary_id,
                           b.item_id,
	                       a.title,
	                        (
	        	          CASE b.status
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
                             b.content,
	                         from_unixtime(a.dateline, '%Y-%m-%d') time 
                             FROM
	                              cy_diary a,
	                              cy_diary_item b
                             WHERE
	                                 a.diary_id = b.diary_id
	                          AND  
                                     a.diary_id = '$diary_id'
                         LIMIT " . $start . "," . $pageSize;
        $result = $this->db->query($querySql);
        return result($result);
    }
    public  function setUmember_wz($diary_id){
        $querySql = "SELECT
	                    count(*) AS pageTotal
                     FROM
	                          cy_diary a,
	                           cy_diary_item b
                             WHERE
	                                 a.diary_id = b.diary_id
	                          AND  
                                     a.diary_id = '$diary_id'";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public function Umember_wzjd()
    {
        $querySql = "SELECT
	*
FROM
	cy_data_attr_value
WHERE
	attr_id = '20'";
        $result = $this->db->query($querySql);
        return result($result);
    }
    public function Umember_xgcx($item_id)
    {
        $querySql = "SELECT
	 (
	        	          CASE status
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
	                         (SELECT title FROM  cy_diary WHERE diary_id=cy_diary_item.diary_id) title,
	                         item_id
FROM
	cy_diary_item
WHERE
	item_id = '$item_id'";
        $result = $this->db->query($querySql);
        return result($result);
    }

    public function Umember_cr($diary_id, $status, $content, $clinetip, $dateline)
    {
        $sql = "INSERT INTO cy_diary_item (
                  diary_id,
                  status,
                  content,
                  clientip,
                  dateline
                ) 
                VALUES
                  (
                    '$diary_id',
                    '$status',
                    '$content',
                    '$clinetip',
                    '$dateline'
                  )";
        return execResult($this->db->execute($sql));
    }

    public function Umember_xg($item_id, $status, $content, $dateline)
    {
        $querySql = "UPDATE 
                         cy_diary_item 
                      SET 
                          status='$status',
                           content='$content',
                            dateline='$dateline'
                      WHERE 
                          item_id=$item_id";
        return $this->db->execute($querySql);
    }

    public function yuyue($uid)
    {
        $querySql = "SELECT
	mobile,
	(
		SELECT
			area_name
		FROM
			cy_data_area
		WHERE
			city_id = cy_tenders.city_id
	) city,
	(
		SELECT
			count(*)
		FROM
			cy_data_area
		WHERE
			uid = cy_tenders.uid
	) count,
	(
		CASE audit
		WHEN '0' THEN
			'待审核'
		WHEN '1' THEN
			'已审核'
		END
	) audit,
	from_unixtime(dateline, '%Y-%m-%d') time
FROM
	cy_tenders
	    WHERE 
        uid IN ('$uid')";
        $result = $this->db->query($querySql);
        return result($result);
    }

    public function ask($uid,$start,$pageSize)
    {
        $querySql = "SELECT
   ask_id,
	title,
	answer_num,
	(
		CASE cy_ask.audit
		WHEN '1' THEN
			'通过'
		WHEN '0' THEN
			'待审中'
		END
	) audit,
	(
		CASE cy_ask.answer_id
		WHEN '0' THEN
			'未解决'
		WHEN '1' THEN
			'已解决'
		END
	) answer,
	FROM_UNIXTIME(
		dateline,
		'%Y-%m-%d'
	) dateline
FROM
	cy_ask
	where
       uid in ('$uid')
        LIMIT " . $start . "," . $pageSize;
        $result = $this->db->query($querySql);
        return result($result);
    }
    public  function setask($uid){
        $querySql = "SELECT
	                  count(*) AS pageTotal
                    FROM
	                 	cy_ask
	where
       uid in ('$uid')";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public function ask_answer($uid,$start,$pageSize)
    {
        $querySql = "SELECT
	                    answer_id,
	                    ask_id,
	                   (SELECT  title FROM cy_ask WHERE ask_id=cy_ask_answer.ask_id) title,
	                     (
		             CASE 
		                 cy_ask_answer.audit
		             WHEN '1' THEN
			              '通过'
		             WHEN '0' THEN
			              '待审'
		             END
	                     ) audit,
	                    (
		             CASE 
		                cy_ask_answer.ask_id
		            WHEN '0' THEN
			            '未采纳'
	              	WHEN '1' THEN
			            '未采纳'
		            WHEN '2' THEN
			            '未采纳'
		            WHEN '3' THEN
			             '未采纳'
		            WHEN '4' THEN
			            '进行中'
		           WHEN '5' THEN
		            	'进行中'
		           WHEN '6' THEN
			           '进行中'
		           WHEN '7' THEN
			           '进行中'
		           WHEN '8' THEN
		            	'进行中'
		           WHEN '9' THEN
			            '进行中'
		           END
	                 ) answer,
	                 FROM_UNIXTIME(dateline, '%Y-%m-%d') dateline
                 FROM
	                 cy_ask_answer
                 where
                        uid in ('$uid')
                         LIMIT " . $start . "," . $pageSize;
        $result = $this->db->query($querySql);
        return result($result);
    }
    public  function setsk_answer($uid){
        $querySql = "SELECT
	                  count(*) AS pageTotal
                    FROM
	                 	   cy_ask_answer
                      where
                        uid in ('$uid')";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public function yuyue_company($uid)
    {
        $querySql = "
SELECT
	yuyue_id,
	contact,
	mobile,
	(
		SELECT
			NAME
		FROM
			cy_company
		WHERE
			uid = cy_company_yuyue.uid
	) name,
	FROM_UNIXTIME(dateline, '%Y-%m-%d') dateline
FROM
	cy_company_yuyue
	WHERE 
	 uid='$uid'
";
        $result = $this->db->query($querySql);
        return result($result);
    }
    public function yuyue_company_sjs($uid,$start,$pageSize)
    {
        $querySql = "SELECT
	yuyue_id,
	contact,
	mobile,
	(
		SELECT
			NAME
		FROM
			cy_company
		WHERE
			uid = cy_designer_yuyue.uid
	) name,
	FROM_UNIXTIME(dateline, '%Y-%m-%d') dateline
FROM
	cy_designer_yuyue
 where
    uid in ('$uid')
   LIMIT " . $start . "," . $pageSize;
        $result = $this->db->query($querySql);
        return result($result);
    }
    public function wdtb($uid,$start,$pageSize)
    {
        $querySql = "SELECT
	mobile,
	(
		SELECT
			area_name
		FROM
			cy_data_area
		WHERE
			city_id = cy_tenders.city_id
	) city,
	(
		SELECT
			count(*)
		FROM
			cy_data_area
		WHERE
			uid = cy_tenders.uid
	) count,
	(
		CASE audit
		WHEN '0' THEN
			'待审核'
		WHEN '1' THEN
			'已审核'
		END
	) audit,
	from_unixtime(dateline, '%Y-%m-%d') time
FROM
	cy_tenders
	    WHERE 
        uid ='$uid'
         LIMIT " . $start . "," . $pageSize;
        $result = $this->db->query($querySql);
        return result($result);
    }
    public  function setwdtb($uid){
        $querySql = "SELECT
	                  count(*) AS pageTotal
                    FROM
	                	cy_tenders
	    WHERE 
        uid IN ('$uid')";
        $result = $this->db->query($querySql);
        return resultList($result);
    }

    public  function setyuyue_company_sjs($uid){
        $querySql = "SELECT
	                  count(*) AS pageTotal
                    FROM
	                 	cy_designer_yuyue
 where
    uid in ('$uid')";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public function yuyue_company_sj($uid)
    {
        $querySql = "
SELECT
	yuyue_id,
	contact,
	mobile,
	(
		SELECT
			NAME
		FROM
			cy_company
		WHERE
			uid = cy_shop_yuyue.uid
	) name,
	FROM_UNIXTIME(dateline, '%Y-%m-%d') dateline
FROM
	cy_shop_yuyue
 where
      uid in ('$uid')";
        $result = $this->db->query($querySql);
        return result($result);
    }

    public function order_index($order_status)
    {
        $querySql = "SELECT
	a.order_no,
	FROM_UNIXTIME(a.dateline, '%Y-%m-%d') dateline,
	b.product_name,
	b.product_price,
	b.number,
	a.amount,
	a.order_status,
	(
		SELECT
			name
		FROM
			cy_shop
		WHERE
			shop_id = a.shop_id
	) name,(
		SELECT
			photo
		FROM
			cy_product
		WHERE
			product_id = b.product_id
	) photo
FROM
	cy_order a,
	cy_order_product b
WHERE
	a.order_id = b.order_id
AND order_status = '$order_status'";
        $result = $this->db->query($querySql);
        return result($result);
    }

    public function order_indexa()
    {
        $querySql = "SELECT
	a.order_no,
	FROM_UNIXTIME(a.dateline, '%Y-%m-%d') dateline,
	b.product_name,
	b.product_price,
	b.number,
	a.amount,
	a.order_status,
	(
		SELECT
			name
		FROM
			cy_shop
		WHERE
			shop_id = a.shop_id
	) name,(
		SELECT
			photo
		FROM
			cy_product
		WHERE
			product_id = b.product_id
	) photo
FROM
	cy_order a,
	cy_order_product b
WHERE
	a.order_id = b.order_id
";
        $result = $this->db->query($querySql);
        return result($result);
    }

    public function order_index_b($order_id)
    {
        $querySql = "UPDATE 
                         cy_order 
                      SET 
                          order_status='-1'  
                      WHERE 
                          order_id=$order_id";
        return $this->db->execute($querySql);
    }

    public function order_index_c($pay_status)
    {
        $querySql = "UPDATE 
                         cy_order 
                      SET 
                          order_status='2'  
                      WHERE 
                          pay_status=$pay_status";
        return $this->db->execute($querySql);
    }

    public function Umember_designer_yl($uid,$start,$pageSize)
    {
        $querySql = "SELECT
	                     article_id,
	                     title,
	                     (
		CASE audit
		WHEN '1' THEN
			'通过'
		WHEN '0' THEN
			'待审'
		ELSE
			''
		END
	) audit,
	                  
	                   FROM_UNIXTIME(dateline, '%Y-%m-%d') dateline
                    FROM
	                      cy_designer_article
	                WHERE 
	                       uid='$uid'
	                    LIMIT " . $start . "," . $pageSize;
        $result = $this->db->query($querySql);
        return result($result);
    }
    public  function setUmember_designer_yl($uid){
        $querySql = "SELECT
	                  count(*) AS pageTotal
                    FROM
	                       cy_designer_article
	                WHERE 
	                       uid='$uid'";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public function Umember_designer_delete($article_id)
    {
        $querySql = "DELETE 
                        FROM 
                       cy_designer_article
                       WHERE  
                       article_id = '$article_id'";
        return $this->db->execute($querySql);
    }

    public function Umember_designer_update($article_id, $title, $content, $dateline)
    {
        $querySql = "UPDATE 
                         cy_designer_article 
                      SET 
                          dateline='$dateline',
                          title='$title',
                          content='$content',
                      WHERE 
                          article_id=$article_id";
        return $this->db->execute($querySql);
    }
    public function Umember_designer_tj($uid,$title,$content,$dateline)
    {
        $sql = "INSERT INTO cy_designer_article (
                  city_id,
                  uid,
                  title,
                  content,
                  is_top,
                  views,
                  audit,
                  dateline
                ) 
                VALUES
                  (
                    '7',
                    '$uid',
                    '$title',
                    '$content',
                     '0',
                      '0',
                      '1',
                    '$dateline'
                  )";
        return execResult($this->db->execute($sql));
    }
    public function Umember_designer_yuyue($uid,$start,$pageSize)
    {
        $querySql = "SELECT
                           a.mobile,
                           a.contact,
                           FROM_UNIXTIME(a.dateline, '%Y-%m-%d') dateline
                      FROM
	                     cy_designer_yuyue a
                      WHERE 
	                    a.uid='$uid'
	                    LIMIT " . $start . "," . $pageSize;
        $result = $this->db->query($querySql);
        return result($result);
    }
    public  function setUmember_designer_yuyue($uid){
        $querySql = "SELECT
	                  count(*) AS pageTotal
                    FROM
	                       cy_designer_article
	                WHERE 
	                       uid='$uid'";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public function Umember_designer_Case($uid)
    {
        $querySql = "SELECT
                       case_id,
                       home_name,  (
		             CASE a.audit
	           	     WHEN '0' THEN
			            '待审核'
		             WHEN '1' THEN
			            '已审核'
		             ELSE
			             ''
		             END
	                    ) audit,
                        FROM_UNIXTIME(a.dateline, '%Y-%m-%d') dateline,
                        (SELECT COUNT(*) FROM cy_case WHERE uid=a.uid) conut
                     FROM
	                     cy_case a
                  	 WHERE 
	                    a.uid='$uid'";
        $result = $this->db->query($querySql);
        return result($result);
    }
    public function Umember_company_Casee($company_id)
    {
        $querySql = "SELECT
                           case_id,
                           home_name,  (
		            CASE a.audit
		            WHEN '0' THEN
			             '待审核'
		            WHEN '1' THEN
			             '已审核'
		            ELSE
			              ''
		            END
	                   ) audit,
                       FROM_UNIXTIME(a.dateline, '%Y-%m-%d') dateline,
                      (SELECT COUNT(*) FROM cy_case WHERE uid=a.uid) conut
                    FROM
	                     cy_case a
                  	WHERE 
	                    a.company_id='$company_id'";
        $result = $this->db->query($querySql);
        return result($result);
    }
    public function Umember_designer_Caseesc($case_id)
    {
        $querySql = "UPDATE 
                         cy_case 
                      SET 
                          audit='0'
                      WHERE 
                          case_id=$case_id";
        return $this->db->execute($querySql);
    }
    public function Umember_company_team($company_id,$start,$pageSize)
    {
        $querySql = "SELECT
	a.uid,
	a.NAME,
	a.school,
	a.mobile,
	a.qq,
	(
		CASE a.audit
		WHEN '0' THEN
			'待审核'
		WHEN '1' THEN
			'已审核'
		ELSE
			''
		END
	) audit,
	(
		SELECT
			mail
		FROM
			cy_member
		WHERE
			uid = a.uid
	) mail
        FROM
	cy_designer a
       WHERE
	a.company_id ='$company_id'
	   LIMIT " . $start . "," . $pageSize;
        $result = $this->db->query($querySql);
        return result($result);
    }

    public function setUmember_company_team($company_id)
    {
        $querySql = "SELECT 
	                  count(*) AS pageTotal
                     FROM
	            	cy_designer a
                     WHERE
	                a.company_id ='$company_id'";
        $result = $this->db->query($querySql);
        return  resultList($result);
    }
    public function Umember_company_jg($uid, $dateline)
    {
        $querySql = "UPDATE 
                         cy_designer 
                      SET 
                          dateline='$dateline',
                          company_id='0'
                      WHERE 
                          uid=$uid";
        return $this->db->execute($querySql);
    }

    public function Umember_company_tj($company_id,$uid,$dateline)
    {
        $querySql = "UPDATE 
                         cy_designer 
                      SET 
                          dateline='$dateline',
                          company_id='$company_id'
                      WHERE 
                          uid=$uid";
        return $this->db->execute($querySql);
    }

    public function Umember_company_yuyue($company_id)
    {
        $querySql = "SELECT
	                      a.content,
	                      a.mobile,
	                       FROM_UNIXTIME(a.dateline, '%Y-%m-%d') dateline
                     FROM
	                       cy_company_yuyue a
                     WHERE
	                        a.company_id = '$company_id'";
        $result = $this->db->query($querySql);
        return result($result);
    }

    public function Umember_company_yuyuesjs($company_id,$start,$pageSize)
    {
        $querySql = "SELECT	
                          (
		              SELECT
			              uname
		              FROM
			               cy_member
		              WHERE
		              	  uid = a.uid
	                      ) uname,
                           a.content,
	                       a.mobile,
	                      FROM_UNIXTIME(a.dateline, '%Y-%m-%d') dateline
                      FROM
	                      cy_designer_yuyue a
                      WHERE
	                      a.company_id = '$company_id'
	                        LIMIT " . $start . "," . $pageSize;
        $result = $this->db->query($querySql);
        return result($result);
    }
    public function setUmember_company_yuyuesjs($company_id)
    {
        $querySql = "SELECT 
	                  count(*) AS pageTotal
                     FROM
	              cy_designer_yuyue a
                      WHERE
	                      a.company_id = '$company_id'";
        $result = $this->db->query($querySql);
        return  resultList($result);
    }
    public function Umember_company_comment($company_id,$start,$pageSize)
    {
        $querySql = "SELECT
    comment_id,
	content,
	reply,
	score1,
	score2,
	score3,
	score4,
	score5,
	(
		SELECT
			UNAME
		FROM
			cy_member
		WHERE
			uid = a.uid
	) name,(
		CASE a.audit
		WHEN '1' THEN
			'已回复'
		WHEN '0' THEN
			'待回复'
		ELSE
			''
		END
	) audit,
	FROM_UNIXTIME(a.dateline, '%Y-%m-%d') dateline
FROM
	cy_company_comment a
WHERE
	a.company_id = '$company_id'
	  LIMIT " . $start . "," . $pageSize;
        $result = $this->db->query($querySql);
        return result($result);
    }
    public  function setUmember_company_comment($company_id){
        $querySql = "SELECT
	                  count(*) AS pageTotal
                     FROM
	                  cy_company_comment a
                     WHERE
	                   a.company_id = '$company_id'";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public function Umember_company_commenthf($comment_id, $reply, $dateline)
    {
        $querySql = "UPDATE 
                         cy_company_comment 
                      SET 
                          dateline='$dateline',
                          reply='$reply'
                      WHERE 
                          comment_id=$comment_id";
        return $this->db->execute($querySql);
    }

    public function Umember_company_tenders($area_id)
    {
          $querySql = "SELECT
	                   a.tenders_id,
	                   a.title yushuan,
	                   (
	                   	SELECT
			                area_name
		                FROM
			               cy_data_area
		               WHERE
			             area_id = a.area_id
	                     ) area_name,
	                     a.gold,
	                     a.title,
	                    FROM_UNIXTIME(a.dateline, '%Y-%m-%d') dateline
                        FROM
	                     cy_tenders a
                        WHERE
	                      a.FROM= 'TZX'
                        AND a.area_id = '$area_id'";
        $result = $this->db->query($querySql);
        return result($result);
    }

    public function Umember_company_tenderslooked($company_id,$start,$pageSize)
    {
        $querySql = "SELECT
	                   b.look_id,
	                   a.title,
	                   a.mobile,
	                   a.contact,
	                 FROM_UNIXTIME(b.dateline, '%Y-%m-%d') dateline,
                      	(
	               	 CASE b.is_signed
		             WHEN '1' THEN
		                   	'恭喜签单'
		             WHEN '0' THEN
			              '竞标中'
		             ELSE
			              ''
		             END
	                         ) is_signed
                     FROM
	                    cy_tenders a,
                     	cy_tenders_look b
                     WHERE
	                   a.tenders_id = b.tenders_id
	                   AND 
	                     b.company_id='$company_id'
	                        LIMIT " . $start . "," . $pageSize;
        $result = $this->db->query($querySql);
        return result($result);
    }
    public  function setUmember_company_tenderslooked($company_id){
        $querySql = "SELECT
	                  count(*) AS pageTotal
                     FROM
	                     cy_tenders a,
                     	cy_tenders_look b
                     WHERE
	                   a.tenders_id = b.tenders_id
	                   AND 
	                     b.company_id='$company_id'";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public function Umember_company_site()
    {
        $querySql = "SELECT
       b.site_id,
	   b.thumb,
       a.`name`,
       b.title,
     FROM_UNIXTIME(a.dateline, '%Y-%m-%d') dateline,
         (
		CASE a.audit
		WHEN '1' THEN
			'正常'
		WHEN '0' THEN
			'待审'
		ELSE
			''
		END
	     ) audit,(
		CASE b. STATUS
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
       cy_home a,
       cy_home_site b
    WHERE
       a.home_id=b.home_id";
        $result = $this->db->query($querySql);
        return result($result);
    }

    public function Umember_company_sitetj($title, $city_id, $area_id, $house_mj, $price, $thumb, $home_name, $case_id, $addr, $intro, $dateline, $clientip, $audit)
    {
        $sql = "INSERT INTO cy_home_site (
                  title,
                  city_id,
                  area_id,
                  house_mj,
                  price,
                  thumb,
                  home_name,
                  case_id,
                  addr,
                  intro,
                  dateline,
                  clientip,
                  audit
                ) 
                VALUES
                  (
                    '$title',
                    '$city_id',
                    '$area_id',
                    '$house_mj',
                    '$price',
                    '$thumb',
                    '$home_name',
                    '$case_id',
                    '$addr',
                    '$intro',
                    '$dateline',
                    '$clientip',
                    '$audit'
                  )";
        return execResult($this->db->execute($sql));
    }

    public function Umember_company_siteyl($site_id)
    {
        $querySql = "SELECT
	                    title,
	                    house_mj,
	                    price,
                  	    thumb,
                  	    home_name,
	                    addr,
	                    intro
                    FROM
	                   cy_home_site
	                WHERE 
	                   site_id='$site_id' 
	                AND 
	                   audit='1'";
        $result = $this->db->query($querySql);
        return result($result);
    }

    public function Umember_company_sitexg($title, $city_id, $area_id, $house_mj, $price, $thumb, $home_name, $case_id, $addr, $intro, $dateline, $clientip, $site_id)
    {
        $querySql = "UPDATE 
                         cy_home_site 
                      SET 
                         title='$title',
                         city_id='$city_id',
                         area_id='$area_id',
                         house_mj='$house_mj',
                         price='$price',
                         thumb='$thumb',
                         home_name='$home_name',
                         case_id='$case_id',
                         addr='$addr',
                         intro='$intro',
                         dateline='$dateline',
                         clientip='$clientip',
                      WHERE 
                          site_id=$site_id";
        return $this->db->execute($querySql);
    }

    public function Umember_company_sitesc($site_id)
    {
        $querySql = "UPDATE 
                         cy_home_site 
                     SET 
                         audit='0'
                     WHERE 
                           site_id = '$site_id'";
        return $this->db->execute($querySql);
    }

    public function Umember_company_diary($site_id)
    {
        $querySql = "SELECT
	                    title,
                        item_id,(
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
	                  FROM_UNIXTIME(dateline, '%Y-%m-%d') dateline
                      FROM
                       	cy_home_site_item
	                   WHERE 
	                 site_id='$site_id' ";
        $result = $this->db->query($querySql);
        return result($result);
    }

    public function Umember_company_diarytj($site_id, $status, $title, $content, $dateline, $clientip)
    {
        $sql = "INSERT INTO cy_home_site_item (
                  site_id,
                  status,
                  title,
                  content,
                  dateline,
                  clientip,
                ) 
                VALUES
                  (
                    '$site_id',
                    '$status',
                    '$title',
                    '$content',
                    '$dateline',
                    '$clientip'
                  )";
        return execResult($this->db->execute($sql));
    }

    public function Umember_company_diaryxg($site_id, $status, $title, $content, $dateline, $clientip, $item_id)
    {
        $querySql = "UPDATE 
                         cy_home_site_item 
                      SET 
                         site_id='$site_id',
                         status='$status',
                         title='$title',
                         content='$content',
                         dateline='$dateline',
                         clientip='$clientip',
                      WHERE 
                          item_id=$item_id";
        return $this->db->execute($querySql);
    }

    public function Umember_company_diaryly($item_id)
    {
        $querySql = "SELECT
	                  title,
	                  content,
	                 (SELECT title FROM cy_home_site WHERE site_id=cy_home_site_item.site_id)
                       item_id,(
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
	                   FROM_UNIXTIME(dateline, '%Y-%m-%d') dateline
                      FROM
	                   cy_home_site_item
	                  WHERE 
	                   item_id='$item_id' ";
        $result = $this->db->query($querySql);
        return result($result);
    }

    public function Umember_company_diarysc($item_id)
    {
         $querySql = "DELETE 
                        FROM 
                       cy_home_site_item
                       WHERE  
                       item_id = '$item_id'";
        return $this->db->execute($querySql);
    }

    public function Umember_company_sgjd()
    {
        $querySql = "SELECT
                         title
                      FROM
	                      cy_data_attr_value
	                      WHERE  attr_id='20'";
        $result = $this->db->query($querySql);
        return result($result);
    }

    public function Umember_company_home($name)
    {
        $querySql = "SELECT
	                       name
                      FROM
	                     cy_home
                     WHERE  name LIKE '%$name%'";
        $result = $this->db->query($querySql);
        return result($result);
    }
    public function company_id($company_id)
    {
        $querySql = "SELECT
	                       name
                      FROM
	                     cy_company
                     WHERE  company_id='$company_id'";
        $result = $this->db->query($querySql);
        return result($result);
    }
    public function Umember_company_cb($company)
    {
        $querySql = "SELECT
                       *
                      FROM
	                      cy_company
                      WHERE 
                        name LIKE '%$company%'";
        $result = $this->db->query($querySql);
        return result($result);
    }
    public function type1()
    {
        $querySql = "SELECT
	                   *
                     FROM
	                     cy_tenders_setting
                     WHERE
	                      type = '5'";
        $result = $this->db->query($querySql);
        return result($result);
    }
    public function type2()
    {
        $querySql = "SELECT
	                   *
                     FROM
	                     cy_tenders_setting
                     WHERE
	                       type = '6'";
        $result = $this->db->query($querySql);
        return result($result);
    }
    public function type_id($type_id)
    {
        $querySql = "SELECT
	                   name 
                     FROM
	                     cy_tenders_setting
                     WHERE
	                      type = '$type_id'";
        $result = $this->db->query($querySql);
        return result($result);
    }
    public function way_id($way_id)
    {
        $querySql = "SELECT
	                   name
                     FROM
	                     cy_tenders_setting
                     WHERE
	                      type = '$way_id'";
        $result = $this->db->query($querySql);
        return result($result);
    }
}