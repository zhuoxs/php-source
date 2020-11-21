<?php

goto XqNND;
EBBq2:
goto PkKKO;
goto yMmkc;
Tzund:
$condition .= " AND tid = '{$id} ' ";
goto hAtAh;
YV123:
Z30pU:
goto wCPIt;
lk692:
cv7sL:
goto T0iLc;
TfObA:
$this->authorization();
goto UVMH4;
ViAKR:
l3cFy:
goto pMDPy;
hAtAh:
TgooU:
goto DWAfE;
fps19:
$id = intval($_GPC["id"]);
goto YI3uJ;
PKJ0L:
if (empty($_GPC["keyword"])) {
    goto Z30pU;
}
goto xKbKO;
QS8lV:
PkKKO:
goto WjYBV;
jp8w0:
if (empty($list)) {
    goto Pe_UR;
}
goto fH_pV;
ezZaN:
$reply = unserialize($reply["config"]);
goto AmSYu;
fH_pV:
$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->tablegift) . " WHERE uniacid = '{$uniacid}' AND rid = '{$rid} '  {$condition}");
goto BJr33;
aI6A_:
$result = json_decode($content["content"], true);
goto unOi_;
xKbKO:
$condition .= " AND CONCAT(`nickname`,`openid`,`user_ip`,`uniontid`) LIKE '%{$_GPC["keyword"]}%'";
goto YV123;
AmSYu:
$voteuser = pdo_fetch("SELECT * FROM " . tablename($this->tablevoteuser) . " WHERE  id = :id AND uniacid = :uniacid AND rid = :rid", array(":id" => $id, ":uniacid" => $uniacid, ":rid" => $rid));
goto mRE4A;
XqNND:
defined("IN_IA") or exit("Access Denied");
goto R1YZB;
mRE4A:
$pindex = max(1, intval($_GPC["page"]));
goto P8KJl;
unOi_:
if ($result["sta"]) {
    goto l3cFy;
}
goto ajj2N;
b1eLM:
goto PkKKO;
goto JKX1M;
UVMH4:
$reply = pdo_fetch("SELECT config FROM " . tablename($this->tablereply) . " WHERE uniacid=:uniacid AND rid = :rid ORDER BY `id` DESC", array(":uniacid" => $uniacid, ":rid" => $rid));
goto ezZaN;
OpCJ0:
if ($_GPC["ispay"] == "notpay") {
    goto JFhd0;
}
goto EBBq2;
C0Ti5:
if (!($_GPC["id"] == '')) {
    goto rIUkb;
}
goto Pdce3;
M98wB:
foreach ($list as $key => $value) {
    goto OhACf;
    UGwlp:
    $list[$key]["nc"] = $vu["nickname"];
    goto IpJlp;
    Uh_8a:
    RNCUk:
    goto EqvHQ;
    IpJlp:
    $list[$key]["tx"] = $vu["avatar"];
    goto Uh_8a;
    OhACf:
    $vu = pdo_fetch("SELECT nickname,avatar FROM " . tablename($this->tablevoteuser) . " WHERE uniacid = '{$uniacid}' AND id = '{$value["tid"]} ' ");
    goto UGwlp;
    EqvHQ:
}
goto qrJpS;
Pdce3:
$ztotal = pdo_fetchcolumn("SELECT sum(fee) FROM " . tablename($this->tablegift) . " WHERE rid = :rid  AND ispay=:ispay and openid != 'addgift'", array(":rid" => $rid, ":ispay" => 1));
goto o718q;
wCPIt:
if (empty($id)) {
    goto TgooU;
}
goto Tzund;
nRnuI:
if ($_GPC["ispay"] == "pay") {
    goto lOBhK;
}
goto OpCJ0;
yDNax:
$condition = '';
goto PKJ0L;
WjYBV:
if (!empty($_GPC["order"])) {
    goto cv7sL;
}
goto RYtvN;
qrJpS:
BE_wj:
goto SpiJj;
RYtvN:
$condition .= " ORDER BY id DESC ";
goto KX7JN;
T0iLc:
$condition .= " ORDER BY {$_GPC["order"]} DESC,id desc ";
goto R823C;
TULlv:
$post_data = array("time" => time(), "ticket" => $cfg["ticket"], "module_id" => 3);
goto hIeU3;
R1YZB:
global $_GPC, $_W;
goto tZiD6;
ILYSJ:
load()->func("communication");
goto jvSVG;
YI3uJ:
$uniacid = $_W["uniacid"];
goto TfObA;
Z_eaA:
$reply = pdo_fetch("SELECT * FROM " . tablename($this->tablereply) . " WHERE rid = :rid ORDER BY `id` DESC", array(":rid" => $_GPC["rid"]));
goto X33Yi;
Axub0:
$condition .= " and ispay = 0 ";
goto QS8lV;
w1uLw:
$post_data["token"] = md5(sha1(implode('', $post_data)));
goto ILYSJ;
hIeU3:
ksort($post_data);
goto w1uLw;
pEuDU:
$url = $this->auth_url . "/index/vote/checkauth";
goto TULlv;
R823C:
C3jy_:
goto C0Ti5;
SpiJj:
Pe_UR:
goto Z_eaA;
P8KJl:
$psize = 20;
goto yDNax;
KX7JN:
goto C3jy_;
goto lk692;
kzPKG:
$list = pdo_fetchall("SELECT * FROM " . tablename($this->tablegift) . " WHERE uniacid = '{$uniacid} ' AND rid = '{$rid} ' {$condition}   LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
goto jp8w0;
JKX1M:
JFhd0:
goto Axub0;
yMmkc:
lOBhK:
goto syrUf;
syrUf:
$condition .= " and ispay = 1 ";
goto b1eLM;
jNzu1:
$rid = intval($_GPC["rid"]);
goto fps19;
DWAfE:
$condition .= " and openid != 'addgift' ";
goto nRnuI;
tZiD6:
$cfg = $this->module["config"];
goto pEuDU;
X33Yi:
$reply["config"] = @unserialize($reply["config"]);
goto IBsug;
jvSVG:
$content = ihttp_post($url, $post_data);
goto aI6A_;
K1lsQ:
goto UgciI;
goto ViAKR;
BJr33:
$pager = pagination($total, $pindex, $psize);
goto M98wB;
o718q:
rIUkb:
goto kzPKG;
pMDPy:
UgciI:
goto jNzu1;
ajj2N:
//message("授权错误，请联系客服！", "referer", "error");
goto K1lsQ;
IBsug:
include $this->template("giftlist");