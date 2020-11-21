<?php
 global $_W, $_GPC;
       $url=urldecode($_GPC['link']);
       $cfg = $this->module['config'];
       include $this->template ('openlink');
?>