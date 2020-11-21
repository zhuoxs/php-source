<?php
goto vp15p;
ZF3f5:
if (!($sopranop["free_audio_open"] == 2 && $free_audio["text"])) {
    goto gNOqd;
}
goto zLHkB;
HMA_V:
goto B6ZVh;
goto gAz1S;
kRWw6:
$this->show_error("获取语音失败", "error", $jump_url_error);
goto SBd36;
lLoAs:
if (!($sopranop["before_lasttime"] >= $time_day)) {
    goto lHyjd;
}
goto FMvnY;
ec7no:
if (!($this->get_shoptoken($uniacid, $id) != $token)) {
    goto W14Fo;
}
goto aV3g2;
yiZqj:
$filename = $this->get_code();
goto yXsIN;
qrNAs:
XEs67:
goto zhySy;
fzrbw:
exit(json_encode(array("sta" => 1, "path" => tomedia($free_audio["music"]))));
goto GOTI6;
Z7n1s:
$text_audio = '';
goto Y_s_l;
SYmIl:
if (!$sopranop["rules"]) {
    goto Y4vSa;
}
goto F8YV9;
EIn8Z:
UEQVi:
goto hvGMY;
Ppz80:
$starttime = $time_day - $sopranop["audio_before"] * 86400;
goto uakER;
wJ3Tk:
exit($this->get_audio($filename, $sopranop["per"], $text_audio, true));
goto aOF6o;
FMvnY:
$where2 = " AND id<'{$sopranop["before_rid"]}' ";
goto Z8P40;
CiUio:
exit(json_encode(array("sta" => 1, "path" =>$entry_audio["music"])));
goto L8hok;
PVK0p:
$id = intval($_GPC["id"]);
goto fO2it;
XEVfM:
T9zmC:
goto X9wqf;
cuOJG:
goto FPEe7;
goto RqyVU;
j3Hjx:
W14Fo:
goto QX7fa;
d7wk7:
$data["sta"] = 2;
goto xc9Tm;
BhJzq:
dNQRY:
goto u2UAV;
GjMHj:
exit(json_encode(array("sta" => 1, "path" => tomedia($entry_audio["music"]))));
goto JxDqy;
OriBp:
$red_day = pdo_fetchall("SELECT id,aid,openid,money FROM " . tablename(TABLE_RED) . " WHERE status=1 AND createtime >={$time_day} {$where} {$where1} ORDER BY id ASC LIMIT 5");
goto Bl69T;
QX7fa:
$sopranop = pdo_fetch("SELECT * FROM " . tablename("crad_qrcode_red_soprano") . " WHERE id = :id", array(":id" => $id));
goto fxETe;
dmi5d:
$lasttime = max($sopranop["before_lasttime"], $sopranop["lasttime"]);
goto mweOC;
JRxVd:
$red_new = pdo_fetchall("SELECT id,aid,openid,money FROM " . tablename(TABLE_RED) . " WHERE status=1 AND createtime >={$lasttime} {$where} ORDER BY id DESC LIMIT 5");
goto lk0uO;
TobMP:
EmQNx:
goto DITUE;
RHoxv:
global $_W, $_GPC;
goto Bm9sw;
tPINm:
rRRWO:
goto OcXMd;
S1Mpz:
echo json_encode($data);
goto l6drJ;
X9wqf:
U9D_I:
goto za909;
SsDzg:
if ($sopranop["entry_audio_open"] == 2 && $entry_audio["text"]) {
    goto hUwAM;
}
goto Dimr7;
C82Fb:
if (!($sopranop["lasttime"] >= $time_day)) {
    goto WlDi2;
}
goto N9QjW;
OcXMd:
if (!($sopranop["free_audio_open"] > 0)) {
    goto z68RG;
}
goto wURwJ;
mweOC:
if ($sopranop["aids"]) {
    goto PN2Cv;
}
goto fdSJC;
V2sP2:
$time_day = strtotime(date("Y-m-d" . "00:00:00", time()));
goto dmi5d;
fe9P5:
hUwAM:
goto pf0Df;
o4TFG:
exit($this->get_audio("free_audio_" . $sopranop["id"] . $free_audio["per"], $free_audio["per"], $free_audio["text"], true));
goto TobMP;
XxUNJ:
exit;
goto cuOJG;
ADMf0:
echo json_encode($data);
goto rvdwU;
Bl69T:
if (!$red_day) {
    goto UEQVi;
}
goto Z7n1s;
gAz1S:
PN2Cv:
goto KeEGp;
QveyY:
if ($type == 1) {
    goto Gt9rU;
}
goto V2sP2;
SBd36:
xvZjv:
goto H2vob;
a1Uiq:
$uniacid = $_W["uniacid"];
goto PVK0p;
wURwJ:
$free_audio = json_decode($sopranop["free_audio"], true);
goto pcDgy;
L8hok:
goto T9zmC;
goto qrNAs;
Jb7lV:
pdo_update("crad_qrcode_red_soprano", array("lasttime" => time()), array("id" => $sopranop["id"]));
goto GjMHj;
Odjp6:
$data["error"] = "参数错误";
goto ADMf0;
iDGJs:
l8hHY:
goto Jb7lV;
MVChh:
if ($sopranop["entry_audio_open"] == 1 && $entry_audio["music"]) {
    goto l8hHY;
}
goto SsDzg;
T4Asv:
foreach ($red_bafore as &$value) {
    goto OVGKw;
    OVGKw:
    foreach ($rules as $rule) {
        goto J0GFl;
        xbKAE:
        $value["text_audio"] = $rule["text"];
        goto KZ0ui;
        KZ0ui:
        goto fmorb;
        goto s32Su;
        fDBh2:
        Smf1_:
        goto UxEAa;
        J0GFl:
        if (!(round($value["money"] * 100) >= round($rule["money"] * 100))) {
            goto gJO4p;
        }
        goto xbKAE;
        s32Su:
        gJO4p:
        goto fDBh2;
        UxEAa:
    }
    goto nybAA;
    b7R6m:
    $nick_name = pdo_fetch("SELECT nickname FROM " . tablename(TABLE_USER) . " WHERE openid = :openid AND aid = :aid", array(":openid" => $value["openid"], ":aid" => $value["aid"]));
    goto xQe3U;
    AO_4r:
    $value["text_audio"] = $value["text_audio"] ? $value["text_audio"] : "恭喜，#昵称#，刚刚领取了#金额#元红包";
    goto b7R6m;
    ywQ1S:
    $value["text_audio"] = str_replace("#金额#", $value["money"], $value["text_audio"]);
    goto ZhNgl;
    nrA_D:
    OOdyi:
    goto IZxWW;
    nybAA:
    fmorb:
    goto AO_4r;
    ZhNgl:
    $text_audio .= $value["text_audio"] . "。";
    goto nrA_D;
    xQe3U:
    $value["text_audio"] = str_replace("#昵称#", $nick_name["nickname"], $value["text_audio"]);
    goto ywQ1S;
    IZxWW:
}
goto BhJzq;
zhySy:
exit($this->get_audio("entry_audio_" . $sopranop["id"] . $entry_audio["per"], $entry_audio["per"], $entry_audio["text"], true));
goto XEVfM;
mFUZx:
pdo_update("crad_qrcode_red_soprano", array("lasttime" => time(), "rid" => $red_day_end["id"]), array("id" => $sopranop["id"]));
goto IUOGi;
u2UAV:
$filename = $this->get_code();
goto uuxSt;
hvGMY:
if (!($sopranop["audio_before"] > 0)) {
    goto rRRWO;
}
goto lLoAs;
aicY2:
z68RG:
goto mkNlM;
TeaKn:
if (!(empty($cfg["ticket"]) || !preg_match("/^[A-Za-z0-9]{32}\$/", $cfg["ticket"]))) {
    goto xvZjv;
}
goto kRWw6;
pcDgy:
if ($sopranop["free_audio_open"] == 1 && $free_audio["music"]) {
    goto SRGl8;
}
goto ZF3f5;
AzhPW:
$data["sta"] = 0;
goto ftLkF;
zLHkB:
if (empty($free_audio["music"])) {
    goto ht2Rq;
}
goto Gh47t;
vp15p:
defined("IN_IA") or exit("Access Denied");
goto RHoxv;
Bm9sw:
error_reporting(0);
goto ESrro;
rBv0m:
SRGl8:
goto fzrbw;
Ca2eg:
NsRss:
goto HFdu8;
Y_s_l:
session_start();
goto g7cgE;
fO2it:
$token = trim($_GPC["token"]);
goto gIEEB;
jA99T:
goto eL610;
goto rBv0m;
fxETe:
if (!(empty($sopranop) || $sopranop["status"] == 1)) {
    goto Myr2O;
}
goto AzhPW;
fdSJC:
$where = " AND uniacid='{$uniacid}' ";
goto HMA_V;
F8YV9:
$rules = json_decode($sopranop["rules"], true);
goto C_SeD;
eitUu:
$red_day_end = end($red_day);
goto mFUZx;
ViIFJ:
$text_audio = '';
goto v7ecM;
Gh47t:
exit(json_encode(array("sta" => 1, "path" => tomedia($free_audio["music"]))));
goto YSvWx;
Vi6xz:
exit($this->get_audio($filename, $sopranop["per"], $text_audio, true));
goto Ca2eg;
Bz1GT:
echo json_encode($data);
goto XxUNJ;
uuxSt:
$red_before_end = end($red_bafore);
goto regvE;
l6drJ:
exit;
goto r_Igh;
T88Sa:
if (empty($entry_audio["music"])) {
    goto XEs67;
}
goto CiUio;
uakER:
$red_bafore = pdo_fetchall("SELECT id,aid,openid,money FROM " . tablename(TABLE_RED) . " WHERE status=1 AND createtime<{$time_day} AND createtime >{$starttime} AND  {$where} {$where2} ORDER BY id ASC LIMIT 5");
goto TIrnD;
gIEEB:
$type = intval($_GPC["type"]);
goto ec7no;
TIrnD:
if (!$red_bafore) {
    goto IGcyR;
}
goto HGt6f;
TD0gJ:
B6ZVh:
goto SYmIl;
YSvWx:
goto EmQNx;
goto VmIpT;
ZEPVf:
foreach ($red_day as &$value) {
    goto lQ45l;
    ltPif:
    $value["text_audio"] = $value["text_audio"] ? $value["text_audio"] : "恭喜，#昵称#，刚刚领取了#金额#元红包";
    goto KhDMk;
    KhDMk:
    $nick_name = pdo_fetch("SELECT nickname FROM " . tablename(TABLE_USER) . " WHERE openid = :openid AND aid = :aid", array(":openid" => $value["openid"], ":aid" => $value["aid"]));
    goto d2KTZ;
    v7Jal:
    rqjhX:
    goto KlNvD;
    r9FNw:
    goto WhLHi;
    goto v7Jal;
    KlNvD:
    foreach ($rules as $rule) {
        goto nJZUw;
        nJZUw:
        if (!(round($value["money"] * 100) >= round($rule["money"] * 100))) {
            goto Q40q8;
        }
        goto KQNdT;
        KQNdT:
        $value["text_audio"] = $rule["text"];
        goto tuW09;
        PSnQ3:
        jRnkc:
        goto xRLR2;
        mzz7Y:
        Q40q8:
        goto PSnQ3;
        tuW09:
        goto QXBPt;
        goto mzz7Y;
        xRLR2:
    }
    goto yZXq5;
    AvRC_:
    $text_audio .= $value["text_audio"] . "。";
    goto N_OyQ;
    d2KTZ:
    $value["text_audio"] = str_replace("#昵称#", $nick_name["nickname"], $value["text_audio"]);
    goto GJKCY;
    yZXq5:
    QXBPt:
    goto ltPif;
    GJKCY:
    $value["text_audio"] = str_replace("#金额#", $value["money"], $value["text_audio"]);
    goto AvRC_;
    N_OyQ:
    WhLHi:
    goto kNBOH;
    lQ45l:
    if (!($red_new_ids && in_array($value["id"], $red_new_ids))) {
        goto rqjhX;
    }
    goto r9FNw;
    kNBOH:
}
goto tf1mN;
HGt6f:
$text_audio = '';
goto T4Asv;
g7cgE:
$red_new_ids = $_SESSION["red_new_ids"];
goto ZEPVf;
aV3g2:
$data["sta"] = 0;
goto Odjp6;
JxDqy:
Bs6y5:
goto wnVCh;
WaGiR:
$_SESSION["red_new_ids"] = $red_new_ids;
goto NpLNB;
QIh_t:
session_start();
goto WaGiR;
r_Igh:
goto U9D_I;
goto fe9P5;
VmIpT:
ht2Rq:
goto o4TFG;
YLSxF:
exit;
goto CMm_s;
RqyVU:
Gt9rU:
goto WrLHN;
KeEGp:
$where = " AND aid IN ({$sopranop["aids"]}) ";
goto TD0gJ;
NpLNB:
k2RGf:
goto Vi6xz;
xc9Tm:
echo json_encode($data);
goto YLSxF;
aOF6o:
IGcyR:
goto tPINm;
C_SeD:
Y4vSa:
goto pnEYy;
pf0Df:
pdo_update("crad_qrcode_red_soprano", array("lasttime" => time()), array("id" => $sopranop["id"]));
goto T88Sa;
N9QjW:
$where1 = " AND id>'{$sopranop["rid"]}' ";
goto FIpQv;
H2vob:
$data_str = date("H");
goto XpuNA;
DITUE:
gNOqd:
goto jA99T;
HO59m:
$cfg = $this->module["config"]["api"];
goto TeaKn;
HFdu8:
TrRNy:
goto C82Fb;
za909:
goto Bs6y5;
goto iDGJs;
ftLkF:
echo json_encode($data);
goto Ai7B0;
Dimr7:
$data["sta"] = 0;
goto S1Mpz;
regvE:
pdo_update("crad_qrcode_red_soprano", array("before_lasttime" => time(), "rid" => $red_before_end["before_rid"]), array("id" => $sopranop["id"]));
goto wJ3Tk;
YLczZ:
if (!$red_new_ids) {
    goto k2RGf;
}
goto QIh_t;
FIpQv:
WlDi2:
goto OriBp;
tf1mN:
Bpjge:
goto XY_TJ;
IUOGi:
exit($this->get_audio($filename, $sopranop["per"], $text_audio, true));
goto EIn8Z;
rvdwU:
exit;
goto j3Hjx;
mkNlM:
$data["sta"] = 0;
goto Bz1GT;
yXsIN:
pdo_update("crad_qrcode_red_soprano", array("lasttime" => time()), array("id" => $sopranop["id"]));
goto YLczZ;
QBb_N:
Myr2O:
goto HO59m;
XY_TJ:
$filename = $this->get_code();
goto eitUu;
Z8P40:
lHyjd:
goto Ppz80;
lTrZw:
bxz7n:
goto yiZqj;
Ai7B0:
exit;
goto QBb_N;
ESrro:
header("Content-type:application/json");
goto a1Uiq;
GOTI6:
eL610:
goto aicY2;
tH8ii:
foreach ($red_new as &$value) {
    goto v5cj_;
    mA1SG:
    jKGIZ:
    goto R8DOX;
    CHzKI:
    $nick_name = pdo_fetch("SELECT nickname FROM " . tablename(TABLE_USER) . " WHERE openid = :openid AND aid = :aid", array(":openid" => $red_new["openid"], ":aid" => $red_new["aid"]));
    goto Ia2ov;
    qPOg3:
    Dsf1B:
    goto kMxuO;
    Ia2ov:
    $value["text_audio"] = str_replace("#昵称#", $nick_name["nickname"], $value["text_audio"]);
    goto f_bOZ;
    R8DOX:
    $value["text_audio"] = $value["text_audio"] ? $value["text_audio"] : "恭喜，#昵称#，刚刚领取了#金额#元红包";
    goto CHzKI;
    f_bOZ:
    $value["text_audio"] = str_replace("#金额#", $value["money"], $value["text_audio"]);
    goto ZE8lj;
    CyFs9:
    $red_new_ids[] = $value["id"];
    goto qPOg3;
    ZE8lj:
    $text_audio .= $value["text_audio"] . "。";
    goto CyFs9;
    v5cj_:
    foreach ($rules as $rule) {
        goto ycfpn;
        arFWz:
        goto jKGIZ;
        goto xFcTG;
        xFcTG:
        Py2hh:
        goto hl0oZ;
        hl0oZ:
        rFL23:
        goto iYJtx;
        t3bo7:
        $value["text_audio"] = $rule["text"];
        goto arFWz;
        ycfpn:
        if (!(round($value["money"] * 100) >= round($rule["money"] * 100))) {
            goto Py2hh;
        }
        goto t3bo7;
        iYJtx:
    }
    goto mA1SG;
    kMxuO:
}
goto lTrZw;
v7ecM:
$red_new_ids = array();
goto tH8ii;
lk0uO:
if (!$red_new) {
    goto NsRss;
}
goto ViIFJ;
pnEYy:
if (!($lasttime > $time_day)) {
    goto TrRNy;
}
goto JRxVd;
WrLHN:
$entry_audio = json_decode($sopranop["entry_audio"], true);
goto MVChh;
CMm_s:
QfCr2:
goto QveyY;
XpuNA:
if (!($sopranop["starttime"] && $data_str < $sopranop["starttime"] || $sopranop["endtime"] && $data_str > $sopranop["endtime"])) {
    goto QfCr2;
}
goto d7wk7;
wnVCh:
FPEe7: