<?php
/**
 * Created by PhpStorm.
 * User: jiechengkeji
 * Date: 2017/7/20
 * Time: 10:56
 */

namespace DataCenter\Controller;


use DataCenter\Service\ShowService;
use Enum\SessionEnum;

class ShowController extends AuthController
{
    private static $showservice;

    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        self::$showservice = new ShowService();
    }

    /*
     * 根据交易时间查询用户信息及交易金额查询
     */
    public function showPhone()
    {
        $showTimeStart = I('showtimestart');//检索的开始时间
        $showTimeEnd = I('showtimeend');//检索的结束时间
        $searchType = I('searchtype', '', 'intval');//交易类型 (充值：0，消费：1)
        $page = I('page', 1, 'intval');//分页：当前页数从 1 开始
        $pageSize = I('pageSize', 10, 'intval');//分页：每页显示的条数
        $sessionId = session(SessionEnum::SHOP_ID);//商家的id
        $result = self::$showservice->showPhone($showTimeStart, $showTimeEnd, $searchType, $page, $pageSize, $sessionId);
        $this->ajaxReturn($result);

    }
}