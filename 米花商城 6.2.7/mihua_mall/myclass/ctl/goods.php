<?php
 namespace myclass\ctl; class goods { public function composeGoodsName($goods_list) { $goods_name = getSomeFromArr($goods_list, "\x74\151\164\x6c\x65"); return implode("\x2c", $goods_name); } }