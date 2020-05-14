<?php
/**
 * Created by PhpStorm.
 * User: Freeman
 * Date: 2016/10/27
 * Time: 14:51
 */

namespace Admin\Dao;


class IndexDao extends BaseDao
{
    public  function  __construct($db)
    {
        parent::__construct($db);
    }
    /**
     * @param $db
     * @param $params
     * @return 获取菜单栏信息
     */
    public function getMenu($db, $userId) {
        $sql = "select distinct res.* 
                    from admin_auth_resource res 
                    left join admin_auth_role_resource_rel  rel 
                    on res.id=rel.resourceId 
                    left join admin_auth_user_role_rel rol 
                    on rel.roleId=rol.roleId
                    where res.type=1 and rol.userId=" . $userId . " ORDER BY res.weight";
        $this->loger("sql", $sql);
        $data = $db->query($sql);
        return resultList($data);
    }
    public  function  login($uname,$passwd){
        $querySql = "SELECT 
                      a.from
                    FROM
                       cy_member  a
                    WHERE a.uname = '$uname' 
                      AND a.passwd = '$passwd'";
        $result=$this->db->query($querySql);
        return result($result);
    }
    public  function Umember_zl($uname){
        $querySql = "SELECT
	uname,
	face,
	realname,
	 (SELECT city_name FROM cy_data_city WHERE city_id=cy_member.city_id) city_id,
	y,
	m,
	d
  FROM
	cy_member
	WHERE 
	   uname='$uname';";
        $result=$this->db->query($querySql);
        return result($result);
    }
    public function Designer_h($city_id)
    {
        $querySql = "SELECT 
	                 *
                     FROM
	                cy_data_city
	                WHERE 
	                 city_name='$city_id';
	                  ";
        $result = $this->db->query($querySql);
        return resultList($result);
    }

    public  function Umember_zlx($uname,$realname,$city_id,$y,$m,$d,$dateline){
        $querySql = "UPDATE 
                        cy_member 
                     SET 
                        realname='$realname',
                        city_id='$city_id',
                         y='$y',
                         m='$m',
                         d='$d',
                        dateline='$dateline' 
                     WHERE 
                         uname='$uname'";
        return execResult($this->db->execute($querySql));
    }
    public  function  create($uname,$passwd,$fromw,$mail,$from,$group_id,$gender,$city_id,$lastlogin,$loginip,$regip,$dateline){
        $sql = "INSERT INTO cy_member (
                  uname,
                  passwd,
                  group_id,
                  mail,
                  from,
                  credits,
                  gold,
                  gender,
                  city_id,
                  Y,
                  M,
                  D,
                  verify,
                  lastlogin,
                  loginip,
                  closed,
                  regip,
                  dateline,
                  fromw
                ) 
                VALUES
                  (
                    '$uname',
                    '$passwd',
                    '$group_id',
                    '$mail',
                    '$from',
                    '0',
                    '0',
                    '$gender',
                    '$city_id',
                    '0',
                    '0',
                    '0',
                    '0',
                    '$lastlogin',
                    '$loginip',
                    '0',
                    '$regip',
                    '$dateline',
                    '$fromw'  
                  )";
        return execResult($this->db->execute($sql));
    }
    public  function  Umember_mm($xpasswd,$uname,$dateline){
        $querySql = "UPDATE 
                        cy_member 
                     SET 
                        passwd='$xpasswd',
                         dateline='$dateline'
                     WHERE 
                         uname='$uname'";
        return execResult($this->db->execute($querySql));
    }
    public  function  Umember_passwd($uname){
        $querySql = "SELECT 
	                 *
                     FROM
	                cy_member
	                WHERE 
	                 uname='$uname';
	                  ";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
}