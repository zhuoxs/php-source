<?php

goto DGZAp;
otCcE:
UbYmt:
goto vd81n;
RXj6a:
if (!($op == "del")) {
    goto deUK7;
}
goto CCC9e;
CCC9e:
$rs = pdo_delete("silence_vote_voteagree", array("id" => $_GPC["id"]));
goto NKFMY;
h4TWZ:
message("审核成功.", "referer", "success");
goto W8PVi;
r1nyL:
$op = $_GPC["op"];
goto K7kCV;
XduXn:
message("查看评论失败.", "referer", "error");
goto lfmbl;
st4An:
ZK7SU:
goto h4TWZ;
tlcI3:
ZnoYL:
goto ZBaKj;
J742p:
die;
goto otCcE;
OjT_X:
message("审核失败.", "referer", "error");
goto yCrM1;
L1T_u:
iTdVG:
goto BuB_S;
BNigR:
message("删除失败.", "referer", "error");
goto q39MD;
ZBaKj:
$list = pdo_fetchall("SELECT * FROM" . tablename("silence_vote_voteagree") . "WHERE uniacid=:uniacid AND hid=:hid", array(":uniacid" => $_W["uniacid"], ":hid" => $_GPC["hid"]));
goto L1T_u;
xoeEn:
goto iTdVG;
goto tlcI3;
K7kCV:
if (!($op == "sh")) {
    goto GlNuh;
}
goto Erm84;
pg2RF:
e9KBT:
goto IfSZD;
W8PVi:
die;
goto NYn1R;
Erm84:
$rs = pdo_update("silence_vote_voteagree", array("status" => 1), array("id" => $_GPC["id"]));
goto MjZS7;
MjZS7:
if ($rs != false) {
    goto ZK7SU;
}
goto OjT_X;
iSSXD:
global $_W, $_GPC;
goto r1nyL;
qUJYz:
if ($_GPC["hid"] != '') {
    goto ZnoYL;
}
goto XduXn;
IfSZD:
message("删除成功.", "referer", "success");
goto J742p;
DGZAp:
defined("IN_IA") or exit("Access Denied");
goto iSSXD;
q39MD:
die;
goto ma4W5;
qm17O:
goto QsCYE;
goto st4An;
xvct0:
GlNuh:
goto RXj6a;
NKFMY:
if ($rs != false) {
    goto e9KBT;
}
goto BNigR;
NYn1R:
QsCYE:
goto xvct0;
yCrM1:
die;
goto qm17O;
ma4W5:
goto UbYmt;
goto pg2RF;
vd81n:
deUK7:
goto qUJYz;
lfmbl:
die;
goto xoeEn;
BuB_S:
include $this->template("voteagree");