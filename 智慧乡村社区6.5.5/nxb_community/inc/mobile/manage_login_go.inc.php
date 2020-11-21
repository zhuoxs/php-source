<?php





global $_W, $_GPC;
include 'common.php';
$base=$this->get_base();
$title=$base['title'];
$_SESSION['webtoken'] = 'admin';
header('Location: '.$this->createMobileUrl('manage'));
?>