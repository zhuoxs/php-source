<?php

goto UsYCj;
UFb5_:
checklogin();
goto sxabm;
y9Njz:
$_W["page"]["title"] = "机器人执行管理";
goto hJ9LR;
UsYCj:
defined("IN_IA") or exit("Access Denied");
goto r3b61;
r3b61:
global $_W, $_GPC;
goto UFb5_;
sxabm:
load()->func("tpl");
goto y9Njz;
hJ9LR:
$this->check_ticket();
goto fwA2g;
fwA2g:
include $this->template("robot_do");