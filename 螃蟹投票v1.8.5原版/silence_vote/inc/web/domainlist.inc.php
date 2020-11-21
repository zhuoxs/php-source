<?php

goto WvPhU;
LG743:
message("删除成功！", $this->createWebUrl("domainlist", array("name" => "silence_vote", "rid" => $rid)), "success");
goto YcERe;
qVBEw:
AkoHR:
goto WeGxx;
op3hb:
OG744:
goto NXQCp;
qzP75:
$type = intval($_GPC["type"]);
goto roSPl;
ODnni:
aVaKO:
goto XyP0w;
MMeAn:
$id = intval($_GPC["id"]);
goto a4d0L;
d4LJQ:
goto OetAN;
goto NDHCE;
C1hTp:
$reply = pdo_fetch("SELECT * FROM " . tablename($this->tablereply) . " WHERE rid = :rid ORDER BY `id` DESC", array(":rid" => $rid));
goto hOyNb;
ulwo7:
goto jHibF;
goto op3hb;
a0lbI:
RWn8P:
goto ymcs6;
E9qlG:
if ($result["sta"]) {
    goto OG744;
}
goto h8m0l;
c0Ozl:
global $_GPC, $_W;
goto Tu9E5;
M6qzJ:
$re = pdo_update($this->tabledomainlist, $data, array("id" => $id));
goto BJKjh;
rORr0:
$result = json_decode($content["content"], true);
goto E9qlG;
BJKjh:
OetAN:
goto SJhuD;
QU8m7:
$post_data = array("time" => time(), "ticket" => $cfg["ticket"], "module_id" => 3);
goto Y28UW;
Z9YEO:
yab0I:
goto zVlMe;
XyP0w:
$reply = pdo_fetch("SELECT * FROM " . tablename($this->tablereply) . " WHERE rid = :rid ORDER BY `id` DESC", array(":rid" => $_GPC["rid"]));
goto BDBcO;
WvPhU:
defined("IN_IA") or exit("Access Denied");
goto c0Ozl;
YcERe:
isMMJ:
goto ODnni;
jNWCk:
$pindex = max(1, intval($_GPC["page"]));
goto boqDN;
VU87S:
qjvRQ:
goto LG743;
L5axH:
if ($re) {
    goto qjvRQ;
}
goto Iunoj;
GW3zR:
$data = array("uniacid" => $_W["uniacid"], "rid" => $rid, "type" => $type, "domain" => $domain, "extensive" => intval($_GPC["extensive"]), "description" => $_GPC["description"], "status" => intval($_GPC["status"]), "createtime" => time());
goto oK0q5;
bU9Eu:
if (!($op == "display")) {
    goto yab0I;
}
goto C1hTp;
Y28UW:
ksort($post_data);
goto tHCOw;
SJhuD:
if ($re) {
    goto t_qkd;
}
goto Y9OLw;
ySOME:
if (!(!empty($type) && $typed["id"] != $id)) {
    goto ilpxc;
}
goto dLGYv;
p7eza:
wRA3X:
goto Z9YEO;
WeGxx:
ONtbY:
goto SiaJO;
euqjt:
$condition .= "AND rid={$rid}  ORDER BY type DESC,id DESC ";
goto Kd_PU;
xpECW:
$pager = pagination($total, $pindex, $psize);
goto p7eza;
BDBcO:
$reply = @array_merge($reply, unserialize($reply["config"]));
goto pbl31;
zBk_1:
$re = pdo_insert($this->tabledomainlist, $data);
goto d4LJQ;
u367X:
YzRKj:
goto GW3zR;
KoPBf:
$condition = '';
goto BDEHF;
c1dLN:
$condition .= " AND CONCAT(`domain`) LIKE '%{$_GPC["keyword"]}%'";
goto OyYsi;
F9eap:
$url = $this->auth_url . "/index/vote/checkauth";
goto QU8m7;
NDHCE:
KGCQm:
goto M6qzJ;
Kd_PU:
$list = pdo_fetchall("SELECT * FROM " . tablename($this->tabledomainlist) . " WHERE uniacid = '{$uniacid} '  {$condition}   LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
goto FtYDw;
bBTiV:
if (!empty($domain)) {
    goto YzRKj;
}
goto kDDwl;
VUiKx:
$id = intval($_GPC["id"]);
goto qzP75;
kPM6V:
$op = !empty($_GPC["op"]) ? $_GPC["op"] : "display";
goto bU9Eu;
oK0q5:
if (!empty($id)) {
    goto KGCQm;
}
goto zBk_1;
at7OS:
$content = ihttp_post($url, $post_data);
goto rORr0;
BDEHF:
if (empty($_GPC["keyword"])) {
    goto rhynA;
}
goto c1dLN;
ymcs6:
W4UuF:
goto FxicR;
Iccwn:
$uniacid = $_W["uniacid"];
goto BX2ut;
h8m0l:
//message("授权错误，请联系客服！", "referer", "error");
goto ulwo7;
Iunoj:
message("删除失败，不存在该名单！", $this->createWebUrl("domainlist", array("name" => "silence_vote", "rid" => $rid)), "error");
goto k4kEP;
tHCOw:
$post_data["token"] = md5(sha1(implode('', $post_data)));
goto dj5QX;
kDDwl:
message("域名不能为空", "error");
goto u367X;
BX2ut:
$rid = intval($_GPC["rid"]);
goto kPM6V;
w_OdM:
$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->tabledomainlist) . " WHERE uniacid = '{$uniacid}' {$condition}");
goto xpECW;
uGKbo:
$domain = trim($_GPC["domain"]);
goto VUiKx;
vTlqG:
message("更新成功！", $this->createWebUrl("domainlist", array("name" => "silence_vote", "rid" => $rid)), "success");
goto qVBEw;
FxicR:
if (!($op == "delete")) {
    goto aVaKO;
}
goto MMeAn;
Tu9E5:
$cfg = $this->module["config"];
goto F9eap;
k4kEP:
goto isMMJ;
goto VU87S;
dLGYv:
$reup = pdo_update($this->tabledomainlist, array("type" => "0"), array("id" => $typed["id"]));
goto l3Dfd;
boqDN:
$psize = 20;
goto KoPBf;
SiaJO:
if (empty($id)) {
    goto RWn8P;
}
goto XEuFw;
l3Dfd:
ilpxc:
goto bBTiV;
NXQCp:
jHibF:
goto Iccwn;
zVlMe:
if (!($op == "post")) {
    goto W4UuF;
}
goto uGKbo;
FtYDw:
if (empty($list)) {
    goto wRA3X;
}
goto w_OdM;
ttsZS:
t_qkd:
goto vTlqG;
hOyNb:
$reply = @array_merge($reply, unserialize($reply["config"]));
goto hTHY1;
OyYsi:
rhynA:
goto euqjt;
Y9OLw:
message("更新失败，", $this->createWebUrl("domainlist", array("name" => "silence_vote", "rid" => $rid)), "error");
goto mbo7g;
a4d0L:
$re = pdo_delete($this->tabledomainlist, array("id" => $id, "rid" => $rid, "uniacid" => $uniacid));
goto L5axH;
XEuFw:
$list = pdo_get($this->tabledomainlist, array("id" => $id, "rid" => $rid));
goto a0lbI;
SLRUK:
$typed = pdo_get($this->tabledomainlist, array("uniacid" => $_W["uniacid"], "rid" => $rid, "type" => 1), array("id"));
goto ySOME;
roSPl:
if (!$_W["ispost"]) {
    goto ONtbY;
}
goto SLRUK;
mbo7g:
goto AkoHR;
goto ttsZS;
hTHY1:
unset($reply["config"]);
goto jNWCk;
dj5QX:
load()->func("communication");
goto at7OS;
pbl31:
unset($reply["config"]);
goto ibaFG;
ibaFG:
include $this->template("domainlist");