<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/19
 * Time: 9:47
 */

namespace Admin\Controller;
use Admin\Service\UmemberService;

class UmemberController extends AuthController
{
    private static $UmemberService;

    public function _initialize() {
        parent::_initialize();
        self::$UmemberService = new UmemberService();
    }
    //个人中心页面
    public  function  Umember(){
        $result=self::$UmemberService->Umember();
        $this->loger('result', $result);
       // $this->ajaxReturn($result);
    }
    //执行Linux命令实现语音转码
    public function test_voice(){
        $str="cp -r /www/wwwroot/m.shulailo.cn/Uploads/CompanyLicense/2018-01-16/5a5d73bd80e55.png /www/wwwroot/music.shulailo.cn/attachs/photo/201712";
//        $str="ffmpeg -i /www/wwwroot/m.shulailo.cn/Uploads/CompanyLicense/2018-01-16/5a5d73bd80e55.png.mp3 -ac 1 -ar 8000  /www/wwwroot/hb.shulailo.cn/upload/".$name.".amr";
        exec($str);
    }
    //注册实名认证
    public function Umember_rz(){
        $mobile=I("uname");
//        $mobile='15666319057';
        $name=I("name");
        $id_number=I("id_number");
        $id_photo=I("id_photo");
        $result=self::$UmemberService->Umember_rz($mobile,$name,$id_number,$id_photo);
        $this->loger('result', $result);
        $this->ajaxReturn($result);
    }

