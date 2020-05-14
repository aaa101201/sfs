<?php
/**
 * Created by PhpStorm.
 * User: rainbow
 * Date: 16/10/20
 * Time: 上午11:43
 */

namespace Tools;

class XAuth {

    public static function auth13($accessMap) {
        XLog::trackLog("__INFO__", __INFO__);
        if(isset($accessMap) && in_array(__INFO__, $accessMap)) {
            XLog::trackLog("auth13 successfully!", __INFO__);
            return true;
        } else {
            XLog::trackLog("auth13 failed!", __INFO__);
            return false;
        }
    }

}