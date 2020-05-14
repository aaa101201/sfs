1.关于系统日志配置

1-1 线上环境设置
===Application/index.php====
define('APP_DEBUG', false);


===Application/Common/Conf/config.php===
'LOG_RECORD' => true, // 开启日志记录
'LOG_LEVEL'  =>'DEBUG', // 只记录EMERG ALERT CRIT ERR 错误	
'SHOW_PAGE_TRACE' =>false

1-2 测试环境
===Application/index.php====
define('APP_DEBUG', true);


===Application/Common/Conf/config.php===
//'LOG_RECORD' => true, // 开启日志记录
//'LOG_LEVEL'  =>'DEBUG', // 只记录EMERG ALERT CRIT ERR 错误	
'SHOW_PAGE_TRACE' =>true

注意：修改完配置后清除缓存使之生效
Application/Runtime/common~runtime.php