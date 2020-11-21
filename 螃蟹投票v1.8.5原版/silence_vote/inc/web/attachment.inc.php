<?php

goto EcC5j;
lqPw2:
NYMJL:
goto pNU8U;
emib4:
message("请添加支持的图片附件后缀类型");
goto vMtrm;
xlaP_:
rLnxl:
goto Cu205;
sxF2a:
$message = $auth["message"]["error"] == "bad token" ? "Accesskey或Secretkey填写错误， 请检查后重新提交" : "bucket填写错误或是bucket所对应的存储区域选择错误，请检查后重新提交";
goto ubHYr;
mMc5W:
kSQ4V:
goto V63QQ;
UrM9c:
message("OSS-Access Key ID 或 OSS-Access Key Secret错误，请重新填写");
goto mMc5W;
Vuv3o:
message("请填写APPID", referer(), "info");
goto CYwOW;
vAhr5:
if ($remote["type"] == ATTACH_FTP) {
    goto Ns6HW;
}
goto xSlvB;
WJ7FQ:
if (!empty($remote["cos"]["secretkey"])) {
    goto ox1gl;
}
goto XayjN;
aRCIS:
if (!(strexists($remote["cos"]["url"], ".cos.myqcloud.com") && !strexists($url, "//" . $remote["cos"]["bucket"] . "-"))) {
    goto mQwjt;
}
goto tIHI7;
iYlki:
if (!empty($buckets[$remote["alioss"]["bucket"]])) {
    goto iZH6x;
}
goto ClGQv;
yQit4:
$remote["qiniu"]["url"] = strexists($remote["qiniu"]["url"], "http") ? trim($remote["qiniu"]["url"], "/") : "http://" . trim($remote["qiniu"]["url"], "/");
goto bcalY;
JIwfu:
CLq0o:
goto T4oew;
L4_QI:
inbvB:
goto LN7t7;
B8HuJ:
if ($remote["type"] == ATTACH_OSS) {
    goto e2_nf;
}
goto vAhr5;
hz9gI:
if (!empty($remote["qiniu"]["bucket"])) {
    goto blgah;
}
goto HMAO4;
ND59a:
ev1Lo:
goto Kv83H;
KX_Ou:
if (!is_error($auth)) {
    goto PmhOq;
}
goto wWYU6;
P1hxh:
foreach ($buckets as $key => $value) {
    goto NG8WB;
    NG8WB:
    $value["loca_name"] = $key . "@@" . $bucket_datacenter[$value["location"]];
    goto XT_Es;
    bfb58:
    OoDci:
    goto Qze6f;
    XT_Es:
    $bucket[] = $value;
    goto bfb58;
    Qze6f:
}
goto YFPDS;
HK1O2:
message("FTP密码为必填项.");
goto ND59a;
CYwOW:
x4m3e:
goto szA9c;
SlwfX:
if (!empty($remote["qiniu"]["secretkey"])) {
    goto wigyL;
}
goto kJjDP;
tMkac:
if (empty($_GPC["custom"]["url"])) {
    goto G1RmN;
}
goto uAyEO;
PfYYE:
$upload["image"]["width"] = intval(trim($upload["image"]["width"]));
goto AQ9mi;
EcC5j:
defined("IN_IA") or exit("Access Denied");
goto CMKc6;
qdGBM:
G1RmN:
goto ZxWar;
pcHU4:
TVaO0:
goto zV9Jh;
q0uLv:
$buckets = attachment_alioss_buctkets($key, $secret);
goto syQlc;
FKHQ0:
mPmdy:
goto u3X1A;
qh5hg:
$url = "http://" . $url;
goto lqPw2;
oJrBH:
Mp6Je:
goto N3iSv;
LN7t7:
message("请填写url", referer(), "info");
goto me16n;
ev3yF:
$upload["audio"]["extentions"] = explode("\n", $upload["audio"]["extentions"]);
goto Fohdl;
M993L:
if (!empty($remote["ftp"]["password"])) {
    goto ev1Lo;
}
goto HK1O2;
tIHI7:
$remote["cos"]["url"] = "http://" . $remote["cos"]["bucket"] . "-" . $remote["cos"]["appid"] . ".cos.myqcloud.com";
goto BjvkY;
riuVN:
load()->model("setting");
goto jca5a;
YuPUI:
if (empty($remote["cos"]["url"])) {
    goto S0jU3;
}
goto aRCIS;
Nu4R5:
$secret = $_GPC["secret"];
goto q0uLv;
eunmo:
if (!(!empty($remote["alioss"]["key"]) && !empty($remote["alioss"]["secret"]))) {
    goto rLnxl;
}
goto L3GW_;
vOHRL:
if (!(!strexists($url, "http://") && !strexists($url, "https://"))) {
    goto NYMJL;
}
goto qh5hg;
L7kwH:
if (empty($upload["audio"]["extentions"])) {
    goto RBSnQ;
}
goto ev3yF;
NXjY_:
$remote["alioss"]["url"] = "http://" . $remote["alioss"]["bucket"] . "." . $buckets[$remote["alioss"]["bucket"]]["location"] . ".aliyuncs.com";
goto Ad90Z;
syQlc:
if (!is_error($buckets)) {
    goto ode2Z;
}
goto vSr6A;
Q69eh:
message("请设置音频视频上传支持的文件大小, 单位 KB.");
goto C_zAN;
C_zAN:
SL3Kd:
goto L7kwH;
szA9c:
if (!empty($remote["cos"]["secretid"])) {
    goto gQuwW;
}
goto sBuV5;
wWYU6:
message($auth["message"], referer(), "info");
goto iQoYZ;
KhDDZ:
qogra:
goto lvCVW;
lis8O:
$remote["cos"]["url"] = "http://" . $remote["cos"]["bucket"] . "-" . $remote["cos"]["appid"] . ".cos.myqcloud.com";
goto XQ1aw;
zjVLu:
if (!empty($remote["ftp"]["host"])) {
    goto qogra;
}
goto C1mAp;
neU_9:
$upload_max_filesize = ini_get("upload_max_filesize");
goto uU7et;
M1dz1:
goto TVaO0;
goto E1Uz7;
N3iSv:
RBSnQ:
goto V0jEF;
uU7et:
$upload = empty($_W["setting"]["upload"]) ? $_W["config"]["upload"] : $_W["setting"]["upload"];
goto Tp2S3;
Jtlay:
$do = in_array($do, $dos) ? $do : "global";
goto riuVN;
AQ9mi:
if (!(!empty($upload["image"]["thumb"]) && empty($upload["image"]["width"]))) {
    goto d8fpE;
}
goto cBTZR;
R9Y8t:
message("请填写Accesskey", referer(), "info");
goto ZWA8k;
zjlLL:
xloxd:
goto M1dz1;
pNU8U:
$remote["alioss"]["url"] = $url;
goto qdGBM;
V63QQ:
list($remote["alioss"]["bucket"], $remote["alioss"]["url"]) = explode("@@", $_GPC["alioss"]["bucket"]);
goto iYlki;
UTZFo:
iZH6x:
goto NXjY_;
sH41c:
vh39S:
goto lIjfh;
ZmgWU:
$harmtype = array("asp", "php", "jsp", "js", "css", "php3", "php4", "php5", "ashx", "aspx", "exe", "cgi");
goto T7BXY;
ekw7q:
ZnxAT:
goto ZUplh;
FFQcQ:
if (empty($upload["image"]["extentions"])) {
    goto mPmdy;
}
goto QKX50;
W1KZZ:
goto izGLu;
goto Al8CR;
rkXLr:
if (!(!empty($upload["image"]["extentions"]) && is_array($upload["image"]["extentions"]))) {
    goto CLq0o;
}
goto vZS8J;
YGUb9:
message(error(1, $bucket), '', "ajax");
goto busbA;
Ad90Z:
$remote["alioss"]["ossurl"] = $buckets[$remote["alioss"]["bucket"]]["location"] . ".aliyuncs.com";
goto tMkac;
ZUplh:
setting_save($upload, "upload");
goto q6GhM;
R8OGB:
$remote = $_W["setting"]["remote"];
goto eunmo;
JR0G2:
$bucket_datacenter = array("oss-cn-hangzhou" => "杭州数据中心", "oss-cn-qingdao" => "青岛数据中心", "oss-cn-beijing" => "北京数据中心", "oss-cn-hongkong" => "香港数据中心", "oss-cn-shenzhen" => "深圳数据中心", "oss-cn-shanghai" => "上海数据中心", "oss-us-west-1" => "美国硅谷数据中心");
goto KwHPV;
Ctjze:
message("请设置图片上传支持的文件大小, 单位 KB.");
goto OukDC;
EzkFa:
message("阿里云OSS-Access Key ID不能为空");
goto s9kX4;
ulEsT:
S0jU3:
goto lis8O;
ymzr8:
blgah:
goto Qs_1W;
Auyu9:
if (!empty($remote["qiniu"]["accesskey"])) {
    goto kT1Pr;
}
goto R9Y8t;
lvCVW:
if (!empty($remote["ftp"]["username"])) {
    goto LQf8V;
}
goto RGplf;
RGplf:
message("FTP帐号为必填项.");
goto rlsEJ;
beUKi:
$upload["audio"]["extentions"] = implode("\n", $upload["audio"]["extentions"]);
goto pMo6y;
yFkty:
e2_nf:
goto dkh0P;
df_H3:
TmshR:
goto Auyu9;
Cu205:
$bucket_datacenter = array("oss-cn-hangzhou" => "杭州数据中心", "oss-cn-qingdao" => "青岛数据中心", "oss-cn-beijing" => "北京数据中心", "oss-cn-hongkong" => "香港数据中心", "oss-cn-shenzhen" => "深圳数据中心", "oss-cn-shanghai" => "上海数据中心", "oss-us-west-1" => "美国硅谷数据中心");
goto g8foq;
vbxBw:
X1FJZ:
goto cgExL;
MrqVZ:
d9Pms:
goto JioJP;
bbSEm:
goto izGLu;
goto sH41c;
dfytL:
if (!empty($remote["cos"]["appid"])) {
    goto x4m3e;
}
goto Vuv3o;
zV9Jh:
setting_save($remote, "remote");
goto KoMFq;
MIK8O:
goto TVaO0;
goto yFkty;
OukDC:
a1q6L:
goto paZqD;
Al8CR:
Te83l:
goto aqunM;
KoMFq:
message("远程附件配置信息更新成功！", url("system/attachment/remote"));
goto HnkwS;
Fohdl:
foreach ($upload["audio"]["extentions"] as $key => &$row) {
    goto oBIAj;
    oBIAj:
    $row = trim($row);
    goto Y17wK;
    Y17wK:
    if (!in_array($row, $harmtype)) {
        goto WPxnK;
    }
    goto CIFRe;
    CIFRe:
    unset($upload["audio"]["extentions"][$key]);
    goto sL1U0;
    sL1U0:
    goto JXRv8;
    goto BmDHG;
    QDTZw:
    JXRv8:
    goto kD46o;
    BmDHG:
    WPxnK:
    goto QDTZw;
    kD46o:
}
goto oJrBH;
XQ1aw:
HVTad:
goto ZrI4d;
vSr6A:
message(error(-1), '', "ajax");
goto b6orl;
ClGQv:
message("Bucket不存在或是已经被删除");
goto UTZFo;
ZxWar:
goto TVaO0;
goto oawTA;
CFdGH:
ox1gl:
goto ZmpGv;
kjesH:
$upload["image"]["width"] = intval($upload["image"]["width"]);
goto lTne_;
cBTZR:
message("请设置图片缩略宽度.");
goto BpFpH;
OdyFQ:
ADh7n:
goto YuPUI;
JioJP:
$buckets = attachment_alioss_buctkets($remote["alioss"]["key"], $remote["alioss"]["secret"]);
goto eto6V;
oawTA:
Ns6HW:
goto zjVLu;
T4oew:
if (!(!empty($upload["audio"]["extentions"]) && is_array($upload["audio"]["extentions"]))) {
    goto rUS1d;
}
goto beUKi;
KwHPV:
$bucket = array();
goto P1hxh;
XayjN:
message("请填写SECRETKEY", referer(), "info");
goto CFdGH;
sBuV5:
message("请填写SECRETID", referer(), "info");
goto Xzy9p;
KiKu2:
$upload["image"]["thumb"] = !empty($upload["image"]["thumb"]) ? 1 : 0;
goto PfYYE;
kpT8f:
$auth = attachment_qiniu_auth($remote["qiniu"]["accesskey"], $remote["qiniu"]["secretkey"], $remote["qiniu"]["bucket"], $remote["qiniu"]["district"]);
goto wbvmJ;
Tp2S3:
$upload["image"]["thumb"] = empty($upload["image"]["thumb"]) ? 0 : 1;
goto kjesH;
BpFpH:
d8fpE:
goto HHcAn;
pt3cR:
if (!empty($upload["image"]["limit"])) {
    goto SL3Kd;
}
goto Q69eh;
ZmpGv:
if (!empty($remote["cos"]["bucket"])) {
    goto ADh7n;
}
goto Jbzpd;
vgSuK:
$upload["audio"]["limit"] = max(0, intval(trim($upload["audio"]["limit"])));
goto pt3cR;
Kv83H:
goto TVaO0;
goto df_H3;
paZqD:
if (!empty($upload["image"]["extentions"])) {
    goto hXqNM;
}
goto W28Dm;
ChU0w:
$remote["cos"]["url"] = strexists($remote["cos"]["url"], "http") ? trim($remote["cos"]["url"], "/") : "http://" . trim($remote["cos"]["url"], "/");
goto qRYfP;
hwBP6:
if ($do == "global") {
    goto vh39S;
}
goto NUhh3;
pMo6y:
rUS1d:
goto W1KZZ;
L3GW_:
$buckets = attachment_alioss_buctkets($remote["alioss"]["key"], $remote["alioss"]["secret"]);
goto xlaP_;
HMAO4:
message("请填写bucket", referer(), "info");
goto ymzr8;
chtgk:
if ($do == "buckets") {
    goto qis9G;
}
goto bbSEm;
A4Iox:
IFt3h:
goto FKHQ0;
s9kX4:
m6G_k:
goto SEYm7;
vMtrm:
mx0KT:
goto vgSuK;
ubHYr:
message($message, referer(), "info");
goto zjlLL;
SEYm7:
if (!(trim($remote["alioss"]["secret"]) == '')) {
    goto d9Pms;
}
goto OaB8t;
CMKc6:
$_W["page"]["title"] = "全局设置 - 附件设置 - 系统管理";
goto wmmpm;
V0jEF:
if (!(!is_array($upload["audio"]["extentions"]) || count($upload["audio"]["extentions"]) < 1)) {
    goto ZnxAT;
}
goto lHqDe;
Xzy9p:
gQuwW:
goto WJ7FQ;
IlolY:
$remote = array("type" => intval($_GPC["type"]), "ftp" => array("ssl" => intval($_GPC["ftp"]["ssl"]), "host" => $_GPC["ftp"]["host"], "port" => $_GPC["ftp"]["port"], "username" => $_GPC["ftp"]["username"], "password" => strexists($_GPC["ftp"]["password"], "*") ? $_W["setting"]["remote"]["ftp"]["password"] : $_GPC["ftp"]["password"], "pasv" => intval($_GPC["ftp"]["pasv"]), "dir" => $_GPC["ftp"]["dir"], "url" => $_GPC["ftp"]["url"], "overtime" => intval($_GPC["ftp"]["overtime"])), "alioss" => array("key" => $_GPC["alioss"]["key"], "secret" => strexists($_GPC["alioss"]["secret"], "*") ? $_W["setting"]["remote"]["alioss"]["secret"] : $_GPC["alioss"]["secret"], "bucket" => $_GPC["alioss"]["bucket"]), "qiniu" => array("accesskey" => trim($_GPC["qiniu"]["accesskey"]), "secretkey" => strexists($_GPC["qiniu"]["secretkey"], "*") ? $_W["setting"]["remote"]["qiniu"]["secretkey"] : trim($_GPC["qiniu"]["secretkey"]), "bucket" => trim($_GPC["qiniu"]["bucket"]), "district" => intval($_GPC["qiniu"]["district"]), "url" => trim($_GPC["qiniu"]["url"])), "cos" => array("appid" => trim($_GPC["cos"]["appid"]), "secretid" => trim($_GPC["cos"]["secretid"]), "secretkey" => strexists(trim($_GPC["cos"]["secretkey"]), "*") ? $_W["setting"]["remote"]["cos"]["secretkey"] : trim($_GPC["cos"]["secretkey"]), "bucket" => trim($_GPC["cos"]["bucket"]), "url" => trim($_GPC["cos"]["url"])));
goto B8HuJ;
dkh0P:
if (!(trim($remote["alioss"]["key"]) == '')) {
    goto m6G_k;
}
goto EzkFa;
uAyEO:
$url = trim($_GPC["custom"]["url"], "/");
goto vOHRL;
lIjfh:
if (!checksubmit("submit")) {
    goto X1FJZ;
}
goto ZmgWU;
jca5a:
load()->model("attachment");
goto hwBP6;
eto6V:
if (!is_error($buckets)) {
    goto kSQ4V;
}
goto UrM9c;
cgExL:
$post_max_size = ini_get("post_max_size");
goto neU_9;
u3X1A:
if (!(!is_array($upload["image"]["extentions"]) || count($upload["image"]["extentions"]) < 1)) {
    goto mx0KT;
}
goto emib4;
HUEwk:
foreach ($upload["image"]["extentions"] as $key => &$row) {
    goto MPCr0;
    MPCr0:
    $row = trim($row);
    goto Dadvk;
    MXlmz:
    goto UfN3R;
    goto L9gv0;
    Dadvk:
    if (!in_array($row, $harmtype)) {
        goto Ppk3s;
    }
    goto cyRho;
    L9gv0:
    Ppk3s:
    goto I0Guf;
    cyRho:
    unset($upload["image"]["extentions"][$key]);
    goto MXlmz;
    I0Guf:
    UfN3R:
    goto qlP_r;
    qlP_r:
}
goto A4Iox;
ekxg5:
$key = $_GPC["key"];
goto Nu4R5;
Hwrkw:
qis9G:
goto ekxg5;
iFZk4:
if (!empty($upload["image"]["limit"])) {
    goto a1q6L;
}
goto Ctjze;
iQoYZ:
PmhOq:
goto pcHU4;
E1Uz7:
x2sQj:
goto dfytL;
wbvmJ:
if (!is_error($auth)) {
    goto xloxd;
}
goto sxF2a;
g8foq:
goto izGLu;
goto Hwrkw;
lTne_:
if (!empty($upload["image"]["width"])) {
    goto JJRTZ;
}
goto QQoVE;
wmmpm:
$dos = array("attachment", "remote", "buckets");
goto Jtlay;
W28Dm:
message("请添加支持的图片附件后缀类型");
goto UnJLe;
Qs_1W:
if (empty($remote["qiniu"]["url"])) {
    goto inbvB;
}
goto yQit4;
b6orl:
ode2Z:
goto JR0G2;
rlsEJ:
LQf8V:
goto M993L;
HnkwS:
ZxA84:
goto R8OGB;
ZrI4d:
$auth = attachment_cos_auth($remote["cos"]["bucket"], $remote["cos"]["appid"], $remote["cos"]["secretid"], $remote["cos"]["secretkey"]);
goto KX_Ou;
vZS8J:
$upload["image"]["extentions"] = implode("\n", $upload["image"]["extentions"]);
goto JIwfu;
T7BXY:
$upload = $_GPC["upload"];
goto KiKu2;
aqunM:
if (!checksubmit("submit")) {
    goto ZxA84;
}
goto IlolY;
kJjDP:
message("secretkey", referer(), "info");
goto Ld6I0;
busbA:
izGLu:
goto pQcyY;
QQoVE:
$upload["image"]["width"] = 800;
goto WBrs_;
UnJLe:
hXqNM:
goto FFQcQ;
Jbzpd:
message("请填写BUCKET", referer(), "info");
goto OdyFQ;
xSlvB:
if ($remote["type"] == ATTACH_QINIU) {
    goto TmshR;
}
goto iiAcV;
Ld6I0:
wigyL:
goto hz9gI;
me16n:
uQIkE:
goto kpT8f;
WBrs_:
JJRTZ:
goto rkXLr;
bcalY:
goto uQIkE;
goto L4_QI;
YFPDS:
VVdL9:
goto YGUb9;
q6GhM:
message("更新设置成功！", url("system/attachment"));
goto vbxBw;
C1mAp:
message("FTP服务器地址为必填项.");
goto KhDDZ;
BjvkY:
mQwjt:
goto ChU0w;
iiAcV:
if ($remote["type"] == ATTACH_COS) {
    goto x2sQj;
}
goto MIK8O;
lHqDe:
message("请添加支持的音频视频附件后缀类型");
goto ekw7q;
OaB8t:
message("阿里云OSS-Access Key Secret不能为空");
goto MrqVZ;
HHcAn:
$upload["image"]["limit"] = max(0, intval(trim($upload["image"]["limit"])));
goto iFZk4;
ZWA8k:
kT1Pr:
goto SlwfX;
QKX50:
$upload["image"]["extentions"] = explode("\n", $upload["image"]["extentions"]);
goto HUEwk;
NUhh3:
if ($do == "remote") {
    goto Te83l;
}
goto chtgk;
qRYfP:
goto HVTad;
goto ulEsT;
pQcyY:
include $this->template("attachment");