<?php

goto P7zcr;
x1kl1:
s1GIq:
goto pxvgu;
bbBLP:
pdo_insert($this->modulename . "_robotstatus", $data);
goto FmsiU;
L17wD:
$check = pdo_fetch("SELECT * FROM " . tablename($this->modulename . "_robotstatus") . " WHERE uniacid = {$uniacid}");
goto AoGfB;
jEhRu:
$headers = array("Content-Type" => "application/x-www-form-urlencoded");
goto JyaUe;
NYlHW:
$msg .= "缓慢跟随脚本已在运行中，无需触发!";
goto weOuW;
sTE5s:
WbV5G:
goto J7oE8;
Kffc1:
$data["mode2"] = 1;
goto J9D2C;
xt6Qp:
tfNyw:
goto nYHPe;
ypgJL:
$msg = '';
goto LUXuS;
nYHPe:
if ($check["mode3"] == 0) {
    goto GuFRK;
}
goto S0CnW;
J7oE8:
$post = array();
goto bTD00;
grukW:
if ($check["mode2"] == 0) {
    goto C11Iu;
}
goto NYlHW;
oKIuV:
fnyUW:
goto Yir2R;
HcER8:
foreach ($ud as $value) {
    goto DhGLa;
    Jdn_S:
    e3CKF:
    goto VjL5F;
    DhGLa:
    $url = $this->createMobileUrl($value);
    goto aG0mT;
    gis_Z:
    $a = ihttp_request($url, $post, $headers, 1);
    goto Jdn_S;
    aG0mT:
    $url = $_W["siteroot"] . "app" . str_replace("./index.php?", "/index.php?", $url);
    goto gis_Z;
    VjL5F:
}
goto jreSF;
Gx16Q:
$msg .= "快速超越脚本触发成功!";
goto oKIuV;
TALqq:
if (!($robotstatus == 0)) {
    goto I9dhU;
}
goto WxsMU;
c6zPR:
I9dhU:
goto L17wD;
S0CnW:
$msg .= "快速超越脚本已在运行中，无需触发!";
goto VJoLS;
hRqwa:
goto osMh_;
goto VifOc;
AoGfB:
if (!$check) {
    goto WbV5G;
}
goto J34O5;
ylwym:
$data["mode4"] = 1;
goto m4pdU;
FmsiU:
$msg = "机器人脚本初始化成功";
goto r8vyu;
qz1Y8:
$post = array();
goto ogF4H;
WXfwi:
$msg .= "缓慢超越脚本已在运行中，无需触发!";
goto hRqwa;
gRUt5:
s7yi0:
goto b4Jz4;
Ji8Wr:
$data["mode1"] = 1;
goto RkLsE;
adLIE:
GuFRK:
goto MLqpK;
p0v_B:
if ($check["mode1"] == 0) {
    goto s1GIq;
}
goto rEK0b;
YpcNJ:
$data["mode2"] = 1;
goto Z3od_;
Oitut:
$data["uniacid"] = $uniacid;
goto bbBLP;
jreSF:
FZXwE:
goto pPLKh;
bTD00:
load()->func("communication");
goto jEhRu;
oNZyU:
foreach ($urla as $value) {
    goto I5mSH;
    RxQVj:
    $url = $_W["siteroot"] . "app" . str_replace("./index.php?", "/index.php?", $url);
    goto ru19x;
    I5mSH:
    $url = $this->createMobileUrl($value);
    goto RxQVj;
    ru19x:
    $a = ihttp_request($url, $post, $headers, 1);
    goto lz7g3;
    lz7g3:
    v2gUQ:
    goto dm1Mv;
    dm1Mv:
}
goto gRUt5;
D21Vc:
goto k8co2;
goto sTE5s;
pPLKh:
$data["mode1"] = 1;
goto YpcNJ;
mIZ27:
$headers = array("Content-Type" => "application/x-www-form-urlencoded");
goto oNZyU;
NdP2u:
osMh_:
goto qz1Y8;
pxvgu:
$urla[] = "robotmode1";
goto Ji8Wr;
eQD7p:
global $_W, $_GPC;
goto XVJnG;
m4pdU:
$msg .= "缓慢超越脚本触发成功!";
goto NdP2u;
J9D2C:
$msg .= "缓慢跟随脚本触发成功!";
goto xt6Qp;
z5ytR:
$data["mode4"] = 1;
goto Oitut;
gIQjL:
exit;
goto c6zPR;
J7sqm:
goto TXDYJ;
goto x1kl1;
LUXuS:
$robotstatus = $this->module["config"]["robotstatus"];
goto TALqq;
MLqpK:
$urla[] = "robotmode3";
goto Jam0u;
VJoLS:
goto fnyUW;
goto adLIE;
I2oDU:
$urla = array();
goto p0v_B;
WxsMU:
message("当前公众号未开启机器人模式 请在参数里设置", referer(), "error");
goto gIQjL;
Z3od_:
$data["mode3"] = 1;
goto z5ytR;
ThEV4:
load()->func("tpl");
goto j3V4n;
CiUhg:
$urla[] = "robotmode2";
goto Kffc1;
Yir2R:
if ($check["mode4"] == 0) {
    goto FEBea;
}
goto WXfwi;
rEK0b:
$msg .= "快速跟随脚本已在运行中，无需触发!";
goto J7sqm;
ogF4H:
load()->func("communication");
goto mIZ27;
slGSB:
$urla[] = "robotmode4";
goto ylwym;
cntic:
TXDYJ:
goto grukW;
r8vyu:
k8co2:
goto J0K26;
JyaUe:
$ud = array("robotmode1", "robotmode2", "robotmode3", "robotmode4");
goto HcER8;
RkLsE:
$msg .= "快速跟随脚本触发成功!";
goto cntic;
weOuW:
goto tfNyw;
goto bzfnu;
Jam0u:
$data["mode3"] = 1;
goto Gx16Q;
VifOc:
FEBea:
goto slGSB;
bzfnu:
C11Iu:
goto CiUhg;
J34O5:
$data = array();
goto I2oDU;
j3V4n:
$uniacid = !empty($_W["uniacid"]) ? $_W["uniacid"] : intval($_GET["uniacid"]);
goto ypgJL;
P7zcr:
defined("IN_IA") or exit("Access Denied");
goto eQD7p;
b4Jz4:
$data ? pdo_update($this->modulename . "_robotstatus", $data, array("uniacid" => $uniacid)) : '';
goto D21Vc;
XVJnG:
checklogin();
goto ThEV4;
J0K26:
message($msg, referer(), "success");