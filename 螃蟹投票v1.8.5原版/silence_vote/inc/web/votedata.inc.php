<?php

goto IsOhw;
rapX1:
$voteuser = pdo_fetch("SELECT * FROM " . tablename($this->tablevoteuser) . " WHERE  id = :id AND uniacid = :uniacid AND rid = :rid", array(":id" => $id, ":uniacid" => $uniacid, ":rid" => $rid));
goto RGPTp;
xHm35:
goto G3ZYd;
goto ulmG9;
WlIlH:
if ($_GPC["ty"] == "order" && $_GPC["ispay"] == "1") {
    goto GaxuF;
}
goto xHm35;
wnNrA:
$psize = 20;
goto ji8C1;
vwbX8:
$condition .= " AND tid = '{$id} ' AND CONCAT(`nickname`,`openid`,`user_ip`) LIKE '%{$_GPC["keyword"]}%'";
goto C_rRa;
OEr8O:
$condition .= " ORDER BY id DESC ";
goto BTtRw;
qVGWA:
$condition .= " AND votetype>0 ";
goto tfl87;
C_rRa:
CXKWm:
goto DQ1ZW;
ZIn2s:
$i = 0;
goto lgeo8;
tfl87:
goto G3ZYd;
goto qJCzF;
D1Muf:
ksort($post_data);
goto WOmie;
x4PX2:
$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->tablevotedata) . " WHERE uniacid = '{$uniacid}' AND rid = '{$rid} '  {$condition}");
goto Td9ew;
G3kfG:
goto gbyCG;
goto Q4lWZ;
WOmie:
$post_data["token"] = md5(sha1(implode('', $post_data)));
goto USx3c;
NpVRm:
$post_data = array("time" => time(), "ticket" => $cfg["ticket"], "module_id" => 3);
goto D1Muf;
Q4lWZ:
hakw5:
goto zTfXo;
PH0cY:
if (empty($_GPC["keyword"])) {
    goto CXKWm;
}
goto vwbX8;
DSvx1:
goto G3ZYd;
goto vg63o;
Q6hqA:
if (empty($list)) {
    goto hFIje;
}
goto x4PX2;
zTfXo:
gbyCG:
goto B2dpZ;
IsOhw:
defined("IN_IA") or exit("Access Denied");
goto EGPD4;
LA08d:
$uniacid = $_W["uniacid"];
goto rTpHl;
OT17Y:
$condition .= " AND votetype>0  AND ispay=1";
goto papxl;
papxl:
G3ZYd:
goto OEr8O;
gsnJI:
$url = $this->auth_url . "/index/vote/checkauth";
goto NpVRm;
JVFxP:
$result = json_decode($content["content"], true);
goto ZrBy8;
BTtRw:
if (!($_GPC["ty"] == "order")) {
    goto v8Q0i;
}
goto oHTkW;
rTpHl:
$this->authorization();
goto VBCKg;
ZrBy8:
if ($result["sta"]) {
    goto hakw5;
}
goto TLM4G;
bLRhs:
if (!($i < $cpage)) {
    goto zz_Uj;
}
goto VXbIm;
BfOG0:
$condition .= " AND votetype=1 AND ispay=1  AND tid = '{$id} '";
goto KOtf7;
Xow27:
$list = pdo_fetchall("SELECT * FROM " . tablename($this->tablevotedata) . " WHERE uniacid = '{$uniacid} ' AND rid = '{$rid} ' {$condition}   LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
goto Q6hqA;
Rqt3T:
TyC7z:
goto qVGWA;
Td9ew:
$pager = pagination($total, $pindex, $psize);
goto HznMn;
vjUfr:
if ($_GPC["ty"] == "order" && $_GPC["ispay"] == "0") {
    goto p0Rr5;
}
goto WlIlH;
MtMHl:
BY3FG:
goto BfOG0;
PYDo6:
$reply = unserialize($reply["config"]);
goto rapX1;
RGPTp:
$pindex = max(1, intval($_GPC["page"]));
goto wnNrA;
MdfNw:
zz_Uj:
goto wwnVK;
HznMn:
$cpage = ceil($total / 500);
goto ZIn2s;
DS312:
if ($_GPC["ty"] == "order" && $_GPC["ispay"] == '') {
    goto TyC7z;
}
goto vjUfr;
cKT91:
$condition .= " AND votetype>0 AND ispay=0";
goto DSvx1;
nqk58:
$id = intval($_GPC["id"]);
goto LA08d;
S9tEz:
BiD0H:
goto DjTUf;
mkhJm:
v8Q0i:
goto Xow27;
ji8C1:
$condition = '';
goto PH0cY;
VXbIm:
$fenpi[] = $i + 1;
goto Dw8KW;
VBCKg:
$reply = pdo_fetch("SELECT config FROM " . tablename($this->tablereply) . " WHERE uniacid=:uniacid AND rid = :rid ORDER BY `id` DESC", array(":uniacid" => $uniacid, ":rid" => $rid));
goto PYDo6;
B2dpZ:
$rid = intval($_GPC["rid"]);
goto nqk58;
vg63o:
GaxuF:
goto OT17Y;
KOtf7:
goto G3ZYd;
goto Rqt3T;
lgeo8:
bP_WW:
goto bLRhs;
ulmG9:
mGwBo:
goto YCUFb;
m29qq:
$cfg = $this->module["config"];
goto gsnJI;
Dw8KW:
nDT0K:
goto K7_Nx;
USx3c:
load()->func("communication");
goto OZevk;
oHTkW:
$ztotal = pdo_fetchcolumn("SELECT sum(fee) FROM " . tablename($this->tablevotedata) . " WHERE rid = :rid AND votetype=:votetype AND ispay=:ispay", array(":rid" => $rid, ":votetype" => 1, ":ispay" => 1));
goto mkhJm;
YCUFb:
$condition .= " AND votetype=0  AND tid = '{$id} '";
goto qtAad;
EGPD4:
global $_GPC, $_W;
goto m29qq;
K7_Nx:
$i++;
goto vPogz;
qJCzF:
p0Rr5:
goto cKT91;
qtAad:
goto G3ZYd;
goto MtMHl;
wwnVK:
hFIje:
goto juYns;
OZevk:
$content = ihttp_post($url, $post_data);
goto JVFxP;
TLM4G:
//message("授权错误，请联系客服！", "referer", "error");
goto G3kfG;
DQ1ZW:
if ($_GPC["ty"] == "votenum") {
    goto mGwBo;
}
goto OU5uK;
vPogz:
goto bP_WW;
goto MdfNw;
juYns:
foreach ($list as $key => &$item) {
    goto zN6Ul;
    GtVmN:
    $item["phonetype"] = $phoneinfo ? $phoneinfo[1] : '';
    goto q8X5X;
    Ipxnb:
    DXGQe:
    goto vLnFw;
    q8X5X:
    $item["totaltp"] = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->tablevotedata) . " WHERE uniacid = '{$uniacid}' AND rid = '{$rid} '  and openid = '{$item["openid"]}' ");
    goto S2M1B;
    zN6Ul:
    $item["ipaddress"] = getIPLoc_QQ($item["user_ip"]);
    goto qUy6E;
    qUy6E:
    $phoneinfo = json_decode($item["phoneinfo"], true);
    goto VD3J9;
    VD3J9:
    $item["phonesys"] = $phoneinfo ? $phoneinfo[0] : '';
    goto GtVmN;
    S2M1B:
    $item["totalxstp"] = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->tablevotedata) . " WHERE uniacid = '{$uniacid}' AND rid = '{$rid} '  and openid = '{$item["openid"]}' and tid = {$item["tid"]}");
    goto Ipxnb;
    vLnFw:
}
goto S9tEz;
OU5uK:
if ($_GPC["ty"] == "diamondnum") {
    goto BY3FG;
}
goto DS312;
DjTUf:
include $this->template("votedata");