<?php

goto Z8o_T;
mlzkg:
unset($reply["config"]);
goto xno3y;
fqnlp:
$this->authorization();
goto Y3UlM;
Z8o_T:
defined("IN_IA") or exit("Access Denied");
goto bkUR_;
YYME3:
POr7u:
goto yxJ3c;
bkUR_:
global $_GPC, $_W;
goto fqnlp;
xno3y:
$list = pdo_fetchall("SELECT tid,openid,ptid,fee,giftvote,ispay FROM " . tablename($this->tablegift) . "  WHERE uniacid=:uniacid AND rid = :rid AND ptid!='' AND ispay=0  AND openid != 'addgift' ", array(":uniacid" => $uniacid, "rid" => $rid));
goto TctOK;
PgI2T:
$rid = intval($_GPC["rid"]);
goto AaktB;
MQ1SI:
$reply = @array_merge($reply, unserialize($reply["config"]));
goto mlzkg;
AaktB:
$reply = pdo_fetch("SELECT config FROM " . tablename($this->tablereply) . " WHERE rid = :rid ", array(":rid" => $rid));
goto MQ1SI;
TctOK:
$verifynum = 0;
goto HnIFm;
HnIFm:
foreach ($list as $key => $value) {
    goto q0Al_;
    pnCSx:
    W6mX5:
    goto g7nGR;
    gTpAJ:
    if (!$resetvote) {
        goto GLWbU;
    }
    goto TzN6d;
    mhqmc:
    m("present")->upcredit($value["openid"], $reply["giftgive_type"], $reply["giftgive_num"] * $paylog["fee"], "silence_vote");
    goto RmcSb;
    VyTtY:
    GLWbU:
    goto XaBO7;
    Yl1IM:
    $resetvote = pdo_query($setvotesql);
    goto gTpAJ;
    TzN6d:
    $verifynum++;
    goto br4m2;
    XSof3:
    m("present")->upcredit($votedata["openid"], $reply["awardgive_type"], $reply["awardgive_num"] * $paylog["fee"], "silence_vote");
    goto VIov5;
    VIov5:
    nn6lG:
    goto VyTtY;
    br4m2:
    if (empty($reply["giftgive_num"])) {
        goto QQq7O;
    }
    goto mhqmc;
    yMS3m:
    if (!(!empty($paylog) && $value["fee"] == $paylog["fee"])) {
        goto ppEGE;
    }
    goto CuOwy;
    tHEn0:
    $votedata = pdo_fetch("SELECT openid FROM " . tablename($this->tablevoteuser) . " WHERE id = :id ", array(":id" => $value["tid"]));
    goto XSof3;
    vY1sG:
    $setvotesql = "update " . tablename($this->tablevoteuser) . " set votenum=votenum+" . $value["giftvote"] . ",giftcount=giftcount+" . $value["fee"] . "  where id = " . $value["tid"];
    goto Yl1IM;
    q0Al_:
    $paylog = pdo_get("core_paylog", array("tid" => $value["ptid"], "status" => 1), array("fee"));
    goto yMS3m;
    RmcSb:
    QQq7O:
    goto i1Cxt;
    CuOwy:
    $reupvote = pdo_update($this->tablegift, array("ispay" => "1", "isdeal" => "1"), array("ptid" => $value["ptid"]));
    goto hsQ3y;
    hsQ3y:
    $value["fee"] = sprintf("%.2f", $value["fee"]);
    goto vY1sG;
    XaBO7:
    ppEGE:
    goto pnCSx;
    i1Cxt:
    if (empty($reply["awardgive_num"])) {
        goto nn6lG;
    }
    goto tHEn0;
    g7nGR:
}
goto YYME3;
Y3UlM:
$uniacid = intval($_W["uniacid"]);
goto PgI2T;
yxJ3c:
message("完成" . $verifynum . "个校验");