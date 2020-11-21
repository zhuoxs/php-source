<?php

goto iPLJP;
kHcyG:
$instdata["id"] = $votedata["id"];
goto Futui;
JmbuO:
$instdata["createtime"] = $votedata["createtime"];
goto y01sl;
xLDXE:
goto oGaik;
goto VL3Fg;
oCw6S:
load()->func("file");
goto Ln7Aq;
Fve1A:
$formatdata = unserialize($votedata["formatdata"]);
goto h6Ozp;
Pmoce:
foreach ($_GPC["videoarr"] as $key => $v) {
    $videoarr[] = $v;
    eau7A:
}
goto tfZoW;
qc62f:
$videoarr = array();
goto Pmoce;
Qq0yz:
$maxaudio = count($audioarr) + 1;
goto frXo2;
N7bT_:
$audiostr = json_encode($audioarr);
goto xFJ4n;
VuVRg:
if ($result["sta"]) {
    goto JEBxc;
}
goto oMEoE;
JXb1V:
$instdata["createtime"] = time();
goto b1r2T;
jx2iP:
dgCaL:
goto qc62f;
jQR6O:
$lastid = pdo_getall($this->tablevoteuser, array("rid" => $rid, "uniacid" => $_W["uniacid"]), array("noid", "source_id"), '', "noid DESC", array(1));
goto QEqrH;
Futui:
$instdata["noid"] = $votedata["noid"];
goto JmbuO;
BPdKc:
$instdata = array("noid" => intval($_GPC["noid"]), "rid" => $rid, "uniacid" => $_W["uniacid"], "avatar" => $_GPC["avatar"], "openid" => $_GPC["openid"], "oauth_openid" => $_GPC["oauth_openid"], "name" => $_GPC["name"], "nickname" => $_GPC["nickname"], "introduction" => $_GPC["introduction"], "resume" => $_GPC["resume"], "img1" => $_GPC["img1"], "img2" => $_GPC["img2"], "img3" => $_GPC["img3"], "img4" => $_GPC["img4"], "img5" => $_GPC["img5"], "videoarr" => $videostr, "videodesc" => $videodesc, "audioarr" => $audiostr, "audiodesc" => $audiodesc, "details" => htmlspecialchars_decode($_GPC["details"]), "joindata" => iserializer($joinedata), "votenum +=" => empty($_GPC["addvotenum"]) ? 0 : $_GPC["addvotenum"], "giftcount +=" => empty($_GPC["addgiftcount"]) ? 0 : $_GPC["addgiftcount"], "vheat" => $_GPC["vheat"], "attestation" => $_GPC["attestation"], "atmsg" => $_GPC["atmsg"], "status" => $_GPC["status"], "agent_id" => $_GPC["agentid"], "zc" => $_GPC["zc"], "saiquid" => $_GPC["saiquid"]);
goto bhyfO;
VRLNd:
goto fzhBm;
goto y5fZV;
J_93B:
r_agL:
goto Un2FW;
E0lOI:
$uniacid = intval($_W["uniacid"]);
goto mREvr;
S7shU:
$url = $this->auth_url . "/index/vote/checkauth";
goto XJWBR;
GrRA9:
zBHhV:
goto nFbnD;
Csl2S:
message("名字不能为空");
goto yLtbQ;
EChI4:
foreach ($_GPC["join"] as $key => $row) {
    $joinedata[] = array("name" => $key, "val" => $row);
    EVCZV:
}
goto jx2iP;
tfZoW:
ZDK6i:
goto YCAN4;
oMEoE:
//message("授权错误，请联系客服！", "referer", "error");
goto VRLNd;
d8cJs:
pdo_update($this->tablevoteuser, array("fmimg" => $_GPC["which"] ?: 1), array("id" => $id));
goto PY8O2;
y5fZV:
JEBxc:
goto ut2gk;
v2Utt:
$videodesc = json_decode($votedata["videodesc"], true);
goto ff1nb;
QEqrH:
$instdata["noid"] = $lastid[0]["noid"] + 1;
goto JXb1V;
AdUDT:
exit;
goto GrRA9;
b1r2T:
pdo_insert($this->tablevoteuser, $instdata);
goto chdBQ;
YCAN4:
$videostr = json_encode($videoarr);
goto M4gUb;
qLNwa:
$reply = @array_merge($reply, @unserialize($reply["config"]));
goto d3ik2;
kZX0h:
$tplappye = m("tpl")->tpl_inputweb($applydata, $joindata);
goto mhO4R;
EKXZ0:
$rid = intval($_GPC["rid"]);
goto In_xF;
ajYiO:
if (!empty($_GPC["name"])) {
    goto qTflg;
}
goto Csl2S;
PAn9w:
$votedata = pdo_fetch("SELECT * FROM " . tablename($this->tablevoteuser) . " WHERE  id = :id AND uniacid = :uniacid AND rid = :rid", array(":id" => $id, ":uniacid" => $uniacid, ":rid" => $rid));
goto Fve1A;
iPLJP:
defined("IN_IA") or exit("Access Denied");
goto BFN4H;
t7kKB:
$_GPC["oauth_openid"] = $_GPC["openid"];
goto Au68J;
zQXh_:
mQ317:
goto X5xso;
BFN4H:
$cfg = $this->module["config"];
goto S7shU;
chdBQ:
$instdata["id"] = pdo_insertid();
goto xLDXE;
JQAxu:
$maxvideo = count($videoarr) + 1;
goto v2Utt;
YVW7b:
$content = ihttp_post($url, $post_data);
goto T1IM1;
bhyfO:
if (!empty($votedata["id"])) {
    goto ttwRp;
}
goto jQR6O;
ut2gk:
fzhBm:
goto oCw6S;
d1Xtd:
foreach ($_GPC["audioarr"] as $key => $v) {
    $audioarr[] = $v;
    a1z8t:
}
goto Yvbfx;
XJWBR:
$post_data = array("time" => time(), "ticket" => $cfg["ticket"], "module_id" => 3);
goto e4rTi;
iySqM:
pdo_update($this->tablevoteuser, $instdata, array("id" => $votedata["id"]));
goto kHcyG;
e4rTi:
ksort($post_data);
goto HYv7r;
Aasqt:
$applydata = @unserialize($reply["applydata"]);
goto PAn9w;
XhTDm:
global $_W, $_GPC;
goto E0lOI;
HYv7r:
$post_data["token"] = md5(sha1(implode('', $post_data)));
goto phgk2;
DVCpb:
if (!($votedata["createtime"] + 259000 > time())) {
    goto Be96E;
}
goto egxlf;
syh9f:
if (!empty($_GPC["oauth_openid"])) {
    goto iKXC7;
}
goto t7kKB;
Ln7Aq:
load()->func("tpl");
goto XhTDm;
frXo2:
$audiodesc = json_decode($votedata["audiodesc"], true);
goto K1dOP;
iqEII:
$videoarr = json_decode($votedata["videoarr"], true);
goto JQAxu;
h6Ozp:
$options = array("width" => 80, "height" => 80);
goto iqEII;
mREvr:
$id = intval($_GPC["id"]);
goto EKXZ0;
Un2FW:
$joindata = @unserialize($votedata["joindata"]);
goto kZX0h;
yLtbQ:
qTflg:
goto EChI4;
Au68J:
iKXC7:
goto BPdKc;
M4gUb:
$videodesc = json_encode($_GPC["videodesc"]);
goto EkSMo;
ANXI1:
if (!$_W["ispost"]) {
    goto r_agL;
}
goto ajYiO;
y01sl:
oGaik:
goto I0j1l;
d3ik2:
unset($reply["config"]);
goto Aasqt;
I0j1l:
if (!empty($lastid[0]["source_id"])) {
    goto mQ317;
}
goto P5cfj;
phgk2:
load()->func("communication");
goto YVW7b;
egxlf:
$nodownpic = 1;
goto ZQM4w;
Yvbfx:
Q8wpo:
goto N7bT_;
VL3Fg:
ttwRp:
goto iySqM;
ZQM4w:
Be96E:
goto ANXI1;
X5xso:
message("活动设置成功！", $this->createWebUrl("votelist", array("name" => "silence_vote", "rid" => $rid)), "success");
goto J_93B;
In_xF:
if (!($_GPC["op"] == "whichfm")) {
    goto zBHhV;
}
goto d8cJs;
P5cfj:
$this->savedata($instdata);
goto zQXh_;
nFbnD:
$reply = pdo_fetch("SELECT * FROM " . tablename($this->tablereply) . " WHERE rid = :rid ORDER BY `id` DESC", array(":rid" => $rid));
goto qLNwa;
xFJ4n:
$audiodesc = json_encode($_GPC["audiodesc"]);
goto syh9f;
T1IM1:
$result = json_decode($content["content"], true);
goto VuVRg;
PY8O2:
echo json_encode(array("code" => 200, "msg" => "设置成功"));
goto AdUDT;
EkSMo:
$audioarr = array();
goto d1Xtd;
ff1nb:
$audioarr = json_decode($votedata["audioarr"], true);
goto Qq0yz;
K1dOP:
$votetotal = pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename($this->tablevotedata) . " WHERE   rid = :rid   AND tid = :tid ", array(":rid" => $rid, ":tid" => $id));
goto DVCpb;
mhO4R:
include $this->template("edit");