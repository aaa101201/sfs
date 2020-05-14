<?php

/**
 * 生成6位随机数字
 */
function build_number($length = 6) {
    // 密码字符集，可任意添加你需要的字符
    $chars = '0123456789';
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $password .= $chars[mt_rand(0, strlen($chars) - 1)];
    }
    return $password;
}

/**
 * @param $result
 * @return mixed
 * 处理PDO返回结果集
 */
function result($result) {
    $count = sizeof($result);
    if ($count > 1) {
        return $result;
    } else if ($count == 1) {
        return $result[0];
    } else {
        return 0;
    }
}

/**
 * @param $result
 * @return mixed
 * 处理PDO返回结果集
 */
function resultList($result) {
    return $result;
}

/**
 * @param $result
 * @return mixed
 * 处理EXEC返回结果集
 */
function execResult($result) {
    if (!isset($result)) {
        return false;
    }
    if ($result > 0) {
        return true;
    } else {
        return false;
    }
}


/**
 * @param string $msg
 * @param null $data
 * @param null $total
 * @return mixed请求成功
 */
function success_json_l($msg = "请求成功!", $data = null,  $ex1 = null) {
    $result['msg'] = $msg;
    $result['code'] = 0;
    $result['data']['result']=array();
    if ($data || is_array($data)) $result['data']['result'] = $data;
    if ($ex1) $result['pointtotal'] = $ex1;
    return $result;
}
function echo_res($code = 0, $msg = '', $data = [])
{
    $a = [];
    $a['code'] = $code;
    $a['msg'] = $msg;
    $a['data'] = $data;
    echo json_encode($a, JSON_UNESCAPED_UNICODE);
}
function success_json_o($msg = "请求成功!", $data = null,  $ex1 = null) {
    $result['msg'] = $msg;
    $result['code'] = 0;
    $result['data']=array();
    if ($data || is_array($data)) $result['data'] = $data;
    if ($ex1) $result['pointtotal'] = $ex1;
    $b= $result['data'][0];
    if ($b==''){
        $a= $result['data'];
        $result['data']=array();
        $result['data'][0]=$a;
    }
    return $result;
}
function success_json($msg = "请求成功!", $data = null,  $ex1 = null) {
    $result['msg'] = $msg;
    $result['code'] = 0;
    $result['data']=array();
    if ($data || is_array($data)) $result['data'] = $data;
    if ($ex1) $result['pointtotal'] = $ex1;
      $a= $result['data'][0];
        $result['data']=array();
        $result['data']=$a;
    return $result;
}
/**
 * @param string $msg
 * @param null $data
 * @param null $total
 * @return 多条成功
 */
function success_json_d($msg = "请求成功!", $data = null,$pageCurrent = 0,$recordTotal = 0,$pageTotal=0, $ex1 = null) {
    $result['msg'] = $msg;
    if ($data==null){
        $result['code'] = 1;
    }else{
        $result['code'] = 0;
    }
    $result['data']['result']=array();
    $result['data']['pageTotal']=0;
    $result['data']['pageCurrent']=0;
    if ($data || is_array($data)) $result['data']['result'] = $data;
    if ($recordTotal || $recordTotal == 0) $result['data']['recordTotal'] = $recordTotal;
    if ($pageTotal || $pageTotal == 0) $result['data']['pageTotal'] = $pageTotal;
    if ($pageCurrent || $pageCurrent == 0) $result['data']['pageCurrent'] = $pageCurrent;
    if ($ex1) $result['pointtotal'] = $ex1;
    return $result;
}
/**
 * @param string $msg
 * @return mixed请求失败
 */
function fail_json($msg = "请求失败!") {
    $result['msg'] = $msg;
    $result['code'] = 1;
    return $result;
}

/**
 * 导出xls
 * @param (array) $data
 * @param string $filename 文件名
 * @param (array) $title 每列的标题
 */
