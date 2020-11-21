<?php

goto BsajH;
mOkLF:
if ($result["sta"]) {
    goto ZE3Oe;
}
goto lyXTl;
lOgOE:
die;
goto ap4Rs;
Wiqja:
message("更新成功", $this->createWebUrl("mirrorvote", array("op" => "display", "rid" => $rid)), "success");
goto k0xZH;
JWs7W:
mkdirs($path);
goto GdiIe;
X3pqr:
pOnSC:
goto uN5Fm;
vZxLy:
goto lvNvS;
goto I4nD5;
EzIoS:
if ($item) {
    goto fL7uO;
}
goto Ffc7W;
Wbo9o:
D28s9:
goto y8tGa;
KQZ05:
$pindex = max(1, intval($_GPC["page"]));
goto ETS39;
vjbu6:
message("您没有权限编辑");
goto MpxS7;
SYC8j:
deRoH:
goto lQ4wo;
Wq3Nh:
pdo_delete($this->modulename . "_mirrorvote", array("id" => $id), "OR");
goto hJH_t;
MpxS7:
jZs1w:
goto Wq3Nh;
CSCVk:
$file_name = $str . "." . $file_type;
goto dnFes;
LO82g:
pdo_update($this->modulename . "_mirrorvote", $data, array("id" => $id));
goto RLJBO;
rHDGg:
ksort($post_data);
goto X7z8D;
AITBG:
$item = pdo_fetch("SELECT * FROM " . tablename($this->modulename . "_mirrorvote") . " WHERE id = '{$id}'");
goto fVnDs;
QeiPt:
io2HF:
goto wMgBu;
RXqn8:
$id = $_GPC["id"];
goto AZ5aD;
Rngoa:
if ($operation == "display") {
    goto pOnSC;
}
goto S7GV4;
RrzWi:
header("Content-Description: File Transfer");
goto dvqyk;
dbLnR:
if (empty($keyword)) {
    goto x8EYN;
}
goto BNRLQ;
THXOU:
header("Content-Length: " . filesize($filename));
goto Qyuhj;
IHdPw:
if ($operation == "downpsd") {
    goto ytXZW;
}
goto UJUbm;
wb5Nx:
$params[":keyword"] = "%{$keyword}%";
goto k5Mdf;
SM83q:
@unlink($psdfile);
goto eRsDS;
OiYOK:
lvNvS:
goto z60Zb;
w6uuY:
message("请输入标题");
goto Wbo9o;
yYhM0:
XLNCT:
goto Zl_mb;
XLVSi:
pdo_insert($this->modulename . "_mirrorvote", $data);
goto ghlai;
kpi10:
if (!($al < $rl)) {
    goto io2HF;
}
goto gtg3j;
y8tGa:
if (empty($data["mirroragent"])) {
    goto deRoH;
}
goto Idl1K;
uOaQS:
goto lvNvS;
goto Fo3AM;
bblPa:
echo json_encode(array("code" => 200, "filepath" => $path . $file_name, "message" => "上传成功"));
goto Rajze;
Icljo:
$item = pdo_fetch("SELECT * FROM " . tablename($this->modulename . "_mirrorvote") . " WHERE id = {$id} and uniacid = {$uniacid}");
goto EzIoS;
fqB1A:
$post_data = array("time" => time(), "ticket" => $cfg["ticket"], "module_id" => 3);
goto rHDGg;
V_jFw:
LFKXm:
goto H9l7W;
ipNBf:
message("不存在或是已经被删除", $this->createWebUrl("mirrorvote", array("op" => "display", "rid" => $rid)), "error");
goto yYhM0;
ghlai:
goto cCm6y;
goto pWRA4;
ZU7c3:
N5OAY:
goto L1tI2;
BNRLQ:
$condition .= " AND title LIKE :keyword";
goto wb5Nx;
lp_5J:
$file_types = explode(".", $file["name"]);
goto YlDu1;
iNQAY:
if ($operation == "deleteall") {
    goto LFKXm;
}
goto VjfAl;
ETS39:
$psize = 15;
goto EEXm1;
hJH_t:
message("删除成功", $this->createWebUrl("mirrorvote", array("op" => "display", "rid" => $rid)), "success");
goto MlCgg;
uN5Fm:
$rid = $_GPC["rid"];
goto KQZ05;
YlDu1:
$file_type = $file_types[count($file_types) - 1];
goto t2fsk;
GsA8D:
$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->modulename . "_mirrorvote") . $condition . $order_condition, $params);
goto B366S;
UJUbm:
goto lvNvS;
goto kNOcs;
LncNv:
$result = json_decode($content["content"], true);
goto mOkLF;
V2Dlv:
$sql = "SELECT * FROM " . tablename($this->modulename . "_mirrorvote") . $condition . $order_condition . " LIMIT " . ($pindex - 1) * $psize . "," . $psize;
goto RN91F;
JPC1q:
$order_condition = " ORDER BY id DESC ";
goto V2Dlv;
VjfAl:
if ($operation == "post") {
    goto N5OAY;
}
goto Rngoa;
QI8xw:
$al = $check["agentlevel"] ?: 0;
goto t61f3;
ox5Q3:
$data = $_GPC["data"];
goto bJC8I;
H9l7W:
if (!(empty($_GPC["idArr"]) || !is_array($_GPC["idArr"]))) {
    goto XLNCT;
}
goto ipNBf;
ap4Rs:
goto lvNvS;
goto ZU7c3;
pWRA4:
rA_VX:
goto LO82g;
lyXTl:
//message("授权错误，请联系客服！", "referer", "error");
goto CT9GP;
x3HeK:
$uniacid = !empty($_W["uniacid"]) ? $_W["uniacid"] : intval($_GET["uniacid"]);
goto p2EYv;
SLSMP:
exit;
goto OiYOK;
nIwgI:
header("Content-Transfer-Encoding: binary");
goto THXOU;
lBqRA:
load()->func("communication");
goto MWzSc;
ynD1v:
checklogin();
goto u_Hgy;
eRsDS:
ioBHM:
goto DMOpl;
ROWkL:
message("上传文件错误，只支持zip和rar文件");
goto mfs_S;
dvqyk:
header("Content-disposition: attachment; filename=" . basename($filename));
goto H8MiR;
s4RSH:
$params = array();
goto dbLnR;
ZiiL2:
$reply["config"] = @unserialize($reply["config"]);
goto cuzTF;
RLJBO:
cCm6y:
goto Wiqja;
k_5a4:
message("不存在或是已经被删除", $this->createWebUrl("mirrorvote", array("op" => "display", "rid" => $rid)), "error");
goto f6rFR;
wMgBu:
goto s9l2_;
goto SYC8j;
f6rFR:
crLjf:
goto Jzl9j;
pdxqS:
$id = intval($_GPC["id"]);
goto AITBG;
dnFes:
move_uploaded_file($file["tmp_name"], $path . $file_name);
goto bblPa;
EYFZf:
ZE3Oe:
goto vrlLl;
QggzE:
if ($operation == "delete") {
    goto rF27D;
}
goto iNQAY;
lQ4wo:
message("请输入经纪人id");
goto guz3F;
Qyuhj:
@readfile($filename);
goto SLSMP;
CT9GP:
goto cNVKz;
goto EYFZf;
p2EYv:
$rid = $_GPC["rid"];
goto QggzE;
DMOpl:
$path = MODULE_ROOT . "/template/static/psd/{$uniacid}/";
goto JWs7W;
zmgYv:
$rid = $_GPC["rid"];
goto CRvcm;
hND0V:
$level = $level ?: 0;
goto JEmpf;
MWzSc:
$content = ihttp_post($url, $post_data);
goto LncNv;
sBgov:
$data["uniacid"] = $uniacid;
goto M_Xi7;
Bksb6:
$url = $this->auth_url . "/index/vote/checkauth";
goto fqB1A;
S7GV4:
if ($operation == "upfile") {
    goto Dn9EP;
}
goto IHdPw;
oedGK:
YDYIO:
goto VhijU;
Jzl9j:
if (!($item["uniacid"] != $uniacid)) {
    goto jZs1w;
}
goto vjbu6;
aTD_Y:
load()->func("tpl");
goto Oj79u;
CRvcm:
$psdfile = $_GPC["psdfile"];
goto UZ125;
EEXm1:
$keyword = trim($_GPC["keyword"]);
goto hS8NW;
BsajH:
defined("IN_IA") or exit("Access Denied");
goto NcSDs;
CEoM9:
if (!$id) {
    goto VsVD2;
}
goto Icljo;
z60Zb:
$reply = pdo_fetch("SELECT * FROM " . tablename($this->tablereply) . " WHERE rid = :rid ORDER BY `id` DESC", array(":rid" => $_GPC["rid"]));
goto ZiiL2;
I4nD5:
Dn9EP:
goto zmgYv;
Rajze:
exit;
goto uOaQS;
k0xZH:
JVA2h:
goto MgKpr;
UZ125:
$file = $_FILES["filedata"];
goto lp_5J;
Idl1K:
$check = pdo_fetch("select * from " . tablename($this->modulename . "_agentlist") . "where id = {$data["mirroragent"]}");
goto R1Apj;
T5jSJ:
if (!empty($id)) {
    goto rA_VX;
}
goto sBgov;
KPt3d:
if (!file_exists($psdfile)) {
    goto ioBHM;
}
goto SM83q;
MgKpr:
goto lvNvS;
goto X3pqr;
Bi1ht:
header("Cache-Control: public");
goto RrzWi;
BcFA8:
VsVD2:
goto yuer2;
wEeSw:
$operation = !empty($_GPC["op"]) ? $_GPC["op"] : "display";
goto x3HeK;
k5Mdf:
x8EYN:
goto JPC1q;
t61f3:
$reply = pdo_fetch("SELECT * FROM " . tablename($this->tablereply) . " WHERE rid = :rid ORDER BY `id` DESC", array(":rid" => $_GPC["rid"]));
goto ZCDBs;
H8MiR:
header("Content-Type: application/zip");
goto nIwgI;
VhijU:
echo "{\"data\":\"删除成功\"}";
goto lOgOE;
kNOcs:
rF27D:
goto pdxqS;
Fo3AM:
ytXZW:
goto RXqn8;
RN91F:
$items = pdo_fetchall($sql, $params);
goto GsA8D;
L1tI2:
$id = intval($_GPC["id"]);
goto XyKMX;
AZ5aD:
$filename = pdo_fetchcolumn("select psdfile from " . tablename($this->modulename . "_mirrorvote") . " where id = {$id}");
goto Bi1ht;
ku0md:
fL7uO:
goto BcFA8;
X7z8D:
$post_data["token"] = md5(sha1(implode('', $post_data)));
goto lBqRA;
yuer2:
if (!checksubmit("submit")) {
    goto JVA2h;
}
goto ox5Q3;
fVnDs:
if (!empty($item)) {
    goto crLjf;
}
goto k_5a4;
guz3F:
s9l2_:
goto T5jSJ;
t2fsk:
if (!(strtolower($file_type) != "zip" && strtolower($file_type) != "rar")) {
    goto Hr1WA;
}
goto ROWkL;
XyKMX:
$rid = $_GPC["rid"];
goto CEoM9;
gtg3j:
message("经纪人等级不满足参与活动要求,经纪人等级为{$al}级,活动要求为{$rl}级");
goto QeiPt;
mfs_S:
Hr1WA:
goto KPt3d;
vrlLl:
cNVKz:
goto aTD_Y;
R1Apj:
$check ?: message("经纪人不存在");
goto QI8xw;
ZCDBs:
$rl = $reply["agentlevel"];
goto kpi10;
Zl_mb:
foreach ($_GPC["idArr"] as $k => $id) {
    goto TOq4i;
    VRzF0:
    if (!$id) {
        goto TD7YF;
    }
    goto w_hrw;
    TOq4i:
    $id = intval($id);
    goto VRzF0;
    itJfA:
    SnV8J:
    goto UfFTf;
    oSIay:
    TD7YF:
    goto itJfA;
    w_hrw:
    pdo_delete($this->modulename . "_mirrorvote", array("id" => $id, "uniacid" => $uniacid));
    goto oSIay;
    UfFTf:
}
goto oedGK;
u_Hgy:
$cfg = $this->module["config"];
goto Bksb6;
Oj79u:
$_W["page"]["title"] = "镜像投票管理";
goto wEeSw;
bJC8I:
if (!empty($data["title"])) {
    goto D28s9;
}
goto w6uuY;
cuzTF:
$level = pdo_fetchcolumn("select level from " . tablename($this->modulename . "_agentlevel") . "where id = {$reply["agentlevel"]}");
goto hND0V;
B366S:
$pager = pagination($total, $pindex, $psize);
goto vZxLy;
hS8NW:
$condition = " WHERE uniacid = {$uniacid} and rid = {$rid}";
goto s4RSH;
NcSDs:
global $_W, $_GPC;
goto ynD1v;
GdiIe:
$str = $rid . "_" . md5(TIMESTAMP);
goto CSCVk;
MlCgg:
goto lvNvS;
goto V_jFw;
Ffc7W:
message("镜像投票不存在");
goto ku0md;
M_Xi7:
$data["rid"] = $rid;
goto XLVSi;
JEmpf:
include $this->template("mirrorvote");