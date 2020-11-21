<?php
  global $_W, $_GPC;
        //include 'duiba.php';
        include IA_ROOT.'/addons/tiger_newhu/duiba.php';
        $settings = $this->module['config'];
        $request_array = $_GPC;
        foreach ($request_array as $key => $val) {
            $unsetkeyarr = array('i', 'do', 'm', 'c','module_status:1','module_status:tiger_shouquan','module_status:tiger_newhu','notice','state');
            if (in_array($key, $unsetkeyarr) || strstr($key, '__')) {
                unset($request_array[$key]);
            }
        }
        //file_put_contents(IA_ROOT."/addons/tiger_newhu/tkl_duiban.txt","\n".json_encode($request_array),FILE_APPEND);
//    echo "<pre>";
//      print_r($request_array);
//      exit;
        $ret = parseCreditNotify($settings['AppKey'], $settings['appSecret'], $request_array);
        if (is_array($ret) && $ret['success'] == "true") {        	
            $order = pdo_fetch("SELECT * FROM " . tablename($this->modulename."_dborder") . " WHERE  uniacid = :uniacid AND orderNum = :orderNum ", array(':uniacid' => $_W['uniacid'], ':orderNum' => $ret['orderNum']));
            if ($order['status'] == 0) {
                $result = pdo_update($this->modulename."_dborder", array('status' => 1, 'endtimestamp' => $request_array['timestamp']), array('id' => $order['id']));
                if (!empty($result)) {
                    exit('ok');
                }
            } elseif ($order['status'] == 1) {
                exit('ok');
            }
        } elseif (is_array($ret) && $ret['success'] == "false") {
            $order = pdo_fetch("SELECT * FROM " . tablename($this->modulename."_dborder") . " WHERE  uniacid = :uniacid  AND ordernum = :ordernum ", array(':uniacid' => $_W['uniacid'], ':orderNum' => $ret['orderNum']));
            if ($order['status'] != 2) {
                $result = pdo_update($this->modulename."_dborder", array('status' => 2, 'endtimestamp' => $request_array['timestamp']), array('id' => $order['id']));
                if (!empty($result)) {
                    $updatecredit = mc_credit_update($request_array["uid"], 'credit1', abs($request_array["credits"]), array("积分宝", "兑吧兑换失败，退还积分"));
                    if (!empty($updatecredit)) {
                        exit('ok');
                    }
                }
            } elseif ($order['status'] == 2) {
                exit('ok');
            }
        }
?>