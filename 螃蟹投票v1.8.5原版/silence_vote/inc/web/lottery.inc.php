<?php

goto VgVXJ;
FwuAJ:
$condition .= " AND CONCAT(`id`,`nickname`,`user_ip`) LIKE '%{$_GPC["keyword"]}%'";
goto s2_gT;
YntFk:
$reply["config"] = @unserialize($reply["config"]);
goto JWecC;
M0pZf:
$pager = pagination($total, $pindex, $psize);
goto MvHO5;
VgVXJ:
defined("IN_IA") or exit("Access Denied");
goto j680O;
EIfGV:
if (empty($_GPC["keyword"])) {
    goto KRSGR;
}
goto FwuAJ;
ipj0q:
$list = pdo_fetchall("SELECT * FROM " . tablename($this->tableredpack) . " WHERE uniacid = " . $uniacid . " AND rid=" . $rid . "   {$condition} ORDER BY id DESC LIMIT " . ($pindex - 1) * $psize . "," . $psize);
goto sf3xG;
eQ2gj:
$pindex = max(1, intval($_GPC["page"]));
goto olVkI;
ke4b5:
$condition = '';
goto stF6g;
j680O:
global $_W, $_GPC;
goto xnzUf;
stF6g:
$uniacid = $_W["uniacid"];
goto EIfGV;
s2_gT:
KRSGR:
goto ipj0q;
MvHO5:
$redpacktotal = pdo_fetchcolumn("SELECT count(total_amount) FROM " . tablename($this->tableredpack) . " WHERE uniacid = " . $uniacid . " AND result_code='SUCCESS' AND rid=" . $rid . "    {$condition}");
goto O3NM3;
xnzUf:
$rid = $_GPC["rid"];
goto eQ2gj;
olVkI:
$psize = 20;
goto ke4b5;
sf3xG:
$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->tableredpack) . " WHERE uniacid = " . $uniacid . " AND rid=" . $rid . "    {$condition}");
goto M0pZf;
O3NM3:
$reply = pdo_fetch("SELECT * FROM " . tablename($this->tablereply) . " WHERE rid = :rid ORDER BY `id` DESC", array(":rid" => $_GPC["rid"]));
goto YntFk;
JWecC:
include $this->template("lottery");