<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
error_reporting(E_ALL);
ini_set('display_errors','On');
define('IN_MOBILE', true);
require '../../framework/bootstrap.inc.php';
$input = file_get_contents('php://input');

file_put_contents(dirname(__FILE__).'/pay.txt',date('Y-m-d H:i:s').var_export($input,true)."\n",FILE_APPEND);
$isxml = true;
if (!empty($input) && empty($_GET['out_trade_no'])) {
    $obj = isimplexml_load_string($input, 'SimpleXMLElement', LIBXML_NOCDATA);
    $data = json_decode(json_encode($obj), true);
    if (empty($data)) {
        $result = array(
            'return_code' => 'FAIL',
            'return_msg' => ''
        );
        echo array2xml($result);
    }
    if ($data['result_code'] != 'SUCCESS' || $data['return_code'] != 'SUCCESS') {
        $result = array(
            'return_code' => 'FAIL',
            'return_msg' => empty($data['return_msg']) ? $data['err_code_des'] : $data['return_msg']
        );
        echo array2xml($result);
    }
    $get = $data;
} else {
    $isxml = false;
    $get = $_GET;
}
if($_GET['out_trade_no'] == '201804041735580713') {
    $isxml = true;
}
if($isxml) {
    $site = WeUtility::createModuleSite('wg_fenxiao');
    $method = 'doMobilepayresult';

    $result = $site->$method($get);
    if($result === 0) {
        $result = array(
            'return_code' => 'SUCCESS',
            'return_msg' => 'OK'
        );
        echo array2xml($result);
    } else {
        file_put_contents(dirname(__FILE__).'/pay.txt',date('Y-m-d H:i:s').var_export($result,true)."\n",FILE_APPEND);
        echo('fail');
    }

}
exit;