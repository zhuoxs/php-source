<?php

goto g3OnE;
gJtaY:
die;
goto cuZkf;
kXTNk:
goto iZEyc;
goto wPGit;
hl6mM:
z5pHY:
goto C4Gad;
iclVq:
$rs = pdo_update("silence_vote_voteagree", array("status" => 1), array("id" => $_GPC["id"]));
goto twVan;
rM6wE:
global $_W, $_GPC;
goto S_r4T;
LtPcD:
if (!($op == "del")) {
    goto REJc7;
}
goto ILbpU;
mSO3X:
TTD5t:
goto llvaE;
HADQ1:
iZEyc:
goto ELbHg;
ZhnWc:
if (!($_GPC["id"] != '')) {
    goto F8UBD;
}
goto iclVq;
PYOHY:
if (strlen($content) > 25) {
    goto TTD5t;
}
goto e4v3c;
oO4QN:
message("审核成功.", "referer", "success");
goto j3c26;
NJb5n:
$content = htmlspecialchars($_GPC["content"]);
goto irJve;
lNXrp:
qZWt7:
goto kQhji;
QXTq3:
if ($rs != false) {
    goto h1_PK;
}
goto KNH26;
wPGit:
h1_PK:
goto u919G;
g3OnE:
defined("IN_IA") or exit("Access Denied");
goto rM6wE;
Hymi_:
GJvj1:
goto zqFdG;
FSoqP:
if (!($op == "sel")) {
    goto qkWPF;
}
goto XuEKj;
l625n:
goto mn7KM;
goto Sne4Q;
zqFdG:
goto uGxUz;
goto xMkm1;
LPnAC:
F8UBD:
goto z5ekm;
wfsk0:
DSFma:
goto LtPcD;
sRu_j:
qkWPF:
goto w5Wrz;
zzpJT:
die;
goto HADQ1;
ILbpU:
if (!($_GPC["id"] != '')) {
    goto uC0y8;
}
goto s6TpH;
twVan:
if ($rs != false) {
    goto mMEP7;
}
goto A9Xa2;
d7YC5:
message("查询出错.", "referer", "error");
goto gJtaY;
M2iay:
die;
goto kXTNk;
TwamP:
if (!($op == "add")) {
    goto DSFma;
}
goto XsB_Z;
KNH26:
message("添加失败.", "referer", "error");
goto M2iay;
irJve:
if (empty($content)) {
    goto grjon;
}
goto PYOHY;
Rm3gY:
die;
goto bl3UX;
GrFI_:
K70FH:
goto sRu_j;
bl3UX:
goto QqJVh;
goto hl6mM;
e4v3c:
$rs = pdo_insert("silence_vote_voteagree", array("uniacid" => $_W["uniacid"], "uid" => $_GPC["uid"], "hid" => $_GPC["hid"], "touxiang" => $_GPC["touxiang"], "nick" => $_GPC["nick"], "noid" => $_GPC["noid"], "username" => $_GPC["username"], "resume" => $_GPC["resume"], "nickname" => $nickname, "status" => 0, "content" => $content, "createtime" => time()));
goto QXTq3;
H5sOD:
QqJVh:
goto YJ8Y5;
XsB_Z:
$nickname = $_GPC["nickname"] == '' ? "匿名(用户)" : $_GPC["nickname"];
goto NJb5n;
cuZkf:
goto K70FH;
goto lNXrp;
YJ8Y5:
uC0y8:
goto hynop;
zbaxJ:
$voteinfo = pdo_fetch("SELECT * FROM" . tablename("silence_vote_voteuser") . "WHERE id=:id", array(":id" => $_GPC["id"]));
goto GrFI_;
xMkm1:
grjon:
goto KTmwr;
Y5gp7:
if (!($op == "sh")) {
    goto Jss0P;
}
goto ZhnWc;
A9Xa2:
message("审核失败.", "referer", "error");
goto jafNn;
XuEKj:
if ($_GPC["id"] != '') {
    goto qZWt7;
}
goto d7YC5;
hynop:
REJc7:
goto FSoqP;
s6TpH:
$rs = pdo_delete("silence_vote_voteagree", array(":id" => $_GPC));
goto JvSzi;
kQhji:
$list = pdo_fetchall("SELECT * FROM" . tablename("silence_vote_voteagree") . "WHERE uid=:uid", array(":uid" => $_GPC["id"]));
goto zbaxJ;
ApZ71:
mn7KM:
goto LPnAC;
Sne4Q:
mMEP7:
goto oO4QN;
llvaE:
message("请填写小于25个字符.", "referer", "error");
goto Cqb4l;
S_r4T:
$op = $_GPC["op"];
goto Y5gp7;
z5ekm:
Jss0P:
goto TwamP;
C4Gad:
message("删除成功.", "referer", "success");
goto L1Mhx;
Zz7vj:
die;
goto YPOIk;
u919G:
message("添加成功.", "referer", "success");
goto zzpJT;
L1Mhx:
die;
goto H5sOD;
KTmwr:
message("请填写评论内容.", "referer", "error");
goto Zz7vj;
Cqb4l:
die;
goto Hymi_;
j3c26:
die;
goto ApZ71;
z5Opv:
message("删除失败.", "referer", "error");
goto Rm3gY;
jafNn:
die;
goto l625n;
YPOIk:
uGxUz:
goto wfsk0;
ELbHg:
goto GJvj1;
goto mSO3X;
JvSzi:
if ($rs != false) {
    goto z5pHY;
}
goto z5Opv;
w5Wrz:
include $this->template("voteagree_sel");