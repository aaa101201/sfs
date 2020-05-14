<?php

namespace Enum;

header("Content-Type: text/html; charset=utf-8");

class JsonEnum {

    CONST AJAX_DATA = "data";    //ajax返回的数据
    CONST AJAX_CODE = "code";    //ajax返回的业务编码
    CONST AJAX_MSG = "msg";    //ajax返回的message
    CONST AJAX_FILE_DATA = "file_data";    //ajax返回的数据

    CONST AJAX_CODE_SUCCESS = 0;    //ajax返回的数据
    CONST AJAX_CODE_FAILED = 1;    //ajax返回的数据
}

?>