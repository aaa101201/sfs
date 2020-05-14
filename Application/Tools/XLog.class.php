<?php

/**
 * User: James.Yu<zhenzhouyu@jiechengkeji.cn>
 * Date: 16-3-23
 */

namespace Tools;

use Think\Log;

class XLog {

    // 跟踪日志
    public static function trackLog($title, $content, $source = 0, $type = "DEBUG") {
        if(!is_string($content)) {
            $content = json_encode($content);
        }

        $_prefix = "[ Jiechengkeji ]";
        $_date = "[ " . date("H:i:s", time()) . " ]";
        $title = "[ " . $title . " ]";
        Log::record($_prefix ." ". $_date ." ". $title . $content, $type);
    }
}