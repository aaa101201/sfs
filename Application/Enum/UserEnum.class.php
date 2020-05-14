<?php
/**
 * Created by PhpStorm.
 * User: Freeman
 * Date: 2016/11/8
 * Time: 16:05
 */

namespace Enum;


class UserEnum{
    //提现状态
    CONST AD_STATUS_STATE = 2;      //提现状态未提交
    CONST AD_STATUS_STATEE = 1;      //提现状态已提交
    //合同状态
    CONST HOMEMONEY_STATE = 2;      //待签署合同
    CONST HOMEMONEY_STATE1 = 1;      //已签署合同
    CONST AD_STATUS_PASSWORD = 123456;

    //微信表用户状态
    CONST WC_STATUS_REFUSED = 0;       //0:停用
    CONST WC_STATUS_ACTIVE = 1;      //1:启用
    //提现流水常量
    CONST  SURVEY_NAME1 = "签署合同款";
    //付款方式常量
    CONST  SURVEY_PAYMENT1 = "提现";
    //消费方式
    CONST  SURVEY_XF = 1;//提现类型
    CONST  SURVEY_XF1 = 2;//贷款消费类型
    //消费常量
    CONST  SURVEY_XFNAME = "消费";

    CONST  AD_STATUS_REFUSED = 2;
}