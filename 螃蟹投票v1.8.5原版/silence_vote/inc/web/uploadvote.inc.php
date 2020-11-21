<?php

goto VQZPh;
vkuQy:
if ($result) {
    goto UgEQm;
}
goto EYka8;
Jl61D:
no8Xg:
goto WxTNo;
E2Xlx:
goto NtH0q;
goto c0pjO;
zzKdV:
message("操作完成，成功" . $cture . "个，失败" . $cflase . "个。", $this->createWebUrl("votelist", array("name" => "silence_vote", "rid" => $rid)), "success");
goto Jl61D;
X5DJ6:
kpywo:
goto DFS7w;
Ft84t:
$cture = 0;
goto OX4Tm;
OX4Tm:
$cflase = 0;
goto PMbHS;
Cznxl:
NtH0q:
goto qJBb5;
QcdFs:
UgEQm:
goto rlu7D;
VYn4b:
$rid = intval($_GPC["rid"]);
goto Af700;
VQZPh:
defined("IN_IA") or exit("Access Denied");
goto WGDg3;
WGDg3:
global $_W, $_GPC;
goto DTvVL;
vFgrN:
$instdata["noid"] = $lastid[0]["noid"] + 1;
goto Htc2A;
T1X4t:
$lastid = pdo_getall($this->tablevoteuser, array("rid" => $rid, "uniacid" => $_W["uniacid"]), array("noid"), '', "noid DESC", array(1));
goto vFgrN;
jsNs5:
goto OSra3;
goto QcdFs;
DFS7w:
$k++;
goto E2Xlx;
qJBb5:
if (!($k < count($_POST["imgname"]))) {
    goto dAoEx;
}
goto KVMqA;
Htc2A:
$instdata["createtime"] = time();
goto BHcET;
DTvVL:
$op = $_GPC["op"];
goto VYn4b;
Af700:
if (!$_W["ispost"]) {
    goto no8Xg;
}
goto Ft84t;
PMbHS:
$k = 0;
goto Cznxl;
r0m2L:
OSra3:
goto X5DJ6;
EYka8:
$cflase++;
goto jsNs5;
BHcET:
$result = pdo_insert($this->tablevoteuser, $instdata);
goto vkuQy;
rlu7D:
$cture++;
goto r0m2L;
c0pjO:
dAoEx:
goto zzKdV;
KVMqA:
$instdata = array("rid" => $rid, "uniacid" => $_W["uniacid"], "avatar" => $_POST["imgurl"][$k], "name" => $_POST["imgname"][$k], "img1" => $_POST["imgurl"][$k], "introduction" => '', "status" => 1);
goto T1X4t;
WxTNo:
include $this->template("uploadvote");