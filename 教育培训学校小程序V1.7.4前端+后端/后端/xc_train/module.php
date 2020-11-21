<?php
 defined('IN_IA') or exit('Access Denied'); class Xc_trainModule extends WeModule { public function welcomeDisplay() { header('location: ' . $this->createWebUrl('webhome')); } } ?>