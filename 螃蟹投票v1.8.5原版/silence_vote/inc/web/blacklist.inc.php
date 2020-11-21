<?php

goto ifnOl;
ue7b9:
$condition .= " AND type = {$type} ORDER BY id DESC ";
goto qKAA3;
ubpBl:
message("删除成功！", $this->createWebUrl("blacklist", array("name" => "silence_vote")), "success");
goto hMRUn;
hMRUn:
bqgv_:
goto X7pnm;
kRmTU:
if (empty($_GPC["keyword"])) {
    goto fv023;
}
goto kPC5X;
HTOn5:
if (!$_W["ispost"]) {
    goto gget8;
}
goto lpwb8;
kPC5X:
$condition .= " AND CONCAT(`value`,`content`) LIKE '%{$_GPC["keyword"]}%'";
goto amjK8;
um5ZT:
$content = getIPLoc_QQ($val) . " " . $val;
goto m52GZ;
fUwr0:
if (empty($list)) {
    goto aqIPD;
}
goto B0KfH;
lpwb8:
$ispost = 1;
goto NY2Or;
NY2Or:
gget8:
goto dbjmB;
ifnOl:
defined("IN_IA") or exit("Access Denied");
goto Q0MdN;
agKy2:
$userinfo = mc_fansinfo($val, $_W["uniacid"], $_W["uniacid"]);
goto Ksd4H;
PCevX:
$data = array("uniacid" => $_W["uniacid"], "type" => $type, "value" => $val, "content" => $content, "status" => 0, "createtime" => time());
goto lEDgB;
Ksd4H:
$content = $userinfo["tag"]["nickname"] ?: "佚名" . " " . $val;
goto Wo9Nz;
zpUfO:
goto aptsY;
goto z3m3A;
UHl7c:
$id = intval($_GPC["id"]);
goto Ai81O;
VO_Hx:
if (!($op == "add")) {
    goto oNWz4;
}
goto gojeZ;
qKAA3:
$list = pdo_fetchall("SELECT * FROM " . tablename($this->tableblacklist) . " WHERE uniacid = '{$uniacid} '  {$condition}   LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
goto fUwr0;
RDkWA:
if ($type) {
    goto Eo4O6;
}
goto jXX6g;
X7pnm:
xUi5S:
goto W20JI;
G4EtG:
oNWz4:
goto q7QJn;
z3m3A:
AGlzd:
goto f9PWa;
jXX6g:
load()->model("mc");
goto agKy2;
HdUXU:
if ($re) {
    goto AGlzd;
}
goto TjEen;
tAlV_:
message("黑名单不能为空", $this->createWebUrl("blacklist", array("name" => "silence_vote")), "error");
goto pUS6y;
Ln6sK:
$psize = 20;
goto DZ3md;
amjK8:
fv023:
goto ue7b9;
e0ACk:
$id = intval($_GPC["id"]);
goto Wyunn;
CUR4R:
message("删除失败，不存在该名单！", $this->createWebUrl("blacklist", array("name" => "silence_vote")), "error");
goto jPfO4;
Wo9Nz:
goto ZT9J0;
goto EpJDp;
EpJDp:
Eo4O6:
goto um5ZT;
TJXca:
$op = !empty($_GPC["op"]) ? $_GPC["op"] : "display";
goto gLYaW;
tUxKV:
YG2fY:
goto VO_Hx;
gfxgk:
if ($re) {
    goto KEsTF;
}
goto CUR4R;
Ai81O:
$uniacid = $_W["uniacid"];
goto mtdDN;
DZ3md:
$condition = '';
goto kRmTU;
ZwlZN:
$pindex = max(1, intval($_GPC["page"]));
goto Ln6sK;
q7QJn:
if (!($op == "delete")) {
    goto xUi5S;
}
goto e0ACk;
gLYaW:
if (!($op == "display")) {
    goto YG2fY;
}
goto ZwlZN;
gojeZ:
$val = $_GPC["val"];
goto HTOn5;
lEDgB:
$re = @pdo_insert($this->tableblacklist, $data);
goto HdUXU;
CIRxc:
aqIPD:
goto tUxKV;
T6r0G:
aptsY:
goto G4EtG;
mtdDN:
$type = intval($_GPC["type"]);
goto TJXca;
pUS6y:
pALsR:
goto RDkWA;
Wyunn:
$re = pdo_delete($this->tableblacklist, array("id" => $id, "uniacid" => $uniacid));
goto gfxgk;
TjEen:
message("添加失败，不存在该名单！", $this->createWebUrl("blacklist", array("name" => "silence_vote", "type" => $type)), "error");
goto zpUfO;
Q0MdN:
global $_GPC, $_W;
goto UHl7c;
kU7PS:
KEsTF:
goto ubpBl;
f9PWa:
message("添加黑名单成功！", $this->createWebUrl("blacklist", array("name" => "silence_vote", "type" => $type)), "success");
goto T6r0G;
m52GZ:
ZT9J0:
goto PCevX;
B0KfH:
$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->tableblacklist) . " WHERE uniacid = '{$uniacid}' {$condition}");
goto HQwyp;
jPfO4:
goto bqgv_;
goto kU7PS;
dbjmB:
if (!empty($val)) {
    goto pALsR;
}
goto tAlV_;
HQwyp:
$pager = pagination($total, $pindex, $psize);
goto CIRxc;
W20JI:
include $this->template("blacklist");