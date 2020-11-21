<?php

goto HYpmH;
WF51e:
$filename = "用户（" . $id . "）信息" . "_" . $rid . "_" . $now;
goto DG6Id;
eMGWH:
$now = date("Y-m-d H:i:s", time());
goto WF51e;
nSH3F:
yfpLk:
goto WTwrr;
Yb385:
foreach ($list as $mid => $value) {
    goto OHOPT;
    Io6pN:
    $html .= "\n";
    goto lHAik;
    lHAik:
    mAzoC:
    goto wE7hJ;
    zcVxv:
    $html .= $value["phonesys"] . "--" . $value["phonetype"] . "\t ,";
    goto yOVUD;
    kn1ok:
    $html .= $value["id"] . "\t ,";
    goto qoJeM;
    qoJeM:
    $html .= htmlspecialchars($value["nickname"]) . "\t ,";
    goto u1ynK;
    AfG92:
    $value["phonetype"] = $phoneinfo ? $phoneinfo[1] : '';
    goto WotVf;
    RFVpP:
    $html .= getIPLoc_QQ($value["user_ip"]) . "\t ,";
    goto zcVxv;
    yOVUD:
    $html .= "活动已投:" . $value["totaltp"] . "对选手已投:" . $value["totalxstp"] . "\t ,";
    goto m8d3Q;
    m8d3Q:
    $html .= date("Y-m-d H:i:s", $value["createtime"]) . "\t ,";
    goto Io6pN;
    u1ynK:
    $html .= $value["openid"] . "\t ,";
    goto keUjg;
    jOJEq:
    $value["totalxstp"] = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->tablevotedata) . " WHERE uniacid = '{$uniacid}' AND rid = '{$rid} '  and openid = '{$value["openid"]}' and tid = {$value["tid"]}");
    goto kn1ok;
    WotVf:
    $value["totaltp"] = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->tablevotedata) . " WHERE uniacid = '{$uniacid}' AND rid = '{$rid} '  and openid = '{$value["openid"]}' ");
    goto jOJEq;
    keUjg:
    $html .= $value["user_ip"] . "\t ,";
    goto RFVpP;
    OHOPT:
    $phoneinfo = json_decode($value["phoneinfo"], true);
    goto qD8QF;
    qD8QF:
    $value["phonesys"] = $phoneinfo ? $phoneinfo[0] : '';
    goto AfG92;
    wE7hJ:
}
goto nSH3F;
vuWr4:
$psize = 500;
goto pdx85;
VLBFf:
AQrRP:
goto q2WzL;
A7udG:
$pindex = $_GPC["page"];
goto vuWr4;
eo1Iw:
$uniacid = $_W["uniacid"];
goto YsmNR;
Ykv10:
$rid = intval($_GPC["rid"]);
goto eo1Iw;
fRZ_u:
header("Content-Disposition:attachment; filename=" . $filename . ".csv");
goto k3Cyg;
Fq7T_:
d4lUT:
goto lHCmG;
hBj3W:
q21wk:
goto KG_nb;
DG6Id:
header("Content-type:text/csv");
goto fRZ_u;
dsZA2:
message("抱歉，传递的参数错误！", '', "error");
goto VLBFf;
avKf4:
if ($_GPC["page"] > 0) {
    goto zVRAN;
}
goto O28SH;
EJbdU:
goto q21wk;
goto EuR38;
WTwrr:
$html .= "\n";
goto eMGWH;
k8n0G:
$html .= "\n";
goto Yb385;
A5FfL:
$html = "﻿";
goto TvmPz;
O28SH:
$list = pdo_fetchall("SELECT * FROM " . tablename($this->tablevotedata) . " WHERE uniacid = '{$uniacid}' AND rid = '{$rid} '  {$condition} ");
goto EJbdU;
KG_nb:
load()->model("mc");
goto G8qm1;
J1NkE:
$id = intval($_GPC["id"]);
goto Ykv10;
TvmPz:
foreach ($tableheader as $value) {
    $html .= $value . "\t ,";
    N_ti8:
}
goto eZt2N;
YsmNR:
if (!(empty($rid) || empty($id))) {
    goto AQrRP;
}
goto dsZA2;
HYpmH:
if (!(PHP_SAPI == "cli")) {
    goto d4lUT;
}
goto rXUvw;
G8qm1:
$tableheader = array("id", "用户", "openid", "ip", "ip地址", "手机信息", "投票信息", "投票时间");
goto A5FfL;
q2WzL:
$condition .= " AND votetype=0  AND tid = '{$id} '";
goto avKf4;
EuR38:
zVRAN:
goto A7udG;
pdx85:
$list = pdo_fetchall("SELECT * FROM " . tablename($this->tablevotedata) . " WHERE uniacid = '{$uniacid}' AND rid = '{$rid} '  {$condition} LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
goto hBj3W;
k3Cyg:
echo $html;
goto bLt7Q;
lHCmG:
global $_GPC, $_W;
goto J1NkE;
rXUvw:
die("This example should only be run from a Web Browser");
goto Fq7T_;
eZt2N:
D9GcG:
goto k8n0G;
bLt7Q:
exit;