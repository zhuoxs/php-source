<?php

goto Da5uf;
YpqbD:
$pager = pagination($total, $pindex, $psize);
goto EVVsD;
CWuoW:
goto X7YwR;
goto mtSkH;
HgwwC:
$condition .= " AND agent_id = {$keyword}";
goto d1eZm;
RCuS0:
goto KMsGl;
goto lmi8E;
qggFP:
if (!(empty($_GPC["idArr"]) || !is_array($_GPC["idArr"]))) {
    goto wpzBl;
}
goto QjZdJ;
bpUNt:
OmePw:
goto lE6FI;
ojXWO:
load()->func("tpl");
goto MyWg2;
RQNxj:
$item = pdo_fetch("SELECT * FROM " . tablename($this->modulename . "_withdraw") . " WHERE id = '{$id}'");
goto nd74r;
vXLSV:
if (!$id) {
    goto QO2xZ;
}
goto tmDxI;
m9tQM:
if (!($check != 0)) {
    goto fTREK;
}
goto Wf3pG;
pAj2S:
$reply_id = $rid;
goto Zmul6;
zzK4R:
$keyword = trim($_GPC["keyword"]);
goto wKg78;
J15HJ:
echo "{\"data\":\"删除成功\"}";
goto r6cyG;
r6cyG:
die;
goto wgU2P;
QjZdJ:
message("不存在或是已经被删除", $this->createWebUrl("withdrawsmanage", array("op" => "display")), "error");
goto rnq4P;
Jlg1h:
goto qO9Z0;
goto UjJsi;
JYCX8:
$remark = $_GPC["remark"];
goto rWDNy;
AuEsW:
message("删除成功", $this->createWebUrl("withdrawsmanage", array("op" => "display")), "success");
goto RCuS0;
sygyR:
XSQnS:
goto K2Ypx;
fPZQq:
$content = ihttp_post($url, $post_data);
goto FKdgz;
i_gRq:
k28O8:
goto bpUNt;
UjJsi:
ThJ8i:
goto qAhqa;
Kr914:
sKpO1:
goto J15HJ;
Wf3pG:
message("该提现记录已被处理，请不要重复处理！", $this->createWebUrl("withdrawsmanage", array("op" => "display")), "success");
goto tPWnp;
QKmqe:
$uniacid = !empty($_W["uniacid"]) ? $_W["uniacid"] : intval($_GET["uniacid"]);
goto Iy3iB;
EVVsD:
goto KMsGl;
goto BVV_C;
tmDxI:
$item = pdo_fetch("SELECT * FROM " . tablename($this->modulename . "_withdraw") . " WHERE id = {$id} and uniacid = {$uniacid}");
goto tBWqw;
SOvxS:
pdo_delete($this->modulename . "_withdraw", array("id" => $id), "OR");
goto AuEsW;
EadVH:
mk34B:
goto SOvxS;
szTHC:
$order_condition = " ORDER BY id DESC ";
goto Q6BHT;
uOIyn:
foreach ($aidA as $key => $value) {
    $aids .= "," . $value["id"];
    Ylzkf:
}
goto sygyR;
bKzTc:
pdo_update($this->modulename . "_withdraw", array("status" => $status, "handletime" => time(), "remark" => $remark), array("id" => $id));
goto lxtZr;
mtSkH:
I0tki:
goto HgwwC;
GkgXr:
foreach ($agentlist as $userfan) {
    goto lpsTS;
    lpsTS:
    if (!$userfan) {
        goto rIMqw;
    }
    goto fmCwj;
    i6CeI:
    rIMqw:
    goto lip40;
    PnDg8:
    $d = $acc->sendTplNotice($userfan["openid"], $cfg["OPENTM406762250"], $postdata, $re_url, $topcolor = "#FF683F");
    goto i6CeI;
    fmCwj:
    $postdata = array("first" => array("value" => "恭喜，您的提现我们已经处理，近期到账，请注意查收~", "color" => "#173177"), "keyword1" => array("value" => $da["money"] . "元", "color" => "#173177"), "keyword2" => array("value" => date("Y-m-d H:i:s", $_W["timestamp"]), "color" => "#173177"), "keyword3" => array("value" => "手动打款", "color" => "#173177"), "remark" => array("value" => $da["remark"], "color" => "#173177"));
    goto PnDg8;
    lip40:
    GsIwS:
    goto gVR3y;
    gVR3y:
}
goto YYPzN;
d1eZm:
X7YwR:
goto K5jDV;
tBWqw:
QO2xZ:
goto dnepa;
c_oaM:
$da = pdo_fetch("SELECT * FROM " . tablename($this->modulename . "_withdraw") . " WHERE uniacid = {$_W["uniacid"]} AND id = {$id}");
goto V8ciQ;
Z33Xu:
if ($operation == "display") {
    goto L9yyX;
}
goto mg0aB;
eXjjm:
if (empty($keyword)) {
    goto R_2wD;
}
goto M28PQ;
wKg78:
$condition = " WHERE uniacid = {$uniacid} ";
goto J9tVY;
Fb3uH:
goto KMsGl;
goto gcWnx;
msuIp:
$pindex = max(1, intval($_GPC["page"]));
goto zU3ke;
rWDNy:
if (!empty($remark)) {
    goto d6vR6;
}
goto phSEa;
nWrvf:
$where = " and id = {$da["agent_id"]}";
goto dd4Dy;
JCmkA:
$post_data = array("time" => time(), "ticket" => $cfg["ticket"], "module_id" => 3);
goto kB3Su;
t8uW9:
if ($operation == "post") {
    goto SWngZ;
}
goto Z33Xu;
MjQvw:
Hr6Bk:
goto Jlg1h;
HWsvw:
$acc = WeAccount::create($uniacid);
goto yRC2W;
qLH31:
message("您没有权限编辑");
goto EadVH;
qpelR:
$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->modulename . "_withdraw") . $condition . $order_condition, $params);
goto YpqbD;
LFVFO:
goto KMsGl;
goto HDnyY;
dd4Dy:
$agentlist = pdo_fetchall("SELECT * FROM " . tablename($this->modulename . "_agentlist") . " WHERE uniacid = {$_W["uniacid"]} AND openid != '' and openid != '0'" . $where);
goto Shc6w;
DnCgz:
checklogin();
goto ojXWO;
J73KY:
$check = pdo_fetchcolumn("SELECT status FROM " . tablename($this->modulename . "_withdraw") . "where id = {$id}");
goto m9tQM;
M28PQ:
if (is_numeric($keyword)) {
    goto I0tki;
}
goto m3jUD;
boovp:
$aidA = pdo_fetchall("select id from " . tablename($this->modulename . "_agentlist") . " where realname like '%{$keyword}%' and uniacid = {$uniacid} ");
goto uOIyn;
XQdEb:
$id = intval($_GPC["id"]);
goto vXLSV;
vWe2P:
if (!($item["uniacid"] != $uniacid)) {
    goto mk34B;
}
goto qLH31;
xbiNc:
$cfg = $this->module["config"];
goto pAj2S;
yRC2W:
$where = " and id = {$da["agent_id"]}";
goto lI4Kg;
Scht9:
message("更新成功", $this->createWebUrl("withdrawsmanage", array("op" => "display")), "success");
goto zY6zF;
lxtZr:
$da = pdo_fetch("SELECT * FROM " . tablename($this->modulename . "_withdraw") . " WHERE uniacid = {$_W["uniacid"]} AND id = {$id}");
goto xbiNc;
zY6zF:
KMsGl:
goto SnUxH;
nd74r:
if (!empty($item)) {
    goto WpOXY;
}
goto qUF_R;
RbG8v:
if ($status == 1) {
    goto ThJ8i;
}
goto bKzTc;
WDLUI:
goto OmePw;
goto i_gRq;
enrrQ:
load()->func("communication");
goto fPZQq;
n1olo:
$url = $this->auth_url . "/index/vote/checkauth";
goto JCmkA;
YYPzN:
INETK:
goto fCHfy;
w3Y7H:
if ($operation == "deleteall") {
    goto xtrro;
}
goto t8uW9;
m3jUD:
$aids = "0";
goto boovp;
BVV_C:
RwROB:
goto FFPiO;
phSEa:
message("备注不能为空！");
goto WlRwA;
BrEzG:
$id = $_GPC["id"];
goto J73KY;
WlRwA:
d6vR6:
goto RbG8v;
WTwe1:
NHSJd:
goto qpelR;
aaFzK:
$id = intval($_GPC["id"]);
goto RQNxj;
FaI_V:
$re_url = $_W["siteroot"] . "app/" . $this->createMobileUrl("ht_withdraws");
goto HWsvw;
qAhqa:
pdo_update($this->modulename . "_withdraw", array("status" => $status, "handletime" => time(), "remark" => $remark), array("id" => $id));
goto c_oaM;
ipXtP:
//message("授权错误，请联系客服！", "referer", "error");
goto WDLUI;
FFPiO:
$status = $_GPC["status"];
goto BrEzG;
Da5uf:
defined("IN_IA") or exit("Access Denied");
goto QGpmL;
qUF_R:
message("不存在或是已经被删除", $this->createWebUrl("withdrawsmanage", array("op" => "display")), "error");
goto qUV28;
qUV28:
WpOXY:
goto vWe2P;
M6O_0:
$cfg = $this->module["config"];
goto n1olo;
N2FeM:
$post_data["token"] = md5(sha1(implode('', $post_data)));
goto enrrQ;
KbXOX:
foreach ($_GPC["idArr"] as $k => $id) {
    goto Uu_77;
    w5Pk7:
    F5ZsK:
    goto SQKS7;
    E0dWl:
    pdo_delete($this->modulename . "_withdraw", array("id" => $id, "uniacid" => $uniacid));
    goto Omex5;
    Uu_77:
    $id = intval($id);
    goto G0tIj;
    Omex5:
    gXd2f:
    goto w5Pk7;
    G0tIj:
    if (!$id) {
        goto gXd2f;
    }
    goto E0dWl;
    SQKS7:
}
goto Kr914;
UEEtU:
$reply_id = $rid;
goto FaI_V;
kB3Su:
ksort($post_data);
goto N2FeM;
HDnyY:
L9yyX:
goto msuIp;
J9tVY:
$params = array();
goto eXjjm;
Shc6w:
foreach ($agentlist as $userfan) {
    goto IqYyT;
    fEo3W:
    lerJi:
    goto NlFLH;
    IqYyT:
    if (!$userfan) {
        goto lerJi;
    }
    goto KSxIX;
    KSxIX:
    $postdata = array("first" => array("value" => "申请提现发放失败", "color" => "#173177"), "keyword1" => array("value" => date("Y-m-d H:i:s", $_W["timestamp"]), "color" => "#173177"), "keyword2" => array("value" => $da["remark"], "color" => "#173177"), "remark" => array("value" => "如有疑问，请联系相关客服", "color" => "#173177"));
    goto fbQY3;
    fbQY3:
    $d = $acc->sendTplNotice($userfan["openid"], $cfg["OPENTM409997271"], $postdata, $re_url, $topcolor = "#FF683F");
    goto fEo3W;
    NlFLH:
    aKq65:
    goto fnAFp;
    fnAFp:
}
goto MjQvw;
gWJYe:
foreach ($items as &$vv) {
    goto rPZGs;
    qSeHq:
    G_At4:
    goto Tq3BI;
    Sy_wd:
    $vv["moneyqr"] = pdo_fetchcolumn("select moneyqr from " . tablename($this->modulename . "_agentlist") . " where id = {$vv["agent_id"]} and uniacid = {$uniacid}");
    goto qSeHq;
    rPZGs:
    $vv["agentname"] = pdo_fetchcolumn("select realname from " . tablename($this->modulename . "_agentlist") . " where id = {$vv["agent_id"]} and uniacid = {$uniacid}");
    goto Sy_wd;
    Tq3BI:
}
goto WTwe1;
DjTbg:
$items = pdo_fetchall($sql, $params);
goto gWJYe;
AUHoz:
$acc = WeAccount::create($uniacid);
goto nWrvf;
mg0aB:
if ($operation == "review") {
    goto RwROB;
}
goto Fb3uH;
wgU2P:
goto KMsGl;
goto ousCL;
cWXnj:
k7Gjd:
goto LFVFO;
MyWg2:
$_W["page"]["title"] = "提现管理";
goto M6O_0;
ousCL:
SWngZ:
goto XQdEb;
FKdgz:
$result = json_decode($content["content"], true);
goto golRq;
K2Ypx:
$condition .= " AND agent_id in ({$aids})";
goto CWuoW;
K5jDV:
R_2wD:
goto szTHC;
Zmul6:
$re_url = $_W["siteroot"] . "app/" . $this->createMobileUrl("ht_withdraws");
goto AUHoz;
tPWnp:
fTREK:
goto JYCX8;
dnepa:
if (!checksubmit("submit")) {
    goto k7Gjd;
}
goto cWXnj;
gcWnx:
EnJn6:
goto aaFzK;
lE6FI:
$operation = !empty($_GPC["op"]) ? $_GPC["op"] : "display";
goto QKmqe;
zU3ke:
$psize = 15;
goto zzK4R;
lI4Kg:
$agentlist = pdo_fetchall("SELECT * FROM " . tablename($this->modulename . "_agentlist") . " WHERE uniacid = {$_W["uniacid"]} AND openid != '' and openid != '0'" . $where);
goto GkgXr;
lmi8E:
xtrro:
goto qggFP;
rnq4P:
wpzBl:
goto KbXOX;
golRq:
if ($result["sta"]) {
    goto k28O8;
}
goto ipXtP;
QGpmL:
global $_W, $_GPC;
goto DnCgz;
Iy3iB:
if ($operation == "delete") {
    goto EnJn6;
}
goto w3Y7H;
Q6BHT:
$sql = "SELECT * FROM " . tablename($this->modulename . "_withdraw") . $condition . $order_condition . " LIMIT " . ($pindex - 1) * $psize . "," . $psize;
goto DjTbg;
fCHfy:
qO9Z0:
goto Scht9;
V8ciQ:
$cfg = $this->module["config"];
goto UEEtU;
SnUxH:
include $this->template("withdraws_manage");