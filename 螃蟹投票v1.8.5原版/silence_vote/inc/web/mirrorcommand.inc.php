<?php

goto SrFCY;
Jj59O:
G3Ubc:
goto jRw54;
N1PoH:
$operation = !empty($_GPC["op"]) ? $_GPC["op"] : "display";
goto iV54S;
Fer42:
if (!empty($data["commandword"])) {
    goto n59sq;
}
goto T2UWF;
gAnz7:
goto n64AG;
goto Jj59O;
zW8_j:
$keyword = trim($_GPC["keyword"]);
goto zcAPL;
oUdTA:
$content = ihttp_post($url, $post_data);
goto mFLbK;
tfLwm:
if (empty($keyword)) {
    goto K6ITy;
}
goto Dran3;
XL7Q4:
if (!(!empty($maxmirrorcommandps) && $data["commandpiaoshu"] > $maxmirrorcommandps)) {
    goto rEed1;
}
goto pZKw7;
jIdWm:
$items = pdo_fetchall($sql, $params);
goto RAcrz;
RkLwt:
$rid = $_GPC["rid"];
goto W25VS;
Xhbvx:
pm2MT:
goto WG4NJ;
kPck0:
n64AG:
goto Z3D2S;
gfuVv:
$url = $this->auth_url . "/index/vote/checkauth";
goto S6NhN;
y3R25:
$order_condition = " ORDER BY id DESC ";
goto etNVR;
S6NhN:
$post_data = array("time" => time(), "ticket" => $cfg["ticket"], "module_id" => 3);
goto QafCM;
JDPKb:
$data["uniacid"] = $uniacid;
goto MNR83;
VGNAP:
WKPoP:
goto hkhfE;
Rak3B:
$pager = pagination($total, $pindex, $psize);
goto kPck0;
Csow1:
if (!($item["uniacid"] != $uniacid)) {
    goto PuwFo;
}
goto NzRX6;
oWnYJ:
$psize = 15;
goto zW8_j;
W25VS:
if (!$id) {
    goto hdS0I;
}
goto nB6c5;
ESiuA:
if (!checksubmit("submit")) {
    goto cfIHE;
}
goto vbF4c;
zcAPL:
$condition = " WHERE uniacid = {$uniacid} and rid = {$rid} and ismirror = 1 and mirrorid = {$mirrorid}";
goto nLWz9;
hnrgd:
$data["mirrorid"] = $mirrorid;
goto C5Xl6;
QgkWJ:
message("不存在或是已经被删除", $this->createWebUrl("mirrorcommand", array("op" => "display", "rid" => $rid, "mirrorid" => $mirrorid)), "error");
goto f58_8;
WmNOT:
goto knEr3;
goto i49Cf;
g3n3v:
$maxmirrorcommandps = pdo_fetchcolumn("SELECT maxmirrorcommandps FROM " . tablename($this->tablereply) . " WHERE rid = :rid ORDER BY `id` DESC", array(":rid" => $rid));
goto XL7Q4;
Dran3:
$condition .= " AND commandword LIKE :keyword";
goto ogoei;
i49Cf:
jyFS8:
goto LeipJ;
RAcrz:
$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->modulename . "_commandvote") . $condition . $order_condition, $params);
goto Rak3B;
MNR83:
$data["rid"] = $rid;
goto ygu1d;
RzPmJ:
echo "{\"data\":\"删除成功\"}";
goto oVDeE;
Z6rOs:
goto n64AG;
goto KxU9M;
KxU9M:
o2aq3:
goto Gsqjf;
Z9TvP:
message("更新成功", $this->createWebUrl("mirrorcommand", array("op" => "display", "rid" => $rid, "mirrorid" => $mirrorid)), "success");
goto ilwLN;
PR2Es:
if (!empty($id)) {
    goto jyFS8;
}
goto JDPKb;
ogoei:
$params[":keyword"] = "%{$keyword}%";
goto yjd6l;
sWlzW:
if ($result["sta"]) {
    goto WKPoP;
}
goto IUHoR;
SrFCY:
defined("IN_IA") or exit("Access Denied");
goto foHrT;
vUvH_:
goto n64AG;
goto y_W1g;
USCRA:
if ($operation == "display") {
    goto zTHwS;
}
goto Z6rOs;
ruJyZ:
$item = pdo_fetch("SELECT * FROM " . tablename($this->modulename . "_commandvote") . " WHERE id = '{$id}'");
goto s2qtC;
JCPRW:
if (!(empty($_GPC["idArr"]) || !is_array($_GPC["idArr"]))) {
    goto VgkYE;
}
goto gGl2a;
jRw54:
$id = intval($_GPC["id"]);
goto RkLwt;
ml43M:
message("请在镜像所属的活动里设置开启口令投票", $this->createWebUrl("manage"), "error");
goto Xhbvx;
pn6Zu:
zTHwS:
goto RobpF;
foHrT:
global $_W, $_GPC;
goto Ev_56;
j2LKJ:
if ($operation == "deleteall") {
    goto mKl2P;
}
goto x2aU2;
RobpF:
$rid = $_GPC["rid"];
goto hVyRu;
miZMH:
$post_data["token"] = md5(sha1(implode('', $post_data)));
goto e7vun;
vbF4c:
$data = $_GPC["data"];
goto Fer42;
nLWz9:
$params = array();
goto tfLwm;
iV54S:
$uniacid = !empty($_W["uniacid"]) ? $_W["uniacid"] : intval($_GET["uniacid"]);
goto izIgn;
NOZiz:
load()->func("tpl");
goto SeCG2;
hkhfE:
s1b14:
goto NOZiz;
izIgn:
$rid = $_GPC["rid"];
goto GgHsP;
LNz62:
hdS0I:
goto ESiuA;
Gsqjf:
$id = intval($_GPC["id"]);
goto ruJyZ;
EF30a:
PuwFo:
goto DYg0u;
yjd6l:
K6ITy:
goto y3R25;
oVDeE:
die;
goto gAnz7;
DYg0u:
pdo_delete($this->modulename . "_commandvote", array("id" => $id), "OR");
goto HZWYl;
oYD_w:
if ($item) {
    goto x0_5p;
}
goto v8V0S;
GgHsP:
$mirrorid = $_GPC["mirrorid"];
goto Vtfkx;
f58_8:
Ga74I:
goto Csow1;
HZWYl:
message("删除成功", $this->createWebUrl("mirrorcommand", array("op" => "display", "rid" => $rid, "mirrorid" => $mirrorid)), "success");
goto vUvH_;
mFLbK:
$result = json_decode($content["content"], true);
goto sWlzW;
ZF2uy:
MVfQZ:
goto RzPmJ;
QafCM:
ksort($post_data);
goto miZMH;
e7vun:
load()->func("communication");
goto oUdTA;
scB47:
$cfg = $this->module["config"];
goto gfuVv;
nB6c5:
$item = pdo_fetch("SELECT * FROM " . tablename($this->modulename . "_commandvote") . " WHERE id = {$id} and uniacid = {$uniacid}");
goto oYD_w;
Ev_56:
checklogin();
goto scB47;
pZKw7:
message("抵票数请不要超过原活动设置的" . $maxmirrorcommandps . "票");
goto JquYX;
NzRX6:
message("您没有权限编辑");
goto EF30a;
F3Bww:
n59sq:
goto g3n3v;
GdN5J:
goto s1b14;
goto VGNAP;
k72Xh:
knEr3:
goto Z9TvP;
ilwLN:
cfIHE:
goto iUxzi;
v8V0S:
message("口令投票不存在");
goto QyJCj;
ygu1d:
$data["ismirror"] = 1;
goto hnrgd;
WG4NJ:
$pindex = max(1, intval($_GPC["page"]));
goto oWnYJ;
SeCG2:
$_W["page"]["title"] = "镜像口令投票管理";
goto N1PoH;
JquYX:
rEed1:
goto PR2Es;
m4q1N:
foreach ($_GPC["idArr"] as $k => $id) {
    goto XQ88v;
    hQzY5:
    a6FiW:
    goto lOKpf;
    ARjOO:
    Pfqcu:
    goto hQzY5;
    XQ88v:
    $id = intval($id);
    goto LgocD;
    OVrXr:
    pdo_delete($this->modulename . "_commandvote", array("id" => $id, "uniacid" => $uniacid));
    goto ARjOO;
    LgocD:
    if (!$id) {
        goto Pfqcu;
    }
    goto OVrXr;
    lOKpf:
}
goto ZF2uy;
etNVR:
$sql = "SELECT * FROM " . tablename($this->modulename . "_commandvote") . $condition . $order_condition . " LIMIT " . ($pindex - 1) * $psize . "," . $psize;
goto jIdWm;
T2UWF:
message("请输入口令");
goto F3Bww;
QyJCj:
x0_5p:
goto LNz62;
LeipJ:
pdo_update($this->modulename . "_commandvote", $data, array("id" => $id));
goto k72Xh;
Vtfkx:
if ($operation == "delete") {
    goto o2aq3;
}
goto j2LKJ;
y_W1g:
mKl2P:
goto JCPRW;
IUHoR:
//message("授权错误，请联系客服！", "referer", "error");
goto GdN5J;
j00GP:
if (!($iscommandvote == 0)) {
    goto pm2MT;
}
goto ml43M;
iUxzi:
goto n64AG;
goto pn6Zu;
nfy0T:
VgkYE:
goto m4q1N;
gGl2a:
message("不存在或是已经被删除", $this->createWebUrl("mirrorcommand", array("op" => "display", "rid" => $rid, "mirrorid" => $mirrorid)), "error");
goto nfy0T;
hVyRu:
$iscommandvote = pdo_fetchcolumn("SELECT iscommandvote FROM " . tablename($this->modulename . "_reply") . " WHERE rid = '{$rid}'");
goto j00GP;
C5Xl6:
pdo_insert($this->modulename . "_commandvote", $data);
goto WmNOT;
s2qtC:
if (!empty($item)) {
    goto Ga74I;
}
goto QgkWJ;
x2aU2:
if ($operation == "post") {
    goto G3Ubc;
}
goto USCRA;
Z3D2S:
include $this->template("mirror_commandvote");