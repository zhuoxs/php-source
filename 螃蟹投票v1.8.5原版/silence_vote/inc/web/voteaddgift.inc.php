<?php

goto aqJmP;
XB_1n:
zac2m:
goto KoVFf;
gf86V:
if (!$id) {
    goto XILoB;
}
goto ndJIL;
w9xyq:
Cpvuf:
goto wDz1o;
VG1O_:
RXaco:
goto E9JWl;
Or2us:
pdo_update($this->modulename . "_gift", $data, array("id" => $id));
goto WMrOH;
HLlgJ:
DqDkJ:
goto oL8PL;
t2kyj:
if ($operation == "getvuser") {
    goto lsoeW;
}
goto CrV2b;
sMDmr:
echo json_encode($info);
goto wufPk;
bqtjK:
sQaLy:
goto Or2us;
IUHcd:
message("不存在或是已经被删除", $this->createWebUrl("voteaddgift", array("op" => "display", "rid" => $rid)), "error");
goto VG1O_;
ndJIL:
$item = pdo_fetch("SELECT * FROM " . tablename($this->modulename . "_gift") . " WHERE id = {$id} and uniacid = {$uniacid}");
goto BUkyH;
R8WnF:
message("虚拟礼物订单不存在");
goto HLlgJ;
Qt3Fh:
gLj8X:
goto xLOw3;
A6Oda:
$post_data = array("time" => time(), "ticket" => $cfg["ticket"], "module_id" => 3);
goto cnZK0;
LDA2Z:
goto Cpvuf;
goto V_J3U;
SDgn_:
$data["ispay"] = 1;
goto HKRnl;
VX_Tu:
pdo_insert($this->modulename . "_count", array("rid" => $rid, "pv_total" => 1, "uniacid" => $uniacid, "tid" => $data["tid"], "share_total" => 0));
goto rlad6;
qcjWj:
XUo5J:
goto uQWvG;
LwMWL:
$uniacid = !empty($_W["uniacid"]) ? $_W["uniacid"] : intval($_GET["uniacid"]);
goto Y5eUb;
zkPxj:
echo "{\"data\":\"删除成功\"}";
goto WjmCm;
LxPbh:
if (!(empty($_GPC["idArr"]) || !is_array($_GPC["idArr"]))) {
    goto DYgqA;
}
goto f5q23;
I3M2l:
WWhmX:
goto N2BEl;
bfrfh:
$giftvote = $item["giftvote"] ?: 0;
goto wmPRL;
zIkHN:
$pic = tomedia($data["avatar"]);
goto jgys0;
BnuvV:
$keyword = trim($_GPC["keyword"]);
goto GMlJ4;
KBObX:
if ($result["sta"]) {
    goto csqbb;
}
goto oYlRU;
dwxY4:
$psize = 15;
goto BnuvV;
uh6hA:
load()->func("tpl");
goto fkTFJ;
wmPRL:
pdo_query("UPDATE " . tablename($this->modulename . "_voteuser") . " SET votenum = votenum - {$giftvote} WHERE id = {$item["tid"]} and uniacid = {$uniacid} and rid = {$rid}");
goto ljdeq;
q6WKo:
HhgxT:
goto zezb7;
RCxJP:
if (!($size > 200)) {
    goto WWhmX;
}
goto KNCrx;
XRVv4:
goto Cpvuf;
goto YN8X1;
c5cPJ:
$id = intval($_GPC["id"]);
goto gf86V;
ljdeq:
message("删除成功", $this->createWebUrl("voteaddgift", array("op" => "display", "rid" => $rid)), "success");
goto LDA2Z;
xqXTF:
$giftvote = $data["giftvote"] ?: 0;
goto On8bQ;
f5q23:
message("不存在或是已经被删除", $this->createWebUrl("voteaddgift", array("op" => "display")), "error");
goto U8FBu;
pbZaa:
foreach ($info as $key => &$val) {
    goto a4U6E;
    ub5Wa:
    AVnG4:
    goto hKnZX;
    a4U6E:
    if ($val["giftvote"] >= 0) {
        goto O_YgT;
    }
    goto mBNWR;
    mBNWR:
    unset($val);
    goto M1iCD;
    M1iCD:
    goto AVnG4;
    goto Qmu7l;
    Qmu7l:
    O_YgT:
    goto m25Nd;
    hKnZX:
    cri7N:
    goto kv691;
    m25Nd:
    $val["id"] = $key;
    goto bInER;
    bInER:
    $val["text"] = "{$val["gifttitle"]} {$val["giftprice"]}元 {$val["giftvote"]}票";
    goto ub5Wa;
    kv691:
}
goto XB_1n;
a67Kf:
if ($operation == "getgift") {
    goto cxB_c;
}
goto t2kyj;
OvsaM:
aU5pm:
goto XRVv4;
oYlRU:
//message("授权错误，请联系客服！", "referer", "error");
goto LYzSt;
RJa6E:
$result = json_decode($content["content"], true);
goto KBObX;
zeDUg:
message("更新成功", $this->createWebUrl("voteaddgift", array("op" => "display", "rid" => $rid)), "success");
goto OvsaM;
KNCrx:
message("图片大小不要超过200k");
goto I3M2l;
RfLAl:
message("请选择一名选手");
goto evnbp;
oL8PL:
XILoB:
goto kkKZy;
jgys0:
$picsize = file_get_contents($pic);
goto wOn6a;
eestC:
$data["giftvote"] = $giftdata[$data["uniontid"]]["giftvote"] * $data["giftcount"];
goto MYUfR;
BUkyH:
if ($item) {
    goto DqDkJ;
}
goto R8WnF;
NewU5:
$operation = !empty($_GPC["op"]) ? $_GPC["op"] : "display";
goto LwMWL;
WjmCm:
die;
goto imK8A;
cYrnA:
pdo_delete($this->modulename . "_gift", array("id" => $id), "OR");
goto bfrfh;
uQWvG:
$condition .= " AND tid in ({$ids})";
goto Xm1gC;
JOb86:
foreach ($info as $key => $value) {
    $info[$key]["text"] = $value["text"] . " id:" . $value["id"];
    xsPOS:
}
goto wyEBr;
kRccY:
$post_data["token"] = md5(sha1(implode('', $post_data)));
goto ccyRy;
BO6qw:
message("您没有权限编辑");
goto DQ4XQ;
O78er:
if (!empty($item)) {
    goto RXaco;
}
goto IUHcd;
nBkXN:
ECD17:
goto tcgEn;
On8bQ:
pdo_query("UPDATE " . tablename($this->modulename . "_voteuser") . " SET votenum = votenum + {$giftvote} WHERE id = {$data["tid"]} and uniacid = {$uniacid} and rid = {$rid}");
goto QW_tE;
X2OzN:
if (empty($keyword)) {
    goto RNe1w;
}
goto xTe4b;
YN8X1:
fArFM:
goto HqFGK;
WCuW9:
cxB_c:
goto O9zWW;
J9EXi:
$url = $this->auth_url . "/index/vote/checkauth";
goto A6Oda;
ZogF5:
$item = pdo_fetch("SELECT * FROM " . tablename($this->modulename . "_gift") . " WHERE id = '{$id}'");
goto O78er;
SCWg9:
$sql = "SELECT * FROM " . tablename($this->modulename . "_gift") . $condition . $order_condition . " LIMIT " . ($pindex - 1) * $psize . "," . $psize;
goto QWGTL;
DQ4XQ:
tbiHv:
goto cYrnA;
zezb7:
$rid = $_GPC["rid"];
goto c5cPJ;
fkTFJ:
$_W["page"]["title"] = "刷礼物管理";
goto NewU5;
N2BEl:
$giftdata = pdo_fetchcolumn("select giftdata from " . tablename($this->modulename . "_reply") . "where uniacid = {$uniacid} and rid = {$rid}");
goto krIsw;
pvxVG:
foreach ($_GPC["idArr"] as $k => $id) {
    goto qviz5;
    AVKWb:
    $item = pdo_fetch("SELECT * FROM " . tablename($this->modulename . "_gift") . " WHERE id = '{$id}'");
    goto OErFK;
    NfVsp:
    mfuBh:
    goto mSdAi;
    WhBRO:
    if (!$id) {
        goto mfuBh;
    }
    goto AVKWb;
    gwETY:
    pdo_query("UPDATE " . tablename($this->modulename . "_voteuser") . " SET votenum = votenum - {$giftvote} WHERE id = {$item["tid"]} and uniacid = {$uniacid} and rid = {$item["rid"]}");
    goto KKiAs;
    OErFK:
    $giftvote = $item["giftvote"] ?: 0;
    goto gwETY;
    qviz5:
    $id = intval($id);
    goto WhBRO;
    KKiAs:
    pdo_delete($this->modulename . "_gift", array("id" => $id, "uniacid" => $uniacid));
    goto NfVsp;
    mSdAi:
    t0GM9:
    goto OBQC8;
    OBQC8:
}
goto bEnEI;
WMrOH:
sK3GV:
goto zeDUg;
Yp4Wm:
exit;
goto nN2_Z;
HqFGK:
$rid = $_GPC["rid"];
goto icFTo;
GMlJ4:
$condition = " WHERE uniacid = {$uniacid} and rid = {$rid} and openid = 'addgift' ";
goto Exj2y;
RevqV:
$pager = pagination($total, $pindex, $psize);
goto iz6kf;
wDz1o:
$reply = pdo_fetch("SELECT * FROM " . tablename($this->tablereply) . " WHERE rid = :rid ORDER BY `id` DESC", array(":rid" => $_GPC["rid"]));
goto h7JvC;
n5QVl:
$info = pdo_fetchall("select *,name as text from " . tablename($this->modulename . "_voteuser") . "where uniacid = {$uniacid} and rid = {$rid}");
goto JOb86;
HKRnl:
$data["uniacid"] = $uniacid;
goto SSY8k;
q_H2w:
checklogin();
goto JlqdM;
LYzSt:
goto Hf3X_;
goto hmhD1;
aqJmP:
defined("IN_IA") or exit("Access Denied");
goto bvH9G;
sP0B5:
$data["gifticon"] = $giftdata[$data["uniontid"]]["gifticon"];
goto eestC;
CAhs5:
pdo_insert($this->modulename . "_gift", $data);
goto VX_Tu;
xTe4b:
$ida = pdo_fetchall("select id from " . tablename($this->modulename . "_voteuser") . " where rid = {$rid} and name like '%{$keyword}%' and uniacid = {$uniacid}");
goto fWjtN;
g5iRz:
$info = unserialize($data);
goto pbZaa;
QW_tE:
$data["openid"] = "addgift";
goto SDgn_;
JlqdM:
$cfg = $this->module["config"];
goto J9EXi;
O9zWW:
$rid = $_GPC["rid"];
goto Qtpe7;
zIW_j:
$content = ihttp_post($url, $post_data);
goto RJa6E;
pNkvI:
if (!empty($data["tid"])) {
    goto hXONx;
}
goto RfLAl;
U2GHV:
$data["gifttitle"] = $giftdata[$data["uniontid"]]["gifttitle"];
goto sP0B5;
KoVFf:
echo json_encode($info);
goto Yp4Wm;
Y5eUb:
if ($operation == "delete") {
    goto ECD17;
}
goto xcxGE;
KD5fZ:
foreach ($ida as $v) {
    $ids .= "," . $v["id"];
    ITNiX:
}
goto qcjWj;
OePbj:
Hf3X_:
goto uh6hA;
bEnEI:
wgjM6:
goto zkPxj;
Xm1gC:
RNe1w:
goto WKQ5K;
icFTo:
$pindex = max(1, intval($_GPC["page"]));
goto dwxY4;
bvH9G:
global $_W, $_GPC;
goto q_H2w;
SSY8k:
$data["createtime"] = time();
goto Jh1iE;
N1lb8:
$rid = $_GPC["rid"];
goto ZogF5;
xcxGE:
if ($operation == "deleteall") {
    goto G_8Cp;
}
goto O4jzX;
cnZK0:
ksort($post_data);
goto kRccY;
nN2_Z:
goto Cpvuf;
goto ye9lm;
Exj2y:
$params = array();
goto X2OzN;
ccyRy:
load()->func("communication");
goto zIW_j;
xLOw3:
$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->modulename . "_gift") . $condition . $order_condition, $params);
goto RevqV;
O4jzX:
if ($operation == "post") {
    goto HhgxT;
}
goto WqvIL;
fWjtN:
$ids = "0";
goto KD5fZ;
evnbp:
hXONx:
goto zIkHN;
Jh1iE:
$data["rid"] = $rid;
goto iVUbP;
kkKZy:
if (!checksubmit("submit")) {
    goto aU5pm;
}
goto i4CPb;
iVUbP:
if (!empty($id)) {
    goto sQaLy;
}
goto CAhs5;
iz6kf:
goto Cpvuf;
goto WCuW9;
ye9lm:
lsoeW:
goto KTkX3;
tF_h1:
foreach ($items as &$v) {
    goto K7Lx8;
    r0pYL:
    bbIw7:
    goto AZI0Y;
    E48UA:
    $v["vuavatar"] = pdo_fetchcolumn("select avatar from" . tablename($this->modulename . "_voteuser") . " where id = {$v["tid"]} ");
    goto r0pYL;
    K7Lx8:
    $v["vuname"] = pdo_fetchcolumn("select name from" . tablename($this->modulename . "_voteuser") . " where id = {$v["tid"]} ");
    goto E48UA;
    AZI0Y:
}
goto Qt3Fh;
i4CPb:
$data = $_GPC["data"];
goto pNkvI;
QWGTL:
$items = pdo_fetchall($sql, $params);
goto tF_h1;
KTkX3:
$rid = $_GPC["rid"];
goto n5QVl;
h7JvC:
$reply["config"] = @unserialize($reply["config"]);
goto NpVLX;
krIsw:
$giftdata = unserialize($giftdata);
goto U2GHV;
wOn6a:
$size = (int) (strlen($picsize) / 1024);
goto RCxJP;
WqvIL:
if ($operation == "display") {
    goto fArFM;
}
goto a67Kf;
tcgEn:
$id = intval($_GPC["id"]);
goto N1lb8;
imK8A:
goto Cpvuf;
goto q6WKo;
wufPk:
exit;
goto w9xyq;
U8FBu:
DYgqA:
goto pvxVG;
CrV2b:
goto Cpvuf;
goto nBkXN;
Qtpe7:
$data = pdo_fetchcolumn("select giftdata from " . tablename($this->modulename . "_reply") . "where uniacid = {$uniacid} and rid = {$rid}");
goto g5iRz;
rlad6:
goto sK3GV;
goto bqtjK;
hmhD1:
csqbb:
goto OePbj;
WKQ5K:
$order_condition = " ORDER BY id DESC ";
goto SCWg9;
E9JWl:
if (!($item["uniacid"] != $uniacid)) {
    goto tbiHv;
}
goto BO6qw;
V_J3U:
G_8Cp:
goto LxPbh;
wyEBr:
Zf8I0:
goto sMDmr;
MYUfR:
$data["fee"] = $data["giftcount"] * $giftdata[$data["uniontid"]]["giftprice"];
goto xqXTF;
NpVLX:
include $this->template("vote_addgift");