<?php

goto OzxC0;
fFcHi:
$post_data["token"] = md5(sha1(implode('', $post_data)));
goto RucTt;
jLijD:
NfRTN:
goto rTlWR;
iWM4z:
goto j9NWY;
goto U6Pqn;
RySNR:
echo "{\"data\":\"更新成功\"}";
goto J3VrH;
EcuP6:
$rid = $_GPC["rid"];
goto a76GC;
U6Pqn:
JYO_v:
goto xsTkK;
Hw9Sl:
$id = intval($_GPC["id"]);
goto cvQH1;
klwtO:
if (!empty($item)) {
    goto K4koY;
}
goto lxPKW;
eaxwV:
global $_W, $_GPC;
goto L9Z87;
lxPKW:
message("不存在或是已经被删除", $this->createWebUrl("saiqumanage", array("op" => "display")), "error");
goto fK7qN;
BG3Oc:
$reply_id = $_GPC["reply_id"];
goto TH2eL;
IlCgt:
di8Jo:
goto QtWaw;
X7tw6:
message("不存在或是已经被删除", $this->createWebUrl("saiqumanage", array("op" => "display")), "error");
goto td2H4;
QgYgB:
if ($operation == "delete") {
    goto N0Z69;
}
goto TvSwH;
u8CRP:
$reply_id = $_GPC["reply_id"];
goto EcuP6;
DcKYJ:
goto j9NWY;
goto AbqJA;
QjB5d:
pdo_update($this->modulename . "_saiqu", $data, array("id" => $id));
goto Qa0Ms;
ld1DZ:
bqSUM:
goto gP3Xx;
nz4I1:
$item = pdo_fetch("SELECT * FROM " . tablename($this->modulename . "_saiqu") . " WHERE id = {$id} and uniacid = {$uniacid}");
goto fvWiN;
evuMn:
$post_data = array("time" => time(), "ticket" => $cfg["ticket"], "module_id" => 3);
goto QaskD;
RucTt:
load()->func("communication");
goto lB4pt;
V57yi:
pdo_delete($this->modulename . "_saiqu", array("id" => $id), "OR");
goto BY18L;
mpoIj:
$reply = pdo_fetch("SELECT * FROM " . tablename($this->tablereply) . " WHERE rid = :rid ORDER BY `id` DESC", array(":rid" => $_GPC["rid"]));
goto NQPXN;
gZAJC:
foreach ($_GPC["idArr"] as $k => $id) {
    goto dQJwY;
    GyjGT:
    pdo_delete($this->modulename . "_saiqu", array("id" => $id, "uniacid" => $uniacid));
    goto vgh8H;
    py5kt:
    ykWXa:
    goto F4iFS;
    dQJwY:
    $id = intval($id);
    goto DOgJf;
    vgh8H:
    GHRO4:
    goto py5kt;
    DOgJf:
    if (!$id) {
        goto GHRO4;
    }
    goto GyjGT;
    F4iFS:
}
goto NwI9j;
ECVvp:
qxJIZ:
goto ba5d5;
d67y8:
$uniacid = !empty($_W["uniacid"]) ? $_W["uniacid"] : intval($_GET["uniacid"]);
goto QgYgB;
YITVP:
$data = $_GPC["data"];
goto Wi1ss;
Q0oI8:
$params = array();
goto vDZMU;
fvWiN:
if ($item) {
    goto PhXZl;
}
goto kwZRN;
QaskD:
ksort($post_data);
goto fFcHi;
a76GC:
$pindex = max(1, intval($_GPC["page"]));
goto rlKhz;
td2H4:
cvp4i:
goto gZAJC;
tuayM:
PhXZl:
goto jLijD;
CoE_p:
$id = intval($_GPC["id"]);
goto zLtHy;
RqqLj:
$items = pdo_fetchall($sql, $params);
goto VL7GI;
mGc9Q:
JL4gG:
goto ZC2k4;
QKL1n:
if ($operation == "display") {
    goto QetBZ;
}
goto b1sjO;
j6vR2:
pdo_update($this->modulename . "_reply", array("saiqustatus" => $status), array("rid" => $rid));
goto RySNR;
gP3Xx:
goto j9NWY;
goto pXaqH;
VeReJ:
if (!$check) {
    goto qxJIZ;
}
goto MbtLZ;
VEp5_:
if (!($data["saiquname"] != $item["saiquname"])) {
    goto vLzZv;
}
goto J3pdL;
NwI9j:
ms3Ig:
goto kIB2h;
SGDIG:
goto SaQ4E;
goto hMVdR;
wm9R1:
$cfg = $this->module["config"];
goto ycR2h;
NQPXN:
$reply["config"] = @unserialize($reply["config"]);
goto jEvrs;
czhPo:
message("更新成功", $this->createWebUrl("saiqumanage", array("op" => "display", "rid" => $rid, "reply_id" => $reply_id)), "success");
goto ld1DZ;
SsFVt:
$result = json_decode($content["content"], true);
goto ucoqe;
MbtLZ:
message("赛区已存在");
goto ECVvp;
aFRne:
if (!$check) {
    goto QZI13;
}
goto tsl2D;
zLtHy:
$item = pdo_fetch("SELECT * FROM " . tablename($this->modulename . "_saiqu") . " WHERE id = '{$id}'");
goto klwtO;
ycR2h:
$url = $this->auth_url . "/index/vote/checkauth";
goto evuMn;
wlTyR:
$keyword = trim($_GPC["keyword"]);
goto LX0UW;
Qa0Ms:
SaQ4E:
goto czhPo;
Nwe0v:
goto Ko7H1;
goto IlCgt;
WWoBf:
if (!(empty($_GPC["idArr"]) || !is_array($_GPC["idArr"]))) {
    goto cvp4i;
}
goto X7tw6;
rTlWR:
if (!checksubmit("submit")) {
    goto bqSUM;
}
goto YITVP;
uRd3G:
goto j9NWY;
goto r8LPx;
AbqJA:
C9hxs:
goto WWoBf;
hQ7EY:
//message("授权错误，请联系客服！", "referer", "error");
goto Nwe0v;
fK7qN:
K4koY:
goto igmwE;
TCuz0:
GgUi2:
goto V57yi;
TH2eL:
$rid = $_GPC["rid"];
goto Hw9Sl;
BY18L:
message("删除成功", referer(), "success");
goto DcKYJ;
ucoqe:
if ($result["sta"]) {
    goto di8Jo;
}
goto hQ7EY;
hMVdR:
U3hjc:
goto VEp5_;
dVRT2:
$check = pdo_fetch("select * from " . tablename($this->modulename . "_saiqu") . " where saiquname = '{$data["saiquname"]}' and rid = {$rid} and uniacid = {$uniacid}");
goto aFRne;
LX0UW:
$condition = " WHERE uniacid = {$uniacid} and rid = {$rid}";
goto Q0oI8;
wxrYH:
$condition .= " AND saiquname like '%{$keyword}%'";
goto DF7Kp;
dUvKS:
if (!empty($id)) {
    goto U3hjc;
}
goto dVRT2;
kIB2h:
echo "{\"data\":\"删除成功\"}";
goto sOoTI;
rlKhz:
$psize = 15;
goto wlTyR;
peyF6:
$operation = !empty($_GPC["op"]) ? $_GPC["op"] : "display";
goto d67y8;
igmwE:
if (!($item["uniacid"] != $uniacid)) {
    goto GgUi2;
}
goto nAM28;
OSIKX:
QZI13:
goto ReHTn;
Kmb0O:
j9NWY:
goto mpoIj;
J3pdL:
$check = pdo_fetch("select * from " . tablename($this->modulename . "_saiqu") . " where saiquname = '{$data["saiquname"]}' and rid = {$rid} and uniacid = {$uniacid}");
goto VeReJ;
r8LPx:
N0Z69:
goto CoE_p;
VL7GI:
foreach ($items as $key => $value) {
    goto gkqlA;
    gkqlA:
    $u = $_W["siteroot"] . "app/" . $this->createMobileUrl("index", array("rid" => $rid, "saiquid" => $value["id"], "op" => "originurl"));
    goto CqJba;
    ANk8Q:
    LPptQ:
    goto emEc_;
    CqJba:
    $items[$key]["saiquurl"] = $u;
    goto ANk8Q;
    emEc_:
}
goto mGc9Q;
f8I4d:
$_W["page"]["title"] = "赛区管理";
goto peyF6;
ZC2k4:
$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->modulename . "_saiqu") . $condition . $order_condition, $params);
goto SzJ06;
lB4pt:
$content = ihttp_post($url, $post_data);
goto SsFVt;
TvSwH:
if ($operation == "deleteall") {
    goto C9hxs;
}
goto F0Kgc;
DGcqL:
load()->func("tpl");
goto f8I4d;
ba5d5:
vLzZv:
goto QjB5d;
NnQQb:
$status = $_GPC["status"] ? 0 : 1;
goto j6vR2;
kwZRN:
message("赛区不存在");
goto tuayM;
JbsmK:
goto j9NWY;
goto C4ghP;
QlUM8:
$sql = "SELECT * FROM " . tablename($this->modulename . "_saiqu") . $condition . $order_condition . " LIMIT " . ($pindex - 1) * $psize . "," . $psize;
goto RqqLj;
L9Z87:
checklogin();
goto wm9R1;
DF7Kp:
UAijk:
goto tvuKx;
xsTkK:
$rid = $_GPC["rid"];
goto NnQQb;
sOoTI:
die;
goto JbsmK;
F0Kgc:
if ($operation == "post") {
    goto IZeMX;
}
goto QKL1n;
Wi1ss:
$data["uniacid"] = $uniacid;
goto dUvKS;
tsl2D:
message("赛区已存在");
goto OSIKX;
J3VrH:
die;
goto Kmb0O;
b1sjO:
if ($operation == "checkrobot") {
    goto JYO_v;
}
goto uRd3G;
QtWaw:
Ko7H1:
goto DGcqL;
SzJ06:
$pager = pagination($total, $pindex, $psize);
goto iWM4z;
ReHTn:
pdo_insert($this->modulename . "_saiqu", $data);
goto SGDIG;
C4ghP:
IZeMX:
goto BG3Oc;
tvuKx:
$order_condition = " ORDER BY id DESC ";
goto QlUM8;
OzxC0:
defined("IN_IA") or exit("Access Denied");
goto eaxwV;
pXaqH:
QetBZ:
goto u8CRP;
nAM28:
message("您没有权限编辑");
goto TCuz0;
vDZMU:
if (empty($keyword)) {
    goto UAijk;
}
goto wxrYH;
cvQH1:
if (!$id) {
    goto NfRTN;
}
goto nz4I1;
jEvrs:
include $this->template("saiqu_manage");