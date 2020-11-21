<?php
global $_W,$_GPC;
$prizesum = $_GPC['quantity'];
$miss_num = $_GPC['miss_num'];
pdo_update('n1ce_mission_prize',array('prizesum'=>$prizesum,'miss_num'=>$miss_num),array('id'=>$_GPC['id']));
message(error(0, '修改成功'), referer(), 'ajax');