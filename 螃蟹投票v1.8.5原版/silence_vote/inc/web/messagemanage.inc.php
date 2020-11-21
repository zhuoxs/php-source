<?php

goto m1an5;
IlM4G:
B67IH:
goto ENuiW;
JqVCQ:
if (!empty($id)) {
    goto XsmpT;
}
goto K5hzx;
fMjen:
$data["content"] = trim($_GPC["content"]);
goto IJfWo;
S_8t5:
pdo_delete($this->modulename . "_message", array("id" => $id), "OR");
goto aVcqD;
AnaOQ:
checklogin();
goto DECBP;
cWTrb:
$id = intval($_GPC["id"]);
goto GhBg2;
tiYDI:
TCAvA:
goto escTQ;
RSfL8:
$result = json_decode($content["content"], true);
goto eVUx4;
yKKID:
M3qSa:
goto cWTrb;
P69Y0:
JE_xt:
goto HBXNo;
HBXNo:
message("更新成功", $this->createWebUrl("messagemanage", array("op" => "display")), "success");
goto vpjjX;
IaKRY:
qC2Rm:
goto tiYDI;
LDzZI:
if (!$aid) {
    goto pCpX7;
}
goto WBZH_;
tVY_p:
if ($operation == "deleteall") {
    goto df6bT;
}
goto SEOth;
Btoly:
pdo_update($this->modulename . "_message", $data, array("id" => $id));
goto P69Y0;
GhBg2:
$item = pdo_fetch("SELECT * FROM " . tablename($this->modulename . "_message") . " WHERE id = '{$id}'");
goto E7LQX;
lrJDY:
$data = $_GPC["data"];
goto FriBA;
huL6p:
echo json_encode(array("code" => 200, "msg" => "站内信发送成功"));
goto iTAHS;
BWzCb:
x6Sy4:
goto qnK9Q;
KCRQX:
goto qC2Rm;
goto ghAwk;
NIdcx:
$condition .= " AND agent_id = {$keyword}";
goto IaKRY;
XfR0j:
XsmpT:
goto Btoly;
Sfb18:
if (is_numeric($keyword)) {
    goto r0sBL;
}
goto PHWln;
VbWMt:
message("不存在或是已经被删除", $this->createWebUrl("messagemanage", array("op" => "display")), "error");
goto NoNh4;
Le_B9:
goto cas7u;
goto qTsk2;
g7vpc:
goto JE_xt;
goto XfR0j;
qTsk2:
sK8JN:
goto f9R1d;
aG2v0:
$_W["page"]["title"] = "站内信管理";
goto vi2ef;
KtfrJ:
Rzw6G:
goto pXun6;
t3uQU:
$sql = "SELECT * FROM " . tablename($this->modulename . "_message") . $condition . $order_condition . " LIMIT " . ($pindex - 1) * $psize . "," . $psize;
goto tjIy8;
I_K2p:
echo "{\"data\":\"删除成功\"}";
goto PvvaO;
DECBP:
$cfg = $this->module["config"];
goto lok2g;
NVZdS:
sdIBn:
goto iPZ_t;
K5hzx:
pdo_insert($this->modulename . "_message", $data);
goto g7vpc;
AxyBt:
message("您没有权限编辑");
goto y4XSl;
Hfhdy:
$params = array();
goto CZGkX;
Wpp5i:
$aidA = pdo_fetchall("select id from " . tablename($this->modulename . "_agentlist") . " where realname like '%{$keyword}%' and uniacid = {$uniacid} ");
goto l_xFZ;
qnK9Q:
if (!checksubmit("submit")) {
    goto M_Mmc;
}
goto lrJDY;
g_CdC:
goto cas7u;
goto cr5FO;
Wg7b4:
$item = pdo_fetch("SELECT * FROM " . tablename($this->modulename . "_message") . " WHERE id = {$id} and uniacid = {$uniacid}");
goto ZUmvB;
XT16N:
$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->modulename . "_message") . $condition . $order_condition, $params);
goto enpnG;
j85_Z:
nHsx3:
goto NVZdS;
cxnWn:
$config = $this->module["config"];
goto pAFK7;
TPQlT:
$uniacid = !empty($_W["uniacid"]) ? $_W["uniacid"] : intval($_GET["uniacid"]);
goto SsxW0;
pAFK7:
$acc = WeAccount::create($uniacid);
goto UVswe;
bhNMl:
STsSn:
goto H2FVF;
xJeR9:
load()->func("communication");
goto ouJ_s;
rzQfE:
$aid = $_GPC["aid"] ? $_GPC["aid"] : 0;
goto fMjen;
oeZ4X:
global $_W, $_GPC;
goto AnaOQ;
m1an5:
defined("IN_IA") or exit("Access Denied");
goto oeZ4X;
SsxW0:
if ($operation == "delete") {
    goto M3qSa;
}
goto tVY_p;
tYU0r:
$pindex = max(1, intval($_GPC["page"]));
goto jfDQ_;
J2lCp:
ksort($post_data);
goto KoeN2;
Xng4A:
FSdAg:
goto tCNl0;
PHWln:
$aids = "0";
goto Wpp5i;
ceTsK:
if ($operation == "display") {
    goto FSdAg;
}
goto r33R6;
kGW3x:
$agentlist = pdo_fetchall("SELECT * FROM " . tablename($this->modulename . "_agentlist") . " WHERE uniacid = {$uniacid} AND openid != '' and openid != '0'" . $where);
goto oqE9f;
ymJmY:
foreach ($items as $key => $value) {
    goto GPlTY;
    Gk2kb:
    w8H6P:
    goto A84PS;
    A84PS:
    WELFL:
    goto IcJji;
    CIRvb:
    $items[$key]["agentname"] = pdo_fetchcolumn("SELECT username FROM " . tablename($this->modulename . "_agentlist") . " where id = {$value["agent_id"]}");
    goto Gk2kb;
    lL5Vq:
    goto w8H6P;
    goto xbM04;
    dqEBy:
    $items[$key]["agentname"] = "所有经纪人";
    goto lL5Vq;
    GPlTY:
    if ($value["agent_id"] != 0) {
        goto roLgw;
    }
    goto dqEBy;
    xbM04:
    roLgw:
    goto CIRvb;
    IcJji:
}
goto fGBpB;
tCNl0:
$pindex = max(1, intval($_GPC["page"]));
goto v4ixq;
l_xFZ:
foreach ($aidA as $key => $value) {
    $aids .= "," . $value["id"];
    vCM5F:
}
goto bhNMl;
PfvQ3:
YN9QN:
goto W22Wc;
vugIk:
message("经纪人不存在");
goto KtfrJ;
IJfWo:
$data["createtime"] = $_W["timestamp"];
goto D23NQ;
TX8em:
pdo_insert($this->modulename . "_message", $data);
goto cxnWn;
escTQ:
$order_condition = " ORDER BY id DESC,createtime desc,agent_id desc ";
goto t3uQU;
THK5M:
goto cas7u;
goto hff4x;
lok2g:
$url = $this->auth_url . "/index/vote/checkauth";
goto dkGhd;
CZGkX:
if (empty($keyword)) {
    goto B67IH;
}
goto XhKS0;
bxBv2:
$data["uniacid"] = $uniacid;
goto JqVCQ;
oqE9f:
$module_title = pdo_fetchcolumn("select title from " . tablename("modules") . " where name = '{$this->modulename}'");
goto KEVTf;
SEOth:
if ($operation == "post") {
    goto sK8JN;
}
goto ceTsK;
ZPzl6:
foreach ($_GPC["idArr"] as $k => $id) {
    goto gteVI;
    SXnBq:
    if (!$id) {
        goto fh2Js;
    }
    goto esysd;
    esysd:
    pdo_delete($this->modulename . "_message", array("id" => $id, "uniacid" => $uniacid));
    goto nxewv;
    gteVI:
    $id = intval($id);
    goto SXnBq;
    nxewv:
    fh2Js:
    goto U87FW;
    U87FW:
    qJTXw:
    goto ii1O4;
    ii1O4:
}
goto Etwpc;
LqR6Z:
//message("授权错误，请联系客服！", "referer", "error");
goto zWoQ1;
f9R1d:
$id = intval($_GPC["id"]);
goto mgtKV;
FriBA:
if (!$data["agentrecommend"]) {
    goto U96Hc;
}
goto RbPmm;
tjIy8:
$items = pdo_fetchall($sql, $params);
goto gG9Ud;
y4XSl:
ihKch:
goto S_8t5;
cQhvL:
$where = '';
goto LDzZI;
wALWx:
if ($operation == "messagesend") {
    goto x2KIC;
}
goto p8rIH;
y8Vcd:
U96Hc:
goto bxBv2;
XhKS0:
$condition .= " AND content like '%{$keyword}%'";
goto IlM4G;
hff4x:
df6bT:
goto RmkEl;
vi2ef:
$operation = !empty($_GPC["op"]) ? $_GPC["op"] : "display";
goto TPQlT;
LkeMW:
$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->modulename . "_message") . $condition . $order_condition, $params);
goto NVsgq;
ENuiW:
$order_condition = " ORDER BY id DESC,createtime desc,agent_id desc ";
goto vJWu0;
RmkEl:
if (!(empty($_GPC["idArr"]) || !is_array($_GPC["idArr"]))) {
    goto Wam54;
}
goto M2sAH;
KEVTf:
foreach ($agentlist as $userfan) {
    goto xPq3d;
    gwUzW:
    $d = $acc->sendTplNotice($userfan["openid"], $config["OPENTM406187050"], $postdata, $url, $topcolor = "#FF683F");
    goto pahJs;
    pahJs:
    P_3_M:
    goto OAlQK;
    OAlQK:
    ZmSv2:
    goto ljS3c;
    xPq3d:
    if (!$userfan) {
        goto P_3_M;
    }
    goto wbFAJ;
    wbFAJ:
    $postdata = array("first" => array("value" => "有新的站内信通知", "color" => "#173177"), "keyword1" => array("value" => $module_title, "color" => "#173177"), "keyword2" => array("value" => date("Y-m-d H:i:s", $_W["timestamp"]), "color" => "#173177"), "remark" => array("value" => $data["content"], "color" => "#173177"));
    goto gwUzW;
    ljS3c:
}
goto oanZO;
p8rIH:
goto cas7u;
goto yKKID;
W22Wc:
cas7u:
goto jXGJ1;
Etwpc:
YOV3W:
goto I_K2p;
zWoQ1:
goto sdIBn;
goto j85_Z;
dkGhd:
$post_data = array("time" => time(), "ticket" => $cfg["ticket"], "module_id" => 3);
goto J2lCp;
AahBY:
$keyword = trim($_GPC["keyword"]);
goto MAVTB;
NoNh4:
PkCMY:
goto FeeXt;
vJWu0:
$sql = "SELECT * FROM " . tablename($this->modulename . "_message") . $condition . $order_condition . " LIMIT " . ($pindex - 1) * $psize . "," . $psize;
goto Mzs_t;
ZUmvB:
if ($item) {
    goto Rzw6G;
}
goto vugIk;
XOteE:
Wam54:
goto ZPzl6;
FeeXt:
if (!($item["uniacid"] != $uniacid)) {
    goto ihKch;
}
goto AxyBt;
rdCzb:
$data["agent_id"] = $aid;
goto lBIem;
xKMM2:
goto cas7u;
goto Xng4A;
pdptt:
C138U:
goto y8Vcd;
ghAwk:
r0sBL:
goto NIdcx;
pXun6:
$item["password"] = "******";
goto BWzCb;
iPZ_t:
load()->func("tpl");
goto aG2v0;
r33R6:
if ($operation == "displaysend") {
    goto gjIJ9;
}
goto wALWx;
iTAHS:
exit;
goto PfvQ3;
u4AGa:
$keyword = trim($_GPC["keyword"]);
goto o1HSu;
lBIem:
$data["type"] = 1;
goto TX8em;
o1HSu:
$condition = " WHERE uniacid = {$uniacid} and type = 0";
goto rcmhJ;
vpjjX:
M_Mmc:
goto xKMM2;
enpnG:
$pager = pagination($total, $pindex, $psize);
goto GNr6K;
NVsgq:
$pager = pagination($total, $pindex, $psize);
goto g_CdC;
KoeN2:
$post_data["token"] = md5(sha1(implode('', $post_data)));
goto xJeR9;
ouJ_s:
$content = ihttp_post($url, $post_data);
goto RSfL8;
WVaPx:
if ($check) {
    goto C138U;
}
goto cdZ0Q;
H2FVF:
$condition .= " AND agent_id in ({$aids})";
goto KCRQX;
UVswe:
$url = $_W["siteroot"] . "app/" . $this->createMobileUrl("ht_message");
goto cQhvL;
oanZO:
yJagO:
goto huL6p;
Mzs_t:
$items = pdo_fetchall($sql, $params);
goto ymJmY;
v4ixq:
$psize = 15;
goto u4AGa;
cdZ0Q:
message("站内信不存在");
goto pdptt;
oRwov:
if (!$_W["isajax"]) {
    goto YN9QN;
}
goto rzQfE;
zKHKa:
DQvJP:
goto XT16N;
fGBpB:
AgV2P:
goto LkeMW;
MAVTB:
$condition = " WHERE uniacid = {$uniacid} and type = 1";
goto Hfhdy;
E7LQX:
if (!empty($item)) {
    goto PkCMY;
}
goto VbWMt;
RbPmm:
$check = pdo_fetch("SELECT * FROM " . tablename($this->modulename . "_message") . " WHERE id = {$data["agentrecommend"]} and uniacid = {$uniacid}");
goto WVaPx;
eVUx4:
if ($result["sta"]) {
    goto nHsx3;
}
goto LqR6Z;
WBZH_:
$where = " AND id = " . $aid;
goto rIHiS;
W223s:
if (empty($keyword)) {
    goto TCAvA;
}
goto Sfb18;
a8STJ:
gjIJ9:
goto tYU0r;
D23NQ:
$data["uniacid"] = $uniacid;
goto rdCzb;
rcmhJ:
$params = array();
goto W223s;
rIHiS:
pCpX7:
goto kGW3x;
M2sAH:
message("不存在或是已经被删除", $this->createWebUrl("messagemanage", array("op" => "display")), "error");
goto XOteE;
cr5FO:
x2KIC:
goto oRwov;
gG9Ud:
foreach ($items as &$v) {
    goto FwZAM;
    LPF2Q:
    $v["agentzh"] = pdo_fetchcolumn("select username from " . tablename($this->modulename . "_agentlist") . " where id = {$v["agent_id"]} and uniacid = {$uniacid}");
    goto Fpkg_;
    Fpkg_:
    $v["agentid"] = pdo_fetchcolumn("select id from " . tablename($this->modulename . "_agentlist") . " where id = {$v["agent_id"]} and uniacid = {$uniacid}");
    goto FzCIj;
    FzCIj:
    i19ta:
    goto pmY5r;
    FwZAM:
    $v["agentname"] = pdo_fetchcolumn("select realname from " . tablename($this->modulename . "_agentlist") . " where id = {$v["agent_id"]} and uniacid = {$uniacid}");
    goto LPF2Q;
    pmY5r:
}
goto zKHKa;
mgtKV:
if (!$id) {
    goto x6Sy4;
}
goto Wg7b4;
jfDQ_:
$psize = 15;
goto AahBY;
PvvaO:
die;
goto Le_B9;
GNr6K:
goto cas7u;
goto a8STJ;
aVcqD:
message("删除成功", $this->createWebUrl("messagemanage", array("op" => "displaysend")), "success");
goto THK5M;
jXGJ1:
include $this->template("message_manage");