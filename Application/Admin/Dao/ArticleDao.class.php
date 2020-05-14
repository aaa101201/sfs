<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/8
 * Time: 9:46
 */

namespace Admin\Dao;


class ArticleDao extends  BaseDao
{
    public function _initialize($db) {
        parent::_initialize($db);
    }
    public function  Article_a(){
        $querySql = "SELECT 
	                    photo
                     FROM            
                        cy_article_lbphoto
                     ORDER BY
                	    id 
                	 DESC" ;
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public function  Article_b(){
        $querySql = "SELECT
	                     cat_id,
	                     title,
	                     photo
                     FROM
	                     cy_article_cate
                     WHERE
                          parent_id='8' 
                     LIMIT 0,3" ;
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public function  Article_c(){
        $querySql = "SELECT
	                     cat_id,
	                     title,
	                     photo
                     FROM
	                     cy_article_cate
                     WHERE
	                     parent_id = '9'" ;
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public function  Article_f(){
        $querySql = "SELECT
	                   article_id, 
	                   title ,
	                   from_unixtime(dateline,'%Y-%m-%d')  dateline
                     FROM
	                      cy_article a
                     WHERE
                         a.audit = '1'
                     AND
                          a.closed = '0'
                     AND 
                          a.`from`='article' " ;
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public function  Article_select(){
        $querySql = "SELECT
                         cat_id,
                         title
                      FROM
	                     cy_article_cate
                      WHERE
	                     parent_id = '16'" ;
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public function  Article_select1(){
        $querySql = "SELECT
                         cat_id,
                         title
                      FROM
	                     cy_article_cate
                      WHERE
	                     parent_id = '17'" ;
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public function  Article_select2(){
        $querySql = "SELECT
                         cat_id,
                         title
                     FROM
	                     cy_article_cate
                      WHERE
	                     parent_id = '18'" ;
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public function  Article_selectt(){
        $querySql = "SELECT
                         cat_id,
                         title
                      FROM
	                     cy_article_cate
                      WHERE
	                     parent_id = '18'" ;
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public function  Article_sfzsk($start,$pageSize){
        $querySql = "SELECT
                           a.article_id,
                           cat_id,
                           views,  
                           title,
	                       thumb,
	                       from_unixtime(dateline, '%Y-%m-%d') dateline
                     FROM
	                    cy_article a,
	                    cy_article_content b
                     WHERE
	                     a.article_id = b.article_id
                     AND 
                         a.audit = '1'
                     AND 
                         a.closed = '0'
                     AND 
                         a.`from` = 'article'
                            LIMIT " . $start . "," . $pageSize;
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public function setArticle_sfzsk()
    {
        $querySql = "SELECT 
	                  count(*) AS pageTotal
                     FROM
	                   cy_article a,
	                    cy_article_content b
                     WHERE
	                     a.article_id = b.article_id
                     AND 
                         a.audit = '1'
                     AND 
                         a.closed = '0'
                     AND 
                         a.`from` = 'article'";
        $result = $this->db->query($querySql);
        return  resultList($result);
    }
    public function setArticle_sfzs($cat_id)
    {
        $querySql = "SELECT 
	                  count(*) AS pageTotal
                     FROM
	                   cy_article a,
	                    cy_article_content b
                     WHERE
	                     a.article_id = b.article_id
                     AND 
                         a.audit = '1'
                     AND 
                         a.closed = '0'
                     AND 
                         a.`from` = 'article'
                          AND  
                         a.cat_id='$cat_id'";
        $result = $this->db->query($querySql);
        return  resultList($result);
    }
    public function  Article_sfzs($cat_id,$start,$pageSize){
        $querySql = "SELECT
                           a.article_id,
                           cat_id,
                           views,  
                           title,
	                       thumb,
	                       from_unixtime(dateline, '%Y-%m-%d') dateline
                     FROM
	                    cy_article a,
	                    cy_article_content b
                     WHERE
	                     a.article_id = b.article_id
                     AND 
                         a.audit = '1'
                     AND 
                         a.closed = '0'
                     AND 
                         a.`from` = 'article'
                     AND  
                         a.cat_id='$cat_id'
                            LIMIT " . $start . "," . $pageSize;
        $result = $this->db->query($querySql);
        return resultList($result);
    }

    public function  Article_l($article_id){
        $querySql = "SELECT
	                    a.cat_id,
	                    a.views,
	                    a.title,
	                    from_unixtime(a.dateline, '%Y-%m-%d') dateline,
	                    b.content,
	                   (
		                SELECT
			               COUNT(*)
		                FROM
			                cy_article_comment
		               WHERE
			             article_id = a.article_id
	                  )  count
                       FROM
	                      cy_article a,
	                      cy_article_content b
                      WHERE
	                      a.article_id = b.article_id
                      AND a.audit = '1'
                      AND a.closed = '0'
                      AND a.`from` = 'article'
                      AND  a.article_id='$article_id'" ;
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public function  Article_wz($cat_id){
        $querySql = "SELECT
	                      a.title,
	                      from_unixtime(a.dateline, '%Y-%m-%d') dateline
                      FROM
	                      cy_article a,
	                      cy_article_content b
                      WHERE
	                       a.article_id = b.article_id
                      AND a.audit = '1'
                      AND a.closed = '0'
                      AND a.`from` = 'article'
                      AND a.cat_id = '$cat_id'
                       LIMIT 0,5" ;
        $result = $this->db->query($querySql);
        return resultList($result);
    }
    public function  Article_xs($article_id,$start,$pageSize){
        $querySql = "SELECT
                       b.uid,
	                   a.uname,
	                   b.content,
	                  from_unixtime(a.dateline, '%Y-%m-%d') dateline
                     FROM
	                   cy_member a,
	                   cy_article_comment b
                    WHERE
	                    a.uid = b.uid
                   AND
                       b.article_id='$article_id'
                   LIMIT " . $start . "," . $pageSize;
        $result = $this->db->query($querySql);
        return resultList($result);
    }

    public function  setArticle_xs($article_id){
        $querySql = "SELECT
	                  count(*) AS pageTotal
                    FROM
	                    cy_member a,
	                   cy_article_comment b
                    WHERE
	                    a.uid = b.uid
                   AND
                       b.article_id='$article_id'";
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
    public function  Article_cr($article_id,$uid,$content,$closed,$dateline){
        $sql = "INSERT INTO cy_article_comment (
                    article_id,
                    uid,
                    content,
                    closed,
                    dateline
                ) 
                VALUES
                  (
                    '$article_id',
                    '$uid',
                    '$content',
                    '$closed',
                    '$dateline'
                  )";
        return execResult($this->db->execute($sql));
    }
}