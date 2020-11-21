<?php
goto PGBlk;
TemVr:
$temp_least = $activity["friend_cuteface_num"] - $count_cuteface_user;
goto Y6ZBA;
qkVwN:
$data["sta"] = 0;
goto bZt6d;
pW1yl:
w0Ilh:
goto Q_WCs;
DYCU6:
if (!($activity["status"] == 2)) {
    goto zEzVC;
}
goto jQLdQ;
CSMQw:
$data["error"] = "接口参数没配置";
goto PlEz1;
tzPkD:
$data["sta"] = 0;
goto Ukung;
ZfNss:
if ($cuteface) {
    goto PJGN3;
}
goto RDMn2;
AhGpw:
echo json_encode($data);
goto NF2FI;
SKjNQ:
if (!(!$tel || !preg_match("/^([0-9]{11})?\$/", $tel))) {
    goto M3tto;
}
goto b6sCM;
w_hu5:
exit(json_encode(array("sta" => 1, "msg" => "发送成功")));
goto whEmG;
FLN2Z:
rdFZx:
goto FFd7b;
EnfUJ:
$data["error"] = "商家信息不存在";
goto dPo8_;
OYvNZ:
$all_day = $activity["lipstick_num"];
goto v4vEp;
FB7lA:
if (!($user["is_white"] == 1)) {
    goto AgpLM;
}
goto Kmtq9;
ll0Zj:
exit;
goto MQAda;
PmO11:
$this->send_temp_ms(urldecode(json_encode($template)));
goto ukEWM;
fGNAY:
xGDbw:
goto Pw_5Q;
B3ddI:
if ($red_info["status"] == 1) {
    goto vl4mB;
}
goto Eqm8_;
UzYLV:
exit;
goto nP1Gs;
EartH:
exit;
goto eiloU;
nODih:
$data["invitation_content"] = "还差<span>" . ($activity["share_num"] - $invitation_user) . "</span>好友即可增加<span>" . $num_day_surplus . "次</span>";
goto p5GrJ;
xc2aV:
$time_type = $_GPC["time_type"] ? 1 : 0;
goto vtqkO;
Q9bI_:
fo30h:
goto GFsOh;
jDmTK:
if ($activity["pattern"] == 12) {
    goto zgFxu;
}
goto hC98e;
j24fQ:
goto wwmXi;
goto ANfWO;
nP1Gs:
M0nCS:
goto IjlXa;
sWaQx:
$where = " AND time>0";
goto shfSM;
PkZLi:
if ($op == "verification") {
     //lonedev
     if (empty($openid)) {
        $data["sta"] = 0;
        $data["error"] = "openid为空，配置错误或在非微信浏览器中打开";
        echo json_encode($data);
        exit;
    }
    $user = pdo_fetch("SELECT id,openid,realname,uniacid,is_check,aid,tel FROM " . tablename(TABLE_USER) . " WHERE openid = :openid AND aid= :aid", array(":openid" => $openid, ":aid" => $aid));
    if (empty($user) || $user["uniacid"] != $uniacid) {
        $data["sta"] = 0;
        $data["error"] = "参数错误" . $user["uniacid"];
        echo json_encode($data);
        exit;
    }
    if ($_SESSION["verification_send_time"] && time() - $_SESSION["verification_send_time"] < 60) {
        $data["sta"] = 0;
        $data["error"] = "请求太频繁，" . (time() - $_SESSION["verification_send_time"]) . "秒后再试";
        echo json_encode($data);
        exit;
    }
    $tel = trim($_GPC["tel"]);
    if (!$tel || !preg_match("/^([0-9]{11})?\$/", $tel)) {
        $data["sta"] = 0;
        $data["error"] = "手机号格式不对";
        echo json_encode($data);
        exit;
    }
    if ($tel == $user["tel"] && $user["is_check"] == 1) {
        $data["sta"] = 0;
        $data["error"] = "该手机已验证过了，直接保存吧";
        echo json_encode($data);
        exit;
    }
    if (empty($cfg["api"]["accesskeyid"]) || empty($cfg["api"]["accesskeysecret"]) || empty($cfg["api"]["templatecode"])) {
        $data["sta"] = 0;
        $data["error"] = "接口参数没配置";
        echo json_encode($data);
        exit;
    }
    $code = mt_rand(100000, 999999);
    $resp = $this->send_ali_sms(array("ali_appkey" => trim($cfg["api"]["accesskeyid"]), "ali_smssign" => $cfg["api"]["signname"], "ali_secretkey" => trim($cfg["api"]["accesskeysecret"]), "ali_smstemplate" => $cfg["api"]["templatecode"]), $tel, $code);
    if ($resp["Code"] != "OK") {
        exit(json_encode(array("sta" => 0, "error" => $resp["Message"] . "||" . $resp["Code"])));
    }
    $_SESSION["verification_code"] = $code;
    $_SESSION["verification_tel"] = $tel;
    $_SESSION["verification_send_time"] = time();
    exit(json_encode(array("sta" => 1, "msg" => "发送成功")));

    //goto HDcCV;
}
goto Ohe67;
NII0D:
$data["sta"] = 0;
goto wzYiw;
OJc0k:
echo json_encode($data);
goto YZx96;
fqLdb:
eucpJ:
goto Y0bjg;
qxfOq:
$data["sta"] = 0;
goto BKEQR;
ySejX:
if (!empty($user)) {
    goto Kc8Ao;
}
goto F5lr5;
NzzOI:
b83lo:
goto e_W81;
UwWEN:
$data["sta"] = 0;
goto EnfUJ;
eCWh4:
$html_res .= "<div class='crownli_img'>";
goto H1gS7;
j3Q9J:
if (!($cuteface_all[$x]["id"] == $max_cid)) {
    goto M08Jt;
}
goto gEJaT;
JrZ9i:
S7_pg:
goto PFqCY;
pd0jE:
if ($max_openid == $openid) {
    goto lTe1T;
}
goto F8tri;
wAoV4:
iiJpP:
goto wObqM;
BsriB:
if (!($invitation_user > 0)) {
    goto Q754n;
}
goto rRkBh;
aWdNr:
$cuteface_all = pdo_fetchall("SELECT id,openid,tid,image_thumb_url,mark,status FROM " . tablename(TABLE_CUTEFACE) . " WHERE tid = :tid ORDER BY id ASC", array(":tid" => $qrcode["id"]));
goto JE2MA;
e5I1M:
exit;
goto L6ioL;
LDaWn:
EYFb9:
goto yv97b;
dFzzJ:
$lipstick_num_surplus = $lipstick_num_surplus + $times_buy["times_buy"];
goto dWazk;
bDFFe:
goto GouJN;
goto nqn07;
jGHle:
$audio_res = json_decode($audio_res, true);
goto sN70U;
FKTCo:
$activity["entry_audio_text"] = str_replace("#最大金额#", $activity["end_money"], $activity["entry_audio_text"]);
goto kSj2U;
DsJxl:
$data["sta"] = 0;
goto injR3;
Ohe67:
if ($op == "get_red_status") {
    goto AJUJJ;
}
goto Z08yP;
j0LG0:
$data["sta"] = $invitation_times && $cuteface_num_day_surplus == $invitation_times ? 2 : 0;
goto dAOmR;
raRBT:
if (!($activity["buy_times"] == 1 && $activity["pattern"] == 11)) {
    goto IBvLS;
}
goto nSQya;
m95qM:
B79Cx:
goto fM_LH;
Qcak6:
$data["tips"] = '';
goto m903W;
re69j:
$data["error"] = "手机验证码已过期，请重新获取";
goto xY0JK;
ANfWO:
YhLbY:
goto qOEES;
hQ73R:
Ylmi9:
goto OyjCM;
CDVgT:
g6mcw:
goto Ku1Np;
nYqaD:
die;
goto MrT_C;
Q_WCs:
$qrcode = pdo_fetch("SELECT id FROM " . tablename(TABLE_QRCODE) . " WHERE aid = :aid AND uuid = :uuid", array(":aid" => $aid, ":uuid" => $uuid));
goto SIuzh;
BMDe2:
$tel = trim($_GPC["tel"]);
goto ZME_a;
mWG_x:
goto GSerG;
goto pe0v8;
kSj2U:
$activity["entry_audio_text"] = str_replace("#活动#", $activity["name"], $activity["entry_audio_text"]);
goto dL_4Q;
R5XwB:
$html_res .= "<div class='crownli_one'>";
goto Toozf;
a2aiM:
$data["sta"] = 0;
goto QFHml;
UGO8C:
$num_day = $activity["cuteface_num_day"];
goto uK_39;
BC0UD:
echo json_encode($data);
goto CliNU;
hdeuZ:
$path = tomedia($activity["music"]);
goto MpUYW;
aFfcY:
h7cpe:
goto mkhGo;
MMJdJ:
if ($qrcode && $qrcode["sharetime"] < 1) {
    goto uhHqe;
}
goto aTn3W;
HHLqo:
exit;
goto zdB2w;
OYlX_:
if (!empty($invitation_user)) {
    goto oPT3E;
}
goto h9KL3;
Cb752:
$uuid = addslashes(trim($_GPC["uuid"]));
goto YbE2n;
nxMX2:
if (!($times_buy_day["times_buy"] > 0)) {
    goto Ylmi9;
}
goto vfs_T;
AZOof:
$adinfo_red_before = $this->get_ads(1, $aid);
goto bOfq0;
mB0lv:
if (!$activity["entry_audio_text"]) {
    goto S9rEF;
}
goto TpKEU;
JDRfG:
$time_data = $this->time_tran($data_insert["time"]);
goto vMR8L;
JZvE3:
echo json_encode($data);
goto xxYPV;
tfzKH:
if (!($cfg["api"]["mid_check"] && $cfg["api"]["openid"])) {
    goto CF7pP;
}
goto iDe4w;
bZt6d:
$data["error"] = "openid为空，配置错误或在非微信浏览器中打开";
goto CrpJI;
L5aRp:
$html_res .= "您的颜值";
goto bhWXs;
U3YfM:
cro0D:
goto pVcCk;
gbn3O:
$lack_time = $starttime + $activity["countdown"] + $add_time - $reduce_time - $endtime;
goto Sc5ld;
NF2FI:
exit;
goto JYvfX;
dL_4Q:
$filename = $this->get_code();
goto xx17y;
aajpS:
UyjNE:
goto DkAXw;
u_UX5:
b3Lb7:
goto OsqFs;
GTb17:
$red_info = pdo_fetch("SELECT status,money,openid FROM " . tablename(TABLE_RED) . " WHERE tid = :tid", array(":tid" => $qrcode["id"]));
goto JRteb;
VD380:
YAE71:
goto Fd2Qm;
gEJaT:
$html_res .= "<div class='crown_first'>";
goto cdcQh;
AnlNe:
$html_res .= "</div>";
goto GGs0f;
cEdD7:
if ($openid != $red_info["openid"]) {
    goto He6BO;
}
goto Ld5Ah;
YoK9l:
$data["is_cuteface"] = 1;
goto I65Yb;
glIKY:
$uuid = addslashes(trim($_GPC["uuid"]));
goto ZtLjz;
DY0sn:
echo json_encode($data);
goto QiB0E;
Uo0rq:
$tel_openid = pdo_fetch("SELECT openid FROM " . tablename(TABLE_USER) . " WHERE tel = :tel AND aid=:aid", array(":tel" => $tel, ":aid" => $aid));
goto o9nf8;
izkA0:
$cuteface_num_day_surplus += $invitation_times;
goto j0LG0;
yv97b:
$data = array("realname" => addslashes(trim($_GPC["realname"])), "tel" => $tel, "comment" => addslashes(trim($_GPC["comment"])), "other_info" => addslashes(trim($_GPC["other_info"])));
goto JsNEr;
Ve27Q:
WKbj1:
goto UPypE;
vMR8L:
$lack_time_str = $this->time_tran($lack_time);
goto BdKtL;
A8FIN:
$qrcode = pdo_fetch("SELECT id,sharetime,openid,usetime FROM " . tablename(TABLE_QRCODE) . " WHERE aid = :aid AND uuid = :uuid", array(":aid" => $aid, ":uuid" => $uuid));
goto Rpaxy;
SdsnS:
$data["content"] = $html_res;
goto vsMav;
njKBA:
if (!(empty($_SESSION["verification_send_time"]) || time() - $_SESSION["verification_send_time"] > 60)) {
    goto R9f0L;
}
goto kRWZb;
e_yhI:
echo json_encode(array("sta" => 1));
goto eFQiK;
txg7h:
$qrcode = pdo_fetch("SELECT id,sharetime,openid,usetime FROM " . tablename(TABLE_QRCODE) . " WHERE aid = :aid AND uuid = :uuid", array(":aid" => $aid, ":uuid" => $uuid));
goto xPSIG;
sN70U:
S9rEF:
goto rEtpH;
Fsc7t:
$activity = pdo_fetch("SELECT id,pattern,cuteface_num_day,challenge_num,challenge_num_day,cuteface_num,share_num,share_open,add_one,friend_cuteface_num,lipstick_image,lipstick_level,lipstick_num_day,lipstick_num,buy_times FROM " . tablename(TABLE_ACTIVITY) . " WHERE id = :aid", array(":aid" => $aid));
goto X6PD2;
Nfbmd:
exit;
goto QRUV4;
EIq4i:
echo json_encode($data);
goto XPiNu;
AX6b2:
$path = "../addons/crad_qrcode_red/template/mobile/css/welcome1.mp3";
goto Irn_q;
AopGb:
Tx8Lr:
goto s1Zrr;
u5svm:
$uuid = addslashes(trim($_GPC["uuid"]));
goto nJIbb;
m903W:
if (!empty($cuteface)) {
    goto eucpJ;
}
goto hs8CQ;
ACvsv:
$max_cid = 0;
goto IiR23;
M8cK2:
$data["invitation_content"] = $game_tip_before;
goto jpESh;
yp2Is:
echo json_encode($data);
goto e5I1M;
J5Q1q:
$data["is_send_red"] = 2;
goto yNcW6;
jQIJt:
$data["error"] = "来路错误";
goto d69kR;
xx17y:
$audio_res = $this->get_audio($filename, $activity["per"], $activity["entry_audio_text"], true);
goto jGHle;
puNV9:
$data["error"] = "操作失败：规则错误";
goto J81OC;
C7p0h:
JqWS1:
goto XjUVV;
q0_58:
$html_res .= "</div><div class='crownli_two'>" . $cuteface_all[$x]["mark"] . "分</div>";
goto ZEsaA;
gRgWP:
goto sWrQ5;
goto Sg4vY;
u943a:
goto iufGN;
goto WuNMH;
ZSXXS:
xLKqP:
goto qFtlf;
e7Hsb:
echo json_encode($data);
goto PWYE9;
l_Pxo:
$audio_res = json_decode($audio_res, true);
goto VD380;
idcDn:
$activity = pdo_fetch("SELECT id,sid,name FROM " . tablename(TABLE_ACTIVITY) . " WHERE id = :aid", array(":aid" => $user["aid"]));
goto n1HZX;
mdkIu:
$data["sta"] = 0;
goto ttS5L;
eFQiK:
exit;
goto Kl49c;
eIO0e:
diYIF:
goto A8FIN;
rJX86:
$data["sta"] = 0;
goto NmmD9;
G1Z6l:
goto Btr4a;
goto GoIlo;
KvDd2:
$html_res .= "</div>";
goto kb_2t;
aTIuf:
goto Sb7y3;
nxr6h:
$data["sta"] = 1;
goto NHOyc;
s_PDk:
if (!($time_check == 1)) {
    goto oFMuv;
}
goto sWaQx;
dWazk:
XUbtJ:
goto KjEnh;
YHyem:
$data["sta"] = 0;
goto PW4NN;
I1Hjp:
goto pwSf2;
goto nOtT0;
Eqm8_:
$data["sta"] = 0;
goto BEFZZ;
N6YSF:
gsR9P:
goto K8Nwj;
kwC07:
$data["invitation_content"] = $cuteface_num_day_surplus > 0 ? "今日剩余<span>{$cuteface_num_day_surplus}次</span>" : '';
goto gE9jT;
RzYBE:
$data["is_send_red"] = 3;
goto WGABg;
GFsOh:
if (!($x <= $activity["friend_cuteface_num"])) {
    goto lc35C;
}
goto MSQPu;
cdcQh:
$html_res .= "<img src='../addons/crad_qrcode_red/template/mobile/img/crown.png' /></div>";
goto tbvEb;
Xquxr:
goto Hy3O6;
goto bVAEb;
FRLnT:
$_SESSION["verification_tel"] = $tel;
goto XZgNX;
J6Dh4:
goto zS23J;
goto cljpv;
rAGHB:
eLzXS:
goto K4CGz;
DlEgM:
$audio_url_before = tomedia($adinfo_red_before["music"]);
goto s9TEM;
K69B9:
$data["error"] = "该手机已验证过了，直接保存吧";
goto adkmx;
gdD5j:
$data["sta"] = 1;
goto UdcA6;
qOEES:
$data["is_send_red"] = 1;
goto wQ_My;
FRKsf:
b5yOI:
goto NfAkW;
iYfDo:
zgFxu:
goto txg7h;
mMNMy:
zS23J:
goto ZfNss;
bhWXs:
Hy3O6:
goto q0_58;
xBUFF:
$data["error"] = "openid为空，配置错误或在非微信浏览器中打开";
goto YMP76;
qXfFL:
$data_insert["comment"] = $comment;
goto oUQxb;
C3RAy:
B3IFO:
goto HMnBC;
anZLi:
$data["error"] = "数据错误";
goto UFsqp;
mw0Xt:
$data["error"] = "活动已关闭";
goto EIq4i;
q_t_w:
$resp = $this->send_ali_sms(array("ali_appkey" => trim($cfg["api"]["accesskeyid"]), "ali_smssign" => $cfg["api"]["signname"], "ali_secretkey" => trim($cfg["api"]["accesskeysecret"]), "ali_smstemplate" => $cfg["api"]["templatecode"]), $tel, $code);
goto NRhMI;
yZudP:
$user = pdo_fetch("SELECT nickname FROM " . tablename(TABLE_USER) . " WHERE openid = :openid AND aid= :aid", array(":openid" => $openid, ":aid" => $aid));
goto CxuPw;
dB21H:
exit(json_encode(array("sta" => 0, "error" => $resp["Message"] . "||" . $resp["Code"])));
goto X1pkV;
GoIlo:
OK2ri:
goto tKxB7;
q9WSy:
echo json_encode($data);
goto BmgtR;
tKxB7:
$invitation_times = $add_one * $activity["share_num"];
goto izkA0;
Vko8B:
$html_res .= $cuteface_all[$x]["nickname"];
goto Xquxr;
TMPan:
iufGN:
goto ow7Da;
fqxN8:
$data["sta"] = 0;
goto EJLG5;
mH6d9:
exit;
goto XiMI5;
d69kR:
echo json_encode($data);
goto FBhul;
gMkYY:
exit;
goto m95qM;
SIuzh:
$red_info = pdo_fetch("SELECT status FROM " . tablename(TABLE_RED) . " WHERE tid = :tid", array(":tid" => $qrcode["id"]));
goto B3ddI;
XVLvQ:
exit;
goto YZIk0;
zVk4b:
if ($activity["rules"]) {
    goto AsgrO;
}
goto c5eaF;
PV5N_:
$activity["red_audio_text"] = str_replace("#卡券#", $coupon_count_user, $activity["red_audio_text"]);
goto e2518;
JRsir:
M3tto:
goto Uo0rq;
M0NW8:
pdo_update(TABLE_QRCODE, array("sharetime" => time()), array("id" => $qrcode["id"]));
goto nxr6h;
TZ3sC:
R9f0L:
goto Acy6q;
zAyHX:
rAnvE:
goto DYCU6;
smYl8:
exit;
gD8Vr:
if (!(empty($aid) || empty($uuid))) {
    goto vYpfK;
}
goto tzPkD;
sTwpZ:
exit;
goto zAyHX;
cvtcI:
$uuid = addslashes(trim($_GPC["uuid"]));
goto xaPMK;
I0ZIO:
$max_temp = min(1, intval($lack_time / 10));
goto FusIx;
yLaBl:
if ($op == "share_time") {
    goto tCTuN;
}
goto Q35vu;
Ku1Np:
if (!($_SESSION["verification_send_time"] && time() - $_SESSION["verification_send_time"] < 60)) {
    goto Tq4Jo;
}
goto NII0D;
T28W3:
if ($qrcode["sharetime"]) {
    goto nmCC3;
}
goto Sq601;
Ld5Ah:
if (!$activity["red_audio_text"]) {
    goto YAE71;
}
goto j0Vbe;
cMTPh:
$qrcode = pdo_fetch("SELECT id,sharetime FROM " . tablename(TABLE_QRCODE) . " WHERE aid = :aid AND uuid = :uuid", array(":aid" => $aid, ":uuid" => $uuid));
goto MMJdJ;
jQLdQ:
$data["sta"] = 0;
goto bbYmX;
D5TnS:
Z2e3Y:
goto cMTPh;
jpESh:
echo json_encode($data);
goto Q1ZcC;
n983Z:
CUeQu:
goto OUrTO;
CdFH_:
$aid = intval($_GPC["aid"]);
goto rT6jn;
Hj9Af:
ZIok3:
goto uuzeu;
uLtbH:
echo json_encode($data);
goto nYqaD;
MkqXu:
global $_GPC, $_W;
goto MvD4W;
HF_Ad:
$_SESSION["verification_code"] = $code;
goto FRLnT;
ZEsaA:
$html_res .= "</div>";
goto KTEGX;
RDMn2:
$data["is_cuteface"] = 0;
goto CJzPK;
ESTSw:
$data["sta"] = 0;
goto C1JGU;
Suc7P:
exit;
goto D5TnS;
hUMU4:
echo json_encode($data);
goto heynO;
zuHyk:
$data["sta"] = $invitation_user_count ? 1 : 0;
goto KsweU;
Oyvcs:
$user = pdo_fetch("SELECT id,openid,realname,uniacid,is_white,aid FROM " . tablename(TABLE_USER) . " WHERE openid = :openid AND aid= :aid", array(":openid" => $openid, ":aid" => $aid));
goto cb8Ua;
QSbym:
$qrcode = pdo_fetch("SELECT id FROM " . tablename(TABLE_QRCODE) . " WHERE aid = :aid AND uuid = :uuid", array(":aid" => $aid, ":uuid" => $uuid));
goto HD9g2;
ViTzF:
$data["sta"] = 0;
goto UnfqJ;
mUZ2b:
$this->send_temp_ms(urldecode(json_encode($template)));
goto u_UX5;
uQMd7:
$data["error"] = "数据错误";
goto YQSGP;
YGARv:
$code = intval($_GPC["check_code"]);
goto njKBA;
wObqM:
$invitation_user = pdo_fetch("SELECT id,time,comment,nickname FROM " . tablename(TABLE_INVITATION_USER) . "WHERE tid=:tid AND openid=:openid ", array(":tid" => $qrcode["id"], ":openid" => $openid));
goto OYlX_;
EbDqC:
$data["error"] = "手机号格式不对";
goto q9WSy;
Zaiq0:
if ($op == "user_info") {
    goto eLzXS;
}
goto pedSY;
Zg3xl:
exit;
goto n8_qc;
An8Qc:
$data["sta"] = 0;
goto BC0UD;
xPSIG:
if (!($qrcode["sharetime"] < 1)) {
    goto GKQZk;
}
goto a2aiM;
d4ZtB:
$url = $_W["siteroot"] . "app/" . substr($this->createMobileUrl("index", array("aid" => $aid, "uuid" => $uuid), true), 2);
goto c8GAW;
E8A8_:
pdo_update(TABLE_USER, $data, array("id" => $user["id"]));
goto idcDn;
nRbxx:
exit;
goto wv_uV;
YbE2n:
if (!(empty($aid) || empty($uuid))) {
    goto egHsN;
}
goto DsJxl;
jkIrc:
$data["error"] = "手机号格式不对";
goto mOFRN;
jEI6e:
echo json_encode($data);
goto s0Trm;
fgqDo:
xTWXB:
goto HSH7B;
rErFu:
$invitation_user = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename(TABLE_INVITATION_USER) . " WHERE tid=:tid AND createtime>{$today_start}", array(":tid" => $qrcode["id"]));
goto jElps;
IjlXa:
if (!($activity["begintime"] && $_W["timestamp"] < $activity["begintime"])) {
    goto B79Cx;
}
goto OtDIb;
uDrjc:
GKQZk:
goto aWdNr;
OsqFs:
ILpsL:
goto hCh4x;
VXUp4:
$where = '';
goto s_PDk;
UOTVZ:
goto J3gGC;
goto s6N9h;
Uix2K:
echo json_encode($data);
goto XVLvQ;
rAwXQ:
Tq4Jo:
goto BMDe2;
BNNj3:
$data["sta"] = 0;
goto Nmopn;
eUhQi:
exit;
goto Ve27Q;
T7s1C:
sWrQ5:
goto FLN2Z;
Ro2PC:
exit;
goto gwpuy;
BdAZX:
pdo_update(TABLE_USER, $data, array("id" => $user["id"]));
goto vbi3X;
WGABg:
rjuC2:
goto NuogC;
jqMlk:
if (!empty($openid)) {
    goto LIn1Q;
}
goto qkVwN;
bBM8x:
exit;
goto wAoV4;
ker4S:
J3gGC:
goto AhGpw;
DFPG7:
if (!empty($shop)) {
    goto xTWXB;
}
goto UwWEN;
cSXvV:
$today_start = strtotime(date("Y-m-d"));
goto raRBT;
K4CGz:
if (!empty($openid)) {
    goto IXu2t;
}
goto fRUEl;
hs8CQ:
$least_cuteface_users = $least_cuteface_users + 1;
goto fqLdb;
K8Nwj:
$type = intval($_GPC["type"]);
goto rClGN;
bOfq0:
if (!$adinfo_red_before) {
    goto B3IFO;
}
goto DlEgM;
inXkW:
$times_buy = pdo_fetch("SELECT SUM(times) AS times_buy  FROM " . tablename(TABLE_ORDER) . " WHERE tid = :tid AND aid = :aid AND status=1", array(":tid" => $qrcode["id"], ":aid" => $aid));
goto nDL6X;
UPypE:
$code = mt_rand(100000, 999999);
goto q_t_w;
dAOmR:
$cuteface_num_day_surplus = $num_day ? min($lipstick_num_surplus, $cuteface_num_day_surplus) : $cuteface_num_day_surplus;
goto kwC07;
eY42W:
$qrcode = pdo_fetch("SELECT id,sharetime FROM " . tablename(TABLE_QRCODE) . " WHERE aid = :aid AND uuid = :uuid", array(":aid" => $aid, ":uuid" => $uuid));
goto T28W3;
mkhGo:
goto wZac2;
goto NzzOI;
MrT_C:
QoA_i:
goto ioWow;
treCn:
$data["error"] = "手机号码已被其他用户绑定";
goto rwwhN;
b6sCM:
$data["sta"] = 0;
goto jkIrc;
kRP3e:
$data["sta"] = 0;
goto moxf7;
Q35vu:
if ($op == "share_user_count") {
    goto UZS0e;
}
goto i7Z7_;
ys2g4:
goto y2BLN;
sjOdG:
if (!(empty($aid) || empty($uuid))) {
    goto diYIF;
}
goto YHyem;
H81JX:
FMm5z:
goto u943a;
rRkBh:
if (!($cuteface_num_day_surplus < 1)) {
    goto DQ9l0;
}
goto gdD5j;
JE2MA:
if (!$cuteface_all) {
    goto dLiYZ;
}
goto PtXRt;
CliNU:
exit;
goto E8UAC;
rT6jn:
$op = trim($_GPC["op"]);
goto uNf8E;
x8Ols:
hamRY:
goto yTGW5;
hlz1l:
$all_day = $activity["challenge_num"];
goto P8iNs;
y4D7k:
goto hamRY;
goto OjhMD;
NHOyc:
GSerG:
goto E_fVY;
xAGFH:
$path = tomedia($activity["music_entry"]);
goto h5EaI;
sNsgB:
exit;
goto x8Ols;
Sg4vY:
xO8qN:
goto e720w;
pe0v8:
uhHqe:
goto M0NW8;
n1HZX:
if ($activity["sid"]) {
    goto Q2Lap;
}
goto tfzKH;
QLwrz:
exit;
goto eIO0e;
xY0JK:
echo json_encode($data);
goto yNnaO;
EPYMY:
echo json_encode($data);
goto potUa;
e_W81:
$num_day = $activity["lipstick_num_day"];
goto OYvNZ;
NmmD9:
$data["error"] = "参数错误" . $user["uniacid"];
goto Uqn1R;
Q1ZcC:
exit;
goto C7p0h;
ELv9b:
$cuteface_num_day_surplus += $add_one * $invitation_user;
goto gRgWP;
Ca8LS:
$red_str = $shop["name"] ? "本红包由" . $shop["name"] . "提供，感谢您的参与" : "本红包来自" . $activity["name"] . "，感谢您的参与";
goto d4ZtB;
yTGW5:
goto nbwHr;
uumrP:
exit;
goto FeMvX;
Gx_zV:
$audio_res = $this->get_audio($filename, $activity["per"], $activity["red_audio_text"], true);
goto l_Pxo;
NfAkW:
$qrcode = pdo_fetch("SELECT id,times,times_day,last_time FROM " . tablename(TABLE_QRCODE) . " WHERE aid = :aid AND uuid = :uuid", array(":aid" => $aid, ":uuid" => $uuid));
goto vwGJC;
q92pk:
$data["sta"] = 0;
goto PPpOW;
UZyuB:
if ($activity["pattern"] == 11) {
    goto b83lo;
}
goto jDmTK;
c5eaF:
$data["sta"] = 0;
goto puNV9;
LOhch:
if (!($activity["status"] != 1)) {
    goto H75AB;
}
goto LgBoZ;
MpUYW:
j3jdY:
goto e9NV_;
z31Ny:
exit;
goto neGpe;
Z08yP:
if ($op == "invitation_user_count") {
    goto iuCJu;
}
goto Y36BS;
vjWf1:
echo json_encode($data);
goto nRbxx;
GjbFf:
$data["error"] = "好友的红包可以开启了";
goto Vb8bQ;
zqs_k:
$x++;
goto tF3yq;
vS4kV:
if ($op == "get_audio") {
    //lonedev
    $type = intval($_GPC["type"]);
    $uuid = addslashes(trim($_GPC["uuid"]));
    if (empty($aid) || empty($uuid)) {
        $data["sta"] = 0;
        echo json_encode($data);
        exit;
    }
    $activity = pdo_fetch("SELECT id,audio_volume,per,name,entry_audio_text,red_audio_text,end_money,music,music_entry FROM " . tablename(TABLE_ACTIVITY) . " WHERE id = :aid", array(":aid" => $aid));
    $qrcode = pdo_fetch("SELECT id FROM " . tablename(TABLE_QRCODE) . " WHERE aid = :aid AND uuid = :uuid", array(":aid" => $aid, ":uuid" => $uuid));
    $red_info = pdo_fetch("SELECT status,money,openid FROM " . tablename(TABLE_RED) . " WHERE tid = :tid", array(":tid" => $qrcode["id"]));
  if ($red_info["status"] == 1) {
        $coupon_count_user = pdo_fetchcolumn("SELECT COUNT(*) FROM" . tablename(TABLE_COUPON) . " WHERE tid = :tid AND openid = :openid  AND status!=2", array(":openid" => $openid, ":tid" => $qrcode["id"]));
        if ($openid != $red_info["openid"]) {
            $path = $coupon_count_user ? "../addons/crad_qrcode_red/template/mobile/css/coupon.mp3" : "../addons/crad_qrcode_red/template/mobile/static/audio/gameFail_audio.mp3";
        } else {
            if ($activity["red_audio_text"]) {
                $nick_name = pdo_fetch("SELECT nickname FROM " . tablename(TABLE_USER) . " WHERE openid = :openid AND aid = :aid", array(":openid" => $openid, ":aid" => $aid));
                $activity["red_audio_text"] = str_replace("#昵称#", $nick_name["nickname"], $activity["red_audio_text"]);
                $activity["red_audio_text"] = str_replace("#金额#", $red_info["money"], $activity["red_audio_text"]);
                $activity["red_audio_text"] = str_replace("#卡券#", $coupon_count_user, $activity["red_audio_text"]);
                $activity["red_audio_text"] = str_replace("#活动#", $activity["name"], $activity["red_audio_text"]);
                $filename = $this->get_code();
                $audio_res = $this->get_audio($filename, $activity["per"], $activity["red_audio_text"], true);
                $audio_res = json_decode($audio_res, true);
            }
            if ($audio_res["sta"] == 1) {
                $path = $audio_res["path"];
            } else {
                if ($activity["music"]) {
                    $path = tomedia($activity["music"]);
                } else {
                    $path = $coupon_count_user ? "../addons/crad_qrcode_red/template/mobile/css/coupon.mp3" : "../addons/crad_qrcode_red/template/mobile/css/red.mp3";
                }
            }
        }
        $adinfo_red_after = $this->get_ads(2, $aid);
        if ($adinfo_red_after) {
            $audio_url_after = tomedia($adinfo_red_after["music"]);
            pdo_update("crad_qrcode_red_adcenter", array("show_num" => $adinfo_red_after["show_num"] + 1), array("uniacid" => $uniacid, "id" => $adinfo_red_after["id"]));
        }
        exit(json_encode(array("sta" => 1, "path" => $path, "path_ad" => $audio_url_after . "?" . $adinfo_red_after["createtime"])));
    } else {
         if ($activity["entry_audio_text"]) {
            $nick_name = pdo_fetch("SELECT nickname FROM " . tablename(TABLE_USER) . " WHERE openid = :openid AND aid = :aid", array(":openid" => $openid, ":aid" => $aid));
            $activity["entry_audio_text"] = str_replace("#昵称#", $nick_name["nickname"], $activity["entry_audio_text"]);
            $activity["entry_audio_text"] = str_replace("#最大金额#", $activity["end_money"], $activity["entry_audio_text"]);
            $activity["entry_audio_text"] = str_replace("#活动#", $activity["name"], $activity["entry_audio_text"]);
            $filename = $this->get_code();
            $audio_res = $this->get_audio($filename, $activity["per"], $activity["entry_audio_text"], true);
            $audio_res = json_decode($audio_res, true);
        }
       if ($audio_res["sta"] == 1) {
            $path = $audio_res["path"];
        } else {
            if ($activity["music_entry"]) {
                $path = tomedia($activity["music_entry"]);
            } else {
                $path = "../addons/crad_qrcode_red/template/mobile/css/welcome1.mp3";
            }
        }
          $adinfo_red_before = $this->get_ads(1, $aid);
        if ($adinfo_red_before) {
            $audio_url_before = tomedia($adinfo_red_before["music"]);
            pdo_update("crad_qrcode_red_adcenter", array("show_num" => $adinfo_red_before["show_num"] + 1), array("uniacid" => $uniacid, "id" => $adinfo_red_before["id"]));
        }
        $path_ad="";
        if(!empty($audio_url_before)){
            $path_ad=$audio_url_before . "?" . $audio_url_before["createtime"];
        }
        exit(json_encode(array("sta" => 1, "path" => $path, "path_ad" =>$path_ad)));
     }
    exit;
}
goto PkZLi;
BLNAP:
echo json_encode($data);
goto EartH;
KjEnh:
pJf4p:
goto JzBCY;
wzYiw:
$data["error"] = "请求太频繁，" . (time() - $_SESSION["verification_send_time"]) . "秒后再试";
goto Emz_a;
xkvxM:
HDcCV:
goto zkPvK;
EJLG5:
$data["error"] = "商家授权开始时间未到";
goto jEI6e;
vsMav:
$data["least_user"] = $least_cuteface_users;
goto JZvE3;
tIgUQ:
$data["sta"] = 0;
goto eW9zX;
TkNKn:
echo json_encode($data);
goto CrfOq;
FBhul:
exit;
goto RUKW7;
MSQPu:
if ($cuteface_all[$x]) {
    goto CUeQu;
}
goto AJRPP;
PWYE9:
exit;
goto A3EIm;
Irn_q:
goto xpSif;
goto MWUp1;
eME1H:
exit;
goto NxF3d;
eMrMW:
exit;
goto CDVgT;
GrcTv:
if (!($tel_openid && $tel_openid["openid"] != $openid)) {
    goto SR7wz;
}
goto M1Ida;
n39d7:
$time_content_str = $time_type ? "增加" : "减少";
goto Ca8LS;
gE9jT:
$data["times"] = min($invitation_times, $cuteface_num_day_surplus);
goto yp2Is;
rBAwa:
if (!$num_day) {
    goto E8u1e;
}
goto De01X;
XiMI5:
egHsN:
goto Fsc7t;
CC8fF:
$x = 0;
goto Q9bI_;
wmJwb:
goto fxe_I;
goto U3YfM;
IHZlj:
$data["sta"] = 0;
goto EPYMY;
YZIk0:
vC836:
goto FYFd2;
oJVjy:
if (!$activity["sid"]) {
    goto sTmPD;
}
goto VsIJO;
nqn07:
kMuyp:
goto VZn7o;
y2BLN:
DOP4M:
goto cvtcI;
M1Ida:
$data["sta"] = 0;
goto treCn;
fRMbx:
echo json_encode($data);
goto j5HeC;
FeMvX:
goto fKJHo;
goto bjeRa;
Tx5wB:
AsgrO:
goto ZK549;
RSC6n:
$data["error"] = "参数错误";
goto hUMU4;
te3Py:
$data["time"] = $time_data["tip"];
goto J12cB;
fLDbw:
dLiYZ:
goto Rpg3D;
ow7Da:
$adinfo_red_after = $this->get_ads(2, $aid);
goto nuaLT;
wsbdm:
$data["sta"] = 0;
goto EbDqC;
QuMCt:
echo json_encode($data);
goto ywJ4w;
whEmG:
goto PT3ys;
DkAXw:
$num_day = $activity["challenge_num_day"];
goto hlz1l;
kRWZb:
$data["sta"] = 0;
goto re69j;
e2518:
$activity["red_audio_text"] = str_replace("#活动#", $activity["name"], $activity["red_audio_text"]);
goto PpDJE;
ph0j5:
if (!(empty($aid) || empty($uuid))) {
    goto H0gVs;
}
goto hTfpC;
ia8U0:
$data["sta"] = 0;
goto CSMQw;
nbwHr:
iuCJu:
goto AlwhJ;
HMnBC:
exit(json_encode(array("sta" => 1, "path" => $path, "path_ad" => $audio_url_before . "?" . $audio_url_before["createtime"])));
goto bDFFe;
PGBlk:
defined("IN_IA") or exit("Access Denied");
goto tyQFt;
Qiv0K:
$reduce_time = $sum_reduce["reduce_time"] ? $sum_reduce["reduce_time"] : 0;
goto Zt9wV;
P8iNs:
JTcJt:
goto GsayU;
e720w:
if ($invitation_user >= $activity["share_num"]) {
    goto OK2ri;
}
goto BsriB;
SSLT3:
$data["sta"] = 0;
goto K69B9;
e9NV_:
goto FMm5z;
goto AopGb;
PdB0t:
GouJN:
goto IHZlj;
F2fHK:
$time_check = intval($_GPC["time_check"]);
goto VXUp4;
dYGF1:
exit;
goto y4D7k;
Sc5ld:
if (!($lack_time <= 0)) {
    goto XSXgW;
}
goto NNkje;
PT3ys:
AJUJJ:
goto glIKY;
uNf8E:
$openid = $_W["openid"];
goto iihXc;
UstJ1:
$time_type_str = $time_type ? "你被" . $invitation_user["nickname"] . "整了，快去看看!" : $invitation_user["nickname"] . "帮助了你，快去看看!";
goto n39d7;
CNKdR:
ecEfq:
goto fLDbw;
vtqkO:
$comment = trim($_GPC["comment"]);
goto sjOdG;
QRUV4:
SR7wz:
goto QqVK7;
XjUVV:
if (!$all_day) {
    goto SY6iJ;
}
goto Ly84w;
NuogC:
goto I3nDl;
goto yQni7;
QqVK7:
if (!($tel != $user["tel"] || empty($user["is_check"]))) {
    goto HJ1Cx;
}
goto hBdqI;
bwFl3:
vYpfK:
goto kgG7K;
i8RRT:
exit;
goto v2SxR;
kBlyW:
if (empty($red_info) && $max_openid != $openid) {
    goto H8Llt;
}
goto pd0jE;
De01X:
$cuteface_num_day_surplus = $qrcode["last_time"] >= strtotime(date("Y-m-d")) ? $num_day - $qrcode["times_day"] : $num_day;
goto cSXvV;
OyjCM:
IBvLS:
goto HoglP;
hTfpC:
$data["sta"] = 0;
goto BLNAP;
c60tH:
$data["tips"] = "红包已被<span>" . $red_nickname . "</span>抢走啦";
goto IEq6O;
ZtWd9:
$html_res .= "</div>";
goto DenTg;
NxF3d:
goto N6YSF;
ZME_a:
if (!(!$tel || !preg_match("/^([0-9]{11})?\$/", $tel))) {
    goto m62YX;
}
goto wsbdm;
Kl49c:
goto IhxT1;
F3zJ6:
$image_cuteface = $cuteface_all[$x]["image_thumb_url"] ? tomedia($cuteface_all[$x]["image_thumb_url"]) : $cuteface_all[$x]["headimgurl"];
goto nuKvD;
J1Fgi:
echo json_encode($data);
goto Zg3xl;
nY9AV:
echo json_encode($data);
goto QLwrz;
xgwBx:
if ($activity["music_entry"]) {
    goto tZXlf;
}
goto AX6b2;
Pd2Ga:
$data["error"] = "您的信息已审核，无法修改了";
goto DY0sn;
gRfV3:
echo json_encode(array("sta" => 1));
goto eME1H;
Sb7y3:
UZS0e:
goto Cb752;
BmgtR:
exit;
goto Vv2BO;
MvD4W:
$uniacid = $_W["uniacid"];
goto CdFH_;
hC98e:
$data["sta"] = 0;
goto wqonc;
IEq6O:
goto rjuC2;
goto lc9rB;
MYcKU:
die;
goto fgqDo;
o9nf8:
if (!($tel_openid && $tel_openid["openid"] != $openid)) {
    goto EYFb9;
}
goto qxfOq;
vbi3X:
qmvaT:
goto gRfV3;
F5lr5:
$data["sta"] = 0;
goto kkDMC;
mW5_h:
gQSZ6:
goto JMl6A;
PpDJE:
$filename = $this->get_code();
goto Gx_zV;
CIJYD:
$activity["entry_audio_text"] = str_replace("#昵称#", $nick_name["nickname"], $activity["entry_audio_text"]);
goto FKTCo;
ZhGpi:
$audio_url_after = tomedia($adinfo_red_after["music"]);
goto aOfnf;
iReCW:
echo json_encode($data);
goto gMkYY;
yQni7:
H8Llt:
goto J5Q1q;
X6PD2:
if ($activity["pattern"] == 6) {
    goto ltLZK;
}
goto I7oUz;
ZP1io:
$add_time = $sum_add["add_time"] ? $sum_add["add_time"] : 0;
goto Qiv0K;
Xxhoi:
echo json_encode($data);
goto sNsgB;
xP4Ek:
$data["sta"] = 0;
goto uQMd7;
xaPMK:
if (!(empty($aid) || empty($uuid))) {
    goto j7F6f;
}
goto An8Qc;
Lag7R:
$cuteface_num_day_surplus = $num_day ? min($lipstick_num_surplus, $cuteface_num_day_surplus) : $cuteface_num_day_surplus;
goto Od1sl;
v2SxR:
goto etllH;
b_i72:
if (!(empty($cfg["api"]["accesskeyid"]) || empty($cfg["api"]["accesskeysecret"]) || empty($cfg["api"]["templatecode"]))) {
    goto WKbj1;
}
goto ia8U0;
Wv6gi:
exit;
goto bwFl3;
AJRPP:
$html_res .= "<div class='crown_li'>";
goto eCWh4;
Rpg3D:
$count_cuteface_user = count($cuteface_users);
goto TemVr;
izLAq:
Kc8Ao:
goto BdAZX;
JYvfX:
goto lLQXf;
LgBoZ:
$data["sta"] = 0;
goto mw0Xt;
vqoVT:
$data["is_send_red"] = 0;
goto Qcak6;
TpKEU:
$nick_name = pdo_fetch("SELECT nickname FROM " . tablename(TABLE_USER) . " WHERE openid = :openid AND aid = :aid", array(":openid" => $openid, ":aid" => $aid));
goto CIJYD;
LG8Vx:
$data["error"] = "活动未开始";
goto iReCW;
NRhMI:
if (!($resp["Code"] != "OK")) {
    goto A8LxQ;
}
goto dB21H;
mNylD:
$shop_user = pdo_fetch("SELECT openid FROM " . tablename(TABLE_MANAGER) . " WHERE shopid = :shopid AND power>1 AND openid!=''", array(":shopid" => $activity["sid"]));
goto Bq4RI;
hJP2Y:
$tel = trim($_GPC["check_phone"]);
goto YGARv;
JzBCY:
SY6iJ:
goto rBAwa;
pVcCk:
$path = $audio_res["path"];
goto L4bEK;
OjhMD:
vl4mB:
goto VT4aq;
KsweU:
$data["user_count"] = $invitation_user_count ? $invitation_user_count : 0;
goto F1hgd;
Nmopn:
$data["error"] = "活动已结束";
goto kQt0a;
BEFZZ:
echo json_encode($data);
goto dYGF1;
jElps:
if ($activity["share_num"]) {
    goto xO8qN;
}
goto ELv9b;
Ly84w:
$lipstick_num_surplus = $all_day - $qrcode["times"];
goto UXbIH;
DenTg:
goto S7_pg;
goto n983Z;
Qk7is:
ltLZK:
goto UGO8C;
Vv2BO:
m62YX:
goto vbdOn;
Gdsok:
$html_res .= "</div>";
goto ZtWd9;
I7oUz:
if ($activity["pattern"] == 8) {
    goto UyjNE;
}
goto UZyuB;
ZK549:
$rules = json_decode($activity["rules"], true);
goto wGpg1;
MWUp1:
tZXlf:
goto xAGFH;
LNlL1:
$html_res .= "<div class='crownli_img'>";
goto F3zJ6;
eW9zX:
$data["error"] = "商家授权时间已过";
goto uLtbH;
I0YwO:
$data["sta"] = 0;
goto gIY5_;
D7prx:
foreach ($cuteface_all as &$value) {
    goto dz95v;
    BiBNa:
    goto Su3mK;
    goto sf62M;
    fsFzK:
    $max_cid = $value["id"];
    goto wH6nL;
    q9iUw:
    $value["headimgurl"] = $red_nickname["headimgurl"];
    goto RAy6B;
    qnbwR:
    nFhKb:
    goto VMjGR;
    qft8Y:
    $cuteface_users[] = $value;
    goto BiBNa;
    TjId5:
    Fro54:
    goto tAtbi;
    ws1aw:
    Su3mK:
    goto TjId5;
    E_iyy:
    $cuteface = $value;
    goto ws1aw;
    VMjGR:
    if ($value["openid"] == $qrcode["openid"]) {
        goto D51GV;
    }
    goto qft8Y;
    dz95v:
    $red_nickname = pdo_fetch("SELECT nickname,headimgurl FROM " . tablename(TABLE_USER) . " WHERE openid = :openid AND aid= :aid", array(":openid" => $value["openid"], ":aid" => $aid));
    goto mnTDt;
    RAy6B:
    if (!($value["mark"] > $max_mark)) {
        goto nFhKb;
    }
    goto ckzI7;
    ckzI7:
    $max_mark = $value["mark"];
    goto fsFzK;
    mnTDt:
    $value["nickname"] = $red_nickname["nickname"];
    goto q9iUw;
    wH6nL:
    $max_openid = $value["openid"];
    goto qnbwR;
    sf62M:
    D51GV:
    goto E_iyy;
    tAtbi:
}
goto CNKdR;
CrpJI:
echo json_encode($data);
goto ll0Zj;
ywJ4w:
die;
goto aTIuf;
eNoP2:
$url = $this->domain_site() . "app/" . substr($this->createMobileUrl("activity_user", array("aid" => $activity["id"], "shopid" => $activity["sid"], "token" => $this->get_shoptoken($uniacid, $activity["sid"])), true), 2);
goto PROHS;
kw80D:
M08Jt:
goto LNlL1;
Z8ldD:
$red_info = pdo_fetch("SELECT * FROM " . tablename(TABLE_RED) . " WHERE tid = :tid", array(":tid" => $qrcode["id"]));
goto QP3yu;
PROHS:
$template = array("touser" => $shop_user["openid"], "template_id" => $cfg["api"]["mid_check"], "url" => $url, "topcolor" => "#743a3a", "data" => array("first" => array("value" => urlencode("有新用户申请加入白名单，赶紧去审核吧"), "color" => "#2F1B58"), "keyword1" => array("value" => urlencode($activity["name"]), "color" => "#2F1B58"), "keyword2" => array("value" => urlencode($user["realname"]), "color" => "#2F1B58"), "keyword3" => array("value" => urlencode(date("Y-m-d H:i:s", time())), "color" => "#2F1B58"), "remark" => array("value" => urlencode("点击进入商家后台审核"), "color" => "#2F1B58")));
goto mUZ2b;
Y_bSG:
H75AB:
goto oJVjy;
jpjGH:
header("Content-type:application/json");
goto MkqXu;
h9KL3:
$data["sta"] = 0;
goto jQIJt;
YZx96:
exit;
goto wVd9S;
UnfqJ:
$data["error"] = "参数错误";
goto e7Hsb;
h5EaI:
xpSif:
goto wmJwb;
sp3ZR:
die;
goto FrkHD;
qzbbl:
if (!($shop["time_open"] && $shop["endtime"] && $_W["timestamp"] > $shop["endtime"])) {
    goto QoA_i;
}
goto tIgUQ;
kgG7K:
$activity = pdo_fetch("SELECT id,audio_volume,per,name,entry_audio_text,red_audio_text,end_money,music,music_entry FROM " . tablename(TABLE_ACTIVITY) . " WHERE id = :aid", array(":aid" => $aid));
goto jaT0q;
A3EIm:
LZj3m:
goto Zaiq0;
v4vEp:
wZac2:
goto K6Kn1;
J81OC:
goto Ono7b;
goto Tx5wB;
HD9g2:
$invitation_user_count = pdo_fetchcolumn("select COUNT(*) from " . tablename(TABLE_INVITATION_USER) . " WHERE tid=:tid {$where}", array(":tid" => $qrcode["id"]));
goto zuHyk;
QP3yu:
if (empty($red_info) && $max_openid == $openid) {
    goto YhLbY;
}
goto kBlyW;
ugqzA:
$data["sta"] = 0;
goto SMXS4;
jvbRn:
exit;
goto pW1yl;
Y6ZBA:
$least_cuteface_users = $temp_least > 0 ? $temp_least : 0;
goto W1eFA;
fDJAL:
$data = array("tel" => $tel, "is_check" => 1, "check_tel_time" => time());
goto ySejX;
mvQIu:
exit;
goto uDrjc;
dPo8_:
echo json_encode($data);
goto MYcKU;
qFtlf:
$activity = pdo_fetch("SELECT id,pattern,countdown,comment_open,rules,begintime,endtime,status,sid,name FROM " . tablename(TABLE_ACTIVITY) . " WHERE id = :aid", array(":aid" => $aid));
goto FCphK;
Rpaxy:
if (!(empty($qrcode) || $qrcode["sharetime"] < 1)) {
    goto iiJpP;
}
goto PIjvP;
X0eRc:
$data["invitation_content"] = $cuteface_num_day_surplus ? "今日剩余<span>{$cuteface_num_day_surplus}次</span>" : '';
goto n7D1I;
RtHiZ:
$sum_reduce = pdo_fetch("SELECT SUM(time) AS reduce_time FROM " . tablename(TABLE_INVITATION_USER) . " WHERE tid=:tid AND time_type=0", array(":tid" => $qrcode["id"]));
goto ZP1io;
Ukung:
echo json_encode($data);
goto Wv6gi;
tbvEb:
$red_nickname = $cuteface_all[$x]["nickname"];
goto kw80D;
uuzeu:
$tel = trim($_GPC["tel"]);
goto FB7lA;
t7HPu:
$lipstick_image = $activity["lipstick_image"] ? json_decode($activity["lipstick_image"], true) : array();
goto N_qiy;
heynO:
exit;
goto iwqqX;
JMl6A:
exit(json_encode(array("sta" => 1, "path" => $path, "path_ad" => $audio_url_after . "?" . $adinfo_red_after["createtime"])));
goto PdB0t;
XXIr8:
if ($data_insert["time"]) {
    goto C21t1;
}
goto ESTSw;
nuKvD:
$html_res .= "<img src='" . $image_cuteface . "' class='' />";
goto AnlNe;
fbCLZ:
AgpLM:
goto SKjNQ;
H1gS7:
$html_res .= "<img src='../addons/crad_qrcode_red/template/mobile/img/me.png' />";
goto KvDd2;
Bq4RI:
if (!($shop_user["openid"] && $cfg["api"]["mid_check"])) {
    goto b3Lb7;
}
goto eNoP2;
LVN7P:
$user = pdo_fetch("SELECT id,openid,realname,uniacid,is_check,aid,tel FROM " . tablename(TABLE_USER) . " WHERE openid = :openid AND aid= :aid", array(":openid" => $openid, ":aid" => $aid));
goto TL2T4;
R5mvZ:
Q2Lap:
goto mNylD;
W1eFA:
$html_res = '';
goto CC8fF;
fJ6wi:
$data["sta"] = 1;
goto te3Py;
yNcW6:
I3nDl:
goto j24fQ;
IhxT1:
I7I_I:
goto jqMlk;
L3nmC:
Ono7b:
goto QuMCt;
CO0Uc:
if ($activity["music"]) {
    goto Id74W;
}
goto zFjfg;
GsayU:
goto b5yOI;
goto Qk7is;
QJ0sm:
$data["error"] = "参数错误";
goto v4yPY;
zkPvK:
if (!empty($openid)) {
    goto sxwmV;
}
goto mdkIu;
VT4aq:
$data["sta"] = 1;
goto Xxhoi;
fM_LH:
if (!($activity["endtime"] && $_W["timestamp"] > $activity["endtime"])) {
    goto rAnvE;
}
goto BNNj3;
shfSM:
oFMuv:
goto QSbym;
kkDMC:
$data["error"] = "数据错误";
goto OJc0k;
hBdqI:
if (!(empty($code) || $code != $_SESSION["verification_code"])) {
    goto vC836;
}
goto I0YwO;
vbdOn:
if (!($tel == $user["tel"] && $user["is_check"] == 1)) {
    goto vfBdz;
}
goto SSLT3;
vfs_T:
$cuteface_num_day_surplus += $times_buy_day["times_buy"];
goto hQ73R;
VuynR:
$endtime = time();
goto gbn3O;
FYFd2:
HJ1Cx:
goto fDJAL;
jaT0q:
$qrcode = pdo_fetch("SELECT id FROM " . tablename(TABLE_QRCODE) . " WHERE aid = :aid AND uuid = :uuid", array(":aid" => $aid, ":uuid" => $uuid));
goto GTb17;
EQmOP:
Id74W:
goto hdeuZ;
eiloU:
H0gVs:
goto F2fHK;
lc9rB:
lTe1T:
goto RzYBE;
RUKW7:
oPT3E:
goto Fc0v2;
rEtpH:
if ($audio_res["sta"] == 1) {
    goto cro0D;
}
goto xgwBx;
L6ioL:
Btr4a:
goto T7s1C;
Fc0v2:
if (!($invitation_user["time"] > 0)) {
    goto xLKqP;
}
goto q92pk;
WuOHc:
exit;
goto Hj9Af;
OSukl:
if (!(empty($user) || $user["uniacid"] != $uniacid)) {
    goto LDRkN;
}
goto EdDxe;
potUa:
exit;
goto gJXFa;
ioWow:
sTmPD:
goto NZPOS;
SMXS4:
echo json_encode($data);
goto Suc7P;
etllH:
vY_od:
goto u5svm;
YMP76:
echo json_encode($data);
goto rK__p;
wqonc:
echo json_encode($data);
goto Ro2PC;
CrfOq:
exit;
goto ZSXXS;
MQAda:
LIn1Q:
goto ti_mA;
injR3:
echo json_encode($data);
goto mH6d9;
bYT1E:
$data["sta"] = 0;
goto UGdVR;
L0V3M:
Q754n:
goto G1Z6l;
jFme8:
echo json_encode($data);
goto UzYLV;
BdKtL:
if (!($qrcode["openid"] && $cfg["api"]["mid_share"])) {
    goto iF4tU;
}
goto UstJ1;
wQ_My:
wwmXi:
goto J6Dh4;
C1JGU:
$data["error"] = "操作失败：时间错误";
goto I1Hjp;
r2A5k:
exit;
goto ys2g4;
g20gd:
exit;
goto KB8dt;
ORXi0:
$uuid = addslashes(trim($_GPC["uuid"]));
goto xc2aV;
NZPOS:
$sum_add = pdo_fetch("SELECT SUM(time) AS add_time FROM " . tablename(TABLE_INVITATION_USER) . " WHERE tid=:tid AND time_type=1", array(":tid" => $qrcode["id"]));
goto RtHiZ;
n7D1I:
echo json_encode($data);
goto smYl8;
aOfnf:
pdo_update("crad_qrcode_red_adcenter", array("show_num" => $adinfo_red_after["show_num"] + 1), array("uniacid" => $uniacid, "id" => $adinfo_red_after["id"]));
goto mW5_h;
E8UAC:
j7F6f:
goto eY42W;
L4bEK:
fxe_I:
goto AZOof;
pedSY:
if ($op == "check_tel") {
    goto I7I_I;
}
goto vS4kV;
N_qiy:
$game_tip_before = $lipstick_image["game_tip_before"] ? $lipstick_image["game_tip_before"] : "玩口红游戏，通过" . $activity["lipstick_level"] . "关即可领取红包";
goto yMSOl;
Od1sl:
$data["sta"] = $cuteface_num_day_surplus ? 1 : 0;
goto X0eRc;
gIY5_:
$data["error"] = "验证码错误";
goto Uix2K;
u9Q5f:
CF7pP:
goto OrdBa;
YQSGP:
echo json_encode($data);
goto uumrP;
neGpe:
DQ9l0:
goto L0V3M;
p5GrJ:
echo json_encode($data);
goto z31Ny;
vXMC2:
echo json_encode($data);
goto R2E7g;
uat5X:
$data["tips"] = "还差<span>" . $least_cuteface_users . "人</span>参与PK，颜值最高者得红包！";
goto mMNMy;
rClGN:
$uuid = addslashes(trim($_GPC["uuid"]));
goto gD8Vr;
UdcA6:
$num_day_surplus = min($lipstick_num_surplus, $add_one * $activity["share_num"]);
goto nODih;
yqLKf:
$data["sta"] = 1;
goto ker4S;
F8tri:
$data["is_send_red"] = 4;
goto c60tH;
uK_39:
$all_day = $activity["cuteface_num"];
goto FRKsf;
L6hXd:
echo json_encode($data);
goto g20gd;
cljpv:
Q6UG6:
goto uat5X;
bbYmX:
$data["error"] = "活动已暂停：" . $activity["stop_tips"];
goto J1Fgi;
n8_qc:
zEzVC:
goto LOhch;
In1kA:
hZgKz:
goto qzbbl;
bVAEb:
VuRDo:
goto L5aRp;
VsIJO:
$shop = pdo_fetch("SELECT id,time_open,begintime,endtime,name FROM " . tablename(TABLE_SHOP) . " WHERE id = :shopid", array(":shopid" => $activity["sid"]));
goto DFPG7;
JRteb:
if ($red_info["status"] == 1) {
    goto kMuyp;
}
goto mB0lv;
Kmtq9:
$data["sta"] = 0;
goto Pd2Ga;
FusIx:
$data_insert["time"] = rand(1, $max_temp);
goto ebMte;
R0NGK:
goto j3jdY;
goto EQmOP;
tF3yq:
goto fo30h;
goto Ln36U;
cb8Ua:
if (!(empty($user) || $user["uniacid"] != $uniacid)) {
    goto ZIok3;
}
goto FGgx2;
s1Zrr:
$path = $audio_res["path"];
goto H81JX;
moxf7:
$data["error"] = "手机号错误";
goto fRMbx;
FCphK:
if (!(empty($activity) || $activity["pattern"] != 10 || empty($activity["countdown"]) || empty($activity["rules"]))) {
    goto M0nCS;
}
goto bYT1E;
JsNEr:
if (!empty($user)) {
    goto rgYiP;
}
goto xP4Ek;
s0Trm:
die;
goto In1kA;
Acy6q:
if (!(!$tel || $tel != $_SESSION["verification_tel"] || !preg_match("/^([0-9]{11})?\$/", $tel))) {
    goto xGDbw;
}
goto kRP3e;
lLQXf:
tCTuN:
goto ORXi0;
nOtT0:
C21t1:
goto mmez0;
FFd7b:
E8u1e:
goto Lag7R;
oKMQh:
echo json_encode($data);
goto jvbRn;
GGs0f:
$html_res .= "<div class='crownli_yes'>";
goto R5XwB;
NqnBM:
$html_res .= "<div class='crownli_one'>等待加入</div>";
goto Gdsok;
I65Yb:
mV2cM:
goto SdsnS;
Y36BS:
if ($op == "share_status") {
    goto vY_od;
}
goto h2Q8V;
TL2T4:
if (!(empty($user) || $user["uniacid"] != $uniacid)) {
    goto g6mcw;
}
goto rJX86;
PPpOW:
$data["error"] = "您已经帮助过好友了";
goto TkNKn;
VZn7o:
$coupon_count_user = pdo_fetchcolumn("SELECT COUNT(*) FROM" . tablename(TABLE_COUPON) . " WHERE tid = :tid AND openid = :openid  AND status!=2", array(":openid" => $openid, ":tid" => $qrcode["id"]));
goto cEdD7;
XPiNu:
exit;
goto Y_bSG;
E_fVY:
echo json_encode($data);
goto r2A5k;
Sq601:
$data["sta"] = 0;
goto UOTVZ;
pGcKq:
PJGN3:
goto YoK9l;
QiB0E:
exit;
goto fbCLZ;
wGpg1:
foreach ($rules as $value) {
    goto EKicd;
    jqVwp:
    $lack_time = $lack_time + $data_insert["time"];
    goto JTjjW;
    yH7cg:
    R152O:
    goto I8uvj;
    JTjjW:
    y8fsh:
    goto bKHvf;
    PYbEb:
    xC5WZ:
    goto XWX0q;
    XWX0q:
    $data_insert["time"] = rand($value["add_min"], $value["add_max"]);
    goto jqVwp;
    bKHvf:
    goto WCl33;
    goto yH7cg;
    F4Ud1:
    $data_insert["time"] = rand($value["reduce_min"], $value["reduce_max"]);
    goto SJLOF;
    BTYRv:
    if ($time_type == 1) {
        goto xC5WZ;
    }
    goto F4Ud1;
    EKicd:
    if (!($lack_time > $value["time"])) {
        goto R152O;
    }
    goto BTYRv;
    SJLOF:
    $lack_time = $lack_time - $data_insert["time"] > 0 ? $lack_time - $data_insert["time"] : 0;
    goto NoAvf;
    I8uvj:
    KEF0e:
    goto hvDKb;
    NoAvf:
    goto y8fsh;
    goto PYbEb;
    hvDKb:
}
goto nJMkS;
WYMoh:
$add_one = $activity["add_one"] ? $activity["add_one"] : 1;
goto rErFu;
Ln36U:
lc35C:
goto P_J48;
vwGJC:
if (!($activity["pattern"] == 11 && ($qrcode["last_time"] < strtotime(date("Y-m-d")) || empty($activity["lipstick_num"]) && empty($activity["lipstick_num_day"])))) {
    goto JqWS1;
}
goto yZudP;
adkmx:
echo json_encode($data);
goto HHLqo;
CxuPw:
$activity["lipstick_level"] = $activity["lipstick_level"] < 1 || $activity["lipstick_level"] > 3 ? 3 : intval($activity["lipstick_level"]);
goto t7HPu;
X1pkV:
A8LxQ:
goto HF_Ad;
j0Vbe:
$nick_name = pdo_fetch("SELECT nickname FROM " . tablename(TABLE_USER) . " WHERE openid = :openid AND aid = :aid", array(":openid" => $openid, ":aid" => $aid));
goto YsXMg;
PW4NN:
$data["error"] = "参数错误";
goto nY9AV;
CJzPK:
goto mV2cM;
goto pGcKq;
Toozf:
if ($cuteface_all[$x]["openid"] == $openid) {
    goto VuRDo;
}
goto Vko8B;
UGdVR:
$data["error"] = "模式数据错误";
goto jFme8;
nDL6X:
if (!($times_buy["times_buy"] > 0)) {
    goto XUbtJ;
}
goto dFzzJ;
Uqn1R:
echo json_encode($data);
goto eMrMW;
h2Q8V:
if ($op == "get_share_status") {
    goto DOP4M;
}
goto yLaBl;
bllbI:
$data["error"] = "非法操作";
goto L6hXd;
iDe4w:
$template = array("touser" => $cfg["api"]["openid"], "template_id" => $cfg["api"]["mid_check"], "url" => '', "topcolor" => "#743a3a", "data" => array("first" => array("value" => urlencode("有新用户申请加入白名单，赶紧去审核吧"), "color" => "#2F1B58"), "keyword1" => array("value" => urlencode($activity["name"]), "color" => "#2F1B58"), "keyword2" => array("value" => urlencode($user["realname"]), "color" => "#2F1B58"), "keyword3" => array("value" => urlencode(date("Y-m-d H:i:s", time())), "color" => "#2F1B58"), "remark" => array("value" => urlencode("请进入系统后台活动列表审核"), "color" => "#2F1B58")));
goto JwIjp;
GmRAb:
exit;
goto rAwXQ;
aTn3W:
$data["sta"] = 0;
goto mWG_x;
Vb8bQ:
echo json_encode($data);
goto sp3ZR;
ZtLjz:
if (!(empty($aid) || empty($uuid))) {
    goto w0Ilh;
}
goto qB3mk;
wv_uV:
sxwmV:
goto LVN7P;
XZgNX:
$_SESSION["verification_send_time"] = time();
goto w_hu5;
fRUEl:
$data["sta"] = 0;
goto xBUFF;
hCh4x:
fKJHo:
goto e_yhI;
Pw_5Q:
$tel_openid = pdo_fetch("SELECT openid FROM " . tablename(TABLE_USER) . " WHERE tel = :tel AND aid=:aid", array(":tel" => $tel, ":aid" => $aid));
goto GrcTv;
EdDxe:
$data["sta"] = 0;
goto RSC6n;
gJXFa:
goto xkvxM;
KB8dt:
goto rAGHB;
K6Kn1:
goto JTcJt;
goto aajpS;
ebMte:
$data_insert["time_type"] = $time_type;
goto uloby;
bjeRa:
rgYiP:
goto E8A8_;
n1dZK:
if (!(empty($cfg["api"]["ticket"]) || !preg_match("/^[A-Za-z0-9]{32}\$/", $cfg["api"]["ticket"]))) {
    goto LZj3m;
}
goto ViTzF;
HSH7B:
if (!($shop["time_open"] && $shop["begintime"] && $_W["timestamp"] < $shop["begintime"])) {
    goto hZgKz;
}
goto fqxN8;
F1hgd:
echo json_encode($data);
goto i8RRT;
mOFRN:
echo json_encode($data);
goto jrWfB;
j5HeC:
exit;
goto fGNAY;
YsXMg:
$activity["red_audio_text"] = str_replace("#昵称#", $nick_name["nickname"], $activity["red_audio_text"]);
goto XfTAY;
yNnaO:
exit;
goto TZ3sC;
FGgx2:
$data["sta"] = 0;
goto QJ0sm;
xxYPV:
exit;
goto aFfcY;
oUQxb:
Owo9E:
goto zVk4b;
ukEWM:
iF4tU:
goto fJ6wi;
tyQFt:
error_reporting(0);
goto jpjGH;
mmez0:
pdo_update(TABLE_INVITATION_USER, $data_insert, array("id" => $invitation_user["id"]));
goto JDRfG;
i7Z7_:
$data["sta"] = 0;
goto bllbI;
wtImB:
IXu2t:
goto Oyvcs;
KTEGX:
$html_res .= "</div>";
goto JrZ9i;
v4yPY:
echo json_encode($data);
goto WuOHc;
wVd9S:
goto qmvaT;
goto izLAq;
kb_2t:
$html_res .= "<div class='crownli_yes'>";
goto NqnBM;
P_J48:
$data["sta"] = 1;
goto vqoVT;
JwIjp:
$this->send_temp_ms(urldecode(json_encode($template)));
goto u9Q5f;
PtXRt:
$max_mark = 0;
goto ACvsv;
WuNMH:
He6BO:
goto VAu64;
AlwhJ:
$uuid = addslashes(trim($_GPC["uuid"]));
goto ph0j5;
ttS5L:
$data["error"] = "openid为空，配置错误或在非微信浏览器中打开";
goto vjWf1;
PIjvP:
$data["sta"] = 0;
goto anZLi;
qB3mk:
$data["sta"] = 0;
goto oKMQh;
jrWfB:
exit;
goto JRsir;
c8GAW:
$template = array("touser" => $qrcode["openid"], "template_id" => $cfg["api"]["mid_share"], "url" => $url, "topcolor" => "#743a3a", "data" => array("first" => array("value" => urlencode($time_type_str), "color" => "#2F1B58"), "keyword1" => array("value" => urlencode("红包领取时间" . $time_content_str . $time_data["tip"]), "color" => "#2F1B58"), "keyword2" => array("value" => urlencode("还差" . $lack_time_str["tip"] . "可领取红包"), "color" => "#2F1B58"), "remark" => array("value" => urlencode($red_str), "color" => "#2F1B58")));
goto PmO11;
gwpuy:
goto h7cpe;
goto iYfDo;
BKEQR:
$data["error"] = "手机号码已被其他用户绑定";
goto vXMC2;
VAu64:
$path = $coupon_count_user ? "../addons/crad_qrcode_red/template/mobile/css/coupon.mp3" : "../addons/crad_qrcode_red/template/mobile/static/audio/gameFail_audio.mp3";
goto TMPan;
zFjfg:
$path = $coupon_count_user ? "../addons/crad_qrcode_red/template/mobile/css/coupon.mp3" : "../addons/crad_qrcode_red/template/mobile/css/red.mp3";
goto R0NGK;
PlEz1:
echo json_encode($data);
goto eUhQi;
rK__p:
exit;
goto wtImB;
yMSOl:
$data["sta"] = 1;
goto M8cK2;
FrkHD:
XSXgW:
goto I0ZIO;
J12cB:
pwSf2:
goto L3nmC;
Y0bjg:
if ($least_cuteface_users > 0) {
    goto Q6UG6;
}
goto Z8ldD;
nJIbb:
if (!(empty($aid) || empty($uuid))) {
    goto Z2e3Y;
}
goto ugqzA;
XfTAY:
$activity["red_audio_text"] = str_replace("#金额#", $red_info["money"], $activity["red_audio_text"]);
goto PV5N_;
QFHml:
echo json_encode($data);
goto mvQIu;
OrdBa:
goto ILpsL;
goto R5mvZ;
iihXc:
$cfg = $this->module["config"];
goto n1dZK;
IiR23:
$max_openid = '';
goto D7prx;
ti_mA:
$user = pdo_fetch("SELECT id,openid,is_check,uniacid,is_white,aid,tel FROM " . tablename(TABLE_USER) . " WHERE openid = :openid AND aid= :aid", array(":openid" => $openid, ":aid" => $aid));
goto OSukl;
Zt9wV:
$starttime = $activity["countdown_type"] == 1 ? $qrcode["usetime"] : $qrcode["sharetime"];
goto VuynR;
iwqqX:
LDRkN:
goto hJP2Y;
nJMkS:
WCl33:
goto XXIr8;
kQt0a:
echo json_encode($data);
goto sTwpZ;
PFqCY:
AeRzQ:
goto zqs_k;
UFsqp:
echo json_encode($data);
goto bBM8x;
OtDIb:
$data["sta"] = 0;
goto LG8Vx;
nSQya:
$times_buy_day = pdo_fetch("SELECT SUM(times) AS times_buy  FROM " . tablename(TABLE_ORDER) . " WHERE tid = :tid AND aid = :aid AND status=1 AND paytime>={$today_start}", array(":tid" => $qrcode["id"], ":aid" => $aid));
goto nxMX2;
OUrTO:
$html_res .= "<div class='crown_li'>";
goto j3Q9J;
zdB2w:
vfBdz:
goto b_i72;
UXbIH:
if (!($activity["buy_times"] == 1 && $activity["pattern"] == 11)) {
    goto pJf4p;
}
goto inXkW;
HoglP:
if (!$activity["share_open"]) {
    goto rdFZx;
}
goto WYMoh;
rwwhN:
echo json_encode($data);
goto Nfbmd;
Emz_a:
echo json_encode($data);
goto GmRAb;
Fd2Qm:
if ($audio_res["sta"] == 1) {
    goto Tx8Lr;
}
goto CO0Uc;
nuaLT:
if (!$adinfo_red_after) {
    goto gQSZ6;
}
goto ZhGpi;
R2E7g:
exit;
goto LDaWn;
s9TEM:
pdo_update("crad_qrcode_red_adcenter", array("show_num" => $adinfo_red_before["show_num"] + 1), array("uniacid" => $uniacid, "id" => $adinfo_red_before["id"]));
goto C3RAy;
NNkje:
$data["sta"] = 0;
goto GjbFf;
s6N9h:
nmCC3:
goto yqLKf;
uloby:
if (!$activity["comment_open"]) {
    goto Owo9E;
}
goto qXfFL;