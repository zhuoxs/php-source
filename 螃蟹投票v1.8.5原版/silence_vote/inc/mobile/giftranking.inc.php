<?php
goto ocd1R;
Q3yY6:
if (empty($list)) {
    goto rq9dp;
}
goto yS1y0;
Z3mnw:
if ($reply["htmlmode"] == 0) {
    goto VQH3L;
}
goto eV9D8;
aupge:
$reply = pdo_fetch("SELECT htmlmode  FROM " . tablename($this->tablereply) . " WHERE rid = :rid ", array(":rid" => $rid));
goto Z3mnw;
zeM14:
$userinfo = $this->oauthuser;
goto Fnyfv;
lGH0j:
$mygift["totalfee"] = $mygift["totalfee"] ?: 0;
goto aupge;
l0g1o:
rq9dp:
goto Dx6LB;
ocd1R:
defined("IN_IA") or exit("Access Denied");
goto eNeIm;
g3Mlm:
$oauth_openid = $userinfo["oauth_openid"];
goto mj0W9;
Fq8G1:
include $this->template(m("tpl")->style("giftranking", $reply["style"]["template"]));
goto YApqd;
qlBjQ:
$rid = intval($_GPC["rid"]);
goto j0niU;
MLWAa:
$mygift["giftcount"] = $mygift["giftcount"] ?: 0;
goto lGH0j;
mj0W9:
$follow = $userinfo["follow"];
goto GuAAq;
xb46z:
$filepath = MODULE_ROOT . "/template/mobile/mode{$reply["htmlmode"]}/{$prefix}_giftranking.html";
goto exQ8x;
xOCtZ:
$reply1 = pdo_fetch("SELECT * FROM " . tablename($this->tablereply) . " WHERE rid = :rid ", array(":rid" => $rid));
goto SS2z5;
HKYUQ:
$list = pdo_fetchall("SELECT sum(giftcount) as giftcount,sum(fee) as totalfee,openid,avatar,nickname FROM " . tablename($this->tablegift) . " WHERE tid = {$id} and rid= {$rid} AND (ispay=1) AND status=0 group by openid,nickname order by totalfee desc  LIMIT " . ($pindex - 1) * $psize . "," . $psize);
goto Q3yY6;
ba4a1:
he9jH:
goto feJyV;
feJyV:
$sta = 200;
goto l0g1o;
UVffy:
$reply1["globallw"] ?: ($reply1["globallw"] = "礼物");
goto fKADn;
fKADn:
$_W["page"]["sitename"] = "{$reply1["globallw"]}排名";
goto zeM14;
ceLon:
if ($prefix) {
    goto WFzer;
}
goto d0BYH;
bhhO1:
goto eUOLY;
goto LIGJi;
SS2z5:
$reply1 = @array_merge($reply1, @unserialize($reply1["config"]));
goto Gb4EO;
GuAAq:
$nowpage = $_GPC["limit"];
goto piH5s;
hhD1U:
include $this->template(m("tpl")->style($prefix . "_" . "giftranking", "mode" . $reply["htmlmode"]));
goto bhhO1;
i5zO2:
$openid = $userinfo["openid"];
goto WPxac;
eV9D8:
$prefix = $this->get_tplprefix($reply["htmlmode"]);
goto ceLon;
d0BYH:
//vote_message("系统提示", "选用的模板主题{$reply["htmlmode"]}未授权 请联系客服！", referer(), "error");
goto TRBfq;
yS1y0:
foreach ($list as $key => $value) {
    goto IrC5d;
    AvFCC:
    uudT5:
    goto Cfhoq;
    LNQvi:
    $list[$key]["avatar"] = MODULE_URL . "/template/static/images/niming.jpg";
    goto sU2K3;
    gxFjf:
    if (empty($reply["isdiamondnone"])) {
        goto pwxH4;
    }
    goto LNQvi;
    Sq8cT:
    $list[$key]["cont"] = htmlspecialchars($value["nickname"] . "，给TA送了" . $value["giftcount"] . "份！");
    goto AvFCC;
    rg3lN:
    $list[$key]["cont"] = htmlspecialchars("微信用户，给TA送了" . $value["giftcount"] . "份！");
    goto eW_Du;
    sU2K3:
    $list[$key]["nickname"] = "微信用户";
    goto rg3lN;
    eW_Du:
    goto uudT5;
    goto UbBw5;
    IrC5d:
    $list[$key]["avatar"] = tomedia($value["avatar"]);
    goto gxFjf;
    UbBw5:
    pwxH4:
    goto Sq8cT;
    Cfhoq:
    WZ3Ko:
    goto hrd7T;
    hrd7T:
}
goto ba4a1;
LIGJi:
VQH3L:
goto Fq8G1;
S6060:
vote_message("系统提示", "选用的模板主题{$reply["htmlmode"]}文件不存在 请联系客服！", referer(), "error");
goto i5Uyw;
Dx6LB:
$mygift = pdo_fetch("SELECT sum(giftcount) as giftcount,sum(fee) as totalfee,openid,avatar,nickname FROM " . tablename($this->tablegift) . " WHERE openid = '{$openid}' and tid = {$id} and rid= {$rid} AND (ispay=1) AND status=0 ");
goto MLWAa;
TRBfq:
WFzer:
goto xb46z;
j0niU:
$id = intval($_GPC["id"]);
goto xOCtZ;
piH5s:
$pindex = max(1, intval($nowpage));
goto W0V2P;
WPxac:
$avatar = $userinfo["avatar"];
goto g3Mlm;
Gb4EO:
unset($reply1["config"]);
goto UVffy;
Fnyfv:
$nickname = $userinfo["nickname"];
goto i5zO2;
W0V2P:
$psize = 20;
goto HKYUQ;
eNeIm:
global $_W, $_GPC;
goto qlBjQ;
i5Uyw:
YTmTF:
goto hhD1U;
exQ8x:
if (is_file($filepath)) {
    goto YTmTF;
}
goto S6060;
YApqd:
eUOLY:
goto RWDhE;
RWDhE:
exit;