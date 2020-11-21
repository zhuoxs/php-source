<?php

goto gTvuO;
AJ6PP:
$noid = $lastid[0]["noid"] + 1;
goto kBtU9;
cwKy3:
goto t_7M3;
goto w8keH;
zFn2c:
$user_max_count = $user_max_count ? $user_max_count : 10;
goto RclQl;
qXNDR:
$uniacid = $_W["uniacid"];
goto K61MD;
xv6Hm:
$source_arr = array();
goto T1dRU;
tWAuH:
$post_data = array("time" => time(), "ticket" => $cfg["ticket"], "module_id" => 3);
goto W_PXy;
f54Ju:
qKW79:
goto ajBRB;
zrwNg:
tnxP7:
goto xwFAO;
q2Y5O:
if ($result["sta"]) {
    goto V9bx0;
}
goto G2YOj;
Dmkqf:
$cture = 0;
goto JXZa_;
RclQl:
if (!($_GPC["vheat_min"] || $_GPC["vheat_max"])) {
    goto tnxP7;
}
goto VGJae;
JXZa_:
$lastid = pdo_getall($this->tablevoteuser, array("rid" => $rid, "uniacid" => $_W["uniacid"]), array("noid", "source_id"), '', "noid DESC", array(1));
goto AJ6PP;
NdjaQ:
$votenum = 1;
goto T5Yy1;
uA7sC:
//message("获取数据失败", '', "error");
goto awRy0;
DYW0K:
$vheat_max = intval($_GPC["vheat_max"]);
goto vdz2o;
nbueV:
$source_str = $source_arr ? implode(",", $source_arr) : '';
goto XrEA5;
DIZBq:
$reply = pdo_fetch("SELECT saiqustatus FROM " . tablename($this->tablereply) . " WHERE rid = :rid ORDER BY `id` DESC", array(":rid" => $rid));
goto f54Ju;
iHZgy:
$vote_max = $vote_max ? $vote_max : $vote_min + 100;
goto NdjaQ;
dzj79:
$content = ihttp_post($url, $post_data);
goto W8ax2;
wTXg1:
$url = $this->auth_url . "/index/vote/checkauth";
goto tWAuH;
teAiI:
t_7M3:
goto VxiuP;
T5Yy1:
KrHEC:
goto Wu5M4;
W_PXy:
ksort($post_data);
goto x2Ss0;
hyTyO:
message("成功导入" . $cture . "个选手数据", $this->createWebUrl("votelist", array("name" => "silence_vote", "rid" => $rid)), "success");
goto C4Pm9;
Wu5M4:
$tag = intval($_GPC["tag"]);
goto DIjXV;
w016m:
$dataset = json_decode($data_users, true);
goto Dmkqf;
x2Ss0:
$post_data["token"] = md5(sha1(implode('', $post_data)));
goto WAqAc;
Yhuy9:
if (!checksubmit("submit")) {
    goto wpo9w;
}
goto ymqjv;
B4xTM:
$agentlist = pdo_fetchall("select id,username,realname from " . tablename($this->modulename . "_agentlist") . "where uniacid = {$uniacid}");
goto fYtsK;
rc7cp:
$cfg = $this->module["config"];
goto wTXg1;
kT0Ah:
$vheat_min = $vheat_min ? $vheat_min : 1;
goto DYW0K;
VGJae:
$vheat_min = intval($_GPC["vheat_min"]);
goto kT0Ah;
W8ax2:
$result = json_decode($content["content"], true);
goto q2Y5O;
QuTrK:
if (!$list_source) {
    goto bfkam;
}
goto xv6Hm;
WAqAc:
load()->func("communication");
goto dzj79;
ZTMV7:
$vote_min = $vote_min ? $vote_min : 1;
goto Af_5F;
Af_5F:
$vote_max = intval($_GPC["vote_max"]);
goto iHZgy;
RQv_j:
aLeQo:
goto B4xTM;
iofZc:
l6i78:
goto hyTyO;
ymqjv:
$user_max_count = intval($_GPC["user_max_count"]);
goto zFn2c;
jeb_1:
AlMKC:
goto Z8ffI;
ajBRB:
if (!($op == "getusers")) {
    goto aLeQo;
}
goto Yhuy9;
G2YOj:
message("授权错误，请联系客服！", "referer", "error");
goto cwKy3;
T1dRU:
foreach ($list_source as $source) {
    goto OFN96;
    xH5Mr:
    hW0CI:
    goto jPxq7;
    hNjvD:
    v8BQz:
    goto xH5Mr;
    s5W8r:
    $source_arr[] = $source["source_id"];
    goto hNjvD;
    OFN96:
    if (!$source["source_id"]) {
        goto v8BQz;
    }
    goto s5W8r;
    jPxq7:
}
goto jeb_1;
XrEA5:
$data_users = $this->get_cloud_data($tag, $user_max_count, $source_str);
goto oA1rt;
C4Pm9:
wpo9w:
goto RQv_j;
P61uQ:
if (!$rid) {
    goto qKW79;
}
goto DIZBq;
rknkv:
$vote_min = intval($_GPC["vote_min"]);
goto ZTMV7;
w8keH:
V9bx0:
goto teAiI;
vdz2o:
$vheat_max = $vheat_max ? $vheat_max : $vheat_min + 100;
goto ugP2I;
F2GSx:
$rid = intval($_GPC["rid"]);
goto P61uQ;
fYtsK:
$saiqulist = pdo_fetchall("select id,saiquname  from " . tablename($this->modulename . "_saiqu") . "where uniacid = {$uniacid} and rid = '{$rid}'");
goto im0yH;
Z8ffI:
bfkam:
goto nbueV;
ugP2I:
$vheat = 1;
goto zrwNg;
xwFAO:
if (!($_GPC["vote_min"] || $_GPC["vote_max"])) {
    goto KrHEC;
}
goto rknkv;
VxiuP:
global $_W, $_GPC;
goto qXNDR;
K61MD:
$op = $_GPC["op"];
goto F2GSx;
gTvuO:
defined("IN_IA") or exit("Access Denied");
goto rc7cp;
kBtU9:
foreach ($dataset as $v) {
    goto j6LSk;
    IXobh:
    G0LhB:
    goto Vx2NI;
    yCwIj:
    $temp["nickname"] = $v["nickname"];
    goto EfoHJ;
    tQLpF:
    RLAiT:
    goto HamOI;
    aHE7T:
    $img5 = $this->getImage($v["img5"]);
    goto SCWoS;
    qfWRD:
    if (!$v["img2"]) {
        goto zrFit;
    }
    goto O12uz;
    k3ogb:
    $img1 = $this->getImage($v["img1"]);
    goto U3CoE;
    C0oEm:
    if (!$avatar["save_path"]) {
        goto dBtXR;
    }
    goto sICkt;
    iDFQI:
    $temp["noid"] = $noid;
    goto daxlQ;
    hZnHX:
    $avatar = $this->getImage($v["avatar"]);
    goto C0oEm;
    wlAgk:
    $temp["img3"] = $img3["save_path"];
    goto c33IB;
    Cb0UX:
    if (!$v["img3"]) {
        goto SXsqm;
    }
    goto GgcFt;
    SCWoS:
    if (!$img5["save_path"]) {
        goto RLAiT;
    }
    goto kjhlT;
    SPmb9:
    $temp["img2"] = $img2["save_path"];
    goto AnzlO;
    W0gRc:
    $temp["avatar"] = $v["avatar"];
    goto DEFAE;
    yBtzE:
    $temp["img2"] = $v["img2"];
    goto qfWRD;
    Gbpvh:
    pdo_insert($this->modulename . "_voteuser", $temp);
    goto TnKBc;
    U3CoE:
    if (!$img1["save_path"]) {
        goto G0LhB;
    }
    goto OkDwf;
    CBOqo:
    $temp["status"] = $sta;
    goto mEZg2;
    gB4H4:
    if (!$v["img1"]) {
        goto ifaKH;
    }
    goto k3ogb;
    kjhlT:
    $temp["img5"] = $img5["save_path"];
    goto tQLpF;
    AnzlO:
    b8vgt:
    goto P544a;
    sICkt:
    $temp["avatar"] = $avatar["save_path"];
    goto u4Gfb;
    oTdqY:
    if (!$v["img4"]) {
        goto n8m_P;
    }
    goto kO5CC;
    mEZg2:
    $temp["createtime"] = time();
    goto iDFQI;
    zsDTB:
    $temp["introduction"] = $v["introduction"];
    goto VnHbB;
    Vx2NI:
    ifaKH:
    goto yBtzE;
    sgHNa:
    $temp["img3"] = $v["img3"];
    goto Cb0UX;
    Lf1Ma:
    $temp["vheat"] = $vheat ? rand($vheat_min, $vheat_max) : 0;
    goto IeFCV;
    DEFAE:
    if (!$v["avatar"]) {
        goto gD5fD;
    }
    goto hZnHX;
    j6LSk:
    $temp["name"] = $v["name"] ? $v["name"] : $v["nickname"];
    goto yCwIj;
    IjTwK:
    if (!$img4["save_path"]) {
        goto C4Lyv;
    }
    goto QTDgI;
    TnKBc:
    $noid++;
    goto LwdN3;
    fHlIX:
    C4Lyv:
    goto tXCzS;
    LwdN3:
    $cture++;
    goto DksbS;
    dhCIC:
    $temp["source_id"] = $v["id"];
    goto uafXE;
    zIcVF:
    $temp["img4"] = $v["img4"];
    goto oTdqY;
    QTDgI:
    $temp["img4"] = $img4["save_path"];
    goto fHlIX;
    Ka3yn:
    gD5fD:
    goto D2nbm;
    tXCzS:
    n8m_P:
    goto oVidB;
    oVidB:
    $temp["img5"] = $v["img5"];
    goto dQ12R;
    kO5CC:
    $img4 = $this->getImage($v["img4"]);
    goto IjTwK;
    D2nbm:
    $temp["img1"] = $v["img1"];
    goto gB4H4;
    dQ12R:
    if (!$v["img5"]) {
        goto EzMDA;
    }
    goto aHE7T;
    P544a:
    zrFit:
    goto sgHNa;
    O12uz:
    $img2 = $this->getImage($v["img2"]);
    goto VJoJq;
    u4Gfb:
    dBtXR:
    goto Ka3yn;
    G_adr:
    $temp["saiquid"] = intval($_GPC["saiquid"]);
    goto Gbpvh;
    GgcFt:
    $img3 = $this->getImage($v["img3"]);
    goto uQYat;
    uafXE:
    $temp["uniacid"] = $uniacid;
    goto Lf1Ma;
    FUE_Z:
    SXsqm:
    goto zIcVF;
    VnHbB:
    $temp["rid"] = $rid;
    goto dhCIC;
    EfoHJ:
    $re_dir = "images/{$uniacid}/silence_vote/" . date("Y/m/");
    goto W0gRc;
    Zv4ld:
    $sta = $_GPC["sta"] ? 0 : 1;
    goto CBOqo;
    IeFCV:
    $temp["votenum"] = $votenum ? rand($vote_min, $vote_max) : 0;
    goto Zv4ld;
    DksbS:
    EdUZZ:
    goto DdD_1;
    uQYat:
    if (!$img3["save_path"]) {
        goto ZuPJc;
    }
    goto wlAgk;
    HamOI:
    EzMDA:
    goto zsDTB;
    VJoJq:
    if (!$img2["save_path"]) {
        goto b8vgt;
    }
    goto SPmb9;
    c33IB:
    ZuPJc:
    goto FUE_Z;
    OkDwf:
    $temp["img1"] = $img1["save_path"];
    goto IXobh;
    daxlQ:
    $temp["agent_id"] = intval($_GPC["agentid"]);
    goto G_adr;
    DdD_1:
}
goto iofZc;
awRy0:
gK6Zo:
goto w016m;
DIjXV:
$list_source = pdo_fetchall("SELECT * FROM " . tablename($this->tablevoteuser) . " WHERE uniacid = '{$_W["uniacid"]} ' AND rid = '{$rid}' AND source_id>0");
goto QuTrK;
oA1rt:
if (!empty($data_users)) {
    goto gK6Zo;
}
goto uA7sC;
im0yH:
include $this->template("cloudvote");