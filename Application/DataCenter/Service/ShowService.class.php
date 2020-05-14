<?php
/**
 * Created by PhpStorm.
 * User: jiechengkeji
 * Date: 2017/7/20
 * Time: 10:57
 */

namespace DataCenter\Service;


use DataCenter\Dao\ShowDao;
use Think\Model;


class ShowService extends BaseService
{
    private static $showDao;
    private $db;

    public function __construct()
    {
        $this->db = new Model();
        self::$showDao = new ShowDao($this->db);
    }

    /*
     *
     */

    public function showPhone($showTimeStart, $showTimeEnd, $searchType, $page = 1, $pageSize = 10, $sessionId)
    {
        $this->loger('session', $sessionId);
        $data = self::$showDao->showPhone($showTimeStart, $showTimeEnd, $searchType, $page, $pageSize, $sessionId);
        $total = self::$showDao->showPhoneCount($showTimeStart, $showTimeEnd, $searchType, $sessionId);
        $this->loger('data', $data);
        $this->loger('total', $total);
        if ($data || $total) {
            return success_json('交易数据获取成功!', $data, $total);
        } else {
            return fail_json('拉取数据失败或者无交易数据！');
        }
    }
}