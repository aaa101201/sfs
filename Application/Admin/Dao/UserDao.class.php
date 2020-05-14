<?php
// +----------------------------------------------------------------------
// | 基础业务CRUD方法范例
// +----------------------------------------------------------------------
// | Author: WangGang <gangwang@yingfankeji.net>
// +----------------------------------------------------------------------

namespace Admin\Dao;

class UserDao extends BaseDao
{

    public function _initialize($db)
    {
        parent::_initialize($db);
    }

    public function createId()
    {
        $querySql = "SELECT
	                 uid,group_id
                     FROM
	                  cy_member
                   ORDER BY
	                uid DESC
                    LIMIT 0,1
                    ";
        $result = $this->db->query($querySql);
        return result($result);
    }

    public function cy_companylyy($company_id)
    {
        $querySql = "SELECT
	b.title,
	b.attr_id,
	b.attr_value_id
FROM
	cy_company_attr a,
	cy_data_attr_value b
WHERE
	a.attr_id = b.attr_id
AND a.attr_value_id = b.attr_value_id
	                  AND 
	                  a.company_id='$company_id'
                    ";
        $result = $this->db->query($querySql);
        return result($result);
    }
    public function cy_companyly($company_id)
    {
        $querySql = "SELECT
company_id,
	(
		SELECT
			city_name
		FROM
			cy_data_city
		WHERE
			city_id = cy_company.city_id
	) city_name,
	(
		SELECT
			area_name
		FROM
			cy_data_area
		WHERE
			area_id = cy_company.area_id
	) area_name,
	title,
	name,
	thumb,
	logo,
	slogan,
	contact,
	phone,
	mobile,
	qq,
	addr,
	photo,
		(
		SELECT
			info
		FROM
			cy_company_fields
		WHERE
			company_id = cy_company.company_id
	) info
FROM
	cy_company
                     WHERE 
                       company_id='$company_id';
                    ";
        $result = $this->db->query($querySql);
        return result($result);
    }
    public function designerl($uid)
    {
        $querySql = "SELECT
	(
		SELECT
			city_name
		FROM
			cy_data_city
		WHERE
			city_id = cy_designer.city_id
	) city_name,
	(
		SELECT
			area_name
		FROM
			cy_data_area
		WHERE
			area_id = cy_designer.area_id
	) area_name,
	name,
	school,
	qq,
	mobile,
	slogan,
	about
FROM
	cy_designer
                     WHERE 
                       uid='$uid';
                    ";
        $result = $this->db->query($querySql);
        return result($result);
    }
    public function attr($attr)
    {
        $querySql = "SELECT
	                  attr_value_id,
	                  attr_id
                     FROM
	                  cy_data_attr_value
                     WHERE 
                       title='$attr';
                    ";
        $result = $this->db->query($querySql);
        return result($result);
    }
    public function attrR2($company_id)
    {
        $querySql = "DELETE 
                        FROM 
                       cy_company_attr
                       WHERE  
                       company_id = '$company_id'";
        return $this->db->execute($querySql);
    }
    public function designerly_j()
    {
        $querySql = "SELECT
  attr_id,
attr_value_id,
	title
FROM
	cy_data_attr_value
WHERE
	attr_id = '9';
                    ";
        $result = $this->db->query($querySql);
        return result($result);
    }
    public function designerly_zyx()
    {
        $querySql = "SELECT
    attr_value_id,
	title
FROM
	cy_data_attr_value
WHERE
	attr_id = '10';
                    ";
        $result = $this->db->query($querySql);
        return result($result);
    }
    public function designer_q($uid,$cy_company)
    {
        $querySql = "SELECT
	*
FROM
	cy_company
WHERE company_id='$cy_company'
UNION
	SELECT
		*
	FROM
		cy_designer
WHERE uid='$uid'';
                    ";
        $result = $this->db->query($querySql);
        return result($result);
    }
    public function uidddc($uname)
    {
        $querySql = "SELECT
                    a.uid,
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
                    uid
                      FROM
	                      cy_member 
                     WHERE 
                         uname='$uname'";
        $result = $this->db->query($querySql);
        return result($result);
    }
    public function cy_companylygsgm()
    {
        $querySql = "SELECT
  attr_id,
attr_value_id,
	title
FROM
	cy_data_attr_value
WHERE
	attr_id = '3';
                    ";
        $result = $this->db->query($querySql);
        return result($result);
    }
    public function cy_companylygsfw()
    {
        $querySql = "SELECT
attr_value_id,
	title
FROM
	cy_data_attr_value
WHERE
	attr_id = '1';
                    ";
        $result = $this->db->query($querySql);
        return result($result);
    }
    public function attrR($company_id, $attr_id, $attr_value_id)
    {
        $sql = "INSERT INTO `cy_company_attr` (
                                 	`company_id`,
	                            `attr_id`,
	                         `attr_value_id`
                                           )
                                 VALUES
	                                      (
	                              	'$company_id',
		                       '$attr_id',
		                           '$attr_value_id'
	                                       )";
        return execResult($this->db->execute($sql));
    }
    public function attrb($attrb)
    {
        $querySql = "SELECT
	                  attr_value_id,
	                  attr_id
                     FROM
	                  cy_data_attr_value
                     WHERE 
                       title='$attrb';
                    ";
        $result = $this->db->query($querySql);
        return result($result);
    }
    public function company_idD()
    {
        $querySql = "SELECT
	company_id
FROM
	cy_company
GROUP BY
	company_id DESC
LIMIT 0,
 1;
                    ";
        $result = $this->db->query($querySql);
        return result($result);
    }
    public function createe($uname)
    {
        $querySql = "SELECT
	a.uid,
	a.group_id,
	b.company_id
FROM
	cy_member a,
	cy_company b
WHERE
	a.uid = b.uid
	AND 
                      a.uname='$uname'
                        LIMIT 0,1
                    ";
        $result = $this->db->query($querySql);
        return result($result);
    }

    // 获取主键ID
    public function getLastInsertId($db)
    {
        $sql = "SELECT  last_insert_id()  AS  id";
        $result = $db->query($sql);
        $this->loger('result', $result);
        return $result[0]['id'];
    }

    public function creat($uname)
    {
        $querySql = "SELECT
	a.uid,
	a.group_id
FROM
	cy_member a
WHERE
                      a.uname='$uname'
                        LIMIT 0,1
                    ";
        $result = $this->db->query($querySql);
        return result($result);
    }

    public function company_id($uid)
    {
        $querySql = "SELECT
	                    company_id
                     FROM
                       	cy_company
                  WHERE
                      uid='$uid'
                        LIMIT 0,1";
        $result = $this->db->query($querySql);
        return result($result);
    }

    public function createea($uname)
    {
        $querySql = "SELECT
	a.uid
FROM
	cy_member a
	WHERE
                      a.uname='$uname'
                    ";
        $result = $this->db->query($querySql);
        return result($result);
    }


    public function cy_member($uname)
    {
        $querySql = "SELECT
	                 *
                     FROM
	                  cy_member
                     WHERE 
                      uname='$uname'
                        LIMIT 0,1
                    ";
        $result = $this->db->query($querySql);
        return result($result);
    }

    public function cy_member_a($uid)
    {
        $sql = "INSERT INTO `cy_member_fields` (
                                 	 `uid`,
                                 	  `addr`
                                           )
                                 VALUES
	                                      (
	                              	'$uid',
	                              	''
	                                       )";
        return execResult($this->db->execute($sql));
    }

    /**
     * 业主注册
     *
     */
    public function create($uid, $uname, $passwd, $from, $grop_id, $mail, $gender, $city_id, $lastlogin, $loginip, $regip, $dateline)
    {
        $sql = "INSERT INTO 
                   `cy_member`
                    VALUES 
                  (
                    '$uid',
                    '$grop_id',
                    '$uname',
                    '$passwd',
                    '$from',
                    '$mail',
                    '',
                    '0',
                    '0',
                    '$gender',
                    '$city_id',
                   	'',
	               	'',
		            '',
		            '',
		            '0',
	            	'0',
		            '0',
		            '0',
		            '0',
		             '',
                    '$lastlogin',
                    '$loginip',
                    '0',
                    '$regip',
                    '$dateline',
                    '0' 
                  )";
        return execResult($this->db->execute($sql));
    }

    /**
     * 设计师注册
     *
     */
    public function setDesigner($uid,$group_id, $name, $school, $city_id, $area_id, $mobile, $qq, $slogan, $about, $orderby, $flushtime, $dateline)
    {
        $sql = "INSERT INTO `cy_designer` (
                               `uid`,
	                           `group_id`,
	                           `company_id`,
	                           `city_id`,
                               `area_id`,
	                           `name`,
	                           `school`,
	                           `qq`,
	                           `mobile`,
	                           `attention_num`,
                               `yuyue_num`,
	                           `case_num`,
	                           `blog_num`,
	                           `views`,
	                           `tenders_num`,
	                           `tenders_sign`,
	                           `comments`,
	                           `score`,
	                           `score1`,
	                           `score2`,
	                           `score3`,
	                           `slogan`,
	                           `about`,
	                           `orderby`,
	                           `flushtime`,
	                           `audit`,
	                           `closed`,
                          	   `dateline`
                                 )
                          VALUES
	                            (
	                           '$uid',
		                       '$group_id',
		                       '0',
		                       '$city_id',
		                       '$area_id',
	                  	       '$name',
		                       '$school',
		                       '$qq',
		                       '$mobile',
		                       '0',
		                       '0',
	                      	   '0',
		                       '0',
		                       '0',
		                       '0',
		                       '0',
		                       '0',
		                       '0',
		                       '0',
		                       '0',
	                           '0',
		                       '$slogan',
		                       '$about',
	                       	   '$orderby',
		                       '$flushtime',
		                       '0',
		                       '0',
		                       '$dateline'
	)";
        return execResult($this->db->execute($sql));

    }

    public function Mechaniclist($uid)
    {
        $querySql = "SELECT 
                         * 
                     FROM 
                         cy_mechanic 
                     WHERE 
                          uid='$uid'";
        $result = $this->db->query($querySql);
        return result($result);
    }
    public function cy_companyly_banner($company_id)
    {
        $querySql = "SELECT 
                        photo
                     FROM 
                         cy_company_banner 
                     WHERE 
                          company_id='$company_id'";
        $result = $this->db->query($querySql);
        return result($result);
    }
    public function deletebanner($company_id)
    {
        $sql = "DELETE 
                    FROM 
                    cy_company_banner
                  WHERE  
                  company_id = '$company_id'";
        return execResult($this->db->execute($sql));
    }

    public function banner($company_id, $photo, $title)
    {
        $sql = "INSERT INTO `cy_company_banner` (
                                 	`company_id`,
	                                `photo`,
	                                `title`,
	                               `orderBy`
                                           )
                          VALUES
	                                      (
	                            '$company_id',
		                        '$photo',
		                         '$title',
		                           '50'
	                                       )";
        return execResult($this->db->execute($sql));
    }

    public function setMechaniclist($uid, $group_id, $city_id, $flushtime, $name, $area_id, $mobile, $qq, $about)
    {
        $sql = "INSERT INTO `cy_mechanic` (
                                 	`uid`,
	                           `group_id`,
	                               `name`,
	                            `city_id`,
	                            `area_id`,
	                             `mobile`,
	                                 `qq`,
	                              `about`,
	                       `tenders_sign`,
	                        `tenders_num`,
	                          `yuyue_num`,
	                              `views`,
	                            `orderby`,
	                          `flushtime`,
                              	  `audit`,
	                             `closed`
                                           )
                          VALUES
	                                      (
	                              	'$uid',
		                       '$group_id',
		                           '$name',
		                        '$city_id',
		                        '$area_id',
		                         '$mobile',
		                             '$qq',
		                          '$about',
		                               '0',
		                               '0',
		                               '0',
		                               '0',
		                              '50',
		                         $flushtime,
		                               '0',
		                                '0'
	                                       )";
        return execResult($this->db->execute($sql));
    }

    public function designer_s($uid, $attr_id, $attr_value_id)
    {
        $sql = "INSERT INTO `cy_mechanic_attr` (
                                 	`uid`,
	                            `attr_id`,
	                         `attr_value_id`
                                           )
                                 VALUES
	                                      (
	                              	'$uid',
		                       '$attr_id',
		                           '$attr_value_id'
	                                       )";
        return execResult($this->db->execute($sql));
    }

    public function Mechanic_s($uid, $attr_id, $attr_value_id)
    {
        $sql = "INSERT INTO `cy_mechanic_attr` (
                                 	`uid`,
	                            `attr_id`,
	                         `attr_value_id`
                                           )
                                 VALUES
	                                      (
	                              	'$uid',
		                       '$attr_id',
		                           '$attr_value_id'
	                                       )";
        return execResult($this->db->execute($sql));
    }

    public function setcy_company_fields( $company_idD,$info)
    {
        $sql = "INSERT INTO `cy_company_fields` (
                                     `company_id`,   
                                 	`info`
                                           )
                                 VALUES
	                                      (
	                              $company_idD,
	                              	'$info'
	                                       )";
        return execResult($this->db->execute($sql));
    }

    public function company($uid)
    {
        $querySql = "SELECT 
                      * 
                     FROM 
                      cy_company
                     WHERE 
                       uid='$uid'";
        $result = $this->db->query($querySql);
        return result($result);
    }

    public function fields($company_id)
    {
        $querySql = "SELECT 
                      * 
                     FROM 
                      cy_company_fields
                     WHERE 
                       company_id='$company_id'";
        $result = $this->db->query($querySql);
        return result($result);
    }
    public function company_fieldsLOL($info)
    {
        $querySql = "SELECT 
                      * 
                     FROM 
                      cy_company_fields
                     WHERE 
                       info='$info'";
        $result = $this->db->query($querySql);
        return result($result);
    }

    public function Update_company_fields($company_id, $info)
    {
        $querySql = "UPDATE 
                        cy_company_fields 
                     SET 
                        info='$info'
                     WHERE 
                         company_id='$company_id'";
        return $this->db->execute($querySql);
    }

    public function Update_company($uid, $uname, $group_id, $city_id, $area_id, $title, $name, $thumb, $logo, $slogan, $contact, $phone, $mobile, $qq, $addr, $flushtime, $clientip, $dateline)
    {
        $querySql = "UPDATE 
                        cy_company 
                     SET 
                        group_id='$group_id' ,
                        city_id='$city_id' ,
                        flushtime='$flushtime' ,
                        name='$name' ,
                        area_id='$area_id' ,
                        mobile='$mobile' ,
                        qq='$qq' ,
                        title='$title' ,
                        slogan='$slogan' ,
                        thumb='$thumb' ,
                        dateline='$dateline',
                        logo='$logo',
                        contact='$contact',
                        phone='$phone',
                        addr='$addr',
                        clientip='$clientip' 
                     WHERE 
                         uid='$uid'";
        return $this->db->execute($querySql);
    }

    public function Update_Mechani($uid, $attr_id, $attr_value_id)
    {
        $querySql = "UPDATE 
                        cy_designer_attr 
                     SET 
                        attr_value_id='$attr_value_id',
                        attr_id='$attr_id'
                     WHERE 
                         uid='$uid'";
        return $this->db->execute($querySql);
    }

    public function Update_cy_designer($uid, $attr_id)
    {
        $querySql = "DELETE 
                        FROM 
                       cy_designer_attr
                       WHERE  
                       uid = '$uid'
                       AND
                        attr_id='$attr_id'";
        return $this->db->execute($querySql);
    }
    public function Update_cy_designerr($uid, $attr_idd)
    {

        $querySql = "DELETE 
                        FROM 
                       cy_designer_attr
                       WHERE  
                       uid = '$uid'
                       AND
                        attr_id='$attr_idd'";
        return $this->db->execute($querySql);

//        $querySql = "UPDATE
//                        cy_designer_attr
//                     SET
//                        attr_value_id='$attr_value_idd',
//                        attr_id='$attr_idd'
//                     WHERE
//                         uid='$uid'";
//        return $this->db->execute($querySql);
    }
    public function cy_designer_s($uid, $attr_id, $attr_value_id)
    {
        $sql = "INSERT INTO `cy_designer_attr` (
                                 	`uid`,
	                            `attr_id`,
	                         `attr_value_id`
                                           )
                                 VALUES
	                                      (
	                              	'$uid',
		                       '$attr_id',
		                           '$attr_value_id'
	                                       )";
        return execResult($this->db->execute($sql));
    }
    public function cy_designer_ss($uid, $attr_idd, $attr_value_idd)
    {
        $sql = "INSERT INTO `cy_designer_attr` (
                                 	`uid`,
	                            `attr_id`,
	                         `attr_value_id`
                                           )
                                 VALUES
	                                      (
	                              	'$uid',
		                       '$attr_idd',
		                           '$attr_value_idd'
	                                       )";
        return execResult($this->db->execute($sql));
    }
    public function designer_slyy($attr_id,$attr_value_id)
    {
        $querySql = "SELECT
	*
FROM
	cy_data_attr_value
WHERE
  attr_id='$attr_id'
  AND 
    attr_value_id='$attr_value_id'
  ";
        $result = $this->db->query($querySql);
        return result($result);
    }
    public function attr_id_attr_value_id($namejy)
    {
        $querySql = "SELECT
	*
FROM
	cy_data_attr_value
WHERE
  title='$namejy'";
        $result = $this->db->query($querySql);
        return result($result);
    }
    public function attr_id_attr_value_idd($namezw)
    {
        $querySql = "SELECT
	*
FROM
	cy_data_attr_value
WHERE
  title='$namezw'";
        $result = $this->db->query($querySql);
        return result($result);
    }
    public function Update_Mechaniclist($uid, $group_id, $city_id, $flushtime, $name, $area_id, $mobile, $qq, $about)
    {
        $querySql = "UPDATE 
                        cy_mechanic 
                     SET 
                        group_id='$group_id' ,
                        city_id='$city_id' ,
                        flushtime='$flushtime' ,
                        name='$name' ,
                        area_id='$area_id' ,
                        mobile='$mobile' ,
                        qq='$qq' ,
                        about='$about' 
                     WHERE 
                         uid='$uid'";
        return $this->db->execute($querySql);
    }

    public function cy_designer_attr($uid)
    {
        $querySql = "SELECT 
                      * 
                     FROM 
                      cy_designer_attr 
                     WHERE 
                       uid='$uid' 
                  ";
        $result = $this->db->query($querySql);
        return result($result);
    }
    public function designer_sly($uid)
    {
        $querySql = "SELECT 
                      * 
                     FROM 
                      cy_designer_attr 
                     WHERE 
                       uid='$uid' ";
        $result = $this->db->query($querySql);
        return result($result);
    }

    public function Designer($uid)
    {
        $querySql = "SELECT 
                      * 
                     FROM 
                      cy_designer 
                     WHERE 
                       uid='$uid'";
        $result = $this->db->query($querySql);
        return result($result);
    }

    public function cy_member_group()
    {
        $querySql = "SELECT a.group_id,a.from,(		CASE a.from
		WHEN 'member' THEN
			'业主会员'
		WHEN 'designer' THEN
			'设计师'
		WHEN 'company' THEN
			'装修公司'
		WHEN 'shop' THEN
			'建材商家'
		WHEN 'mechanic' THEN
			'装修工人'
		END) group_name FROM cy_member_group a
