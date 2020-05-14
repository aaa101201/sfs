<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/8
 * Time: 9:43
 */

namespace Admin\Controller;
use Admin\Service\ArticleService;
use Enum\SessionEnum;
class ArticleController extends  AuthController
{
    private  static $ArticleService;

    public  function  _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        self::$ArticleService=new ArticleService();
    }
    //首页
    public  function  Article_a(){
        $result=self::$ArticleService->Article_a();
        $this->loger('result', $result);
        $this->ajaxReturn($result);
    }
    //装修流程
    public  function  Article_b(){
        $result=self::$ArticleService->Article_b();
        $this->loger('result', $result);
        $this->ajaxReturn($result);
    }
    //装修学堂
    public  function   Article_c(){
        $result=self::$ArticleService->Article_c();
        $this->loger('result', $result);
        $this->ajaxReturn($result);
    }
    //热点推荐
    public  function   Article_f(){
        $result=self::$ArticleService->Article_f();
        $a=$result['data'];
        $result['data']=array();
        $result['data']['result']=$a;
        $this->loger('result', $result);
        $this->ajaxReturn($result);
    }
    //学装修-收房准备中等等选项
    public  function   Article_select(){
        $id=I("id");
        $result=self::$ArticleService->Article_select($id);
        $this->loger('result', $result);
    }

    //学装修-收房准备中显示
    public  function  Article_sfzs(){
        $cat_id = I("cat_id");
        $pageNumber=I('pageNumber',1, 'intval');// 当前页，首页为1
        $pageSize = I('pageSize', 10, 'intval');// 分页用 每页数量
        //下面测试
//        $cat_id='26';
        $result=self::$ArticleService->Article_sfzs($cat_id,$pageNumber,$pageSize);
        $this->loger('result', $result);
        $this->ajaxReturn($result);
    }
    //学装修-装修学堂选项
    public  function   Article_selectt(){
        $result=self::$ArticleService->Article_selectt();
        $this->loger('result', $result);
    }

    //装修课堂-文章详情
    public  function  Article_l(){
        $article_id = I("article_id");
        //下面测试
//        $article_id='36';
        $result=self::$ArticleService->Article_l($article_id);
        $this->loger('result', $result);
        //$this->ajaxReturn($result);
    }
    //装修课堂-相关文章
    public  function  Article_wz(){
        $cat_id = I("cat_id");
        //下面测试
//        $cat_id='26';
        $result=self::$ArticleService->Article_wz($cat_id);
        $this->loger('result', $result);
      //  $this->ajaxReturn($result);
    }
    //装修课堂-评论显示
    public  function  Article_xs(){
        $article_id = I("article_id");
        //下面测试
//        $article_id='26';
        $pageNumber=I('pageNumber',1, 'intval');// 当前页，首页为1
        $pageSize = I('pageSize', 10, 'intval');// 分页用 每页数量
        $result=self::$ArticleService->Article_xs($article_id,$pageNumber,$pageSize);
        $this->loger('result', $result);
      //  $this->ajaxReturn($result);
    }
    //装修课堂-评论插入
    public  function  Article_cr(){
        $article_id = I("article_id");
        $content = I("content");
        //下面测试
//        $article_id='26';
//        $uid='26';
//        //内容
//        $content=I('content');
        $dateline=time();
        $closed='0';
        $result=self::$ArticleService->Article_cr($article_id,$content,$closed,$dateline);
        $this->loger('result', $result);
        $this->ajaxReturn($result);
    }
}