    //装修日记申请
    public function Diary_s(){
        //日记标题
        $title=I('title');
        //装修小区
        $home_name=I('home_name');
        //承接公司
        $company=I('company');
        //空间户型
        $type=I('type');
        //装修方式
        $way=I('way');
        //合同总价
        $total_price=I('total_price');
        //开工日期
        $start_date=I('start_date');
        //完工日期
        $end_date=I('end_date');
        $localLicence=I("localLicence");


//        //日记标题
//        $title='ERWE';
//        //装修小区
//        $home_name='振华奥特莱斯';
//        //承接公司
//        $company='4';
//        //空间户型
//        $type='6';
//        //装修方式
//        $way='家装';
//        //合同总价
//        $total_price='ERWE';
//        //开工日期
//        $start_date='ERWE';
//        //完工日期
//        $end_date='ERWE';
//        $localLicence='ERWE';
        $result=self::$UmemberService->Diary_s($title,$home_name,$company,$type,$way,$total_price,$start_date,$end_date,$localLicence);
        $this->loger('result', $result);
        $this->ajaxReturn($result);
    }
    //装修日记修改查询
    public  function  Umember_rjcx(){
        $diary_id=I('diary_id');
//        $diary_id='4';
        $result=self::$UmemberService->Umember_rjcx($diary_id);
        $this->loger('result', $result);
        //$this->ajaxReturn($result);
    }
    //装修日记修改
    public  function  Umember_up(){
        $diary_id=I('diary_id');
//        $diary_id='4';
        //日记标题
        $title=I('title');
        //装修小区
        $home_name=I('home_name');
        //承接公司
        $company=I('company');
        //空间户型
        $type=I('type');
        //装修方式
        $way=I('way');
        //合同总价
        $total_price=I('total_price');
        //开工日期
        $start_date=I('start_date');
        //完工日期
        $end_date=I('end_date');
        $localLicence=I("localLicence");
        $result=self::$UmemberService->Umember_up($diary_id,$title,$home_name,$company,$type,$way,$total_price,$start_date,$end_date,$localLicence);
        $this->loger('result', $result);
        $this->ajaxReturn($result);
    }
    //装修日记预览
    public  function  Umember_y(){
        $pageNumber=I('pageNumber',1, 'intval');// 当前页，首页为1
        $pageSize = I('pageSize', 10, 'intval');// 分页用 每页数量
        $result=self::$UmemberService->Umember_y($pageNumber,$pageSize);
        $this->loger('result', $result);
       // $this->ajaxReturn($result);
    }
    //装修文章预览
    public  function  Umember_wz(){
        $diary_id=I('diary_id');
        $pageNumber=I('pageNumber',1, 'intval');// 当前页，首页为1
        $pageSize = I('pageSize', 10, 'intval');// 分页用 每页数量
        $result=self::$UmemberService->Umember_wz($diary_id,$pageNumber,$pageSize);
        $this->loger('result', $result);
        //$this->ajaxReturn($result);
    }
    //装修日记预览删除
    public  function  Umember_delete(){
        $diary_id=I('diary_id');
//        $diary_id='7';
        $result=self::$UmemberService->Umember_delete($diary_id);
        $this->loger('result', $result);
        $this->ajaxReturn($result);
    }
    //装修文章修改
    public  function  Umember_xg(){
        $item_id=I('item_id');
        $status=I('status');
        $content=I('content');

//        $item_id='12';
//        $status='5';
//        $content='csllll';
        $result=self::$UmemberService->Umember_xg($item_id,$status,$content);
        $this->loger('result', $result);
        $this->ajaxReturn($result);
    }
    //装修文章预览修改
    public  function  Umember_xgcx(){
        $item_id=I('item_id');
        $result=self::$UmemberService->Umember_xgcx($item_id);
        $this->loger('result', $result);
        //$this->ajaxReturn($result);
    }
    //装修文章插入
    public  function  Umember_cr(){
        $diary_id=I('diary_id');
        $status=I('status');
        $content=I('content');
//        $diary_id='4';
//        $status='2';
//        $content='dsgsd';
        $result=self::$UmemberService->Umember_cr($diary_id,$status,$content);
        $this->loger('result', $result);
        $this->ajaxReturn($result);
    }
    //装修文章删除
    public  function  Umember_wzd(){
        $item_id=I('item_id');
//        $item_id='12';
        $result=self::$UmemberService->Umember_wzd($item_id);
        $this->loger('result', $result);
        $this->ajaxReturn($result);
    }
    //装修文章施工阶段
    public  function  Umember_wzjd(){
        $result=self::$UmemberService->Umember_wzjd();
        $this->loger('result', $result);
    }
    //装修日记我的招标
    public  function  yuyue(){
        $result=self::$UmemberService->yuyue();
        $this->loger('result', $result);
    }
    //装修日记装修问题
    public  function  ask(){
        $pageNumber=I('pageNumber',1, 'intval');// 当前页，首页为1
        $pageSize = I('pageSize', 10, 'intval');// 分页用 每页数量
        $result=self::$UmemberService->ask($pageNumber,$pageSize);
        $this->loger('result', $result);
    }
    //装修日记我要回答
    public  function  ask_answer(){
        $pageNumber=I('pageNumber',1, 'intval');// 当前页，首页为1
        $pageSize = I('pageSize', 10, 'intval');// 分页用 每页数量
        $result=self::$UmemberService->ask_answer($pageNumber,$pageSize);
        $this->loger('result', $result);
    }
    //普通我的预约预约公司
    public  function  yuyue_company(){
        $result=self::$UmemberService->yuyue_company();
        $this->loger('result', $result);
    }
    //普通我的预约预约设计师
    public  function  yuyue_company_sjs(){
        $pageNumber=I('pageNumber',1, 'intval');// 当前页，首页为1
        $pageSize = I('pageSize', 10, 'intval');// 分页用 每页数量
        $result=self::$UmemberService->yuyue_company_sjs($pageNumber,$pageSize);
        $this->loger('result', $result);
    }
    //我的招标
    public  function  wdtb(){
        $pageNumber=I('pageNumber',1, 'intval');// 当前页，首页为1
        $pageSize = I('pageSize', 10, 'intval');// 分页用 每页数量
        $result=self::$UmemberService->wdtb($pageNumber,$pageSize);
        $this->loger('result', $result);
    }
    //普通我的预约预约商家
    public  function  yuyue_company_sj(){
        $result=self::$UmemberService->yuyue_company_sj();
        $this->loger('result', $result);
    }
    //我的订单
    public  function  order_index(){
        $order_status=I('order_status');
        $result=self::$UmemberService->order_index($order_status);
        $this->loger('result', $result);
        $this->ajaxReturn($result);
    }
    //订单已经取消
    public  function  order_index_b(){
        $order_id=I('order_id');
        $result=self::$UmemberService->order_index_b($order_id);
        $this->loger('result', $result);
        $this->ajaxReturn($result);
    }
    //确认收货
    public  function  order_index_c(){
        $pay_status=I('pay_status');
        $result=self::$UmemberService->order_index_c($pay_status);
        $this->loger('result', $result);
        $this->ajaxReturn($result);
    }
    //个人中心设计师详情页
    public  function  Umember_designer(){
        $result=self::$UmemberService->Umember_designer();
        $this->loger('result', $result);
    }
    //个人中心设计师文章预览
    public  function  Umember_designer_yl(){
        $pageNumber=I('pageNumber',1, 'intval');// 当前页，首页为1
        $pageSize = I('pageSize', 10, 'intval');// 分页用 每页数量
        $result=self::$UmemberService->Umember_designer_yl($pageNumber,$pageSize);
        $this->loger('result', $result);
    }
    //个人中心设计师文章删除
    public  function  Umember_designer_delete(){
        $article_id=I('article_id');
        $result=self::$UmemberService->Umember_designer_delete($article_id);
        $this->loger('result', $result);
        $this->ajaxReturn($result);
    }
    //个人中心设计师文章修改
    public  function  Umember_designer_update(){
        $title=I('title');
        $content=I('content');
        $result=self::$UmemberService->Umember_designer_update($title,$content);
        $this->loger('result', $result);
        $this->ajaxReturn($result);
    }
    //个人中心设计师文章添加
    public  function  Umember_designer_tj(){
        $title=I('title');
        $content=I('content');
        $result=self::$UmemberService->Umember_designer_tj($title,$content);
        $this->loger('result', $result);
        $this->ajaxReturn($result);
    }
    //个人中心设计师预览管理
    public  function  Umember_designer_yuyue(){
        $pageNumber=I('pageNumber',1, 'intval');// 当前页，首页为1
        $pageSize = I('pageSize', 10, 'intval');// 分页用 每页数量
        $result=self::$UmemberService->Umember_designer_yuyue($pageNumber,$pageSize);
        $this->loger('result', $result);
    }
    //个人中心设计师案例管理   这个现在没有用
    public  function  Umember_designer_Casee(){
        $result=self::$UmemberService->Umember_designer_Casee();
        $this->loger('result', $result);
        $this->ajaxReturn($result);
    }
    //个人中心设计师案例管理删除或个人中心装修公司案例管理删除  这个现在没有用
    public  function  Umember_designer_Caseesc(){
        $case_id=I('case_id');
        $result=self::$UmemberService->Umember_designer_Caseesc($case_id);
        $this->loger('result', $result);
        $this->ajaxReturn($result);
    }

