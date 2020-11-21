<?php

goto AJHzw;
kJfv1:
goto Jz9e4;
goto pyF78;
qDwS0:
goto Jz9e4;
goto ariYU;
cg_Fp:
$condition .= " AND activecode LIKE ''";
goto tVxvn;
jI6Hr:
$keyword = $_GPC["keyword"];
goto yVLmn;
t66s7:
$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->tablereply) . " WHERE uniacid = '{$_W["uniacid"]}'  {$condition}");
goto xr2Sy;
rKjaW:
if (!empty($_GPC["keyword"])) {
    goto fP9z2;
}
goto Gbr3r;
Fuf1g:
H0Aa4:
goto Mzwj4;
Dr6Vx:
$keyword = $_GPC["keyword"];
goto YcU0l;
MYrWn:
goto NabU7;
goto Fuf1g;
zESd7:
$list = pdo_fetchall($testSql);
goto qDwS0;
BBjjB:
$list = pdo_fetchall($testSql);
goto woyxf;
tVxvn:
goto R2gOR;
goto BcMRk;
YcU0l:
$condition .= " AND title LIKE ''";
goto MYrWn;
JvRGC:
$list = pdo_fetchall($testSql);
goto kJfv1;
hVk3E:
$pindex = max(1, intval($_GPC["page"]));
goto fIxqj;
LTelG:
MTjZi:
goto Y1rRB;
h1H7D:
global $_GPC, $_W;
goto iFuN1;
izbWH:
$testSql = "SELECT * FROM " . tablename($this->tablereply) . " WHERE uniacid = '{$_W["uniacid"]}' {$condition}  ORDER BY createtime DESC LIMIT " . ($pindex - 1) * $psize . ",{$psize}";
goto BBjjB;
ariYU:
A17IL:
goto rKjaW;
yVLmn:
$condition .= " AND activecode LIKE '%{$keyword}%'";
goto DxZVV;
KJmva:
y9Pbb:
goto HXRqf;
gkO1E:
$keyword = $_GPC["keyword"];
goto ne6tn;
iFuN1:
$this->authorization();
goto hVk3E;
AJHzw:
defined("IN_IA") or exit("Access Denied");
goto h1H7D;
vkTXr:
$choice = $_GPC["choice"];
goto SAtkC;
bhaHm:
if ($choice < 2) {
    goto A17IL;
}
goto g2ReT;
SAtkC:
if (empty($choice)) {
    goto ttGsT;
}
goto bhaHm;
BcMRk:
fP9z2:
goto jI6Hr;
ne6tn:
$condition .= " AND CONCAT(`title`,`activecode`) LIKE '%{$keyword}%'";
goto KJmva;
tyqw6:
if (empty($_GPC["keyword"])) {
    goto y9Pbb;
}
goto gkO1E;
Gbr3r:
$keyword = $_GPC["keyword"];
goto cg_Fp;
xr2Sy:
$pager = pagination($total, $pindex, $psize);
goto s1NVq;
g2ReT:
if (!empty($_GPC["keyword"])) {
    goto H0Aa4;
}
goto Dr6Vx;
HXRqf:
$testSql = "SELECT * FROM " . tablename($this->tablereply) . " WHERE uniacid = '{$_W["uniacid"]}' {$condition}  ORDER BY createtime DESC LIMIT " . ($pindex - 1) * $psize . ",{$psize}";
goto zESd7;
Mzwj4:
$keyword = $_GPC["keyword"];
goto U4omV;
beARn:
$testSql = "SELECT * FROM " . tablename($this->tablereply) . " WHERE uniacid = '{$_W["uniacid"]}' {$condition}  ORDER BY createtime DESC LIMIT " . ($pindex - 1) * $psize . ",{$psize}";
goto JvRGC;
c9Ais:
z8rj2:
goto LTelG;
qf2pe:
if (empty($list)) {
    goto MTjZi;
}
goto t66s7;
fIxqj:
$psize = 20;
goto vkTXr;
U4omV:
$condition .= " AND title LIKE '%{$keyword}%'";
goto I_SH0;
pyF78:
ttGsT:
goto tyqw6;
s1NVq:
foreach ($list as &$item) {
    goto M9dFT;
    XS241:
    $item["sharetotal"] = pdo_fetchcolumn("SELECT sum(share_total) FROM " . tablename($this->tablecount) . " WHERE rid = :rid ", array(":rid" => $item["rid"]));
    goto iavT5;
    lfI8s:
    $item["config"] = @unserialize($item["config"]);
    goto y6N2b;
    YsRk9:
    wA6f1:
    goto AGnUv;
    iavT5:
    $item["sharetotal"] = !empty($item["sharetotal"]) ? $item["sharetotal"] : 0;
    goto lfI8s;
    TmTh1:
    xEY9k:
    goto yPcF8;
    j9a5v:
    $item["virtualpvtotal"] = pdo_fetchcolumn("SELECT sum(vheat) FROM " . tablename($this->tablevoteuser) . " WHERE rid = :rid ", array(":rid" => $item["rid"]));
    goto iqLm0;
    yPcF8:
    $item["status"] = 4;
    goto Oj1qJ;
    TxYLf:
    if ($item["endtime"] < time()) {
        goto xEY9k;
    }
    goto vSDLM;
    M9dFT:
    if (!($item["status"] == 1)) {
        goto LtgZx;
    }
    goto uR6Vl;
    NmPGX:
    $dd["sqltotal"] = "SELECT count(*) as total FROM silence_vote_robotlist " . $condition;
    goto ICGr6;
    f5TXQ:
    LtgZx:
    goto XpMOu;
    NDOn4:
    $dd["rid"] = $item["rid"];
    goto otxAM;
    otxAM:
    $dd["sql"] = $sql;
    goto NmPGX;
    L2wSu:
    $item["votetotal"] = pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename($this->tablevotedata) . " WHERE   rid = :rid AND votetype=0 ", array(":rid" => $item["rid"]));
    goto y4L3x;
    vSDLM:
    goto B1ck2;
    goto YsRk9;
    y4L3x:
    $item["giftcount"] = pdo_fetchcolumn("SELECT sum(fee) FROM " . tablename($this->tablegift) . " WHERE   rid = :rid AND ispay=1 AND openid != 'addgift' ", array(":rid" => $item["rid"]));
    goto a3MKd;
    bzAko:
    NXnPE:
    goto CeeM_;
    bxeXL:
    $cfg = $this->module["config"];
    goto Ei5bq;
    UpmJy:
    $c = 0;
    goto meBSy;
    bVA7w:
    $sql = "SELECT *  FROM silence_vote_robotlist " . $condition;
    goto NDOn4;
    e1VWr:
    cache_write("robot-" . $uniacid . "-" . $item["rid"], $items);
    goto pPqEn;
    oZwwR:
    $item["agentcount"] = pdo_fetchcolumn("SELECT count(*) FROM " . tablename($this->modulename . "_agentlist") . " WHERE uniacid = :uniacid ", array(":uniacid" => $_W["uniacid"]));
    goto bxeXL;
    zUUdk:
    $item["pvtotal"] = $item["virtualpvtotal"] + $item["pvtotal"];
    goto XS241;
    ICGr6:
    $items = $this->getrobot($dd) ?: "0";
    goto e1VWr;
    hEeZU:
    $c = count($items["info"]);
    goto r6e7S;
    OIPhN:
    $condition = " WHERE uniacid = {$_W["uniacid"]} and rid = {$item["rid"]} and ticket = '{$cfg["ticket"]}'";
    goto bVA7w;
    gnMzM:
    vH7B1:
    goto hEeZU;
    VY2Jq:
    if ($items) {
        goto vH7B1;
    }
    goto UpmJy;
    Ei5bq:
    $items = cache_load("robot-" . $uniacid . "-" . $item["rid"]);
    goto ch61D;
    r6e7S:
    tuKyj:
    goto lcR6i;
    Oj1qJ:
    B1ck2:
    goto f5TXQ;
    ch61D:
    if (!(empty($items) && $items !== "0")) {
        goto pVDts;
    }
    goto OIPhN;
    meBSy:
    goto tuKyj;
    goto gnMzM;
    a3MKd:
    $item["giftcount"] = !empty($item["giftcount"]) ? $item["giftcount"] : 0;
    goto j9a5v;
    uR6Vl:
    if ($item["starttime"] > time()) {
        goto wA6f1;
    }
    goto TxYLf;
    AGnUv:
    $item["status"] = 3;
    goto W0Oe0;
    pPqEn:
    pVDts:
    goto VY2Jq;
    W0Oe0:
    goto B1ck2;
    goto TmTh1;
    lcR6i:
    $item["robotcount"] = $c;
    goto bzAko;
    y6N2b:
    $item["qrcode"] = $_W["siteroot"] . "app/" . $this->createMobileUrl("Qrcodeurl") . "&url=" . urlencode($_W["siteroot"] . "app/" . $this->createMobileUrl("index", array("rid" => $item["rid"], "op" => "originurl")));
    goto oZwwR;
    iqLm0:
    $item["pvtotal"] = pdo_fetchcolumn("SELECT sum(pv_total) FROM " . tablename($this->tablecount) . " WHERE rid = :rid ", array(":rid" => $item["rid"]));
    goto zUUdk;
    XpMOu:
    $item["jointotal"] = pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename($this->tablevoteuser) . " WHERE   rid = :rid  ", array(":rid" => $item["rid"]));
    goto L2wSu;
    CeeM_:
}
goto c9Ais;
DxZVV:
R2gOR:
goto izbWH;
woyxf:
Jz9e4:
goto qf2pe;
I_SH0:
NabU7:
goto beARn;
Y1rRB:
include $this->template("new_manage");