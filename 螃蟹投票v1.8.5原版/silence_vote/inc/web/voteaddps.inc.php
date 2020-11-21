<?php

goto cP8Ke;
Hyxjz:
Tpa5u:
goto IPSWz;
hxXVj:
$cfg = $this->module["config"];
goto gAT6m;
XYK_T:
goto G54Zd;
goto G5ruC;
X8sSo:
$adsc = "asc";
goto EBQfn;
ZvAz5:
fXXtS:
goto yQAGL;
Z46t3:
$where = '';
goto PfqTP;
EG0El:
if ($data["type"] == 2) {
    goto ipizd;
}
goto y2BDB;
FhS_t:
$content = ihttp_post($url, $post_data);
goto c9NRw;
VAi90:
$reply["config"] = @unserialize($reply["config"]);
goto W2ZcL;
B_O0O:
foreach ($array as $key => $value) {
    $fid .= "," . $value["id"];
    YDLYt:
}
goto RiBPD;
eE_rk:
$fid = 0;
goto BpNB6;
afiO2:
goto VZUge;
goto h030s;
xRLO3:
global $_GPC, $_W;
goto rIagj;
wdOxE:
$where = " and source_id != 0 ";
goto yE1jx;
KZeZW:
$allid = pdo_fetchall("select id from " . tablename($this->modulename . "_voteuser") . " where uniacid = {$uniacid} and rid = {$rid} " . $where);
goto kR5Ej;
HPxpA:
hZook:
goto OE0Ob;
xKs6r:
$_W["page"]["title"] = "造势管理";
goto L3ldV;
RdALR:
dtZEI:
goto lm9vZ;
G5ruC:
esrXg:
goto qmHz4;
RsZm3:
E74RN:
goto HbE3A;
pvZyz:
$adsc = "desc";
goto HPxpA;
aIci6:
goto rVYk_;
goto e2xkC;
d_488:
XkUhO:
goto VeR9W;
y2BDB:
if ($data["type"] == 3 || $data["type"] == 4) {
    goto esrXg;
}
goto wNTLo;
CN6By:
AzAS0:
goto UB2r3;
qmHz4:
if ($data["type"] == 3) {
    goto Rm53x;
}
goto X8sSo;
EBQfn:
goto hZook;
goto dUkml;
HbE3A:
message("造势成功！", referer(), "success");
goto aZme6;
iOLCw:
message("活动rid不存在！");
goto d_488;
eO9ri:
if ($result["sta"]) {
    goto fXXtS;
}
goto Zq0dx;
sowyV:
$where = " and  id in ({$fid})";
goto lXOLS;
OUX_f:
$post_data = array("time" => time(), "ticket" => $cfg["ticket"], "module_id" => 3);
goto ENXzv;
iql5T:
load()->func("communication");
goto FhS_t;
C8tZo:
if ($operation == "post") {
    goto AzAS0;
}
goto afiO2;
dUkml:
Rm53x:
goto pvZyz;
dmFr8:
$data = $_GPC["data"];
goto pxRh7;
vc_Y4:
exit;
goto F517y;
GKuBO:
goto u9bIZ;
goto RdALR;
jtzj0:
$vote_max = intval($_GPC["vote_max"]);
goto V1upo;
lXOLS:
G54Zd:
goto aIci6;
L3ldV:
$operation = !empty($_GPC["op"]) ? $_GPC["op"] : "display";
goto sVG5h;
CjNZK:
$check = pdo_fetch("select * from " . tablename($this->modulename . "_reply") . " where rid = {$rid}");
goto ZuiL8;
c9NRw:
$result = json_decode($content["content"], true);
goto eO9ri;
rIagj:
checklogin();
goto hxXVj;
xDQty:
$vote_min = $vote_min ? $vote_min : 1;
goto jtzj0;
OcOju:
FY2mU:
goto RsZm3;
X6rBe:
rVYk_:
goto GKuBO;
ZuiL8:
if ($check) {
    goto XkUhO;
}
goto iOLCw;
RI7dt:
goto PBqgt;
goto ZvAz5;
Zq0dx:
//message("授权错误，请联系客服！", "referer", "error");
goto RI7dt;
OE0Ob:
$rknum = $_GPC["ranknum"];
goto eE_rk;
SnP8t:
$where = " and (openid != '' and openid != '0' ) ";
goto X6rBe;
sVG5h:
$uniacid = !empty($_W["uniacid"]) ? $_W["uniacid"] : intval($_GET["uniacid"]);
goto FV_wb;
Is4D8:
$rid = $_GPC["rid"];
goto CjNZK;
VeR9W:
$reply = pdo_fetch("SELECT * FROM " . tablename($this->tablereply) . " WHERE rid = :rid ORDER BY `id` DESC", array(":rid" => $_GPC["rid"]));
goto VAi90;
BpNB6:
$array = pdo_fetchall("select id from " . tablename($this->modulename . "_voteuser") . " where  uniacid = {$uniacid} and rid = {$rid} order by votenum {$adsc} limit 0,{$rknum}");
goto B_O0O;
PfqTP:
if ($data["type"] == 0) {
    goto Tpa5u;
}
goto ieISF;
W2ZcL:
include $this->template("vote_addps");
goto vc_Y4;
wNTLo:
if (!($data["type"] == 5)) {
    goto Zjk_a;
}
goto wdOxE;
pxRh7:
$vote_min = intval($_GPC["vote_min"]);
goto xDQty;
cP8Ke:
defined("IN_IA") or exit("Access Denied");
goto xRLO3;
ENXzv:
ksort($post_data);
goto R4jZT;
yQAGL:
PBqgt:
goto uyDC2;
ieISF:
if ($data["type"] == 1) {
    goto dtZEI;
}
goto EG0El;
gAT6m:
$url = $this->auth_url . "/index/vote/checkauth";
goto OUX_f;
IPSWz:
$where = '';
goto M_Gyn;
F517y:
goto VZUge;
goto CN6By;
lm9vZ:
$where = " and (openid = '' or openid = '0') ";
goto BnXHa;
M_Gyn:
HCIpp:
goto KZeZW;
aM12r:
goto HCIpp;
goto Hyxjz;
h030s:
eR2bQ:
goto Is4D8;
FV_wb:
if ($operation == "display") {
    goto eR2bQ;
}
goto C8tZo;
kR5Ej:
foreach ($allid as $v) {
    goto c91mA;
    is2Ex:
    $addrd = round($addps * 1.2);
    goto T13vg;
    T13vg:
    $sql = "update " . tablename($this->modulename . "_voteuser") . " set votenum = votenum+{$addps},vheat = vheat + {$addrd} where uniacid = {$uniacid} and rid = {$rid} and id = {$v["id"]}";
    goto zKrzP;
    c91mA:
    $addps = rand($vote_min, $vote_max);
    goto is2Ex;
    zKrzP:
    pdo_query($sql);
    goto SWAVD;
    SWAVD:
    q9XF9:
    goto EAv18;
    EAv18:
}
goto OcOju;
JDAiw:
$rid = $_GPC["rid"];
goto dmFr8;
RiBPD:
QeU9c:
goto sowyV;
yE1jx:
Zjk_a:
goto XYK_T;
V1upo:
$vote_max = $vote_max ? $vote_max : $vote_min + 100;
goto Z46t3;
e2xkC:
ipizd:
goto SnP8t;
UB2r3:
if (!checksubmit("submit")) {
    goto E74RN;
}
goto JDAiw;
R4jZT:
$post_data["token"] = md5(sha1(implode('', $post_data)));
goto iql5T;
BnXHa:
u9bIZ:
goto aM12r;
uyDC2:
load()->func("tpl");
goto xKs6r;
aZme6:
VZUge: