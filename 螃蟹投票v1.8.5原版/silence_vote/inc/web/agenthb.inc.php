<?php

goto Jx2q1;
r5t9i:
ksort($post_data);
goto xVBfX;
Wk370:
goto i3PXa;
goto Zl6Ae;
PeUsJ:
$id = $_GPC["id"];
goto guH22;
XKacA:
goto J1RmI;
goto rZOLM;
k5stu:
RjLRU:
goto AYxYo;
THk6w:
$nofont = 1;
goto TE_ta;
eB01C:
$reply = pdo_fetch("SELECT * FROM " . tablename($this->tablereply) . " WHERE rid = :rid ORDER BY `id` DESC", array(":rid" => $_GPC["rid"]));
goto OTy52;
x4RGc:
goto RjLRU;
goto pFD3D;
BzPm1:
$content = ihttp_post($url, $post_data);
goto eMhDA;
LaoLr:
$cfg = $this->module["config"];
goto H5lKh;
wdIUf:
$uniacid = !empty($_W["uniacid"]) ? $_W["uniacid"] : intval($_GET["uniacid"]);
goto pQSdH;
XEsV0:
pdo_insert($this->modulename . "_agenthb", $insert);
goto zxZ8f;
TE_ta:
ZU1_8:
goto eZPCp;
u4KIO:
xVH2T:
goto PeUsJ;
BtgLF:
$insert = array("rid" => $rid, "uniacid" => $_W["uniacid"], "config" => $config, "bill_data" => htmlspecialchars_decode($_GPC["bill_data"]));
goto OrV16;
Mb5ot:
$aghb = pdo_fetch("SELECT * FROM " . tablename($this->modulename . "_agenthb") . " WHERE rid = :rid ORDER BY `id` DESC", array(":rid" => $rid));
goto C6O7v;
pFD3D:
eOkEH:
goto k5stu;
eMhDA:
$result = json_decode($content["content"], true);
goto TyS8Q;
Z34Al:
$rid = intval($_GPC["rid"]);
goto Mb5ot;
pQSdH:
if ($operation == "display") {
    goto bVrKt;
}
goto anWtB;
DcWAe:
if (file_exists(MODULE_ROOT . "/lib/font/font.ttf")) {
    goto ZU1_8;
}
goto THk6w;
OTy52:
$reply["config"] = @unserialize($reply["config"]);
goto YCFdM;
Zl6Ae:
ae82J:
goto XEsV0;
zxZ8f:
i3PXa:
goto TFftS;
H5lKh:
$url = $this->auth_url . "/index/vote/checkauth";
goto sxN26;
xYXQE:
global $_W, $_GPC;
goto twax2;
EPwNE:
//message("授权错误，请联系客服！", "referer", "error");
goto x4RGc;
anWtB:
if ($operation == "post") {
    goto xVH2T;
}
goto XKacA;
Jx2q1:
defined("IN_IA") or exit("Access Denied");
goto xYXQE;
nHe21:
pdo_update($this->modulename . "_agenthb", $insert, array("id" => $id));
goto Wk370;
TyS8Q:
if ($result["sta"]) {
    goto eOkEH;
}
goto EPwNE;
C6O7v:
$aghb = @array_merge($aghb, @unserialize($aghb["config"]));
goto fVZzB;
sxN26:
$post_data = array("time" => time(), "ticket" => $cfg["ticket"], "module_id" => 3);
goto r5t9i;
eZPCp:
goto J1RmI;
goto u4KIO;
QbzNI:
load()->func("tpl");
goto RzJ9M;
xVBfX:
$post_data["token"] = md5(sha1(implode('', $post_data)));
goto ddrI5;
hny6H:
$config = @iserializer(array("bill_bg" => $_GPC["bill_bg"], "bill_hint" => $_GPC["bill_hint"]));
goto BtgLF;
TFftS:
message("设置经纪人海报成功！", referer(), "success");
goto Mb11g;
fVZzB:
$bill_data = json_decode(str_replace("&quot;", "'", $aghb["bill_data"]), true);
goto DcWAe;
guH22:
$rid = $_GPC["rid"];
goto hny6H;
rZOLM:
bVrKt:
goto Z34Al;
Mb11g:
J1RmI:
goto eB01C;
AYxYo:
$operation = !empty($_GPC["op"]) ? $_GPC["op"] : "display";
goto wdIUf;
OrV16:
if (empty($id)) {
    goto ae82J;
}
goto nHe21;
RzJ9M:
$_W["page"]["title"] = "经纪人海报管理";
goto LaoLr;
twax2:
checklogin();
goto QbzNI;
ddrI5:
load()->func("communication");
goto BzPm1;
YCFdM:
include $this->template("agent_hb");
goto L6GPO;
L6GPO:
exit;