";
        $result = $this->db->query($querySql);
        return result($result);
    }

    public function Update_Designer($uid, $group_id, $name, $school, $city_id, $area_id, $mobile, $qq, $slogan, $about, $orderby, $flushtime, $dateline)
    {
        $querySql = "UPDATE 
                        cy_designer 
                     SET 
                        school='$school',
                        group_id='$group_id' ,
                        city_id='$city_id' ,
                        flushtime='$flushtime' ,
                        name='$name' ,
                        area_id='$area_id' ,
                        mobile='$mobile' ,
                        qq='$qq' ,
                        about='$about' ,
                        slogan='$slogan' ,
                        orderby='$orderby' ,
                        dateline='$dateline' 
                     WHERE 
                         uid='$uid'";
        return $this->db->execute($querySql);
    }

    /**
     * 注册 装修公司
     *
     */
    public function setcy_company($uid, $group_id, $city_id, $area_id, $title, $name, $thumb, $logo, $slogan, $contact, $phone, $mobile, $qq, $addr, $flushtime, $clientip, $dateline)
    {
        $sql = "INSERT INTO `cy_company` (
	                          `uid`,
	                          `group_id`,
	                          `city_id`,
	                          `area_id`,
                      	      `title`,
	                          `name`,
	                          `thumb`,
	                          `logo`,
	                          `slogan`,
	                          `contact`,
	                          `phone`,
	                          `mobile`,
	                          `qq`,
	                          `addr`,
	                          `xiaobao`,
	                          `comments`,
	                          `score`,
	                          `score1`,
	                          `score2`,
	                          `score3`,
	                          `score4`,
	                          `score5`,
	                          `tenders_num`,
	                          `tenders_sign`,
	                          `case_num`,
	                          `site_num`,
	                          `news_num`,
	                          `youhui_num`,
	                          `yuyue_num`,
	                          `last_case`,
	                          `last_site`,
	                          `views`,
	                          `verify_name`,
	                          `is_vip`,
	                          `lasttime`,
	                          orderby,
	                          `audit`,
	                          `closed`,
	                          `flushtime`,
                          	  `clientip`,
	                          `dateline`,
                    	      `pay`
                                 )
                    VALUES
	                           (
		                     '$uid',
		                     '$group_id',
		                     '$city_id',
		                     '$area_id',
		                     '$title',
		                     '$name',
		                     '$thumb',
		                     '$logo',
		                     '$slogan',
		                     '$contact',
		                     '$phone',
		                     '$mobile',
		                     '$qq',
	            	         '$addr',
		                     '0',
	               	         '0',
		                     '0',
		                     '0',
		                     '0',
		                     '0',
		                     '0',
		                     '0',
		                     '0',
		                     '0',
		                     '0',
		                     '0',
		                     '0',
		                     '0',
		                     '0',
	                         '0',
	                         '0',
	                         '0',
		                     '0',
                           	 '0',
		                     '0',
		                      '50',
		                     '0',
		                     '0',
	                         '$flushtime',
		                     '$clientip',
		                     '$dateline',
		                     '0'
	)";
        return execResult($this->db->execute($sql));
    }

    /**
     * 业主注册+建材商家
     *
     */
    public function setcy_shop($uid, $group_id, $money, $cat_id, $area_id, $city_id, $title, $name, $logo, $thumb, $contact, $phone, $xiaobao, $views, $credit, $score, $comments, $products, $verif_name, $tenders_num, $tenders_sign, $is_vip, $ling, $lat, $orderby, $audit, $flushtime, $closed, $dataline, $pay)
    {
        $sql = "INSERT INTO `cy_shop` (
	                        `uid`,
	                        `group_id`,
	                        `money`,
	                        `cat_id`,
	                        `city_id`,
	                        `area_id`,
	                        `title`,
	                        `name`,
	                        `logo`,
	                        `thumb`,
	                        `contact`,
	                        `phone`,
	                        `xiaobao`,
	                        `views`,
                        	`credit`,
	                        `score`,
	                        `comments`,
	                        `products`,
	                        `verify_name`,
	                        `tenders_num`,
	                        `tenders_sign`,
	                        `is_vip`,
                          	`lng`,
	                        `lat`,
	                        `orderby`,
	                        `audit`,
	                        `flushtime`,
	                        `closed`,
	                        `dateline`,
	                        `pay`
                           )
                           VALUES
	                      (
	                         '$uid',
		                     '$group_id',
	      	                 '$money',
		                     '$cat_id',
		                     '$city_id',
	                         '$area_id',
	                         '$title',
		                     '$name',
		                     '$logo',
		                     '$thumb',
	              	         '$contact',
		                     '$phone',
		                     '0',
	                         '0',
	                         '0',
	                         '0',
	                         '0',
	                         '0',
	                         '0',
                      	     '0',
	                         '0',
	                         '0',
		                     '$ling',
		                     '$lat',
	                         '0',
	                         '0',
	                         '$flushtime',
	                         '0',
	                         '$dataline',
		                     '0'
	)";
        return execResult($this->db->execute($sql));
    }

    public function setcy_shop_fields($uid)
    {
        $sql = "INSERT INTO `cy_shop_fields` (
	                        `uid`
                           )
                           VALUES
	                      (
	                         '$uid'
	)";
        return execResult($this->db->execute($sql));
    }

    public function cy_shop_banner($uid, $banner)
    {
        $querySql = "UPDATE 
                        cy_shop_fields 
                     SET 
                        banner='$banner'
                     WHERE 
                         uid='$uid'";
        return $this->db->execute($querySql);
    }

    public function cy_shop_fox($uid, $fox, $mail, $qq, $hours, $addr, $jiaotong, $bulletin)
    {
        $querySql = "UPDATE 
                        cy_shop_fields 
                     SET 
                        fox='$fox',
                        mail='$mail',
                        qq='$qq',
                        hours='$hours',
                        addr='$addr',
                        jiaotong='$jiaotong',
                        bulletin='$bulletin'
                     WHERE 
                         uid='$uid'";
        return $this->db->execute($querySql);
    }

    public function cy_shop_seo($uid, $seo_title, $seo_keywords, $seo_description)
    {
        $querySql = "UPDATE 
                        cy_shop_fields 
                     SET 
                        seo_title='$seo_title',
                        seo_keywords='$seo_keywords',
                        seo_description='$seo_description'
                     WHERE 
                         uid='$uid'";
        return $this->db->execute($querySql);
    }
}