<?php

goto o13Ye;
BtnY1:
$saiqulist = pdo_fetchall("select id,saiquname  from " . tablename($this->modulename . "_saiqu") . "where uniacid = {$uniacid} and rid = '{$rid}'");
goto haRLS;
UkhOP:
global $_GPC, $_W;
goto YEhqU;
QIGCd:
foreach ($saiqulist as $value) {
    $saiqu_info[$value["id"]] = $value["saiquname"];
    dDi2H:
}
goto E5dFC;
De8ff:
echo $html;
goto jPYDw;
hBggt:
$tableheader = array("序号", "编号", "微信昵称", "openid", "姓名", "报名信息", "赛区", "介绍", "票数", "礼物", "审核", "参加时间", "头像", "图片1", "图片2", "图片3", "图片4", "图片5");
goto hQ5Mr;
E5dFC:
D8KmH:
goto yDEbL;
D9Cc_:
die("This example should only be run from a Web Browser");
goto hbmZM;
yF_za:
header("Content-type:text/csv");
goto fz9da;
tulbU:
message("抱歉，传递的参数错误！", '', "error");
goto lSL3e;
fz9da:
header("Content-Disposition:attachment; filename=" . $filename . ".csv");
goto De8ff;
IrTul:
$remote = $modulelist["silence_vote"]["config"]["remote"];
goto ZKHXz;
CbTPp:
$html .= "\n";
goto v6Sm6;
ttAgO:
$uniacid = $_W["uniacid"];
goto nJgjD;
hQ5Mr:
$html = "﻿";
goto Q9vCG;
v6Sm6:
$now = date("Y-m-d H:i:s", time());
goto pG3G8;
ZKHXz:
foreach ($list as $mid => $value) {
    goto lK97V;
    tLNxi:
    $value["img1"] = $prefix . "/" . $value["img1"];
    goto qsUdG;
    nw_1W:
    $html .= $value["img1"] . "\t ,";
    goto hDePu;
    Sxbom:
    $html .= htmlspecialchars($value["name"]) . "\t ,";
    goto PLOf3;
    F0BtC:
    $html .= htmlspecialchars(trim($value["resume"])) . "\t ,";
    goto mDD3D;
    Gf8wm:
    $status = "待审核";
    goto AAXPg;
    mDD3D:
    $html .= $value["votenum"] . "\t ,";
    goto bsqz_;
    h6SjC:
    aLItV:
    goto xkS0s;
    dCXY1:
    $prefix = $_W["attachurl"];
    goto D8LGB;
    EP6b_:
    F1gPl:
    goto WIyFb;
    QK4Y8:
    $join = '';
    goto e7s2X;
    SjwXD:
    $html .= $value["noid"] . "\t ,";
    goto rLQmb;
    WEJsL:
    $html .= date("Y-m-d H:i:s", $value["createtime"]) . "\t ,";
    goto aV9LA;
    tefwx:
    GLrhI:
    goto oM7Lj;
    Zl54r:
    goto sNyhS;
    goto iCHHe;
    g1kgi:
    $value["img2"] = $prefix . "/" . $value["img2"];
    goto iFpym;
    eKrdR:
    L4bOY:
    goto QK4Y8;
    OHSSD:
    $value["img5"] = $prefix . "/" . $value["img5"];
    goto tefwx;
    ZusvP:
    foreach ($joindata as $key => $rom) {
        $join .= $rom["name"] . "：" . $rom["val"] . ";  ";
        dcHD4:
    }
    goto Mu3Wt;
    nkfT9:
    $status = "已审核";
    goto eKrdR;
    K2jXe:
    $value["avatar"] = $prefix . "/" . $value["avatar"];
    goto YytkC;
    rLQmb:
    $html .= htmlspecialchars($value["nickname"]) . "\t ,";
    goto GhMzm;
    D8LGB:
    sNyhS:
    goto NXXWK;
    KBx3_:
    MyhUC:
    goto x1g91;
    LDXsG:
    $prefix = $_W["attachurl_local"];
    goto Zl54r;
    aV9LA:
    $html .= $value["avatar"] . "\t ,";
    goto nw_1W;
    iCHHe:
    mLQsn:
    goto dCXY1;
    hDePu:
    $html .= $value["img2"] . "\t ,";
    goto eGviz;
    AAXPg:
    goto L4bOY;
    goto tq0Vk;
    p9XVG:
    DdPpr:
    goto RV1En;
    xkS0s:
    if (!($value["img5"] && !preg_match("/(http:\\/\\/)|(https:\\/\\/)/i", $value["img5"]))) {
        goto GLrhI;
    }
    goto OHSSD;
    RV1En:
    $html .= $value["id"] . "\t ,";
    goto SjwXD;
    YytkC:
    FVqV_:
    goto JCwCB;
    H38ZI:
    $joindata = @unserialize($value["joindata"]);
    goto ZusvP;
    NXXWK:
    if (!($value["avatar"] && !preg_match("/(http:\\/\\/)|(https:\\/\\/)/i", $value["avatar"]))) {
        goto FVqV_;
    }
    goto K2jXe;
    tq0Vk:
    tTnf8:
    goto nkfT9;
    kqvUL:
    $html .= $status . "\t ,";
    goto WEJsL;
    lK97V:
    if (!empty($_W["setting"]["remote"]["type"])) {
        goto mLQsn;
    }
    goto LDXsG;
    kAswg:
    $html .= $saiqu_info[$value["saiquid"]] . "\t ,";
    goto AcxPr;
    iFpym:
    f3_EZ:
    goto eeESG;
    eeESG:
    if (!($value["img3"] && !preg_match("/(http:\\/\\/)|(https:\\/\\/)/i", $value["img3"]))) {
        goto F1gPl;
    }
    goto VBicG;
    o1jYi:
    $html .= "\n";
    goto wklZp;
    GhMzm:
    $html .= $value["openid"] . "\t ,";
    goto Sxbom;
    Mu3Wt:
    IBuUM:
    goto p9XVG;
    AcxPr:
    $value["resume"] = str_replace(",", "  ", $value["resume"]);
    goto F0BtC;
    yLjcm:
    $html .= $value["img4"] . "\t ,";
    goto zRhyg;
    oM7Lj:
    if ($value["status"] == 1) {
        goto tTnf8;
    }
    goto Gf8wm;
    Ktg82:
    $value["img4"] = $prefix . "/" . $value["img4"];
    goto h6SjC;
    qsUdG:
    iN50s:
    goto G7CiA;
    PLOf3:
    $html .= $join . "\t ,";
    goto kAswg;
    G7CiA:
    if (!($value["img2"] && !preg_match("/(http:\\/\\/)|(https:\\/\\/)/i", $value["img2"]))) {
        goto f3_EZ;
    }
    goto g1kgi;
    WIyFb:
    if (!($value["img4"] && !preg_match("/(http:\\/\\/)|(https:\\/\\/)/i", $value["img4"]))) {
        goto aLItV;
    }
    goto Ktg82;
    eGviz:
    $html .= $value["img3"] . "\t ,";
    goto yLjcm;
    e7s2X:
    if (!($value["joindata"] && unserialize($value["joindata"]))) {
        goto DdPpr;
    }
    goto H38ZI;
    zRhyg:
    $html .= $value["img5"] . "\t ,";
    goto o1jYi;
    VBicG:
    $value["img3"] = $prefix . "/" . $value["img3"];
    goto EP6b_;
    wklZp:
    $join = '';
    goto KBx3_;
    bsqz_:
    $html .= $value["giftcount"] . "\t ,";
    goto kqvUL;
    JCwCB:
    if (!($value["img1"] && !preg_match("/(http:\\/\\/)|(https:\\/\\/)/i", $value["img1"]))) {
        goto iN50s;
    }
    goto tLNxi;
    x1g91:
}
goto wMm2N;
o13Ye:
if (!(PHP_SAPI == "cli")) {
    goto L4225;
}
goto D9Cc_;
JfkOT:
AF30V:
goto RWbOa;
kq76w:
$list = pdo_fetchall("SELECT * FROM " . tablename($this->tablevoteuser) . " WHERE uniacid= :uniacid " . $Where . "  ORDER BY `id` DESC, `createtime` ASC", array(":uniacid" => $_W["uniacid"]));
goto BtnY1;
pG3G8:
$filename = "用户信息" . "_" . $rid . "_" . $now;
goto yF_za;
yDEbL:
load()->model("mc");
goto hBggt;
hbmZM:
L4225:
goto UkhOP;
lSL3e:
p3ARC:
goto x0IxB;
ogohg:
ekSuP:
goto kq76w;
nJgjD:
$this->authorization();
goto m0COw;
yngAl:
$Where .= " AND `rid` = {$rid}";
goto ogohg;
Q9vCG:
foreach ($tableheader as $value) {
    $html .= $value . "\t ,";
    sx8WL:
}
goto JfkOT;
YEhqU:
$rid = intval($_GPC["rid"]);
goto ttAgO;
wMm2N:
iIExt:
goto CbTPp;
m0COw:
if (!empty($rid)) {
    goto p3ARC;
}
goto tulbU;
RWbOa:
$html .= "\n";
goto t69h7;
t69h7:
$modulelist = uni_modules(false);
goto IrTul;
G8Bfb:
if (empty($rid)) {
    goto ekSuP;
}
goto yngAl;
haRLS:
$saiqu_info = array();
goto QIGCd;
x0IxB:
$Where = '';
goto G8Bfb;
jPYDw:
exit;