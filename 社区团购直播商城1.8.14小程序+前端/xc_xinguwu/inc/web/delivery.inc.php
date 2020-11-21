<?php
global $_W, $_GPC, $xcmodule, $xcconfig;
$xtitlea = "";
$xtitleb = "";
if (strlen($_GPC["xtitlea"]) > 0) {
    $xtitlea = urldecode($_GPC["xtitlea"]);
}
if (strlen($_GPC["xtitleb"]) > 0) {
    $xtitleb = urldecode($_GPC["xtitleb"]);
}
$table = $xcmodule . "_" . "other";
$op = strlen($_GPC['op']) > 1 ? $_GPC['op'] : 'list';
$do = $_GPC['do'];

//李晨
switch ($op) {
    case "edit": {
        $xc = array();
        $params['uniacid'] = $_W["uniacid"];
        $params['keyval'] = 'express';
        $xc = pdo_get($table, $params);
        $xc['contents'] = iunserializer($xc['contents']);

        if ($xc['contents']['setting']) {
            foreach ($xc['contents']['setting'] as &$item) {
                if ($item['citys']) {

                    $item['citys'] = json_encode($item['citys'], JSON_UNESCAPED_UNICODE);

                }
            }
        }
        include $this->template("mymanage/" . strtolower($_GPC["do"]) . "/" . $op);
        exit();
    }
    case "save": {

        $postdata=array();
        $postdata['default'] = $_GPC['default'];
        $postdata['express'] = $_GPC['express'];
        $data['status'] = $_GPC['status'];
        $postdata['setting'] = $_GPC['setting'];
        $postdata['calculatetype'] = $_GPC['calculatetype'];
        $postdata['notarea'] = $_GPC['notarea'];



        $data['contents'] = iserializer($postdata);

        $parawhere = array();
        $parawhere["uniacid"] = $_W["uniacid"];
        $parawhere["keyval"] = "express";

        $pmodel = pdo_get($table, $parawhere);
        $ret = -1;
        if ($pmodel) {
            $data['modifytime'] = date('Y-m-d H:i:s');
            $ret = pdo_update($table, $data,$parawhere);
        } else {
            $data['modifytime'] = date('Y-m-d H:i:s');
            $data['uniacid'] = $_W["uniacid"];
            $data['keyval'] = "express";
            $ret = pdo_insert($table, $data);
        }

        $status = $ret > 0 ? 1 : -1;
        xc_message($status, null);
    }

}
exit();