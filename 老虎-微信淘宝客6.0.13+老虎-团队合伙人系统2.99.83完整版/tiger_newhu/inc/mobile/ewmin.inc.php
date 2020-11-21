<?php
  global $_W, $_GPC;
       $url=urldecode($_GPC['url']);
       return 'http://pan.baidu.com/share/qrcode?w=150&h=150&url='.$url;
        //
       //$this->ewm($url);
?>