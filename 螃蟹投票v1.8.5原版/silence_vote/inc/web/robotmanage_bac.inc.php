<?php

goto hDKFj;
ikll9:
Ep0yf:
goto NXsFF;
uAmCs:
echo "{\"data\":\"更新成功\"}";
goto mhZNE;
NXsFF:
if (!(empty($_GPC["idArr"]) || !is_array($_GPC["idArr"]))) {
    goto XWi05;
}
goto QLwo2;
hMZfA:
pdo_insert($this->modulename . "_robotlist", $data);
goto U22sq;
M2auK:
global $_W, $_GPC;
goto iHZpF;
id6ez:
$ids = pdo_fetch("select id from " . tablename($this->modulename . "_voteuser") . $condition . " and  nickname like '%{$keyword}%' ");
goto YAvKj;
p3rXK:
pdo_delete($this->modulename . "_robotlist", array("id" => $id), "OR");
goto zVDwi;
NxcFK:
$this->check_ticket();
goto fsgqx;
rf6WA:
if (!$id) {
    goto pX07e;
}
goto i8lD6;
iHZpF:
checklogin();
goto I5pUH;
WIwvQ:
N_EjC:
goto u4M05;
QLwo2:
message("不存在或是已经被删除", $this->createWebUrl("robotmanage", array("op" => "display")), "error");
goto fEe3_;
gjerI:
XmwrQ:
goto Gs4iP;
eJIow:
message("您没有权限编辑");
goto pW69O;
Gs4iP:
$order_condition = " ORDER BY id DESC ";
goto cqnLk;
u6ht_:
pX07e:
goto Xx2gR;
n6q73:
$reply_id = $_GPC["reply_id"];
goto ZMNNp;
pHInO:
if (!($data["balance"] < 1 || $data["balance"] > 100)) {
    goto hE0I0;
}
goto XGlhm;
POkEE:
$items = pdo_fetchall($sql, $params);
goto Ip02h;
U22sq:
goto xQu8S;
goto f1MZf;
m7IV4:
$data = $_GPC["data"];
goto pHInO;
QcS_2:
$pager = pagination($total, $pindex, $psize);
goto XQh4c;
tMVBu:
goto CPpjh;
goto LXzXT;
EAvb1:
foreach ($_GPC["idArr"] as $k => $id) {
    goto qyqAR;
    yu8Hg:
    if (!$id) {
        goto tEvlh;
    }
    goto pqDQd;
    qyqAR:
    $id = intval($id);
    goto yu8Hg;
    rnElR:
    V6edQ:
    goto K4RyV;
    Pnf4o:
    tEvlh:
    goto rnElR;
    pqDQd:
    pdo_delete($this->modulename . "_robotlist", array("id" => $id, "uniacid" => $uniacid));
    goto Pnf4o;
    K4RyV:
}
goto vMmA_;
hNGXK:
$condition .= " AND vuid in ({$ids})";
goto gjerI;
t7nhe:
if ($operation == "deleteall") {
    goto Ep0yf;
}
goto jIgFB;
CGxFf:
if (empty($keyword)) {
    goto XmwrQ;
}
goto id6ez;
VPGFH:
if ($operation == "checkrobot") {
    goto N_EjC;
}
goto p1Bj1;
o02UJ:
$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->modulename . "_robotlist") . $condition . $order_condition, $params);
goto QcS_2;
ZPzI3:
xQu8S:
goto mW9zE;
pW69O:
taTaT:
goto p3rXK;
VpN6h:
die;
goto tMVBu;
u4M05:
$rid = $_GPC["rid"];
goto y6LpG;
Ip02h:
foreach ($items as $key => $value) {
    goto ySHcc;
    mQZCY:
    $name = pdo_fetch("select name from " . tablename($this->modulename . "_voteuser") . " where id = {$value["vuid"]} and uniacid = {$uniacid}");
    goto aMsHH;
    akyxs:
    $items[$key]["vuid"] = $vuid["id"];
    goto PnjRG;
    YHT3L:
    $items[$key]["nickname"] = $nickname["nickname"];
    goto HxGkw;
    aMsHH:
    $vuid = pdo_fetch("select id from " . tablename($this->modulename . "_voteuser") . " where id = {$value["vuid"]} and uniacid = {$uniacid}");
    goto YHT3L;
    HxGkw:
    $items[$key]["name"] = $name["name"];
    goto akyxs;
    PnjRG:
    H34Ra:
    goto UVCKf;
    ySHcc:
    $nickname = pdo_fetch("select nickname from " . tablename($this->modulename . "_voteuser") . " where id = {$value["vuid"]} and uniacid = {$uniacid}");
    goto mQZCY;
    UVCKf:
}
goto LZxbH;
Xx2gR:
if (!checksubmit("submit")) {
    goto AjT7R;
}
goto m7IV4;
IxLzu:
hE0I0:
goto IbeWA;
upSU9:
CPpjh:
goto gdHUO;
IH9sm:
pdo_update($this->modulename . "_robotlist", $data, array("id" => $id));
goto ZPzI3;
wWXMs:
$uniacid = !empty($_W["uniacid"]) ? $_W["uniacid"] : intval($_GET["uniacid"]);
goto diP76;
ys94_:
goto CPpjh;
goto tD6CZ;
fEe3_:
XWi05:
goto EAvb1;
iCtNd:
if ($item) {
    goto FVZ7K;
}
goto hh5Nv;
diP76:
if ($operation == "delete") {
    goto rszfK;
}
goto t7nhe;
LZxbH:
G8rE7:
goto o02UJ;
jIgFB:
if ($operation == "post") {
    goto P3Vps;
}
goto WbiY_;
y6LpG:
$status = $_GPC["status"] ? 0 : 1;
goto sFyMU;
wgtK6:
$psize = 15;
goto d97oE;
xfiT0:
$pindex = max(1, intval($_GPC["page"]));
goto wgtK6;
sFyMU:
pdo_update($this->modulename . "_reply", array("robotstatus" => $status), array("rid" => $rid));
goto uAmCs;
e4F5U:
if (!empty($id)) {
    goto A2mq4;
}
goto hMZfA;
DOrDh:
oZL8p:
goto iPSZZ;
hDKFj:
defined("IN_IA") or exit("Access Denied");
goto M2auK;
Mxh2D:
$item = pdo_fetch("SELECT * FROM " . tablename($this->modulename . "_robotlist") . " WHERE id = '{$id}'");
goto cOQDW;
i8lD6:
$item = pdo_fetch("SELECT * FROM " . tablename($this->modulename . "_robotlist") . " WHERE id = {$id} and uniacid = {$uniacid}");
goto iCtNd;
dmzTN:
message("不存在或是已经被删除", $this->createWebUrl("robotmanage", array("op" => "display")), "error");
goto DOrDh;
fsgqx:
$operation = !empty($_GPC["op"]) ? $_GPC["op"] : "display";
goto wWXMs;
qlM8C:
rszfK:
goto LuKPo;
Vr3S2:
$rid = $_GPC["rid"];
goto TV2RO;
YAvKj:
$ids = $ids ? join(",", $ids) : 0;
goto hNGXK;
cOQDW:
if (!empty($item)) {
    goto oZL8p;
}
goto dmzTN;
iPSZZ:
if (!($item["uniacid"] != $uniacid)) {
    goto taTaT;
}
goto eJIow;
F9ek6:
$_W["page"]["title"] = "机器人管理";
goto NxcFK;
ot8Bg:
echo "{\"data\":\"删除成功\"}";
goto VpN6h;
LXzXT:
P3Vps:
goto Gd5eI;
I5pUH:
load()->func("tpl");
goto F9ek6;
ZMNNp:
$rid = $_GPC["rid"];
goto xfiT0;
RMl5C:
AjT7R:
goto ys94_;
Gd5eI:
$reply_id = $_GPC["reply_id"];
goto Vr3S2;
vMmA_:
w5uZV:
goto ot8Bg;
TV2RO:
$id = intval($_GPC["id"]);
goto rf6WA;
hh5Nv:
message("机器人不存在");
goto pebqY;
tD6CZ:
QwWyJ:
goto n6q73;
mxJnd:
$condition = " WHERE uniacid = {$uniacid} and rid = {$rid}";
goto Dn1Cs;
WbiY_:
if ($operation == "display") {
    goto QwWyJ;
}
goto VPGFH;
LuKPo:
$id = intval($_GPC["id"]);
goto Mxh2D;
XGlhm:
message("差额百分比设置不正确");
goto IxLzu;
Dn1Cs:
$params = array();
goto CGxFf;
zVDwi:
message("删除成功", referer(), "success");
goto NutQQ;
f1MZf:
A2mq4:
goto IH9sm;
p1Bj1:
goto CPpjh;
goto qlM8C;
pebqY:
FVZ7K:
goto u6ht_;
IbeWA:
$data["uniacid"] = $uniacid;
goto e4F5U;
d97oE:
$keyword = trim($_GPC["keyword"]);
goto mxJnd;
XQh4c:
goto CPpjh;
goto WIwvQ;
cqnLk:
$sql = "SELECT * FROM " . tablename($this->modulename . "_robotlist") . $condition . $order_condition . " LIMIT " . ($pindex - 1) * $psize . "," . $psize;
goto POkEE;
mW9zE:
message("更新成功", $this->createWebUrl("robotmanage", array("op" => "display", "rid" => $rid, "reply_id" => $reply_id)), "success");
goto RMl5C;
NutQQ:
goto CPpjh;
goto ikll9;
mhZNE:
die;
goto upSU9;
gdHUO:
$reply = pdo_fetch("SELECT * FROM " . tablename($this->tablereply) . " WHERE rid = :rid ORDER BY `id` DESC", array(":rid" => $_GPC["rid"]));
goto VypCP;
VypCP:
include $this->template("robot_manage");