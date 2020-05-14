<?php
return array(

    //系统配置
   // 'X_AUTH' => true, // auth验证
    'SHOW_PAGE_TRACE' =>false,
    'X_SMS_SEND'=>true,
    //'LOG_RECORD' => true, // 开启日志记录
    //'LOG_LEVEL'  =>'DEBUG', // 只记录EMERG ALERT CRIT ERR 错误
    /* 数据库设置 */
//    'DB_TYPE'               =>  'mysql',     // 数据库类型
//    'DB_HOST'               =>  '127.0.0.1', // 服务器地址
//    'DB_NAME'               =>  'whjz365',  // 数据库名
//    'DB_USER'               =>  'whjz365',      // 用户名
//    'DB_PWD'                =>  'aideguodu1',          // 密码
//    'DB_PREFIX'             =>  '',    // 数据库表前缀
//    'DB_CHARSET'            =>  'utf8',      // 数据库编码默认采用utf8

    //本地数据库配置
	'DB_TYPE'=>'mysql',// 数据库类型
	'DB_HOST'=>'localhost',// 服务器地址
	'DB_NAME'=>'whjz',// 数据库名
	'DB_USER'=>'root',// 用户名
	'DB_PWD'=>'',// 密码
	'DB_PORT'=>3306,// 端口
    'DEFAULT_MODULE'=>'Admin',
	'DB_CHARSET'=>'utf8',// 数据库字符集
    'DB_PREFIX'=>'',// 数据库表前缀

    // 阿里云OSS相关配置
	'OSS_ENDPOINT' => "oss-cn-beijing.aliyuncs.com",
    'OSS_ACCESS_KEY_ID' => "I0kThHwa60ISiCRK",
    'OSS_ACCESS_KEY_SECRET' => 'VpRMwZQ2xFeWDaj2ZgiEAU5AELKoF9',
	'OSS_URL' => 'http://bewin-image.oss-cn-beijing.aliyuncs.com/',
	'OSS_BUCKET' => 'bewin-image',

    // Wechat相关配置
    'WT_ACCOUNT' => '微会员系统',
    'WT_APP_TOKEN' => 'bewin_yingfankeji',

    //投票系统参数设置
    'LIMITED_URL_HEADER' => 'http://bewin.yingfankeji.net/index.php/Home/Vote/vote',
    'UNLIMITED_URL_HEADER' => 'http://bewin.yingfankeji.net/index.php/Home/Vote/infi_vote',

    'WT_ACCOUNT_URL' => 'http://bewin.yingfankeji.net/index.php/Home/Index/',
);