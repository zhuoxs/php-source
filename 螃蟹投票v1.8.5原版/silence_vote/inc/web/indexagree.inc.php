<?php

goto iDGxE;
Tmmt1:
goto SBSqZ;
goto I_2wi;
U5XOh:
AvSJx:
goto SwIxY;
zw6do:
die;
goto aAk9N;
pPUwb:
qFMx4:
goto cGdwz;
Ik3Nt:
message("删除成功.", "referer", "success");
goto NgYxR;
wlJJj:
die;
goto pPUwb;
ZTcWh:
if ($rs != false) {
    goto C6pMf;
}
goto GNmdp;
ZY1p6:
$rs = pdo_update("silence_vote_indexagree", array("status" => 1), array("id" => $_GPC["id"]));
goto ZTcWh;
I_2wi:
mA6M2:
goto Ik3Nt;
y0adm:
if (!($op == "sh")) {
    goto ECCp3;
}
goto ZY1p6;
YuBKQ:
if (!($op == "del")) {
    goto AvSJx;
}
goto kE7Od;
ps8f_:
SBSqZ:
goto U5XOh;
XPafW:
die;
goto Tmmt1;
ScsIE:
die;
goto Hpbq0;
rNfig:
message("审核成功.", "referer", "success");
goto wlJJj;
NgYxR:
die;
goto ps8f_;
aAk9N:
goto kpIlV;
goto HucsM;
xxM4G:
$op = $_GPC["op"];
goto y0adm;
iLtvs:
message("查看评论失败.", "referer", "error");
goto zw6do;
tpJpP:
kpIlV:
goto wgCbO;
iDGxE:
defined("IN_IA") or exit("Access Denied");
goto TAQ3I;
cGdwz:
ECCp3:
goto YuBKQ;
HucsM:
J92sO:
goto hYDOm;
kE7Od:
$rs = pdo_delete("silence_vote_indexagree", array("id" => $_GPC["id"]));
goto f__uX;
VEV8C:
C6pMf:
goto rNfig;
f__uX:
if ($rs != false) {
    goto mA6M2;
}
goto QWTqT;
Hpbq0:
goto qFMx4;
goto VEV8C;
GNmdp:
message("审核失败.", "referer", "error");
goto ScsIE;
TAQ3I:
global $_W, $_GPC;
goto xxM4G;
QWTqT:
message("删除失败.", "referer", "error");
goto XPafW;
SwIxY:
if ($_GPC["hid"] != '') {
    goto J92sO;
}
goto iLtvs;
hYDOm:
$list = pdo_fetchall("SELECT * FROM" . tablename("silence_vote_indexagree") . "WHERE uniacid=:uniacid AND hid=:hid", array(":uniacid" => $_W["uniacid"], ":hid" => $_GPC["hid"]));
goto tpJpP;
wgCbO:
include $this->template("indexagree");