    //个人中心装修公司案例管理  这个现在没有用
    public  function  Umember_company_Casee(){
        $result=self::$UmemberService->Umember_company_Casee();
        $this->loger('result', $result);
        $this->ajaxReturn($result);
    }
    //个人中心装修公司详情页
    public  function  Umember_company(){
        $result=self::$UmemberService->Umember_company();
        $this->loger('result', $result);
    }
    //个人中心装修公司企业新闻
    public  function  Umember_company_yl(){
        $pageNumber=I('pageNumber',1, 'intval');// 当前页，首页为1
        $pageSize = I('pageSize', 10, 'intval');// 分页用 每页数量
        $result=self::$UmemberService->Umember_designer_yl($pageNumber,$pageSize);
        $this->loger('result', $result);
    }
    //个人中心装修公司-企业新闻-添加新闻完成
    public  function  Umember_company_cr(){
        $title=I('title');
        $content=I('content');
//        $title='423423';
//        $content='dfds';
        $result=self::$UmemberService->Umember_designer_tj($title,$content);
        $this->loger('result', $result);
        $this->ajaxReturn($result);
    }
    //个人中心装修公司-企业新闻-添加新闻删除
    public  function  Umember_company_sc(){
        $article_id=I('article_id');
//         $article_id='23';
        $result=self::$UmemberService->Umember_designer_delete($article_id);
        $this->loger('result', $result);
        $this->ajaxReturn($result);
    }
    //个人中心装修公司-团队管理
    public  function  Umember_company_team(){
        $pageNumber=I('pageNumber',1, 'intval');// 当前页，首页为1
        $pageSize = I('pageSize', 10, 'intval');// 分页用 每页数量
        $result=self::$UmemberService->Umember_company_team($pageNumber,$pageSize);
        $this->loger('result', $result);
    }
    //个人中心装修公司-团队管理添加设计师
    public  function  Umember_company_tj(){
        $uname=I("uname");
        $passwd=I("passwd", "", "md5");// 密码
//        $uname='18628905199';
//        $passwd='123456';// 密码
        $result=self::$UmemberService->Umember_company_tj($uname,$passwd);
        $this->loger('result', $result);
        $this->ajaxReturn($result);
    }
    //个人中心装修公司-团队管理解雇
    public  function  Umember_company_jg(){
        $uid=I('uid');
//        $uid='110';
        $result=self::$UmemberService->Umember_company_jg($uid);
        $this->loger('result', $result);
        $this->ajaxReturn($result);
    }
    //个人中心装修公司-预约公司
    public  function  Umember_company_yuyue(){
        $result=self::$UmemberService->Umember_company_yuyue();
        $this->loger('result', $result);
    }
    //个人中心装修公司-预约设计师
    public  function  Umember_company_yuyuesjs(){
        $pageNumber=I('pageNumber',1, 'intval');// 当前页，首页为1
        $pageSize = I('pageSize', 10, 'intval');// 分页用 每页数量
        $result=self::$UmemberService->Umember_company_yuyuesjs($pageNumber,$pageSize);
        $this->loger('result', $result);
    }
    //个人中心装修公司-点评管理
    public  function  Umember_company_comment(){
        $pageNumber=I('pageNumber',1, 'intval');// 当前页，首页为1
        $pageSize = I('pageSize', 10, 'intval');// 分页用 每页数量
        $result=self::$UmemberService->Umember_company_comment($pageNumber,$pageSize);
        $this->loger('result', $result);
//        $this->ajaxReturn($result);
    }
    //个人中心装修公司-点击回复
    public  function  Umember_company_commenthf(){
        $comment_id=I('comment_id');
        $reply=I('reply');

//        $comment_id='3';
//        $reply='测试手机版';
        $result=self::$UmemberService->Umember_company_commenthf($comment_id,$reply);
        $this->loger('result', $result);
        $this->ajaxReturn($result);
    }
    //个人中心装修公司-招标预约
    public  function  Umember_company_tenders(){
        $result=self::$UmemberService->Umember_company_tenders();
        $this->loger('result', $result);
        $this->ajaxReturn($result);
    }
    //个人中心装修公司-我的投标
    public  function  Umember_company_tenderslooked(){
        $pageNumber=I('pageNumber',1, 'intval');// 当前页，首页为1
        $pageSize = I('pageSize', 10, 'intval');// 分页用 每页数量
        $result=self::$UmemberService->Umember_company_tenderslooked($pageNumber,$pageSize);
        $this->loger('result', $result);
    }
    //个人中心装修公司-在建工地
    public  function  Umember_company_site(){
        $result=self::$UmemberService->Umember_company_site();
        $this->loger('result', $result);
        //$this->ajaxReturn($result);
    }
    //个人中心装修公司-在建工地添加
    public  function  Umember_company_sitetj(){
        //地址
        $title=I('title');
         //公司地区
        $city_id='7';
        $area_id='3';
        //面积
        $house_mj=I('house_mj');
        //造价
        $price=I('price');
        //缩略图
        $thumb=I('thumb');
        $thumb = substr("$thumb", -34, 42); // 返回 "d"
        //小区名称
        $home_name=I('home_name');
        //装修案例
        $case_id=I('case_id');
        //地址
        $addr=I('addr');
        //简介
        $intro=I('intro');
        $result=self::$UmemberService->Umember_company_sitetj($title,$city_id,$area_id,$house_mj,$price,$thumb,$home_name,$case_id,$addr,$intro);
        $this->loger('result', $result);
        $this->ajaxReturn($result);
    }
    //个人中心装修公司-在建工地预览
    public  function  Umember_company_siteyl(){
        $site_id=I('site_id');
        $result=self::$UmemberService->Umember_company_siteyl($site_id);
        $this->loger('result', $result);
    }
    //个人中心装修公司-在建工地修改
    public  function  Umember_company_sitexg(){
        $site_id=I('site_id');
        //地址
        $title=I('title');
        //公司地区
        $city_id='7';
        $area_id='3';
        //面积
        $house_mj=I('house_mj');
        //造价
        $price=I('price');
        //缩略图
        $thumb=I('thumb');
        $thumb = substr("$thumb", -34, 42); // 返回 "d"
        //小区名称
        $home_name=I('home_name');
        //装修案例
        $case_id=I('case_id');
        //地址
        $addr=I('addr');
        //简介
        $intro=I('intro');
        $result=self::$UmemberService->Umember_company_sitexg($title,$city_id,$area_id,$house_mj,$price,$thumb,$home_name,$case_id,$addr,$intro,$site_id);
        $this->loger('result', $result);
        $this->ajaxReturn($result);
    }
    //个人中心装修公司-在建工地删除
    public  function  Umember_company_sitesc(){
        $site_id=I('site_id');
        $result=self::$UmemberService->Umember_company_sitesc($site_id);
        $this->loger('result', $result);
        $this->ajaxReturn($result);
    }
    //个人中心装修公司-在建工地工地日记
    public  function  Umember_company_diary(){
        $site_id=I('site_id');
        $result=self::$UmemberService->Umember_company_diary($site_id);
        $this->loger('result', $result);
    }
    //个人中心装修公司-在建工地工地日记添加
    public  function  Umember_company_diarytj(){
        $site_id=I('site_id');
        //施工阶段
        $status=I('status');
        //日记标题
        $title=I('title');
        //日记内容
        $content=I('content');
        $result=self::$UmemberService->Umember_company_diarytj($site_id,$status,$title,$content);
        $this->loger('result', $result);
        $this->ajaxReturn($result);
    }
    //个人中心装修公司-在建工地工地日记预览
    public  function  Umember_company_diaryly(){
        $item_id=I('item_id');
        $result=self::$UmemberService->Umember_company_diaryly($item_id);
        $this->loger('result', $result);
        $this->ajaxReturn($result);
    }
    //个人中心装修公司-在建工地工地日记修改
    public  function  Umember_company_diaryxg(){
        $item_id=I('item_id');
        $site_id=I('site_id');
        //施工阶段
        $status=I('status');
        //日记标题
        $title=I('title');
        //日记内容
        $content=I('content');
        $result=self::$UmemberService->Umember_company_diaryxg($site_id,$status,$title,$content,$item_id);
        $this->loger('result', $result);
        $this->ajaxReturn($result);
    }
    //个人中心装修公司-在建工地工地日记删除
    public  function  Umember_company_diarysc(){
        $item_id=I('item_id');
//        $item_id='2';
        $result=self::$UmemberService->Umember_company_diarysc($item_id);
        $this->loger('result', $result);
        $this->ajaxReturn($result);
    }
    //施工阶段
    public  function  Umember_company_sgjd(){
        $result=self::$UmemberService->Umember_company_sgjd();
        $this->loger('result', $result);
        $this->ajaxReturn($result);
    }
    //小区
    public  function  Umember_company_home(){
        $name=I('title');
        $result=self::$UmemberService->Umember_company_home($name);
        $this->loger('result', $result);
        //$this->ajaxReturn($result);
    }
    //承包公司
    public  function  Umember_company_cb(){
        $name=I('title');
        $result=self::$UmemberService->Umember_company_cb($name);
        $this->loger('result', $result);
       // $this->ajaxReturn($result);
    }
    ////空间户型
    public  function  type1(){
        $result=self::$UmemberService->type1();
        $this->loger('result', $result);
        $this->ajaxReturn($result);
    }
    ////空间户型
    public  function  type2(){
        $result=self::$UmemberService->type2();
        $this->loger('result', $result);
        $this->ajaxReturn($result);
    }
}