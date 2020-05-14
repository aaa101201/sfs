<?php

namespace Admin\Behavior;

use Think\Behavior;
use Enum\SessionEnum;

/**
 * Class TestBehavior
 * @package Home\Behavior
 * 记录系统日志的行为类
 */
class SystemLogBehavior extends Behavior
{

    public function run(&$params) {
        $loginUser=session(SessionEnum::USER_INFO);
        // 系统日志表
        $SystemLog = M('system_log');
        $data["path"] = $params["path"];
        $data["inputData"] = json_encode($params["input"]);
        $data["outputData"] = json_encode($params["output"]);
        $data["userId"] = $loginUser["id"];
        $data["userName"] = $loginUser["name"];
        $data["operaName"] = $params["operaName"];
        $data["ipAddress"] = get_client_ip();
        // 保存系统日志信息
        $SystemLog
            ->data($data)
            ->add();
    }
}