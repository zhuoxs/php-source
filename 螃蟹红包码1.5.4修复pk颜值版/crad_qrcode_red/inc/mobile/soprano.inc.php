<?php
goto GIZTa;
LvboS:
$sopranop = pdo_fetch("SELECT bg_volume,music_open,music,audio_volume FROM " . tablename("crad_qrcode_red_soprano") . " WHERE id = :id", array(":id" => $id));
goto vSLgC;
XDCb1:
error_reporting(0);
goto aQkYA;
DhYjV:
$id = intval($_GPC["id"]);
goto JAXx8;
aQkYA:
$uniacid = $_W["uniacid"];
goto DhYjV;
JmrwB:
global $_GPC, $_W;
goto XDCb1;
JAXx8:
$token = trim($_GPC["token"]);
goto LvboS;
GIZTa:
defined("IN_IA") or exit("Access Denied");
goto JmrwB;
vSLgC:
include $this->template("soprano");