function create_xls($data, $filename = 'simple.xls', $title = array()) {
    ini_set('max_execution_time', '0');
    Vendor('PHPExcel.PHPExcel');
    $filename = str_replace('.xls', '', $filename) . '.xls';
    $phpexcel = new PHPExcel();
    $phpexcel->getProperties()
        ->setCreator("Maarten Balliauw")
        ->setLastModifiedBy("Maarten Balliauw")
        ->setTitle("Office 2007 XLSX Test Document")
        ->setSubject("Office 2007 XLSX Test Document")
        ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
        ->setKeywords("office 2007 openxml php")
        ->setCategory("Test result file");
    $phpexcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
    $dataArray = array($title);
    $phpexcel->getActiveSheet()->fromArray($dataArray, NULL, 'A1');
    $phpexcel->getActiveSheet()->fromArray($data, null, 'A2');
    $phpexcel->getActiveSheet()->setTitle('Sheet1');
    $phpexcel->setActiveSheetIndex(0);
    header('Content-Type: application/vnd.ms-excel');
    header("Content-Disposition: attachment;filename=$filename");
    header('Cache-Control: max-age=0');
    header('Cache-Control: max-age=1');
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
    header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header('Pragma: public'); // HTTP/1.0
    $objwriter = PHPExcel_IOFactory::createWriter($phpexcel, 'Excel5');
    $objwriter->save('php://output');
    exit;
}

function getSMSToken() {
    $time = time();
    $key = substr(md5($time . "YINGFANKEJI2018"), 6, 6);
    return array('key' => $key, 'time' => $time);
}

/**
 * @param $phone 发送验证码短信
 * @param $phonecaptcha
 * @return bool|mixed
 */
function sendSmsCode($phone, $code, $company = "") {
    $smsSend = C('X_SMS_SEND');
    if (!$smsSend) {
        return;
    }
    $params['token'] = getSMSToken(); //token验证
    $params['source'] = 'bewin.net';
    $params['password'] = md5('bewin123456');
    $params['phone'] = $phone;
    $params['templateId'] = 'BEWIN_COM_10001';
    $params['args'] = array($code, $company);
    $params['data'] = json_encode(array("code" => $code, "company" => $company));
    $params = array_merge($params);
    return request_post('http://sms.yingfankeji.net/index.php/Home/Index/send', http_build_query($params));
}


function request_get($url) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 500);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_URL, $url);

    $res = curl_exec($curl);
    curl_close($curl);

    return $res;
}

/**
 * 发送post请求
 * @param string $url
 * @param string $param
 * @return bool|mixed
 */
function request_post($url = '', $param = '') {
    if (empty($url) || empty($param)) {
        return false;
    }
    $postUrl = $url;
    $curlPost = $param;
    $ch = curl_init(); //初始化curl
    curl_setopt($ch, CURLOPT_URL, $postUrl); //抓取指定网页
    curl_setopt($ch, CURLOPT_HEADER, 0); //设置header
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //要求结果为字符串且输出到屏幕上
    curl_setopt($ch, CURLOPT_POST, 1); //post提交方式
    curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
    $data = curl_exec($ch); //运行curl
    curl_close($ch);
    return $data;
}

/**
 * 发送post请求 请求数据格式为application/x-www-form-urlencoded
 * @param string $url
 * @param string $param
 * @return bool|mixed
 */
function request_urlencode_post($url = '', $param = '') {
    if (empty($url) || empty($param)) {
        return false;
    }
    $postUrl = $url;
    $curl = $param;
    $ch = curl_init(); //初始化curl
    curl_setopt($curl, CURLOPT_URL, $postUrl);
    curl_setopt($curl, CURLOPT_USERAGENT, 'Opera/9.80 (Windows NT 6.2; Win64; x64) Presto/2.12.388 Version/12.15');
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // stop verifying certificate
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
    curl_setopt($curl, CURLOPT_POSTFIELDS, $param);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    $data = curl_exec($ch); //运行curl
    curl_close($ch);
    return $data;
}

/**
 * 验证码session
 */
function checkSessTime() {
    if (!$_SESSION) {
        header('content-type:text/html;charset=utf-8');
        die('<h1>session不存在</h1>');
    }
    $sess_end_time = time();//取当前时间     //读取Session中的时间戳
    if (C('SESSION_PREFIX')) {//如果session有前缀
        $sess_time = $_SESSION[C('SESSION_PREFIX')]['phone_time_stamp'];
    } else {//如果session没有前缀
        $sess_time = $_SESSION['phone_time_stamp'];
    }
    //session在10分钟后失效
    if ($sess_time + 10 * 60 < $sess_end_time) {
        unset($_SESSION['phonecaptcha']);
        unset($_SESSION['phone_time_stamp']);
    }
}