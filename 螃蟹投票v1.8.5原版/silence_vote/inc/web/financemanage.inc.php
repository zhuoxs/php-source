<?php

goto kVOp4;
UGefh:
if (!$checkrakeback) {
    goto Io0KR;
}
goto ymWNG;
aI08k:
$players = pdo_fetchall("select id,agent_id from " . tablename($this->modulename . "_voteuser") . " WHERE uniacid = {$uniacid} " . $order_condition);
goto laVuS;
BofmD:
if (empty($config["israkeback"])) {
    goto efXgk;
}
goto W8Y5I;
xUyEn:
$condition = " WHERE uniacid = {$uniacid} ";
goto iX4yL;
pOJ3_:
if (empty($keyword)) {
    goto ZMNDB;
}
goto nd3kp;
xkcoD:
$agpl_data = checkdetailfx($leveltwo, $uniacid, "leveltwopercent", $aid);
goto fXMJO;
vwLvs:
$totalfee = array();
goto nsWsy;
oiz7u:
oaEo9:
goto Bskk7;
n3gZ4:
if (!($begin == '')) {
    goto VPStT;
}
goto qizhs;
AYlgu:
ec83F:
goto YnG6N;
BiZdD:
MGjhq:
goto v2dGE;
VX2pN:
$levelone = array();
goto kxOb4;
KJtx4:
VPStT:
goto Jajy8;
djATa:
$ispay = 1;
goto tD_z0;
LEpq0:
$agpl_data = checkdetailfx($levelone, $uniacid, "levelonepercent", $aid);
goto RQRFi;
oMyBM:
//message("授权错误，请联系客服！", "referer", "error");
goto oOuRl;
qsITL:
$end = strtotime($keyword["end"]);
goto JFsHJ;
V_TOB:
$agents = pdo_fetchall($sql, $params);
goto mgzWi;
kVex_:
ZMNDB:
goto WfagM;
JPH6O:
gg5DJ:
goto YQTAs;
fKpSz:
$aid = $_GPC["aid"];
goto pQuXa;
eCb0T:
tDR4c:
goto sd0tj;
LnK56:
if (!($operation == "checkplrw")) {
    goto P_s4K;
}
goto nr9II;
ut6Tk:
$operation = !empty($_GPC["op"]) ? $_GPC["op"] : "agent";
goto Oh232;
cwaNm:
$agentlevel = pdo_fetchcolumn("select agentlevel from " . tablename($this->modulename . "_agentlist") . " where uniacid = {$uniacid} and id = {$aid}");
goto jBzQ8;
W8Y5I:
$checkrakeback = true;
goto nq7lp;
e6rWO:
$end = time();
goto fiVxT;
Ebx6u:
$leveltwo = array();
goto Sdnxh;
XOZfs:
$levelone = array();
goto p5YaL;
REWQM:
$totalfee = array_slice($totalfee, ($pindex - 1) * $psize, $psize, true);
goto u1Oes;
qCIOL:
$msg = '';
goto nNsJb;
hjAPj:
checklogin();
goto ozRDo;
U0OG0:
M8QeU:
goto WRolB;
Etl41:
$keyword = trim($_GPC["keyword"]);
goto YEK3H;
dCUXC:
$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->modulename . "_reply") . $condition . " order by rid desc ");
goto y0bFI;
nOiCo:
if (!($operation == "agent")) {
    goto WpOMs;
}
goto SZSay;
qzHHr:
$cfg = $this->module["config"];
goto nDLVl;
vuTJ5:
vhT5m:
goto P4oM_;
nzc8M:
$fee_one = array();
goto iBWqc;
nDLVl:
$url = $this->auth_url . "/index/vote/checkauth";
goto f3VHu;
PB1vG:
if (empty($keyword)) {
    goto J9Q0X;
}
goto uHMCw;
nv8YV:
giSH4:
goto AtjFo;
eZChZ:
uakFc:
goto Ebx6u;
mK8uK:
jYLqw:
goto n3gZ4;
Ez9mJ:
$player = pdo_fetchall("select * from " . tablename($this->modulename . "_voteuser") . $condition . " order by rid desc " . " LIMIT " . ($pindex - 1) * $psize . "," . $psize);
goto CJjIK;
d7hHL:
$begin = strtotime($keyword["start"]);
goto qsITL;
jBzQ8:
foreach ($ag_pl as $key => $value) {
    goto CZTyb;
    CZTyb:
    $tids = $value["id"];
    goto vTxaS;
    vTxaS:
    $ispay = 1;
    goto JP6tI;
    JP6tI:
    $player_reward = pdo_fetch("SELECT sum(fee) as totalfee ,rid,tid FROM " . tablename($this->modulename . "_gift") . " WHERE tid in ({$tids}) and ispay = {$ispay} and openid != 'addgift' group by rid order by rid DESC");
    goto tCQLI;
    vmg7o:
    $ag_pl[$key]["rewardagentpercent"] = $rewardagentpercent;
    goto eyYwp;
    OlFwU:
    wvtDH:
    goto iVykB;
    r1bo1:
    $ag_pl[$key]["reply_title"] = $replydata["title"];
    goto Ro33T;
    jWw6H:
    $replydata = pdo_fetch("select id,title,rewardagentpercent,arewardpercent from " . tablename($this->modulename . "_reply") . " where rid = {$value["rid"]}");
    goto r1bo1;
    Ro33T:
    $ag_pl[$key]["reply_id"] = $replydata["id"];
    goto FKdcx;
    attus:
    B5t6g:
    goto vmg7o;
    HPeOo:
    if (array_key_exists($agentlevel, $arewper)) {
        goto wvtDH;
    }
    goto w1inc;
    w1inc:
    $rewardagentpercent = $replydata["rewardagentpercent"];
    goto GvLog;
    tCQLI:
    $ag_pl[$key]["totalfee"] = $player_reward["totalfee"] ?: 0;
    goto jWw6H;
    GvLog:
    goto B5t6g;
    goto OlFwU;
    FKdcx:
    $arewper = @unserialize($replydata["arewardpercent"]);
    goto HPeOo;
    eyYwp:
    hhMEB:
    goto WSzny;
    iVykB:
    $rewardagentpercent = $arewper[$agentlevel];
    goto attus;
    WSzny:
}
goto EoI04;
iBWqc:
if (!$checkrakeback) {
    goto MGjhq;
}
goto XSnNo;
nr9II:
$aid = $_GPC["aid"];
goto sk9Zn;
y10Jr:
$levelthree = array();
goto Bpn3r;
cJnOR:
foreach ($leveltwo as $k => $v) {
    $fee_two[$k] = checkfenxiao($v, $aid = $k, $pername = "leveltwopercent", $uniacid);
    WInAs:
}
goto hAzem;
LMv7a:
$leveltwo = array();
goto y10Jr;
Oh232:
$uniacid = !empty($_W["uniacid"]) ? $_W["uniacid"] : intval($_GET["uniacid"]);
goto Wv0QK;
cBTwz:
foreach ($totalfee as $key => $value) {
    goto B4vX_;
    LMtcu:
    foreach ($fee_two as $k => &$v) {
        goto eURQG;
        Vc8Y6:
        unset($fee_two[$k]);
        goto eytmn;
        MLjsw:
        CrX5z:
        goto BfIvp;
        eytmn:
        goto SlBtj;
        goto Hu24f;
        eURQG:
        if (!($value["agent_id"] == $v["agent_id"])) {
            goto Uzi_K;
        }
        goto kEbAe;
        Hu24f:
        Uzi_K:
        goto MLjsw;
        kEbAe:
        $totalfee[$key]["fee_two"] = $v["leveltwopercentfee"];
        goto Vc8Y6;
        BfIvp:
    }
    goto oVHke;
    fO60s:
    $totalfee[$key]["fee_one"] = 0;
    goto ruzX2;
    s8W1S:
    $totalfee[$key]["fee_three"] = 0;
    goto u4LRh;
    ruzX2:
    $totalfee[$key]["fee_two"] = 0;
    goto s8W1S;
    YOyeM:
    PAH8s:
    goto EQNZP;
    pwbsD:
    gmktk:
    goto LMtcu;
    B4vX_:
    $name = pdo_fetch("select username,realname,phonenum from " . tablename($this->modulename . "_agentlist") . " where id = {$value["agent_id"]} ");
    goto MCIZ5;
    TfstS:
    foreach ($fee_three as $k => &$v) {
        goto zgiyY;
        zgiyY:
        if (!($value["agent_id"] == $v["agent_id"])) {
            goto sMDRR;
        }
        goto vdxrr;
        mPOgI:
        EG9i3:
        goto hxoxT;
        iKKAS:
        unset($fee_three[$k]);
        goto NLnid;
        Guivk:
        sMDRR:
        goto mPOgI;
        NLnid:
        goto hEm9v;
        goto Guivk;
        vdxrr:
        $totalfee[$key]["fee_three"] = $v["levelthreepercentfee"];
        goto iKKAS;
        hxoxT:
    }
    goto FIDq1;
    VbD70:
    $totalfee[$key]["phonenum"] = $name["phonenum"];
    goto fO60s;
    u4LRh:
    foreach ($fee_one as $k => &$v) {
        goto zw9kL;
        JsVuJ:
        unset($fee_one[$k]);
        goto KPUhd;
        U8IRE:
        kD6z0:
        goto mw6uj;
        KPUhd:
        goto gmktk;
        goto U8IRE;
        zw9kL:
        if (!($value["agent_id"] == $v["agent_id"])) {
            goto kD6z0;
        }
        goto hfiet;
        mw6uj:
        HuVoi:
        goto gma76;
        hfiet:
        $totalfee[$key]["fee_one"] = $v["levelonepercentfee"];
        goto JsVuJ;
        gma76:
    }
    goto pwbsD;
    oVHke:
    SlBtj:
    goto TfstS;
    FIDq1:
    hEm9v:
    goto YOyeM;
    BVoRq:
    $totalfee[$key]["realname"] = $name["realname"];
    goto VbD70;
    MCIZ5:
    $totalfee[$key]["username"] = $name["username"];
    goto BVoRq;
    EQNZP:
}
goto JPH6O;
noUFG:
$config = $this->module["config"];
goto BofmD;
Ib3XX:
$checkrakeback = false;
goto i3oQQ;
MRWXT:
$sql = "SELECT id,agentrecommend FROM " . tablename($this->modulename . "_agentlist") . $condition . $order_condition;
goto XA_yj;
M3o7c:
load()->func("communication");
goto dioq5;
gTZCR:
if (!($operation == "checkfeetwo")) {
    goto nuueK;
}
goto wG5mE;
GC6ws:
$psize = 15;
goto xRpgh;
Ezzju:
$timezone = pdo_fetch("select max(createtime) as maxtime,min(createtime) as mintime ,sum(fee) as totalfee,sum(giftcount) as totalcount from " . tablename($this->modulename . "_gift") . $condition . " order by rid desc ");
goto gH1N_;
v2dGE:
$fee_two = array();
goto JpS7V;
YyW1q:
$psize = 15;
goto Etl41;
QOQAe:
echo json_encode($msg);
goto uHYF5;
UwqCn:
include $this->template("finance_manage");
goto oQG0L;
U6B9M:
foreach ($data as $v) {
    $msg .= "礼物名称：" . $v["gifttitle"] . " 数量：" . $v["count"] . " 价值：" . $v["totalfee"] . " \r\n";
    VNQ9o:
}
goto kqxH_;
n_k9Q:
P_s4K:
goto AMpzi;
Q8awP:
foreach ($leveltwo as $k => $v) {
    goto v1x2o;
    qJmyy:
    AS9Oc:
    goto qfM3h;
    cvmyO:
    boApg:
    goto qJmyy;
    v1x2o:
    foreach ($agents as $kk => $vv) {
        goto d0WqU;
        d0WqU:
        foreach ($v as $kkk => $value) {
            goto RhaxK;
            VGY3G:
            $levelthree[$k][] = $vv["id"];
            goto VgWKI;
            Orceo:
            y00_6:
            goto KfVtG;
            VgWKI:
            lxnFm:
            goto Orceo;
            RhaxK:
            if (!($vv["agentrecommend"] == $value)) {
                goto lxnFm;
            }
            goto VGY3G;
            KfVtG:
        }
        goto bQYIe;
        bQYIe:
        ookjA:
        goto vC4n9;
        vC4n9:
        aIq1D:
        goto UVHeZ;
        UVHeZ:
    }
    goto cvmyO;
    qfM3h:
}
goto kjV9r;
ymWNG:
foreach ($levelthree as $k => $v) {
    $fee_three[$k] = checkfenxiao($v, $aid = $k, $pername = "levelthreepercent", $uniacid);
    btw13:
}
goto vuTJ5;
sd0tj:
$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->modulename . "_voteuser") . $condition . " order by rid desc ");
goto iChWX;
yhZSv:
$post_data["token"] = md5(sha1(implode('', $post_data)));
goto M3o7c;
ZvXNn:
$agents = pdo_fetchall($sql, $params);
goto XOZfs;
lXnig:
$pindex = max(1, intval($_GPC["page"]));
goto cvlIc;
NgFBW:
$levelone = array();
goto LMv7a;
gH1N_:
$total = 1;
goto FbxJr;
JpS7V:
if (!$checkrakeback) {
    goto HMP3g;
}
goto cJnOR;
RGEF5:
DyP0d:
goto BiZdD;
cvlIc:
$psize = 15;
goto RPb0N;
nd3kp:
$condition .= " AND activecode LIKE '%{$keyword}%'";
goto kVex_;
DC51J:
NrtQN:
goto noUFG;
mHMuh:
$params[":keyword"] = "%{$keyword}%";
goto fzj8E;
kjV9r:
nEJa_:
goto vwLvs;
kuzd0:
$agents = pdo_fetchall($sql, $params);
goto aI08k;
laVuS:
$ag_pl = array();
goto NgFBW;
KzHCd:
HMP3g:
goto UrIX4;
LuJ8X:
Pcb2a:
goto mv2HD;
tZxxU:
$_W["page"]["title"] = "财务管理";
goto qzHHr;
YnG6N:
$leveltwo = array();
goto jGkRf;
fzj8E:
J9Q0X:
goto I2qJc;
kZDKS:
NSHl9:
goto Ez9mJ;
DrHPi:
$condition .= "and ispay = {$ispay} and openid != 'addgift'";
goto Ezzju;
kVOp4:
defined("IN_IA") or exit("Access Denied");
goto A1DpS;
k1aRA:
foreach ($levelone as $k => $v) {
    goto ZqOZm;
    ZqOZm:
    foreach ($agents as $kk => $vv) {
        goto oo_IL;
        SuuUL:
        CEfFn:
        goto hfqAR;
        oo_IL:
        foreach ($v as $kkk => $value) {
            goto rfTC0;
            rfTC0:
            if (!($vv["agentrecommend"] == $value)) {
                goto zZ4cw;
            }
            goto f7ksU;
            NAiWn:
            tGGEw:
            goto pq0GV;
            f7ksU:
            $leveltwo[$k][] = $vv["id"];
            goto mcx0b;
            mcx0b:
            zZ4cw:
            goto NAiWn;
            pq0GV:
        }
        goto SuuUL;
        hfqAR:
        V1c_Y:
        goto Nrl1x;
        Nrl1x:
    }
    goto vTVpr;
    zno08:
    WIiZg:
    goto kjabx;
    vTVpr:
    aUAp4:
    goto zno08;
    kjabx:
}
goto QUWsR;
RPb0N:
$keyword = trim($_GPC["keyword"]);
goto pOJ3_;
xRpgh:
$keyword = trim($_GPC["keyword"]);
goto PB1vG;
QUWsR:
gPpfk:
goto Q8awP;
U3ttf:
WpOMs:
goto LnK56;
Jajy8:
if (!($end == '')) {
    goto dpM3E;
}
goto e6rWO;
qizhs:
$begin = strtotime("last month");
goto KJtx4;
AMpzi:
if (!($operation == "checkfeeone")) {
    goto XyoQQ;
}
goto bYcwj;
iCaKd:
$keyword = $_GPC["time"];
goto i2YDf;
SZSay:
$pindex = max(1, intval($_GPC["page"]));
goto GC6ws;
oQG0L:
function checkfenxiao($ids = array(), $aid = 0, $pername = '', $uniacid)
{
    goto F__iL;
    F__iL:
    $order_condition = " ORDER BY id ASC ";
    goto HE31w;
    HE31w:
    $condition = " WHERE uniacid = {$uniacid} ";
    goto WeTr6;
    cBMdJ:
    $agentlevel = pdo_fetchcolumn("select agentlevel from " . tablename("silence_vote_agentlist") . " where uniacid = {$uniacid} and id = {$aid}");
    goto jx_UZ;
    tzKc5:
    goto C4fkc;
    goto W11v3;
    s4NI7:
    if ($pername == "levelthreepercent") {
        goto WgDdX;
    }
    goto fDvOW;
    nNUxI:
    foreach ($ag_pl as $key => $value) {
        goto bKukM;
        iYWbe:
        foreach ($player_reward as $k => $v) {
            goto ZHlsg;
            WBj1Q:
            $percent = $alper[$agentlevel][$alkey] ?: 0;
            goto Nz0bS;
            ZHlsg:
            $alper = pdo_fetchcolumn("select alevelpercent from " . tablename("silence_vote_reply") . " where rid = {$v["rid"]} and rakebacklevel >= {$rakeback}");
            goto Z2JmN;
            cQn9X:
            $percent = pdo_fetchcolumn("select {$pername} from " . tablename("silence_vote_reply") . " where rid = {$v["rid"]} and rakebacklevel >= {$rakeback}");
            goto JbMN2;
            oMjzm:
            $reward += $m;
            goto sbs3k;
            JbMN2:
            goto kXtjy;
            goto ZuXGm;
            Nz0bS:
            kXtjy:
            goto jHH3_;
            ZuXGm:
            lem43:
            goto WBj1Q;
            Z2JmN:
            $alper = @unserialize($alper) ?: array();
            goto HArGt;
            HArGt:
            if (array_key_exists($agentlevel, $alper)) {
                goto lem43;
            }
            goto cQn9X;
            jHH3_:
            $m = $percent ? sprintf("%.2f", $v["totalfee"] * ($percent / 100)) : 0;
            goto oMjzm;
            sbs3k:
            MdsKE:
            goto hxzUX;
            hxzUX:
        }
        goto bd47M;
        AbpeM:
        $totalfee += $reward;
        goto lD6T1;
        bKukM:
        $tids = join(",", $value);
        goto FIeww;
        FIeww:
        $ispay = 1;
        goto hPe2k;
        hPe2k:
        $player_reward = pdo_fetchall("SELECT sum(fee) as totalfee,rid FROM " . tablename("silence_vote_gift") . " WHERE tid in ({$tids}) and ispay = {$ispay} and openid != 'addgift' group by rid order by rid DESC");
        goto F04LF;
        lD6T1:
        BLFiF:
        goto rV1iS;
        F04LF:
        $reward = 0;
        goto iYWbe;
        bd47M:
        kPGNs:
        goto AbpeM;
        rV1iS:
    }
    goto gs1y7;
    jx_UZ:
    $sql = "SELECT id FROM " . tablename("silence_vote_agentlist") . $condition . $order_condition;
    goto Ug1Sn;
    fDvOW:
    $rakeback = 1;
    goto rG3cY;
    NxpGo:
    return $fee;
    goto g9eQ5;
    rG3cY:
    $alkey = "l1";
    goto NdrOR;
    fyG03:
    $fee = array("agent_id" => $aid, $pername . "fee" => $totalfee);
    goto NxpGo;
    YoPME:
    GYh7G:
    goto DCgkm;
    R4KVv:
    $alkey = "l2";
    goto tzKc5;
    W11v3:
    WgDdX:
    goto cy5vz;
    P2I1P:
    $ag_pl = array();
    goto vNgla;
    WeTr6:
    if ($pername == "leveltwopercent") {
        goto GYh7G;
    }
    goto s4NI7;
    arcrY:
    $alkey = "l3";
    goto dJwo4;
    lkgfX:
    ni01a:
    goto xKgXx;
    gs1y7:
    lTnY9:
    goto fyG03;
    Ug1Sn:
    $agents = pdo_fetchall($sql, $params);
    goto vMCDL;
    NdrOR:
    goto C4fkc;
    goto YoPME;
    vNgla:
    foreach ($ids as $v) {
        goto vWK4B;
        zvCsn:
        GUrty:
        goto zUD87;
        vWK4B:
        foreach ($players as $key => $val) {
            goto cBykl;
            ddiP9:
            unset($players[$key]);
            goto ooPlJ;
            b03Ou:
            SW_Up:
            goto kATaz;
            ooPlJ:
            Dvz8Q:
            goto b03Ou;
            cBykl:
            if (!($v == $val["agent_id"])) {
                goto Dvz8Q;
            }
            goto J59OH;
            J59OH:
            $ag_pl[$v][] = $val["id"];
            goto ddiP9;
            kATaz:
        }
        goto zvCsn;
        zUD87:
        AqO7X:
        goto aiy38;
        aiy38:
    }
    goto lkgfX;
    xKgXx:
    $totalfee = 0;
    goto nNUxI;
    DCgkm:
    $rakeback = 2;
    goto R4KVv;
    vMCDL:
    $players = pdo_fetchall("select id,agent_id from " . tablename("silence_vote_voteuser") . $condition . $order_condition);
    goto P2I1P;
    dJwo4:
    C4fkc:
    goto cBMdJ;
    cy5vz:
    $rakeback = 3;
    goto arcrY;
    g9eQ5:
}
goto fgFry;
KendU:
$id = $_GPC["id"];
goto qCIOL;
tD_z0:
foreach ($active as $key => $value) {
    goto TqdJC;
    zGE2l:
    jOD2U:
    goto sxoGq;
    ugq6k:
    $active[$key]["gift"] = $gift["totalcount"] ? $gift : array("totalfee" => 0, "totalcount" => 0);
    goto zGE2l;
    TqdJC:
    $gift = pdo_fetch("select sum(fee) as totalfee,sum(giftcount) as totalcount from " . tablename($this->modulename . "_gift") . "where rid = {$value["rid"]} and ispay = {$ispay} and openid != 'addgift'");
    goto ugq6k;
    sxoGq:
}
goto rQaM5;
Wv0QK:
$order_condition = " ORDER BY id ASC ";
goto xUyEn;
nq7lp:
goto BjaX8;
goto Z1Eb9;
Bskk7:
if (!($operation == "playerdetail")) {
    goto gFJJ8;
}
goto KendU;
XA_yj:
$agents = pdo_fetchall($sql, $params);
goto VX2pN;
cIBmZ:
CftDO:
goto Kcu0X;
m3c2V:
if (!($operation == "player")) {
    goto oaEo9;
}
goto OK0h9;
P4oM_:
Io0KR:
goto cBTwz;
sk9Zn:
$ag_pl = pdo_fetchall("select id,agent_id,nickname,name,rid from " . tablename($this->modulename . "_voteuser") . " WHERE uniacid = {$uniacid} and agent_id = {$aid} " . $order_condition);
goto cwaNm;
hAzem:
LbuCH:
goto KzHCd;
p36pv:
if (!($operation == "checkfeethree")) {
    goto tJlK1;
}
goto fKpSz;
Sdnxh:
foreach ($levelone as $k => $v) {
    goto bEJYK;
    yl1Qm:
    QurvG:
    goto by2vj;
    bEJYK:
    foreach ($agents as $kk => $vv) {
        goto s14GC;
        s14GC:
        if (!($vv["agentrecommend"] == $v)) {
            goto IydWD;
        }
        goto SYfno;
        b7kgT:
        IydWD:
        goto fZ3ww;
        SYfno:
        $leveltwo[] = $vv["id"];
        goto b7kgT;
        fZ3ww:
        J8w_5:
        goto f3Txg;
        f3Txg:
    }
    goto uZWoh;
    uZWoh:
    C6Cl3:
    goto yl1Qm;
    by2vj:
}
goto uIFMb;
vdtCQ:
ksort($post_data);
goto yhZSv;
VPASd:
$result = json_decode($content["content"], true);
goto QK1K3;
kxOb4:
foreach ($agents as $kk => $vv) {
    goto jw3LX;
    txBEI:
    SprRr:
    goto jFV_v;
    jFV_v:
    HN5Fh:
    goto Cgc8W;
    jw3LX:
    if (!($vv["agentrecommend"] == $aid)) {
        goto SprRr;
    }
    goto wDGBb;
    wDGBb:
    $levelone[] = $vv["id"];
    goto txBEI;
    Cgc8W:
}
goto eZChZ;
NcBzH:
$condition .= " AND name LIKE '%{$keyword}%'";
goto kZDKS;
RQRFi:
XyoQQ:
goto gTZCR;
CJjIK:
$ispay = 1;
goto kW8UM;
rQaM5:
khYac:
goto dCUXC;
zV_xX:
gFJJ8:
goto dP8Zl;
vM8Bl:
$ispay = 1;
goto DrHPi;
JFsHJ:
$condition .= " AND createtime >= {$begin} and createtime <= {$end} ";
goto mK8uK;
oOuRl:
goto EXMLT;
goto LuJ8X;
FbxJr:
O4bBw:
goto UwqCn;
ozRDo:
load()->func("tpl");
goto tZxxU;
QK1K3:
if ($result["sta"]) {
    goto Pcb2a;
}
goto oMyBM;
YQTAs:
$total = count($totalfee);
goto REWQM;
i3oQQ:
BjaX8:
goto nzc8M;
EoI04:
omrv0:
goto n_k9Q;
uIFMb:
GRUMZ:
goto xkcoD;
uHYF5:
exit;
goto zV_xX;
iX4yL:
$params = array();
goto nOiCo;
uHMCw:
$condition .= " AND realname LIKE :keyword";
goto mHMuh;
UrIX4:
$fee_three = array();
goto UGefh;
I2qJc:
$sql = "SELECT id,agentrecommend FROM " . tablename($this->modulename . "_agentlist") . $condition . $order_condition;
goto kuzd0;
jGkRf:
foreach ($levelone as $k => $v) {
    goto zPxQ9;
    zPxQ9:
    foreach ($agents as $kk => $vv) {
        goto RXSyg;
        ZmIYe:
        DxC9d:
        goto zduNA;
        rwNTh:
        $leveltwo[] = $vv["id"];
        goto ZmIYe;
        zduNA:
        mkYyt:
        goto F6Qrh;
        RXSyg:
        if (!($vv["agentrecommend"] == $v)) {
            goto DxC9d;
        }
        goto rwNTh;
        F6Qrh:
    }
    goto uHXTd;
    uHXTd:
    wDNk3:
    goto gfQqU;
    gfQqU:
    BMJln:
    goto SLo1m;
    SLo1m:
}
goto cIBmZ;
wG5mE:
$aid = $_GPC["aid"];
goto MRWXT;
fiVxT:
dpM3E:
goto vM8Bl;
bYcwj:
$aid = $_GPC["aid"];
goto aQtaB;
y0bFI:
$pager = pagination($total, $pindex, $psize);
goto nv8YV;
WfagM:
$active = pdo_fetchall("select * from " . tablename($this->modulename . "_reply") . $condition . " order by rid desc " . " LIMIT " . ($pindex - 1) * $psize . "," . $psize);
goto djATa;
WRolB:
$agpl_data = checkdetailfx($levelthree, $uniacid, "levelthreepercent", $aid);
goto TcvKU;
kW8UM:
foreach ($player as $key => $value) {
    goto WmyHl;
    WmyHl:
    $gift = pdo_fetch("select sum(fee) as totalfee,sum(giftcount) as totalcount from " . tablename($this->modulename . "_gift") . "where tid = {$value["id"]} and ispay = {$ispay} and openid != 'addgift' ");
    goto xyjt1;
    Cew7q:
    o3Zin:
    goto SSzlT;
    xyjt1:
    $player[$key]["gift"] = $gift["totalcount"] ? $gift : array("totalfee" => 0, "totalcount" => 0);
    goto Cew7q;
    SSzlT:
}
goto eCb0T;
nsWsy:
foreach ($ag_pl as $key => $value) {
    goto yqmoL;
    h4x77:
    xLzPI:
    goto nQOax;
    QLK4b:
    $totalfee[$key] = ["agent_id" => $key, "playerreward" => $reward];
    goto h4x77;
    qmBRw:
    $reward = 0;
    goto iFOUF;
    zQa_q:
    M7J8W:
    goto QLK4b;
    pgMYv:
    $player_reward = pdo_fetchall("SELECT sum(fee) as totalfee,rid FROM " . tablename($this->modulename . "_gift") . " WHERE tid in ({$tids}) and ispay = {$ispay} and openid != 'addgift' group by rid order by rid DESC");
    goto qmBRw;
    OXide:
    foreach ($player_reward as $k => $v) {
        goto N5hDU;
        CEwAg:
        $reward += $m;
        goto NUaK0;
        Y9ReP:
        if (array_key_exists($agentlevel, $arewper)) {
            goto EjzK0;
        }
        goto ftoXH;
        NUaK0:
        DD_Qo:
        goto nBEeM;
        CHfcN:
        EjzK0:
        goto MWoGB;
        N5hDU:
        $arewper = pdo_fetchcolumn("select arewardpercent from " . tablename($this->modulename . "_reply") . " where rid = {$v["rid"]}");
        goto gIbK6;
        fOefp:
        $m = sprintf("%.2f", $v["totalfee"] * ($rewardagentpercent / 100));
        goto CEwAg;
        ftoXH:
        $rewardagentpercent = pdo_fetchcolumn("select rewardagentpercent from " . tablename($this->modulename . "_reply") . " where rid = {$v["rid"]}");
        goto aEWze;
        gIbK6:
        $arewper = @unserialize($arewper) ?: array();
        goto Y9ReP;
        Gbt9g:
        ehRSK:
        goto fOefp;
        aEWze:
        goto ehRSK;
        goto CHfcN;
        MWoGB:
        $rewardagentpercent = $arewper[$agentlevel];
        goto Gbt9g;
        nBEeM:
    }
    goto zQa_q;
    yqmoL:
    $tids = join(",", $value) ?: 0;
    goto E3REs;
    E3REs:
    $ispay = 1;
    goto pgMYv;
    iFOUF:
    $agentlevel = pdo_fetchcolumn("select agentlevel from " . tablename($this->modulename . "_agentlist") . " where uniacid = {$uniacid} and id = {$key}");
    goto OXide;
    nQOax:
}
goto DC51J;
Bpn3r:
foreach ($agents as $v) {
    goto hKlUf;
    GEx1k:
    l2jn6:
    goto LibxW;
    onTZt:
    vFh4l:
    goto GEx1k;
    hKlUf:
    foreach ($players as $key => $val) {
        goto v1K3b;
        kde0H:
        f5L1V:
        goto LaZyD;
        uOXDa:
        unset($players[$key]);
        goto kde0H;
        PeyPr:
        goto f5L1V;
        goto pzHWL;
        v1K3b:
        if ($v["id"] == $val["agent_id"]) {
            goto cZ__m;
        }
        goto clZJh;
        clZJh:
        $ag_pl[$v["id"]][] = 0;
        goto PeyPr;
        pzHWL:
        cZ__m:
        goto SXXc5;
        SXXc5:
        $ag_pl[$v["id"]][] = $val["id"];
        goto uOXDa;
        LaZyD:
        yBepx:
        goto kRuIo;
        kRuIo:
    }
    goto zq7yl;
    DLKTD:
    foreach ($agents as $kk => $vv) {
        goto fjADZ;
        fjADZ:
        if (!($vv["agentrecommend"] == $v["id"])) {
            goto snagP;
        }
        goto j3l3k;
        tUFzW:
        snagP:
        goto C01IU;
        C01IU:
        sLCSI:
        goto AVPLf;
        j3l3k:
        $levelone[$v["id"]][] = $vv["id"];
        goto tUFzW;
        AVPLf:
    }
    goto onTZt;
    zq7yl:
    fu92g:
    goto DLKTD;
    LibxW:
}
goto Hso1c;
Pxdpl:
foreach ($agents as $kk => $vv) {
    goto z0yk0;
    ylYUx:
    DW5Rn:
    goto AXMm1;
    z0yk0:
    if (!($vv["agentrecommend"] == $aid)) {
        goto DW5Rn;
    }
    goto uc3I8;
    uc3I8:
    $levelone[] = $vv["id"];
    goto ylYUx;
    AXMm1:
    s7YeG:
    goto S4pvE;
    S4pvE:
}
goto FVUA2;
FVUA2:
cJQJu:
goto LEpq0;
kqxH_:
xwZzb:
goto QOQAe;
p5YaL:
foreach ($agents as $kk => $vv) {
    goto xkj7e;
    xkj7e:
    if (!($vv["agentrecommend"] == $aid)) {
        goto J8xiN;
    }
    goto mMGM9;
    T56gw:
    Hhgrz:
    goto cy1h8;
    qy7Lz:
    J8xiN:
    goto T56gw;
    mMGM9:
    $levelone[] = $vv["id"];
    goto qy7Lz;
    cy1h8:
}
goto AYlgu;
mv2HD:
EXMLT:
goto ut6Tk;
YEK3H:
if (empty($keyword)) {
    goto NSHl9;
}
goto NcBzH;
Z1Eb9:
efXgk:
goto Ib3XX;
XSnNo:
foreach ($levelone as $k => $v) {
    $fee_one[$k] = checkfenxiao($v, $aid = $k, $pername = "levelonepercent", $uniacid);
    MSrs0:
}
goto RGEF5;
aQtaB:
$sql = "SELECT id,agentrecommend FROM " . tablename($this->modulename . "_agentlist") . $condition . $order_condition;
goto V_TOB;
TcvKU:
tJlK1:
goto m3c2V;
iChWX:
$pager = pagination($total, $pindex, $psize);
goto oiz7u;
hjRft:
foreach ($leveltwo as $k => $v) {
    goto TcjgL;
    TcjgL:
    foreach ($agents as $kk => $vv) {
        goto DRnzu;
        fIWhH:
        $levelthree[] = $vv["id"];
        goto uSqhg;
        uSqhg:
        W6Vrs:
        goto M2jtM;
        M2jtM:
        fmGoM:
        goto CfPpI;
        DRnzu:
        if (!($vv["agentrecommend"] == $v)) {
            goto W6Vrs;
        }
        goto fIWhH;
        CfPpI:
    }
    goto NpT3y;
    NpT3y:
    JPUNO:
    goto sgi4Y;
    sgi4Y:
    f3EYI:
    goto hoMak;
    hoMak:
}
goto U0OG0;
fXMJO:
nuueK:
goto p36pv;
Hso1c:
Df_iK:
goto k1aRA;
pQuXa:
$sql = "SELECT id,agentrecommend FROM " . tablename($this->modulename . "_agentlist") . $condition . $order_condition;
goto ZvXNn;
OK0h9:
$pindex = max(1, intval($_GPC["page"]));
goto YyW1q;
i2YDf:
if (empty($keyword)) {
    goto jYLqw;
}
goto d7hHL;
dP8Zl:
if (!($operation == "active")) {
    goto giSH4;
}
goto lXnig;
f3VHu:
$post_data = array("time" => time(), "ticket" => $cfg["ticket"], "module_id" => 3);
goto vdtCQ;
dioq5:
$content = ihttp_post($url, $post_data);
goto VPASd;
nNsJb:
$data = pdo_fetchall("select sum(fee) as totalfee,sum(giftcount) as count,gifttitle from " . tablename($this->modulename . "_gift") . " where tid = {$id} and openid != 'addgift' group by gifttitle");
goto U6B9M;
u1Oes:
$pager = pagination($total, $pindex, $psize);
goto U3ttf;
Kcu0X:
$levelthree = array();
goto hjRft;
mgzWi:
$levelone = array();
goto Pxdpl;
A1DpS:
global $_W, $_GPC;
goto hjAPj;
AtjFo:
if (!($operation == "timezone")) {
    goto O4bBw;
}
goto iCaKd;
fgFry:
function checkdetailfx($childag = array(), $uniacid = 0, $pername, $aid = 0)
{
    goto d30KQ;
    BAacq:
    $alkey = "l3";
    goto rmZrG;
    RgEiB:
    foreach ($childag as $key => $v) {
        goto kniT1;
        TeTr6:
        $agpl_data[$v]["player"] = $ag_pl;
        goto CUBjl;
        oXe1K:
        $ag_pl = pdo_fetchall("select id,agent_id,nickname,name,rid from " . tablename("silence_vote_voteuser") . " WHERE uniacid = {$uniacid} and agent_id = {$v} " . $order_condition);
        goto RHeUP;
        kniT1:
        $ag_data = pdo_fetch("select id,username,realname from " . tablename("silence_vote_agentlist") . "where id = {$v}");
        goto oXe1K;
        CUBjl:
        $agpl_data[$v]["agent"] = $ag_data;
        goto Ut7l2;
        Ut7l2:
        iCjzK:
        goto hb5rA;
        RHeUP:
        foreach ($ag_pl as $key => $value) {
            goto Y5hyD;
            rAdek:
            $ag_pl[$key]["totalfee"] = $player_reward["totalfee"] ? $player_reward["totalfee"] : 0;
            goto MgcQq;
            Y5hyD:
            $tids = $value["id"];
            goto Jn3wR;
            cpKFw:
            $player_reward = pdo_fetch("SELECT sum(fee) as totalfee ,rid,tid FROM " . tablename("silence_vote_gift") . " WHERE tid in ({$tids}) and ispay = {$ispay} and openid != 'addgift' group by rid order by rid DESC");
            goto rAdek;
            Jn3wR:
            $ispay = 1;
            goto cpKFw;
            ERTRa:
            $percent = $replydata[$pername];
            goto dE_Vu;
            MgcQq:
            $replydata = pdo_fetch("select id,title,{$pername},rakebacklevel,alevelpercent from " . tablename("silence_vote_reply") . " where rid = {$value["rid"]}");
            goto X3ejy;
            PRGT2:
            if (array_key_exists($agentlevel, $alper)) {
                goto gQtwW;
            }
            goto ERTRa;
            v05YB:
            $ag_pl[$key][$pername] = $percent;
            goto ocDIP;
            egjIw:
            $alper = $replydata["alevelpercent"];
            goto sgPm4;
            dE_Vu:
            goto E485s;
            goto Iyh3m;
            eGmg5:
            $ag_pl[$key]["reply_id"] = $replydata["id"];
            goto l2KP2;
            lHHnd:
            $percent = $alper[$agentlevel][$alkey] ?: 0;
            goto rWBCg;
            X3ejy:
            $ag_pl[$key]["reply_title"] = $replydata["title"];
            goto eGmg5;
            l2KP2:
            $ag_pl[$key]["reply_rakebacklevel"] = $replydata["rakebacklevel"];
            goto egjIw;
            sgPm4:
            $alper = @unserialize($alper) ?: array();
            goto PRGT2;
            rWBCg:
            E485s:
            goto v05YB;
            ocDIP:
            W9W43:
            goto YHgZh;
            Iyh3m:
            gQtwW:
            goto lHHnd;
            YHgZh:
        }
        goto QWQns;
        QWQns:
        g2mpR:
        goto TeTr6;
        hb5rA:
    }
    goto k8rpj;
    PyeU5:
    return $agpl_data;
    goto IHlot;
    FIO5t:
    $condition = " WHERE uniacid = {$uniacid} ";
    goto KLW_T;
    EWbBq:
    $rakeback = 3;
    goto BAacq;
    KLW_T:
    $agentlevel = pdo_fetchcolumn("select agentlevel from " . tablename("silence_vote_agentlist") . " where uniacid = {$uniacid} and id = {$aid}");
    goto deZwJ;
    deZwJ:
    if ($pername == "leveltwopercent") {
        goto jj6rU;
    }
    goto juAjd;
    JhyhL:
    goto CpPry;
    goto LM0m0;
    uW7gt:
    fxZhm:
    goto EWbBq;
    juAjd:
    if ($pername == "levelthreepercent") {
        goto fxZhm;
    }
    goto KBF5b;
    Prprt:
    $alkey = "l2";
    goto i_dVW;
    d30KQ:
    $order_condition = " ORDER BY id ASC ";
    goto FIO5t;
    KBF5b:
    $rakeback = 1;
    goto zRj1W;
    zRj1W:
    $alkey = "l1";
    goto JhyhL;
    k8rpj:
    wov7w:
    goto PyeU5;
    i_dVW:
    goto CpPry;
    goto uW7gt;
    C8gC2:
    $rakeback = 2;
    goto Prprt;
    rmZrG:
    CpPry:
    goto RgEiB;
    LM0m0:
    jj6rU:
    goto C8gC2;
    IHlot:
}