<?php

goto M1zpC;
Yr_m9:
$rid = intval($_GPC["rid"]);
goto WQnDf;
H0f_j:
exit;
goto FZXIR;
kDS1f:
exit(json_encode($out));
goto RINw0;
eFZpc:
$voteuser = pdo_fetch("SELECT * FROM " . tablename($this->tablevoteuser) . " WHERE  id = :id AND uniacid = :uniacid AND rid = :rid", array(":id" => $id, ":uniacid" => $uniacid, ":rid" => $rid));
goto mG73O;
KiLdG:
if (!($ty == "lock")) {
    goto rP2GK;
}
goto xa9A0;
NlAbW:
message("删除成功！", $this->createWebUrl("votelist", array("name" => "silence_vote", "rid" => $rid)), "success");
goto Qc595;
paPAV:
array_unshift($info, $a);
goto ye7PX;
evbQu:
if (!($ty == "indexff")) {
    goto wl4eN;
}
goto HzJsQ;
lmGVE:
echo json_encode(array("pic" => $pic, "btn" => $btn));
goto JdFBU;
pfMwn:
global $_GPC, $_W;
goto WAQPr;
FB99k:
FHoP0:
goto pA9gA;
ucU0V:
GpsVE:
goto UQyZf;
Q_p8w:
pdo_delete($this->tableredpack, array("id" => $id, "uniacid" => $uniacid));
goto QobyE;
Xkcgs:
pdo_update($this->tablereply, array("config" => $cdatacfg), array("uniacid" => $uniacid, "rid" => $rid));
goto lSh_k;
jxCyX:
Qi2xr:
goto evbQu;
Eb8fB:
$out["status"] = 200;
goto VX2I2;
FOu2K:
mMiO8:
goto FMstk;
zVqQ0:
pdo_update($this->tablevotedata, array("status" => 1 - $_GPC["status"]), array("id" => intval($_GPC["vid"]), "tid" => $id, "rid" => $rid, "uniacid" => $uniacid));
goto v8x0Z;
iSWpU:
UnckS:
goto sm8Pq;
kRF8m:
exit;
goto lmGVE;
jSdJN:
BbFdA:
goto odtly;
aCTmm:
ooXnw:
goto huntj;
ij_BH:
print_r($_GPC["idArr"]);
goto H0f_j;
rnPBy:
goto FHoP0;
goto ucU0V;
iqbkz:
$out["msg"] = "下载失败，请重试";
goto kDS1f;
mfA2f:
vTDvI:
goto i5gHU;
VjRGN:
$pic = tpl_form_field_image("indexpic[]");
goto IplVs;
NXKCf:
Angfv:
goto irVPA;
v8x0Z:
goto BbFdA;
goto OTx3z;
huntj:
if (!($ty == "repeatredpack")) {
    goto auzBh;
}
goto KWvsf;
BcDtG:
OllXV:
goto KiTtB;
WgEYD:
exit(json_encode($out));
goto lVEfR;
LApQJ:
auzBh:
goto pjoY1;
Qc595:
VYH6S:
goto SyKoo;
UQyZf:
$out["status"] = 200;
goto FyIBs;
lVEfR:
goto SsJiX;
goto kB1ee;
ye7PX:
echo json_encode($info);
goto cabGx;
VIBmZ:
$out["status"] = 404;
goto WgEYD;
ZFbZe:
exit(json_encode($out));
goto mfA2f;
vsYj_:
vWtbC:
goto Nz7V_;
odtly:
dD5kW:
goto cJtOV;
xHcvr:
yI347:
goto vDByv;
n6MXn:
message($sendr, $this->createWebUrl("lottery", array("name" => "silence_tuanyuan", "rid" => $rid)), "success");
goto LApQJ;
GyTrP:
if ($_GPC["status"] == 1) {
    goto CVto1;
}
goto CW1_0;
cmMMS:
$postdata = array("first" => array("value" => "'{$voteuser["nickname"]}'你参加的活动审核未通过", "color" => "#173177"), "keyword1" => array("value" => $reply["title"], "color" => "#173177"), "keyword2" => array("value" => date("Y.m.d", $reply["starttime"]) . "-" . date("Y.m.d", $reply["endtime"]), "color" => "#173177"), "remark" => array("value" => "点击此处链接进入选手页面", "color" => "#173177"));
goto L7zlB;
BieE3:
$out["status"] = 200;
goto ZFbZe;
KKnE9:
$cfg = $this->module["config"];
goto duFS0;
z9RxI:
$status = intval($_GPC["status"]);
goto YAIj3;
r025u:
vwTlL:
goto DGpXI;
fkM8J:
SsJiX:
goto aCTmm;
xa9A0:
if (!$_W["ispost"]) {
    goto IDH1J;
}
goto SRYOK;
mG73O:
$reply = pdo_fetch("SELECT * FROM " . tablename($this->tablereply) . " WHERE  uniacid = :uniacid AND rid = :rid", array(":uniacid" => $uniacid, ":rid" => $rid));
goto gluOM;
nNeSj:
exit(json_encode($out));
goto kSsnX;
Lcy1u:
if (!($ty == "delposterimg")) {
    goto GOMwe;
}
goto mB3rQ;
PGCSx:
$sendr = m("redpack")->sendredpack($redpackid, $rid);
goto uhXYV;
t4OGP:
if (file_exists($file)) {
    goto Mfl64;
}
goto VIBmZ;
kPdw5:
if (!pdo_update($this->tablevoteuser, array("status" => $audit), array("id" => $id, "rid" => $rid, "uniacid" => $uniacid))) {
    goto vTDvI;
}
goto eFZpc;
k3_bq:
$a = ["id" => 0, "text" => "无赛区"];
goto paPAV;
tT9BM:
O8EJa:
goto R53rk;
dCLuR:
if (!$setvotestatus) {
    goto dD5kW;
}
goto GyTrP;
OTx3z:
J2ejz:
goto nx7JH;
wnmKA:
$viporder = pdo_fetch("SELECT * FROM " . tablename($this->tableviporder) . " WHERE  id = :id AND uniacid = :uniacid ", array(":id" => $id, ":uniacid" => $uniacid));
goto dayIj;
F3Wuv:
message("删除成功！", $this->createWebUrl("viporder", array("name" => "silence_vote")), "success");
goto M9N37;
T4yUh:
$voteuser = pdo_fetch("SELECT * FROM " . tablename($this->tablevoteuser) . " WHERE  id = :id AND uniacid = :uniacid AND rid = :rid", array(":id" => $id, ":uniacid" => $uniacid, ":rid" => $rid));
goto pnGQE;
pnGQE:
if (empty($voteuser)) {
    goto VYH6S;
}
goto TrHup;
MnCSl:
$out["status"] = 1;
goto UL30F;
nvfMx:
$re = del_dir($dirName);
goto Eb8fB;
kh_Ub:
Sih45:
goto oONvA;
rrAwL:
sKpC_:
goto NXKCf;
HzJsQ:
$isindexff = $_GPC["isindexff"];
goto J4Cye;
oUhOt:
message("删除失败，不存在该红包！", "error");
goto uYxKV;
pUvg0:
goto PzlKz;
goto fzOKg;
cgS8x:
exit(json_encode($out));
goto rnPBy;
dKvLk:
$id = intval($_GPC["id"]);
goto Yr_m9;
cJtOV:
ysrEV:
goto iSWpU;
SrUvm:
goto woTY9;
goto vHcFv;
dcFyt:
exit(json_encode($out));
goto jSdJN;
ZwtB5:
$d = $acc->sendTplNotice($voteuser["openid"], $cfg["OPENTM412230652"], $postdata, $re_url, $topcolor = "#FF683F");
goto rx2ml;
oONvA:
$temp = pdo_update($this->tablereply, array("status" => $status), array("rid" => $rid, "uniacid" => $uniacid));
goto hxEH7;
lbBGu:
$votedata = pdo_fetch("SELECT * FROM " . tablename($this->tablevoteuser) . " WHERE  id = :id AND uniacid = :uniacid AND rid = :rid", array(":id" => $id, ":uniacid" => $uniacid, ":rid" => $rid));
goto aKHuy;
VlcQa:
$voteuser = pdo_fetch("SELECT id,createtime FROM " . tablename($this->tablevoteuser) . " WHERE  id = :id AND uniacid = :uniacid AND rid = :rid", array(":id" => $id, ":uniacid" => $uniacid, ":rid" => $rid));
goto e3jIw;
zgXKl:
OkpRj:
goto Lcy1u;
SCLeb:
ybK48:
goto ZwZOS;
pA9gA:
IDH1J:
goto GDX6U;
WQnDf:
if (!($ty == "audit")) {
    goto O8EJa;
}
goto l2He4;
aKHuy:
$formatdata = unserialize($votedata["formatdata"]);
goto HsLcY;
M9N37:
Q20kE:
goto W93aJ;
eRlI1:
exit(json_encode($out));
goto tc9iQ;
l2He4:
if (!$_W["ispost"]) {
    goto Cptk8;
}
goto dRFUd;
CW1_0:
$setvotesql = "update " . tablename($this->tablevoteuser) . " set votenum=votenum+1 where id = " . $id;
goto SrUvm;
ozoj3:
Jzml6:
goto nrGcx;
kB1ee:
Mfl64:
goto wuLch;
sm8Pq:
if (!($ty == "setgiftstatus")) {
    goto vWtbC;
}
goto nNdIT;
u9mI5:
pdo_delete($this->tablecount, array("tid" => $id, "rid" => $rid, "uniacid" => $uniacid));
goto NlAbW;
Nz7V_:
if (!($ty == "downpic")) {
    goto TCkcJ;
}
goto lbBGu;
FMstk:
$out["status"] = 0;
goto nNeSj;
PWUNW:
$cdatacfg["isindexff"] = $isindexff;
goto VrENi;
BTxWg:
GOMwe:
goto lLY8F;
J4Cye:
$cdata = pdo_fetch("select config from " . tablename($this->tablereply) . " where uniacid = {$uniacid} and rid = {$rid}");
goto WfbG2;
vBFzm:
if ($resetvote) {
    goto J2ejz;
}
goto zVqQ0;
lhQzn:
var_dump(htmlspecialchars($pic));
goto kRF8m;
UL30F:
$out["imgurl"] = tomedia($imgurl);
goto eRlI1;
SyKoo:
message("删除失败，不存在该投票！", "error");
goto xHcvr;
AihOQ:
if ($lock == 1) {
    goto gi60T;
}
goto rBw3j;
MnTEc:
$postdata = array("first" => array("value" => "'{$voteuser["nickname"]}'你参加的活动审核已通过", "color" => "#173177"), "keyword1" => array("value" => $reply["title"], "color" => "#173177"), "keyword2" => array("value" => date("Y.m.d", $reply["starttime"]) . "-" . date("Y.m.d", $reply["endtime"]), "color" => "#173177"), "remark" => array("value" => "点击此处链接进入选手页面", "color" => "#173177"));
goto ZwtB5;
vDByv:
if (!($ty == "deleteviporder")) {
    goto h8Cnt;
}
goto wnmKA;
VrENi:
$cdatacfg = serialize($cdatacfg);
goto Xkcgs;
W93aJ:
message("删除失败，不存在该投票！", "error");
goto VH5c6;
QobyE:
message("删除成功！", $this->createWebUrl("lottery", array("name" => "silence_vote", "rid" => $rid)), "success");
goto UPbzz;
RWkgZ:
$out["status"] = 200;
goto bLuoz;
KiTtB:
$out["status"] = 0;
goto iqbkz;
PO961:
$status = intval($_GPC["status"]);
goto SaB9l;
K2pFl:
$acc = WeAccount::create($uniacid);
goto cmMMS;
JdFBU:
EKsgu:
goto a4TyI;
e3jIw:
$file = ATTACHMENT_ROOT . "/images/" . $_W["uniacid"] . "/silence_vote/" . $rid . "/" . $voteuser["createtime"] . "_" . $voteuser["id"] . ".jpg";
goto t4OGP;
YAIj3:
$setvotestatus = pdo_update($this->tablevotedata, array("status" => $status), array("id" => intval($_GPC["vid"]), "tid" => $id, "rid" => $rid, "uniacid" => $uniacid));
goto dCLuR;
sQtcj:
hq24N:
goto BieE3;
prp8x:
k8MiK:
goto n6MXn;
WAQPr:
$ty = $_GPC["ty"];
goto zgQiE;
A8pmo:
$imgurl = m("attachment")->doMobileMedia(array("media_id" => $serverid, "type" => "image", "width" => 500));
goto ScnrB;
ZhBhl:
$out["status"] = 0;
goto cgS8x;
rBw3j:
$locktime = time() + 30 * 24 * 3600;
goto pUvg0;
dayIj:
if (empty($viporder)) {
    goto Q20kE;
}
goto d2Wn5;
FyIBs:
exit(json_encode($out));
goto FB99k;
VX2I2:
exit(json_encode($out));
goto BTxWg;
xb4AE:
$setgiftstatus = pdo_update($this->tablegift, array("status" => $status), array("id" => intval($_GPC["vid"]), "tid" => $id, "rid" => $rid, "uniacid" => $uniacid));
goto w6rv6;
SRYOK:
$lock = intval($_GPC["lock"]);
goto AihOQ;
UbFfg:
if (pdo_update($this->tablevoteuser, array("locktime" => $locktime), array("id" => $id, "rid" => $rid, "uniacid" => $uniacid))) {
    goto GpsVE;
}
goto ZhBhl;
ScnrB:
if (empty($imgurl)) {
    goto OllXV;
}
goto rJskA;
a4TyI:
if (!($ty == "getsaiqu")) {
    goto Qi2xr;
}
goto qg0Wh;
BmAPL:
$acc = WeAccount::create($uniacid);
goto MnTEc;
F1_i7:
$out["status"] = 200;
goto utGxP;
i5gHU:
Cptk8:
goto tT9BM;
cabGx:
exit;
goto jxCyX;
DGpXI:
TCkcJ:
goto gfrky;
utGxP:
exit(json_encode($out));
goto W2ka0;
kSsnX:
rmxk6:
goto fkM8J;
FkoGD:
pdo_delete($this->tablevotedata, array("tid" => $id, "rid" => $rid, "uniacid" => $uniacid));
goto u9mI5;
VH5c6:
h8Cnt:
goto j2Pd5;
uYxKV:
dfn9_:
goto aT2OV;
HsLcY:
$serverid = $formatdata[intval($_GPC["imgid"])];
goto Wx_h1;
KWvsf:
$redpackid = intval($_GPC["redpackid"]);
goto PGCSx;
CNXLT:
woTY9:
goto Dcxw1;
nrGcx:
U9LkQ:
goto vsYj_;
YNLXF:
if (!($ty == "deletevoteuser")) {
    goto yI347;
}
goto T4yUh;
pjoY1:
if (!($ty == "setvotestatus")) {
    goto UnckS;
}
goto s2_YI;
ye83A:
$dirName = ATTACHMENT_ROOT . "/images/" . $_W["uniacid"] . "/silence_vote/" . $rid . "/agenthb/";
goto Uz0j9;
IplVs:
$btn = tpl_form_field_image("indexpicbtn[]");
goto lhQzn;
Uz0j9:
$re = del_dir($dirName);
goto DhR9E;
s2_YI:
if (!$_W["ispost"]) {
    goto ysrEV;
}
goto z9RxI;
Vcruf:
msuTX:
goto ZokxU;
bLuv4:
if (empty($viporder)) {
    goto O87PO;
}
goto Q_p8w;
gfrky:
if (!($ty == "formhtml")) {
    goto EKsgu;
}
goto OV5Px;
Wx_h1:
if (empty($serverid)) {
    goto vwTlL;
}
goto A8pmo;
W2ka0:
goto rmxk6;
goto FOu2K;
M1zpC:
defined("IN_IA") or exit("Access Denied");
goto pfMwn;
aT2OV:
if (!($ty == "setstatus")) {
    goto OkpRj;
}
goto PO961;
Ompaz:
PzlKz:
goto UbFfg;
wEYqo:
$re_url = $_W["siteroot"] . "app/" . $this->createMobileUrl("view", array("rid" => $rid, "id" => $voteuser["id"], "op" => "xsrecommend", "xsid" => "xs" . $voteuser["id"], "saiquid" => $voteuser["saiquid"] ?: 0)) . "&time=" . time();
goto K2pFl;
R53rk:
if (!($ty == "statusAll")) {
    goto HE7oN;
}
goto ij_BH;
RINw0:
nUlRA:
goto r025u;
dRFUd:
$audit = intval($_GPC["audit"]);
goto kPdw5;
qg0Wh:
$rid = $_GPC["rid"];
goto keQ0O;
nx7JH:
$out["status"] = 200;
goto dcFyt;
gi9sF:
$locktime = 0;
goto Ompaz;
fzOKg:
gi60T:
goto gi9sF;
duFS0:
$re_url = $_W["siteroot"] . "app/" . $this->createMobileUrl("view", array("rid" => $rid, "id" => $voteuser["id"], "op" => "xsrecommend", "xsid" => "xs" . $voteuser["id"], "saiquid" => $voteuser["saiquid"] ?: 0)) . "&time=" . time();
goto BmAPL;
wuLch:
if (!unlink($file)) {
    goto mMiO8;
}
goto F1_i7;
tuXt4:
exit(json_encode($out));
goto SCLeb;
WfbG2:
$cdatacfg = unserialize($cdata["config"]);
goto PWUNW;
j2Pd5:
if (!($ty == "deleteredpack")) {
    goto dfn9_;
}
goto VDjW4;
mB3rQ:
$dirName = ATTACHMENT_ROOT . "/images/" . $_W["uniacid"] . "/silence_vote/" . $rid . "/";
goto nvfMx;
keQ0O:
$info = pdo_fetchall("select *,saiquname as text from " . tablename($this->modulename . "_saiqu") . "where uniacid = {$uniacid} and rid = {$rid}");
goto k3_bq;
ZokxU:
$cfg = $this->module["config"];
goto wEYqo;
Dcxw1:
$resetvote = pdo_query($setvotesql);
goto vBFzm;
zgQiE:
$uniacid = intval($_W["uniacid"]);
goto dKvLk;
tc9iQ:
goto nUlRA;
goto BcDtG;
lLY8F:
if (!($ty == "delposterimg_agent")) {
    goto ybK48;
}
goto ye83A;
w6rv6:
if (!$setgiftstatus) {
    goto Jzml6;
}
goto RWkgZ;
VDjW4:
$viporder = pdo_fetch("SELECT * FROM " . tablename($this->tableredpack) . " WHERE  id = :id AND uniacid = :uniacid ", array(":id" => $id, ":uniacid" => $uniacid));
goto bLuv4;
KMDm4:
$status = intval($_GPC["status"]);
goto xb4AE;
FZXIR:
HE7oN:
goto KiLdG;
DhR9E:
$out["status"] = 200;
goto tuXt4;
TrHup:
pdo_delete($this->tablevoteuser, array("id" => $id, "uniacid" => $uniacid));
goto FkoGD;
bLuoz:
exit(json_encode($out));
goto ozoj3;
rJskA:
switch (intval($_GPC["imgid"])) {
    case 0:
        $uparray = array("img1" => $imgurl);
        goto Angfv;
    case 1:
        $uparray = array("img2" => $imgurl);
        goto Angfv;
    case 2:
        $uparray = array("img3" => $imgurl);
        goto Angfv;
    case 3:
        $uparray = array("img4" => $imgurl);
        goto Angfv;
    case 4:
        $uparray = array("img5" => $imgurl);
        goto Angfv;
}
goto rrAwL;
gluOM:
if (empty($audit)) {
    goto msuTX;
}
goto KKnE9;
d2Wn5:
pdo_delete($this->tableviporder, array("id" => $id, "uniacid" => $uniacid));
goto F3Wuv;
hxEH7:
message("状态设置成功！", $this->createWebUrl("manage", array("name" => "silence_vote")), "success");
goto zgXKl;
vHcFv:
CVto1:
goto ddEX5;
OEzrj:
message("抱歉，传递的参数错误！", '', "error");
goto kh_Ub;
OV5Px:
load()->func("tpl");
goto VjRGN;
rx2ml:
goto hq24N;
goto Vcruf;
lSh_k:
exit(json_encode(array("code" => 200, "msg" => "设置送礼页独立防封成功")));
goto PQH0m;
nNdIT:
if (!$_W["ispost"]) {
    goto U9LkQ;
}
goto KMDm4;
Mt21u:
$sendr = "红包发送成功，分享海报邀请好友，获得红包奖励！";
goto prp8x;
irVPA:
pdo_update($this->tablevoteuser, $uparray, array("id" => $votedata["id"]));
goto MnCSl;
L7zlB:
$d = $acc->sendTplNotice($voteuser["openid"], $cfg["OPENTM412230652"], $postdata, $re_url, $topcolor = "#FF683F");
goto sQtcj;
GDX6U:
rP2GK:
goto YNLXF;
uhXYV:
if (!($sendr == 88)) {
    goto k8MiK;
}
goto Mt21u;
ZwZOS:
if (!($ty == "clearposter")) {
    goto ooXnw;
}
goto VlcQa;
ddEX5:
$setvotesql = "update " . tablename($this->tablevoteuser) . " set votenum=votenum-1 where id = " . $id;
goto CNXLT;
SaB9l:
if (!empty($rid)) {
    goto Sih45;
}
goto OEzrj;
UPbzz:
O87PO:
goto oUhOt;
PQH0m:
wl4eN: