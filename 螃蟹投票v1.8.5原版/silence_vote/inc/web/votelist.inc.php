<?php

goto qyptN;
fmOXy:
RDeLx:
goto D3dEF;
Tp2wW:
array_unshift($info, $a);
goto dmsAc;
R_7aT:
$reply = pdo_fetch("SELECT * FROM " . tablename($this->tablereply) . " WHERE rid = :rid ORDER BY `id` DESC", array(":rid" => $_GPC["rid"]));
goto zvlWL;
Oz54_:
$condition .= " ORDER BY id DESC ";
goto ZObrR;
Zwb8R:
$condition .= " AND status=1";
goto xKb3V;
gl9cT:
if ($_GPC["ty"] == 1) {
    goto bCBvk;
}
goto pPDQs;
qRz3H:
GZvkX:
goto Appvt;
nU2ab:
$condition .= " ORDER BY giftcount DESC,votenum DESC,id DESC ";
goto ClEWr;
suZF_:
$condition .= " ORDER BY votenum DESC,giftcount DESC,id DESC ";
goto ON3x9;
hInjf:
if ($_GPC["ranking"] == '') {
    goto Q5Uey;
}
goto xX1Cz;
a3l1d:
goto LTY1g;
goto tRsRB;
O3mjt:
$condition = '';
goto aBP9M;
pPDQs:
goto JCX3L;
goto Hq8Y6;
jSOX0:
goto uZYrX;
goto wiJiI;
ks8dU:
global $_GPC, $_W;
goto HJ8yw;
WSs2B:
$pindex = max(1, intval($_GPC["page"]));
goto yjZ_T;
Wte68:
if (!$_GPC["flag"]) {
    goto NG4lE;
}
goto mdKgC;
bEGLo:
uZYrX:
goto K4UaW;
PMtFk:
foreach ($list as $key => &$item) {
    goto WzzwJ;
    PHlfP:
    if ($cfg["ischeatshow"] == 1) {
        goto K47B2;
    }
    goto J6Hy3;
    jNvkG:
    CRuFT:
    goto FZVx6;
    u2xVf:
    $ii = $this->getrobot($data)["info"] ?: "0";
    goto tHJ1D;
    wOKVu:
    $item["saiqu"] = "无赛区";
    goto HJnjC;
    Mf8BX:
    bbmQq:
    goto wOBrm;
    IOi0P:
    goto CRuFT;
    goto Mf8BX;
    I2CXQ:
    K47B2:
    goto CBOFk;
    PuC7j:
    IcU7L:
    goto OWGxL;
    nCWdA:
    if (!(empty($ii) && $ii !== "0")) {
        goto zEytm;
    }
    goto JwOuX;
    b30nb:
    $item["robotmode"] = $ii[0]["mode"];
    goto IOi0P;
    k7tfj:
    $sharetotal = pdo_fetchcolumn("SELECT share_total FROM " . tablename($this->tablecount) . " WHERE rid = :rid AND tid=:tid ", array(":rid" => $item["rid"], ":tid" => $item["id"]));
    goto z38bT;
    tHJ1D:
    cache_write("robot-" . $uniacid . "-" . $item["rid"] . "-" . $item["id"], $ii);
    goto sUK5z;
    J6Hy3:
    $ii = cache_load("robot-" . $uniacid . "-" . $item["rid"] . "-" . $item["id"]);
    goto nCWdA;
    pC3NN:
    $data["sql"] = $sql;
    goto u2xVf;
    TBol6:
    if (!$item["agent_id"]) {
        goto c_pxo;
    }
    goto yeOk5;
    WzzwJ:
    $pvtotal = pdo_fetchcolumn("SELECT pv_total FROM " . tablename($this->tablecount) . " WHERE rid = :rid AND tid=:tid ", array(":rid" => $item["rid"], ":tid" => $item["id"]));
    goto c0DrB;
    FZVx6:
    goto SdZqH;
    goto I2CXQ;
    sUK5z:
    zEytm:
    goto vHGfe;
    JwOuX:
    $sql = "SELECT * FROM silence_vote_robotlist WHERE vuid = {$item["id"]} and uniacid = {$uniacid} and ticket = '{$cfg["ticket"]}' and rid = {$item["rid"]}";
    goto TxPtZ;
    vHGfe:
    if (!$ii) {
        goto bbmQq;
    }
    goto b30nb;
    Gh3sg:
    uye_L:
    goto nV6xA;
    CBOFk:
    $item["robotmode"] = 0;
    goto lJbKh;
    AvYv7:
    $item["saiqu"] = pdo_fetchcolumn("SELECT saiquname FROM " . tablename($this->modulename . "_saiqu") . " WHERE id=:id  and rid = {$item["rid"]}", array(":id" => $item["saiquid"]));
    goto PuC7j;
    wOBrm:
    $item["robotmode"] = 0;
    goto jNvkG;
    KakBW:
    if ($item["saiquid"]) {
        goto f6CWP;
    }
    goto wOKVu;
    z38bT:
    $item["sharetotal"] = empty($sharetotal) ? 0 : $sharetotal;
    goto drUKA;
    gJfvb:
    c_pxo:
    goto KakBW;
    drUKA:
    $item["joindata"] = @unserialize($item["joindata"]);
    goto TBol6;
    TxPtZ:
    $data["rid"] = $item["rid"];
    goto pC3NN;
    OWGxL:
    $cfg = $this->module["config"];
    goto PHlfP;
    lJbKh:
    SdZqH:
    goto Gh3sg;
    HJnjC:
    goto IcU7L;
    goto xFn1T;
    c0DrB:
    $item["pvtotal"] = empty($pvtotal) ? 0 : $pvtotal;
    goto k7tfj;
    xFn1T:
    f6CWP:
    goto AvYv7;
    yeOk5:
    $item["agentname"] = pdo_fetchcolumn("SELECT username FROM " . tablename($this->modulename . "_agentlist") . " WHERE id=:id ", array(":id" => $item["agent_id"]));
    goto gJfvb;
    nV6xA:
}
goto tkEe5;
mdKgC:
if (!($_GPC["saiquid"] != -1)) {
    goto Auz9S;
}
goto X6xrn;
YjeiN:
exit;
goto fmOXy;
Bbgfg:
die;
goto b8ZD0;
fwnVC:
mfhZV:
goto nU2ab;
ZObrR:
goto LTY1g;
goto fwnVC;
wFoIB:
$pager = pagination($total, $pindex, $psize);
goto PMtFk;
VkuAW:
foreach ($_GPC["idArr"] as $k => $id) {
    goto PtEEp;
    MxyaD:
    fr10n:
    goto jnp4P;
    Pfcq2:
    pdo_delete($this->modulename . "_voteuser", array("id" => $id, "uniacid" => $uniacid));
    goto QGhRE;
    PtEEp:
    $id = intval($id);
    goto QRF8L;
    QGhRE:
    XLp0O:
    goto MxyaD;
    QRF8L:
    if (!$id) {
        goto XLp0O;
    }
    goto Pfcq2;
    jnp4P:
}
goto qRz3H;
K4UaW:
$this->authorization();
goto BAXrZ;
tkEe5:
VKd3S:
goto cauxt;
HJ8yw:
$cfg = $this->module["config"];
goto csfwD;
qyptN:
defined("IN_IA") or exit("Access Denied");
goto ks8dU;
BAXrZ:
$uniacid = $_W["uniacid"];
goto E4QAv;
M27zn:
$list = pdo_fetchall("SELECT * FROM " . tablename($this->tablevoteuser) . " WHERE uniacid = '{$_W["uniacid"]} ' AND rid = '{$_GPC["rid"]} ' {$condition}   LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
goto M715W;
ssI8v:
$post_data["token"] = md5(sha1(implode('', $post_data)));
goto zRwWG;
lPI1D:
goto JCX3L;
goto EQ0bv;
Z22LA:
//message("授权错误，请联系客服！", "referer", "error");
goto jSOX0;
jYWrS:
$rid = $_GPC["rid"];
goto bqQo0;
wiJiI:
GT_AN:
goto bEGLo;
Fm6Tt:
$a = ["id" => 0, "text" => "无赛区"];
goto Tp2wW;
OIXLi:
Auz9S:
goto TABzf;
ON3x9:
LTY1g:
goto M27zn;
zvlWL:
$reply["config"] = @unserialize($reply["config"]);
goto IAley;
Jh5uL:
echo "{\"data\":\"删除失败\"}";
goto Bbgfg;
o1e4C:
$post_data = array("time" => time(), "ticket" => $cfg["ticket"], "module_id" => 3);
goto rTzRx;
EQ0bv:
bCBvk:
goto Zwb8R;
X6xrn:
$condition .= " AND saiquid = {$_GPC["saiquid"]}";
goto OIXLi;
E4tbP:
if ($result["sta"]) {
    goto GT_AN;
}
goto Z22LA;
rTzRx:
ksort($post_data);
goto ssI8v;
bqQo0:
$info = pdo_fetchall("select *,saiquname as text from " . tablename($this->modulename . "_saiqu") . "where uniacid = {$uniacid} and rid = {$rid}");
goto Fm6Tt;
F1ZCG:
array_unshift($info, $a);
goto xHqit;
INmIU:
$result = json_decode($content["content"], true);
goto E4tbP;
D3dEF:
if (!($_GPC["op"] == "deleteall")) {
    goto vQIBU;
}
goto a1FDR;
csfwD:
$url = $this->auth_url . "/index/vote/checkauth";
goto o1e4C;
a1FDR:
if (!(empty($_GPC["idArr"]) || !is_array($_GPC["idArr"]))) {
    goto M_BdQ;
}
goto Jh5uL;
M715W:
if (empty($list)) {
    goto s4cuT;
}
goto L_RDk;
DBHRq:
v69z7:
goto KnQRc;
Hc8LY:
vQIBU:
goto ZtNve;
aBP9M:
if (empty($_GPC["keyword"])) {
    goto v69z7;
}
goto HT2CL;
ZtNve:
$uservote = pdo_get("silence_vote_voteuser", array("uniacid" => $_W["uniacid"], "rid" => $_GPC["rid"]), array("id", "locktime"));
goto WSs2B;
xX1Cz:
if ($_GPC["ranking"] == 1) {
    goto mfhZV;
}
goto F8xCz;
F8xCz:
if ($_GPC["ranking"] == 0) {
    goto K1_HU;
}
goto a3l1d;
xKb3V:
JCX3L:
goto Wte68;
E4QAv:
if (!($_GPC["op"] == "getsaiqu")) {
    goto RDeLx;
}
goto jYWrS;
xHqit:
echo json_encode($info);
goto YjeiN;
xRKGx:
die;
goto Hc8LY;
zRwWG:
load()->func("communication");
goto lw0De;
tRsRB:
Q5Uey:
goto Oz54_;
dmsAc:
$a = ["id" => -1, "text" => "所有赛区"];
goto F1ZCG;
b8ZD0:
M_BdQ:
goto VkuAW;
eNrPF:
K1_HU:
goto suZF_;
yjZ_T:
$psize = 20;
goto O3mjt;
KnQRc:
if ($_GPC["ty"] == 2) {
    goto CljzL;
}
goto gl9cT;
cauxt:
s4cuT:
goto R_7aT;
Appvt:
echo "{\"data\":\"删除成功\"}";
goto xRKGx;
TABzf:
NG4lE:
goto hInjf;
L_RDk:
$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->tablevoteuser) . " WHERE uniacid = '{$_W["uniacid"]}' AND rid = '{$_GPC["rid"]} ' {$condition}");
goto wFoIB;
Hq8Y6:
CljzL:
goto xRidi;
HT2CL:
$condition .= " AND CONCAT(`noid`,`name`,`joindata`) LIKE '%{$_GPC["keyword"]}%'";
goto DBHRq;
ClEWr:
goto LTY1g;
goto eNrPF;
xRidi:
$condition .= " AND status!=1";
goto lPI1D;
lw0De:
$content = ihttp_post($url, $post_data);
goto INmIU;
IAley:
include $this->template("votelist");