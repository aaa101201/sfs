<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/8
 * Time: 9:45
 */

namespace Admin\Service;
use Admin\Controller\BaseController;
use Admin\Dao\ArticleDao;
use Think\Model;
use  Enum\SessionEnum;

class ArticleService extends BaseController
{
    private  static  $ArticleDao;
    private  $db;
    public  function  __construct()
    {
        $this->db=new  Model();
        self::$ArticleDao=new  ArticleDao($this->db);
    }


    public function  Article_a(){
        $result =self::$ArticleDao->Article_a();
        foreach($result as $k =>$v){
            if ($result[$k]['photo']==""){
                $result[$k]['photo']=SessionEnum::PHOTOo.'face/face.jpg';
            }else{
                $result[$k]['photo']=SessionEnum::PHOTOo.$result[$k]['photo'];
            }

        }
        $arr=array();
        foreach ($result as $value) {
            array_push($arr,  $value['photo']);
        }
        $result=array();
        $result[0]['sy']=$arr;
        $resultt =self::$ArticleDao->Article_b();
        foreach($resultt as $k =>$v){
            if ($resultt[$k]['photo']==""){
                $resultt[$k]['photo']=SessionEnum::PHOTOo.'face/face.jpg';
            }else{
                $resultt[$k]['photo']=SessionEnum::PHOTOo.$resultt[$k]['photo'];
            }
//            $resultt[$k]['photo']=SessionEnum::PHOTO.$resultt[$k]['photo'];

        }
        $result[0]['lc']=$resultt;
        $resultk =self::$ArticleDao->Article_c();
        foreach($resultk as $k =>$v){
            if ($resultk[$k]['photo']==""){
                $resultk[$k]['photo']=SessionEnum::PHOTOo.'face/face.jpg';
            }else{
                $resultk[$k]['photo']=SessionEnum::PHOTOo.$resultk[$k]['photo'];
            }

        }
        $result[0]['xy']=$resultk;
        $this->loger("result", $result);
        return success_json("数据获取成功", $result);
    }
    public function  Article_b(){
        $result =self::$ArticleDao->Article_a();
        foreach($result as $k =>$v){
            if ($result[$k]['photo']==""){
                $result[$k]['photo']=SessionEnum::PHOTO.'face/face.jpg';
            }else{
                $result[$k]['photo']=SessionEnum::PHOTOo.$result[$k]['photo'];
            }

        }
        $arr=array();
        foreach ($result as $value) {
            array_push($arr,  $value['photo']);
        }
        $this->loger("result", $arr);
        return success_json_o("数据获取成功", $arr);
    }
    public function  Article_c(){
        $result =self::$ArticleDao->Article_c();
        foreach($result as $k =>$v){
            if ($result[$k]['photo']==""){
                $result[$k]['photo']=SessionEnum::PHOTO.'face/face.jpg';
            }else{
                $result[$k]['photo']=SessionEnum::PHOTOo.$result[$k]['photo'];
            }
        }
        $this->loger("result", $result);
        return success_json("数据获取成功", $result);
    }
    public function Article_f(){
        $result =self::$ArticleDao->Article_f();
        $this->loger("result", $result);
        return success_json_o("数据获取成功", $result);
    }
    public function  Article_select($id){
    if ($id==1){
        $result =self::$ArticleDao->Article_select();
    }
    if ($id==2){
        $result =self::$ArticleDao->Article_select1();

    }
    if ($id==3){
        $result =self::$ArticleDao->Article_select2();

    }
    if ($result==null){
        echo_res(1,"没有数据");
        return ;
    }else{
        $data = [];
        if ($result[0]==null){
            $data['result'][0]=$result;
        }else{
            $data['result'] = $result;
        }
        echo_res(0,"正确格式", $data);
        return ;
    }
}
    public function  Article_selectt(){
            $result =self::$ArticleDao->Article_selectt();
        if ($result==null){
            echo_res(1,"没有数据");
            return ;
        }else{
            $data = [];
            if ($result[0]==null){
                $data['result'][0]=$result;
            }else{
                $data['result'] = $result;
            }
            echo_res(0,"正确格式", $data);
            return ;
        }
    }
    public function  Article_sfzs($cat_id,$pageNumber,$pageSize){
        $pageSizee=$pageNumber*$pageSize;
        $start=$pageSizee-$pageSize;
        if ($cat_id==''){
            $result =self::$ArticleDao->Article_sfzsk($start,$pageSize);
            $pageTotal = self::$ArticleDao->setArticle_sfzsk();
            foreach($result as $k =>$v){
                $thumb=$result[$k]['thumb'];
                if ($thumb==""){
                    $result[$k]['thumb']=SessionEnum::PHOTO.'face/face.jpg';
                }else{
                    $result[$k]['thumb']=SessionEnum::PHOTO.$thumb;
                }
            }
            $pageCurrent=intval($pageNumber);
            $pageTotal =intval($pageTotal['0']['pagetotal']);
            $recordTotal=ceil($pageTotal/$pageSize);
        }else{
            $result =self::$ArticleDao->Article_sfzs($cat_id,$start,$pageSize);
            $pageTotal = self::$ArticleDao->setArticle_sfzs($cat_id);
            foreach($result as $k =>$v){
                $thumb=$result[$k]['thumb'];
                if ($thumb==""){
                    $result[$k]['thumb']=SessionEnum::PHOTO.'face/face.jpg';
                }else{
                    $result[$k]['thumb']=SessionEnum::PHOTO.$thumb;
                }
            }
            $pageCurrent=intval($pageNumber);
            $pageTotal =intval($pageTotal['0']['pagetotal']);
            $recordTotal=ceil($pageTotal/$pageSize);
        }
        $this->loger("result", $result);
        return success_json_d("数据获取成功", $result,$pageCurrent,$pageTotal,$recordTotal);
    }
    public function  Article_l($article_id){
        $result =self::$ArticleDao->Article_l($article_id);
        $pageTotal = self::$ArticleDao->setArticle_xs($article_id);
        $pageTotal=intval($pageTotal['0']['pagetotal']);
        $data = [];
        $data['cat_id'] = $result[0]['cat_id'];
        $data['views'] = $result[0]['views'];
        $data['title'] = $result[0]['title'];
        $data['dateline'] = $result[0]['dateline'];
        $data['content'] = $result[0]['content'];
        $data['count'] = $result[0]['count'];
        $data['commentTotal'] = $pageTotal;
        echo_res(0,"装修课堂-文章详情", $data);
        return ;
    }
    public function  Article_wz($cat_id){
        $result =self::$ArticleDao->Article_wz($cat_id);
        $this->loger("result", $result);
        if ($result==null){
            echo_res(1,"没有数据");
            return ;
        }else{
            $data = [];
            if ($result[0]==null){
                $data['result'][0]=$result;
            }else{
                $data['result'] = $result;
            }
            echo_res(0,"正确格式", $data);
            return ;
        }
    }
    public function  Article_xs($article_id,$pageNumber,$pageSize){
        $pageSizee=$pageNumber*$pageSize;
        $start=$pageSizee-$pageSize;
        $result =self::$ArticleDao->Article_xs($article_id,$start,$pageSize);
        foreach($result as $k =>$v){
            $thumb=$result[$k]['face'];
            if ($thumb==""){
                $result[$k]['face']=SessionEnum::PHOTO.'face/face.jpg';
            }else{
                $result[$k]['face']=SessionEnum::PHOTO.$thumb;
            }
        }
        $pageTotal = self::$ArticleDao->setArticle_xs($article_id);
        $pageCurrent=intval($pageNumber);
        $pageTotal=intval($pageTotal['0']['pagetotal']);
        $recordTotal=ceil($pageTotal/$pageSize);
        if ($result==null){
            $data['recordTotal'] = $recordTotal;
            $data['pageCurrent'] = $pageCurrent;
            $data['pageTotal'] = $pageTotal;
            if ($result[0]==null){
                $data['result'][0]=$result;
            }else{
                $data['result'] = $result;
            }
            echo_res(1,"装修课堂-评论显示", $data);
            return ;
        }else{
            $data = [];
            if ($result[0]==null){
                $data['result'][0]=$result;
            }else{
                $data['result'] = $result;
            }
            $data['recordTotal'] = $recordTotal;
            $data['pageCurrent'] = $pageCurrent;
            $data['pageTotal'] = $pageTotal;
            echo_res(0,"装修课堂-评论显示", $data);
            return ;
        }
    }
    public function  Article_cr($article_id,$content,$closed,$dateline){
        $uname=$_SESSION;
        $uname=$uname['user']['uname'];
        if ($uname==""){
            return fail_json("请登录!");
        }
        $uid=self::$ArticleDao->cy_compay_uid($uname);
        $uid=$uid[0]['uid'];
        $result =self::$ArticleDao->Article_cr($article_id,$uid,$content,$closed,$dateline);
        if (empty($result)) {
            return fail_json("插入评论失败!");
        } else {
            return success_json_o("插入评论成功");
        }
    }
}