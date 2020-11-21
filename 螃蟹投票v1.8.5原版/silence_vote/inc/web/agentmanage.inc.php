<?php

goto yghes;
LrSiC:
$items = pdo_fetchall($sql, $params);
goto nCEJq;
yddC_:
$info = pdo_fetchall("select *,levelname as text from " . tablename($this->modulename . "_agentlevel") . "where uniacid = {$uniacid} order by level asc");
goto BpOVv;
ccsFo:
pdo_delete($this->modulename . "_agentlist", array("id" => $id), "OR");
goto bmM_P;
Nz1sN:
ZqWII:
goto rOjQJ;
AoE9d:
$psize = 25;
goto GLtiv;
OBpDW:
if (!($item["level"] != $data["level"])) {
    goto TsxOx;
}
goto eHp5v;
xaVT9:
Deyx3:
goto bw8c3;
rTuJt:
echo json_encode($info);
goto EoJ4Z;
ag0hg:
TtAXe:
goto M4B9M;
LkSyn:
if ($isdefault == 1) {
    goto BPGIU;
}
goto ocq7Y;
UO2xo:
$id = intval($_GPC["id"]);
goto Q1xMy;
y1fgP:
mk4GD:
goto qV0LM;
gaSEM:
G84aR:
goto r2LGP;
CdSzg:
IwtRS:
goto vLy7O;
aoSRQ:
B_0M8:
goto aALCA;
SUA9m:
$pindex = max(1, intval($_GPC["page"]));
goto AoE9d;
KzLvz:
$condition = " WHERE uniacid = {$uniacid} ";
goto UfhGo;
Zyb85:
T2ujP:
goto d2Lzv;
V0IMc:
SkmiT:
goto JefvE;
iP_Rs:
pdo_update($this->modulename . "_agentlist", array("status" => $status), array("id" => $aid));
goto my6DD;
d_w4g:
KY7h4:
goto uaxz1;
uaxz1:
$info = pdo_fetchall("select *,username as text from " . tablename($this->modulename . "_agentlist") . "where uniacid = {$uniacid}");
goto TIbFM;
BQCru:
dnfH6:
goto SbQ1Z;
vLy7O:
pdo_update($this->modulename . "_agentlist", $data, array("id" => $id));
goto ikDOb;
Rm2A3:
die;
goto qH0ud;
ZptJQ:
if ($operation == "delete") {
    goto TtAXe;
}
goto B5yqx;
bdMto:
if (!empty($item)) {
    goto KOYdk;
}
goto WvDHt;
fHx49:
message("经纪人等级不存在！");
goto Xr2HQ;
KrCYS:
HJUF_:
goto LCd1_;
C4DaW:
$pager = pagination($total, $pindex, $psize);
goto At0a5;
ozEdF:
foreach ($_GPC["idArr"] as $k => $id) {
    goto RbHx1;
    QqkWp:
    ut42W:
    goto HRRV_;
    RbHx1:
    $id = intval($id);
    goto dWIgm;
    A5H35:
    pdo_delete($this->modulename . "_agentlevel", array("id" => $id, "uniacid" => $uniacid));
    goto yqtaL;
    yqtaL:
    XADBs:
    goto QqkWp;
    dWIgm:
    if (!$id) {
        goto XADBs;
    }
    goto A5H35;
    HRRV_:
}
goto qI21H;
BpOVv:
echo json_encode($info);
goto gqiFf;
H3kkY:
$data = $_GPC["data"];
goto LrluI;
sgoPg:
rOdu7:
goto RMRsZ;
EqbOg:
$params[":keyword"] = "%{$keyword}%";
goto oyPYG;
YHbME:
QOtTN:
goto yJEL3;
E9PLN:
goto QOtTN;
goto ag0hg;
MpHz6:
YgEEn:
goto V3FsV;
UMgzK:
otr8W:
goto pff00;
UDW0v:
if (empty($keyword)) {
    goto ch6Eg;
}
goto mQ9ie;
EWLE7:
$aid = $_GPC["aid"];
goto iP_Rs;
nCEJq:
$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->modulename . "_agentlist") . $condition . $order_condition, $params);
goto K6zoy;
V3Hwf:
EzF2P:
goto v9Wx_;
O2Cu8:
load()->func("communication");
goto itOF3;
O7tiz:
message("不存在或是已经被删除", $this->createWebUrl("agentmanage", array("op" => "display")), "error");
goto aoSRQ;
aGn9n:
//message("授权错误，请联系客服！", "referer", "error");
goto QFado;
oHYVa:
if (!empty($data["agentlevel"])) {
    goto Goqcv;
}
goto nPd4A;
At0a5:
goto QOtTN;
goto E1OX3;
pnFhi:
if ($checkisdefault) {
    goto I0z3h;
}
goto AVsuz;
ikDOb:
cC_Eo:
goto vH0Z1;
SytvL:
$info = pdo_fetchall("select *,realname as text from " . tablename($this->modulename . "_agentlist") . "where uniacid = {$uniacid}");
goto UiBXe;
rjJ76:
if ($check) {
    goto xk7E_;
}
goto cJyH2;
EZazR:
KB0l4:
goto JNlRm;
AP7cM:
if ($operation == "display") {
    goto BGgog;
}
goto AmGxX;
mpluB:
g7xuE:
goto rTuJt;
v9Wx_:
if (!empty($data["password"])) {
    goto mk4GD;
}
goto HSDg2;
NpOOF:
Cm91h:
goto oHYVa;
mYwpz:
if (!empty($item)) {
    goto W1eHA;
}
goto uyxch;
MdXCA:
$checkisdefault = pdo_fetch("SELECT * FROM " . tablename($this->modulename . "_agentlevel") . " WHERE isdefault = 1 and uniacid = {$uniacid}");
goto Gnqyt;
YAmVa:
goto QOtTN;
goto tsc7I;
r2LGP:
nIBtL:
goto y18w8;
YJZHO:
if ($item) {
    goto G84aR;
}
goto F6uBj;
bFo_2:
$item = pdo_fetch("SELECT * FROM " . tablename($this->modulename . "_agentlevel") . " WHERE id = {$id} and uniacid = {$uniacid}");
goto YJZHO;
GMBZn:
Qh7Zg:
goto n2rqG;
MWuAJ:
dBj1t:
goto RWcEr;
q9OBu:
$psize = 15;
goto kcrG0;
F88YT:
$status = $_GPC["status"];
goto EWLE7;
LCd1_:
pdo_update($this->modulename . "_agentlevel", $data, array("id" => $id));
goto eoozP;
XZr_N:
if (!empty($id)) {
    goto HJUF_;
}
goto QoZQV;
pff00:
ch6Eg:
goto RLKNU;
AIECY:
W1eHA:
goto wAr3r;
jBIVM:
Gkq_w:
goto ozEdF;
TGysl:
checklogin();
goto gfpED;
JNlRm:
$data["uniacid"] = $uniacid;
goto UqRw0;
yghes:
defined("IN_IA") or exit("Access Denied");
goto O1E4t;
SMN1A:
message("经纪人等级已存在");
goto TqShf;
MhraX:
$check = pdo_fetch("SELECT * FROM " . tablename($this->modulename . "_agentlist") . " WHERE id = {$data["agentrecommend"]} and uniacid = {$uniacid}");
goto rjJ76;
w0Ei8:
echo "{\"data\":\"删除成功\"}";
goto qZoK1;
qhWm7:
BPGIU:
goto pnFhi;
F6uBj:
message("经纪人等级不存在");
goto gaSEM;
qZoK1:
die;
goto R1m4E;
wAr3r:
if (!($item["uniacid"] != $uniacid)) {
    goto k9LUi;
}
goto Db5yy;
OZSg4:
message("请输入账号名称");
goto V3Hwf;
De1Lw:
$pindex = max(1, intval($_GPC["page"]));
goto q9OBu;
ocq7Y:
goto uCZHY;
goto V0IMc;
QFado:
goto OSbKK;
goto MWuAJ;
pVTVu:
$condition .= " AND realname LIKE :keyword";
goto EqbOg;
gQjQ6:
$id = intval($_GPC["id"]);
goto JJ2ga;
EdpW7:
jE2q3:
goto gQjQ6;
JefvE:
if ($checkisdefault) {
    goto Tt_BV;
}
goto z3t8p;
eqUsn:
if (!$check) {
    goto T2ujP;
}
goto TWuPs;
eHp5v:
$check = pdo_fetch("SELECT * FROM " . tablename($this->modulename . "_agentlevel") . " WHERE level = {$data["level"]} and uniacid = {$uniacid}");
goto TGJBi;
O1E4t:
global $_W, $_GPC;
goto TGysl;
QoZQV:
pdo_insert($this->modulename . "_agentlevel", $data);
goto Ee7wn;
qH0ud:
goto QOtTN;
goto TeRXy;
G8l3K:
$url = $this->auth_url . "/index/vote/checkauth";
goto QXqyg;
LrluI:
if (!(empty($data["level"]) && $data["level"] !== "0")) {
    goto qbHyy;
}
goto kTpYN;
GLtiv:
$keyword = trim($_GPC["keyword"]);
goto ye2qN;
gh_e6:
xk7E_:
goto qBqlH;
qV0LM:
if (!$data["agentrecommend"]) {
    goto rza0D;
}
goto MhraX;
ylZsB:
WGKjO:
goto Ib0L0;
V3FsV:
$condition .= " AND id = {$keyword}";
goto UMgzK;
PTmB7:
echo "{\"data\":\"删除成功\"}";
goto Rm2A3;
QXqyg:
$post_data = array("time" => time(), "ticket" => $cfg["ticket"], "module_id" => 3);
goto Qc3_T;
UiBXe:
array_unshift($info, $a);
goto mpluB;
FFCjp:
$check = pdo_fetch("SELECT * FROM " . tablename($this->modulename . "_agentlevel") . " WHERE level = {$data["level"]} and uniacid = {$uniacid}");
goto eqUsn;
d2Lzv:
goto KB0l4;
goto UpQYq;
EyrkK:
goto QOtTN;
goto HDtcG;
nBymU:
BGgog:
goto De1Lw;
kaCTa:
if (!($item["uniacid"] != $uniacid)) {
    goto CIB6O;
}
goto o4_AV;
BW_8v:
$result = json_decode($content["content"], true);
goto qmXdM;
k405u:
if ($operation == "getagent") {
    goto KY7h4;
}
goto E9PLN;
b5srw:
GtpU1:
goto yddC_;
rOjQJ:
goto uCZHY;
goto qhWm7;
YYAsx:
pdo_update($this->modulename . "_agentlevel", array("isdefault" => 1), array("id" => $id));
goto vODen;
ZejSR:
$data["uniacid"] = $uniacid;
goto EdiGo;
TfEHA:
if ($operation == "deletealllevel") {
    goto wdZ5s;
}
goto j_oD0;
mQ9ie:
if (is_numeric($keyword)) {
    goto YgEEn;
}
goto pVTVu;
n2rqG:
if (!checksubmit("submit")) {
    goto VaI3j;
}
goto ou9ML;
U7mnR:
if (!(empty($_GPC["idArr"]) || !is_array($_GPC["idArr"]))) {
    goto B_0M8;
}
goto O7tiz;
mN7qL:
message("不存在或是已经被删除", $this->createWebUrl("agentmanage", array("op" => "displaylevel")), "error");
goto jBIVM;
JJ2ga:
$item = pdo_fetch("SELECT * FROM " . tablename($this->modulename . "_agentlevel") . " WHERE id = '{$id}'");
goto mYwpz;
ljBaj:
$_W["page"]["title"] = "经纪人管理";
goto WEpZl;
cv3IB:
goto YbWUR;
goto Mhs1J;
SpIk8:
k9LUi:
goto V0kVp;
eoozP:
QLksa:
goto MdXCA;
qZsQ6:
if (!empty($level)) {
    goto TACQF;
}
goto fHx49;
Mhs1J:
I0z3h:
goto W90t_;
aZs3g:
$condition .= " AND levelname LIKE :keyword";
goto BX2A2;
Db5yy:
message("您没有权限编辑");
goto SpIk8;
RAeH0:
pdo_insert($this->modulename . "_agentlist", $data);
goto PAd6O;
nLhu9:
CIB6O:
goto ccsFo;
UpQYq:
FyhnL:
goto OBpDW;
nPd4A:
message("请先设置经纪人等级 再添加经纪人");
goto mr4aA;
Q1xMy:
if (!$id) {
    goto nIBtL;
}
goto bFo_2;
gqiFf:
exit;
goto QSRwY;
HDtcG:
wdZ5s:
goto tyXbD;
OnE08:
W3kKr:
goto w0Ei8;
cKTJ5:
if (empty($keyword)) {
    goto dnfH6;
}
goto aZs3g;
XqbIl:
$level = pdo_fetch("SELECT * FROM " . tablename($this->modulename . "_agentlevel") . " WHERE level = {$data["agentlevel"]} and uniacid = {$uniacid}");
goto qZsQ6;
lAlyj:
message("更新成功", $this->createWebUrl("agentmanage", array("op" => "displaylevel")), "success");
goto sgoPg;
pwSpk:
$item = pdo_fetch("SELECT * FROM " . tablename($this->modulename . "_agentlist") . " WHERE id = '{$id}'");
goto bdMto;
mr4aA:
Goqcv:
goto XqbIl;
EdiGo:
if (!empty($id)) {
    goto IwtRS;
}
goto bvqdt;
MwwSM:
goto QLksa;
goto KrCYS;
H1uwk:
unset($data["isdefault"]);
goto XZr_N;
a77qV:
yCEO1:
goto U7mnR;
V6288:
KOYdk:
goto kaCTa;
EmBq_:
TsxOx:
goto EZazR;
Xkg0a:
ijJ14:
goto sMQK1;
TIbFM:
if (!($_GPC["todo"] == "tomsg")) {
    goto g7xuE;
}
goto a5hE0;
WEpZl:
$cfg = $this->module["config"];
goto G8l3K;
Qc3_T:
ksort($post_data);
goto EbTfN;
PAd6O:
goto cC_Eo;
goto CdSzg;
WvDHt:
message("不存在或是已经被删除", $this->createWebUrl("agentmanage", array("op" => "display")), "error");
goto V6288;
bw8c3:
unset($data["password"]);
goto NpOOF;
uhy7A:
$sql = "SELECT * FROM " . tablename($this->modulename . "_agentlist") . $condition . $order_condition . " LIMIT " . ($pindex - 1) * $psize . "," . $psize;
goto LrSiC;
Ee7wn:
$id = pdo_insertid();
goto MwwSM;
E1OX3:
WMOEI:
goto UO2xo;
TeRXy:
tDvQL:
goto SUA9m;
itOF3:
$content = ihttp_post($url, $post_data);
goto BW_8v;
EoJ4Z:
exit;
goto YHbME;
rrhp5:
goto QOtTN;
goto a77qV;
TqShf:
H5FbS:
goto EmBq_;
oyPYG:
goto otr8W;
goto MpHz6;
kTpYN:
message("请输入等级");
goto p3VwK;
EL_Fo:
goto QOtTN;
goto nBymU;
pO0Xo:
if (!$id) {
    goto Qh7Zg;
}
goto kHRmK;
gfpED:
load()->func("tpl");
goto ljBaj;
oliOC:
message("删除成功", $this->createWebUrl("agentmanage", array("op" => "displaylevel")), "success");
goto EyrkK;
sMQK1:
$item["password"] = "******";
goto GMBZn;
ou9ML:
$data = $_GPC["data"];
goto PpE5H;
Ib0L0:
$id = intval($_GPC["id"]);
goto pO0Xo;
J10He:
$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->modulename . "_agentlevel") . $condition . $order_condition, $params);
goto C4DaW;
sZwMq:
$operation = !empty($_GPC["op"]) ? $_GPC["op"] : "display";
goto SJt5x;
D2NtI:
if ($operation == "deletelevel") {
    goto jE2q3;
}
goto TfEHA;
p96PW:
Tt_BV:
goto LgtjM;
l0_H3:
uCZHY:
goto lAlyj;
IHOEG:
if ($operation == "postlevel") {
    goto WMOEI;
}
goto PVzCj;
HB4Kn:
if ($item) {
    goto FyhnL;
}
goto FFCjp;
M4B9M:
$id = intval($_GPC["id"]);
goto pwSpk;
HAW3m:
$data["password"] = md5($data["password"]);
goto xAdfh;
XJTrF:
$items = pdo_fetchall($sql, $params);
goto J10He;
R1m4E:
goto QOtTN;
goto ylZsB;
qmXdM:
if ($result["sta"]) {
    goto dBj1t;
}
goto aGn9n;
AmGxX:
if ($operation == "review") {
    goto lvIvN;
}
goto D2NtI;
my6DD:
message("更新成功", $this->createWebUrl("agentmanage", array("op" => "display")), "success");
goto iSaO3;
R5hy2:
message("经纪人不存在");
goto Xkg0a;
Gnqyt:
if ($isdefault == 0) {
    goto SkmiT;
}
goto LkSyn;
SJt5x:
$uniacid = !empty($_W["uniacid"]) ? $_W["uniacid"] : intval($_GET["uniacid"]);
goto ZptJQ;
o4_AV:
message("您没有权限编辑");
goto nLhu9;
JOtQf:
if ($data["password"] == "******") {
    goto Deyx3;
}
goto HAW3m;
PpE5H:
if (!empty($data["username"])) {
    goto EzF2P;
}
goto OZSg4;
vH0Z1:
message("更新成功", $this->createWebUrl("agentmanage", array("op" => "display")), "success");
goto b9Y36;
aALCA:
foreach ($_GPC["idArr"] as $k => $id) {
    goto RUcbv;
    RdWQQ:
    gi1u_:
    goto SC1Rq;
    Y0p1Z:
    pdo_delete($this->modulename . "_agentlist", array("id" => $id, "uniacid" => $uniacid));
    goto v7eFT;
    v7eFT:
    kuo7m:
    goto RdWQQ;
    hNf0C:
    if (!$id) {
        goto kuo7m;
    }
    goto Y0p1Z;
    RUcbv:
    $id = intval($id);
    goto hNf0C;
    SC1Rq:
}
goto OnE08;
uyxch:
message("不存在或是已经被删除", $this->createWebUrl("agentmanage", array("op" => "displaylevel")), "error");
goto AIECY;
PVzCj:
if ($operation == "getlevel") {
    goto GtpU1;
}
goto k405u;
ye2qN:
$condition = " WHERE uniacid = {$uniacid} ";
goto YIDS8;
UfhGo:
$params = array();
goto UDW0v;
bmM_P:
message("删除成功", $this->createWebUrl("agentmanage", array("op" => "display")), "success");
goto rrhp5;
z3t8p:
pdo_update($this->modulename . "_agentlevel", array("isdefault" => 1), array("id" => $id));
goto OhZAO;
p3VwK:
qbHyy:
goto HB4Kn;
qBqlH:
rza0D:
goto JOtQf;
RLKNU:
$order_condition = " ORDER BY id DESC ";
goto uhy7A;
Xr2HQ:
TACQF:
goto ZejSR;
j_oD0:
if ($operation == "displaylevel") {
    goto tDvQL;
}
goto IHOEG;
UqRw0:
$isdefault = $data["isdefault"];
goto H1uwk;
xAdfh:
goto Cm91h;
goto xaVT9;
y18w8:
if (!checksubmit("submit")) {
    goto rOdu7;
}
goto H3kkY;
AVsuz:
pdo_update($this->modulename . "_agentlevel", array("isdefault" => 1), array("id" => $id));
goto cv3IB;
TWuPs:
message("经纪人等级已存在");
goto Zyb85;
HSDg2:
message("请输入密码");
goto y1fgP;
QSRwY:
goto QOtTN;
goto d_w4g;
SbQ1Z:
$order_condition = " ORDER BY id DESC ";
goto z1SV5;
RWcEr:
OSbKK:
goto sZwMq;
B5yqx:
if ($operation == "deleteall") {
    goto yCEO1;
}
goto o8TD0;
a5hE0:
$a = ["id" => 0, "text" => "所有人"];
goto SytvL;
z1SV5:
$sql = "SELECT * FROM " . tablename($this->modulename . "_agentlevel") . $condition . $order_condition . " LIMIT " . ($pindex - 1) * $psize . "," . $psize;
goto XJTrF;
V0kVp:
pdo_delete($this->modulename . "_agentlevel", array("id" => $id), "OR");
goto oliOC;
OhZAO:
goto ZqWII;
goto p96PW;
iSaO3:
goto QOtTN;
goto EdpW7;
b9Y36:
VaI3j:
goto EL_Fo;
vODen:
YbWUR:
goto l0_H3;
TGJBi:
if (!$check) {
    goto H5FbS;
}
goto SMN1A;
kcrG0:
$keyword = trim($_GPC["keyword"]);
goto KzLvz;
qI21H:
Kz0WV:
goto PTmB7;
BX2A2:
$params[":keyword"] = "%{$keyword}%";
goto BQCru;
o8TD0:
if ($operation == "post") {
    goto WGKjO;
}
goto AP7cM;
kHRmK:
$item = pdo_fetch("SELECT * FROM " . tablename($this->modulename . "_agentlist") . " WHERE id = {$id} and uniacid = {$uniacid}");
goto eMCap;
RMRsZ:
goto QOtTN;
goto b5srw;
EbTfN:
$post_data["token"] = md5(sha1(implode('', $post_data)));
goto O2Cu8;
tyXbD:
if (!(empty($_GPC["idArr"]) || !is_array($_GPC["idArr"]))) {
    goto Gkq_w;
}
goto mN7qL;
bvqdt:
$data["status"] = 1;
goto RAeH0;
YIDS8:
$params = array();
goto cKTJ5;
tsc7I:
lvIvN:
goto F88YT;
eMCap:
if ($item) {
    goto ijJ14;
}
goto R5hy2;
K6zoy:
$pager = pagination($total, $pindex, $psize);
goto YAmVa;
cJyH2:
message("推荐人id不存在");
goto gh_e6;
LgtjM:
pdo_update($this->modulename . "_agentlevel", array("isdefault" => 0), array("id" => $id));
goto Nz1sN;
W90t_:
pdo_query("UPDATE " . tablename($this->modulename . "_agentlevel") . " SET isdefault = 0 WHERE id != {$id} and uniacid = {$uniacid}");
goto YYAsx;
yJEL3:
include $this->template("agent_manage");