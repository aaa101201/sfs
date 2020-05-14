<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/9
 * Time: 10:09
 */

namespace Admin\Dao;


class ShopDao extends  BaseDao
{
    public function _initialize($db) {
        parent::_initialize($db);
    }
    public function cy_shop_cate()
    {
        $querySql = "SELECT
	cat_id id ,
	title  name 
FROM
	cy_shop_cate
WHERE
	cat_id in ('1','2','3','4','5')";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public function cy_shop_splb()
    {
        $querySql = "SELECT
	cat_id id ,
	title  name 
FROM
	cy_shop_cate
WHERE
	cat_id in ('350','2','3','4','5')";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    /**
     * 设置检索条件
     */
    private function setWhere($mr,$xl,$jg,$cat_id)
    {
        $where = "   where 
                           b.audit=1
                      and
                           b.closed=0  ";
        if (!empty($cat_id) || !$cat_id== null) {
            $where .= " and b.cat_id = '" . $cat_id . "'";
        }
        if ($mr=='90') {
            $where .= "   ORDER BY a.is_vip desc";
        }
        if ($jg=='92') {
            $where .= " ORDER BY  b.price";
        }
        return $where;
    }
    public  function setFitmentConut($mr,$xl,$jg,$cat_id){
        $where = $this->setWhere($mr,$xl,$jg,$cat_id);
        $querySql = "SELECT 
	                  count(*) AS pageTotal
                     FROM
                           cy_product b
                        $where";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public function cy_shop_syxq($mr,$xl,$jg,$cat_id,$start,$pageSize)
    {
        $where = $this->setWhere($mr,$xl,$jg,$cat_id);
        $querySql = "SELECT 
	                      distinct  
	                      b.photo,
	                      b.product_id,
	                     (SELECT name  FROM  cy_shop where shop_id=b.shop_id) gsname,
	                      b.name nameb,
	                      b.price,
	                      b.market_price
                     FROM
                           cy_product b
	                              $where
	                 LIMIT " . $start . "," . $pageSize;
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public function cy_shop_sjqb($shop_id,$start,$pageSize)
    {
        $querySql = "SELECT 
	                      distinct  
	                      b.photo,
	                      b.product_id,
	                      b.name,
	                      b.price,
	                      b.market_price
                     FROM
                          cy_product b
	                 WHERE
	                      shop_id='$shop_id'
	                 LIMIT " . $start . "," . $pageSize;
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public function cy_shop_cateb($id)
{
    $querySql = "SELECT
	cat_id id ,
	title  name 
FROM
	cy_shop_cate
WHERE
	parent_id ='$id'";
    $result = $this->db->query($querySql);
    return resultList($result);
}
    public function cy_shop_s()
    {
        $querySql = "SELECT
title,
attr_value_id
FROM
	cy_data_attr_value
WHERE
	attr_id ='21'";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public function  cy_shop_photosy(){
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
    public function cy_shop_catebc($id)
    {
        $querySql = "SELECT
	cat_id id ,
	title  name 
FROM
	cy_shop_cate
WHERE
	parent_id ='$id'";
        $result = $this->db->query($querySql);
        return resultList($result);
    }

    public function cy_shop_lb($cat_id)
    {
        $querySql = "SELECT 
                       shop_id,
	                   name,
	                   score,
	                   views,
	                   logo,
	                   products,
	                   (SELECT addr  FROM  cy_shop_fields where shop_id=a.shop_id) addr
                     FROM
	                  cy_shop a     
                      where             
                      a.cat_id='$cat_id'";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function setCy_shop_lb($cat_id){
        $querySql = "SELECT 
	                  count(*) AS pageTotal
                     FROM
	                      cy_shop a     
                     where             
                        a.cat_id='$cat_id'";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public function  cy_shop_sjxq($shop_id){
        $querySql = "SELECT 
                      (SELECT banner FROM cy_shop_fields where shop_id=cy_shop.shop_id) photo,
                       name,
                       logo,
                       info,
                       (SELECT addr  FROM  cy_shop_fields where shop_id=cy_shop.shop_id) addr,
                       (SELECT hours  FROM  cy_shop_fields where shop_id=cy_shop.shop_id) hours,
                       score
                    FROM  cy_shop
	                  WHERE 
	                 shop_id='$shop_id' " ;
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public function  cy_shop_xq($product_id){
        $querySql = "SELECT
                      shop_id,
                      product_id,
	                   photo,
	                   name,
	                   market_price,
	                   price,
	                   sale_sku,
                           freight,
                           (SELECT title  FROM  cy_shop_vcate where shop_id=cy_product.shop_id) fl,
                          (SELECT info  FROM  cy_shop_fields where shop_id=cy_product.shop_id) gsinfo,
(SELECT name  FROM  cy_shop where shop_id=cy_product.shop_id) gsname,
(SELECT logo  FROM  cy_shop where shop_id=cy_product.shop_id) logo,
(SELECT title  FROM  cy_shop_cate where cat_id=cy_product.cat_id) title,
(SELECT   count(*) AS count FROM  cy_product_comment) count,
  (SELECT info  FROM  cy_product_fields where product_id=cy_product.product_id) info
                     FROM
	                  cy_product
	                  WHERE 
	                 product_id='$product_id' " ;
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function cy_compay_uid($phone){
        $querySql = "SELECT
	                      uid
                     FROM
	                      cy_member 
                     WHERE
                      uname = '$phone'";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function views($shop_id){
        $querySql = "SELECT
	                      views
                     FROM
	                       cy_shop 
                     WHERE
                      shop_id = '$shop_id'";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function cy_shop_spfl($shop_id){
        $querySql = "SELECT
	                      vcat_id,
	                      title
                     FROM
	                       cy_shop_vcate 
                     WHERE
                      shop_id = '$shop_id'";
        $result = $this->db->query($querySql);
        return resultList($result);
    }

    public  function cy_shop_spjj($shop_id){
        $querySql = "SELECT 
                        title,
                        contact,
                        phone,
                        (SELECT addr  FROM  cy_shop_fields where shop_id=cy_shop.shop_id) addr,
                        info
                       (SELECT title  FROM  cy_shop_cate where  cat_id=cy_shop.cat_id) title
                        FROM  cy_shop 
                     WHERE
                      shop_id = '$shop_id'";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public function  cy_shop_gwc($uid,$product_id,$dateline){
        $querySql = "UPDATE 
                         cy_member 
                      SET 
                          cart = '$product_id',
                          dateline = '$dateline'
                      WHERE 
                          uid=$uid";
        return $this->db->execute($querySql);
    }
    public  function cy_shop_gwa($uid){
        $querySql = "SELECT 
                       cart
                        FROM  cy_member 
                     WHERE
                      uid = '$uid'";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function product($product_id){
        $querySql = "SELECT 
                       name,price
                        FROM  product_id 
                     WHERE
                      product_id = '$product_id'";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public  function cy_shop_ddxxan($order_id){
        $querySql = "SELECT 
                       name,price
                        FROM  cy_order 
                     WHERE
                      order_id = '$order_id'";
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public function  cy_shop_spzx($name,$phone,$address,$shop_id,$product_id,$uid,$dateline,$clinetip){
        $sql = "INSERT INTO cy_shop_yuyue (
                    city_id,
                    contact,
                    mobile,
                    address,
                    shop_id,
                    product_id,
                    uid,
                    dateline,
                    clientip,
                    status
                ) 
                VALUES
                  (
                    '7',
                    '$name',
                    '$phone',
                    '$address',
                    '$shop_id',
                    '$product_id',
                    '$uid',
                    '$dateline',
                    '$clinetip',
                    '0'
                  )";
        return execResult($this->db->execute($sql));
    }
    public function  cy_shop_ddxxa($order_id,$product_id,$product_name,$product_price,$number,$amount){
        $sql = "INSERT INTO cy_order_product (
                    order_id,
                    product_id,
                    product_name,
                    spec_id,
                    spec_name,
                    product_price,
                    number,
                    freight,
                    amount
                ) 
                VALUES
                  (
                    '$order_id',
                    '$product_id',
                    '$product_name',
                    '0',
                    '',
                    '$product_price',
                    '0.00',
                    '$number',
                    '$amount'
                  )";
        return execResult($this->db->execute($sql));
    }
    public function  cy_shop_ddxx($order_no,$uid,$shop_id,$addr,$mobile,$note,$product_count,$product_number,$product_amount,$contact,$clinetip,$dateline){
        $sql = "INSERT INTO cy_order (
                    order_no,
                    uid,
                    shop_id,
                    product_count,
                    product_number,
                    product_amount,
                    freight,
                    amount,
                    contact,
                    mobile,
                    addr,
                    note,
                    pay_status,
                    pay_time,
                    order_status,
                    audit,
                    closed,
                    clientip,
                    dateline
                ) 
                VALUES
                  (
                    '$order_no',
                    '$uid',
                    '$shop_id',
                    '$product_count',
                    '$product_number',
                    '$product_amount',
                    '0.00',
                    '$product_amount',
                    '$contact',
                    '$mobile',
                    '$addr',
                    '$note',
                    '0',
                    '0',
                    '0',
                    '0',
                    '0',
                    '$clinetip',
                     '$dateline',
                  )";
        return execResult($this->db->execute($sql));
    }
    public function cy_shop_spgz($shop_id,$views,$dateline)
    {
        $querySql = "UPDATE 
                         cy_shop 
                      SET 
                         views='$views',
                         dateline='$dateline'
                      WHERE 
                          shop_id=$shop_id";
        return $this->db->execute($querySql);
    }
}