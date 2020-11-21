<?php

goto pXyMR;
joWQK:
$condition .= " AND commandword LIKE :keyword";
goto bDCZF;
Qm4Yr:
n3Abi:
goto cF54c;
FgWAN:
goto Vk4Sd;
goto oQn80;
mewHK:
if (!empty($item)) {
    goto jdYW5;
}
goto eH6RR;
RTqQS:
$cfg = $this->module["config"];
goto ttLDN;
IKMfs:
global $_W, $_GPC;
goto S9PXd;
xoWCn:
$sql = "SELECT * FROM " . tablename($this->modulename . "_commandvote") . $condition . $order_condition . " LIMIT " . ($pindex - 1) * $psize . "," . $psize;
goto eYdNH;
oIHEq:
//message("授权错误，请联系客服！", "referer", "error");
goto rsEn1;
KJBrh:
DEoLA:
goto CQCwC;
YsqyR:
wuAsO:
goto FyXZG;
LE40u:
goto Vk4Sd;
goto qZdo6;
acI9u:
$post_data = array("time" => time(), "ticket" => $cfg["ticket"], "module_id" => 3);
goto vhOKu;
JcttX:
$post_data["token"] = md5(sha1(implode('', $post_data)));
goto KweDg;
Fov_G:
foreach ($_GPC["idArr"] as $k => $id) {
    goto TxKw0;
    sXJhm:
    ADbb1:
    goto vGvmi;
    b85fx:
    EKlVn:
    goto sXJhm;
    QBPqf:
    pdo_delete($this->modulename . "_commandvote", array("id" => $id, "uniacid" => $uniacid));
    goto b85fx;
    QecIS:
    if (!$id) {
        goto EKlVn;
    }
    goto QBPqf;
    TxKw0:
    $id = intval($id);
    goto QecIS;
    vGvmi:
}
goto YsqyR;
BrxDq:
$id = intval($_GPC["id"]);
goto plttY;
Piew6:
$condition = " WHERE uniacid = {$uniacid} and rid = {$rid} and ismirror = 0";
goto tmrEo;
vWzuy:
goto Vk4Sd;
goto ybTbr;
JsMmd:
BKWyY:
goto voFSB;
ttLDN:
$url = $this->auth_url . "/index/vote/checkauth";
goto acI9u;
voVo1:
if ($result["sta"]) {
    goto NjeJX;
}
goto oIHEq;
qky4c:
$iscommandvote = pdo_fetchcolumn("SELECT iscommandvote FROM " . tablename($this->modulename . "_reply") . " WHERE rid = '{$rid}'");
goto xyJ7o;
P33ek:
if ($item) {
    goto MJ62P;
}
goto O5S7B;
MNGT1:
$keyword = trim($_GPC["keyword"]);
goto Piew6;
VWx8X:
goto DEoLA;
goto s2spd;
JKxEm:
message("请输入口令");
goto wfrue;
iVGiU:
$data = $_GPC["data"];
goto N72av;
kuzf0:
if (empty($keyword)) {
    goto EoAm2;
}
goto joWQK;
LU_B1:
$order_condition = " ORDER BY id DESC ";
goto xoWCn;
n6VPb:
Vk4Sd:
goto rCEHt;
PA914:
$pager = pagination($total, $pindex, $psize);
goto n6VPb;
tmrEo:
$params = array();
goto kuzf0;
ugBjP:
message("删除成功", $this->createWebUrl("commandvote", array("op" => "display", "rid" => $rid)), "success");
goto LE40u;
cggw5:
$psize = 15;
goto MNGT1;
r__9O:
$uniacid = !empty($_W["uniacid"]) ? $_W["uniacid"] : intval($_GET["uniacid"]);
goto MVwYN;
FbFEY:
message("请在活动里设置开启口令投票", $this->createWebUrl("manage"), "error");
goto KfpJC;
iAzZ7:
M9cCI:
goto vWzuy;
wnxcg:
EoAm2:
goto LU_B1;
Taefq:
if (!($item["uniacid"] != $uniacid)) {
    goto IKUUi;
}
goto PovuH;
ybTbr:
cn0ne:
goto XxltY;
oQdiE:
$operation = !empty($_GPC["op"]) ? $_GPC["op"] : "display";
goto r__9O;
rsEn1:
goto BKWyY;
goto hUJOC;
u9Kq2:
$data["rid"] = $rid;
goto vlziW;
QANsX:
MJ62P:
goto XwJIs;
OAGCA:
$data["mirrorid"] = 0;
goto sIhqo;
rCEHt:
$reply = pdo_fetch("SELECT * FROM " . tablename($this->tablereply) . " WHERE rid = :rid ORDER BY `id` DESC", array(":rid" => $_GPC["rid"]));
goto g2WYg;
KfpJC:
KxBTS:
goto k8atM;
bp5nC:
if ($operation == "deleteall") {
    goto WeYhK;
}
goto XEHhp;
eH6RR:
message("不存在或是已经被删除", $this->createWebUrl("commandvote", array("op" => "display", "rid" => $rid)), "error");
goto Haw83;
KkZFV:
$item = pdo_fetch("SELECT * FROM " . tablename($this->modulename . "_commandvote") . " WHERE id = {$id} and uniacid = {$uniacid}");
goto P33ek;
plttY:
$item = pdo_fetch("SELECT * FROM " . tablename($this->modulename . "_commandvote") . " WHERE id = '{$id}'");
goto mewHK;
Vj6Yj:
if (!empty($id)) {
    goto Yvccg;
}
goto BFEjh;
PovuH:
message("您没有权限编辑");
goto swv2i;
qZdo6:
WeYhK:
goto c4dfF;
DRAAJ:
if ($operation == "delete") {
    goto YXsen;
}
goto bp5nC;
O5S7B:
message("口令投票不存在");
goto QANsX;
CQCwC:
message("更新成功", $this->createWebUrl("commandvote", array("op" => "display", "rid" => $rid)), "success");
goto iAzZ7;
J5Sjg:
$content = ihttp_post($url, $post_data);
goto rJBpc;
pXyMR:
defined("IN_IA") or exit("Access Denied");
goto IKMfs;
vhOKu:
ksort($post_data);
goto JcttX;
voFSB:
load()->func("tpl");
goto j2sFi;
qC1Lt:
if ($operation == "display") {
    goto cn0ne;
}
goto FgWAN;
sIhqo:
pdo_insert($this->modulename . "_commandvote", $data);
goto VWx8X;
hUJOC:
NjeJX:
goto JsMmd;
k8atM:
$pindex = max(1, intval($_GPC["page"]));
goto cggw5;
FyXZG:
echo "{\"data\":\"删除成功\"}";
goto Sh4xO;
eYdNH:
$items = pdo_fetchall($sql, $params);
goto SZWsp;
mW5V6:
if (!checksubmit("submit")) {
    goto M9cCI;
}
goto iVGiU;
N72av:
if (!empty($data["commandword"])) {
    goto dicZj;
}
goto JKxEm;
rJBpc:
$result = json_decode($content["content"], true);
goto voVo1;
VXb5O:
nLDxu:
goto Fov_G;
mvBkx:
pdo_update($this->modulename . "_commandvote", $data, array("id" => $id));
goto KJBrh;
Sh4xO:
die;
goto Q84j2;
XwJIs:
PBTmU:
goto mW5V6;
SZWsp:
$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->modulename . "_commandvote") . $condition . $order_condition, $params);
goto PA914;
Q84j2:
goto Vk4Sd;
goto Qm4Yr;
MVwYN:
$rid = $_GPC["rid"];
goto DRAAJ;
KweDg:
load()->func("communication");
goto J5Sjg;
s2spd:
Yvccg:
goto mvBkx;
g2WYg:
$reply["config"] = @unserialize($reply["config"]);
goto Umhpe;
BFEjh:
$data["uniacid"] = $uniacid;
goto u9Kq2;
j2sFi:
$_W["page"]["title"] = "口令投票管理";
goto oQdiE;
xyJ7o:
if (!($iscommandvote == 0)) {
    goto KxBTS;
}
goto FbFEY;
Cf5nk:
$rid = $_GPC["rid"];
goto BhWb5;
cF54c:
$id = intval($_GPC["id"]);
goto Cf5nk;
bDCZF:
$params[":keyword"] = "%{$keyword}%";
goto wnxcg;
S9PXd:
checklogin();
goto RTqQS;
Haw83:
jdYW5:
goto Taefq;
c4dfF:
if (!(empty($_GPC["idArr"]) || !is_array($_GPC["idArr"]))) {
    goto nLDxu;
}
goto f22eu;
XxltY:
$rid = $_GPC["rid"];
goto qky4c;
wfrue:
dicZj:
goto Vj6Yj;
oQn80:
YXsen:
goto BrxDq;
OYvxs:
pdo_delete($this->modulename . "_commandvote", array("id" => $id), "OR");
goto ugBjP;
XEHhp:
if ($operation == "post") {
    goto n3Abi;
}
goto qC1Lt;
BhWb5:
if (!$id) {
    goto PBTmU;
}
goto KkZFV;
swv2i:
IKUUi:
goto OYvxs;
vlziW:
$data["ismirror"] = 0;
goto OAGCA;
f22eu:
message("不存在或是已经被删除", $this->createWebUrl("commandvote", array("op" => "display", "rid" => $rid)), "error");
goto VXb5O;
Umhpe:
include $this->template("commandvote");