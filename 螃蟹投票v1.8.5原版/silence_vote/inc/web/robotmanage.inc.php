<?php

goto v27gC;
iSW0t:
BlqW1:
goto YaqPD;
RT3zx:
VlkNs:
goto LtPSM;
WQI2O:
message("不存在或是已经被删除", $this->createWebUrl("robotmanage", array("op" => "display")), "error");
goto z3JAh;
MBQJz:
$reply_id = $_GPC["reply_id"];
goto YF1EV;
W9Yev:
load()->func("tpl");
goto mOXa6;
R5WtF:
if ($operation == "post") {
    goto Pk80H;
}
goto I27jK;
dAGhL:
$data["id"] = $id;
goto ib_By;
jhuhL:
$uniacid = !empty($_W["uniacid"]) ? $_W["uniacid"] : intval($_GET["uniacid"]);
goto Qexa5;
ib_By:
$a = $this->delrobot($data);
goto fs9Wp;
eJh4u:
q80QA:
goto JB4qr;
RIvR6:
$id = intval($_GPC["id"]);
goto dAGhL;
cciCA:
$ids = $ids ? join(",", $ids) : 0;
goto BGd21;
m3Qqf:
$content = ihttp_post($url, $post_data);
goto zR9Lg;
VG3r3:
$data["dailyend"] = $data["dailyend"] ?: "23:59:59";
goto CqGv4;
UKprZ:
message("机器人不存在");
goto PZNhZ;
Wrbfj:
echo "{\"data\":\"更新成功\"}";
goto MtwX5;
o6J2n:
message("差额百分比设置不正确");
goto eJh4u;
Dr3PC:
$url = $this->auth_url . "/index/vote/checkauth";
goto Cwg5r;
HT_sO:
$id = intval($_GPC["id"]);
goto JtdMb;
zpniv:
xiZpW:
goto hcJun;
XwEvY:
message("每日执行时间段设置不正确");
goto nEBxK;
LO_QI:
RtTrc:
goto W9Yev;
F5DPX:
$data["reply_id"] = $reply_id;
goto O72jf;
yJd6I:
$psize = 15;
goto fFiG0;
JQzmy:
$pindex = max(1, intval($_GPC["page"]));
goto yJd6I;
lYuWN:
$cfg = $this->module["config"];
goto Dr3PC;
Mmqtn:
if ($operation == "deleteall") {
    goto jFSvj;
}
goto R5WtF;
L0hYr:
$sql = "SELECT * FROM silence_vote_robotlist WHERE id = {$id} and uniacid = {$uniacid} and ticket = '{$cfg["ticket"]}'";
goto WYGLU;
v27gC:
defined("IN_IA") or exit("Access Denied");
goto ChTmr;
hK6RH:
Pk80H:
goto rMin5;
KduPF:
IOqSv:
goto Zauia;
dn6KR:
$arr = $this->getrobot($data);
goto FkCab;
ChTmr:
global $_W, $_GPC;
goto YglF5;
gcBMa:
echo "{\"data\":\"删除成功\"}";
goto EIQr9;
e0CvZ:
$data["id"] = $id;
goto sekbr;
O72jf:
$data["rid"] = $rid;
goto e0CvZ;
BjzgG:
JSqmO:
goto Tw95S;
uxOQP:
$data["rid"] = $rid;
goto Yi5GB;
hcJun:
$total = $arr["total"];
goto A7BfV;
PZNhZ:
CuoBk:
goto a9TJI;
YglF5:
checklogin();
goto lYuWN;
h9W43:
$params = array();
goto RDNgX;
AKZRA:
$operation = !empty($_GPC["op"]) ? $_GPC["op"] : "display";
goto jhuhL;
A7BfV:
$pager = pagination($total, $pindex, $psize);
goto jcinX;
VcH5x:
if (!(empty($_GPC["idArr"]) || !is_array($_GPC["idArr"]))) {
    goto WmeM2;
}
goto WQI2O;
mOXa6:
$_W["page"]["title"] = "机器人管理";
goto AKZRA;
hIa86:
$ids = pdo_fetch("select id from " . tablename($this->modulename . "_voteuser") . $condition . " and  nickname like '%{$keyword}%' ");
goto cciCA;
piOsS:
ksort($post_data);
goto qsp3T;
DZOo4:
message("保存成功", $this->createWebUrl("robotmanage", array("op" => "display", "rid" => $rid, "reply_id" => $reply_id)), "success");
goto BjzgG;
vOIzT:
//message("授权错误，请联系客服！", "referer", "error");
goto rfGVC;
Vu9mE:
if (!checksubmit("submit")) {
    goto hP2zm;
}
goto M1IhU;
Nm4NC:
if ($item) {
    goto CuoBk;
}
goto UKprZ;
Cwg5r:
$post_data = array("time" => time(), "ticket" => $cfg["ticket"], "module_id" => 3);
goto piOsS;
CqGv4:
if (!(strtotime($data["dailystart"]) > strtotime($data["dailyend"]))) {
    goto K6G69;
}
goto XwEvY;
zR9Lg:
$result = json_decode($content["content"], true);
goto XnukF;
Glu85:
$status = $_GPC["status"] ? 0 : 1;
goto SKHrL;
RDNgX:
if (empty($keyword)) {
    goto BlqW1;
}
goto hIa86;
QNKdY:
if (!($data["balance"] < 1 || $data["balance"] > 100)) {
    goto q80QA;
}
goto o6J2n;
I4psO:
LhmQy:
goto DZOo4;
b9gd7:
OT3mw:
goto Vu9mE;
YF1EV:
$rid = $_GPC["rid"];
goto JQzmy;
fs9Wp:
message($a, referer(), "success");
goto YvhtE;
ClQKE:
goto b5TS_;
goto hK6RH;
VPsIk:
$item = $this->getrobot($data);
goto Nm4NC;
sMfzJ:
OQgAh:
goto LO_QI;
KBv26:
ZzRtI:
goto gcBMa;
cSY_3:
$i = $this->saverobot($data);
goto SJjBf;
e_EIS:
$sqltotal = "SELECT count(*) as total FROM silence_vote_robotlist " . $condition . $order_condition;
goto uxOQP;
ZJI4D:
$sql = "SELECT * FROM silence_vote_robotlist " . $condition . $order_condition . " LIMIT " . ($pindex - 1) * $psize . "," . $psize;
goto e_EIS;
nEh2X:
load()->func("communication");
goto m3Qqf;
SKHrL:
pdo_update($this->modulename . "_reply", array("robotstatus" => $status), array("rid" => $rid));
goto Wrbfj;
LIx9T:
$data["sql"] = $sql;
goto VPsIk;
JtdMb:
if (!$id) {
    goto OT3mw;
}
goto AnES_;
YvhtE:
goto b5TS_;
goto Uwiea;
Uwiea:
jFSvj:
goto VcH5x;
auFhr:
message("保存失败");
goto DcZFV;
DcZFV:
goto JSqmO;
goto I4psO;
a9TJI:
$item = $item["info"][0];
goto b9gd7;
YaqPD:
$order_condition = " ORDER BY id DESC ";
goto ZJI4D;
Qexa5:
if ($operation == "delete") {
    goto VH8rO;
}
goto Mmqtn;
Zauia:
$rid = $_GPC["rid"];
goto Glu85;
Nu5f4:
$data["dailystart"] = $data["dailystart"] ?: "00:00:00";
goto VG3r3;
oUQqn:
$reply["config"] = @unserialize($reply["config"]);
goto Po3hn;
I27jK:
if ($operation == "display") {
    goto VlkNs;
}
goto MUpJP;
Zi7R0:
foreach ($items as $key => $value) {
    goto ewlzA;
    mn4N2:
    $items[$key]["vuid"] = $vuid["id"];
    goto FmuXJ;
    RqloN:
    $vuid = pdo_fetch("select id from " . tablename($this->modulename . "_voteuser") . " where id = {$value["vuid"]} and uniacid = {$uniacid}");
    goto HgjK0;
    ewlzA:
    $nickname = pdo_fetch("select nickname from " . tablename($this->modulename . "_voteuser") . " where id = {$value["vuid"]} and uniacid = {$uniacid}");
    goto K1T6q;
    K1T6q:
    $name = pdo_fetch("select name from " . tablename($this->modulename . "_voteuser") . " where id = {$value["vuid"]} and uniacid = {$uniacid}");
    goto RqloN;
    FmuXJ:
    S6hFW:
    goto JoRsA;
    UPu2E:
    $items[$key]["name"] = $name["name"];
    goto mn4N2;
    HgjK0:
    $items[$key]["nickname"] = $nickname["nickname"];
    goto UPu2E;
    JoRsA:
}
goto zpniv;
vmLXG:
$cfg = $this->module["config"];
goto QvDxn;
dVA8p:
goto b5TS_;
goto RT3zx;
BGd21:
$condition .= " AND vuid in ({$ids})";
goto iSW0t;
uWFWh:
$rid = $_GPC["rid"];
goto HT_sO;
jcinX:
goto b5TS_;
goto KduPF;
LtPSM:
cache_clean();
goto MBQJz;
qsp3T:
$post_data["token"] = md5(sha1(implode('', $post_data)));
goto nEh2X;
z3JAh:
WmeM2:
goto q1uJG;
sekbr:
$data["starttime"] = strtotime($_GPC["time"]["start"]);
goto Uq0TY;
M1IhU:
$data = $_GPC["data"];
goto F5DPX;
nEBxK:
K6G69:
goto QNKdY;
MUpJP:
if ($operation == "checkrobot") {
    goto IOqSv;
}
goto bB7dc;
EIQr9:
die;
goto ClQKE;
oPWQG:
VH8rO:
goto RIvR6;
cLQWz:
$reply = pdo_fetch("SELECT * FROM " . tablename($this->tablereply) . " WHERE rid = :rid ORDER BY `id` DESC", array(":rid" => $_GPC["rid"]));
goto oUQqn;
AnES_:
$cfg = $this->module["config"];
goto L0hYr;
q1uJG:
foreach ($_GPC["idArr"] as $k => $id) {
    goto O1U6N;
    FzstA:
    Z9Eom:
    goto nZwIH;
    l6jWB:
    $data["id"] = $id;
    goto SSA0t;
    SSA0t:
    $this->delrobot($data);
    goto z1eAq;
    sJAk2:
    if (!$id) {
        goto vIFdH;
    }
    goto l6jWB;
    O1U6N:
    $id = intval($id);
    goto sJAk2;
    z1eAq:
    vIFdH:
    goto FzstA;
    nZwIH:
}
goto KBv26;
rfGVC:
goto RtTrc;
goto sMfzJ;
bB7dc:
goto b5TS_;
goto oPWQG;
Uq0TY:
$data["endtime"] = strtotime($_GPC["time"]["end"]);
goto Nu5f4;
fFiG0:
$keyword = trim($_GPC["keyword"]);
goto vmLXG;
FkCab:
$items = $arr["info"];
goto Zi7R0;
MtwX5:
die;
goto Q17Ad;
Yi5GB:
$data["sql"] = $sql;
goto Fwe68;
WYGLU:
$data["rid"] = $rid;
goto LIx9T;
rMin5:
$reply_id = $_GPC["reply_id"];
goto uWFWh;
SJjBf:
if ($i) {
    goto LhmQy;
}
goto auFhr;
Tw95S:
hP2zm:
goto dVA8p;
JB4qr:
$data["uniacid"] = $uniacid;
goto cSY_3;
Fwe68:
$data["sqltotal"] = $sqltotal;
goto dn6KR;
XnukF:
if ($result["sta"]) {
    goto OQgAh;
}
goto vOIzT;
QvDxn:
$condition = " WHERE uniacid = {$uniacid} and rid = {$rid} ";
goto h9W43;
Q17Ad:
b5TS_:
goto cLQWz;
Po3hn:
include $this->template("robot_manage");