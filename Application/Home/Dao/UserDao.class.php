<?php
// +----------------------------------------------------------------------
// | 基础业务CRUD方法范例
// +----------------------------------------------------------------------
// | Author: WangGang <gangwang@yingfankeji.net>
// +----------------------------------------------------------------------

namespace Home\Dao;
use Enum\SessionEnum;

class UserDao extends BaseDao{

    public function _initialize($db) {
        parent::_initialize($db);
    }

    /**
     * 持久化信息到user表 返回userID
     */
    public function snycUser2DB($id=null,$shopId=null,$phone=null) {
        $user=session(SessionEnum::WECHAT_USER);
        if(empty($user)){
            return;
        }
        $data = array(
            'openid' => $user['openid'],
            'nickname' => $user['nickname'],
            'headimgurl' => $user['headimgurl'],
            'gender' => $user['sex'],
            'country' => $user['country'],
            'province' => $user['province'],
            'city' => $user['city']
        );


        // 已存在账号
        if($id>0){
            $where=empty($id)?"":" AND id=$id";
            // 根据用户openid查询用户微信信息是否同步
            $querySql = "SELECT
                      count(*) as total
                    FROM `c_user`
                    WHERE openid='".$data['openid']."' $where";
            $result=$this->db->query($querySql);
            $total =$result[0]["total"];
            // 未关注
            if(!$total){
                $data["lastLoginTime"]=date("Y-m-d H:i:s",time());
                M("c_user")->where("id=$id")->save($data);
            }
            return $id;
        }else{
            // 未同步
            $data["subscribeTime"]=date("Y-m-d H:i:s",time());
            $data["lastLoginTime"]=date("Y-m-d H:i:s",time());
            $data["shopId"]=$shopId;
            $data["phone"]=$phone;
            if(!empty($id)){
                $data["id"]=$id;
            }
            return M("c_user")->add($data);
        }
    }

    /**
     * 根据ID查询该商户最低等级的会员等级ID
     */
    public function getLevelDefault() {
        $sql="SELECT
              `id`
            FROM `b_config_level`
            where status = 1
            order by amount asc limit 1";
        $result=$this->db->query($sql);
        if(sizeof($result)>0){
            return $result[0]["id"];
        }else{
            return 0;
        }
    }

    /**
     * 生成该用户的会员卡
     */
    public function createCard($param) {
        $sql=" INSERT INTO `c_user_card`
                    (
                     `cardNo`,
                     `userId`,
                     `balance`,
                     `point`,
                     `levelId`)
                      VALUES ('%s',%d ,%d, %d , %d )";
        $result=$this->db->execute($sql,$param);
        return execResult($result);
    }

    /**
     * @param $phone
     * @return mixed
     * 验证该手机号是否已注册
     */
    public function checkPhoneUnique($shopId,$phone) {
        $querySql = "SELECT 
                      id
                    FROM
                      c_user 
                    WHERE phone = '$phone'
                    and shopId='$shopId'";
        $result=$this->db->query($querySql);
        if(sizeof($result)>0){
            return $result[0]["id"];
        }else{
            return 0;
        }
    }

    /**
     * @param $openId
     * @return mixed
     * 判断该用户是否已关注
     */
    public function checkHasNotice($openId,$expire=7) {
        $querySql = "SELECT 
                      count(*) as total
                    FROM
                      c_user 
                    WHERE openId = '$openId'
                    and lastLoginTime > date_add(now(),interval - $expire day)";
        $result=$this->db->query($querySql);
        if(sizeof($result)>0){
            return $result[0]["total"];
        }else{
            return 0;
        }
    }

    /**
     * @param $accountId
     * @return mixed
     * 系统中是否存在该账号
     */
    public function getWtAccount($accountId) {
        $querySql = "SELECT 
                      shopId,
                      appId,
                      appSecret
                    FROM
                      wt_account 
                    WHERE id = '$accountId'";
        $result=$this->db->query($querySql);
        return result($result);
    }

    /**
     * @param $openid
     * @return mixed
     * 根据openid查询卡号信息
     */
    public function getUserCardInfo($openid) {
        $querySql = "SELECT 
                      c_user_card.cardno,
                      c_user.`realname`,
                      b_config_level.`levelname`,
                      c_user_card.`balance`/100 as balance,
                      c_user_card.`point`
                    FROM
                      c_user_card
                      LEFT JOIN c_user
                      ON c_user.id=c_user_card.userid
                      LEFT JOIN b_config_level
                      ON b_config_level.id=c_user_card.`levelId`
                    WHERE c_user.openid = '$openid'";
        $result=$this->db->query($querySql);
        return result($result);
    }

    /**
     * @param $openid
     * @return mixed
     * 根据openid查询信息
     */
    public function getUserInfo($openid) {
        $querySql = "SELECT                     
                      `realname`,
                      `birthday`,
                      `birthType`,
                      `phone`,
                      `headimgurl`,
                      `gender`                      
                    FROM `c_user`
                    WHERE openid = '$openid'";
        $result=$this->db->query($querySql);
        return result($result);
    }

    /**
     * 更新信息
     */
    public function editUserInfoByOpenId($openId,$param) {
        $result=M('c_user')->where("openid='".$openId."'")->data($param)->save();
        return execResult($result);
    }
 }