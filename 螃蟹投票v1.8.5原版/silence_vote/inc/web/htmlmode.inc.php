<?php

goto V6sY_;
wbODg:
bEven:
goto BK33Z;
uonxg:
if ($result["sta"] == 201) {
    goto DJHVT;
}
goto iENXA;
Vk10j:
$path16 = MODULE_ROOT . "/template/static/toupiao_sou" . "/mode{$modeid}/mui1.css";
goto ABbap;
pPhq5:
ksort($post_data);
goto W2Lnf;
W2Lnf:
$post_data["token"] = md5(sha1(implode('', $post_data)));
goto R254L;
amiuf:
$path2 = MODULE_ROOT . "/template/mobile" . "/mode{$modeid}/{$prefix}_index.html";
goto sb3WZ;
AeNPu:
$a = "path" . $i;
goto xnNgY;
RPMSw:
pdo_update($this->modulename . "_reply", array("htmlmode" => $html_id), array("rid" => $rid, "uniacid" => $uniacid));
goto xQ700;
XSCmL:
$cfg = $this->module["config"];
goto sRXOo;
tJJq8:
mkdirs(MODULE_ROOT . "/template/static/toupiao_sou" . "/mode{$modeid}");
goto bUgfA;
SSq1B:
YtWgt:
goto w3M6O;
OqZ3q:
ubJeV:
goto wbODg;
bUgfA:
$path1 = MODULE_ROOT . "/template/mobile" . "/mode{$modeid}/{$prefix}_giftranking.html";
goto amiuf;
TqXTD:
$path7 = MODULE_ROOT . "/template/mobile" . "/mode{$modeid}/{$prefix}_view.html";
goto u_S0R;
vVHXV:
load()->func("communication");
goto w_xLE;
Ut_Su:
qRkGm:
goto qVZD5;
xQ700:
message("主题取消成功", referer(), "success");
goto Py8LO;
S05Gb:
if ($result["sta"] == 200) {
    goto odFvB;
}
goto uonxg;
JkG2G:
load()->func("communication");
goto Uzvqd;
ZjRG2:
$url = $this->auth_url . "/index/votehtml/getHtmlMode";
goto JkG2G;
wOxH_:
$path12 = MODULE_ROOT . "/template/static/toupiao_sou" . "/mode{$modeid}/ranking_list.css";
goto RqQFg;
MSiCK:
global $_W, $_GPC;
goto hc_LH;
VP7FR:
$new_version = $result["version"];
goto dbdK0;
tQ51b:
$versiondata = array();
goto kJ_Cu;
b2my5:
message("模板文件已存在且无需更新 mode" . $html_id . "版本号" . $version, referer(), "success");
goto qrUn8;
kXoxy:
$content = ihttp_post($url, $data);
goto totZK;
HFL0I:
mkdirs(MODULE_ROOT . "/template/mobile" . "/mode{$modeid}");
goto tJJq8;
xaLNd:
$versiondata = json_encode($versiondata);
goto HHkVt;
uCwtL:
$path9 = MODULE_ROOT . "/template/static/toupiao_sou" . "/mode{$modeid}/index.css";
goto p5k9Y;
ZNZI3:
$path10 = MODULE_ROOT . "/template/static/toupiao_sou" . "/mode{$modeid}/join.css";
goto ss3gj;
hPNhS:
$post_data["version"] = $version;
goto WYXMl;
cP5aA:
//message("授权错误，请联系客服！", "referer", "error");
goto gyr2a;
yUkCj:
$content = ihttp_post($url, $post_data);
goto LH651;
O1ye3:
foreach ($result as $key => $value) {
    goto nLn9C;
    mW3Pl:
    TNdaM:
    goto P10n_;
    nLn9C:
    if ($value["upinfo"] == 2) {
        goto TNdaM;
    }
    goto XsaAu;
    HCf_e:
    goto l7Utg;
    goto Db2f7;
    UxEr0:
    l7Utg:
    goto kW0iT;
    UcgwR:
    $result[$key]["isdown"] = "有更新";
    goto UxEr0;
    XsaAu:
    if ($value["upinfo"] == 1) {
        goto fYYIR;
    }
    goto p55Jn;
    bBk7G:
    goto l7Utg;
    goto mW3Pl;
    kW0iT:
    c_fqb:
    goto VxYuZ;
    p55Jn:
    $result[$key]["isdown"] = "未下载";
    goto bBk7G;
    Db2f7:
    fYYIR:
    goto UcgwR;
    P10n_:
    $result[$key]["isdown"] = "已下载";
    goto HCf_e;
    VxYuZ:
}
goto pEOTb;
YPs7p:
$post_data = array("time" => time(), "ticket" => $cfg["ticket"], "html_id" => $html_id);
goto pPhq5;
q8sD1:
goto b8S8z;
goto ArVmk;
w3M6O:
$data["ver"] = $versiondata;
goto kXoxy;
JX8nH:
$path8 = MODULE_ROOT . "/template/static/toupiao_sou" . "/mode{$modeid}/gift.css";
goto uCwtL;
KoBaO:
$versiondata = json_decode(file_get_contents($version_path), true);
goto iJ03k;
BK33Z:
load()->func("tpl");
goto pIKrW;
RqQFg:
$path13 = MODULE_ROOT . "/template/static/toupiao_sou" . "/mode{$modeid}/poster.css";
goto m98mU;
SP2Af:
$path13 = MODULE_ROOT . "/template/static/toupiao_sou" . "/mode{$modeid}/ranking_list.css";
goto CBRcp;
u_S0R:
if ($modeid == 3) {
    goto yF82F;
}
goto vihtB;
tMtaW:
goto Ez7jP;
goto TrizN;
WPVTk:
$count = count($result["filedata"]);
goto dnupN;
Iq8yN:
$path15 = MODULE_ROOT . "/template/static/toupiao_sou" . "/mode{$modeid}/iconfont1.css";
goto Vk10j;
IpaY5:
GJwje:
goto wHo9c;
KeDMp:
$path9 = MODULE_ROOT . "/template/static/toupiao_sou" . "/mode{$modeid}/index.css";
goto ZNZI3;
TrizN:
DJHVT:
goto b2my5;
YHOMH:
$versiondata = json_decode(file_get_contents($version_path), true);
goto j4Fgd;
Uzvqd:
$version_path = MODULE_ROOT . "/version_html.txt";
goto tQ51b;
xnNgY:
file_put_contents(${$a}, $result["filedata"][$i]);
goto IpaY5;
Q1Wrb:
if ($operation == "display") {
    goto l3cdh;
}
goto dg7Fu;
RO2nD:
$version = array();
goto afTGh;
iJ03k:
$version = $versiondata["mode" . $html_id] ?: 0;
goto E_JNO;
afTGh:
goto YtWgt;
goto zK4uJ;
Oueps:
goto qVhBF;
goto AH1mk;
YUxFY:
$url = $this->auth_url . "/index/votehtml/getHtml";
goto YPs7p;
gMYcW:
$path18 = MODULE_ROOT . "/template/static/toupiao_sou" . "/mode{$modeid}/toupiao1.css";
goto d82g2;
JVCaJ:
$result = json_decode($content["content"], true);
goto zt1ww;
p8fQD:
odFvB:
goto VP7FR;
IKBC7:
$cfg = $this->module["config"];
goto YUxFY;
sRXOo:
$url = $this->auth_url . "/index/vote/checkauth";
goto SiuYl;
ArVmk:
l3cdh:
goto ZjRG2;
IVaqb:
goto nQg1g;
goto u3GsC;
wHo9c:
$i++;
goto GQ7Bs;
qVZD5:
message("模板文件下载成功", referer(), "success");
goto sdlj4;
B9yEH:
goto o1yuF;
goto p8fQD;
V6sY_:
defined("IN_IA") or exit("Access Denied");
goto MSiCK;
JwAnf:
$operation = !empty($_GPC["op"]) ? $_GPC["op"] : "display";
goto qZFnF;
zu_ts:
$prefix = $result["prefix"];
goto eM0um;
qYKrF:
nQg1g:
goto WPVTk;
uFdOF:
l9yky:
goto VRz9k;
AH1mk:
B5ajZ:
goto KoBaO;
zK4uJ:
znXL9:
goto YHOMH;
hc_LH:
checklogin();
goto XSCmL;
sb3WZ:
$path3 = MODULE_ROOT . "/template/mobile" . "/mode{$modeid}/{$prefix}_join.html";
goto x5ZJK;
WYXMl:
load()->func("communication");
goto yUkCj;
p5k9Y:
$path10 = MODULE_ROOT . "/template/static/toupiao_sou" . "/mode{$modeid}/join.css";
goto mbrgt;
BHtIA:
$path12 = MODULE_ROOT . "/template/static/toupiao_sou" . "/mode{$modeid}/poster.css";
goto SP2Af;
w_xLE:
$content = ihttp_post($url, $post_data);
goto JVCaJ;
zt1ww:
if ($result["sta"]) {
    goto ubJeV;
}
goto cP5aA;
CBRcp:
$path14 = MODULE_ROOT . "/template/static/toupiao_sou" . "/mode{$modeid}/toupiao.css";
goto IVaqb;
MQVeH:
$path5 = MODULE_ROOT . "/template/mobile" . "/mode{$modeid}/{$prefix}_poster.html";
goto xD5rV;
mbrgt:
$path11 = MODULE_ROOT . "/template/static/toupiao_sou" . "/mode{$modeid}/List.css";
goto wOxH_;
ty53X:
exit;
goto eVe99;
GQ7Bs:
goto x2czs;
goto Ut_Su;
HPrVJ:
$version = 0;
goto Oueps;
HHkVt:
$a = file_put_contents(MODULE_ROOT . "/version_html.txt", $versiondata);
goto zu_ts;
VRz9k:
$html_id = $_GPC["html_id"];
goto mTwrl;
dbdK0:
$versiondata["mode" . $html_id] = $new_version;
goto xaLNd;
eM0um:
$modeid = $html_id;
goto HFL0I;
E_JNO:
qVhBF:
goto hPNhS;
YahFf:
$post_data["token"] = md5(sha1(implode('', $post_data)));
goto vVHXV;
x5ZJK:
$path4 = MODULE_ROOT . "/template/mobile" . "/mode{$modeid}/{$prefix}_payvote.html";
goto MQVeH;
dnupN:
$i = 1;
goto nMNtZ;
dg7Fu:
if ($operation == "fetchfile") {
    goto l9yky;
}
goto q8sD1;
j4Fgd:
$version = $versiondata;
goto SSq1B;
vihtB:
$path8 = MODULE_ROOT . "/template/static/toupiao_sou" . "/mode{$modeid}/gift.css";
goto KeDMp;
e1uOX:
ksort($post_data);
goto YahFf;
ss3gj:
$path11 = MODULE_ROOT . "/template/static/toupiao_sou" . "/mode{$modeid}/List.css";
goto BHtIA;
ABbap:
$path17 = MODULE_ROOT . "/template/static/toupiao_sou" . "/mode{$modeid}/reset1.css";
goto gMYcW;
xD5rV:
$path6 = MODULE_ROOT . "/template/mobile" . "/mode{$modeid}/{$prefix}_ranking.html";
goto TqXTD;
pEOTb:
RU9NC:
goto R3KSt;
eVe99:
goto b8S8z;
goto uFdOF;
R3KSt:
include $this->template("html_mode");
goto ty53X;
kJ_Cu:
if (is_file($version_path)) {
    goto znXL9;
}
goto RO2nD;
iENXA:
message($result["error"], referer(), "error");
goto tMtaW;
mTwrl:
if (!($html_id == 0)) {
    goto VSdzQ;
}
goto RPMSw;
O7Vpj:
if (!($i < $count + 1)) {
    goto qRkGm;
}
goto AeNPu;
m98mU:
$path14 = MODULE_ROOT . "/template/static/toupiao_sou" . "/mode{$modeid}/toupiao.css";
goto Iq8yN;
pIKrW:
$_W["page"]["title"] = "模板主题管理";
goto JwAnf;
gyr2a:
goto bEven;
goto OqZ3q;
ie5S3:
$versiondata = array();
goto u41By;
LH651:
$result = json_decode($content["content"], true);
goto S05Gb;
Py8LO:
VSdzQ:
goto IKBC7;
u41By:
if (is_file($version_path)) {
    goto B5ajZ;
}
goto HPrVJ;
sdlj4:
o1yuF:
goto tuuqg;
SiuYl:
$post_data = array("time" => time(), "ticket" => $cfg["ticket"], "module_id" => 3);
goto e1uOX;
d82g2:
$path19 = MODULE_ROOT . "/template/static/toupiao_sou" . "/mode{$modeid}/app.js";
goto qYKrF;
R254L:
$version_path = MODULE_ROOT . "/version_html.txt";
goto ie5S3;
qZFnF:
$uniacid = !empty($_W["uniacid"]) ? $_W["uniacid"] : intval($_GET["uniacid"]);
goto Q1Wrb;
totZK:
$result = json_decode($content["content"], true);
goto O1ye3;
u3GsC:
yF82F:
goto JX8nH;
nMNtZ:
x2czs:
goto O7Vpj;
qrUn8:
Ez7jP:
goto B9yEH;
tuuqg:
b8S8z: